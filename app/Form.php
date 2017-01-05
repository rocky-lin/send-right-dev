<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\FormList; 
use App\List1;
class Form extends Model
{
   protected $table = 'forms';  
   
   protected $fillable = ['account_id', 'name', 'config_email', 'folder_name', 'content', 'redirect_url', 'response', 'opt_in_message', 'simple_embedded', 'full_embedded']; 

   protected $hidden = []; 


   /** 
    *  A form is belongs to a account
    */
   public function acccount() 
   {
   		return belongsTo('App\Account');
   } 
 
   /**
    *  Form has many lists  but for now its 1 list select
    *  but I set this already to point to 1 form to many lists
    */
   public function formLists() {
   		return $this->hasMany('App\FormList', 'form_id', 'id');
   }

   /**
    * Form has many form entries 
    * This may be deleted soon, please take a look with the database because that may be 
    * bloated with data
    */
   public function formEntries(){
   		return $this->hasMany('App\FormEntry');
   }

   /**
    * If form assign to many list then this query should be
    * changed to many result and return an array 
    */
   public static function getListIdFirst($formId) 
   {   
       $list = FormList::where('form_id', $formId)->first();     
       return (!empty($list->list_id)) ? $list->list_id : 0;
   }

   /** 
    * Get total form contacts
    */
   public function getTotalFormContacts() {
      return 20;
   }

   public static function getAllForms($limit=100) 
    {
        return self::where('account_id', User::getUserAccount())->limit($limit)->orderBy('id', 'desc')->get();
    }
   /**
    * if the contact can add many list then this should be looping to 
    * get the total contact of each list 
    */ 
   public static function getFormTotalContact($formId) 
   { 
      // get specific list_id of the contact 
     $listId = self::getListIdFirst($formId); 

     // print "<br> list id  $listId ";
      // get total contact via specific list 
      return List1::getListTotalContact($listId); 
   }
}
