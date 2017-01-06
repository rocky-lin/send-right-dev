<?php
session_start();
/**********************************************************************************
 * Contact Form Generator is (c) Top Studio
 * It is strictly forbidden to use or copy all or part of an element other than for your 
 * own personal and private use without prior written consent from Top Studio http://topstudiodev.com
 * Copies or reproductions are strictly reserved for the private use of the person 
 * making the copy and not intended for a collective use.
 *********************************************************************************/

 
// print "this is the form creation"; 
// print "<prE>";
// print_r($_SESSION);
// print "</pre>";

//require laravel
require "../../../../laravel-load.php";
//print "test";
// use App\User;
//print Auth::user()->name;
//print_r(User::find(1));








$id = (!empty($_GET['id'])) ? $_GET['id'] : false;
require '../../../autoload.php';  
$formController = new FormController(new Model()); 

// print "this is";
require 'inc/sessionpath.php';

require 'class/class.formbuilder.menu.php';

require 'class/class.ts.tools.php';
$topstudio_tools_obj = new TopStudio_Tools();

require 'class/class.contactformeditor.php';
$cfgenwp_editor_obj = new contactFormEditor();

$cfgenwp_config = $cfgenwp_editor_obj->includeConfig();

require 'class/class.cfgenwp.api.editor.php';
$cfgenwpapi_editor_obj = new cfgenwpApiEditor();

require 'sourcecontainer/'.$cfgenwp_editor_obj->dir_form_inc.'/class/class.form.php';

$contactform_obj = new contactForm($cfg=array());


if($contactform_obj->demo != 1){
	$cfgenwp_editor_obj->authentication(true);
}

$form_id_exist = true;


// LOAD CONFIG FILE: GOOGLE WEB FONTS API KEY
if(!isset($_SESSION['cfgenwp_googlewebfonts_list']) || !$_SESSION['cfgenwp_googlewebfonts_list']){
	// ^-- session name also used in config.php

	if($cfgenwp_config['googlewebfontsapikey'] && extension_loaded('openssl')){
		
		$cfgenwp_googlewebfonts_content = '';
		
		$cfgenwp_googlewebfonts_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key='.$cfgenwp_config['googlewebfontsapikey'];
		
		if(ini_get('allow_url_fopen')){
			$cfgenwp_googlewebfonts_content = @file_get_contents($cfgenwp_googlewebfonts_api_url); // @ because "failed to open stream: HTTP request failed! HTTP/1.0 403 Forbidden" may appear
		} else{
			$cfgenwp_googlewebfonts_content = $topstudio_tools_obj->loadCurlFile($cfgenwp_googlewebfonts_api_url);
		}

		$cfgenwp_googlewebfonts_content = json_decode($cfgenwp_googlewebfonts_content, true);
		
		
		if(isset($cfgenwp_googlewebfonts_content['items'])){			
			$_SESSION['cfgenwp_googlewebfonts_list'] = array();
			
			foreach($cfgenwp_googlewebfonts_content['items'] as $cfgenwp_gwf_key=>$cfgenwp_gwf_value){
				$_SESSION['cfgenwp_googlewebfonts_list']['item'][$cfgenwp_gwf_value['family']]['variants'] = $cfgenwp_gwf_value['variants'];
				$_SESSION['cfgenwp_googlewebfonts_list']['items'][] = array('family'=>$cfgenwp_gwf_value['family'], 'variants'=>$cfgenwp_gwf_value['variants']);
			}
		}
	}
}

$json_load_form_setup = '';
$loaded_form_json_key = '';
$cfgenwp_form_load = array();

$json_load_form = $cfgenwp_editor_obj->getFormsIndex();

if(isset($_GET['id']) && $_GET['id'] && $contactform_obj->demo != 1){
	
	if($json_load_form['forms']){
		
		foreach($json_load_form['forms'] as $form_key=>$form_value){
			
			if($form_value['form_id'] == $_GET['id']){
				$json_load_form_setup = $form_value['element'];
				$loaded_form_json_key = $form_key;
				break;
			}
		}
		
		if(!$json_load_form_setup){
			$form_id_exist = false;
		}
	}
} else{
	$json_load_form_setup = $cfgenwp_editor_obj->form_elements_setup;
}

if($loaded_form_json_key || $loaded_form_json_key === 0){
	$cfgenwp_form_load = $json_load_form['forms'][$loaded_form_json_key];
}


// API LISTS
$cfgenwp_loadform_api_config = array();

if(!empty($cfgenwp_form_load['api'])){
	foreach($cfgenwp_form_load['api'] as $cfgenwp_form_load_api_k=>$cfgenwp_form_load_api_v){
		// $cfgenwp_form_load_api_k : id of the api
		$cfgenwp_loadform_api_config[$cfgenwp_form_load_api_k] = $cfgenwp_form_load_api_v;
	}
}
// print_r($cfgenwp_loadform_api_config);



// SMTP CONFIG
// don't use if($loaded_form_json_key) because it would return false for the first form ($loaded_form_json_key would equal 0, first key for the array)
if($cfgenwp_form_load){
	
	if(isset($cfgenwp_form_load['form_inc_dir'])){
		
		$loadcontactformconfig_file = $cfgenwp_editor_obj->forms_dir_path.'/'.$cfgenwp_form_load['form_dir'].'/'.$cfgenwp_form_load['form_inc_dir'].'/inc/form-config.php';
		
		if(is_file($loadcontactformconfig_file)){
			include($loadcontactformconfig_file);
		}
	}
}

if(!$topstudio_tools_obj->licenseFileExists()){
	exit;
}

?><!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">

<title>Contact Form Generator - Online Form Builder</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

<?php
// GOOGLE WEB FONTS (css in <head>)
// don't use if($cfgenwp_loaded_form_json_key) because it would return false for the first form ($cfgenwp_loaded_form_json_key would equal 0, first key for the array)
if($cfgenwp_form_load){
	if(!empty($cfgenwp_form_load['googlewebfonts'])){
		echo $cfgenwp_editor_obj->getLinkGoogleWebFonts($cfgenwp_form_load['googlewebfonts'], true);
	}
}
?>

<link rel="stylesheet" href="<?php echo $cfgenwp_editor_obj->path_jquery_ui_theme;?>"> 

<link href="//fonts.googleapis.com/css?family=Open+Sans:400,600%7CRoboto:400,500" rel="stylesheet" type="text/css">

<style type="text/css">
<?php
require 'inc/contactform-css.php';
echo $cfgenwp_editor_obj->buildFormDefaultCss($cfgenwp_form_css, array('body'));
?>
</style>
<link rel="stylesheet" type="text/css" href="css/global.css">
<link rel="stylesheet" type="text/css" href="css/contactformeditor.css">
<link rel="stylesheet" type="text/css" href="css/api.css">
<link rel="stylesheet" type="text/css" href="<?php echo $cfgenwp_editor_obj->path_fontawesome;?>">
<meta name="robots" content="noindex, nofollow">
	
	<?php require ('include/js.php'); ?>

</head>

<body>


<div id="cfgenwp-formbuilder-wrap">

