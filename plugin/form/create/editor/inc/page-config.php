<?php
if(session_id() === ''){

	session_start();
	
	if(!isset($_SESSION['user'])){
		header('Location: ../');exit;
	}
}


function cfgenwp_formmessage($key){
	global $cfgenwp_config_validation_message, $cfgenwp_config_error_message;
	
	$html = '';
	
	if(isset($cfgenwp_config_validation_message[$key]) && $cfgenwp_config_validation_message[$key]){
		$html = '<div class="cfgenwp-validation">'.$cfgenwp_config_validation_message[$key].'</div>';
	}
	
	if(isset($cfgenwp_config_error_message[$key]) && $cfgenwp_config_error_message[$key]){
		$html = '<div class="cfgenwp-error">'.$cfgenwp_config_error_message[$key].'</div>';
	}
	
	return $html;
}

function cfgenwp_setServiceFormMessageAnchor($service_id){
	return 'service-message-'.$service_id;
}

if(isset($_POST) && $_POST){
	
	// ERROR: dir writable
	if(!$contactformeditor_obj->isWritable($contactformeditor_obj->config_dir)){
		$cfgenwp_config_error_message[$_POST['cfgenwp_error_anchor']] = $contactformeditor_obj->error_not_writable_config_dir;
	}
		
	// ERROR: config file writable
	if(file_exists($contactformeditor_obj->config_filename_path) && !$contactformeditor_obj->isWritable($contactformeditor_obj->config_filename_path)){
		$cfgenwp_config_error_message[$_POST['cfgenwp_error_anchor']] = $contactformeditor_obj->error_not_writable_config_file;
	}
}


/*****************************************
 * ACCOUNT
 *****************************************/
if(isset($_POST['cfgenwp_config_username']) && isset($_POST['cfgenwp_config_password1']) && isset($_POST['cfgenwp_config_password2'])){
	
	$length_login_min = 2;
	$length_login_max = 30;
	
	$cfgenwp_config['account']['login'] = trim($contactformeditor_obj->quote_smart($_POST['cfgenwp_config_username']));
	
	
	if(!preg_match('#^[a-z0-9]{'.$length_login_min.','.$length_login_max.'}$#i', $cfgenwp_config['account']['login'])){
		$error[] = 'Please enter a valid username with letters and numbers only ('.$length_login_min.' characters min, '.$length_login_max.' characters max)';
	}
	
	
	$pwd1 = $cfgenwp_config['account']['password'] = $contactformeditor_obj->quote_smart($_POST['cfgenwp_config_password1']);
	$pwd2 = $contactformeditor_obj->quote_smart($_POST['cfgenwp_config_password2']);
	
	if(!$pwd1 && !$pwd2){
		$cfgenwp_config_error_message['account'] = '<p>Please enter a password.</p>';
	} else{
		
		$length_pwd_min = 4;
		$length_pwd_max = 30;
		
		if($pwd1){
			if(strlen($pwd1) < $length_pwd_min){
				$cfgenwp_config_error_message['account'] = '<p>Your password must be at least '.$length_pwd_min.' characters long.</p>';
			}
		}
			
		if($pwd1 != $pwd2){
			$cfgenwp_config_error_message['account'] = '<p>Please enter the same password in the two password fields.</p>';
		}
	}
	
	
	if(!isset($cfgenwp_config_error_message)){
		$cfgenwp_config['account']['password'] = sha1($cfgenwp_config['account']['password']);
		
		// update session and cookie
		$_SESSION['user'] = $cfgenwp_config['account']['login'];
		
		$contactformeditor_obj->setUserCookie($cfgenwp_config);
		
		$cfgenwp_config_validation_message['account'] = '<p>Your account has been successfully updated.</p>';
	}
	
}

/*****************************************
 * SMTP
 *****************************************/
