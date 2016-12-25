<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	
   	protected $table = 'invoices'; 

   	protected $fillable = [
   		'account_id',
		'product_id',
		'total_amount',
		'response'
	];
 
	public function account()
	{
		return $this->belongsTo('App\Account'); 
	}
	public function product()
	{
		return $this->belongsTo('App\Product'); 
	} 
	public static function getNewOrderId()
	{
		$orderId = Self::orderBy('id', 'desc')->first()->id;
 		$orderId++;   
 		return $orderId; 
	}
	public static function createNewInvoice($invoice=[])
	{
		// dd($invoice);
		return self::create($invoice);
	}
}
