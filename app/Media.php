<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table_name = 'media';
    protected $hidden = [];
    protected $fillable = ['account_id', 'name', 'path'];
}
