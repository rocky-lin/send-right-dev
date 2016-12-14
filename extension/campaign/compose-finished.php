<?php  
	session_start();

	// require the laravel functions
	require_once('includes.php');

	// call the campaign model class
	use App\Campaign; 
	use App\CampaignSchedule;
	use App\EmailAnalytic;
	use App\CampaignList;
	use Carbon\Carbon;


	// pass the content from compose via post request to session
	// content will be saved automatically to database
	$_SESSION['campaign']['content'] = $_POST['content'];  
 
	// check if the post request has campaign id and if exist, 
	// prepare execute the update campaign and other part campaign related tables
	if(!empty($_POST['id'])) 
	{   
		
		$campaign = [
			'id'=> $_POST['id'], 
			'account_id'=>$_SESSION['account_id'],  
			'content' =>htmlentities($_SESSION['campaign']['content']) 
		];  
 
	    // execute update
		$_SESSION['campaign']['id'] = Campaign::createOrUpdateByCampaignId($campaign);
 		
 		// set edit values to session
		Campaign::setDefaultValueToSession($_POST['id']);  
    } 

	// after checking the campaign id and if not found, 
	// prepare execute the update campaign and to its related tables
	else {
		


		// print "<pre>"; 
		// print "test"; 
		// print_R(  $_SESSION['campaign']['listIds']);  
	 	// $campaignList['campaign_lists'] = Campaign::stringListIdsToArray($_SESSION['campaign']['listIds']); 
 	// print "done";
		// print_r($listArry);
		// print "</pre>"; 
		// $campaignList['campaign_lists'] = $_SESSION['campaign']['listIds']; 
		// $campaignList['campaign_id'] = 11;
 
		// CampaignList::createOrUpdateByCampaignId(['campaign_lists'=>, 'campaign_id'=>11]);

		// exit; 	
		// prepare campaign details
		// 
		 
		if($_SESSION['campaign']['kind'] == 'auto responder') {
			$repeat = 'Response All Time'; 
		} else {
			$repeat = 'One Time'; 
		}




		$campaign = [ 
			'id'=>$_POST['id'],
			'title'=>$_SESSION['campaign']['name'],
			'account_id'=>$_SESSION['account_id'],
			'sender_name' => $_SESSION['campaign']['sender']['name'],
			'sender_email' => $_SESSION['campaign']['sender']['email'],
			'sender_subject' => $_SESSION['campaign']['sender']['subject'],
			'content' =>htmlentities($_SESSION['campaign']['content']),
			'type' => ($_SESSION['campaign']['kind'] == 'auto responder') ? 'immediate response' : 'schedule send',   
			'kind' =>  $_SESSION['campaign']['kind'],
			'status' => 'inactive'
		];  

	    // execute insert campaign
		$_SESSION['campaign']['id'] = Campaign::createOrUpdateByCampaignId($campaign);
 
		// insert campaign schedule 
		CampaignSchedule::create(['campaign_id'=>$_SESSION['campaign']['id'], 'schedule_send'=>Carbon::now(), 'repeat'=>$repeat]);
 
		// insert email analytic
		EmailAnalytic::create(['table_name'=>'campaigns', 'table_id'=>$_SESSION['campaign']['id']]);

		// insert list
		CampaignList::createOrUpdateByCampaignId(['campaign_lists'=>$_SESSION['campaign']['listIds'], 'campaign_id'=>$_SESSION['campaign']['id']]);
 		 
		// set campaign session to empty because campaign is just created
		Campaign::setDefaultValueToSessionClear($_SESSION['campaign']['id']);  


	} 

	// the "ok" or "not ok" status will trigger the next page or redirect to settings. 
	// If success insert or update settings, else do nothing and show error if not success
	if($_SESSION['campaign']['id']) {
		print "Ok";
	} else {
		print "Not Ok";
	}