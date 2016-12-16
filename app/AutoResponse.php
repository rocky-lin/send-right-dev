<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class autoResponse extends Model
{
    protected $table = 'auto_responses';
    protected $fillable = ['campaign_id','table_name', 'table_id'];
    protected $hidden = [];

    public function autoResponseDetails()
    {
        return $this->hasMany('App\AutoResponseDetails', 'autoResponse_id', 'id');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }
}
