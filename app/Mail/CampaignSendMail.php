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
        return $this->from($this->campaign['sender_email'], $this->campaign['sender_name'])->subject($this->campaign['sender_subject'])->view('mail.campaign-send-mail', ['content'=>$this->campaign['content']]);
    }
}
