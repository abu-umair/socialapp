<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use App\Otpcustom;
use Seshac\Otp\Otp;
use Illuminate\Support\Str;
use Mail;
use Twilio\Rest\Client;
use Exception;
use App\Mail\ForgotToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail as FacadesMail;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    // protected function sendResetResponse(Request $request, $response)
    // {
    //     $credentials = $request->only('email', 'password');
    //     $token = JWTAuth::refresh($credentials);
    //     return response()->json([
    //         'message'=> trans($response),
    //         'token' => $token
    //         ]);

    // }

    protected function sendResetResponse(Request $request, $response)
    {
        return response(['message'=> trans($response)]);

    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response(['error'=> trans($response)], 422);
    }

    public function updatereset(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:users',
            'password' => 'required|confirmed',
            'token' => 'required',
            // 'password_confirmation' => 'required|confirmed',
          ]);
          $data = $request->all();

          $user = User::with([
            'token'
          ])->whereEmail($request->email)->first();
        
          if ($user->token->token != $request->token) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Token tidak sama',
                    'data' => $request->token,
                    // 'input' => $request->token
                    
                ], 401);
            }
          } else{
                $userupdate = $user->update([
                  'password'         => Hash::make($request->password),
                ]);
          }
          
          if (!$userupdate) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Update',
                    'data' => $user,
                    
                ], 401);
            }
          } else {
            if(\Request::segment(1) == 'api') {
              

                return response([
                    'status' => 'OK',
                    'message' => 'Berhasil Disimpan User',
                    'data' => $user,
                ], 200);           
            }
            
          }
          
    }

    public function resettoken(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email|exists:users',
        ]);

        $user = User::with([
            'token'
          ])->whereEmail($request->email)->first();
        if ($user->isVerified != false) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'verified user',
                    'message' => 'isVerified True',
                    'data' => $user
                ], 401);
            }
            
        } else {
                $identifier = Str::random(12);
                $AllOtp = Otpcustom::where('users_id',$user->id)->get();
                
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
                        'users_id'         => $user->id,
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
                            'users_id'         => $user->id,
                        ]);
                    }
                    
                }
                if(\Request::segment(1) == 'api') {
                    //kirim email ke user tokennya
                    $newuser = User::with([
                        'token'
                      ])->whereEmail($request->email)->first();
                    
                    $receiverNumber = $newuser->phone;
                    $message = 'Hi '.$newuser->name.', your AdFood verification code for registration is '.$otp->token.'. Use this OTP code to validate your login.';
              
                    try {
              
                        $account_sid = getenv("TWILIO_SID");
                        $auth_token = getenv("TWILIO_TOKEN");
                        $twilio_number = getenv("TWILIO_FROM");
              
                        $client = new Client($account_sid, $auth_token);
                        $client->messages->create($receiverNumber, [
                            'from' => $twilio_number, 
                            'body' => $message]);
              
                        // dd('SMS Sent Successfully.');
              
                        return response([
                          'success' => true,
                          'OTP' => $otp->token,
                          'user' => $newuser->name,
                          'message' => $message,
                        ], 200);

                    } catch (Exception $e) {
                        return response([
                          'success' => false,
                          "Error: ". $e->getMessage()
                        ], 401);
                        
                    }

                }
        }
        
        // return redirect('verifytoken')->with('success','Silakan cek email anda.');
        
    }

}