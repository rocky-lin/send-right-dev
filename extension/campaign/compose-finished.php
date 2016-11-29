<?php  
session_start();  

require_once('includes.php'); 

$_SESSION['campaign']['content'] = $_POST['content'];
  
// use App\Campaign;
// $_SESSION['campaign']['template']
// $_SESSION['campaign']['name']
// $_SESSION['campaign']['list']
// $_SESSION['campaign']['sender']['name']
// $_SESSION['campaign']['sender']['email']
// $_SESSION['campaign']['sender']['subject'] 
 $isCreated = App\Campaign::create(
  	[
  		'title'=>$_SESSION['campaign']['name'], 
  		'account_id'=>$_SESSION['account_id'],  
  		'sender_name' => $_SESSION['campaign']['sender']['name'],
  		'sender_email' => $_SESSION['campaign']['sender']['email'],
  		'sender_subject' => $_SESSION['campaign']['sender']['subject'],
  		'content' =>htmlentities($_SESSION['campaign']['content']),
  		'type' => 'schedule',
  		'status' => 'active',
  	]
  );


if($isCreated) {
	print "Ok"; 
} else {
	print "Not Ok";
}


 // print "content " . $_POST['content'];