<?php 
if(!function_exists('test')) {
	function test() 
	{
		print "this is the test helper functionality";
	}  
}

if(!function_exists('print_r_pre')) {
	function print_r_pre($string, $title = null)
	{

		if (!empty($title)) {
			print "<br> " . $title . '<br>';
		}

		print "<pre>";
		print_r($string);
		print "</pre>";
	}
}

if(!function_exists('print_r_pre_die')) {

	function print_r_pre_die($string)
	{
		print "<pre>";
		print_r($string);
		print "</pre>";
		exit;
	}
}
if(!function_exists('isValidEmail'))
{
	function isValidEmail($email)
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return false;
		} else {
			return true;
		}
	}
}

if(!function_exists('changeDashToSpaceUcLetter')) {
	function changeDashToSpaceUcLetter($string)
	{
		$string = str_replace('_', ' ', $string);
		return ucfirst($string);
	}
}

/**
 * @src http://stackoverflow.com/questions/2138527/php-curl-http-post-sample-code
 * @param $postData
 * @return mixed
 */
if(!function_exists('curlPostRequest')) {
	function curlPostRequest($postData, $url)
	{
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

		// execute!
		$response = curl_exec($ch);

		// close the connection, release resources used
		curl_close($ch);

		// do anything you want with your response
		var_dump($response);

		return json_decode($response, true);
	}
}

/**
 * @src http://codular.com/curl-with-php
 * @param $getData
 * @param $url
 * @return mixed
 */
if(!function_exists('curlGetRequest')) {
	function curlGetRequest($getData, $url, $type="")
	{
		if($type!='full') {
			$getData = http_build_query($getData, "", "&");
			$url = $url . '?' . $getData;
		}

		//print " url " . $url;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($ch);

		curl_close($ch);

		return json_decode($output, true);
	}
}

if(!function_exists('addpadding')) {

	function addpadding($string, $blocksize = 32)
	{
		$len = strlen($string);
		$pad = $blocksize - ($len % $blocksize);
		$string .= str_repeat(chr($pad), $pad);
		return $string;
	}
}
if(!function_exists('time_elapsed_string')) {

	function time_elapsed_string($datetime, $full = false)
	{
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
				'y' => 'year',
				'm' => 'month',
				'w' => 'week',
				'd' => 'day',
				'h' => 'hour',
				'i' => 'minute',
				's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
}


if(!function_exists('human_readable_date_time')) {
	function human_readable_date_time($date)
	{
		return date("F j, Y, g:i a", strtotime($date));
	}
}

if(!function_exists('redirect')) {
	function redirect($url)
	{
		print "-----test-----";
		?>
			<script>
				document.location = '<?php echo $url ?>';
			</script>
		<?php
	}
}




