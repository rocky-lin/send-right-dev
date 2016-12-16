<?php

namespace App;
use DB; 

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class CampaignSchedule extends Model
{
       protected $table = "campaign_schedules";    

       protected $fillable = ['campaign_id', 'repeat', 'schedule_send', 'batch_send'];  

       protected $hidden = []; 


       public static function createOrUpdateByCampaignId($campaignSchedule) 
       {  
       		if(!self::where('campaign_id', $campaignSchedule['campaign_id'])->update($campaignSchedule)) { 
   				self::create($campaignSchedule);  
       		} 
       } 
  
       // get all the campaign details
       public static function getReachDeadline() 
       {  
         // print "<br> date time now  " .  Carbon::now(); 
    	   $scheduledCampaign = DB::table('campaigns')
          ->join('campaign_schedules', function ($join) {
              $join->on('campaigns.id', '=', 'campaign_schedules.campaign_id')
                 ->where('campaign_schedules.schedule_send', '<=', Carbon::now())
                 ->where('campaigns.status', '=', 'active')
                 ->where('campaigns.type', '=', 'schedule send');
          })
        ->get(); 
       		return $scheduledCampaign; 
       } 

       // get specific campaign info
       public static function getScpecificCampaignByCampaignId($campaign_id)
       {   
         $scheduledCampaign = DB::table('campaigns')
          ->join('campaign_schedules', function ($join) use ($campaign_id)  {
              $join->on('campaigns.id', '=', 'campaign_schedules.campaign_id')
                 ->where('campaigns.status', '=', 'active')
                 ->where('campaigns.type', '=', 'direct send')
                 ->where('campaigns.id', '=', $campaign_id);
          } )
        ->get(); 
          return $scheduledCampaign; 
       } 
        // get specific campaign info
       public static function getScpecificCampaignByCampaignIdForTest($campaign_id)
       {   
         $scheduledCampaign = DB::table('campaigns')
          ->join('campaign_schedules', function ($join) use ($campaign_id)  {
              $join->on('campaigns.id', '=', 'campaign_schedules.campaign_id')
                 // ->where('campaigns.status', '=', 'active')
                 // ->where('campaigns.type', '=', 'direct send')
                 ->where('campaigns.id', '=', $campaign_id);
          } )
        ->get(); 
          return $scheduledCampaign; 
       }

       /**
        * 
        * @var dayHour1 - is the current date time now converted to days and hour only, compared to autoresponse details
        * @var dayHour2 - is the date and hour in array from auto campaign schedule compared.
        * return @var bool - the boolean true or false this mean that the auto response details reach the schedule for sending email to client
        */ 
       public static function isAutoResponseReachDeadlineSend($dayHour1, $dayHour2) 
       {
           // current date time 
            $days1  = $dayHour1['days'];
            $hours1 = $dayHour1['hours'];

            // from campaign auto response
            $days2  = $dayHour2['days'];
            $hours2 = $dayHour2['hours'];

            print "\n<br> auto response info day1, hour1 and  day2 , hour2 is campaign schedule  if(days1 > days2 and hours1 >= hours2 ) if(($days2 >= $days1) and ($hours2 >= $hours1))";
            if(($days2 >= $days1) and ($hours2 >= $hours1)) {
                return true; 
            } else {
                return false;     
            } 
       }
} 