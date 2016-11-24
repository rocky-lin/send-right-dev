<?php  
class Contact { 

	private $model; 
	private $table_name = 'contacts';

	function __construct($model) 
	{ 
		$this->model = $model; 
	}

	/**
	 * set valid key entry for contact
	 * @param $formEntries
	 * @return array
	 */
	public function setFormVluesFromSubscriberEntry($formEntries) {
		$valueArray = array();
		foreach ($formEntries as $formEntry) {
			$field = str_replace(' ', '_',  strtolower($formEntry['elementlabel_value']));
			$value  = $formEntry['element_value'];
			if($this->setFormCorrectKey($field) != false) {
			 	$valueArray[$this->setFormCorrectKey($field)] = $value;
			} 
		}
		return $valueArray;
	}

	/**
	 * set valid key entry for contact
	 * @param $formEntriesField
	 * @return mixed
	 */
	public function setFormCorrectKey($formEntriesField) {
		$formFields = ['first_name', 'last_name', 'email', 'location', 'telephone_number', 'phone_number'];
		foreach ($formFields as $formField) { 
			if(strrpos($formEntriesField, $formField) > -1){ 
				return $formField;
			}
		} 
	}

	/**
	 * add new contact
	 * @param $contactEntry
	 * @return mixed
	 */
	public function addNewContact($contactEntry)
	{  
		$contactEntry['created_at'] = getCurrentDateTime(); 
		$contactEntry['updated_at'] = getCurrentDateTime(); 

			$this->model->insert(
				$this->table_name, 
				$contactEntry
			);	 
			return $this->model->getResult()[0];
		// print_r($contactEntry);
		// insert new contact 
		// return list id 
	}
}