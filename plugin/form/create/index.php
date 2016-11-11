<?php
/**********************************************************************************
 * Contact Form Generator is (c) Top Studio
 * It is strictly forbidden to use or copy all or part of an element other than for your 
 * own personal and private use without prior written consent from Top Studio http://topstudiodev.com
 * Copies or reproductions are strictly reserved for the private use of the person 
 * making the copy and not intended for a collective use.
 *********************************************************************************/

// $cfgenwp_config['account']['login'] = 'rockylin';
// $cfgenwp_config['account']['password'] = 'a53df08425cc2ec446f589e3eb20af5d17b4683e';

include('editor/inc/sessionpath.php');

include('editor/class/class.ts.tools.php');
$topstudio_tools_obj = new TopStudio_Tools();

include('editor/class/class.contactformeditor.php');
$contactformeditor_obj = new contactFormEditor();

$cfgenwp_config = $contactformeditor_obj->includeConfig();

$contactformeditor_obj->authentication(false);


include('editor/class/class.cfgenwp.api.editor.php');
$cfgenwpapi_editor_obj = new cfgenwpApiEditor();

$html_section = (isset($html_section) && $html_section) ? $html_section : 'forms';


// print "<pre>"; 
	
	// print_r($_SESSION);
	// unset($_SESSION);
	$_SESSION['user'] = 'rockylin'; 
// print "</pre>"; 
?>
<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">

<title>Contact Form Generator</title>

<link href="//fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="<?php echo $contactformeditor_obj->path_jquery_ui_theme;?>"> 

<link rel="stylesheet" type="text/css" href="editor/css/global.css">

<link rel="stylesheet" type="text/css" href="editor/css/index.css">

<link rel="stylesheet" type="text/css" href="editor/css/api.css">

<script src="<?php echo $contactformeditor_obj->path_jquery; ?>"></script>

<script src="<?php echo $contactformeditor_obj->path_jquery_ui;?>"></script>

<script src="editor/js/contactformeditor.js"></script>

<meta name="robots" content="noindex, nofollow">

</head>

<body>

