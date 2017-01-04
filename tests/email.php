#!/usr/bin/php -q
<?php 
 
if($_SERVER['SERVER_NAME'] == 'localhost')  {
	require ('E:/xampp/htdocs/rocky/send-right-dev/extension/custom_database/Database.php');
	$database = new Database('root' , '1234567890'  , 'rocky_sendright');  
} else {
	require ('/home/iamroc5/public_html/sendright/extension/custom_database/Database.php');
	$database = new Database('iamroc5_rocky123' , 'SehmVz_~RNIO'  , 'iamroc5_sendright');  
}
 
 
// use App\Activity; 

// $exitCode = Artisan::call('command:name', ['--option' => 'foo']);
 
//Listen to incoming e-mails
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

//Parse "subject"
$subject1 = explode ("\nSubject: ", $email);
$subject2 = explode ("\n", $subject1[1]);
$subject = $subject2[0];

//Parse "to"
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

// check to email and get what is the account id
 
// get specific lists for this specific mobipe optin
 
// check if the contact is already added to the list
  
// contact add or update to the specific list
 
 // set activity
$dateTimeNow = date("Y-m-d h:i:s");  
$database->insert(
      	'activities', 
      	[
	      	'account_id' =>1,
			'table_name' =>'email',
			'table_id' =>1,
			'action' =>"email optin new entry from $fromName  email $from ", 
			'created_at' =>$dateTimeNow,
			'updated_at'=>$dateTimeNow, 
		]
);


 
 
// recent sent email record to a file
$myfile = fopen("/home/iamroc5/public_html/sendright/tests/newfile.txt", "w") or die("Unable to open file(filename)!");
$txt = "1to    $to  email subject  $subject   from   $from  message  $message fromindex0 $fromIndex0 from name $fromName   \n email $email ";
fwrite($myfile, $txt); 
fclose($myfile);

exit; 