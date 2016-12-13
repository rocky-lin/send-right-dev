<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterSendToTable extends Model
{
    protected $table = 'newsletter_send_to_tables';
    protected $fillable = ['newsletter_id', 'table_name', 'table_id'];
    protected $hidden = [''];
 
    public function newsletterSendToTables()
    {
    	return $this->belongsTo('App\Newsletter'); 
    }
}
