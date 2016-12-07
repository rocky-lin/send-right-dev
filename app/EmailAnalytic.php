<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailAnalytic extends Model
{
  		protected $table = "email_analytics";    
       	protected $fillable = ['table_id', 'table_name', 'open', 'click_link', 'reply'];  
       	protected $hidden = [];

  		public static function createOrUpdateByCampaignId($emailAnalytic) 
        {

			//			print "<pre>";
			//			$emailAnalytic['table_id'] = 80;
			//			$emailAnalytic['table_name'] = 'campaigns';
			//				print_r($emailAnalytic);

			//			print "</pre>";
       		if(!self::where('table_name', $emailAnalytic['table_name'])->where('table_id',$emailAnalytic['table_id'])->update($emailAnalytic)) {
   				self::create($emailAnalytic);   
       		}

			//			if(!self::where([['table_name', '=', 'newsletters'],['table_id', '=', $emailAnalytic['table_id']]])->update($emailAnalytic)) {
			//				self::create($emailAnalytic);
			//			}
		}
}

      