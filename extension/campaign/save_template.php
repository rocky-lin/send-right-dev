<?php
session_start(); 
require_once('includes.php');
include_once 'includes/db.class.php';  
$db = new Db(); 
$UserId=$_SESSION["UserId"];
$name = $_POST['name'];
$content = htmlentities($_POST['content']); 
$result = $db -> insert( $name, $content,$UserId); 
// insert to send right database
 App\Campaign::create(
  	[
  		'title'=>$_POST['name'], 
  		'account_id'=>$_SESSION['account_id'], 
  		'sender_name' => 'Jesus Erwin Suarez',
  		'sender_email' => 'mrjesuserwinsuarez@gmail.com',
  		'sender_subject' => 'This is my first campaign',
  		'content' =>htmlentities($_POST['content']),
  		'type' => 'schedule',
  		'status' => 'active',
  	]
  );
 
if ($result) {
  echo 'ok';
}else {
   echo 'error';
} 
?>
