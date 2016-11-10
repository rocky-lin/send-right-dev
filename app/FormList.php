<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormList extends Model
{ 
    protected $table = 'form_lists';  
    protected $fillable = []; 
    protected $hidden = []; 

    public function list1() {
    	return $this->belongsTo('App\List1'); 
    } 

    public function form() {
    	return $this->belongsTo('App\Form'); 
    } 
}
