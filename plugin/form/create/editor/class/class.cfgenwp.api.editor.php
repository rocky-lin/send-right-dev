<?php
/**********************************************************************************
 * Contact Form Generator is (c) Top Studio
 * It is strictly forbidden to use or copy all or part of an element other than for your 
 * own personal and private use without prior written consent from Top Studio http://topstudiodev.com
 * Copies or reproductions are strictly reserved for the private use of the person 
 * making the copy and not intended for a collective use.
 *********************************************************************************/

include('class.cfgenwp.api.php');

class cfgenwpApiEditor extends cfgenwpApi{
	
	function __construct(){
		
		parent::__construct();
		
		$this->aweber['applicationid'] = '2bc109e5';
		$this->aweber['auth_url'] = 'https://auth.aweber.com/1.0/oauth/authorize_app/'.$this->aweber['applicationid'];
		
		$this->aweber['validauthorizationcode'] = '<div class="cfgenwp-api-validcredential">A valid authorization code has been set up.</div>';

		$this->helpwww['icontact'] = 'http://www.topstudiodev.com/support/icontact';
		$this->helpwww['constantcontact'] = 'http://www.topstudiodev.com/support/constantcontact';
		
		$this->setServiceError('aweber', 'authorizationcode', 'This authorization code is not valid or does not exist.<br>Authorization codes can only be used once. You must get a new authorization code once you have used one.');
		
		
		$this->setServiceError('campaignmonitor', 'apikey', 'This API key is not valid.');
		$this->setServiceError('constantcontact', 'apikey', 'Invalid API key.');
		$this->setServiceError('constantcontact', 'accesstoken', 'Invalid access token.');
		$this->setServiceError('getresponse', 'apikey', 'This API key is not valid.');
		//$this->setServiceError('googlecontacts', 'accesstoken', 'Invalid access token.');
		$this->setServiceError('icontact', 'login', 'Invalid username or invalid application password.<br><a href="'.$this->helpwww['icontact'].'" target="_blank">Click here to get your application password</a> if you don\'t have one (note that the application password is different from your iContact password).');
		$this->setServiceError('mailchimp', 'apikey', 'This API key is not valid.');
		$this->setServiceError('salesforce', 'login', 'Invalid username, password or security token.');
		$this->setServiceError('salesforce', 'http', 'Invalid API key or access token support is not available. OpenSSL must be activated.');
		
		$this->setServiceCredentials('aweber', array(
													array(
														'type'=>'authorizationcode',
														'label'=>'Authorization code',
														'input_label'=>'Your authorization code',
														'input_type'=>'textarea',
														'placeholder'=>'Enter your authorization code',
														'append'=>'<div class="cfgenwp-api-notice cfgenwp-a"><a href="'.$this->aweber['auth_url'].'" target="_blank">Click here to get your authorization code</a></div>',
														'help'=>$this->aweber['auth_url'],
														),
													));
													

													
		$this->setServiceCredentials('campaignmonitor', array(
															array(
																'type'=>'apikey',
																'label'=>'API key',
																'input_label'=>'Your API key',
																'input_type'=>'text',
																'placeholder'=>'Enter your API key',
																'addtoformconfig'=>true,
																'help'=>'http://help.campaignmonitor.com/topic.aspx?t=206',
																),
														));
		
		$this->setServiceCredentials('constantcontact', array(
															array(
																'type'=>'apikey',
																'label'=>'API key',
																'input_label'=>'Your API key',
																'input_type'=>'text',
																'placeholder'=>'Enter your API key',
																'addtoformconfig'=>true,
																'help'=>$this->helpwww['constantcontact'],
																),
														));								
		
		$this->setServiceCredentials('constantcontact', array(
															array(
																'type'=>'accesstoken',
																'label'=>'Access token',
																'input_label'=>'Your access token',
																'input_type'=>'text',
																'placeholder'=>'Enter your access token',
																'addtoformconfig'=>true,
																'help'=>$this->helpwww['constantcontact'],
																),
														));
		
		$this->setServiceCredentials('getresponse', array(
														array('type'=>'apikey',
															'label'=>'API key',
															'placeholder'=>'Enter API key',
															'input_type'=>'text',
															'input_label'=>'Your API key',
															'addtoformconfig'=>true,
															'help'=>'http://support.getresponse.com/faq/where-i-find-api-key',
															),
													));
		/*
		$this->setServiceCredentials('googlecontacts', array(
													array(
														'type'=>'authorizationcode',
														'label'=>'Authorization code',
														'input_label'=>'Your authorization code',
														'input_type'=>'textarea',
														'placeholder'=>'Enter your authorization code',
														'append'=>'<div class="cfgenwp-api-notice cfgenwp-a"><a href="'.$this->aweber['auth_url'].'" target="_blank">Click here to get your authorization code</a></div>',
														'help'=>$this->aweber['auth_url'],
														),
													));
		*/

		$this->setServiceCredentials('icontact', array(
													array(
														'type'=>'username',
														'label'=>'Username',
														'input_type'=>'text',
														'input_label'=>'Your username',
														'placeholder'=>'Enter your username',
														'addtoformconfig'=>true,
														),
													array(
														'type'=>'applicationpassword',
														'label'=>'Application password',
														'input_label'=>'Application password',
														'input_type'=>'password',
														'placeholder'=>'Enter your application password',
														'addtoformconfig'=>true,
														'help'=>$this->helpwww['icontact'],
														),

												));
								
		$this->setServiceCredentials('mailchimp', array(
													array(
														'type'=>'apikey',
														'label'=>'API key',
														'input_label'=>'Your API key',
														'input_type'=>'text',
														'placeholder'=>'Enter API key',
														'addtoformconfig'=>true,
														'help'=>'http://kb.mailchimp.com/accounts/management/about-api-keys#Find-or-Generate-Your-API-Key',
														),
												));
		
		$this->setServiceCredentials('salesforce', array(
													array(
														'type'=>'username',
														'label'=>'Username',
														'input_label'=>'Your username',
														'input_type'=>'text',
														'placeholder'=>'Enter your username',
														'addtoformconfig'=>true,
														),
													array(
														'type'=>'password',
														'label'=>'Password',
														'input_label'=>'Your password',
														'input_type'=>'password',
														'placeholder'=>'Enter your password',
														'addtoformconfig'=>true,
														'append'=>'<div id="cfgenwp-salesforce-notice-password" class="cfgenwp-api-notice cfgenwp-a">Important notice about Salesforce password policy</div>'
														),
													array('type'=>'accesstoken',
															'label'=>'Security token',
															'input_label'=>'Your security token',
															'input_type'=>'text',
															'placeholder'=>'Enter your security token',
															'addtoformconfig'=>true,
															'help'=>'https://help.salesforce.com/HTViewHelpDoc?id=user_security_token.htm&language=en_US',
															),
													));

		$this->addCredentialToServiceFormConfig('aweber', array('consumersecret', 'consumerkey', 'accesstokenkey', 'accesstokensecret'));
		
		
	
		$this->api_doubleoptin = array('mailchimp');
		
		$this->api_updateexistingcontact = array('aweber', 'campaignmonitor', 'constantcontact', 'getresponse', 'icontact', 'mailchimp', 'salesforce');
		
		$this->api_list_groups = array('constantcontact', 'icontact');
		
		$this->api_sendwelcomeemail = array('mailchimp');
		
		$this->api_preventduplicates = array('salesforce');
		
		
	}
	
