<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConfirRegistrationController extends Controller
{ 
	/** 
	 * [__construct this will allow the user to authenticate the]
	 */
   	function __construct() {
   		$this->middleware('auth');  
   	} 
   	/**
   	 * [cofnrmEmail confirm the user being registered system]
   	 * @param  [type] $userId [this is the id of the user to be able to locate to update the user status]
   	 * @param  [type] $token  [this is the token that has been sent during the registration]
   	 * @return [type]         [description]
   	 */
   	public function cofnrmEmail($userId, $token) {
   		// confirm email here update user status 
   	}	  
}
