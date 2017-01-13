
$(document).ready(function(){ 
	// click the button in mobile optin page
 	$('.button-1').on('click', function(){

 
		var emailBody = $('#optin_email_content').val(); 
		var subject   = $('#optin_email_subject').val(); 
		var link      = $('#optin_popup_link').val(); 
		var name      = $('#optin_email_to_name').val(); 
		var email     = $('#optin_email_to_mail').val();  
        document.location = "mailto:"+email+"?subject="+subject+"&body="+emailBody+"&header=From:James <webmaster@example.com>"; 
 	}); 
}); 