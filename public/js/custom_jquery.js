// date picker in campaign settings  
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
})
//
//$(document).ready(function(){
//
//	$("#list-search").change(function(){
//		alert("change");
//	});
//});