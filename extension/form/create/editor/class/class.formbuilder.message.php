<?php
class FormBuilderMessage{
	

}

class SuccessMessage extends FormBuilderMessage{
	
	function setSuccessMessage($value){
		$this->success_message = $value;
	}
	
	function getSuccessMessage(){
		return isset($this->success_message) ? $this->success_message : null;
	}

}

class ErrorMessage extends FormBuilderMessage{
	
	function setErrorCode($value){
		$this->error_code = $value;
		return $this;
	}
	
	function getErrorCode(){
		return $this->error_code;
	}
	
	function setErrorMessage($value){
		$this->error_message = $value;
		return $this;
	}
	
	function getErrorMessage(){
		return isset($this->error_message) ? $this->error_message : null;
	}
	
}

class FormBuilderMessageFactory{
	
	function createError(){
		
		$new_error_message = new ErrorMessage();
		
		$this->error_messages[] = $new_error_message;
		
		return $new_error_message;
	}
	
	function getErrors(){
		return isset($this->error_messages) ? $this->error_messages : array();
	}

	function createSuccess(){

		$new_success_message = new SuccessMessage();
		
		$this->success_messages[] = $new_success_message;
		
		return $new_success_message;
	}
	
	function getSuccesses(){
		return isset($this->success_messages) ? $this->success_messages : array();
	}
	
	function getJsonMessages(){
		
		$message = array(); // default value required to prevent Notice: Undefined variable: message in json_encode
		
		// We don't return the error message object because json_encode would also return inherited properties
		foreach($this->getErrors() as $error_message){
			$message['error'][$error_message->getErrorCode()] = $error_message->getErrorMessage();
		}
		
		foreach($this->getSuccesses() as $success_message){
			$message['success'][] = $success_message->getSuccessMessage();
		}
		
		return json_encode($message);
		
	}
	
	function setSessionMessages(){
		
		unset($_SESSION['error'], $_SESSION['success']);
		
		foreach($this->getErrors() as $error_message){
			$_SESSION['error'][] = $error_message;
		}
		
		foreach($this->getSuccesses() as $success_message){
			$_SESSION['success'][] = $success_message;
		}
	}
	
	function getErrorsSession(){
		return isset($_SESSION['error']) ? $_SESSION['error'] : array();
	}

	function getErrorsSessionHtml(){
		
		if(!empty($_SESSION['error'])){
			
			$html = '';
			
			foreach($this->getErrorsSession() as $error_message){
				$html .= '<p>'.$error_message->getErrorMessage().'</p>';
			}
			
			$html = $html ? '<div class="error">'.$html.'</div>' : '';
			
			unset($_SESSION['error']);

			return $html;
		}
	}
	
	function getSuccessesSession(){
		return isset($_SESSION['success']) ? $_SESSION['success'] : array();
	}

	function getSuccessesSessionHtml(){

		if(!empty($_SESSION['success'])){

			$html = '';

			foreach($this->getSuccessesSession() as $success_message){
				$html .= '<p>'.$success_message->getSuccessMessage().'</p>';
			}

			$html = $html ? '<div class="success">'.$html.'</div>' : '';

			unset($_SESSION['success']);

			return $html;
		}
	}
	
	function getAndPrintErrorMessage(){
		if($this->getErrors()){
			echo $this->getJsonMessages();
			exit;
		}
	}
}
?>