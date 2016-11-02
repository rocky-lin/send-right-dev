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
        'name', 'email', 'password', 'registration_token',
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
 
    public function user_account() { 
        return $this->hasOne('App\UserAccount');
    } 
    public static function getUserAccount() {
        return self::find(Auth::user()->id)->user_account->account->id; 
    } 

    public static function getUserAccountContacts() {
        return self::find(Auth::user()->id)->user_account->account->contacts;
    }

    public function routeNotificationForSlack() {
        // https://hooks.slack.com/services/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 - #payments
        // https://hooks.slack.com/services/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 - #jesus143
        return 'https://hooks.slack.com/services/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'; 


 
    }
}
