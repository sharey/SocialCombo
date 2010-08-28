<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>Welcome to SocialCombo</title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Verdana, Sans-serif;
 font-size: 13px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

#form {
	font-family: Verdana, Sans-serif;
	font-size: 13px;
	margin: 3px;
}

h1 {
 color: #444;
 background-color: transparent;
 /*border-bottom: 1px solid #D0D0D0;*/
 font-size: 15px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

</style>
</head>

<body>
<h1>Welcome to SocialCombo !!!</h1>
	<div style="float: right;">Page rendered in {elapsed_time} seconds</div>
<br>
<hr size="4">
<!-- IF COOKIE IS SET AND COULD SUCCESSFULLY RETRIEVE THE USER PROFILE FROM FB, SHOW WELCOME MESSAGE OTHERWISE SHOW FB LOGIN BUTTON -->
<?php if (@$cookie && @$user) { ?>
	<div valign="top"><!-- <img src="http://graph.facebook.com/<?php echo $user->id; ?>/picture">&nbsp;&nbsp; -->Welcome <?php echo $user->name; ?> !!!</div><br><br>
<?php } ?>