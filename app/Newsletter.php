<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = 'newsletters';
    protected $fillable = ['account_id', 'content', 'status'];
    protected $hidden = [''];
 
    public function newsletterSendToTables()
    {
    	return $this->hasMany('App\NewsletterSendToTable', 'newsletter_id', 'id'); 
    }
}
