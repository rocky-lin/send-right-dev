<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignTemplate extends Model
{

    protected $table = 'campaign_templates'; 

    protected $fillable = ['name', 'type', 'content' ];    
    
}
