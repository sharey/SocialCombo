<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


// SET CONFIG VARS FOR FB APP
define('FACEBOOK_APP_ID', '641eab663bce2bcd786e7757ecf7145e');
define('FACEBOOK_SECRET', '22f1e4a2314e0013619a8d6bc4b326f8');

// SET CONFIG VARS FOR TWITTER APP
define('CONSUMER_KEY', 'iYzIflyVxkXQvcFLvSdPTw');
define('CONSUMER_SECRET', 'IfnxaLwvoJ22du8QOIT1bsXclLvZtycv0waW6DXHJDg');
define('OAUTH_CALLBACK', 'http://localhost/ci/index.php/image_upload');

define('TWITPIC_API_KEY', 'efe2b4b107bf5f965002d7d04a32f16d');

define('JANRAIN_API_KEY', '6c9cf85ada920b11f72dd3a38dfdefd98d17b2bd');
define('JANRAIN_API_URL', 'https://rpxnow.com/api/v2/auth_info');

/* End of file constants.php */
/* Location: ./system/application/config/constants.php */