if(isset($_POST['cfgenwp_config_smtp_host']) 
	&& isset($_POST['cfgenwp_config_smtp_port']) 
	&& isset($_POST['cfgenwp_config_smtp_encryption']) 
	&& isset($_POST['cfgenwp_config_smtp_username']) 
	&& isset($_POST['cfgenwp_config_smtp_password'])
	){

	$cfgenwp_config['smtp']['host'] = $contactformeditor_obj->quote_smart(trim($_POST['cfgenwp_config_smtp_host']));
	$cfgenwp_config['smtp']['port'] = $contactformeditor_obj->quote_smart(trim($_POST['cfgenwp_config_smtp_port']));
	$cfgenwp_config['smtp']['encryption'] = $contactformeditor_obj->quote_smart(trim($_POST['cfgenwp_config_smtp_encryption']));
	$cfgenwp_config['smtp']['username'] = $contactformeditor_obj->quote_smart(trim($_POST['cfgenwp_config_smtp_username']));
	$cfgenwp_config['smtp']['password'] = $contactformeditor_obj->quote_smart($_POST['cfgenwp_config_smtp_password']);
	
	if(!isset($cfgenwp_config_error_message)){
		$cfgenwp_config_validation_message['smtp'] = '<p>SMTP configuration saved.</p>';
	}
}


/*****************************************
 * GOOGLE WEB FONTS API KEY
 *****************************************/
if(isset($_POST['cfgenwp_config_googlewebfontsapikey'])){
	
	$cfgenwp_config['googlewebfontsapikey'] = $contactformeditor_obj->quote_smart(trim($_POST['cfgenwp_config_googlewebfontsapikey']));
	
	
	// ERROR: api key empty
	if(!$cfgenwp_config['googlewebfontsapikey']){
		//$cfgenwp_config_error_message['googlewebfontsapikey'] = '<p>The API key cannot be left blank. API key not saved.</p>';
	}
	
	if(!isset($cfgenwp_config_error_message)){
		unset($_SESSION['cfgenwp_googlewebfonts_list']);
		$cfgenwp_config_validation_message['googlewebfontsapikey'] = '<p>Google Web Fonts API key saved.</p>';
	}
}


/*****************************************
 * SERVICE API
 *****************************************/
if(isset($_POST['cfgenwp_config_list'])){
	
	$cfgenwp_config_list = trim($_POST['cfgenwp_config_list']);

	$cfgenwp_input_name_prefix = 'cfgenwp_';
	
	function cfgenwp_removeInputNamePrefix($string){
		global $cfgenwp_input_name_prefix;
		return str_replace($cfgenwp_input_name_prefix, '', $string);
	}
	
	
	// SERVICE CREDENTIALS
	$cfgenwp_service = $cfgenwpapi_editor_obj->service[$cfgenwp_config_list];
	
	// Remove all previously saved credentials for the service
	unset($cfgenwp_config[$cfgenwp_config_list]);
	
	foreach($cfgenwp_service['credentials'] as $cfgenwp_service_credential_id=>$cfgenwp_service_credential_v){
	
		$cfgenwp_service_formmessage_anchor = cfgenwp_setServiceFormMessageAnchor($cfgenwp_service['id']);
		
		$cfgenwp_service_credential_id = $cfgenwp_input_name_prefix.$cfgenwp_service_credential_id;
		
		$cfgenwp_configfile_credential_key = cfgenwp_removeInputNamePrefix($cfgenwp_service_credential_id);
		
		if(isset($_POST[$cfgenwp_service_credential_id])){
				
			// AWEBER
			if($cfgenwp_config_list == 'aweber' && $cfgenwp_configfile_credential_key == 'authorizationcode' && $_POST[$cfgenwp_service_credential_id]){
			
				include('editor/api/aweber/aweber_api.php');
				
				try{
				
					$post_aweber['auth'] = AWeberAPI::getDataFromAweberID($_POST[$cfgenwp_service_credential_id]);
					
					// var_dump($post_aweber['auth']);
					// $post_aweber['auth'] is null if the authorization code is invalid
					
					if($post_aweber['auth']){
					
						$cfgenwp_config[$cfgenwp_config_list]['consumerkey'] = $post_aweber['auth'][0];
						$cfgenwp_config[$cfgenwp_config_list]['consumersecret'] = $post_aweber['auth'][1];
						$cfgenwp_config[$cfgenwp_config_list]['accesstokenkey'] = $post_aweber['auth'][2];
						$cfgenwp_config[$cfgenwp_config_list]['accesstokensecret'] = $post_aweber['auth'][3];
						
					} else{
						$cfgenwp_config_error_message[$cfgenwp_service_formmessage_anchor] = '<p>'.$cfgenwp_service['error']['authorizationcode'].'</p>';
					}
					
				} catch(AWeberAPIException $e){
					$cfgenwp_config_error_message[$cfgenwp_service_formmessage_anchor] = '<p>'.$cfgenwp_service['error']['authorizationcode'].'</p>';
				}
			}
			
			
			// Preparing the values for the config file
			// in_array check: that way we filter connection credentials that should not be saved (example: authorizationcode for aweber)
			if(isset($cfgenwp_service['formconfig']['credentials'][$cfgenwp_configfile_credential_key])){
			
				$cfgenwp_config[$cfgenwp_config_list][$cfgenwp_configfile_credential_key] = $contactformeditor_obj->quote_smart($_POST[$cfgenwp_service_credential_id]);
				
				if($cfgenwp_configfile_credential_key != 'password'){
					$cfgenwp_config[$cfgenwp_config_list][$cfgenwp_configfile_credential_key] = trim($cfgenwp_config[$cfgenwp_config_list][$cfgenwp_configfile_credential_key]);
				}
			}
		}
		
		if(!isset($cfgenwp_config_error_message)){
			$cfgenwp_config_validation_message[$cfgenwp_service_formmessage_anchor] = '<p>Service configuration saved.</p>';
		}
	}
}

