<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $name = "Jesus Erwin Suarez"; 
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    { 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.user-registered')->subject('Thanks for signing up!');
    }
}
