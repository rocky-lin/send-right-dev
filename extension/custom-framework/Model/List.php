<?php  
class List1 { 

	private $model; 
	private $table_name = 'lists';

	function __construct($model) 
	{ 
		$this->model = $model; 
	}

	/**
	 * Get list by name
	 * @param $name
	 * @return mixed
	 */
	public function getListByName($name)
	{
		$this->model->select($this->table_name, '*', null , "  name = '$name'");  
		return $this->model->getResult();
	}


	/**
	 * get total contact by list id
	 * @param $listId
	 */
	public static function getTotalContact($listId)    
	{ 

		App\ListContact::find($listId)->count();
		// counte total list by id
	}
}