<br><?php if(!@$oauth_token) { ?>
	<div>
		<a href='<?php echo $url ?>'><img src="../images/sign-in-with-twitter.png" title="Sign In with Twitter" border="0"></a>
	</div>
<?php } else { ?>
	<table width="500" height="150" style="border: 1px solid; background-color: #FBF9E1">
	<tr>
		<td width="130"><img src="../images/Twitter.png"></td>
		<td valign="top">
			<!-- <div valign="top"><img src="<?php echo $profilepic; ?>">&nbsp;&nbsp; Welcome <?php echo $username; ?> !!!</div><br> -->
			<div id="form">
				<input type="checkbox" name="upload_to_twitter" value=2> Upload to TwitPic
				<br><input type="checkbox" name="post_to_twitter" value=4> Post TwitPic URL to Twitter
				<br><input type="checkbox" name="tweet" value=5 onclick="Javascript: show_tweet_form(this);"> Tweet
				<br>
				<div id="show_tweet_form" style="display: none; padding: 10px;">
					<textarea name="tweet_txt" rows="2" cols="15"></textarea>
				</div>
			</div>
		</td>
	</tr>
	</table>

<script language="JavaScript">
<!--
	function show_tweet_form(obj) {

		if(obj.checked == true) {
			document.getElementById('show_tweet_form').style.display = '';
		} else {
			document.getElementById('show_tweet_form').style.display = 'none';
		}

	}
//-->
</script>

<?php } ?>
<br>