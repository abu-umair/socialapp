<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotToken extends Mailable
{
    use Queueable, SerializesModels;

    public $data; //utk menapung data yang passing dr ctrl lain, variable $data bs dipake di view

    public function __construct($data)
    {
        $this->data = $data; //variable send mail dari forgotpasswordcontroller.php
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() //utk mengirim
    {
        return $this
        ->from('hi@adfood.com', 'Adfood')
        ->subject('Reset Password Notification') //bisa dinamis memakai variable apa
        ->view('auth.email.forgot-template');
    }
}
