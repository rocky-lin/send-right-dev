<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class PaymentDeadlineNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }
    public function toSlack() {
            $url = '#';
            return (new SlackMessage)  
                ->success()
                ->from('Send Right Slack Team')
                ->content("Hi Sir Rocky, It's end of the week and payday of Jesus, just a reminder for you from your Send Right Slack Team. Thank you :slightly_smiling_face:")
                 ->attachment(function ($attachment) use ($url) {
                    $attachment->title('EOW Payment', $url)
                               ->fields([ 
                                    'Via' => 'Paypal account to mrjesuserwinsuarez@gmail.com',
                                    'Status' => 'Pending' 
                                ]);
                });
    }
}
