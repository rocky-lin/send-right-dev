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

include('../class/class.ts.tools.php');
$topstudio_tools_obj = new TopStudio_Tools();

$cfgenwp_config = $contactformeditor_obj->includeConfig();

// AUTHENTICATION
if($contactformeditor_obj->demo != 1){
	
	if(isset($_POST['api_id'])){
	
		if(!isset($_SESSION['user']) || !$_SESSION['user']){
			
			$contactformeditor_obj->setSessionByCookie($cfgenwp_config['account']['login'], $cfgenwp_config['account']['password']);
			
			// no session['user'] after cookie check?
			if(!isset($_SESSION['user']) || !$_SESSION['user']){
				
				$json_message = array('error'=>$contactformeditor_obj->error_message['session_expired']);
				
				echo json_encode($json_message);
				
				exit;
			}
		}
		
	} else{
		$contactformeditor_obj->authentication(true);
	}
}


include('../class/class.cfgenwp.api.editor.php');
$cfgenwpapi_editor_obj = new cfgenwpApiEditor();


$_SESSION['select_container_i'] = 1;

function consolidateList($api_listfields_res, $api_config, $sort=true){
	
	$array_to_sort = array(); // array that will be sorted on fields id to display the fields in alphabetical order
	
	$field_data = array(); // to retrieve the field data after sorting
	
	foreach($api_listfields_res as $api_listfields_res_v){
		$array_to_sort[$api_listfields_res_v['id']] = $api_listfields_res_v['name'];
		
		$field_data[$api_listfields_res_v['id']] = $api_listfields_res_v;
	}

	if($sort){
		natcasesort($array_to_sort);
	}

	$j = 0;
	
	foreach($array_to_sort as $field_id => $field_name){
		
		$api_config['fields'][$j]['id'] = $field_id;

		$api_config['fields'][$j]['required'] = isset($field_data[$field_id]['required']) ? $field_data[$field_id]['required'] : '';

		$api_config['fields'][$j]['name'] = $field_name;
		
		$api_config['fields'][$j]['type'] = isset($field_data[$field_id]['type']) ? $field_data[$field_id]['type'] : '';

		$j++;
	}

	return $api_config;	
}

function sortArrayByName($a, $b){
	global $topstudio_tools_obj;
	return $topstudio_tools_obj->sortArrayBy($a, $b, 'name');
}

// print_r($_POST);exit;

$error_title = '';
$error_text = '';
$html = '';


$post_api['id'] = (isset($_POST['api_id']) && trim($_POST['api_id'])) ? trim($_POST['api_id']) : '';
$post_api['apikey'] = (isset($_POST['apikey']) && trim($_POST['apikey'])) ? trim($_POST['apikey']) : '';
$post_api['authorizationcode'] = (isset($_POST['authorizationcode']) && trim($_POST['authorizationcode'])) ? trim($_POST['authorizationcode']) : '';
$post_api['accesstoken'] = (isset($_POST['accesstoken']) && trim($_POST['accesstoken'])) ? trim($_POST['accesstoken']) : '';
$post_api['username'] = (isset($_POST['username']) && trim($_POST['username'])) ? trim($_POST['username']) : '';
$post_api['password'] = (isset($_POST['password']) && $_POST['password']) ? $_POST['password'] : '';
$post_api['applicationpassword'] = (isset($_POST['applicationpassword']) && $_POST['applicationpassword']) ? $_POST['applicationpassword'] : '';

/* aweber */
$post_api['consumerkey'] = (isset($_POST['consumerkey']) && trim($_POST['consumerkey'])) ? trim($_POST['consumerkey']) : '';
$post_api['consumersecret'] = (isset($_POST['consumersecret']) && trim($_POST['consumersecret'])) ? trim($_POST['consumersecret']) : '';
$post_api['accesstokenkey'] = (isset($_POST['accesstokenkey']) && trim($_POST['accesstokenkey'])) ? trim($_POST['accesstokenkey']) : '';
$post_api['accesstokensecret'] = (isset($_POST['accesstokensecret']) && trim($_POST['accesstokensecret'])) ? trim($_POST['accesstokensecret']) : '';


$api_config = array();


$api_lists_res = '';

$api_listfields_res = '';

$required_field = '<span class="cfgenwp-api-list-required-field">*</span>';

$cfgenwp_service = $cfgenwpapi_editor_obj->service[$post_api['id']];

// ERROR : empty credentials
foreach($cfgenwp_service['credentials'] as $cfgenwp_api_credential_k=>$cfgenwp_api_credential_v){
	
	$break = true;
	
	if(!$post_api[$cfgenwp_api_credential_k]){
	
		$error_title = $cfgenwpapi_editor_obj->getServiceName($post_api['id']);
		$error_text = 'You must enter a valid '.strtolower($cfgenwp_api_credential_v['label']).'.';
		
		if($post_api['id'] == 'aweber' && $cfgenwp_api_credential_k == 'authorizationcode' && $post_api['consumerkey']){
			// When loading a form that includes an aweber list, it prevents throwing up an error on empty authorization code
			$error_title = '';
			$error_text = '';
			$break = false;
		}

		if($break){
			break;
		}
	}
}


$html = '';
$html_res_type = '';
$load_selected_formelement = '';


