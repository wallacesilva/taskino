<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
?>
<div class="wrap">

	<h3><?php echo _gettxt('members') ?></h3>

	<form action="<?php echo base_url('/members/save'); ?>" method="post">

		<input type="hidden" name="form_action" value="save" />

		<label for="member-name"><?php echo _gettxt('name') ?></label>
		<input type="text" id="member-name" name="name" placeholder="<?php echo _gettxt('name') ?>" value="<?php echo set_value('name') ?>" />

		<label for="member-email"><?php echo _gettxt('email') ?></label>
		<input type="text" id="member-email" name="email" placeholder="<?php echo _gettxt('email') ?>" value="<?php echo set_value('email') ?>" />

		<label for="member-password"><?php echo _gettxt('password') ?></label>
		<input type="password" id="member-password" name="password" placeholder="<?php echo _gettxt('password') ?>" />

		<label for="member-password-confirm">Confirm Password</label>
		<input type="password" id="member-password-confirm" name="password_confirm" placeholder="<?php echo _gettxt('password_confirm') ?>" />

		<p></p>
		<p></p>
		<br>

		<button type="submit" class="btn"><?php echo _gettxt('save') ?></button>

	</form>

</div><!-- end .wrap -->

<?php include('footer.php'); ?>