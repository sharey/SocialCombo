<?php

class login_model extends Model {

	function login_model() {
		parent::Model();
	}

	// CHECK IF LOCALHOST COOKIE IS PRESENT OR FETCH IT FROM DB
	function Get_Cookie() {

		$CI =& get_instance();
		$CI->load->model('msapp_database_model');

		// THIS LOCALHOST COOKIE IS SET AUTOMATICALLY WHEN USER ACCESS THE WEBPAGE
		$cookie = $this->Get_Facebook_Cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);

		// THIS COOKIE ARRAY IS BUILT FROM THE DB VALUES THAT WE STORED FROM USER SESSION IF LOCALHOST COOKIE IS NOT FOUND
		if(!$cookie) {
			$user_details = $CI->msapp_database_model->get_user(@$_COOKIE['lh_userid'], 1);

			//*
			if(@$user_details['user_id'])		$cookie['uid']			= $user_details['user_id'];
			if(@$user_details['access_token'])	$cookie['access_token'] = $user_details['access_token'];
			//*/
		}

		// UPDATE THE ACCES TOKEN STORED INTO TABLE IF NEEDED
		if(@$cookie['access_token'] && @$cookie['uid']) {

			// SET USER COOKIE EXPIRING IN 24 HOURS BCOZ OUR WEBSITE DOESNT STORE USER ID WHICH WOULD HELP US DETERMINE THE USER NEXT TIME HE VISITS THE WEBSITE.
			if(!@$_COOKIE['lh_userid'])	setcookie("lh_userid",$cookie['uid'], time()+3600*24);

			// INSERT ACCESS TOKEN AND SESSION KEY INTO DB HERE..
			$db_uid = $CI->msapp_database_model->replace_user(array(
				'user_id'			=> $cookie['uid'],
				'access_token'		=> $cookie['access_token'],
				'social_site_flag'	=> 1
			));
		}

		//echo "<pre>".print_r($cookie);

		if($cookie)	return $cookie;
		else		return false;
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