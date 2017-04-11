<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Report extends Model
{
  	protected $table = 'reports';
 	protected $fillable = [
 	 	'account_id',
		'campaign_id',
		'total_send',
		'total_arrival',
		'total_open',
		'total_click',
		'total_unsubscribe',
		'total_complain',
		'total_arrival_rate',
		'total_open_rate',
		'total_click_rate',
		'total_unsubscribe_rate',
		'last_sent_date_time',
		'status' 
 	]; 

 	/**
 	 * Create campaign report if not exist via campaign id check 
 	 */
 	public static function createIfNotExist($campaignId, $kind)
 	{	
 
 		if($kind != 'mobile email optin') {  
	 		// get total results from campaign report if more than 0 meaning campaign report already exist 
	 		// else not exist and execute insert new campaign	
	 		$isReportCampaign = Report::where('campaign_id', $campaignId)->count();

	 		if($isReportCampaign < 1) { 
		 		// create new report information for new campaign only
		 		Report::create([
					'campaign_id' => $campaignId,   
					 'total_send' => 0,
					 'total_arrival' => 0,
					 'total_open' => 0,
					 'total_click' => 0,
					 'total_unsubscribe' => 0,
					 'total_complain' => 0,
					 'total_arrival_rate' => 0,
					 'total_open_rate' => 0,
					 'total_click_rate' => 0,
					 'total_unsubscribe_rate' => 0, 
					 'status' => 'Pending'
				]); 
	 		}  
 		}
 	}

	/**
	 * Set report for specific campaign to delivered status 
	 */
 	public static function updateStatusDelivered($campaignId) {
 		Report::where('campaign_id', $campaignId)->update(['status'=> 'Delivered', 'last_sent_date_time'=>Carbon::now()]); 
 	}

	/**
	 * Set report for specific campaign to pending status 
	 */
 	public static function updateStatusPending($campaignId) {
 		 		Report::where('campaign_id', $campaignId)->update(['status'=> 'Pending']); 
 	}

	/**
	 * Set report for specific campaign to schedule status 
	 */
 	public static function updateStatusOnSchedule($campaignId) {
  		Report::where('campaign_id', $campaignId)->update(['status'=> 'On Schedule']);  
 	}


 	public static function updateTotalSend($campaignId, $addNumber)
 	{ 
 		Report::where('campaign_id', $campaignId)->increment('total_send', $addNumber);
  	}
}
