<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';  
    protected $fillable = ['account_id', 'table_name', 'table_id', 'action'];
    protected $hidden = []; 
}
