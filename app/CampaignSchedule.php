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
      } 