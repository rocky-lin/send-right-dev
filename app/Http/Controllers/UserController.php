<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; 
use App\Activity;
use Auth; 
use App\Account; 

class UserController extends Controller
{
    public function profile()
    { 	 
    	return view('pages/member/profile'); 
    }
    public function account() 
    {

        $userAccount['name']      = Auth::user()->name;
        $userAccount['email']     = Auth::user()->email; 
        $userAccount['user_name'] = Account::getUserName(); 
        $userAccount['company']   = Account::getCompanyName(); 
        $userAccount['time_zone'] = Account::getTimeZone();   

        $userAccount = json_encode($userAccount);
        return view('pages/member/account', compact('userAccount'));   

    }
    public function billing() 
    {	
    	return view('pages/member/billing'); 
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
        $accountAction = ''; 
        $userAction = '';
        $isEamil = false;
        $isEamil = User::isUserExist($request->get('email')); 
         if(!$isEamil)   {
            // print "email not exist"; 
            User::find(Auth::user()->id)->update(['email'=>$request->get('email')]);  
         }  else {
            print "Email exist, failed to update  <b>x</b><br>";
            $userAction .= "Email exist, failed to update. ";  
         }
 
        $user = User::find(Auth::user()->id)->update(['name'=>$request->get('name')]);   
        $account = Account::find(User::getUserAccount())->update(['company'=>$request->get('company')]);  

        if(!$isEamil) { 
            print "Email successfully update  <i class='fa fa-check' aria-hidden='true'></i><br>";  
             $userAction .= "Email successfully update"; 
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
}