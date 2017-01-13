#!/usr/bin/php -q
<?php   

$dateTimeNow = date("Y-m-d h:i:s");  
$activateEmailCampaign = true;

if($_SERVER['SERVER_NAME'] == 'localhost')  {
	require ('E:/xampp/htdocs/rocky/send-right-dev/extension/custom_database/Database.php');
	$database = new Database('root' , '1234567890'  , 'rocky_sendright');  
} else {
	require ('/home/iamroc5/public_html/sendright/extension/custom_database/Database.php');
	$database = new Database('iamroc5_rocky123' , 'SehmVz_~RNIO'  , 'iamroc5_sendright');  
} 

if($activateEmailCampaign) 
{  
	$sock = fopen ("php://stdin", 'r');
	$email = ''; 
	//Read e-mail into buffer
	while (!feof($sock))
	{
	    $email .= fread($sock, 1024);
	} 
	//Close socket
	fclose($sock); 
	//Assumes $email contains the contents of the e-mail
	//When the script is done, $subject, $to, $message, and $from all contain appropriate values 
	$subject1 = explode ("\nSubject: ", $email);
	$subject2 = explode ("\n", $subject1[1]);
	$subject = $subject2[0]; 
	$to1 = explode ("\nTo: ", $email);
	$to2 = explode ("\n", $to1[1]);
	$to = str_replace ('>', '', str_replace('<', '', $to2[0])); 
	$message1 = explode ("\n\n", $email); 
	$start = count ($message1) - 3; 
	if ($start < 1)
	{
	    $start = 1;
	} 
	//Parse "message"
	$message2 = explode ("\n\n", $message1[$start]);
	$message = $message2[0]; 
	//Parse "from"
	$from1 = explode ("\nFrom: ", $email);
	$from2 = explode ("\n", $from1[1]); 
	if(strpos ($from2[0], '<') !== false)
	{
	    $from3 = explode ('<', $from2[0]);
	    $from4 = explode ('>', $from3[1]);
	    $from = $from4[0];  

	    $fromIndex0 = $from2[0]; 
	    $fromName = $from3[0];  
	}
	else
	{
	    $from = $from2[0];
	}   
   
	// recent sent email record to a file
	$myfile = fopen("/home/iamroc5/public_html/sendright/tests/newfile.txt", "w") or die("Unable to open file(filename)!");
	$txt = " delivered 1 to    $to  email subject  $subject   from   $from  fromindex0 $fromIndex0 from name $fromName   \n email $email   message \n\n\n $message  ";
	fwrite($myfile, $txt); 
	fclose($myfile);
}

  
// $to 	  = 'jesus@sendright.net'; 
// $from     = 'francis123@gmail.com'; 
// $fromName = 'Francis Suarez';
 
// $toCampaign = 'new-mobile-optin-test-1@sendright.net';  // to@domain.com
$toCampaign = convertToCampaignTitle($to); 
$first_name =  getFirstName($fromName) ;
$last_name  = getLastName($fromName); 
 
// separate first name and lastname 
// check to email and get what is the account id

print "<br> campaign title <br>" . $toCampaign . '<br>';
$database->select('campaigns', '*',   null, " title = '$toCampaign'" ); 
$results = $database->getResult();  

