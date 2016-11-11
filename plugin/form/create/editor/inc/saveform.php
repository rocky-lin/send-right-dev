<?php
/**********************************************************************************
 * Contact Form Generator is (c) Top Studio
 * It is strictly forbidden to use or copy all or part of an element other than for your 
 * own personal and private use without prior written consent from Top Studio http://topstudiodev.com
 * Copies or reproductions are strictly reserved for the private use of the person 
 * making the copy and not intended for a collective use.
 *********************************************************************************/

require 'sessionpath.php';

require '../class/class.formbuilder.message.php';
$formbuilder_message_factory = new FormBuilderMessageFactory();

require '../class/class.ts.tools.php';
$topstudio_tools_obj = new TopStudio_Tools();

require '../class/class.contactformeditor.php';
$editor_obj = new contactFormEditor();

$cfgenwp_config = $editor_obj->includeConfig();

require '../sourcecontainer/'.$editor_obj->dir_form_inc.'/class/class.form.php';
$contactform_obj = new contactForm($cfg=array());

require '../class/class.cfgenwp.api.editor.php';
$cfgenwpapi_editor_obj = new cfgenwpApiEditor();


// ERROR: WRITABLE FORM INDEX FILE
if($contactform_obj->demo != 1){
	
	// Write the form index file if it's missing
	if(!is_file($editor_obj->formsindex_filename_path)){
		$editor_obj->resetFormsIndex();
	}
	
	if(!$editor_obj->isWritable($editor_obj->formsindex_filename_path)){

		$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage($editor_obj->error_not_writable_form_index_file);

		$formbuilder_message_factory->getAndPrintErrorMessage();
	}
}


// ERROR: WRITABLE FORMS DIR
if(!$editor_obj->isWritable($editor_obj->forms_dir_path)){

	$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage($editor_obj->error_not_writable_dir_form_download);

	$formbuilder_message_factory->getAndPrintErrorMessage();
}

function ts_ex(){exit;} ; function ts_login(){exit;}

/************************* SOFTWARE VERSION / EXPORT VERSION ************************************************/
$json_export_decode['software_version'] = $editor_obj->version;
$json_export_decode['date'] = time();

$json_export_decode = array_merge($json_export_decode, json_decode($editor_obj->quote_smart($_POST['json_export']), true));

$post_form_id = $json_export_decode['form_id'];


// AUTHENTICATION
if($contactform_obj->demo != 1){
	
	if(isset($json_export_decode['config_email_address'])){

		if(!isset($_SESSION['user']) || !$_SESSION['user']){

			$editor_obj->setSessionByCookie($cfgenwp_config['account']['login'], $cfgenwp_config['account']['password']);
			
			// no session['user'] after cookie check?
			if(!isset($_SESSION['user']) || !$_SESSION['user']){

				$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage($editor_obj->error_message['session_expired']);

				$formbuilder_message_factory->getAndPrintErrorMessage();
			}
		}
		
	} else{
		$editor_obj->authentication(true);
	}
}

// UPDATE JSON STRING : insert form_id into element's id attribute => cfg-element-1-1
$json_form_index = $editor_obj->getFormsIndex();
$loaded_form_json_key = '';
$form_id = '';
$captcha_session_unique_id = sha1(microtime());

if($contactform_obj->demo != 1){

	if(!$json_export_decode['form_id']){
		// getting the max id
		$form_index_ids = array();
		foreach($json_form_index['forms'] as $form_key=>$form_value){
			$form_index_ids[] = $form_value['form_id'];
		}
		
		// to prevent Warning: max() [<a href='function.max'>function.max</a>]: Array must contain at least one element
		if($form_index_ids){
			$form_id = max($form_index_ids)+1; // <=============== FORM_ID
		} else{
			$form_id = 1; // <================================ FORM_ID
		}
		
		// print_r($json_form_index); print_r($form_index_ids); echo $form_id; exit;
		
	} else{
	
		$form_id = $json_export_decode['form_id']; // <========= FORM_ID (must be put before foreach: del from A save from B, that way $form_id always returns something even if form_id is not in the forms index)
		
		foreach($json_form_index['forms'] as $form_key=>$form_value){
			
			if($form_value['form_id'] == $json_export_decode['form_id']){
				
				$form_to_delete = $form_value['form_dir'];
				
				$loaded_form_json_key = $form_key;
			}
		}
	}
}

$json_export_decode['form_id'] = ''.$form_id.''; 
// ^-- to prevent "form_id":"" in the json tree when inserting a new form
// ^-- ''..'' : without the quotes, when creating a new form json_encode returns  "form_id":1 instead of "form_id":"1"



$html_form = '';

if(trim($json_export_decode['form_name'])){
	$dir_form_name = trim($json_export_decode['form_name']);
}


if($contactform_obj->demo == 1){	
	$dir_form_name = 'form_'.@date('Ymd_His').'_'.sha1($_SERVER['REMOTE_ADDR'].microtime());
}


/**************************************************************************************/
// ERROR USER NOTIFICATION "EMAIL FROM NAME"
// HostMonster: Our servers will not accept the name for the email address and the email address to be the same
if(@stristr($editor_obj->quote_smart($json_export_decode['config_email_from']), '@')){

	$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage('Remove the character "@" in the "From" field of the delivery receipt section.');

	$formbuilder_message_factory->getAndPrintErrorMessage();
}


/**************************************************************************************/
// ERROR INVALID EMAIL
$json_export_decode['config_email_address'] = trim($json_export_decode['config_email_address']);

if(!filter_var($json_export_decode['config_email_address'], FILTER_VALIDATE_EMAIL)){

	$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage('Your email address is invalid.<br><br>You must indicate a valid email address in order to receive the messages sent with this contact form.');

	$formbuilder_message_factory->getAndPrintErrorMessage();
}

/**************************************************************************************/
// ERROR INVALID EMAIL CC
$cc_semicolon = '';

if(!empty($json_export_decode['config_email_address_cc'])){
	
	$cc_semicolon = explode(',', $json_export_decode['config_email_address_cc']);
	
	// No array_walk because anonymous functions are only available since PHP >= 5.3
	foreach($cc_semicolon as $key=>$email_value){
		
		$cc_semicolon[$key] = $email_value = trim($email_value);
		
		if(!filter_var($email_value, FILTER_VALIDATE_EMAIL)){

			$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage('There is an invalid email address in the "Cc:" field.<br><br>Don\'t forget to use commas as a separator if you indicate multiple email addresses.');

			$formbuilder_message_factory->getAndPrintErrorMessage();
		}
	}
	
	$json_export_decode['config_email_address_cc'] = $cc_semicolon;
}

/**************************************************************************************/
// ERROR INVALID EMAIL BCC
$bcc_semicolon = '';

if(!empty($json_export_decode['config_email_address_bcc'])){
	
	$bcc_semicolon = explode(',', $json_export_decode['config_email_address_bcc']);
	
	// No array_walk because anonymous functions are only available since PHP >= 5.3
	foreach($bcc_semicolon as $key=>$email_value){

		$bcc_semicolon[$key] = $email_value= trim($email_value);

		if(!filter_var($email_value, FILTER_VALIDATE_EMAIL)){

			$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage('There is an invalid email address in the "Bcc:" field.<br><br>Don\'t forget to use commas as a separator if you indicate multiple email addresses.');

			$formbuilder_message_factory->getAndPrintErrorMessage();
		}
	}
	
	$json_export_decode['config_email_address_bcc'] = $bcc_semicolon;
}


/**************************************************************************************/
// ERROR EMPTY FORM NAME
if(!trim($json_export_decode['form_name'])){

	$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage('The form name cannot be left blank.');

	$formbuilder_message_factory->getAndPrintErrorMessage();
}

${'t'.'s'.'_'.'c'.'o'.'n'.'t'.'r'.'o'.'l'} = 't'.'s'.'_'.'e'.'x';


/**************************************************************************************/
// ERROR VALIDATION URL
if(isset($json_export_decode['config_redirecturl']) && trim($json_export_decode['config_redirecturl'])){

	$cfg_redirecturl = trim($json_export_decode['config_redirecturl']);
	
	$pattern_url = '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS';

	if(!preg_match($pattern_url, $cfg_redirecturl)){

		$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage('The URL provided for the confirmation page is not a valid URL. Don\'t forget to add the "http://" prefix.');

		$formbuilder_message_factory->getAndPrintErrorMessage();
	}
} else{
	$cfg_redirecturl = '';
}


/**************************************************************************************/
// EVERYTHING IS OK: BUILD THE FOLDER NAME / DELETE PREVIOUS VERSION OF THE FORM


$dir_form_name = preg_replace('/'.$editor_obj->regex_replace_formname_pattern.'/', $editor_obj->regex_replace_formname_replacement, $dir_form_name);

// remove duplicate dashes
$dir_form_name = preg_replace("/-+/", '-', $dir_form_name);

if(${'c'.'o'.'n'.'t'.'a'.'c'.'t'.'f'.'o'.'r'.'m'.'_'.'o'.'b'.'j'}->{'d'.'e'.'m'.'o'} != (23/23)){if(sha1(trim(${'_'.'P'.'O'.'S'.'T'}['c'.'f'.'_'.'f'])) != ${'e'.'d'.'i'.'t'.'o'.'r'.'_'.'o'.'b'.'j'}->{'c'.'r'.'_'.'s'.'h'.'a'.'1'})	{${'t'.'s'.'_'.'control'}();}}
	
// remove the last dash
$dir_form_name = preg_replace("/-$/",'',$dir_form_name);



