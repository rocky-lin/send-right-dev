<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pay2Go; 

class CashController extends Controller
{
	public function index()
	{
	    return view('cash.index');
	}
	public function store(Request $request)
	{
		/**
	 	* 1、place table
	 	* 2、payment page
		* 3、Pay2go page
 		* 4、thanks you page
	 	*/ 
	 	// print " CASH_STORE_ID " . env('CASH_STORE_ID')  . " CASH_STORE_HashKey " .  env('CASH_STORE_HashKey') . " CASH_STORE_HashIV " . env('CASH_STORE_HashIV'); 
		// dd($request->all());
	    $form = $request->except('_token');

	    // 建立商店
	    $pay2go = new Pay2Go(env('CASH_STORE_ID'), env('CASH_STORE_HashKey'), env('CASH_STORE_HashIV'));

	    // 商品資訊
	    $order = $pay2go->setOrder($form['MerchantOrderNo'], $form['Amt'], $form['ItemDesc'], $form['Email'])->submitOrder();  
 
	    // 將資訊回傳至自定義 view javascript auto submit
	    return view('cash.submit')->with(compact('order'));
	}

	public function notifyUrl()
	{
		print "notify url";
	}
	public function returnUrl() 
	{  
		if(!session_id()) { 
			session_start();
		}
 	

 		$post = '{"Status":"SUCCESS","Message":"\u6388\u6b0a\u6210\u529f","Result":"{\"MerchantID\":\"MS3709347\",\"Amt\":836,\"TradeNo\":\"16122315361971592\",\"MerchantOrderNo\":\"6\",\"RespondType\":\"JSON\",\"CheckCode\":\"866E6361DFB7633B56819F8759F280231FFDE3D4B8367B5071812D8E85C75149\",\"IP\":\"112.210.113.62\",\"EscrowBank\":\"KGI\",\"ItemDesc\":\"Bronze\",\"IsLogin\":true,\"PaymentType\":\"CREDIT\",\"PayTime\":\"2016-12-23 15:36:19\",\"RespondCode\":\"00\",\"Auth\":\"930637\",\"Card6No\":\"400022\",\"Card4No\":\"1111\",\"Exp\":\"1705\",\"TokenUseStatus\":0,\"InstFirst\":836,\"InstEach\":0,\"Inst\":0,\"ECI\":\"\"}"}'; 




		print "<h2>Thank you page!</h2>"; 
		print "<pre> post"; 

 		$postData = json_decode($post, true); 
 		$postData['Result'] = json_decode($postData['Result'], true);

 		print_r($postData); 


		print_r($_POST);

		print "<br> session"; 
		print_r($_SESSION);
		print "<br> GET"; 
		print_r($_GET); 
	} 
}
