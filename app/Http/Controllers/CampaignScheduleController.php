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

class CampaignScheduleController extends Controller
{
 
    public function send()
    {    
        // print '<h1> fix campaign query contact/list even without contact</h1>'; 
        // Mail::to('mrjesuserwinsuarez@gmail.com')->send(new OrderShipped(['id'=>1, 'title'=>'campaign title']));  
        // print "send an email now ";  
        // exit; 
        // print "controller works";
    	//  get all campaign that on time and also exceeding the time already
        $campaignScheduleReachDeadline = CampaignSchedule::getReachDeadline(); 

        // dd($campaignScheduleReachDeadline);

        // print "test";
        // exit; 
            // print "<br> date time now " . Carbon::now(); 
            // dd( $campaignScheduleReachDeadline ); 
            // get campaign template
            foreach ($campaignScheduleReachDeadline as $campaign) {     

                print "\n " . $campaign->id . " campaign title " . $campaign->schedule_send . ' campaign id ' . $campaign->campaign_id;        
                
                if(CampaignList::getTotalCampaignList($campaign->campaign_id) > 0) {

                    // exit;  
                    // print "<pre>";
                    // print_r($contacts); 
                    // print_r($campaign);
                    // print "</pre>";    
                     
                    // send email now to the contacts the belong to the lists of the campaign
                    $this->sendEmailToContacts($campaign);   

                    // update campaign now with next schedule if repeat and batch send, so that we will know how many times it sent
                    $this->supdateNextScheduleAndUpdateBatch($campaign); 
     
                    // break; 
                } else {
                    print "<br>\n No list found in the campaign";
                }

            }
    }  
     
    public function sendEmailToContacts($campaign)
    {

        $contacts = Campaign::getAllEmailWillRecieveTheCampaign($campaign->campaign_id);
         
        // print "<pre>";
        //     print_r($contacts );
        // print "</pre>"; 
        // exit; 
        $campaign = (array) $campaign;  

        // dd($campaign); 
        // exit; 

        // send to contact now
        foreach ($contacts['contacts'] as $id => $contact) { 
            
            // print "current user account " . User::getUserAccount(); 
            // exit; 
             // print " contact email  email = " . $contact['email'] ;
            if(Mail::to($contact['email'])->send(new CampaignSendMail($contact, $campaign))) {
            
                Activity::create(['account_id'=>$campaign['account_id'], 'table_name'=>'campaigns','table_id'=>$campaign['campaign_id'], 'action'=>'Email successfully sent to ' . $contact['email'] . ' campaign status is ' . $campaign['repeat'] ]); 

                // print "sent an email success";
                // Log::info('successfully sent and email to his contact'); 
            } else {
                 Activity::create(['account_id'=>$campaign['account_id'], 'table_name'=>'campaigns','table_id'=>$campaign['campaign_id'], 'action'=>'Email failed sending to ' . $contact['email'] . ' campaign status is ' . $campaign['repeat'] ]); 
                // print "failed send and email";
                 // Log::info('failed sent and email to his contact'); 
                 // Log::emergency("emergency text");
            } 
        }  
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
