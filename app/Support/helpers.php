<?php 
if(!function_exists('test')) {
	function test() 
	{
		print "this is the test helper functionality";
	}  
}
function print_r_pre($string, $title=null)
{

	if(!empty($title)){
		print "<br> " . $title . '<br>';
	}

	print "<pre>";
		print_r($string);
	print "</pre>";
}
function print_r_pre_die($string)
{
	print "<pre>";
		print_r($string);
	print "</pre>";
	exit;
}
