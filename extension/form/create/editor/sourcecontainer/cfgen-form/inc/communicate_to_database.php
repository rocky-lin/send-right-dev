<?php   
	require ('../../../../../../../autoload.php');  

	if($json_response['status'] == 'ok') {    
		
	// get folder name
	$folderName = explode('-', $_POST['form_values'][0]['element_id'])[2];  

	// set correct contact entry
	$contact = new Contact(new Model()); 
	$formEntries = $contact->setFormVluesFromSubscriberEntry($_POST['form_values']);  
	$formEntries['account_id'] = $_SESSION['account_id'];  
	$formEntries['type'] = 'contact';


	// insert new contact to contact table
	$contactId = $contact->addNewContact($formEntries); 
 	
 	// get list id in form list
 	$formList = new FormList(new Model()); 
    $listId = $formList->getFormListIdByFolderName($folderName);
  
	// insert new list contact 
	$listContact = new ListContact(new Model());
	$isInsert = $listContact->addNewFromList(['list_id'=>$listId, 'contact_id'=>$contactId]);  

	// Insert new back up, form entry
	$formEntry = new FormEntry(new Model()); 
	$formEntry->addNewFormEntry(['content'=>mysql_real_escape_string(serialize($_POST['form_values'])), 'folder_name'=>$folderName]);   
} 