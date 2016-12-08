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
 
       public static function getReachDeadline() 
       { 
       	 	 
          // $scheduledCampaign  = DB::table('campaigns')
          //   ->join('campaign_schedules', 'campaign_schedules.campaign_id', '=', 'campaigns.id')
          //   ->join('campaign_lists', 'campaign_lists.campaign_id', '=', 'campaigns.id') 
          //   ->where('campaign_schedules.schedule_send', '<=', Carbon::now()) 
          //   ->get();

      print "<br> date time now  " .  Carbon::now(); 
  	$scheduledCampaign = DB::table('campaigns')
        ->join('campaign_schedules', function ($join) {
            $join->on('campaigns.id', '=', 'campaign_schedules.campaign_id')
               ->where('campaign_schedules.schedule_send', '<=', Carbon::now())
               ->where('campaigns.status', '=', 'active')
               ->where('campaigns.type', '=', 'schedule send');
        })
        ->get();
 
       		// print "current date time  " . Carbon::now(); 
       		// $scheduledCampaign = self::where('schedule_send', '<=', Carbon::now())->get(); 
       		 
       		// dd($scheduledCampaign); 
       		// foreach ($scheduledCampaign as $sc) {
       		// 	print "<br> id " . $sc->id . " date " . $sc->schedule_send; 
       		// }
       		return $scheduledCampaign; 
       }



} 