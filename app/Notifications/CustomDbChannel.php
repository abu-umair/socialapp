<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

// kirim notifications table
class CustomDbChannel 
{
    public function send($notifiable, Notification $notification)
  {
    $data = $notification->toDatabase($notifiable);

    return $notifiable->routeNotificationFor('database')->create([
        'id' => $notification->id,

        //customize here
        //'merchants_id' => $data['merchants_id'], //<-- comes from toDatabase() Method below
        // 'user_id'=> \Auth::user()->id,

        'type' => get_class($notification),
        'data' => $data,
        'read_at' => null,
    ]);
  }
}
