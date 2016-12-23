<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;
use App\Product;

class SubscriptionController extends Controller
{
    public function confirm(Request $request)
    {   
    	$productInfo = Product::getProductByProductName($request->get('name'));

    	dd($productInfo); 

    }
    public function thankYou()
    {
    	PRINT "THANK YOU PAGE";
    	//
    }
}
