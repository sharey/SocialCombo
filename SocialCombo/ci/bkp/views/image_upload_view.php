<?php
$this->load->view('header');
$this->load->helper('form');
?>

<!-- IF COOKIE IS SET AND COULD SUCCESSFULLY RETRIEVE THE USER PROFILE FROM FB, SHOW WELCOME MESSAGE OTHERWISE SHOW FB LOGIN BUTTON -->
<?php if ($cookie && @$user) { ?>
	<div valign="top"><!-- <img src="http://graph.facebook.com/<?php echo $user->id; ?>/picture">&nbsp;&nbsp; -->Welcome <?php echo $user->name; ?> !!!</div><br><br>
	<!-- IF IMAGES UPLOAD SUCCESSFULLY, SHOW SUCCESS MESSAGE OTHERWISE SHOW THE UPLOAD FORM -->
	<?php if(@$success_msg) { echo $success_msg; } else { ?>
		<form method=post action="image_upload" enctype="multipart/form-data">
			Upload Image: <input type="file" name="image_to_upload">
			<input type="submit" name="Submit" value="Upload">
		</form>
		<?php } ?>
<?php } else { ?>
	<fb:login-button length="long" perms="publish_stream,offline_access"></fb:login-button>
<?php } ?>

<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<!-- <script type="text/javaScript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script> -->
<script>
	FB.init({appId: '<?php echo FACEBOOK_APP_ID; ?>', status: true, cookie: true, xfbml: true});
	//FB.init('641eab663bce2bcd786e7757ecf7145e','xd_receiver.htm');
	FB.Event.subscribe('auth.login', function(response) {
	window.location.reload();
	});
</script>

<?php $this->load->view('footer'); ?>