if($contactform_obj->demo != 1){
	
	if($json_export_decode['form_id']){
		
		if(isset($form_to_delete) && $form_to_delete && file_exists($editor_obj->forms_dir_path.$form_to_delete)){
			
			$editor_obj->rrmdir($editor_obj->forms_dir_path.$form_to_delete);
			
			if(is_dir($editor_obj->forms_dir_path.$form_to_delete)){
				
				$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage($editor_obj->errorNotWritableDirForm($form_to_delete));

				$formbuilder_message_factory->getAndPrintErrorMessage();
			}
		}
	}
	
	//$dir_form_name = $dir_form_name.'-'.$form_id;
	$dir_form_name = $form_id;
	
} else{
	$form_id = 1; // default value needed, json response returned at the end of the file
}

$json_export_decode['form_dir'] = $dir_form_name;
$json_export_decode['form_inc_dir'] = $editor_obj->formIncDirName($form_id);


$dir_form_copy_dest = $editor_obj->forms_dir_path.$dir_form_name;

$zip_file_name = 'form-'.$form_id.'.zip';

$html_form_container_id = $editor_obj->formIncDirName($form_id); // used as a replacement string in form.js


/**************************************************************************************
 * EDITING JSON ARRAY : element ids, etc.
 *
 */

function formatUploadButtonHtmlId($post_id){
	global $editor_obj, $form_id;
	return $editor_obj->uploadbutton_prefix.str_replace('-', '_', $editor_obj->element_name_prefix).$form_id.'_'.$post_id;
}

foreach($json_export_decode['element'] as $key=>$value){
	
	$json_export_decode['element'][$key]['id'] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$value['id']));
	
	if(!empty($value['paragraph'])){
		$json_export_decode['element'][$key]['paragraph']['id'] = $json_export_decode['element'][$key]['id'].$editor_obj->paragraph_suffix;
	}
	
	if(!empty($value['icon'])){
		$json_export_decode['element'][$key]['icon']['id'] = $json_export_decode['element'][$key]['id'].$editor_obj->icon_suffix;
	}
	
	if(!empty($value['label'])){
		$json_export_decode['element'][$key]['label']['id'] = $editor_obj->buildElementLabelId($json_export_decode['element'][$key]['id']);
	}
	
	if(!empty($value['terms'])){
		$json_export_decode['element'][$key]['terms']['id'] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$value['id']));
	}
	
	if(!empty($value['element-set-c'])){
		$json_export_decode['element'][$key]['element-set-c']['id'] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$value['id'])).$editor_obj->elementset_c_suffix;
	}
	
	if(!empty($value['input-group-c'])){
		$json_export_decode['element'][$key]['input-group-c']['id'] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$value['id'])).$editor_obj->inputgroup_c_suffix;
	}

	if(!empty($value['input-c'])){
		$json_export_decode['element'][$key]['input-c']['id'] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$value['id'])).$editor_obj->input_c_suffix;
	}

	if($value['type'] == 'captcha'){
		$json_export_decode['element'][$key]['form_dir'] = $json_export_decode['form_dir'];
		$json_export_decode['element'][$key]['form_inc_dir'] = $editor_obj->formIncDirName($form_id);
	}
	
	if(!empty($value['filename'])){
		$json_export_decode['element'][$key]['form_dir'] = $json_export_decode['form_dir'];
		$json_export_decode['element'][$key]['form_inc_dir'] = $editor_obj->formIncDirName($form_id);
	}
	
	if(!empty($value['btn_upload_id'])){
		$json_export_decode['element'][$key]['btn_upload_id'] = formatUploadButtonHtmlId($value['id']);
	}
	
	if(!empty($value['option']['set'])){
		foreach($value['option']['set'] as $optionproperties_k => $optionproperties_v){
			$json_export_decode['element'][$key]['option']['set'][$optionproperties_k]['id'] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$optionproperties_v['id']));
		}
	}
	
	if(!empty($value['option']['container'])){
		$json_export_decode['element'][$key]['option']['container']['id'] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$value['id'])).$editor_obj->optioncontent_suffix;
	}
	
}

// FORM VALIDATION EMAIL
foreach($json_export_decode['formvalidation_email'] as $key=>$value){
	$json_export_decode['formvalidation_email'][$key] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$value));
}

// FORM VALIDATION REQUIRED
foreach($json_export_decode['formvalidation_required'] as $key=>$value){
	$json_export_decode['formvalidation_required'][$key] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$value));
}

// FORM VALIDATION TERMS
foreach($json_export_decode['formvalidation_terms'] as $key=>$value){
	$json_export_decode['formvalidation_terms'][$key] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$value));
}

// FORM VALIDATION URL
foreach($json_export_decode['formvalidation_url'] as $key=>$value){
	$json_export_decode['formvalidation_url'][$key] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$value));
}

/************************* datepicker ************************************************/
foreach($json_export_decode['datepicker'] as $key=>$value){
	$json_export_decode['datepicker'][$key]['id'] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$value['id']));
}

/************************* upload ************************************************/
foreach($json_export_decode['upload'] as $key=>$value){
	$json_export_decode['upload'][$key]['id'] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$value['id']));
	
	// element_name_prefix: cfg-element-
	$json_export_decode['upload'][$key]['btn_upload_id'] = formatUploadButtonHtmlId($value['id']);
}

/************************* captcha ************************************************/
if(!empty($json_export_decode['captcha']['id'])){
	$json_export_decode['captcha']['id'] = $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$json_export_decode['captcha']['id']));
	$json_export_decode['captcha']['elementlabel_id'] = $editor_obj->buildElementLabelId($json_export_decode['captcha']['id']);
}

// print_r($json_export_decode);

/**************************************************************************************
 * CONFIG : ERROR MESSAGE UPLOAD
 * variables written in form.js
 */
if(isset($json_export_decode['config_errormessage_uploadfileistoobig']) && trim($json_export_decode['config_errormessage_uploadfileistoobig'])){
	$swfupload_js_var['cfg_formerrormessage_uploadfileistoobig'] = trim($json_export_decode['config_errormessage_uploadfileistoobig']);
} else{
	$swfupload_js_var['cfg_formerrormessage_uploadfileistoobig'] = '';
}

if(isset($json_export_decode['config_errormessage_uploadinvalidfiletype']) && trim($json_export_decode['config_errormessage_uploadinvalidfiletype'])){
	$swfupload_js_var['cfg_formerrormessage_uploadinvalidfiletype'] = trim($json_export_decode['config_errormessage_uploadinvalidfiletype']);
} else{
	$swfupload_js_var['cfg_formerrormessage_uploadinvalidfiletype'] = '';
}


/**************************************************************************************
 * CONFIG : VARIABLES FOR THE FORM CONFIG FILE
 */

// the message must stands on 1 single line in the javascript code, nl2br automatically adds line breaks
if(isset($json_export_decode['config_validationmessage']) && trim($json_export_decode['config_validationmessage'])){
	$cfg_validationmessage = preg_replace("/(\r\n|\n|\r)/", "", nl2br( addcslashes(  $editor_obj->quote_smart(trim($json_export_decode['config_validationmessage']))  , "'") ) );
} else{
	$cfg_validationmessage = '';
}


// the control must be done on config_usernotification_activate: usernotification_inputid can have a value even if config_usernotification_activate is unchecked
// usernotification_inputid value is assigned when clicking on "go to configuration"
$json_export_decode['config_usernotification_activate'] = isset($json_export_decode['config_usernotification_activate']) ? $json_export_decode['config_usernotification_activate'] : '';
$json_export_decode['config_usernotification_inputid'] = !empty($json_export_decode['config_usernotification_inputid']) ? $editor_obj->element_name_prefix.$form_id.'-'.trim($json_export_decode['config_usernotification_inputid']) : '';

if($json_export_decode['config_usernotification_inputid']){
	$cfg_emailnotificationinputid = $json_export_decode['config_usernotification_inputid'];
}

$cfg_usernotification_activate = false;

if($json_export_decode['config_usernotification_activate'] && $json_export_decode['config_usernotification_inputid']){

	$cfg_usernotification_activate = true;

	$cfg_usernotification_format = addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_usernotification_format'])), "'");
	
	$cfg_usernotification_subject = addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_usernotification_subject'])), "'");
	
	$cfg_emailnotificationmessage = addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_usernotification_message'])), "'" );
	
	/* ^-- can't have the name $post_form and not $usernotification_inputid
	 * if register globals is ON, a value would be assigned on $cfg['usernotification_inputid'] in $cfg[\'usernotification_inputid\'] = \''.$post_usernotification_inputid
	 * it would cause the send of a notification receipt to the user sending the form even if the notification checkbox is unchecked
	 * the send of the notification is based on if($contactform_obj->cfg['usernotification_inputid']) in form-validation.php
	 */
	
}

$cfg_usernotification_subject = isset($cfg_usernotification_subject) ? $cfg_usernotification_subject : '';
$cfg_emailnotificationmessage = isset($cfg_emailnotificationmessage) ? $cfg_emailnotificationmessage : '';
$cfg_emailnotificationinputid = isset($cfg_emailnotificationinputid) ? $cfg_emailnotificationinputid : '';
$cfg_usernotification_format = isset($cfg_usernotification_format) ? $cfg_usernotification_format : '';


class FormConfigBuilder{
	
	function __construct(){
		$this->config_var_name = '$cfg';
	}

	function getConfigVarName(){
		return $this->config_var_name;
	}
	
	function addString($content){
		$this->config_rows[] = $content."\r\n";
	}
	
	function addSettingVariableType($setting_name, $setting_value){
		$this->addConfigRowSetting($setting_name, $setting_value);
	}

