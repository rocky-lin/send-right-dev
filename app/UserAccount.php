<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{ 
    protected $table = 'user_accounts';  
  	protected $fillable = [
         'account_id', 'user_id', 'role',
    ]; 

    public function account() {
      return $this->belongsTo('App\Account');
    }

}