if(isset($cfgenwp_config_validation_message)){
	
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
	
	$cfgenwp_content_write .= '?>';
			
	@fwrite($cfgenwp_fopen, $cfgenwp_content_write);
				
	@fclose($cfgenwp_fopen);
}
	
?>
	

<h2>Settings and server configuration</h2>

<?php
if(!$contactformeditor_obj->isWritable($contactformeditor_obj->config_dir)){?>

	<div class="cfgenwp-error">
		<?php echo $contactformeditor_obj->error_not_writable_config_dir;?>
	</div>
	<?php
}
?>


<div class="cfgenwp-settings-container cfgenwp-index-panel" id="cfgenwp-config-accountsettings">
	
	<div class="cfgenwp-index-panel-c">
	
		<h3>Account settings</h3>
		
		<?php
		$cfgenwp_error_anchor = 'account';
		echo cfgenwp_formmessage($cfgenwp_error_anchor);
		?>
		
		<form action="config.php#cfgenwp-config-accountsettings" method="post">
		
			<input type="hidden" name="cfgenwp_error_anchor" value="<?php echo $cfgenwp_error_anchor;?>">
		
			<!-- chrome honey pot to prevent prefilling -->
			<input style="display:none;" type="password">
		
			<div class="cfgenwp-form-settings-l">
				<label for="cfgenwp_config_username">Username</label>
			</div>
			
			<div class="cfgenwp-form-settings-r">
				<input type="text" id="cfgenwp_config_username" name="cfgenwp_config_username" value="<?php echo $contactformeditor_obj->htmlEntities($_SESSION['user']);?>" placeholder="Enter your username">
			</div>
			
			<div class="cfgenwp-clear"></div>
			
		
			<div class="cfgenwp-form-settings-l">
				<label for="cfgenwp_config_password1">New password</label>
			</div>
			
			<div class="cfgenwp-form-settings-r">
				<input type="password" id="cfgenwp_config_password1" name="cfgenwp_config_password1" value="" placeholder="Enter your password">
			</div>
			
			<div class="cfgenwp-clear"></div>
			
		
			<div class="cfgenwp-form-settings-l">
				<label for="cfgenwp_config_password2">Confirm new password</label>
			</div>
			
			<div class="cfgenwp-form-settings-r">
				<input type="password" id="cfgenwp_config_password2" name="cfgenwp_config_password2" value="" placeholder="Enter your password">
			</div>
			
			<div class="cfgenwp-clear"></div>
			
			
			<div class="cfgenwp-form-settings-l">
			&nbsp;
			</div>
			
			<div class="cfgenwp-form-settings-r">
				<input type="submit" class="cfgenwp-button-small cfgenwp-button-blue" value="Save account configuration">
			</div>
			
			<div class="cfgenwp-clear"></div>

		</form>
	
	</div><!-- cfgenwp-index-panel-c -->
	
