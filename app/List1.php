<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class  List1 extends Model
{
    protected $table = 'lists';
    protected $fillable = ['name', 'url', 'reminder', 'account_id']; 
    protected $hidden = ['account_id'];
    
    public function list_contact()
    {
   		return $this->hasMany('App\ListContact', 'list_id', 'id');
    }     

    public function formLists() {
        return $this->hasMany('App\FormList'); 
    }

    public static function getListContactsTotal($id) 
    { 
        return List1::find($id)->list_contact()->count();
    }

    public static function getListContacts($id) 
    { 
        return List1::find($id)->list_contact;
    }

    public static function getLists() 
    {
        return List1::where('account_id', User::getUserAccount())->orderBy('id', 'DESC')->get(); 
    }

}
