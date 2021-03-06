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

    public function campaignList(){
        return $this->hasMany('App\CampaignList', 'list_id', 'id');
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


    public static function getAllLists($limit=100) 
    {
        return self::where('account_id', User::getUserAccount())->limit($limit)->orderBy('id', 'desc')->get();
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


    public static function getListIdByListName($listName) 
    { 
        // print_r($listName);
        
        $list = self::where('name', $listName)->first();

        return $list->id;
    }


    public static function getListIdsToArray($listIds) 
    {

        // print "list id " . $listId; 
        // exit; 
        $listIds      = str_replace('[', '', $listIds);
        $listIds      = str_replace(']', '', $listIds);
        $listIdsArray = explode(',', $listIds); 
        // print_r($listIdsArray); 
        // exit;  
        return $listIdsArray;
    }
    public static function getListNamesByListIds($listIds)
    { 
        $listIds      = str_replace('[', '', $listIds);
        $listIds      = str_replace(']', '', $listIds);
        $listIdsArray = explode(',', $listIds);
        $listNameStr  = '';
        $i=0;
 

        foreach($listIdsArray as $id) {
            if($id > 0) {
                $listNameStr .= self::find($id)->name; 
                if($i < count($listIdsArray)-1) {
                    $listNameStr .= ',';

                }
            }
            $i++;
        }
        // self::find()
        // rint $listIds;
        return $listNameStr;
    }
    public static function getCurrentCampaignListNames()
    {  
        return self::getListNamesByListIds($_SESSION['campaign']['listIds']);
    }

    public static function getTotalContactsInSpecificListById($list_id)
    {
        $response = DB::table('list_contacts')->where('list_id', $list_id)->count('id');

        return $response;
    }

    /**
     * list response conver to id as string 
     * ex: 1,2,3,4,5,5,6,7,8 <-- all of them are list ids
     * [toStr description]
     * @param  array  $lists [description]
     * @return [type]        [description]
     */
    public static function toStr($lists=array())
    {  
        $listStr = '';  
        foreach($lists as $list) { 
            $listStr .= $list->id . ',';  
        }  
        return rtrim($listStr,","); 
    } 
    /**
     *
     * parameter is from database query get related list of specific database info
     * this will return format as list1,list2,list3
     * [getStrName description]
     * @param  array  $lists [description]
     * @return [type]        [description]
     */
    public static function getStrName($lists=array())
    {   


        $listStr = '';  
        foreach($lists as $list) {  
            $listInfo  = List1::find($list->id);  
            if(!empty($listInfo)) {  
                $listStr .= $listInfo->name . ',';  
            } 
        }   
 
        return rtrim($listStr,","); 
    } 



}


