<?php $this->load->view('header'); ?>

<!-- IF COOKIE IS SET AND COULD SUCCESSFULLY RETRIEVE THE USER PROFILE FROM FB, SHOW WELCOME MESSAGE OTHERWISE SHOW FB LOGIN BUTTON -->
<?php if (!@$cookie || !@$user) { ?>
	<!-- <fb:login-button length="long" perms="publish_stream,offline_access"></fb:login-button> -->
	<fb:login-button length="long" perms="publish_stream"></fb:login-button>
<?php } ?>


<?php if(!@$oauth_token) { ?>
	<br><br>
	<div>
		<a href='<?php echo $url ?>'><img src="../images/sign-in-with-twitter.png" title="Sign In with Twitter" border="0"></a>
	</div>
<?php } ?>


<?php $this->load->view('footer'); ?>