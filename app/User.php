<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
 
    // public function routeNotificationForMail()
    // {
    //     return $this->email_address;
    // }
    

    // function __construct() {
    //     print "test";
    // }



    /**
     *  user has one user account
     */
    public function user_account() 
    { 
        return $this->hasOne('App\UserAccount');
    } 
    
    /** 
     * this will return the users account id
     */
    public static function getUserAccount() 
    {
        return self::find(Auth::user()->id)->user_account->account->id; 
    } 

    /** 
     * This will get the users account forms
     */
    public static function getUserAccountForms() 
    {
        return self::find(Auth::user()->id)->user_account->account->forms->toArray();
    }

    /** 
     * This will get the users account contacts
     */
    public static function getUserAccountContacts() 
    {
        return self::find(Auth::user()->id)->user_account->account->contacts;
    }

    /** 
     * This will send a notification to slack
     */
    public function routeNotificationForSlack() 
    {
        // https://hooks.slack.com/services/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 - #payments
        // https://hooks.slack.com/services/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 - #jesus143
        return 'https://hooks.slack.com/services/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';  
    } 

    /** 
     * This will return users lists
     */
    public static function lists() 
    { 
        return 'users lists';
    }

    /** 
     * This will return the form lists
     */
    public static function formLists() 
    {
         return self::find(Auth::user()->id)->user_account->account->formLists;
    }  

    public static function updatePassword($password, $new_password=null, $old_password=null) 
    { 
        $status = self::find(Auth::user()->id)->update(['password'=>bcrypt($password)]); 
        if($status) {
            return true;
        } else {
            return false; 
        }
    }
    public static function isUserExist($email) 
    {
        $user = User::where('email', '=', $email)->first();
        if ($user === null) {
            return false; 
        } else {
            return true; 
        }
    } 
}
