<?php
/**********************************************************************************
 * Contact Form Generator is (c) Top Studio
 * It is strictly forbidden to use or copy all or part of an element other than for your 
 * own personal and private use without prior written consent from Top Studio http://topstudiodev.com
 * Copies or reproductions are strictly reserved for the private use of the person 
 * making the copy and not intended for a collective use.
 *********************************************************************************/

 class editorpanel{

	function __construct(){
		
	}
	
	function createPanel($panel_title, $show = true){
		$this->editor_properties = array();
		$this->panel_title = $panel_title;
		$this->panel_show = $show;
	}

	
	function elementPropertyName($value){
		$html = '<div class="cfgenwp-e-property-l">'.$value.'</div>';
		return $html;
	}
	
	function openElementPropertyValue(){
		return '<div class="cfgenwp-e-property-r">';
	}
	
	function closeDiv(){
		return '</div>';
	}
	
	function elementSettingsTitle($value){
		$html = '<div class="cfgenwp-e-properties-t">'.$value.'</div>';
		return $html;
	}
	
	function openEditProperties(){
		$c_style = !$this->panel_show ? ' style="display:none;"' : '';
		return '<div class="cfgenwp-e-properties-c"'.$c_style.'>';
	}
	
	function addProperty($properties){
		$this->editor_properties[] = $properties;
	}
	
	function getEditor(){

		$editor = $this->openEditProperties();
		
		$editor .= $this->elementSettingsTitle($this->panel_title);
		
		// var_dump($this->editor_properties);
		
		foreach($this->editor_properties as $property_c){

			$editor .= '<div class="cfgenwp-e-property-c">';
			
			foreach($property_c as $property_v){

				// var_dump($property_v);
				
				$ins_class = isset($property_v['ins_class']) ? $property_v['ins_class'] : '';
				$ins_style = (isset($property_v['ins_show']) && !$property_v['ins_show']) ? ' style="display:none;"' : '';

				$editor .= '<div class="cfgenwp-e-property-ins '.$ins_class.'" '.$ins_style.'>';
				
					$editor .= !empty($property_v['name']) ? $this->elementPropertyName($property_v['name']) : '';
					
					$editor .= $this->openElementPropertyValue();
					
					foreach($property_v['values'] as $property_value){
						
						if(count($property_v['values'])>1){
							$editor .= $this->openElementPropertyValue();
						}
						
						$editor .= $property_value;
						
						if(count($property_v['values'])>1){
							$editor .= $this->closeDiv();
						}
					}

					$editor .= $this->closeDiv();
					
					$editor .= '<div class="cfgenwp-clear"></div>';
				
				$editor .= '</div>';
				
			}
		
			$editor .= '</div>';
		}
		
		$editor .= '</div>';
		
		echo $editor;
	}
	
}

class contactFormEditor{

	function __construct(editorpanel $editorpanel = null){
		
		$this->editorpanel = new editorpanel;
		$this->html_form_element = '';
		$this->version = '2.7';
        
		$this->path_jquery = '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js';
		$this->path_jquery_ui = '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js';
		$this->path_jquery_ui_theme = '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.min.css';
		$this->path_jquery_ui_datepicker_language = '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/i18n/jquery-ui-i18n.min.js';
		$this->path_fontawesome = '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css';
        
		include(dirname(__FILE__).'/../inc/inc-fontawesome-list.php');
		$this->fontawesome_list = $cfgenwp_fontawesome_list;
		
		$this->support_url = 'http://www.topstudiodev.com/support/formgenerator';
		
		$this->dir_form_inc = 'cfgen-form';

		// FORMS INDEX
		$this->forms_dir = 'forms';
		$this->forms_dir_path = dirname(__FILE__).'/../'.$this->forms_dir.'/';
		$this->formsindex_protection = '<?php exit;?>';
		$this->formsindex_reset_content = $this->formsindex_protection.'{"forms":[]}';
		$this->formsindex_filename = 'forms.php';
		$this->formsindex_filename_path = $this->forms_dir_path.$this->formsindex_filename;
		
		// CONFIG FILE
		$this->config_dir = 'editor/inc'; // used in error messages
		$this->config_dir_path = dirname(__FILE__).'/../inc/';
		$this->config_filename = 'inc-config.php';
		$this->config_filename_path = $this->config_dir_path.$this->config_filename;
		
		// FORM SETTINGS
		
		$this->element_name_prefix = 'cfgen-element-';
		$this->option_name_prefix = 'cfgen-option-';
		$this->uploadbutton_prefix = 'uploadbutton_';
		$this->icon_suffix = '-icon';
		$this->label_suffix = '-label';
		$this->paragraph_suffix = '-paragraph';
		$this->terms_suffix = '-terms';
		$this->elementset_c_suffix = '-set-c';
		$this->input_c_suffix = '-input-c';
		$this->inputgroup_c_suffix = '-inputgroup-c';
		$this->elementcontent_suffix = '-content';
		$this->optioncontent_suffix = '-option-content';

		$this->isinput_list = array('checkbox', 'date',  'email', 'hidden', 'phone', 'radio', 'rating', 'select', 'selectmultiple', 'text', 'textarea', 'time', 'upload', 'url');

		$this->form_elements_setup = array();
		
		$this->addElement('title');
		$this->addElement('paragraph');
		$this->addElement('email');
		$this->addElement('textarea');
		$this->addElement('submit');
		
		if(!ini_get('date.timezone') && function_exists('date_default_timezone_set')){
			date_default_timezone_set('UTC');
		}
		
		$this->fontweight_list = array('normal', 'bold', 100, 200, 300, 400, 500, 600, 700, 800, 900);
		$this->fontstyle_list = array('normal', 'italic');
		
		$this->googlewebfonts_variants = '100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic,100,200,300,400,500,600,700,800,900';
	

		$this->checked = ' checked="checked" ';
		$this->disabled = ' disabled="disabled" ';
		$this->selected = ' selected="selected" ';
		
		$this->html_empty_image_container = '<div class="addimagecontainer">Use the options on the right to add an image here</div>';
		$this->dir_upload = 'upload/';
		$this->upload_image_authorized_ext = array ('.jpg', '.jpeg', '.jpe', '.gif', '.png');
		$this->swfupload_authorized_ext = '';
		foreach($this->upload_image_authorized_ext as $ext_value){
			$this->swfupload_authorized_ext .= '*'.$ext_value.';';
		}
		$this->swfupload_authorized_ext = substr($this->swfupload_authorized_ext, 0, -1);
		
		$this->slider_settings['captcha']['width']['min'] = 129;
		$this->slider_settings['separator']['height']['min'] = 1;
		$this->slider_settings['separator']['height']['max'] = 20;
		$this->slider_settings['submit']['height']['min'] = 20;
		$this->slider_settings['submit']['height']['max'] = 90;
		$this->slider_settings['textarea']['height']['min'] = 50;
		$this->slider_settings['textarea']['height']['max'] = 430;
		
		$this->slider_borderradius_min = 0;
		$this->slider_borderradius_max = 30;
		$this->slider_marginleft_min = 0;
		$this->slider_marginleft_max = 400;
		$this->slider_width_min = 10;
		$this->slider_width_max = 600;
		$this->slider_rows_min = 1;
		$this->slider_rows_max = 30;
		$this->slider_fontsize_min = 8;
		$this->slider_fontsize_max = 60;
		$this->slider_icon_fontsize_min = 1;
		$this->slider_icon_fontsize_max = 41; // Be careful when changing this value, the icon must fit within the input padding (check the input padding slider)
		$this->slider_fontsize_step = 1;
		$this->slider_margintop_min = 0;
		$this->slider_margintop_max = 20;
		
		
		$input_css_default_properties = array(
												'default'=>array(
																'background-color'=>'#ffffff',
																'border-width'=>'1px',
																'border-style'=>'solid',
																'border-color'=>'#dcdcdc',
																'border-radius'=>'4px',
																'color'=>'#000000',
																'font-family'=>'Arial',
																'font-weight'=>'normal',
																'font-style'=>'normal',
																'font-size'=>'14px',
																'padding'=>'7px',
																),
												'focus'=>array(
																'border-color'=>'#dcdcdc'
															)
												);

		$selectmultiple_css_default_properties = $input_css_default_properties;
		$selectmultiple_css_default_properties['default']['border-radius'] = '0px';
		
		$this->css_properties_initialization = array(	
												'captcha'=>array(
																'element-set-c'=>array('width'=>'129px', 'max-width:100%'),
																'input-group-c'=>array('max-width'=>'129px'), /* can\'t be inferior to the captcha slider width min */
																),
												'date'=>array(
															'element-set-c'=>array('width'=>'100px', 'max-width:100%'),
															'input-group-c'=>array('max-width'=>'100px'),
															),
												'email'=>array(
																'element-set-c'=>array('width'=>'300px', 'max-width:100%'),
																'input-group-c'=>array('max-width'=>'300px'),
																),
												'icon'=>array(
																'default'=>array(
																				'background-color'=>'#ececec',
																				'border-color'=>'#dcdcdc',
																				'border-style'=>'solid',
																				'font-size'=>'22px',
																				'color'=>'#969696',
																				'min-width'=>'40px',
																				),
																),
												'input'=>$input_css_default_properties,
												'label'=>array(
																'default'=>array(
																				'color'=>'#4DBCE9',
																				'font-family'=>'Arial',
																				'font-weight'=>'700',
																				'font-style'=>'normal',
																				'font-size'=>'16px',
																				'margin-bottom'=>'2px',
																				),
																),
												'option'=>array(
																'default'=>array(
																				'padding-top'=>'0px',
																				'width'=>'100px',
																				),
																),
												'paragraph'=>array(
																	'default'=>array(
																					'color'=>'#000000',
																					'font-family'=>'Arial',
																					'font-weight'=>'normal',
																					'font-style'=>'normal',
																					'font-size'=>'14px',
																					'width'=>'300px',
																					)
																),
												'rating'=>array(
																'default'=>array(
																				'color'=>'#dddddd',
																				'padding-right'=>'10px',
																				'font-size'=>'31px',
																				),
																'hover'=>array(
																				'color'=>'#fac12f',
																				),
																),
												'select'=>$input_css_default_properties,
												'selectmultiple'=>$selectmultiple_css_default_properties,
												'separator'=>array(
																	'default'=>array(
																					'height'=>'1px',
																					'background-color'=>'#cccccc',
																					)
																),
												'submit'=>array('element-set-c'=>array('width'=>'140px', 'max-width:100%'),
																'input-group-c'=>array('max-width'=>'140px'),
																'default'=>array(
																				'background-color'=>'#f1f1f1',
																				'border-width'=>'1px',
																				'border-style'=>'solid',
																				'border-color'=>'#cccccc',
																				'border-radius'=>'5px',
																				'color'=>'#555555',
																				'font-family'=>'Arial',
																				'font-weight'=>'bold',
																				'font-style'=>'normal',
																				'font-size'=>'20px',
																				'height'=>'45px',
																				'margin-left'=>'0px',
																				)
																),
												'terms'=>array(
																	'default'=>array(
																					'color'=>'#000000',
																					'font-family'=>'Arial',
																					'font-weight'=>'normal',
																					'font-style'=>'normal',
																					'font-size'=>'14px',
																					)
																),
												'text'=>array('element-set-c'=>array('width'=>'300px', 'max-width:100%'),
															  'input-group-c'=>array('max-width'=>'300px'),
															 ),
												'textarea'=>array('element-set-c'=>array('width'=>'300px', 'max-width:100%'),
																  'input-group-c'=>array('max-width'=>'300px'),
																  'default'=>array('height'=>'140px')
																  ),
												'time'=>$input_css_default_properties,
												'title'=>array('default'=>array(
																				'color'=>'#26ADE4',
																				'font-family'=>'Arial',
																				'font-weight'=>'bold',
																				'font-style'=>'normal',
																				'font-size'=>'34px',
																				),
																),
												'url'=>array('element-set-c'=>array('width'=>'300px', 'max-width:100%'),
															 'input-group-c'=>array('max-width'=>'300px'),
															 ),
												);
		
		$this->rating_default_maximum = 5;
		
		// Default value is required because it is used to build javascript vars in index.php
		$this->icon_style = $this->buildStyle($this->css_properties_initialization['icon']['default']);
		$this->option_style = 'font-family:'.$this->getCssPropertyDefaultValue('input', 'font-family').';'
							 .'font-weight:'.$this->getCssPropertyDefaultValue('input', 'font-weight').';'
							 .'font-style:'.$this->getCssPropertyDefaultValue('input', 'font-style').';'
							 .'font-size:'.$this->getCssPropertyDefaultValue('input', 'font-size').';'
							 .'color:'.$this->getCssPropertyDefaultValue('input', 'color').';';

		$this->label_align_left_width = '130px';
		$this->paragraph_default_value = 'To contact us, use the form below.<br>We will get back to you as soon as possible.';
		$this->newoption_default_value = 'New option';
		$this->option_default_value = 'Option';
		$this->submit_default_value = 'Send';
		$this->terms_default_link = 'http://www.example.com';
		$this->terms_default_value = 'I agree to the {Terms and Conditions}.';
		$this->title_default_value = 'Contact us';
		
		$this->labels = array(
								'captcha'=>'Captcha: type the characters below',
								'checkbox'=>'Checkboxes',
								'date'=>'Date',
								'email'=>'Email address',
								'hidden'=>'Hidden input',
								'radio'=>'Radio buttons',
								'rating'=>'Rating',
								'select'=>'Select',
								'selectmultiple'=>'Multiple Select',
								'textarea'=>'Your message',
								'text'=>'Text field',
								'time'=>'Time',
								'upload'=>'Upload',
								'url'=>'URL',
							);
		

		$this->datepicker_default_format = 'mm/dd/yy';
		// y - year (two digit) yy - year (four digit) http://docs.jquery.com/UI/Datepicker/formatDate
		$this->datepicker_formats = array(
										  'mm/dd/yy'=>'mm/dd/y',
										  'mm/dd/yyyy'=>'mm/dd/yy',
										  'dd/mm/yy'=>'dd/mm/y',
										  'dd/mm/yyyy'=>'dd/mm/yy',
										  'dd-mm-yy'=>'dd-mm-y',
										  'dd-mm-yyyy'=>'dd-mm-yy',
										  'yy-mm-dd'=>'y-mm-dd',
										  'yyyy-mm-dd'=>'yy-mm-dd',
										  );
		
		$this->datepicker_language = array(
						   					'Bosnian'=>'bs', 'Bulgarian'=>'bg', 'Brazilian'=>'pt-BR', 'Chinese (simplified)'=>'zh-CN', 'Chinese (traditional)'=>'zh-TW', 'Czech'=>'cs', 'Croatian'=>'hr', 'Danish'=>'da', 
											'Dutch'=>'nl', 'English'=>'en-GB', 'Español'=>'es', 'Estonian'=>'et', 'Finnish'=>'fi', 'French'=>'fr', 'German'=>'de', 'Greek'=>'el', 'Hebrew'=>'he', 'Hungarian'=>'hu', 'Icelandic'=>'is', 
											'Indonesian'=>'id', 'Italian'=>'it', 'Japanese'=>'ja', 'Lithuanian'=>'lt', 'Norwegian'=>'no', 'Polish'=>'pl', 'Portuguese'=>'pt-BR', 'Romanian'=>'ro',  'Russian'=>'ru', 'Serbian'=>'sr', 
											'Slovak'=>'sk', 'Slovenian'=>'sl', 'Swedish'=>'sv', 'Ukrainian'=>'uk', 'Vietnamese'=>'vi',
											);
		
		$this->datepicker_firstdayoftheweek_default = 1;
		
		$this->datepicker_firstdayoftheweek = array(1=>'Monday', 0=>'Sunday');
		
		$this->datepicker_default_language = 'English';
		$this->datepicker_default_yearrange_max = 70;
		$this->datepicker_default_yearrange_minus = 70;
		$this->datepicker_default_yearrange_plus = 70;
		
		$this->captcha_default_length = 6;
		$this->captcha_default_format = 'lettersandnumbers'; // Choices: lettersandnumbers / letters / numbers
		
		$this->upload_filesizelimit = 1; //preg_replace('/M/i', '', ini_get('upload_max_filesize'));
		$this->upload_filesizeunit = 'MB';
		$this->upload_fileextension = array(
											'Image' => array('jpeg', 'jpg', 'tif', 'png', 'gif', 'bmp', 'psd', 'ai', 'eps'),
											'Text' => array('doc', 'docx', 'pdf', 'txt', 'xls', 'xlsx')
											);

		$this->formmessage_style['validation'] = array(
														'font-family'=>'Verdana',
														'font-weight'=>'normal',
														'font-style'=>'normal',
														'font-size'=>'12px',
														'color'=>'#ffffff',
														'background-color'=>'#3bb000',
														'width'=>'315px',														
														);

		$this->formmessage_style['error'] = array(
													'font-family'=>'Verdana',
													'font-weight'=>'normal',
													'font-style'=>'normal',
													'font-size'=>'12px',
													'color'=>'#ffffff',
													'background-color'=>'#ff0000',
													'width'=>'315px',
												);


		$this->fontstyleeditor_fontlist = array('Arial', 'Courier New', 'Georgia', 'Impact', 'Tahoma', 'Times New Roman', 'Trebuchet MS', 'Verdana');
		
		$this->regex_replace_formname_pattern = ' '; // spaces will be replaced with dashes
		$this->regex_replace_formname_replacement = '-'; // spaces will be replaced with dashes
		
		$this->warning_php5 = '<div class="warning">'
								.'<p><strong>Error: Contact Form Generator requires PHP 5.2 or newer to work properly</strong>.</p>'
								.'<p>The version of PHP installed on your server is <strong>'.phpversion().'</strong></p>'
								.'<p>You can solve this problem by contacting your web hosting technical support and ask them to activate PHP 5.2 or newer.</p>'
								.'<p>Don\'t hesitate to contact us at support@topstudiodev.com if you need further assistance, we will be glad to help you.</p>'
							.'</div>';
		
		$this->set_permission_format = '<p>Set the permission to 755 on "%s" on your server to solve this problem.</p>'
									  .'<p>Set the permission to 777 if it does not work otherwise.</p>'
									  .'<p>If your website is installed on a Windows based server, you must make it writable in your file manager.</p>';

		$this->error_not_writable_form_index_file = '<p>The file that indexes your forms can\'t be edited.</p>'.sprintf($this->set_permission_format, 'editor/'.$this->forms_dir.'/'.$this->formsindex_filename);

		$this->error_not_writable_config_file = '<p>The config file can\'t be edited.</p>'.sprintf($this->set_permission_format, $this->config_dir.'/'.$this->config_filename);

		$this->error_not_writable_dir_form_download = '<p>The directory that will contain your new forms can\'t be edited.</p>'.sprintf($this->set_permission_format, 'editor/'.$this->forms_dir);

		$this->error_not_writable_dir_upload = '<p>The directory that will contain your new forms can\'t be edited.</p>'.sprintf($this->set_permission_format, $this->forms_dir);

		$this->error_not_writable_dir_upload = '<p>The directory that will contain your uploads can\'t be edited.</p>'.sprintf($this->set_permission_format, 'editor/upload');

		$this->error_not_writable_config_dir = '<p>The directory that will contain your config file can\'t be edited.</p>'.sprintf($this->set_permission_format, $this->config_dir);


		$this->error_message['session_expired'] = 'Your session has expired due to an extended period of inactivity.'
												.'<br><br><strong>Your server automatically stops sessions after '.ceil(ini_get('session.gc_maxlifetime')/60).' minutes of inactivity</strong>.'
												.'<br><br>If you want unlimited session time, click on the "remember me" checkbox when you log in.';

		$this->cr_sha1 = '423700b9f763d025147a87f9d316b24f0fefbb7a';		
		
		$this->{'d'.'e'.'m'.'o'} = 0;
		
		$this->envato_item_link = 'http://codecanyon.net/item/contact-form-generator-form-builder/1719810';
		
		$this->url_envato_formgenerator_item = $this->envato_item_link.'?ref=topstudio';
		$this->url_envato_formgenerator_support = $this->envato_item_link.'/support';
		$this->url_topstudio_formgenerator = 'http://www.topstudiodev.com/formgenerator';
		
		$this->icons['fontawesome'] = array(
											array('unicode'=>'&#xf0e0;', 'id'=>'fa-envelope'), array('unicode'=>'&#xf003;', 'id'=>'fa-envelope-o'),
											array('unicode'=>'&#xf073;', 'id'=>'fa-calendar'), array('unicode'=>'&#xf133;', 'id'=>'fa-calendar-o'),
											array('unicode'=>'&#xf007;', 'id'=>'fa-user'), array('unicode'=>'&#xf015;', 'id'=>'fa-home'),
											array('unicode'=>'&#xf129;', 'id'=>'fa-info'), array('unicode'=>'&#xf05a;', 'id'=>'fa-info-circle'),
											array('unicode'=>'&#xf041;', 'id'=>'fa-map-marker'), array('unicode'=>'&#xf095;', 'id'=>'fa-phone'),
											array('unicode'=>'&#xf098;', 'id'=>'fa-phone-square'), array('unicode'=>'&#xf104;', 'id'=>'fa-angle-left'),
											array('unicode'=>'&#xf105;', 'id'=>'fa-angle-right'), array('unicode'=>'&#xf0a8;', 'id'=>'fa-arrow-circle-left'),
											array('unicode'=>'&#xf0a9;', 'id'=>'fa-arrow-circle-right'), array('unicode'=>'&#xf060;', 'id'=>'fa-arrow-left'),
											array('unicode'=>'&#xf061;', 'id'=>'fa-arrow-right'), array('unicode'=>'&#xf053;', 'id'=>'fa-chevron-left'),
											array('unicode'=>'&#xf054;', 'id'=>'fa-chevron-right'), array('unicode'=>'&#xf0a5;', 'id'=>'fa-hand-o-left'),
											array('unicode'=>'&#xf0a4;', 'id'=>'fa-hand-o-right'), array('unicode'=>'&#xf099;', 'id'=>'fa-twitter'),
											array('unicode'=>'&#xf09a;', 'id'=>'fa-facebook'), array('unicode'=>'&#xf230;', 'id'=>'fa-facebook-official'),
											array('unicode'=>'&#xf0e1;', 'id'=>'fa-linkedin'), array('unicode'=>'&#xf08c;', 'id'=>'fa-linkedin-square'),
											array('unicode'=>'&#xf16d;', 'id'=>'fa-instagram'), array('unicode'=>'&#xf1a0;', 'id'=>'fa-google'),
											array('unicode'=>'&#xf19a;', 'id'=>'fa-wordpress'), array('unicode'=>'&#xf167;', 'id'=>'fa-youtube'),
											array('unicode'=>'&#xf153;', 'id'=>'fa-euro'), array('unicode'=>'&#xf155;', 'id'=>'fa-dollar'),
											array('unicode'=>'&#xf157;', 'id'=>'fa-yen'),
											);
	}

	
	function errorNotWritableDirForm($form_dir){
		
		$error = '<p>The form directory can\'t be edited.</p>'
				.'<p>Set the permission to 755 on the directory \'editor/'.$this->forms_dir.'/'.$form_dir.'\' on your server to solve this problem.</p>'
				.'<p>Also set the permission to 755 on the directory \'editor/'.$this->forms_dir.'\' on your server to solve this problem.</p>'
				.'<p>Set the permission to 777 on both directories if it does not work otherwise.</p>';
	
		return($error);
	}
	
