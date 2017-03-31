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

        $responseData = []; 
        // dd($request->all());  
        // process deactivate payment in spgateway
        $response = curlPostRequest(['PostData_'=>$request->get('PostData_'), 'MerchantID_'=>$request->get('MerchantID_')], $request->get('url'));    
        $responseData['response_spgateway'] = $response;
         

        // process update status to deactivated in payshortcut with specific order id 
        $response = curlGetRequest(null, 'http://payshortcut.net/api/order/update/status/' . $request->get('order_id'), 'full'); 
         
        $responseData['response_payshortcut'] = $response;  
        return  $responseData; 
    }
}