</div>

<div class="cfgenwp-settings-container cfgenwp-index-panel" id="cfgenwp-config-googlewebfontsapikey">
	
	<div class="cfgenwp-index-panel-c">

		<h3>Google web fonts settings</h3>
		
		<?php
		$cfgenwp_error_anchor = 'googlewebfontsapikey';
		echo cfgenwp_formmessage($cfgenwp_error_anchor);
		?>
		
		<p>You need a Google Web Fonts API Key to display the complete Google fonts list in Form Generator.</p>
		
		<p>If you haven't your own Google API key, <a href="<?php echo $contactformeditor_obj->support_url;?>" target="_blank">click here</a> to see how you can get one in almost no time.</p>
		
		<form action="config.php#cfgenwp-config-googlewebfontsapikey" method="post">
		
			<input type="hidden" name="cfgenwp_error_anchor" value="<?php echo $cfgenwp_error_anchor;?>">
		
			<div class="cfgenwp-form-settings-l">
				<label for="cfgenwp_config_googlewebfontsapikey">Google Fonts API Key</label>
			</div>
			
			<div class="cfgenwp-form-settings-r">
				<input type="text" id="cfgenwp_config_googlewebfontsapikey" name="cfgenwp_config_googlewebfontsapikey" value="<?php echo $contactformeditor_obj->htmlEntities($cfgenwp_config['googlewebfontsapikey']);?>" placeholder="Enter your Google API key">
				&nbsp;&nbsp;
				<?php
				if($cfgenwp_config['googlewebfontsapikey']){?>
					<a href="https://www.googleapis.com/webfonts/v1/webfonts?key=<?php echo $contactformeditor_obj->htmlEntities($cfgenwp_config['googlewebfontsapikey']);?>" target="_blank">Check if my Google API key is working</a>
					<?php
				} else{?>
					<a href="http://www.topstudiodev.com/support/googleapikey" target="_blank">Get your Google API key</a>
					<?php
				}
				?>			
			</div>
			
			<div class="cfgenwp-clear"></div>
		
			<div class="cfgenwp-form-settings-l">
			&nbsp;
			</div>
			
			<div class="cfgenwp-form-settings-r">
				<input type="submit" class="cfgenwp-button-small cfgenwp-button-blue" value="Save Google fonts API key">
			</div>
			
			<div class="cfgenwp-clear"></div>
		
		</form>

	</div><!-- cfgenwp-index-panel-c -->
	
</div>


