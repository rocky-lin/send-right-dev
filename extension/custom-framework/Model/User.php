<?php   

class User  {   

	private $model; 
	private $table_name = 'forms';

	function __construct($model) 
	{ 
		$this->model = $model; 
	}  

	public function getAllUser() 
	{  
		$this->model->select($this->table_name,'*',NULL);  
		$res = $this->model->getResult(); 
		return $res; 
	}

	public function getSpecificUserById($user_id) 
	{
		$this->model->select($this->table_name,'*',NULL, " id=" . $user_id);  
		$res = $this->model->getResult(); 
		return $res; 
	} 
}


