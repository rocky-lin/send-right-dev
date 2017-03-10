<?php

namespace App;

use Illuminate\Database\Eloquent\Model; 

class LabelDetail extends Model
{
    protected $table = 'label_details'; 
    protected $fillable = ['label_id', 'table_id']; 

    public function label() 
    {
    	return $this->belongsTo('App\Label'); 
    }
}
