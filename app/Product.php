<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'price'];

    public function subscription()
    {
    	return $this->hasMany('App\Subscription');
    }
    public function productDetails()
    {
    	return $this->hasMany('App\ProductDetail');
    }

    public static  function getProductDetails($product_id)
    {
        return self::find(1)->productDetails;
    }
}
