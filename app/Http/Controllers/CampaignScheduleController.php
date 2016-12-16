<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CampaignSchedule; 
use Carbon\Carbon;
use App\Campaign;
use Mail;  
use App\Mail\OrderShipped;
use App\Mail\CampaignSendMail; 
use Log; 
use App\Helper; 
use App\Activity; 
use App\User; 
use App\CampaignList;
use App\Contact; 



class CampaignScheduleController extends Controller
{  
   
    public function send()
    {    
         
    	//  get all campaign that on time and also exceeding the time already
        $campaignScheduleReachDeadline = CampaignSchedule::getReachDeadline(); 
 
            // get campaign template
            foreach ($campaignScheduleReachDeadline as $campaign) {     
     
                if(CampaignList::getTotalCampaignList($campaign->campaign_id) > 0) {
  
                    // send email now to the contacts the belong to the lists of the campaign
                    $this->sendEmailToContacts($campaign);   

                    // update campaign now with next schedule if repeat and batch send, so that we will know how many times it sent
                    $this->supdateNextScheduleAndUpdateBatch($campaign); 
     
                    // break; 
                } else {
                    print "<br>\n No list found in the campaign";
                } 
                $this->pauseInHalfOfSeconds();
            }
    }  

    public function directSend($campaign_id) 
    {
        // get campaign content
        $campaignScheduleReachDeadline = CampaignSchedule::getScpecificCampaignByCampaignId($campaign_id); 
      
        // get contact of the specific campaign
           foreach ($campaignScheduleReachDeadline as $campaign) {     

                // print "\n direct send " . $campaign->id . " campaign title " . $campaign->schedule_send . ' campaign id ' . $campaign->campaign_id;        
                
                if(CampaignList::getTotalCampaignList($campaign->campaign_id) > 0) {
  
                    // send email now to the contacts the belong to the lists of the campaign
                    $this->sendEmailToContacts($campaign);   

                    // update campaign now with next schedule if repeat and batch send, so that we will know how many times it sent
                    $this->supdateNextScheduleAndUpdateBatch($campaign); 
     
                    // break; 
                } else {
                    print "<br>\n No list found in the campaign";
                } 
 
                $this->pauseInHalfOfSeconds();
            } 
        // update 
    }

    public function sendAutoResponseToOneReceiver($campaign_id, $email, $contact_id=null) {
 
        if(empty($contact_id))  {
            return $this->sendOneRecipeint($campaign_id, $email, ' as auto response.'); 
        } else {    
            return $this->sendOneRecipentContact($campaign_id, $contact_id, ' as auto responder');
        }
    }
    
    public function sendOneRecipeint($campaign_id, $email, $action=null) 
    { 
        $toMail = '';
        $contact = ['contact'=>[]]; 
        // get campaign content
        $campaignScheduleReachDeadline = CampaignSchedule::getScpecificCampaignByCampaignIdForTest($campaign_id); 
          
            // get contact of the specific campaign
           foreach ($campaignScheduleReachDeadline as $campaign) {      
               $campaign = (array) $campaign;   
              
                if(!empty($email)) {
                    $toMail = $email;
                } else {
                    $toMail = $campaign['sender_email'];
                }
                // print "email " .$toMail;
               // exit;
                 if(Mail::to($toMail)->queue(new CampaignSendMail($contact, $campaign))) { 

                    Activity::create(['account_id'=>$campaign['account_id'], 'table_name'=>'campaigns','table_id'=>$campaign['campaign_id'], 'action'=>'Email test successfully sent to ' . $campaign['sender_email'] . ' campaign status is ' . $campaign['repeat'] .  $action ]);  
                    return true; 
                } else {
                    Activity::create(['account_id'=>$campaign['account_id'], 'table_name'=>'campaigns','table_id'=>$campaign['campaign_id'], 'action'=>'Email test failed sending to ' . $campaign['sender_email'] . ' campaign status is ' . $campaign['repeat'] .   $action ]);   
                    return false; 
                }  
                break;
            } 
        // update 
    }  
    public function testSend($campaign_id, $email) 
    { 
        $toMail = '';
        $contact = ['contact'=>[]]; 
        // get campaign content
        $campaignScheduleReachDeadline = CampaignSchedule::getScpecificCampaignByCampaignIdForTest($campaign_id); 
         
        // $campaign = (array) $campaign; 

            // dd(    $campaignScheduleReachDeadline );

            // dd($campaignScheduleReachDeadline); 
            // get contact of the specific campaign
           foreach ($campaignScheduleReachDeadline as $campaign) {      
               $campaign = (array) $campaign;   
              
                if(!empty($email)) {
                    $toMail = $email;
                } else {
                    $toMail = $campaign['sender_email'];
                }
 // print "email " .$toMail;
               // exit;
                 if(Mail::to($toMail)->queue(new CampaignSendMail($contact, $campaign))) { 

                    Activity::create(['account_id'=>$campaign['account_id'], 'table_name'=>'campaigns','table_id'=>$campaign['campaign_id'], 'action'=>'Email test successfully sent to ' . $campaign['sender_email'] . ' campaign status is ' . $campaign['repeat'] ]);  
                    return true; 
                } else {
                    Activity::create(['account_id'=>$campaign['account_id'], 'table_name'=>'campaigns','table_id'=>$campaign['campaign_id'], 'action'=>'Email test failed sending to ' . $campaign['sender_email'] . ' campaign status is ' . $campaign['repeat'] ]);   
                    return false; 
                }  
                break;
            } 
        // update 
    }
    
