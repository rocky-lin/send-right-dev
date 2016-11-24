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
		//
	}

	public function getAllForms()
	{
		//
	}

	/**
	 * get specific form by folder name
	 * @param $folder_name
	 * @return mixed
	 */
	public function getForm($folder_name)
	{
		$this->model->select($this->table_name, '*', null , ' folder_name = ' . $folder_name);
		return $this->model->getResult();
	}

	/**
	 * Insert new data or update by form name
	 * @param array $formData
	 * @return mixed
	 */
	public function insertOrUpdateByFormName($formData = array()) 
	{
		$formData['updated_at'] = getCurrentDateTime();

		if(empty($this->getForm($formData['folder_name']))){

			$formData['created_at'] = getCurrentDateTime(); 
			$this->model->insert(
				$this->table_name, 
				$formData
			);
			return $this->model->getResult()[0];
		} else {

			$this->model->update($this->table_name,$formData, ' folder_name = ' . $formData['folder_name']);
			return $this->model->getResult()[0];
		}
	}  

	 
}