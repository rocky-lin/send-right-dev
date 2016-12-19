<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; 
use App\Activity;
use Auth; 

class UserController extends Controller
{
    public function profile()
    { 	 
    	return view('pages/member/profile'); 
    }
    public function account() 
    {
        return view('pages/member/account'); 
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
}