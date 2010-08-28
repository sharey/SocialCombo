<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
	FB.init({appId: '<?php echo FACEBOOK_APP_ID; ?>', status: true, cookie: true, xfbml: true});
	FB.Event.subscribe('auth.login', function(response) {
	window.location.reload();
	});
</script>

<hr size="4">
<div style="font-size: 9px;">Copyright © 2010 SocialCombo.</div>
</body>
</html>
