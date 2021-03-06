<?php
namespace App; 

use Illuminate\Database\Eloquent\Model; 

class Contact extends Model
{
    protected $table = "contacts";   

    protected $fillable = [ 'account_id', 'first_name', 'last_name', 'email', 'location', 'phone_number', 'telephone_number', 'type', 'history', 'status' ]; 
 
    public function list_contacts()
    {
        return $this->hasMany('App\ListContact'); 
    } 
    
    /** 
     * Contact belongs to an account
     */
    public function account() 
    {
    	return $this->belongsTo('App\Account'); 
    }

    public static function setgetFilterValues($contact)
    {                
            // only execute this filter if not test send
            // if(count($contact['contact']) > 1) {        
                $contactFilterValues = [ 
                    '{{first_name}}'=>$contact['first_name'], 
                    '{{last_name}}'=>$contact['last_name'], 
                    '{{email}}'=>$contact['email'], 
                    '{{location}}'=>$contact['location'], 
                    '{{phone_number}}'=>$contact['phone_number'], 
                    '{{telephone_number}}'=>$contact['telephone_number'],
                    '{{unsubscribe}}' => "<br>Click <a href='". route('user.contact.unsubscribe', [$contact['id'], $contact['email']]) . "'> here </a> to unsubscribe from this email click <a href='".url('/')."'>here</a> to visit " . url('/') 
                ];   
                 // dd($contactFilterValues); 
                return $contactFilterValues;
        // }   
        // else {
        //     return $contact; 
        // }
    }


    public static function getAllContacts($limit=100) 
    {
        return self::where('account_id', User::getUserAccount())->limit($limit)->orderBy('id', 'desc')->get();
    }

    public static function countByStatus($status)
    {
        return self::where('status', $status)->count('id');
    }
}
