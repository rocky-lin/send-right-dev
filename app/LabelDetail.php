<?php

namespace App;

use Illuminate\Database\Eloquent\Model; 

class LabelDetail extends Model
{
    protected $table = 'label_details'; 
    protected $fillable = ['label_id', 'table_id', 'table_name']; 

    public function label() 
    {
    	return $this->belongsTo('App\Label'); 
    }
}
