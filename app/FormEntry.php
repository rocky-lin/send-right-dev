<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormEntry extends Model
{ 
	protected $table = 'form_entries';  
	protected $fillable = ['form_id', 'content'];  
	protected $hidden = ['form_id']; 


	public function form() {
		return belongsTo('App\Form'); 
	} 
	
}
