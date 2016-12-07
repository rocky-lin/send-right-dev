<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
use App\List1;  
use App\Campaign;

class CampaignList extends Model
{
 	protected $table = 'campaign_lists'; 
 	protected $fillable = ['campaign_id', 'list_id']; 
 	protected $hidden = [];


	public function list1() {
		return $this->belongsTo('App\List1', 'list_id', 'id');
	}

 	public static function createOrUpdateByCampaignId($campaignList=[])
 	{  
 		// dd($campaignList);
 
 		$listIdArry = List1::getListIdsToArray($campaignList['campaign_lists']); 
  
 		if(campaignList::where('campaign_id', $campaignList['campaign_id'])->count() > 0) { 
 	    	campaignList::where('campaign_id', $campaignList['campaign_id'])->delete();
 	    }

 		foreach ($listIdArry as $key => $list_id) 
 		{  


 			
 			if(!empty($list_id) and $list_id != null and  $list_id > 0 ) {  

 				// print " list id $list_id <br>";


 		     
				// note: This needs to be an array 
		 	    // get specific list id by list name
		     	// $list_id = List1::getListIdByListName($list_id);  
				// print_r($campaignList);
		 		// 	exit; 
		     	// insert new list for campaign 
		        self::create(['list_id'=>$list_id,  'campaign_id'=>$campaignList['campaign_id']]); 	 
	     	}
 		}  

 
 		return true; 
 		// exit;  
 	}

 	 




}
