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

	public function getForm($folder_name) {
		// return 
		$this->model->select($this->table_name, '*', null , ' folder_name = ' . $folder_name);
		// print_r($this->model->getResult());  
		return $this->model->getResult();
	} 
 
	public function insertOrUpdateByFormName($formData = array()) 
	{  
		
		$formData['updated_at'] = getCurrentDateTime(); 


		// print "<pre>";
		// 	print_r($formData); 
		// print "</pre>"; 
		if(empty($this->getForm($formData['folder_name']))){
			// print "<br>insert data";
			// 
			// 
			$formData['created_at'] = getCurrentDateTime(); 
			$this->model->insert(
				$this->table_name, 
				$formData
			);	

			return $this->model->getResult()[0];
		} else {
			// print "<br> update data";
			$this->model->update($this->table_name,$formData, ' folder_name = ' . $formData['folder_name']);

			return $this->model->getResult()[0];
		}
	}  

	 
}