    public function sendOneRecipentContact($campaign_id, $contact_id, $action= null) 
    { 
        // get campaing details 
        $campaign = Campaign::where('id', $campaign_id)->first()->toArray(); 

        // get contact details 
        $contact = Contact::where('id', $contact_id)->first()->toArray();   
        

        // print "<pre>";
        // print "test";
        // print_r(  $contact );
        // exit; 

        // $contact['contacts']['first_name']        =  $contact1['first_name']; 
        // $contact['contacts']['last_name']         =  $contact1['last_name']; 
        // $contact['contacts']['email']             =  $contact1['email']; 
        // $contact['contacts']['location']          =  $contact1['location']; 
        // $contact['contacts']['phone_number']      =  $contact1['phone_number']; 
        // $contact['contacts']['telephone_number']  =  $contact1['telephone_number']; 
 
        if(Mail::to($contact['email'])->queue(new CampaignSendMail($contact, $campaign))) {
        
            Activity::create(['account_id'=>$campaign['account_id'], 'table_name'=>'campaigns','table_id'=>$campaign['id'], 'action'=>'Email successfully sent to ' . $contact['email'] . ' ' . $action ]); 
            return true; 

        } else {
             Activity::create(['account_id'=>$campaign['account_id'], 'table_name'=>'campaigns','table_id'=>$campaign['id'], 'action'=>'Email failed sending to ' . $contact['email']  . ' ' . $action  ]);  
             return false; 
        }   
    }
    public function sendEmailToContacts($campaign)
    { 
        $contacts = Campaign::getAllEmailWillRecieveTheCampaign($campaign->campaign_id);  

        $campaign = (array) $campaign;     
        foreach ($contacts['contacts'] as $id => $contact) {  
            if(Mail::to($contact['email'])->queue(new CampaignSendMail($contact, $campaign))) { 
                Activity::create(['account_id'=>$campaign['account_id'], 'table_name'=>'campaigns','table_id'=>$campaign['campaign_id'], 'action'=>'Email successfully sent to ' . $contact['email'] . ' campaign status is ' . $campaign['repeat'] ]);  
            } else {
                 Activity::create(['account_id'=>$campaign['account_id'], 'table_name'=>'campaigns','table_id'=>$campaign['campaign_id'], 'action'=>'Email failed sending to ' . $contact['email'] . ' campaign status is ' . $campaign['repeat'] ]);   
            }  
            $this->pauseInHalfOfSeconds(); 
        }  
    }

    // pause in 1 second in order to send 2 emails per second
    private function pauseInHalfOfSeconds()
    { 
        // send 2 emails per seconds 
        sleep(1);         
    }

    public function supdateNextScheduleAndUpdateBatch($campaign)
    {  
        $campaign = (array) $campaign;      
        // print " repeat ".  $campaign['repeat'];   
        // Update send schedule and send batch
        if($campaign['repeat'] == 'One Time') { 
 
            // update campaign status to finished 
            Campaign::where('id', $campaign['campaign_id'])->update(['status'=>'finished']); 
             
            // update batch to 1
            Campaign::where('id', $campaign['campaign_id'])->increment('batch_send', 1); 

        }
         else if($campaign['repeat'] == 'Daily') {  
 
            $date = Helper::createDateTime($campaign['schedule_send']); 
  
            CampaignSchedule::find($campaign['id'])->update(['schedule_send'=> $date->now()->addDays(1)]);

            // increment batch with 1  
               Campaign::where('id', $campaign['campaign_id'])->increment('batch_send', 1); 
        } else if($campaign['repeat'] == 'Weekly') { 

            // move send schedule to next week 
            $date  = Helper::createDateTime($campaign['schedule_send']);  
            CampaignSchedule::find($campaign['id'])->update(['schedule_send'=> $date->now()->addDays(7)]);

            // increment batch with 1 
             Campaign::where('id', $campaign['campaign_id'])->increment('batch_send', 1); 
        } else if($campaign['repeat'] == 'Monthly') {

            // move send schedule to next week 
            $date  = Helper::createDateTime($campaign['schedule_send']);  
            CampaignSchedule::find($campaign['id'])->update(['schedule_send'=> $date->now()->addMonth(1)]); 

            // increment batch with 1 
            Campaign::where('id', $campaign['campaign_id'])->increment('batch_send', 1);     
        }   
    }

    public function sendEmail() {}
    public function sendSms() {}
    public function sendNotification() {} 
}