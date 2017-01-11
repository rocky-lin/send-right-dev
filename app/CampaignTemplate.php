<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignTemplate extends Model
{

    protected $table = 'campaign_templates'; 

    protected $fillable = ['account_id', 'name', 'category', 'type', 'content' ];	

    public static function getSpecificTemplateByCampaignType($type)
    {
    	// print "type $type";
    	return self::where('type', $type)->get(); 
    }
    
}
