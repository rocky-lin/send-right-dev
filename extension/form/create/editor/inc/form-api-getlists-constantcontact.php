<?php
/**********************************************************************************
 * Contact Form Generator is (c) Top Studio
 * It is strictly forbidden to use or copy all or part of an element other than for your 
 * own personal and private use without prior written consent from Top Studio http://topstudiodev.com
 * Copies or reproductions are strictly reserved for the private use of the person 
 * making the copy and not intended for a collective use.
 *********************************************************************************/

// We do NOT include sessionpath.php: it is already included in form-api-getlists.php
// To include sessionpath.php would generate: A session had already been started - ignoring session_start() in \inc\sessionpath.php

if(session_id() === ''){

	session_start();
	
	include('../class/class.contactformeditor.php');
	
	$contactformeditor_obj = new contactFormEditor();
	
	$cfgenwp_config = $contactformeditor_obj->includeConfig();
	
	$contactformeditor_obj->authentication(true);
}


include('../api/Ctct/autoload.php');

$cc = new Ctct\ConstantContact($post_api['apikey']);
//var_dump($cc);

try{
	$api_lists_res[0] = $cc->getLists($post_api['accesstoken']);
	
	// var_dump($api_lists_res);
	
	$api_config[0]['account_id'] = $post_api['apikey']; // Account information is not available in the API and getVerifiedEmailAddresses only returns the email addresses of the account
		
	$api_config[0]['account_name'] = '';
	
} catch(Exception $e){

	$cfgenwp_service = $cfgenwpapi_editor_obj->service['constantcontact'];

	//print_r($e->getErrors());
	
	foreach($e->getErrors() as $cc_error){
	
		if($cc_error['error_key'] == 'mashery.not.authorized.inactive'){
		
			$error_title = $cfgenwpapi_editor_obj->getServiceName($post_api['id']);
			$error_text = $cfgenwp_service['error']['apikey'];
			break;
		}
		
		if($cc_error['error_key'] == 'http.status.authentication.invalid_token'){
		
			$error_title = $cfgenwpapi_editor_obj->getServiceName($post_api['id']);
			$error_text = $cfgenwp_service['error']['accesstoken'];
			break;
		}
	}
}
?>