<div class="cfgenwp-settings-container cfgenwp-index-panel" id="cfgenwp-config-smtp">
	
	<div class="cfgenwp-index-panel-c">
	
		<h3>SMTP settings</h3>
		
		<?php
		$cfgenwp_error_anchor = 'smtp';
		echo cfgenwp_formmessage($cfgenwp_error_anchor);
		?>
		
		<p>Fill the form below if you want to save some time and make the SMTP credentials appear automatically in the "Email Sending Method" section of the form builder.</p>
		
		<form action="config.php#cfgenwp-config-smtp" method="post">
		
			<!-- chrome honey pot to prevent prefilling -->
			<input style="display:none;" type="password">
			
			<input type="hidden" name="cfgenwp_error_anchor" value="<?php echo $cfgenwp_error_anchor;?>">
			
			<div class="cfgenwp-form-settings-l">
				<label for="cfgenwp_config_smtp_host">SMTP Host</label>		
			</div>
			
			<div class="cfgenwp-form-settings-r">
				<input type="text" id="cfgenwp_config_smtp_host" name="cfgenwp_config_smtp_host" value="<?php echo $contactformeditor_obj->htmlEntities($cfgenwp_config['smtp']['host']);?>" placeholder="Enter SMTP host">		
			</div>
			
			<div class="cfgenwp-clear"></div>
			
			<div class="cfgenwp-form-settings-l">
				<label for="cfgenwp_config_smtp_port">SMTP Port</label>
			</div>
			
			<div class="cfgenwp-form-settings-r">
				<input type="text" id="cfgenwp_config_smtp_port" name="cfgenwp_config_smtp_port" value="<?php echo $contactformeditor_obj->htmlEntities($cfgenwp_config['smtp']['port']);?>" placeholder="Enter SMTP port">		
			</div>
			
			<div class="cfgenwp-clear"></div>
			
			<div class="cfgenwp-form-settings-l">
				<label for="cfgenwp_config_smtp_encryption">SMTP Encryption</label>
			</div>
			
			<div class="cfgenwp-form-settings-r">
				<select id="cfgenwp_config_smtp_encryption" name="cfgenwp_config_smtp_encryption">
					<?php
					$cfgenwp_smtpencryptionmethods = array(''=>'No encryption', 'ssl'=>'Use SSL encryption', 'tls'=>'Use TLS encryption');
						
					foreach($cfgenwp_smtpencryptionmethods as $cfgenwp_smtpencryptionmethods_key=>$cfgenwp_smtpencryptionmethods_value){
						
						$cfgenwp_selected_smtpencryptionmethod = '';
						
						if($cfgenwp_smtpencryptionmethods_key == $cfgenwp_config['smtp']['encryption']){
						   $cfgenwp_selected_smtpencryptionmethod = ' selected="selected" ';
						}
						
						echo '<option '.$cfgenwp_selected_smtpencryptionmethod.' value="'.$cfgenwp_smtpencryptionmethods_key.'">'.$cfgenwp_smtpencryptionmethods_value.'</option>';
					}
					?>
				</select>
			</div>
			
			<div class="cfgenwp-clear"></div>
			
			<div class="cfgenwp-form-settings-l">
				<label for="cfgenwp_config_smtp_username">SMTP Username </label>
			</div>
			
			<div class="cfgenwp-form-settings-r">
				<input type="text" autocomplete="off" id="cfgenwp_config_smtp_username" name="cfgenwp_config_smtp_username" value="<?php echo $contactformeditor_obj->htmlEntities($cfgenwp_config['smtp']['username']);?>" >
			</div>
			
			<div class="cfgenwp-clear"></div>

			<div class="cfgenwp-form-settings-l">
				<label for="cfgenwp_config_smtp_password">SMTP Password</label>
			</div>
			
			<div class="cfgenwp-form-settings-r">
				<input type="password" autocomplete="off" id="cfgenwp_config_smtp_password" name="cfgenwp_config_smtp_password" value="<?php echo $contactformeditor_obj->htmlEntities($cfgenwp_config['smtp']['password']);?>" >
			</div>
			
			<div class="cfgenwp-clear"></div>

			<div class="cfgenwp-form-settings-l">
			&nbsp;
			</div>
			
			<div class="cfgenwp-form-settings-r">
				<input type="submit" class="cfgenwp-button-small cfgenwp-button-blue" value="Save SMTP configuration">
			</div>
			
			<div class="cfgenwp-clear"></div>


			
		</form>
	
	</div>
	
</div>



