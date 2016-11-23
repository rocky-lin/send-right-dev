<?php
 session_start();

require ('../../../../autoload.php');    
  
$folderName = 32;
$listId = 7; 

$formList = new FormList(new Model()); 
$isListExist = $formList->addOrUpdate(['folder_name'=>$folderName, 'list_id' => $listId]); 
print_r($isListExist);
if(true === $isListExist) {
	print "list exist"; 
} else {
	print "list is not exist";
}





  exit; 
$formController = new FormController(new Model);
$form_id  = 1;


$data =  '<iframe width="560" height="560" src="'. $_SESSION['extension']['site_url'] . '/extension/form/create/editor/forms/' . $form_id . '/index.php" frameborder="0" ></iframe>';
 

print_r($data); 
$formController->insertNewFormNow(
  	[
  		'account_id'=>1, 
	  	'folder_name'=>2, 
	  	'name'=>'form name', 
	  	'config_email'=>  'mrjesuserwinsuarez@gmail.com',
	  	'simple_embedded'=>  mysql_real_escape_string($data),
  	] 
);    


$formId = 3; 
$folderName = 2; 
$listId = 1;
// insert new form list

$selectedList = 'Francisco Bauch'; 
$list = new List1(new Model()); 
$listId = $list->getListByName($selectedList)[0]['id'];
 
 
// $formId
// $folderName
$formList = new FormList(new Model());
 $formList->addNewFormList(['form_id'=>$formId, 'folder_name'=>$folderName, 'list_id'=>$listId]);


// print_r( $formListId);
// print "form list id " . $formListId;


