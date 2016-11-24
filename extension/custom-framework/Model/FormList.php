<?php  
class FormList { 

	private $model; 
	private $table_name = 'form_lists';

	function __construct($model) 
	{ 
		$this->model = $model; 
	}

	/**
	 * Get form list by folder name
	 * @param $folderName
	 * @return mixed
	 */
  	public function getFormListIdByFolderName($folderName) 
  	{ 

		$this->model->select($this->table_name, '*', null , ' folder_name = ' . $folderName); 
		return $this->model->getResult()[0]['list_id']; 
  	}

	/**
	 * get form list folder name and list id
	 * @param $folder_name
	 * @param $list_id
	 * @return mixed
	 */
	public function getFormList($folder_name, $list_id)
	{
		$this->model->select($this->table_name, '*', null , ' folder_name = ' . $folder_name . ' and list_id = ' . $list_id );
		return $this->model->getResult();
	}

	/**
	 * Add or updated list folder name and list id
	 * @param $entry
	 * @return mixed
	 */
  	public function addOrUpdate($entry) 
  	{ 
		$entry['updated_at'] = getCurrentDateTime();

		if(empty($this->getFormList($entry['folder_name'], $entry['list_id']))){

			$entry['created_at'] = getCurrentDateTime();

			$this->model->insert(
				$this->table_name,
				$entry
			);

			return $this->model->getResult()[0];

		} else {

			$this->model->update($this->table_name,$entry, ' folder_name = ' . $entry['folder_name'] . ' and list_id = ' . $entry['list_id'] ); 
			return $this->model->getResult()[0];

		}
  	}

	/**
	 * add new form list
	 * @param $entry
	 * @return mixed
	 */
  	public function addNewFormList($entry) 
  	{  
  		$entry['created_at'] = getCurrentDateTime(); 
		$entry['updated_at'] = getCurrentDateTime(); 
		$this->model->insert(
			$this->table_name, 
			$entry
		);	 
		return $this->model->getResult()[0];
  	}
	public function isListExist($folderName, $listId) 
	{
		print "$folderName, $listId";
		$this->model->select($this->table_name, '*', null , " folder_name = '$folderName'");  
		return $this->model->getResult(); // (count($this->model->getResult() > 0)) ? true : false; 
	}
}