<div class="cfgenwp-settings-container cfgenwp-index-panel">
	
	<div class="cfgenwp-index-panel-c">
	
		<h3>Email marketing service settings</h3>
	
		<?php
		foreach($cfgenwpapi_editor_obj->service_types['emaillist'] as $cfgenwp_api_service_id_v){
		
			$cfgenwp_api_service = $cfgenwpapi_editor_obj->service[$cfgenwp_api_service_id_v];
		
			unset($cfgenwp_hide_saveconfigurationbtn);
			
			
			$cfgenwp_anchor_message = 'cfgenwp-anchor-message-'.$cfgenwp_api_service['id'];
			
			?>
		
				
			<div class="cfgenwp-editor-api-c cfgenwp-div-listitem">

			<form action="config.php#<?php echo $cfgenwp_anchor_message;?>" method="post" id="<?php echo $cfgenwp_anchor_message;?>">
			
				<input type="hidden" name="cfgenwp_error_anchor" value="<?php echo $cfgenwp_error_anchor;?>">
			
				<input type="hidden" name="cfgenwp_config_list" value="<?php echo $cfgenwp_api_service['id'];?>">
			
				<!-- chrome honey pot to prevent prefilling -->
				<input style="display:none;" type="password">
				
				<div class="cfgenwp-config-api-name cfgenwp-api-ico-<?php echo $cfgenwp_api_service['id'];?> ">
					<?php echo $cfgenwp_api_service['name'];?>
				</div>
				
				
				<?php
				$cfgenwp_error_anchor = 'service-message-'.$cfgenwp_api_service['id'];
				
				$cfgenwp_service_form_message = cfgenwp_formmessage($cfgenwp_error_anchor);
				echo $cfgenwp_service_form_message;
				?>
				
				
				<div class="cfgenwp-editor-api-builder" style="<?php echo ($cfgenwp_service_form_message ? 'display:block' : '');?>">
				
					<div class="cfgenwp-editor-api-authentication">
							
						<?php
						foreach($cfgenwp_api_service['credentials'] as $cfgenwp_api_access_requirement_k=>$cfgenwp_api_access_requirement_v){
						
							$cfgenwp_service_input['attr']['class'] = 'cfgenwp-api-'.$cfgenwp_api_access_requirement_k;
							$cfgenwp_service_input['attr']['id'] = 'cfgenwp_'.$cfgenwp_api_service['id'].'_'.$cfgenwp_api_access_requirement_k;
							$cfgenwp_service_input['attr']['name'] = 'cfgenwp_'.$cfgenwp_api_access_requirement_k;
							$cfgenwp_service_input['attr']['value'] = '';
									
							if(isset($cfgenwp_config[$cfgenwp_api_service['id']][$cfgenwp_api_access_requirement_k])){
							// ^-- isset check : we loop on connect credentials but all connect credentials are not necessarily in the form config (example: authorizationcode for aweber)
								$cfgenwp_service_input['attr']['value'] = $contactformeditor_obj->htmlEntities($cfgenwp_config[$cfgenwp_api_service['id']][$cfgenwp_api_access_requirement_k]);
							}
							?>
							
							<div class="cfgenwp-form-settings-l">
									
								<?php
								echo $cfgenwpapi_editor_obj->getServiceCredentialLabel($cfgenwp_api_service['id'], $cfgenwp_api_access_requirement_k);
								
								echo $cfgenwpapi_editor_obj->getServiceCredentialHelp($cfgenwp_api_service['id'], $cfgenwp_api_access_requirement_k, 'editor');
								?>
								
							</div>

							<div class="cfgenwp-form-settings-r">
							
								<?php
								
								if($cfgenwp_api_access_requirement_k == 'authorizationcode')
								{

									if(isset($cfgenwp_config[$cfgenwp_api_service_id_v]['consumerkey']) && $cfgenwp_config[$cfgenwp_api_service_id_v]['consumerkey']){
										$cfgenwp_hide_saveconfigurationbtn = true;
									}
									
									?>

									<div class="cfgenwp-api-validcredential-c" style="<?php echo(isset($cfgenwp_hide_saveconfigurationbtn) ? '' : 'display:none');?>">
												
										<?php
										echo $cfgenwpapi_editor_obj->aweber['validauthorizationcode'];
										?>

										<span class="cfgenwp-api-changecredentials cfgenwp-a">Change the authorization code</span>

									</div>


									<div class="cfgenwp-api-credential-c" style="<?php echo (isset($cfgenwp_hide_saveconfigurationbtn) ? 'display:none' : '');?>">
										<?php
										echo $cfgenwpapi_editor_obj->getServiceCredentialInput($cfgenwp_api_service['id'], $cfgenwp_api_access_requirement_k, $cfgenwp_service_input);
										?>
									</div>


								<?php
								} else{
									echo $cfgenwpapi_editor_obj->getServiceCredentialInput($cfgenwp_api_service['id'], $cfgenwp_api_access_requirement_k, $cfgenwp_service_input);
								}
								?>
							</div>
									
							<div class="cfgenwp-clear"></div>
									
						<?php
							
						}
						?>
						
						
						<div class="cfgenwp-api-config-submit-c" style="<?php echo (isset($cfgenwp_hide_saveconfigurationbtn) ? 'display:none':'');?>">
						
							<div class="cfgenwp-form-settings-l">
							&nbsp;
							</div>
							
							<div class="cfgenwp-form-settings-r">
								
								<input type="submit" class="cfgenwp-button-small cfgenwp-button-blue" data-cfgenwp_api_id="<?php echo $cfgenwp_api_service['id'];?>" value="Save <?php echo $cfgenwp_api_service['name'];?> configuration">
								
							</div>
							
							<div class="cfgenwp-clear"></div>
						</div><!-- cfgenwp-api-config-submit-c -->
					
					</div><!-- cfgenwp-editor-api-authentication -->
					
				</div><!-- cfgenwp-editor-api-builder -->
			</form>
				
			</div><!-- cfgenwp-config-api-c -->
		<?php
		}
		?>
		
	</div>
	
