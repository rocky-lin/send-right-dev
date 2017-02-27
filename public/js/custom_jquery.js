// date picker in campaign settings  
// 
  var $url_home  = $('#url_home').val(); 
$(function(){  
	console.log("contact jquery loaded!...");   
	$('[data-toggle="popover"]').popover();
	$('input:radio').click(function(){
		var pullRight =  $(this).attr("rel");
		 if(pullRight == "pullRight2"){
			$('.showDatetime').css({
				"display": "block"
			});
		 }else if(pullRight == "pullRight1"){
			$('.showDatetime').css({
				"display": "none"
			});
		 }
	}); 
		flatpickr(".flatpickr", {
	    enableTime: true,  
	    altInput: true,
	    altFormat: "F j, Y h:i K"
	}); 
});
 
$(document).ready(function(){  
	console.log("document is ready from custom_jquery.js");   
	// preview desktop campaign
	$('#previewDesktop').on('click', function(){  
		var campaignId = $(this).attr('campaign-id');  
		  console.log("campaign preview "  + campaignId);

		  var url_home  = $('#url_home').val(); 
		var jqxhr = $.get( url_home + "/extension/campaign/preview.php?campaignId=" + campaignId, function(data) { 
		  	$('#previewDesktopDisplay').html(data);
		})
	})
	// preview mobile campaign
	$('#previewMobile').on('click', function(){ 
		var campaignId = $(this).attr('campaign-id');  
		  console.log("campaign preview "  + campaignId);
		    var url_home  = $('#url_home').val(); 
		var jqxhr = $.get( url_home + "/extension/campaign/preview.php?campaignId=" + campaignId, function(data) { 
		  	$('#previewMobileDisplay').html(data);
		})
	});  
	// send test email in campaign  
	$('#campaign-send-test').on('click', function(){  
		var testEmail = $('#test_email').val();   
		if(validateEmail(testEmail) == true) {  
			$('#campaign-send-test-status').html('');
			$('#campaign-send-test-status').attr('class', 'fa fa-spinner fa-spin');  
			console.log("prepare to send new test email");
			var campaignId = $('#campaign_id').val(); 
			var testEmail = $('#test_email').val(); 
			console.log("campaign id " + campaignId);
				    var url_home  = $('#url_home').val(); 
			var jqxhr = $.get( url_home + "/user/campaign/create/settings/email/send/test/"+campaignId+"/"+testEmail, function(data) { 
				$('#campaign-send-test-status').attr('class', 'waiting');  
			  	$('#campaign-send-test-status').html(data);
			  	console.log('campaign send processed! ');
			  	console.log(data)  
			});  
		} else {
			alert("Please put a valid test email."); 
		} 
		function validateEmail(email) {
		    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		    return re.test(email);
		}
	}); 

	// campaign settings
	 $('#campaign_type_schedule_send, #campaign_type_direct_send').click(function() { 
	 		var value = $("input[name='campaign_type']:checked").val();  
	 		if(value == 'direct send') {
	 			$('#campaign-finish').val('Send now');
	 		} else {
	 			$('#campaign-finish').val('Save now');
	 		}	 
	  });  

	// campaign compose 
	$('#campaign-select-contact-table-row').change(function(e){
		console.log(" selected contact row name");
		console.log( "selected value " + $(this).val() );  
	})




// Compose campaign copy clipboard when clicked contact
$('#campaign-compose-select-contact-row-name input ').click(function(){ 
	 var copyRowNameId = $(this).attr('table-row-name-id'); 
	 var copyRowValue = $('#'+copyRowNameId).val(); 
	 var copyRowName =  $(this).val();
	 console.log("table row name id " + copyRowNameId); 
	   copyToClipboard(document.getElementById(copyRowNameId));  
	  $('#campaign-compose-select-contact-collapse').attr('class', 'collapse'); 
	  $('#campaign-compose-select-contact-collapse').attr('aria-expanded', 'false');   
	  alert("Contact row name "  + copyRowName + " as "  + copyRowValue  + " successfully copied to your clipboard");
}) 
 	
// clipboard copy when click   
function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
} 




// Home loaded
// Change code to only load home page view 

	$("#home-activity-preview").load( $url_home + "/user/home/preview/activities", function() {
  		console.log( "home activities preview loaded, this should only loaded in home page" );
	});   
	$("#home-contact-preview").load( $url_home + '/user/home/preview/contacts', function(){
		console.log( "home contacts preview loaded, this should only loaded in home page" );
	})
	$("#home-list-preview").load( $url_home + '/user/home/preview/lists', function(){
		console.log( "home lists preview loaded, this should only loaded in home page" );
	})
	$("#home-form-preview").load( $url_home + '/user/home/preview/forms', function(){
		console.log( "home forms preview loaded, this should only loaded in home page" );
	})
	$("#home-campaign-preview").load( $url_home + '/user/home/preview/campaigns', function(){
		console.log( "home campaigns preview loaded, this should only loaded in home page" );
	})
	$("#home-statistic-preview").load( $url_home + '/user/home/preview/statics', function(){
		//
	})

  // alert( "Load was performed." ); 
 	 
});  


