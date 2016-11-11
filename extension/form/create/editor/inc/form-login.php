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

$cfgenwp_config = $contactformeditor_obj->includeConfig();


if(!isset($cfgenwp_config['account']['login']) || !isset($cfgenwp_config['account']['password'])){
	header('Location: ../../index.php');
	exit;
}

// VERIFY LOGIN AND PASSWORD
$post_login = trim($contactformeditor_obj->quote_smart($_POST['user-login']));

$post_pwd = sha1($contactformeditor_obj->quote_smart($_POST['user-password']));

if(sha1(trim($_POST['cr'])) != $contactformeditor_obj->cr_sha1){
	
	$_SESSION['error'][] = 'It seems you have changed or removed the original copyright notice.'
							.'<br><br>This software can only work with the Top Studio copyright notice.'
							.'<br><br>Restore the original notice or contact us by email on Code Canyon to solve this problem.';

} else if($post_login != $cfgenwp_config['account']['login'] || $post_pwd != $cfgenwp_config['account']['password']){
	$_SESSION['error'][] = 'Invalid password';
	
} else{

	$_SESSION['user'] = $cfgenwp_config['account']['login'];
	
	if(isset($_POST['rememberme']) && $_POST['rememberme'] == 1){
		
		$contactformeditor_obj->setUserCookie($cfgenwp_config);
	}
}

header('Location: ../../index.php');
exit;

?>