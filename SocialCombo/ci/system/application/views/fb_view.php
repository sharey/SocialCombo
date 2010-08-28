<!-- IF COOKIE IS SET AND COULD SUCCESSFULLY RETRIEVE THE USER PROFILE FROM FB, SHOW WELCOME MESSAGE OTHERWISE SHOW FB LOGIN BUTTON -->
<br><?php if (@$cookie && @$user) { ?>
	<!-- IF IMAGES UPLOAD SUCCESSFULLY, SHOW SUCCESS MESSAGE OTHERWISE SHOW THE UPLOAD FORM -->
	<table width="500" style="border: 1px solid; background-color: #FBF9E1">
	<tr>
		<td width="130"><img src="../images/Facebook.png"></td>
		<td>
			<!-- <div valign="top"><img src="http://graph.facebook.com/<?php echo $user->id; ?>/picture">&nbsp;&nbsp; Welcome <?php echo $user->name; ?> !!!</div><br> -->
			<div id="form">
				<input type="checkbox" name="upload_to_facebook" value=1> Upload to Facebook
			</div>
		</td>
	</tr>
	</table>
<?php } else { ?>
	<fb:login-button length="long" perms="publish_stream,offline_access"></fb:login-button>
<?php } ?>
<br>




