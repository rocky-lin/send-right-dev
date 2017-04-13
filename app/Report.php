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

	/**
	 * Set updated total send increment
	 */
 	public static function updateTotalSend($campaignId, $addNumber)
 	{ 
 		Report::where('campaign_id', $campaignId)->increment('total_send', $addNumber);
  	}
 	
 	/**
 	 * use parameter rateType below 
 	 * total_arrival_rate,total_open_rate, total_click_rate, total_unsubscribe_rate  
 	 */
  	public static function updateCalculationRate($campaignId, $rateType) 
  	{ 
  		 $rateTotalName = Report::getTotalRowName($rateType); 
  		
  		// get from database
 	    $report = Report::where('campaign_id', $campaignId)->first()->toArray(); 
 		// dd(	$report) ;
 		// do do calculation of percentage	 
 			$percentage = Report::getPercentage($report['total_send'], $report[$rateTotalName]);
 	 	
 	 	// do update to database
			 Report::where('campaign_id', $campaignId)->update([$rateType=>$percentage]);  

		// return latest percentage
			return $percentage; 
  	}
  	 
  	 /**
  	  * Use this parameter as row
  	  * total_arrival_rate,total_open_rate, total_click_rate, total_unsubscribe_rate  
      */
  	public static function getRateDb($campaignId, $rateType) 
  	{  
  		// get rate direct from database and return rate 
  		$report = Report::where('campaign_id', $campaignId)->first()->toArray();
 
  		return $report[$rateType];  
  	}

  	/**
  	 * Update total rating and get new total rating
  	  * total_arrival_rate,total_open_rate, total_click_rate, total_unsubscribe_rate  
  	 */
  	public static function getAndUpdateRate($campaignId, $rateType) {

  		// call updateCalculationRate
  	    Report::updateCalculationRate($campaignId, $rateType); 
  		
  		// call getRateDb 
  		return Report::getRateDb($campaignId, $rateType);
  	}
 
	private static function getPercentage($y, $x) 
  	{ 
		$percentage = 0.0; 
	 	$percentage =  (double) ($x/$y)*100;  
	 	return number_format($percentage, 2, '.', '');  
  	}

  	private static function getTotalRowName($rateRow) 
  	{
  		$row = [
	  		'total_arrival_rate' => 'total_arrival', 
	  		'total_open_rate' => 'total_open', 
	  		'total_click_rate' => 'total_click', 
	  		'total_unsubscribe_rate' => 'total_unsubscribe',  
  		];  
  		return $row[$rateRow];
  	}
}
