<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignSchedule extends Model
{
       protected $table = "campaign_schedules";    
       protected $fillable = ['campaign_id', 'repeat', 'schedule_send'];  
       protected $hidden = []; 


       public static function createOrUpdateByCampaignId($campaignSchedule) 
       {  
       		if(!self::where('campaign_id', $campaignSchedule['campaign_id'])->update($campaignSchedule)) { 
   				self::create($campaignSchedule);  
       		} 
       }
} 