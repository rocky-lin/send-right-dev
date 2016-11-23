<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormList extends Model
{ 
    protected $table = 'form_lists'; 

    protected $fillable = ['folder_name', 'form_id', 'list_id']; 

    protected $hidden = []; 

    /** 
     * Form lists belong to a list
     */
    public function list1() 
    {
    	return $this->belongsTo('App\List1'); 
    }   
    
    /** 
     * Form lists belongs to form
     */
    public function form() 
    {
    	return $this->belongsTo('App\Form'); 
    }  
}
