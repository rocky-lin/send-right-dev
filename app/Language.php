<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Language extends Model
{
    protected $fillable = ['name'];

    public static function setCurrentLanguage()
    {
        $language = self::getActiveLanguage();
        App::setLocale($language->name);
    }
    public static function getActiveLanguage()
    {
        return self::where('status', 'active')->get()->first();
    }

}
