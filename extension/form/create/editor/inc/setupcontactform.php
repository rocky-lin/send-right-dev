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

$contactform_obj = new contactForm(array());

if($contactform_obj->demo != 1){
	$contactformeditor_obj->authentication(true);
}


$json_decode_element = json_decode($contactformeditor_obj->quote_smart($_POST['element']), true);

if(!isset($_SESSION['cfgenwp_used_element_ids'][$json_decode_element['unique_hash_form_editor']])){
	$_SESSION['cfgenwp_used_element_ids'][$json_decode_element['unique_hash_form_editor']] = array();
}


if(isset($json_decode_element['id']) && $json_decode_element['id']){
	$explode_element_id = explode('-', $json_decode_element['id']); // prevents "Only variables shoulds be Passed by reference" when using end(explode()) in EasyPHP
	$loaded_element_numeric_id = end($explode_element_id);
	// that way if a form is loaded we keep the numeric id instead of having a new html id created with $_SESSION['cfgenwp_form_element_id']
}

if(isset($loaded_element_numeric_id)){
	$_SESSION['cfgenwp_used_element_ids'][$json_decode_element['unique_hash_form_editor']][] = $loaded_element_numeric_id;
}


if($_SESSION['cfgenwp_used_element_ids'][$json_decode_element['unique_hash_form_editor']] && !isset($loaded_element_numeric_id)){ 
	// we use max() for the elements added on the fly ( = no 'id' property)
	$_SESSION['cfgenwp_form_element_id'] = max($_SESSION['cfgenwp_used_element_ids'][$json_decode_element['unique_hash_form_editor']])+1;
} else{
	$_SESSION['cfgenwp_form_element_id'] = 1; 
}


if(isset($loaded_element_numeric_id)){
	$container_id = $loaded_element_numeric_id;
	$_SESSION['cfgenwp_form_element_id'] = $loaded_element_numeric_id; // else $_SESSION['cfgenwp_form_element_id'] would be stuck to one because of !isset($loaded_element_numeric_id) and we need a distinct value as the variable is used in class.contactformeditor.php
} else{
	$container_id = $_SESSION['cfgenwp_form_element_id'];
}

$_SESSION['cfgenwp_used_element_ids'][$json_decode_element['unique_hash_form_editor']][] = $_SESSION['cfgenwp_form_element_id'];

$element_type_with_properties = array('captcha', 'checkbox', 'date', 'email', 'hidden', 'image', 'radio', 'rating', 'select', 'selectmultiple', 'separator', 'submit', 'terms', 'text', 'textarea', 'time', 'title', 'upload', 'url');
$element_type_with_label = array('captcha', 'checkbox', 'date', 'email', 'radio', 'rating', 'select', 'selectmultiple', 'text', 'textarea', 'time', 'upload', 'url');
$element_type_with_icon = array('captcha', 'date', 'email', 'text', 'url');
$element_type_with_paragraph = array('captcha', 'checkbox', 'date', 'email', 'paragraph', 'radio', 'rating', 'select', 'selectmultiple', 'text', 'textarea', 'time', 'upload', 'url');
?>
<div class="cfgenwp-fb-e-move-c">
	<?php
	// echo $container_id.' | '.$_SESSION['cfgenwp_form_element_id'];
	// print_r($_SESSION['cfgenwp_used_element_ids']);
	?>
	
	<div id="cfgenwp-elementbuilder-<?php echo $container_id;?>" class="cfgenwp-fb-element-c" data-cfgenwp_element_type="<?php echo $json_decode_element['type'];?>" data-cfgenwp_element_id="<?php echo $container_id;?>">

		<?php echo $contactformeditor_obj->addFormField($json_decode_element, true);?>
		
		<div class="cfgenwp-e-editor-c">
		
			<?php if($contactform_obj->demo != 1){if(!isset($_SESSION['user']) || !$_SESSION['user']){exit;}}?>
		
			<div class="cfgenwp-e-editor-btns-c">

				<?php
				$editor_btns = array(
									array(	
											'title' => 'Edit element', 
											'img' => 'element-editor-menu-edit.png', 
											'var_type_name' => 'element_type_with_properties', 
											'panel'=>'cfgenwp-e-editsettings-c',
											),
									array(	
											'title' => 'Edit icon', 
											'img' => 'element-editor-menu-icon.png', 
											'var_type_name' => 'element_type_with_icon', 
											'panel'=>'cfgenwp-e-editicon-c',
											),
									array(	
											'title' => 'Edit alignment', 
											'img' => 'element-editor-menu-alignment.png', 
											'var_type_name' => 'element_type_with_label', 
											'panel'=>'cfgenwp-e-editalignment-c',
											),
									array(
											'title' => 'Edit paragraph', 
											'class' => 'cfgenwp-e-editor-btn-paragraph', 
											'img' => 'element-editor-menu-paragraph.png', 
											'var_type_name' => 'element_type_with_paragraph',
											'panel'=>'cfgenwp-e-editparagraph-c',
											),
									);			

				foreach($editor_btns as $btn_v){
					
					if(in_array($json_decode_element['type'], ${$btn_v['var_type_name']})){?>
					
						<div class="cfgenwp-e-editor-btn" title="<?php echo $btn_v['title'];?>" data-cfgenwp_editor_panel="<?php echo $btn_v['panel'];?>">
							<img src="img/<?php echo $btn_v['img'];?>">
						</div>

					<?php
					}
				}
				?>
				
				<div class="cfgenwp-e-editor-btn cfgenwp-e-editor-btn-delete" title="Delete this element" >
					<img src="img/cross.png">
				</div>
			
			</div>

			<div class="cfgenwp-clear"></div>
			
			<?php
			if(in_array($json_decode_element['type'], $element_type_with_label)){?>
				<div class="cfgenwp-e-editor-panel cfgenwp-e-editalignment-c">
					<?php
					echo $contactformeditor_obj->addEditAlignment($json_decode_element);
					echo $contactformeditor_obj->closeEditContainer();
					?>
				</div>
			<?php
			}
			?>
			
			<?php
			if(in_array($json_decode_element['type'], $element_type_with_paragraph)){?>
				<div class="cfgenwp-e-editor-panel cfgenwp-e-editparagraph-c">
					<?php
					echo $contactformeditor_obj->addEditParagraph($json_decode_element);
					echo $contactformeditor_obj->closeEditContainer();
					?>
				</div>
			<?php
			}
			?>
			
			<?php
			if(in_array($json_decode_element['type'], $element_type_with_properties)){?>
				<div class="cfgenwp-e-editor-panel cfgenwp-e-editsettings-c">
					<?php
					echo $contactformeditor_obj->addEditFormField($json_decode_element);
					echo $contactformeditor_obj->closeEditContainer();
					?>
				</div>
			<?php
			}
			?>
			
			<?php
			if(in_array($json_decode_element['type'], $element_type_with_icon)){?>
				<div class="cfgenwp-e-editor-panel cfgenwp-e-editicon-c">
				<?php
				echo $contactformeditor_obj->addEditIcon($json_decode_element);
				echo $contactformeditor_obj->closeEditContainer();
				?>
				</div>
			<?php
			}
			?>
			
		</div>
		
		<div class="cfgenwp-clear"></div>
		
	</div>
	
	
	<div class="cfgenwp-e-editor-btn cfgenwp-e-editor-btn-move" title="Move this element">
		<img src="img/arrow-move.png">
	</div>
	
	<div class="cfgenwp-clear"></div>
	
</div>