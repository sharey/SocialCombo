<?php
$this->load->view('header');
$this->load->helper('form');
?>

<?php //if (@$cookie && @$user) { ?>
	<!-- IF IMAGES UPLOAD SUCCESSFULLY, SHOW SUCCESS MESSAGE OTHERWISE SHOW THE UPLOAD FORM -->
	<?php //if(@$success_msg) { echo $success_msg; } else { ?>
		<!-- <form method=post action="image_upload" enctype="multipart/form-data">
			Upload Image: <input type="file" name="image_to_upload">
			<input type="submit" name="Submit" value="Upload">
		</form> -->
		<?php //} ?>
<?php //} ?>

<?php if(@$oauth_token) { ?>
		<div id="form"><!--Start form-->
	<p>User Name: <?php echo $username ?></p>
	<p>Profile Picture: <br /><?php echo "<img src='$profilepic' />" ?><br /></p>
	<label>Update Twitter Post</label><br />

	<form method='post' action='image_upload'>
		<br /><textarea  name="tweet" cols="50" rows="5" id="tweet" ></textarea><br />
		<input type='submit' value='Tweet' name='submit' id='submit' />
	</form>
	</div><!--End Form-->
<?php } ?>

<?php $this->load->view('footer'); ?>