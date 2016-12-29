<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; 
use App\Activity;
use Auth; 
use App\Account;
use App\Product;
use App\Subscription;

class UserController extends Controller
{
    public function profile()
    {
        $subscriptionRemainingDaysBilled = Subscription::getRemainingDaysFromSubscription();
        $subscriptionRemainingDaysTrial = Subscription::getRemainingDaysFromTrial();

        //        print "<pre>";
        //        print_r($subscription);
        $account = Account::find(User::getUserAccount());
        $userInfo['user_name'] = $account->user_name;
        $userInfo['company']   = $account->company;
        $userInfo['time_zone'] = $account->time_zone;
        $userInfo['full_name'] = Auth::user()->name;
        $userInfo['email']     = Auth::user()->email;
        $userInfo['subscription_name'] = User::getSubscriptionName();


    	return view('pages/member/profile', compact('userInfo', 'subscriptionRemainingDaysBilled', 'subscriptionRemainingDaysTrial'));
    }
    public function account() 
    {

        $userAccount['name']      = Auth::user()->name;
        $userAccount['email']     = Auth::user()->email; 
        $userAccount['user_name'] = Account::getUserName(); 
        $userAccount['company']   = Account::getCompanyName(); 
        $userAccount['time_zone'] = Account::getTimeZone();
        $userAccount['sendright_email'] = Account::getSendRightEmail();
        $userAccount['details'] = Account::find(User::getUserAccount());

        $userAccount = json_encode($userAccount);
        return view('pages/member/account', compact('userAccount'));   

    }
    public function billing() 
    {



        $bronze['product'] = Product::first();
        // dd(  $bronze['product'] );
        $bronze['product']['details'] = Product::getProductDetails(Product::first()->id);

 
    //       Product::find(1)

        $subscriptionStatus =  Account::getSubscriptionStatus(); 
    	return view('pages/member/billing', compact('bronze', 'subscriptionStatus'));
    } 
    public function changePassword() 
    {
    	return view('pages/member/change-password'); 
    }
    public function updatePasswordPost(Request $request)   
    {  
         // dd($request->all()); 
        if(User::updatePassword($request->get('password'))) {

            Activity::createActivity(['table_name'=>'user', 'table_id'=>Auth::user()->id, 'action'=> Auth::user()->name . " successfully updated his password."]);
            print "Your account password successfully updated, try logout and log in now!"; 
        } else {
            print "Failed to update your password"; 
        } 
    } 
    public function updateAccountPost(Request $request)  
    {   


        // print "user account " . User::getUserAccount();
        // dd($request->all());
        $accountAction = ''; 
        $userAction = '';
        $isEamil = false;
        $sendRightEmail = false;
        $isEamil = User::isUserExist($request->get('email')); 
         if(!$isEamil)   {
            // print "email not exist"; 
            User::find(Auth::user()->id)->update(['email'=>$request->get('email')]);  
         }  else {
            print "Email exist, failed to update  <b>x</b><br>";
            $userAction .= "Email exist, failed to update. ";  
         }

        $sendRightEmail = Account::isSendRightEmailExist($request->get('sendright_email'));
         if(!$sendRightEmail)   { 
            Account::find(User::getUserAccount())->update(['sendright_email'=>$request->get('sendright_email')]); 
         }  else {
            print "Sendright Email exist, failed to update  <b>x</b><br>";
            $userAction .= "Sendright Email exist, failed to update. ";  
         }
 

        $user = User::find(Auth::user()->id)->update(['name'=>$request->get('name')]);   

        $account = Account::find(User::getUserAccount())->update(['company'=>$request->get('company')]);  



        if(!$isEamil) { 
            print "Email successfully update  <i class='fa fa-check' aria-hidden='true'></i><br>";  
             $userAction .= "Email successfully update"; 
        } 
        if(!$sendRightEmail) { 
            print "Sendright Email successfully update  <i class='fa fa-check' aria-hidden='true'></i><br>";  
             $userAction .= "Sendright Email successfully update"; 
        } 


        if($user  === true)  {
            print "Full name successfully updated <i class='fa fa-check' aria-hidden='true'></i>  <br>";
            $userAction .= "Full name successfully updated";
        } else {
            print "Something wrong full name failed updated<span class='glyphicon-class'></span><br>";
            $userAction .=  "Something wrong full name failed updated";
        }
        
        if($account  === true) {
            print "Company successfully updated <i class='fa fa-check' aria-hidden='true'></i><br>"; 
            $accountAction .=  "Company successfully updated";  
        } else {
            print "Something wrong company failed updated  <b>x</b><br>";
            $accountAction .= "Something wrong company failed updated"; 
        } 




        // print "user action  " . $userAction; 
        // print "user action  " . $accountAction;  
        Activity::createActivity(['table_name'=>'users', 'table_id'=>Auth::user()->id, 'action'=>$userAction]);
        Activity::createActivity(['table_name'=>'accounts', 'table_id'=>User::getUserAccount(), 'action'=>$accountAction]); 
        // print "Your account password successfully updated, try logout and log in now!";  
    }

    public function updateBillingAddress(Request $request)
    {
        print "updated account id" . User::getUserAccount();
        //        dd($request->all());
        Account::where('id',User::getUserAccount())->update([
            'billing_address'=>$request->get('billing_address'),
            'billing_address_street'=>$request->get('billing_address_street'),
            'billing_address_line_2'=>$request->get('billing_address_line_2'),
            'billing_address_city'=>$request->get('billing_address_city'),
            'billing_address_state'=>$request->get('billing_address_state'),
            'billing_address_zip_code'=>$request->get('billing_address_zip_code'),
        ]);
    }
     public function updateBillingCreditCard(Request $request)
    {
//        dd($request->all());
        Account::where('id',User::getUserAccount())->update([
            'billing_card_holder_name'=>$request->get('billing_card_holder_name'),
            'billing_card_number'=>$request->get('billing_card_number'),
            'billing_card_month_expiry'=>$request->get('billing_card_month_expiry'),
            'billing_card_year_expiry'=>$request->get('billing_card_year_expiry'),
            'billing_card_cvv'=>$request->get('billing_card_cvv')
        ]);

    }

}