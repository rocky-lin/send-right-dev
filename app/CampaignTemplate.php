<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignTemplate extends Model
{

    protected $table = 'campaign_templates'; 

    protected $fillable = ['account_id', 'name', 'category', 'type', 'content' ];	


    public static function getSpecificTemplateByCampaignType($type)
    {
        if($type == 'mobile email optin') {
            return self::where('type', $type)->orWhere(['id'=>2, 'type'=>'all'])->get(); // index 2 is the default template for mobile optin
        } else {
            return self::where('type', $type)->orWhere(['id'=>1, 'type'=>'all'])->get(); // index 1 is the default template for campaign and newsletter
        }
    }
    
}
