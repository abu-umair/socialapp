<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\User;
use App\Otpcustom;
use Seshac\Otp\Otp;
use Illuminate\Support\Str;
use Mail;
use App\Mail\ForgotToken;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response(['message'=> $response]);

    }


    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response(['error'=> $response], 422);

    }

    public function postforgot(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email|exists:users',
        ]);

        $user = User::with([
            'token'
          ])->whereEmail($request->email)->first();
        if ($user->isVerified != true) {
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Email belum aktif',
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
                    Mail::to($newuser)->send(
                      new ForgotToken($newuser) //variable $user di passing ke ForgotTOken.php
                    );

                    return response([
                        'status' => 'success',
                        'message' => 'Create OTP',
                        'data' => $otp
                    ], 200);
                }
        }
        
        // return redirect('verifytoken')->with('success','Silakan cek email anda.');
        
    }

}