$(document).ready(function(){
 
	// Save optin settings in campaign editor
 	$('#save_optin_settings').on('click', function() {  
 		var optInUrlInput 	 = change_space_with_dash($("#optInUrlInput").val()); 
 		var optInEmailSubject = $("#optInEmailSubject").val(); 
 		var optInEmailContent = $("#optInEmailContent").val(); 
 		var optInRecieverName = $("#optInRecieverName").val(); 
 		var optInRecieverEmail = $("#optInRecieverEmail").val(); 
 		var optInResponseUrl   = $("#optInResponseUrl").val(); 
  
        var $this = $(this); 
        $this.button('loading');  
 		$.post( "includes/optin-settings-popup-savetosession.php", {
 			optin_url:optInUrlInput, optin_email_subject:optInEmailSubject,optin_email_content:optInEmailContent,optin_email_to_name:optInRecieverName,optin_email_to_mail:optInRecieverEmail,optin_popup_link:optInResponseUrl
 		 })
		  .done(function( data ) {
		  	
		  	  	$this.button('reset');

		    	console.log( "Data Loaded: " + data );

		    	if(data == 'Optin Settings saved successfully') {
		    		console.log("display success box");
		    		$('#optin-status').attr('class', 'alert alert-success');  
		    	} else {
		    		$('#optin-status').attr('class', 'alert alert-danger'); 
		    		console.log("display error box");  
		    	}
 
		    	if(data == 'Optin Settings saved successfully') {  
			    	setTimeout(function(){
			    		 $('#emailOptIn').modal('hide');
			    	}, 1000);
		    	} 

		    	$('#optin-status').html(data);
 
		  }); 
	});  
 	$( "#optInUrlInput" ).keyup(function() { 
		var optInUrlTyped = $(this).val();   
		$("#optInUrlTyped").text(change_space_with_dash(optInUrlTyped) ); 
	}); 
}); 
 
$(document).ready(function() { 
	// click the button in mobile optin page
 	$('.button-1').on('click', function(){
 
		var emailBody = $('#optin_email_content').val(); 
		var subject   = $('#optin_email_subject').val(); 
		var link      = $('#optin_popup_link').val(); 
		var name      = $('#optin_email_to_name').val(); 
		var email     = $('#optin_email_to_mail').val();  
		var redirect_link     = $('#optin_popup_link').val();  
        document.location = "mailto:"+email+"?subject="+subject+"&body="+emailBody;  
        setTimeout(function(){
	        if(redirect_link != null) { 
	        	document.location = redirect_link;  
	    	}
    	}, 1000)
 	}); 
}); 
 
$(document).ready(function(){
	$('#select-campaign-template').on('change', function(){ 

	$('#selected-campaign-template-preview-loader').css('display', 'block');
		var templateId = $(this).val(); 
		$.get( $url_home  + "/user/campaign/template/preview/"+templateId, function( data ) {    
			$('#selected-campaign-template-preview-container').css('display', 'block'); 
			$('#selected-campaign-template-preview-loader').css('display', 'none'); 
			// enable this to display the preview
			$("#selected-campaign-template-preview").html(data);  
		}); 
	}); 
}); 


function change_space_with_dash(str) 
{
	return str.replace(/\s+/g, '-').toLowerCase();  
}


$(document).ready(function(){

	$("#campaign-template-preview-container #campaign-template-preview").on('click', function(){
		var img_src = $(this).attr('data-src');
		$("#campaign-template-image-src").attr('src', img_src);
	});

	$("#campaign-template-preview-container #campaign-template-select").on('click', function(){

		var id	    = $(this).attr('data-template-id');

		// remove selected all as default
		$( "#campaign-template-preview-container .thumbnail" ).each(function() {
			$(this).attr('style', 'border:1px solid grey');
		});


		// set selected current clicked

		$("#template-thumbnail-" + id).attr('style', 'border:1px solid red');
		// assign id to a field

		$("#select-campaign-template").val(id);
		console.log(" id " + id);


		$('#campaign-template-next-button').prop('disabled', false);
		$("#campaign-template-next-button-text").css('display', 'none');

	});
});

