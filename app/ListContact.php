<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListContact extends Model
{
    protected $table = 'list_contacts'; 
    protected $fillable = ['list_id', 'contact_id'];

    public function list1() 
    {
    	return $this->belongsTo('App\List1');
    }  

    public function contact() 
    {
    	return $this->belongsTo('App\Contact');
    }
}
