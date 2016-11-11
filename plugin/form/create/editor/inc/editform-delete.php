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
	
	$post_form_id = (isset($_POST['form_id']) && $_POST['form_id']) ? $_POST['form_id'] : '';
	
	if($post_form_id){
		
		$form_index_file = $contactformeditor_obj->formsindex_filename_path;
		
		
		// JSON INDEX FILE WRITABLE?
		$is_writable_form_index_file = false;
		
		if(!$contactformeditor_obj->isWritable($form_index_file)){
			
			echo json_encode(array('response'=>'nok', 'response_msg'=>$contactformeditor_obj->error_not_writable_form_index_file));
			exit;
			
		} else{
			$is_writable_form_index_file = true;
		}
		
		
		// LOAD JSON INDEX FILE
		$json_form_index = $contactformeditor_obj->getFormsIndex();
		
		//print_r($json_form_index);
		
		foreach($post_form_id as $post_form_id_v){

			foreach($json_form_index['forms'] as $form_key=>$form_value){

				if($form_value['form_id'] == $post_form_id_v){

					$form_dir = $form_value['form_dir'];

					unset($json_form_index['forms'][$form_key]);

					break;
				}
			}

			//print_r($json_form_index);

			/***
			 * array_values required
			 * For example: if the form has 2 entries and if we unset the first entry, 
			 * the json will look like this: {"forms":{"1":{" instead of {"forms":[{"
			 *
			 * http://stackoverflow.com/questions/3869129/php-json-encode-as-object-after-php-array-unset
			 * "The reason for that is that your array has a hole in it: it has the indices 0 and 2, but misses 1. 
			 * JSON can't encode arrays with holes because the array syntax has no support for indices.
			 * You can encode array_values($a) instead, which will return a reindexed array."
			 *
			 * "The unset() function allows removing keys from an array. Be aware that the array will not be reindexed"
			 */
			 
			$json_form_index['forms'] = array_values($json_form_index['forms']); 


			if($is_writable_form_index_file){

				$dir_to_delete = $contactformeditor_obj->forms_dir_path.$contactformeditor_obj->quote_smart($form_dir);

				if($form_dir && is_dir($dir_to_delete)){

					if(is_writable($dir_to_delete)){

						// DELETE FORM DIRECTORY
						$contactformeditor_obj->rrmdir($dir_to_delete);

						// REWRITE FORM INDEX FILE
						$json_form_index_write = json_encode($json_form_index);

						$contactformeditor_obj->writeFormsIndex(json_encode($json_form_index));

						$form_deleted[] = $post_form_id_v;

					} else{

						echo json_encode(array('form_deleted'=>$form_deleted, 
												'response'=>'nok', 
												'response_msg'=>$contactformeditor_obj->errorNotWritableDirForm($form_dir)
												));
						exit;

					} // is_writable
				} // is_dir
			}// is_writable_form_index_file
		} // foreach($post_form_dir 
	} // if($post_form_dir)

}

// No error found, yet a valid json string must be returned to prevent "Uncaught SyntaxError: Unexpected end of input" since jQuery 1.10
echo '{}';

?>