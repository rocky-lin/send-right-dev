<!DOCTYPE html>

<html>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

<meta charset="utf-8">

<title>My Contact Form</title>


<!-- Form Start -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src="cfgen-form-5/js/form.js"></script>
<link href="cfgen-form-5/css/form.css" rel="stylesheet" type="text/css">

<script src="cfgen-form-5/js/swfupload/swfupload.js"></script>
<script src="cfgen-form-5/js/swfupload/swfupload.queue.js"></script>
<script src="cfgen-form-5/js/swfupload/fileprogress.js"></script>
<script src="cfgen-form-5/js/swfupload/handlers.js"></script>
<script src="cfgen-form-5/js/upload.js"></script>
<link href="cfgen-form-5/js/swfupload/default.css" rel="stylesheet" type="text/css">

<!-- Form End -->


</head>

<body>

<div class="cfgen-form-container" id="cfgen-form-5">

<div class="cfgen-form-content">


<?php
$dir_install_contactform = 'cfgen-form-5';

if(!is_dir($dir_install_contactform.'/upload'))
{
	@mkdir($dir_install_contactform.'/upload', 0755);
}

if(!is_writable($dir_install_contactform.'/upload'))
{
	@chmod($dir_install_contactform.'/upload', 0755);
	
	if(!is_writable($dir_install_contactform.'/upload'))
	{
		@chmod($dir_install_contactform.'/upload', 0777);
		
		if(!is_writable($dir_install_contactform.'/upload'))
		{
					
			echo '<div style="color:#cc0000; border:1px solid #cc0000; background-color:#fef6f3; font-family: Arial; font-size:14px; padding:0 10px;">'
					.'<p><strong>The upload directory is not writable</strong>: uploads won\'t work in your form.</p>'
					.'<p>Use your FTP software to set the permission to <strong>755</strong> on the directory <strong>'.$dir_install_contactform.'/upload</strong> to solve this problem.</p>'
					.'<p>Set the permission to <strong>777</strong> if it does not work otherwise. If your website is installed on a Windows based server, you must make the directory writable.</p>'
					.'<p>If there is no directory <strong>upload</strong> inside the directory <strong>'.$dir_install_contactform.'</strong>, use your FTP software to create it and set it with the permissions mentionned above (755 or 777).</p>'
					.'</div>';
					
		}
	}
}
?>

<div class="cfgen-e-c">
	<div class="cfgen-title" id="cfgen-element-5-1">Contact us</div>
</div>


<div class="cfgen-e-c">

	<div class="cfgen-e-set" id="cfgen-element-5-2-set-c">
		<div class="cfgen-paragraph" id="cfgen-element-5-2-paragraph">
		To contact us, use the form below.<br />
We will get back to you as soon as possible.
		</div>
	</div>

</div>


<div class="cfgen-e-c">

	<label class="cfgen-label" id="cfgen-element-5-3-label" ><span class="cfgen-label-value">Email address</span><span class="cfgen-required">*</span></label>

	<div class="cfgen-e-set" id="cfgen-element-5-3-set-c">
		<div class="cfgen-input-group" id="cfgen-element-5-3-inputgroup-c">
			<div class="cfgen-input-c" id="cfgen-element-5-3-input-c">
				<input type="text" class="cfgen-type-email cfgen-form-value " name="cfgen-element-5-3" id="cfgen-element-5-3">
			</div>
		</div>
	</div>

	<div class="cfgen-clear"></div>

</div>


<div class="cfgen-e-c">

	<label class="cfgen-label" id="cfgen-element-5-4-label" ><span class="cfgen-label-value">Your message</span></label>

	<div class="cfgen-e-set" id="cfgen-element-5-4-set-c">
		<div class="cfgen-input-group" id="cfgen-element-5-4-inputgroup-c">
			<div class="cfgen-input-c" id="cfgen-element-5-4-input-c">
				<textarea class="cfgen-type-textarea cfgen-form-value " name="cfgen-element-5-4" id="cfgen-element-5-4"></textarea>
			</div>
		</div>
	</div>

	<div class="cfgen-clear"></div>

</div>


<div class="cfgen-e-c">

	<label class="cfgen-label" id="cfgen-element-5-6-label" ><span class="cfgen-label-value">Upload</span></label>

	<div class="cfgen-e-set" id="cfgen-element-5-6-set-c">
		<div class="cfgen-input-group" id="cfgen-element-5-6-inputgroup-c">
			<input type="hidden" class="cfgen-form-value cfgen-uploadfilename" name="cfgen-element-5-6" >
			<input type="hidden" class="cfgen-uploaddeletefile" value="1" >
			<span id="uploadbutton_cfgen_element_5_6" class="btnUpload"></span>
			<input id="btnCancel_cfgen_element_5_6" type="button" value="Cancel Upload" onclick="swfupload_cfgen_element_5_6.cancelQueue();" disabled="disabled" style="display:none;margin-left: 2px; font-size: 8pt; height: 29px;" >
			<div id="fsUploadProgress_cfgen_element_5_6"></div>
		</div>
	</div>

	<div class="cfgen-clear"></div>

</div>


<div class="cfgen-e-c">

	<label class="cfgen-label" id="cfgen-element-5-7-label" ><span class="cfgen-label-value">Captcha: type the characters below</span></label>

	<div class="cfgen-e-set" id="cfgen-element-5-7-set-c">
		<div class="cfgen-captcha-c">
			<img src="cfgen-form-5/inc/captcha.php" class="cfgen-captcha-img" alt="" ><img src="cfgen-form-5/img/captcha-refresh.png" class="cfgen-captcha-refresh" alt="">
		</div>
		<div class="cfgen-input-group" id="cfgen-element-5-7-inputgroup-c">
			<div class="cfgen-input-c" id="cfgen-element-5-7-input-c">
				<input type="text" name="cfgen-element-5-7" id="cfgen-element-5-7" class="cfgen-captcha-input">
			</div>
		</div>
	</div>

	<div class="cfgen-clear"></div>

</div>


<div class="cfgen-e-c">

	<div class="cfgen-e-set" id="cfgen-element-5-5-set-c">
		<div class="cfgen-input-group" id="cfgen-element-5-5-inputgroup-c">
			<div class="cfgen-input-c" id="cfgen-element-5-5-input-c">
				<input type="submit" class="cfgen-submit" name="cfgen-element-5-5" id="cfgen-element-5-5" value="Send">
			</div>
		</div>
	</div>

</div>


<div class="cfgen-loading"></div>

</div><!-- cfgen-form-content -->

</div><!-- cfgen-form-container -->

</body>


</html>