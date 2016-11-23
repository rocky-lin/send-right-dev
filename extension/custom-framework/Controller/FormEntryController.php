<?php   
/**
* 
*/
class FormEntryController 
{

	private $model; 

	function __construct($model)
	{ 
		$this->model = $model;
	} 

	public function insertNewFormEntryNow($formEntryData = array()) 
	{  

		print_r($formEntryData );
	 	$formEntry = new FormEntry(new Model()); 
		$formEntry->addNewFormEntry($formEntryData); 
	}

	 

}