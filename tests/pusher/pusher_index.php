<!DOCTYPE html>
<html>
<head>

  <title>Pusher Test</title> 
  <script src="https://js.pusher.com/3.2/pusher.min.js"></script> 
  <script> 

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true; 

    var pusher = new Pusher('5d4540ae0b86caedd37a', {
      encrypted: true
    }); 

    var channel = pusher.subscribe('my-channel');

    channel.bind('nicd34245213', function(data) {  
        console.log("show a popup now");
    });


  </script>
</head>
<body>

  Load now
  
</body>
</html>