<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Account extends Model
{ 
	protected $table = 'accounts'; 
	 
	protected $fillable = [ 
		'user_name',
		'company',
		'time_zone',
		'payment_api_id',
		'billing_card_holder_name',
		'billing_card_number',
		'billing_card_month_expiry',
		'billing_card_year_expiry',
		'billing_card_cvv',
		'billing_address',
		'billing_address_street',
		'billing_address_line_2',
		'billing_address_city',
		'billing_address_state',
		'billing_address_zip_code',
		'sendright_email'
	];

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
	public static function getSendRightEmail() 
	{ 
		$account = self::find(User::getUserAccount()); 
		return $account->sendright_email;  
	}  
	public static function getUserName() 
	{ 
		$account = self::find(User::getUserAccount()); 
		return $account->user_name;   
	}



	public static function getSubscriptionStatus()
	{
		return self::find(User::getUserAccount())->subscription()->first()->status;
	}
	public static function getSubscriptionId()
	{
		return self::find(User::getUserAccount())->subscription()->first()->id;
	}
	public static function getSubscription()
	{
		return self::find(User::getUserAccount())->subscription;
	}

	public static function getSubscriptionProduct()
	{
		return self::find(User::getUserAccount())->subscription->product;
	}
	public static function isSendRightEmailExist($sendRightEmail)
	{
		return self::where('sendright_email', $sendRightEmail)->count(); 
	}






}