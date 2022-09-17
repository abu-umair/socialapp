<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChatEvent;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat()
    {
        return view('pages.admin.messages.chat');
    }

    public function send(Request $request)
    {
        // return $request->all();
        $a= $request->message;
        $user = User::find(Auth::id());
        event(new ChatEvent($a, $user));
        
    }

    // public function send()
    // {
    //     $message = 'Hello Simple';
    //     $user = User::find(Auth::id());
    //     event(new ChatEvent($message, $user));
        
    // }
}