<div id="cfgenwp-formbuilder-container"> 

	<?php require ('include/check-php-version.php'); ?> 
	<?php require ('include/check-buy-or-not.php'); ?> 
	<?php require ('include/cfgenwp-formbuilder-l.php'); ?>

	<div class="cfgenwp-formbuilder-r">
	
		<div id="cfgenwp-formbuilder-toolbar" class="cfgenwp-fb-panel">
			
			<div id="cfgenwp-openform-list">
				<?php
				if($contactform_obj->demo != 1){
					
					$cfgenwp_openform_print_form_container = false;
					
					if($json_load_form['forms']){
						
						function cfgenwp_sortForms($a, $b){
							global $topstudio_tools_obj;
							return $topstudio_tools_obj->sortArrayBy($a, $b, 'form_name');
						}
						
						usort($json_load_form['forms'], 'cfgenwp_sortForms');
						
						foreach($json_load_form['forms'] as $cfgenwp_open_form_k=>$cfgenwp_open_form_v){
						
							$cfgenwp_open_form_name = $cfgenwp_open_form_v['form_name'].' #'.$cfgenwp_open_form_v['form_id'];
							
							if(is_dir($cfgenwp_editor_obj->forms_dir_path.'/'.$cfgenwp_open_form_v['form_dir'])){
							
								$cfgenwp_openform_print_form_container = true;?>
								
								<div class="cfgenwp-openform-item-c">
									<a href="<?php echo '?id='.$cfgenwp_open_form_v['form_id'];?>"><?php echo $cfgenwp_open_form_name;?></a>
								</div>
								
								<?php
							}
						}
					}
					
					if(!$cfgenwp_openform_print_form_container){
						echo '<p>No form created yet</p>';
					}
					
				} else{
					echo '<p>This feature is disabled in demo mode</p>';
				}
				?>
			</div>
			
			<div>
			
				<!-- <div class="cfgenwp-toolbar-btn" id="cfgenwp-newform">New</div> -->
		
				<!-- <div class="cfgenwp-toolbar-btn cfgenwp-openform-closed" id="cfgenwp-openform-btn">Open</div> -->
		
				<div class="cfgenwp-toolbar-btn cfgenwp-toolbaraction" id="cfgenwp-style-all">Colors<span class="cfgenwp-responsive-hide-inline"> and fonts</span></div>
				
				<div class="cfgenwp-toolbar-btn cfgenwp-toolbaraction" id="cfgenwp-textinputformat">Inputs</div>
				
				<div class="cfgenwp-toolbar-btn" id="cfgenwp-expandall">Expand all</div>
				
				<div class="cfgenwp-toolbar-btn" id="cfgenwp-collapseall">Collapse all</div>
				
				<div class="cfgenwp-toolbar-btn" id="cfgenwp-clearform">Clear form</div>
				
				<?php
				if($contactform_obj->demo != 1){?>
					<div class="cfgenwp-toolbar-btn" id="cfgenwp-exit-form"><a href="<?php print $_SESSION['extension']['site_url']; ?>/user/form">Exit</a></div>
				<?php } ?>
				
			</div>

			<div class="cfgenwp-clear"></div>
			
			<div id="cfgenwp-genericstyle-container">
			
				<div id="cfgenwp-genericstyle-text-c">
					
					<?php
					$cfgenwp_gs_objects = array(
												array('type'=>'label', 'title'=>'Labels', 'target'=>'label.cfgen-label', 'fontsize_slider_function'=>'cfgen_sliderLabelAllFontSize'),
												array('type'=>'input', 'title'=>'Inputs', 'target'=>'input[type="text"].cfgen-form-value, select.cfgen-form-value, textarea.cfgen-form-value', 'fontsize_slider_function'=>'cfgen_sliderInputAllFontSize'),
												array('type'=>'paragraph', 'title'=>'Paragraphs', 'target'=>'div.cfgen-paragraph', 'fontsize_slider_function'=>'cfgen_sliderParagraphAllFontSize'),
												array('type'=>'title', 'title'=>'Titles', 'target'=>'div.cfgen-title', 'fontsize_slider_function'=>'cfgen_sliderTitleAllFontSize'),
												);

					foreach($cfgenwp_gs_objects as $cfgenwp_gs_object_v){
					
						$cfgenwp_config_fse['title'] = $cfgenwp_gs_object_v['title'];
						
						$cfgenwp_gs_object_type = $cfgenwp_gs_object_v['type'];
						
						$cfgenwp_config_fse['data']['object_type'] = $cfgenwp_gs_object_type;

						$cfgenwp_config_fse['fontfamily_select_id'] = 'cfgenwp-'.$cfgenwp_gs_object_type.'-fontfamily-select';
						$cfgenwp_config_fse['fontfamily_value'] = !empty($cfgenwp_form_load['css'][$cfgenwp_gs_object_type]['default']['font-family']) ? $cfgenwp_form_load['css'][$cfgenwp_gs_object_type]['default']['font-family'] : $cfgenwp_editor_obj->getCssPropertyDefaultValue($cfgenwp_gs_object_type, 'font-family');

						$cfgenwp_config_fse['fontweight_select_id'] = 'cfgenwp-'.$cfgenwp_gs_object_type.'-fontweight-select';
						$cfgenwp_config_fse['fontweight_value'] = !empty($cfgenwp_form_load['css'][$cfgenwp_gs_object_type]['default']['font-weight']) ? $cfgenwp_form_load['css'][$cfgenwp_gs_object_type]['default']['font-weight'] : $cfgenwp_editor_obj->getCssPropertyDefaultValue($cfgenwp_gs_object_type, 'font-weight');
						
						$cfgenwp_config_fse['fontstyle_select_id'] = 'cfgenwp-'.$cfgenwp_gs_object_type.'-fontstyle-select';
						$cfgenwp_config_fse['fontstyle_value'] = !empty($cfgenwp_form_load['css'][$cfgenwp_gs_object_type]['default']['font-style']) ? $cfgenwp_form_load['css'][$cfgenwp_gs_object_type]['default']['font-style'] : $cfgenwp_editor_obj->getCssPropertyDefaultValue($cfgenwp_gs_object_type, 'font-style');

						$cfgenwp_config_fse['fontsize_select_id'] = 'cfgenwp-'.$cfgenwp_gs_object_type.'-all-fontsize-select';
						$cfgenwp_config_fse['fontsize_slider_id'] = 'cfgenwp-'.$cfgenwp_gs_object_type.'-fontsize-slider';
						$cfgenwp_config_fse['fontsize_value'] = !empty($cfgenwp_form_load['css'][$cfgenwp_gs_object_type]['default']['font-size']) ? $cfgenwp_editor_obj->getNumbersOnly($cfgenwp_form_load['css'][$cfgenwp_gs_object_type]['default']['font-size']) : $cfgenwp_editor_obj->getCssPropertyDefaultValue($cfgenwp_gs_object_type, 'font-size');
						$cfgenwp_config_fse['fontsize_target'] = $cfgenwp_gs_object_v['target'];
						$cfgenwp_config_fse['fontsize_slider_function'] = $cfgenwp_gs_object_v['fontsize_slider_function'];
						
						$cfgenwp_config_fse['colorpicker_input_id'] = 'cfgenwp-'.$cfgenwp_gs_object_type.'-color';
						$cfgenwp_config_fse['colorpicker_target'] = $cfgenwp_gs_object_v['target'];
						$cfgenwp_config_fse['colorpicker_objecttype'] = $cfgenwp_gs_object_type;
						$cfgenwp_config_fse['colorpicker_csspropertyname'] = 'color';
						$cfgenwp_config_fse['colorpicker_applytoall'] = true;
						$cfgenwp_config_fse['colorpicker_color'] = !empty($cfgenwp_form_load['css'][$cfgenwp_gs_object_type]['default']['font-weight']) ? $cfgenwp_form_load['css'][$cfgenwp_gs_object_type]['default']['color'] : $cfgenwp_editor_obj->getCssPropertyDefaultValue($cfgenwp_gs_object_type, 'color');
						
						if($cfgenwp_gs_object_type === 'input'){
							
							$cfgenwp_config_fse['backgroundcolor_colorpicker_defaultcolor'] = $cfgenwp_editor_obj->getCssPropertyDefaultValue($cfgenwp_gs_object_type, 'background-color');
							
							if(!empty($cfgenwp_form_load['css']['input']['default']['background-color'])){
								$cfgenwp_config_fse['backgroundcolor_colorpicker_defaultcolor'] = $cfgenwp_form_load['css']['input']['default']['background-color'];
							}
							
							$cfgenwp_config_fse['bordercolor_colorpicker_defaultcolor'] = $cfgenwp_editor_obj->getCssPropertyDefaultValue($cfgenwp_gs_object_type, 'border-color');
							
							if(!empty($cfgenwp_form_load['css']['input']['default']['border-color'])){
								$cfgenwp_config_fse['bordercolor_colorpicker_defaultcolor'] = $cfgenwp_form_load['css']['input']['default']['border-color'];
							}
						}
						
						//echo $cfgenwp_editor_obj->fontStyleEditor($cfgenwp_config_fse);
						
						$select_data_attr = array('cfgenwp_object_type'=>$cfgenwp_config_fse['data']['object_type']);?>
							
						<div class="cfgenwp-fontstyleeditor">
						
							<?php
							$cfgenwp_editor_obj->editorpanel->createPanel($cfgenwp_config_fse['title']);
							$cfgenwp_editor_obj->editorpanel->addProperty($cfgenwp_editor_obj->addEditFontFamily(array(
																						'fontfamily_value'=>$cfgenwp_config_fse['fontfamily_value'], 
																						'data_attr'=>array_merge($select_data_attr, array(
																																		'cfgenwp_applytoall'=>true,
																																		'cfgenwp_fontfamily_selected'=>$cfgenwp_config_fse['fontfamily_value'], 
																																		'cfgenwp_fontweight_selected'=>$cfgenwp_config_fse['fontweight_value'])), 
																						'fontfamily_select_id'=>$cfgenwp_config_fse['fontfamily_select_id'])));
							
							
							$slider_all_fontsize = $cfgenwp_editor_obj->addSelectSlider(array(
																								'slider_id'=>$cfgenwp_config_fse['fontsize_slider_id'],
																								'slider_function'=>$cfgenwp_config_fse['fontsize_slider_function'],
																								'select_id'=>$cfgenwp_config_fse['fontsize_select_id'], 
																								'option_min'=>$cfgenwp_editor_obj->slider_fontsize_min, 
																								'option_max'=>$cfgenwp_editor_obj->slider_fontsize_max, 
																								'option_selected'=>$cfgenwp_config_fse['fontsize_value'],
																							));
							$cfgenwp_editor_obj->editorpanel->addProperty( array(  array('name'=>'Font size', 'values'=>array($slider_all_fontsize))  ) );


							$cfgenwp_editor_obj->editorpanel->addProperty($cfgenwp_editor_obj->addEditFontWeight(array(
																						'fontweight_value'=>$cfgenwp_config_fse['fontweight_value'], 
																						'fontweight_select_id'=>$cfgenwp_config_fse['fontweight_select_id'], 
																						'data_attr'=>array_merge($select_data_attr, array(
																																		'cfgenwp_applytoall'=>true,
																																		'cfgenwp_fontfamily_selected'=>$cfgenwp_config_fse['fontfamily_value'])), 
																						), $cfgenwp_editor_obj->getFontVariants($cfgenwp_config_fse['fontfamily_value'], 'fontweight')));

																						
							$cfgenwp_editor_obj->editorpanel->addProperty($cfgenwp_editor_obj->addEditFontStyle(array(
																						'fontstyle_value'=>$cfgenwp_config_fse['fontstyle_value'], 
																						'data_attr'=>array_merge($select_data_attr, array(
																																		'cfgenwp_applytoall'=>true,
																																		'cfgenwp_fontfamily_selected'=>$cfgenwp_config_fse['fontfamily_value'])), 
																						'fontstyle_select_id'=>$cfgenwp_config_fse['fontstyle_select_id']
																						), $cfgenwp_editor_obj->getFontVariants($cfgenwp_config_fse['fontfamily_value'], 'fontstyle')));

							$cfgenwp_editor_obj->editorpanel->addProperty( array(  array('name'=>'Color', 'values'=>array($cfgenwp_editor_obj->setUpColorPicker($cfgenwp_config_fse, false)))  ) );


							if($cfgenwp_config_fse['data']['object_type'] === 'label'){
				
								// LABEL MARGIN-BOTTOM
								$slider_label_marginbottom = $cfgenwp_editor_obj->addSelectSlider(array(
																									'slider_id'=>'cfgenwp-label-all-marginbottom-slider',
																									'slider_function'=>'cfgen_sliderLabelMarginBottom',
																									'select_id'=>'cfgenwp-label-all-marginbottom-select', 
																									'option_min'=>0, 
																									'option_max'=>20, 
																									'option_selected'=>$cfgenwp_editor_obj->getNumbersOnly(!empty($cfgenwp_form_load['css']['label']['default']['margin-bottom']) ? $cfgenwp_form_load['css']['label']['default']['margin-bottom'] : $cfgenwp_editor_obj->getCssPropertyDefaultValue('label', 'margin-bottom')),
																									));

								$cfgenwp_editor_obj->editorpanel->addProperty( array(  array('name'=>'Bottom margin', 'values'=>array($slider_label_marginbottom))  ) );
							}
							
							if($cfgenwp_config_fse['data']['object_type'] === 'input'){
								
								// INPUT BACKGROUND COLOR
								$cpicker_input_bg['colorpicker_input_id'] = 'cfgenwp-input-backgroundcolor';
								$cpicker_input_bg['colorpicker_target'] = 'input[type="text"].cfgen-form-value, select.cfgen-form-value, textarea.cfgen-form-value';
								$cpicker_input_bg['colorpicker_objecttype'] = 'input';
								$cpicker_input_bg['colorpicker_csspropertyname'] = 'background-color';
								$cpicker_input_bg['colorpicker_applytoall'] = true;
								$cpicker_input_bg['colorpicker_color'] = $cfgenwp_config_fse['backgroundcolor_colorpicker_defaultcolor'];
								$cfgenwp_editor_obj->editorpanel->addProperty( array(  array('name'=>'Background', 'values'=>array($cfgenwp_editor_obj->setUpColorPicker($cpicker_input_bg, false)))  ) );
								
								// INPUT BORDER COLOR
								$cpicker_input_border['colorpicker_input_id'] = 'cfgenwp-input-bordercolor';
								$cpicker_input_border['colorpicker_target'] = 'input[type="text"].cfgen-form-value, select.cfgen-form-value, textarea.cfgen-form-value';
								$cpicker_input_border['colorpicker_objecttype'] = 'input';
								$cpicker_input_border['colorpicker_csspropertyname'] = 'border-color';
								$cpicker_input_border['colorpicker_applytoall'] = true;
								$cpicker_input_border['colorpicker_color'] = $cfgenwp_config_fse['bordercolor_colorpicker_defaultcolor'];
								$cfgenwp_editor_obj->editorpanel->addProperty( array(  array('name'=>'Border', 'values'=>array($cfgenwp_editor_obj->setUpColorPicker($cpicker_input_border, false)))  ) );

								// BORDER-COLOR ON FOCUS
								$cpicker_input_focus_bordercolor['colorpicker_input_id'] = 'cfgenwp-input-bordercolor-focus';
								$cpicker_input_focus_bordercolor['colorpicker_target'] = 'input[type="text"].cfgen-form-value, select.cfgen-form-value, textarea.cfgen-form-value';
								$cpicker_input_focus_bordercolor['colorpicker_objecttype'] = 'input';
								$cpicker_input_focus_bordercolor['colorpicker_csspropertyname'] = 'outline';
								$cpicker_input_focus_bordercolor['colorpicker_applytoall'] = true;
								$cpicker_input_focus_bordercolor['colorpicker_color'] = !empty($cfgenwp_form_load['css']['input']['focus']['border-color']) ? $cfgenwp_form_load['css']['input']['focus']['border-color'] : $cfgenwp_editor_obj->getCssPropertyDefaultValue('input', 'border-color', 'focus');
								$cpicker_input_focus_bordercolor['colorpicker_paletteonly'] = true;
								$cfgenwp_editor_obj->editorpanel->addProperty( array(  array('name'=>'Border focus', 'values'=>array($cfgenwp_editor_obj->setUpColorPicker($cpicker_input_focus_bordercolor, false)))  ) );
								
							}

							$cfgenwp_editor_obj->editorpanel->getEditor();
							?>
							
						</div>

						<?php
					}
					?>
					
				</div><!-- cfgenwp-genericstyle-text-c -->
			
				<div id="cfgenwp-genericstyle-input-c">
				
					<div class="cfgenwp-fontstyleeditor">
						
						<?php
						$cfgenwp_editor_obj->editorpanel->createPanel('Input design');

						// INPUT PADDING
						$html_input_padding = $cfgenwp_editor_obj->addSelectSlider(array(
																						'slider_id'=>'cfgenwp-input-all-padding-slider',
																						'slider_function'=>'cfgen_sliderInputPadding',
																						'select_id'=>'cfgenwp-input-all-padding-select', 
																						'option_min'=>0, 
																						'option_max'=>20, 
																						'option_selected'=>$cfgenwp_editor_obj->getNumbersOnly(!empty($cfgenwp_form_load['css']['input']['default']['padding']) ? $cfgenwp_form_load['css']['input']['default']['padding'] : $cfgenwp_editor_obj->getCssPropertyDefaultValue('input', 'padding')),
																					));

						$cfgenwp_editor_obj->editorpanel->addProperty( array(  array('name'=>'Padding', 'values'=>array($html_input_padding))  ) );


						// INPUT BORDER-RADIUS
						$html_input_border_radius = $cfgenwp_editor_obj->addSelectSlider(array(
																							   'slider_id'=>'cfgenwp-input-borderradius-slider',
																							   'slider_function'=>'cfgen_sliderInputBorderRadius',
																							   'select_id'=>'cfgenwp-input-all-borderradius-select', 
																							   'option_min'=>0, 
																							   'option_max'=>30, 
																							   'option_selected'=>$cfgenwp_editor_obj->getNumbersOnly(!empty($cfgenwp_form_load['css']['input']['default']['border-radius']) ? $cfgenwp_form_load['css']['input']['default']['border-radius'] : $cfgenwp_editor_obj->getCssPropertyDefaultValue('input', 'border-radius')),
																							   ));

						$cfgenwp_editor_obj->editorpanel->addProperty( array(  array('name'=>'Border radius', 'values'=>array($html_input_border_radius))  ) );


						// INPUT BORDER-WIDTH
						$html_input_border_width = $cfgenwp_editor_obj->addSelectSlider(array(
																							  'slider_id'=>'cfgenwp-input-borderwidth-slider',
																							  'slider_function'=>'cfgen_sliderInputBorderWidth',
																							  'select_id'=>'cfgenwp-input-all-borderwidth-select', 
																							  'option_min'=>0, 
																							  'option_max'=>10, 
																							  'option_selected'=>$cfgenwp_editor_obj->getNumbersOnly(!empty($cfgenwp_form_load['css']['input']['default']['border-width']) ? $cfgenwp_form_load['css']['input']['default']['border-width'] : $cfgenwp_editor_obj->getCssPropertyDefaultValue('input', 'border-width')),
																							  ));
						
						$cfgenwp_editor_obj->editorpanel->addProperty( array(  array('name'=>'Border width', 'values'=>array($html_input_border_width))  ) );

						$cfgenwp_editor_obj->editorpanel->getEditor();
						?>
						
					</div>
					
				</div>
				
				<div class="cfgenwp-clear"></div>
			
				<div id="cfgenwp-genericstyle-close">Close</div>

			</div><!-- cfgenwp-genericstyle-container -->

		</div>
		
		
		<?php
		$cfgenwp_loadform_data_c_style = '';
		$cfgenwp_loadform_data_formname = '';
		
		if($cfgenwp_form_load){
			
			$cfgenwp_loadform_data_formname = $cfgenwp_form_load['form_name'];
			$cfgenwp_loadform_data_c_style = 'display:block;';
			
			if(isset($_GET['duplicate']) && $_GET['duplicate'] == 1){
				$cfgenwp_form_load['form_name'] = $cfgenwp_loadform_data_formname = $cfgenwp_form_load['form_name'].' copy';
			}
		}
		?>
		
		<div id="cfgenwp-loadform-data-c" class="cfgenwp-fb-panel" style="<?php echo $cfgenwp_loadform_data_c_style;?>">
			<?php echo $cfgenwp_loadform_data_formname;?>
		</div>

		<div id="cfgenwp-fb-c" class="cfgenwp-fb-panel">
		
		
			<div id="cfgenwp-fb-editor-c">
				<?php
				if(!$form_id_exist){?>
					<div class="warning">
						<p><strong>Error: you are trying a load a form that does not exist</strong>.</p>
						<p>Form id: <strong><?php echo $cfgenwp_editor_obj->htmlEntities($_GET['id']);?></strong></p>
					</div>
					<?php
				}
				?>
			
				<?php
				// SUHOSIN CHECK
				$check_suhosin_post_max_value_length = 100000;
				/**
					$check_suhosin_get_max_value_length = 100000;
					&& (ini_get('suhosin.get.max_value_length')<$check_suhosin_get_max_value_length || ini_get('suhosin.post.max_value_length')<$check_suhosin_post_max_value_length)
					<br><strong>suhosin.get.max_value_length</strong> : <span style="font-weight:bold; color: #009900;"><?php echo $check_suhosin_get_max_value_length;?></span>
				*/
				if(extension_loaded('suhosin') && ini_get('suhosin.post.max_value_length')<$check_suhosin_post_max_value_length){ ?>

					<div class="warning">

						<p><strong>Error: there is a small misconfiguration on your server</strong>.</p>
						
						<p>The Suhosin extension is installed on your server and the current value for <strong>suhosin.post.max_value_length</strong> is <strong><?php echo ini_get('suhosin.post.max_value_length');?></strong>.</p>
						
						<p>These settings are too low to make Contact Form Generator work properly.</p>
						
						<p>You can easily solve this problem by contacting your web hosting technical support and ask them to apply the settings below.

						<br><strong>suhosin.post.max_value_length</strong> : <span style="font-weight:bold; color: #009900;"><?php echo $check_suhosin_post_max_value_length;?></span>
						
						</p><p><strong>The best solution would be to turn off/disable Suhosin</strong> on the directory where Contact Form Generator is installed</p>
						
						<p>If you need further assistance, don't hesitate to contact us at support@topstudiodev.com,
						<br>we will be glad to help you.</p>
					
					</div>
				<?php
				}
				?>
				
				<div id="cfgenwp-fb-form"></div>

				<span id="cfgenwp-gotoformconfiguration" class="cfgenwp-button cfgenwp-button-blue">Next step: go to form settings</span>

			</div><!-- cfgenwp-fb-editor-c -->
		
		
		
			<div id="cfgenwp-formsettings">

				<h2>Form settings</h2>
				
				<div class="cfgenwp-formconfig-separator"></div>
				
				<?php
				class TsCfgenForm{
					
					function __construct(){
						
						$this->setFormId('');
						
						$this->setFormName('My Contact Form');
						
						$this->setFormValidationMessage('Thank you, your message has been sent to us.'."\r\n".'We will get back to you as soon as possible.');
						
						$this->setFormAdminNotificationSubject('New message sent from your website');
						
						$this->setFormUserNotificationSubject('Thank you for your message');
						
						$this->setFormUserNotificationMessage('Thank you for contacting us.'."\r\n".'We will answer you as soon as possible.');
						
						$this->setFormEmailSendingMethod('php');
						
						$this->setFormDatabaseCharset('utf8');
						
					}
					
					function setFormId($value){
						$this->form_id = $value;
					}
					
					function getFormId(){
						return $this->form_id;
					}
					
					function setFormName($value){
						$this->form_name = $value;
					}
					
					function getFormName() {  
						return (!empty($_SESSION['formEntryStep1']['formName'])) ? $_SESSION['formEntryStep1']['formName'] : $this->form_name;  
					}
					function getSelectedList() {
						return $_SESSION['formEntryStep1']['selectedList']; 
					}
					function getSelectedAutoResponder() {
						return $_SESSION['formEntryStep1']['autoresponse']['name']; 
					}

					function setFormEmail($value){
						$this->form_email = $value;
					}
					
					function getFormEmail(){


						return isset($this->form_email) ? $this->form_email : $_SESSION['formEntryStep1']['email'];
					}
					
					function setFormEmailFrom($value){
						$this->form_email_from = $value;
					}
					
					function getFormEmailFrom(){
						return isset($this->form_email_from) ? $this->form_email_from : null;
					}

					function setFormEmailCC($value){
						$this->form_email_cc = $value;
					}
					
					function getFormEmailCC(){
						return isset($this->form_email_cc) ? $this->form_email_cc : null;

					}

					function setFormEmailBCC($value){
						$this->form_email_bcc = $value;
					}
					
					function getFormEmailBCC(){
						return isset($this->form_email_bcc) ? $this->form_email_bcc : null;
					}
					
					function setFormAdminNotificationSubject($value){
						$this->admin_notification_subject = $value;
					}
					
					function getFormAdminNotificationSubject(){
						return $this->admin_notification_subject;
					}

					function setFormUserNotificationSubject($value){
						$this->user_notification_subject = $value;
					}
					
					function getFormUserNotificationSubject(){
						return $this->user_notification_subject;
					}

					function setFormUserNotificationMessage($value){
						$this->user_notification_message = $value;
					}
					
					function getFormUserNotificationMessage(){
						return $this->user_notification_message;
					}

					function setFormEmailSendingMethod($value){
						$this->email_sending_method = $value;
					}
					
					function getFormEmailSendingMethod(){
						return $this->email_sending_method;
					}

					function setFormValidationMessage($value){
						$this->form_validation_message = $value;
					}
					
					function getFormValidationMessage(){
						return $this->form_validation_message;
					}

					function setFormDatabaseHost($value){
						$this->db_host = $value;
					}
					
					function getFormDatabaseHost(){
						return isset($this->db_host) ? $this->db_host : null;
					}

					function setFormDatabaseName($value){
						$this->db_name = $value;
					}
					
					function getFormDatabaseName(){
						return isset($this->db_name) ? $this->db_name : null;
					}

					function setFormDatabaseLogin($value){
						$this->db_login = $value;
					}
					
					function getFormDatabaseLogin(){
						return isset($this->db_login) ? $this->db_login : null;
					}

					function setFormDatabasePassword($value){
						$this->db_password = $value;
					}
					
					function getFormDatabasePassword(){
						return isset($this->db_password) ? $this->db_password : null;
					}

					function setFormDatabaseTable($value){
						$this->db_table = $value;
					}
					
					function getFormDatabaseTable(){
						return isset($this->db_table) ? $this->db_table : null;
					}

					function setFormDatabaseCharset($value){
						$this->db_charset = $value;
					}
					
					function getFormDatabaseCharset(){
						return isset($this->db_charset) ? $this->db_charset : null;
					}

					function setFormTimezone($value){
						$this->form_timezone = $value;
					}

					function getFormTimezone(){
						return isset($this->form_timezone) ? $this->form_timezone : null;
					}

					function setFormSMTPHost($value){
						$this->smtp_host = $value;
					}

					function getFormSMTPHost(){
						return $this->smtp_host;
					}

					function setFormSMTPPort($value){
						$this->smtp_port = $value;
					}

					function getFormSMTPPort(){
						return $this->smtp_port;
					}

					function setFormSMTPEncryption($value){
						$this->smtp_encryption = $value;
					}

					function getFormSMTPEncryption(){
						return $this->smtp_encryption;
					}

					function setFormSMTPUsername($value){
						$this->smtp_username = $value;
					}

					function getFormSMTPUsername(){
						return $this->smtp_username;
					}

					function setFormSMTPPassword($value){
						$this->smtp_password = $value;
					}

					function getFormSMTPPassword(){
						return $this->smtp_password;
					}
				}
		

				
				class TsCfgenFormSetting{
					
					function __construct(){
						$this->setFormSettingVisible();
					}
					
					function setFormSettingTitle($value){
						$this->form_setting_title = $value;
					}
					
					function getFormSettingTitle(){
						return isset($this->form_setting_title) ? $this->form_setting_title : null;
					}
					
					function setFormSettingValue($value){
						$this->form_setting_value = $value;
					}
					
					function getFormSettingValue(){
						return $this->form_setting_value;
					}
					
					function setFormSettingLabelFor($value){
						$this->form_setting_label_for = $value;
					}
					
					function getFormSettingLabelFor(){
						return isset($this->form_setting_label_for) ? $this->form_setting_label_for : null;
					}
					
					function setFormSettingHidden(){
						$this->form_setting_visible = false;
					}
					
					function setFormSettingVisible(){
						$this->form_setting_visible = true;
					}
					
					function formSettingIsVisible(){
						return $this->form_setting_visible === true ? true : false;
					}
					
					function setFormSettingContainerHtmlId($value){
						$this->form_setting_container_html_id = $value;
					}
					
					function getFormSettingContainerHtmlId(){
						return isset($this->form_setting_container_html_id) ? $this->form_setting_container_html_id : null;
					}
					
					function setFormSettingContainerHtmlClass($value){
						$this->form_setting_container_html_class = $value;
					}
					
					function getFormSettingContainerHtmlClass(){
						return isset($this->form_setting_container_html_class) ? $this->form_setting_container_html_class : null;
					}
					
					function getFormSettingHtml(){
						
						$config_c_id = $this->getFormSettingContainerHtmlId() ? ' id="'.$this->getFormSettingContainerHtmlId().'"' : '';
						
						$config_c_class = $this->getFormSettingContainerHtmlClass() ? ' '.$this->getFormSettingContainerHtmlClass() : '';
						
						$config_c_style = $this->formSettingIsVisible() ? '' : ' style="display:none;"';
						
						
						$html = '<div class="cfgenwp-formconfig-c'.$config_c_class.'"'.$config_c_style.$config_c_id.'>'

									.'<div class="cfgenwp-formconfig-l">'
									.($this->getFormSettingTitle() ? '<label for="'.$this->getFormSettingLabelFor().'">'.$this->getFormSettingTitle().'</label>' : '')
									.'</div>'

									.'<div class="cfgenwp-formconfig-r">'
									.$this->getFormSettingValue()
									.'</div>'

									.'<div class="cfgenwp-clear"></div>'

								.'</div>';
						return $html;
					}
					
					function printFormSettingHtml(){
						echo $this->getFormSettingHtml();
					}
				}
				
				
				$tscfgenform = new TsCfgenForm();
				
				if(!empty($cfgenwp_form_load['form_name'])){
					$tscfgenform->setFormName($cfgenwp_form_load['form_name']);
					$tscfgenform->setFormId($cfgenwp_form_load['form_id']);
				}
				
				if(isset($_GET['duplicate']) && $_GET['duplicate'] == 1){
					$tscfgenform->setFormId('');
				}
				
				
				// FORM NAME
				$tscfgenform_setting = new TsCfgenFormSetting();
				$tscfgenform_setting->setFormSettingTitle('Form name');
				$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-form-name');
				$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-config-form-name" value="'.$cfgenwp_editor_obj->htmlEntities($tscfgenform->getFormName()).'">'
															.'<input type="hidden" id="cfgenwp-form-id" value="'.$tscfgenform->getFormId().'">');
				$tscfgenform_setting->printFormSettingHtml();

				// selected list display
				$tscfgenform_setting = new TsCfgenFormSetting();
				$tscfgenform_setting->setFormSettingTitle('Selected List ');
				$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-form-name');
				$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-config-list-name" value="'.$tscfgenform->getSelectedList().'"   disabled />'); 
				$tscfgenform_setting->printFormSettingHtml();

				// selected list display
				$tscfgenform_setting = new TsCfgenFormSetting();
				$tscfgenform_setting->setFormSettingTitle('Selected Autoresponder');
				$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-form-name');
				$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-config-list-name" value="'.$tscfgenform->getSelectedAutoResponder().'"   disabled />'); 
				$tscfgenform_setting->printFormSettingHtml();




 
				// EMAIL
				if(!empty($cfgenwp_form_load['config_email_address'])) $tscfgenform->setFormEmail($cfgenwp_form_load['config_email_address']);
				
				// CC
				if(!empty($cfgenwp_form_load['config_email_address_cc'])) $tscfgenform->setFormEmailCC(implode(',', $cfgenwp_form_load['config_email_address_cc']));
				
				// BCC
				if(!empty($cfgenwp_form_load['config_email_address_bcc'])) $tscfgenform->setFormEmailBCC(implode(',', $cfgenwp_form_load['config_email_address_bcc']));
				
				// style applied on cc block and bcc block
				if(!$tscfgenform->getFormEmailCC() && !$tscfgenform->getFormEmailBCC()){
					$cfgenwp_edit_cc_bcc_c_style = 'display:none';
					$cfgenwp_add_cc_bcc_style = '';
				} else{
					$cfgenwp_edit_cc_bcc_c_style = ''; 
					$cfgenwp_add_cc_bcc_style = 'display:none';
				}
				?>
				
				
				<?php
				// EMAIL
				$tscfgenform_setting = new TsCfgenFormSetting();
				$tscfgenform_setting->setFormSettingTitle('Your email address');
				$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-email-address');
				$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-config-email-address" value="'.$tscfgenform->getFormEmail().'">'
														 .'<p>You will receive the form notification messages on this email address</p>'
														 .'<div>'
														 .'<span id="cfgenwp-add-cc-bcc-recipients" class="cfgenwp-edit-cc-bcc-toggle cfgenwp-a" style="'.$cfgenwp_add_cc_bcc_style.'">Add recipients to the notification message (Cc and Bcc fields)</span>'
														 .'<span id="cfgenwp-remove-cc-bcc-recipients" class="cfgenwp-edit-cc-bcc-toggle cfgenwp-a" style="'.$cfgenwp_edit_cc_bcc_c_style.'">Remove Cc and Bcc recipients</span>'
														 .'</div>');
				$tscfgenform_setting->printFormSettingHtml();
				?>

				<script>
				jQuery(function(){
					jQuery('span.cfgenwp-edit-cc-bcc-toggle').click(function(){
					
					   jQuery('#cfgenwp-edit-cc-bcc-config-c').slideToggle(100, 
																function(){
																	if(!jQuery(this).is(':visible')){	
																		jQuery('#cfgenwp-config-email-address-cc, #cfgenwp-config-email-address-bcc').val('');																
																		jQuery('#cfgenwp-remove-cc-bcc-recipients').hide();
																		jQuery('#cfgenwp-add-cc-bcc-recipients').show();
																	} else{
																		jQuery('#cfgenwp-add-cc-bcc-recipients').hide();
																		jQuery('#cfgenwp-remove-cc-bcc-recipients').show();																
																	}
																});
					});
				});
				</script>
				
				<div id="cfgenwp-edit-cc-bcc-config-c" style="<?php echo $cfgenwp_edit_cc_bcc_c_style;?>">
				
					<?php
					// EMAIL CC
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Cc recipient(s)');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-email-address-cc');
					$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-config-email-address-cc" value="'.$tscfgenform->getFormEmailCC().'"><p>These recipients will receive a copy of the data collected in the form<br>Use commas to separate mutiple e-mail addresses</p>');
					$tscfgenform_setting->printFormSettingHtml();
					?>
					
					
					<?php
					// EMAIL BCC
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Bcc recipient(s)');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-email-address-bcc');
					$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-config-email-address-bcc" value="'.$tscfgenform->getFormEmailBCC().'"><p>These recipients will receive a copy of the data collected in the form<br>Use commas to separate mutiple e-mail addresses</p>');
					$tscfgenform_setting->printFormSettingHtml();
					?>
					
				</div>
				
				
				<?php
				// ADMIN NOTIFICATION SUBJECT
				if(isset($cfgenwp_form_load['config_adminnotification_subject'])) $tscfgenform->setFormAdminNotificationSubject($cfgenwp_form_load['config_adminnotification_subject']);
				
				$tscfgenform_setting = new TsCfgenFormSetting();
				$tscfgenform_setting->setFormSettingTitle('Notification subject line');
				$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-admin-notification-subject');
				$tscfgenform_setting->setFormSettingValue('<input type="text" class="cfgenwp-target-insertfieldvalue" id="cfgenwp-config-admin-notification-subject" value="'.$cfgenwp_editor_obj->htmlEntities($tscfgenform->getFormAdminNotificationSubject()).'">'
														 .'<select class="cfgenwp-insertfieldvalue"></select>');
				$tscfgenform_setting->printFormSettingHtml();
				?>
				
				
				<?php
				// TIMEZONE
				if(!empty($cfgenwp_form_load['config_timezone'])) $tscfgenform->setFormTimezone($cfgenwp_form_load['config_timezone']);
				
				$cfgenwp_config_timezone_select = '<select id="cfgenwp-config-timezone" class="cfgenwp-formsettings-select">';

				foreach(DateTimeZone::listIdentifiers() as $cfgenwp_timezone_id){

					$cfgenwp_selected_timezone = '';
					
					if($tscfgenform->getFormTimezone() == $cfgenwp_timezone_id){
					   $cfgenwp_selected_timezone = ' selected ';
					} else{
						if(!$tscfgenform->getFormTimezone()){
							if($cfgenwp_timezone_id == date_default_timezone_get() || $cfgenwp_timezone_id == ini_get('date.timezone')){
								$cfgenwp_selected_timezone = ' selected ';
							}
						}
					}
					
					$cfgenwp_config_timezone_select .= '<option '.$cfgenwp_selected_timezone.' value="'.$cfgenwp_timezone_id.'">'.$cfgenwp_timezone_id.'</option>';

				}
				
				$cfgenwp_config_timezone_select .= '</select>';

				$tscfgenform_setting = new TsCfgenFormSetting();
				$contactform_obj->demo == 1 ? $tscfgenform_setting->setFormSettingHidden() : '';
				$tscfgenform_setting->setFormSettingTitle('Timezone');
				$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-timezone');
				$tscfgenform_setting->setFormSettingValue($cfgenwp_config_timezone_select);
				$tscfgenform_setting->printFormSettingHtml();
				?>
				

				<div class="cfgenwp-formconfig-separator"></div>
				
				<h3>Database integration</h3>

				
				<?php
				// DATABASE ACTIVATE
				$cfgenwp_config_database_activate_checked = !empty($cfgenwp_form_load['config_database_host']) ? $cfgenwp_editor_obj->checked : '';
				
				$tscfgenform_setting = new TsCfgenFormSetting();
				$tscfgenform_setting->setFormSettingValue('<input type="checkbox" id="cfgenwp-config-database-activate" '.$cfgenwp_config_database_activate_checked.'>'
														 .'<label for="cfgenwp-config-database-activate">Insert/Save the form submissions in your database</label>');
				$tscfgenform_setting->printFormSettingHtml();
				?>
				
				
				<div id="cfgenwp-database-config-c" style="<?php echo (isset($cfgenwp_form_load['config_database_host']) ? 'display:block' : 'display:none'); ?>">
					
					<?php
					// DATABASE HOST
					if(!empty($cfgenwp_form_load['config_database_host'])) $tscfgenform->setFormDatabaseHost($cfgenwp_form_load['config_database_host']);
					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Database host');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-database-host');
					$tscfgenform_setting->setFormSettingValue('<input type="text" class="cfgenwp-config-credentials" id="cfgenwp-database-host" value="'.$cfgenwp_editor_obj->htmlEntities($tscfgenform->getFormDatabaseHost()).'">');
					$tscfgenform_setting->printFormSettingHtml();
					?>

					
					<?php
					// DATABASE NAME
					if(!empty($cfgenwp_form_load['config_database_name'])) $tscfgenform->setFormDatabaseName($cfgenwp_form_load['config_database_name']);
					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Database name');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-database-name');
					$tscfgenform_setting->setFormSettingValue('<input type="text" class="cfgenwp-config-credentials" id="cfgenwp-database-name" value="'.$cfgenwp_editor_obj->htmlEntities($tscfgenform->getFormDatabaseName()).'">');
					$tscfgenform_setting->printFormSettingHtml();
					?>

					
					<?php
					// DATABASE LOGIN
					if(!empty($cfgenwp_form_load['config_database_login'])) $tscfgenform->setFormDatabaseLogin($cfgenwp_form_load['config_database_login']);
					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Database login');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-database-login');
					$tscfgenform_setting->setFormSettingValue('<input type="text" autocomplete="off" class="cfgenwp-config-credentials" id="cfgenwp-database-login" value="'.$cfgenwp_editor_obj->htmlEntities($tscfgenform->getFormDatabaseLogin()).'">');
					$tscfgenform_setting->printFormSettingHtml();
					?>

					
					<?php
					// DATABASE PASSWORD
					if(!empty($cfgenwp_form_load['config_database_password'])) $tscfgenform->setFormDatabasePassword($cfgenwp_form_load['config_database_password']);
					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Database password');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-database-password');
					$tscfgenform_setting->setFormSettingValue('<input type="password" autocomplete="off" class="cfgenwp-config-credentials" id="cfgenwp-database-password" value="'.$cfgenwp_editor_obj->htmlEntities($tscfgenform->getFormDatabasePassword()).'">');
					$tscfgenform_setting->printFormSettingHtml();
					?>
					
					
					<?php
					// DATABASE TABLE NAME
					if(!empty($cfgenwp_form_load['config_database_table'])) $tscfgenform->setFormDatabaseTable($cfgenwp_form_load['config_database_table']);
					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Database table name');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-database-table');
					$tscfgenform_setting->setFormSettingValue('<input type="text" class="cfgenwp-config-credentials" id="cfgenwp-database-table" value="'.$cfgenwp_editor_obj->htmlEntities($tscfgenform->getFormDatabaseTable()).'">');
					$tscfgenform_setting->printFormSettingHtml();
					?>
					

					<?php
					// DATABASE CHARACTER SET
					if(!empty($cfgenwp_form_load['config_database_table_charset'])) $tscfgenform->setFormDatabaseCharset($cfgenwp_form_load['config_database_table_charset']);
					
					
					$cfgenwp_database_charset_collection = array('armscii8', 'ascii', 'big5', 'binary', 'cp1250', 'cp1251', 'cp1256', 'cp1257', 'cp850', 'cp852', 'cp866', 'cp932', 'dec8', 'eucjpms', 'euckr', 'gb2312', 'gbk', 'geostd8', 'greek', 'hebrew', 'hp8', 'keybcs2', 'koi8r', 'koi8u', 'latin1', 'latin2', 'latin5', 'latin7', 'macce', 'macroman', 'sjis', 'swe7', 'tis620', 'ucs2', 'ujis', 'utf16', 'utf32', 'utf8', 'utf8mb4',);

					$cfgenwp_database_s_table_charset = '<select class="cfgenwp-config-credentials" id="cfgenwp-database-table-charset">';
					
					foreach($cfgenwp_database_charset_collection as $cfgenwp_database_s_charset_v){
						
						$cfgenwp_database_charset_selected = $cfgenwp_database_s_charset_v === $tscfgenform->getFormDatabaseCharset() ? $cfgenwp_editor_obj->selected : '';
						
						$cfgenwp_database_s_table_charset .= '<option value="'.$cfgenwp_database_s_charset_v.'" '.$cfgenwp_database_charset_selected.'>'.$cfgenwp_database_s_charset_v.'</option>';
					}
					
					$cfgenwp_database_s_table_charset .= '</select>';


					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Table character set');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-database-table-charset');
					$tscfgenform_setting->setFormSettingValue($cfgenwp_database_s_table_charset);
					$tscfgenform_setting->printFormSettingHtml();
					?>
					
					<div class="cfgenwp-formconfig-c">
					
						<p id="cfgenwp-database-howto-p">Drag and drop the values you want to save in the panel on the right.</p>
						
						<div id="cfgenwp-database-select-form-elements"></div>
						
						<div id="cfgenwp-database-builder" class="cfgenwp-database-builder cfgenwp-database-builder"></div>
					
						<div class="cfgenwp-clear"></div>
						
					</div>
					
				</div>

				
				<div class="cfgenwp-formconfig-separator"></div>

				 
		<!-- 		<div class="cfgenwp-formconfig-c">
				<div class="cfgenwp-formconfig-l">
				 	<h3>Redirect Url</h3>
				</div>  
					<div class="cfgenwp-formconfig-r">
					 	<input type="text" id="cfgenwp-redirect-url" value="" placeholder="http://www.yourdomain.com" /> 
				 	</div>
				 	<div class="cfgenwp-clear"></div>
				</div>
 -->






			<div class="cfgenwp-formconfig-separator"></div>
				<h3 class="un-used-elements">Email marketing integration</h3>
				
				<div class="cfgenwp-formconfig-c un-used-elements">
					
					<div class="cfgenwp-formconfig-l">
					</div>
					
					<div class="cfgenwp-formconfig-r">
					
						<div class="cfgenwp-service-menu-c">
						
							<?php
							foreach($cfgenwpapi_editor_obj->service_types['emaillist'] as $cfgenwp_api_service_id_v){
								$cfgenwp_api_service = $cfgenwpapi_editor_obj->service[$cfgenwp_api_service_id_v];
								?>
								<div id="cfgenwp-service-menu-<?php echo $cfgenwp_api_service['id'];?>" class="cfgenwp-service-menu-ico" data-cfgenwp_api_id="<?php echo $cfgenwp_api_service['id'];?>">
									
									<div class="cfgenwp-service-menu-btn cfgenwp-service-menu-btn-add"><i class="fa fa-plus-circle"></i> Add</div>
									<div class="cfgenwp-service-menu-btn cfgenwp-service-menu-btn-remove"><i class="fa fa-minus-circle"></i> Remove</div>
									
								</div>
							<?php
							}
							?>
							
							<div class="cfgenwp-clear"></div>
						
						</div><!-- cfgenwp-service-menu-c -->
						
						<?php
						function cfgenwp_getFromConfigOrFromLoadForm($cfgenwp_config, $cfgenwp_form_load, $key){
							
							$val = !empty($cfgenwp_config[$key]) ? $cfgenwp_config[$key] : '';

							$val = isset($cfgenwp_form_load[$key]) ? $cfgenwp_form_load[$key] : $val;
							
							return $val;
						}
						
						foreach($cfgenwpapi_editor_obj->service_types['emaillist'] as $cfgenwp_api_service_id_v){
						
							$cfgenwp_api_service = $cfgenwpapi_editor_obj->service[$cfgenwp_api_service_id_v];

							if(!isset($cfgenwp_loadform_api_config[$cfgenwp_api_service['id']])){
								$cfgenwp_loadform_api_config[$cfgenwp_api_service['id']] = array();
							}
							
							
							$cfgenwp_aweber_data_att = '';

							if($cfgenwp_api_service['id'] === 'aweber'){

								foreach($cfgenwp_api_service['formconfig']['credentials'] as $cfgenwp_api_service_formconfig_k=>$cfgenwp_api_service_formconfig_v){
									
									$cfgenwp_api_service['formconfig']['credentials'][$cfgenwp_api_service_formconfig_k] = cfgenwp_getFromConfigOrFromLoadForm($cfgenwp_config[$cfgenwp_api_service['id']], 
																						$cfgenwp_loadform_api_config[$cfgenwp_api_service['id']],
																						$cfgenwp_api_service_formconfig_k);
																						
									// The name of the data attributes must be the same as in api.js
									$cfgenwp_aweber_data_att .= 'data-cfgenwp_api_'.$cfgenwp_api_service_formconfig_k.'="'
																.$cfgenwp_editor_obj->htmlEntities($cfgenwp_api_service['formconfig']['credentials'][$cfgenwp_api_service_formconfig_k]).'" ';

								}
								
							}
							?>
								
							<div id="cfgenwp-service-editor-<?php echo $cfgenwp_api_service['id'];?>" <?php echo $cfgenwp_aweber_data_att;?> class="cfgenwp-editor-api-c <?php echo ($cfgenwp_loadform_api_config[$cfgenwp_api_service['id']] ? 'cfgenwp-editor-api-c-selected' : '');?>" data-cfgenwp_api_id="<?php echo $cfgenwp_api_service['id'];?>" data-cfgenwp_api_name="<?php echo $cfgenwp_api_service['name'];?>">
								
								
								<div class="cfgenwp-api-remove cfgenwp-api-button">
									X
								</div>
								
								<div class="cfgenwp-api-buttons-c">

									<div class="cfgenwp-api-reload cfgenwp-api-button">
										Reload lists
									</div>
									
									<div class="cfgenwp-api-signin cfgenwp-api-button">
										Sign in as a different user
									</div>

								</div>

								
								<div class="cfgenwp-editor-api-name cfgenwp-api-ico-<?php echo $cfgenwp_api_service['id'];?>">
									<span><?php echo $cfgenwp_api_service['name'];?></span>
								</div>
								
								<div class="cfgenwp-clear"></div>
									
								<div class="cfgenwp-editor-api-builder">
								
								<?php
								$cfgenwp_api_works = $cfgenwpapi_editor_obj->checkServiceRequirements($cfgenwp_api_service['id']);
								
								if(!$cfgenwp_api_works['status']){
									foreach($cfgenwp_api_works['errors'] as $cfgenwp_api_err_v){?>
										<div class="cfgenwp-api-status-error">
											<?php echo $cfgenwp_api_err_v;?>
										</div>
										<?php
									}
								} else{?>
								
									<div class="cfgenwp-editor-api-authentication">

										<?php
										foreach($cfgenwp_api_service['credentials'] as $cfgenwp_api_access_requirement_k=>$cfgenwp_api_access_requirement_v){

											$cfgenw_api_auth_val[$cfgenwp_api_access_requirement_k] = cfgenwp_getFromConfigOrFromLoadForm($cfgenwp_config[$cfgenwp_api_service['id']], $cfgenwp_loadform_api_config[$cfgenwp_api_service['id']], $cfgenwp_api_access_requirement_k);
											
											$cfgenwp_service_input['attr']['class'] = 'cfgenwp-api-'.$cfgenwp_api_access_requirement_k;
											$cfgenwp_service_input['attr']['value'] = $cfgenwp_editor_obj->htmlEntities($cfgenw_api_auth_val[$cfgenwp_api_access_requirement_k]);
											$cfgenwp_service_input['attr']['id'] = 'cfgenwp_'.$cfgenwp_api_service['id'].'_'.$cfgenwp_api_access_requirement_k;


											?>

											<div class="cfgenwp-formconfig-r-c">
											
												<div class="cfgenwp-formconfig-r-l">
													
													<?php
													echo $cfgenwpapi_editor_obj->getServiceCredentialLabel($cfgenwp_api_service['id'], $cfgenwp_api_access_requirement_k);
													?>
													
													<?php
													echo $cfgenwpapi_editor_obj->getServiceCredentialHelp($cfgenwp_api_service['id'], $cfgenwp_api_access_requirement_k);
													?>
													
												</div>
												
												<div class="cfgenwp-formconfig-r-r">
													
													<?php
													$cfgenwp_hide_credential_input = false;
													
													if($cfgenwp_api_service['id'] === 'aweber' && current($cfgenwp_api_service['formconfig']['credentials'])){
														// we use current to check if the first credential key is not empty, which normally means all the other credentials are also not empty
														$cfgenwp_hide_credential_input = true;
														echo $cfgenwpapi_editor_obj->aweber['validauthorizationcode'];
													}
													
													$cfgenwp_credential_c_style = '';
													if($cfgenwp_hide_credential_input){
														$cfgenwp_credential_c_style = 'display:none;';
													}
													?>

													<div class="cfgenwp-api-credential-c" style="<?php echo $cfgenwp_credential_c_style;?>">
													<?php
													echo $cfgenwpapi_editor_obj->getServiceCredentialInput($cfgenwp_api_service['id'], $cfgenwp_api_access_requirement_k, $cfgenwp_service_input);
													?>
													</div>
													
												</div>
													
												<div class="cfgenwp-clear"></div>
													
											</div>
											<?php
										}
										?>
										
										<div class="cfgenwp-formconfig-r-c cfgenwp-integrate-api-c">
											
											<div class="cfgenwp-formconfig-r-l">
											&nbsp;
											</div>
											
											<div class="cfgenwp-formconfig-r-r">
												<span class="cfgenwp-integrate-api cfgenwp-button-small cfgenwp-button-blue">Integrate <?php echo $cfgenwp_api_service['name'];?><span class="cfgenwp-responsive-hide-inline"> with your form</span></span>
											</div>
											
											<div class="cfgenwp-clear"></div>
											
										</div>

									</div><!-- cfgenwp-editor-api-authentication -->

									
									<div class="cfgenwp-api-loading">
									Loading account information. It may take a few seconds.
									</div>

									<div class="cfgenwp-clear"></div>
				
									<div class="cfgenwp-api-user-accounts">
									</div>
									<?php
									} // if !$cfgenwp_api_works['status']
									?>
								</div><!-- cfgenwp-editor-api-builder -->
								
							</div><!-- cfgenwp-editor-api-c -->

							<?php
						}
						?>
					
					</div><!-- cfgenwp-formconfig-r -->
					
					<div class="cfgenwp-clear"></div>
					
				</div>

				
				<div class="cfgenwp-formconfig-separator"></div>
				
				<h3>Form validation message</h3>
				
				<?php
				$cfgenwp_config_redirecturl_checked = '';
				$cfgenwp_config_validationmessage_checked = $cfgenwp_editor_obj->checked;

				$cfgenwp_config_redirecturl_c_show = false;
				$cfgenwp_config_validationmessage_c_show = true;

				$cfgenwp_config_redirecturl_label_class = '';
				$cfgenwp_config_validationmessage_label_class = 'cfgenwp-option-selected';

				if(!empty($cfgenwp_form_load['config_redirecturl'])){
					$cfgenwp_config_redirecturl_checked = $cfgenwp_editor_obj->checked;
					$cfgenwp_config_validationmessage_checked = '';
					
					$cfgenwp_config_redirecturl_c_show = true;
					$cfgenwp_config_validationmessage_c_show = false;
					
					$cfgenwp_config_redirecturl_label_class = 'cfgenwp-option-selected';
					$cfgenwp_config_validationmessage_label_class = '';
				}
				?>


				<?php
				// FORM VALIDATION SELECT REDIRECT URL
				$tscfgenform_setting = new TsCfgenFormSetting();
				$tscfgenform_setting->setFormSettingValue('<input type="radio" '.$cfgenwp_config_redirecturl_checked.' id="cfgenwp-config-redirecturl-btn" name="cfgenwp-config-validationmessage-type-radio">'
														 .'<label for="cfgenwp-config-redirecturl-btn">'
														 .'<span class="cfgenwp-config-validationmessage-type-label '.$cfgenwp_config_redirecturl_label_class.'">Redirect the user to a specific url after he submits the form</span>'
														 .'</label>');
				$tscfgenform_setting->printFormSettingHtml();
				?>

				
				<?php
				// FORM VALIDATION SELECT SHOW CONFIRMATION MESSAGE
				$tscfgenform_setting = new TsCfgenFormSetting();
				$tscfgenform_setting->setFormSettingValue('<input type="radio" '.$cfgenwp_config_validationmessage_checked.' id="cfgenwp-config-validationmessage-btn" name="cfgenwp-config-validationmessage-type-radio">'
														 .'<label for="cfgenwp-config-validationmessage-btn">'
														 .'<span class="cfgenwp-config-validationmessage-type-label '.$cfgenwp_config_validationmessage_label_class.'">Show the confirmation message in the form page</span>'
														 .'</label>');
				$tscfgenform_setting->printFormSettingHtml();
				?>

				
				<?php
				// FORM VALIDATION SET REDIRECT URL
				$cfgenwp_config_redirect_url = !empty($cfgenwp_form_load['config_redirecturl']) ? $cfgenwp_form_load['config_redirecturl'] : '';
				
				$tscfgenform_setting = new TsCfgenFormSetting();
				if(!$cfgenwp_config_redirecturl_c_show) $tscfgenform_setting->setFormSettingHidden();
				$tscfgenform_setting->setFormSettingContainerHtmlClass('cfgenwp-config-redirecturl-c');
				$tscfgenform_setting->setFormSettingTitle('URL');
				$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-redirecturl-input');
				$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-config-redirecturl-input" value="'.$cfgenwp_editor_obj->htmlEntities($cfgenwp_config_redirect_url).'"><p>The user will be redirected to this URL after he submits the form<br>(don\'t forget to add the "http://" prefix)</p>');
				$tscfgenform_setting->printFormSettingHtml();
				?>
				
				
				<?php
				// FORM VALIDATION SET CONFIRMATION MESSAGE
				if(!empty($cfgenwp_form_load['config_validationmessage'])) $tscfgenform->setFormValidationMessage($cfgenwp_form_load['config_validationmessage']);
				
				$tscfgenform_setting = new TsCfgenFormSetting();
				if(!$cfgenwp_config_validationmessage_c_show) $tscfgenform_setting->setFormSettingHidden();
				$tscfgenform_setting->setFormSettingContainerHtmlClass('cfgenwp-config-validationmessage-c');
				$tscfgenform_setting->setFormSettingTitle('Message');
				$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-validationmessage-input');
				$tscfgenform_setting->setFormSettingValue('<textarea id="cfgenwp-config-validationmessage-input" rows="2" cols="40">'.$tscfgenform->getFormValidationMessage().'</textarea><p>This message will appear at the top of the form after the user submits the form</p>');
				$tscfgenform_setting->printFormSettingHtml();
				?>

				
				<div class="cfgenwp-formconfig-c cfgenwp-config-validationmessage-c" style="<?php echo $cfgenwp_config_validationmessage_c_show;?>">
				
					<div class="cfgenwp-formconfig-l">
						<label class="label-formconfiguration">Message color</label>
					</div>
					
					<div class="cfgenwp-formconfig-r">
						<?php
						$cfgenwp_formmessage_types = array('validation', 'error');
						
						$cfgenwp_formmessage_config = array();
						
						foreach($cfgenwp_formmessage_types as $cfgenwp_formmessage_type){
							
							$cfgenwp_formload_css_key = $cfgenwp_formmessage_type.'message';
							
							$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['type'] = $cfgenwp_formmessage_type;
							
							$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['object_type'] = 'formmessage'.$cfgenwp_formmessage_type;
							
							if(isset($cfgenwp_form_load['css'][$cfgenwp_formload_css_key])){
								$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['css'] = $cfgenwp_form_load['css'][$cfgenwp_formload_css_key]['default'];
							} else{
								$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['css'] = $cfgenwp_editor_obj->formmessage_style[$cfgenwp_formmessage_type];
							}
							
							$cfgenwp_formmessage_style_css_properties = array('font-family', 'font-size', 'font-weight', 'font-style', 'color', 'background-color', 'width');
							
							foreach($cfgenwp_formmessage_style_css_properties as $cfgenwp_formmessage_css_property_v){

								$cfgenwp_formmessage_css_property_value_key = str_replace('-', '', $cfgenwp_formmessage_css_property_v).'_value';
								
								$cfgenwp_getnumbersonly = (in_array($cfgenwp_formmessage_css_property_v, array('font-size', 'width'))) ? true : false;
								
								if(!empty($cfgenwp_form_load['css'][$cfgenwp_formload_css_key]['default'][$cfgenwp_formmessage_css_property_v])){
									$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config'][$cfgenwp_formmessage_css_property_value_key] = $cfgenwp_getnumbersonly 
																																					? $cfgenwp_editor_obj->getNumbersOnly($cfgenwp_form_load['css'][$cfgenwp_formload_css_key]['default'][$cfgenwp_formmessage_css_property_v]) 
																																					: $cfgenwp_form_load['css'][$cfgenwp_formload_css_key]['default'][$cfgenwp_formmessage_css_property_v];
								} else{
									$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config'][$cfgenwp_formmessage_css_property_value_key] = $cfgenwp_getnumbersonly 
																																					? $cfgenwp_editor_obj->getNumbersOnly($cfgenwp_editor_obj->formmessage_style[$cfgenwp_formmessage_type][$cfgenwp_formmessage_css_property_v]) 
																																					: $cfgenwp_editor_obj->formmessage_style[$cfgenwp_formmessage_type][$cfgenwp_formmessage_css_property_v];
								}
							}
						
							// FONT SIZE
							$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['fontsize_slider_id'] = 'cfgenwp-formmessage-'.$cfgenwp_formmessage_type.'-fontsize-slider';
							$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['fontsize_slider_target_id'] = 'cfgenwp-formmessage-'.$cfgenwp_formmessage_type.'-preview';
							
							// COLOR
							$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['color']['colorpicker_color'] = (isset($cfgenwp_form_load['css'][$cfgenwp_formload_css_key]['default']['color']) && $cfgenwp_form_load['css'][$cfgenwp_formload_css_key]['default']['color'])
																									 ? $cfgenwp_form_load['css'][$cfgenwp_formload_css_key]['default']['color']
																									 : $cfgenwp_editor_obj->formmessage_style[$cfgenwp_formmessage_type]['color'];
							$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['color']['colorpicker_input_id'] = 'cfgenwp-'.$cfgenwp_formload_css_key.'-color';
							$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['color']['colorpicker_target'] = '#cfgenwp-formmessage-'.$cfgenwp_formmessage_type.'-preview';
							$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['color']['colorpicker_csspropertyname'] = 'color';
							
							// BACKGROUND COLOR
							$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['background-color']['colorpicker_color'] = (isset($cfgenwp_form_load['css'][$cfgenwp_formload_css_key]['default']['background-color']) && $cfgenwp_form_load['css'][$cfgenwp_formload_css_key]['default']['background-color'])
																												 ? $cfgenwp_form_load['css'][$cfgenwp_formload_css_key]['default']['background-color']
																												 : $cfgenwp_editor_obj->formmessage_style[$cfgenwp_formmessage_type]['background-color'];
							$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['background-color']['colorpicker_input_id'] = 'cfgenwp-'.$cfgenwp_formload_css_key.'-backgroundcolor';
							$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['background-color']['colorpicker_target'] = '#cfgenwp-formmessage-'.$cfgenwp_formmessage_type.'-preview';
							$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['background-color']['colorpicker_csspropertyname'] = 'background-color';
							
							// WIDTH
							if($cfgenwp_formmessage_type == 'validation'){
								$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['width_slider_id'] = 'cfgenwp-'.$cfgenwp_formmessage_type.'-width-slider';
								$cfgenwp_formmessage_config[$cfgenwp_formmessage_type]['config']['width_slider_target_id'] = 'cfgenwp-formmessage-'.$cfgenwp_formmessage_type.'-preview';
							}
							
						}
						?>
						
						
						<div id="cfgenwp-formmessage-validation-preview" class="cfgenwp-formmessage-preview cfgen-validationmessage" style="<?php echo $cfgenwp_editor_obj->buildStyle($cfgenwp_formmessage_config['validation']['css'], array('margin'));?>">
						Validation message
						</div>

						<div>
							<span class="cfgenwp-a cfgenwp-formmessage-toggle-changeformat">Change colors and font style</span>
						</div>
						
						<div id="cfgenwp-formmessage-validation-style-c" class="cfgenwp-formmessage-changeformat-container" style="display:none">
							<div class="cfgenwp-e-editor-c">
								<?php
								$cfgenwp_editor_obj->editFormMessageStyle($cfgenwp_formmessage_config['validation']['config']);
								?>
							</div>
						</div>
						
					</div><!-- cfgenwp-formconfig-r -->
					
					<div class="cfgenwp-clear"></div>
					
				</div>
				
				
				<div id="cfgenwp-form-error-msgs-c" style="display:none">
					
					<div class="cfgenwp-formconfig-separator"></div>
					
					<h3>Form error messages</h3>
					<?php
					$cfgenwp_edit_form_error_messages = array(
															array(
																'label'=>'Invalid email address',
																'c_html_id'=>'cfgenwp-form-error-msg-email-c',
																'input_html_id'=>'cfgenwp-form-error-msg-email-value',
																'json_key'=>'config_errormessage_invalidemailaddress',
																'default_value'=>'Invalid email address',
																),
															array(
																'label'=>'Required field',
																'c_html_id'=>'cfgenwp-form-error-msg-required-c',
																'input_html_id'=>'cfgenwp-form-error-msg-required-value',
																'json_key'=>'config_errormessage_emptyfield',
																'default_value'=>'This field cannot be left blank',
																),
															array(
																'label'=>'Terms & Conditions',
																'c_html_id'=>'cfgenwp-form-error-msg-terms-c',
																'input_html_id'=>'cfgenwp-form-error-msg-terms-value',
																'json_key'=>'config_errormessage_terms',
																'default_value'=>'You must accept the terms and conditions',
																),
															array(
																'label'=>'Invalid URL',
																'c_html_id'=>'cfgenwp-form-error-msg-url-c',
																'input_html_id'=>'cfgenwp-form-error-msg-url-value',
																'json_key'=>'config_errormessage_invalidurl',
																'default_value'=>'Invalid URL',
																),
															array(
																'label'=>'Wrong captcha',
																'c_html_id'=>'cfgenwp-form-error-msg-captcha-c',
																'input_html_id'=>'cfgenwp-form-error-msg-captcha-value',
																'json_key'=>'config_errormessage_captcha',
																'default_value'=>'Incorrect captcha',
																),
															array(
																'label'=>'Upload : file size limit',
																'c_html_id'=>'cfgenwp-form-error-msg-uploadfilesize-c',
																'input_html_id'=>'cfgenwp-form-error-msg-uploadfilesize-value',
																'json_key'=>'config_errormessage_uploadfileistoobig',
																'default_value'=>'File size is too large',
																),
															array(
																'label'=>'Upload : invalid file type',
																'c_html_id'=>'cfgenwp-form-error-msg-uploadfiletype-c',
																'input_html_id'=>'cfgenwp-form-error-msg-uploadfiletype-value',
																'json_key'=>'config_errormessage_uploadinvalidfiletype',
																'default_value'=>'Unauthorized file type',
																),
														);
					foreach($cfgenwp_edit_form_error_messages as $cfgenwp_form_config_error_msg_v){
						$cfgenwp_error_msg_string = isset($cfgenwp_form_load[$cfgenwp_form_config_error_msg_v['json_key']]) ? $cfgenwp_form_load[$cfgenwp_form_config_error_msg_v['json_key']] : $cfgenwp_form_config_error_msg_v['default_value'];

						?>
						<div id="<?php echo $cfgenwp_form_config_error_msg_v['c_html_id'];?>" class="cfgenwp-form-error-msg-c" style="display:none">
						
							<div class="cfgenwp-formconfig-c">
							
								<div class="cfgenwp-formconfig-l">
									<label for="<?php echo $cfgenwp_form_config_error_msg_v['input_html_id'];?>"><?php echo $cfgenwp_form_config_error_msg_v['label'];?></label>
								</div>
								
								<div class="cfgenwp-formconfig-r">
									<input type="text" id="<?php echo $cfgenwp_form_config_error_msg_v['input_html_id'];?>" value="<?php echo $cfgenwp_editor_obj->htmlEntities($cfgenwp_error_msg_string);?>">
								</div>
								
								<div class="cfgenwp-clear"></div>
								
							</div>
							
						</div>
						
					<?php
					}
					?>
					
					<div class="cfgenwp-formconfig-c">
						
						<div class="cfgenwp-formconfig-l">
							<label class="label-formconfiguration">Message color</label>
						</div>
						
						<div class="cfgenwp-formconfig-r">

							<?php
							// There is a default width value for the error container when creating a new form, there is not when loading a form because the error container width autoadjust to the input width
							// For design purpose, the parameter below makes the setting appear with a fixed width instead of a 100% width
							$cfgenwp_formmessage_config['error']['css']['width'] = $cfgenwp_editor_obj->formmessage_style['error']['width'];
							?>
							<div id="cfgenwp-formmessage-error-preview" class="cfgenwp-formmessage-preview cfgen-errormessage" style="<?php echo $cfgenwp_editor_obj->buildStyle($cfgenwp_formmessage_config['error']['css'], array('margin'));?>; display:block;"><? /* display block to cancel display none in cfgen-errormessage */ ?>
							Error message
							</div>

							<div>
								<span class="cfgenwp-a cfgenwp-formmessage-toggle-changeformat">Change colors and font style</span>
							</div>
							
							<div id="cfgenwp-formmessage-error-style-c" class="cfgenwp-formmessage-changeformat-container" style="display:none">
								<div class="cfgenwp-e-editor-c">
									<?php
									$cfgenwp_editor_obj->editFormMessageStyle($cfgenwp_formmessage_config['error']['config']);
									?>
								</div>
							</div>
						
						</div>

						<div class="cfgenwp-clear"></div>

					</div>
					
				</div><!-- cfgenwp-form-error-msgs-c -->
				
				
				<div class="cfgenwp-formconfig-separator"></div>
				
				
				<div id="userinformationconfiguration" style="display:none">
				
					<h3>User information</h3>
					
					<?php
					// USER NOTIFICATION INPUT ID SELECT
					if(!empty($cfgenwp_form_load['config_database_login'])) $tscfgenform->setFormDatabaseLogin($cfgenwp_form_load['config_database_login']);
					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Recipient\'s email');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp_config_usernotification_inputid');
					$tscfgenform_setting->setFormSettingValue('<div id="notificationemailaddress"></div><p>This is the address that will appear in the "From" field of your notification message<br>The user notification message will also be sent to this address if delivery receipt is activated</p>');
					$tscfgenform_setting->printFormSettingHtml();
					?>

					<div class="cfgenwp-formconfig-separator"></div>
					
				</div>
				
				
				<h3>Notification message</h3>
				
				<?php
				// ADMIN NOTIFICATION HIDE EMPTY VALUES
				$cfgenwp_config_admin_notification_hideemptyvalues_checked = !empty($cfgenwp_form_load['config_adminnotification_hideemptyvalues']) ? $cfgenwp_editor_obj->checked : '';

				$tscfgenform_setting = new TsCfgenFormSetting();
				$tscfgenform_setting->setFormSettingValue('<input type="checkbox" id="cfgenwp-config-admin-notification-hideemptyvalues" value="" '.$cfgenwp_config_admin_notification_hideemptyvalues_checked.'>'
																 .'<label for="cfgenwp-config-admin-notification-hideemptyvalues">Hide empty fields and empty values in the admin notification message</label>');
				$tscfgenform_setting->printFormSettingHtml();
				?>
				
				<?php
				// ADMIN NOTIFICATION HIDE FORM URL
				$cfgenwp_config_admin_notification_hideformurl_checked = $cfgenwp_editor_obj->checked;
				
				if(isset($cfgenwp_form_load['config_adminnotification_hideformurl'])){
					$cfgenwp_config_admin_notification_hideformurl_checked = $cfgenwp_form_load['config_adminnotification_hideformurl'] ? $cfgenwp_editor_obj->checked : '';
				}

				$tscfgenform_setting = new TsCfgenFormSetting();
				$tscfgenform_setting->setFormSettingValue('<input type="checkbox" id="cfgenwp-config-admin-notification-hideformurl" value="" '.$cfgenwp_config_admin_notification_hideformurl_checked.'>'
																 .'<label for="cfgenwp-config-admin-notification-hideformurl">Hide the form URL in the admin notification message (may prevent the message from landing in the spam folder)</label>');
				$tscfgenform_setting->printFormSettingHtml();
				?>
				
				<div class="cfgenwp-formconfig-separator"></div>
				
				<h3>SMS notification</h3>
				
				<?php
				// SMS ACTIVATE FLAG
				$cfgenwp_config_sms_admin_notification_activate_checked = !empty($cfgenwp_form_load['config_sms_admin_notification_gateway_id']) ? $cfgenwp_editor_obj->checked : '';
				?>
				
				
				<?php
				// SMS ACTIVATE CHECKBOX
				$tscfgenform_setting = new TsCfgenFormSetting();
				$tscfgenform_setting->setFormSettingValue('<input type="checkbox" id="cfgenwp-sms-admin-notification-activate" '.$cfgenwp_config_sms_admin_notification_activate_checked.'>'	
														 .'<label for="cfgenwp-sms-admin-notification-activate">Activate SMS notification</label>');
				$tscfgenform_setting->printFormSettingHtml();
				?>
					
				<div id="cfgenwp-sms-admin-notification-c" style="<?php echo !$cfgenwp_config_sms_admin_notification_activate_checked ? 'display:none' : '';?>">
					
					<?php
					// SMS PHONE NUMBER
					$cfgenwp_config_sms_admin_notification_to_phone_number = !empty($cfgenwp_form_load['config_sms_admin_notification_to_phone_number']) ? $cfgenwp_form_load['config_sms_admin_notification_to_phone_number'] : '';
						
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Your phone number');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-sms-admin-notification-to-phone-number');
					$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-sms-admin-notification-to-phone-number" placeholder="Insert numbers only" value="'.$cfgenwp_editor_obj->htmlEntities($cfgenwp_config_sms_admin_notification_to_phone_number).'"><p>The SMS will be sent to this phone number, the country code prefix is required</p>');
					$tscfgenform_setting->printFormSettingHtml();
					?>
					
					<?php
					// SMS MESSAGE
					$cfgenwp_config_sms_admin_notification_message = !empty($cfgenwp_form_load['config_sms_admin_notification_message']) ? $cfgenwp_form_load['config_sms_admin_notification_message'] : '';
						
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Message');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-sms-admin-notification-message');
					$tscfgenform_setting->setFormSettingValue('<textarea id="cfgenwp-sms-admin-notification-message" class="cfgenwp-target-insertfieldvalue" rows="4" cols="40">'.$cfgenwp_config_sms_admin_notification_message.'</textarea>'
															 .'<select class="cfgenwp-insertfieldvalue"></select>');
					$tscfgenform_setting->printFormSettingHtml();
					?>
				
				
					<?php
					// SMS GATEWAY
					$cfgenwp_config_sms_admin_notification_gateway = !empty($cfgenwp_form_load['config_sms_admin_notification_gateway_id']) ? $cfgenwp_form_load['config_sms_admin_notification_gateway_id'] : '';

					$cfgenwp_sms_gateway_collection = array(
															array('id'=>'clickatell', 'label'=>'Click A Tell'),
															array('id'=>'twilio', 'label'=>'Twilio')
															);

					$cfgenwp_sms_gateway_select = '<select class="cfgenwp-config-credentials" id="cfgenwp-sms-admin-notification-gateway">';
					$cfgenwp_sms_gateway_select .= '<option value="">Select your SMS gateway</option>';
						
					foreach($cfgenwp_sms_gateway_collection as $cfgenwp_sms_gateway_collection_k=>$cfgenwp_sms_gateway_collection_v){

						$cfgenwp_sms_admin_notification_gateway_selected = $cfgenwp_sms_gateway_collection_v['id'] === $cfgenwp_config_sms_admin_notification_gateway ? $cfgenwp_editor_obj->selected : '';
						
						$cfgenwp_sms_gateway_select .= '<option value="'.$cfgenwp_sms_gateway_collection_v['id'].'" '.$cfgenwp_sms_admin_notification_gateway_selected.'>'.$cfgenwp_sms_gateway_collection_v['label'].'</option>';
					}
					
					$cfgenwp_sms_gateway_select .= '</select>';

					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('SMS gateway');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-sms-admin-notification-gateway');
					$tscfgenform_setting->setFormSettingValue($cfgenwp_sms_gateway_select);
					$tscfgenform_setting->printFormSettingHtml();
					?>
				
					<div class="cfgenwp-sms-admin-notification-gateway-config" data-cfgenwp_sms_gateway_id="clickatell" style="<?php echo ($cfgenwp_config_sms_admin_notification_gateway === 'clickatell' ? 'display:block' : 'display:none'); ?>">

						<?php
						// CLICKATELL USERNAME
						$cfgenwp_config_sms_admin_notification_clickatell_username = !empty($cfgenwp_form_load['config_sms_admin_notification_username']) ? $cfgenwp_form_load['config_sms_admin_notification_username'] : '';
							
						$tscfgenform_setting = new TsCfgenFormSetting();
						$tscfgenform_setting->setFormSettingTitle('Clickatell username');
						$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-sms-admin-notification-clickatell-username');
						$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-sms-admin-notification-clickatell-username" value="'.$cfgenwp_editor_obj->htmlEntities($cfgenwp_config_sms_admin_notification_clickatell_username).'">');
						$tscfgenform_setting->printFormSettingHtml();
						?>


						<?php
						// CLICKATELL PASSWORD
						$cfgenwp_config_sms_admin_notification_clickatell_password = !empty($cfgenwp_form_load['config_sms_admin_notification_password']) ? $cfgenwp_form_load['config_sms_admin_notification_password'] : '';

						$tscfgenform_setting = new TsCfgenFormSetting();
						$tscfgenform_setting->setFormSettingTitle('Clickatell password');
						$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-sms-admin-notification-clickatell-password');
						$tscfgenform_setting->setFormSettingValue('<input type="password" id="cfgenwp-sms-admin-notification-clickatell-password" value="'.$cfgenwp_editor_obj->htmlEntities($cfgenwp_config_sms_admin_notification_clickatell_password).'">');
						$tscfgenform_setting->printFormSettingHtml();
						?>

						
						<?php
						// CLICKATELL API ID
						$cfgenwp_config_sms_admin_notification_clickatell_api_id = !empty($cfgenwp_form_load['config_sms_admin_notification_api_id']) ? $cfgenwp_form_load['config_sms_admin_notification_api_id'] : '';

						$tscfgenform_setting = new TsCfgenFormSetting();
						$tscfgenform_setting->setFormSettingTitle('Clickatell HTTP API id');
						$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-sms-admin-notification-clickatell-api_id');
						$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-sms-admin-notification-clickatell-api_id" value="'.$cfgenwp_editor_obj->htmlEntities($cfgenwp_config_sms_admin_notification_clickatell_api_id).'">');
						$tscfgenform_setting->printFormSettingHtml();
						?>

					</div>

					<div class="cfgenwp-sms-admin-notification-gateway-config" data-cfgenwp_sms_gateway_id="twilio" style="<?php echo ($cfgenwp_config_sms_admin_notification_gateway === 'twilio' ? 'display:block' : 'display:none'); ?>">
					
						<?php
						// TWILIO FROM NUMBER
						$cfgenwp_config_sms_admin_notification_from_phone_number = !empty($cfgenwp_form_load['config_sms_admin_notification_from_phone_number']) ? $cfgenwp_form_load['config_sms_admin_notification_from_phone_number'] : '';

						$tscfgenform_setting = new TsCfgenFormSetting();
						$tscfgenform_setting->setFormSettingTitle('Twilio "From" number');
						$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-sms-admin-notification-twilio-from_phone_number');
						$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-sms-admin-notification-twilio-from_phone_number" placeholder="Insert numbers only" value="'.$cfgenwp_editor_obj->htmlEntities($cfgenwp_config_sms_admin_notification_from_phone_number).'">');
						$tscfgenform_setting->printFormSettingHtml();
						?>
					
						<?php
						// TWILIO ACCOUNT SID
						$cfgenwp_config_sms_admin_notification_twilio_account_sid = !empty($cfgenwp_form_load['config_sms_admin_notification_account_sid']) ? $cfgenwp_form_load['config_sms_admin_notification_account_sid'] : '';

						$tscfgenform_setting = new TsCfgenFormSetting();
						$tscfgenform_setting->setFormSettingTitle('Twilio account SID');
						$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-sms-admin-notification-twilio-account_sid');
						$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-sms-admin-notification-twilio-account_sid" value="'.$cfgenwp_editor_obj->htmlEntities($cfgenwp_config_sms_admin_notification_twilio_account_sid).'">');
						$tscfgenform_setting->printFormSettingHtml();
						?>


						<?php
						// TWILIO ACCOUNT TOKEN
						$cfgenwp_config_sms_admin_notification_twilio_auth_token = !empty($cfgenwp_form_load['config_sms_admin_notification_auth_token']) ? $cfgenwp_form_load['config_sms_admin_notification_auth_token'] : '';
						
						$tscfgenform_setting = new TsCfgenFormSetting();
						$tscfgenform_setting->setFormSettingTitle('Twilio auth token');
						$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-sms-admin-notification-twilio-auth_token');
						$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-sms-admin-notification-twilio-auth_token" value="'.$cfgenwp_editor_obj->htmlEntities($cfgenwp_config_sms_admin_notification_twilio_auth_token).'">');
						$tscfgenform_setting->printFormSettingHtml();
						?>
						
					</div>
					
				</div><!-- cfgenwp-sms-admin-notification-c -->

				<div class="cfgenwp-formconfig-separator"></div>
				
				
				<h3>Autoresponder</h3>
				
				<?php
				// ACTIVATE DELIVERY RECEIPT
				$cfgenwp_config_user_notification_activate_checked = '';
				$cfgenwp_config_deliveryreceipt_c_style = 'display:none';
				
				if(!empty($cfgenwp_form_load['config_usernotification_activate'])){
					$cfgenwp_config_user_notification_activate_checked = $cfgenwp_editor_obj->checked;
					$cfgenwp_config_deliveryreceipt_c_style = '';			
				}
				
				$tscfgenform_setting = new TsCfgenFormSetting();
				$tscfgenform_setting->setFormSettingValue('<input type="checkbox" id="cfgenwp-config-user-notification-activate" value="" '.$cfgenwp_config_user_notification_activate_checked.'>'
														 .'<label for="cfgenwp-config-user-notification-activate">Activate delivery receipt: notify the user by email that his message has been sent to you</label>');
				$tscfgenform_setting->printFormSettingHtml();
				?>
				
				
				<div id="deliveryreceiptconfiguration" style=" <?php echo $cfgenwp_config_deliveryreceipt_c_style?>">

					<?php
					// USER NOTIFICATION INSERT DATA
					$cfgenwp_config_user_notification_insertformdata_checked = !empty($cfgenwp_form_load['config_usernotification_insertformdata']) ? $cfgenwp_editor_obj->checked : '';
					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingValue('<input type="checkbox" id="cfgenwp-config-user-notification-insertformdata" value="" '.$cfgenwp_config_user_notification_insertformdata_checked.'>'
															 .'<label for="cfgenwp-config-user-notification-insertformdata">Insert a copy of the form data in the user notification message</label>');
					$tscfgenform_setting->printFormSettingHtml();
					?>
					
					
					<?php
					// USER NOTIFICATION HIDE EMPTY VALUES
					$cfgenwp_usernotification_hideemptyvalue_checked = !empty($cfgenwp_form_load['config_usernotification_hideemptyvalues']) ? $cfgenwp_editor_obj->checked : '';
					$tscfgenform_setting = new TsCfgenFormSetting();
					if(!$cfgenwp_config_user_notification_insertformdata_checked) $tscfgenform_setting->setFormSettingHidden();
					$tscfgenform_setting->setFormSettingContainerHtmlId('cfgenwp_usernotification_hideemptyvalues_c');
					$tscfgenform_setting->setFormSettingValue('<input type="checkbox" id="cfgenwp-config-user-notification-hideemptyvalues" value="" '.$cfgenwp_usernotification_hideemptyvalue_checked.'>'
															 .'<label for="cfgenwp-config-user-notification-hideemptyvalues">Hide blank fields and empty values in the user notification message</label>');
					$tscfgenform_setting->printFormSettingHtml();
					?>
					
					
					<?php
					// AT LEAST ONE EMAIL FIELD IS REQUIRED
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingHidden();
					$tscfgenform_setting->setFormSettingContainerHtmlId('cfgenwp-atleastonemailfield');
					$tscfgenform_setting->setFormSettingValue('<p style="color:#ff0000; font-style:normal;">You must add at least one email field in the form to activate email notification</p>');
					$tscfgenform_setting->printFormSettingHtml();
					?>
					
					
					<?php
					// USER NOTIFICATION FROM FIELD
					if(!empty($cfgenwp_form_load['config_email_from'])) $tscfgenform->setFormEmailFrom($cfgenwp_form_load['config_email_from']);
					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Name in inbox "From" field');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-email-from');
					$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-config-email-from" value="'.$cfgenwp_editor_obj->htmlEntities($tscfgenform->getFormEmailFrom()).'"><p>This is the name that will be displayed in the user\'s inbox "From" field<br>If left blank, your email address will be displayed instead</p>');
					$tscfgenform_setting->printFormSettingHtml();
					?>


					<div class="cfgenwp-formconfig-c">
					
						<div class="cfgenwp-formconfig-l cfgenwp-formconfig-l-onelinefix">
							<label class="label-formconfiguration">Notification message format</label>
						</div>
						
						<div class="cfgenwp-formconfig-r cfgenwp-formconfig-r-onelinefix">
						<?php
						$cfgenwp_notification_format_list = array(
																array('format_name'=>'Plain Text', 'format_value'=>'plaintext'), 
																array('format_name'=>'HTML', 'format_value'=>'html')
																);
						
						
						$default_notification_format_list = !empty($cfgenwp_form_load['config_usernotification_format']) ? $cfgenwp_form_load['config_usernotification_format'] : 'plaintext';
						
						
						foreach($cfgenwp_notification_format_list as $cfgenwp_notification_format_list){
							
							${'checked_notification_format_'.$cfgenwp_notification_format_list['format_value']} = '';
							
							if($default_notification_format_list == $cfgenwp_notification_format_list['format_value']){
								${'checked_notification_format_'.$cfgenwp_notification_format_list['format_value']} = $cfgenwp_editor_obj->checked;
							}
							?>
							
							<input type="radio" name="cfgenwp-config-user-notification-format" id="cfgenwp-config-user-notification-format-<?php echo $cfgenwp_notification_format_list['format_value'];?>" value="<?php echo $cfgenwp_notification_format_list['format_value'];?>" <?php echo ${'checked_notification_format_'.$cfgenwp_notification_format_list['format_value']};?>><label for="cfgenwp-config-user-notification-format-<?php echo $cfgenwp_notification_format_list['format_value'];?>"><?php echo $cfgenwp_notification_format_list['format_name'];?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php
						}
						?>
						
						</div>
						<div class="cfgenwp-clear"></div>
						
					</div>
				
				
					<?php
					// USER NOTIFICATION SUBJECT
					if(isset($cfgenwp_form_load['config_usernotification_subject'])) $tscfgenform->setFormUserNotificationSubject($cfgenwp_form_load['config_usernotification_subject']);
					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Notification subject line');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-user-notification-subject');
					$tscfgenform_setting->setFormSettingValue('<input type="text" class="cfgenwp-target-insertfieldvalue" id="cfgenwp-config-user-notification-subject" value="'.$cfgenwp_editor_obj->htmlEntities($tscfgenform->getFormUserNotificationSubject()).'">'
															 .'<select class="cfgenwp-insertfieldvalue"></select>');
					$tscfgenform_setting->printFormSettingHtml();
					?>

					
					<?php
					// USER NOTIFICATION BODY
					if(isset($cfgenwp_form_load['config_usernotification_message'])) $tscfgenform->setFormUserNotificationMessage($cfgenwp_form_load['config_usernotification_message']);
					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('Notification message');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-user-notification-message');
					$tscfgenform_setting->setFormSettingValue('<textarea class="cfgenwp-target-insertfieldvalue" id="cfgenwp-config-user-notification-message" rows="4" cols="40">'.$tscfgenform->getFormUserNotificationMessage().'</textarea>'
															 .'<select class="cfgenwp-insertfieldvalue"></select>');
					$tscfgenform_setting->printFormSettingHtml();
					?>
					
					
				</div><!-- deliveryreceiptconfiguration -->

				<div class="cfgenwp-formconfig-separator"></div>

				
				<h3>Email sending method</h3>

				<?php
				// EMAIL SENDING METHOD
				$cfgenwp_smtpconfiguration_container_style = 'display:none';
				
				if(isset($cfgenwp_form_load['config_emailsendingmethod']) && $cfgenwp_form_load['config_emailsendingmethod'] === 'smtp'){
					$tscfgenform->setFormEmailSendingMethod($cfgenwp_form_load['config_emailsendingmethod']);
					$cfgenwp_smtpconfiguration_container_style = '';			
				}

				$cfgenwp_configrow_email_sending_method_select = '<select id="cfgenwp-config-emailsendingmethod" class="cfgenwp-formsettings-select cfgenwp-config-credentials">';

				foreach(array('php'=>'PHP mail( )', 'smtp'=>'SMTP') as $cfgenwp_emailsendingmethods_key=>$cfgenwp_emailsendingmethods_value){

					$cfgenwp_selected_emailsendingmethod = ($tscfgenform->getFormEmailSendingMethod() == $cfgenwp_emailsendingmethods_key) ? $cfgenwp_editor_obj->selected : '';

					$cfgenwp_configrow_email_sending_method_select .= '<option '.$cfgenwp_selected_emailsendingmethod.' value="'.$cfgenwp_emailsendingmethods_key.'">'.$cfgenwp_emailsendingmethods_value.'</option>';
				}
				
				$cfgenwp_configrow_email_sending_method_select .= '</select>';
				
				
				if(isset($cfgenwp_form_load['config_usernotification_message'])) $tscfgenform->setFormUserNotificationMessage($cfgenwp_form_load['config_usernotification_message']);

				$tscfgenform_setting = new TsCfgenFormSetting();
				$tscfgenform_setting->setFormSettingTitle('Delivery method');
				$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-config-emailsendingmethod');
				$tscfgenform_setting->setFormSettingValue($cfgenwp_configrow_email_sending_method_select);
				$tscfgenform_setting->printFormSettingHtml();
				
				?>


				<div id="cfgenwp-smtpconfiguration-c" style=" <?php echo $cfgenwp_smtpconfiguration_container_style; ?>">
					
					<?php
					// SMTP HOST
					$tscfgenform->setFormSMTPHost(isset($cfg['smtp_host']) ? $cfg['smtp_host'] : (!empty($cfgenwp_config['smtp']['host']) ? $cfgenwp_config['smtp']['host'] : ''));
					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('SMTP Host');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-smtp-host');
					$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-smtp-host" class="cfgenwp-config-credentials" value="'.$cfgenwp_editor_obj->htmlEntities($tscfgenform->getFormSMTPHost()).'">');
					$tscfgenform_setting->printFormSettingHtml();
					?>
					

					<?php
					// SMTP PORT
					$tscfgenform->setFormSMTPPort(isset($cfg['smtp_port']) ? $cfg['smtp_port'] : (!empty($cfgenwp_config['smtp']['port']) ? $cfgenwp_config['smtp']['port'] : ''));
					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('SMTP Port');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-smtp-port');
					$tscfgenform_setting->setFormSettingValue('<input type="text" id="cfgenwp-smtp-port" class="cfgenwp-config-credentials" value="'.$cfgenwp_editor_obj->htmlEntities($tscfgenform->getFormSMTPPort()).'">');
					$tscfgenform_setting->printFormSettingHtml();
					?>
					
					
					<?php
					// SMTP ENCRYPTION
					$tscfgenform->setFormSMTPEncryption(isset($cfg['smtp_encryption']) ? $cfg['smtp_encryption'] : (!empty($cfgenwp_config['smtp']['encryption']) ? $cfgenwp_config['smtp']['encryption'] : ''));
					
					$cfgenwp_smtpencryptionmethods = array(''=>'No encryption', 'ssl'=>'Use SSL encryption', 'tls'=>'Use TLS encryption');
					
					$cfgenwp_config_smtp_encryption_select = '<select id="cfgenwp-smtp-encryption" class="cfgenwp-config-credentials">';
					
					foreach($cfgenwp_smtpencryptionmethods as $cfgenwp_smtpencryptionmethods_key=>$cfgenwp_smtpencryptionmethods_value){
						
						$cfgenwp_selected_smtpencryptionmethod = '';
						
						if($tscfgenform->getFormSMTPEncryption() == $cfgenwp_smtpencryptionmethods_key){
						   $cfgenwp_selected_smtpencryptionmethod = $cfgenwp_editor_obj->selected;
						}
						
						$cfgenwp_config_smtp_encryption_select .= '<option '.$cfgenwp_selected_smtpencryptionmethod.' value="'.$cfgenwp_smtpencryptionmethods_key.'">'.$cfgenwp_smtpencryptionmethods_value.'</option>';
					}
					
					$cfgenwp_config_smtp_encryption_select .= '</select>';

					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('SMTP Encryption');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-smtp-encryption');
					$tscfgenform_setting->setFormSettingValue($cfgenwp_config_smtp_encryption_select);
					$tscfgenform_setting->printFormSettingHtml();
					?>
					
					
					<?php
					// SMTP USERNAME
					$tscfgenform->setFormSMTPUsername(isset($cfg['smtp_username']) ? $cfg['smtp_username'] : (!empty($cfgenwp_config['smtp']['username']) ? $cfgenwp_config['smtp']['username'] : ''));
					
					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('SMTP Username');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-smtp-username');
					$tscfgenform_setting->setFormSettingValue('<input type="text" autocomplete="off" id="cfgenwp-smtp-username" class="cfgenwp-config-credentials" value="'.$cfgenwp_editor_obj->htmlEntities($tscfgenform->getFormSMTPUsername()).'">');
					$tscfgenform_setting->printFormSettingHtml();
					?>
					
					
					<?php
					// SMTP PASSWORD
					$tscfgenform->setFormSMTPPassword(isset($cfg['smtp_password']) ? $cfg['smtp_password'] : (!empty($cfgenwp_config['smtp']['password']) ? $cfgenwp_config['smtp']['password'] : ''));

					$tscfgenform_setting = new TsCfgenFormSetting();
					$tscfgenform_setting->setFormSettingTitle('SMTP Password');
					$tscfgenform_setting->setFormSettingLabelFor('cfgenwp-smtp-password');
					$tscfgenform_setting->setFormSettingValue('<input type="password" autocomplete="off" id="cfgenwp-smtp-password" class="cfgenwp-config-credentials" value="'.$cfgenwp_editor_obj->htmlEntities($tscfgenform->getFormSMTPPassword()).'">');
					$tscfgenform_setting->printFormSettingHtml();
					?>
					
				</div><!-- cfgenwp-smtpconfiguration-c -->
 


 
			<h3>Embeded Code</h3>
				<div class='cfg-simple-embeded-code' id='cfg-simple-embeded-code' >
					<?php 
						if(!empty($id )) {

							print htmlspecialchars('<iframe width="560" height="560" src=" '. $formController->getSimpleEmbedded($_GET['id']) .  '" frameborder="0" ></iframe>');
							 
						} else {
							print "Will generate after saved and published form..";
						}
					 ?>
				</div>
				
				<h2>Ready? Create your form!</h2>

				<div id="cfgenwp-notice-savevalidation" class="cfgenwp-aftersave">
					Your form is ready!
				</div> 
				<div id="downloadsources"></div> 
				<div>
				
					<span id="cfgenwp-notice-loadinglists" class="cfgenwp-savenotice cfgenwp-button-position">Your lists are loading. The save button will reappear as soon as everything is loaded.</span>
					<span id="cfgenwp-notice-savingform" class="cfgenwp-savenotice cfgenwp-button-position">Creating source files</span><span id="cfgenwp-saveform" class="cfgenwp-button cfgenwp-button-blue cfgenwp-button-position">Save and create source files</span><span id="cfgenwp-returntoformedition" class="cfgenwp-button cfgenwp-button-position cfgenwp-button-grey">Return to the form</span>
					
					<img id="cfgenwp-scrolltotop" src="img/scrolltotop.png" id="cfgenwp-scrolltotop">
					
					<div class="cfgenwp-clear"></div>

				</div>
				
			</div>

		</div><!-- cfgenwp-fb-c -->
	
	</div><!-- cfgenwp-formbuilder-r -->
	
	<div class="cfgenwp-clear"></div>

	<?php
	if($contactform_obj->demo != 1){?>

		<div id="footer">
			
			<p><span class="footer-section">Contact Form Generator:</span> <a href="<?php echo $cfgenwp_editor_obj->url_envato_formgenerator_item;?>" target="_blank">Download the latest version</a></p>
			
			<p><span class="footer-section">Help and support:</span> <a href="<?php echo $cfgenwp_editor_obj->url_envato_formgenerator_support;?>" target="_blank">Contact TopStudio Support</a></p>
			
			<p><span class="footer-section">Top Studio website:</span> <a href="http://www.topstudiodev.com" target="_blank">TopStudioDev.com</a></p>
			
		</div>
		
		<?php
	}
	?>

