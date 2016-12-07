<?php
// header('location:../user/form');    
require('autoload.php'); 
$usr = new User(new Model()); 
$frm = new Form(new Model());  
// $formController = new FormController(new Model());
 
// print_r($formController->getFormByFolderName(24));
 
print htmlspecialchars('<iframe width="560" height="560" src="http://localhost/rocky/send-right-dev/extension/form/create/editor/forms/24/index.php" frameborder="0" ></iframe>');
// print "<pre>";   
	// $frm->insertNewForm(); 
	// $users = $usr->getAllUser(); 
	// $user = $usr->getSpecificUserById(1); 
	// print_r($user);  
// print "</pre>";  

// $usr->getAllUser(); 
// $db = new Model();
// $db->connect();
// $db->select('users','*',NULL); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
// $res = $db->getResult();
// print_r($res);


 