if(count($results) > 0) {  
	$account_id   = $results[0]['account_id']; 
	$campaign_id  = $results[0]['id']; 
	$status	      = $results[0]['status']; 
  	 
	if($status == 'active')  {  
		// check contact if already exist for the specific account
		 $database->select('contacts', '*',   null, "email = '$from' and account_id = $account_id" );  
		 $contact = $database->getResult();  
		  
		// if contact is not exist then do insert new contact
		 if(count($contact) < 1) { 
		 	 print "<br> not exist and do insert";   
			$rseponse = $database->insert('contacts', [
					'account_id' => $account_id,
			      	'first_name' => $first_name,
					'last_name' => $last_name,
					'email' => $from,
					'type'=>'subscriber',
					'history' => 'added from mobile optin, email sent',
					'created_at' =>$dateTimeNow,
					'updated_at'=>$dateTimeNow, 
			]);      
			$contact  = $database->getResult();
			print_r_pre($contact); 
			$contact_id = $contact[0];  	

		} else { 
			$database->select('contacts', 'id',   null, "email = '$from' and account_id = $account_id" ); 
		 	$contact 	= $database->getResult();   
			$contact_id = $contact[0]['id'];  	
			print "<br> contact exist, not do insert"; 

		}
		  
		// get contact id, the recent added or the 1 new registered  
		print "<br> newly inserted contact id $contact_id under account id $account_id";  
		// get campaign list ids
		$database->select('campaign_lists', '*',   null, "campaign_id = $campaign_id" ); 
		$campaign_lists = $database->getResult(); 
		  

		// check if the contact is already added to the list 
		foreach ($campaign_lists as $campaign_list) {  
			$list_id = $campaign_list['list_id']; 
			 // check if exist list id and contact id in list_contacts table 
			$database->select('list_contacts', '*', null, " list_id = $list_id and contact_id = $contact_id");  
			$list_contact = $database->getResult();    
			 
			// if not exist list id and contact id in list_contacts table then do insert
			if(count($list_contact) < 1) { 
				print "<br> insert list to list_contacts id $list_id and contact id $contact_id ";  
				$database->insert('list_contacts', 
					[
						'list_id' => $list_id,
						'contact_id' => $contact_id,
						'created_at' =>$dateTimeNow,
						'updated_at'=>$dateTimeNow, 
					]
				); 
				  
			} else {
				print "<br> exist not insert to list_contacts list id $list_id and contact id $contact_id "; 
			} 
			$database->clearResult();
		}    
		 print "<br> account id $account_id  campaign id $campaign_id contact id  $contact_id ";
		// contact add or update to the specific list
		  
		// set activity 
		// addActivities($database, [
	 //      	'account_id' =>1,
		// 	'table_name' =>'email',
		// 	'table_id' =>1,
		// 	'action' =>"email optin new entry from $fromName  email $from ", 
		// 	'created_at' =>$dateTimeNow,
		// 	'updated_at'=>$dateTimeNow, 
		// ]);
	} // end if is active
	else { 
		print "<br> current campaign is in active, please turn to active so that we can start adding contact to it.";  
	}

	addActivities($database, [
      	'account_id' =>$account_id,
		'table_name' =>'email',
		'table_id' =>1,
		'action' =>"email optin new entry from $fromName  email $from", 
		'created_at' =>$dateTimeNow,
		'updated_at'=>$dateTimeNow, 
	]); 
} 
// check if found a campaign 
else {

	print "<br> campaign not found";
}

function print_r_pre($response) 
{
	print "<pre>";
		print_r($response);
	print "</pre>";  
}  
function getFirstName($fullName)
{
	$fullNameArr = explode(' ', $fullName);  
	if (count($fullNameArr) > 2) { 
		$firstName = '';
		for ($i=0; $i <count($fullNameArr)-1 ; $i++) { 
			$firstName .= $fullNameArr[$i] . ' '; 
		}  
		return $firstName;
	} else if (count($fullNameArr) == 2) {
		return $fullNameArr[0];
	} else {
		 return $fullName;
	} 
}
function getLastName($fullName)
{
	$fullNameArr = explode(' ', $fullName);  
	if (count($fullNameArr) > 2) {  
		return $fullNameArr[count($fullNameArr)-1];
	} else if (count($fullNameArr) == 2) {
		return $fullNameArr[1];
	} else {
		 return '';
	} 
} 
function convertToCampaignTitle($toMail)
{
	$campaignTitle = str_replace('-', ' ', $toMail); 
	$campaignTitle = str_replace('@sendright.net', '', $campaignTitle); 
	return $campaignTitle; 
}
function addActivities($database, $activities=[])
{
	$database->insert(
      	'activities', 
      	$activities
	);
}
  