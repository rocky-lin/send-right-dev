<?php  
class ListContact { 

	private $model; 
	private $table_name = 'list_contacts';

	function __construct($model) 
	{ 
		$this->model = $model; 
	}

	/**
	 * add new form list
	 * @param $formListEntry
	 * @return mixed
	 */
  	public function addNewFromList($formListEntry)
	{
  		
  		$formListEntry['created_at'] = getCurrentDateTime(); 
		$formListEntry['updated_at'] = getCurrentDateTime(); 

		$this->model->insert(
			$this->table_name, 
			$formListEntry
		);	

		return $this->model->getResult();
  	}
}