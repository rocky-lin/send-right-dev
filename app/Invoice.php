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
	];
 
	public function account()
	{
		return $this->belongsTo('App\Account'); 
	}
	public function product()
	{
		return $this->belongsTo('App\Product'); 
	} 
}
