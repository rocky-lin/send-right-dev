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
	
	$post_filename = (isset($_POST['filename']) && $_POST['filename']) ? $_POST['filename'] : '';
	
	if($post_filename){
		
		foreach($post_filename as $post_filename_value){
			
			unlink('../'.$contactformeditor_obj->dir_upload.$contactformeditor_obj->quote_smart($post_filename_value));
			
			// FILE STILL EXISTS?
			// problem with infomaniak servers http://stackoverflow.com/questions/12117266/php-file-is-writable-but-cannot-be-deleted
			if(is_file('../'.$contactformeditor_obj->dir_upload.$contactformeditor_obj->quote_smart($post_filename_value))){
				
				echo json_encode(array('response'=>'nok', 'response_msg'=>$contactformeditor_obj->errorNotWritableAdminUpload($post_filename_value)));
				exit;
			}
		}
	}
}

// No error found, yet a valid json string must be returned to prevent "Uncaught SyntaxError: Unexpected end of input" since jQuery 1.10
echo '{}';

?>