<?php
/**********************************************************************************
 * Contact Form Generator is (c) Top Studio
 * It is strictly forbidden to use or copy all or part of an element other than for your 
 * own personal and private use without prior written consent from Top Studio http://topstudiodev.com
 * Copies or reproductions are strictly reserved for the private use of the person 
 * making the copy and not intended for a collective use.
 *********************************************************************************/

class TopStudio_Tools{

	
	function __construct(){

		
		$this->license_dir_path = dirname(__FILE__).'/../forms/';
		$this->license_filename = 'license.php';
		$this->license_filename_path = $this->license_dir_path.$this->license_filename;
	}
	
	function loadCurlFile($url, $options = array()){
		
		$res = false;
		
		if(extension_loaded('curl')){
			
			$curl = @curl_init($url);
			
			@curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // http://codecanyon.net/forums/thread/envato-api-is-not-working-for-me-anymore/114284?page=6#1004051
			
			@curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // ssl connection for google api
			
			@curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // for gravatar: http://www.gravatar.com/xxx.xml redirects to another xml url

			@curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

			if(isset($options['referer'])){
				
				$referer = (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
				
				if($referer){
					@curl_setopt($curl, CURLOPT_REFERER, $referer);
				}
			}
				
			if(isset($options['force_referer'])){
				
				$referer = 'http'.((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : '').'//'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
				
				if($referer){
					@curl_setopt($curl, CURLOPT_REFERER, $referer);
				}
			}
				

			if(isset($options['method'])){
				
				if($options['method'] == 'post'){
					@curl_setopt($curl, CURLOPT_POST, true);
				}
			}
				
			$res = @curl_exec($curl);
			
			@curl_close($curl);
				
			//echo '<p>CURL RES:'.$res.'</p>';
			
		}
		
		return($res);
	}

	function validatePurchaseCode($buyer, $purchasecode){
		
		$response = '';
		
		$buyer = trim($buyer);
		
		$purchasecode = trim($purchasecode);
		
		$url = 'http://topstudiodev.com/verifypurchase/formgenerator.php?buyer='.$buyer.'&purchasecode='.$purchasecode;
		
		// echo $url;
		
		if(extension_loaded('curl')){ // curl first to get the referer
			$response = $this->loadCurlFile($url, array('referer'=>true));
		} else{
			if(ini_get('allow_url_fopen')){
				$response = @file_get_contents($url);
			}
		}
		
		if($response){
			$response = json_decode($response, true);
		}
		
		// var_dump($response);
		
		return($response);		
	}
	

	function licenseFileExists(){
		
		/*
		unset($_SESSION['cfgenwp_licensefileexists']);
		*/
		
		if(/*isset($_SESSION['cfgenwp_plugin_dir']) && */is_file($this->license_filename_path))
		{
			include($this->license_filename_path); // include, not require_once
			
			if(isset($topstudio_item_license_buyer) && isset($topstudio_item_license_purchasecode)){
			
				//$_SESSION['cfgenwp_licensefileexists'] = true;
				return true;
			} else{
				return false;
			}
		} else{
			return false;
		}
	}
	
	function writeLicenseFile($buyer, $purchasecode){
		// @: fopen Permission denied > fwrite() expects parameter 1 to be resource, boolean given > fclose() expects parameter 1 to be resource, boolean given
	
		$file = @fopen($this->license_filename_path, 'w+');
		
		if(is_resource($file)){		
			$c = '<?php'."\r\n";
			$c .= '$topstudio_item_license_buyer = \''.addcslashes($buyer, "'").'\';'."\r\n";;
			$c .= '$topstudio_item_license_purchasecode = \''.addcslashes($purchasecode, "'").'\';'."\r\n";;
			$c .= '?>';

			fwrite($file, $c);
			fclose($file);
		}
		
		// On windows based servers, the file may not be written even if the directory is writable
		// We set a flag that will be catched in order to display the proper error message
		if(!file_exists($this->license_filename_path)){
			$this->unable_to_write_license_file = true;
		}
	}
	
	function sortArrayBy($a, $b, $key){
		return strcasecmp($a[$key], $b[$key]);
	}	
}
?>