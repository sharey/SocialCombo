<?php

class Upload extends Controller {

	function Upload()
	{
		parent::Controller();
	}

	function index()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->model('upload_model');

		$view_data = array();

		if(@$_POST['Submit']) {

			// Awesome Facebook Application
			//
			// Name: MSapp
			//

			//print_r($_FILES);exit;
			if($_FILES) {

				$file_details = $_FILES['image_to_upload'];

				$file_url	= "images/".$file_details['name'];

				if((int)$file_details['size'] > 0 && (int)$file_details['error'] === 0 && trim($file_details['tmp_name']) != '') {

					move_uploaded_file($file_details['tmp_name'], $file_url);
				}
			}


			$appid= '145834245442514';
			$key = '641eab663bce2bcd786e7757ecf7145e';
			$sec = '22f1e4a2314e0013619a8d6bc4b326f8';
			$ver = '1.0';
			$cid = microtime(true);
			$uid = '1466424208';
			$file= $file_url;

			$args = array(
			  'method' => 'photos.upload',
			  'v' => $ver,
			  'api_key' => $key,
			  'uid' => $uid,
			  'call_id' => $cid,
			  'format' => 'XML'
			);

			$this->upload_model->signRequest($args, $sec);

			$args[basename($file)] = '@' . realpath($file);

			$ch = curl_init();
			$url = 'http://api.facebook.com/restserver.php?method=photos.upload';
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
			$data = curl_exec($ch);

			@unlink($file_url);

			$view_data['message'] = "Image has been posted successfully.";
		}

		//print_r($view_data);exit;

		$this->load->view('upload_view', $view_data);
	}

}

/* End of file upload.php */
/* Location: ./system/application/controllers/upload.php */