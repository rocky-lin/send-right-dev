<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
  	protected $table = 'reports';
 	protected $fillable = [
 		'account_id', 
		'campaign_id', 
		'total_send', 
		'total_arrival', 
		'total_open', 
		'total_click', 
		'total_unsubscribe_complain', 
		'total_arrival_rate', 
		'total_open_rate', 
		'total_click_rate', 
		'total_unsubscribe_complain_rate' 
 	]; 
}