</div><!-- cfgenwp-formbuilder-container -->


	<div id="copyright">
	© <?php echo @date('Y');?> <a href="http://www.topstudiodev.com" target="_blank" class="cfgenwp-a-text">Send Right</a>
	</div>

</div><!-- cfgenwp-formbuilder-wrap -->


<div id="cfgenwp-dialog-message"></div>




<script src="js/contactformeditor.js"></script>
<script src="js/swfupload/swfupload.js"></script>


<script>
var cfgenwp_isinput_list = ['<?php echo implode("','", $cfgenwp_editor_obj->isinput_list);?>']; // used to check if the form contains at least one input, used to check if the element can be put in active/inactive columns

var cfgenwp_editor_cfg = {};

var cfg_php_safe_mode = '<?php echo (ini_get('safe_mode') ? 1 : '');?>';

var dir_form_inc = '<?php echo $cfgenwp_editor_obj->dir_form_inc;?>';


<?php
if(!$form_id_exist){?>
jQuery(function(){jQuery('#cfgenwp-gotoformconfiguration').hide()});
<?php
}

if($json_load_form_setup){
	foreach($json_load_form_setup as $load_form_element){?>
elements.push(<?php echo json_encode($load_form_element);?>);<?php
	echo "\r\n";
	}
	
	if(!empty($cfgenwp_form_load['config_database_table_fields'])){?>
	jQuery(function(){
		var cfgen_database_builder_elements = <?php echo json_encode($cfgenwp_form_load['config_database_table_fields']);?>;
		jQuery('#cfgenwp-database-builder').cfgen_addToDatabaseBuilder(cfgen_database_builder_elements, true);
	});
		<?php
	}
}
?>

