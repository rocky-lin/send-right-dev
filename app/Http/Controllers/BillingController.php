<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function testing()
    {
        print "test";
    }

    public function deactivate(Request $request)
    {
                $response = curlPostRequest(['PostData_'=>$request->get('PostData_'), 'MerchantID_'=>$request->get('MerchantID_')], 'https://core.spgateway.com/API/CreditCard/Cancel');
        //        print "deactivate " .  $response;
        //        print "deactivate billing via php curl";
                dd($request->all());
        //        print "update status billing in payshortcut via curl";
        //        done
    }
}
