<?php
namespace App; 

use Illuminate\Database\Eloquent\Model; 

class Contact extends Model
{
    protected $table = "contacts";   

    protected $fillable = [ 'account_id', 'first_name', 'last_name', 'email', 'location', 'phone_number', 'telephone_number', 'type', 'history', 'status' ]; 

    /** 
     * Contact belongs to an account
     */
    public function account() 
    {
    	return $this->belongsTo('App\Account'); 
    }

}
