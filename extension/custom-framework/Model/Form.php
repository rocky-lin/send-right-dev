<?php  
class Form { 

	private $model; 
	private $table_name = 'forms';

	function __construct($model) 
	{ 
		$this->model = $model; 
	}  

	public function getSpecificFormByFormId() 
	{ 
	}

	public function getAllForms() 
	{ 
	}  
	
	public function insertNewForm() 
	{
		$this->model->insert(
			$this->table_name,
			array(
				'name' => 'This is the form name', 
				'folder_name' => 1  
			) 
		);
	}  
}