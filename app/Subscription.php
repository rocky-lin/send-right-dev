<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Product;
use Carbon\Carbon;
use App\Account;
use App\Helper;

class Subscription extends Model
{
    protected $table = 'subscriptions'; 

    protected $fillable = [
	    'account_id',
		'product_id',
		'payment_api_id',
		'payment_api_plan',
		'bill_start_at',
		'bill_end_at',
		'quantity',
		'trial_start_at',
		'trial_end_at',
        'status'
    ];


    protected static $statusBilled = 3;
    protected static $statusFree = 2;
    protected static $statusExpired = 1;

    public function account() 
    {
    	return $this->belongsTo('App\Account'); 
    }
    public function product()
    {
    	return $this->belongsTo('App\Product');
    }


    public static function getTrialStartAt()
    {
        return self::where('account_id', User::getUserAccount())->get()->trial_start_at;
    }
    public static function getTrialEndAt()
    {
        return self::where('account_id', User::getUserAccount())->get()->trial_ends_at;
    }
    public static function createNewSubscription($account_id)
    {
        return self::create(['account_id'=>$account_id, 'product_id'=>Product::first()->id, 'trial_start_at'=>Carbon::now(), 'trial_end_at'=>Carbon::now()->addMonth(1)]);
    }
    public static function createNewSubscriptionCustom($subscription) {
        self::create($subscription);
    }
    public static function getRemainingDaysFromSubscription()
    {
        $subscription = Account::getSubscription();
        $totalDays =  Helper::getDaysDifferenceBetween2DatTime($subscription->bill_end_at);
        return $totalDays;
    }
    public static function getRemainingDaysFromTrial()
    {
        $subscription = Account::getSubscription();
        $totalDays =  Helper::getDaysDifferenceBetween2DatTime($subscription->trial_end_at);
        return $totalDays;
    }
    public static function getStatusFree()
    {
        return self::$statusFree;
    }
    public static function getStatusBilled()
    {
        return self::$statusBilled;
    }
    public static function getStatusExpired()
    {
        return self::$statusExpired;
    }

    public static function updateSubscriptionExpired()
    {

//        print "<br> remaining subscription " . self::getRemainingDaysFromSubscription();
//        print "<br> remaining trial subscription " . self::getRemainingDaysFromTrial();

        $subscriptionId = Account::getSubscriptionId();
        if(!empty(Account::getSubscription()->trial_end_at)) {

            if (self::getRemainingDaysFromSubscription() == 0){
//                print "<br>status = 1 successfully  updated";
                return Subscription::find($subscriptionId)->update(['status' => 1]);
            } else if (self::getRemainingDaysFromSubscription() > 0){
//                print "<br>status = 3 successfully  updated";
                return Subscription::find($subscriptionId)->update(['status'=>3]);
                //update  status 3
            }
            // update status 1
        } else {

            if (self::getRemainingDaysFromTrial() == 0) {
//                print "<br>status = 1 successfully  updated";
                return Subscription::find($subscriptionId)->update(['status'=>4]);
            }
        }
            // update status 1

    }

    public static function setAddOneMonthSubscription() {}
    public static function setAddOneMonthSubscriptionAlreadySubscribed() {}
    public static function setCancelSubscription() {}
    public static function setStatusSubscription() {}







}
