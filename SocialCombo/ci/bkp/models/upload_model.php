<?php

class upload_model extends Model {

	function signRequest(&$args, $secret)
	{
		//echo "app secret:".$secret."";
		ksort($args);
		$sig = '';
		foreach($args as $k => $v)
		{
		$sig .= $k . '=' . $v;
		}

		$sig .= $secret;
		//echo "signatureRAW:".$sig."---";
		$args['sig'] = md5($sig);
		//echo "signature:".md5($sig)."---";
	}

	function Call_My_API($method, $version, $fb_app_key, $fb_secret, $uid, $cid, $format, $file) {

		$args = array(
		  'method'	=> $method,
		  'v'		=> $version,
		  'api_key' => $fb_app_key,
		  'uid'		=> $uid,
		  'call_id' => $cid,
		  'format'	=> $format
		);

		$this->signRequest($args, $fb_secret);
		$args[basename($file)] = '@' . realpath($file);

		$curl_response = $this->Curl_Call('http://api.facebook.com/restserver.php?method=photos.upload', $args);

		return $curl_response;
	}

	function Call_Megha_API($access_token, $file) {

		$file_stream = file_get_contents($file);

		// PASS AS multipart/form-data
		$args = array(
		  'access_token' => $access_token
		  //'photo_stream' => $file_stream
		);

		// PASS application/x-www-form-urlencoded
		//$args = "access_token=".$access_token;

		//$curl_response = $this->Curl_Call('http://192.168.0.101:8080/MyProject/facebook', $args); // Megha
		$curl_response = $this->Curl_Call('http://192.168.0.105:8080/coen316proj/photos/shabbir', $args); // Shabbir

		return $curl_response;
	}

	// CURL CALL TO POST THE DATA
	function Curl_Call($url, $args) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
		$data = curl_exec($ch);

		//echo "<pre>".print_r(curl_getinfo($ch));

		return $data;
	}


	// GET THE MY WEBSERVER COOKIE AND PARSE IT TO GET ACCESS TOKEN, SESSION KEY ETC.
	function Get_Facebook_Cookie($app_id, $application_secret) {
	  $args = array();

	  // LOCALHOST COOKIE CONTAIN ALL DATA. THE SIG VARIABLE IS MD5 OF ALL OTHER VARIABLES AND SECRET KEY
	  @parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
	  @ksort($args);
	  $payload = '';
	  foreach ($args as $key => $value) {
		if ($key != 'sig') {
		  $payload .= $key . '=' . $value;
		}
	  }
	  if (md5($payload . $application_secret) != @$args['sig']) {
		return null;
	  }
	  return $args;
	}

}

?>