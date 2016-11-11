var elements = [];
var element_id;
var cfgenwp_init_index_element = 0;
var cfgenwp_list_field_selected_element_id = [];
var cfgenwp_googlewebfonts_added = [];
var cfgenwp_js_gwf_variants_url_param = '100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic,100,200,300,400,500,600,700,800,900';
var cfgenwp_element_container_default_height = {};


jQuery(function(){
	var cfgenwp_dialog_box = jQuery('#cfgenwp-dialog-message');
	jQuery.cfgenwp_dialog_box = cfgenwp_dialog_box; // creating this property in jQuery in order to be able to access the property in index pages
	cfgenwp_dialog_box.dialog({autoOpen: false, modal: true, resizable:false, draggable:false, position: ['center', 200], width:460});
	
	// Saving the aweber credentials for the scenario: aweber added auth code loaded, sign in as a different use, close, aweber added
	var aweber_authorizationcode_cache = {};
	var span_required = '<span class="cfgen-required">*</span>';
	var saveform_btn = jQuery('#cfgenwp-saveform');
	var saveform_btn_add = 'Save and create source files 3';
	var saveform_btn_update = 'Save and update 4';
	var form_editor = jQuery('#cfgenwp-fb-form');
	var form_settings = jQuery('#cfgenwp-formsettings');
	var form_id = jQuery('#cfgenwp-form-id');
	var returntoformedition_btn = jQuery('#cfgenwp-returntoformedition');
	var formmessage_validation_style_c = jQuery('#cfgenwp-formmessage-validation-style-c');
	var formmessage_error_style_c = jQuery('#cfgenwp-formmessage-error-style-c');
	var label_fontfamily_select = jQuery('#cfgenwp-label-fontfamily-select');
	var label_fontweight_select = jQuery('#cfgenwp-label-fontweight-select');
	var label_fontstyle_select = jQuery('#cfgenwp-label-fontstyle-select');
	var label_fontsize_select = jQuery('#cfgenwp-label-all-fontsize-select');
	var input_fontfamily_select = jQuery('#cfgenwp-input-fontfamily-select');
	var input_fontweight_select = jQuery('#cfgenwp-input-fontweight-select');
	var input_fontsize_select = jQuery('#cfgenwp-input-all-fontsize-select');
	var input_fontstyle_select = jQuery('#cfgenwp-input-fontstyle-select');
	var input_padding_select = jQuery('#cfgenwp-input-all-padding-select');
	var paragraph_fontfamily_select = jQuery('#cfgenwp-paragraph-fontfamily-select');
	var paragraph_fontweight_select = jQuery('#cfgenwp-paragraph-fontweight-select');
	var paragraph_fontsize_select = jQuery('#cfgenwp-paragraph-all-fontsize-select');
	var paragraph_fontstyle_select = jQuery('#cfgenwp-paragraph-fontstyle-select');
	var title_fontfamily_select = jQuery('#cfgenwp-title-fontfamily-select');
	var title_fontweight_select = jQuery('#cfgenwp-title-fontweight-select');
	var title_fontsize_select = jQuery('#cfgenwp-title-all-fontsize-select');
	var title_fontstyle_select = jQuery('#cfgenwp-title-fontstyle-select');	
	var openform_list = jQuery('#cfgenwp-openform-list');
	var openform_btn = jQuery('#cfgenwp-openform-btn');
	var toolbar_c = jQuery('#cfgenwp-formbuilder-toolbar');
	var loadformdata_c = jQuery('#cfgenwp-loadform-data-c');
	var form_config_admin_notification_subject = jQuery('#cfgenwp-config-admin-notification-subject');
	var form_config_user_notification_message = jQuery('#cfgenwp-config-user-notification-message');
	var form_config_user_notification_activate = jQuery('#cfgenwp-config-user-notification-activate');
	var form_config_database_host = jQuery('#cfgenwp-database-host');
	var form_config_database_name = jQuery('#cfgenwp-database-name');
	var form_config_database_login = jQuery('#cfgenwp-database-login');
	var form_config_database_password = jQuery('#cfgenwp-database-password');
	var form_config_database_table = jQuery('#cfgenwp-database-table');
	var form_config_smtp_host = jQuery('#cfgenwp-smtp-host');
	var form_config_smtp_port = jQuery('#cfgenwp-smtp-port');
	var form_config_form_name = jQuery('#cfgenwp-config-form-name');
	var form_config_email_from = jQuery('#cfgenwp-config-email-from');
	var form_config_email_address = jQuery('#cfgenwp-config-email-address');
	var form_config_email_address_cc = jQuery('#cfgenwp-config-email-address-cc');
	var form_config_email_address_bcc = jQuery('#cfgenwp-config-email-address-bcc');
	var form_config_redirecturl = jQuery('#cfgenwp-config-redirecturl-input');
	var form_config_user_notification_insertformdata = jQuery('#cfgenwp-config-user-notification-insertformdata');
	var form_config_sms_admin_notification_activate = jQuery('#cfgenwp-sms-admin-notification-activate');
	var form_config_sms_admin_notification_gateway = jQuery('#cfgenwp-sms-admin-notification-gateway');
	var form_config_sms_admin_notification_to_phone_number = jQuery('#cfgenwp-sms-admin-notification-to-phone-number');
	var form_config_sms_admin_notification_message = jQuery('#cfgenwp-sms-admin-notification-message');
	var form_config_sms_admin_notification_clickatell_username = jQuery('#cfgenwp-sms-admin-notification-clickatell-username');
	var form_config_sms_admin_notification_clickatell_password = jQuery('#cfgenwp-sms-admin-notification-clickatell-password');
	var form_config_sms_admin_notification_clickatell_api_id = jQuery('#cfgenwp-sms-admin-notification-clickatell-api_id');
	var form_config_sms_admin_notification_twilio_account_sid = jQuery('#cfgenwp-sms-admin-notification-twilio-account_sid');
	var form_config_sms_admin_notification_twilio_from_phone_number = jQuery('#cfgenwp-sms-admin-notification-twilio-from_phone_number');
	var form_config_sms_admin_notification_twilio_auth_token = jQuery('#cfgenwp-sms-admin-notification-twilio-auth_token');
	
	/*********************************************************************************************************************************/
	jQuery('#cfgenwp-formbuilder-menu-elements').find('div.cfgenwp-addelement').draggable({
		appendTo:'body',
		helper:'clone', 
		connectToSortable: form_editor,

		start: function(event, ui){

			jQuery('.ui-draggable-dragging').addClass('cfgenwp-fb-e-move-c cfgenwp-menu-addelement-dragging');
		},
		
		drag: function(event, ui){
			
			jQuery('.ui-state-highlight').css({'height':'60px'});
		}
    });
	
	/*********************************************************************************************************************************/
	form_editor.on('focusin focusout', 'input.cfgen-form-value, select.cfgen-form-value, textarea.cfgen-form-value', function(e){
		jQuery(this).cfgen_inputFocus(e.type);
	});
	
	jQuery.fn.cfgen_inputFocus = function(event_type){

		var collection = jQuery(this); // the input

		var icon_c = collection.cfgen_closestElementCont().cfgen_findElementIconCont();
		/*
		if(icon_c.length){
			collection = collection.add(icon_c);
		}
		*/
		if(event_type == 'focusin'){
			collection.css('border-color', jQuery.cfgen_getCssPropertyValue('input', 'border-color', 'focus'));
		}

		if(event_type == 'focusout'){
			collection.css('border-color', jQuery.cfgen_getCssPropertyValue('input', 'border-color'));
		}
	}

	jQuery.cfgen_hasDigitsOnly = function(n){
		return n.match(/^[0-9]+$/) != null ? true : false;
	}
	
	jQuery.cfgen_getCssPropertyValue = function(object_type, property_name, state){
		state = typeof state !== 'undefined' ? state : 'default';
		return cfgenwp_css_properties[object_type][state][property_name];
	}
	
	jQuery.cfgen_setCssPropertyValue = function(object_type, property_name, property_value, state){
		
		//console.log(object_type+' '+property_name+' '+property_value+' '+state);
		
		state = typeof state !== 'undefined' ? state : 'default';
		
		if(cfgenwp_css_properties.hasOwnProperty(object_type)){
			// ^-- To prevent "Cannot read property 'default' of undefined" when changing properties for the form validation message and the form error message as they are not defined in cfgenwp_css_properties
			
			property_value = jQuery.trim(property_value);
			
			if(!property_value){
				delete cfgenwp_css_properties[object_type][state][property_name];
			} else{
				cfgenwp_css_properties[object_type][state][property_name] = property_value;	
			}
		}
	}

	jQuery.cfgen_appendPx = function(string){
		return (string+'px');
	}
	
	jQuery.cfgen_databaseIsActivated = function(){
		if(jQuery('#cfgenwp-config-database-activate:checked').length){
			return true;
		}
	}
	
	jQuery.cfgen_smsAdminNotificationIsActivated = function(){
		if(form_config_sms_admin_notification_activate.is(':checked')){
			return true;
		}
	}

	jQuery.cfgen_returnToFormEdition = function(){
		
		jQuery('#downloadsources').empty();

		var to_show = jQuery('#cfgenwp-fb-editor-c').add(toolbar_c);
		
		if(form_id.val()){		
			to_show = to_show.add(loadformdata_c);
		}

		to_show.css({'display':'block'});
		
		to_hide = jQuery('#cfgenwp-formsettings, #cfgenwp-form-error-msgs-c').add(jQuery('#cfgenwp-form-error-msgs-c').find('div.cfgenwp-form-error-msg-c'));
	
		jQuery(to_hide).css({'display':'none'});
		
	}

	jQuery.cfgen_smsAdminNotificationGatewayIsClickatell = function(){
		return form_config_sms_admin_notification_gateway.val() === 'clickatell' ? true : false;
	}

	jQuery.cfgen_smsAdminNotificationGatewayIsTwilio = function(){
		return form_config_sms_admin_notification_gateway.val() === 'twilio' ? true : false;
	}
	
	jQuery.fn.cfgen_resetImageContainer = function(){

		var fb_e_c = jQuery(this).cfgen_closestFbElementCont();

		fb_e_c.find('div.cfgen-input-group').empty().append(cfgenwp_html_empty_image_container);
		
		fb_e_c.cfgen_adjustElementHeightToRightContent();
	}
	
	jQuery.fn.cfgen_insertInputIcon = function(align, icon_to_clone){

		/**
		 * prepend() and append() methods allow to select an element on the page and insert it into another
		 * therefore detaching or removing the element moved is not necessary
		 */
		var input_group_c = jQuery(this).find('div.cfgen-input-group');

		if(align == 'left'){
			input_group_c.prepend(icon_to_clone);
		} else{
			input_group_c.append(icon_to_clone);
		}
		
		return icon_to_clone;
	}

	jQuery.fn.cfgen_iconContAdjustRecurs = function(){

		var icon_c = jQuery(this);
		
		var input = icon_c.cfgen_closestElementCont().find('input[type="text"]');
		
		var icon_c_outer_height = icon_c.outerHeight();
		
		if(input.outerHeight() < icon_c_outer_height){
			
			var new_icon_c_outer_height = (parseInt(icon_c.css('height')) - 1)+'px';
			
			var new_icon_c_font_size_int = (parseInt(icon_c.css('font-size')) - 1);
			var new_icon_c_font_size_px = new_icon_c_font_size_int+'px';
			
			// The else statement prevents an infinite loop from happening because FF and IE can't manage both height to match exactly when padding equals 0
			// The icon container ends up being 1 pixel larger
			if(new_icon_c_font_size_int >=1){

				icon_c.css({'font-size':new_icon_c_font_size_px});
				
				icon_c.cfgen_iconContAdjustRecurs();
				
				// This only happens which Chrome
				if(input.outerHeight() == icon_c.outerHeight()){
					// Same event below for FF and IE
					icon_c.cfgen_closestFbElementCont().cfgen_findElementEditorCont().find('select.cfgenwp-icon-fontsize-select').val(new_icon_c_font_size_int).trigger('change');
				}
				
			} else{
				// For FF and IE
				icon_c.cfgen_closestFbElementCont().cfgen_findElementEditorCont().find('select.cfgenwp-icon-fontsize-select').val(new_icon_c_font_size_int).trigger('change');
			}
		}
	}
	
	jQuery.fn.cfgen_sliderIconFontSize = function(res){

		var e_c = jQuery(this).cfgen_findElementContThroughFbElementCont();
		
		var icon_c = e_c.cfgen_findElementIconCont();
		
		icon_c.css({'font-size':res['value_px']});
		
		// ADJUST INPUT PADDING IF ICON HEIGHT != INPUT
		var icon_c_height = icon_c.outerHeight();
		var input = e_c.find('input[type="text"]');
		var input_height = input.outerHeight();
		
		if(input_height < icon_c_height){
			
			var slider_input_padding = jQuery('#cfgenwp-input-all-padding-slider');
			
			var input_current_padding = slider_input_padding.slider('option', 'value');

			var icon_height_minus_input_height = icon_c_height - input_height;
			input_padding_add = Math.round(icon_height_minus_input_height/2);
			
			var new_input_padding = parseInt(input_current_padding)+parseInt(input_padding_add);
			
			if(new_input_padding < 0){
				new_input_padding = 0;
			}
			
			// console.log('input height ('+input_height+') < icon height ('+icon_c_height+') | new padding ('+new_input_padding+') add '+input_padding_add+' to '+input_current_padding+'');
			
			slider_input_padding.slider('value', parseInt(new_input_padding));

		} else{
			//console.log('input height ('+input_height+') > icon height ('+icon_c_height+')');
		}
		
		jQuery.cfgen_setCssPropertyValue('icon', 'font-size', res['value_px']);
		
		jQuery(this).cfgen_triggerSliderIconContWidth();
	}
	
	jQuery.fn.cfgen_triggerSliderIconContWidth = function(){

		var src = jQuery(this); // this can be the icon id select or the font size select
		
		var e_editor_c = src.cfgen_closestFbElementCont().cfgen_findElementEditorCont();

		var icon_outer_width_val = src.cfgen_findElementContThroughFbElementCont().cfgen_findElementIconCont().outerWidth();

		e_editor_c.find('input[type="text"].cfgenwp-icon-width-input-value').cfgen_closestElementPropertyCont().find('.ui-slider').slider('option', 'value', icon_outer_width_val);
	}
	
	jQuery.fn.cfgen_sliderInputAllFontSize = function(res){
		
		form_editor.find('.cfgenwp-formelement').css({'font-size':res['value_px']});

		jQuery.cfgen_setCssPropertyValue('input', 'font-size', res['value_px']);
		
		var input_collection = form_editor.find('input[type="text"].cfgen-form-value, select.cfgen-form-value, textarea.cfgen-form-value');
		
		input_collection.each(function(){

			var input = jQuery(this);
			
			var icon_c = input.cfgen_closestElementCont().cfgen_findElementIconCont();
			
			if(icon_c.length){
				icon_c.cfgen_iconContAdjustRecurs();
			}
		});

		form_editor.cfgen_findFbElementConts().cfgen_adjustElementHeightToLeftContent();
	}

	jQuery.fn.cfgen_sliderInputBorderRadius = function(res){
		
		var input_border_radius_px = res['value_px'];
		
		var input_collection = form_editor.find('input[type="text"].cfgen-form-value, select.cfgen-form-value, textarea.cfgen-form-value');
		
		input_collection.each(function(){
			
			var input = jQuery(this);
			
			var icon_c = input.cfgen_closestElementCont().cfgen_findElementIconCont();
			
			if(icon_c.length){				
				if(icon_c.cfgen_iconIsBeforeInput()){
					var input_css = {
									'border-top-right-radius':input_border_radius_px,
									'border-bottom-right-radius':input_border_radius_px,
									'border-top-left-radius':'0px',
									'border-bottom-left-radius':'0px'
									};					
				} else{
					var input_css = {
									'border-top-right-radius':'0px',
									'border-bottom-right-radius':'0px',
									'border-top-left-radius':input_border_radius_px,
									'border-bottom-left-radius':input_border_radius_px
									};					
				}

				input.css(input_css); // It must comes BEFORE updating the icon
				
				icon_c.cfgen_updateIconBorderRadius();
			} else{
				input.css('borderRadius', input_border_radius_px);
			}
		});
		
		jQuery.cfgen_setCssPropertyValue('input', 'border-radius', res['value_px']);
	}

	jQuery.fn.cfgen_sliderInputBorderWidth = function(res){		
		
		var input_collection = form_editor.find('input[type="text"].cfgen-form-value, select.cfgen-form-value, textarea.cfgen-form-value');
		
		input_collection.each(function(){
			
			var input = jQuery(this);
			input.css('borderWidth', res['value_px']); // It must comes BEFORE updating the icon
			
			var icon_c = input.cfgen_closestElementCont().cfgen_findElementIconCont();
			
			if(icon_c.length){	
				icon_c.cfgen_updateIconBorderWidth();
			}
			
		});
		
		jQuery.cfgen_setCssPropertyValue('input', 'border-width', res['value_px']);

		form_editor.cfgen_findFbElementConts().cfgen_adjustElementHeightToLeftContent();
	}

	jQuery.fn.cfgen_setInputContWidth = function(){
		// ^-- When adding a new icon that may be larger than the previous one or when increasing the icon width container

		var src = jQuery(this); // this can be the icon cont slider width or the icon id select

		var e_editor_c = src.cfgen_closestElementEditorCont();

		var e_c = jQuery(this).cfgen_findElementContThroughFbElementCont();

		var element_set_c = e_c.find('div.cfgen-e-set');

		var input_group_c = e_c.find('div.cfgen-input-group');

		var select_icon = e_editor_c.find('select.cfgenwp-icon-select');
		
		var input_width_val = parseInt(e_editor_c.find('input[type="text"].cfgenwp-element-width-input-value').val());

		if(select_icon.val()){

			var icon_width_val = parseInt(e_editor_c.find('input[type="text"].cfgenwp-icon-width-input-value').val());
			
			var icon_width_plus_input_width = icon_width_val + input_width_val;
			
			element_set_c.css({'width':jQuery.cfgen_appendPx(icon_width_plus_input_width)});

			input_group_c.css({'max-width':jQuery.cfgen_appendPx(icon_width_plus_input_width)});

		} else{

			var input_width_px = jQuery.cfgen_appendPx(input_width_val);

			element_set_c.css({'width':input_width_px});

			input_group_c.css({'max-width':input_width_px});
		}
		
		return jQuery(this);
	}
	
	jQuery.fn.cfgen_sliderInputHeight = function(target_id, value){

		var height_px = jQuery.cfgen_appendPx(value);

		// Using an html id because the slider may control a textarea or a submit button
		jQuery(target_id).css({'height':height_px});

		var element_type = jQuery(this).data('cfgenwp_slider_target');

		jQuery.cfgen_setCssPropertyValue(element_type, 'height', height_px);
	}

	jQuery.fn.cfgen_sliderInputPadding = function(res){
		
		var input_collection = form_editor.find('input[type="text"].cfgen-form-value, select.cfgen-form-value, textarea.cfgen-form-value');

		input_collection.each(function(){
			
			var input = jQuery(this);
			
			input.css('padding', res['value_px']); // It must comes BEFORE updating the icon
			
			var icon_c = input.cfgen_closestElementCont().cfgen_findElementIconCont();
		
			if(icon_c.length){
				icon_c.cfgen_iconContAdjustRecurs();
			}			
			
		});

		jQuery.cfgen_setCssPropertyValue('input', 'padding', res['value_px']);

		form_editor.cfgen_findFbElementConts().cfgen_adjustElementHeightToLeftContent();
	}
	
	jQuery.fn.cfgen_sliderInputWidth = function(value){

		var width_px = jQuery.cfgen_appendPx(value);
		
		var e_c = jQuery(this).cfgen_findElementContThroughFbElementCont();

		e_c.find('div.cfgen-e-set').css({'width':width_px});		
		e_c.find('div.cfgen-input-group').css({'max-width':width_px});

		var element_type = jQuery(this).data('cfgenwp_slider_target');

		jQuery.cfgen_setCssPropertyValue(element_type, 'width', width_px, 'element-set-c');

		jQuery.cfgen_setCssPropertyValue(element_type, 'max-width', width_px, 'input-group-c');
		
	}

	jQuery.fn.cfgen_sliderLabelAllFontSize = function(res){
		
		form_editor.find('label.cfgen-label').css({'font-size':res['value_px']});

		jQuery.cfgen_setCssPropertyValue('label', 'font-size', res['value_px']);
		
		form_editor.cfgen_findFbElementConts().cfgen_adjustElementHeightToLeftContent();
	}

	jQuery.fn.cfgen_sliderLabelMarginBottom = function(res){
		
		form_editor.find('label.cfgen-label').each(function(){
			jQuery(this).css('margin-bottom', res['value_px']);
		});
		
		jQuery.cfgen_setCssPropertyValue('label', 'margin-bottom', res['value_px']);

		form_editor.cfgen_findFbElementConts().cfgen_adjustElementHeightToLeftContent();
	}

	jQuery.fn.cfgen_sliderLabelWidth = function(value){

		var width_px = jQuery.cfgen_appendPx(value);
		
		jQuery(this).cfgen_findElementContThroughFbElementCont().find('label.cfgen-label').css({'width':width_px});
	}
	
	jQuery.fn.cfgen_sliderOptionMarginTop = function(res){
		
		var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
		
		var e_c = fb_e_c.cfgen_findElementCont();

		e_c.find('div.cfgen-e-set').css({'padding-top':res['value_px']}); /* padding and not margin because of table-cell display */

		jQuery.cfgen_setCssPropertyValue('option', 'padding-top', res['value_px']);
		
		fb_e_c.cfgen_adjustElementHeightToLeftContent();
	}

	jQuery.fn.cfgen_sliderRatingFontSize = function(res){
		jQuery(this).cfgen_findElementContThroughFbElementCont().find('.fa').css({'font-size':res['value_px']});
	}

	jQuery.fn.cfgen_sliderRatingPaddingRight = function(res){
		jQuery(this).cfgen_closestFbElementCont().find('div.cfgen-rating-c .fa:not(:last-child)').css({'padding-right':res['value_px']});
	}

	jQuery.fn.cfgen_sliderFormMessageFontSize = function(res){
		jQuery(this).closest('div.cfgenwp-formconfig-r').find('.cfgenwp-formmessage-preview').css({'font-size':res['value_px']});
	}

	jQuery.fn.cfgen_sliderParagraphAllFontSize = function(res){
		
		form_editor.find('div.cfgen-paragraph').css({'font-size':res['value_px']});
		
		jQuery.cfgen_setCssPropertyValue('paragraph', 'font-size', res['value_px']);

		form_editor.cfgen_findFbElementConts().cfgen_adjustElementHeightToLeftContent();
	}
	
	jQuery.fn.cfgen_sliderParagraphFontSize = function(res){
		
		var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
		
		var e_c = fb_e_c.cfgen_findElementCont();
		
		e_c.find('div.cfgen-paragraph').css({'font-size':res['value_px']});
		
		jQuery.cfgen_setCssPropertyValue('paragraph', 'font-size', res['value_px']);

		fb_e_c.cfgen_adjustElementHeightToLeftContent();
	}
	
	jQuery.fn.cfgen_sliderParagraphWidth = function(value){

		var width_px = jQuery.cfgen_appendPx(value);
		
		var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
		
		var e_c = fb_e_c.cfgen_findElementCont();

		e_c.find('div.cfgen-paragraph').css({'width':width_px});		

		jQuery.cfgen_setCssPropertyValue('paragraph', 'width', width_px);
		
		fb_e_c.cfgen_adjustElementHeightToLeftContent();
	}
	
	jQuery.fn.cfgen_sliderSeparatorHeight = function(res){
		
		var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
		
		var e_c = fb_e_c.cfgen_findElementCont();
		
		e_c.find('div.cfgen-separator').css({'height':res['value_px']});
		
		jQuery.cfgen_setCssPropertyValue('separator', 'height', res['value_px']);

		fb_e_c.cfgen_adjustElementHeightToLeftContent();
	}

	jQuery.fn.cfgen_sliderSubmitBorderRadius = function(res){

		jQuery(this).cfgen_findElementContThroughFbElementCont().find('input[type="submit"]').css({'border-radius':res['value_px']});
		
		jQuery.cfgen_setCssPropertyValue('submit', 'border-radius', res['value_px']);
	}

	jQuery.fn.cfgen_sliderSubmitFontSize = function(res){

		jQuery(this).cfgen_findElementContThroughFbElementCont().find('input[type="submit"]').css({'font-size':res['value_px']});
		
		jQuery.cfgen_setCssPropertyValue('submit', 'font-size', res['value_px']);
	}

	jQuery.fn.cfgen_sliderSubmitMarginLeft = function(res){
		
		jQuery(this).cfgen_findElementContThroughFbElementCont().find('input[type="submit"]').css({'margin-left':res['value_px']});
		
		jQuery.cfgen_setCssPropertyValue('submit', 'margin-left', res['value_px']);
	}
	
	jQuery.fn.cfgen_sliderTermsFontSize = function(res){
		
		var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
		
		var e_c = fb_e_c.cfgen_findElementCont();
		
		e_c.find('div.cfgen-terms label').css({'font-size':res['value_px']});
		
		jQuery.cfgen_setCssPropertyValue('terms', 'font-size', res['value_px']);
		
		fb_e_c.cfgen_adjustElementHeightToLeftContent();
	}
	
	jQuery.fn.cfgen_sliderTitleAllFontSize = function(res){
		
		form_editor.find('div.cfgen-title').css({'font-size':res['value_px']});
		
		jQuery.cfgen_setCssPropertyValue('title', 'font-size', res['value_px']);
		
		form_editor.cfgen_findFbElementConts().cfgen_adjustElementHeightToLeftContent();
	}
	
	jQuery.fn.cfgen_sliderTitleFontSize = function(res){
		
		var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
		
		var e_c = fb_e_c.cfgen_findElementCont();
		
		e_c.find('div.cfgen-title').css({'font-size':res['value_px']});
		
		jQuery.cfgen_setCssPropertyValue('title', 'font-size', res['value_px']);
		
		fb_e_c.cfgen_adjustElementHeightToLeftContent();
	}

	jQuery.fn.cfgen_findProperLabel = function(){
		var anchor = jQuery(this);
		
		var label_val = anchor.find('input[type="text"].cfgenwp-edit-label-value').val();

		if(!label_val){
			var label_val = anchor.find('input[type="text"].cfgenwp-edit-placeholder-value').val();
		}
		
		if(anchor.find('span.cfgen-required').length){
			label_val = label_val + '*';
		}
		
		return label_val;
	}

	jQuery.fn.cfgen_updateCaptcha = function(){

		var captcha_length = jQuery('#cfgenwp-captcha-length').val();

		var captcha_format = form_editor.find('input[type="radio"][name=cfgenwp-captchaformat]:checked').val();

		jQuery(this).prop('src','sourcecontainer/'+dir_form_inc+'/inc/captcha.php?length='+captcha_length+'&format='+captcha_format+'&r=' + Math.random());		
	}

	jQuery.fn.cfgen_adjustElementHeightToLeftContent = function(){
		
		var fb_e_c_collection = jQuery(this);
		
		fb_e_c_collection.each(function(){
			
			var fb_e_c = jQuery(this);
			
			var left_content_innerheight = fb_e_c.cfgen_findElementCont().innerHeight();
			
			if(fb_e_c.innerHeight() < (parseInt(left_content_innerheight) + 20)){
				// ^-- +20 helps adjusting the height comparison: always return the right result on focusout event for paragraphs
				fb_e_c.css({'height':parseInt(left_content_innerheight)});
			} else{
				fb_e_c.css({'height':parseInt(fb_e_c.cfgen_findElementEditorCont().innerHeight())});
			}
		});		
	}

	jQuery.fn.cfgen_adjustElementHeightToRightContent = function(){

		var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
		// fb_e_c.css({'background-color': '#ff0033'});
		
		var container_default_height = parseInt(fb_e_c.cfgen_findElementCont().innerHeight());
		
		var element_editor_height = parseInt(fb_e_c.cfgen_findElementEditorCont().innerHeight());
		
		
		if(element_editor_height>container_default_height){
			//	console.log('right editor > left element');
			var new_element_container_height = element_editor_height;
		} else{
			// 	console.log('left element > right editor');
			var new_element_container_height = container_default_height;
		}
		
		fb_e_c.css({'height':new_element_container_height});
		
		// console.log('container_default_height: '+container_default_height);
		// console.log('element_editor_height:' +element_editor_height);
		// console.log('new_element_container_height = container_default_height+element_editor_height:' +new_element_container_height);
		// console.log('=============================');
	}
	
	jQuery.fn.cfgen_colorkit = function(arg_colorpicker_id){

		jQuery(this).each(function(){

			if(jQuery(this).hasClass('cfgenwp-colorpicker-ico')){
				var colorpicker_input = jQuery(this).closest('div.cfgenwp-colorpicker-c').find('.cfgenwp-colorpicker-value');
			} else{
				var colorpicker_input = jQuery(this);
			}
			
			// same function for colorpicker ico and for input value
			jQuery(this).parent().find('.cfgenwp-colorpicker-ico').add(jQuery(this)).click(function(e){

				// open CP 1 and CP2, stopPropagation make the color selected from CP2 applied to the target
				e.stopPropagation();

				// added in v.5, prevents from having multiple colorpicker panel opened (if 2 colorpickers are opened the color clicked in the second colorpicker is not applied)
				var colorpickercontainer = jQuery(this).closest('div.cfgenwp-colorpicker-c');
				jQuery('.cfgenwp-colorpicker-c').not(colorpickercontainer).each(function(){
					// hide all colorpickers except the one that is currently opened (prevents hide/show bumping when clicking again in the input
					jQuery(this).find('.cfgenwp-colorpicker-wheel').hide();
				});

				// z-index is set to 2 to put the colorpicker of the current element above the cfgenwp-e-editor-c of the element below
				colorpickercontainer.cfgen_closestElementEditorCont().css({'z-index':'2'});
				
				var colorpicker_wheel = colorpicker_input.closest('div.cfgenwp-colorpicker-c').find('.cfgenwp-colorpicker-wheel');
				
				colorpicker_wheel.farbtastic(colorpicker_input);
				
				jQuery(colorpicker_wheel).css({'display':'block'});
				
			}); // click event on input and color wheel
			
			// Triggered on typing in the input
			// When clicking on the color wheel, cfgenwp_updateElementColor is called in farbtastic.js
			colorpicker_input.change(function(){
			
				// if the user erases the content of the input that displays the color code (ctrl+x), 
				// the color wheel will still appear when clicking the icon but the color code won't be added in the input when clicking in the wheel again
				if( !jQuery.trim(colorpicker_input.val()) ){
					colorpicker_input.val(colorpicker_input.data('cfgenwp_colorpicker_last_value')); // set in farbtastic.js
				}
				
				colorpicker_input.cfgen_updateElementColor();

			});
		})
	} // cfgenwp_colorkit


	// COLOR PICKERS
	jQuery('#cfgenwp-formbuilder-container').find('input[type=text].cfgenwp-colorpicker-value').cfgen_colorkit();
	
	jQuery.fn.cfgen_findRequiredChecked = function(){
		return jQuery(this).find('input[type="checkbox"].cfgenwp-validation-required:checked');
	}
	
	jQuery.fn.cfgen_findTermsRequiredChecked = function(){
		return jQuery(this).find('input[type="checkbox"].cfgenwp-validation-terms:checked');
	}
	
	jQuery.fn.cfgen_findElementContThroughFbElementCont = function(){
		return jQuery(this).cfgen_closestFbElementCont().cfgen_findElementCont();
	}

	jQuery.fn.cfgen_findElementCont = function(){
		return jQuery(this).find('div.cfgen-e-c');
	}

	jQuery.fn.cfgen_findElementIconCont = function(){
		return jQuery(this).find('div.cfgen-icon-c');
	}

	jQuery.fn.cfgen_findElementRatingContainer = function(){
		return jQuery(this).find('div.cfgen-rating-c');
	}
	
	jQuery.fn.cfgen_findElementEditorCont = function(){
		return jQuery(this).find('div.cfgenwp-e-editor-c');
	}

	jQuery.fn.cfgen_closestFbElementCont = function(){
		return jQuery(this).closest('div.cfgenwp-fb-element-c');
	}

	jQuery.fn.cfgen_findFbElementConts = function(){
		return jQuery(this).find('div.cfgenwp-fb-element-c');
	}

	jQuery.fn.cfgen_closestElementCont = function(){
		return jQuery(this).closest('div.cfgen-e-c');
	}
	
	jQuery.fn.cfgen_closestElementPropertiesCont = function(){
		return jQuery(this).closest('div.cfgenwp-e-properties-c');
	}

	jQuery.fn.cfgen_closestElementPropertyCont = function(){
		return jQuery(this).closest('div.cfgenwp-e-property-c');
	}
	
	jQuery.fn.cfgen_closestElementEditorCont = function(){
		return jQuery(this).closest('div.cfgenwp-e-editor-c');
	}

	jQuery.fn.cfgen_closestElementEditorPanel = function(){
		return jQuery(this).closest('div.cfgenwp-e-editor-panel');
	}

	jQuery.fn.cfgen_sliderUpdateInputValue = function(value_num){
		var input = jQuery(this).closest('div.cfgenwp-e-property-r').find('input[type="text"].cfgenwp-slider-input-value');
		input.val(value_num);
		return jQuery(this);
	}
	jQuery.fn.cfgen_iconIsBeforeInput = function(){
		return jQuery(this).next('div.cfgen-input-c').length !== 0;
	}

	jQuery.fn.cfgen_updateIconBorderWidth = function(){

		var icon_c = jQuery(this);
		
		var input_width_px = getInputBorderWidthPx();
		
		var icon_css = {};
		
		icon_css['border-top-width'] = input_width_px;
		icon_css['border-bottom-width'] = input_width_px;
		
		// Icon aligned on the left
		if(icon_c.cfgen_iconIsBeforeInput()){
			icon_css['border-left-width'] = input_width_px;
			icon_css['border-right-width'] = '0px';
		} else{
			icon_css['border-left-width'] = '0px';
			icon_css['border-right-width'] = input_width_px;
		}
		
		icon_c.css(icon_css);
	}
	
	jQuery.fn.cfgen_updateIconBorderRadius = function(){
		
		var icon_c = jQuery(this);
		
		var input_border_radius_px = getInputBorderRadiusPx();
		
		var icon_css = {};
		
		// Icon aligned on the left
		
		if(icon_c.cfgen_iconIsBeforeInput()){
			icon_css = {
						'border-top-left-radius':input_border_radius_px,
						'border-bottom-left-radius':input_border_radius_px,
						'border-top-right-radius':'0',
						'border-bottom-right-radius':'0'
						};
			
		} else{
			icon_css = {
						'border-top-left-radius':'0',
						'border-bottom-left-radius':'0',
						'border-top-right-radius':input_border_radius_px,
						'border-bottom-right-radius':input_border_radius_px
						};			
		}
		
		icon_c.css(icon_css);
	}
	
	jQuery.fn.cfgen_getInputHeightPx = function(){
		return jQuery(this).outerHeight()+'px';
	}
	
	function getInputBorderRadiusPx(){
		return jQuery('#cfgenwp-input-borderradius-slider').slider('option','value')+'px';
	}
	
	function getInputBorderWidthPx(){
		return jQuery('#cfgenwp-input-borderwidth-slider').slider('option','value')+'px';
	}

	
	var cfgenwp_flag_load_api = 0;
	
	var cfgenwp_dialog_error = {autoOpen: true, title: 'Error', buttons:{OK: function(){jQuery(this).dialog('close');}}};
	
	var cfgenwp_dialog_button_close = {OK: function(){jQuery(this).dialog('close');}};
	
	var cfgenwp_dialog = {};

	cfgenwp_dialog['clearform'] = {title : 'Clear form',
									text : '<p>Are you sure you want clear this form and delete all its elements? There is no undo.</p>',
									buttons : {'Delete all items': function(){jQuery(this).dialog('close'); form_editor.empty(); }, Cancel: function(){jQuery(this).dialog('close');}}
									};


	cfgenwp_dialog['newform'] = {title : 'New form',
								text : '<p>Please select an option below to create your new form.</p>',
								buttons : {
											'Start from scratch': function(){
																	jQuery(this).dialog('close');
																	form_editor.empty();
																	form_id.val('');
																	jQuery('.cfgenwp-api-user-accounts').empty();
																	jQuery('.cfgenwp-api-buttons-c, .cfgenwp-editor-api-builder').hide();
																	jQuery('.cfgenwp-editor-api-authentication').show();
																	jQuery('.cfgenwp-editor-api-c').removeClass('cfgenwp-editor-api-c-selected cfgenwp-editor-api-c-open');
																	cfgenwp_flag_load_api = 1; cfgenwp_loadform_api_config = {};
																},
										'Start with this template': function(){
																		jQuery(this).dialog('close');
																		form_id.val('');
																		loadformdata_c.hide();
																},
										Cancel: function(){jQuery(this).dialog('close');}}};

	cfgenwp_dialog['form_name_empty'] = {text : '<p>The form name cannot be left blank.</p>',
										 buttons : {OK: function(){jQuery(this).dialog('close'); form_config_form_name.focus();}}};

	cfgenwp_dialog['adminnotification_subject_line_empty'] = {text : '<p>The notification subject line cannot be left blank.</p>',
															  buttons : {OK: function(){jQuery(this).dialog('close'); form_config_admin_notification_subject.focus();}}};

	cfgenwp_dialog['redirecturl_empty'] = {text : '<p>The URL field in the validation message section cannot be left blank.</p>',
										   buttons : {OK: function(){jQuery(this).dialog('close'); form_config_redirecturl.focus();}}};

	cfgenwp_dialog['autoresponder_email_field_missing'] = {text : '<p>You must add at least one email field in the form to activate email notification.</p>',
														   buttons : {OK: function(){jQuery(this).dialog('close');}}};

	cfgenwp_dialog['usernotification_message_empty'] = {text : '<p>The user notification message cannot be left blank.</p>',
														buttons : {OK: function(){jQuery(this).dialog('close');
																				  form_config_user_notification_message.focus();}}};

	cfgenwp_dialog['smtp_empty'] = {text : '<p>The SMTP host field and the SMTP port field cannot be left blank.</p>', buttons : {OK: function(){jQuery(this).dialog('close');}}};

	cfgenwp_dialog['database_credentials_empty'] = {text : '<p>The database host field, the database name field, the login field and the table name field cannot be left blank.</p>', buttons : {OK: function(){jQuery(this).dialog('close');}}};
	
	cfgenwp_dialog['database_field_name_empty'] = {text : '<p>You must indicate a table field name for all the form elements you have selected for insertion in your database.</p>', buttons : {OK: function(){jQuery(this).dialog('close');}}};
	
	cfgenwp_dialog['database_no_element_selected'] = {text : '<p>You must add at least one form element in the database settings in order to insert the form data in your database.</p>', buttons : {OK: function(){jQuery(this).dialog('close');}}};

	cfgenwp_dialog['salesforcepasswordpolicy'] = {title : 'Salesforce password policy',
									text : '<p>Please read this carefully.</p>'
											+'<p>Salesforce passwords are set to expire after a certain period of time by default. That means your list integration won\'t work anymore after this period of time ends.'
											+'<p>If you don\'t set your password to never expire in your Salesforce settings or if you don\'t update your password in the list integration when your password has changed, your Salesforce account will be temporarily disabled as a result of too many failed login attempts.</p>'
											+'<p>You can disable password expiration by taking the steps below:</p>'
											+'<p>Go to Setup > Administration setup > Security controls > Password Policies > Set the "user passwords expire" option to "Never expires"</p>'
											,
									buttons : {OK: function(){jQuery(this).dialog('close');}}
									};

	cfgenwp_dialog['sms_admin_notification_to_phone_number_numbers_only'] = {text : '<p>SMS notification error: the phone number must contain digits only and cannot be left blank.</p>', 
																			 buttons : {OK: function(){jQuery(this).dialog('close');
																									   form_config_sms_admin_notification_to_phone_number.focus();
																									   }}};

	cfgenwp_dialog['sms_admin_notification_message_empty'] = {text : '<p>SMS notification error: the text message cannot be left blank.</p>', 
															  buttons : {OK: function(){jQuery(this).dialog('close'); form_config_sms_admin_notification_to_phone_number.focus();}
																		}
															 };

	cfgenwp_dialog['sms_admin_notification_gateway_empty'] = {text : '<p>SMS notification error: you must select an SMS gateway in order to be able to send the message.</p>', 
															  buttons : {OK: function(){jQuery(this).dialog('close'); form_config_sms_admin_notification_gateway.focus();}}};

	cfgenwp_dialog['sms_admin_notification_clickatell_empty_parameter'] = {text : '<p>Clickatell SMS notification error: the username, the password and the HTTP API id cannot be left blank.</p>', 
																		   buttons : {OK: function(){jQuery(this).dialog('close');}}};

	cfgenwp_dialog['sms_admin_notification_twilio_empty_parameter'] = {text : '<p>Twilio SMS notification error: the Twilio "From" number, the account SID and the auth token cannot be left blank.</p>', 
																	   buttons : {OK: function(){jQuery(this).dialog('close');}}};

	cfgenwp_dialog['sms_admin_notification_from_phone_number_numbers_only'] = {text : '<p>SMS notification error: the "From" phone number must contain digits only and cannot be left blank.</p>', 
																			   buttons : {OK: function(){jQuery(this).dialog('close');}}};

	jQuery.fn.cfgen_isGoogleWebFont = function(){
		return jQuery(this).find('option:selected').hasClass('cfgenwp-googlewebfonts');
	}

	jQuery.fn.cfgen_insertAtCaret = function(myValue){
	
		return this.each(function() {
	
			//IE support
			if(document.selection){
	
				this.focus();
				sel = document.selection.createRange();
				sel.text = myValue;
				this.focus();
	
			} else if (this.selectionStart || this.selectionStart == '0') {
	
				//MOZILLA / NETSCAPE support
				var startPos = this.selectionStart;
				var endPos = this.selectionEnd;
				var scrollTop = this.scrollTop;
				this.value = this.value.substring(0, startPos)+ myValue+ this.value.substring(endPos,this.value.length);
				this.focus();
				this.selectionStart = startPos + myValue.length;
				this.selectionEnd = startPos + myValue.length;
				this.scrollTop = scrollTop;
	
			} else{
	
				this.value += myValue;
				this.focus();
			}
		});
	};
	
	jQuery('#cfgenwp-config-redirecturl-btn').click(function(){
		jQuery(this).parent().find('.cfgenwp-config-validationmessage-type-label').addClass('cfgenwp-option-selected');
		jQuery('#cfgenwp-config-validationmessage-btn').parent().find('.cfgenwp-config-validationmessage-type-label').removeClass('cfgenwp-option-selected');
		form_settings.find('div.cfgenwp-config-validationmessage-c').slideUp('fast');
		form_settings.find('div.cfgenwp-config-redirecturl-c').slideDown('fast');
	});
	
	jQuery('#cfgenwp-config-validationmessage-btn').click(function(){
		jQuery(this).parent().find('.cfgenwp-config-validationmessage-type-label').addClass('cfgenwp-option-selected');
		jQuery('#cfgenwp-config-redirecturl-btn').parent().find('.cfgenwp-config-validationmessage-type-label').removeClass('cfgenwp-option-selected');
		form_settings.find('div.cfgenwp-config-validationmessage-c').slideDown('fast');
		form_settings.find('div.cfgenwp-config-redirecturl-c').slideUp('fast');
	});	

	form_settings.on('change', 'select.cfgenwp-insertfieldvalue', function(){
		//console.log(jQuery(this).val());
		
		// no val for the default option (insert value)
		if(jQuery(this).val()){
		
			var cfgenwp_selectinsertfield_value = jQuery(this).val();
			
			var cfgenwp_target_insertfieldvalue = jQuery(this).closest('div.cfgenwp-formconfig-r').find('.cfgenwp-target-insertfieldvalue');
			
			if(!isNaN(parseFloat(cfgenwp_selectinsertfield_value)) && isFinite(cfgenwp_selectinsertfield_value)){
				var cfgenwp_between_braces = jQuery('option:selected', this).html()+'|'+cfgenwp_selectinsertfield_value;
			} else{
				var cfgenwp_between_braces = cfgenwp_selectinsertfield_value;
			}
			
			var cfgenwp_target_braces = '{'+cfgenwp_between_braces+'}';
			
			cfgenwp_target_insertfieldvalue.cfgen_insertAtCaret(cfgenwp_target_braces);
		}		
	});

	// hide the colorpicker when the user click outside of it (necessary when displaying the colorpicker from the cfgenwp-colorpicker-ico)
	jQuery(document).mouseup(function (e){
		//console.log(e.target);
		var container = jQuery('div.cfgenwp-colorpicker-wheel');
	
		if(container.has(e.target).length === 0){

			container.css({'display':'none'});
			
			// z-index default value must be 1 (check contactformeditor.css)
			// z-index is set to 2 in colorkit to put the colorpicker of the current element above the cfgenwp-e-editor-c of the element below
			container.cfgen_closestElementEditorCont().css({'z-index':'1'});
		}
	});
	
	addFormElement(elements);
	
	// SORTABLE ELEMENTS
	form_editor.sortable({
		handle: '.cfgenwp-e-editor-btn-move',
		placeholder: 'ui-state-highlight', 
		forcePlaceholderSize: true,
		start: function(e, ui){

			// current element being sorted: ui.item
			
			//jQuery('.ui-state-highlight').css({'height':ui.item[0]['offsetHeight']});
			
		},
		stop: function(event, ui){
			
			if(ui.item.hasClass('cfgenwp-addelement')){

				addFormElement([{'type':ui.item.data('cfgenwp_type')}], ui.item.index());

				ui.item.remove();

			}

		}

	});
	
 	// MOVING ELEMENT
	form_editor.on('mousedown mouseup','div.cfgenwp-e-editor-btn-move', function(e){
		
		switch(e.type){
			case 'mousedown':
				jQuery(this).closest('div.cfgenwp-fb-e-move-c').addClass('cfgenwp-elementisselected'); break;
			case 'mouseup':
				jQuery(this).closest('div.cfgenwp-fb-e-move-c').removeClass('cfgenwp-elementisselected'); break;
		}
		
	});
	
	
	// ELEMENT ROLLOVER
	form_editor.on('mouseenter mouseleave', 'div.cfgenwp-fb-element-c', function(e){
	
		var c = jQuery(this);
		
		switch(e.type){
			case 'mouseenter':
				c.cfgen_findElementEditorCont().show();
				c.addClass('cfgenwp-elementisselected');
				break;
			case 'mouseleave':
				if(!c.find('div.cfgenwp-e-editor-panel').is(':visible')){
					c.cfgen_findElementEditorCont().hide();
					c.removeClass('cfgenwp-elementisselected');
				}
				break;
		}
	});
	

	// ADD ELEMENTS IN THE EDITOR
	function addFormElement(elements, element_position){

		element_position = typeof element_position !== 'undefined' ? element_position : false;
		
		if(cfgenwp_init_index_element<elements.length){

			var element_properties = {};
			
			for(var property in elements[cfgenwp_init_index_element]){  
				element_properties[property] = elements[cfgenwp_init_index_element][property];
			}


			if(element_properties['type'] === 'submit' && form_editor.find('input[type="submit"].cfgen-submit').length){
				cfgenwp_dialog_box.html('<p>There can be only one submit button in the form.</p>').dialog(cfgenwp_dialog_error);	
				return false;
			}
			
			if(element_properties['type'] === 'captcha' && form_editor.find('img.cfgen-captcha-img').length){
				cfgenwp_dialog_box.html('<p>There can be only one captcha field in the form.</p>').dialog(cfgenwp_dialog_error);
				return false;
			}
			
			element_properties['unique_hash_form_editor'] = cfgenwp_unique_hash_form_editor;
			element_properties['css'] = cfgenwp_css_properties;
			//console.log(element_properties);
			element_properties = JSON.stringify(element_properties);
			var cfgenw_addelement_loading_html = '<div class="cfgenwp-editor-loading"><img src="img/loading.gif"></div>';
			
			var submit_element = form_editor.find('input[type="submit"].cfgen-submit');
			

			// POSITIONNING THE LOADING ICON
			if(element_position === false){
				
				if(submit_element.length){
					submit_element.closest('div.cfgenwp-fb-e-move-c').before(cfgenw_addelement_loading_html);
				} else{
					form_editor.append(cfgenw_addelement_loading_html);
				}
				
			} else{
				
				if(element_position === 0){
					form_editor.prepend(cfgenw_addelement_loading_html);
				} else{
					jQuery('.cfgenwp-fb-e-move-c:eq('+(element_position-1)+')').after(cfgenw_addelement_loading_html);
				}

			}
			
			jQuery.post('inc/setupcontactform.php',
					{element:element_properties},
					function(data){
					
						//console.log(data);
						
						form_editor.find('div.cfgenwp-editor-loading').remove();
						
						var cfgenwp_new_element = jQuery(data);
						
						var cfgenwp_new_element_id = cfgenwp_new_element.find('.cfgenwp-fb-element-c').prop('id');
						
						// 2 elements can't have the same id
						if(jQuery('#'+cfgenwp_new_element_id).length){
							
							addFormElement(elements, element_position);
						}
						
						else{
							
							cfgenwp_init_index_element++;
							
							var submit_element = form_editor.find('input[type="submit"].cfgen-submit');
							
							if(element_position === false){

								if(submit_element.length){
									submit_element.closest('div.cfgenwp-fb-e-move-c').before(data);
								} else{
									form_editor.append(data);
								}

							} else{
								
								if(element_position === 0){
									form_editor.prepend(data);
								} else{
									jQuery('.cfgenwp-fb-e-move-c:eq('+(element_position-1)+')').after(data);
								}

							}
							
							addFormElement(elements, element_position);
						}
					});
			
		}
		
		if(cfgenwp_init_index_element == elements.length){
			cfgenwp_init_index_element = 0;
		}


		jQuery('div.cfgenwp-options-editor-c').sortable({
				placeholder: 'ui-state-highlight',
				handle: '.cfgenwp-sortoption-handle',
				update: function(e, ui)
					{
						var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
						
						var e_c = fb_e_c.cfgen_findElementCont();
						
						if(e_c.find('select').length){
							// clean previously checked elements
							e_c.find('select option').each(function(){jQuery(this).prop('selected', false)});

							fb_e_c.find('.cfgenwp-editoption-c input').each(function(){
										
										var inputindex = jQuery(this).parent().index();
										
										var newoptionvalue = jQuery(this).val();
										
										var optioncontent = fb_e_c.cfgen_findElementCont().find('select option:eq('+inputindex+')');
										
										optioncontent.val(newoptionvalue);
										
										optioncontent.html(newoptionvalue);
										
										// new check status
										if(jQuery(this).closest('div.cfgenwp-editoption-c').find('.selected').length){
											optioncontent.prop('selected', true);
										}
									});
						}
						
						if(e_c.find('input[type=radio]').length || e_c.find('input[type=checkbox]').length){
							// clean previously checked elements
							fb_e_c.find('.cfgen-option-content input').each(function(){jQuery(this).prop('checked', false)});
							
							fb_e_c.find('.cfgenwp-editoption-c input').each(function(){

										var containerindex = jQuery(this).parent().index();

										var newoptionvalue = jQuery(this).val();
										
										var optioncontent = fb_e_c.find('.cfgen-option-content:eq('+containerindex+')');

										optioncontent.find('input').val(newoptionvalue);
										
										optioncontent.find('label').text(newoptionvalue);
										
										// new check status
										if(jQuery(this).closest('div.cfgenwp-editoption-c').find('.selected').length){
											optioncontent.find('input').prop('checked', true);
										}
									});							
						}
					} // end update method
		}); // end sortable
		
		if(!jQuery('#cfgenwp-fb-editor-c:visible').length){
			jQuery.cfgen_returnToFormEdition();	
		}
		
	}
	
	jQuery('#cfgenwp-formbuilder-menu-elements').find('div.cfgenwp-addelement').click(function(){
		addFormElement([{'type':jQuery(this).data('cfgenwp_type')}]);
	});
	
	
	jQuery('#cfgenwp-genericstyle-close').click(function(){
		jQuery('#cfgenwp-genericstyle-container').css({'display':'none'});
	});
	
	toolbar_c.find('div.cfgenwp-toolbaraction').click(function(){

		switch(jQuery(this).prop('id')){
		
			case 'cfgenwp-style-all':
				
				jQuery('#cfgenwp-genericstyle-input-c').css({'display':'none'});
				
				if(jQuery('#cfgenwp-genericstyle-text-c').is(':visible')){
					jQuery('#cfgenwp-genericstyle-text-c, #cfgenwp-genericstyle-container, #cfgenwp-genericstyle-close').css({'display':'none'});
				} else{
					jQuery('#cfgenwp-genericstyle-text-c, #cfgenwp-genericstyle-container, #cfgenwp-genericstyle-close').css({'display':'block'});
				}
				
				break;
				
			case 'cfgenwp-textinputformat':
				
				jQuery('#cfgenwp-genericstyle-text-c').css({'display':'none'});
				
				if(jQuery('#cfgenwp-genericstyle-input-c').is(':visible')){
					jQuery('#cfgenwp-genericstyle-input-c, #cfgenwp-genericstyle-container, #cfgenwp-genericstyle-close').css({'display':'none'});
				} else{
					jQuery('#cfgenwp-genericstyle-input-c, #cfgenwp-genericstyle-container, #cfgenwp-genericstyle-close').css({'display':'block'});
				}
				
				break;
		}

	});
	
	// EXPAND ALL
	jQuery('#cfgenwp-expandall').click(function(){
	
		jQuery(this).hide();
		
		jQuery('#cfgenwp-collapseall').css({'display':'inline-block'});
		
		form_editor.cfgen_findFbElementConts().each(function(){
			
			var e = jQuery(this);
			
			e.addClass('cfgenwp-elementisselected');
			
			var btn_hook = e.find('.cfgenwp-e-editor-btn').first();
			
			configureElementContainerHeight(btn_hook, 'expandall');
		});
	});
	
	// COLLAPSE ALL
	jQuery('#cfgenwp-collapseall').click(function(){
	
		jQuery(this).hide();
		
		jQuery('#cfgenwp-expandall').css({'display':'inline-block'});
		
		form_editor.cfgen_findFbElementConts().each(function(){
	
			var e = jQuery(this);
			
			e.removeClass('cfgenwp-elementisselected');
			
			var btn_hook = e.find('.cfgenwp-e-editor-btn').first();

			configureElementContainerHeight(btn_hook, 'collapseall');
		});		
	});
	
	// CLEAR FORM
	jQuery('#cfgenwp-clearform').click(function(){
	
		var html = cfgenwp_dialog['clearform']['text'];
		
		if(form_id.val()){
			html += '<p>Notice: you are currently working on form #'+form_id.val()+'. ';
			html += 'If you want to create a new form with a new #id, click on the "New form" button in the top right corner instead.</p>';
		};
		
		cfgenwp_dialog_box.html(html).dialog({autoOpen: true, title: cfgenwp_dialog['clearform']['title'], buttons: cfgenwp_dialog['clearform']['buttons']});
		
	});
	
	// NEW FORM
	jQuery('#cfgenwp-newform').click(function(){
		cfgenwp_dialog_box.html(cfgenwp_dialog['newform']['text']).dialog({autoOpen: true, title: cfgenwp_dialog['newform']['title'], buttons: cfgenwp_dialog['newform']['buttons']});
	});
	
	// SALESFORCE PASSWORD
	jQuery('body').on('click', '#cfgenwp-salesforce-notice-password', function(){
		cfgenwp_dialog_box.html(cfgenwp_dialog['salesforcepasswordpolicy']['text']).dialog({autoOpen: true, title: cfgenwp_dialog['salesforcepasswordpolicy']['title'], buttons: cfgenwp_dialog['salesforcepasswordpolicy']['buttons']});		
	});

	function configureElementContainerHeight(hook_target, mode){
		
		var btn = jQuery(hook_target);
		var fb_e_c = jQuery(hook_target).cfgen_closestFbElementCont();
		var element_container_id = fb_e_c.data('cfgenwp_element_id');
		var e_editor_c = jQuery(hook_target).cfgen_closestElementEditorCont(); // only for toggling the btn class
		var e_c = fb_e_c.cfgen_findElementCont();
		
		if(!cfgenwp_element_container_default_height[element_container_id]){
			cfgenwp_element_container_default_height[element_container_id] = e_c.innerHeight();
		}
		
		if(btn.hasClass('cfgenwp-e-editor-btn')){
			var e_editor_panel = 'div.'+btn.data('cfgenwp_editor_panel');
			fb_e_c.find('div.cfgenwp-e-editor-panel').not(e_editor_panel).hide();
		}

		e_editor_panel = fb_e_c.find(e_editor_panel);
		
		var element_editor_height = parseInt(e_editor_panel.innerHeight());
		
		if(parseInt(e_c.innerHeight()) >= cfgenwp_element_container_default_height[fb_e_c.data('cfgenwp_element_id')]){
			//console.log('new content overlap');
			cfgenwp_element_container_default_height[element_container_id] = parseInt(e_c.innerHeight());
		}
		
		if(parseInt(e_c.innerHeight()) < element_editor_height){
			//console.log('new content no overlap');
			cfgenwp_element_container_default_height[element_container_id] = fb_e_c.innerHeight();
		}		
		
		var slide_speed = 40;
		
		if(mode == 'toggle'){
			
			if(e_editor_panel.is(':visible')){
				e_editor_panel.hide(slide_speed, function(){
													// adjusted to cfgen-e-c innerHeight for the case when the height of the left content increases dynamically (paragraph value, textarea rows, adding options, paragraph value+element, etc)
													// /!\ /!\ the same adjustment must also be applied when .cfgenwp-e-editor-close-t is clicked and for mode = collapseall
													fb_e_c.css({'height':parseInt(fb_e_c.cfgen_findElementCont().innerHeight())});
													btn.removeClass('cfgenwp-e-editor-btn-active');
													});
			} else{
				e_editor_panel.show(slide_speed, function(){
														e_editor_panel.cfgen_adjustElementHeightToRightContent();
														
														// /!\ /!\ the same adjustment must also be applied for mode = expandall
														e_editor_c.find('.cfgenwp-e-editor-btn').removeClass('cfgenwp-e-editor-btn-active');
														btn.addClass('cfgenwp-e-editor-btn-active');
														});
				
			}
		}
		
		if(mode == 'expandall'){

			e_editor_panel.slideDown(slide_speed, function(){
															btn.cfgen_closestElementEditorCont().show(); // only for expand all
															e_editor_panel.cfgen_adjustElementHeightToRightContent();
															e_editor_c.find('.cfgenwp-e-editor-btn').removeClass('cfgenwp-e-editor-btn-active');
															btn.addClass('cfgenwp-e-editor-btn-active');
															});
		}
		
		if(mode == 'collapseall'){
			
			e_editor_panel.slideUp(slide_speed, function(){
															btn.cfgen_closestElementEditorCont().hide(); // only for collapse all
															fb_e_c.css({'height':parseInt(fb_e_c.cfgen_findElementCont().innerHeight())});
															btn.removeClass('cfgenwp-e-editor-btn-active');
														});
		}
	}
	
	
	form_editor.on('click', 'div.cfgenwp-e-editor-btn', function(){
		
		configureElementContainerHeight(jQuery(this), 'toggle');
	});
	
	form_editor.on('click', 'span.cfgenwp-e-editor-close-t', function(){
		var close_btn = jQuery(this);

		var fb_e_c = close_btn.cfgen_closestFbElementCont();
		
		close_btn.css('cursor','default'); // prevent from having the hand cursor after the element slided up
		
		fb_e_c.removeClass('cfgenwp-elementisselected');
	
		fb_e_c.cfgen_findElementEditorCont().slideUp(100,
															function(){
																fb_e_c.find('div.cfgenwp-e-editor-panel').hide();
																close_btn.css('cursor','pointer'); // the element slidedup, the close button can gets its hand style

																// height adjustment (same adjustmen in .on('click', 'div.cfgenwp-e-editor-btn',
																fb_e_c.css({'height':parseInt(fb_e_c.cfgen_findElementCont().innerHeight())});
															});
	});
	
	// Edit placeholder
	form_editor.on('keyup focusout', 'input[type="text"].cfgenwp-edit-placeholder-value', function(){

		var edit_placeholder = jQuery(this);

		var edit_placeholder_val = jQuery.trim(edit_placeholder.val());
		
		edit_placeholder.cfgen_findElementContThroughFbElementCont().find('.cfgenwp-formelement').prop('placeholder', edit_placeholder_val);

		edit_placeholder.cfgen_closestElementEditorCont().find('input[type="text"].cfgenwp-edit-label-value').trigger('focusout'); // Also applied when clicking on the "required field" checkbox
	});
	
	// Edit label
	form_editor.on('keyup focusout', 'input[type="text"].cfgenwp-edit-label-value', function(){
		var edit_label = jQuery(this);
		
		var edit_label_val = jQuery.trim(edit_label.val());
		
		var e_fb_container = edit_label.cfgen_closestFbElementCont();
		
		var e_type = e_fb_container.data('cfgenwp_element_type');
		
		var e_c = e_fb_container.cfgen_findElementCont();
		
		e_c.find('span.cfgen-label-value').text(edit_label_val);
		
		if(!edit_label_val){
			e_c.find('label.cfgen-label').css({'display':'none'});
		} else{
			if(e_type != 'hidden'){
				e_c.find('label.cfgen-label').show();	
			}			
		}		
		
	});
	
	// Edit title
	form_editor.on('keyup focusout', 'input[type="text"].cfgenwp-edit-title-value', function(){
		
		var edit_input = jQuery(this);
		
		edit_input.cfgen_findElementContThroughFbElementCont().find('div.cfgen-title').text(edit_input.val());
	});
	
	// Edit submit
	form_editor.on('keyup focusout', 'input[type="text"].cfgenwp-edit-submit-value', function(){

		var edit_input = jQuery(this);

		edit_input.cfgen_findElementContThroughFbElementCont().find('input[type="submit"]').val(edit_input.val());
	});
	
	
	// EDIT INPUT HIDDEN
	form_editor.on('keyup focusout', 'input[type="text"].cfgenwp-hidden-input-value', function(){
		jQuery(this).cfgen_findElementContThroughFbElementCont().find('input').val(jQuery(this).val());
	});
	
	
	// EDIT PARAGRAPH
	form_editor.on('keyup focusout', 'textarea.cfgenwp-paragraph-edit', function(){
		
		var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
		
		var paragraph = fb_e_c.find('div.cfgen-paragraph');
		
		var text = jQuery(this).val().replace(/\r?\n|\r/g, '<br>');
		
		paragraph.html(text);
		
		if(paragraph.html()){
			paragraph.css({'display':'block'});
		} else{
			paragraph.css({'display':'none'});
		}
		
		fb_e_c.cfgen_adjustElementHeightToLeftContent();
	});
	
	// EDIT TERMS AND CONDITIONS
	form_editor.on('keyup focusout', 'textarea.cfgenwp-edit-terms-value, input[type="text"].cfgenwp-edit-terms-link', function(){
		
		var input_edit = jQuery(this); // may be terms value or terms link
		
		var e_properties_cont = input_edit.cfgen_closestElementPropertiesCont();
		
		var terms_label_val = e_properties_cont.find('textarea.cfgenwp-edit-terms-value').val();
		
		var terms_link_val = jQuery.trim(e_properties_cont.find('input[type="text"].cfgenwp-edit-terms-link').val());
		
		var fb_e_c = input_edit.cfgen_closestFbElementCont();
		
		var terms_label = input_edit.cfgen_closestFbElementCont().find('div.cfgen-terms label');
		
		if(terms_link_val){
			var new_terms_label = terms_label_val.replace(/{(.*)}/g, '<a href="'+terms_link_val+'" target="_blank">$1</a>');
		} else{
			var new_terms_label = terms_label_val.replace(/{(.*)}/g, '$1');
		}
		

		terms_label.html(new_terms_label);
		
		fb_e_c.cfgen_adjustElementHeightToLeftContent();
	});
	
	
	
	// EDIT IMAGE FROM URL
	form_editor.on('click', 'input.cfgenwp-addimagefromurl', function(){
		
		var e_property_c = jQuery(this).cfgen_closestElementPropertyCont();
		var e_editor_panel = jQuery(this).cfgen_closestElementEditorPanel();
		
		// get url value
		var image_url = jQuery.trim(e_property_c.find('input[type="text"].cfgenwp-image-edit-url').val());
		
		if(image_url){
			
			var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
			
			// add image in the form
			fb_e_c.find('.addimagecontainer').remove();
			fb_e_c.find('.cfgen-input-group').empty().append('<img src="'+image_url+'" />');
			e_property_c.find('.cfgenwp-delimagefromurl').remove();
			
			// add delete button
			jQuery(this).after('<span class="cfgenwp-delimagefromurl">Delete</span>');
			
			// adjust element height after the image is loaded
			fb_e_c.find('div.cfgen-input-group img').load(function(){
				fb_e_c.cfgen_adjustElementHeightToLeftContent();
			});
			
			// imagefromurl after imagefromupload
			if(e_editor_panel.find('.uploadimagefilename').val()){
				
				var filename = e_editor_panel.find('.uploadimagefilename').val();
				var delimgbutton = jQuery(this);

				jQuery.post('inc/editimage-delete.php', 
						{filename:Array(filename)},
						function(data){
							delimgbutton.cfgen_closestElementEditorPanel().find('.uploadsuccess-container').hide();
						}
				);
				
			}
		}
		
	});
	
	
	// DELETE IMAGE FROM URL
	form_editor.on('click', 'span.cfgenwp-delimagefromurl', function(){
		var e_property_c = jQuery(this).cfgen_closestElementPropertyCont();
		e_property_c.find('input[type="text"].cfgenwp-image-edit-url').val('');
		
		jQuery(this).cfgen_resetImageContainer();
		// ^-- it must be called BEFORE being removed or the reset won't work since the hook is not in the DOM
		// the height adjustment of the element container is done inside resetImageContainer
		e_property_c.find('.cfgenwp-delimagefromurl').remove();
	});
	
	
	// DELETE IMAGE FROM UPLOAD
	form_editor.on('click', 'span.cfgenwp-delimagefromupload', function(){
		var uploadimagesuccesscontainer = jQuery(this).closest('.uploadsuccess-container');
		var filename = uploadimagesuccesscontainer.find('.uploadimagefilename').val();
		var delimgbutton = jQuery(this);
		delimgbutton.hide();
		uploadimagesuccesscontainer.find('.uploadimageloading').show();
		
		jQuery.post('inc/editimage-delete.php', 
			 	{filename:Array(filename)},
				function(data){
					uploadimagesuccesscontainer.find('.uploadimageloading').hide();
					uploadimagesuccesscontainer.hide();
					uploadimagesuccesscontainer.find('.uploadimagehtmlfilename').empty(); // shows file name
					uploadimagesuccesscontainer.find('.uploadimagefilename').val(''); // contains the name of the file
					delimgbutton.show();
				}
		);
		
		jQuery(this).cfgen_resetImageContainer();
	});

	
	// EDIT LABEL ALIGNMENT
	form_editor.on('click', 'input[type="radio"].cfgenwp-label-alignment', function(){
		
		var btn_position = jQuery(this);
		var btn_position_val = btn_position.val();
		
		// display: block; already set in form.css for cfgen-label
		var fb_e_c = btn_position.cfgen_closestFbElementCont();
		var e_editor_c = btn_position.cfgen_closestElementEditorCont();
		
		var label = fb_e_c.find('label.cfgen-label');
		var element_set_c = fb_e_c.find('div.cfgen-e-set');
		
		// Not e_editor_c.find() directly because the slider input is not in the same editor where the radio button is clicked, we must go through the element container
		var label_width_c = fb_e_c.find('input[type="text"].cfgenwp-input-label-width-value').closest('div.cfgenwp-e-properties-c');
		
		var option_margintop_input = e_editor_c.find('select.cfgenwp-option-margintop-select');
		var option_margintop_c = option_margintop_input.closest('div.cfgenwp-e-properties-c');
		
		if(btn_position_val == 'top'){
			
			label_width_c.slideUp(50, function(){
												option_margintop_c.slideUp(50, function(){
													fb_e_c.cfgen_adjustElementHeightToRightContent();
												});
											  });
			// reset label
			label.css({'display':'block', 'text-align':'left', 'width':''});
			element_set_c.css({'display':'block'}); 
			
			// reset element set
			jQuery.cfgen_setCssPropertyValue('label', 'width', ''); // the property width will be deleted
			
			// reset option margin-top
			var option_margintop_val = jQuery.cfgen_getCssPropertyValue('option', 'padding-top');
			option_margintop_input.val(parseFloat(option_margintop_val));
			option_margintop_c.find('.ui-slider').slider('option', 'value', parseFloat(option_margintop_val));
		}
		
		if(btn_position_val == 'left'){
			label.css({'text-align':'left'});
		}
		
		if(btn_position_val == 'right'){
			label.css({'text-align':'right'});
		}
		
		if(btn_position_val  == 'left' || btn_position_val == 'right'){
			
			if(!label_width_c.is(':visible')){

				label.css({'display':'table-cell', 'vertical-align':'top', 'width': e_editor_c.find('input[type="text"].cfgenwp-input-label-width-value').val()+'px'});
				
				element_set_c.css({'display':'table-cell', 'vertical-align':'top'}); 

				label_width_c.slideDown(50, function(){
														// for radio and checkbox elements (the containerHeight must be set after the margin top edit box appears
														if(option_margintop_c.length){
															option_margintop_c.slideDown(50, function(){
																jQuery(this).cfgen_adjustElementHeightToRightContent();
															});
														} 
														// for the other input elements having labels
														else{
															jQuery(this).cfgen_adjustElementHeightToRightContent();
														}
													});
			}
		}
	});
	

	// EDIT OPTION PLACEMENT AND ALIGNMENT
	form_editor.on('click', 'input[type="radio"].cfgenwp-option-alignment', function(){
		var btn_position = jQuery(this);
		var btn_position_val = btn_position.val();
		
		// display: block; already set in form.css for cfgen-label
		var fb_e_c = btn_position.cfgen_closestFbElementCont();
		var option_width_c = btn_position.cfgen_closestElementEditorCont().find('input[type="text"].cfgenwp-input-option-width-value').closest('div.cfgenwp-e-properties-c');

		if(btn_position_val == 'top'){
			
			// 'width':'' remove the width property if clicked after left or right alignment
			fb_e_c.find('.cfgen-option-content').css({'float':'none', 'text-align':'left', 'width':''});
			
			option_width_c.slideUp(100,
										function(){
											jQuery(this).cfgen_adjustElementHeightToRightContent();
										});
		}
		
		if(btn_position_val == 'left'){
			
			if(!option_width_c.is(':visible')){
				
				var css = {'width':fb_e_c.find('.cfgenwp-input-option-width-value').val()};
				
				fb_e_c.find('.cfgen-option-content').css(buildAlignOptionLeftCss(css));
				
				option_width_c.slideDown(100,
											function(){
												jQuery(this).cfgen_adjustElementHeightToRightContent();
											});
			}
		}
	});
	
	function buildAlignOptionLeftCss(css){
		return ({'float':'left', 'width':css['width']+'px'});
	}
	

	// EDIT TIME - ADD REMOVE AM PM
	form_editor.on('click', 'input[type="radio"].cfgenwp-timeformat', function(){
		
		var timeformat_btn = jQuery(this);
		
		var edec = timeformat_btn.cfgen_closestFbElementCont();
		
		if(timeformat_btn.hasClass('12hourclock')){ 
			edec.find('select.cfgen-time-ampm').show();
			edec.find('select.cfgen-time-hour').empty().append(buildSelectHourOptions(12));
		}
		
		if(timeformat_btn.hasClass('24hourclock')){
			edec.find('select.cfgen-time-ampm').hide();
			edec.find('select.cfgen-time-hour').empty().append(buildSelectHourOptions(24));
		}
	});
	
	
	function buildSelectHourOptions(timeformat){
		var houroptions = '';
		
		if(timeformat == 12){
			var i_start = 1;
			var i_end = 13;
		}
		
		if(timeformat == 24){
			var i_start = 0;
			var i_end = 24;
		}
		
		for(var i = i_start; i < i_end; i++){ 
			var i_zeropadding = ('00' + i.toString()).substr(i.toString().length);
			houroptions += "\r\n\t"+'<option value="'+i_zeropadding+'">'+i_zeropadding+'</option>';
		}
		
		return houroptions;
	}
	
	
	// EDIT OPTION VALUE
	form_editor.on('keyup focusout', 'input[type="text"].cfgenwp-editoption-value', function(){
	
		var edit_input = jQuery(this);
		
		var fb_e_c = edit_input.cfgen_closestFbElementCont();
		
		var e_c = fb_e_c.cfgen_findElementCont();
		
		var inputindex = edit_input.parent().index();
		
		if(edit_input.hasClass('radio') || edit_input.hasClass('checkbox')){
			
			var target_option = fb_e_c.find('div.cfgen-option-content:eq('+inputindex+')');
			target_option.find('label').text(edit_input.val());
			target_option.find('input').val(edit_input.val());			
		}
		
		if(edit_input.hasClass('select') || edit_input.hasClass('selectmultiple')){
		
			var selectedoption_index = e_c.find('select option:selected').index(); // FF: focus on the current selected option
			
			var target_option = e_c.find('select option:eq('+inputindex+')');
			target_option.val(edit_input.val()).text(edit_input.val());
			
			e_c.find('select option:eq('+selectedoption_index+')').prop('selected',true); // FF: focus on the current selected option
		}
	});
	

	// DELETE OPTION
	form_editor.on('click', 'span.cfgenwp-editoption-delete', function(){
	
		var delete_btn = jQuery(this);
		var inputindex = jQuery(this).parent().index();
		var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
		
		if(fb_e_c.find('div.cfgenwp-editoption-c').length == 1){
			
			cfgenwp_dialog_box.html('<p>You can\'t delete all choices.</p>').dialog(cfgenwp_dialog_error);

			return false;
			
		} else{
			
			if( jQuery(this).hasClass('radio') || jQuery(this).hasClass('checkbox') ){
			
				fb_e_c.find('.cfgen-option-content:eq('+inputindex+')').remove();
			}
			
			if(jQuery(this).hasClass('select') || jQuery(this).hasClass('selectmultiple')){
				fb_e_c.cfgen_findElementCont().find('select option:eq('+inputindex+')').remove();
			}
			
			jQuery(this).closest('div.cfgenwp-editoption-c').slideUp(200, function(){
																		  jQuery(this).cfgen_adjustElementHeightToRightContent(); // must be called before the removal of the button, or it won't work since delete_btn is removed
																		  
																		  jQuery(this).remove();// must be called after inputindex, else index returns -1
																		  
																		  }); 
		}
		
	});


	// ADD OPTION
	form_editor.on('click', 'span.cfgenwp-editoption-add', function(){
		
		var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
		
		var element_id = fb_e_c.data('cfgenwp_element_id');
		
		var edit_option_container = jQuery(this).closest('div.cfgenwp-editoption-c');
		
		var inputindex = jQuery(this).parent().index();
		
		if(jQuery(this).hasClass('radio')){
			
			// form option
			fb_e_c.find('div.cfgen-option-content:eq('+inputindex+')').after(html_optionradiocontainer);
			
			// editform option
			edit_option_container.after(html_editoptionradiocontainer);
			
		}
		
		if(jQuery(this).hasClass('checkbox')){
			// form option
			fb_e_c.find('div.cfgen-option-content:eq('+inputindex+')').after(html_optioncheckboxcontainer);
		
			// editform option
			edit_option_container.after(html_editoptioncheckboxcontainer);
		}
		
		
		// update id, name and for attributes on the input and on the label
		if(jQuery(this).hasClass('radio') || jQuery(this).hasClass('checkbox')){
			
			fb_e_c.find('div.cfgen-option-content').each(function(){
				var option_index = jQuery(this).index();
				
				var option_html_id = cfgenwp_element_name_prefix+element_id+'-'+option_index;
				var option_html_name = cfgenwp_element_name_prefix+element_id;
				
				jQuery(this).find('input').prop('id', option_html_id).prop('name', option_html_name);
				jQuery(this).find('label').prop('for', option_html_id);
			});
		

			// if new_option_css is not applied, the new options that are added keep their default format from the form load
			var new_option_css = {
									'font-family':jQuery.cfgen_getCssPropertyValue('input', 'font-family'),
									'font-weight':jQuery.cfgen_getCssPropertyValue('input', 'font-weight'),
									'font-style':jQuery.cfgen_getCssPropertyValue('input', 'font-style'),
									'font-size':jQuery.cfgen_getCssPropertyValue('input', 'font-size')+'px',
									'color':jQuery.cfgen_getCssPropertyValue('input', 'color')
								};
			var html_form_newoption_container = fb_e_c.find('.cfgen-option-content:eq('+(inputindex+1)+')');
			
			html_form_newoption_container.css(new_option_css);
			
			
			// alignment: only apply to current and new options when the alignment is set to left
			if(fb_e_c.find('input[type="radio"].cfgenwp-option-alignment:checked').val() == 'left'){
				var css = {'width':fb_e_c.find('.cfgenwp-input-option-width-value').val()};

				fb_e_c.find('.cfgen-option-content').css(buildAlignOptionLeftCss(css));
			}
		}
		
		if(jQuery(this).hasClass('select') || jQuery(this).hasClass('selectmultiple')){
		
			// form option
			fb_e_c.cfgen_findElementCont().find('select option:eq('+inputindex+')').after("\r\n\t"+html_selectoption);
			
			// editform option
			if(jQuery(this).hasClass('select')){
				edit_option_container.after(html_editselectoptioncontainer);
			}
			
			if(jQuery(this).hasClass('selectmultiple')){
				edit_option_container.after(html_editselectmultipleoptioncontainer);
			}
		}
		
		edit_option_container.next().hide().slideDown(100, 
														function(){
															jQuery(this).cfgen_adjustElementHeightToRightContent();
														});

	});



	// SET DEFAULT OPTION
	form_editor.on('click', 'span.cfgenwp-editoption-default', function(){
		
		var inputindex = jQuery(this).parent().index();
		
		var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
		
		// RADIO CHECKBOX
		if( jQuery(this).hasClass('radio') || jQuery(this).hasClass('checkbox') ){
			
				// clean previously checked elements
				fb_e_c.find('.cfgen-option-content input').each(function(){jQuery(this).prop('checked', false)});

				if(jQuery(this).hasClass('radio')){
					
					jQuery(this).closest('div.cfgenwp-options-editor-c').find('.radiocheck').removeClass('selected'); // for radio, all radio buttons must be reset in the editoption container
					
					// clean previously checked elements in editor
					fb_e_c.find('.radiocheck').hide(); // all radio buttons must be reset in the editoption container
					fb_e_c.find('.radiouncheck').show(); // all radio buttons must be reset in the editoption container
				}
				
				if(jQuery(this).hasClass('radiocheck')){
					jQuery(this).removeClass('selected');
					jQuery(this).hide().prev().show();
					
				} else{
					jQuery(this).next().addClass('selected');
					jQuery(this).hide().next().show();
				}
				
				// foreach option checked, we check the associated input
				jQuery(this).closest('div.cfgenwp-options-editor-c').find('.selected').each(function(){
					var option_selected_index = jQuery(this).parent().index();
					//console.log(option_selected_index);
					fb_e_c.find('.cfgen-option-content input:eq('+option_selected_index+')').prop('checked', true);
				});
		}
		
		// SELECT
		if(jQuery(this).hasClass('select')){
			
				jQuery(this).closest('div.cfgenwp-options-editor-c').find('.radiocheck').removeClass('selected'); // for select, all radio buttons must be reset in the editoption container
		
				// clean previously checked elements
				fb_e_c.cfgen_findElementCont().find('select option').each(function(){jQuery(this).prop('selected', false)});
				fb_e_c.find('.radiouncheck').show(); // 2 for radio img, every radio button must be reset in the editoption container
				fb_e_c.find('.radiocheck').hide(); // 2 for radio img, every radio button must be reset in the editoption container
				
				if(jQuery(this).hasClass('radiocheck')){
					
					jQuery(this).removeClass('selected');
					jQuery(this).hide();
					jQuery(this).prev().show();
					
					
					// all options are unselected after cleaning, if the same option is clicked twice, the focus is lost and a blank selection appears in IE and chrome
					if(!fb_e_c.cfgen_findElementCont().find('select option:selected').length){
						fb_e_c.cfgen_findElementCont().find('select option:eq(0)').prop('selected', true);
					}
				} else{
					jQuery(this).next().addClass('selected');
					jQuery(this).hide();
					jQuery(this).next().show();
					fb_e_c.cfgen_findElementCont().find('select option:eq('+inputindex+')').prop('selected', 'selected');
				}
		}

		// SELECT MULTIPLE
		if(jQuery(this).hasClass('selectmultiple')){
			
			// clean previously checked elements
			fb_e_c.cfgen_findElementCont().find('select option').each(function(){jQuery(this).prop('selected', false)});

			if(jQuery(this).hasClass('radiocheck')){
				jQuery(this).removeClass('selected');
				jQuery(this).hide();
				jQuery(this).prev().show();
				
			} else{
				jQuery(this).next().addClass('selected');
				jQuery(this).hide();
				jQuery(this).next().show();
			}
			
			// foreach option checked, we check the associated input
			jQuery(this).closest('div.cfgenwp-options-editor-c').find('.selected').each(function(){
				var option_selected_index = jQuery(this).parent().index();
				fb_e_c.cfgen_findElementCont().find('select option:eq('+option_selected_index+')').prop('selected', 'selected');
			});
		}
	});
	
	
	// FIND DATEPICKER 
	jQuery.fn.cfgen_findDatePicker = function(){
		return jQuery(this).cfgen_closestFbElementCont().find('input[type="text"].cfgen-form-value');
	}

	// DATEPICKER FORMAT
	form_editor.on('change', 'select.cfgenwp-datepicker-format', function(){
		jQuery(this).cfgen_findDatePicker().datepicker('option', 'dateFormat', jQuery(this).val());
	});

	// DATEPICKER FIRST DAY OF THE WEEK
	form_editor.on('change', 'select.cfgenwp-datepicker-firstdayoftheweek', function(){
		jQuery(this).cfgen_findDatePicker().datepicker('option', 'firstDay', jQuery(this).val());
	});
	
	// DATEPICKER DISABLE DAYS OF THE WEEK
	form_editor.on('click', 'input[type="checkbox"].cfgenwp-date-disabledaysoftheweek', function(){

		var disable = [];
		
		jQuery(this).closest('div.cfgenwp-e-property-r').find('.cfgenwp-date-disabledaysoftheweek:checked').each(function(){
			disable.push(parseInt(jQuery(this).val())); // parseInt mandatory because inArray also checks for the variable type and getDay returns an integer
		});
		
		jQuery(this).cfgen_findDatePicker().datepicker('option', 'beforeShowDay', function(dt){return [jQuery.inArray(dt.getDay(), disable) != -1 ? false : true];});
	});

	
	// DATEPICKER DISABLE PAST DATES
	form_editor.on('click', 'input[type="radio"].cfgenwp-date-disablepastdates', function(){
		jQuery(this).cfgen_findDatePicker().datepicker('option', 'minDate', 0);
	});

	
	// DATEPICKER Min Date Max Date check buttons
	form_editor.on('click', 'input[type="text"].cfgenwp-date-minmax-radiocontroller, select.cfgenwp-date-minmax-radiocontroller', function(){
		
		var currentbutton = jQuery(this).closest('div.cfgenwp-e-property-r').find('input[type="radio"]');
		currentbutton.prop('checked', true);
		
		currentbutton.trigger('click'); // to set the year range in the datepicker when the year range select menus are clicked instead of the radio button directly
	});
	
	
	// DATEPICKER Show Custom Min Date Custom Max Date
	form_editor.on('click', 'input[type="radio"].cfgenwp-date-mindatecustom, input[type="radio"].cfgenwp-date-maxdatecustom', function(){
		
		var c = jQuery(this).closest('div.cfgenwp-e-property-r');
		
		if(jQuery(this).hasClass('cfgenwp-date-mindatecustom')){
			var dp = c.find('.cfgenwp-date-mindatecustom-v');
		}
		
		if(jQuery(this).hasClass('cfgenwp-date-maxdatecustom')){
			var dp = c.find('.cfgenwp-date-maxdatecustom-v');
		}
		
		dp.datepicker('show');
	});
	
	
	// DATEPICKER Set Custom Min Date Custom Max Date
	form_editor.on('change', 'input[type="text"].cfgenwp-date-mindatecustom-v, input[type="text"].cfgenwp-date-maxdatecustom-v', function(){
		var input = jQuery(this);
		var val = input.val();
		
		if(input.hasClass('cfgenwp-date-mindatecustom-v')){
			input.cfgen_findDatePicker().datepicker('option', 'minDate', new Date(val));
		}
		
		if(input.hasClass('cfgenwp-date-maxdatecustom-v')){
			input.cfgen_findDatePicker().datepicker('option', 'maxDate', new Date(val));
		}		
	});

	
	// DATEPICKER Set Year Range
	form_editor.on('click', 'input[type="radio"].cfgenwp-date-yearrange-currentyearminus, input[type="radio"].cfgenwp-date-yearrange-currentyearplus', function(){
		// trigger is used on the year range select menus to call this function
		
		var input_target = jQuery(this).cfgen_findDatePicker();
		
		var c = jQuery(this).cfgen_closestElementPropertiesCont();

		var rangeminus = c.find('.cfgenwp-date-yearrange-currentyearminus-v').val();
		var rangeplus = c.find('.cfgenwp-date-yearrange-currentyearplus-v').val();

		input_target.datepicker('option', 'yearRange', '-'+rangeminus+':+'+rangeplus+'');
		input_target.datepicker('option', 'minDate', null);
		input_target.datepicker('option', 'maxDate', null);
	});

	// DATEPICKER LANGUAGE
	form_editor.on('change', 'select.cfgenwp-datepicker-language', function(){

		var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
		
		var input_target = jQuery(this).cfgen_findDatePicker();
		
		input_target.datepicker('option', jQuery.datepicker.regional[jQuery(this).val()]);
		
		// re-apply the selected dateFormat because the regional includes its own dateformat
		input_target.datepicker('option', 'dateFormat', fb_e_c.find('.cfgenwp-datepicker-format').val());
	});


	// CAPTCHA FORMAT
	form_editor.on('click', '#captchaformat-letters, #captchaformat-numbers, #captchaformat-lettersandnumbers, .cfgen-captcha-refresh', function(){
		form_editor.find('img.cfgen-captcha-img').cfgen_updateCaptcha();
	});
	
	form_editor.on('change', '#cfgenwp-captcha-length', function(){
		form_editor.find('img.cfgen-captcha-img').cfgen_updateCaptcha();
	});
	
	// SUBMIT HOVER
	form_editor.on('click', 'span.cfgenwp-hover-edit-c', function(){
		
		var btn = jQuery(this);
		var action = btn.data('cfgenwp_hover_edit_action');
		var property_c = btn.cfgen_closestElementPropertyCont();
		var add_hover_c = property_c.find('span.cfgenwp-hover-edit-c[data-cfgenwp_hover_edit_action="add"]');
		var hover_c = property_c.find('.cfgenwp-colorpicker-hover-c');
		var hover_input = property_c.find('input[type="text"]');
		var submit = form_editor.find('input[type="submit"].cfgen-submit');
		
		if(action == 'add'){
			add_hover_c.hide();			
			hover_c.show();
			hover_input.addClass('cfgenwp-add-to-export');
			btn.cfgen_hoverSubmitAdd();
		}
		
		if(action == 'del'){
			add_hover_c.show();
			hover_c.hide();
			hover_input.removeClass('cfgenwp-add-to-export');
			btn.cfgen_hoverSubmitDel();
		}
		
		jQuery(this).cfgen_adjustElementHeightToRightContent();
	});
	
	jQuery.fn.cfgen_hoverSubmitAdd = function(){
		var submit = form_editor.find('input[type="submit"].cfgen-submit');
		var property_c = jQuery(this).cfgen_closestElementPropertyCont();
		
		var css_property_name = jQuery(this).data('cfgenwp_colorpicker_csspropertyname');
		// By going through cfgenwp-colorpicker-default-c input text we can handle all the rollover effects without having to specify the text input class for color rollover, background rollover etc.
		var css_default_value = property_c.find('.cfgenwp-colorpicker-default-c input[type="text"]').val();
		var css_hover_value = property_c.find('.cfgenwp-colorpicker-hover-c input[type="text"]').val();		

		if(css_hover_value != css_default_value){
			submit.hover(function(){ jQuery(this).css(css_property_name, css_hover_value); }, function(){ jQuery(this).css(css_property_name, css_default_value); } );
		}
	}
	
	jQuery.fn.cfgen_hoverSubmitDel = function(){
		var submit = form_editor.find('input[type="submit"].cfgen-submit');
		var property_c = jQuery(this).cfgen_closestElementPropertyCont();
		var css_property_name = jQuery(this).data('cfgenwp_colorpicker_csspropertyname');
		var css_default_value = property_c.find('input[type="text"].cfgenwp-colorpicker-submit-color').val();
		
		submit.hover(function(){ jQuery(this).css(css_property_name, css_default_value); },	function(){ jQuery(this).css(css_property_name, css_default_value); } );
	}


	// REQUIRED FIELD
	form_editor.on('click', 'input[type="checkbox"].cfgenwp-validation-required', function(){
		
		var btn = jQuery(this);
		
		var e_c = btn.cfgen_findElementContThroughFbElementCont();
		
		var required_asterisk = e_c.find('.cfgen-required');
		
		if(btn.is(':checked')){
			/**
			 * IE problem: 
			 * We check if the cfgen-required is already there to prevent the element from being appended twice if the user clicks on the checkbox multiple times too quickly
			 * To have it working properly, we also must have the control separated from 'is checked' above
			 */
			if(!required_asterisk.length){
				e_c.find('label.cfgen-label').append(span_required);
				
				// Hide the label if the label value is empty, prevents from showing an asterix alone
				var e_editor_c = btn.cfgen_closestElementEditorCont();
				e_editor_c.find('input[type="text"].cfgenwp-edit-label-value').trigger('focusout'); // Also applied when editing the placeholder input on the "required field" checkbox
			}
		} else{
			required_asterisk.remove();
		}
	});

	
	// DELETE ELEMENT FROM THE EDITOR
	form_editor.on('click', 'div.cfgenwp-e-editor-btn-delete', function(){
	
		jQuery(this).css('cursor','default'); // prevent from having the hand cursor after the element slided up

		jQuery(this).closest('div.cfgenwp-fb-e-move-c').slideUp({duration:75, easing:'easeInOutQuart', done:function(){ jQuery(this).remove(); }});
	});
	
	// API SET LIST FIELD LABEL CLASS ON SELECT FORM ELEMENT CHANGE
	form_settings.on('change', 'select.cfgenwp-api-form-element-id', function(){
		
		var s = jQuery(this);
		
		var c = s.closest('div.cfgenwp-api-list-field-c');
		
		var field_label = c.find('div.cfgenwp-api-list-field-id-container');
		
		if(s.val()){
			field_label.addClass('cfgenwp-api-list-field-id-selected');
		} else{
			field_label.removeClass('cfgenwp-api-list-field-id-selected');
		}
	});
	
	
	// NEXT STEP - CONFIGURATION
	jQuery('#cfgenwp-gotoformconfiguration').click(function(){
		
		var cfgenwp_gotoconfig_error_message = '';
		
		var fb_e_c_collection = form_editor.cfgen_findFbElementConts();
		
		// ADJUSTMENT: if no email field after having previously added one, the delivery receipt section must be hidden by default
		if(!form_editor.find('input[type="text"].cfgen-type-email').length){
			form_config_user_notification_activate.prop('checked', false);
			jQuery('#deliveryreceiptconfiguration').hide();
		}
		
		
		// ERROR: no submit button
		if(!form_editor.find('input[type="submit"].cfgen-submit').length){
			cfgenwp_gotoconfig_error_message = 'You forgot to insert a submit button in your form.';
		}
		
		// ERROR: A field name must be set for all hidden input fields
		if(form_editor.find('input[type="text"].cfgen-type-hidden').length){
			
			form_editor.find('input[type="text"].cfgen-type-hidden').each(function(){
				
				if(!jQuery.trim(jQuery(this).cfgen_closestFbElementCont().find('input[type="text"].cfgenwp-edit-label-value').val())){
					
					cfgenwp_gotoconfig_error_message = 'A field name must be set for all the hidden input fields in your form.';
					
					return false; // only stops the each function
				}
			});
		}
		
		// ERROR: no input field in the form
		var form_has_input = 0;
		
		fb_e_c_collection.each(function(){
			
			if(jQuery.inArray(jQuery(this).data('cfgenwp_element_type'), [ 'checkbox', 'date',  'email', 'hidden', 'radio', 'rating', 'select', 'selectmultiple', 'terms', 'text', 'textarea', 'time', 'upload', 'url' ]) != -1){
				form_has_input = 1;
				return false;
			}
		});
		
		if(!form_has_input){
			cfgenwp_gotoconfig_error_message = 'You must add at least one input field in the form to make the data submission work properly.';
		}
		
		// ERROR FOUND?
		if(cfgenwp_gotoconfig_error_message){
			
			cfgenwp_dialog_box.html('<p>'+cfgenwp_gotoconfig_error_message+'</p>').dialog(cfgenwp_dialog_error);

			return false;
		}
		
		if(!cfgenwp_gotoconfig_error_message) {
		
			var insertfieldvalue_collection = form_settings.find('select.cfgenwp-insertfieldvalue');
			
			jQuery('#cfgenwp-notice-savevalidation').hide();
			
			jQuery('#cfgenwp-fb-editor-c').hide(0, function(){
				
				toolbar_c.add(loadformdata_c).css({'display':'none'});
				
				form_settings.css({'display':'block'});
				
				buildSelectNotificationEmailAddress(); 
				// ^-- this function must be triggered in gotoformconfiguration in order to update the labels of the email field names that will appear in the select options of #notificationemailaddress
				
				form_id.val() ? saveform_btn.html(saveform_btn_update) : saveform_btn.html(saveform_btn_add);

				var include_requiredfield = form_editor.cfgen_findRequiredChecked().length ? true : false;
				var include_emailfield = form_editor.find('input[type="text"].cfgen-type-email').length ? true : false;
				var include_captcha = form_editor.find('img.cfgen-captcha-img').length ? true : false;
				var include_terms = form_editor.cfgen_findTermsRequiredChecked().length ? true : false;
				var include_uploadfield = form_editor.find('div.replace_upload_field').length ? true : false;
				var include_urlfield = form_editor.find('input[type="text"].cfgen-type-url').length ? true : false;

				if(include_requiredfield || include_emailfield || include_captcha || include_uploadfield || include_urlfield){
					
					jQuery('#cfgenwp-form-error-msgs-c').css({'display':'block'});
					
					if(include_requiredfield){
						jQuery('#cfgenwp-form-error-msg-required-c').css({'display':'block'});
					}
					
					if(include_terms){
						jQuery('#cfgenwp-form-error-msg-terms-c').css({'display':'block'});
					}
					
					if(include_emailfield){
						jQuery('#cfgenwp-form-error-msg-email-c').css({'display':'block'});
					}
					
					if(include_captcha){
						jQuery('#cfgenwp-form-error-msg-captcha-c').css({'display':'block'});
					}
					
					if(include_urlfield){
						jQuery('#cfgenwp-form-error-msg-url-c').css({'display':'block'});
					}
					
					if(include_uploadfield){
						jQuery('#cfgenwp-form-error-msg-uploadfilesize-c').css({'display':'block'});
						form_editor.find('.radio_upload_filetype_custom:checked').length ? jQuery('#cfgenwp-form-error-msg-uploadfiletype-c').css({'display':'block'}) : jQuery('#cfgenwp-form-error-msg-uploadfiletype-c').css({'display':'none'});
					}
				}
			
			
				// SELECT INSERT FIELD VALUE
				insertfieldvalue_collection.empty().append('<option value="">Insert Field Value</option>'); // important to set value="" jQuery(cfgenwp-insertfieldvalue).val() would still return the value between option otherwise


				// ELEMENTS ARRAY
				var elements_list_array = [];
				
				fb_e_c_collection.each(function(){
					
					var cfgenwp_elementbuilder = jQuery(this);
					var cfgenwp_elementbuilder_id = cfgenwp_elementbuilder.data('cfgenwp_element_id');
					
					var cfgenwp_elementbuilder_labeledit = cfgenwp_elementbuilder.cfgen_findProperLabel();
					
					var e_validation_required = cfgenwp_elementbuilder.find('input[type="checkbox"].cfgenwp-validation-required:checked').length ? true : false;
					
					// the element is a form input (not a title, not a submit button, etc.)
					if(jQuery.inArray(cfgenwp_elementbuilder.data('cfgenwp_element_type'), cfgenwp_isinput_list) != -1){
						insertfieldvalue_collection.append('<option value="'+cfgenwp_elementbuilder_id+'">'+cfgenwp_elementbuilder_labeledit+'</option>');
						
						elements_list_array.push( {'element_labelhtml':cfgenwp_elementbuilder_labeledit, 'element_id':cfgenwp_elementbuilder_id, 'validation_required':e_validation_required} );
					}
					
				});
				
				// DATABASE BUILDER: UPDATE ELEMENT LIST
				var db_select_element_id_collection = jQuery.map(jQuery('#cfgenwp-database-form-elements option'), function(ele){return ele.value;});
				
				jQuery('#cfgenwp-database-select-form-elements').empty();
				
				jQuery.each(elements_list_array, function(index, value){
					jQuery('#cfgenwp-database-select-form-elements').append('<div data-cfgenwp_database_item_type="element" data-cfgenwp_database_form_e_id="'+value['element_id']+'" data-cfgenwp_database_e_required="'+value['validation_required']+'">'+value['element_labelhtml']+'</div>');
				});
				
				var database_builder_predefined_options = ''
														 +'<div data-cfgenwp_database_item_type="preset" data-cfgenwp_database_preset_id="form_name">Form name</div>'
														 +'<div data-cfgenwp_database_item_type="preset" data-cfgenwp_database_preset_id="form_url">Form URL</div>'
														 +'<div data-cfgenwp_database_item_type="preset" data-cfgenwp_database_preset_id="form_id">Form ID</div>'
														 +'<div data-cfgenwp_database_item_type="preset" data-cfgenwp_database_preset_id="ipaddress">User\'s IP address</div>'
														 +'<div data-cfgenwp_database_item_type="preset" data-cfgenwp_database_preset_id="date">Date <br>yyyy-mm-dd</div>'
														 +'<div data-cfgenwp_database_item_type="preset" data-cfgenwp_database_preset_id="datetime">DateTime <br>yyyy-mm-dd hh:mm:ss</div>'
														 +'<div data-cfgenwp_database_item_type="preset" data-cfgenwp_database_preset_id="time">Time <br>hh:mm:ss</div>'
														 +'<div data-cfgenwp_database_item_type="preset" data-cfgenwp_database_preset_id="utc_timestamp">UTC timestamp</div>'
														 +'<div data-cfgenwp_database_item_type="preset" data-cfgenwp_database_preset_id="unix_timestamp">Unix timestamp</div>'
														 ;

				jQuery('#cfgenwp-database-select-form-elements').append(database_builder_predefined_options);

				
				var database_item_position = '';
				jQuery('#cfgenwp-database-select-form-elements').sortable({
																			connectWith:'#cfgenwp-database-builder',
																			placeholder:'cfgenwp-database-builder-placeholder',
																			start:function(event, ui){
																				jQuery('#cfgenwp-database-howto').remove();
																				
																				database_item_position = ui.item.index();

																				var duplicate_option = ui.item.clone();
																				
																				duplicate_option.removeAttr('style').addClass('cfgenwp-database-item-clone');
																				
																				jQuery('#cfgenwp-database-select-form-elements div').eq(database_item_position).before(duplicate_option);
																				
																				jQuery('#cfgenwp-database-builder').addClass('cfgenwp-database-builder-hover');
																				
																			},
																			stop:function(event, ui){
																				
																				var sort_container = ui.item.closest('.ui-sortable');
																				
																				var duplicate_option = ui.item.clone();
																				
																				duplicate_option.removeAttr('style');
																				
																				jQuery('.cfgenwp-database-item-clone').remove();
																				
																				if(sort_container.is(jQuery(this))){
																					jQuery(this).sortable('cancel');
																				} else{
																					// After being dropped in the container, the item is removed from the list and the next item has taken its place
																					// In order to have it back at its original position, we use .before() after .eq() which is zero based
																					var item_before = jQuery('#cfgenwp-database-select-form-elements div').eq(database_item_position);
																					
																					// If we move the last element of the list, .eq(last_position) does not exist anymore, therefore .before() would not append the cloned item
																					if(!item_before.length){
																						jQuery('#cfgenwp-database-select-form-elements').append(duplicate_option);
																					} else{
																						// Moving everything else but the last element
																						jQuery('#cfgenwp-database-select-form-elements div').eq(database_item_position).before(duplicate_option);
																					}
																					
																				}
																				
																				jQuery('#cfgenwp-database-builder').removeClass('cfgenwp-database-builder-hover');
																			}
																			}).disableSelection();


				jQuery('#cfgenwp-database-builder').sortable({
														handle:'.cfgenwp-database-builder-move-c',
														placeholder:'cfgenwp-database-builder-sortable-placeholder',
														receive:function(event, ui){
															
															var option = ui.item;
															
															var item_type = option.data('cfgenwp_database_item_type');

															if(item_type === 'preset'){
																var item_to_add = {'preset_id':option.data('cfgenwp_database_preset_id')};
															}
															
															if(item_type === 'element'){
																var item_to_add = {'element_id':option.data('cfgenwp_database_form_e_id')};
																
																// If the element is required, can_be_null is false
																item_to_add['can_be_null'] = option.data('cfgenwp_database_e_required') === true ? false : true;
															}
															
															item_to_add['item_type'] = item_type;
															item_to_add['item_label'] = option.text();
															item_to_add['table_field_id'] = '';
															item_to_add['table_field_default_value'] = '';

															var database_item_html = jQuery(this).cfgen_addToDatabaseBuilder([item_to_add]);
															
															var jq_database_item = jQuery(database_item_html).hide();
															option.replaceWith(jq_database_item);
															jq_database_item.fadeIn(180);
														}
				});


				
				// DATABASE BUILDER: UPDATE LABELS IN THE ITEMS LIST
				var database_table_items_c = jQuery('#cfgenwp-database-builder').find('div.cfgenwp-database-builder-table-item-c');
				
				if(!database_table_items_c.length){
					jQuery('#cfgenwp-database-builder').empty().append('<div id="cfgenwp-database-howto">Drag and drop the elements you want<br> to save in your database here.</div>');
				}else{
					jQuery('#cfgenwp-database-howto').hide();
				}

				database_table_items_c.each(function(){
					
					var c = jQuery(this);
					
					var item_type = c.data('cfgenwp_database_item_type');
					
					if(item_type === 'element'){

						var database_element_id = c.data('cfgenwp_database_form_e_id');
						
						
						var database_item_option = jQuery('#cfgenwp-database-select-form-elements').find('div[data-cfgenwp_database_form_e_id="'+database_element_id+'"]');
						
						if(!database_item_option.length){
							c.cfgen_deleteFromDatabaseBuilder();
						} else{
							c.find('div.cfgenwp-database-builder-item-label-c').html(database_item_option.html());
							
							var database_item_default_value_c = c.find('div.cfgenwp-database-builder-table-field-default-value-c');
							
							var database_element_required = database_item_option.data('cfgenwp_database_e_required');
							
							// If the element is required, we can't set to null, therefore we hide the null container
							if(database_element_required === true){
								database_item_default_value_c.hide();
							} else{
								// If the element is not required, we show the null container
								database_item_default_value_c.show();
							}
						}	
					}
					
					if(item_type == 'preset'){
						var database_preset_id = c.data('cfgenwp_database_item_preset_id');
						
						var database_item_option = jQuery('#cfgenwp-database-select-form-elements').find('div[data-cfgenwp_database_preset_id="'+database_preset_id+'"]');
						
						c.find('div.cfgenwp-database-builder-item-label-c').html(database_item_option.html());
					}
				});


				// API UPDATE SELECT ELEMENT CONTAINER FOR API LIST FIELDS
				if(jQuery('.cfgenwp-api-form-element-id').length){
					
					jQuery('.cfgenwp-api-form-element-id').each(function(){
						var select_container = jQuery(this);
						var api_c = select_container.closest('div.cfgenwp-api-list-c');
						
						var list_id = api_c.data('cfgenwp_api_list_id');

						// prevents duplicate options when going back from editor to configuration
						// We use filter() remove all the options but the first option (which is a blank option and has no value)
						// this.value is the element id set in the option value
						select_container.find('option').filter(function(){return this.value}).remove();
						
						jQuery.each(elements_list_array, function(index, value){
							select_container.append('<option value="'+value['element_id']+'">'+value['element_labelhtml']+'</option>');
						});
						
						// keeps the option previously selected as selected when going back from editor to configuration
						select_container.find('option[value='+cfgenwp_list_field_selected_element_id[select_container.attr('id')]+']').prop('selected',true);
						
					});
				}
				
				insertfieldvalue_collection.append('<option value="ipaddress">User IP Address</option>')
										   .append('<option value="form_name">Form Name</option>')
										   .append('<option value="url">Form URL</option>');
				//insertfieldvalue_collection.append('<option value="form_id">Form ID</option>');

				
				// IF A FORM IS LOADED, LOAD API CONFIG ONCE
				if(!cfgenwp_flag_load_api){
					cfgenwp_flag_load_api = 1; // also set to 1 when clicking on "start from scratch" to prevent lists from loading when starting on a form containing lists
					
					jQuery.each(cfgenwp_loadform_api_config, function(index, value){
						
						var c = jQuery('.cfgenwp-editor-api-c[data-cfgenwp_api_id="'+index+'"]');
						
						jQuery.cfgen_findServiceMenuIco(index).trigger('click');
						
						c.find('.cfgenwp-integrate-api').trigger('click').cfgen_apiShowAuthenticate();
						
					});
				}

				// scroll to top
				window.scrollTo(0, 0);
				
			}); // #cfgenwp-fb-editor-c hide
			
		} // if(!cfgenwp_gotoconfig_error_message)
		
	}); // jQuery('#cfgenwp-gotoformconfiguration').click

	
	returntoformedition_btn.click(function(){

		jQuery.cfgen_returnToFormEdition();

		jQuery('html,body').animate({scrollTop: jQuery('#cfgenwp-gotoformconfiguration').offset().top}, 1);
	});
	
	jQuery('#cfgenwp-database-select-form-elements').on('mousedown', 'div', function(){
		jQuery(this).addClass('cfgenwp-database-select-grabbing');
	});
	
	jQuery('#cfgenwp-database-select-form-elements').on('mouseup', 'div', function(){
		jQuery(this).removeClass('cfgenwp-database-select-grabbing');
	});
	
	form_config_user_notification_insertformdata.click(function(){
		var btn_insertformdata = jQuery(this);
		var btn_hideemptyvalues = jQuery('#cfgenwp-config-user-notification-hideemptyvalues');
		var hideemptyvalues_c = jQuery('#cfgenwp_usernotification_hideemptyvalues_c')
		
		if(btn_insertformdata.is(':checked')){
			hideemptyvalues_c.show();
		} else{
			btn_hideemptyvalues.prop('checked', false);
			hideemptyvalues_c.hide();
		}
	});
	
	// SAVE FORM
	saveform_btn.click(function(){

 		alert("button clicked saved");

		var cfgenwp_saveform_error_message = '';
		var cfgenwp_saveform_error_buttons = '';
		
		// IE8 doesn't like jQuery(this).trim()
		form_config_form_name.val(jQuery.trim(form_config_form_name.val()));

		form_config_email_from.val(jQuery.trim(form_config_email_from.val()));


		// SAVE EMAIL CC
		form_config_email_address_cc.val(jQuery.trim(form_config_email_address_cc.val()));
		var config_email_address_cc = form_config_email_address_cc.val();
		
		
		// SAVE EMAIL BCC
		form_config_email_address_bcc.val(jQuery.trim(form_config_email_address_bcc.val()));
		var config_email_address_bcc = form_config_email_address_bcc.val();
	
		
		// SAVE EMAIL
		form_config_email_address.val(jQuery.trim(form_config_email_address.val()));

		
		// ERROR: The form name cannot be left blank
		if(!jQuery.trim(form_config_form_name.val())){
			cfgenwp_saveform_error_message = cfgenwp_dialog['form_name_empty']['text'];
			cfgenwp_saveform_error_buttons = cfgenwp_dialog['form_name_empty']['buttons'];
		}


		// ERROR: The notification subject line cannot be left blank
		if(!jQuery.trim(form_config_admin_notification_subject.val())){
			cfgenwp_saveform_error_message = cfgenwp_dialog['adminnotification_subject_line_empty']['text'];
			cfgenwp_saveform_error_buttons = cfgenwp_dialog['adminnotification_subject_line_empty']['buttons'];
		}


		// ERROR: Check if the url for the confirmation is blank
		if(jQuery('#cfgenwp-config-redirecturl-btn').is(':checked')){
			
			if(!jQuery.trim(form_config_redirecturl.val())){
				cfgenwp_saveform_error_message = cfgenwp_dialog['redirecturl_empty']['text'];
				cfgenwp_saveform_error_buttons = cfgenwp_dialog['redirecturl_empty']['buttons'];
			}

			var saveform_config_redirecturl_val = jQuery.trim(form_config_redirecturl.val());
			var config_validationmessage = '';
			
		} else{
			var saveform_config_redirecturl_val = '';
			var config_validationmessage = jQuery('#cfgenwp-config-validationmessage-input').val();
		}


		// ERROR: if delivery receipt is activated, there must be an email field in the form
		if(form_config_user_notification_activate.is(':checked') && !jQuery('#cfgenwp_config_usernotification_inputid').val()){
			cfgenwp_saveform_error_message = cfgenwp_dialog['autoresponder_email_field_missing']['text'];
			cfgenwp_saveform_error_buttons = cfgenwp_dialog['autoresponder_email_field_missing']['buttons'];
		}


		// ERROR: if delivery receipt is activated and "insert copy of form data" is not checked, the notification message cannot be left blank
		// SMTP => Body can't be empty or the message won't be sent
		// SMTP => ErrorInfo would return: Message was not sent.Mailer error: Message body empty
		if(form_config_user_notification_activate.is(':checked') && !jQuery.trim(form_config_user_notification_message.val()) && !jQuery('#config_usernotification_insertformdata').is(':checked')){
			cfgenwp_saveform_error_message = cfgenwp_dialog['usernotification_message_empty']['text'];
			cfgenwp_saveform_error_buttons = cfgenwp_dialog['usernotification_message_empty']['buttons'];
		}
		
		// ERROR DATABASE
		if(jQuery.cfgen_databaseIsActivated()){

			// ERROR DATABASE: empty host, empty db name, empty login, empty table name
			if(!jQuery.trim(form_config_database_host.val()) 
				|| !jQuery.trim(form_config_database_name.val()) 
				|| !jQuery.trim(form_config_database_login.val()) 
				|| !jQuery.trim(form_config_database_table.val()) 
			){
				cfgenwp_saveform_error_message = cfgenwp_dialog['database_credentials_empty']['text'];
				cfgenwp_saveform_error_buttons = cfgenwp_dialog['database_credentials_empty']['buttons'];
			}

 
			// ERROR DATABASE: empty table field name, table field/column used twice, no element selected
			if(!cfgenwp_saveform_error_message){
				// ^-- It makes more sense to display the empty field name error message after the database connection error message (if any)
				var databasebuilder_fields_c = jQuery('#cfgenwp-database-builder').find('div.cfgenwp-database-builder-table-item-c');
				
				if(databasebuilder_fields_c.length){
					
					var databasebuilder_table_field_names_collection = [];

					databasebuilder_fields_c.each(function(){
					
						var c = jQuery(this);
						var table_field_name = jQuery.trim(c.find('input[type="text"].cfgenwp-database-builder-table-field-id').val());
						
						// Empty table field name
						if(!table_field_name){
							cfgenwp_saveform_error_message = cfgenwp_dialog['database_field_name_empty']['text'];
							cfgenwp_saveform_error_buttons = cfgenwp_dialog['database_field_name_empty']['buttons'];
						}
						
						if(!cfgenwp_saveform_error_message){
							// Table column used twice
							if(jQuery.inArray(table_field_name, databasebuilder_table_field_names_collection) != -1){
								cfgenwp_dialog['database_field_name_twice'] = {text : '<p>There is an error in the database settings. It is not valid to use the table column name "'+table_field_name+'" more than once. A table field name cannot be used multiple times for multiple elements.</p>', buttons : {OK: function(){jQuery(this).dialog('close');}}};
								cfgenwp_saveform_error_message = cfgenwp_dialog['database_field_name_twice']['text'];
								cfgenwp_saveform_error_buttons = cfgenwp_dialog['database_field_name_twice']['buttons'];
							} else{
								databasebuilder_table_field_names_collection.push(table_field_name);
							}
						}
					});
				} else{
					// No element selected
					cfgenwp_saveform_error_message = cfgenwp_dialog['database_no_element_selected']['text'];
					cfgenwp_saveform_error_buttons = cfgenwp_dialog['database_no_element_selected']['buttons'];
				}				
			}
		}
		
		// ERROR SMTP: empty host, empty port 
		if(jQuery('#cfgenwp-config-emailsendingmethod').val() == 'smtp' && (!form_config_smtp_host.val() || !form_config_smtp_port.val())){
			cfgenwp_saveform_error_message = cfgenwp_dialog['smtp_empty']['text'];
			cfgenwp_saveform_error_buttons = cfgenwp_dialog['smtp_empty']['buttons'];
		}
		
		// ERROR SMS ADMIN NOTIFICATION
		if(jQuery.cfgen_smsAdminNotificationIsActivated()){
			
			if(!jQuery.cfgen_hasDigitsOnly(form_config_sms_admin_notification_to_phone_number.val())){
				
				cfgenwp_saveform_error_message = cfgenwp_dialog['sms_admin_notification_to_phone_number_numbers_only']['text'];
				cfgenwp_saveform_error_buttons = cfgenwp_dialog['sms_admin_notification_to_phone_number_numbers_only']['buttons'];
			}

			if(!form_config_sms_admin_notification_message.val()){
				
				cfgenwp_saveform_error_message = cfgenwp_dialog['sms_admin_notification_message_empty']['text'];
				cfgenwp_saveform_error_buttons = cfgenwp_dialog['sms_admin_notification_message_empty']['buttons'];
			}

			if(!form_config_sms_admin_notification_gateway.val()){
				
				cfgenwp_saveform_error_message = cfgenwp_dialog['sms_admin_notification_gateway_empty']['text'];
				cfgenwp_saveform_error_buttons = cfgenwp_dialog['sms_admin_notification_gateway_empty']['buttons'];
			}

			if(jQuery.cfgen_smsAdminNotificationGatewayIsClickatell()){
				
				if(!form_config_sms_admin_notification_clickatell_username.val() || !form_config_sms_admin_notification_clickatell_password.val() || !form_config_sms_admin_notification_clickatell_api_id.val()){

					cfgenwp_saveform_error_message = cfgenwp_dialog['sms_admin_notification_clickatell_empty_parameter']['text'];
					cfgenwp_saveform_error_buttons = cfgenwp_dialog['sms_admin_notification_clickatell_empty_parameter']['buttons'];
				}
			}

			if(jQuery.cfgen_smsAdminNotificationGatewayIsTwilio()){
				
				if(!form_config_sms_admin_notification_twilio_from_phone_number.val() || !form_config_sms_admin_notification_twilio_account_sid.val() || !form_config_sms_admin_notification_twilio_auth_token.val()){

					cfgenwp_saveform_error_message = cfgenwp_dialog['sms_admin_notification_twilio_empty_parameter']['text'];
					cfgenwp_saveform_error_buttons = cfgenwp_dialog['sms_admin_notification_twilio_empty_parameter']['buttons'];
				}
				
				if(!jQuery.cfgen_hasDigitsOnly(form_config_sms_admin_notification_twilio_from_phone_number.val())){
					
					cfgenwp_saveform_error_message = cfgenwp_dialog['sms_admin_notification_from_phone_number_numbers_only']['text'];
					cfgenwp_saveform_error_buttons = cfgenwp_dialog['sms_admin_notification_from_phone_number_numbers_only']['buttons'];
				}
			}
			
		}
		
		// FORM MESSAGE : ERROR AND VALIDATION MESSAGE STYLE
		// the error check for empty color, empty background color, empty width, empty fontsize is based on export_validationmessage_style and export_errormessage_style
		var export_validationmessage_style = {
											'font-family':formmessage_validation_style_c.find('select.cfgenwp-fontfamily-select').val(),
											'font-size':formmessage_validation_style_c.find('select.cfgenwp-formmessage-fontsize-select').val()+'px',
											'font-weight':formmessage_validation_style_c.find('select.cfgenwp-fontweight-select').val(),
											'font-style':formmessage_validation_style_c.find('select.cfgenwp-fontstyle-select').val(),
											'color':jQuery.trim(jQuery('#cfgenwp-validationmessage-color').val()),
											'background-color':jQuery.trim(jQuery('#cfgenwp-validationmessage-backgroundcolor').val()),
											'width':jQuery.trim(formmessage_validation_style_c.find('.cfgenwp-formmessage-width-input-value').val())+'px'
											};
		
		// SAVE ERROR
		var export_errormessage_style = {
										'font-family':formmessage_error_style_c.find('select.cfgenwp-fontfamily-select').val(),
										'font-size':formmessage_error_style_c.find('select.cfgenwp-formmessage-fontsize-select').val()+'px',
										'font-weight':formmessage_error_style_c.find('select.cfgenwp-fontweight-select').val(),
										'font-style':formmessage_error_style_c.find('select.cfgenwp-fontstyle-select').val(),
										'color':jQuery.trim(jQuery('#cfgenwp-errormessage-color').val()),
										'background-color':jQuery.trim(jQuery('#cfgenwp-errormessage-backgroundcolor').val())
										/*,
										'width':jQuery.trim(formmessage_error_style_c.find('.cfgenwp-formmessage-width-input-value').val())+'px'*/
										};


		if(!export_validationmessage_style['color']){
			cfgenwp_saveform_error_message = '<p>The color field of the validation message cannot be left blank.</p>';
			cfgenwp_saveform_error_buttons = cfgenwp_dialog_button_close;
		}
		
		if(!export_errormessage_style['color']){
			cfgenwp_saveform_error_message = '<p>The color field of the error message cannot be left blank.</p>';
			cfgenwp_saveform_error_buttons = cfgenwp_dialog_button_close;
		}
		
		if(!export_validationmessage_style['background-color']){
			cfgenwp_saveform_error_message = '<p>The backround color field of the validation message cannot be left blank.</p>';
			cfgenwp_saveform_error_buttons = cfgenwp_dialog_button_close;
		}
		
		if(!export_errormessage_style['background-color']){
			cfgenwp_saveform_error_message = '<p>The background color field of the error message cannot be left blank.</p>';
			cfgenwp_saveform_error_buttons = cfgenwp_dialog_button_close;
		}
		
		if(export_validationmessage_style['width'] == 'px'){
			cfgenwp_saveform_error_message = '<p>The width field of the validation message cannot be left blank.</p>';
			cfgenwp_saveform_error_buttons = cfgenwp_dialog_button_close;
		}
		
		if(export_errormessage_style['width'] == 'px'){
			cfgenwp_saveform_error_message = '<p>The width field of the error message cannot be left blank.</p>';
			cfgenwp_saveform_error_buttons = cfgenwp_dialog_button_close;
		}

		
		if(cfgenwp_saveform_error_message){
			cfgenwp_dialog_box.html(cfgenwp_saveform_error_message).dialog({autoOpen: true, title: 'Error', buttons: cfgenwp_saveform_error_buttons});
			return false;
		}
		
		saveform_btn.hide();
		
		returntoformedition_btn.hide();
		
		jQuery('#downloadsources').empty().hide();
		
		var notice_savingform = jQuery('#cfgenwp-notice-savingform');
		notice_savingform.css({'display':'inline-block'});
		
		var aftersave_cs = jQuery('.cfgenwp-aftersave');
		aftersave_cs.hide();
		
		// catch uploaded images file name
		var export_imageupload = [];
		
		
		// JSON EXPORT ARRAY
		var json_export = {};
		var export_element = [];
		cfgenwp_export_googlewebfonts = {}; // must be global in order to be accessible in buildExportGoogleWebFonts


		// GOOGLE WEB FONTS: label
		if(label_fontfamily_select.cfgen_isGoogleWebFont()){
			buildExportGoogleWebFonts(label_fontfamily_select.val(), label_fontweight_select.val(), label_fontstyle_select.val());
		}		
		
		// GOOGLE WEB FONTS: inputs
		if(input_fontfamily_select.cfgen_isGoogleWebFont()){
			buildExportGoogleWebFonts(input_fontfamily_select.val(), input_fontweight_select.val(), input_fontstyle_select.val());
		}

		// GOOGLE WEB FONTS: paragraph
		if(paragraph_fontfamily_select.cfgen_isGoogleWebFont()){
			buildExportGoogleWebFonts(paragraph_fontfamily_select.val(), paragraph_fontweight_select.val(), paragraph_fontstyle_select.val());
		}

		// GOOGLE WEB FONTS: title
		if(title_fontfamily_select.cfgen_isGoogleWebFont()){
			buildExportGoogleWebFonts(title_fontfamily_select.val(), title_fontweight_select.val(), title_fontstyle_select.val());
		}

		// GOOGLE WEB FONTS: validation message
		var cfgenwp_formmessage_validation_select_fontfamily = formmessage_validation_style_c.find('select.cfgenwp-fontfamily-select');
		
		if(cfgenwp_formmessage_validation_select_fontfamily.cfgen_isGoogleWebFont()){
			buildExportGoogleWebFonts(cfgenwp_formmessage_validation_select_fontfamily.val(), formmessage_validation_style_c.find('select.cfgenwp-fontweight-select').val(), formmessage_validation_style_c.find('select.cfgenwp-fontstyle-select').val());
		}
		
		// GOOGLE WEB FONTS: error message
		var cfgenwp_formmessage_error_select_fontfamily = formmessage_error_style_c.find('select.cfgenwp-fontfamily-select');
		
		if(cfgenwp_formmessage_error_select_fontfamily.cfgen_isGoogleWebFont()){
			buildExportGoogleWebFonts(cfgenwp_formmessage_error_select_fontfamily.val(), formmessage_error_style_c.find('select.cfgenwp-fontweight-select').val(), formmessage_error_style_c.find('select.cfgenwp-fontstyle-select').val());
		}
		
		var input_border_radius_px = getInputBorderRadiusPx();
		var input_border_width_px = getInputBorderWidthPx();

		var export_icon_config = false;
		var export_rating_config = false;
		var export_datepicker_config = [];
		var export_upload_config = [];		
		var export_css = {};
		var export_captcha = {};
		

		export_css['label'] = {'default':{
											'font-family':label_fontfamily_select.val(),
											'font-weight':label_fontweight_select.val(),
											'font-style':label_fontstyle_select.val(),
											'font-size':label_fontsize_select.val()+'px',
											'color':jQuery.trim(jQuery('#cfgenwp-label-color').val()),
											'margin-bottom':jQuery('#cfgenwp-label-all-marginbottom-select').val()+'px'
											}};
		
		export_css['paragraph'] = {'default':{
											'font-family':paragraph_fontfamily_select.val(),
											'font-weight':paragraph_fontweight_select.val(),
											'font-style':paragraph_fontstyle_select.val(),
											'font-size':paragraph_fontsize_select.val()+'px',
											'color':jQuery.trim(jQuery('#cfgenwp-paragraph-color').val())
											}};
		
		export_css['title'] = {'default':{
											'font-family':title_fontfamily_select.val(),
											'font-weight':title_fontweight_select.val(),
											'font-style':title_fontstyle_select.val(),
											'font-size':title_fontsize_select.val()+'px',
											'color':jQuery.trim(jQuery('#cfgenwp-title-color').val())
											}};
		
		export_css['input'] = {'default':{
											'font-family':input_fontfamily_select.val(),
											'font-weight':input_fontweight_select.val(),
											'font-style':input_fontstyle_select.val(),
											'font-size':input_fontsize_select.val()+'px',
											'color':jQuery.trim(jQuery('#cfgenwp-input-color').val()),
											'padding':input_padding_select.val()+'px',
											'border-radius':jQuery('#cfgenwp-input-all-borderradius-select').val()+'px',
											'border-width':jQuery('#cfgenwp-input-all-borderwidth-select').val()+'px',
											'border-style':'solid',
											'border-color':jQuery.trim(jQuery('#cfgenwp-input-bordercolor').val()),
											'background-color':jQuery.trim(jQuery('#cfgenwp-input-backgroundcolor').val())
											},
								'focus':{
											'border-color':jQuery.trim(jQuery('#cfgenwp-input-bordercolor-focus').val())
										}};
		
		export_css['validationmessage'] = {'default':export_validationmessage_style};
		export_css['errormessage'] = {'default':export_errormessage_style};
		
		// export elements
		form_editor.cfgen_findFbElementConts().each(function(){
			
			var fb_e_c = jQuery(this);
			var e_editor_c = fb_e_c.cfgen_findElementEditorCont();

			var type = fb_e_c.data('cfgenwp_element_type');
			var export_element_id = fb_e_c.data('cfgenwp_element_id');
			
			var element_obj = {};
			element_obj['id'] = export_element_id;
			element_obj['type'] = type;
			
			var icon_width_val = 0;
			var paragraph_width_val = 0;
			
			var export_input = {'css':{ 'default':{}, 'hover':{} }};
			
			var export_e_set_container = {'id':'', 'css':{ 'default':{} }}; // id updated in saveform.php
			var export_input_group_container = {'id':'', 'css':{ 'default':{} }}; // id updated in saveform.php
			var export_input_container = {'id':'', 'css':{ 'default':{} }}; // id updated in saveform.php
			
			var e_editor_font_family_select = e_editor_c.find('select.cfgenwp-fontfamily-select');
			if(e_editor_font_family_select.length){
				var export_css_font_family = e_editor_font_family_select.val();
			}
			
			var e_editor_font_weight = e_editor_c.find('select.cfgenwp-fontweight-select');
			if(e_editor_font_weight.length){
				var export_css_font_weight = e_editor_font_weight.val();
			}
			
			var e_editor_font_style = e_editor_c.find('select.cfgenwp-fontstyle-select');
			if(e_editor_font_style.length){
				var export_css_font_style = e_editor_font_style.val();
			}
			
			// catch google web fonts
			if(e_editor_font_family_select.cfgen_isGoogleWebFont()){
				buildExportGoogleWebFonts(export_css_font_family, export_css_font_weight, export_css_font_style);
			}
			
			// SAVE HIDDEN
			if(type == 'hidden'){
				export_e_set_container['css']['default']['display'] = 'none';
				
				element_obj['hidden'] = {'value':e_editor_c.find('input[type="text"].cfgenwp-hidden-input-value').val()};
				
				element_obj['label'] = {'id':'', 'value':e_editor_c.find('input[type="text"].cfgenwp-edit-label-value').val(), 'css':export_label_css};
			}

			
			// SAVE SUBMIT
			if(type == 'submit'){
				
				var export_submit_css = {'default':{
													'font-family':export_css_font_family,
													'font-weight':export_css_font_weight,
													'font-style':export_css_font_style,
													'font-size':e_editor_c.find('select.cfgen-submit-fontsize-select').val()+'px',
													'color':e_editor_c.find('input[type="text"].cfgenwp-colorpicker-submit-color').val(),
													'background-color':e_editor_c.find('input[type="text"].cfgenwp-colorpicker-submit-backgroundcolor').val(),
													'border-width':'1px',
													'border-style':'solid',
													'border-color':e_editor_c.find('input[type="text"].cfgenwp-colorpicker-submit-bordercolor').val(),
													'border-radius':e_editor_c.find('select.cfgen-submit-borderradius-select').val()+'px',
													'margin-left':e_editor_c.find('select.cfgen-submit-marginleft-select').val()+'px',
													'height':e_editor_c.find('input[type="text"].cfgenwp-element-height-input-value').val()+'px'
													}
										};
				
				var submit_width = e_editor_c.find('input[type="text"].cfgenwp-element-width-input-value').val()+'px';
				
				export_e_set_container['css']['default']['width'] = submit_width; // also set in input type

				export_input_group_container['css']['default']['max-width'] = submit_width; // also set in input type

				export_submit_css['hover'] = {};
				
				// Submit hover color
				var submit_color_hover_input = e_editor_c.find('input[type="text"].cfgenwp-colorpicker-submit-color-hover');
				
				if(submit_color_hover_input.hasClass('cfgenwp-add-to-export')){
					// ^-- we use a class instead of :visible in order to check whether or not we grab the hover value because the input is never visible once we are in the form settings
					
					var submit_color_hover_input_val = submit_color_hover_input.val();
					
					if(submit_color_hover_input_val != export_submit_css['default']['color']){
						export_submit_css['hover']['color'] = submit_color_hover_input_val;
					}
				}

				// Submit hover background-color
				var submit_backgroundcolor_hover_input = e_editor_c.find('input[type="text"].cfgenwp-colorpicker-submit-backgroundcolor-hover');
				
				if(submit_backgroundcolor_hover_input.hasClass('cfgenwp-add-to-export')){
					
					var submit_backgroundcolor_hover_input_val = submit_backgroundcolor_hover_input.val();
					
					if(submit_backgroundcolor_hover_input_val != export_submit_css['default']['background-color']){
						export_submit_css['hover']['background-color'] = submit_backgroundcolor_hover_input_val;
					}
				}
				
				// Submit hover border-color
				var submit_bordercolor_hover_input = e_editor_c.find('input[type="text"].cfgenwp-colorpicker-submit-bordercolor-hover');
				
				if(submit_bordercolor_hover_input.hasClass('cfgenwp-add-to-export')){
					
					var submit_bordercolor_hover_input_val = submit_bordercolor_hover_input.val();
					
					if(submit_bordercolor_hover_input_val != export_submit_css['default']['border-color']){
						export_submit_css['hover']['border-color'] = submit_bordercolor_hover_input_val;
					}
				}
				
				element_obj['submit'] = {'value':e_editor_c.find('input[type="text"].cfgenwp-edit-submit-value').val(), 'css':export_submit_css};

			}
			
			if(type == 'select' || type == 'selectmultiple' || type == 'checkbox' || type == 'radio'){
				
				var export_option_array = [];

				fb_e_c.find('div.cfgenwp-editoption-c').each(function(){
					
					var option_checked = jQuery(this).find('.selected').length ? '1' : '';

					export_option_array.push({
												'id':export_element_id+'-'+jQuery(this).index(),
												'value':jQuery.trim(jQuery(this).find('input[type="text"].cfgenwp-editoption-value').val()),
												'checked':option_checked
												});
				});
			}

			// SAVE CAPTCHA
			if(type == 'captcha'){
				
				element_obj['format'] = fb_e_c.find('.captchaformat:checked').val();
				element_obj['length'] = jQuery('#cfgenwp-captcha-length').val();
				element_obj['form_dir'] = ''; // updated in saveform.php
				element_obj['form_inc_dir'] = ''; // updated in saveform.php

				export_captcha = {
									'id':fb_e_c.data('cfgenwp_element_id'),
									'format':fb_e_c.find('.captchaformat:checked').val(),
									'length':jQuery('#cfgenwp-captcha-length').val()
								 };
			}

			// SAVE DATEPICKER
			if(type == 'date'){
				
				var datepicker_obj = {
									'format':fb_e_c.find('select.cfgenwp-datepicker-format').val(),
									'regional':fb_e_c.find('select.cfgenwp-datepicker-language').val(),
									'firstdayoftheweek':fb_e_c.find('select.cfgenwp-datepicker-firstdayoftheweek').val(),
									'disabledaysoftheweek':[],
									'disablepastdates':false,
									'mindate':false,
									'maxdate':false,
									'yearrange':{},
									'yearrange':{'minus':''},
									'yearrange':{'plus':''}
									};
				
				
				fb_e_c.find('.cfgenwp-date-disabledaysoftheweek:checked').each(function(){
					datepicker_obj['disabledaysoftheweek'].push(parseInt(jQuery(this).val()));
				});
				
				var datepicker_mindate_config = fb_e_c.find('.cfgenwp-date-mindate:checked');
				
				var datepicker_maxdate_config = fb_e_c.find('.cfgenwp-date-maxdate:checked');
				
				// MIN
				if(datepicker_mindate_config.hasClass('cfgenwp-date-mindatecustom')){
					var datepicker_mindate_val = fb_e_c.find('.cfgenwp-date-mindatecustom-v').val();
					if(datepicker_mindate_val){ // prevents datepicker_obj['mindate'] = '' if the user click on the radio button and leave the field empty
						datepicker_obj['mindate'] = datepicker_mindate_val;
					}
				}
				
				if(datepicker_mindate_config.hasClass('cfgenwp-date-yearrange-currentyearminus')){
					datepicker_obj['yearrange']['minus'] = parseInt(fb_e_c.find('.cfgenwp-date-yearrange-currentyearminus-v').val());
				}
				
				if(datepicker_mindate_config.hasClass('cfgenwp-date-disablepastdates')){
					datepicker_obj['disablepastdates'] = true;
				}
				
				// MAX
				if(datepicker_maxdate_config.hasClass('cfgenwp-date-maxdatecustom')){
					var datepicker_maxdate_val = fb_e_c.find('.cfgenwp-date-maxdatecustom-v').val();
					if(datepicker_maxdate_val){ // prevents datepicker_obj['mindate'] = '' if the user click on the radio button and leave the field empty
						datepicker_obj['maxdate'] = datepicker_maxdate_val;
					} 
				}
				
				if(datepicker_maxdate_config.hasClass('cfgenwp-date-yearrange-currentyearplus')){
					datepicker_obj['yearrange']['plus'] = parseInt(fb_e_c.find('.cfgenwp-date-yearrange-currentyearplus-v').val());
				}
				
				// datepicker in the element
				element_obj['datepicker'] = datepicker_obj;
				
				//console.log(datepicker_obj);
				
				export_datepicker_config.push({
												'id':export_element_id, 
												'format':datepicker_obj['format'], 
												'regional':datepicker_obj['regional'], 
												'firstdayoftheweek':datepicker_obj['firstdayoftheweek'],
												'disabledaysoftheweek':datepicker_obj['disabledaysoftheweek'],
												'disablepastdates':datepicker_obj['disablepastdates'],
												'mindate':datepicker_obj['mindate'],
												'maxdate':datepicker_obj['maxdate'],
												'yearrange':datepicker_obj['yearrange']
												});
			}

			// SAVE TERMS AND CONDITIONS
			if(type == 'terms'){
				element_obj['terms'] = {
										'value':e_editor_c.find('textarea.cfgenwp-edit-terms-value').val(),
										'link':jQuery.trim(e_editor_c.find('input[type="text"].cfgenwp-edit-terms-link').val()),
										'css':{'default':{
													'font-family':e_editor_c.find('select.cfgenwp-fontfamily-select').val(),
													'font-weight':e_editor_c.find('select.cfgenwp-fontweight-select').val(),
													'font-style':e_editor_c.find('select.cfgenwp-fontstyle-select').val(),
													'font-size':e_editor_c.find('select.cfgenwp-terms-fontsize-select').val()+'px',
													'color':e_editor_c.find('input[type="text"].cfgenwp-colorpicker-terms-color').val()
													}
												}
										};
			}
			
			// SAVE UPLOAD
			if(type == 'upload'){
				
				var file_types = '';
				
				if(fb_e_c.find('.radio_upload_filetype_all').is(':checked')){
					file_types = '*.*';
				}
				
				if(fb_e_c.find('.radio_upload_filetype_custom').is(':checked')){
					file_types = jQuery.trim(fb_e_c.find('.upload_filetype_custom').val());
				}
				
				var export_upload_element = {
											'id':export_element_id,
											'btn_upload_id':'uploadbutton', // spanButtonPlaceHolder written in class.contactformeditor.php and used in saveform.php;
											'file_size_limit':fb_e_c.find('.upload_filesizelimit').val(),
											'file_size_unit':fb_e_c.find('.upload_filesizeunit:checked').val(),
											'file_types':file_types,
											'upload_deletefile':fb_e_c.find('.upload_deletefile:checked').val(),
											};

				
				element_obj['btn_upload_id'] = export_upload_element['btn_upload_id'];
				element_obj['file_size_limit'] = export_upload_element['file_size_limit'];
				element_obj['file_size_unit'] = export_upload_element['file_size_unit'];
				element_obj['file_types'] = export_upload_element['file_types'];
				element_obj['upload_deletefile'] = export_upload_element['upload_deletefile'];
				
				export_upload_config.push(export_upload_element); // saveform.php
			}

			// SAVE REQUIRED
			if(fb_e_c.cfgen_findRequiredChecked().length || fb_e_c.cfgen_findTermsRequiredChecked().length){
				element_obj['required'] = 1;
			}

			// SAVE SEPARATOR
			if(type == 'separator'){
				
				var export_separator_css_default = {'default':{
																'background-color':e_editor_c.find('input[type="text"].cfgenwp-colorpicker-separator-color').val(),
																'height':e_editor_c.find('select.cfgenwp-separator-height-value').val()+'px'
																}};

				element_obj['separator'] = {'css':export_separator_css_default};
			}

			// SAVE TITLE
			if(type == 'title'){
				
				var export_title_css = {'default':{
													'font-family':export_css_font_family,
													'font-weight':export_css_font_weight,
													'font-style':export_css_font_style,
													'font-size':e_editor_c.find('select.cfgenwp-title-fontsize-select').val()+'px',
													'color':e_editor_c.find('input[type="text"].cfgenwp-colorpicker-title-color').val()
												}};
				
				element_obj['title'] = {'value':e_editor_c.find('input[type="text"].cfgenwp-edit-title-value').val(), 'css':export_title_css};
			}

			// SAVE PARAGRAPH
			var e_editor_paragraph = e_editor_c.find('textarea.cfgenwp-paragraph-edit');
			
			if(e_editor_paragraph.length){
				
				var paragraph_val = e_editor_paragraph.val();

				if(paragraph_val){
					
					paragraph_width_val = parseInt(e_editor_c.find('input[type="text"].cfgenwp-input-paragraph-width-value').val());
					
					// There can be paragraphs with inputs
					var export_paragraph_css_default = {'default':{
																	'font-family':export_css_font_family,
																	'font-weight':export_css_font_weight,
																	'font-style':export_css_font_style,
																	'font-size':e_editor_c.find('select.cfgenwp-paragraph-fontsize-select').val()+'px',
																	'color':e_editor_c.find('input[type="text"].cfgenwp-colorpicker-paragraph-color').val(),
																	'width':paragraph_width_val+'px'
																	}};
														
					element_obj['paragraph'] = {'id':'', 'value':paragraph_val, 'css':export_paragraph_css_default}; // id updated in saveform.php
					
					
					// for other elements, paragraph is pushed in json only if it's not empty
					if(jQuery.inArray(type, [ 'checkbox', 'captcha', 'date', 'email', 'radio', 'select', 'selectmultiple', 'text', 'textarea', 'time', 'upload', 'url' ]) != -1){
						if(e_editor_paragraph.val()){
							element_obj['paragraph'] = {'id':'', 'value':paragraph_val, 'css':export_paragraph_css_default}; // id updated in saveform.php
						}
					}
				}
			}

			// SAVE TIME AMPM
			if(type == 'time'){
				element_obj['timeformat'] = e_editor_c.find('input[type="radio"].cfgenwp-timeformat:checked').val();
			}
			
			// SAVE RATING
			if(type == 'rating'){

				export_rating_config = true;
				
				var export_rating_css = {
										'default':{
													'font-size':jQuery.cfgen_appendPx(e_editor_c.find('select.cfgenwp-rating-fontsize-select').val()),
													'color':e_editor_c.find('input[type="text"].cfgenwp-colorpicker-rating-color').val(),
													'padding-right':jQuery.cfgen_appendPx(e_editor_c.find('select.cfgenwp-rating-paddingright-select').val()),
													},
										'hover':{
												'color':e_editor_c.find('input[type="text"].cfgenwp-colorpicker-rating-color-hover').val()
												}
										};
										
				element_obj['rating'] = {
										'maximum':e_editor_c.find('select.cfgenwp-rating-maximum').val(), 
										'fontawesome_id':e_editor_c.find('select.cfgenwp-rating-icon-select').val(),
										'css':export_rating_css
										};

			}
			
			
			// SAVE ICON, it must comes before saving the input because the input css will be modified by variables set in this section
			if(jQuery.inArray(type, ['captcha', 'date', 'email', 'text', 'url']) != -1){
				
				var select_icon = e_editor_c.find('select.cfgenwp-icon-select');
				var icon_fontawesome_id = select_icon.val();
				
				if(select_icon.length && select_icon.val()){
					
					export_icon_config = true;

					icon_width_val = parseInt(e_editor_c.find('input[type="text"].cfgenwp-icon-width-input-value').val());
					
					var icon_align = e_editor_c.find('input[type="radio"].cfgenwp-icon-align:checked').val();
					
					var icon_obj = {
									'id':'', // id updated in saveform.php
									'type':select_icon.find('option:selected').data('cfgenwp_icon_type'),
									'fontawesome_id':icon_fontawesome_id,
									'align':icon_align,
									'css':{'default':{
														'min-width':icon_width_val+'px',
														'font-size':e_editor_c.find('select.cfgenwp-icon-fontsize-select').val()+'px',
														'color':e_editor_c.find('input[type="text"].cfgenwp-colorpicker-icon-color').val(),
														'background-color':e_editor_c.find('input[type="text"].cfgenwp-colorpicker-icon-backgroundcolor').val(),
														'border-color':e_editor_c.find('input[type="text"].cfgenwp-colorpicker-icon-bordercolor').val(),
														'border-style':'solid',
														'border-top-width':input_border_width_px,
														'border-bottom-width':input_border_width_px
													 }
										  }
									};

					if(icon_align == 'left'){
						icon_obj['css']['default']['border-top-left-radius'] = input_border_radius_px;
						icon_obj['css']['default']['border-bottom-left-radius'] = input_border_radius_px;
						icon_obj['css']['default']['border-left-width'] = input_border_width_px;
						icon_obj['css']['default']['border-right-width'] = '0px';
						
						var export_input_with_icon_css = {
															'border-top-left-radius':'0px',
															'border-bottom-left-radius':'0px',
															'border-top-right-radius':export_css['input']['default']['border-radius'],
															'border-bottom-right-radius':export_css['input']['default']['border-radius']
														 }						
					}
					
					if(icon_align == 'right'){
						
						icon_obj['css']['default']['border-top-right-radius'] = input_border_radius_px;
						icon_obj['css']['default']['border-bottom-right-radius'] = input_border_radius_px;
						icon_obj['css']['default']['border-left-width'] = '0px';
						icon_obj['css']['default']['border-right-width'] = input_border_width_px;

						var export_input_with_icon_css = {
															'border-top-left-radius':export_css['input']['default']['border-radius'],
															'border-bottom-left-radius':export_css['input']['default']['border-radius'],
															'border-top-right-radius':'0px',
															'border-bottom-right-radius':'0px'
														 }
					}
					
					var delete_export_input_css_border_radius = true;

					element_obj['icon'] = icon_obj;
				}
			}
			
			// SAVE INPUT SAVE LABEL
			if(jQuery.inArray(type, ['captcha', 'checkbox', 'date', 'email', 'radio', 'rating', 'select', 'selectmultiple', 'text', 'textarea', 'time', 'upload', 'url']) != -1){
				
				
				// SAVE LABEL CSS
				var export_label_css = {'default':{
													'font-family':export_css['label']['default']['font-family'],
													'font-weight':export_css['label']['default']['font-weight'],
													'font-style':export_css['label']['default']['font-style'],
													'font-size':export_css['label']['default']['font-size'],
													'color':export_css['label']['default']['color'],
													'margin-bottom':export_css['label']['default']['margin-bottom']
													}
										};
				
				var label_alignment_val = e_editor_c.find('input[type="radio"].cfgenwp-label-alignment:checked').val();
				
				if(label_alignment_val == 'left' || label_alignment_val == 'right'){
					
					// Label
					if(type == 'radio' || type == 'checkbox'){
						export_label_css['default']['width'] = e_editor_c.find('input[type="text"].cfgenwp-input-label-width-value').val()+'px';
						export_label_css['default']['display'] = 'table-cell';	
						export_label_css['default']['vertical-align'] = 'top';	
					} else{
						export_label_css['default']['width'] = e_editor_c.find('input[type="text"].cfgenwp-input-label-width-value').val()+'px';
						export_label_css['default']['float'] = 'left';	
					}
					
					export_label_css['default']['text-align'] = label_alignment_val == 'left' ? 'left' : 'right';
					// ^-- the text-align property must be saved because it is used in addEditAlignment php method to precheck the label alignment
					
					// Element set
					if(type == 'radio' || type == 'checkbox'){
						export_e_set_container['css']['default']['display'] = 'table-cell';
					} else{
						export_e_set_container['css']['default']['float'] = 'left';
					}
					
					
					if(jQuery.inArray(type, ['checkbox', 'radio']) != -1){
						/* padding and not margin because of table-cell display */
						export_e_set_container['css']['default']['padding-top'] = e_editor_c.find('select.cfgenwp-option-margintop-select').val()+'px';
					}
				}

				// Placeholder value
				var placeholder_val = jQuery.trim(e_editor_c.find('input[type="text"].cfgenwp-edit-placeholder-value').val());

				// Label value
				var label_val = jQuery.trim(e_editor_c.find('input[type="text"].cfgenwp-edit-label-value').val());
				
				// SAVE LABEL
				element_obj['label'] = {'id':'', 'css':export_label_css}; // id updated in saveform.php
				
				if(label_val){
					element_obj['label']['value'] = label_val;
				}
				
				// SAVE INPUT
				if(jQuery.inArray(type, ['captcha', 'date', 'email', 'select', 'selectmultiple', 'text', 'textarea', 'time', 'url']) != -1){
					
					element_obj['input'] = export_input;
				
					// SAVE PLACEHOLDER
					if(typeof placeholder_val !== 'undefined'){
						element_obj['input']['placeholder'] = placeholder_val;
						
						if(!label_val){
							export_label_css['default']['display'] = 'none';
						}
					}

					
					// SAVE INPUT WIDTH SAVE TEXTAREA HEIGHT
					if(jQuery.inArray(type, ['captcha', 'date', 'email', 'select', 'selectmultiple', 'time', 'text', 'textarea', 'url']) != -1){
						
						var export_input_css = {'default':{
															'padding':export_css['input']['default']['padding'],
															'background-color':export_css['input']['default']['background-color'],
															'font-family':export_css['input']['default']['font-family'],
															'font-weight':export_css['input']['default']['font-weight'],
															'font-style':export_css['input']['default']['font-style'],
															'font-size':export_css['input']['default']['font-size'],
															'color':export_css['input']['default']['color'],
															'border-width':export_css['input']['default']['border-width'],
															'border-style':export_css['input']['default']['border-style'],
															'border-color':export_css['input']['default']['border-color']
															}};
						
						// width
						var e_editor_input_width = e_editor_c.find('input[type="text"].cfgenwp-element-width-input-value');
						
						if(e_editor_input_width.length){

							var input_width_val = parseInt(e_editor_input_width.val());
							
							var icon_width_plus_input_width = icon_width_val + input_width_val;
							
							if(icon_width_plus_input_width < paragraph_width_val){
								var element_set_width = paragraph_width_val;
							} else{
								var element_set_width = icon_width_plus_input_width;
							}

							export_e_set_container['css']['default']['width'] = element_set_width+'px'; // also set in submit type
							
							export_input_group_container['css']['default']['max-width'] = (icon_width_val + input_width_val)+'px'; // also set in submit type
							
							if(typeof icon_align !== 'undefined' && icon_align === 'right'){
								export_input_container['css']['default']['display'] = 'table-cell';
								export_input_container['css']['default']['width'] = '100%';
								export_input_container['css']['default']['vertical-align'] = 'top';
							}
						}
						
						if(type != 'radio' && type != 'checkbox'){
							export_e_set_container['css']['default']['max-width'] = '100%';
						}
						
						// height
						var e_editor_input_height = e_editor_c.find('input[type="text"].cfgenwp-element-height-input-value');
						
						if(e_editor_input_height.length){
							export_input_css['default']['height'] = e_editor_input_height.val()+'px';
						}
					}
					
					if(jQuery.inArray(type, ['captcha', 'date', 'email', 'select', 'time', 'text', 'textarea', 'url']) != -1){
						export_input_css['default']['border-radius'] = export_css['input']['default']['border-radius'];
					}
					
					
					// Apply css changes (border corner radius)on the input if there is an icon
					var export_input_with_icon_css = typeof export_input_with_icon_css !== 'undefined' ? export_input_with_icon_css : '';
					
					if(export_input_with_icon_css){
						for(var key in export_input_with_icon_css){
							if(export_input_with_icon_css.hasOwnProperty(key)){
								export_input_css['default'][key] = export_input_with_icon_css[key];
							}
						}
					}
					
					// Remove the css border-radius property on the input if there is an icon
					var delete_export_input_css_border_radius = typeof delete_export_input_css_border_radius !== 'undefined' ? delete_export_input_css_border_radius : '';
					
					if(delete_export_input_css_border_radius){
						delete export_input_css['default']['border-radius'];
					}
					
					element_obj['input']['css'] = export_input_css;
				}
			}
			
			// SAVE OPTIONS
			if(jQuery.inArray(type, ['checkbox', 'radio', 'select', 'selectmultiple']) != -1){
				
				var export_optioncontainer_css = {'default':{
															'font-family':export_css['input']['default']['font-family'],
															'font-weight':export_css['input']['default']['font-weight'],
															'font-style':export_css['input']['default']['font-style'],
															'font-size':export_css['input']['default']['font-size'],
															'color':export_css['input']['default']['color']
															}};
				
				if(jQuery.inArray(type, ['checkbox', 'radio']) != -1){
					
					if(fb_e_c.find('.cfgenwp-option-alignment[value="left"]:checked').length){
					
						export_optioncontainer_css['default']['width'] = fb_e_c.find('input[type="text"].cfgenwp-input-option-width-value').val()+'px';
						
						export_optioncontainer_css['default']['float'] = 'left';
					}
					
					element_obj['option'] = {'set':export_option_array, 'container':{'id':'', 'css':export_optioncontainer_css}}; // id updated in saveform.php};
				}
				
				if(jQuery.inArray(type, ['select', 'selectmultiple']) != -1){
					element_obj['option'] = {'set':export_option_array};
				}
			}
			
			
			// SAVE IMAGE URL
			var export_imgurl = jQuery.trim(fb_e_c.find('.cfgenwp-image-edit-url').val());
			if(export_imgurl){
				element_obj['url'] = export_imgurl;  // to prevent imgurl = ''
			}
			
			// SAVE IMAGE UPLOAD
			var export_imageuploadfilename = fb_e_c.find('.uploadimagefilename').val();
			if(export_imageuploadfilename){
				
				element_obj['filename'] = fb_e_c.find('.uploadimagefilename').val();
				element_obj['form_dir'] = ''; // updated in saveform.php
				element_obj['form_inc_dir'] = ''; // updated in saveform.php
				
				export_imageupload.push(element_obj['filename']);
			}
			
			
			element_obj['element-set-c'] = export_e_set_container;
			element_obj['input-group-c'] = export_input_group_container;
			element_obj['input-c'] = export_input_container;

			export_element.push(element_obj);	
		});
		
		
		// FORM CONFIG
		json_export['form_id'] = form_id.val();
		json_export['form_name'] = form_config_form_name.val();
		json_export['form_dir'] = ''; // value set in saveform.php, sent through js call to prevent having to create ['form_dir'] with php, which would put the form_dir key at the end of the json array / less easy to find and read
		json_export['config_email_address'] = form_config_email_address.val();
		json_export['config_email_address_cc'] = config_email_address_cc;
		json_export['config_email_address_bcc'] = config_email_address_bcc;
		json_export['config_emailsendingmethod'] = jQuery('#cfgenwp-config-emailsendingmethod').val();		
		json_export['config_smtp_host'] = '';
		json_export['config_smtp_port'] = '';
		json_export['config_smtp_encryption'] = '';
		json_export['config_smtp_username'] = '';
		json_export['config_smtp_password'] = '';
		
		if(json_export['config_emailsendingmethod'] == 'smtp'){
			json_export['config_smtp_host'] = form_config_smtp_host.val();
			json_export['config_smtp_port'] = form_config_smtp_port.val();
			json_export['config_smtp_encryption'] = jQuery('#cfgenwp-smtp-encryption').val();
			json_export['config_smtp_username'] = jQuery('#cfgenwp-smtp-username').val();
			json_export['config_smtp_password'] = jQuery('#cfgenwp-smtp-password').val();
		}

		// SMS ADMIN NOTIFICATION
		var sms_admin_notification_gateway_val = form_config_sms_admin_notification_gateway.val();
		
		if(jQuery.cfgen_smsAdminNotificationIsActivated() && sms_admin_notification_gateway_val){

			json_export['config_sms_admin_notification_to_phone_number'] = jQuery.trim(form_config_sms_admin_notification_to_phone_number.val());
			json_export['config_sms_admin_notification_message'] = jQuery.trim(form_config_sms_admin_notification_message.val());

			if(jQuery.cfgen_smsAdminNotificationGatewayIsClickatell()){
				json_export['config_sms_admin_notification_gateway_id'] = 'clickatell';
				json_export['config_sms_admin_notification_username'] = jQuery.trim(form_config_sms_admin_notification_clickatell_username.val());
				json_export['config_sms_admin_notification_password'] = jQuery.trim(form_config_sms_admin_notification_clickatell_password.val());
				json_export['config_sms_admin_notification_api_id'] = jQuery.trim(form_config_sms_admin_notification_clickatell_api_id.val());
			}

			if(jQuery.cfgen_smsAdminNotificationGatewayIsTwilio()){
				json_export['config_sms_admin_notification_gateway_id'] = 'twilio';
				json_export['config_sms_admin_notification_from_phone_number'] = jQuery.trim(form_config_sms_admin_notification_twilio_from_phone_number.val());
				json_export['config_sms_admin_notification_account_sid'] = jQuery.trim(form_config_sms_admin_notification_twilio_account_sid.val());
				json_export['config_sms_admin_notification_auth_token'] = jQuery.trim(form_config_sms_admin_notification_twilio_auth_token.val());
			}
			
		}

		// SAVE DATABASE BUILDER
		var databasebuilder_fields_c = jQuery('#cfgenwp-database-builder').find('div.cfgenwp-database-builder-table-item-c');

		if(jQuery.cfgen_databaseIsActivated()){

			json_export['config_database_host'] = jQuery.trim(form_config_database_host.val());
			json_export['config_database_name'] = jQuery.trim(form_config_database_name.val());
			json_export['config_database_login'] = jQuery.trim(form_config_database_login.val());
			json_export['config_database_password'] = jQuery.trim(form_config_database_password.val());
			json_export['config_database_table'] = jQuery.trim(form_config_database_table.val());
			json_export['config_database_table_charset'] = jQuery('#cfgenwp-database-table-charset').val();
			
			json_export['config_database_table_fields'] = [];
			
			databasebuilder_fields_c.each(function(){
				
				var c = jQuery(this);
				
				var item_type = c.data('cfgenwp_database_item_type');
				var table_field_id = jQuery.trim(c.find('input[type="text"].cfgenwp-database-builder-table-field-id').val());
				
				if(item_type == 'element'){
					var database_item = {
										 'element_id':c.data('cfgenwp_database_form_e_id'), 
										 'table_field_default_value':c.find('input[type="checkbox"].cfgenwp-database-builder-table-field-default-value:checked').length ? 'NULL' : false
										};
				}
				
				if(item_type == 'preset'){
					var database_item = {
										 'preset_id':c.data('cfgenwp_database_item_preset_id'), 
										 'table_field_default_value':c.find('input[type="checkbox"].cfgenwp-database-builder-table-field-default-value:checked').length ? 'NULL' : false
										};
				}
				
				database_item['item_type'] = item_type;
				database_item['table_field_id'] = table_field_id;
				
				json_export['config_database_table_fields'].push(database_item);

			});
		}
		
		json_export['config_timezone'] = jQuery('#cfgenwp-config-timezone').val();
		json_export['config_redirecturl'] = saveform_config_redirecturl_val;
		json_export['config_validationmessage'] = config_validationmessage;
		
		json_export['config_errormessage_captcha'] = form_editor.find('img.cfgen-captcha-img').length ? jQuery('#cfgenwp-form-error-msg-captcha-value').val() : '';
		json_export['config_errormessage_emptyfield'] = form_editor.cfgen_findRequiredChecked().length ? jQuery('#cfgenwp-form-error-msg-required-value').val() : '';
		json_export['config_errormessage_invalidemailaddress'] = form_editor.find('input[type="text"].cfgen-type-email').length ? jQuery('#cfgenwp-form-error-msg-email-value').val() : '';
		json_export['config_errormessage_invalidurl'] = form_editor.find('input[type="text"].cfgen-type-url').length ? jQuery('#cfgenwp-form-error-msg-url-value').val() : '';
		json_export['config_errormessage_uploadfileistoobig'] = '';
		json_export['config_errormessage_uploadinvalidfiletype'] = '';
		json_export['config_errormessage_terms'] = form_editor.cfgen_findTermsRequiredChecked().length ? jQuery('#cfgenwp-form-error-msg-terms-value').val() : '';
		
		
		if(jQuery('div.replace_upload_field').length){
			json_export['config_errormessage_uploadfileistoobig'] = jQuery('#cfgenwp-form-error-msg-uploadfilesize-value').val();
			json_export['config_errormessage_uploadinvalidfiletype'] = jQuery('#cfgenwp-form-error-msg-uploadfiletype-value').val();
		}
		
		
		json_export['config_adminnotification_subject'] = form_config_admin_notification_subject.val();
		json_export['config_adminnotification_hideemptyvalues'] = jQuery('#cfgenwp-config-admin-notification-hideemptyvalues').is(':checked') ? true :false;
		json_export['config_adminnotification_hideformurl'] = jQuery('#cfgenwp-config-admin-notification-hideformurl').is(':checked') ? true : false;
		
		json_export['config_email_from'] = ''; // default value to prevent Undefined index
		json_export['config_usernotification_activate'] = false; // default value to prevent Undefined index
		json_export['config_usernotification_insertformdata'] = false; // default value to prevent Undefined index
		json_export['config_usernotification_inputid'] = jQuery('#cfgenwp_config_usernotification_inputid').val() ? jQuery('#cfgenwp_config_usernotification_inputid').val() : '';
		json_export['config_usernotification_format'] = ''; // default value to prevent Undefined index
		json_export['config_usernotification_subject'] = ''; // default value to prevent Undefined index
		json_export['config_usernotification_message'] = ''; // default value to prevent Undefined index
		json_export['config_usernotification_hideemptyvalues'] = false;


		
		if(form_config_user_notification_activate.is(':checked') && jQuery('#cfgenwp_config_usernotification_inputid').val()){
			json_export['config_usernotification_activate'] = true;
			json_export['config_usernotification_insertformdata'] = form_config_user_notification_insertformdata.is(':checked') ? true : false;
			json_export['config_email_from'] = form_config_email_from.val();
			json_export['config_usernotification_format'] = jQuery('input[type="radio"][name=cfgenwp-config-user-notification-format]:checked').val();
			json_export['config_usernotification_subject'] = jQuery('#cfgenwp-config-user-notification-subject').val();
			json_export['config_usernotification_message'] = form_config_user_notification_message.val();
			json_export['config_usernotification_hideemptyvalues'] = jQuery('#cfgenwp-config-user-notification-hideemptyvalues').is(':checked') ? true :false;			
		}

		// FORM VALIDATION EMAIL
		var export_formvalidation_email = [];
		form_editor.find('input[type="text"].cfgen-type-email').each(function(){
			export_formvalidation_email.push(jQuery(this).cfgen_closestFbElementCont().data('cfgenwp_element_id'));
		});

		// FORM VALIDATION URL
		var export_formvalidation_url = [];
		form_editor.find('input[type="text"].cfgen-type-url').each(function(){
			export_formvalidation_url.push(jQuery(this).cfgen_closestFbElementCont().data('cfgenwp_element_id'));
		});

		// FORM VALIDATION TERMS
		var export_formvalidation_terms = [];
		form_editor.cfgen_findTermsRequiredChecked().each(function(){
			export_formvalidation_terms.push(jQuery(this).cfgen_closestFbElementCont().data('cfgenwp_element_id'));
		});

		// FORM VALIDATION REQUIRED
		var export_formvalidation_required = [];
		form_editor.cfgen_findRequiredChecked().each(function(){
			export_formvalidation_required.push(jQuery(this).cfgen_closestFbElementCont().data('cfgenwp_element_id'));
		});
		
		json_export['formvalidation_email'] = export_formvalidation_email;
		json_export['formvalidation_required'] = export_formvalidation_required;
		json_export['formvalidation_terms'] = export_formvalidation_terms;
		json_export['formvalidation_url'] = export_formvalidation_url;
		
		json_export['imageupload'] = export_imageupload;
		json_export['upload'] = export_upload_config; // saveform.php
		json_export['datepicker'] = export_datepicker_config; // saveform.php
		json_export['icon'] = export_icon_config; // flag used to decide whether we include the fontawesome css or not, this flag is not used in the form builder and is unset in saveform.php
		json_export['rating'] = export_rating_config; // flag used to decide whether we include the fontawesome css or not, this flag is not used in the form builder and is unset in saveform.php
		
		json_export['googlewebfonts'] = [];
		for(var gwf_k in cfgenwp_export_googlewebfonts){
			json_export['googlewebfonts'].push({'family':gwf_k, 'variants':cfgenwp_export_googlewebfonts[gwf_k]});
		}
		
		json_export['captcha'] = export_captcha; // saveform.php
		json_export['element'] = export_element;
		json_export['css'] = export_css;


		json_export['api'] = {};
		
		var api_error_message = '';
		
		// FOREACH API CONTAINER
		form_settings.find('.cfgenwp-editor-api-c').each(function(){
			
			var api = {};
			
			var api_container = jQuery(this);
			
			var api_id = api_container.data('cfgenwp_api_id');
			
			var api_name = api_container.data('cfgenwp_api_name');
			
			var apikey = jQuery.trim(api_container.find('.cfgenwp-api-apikey').val());
			
			var api_username = jQuery.trim(api_container.find('.cfgenwp-api-username').val());
			
			var api_password = jQuery.trim(api_container.find('.cfgenwp-api-password').val());
			
			var api_applicationpassword = jQuery.trim(api_container.find('.cfgenwp-api-applicationpassword').val());
			
			var api_accesstoken = jQuery.trim(api_container.find('.cfgenwp-api-accesstoken').val());
			
			var api_authorizationcode = jQuery.trim(api_container.find('.cfgenwp-api-authorizationcode').val());
			
			
			var insert_api_in_json = false;
			
			if(api_id == 'campaignmonitor' || api_id == 'getresponse' || api_id == 'mailchimp'){
				api['apikey'] = apikey;
			}

			if(api_id == 'aweber'){
				api['consumerkey'] = api_container.data('cfgenwp_api_consumerkey');
				api['consumersecret'] = api_container.data('cfgenwp_api_consumersecret');
				api['accesstokenkey'] = api_container.data('cfgenwp_api_accesstokenkey');
				api['accesstokensecret'] = api_container.data('cfgenwp_api_accesstokensecret');
			}

			if(api_id == 'salesforce'){
				
				api['username'] = api_username;
				api['password'] = api_password;
				api['accesstoken'] = api_accesstoken;
			}

			if(api_id == 'icontact'){
				
				api['username'] = api_username;
				api['applicationpassword'] = api_applicationpassword;
			}

			if(api_id == 'constantcontact'){
				
				api['apikey'] = apikey;
				api['accesstoken'] = api_accesstoken;
			}

			api['accounts'] = [];

			// FOREACH ACCOUNT CONTAINER
			api_container.find('.cfgenwp-api-account-container').each(function(){

				var account_container = jQuery(this);

				var account_id = account_container.data('cfgenwp_api_account_id');

				var account = {};

				account['account_id'] = account_id;
				
				account['lists'] = [];


				// FOREACH LIST CONTAINER CHECKED
				account_container.find('.cfgenwp-integrate-list:checked').each(function(){
					
					var list_container = jQuery(this).closest('div.cfgenwp-api-list-c');
					
					var list_name = list_container.data('cfgenwp_api_list_name');
					
					var list = {};

					list['list_id'] = list_container.data('cfgenwp_api_list_id');
				
					list['doubleoptin'] = list_container.find('.cfgenwp-api-list-doubleoptin:checked').length ? true : false;
				
					list['updateexistingcontact'] = list_container.find('.cfgenwp-api-list-updateexistingcontact:checked').length ? true : false;
					
					list['sendwelcomeemail'] = list_container.find('.cfgenwp-api-list-sendwelcomeemail:checked').length ? true : false;
					
					list['preventduplicates'] = list_container.find('.cfgenwp-api-list-preventduplicates:checked').length ? true : false;
					
					
					if(api_id == 'salesforce'){
						
						list['filterduplicates'] = [];
						
						var list_check_error = {}; // only used for api error message
						list_check_error['filterduplicates'] = []; // only used for api error message
						
						list_container.find('.cfgenwp-api-filterduplicates-field-id option:selected').each(function(){
							
							var field = {};
							
							field['list_field_id'] = jQuery(this).val();
							
							// only used for api error message
							field['list_field_label'] = jQuery(this).text();
							
							// only used for api error message
							field['element_id'] = list_container.find('select[data-cfgenwp_api_list_field_id='+field['list_field_id']+']').val();

							list['filterduplicates'].push(field['list_field_id']);
							
							list_check_error['filterduplicates'].push(field);
						});
						
						if((list['preventduplicates'] || list['updateexistingcontact']) && !list['filterduplicates'].length){

							api_error_message = api_name+' error: you must select at least one list field that can be used ';
							if(list['preventduplicates']){
								api_error_message += 'to prevent duplicate records';
							}
							if(list['preventduplicates'] && list['updateexistingcontact']){
								api_error_message += ' and ';
							}

							if(list['updateexistingcontact']){
								api_error_message += 'to find and update existing contacts';
							}
							
							api_error_message += ' in the list "'+list_name+'".';
							
						}
						//console.log(list['filterduplicates']);
						if(list['filterduplicates'].length){
							jQuery.each(list_check_error['filterduplicates'], function(index, value){
								if(!value['element_id']){
									api_error_message = api_name+' error: one of the fields you have selected to prevent duplicates or to find and update existing contacts in the list "'+list_name+'" has no form field associated with it. ';
									api_error_message += 'You must associate one form field with the list field "'+value['list_field_label']+'" in the list "'+list_name+'".';
									return false;
								}
							});
							
						}

						if(api_error_message){
							return false;
						}
					}
					
					// FOREACH LIST FIELD CONTAINER
					list['fields'] = [];

					list_container.find('.cfgenwp-api-list-field-c').each(function(){

						var field = {};

						var api_form_element = jQuery(this).find('.cfgenwp-api-form-element-id');
						
						var api_list_field_id = api_form_element.data('cfgenwp_api_list_field_id');
						
						var api_list_field_required = api_form_element.data('cfgenwp_api_list_field_required');
						
						var api_list_field_name = api_form_element.data('cfgenwp_api_list_field_name');
						
						var api_form_element_id = api_form_element.val();
						//console.log(api_form_element_id);

						if(api_form_element_id){ // an element is selected for the list field
							field['element_id'] = api_form_element_id;

							field['list_field_id'] = api_list_field_id;

							list['fields'].push(field);
							
							insert_api_in_json = true; // There must be at least one form element assigned to a field of the current list to push the api config
						}
						
						
						if(api_list_field_required && !api_form_element_id){
							api_error_message = api_name+' error: there is a required field in the list "'+list_name+'" that has no form field associated with it. ';
							api_error_message += 'You must associate one form field with the list field "'+api_list_field_name+'" in the list "'+list_name+'".';
							
							// no return false here in order to prevent false positive on !list['fields'].length error message
							// happens if the first field is mandatory and is left empty: return false after the first element, hence empty list['fields'] array, even if fields below the first one are not empty
							// we let list['fields'] being populated and a check for api_error_message is set after the each loop
						}
						
					}); // foreach list field container

					if(!list['fields'].length){
						api_error_message = api_name+' error: you must associate at least one form field with the list "'+list_name+'" to activate '+api_name+' properly.';
					}
					
					if(api_error_message){
						return false;
					}


					if(api_id == 'constantcontact' || api_id == 'icontact'){
						list['groups'] = [];
						
						list_container.find('.cfgenwp-api-list-groups-container .cfgenwp-api-list-group:checked').each(function(){
							list['groups'].push(jQuery(this).val());
						});
						
						if(api_id == 'constantcontact' && !list['groups'].length){
							api_error_message = api_name+' error: you must select at least one list in the email lists management section.';
							return false;
						}
					}
					
					if(api_id == 'mailchimp'){

						list['groupings'] = [];

						// GROUPINGS
						list_container.find('.cfgenwp-api-list-grouping-container').each(function(){

							var grouping_container = jQuery(this);

							var grouping = {};

							var grouping_id = grouping_container.data('cfgenwp_api_list_grouping_id');

							var grouping_type = grouping_container.data('cfgenwp_api_list_grouping_type');

							grouping['grouping_id'] = grouping_id;

							grouping['groups'] = [];

							if(grouping_type == 'dropdown'){
								var groups_val = grouping_container.find('.cfgenwp-api-list-group').val();

								if(groups_val){
									grouping['groups'].push(groups_val);
								}
							} // if dropdown

							if(grouping_type == 'checkboxes' || grouping_type == 'radio'){

								grouping_container.find('.cfgenwp-api-list-group:checked').each(function(){
									var groups_val = jQuery(this).val();
									
									if(groups_val){
										grouping['groups'].push(groups_val);
									}
								});

							} // if checkboxes ||radio
							
							if(grouping['groups'].length){// prevents php Notice undefined index errors in apigetlists when groups is empty (no JSON.stringify on api ajax load, empty js array groups won't be exist in php)
								list['groupings'].push(grouping);
							}

						}); // foreach groupings

					} // if mailchimp
					
					account['lists'].push(list);
					
				}); // foreach list checked container

				api['accounts'].push(account);

			}); // foreach account container
			
			
			if(insert_api_in_json){
				json_export['api'][api_id] = api;
			}

		}); // foreach api container
		
		if(api_error_message){
			cfgenwp_dialog_box.html('<p>'+api_error_message+'</p>').dialog(cfgenwp_dialog_error);
			
			notice_savingform.hide();
			saveform_btn.show();
			returntoformedition_btn.show();
			
			return false;
		}
		
		// console.log(JSON.stringify(json_export['api']));
		
		post_json_export = JSON.stringify(json_export); // convert the object in a json string, also keeps the empty objects in json_export (would not be there in a POST php array generated through a js object)
		
		// console.log(post_json_export);

		var jqxhr_saveform = jQuery.post('inc/saveform.php',
			   	{


					'json_export':post_json_export,
					'cf_f':jQuery('#copyright-header:visible').html()
				},
				function(data)
				{	

			   		// console.log(data);
					
					var json_response = jQuery.parseJSON(data);
					
					if(!jQuery.isEmptyObject(json_response['error'])){
						var response_error = json_response['error'];
						cfgenwp_dialog_box.html('<p>'+response_error['error_message']+'</p>').dialog(cfgenwp_dialog_error);
					}
					else{
						
						// no form id in demo mode, the button value must remain "save and create"
						json_response['form_id'] ? saveform_btn.html(saveform_btn_update) : saveform_btn.html(saveform_btn_add);
						
					    aftersave_cs.show();
						
						jQuery('#downloadsources').append(json_response['response']).slideDown('fast');

						loadformdata_c.html(json_export['form_name']);

						form_id.val(json_response['form_id']);
					}
					
					saveform_btn.show();
					
					returntoformedition_btn.show();
					
					notice_savingform.hide();
				
				}).fail(function(){
					
					//console.log(jqxhr_saveform);
					
					if(jqxhr_saveform.status && jqxhr_saveform.status == 500){
						
						saveform_btn.show();
						
						returntoformedition_btn.show();
						
						notice_savingform.hide();
						
						var cfg_php_safe_mode_error_message = '<br><br>The PHP Safe Mode is activated on your server. You must disable the Safe Mode and set the PHP safe_mode option to Off on your server in order to be able to create your forms properly.';
						
						var status_error_message = '500 Internal Server Error :<br>The server encountered an internal error or misconfiguration and was unable to complete your request.';
						
						var status_error_source = '';
						
						if(cfg_php_safe_mode){
							status_error_message += cfg_php_safe_mode_error_message;
							status_error_source = 1;
						}
						
						if(!status_error_source){
							status_error_message += '<br><br>Something has gone wrong on the server but the script wasn\'t able to idenfity why it is not working properly.';
							status_error_message += '<br><br>Contact us at support@topstudiodev.com so that we can help you identify what the exact problem is.';
							status_error_message += '<br><br>We will get back to you in less than 24 hours.';
						}
						
						cfgenwp_dialog_box.html('<p>'+status_error_message+'</p>').dialog(cfgenwp_dialog_error);		
					}
				});

	})

	form_settings.find('.cfgenwp-formmessage-toggle-changeformat').click(function(){
	
		var target = jQuery(this).closest('div.cfgenwp-formconfig-r').find('.cfgenwp-formmessage-changeformat-container');
		target.is(':visible') ? target.slideUp(100) : target.slideDown(100);
	});	
	
	// DOWNLOAD DEMO
	jQuery('body').on('click', '.demodownload', function(){
		
		cfgenwp_dialog_box.html('<p>You are currently using a demo version of Contact Form Generator.</p><p>The download feature is only available in the full version.</p><p>You can use the "<strong>View your form</strong>" button to see what your form looks like.</p>').dialog({autoOpen: true, title: 'Demo - Download sources', buttons: {OK: function(){jQuery(this).dialog('close');}}});		
	});
	
	
	function buildExportGoogleWebFonts(gwf_family, gfw_fontweight, gfw_fontstyle){

		if(!(gwf_family in cfgenwp_export_googlewebfonts)){
			cfgenwp_export_googlewebfonts[gwf_family] = [];
		}
	
		var gwf_variant = cfgenwp_buildGwfVariant(gfw_fontweight, gfw_fontstyle);

		if(jQuery.inArray(gwf_variant, cfgenwp_export_googlewebfonts[gwf_family]) == -1){
			cfgenwp_export_googlewebfonts[gwf_family].push(gwf_variant);
		}
	}
	
	// Build google web font variant for export (300, 300italic, etc.)
	function cfgenwp_buildGwfVariant(gfw_fontweight, gfw_fontstyle){
		
		// string, not integer
		if(gfw_fontweight == 'normal'){	gfw_fontweight = '400';	}
		
		// string, not integer
		if(gfw_fontweight == 'bold'){ gfw_fontweight = '700'; }
		
		// "300"
		var gwf_variant = gfw_fontweight;
		
		// "300italic"
		if(gfw_fontstyle == 'italic'){	gwf_variant = gwf_variant+gfw_fontstyle; }

		return gwf_variant;
	}
	
	
	function cfgenwp_getGoogleWebFontsUrl(font_family){
		var googleapi_font_family_url = font_family.replace(/ /g, '+');
		return (('https:' == document.location.protocol ? 'https://' : 'http://')+'fonts.googleapis.com/css?family='+googleapi_font_family_url+':'+cfgenwp_js_gwf_variants_url_param);
	}

	
	jQuery.fn.cfgen_updateFontProperty = function(target, css_properties){
		
		//console.log('cfgenwp_updateFontProperty '+jQuery(this).attr('class'));
		
		var s = jQuery(this);
		
		var object_type = s.data('cfgenwp_object_type');
		
		for(var css_property in css_properties){
		
			if(css_properties.hasOwnProperty(css_property)){
			   
				if(css_property == 'font-family' && s.cfgen_isGoogleWebFont()){
					
					if(jQuery.inArray(css_properties[css_property], cfgenwp_googlewebfonts_added) == -1){
						
						cfgenwp_googlewebfonts_added.push(css_properties[css_property]);
				
						jQuery('body').append("<link href='"+cfgenwp_getGoogleWebFontsUrl(css_properties[css_property])+"' rel='stylesheet' type='text/css'>");
						// don't use jQuery.get or jQuery load => Origin http://127.0.0.1 is not allowed by Access-Control-Allow-Origin.
						
					}
				}
				
				if(css_property == 'font-size'){
					css_properties[css_property] = jQuery.cfgen_appendPx(css_properties[css_property]);
				}
				
				target.css(css_property, css_properties[css_property]);


				if(
					/*(css_property == 'font-size' || css_property == 'font-weight' || css_property == 'font-style' )*/
					// ^-- height resizing is applied on all three and font-family
					object_type != 'formmessagevalidation' && object_type != 'formmessageerror'){
					/**
					 * Check on object_type to prevent the element container height from being resized when using the font size slider in the form message styling containers
					 * As the element containers are not visible, innerHeight() would return 0 and the elements containers height would not be resized properly
					 */
					//console.log('? ADJUST');
					
					// each on target because target may include multiple elements (labels, inputs, titles...)
					target.each(function(){

						var fb_e_c = jQuery(this).cfgen_closestFbElementCont();
					
						if(!fb_e_c.find('.cfgenwp-e-editor-panel').is(':visible')){
							fb_e_c.css({'height':parseInt(fb_e_c.cfgen_findElementCont().innerHeight())});
							//console.log(fb_e_c.data('cfgenwp_element_id')+' NO ADJUST'+parseInt(fb_e_c.cfgen_findElementCont().innerHeight()));
							
						} else{
							//console.log('AAAAAA');
							
							if(parseInt(fb_e_c.cfgen_findElementCont().innerHeight()) + 20 > fb_e_c.innerHeight()){
								//	console.log('UUUUU');
								fb_e_c.css({'height':parseInt(fb_e_c.cfgen_findElementCont().innerHeight())});
							
							} else{
								fb_e_c.css({'height':parseInt(fb_e_c.cfgen_findElementEditorCont().innerHeight())});
								//console.log('VVVVVVV');
							}
						}
					});
				}
			}
		}
		
		// ICON HEIGHT AFTER FONT CHANGE
		if(object_type == 'input'){
			adjustIconToFontEditor(target);
		}
	}
	
	function adjustIconToFontEditor(target){

		var icon_c = target.cfgen_closestElementCont().cfgen_findElementIconCont();
		
		setTimeout(function(){
		
					var input_collection = form_editor.find('input[type="text"].cfgen-form-value, select.cfgen-form-value, textarea.cfgen-form-value');

					input_collection.each(function(){
						
						var input = jQuery(this);
						
						var icon_c = input.cfgen_closestElementCont().cfgen_findElementIconCont();
					
						if(icon_c.length){
							icon_c.cfgen_iconContAdjustRecurs();
						}			
						
					});
				}, 400); // The timeout must not be too low so that cfgen_iconContAdjustRecurs can have the time to execute entirely
	}
	
	// FONT FAMILY, FONT WEIGHT, FONT STYLE (keyup: for keyboard arrows)
	jQuery('#cfgenwp-formbuilder-container').on('keyup change', 'select.cfgenwp-fontfamily-select, select.cfgenwp-fontweight-select, select.cfgenwp-fontstyle-select', function(e){
		
		/*
		keyup filter based on keyCode is not reliable: 
		on firefox, the keyup event is detected before the change event. Therefore false is returned as soon as a key is pressed (a letter for example)
		on chrome, the change event is detected before the keyup event. It does work even a key is pressed (a letter for example), which would put the focus on the first option matching with the key pressed
		
		console.log('e.type '+e.type);
		if(e.type == 'keyup'){
			if(e.keyCode != 38 && e.keyCode != 40){
				console.log('e.keydown stop '+e.keydown);
				return false;
			}		
		}
		*/
		
		var s = jQuery(this);
		var editproperties_c = s.cfgen_closestElementPropertiesCont();
		
		if(s.hasClass('cfgenwp-fontfamily-select')){
			var fontfamily_s = jQuery(this);
			var is_fontfamily = true;
			var css_property = 'font-family';
		} else{
			var fontfamily_s = editproperties_c.find('select.cfgenwp-fontfamily-select');
			var is_fontfamily = false;
		}
		
		if(s.hasClass('cfgenwp-fontweight-select')){
			var fontweight_s = jQuery(this);
			var is_fontweight = true;
			var css_property = 'font-weight';
		} else{
			var fontweight_s = editproperties_c.find('select.cfgenwp-fontweight-select');
			var is_fontweight = false;
		}
		
		if(s.hasClass('cfgenwp-fontstyle-select')){
			var fontstyle_s = jQuery(this);
			var is_fontstyle = true;
			var css_property = 'font-style';
		} else{
			var fontstyle_s = editproperties_c.find('select.cfgenwp-fontstyle-select');
			var is_fontstyle = false;
		}

		var fontfamily_v = fontfamily_s.val();
		var fontweight_v = fontweight_s.val();
		var fontstyle_v = fontstyle_s.val();
		var css_value = s.val();
		var e_c = s.cfgen_findElementContThroughFbElementCont();
		var target = '';
		
		var applytoall = s.data('cfgenwp_applytoall') ? true : false;
		
		var object_type = s.data('cfgenwp_object_type');
		
		if(object_type == 'input'){
			target = form_editor.find('.cfgenwp-formelement');
		}
		
		if(object_type == 'label'){
			target = form_editor.find('label.cfgen-label');
		}
		
		if(object_type == 'terms'){
			target = form_editor.find('div.cfgen-terms label');
		}
		
		if(object_type == 'formmessagevalidation'){
			target = jQuery('#cfgenwp-formmessage-validation-preview');
		}
		
		if(object_type == 'formmessageerror'){
			target = jQuery('#cfgenwp-formmessage-error-preview');
		}
		
		if(object_type == 'title'){
			target = applytoall ? form_editor.find('div.cfgen-title') : e_c.find('div.cfgen-title');
			var applytoall_target = jQuery('div.cfgenwp-fb-element-c[data-cfgenwp_element_type='+object_type+']');
		}
		
		if(object_type == 'paragraph'){
			target = applytoall ? form_editor.find('div.cfgen-paragraph') : e_c.find('div.cfgen-paragraph');
			var applytoall_target = jQuery('.cfgenwp-e-editparagraph-c');
		}
		
		/*
		console.log('object_type =>'+object_type);
		console.log('target =>'+target);
		console.log('applytoall_target =>'+applytoall_target);
		*/

		if(is_fontstyle){
			
			jQuery.cfgen_setCssPropertyValue(object_type, 'font-style', css_value);
			
			var cssproperty_select_collection = [];
			cssproperty_select_collection.push(fontstyle_s);
			
			if(e.originalEvent && applytoall && (object_type == 'title' || object_type == 'paragraph')){
			
				// console.log('APPLY TO ALL FROM FONT STYLE');
				
				jQuery.cfgen_setCssPropertyValue(object_type, 'font-family', fontfamily_v);
				jQuery.cfgen_setCssPropertyValue(object_type, 'font-weight', fontweight_v);
				
				var applytoall_t_fontstyle_s = applytoall_target.find('select.cfgenwp-fontstyle-select');
				
				applytoall_t_fontstyle_s.val(css_value).data('cfgenwp_fontfamily_selected', fontfamily_v);
			
				applytoall_target.find('select.cfgenwp-fontfamily-select').val(fontfamily_v);
				// ^-- do not set data cfgenwp_fontfamily_selected here because the "!=" comparison would inevitably fail and the options would not be reloaded
				// the update of the data attribute is made at the end of the loop
				applytoall_target.find('select.cfgenwp-fontweight-select').val(fontweight_v);
				
				s.cfgen_updateFontProperty(target, {'font-family':fontfamily_v, 'font-weight':fontweight_v});
				
				applytoall_t_fontstyle_s.each(function(){
					cssproperty_select_collection.push(jQuery(this));
				});
			}
			
			// console.log("\r\n"+'COLLECTION TOTAL FROM [fontStyle] : '+cssproperty_select_collection.length);
			
			jQuery.each(cssproperty_select_collection, function(index, collected_obj){
			
				var fontstyle_s_loop = collected_obj;
					
				var editproperties_c_loop = fontstyle_s_loop.cfgen_closestElementPropertiesCont();
				
				var fontfamily_s_loop = editproperties_c_loop.find('select.cfgenwp-fontfamily-select');
				
				var fontweight_s_loop = editproperties_c_loop.find('select.cfgenwp-fontweight-select');
				
				/*
				if(fontfamily_s_loop.data('cfgenwp_fontfamily_selected') != fontstyle_s_loop.data('cfgenwp_fontfamily_selected')){
				}
				// ^-- this statement prevents from reloading / filtering all the font weight options when the font family has not changed
				// X no : font style options depends on font weight, not font family
				*/
				
				//console.log('[fontStyle] '+fontfamily_s_loop.data('cfgenwp_fontfamily_selected') +' != '+fontstyle_s_loop.data('cfgenwp_fontfamily_selected'));

				var googlewebfonts_variants = fontfamily_s_loop.find('option:selected').data('cfgenwp_font_variants');
	
				var fontfamily_v = fontfamily_s_loop.val();
				
				fontstyle_s_loop.empty().append(cfgenwp_html_fontstyle_options);
				
				var fontstyle_to_apply = '';
				
				fontstyle_s_loop.find('option').each(function(){
					
					var o = jQuery(this);
					
					o_v = o.prop('value');
					
					if(o_v == 'normal'){o_v = 'regular';}
					
					if(o_v == 'bold'){o_v = '700';}// string, not integer

					if(o_v == 'italic'){
					
						if(o_v == 'regular' || o_v == '400'){
							var pattern = 'italic';
						} else{
							var pattern = o_v+'italic';
						}
					}

					// console.log('fontStyle = '+o_v+', search '+o_v+' in '+googlewebfonts_variants);					
					
					if(o_v != 'regular'){
					
						var fontweightitalic = (fontweight_s_loop.val() == 'bold') ? '700' : fontweight_s_loop.val();
						fontweightitalic = fontweightitalic + o_v;
						//console.log('search : '+fontweightitalic);
					
						// this condition has been added because of Open Sans Condensed: regular does not exist but 700 does, therefore "normal" font style should be available for 700
						if(jQuery.inArray(o_v, googlewebfonts_variants) == -1 && jQuery.inArray(fontweightitalic, googlewebfonts_variants) == -1){
							// statement is applied if italic and 300italic (300 is an example) are not in googlewebfonts_variants
							// the condition for 300italic has been added because of Open Sans Condensed: italic does not exist but 300italic does
							//console.log('delete option '+o_v);
							o.remove();
						}
					}
					
					if(o_v == 'regular' && googlewebfonts_variants.length == 1 && googlewebfonts_variants[0] == 'italic'){
						// This if statement was added for Molle
						// Molle includes italic only, "Normal" must be removed from the font style dropdown
						o.remove();
					}
					
				});
			
			
				fontstyle_s_loop.data('cfgenwp_fontfamily_selected', fontfamily_v); // used for comparison "!=" above
				
				fontfamily_s_loop.data('cfgenwp_fontfamily_selected', fontfamily_v); // used for comparison "!=" above
				
				fontstyle_s_loop.find('option[value='+fontstyle_v+']').prop('selected', true);

			});
			
			// using fontstyle_s.val(): we get the option automatically set after the options cleaning
			s.cfgen_updateFontProperty(target, {'font-style':fontstyle_s.val()});
		}
		
		if(is_fontweight){
			
			jQuery.cfgen_setCssPropertyValue(object_type, 'font-weight', css_value);
			
			var cssproperty_select_collection = [];
			cssproperty_select_collection.push(fontweight_s);
			
			if(e.originalEvent && applytoall && (object_type == 'title' || object_type == 'paragraph')){
			
				// console.log('APPLY TO ALL FROM FONT WEIGHT');
				
				jQuery.cfgen_setCssPropertyValue(object_type, 'font-family', fontfamily_v);
				jQuery.cfgen_setCssPropertyValue(object_type, 'font-style', fontstyle_v);
				
				var applytoall_t_fontweight_s = applytoall_target.find('select.cfgenwp-fontweight-select');
				
				applytoall_t_fontweight_s.val(css_value).data('cfgenwp_fontfamily_selected', fontfamily_v);
			
				applytoall_target.find('select.cfgenwp-fontfamily-select').val(fontfamily_v);
				// ^-- do not set data cfgenwp_fontfamily_selected here because the "!=" comparison would inevitably fail and the options would not be reloaded
				// the update of the data attribute is made at the end of the loop
				applytoall_target.find('select.cfgenwp-fontstyle-select').val(fontstyle_v);

				s.cfgen_updateFontProperty(target, {'font-family':fontfamily_v, 'font-style':fontstyle_v});
				
				applytoall_t_fontweight_s.each(function(){
					cssproperty_select_collection.push(jQuery(this));
				});
				
			}
			
			// console.log("\r\n"+'COLLECTION TOTAL FROM [fontWeight] : '+cssproperty_select_collection.length);

			jQuery.each(cssproperty_select_collection, function(index, collected_obj){
				
				var fontweight_s_loop = collected_obj;
				
				var editproperties_c_loop = fontweight_s_loop.cfgen_closestElementPropertiesCont();
				
				var fontfamily_s_loop = editproperties_c_loop.find('select.cfgenwp-fontfamily-select');
			
				//console.log('[fontWeight] '+fontfamily_s_loop.data('cfgenwp_fontfamily_selected') +' ?= '+fontweight_s_loop.data('cfgenwp_fontfamily_selected'));
				
				if(fontfamily_s_loop.data('cfgenwp_fontfamily_selected') != fontweight_s_loop.data('cfgenwp_fontfamily_selected')){
		
					// ^-- this statement prevents from reloading / filtering all the font weight options when the font family has not changed
					// console.log('[fontWeight] '+fontfamily_s_loop.data('cfgenwp_fontfamily_selected') +' != '+fontweight_s_loop.data('cfgenwp_fontfamily_selected'));

					var googlewebfonts_variants = fontfamily_s_loop.find('option:selected').data('cfgenwp_font_variants');
		
					var fontfamily_v = fontfamily_s_loop.val();
					
					fontweight_s_loop.empty().append(cfgenwp_html_fontweight_options);
					
					fontweight_s_loop.find('option').each(function(){
						
						var o = jQuery(this);
						
						o_v = o.prop('value');
						
						if(o_v == 'normal' || o_v == '400') o_v = 'regular';
						
						if(o_v == 'bold') o_v = '700'; // string, not integer
						
						// console.log('fontWeight = '+o_v+', search '+o_v+' in '+googlewebfonts_variants);
						// console.log(googlewebfonts_variants.length +' variant(s) '+ googlewebfonts_variants[0]);
						
						if(jQuery.inArray(o_v, googlewebfonts_variants) == -1){
							
							if(googlewebfonts_variants.length == 1 && googlewebfonts_variants[0] == 'italic' && o_v == 'regular'){
								// This if statement was added for Molle
								// If the font only includes "italic", Normal/400 must remain in the dropdown
								// In any other cases, Normal/400 can be removed from the dropdown
								
							} else{
								//console.log('delete option '+o_v);
								o.remove();
							}	
						}
					});
				
				
					fontweight_s_loop.data('cfgenwp_fontfamily_selected', fontfamily_v); // used for comparison "!=" above
					
					fontfamily_s_loop.data('cfgenwp_fontfamily_selected', fontfamily_v); // used for comparison "!=" above
					
					fontweight_s_loop.find('option[value='+fontweight_v+']').prop('selected', true);
					
				}
				
				// the font style options must be updated only if the font family is different from the previous one
				// ^-- NO! We take the fontstyle trigger out of the if() statement because some font styles may be specific to some font weights
				// Example: Open Sans Condensed: italic exist for 300 but not for 700
				// Therefore, in the example above, even if we stay on Open Sans Condensed, the font style options must be reloaded 
				// in order to display "normal" and "italic" for "300", and "normal" only for 700
				editproperties_c_loop.find('select.cfgenwp-fontstyle-select').trigger('change');
				
			});
			
			// using fontstyle_s.val(): we get the option automatically set after the options cleaning
			s.cfgen_updateFontProperty(target, {'font-weight':fontweight_s.val()});
		}
		
		if(is_fontfamily){
		
			jQuery.cfgen_setCssPropertyValue(object_type, 'font-family', css_value);
			
			var cssproperty_select_collection = [];
			cssproperty_select_collection.push({'fontfamily_s':fontfamily_s, 'fontweight_s':fontweight_s});
			
			if(applytoall && (object_type == 'title' || object_type == 'paragraph')){
			
				// console.log('APPLY TO ALL FROM FONT FAMILY');
				
				// The js default font weight var is updated in the if(is_fontweight) statement, which is triggered in any font family change
				
				applytoall_target.find('select.cfgenwp-fontfamily-select').val(css_value);
				applytoall_target.find('select.cfgenwp-fontweight-select').val(fontweight_v); // .val() doesn't trigger .change() 
				applytoall_target.find('select.cfgenwp-fontstyle-select').val(fontstyle_v); // .val() doesn't trigger .change()

				applytoall_target.find('select.cfgenwp-fontweight-select').each(function(){
					
					var fontweight_s_loop = jQuery(this);
					var editproperties_indiv_c = fontweight_s_loop.cfgen_closestElementPropertiesCont();
					var fontfamily_s_loop = editproperties_indiv_c.find('select.cfgenwp-fontfamily-select');
					
					cssproperty_select_collection.push({'fontfamily_s':fontfamily_s_loop, 'fontweight_s':fontweight_s_loop});
				});
			}
			
			// Update the fontweight select and fontstyle select of each properties container
			jQuery.each(cssproperty_select_collection, function(index, value){
				
				// Update fontfamily
				jQuery(value['fontfamily_s']).data('cfgenwp_fontfamily_selected', fontfamily_v); // to be able to compare the font family for individual editors in is_fontweight and is_fontstyle
				
				// Update fontweight
				// open sans 300 => arial => we trigger the event on the fontweight select to apply the default selected font weight
				jQuery(value['fontweight_s']).trigger('change');
				
			});
			
			s.cfgen_updateFontProperty(target, {'font-family':fontfamily_v});
		}
		
	});

	jQuery.fn.cfgen_SliderTriggersSelect = function(value){

		var select = jQuery(this).closest('div.cfgenwp-e-property-r').find('select.cfgenwp-select-slider');

		select.val(value).trigger('change', ['slider']);

		var res = {'value_px':jQuery.cfgen_appendPx(value)};

		return res;
	}

	jQuery('#cfgenwp-formbuilder-container').on('keyup change', 'select.cfgenwp-select-slider', function(e, source){
		// ^-- can be in toolbar or in the form builder
		
		source = typeof source !== 'undefined' ? source : 'select';
		
		var select = jQuery(this);
		var select_val = select.val();

		if(source === 'select'){
			// ^-- This condition prevents from triggering an infinite loop when the source is slider: select => slider value => slidechange => cfgen_SliderTriggersSelect => select
			select.closest('div.cfgenwp-e-property-r').find('.ui-slider').slider('option', 'value', select_val);
		}
	});
	
	// SLIDER WIDTH VALUE FROM INPUT
	var delay_keyup = (function(){
									var timer = 0;
									return function(callback, ms){
										clearTimeout(timer);
										timer = setTimeout(callback, ms);
									};
								})();

	jQuery('#cfgenwp-formbuilder-container').on('keyup focusout', '.cfgenwp-e-property-r input[type="text"].cfgenwp-slider-input-value', function(){
			// ^-- not using form_editor because this input can also be in the form settings
			
		var ui_slider = jQuery(this).cfgen_closestElementPropertyCont().find('.ui-slider');
		
		var input_value = jQuery(this).val();

		if(jQuery.cfgen_hasDigitsOnly(input_value)){

			if(event.type == 'keyup'){
				delay_keyup(function(){ui_slider.slider('option', 'value', input_value);}, 600);			
			} else{
				ui_slider.slider('option', 'value', input_value);
			}			
		} else{
			jQuery(this).val(ui_slider.slider('option', 'value'));
		}
	});

	
	// TOGGLE SMTP CONFIGURATION
	jQuery('#cfgenwp-config-emailsendingmethod').change(function(){
		jQuery(this).val() == 'smtp' ? jQuery('#cfgenwp-smtpconfiguration-c').show() : jQuery('#cfgenwp-smtpconfiguration-c').hide();
	});
	
	
	// EMAIL NOTIFICATION CHECKBOX
	form_config_user_notification_activate.click(function(){
		jQuery(this).is(':checked') ? jQuery('#deliveryreceiptconfiguration').show() : jQuery('#deliveryreceiptconfiguration').hide();
	});
	
	
	function buildSelectNotificationEmailAddress(){
		
		jQuery('#cfgenwp_config_usernotification_inputid').remove();
		
		var label_value = '';
		var emailinput_id = '';
		var count_email_field = form_editor.find('input[type="text"].cfgen-type-email').length;
		var select_emailnotificationinputid = '<select id="cfgenwp_config_usernotification_inputid" class="cfgenwp-formsettings-select">';
		
		form_editor.find('input[type="text"].cfgen-type-email').each(function(){
			var e_c = jQuery(this).cfgen_closestFbElementCont();
			label_value = e_c.find('.cfgen-label-value').html();
			emailinput_id = e_c.data('cfgenwp_element_id');
			
			var option_selected = '';
			if(emailinput_id == js_config_usernotification_inputid){
				// ^-- js_config_usernotification_inputid is created in index.php
				// preselect the right email field option when a form is loaded
				option_selected = 'selected="selected"';
			}
			select_emailnotificationinputid = select_emailnotificationinputid+'<option value="'+emailinput_id+'" '+option_selected+'>'+label_value+'</option>';
		});
		
		select_emailnotificationinputid = select_emailnotificationinputid+'</select>';
		
		jQuery('#notificationemailaddress').empty();
		
		
		jQuery('#cfgenwp-atleastonemailfield').css({'display':'none'});
		
		jQuery('#userinformationconfiguration').css({'display':'none'});
		
		if(!count_email_field){
			jQuery('#cfgenwp-atleastonemailfield').css({'display':'block'});
		} else{
			jQuery('#userinformationconfiguration').css({'display':'block'});
			
			// append the options in the select container
			jQuery('#notificationemailaddress').append(select_emailnotificationinputid);
		}
	}
	
	jQuery('body').on('change', '#cfgenwp_config_usernotification_inputid', function(){
		js_config_usernotification_inputid = jQuery(this).val();
	});
	
	
	// HIDE SHOW RADIO OPTIONS IN UPLOAD EDITOR
	form_editor.on('click', 'input[type="radio"].radio_upload_filetype', function(){

		jQuery(this).cfgen_closestElementPropertiesCont().find('.radio-upload-slide').hide();
		jQuery(this).closest('div.cfgenwp-e-property-r').find('.radio-upload-slide').show();
		
		jQuery(this).cfgen_closestElementPropertiesCont().find('label').removeClass('cfgenwp-option-selected');
		jQuery(this).closest('div').find('label').addClass('cfgenwp-option-selected');
		
		jQuery(this).cfgen_adjustElementHeightToRightContent();
	});
	
	
	// UPDATE DELETEFILE UPLOAD CHECKBOX
	form_editor.on('click', 'input[type="radio"].upload_deletefile', function(){
		/**
		 * 1: File Attachment + Download Link
		 * 2: File Attachment Only
		 * 3: Download Link Only
		 */
		var edit_c = jQuery(this).cfgen_closestElementPropertiesCont();
		var parentdiv = jQuery(this).closest('div');
		
		edit_c.find('label').removeClass('cfgenwp-option-selected');
		parentdiv.find('label').addClass('cfgenwp-option-selected');
		
		edit_c.find('.cfgenwp-element-editor-hint').hide();
		parentdiv.find('.cfgenwp-element-editor-hint').show();//slideDown('fast');
		
		jQuery(this).cfgen_adjustElementHeightToRightContent();
	});


	openform_btn.click(function(){
		var btn = jQuery(this).closest('div.cfgenwp-toolbar-btn');
		
		if(openform_list.is(':visible')){
			openform_list.fadeOut(100);
			btn.addClass('cfgenwp-openform-closed').removeClass('cfgenwp-openform-opened');
		} else{
			openform_list.fadeIn(60);
			btn.addClass('cfgenwp-openform-opened').removeClass('cfgenwp-openform-closed');
		}		
	});
	
	toolbar_c.find('.cfgenwp-openform-item-c').click(function(){
		openform_list.hide();
		openform_btn.addClass('cfgenwp-openform-closed').removeClass('cfgenwp-openform-opened');
	});
	
	jQuery(document).mouseup(function(e){
		
		//	console.log(e.target);
		var target = jQuery(e.target);
	
		if(openform_list.has(e.target).length === 0 && !target.is(openform_btn) && !target.is(openform_list)){
			openform_btn.addClass('cfgenwp-openform-closed').removeClass('cfgenwp-openform-opened');

			openform_list.fadeOut(100);
		}
	});

	
	jQuery('#cfgenwp-scrolltotop').click(function(){
		jQuery('html, body').animate({scrollTop: 0}, 100); 	
	})
	
	// RATING HOVER MOUSEENTER
	form_editor.on('mouseenter', 'div.cfgen-rating-c .fa', function(){
		
		var e_editor_c = jQuery(this).cfgen_closestFbElementCont().cfgen_findElementEditorCont();
		
		var color_hover = e_editor_c.find('input[type="text"].cfgenwp-colorpicker-rating-color-hover').val();
		var color_default = e_editor_c.find('input[type="text"].cfgenwp-colorpicker-rating-color').val();
		
		var rating_icon = jQuery(this);
		var rating_icon_index = rating_icon.index();
		var rating_icons = rating_icon.closest('div.cfgen-rating-c').find('.fa');
		
		var cut_index = rating_icon_index+1;
		
		rating_icons.slice(0, cut_index).css('color', color_hover);
		rating_icons.slice(cut_index).css('color', color_default);
	});

	// RATING HOVER MOUSELEAVE
	form_editor.on('mouseleave', 'div.cfgen-rating-c .fa', function(){
		
		var e_editor_c = jQuery(this).cfgen_closestFbElementCont().cfgen_findElementEditorCont();
		
		var color_hover = e_editor_c.find('input[type="text"].cfgenwp-colorpicker-rating-color-hover').val();
		var color_default = e_editor_c.find('input[type="text"].cfgenwp-colorpicker-rating-color').val();
		
		var rating_icon = jQuery(this);
		var rating_icons = rating_icon.closest('div.cfgen-rating-c').find('.fa');
		var ratings_c = rating_icon.closest('div.cfgen-rating-c');
		
		rating_icons.not('.cfgen-rating-selected').css('color', color_default);
		rating_icons.filter('.cfgen-rating-selected').css('color', color_hover);

	});
	
	// RATING CLICK
	form_editor.on('click', 'div.cfgen-rating-c .fa', function(){
		var e_editor_c = jQuery(this).cfgen_closestFbElementCont().cfgen_findElementEditorCont();
		var color_hover = e_editor_c.find('input[type="text"].cfgenwp-colorpicker-rating-color-hover').val();
		
		var rating_icon = jQuery(this);
		var rating_icon_index = rating_icon.index();
		var rating_icons = rating_icon.closest('div.cfgen-rating-c').find('.fa');
		
		rating_icons.removeClass('cfgen-rating-selected');
		rating_icons.slice(0, rating_icon_index+1).css('color', color_hover).addClass('cfgen-rating-selected');
	});
	
	// RATING SELECT ICON
	form_editor.on('change', 'select.cfgenwp-rating-icon-select', function(){
		var select_icon  = jQuery(this);
		
		var icon_id = select_icon.val();

		var rating_c = select_icon.cfgen_findElementContThroughFbElementCont().cfgen_findElementRatingContainer();
		
		rating_c.find('.fa').prop('class', 'fa '+icon_id);		
	});

	// MAXIMUM RATING
	form_editor.on('change', 'select.cfgenwp-rating-maximum', function(){
		
		var select_maximum = jQuery(this);
		
		var select_maximum_val = select_maximum.val();

		var e_properties_container = select_maximum.cfgen_closestElementPropertiesCont();
		// ^-- We are not using cfgenwp_findElementEditorCont() because the font size returned would be the select font size of the paragraph
		
		var e_c = select_maximum.cfgen_findElementContThroughFbElementCont();
		
		var selected_size = jQuery.cfgen_appendPx(e_properties_container.find('select.cfgenwp-rating-fontsize-select').val());
		
		var rating_c = e_c.cfgen_findElementRatingContainer();
		
		var icon_id = e_properties_container.find('select.cfgenwp-rating-icon-select').val();
		
		var padding_right = jQuery.cfgen_appendPx(e_properties_container.find('select.cfgenwp-rating-paddingright-select').val());
		
		var color_default = e_properties_container.find('input[type="text"].cfgenwp-colorpicker-rating-color').val();
		
		rating_c.empty();
		
		for(i = 1; i <= select_maximum_val; i++){
			rating_c.append('<span class="fa '+icon_id+'" style="font-size:'+selected_size+'; color:'+color_default+'; padding-right:'+padding_right+'"></span>');
		}
	});
	
	
	// ADD ICON
	form_editor.on('change', 'select.cfgenwp-icon-select', function(){

		var select_icon = jQuery(this);
		
		var selected_icon_id = select_icon.val();

		var fb_e_c = select_icon.cfgen_closestFbElementCont();

		var e_editor_panel = select_icon.cfgen_closestElementEditorPanel();

		var e_c = fb_e_c.cfgen_findElementCont();

		var icon_c = e_c.cfgen_findElementIconCont();

		var input = e_c.find('input[type="text"]');
		
		if(!selected_icon_id){
			
			// Hide icon properties panels
			var select_icon_editor_c = select_icon.closest('div.cfgenwp-e-properties-c');
			e_editor_panel.find('div.cfgenwp-e-properties-c').not(select_icon_editor_c).css({'display':'none'});
			
			icon_c.remove();
			
			var input_border_radius_px = getInputBorderRadiusPx();
			input.css('borderRadius', input_border_radius_px);
			
			e_editor_panel.cfgen_adjustElementHeightToRightContent();
			
		} else{

			e_editor_panel.find('div.cfgenwp-e-properties-c').css({'display':'block'});
			
			e_editor_panel.cfgen_adjustElementHeightToRightContent();

			// REPLACE ICON
			if(icon_c.length){
				icon_c.find('.fa').removeClass().addClass('fa '+selected_icon_id);
			}
			// ADD ICON
			else{

				e_c.cfgen_insertInputIcon('left', jQuery(cfgenwp_html_icon));
				
				var new_icon = e_c.cfgen_findElementIconCont();

				new_icon.cfgen_updateIconBorderRadius();
				new_icon.cfgen_updateIconBorderWidth();
				
				new_icon.find('.fa').addClass(selected_icon_id);

				// Apply icon color, background-color, border-color
				var icon_css = {
								'color':e_editor_panel.find('input[type=text].cfgenwp-colorpicker-icon-color').val(),
								'background-color':e_editor_panel.find('input[type=text].cfgenwp-colorpicker-icon-backgroundcolor').val(),
								'border-color':e_editor_panel.find('input[type=text].cfgenwp-colorpicker-icon-bordercolor').val(),
								'min-width':e_editor_panel.find('input[type=text].cfgenwp-icon-width-input-value').val()+'px'
								};

				new_icon.css(icon_css);

				// Apply icon alignment, icon border radius, icon border width
				e_editor_panel.find('input[type="radio"].cfgenwp-icon-align:checked').trigger('click');
				
			}
		}
		
		select_icon.cfgen_setInputContWidth().cfgen_triggerSliderIconContWidth();

	});
	
	// ICON ALIGNMENT, ICON BORDER RADIUS, ICON BORDER WIDTH 
	form_editor.on('click', 'input[type="radio"].cfgenwp-icon-align', function(){

		var btn = jQuery(this);
		var align_val = btn.val();
		
		var e_c = btn.cfgen_findElementContThroughFbElementCont();
		
		var find_element_icon = e_c.cfgen_findElementIconCont();
		
		var input = e_c.find('input');
		
		var input_border_radius_px = getInputBorderRadiusPx();

		var input_border_width_px = getInputBorderWidthPx();
		
		var input_c = input.closest('div.cfgen-input-c');
		
		if(align_val == 'left'){
			
			// inline css is not required for input_c when align is set on the left (whereas it is when align is set on the right)
			// the css style is already defined in the form css when the icon is before the input container
			
			input_css = {
						'border-top-left-radius':'0px',
						'border-bottom-left-radius':'0px',
						'border-top-right-radius':input_border_radius_px,
						'border-bottom-right-radius':input_border_radius_px
						};

			icon_css = {
						'border-top-right-radius':'0px',
						'border-bottom-right-radius':'0px',
						'border-top-left-radius':input_border_radius_px,
						'border-bottom-left-radius':input_border_radius_px,
						'border-left-width':input_border_width_px,
						'border-right-width':'0px'
						};
		}
		
		if(align_val == 'right'){
			
			// same css style as set in the form css file for .cfgen-icon-c + .cfgen-input-c (when icon is on the left side)
			input_c.css({'display':'table-cell', 'width':'100%', 'vertical-align':'top'});

			input_css = {
						'border-top-left-radius':input_border_radius_px,
						'border-bottom-left-radius':input_border_radius_px,
						'border-top-right-radius':'0px',
						'border-bottom-right-radius':'0px'
						};

			icon_css = {
						'border-top-left-radius':'0px',
						'border-bottom-left-radius':'0px',
						'border-top-right-radius':input_border_radius_px,
						'border-bottom-right-radius':input_border_radius_px,
						'border-left-width':'0px',
						'border-right-width':input_border_width_px
						};
		}
		
		input.css(input_css);
		
		var icon_moved = e_c.cfgen_insertInputIcon(align_val, find_element_icon);
		icon_moved.css(icon_css);
		
		// Adjusts the input padding after adding the icon (adding the icon triggers icon align button)
		btn.cfgen_closestElementEditorPanel().find('select.cfgenwp-icon-fontsize-select').trigger('change');

	});


	// API AND SERVICES
	var cfgenwp_false_required_type = ['email', 'url'];

	cfgenwp_dialog['emailtypemismatch'] = {title : 'Type mismatch',
											text : '<p>The form field you have selected is not an email field. For validation purposes and to prevent errors in your list, it is highly recommended that you select an email field instead.</p>'
													+'<p>If there is no email field in your form, you can add one by clicking on "Email" in the form builder sidebar.</p>',
											buttons : {OK: function(){jQuery(this).dialog('close');}}
											};


	cfgenwp_dialog['listfieldrequired'] = {title : 'Required field notice',
											text : '<p>The form field you have selected is not set as required in the form builder. For validation purposes and to prevent errors in your list, it is highly recommended that you set this field as required in your form.</p>'
													+'<p>The form data will not be pushed in your list if your visitor submits the form leaving this field empty. You will still receive the form notification message though.</p>',
											buttons : {OK: function(){jQuery(this).dialog('close');}}
											};

	
	jQuery.cfgen_findServiceMenuIco = function(service_id){
		return jQuery('#cfgenwp-service-menu-'+service_id);
	}
	
	jQuery.fn.cfgen_apiShowAuthenticate = function(){
		var api_c = jQuery(this).cfgen_findApiContainer();
		var api_id = api_c.data('cfgenwp_api_id');

		api_c.addClass('cfgenwp-editor-api-c-open');
		
		api_c.find('.cfgenwp-editor-api-builder').slideDown({duration:100, easing:'easeInOutQuart'});
	}
	
	jQuery.fn.cfgen_findApiContainer = function(){
		return jQuery(this).closest('div.cfgenwp-editor-api-c');
	}
	
	jQuery.fn.cfgen_apiFindUserAccounts = function(){
		return jQuery(this).find('.cfgenwp-api-user-accounts');
	}
	
	jQuery.fn.cfgen_apiFindButtonsContainer = function(){
		return jQuery(this).find('.cfgenwp-api-buttons-c');
	}
	
	jQuery.fn.cfgen_getApiContainerData = function(){
		var c = jQuery(this);

		var d = {};

		d['api_id'] = c.data('cfgenwp_api_id');
		d['aweber_consumerkey'] = c.data('cfgenwp_api_consumerkey');
		d['aweber_consumersecret'] = c.data('cfgenwp_api_consumersecret');
		d['aweber_accesstokenkey'] = c.data('cfgenwp_api_accesstokenkey');
		d['aweber_accesstokensecret'] = c.data('cfgenwp_api_accesstokensecret');

		return	d;
	}

	jQuery.fn.cfgen_serviceApiOpen = function(find_api_container){
	 
		find_api_container = typeof find_api_container !== 'undefined' ? find_api_container : true;
		
		if(find_api_container){
			var c = jQuery(this).cfgen_findApiContainer();
		} else{
			var c = jQuery(this);
		}
		
		var apibuilder = c.find('.cfgenwp-editor-api-builder');
		
		apibuilder.slideDown({duration:100, easing:'easeInOutQuart'});
		
		c.addClass('cfgenwp-editor-api-c-open');
		
		if(jQuery.trim(c.cfgen_apiFindUserAccounts().html())){
			c.cfgen_apiFindButtonsContainer().show();
		}
		
		
		// Aweber scenario
		// aweber added auth code loaded, sign in as a different use, close, aweber added
		// That way the auth code login box can still work even if the container aweber data attributes are set to null
		var validcredential_c = c.find('div.cfgenwp-api-validcredential');
		
		if(validcredential_c.length){
		
			validcredential_c.show();
			
			c.find('div.cfgenwp-api-credential-c').hide();
			
			if(aweber_authorizationcode_cache.hasOwnProperty('consumerkey')){
				
				// aweber data attributes may have been set to null after clicking on sign in as a different user
				c.data('cfgenwp_api_consumerkey', aweber_authorizationcode_cache['consumerkey'])
						.data('cfgenwp_api_consumersecret', aweber_authorizationcode_cache['consumersecret'])
						.data('cfgenwp_api_accesstokenkey', aweber_authorizationcode_cache['accesstokenkey'])
						.data('cfgenwp_api_accesstokensecret', aweber_authorizationcode_cache['accesstokensecret']);
			}
		}
	}
	
	form_settings.find('.cfgenwp-editor-api-name').click(function(){
	
		var c = jQuery(this).cfgen_findApiContainer();
		
		var apibuilder = c.find('.cfgenwp-editor-api-builder');
		
		// CLOSE
		if(apibuilder.is(':visible')){

			apibuilder.slideUp({duration:100, easing:'easeInOutQuart'});
			c.removeClass('cfgenwp-editor-api-c-open');
			c.cfgen_apiFindButtonsContainer().hide();
			
			c.cfgen_apiFindButtonsContainer().hide();
			
		}
		// OPEN
		else{

			c.cfgen_serviceApiOpen(false);

			if(jQuery.trim(c.cfgen_apiFindUserAccounts().html())){
				c.cfgen_apiFindButtonsContainer().show();
			}
		}
	});
	

	form_settings.on('change', '.cfgenwp-api-form-element-id', function(){
		
		var error = false;
		
		var o = jQuery(this);
		
		var api_c = o.closest('div.cfgenwp-api-list-c');
		
		var list_id = api_c.data('cfgenwp_api_list_id');
		
		var form_element_id = o.val();
		
		// keeps the option previously selected as selected when going back from editor to configuration
		cfgenwp_list_field_selected_element_id[o.attr('id')] = form_element_id;
		
		if(form_element_id){ // <= to prevent "unrecognized expression: div[data-cfgenwp_element_id=]" when selecting the empty option after selecting a non empty option
			var list_field_name = o.data('cfgenwp_api_list_field_name');
			var list_field_type = o.data('cfgenwp_api_list_field_type');
			var list_field_required = o.data('cfgenwp_api_list_field_required');
			
			var form_element = form_editor.find('div.cfgenwp-fb-element-c[data-cfgenwp_element_id='+form_element_id+']');
			var element_type = form_element.data('cfgenwp_element_type');
			var element_required = form_element.cfgen_findRequiredChecked().length;
			
			if(list_field_type == 'email' && list_field_type != element_type){
				error = true;

				cfgenwp_dialog_box.html('<p>Type mismatch for the list field "'+list_field_name+'"</p>'+cfgenwp_dialog['emailtypemismatch']['text']).dialog({autoOpen: true, title: cfgenwp_dialog['emailtypemismatch']['title'], buttons: cfgenwp_dialog['emailtypemismatch']['buttons']});
			}
			
			if(!error && jQuery.inArray(element_type, cfgenwp_false_required_type) == -1 && list_field_required == 1 && !element_required){
				cfgenwp_dialog_box.html('<p>Important notice about the list field "'+list_field_name+'"</p>'+cfgenwp_dialog['listfieldrequired']['text']).dialog({autoOpen: true, title: cfgenwp_dialog['listfieldrequired']['title'], buttons: cfgenwp_dialog['listfieldrequired']['buttons']});
			}
		}
	});
	
	form_settings.on('click', 'input[type="checkbox"].cfgenwp-api-list-doubleoptin, input[type="checkbox"].cfgenwp-api-list-sendwelcomeemail', function(){
		var btn = jQuery(this);
		var c = btn.closest('div.cfgenwp-api-list-c');
		var doubleoptin = c.find('.cfgenwp-api-list-doubleoptin');
		var sendwelcomeemail = c.find('.cfgenwp-api-list-sendwelcomeemail');
		
		if(btn.is(':checked')){
			if(btn.hasClass('cfgenwp-api-list-doubleoptin')){
				sendwelcomeemail.prop('checked', false);//.prop('disabled', true);
			}
			if(btn.hasClass('cfgenwp-api-list-sendwelcomeemail')){
				doubleoptin.prop('checked', false);//.prop('disabled', true);
			}
		} else{
			if(btn.hasClass('cfgenwp-api-list-doubleoptin')){
				//sendwelcomeemail.prop('disabled', false);
			}
			if(btn.hasClass('cfgenwp-api-list-sendwelcomeemail')){
				//doubleoptin.prop('disabled', false);
			}
		}
	});

	form_settings.on('click', 'input[type="checkbox"].cfgenwp-integrate-list', function(){
		
		var selector = jQuery(this);
		
		var list_container = selector.closest('div.cfgenwp-api-list-c');
		
		var fields_container = list_container.find('.cfgenwp-api-list-settings');
		
		
		var api_c = selector.cfgen_findApiContainer();
		
		var api_name_c = api_c.find('.cfgenwp-editor-api-name');
		
		var list_c = selector.closest('div.cfgenwp-api-list-c');
		
		if(selector.is(':checked')){
			
			selector.cfgen_apiActivate();
			
			fields_container.slideDown({duration:100, easing:'easeInOutQuart'});
			list_c.addClass('cfgenwp-api-list-c-selected');
			
		} else{
			fields_container.slideUp({duration:100, easing:'easeInOutQuart'});
			
			if(!api_c.find('.cfgenwp-integrate-list:checked').length){
				api_c.removeClass('cfgenwp-editor-api-c-selected');
			}
			
			list_c.removeClass('cfgenwp-api-list-c-selected');
			
		}

	});


	form_settings.on('click', 'input[type="radio"].cfgenwp-mailchimp-grouping-radio', function(){
		
		var previousCheck = jQuery(this).data('cfgenwp_mailchimp_grouping_checked');
		
		if(previousCheck == true){
			jQuery(this).prop('checked', false)
		}

		jQuery(this).data('cfgenwp_mailchimp_grouping_checked', jQuery(this).prop('checked'));
		
	});
	
	form_settings.on('click', 'input[type="checkbox"].cfgenwp-api-list-updateexistingcontact, input[type="radio"].cfgenwp-api-list-preventduplicates, input[type="radio"].cfgenwp-api-list-allowduplicates', function(){
		
		btn = jQuery(this);
		
		c = btn.closest('div.cfgenwp-api-list-settings');
		
		filterduplicates_c = c.find('.cfgenwp-api-filterduplicates-c');
		
		filterduplicates_select = filterduplicates_c.find('.cfgenwp-api-filterduplicates-field-id');
		
		if(btn.is('.cfgenwp-api-list-updateexistingcontact') || btn.is('.cfgenwp-api-list-preventduplicates')){
			
			if(btn.is(':checked')){
			
				filterduplicates_c.show();
				
				if(btn.is('.cfgenwp-api-list-updateexistingcontact')){
					filterduplicates_c.find('li.cfgenwp-api-updateexistingcontact-notice').show();
				}
				
				if(btn.is('.cfgenwp-api-list-preventduplicates')){
					filterduplicates_c.find('li.cfgenwp-api-preventduplicates-notice').show();
				}

			} else{
				if(btn.is('.cfgenwp-api-list-updateexistingcontact')){
					filterduplicates_c.find('li.cfgenwp-api-updateexistingcontact-notice').hide();
				}
			}
		}
		
		if(btn.is('.cfgenwp-api-list-allowduplicates:checked')){
			filterduplicates_c.find('ul li.cfgenwp-api-preventduplicates-notice').hide();
		}
		
		if(!c.find('.cfgenwp-api-list-updateexistingcontact:checked').length && !c.find('.cfgenwp-api-list-preventduplicates:checked').length){
			filterduplicates_c.hide();
			filterduplicates_select.find('option').removeAttr('selected');
		}
	});
	
	jQuery.fn.cfgen_apiActivate = function(){
		jQuery(this).cfgen_findApiContainer().addClass('cfgenwp-editor-api-c-selected');
	}
	
	jQuery.fn.cfgen_apiDeactivate = function(find_api_container){
	
		find_api_container = typeof find_api_container !== 'undefined' ? find_api_container : true;
		
		if(find_api_container){
			var c = jQuery(this).cfgen_findApiContainer();
		} else{
			var c = jQuery(this);
		}
		
		c.removeClass('cfgenwp-editor-api-c-selected');
		
		c.find('.cfgenwp-integrate-list').each(function(){
		
			var checkbox = jQuery(this);
			
			if(checkbox.is(':checked')){
				// Deactivate the list
				checkbox.trigger('click');
			}
		});

	}

	
	form_settings.on('click', 'div.cfgenwp-api-signin', function(){
		
		var button = jQuery(this);

		var c = button.cfgen_findApiContainer();
		c.cfgen_apiDeactivate();

		c.find('.cfgenwp-editor-api-authentication').slideDown({duration:70, easing: 'easeInOutQuart'});
		button.cfgen_apiShowAuthenticate();
		
		// empty: prevents potential checked lists from being saved
		c.cfgen_apiFindUserAccounts().slideUp({duration:70, easing: 'easeInOutQuart'}).empty();
		
		c.cfgen_apiFindButtonsContainer().hide();
	});

	
	form_settings.on('click', 'div.cfgenwp-api-reload', function(){
		var c = jQuery(this).cfgen_findApiContainer();
		c.removeClass('cfgenwp-editor-api-c-selected').find('.cfgenwp-integrate-api').trigger('click');

	});

	form_settings.find('span.cfgenwp-integrate-api').click(function(){
		
		/**
		 class used as a flag in order to :
		 - check if one or multiple service is being loaded 
		 - hide/show the save button
		**/
		var class_service_loadinginprogress = 'cfgenwp-service-loadinginprogress';
		
		var button_c = jQuery(this).closest('div.cfgenwp-integrate-api-c');
		button_c.hide();
		
		saveform_btn.hide();

		var savenotice_c = jQuery('#cfgenwp-notice-loadinglists');
		savenotice_c.css({'display':'inline-block'});
		
		var container = button_c.cfgen_findApiContainer();
		container.addClass(class_service_loadinginprogress);
		
		var container_data = container.cfgen_getApiContainerData();

		var api_buttons_c = container.cfgen_apiFindButtonsContainer();
		api_buttons_c.add().hide();
		
		var remove_service_ico = container.find('.cfgenwp-api-remove');
		remove_service_ico.hide();
		
		var authentication_c = container.find('.cfgenwp-editor-api-authentication');

		var accountlists_container = container.cfgen_apiFindUserAccounts();
		accountlists_container.empty();

		var api_id = container_data['api_id'];

		var apikey = jQuery.trim(container.find('.cfgenwp-api-apikey').val());

		var authorizationcode = jQuery.trim(container.find('.cfgenwp-api-authorizationcode').val());
		
		var accesstoken = jQuery.trim(container.find('.cfgenwp-api-accesstoken').val());
		
		var username = jQuery.trim(container.find('.cfgenwp-api-username').val());
		
		var password = container.find('.cfgenwp-api-password').val();
		
		var applicationpassword = container.find('.cfgenwp-api-applicationpassword').val();

		/* aweber */
		var consumerkey = container_data['aweber_consumerkey']
		var consumersecret = container_data['aweber_consumersecret'];
		var accesstokenkey = container_data['aweber_accesstokenkey'];
		var accesstokensecret = container_data['aweber_accesstokensecret'];

		var loading = container.find('.cfgenwp-api-loading');
		loading.show();
		
		var obj_form_elements = [];
		
		
		var service_menu_ico = jQuery.cfgen_findServiceMenuIco(api_id);
		service_menu_ico.addClass('cfgenwp-service-menu-ico-deactivated');
		

		
		form_editor.cfgen_findFbElementConts().each(function(){
			
			var cfgenwp_elementbuilder = jQuery(this);
			
			var cfgenwp_elementbuilder_id = cfgenwp_elementbuilder.data('cfgenwp_element_id');

			var cfgenwp_elementbuilder_label = cfgenwp_elementbuilder.cfgen_findProperLabel();

			// the element is a form input (not a title, not a submit button, etc.)
			if(jQuery.inArray(cfgenwp_elementbuilder.data('cfgenwp_element_type'), cfgenwp_isinput_list) != -1){
				obj_form_elements.push({'id': cfgenwp_elementbuilder_id, 'label': cfgenwp_elementbuilder_label});
			}
			
		});
		
		var post_api = {
						'api_id':api_id,
						'apikey':apikey,
						'authorizationcode':authorizationcode,
						'accesstoken':accesstoken,
						'username':username,
						'password':password,
						'applicationpassword':applicationpassword,
						'consumerkey':consumerkey,
						'consumersecret':consumersecret,
						'accesstokenkey':accesstokenkey,
						'accesstokensecret':accesstokensecret,
						'form_elements':obj_form_elements,
						'loadform_api_config':JSON.stringify(cfgenwp_loadform_api_config)
						/**
						 * JSON.stringify
						 * prevents php Notice undefined index errors in apigetlists when groups is empty (no JSON.stringify on api ajax load, empty js array groups won't be exist in php)
						 */
						};

		//console.log(post_api);
		
		jQuery.post(
					'inc/form-api-getlists.php',
					post_api,
					function(data){
									//console.log(data);
									
									service_menu_ico.removeClass('cfgenwp-service-menu-ico-deactivated');
									remove_service_ico.show();

									container.removeClass(class_service_loadinginprogress);
									if(!jQuery('.'+class_service_loadinginprogress).length){
										saveform_btn.show();
										savenotice_c.hide();
									}
									
									
									button_c.show();
									loading.hide();
									
									var response = jQuery.parseJSON(data);
									
									// ERROR
									if(response['error_text']){
									
										/**
										 * If a form is loaded and an api error is returned (wrong credentials or revoked credentials), we show the authentication box (along with emptying the list container etc.)
										 * (if a form is loaded, cfgenwp_loadform_api_config is not empty)
										 */
										if(!jQuery.isEmptyObject(cfgenwp_loadform_api_config)){
											container.find('.cfgenwp-api-signin').trigger('click');
										}
										
										cfgenwp_dialog_box.html('<p>'+response['error_text']+'</p>').dialog({
																											autoOpen: true, title: response['error_title'],
																											buttons: {OK: function() {jQuery(this).dialog('close');}}
																											});

										return false;
									}
									
									// NO ERROR
									else{
										authentication_c.slideUp({duration:70, easing:'easeInOutQuart', done:function(){}});

										if(response['html_res_type'] == 'ok'){
											
											if(container.hasClass('cfgenwp-editor-api-c-open')){
												api_buttons_c.fadeIn('fast');
											}
											
											accountlists_container.append(response['html']).hide().slideDown({duration:70, easing:'easeInOutQuart'});
											
											if(api_id == 'aweber'){
												container.find('.cfgenwp-api-authorizationcode').val('');
											}
											
											if(container.find('.cfgenwp-integrate-list:checked').length){
												button_c.cfgen_apiActivate();
											}

											if(response['aweber']){
												// The data attributes must be the same as in editor/index.php when a form is loaded with aweber credentials
												container.data('cfgenwp_api_consumerkey', response['aweber']['consumerkey'])
														.data('cfgenwp_api_consumersecret', response['aweber']['consumersecret'])
														.data('cfgenwp_api_accesstokenkey', response['aweber']['accesstokenkey'])
														.data('cfgenwp_api_accesstokensecret', response['aweber']['accesstokensecret']);

											}

											
											if(response['load_selected_formelement']){
												// A form is loaded with some form elements preselected for some api list fields
												// Keeps the options selected when: load form, go to config, go back to form, go to config
												// Required because cfgenwp_list_field_selected_element_id would be empty after the load of the form
												// Reminder: cfgenwp_list_field_selected_element_id is updated when changing the form element associated with a list field
												jQuery.each(response['load_selected_formelement'], function(index, value){
													cfgenwp_list_field_selected_element_id[index] = value;
												});
											}
											
										} else{
											accountlists_container.append(response['html']);
										}
									}
									
								}// function
					);// post
	
	});
		
	form_settings.find('div.cfgenwp-editor-api-c[data-cfgenwp_api_id=aweber] div.cfgenwp-api-signin').click(function(){
	
		var button = jQuery(this);
		var config_c = button.closest('div.cfgenwp-editor-api-c');
		
		// Saving the aweber credentials for the scenario: 
		// aweber added auth code loaded, sign in as a different use, close, aweber added
		// That way the auth code login box can still work even if the container aweber data attributes are set to null
		aweber_authorizationcode_cache['consumerkey'] = config_c.data('cfgenwp_api_consumerkey');
		aweber_authorizationcode_cache['consumersecret'] = config_c.data('cfgenwp_api_consumersecret');
		aweber_authorizationcode_cache['accesstokenkey'] = config_c.data('cfgenwp_api_accesstokenkey');
		aweber_authorizationcode_cache['accesstokensecret'] = config_c.data('cfgenwp_api_accesstokensecret');
		
		// To avoid a re-query of the data- attribute, set the name to a value of either null or undefined (e.g. .data("name", undefined)) rather than using .removeData()
		config_c.data('cfgenwp_api_consumerkey', null)
				.data('cfgenwp_api_consumersecret', null)
				.data('cfgenwp_api_accesstokenkey', null)
				.data('cfgenwp_api_accesstokensecret', null);

		config_c.find('.cfgenwp-api-validcredential').hide();
		config_c.find('.cfgenwp-api-credential-c').show();
		
	});
	
	form_settings.find('.cfgenwp-api-remove').click(function(){
	
		var btn = jQuery(this);
		
		var c = btn.closest('div.cfgenwp-editor-api-c');
		
		c.slideUp({duration:70, easing:'easeInOutQuart', complete: function(){}});

		var service_id = c.data('cfgenwp_api_id');
		
		var service_editor_c_id = 'cfgenwp-service-menu-'+service_id;
		
		var service_editor_c = jQuery('#'+service_editor_c_id);
		
		service_editor_c.removeClass('cfgenwp-service-menu-ico-selected');		
		service_editor_c.find('.cfgenwp-service-menu-btn-remove').hide();
		service_editor_c.find('.cfgenwp-service-menu-btn-add').show();
		
		c.cfgen_apiDeactivate();
	});
	
	form_settings.find('div.cfgenwp-service-menu-ico').click(function(){
	
		var btn = jQuery(this);
		
		if(btn.hasClass('cfgenwp-service-menu-ico-deactivated')) return;
		
		var c = btn;
		
		var add_btn = c.find('.cfgenwp-service-menu-btn-add');
		var remove_btn = c.find('.cfgenwp-service-menu-btn-remove');
		
		var service_id = c.data('cfgenwp_api_id');
		
		var service_editor_c_id = 'cfgenwp-service-editor-'+service_id; // as in cfgenwp-editor-api-c
		service_editor_c = jQuery('#'+service_editor_c_id);
		
		
		// CLOSE
		if(service_editor_c.is(':visible')){
			
			add_btn.show();
			remove_btn.hide();
			
			service_editor_c.slideUp({duration:70, easing:'easeInOutQuart', complete: function(){}});
			btn.removeClass('cfgenwp-service-menu-ico-selected');
			
			service_editor_c.cfgen_apiDeactivate();
		}
		// OPEN
		else{
			add_btn.hide();
			remove_btn.show();
			
			btn.addClass('cfgenwp-service-menu-ico-selected');
			
			var apibuilder = service_editor_c.find('.cfgenwp-editor-api-builder');
			
			service_editor_c.slideDown({duration:70,
										easing:'easeInOutQuart',
										complete: function(){
											service_editor_c.cfgen_serviceApiOpen(false);
										}
										});
		}

	});
	
	// DATABASE ACTIVATE DEACTIVATE
	jQuery('#cfgenwp-config-database-activate').click(function(){
		jQuery(this).is(':checked') ? jQuery('#cfgenwp-database-config-c').show() : jQuery('#cfgenwp-database-config-c').hide();
	});
	
	// DATABASE BUILDER: add formated element
	jQuery.fn.cfgen_addToDatabaseBuilder = function(collection, append){

		var html = '';

		jQuery.each(collection, function(index, value){

			var chekbox_default_value_html_id = 'cfgenwp-database-table-field-default-value-'+value['element_id'];
			var chekbox_default_value_html_checked = value['table_field_default_value'] === 'NULL' ? 'checked="checked"': '';
			
			if(value['item_type'] === 'element'){
				var c_data_attribute = 'data-cfgenwp_database_item_type="element" data-cfgenwp_database_form_e_id="'+value['element_id']+'"';
				// This attribute is used to select the builder item containers that are form elements in order to 
				// update the element label value when returning to the form edition and going back to the form settings
			}
			
			if(value['item_type'] === 'preset'){
				var c_data_attribute = 'data-cfgenwp_database_item_type="preset" data-cfgenwp_database_item_preset_id="'+value['preset_id']+'"';
			}

			html += '<div class="cfgenwp-database-builder-table-item-c" '+c_data_attribute+'>';
				
				html += '<div class="cfgenwp-database-builder-item-label-c">'+value['item_label']+'</div>';
				
				html += '<div class="cfgenwp-database-builder-item-r">';

					html += '<div class="cfgenwp-database-builder-table-field-id-c">';
						html += '<input type="text" class="cfgenwp-database-builder-table-field-id" value="'+value['table_field_id']+'" placeholder="Enter the table column name">'
					html += '</div>';
					
					html += '<div class="cfgenwp-database-builder-delete-c"><span class="cfgenwp-database-builder-delete cfgenwp-a">Delete</span></div>';
					html += '<img src="img/arrow-move.png" class="cfgenwp-database-builder-move-c">';
					
					/**
					 * can_be_null is set when creating the element list on the fly and is based on whether the required validation is checked or not
					 * chekbox_default_value_html_checked is set when loading a form that includes a database config
					 */
					if(value['item_type'] === 'element' && (value['can_be_null'] === true || chekbox_default_value_html_checked)){
						var database_item_default_value_c_style = '';
					} else{
						var database_item_default_value_c_style = 'display:none';
					}
					html += '<div class="cfgenwp-database-builder-table-field-default-value-c" style="'+database_item_default_value_c_style+'">';
					html += '<input type="checkbox" '+chekbox_default_value_html_checked+' class="cfgenwp-database-builder-table-field-default-value" id="'+chekbox_default_value_html_id+'">';
					html += '<label for="'+chekbox_default_value_html_id+'">Insert NULL if the form input value is left blank</label>';
					html += '</div>';
					
				
				html += '</div>';
				
			html += '<div class="cfgenwp-clear"></div>';
				
			html += '</div>';
		});
		
		if(append === true){
			jQuery(this).append(html);
		}

		return html;
	}
	
	jQuery.fn.cfgen_deleteFromDatabaseBuilder = function(){
		jQuery(this).closest('div.cfgenwp-database-builder-table-item-c').remove();
	}

	// DATABASE BUILDER: delete element
	jQuery('#cfgenwp-database-builder').on('click','span.cfgenwp-database-builder-delete', function(){
		jQuery(this).cfgen_deleteFromDatabaseBuilder();
	});
	
	// SMS ADMIN NOTIFICATION ACTIVATE
	form_config_sms_admin_notification_activate.click(function(){
		jQuery(this).is(':checked') ? jQuery('#cfgenwp-sms-admin-notification-c').show() : jQuery('#cfgenwp-sms-admin-notification-c').hide();
	});
	
	// SMS ADMIN NOTIFICATION GATEWAY
	jQuery('#cfgenwp-sms-admin-notification-gateway').change(function(){
		var sms_gateway_id = jQuery(this).val();
		
		// Hide all (reset)
		form_settings.find('div.cfgenwp-sms-admin-notification-gateway-config').hide();
		
		// Show gateway config
		if(sms_gateway_id){
			form_settings.find('div.cfgenwp-sms-admin-notification-gateway-config[data-cfgenwp_sms_gateway_id="'+sms_gateway_id+'"]').show();
		}
	});

	
}); //jQuery

