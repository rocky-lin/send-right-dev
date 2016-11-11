<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
   protected $table = 'forms';  
   protected $fillable = ['account_id', 'name', 'folder_name', 'content', 'redirect_url', 'response', 'opt_in_message']; 
   protected $hidden = []; 

   public function acccount() {
   		return belongsTo('App\Account');
   }
   public function formLists() {
   		return hasMany('App\FormList');
   }
}
