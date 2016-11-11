<?php
/**********************************************************************************
* Contact Form Generator is (c) Top Studio
* It is strictly forbidden to use or copy all or part of an element other than for your 
* own personal and private use without prior written consent from Top Studio http://topstudiodev.com
* Copies or reproductions are strictly reserved for the private use of the person 
* making the copy and not intended for a collective use.
*********************************************************************************/

$cfgenwp_form_css = array();

$cfgenwp_form_css['default']['body'] = array('background-color'=>'#f7f7f7');

$cfgenwp_form_css['default']['.cfgen-clear'] = array('clear'=>'both');

$cfgenwp_form_css['default']['.cfgen-form-container'] = array('padding'=>'30px', 'border'=>'1px solid #EEE', 'background-color'=>'#FFF', 'border-radius'=>'4px', 
															/* box sizing property is not merged with other elements because cfgen-form-container is not inside id="cfg-form-XXX", it is id="cfg-form-XXX" */
															'-webkit-box-sizing'=>'border-box', '-moz-box-sizing'=>'border-box', '-ms-box-sizing'=>'border-box', 'box-sizing'=>'border-box', 'max-width'=>'100%');

$cfgenwp_form_css['default']['.ui-datepicker'] = array('font-size'=>'9pt !important');

$cfgenwp_form_css['default']['.cfgen-e-c'] = array('clear'=>'both', 'margin-bottom'=>'16px');

$cfgenwp_form_css['default']['.cfgen-icon-c + .cfgen-input-c'] = array('display'=>'table-cell', 'width'=>'100%', 'vertical-align'=>'top');

$cfgenwp_form_css['default']['.cfgen-option-set::after'] = array('content'=>'"."', /* restore margin bottom when elements are floating */ 'display'=>'block', 'height'=>'0', 'clear'=>'both', 'visibility'=>'hidden',);

$cfgenwp_form_css['default']['.cfgen-label'] = array('display'=>'block', 'padding-right'=>'10px', 'max-width'=>'100%'); /* using padding and not margin to make the spacing work when table-cell display is applied on label */

$cfgenwp_form_css['default']['.cfgen-terms input'] = array('vertical-align'=>'middle', 'margin-top'=>'0');

$cfgenwp_form_css['default']['.cfgen-paragraph'] = array('margin-bottom'=>'1px'); /* IE (for paragraphs above <select>) */

$cfgenwp_form_css['default']['.cfgen-captcha-c'] = array('margin-top'=>'2px');

$cfgenwp_form_css['default']['.cfgen-captcha-img'] = array('border'=>'1px solid #dcdcdc', 'border-radius'=>'4px', 'margin-bottom'=>'1px',);

$cfgenwp_form_css['default']['.cfgen-captcha-refresh'] = array('margin-bottom'=>'2px', 'margin-left'=>'2px', 'cursor'=>'pointer',);

$cfgenwp_form_css['default']['.cfgen-submit'] = array('cursor'=>'pointer', 'height'=>'auto', '-webkit-appearance'=>'none',);

$cfgenwp_form_css['default']['.cfgen-required'] = array('color'=>'#990000');

$cfgenwp_form_css['default']['.cfgen-uploadsuccess-c'] = array('margin-top'=>'10px', 'font-family'=>'Verdana, Geneva, sans-serif', 'font-size'=>'12px',);

$cfgenwp_form_css['default']['.cfgen-deleteupload'] = array('color'=>'#ff0033', 'margin-left'=>'10px', 'cursor'=>'pointer',);

$cfgenwp_form_css['default']['.cfgen-deleteupload:hover'] = array('text-decoration'=>'underline');

$cfgenwp_form_css['default']['.cfgen-loading'] = array('display'=>'none', 'background'=>'url(\'../img/loading.gif\') no-repeat 0 1px', 'width'=>'16px', 'height'=>'16px',);

$cfgenwp_form_css['default']['.cfgen-errormessage, .cfgen-validationmessage'] = array('padding'=>'8px 8px', 'line-height'=>'normal', 'border-radius'=>'4px');

$cfgenwp_form_css['default']['.cfgen-validationmessage'] = array('margin'=>'0 0 10px 0',);

$cfgenwp_form_css['default']['.cfgen-errormessage'] = array('display'=>'none', 'margin'=>'4px 0',);

$cfgenwp_form_css['default']['.cfgen-option-content'] = array('max-width'=>'100%');

$cfgenwp_form_css['default']['.cfgen-option-radio'] = array('margin-bottom'=>'4px');

$cfgenwp_form_css['default']['.cfgen-option-checkbox'] = array('margin-bottom'=>'2px');

$cfgenwp_form_css['default']['.cfgen-option-content input[type=radio], .cfgen-option-content input[type=checkbox]'] = array('margin-right'=>'2px', 'margin-left'=>'1px', 'vertical-align'=>'middle');

$cfgenwp_form_css['default']['.cfgen-option-content input[type=checkbox]'] = array('margin-top'=>'0');

$cfgenwp_form_css['default']['.cfgen-option-content input[type=radio]'] = array('margin-top'=>'-2px');

$cfgenwp_form_css['default']['.cfgen-icon-c'] = array('text-align'=>'center', 'display'=>'table-cell', 'vertical-align'=>'middle', 'padding'=>'4px');

$cfgenwp_form_css['default']['.cfgen-rating-c .fa'] = array('cursor'=>'pointer');

$cfgenwp_form_css['default']['.cfgen-input-c input[type="text"], .cfgen-input-c select, .cfgen-input-c input[type="submit"], .cfgen-input-c textarea'] 
						= array('outline-style'=>'none',);

$cfgenwp_form_css['default']['.cfgen-input-c input[type="text"], .cfgen-input-c textarea, .cfgen-input-c input[type="submit"]'] 
						= array('width'=>'100%',);

$cfgenwp_form_css['default']['.cfgen-input-c input[type="text"], .cfgen-input-c select, .cfgen-input-c input[type="submit"], .cfgen-input-c textarea, .cfgen-icon-c, .cfgen-label, .cfgen-paragraph, .cfgen-errormessage, .cfgen-validationmessage'] 
						= array('-webkit-box-sizing'=>'border-box', '-moz-box-sizing'=>'border-box', '-ms-box-sizing'=>'border-box', 'box-sizing'=>'border-box',);

$cfgenwp_form_css['default']['.cfgen-label, .cfgen-paragraph, .cfgen-errormessage, .cfgen-validationmessage'] 
						= array('max-width'=>'100%',);

$cfgenwp_mediaquery_css_key = '@media only screen and (min-width: 320px), only screen and (max-width: 320px)';
$cfgenwp_form_css['mediaquery'][$cfgenwp_mediaquery_css_key]['.cfgen-form-container'] = array('width'=>'300px', 'margin'=>'2px auto',);

$cfgenwp_mediaquery_css_key = '@media only screen and (min-width: 480px)';
$cfgenwp_form_css['mediaquery'][$cfgenwp_mediaquery_css_key]['.cfgen-form-container'] = array('width'=>'440px');

$cfgenwp_mediaquery_css_key = '@media only screen and (min-width: 600px)';
$cfgenwp_form_css['mediaquery'][$cfgenwp_mediaquery_css_key]['.cfgen-form-container'] = array('width'=>'580px');

$cfgenwp_mediaquery_css_key = '@media only screen and (min-width: 768px)';
$cfgenwp_form_css['mediaquery'][$cfgenwp_mediaquery_css_key]['.cfgen-form-container'] = array('width'=>'680px');
?>