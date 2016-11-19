<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
   protected $table = 'forms';  
   protected $fillable = ['account_id', 'name', 'config_email', 'folder_name', 'content', 'redirect_url', 'response', 'opt_in_message', 'simple_embedded', 'full_embedded']; 
   protected $hidden = []; 

   public function acccount() {
   		return belongsTo('App\Account');
   }
   public function formLists() {
   		return hasMany('App\FormList');
   }
   public function formEntries(){
   		return hasMany('App\FormEntry');
   } 
}
