<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
 	protected $table = 'labels';  
 	
 	protected $fillable = ['type', 'name', 'account_id'];

 	public function labelDetails() 
 	{
 		return $this->hasMany('App\LabelDetail'); 
 	}
}
