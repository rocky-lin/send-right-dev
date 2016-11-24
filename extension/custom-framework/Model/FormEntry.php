<?php  
class FormEntry { 

	private $model; 
	private $table_name = 'form_entries';

	function __construct($model) 
	{ 
		$this->model = $model; 
	}

	/**
	 * Add new form entry
	 * @param array $formData
	 * @return mixed
	 */
	public function addNewFormEntry($formData = array()) 
	{    
		$formData['created_at'] = getCurrentDateTime(); 
		$formData['updated_at'] = getCurrentDateTime(); 

		$this->model->insert(
			$this->table_name, 
			$formData
		);

		return $this->model->getResult();
	}   
}