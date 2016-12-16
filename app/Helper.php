<?php

namespace App; 
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Helper extends Model
{ 





    // 2016-12-15 17:38:07
    public static function getSpecificDayHowMinInDateTime($dateTime)
    {   

        // calculate passed day interval  
        $day1 = Self::createDateTime($dateTime); 
        $day2 = Self::createDateTime(Carbon::now());   
        $time1 = self::dateTimeExplode($dateTime);  
        $time2 = self::dateTimeExplode(Carbon::now());  
        $hour1 = $time2['year'] . '-' . $time2['month']  . '-' . $time2['day'] . ' '  . $time1['hour'] . ':' . $time1['min'] . ':' . $time1['sec'];
        $hour2 = $time2['year'] . '-' . $time2['month']  . '-' . $time2['day'] . ' '  . $time2['hour'] . ':' . $time2['min'] . ':' . $time2['sec']; 

        // calculate passed hours interval
        $date1 = Self::createDateTime($hour1); 
        $date2 = Self::createDateTime($hour2);   
        $dayHourInteraval['hours'] = $date1->diffInHours($date2); 
        $dayHourInteraval['days'] =  $day1->diffInDays($day2) ;   
        
        // return interval days and hours
        return $dayHourInteraval;
    }
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
    public static function responseAddCreatedAtAgo($response) 
    {
        foreach($response as $index => $respond) {
            $response[$index]['create_at_ago'] = Helper::toAgo($respond['created_at']); 
        } 

        return $response;
    }
 
}