	function errorNotWritableAdminUpload($filename){

		$error = '<p>This file can\'t be edited.</p>'
				.'<p>Set the permission to 755 on the file \'editor/upload/'.addcslashes($filename, '"').'\' on your server to solve this problem.</p>'
				.'<p>Also set the permission to 755 on the directory \'editor/upload\' on your server to solve this problem.</p>'
				.'<p>Set the permission to 777 on both directories if it does not work otherwise.</p>';
	
		return($error);
	}

	function getCssPropertyDefaultValue($key, $property_name, $state = 'default'){
		return (isset($this->css_properties_initialization[$key][$state][$property_name]) ?  $this->css_properties_initialization[$key][$state][$property_name] : '');
	}
	
	function getCssPropertyValue($element, $belongs_to, $property_name, $state = 'default'){
		return $element[$belongs_to]['css'][$state][$property_name];
	}
	
	function elementHasCssProperty($element, $belongs_to, $property_name, $state = 'default'){
		return (!empty($element[$belongs_to]['css'][$state][$property_name]) ? true : false);
	}
	
	function addElement($type){
		$this->form_elements_setup[]['type'] = $type;
	}

	
	function addEditIcon($element){

		$icon_properties_c_show = !empty($element['icon']) ? true : false;
		
		// ADD ICON EDIT ICON
		$this->editorpanel->createPanel('Select an icon');
		
		// POPULAR ICONS
		$html_icon_select_options = '<option value="">No icon selected</option>';
		$html_icon_select_options .= '<optgroup label="Popular icons">';
		
		$load_icon_id = !empty($element['icon']) ? $element['icon']['fontawesome_id'] : '';
		
		foreach($this->icons['fontawesome'] as $icon_v){
			
			$selected_id = $load_icon_id == $icon_v['id'] ? $this->selected : '';
			
			$html_icon_select_options .= '<option '.$selected_id.' value="'.$icon_v['id'].'" data-cfgenwp_icon_type="fontawesome">'.$icon_v['unicode'].'</option>';
		}
		
		$html_icon_select_options .= '</optgroup">';
		
		// ALL ICONS
		$html_icon_select_options .= '<optgroup label="All icons">';
		
		foreach($this->fontawesome_list as $icon_v){
			
			$selected_id = $load_icon_id == $icon_v['id'] ? $this->selected : '';
			
			$html_icon_select_options .= '<option '.$selected_id.' value="'.$icon_v['id'].'" data-cfgenwp_icon_type="fontawesome">'.$icon_v['unicode'].'</option>';
		}
		
		$html_icon_select_options .= '</optgroup">';
		
		$html_icon_select = '<select class="cfgenwp-icon-select">'.$html_icon_select_options.'</select>';
		
		
		$this->editorpanel->addProperty( array(  array('values'=>array($html_icon_select))  ) );
		
		$this->editorpanel->getEditor();
		
		// ICON DESIGN
		$this->editorpanel->createPanel('Icon color', $icon_properties_c_show);

		// ADD ICON EDIT COLOR
		$cpicker_icon_color['colorpicker_csspropertyname'] = 'color';
		$cpicker_icon_color['colorpicker_input_id'] = 'cfgenwp-icon-color-'.$_SESSION['cfgenwp_form_element_id'];
		$cpicker_icon_color['colorpicker_color'] = $this->elementHasCssProperty($element, 'icon', 'color') ? $this->getCssPropertyValue($element, 'icon', 'color') : $this->getCssPropertyDefaultValue('icon', 'color');
		$cpicker_icon_color['colorpicker_target'] = 'icon';
		$cpicker_icon_color['colorpicker_objecttype'] = 'icon';
		$cpicker_icon_color['colorpicker_class'] = 'cfgenwp-colorpicker-icon-color';
		$this->editorpanel->addProperty( array(  array('name'=>'Color', 'values'=>array($this->setUpColorPicker($cpicker_icon_color, true)))  ) );
		
		// ADD ICON EDIT BACKGROUND COLOR
		$cpicker_icon_bg['colorpicker_csspropertyname'] = 'background-color';
		$cpicker_icon_bg['colorpicker_input_id'] = 'cfgenwp-icon-bgcolor-'.$_SESSION['cfgenwp_form_element_id'];
		$cpicker_icon_bg['colorpicker_color'] = $this->elementHasCssProperty($element, 'icon', 'background-color') ? $this->getCssPropertyValue($element, 'icon', 'background-color') : $this->getCssPropertyDefaultValue('icon', 'background-color');
		$cpicker_icon_bg['colorpicker_target'] = 'icon';
		$cpicker_icon_bg['colorpicker_objecttype'] = 'icon';
		$cpicker_icon_bg['colorpicker_class'] = 'cfgenwp-colorpicker-icon-backgroundcolor';
		$this->editorpanel->addProperty( array(  array('name'=>'Background', 'values'=>array($this->setUpColorPicker($cpicker_icon_bg, true)))  ) );
		
		// ADD ICON EDIT BORDER COLOR
		$cpicker_icon_border['colorpicker_csspropertyname'] = 'border-color';
		$cpicker_icon_border['colorpicker_input_id'] = 'cfgenwp-icon-bordercolor-'.$_SESSION['cfgenwp_form_element_id'];
		$cpicker_icon_border['colorpicker_color'] = $this->elementHasCssProperty($element, 'icon', 'border-color') ? $this->getCssPropertyValue($element, 'icon', 'border-color') : $this->getCssPropertyDefaultValue('icon', 'border-color');
		$cpicker_icon_border['colorpicker_target'] = 'icon';
		$cpicker_icon_border['colorpicker_objecttype'] = 'icon';
		$cpicker_icon_border['colorpicker_class'] = 'cfgenwp-colorpicker-icon-bordercolor';
		$this->editorpanel->addProperty( array(  array('name'=>'Border', 'values'=>array($this->setUpColorPicker($cpicker_icon_border, true)))  ) );
		
		// ADD ICON EDIT FONT SIZE
		$slider_fontsize_value = $this->elementHasCssProperty($element, 'icon', 'font-size') ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'icon', 'font-size')) : $this->getNumbersOnly($this->getCssPropertyDefaultValue('icon', 'font-size'));
		
		$select_slider = $this->addSelectSlider(array(
													'slider_id'=>'cfgenwp-icon-fontsize-slider-'.$_SESSION['cfgenwp_form_element_id'],
													'slider_function'=>'cfgen_sliderIconFontSize',
													'select_class'=>'cfgenwp-icon-fontsize-select',
													'option_min'=>$this->slider_icon_fontsize_min,
													'option_max'=>$this->slider_icon_fontsize_max,
													'option_selected'=>$slider_fontsize_value,
												));

		$this->editorpanel->addProperty( array(  array('name'=>'Icon size', 'values'=>array($select_slider))  ) );
		
		// ADD ICON EDIT WIDTH
		$slider_width_id = 'cfgenwp-icon-width-slider-'.$_SESSION['cfgenwp_form_element_id'];
		$slider_width_value = $this->elementHasCssProperty($element, 'icon','min-width') ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'icon', 'min-width')) : $this->getNumbersOnly($this->getCssPropertyDefaultValue('icon', 'min-width'));
		?>
		<script>
		jQuery(function(){
			jQuery('#<?php echo $slider_width_id;?>').slider(
			{
				range: 'min',
				min:28,
				max:80,
				value:<?php echo $slider_width_value; ?>,
				step:1
			}).on('slide slidechange', function(event, ui){
				
				var width_px = jQuery.cfgen_appendPx(ui.value);
				jQuery.cfgen_setCssPropertyValue('icon', 'min-width', width_px);
				
				var find_icon_c = jQuery(this).cfgen_findElementContThroughFbElementCont().cfgen_findElementIconCont();
				
				var icon_c_outer_width = find_icon_c.outerWidth();

				find_icon_c.css({'min-width':width_px});
				
				/**
				 * This occurs when reducing the icon container width using the slider whereas the icon container is currently bigger due to a big icon inside
				 * Therefore the slider must return false so that nothing happens (the input value and the slider value are not updated)
				 */
				if(icon_c_outer_width > ui.value){
					return false;
				} else{
					// cfgen_triggerSliderIconContWidth must comes after cfgen_sliderUpdateInputValue as it includes adjustments based on the input width edit value
					jQuery(this).cfgen_sliderUpdateInputValue(ui.value).cfgen_setInputContWidth();
				}

			});
		});
		</script>
		<?php
		$html_slider_width = '<input type="text" '
								   .'class="cfgenwp-icon-width-input-value cfgenwp-slider-input-value" '
								   .'value="'.$slider_width_value.'">px'
							.'<div id="'.$slider_width_id.'"></div>';
							
		$this->editorpanel->addProperty( array(  array('name'=>'Container width', 'values'=>array($html_slider_width))  ) );

		$this->editorpanel->getEditor();
		
		// ICON POSITION
		$this->editorpanel->createPanel('Icon position', $icon_properties_c_show);
		
		$icon_positions = array(
								array('class'=>'cfgenwp-icon-align', 'id'=>'cfgenwp-icon-align-left', 'value'=>'left', 'label'=>'Left side'),
								array('class'=>'cfgenwp-icon-align', 'id'=>'cfgenwp-icon-align-right', 'value'=>'right', 'label'=>'Right side'),
								);

		foreach($icon_positions as $position_v){
			
			$input_name = $position_v['class'].'-'.$_SESSION['cfgenwp_form_element_id'];
			$input_id = $position_v['id'].'-'.$_SESSION['cfgenwp_form_element_id'];
			
			if($position_v['value'] === 'left'){
				$checked = $this->checked;
			}

			if($position_v['value'] === 'right'){

				if(isset($element['id']) && isset($element['icon']['align']) && $element['icon']['align'] === 'right'){
					$checked = $this->checked;
				} else{
					$checked = '';
				}
			}
			
			$html_icon_position[] = '<input type="radio" '.$checked.' name="'.$input_name.'" class="'.$position_v['class'].'" id="'.$input_id.'" value="'.$position_v['value'].'"><label for="'.$input_id.'">'.$position_v['label'].'</label>';
		}

		$this->editorpanel->addProperty( array(  array('name'=>'Position', 'values'=>$html_icon_position)  ) );
		
		$this->editorpanel->getEditor();
	}
	
	// ADD PARAGRAPH EDIT
	function addEditParagraph($element){
		
		// Paragraph value
		$this->editorpanel->createPanel('Paragraph text');
		
		if(!empty($element['id'])){
			$edit_paragraph_value = !empty($element['paragraph']['value'])? $element['paragraph']['value'] : '';
		} else{
			if($element['type'] == 'paragraph'){
				$edit_paragraph_value = $this->paragraph_default_value;
			} else{
				$edit_paragraph_value = '';
			}
		}
		
		$html_paragraph_text = '<textarea rows="4" class="cfgenwp-input-100 cfgenwp-paragraph-edit">'.preg_replace('#<br(\s*)/>|<br(\s*)>#i', "\r\n", $edit_paragraph_value).'</textarea>';		
		$this->editorpanel->addProperty( array(  array('values'=>array($html_paragraph_text)) ) );
		$this->editorpanel->getEditor();
		
		
		$this->editorpanel->createPanel('Font style');
		$select_attr_data = array('cfgenwp_object_type'=>'paragraph');
		$preselect_fontfamily = $this->elementHasCssProperty($element, 'paragraph', 'font-family') ? $this->getCssPropertyValue($element, 'paragraph', 'font-family') : $this->getCssPropertyDefaultValue('paragraph', 'font-family');
		$preselect_fontweight = $this->elementHasCssProperty($element, 'paragraph', 'font-weight') ? $this->getCssPropertyValue($element, 'paragraph', 'font-weight') : $this->getCssPropertyDefaultValue('paragraph', 'font-weight');
		$preselect_fontstyle = $this->elementHasCssProperty($element, 'paragraph', 'font-style') ? $this->getCssPropertyValue($element, 'paragraph', 'font-style') : $this->getCssPropertyDefaultValue('paragraph', 'font-style');


		// PARAGRAPH FONT FAMILY
		$this->editorpanel->addProperty($this->addEditFontFamily(array(
																	'fontfamily_value'=>$preselect_fontfamily, 
																	'data_attr'=>array_merge($select_attr_data, array('cfgenwp_fontfamily_selected'=>$preselect_fontfamily, 'cfgenwp_fontweight_selected'=>$preselect_fontweight)))));
		
		
		// PARAGRAPH FONT SIZE
		$slider_fontsize_value = $this->elementHasCssProperty($element, 'paragraph', 'font-size') ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'paragraph', 'font-size')) : $this->getCssPropertyDefaultValue('paragraph', 'font-size');
		
		$slider_paragraph_fontsize = $this->addSelectSlider(array(
																'slider_id'=>'cfgenwp-paragraph-fontsize-slider-'.$_SESSION['cfgenwp_form_element_id'],
																'slider_function'=>'cfgen_sliderParagraphFontSize',
																'select_class'=>'cfgenwp-paragraph-fontsize-select',
																'option_min'=>$this->slider_fontsize_min, 
																'option_max'=>$this->slider_fontsize_max, 
																'option_selected'=>$slider_fontsize_value,
																));
		
		$this->editorpanel->addProperty( array(  array('name'=>'Font size', 'values'=>array($slider_paragraph_fontsize))  ) );
		
		
		// PARAGRAPH FONT WEIGHT
		$this->editorpanel->addProperty($this->addEditFontWeight(array(
																	'fontweight_value'=>$preselect_fontweight, 
																	'data_attr'=>array_merge($select_attr_data, array('cfgenwp_fontfamily_selected'=>$preselect_fontfamily))
																	), $this->getFontVariants($preselect_fontfamily, 'fontweight')));
		
		
		// PARAGRAPH FONT STYLE
		$this->editorpanel->addProperty($this->addEditFontStyle(array(
																	'fontstyle_value'=>$preselect_fontstyle, 
																	'data_attr'=>array_merge($select_attr_data, array('cfgenwp_fontfamily_selected'=>$preselect_fontfamily))
																	), $this->getFontVariants($preselect_fontfamily, 'fontstyle')));
	
	
		// PARAGRAPH COLOR
		$cpicker_paragraph_color['colorpicker_color'] = $this->elementHasCssProperty($element, 'paragraph', 'color') ? $this->getCssPropertyValue($element, 'paragraph', 'color') : $this->getCssPropertyDefaultValue('paragraph', 'color');
		$cpicker_paragraph_color['colorpicker_csspropertyname'] = 'color';
		$cpicker_paragraph_color['colorpicker_input_id'] = 'cfgenwp-paragraph-color-'.$_SESSION['cfgenwp_form_element_id'];
		$cpicker_paragraph_color['colorpicker_target'] = 'paragraph';
		$cpicker_paragraph_color['colorpicker_objecttype'] = 'paragraph';
		$cpicker_paragraph_color['colorpicker_class'] = 'cfgenwp-colorpicker-paragraph-color';
		$this->editorpanel->addProperty( array(  array('name'=>'Font color', 'values'=>array($this->setUpColorPicker($cpicker_paragraph_color, true)))  ) );

		
		// PARAGRAPH WIDTH
		$slider_width_id = 'cfgenwp-paragraph-width-slider-'.$_SESSION['cfgenwp_form_element_id'];
		
		$slider_width_value = $this->elementHasCssProperty($element, 'paragraph', 'width')
							  ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'paragraph', 'width')) 
							  : $this->getNumbersOnly($this->getCssPropertyDefaultValue('paragraph', 'width'));
		?>
		<script>
		jQuery(function(){
			jQuery('#<?php echo $slider_width_id;?>').slider(
			{
				range: 'min',
				min: <?php echo $this->slider_width_min; ?>,
				max: <?php echo $this->slider_width_max; ?>,
				value: <?php echo $slider_width_value; ?>,
				step: 1,
				slide: function(event, ui){
					jQuery(this).cfgen_closestFbElementCont().find('div.cfgen-paragraph').addClass('cfgenwp-slidertracker-width');
				},
				stop: function(event, ui){
					jQuery(this).cfgen_closestFbElementCont().find('div.cfgen-paragraph').removeClass('cfgenwp-slidertracker-width');
				}
			}).on('slide slidechange', function(event, ui){
											jQuery(this).cfgen_sliderUpdateInputValue(ui.value).cfgen_sliderParagraphWidth(ui.value);
										});
		});
		</script>
		<?php
		$html_slider_paragraph_width = '<input type="text" class="cfgenwp-input-paragraph-width-value cfgenwp-slider-input-value" value="'.$slider_width_value.'" >px'
										.'<div id="'.$slider_width_id.'"></div>';
										
		$this->editorpanel->addProperty( array(  array('name'=>'Width', 'values'=>array($html_slider_paragraph_width))  ) );

		$this->editorpanel->getEditor();

	}
	
	function buildSelectOption($option_label, $option_value, $option_selected){	
		return '<option value="'.$option_value.'" '.$option_selected.'>'.ucfirst($option_label).'</option>';
	}
	
	function buildSelectFontFamilyOptions($config){
		
		$select_font_family = '<optgroup label="Standard Fonts">';
		
		foreach($this->fontstyleeditor_fontlist as $value){
			// Single quotes are imperative because json_encode return a proper json string with double quotes
			$select_font_family .= '<option data-cfgenwp_font_variants=\''.json_encode(array('regular', 'italic', '700', '700italic')).'\' '
										  .'value="'.$value.'" '.($config['fontfamily_value'] == $value ? $this->selected : '').'>'.$value.'</option>';
		}
		
		$select_font_family .= '</optgroup>';
		
		if(!empty($_SESSION['cfgenwp_googlewebfonts_list'])){
			$select_font_family .= '<optgroup label="Google Web Fonts">';
			
			foreach($_SESSION['cfgenwp_googlewebfonts_list']['items'] as $value){
				
				// Single quotes are imperative because json_encode return a proper json string with double quotes
				$select_font_family .= '<option data-cfgenwp_font_variants=\''.json_encode($value['variants']).'\' '
											  .'class="cfgenwp-googlewebfonts" '
											  .'value="'.$value['family'].'" '.($config['fontfamily_value'] == $value['family'] ? $this->selected : '').'>'.$value['family'].'</option>';
			}
			
			$select_font_family .= '</optgroup>';
			
		}
		
		return $select_font_family;
	}
	
	function buildDataAttr($data){
	
		$data_attr = '';
		
		if($data){
			foreach($data as $data_attr_k=>$data_attr_v){
				$data_attr .= 'data-'.$data_attr_k.' = "'.$data_attr_v.'" ';
			}
		}
		
		return $data_attr;
	}
	
	function addEditFontFamily($config){
		
		$property_name = 'Font family';
		
		$select_attr_data = isset($config['data_attr']) ? $this->buildDataAttr($config['data_attr']) : '';
		$select_attr_id = isset($config['fontfamily_select_id']) ? 'id="'.$config['fontfamily_select_id'].'"' : '';
		
		$property_value = '<select class="cfgenwp-fontfamily-select" '.$select_attr_data.' '.$select_attr_id.'>'
						  .$this->buildSelectFontFamilyOptions($config)
						 .'</select>';
							
		return array(array('name'=>$property_name, 'values'=>array($property_value)));

	}
	
	function addSelectSlider($config){
		// Single quotes are imperative because json_encode return a proper json string with double quotes
		$select = '<select '.(isset($config['select_id']) ? 'id="'.$config['select_id'].'" ' : '')
							.'class="cfgenwp-select-slider'.(isset($config['select_class']) ? ' '.$config['select_class'] : '').'" '
							.'>';
		
		for($i=$config['option_min']; $i<=$config['option_max']; $i++){
			
			$selected = '';
			
			if($i == $config['option_selected']){
				$selected = $this->selected;
			}
			
			$select .= '<option '.$selected.' value="'.$i.'">'.$i.'px</option>';
		}
		
		$select .= '</select>';
		
		$slider = '<div id="'.$config['slider_id'].'"></div>';

		$jquery = '<script>';
		$jquery .= 'jQuery(function(){';
		$jquery .= "jQuery('#".$config['slider_id']."').slider({
																range: 'min',
																min: ".$config['option_min'].",
																max: ".$config['option_max'].",
																value: parseFloat('".$config['option_selected']."'),
																step: 1
															}).on('slide slidechange', /* slidechange is triggered by select and is required to adjust the icon after releasing the slider */
																	
																	function(event, ui){
																		var res = jQuery(this).cfgen_SliderTriggersSelect(ui.value);
																		jQuery(this).".$config['slider_function']."(res);
																	});";
		$jquery .= '})';
		$jquery .= '</script>';
		return $select.$slider.$jquery;
	}
	
	function addEditFontWeight($config, $filter = array()){
		
		foreach($filter as $filter_k=>$filter_v){
			
			if($filter_v === 'regular'){
				$filter[] = '400'; // Add 400 to the authorized values in order to display it in the dropdown along with 'normal'
			}
			
			if($filter_v === 'italic'){
				// Regular/Normal may not be available in the official font variants, however it still must be available in the dropdown for font styles like italic (Molle does not include "regular" and includes "italic" only)
				$filter[] = '400';
				$filter[] = 'normal';
			}
			
			$filter[$filter_k] = str_replace(array('regular'), array('normal'), $filter_v);
			
		}
		
		$select_attr_data = isset($config['data_attr']) ? $this->buildDataAttr($config['data_attr']) : '';
		$select_attr_id = isset($config['fontweight_select_id']) ? 'id="'.$config['fontweight_select_id'].'"' : '';
	
		$property_value = '<select class="cfgenwp-fontweight-select" '.$select_attr_data.' '.$select_attr_id.'>';
		
		foreach($this->fontweight_list as $fontweight_v){
			
			$fontweight_selected = '';
			
			if($fontweight_v == $config['fontweight_value']){
				$fontweight_selected = $this->selected;
			}
			
			$show_option = true;
			
			if($filter && !in_array($fontweight_v, $filter)){
				$show_option = false;
			}
			
			if($show_option){
				$property_value .= $this->buildSelectOption($fontweight_v, $fontweight_v, $fontweight_selected);
			}
		}
		
		$property_value .= '</select>';
		
		return array(array('name'=>'Font weight', 'values'=>array($property_value)));
	}
	
	function addEditFontStyle($config, $filter = array()){
		
		foreach($filter as $filter_k=>$filter_v){
			
			if(in_array($filter_v, array(100, 200, 300, 400, 500, 600, 700, 800, 900))){
				$filter[] = 'normal'; // Regular/Normal may not be available in the official font variants, however it still must be available in the dropdown for font weights like 300 or 700 (open sans condensed does not include "regular")
			}
			
			if(in_array($filter_v, array('100italic','200italic','300italic','400italic','500italic','600italic','700italic','800italic','900italic'))){
				$filter[] = 'italic'; // Regular/Normal may not be available in the official font variants, however it still must be available in the dropdown for font styles like 300italic (open sans condensed does not include "italic" but includes 300italic)
			}
			
			$filter[$filter_k] = str_replace(array('regular'), array('normal'), $filter_v);
		}
		
		$select_attr_data = isset($config['data_attr']) ? $this->buildDataAttr($config['data_attr']) : '';
		$select_attr_id = isset($config['fontstyle_select_id']) ? 'id="'.$config['fontstyle_select_id'].'"' : '';
		
		$property_value = '<select class="cfgenwp-fontstyle-select" '.$select_attr_data.' '.$select_attr_id.'>';
		
		foreach($this->fontstyle_list as $fontstyle_v){

			$fontstyle_selected = '';
			
			if($fontstyle_v == $config['fontstyle_value']){
				$fontstyle_selected = $this->selected;
			}
			
			if($filter && in_array($fontstyle_v, $filter)){
				$property_value .= $this->buildSelectOption($fontstyle_v, $fontstyle_v, $fontstyle_selected);
			}
		}
		
		$property_value .= '</select>';
		
		return array(array('name'=>'Font style', 'values'=>array($property_value)));

	}

	function addEditAlignment($element){

		// Label alignment
		$this->editorpanel->createPanel('Label alignment');
		
		$html_id = 'cfgenwp-label-alignment-'.$_SESSION['cfgenwp_form_element_id'];
		
		$edit_align_label_left = (isset($element['label']['css']['default']['text-align']) && $element['label']['css']['default']['text-align'] == 'left') ? $this->checked : '';
		$edit_align_label_right = (isset($element['label']['css']['default']['text-align']) && $element['label']['css']['default']['text-align'] == 'right') ? $this->checked : '';

		$edit_align_label_top = '';
		
		// if no text-align property => vertical alignment
		if(!$edit_align_label_left && !$edit_align_label_right){
			$edit_align_label_top = $this->checked; 
			$label_width_c_show = false;
		} else{
			$label_width_c_show = true;
		}
		
		$html_label_alignment[] = '<input type="radio" name="'.$html_id.'" id="'.$html_id.'-1" class="cfgenwp-label-alignment" value="top" '.$edit_align_label_top.'><label for="'.$html_id.'-1">Top-aligned label</label>';
		$html_label_alignment[] = '<input type="radio" name="'.$html_id.'" id="'.$html_id.'-2" class="cfgenwp-label-alignment" value="left" '.$edit_align_label_left.'><label for="'.$html_id.'-2">Left-aligned label</label>';
		$html_label_alignment[] = '<input type="radio" name="'.$html_id.'" id="'.$html_id.'-3" class="cfgenwp-label-alignment" value="right" '.$edit_align_label_right.'><label for="'.$html_id.'-3">Right-aligned label</label>';
		
		$this->editorpanel->addProperty( array(  array('values'=>$html_label_alignment)  ) );

		$this->editorpanel->getEditor();


		// Label width
		$this->editorpanel->createPanel('Label width', $label_width_c_show);
		
		$slider_width_id = 'cfgenwp-label-width-slider-'.$_SESSION['cfgenwp_form_element_id'];
		$slider_width_value = $this->elementHasCssProperty($element, 'label', 'width') ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'label', 'width')) : $this->getNumbersOnly($this->label_align_left_width);
		?>
		<script>
		jQuery(function(){
			jQuery('#<?php echo $slider_width_id;?>').slider(
			{
				range: 'min',
				min: <?php echo $this->slider_width_min; ?>,
				max: <?php echo $this->slider_width_max; ?>,
				value: <?php echo $slider_width_value; ?>,
				step: 1
			}).on('slide slidechange', 
						function(event, ui){
							jQuery(this).cfgen_sliderUpdateInputValue(ui.value).cfgen_sliderLabelWidth(ui.value);
						});
		});
		</script>
		<?php
		$html_label_width = '<input type="text" class="cfgenwp-input-label-width-value cfgenwp-slider-input-value" value="'.$slider_width_value.'" >px'
							.'<div id="'.$slider_width_id.'"></div>';
		
		$this->editorpanel->addProperty( array(  array('name'=>'Width', 'values'=>array($html_label_width))  ) );

		$this->editorpanel->getEditor();

		
		if($element['type'] === 'radio' || $element['type'] === 'checkbox'){
		
			$edit_align_option_left = (isset($element['option']['container']['css']['default']['float']) && $element['option']['container']['css']['default']['float'] === 'left') ? $this->checked : '';

			$edit_align_option_top = '';
			
			// if no text-align property => vertical alignment
			if(!$edit_align_option_left){
				$edit_align_option_top = $this->checked; 
				$option_width_c_show = false;
			} else{
				$option_width_c_show = true;
			}
			
			// Options alignment
			$this->editorpanel->createPanel('Options alignment');
			
			$html_id = 'cfgenwp-option-alignment-'.$_SESSION['cfgenwp_form_element_id'];
			
			$html_option_alignment[] = '<input type="radio" name="'.$html_id.'" id="'.$html_id.'-1" class="cfgenwp-option-alignment" value="top" '.$edit_align_option_top.'><label for="'.$html_id.'-1">Top-aligned option</label>';
			$html_option_alignment[] = '<input type="radio" name="'.$html_id.'" id="'.$html_id.'-2" class="cfgenwp-option-alignment" value="left" '.$edit_align_option_left.'><label for="'.$html_id.'-2">Left-aligned option</label>';
			
			$this->editorpanel->addProperty( array(  array('name'=>'', 'values'=>$html_option_alignment)  ) );

			$this->editorpanel->getEditor();
			
			
			// Options width
			$this->editorpanel->createPanel('Options width', $option_width_c_show);
			
			$slider_width_id = 'cfgenwp-option-width-slider-'.$_SESSION['cfgenwp_form_element_id'];
			$slider_width_value = !empty($element['option']['container']['css']['default']['width']) ? $this->getNumbersOnly($element['option']['container']['css']['default']['width']) : $this->getNumbersOnly($this->getCssPropertyDefaultValue('option', 'width'));
			?>
			<script>
			jQuery(function(){
				jQuery('#<?php echo $slider_width_id;?>').slider(
				{
					range: 'min',
					min: <?php echo $this->slider_width_min; ?>,
					max: <?php echo $this->slider_width_max; ?>,
					value: <?php echo $slider_width_value; ?>,
					step: 1,
					change: function(event, ui){
						jQuery(this).cfgen_closestFbElementCont().find('.cfgen-option-content').css({'width':ui.value});
					},
					slide: function(event, ui){
						jQuery(this).cfgen_closestFbElementCont().find('.cfgen-option-content').css({'width':ui.value}).addClass('cfgenwp-slidertracker-width');
					},
					stop: function(event, ui){
						jQuery(this).cfgen_closestFbElementCont().find('.cfgen-option-content').removeClass('cfgenwp-slidertracker-width');
					}
				}).on('slide slidechange', 
							function(event, ui){
								jQuery(this).cfgen_sliderUpdateInputValue(ui.value).cfgen_closestFbElementCont().cfgen_adjustElementHeightToLeftContent();
							});
			});
			</script>
			<?php
			$html_option_width = '<input type="text" class="cfgenwp-input-option-width-value cfgenwp-slider-input-value" value="'.$slider_width_value.'">px'
								.'<div id="'.$slider_width_id.'"></div>';
								
			$this->editorpanel->addProperty( array(  array('name'=>'Width', 'values'=>array($html_option_width))  ) );

			$this->editorpanel->getEditor();
			
			
			// OPTIONS MARGIN TOP
			$option_margintop_c_show = ($edit_align_label_left || $edit_align_label_right) ? true : false;
			
			/* padding and not margin because of table-cell display */
			$slider_margintop_value = !empty($element['element-set-c']['css']['default']['padding-top']) ? $this->getNumbersOnly($element['element-set-c']['css']['default']['padding-top']) : $this->getNumbersOnly($this->getCssPropertyDefaultValue('option', 'padding-top'));
			
			$this->editorpanel->createPanel('Options margin', $option_margintop_c_show);
			
			$slider_option_margintop = $this->addSelectSlider(array(
																	'slider_id'=>'cfgenwp-option-margintop-slider-'.$_SESSION['cfgenwp_form_element_id'],
																	'slider_function'=>'cfgen_sliderOptionMarginTop',
																	'select_class'=>'cfgenwp-option-margintop-select',
																	'option_min'=>$this->slider_margintop_min,
																	'option_max'=>$this->slider_margintop_max,
																	'option_selected'=>$slider_margintop_value,
																	));

			$this->editorpanel->addProperty( array(  array('name'=>'Top margin', 'values'=>array($slider_option_margintop))  ) );

			$this->editorpanel->getEditor();
			
		} // if type radio or checkbox
	}
	
	function addEditFormField($element){
		
		$type = $element['type'];


		// FORM VALIDATION
		$types_for_form_validation = array('checkbox', 'date', 'email', 'radio', 'rating', 'select', 'selectmultiple', 'terms', 'text', 'textarea', 'upload', 'url');
		$types_for_validation_required = array('checkbox', 'date', 'email', 'radio', 'rating', 'select', 'selectmultiple', 'text', 'textarea', 'upload', 'url');

		if(in_array($type, $types_for_form_validation)){
			
			$this->editorpanel->createPanel('Field validation');			
			
			// EMAIL VALIDATION
			if($type === 'email'){
				$html_validation[] = '<input type="checkbox" '.$this->checked.' '
										   .'id="cfgenwp-label-validation-email-'.$_SESSION['cfgenwp_form_element_id'].'" '.$this->disabled.'>'
									.'<label for="cfgenwp-label-validation-email-'.$_SESSION['cfgenwp_form_element_id'].'">A valid email address will be required</label>';
			}
			
			// URL VALIDATION
			if($type === 'url'){
				$html_validation[] = '<input type="checkbox" '.$this->checked.' '
										   .'id="cfgenwp-label-validation-url-'.$_SESSION['cfgenwp_form_element_id'].'" '.$this->disabled.'>'
									.'<label for="cfgenwp-label-validation-url-'.$_SESSION['cfgenwp_form_element_id'].'">A valid URL will be required</label>';
			}

			// TERMS VALIDATION
			if($type === 'terms'){

				if(!empty($element['id'])){
					$terms_required_checked = !empty($element['required']) ? $this->checked : '';
				} else{
					$terms_required_checked = $this->checked;
				}
				
				$html_validation[] = '<input type="checkbox" class="cfgenwp-validation-terms" '.$terms_required_checked.' '
										   .'id="cfgenwp-label-validation-terms-'.$_SESSION['cfgenwp_form_element_id'].'">'
									.'<label for="cfgenwp-label-validation-terms-'.$_SESSION['cfgenwp_form_element_id'].'">The "Terms & Conditions" checkbox must be checked</label>';
			}
			
			// REQUIRED VALIDATION
			if(in_array($type, $types_for_validation_required)){
			
				if(in_array($type, array('email', 'url'))){

					if(!empty($element['id'])){
						$requiredfield_checked = !empty($element['required']) ? $this->checked : '';
					} else{
						$requiredfield_checked = $this->checked;
					}

				} else{
					$requiredfield_checked = !empty($element['required']) ? $this->checked : '';
				}
				
				$requiredfield_label = 'This field cannot be left blank';
			
				$html_validation[] = '<input type="checkbox" class="cfgenwp-validation-required" '.$requiredfield_checked.' '
										   .'id="cfgenwp-label-validation-required-'.$_SESSION['cfgenwp_form_element_id'].'">'
									.'<label for="cfgenwp-label-validation-required-'.$_SESSION['cfgenwp_form_element_id'].'">'.$requiredfield_label.'</label>';
			}
			
			$this->editorpanel->addProperty( array(  array('values'=>$html_validation)  ) );
			
			$this->editorpanel->getEditor();
		}

		// ADD TITLE EDIT
		if($type == 'title'){
	
			$edit_element_value = isset($element['title']['value']) ? $element['title']['value'] : $this->title_default_value;
			
			$input = '<input type="text" class="cfgenwp-input-100 cfgenwp-edit-title-value" value="'.$this->htmlentities($edit_element_value).'" >';

			$this->editorpanel->createPanel('Title');

			$this->editorpanel->addProperty( array(  array('values'=>array($input))  ) );

			$this->editorpanel->getEditor();
		}
		
		// ADD SUBMIT EDIT
		if($type == 'submit'){
			$edit_element_value = isset($element['input']['value']) ? $element['input']['value'] : $this->submit_default_value;
			
			$input = '<input type="text" class="cfgenwp-input-100 cfgenwp-edit-submit-value" value="'.$this->htmlentities($edit_element_value).'" >';

			$this->editorpanel->createPanel('Button value');

			$this->editorpanel->addProperty( array(  array('values'=>array($input))  ) );

			$this->editorpanel->getEditor();
		}
		
		// ADD LABEL EDIT
		if(in_array($type, array('captcha', 'checkbox', 'date', 'email', 'radio', 'rating', 'select', 'selectmultiple', 'upload', 'url', 'time', 'text', 'textarea', 'url'))){

			$this->editorpanel->createPanel('Label');
			
			// Label
			if(!empty($element['id'])){
				if(isset($element['label']['value'])){
					$edit_label_value = $element['label']['value'];
				} else{
					$edit_label_value = '';
				}
			} else{
				$edit_label_value = $this->labels[$type];
			}
			
			$html_label_value = '<input type="text" class="cfgenwp-input-100 cfgenwp-edit-label-value" value="'.$this->htmlentities($edit_label_value).'" >';
			
			$label_property_name = in_array($type, array('captcha', 'date', 'email', 'text', 'textarea', 'url')) ? 'Label outside input' : '';
			
			$this->editorpanel->addProperty( array(  array('name'=>$label_property_name, 'values'=>array($html_label_value)),  ) );
			
			
			// Placeholder
			if(in_array($type, array('captcha', 'date', 'email', 'text', 'textarea', 'url'))){
				
				$html_label_hide_id = 'cfgenwp-label-hide-'.$_SESSION['cfgenwp_form_element_id'];
				
				$placeholder_value = (!empty($element['input']['placeholder'])) ? $this->htmlEntities($element['input']['placeholder']) : '';
				$html_placeholder_value = '<input type="text" class="cfgenwp-input-100 cfgenwp-edit-placeholder-value" value="'.$placeholder_value.'">';
				
				$this->editorpanel->addProperty( array(  array('name'=>'Label inside input', 'values'=>array($html_placeholder_value))  ) );

			}
			
			$this->editorpanel->getEditor();
		}
		
		
		// ADD HIDDEN EDIT
		if($type === 'hidden'){
			
			$inputhidden_value = isset($element['hidden']['value']) ? $element['hidden']['value'] : '';
			
			$edit_element_label = isset($element['label']['value']) ? $element['label']['value'] : '';
			
			// HIDDEN INPUT FIELD NAME
			$input = '<input type="text" class="cfgenwp-input-100 cfgenwp-edit-label-value" value="'.$this->htmlentities($edit_element_label).'">';

			$this->editorpanel->createPanel('Field name');

			$this->editorpanel->addProperty( array(  array('values'=>array($input)) ) );

			$this->editorpanel->getEditor();
			
			// HIDDEN INPUT VALUE
			$input = '<input type="text" class="cfgenwp-input-100 cfgenwp-hidden-input-value" value="'.$this->htmlentities($inputhidden_value).'">';

			$this->editorpanel->createPanel('Hidden input value');

			$this->editorpanel->addProperty( array(  array('values'=>array($input))  ) );

			$this->editorpanel->getEditor();
		}

		// ADD IMAGE EDIT
		if($type === 'image'){

			$edit_img_url = !empty($element['url']) ? $element['url'] : '';
			$element_name = !empty($element['id']) ? $element['id'] : $this->htmlElementName($_SESSION['cfgenwp_form_element_id']);
			
			if(!empty($element['id']) && !empty($element['filename'])){
				$uploadsuccesscontainer_style = '';
				$uploadsuccesscontainer_filename = $element['filename'];
			} else{
				$uploadsuccesscontainer_style = ' display:none; ';
				$uploadsuccesscontainer_filename = '';
			}
			?>

			<?php echo $this->openEditProperties();?>

				<?php echo $this->elementSettingsTitle('Image URL');?>

				<div class="cfgenwp-e-property-c">
					
					<input type="text" class="cfgenwp-image-edit-url" value="<?php echo $edit_img_url;?>" ><input type="button" value="Add image" class="cfgenwp-addimagefromurl" >
					
				</div>

			</div>

			<?php echo $this->openEditProperties();?>
				
				<?php echo $this->elementSettingsTitle('Upload image');?>
				
				<div class="cfgenwp-e-property-c">
				<?php				
				if($this->demo == 1){
					echo '<p>You are currently using a demo version of Contact Form Generator.</p><p>The upload function is only available in the full version.</p>';
				} else{
					if(!$this->isWritable('../'.$this->dir_upload)){?>
						<div style="margin:0 0 4px 0"><span style="color:#ff0033">Installation warning</span> : set the permission to '755' on the 'editor/<?php echo substr($this->dir_upload, 0, -1);?>' directory on your server to make the image upload work (set the permission to '777' if it does not work otherwise).</div>
						<?php
					}
					?>
					<div class="" id="fsUploadProgress-<?php echo $element_name;?>">
						
						<div class="uploadsuccess-container" style=" <?php echo $uploadsuccesscontainer_style;?>">

							<span class="uploadimagehtmlfilename"><?php echo $uploadsuccesscontainer_filename;?></span>
							<input type="hidden" class="uploadimagefilename" value="<?php echo $uploadsuccesscontainer_filename;?>" ><!-- used to delete the image -->
							<span class="cfgenwp-delimagefromupload">Delete</span>
							<img src="img/loading.gif" class="uploadimageloading" style="display:none" >

						</div>

					</div>
					
					<div>
						<span id="spanButtonPlaceHolder-<?php echo $element_name;?>"></span>
						<input id="btnCancel-<?php echo $element_name;?>" type="button" value="Cancel Upload" onClick="swfu.cancelQueue();" disabled="disabled" style="display:none;margin-left: 2px; font-size: 8pt; height: 29px;" >
					</div>
					
					<script type="text/javascript">
					var swfu;
					
					jQuery(function(){
						var settings = {
										flash_url : "js/swfupload/swfupload.swf",
										upload_url: "inc/uploadimage.php",
										post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
										file_size_limit : "100 MB",
										file_types : "<?php echo $this->swfupload_authorized_ext;?>",
										file_types_description : "All Files",
										file_upload_limit : 0,
										file_queue_limit : 0,
										custom_settings : {
											progressTarget : "fsUploadProgress-<?php echo $element_name;?>",
											cancelButtonId : "btnCancel-<?php echo $element_name;?>"
										},
										debug: false,
								
										// Button settings
										button_image_url: "img/upload-button.png",
										button_width: "130",
										button_height: "31",
										button_placeholder_id: "spanButtonPlaceHolder-<?php echo $element_name;?>",
										
										button_action:SWFUpload.BUTTON_ACTION.SELECT_FILE, // when the Flash button is clicked the file dialog will only allow a single file to be selected
										button_cursor: SWFUpload.CURSOR.HAND,
								
										// The event handler functions are defined in handlers.js
										file_queued_handler : fileQueued,
										file_queue_error_handler : fileQueueError,
										file_dialog_complete_handler : fileDialogComplete,
										upload_start_handler : uploadStart,
										upload_progress_handler : uploadProgress,
										upload_error_handler : uploadError,
										upload_success_handler : uploadSuccess, // uploadSuccess in handlers.js
										upload_complete_handler : uploadComplete // FileProgress.prototype.setComplete in fileprogress.js
									};
									/* queue_complete_handler : queueComplete	// queueComplete in handlers.js, Queue plugin event */

						swfu = new SWFUpload(settings);
					 });
					</script>
				<?php
				}
				?>
				</div><!-- property -->
			</div>

		<?php
		}


		// ADD OPTIONS ADD RADIO ADD CHECKBOX ADD SELECT EDIT
		if(in_array($type, array('radio', 'checkbox', 'select', 'selectmultiple'))){?>
		
			<?php echo $this->openEditProperties();?>
				
				<?php echo $this->elementSettingsTitle('List of choices');?>
				
				<div class="cfgenwp-e-property-c cfgenwp-options-editor-c" style="overflow:auto; max-height:250px;">
					<?php
					if(!empty($element['option']['set'])){
						foreach($element['option']['set'] as $edit_element_option_set){
							echo $this->divEditOptionContainer($type, $edit_element_option_set['value'], $edit_element_option_set['checked']);
						}
					}
					else{
						for($i=1; $i<=3; $i++){
							echo $this->divEditOptionContainer($type, $this->option_default_value, '');
						}
					}
					?>
				</div><!-- property -->
				
			</div><!-- properties -->
			<?php
		}

		// ADD INPUT EDIT WIDTH EDIT HEIGHT
		if(in_array($type, array('captcha', 'date', 'email', 'submit', 'text', 'textarea', 'url'))){
			
			if($type === 'submit'){
				$panel_title = 'Button dimensions';
			} else{
				$panel_title = 'Input dimensions';
			}

			$this->editorpanel->createPanel($panel_title);

			if(in_array($type, array('captcha', 'date', 'email', 'submit', 'text', 'textarea', 'url'))){

				$slider_width_id = 'cfgenwp-element-width-slider-'.$_SESSION['cfgenwp_form_element_id'];
				
				$slider_width_value = !empty($element['id']) 
									  ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'input-group-c', 'max-width')) 
									  : $this->getNumbersOnly($this->getCssPropertyDefaultValue($type, 'width', 'element-set-c'));
				
				if($type === 'captcha'){
					$slider_width_min = $this->slider_settings['captcha']['width']['min'];
				} else{
					$slider_width_min = $this->slider_width_min;
				}
				?>
				<script>
				jQuery(function(){
					jQuery('#<?php echo $slider_width_id;?>').slider(
					{
						range: 'min',
						min: <?php echo $slider_width_min; ?>,
						max: <?php echo $this->slider_width_max; ?>,
						value: <?php echo $slider_width_value; ?>,
						step: 1
					}).on('slide slidechange', 
							function(event, ui){
								jQuery(this).cfgen_sliderUpdateInputValue(ui.value).cfgen_sliderInputWidth(ui.value);
							});
				});
				</script>			
				<?php
				$input = '<input type="text" class="cfgenwp-element-width-input-value cfgenwp-slider-input-value" value="'.$slider_width_value.'">px'
						.'<div id="'.$slider_width_id.'" data-cfgenwp_slider_target="'.$type.'"></div>';
				
				$this->editorpanel->addProperty( array(  array('name'=>'Width', 'values'=>array($input))  ) );
			}


			// ADD TEXTAREA HEIGHT EDIT
			if(in_array($type, array('submit', 'textarea'))){
				
				$slider_height_id = 'cfgenwp-element-height-slider-'.$_SESSION['cfgenwp_form_element_id'];

				// Using an html id because the slider may control a textarea or a submit button
				$slider_height_target_id = !empty($element['id']) ? $element['id'] : $this->htmlElementName($_SESSION['cfgenwp_form_element_id']);
				
				$slider_height_value = !empty($element['id']) ? $this->getNumbersOnly($this->getCssPropertyValue($element, ($type === 'submit' ? $type : 'input'), 'height')) : $this->getNumbersOnly($this->getCssPropertyDefaultValue($type, 'height'));
				$slider_height_min_value = $this->slider_settings[$type]['height']['min'];
				$slider_height_max_value = $this->slider_settings[$type]['height']['max'];
				?>
				<script>
				jQuery(function(){
					jQuery('#<?php echo $slider_height_id;?>').slider(
					{
						range: 'min',
						min: <?php echo $slider_height_min_value; ?>,
						max: <?php echo $slider_height_max_value; ?>,
						value: <?php echo $slider_height_value; ?>,
						step: 1
					}).on('slide slidechange', 
							function(event, ui){
								jQuery(this).cfgen_sliderInputHeight('#<?php echo $slider_height_target_id;?>', ui.value);
								jQuery(this).cfgen_sliderUpdateInputValue(ui.value).cfgen_closestFbElementCont().cfgen_adjustElementHeightToLeftContent();
							});
				});
				</script>
				
				<?php
				$input = '<input type="text" '
							   .'class="cfgenwp-element-height-input-value cfgenwp-slider-input-value" '
							   .'value="'.$slider_height_value.'">px'
						.'<div id="'.$slider_height_id.'" data-cfgenwp_slider_target="'.$type.'"></div>';
						
				$this->editorpanel->addProperty( array(  array('name'=>'Height', 'values'=>array($input))  ) );
			}
			
			$this->editorpanel->getEditor();
		}
		
		// ADD SEPARATOR HEIGHT EDIT
		if($type === 'separator'){

			$this->editorpanel->createPanel('Separator dimensions');

			$slider_height_value = !empty($element['id']) ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'separator', 'height')) : $this->getNumbersOnly($this->getCssPropertyDefaultValue('separator', 'height'));
			$slider_height_min_value = $this->slider_settings[$type]['height']['min'];
			$slider_height_max_value = $this->slider_settings[$type]['height']['max'];

			$slider_separator_height = $this->addSelectSlider(array(
																	'slider_id'=>'cfgenwp-separator-height-slider-'.$_SESSION['cfgenwp_form_element_id'],
																	'slider_function'=>'cfgen_sliderSeparatorHeight',
																	'select_class'=>'cfgenwp-separator-height-value',
																	'option_min'=>$slider_height_min_value, 
																	'option_max'=>$slider_height_max_value, 
																	'option_selected'=>$slider_height_value,
																	));

			$this->editorpanel->addProperty( array(  array('name'=>'Height', 'values'=>array($slider_separator_height))  ) );
			
			$this->editorpanel->getEditor();
		}


		// ADD DATE EDIT
		if($type === 'date'){
			
			$this->editorpanel->createPanel('Date format');
			
			// Format
			$edit_dateformat = !empty($element['datepicker']['format']) ? $element['datepicker']['format'] : $this->datepicker_formats[$this->datepicker_default_format];
			
			$html_datepicker_format = '<select class="cfgenwp-datepicker-format">';
			
			foreach($this->datepicker_formats as $datepicker_option=>$datepicker_value){
				$selected_datepicker = ($datepicker_value == $edit_dateformat) ? $this->selected : '';
				$html_datepicker_format .= '<option value="'.$datepicker_value.'" '.$selected_datepicker.' >'.$datepicker_option.'</option>';
			}
			
			$html_datepicker_format .= '</select>';

			$this->editorpanel->addProperty( array(  array('name'=>'Format', 'values'=>array($html_datepicker_format))  ) );


			// First day of the week
			$edit_firstdayoftheweek = isset($element['datepicker']['firstdayoftheweek']) ? $element['datepicker']['firstdayoftheweek'] : $this->datepicker_firstdayoftheweek_default;
				// ^-- check on isset only, if($element['firstdayoftheweek']) would fail when firstdayoftheweek = 0 for Sunday

			$html_datepicker_firstdayoftheweek = '<select class="cfgenwp-datepicker-firstdayoftheweek">';

			foreach($this->datepicker_firstdayoftheweek as $cfgenwp_fdotw_k=>$cfgenwp_fdotw_v){
				
				$cfgenwp_fdotw_selected = ($edit_firstdayoftheweek == $cfgenwp_fdotw_k) ? $this->selected : '';
				
				$html_datepicker_firstdayoftheweek .= '<option value="'.$cfgenwp_fdotw_k.'" '.$cfgenwp_fdotw_selected.' >'.$cfgenwp_fdotw_v.'</option>';
				
			}

			$html_datepicker_firstdayoftheweek .= '</select>';

			$this->editorpanel->addProperty( array(  array('name'=>'First day of the week', 'values'=>array($html_datepicker_firstdayoftheweek))  ) );


			// Language
			$edit_datelanguage = !empty($element['datepicker']['regional']) ? $element['datepicker']['regional'] : $this->datepicker_language[$this->datepicker_default_language];
			
			$html_datepicker_language = '<select class="cfgenwp-datepicker-language">';
			
			foreach($this->datepicker_language as $datepickerlanguage_option=>$datepickerlanguage_value){
				$selected_datepickerlanguage = ($datepickerlanguage_value == $edit_datelanguage) ? $this->selected: '';
				$html_datepicker_language .= '<option value="'.$datepickerlanguage_value.'" '.$selected_datepickerlanguage.' >'.$datepickerlanguage_option.'</option>';
			}
			
			$html_datepicker_language .= '</select>';
			
			$this->editorpanel->addProperty( array(  array('name'=>'Language', 'values'=>array($html_datepicker_language))  ) );

			
			// Disable days of the week
			$html_datepicker_disabledaysoftheweek = '';
			
			// Javascript: week starts on Sunday (0)
			$daysoftheweek = array(1=>'M', 2=>'T', 3=>'W', 4=>'T', 5=>'F', 6=>'S', 0=>'S');
			$daysoftheweek_disabled = !empty($element['datepicker']['disabledaysoftheweek']) ? $element['datepicker']['disabledaysoftheweek'] : array();
			foreach($daysoftheweek as $dotw_k=>$dotw_v){
				
				$checked  = '';
				
				$label_dotw = 'cfgenwp-date-daysoftheweek-'.$_SESSION['cfgenwp_form_element_id'].'-'.$dotw_k;
				
				if(in_array($dotw_k, $daysoftheweek_disabled)){
					$checked = $this->checked;
				}
				
				$html_datepicker_disabledaysoftheweek .= '<div class="cfgenwp-daysoftheweek">'
														.'<input type="checkbox" class="cfgenwp-date-disabledaysoftheweek" '
																.'value="'.$dotw_k.'" '
																.'id="'.$label_dotw.'" '.$checked.'>'
																.'<label for="'.$label_dotw.'">'.$dotw_v.'</label>'
														.'</div>';

			}

			$this->editorpanel->addProperty( array(  array('name'=>'Disable days of the week', 'values'=>array($html_datepicker_disabledaysoftheweek))  ) );

			// Min. Date
			
			$mindate_radio_name = 'cfgenwp-date-mindate-'.$_SESSION['cfgenwp_form_element_id'];
			
			// Disable past dates
			$html_datepicker_mindate_disablepastdates = 
			"<script>
				jQuery(function(){
					
					jQuery('.cfgenwp-date-mindatecustom-v, .cfgenwp-date-maxdatecustom-v').datepicker(jQuery.datepicker.regional['en-GB']);
					jQuery('.cfgenwp-date-mindatecustom-v, .cfgenwp-date-maxdatecustom-v').datepicker('option', 'dateFormat', 'yy-mm-dd');
					jQuery('.cfgenwp-date-mindatecustom-v, .cfgenwp-date-maxdatecustom-v').datepicker('option', 'changeMonth', true);
					jQuery('.cfgenwp-date-mindatecustom-v, .cfgenwp-date-maxdatecustom-v').datepicker('option', 'changeYear', true);
					jQuery('.cfgenwp-date-mindatecustom-v, .cfgenwp-date-maxdatecustom-v').datepicker('option', 'yearRange', '-70:+70');

				});
			</script>";// Min Date and Max Date config datepickers, using $('body').on('focusin' in editor js file is buggy

			
			$label_disablepastdates = 'cfgenwp-date-disablepastdates-'.$_SESSION['cfgenwp_form_element_id'];
			$checked_disablepastdates = !empty($element['datepicker']['disablepastdates']) ? $this->checked : '';

			$html_datepicker_mindate_disablepastdates .= '<input type="radio" class="cfgenwp-date-disablepastdates cfgenwp-date-mindate" '
															   .'name="'.$mindate_radio_name.'" '
															   .'id="'.$label_disablepastdates.'" '.$checked_disablepastdates.'>'
														.'<label for="'.$label_disablepastdates.'">Disable past dates</label>';
			// Custom min. date
			$mindatecustom_label = 'cfgenwp-date-mindatecustom-'.$_SESSION['cfgenwp_form_element_id'];
			$mindatecustom_checked = !empty($element['datepicker']['mindate']) ? $this->checked : '';
			$mindatecustom_value = !empty($element['datepicker']['mindate']) ? $element['datepicker']['mindate'] : '';
			
			$html_datepicker_mindate_custommindate = "<script>jQuery(function(){jQuery('.cfgenwp-date-mindatecustom-v').datepicker('setDate', '".$mindatecustom_value."');});</script>";
			$html_datepicker_mindate_custommindate .= '<input type="radio" class="cfgenwp-date-mindatecustom cfgenwp-date-mindate" '
															.'name="'.$mindate_radio_name.'" id="'.$mindatecustom_label.'" '.$mindatecustom_checked.'>'
													 .'<label for="'.$mindatecustom_label.'">Custom min. date</label>'
													 .'<input type="text" class="cfgenwp-input-100 cfgenwp-date-mindatecustom-v cfgenwp-date-minmax-radiocontroller" '
															.'value="'.$this->htmlentities($mindatecustom_value).'">';
			
			// Current year minus
			$label_yearrange_min = 'cfgenwp-date-yearrange-currentyearminus-'.$_SESSION['cfgenwp_form_element_id'];
			$yearrangemin_checked = (isset($element['datepicker']['yearrange']['minus']) && ($element['datepicker']['yearrange']['minus'] || $element['datepicker']['yearrange']['minus'] === 0)) 
													? $this->checked : '';
			$yearrangemin_value = (isset($element['datepicker']['yearrange']['minus']) && ($element['datepicker']['yearrange']['minus'] || $element['datepicker']['yearrange']['minus'] === 0)) 
													? $element['datepicker']['yearrange']['minus'] : $this->datepicker_default_yearrange_minus;
			// default checked setting
			if(!$checked_disablepastdates && !$mindatecustom_checked){
				$yearrangemin_checked = $this->checked;
			}
			
			$html_datepicker_mindate_currentyearminus = '<input type="radio" class="cfgenwp-date-yearrange-currentyearminus cfgenwp-date-mindate" name="'.$mindate_radio_name.'" '
																.'id="'.$label_yearrange_min.'" '.$yearrangemin_checked.'>'
														.'<label for="'.$label_yearrange_min.'">Current year –</label>';
			
			$html_datepicker_mindate_currentyearminus .= '<select class="cfgenwp-date-yearrange-currentyearminus-v cfgenwp-date-minmax-radiocontroller cfgenwp-select-2digits">';
			
			for($yearrange_i = 0; $yearrange_i <= $this->datepicker_default_yearrange_max; $yearrange_i++){
				$selected = ($yearrange_i == $yearrangemin_value ? $this->selected : '');
				$html_datepicker_mindate_currentyearminus .= '<option value="'.$yearrange_i.'" '.$selected.'>'.$yearrange_i.'</option>';
			}
			
			$html_datepicker_mindate_currentyearminus .= '</select>';
			
			
			$this->editorpanel->addProperty( array(  array('name'=>'Min. Date', 'values'=>array($html_datepicker_mindate_disablepastdates, $html_datepicker_mindate_custommindate, $html_datepicker_mindate_currentyearminus))  ) );
			
			// Max. Date
			
			// Custom max. date
			$maxdate_radio_name = 'cfgenwp-date-maxdate-'.$_SESSION['cfgenwp_form_element_id'];
			$maxdatecustom_label = 'cfgenwp-date-maxdatecustom-'.$_SESSION['cfgenwp_form_element_id'];
			$maxdatecustom_checked = !empty($element['datepicker']['maxdate']) ? $this->checked : '';
			$maxdatecustom_value = !empty($element['datepicker']['maxdate']) ? $element['datepicker']['maxdate'] : '';

			$html_datepicker_maxdate_custommaxdate = "<script>jQuery(function(){jQuery('.cfgenwp-date-maxdatecustom-v').datepicker('setDate', '".$maxdatecustom_value."');});</script>";
			$html_datepicker_maxdate_custommaxdate .= '<input type="radio" class="cfgenwp-date-maxdatecustom cfgenwp-date-maxdate" '
															.'name="'.$maxdate_radio_name.'" id="'.$maxdatecustom_label.'" '.$maxdatecustom_checked.'>'
													 .'<label for="'.$maxdatecustom_label.'">Custom max. date</label>'
													 .'<input type="text" class="cfgenwp-input-100 cfgenwp-date-maxdatecustom-v cfgenwp-date-minmax-radiocontroller" value="'.$this->htmlentities($maxdatecustom_value).'">';
			
			// Current year plus
			$label_yearrange_max = 'cfgenwp-date-yearrange-maxvalue-'.$_SESSION['cfgenwp_form_element_id'];
			$yearrangemax_checked = (isset($element['datepicker']['yearrange']['plus']) && ($element['datepicker']['yearrange']['plus'] || $element['datepicker']['yearrange']['plus'] === 0)) 
										? $this->checked : '';
			$yearrangemax_value = (isset($element['datepicker']['yearrange']['plus']) && ($element['datepicker']['yearrange']['plus'] || $element['datepicker']['yearrange']['plus'] === 0)) 
										? $element['datepicker']['yearrange']['plus'] : $this->datepicker_default_yearrange_plus;
							
			// default checked setting
			if(!$maxdatecustom_checked){
				$yearrangemax_checked = $this->checked;
			}
			
			$html_datepicker_mindate_currentyearplus = '<input type="radio" class="cfgenwp-date-yearrange-currentyearplus cfgenwp-date-maxdate" '
															 .'name="'.$maxdate_radio_name.'" id="'.$label_yearrange_max.'" '.$yearrangemax_checked.'>'
													  .'<label for="'.$label_yearrange_max.'">Current year +</label>';

			$html_datepicker_mindate_currentyearplus .= '<select class="cfgenwp-date-yearrange-currentyearplus-v cfgenwp-date-minmax-radiocontroller cfgenwp-select-2digits">';

			for($yearrange_i = 0; $yearrange_i <= $this->datepicker_default_yearrange_max; $yearrange_i++){
				$selected = ($yearrange_i == $yearrangemax_value ? $this->selected : '');
				$html_datepicker_mindate_currentyearplus .= '<option value="'.$yearrange_i.'" '.$selected.'>'.$yearrange_i.'</option>';
			}
			
			$html_datepicker_mindate_currentyearplus .= '</select>';
			
			$this->editorpanel->addProperty( array(  array('name'=>'Max. Date', 'values'=>array($html_datepicker_maxdate_custommaxdate, $html_datepicker_mindate_currentyearplus))  ) );

			$this->editorpanel->getEditor();
		}
		
		// ADD TERMS EDIT
		if($type === 'terms'){
			
			$terms_value = isset($element['terms']['value']) ? $element['terms']['value'] : $this->terms_default_value;
			$terms_link = isset($element['terms']['link']) ? $element['terms']['link'] : $this->terms_default_link;
			
			$this->editorpanel->createPanel('Label');

			$input = '<textarea class="cfgenwp-input-100 cfgenwp-edit-terms-value">'.$terms_value.'</textarea>'
					.'<div class="cfgenwp-element-editor-hint">Wrap the words where you want your link to be inside curly brackets: {your text}</div>';

			$this->editorpanel->addProperty( array(  array('values'=>array($input)) ) );
			
			$input = '<input type="text" class="cfgenwp-input-100 cfgenwp-edit-terms-link" value="'.$this->htmlentities($terms_link).'">';
			$this->editorpanel->addProperty( array(  array('name'=>'Link to your page', 'values'=>array($input)) ) );

			$this->editorpanel->getEditor();
		}
		
		// ADD TIME EDIT
		if($type === 'time'){
			
			$html_id = 'timeformat-'.$_SESSION['cfgenwp_form_element_id'];
			
			$edit_time12_check = (isset($element['timeformat']) && $element['timeformat'] == 12) ? $this->checked : '';
			$edit_time24_check = (isset($element['timeformat']) && $element['timeformat'] == 24) ? $this->checked : '';
			
			// default setting
			if(!$edit_time12_check && !$edit_time24_check){
				$edit_time24_check = $this->checked; 
				$edit_time12_check = ''; 
			}
			
			// TIME FORMAT
			$input = array(
							'<input type="radio" name="'.$html_id.'" id="'.$html_id.'-12hourclock" class="cfgenwp-timeformat 12hourclock" value="12" '.$edit_time12_check.'>'
							.'<label for="'.$html_id.'-12hourclock">12-hour clock</label>',
							'<input type="radio" name="'.$html_id.'" id="'.$html_id.'-24hourclock" class="cfgenwp-timeformat 24hourclock" value="24" '.$edit_time24_check.'>'
							.'<label for="'.$html_id.'-24hourclock">24-hour clock</label>'
						);

			$this->editorpanel->createPanel('Time format');

			$this->editorpanel->addProperty( array(  array('values'=>$input)  ) );

			$this->editorpanel->getEditor();

		}
		
		// ADD CAPTCHA EDIT
		if($type === 'captcha'){

			$edit_captchaformat = !empty($element['format']) ? $element['format'] : $this->captcha_default_format;
			$edit_captchalength = !empty($element['length']) ? $element['length'] : $this->captcha_default_length;
			
			$this->editorpanel->createPanel('Captcha settings');
			
			$input = array();
			
			$formats = array(
							'letters'=>'Letters only ',
							'numbers'=>'Numbers only',
							'lettersandnumbers'=>'Letters and numbers',
							);
			
			foreach($formats as $key=>$value){
				
				$checked = ($key==$edit_captchaformat) ? $this->checked : '';
				
				$input[] = '<input type="radio" name="cfgenwp-captchaformat" class="captchaformat '.$key.'" '
								 .'id="captchaformat-'.$key.'" '
								 .'value="'.$key.'" '.$checked.'>'
							.'<label for="captchaformat-'.$key.'">'.$value.'</label>';
			}
			
			$this->editorpanel->addProperty( array(  array('name'=>'Characters', 'values'=>$input)  ) );
			
			// $i can't be > 8 : Warning: array_rand(): Second argument has to be between 1 and the number of elements in the array 
			// there are 8 elements max. in $captcha_number
			$select_captcha_length_options = '';
			
			for($i=3; $i<=8; $i++){
				$selected = ($i == $edit_captchalength) ? $this->selected : '';
				$select_captcha_length_options .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
			}
			$select_captcha_length = '<select id="cfgenwp-captcha-length">'.$select_captcha_length_options.'</select>';
			
			$this->editorpanel->addProperty( array(  array('name'=>'Captcha length', 'values'=>array($select_captcha_length))  ) );
			
			$this->editorpanel->getEditor();
		}
		
		// ADD RATING EDIT
		if($type === 'rating'){

			$this->editorpanel->createPanel('Rating');
			
			// RATING ICON
			$rating_icons_list = array(
										array('id'=>'fa-star', 'unicode'=>'&#xf005;',),
										array('id'=>'fa-star-o', 'unicode'=>'&#xf006;',),
										array('id'=>'fa-heart', 'unicode'=>'&#xf004;',),
										array('id'=>'fa-heart-o', 'unicode'=>'&#xf08a;',),
										array('id'=>'fa-thumbs-up', 'unicode'=>'&#xf164;',),
										array('id'=>'fa-thumbs-o-up', 'unicode'=>'&#xf087;',),
										array('id'=>'fa-check-circle','unicode'=>'&#xf058;',),
										array('id'=>'fa-check-circle-o','unicode'=>'&#xf05d;',),
										array('id'=>'fa-check','unicode'=>'&#xf00c;',),
										array('id'=>'fa-check-square','unicode'=>'&#xf14a;',),
										array('id'=>'fa-check-square-o','unicode'=>'&#xf046;',),
										array('id'=>'fa-thumbs-down','unicode'=>'&#xf165;',),
										array('id'=>'fa-thumbs-o-down','unicode'=>'&#xf088;',),
									);
			
			$html_rating_icon_options = '';
			
			foreach($rating_icons_list as $rating_icon_v){
				
				if(!empty($element['rating'])){
					$selected_rating_icon = $element['rating']['fontawesome_id'] == $rating_icon_v['id'] ? $this->selected : false;
				} else{
					$selected_rating_icon = false;
				}
				
				$html_rating_icon_options .= '<option '.$selected_rating_icon.' value="'.$rating_icon_v['id'].'">'.$rating_icon_v['unicode'].'</option>';
			}			
			
			$html_rating_icon_select = '<select class="cfgenwp-rating-icon-select">'.$html_rating_icon_options.'</select>';
			
			$this->editorpanel->addProperty( array(  array('name'=>'Rating icon type', 'values'=>array($html_rating_icon_select))  ) );
			
			// RATING HOVER COLOR
			$cpicker_rating_color_hover['colorpicker_csspropertyname'] = 'color';
			$cpicker_rating_color_hover['colorpicker_paletteonly'] = true;
			$cpicker_rating_color_hover['colorpicker_input_id'] = 'cfgen-rating-color-hover-'.$_SESSION['cfgenwp_form_element_id'];
			$cpicker_rating_color_hover['colorpicker_color'] = $this->elementHasCssProperty($element, 'rating', 'color', 'hover') ? $this->getCssPropertyValue($element, 'rating', 'color', 'hover') : $this->getCssPropertyDefaultValue('rating', 'color', 'hover');
			$cpicker_rating_color_hover['colorpicker_target'] = 'rating';
			$cpicker_rating_color_hover['colorpicker_class'] = 'cfgenwp-colorpicker-rating-color-hover';
			$this->editorpanel->addProperty( array(  array('name'=>'Hover color', 'values'=>array($this->setUpColorPicker($cpicker_rating_color_hover, true)))  ) );
			
			// RATING DEFAULT COLOR
			$cpicker_rating_color['colorpicker_csspropertyname'] = 'color';
			$cpicker_rating_color['colorpicker_input_id'] = 'cfgen-rating-color-'.$_SESSION['cfgenwp_form_element_id'];
			$cpicker_rating_color['colorpicker_color'] = $this->elementHasCssProperty($element, 'rating', 'color') ? $this->getCssPropertyValue($element, 'rating', 'color') : $this->getCssPropertyDefaultValue('rating', 'color');
			$cpicker_rating_color['colorpicker_target'] = 'rating';
			$cpicker_rating_color['colorpicker_class'] = 'cfgenwp-colorpicker-rating-color';
			$this->editorpanel->addProperty( array(  array('name'=>'Default color', 'values'=>array($this->setUpColorPicker($cpicker_rating_color, true)))  ) );

			// RATING FONT SIZE
			$rating_fontsize_value = $this->elementHasCssProperty($element, 'rating', 'font-size') ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'rating', 'font-size')) : $this->getNumbersOnly($this->getCssPropertyDefaultValue('rating', 'font-size'));
		
			$slider_rating_fontsize = $this->addSelectSlider(array(
																	'slider_id'=>'cfgenwp-rating-fontsize-slider-'.$_SESSION['cfgenwp_form_element_id'],
																	'slider_function'=>'cfgen_sliderRatingFontSize',
																	'select_class'=>'cfgenwp-rating-fontsize-select',
																	'option_min'=>$this->slider_fontsize_min, 
																	'option_max'=>$this->slider_fontsize_max, 
																	'option_selected'=>$rating_fontsize_value,
																	));

			$this->editorpanel->addProperty( array(  array('name'=>'Rating icon size', 'values'=>array($slider_rating_fontsize))  ) );
			
			// MAXIMUM RATING
			$html_rating_max_options = '';
			for($i = 2; $i <= 10; $i++){
				
				if(!empty($element['rating'])){
					$selected_maximum = $element['rating']['maximum'] == $i ? $this->selected : false;
				} else{
					$selected_maximum = $i == $this->rating_default_maximum ? $this->selected : false;
				}
				
				$html_rating_max_options .= '<option '.$selected_maximum.' value="'.$i.'">'.$i.'</option>';
			}
			$html_rating_max_select = '<select class="cfgenwp-rating-maximum">'.$html_rating_max_options.'</select>';
			
			$this->editorpanel->addProperty( array(  array('name'=>'Number of icons', 'values'=>array($html_rating_max_select))  ) );
			
			
			// RATING PADDING RIGHT SPACING
			$slider_paddingright_value = $this->elementHasCssProperty($element, 'rating', 'padding-right') ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'rating', 'padding-right')) : $this->getNumbersOnly($this->getCssPropertyDefaultValue('rating', 'padding-right'));
			
			$slider_rating_paddingright = $this->addSelectSlider(array(
																	'slider_id'=>'cfgenwp-rating-paddingright-slider-'.$_SESSION['cfgenwp_form_element_id'],
																	'slider_function'=>'cfgen_sliderRatingPaddingRight',
																	'select_class'=>'cfgenwp-rating-paddingright-select',
																	'option_min'=>0,
																	'option_max'=>40,
																	'option_selected'=>$slider_paddingright_value,
																	));

			$this->editorpanel->addProperty( array(  array('name'=>'Icon spacing', 'values'=>array($slider_rating_paddingright))  ) );
			
			$this->editorpanel->getEditor();
		}

		// ADD SEPARATOR EDIT
		if($type === 'separator'){
			
			$this->editorpanel->createPanel('Color');
			
			$cpicker_separator_bg['colorpicker_csspropertyname'] = 'background-color';
			$cpicker_separator_bg['colorpicker_input_id'] = 'cfgenwp-separator-color-'.$_SESSION['cfgenwp_form_element_id'];
			$cpicker_separator_bg['colorpicker_color'] = $this->elementHasCssProperty($element, 'separator', 'background-color') ? $this->getCssPropertyValue($element, 'separator', 'background-color') : $this->getCssPropertyDefaultValue('separator', 'background-color');
			$cpicker_separator_bg['colorpicker_target'] = 'input';
			$cpicker_separator_bg['colorpicker_objecttype'] = 'separator';
			$cpicker_separator_bg['colorpicker_class'] = 'cfgenwp-colorpicker-separator-color';
			
			$this->editorpanel->addProperty( array(  array('name'=>'Color', 'values'=>array($this->setUpColorPicker($cpicker_separator_bg, true)))  ) );
			
			$this->editorpanel->getEditor();
		}
		
		
		// FONT FAMILY / FONT SIZE / FONT WEIGHT / COLOR
		if(in_array($type, array('terms', 'title', 'submit'))){
			
			$select_attr_data = array('cfgenwp_object_type'=>$type);
			
			if($type === 'title'){
				
				$preselect_fontfamily = $this->elementHasCssProperty($element, 'title', 'font-family') ? $this->getCssPropertyValue($element, 'title', 'font-family') : $this->getCssPropertyDefaultValue('title', 'font-family');
				$preselect_fontweight = $this->elementHasCssProperty($element, 'title', 'font-weight') ? $this->getCssPropertyValue($element, 'title', 'font-weight') : $this->getCssPropertyDefaultValue('title', 'font-weight');
				$preselect_fontstyle = $this->elementHasCssProperty($element, 'title', 'font-style') ? $this->getCssPropertyValue($element, 'title', 'font-style') : $this->getCssPropertyDefaultValue('title', 'font-style');
				
				$fontsize_value = $this->elementHasCssProperty($element, 'title', 'font-size') ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'title', 'font-size')) : $this->getCssPropertyDefaultValue('title', 'font-size');
				$slider_element_fontsize = $this->addSelectSlider(array(
																		'slider_id'=>'cfgenwp-title-fontsize-slider-'.$_SESSION['cfgenwp_form_element_id'],
																		'slider_function'=>'cfgen_sliderTitleFontSize',
																		'select_class'=>'cfgenwp-title-fontsize-select',
																		'option_min'=>$this->slider_fontsize_min, 
																		'option_max'=>$this->slider_fontsize_max, 
																		'option_selected'=>$fontsize_value,
																		));
			}
			
			if($type === 'terms'){
				
				$preselect_fontfamily = $this->elementHasCssProperty($element, 'terms', 'font-family') ? $this->getCssPropertyValue($element, 'terms', 'font-family') : $this->getCssPropertyDefaultValue('terms', 'font-family');
				$preselect_fontweight = $this->elementHasCssProperty($element, 'terms', 'font-weight') ? $this->getCssPropertyValue($element, 'terms', 'font-weight') : $this->getCssPropertyDefaultValue('terms', 'font-weight');
				$preselect_fontstyle = $this->elementHasCssProperty($element, 'terms', 'font-style') ? $this->getCssPropertyValue($element, 'terms', 'font-style') : $this->getCssPropertyDefaultValue('terms', 'font-style');
				
				$fontsize_value = $this->elementHasCssProperty($element, 'terms', 'font-size') ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'terms', 'font-size')) : $this->getCssPropertyDefaultValue('terms', 'font-size');
				$slider_element_fontsize = $this->addSelectSlider(array(
																		'slider_id'=>'cfgenwp-terms-fontsize-slider-'.$_SESSION['cfgenwp_form_element_id'],
																		'slider_function'=>'cfgen_sliderTermsFontSize',
																		'select_class'=>'cfgenwp-terms-fontsize-select',
																		'option_min'=>$this->slider_fontsize_min, 
																		'option_max'=>$this->slider_fontsize_max, 
																		'option_selected'=>$fontsize_value,
																		));
			}
			
			if($type === 'submit'){
				
				$preselect_fontfamily = $this->elementHasCssProperty($element, 'submit', 'font-family') ? $this->getCssPropertyValue($element, 'submit', 'font-family') : $this->getCssPropertyDefaultValue('submit', 'font-family');
				$preselect_fontweight = $this->elementHasCssProperty($element, 'submit', 'font-weight') ? $this->getCssPropertyValue($element, 'submit', 'font-weight') : $this->getCssPropertyDefaultValue('submit', 'font-weight');
				$preselect_fontstyle = $this->elementHasCssProperty($element, 'submit', 'font-style') ? $this->getCssPropertyValue($element, 'submit', 'font-style') : $this->getCssPropertyDefaultValue('submit', 'font-style');
				
				$fontsize_value = $this->elementHasCssProperty($element, 'submit', 'font-size') ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'submit', 'font-size')) : $this->getCssPropertyDefaultValue('submit', 'font-size');
				$slider_element_fontsize = $this->addSelectSlider(array(
																		'slider_id'=>'cfgen-submit-fontsize-slider-'.$_SESSION['cfgenwp_form_element_id'],
																		'slider_function'=>'cfgen_sliderSubmitFontSize',
																		'select_class'=>'cfgen-submit-fontsize-select',
																		'option_min'=>$this->slider_fontsize_min, 
																		'option_max'=>$this->slider_fontsize_max, 
																		'option_selected'=>$fontsize_value,
																		));
			}
			
			$this->editorpanel->createPanel('Font style');			
			
			$this->editorpanel->addProperty($this->addEditFontFamily(array(
																			'fontfamily_value'=>$preselect_fontfamily, 
																			'data_attr'=>array_merge($select_attr_data, array('cfgenwp_fontfamily_selected'=>$preselect_fontfamily, 'cfgenwp_fontweight_selected'=>$preselect_fontweight))
																			)));


																
			$this->editorpanel->addProperty( array(  array('name'=>'Font size', 'values'=>array($slider_element_fontsize))  ) );

			$this->editorpanel->addProperty($this->addEditFontWeight(array(
																		'fontweight_value'=>$preselect_fontweight, 
																		'data_attr'=>array_merge($select_attr_data, array('cfgenwp_fontfamily_selected'=>$preselect_fontfamily))
																		), $this->getFontVariants($preselect_fontfamily, 'fontweight')));

			$this->editorpanel->addProperty($this->addEditFontStyle(array(
																		'fontstyle_value'=>$preselect_fontstyle, 
																		'data_attr'=>array_merge($select_attr_data, array('cfgenwp_fontfamily_selected'=>$preselect_fontfamily))
																		), $this->getFontVariants($preselect_fontfamily, 'fontstyle')));
			
			
			$cpicker_color['colorpicker_csspropertyname'] = 'color';
			$cpicker_color['colorpicker_input_id'] = 'cfgen-submit-colorpicker-'.$_SESSION['cfgenwp_form_element_id'];
			
			if($type === 'terms'){
				$cpicker_color['colorpicker_color'] =  $this->elementHasCssProperty($element, $type, 'color') ? $this->getCssPropertyValue($element, $type, 'color') : $this->getCssPropertyDefaultValue($type, 'color');
				$cpicker_color['colorpicker_class'] = 'cfgenwp-colorpicker-terms-color';
				$cpicker_color['colorpicker_target'] = $type;
				$cpicker_color['colorpicker_objecttype'] = $type;
				$this->editorpanel->addProperty( array(  array('name'=>'Color', 'values'=>array($this->setUpColorPicker($cpicker_color, true)))  ) );
			}
			
			if($type === 'title'){
				$cpicker_color['colorpicker_color'] =  $this->elementHasCssProperty($element, $type, 'color') ? $this->getCssPropertyValue($element, $type, 'color') : $this->getCssPropertyDefaultValue($type, 'color');
				$cpicker_color['colorpicker_class'] = 'cfgenwp-colorpicker-title-color';
				$cpicker_color['colorpicker_target'] = $type;
				$cpicker_color['colorpicker_objecttype'] = $type;
				$this->editorpanel->addProperty( array(  array('name'=>'Color', 'values'=>array($this->setUpColorPicker($cpicker_color, true)))  ) );
			}
			
			if($type === 'submit'){
				$cpicker_color['colorpicker_color'] = $this->elementHasCssProperty($element, 'input', 'color') ? $this->getCssPropertyValue($element, 'input', 'color') : $this->getCssPropertyDefaultValue($type, 'color');
				$cpicker_color['colorpicker_class'] = 'cfgenwp-colorpicker-submit-color';
				$cpicker_color['colorpicker_target'] = 'submit';
				$cpicker_color['colorpicker_objecttype'] = 'submit';

				$cpicker_submit_color_hover['colorpicker_csspropertyname'] = 'color';
				$cpicker_submit_color_hover['colorpicker_input_id'] = 'cfgen-submit-colorpicker-hover-'.$_SESSION['cfgenwp_form_element_id'];
				$cpicker_submit_color_hover['colorpicker_target'] = 'submit';
				$cpicker_submit_color_hover['colorpicker_objecttype'] = 'submit';
				$cpicker_submit_color_hover['colorpicker_color'] = $this->elementHasCssProperty($element, 'input', 'color', 'hover') ? $this->getCssPropertyValue($element, 'input', 'color', 'hover') : $cpicker_color['colorpicker_color'];
				$cpicker_submit_color_hover['colorpicker_class'] = 'cfgenwp-colorpicker-submit-color-hover';
				$cpicker_submit_color_hover['colorpicker_paletteonly'] = true;
				
				if(!empty($element['input']['css']['hover']['color']) && $element['input']['css']['hover']['color'] != $cpicker_color['colorpicker_color']){
					$submit_color_show_hover_edit = true;
				} else{
					$submit_color_show_hover_edit = false;
				}
				
				$data_csspropertyname = array('cfgenwp_colorpicker_csspropertyname'=>'color');
				
				$html_submit_color = $this->setUpColorPicker($cpicker_color, true).$this->hoverLink('add', $data_csspropertyname, !$submit_color_show_hover_edit);
				
				$html_submit_color_hover = $this->setUpColorPicker($cpicker_submit_color_hover, true).$this->hoverLink('del', $data_csspropertyname);
				
				$this->editorpanel->addProperty(
												array(
														array('name'=>'Color', 'values'=>array($html_submit_color), 'ins_class'=>'cfgenwp-colorpicker-default-c'),
														array('name'=>'Hover', 'ins_show'=>$submit_color_show_hover_edit, 'values'=>array($html_submit_color_hover), 'ins_class'=>'cfgenwp-colorpicker-hover-c')
													)
												);
			}

			$this->editorpanel->getEditor();
			
			if($type === 'submit'){
				
				$this->editorpanel->createPanel('Button design');
				
				$cpicker_submit_bg['colorpicker_csspropertyname'] = 'background-color';
				$cpicker_submit_bg['colorpicker_input_id'] = 'cfgen-submit-backgroundcolor-'.$_SESSION['cfgenwp_form_element_id'];
				$cpicker_submit_bg['colorpicker_color'] = $this->elementHasCssProperty($element, 'input', 'background-color') ? $this->getCssPropertyValue($element, 'input', 'background-color') : $this->getCssPropertyDefaultValue('submit', 'background-color');
				$cpicker_submit_bg['colorpicker_target'] = 'submit';
				$cpicker_submit_bg['colorpicker_objecttype'] = 'submit';
				$cpicker_submit_bg['colorpicker_class'] = 'cfgenwp-colorpicker-submit-backgroundcolor';
				
				
				$cpicker_submit_bg_hover['colorpicker_csspropertyname'] = 'background-color';
				$cpicker_submit_bg_hover['colorpicker_input_id'] = 'cfgen-submit-backgroundcolorhover-'.$_SESSION['cfgenwp_form_element_id'];
				$cpicker_submit_bg_hover['colorpicker_target'] = 'submit';
				$cpicker_submit_bg_hover['colorpicker_objecttype'] = 'submit';
				$cpicker_submit_bg_hover['colorpicker_class'] = 'cfgenwp-colorpicker-submit-backgroundcolor-hover';
				$cpicker_submit_bg_hover['colorpicker_color'] = $this->elementHasCssProperty($element, 'input', 'background-color', 'hover') ? $this->getCssPropertyValue($element, 'input', 'background-color', 'hover') : $cpicker_submit_bg['colorpicker_color'];
				$cpicker_submit_bg_hover['colorpicker_paletteonly'] = true;
				
				if(!empty($element['input']['css']['hover']['background-color']) && $element['input']['css']['hover']['background-color'] != $cpicker_submit_bg['colorpicker_color']){
					$submit_bg_show_edit_hover = true;
				} else{
					$submit_bg_show_edit_hover = false;
				}
				
				$data_csspropertyname = array('cfgenwp_colorpicker_csspropertyname'=>'background-color');
				
				$html_submit_bg = $this->setUpColorPicker($cpicker_submit_bg, true).$this->hoverLink('add', $data_csspropertyname, !$submit_bg_show_edit_hover);
				
				$html_submit_bg_hover = $this->setUpColorPicker($cpicker_submit_bg_hover, true).$this->hoverLink('del', $data_csspropertyname);
				
				$this->editorpanel->addProperty(array(
														array('name'=>'Background', 'values'=>array($html_submit_bg), 'ins_class'=>'cfgenwp-colorpicker-default-c'),
														array('name'=>'Hover', 'ins_show'=>$submit_bg_show_edit_hover, 'values'=>array($html_submit_bg_hover), 'ins_class'=>'cfgenwp-colorpicker-hover-c')
													)													
												);
				
				
				$cpicker_submit_border['colorpicker_csspropertyname'] = 'border-color';
				$cpicker_submit_border['colorpicker_input_id'] = 'cfgen-submit-bordercolor-'.$_SESSION['cfgenwp_form_element_id'];
				$cpicker_submit_border['colorpicker_color'] = $this->elementHasCssProperty($element, 'input', 'border-color') ? $this->getCssPropertyValue($element, 'input', 'border-color') : $this->getCssPropertyDefaultValue('submit', 'border-color');
				$cpicker_submit_border['colorpicker_target'] = 'submit';
				$cpicker_submit_border['colorpicker_objecttype'] = 'submit';
				$cpicker_submit_border['colorpicker_class'] = 'cfgenwp-colorpicker-submit-bordercolor';


				$cpicker_submit_border_hover['colorpicker_csspropertyname'] = 'border-color';
				$cpicker_submit_border_hover['colorpicker_input_id'] = 'cfgen-submit-bordercolorhover-'.$_SESSION['cfgenwp_form_element_id'];
				$cpicker_submit_border_hover['colorpicker_class'] = 'cfgenwp-colorpicker-submit-bordercolor-hover';
				$cpicker_submit_border_hover['colorpicker_target'] = 'submit';
				$cpicker_submit_border_hover['colorpicker_objecttype'] = 'submit';
				$cpicker_submit_border_hover['colorpicker_color'] = $this->elementHasCssProperty($element, 'input', 'border-color', 'hover') ? $this->getCssPropertyValue($element, 'input', 'border-color', 'hover') : $cpicker_submit_border['colorpicker_color'];
				$cpicker_submit_border_hover['colorpicker_paletteonly'] = true;
				
				if(!empty($element['input']['css']['hover']['border-color']) && $element['input']['css']['hover']['border-color'] != $cpicker_submit_border['colorpicker_color']){
					$submit_border_show_edit_hover = true;
				} else{
					$submit_border_show_edit_hover = false;
				}
				
				$data_csspropertyname = array('cfgenwp_colorpicker_csspropertyname'=>'border-color');
				
				$html_submit_border = $this->setUpColorPicker($cpicker_submit_border, true).$this->hoverLink('add', $data_csspropertyname, !$submit_border_show_edit_hover);
				
				$html_submit_border_hover = $this->setUpColorPicker($cpicker_submit_border_hover, true).$this->hoverLink('del', $data_csspropertyname);

				$this->editorpanel->addProperty(array(
														array('name'=>'Border color', 'values'=>array($html_submit_border), 'ins_class'=>'cfgenwp-colorpicker-default-c'),
														array('name'=>'Hover', 'ins_show'=>$submit_border_show_edit_hover, 'values'=>array($html_submit_border_hover), 'ins_class'=>'cfgenwp-colorpicker-hover-c')
													)
												);

				// SUBMIT BORDER RADIUS
				$slider_borderradius_value = !empty($element['id']) ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'submit', 'border-radius')) : $this->getNumbersOnly($this->getCssPropertyDefaultValue('submit', 'border-radius'));

				$slider_submit_borderradius = $this->addSelectSlider(array(
																		'slider_id'=>'cfgen-submit-borderradius-slider-'.$_SESSION['cfgenwp_form_element_id'],
																		'slider_function'=>'cfgen_sliderSubmitBorderRadius',
																		'select_class'=>'cfgen-submit-borderradius-select',
																		'option_min'=>$this->slider_borderradius_min, 
																		'option_max'=>$this->slider_borderradius_max, 
																		'option_selected'=>$slider_borderradius_value,
																		));
																	
				$this->editorpanel->addProperty( array(  array('name'=>'Border radius', 'values'=>array($slider_submit_borderradius))  ) );
				
				
				// SLIDER MARGIN LEFT
				$slider_marginleft_value = !empty($element['id']) ? $this->getNumbersOnly($this->getCssPropertyValue($element, 'submit', 'margin-left')) : $this->getNumbersOnly($this->getCssPropertyDefaultValue('submit', 'margin-left'));
				
				$slider_submit_marginleft = $this->addSelectSlider(array(
																		'slider_id'=>'cfgen-submit-marginleft-slider-'.$_SESSION['cfgenwp_form_element_id'],
																		'slider_function'=>'cfgen_sliderSubmitMarginLeft',
																		'select_class'=>'cfgen-submit-marginleft-select',
																		'option_min'=>$this->slider_marginleft_min, 
																		'option_max'=>$this->slider_marginleft_max, 
																		'option_selected'=>$slider_marginleft_value,
																		));				
				$this->editorpanel->addProperty( array(  array('name'=>'Left margin', 'values'=>array($slider_submit_marginleft))  ) );
				
				$this->editorpanel->getEditor();
			}
		}
		
		// UPLOAD
		if($type === 'upload'){
			
			if(!empty($element['id'])){
				$upload_edit_filesizelimit = $element['file_size_limit'];
				$upload_edit_filesizeunit = $element['file_size_unit'];
			} else{
				$upload_edit_filesizelimit = $this->upload_filesizelimit;
				$upload_edit_filesizeunit = $this->upload_filesizeunit;	
			}
			
			$this->editorpanel->createPanel('Maximum file size');
			
			$html_upload_max_file_size = '<input type="text" class="upload_filesizelimit" value="'.$upload_edit_filesizelimit.'" style="width:32px; text-align:center;" >';
			
			foreach(array('MB', 'KB') as $value){
				
				if($value == $upload_edit_filesizeunit){
					$selected_filesizeunit = 'checked';
				} else{
					$selected_filesizeunit = '';
				}
				$html_name_filesizeunit = 'file_size_unit_'.$_SESSION['cfgenwp_form_element_id'];
				$html_id_filesizeunit = 'file_size_unit_'.$_SESSION['cfgenwp_form_element_id'].'_'.$value;

				
				$html_upload_max_file_size .= ' <input '.$selected_filesizeunit.' type="radio" '
											.'name="'.$html_name_filesizeunit.'" '
											.'id="'.$html_id_filesizeunit.'" class="upload_filesizeunit" '
											.'value="'.$value.'" >'
											.'<label for="'.$html_id_filesizeunit.'">'.$value.'</label>';
				
			}
			
			$html_upload_max_file_size .= '<div class="cfgenwp-element-editor-hint">'
										.'The maximum authorized file size for uploads on this server is <strong>'.str_ireplace('M', 'MB', ini_get('upload_max_filesize')).'</strong>'
										.'</div>'
										.'<div class="cfgenwp-element-editor-hint">'
										.'Remember the notification message may not arrive in your inbox if the uploaded file size exceeds the allowable attachment size limit of your email service provider.'
										.'</div>';
			
			$this->editorpanel->addProperty( array(  array('values'=>array($html_upload_max_file_size))  ) );
			
			$this->editorpanel->getEditor();			
			
			
			$this->editorpanel->createPanel('Authorized file extensions');
			
			$html_name_radio_upload = 'radio_upload_'.$_SESSION['cfgenwp_form_element_id'];
			
			$upload_edit_filetypes = !empty($element['file_types']) ? $element['file_types'] : '*.*';
			
			if($upload_edit_filetypes == '*.*'){
				$allext_checked = $this->checked;
				$allext_labelselected = ' cfgenwp-option-selected ';
				
				$specifyext_checked = '';
				$specifyext_display = ' display:none ';
				$specifyext_labelselected = '';
				
				$upload_edit_filetypes = ''; // else *.* is shown in the input if load json with *.* and then click on "specify"
			} else{
				$allext_checked = '';
				$allext_labelselected = '';
				
				$specifyext_checked = $this->checked;
				$specifyext_display = '';
				$specifyext_labelselected = ' cfgenwp-option-selected ';
			}
			
			$html_upload_authorized_extensions[] = '<input type="radio" class="radio_upload_filetype_all radio_upload_filetype" '.$allext_checked.' '
														.'name="'.$html_name_radio_upload.'" '
														.'id="'.$html_name_radio_upload.'_1" >'
														.'<label for="'.$html_name_radio_upload.'_1" class="'.$allext_labelselected.'">All file extensions are authorized</label>';
			
			$html_upload_authorized_extensions[] = '<input type="radio" class="radio_upload_filetype_custom radio_upload_filetype " '.$specifyext_checked.' '
														.'name="'.$html_name_radio_upload.'" '
														.'id="'.$html_name_radio_upload.'_3" >'
														.'<label for="'.$html_name_radio_upload.'_3" class="'.$specifyext_labelselected.'">Specify authorized extensions</label>'
												.'<div class="radio-upload-slide" style="'.$specifyext_display.'">'
													.'<input type="text" class="upload_filetype_custom" value="'.$upload_edit_filetypes.'" style="width:150px; margin-left:20px;" > '
													.'<div class="cfgenwp-element-editor-hint">Separate extensions with commas (no dots)<br>Example: jpg,doc,txt</div>'
												.'</div>';
			
			$this->editorpanel->addProperty( array(  array('values'=>$html_upload_authorized_extensions)  ) );

			$this->editorpanel->getEditor();
			
			
			
			$this->editorpanel->createPanel('How do you want to receive the file?');
			
			$html_prefix_upload_deletefile = 'upload_deletefile_'.$_SESSION['cfgenwp_form_element_id'];
			
			$selected_upload_receive_method_id = !empty($element['upload_deletefile']) ? $element['upload_deletefile'] : 1;
			
			$upload_receive_method[1]['id'] = 1;
			$upload_receive_method[1]['title'] = 'File Attachment + Download Link';
			$upload_receive_method[1]['description'] = 'The file will be attached in the admin notification message.<br>The file stays on the server after the user submits the form.';
			
			$upload_receive_method[2]['id'] = 2;
			$upload_receive_method[2]['title'] = 'File Attachment Only';
			$upload_receive_method[2]['description'] = 'The file will be attached in the admin notification message.<br>The file will be deleted from the server after the user submits the form.';
			
			$upload_receive_method[3]['id'] = 3;
			$upload_receive_method[3]['title'] = 'Download Link Only';
			$upload_receive_method[3]['description'] = 'No file attached in the admin notification message but a download link instead.<br>Recommended if you think the uploaded file size will exceed the allowable attachment size limit of your email service provider.<br>The file stays on the server after the user submits the form.';
			
			foreach($upload_receive_method as $upload_receive_value){
				
				if($upload_receive_value['id'] == $selected_upload_receive_method_id){
					$uploadreceive_checked = $this->checked;
					$uploadreceive_labelselected = ' cfgenwp-option-selected ';
					$uploadreceive_hintdisplay = '';
					
				} else{
					$uploadreceive_checked = '';
					$uploadreceive_labelselected = '';
					$uploadreceive_hintdisplay = ' display:none; ';
				}
				
				$html_upload_receive_file_method[] = '<input type="radio" value="'.$upload_receive_value['id'].'" class="upload_deletefile" '.$uploadreceive_checked.' '
															.'name="'.$html_prefix_upload_deletefile.'" '
															.'id="'.$html_prefix_upload_deletefile.'_'.$upload_receive_value['id'].'" >'
													.'<label for="'.$html_prefix_upload_deletefile.'_'.$upload_receive_value['id'].'" class="'.$uploadreceive_labelselected.' ">'.$upload_receive_value['title'].'</label>'
													.'<div class="cfgenwp-element-editor-hint" style="'.$uploadreceive_hintdisplay.'">'
													.$upload_receive_value['description']
													.'</div>';
			}
			
			$this->editorpanel->addProperty( array(  array('values'=>$html_upload_receive_file_method) ) );

			$this->editorpanel->getEditor();
			
		}
	}

	function hoverLink($action, $data, $show = true){
		
		$html_data = '';
		
		foreach($data as $data_k=>$data_v){
			$html_data	.= 'data-'.$data_k.'="'.$data_v.'"';
		}
		
		$html = '<span '.(($show === false) ? 'style="display:none"' : '').' class="cfgenwp-hover-edit-c cfgenwp-a" '.$html_data.' data-cfgenwp_hover_edit_action="'.$action.'">';
		
		$html .= $action == 'add' ? 'Add hover effect' : 'Remove hover effect';
		
		$html .= '</span>';
		
		return($html);		
	}


	function htmlIcon($icon = array()){
		
		$icon_html_id_val = isset($icon['id']) ? $icon['id'] : '';
		$icon_html_id_attr = $icon_html_id_val ? ' id="'.$icon_html_id_val.'"' : '';
		$icon_fontawesome_id = isset($icon['fontawesome_id']) ? ' '.$icon['fontawesome_id'] : '';		
		$icon_c_style = isset($icon['icon_c_style']) ? ' '.$icon['icon_c_style'] : '';
		
		$icon = '<div class="cfgen-icon-c"'.$icon_c_style.$icon_html_id_attr.'><span class="fa'.$icon_fontawesome_id.'"></span></div>';

		return $icon;
	}
	
	// ADD PARAGRAPH WRAP
	function htmlAddParagraph($editor, $element, $default_value, $default_style){

		$element_name = !empty($element['paragraph']['id']) ? $element['paragraph']['id'] : $this->htmlElementName($_SESSION['cfgenwp_form_element_id']).$this->paragraph_suffix;
		
		if(!empty($element['id'])){
			$paragraph_value = !empty($element['paragraph']['value']) ? $element['paragraph']['value'] : '';
		} else{
			$paragraph_value = $default_value;
		}
		
		if($editor){
			$paragraph_style = ' style="'.($paragraph_value ? '' : 'display:none;').(!empty($element['paragraph']) ? $this->buildStyle($element['paragraph']['css']['default']) : $default_style).'"';
		} else{
			$paragraph_style = '';
		}

		if($editor || !empty($element['paragraph']['value'])){
			// ^-- the paragraph element should only be displayed if we are in the editor of there is something in the paragraph
			// this condition prevents displaying empty cfgen-paragraph block in the form
			
			$this->html_form_element = "\r\n\t\t".'<div class="cfgen-paragraph" id="'.$element_name.'"'.$paragraph_style.'>'
									  ."\r\n\t\t".nl2br($paragraph_value)
									  ."\r\n\t\t".'</div>'
									  .$this->html_form_element;
		}

		return $this;
	}


	function addFormField($element, $editor, $contactform_obj = false){
		
		// to prevent style properties such as "font-family:undefined;"
		foreach($element as $key=>$value){
			
			if($value === 'undefined'){
				// "===" http://stackoverflow.com/questions/7471302/php-i-get-true-on-0-undefined-why
				// For example, if default_padding_inputformat is set to 0 in the slider
				// "Notice: Undefined index: default_padding_inputformat" will be returned
				unset($element[$key]);
			}
		}
		
		$type = $element['type'];
		
		$style_paragraph = $style_rating = $style_element = '';
		
		if($editor){		

			$this->option_style = 'font-family:'.$this->getCssPropertyDefaultValue('input', 'font-family').';'
								 .'font-weight:'.$this->getCssPropertyDefaultValue('input', 'font-weight').';'
								 .'font-style:'.$this->getCssPropertyDefaultValue('input', 'font-style').';'
								 .'font-size:'.$this->getCssPropertyDefaultValue('input', 'font-size').';'
								 .'color:'.$this->getCssPropertyDefaultValue('input', 'color').';';
			
			// maj default values for preselection
			foreach($element['css'] as $element_type_k=>$element_property_a){
				foreach($element_property_a as $element_property_a_k=>$element_property_a_v){
					$this->css_properties_initialization[$element_type_k][$element_property_a_k] = $element_property_a_v;
				}
			}
			
			// This code snippet removes the border-radius property on the elements with the type selectmultiple
			if($type === 'selectmultiple'){
				unset($element['css']['input']['default']['border-radius']);
			}
			
			// This code snippet removes the width property on the element label
			// That prevents to have a width on labels, which are aligned vertically by default
			// (after adjusting the width of a label, it updates the width property in cfgenwp_css_properties and new elements label inherits the width property)
			unset($element['css']['label']['default']['width']);

			
			$this->icon_style = $this->buildStyle($element['css']['icon']['default']);

			$style_paragraph = $this->buildStyle($element['css']['paragraph']['default']);

			$style_rating = 'style="'.(!empty($element['rating']) ? $this->buildStyle($element['rating']['css']['default']) : $this->buildStyle($element['css']['rating']['default'])).'"';

			if(in_array($type, array('captcha', 'date', 'email', 'url', 'input', 'text', 'textarea', 'input', 'select', 'selectmultiple', 'time'))){

				$style_element = ' style="';

				// Check isset on $type 'default' because all element types don't necessarily have a 'default' index (textarea and submit do, for the height property)
				if(!empty($element['id'])){
					$style_element .= $this->buildStyle($element['input']['css']['default'])
									 .$this->buildStyle( isset($element['input'][$type]['default']) ? $element['input'][$type]['default'] : array() );
				} else{
					$style_element .= $this->buildStyle($element['css']['input']['default'])
									 .$this->buildStyle( isset($element['css'][$type]['default']) ? $element['css'][$type]['default'] : array() );
				}
				
				$style_element .= '"';
			}
		}

		$html_form_element = '';
		
		$element['required'] = !empty($element['required']) ? $element['required']:''; // isset test because "required" property won't be in the json_export object if the checkbox required is not checked

		$element_name = !empty($element['id']) ? $element['id'] : $this->htmlElementName($_SESSION['cfgenwp_form_element_id']);


		// ADD LABEL
		if(!in_array($type, array('image', 'paragraph', 'terms', 'title', 'separator', 'submit'))){
			
			$label_config['element_id'] = $element_name;
			
			$label_config['value'] = !empty($element['id']) ? $this->getLabelValueFromJson($element) : $this->labels[$type];

			// Default required value for specific fields
			if(in_array($type, array('email', 'url'))){
				$label_config['required'] = !empty($element['id']) ? $element['required'] : 1;	
			} else{
				$label_config['required'] = !empty($element['id']) ? $element['required'] : '';	
			}
			
			if(!$editor){
				$build_label_style = '';
			} else{
				
				$style_display_none = ($type === 'hidden') ? 'display:none;' : '';
				
				// label style is always required because the user may add a label outside value after loading a field without a value
				// without the label style, the outside label would have no style and would mismatch with the other labels
				if(!empty($element['id'])){
					$build_label_style = 'style="'.$style_display_none.$this->buildStyle($element['label']['css']['default']).'"';
					// Form loaded, $element['label']['css'] and not ['css']['label'] because the generic property does not handle display:none if there is no label wheres ['label'['css'] does
				} else{
					$build_label_style = 'style="'.$style_display_none.$this->buildStyle($element['css']['label']['default']).'"';
					// New form, we load the generic css for labels
				}
			}

			$label_config['style'] = $build_label_style;
			
			if(in_array($type, array('captcha'))){
				$label_config['required'] = '';
			}
		}

		
		$placeholder_attr = (!empty($element['input']['placeholder'])) ? ' placeholder="'.$this->htmlEntities($element['input']['placeholder']).'"' : '';


		// ADD CAPTCHA
		if($type === 'captcha'){
		
			$element_class = $editor ? 'class="cfgen-form-value cfgen-captcha-input cfgenwp-formelement cfgenwp-colorpicker-target-element"' : 'class="cfgen-captcha-input"';
			
			$captcha_img_src = ($editor ? 'sourcecontainer/' : '').$this->dir_form_inc.'/inc/captcha.php';
			
			$captcha_url_arg = !empty($element['id']) ? '?length='.$element['length'].'&format='.$element['format'] : '';
			
			if($editor){
				$captcharefresh_path = 'sourcecontainer/'.$this->dir_form_inc.'/';
				$captcha_img_src .= $captcha_url_arg; // append ?length=4&format=letters on the captcha in the editor only
			} else{
				$captcharefresh_path = !empty($element['id']) ? $element['form_inc_dir'].'/' : '';
			}
			
			$html_input = '<input type="text" name="'.$element_name.'" id="'.$element_name.'" '.$element_class.$style_element.$placeholder_attr.'>';

			$html_captcha = $this->htmlAttachIconToInput($element, $editor, $html_input);

			$this->html_form_element = "\r\n\t\t".'<div class="cfgen-captcha-c">'
									  ."\r\n\t\t\t".'<img src="'.$captcha_img_src.'" class="cfgen-captcha-img" alt="" ><img src="'.$captcharefresh_path.'img/captcha-refresh.png" class="cfgen-captcha-refresh" alt="">'
									  ."\r\n\t\t".'</div>'
									  .$this->htmlWrapInputGroup($editor, $element, $html_captcha)->html_form_element;

			$html_form_element = $this->htmlAddParagraph($editor, $element, '', $style_paragraph)->htmlWrapElementSet($element, $editor)->htmlAddLabel($label_config)->html_form_element;
		}


		// ADD DATE
		if($type === 'date'){
			
			$element_class = $editor ? 'cfgenwp-formelement cfgenwp-colorpicker-target-element' : '';
			
			if(!empty($element['id'])){
				$element_datepicker_format = $element['datepicker']['format'];
				$element_datepicker_language = $element['datepicker']['regional'];
				$element_datepicker_firstdayoftheweek = $element['datepicker']['firstdayoftheweek'];
			} else{
				$element_datepicker_format = $this->datepicker_default_format;
				$element_datepicker_language = $this->datepicker_language[$this->datepicker_default_language];
				$element_datepicker_firstdayoftheweek = $this->datepicker_firstdayoftheweek_default;
			}
			
			$html_date = '';
			
			if($editor){
				
				$datepicker_config['regional'] = $element_datepicker_language;
				$datepicker_config['format'] = $element_datepicker_format;
				$datepicker_config['changemonth'] = true;
				$datepicker_config['changeyear'] = true;
				$datepicker_config['format'] = $element_datepicker_format;
				$datepicker_config['firstdayoftheweek'] = $element_datepicker_firstdayoftheweek;

				if(!empty($element['id'])){
					$datepicker_config['disablepastdates'] = $element['datepicker']['disablepastdates'];
					$datepicker_config['disabledaysoftheweek'] = $element['datepicker']['disabledaysoftheweek'];
					$datepicker_config['mindate'] = $element['datepicker']['mindate'];
					$datepicker_config['maxdate'] = $element['datepicker']['maxdate'];
					$datepicker_config['yearrange'] = $element['datepicker']['yearrange'];
				}

				$html_date .= '<script>jQuery(function(){';

				$html_date .= $this->buildDatepicker('#'.$element_name, $datepicker_config);

				$html_date .= '})</script>';
			}

			$html_input = '<input type="text" class="cfgen-type-date cfgen-form-value '.$element_class.'" name="'.$element_name.'" id="'.$element_name.'" value=""'.$style_element.$placeholder_attr.'>';

			$html_date .= $this->htmlAttachIconToInput($element, $editor, $html_input);

			$html_form_element = $this->htmlWrapInputGroup($editor, $element, $html_date)->htmlAddParagraph($editor, $element, '', $style_paragraph)->htmlWrapElementSet($element, $editor)->htmlAddLabel($label_config)->html_form_element;
		}


		// ADD EMAIL
		if($type === 'email'){
			
			$element_class = $editor ? 'cfgenwp-formelement cfgenwp-colorpicker-target-element' : '';

			$html_input = '<input type="text" class="cfgen-type-email cfgen-form-value '.$element_class.'" name="'.$element_name.'" id="'.$element_name.'"'.$style_element.$placeholder_attr.'>';

			$html_email = $this->htmlAttachIconToInput($element, $editor, $html_input);

			$html_form_element = $this->htmlWrapInputGroup($editor, $element, $html_email)->htmlAddParagraph($editor, $element, '', $style_paragraph)->htmlWrapElementSet($element, $editor)->htmlAddLabel($label_config)->html_form_element;
		}


		// ADD HIDDEN
		if($type === 'hidden'){
			
			$element_class 	= $editor ? 'cfgenwp-formbuilder-input-hidden' : ''; // cfgenwp-formbuilder-input-hidden: for css styling in the form builder
			
			$input_value = !empty($element['id']) ? $this->htmlentities($element['hidden']['value']) : '';
			
			$html_hidden = "\r\n\t\t".'<input type="'.( $editor ? 'text' : 'hidden' ).'" class="cfgen-type-hidden cfgen-form-value '.$element_class.'" name="'.$element_name.'" id="'.$element_name.'" value="'.$input_value.'" >';
			
			if($editor){
				$html_hidden .= '<p class="cfgenwp-formbuilder-hint">This input fied will be hidden in your form with <br>the value you set in the options on the right</p>';
			}
			
			$html_form_element = $this->htmlWrapInputGroup($editor, $element, $html_hidden)->htmlWrapElementSet($element, $editor)->htmlAddLabel($label_config)->html_form_element;
		}			


		// ADD IMAGE
		if($type === 'image'){
			
			$img_container = '';
			
			if(!empty($element['id'])){
				
				if(!empty($element['url'])){
					$img_container = "\r\n\t\t\t".'<img src="'.$element['url'].'">';
				}
				
				if(!empty($element['filename'])){

					$img_upload_path =  $editor ? $this->forms_dir.'/'.$element['form_dir'].'/'.$element['form_inc_dir'].'/' : $element['form_inc_dir'].'/';

					$img_container = '<img src="'.$img_upload_path.'img/'.$element['filename'].'">';
				}				
			}
			
			if($editor || $img_container){
			// ^-- when we are in the editor or when there is some image data (url or file) in the json element
				
				if(!$img_container){
					// ^-- when we are in the editor and when there is no image data (url or file) in the image json element
					$img_container = $this->html_empty_image_container;
				}

				$html_form_element = $this->htmlWrapInputGroup($editor, $element, $img_container)->htmlWrapElementSet($element, $editor)->html_form_element;
			}
		}


		// ADD PARAGRAPH
		if($type === 'paragraph'){			
			$html_form_element = $this->htmlAddParagraph($editor, $element, $this->paragraph_default_value, $style_paragraph)->htmlWrapElementSet($element, $editor)->html_form_element;
		}


		// ADD RATING
		if($type === 'rating'){
			
			if(!empty($element['rating'])){
				$rating_maximum = $element['rating']['maximum'];
				$rating_html_attr_id = $element['id'];
				$rating_icon = $element['rating']['fontawesome_id'];
			} else{
				$rating_maximum = $this->rating_default_maximum;
				$rating_html_attr_id = '';
				$rating_icon = 'fa-star';
			}			

			$html_rating = "\r\n\t\t\t".'<div class="cfgen-rating-c cfgen-form-value" id="'.$rating_html_attr_id.'">';
			
			for($i = 1; $i<=$rating_maximum; $i++){
				$html_rating .= '<span class="fa '.$rating_icon.'"'.$style_rating.'></span>';
			}
			
			$html_rating .= "\r\n\t\t\t".'</div>';

			$html_form_element = $this->htmlWrapInputGroup($editor, $element, $html_rating)->htmlAddParagraph($editor, $element, '', $style_paragraph)->htmlWrapElementSet($element, $editor)->htmlAddLabel($label_config)->html_form_element;
		}
		
		
		// ADD SELECT ADD SELECTMULTIPLE
		if($type === 'select' || $type === 'selectmultiple'){
			
			$element_class = $editor ? 'cfgenwp-formelement cfgenwp-colorpicker-target-element' : '';
			
			if($type === 'selectmultiple'){
				$multiple = 'multiple'; // => <select multiple="multiple" class="cfgen-type-selectmultiple
				$html_attr_multiple = ' multiple="multiple"';
			} else{
				$multiple = '';
				$html_attr_multiple = '';	
			}
			
			$html_select = $this->htmlAddParagraph($editor, $element, '', $style_paragraph)->html_form_element;
			
			$html_select .= "\r\n\t\t\t".'<select'.$html_attr_multiple.' class="cfgen-type-select'.$multiple.' cfgen-form-value '.$element_class.'" name="'.$element_name.'" id="'.$element_name.'"'.$style_element.'>';
		
			if(!empty($element['id'])){
				
				foreach($element['option']['set'] as $option_config){
					
					if(!empty($option_config['checked'])){
						$option_selected = $this->selected;
					} else{
						$option_selected = '';
					}					
					
					$html_select .= "\r\n\t\t\t\t".'<option value="'.$this->htmlentities($option_config['value']).'" '.$option_selected.'>'.$this->htmlentities($option_config['value']).'</option>';
				}
			} else{
				for($i=1; $i<=3; $i++){
					$html_select .= "\r\n\t\t\t\t".'<option value="'.$this->htmlentities($this->option_default_value).'">'.$this->htmlentities($this->option_default_value).'</option>';
				}
			}
			
			$html_select .= "\r\n\t\t\t".'</select>';

			$html_form_element = $this->htmlWrapInputGroup($editor, $element, $html_select)->htmlWrapElementSet($element, $editor)->htmlAddLabel($label_config)->html_form_element;
		}


		// ADD SEPARATOR
		if($type === 'separator'){
			
			$element_class = $editor ? ' class="cfgen-separator cfgenwp-colorpicker-target-element"' : '';

			$style_element = $editor ? (' style="'.(!empty($element['id']) ? $this->buildStyle($element['separator']['css']['default']) : $this->buildStyle($element['css']['separator']['default'])).'"') : '';

			$html_separator = "\r\n\t\t\t".'<div id="'.$element_name.'"'.$element_class.$style_element.'></div>';

			$html_form_element = $this->htmlWrapInputGroup($editor, $element, $html_separator)->htmlWrapElementSet($element, $editor)->html_form_element;
		}


		// ADD SUBMIT
		if($type === 'submit'){
			
			$element_label = !empty($element['id']) ? $element['submit']['value'] : $this->submit_default_value;
			
			$style_element = $editor ? (' style="'.(!empty($element['id']) ? $this->buildStyle($element['submit']['css']['default']) : $this->buildStyle($element['css']['submit']['default'])).'"') : '';
			
			$html_submit = '<input type="submit" class="cfgen-submit" name="'.$element_name.'" id="'.$element_name.'" value="'.$this->htmlentities($element_label).'"'.$style_element.'>';
			$html_submit = $this->htmlFormWrapInput($element, $editor, $html_submit);
			$html_form_element = $this->htmlWrapInputGroup($editor, $element, $html_submit)->htmlWrapElementSet($element, $editor)->html_form_element;


			// SUBMIT HOVER EFFECTS
			$build_hover_css = array('background-color', 'border-color', 'color');
			$js_hover_mouseover_css_object = '';
			$js_hover_mouseout_css_object = '';
			
			if(!empty($element['submit']['css']['hover']) && !empty($element['submit']['css']['default']) && $editor){
				
				foreach($build_hover_css as $build_hover_css_propertyname){
					
					if(!empty($element['submit']['css']['hover'][$build_hover_css_propertyname]) && !empty($element['submit']['css']['default'][$build_hover_css_propertyname])){ 
						// ^-- it's possible to have border-color in default, but in hover, we need both to build the hover effect
						$js_hover_mouseover_css_object .= '\''.$build_hover_css_propertyname.'\':\''.$element['submit']['css']['hover'][$build_hover_css_propertyname].'\',';
						$js_hover_mouseout_css_object .= '\''.$build_hover_css_propertyname.'\':\''.$element['submit']['css']['default'][$build_hover_css_propertyname].'\',';
					}
				}
				
				$js_hover_mouseover_css_object = substr($js_hover_mouseover_css_object, 0, -1);
				$js_hover_mouseout_css_object = substr($js_hover_mouseout_css_object, 0, -1);
				
				$html_form_element .= '<script>
									jQuery(function(){
										jQuery(\'input[type="submit"].cfgen-submit\').hover(
																	function(){ jQuery(this).css({'.$js_hover_mouseover_css_object.'}); },
																	function(){ jQuery(this).css({'.$js_hover_mouseout_css_object.'}); }
																	);
									});
									</script>';
			}
		}


		// ADD TERMS
		if($type === 'terms'){

			$element_name = !empty($element['terms']['id']) ? $element['terms']['id'] : $this->htmlElementName($_SESSION['cfgenwp_form_element_id']);
			
			$div_c_id = $element_name.$this->terms_suffix;
			
			if(!empty($element['id'])){
				$terms_value = !empty($element['terms']['value']) ? $element['terms']['value'] : '';
				$terms_link = !empty($element['terms']['link']) ? $element['terms']['link'] : '';
			} else{
				$terms_value = $this->terms_default_value;
				$terms_link = $this->terms_default_link;
			}
			
			$link_pattern = '#{(.*)}#U';
			$link_replacement = '<a href="'.$terms_link.'" target="_blank">$1</a>';
			
			$terms_value = preg_replace($link_pattern, $link_replacement, $terms_value);
			
			if($editor){
				$terms_style = ' style="'.(!empty($element['terms']) ? $this->buildStyle($element['terms']['css']['default']) : $this->buildStyle($element['css']['terms']['default'])).'"';
			} else{
				$terms_style = '';
			}
			
			$this->html_form_element = "\r\n\t\t".'<div class="cfgen-terms" id="'.$div_c_id.'">'
									  ."\r\n\t\t".'<input type="checkbox" id="'.$element_name.'" class="cfgen-type-terms cfgen-form-value"><label for="'.$element_name.'"'.$terms_style.'>'.$terms_value.'</label>'
									  ."\r\n\t\t".'</div>';

			$html_form_element = $this->htmlWrapElementSet($element, $editor)->html_form_element;
		}

		
		// ADD TEXT
		if($type === 'text'){
			
			$element_class 	= $editor ? 'cfgenwp-formelement cfgenwp-colorpicker-target-element' : '';

			$html_input = '<input type="text" class="cfgen-type-text cfgen-form-value '.$element_class.'" name="'.$element_name.'" id="'.$element_name.'"'.$style_element.$placeholder_attr.'>';
			
			$html_text = $this->htmlAttachIconToInput($element, $editor, $html_input);

			$html_form_element = $this->htmlWrapInputGroup($editor, $element, $html_text)->htmlAddParagraph($editor, $element, '', $style_paragraph)->htmlWrapElementSet($element, $editor)->htmlAddLabel($label_config)->html_form_element;
		}


		// ADD TEXTAREA
		if($type === 'textarea'){
			
			$element_class = $editor ? 'cfgenwp-formelement cfgenwp-colorpicker-target-element' : '';

			$html_textarea = $this->htmlFormWrapInput($element, $editor, '<textarea class="cfgen-type-textarea cfgen-form-value '.$element_class.'" name="'.$element_name.'" id="'.$element_name.'"'.$style_element.$placeholder_attr.'></textarea>');
			
			$html_form_element = $this->htmlWrapInputGroup($editor, $element, $html_textarea)->htmlAddParagraph($editor, $element, '', $style_paragraph)->htmlWrapElementSet($element, $editor)->htmlAddLabel($label_config)->html_form_element;
		}

		
		// ADD TIME
		if($type === 'time'){
			
			$element_class 	= $editor ? ' cfgenwp-formelement cfgenwp-colorpicker-target-element' : '';

			// hour
			$html_time = "\r\n\t\t\t".'<select class="cfgen-time-hour cfgen-type-time cfgen-form-value'.$element_class.'" name="'.$element_name.'" id="'.$element_name.'"'.$style_element.'>';

			if(isset($element['timeformat']) && $element['timeformat'] == 12){
				$i_start = 1;
				$i_end = 12;
			} else{
				$i_start = 0;
				$i_end = 23;
			}
			
			for($i=$i_start; $i<= $i_end; $i++){
				$html_time .= "\r\n\t\t\t\t".'<option value="'.str_pad($i, 2, '0', STR_PAD_LEFT).'">'.str_pad($i, 2, '0', STR_PAD_LEFT).'</option>';
			}

			$html_time .= "\r\n\t\t\t".'</select> : ';
			
			
			// minutes
			$html_time .= "\r\n\t\t\t".'<select class="cfgen-time-minute'.$element_class.'"'.$style_element.'>';
			
			$minutes = array('00', '05' , '10', '15', '20', '25', '30', '35', '40', '45', '50', '55');

			foreach($minutes as $value){
				$html_time .= "\r\n\t\t\t\t".'<option value="'.$value.'" >'.$value.'</option>';
			}

			$html_time .= "\r\n\t\t\t".'</select>';


			// the ampm must be included when we are in the form builder (we use a check $element['ampm'] to display or hide the ampm select)
			$include_ampm = ''; // default value
			$ampm_class = ''; // default value
			if($editor){
				$ampm_class = ' hidden'; // 24 hour format by default in the editor
				$include_ampm = 1;
				if(isset($element['timeformat']) && $element['timeformat'] == 12){
					$ampm_class = '';
				}
			} else{
				if(isset($element['timeformat']) && $element['timeformat'] == 12){
					$include_ampm = 1;
				}
			}

			// AM PM
			if($include_ampm){
				
				$html_time .= "\r\n\t\t\t".' <select class="cfgen-time-ampm'.$ampm_class.$element_class.'"'.$style_element.'>';

				$ampm = array('AM', 'PM');

				foreach($ampm as $value){
					$html_time .= "\r\n\t\t\t\t".'<option value="'.$value.'" >'.$value.'</option>';
				}

				$html_time .= "\r\n\t\t\t".'</select>';
			}

			$html_form_element = $this->htmlWrapInputGroup($editor, $element, $html_time)->htmlAddParagraph($editor, $element, '', $style_paragraph)->htmlWrapElementSet($element, $editor)->htmlAddLabel($label_config)->html_form_element;
		}


		// ADD TITLE
		if($type === 'title'){
			
			$element_title = !empty($element['id']) ? $element['title']['value'] : $this->title_default_value;
			
			$style_element = $editor ? (' style="'.(!empty($element['id']) ? $this->buildStyle($element['title']['css']['default']) : $this->buildStyle($element['css']['title']['default'])).'"') : '';
			
			$html_form_element = "\r\n\t".'<div class="cfgen-title"'.$style_element.' id="'.$element_name.'">'.$element_title.'</div>';
		}


		// ADD UPLOAD
		if($type === 'upload'){

			$element_id = !empty($element['id']) ? $element['id'] : $_SESSION['cfgenwp_form_element_id'];

			$upload_btn_img = '';
			
			if($editor){
				$upload_btn_img = '<div class="replace_upload_field" style="height:31px; overflow:hidden;"><img src="sourcecontainer/'.$this->dir_form_inc.'/js/swfupload/img/upload-button.png" alt="" ></div>';
			} else{
			
				// if demo mode is on we display the upload button as an image
				$demo_upload_msg = '';
				
				if(isset($contactform_obj->demo) && $contactform_obj->demo == 1){
					
					$demo_upload_msg = '<div style="background-color:#fef6ca; border:1px solid #f9dd34; -moz-border-radius:4px; -khtml-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; padding:6px; margin:4px 0;">'
									  .'<p style="margin:0; font-family: Verdana; font-size:12px">Upload fields only work when using the <a href="'.$contactform_obj->envato_link.'">full version of Contact Form Generator</a></p>'
									  .'</div>';
					
					$upload_btn_img = $demo_upload_msg.'<div class="replace_upload_field" style="height:31px; overflow:hidden;"><img src="'.$this->dir_form_inc.'/js/swfupload/img/upload-button.png" alt="" ></div>';
				}
			}
			
			
			// spanButtonPlaceHolder-ID used in upload_json['uploads'] in contactformeditor.js
			// height:31px; overflow:hidden used in saveform.php for preg_replace (IE...)
			$html_upload = $upload_btn_img;
			
			if(isset($contactform_obj->demo) && $contactform_obj->demo != 1){
			
				$js_element_name = str_replace('-', '_', $element_name); // in order to prevent dashes in variables names in upload.js => var swfupload_cfg_element_1;
				
				$html_upload .= "\r\n\t\t\t".'<input type="hidden" class="cfgen-form-value cfgen-uploadfilename" name="'.$element_name.'" >'
									 ."\r\n\t\t\t".'<input type="hidden" class="cfgen-uploaddeletefile" value="'.$element['upload_deletefile'].'" >'
									 ."\r\n\t\t\t".'<span id="'.$this->uploadbutton_prefix.$js_element_name.'" class="btnUpload"></span>'
									 ."\r\n\t\t\t".'<input id="btnCancel_'.$js_element_name.'" type="button" value="Cancel Upload" onclick="swfupload_'.$js_element_name.'.cancelQueue();" disabled="disabled" style="display:none;margin-left: 2px; font-size: 8pt; height: 29px;" >'
									 ."\r\n\t\t\t".'<div id="fsUploadProgress_'.$js_element_name.'"></div>'
									 ;
			}
			
			
			$html_form_element = $this->htmlWrapInputGroup($editor, $element, $html_upload)->htmlAddParagraph($editor, $element, '', $style_paragraph)->htmlWrapElementSet($element, $editor)->htmlAddLabel($label_config)->html_form_element;
		}


		// ADD RADIO ADD CHECKBOX
		if($type === 'checkbox' || $type === 'radio'){

			$html_radio_checkbox = "\r\n\t\t\t".'<div class="cfgen-option-set">';
			
			if(!empty($element['option'])){

				$html_radio_checkbox .= $editor ? $this->addOptionContainer($element, true, true, true) : $this->addOptionContainer($element, false, true, true);

			} else{
				$default_option_array['type'] = $type;
				
				for($i=0; $i<=2; $i++){
					$default_option_array['option']['set'][$i]['value'] = $this->option_default_value;
				}

				$html_radio_checkbox .= $this->addOptionContainer($default_option_array, true, true, true);
			}
			
			$html_radio_checkbox .= "\r\n\t\t\t".'</div>'; //cfgen-option-set
			
			$html_form_element = $this->htmlWrapInputGroup($editor, $element, $html_radio_checkbox)->htmlAddParagraph($editor, $element, '', $style_paragraph)->htmlWrapElementSet($element, $editor)->htmlAddLabel($label_config)->html_form_element;
		}


		// ADD URL
		if($type === 'url'){

			$element_class = $editor ? 'cfgenwp-formelement cfgenwp-colorpicker-target-element' : '';

			$html_url_input = '<input type="text" class="cfgen-type-url cfgen-form-value '.$element_class.'" name="'.$element_name.'" id="'.$element_name.'"'.$style_element.$placeholder_attr.'>';

			$html_url = $this->htmlAttachIconToInput($element, $editor, $html_url_input);

			$html_form_element = $this->htmlWrapInputGroup($editor, $element, $html_url)->htmlAddParagraph($editor, $element, $default_value = '', $style_paragraph)->htmlWrapElementSet($element, $editor)->htmlAddLabel($label_config)->html_form_element;
		}

		
		// $html_form_element can = '' in the case of $type = image when there is no img url or img file, this prevents from having <div class="element"></div> in the code
		if($html_form_element){
			
			$html_form_element = '<div class="cfgen-e-c">'
									.$html_form_element;
			
			/**
			 * Needed in the editor:
			 * helps calculating the element height when aligning on left/right the label
			 * prevents the right side from overlapping on the element that is below (exemple with checkboxes that would overlap the following element if label aligned on left/right)
			 *
			 * Needed in the render of the form to properly clear the alignment if label is aligned on left/right
			 */
			if(!in_array($element['type'], array('image', 'paragraph', 'submit', 'title'))){
				$html_form_element .= "\r\n\t".'<div class="cfgen-clear"></div>'."\r\n";
			}
			
			$html_form_element .= "\r\n".'</div>'
								 ."\r\n\r\n"
								 ."\r\n";
								 
			$this->html_form_element = ''; // must be reset to prevent non expected concatenation when using htmlAddParagraph() only
		}
		
		return($html_form_element);
	}
	
	function htmlFormWrapInput($element, $editor, $html_input){

		$container_style = '';
		
		if($editor){

			$container_style = ' style="';

			if(!empty($element['input-c']['css']['default'])){
				$container_style .= $this->buildStyle($element['input-c']['css']['default']);
			} else{
				$container_style .= $this->buildStyle(isset($element['css'][$element['type']]['input-c']) ? $element['css'][$element['type']]['input-c'] : array());
			}
			
			$container_style .= '"';
		}
		
		$container_id = !empty($element['input-c']['id']) ? $element['input-c']['id'] : $this->htmlElementName($_SESSION['cfgenwp_form_element_id']).$this->input_c_suffix;

		return "\r\n\t\t\t".'<div class="cfgen-input-c" id="'.$container_id.'"'.$container_style.'>'
			  ."\r\n\t\t\t\t".$html_input
			  ."\r\n\t\t\t".'</div>';
	}
	
	function htmlAttachIconToInput($element, $editor, $html_input){
		
		$html_icon = '';
		
		$html_input = $this->htmlFormWrapInput($element, $editor, $html_input);
		
		if(!empty($element['icon'])){
			
			$style_attr = $editor ? ' style="'.(!empty($element['icon']) ? $this->buildStyle($element['icon']['css']['default']) : $this->icon_style).'"' : '';
			
			$icon_fontawesome_id = isset($element['icon']['fontawesome_id']) ? $element['icon']['fontawesome_id'] : '';
			
			$icon_html_id = isset($element['icon']['id']) ? $element['icon']['id'] : '';
			
			$html_icon = ($icon_fontawesome_id ? "\r\n\t\t\t" : '').$this->htmlIcon(array('fontawesome_id'=>$icon_fontawesome_id, 
																						'icon_c_style'=>$style_attr,
																						'element_id'=>$element['id'],
																						'id'=>$icon_html_id,
																						));
		}

		if(isset($element['icon']['align']) && $element['icon']['align'] === 'left'){
			$html_icon_and_input = $html_icon.$html_input;
		} else{
			$html_icon_and_input = $html_input.$html_icon;
		}
		
		return $html_icon_and_input;
	}
	
	function htmlWrapInputGroup($editor, $element, $html){
		
		$container_style = '';

		if($editor){

			$container_style = ' style="';

			if(!empty($element['input-group-c']['css']['default'])){
				$container_style .= $this->buildStyle($element['input-group-c']['css']['default']);
			} else{
				$container_style .= $this->buildStyle(isset($element['css'][$element['type']]['input-group-c']) ? $element['css'][$element['type']]['input-group-c'] : array());
			}
			
			$container_style .= '"';
		}

		$container_id = !empty($element['input-group-c']['id']) ? $element['input-group-c']['id'] : $this->htmlElementName($_SESSION['cfgenwp_form_element_id']).$this->inputgroup_c_suffix;

		$this->html_form_element = "\r\n\t\t".'<div class="cfgen-input-group" id="'.$container_id.'"'.$container_style.'>'
								  .$html
								  ."\r\n\t\t".'</div>';

		return $this;
	}

	function htmlWrapElementSet($element, $editor){

		$container_style = '';
	
		if($editor){
			
			$container_style = ' style="';
			
			if(!empty($element['element-set-c']['css']['default'])){
			
				if($element['type'] == 'hidden'){
					unset($element['element-set-c']['css']['default']['display']); // remove display:none so that the element-set can be displayed in the form builder
				}

				$container_style .= $this->buildStyle($element['element-set-c']['css']['default']);
				
			} else{
				if($element['type'] == 'radio' || $element['type'] == 'checkbox'){
					$container_style .= 'padding-top:'.$this->getCssPropertyDefaultValue('option', 'padding-top').';';
				} else{
					$container_style .= $this->buildStyle(isset($element['css'][$element['type']]['element-set-c']) ? $element['css'][$element['type']]['element-set-c'] : array());
				}
			}
			
			$container_style .= '"';
		}
		
		$container_id = !empty($element['element-set-c']['id']) ? $element['element-set-c']['id'] : $this->htmlElementName($_SESSION['cfgenwp_form_element_id']).$this->elementset_c_suffix;
		
		$this->html_form_element = "\r\n\r\n\t".'<div class="cfgen-e-set" id="'.$container_id.'"'.$container_style.'>'.$this->html_form_element."\r\n\t".'</div>'."\r\n";
		
		return $this;
	}

	function addConfigRow($array){

		$config_c_style = (isset($array['show']) && !$array['show']) ? ' style="display:none;"' : '';
		
		$config_c_class = !empty($array['class']) ? ' '.$array['class'] : '';
		
		$config_c_id = !empty($array['id']) ? ' id="'.$array['id'].'"' : '';
		
		$html = '<div class="cfgenwp-formconfig-c'.$config_c_class.'"'.$config_c_style.$config_c_id.'>'

					.'<div class="cfgenwp-formconfig-l">'
					.(!empty($array['left']) ? $array['left'] : '')
					.'</div>'

					.'<div class="cfgenwp-formconfig-r">'
					.(!empty($array['right']) ? $array['right'] : '')
					.'</div>'

					.'<div class="cfgenwp-clear"></div>'

				.'</div>';
		
		return $html;
	}
	
	
	function buildDatepicker($selector, $datepicker){
		
		$html = '';
		
		/**
		 * datepicker options must come after datepicker regional if we don't want datepicker regional format applying instead of datepicker options 
		 * once we instantiate the datepicker with the regional, options can only be changed with 'option', passing one single option object would not work
		 */
		
		if(!empty($datepicker['regional'])){
			$html .= "\t".'jQuery("'.$selector.'").datepicker(jQuery.datepicker.regional["'.$datepicker['regional'].'"]);'."\r\n";
		}
		
		$html .= "\t".'jQuery("'.$selector.'").datepicker("option", "changeMonth", true);'."\r\n";
		$html .= "\t".'jQuery("'.$selector.'").datepicker("option", "changeYear", true);'."\r\n";
		
		if(!empty($datepicker['disablepastdates'])){
			$html .= "\t".'jQuery("'.$selector.'").datepicker("option", "minDate", 0);'."\r\n";
		}
		
		if(!empty($datepicker['mindate']) && preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $datepicker['mindate'], $matches)){
			$html .= "\t".'jQuery("'.$selector.'").datepicker("option", "minDate", new Date('.$matches[1].', '.($matches[2]-1).', '.$matches[3].'));'."\r\n";
		}
		
		if(!empty($datepicker['maxdate']) && preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $datepicker['maxdate'], $matches)){
			$html .= "\t".'jQuery("'.$selector.'").datepicker("option", "maxDate", new Date('.$matches[1].', '.($matches[2]-1).', '.$matches[3].'));'."\r\n";
		}
		
		if(isset($datepicker['firstdayoftheweek'])){
			$html .= "\t".'jQuery("'.$selector.'").datepicker("option", "firstDay", '.$datepicker['firstdayoftheweek'].');'."\r\n";
		}
		
		if(!empty($datepicker['format'])){
			$html .= "\t".'jQuery("'.$selector.'").datepicker("option", "dateFormat", "'.$datepicker['format'].'");'."\r\n";
		}
		
		// Year range
		if(isset($datepicker['yearrange']['minus']) && ($datepicker['yearrange']['minus'] || $datepicker['yearrange']['minus'] === 0)){
			$yearrange_minus = $datepicker['yearrange']['minus'];
		} else{
			$yearrange_minus = $this->datepicker_default_yearrange_minus;
		}			
		
		if(isset($datepicker['yearrange']['plus']) && ($datepicker['yearrange']['plus'] || $datepicker['yearrange']['plus'] === 0)){
			$yearrange_plus = $datepicker['yearrange']['plus'];
		} else{
			$yearrange_plus = $this->datepicker_default_yearrange_plus;
		}
		
		if(isset($yearrange_minus) && isset($yearrange_plus)){
			$html .= "\t".'jQuery("'.$selector.'").datepicker("option", "yearRange", "-'.($yearrange_minus).':+'.$yearrange_plus.'");'."\r\n";
		}

		if(!empty($datepicker['disabledaysoftheweek'])){

			$js_disabledaysoftheweek = '';
			
			foreach($datepicker['disabledaysoftheweek'] as $day){
				$js_disabledaysoftheweek .= 'dt.getDay() == '.$day.' || ';
			}
			
			$js_disabledaysoftheweek = substr($js_disabledaysoftheweek, 0, -3);
			
			$html .= "\t".'jQuery("'.$selector.'").datepicker("option", "beforeShowDay", function(dt){return ['.$js_disabledaysoftheweek.'? false : true];});'."\r\n";
		}
		
		return $html;
	}

	
	function buildElementLabelId($id){
		return ($id.$this->label_suffix);
	}	
	
	function formatElementHtmlId($param){
		if(isset($param['form_id']) && $param['form_id']){
			return $this->element_name_prefix.$param['form_id'].'-'.$param['target_id'];
		} else{
			return $this->element_name_prefix.$param['target_id'];
		}
	}
	
	// ADD LABEL WRAP
	function htmlAddLabel($label_config){
		
		$this->html_form_element = "\r\n\r\n\t".'<label class="cfgen-label" id="'.$this->buildElementLabelId($label_config['element_id']).'" '.$label_config['style'].'>'
												  .'<span class="cfgen-label-value">'.$label_config['value'].'</span>'
												  .($label_config['required'] ? '<span class="cfgen-required">*</span>' : '')
												  .'</label>'
												  .$this->html_form_element;
		
		return $this;
	}

	
	function htmlSelectOption(){
		$html = '<option value="'.$this->newoption_default_value.'">'.$this->newoption_default_value.'</option>';
		return($html);
	}
	
	function addOptionContainer($element, $editor, $insert_attr, $linebreaks){
	
		$html_line_break = '';
		$tab = '';
		
		if($linebreaks == true){
			$html_line_break = "\r\n\t";
			$tab = "\t";
		} else{
			$html_line_break = '';
			$tab = '';
		}
		
		$html='';
		$i = 0;
		
		foreach($element['option']['set'] as $value){
		
			$attr_input = '';
			$attr_label = '';
			
			if($insert_attr){
				$option_name = (isset($value['id']) && $value['id']) ? $element['id'] : $this->htmlElementName($_SESSION['cfgenwp_form_element_id']);
				$option_id = (isset($value['id']) && $value['id']) ? $value['id'] : $this->htmlElementName($_SESSION['cfgenwp_form_element_id']).'-'.$i;
		
				$attr_input = 'name="'.$option_name.'" id="'.$option_id.'"';
				$attr_label = 'for="'.$option_id.'"';
			}

			$option_content_class = (isset($element['option']['container']['id']) && $element['option']['container']['id']) ? ' '.$element['option']['container']['id'] : '';
			
			if($editor){
				$option_content_class .= ' cfgenwp-formelement';
			}
			
			$option_content_style = '';
			
			if($editor){
				$css_filter = array('padding', '-webkit-border-radius', '-moz-border-radius', 'border-radius', 'border-width', 'border-style', 'border-color', 'background-color');

				$option_content_style = ' style="'.(!empty($element['option']['container']) ? $this->buildStyle($element['option']['container']['css']['default'], $css_filter) : $this->option_style).'"';
			}
			
			$checked = (isset($value['checked']) && $value['checked']) ? ' '.$this->checked : '';
			
			// no linebreak and tab in front of the label to prevent extra spacing between the input and the label
			$html .= $html_line_break.$tab.$tab.$tab.'<div class="cfgen-option-content '.($element['type'] === 'checkbox' ? 'cfgen-option-checkbox' : 'cfgen-option-radio').$option_content_class.'"'.$option_content_style.'>'
					.$html_line_break.$tab.$tab.$tab.'<input type="'.$element['type'].'" class="cfgen-form-value" '.$attr_input.' value="'.$this->htmlentities($value['value']).'"'.$checked.'>'
					.'<label '.$attr_label.'>'.$value['value'].'</label>'
					.$html_line_break.$tab.$tab.$tab.'</div>';
					
			$i++;
		}
		
		return($html);
	}
	
	
	function divEditOptionContainer($optiontype, $value, $checked){
		
		if($optiontype == 'select'){
			$img_uncheck = 'ui-radio-button-uncheck.png';
			$img_check = 'ui-radio-button.png';
		}
		
		if($optiontype == 'radio'){
			$img_uncheck = 'ui-radio-button-uncheck.png';
			$img_check = 'ui-radio-button.png';
		}
		
		if($optiontype == 'checkbox' || $optiontype == 'selectmultiple'){
			$img_uncheck = 'ui-check-box-uncheck.png';
			$img_check = 'ui-check-box.png';
		}
		
		$uncheck_style_display_option = $checked ? ' display:none; ' : '';
		$check_style_display_option = $checked ? '' : ' display:none; ';
		
		// the class "selected" is necessary to make it work properly (contactformeditor.js)
		// the class "selected" is only added on radiocheck
		$check_class_selected = $checked ? ' selected ' : '';
		
		
		$html = '<div class="cfgenwp-editoption-c">'
					.'<input type="text" value="'.$this->htmlentities($value).'" class="cfgenwp-editoption-value '.$optiontype.' " >'
					.'<span class="cfgenwp-editoption-add '.$optiontype.'" ><img src="img/plus-button.png" title="Add an option" ></span>'
					.'<span class="cfgenwp-editoption-delete '.$optiontype.'"><img src="img/cross-button.png" title="Delete this option" ></span>'
					.'<span class="cfgenwp-editoption-default '.$optiontype.' radiouncheck" style="'.$uncheck_style_display_option.'"><img src="img/'.$img_uncheck.'" title="Make this option preselected" ></span>'
					.'<span class="cfgenwp-editoption-default '.$optiontype.' radiocheck '.$check_class_selected.'" style="'.$check_style_display_option.'"><img src="img/'.$img_check.'" title="Unselect this option" ></span>'
					.'<span class="cfgenwp-sortoption-handle"><img src="img/arrow-move.png" title="Move this element"  style="cursor:move;" ></span>'
				.'</div>';

		return($html);
	}
	
	function setUpColorPicker($config, $insert_script_tag){
		
		/*
		$insert_script_tag = false for the color pickers of the top bar (calls are made directly in contactformeditor.js
		$insert_script_tag = true when setting up color pickers for elements editor
		*/
		if($insert_script_tag){?>
			<script>jQuery(function(){ jQuery('#<?php echo $config['colorpicker_input_id'];?>').cfgen_colorkit();} );</script>
			<?php
		}
		
		$inputvalue_style_color = '#ffffff';
		if($config['colorpicker_color'] == '#ffffff'){$inputvalue_style_color = '#000000';}
		if($config['colorpicker_color'] == '#000000'){$inputvalue_style_color = '#ffffff';}
		
		
		$config['colorpicker_class'] = isset($config['colorpicker_class']) ? $config['colorpicker_class'] : '';
		
		$html = '<div class="cfgenwp-colorpicker-c">'
		
						.'<input type="text" '
								.'id="'.$config['colorpicker_input_id'].'" '
								.'data-cfgenwp_colorpicker_target="'.$this->htmlEntities($config['colorpicker_target']).'" '
								/* ^-- htmlentities for selectors with double quotes such as input */
								.(isset($config['colorpicker_objecttype']) ? 'data-cfgenwp_colorpicker_objecttype="'.$config['colorpicker_objecttype'].'"' : '')
								.'data-cfgenwp_colorpicker_csspropertyname="'.$config['colorpicker_csspropertyname'].'" '
								.(isset($config['colorpicker_applytoall']) ? 'data-cfgenwp_colorpicker_applytoall="'.$config['colorpicker_applytoall'].'"' : '')
								.(isset($config['colorpicker_paletteonly']) ? 'data-cfgenwp_colorpicker_paletteonly="'.$config['colorpicker_paletteonly'].'"' : '')
								.'value="'.$config['colorpicker_color'].'" '
								.'class="cfgenwp-colorpicker-value '.$config['colorpicker_class'].'" '
								.'style="background-color:'.$config['colorpicker_color'].'; color:'.$inputvalue_style_color.';" >'
						
						.'<div class="cfgenwp-colorpicker-ico" style="background-color:'.$config['colorpicker_color'].'"><img src="img/ui-color-picker.png" alt="" ></div>'
						.'<div class="cfgenwp-colorpicker-wheel"></div>'
						.'<div class="cfgenwp-clear"></div>'
						
					.'</div>'
					;

		return($html);
	}
	
	function buildUploadJsFunction($value){

		// file_upload_limit : 0 unlimited uploads authorized (the user can upload as many files as he wants)
		// file_queue_limit : 1 no multiple downloads at once
		
		// in order to prevent dashes in variables names in upload.js => var swfupload_cfg_element_1;
		$value['id'] = str_replace('-', '_', $value['id']);
		
		$js = 'var swfupload_'.$value['id'].'; // this variable name is also used in onclick="cfg_upload_xxx.cancelQueue();"
				jQuery(function(){
					var swfupload_'.$value['id'].' = new SWFUpload({
											flash_url : "'.$this->dir_form_inc.'/js/swfupload/swfupload.swf",
											upload_url: "'.$this->dir_form_inc.'/inc/upload.php?btn_upload_id='.$value['btn_upload_id'].'",
											post_params: {"PHPSESSID" : "'.session_id().'"},
											file_size_limit : "'.$value['file_size_limit'].'",
											file_types : "'.$value['file_types'].'",
											file_types_description : "All Files",
											file_upload_limit : 0,
											file_queue_limit : 1,
											custom_settings : {
												progressTarget : "fsUploadProgress_'.$value['id'].'",
												cancelButtonId : "btnCancel_'.$value['id'].'"
											},
											debug: false,
											
											// Button settings
											button_image_url: "'.$this->dir_form_inc.'/js/swfupload/img/upload-button.png",
											button_width: "130",
											button_height: "31",
											button_placeholder_id: "'.$value['btn_upload_id'].'",

											button_action:SWFUpload.BUTTON_ACTION.SELECT_FILE, // when the Flash button is clicked the file dialog will only allow a single file to be selected
											button_cursor: SWFUpload.CURSOR.HAND,
									
											// The event handler functions are defined in handlers.js
											file_queued_handler : fileQueued,
											file_queue_error_handler : fileQueueError,
											file_dialog_complete_handler : fileDialogComplete,
											upload_start_handler : uploadStart,
											upload_progress_handler : uploadProgress,
											upload_error_handler : uploadError,
											upload_success_handler : uploadSuccess, // uploadSuccess in handlers.js
											upload_complete_handler : uploadComplete // FileProgress.prototype.setComplete in fileprogress.js
										});
						/* queue_complete_handler : queueComplete	// queueComplete in handlers.js, Queue plugin event */

				});'
				."\r\n\r\n";
			
		return $js;
	}
	
	function closeEditContainer(){
		return ('<div class="cfgenwp-e-editor-close-c"><span class="cfgenwp-e-editor-close-t">Close</span></div>');
	}
	
	function buildStyle($style, $filter = array()){
		$load_element_style = '';
		
		foreach($style as $css_property => $css_value){

			if(!in_array($css_property, $filter)){
				
				// add quotes on the font family name if it contains spaces: Trebuchet MS=> 'Trebuchet MS'
				if($css_property == 'font-family' && preg_match("/\\s/", $css_value)){
					$css_value = '\''.$css_value.'\'';
				}
				
				$load_element_style .= $css_property.':'.$css_value.';';
			}
		}
		
		return $load_element_style;
	}

	
	function buildFormDefaultCss($config, $selector_filter = array()){
		$css_concat = '';
		
		if(isset($config['default'])){
			foreach($config['default'] as $selector=>$css){
				if(!in_array($selector, $selector_filter)){
					$css_concat .= $this->buildCssElement($selector, $css);
				}
			}
		}
		
		if(isset($config['mediaquery'])){
			$css_concat .= $this->buildCssElement($config['mediaquery'], array(), array(), '', true);
		}
		
		return $css_concat;
	}
	
	function buildCssElement($selector, $css, $filter = array(), $state = '', $mediaquery = false){

		$content_css = '';
		
		$filter = array_merge($filter);
		
		if(!$mediaquery){

			$css_property_value_pairs = '';
			
			foreach($css as $css_property_name=>$css_property_value){
				
				if(!in_array($css_property_name, $filter)){
					
					// add quotes on the font family name if it contains spaces: Trebuchet MS=> 'Trebuchet MS'
					if($css_property_name == 'font-family'){
						
						$concat_fontfamily = '';
						$concat_fontfamily_separator = ', ';
						
						$exp_fontfamily = explode(',', $css_property_value);
						
						foreach($exp_fontfamily as $exp_fontfamily_v){
							
							$exp_fontfamily_v = trim($exp_fontfamily_v);
							
							$concat_fontfamily .= (preg_match("/\\s/", $exp_fontfamily_v) ? '\''.$exp_fontfamily_v.'\'' : $exp_fontfamily_v).$concat_fontfamily_separator;
						}
						
						$css_property_value = substr($concat_fontfamily, 0, -strlen($concat_fontfamily_separator));
					}
				
					$css_property_value_pairs .= "\r\n\t".$css_property_name.':'.$css_property_value.';';
				}
			}
			
			if($css_property_value_pairs){

				if(is_string($selector)){
					$content_css = $selector.($state ? ':'.$state : '').'{';
				}
				
				if(is_array($selector)){
					$content_css = implode(($state ? ':'.$state : '').','."\r\n", $selector).($state ? ':'.$state : '').'{';
				}

				$content_css .= $css_property_value_pairs."\r\n".'}'."\r\n";	
			}
			
		} else{
			
			foreach($selector as $mediaquery_k => $mediaquery_v){
				
				$content_css .= $mediaquery_k.'{';
				
				foreach($mediaquery_v as $css_property_name=>$css_property_value){
					$content_css .= "\r\n".$this->buildCssElement($css_property_name, $css_property_value);
				}
				
				$content_css .= "\r\n".'}'."\r\n";
			}
		}
		
		return $content_css;
	}
	
	
	function htmlElementName($id){
		return ($this->element_name_prefix.$id);
	}
	
	function getLabelValueFromJson($element){
		// label is not necessarily set when dealing with placeholder attribute
		return (!empty($element['label']['value']) ? $element['label']['value'] : '');
	}
	
	function formIncDirName($form_id){
		return $this->dir_form_inc.'-'.$form_id;
	}
	
	function getFormsIndex(){
		$index_file_content = @file_get_contents($this->formsindex_filename_path);
		$json_form_index = json_decode(substr($index_file_content, -(strlen($index_file_content)-strlen($this->formsindex_protection))), true);
		return $json_form_index;
	}
	
	function writeFormsIndex($c){
		$index_file = fopen($this->formsindex_filename_path, 'w+');
		fwrite($index_file, $this->formsindex_protection.$c);
		fclose($index_file);
	}
	
	function resetFormsIndex(){
		$index_file = @fopen($this->formsindex_filename_path, 'w+');
		@fwrite($index_file, $this->formsindex_reset_content);
		@fclose($index_file);
	}
	

	/**
	 * Delete duplicate directory and copy source files
	 */
	// removes files and non-empty directories
	function rrmdir($dir){
		
		if(is_dir($dir)){
			
			$objects = scandir($dir); 
			foreach($objects as $object){ 
				if($object != "." && $object != ".."){ 
					if(filetype($dir."/".$object) == "dir"){
						//echo "rrmdir DIR/OBJECT: $dir/$object"."\r\n";
						$this->rrmdir($dir."/".$object);
					}
					else{
						//echo "unlink DIR/OBJECT: $dir/$object"."\r\n";
						@unlink($dir."/".$object); 
					}
				}
			}
			reset($objects); 
			@rmdir($dir); 
		} 
	} 
	
	// copies files and non-empty directories
	function rcopy($src, $dst){
		
		if(file_exists($dst)) $this->rrmdir($dst); // delete the directory if it exists
		
		if(is_dir($src)){
			@mkdir($dst);
			//echo "MK DIR DST: $dst"."\r\n";
			
			$files = scandir($src);
			foreach($files as $file){
				if($file != "." && $file != ".."){
					$this->rcopy("$src/$file", "$dst/$file");
				}
			}
		}
		else if (file_exists($src)){
			@copy($src, $dst);
		}
	}

	
	function quote_smart($value){
		
		if(get_magic_quotes_gpc()){
			$value = stripslashes($value);
		}
		
		return $value;
	}

	function isEmail($email){
		
		$atom = '[-a-z0-9\\_]'; // authorized caracters before @
		$domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)'; // authorized caracters after @

		$regex = '/^' . $atom . '+' . '(\.' . $atom . '+)*' . '@' . '(' . $domain . '{1,63}\.)+' . $domain . '{2,63}$/i';
		
		return preg_match($regex, trim($email)) ? 1 : 0;
	}
	
	function isphp5(){
		if(strnatcmp(phpversion(),'5.2.0') >=0){
			return true;
		}
	}
	
	
	function authentication($redir){
		
		global $cfgenwp_config;
		
		// 1. the display of the login box is based on wether $_SESSION['user'] is set or not
		// 2. if the config file is missing or if the user deletes the config file after he created the account
		if(!isset($cfgenwp_config['account']['login']) || !isset($cfgenwp_config['account']['password'])){
			unset($_SESSION['user']);
			$cfgenwp_config['account']['login'] = '';
			$cfgenwp_config['account']['password'] = '';
		}
		
		if(!isset($_SESSION['user']) || !$_SESSION['user']){
			
			$this->setSessionByCookie($cfgenwp_config['account']['login'], $cfgenwp_config['account']['password']);
			
			/**
			 * no session, no cookie
			 * the header location must be applied only if authentication is called from a page different
			 * from the index (listing)
			 * this redirection is not applied when we are on index (listing) as it would cause an infinite redirection loop
			 */
			if($redir && (!isset($_SESSION['user']) || !$_SESSION['user'])){
				header('Location: ../index.php');
				exit;
			}
		} // isset session
	}
	
	function setSessionByCookie($login_on_file, $password_on_file){
		
		if(isset($_COOKIE['user']) && $_COOKIE['user']){

			$auth_exp = explode('*', $_COOKIE['user']);

			$cookie_login = $auth_exp[0];

			$cookie_password = $auth_exp[1];
			
			// SET THE SESSION IF THE LOGIN AND PASSWORD ON FILE MATCH WITH THE COOKIE
			if($cookie_login && $cookie_login == $login_on_file && $cookie_password && $cookie_password == $password_on_file){
				$_SESSION['user'] = $login_on_file;
			}
		}
	}
	
	function setUserCookie($cfgenwp_config){
		$cookie_expire_in_days = 30;
		
		// don't prefix $_SERVER['SERVER_ADMIN'] with . => the cookie won't be installed in chrome and opera
		setcookie('user', $cfgenwp_config['account']['login'].'*'.$cfgenwp_config['account']['password'], time()+60*60*24*$cookie_expire_in_days, '/', $_SERVER['SERVER_NAME']);
	}
	
	function deleteUserCookie(){
		setcookie('user', '', time() - 3600, '/', $_SERVER['SERVER_NAME']);
	}
	
	
	function elementSettingsTitle($value){
		$html = '<div class="cfgenwp-e-properties-t">'.$value.'</div>';
		return $html;
	}
	
	function elementPropertyName($value){
		$html = '<div class="cfgenwp-e-property-l">'.$value.'</div>';
		return $html;
	}
	
	function openEditProperties($options = array()){
		
		$style = isset($options['style']) ? ' style="'.$options['style'].'"' : '';
		
		return '<div class="cfgenwp-e-properties-c"'.$style.'>';
	}
	
	function openElementPropertyValue(){
		return '<div class="cfgenwp-e-property-r">';
	}
	
	function closeDiv(){		
		return '</div>';
	}
	
	function isWritable($filename){
		
		$this->setWritable($filename);
		
		return is_writable($filename);
	}
	
	function setWritable($filename){
		
		if(!is_writable($filename)){
			
			@chmod($filename, 0755);
			
			if(!is_writable($filename)){				
				@chmod($filename, 0777);
			}
		}
	}

	function includeConfig(){
		
		$cfgenwp_config['googlewebfontsapikey'] = '';
		$cfgenwp_config['smtp']['host'] = '';
		$cfgenwp_config['smtp']['port'] = '';
		$cfgenwp_config['smtp']['encryption'] = '';
		$cfgenwp_config['smtp']['username'] = '';
		$cfgenwp_config['smtp']['password'] = '';
		$cfgenwp_config['aweber']['authorizationcode'] = '';
		$cfgenwp_config['aweber']['consumerkey'] = '';
		$cfgenwp_config['aweber']['consumersecret'] = '';
		$cfgenwp_config['aweber']['accesstokenkey'] = '';
		$cfgenwp_config['aweber']['accesstokensecret'] = '';
		$cfgenwp_config['campaignmonitor']['apikey'] = '';
		$cfgenwp_config['constantcontact']['apikey'] = '';
		$cfgenwp_config['constantcontact']['accesstoken'] = '';
		$cfgenwp_config['getresponse']['apikey'] = '';
		$cfgenwp_config['icontact']['appid'] = '';
		$cfgenwp_config['icontact']['username'] = '';
		$cfgenwp_config['icontact']['password'] = '';
		$cfgenwp_config['mailchimp']['apikey'] = '';
		$cfgenwp_config['salesforce']['accesstoken'] = '';
		$cfgenwp_config['salesforce']['username'] = '';
		$cfgenwp_config['salesforce']['password'] = '';

		if(file_exists($this->config_filename_path)){
			
			include($this->config_filename_path);
			//print_r($cfgenwp_config);echo '<hr>';

			return $cfgenwp_config;
		}
	}
	
	function htmlEntities($string){
		return htmlentities($string, ENT_QUOTES, 'utf-8');
	}
	

	
	function getLinkGoogleWebFonts($googlewebfonts, $editor = false){
		
		// if $editor is set to true, we load all the variants possible
		
		$html = '';
		
		$googlewebfont_concat = '';
		
		$googlewebfont_pipe = '%7C';
		
		foreach($googlewebfonts as $googlewebfonts_k=>$googlewebfonts_v){
			
			if(!$editor){
				$cfgenwp_gwf_variant = '';
		
				foreach($googlewebfonts_v['variants'] as $googlewebfonts_v_variant){
					$cfgenwp_gwf_variant .= $googlewebfonts_v_variant.',';
				}
			
				$cfgenwp_gwf_variant = substr($cfgenwp_gwf_variant, 0, -1);
			} else{
				$cfgenwp_gwf_variant = $this->googlewebfonts_variants;
			}
			
			$googlewebfont_concat .= str_replace(' ', '+', $googlewebfonts_v['family']).':'.$cfgenwp_gwf_variant.$googlewebfont_pipe;
	
		}
		
		if($googlewebfont_concat){
			$googlewebfont_concat = substr($googlewebfont_concat, 0, -strlen($googlewebfont_pipe));
			
			$html = '<link href="//fonts.googleapis.com/css?family='.$googlewebfont_concat.'" rel="stylesheet" type="text/css">';
		}
		
		return $html;
	}
	
	function getNumbersOnly($var){
		return(preg_replace('/[^0-9\.]/', '', $var));
	}
	
	function editFormMessageStyle($config){
		
		$select_attr_data = array('cfgenwp_object_type'=>$config['object_type']);
		
		$this->editorpanel->createPanel('Font style');
		
		$this->editorpanel->addProperty($this->addEditFontFamily(array(
																	'fontfamily_value'=>$config['fontfamily_value'], 
																	'data_attr'=>array_merge($select_attr_data, array('cfgenwp_fontfamily_selected'=>$config['fontfamily_value'], 'cfgenwp_fontweight_selected'=>$config['fontweight_value'])))));
		
		$slider_element_fontsize = $this->addSelectSlider(array(
																'slider_id'=>$config['fontsize_slider_id'],
																'slider_function'=>'cfgen_sliderFormMessageFontSize',
																'select_class'=>'cfgenwp-formmessage-fontsize-select',
																'option_min'=>$this->slider_fontsize_min, 
																'option_max'=>$this->slider_fontsize_max, 
																'option_selected'=>$config['fontsize_value'],
																));

		$this->editorpanel->addProperty( array(  array('name'=>'Font size', 'values'=>array($slider_element_fontsize))  ) );

		$this->editorpanel->addProperty($this->addEditFontWeight(array(
																	'fontweight_value'=>$config['fontweight_value'], 
																	'data_attr'=>array_merge($select_attr_data, array('cfgenwp_fontfamily_selected'=>$config['fontfamily_value']))
																	), $this->getFontVariants($config['fontfamily_value'], 'fontweight')));

		$this->editorpanel->addProperty($this->addEditFontStyle(array(
																	'fontstyle_value'=>$config['fontstyle_value'], 
																	'data_attr'=>array_merge($select_attr_data, array('cfgenwp_fontfamily_selected'=>$config['fontfamily_value']))
																	), $this->getFontVariants($config['fontfamily_value'], 'fontstyle')));
										
		$this->editorpanel->addProperty( array(  array('name'=>'Color', 'values'=>array($this->setUpColorPicker($config['color'], false)))  ) );
		
		$this->editorpanel->addProperty( array(  array('name'=>'Background', 'values'=>array($this->setUpColorPicker($config['background-color'], false)))  ) );
		
		if($config['type'] == 'validation'){?>
			<script>
			jQuery(function(){
				// FORM MESSAGE SLIDER WIDTH
				jQuery('#<?php echo $config['width_slider_id'];?>').slider(
				{
					range: 'min',
					min: 150,
					max: 530,
					value: <?php echo $this->getNumbersOnly($config['width_value']);?>,
					step: 1
				}).on('slide slidechange', 
							function(event, ui){
								jQuery('#<?php echo $config['width_slider_target_id'];?>').css('width', ui.value);
								jQuery(this).cfgen_sliderUpdateInputValue(ui.value);
							});
			});
			</script>
			<?php
			$slider = '<input type="text" class="cfgenwp-formmessage-width-input-value cfgenwp-slider-input-value" value="'.$config['width_value'].'">px'
					 .'<div id="'.$config['width_slider_id'].'"></div>';
					  
			$this->editorpanel->addProperty( array(  array('name'=>'Width', 'values'=>array($slider))  ) );
		}

		$this->editorpanel->getEditor();
	}
	
	function isGoogleWebFont($fontfamily){
		return (isset($_SESSION['cfgenwp_googlewebfonts_list']['item'][$fontfamily]) ? $_SESSION['cfgenwp_googlewebfonts_list']['item'][$fontfamily] : false);
	}
	
	function getFontVariants($fontfamily, $fontproperty){
	
		$filter = array();
		//echo 'search "'.$fontfamily.'" in gwo list<br>';
		
		if($gwf = $this->isGoogleWebFont($fontfamily)){
			$filter = $gwf['variants'];
			// echo 'gwo font found<br>';
		} else{
			if($fontproperty == 'fontweight'){
				$filter = array('normal', 'bold', '400', '700');
			}
			if($fontproperty == 'fontstyle'){
				$filter = array('normal', 'italic');
			}
		}
		// print_r($filter);
		return $filter;
	}
	
}
// THERE MUST BE NO BLANK LINES AFTER THE CLOSING TAG IN ORDER TO PREVENT :
// Warning: Cannot modify header information - headers already sent 
// in editor/inc/form-login.php
?>