jQuery.fn.cfgen_updateElementColor = function(){
	// ^-- can't be included in colorkit, the function is also called in farbtastic js file
	
	var colorvalue_input = jQuery(this);

	var css_property_name = colorvalue_input.data('cfgenwp_colorpicker_csspropertyname');

	var target = colorvalue_input.data('cfgenwp_colorpicker_target');

	var e_c = jQuery(this).cfgen_findElementContThroughFbElementCont();

	if(target == 'input'){
		var colorpicker_target = e_c.find('.cfgenwp-colorpicker-target-element');
	}
	else if(target == 'icon'){
		var colorpicker_target = e_c.cfgen_findElementIconCont();
	}
	else if(target == 'paragraph'){
		var colorpicker_target = e_c.find('div.cfgen-paragraph');
	}
	else if(target == 'rating'){
		var colorpicker_target = e_c.find('div.cfgen-rating-c .fa');
	}
	else if(target == 'terms'){
		var colorpicker_target = e_c.find('div.cfgen-terms label');
	}
	else if(target == 'title'){
		var colorpicker_target = e_c.find('div.cfgen-title');
	}
	else if(target == 'submit'){
		var colorpicker_target = e_c.find('input[type="submit"].cfgen-submit');
	}
	else{
		var colorpicker_target = jQuery(target); // else we target the specified class (index.php), like .cfgen-title, .cfgen-label, etc.
	}
	
	var c = colorvalue_input.val();
	
	colorvalue_input.closest('div.cfgenwp-colorpicker-c').find('div.cfgenwp-colorpicker-ico').css('background-color', c);
	
	var object_type = colorvalue_input.data('cfgenwp_colorpicker_objecttype');
	object_type = typeof object_type === 'undefined' ? '' : object_type; // objecttype is undefined in editFormMessageStyle
	
	// The paletteonly mode is used when using colorpalette for hover, we don't want the color to apply on the element	
	var paletteonly = colorvalue_input.data('cfgenwp_colorpicker_paletteonly');
	paletteonly = typeof paletteonly === 'paletteonly' ? false : paletteonly;
	
	if(!paletteonly){
		
		var applytoall = colorvalue_input.data('cfgenwp_colorpicker_applytoall');
		applytoall = typeof applytoall === 'undefined' ? false : applytoall;

		if(css_property_name == 'color'){

			if(object_type == 'title' || object_type == 'paragraph'){

				if(applytoall){				
					colorpicker_target.each(function(){ // Change the color icon in all the element containers
						var e_container_loop = jQuery(this).cfgen_closestFbElementCont();
						e_container_loop.find('input[type="text"].cfgenwp-colorpicker-value').css('background-color', c).val(c);
						e_container_loop.find('div.cfgenwp-colorpicker-ico').css('background-color', c);
					});
				}
			}
			
			if(object_type){ // objecttype is undefined in editFormMessageStyle
				jQuery.cfgen_setCssPropertyValue(object_type, 'color', c);
			}

			colorpicker_target.css('color', c);
		}

		if(css_property_name == 'background-color'){

			if(object_type){ // objecttype is undefined in editFormMessageStyle
				jQuery.cfgen_setCssPropertyValue(object_type, 'background-color', c);
			}

			colorpicker_target.css('background-color', c);
		}
		
		if(css_property_name == 'border-color'){

			if(object_type){ // objecttype is undefined in editFormMessageStyle
				jQuery.cfgen_setCssPropertyValue(object_type, 'border-color', c);
			}

			colorpicker_target.css('border-color', c);
		}
	}

	// Hover on the submit button
	if(target == 'submit'){
		colorvalue_input.cfgen_hoverSubmitAdd();
	}

	// Border color on :focus
	if(css_property_name == 'outline'){
		jQuery.cfgen_setCssPropertyValue(object_type, 'border-color', c, 'focus')
	}
}

