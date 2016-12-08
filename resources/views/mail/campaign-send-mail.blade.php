<!DOCTYPE html>
<html>
<head>
	<title> Preview </title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="{{url('/extension/campaign/assets/css/email-editor.bundle.min.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{url('/extension/campaign/assets/css/demo.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{url('/extension/campaign/assets/css/colorpicker.css')}}" />
	<link rel="stylesheet" type="text/css" href="http://cdn.tinymce.com/4/skins/lightgray/content.inline.min.css"/> 
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"></script> 
	<style type="text/css" media="screen"> 
		.sortable-row-actions { 
			display:none;
		} 
	</style>
</head>
<body>
	Hi {{$contact['full_name']}},   
	 <?php  
		$content = htmlspecialchars_decode(stripslashes($campaign['content']));
		$content = str_replace('contenteditable="true"', '', $content);
		print $content; 
	 ?>
 	 {{-- {!!htmlspecialchars_decode(stripslashes($campaign['content']))!!} --}}
</body>
</html>