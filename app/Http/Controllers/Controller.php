<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // public function index()
    // {
    //     return view('pages.admin.firebase');
    // }

    // public function sendNotification()
    // {
    //     $token = "dIOSOLQbTx8:APA91bGqb0l4SbG0EaJBmYLA-t6R4sBS05CLAZLniUtWNQYK5jvxHx-m5cmT6QtMsvf4I8_iydP3xHF0TV5fk1Lz1-16fQk6n7cL8AxrGqzJjuzi9U0pcrn2uMxZbeHxOW8W6OEFnJC-";  
    //     $from = "AAAAF87ubws:APA91bEb42i_EUlOjsYyShDqZElY2pmqD1gbm4CigPKYfrnK9FPu5irDtDRtp0pyeIdg4fWpYCzXMCTlMoJwQkYmgGfeqt6wANRzSm1CZAGT33oa4hWk3IEIVtKzVuviBsLDwTP-EJ_B";
    //     $msg = array
    //           (
    //             'body'  => "Demo 2",
    //             'title' => "Hi, From Raj",
    //             'receiver' => 'erw',
    //             'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
    //             'sound' => 'mySound'/*Default sound*/
    //           );

    //     $fields = array
    //             (
    //                 'to'        => $token,
    //                 'notification'  => $msg
    //             );

    //     $headers = array
    //             (
    //                 'Authorization: key=' . $from,
    //                 'Content-Type: application/json'
    //             );
    //     //#Send Reponse To FireBase Server 
    //     $ch = curl_init();
    //     curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    //     curl_setopt( $ch,CURLOPT_POST, true );
    //     curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    //     curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    //     curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    //     curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    //     $result = curl_exec($ch );
    //     dd($result);
    //     curl_close( $ch );
    // }
}
