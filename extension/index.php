<?php
// header('location:../user/form');    
require('autoload.php'); 
$usr = new User(new Model()); 
$frm = new Form(new Model()); 

print "<pre>";  

	$frm->insertNewForm(); 
	// $users = $usr->getAllUser(); 
	// $user = $usr->getSpecificUserById(1); 
	// print_r($user);  
print "</pre>";  

// $usr->getAllUser(); 
// $db = new Model();
// $db->connect();
// $db->select('users','*',NULL); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
// $res = $db->getResult();
// print_r($res);


 
