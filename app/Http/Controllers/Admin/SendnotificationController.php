<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Content;
use App\Fcmnotification;
use App\User;
use App\Notification;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\ContentRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Alert;
use App\Http\Requests\Admin\SendnotificationRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SendnotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    
    {
        return view('pages.admin.send-notification.index');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function sendNotification(SendnotificationRequest $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = 'AAAAQjO8aPg:APA91bFhUNV4TyqhMIyeN6KnKJvU3GlnvkPV9O_7I8vXHtEA2Qc2bLBj-sNjLYYynvkAF33EbpxUwMQQU7c1MOWoi3-Fsx2KvoGs9sCbG9iUN7RBj--mxyF2TNACvasERZW9LIBpZu-U';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
                "content_available" => true,
                "priority" => "high",
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        // dd($response);

        
        
        try {
            $item = Fcmnotification::create([
                    
                'title'         => $request->title,
                'body'          => $request->body,
                // 'created_at'    => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', \Carbon\Carbon::now())->timezone('Asia/Jakarta'),
                // 'updated_at'    => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', \Carbon\Carbon::now())->timezone('Asia/Jakarta'),
                // 'created_at'    => \Carbon\Carbon::now(),
                // 'updated_at'    => \Carbon\Carbon::now(),
            ]);
            // dd($item);
        } catch (QueryException $e) {
            
            if(\Request::segment(1) == 'api') {
                return response([
                    'status' => 'error',
                    'message' => 'Gagal Disimpan',
                    'data' => $item
                ], 401);
            }
            return back()->with('error', 'Error Create');
        }    
        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'OK',
                'message' => 'Berhasil Disimpan Notification',
                'data' => $item
            ], 200);           
        }
        Alert::success('Send Notification', $item->title.' Successfully Create');        
        // return redirect()->route('historynotification');
        return back();
    }

    public function historynotification()
    {
        $items = Fcmnotification::all();
        // $user= Auth::user()->roles;

        if(\Request::segment(1) == 'api') {
            return response()->json([
                'success' => true,
                'message' => 'List Semua History Notifications',
                'data' => $items
                ], 200);
        }

        return view('pages.admin.send-notification.history', [
            'items' => $items
        ]);
    }
}