	function addCredentialToServiceFormConfig($service, $credentials){
		foreach($credentials as $credential){
			$this->service[$service]['formconfig']['credentials'][$credential] = '';
		}
	}
	
	function setServiceCredentials($service, $credentials){
	
		foreach($credentials as $credential_v){
		
			$this->service[$service]['credentials'][$credential_v['type']] = $credential_v;
			
			if(isset($credential_v['addtoformconfig']) && $credential_v['addtoformconfig']){
				$this->addCredentialToServiceFormConfig($service, array($credential_v['type']));
			}
			
			unset($this->service[$service]['credentials'][$credential_v['type']]['type']);
			unset($this->service[$service]['credentials'][$credential_v['type']]['addtoformconfig']);
		}			
	}
	
	function setServiceError($service, $error_type, $error_message){
		$this->service[$service]['error'][$error_type] = $error_message;
	}
	
	function getServiceCredentialLabel($service, $credential){
		return $this->service[$service]['credentials'][$credential]['input_label'];
	}

	function getServiceCredentialHelp($service, $credential, $dir_img = ''){
		
		$dir_img = $dir_img ? $dir_img.'/' : '';
		
		if($credential_res = $this->getServiceCredential($service, $credential)){
		
			$cfgenwp_api_help_link = (isset($credential_res['help']) && $credential_res['help'] ? $credential_res['help']:'');
			
			if($cfgenwp_api_help_link){
				return('<a href="'.$cfgenwp_api_help_link.'" target="_blank"><img src="'.$dir_img.'img/api-help.png" class="cfgenwp-api-help"></a>');
			}
		}
	}
	
	
	function getServiceCredential($service, $credential){
	
		$c = isset($this->service[$service]['credentials'][$credential]) ? $this->service[$service]['credentials'][$credential] : false;
		
		return $c;
	}
	
	function getServiceCredentialInput($service, $credential, $input_config){
	
		if($credential_res = $this->getServiceCredential($service, $credential)){
			
			// this attribute is only used in the form builder config page
			if(!isset($input_config['attr']['name'])){ $input_config['attr']['name'] = '';}
			
			$input_attr = 'name="'.$input_config['attr']['name'].'" id="'.$input_config['attr']['id'].'" class="'.$input_config['attr']['class'].'"';
			
			$placeholder = 'placeholder="'.$credential_res['placeholder'].'"';
			
			if($credential_res['input_type'] == 'textarea'){
				$input = '<textarea '.$placeholder.' '.$input_attr.'>'.$input_config['attr']['value'].'</textarea>';
			}
			
			if($credential_res['input_type'] == 'text' || $credential_res['input_type'] == 'password'){
				$input = '<input '.$placeholder.' type="'.$credential_res['input_type'].'" '.$input_attr.' value="'.$input_config['attr']['value'].'">';
			}
			
			if(isset($credential_res['append']) && $credential_res['append']){
				$input .= $credential_res['append'];
			}
		}
		
		return $input;
	}
}

?>