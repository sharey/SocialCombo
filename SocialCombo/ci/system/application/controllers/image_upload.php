<?php

class Image_Upload extends Controller {

	function Image_Upload()
	{
		parent::Controller();
	}

	function index()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->model(array('login_model', 'upload_model', 'msapp_database_model'));
		$this->load->plugin('twitter');

		$view_data = array();

		/************************************** OPENID IMPLEMENTATION ************************************/

		if(@$_REQUEST['token']) {
			$arr_openid = array(
				'apiKey'	=> JANRAIN_API_KEY,
				'token'		=> $_REQUEST['token'],
				'format'	=> 'json'
			);

			$c_response = $this->upload_model->Curl_Call(JANRAIN_API_URL, $arr_openid);

			$auth_info = json_decode($c_response, true);

			if ($auth_info['stat'] == 'ok') {

				$profile = $auth_info['profile'];

				if (isset($profile['photo'])) {
				  $photo_url = $profile['photo'];
				  $view_data['openid_photo_url'] = $photo_url;
				}

				if (isset($profile['displayName'])) {
				  $name = $profile['displayName'];
				  $view_data['openid_name'] = $name;
				}
			}
		}

		/************************************** END OF OPENID IMPLEMENTATION ************************************/

		$this->load->view('login_top_view', $view_data);

		/************************************** TWITTER IMPLEMENTATION ************************************/

		if(@$_COOKIE['lh_tw_userid']) {
			$tw_user_details = $this->msapp_database_model->get_user(@$_COOKIE['lh_tw_userid'], 2);

			if(@$tw_user_details['user_id'])			$db_user_id				= $tw_user_details['user_id'];
			if(@$tw_user_details['access_token'])		$db_access_token		= $new_access_token = $tw_user_details['access_token'];
			if(@$tw_user_details['access_token_secret'])$db_access_token_secret	= $new_access_token_secret = $tw_user_details['access_token_secret'];
		}

