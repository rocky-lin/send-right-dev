// user contacts 
$(function(){
	console.log("contact jquery loaded!...");  
 
	$('[data-toggle="popover"]').popover();

	$('input:radio').click(function(){ 
		var pullRight =  $(this).attr("rel");
		 // $("."+pullRight).hide();
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
	

	 // $('.showDatetime').on('keyup', function() {
	 // 	alert("hello");
  //      // var showDatetime = $(this).toString();
  //   });
  //    
$('.showDatetime').on("change", function() {
// var date = new Date('6/29/2011 4:52:48 PM UTC');
// date.toString() // "Wed Jun 29 2011 09:52:48 GMT-0700 (PDT)"
	var dateTime = $(this).val();

	// var d = new Date(dateTime); 
	alert(dateTime);



	 // var showDatetime1 = dateTime.toString();
	 // console.log(showDatetime1);
  //  	 var res = showDatetime1.split("T");
  //   // var d = new Date(res[0]);
  //  	 // alert(d.toString());
  //  	 // 12:00:00.000
  //  	 var dateHr = res[1];
  //  	 var dateHrs = dateHr.split(':');

  //  	 // alert(dateHrs[0]);
  //  	 if(dateHrs[0] > 12){
  //  	 	echo "pm";
  //  	 }
  //  	 
  //  	 
 	
 	 // $(".dateConverted").text(res[0] + " at " + res[1]); 

 	flatpickr(".flatpickr", {
    enableTime: true,

    // create an extra input solely for display purposes
    altInput: true,
    altFormat: "F j, Y h:i K"
});
  
});




});
  