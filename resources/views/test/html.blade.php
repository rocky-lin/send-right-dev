<!DOCTYPE html>
<html>
<head>
	<title> This is the html test </title>

	 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body> 




<div class="container"> 
	<div class="form-group">
	  <label for="usr">Name:</label>
	  <input type="text" class="form-control" id="usr">
	</div>
	<div class="form-group">
	  <label for="pwd">Password:</label>
	  <input type="password" class="form-control" id="pwd">
	</div>


 
      {!! Form::open(['method'=>'post', 'url'=>['test', 2, 23, 132]]); !!}
		<div class="form-group">  
	 		{!! Form::label('email', 'please enter your email', ['class'=>'']) !!} 
	     	{!!  Form::input('text', 'email', 'mail@youdomain.com', ['class'=>'form-control']) !!} 
		</div> 
		<div class="form-group">
		    {!!  Form::textarea('message', 'this is your message', ['class'=>'form-control', 'placeholder'=>'please add your message here']) !!}
	  	 	{!!  Form::submit('submit form', ['id'=>'submit']) !!}
		</div>  
	  {!! Form::close() !!}

</div>
</body>
</html>
