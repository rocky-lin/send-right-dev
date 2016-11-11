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

include('../sourcecontainer/'.$contactformeditor_obj->dir_form_inc.'/class/class.form.php');
$contactform_obj = new contactForm($cfg=array());

// only possible when not using the demo
if($contactform_obj->demo != 1)
{
	
	$cfgenwp_config['account']['login'] = trim($contactformeditor_obj->quote_smart($_POST['user-login']));
	
	$length_login_min = 2;
	$length_login_max = 30;
	
	if(!preg_match('#^[a-z0-9]{'.$length_login_min.','.$length_login_max.'}$#i', $cfgenwp_config['account']['login'])){
		$_SESSION['error'][] = 'Please enter a valid username with letters and numbers only ('.$length_login_min.' characters min, '.$length_login_max.' characters max)';
	}
	
	
	$pwd1 = $cfgenwp_config['account']['password'] = $contactformeditor_obj->quote_smart($_POST['user-password-1']);
	$pwd2 = $contactformeditor_obj->quote_smart($_POST['user-password-2']);
	
	if(!$pwd1 && !$pwd2){
		$_SESSION['error'][] = 'Please enter a password';
	} else{
		
		$length_pwd_min = 4;
		
		if($pwd1){
			if(strlen($pwd1) < $length_pwd_min){
				$_SESSION['error'][] = 'Your password must be at least '.$length_pwd_min.' characters long';
			}
		}
			
		if($pwd1 != $pwd2){
			$_SESSION['error'][] = 'Please enter the same password in the two password fields';
		}
	}
	
	if(isset($_SESSION['error']) && $_SESSION['error']){
		header('Location: ../../index.php');
		exit;
	}
	
	$cfgenwp_config['account']['password'] = sha1($cfgenwp_config['account']['password']);

	$cfgenwp_fopen = @fopen($contactformeditor_obj->config_filename_path, 'w+');
 
	$cfgenwp_content_write = '<?php'."\r\n";
	
	foreach($cfgenwp_config as $cfgenwp_config_k=>$cfgenwp_config_v){
		
		if(!isset($cfgenwp_previous_k) || $cfgenwp_config_k != $cfgenwp_previous_k){
			$cfgenwp_previous_k = $cfgenwp_config_k;
			$cfgenwp_content_write .= "\r\n";
		}
		
		if(is_array($cfgenwp_config_v)){
			foreach($cfgenwp_config_v as $cfgenwp_config_vk=>$cfgenwp_config_vv){
				
				$cfgenwp_content_write .= '$cfgenwp_config[\''.$cfgenwp_config_k.'\'][\''.$cfgenwp_config_vk.'\'] = \''.addcslashes($cfgenwp_config_vv, "'").'\';'."\r\n";
			}
		} else{
			$cfgenwp_content_write .= '$cfgenwp_config[\''.$cfgenwp_config_k.'\'] = \''.addcslashes($cfgenwp_config_v, "'").'\';'."\r\n";
		}
	}
	
	$cfgenwp_content_write .= '?>'."\r\n";
	
	fwrite($cfgenwp_fopen, $cfgenwp_content_write);
	
	fclose($cfgenwp_fopen);
	
	
	// delete previously installed cookie (cookie installed / delete user.php / create account)
	if(isset($_COOKIE['user'])){
		$contactformeditor_obj->deleteUserCookie();
	}
	
	
	
	$_SESSION['validation'] = 'Your account has been successfully created. Please log in.';
	
	header('Location: ../../index.php');
	exit;
}

?>