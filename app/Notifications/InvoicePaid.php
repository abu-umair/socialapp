<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\CustomDbChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    use Queueable;
    private $enrollmentData;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($enrollmentData)
    {
        $this->enrollmentData = $enrollmentData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['mail','database'];
        // return ['database'];
        return [CustomDbChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line($this->enrollmentData['body'])
                    ->action($this->enrollmentData['enrollmentText'], $this->enrollmentData['url'])
                    ->line($this->enrollmentData['thankyou']);
                    // ->line('The introduction to the notification.')
                    // ->action('Notification Action', url('/'))
                    // ->line('Thank you for using our application!');
    }

    // kirim notifications table
    public function toDatabase($notifiable)
    {
        return [
            'description' => $this->enrollmentData['description'],
            'from'        => $this->enrollmentData['from'],
            'merchants_id' => $this->enrollmentData['merchants_id'], //<-- send the id here
            
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