if(!$error_text){

/*******************************************************
 * AWEBER API
 *******************************************************/
if($post_api['id'] == 'aweber'){


	include('../api/aweber/aweber_api.php');
	
	try{
		if($post_api['authorizationcode']){
			$aweber['auth'] = AWeberAPI::getDataFromAweberID($post_api['authorizationcode']);

			$aweber['consumerkey'] = $aweber['auth'][0];
			$aweber['consumersecret'] = $aweber['auth'][1];
			$aweber['accesstokenkey'] = $aweber['auth'][2];
			$aweber['accesstokensecret'] = $aweber['auth'][3];

		} else{
			$aweber['consumerkey'] = $post_api['consumerkey'];
			$aweber['consumersecret'] = $post_api['consumersecret'];
			$aweber['accesstokenkey'] = $post_api['accesstokenkey'];
			$aweber['accesstokensecret'] = $post_api['accesstokensecret'];
		}
	
	} catch(AWeberAPIException $e){
		$error_title = $cfgenwpapi_editor_obj->getServiceName($post_api['id']);
		$error_text = $cfgenwp_service['error']['authorizationcode'];
	}

	if(isset($aweber)){
	
		try{
			$aweber_api = new AWeberAPI($aweber['consumerkey'], $aweber['consumersecret']);
			
			$aweber_account = $aweber_api->getAccount($aweber['accesstokenkey'], $aweber['accesstokensecret']);
			//print_r($aweber_account);
		
			$aweber_account_id = $aweber_account->id;
			
			$api_config[0]['account_id'] = $aweber_account->data['id'];
				
			$api_config[0]['account_name'] = $aweber_account->data['id'];
			
			// LISTS
			$api_lists_res[0] = $aweber_account->loadFromUrl("/accounts/{$aweber_account->data['id']}/lists/");
	
			$api_lists_res[0] = isset($api_lists_res[0]->data['entries']) ? $api_lists_res[0]->data['entries'] : array();
			
		} catch(AWeberAPIException $e){
			// print_r($e);
			$error_title = $cfgenwpapi_editor_obj->getServiceName($post_api['id']);
			$error_text = $e->message;
		}
	}
	
}


/*******************************************************
 * CAMPAIGN MONITOR API
 *******************************************************/
if($post_api['id'] == 'campaignmonitor'){

	$campaignmonitor_auth = array('api_key' => $post_api['apikey']);
	
	// CS_REST_General
	include('../api/campaignmonitor/csrest_general.php');

	// CS_REST_Clients
	include('../api/campaignmonitor/csrest_clients.php');

	$wrap = new CS_REST_General($campaignmonitor_auth);

	$account_data = $wrap->get_clients();
	
	if($account_data->http_status_code == 401){
		$error_title = $cfgenwpapi_editor_obj->getServiceName($post_api['id']);
		$error_text = $cfgenwp_service['error']['apikey'];
	} else{
		$account_i = 0;
		
		foreach($account_data->response as $account_data_v){
			
			$api_config[$account_i]['account_id'] = $account_data_v->ClientID;
			
			$api_config[$account_i]['account_name'] = $account_data_v->Name;
	
			$wrap = new CS_REST_Clients($account_data_v->ClientID, $campaignmonitor_auth);
		
			$api_lists_res[$account_i] = $wrap->get_lists();
			$api_lists_res[$account_i] = isset($api_lists_res[$account_i]->response) ? $api_lists_res[$account_i]->response : array();
			
			$account_i++;
		} // foreach
		
		// print_r($api_lists_res); exit;
	}
	
}


/*******************************************************
 * CONSTANTCONTACT API
 */
if($post_api['id'] == 'constantcontact'){
	
	if(version_compare(PHP_VERSION, '5.3.0') >= 0){
		include('form-api-getlists-constantcontact.php');
	}
}


/*******************************************************
 * GETRESPONSE API
 *******************************************************/
if($post_api['id'] == 'getresponse'){

	include('../api/getresponse/GetResponseAPI.class.php');

	$getresponse_api = new GetResponse($post_api['apikey']);
	
	$getresponse_ping = $getresponse_api->ping();

	if($getresponse_ping == 'pong'){
		
		$account_data = $getresponse_api->getAccountInfo();
		
		$api_config[0]['account_id'] = $account_data->login;
			
		$api_config[0]['account_name'] = $account_data->login;
		
		// LISTS
		$api_lists_res[0] = $getresponse_api->getCampaigns();
		//print_r($api_lists_res);
		
	} else{
		$error_title = $cfgenwpapi_editor_obj->getServiceName($post_api['id']);
		$error_text = $cfgenwp_service['error']['apikey'];	
	}

}


/*******************************************************
 * ICONTACT API
 *******************************************************/
if($post_api['id'] == 'icontact'){

	include('../api/icontact/iContactApi.php');
	
	iContactApi::getInstance()->setConfig(array(
											'appId' => $cfgenwpapi_editor_obj->icontact['applicationid'],
											'apiUsername' => $post_api['username'],
											'apiPassword' => $post_api['applicationpassword']
											));

	try{
		// Account details
		$oiContact = iContactApi::getInstance();
		// 	print_r($oiContact);
	
		$account_data = $oiContact->makeCall("/a/{$oiContact->setAccountId()}", 'GET', null, 'account');
		
		$api_config[0]['account_id'] = $account_data->accountId;
		
		$api_config[0]['account_name'] = $account_data->companyName;
		
		
		// LISTS
		$api_lists_res[0] = $oiContact->getLists();
		// print_r($api_lists_res);

	}
	
	catch(Exception $e){
		
		/**
		 * errors returned by the system are not easily understandable
		 * "Api username invalid"
		 * "The application was not recognized. Possible reasons are: the Api-AppId was entered incorrectly; the application is not registered for that user."
		 */
		/*
		$icontact_error = $oiContact->getErrors();
		$error_text = $icontact_error[0];
		*/
		$error_title = $cfgenwpapi_editor_obj->getServiceName($post_api['id']);
		$error_text = $cfgenwp_service['error']['login'];
		//print_r($oiContact->getErrors());

	}

}


/*******************************************************
 * MAILCHIMP API
 *******************************************************/
if($post_api['id'] == 'mailchimp'){

	include('../api/mailchimp/Mailchimp.php');

	$mc = new Mailchimp($post_api['apikey']);
	
	// Account details
	$mc_helper = new Mailchimp_Helper($mc);
	
	try{
		
		$account_data = $mc_helper->accountDetails();
	
		$api_config[0]['account_id'] = $account_data['user_id'];
		
		$api_config[0]['account_name'] = $account_data['username'];
	
		// LISTS
		$mcl_lists = new Mailchimp_Lists($mc);
		
		$api_lists_res[0] = $mcl_lists->getList();
		$api_lists_res[0] = isset($api_lists_res[0]['data']) ? $api_lists_res[0]['data'] : array();
		
		// print_r($api_lists_res); exit;

	}
	
	catch(Exception $e){
		$error_title = $cfgenwpapi_editor_obj->getServiceName($post_api['id']);
			
		$error_text = $e->getCode();

		if($e->getCode() == '0' || $e->getCode() == '104'){
			$error_text = $cfgenwp_service['error']['apikey'];
		}
	}

}


/*******************************************************
 * SALESFORCE
 *******************************************************/
if($post_api['id'] == 'salesforce'){

	include('../api/salesforce/SforceEnterpriseClient.php');

	$mySforceConnection = new SforceEnterpriseClient();
	
	try{
		$mySforceConnection->createConnection('../api/salesforce/enterprise.wsdl.xml');
	
		$mySforceConnection->login($post_api['username'], $post_api['password'].$post_api['accesstoken']);
		
		// Account details
		$account_data = $mySforceConnection->getUserInfo();
		//print_r($userinfo);exit;
		
		$api_config[0]['account_id'] = $account_data->userId;
		
		$api_config[0]['account_name'] = $account_data->userFullName;
	
	
		// LISTS
		$api_lists_res[0][0]['id'] = 'Contact';
		$api_lists_res[0][0]['name'] = 'Contacts';
		
		$api_lists_res[0][1]['id'] = 'Lead';
		$api_lists_res[0][1]['name'] = 'Leads';
		
		$api_lists_res[0][2]['id'] = 'Account';
		$api_lists_res[0][2]['name'] = 'Accounts';
		
		$api_lists_res[0][3]['id'] = 'Opportunity';
		$api_lists_res[0][3]['name'] = 'Opportunities';
	
	}
	
	catch(Exception $e){
		
		//print_r($e);
		
		$error_title = $cfgenwpapi_editor_obj->getServiceName($post_api['id']);
		
		if($e->faultcode == 'INVALID_LOGIN' || $e->faultcode == 'sf:INVALID_LOGIN'){
			$error_text = $cfgenwp_service['error']['login'];
		}
		
		if($e->faultcode == 'HTTP'){
			$error_text = $cfgenwp_service['error']['http'];
		}
	}
}



if($api_lists_res){
	
	//print_r($api_lists_res);
	
	
	/*******************************************************
	 * AWEBER
	 *******************************************************/
	if($post_api['id'] == 'aweber'){
		
		foreach($api_config as $account_k => $account_v){
			
			if($api_lists_res[$account_k]){

				$i = 0;

				foreach($api_lists_res[$account_k] as $api_lists_res_v){
					
					$api_config[$account_k]['lists'][$i]['id'] = $api_lists_res_v['id'];
					
					$api_config[$account_k]['lists'][$i]['name'] = $api_lists_res_v['name'];
						
					// FIELDS
					$api_listfields_res = array(
												array('id' => 'email', 'type'=>'email', 'name' => 'Email Address'.$required_field, 'required' => 1),
												array('id' => 'name', 'name' => 'Name'),
												);
					
					
					$get_custom_fields = $aweber_account->loadFromUrl("/accounts/{$aweber_account->data['id']}/lists/{$api_lists_res_v['id']}/custom_fields");
					// print_r($get_custom_fields);
					
					$get_custom_fields = isset($get_custom_fields->data['entries']) ? $get_custom_fields->data['entries'] : array();
					
					if($get_custom_fields){
						
						foreach($get_custom_fields as $get_custom_field_v){
							
							$api_listfields_res[] = array(
														'id'=>$get_custom_field_v['name'], // name must be used as id because this is the custom field name that is used in the add/update methods  
														'name'=>$get_custom_field_v['name']
														);
						}
					}
					
					
					$api_config[$account_k]['lists'][$i] = consolidateList($api_listfields_res, $api_config[$account_k]['lists'][$i]);
					
						
					$i++;
				} // foreach list
			} // if lists
		} // foreach account
	} // AWEBER
	
	
	/*******************************************************
	 * CAMPAIGN MONITOR
	 *******************************************************/
	if($post_api['id'] == 'campaignmonitor'){
		
		require '../api/campaignmonitor/csrest_lists.php'; // not in the loop to prevent Fatal error: Cannot redeclare class CS_REST_Lists
		
		foreach($api_config as $account_k => $account_v){
			
			if($api_lists_res[$account_k]){

				$i = 0;

				foreach($api_lists_res[$account_k] as $api_lists_res_v){
					
					$api_config[$account_k]['lists'][$i]['id'] = $api_lists_res_v->ListID;
					
					$api_config[$account_k]['lists'][$i]['name'] = $api_config[$account_k]['account_name'].' - '.$api_lists_res_v->Name;
						
						
					// FIELDS
					$api_listfields_res = array(
												array('id' => 'EmailAddress', 'type'=>'email', 'name' => 'Email Address'.$required_field, 'required' => 1),
												array('id' => 'Name', 'name' => 'Name'),
												);
					



					$wrap = new CS_REST_Lists($api_lists_res_v->ListID, $campaignmonitor_auth);
					

					$get_custom_fields = $wrap->get_custom_fields();
					// print_r($get_custom_fields);

					// The API does not return if a custom field is required or not
					// Custom required field missing? No error message returned, data will be inserted anyway
					if($get_custom_fields){
						
						$get_custom_fields = $get_custom_fields->response;
						
						foreach($get_custom_fields as $get_custom_field_v){
							$api_listfields_res[] = array(
														'id'=>$get_custom_field_v->Key, 
														'name'=>$get_custom_field_v->FieldName
														);
						}
					}
					
					
					$api_config[$account_k]['lists'][$i] = consolidateList($api_listfields_res, $api_config[$account_k]['lists'][$i]);
		
					$i++; // list
					
				} // foreach list
			} // if lists
		} // foreach account
	} // CAMPAIGN MONITOR
	
	
	/*******************************************************
	 * CONSTANTCONTACT
	 *******************************************************/
	if($post_api['id'] == 'constantcontact'){
		
		foreach($api_config as $account_k => $account_v){
			
			if($api_lists_res[$account_k]){

				$i = 0;
				$api_config[$account_k]['lists'][$i]['id'] = 'contacts';
					
				$api_config[$account_k]['lists'][$i]['name'] = 'Contacts';

				foreach($api_lists_res[$account_k] as $api_lists_res_v){
				
					// ConstantContact lists will be set as groups (ConstantContact is contact based, not list based)
					$api_config[$account_k]['lists'][$i]['groups'][] = array('id'=>$api_lists_res_v->id, 'name'=>$api_lists_res_v->name);

				} // foreach list

		
				// FIELDS
				// https://developer.constantcontact.com/docs/contacts-api/contacts-resource.html
				$api_listfields_res = array(
								   			array('id' => 'email', 'type'=>'email', 'name' => 'Email'.$required_field, 'required' => 1),
								   			array('id' => 'first_name', 'name' => 'First Name'),
								   			array('id' => 'last_name', 'name' => 'Last Name'),
								   			array('id' => 'job_title', 'name' => 'Job Title'),
								   			array('id' => 'company_name', 'name' => 'Company Name'),
								   			array('id' => 'home_phone', 'name' => 'Home Phone'),
								   			array('id' => 'work_phone', 'name' => 'Work Phone'),
								   			array('id' => 'cell_phone', 'name' => 'Cell Phone'),
								   			array('id' => 'fax', 'name' => 'Fax'),
											/*
								   			array('id' => '', 'name' => 'Notes'),
								   			array('id' => '', 'name' => 'Home Address - Street'),
								   			array('id' => '', 'name' => 'Home Address - Country'),
								   			array('id' => '', 'name' => 'Home Address - City'),
								   			array('id' => '', 'name' => 'Home Address - State/Province'),
								   			array('id' => '', 'name' => 'Home Address - Zip Code'),
								   			array('id' => '', 'name' => 'Work Address - Street'),
								   			array('id' => '', 'name' => 'Work Address - Country'),
								   			array('id' => '', 'name' => 'Work Address - City'),
								   			array('id' => '', 'name' => 'Work Address - State/Province'),
								   			array('id' => '', 'name' => 'Work Address - Zip Code'),
								   			array('id' => '', 'name' => 'Vacation Address - Street'),
								   			array('id' => '', 'name' => 'Vacation Address - Country'),
								   			array('id' => '', 'name' => 'Vacation Address - City'),
								   			array('id' => '', 'name' => 'Vacation Address - State/Province'),
								   			array('id' => '', 'name' => 'Vacation Address - Zip Code'),
								   			array('id' => '', 'name' => 'Other Address - Street'),
								   			array('id' => '', 'name' => 'Other Address - Country'),
								   			array('id' => '', 'name' => 'Other Address - City'),
								   			array('id' => '', 'name' => 'Other Address - State/Province'),
								   			array('id' => '', 'name' => 'Other Address - Zip Code'),*/
								   		);
					
				$api_config[$account_k]['lists'][$i] = consolidateList($api_listfields_res, $api_config[$account_k]['lists'][$i], false);
				
			} // if lists
		} // foreach account
	} // CONSTANTCONTACT
	
	
	/*******************************************************
	 * GETRESPONSE
	 *******************************************************/
	if($post_api['id'] == 'getresponse'){
		
		foreach($api_config as $account_k => $account_v){
			
			if($api_lists_res[$account_k]){

				$i = 0;
				
				foreach($api_lists_res[$account_k] as $api_lists_res_k => $api_lists_res_v){
					
					$api_config[$account_k]['lists'][$i]['id'] = $api_lists_res_k;
					
					$api_config[$account_k]['lists'][$i]['name'] = $api_lists_res_v->name;
						
						
					// FIELDS
					//print_r($api_listfields_res);
					
					$api_listfields_res = array(
												array('id' => 'email', 'type'=>'email', 'name' => 'Email Address'.$required_field, 'required' => 1),
												array('id' => 'name', 'name' => 'Name'.$required_field, 'required' => 1),
											);
					
					
					$get_custom_fields = $getresponse_api->execute($getresponse_api->prepRequest('get_account_customs'));
					
					//print_r($get_custom_fields);
					
					foreach($get_custom_fields as $get_custom_field_v){
						$api_listfields_res[] = array(
											  			'id'=>$get_custom_field_v->name, 
														'name'=>$get_custom_field_v->name,
														);
					}
					
					
					$api_config[$account_k]['lists'][$i] = consolidateList($api_listfields_res, $api_config[$account_k]['lists'][$i]);
		
					$i++; // list
					
				} // foreach list
			} // if lists
		} // foreach account
	} // GETRESPONSE


	/*******************************************************
	 * ICONTACT
	 *******************************************************/
	if($post_api['id'] == 'icontact'){
	
		foreach($api_config as $account_k => $account_v){
			
			if($api_lists_res[$account_k]){

				$i = 0;
				
				$api_config[$account_k]['lists'][$i]['id'] = 'contacts';
					
				$api_config[$account_k]['lists'][$i]['name'] = 'Contacts';
				
				// iContact lists will be set as groups (iContact is contact based, not list based)
				foreach($api_lists_res[$account_k] as $api_lists_res_v){
				
					$api_config[$account_k]['lists'][$i]['groups'][] = array('id'=>$api_lists_res_v->listId, 'name'=>$api_lists_res_v->name);

				} // foreach list

				// FIELDS
				$api_listfields_res = array(
											array('id' => 'email', 'type'=>'email', 'name' => 'Email'.$required_field, 'required' => 1),
											array('id' => 'prefix', 'name' => 'Prefix'),
											array('id' => 'firstName', 'name' => 'First Name'),
											array('id' => 'lastName', 'name' => 'Last Name'),
											array('id' => 'suffix', 'name' => 'Suffix'),
											array('id' => 'street', 'name' => 'Address Line 1'),
											array('id' => 'street2', 'name' => 'Address Line 2'),
											array('id' => 'city', 'name' => 'City'),
											array('id' => 'state', 'name' => 'State / Province'),
											array('id' => 'postalCode', 'name' => 'Zip / Postal Code'),
											array('id' => 'business', 'name' => 'Business name'),
											array('id' => 'phone', 'name' => 'Phone'),
											array('id' => 'fax', 'name' => 'Fax'),
											);
					
					
				$get_custom_fields = $oiContact->makeCall("/a/{$oiContact->setAccountId()}/c/{$oiContact->setClientFolderId()}/customfields",'GET');
				
				//print_r($get_custom_fields->customfields);
				
				foreach($get_custom_fields->customfields as $get_custom_field_v){
					
					$api_listfields_res[] = array(
												'id'=>$get_custom_field_v->customFieldId, 
												'name'=>$get_custom_field_v->publicName, 
												);
				}
					
					
				$api_config[$account_k]['lists'][$i] = consolidateList($api_listfields_res, $api_config[$account_k]['lists'][$i], false);				
				
			} // if lists
		} // foreach account
	} // ICONTACT

	
	/*******************************************************
	 * MAILCHIMP
	 *******************************************************/
	if($post_api['id'] == 'mailchimp'){
		
		foreach($api_config as $account_k => $account_v){
			
			if($api_lists_res[$account_k]){

				$i = 0;
				
				foreach($api_lists_res[$account_k] as $list_value){
					
					$api_config[$account_k]['lists'][$i]['id'] = $list_value['id'];
					
					$api_config[$account_k]['lists'][$i]['name'] = $list_value['name'];

					// FIELDS
					$get_custom_fields = $mcl_lists->mergeVars(array($list_value['id']));
					
					// print_r($get_custom_fields);
	
					foreach($get_custom_fields['data'][0]['merge_vars'] as $get_custom_field_v){
						
						$field = array(
										'id'=>$get_custom_field_v['tag'], 
										'required'=>$get_custom_field_v['req'], 
										'name'=>$get_custom_field_v['name'].($get_custom_field_v['req'] == 1 ? $required_field : ''), 
										);
										
						if($get_custom_field_v['field_type'] == 'email'){
							$field['type'] = 'email';
						}
						
						$api_listfields_res[] = $field;
					}
					
					$api_config[$account_k]['lists'][$i] = consolidateList($api_listfields_res, $api_config[$account_k]['lists'][$i]);					
					
					// GROUPINGS
					$api_config[$account_k]['lists'][$i]['groupings'] = array();
					
					try{
						$api_config[$account_k]['lists'][$i]['groupings'] = $mcl_lists->interestGroupings($list_value['id']);
					}
					catch(Exception $e){
						// Uncaught exception 'Mailchimp_List_InvalidOption' with message 'This list does not have interest groups enabled'
					}
		
					$i++;
					
				} // foreach
			} // foreach
		} //if($api_lists_res['data'])
	} // MAILCHIMP
	
	
	/*******************************************************
	 * SALESFORCE
	 *******************************************************/
	function sfGetFieldTypeFormat($sf_type){
		/**
		 * http://www.salesforce.com/us/developer/docs/api/Content/primitive_data_types.htm
		 * http://www.salesforce.com/us/developer/docs/api/Content/field_types.htm#topic-title
		 */
		$formats = array(
						'date'=>'YYYY-MM-DD',
						'datetime'=>'',
						'int'=>'1234',
						'double'=>'13,37',
						);
		
		$value = '['.$sf_type.( (isset($formats[$sf_type]) && $formats[$sf_type]) ? ' : '.$formats[$sf_type]:'').']';
		$value = '';
		return($value);
	}
	
	if($post_api['id'] == 'salesforce'){
		
		foreach($api_config as $account_k => $account_v){
			
			if($api_lists_res[$account_k]){
						
				$i = 0;
				
				foreach($api_lists_res[$account_k] as $api_lists_res_v){
					
					$api_config[$account_k]['lists'][$i]['id'] = $api_lists_res_v['id'];
					
					$api_config[$account_k]['lists'][$i]['name'] = $api_lists_res_v['name'];
						
						
					// FIELDS
					$get_custom_fields = $mySforceConnection->describeSObject($api_lists_res_v['id']);
					
					// print_r($get_custom_fields);
					
					foreach($get_custom_fields->fields as $get_custom_field_v){
						
						/*
						 * All salesforce fields are not writeable
						 * createable == 1 : prevents error message "Unable to create/update fields: Name"
						 * updateable == 1 : prevents error message "Unable to create/update fields: Name"
						 * Please check the security settings of this field and verify that it is read/write for your profile or permission set.
						 * INVALID_FIELD_FOR_INSERT_UPDATE
						 */

						if($get_custom_field_v->createable == 1 && $get_custom_field_v->updateable == 1){
							
							/*
							 * ACCOUNT : http://www.salesforce.com/us/developer/docs/api/Content/sforce_api_objects_account.htm
							 * CONTACT : http://www.salesforce.com/us/developer/docs/api/Content/sforce_api_objects_contact.htm
							 * LEAD : http://www.salesforce.com/us/developer/docs/api/Content/sforce_api_objects_lead.htm
							 * OPPORTUNITY : http://www.salesforce.com/us/developer/docs/api/Content/sforce_api_objects_opportunity.htm
							 *
							 * These fields won't appear in the list. They are required but are automatically set by SalesForce.
							 * OwnerId :  Defaulted on create
							 * Status : Defaulted on create
							 * IsUnreadByOwner : Defaulted on create
							 */
							if($get_custom_field_v->name != 'OwnerId'
							   && $get_custom_field_v->name != 'Status'
							   && $get_custom_field_v->name != 'IsPrivate'
							   ){
								//echo $get_custom_field_v->label."\r\n";
								$sf_field_type = sfGetFieldTypeFormat($get_custom_field_v->type);
								
								$field = array(
												'id'=>$get_custom_field_v->name, 
												'required'=>($get_custom_field_v->nillable == 1 ? '' : 1), 
												'name'=>$get_custom_field_v->label.($get_custom_field_v->nillable == 1 ? '' : $required_field).$sf_field_type, 
												);
												
								if($get_custom_field_v->type == 'email'){
									$field['type'] = 'email';
								}

								$api_listfields_res[] = $field;
								
							}
						}
					}
					
					$api_config[$account_k]['lists'][$i] = consolidateList($api_listfields_res, $api_config[$account_k]['lists'][$i]);
					
					$i++;
					
				} // foreach list
			} // if lists
		} // foreach account
	} // SALESFORCE

}

//print_r($api_config);



$cfgenwp_loadform_api_config = (isset($_POST['loadform_api_config']) && $_POST['loadform_api_config']) ? json_decode($_POST['loadform_api_config'], true) : array();
//print_r($cfgenwp_loadform_api_config);

if(isset($cfgenwp_loadform_api_config[$post_api['id']])){
	
	foreach($cfgenwp_loadform_api_config as $cfgenwp_loadform_api_config_k=>$cfgenwp_loadform_api_config_v){
		
		$api_properties = array();
		
		foreach($cfgenwp_loadform_api_config_v['accounts'] as $accounts_v){

			$api_properties['account'][$accounts_v['account_id']] = array();
			
			$loop_list_config = array();
			
			foreach($accounts_v['lists'] as $loadform_api_lists_v){
				
				foreach($loadform_api_lists_v['fields'] as $loadform_api_fields_v){
					$loop_list_config['fields'][$loadform_api_fields_v['list_field_id']] = $loadform_api_fields_v['element_id'];
				}
				
				if(isset($loadform_api_lists_v['doubleoptin'])){
					$loop_list_config['doubleoptin'] = $loadform_api_lists_v['doubleoptin'];
				}
				
				if(isset($loadform_api_lists_v['updateexistingcontact'])){
					$loop_list_config['updateexistingcontact'] = $loadform_api_lists_v['updateexistingcontact'];
				}

				if(isset($loadform_api_lists_v['sendwelcomeemail'])){
					$loop_list_config['sendwelcomeemail'] = $loadform_api_lists_v['sendwelcomeemail'];
				}

				if(isset($loadform_api_lists_v['preventduplicates'])){
					$loop_list_config['preventduplicates'] = $loadform_api_lists_v['preventduplicates'];
				}

				if(isset($loadform_api_lists_v['filterduplicates'])){
					$loop_list_config['filterduplicates'] = $loadform_api_lists_v['filterduplicates'];
				}
				
				// groups: constantcontact, icontact
				if(isset($loadform_api_lists_v['groups'])){
					foreach($loadform_api_lists_v['groups'] as $cfgenwp_loadform_api_groups_v){
						$loop_list_config['groups'][] = $cfgenwp_loadform_api_groups_v;
					}
				}
				
				// groupings: mailchimp
				if(isset($loadform_api_lists_v['groupings'])){
					foreach($loadform_api_lists_v['groupings'] as $cfgenwp_loadform_api_groupings_v){
						$loop_list_config['groupings'][$cfgenwp_loadform_api_groupings_v['grouping_id']] = $cfgenwp_loadform_api_groupings_v['groups'];
					}
				}
			
				$api_properties['account'][$accounts_v['account_id']]['lists'][$loadform_api_lists_v['list_id']] = $loop_list_config;
				
			}
		}
		
		$cfgenwp_loadform_api_config[$cfgenwp_loadform_api_config_k]['properties'] = $api_properties;
	
	}
}
// print_r($cfgenwp_loadform_api_config);


$loadform_api_properties = array();
if(isset($cfgenwp_loadform_api_config[$post_api['id']]['properties'])){
	$loadform_api_properties = $cfgenwp_loadform_api_config[$post_api['id']]['properties'];
}

//print_r($cfgenwp_loadform_api_config);


ob_start();

//print_r($api_config);exit;

	
if(!$error_text && !$api_config){
	$error_title = $cfgenwpapi_editor_obj->getServiceName($post_api['id']);
	$error_text = 'It was not possible to establish a connection with the service.';
}

if(!$error_text){
	
	if($api_config){

		$html_res_type = 'ok';
			
		foreach($api_config as $service_account_v){
		?>
			
			<div class="cfgenwp-api-account-container" data-cfgenwp_api_account_id="<?php echo $service_account_v['account_id']; ?>">
				<?php
				/*
				<div>
				Account id : <?php echo $service_account_v['account_id']; ?> <?php echo (isset($service_account_v['account_name']) && $service_account_v['account_name'] ? ', Account name  : '.$service_account_v['account_name'] : ''); ?>
				</div>
				*/
				?>

				<?php
				if(!isset($flag_selectlisttitle)){
					$flag_selectlisttitle = true; // prevents from showing the title multiple times in case of having muliple accounts
					?>
					<div class="cfgenwp-api-selectlisttitle">
					Select the contact lists you want to integrate with your form :
					</div>
					<?php
				}
				?>
				
			<?php
			usort($service_account_v['lists'], 'sortArrayByName');

			foreach($service_account_v['lists'] as $service_list_v){
			
				$list_id = $service_list_v['id'];
				$list_id_htmlentities = $contactformeditor_obj->htmlEntities($list_id);
				$list_id_checked = '';
				$list_settings_css = '';
				$list_label = 'cfgenwp-api-list-'.$post_api['id'].'-'.$list_id;
				
				$list_container_class = '';
				
				$loadform_service_list = array();
				
				if(isset($loadform_api_properties['account'] [$service_account_v['account_id']] ['lists'] [$service_list_v['id']])){
				
					$list_id_checked = $contactformeditor_obj->checked;
					$list_settings_css = 'display:block;';
					$loadform_service_list = $loadform_api_properties['account'] [$service_account_v['account_id']] ['lists'] [$service_list_v['id']];
					$list_container_class = 'cfgenwp-api-list-c-selected';
				}
				?>

				<div class="cfgenwp-api-list-c <?php echo $list_container_class;?>" data-cfgenwp_api_list_id="<?php echo $list_id_htmlentities;?>" data-cfgenwp_api_list_name="<?php echo $contactformeditor_obj->htmlEntities($service_list_v['name']);?>">
				
					<div>
						<input id="<?php echo $list_label;?>" type="checkbox" <?php echo $list_id_checked;?> class="cfgenwp-integrate-list">
						
						<label for="<?php echo $list_label;?>" class="cfgenwp-api-list-name"><?php echo $service_list_v['name'];?></label>
					</div>
					
					<div class="cfgenwp-api-list-settings" style=" <?php echo $list_settings_css;?>">
						
						<div class="cfgenwp-api-list-field-header">
						
							<div class="cfgenwp-api-list-field-col-title">
							List Fields
							</div>
								
							<div class="cfgenwp-api-form-field-col-title">
							Form Fields
							</div>
							
							<div class="cfgenwp-clear"></div>
						
						</div>
						
						<?php
						foreach($service_list_v['fields'] as $fields){?>
						
						<div class="cfgenwp-api-list-field-c">

							<?php
							if(isset($service_list_v['fields']) && $service_list_v['fields']){?>
							
								<div class="cfgenwp-api-list-field-id-container <?php echo (isset($loadform_service_list['fields'][$fields['id']]) ? 'cfgenwp-api-list-field-id-selected' : '');?>">
								<?php echo $fields['name'];?>
								</div>
								
								<div class="cfgenwp-api-list-element-name-container">
								
									<?php
									$select_element_id = 'cfgenwp-'.$post_api['id'].'-'.$service_list_v['id'].'-'.$_SESSION['select_container_i'];
									?>
									
									<select data-cfgenwp_api_list_field_id="<?php echo $contactformeditor_obj->htmlEntities($fields['id']);?>" data-cfgenwp_api_list_field_name="<?php echo $contactformeditor_obj->htmlEntities($fields['name']);?>" data-cfgenwp_api_list_field_required="<?php echo $fields['required'];?>" data-cfgenwp_api_list_field_type="<?php echo $fields['type'];?>" data-cfgenwp_api_list_field_required="<?php echo $fields['required'];?>" class="cfgenwp-formsettings-select cfgenwp-api-form-element-id" id="<?php echo $select_element_id;?>">
										
										<?php $_SESSION['select_container_i']++;?>
										
										<option value=""></option>
										<?php
										foreach($_POST['form_elements'] as $element){
											
											$element_selected = '';
											$element_id = $contactformeditor_obj->htmlEntities($element['id']);
											
											if(isset($loadform_service_list['fields'][$fields['id']]) && $loadform_service_list['fields'][$fields['id']] == $element['id']){
												$element_selected = $contactformeditor_obj->selected;
												$load_selected_formelement[$select_element_id] = $element_id;
											}
											
											?>
											<option <?php echo $element_selected;?> value="<?php echo $element_id;?>"><?php echo $element['label'];?></option>
											<?php
										}
										?>
									</select>
									
								</div>
							
							<?php
							} // if fields
							?>
							
							<div class="cfgenwp-clear"></div>
							
						</div><!-- cfgenwp-api-list-field-c -->
						
						<?php
						}
						?>
					
						<?php
						if(isset($service_list_v['groupings']) && $service_list_v['groupings']){
							
							foreach($service_list_v['groupings'] as $grouping_v){
								
								if($grouping_v['groups']){?>
									
									<div class="cfgenwp-api-list-grouping-container" data-cfgenwp_api_list_grouping_type="<?php echo $grouping_v['form_field'];?>" data-cfgenwp_api_list_grouping_id="<?php echo $grouping_v['id'];?>" >
									
										<div class="cfgenwp-api-list-grouping-title">
										Group: <?php echo $grouping_v['name'];?>
										</div>
										
										<?php
										// SELECT
										if($grouping_v['form_field'] == 'dropdown'){?>
											<select class="cfgenwp-formsettings-select cfgenwp-api-list-group">
												<option value="">Select a group</option>
												<?php
												foreach($grouping_v['groups'] as $group_v){
													
													$group_selected = '';
													
													if(isset($loadform_service_list['groupings'][$grouping_v['id']]) && in_array($group_v['name'], $loadform_service_list['groupings'][$grouping_v['id']])){
														$group_selected = $contactformeditor_obj->selected;
													}
													?>
													<option <?php echo $group_selected;?> value="<?php echo $contactformeditor_obj->htmlEntities($group_v['name']);?>"><?php echo $group_v['name'];?></option>
													<?php
												}
												?>
											</select>
											<?php
										}
										
										
										// CHECKBOXES
										if($grouping_v['form_field'] == 'checkboxes' || $grouping_v['form_field'] == 'radio'){
											
											$group_input_type = ($grouping_v['form_field'] == 'checkboxes') ? 'checkbox' : 'radio';
											
											$input_name = '';
											$input_class = '';
											$input_data = ''; // for js radio uncheck purposes
											if($group_input_type == 'radio'){
												$input_name = 'name="cfgenwp-mailchimp-grouping-'.$grouping_v['id'].'"';
												$input_class = 'cfgenwp-mailchimp-grouping-radio';
											}
											
											foreach($grouping_v['groups'] as $group_v){
													
												$group_checked = '';
												$data_grouping_checked = false;
												
												$group_label = 'cfgenwp-mailchimp-grouping-'.$grouping_v['id'].'-'.$group_v['id'];
												
												if(isset($loadform_service_list['groupings'][$grouping_v['id']]) && in_array($group_v['name'], $loadform_service_list['groupings'][$grouping_v['id']])){
													$group_checked = $contactformeditor_obj->checked;
													$data_grouping_checked = true;
												}
												
												if($group_input_type == 'radio'){
													$input_data = 'data-cfgenwp_mailchimp_grouping_checked="'.var_export($data_grouping_checked, true).'"'; // for js radio uncheck purposes, set to true or false
												}?>
												
												<div>
													<input id="<?php echo $group_label;?>" <?php echo $group_checked;?> type="<?php echo $group_input_type; ?>" <?php echo $input_name;?> <?php echo $input_data;?> class="cfgenwp-api-list-group <?php echo $input_class;?>" value="<?php echo $contactformeditor_obj->htmlEntities($group_v['name']);?>">
													<label for="<?php echo $group_label;?>"><?php echo $group_v['name'];?></label>
												</div>
												
												<?php
											}
										}
										
										?>
									
									</div><!-- cfgenwp-api-list-grouping-container -->
									
									<?php
								} // if groups
							} // foreach groupings
						} // if groupings
						?>
						
						<?php
						if(in_array($post_api['id'], $cfgenwpapi_editor_obj->api_list_groups)){?>

							<div class="cfgenwp-api-list-subtitle">
							Email lists management<?php if($post_api['id']){echo '<span class="cfgenwp-api-list-subtitle-required">*</span>';}?>
							</div>
							
							<div class="cfgenwp-api-selectlisttitle">Select the email lists the contacts will be subscribed to :</div>

							<div class="cfgenwp-api-list-groups-container">
							
								<?php
								usort($service_list_v['groups'], 'sortArrayByName');
								
								foreach($service_list_v['groups'] as $api_config_list_group){
									$list_group_label = 'cfgenwp-api-group-'.$post_api['id'].'-'.$api_config_list_group['id'];
									
									$list_group_checked = '';
									
									if(isset($loadform_service_list['groups'])){
										$list_group_checked = in_array($api_config_list_group['id'], $loadform_service_list['groups']) ? $contactformeditor_obj->checked : '';
									}
									?>
									<div class="cfgenwp-api-list-option">
										<input type="checkbox" <?php echo $list_group_checked;?> class="cfgenwp-api-list-group" id="<?php echo $list_group_label;?>" value="<?php echo $api_config_list_group['id'];?>"><label for="<?php echo $list_group_label;?>"><?php echo $api_config_list_group['name'];?></label>
									</div>
									<?php
								}
								?>
								
							</div>
							
							<?php
						}
						?>
						
						<?php
						if(in_array($post_api['id'], $cfgenwpapi_editor_obj->api_preventduplicates) || in_array($post_api['id'], $cfgenwpapi_editor_obj->api_updateexistingcontact)){?>
						
							<div class="cfgenwp-api-list-subtitle">
							Contact data
							</div>
							<?php
						}
						?>
						
						<?php
						if(in_array($post_api['id'], $cfgenwpapi_editor_obj->api_doubleoptin)){
							
							// default config
							$doubleoptin_checked = $contactformeditor_obj->checked;
							$doubleoptin_disabled = '';
							
							if(isset($loadform_service_list['doubleoptin'])){
								$doubleoptin_checked = $loadform_service_list['doubleoptin'] ? $contactformeditor_obj->checked : '';
							}
							
							if(isset($loadform_service_list['sendwelcomeemail']) && $loadform_service_list['sendwelcomeemail']){
								//$doubleoptin_disabled = $contactformeditor_obj->disabled;
							}
							
							$doubleoptin_label = 'cfgenwp-doubleoptin-'.$post_api['id'].'-'.$list_id_htmlentities;
							?>
							<div class="cfgenwp-api-list-option">
								<input type="checkbox" <?php echo $doubleoptin_checked;?> <?php echo $doubleoptin_disabled;?> class="cfgenwp-api-list-doubleoptin" id="<?php echo $doubleoptin_label;?>"><label for="<?php echo $doubleoptin_label;?>">Activate double opt-in (your user must click on a link in the confirmation email to be added to the list)</label>
							</div>
							<?php
						}
						?>
						
						<?php
						/*
						sendwelcomeemail:  optional, if your double_optin is false and this is true, we will send your lists Welcome Email if this subscribe succeeds - this will *not* fire if we end up updating an existing subscriber.
						If double_optin is true, this has no effect. defaults to false.
						*/
						if(in_array($post_api['id'], $cfgenwpapi_editor_obj->api_sendwelcomeemail)){
							
							// default config
							$sendwelcomeemail_checked = '';
							$sendwelcomeemail_disabled = '';
							
							if(isset($loadform_service_list['sendwelcomeemail'])){
								$sendwelcomeemail_checked = $loadform_service_list['sendwelcomeemail'] ? $contactformeditor_obj->checked : '';
							}
							
							if(isset($loadform_service_list['doubleoptin']) && $loadform_service_list['doubleoptin']){
								//$sendwelcomeemail_disabled = $contactformeditor_obj->disabled;
							}
							
							$sendwelcomeemail_label = 'cfgenwp-sendwelcomeemail-'.$post_api['id'].'-'.$list_id_htmlentities;
							?>
							<div class="cfgenwp-api-list-option">
								<input type="checkbox" <?php echo $sendwelcomeemail_checked;?> <?php echo $sendwelcomeemail_disabled;?> class="cfgenwp-api-list-sendwelcomeemail" id="<?php echo $sendwelcomeemail_label;?>"><label for="<?php echo $sendwelcomeemail_label;?>">Send welcome email (only possible when double opt-in is not activated)</label>
							</div>
							<?php
						}
						?>
							
						<?php
						if(in_array($post_api['id'], $cfgenwpapi_editor_obj->api_preventduplicates)){
							$duplicates_handler_radio_name = 'cfgenwp-api-list-preventduplicates-'.$post_api['id'].'-'.$service_list_v['id'];
							
							$allowduplicates_html_id = 'cfgenwp-api-list-preventduplicates-'.$post_api['id'].'-'.$service_list_v['id'].'-1';
							$preventduplicates_html_id = 'cfgenwp-api-list-preventduplicates-'.$post_api['id'].'-'.$service_list_v['id'].'-2';
							
							// default config
							$allow_duplicates_checked = '';
							$prevent_duplicates_checked = $contactformeditor_obj->checked;
							
							if(isset($loadform_service_list['preventduplicates'])){
								if(!$loadform_service_list['preventduplicates']){
									$allow_duplicates_checked = $contactformeditor_obj->checked;
									$prevent_duplicates_checked = '';
								} else{
									// that would match with the default configuration
								}
							}?>
							
							<div class="cfgenwp-api-list-option">
								<input type="radio" class="cfgenwp-api-list-allowduplicates" name="<?php echo $duplicates_handler_radio_name?>" <?php echo $allow_duplicates_checked;?> id="<?php echo $allowduplicates_html_id;?>">
								<label for="<?php echo $allowduplicates_html_id;?>">Allow duplicate entries</label>
							</div>
							
							<div class="cfgenwp-api-list-option">
								<input type="radio" class="cfgenwp-api-list-preventduplicates" name="<?php echo $duplicates_handler_radio_name?>" <?php echo $prevent_duplicates_checked;?> id="<?php echo $preventduplicates_html_id;?>">
								<label for="<?php echo $preventduplicates_html_id;?>">Prevent duplicate entries</label>
							</div>
							
							<?php
						}
						?>
						
						<?php
						if(in_array($post_api['id'], $cfgenwpapi_editor_obj->api_updateexistingcontact)){
							
							// default config
							$updateexistingcontact_checked = $contactformeditor_obj->checked;
							
							if(isset($loadform_service_list['updateexistingcontact'])){
								$updateexistingcontact_checked = $loadform_service_list['updateexistingcontact'] ? $contactformeditor_obj->checked : '';
							}
							
							$updateexistingcontact_label = 'cfgenwp-updateexistingcontact-'.$post_api['id'].'-'.$list_id_htmlentities;
							?>
							<div class="cfgenwp-api-list-option">
								<input type="checkbox" <?php echo $updateexistingcontact_checked;?> class="cfgenwp-api-list-updateexistingcontact" id="<?php echo $updateexistingcontact_label;?>"><label for="<?php echo $updateexistingcontact_label;?>">Update existing contacts (update the data if the contact already exists). <?php if($post_api['id'] == 'constantcontact') echo 'Note that the user will be removed from the lists you don\'t select in the Email lists management section';?></label>
								
							</div>
						<?php
						}
						?>
						
						<?php
						if($post_api['id'] == 'salesforce'){
							
							// default config
							$filterduplicates_c_css = '';
							$preventduplicates_notice_css = '';
							$updateexistingcontact_notice_css = '';
							
							if((isset($loadform_service_list['preventduplicates']) && !$loadform_service_list['preventduplicates']) 
								&& (isset($loadform_service_list['updateexistingcontact']) && !$loadform_service_list['updateexistingcontact'])){
								$filterduplicates_c_css = 'display:none;';
							}
							
							if(isset($loadform_service_list['preventduplicates']) && !$loadform_service_list['preventduplicates']){
								$preventduplicates_notice_css = 'display:none;';
							}
							
							if(isset($loadform_service_list['updateexistingcontact']) && !$loadform_service_list['updateexistingcontact']){
								$updateexistingcontact_notice_css = 'display:none;';
							}							
							?>
							<div class="cfgenwp-api-filterduplicates-c" style=" <?php echo $filterduplicates_c_css;?>">
							
								Select the SalesForce fields that will be used to:
								
								<ul>
									<li class="cfgenwp-api-preventduplicates-notice" style="<?php echo $preventduplicates_notice_css;?>">Search for existing contact and prevent duplicate records</li>
									<li class="cfgenwp-api-updateexistingcontact-notice" style="<?php echo $updateexistingcontact_notice_css;?>">Search for existing contact and update the contact details</li>
								</ul>
								
								<select multiple="multiple" class="cfgenwp-api-filterduplicates-field-id">
									<?php
									foreach($service_list_v['fields'] as $fields){
										
										// default config
										$filter_selected = '';
										
										if(isset($loadform_service_list['filterduplicates'])){
											$filter_selected = in_array($fields['id'], $loadform_service_list['filterduplicates']) ? $contactformeditor_obj->selected : '';
										}
										?>
										<option <?php echo $filter_selected;?> value="<?php echo $contactformeditor_obj->htmlEntities($fields['id']);?>"><?php echo $fields['name'];?></option>
									<?php
									}
									?>
								</select>
							</div>
						<?php
						}
						?>	

					</div><!-- cfgenwp-api-list-settings -->
						
				</div><!-- cfgenwp-api-list-c -->
				<?php
			}
			?>
			
			</div><!-- cfgenwp-api-account-container -->
			
			<?php
		} // foreach
	} // if($api_config)
} // if !$error_text

$html = ob_get_contents();
		
$html = str_replace("\r", '', $html);
$html = str_replace("\n", '', $html);
$html = str_replace("\r\n", '', $html);
$html = str_replace("\t", '', $html);
			
ob_end_clean();

} // if(!$error_text)

$error_title = $error_title ? $error_title.' error' : '';
$json_message = array(
					'error_text'=>$error_text, 
					'error_title'=>$error_title, 
					'html'=>$html, 
					'html_res_type'=>$html_res_type, 
					'load_selected_formelement'=>$load_selected_formelement,
					);

if(isset($aweber['consumerkey'])){
	$json_message['aweber']['consumerkey'] = $aweber['consumerkey'];
	$json_message['aweber']['consumersecret'] = $aweber['consumersecret'];
	$json_message['aweber']['accesstokenkey'] = $aweber['accesstokenkey'];
	$json_message['aweber']['accesstokensecret'] = $aweber['accesstokensecret'];
}


echo json_encode($json_message);

?>