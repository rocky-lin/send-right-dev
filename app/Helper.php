<?php

namespace App; 
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Helper extends Model
{ 

    public static function dateTimeExplode($dateTime)
    {  
     	if(empty($dateTime)) {
     		$dateTime = Carbon::now(); 
     	}  
 
		$d1   = explode(" ", $dateTime); 
		$date = explode("-", $d1[0]); 
		$time = explode(":", $d1[1]); 
	 
		$hour = $time[0];
		$min  = $time[1];
		$sec  = $time[2]; 

	 	$year  = $date[0];
	 	$month = $date[1];
	 	$day   = $date[2];
		
	  	$explodedDateTime = ['year'=>$year, 'month'=>$month, 'day'=>$day, 'hour'=>$hour, 'min'=>$min, 'sec'=>$sec]; 

	  	return $explodedDateTime; 
    }

    public static function createDateTime($dateTime)
    {
    	 $dateTimeExploded = Helper::dateTimeExplode($dateTime); 
    	return Carbon::create($dateTimeExploded['year'], $dateTimeExploded['month'], $dateTimeExploded['day'],  $dateTimeExploded['hour'], $dateTimeExploded['min'], $dateTimeExploded['sec']); 
    }
    public static function toAgo($dateTime)
    {
    	return Carbon::createFromTimeStamp(strtotime($dateTime))->diffForHumans(); 
    }
 
}
