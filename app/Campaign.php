<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use db;
use Auth;
use App\User;
use App\Account;

class Campaign   extends Model
{

    protected $table = "campaigns";

    protected $fillable = [
        'account_id',
        'sender_name',
        'sender_email',
        'sender_subject',
        'title',
        'content',
        'type',
        'status',
        'type'
    ];

    protected $hidden = [];

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public static function getCampaignsByAccount()
    {
        return Account::find(User::getUserAccount())->campaigns;
    }

}
