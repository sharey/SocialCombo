
<?php if ((@$cookie && @$user) || @$oauth_token) { ?>

	<br>Upload Image: <input type="file" name="image_to_upload">
	<br><br><br><input type='submit' value='Post' name='submit' id='submit' />

<?php } ?>

</form>

<?php if (@$success_msg) { ?>

	<p style="color: #339900; font-weight: bold;"><?php echo $success_msg;?></p>

<?php } ?>

<?php $this->load->view('footer'); ?>