		$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);

		// GET THE REQUEST TOKEN FROM GET OR DB
		$oauth_token = (@$_GET['oauth_token']) ? @$_GET['oauth_token'] : @$db_access_token;

		if(@$oauth_token)	$view_data['oauth_token'] = $oauth_token;

		// IF ITS A FIRST TIME TO VISIT OUR WEBSITE, GET AUTHORIZE URL AND REQUEST OAUTH TOKEN. OTHERWISE USE THE REQUEST TOKEN TO GET ACCESS TOKEN HERE..
		if(!@$oauth_token) {

			$view_data['url'] = $twitterObj->getAuthorizationUrl();

			//$this->load->view('login_view', $view_data);

		} else {

			// IF WE HAVE THE TOKEN STORED IN DB FOR THIS USER, USE IT
			if(@$db_access_token) {

				$twitterObj->setToken($db_access_token, $db_access_token_secret);

			} else { // OTHERWISE SEND THE REQUEST TOKEN CAME IN QUERY STRING TO GET ACCESS TOKEN

				$twitterObj->setToken($_GET['oauth_token']);
				$token = $twitterObj->getAccessToken();
				$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);

				$new_access_token			= $token->oauth_token;
				$new_access_token_secret	= $token->oauth_token_secret;
			}

			// VERIFY THE ACCOUNT CREDENTIALS
			$twitterInfo= $twitterObj->get_accountVerify_credentials();
			$twitterInfo->response;

			$username	= @$twitterInfo->screen_name;
			$profilepic	= @$twitterInfo->profile_image_url;

			// SET USER COOKIE EXPIRING IN 24 HOURS BCOZ OUR WEBSITE DOESNT STORE USER ID WHICH WOULD HELP US IDENTIFY THE USER NEXT TIME HE VISITS THE WEBSITE.
			if(!@$_COOKIE['lh_tw_userid']) setcookie("lh_tw_userid", $username, time()+3600*24);

			if($username && $new_access_token && $new_access_token_secret) {

				// INSERT ACCESS TOKEN AND SECRET INTO DB HERE..
				$db_uid = $this->msapp_database_model->replace_user(array(
					'user_id'				=> $username,
					'access_token'			=> $new_access_token,
					'access_token_secret'	=> $new_access_token_secret,
					'social_site_flag'		=> 2
				));
			}

			$view_data['username']	= $username;
			$view_data['profilepic']= $profilepic;
		}

		/************************************** END OF TWITTER IMPLEMENTATION ************************************/


		/************************************** FACEBOOK IMPLEMENTATION ******************************************/

		// THIS LOCALHOST COOKIE IS SET AUTOMATICALLY WHEN USER ACCESS THE WEBPAGE
		$cookie = $this->login_model->Get_Cookie();

		// MAKE SURE YOU HAVE COOKIE FOR USER AND THEN RETRIEVE THE USER INFORMATION USING BELOW GRAPH API
		if(@$cookie && @$cookie['access_token'] && @$cookie['uid']) {

			// OK SO GETTING USER INFORMATION FROM FB PART WORKS WELL..
			$user = @json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$cookie['access_token']));
			//echo "<br>Name: ".$user->name;

			if(@$user)	$view_data['user'] = $user;
		}

		$view_data['cookie'] = @$cookie;

		/************************************** END OF FACEBOOK IMPLEMENTATION ******************************************/


		/************************************** CALLING JAVA WEB SERVER IMPLEMENTATION ******************************************/

		// AFTER UPLOADING IMAGE
		if (@$_POST['submit']) {

			// SETTING THE BITMAP TO PASS TO MEGH'S WEB SERVICE
			if(@$_POST['upload_to_facebook'] && @$_POST['upload_to_twitter'])	$service_map = 3;
			else if(@$_POST['upload_to_twitter'])	$service_map = 2;
			else if(@$_POST['upload_to_facebook'])	$service_map = 1;
			else	$service_map = 0;

			if($_FILES) {

				$file = $_FILES['image_to_upload']['tmp_name'];

				// NOW CALL FB API TO UPLOAD PHOTOS. CALL IT FROM HERE DIRECTLY. MY PHP FB API CALL
				//$ver = '1.0';
				//$cid = microtime(true);
				//$curl_response = $this->upload_model->Call_My_API('photos.upload', $ver, FACEBOOK_APP_ID, FACEBOOK_SECRET, $user->id, $cid, 'XML', $file);

				// MEGHA'S API JAVA WEB SERVICE CALL
				$curl_response = $this->upload_model->Call_Megha_API(@$cookie['access_token'], @$new_access_token, @$new_access_token_secret, CONSUMER_KEY, CONSUMER_SECRET, TWITPIC_API_KEY, $service_map, $file);

				// SUCCESS MESSAGE
				if(@$curl_response)	{

					$arr_response = @explode("|", $curl_response);

					$fb_msg = ($arr_response[0] == 200) ? "Facebook" : "";

					$tw_msg	= "";
					if($arr_response[1] == 200) {
						$tw_msg = (@$fb_msg) ? " and " : "";
						$tw_msg .= "Twitter";
						$tw_url = (@$arr_response[2]) ? $arr_response[2] : "";
					}

					if($fb_msg || $tw_msg) {
						$view_data['success_msg'] = "Image has been successfully uploaded to your $fb_msg$tw_msg profile.";
					}
				}


				// CHECK THAT USER CHECKED THE BOX TO POST TO TWITTER AND THAT MEGHA'S CALL REPOSNDED WITH THE PIC URL
				if(@$_POST['post_to_twitter'] && @$tw_url) {

					$msg = "Shared picture from SocialCombo: ".$tw_url;

					$update_status = $twitterObj->post_statusesUpdate(array('status' => $msg));
					$temp = $update_status->response;
				}

				//NORMAL TWEET IS CHECKED AND ENTERED TEXT
				if(@$_POST['tweet'] && @$_POST['tweet_txt']) {

					$msg = @$_POST['tweet_txt'];

					$update_status = $twitterObj->post_statusesUpdate(array('status' => $msg));
					$temp = $update_status->response;
				}
			}
		}

		/************************************** END OF CALLING JAVA WEB SERVER IMPLEMENTATION ******************************************/

		$this->load->view('fb_view', $view_data);
		$this->load->view('tw_view', $view_data);

		$this->load->view('login_bottom_view', $view_data);

	}
}

/* End of file image_upload.php */
/* Location: ./system/application/controllers/image_upload.php */