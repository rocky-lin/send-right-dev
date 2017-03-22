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
use App\AutoResponseDetails;


class CampaignScheduleController extends Controller
{  
    protected function printError($error) {
        switch ($error) {
            case 1:
                    print "No campaign found, please check."; 
                break; 
            default: 
                break;
        }
    }
    public function send()
    {     
        print "\n start process sending.."; 
        //  get all campaign that on time and also exceeding the time already
        $campaignScheduleReachDeadline = CampaignSchedule::getReachDeadline();  

        print "\ntotal reach schedule " . count($campaignScheduleReachDeadline); 

        if(count($campaignScheduleReachDeadline) > 0)  {  
            // get campaign template
            foreach ($campaignScheduleReachDeadline as $index => $campaign) {     
     
                  print "\n  " . $index . ".) campaign title  "  . $campaign->title;  

                if(CampaignList::getTotalCampaignList($campaign->campaign_id) > 0) {
                    print "\n prepare process sending.."; 
         
                    // send email now to the contacts the belong to the lists of the campaign
                    $error = $this->sendEmailToContacts($campaign);   

                    // print error
                    $this->printError($error);

                    // update campaign now with next schedule if repeat and batch send, so that we will know how many times it sent
                    $this->supdateNextScheduleAndUpdateBatch($campaign);  
                    // break; 
                } else {
                    print "<br>\n No list found in the campaign";
                } 
                $this->pauseInHalfOfSeconds();
            }  
        } else {
            print "\n no reach schedule found for campaign send";
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

    public function sendAutoResponseToOneReceiver($campaign_id, $email, $contact_id=null, $auto_response_detail_id) {
 
        if(empty($contact_id))  {
            print "send one recepeint";
            return $this->sendOneRecipeint($campaign_id, $email, ' as auto response.'); 
        } else {
            print "send one recepient contact";
            return $this->sendOneRecipentContact($campaign_id, $contact_id, ' as auto responder', $auto_response_detail_id);
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
    
    public function sendOneRecipentContact($campaign_id, $contact_id, $action= null, $auto_response_detail_id)
    { 
        // get campaing details 
        $campaign = Campaign::where('id', $campaign_id)->first()->toArray(); 

        // get contact details 

        $isContactExist = $contact = Contact::where('id', $contact_id)->get();


        /**
         * If contact is found then execute sending auto response email
         */
        if(count($isContactExist) > 0) {
            $contact = $isContactExist->first()->toArray();
            print "\n  $contact_id contact info";
            print "<pre>";
            print_r($contact );
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
        /**
         * set finished queue contact
         */
        else {
            print "set status to finished because not found ";
            $status = AutoResponseDetails::where('id', $auto_response_detail_id)->update(['status'=>'finished']);
            Activity::create(['account_id'=>$campaign['account_id'], 'table_name'=>'campaigns','table_id'=>$campaign['id'], 'action'=>'Auto response not sent because contact not found, we just set auto response queue to finished!']
            );
        }
        return $status;
    }



    public function sendEmailToContacts($campaign)
    {  
        if(!empty($campaign)) { 
            $contacts = Campaign::getAllEmailWillRecieveTheCampaign($campaign->campaign_id);   
            $campaign = (array) $campaign;     
 
            if($contacts) {  
                foreach ($contacts['contacts'] as $id => $contact) {  
                    if(Mail::to($contact['email'])->queue(new CampaignSendMail($contact, $campaign))) { 
                        Activity::create(['account_id'=>$campaign['account_id'], 'table_name'=>'campaigns','table_id'=>$campaign['campaign_id'], 'action'=>'Email successfully sent to ' . $contact['email'] . ' campaign status is ' . $campaign['repeat'] ]);  
 
                        print "\n<br> sent campaign to " . $contact['email'] . ' campaign title ' . $campaign['title']; 

                    } else {

                         Activity::create(['account_id'=>$campaign['account_id'], 'table_name'=>'campaigns','table_id'=>$campaign['campaign_id'], 'action'=>'Email failed sending to ' . $contact['email'] . ' campaign status is ' . $campaign['repeat'] ]);   
                        print "\n<br> failed campaign to " . $contact['email'] . ' campaign title ' . $campaign['title']; 

                    }  

                    $this->pauseInHalfOfSeconds(); 
                    
                }  
            } else {
                print "\n no contact for campaign found"; 
                print "<script> alert('No active contact found for this campaign'); </script>";
            }
        } else {
            print "\n no campaign found"; 
            return 1; // no campaign found
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