<?php
if($cfgenwp_form_load){
	// If a form is loaded, the form id is appended to the element name prefix
	// element name prefix is used to target the date field when changing the datepicker format or datepicker language
	// the "if" test is not done on $loaded_form_json_key alone because $loaded_form_json_key can equals 0 for the first form and the test would return false even if a form is loaded
	?>
var cfgenwp_element_name_prefix = '<?php echo $cfgenwp_editor_obj->element_name_prefix.$cfgenwp_form_load['form_id'].'-';?>';<?php
} else{?>
var cfgenwp_element_name_prefix = '<?php echo $cfgenwp_editor_obj->element_name_prefix;?>';<?php
}
?>


<?php
$addoptioncontainer_style = !empty($cfgenwp_form_load['css']['input']['default']) ? array('css'=>$cfgenwp_form_load['css']['input']) : '';
// ^-- background, border-radius, etc. are filtered in addOptionContainer()
?>

<?php
$cfgenwp_html_fontweight_options = '';
foreach($cfgenwp_editor_obj->fontweight_list as $cfgenwp_fontweight_v){
	$cfgenwp_html_fontweight_options .= $cfgenwp_editor_obj->buildSelectOption($cfgenwp_fontweight_v, $cfgenwp_fontweight_v, '');
}
?>
var cfgenwp_html_fontweight_options = '<?php echo $cfgenwp_html_fontweight_options;?>';

