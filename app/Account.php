<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{ 
	protected $table = 'accounts';
 	

 	public function user_acounts(){
		return $this->hasMany('App\UserAccount');
 	}
 	public function contacts() {
 		return $this->hasMany('App\Contact');
 	}
}
