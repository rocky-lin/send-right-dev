<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Account extends Model
{ 
	protected $table = 'accounts'; 
 	/** 
 	 * Get the forms lists of the specific account
 	 */
	public function formLists() 
    {
        return $this->hasManyThrough('App\FormList', 'App\Form', 'account_id', 'form_id', 'id');
    }     
    /** 
     * This will get all the users in the account
     */
 	public function user_acounts()
 	{
		return $this->hasMany('App\UserAccount');
 	}
 	/** 
 	 * This will get all the contact via specific account
 	 */
 	public function contacts() 
 	{
 		return $this->hasMany('App\Contact');
 	} 

 	public function subscription()
 	{
 		return $this->hasOne('App\Subscription');
 	}
 	/** 
 	 * This will get all the forms via specific account id
 	 */
 	public function forms()
 	{
 		return $this->hasMany('App\Form', 'account_id', 'id');
 	} 
	public function campaigns()
	{
		return $this->hasMany('App\Campaign', 'account_id', 'id');
	}
	public static function getCompanyName() 
	{
		$account = self::find(User::getUserAccount()); 
		return $account->company;  
	} 
	public static function getTimeZone() 
	{ 
		$account = self::find(User::getUserAccount()); 
		return $account->time_zone;  
	}  
	public static function getUserName() 
	{ 
		$account = self::find(User::getUserAccount()); 
		return $account->user_name;   
	} 
}