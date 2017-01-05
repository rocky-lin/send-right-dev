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
        'email',
        'mobile_number'
    ];
    
    protected $hidden = []; 
    public function autoResponse()
    {
        return $this->belongsTo('App\AutoResponse');
    } 

    public static function getActiveAutoResponsesDetails()
    { 
        return  self::where('status', 'active')->get();  
    }
}
