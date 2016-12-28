<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Product;

class Pay2GoModel extends Model
{  

	protected $status; 
	protected $response = [];
	protected $productName = '';
	protected $productAmount = '';
	protected $amount = 0;


	public function loadPaymentResponse($response) 
	{ 
		//		print "<h2>Thank you page!</h2>";
//				print "<pre> post";
 		$response = json_decode($response, true); 
 		$response['Result'] = json_decode($response['Result'], true); 
//		 		print "</pre>";
 		$this->response = $response;

//				print_r($this->response);

//				print_r(serialize($this->response));
//		print "</pre>";

 		$this->status = strtolower($response['Status']);  
 		$this->productName = strtolower($response['Result']['ItemDesc']);
 		$this->productAmount = strtolower($response['Result']['Amt']);
	}


	public function getStatus() { return $this->status; }
	public function getProductName() { return $this->productName; }
	public function getProductId() { return Product::getProductByProductName($this->productName)->id; }
	public function getProductAmount() { return $this->productAmount; }
	public function getArrayResponse() { return $this->response; }
	public function getSerializedResponse() {return serialize($this->response);}
	public function isPaymentSuccess() { return ($this->getStatus() == 'success') ? true : false;  }

}
