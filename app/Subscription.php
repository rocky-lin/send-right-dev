<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Product;
use Carbon\Carbon;

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
    public static function getProductName() {

    }


    public static function setAddOneMonthSubscription() {}
    public static function setAddOneMonthSubscriptionAlreadySubscribed() {}
    public static function setCancelSubscription() {}
    public static function setStatusSubscription() {}





}
