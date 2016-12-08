<?php
 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue; 

class CampaignSendMail extends Mailable
{
    use Queueable, SerializesModels;


    private $contact = [];
    private $campaign = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact, $campaign)
    { 
        // dd($campaign);
        // exit;
        $this->contact = $contact;
        $this->campaign = $campaign; 
        // exit; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.campaign-send-mail', ['contact'=>$this->contact, 'campaign'=>$this->campaign]);
    }
}
