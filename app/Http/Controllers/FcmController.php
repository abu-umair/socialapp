<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class FcmController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('pages.admin.firebase');
    }

    public function sendNotification()
    {
        $token = "ehtJYcKXMPE:APA91bFi-BA6o40OgOHEEnS1ecRZpJEOq23zlR5H23onTchEb4MRctrePkh0JJIp1QBiK5a3NhbDbYf6JUANKhHDLZ7CWOpNfyVMarsrovVqcjcNwUVHia1Ttkqul-PQrCxYEdMINIjA";  
        $from = "AAAAQjO8aPg:APA91bFhUNV4TyqhMIyeN6KnKJvU3GlnvkPV9O_7I8vXHtEA2Qc2bLBj-sNjLYYynvkAF33EbpxUwMQQU7c1MOWoi3-Fsx2KvoGs9sCbG9iUN7RBj--mxyF2TNACvasERZW9LIBpZu-U";
        $msg = array    
              (
                'body'  => "Demo 2",
                'title' => "Hi, From Raj",
                'receiver' => 'erw',
                'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
                'sound' => 'mySound'/*Default sound*/
              );

        $fields = array
                (
                    'to'        => $token,
                    'notification'  => $msg
                );

        $headers = array
                (
                    'Authorization: key=' . $from,
                    'Content-Type: application/json'
                );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        dd($result);
        curl_close( $ch );
    }
}