<?php
$cfgenwp_html_fontstyle_options = '';
foreach($cfgenwp_editor_obj->fontstyle_list as $cfgenwp_fontstyle_v){
	$cfgenwp_html_fontstyle_options .= $cfgenwp_editor_obj->buildSelectOption($cfgenwp_fontstyle_v, $cfgenwp_fontstyle_v, '');
}
?>
var cfgenwp_html_fontstyle_options = '<?php echo $cfgenwp_html_fontstyle_options;?>';

<?php
$js_config_usernotification_inputid = '';
if(!empty($cfgenwp_form_load['config_usernotification_inputid'])){
	$explode_config_usernotification_inputid = explode('-', $cfgenwp_form_load['config_usernotification_inputid']);
	$js_config_usernotification_inputid = end($explode_config_usernotification_inputid);
}
?>
var js_config_usernotification_inputid = '<?php echo $js_config_usernotification_inputid;?>';
// ^-- used in cfgenwp_buildSelectNotificationEmailAddress to preselect the correct email field in the user notification message configuration

<?php
/*
 * addcslashes for html_optioncheckboxcontainer and html_optionradiocontainer
 * to prevent javascript errors because of font families with single quotes
 * without addslashes: font-family:'Trebuchet MS' => error
 * with addslashes: font-family:\'Trebuchet MS\' => ok
 */
