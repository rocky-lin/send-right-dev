// user contacts 
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

	// preview desktop 
	// Assign handlers immediately after making the request,
// and remember the jqxhr object for this request
	$('#previewDesktop').on('click', function(){
		// alert('clicked');
		// 
		var campaignId = $(this).attr('campaign-id'); 

		  console.log("campaign preview "  + campaignId);
		var jqxhr = $.get( "http://localhost/rocky/send-right-dev/extension/campaign/preview.php?campaignId=" + campaignId, function(data) { 
		  	$('#previewDesktopDisplay').html(data);
		})
	})
	$('#previewMobile').on('click', function(){
		// alert('clicked');
		// 
		var campaignId = $(this).attr('campaign-id'); 

		  console.log("campaign preview "  + campaignId);
		var jqxhr = $.get( "http://localhost/rocky/send-right-dev/extension/campaign/preview.php?campaignId=" + campaignId, function(data) { 
		  	$('#previewMobileDisplay').html(data);
		})
	})
})
//
//$(document).ready(function(){
//
//	$("#list-search").change(function(){
//		alert("change");
//	});
//});