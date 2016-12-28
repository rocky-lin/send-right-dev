<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;
use App\Product;
use Auth; 
use Pay2Go; 
use App\Invoice;
use App\Pay2GoModel;
use App\User;
use Carbon\Carbon;
use App\Activity;
use App\Account;

class SubscriptionController extends Controller
{
    public function confirm(Request $request)
    {   
    	$orderId = Invoice::getNewOrderId();
    	$productInfo = Product::getProductByProductName($request->get('name'));

    	// dd($productInfo);  
    	return view('pages/subscription/confirm', compact('productInfo', 'orderId')); 
    }
    public function confirmProceed(Request $request) 
    {	

    	// dd($request->all());
    	// print "conform procced "; 
    	$product = Product::getProductByProductName($request->get('name'));
 
 	    // $orderId = Invoice::orderBy('id', 'desc')->first()->id;
 	    // $orderId++;  
	    // print "order id" . Invoice::getNewOrderId();  
	    // exit;  
		// $orderId = 123;
 
		$form = $request->except('_token');

	    // 建立商店
	    $pay2go = new Pay2Go(env('CASH_STORE_ID'), env('CASH_STORE_HashKey'), env('CASH_STORE_HashIV'));

	    // 商品資訊
	    $order = $pay2go->setOrder(Invoice::getNewOrderId(), $product->price , $product->name, $request->get('Email'))->submitOrder();  
 
	    // 將資訊回傳至自定義 view javascript auto submit
	    return view('cash.submit')->with(compact('order'));
		//    	dd($request->all());

    } 
    public function success()
    {
    	 if(!session_id()) {
			 session_start();
		 }
 		 $response = '{"Status":"SUCCESS","Message":"\u6388\u6b0a\u6210\u529f","Result":"{\"MerchantID\":\"MS3709347\",\"Amt\":836,\"TradeNo\":\"16122315361971592\",\"MerchantOrderNo\":\"6\",\"RespondType\":\"JSON\",\"CheckCode\":\"866E6361DFB7633B56819F8759F280231FFDE3D4B8367B5071812D8E85C75149\",\"IP\":\"112.210.113.62\",\"EscrowBank\":\"KGI\",\"ItemDesc\":\"Bronze\",\"IsLogin\":true,\"PaymentType\":\"CREDIT\",\"PayTime\":\"2016-12-23 15:36:19\",\"RespondCode\":\"00\",\"Auth\":\"930637\",\"Card6No\":\"400022\",\"Card4No\":\"1111\",\"Exp\":\"1705\",\"TokenUseStatus\":0,\"InstFirst\":836,\"InstEach\":0,\"Inst\":0,\"ECI\":\"\"}"}';
		 // load response
		 // increment invoice
    	 // PRINT "THANK YOU PAGE";
    	 $pay2GoModel = new Pay2GoModel(); 
		 $pay2GoModel->loadPaymentResponse($response);
			 // print "status"  . $pay2GoModel->getStatus();
    	 	 if ($pay2GoModel->isPaymentSuccess() == true) {

				 // create invoice
				 $invoiceCreateStatus = Invoice::createNewInvoice([
				 	  'account_id'=>User::getUserAccount(),
				      'product_id'=>$pay2GoModel->getProductId(),
				      'total_amount'=>$pay2GoModel->getProductAmount(),
					  'response'=>$pay2GoModel->getSerializedResponse()
				 ]);

				 if($invoiceCreateStatus) {
					 Activity::createActivity([
							 'table_name' => 'Invoice',
							 'table_id' =>   $invoiceCreateStatus->id,
							 'action' => 'New invoice created',
					 ]);
//					 print "successfully created invoice";
				 }

				 // create or update subscription
				 $subscriptionUpdate = Subscription::where('account_id', User::getUserAccount())->update([
					  'product_id'=> $pay2GoModel->getProductId(),
					  'bill_start_at'=>Carbon::now(),
				      'bill_end_at'=>Carbon::now()->addMonth(1),
					  'status'=>Subscription::getStatusBilled()
				 ]);

				 if($subscriptionUpdate) {
//					 print "Subscription successfully updated";
					 Activity::createActivity([
							 'table_name' => 'subscriptions',
							 'table_id' =>   Account::getSubscriptionId(),
							 'action' => 'New invoice created',
					 ]);
				 }

				// $user = User::firstOrNew(array('name' => Input::get('name')));
				// $user->foo = Input::get('foo');
				// $user->save();

//    	 		 print "success now";
			 } else {
//		 		 print "failed now";
		 	}
    	 return view('pages/subscription/thank-you');
    }

	public static function checkRun()
	{
		print "start checking subscription";
	}



}
