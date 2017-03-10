<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListContact extends Model
{
    
    protected $table = 'list_contacts'; 

    protected $fillable = ['list_id', 'contact_id'];
 
    /** 
     *  List contact belong to a list
     */
    public function list1() 
    {
    	return $this->belongsTo('App\List1');
    }  

    /** 
     *  List contact belong to a contact
     */
    public function contact() 
    {
    	return $this->belongsTo('App\Contact');
    }

    public static function getStrName($lists=array())
    {   


        $listStr = '';  
        foreach($lists as $list) {  
            $listInfo  = List1::find($list->list_id);  
            if(!empty($listInfo)) {  
                $listStr .= $listInfo->name . ',';  
            } 
        }   
 
        return rtrim($listStr,","); 
    } 

}
