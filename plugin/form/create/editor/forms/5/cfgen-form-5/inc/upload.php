<?php
if( !isset($_FILES['Filedata']['name']) || (isset($_FILES['Filedata']['name']) && !$_FILES['Filedata']['name']) ) {echo 'no file sent'; exit;}

$check_fileinfo = pathinfo($_FILES['Filedata']['name']);
if( in_array(strtolower($check_fileinfo['extension']), array('asp', 'avfp', 'aspx', 'c', 'csp', 'cfm', 'gsp', 'ssjs', 'js', 'jsp', 'lp', 'op', 'lua', 'cgi', 'ipl', 'pl', 'php', 'rhtml', 'py', 'rb', 'rbw', 'smx', 'lasso', 'tcl', 'dna', 'tpl', 'r', 'w')) ) {echo 'unauthorized extension'; exit;}

$isset_btn = array('uploadbutton_cfgen_element_5_6');

if( (isset($_GET['btn_upload_id']) && !in_array($_GET['btn_upload_id'], $isset_btn)) || !isset($_GET['btn_upload_id']) ) {echo 'upload buttons are not set'; exit;}



			if(isset($_GET['btn_upload_id']) && $_GET['btn_upload_id'] == 'uploadbutton_cfgen_element_5_6')
			{
				if(!$_FILES['Filedata']['size']) {echo 'empty file'; exit;}
				
				if($_FILES['Filedata']['size'] > 1000000) {echo 'unauthorized file size'; exit;}
			}

?><?php
/**
 * controls are written in saveform.php
 * !isset($_FILES['Filedata']['name'] and !$_FILES['Filedata']['name'] => no file sent
 * !isset($_GET['btn_upload_id']) and !in_array($_GET['btn_upload_id'], $isset_btn) => upload buttons are not set
 * !in_array($fileinfo['extension'], $upload_auth_ext) => unauthorized extension
 * !$_FILES['Filedata']['size'] => empty file
 * if($_FILES['Filedata']['size'] > xxx) => unauthorized file size'
 */


include('sessionpath.php');

include('../inc/form-config.php');

include('../class/class.form.php');

$contactform_obj = new contactForm($cfg);

$_FILES['Filedata']['name'] = $contactform_obj->quote_smart($_FILES['Filedata']['name']);
// ^-- if file name contains simple quotes, {"filename":"aaa\'aaa.gif"} will be returned => json won't be parsed correctly because of the extra \

function uploadFile($copy_src_filename, $originalfilename, $testnewfilename){
	
	global $i;
	
	$dir_upload = '../upload/';
	
	if(!is_writable($dir_upload)){
		@chmod($dir_upload, 0755);
	}

	if(file_exists($dir_upload.$testnewfilename)){
	
		$fileinfo = pathinfo($originalfilename);
		$filename_noext =  basename($originalfilename,'.'.$fileinfo['extension']);
		
		
		$i++;
		$suffix = str_pad($i, 3, '0', STR_PAD_LEFT);
		
		$newfilename = $filename_noext.' - '.$suffix.'.'.$fileinfo['extension'];
		
		uploadFile($copy_src_filename, $originalfilename, $newfilename);
		
	} else{
		$_SESSION['uploaded_files'][] = $testnewfilename;
		
		copy($copy_src_filename, $dir_upload.$testnewfilename);
		// image file name needed to append the image with its new name in uploadSuccess (handlers.js)
		?>
		{"filename":"<?php echo $testnewfilename;?>"}
	<?php
	}
	
	
}

uploadFile($_FILES['Filedata']['tmp_name'], $_FILES['Filedata']['name'], $_FILES['Filedata']['name']);

exit;
?>