<div id="cfgenwp-index-content">

	<div class="cfgenwp-header">
		
		<div id="cfgenwp-index-logo">
			<img src="editor/img/logo-home.png" />
		</div>

		<div>
			<strong>Version <?php echo $contactformeditor_obj->version;?></strong> Copyright © <?php echo @date('Y');?> <a href="http://www.topstudiodev.com" target="_blank" class="cfgenwp-a-text"><span id="copyright-header">Top Studio</span></a>
		</div>

	</div>

	<?php
	if(isset($_POST['cfgenwp_buyer']) && isset($_POST['cfgenwp_purchase_code'])){
		$cfgenwp_validate_purchase_code = $topstudio_tools_obj->validatePurchaseCode($_POST['cfgenwp_buyer'], $_POST['cfgenwp_purchase_code']);
		
		if(isset($cfgenwp_validate_purchase_code['buyer']) && isset($cfgenwp_validate_purchase_code['purchasecode'])){
			$topstudio_tools_obj->writeLicenseFile($cfgenwp_validate_purchase_code['buyer'], $cfgenwp_validate_purchase_code['purchasecode']);
		} 
	}
	?>	

	<?php
	if($topstudio_tools_obj->licenseFileExists()){
		
		// SUCCESSFULL ITEM ACTIVATION
		if(isset($_POST['cfgenwp_buyer']) && isset($_POST['cfgenwp_purchase_code'])){?>		
			<div class="cfgenwp-validation">
				<p>Thank you. Your item has been successfully activated.</p>
			</div>		
			<?php
		}
		

		// PHP VERSION CHECK
		if(!$contactformeditor_obj->isphp5()){
			echo $contactformeditor_obj->warning_php5;
		}
		
		
		// ERROR ACCOUNT CREATION
		if(!empty($_SESSION['error'])){
			
			echo '<div class="cfgenwp-error">';

			foreach($_SESSION['error'] as $error_value){?>
				<p><strong>Error</strong>: <?php echo $error_value;?></p>
			<?php				
			}
			echo '</div>';
			
			unset($_SESSION['error']);
		}
		

		// VALIDATION ACCOUNT CREATION
		if(!empty($_SESSION['validation'])){?>
		
			<div class="cfgenwp-validation">
				<p><?php echo $_SESSION['validation'];?></p>
			</div>
			
			<?php
			unset($_SESSION['validation']);
		}


		// ERROR: SESSION
		if(session_id() === ''){?>

			<div class="cfgenwp-error">
				<p>The session.save_path parameter in your php configuration file (php.ini) is not set or is set to a folder which does not exist.</p>
				<p>The current session folder is "<strong><?php echo session_save_path();?></strong>"</p>
				<p>To change the session path, open contactformgenerator/editor/inc/<strong>sessionpath.php</strong>
				<br>and set the right session folder name for the variable <strong>$cfgenwp_sessionpath</strong> at the top of the document.</p>
				<p><a href="<?php echo $contactformeditor_obj->url_envato_formgenerator_support;?>" target="_blank">Send us a message</a> if you need help with this.</p>
				<p>We'll be happy to help.</p>
			</div>
			
		<?php
		}

		
		if(!file_exists($contactformeditor_obj->config_filename_path)){
			
			if(!$contactformeditor_obj->isWritable($contactformeditor_obj->config_dir)){?>

				<div class="cfgenwp-error">
					<?php echo $contactformeditor_obj->error_not_writable_config_dir?>
				</div>

				<?php
			} else{?>

				<p style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; text-align:center; ">Create your account:</p>

				<div class="cfgenwp-index-panel cfgenwp-form-user">
					
					<div class="cfgenwp-index-panel-c">
					
					<form action="editor/inc/form-createaccount.php" method="post" class="cfgenwp-install-form">
					
						<label for="user-login">Username</label>
						<input type="text" id="user-login" name="user-login">
						
						<label for="user-password-1">Password</label>
						<input type="password" id="user-password-1" name="user-password-1">
						
						<label for="user-password-2">Re-type Password</label>
						<input type="password" id="user-password-2" name="user-password-2">
						
						<input type="submit" value="Create Account" class="cfgenwp-button cfgenwp-button-blue cfgenwp-button-floatright">
						
					</form>
					
					<div class="cfgenwp-clear"></div>
					
					</div>
					
				</div>
				
			<?php
			}
		}
		
		if(!isset($_SESSION['user']) && file_exists($contactformeditor_obj->config_filename_path)){?>
		
			<div class="cfgenwp-index-panel cfgenwp-form-user">
			
				<div class="cfgenwp-index-panel-c">
			
					<form action="editor/inc/form-login.php" method="post" class="cfgenwp-install-form">

						<input type="hidden" name="cr" id="cr" />

						<label for="user-login">Username</label>
						<input type="text" id="user-login" name="user-login">

						<label for="user-password">Password</label>
						<input type="password" id="user-password" name="user-password">

						<input type="checkbox" id="rememberme" name="rememberme" value="1"><label for="rememberme" id="label-rememberme">Remember me</label>
						
						<input type="submit" value="Log In" class="cfgenwp-button cfgenwp-button-blue cfgenwp-button-floatright">
						
						<div class="cfgenwp-clear"></div>

					</form>
				
				</div>
				
			</div>
			
			<div id="cfg-resetpassword-container"><span id="cfg-resetpassword" class="cfgenwp-a">Reset your password</span></div>
			
		<?php
		}
		?>

		<?php
		if(!empty($_SESSION['user'])){?>
			
			
			<div class="cfgenwp-index-menu">
				<a href="index.php">Forms</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="config.php">Config</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="editor/inc/logout.php">Logout</a>
			</div>
			
			<?php
			// ERROR: writable forms dir
			if(!$contactformeditor_obj->isWritable($contactformeditor_obj->forms_dir_path)){?>
				<div class="cfgenwp-error">
					<?php echo $contactformeditor_obj->error_not_writable_dir_form_download;?>
				</div>
				<?php
			}
			
			// ERROR: writable json index file
			// Writes the json index file if it's missing
			if(!is_file($contactformeditor_obj->formsindex_filename_path)){
				$contactformeditor_obj->resetFormsIndex();
			}
			
			if(!$contactformeditor_obj->isWritable($contactformeditor_obj->formsindex_filename_path)){?>
				<div class="cfgenwp-error">
					<?php echo $contactformeditor_obj->error_not_writable_form_index_file;?>
				</div>
				<?php
			}
			
			// ERROR: writable upload dir
			if(!$contactformeditor_obj->isWritable('editor/upload')){?>
				<div class="cfgenwp-error">
					<?php echo $contactformeditor_obj->error_not_writable_dir_upload;?>
				</div>
			<?php } ?>
			
			<?php
			include('editor/inc/page-'.$html_section.'.php');
			?>

			<?php
		} // end if(!isset($_SESSION['error'])
		?>

		</div><!-- content -->

		<div id="cfgenwp-dialog-message"></div>


		<script>
		jQuery(function(){
			
			jQuery('#cfg-resetpassword').click(function(){

				jQuery.cfgenwp_dialog_box.html('<p>Delete the file "<?php echo $contactformeditor_obj->config_filename;?>" in the directory "<?php echo $contactformeditor_obj->config_dir;?>" to reset your password and create a new account.</p>')
				.dialog({
						autoOpen: true,
						title: 'Reset your password',
						buttons:{
							Ok: function(){jQuery(this).dialog('close');}
						}
				});		
			});

			jQuery('#cr').val($('#copyright-header').html());

		});
		</script>

	<?php
	} // licenseFileExists
	else{?>
	
		<?php
		// ERROR: !allow_url_fopen !curl
		if(!ini_get('allow_url_fopen') && !extension_loaded('curl')){?>
			<div class="cfgenwp-error">
				<p><strong>cUrl extension</strong> is not loaded and <strong>allow_url_fopen</strong> is set to OFF.</p>
				<p>You need to have the cUrl extension enabled or allow_url_fopen set to ON in order to make the plugin work properly.</p>
				<p>You can change these settings yourself in the server's php.ini file or you can ask your tech support to do it for you.</p>
			</div>
		<?php } ?>
		
		<?php
		// ERROR: writable forms dir
		if(!$contactformeditor_obj->isWritable($contactformeditor_obj->forms_dir_path)){?>
			<div class="cfgenwp-error">
				<p>The item purchase code can't be validated.</p>
				<?php echo sprintf($contactformeditor_obj->set_permission_format, 'editor/'.$contactformeditor_obj->forms_dir);?>				
			</div>
		<?php } ?>
		
		<?php
		if(isset($_POST['cfgenwp_buyer']) && isset($_POST['cfgenwp_purchase_code'])){
			
			if(isset($topstudio_tools_obj->unable_to_write_license_file)){?>
				<div class="cfgenwp-error">
					<?php echo $contactformeditor_obj->error_not_writable_dir_form_download;?>
				</div>
				<?php
			}
			else{?>
				<div class="cfgenwp-error">
					<p>Invalid item purchase code: please try again.</p>
					<p>If you think your purchase code is valid but you can't validate it, send us a message here:<br>
					<a href="<?php echo $contactformeditor_obj->url_envato_formgenerator_support;?>" target="_blank"><?php echo $contactformeditor_obj->url_envato_formgenerator_support;?></a></p>
					<p>We will get back to you in less than 24 hours.</p>
				</div>
			<?php
			}
		}
		?>
		
		<div class="cfgenwp-purchasecode-c">
			
			<div class="cfgenwp-thankyou">Thank you for your purchase</div>
			
			<div class="cfgenwp-pleaseactivate">Please start by activating the item with your purchase code</div>
			
			
			<div class="cfgenwp-form-purchasecode cfgenwp-index-panel">
				
				<div class="cfgenwp-getyourpurchasecode"><a href="http://www.topstudiodev.com/support/purchasecode" target="_blank"><strong>Click here to get your item purchase code</strong></a></div>
			
				<div class="cfgenwp-index-panel-c">
			
					<form action="index.php" method="post" class="cfgenwp-install-form">
					
						<label for="cfgenwp_buyer">Your username on CodeCanyon</label>
						<input type="text" name="cfgenwp_buyer" id="cfgenwp_buyer" value="" >
						
						<label for="cfgenwp_purchase_code">Your item purchase code</label>
						<input type="text" name="cfgenwp_purchase_code" id="cfgenwp_purchase_code" value="" >
						
						<input type="submit" id="cfgenwp_validate_purchase_code" value="Activate Contact Form Generator"  class="cfgenwp-button cfgenwp-button-blue cfgenwp-button-fullwidth">
						
						<div class="cfgenwp-clear"></div>
						
					</form>
					
				</div>
				
			</div>
			
		</div><!-- cfgenwp-purchasecode-c -->
	<?php
	}
	?>
</body>

</html>