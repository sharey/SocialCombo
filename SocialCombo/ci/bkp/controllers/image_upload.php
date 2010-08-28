<?php

class Image_Upload extends Controller {

	function Image_Upload()
	{
		parent::Controller();
	}

	function index()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->model(array('upload_model', 'msapp_database_model'));

		$view_data = array();

		$success_msg	= "";
		$cookie			= array();

		// THIS LOCALHOST COOKIE IS SET AUTOMATICALLY WHEN USER ACCESS THE WEBPAGE
		$cookie = $this->upload_model->Get_Facebook_Cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);

		// THIS COOKIE ARRAY IS BUILT FROM THE DB VALUES THAT WE STORED FROM USER SESSION IF LOCALHOST COOKIE IS NOT FOUND
		if(!$cookie) {

			$user_details = $this->msapp_database_model->get_user(@$_COOKIE['lh_userid']);

			//*
			if(@$user_details['user_id'])		$cookie['uid']			= $user_details['user_id'];
			if(@$user_details['access_token'])	$cookie['access_token'] = $user_details['access_token'];
			if(@$user_details['session_key'])	$cookie['session_key']	= $user_details['session_key'];
			//*/
		}

		// MAKE SURE YOU HAVE COOKIE FOR USER AND THEN RETRIEVE THE USER INFORMATION USING BELOW GRAPH API
		if(@$cookie['access_token'] && @$cookie['uid']) {

			// SET USER COOKIE EXPIRING IN 24 HOURS BCOZ OUR WEBSITE DOESNT STORE USER ID WHICH WOULD HELP US DETERMINE THE USER NEXT TIME HE VISITS THE WEBSITE.
			setcookie("lh_userid",$cookie['uid'], time()+3600*24);

			// INSERT ACCESS TOKEN AND SESSION KEY INTO DB HERE..
			$db_uid = $this->msapp_database_model->replace_user(array(
				'user_id'		=> $cookie['uid'],
				'access_token'	=> $cookie['access_token'],
				'session_key'	=> $cookie['session_key']
			));

			// OK SO GETTING USER INFORMATION FROM FB PART WORKS WELL..
			$user = @json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$cookie['access_token']));
			//echo "<br>Name: ".$user->name;

			// AFTER UPLOADING IMAGE
			if (@$_POST['Submit']) {

				if($_FILES) {

					$file_details = $_FILES['image_to_upload'];

					$file_url	= "images/".$file_details['name'];

					if((int)$file_details['size'] > 0 && (int)$file_details['error'] === 0 && trim($file_details['tmp_name']) != '') {

						// CALL THE REST FB API ONLY IF THE IMAGE IS UPLOADED CORRECTLY
						if(move_uploaded_file($file_details['tmp_name'], $file_url)) {

							// NOW CALL FB API TO UPLOAD PHOTOS. CALL IT FROM HERE DIRECTLY
							$ver = '1.0';
							$cid = microtime(true);
							$file= $file_url;

							$curl_response = $this->upload_model->Call_My_API('photos.upload', $ver, FACEBOOK_APP_ID, FACEBOOK_SECRET, $user->id, $cid, 'XML', $file);

							// MEGHAS API JAVA WEB SERVICE CALL
							//$curl_response = $this->upload_model->Call_Megha_API($cookie['access_token'], $file);

							if(@$curl_response) $view_data['success_msg'] = "Image has been successfully uploaded to your profile.";

						}
					}
				}
			}
		}

		$view_data['cookie']	= $cookie;
		$view_data['user']		= @$user;

		//echo "<pre>".print_r($view_data);exit;


		$this->load->view('image_upload_view', $view_data);
	}

}

/* End of file upload.php */
/* Location: ./system/application/controllers/upload.php */