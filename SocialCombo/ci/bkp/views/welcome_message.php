<?php $this->load->view('header'); ?>

<p> <!-- THIS IS THE WIDGET TO ADD OPEN ID TO THIS WEBSITE -->
 <!-- <iframe src="http://msapp.rpxnow.com/openid/embed?token_url=http%3A%2F%2Flocalhost%2Fci%2Findex.php%2Fupload"  scrolling="no"  frameBorder="no"  allowtransparency="true"  style="width:400px;height:240px"></iframe> -->

<a class="rpxnow" onclick="return false;"
href="https://msapp.rpxnow.com/openid/v2/signin?token_url=http%3A%2F%2Flocalhost%2Fci%2Findex.php%2Fupload"> Sign In </a> using your OpenID
</p>

<?php $this->load->view('footer'); ?>