?>
cfgenwp_unique_hash_form_editor = '<?php echo (!empty($cfgenwp_form_load['form_id'])) ? sha1($cfgenwp_form_load['form_id']) : sha1(microtime());?>';
var html_optioncheckboxcontainer = '<?php echo addcslashes($cfgenwp_editor_obj->addOptionContainer(array('type'=>'checkbox', 'option'=>array('set'=>array(0=>array('value'=>$cfgenwp_editor_obj->newoption_default_value)), 'container'=>$addoptioncontainer_style)), true, false, false), "'" );?>';
var html_editoptioncheckboxcontainer = '<?php echo $cfgenwp_editor_obj->divEditOptionContainer('checkbox', $cfgenwp_editor_obj->newoption_default_value, '');?>';

var html_optionradiocontainer = '<?php echo addcslashes($cfgenwp_editor_obj->addOptionContainer(array('type'=>'radio', 'option'=>array('set'=>array(0=>array('value'=>$cfgenwp_editor_obj->newoption_default_value)), 'container'=>$addoptioncontainer_style)), true, false, false), "'" );?>';
var html_editoptionradiocontainer = '<?php echo $cfgenwp_editor_obj->divEditOptionContainer('radio', $cfgenwp_editor_obj->newoption_default_value, '');?>';

