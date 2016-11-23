<?php  

/**
* 
*/
class FormController 
{

	private $model; 

	function __construct($model)
	{ 
		$this->model = $model;
	} 

	public function insertNewFormNow($formData = array()) 
	{  
		$form = new Form($this->model);
		return $form->insertOrUpdateByFormName($formData);
	}

	public function getSimpleEmbedded($folder_name) 
	{
		$form = new Form($this->model);
		return $form->getForm($folder_name)[0]['simple_embedded'];	
	}

}