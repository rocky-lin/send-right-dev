<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutoResponseDetails extends Model
{
    protected $table = 'auto_response_details';

    protected $fillable = [
        'auto_response_id',
        'table_name',
        'table_id',
        'status',
    ];

    protected $hidden = [];

    public function autoResponse()
    {
        return $this->belongsTo('App\AutoResponse', 'auto_respnse_id');
    }
}