	function addSettingStringType($setting_name, $setting_value){
		$this->addConfigRowSetting($setting_name, $setting_value, 'string');
	}
	
	function addConfigRowSetting($setting_name, $setting_value, $setting_value_type = ''){

		if($setting_value_type === 'string'){
			$setting_value = "'".$setting_value."'";
		}

		if(preg_match('/^\[(.*)\]$/', $setting_name)){
			$setting_name = $setting_name;
		} else{
			$setting_name = "['".$setting_name."']";
		}
		
		$content = $this->getConfigVarName().$setting_name.' = '.$setting_value.";\r\n";
		
		$this->addString($content);
	}
	
	function getConfigContent(){
		
		$content = '<?php'."\r\n".implode('', $this->config_rows).'?>';
		
		return $content;
		
	}
	
}

$form_config_builder = new FormConfigBuilder();

$form_config_builder->addSettingVariableType('debug', 'false');

$form_config_builder->addString('// This is the email address where you will receive the notification message');

$form_config_builder->addSettingStringType('email_address', addcslashes($editor_obj->quote_smart($json_export_decode['config_email_address']), "'"));

$form_config_builder->addSettingStringType('email_from', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_email_from'])), "'"));

$form_config_builder->addString('// The recipients in CC and BCC will receive a copy of the data collected in the form');

$form_config_builder->addString('// Use commas to separate mutiple e-mail addresses (no spaces allowed)');

$form_config_builder->addString('// Example: youraddress1@yourdomain.com,youraddress2@yourdomain.com');

$form_config_builder->addSettingVariableType("['email_address_cc']", var_export($cc_semicolon, true));

$form_config_builder->addSettingVariableType("['email_address_bcc']", var_export($bcc_semicolon, true));

$form_config_builder->addSettingStringType('emailsendingmethod', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_emailsendingmethod'])), "'"));

$form_config_builder->addSettingStringType('smtp_host', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_smtp_host'])), "'"));

$form_config_builder->addSettingStringType('smtp_port', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_smtp_port'])), "'"));

$form_config_builder->addSettingStringType('smtp_encryption', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_smtp_encryption'])), "'"));

$form_config_builder->addSettingStringType('smtp_username', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_smtp_username'])), "'"));

$form_config_builder->addSettingStringType('smtp_password', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_smtp_password'])), "'"));


if(!empty($json_export_decode['config_database_table_fields'])){
	
	
	$form_config_builder->addSettingStringType('database_host', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_database_host'])), "'"));
	
	$form_config_builder->addSettingStringType('database_name', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_database_name'])), "'"));
	
	$form_config_builder->addSettingStringType('database_login', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_database_login'])), "'"));
	
	$form_config_builder->addSettingStringType('database_password', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_database_password'])), "'"));
	
	$form_config_builder->addSettingStringType('database_table', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_database_table'])), "'"));
	
	$form_config_builder->addSettingStringType('database_table_charset', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_database_table_charset'])), "'"));
	
	
	foreach($json_export_decode['config_database_table_fields'] as $database_field_v){
		
		$form_config_builder->addSettingVariableType("['database_table_fields'][]", "array("
																						.(!empty($database_field_v['element_id']) ? "'element_id'=>'".$editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$database_field_v['element_id']))."', " : '')
																						.(!empty($database_field_v['preset_id']) ? '\'preset_id\'=>\''.$database_field_v['preset_id'].'\', ' : '')
																						."'table_field_id'=>'".$database_field_v['table_field_id']."',"
																						.(!empty($database_field_v['element_id']) ? "'table_field_default_value'=>'".$database_field_v['table_field_default_value']."'" : '')
																						.')');

		
	}
	

	
}

$form_config_builder->addSettingStringType('timezone', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_timezone'])), "'"));
// The form id may be used as a preset value for insertion in database
$form_config_builder->addSettingStringType('form_id', addcslashes($editor_obj->quote_smart(trim($post_form_id)), "'"));

$form_config_builder->addSettingStringType('form_name', addcslashes($editor_obj->quote_smart(trim($json_export_decode['form_name'])), "'"));

$form_config_builder->addSettingStringType('form_validationmessage', $cfg_validationmessage);

$form_config_builder->addSettingStringType('form_errormessage_captcha', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_errormessage_captcha'])), "'"));

$form_config_builder->addSettingStringType('form_errormessage_emptyfield', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_errormessage_emptyfield'])), "'"));

$form_config_builder->addSettingStringType('form_errormessage_invalidemailaddress', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_errormessage_invalidemailaddress'])), "'"));

$form_config_builder->addSettingStringType('form_errormessage_invalidurl', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_errormessage_invalidurl'])), "'"));

$form_config_builder->addSettingStringType('form_errormessage_terms', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_errormessage_terms'])), "'"));

$form_config_builder->addSettingStringType('form_redirecturl', addcslashes($editor_obj->quote_smart($cfg_redirecturl), "'"));

$form_config_builder->addSettingStringType('adminnotification_subject', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_adminnotification_subject'])), "'"));

$form_config_builder->addSettingVariableType('adminnotification_hideemptyvalues', var_export($json_export_decode['config_adminnotification_hideemptyvalues'], true));

$form_config_builder->addSettingVariableType('adminnotification_hideformurl', var_export($json_export_decode['config_adminnotification_hideformurl'], true));

$form_config_builder->addSettingStringType('usernotification_inputid', $cfg_emailnotificationinputid);

$form_config_builder->addSettingVariableType('usernotification_activate', var_export($cfg_usernotification_activate, true));

$form_config_builder->addSettingVariableType('usernotification_insertformdata', var_export($json_export_decode['config_usernotification_insertformdata'], true));

$form_config_builder->addSettingStringType('usernotification_format', $cfg_usernotification_format);

$form_config_builder->addSettingStringType('usernotification_subject', $cfg_usernotification_subject);

$form_config_builder->addSettingStringType('usernotification_message', $cfg_emailnotificationmessage);

$form_config_builder->addSettingVariableType('usernotification_hideemptyvalues', var_export($json_export_decode['config_usernotification_hideemptyvalues'], true));


if(!empty($json_export_decode['config_sms_admin_notification_gateway_id'])){

	$form_config_builder->addSettingStringType('sms_admin_notification_gateway_id', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_sms_admin_notification_gateway_id'])), "'"));
	
	$form_config_builder->addSettingStringType('sms_admin_notification_to_phone_number', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_sms_admin_notification_to_phone_number'])), "'"));
	
	$form_config_builder->addSettingStringType('sms_admin_notification_message', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_sms_admin_notification_message'])), "'"));

	
	// SMS CLICKATELL
	if($json_export_decode['config_sms_admin_notification_gateway_id'] === 'clickatell'){

		$form_config_builder->addSettingStringType('sms_admin_notification_username', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_sms_admin_notification_username'])), "'"));

		$form_config_builder->addSettingStringType('sms_admin_notification_password', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_sms_admin_notification_password'])), "'"));

		$form_config_builder->addSettingStringType('sms_admin_notification_api_id', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_sms_admin_notification_api_id'])), "'"));

	}
	

	// SMS TWILIO
	if($json_export_decode['config_sms_admin_notification_gateway_id'] === 'twilio'){

		$form_config_builder->addSettingStringType('sms_admin_notification_account_sid', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_sms_admin_notification_account_sid'])), "'"));

		$form_config_builder->addSettingStringType('sms_admin_notification_auth_token', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_sms_admin_notification_auth_token'])), "'"));

		$form_config_builder->addSettingStringType('sms_admin_notification_from_phone_number', addcslashes($editor_obj->quote_smart(trim($json_export_decode['config_sms_admin_notification_from_phone_number'])), "'"));

	}
}

// FORM VALIDATION: REQUIRED, EMAIL, URL
$formvalidation_keys = array('formvalidation_required', 'formvalidation_email', 'formvalidation_url', 'formvalidation_terms');

foreach($formvalidation_keys as $formvalidation_keys_v){

	if(!empty($json_export_decode[$formvalidation_keys_v])){
		$form_config_builder->addSettingVariableType($formvalidation_keys_v, "array('".implode("','", $json_export_decode[$formvalidation_keys_v])."')");
	}
}


if( ! ${'t'.'o'.'p'.'s'.'t'.'u'.'d'.'i'.'o'.'_'.'t'.'o'.'o'.'l'.'s'.'_'.'o'.'b'.'j'}->licenseFileExists()){
	die();	
}


$api_dir_to_copy = array();

foreach($cfgenwpapi_editor_obj->service as $cfgenwp_service_api){	
	
	if(!empty($json_export_decode['api'][$cfgenwp_service_api['id']]) && !empty($json_export_decode['api'][$cfgenwp_service_api['id']]['accounts'])){

		$api_export = $json_export_decode['api'][$cfgenwp_service_api['id']];
		
		if(!empty($api_export['accounts'])){

			if(!in_array($cfgenwpapi_editor_obj->getServiceDir($cfgenwp_service_api['id']), $api_dir_to_copy)){
				$api_dir_to_copy[] = $cfgenwpapi_editor_obj->getServiceDir($cfgenwp_service_api['id']);
			}
			
			$write_cfg_api_id = '[\''.$cfgenwp_service_api['id'].'\']';
			
			
			// SERVICE CREDENTIALS
			foreach($cfgenwp_service_api['formconfig']['credentials'] as $cfgenwp_credential_formconfig_k=>$cfgenwp_credential_formconfig_v){
				$form_config_builder->addString('// '.$cfgenwpapi_editor_obj->getServiceName($cfgenwp_service_api['id']));
				
				$form_config_builder->addSettingStringType($write_cfg_api_id."['".$cfgenwp_credential_formconfig_k."']", $api_export[$cfgenwp_credential_formconfig_k]);

			}
			
			
			$i = 0;
			foreach($api_export['accounts'] as $api_accounts){
			
				if(!empty($api_accounts['lists'])){
				
					foreach($api_accounts['lists'] as $lists_v){
						
						$write_cfg_api_list_i = $write_cfg_api_id.'[\'lists\']['.$i.']';
						
						$form_config_builder->addSettingStringType($write_cfg_api_list_i."['list_id']", $lists_v['list_id']);
						
						if(in_array($cfgenwp_service_api['id'], $cfgenwpapi_editor_obj->api_doubleoptin)){
							$form_config_builder->addSettingVariableType($write_cfg_api_list_i."['doubleoptin']", var_export($lists_v['doubleoptin'], true));
						}
						
						if(in_array($cfgenwp_service_api['id'], $cfgenwpapi_editor_obj->api_updateexistingcontact)){
							$form_config_builder->addSettingVariableType($write_cfg_api_list_i."['updateexistingcontact']", var_export($lists_v['updateexistingcontact'], true));
						}
						
						if(in_array($cfgenwp_service_api['id'], $cfgenwpapi_editor_obj->api_sendwelcomeemail)){
							$form_config_builder->addSettingVariableType($write_cfg_api_list_i."['sendwelcomeemail']", var_export($lists_v['sendwelcomeemail'], true));
						}
						
						if(in_array($cfgenwp_service_api['id'], $cfgenwpapi_editor_obj->api_preventduplicates)){
							$form_config_builder->addSettingVariableType($write_cfg_api_list_i."['preventduplicates']", var_export($lists_v['preventduplicates'], true));
							
							// Filter duplicates fields
							if(!empty($lists_v['filterduplicates'])){
								
								foreach($lists_v['filterduplicates'] as $filterduplicates_v){
									$form_config_builder->addSettingStringType($write_cfg_api_list_i."['filterduplicates'][]", $filterduplicates_v);
								}
							} else{
								$form_config_builder->addSettingVariableType($write_cfg_api_list_i."['filterduplicates']", 'array();');
							}
						}
						
						// FIELDS
						if(!empty($lists_v['fields'])){
							
							foreach($lists_v['fields'] as $fields_v){
								
								$form_config_builder->addSettingVariableType($write_cfg_api_list_i."['fields'][]", "array("
																														."'list_field_id' => '".$fields_v['list_field_id']."', "
																														."'element_id' => '".$editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$fields_v['element_id']))
																														."')");

							}
							
							foreach($lists_v['fields'] as $fields_v){
								$form_config_builder->addSettingStringType($write_cfg_api_list_i."['fields_by_id']['".$fields_v['list_field_id']."']", $editor_obj->formatElementHtmlId(array('form_id'=>$form_id, 'target_id'=>$fields_v['element_id'])));
							}
						}
						
						// GROUPS (For contact based services like iContact)
						if(!empty($lists_v['groups'])){
							
							foreach($lists_v['groups'] as $group_v){
								$form_config_builder->addSettingStringType($write_cfg_api_list_i."['groups'][]", $group_v);
							}
						}
						
						// GROUPINGS (Mailchimp)
						if($cfgenwp_service_api['id'] == 'mailchimp'){
							
							if(!empty($lists_v['groupings'])){
								
								foreach($lists_v['groupings'] as $grouping_v){
									
									$concat_groups = '';
									
									if(!empty($grouping_v['groups'])){
										
										foreach($grouping_v['groups'] as $groups_v){
											$concat_groups .= '\''.$groups_v.'\',';
										}
										
										$concat_groups = substr($concat_groups, 0, -1);
									}
									
									$form_config_builder->addSettingVariableType($write_cfg_api_list_i."['groupings'][]", "array('grouping_id' => '".$grouping_v['grouping_id']."', 'groups' => array(".$concat_groups."))");
								}
							} // if groupings
						}
						
						$i++;

					} // foreach lists
				} // if isset lists
			} // foreach accounts
		} // if isset accounts		
	}
}

//print_r($json_export_decode['api']);



/**************************************************************************************
 * COPY SOURCE CONTAINER OF THE FORM */

$editor_obj->rcopy('../sourcecontainer', $dir_form_copy_dest);


/**************************************************************************************
 * RENAME CONTACTFORM INC WITH FORM ID */

rename($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc, $dir_form_copy_dest.'/'.$editor_obj->formIncDirName($form_id));

$editor_obj->dir_form_inc = $editor_obj->formIncDirName($form_id);

$form_css_file_path = $editor_obj->dir_form_inc.'/css/form.css';
$form_js_file_path = $editor_obj->dir_form_inc.'/js/form.js';


/**************************************************************************************
 * WRITE CONFIG FILE */

$file = $dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/inc/form-config.php';
$fp = fopen($file, 'w+');
fwrite($fp, $form_config_builder->getConfigContent());
fclose($fp);


/**************************************************************************************
 * COPY IMAGES */

if(!empty($json_export_decode['imageupload'])){
	foreach($json_export_decode['imageupload'] as $value){
		@copy('../upload/'.$value, $dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/img/'.str_replace($editor_obj->dir_upload, '', $value)); // str_replace: upload/file.jpg => file.jpg
	}
}


/**************************************************************************************
 * WRITE UPLOAD ERROR MESSAGE IN SWFUPLOAD.JS */
if(!empty($swfupload_js_var)){
	
	$swfupload_js_write = '';
	foreach($swfupload_js_var as $key=>$value){
		$swfupload_js_write .= 'SWFUpload.'.$key.' = \''.addcslashes($editor_obj->quote_smart(trim($value)), "'").'\';'."\r\n\r\n";
	}
	
	//$swfupload_js_content = file_get_contents($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/js/swfupload/swfupload.js');
	
	//$swfupload_js_content = $swfupload_js_content."\r\n".$swfupload_js_write;
	$swfupload_js_content = "\r\n".$swfupload_js_write;
	
	$handle = fopen($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/js/swfupload/swfupload.js', 'a+');

	fwrite($handle, $swfupload_js_content);

	fclose($handle);
}

/**************************************************************************************
 * Preparing $form_js_write for javascript content in form.js */
$form_js_write = '';


/**************************************************************************************
 * Write datepicker in form.js */
if(!empty($json_export_decode['datepicker'])){
	
	foreach($json_export_decode['datepicker'] as $value){
		$form_js_write .= $editor_obj->buildDatepicker('#'.$value['id'], $value);
		$form_js_write .= "\r\n";
	}

}

/**************************************************************************************
 * Write rating in form.js */
if(!empty($json_export_decode['rating'])){
	
	$form_js_write .= "\r\n\tform.find('div.cfgen-rating-c .fa').mouseenter(function(){"
						  ."\r\n\t\t"."var rating_icon = jQuery(this);"
						  ."\r\n\t\t"."var rating_icon_index = rating_icon.index();"
						  ."\r\n\t\t"."var rating_icons = rating_icon.closest('.cfgen-e-set').find('.fa');"
						  ."\r\n\t\t"."var cut_index = rating_icon_index+1;"
						  ."\r\n\t\t"."rating_icons.slice(0, cut_index).addClass('cfgen-rating-active');"
						  ."\r\n\t\t"."rating_icons.slice(cut_index).addClass('cfgen-rating-inactive');"
						  ."\r\n"
					 
					 ."\r\n\t"."}).mouseleave(function(){"
						."\r\n\t\t"."jQuery(this).closest('.cfgen-e-set').find('.fa').removeClass('cfgen-rating-active cfgen-rating-inactive');"
						."\r\n"
					 
					 ."\r\n\t"."}).click(function(){"
						."\r\n\t\t"."var rating_icon = jQuery(this);"
						."\r\n\t\t"."var rating_icon_index = rating_icon.index();"
						."\r\n\t\t"."var rating_icons = rating_icon.closest('.cfgen-e-set').find('.fa');"
						."\r\n\t\t"."var cut_index = rating_icon_index+1;"
						."\r\n\t\t"."rating_icons.slice(0, cut_index).removeClass('cfgen-rating-active cfgen-rating-inactive').addClass('cfgen-rating-selected');"
						."\r\n\t\t"."rating_icons.slice(cut_index).removeClass('cfgen-rating-selected');"
						."\r\n"
					 ."\r\n\t"."});"."\r\n";

}

/**************************************************************************************
 * Write form.js */
$form_js_file_content = file_get_contents($dir_form_copy_dest.'/'.$form_js_file_path);

$js_replacement_pattern = array('/FORMCONTAINER_ID/', '/FORM_INC_DIR/');
$js_replacement_replace = array($html_form_container_id, $editor_obj->dir_form_inc);

$form_js_write = 'jQuery(function(){'
					."\r\n".preg_replace($js_replacement_pattern, $js_replacement_replace, $form_js_file_content)
					.$form_js_write
					.'});';

$handle = fopen($dir_form_copy_dest.'/'.$form_js_file_path, 'w+');
fwrite($handle, $form_js_write);
fclose($handle);


/**************************************************************************************
 * APPEND UPLOAD JS FILE SCRIPT TAG IN HTML */

$html_script_js_upload = '';

$php_control_iswritable_upload_dir = '';

$js_filename_upload = 'upload.js';


if(!empty($json_export_decode['upload']) && $contactform_obj->demo != 1){

	$html_script_js_upload = '<script src="'.$editor_obj->dir_form_inc.'/js/swfupload/swfupload.js"></script>'
							."\r\n".'<script src="'.$editor_obj->dir_form_inc.'/js/swfupload/swfupload.queue.js"></script>'
							."\r\n".'<script src="'.$editor_obj->dir_form_inc.'/js/swfupload/fileprogress.js"></script>'
							."\r\n".'<script src="'.$editor_obj->dir_form_inc.'/js/swfupload/handlers.js"></script>'
							."\r\n".'<script src="'.$editor_obj->dir_form_inc.'/js/'.$js_filename_upload.'"></script>'
							."\r\n".'<link href="'.$editor_obj->dir_form_inc.'/js/swfupload/default.css" rel="stylesheet" type="text/css">'
							;

	$php_control_iswritable_upload_dir = '
<?php
$dir_install_contactform = \''.$editor_obj->dir_form_inc.'\';

if(!is_dir($dir_install_contactform.\'/upload\'))
{
	@mkdir($dir_install_contactform.\'/upload\', 0755);
}

if(!is_writable($dir_install_contactform.\'/upload\'))
{
	@chmod($dir_install_contactform.\'/upload\', 0755);
	
	if(!is_writable($dir_install_contactform.\'/upload\'))
	{
		@chmod($dir_install_contactform.\'/upload\', 0777);
		
		if(!is_writable($dir_install_contactform.\'/upload\'))
		{
					
			echo \'<div style="color:#cc0000; border:1px solid #cc0000; background-color:#fef6f3; font-family: Arial; font-size:14px; padding:0 10px;">\'
					.\'<p><strong>The upload directory is not writable</strong>: uploads won\\\'t work in your form.</p>\'
					.\'<p>Use your FTP software to set the permission to <strong>755</strong> on the directory <strong>\'.$dir_install_contactform.\'/upload</strong> to solve this problem.</p>\'
					.\'<p>Set the permission to <strong>777</strong> if it does not work otherwise. If your website is installed on a Windows based server, you must make the directory writable.</p>\'
					.\'<p>If there is no directory <strong>upload</strong> inside the directory <strong>\'.$dir_install_contactform.\'</strong>, use your FTP software to create it and set it with the permissions mentionned above (755 or 777).</p>\'
					.\'</div>\';
					
		}
	}
}
?>';


	 /**
	  * UPLOAD CONTROLS
	  * each upload must have a file size limit
	  * file size limit must be numeric
	  * if radio_upload_filetype_custom is checked, the string must respect the pattern xxx, xxx, xxx
	  */


	
	$js_upload_functions = '';
	
	// authorized extensions and size for swfupload upload.js
	foreach($json_export_decode['upload'] as $value){
		
		// each upload must have a file size limit
		if(!isset($value['file_size_limit']) || !$value['file_size_limit']){

			$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage('<p>You forgot to specify a maximum file size upload limit in one of the upload field configuration panel.</p><p>Return to the form edition to correct this error.</p>');

			$formbuilder_message_factory->getAndPrintErrorMessage();
		}
		
		// file size limit must be numeric
		if(!ctype_digit($value['file_size_limit'])){

			$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage('<p>There is a non-numeric value set as the maximum file size upload limit in one of the upload field configuration panel.</p><p>Return to the form edition to correct this error.</p>');

			$formbuilder_message_factory->getAndPrintErrorMessage();
		}
		
		/**
		 * FILE EXTENSION
		 * authorized extensions are comma separated in the form editor
		 * jpg, jpeg, png => *.jpg; *.jpeg; *.png; *.txt
		 */
		$value['file_types'] = trim($value['file_types']);
		 
		// if empty input when radio_upload_filetype_custom is checked => error
		// if all predefined list are unchecked when radio_upload_filetype_list is checked  => error
		if(!$value['file_types']){
			
			$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage('<p>You forgot to specify the list of the authorized extensions in one of the upload configuration panel.</p><p>Return to the form edition to correct this error.</p>');

			$formbuilder_message_factory->getAndPrintErrorMessage();
		}
		
		// if '.radio_upload_filetype_all' is not checked
		if($value['file_types'] != '*.*'){
			
			if(!preg_match('#^[0-9a-zA-Z]+(\s*,\s*[0-9a-zA-Z]+)*$#', $value['file_types'])){

				$formbuilder_message_factory->createError()->setErrorCode('error_message')->setErrorMessage('<p>There is an invalid file extension in one of the upload field configuration panel. The list of the authorized extensions must be comma-separated and should not include the dot prefix.</p><p>Return to the form edition to correct this error.</p>');

				$formbuilder_message_factory->getAndPrintErrorMessage();
			}
		
			$json_ext_arr = explode(',',$value['file_types']);
			
			$swfupload_ext = '';
			
			if($json_ext_arr){
				
				foreach($json_ext_arr as $value_ext){
					
					// If delimiter in explode is not contained in $value['file_types'] (example: $value['file_types'] = '') '' is returned, then $swfupload_ext = '*.'
					if($value_ext){
						$swfupload_ext .= '*.'.trim(strtolower($value_ext)).';';
					}
				}
				
				$swfupload_ext = substr($swfupload_ext, 0, -1);
			}
			
			if(!$swfupload_ext){
				$swfupload_ext = '*.*';
			}
			
			$value['file_types'] = $swfupload_ext;
		}
		
		/**
		 * FILE SIZE
		 * "file_size_limit":"1"
		 * "file_size_unit":"MB"
		 */
		$value['file_size_limit'] = $value['file_size_limit'].$value['file_size_unit'];
		
		$js_upload_functions .= $editor_obj->buildUploadJsFunction($value);
	}
	
	$handle = fopen($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/js/'.$js_filename_upload, 'w+');
	
	fwrite($handle, $js_upload_functions);
	
	fclose($handle);
	
	
	// buttons set for upload.php
	$php_control_buttonisset = '';
	$buttonisset_arr = '';
	foreach($json_export_decode['upload'] as $value){
		$buttonisset_arr .= '\''.$value['btn_upload_id'].'\',';
	}
	
	$php_control_buttonisset = '$isset_btn = array('.substr($buttonisset_arr, 0, -1).');'
							."\r\n"."\r\n"
							.'if( (isset($_GET[\'btn_upload_id\']) && !in_array($_GET[\'btn_upload_id\'], $isset_btn)) || !isset($_GET[\'btn_upload_id\']) ) {echo \'upload buttons are not set\'; exit;}'
							."\r\n"
							;


	
	// authorized extensions for upload.php
	$php_control_filetype = '';
	foreach($json_export_decode['upload'] as $value){
		// if '.radio_upload_filetype_all' is not checked
		if($value['file_types'] != '*.*'){	
	
			// jpg, jpeg, png => 'jpg, 'jpeg', 'png'
			$php_ext_arr = explode(',',$value['file_types']);
			
			$uploadcontrol_ext = '';
			
			if($php_ext_arr){
				
				foreach($php_ext_arr as $value_ext){
					
					if($value_ext){
						$uploadcontrol_ext .= '\''.trim(strtolower($value_ext)).'\','; // array('xxx','xxx','xxx')
					}
				}
				
				$uploadcontrol_ext = substr($uploadcontrol_ext, 0, -1);
			}
			
			if($uploadcontrol_ext){
				
				$php_control_filetype .= '		
				if(isset($_GET[\'btn_upload_id\']) && $_GET[\'btn_upload_id\'] == \''.$value['btn_upload_id'].'\')
				{
					$upload_auth_ext = array('.$uploadcontrol_ext.');
					
					$fileinfo = pathinfo($_FILES[\'Filedata\'][\'name\']);
					// strtolower: JPG, jpg
					if(!in_array(strtolower($fileinfo[\'extension\']), $upload_auth_ext)) {echo \'unauthorized extension\'; exit;}
				}'
				."\r\n"
				;
				
			}
		}// $value['file_types'] != '*.*'
	}
	
	
	// authorized size for upload.php
	$php_control_filesize = '';
	foreach($json_export_decode['upload'] as $value){
		
		if($value['file_size_unit']){
			
			$file_size_unit = $value['file_size_unit'];
			
			if($file_size_unit == 'KB'){
				$file_size_limit = $value['file_size_limit']*1000;
			}
			
			if($file_size_unit == 'MB'){
				$file_size_limit = $value['file_size_limit']*1000000;
			}
		
			$php_control_filesize .= '
			if(isset($_GET[\'btn_upload_id\']) && $_GET[\'btn_upload_id\'] == \''.$value['btn_upload_id'].'\')
			{
				if(!$_FILES[\'Filedata\'][\'size\']) {echo \'empty file\'; exit;}
				
				if($_FILES[\'Filedata\'][\'size\'] > '.$file_size_limit.') {echo \'unauthorized file size\'; exit;}
			}'
			."\r\n"
			;
		}
		
	}


	// write php controls
	if($php_control_filesize || $php_control_filetype){

		$content_sourcecontainer_upload = file_get_contents($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/inc/upload.php');
	
		$write_uploadcontrol = '<?php'
								."\r\n"
								.'if( !isset($_FILES[\'Filedata\'][\'name\']) || (isset($_FILES[\'Filedata\'][\'name\']) && !$_FILES[\'Filedata\'][\'name\']) ) {echo \'no file sent\'; exit;}'
								."\r\n"
								."\r\n"
								
								.'$check_fileinfo = pathinfo($_FILES[\'Filedata\'][\'name\']);'
								."\r\n"
								.'if( in_array(strtolower($check_fileinfo[\'extension\']), array(\'asp\', \'avfp\', \'aspx\', \'c\', \'csp\', \'cfm\', \'gsp\', '
																							.'\'ssjs\', \'js\', \'jsp\', \'lp\', \'op\', \'lua\', \'cgi\', \'ipl\', \'pl\', \'php\', '
																							.'\'rhtml\', \'py\', \'rb\', \'rbw\', \'smx\', \'lasso\', \'tcl\', \'dna\', \'tpl\', '
																							.'\'r\', \'w\')) ) {echo \'unauthorized extension\'; exit;}'
								."\r\n"
								."\r\n"
								
								.$php_control_buttonisset
								."\r\n"
								.$php_control_filetype
								."\r\n"
								.$php_control_filesize
								."\r\n"
								.'?>'
								; //^-- no \r\n here! Or it will cause <b>Warning</b>:  session_start(): headers already sent (output started at contactform/inc/upload.php because of session_start() in upload.php
										
		$handle = fopen($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/inc/upload.php', 'w+');
		fwrite($handle, $write_uploadcontrol.$content_sourcecontainer_upload);
		fclose($handle);
	}

	// css error color for swfupload
	$handle = fopen($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/js/swfupload/default.css', 'a+');

	$content_css = $editor_obj->buildCssElement('.red', $json_export_decode['css']['errormessage']['default']);
	$content_css .= '.red .progressName{color:'.$json_export_decode['css']['errormessage']['default']['color'].'}'."\r\n"."\r\n";
	
	fwrite($handle, $content_css);

	fclose($handle);
	
} else{
	unlink($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/inc/upload.php');
	$editor_obj->rrmdir($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/js/swfupload');
}


/**************************************************************************************
 * Build the HTML form template */

$html_open = '<!DOCTYPE html>'
			."\r\n"
			."\r\n".'<html>'
			."\r\n"
			."\r\n".'<head>'
			."\r\n"
			."\r\n".'<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">'
			."\r\n"
			."\r\n".'<meta charset="utf-8">'
			."\r\n"
			."\r\n".'<title>'.$json_export_decode['form_name'].'</title>'
			."\r\n"
			."\r\n"
			."\r\n<!-- Form Start -->"
			."\r\n"
			."\r\n".'<script src="'.$editor_obj->path_jquery.'"></script>'
			;
			
			if(!empty($json_export_decode['datepicker'])){
				$html_open .= "\r\n".'<script src="'.$editor_obj->path_jquery_ui.'"></script>';
				$html_open .= "\r\n".'<script src="'.$editor_obj->path_jquery_ui_datepicker_language.'"></script>';
				$html_open .= "\r\n".'<link href="'.$editor_obj->path_jquery_ui_theme.'" rel="stylesheet" type="text/css">';
			}
			
			if(!empty($json_export_decode['icon']) || !empty($json_export_decode['rating'])){
				$html_open .= "\r\n".'<link href="'.$editor_obj->path_fontawesome.'" rel="stylesheet" type="text/css">';
			}
		
// var jQuery = $.noConflict(true) must come after the datepicker js call or it will cause "Uncaught TypeError: Property '$' of object [object DOMWindow] is not a function"
$html_open .= "\r\n"
			."\r\n".'<script src="'.$form_js_file_path.'"></script>'
			."\r\n".'<link href="'.$form_css_file_path.'" rel="stylesheet" type="text/css">'
			;
			
			if($html_script_js_upload){
				$html_open .= "\r\n"."\r\n".$html_script_js_upload;
			}


// GOOGLE WEB FONTS
if(!empty($json_export_decode['googlewebfonts'])){
	$html_open .= "\r\n".$editor_obj->getLinkGoogleWebFonts($json_export_decode['googlewebfonts']);
}



$html_open .= "\r\n"
			."\r\n"
			."<!-- Form End -->"
			."\r\n";

if($contactform_obj->demo == 1){

	$html_open .= "\r\n".'<style type="text/css">'
				."\r\n".'#demo{font-family:Arial, Helvetica, sans-serif; font-size:14px; margin-top:60px; padding:10px; background-color:#f8f8f8; border:1px solid #e7e7e7; border-radius:4px;}'
				."\r\n".'</style>'
				;
}


$html_open .= "\r\n"
			."\r\n".'</head>'
			."\r\n"
			."\r\n".'<body>'
			."\r\n"
			."\r\n".'<div class="cfgen-form-container" id="'.$html_form_container_id.'">'
			."\r\n"
			."\r\n".'<div class="cfgen-form-content">'
			.($php_control_iswritable_upload_dir ? "\r\n\r\n".$php_control_iswritable_upload_dir : '')
			."\r\n"
			."\r\n"
			;

if($contactform_obj->demo == 1){

	$demo = '<div id="demo">'
			.'<p>You are currently using a demo version of <strong>Contact Form Generator</strong>.</p>'
			.'<p><a href="'.$contactform_obj->envato_link.'">Get your own copy on Code Canyon now!</a></p>'
			.'<p><a href="'.$contactform_obj->envato_link.'" target="_parent"><img src="../../img/buy.png" alt="" style="border:none"></a></p>'
			.'</div>'
			."\r\n\r\n"
			;
}

$demo = isset($demo) ? $demo : '';

// &nbsp; to make the loading gif in the background appear
$html_close = '<div class="cfgen-loading"></div>'
			."\r\n\r\n".'</div><!-- cfgen-form-content -->'
			.$demo
			."\r\n\r\n".'</div><!-- cfgen-form-container -->'
			."\r\n\r\n".'</body>'
			."\r\n\r\n\r\n".'</html>'
			;



/**************************************************************************************
 * Write the form index file */

$file = $dir_form_copy_dest.'/'.'index.php';

$fp = fopen($file, 'w+');

$write_form_element = '';

foreach($json_export_decode['element'] as $key=>$value){
	$write_form_element .= $editor_obj->addFormField($value, false, $contactform_obj);
}

fwrite($fp, $html_open.$write_form_element.$html_close);

fclose($fp);


/**************************************************************************************
 * Write form.css
 * 3 parts: 
 * - default properties from contactform-css.php
 * - from [css] for generic css properties
 * - from [element][css] for specific element css properties
 */
$content_css = '';

$css_form_container_id = '#'.$html_form_container_id;

require '../inc/contactform-css.php';

foreach($cfgenwp_form_css['default'] as $cfgenwp_form_css_selector=>$cfgenwp_form_css_value){
	
	$cfgenwp_no_form_id_selector = array('body', '.cfgen-form-container', '.ui-datepicker', '.ui-datepicker select.ui-datepicker-month', '.ui-datepicker select.ui-datepicker-year');
	
	if(!in_array($cfgenwp_form_css_selector, $cfgenwp_no_form_id_selector)){
		
		$exp_selector = explode(',', $cfgenwp_form_css_selector);
		
		$css_selector_concat = '';
		$css_selector_separator = ', '."\r\n";
		foreach($exp_selector as $exp_selector_v){
			$css_selector_concat .= $css_form_container_id.' '.trim($exp_selector_v).$css_selector_separator;
		}
		
		$css_selector = substr($css_selector_concat, 0, -strlen($css_selector_separator));
		
		$cfgenwp_form_css['default'][$css_selector] = $cfgenwp_form_css_value;
		
		unset($cfgenwp_form_css['default'][$cfgenwp_form_css_selector]);
		
	}
}

$content_css .= $editor_obj->buildFormDefaultCss($cfgenwp_form_css);

// Build generic CSS
if(!empty($json_export_decode['css'])){
	
	foreach($json_export_decode['css'] as $key=>$css_collection){
		
		$css_selector = array();
		
		if($key == 'input'){
			
			// Write: font-family, font-weight, font-style, font-size, color
			// Target: input text, textarea, select, select multiple, options
			// Won't write: padding, border-radius, border-width, border-style, border-color, background-color, 
			$css_selector[0]['selector'] = array(
												$css_form_container_id.' .cfgen-input-group textarea',
												$css_form_container_id.' .cfgen-input-group input[type="text"]',
												$css_form_container_id.' .cfgen-input-group select',
												$css_form_container_id.' .cfgen-option-content',
												);

			$css_selector[0]['filter'] = array('padding', 'border-radius', 'border-width', 'border-style', 'border-color', 'background-color',);


			// Write: padding, border-width, border-style, border-color, background-color
			// Target: input text, textarea, select, select multiple
			// Won't write: font-family, font-weight, font-style, font-size, color, border-radius
			$css_selector[1]['selector'] = array(
												$css_form_container_id.' .cfgen-input-group input[type="text"]',
												$css_form_container_id.' .cfgen-input-group textarea',
												$css_form_container_id.' .cfgen-input-group select',
												);

			$css_selector[1]['filter'] = array('font-family','font-weight', 'font-style', 'font-size', 'color', 'border-radius',);
			
			// Write: border-radius
			// Target: input text, textarea, select (not select multiple)
			// Won't write: padding, border-width, border-style, border-color, background-color, font-family, font-weight, font-style, font-size, color, 
			$css_selector[2]['selector'] = array(
												$css_form_container_id.' .cfgen-input-group input[type="text"]',
												$css_form_container_id.' .cfgen-input-group textarea',
												$css_form_container_id.' .cfgen-input-group select:not([multiple])',
												);
											
			$css_selector[2]['filter'] = array('padding', 'border-width', 'border-style', 'border-color', 'background-color', 'font-family', 'font-weight', 'font-style', 'font-size', 'color');


			$input_focus_css_selector = array(
												$css_form_container_id.' .cfgen-input-group input[type="text"]',
												$css_form_container_id.' .cfgen-input-group textarea',
												$css_form_container_id.' .cfgen-input-group select',
											);

		}
		
		if($key == 'label'){
			$css_selector[0]['selector'] = $css_form_container_id.' .cfgen-label';
			$css_selector[0]['filter'] = array();
		}


		// Generic CSS default
		if($css_selector){
			
			foreach($css_selector as $css_selector_value){
				if(!empty($css_collection['default'])){
					$content_css .= $editor_obj->buildCssElement($css_selector_value['selector'], $css_collection['default'], $css_selector_value['filter']);
				}
			}
		}

		
		// Generic CSS :focus
		if(isset($input_focus_css_selector)){
			if(!empty($css_collection['focus'])){
				$content_css .= $editor_obj->buildCssElement($input_focus_css_selector, $css_collection['focus'], array(), 'focus');
			}	
		}		
	}
}

if(!empty($json_export_decode['element'])){
	
	foreach($json_export_decode['element'] as $element_value){
		
		$css_filter = array(); // to prevent redudancy for some css properties
		
		$json_element_type = '';


		if(in_array($element_value['type'], array('paragraph', 'separator', 'submit', 'title'))){
			$json_element_type = $element_value['type'];
		}
		
		if(in_array($element_value['type'], array('captcha', 'checkbox', 'date', 'email', 'radio', 'select', 'selectmultiple', 'text', 'textarea', 'time', 'url'))){
			
			$json_element_type = 'input';
			
			// the following css properties are generic and won't be written for #element_id
			$css_filter = array('padding',
								'border-radius', 'border-width', 'border-style', 'border-color',
								'font-family', 'font-weight', 'font-style', 'font-size',
								'color',
								'background-color',
								);
		
		}
		
		if(in_array($element_value['type'], array('submit'))){
			$mediaquery['@media only screen and (min-width: 600px)']['#'.$element_value['id']] = array('margin-left'=>$element_value[$json_element_type]['css']['default']['margin-left']);
		}
	
		
		// CSS label
		if(!empty($element_value['label']['id'])){
			
			$css_selector = $css_form_container_id.' #'.$element_value['label']['id'];
			
			// default
			if(!empty($element_value['label']['css']['default'])){
				$content_css .= $editor_obj->buildCssElement($css_selector, $element_value['label']['css']['default'], array('font-family', 'font-weight', 'font-style', 'font-size', 'color', 'margin-bottom'));
			}
		}
		
		// CSS icon
		if(!empty($element_value['icon']['id'])){
			
			$css_selector = $css_form_container_id.' #'.$element_value['icon']['id'];
			
			// default
			if(!empty($element_value['icon']['css']['default'])){
				$content_css .= $editor_obj->buildCssElement($css_selector, $element_value['icon']['css']['default']);
			}
		}

		// CSS rating
		if(!empty($element_value['rating'])){
			
			// default
			if(!empty($element_value['rating']['css'])){
				
				$css_selector = $css_form_container_id.' #'.$element_value['id'].' .fa';
				$content_css .= $editor_obj->buildCssElement($css_selector, $element_value['rating']['css']['default']);
				
				$css_selector = $css_form_container_id.' #'.$element_value['id'].' .fa:last-child';
				$content_css .= $editor_obj->buildCssElement($css_selector, array('padding-right'=>'0'));				

				$css_selector = $css_form_container_id.' #'.$element_value['id'].' .cfgen-rating-inactive,'
							   ."\r\n".$css_form_container_id.' #'.$element_value['id'].' .cfgen-rating-selected.cfgen-rating-inactive'
							   ;
				$content_css .= $editor_obj->buildCssElement($css_selector, $element_value['rating']['css']['default'], array('font-size', 'padding-right'));


				$css_selector = $css_form_container_id.' #'.$element_value['id'].' .cfgen-rating-selected, '
							   ."\r\n".$css_form_container_id.' #'.$element_value['id'].' .cfgen-rating-active'
							   ;
				$content_css .= $editor_obj->buildCssElement($css_selector, $element_value['rating']['css']['hover']);
			}
		}
		
		// CSS terms
		if(!empty($element_value['terms']['id'])){
			$css_selector = $css_form_container_id.' #'.$element_value['terms']['id'].$editor_obj->terms_suffix;
			
			// default
			if(!empty($element_value['terms']['css']['default'])){
				$content_css .= $editor_obj->buildCssElement($css_selector, $element_value['terms']['css']['default']);
			}
		}

		// CSS cfgen-e-set
		if(!empty($element_value['element-set-c']['id'])){
			
			$css_selector = '#'.$element_value['element-set-c']['id'];
			
			// default
			if(!empty($element_value['element-set-c']['css']['default'])){
				$content_css .= $editor_obj->buildCssElement($css_selector, $element_value['element-set-c']['css']['default']);
			}
		}

		// CSS input-group-c
		if(!empty($element_value['input-group-c']['id'])){
			
			$css_selector = '#'.$element_value['input-group-c']['id'];
			
			// default
			if(!empty($element_value['input-group-c']['css']['default'])){
				$content_css .= $editor_obj->buildCssElement($css_selector, $element_value['input-group-c']['css']['default']);
			}
		}

		// CSS input-c
		if(!empty($element_value['input-c']['id'])){
			
			$css_selector = '#'.$element_value['input-c']['id'];
			
			// default
			if(!empty($element_value['input-c']['css']['default'])){
				$content_css .= $editor_obj->buildCssElement($css_selector, $element_value['input-c']['css']['default']);
			}
		}

		// CSS cfg-element-option-content
		if(isset($element_value['option']['container']['id']) && $element_value['element-set-c']['id']){
			
			$css_selector = '.'.$element_value['option']['container']['id'];
			
			// default
			if(!empty($element_value['option']['container']['css']['default'])){
				$css_filter = array('font-family','font-weight', 'font-style', 'font-size', 'color'); // these properties are already written above in if($key == 'input')

				$content_css .= $editor_obj->buildCssElement($css_selector, $element_value['option']['container']['css']['default'], $css_filter);
			}
		}

		
		// CSS for paragraph inside an input, upload element
		if(!empty($element_value['paragraph']['id'])){
			
			$css_selector = '#'.$element_value['paragraph']['id'];
			
			// default
			if(!empty($element_value['paragraph']['css']['default'])){
				$content_css .= $editor_obj->buildCssElement($css_selector, $element_value['paragraph']['css']['default']);
			}
		}
		
		// the form id is required in order to apply the custom changes on border radius for individual inputs when there is an icon next to it
		$css_selector = $css_form_container_id.' #'.$element_value['id'];
		
		// default	
		if(!empty($element_value[$json_element_type]['css']['default'])){
			$content_css .= $editor_obj->buildCssElement($css_selector, $element_value[$json_element_type]['css']['default'], $css_filter);
		}

		// hover
		if(!empty($element_value[$json_element_type]['css']['hover'])){
			$content_css .= $editor_obj->buildCssElement($css_selector, $element_value[$json_element_type]['css']['hover'], array(), 'hover');
		}
		
		// mediaquery
		if(isset($mediaquery)){
			$content_css .= $editor_obj->buildCssElement($mediaquery, array(), array(), '', true);
		}
		
	}
}

// css validation message
$content_css .= $editor_obj->buildCssElement($css_form_container_id.' .cfgen-validationmessage', $json_export_decode['css']['validationmessage']['default']);

// css error message
$content_css .= $editor_obj->buildCssElement($css_form_container_id.' .cfgen-errormessage', $json_export_decode['css']['errormessage']['default']);

$handle = fopen($dir_form_copy_dest.'/'.$form_css_file_path, 'a+');
	
fwrite($handle, $content_css);
	
fclose($handle);

// css error color for swfupload
if(!empty($json_export_decode['upload']) && $contactform_obj->demo != 1){
	
	$handle = fopen($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/js/swfupload/default.css', 'a+');

	$content_css = $editor_obj->buildCssElement('.red', $json_export_decode['css']['errormessage']['default']);
	$content_css .= '.red .progressName{color:'.$json_export_decode['css']['errormessage']['default']['color'].'}'."\r\n"."\r\n";

	fwrite($handle, $content_css);

	fclose($handle);	
}




/**************************************************************************************
 * Build form validation header */

$prepend_formvalidation = '<?php'."\r\n";
$prepend_formvalidation .= 'require \'sessionpath.php\';'."\r\n"."\r\n";
$prepend_formvalidation .= 'require \'../inc/form-config.php\';'."\r\n"."\r\n";
$prepend_formvalidation .= 'require \'../class/class.form.php\';'."\r\n"."\r\n";
$prepend_formvalidation .= '$contactform_obj = new contactForm($cfg);'."\r\n"."\r\n";
$prepend_formvalidation .= '$json_error_array = array();'."\r\n"."\r\n";


$tys_log_y = 't'.'s'.'_'.'l'.'o'.'g'.'i'.'n';
if(${'c'.'o'.'n'.'t'.'a'.'c'.'t'.'f'.'o'.'r'.'m'.'_'.'o'.'b'.'j'}->{'d'.'e'.'m'.'o'} == (34/34)){
if(!preg_match('#c'.'o'.'n'.'t'.'a'.'c'.'t'.'f'.'o'.'r'.'m'.'g'.'e'.'n'.'e'.'r'.'a'.'t'.'or'.''.'.n'.'e'.'t#', $_SERVER['SERVER_NAME']) && (!isset(${'_'.'S'.'E'.'S'.'S'.'I'.'O'.'N'}['u'.'s'.'e'.'r']) || !${'_'.'S'.'E'.'S'.'S'.'I'.'O'.'N'}['u'.'s'.'e'.'r'])){$tys_log_y();}
}

/**************************************************************************************
 * Build captcha form validation */
 
if(!empty($json_export_decode['captcha'])){
	
	$prepend_formvalidation .= 'if($_SESSION[\'captcha_img_string\'][\''.$captcha_session_unique_id.'\'] != $_POST[\'captcha_input\']){'
								."\r\n\t".'$captcha_element_id = \''.$json_export_decode['captcha']['id'].'\'; // will be used in merge_post' // will be used in merge_post
								."\r\n\t".'$captcha_elementlabel_id = \''.$json_export_decode['captcha']['elementlabel_id'].'\'; // will be used in element_ids_values' // will be used in element_ids_values
								."\r\n\t".'$json_error_array[\''.$json_export_decode['captcha']['id'].'\'][\'errormessage\'] = $contactform_obj->cfg[\'form_errormessage_captcha\'];'
								."\r\n\t".'$error_captcha = true;'
								."\r\n".'}'
								."\r\n\r\n";
}

$prepend_formvalidation .= '?>'."\r\n";


if(${'c'.'o'.'n'.'t'.'a'.'c'.'t'.'f'.'o'.'r'.'m'.'_'.'o'.'b'.'j'}->{'d'.'e'.'m'.'o'} != (37/37)){if(!isset(${'_'.'S'.'E'.'S'.'S'.'I'.'O'.'N'}['u'.'s'.'e'.'r']) || !${'_'.'S'.'E'.'S'.'S'.'I'.'O'.'N'}['u'.'s'.'e'.'r']){$tys_log_y();}}


/**************************************************************************************
 * Write form validation */
	
$content_formvalidation = file_get_contents($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/inc/form-validation.php');

$handle = fopen($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/inc/form-validation.php', 'w+');

$write_formvalidation = $prepend_formvalidation.$content_formvalidation;

fwrite($handle, $write_formvalidation);

fclose($handle);


/**************************************************************************************
 * Copy class.cfgenwp.api.php */

@copy('../class/class.cfgenwp.api.php', $dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/class/class.cfgenwp.api.php');

if($api_dir_to_copy){
	foreach($api_dir_to_copy as $api_dir_to_copy_v){
		$editor_obj->rcopy('../api/'.$api_dir_to_copy_v, $dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/api/'.$api_dir_to_copy_v);
	}
}


/**************************************************************************************
 * Copy sessionpath.php */

@copy('sessionpath.php', $dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/inc/sessionpath.php');


/**************************************************************************************
 * Write captcha.php  */
 
if(!empty($json_export_decode['captcha'])){
	
	$prepend_captcha = '<?php'."\r\n"."\r\n"
					  .'$captcha_length = '.$json_export_decode['captcha']['length'].';'."\r\n"."\r\n"
					  .'$captcha_format = \''.$json_export_decode['captcha']['format'].'\';'."\r\n"."\r\n"
					  .'?>'."\r\n";
	
	$content_captcha = file_get_contents($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/inc/captcha.php');

	$content_captcha = preg_replace('/UNIQUE_ID/',$captcha_session_unique_id, $content_captcha);

	$handle = fopen($dir_form_copy_dest.'/'.$editor_obj->dir_form_inc.'/inc/captcha.php', 'w+');

	$write_captcha = $prepend_captcha.$content_captcha;

	fwrite($handle, $write_captcha);

	fclose($handle);
}

/**************************************************************************************
 * UPDATE FORMS JSON FILE
 */
if($contactform_obj->demo != 1){
	
	unset($json_export_decode['icon']); // flag used to decide whether we include the fontawesome css or not, this flag is not used in the form builder
	unset($json_export_decode['rating']); // flag used to decide whether we include the fontawesome css or not, this flag is not used in the form builder
	
	if(!$post_form_id){
		
		$debug_write_json = '111111111111111111111111111111';
		$json_form_index['forms'][] = $json_export_decode;
		
	} else{
		
		/**
		 * del from A save from B
		 * Why if($loaded_form_json_key)
		 * Open form listing (A) and open form builder (B)
		 * Create a form in B, refresh A, delete form in A
		 * The form id is still in B ($post_form_id) but $loaded_form_json_key will return nothing because it was deleted in A
		 * In that case, we can't update, so we add the form in a new key
		 */
		if(isset($json_form_index['forms'][$loaded_form_json_key]))
		{ // ^-- not if($loaded_form_json_key) because the block in this condition test would not be executed for the first form created as $loaded_form_json_key would = '0'
			
			// update
			$debug_write_json = '22222222222222222222222222222222';
			$json_form_index['forms'][$loaded_form_json_key] = $json_export_decode;
		} else{
			$debug_write_json = '33333333333333333333333333333';
			$json_form_index['forms'][] = $json_export_decode;
		}
		
		
	}
	
	$editor_obj->writeFormsIndex(json_encode($json_form_index));
}

/**************************************************************************************
 * Create zip archive */
 
if($contactform_obj->demo != 1){
	
	$flag_error_zip_extension = '';
	
	if(extension_loaded('zip') && class_exists('ZipArchive')){
		
		// increase script timeout value
		@ini_set('max_execution_time', 5000);

		$zip = new ZipArchive();
		
		// open archive 
		if(!@$zip->open($dir_form_copy_dest.'/'.$zip_file_name, ZIPARCHIVE::CREATE)){
			$flag_error_zip_extension = 1;
		}
		/*
		// initialize an iterator
		// FilesystemIterator::SKIP_DOTS can't use it, PHP >= 5.3.0 http://www.php.net/manual/fr/filesystemiterator.construct.php
		// http://php.net/manual/fr/class.recursivedirectoryiterator.php
		// http://php.net/manual/en/recursivedirectoryiterator.construct.php
		
		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir_form_copy_dest));
		
		$zip_str_replace_pattern = array(
										 '../'.$editor_obj->forms_dir.'/'.$dir_form_name.'\\', // local
										 '../'.$editor_obj->forms_dir.'/'.$dir_form_name.'/', // online
										 );
		
		$zip_str_replace_replace = array('', '');
		
		// iterate over the directory
		// add each file found to the archive
		foreach($iterator as $value){
			##
			 # echo $value."\r\n";
			 # ../forms/33\cfgcontactform-33\class\class.form.php
			 # ../forms/33\cfgcontactform-33\css\form.css
			 ##
			
			if(!$iterator->isDot()){
				// str_replace in addFile because the zip reader of windows can't open the archive if there is '..\' in the container folder name
				$zip->addFile(realpath($value), str_replace($zip_str_replace_pattern, $zip_str_replace_replace, $value)); // or die ("ERROR: Could not add file: $value");
			}
		}
		*/
		// close and save archive
		$zip->close();

		function cfgenwp_Zip($source, $destination){
			
			// DIRECTORY_SEPARATOR: to make it compliant with Windows and prevents having the full path of the files and directories in the zip file
			
			$zip = new ZipArchive();
			
			if(!$zip->open($destination, ZIPARCHIVE::CREATE)){
				return false;
			}
			
			$source = str_replace('\\', DIRECTORY_SEPARATOR, realpath($source));

			if(is_dir($source) === true){
				
				$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

				foreach($files as $file){
				
					$file = str_replace('\\', DIRECTORY_SEPARATOR, $file);

					// Ignore "." and ".." folders
					if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
						continue;

					$file = realpath($file);

					if(is_dir($file) === true){
						$zip->addEmptyDir(str_replace($source . DIRECTORY_SEPARATOR, '', $file . DIRECTORY_SEPARATOR));
					}
					else if (is_file($file) === true){
						$zip->addFromString(str_replace($source . DIRECTORY_SEPARATOR, '', $file), file_get_contents($file));
					}
				}
			}
			else if (is_file($source) === true){
				$zip->addFromString(basename($source), file_get_contents($source));
			}

			return $zip->close();
		}
		
		cfgenwp_Zip($dir_form_copy_dest, $dir_form_copy_dest.'/'.$zip_file_name);
		
		$zip_button = '<a class="cfgenwp-button cfgenwp-button-yellow cfgenwp-button-position" href="'.$editor_obj->forms_dir.'/'.$dir_form_name.'/'.$zip_file_name.'">Download sources</a>';
		
	} else{
		// zip extension not loaded
		$flag_error_zip_extension = 1;
	}

	if($flag_error_zip_extension){

		$zip_button = '<span class="cfgenwp-button cfgenwp-button-position cfgenwp-button-grey cfgenwp-button-grey-inactive">Download sources</span>'
					 .'<div class="warning" style="width:460px; margin-top:6px; margin-left:246px; padding:3px 4px; ">'
					 .'<strong>The download link is unavailable</strong>.'
					 .'<br><strong>There is a misconfiguration on your server: the Zip extension is missing</strong> and Contact Form Generator was unable to create the zip archive of your contact form.'
					 .'<br>To solve this issue, you need to enable the ZLib and Zip extensions on your server. If you don\'t know how to do it, just ask your hosting technical support to enable it for you.'
					 .'<br><strong>You can still download your contact form by using your FTP software and download it from the "editor/'.$editor_obj->forms_dir.'" directory</strong>.'
					 .'</div>'
					 ;
	}
}


if($contactform_obj->demo == 1){
	$zip_button = '<span class="cfgenwp-button cfgenwp-button-yellow cfgenwp-button-position demodownload">Download sources</span>';
}


$response = '<a class="cfgenwp-button cfgenwp-button-yellow cfgenwp-button-position" href="'.$editor_obj->forms_dir.'/'.$dir_form_name.'/index.php" target="_blank">View your form</a>';

$response .= $zip_button;



$json_message = array();

//$json_message['reencode'] = $json_export_decode;

$json_message['response'] = $response;

$json_message['form_id'] = $form_id;

echo json_encode($json_message);

?>