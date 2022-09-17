<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\User;
use App\Users;
use App\Otpcustom;
use Seshac\Otp\Otp;
use Illuminate\Support\Str;
use Twilio\Rest\Client;
use Exception;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{

    /**
 * Log in the user.
 *
 * @bodyParam   email    string  required    The email of the  user.      Example: testuser@example.com
 * @bodyParam   password    string  required    The password of the  user.   Example: secret
 *
 * @response {
 *  "access_token": "eyJ0eXA...",
 *  "token_type": "Bearer",
 * }
 */

    public function login(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'email_phone' => 'required|string',
            'password' => 'required|string',
        ]);
        $login_type = filter_var( $request->email_phone, FILTER_VALIDATE_EMAIL ) ? 'email' : 'phone';
        $credentials = [$login_type => $request->email_phone, 'password'=>$request->password];
        // $credentials = $request->only('email','', 'password');
        $id = User::with([
            'customer','merchant'
            ])->where('phone', $request->email_phone)
            ->OrWhere('email', $request->email_phone)
            ->get();

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response([
            'data'          => new UserResource($id),
            'token'         => $token,
        ], 200);
        
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                   => 'required|string|max:255',
            'email'                  => 'required|string|email|max:255|unique:users',
            'password'               => 'required|string|min:6|confirmed',
            'isVerified'             => 'string|max:255',
            'phone'                  => 'required|string|unique:users',
            'type_business'          => 'nullable',
            'phone_restaurant'       => 'nullable',
            'roles'                  => 'required|in:USER,MERCHANT',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        User::create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                    'isVerified' => $request->get('isVerified'),
                    'phone' => $request->get('phone'),
                    'roles' => $request->get('roles'),
                    // $request->user == 'partner' ? 'customers_id' => $request->user 
            
        ]);


        $user_relation = User::with([
            'token','merchant','customer'
          ])->whereEmail($request->email)->first();
        
        $token = JWTAuth::fromUser($user_relation);


        $identifier = Str::random(12);
        $AllOtp = Otpcustom::where('users_id',$user_relation->id)->get();

        if ($AllOtp == null) {
            $otp =  Otp::setValidity(3)  // otp validity time in mins
                    ->setLength(6)  // Lenght of the generated otp
                    ->setMaximumOtpsAllowed(100) // Number of times allowed to regenerate otps
                    ->setOnlyDigits(true)  // generated otp contains mixed characters ex:ad2312
                    ->setUseSameToken(false) // if you re-generate OTP, you will get same token
                    ->generate($identifier);
            // $expires = Otp::expiredAt($identifier);
            $updateOtp = Otpcustom::where('token',$otp->token)
                                ->get();
            $updateOtp->update([
                'users_id'         => $user_relation->id,
            ]);
            
        }else{
            foreach ($AllOtp as $post) {
                $post->delete();
            }
            $otp =  Otp::setValidity(3)  // otp validity time in mins
                ->setLength(6)  // Lenght of the generated otp
                ->setMaximumOtpsAllowed(10) // Number of times allowed to regenerate otps
                ->setOnlyDigits(true)  // generated otp contains mixed characters ex:ad2312
                ->setUseSameToken(true) // if you re-generate OTP, you will get same token
                ->generate($identifier);
            // $expires = Otp::expiredAt($identifier);
            $updateOtp = Otpcustom::where('token',$otp->token)
                    ->get();
            foreach ($updateOtp as $postOtp) {
                $postOtp->update([
                    'users_id'         => $user_relation->id,
                ]);
            }
            
        }

        if(\Request::segment(1) == 'api') {
            //kirim email ke user tokennya
            
            $receiverNumber = $user_relation->phone;
            $message = 'Hi '.$user_relation->name.', your AdFood verification code for registration is '.$otp->token.'. Use this OTP code to validate your login.';
      
            try {
      
                $account_sid = getenv("TWILIO_SID");
                $auth_token = getenv("TWILIO_TOKEN");
                $twilio_number = getenv("TWILIO_FROM");
      
                $client = new Client($account_sid, $auth_token);
                $client->messages->create($receiverNumber, [
                    'from' => $twilio_number, 
                    'body' => $message]);
      
                // dd('SMS Sent Successfully.');
                
                if ($user_relation->merchant) {
                    return response([
                        'success'                => true,
                        'id'                     => $user_relation->id,
                        'name'                   => $user_relation->name,
                        'foto'                   => $user_relation->foto,
                        'email'                  => $user_relation->email,
                        'isVerified'             => $user_relation->isVerified,
                        'phone'                  => $user_relation->phone,
                        'type_business'          => $user_relation->merchant->type_business,
                        'phone_restaurant'       => $user_relation->merchant->phone_restaurant,
                        'address'                => $user_relation->merchant->address,
                        'long'                   => $user_relation->merchant->long,
                        'lat'                    => $user_relation->merchant->lat,
                        'roles'                  => $user_relation->roles,
                        'status'                 => $user_relation->status,
                        'OTP'                    => $otp->token,
                        'message'                => $message,
                        'device_token'           => $user_relation->device_token,
                        'token'                  => $token,
                      ], 200);

                } else {
                    return response([
                        'success'       => true,
                        'id'            => $user_relation->id,
                        'name'          => $user_relation->name,
                        'foto'          => $user_relation->foto,
                        'email'         => $user_relation->email,
                        'isVerified'    => $user_relation->isVerified,
                        'phone'         => $user_relation->phone,
                        'address'       => $user_relation->customer->address,
                        'long'          => $user_relation->customer->long,
                        'lat'           => $user_relation->customer->lat,
                        'roles'         => $user_relation->roles,
                        'status'        => $user_relation->status,
                        'OTP'           => $otp->token,
                        'message'       => $message,
                        'device_token'  => $user_relation->device_token,
                        'token'         => $token,
                      ], 200);
                }
                
                

            } catch (Exception $e) {
                return response([
                  'success' => false,
                  "Error: ". $e->getMessage()
                ], 401);
                
            }

        }

        // $customer = Customer::findOrFail($user->id);
        // return response()->json(compact('$user_relation','token'),201);


        // return response()->json([
        //     'id'            => $user_relation->first()->id,
        //     'name'          => $user_relation->first()->name,
        //     'foto'          => $user_relation->first()->foto,
        //     'email'         => $user_relation->first()->email,
        //     'isVerified'    => $user_relation->first()->isVerified,
        //     'phone'         => $user_relation->first()->phone,
        //     'roles'         => $user_relation->first()->roles,
        //     'status'        => $user_relation->first()->status,
        //     'device_token'  => $user_relation->first()->device_token,
        //     'token'         => $token,
        //     ], 201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
        // return response()->json(["user"=> $user->id]);
    }

    public function logout(Request $request ) { 
        // methode "POST", "PARAMS", URL "localhost:8000/api/logout"

        $token = $request->header( 'Authorization' );

        try {
            JWTAuth::parseToken()->invalidate( $token );

            return response()->json( [
                'error'   => false,
                'message' => trans( 'auth.logged_out' )
            ] );
        } catch ( TokenExpiredException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.expired' )

            ], 401 );
        } catch ( TokenInvalidException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.invalid' )
            ], 401 );

        } catch ( JWTException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.missing' )
            ], 500 );
        }
    }
}