var cfgenwp_html_icon = '<?php echo $cfgenwp_editor_obj->htmlIcon(array('icon_c_style'=>'style="'.$cfgenwp_editor_obj->icon_style.'"'));?>';

var html_selectoption = '<?php echo $cfgenwp_editor_obj->htmlSelectOption();?>';
var html_editselectoptioncontainer = '<?php echo $cfgenwp_editor_obj->divEditOptionContainer('select', $cfgenwp_editor_obj->newoption_default_value, '');?>';
var html_editselectmultipleoptioncontainer = '<?php echo $cfgenwp_editor_obj->divEditOptionContainer('selectmultiple', $cfgenwp_editor_obj->newoption_default_value, '');?>';
var cfgenwp_html_empty_image_container = '<?php echo $cfgenwp_editor_obj->html_empty_image_container;?>';
var contactformgenerator_dir_upload = '<?php echo $cfgenwp_editor_obj->dir_upload;?>';
cfgenwp_editor_cfg['slider_fontsize_min'] = <?php echo $cfgenwp_editor_obj->slider_fontsize_min;?>;
cfgenwp_editor_cfg['slider_fontsize_max'] = <?php echo $cfgenwp_editor_obj->slider_fontsize_max;?>;
cfgenwp_editor_cfg['slider_fontsize_step'] = <?php echo $cfgenwp_editor_obj->slider_fontsize_step;?>;
cfgenwp_label_align_left_width = '<?php echo $cfgenwp_editor_obj->label_align_left_width;?>';


