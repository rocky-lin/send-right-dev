<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions'; 

    protected $fillabe = [
	    'account_id',
		'product_id', 
		'payment_api_id',
		'payment_api_plan',
		'bill_start_at',
		'bill_end_at',
		'quantity',
		'trial_ends_at',
		'ends_at'  
    ];  
 
    public function account() 
    {
    	return $this->belongsTo('App\Account'); 
    }
    public function product() 
    {
    	return $this->belongsTo('App\Product'); 
    } 

    public function getSubscritionName() 
    {

    }
}