// json2
"object"!=typeof JSON&&(JSON={}),function(){"use strict";function f(t){return 10>t?"0"+t:t}function this_value(){return this.valueOf()}function quote(t){return rx_escapable.lastIndex=0,rx_escapable.test(t)?'"'+t.replace(rx_escapable,function(t){var e=meta[t];return"string"==typeof e?e:"\\u"+("0000"+t.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+t+'"'}function str(t,e){var r,n,o,u,f,a=gap,i=e[t];switch(i&&"object"==typeof i&&"function"==typeof i.toJSON&&(i=i.toJSON(t)),"function"==typeof rep&&(i=rep.call(e,t,i)),typeof i){case"string":return quote(i);case"number":return isFinite(i)?String(i):"null";case"boolean":case"null":return String(i);case"object":if(!i)return"null";if(gap+=indent,f=[],"[object Array]"===Object.prototype.toString.apply(i)){for(u=i.length,r=0;u>r;r+=1)f[r]=str(r,i)||"null";return o=0===f.length?"[]":gap?"[\n"+gap+f.join(",\n"+gap)+"\n"+a+"]":"["+f.join(",")+"]",gap=a,o}if(rep&&"object"==typeof rep)for(u=rep.length,r=0;u>r;r+=1)"string"==typeof rep[r]&&(n=rep[r],o=str(n,i),o&&f.push(quote(n)+(gap?": ":":")+o));else for(n in i)Object.prototype.hasOwnProperty.call(i,n)&&(o=str(n,i),o&&f.push(quote(n)+(gap?": ":":")+o));return o=0===f.length?"{}":gap?"{\n"+gap+f.join(",\n"+gap)+"\n"+a+"}":"{"+f.join(",")+"}",gap=a,o}}var rx_one=/^[\],:{}\s]*$/,rx_two=/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,rx_three=/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,rx_four=/(?:^|:|,)(?:\s*\[)+/g,rx_escapable=/[\\\"\u0000-\u001f\u007f-\u009f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,rx_dangerous=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;"function"!=typeof Date.prototype.toJSON&&(Date.prototype.toJSON=function(){return isFinite(this.valueOf())?this.getUTCFullYear()+"-"+f(this.getUTCMonth()+1)+"-"+f(this.getUTCDate())+"T"+f(this.getUTCHours())+":"+f(this.getUTCMinutes())+":"+f(this.getUTCSeconds())+"Z":null},Boolean.prototype.toJSON=this_value,Number.prototype.toJSON=this_value,String.prototype.toJSON=this_value);var gap,indent,meta,rep;"function"!=typeof JSON.stringify&&(meta={"\b":"\\b","	":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},JSON.stringify=function(t,e,r){var n;if(gap="",indent="","number"==typeof r)for(n=0;r>n;n+=1)indent+=" ";else"string"==typeof r&&(indent=r);if(rep=e,e&&"function"!=typeof e&&("object"!=typeof e||"number"!=typeof e.length))throw new Error("JSON.stringify");return str("",{"":t})}),"function"!=typeof JSON.parse&&(JSON.parse=function(text,reviver){function walk(t,e){var r,n,o=t[e];if(o&&"object"==typeof o)for(r in o)Object.prototype.hasOwnProperty.call(o,r)&&(n=walk(o,r),void 0!==n?o[r]=n:delete o[r]);return reviver.call(t,e,o)}var j;if(text=String(text),rx_dangerous.lastIndex=0,rx_dangerous.test(text)&&(text=text.replace(rx_dangerous,function(t){return"\\u"+("0000"+t.charCodeAt(0).toString(16)).slice(-4)})),rx_one.test(text.replace(rx_two,"@").replace(rx_three,"]").replace(rx_four,"")))return j=eval("("+text+")"),"function"==typeof reviver?walk({"":j},""):j;throw new SyntaxError("JSON.parse")})}();

/**
 * Farbtastic Color Picker 1.2
 * © 2008 Steven Wittens
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 */

jQuery.fn.farbtastic = function (callback) {
  $.farbtastic(this, callback);
  return this;
};

jQuery.farbtastic = function (container, callback) {
  var container = $(container).get(0);
  return container.farbtastic || (container.farbtastic = new jQuery._farbtastic(container, callback));
}

jQuery._farbtastic = function (container, callback) {
  // Store farbtastic object
  var fb = this;

  // Insert markup
  $(container).html('<div class="farbtastic"><div class="color"></div><div class="wheel"></div><div class="overlay"></div><div class="h-marker marker"></div><div class="sl-marker marker"></div></div>');
  var e = $('.farbtastic', container);
  fb.wheel = $('.wheel', container).get(0);
  // Dimensions
  fb.radius = 84;
  fb.square = 100;
  fb.width = 194;

  // Fix background PNGs in IE6
  if (navigator.appVersion.match(/MSIE [0-6]\./)) {
    $('*', e).each(function () {
      if (this.currentStyle.backgroundImage != 'none') {
        var image = this.currentStyle.backgroundImage;
        image = this.currentStyle.backgroundImage.substring(5, image.length - 2);
        $(this).css({
          'backgroundImage': 'none',
          'filter': "progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=crop, src='" + image + "')"
        });
      }
    });
  }

  /**
   * Link to the given element(s) or callback.
   */
  fb.linkTo = function (callback) {
    // Unbind previous nodes
    if (typeof fb.callback == 'object') {
      $(fb.callback).unbind('keyup', fb.updateValue);
    }

    // Reset color
    fb.color = null;

    // Bind callback or elements
    if (typeof callback == 'function') {
      fb.callback = callback;
    }
    else if (typeof callback == 'object' || typeof callback == 'string') {
      fb.callback = $(callback);
      fb.callback.bind('keyup', fb.updateValue);
      if (fb.callback.get(0).value) {
        fb.setColor(fb.callback.get(0).value);
      }
    }
    return this;
  }
  fb.updateValue = function (event) {
    if (this.value && this.value != fb.color) {
      fb.setColor(this.value);
    }
  }

  /**
   * Change color with HTML syntax #123456
   */
  fb.setColor = function (color) {
    var unpack = fb.unpack(color);
    if (fb.color != color && unpack) {
      fb.color = color;
      fb.rgb = unpack;
      fb.hsl = fb.RGBToHSL(fb.rgb);
      fb.updateDisplay();
    }
    return this;
  }

  /**
   * Change color with HSL triplet [0..1, 0..1, 0..1]
   */
  fb.setHSL = function (hsl) {
    fb.hsl = hsl;
    fb.rgb = fb.HSLToRGB(hsl);
    fb.color = fb.pack(fb.rgb);
    fb.updateDisplay();
    return this;
  }

  /////////////////////////////////////////////////////

  /**
   * Retrieve the coordinates of the given event relative to the center
   * of the widget.
   */
  fb.widgetCoords = function (event) {
    var x, y;
    var el = event.target || event.srcElement;
    var reference = fb.wheel;

    if (typeof event.offsetX != 'undefined') {
      // Use offset coordinates and find common offsetParent
      var pos = { x: event.offsetX, y: event.offsetY };

      // Send the coordinates upwards through the offsetParent chain.
      var e = el;
      while (e) {
        e.mouseX = pos.x;
        e.mouseY = pos.y;
        pos.x += e.offsetLeft;
        pos.y += e.offsetTop;
        e = e.offsetParent;
      }

      // Look for the coordinates starting from the wheel widget.
      var e = reference;
      var offset = { x: 0, y: 0 }
      while (e) {
        if (typeof e.mouseX != 'undefined') {
          x = e.mouseX - offset.x;
          y = e.mouseY - offset.y;
          break;
        }
        offset.x += e.offsetLeft;
        offset.y += e.offsetTop;
        e = e.offsetParent;
      }

      // Reset stored coordinates
      e = el;
      while (e) {
        e.mouseX = undefined;
        e.mouseY = undefined;
        e = e.offsetParent;
      }
    }
    else {
      // Use absolute coordinates
      var pos = fb.absolutePosition(reference);
      x = (event.pageX || 0*(event.clientX + $('html').get(0).scrollLeft)) - pos.x;
      y = (event.pageY || 0*(event.clientY + $('html').get(0).scrollTop)) - pos.y;
    }
    // Subtract distance to middle
    return { x: x - fb.width / 2, y: y - fb.width / 2 };
  }

  /**
   * Mousedown handler
   */
  fb.mousedown = function (event) {
    // Capture mouse
    if (!document.dragging) {
      $(document).bind('mousemove', fb.mousemove).bind('mouseup', fb.mouseup);
      document.dragging = true;
    }

    // Check which area is being dragged
    var pos = fb.widgetCoords(event);
    fb.circleDrag = Math.max(Math.abs(pos.x), Math.abs(pos.y)) * 2 > fb.square;

    // Process
    fb.mousemove(event);
    return false;
  }

  /**
   * Mousemove handler
   */
  fb.mousemove = function (event) {
    // Get coordinates relative to color picker center
    var pos = fb.widgetCoords(event);

    // Set new HSL parameters
    if (fb.circleDrag) {
      var hue = Math.atan2(pos.x, -pos.y) / 6.28;
      if (hue < 0) hue += 1;
      fb.setHSL([hue, fb.hsl[1], fb.hsl[2]]);
    }
    else {
      var sat = Math.max(0, Math.min(1, -(pos.x / fb.square) + .5));
      var lum = Math.max(0, Math.min(1, -(pos.y / fb.square) + .5));
      fb.setHSL([fb.hsl[0], sat, lum]);
    }
    return false;
  }

  /**
   * Mouseup handler
   */
  fb.mouseup = function () {
    // Uncapture mouse
    $(document).unbind('mousemove', fb.mousemove);
    $(document).unbind('mouseup', fb.mouseup);
    document.dragging = false;
  }

  /**
   * Update the markers and styles
   */
  fb.updateDisplay = function () {
    // Markers
    var angle = fb.hsl[0] * 6.28;
    $('.h-marker', e).css({
      left: Math.round(Math.sin(angle) * fb.radius + fb.width / 2) + 'px',
      top: Math.round(-Math.cos(angle) * fb.radius + fb.width / 2) + 'px'
    });

    $('.sl-marker', e).css({
      left: Math.round(fb.square * (.5 - fb.hsl[1]) + fb.width / 2) + 'px',
      top: Math.round(fb.square * (.5 - fb.hsl[2]) + fb.width / 2) + 'px'
    });

    // Saturation/Luminance gradient
    $('.color', e).css('backgroundColor', fb.pack(fb.HSLToRGB([fb.hsl[0], 1, 0.5])));

    // Linked elements or callback
    if (typeof fb.callback == 'object') {
      // Set background/foreground color
      $(fb.callback).css({
        backgroundColor: fb.color,
        color: fb.hsl[2] > 0.5 ? '#000' : '#fff'
      });

      // Change linked value
      $(fb.callback).each(function(){
	  
		var colorinput = jQuery(this); // cfgenwp
	  
        if(this.value && this.value != fb.color){ // cond 1
          this.value = fb.color;
		}
		
		if(!this.value){// cfgenwp // cond 2
			// prevents the input from being left empty after ctrl+x value + clicking on the wheel
			colorinput.val(fb.color);
		}
		
		colorinput.data('cfgenwp_colorpicker_last_value', fb.color).cfgen_updateElementColor();// cfgenwp
		
      });
    }
    else if (typeof fb.callback == 'function') {
      fb.callback.call(fb, fb.color);
    }
  }

  /**
   * Get absolute position of element
   */
  fb.absolutePosition = function (el) {
    var r = { x: el.offsetLeft, y: el.offsetTop };
    // Resolve relative to offsetParent
    if (el.offsetParent) {
      var tmp = fb.absolutePosition(el.offsetParent);
      r.x += tmp.x;
      r.y += tmp.y;
    }
    return r;
  };

  /* Various color utility functions */
  fb.pack = function (rgb) {
    var r = Math.round(rgb[0] * 255);
    var g = Math.round(rgb[1] * 255);
    var b = Math.round(rgb[2] * 255);
    return '#' + (r < 16 ? '0' : '') + r.toString(16) +
           (g < 16 ? '0' : '') + g.toString(16) +
           (b < 16 ? '0' : '') + b.toString(16);
  }

  fb.unpack = function (color) {
    if (color.length == 7) {
      return [parseInt('0x' + color.substring(1, 3)) / 255,
        parseInt('0x' + color.substring(3, 5)) / 255,
        parseInt('0x' + color.substring(5, 7)) / 255];
    }
    else if (color.length == 4) {
      return [parseInt('0x' + color.substring(1, 2)) / 15,
        parseInt('0x' + color.substring(2, 3)) / 15,
        parseInt('0x' + color.substring(3, 4)) / 15];
    }
  }

  fb.HSLToRGB = function (hsl) {
    var m1, m2, r, g, b;
    var h = hsl[0], s = hsl[1], l = hsl[2];
    m2 = (l <= 0.5) ? l * (s + 1) : l + s - l*s;
    m1 = l * 2 - m2;
    return [this.hueToRGB(m1, m2, h+0.33333),
        this.hueToRGB(m1, m2, h),
        this.hueToRGB(m1, m2, h-0.33333)];
  }

  fb.hueToRGB = function (m1, m2, h) {
    h = (h < 0) ? h + 1 : ((h > 1) ? h - 1 : h);
    if (h * 6 < 1) return m1 + (m2 - m1) * h * 6;
    if (h * 2 < 1) return m2;
    if (h * 3 < 2) return m1 + (m2 - m1) * (0.66666 - h) * 6;
    return m1;
  }

  fb.RGBToHSL = function (rgb) {
    var min, max, delta, h, s, l;
    var r = rgb[0], g = rgb[1], b = rgb[2];
    min = Math.min(r, Math.min(g, b));
    max = Math.max(r, Math.max(g, b));
    delta = max - min;
    l = (min + max) / 2;
    s = 0;
    if (l > 0 && l < 1) {
      s = delta / (l < 0.5 ? (2 * l) : (2 - 2 * l));
    }
    h = 0;
    if (delta > 0) {
      if (max == r && max != g) h += (g - b) / delta;
      if (max == g && max != b) h += (2 + (b - r) / delta);
      if (max == b && max != r) h += (4 + (r - g) / delta);
      h /= 6;
    }
    return [h, s, l];
  }

  // Install mousedown handler (the others are set on the document on-demand)
  $('*', e).mousedown(fb.mousedown);

    // Init color
  fb.setColor('#000000');

  // Set linked elements/callback
  if (callback) {
    fb.linkTo(callback);
  }
}