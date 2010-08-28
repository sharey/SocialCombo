<?php
$this->load->view('header');
$this->load->helper('form');
?>

<?php if(@$message) { ?>
	<p><?php echo $message; ?></p>
<?php } else { ?>
	<script type="text/javaScript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>

	<div id="fb_opt">
		<fb:login-button length="long" onlogin="update_user_box();"></fb:login-button>
	</div>

	<script type="text/javaScript">
	<!--
		function update_user_box()
		{
			var fb_option	= document.getElementById('fb_opt');
			var frm_option	= document.getElementById('show_upload_form');

			fb_option.innerHTML =
				"<span>"
			+	"<fb:profile-pic uid='loggedinuser' facebook-logo='true'></fb:profile-pic> Upload to Facebook "
			+ "</span>";

			frm_option.style.display = "";

			FB.XFBML.Host.parseDomTree();
		}

		FB.init('641eab663bce2bcd786e7757ecf7145e','xd_receiver.htm');

		FB.ensureInit( function () {
		FB.Connect.ifUserConnected(update_user_box)});

	//-->
	</script>
	<br>
	<div id="show_upload_form" style="display: none;">
	<form method=post action="upload" enctype="multipart/form-data">
		Upload Image: <input type="file" name="image_to_upload">
		<input type="submit" name="Submit" value="Upload">
	</form>
	</div>
<?php } ?>
<?php $this->load->view('footer'); ?>