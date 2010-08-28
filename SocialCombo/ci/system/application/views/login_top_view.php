<?php
$this->load->view('header');
$this->load->helper('form');
?>

<?php if(@$openid_photo_url) { ?>
	<img src="<?php echo $openid_photo_url; ?>">
<?php } ?>

<?php if(@$openid_name) { ?>
	Welcome <?php echo $openid_name; ?> !!
<?php } ?>

<form method=post action="image_upload" enctype="multipart/form-data">
