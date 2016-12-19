<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AutoResponseDetails;
use App\Helper; 
use App\CampaignSchedule; 
use App\Http\Controllers\CampaignScheduleController; 
use App\Campaign;

class AutoResponseDetailsController extends Controller
{
    /**
     * @return string
     */
    public function startResponse() {  
         
        // set sending to fals
        $isSendNow = false;

        // get all auto responders details, all active status only
        $autoResponseDetails = AutoResponseDetails::getActiveAutoResponsesDetails();  

        // init campaign schedule controller
        $campaignScheduleController = new CampaignScheduleController(); 
        
        foreach($autoResponseDetails as $autoResponseDetail) {  
            
            // get campaign auto response schedule
            $campaignSchedule = $autoResponseDetail->autoResponse->campaign->campaignSchedule()->first();  

            // get specific campaign data
            // will be used in email sending campaign
            $campaign = Campaign::find($autoResponseDetail->autoResponse->campaign_id); 
    
            // display some needed data
            print "\n<br>schedule auto response  repeat as "  . $campaignSchedule->repeat;
            print "\n<br>schedule auto response  repeat as days "  . $campaignSchedule->days;
            print "\n<br>schedule auto response  repeat as hours "  . $campaignSchedule->hours;
            print "\n<br>schedule auto response repeat as mins "  . $campaignSchedule->mins;  
            print "\n<br>receiver email " . $autoResponseDetail->email; 
            print "\n<br>created at email " . $autoResponseDetail->created_at;  
            print "\n<br>campaign id " . $autoResponseDetail->autoResponse->campaign_id;  
             
            // calculate total passed hour and min between auto response details created and time now
            $dayHourInteraval =  Helper::getSpecificDayHowMinInDateTime($autoResponseDetail->created_at);  
                
            // if campaign type is immediate response, direct send response no need for validation
            if($campaign->type == 'immediate response') {
                $isSendNow = true; 
                 print "\n <br> no need to validate day and hour interval because the auto response campaign is " . $campaign->type;
            } 
            // if campaign type is schedule response, need day and hour validation
            else if($campaign->type == 'schedule response') {  
                if(CampaignSchedule::isAutoResponseReachDeadlineSend(['days'=>$campaignSchedule->days, 'hours'=>$campaignSchedule->hours], $dayHourInteraval)) {   
                    print "\n <br>  need day and hour validation because campaign auto response is in" . $campaign->type;
                    $isSendNow = true; 
                } else {
                    $isSendNow = false; 
                    print "\n<bR>not time to send";  
                }
            } 
            // else doing nothing, there should be something wrong
            else { 
                $isSendNow = false; 
                print "\n<bR>something wrong!";  
            }
 
            // start sending auto response now
            if($isSendNow == true) {
                if($campaignScheduleController->sendAutoResponseToOneReceiver($autoResponseDetail->autoResponse->campaign_id, $autoResponseDetail->email, $autoResponseDetail->table_id)) {
                    print "\n<br> email sent to responder"; 
                }   else {
                    print "\n<br> sending failed" ;
                }      

                // update status to finished
                if(AutoResponseDetails::find($autoResponseDetail->id)->update(['status'=>'finished'])  )  {
                    print "\n<br> auto responder status updated finished"; 
                } 
            }
        }  
    }
}