<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $table = 'product_details'; 
    protected $fillable = ['product_id', 'name']; 

    public function product() 
    {
    	return $this->belongsTo('App\Product'); 
    }
}


