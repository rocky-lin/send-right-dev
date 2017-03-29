<?php

namespace App;

use Carbon\Carbon;
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
	public function addOn()
	{
		return $this->hasMany('App\AddOn');
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
	public static function getAddOns()
	{
		return self::find(User::getUserAccount())->addOn;
	}

	public static function getLatestSubscription()
	{
		$payshortcut_member_orders = self::getBillingRecords(); //curlGetRequest(['id'=>$payshortcut_member_id], $payShortCutUrl);
		foreach($payshortcut_member_orders as $order ) {
			if($order['title'] == 'Sendright Lite Plan') {
 				return $order;
			}
		}
	}


	public static function getNextPaymentDateNoneReadable()
	{
		$order = self::getLatestSubscription();
		$date = Helper::createDateTime($order['created_at']);
		return $date->addMonths(1);
	}

	public static function getNextPaymentDate()
	{
		$order = self::getLatestSubscription(); 
		// print "latest subscription created at " . $order['created_at']; 
		if(!empty($order['created_at'])) { 
			$date = Helper::createDateTime($order['created_at']);
			return human_readable_date_time($date->addMonths(1));
		} else {
			return 'Not available';
		}
	}

	public static function getBillingRecords()
	{
		$payshortcut_member = session("payshortcut_member");

		$payshortcut_member_id = $payshortcut_member['id'];

		$payShortCutUrl = 'http://payshortcut.net/api/member/get/order';

		$payshortcut_member_orders = curlGetRequest(['id'=>$payshortcut_member_id], $payShortCutUrl);

		return $payshortcut_member_orders;
	}

	public static function isAccountHasSubscribed()
	{
		if (!empty(self::getLatestSubscription()))
		{
			//			print " you subscribed the sendright";
			return true;
		}
		else
		{
			return false;
		}
	}

	public static function isHasNotExpired()
	{
 		$now = Carbon::now();

		//print " now - $now " . ' next payment - ' .   self::getNextPaymentDateNoneReadable();

		if($now <= self::getNextPaymentDateNoneReadable() )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public static function getAccountSubscription()
	{
		return 'basic';
	}

	public static function isSubscribedAndValid($type='basic')
	{
		if($type == 'basic') {
			if (self::isAccountHasSubscribed() == true and self::isHasNotExpired() == true and self::getAccountSubscription() == 'basic') {
 				return true;
			} else {
				return false;
			}
		}

		return false;
	}
}