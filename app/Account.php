<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Auth;
use Session;

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

	public static function getLatestSubscriptionQueryToPayshortcut()
	{

		$payshortcut_member = session("payshortcut_member");

		//print_r_pre($payshortcut_member, 'account'); 

		if(!empty($payshortcut_member)) {  
			$payshortcut_member_id = $payshortcut_member['id'];
			$url = 'http://payshortcut.net/api/order/get/sendright/subscription/' . $payshortcut_member_id . '/Send%20Right%20Light';
			$payshortcut_member_orders = curlGetRequest(null, $url, 'full');
			session(['latestSubscription'=>$payshortcut_member_orders]);
			return $payshortcut_member_orders;
		} else { 
			 session(['latestSubscription'=>false]);
			return false; 
		}
	}
	public static function getLatestSubscription()
	{
		return session('latestSubscription');
	}


	public static function getNextPaymentDateNoneReadable()
	{
		$order = self::getLatestSubscription();
		$date = Helper::createDateTime($order['created_at']);
		return $date->addMonths(1);


	}

	public static function getNextPaymentDate()
	{

		$created_at = Auth::user()->created_at;

		$order = self::getLatestSubscription(); 
		
		if(!empty($order['created_at']))
		{
			//print "order is not empty";
			$date = Helper::createDateTime($order['created_at']);
			return human_readable_date_time($date->addMonths(1));
		}
		else if (!empty($created_at))
		{
			//print "order is empty then when user registered created at " . $created_at; 
			$date = Helper::createDateTime($created_at);
			return human_readable_date_time($date->addMonths(1)) . ' <br> <b style="color:red">Current free version!</b>';
		}
		else
		{
			print "nothing";
			return 'Not available';
		}
	}

	public static function getBillingRecords()
	{

		$payshortcut_member = session("payshortcut_member");

		if(!empty($payshortcut_member)) { 

			$payshortcut_member_id = $payshortcut_member['id'];

			$payShortCutUrl = 'http://payshortcut.net/api/member/get/order';

			$payshortcut_member_orders = curlGetRequest(['id'=>$payshortcut_member_id], $payShortCutUrl);

			return $payshortcut_member_orders;
		} else {
			return false; 
		}
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

		//print " type = " . $type;

		$subscription  = self::getLatestSubscription();

		$status = $subscription['status']; 

		if($status == 'deactivated') {
			//print "<br> currently deactivated";
			return false;  
		/** Active subscription */
		} else if (self::isAccountHasSubscribed() == true and self::isHasNotExpired() == true and self::getAccountSubscription() == 'basic' ) {  
				//print "<br> currently has subscribed and not expired and subscription is basic"; 
				return true;

		} else if (self::isCurrentFreeVersion()== true and self::isAccountHasSubscribed() == false) { 


			// check date for trial here 
			return 'trial not expired'; 
			//print "<br> free version";
			/** Free version */
		} else if (self::isCurrentFreeVersion()== false and self::isAccountHasSubscribed() == false) { 
			return 'trial expired';   
		}  else { 
			//print "<br> has expired";
			/** expired */
			//print "with expired version";
			return false;
		} 
		//} 
		// return false;
	}

	public static function isCurrentFreeVersion()
	{
		// 		$user = User::find(User::getUserAccount()); 
		//		$created_at = $user->created_at; //'2017-03-29 03:35:33'; // 
		 
		$created_at = Auth::user()->created_at;

		if (30 - ((new \Carbon\Carbon($created_at, 'UTC'))->diffInDays()) < 0) {
			//echo "The date is older than 30 days";
			return false;
		} else {
			//print "current free version"; 
			return true;
		}
	}

	/**
	 * @param array $data
	 * 	$data = [
			'TradeNo' => '17022412335368443',
			'MerchantOrderNo' => '5097',
			'Amt' => '6600',
			'HashIV' => 't8jUsqArVyJOPZcF',
			'HashKey' => 'YK5drj7GZuYiSgfoPlc24OhHJj5g6I35',
			'MerchantID_' => 'MS3709347',
			'url' => 'https://core.spgateway.com/API/CreditCard/Cancel',
		];
	 */
	public static function composeDeactivateButtonForm($data=[])
	{

		$TradeNo 		 = $data['TradeNo'];
		$order_id 		 = $data['order_id'];
		$MerchantOrderNo = $data['MerchantOrderNo'];
		$Amt 		     = $data['Amt'];
		$HashIV 		 = $data['HashIV'];
		$HashKey 		 = $data['HashKey'];
		$MerchantID_     = $data['MerchantID_'];
		$url             = $data['url']; //'https://ccore.spgateway.com/API/CreditCard/Cancel'; //$data['url'];


		$settings = [
			'HashIV'=> $HashIV, //'t8jUsqArVyJOPZcF',
			'HashKey'=> $HashKey, //'YK5drj7GZuYiSgfoPlc24OhHJj5g6I35',
			"MerchantID_" => $MerchantID_, //'MS3709347',
			'url' => $url, //'https://ccore.spgateway.com/API/CreditCard/Cancel',
			'PostData_' => '',
		];

		$post_data_str = [
			'RespondType' => 'JSON',
			'Version' => '1.0',
			'Amt' => $Amt, //6600,
			'MerchantOrderNo' => $MerchantOrderNo, //'5097',
			'TradeNo' => $TradeNo, //'17022412335368443',
			'IndexType' => '1',
			'TimeStamp' => time(),
			'NotifyURL' => '',
		];

		$post_data_str = http_build_query ($post_data_str);
		// print " prepare encryp  " . $post_data_str;

		$post_data = trim(bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $settings['HashKey'], addpadding($post_data_str), MCRYPT_MODE_CBC, $settings['HashIV'])));
		// echo " encrypted string " . $post_data;
		//			<form method='post' action='$settings[url]' ng-submit='deactivateSubmit()'>


		$form = "

				<input type='hidden' value='$url' name='url' id='url' />
				<input type='hidden' value='$order_id' name='order_id' id='order_id' />
				<input type='hidden' value='$post_data' name='PostData_' id='PostData_' />
				<input type='hidden' value='$settings[MerchantID_]'  name='MerchantID_'   id='MerchantID_'   />
				<input type='button' class='button-alt btn btn-danger' value='Deactivate' id='deactivateBilling' />

			";
		return $form;
	}

	public static function getBillingOrderId() 
	{
		$subscription = Account::getLatestSubscription();     
      	return $subscription ['id']; 
	}

	public static function billingGetCurrentLevel()
	{ 
     	$subscription = Account::getLatestSubscription();     
     	$subscribedTotalContact = str_replace('Send Right Light', '',$subscription['title']); 	   
     	 //print " total contact $totalContact total billing contact $subscribedTotalContact"; 
     	if($subscribedTotalContact <= 10000) { 
     		return 1; 
     	} else if ($subscribedTotalContact <= 250000) {   
     		return 2; 
     	} else if ($subscribedTotalContact <= 500000) {   
     		return 3; 
     	} 
	}

 	public static function billingCheckCurrentSubscriptionTotalContactExceed()
 	{   
 		// get total contact in the subscription
     	$subscription = Account::getLatestSubscription();     
     	$subscribedTotalContact = str_replace('Send Right Light', '',$subscription['title']); 	  
     	// get total contact in sendright 
     	 $totalContact  = Contact::where("account_id", User::getUserAccount())->count();   

     	 //print " total contact $totalContact total billing contact $subscribedTotalContact"; 
     	if($totalContact > $subscribedTotalContact) {  

 			$subscription = Account::getLatestSubscription(); 

     		  curlPostRequest(
	            [
	                'email' => Auth::user()->email ,
	                'order_id' => self::getBillingOrderId(),
	                'level' => self::billingGetCurrentLevel(),
	                'status' => 'active'
	            ],
	            'http://payshortcut.net/api/billing/upgrade/store'
	        ); 
     		
     		  // console_js( " insert new billing upgrade and proceed next level because total sendright contact is exceed with total contact subscription" ); 
     		  
     	} else {

     		  // console_js( "subscription total contact and total contact is good for now "); 
     	}  
 	} 

 	private static function billingMoveToNextLevel ()
 	{ 
 	} 
}


