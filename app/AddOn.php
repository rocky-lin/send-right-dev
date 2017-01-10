<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class AddOn extends Model
{
    protected $fillable = ['account_id', 'name'];

    public function account(){
        $this->belongsTo('App\Account');
    }

    public static function isHasMobileOptIn()
    {
        return self::where('account_id', User::getUserAccount())->where('name', 'email mobile opt in')->get()->count();
    }
}
