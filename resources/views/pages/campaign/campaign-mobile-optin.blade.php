<!DOCTYPE html>
<html>
<head>
	<title> Preview </title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/email-editor.bundle.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/demo.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/colorpicker.css" /> 
	{{-- <link rel="stylesheet" type="text/css" href="http://cdn.tinymce.com/4/skins/lightgray/content.inline.min.css"/>   --}}
	<link rel="stylesheet" type="text/css" href="assets/css/colorpicker.css" />  

    <script src="<?php print url('/'); ?>/public/js/src/jquery-3.1.1.min.js"></script>
    <script src="<?php print url('/'); ?>/public/js/custom_jquery.js"></script>

	
		<script type="text/javascript"> 
			$(document).ready(function(){ 
				var containerCss = $('.bal-content-wrapper div:first-child').attr('style');  
				console.log(containerCss);
				$('body').attr('style', containerCss); 
			}); 
		</script>

	<style type="text/css" media="screen">
		.sortable-row-actions{ 
			display:none;
		}
		.bal-content-main { 
		    /*width: 70%;*/
		    margin:  0px auto;  
		}
		/*.bal-content-wrapper {
			height: 100%;
		}*/
	</style>
</head>
<body>
	<div class="container">
		<br><br>
		<?php 
			$content = htmlspecialchars_decode(stripslashes($campaign->content));
			$content = str_replace('contenteditable="true"', '', $content);
			echo $content; 
		?>  
	</div>

  <input type="hidden" value="{{$campaign->optin_url}}"   		   name="optin_url" id="optin_url" /> 
  <input type="hidden" value="{{$campaign->optin_email_content}}"   name="optin_email_content" id="optin_email_content" /> 
  {{-- New lines --}}
  <input type="hidden" value="{{$campaign->optin_email_subject}}"   name="optin_email_subject" id="optin_email_subject" />
  <input type="hidden" value="{{$campaign->optin_popup_link}}"      name="optin_popup_link" id="optin_popup_link" />
  <input type="hidden" value="{{$campaign->optin_email_to_name}}"   name="optin_email_to_name" id="optin_email_to_name" />
  <input type="hidden" value="{{$campaign->optin_email_to_mail}}"   name="optin_email_to_mail" id="optin_email_to_mail" />
 <br><br><br><br>
</body>
</html>