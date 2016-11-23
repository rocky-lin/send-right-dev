<?php  
class FormList { 

	private $model; 
	private $table_name = 'form_lists';

	function __construct($model) 
	{ 
		$this->model = $model; 
	}    

  	public function getFormListIdByFolderName($folderName) 
  	{ 

		$this->model->select($this->table_name, '*', null , ' folder_name = ' . $folderName); 
		return $this->model->getResult()[0]['list_id']; 
  	}
	public function getFormList($folder_name, $list_id) {
		// return 
		$this->model->select($this->table_name, '*', null , ' folder_name = ' . $folder_name . ' and list_id = ' . $list_id );
		// print_r($this->model->getResult());  
		return $this->model->getResult();
	} 
  	public function addOrUpdate($entry) 
  	{ 
		$entry['updated_at'] = getCurrentDateTime();  
		if(empty($this->getFormList($entry['folder_name'], $entry['list_id']))){ 
			// print "not exist";
			$entry['created_at'] = getCurrentDateTime(); 
			$this->model->insert(
				$this->table_name, 
				$entry
			);	 
			return $this->model->getResult()[0];
		} else { 
			// print "exist";
			$this->model->update($this->table_name,$entry, ' folder_name = ' . $entry['folder_name'] . ' and list_id = ' . $entry['list_id'] ); 
			return $this->model->getResult()[0];
		}
  	}

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