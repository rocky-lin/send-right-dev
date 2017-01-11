<?php
require ('../../../../autoload.php');    

$json_message['form_id'] = $form_id;
$folderName 			 = $form_id; 
 

// get selected list id   
	$list = new List1(new Model()); 
	$listId = $list->getListByName($_POST['list_name'])[0]['id']; 



// check if update or not


// $isListExist = $list->isListExist($folderName, $listId); 
// if(true === $isListExist) {
// 	print "list exist"; 
// } else {
// 	print "list is not exist";
// }












//$$_SESS['formEntryStep1']['name'];
//$_SESSION['formEntryStep1']['id'];
// insert new form
$jsonDecoded = json_decode($_POST['json_export'], true);
//print_r_pre($jsonDecoded);
$account_id = $_SESSION['account_id'];
$formController = new FormController(new Model);
$formId = $formController->insertNewFormNow(
  	[

  		'account_id'=>$account_id, 
	  	'folder_name'=>$form_id, 
	  	'name'=>$jsonDecoded['form_name'], 
	  	'config_email'=>$jsonDecoded['config_email_address'],
	  	'simple_embedded'=> $_SESSION['extension']['site_url'] . '/extension/form/create/editor/forms/' . $form_id . '/index.php',
  	] 
);    


// print "This is the list name " . $_POST['list_name']; 
// $selectedList = 'Francisco Bauch'
 

// $formId
// $folderName 

$formList = new FormList(new Model());
$isListExist = $formList->addOrUpdate(['form_id'=>$formId, 'folder_name'=>$folderName, 'list_id' => $listId]); 

// $formList->addNewFormList(['form_id'=>$formId, 'folder_name'=>$folderName, 'list_id'=>$listId]);


// print  " $formId  $folderName $listId";


use App\AutoResponse;
// set auto response and insert
if(!empty($_SESSION['formEntryStep1']['autoresponse']['id'])) {
	$autoResponseData = [
			'campaign_id' => $_SESSION['formEntryStep1']['autoresponse']['id'],
			'table_name' => 'forms',
			'table_id' => $formId,
	];
	AutoResponse::createNow($autoResponseData);
}