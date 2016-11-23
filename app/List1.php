<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\ListContact;
class  List1 extends Model
{
    protected $table = 'lists';

    protected $fillable = ['name', 'url', 'reminder', 'account_id']; 
    
    protected $hidden = ['account_id'];
    

    /**
     *  List has many contacts 
     */
    public function list_contact()
    {
   		return $this->hasMany('App\ListContact', 'list_id', 'id');
    }     

    /** 
     *  list has many forms
     */
    public function formLists() {
        return $this->hasMany('App\FormList'); 
    }

    /** 
     *  This will get the total list coontacts
     */
    public static function getListContactsTotal($id) 
    { 
        return List1::find($id)->list_contact()->count();
    }

    /** 
     * This will get the lists contacts
     */
    public static function getListContacts($id) 
    { 
        return List1::find($id)->list_contact;
    }
    public static function amazingTest() {
        return 'test';
    }

    /** 
     * This will get the list contacts with details, ex: contact details
     */
    public static function getListContactsWithDetails($listId)  
    {  
           return DB::table('list_contacts')
                ->join('contacts', function ($join) use ($listId) {
                    $join->on( 'list_contacts.contact_id', '=', 'contacts.id')
                         ->where('list_contacts.list_id', '=', $listId);
                })
                ->select('contacts.*')
                ->get();
    }


    /**
     * This will get the lists  of the specific user
     */
    public static function getLists() 
    {
        return List1::where('account_id', User::getUserAccount())->orderBy('id', 'DESC')->get(); 
    }

    /**
     *  This will get the total specific lists contacts
     */
    public static function getListTotalContact($listId) 
    {
        return  ListContact::where('list_id', $listId)->count();
    }

}