var cfgenwp_css_properties = jQuery.parseJSON('<?php echo json_encode($cfgenwp_editor_obj->css_properties_initialization);?>');

<?php
if(!empty($cfgenwp_form_load['css']['label']['default'])){?>
cfgenwp_css_properties['label'] = jQuery.parseJSON('<?php echo (json_encode($cfgenwp_form_load['css']['label']));?>');
<?php } ?>

<?php
if(!empty($cfgenwp_form_load['css']['input']['default'])){?>
cfgenwp_css_properties['input'] = jQuery.parseJSON('<?php echo (json_encode($cfgenwp_form_load['css']['input']));?>');
<?php } ?>

<?php
if(!empty($cfgenwp_form_load['css']['paragraph']['default'])){?>
cfgenwp_css_properties['paragraph'] = jQuery.parseJSON('<?php echo (json_encode($cfgenwp_form_load['css']['paragraph']));?>');
cfgenwp_css_properties['paragraph']['default']['width'] = '<?php echo $cfgenwp_editor_obj->getCssPropertyDefaultValue('paragraph', 'width');?>';
<?php } ?>

<?php
if(!empty($cfgenwp_form_load['css']['title']['default'])){?>
cfgenwp_css_properties['title'] = jQuery.parseJSON('<?php echo (json_encode($cfgenwp_form_load['css']['title']));?>');
<?php } ?>

//console.log(cfgenwp_css_properties);

<?php if($contactform_obj->demo != 1){if(!isset($_SESSION['user']) || !$_SESSION['user']){exit;}}?>
</script>

</body>

</html>