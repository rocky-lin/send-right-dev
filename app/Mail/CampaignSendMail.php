<?php
 
namespace App\Mail;
 
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue; 
use App\Contact; 
use App\Campaign; 

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
        // only do validation when sending real contacts 
        // then if not and just a test send then we will not do this validation and filters 
        if(count($this->contact) > 1) {  
            // set values in each filter
            $contactFilterValues = Contact::setgetFilterValues($this->contact);   
            // loop find and replace 
            $this->campaign['content'] =  Campaign::supplyContactFilteres($contactFilterValues, $this->campaign['content']);
        }  
        
        // set view and other attribute of the email sending
        return $this->from($this->campaign['sender_email'], $this->campaign['sender_name'])->subject($this->campaign['sender_subject'])->view('mail.campaign-send-mail', ['content'=>$this->campaign['content']]);
    }
}