</div>




<div class="cfgenwp-settings-container cfgenwp-index-panel">

	<div class="cfgenwp-index-panel-c">
	
		<h3>Server configuration</h3>
		
		<?php
		$cfgenwp_config_allowurlfopen = ini_get('allow_url_fopen') ? true : false;
		
		$cfgenwp_config_simplexml = extension_loaded('SimpleXML') ? true : false;
		
		$cfgenwp_config_curl = extension_loaded('curl') ? true : false;
		
		$cfgenwp_config_openssl = extension_loaded('openssl') ? true : false;
		
		$cfgenwp_config_gd = extension_loaded('gd') ? true : false;
		
		function cfgenwp_showOptionStatus($status){
			$filename = $status ? 'tick-24.png' : 'cross-24.png';
			
			echo '<img src="editor/img/'.$filename.'" class="cfgenwp-option-status-img" alt="" >';
		}
		?>
		
		
		<p>You can change these settings yourself in the server's php.ini file or you can ask your hosting tech support to do it for you.</p>
		
						
		<ul class="cfgenwp-requirements-ul">
			<li>PHP version <?php echo phpversion();?></li>
			<li>GD library <?php echo $cfgenwp_config_gd ? 'is loaded' : 'is not loaded';?></li>
			<li>OpenSSL <?php echo $cfgenwp_config_openssl ? 'is loaded' : 'is not loaded';?></li>
			<li>cURL <?php echo $cfgenwp_config_curl ? 'is loaded' : 'is not loaded';?></li>
			<li>allow_url_fopen <?php echo $cfgenwp_config_allowurlfopen ? 'is set to ON' : 'is set to OFF';?></li>
		</ul>
		
		
		
		<p class="cfgenwp-server-settings-title"><?php
		if($cfgenwp_config_openssl && $cfgenwp_config['googlewebfontsapikey'] && ($cfgenwp_config_allowurlfopen || $cfgenwp_config_curl)){
			cfgenwp_showOptionStatus(true);
		} else{
			cfgenwp_showOptionStatus(false);
		}
		?>Google Web Fonts Requirements</p>
		
		<ul class="cfgenwp-requirements-ul">
			<li>A Google Fonts API Key must be created</li>
			<li>OpenSSL must be loaded</li>
			<li>allow_url_fopen must be set to ON <strong>or</strong> cURL must be loaded</li>
		</ul>
	
	</div><!-- cfgenwp-index-panel-c -->
	
</div>


<script>
jQuery(function(){

	jQuery('.cfgenwp-api-config-empty .cfgenwp-editor-api-name').click(function(){
	
		var container = jQuery(this).closest('.cfgenwp-editor-api-c');
		var target = container.find('.cfgenwp-editor-api-builder');
		
		target.is(':visible') ? target.hide() : target.slideDown(70);
		
	});
	
	jQuery('.cfgenwp-api-changecredentials').click(function(){
		var button = jQuery(this);
		button.hide();
		
		var config_c = button.closest('.cfgenwp-editor-api-authentication');
		config_c.find('.cfgenwp-api-validcredential').hide();
		config_c.find('.cfgenwp-api-credential-c').show();
		config_c.find('.cfgenwp-api-config-submit-c').show();
		
	});
});
</script>