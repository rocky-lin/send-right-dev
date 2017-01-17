<?php 
if(!session_id()){
	session_start(); 
}

$error = ''; 

// print "<pre>";  

// print_r($_REQUEST);

// print "</pre>"; 


if(!$error .= checkStringValidation($_REQUEST['optin_url'], 'optin url')) {
	$error .= checkIfEmpty($_REQUEST['optin_url'], 'optin url'); 
}  
$error .= checkIfEmpty($_REQUEST['optin_email_subject'], 'OptIn Email Subject'); 
$error .= checkIfEmpty($_REQUEST['optin_email_content'], 'OptIn Email Content'); 
$error .= checkIfEmpty($_REQUEST['optin_email_to_name'], 'OptIn Receiver Name'); 
$error .= checkIfEmpty($_REQUEST['optin_email_to_mail'], 'OptIn Receiver Email'); 
// $error .= checkIfEmpty($_REQUEST['optin_popup_link'], 'optin popup link'); 

 
if(empty($error)){
	$_SESSION['campaign']['optin']['url'] 		    = $_REQUEST['optin_url'];
	$_SESSION['campaign']['optin']['email_subject'] = $_REQUEST['optin_email_subject'];
	$_SESSION['campaign']['optin']['email_content'] = $_REQUEST['optin_email_content'];
	$_SESSION['campaign']['optin']['email_to_name'] = $_REQUEST['optin_email_to_name'];
	$_SESSION['campaign']['optin']['email_to_mail'] = $_REQUEST['optin_email_to_mail'];
	$_SESSION['campaign']['optin']['popup_link']	 = $_REQUEST['optin_popup_link'];
	$_SESSION['campaign']['optin']['status']	     = 'success'; 
} else {
	$_SESSION['campaign']['optin']['status']	     = 'failed'; 
	print $error;
} 

 
function checkIfEmpty($value, $name) 
{
	if(empty($value)) {
		return  $name . ' is required' . ".<br>"; 
	} else {
		return ''; 
	} 
}

function checkStringValidation($value, $name)
{  
	$error1 = '';  
	$spacePos = strpos($value, ' '); 
	// print " spos". $spacePos;
	if($spacePos > 0) {
		return "Please don't add space in " . $name . ".<br>"; 
	}  else {
		return false; 
	} 
}

if($_SESSION['campaign']['optin']['status'] == 'success') {
	print "Optin Settings saved successfully"  ; 
} 