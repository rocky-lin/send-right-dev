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

$cfgenwp_config = $contactformeditor_obj->includeConfig();

include('../sourcecontainer/'.$contactformeditor_obj->dir_form_inc.'/class/class.form.php');
$contactform_obj = new contactForm($cfg=array());

// only possible when not using the demo
if($contactform_obj->demo != 1){

	$contactformeditor_obj->authentication(true);
	
	$contactformeditor_obj->setWritable('../'.$contactformeditor_obj->dir_upload);
	
	function uploadFile($copy_src_filename, $originalfilename, $testnewfilename){
		
		global $i;
		
		$contactformeditor_obj = new contactFormEditor();
		global $contactformeditor_obj;
	
		if(file_exists('../'.$contactformeditor_obj->dir_upload.$testnewfilename)){
		
			$fileinfo = pathinfo($originalfilename);
			$filename_noext =  basename($originalfilename,'.'.$fileinfo['extension']);
			
			
			$i++;
			$suffix = str_pad($i, 3, '0', STR_PAD_LEFT);
			
			$newfilename = $filename_noext.' - '.$suffix.'.'.$fileinfo['extension'];
			
			uploadFile($copy_src_filename, $originalfilename, $newfilename);
			
		} else{
		
			@copy($copy_src_filename, '../'.$contactformeditor_obj->dir_upload.$testnewfilename);
			echo $testnewfilename; // image file name needed to append the image with its new name in uploadSuccess (handlers.js)
		}
		
		
	}
	
	uploadFile($_FILES['Filedata']['tmp_name'], $_FILES['Filedata']['name'], $_FILES['Filedata']['name']);
	
	exit;
}
?>