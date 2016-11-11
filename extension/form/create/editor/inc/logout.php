<?php
/**********************************************************************************
 * Contact Form Generator is (c) Top Studio
 * It is strictly forbidden to use or copy all or part of an element other than for your 
 * own personal and private use without prior written consent from Top Studio http://topstudiodev.com
 * Copies or reproductions are strictly reserved for the private use of the person 
 * making the copy and not intended for a collective use.
 *********************************************************************************/

include('sessionpath.php');

include('../class/class.contactformeditor.php');
$contactformeditor_obj = new contactFormEditor();

if(isset($_SESSION['user'])){
	unset($_SESSION['user']);
}


if(isset($_COOKIE['user'])){
	$contactformeditor_obj->deleteUserCookie();
}


header('Location: ../../index.php');
exit;

?>