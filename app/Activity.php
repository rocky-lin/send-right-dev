<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User; 

class Activity extends Model
{
    protected $table = 'activities';  
    protected $fillable = ['account_id', 'table_name', 'table_id', 'action'];
    protected $hidden = []; 


    public static function getAllAcitivities($limit=100) 
    {
    	return self::where('account_id', User::getUserAccount())->limit($limit)->orderBy('id', 'desc')->get();
    }
    public static function getAllAcitivitiesLimit($limitStart, $limitEnd) 
    {
    	//
    }

    public static function createActivity($activity)
    {
          Activity::create([ 
            'account_id'=>(!empty($activity['account_id'])) ? $activity['account_id'] : User::getUserAccount(),
            'table_name'=>$activity['table_name'],
            'table_id'=>$activity['table_id'], 
            'action'=>$activity['action']]      
        ); 
    } 
}
