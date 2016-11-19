<?php
 
require ('../../../../autoload.php');    
  
$formController = new FormController(new Model);
$form_id  = 1;


$data =  '<iframe width="560" height="560" src="http://localhost/rocky/send-right-dev/extension/form/create/editor/forms/' . $form_id . '/index.php" frameborder="0" ></iframe>';
 

print_r($data1); 
$formController->insertNewFormNow(
  	[
  		'account_id'=>1, 
	  	'folder_name'=>2, 
	  	'name'=>'form name', 
	  	'config_email'=>  'mrjesuserwinsuarez@gmail.com',
	  	'simple_embedded'=>  mysql_real_escape_string($data),
  	] 
);   
?>