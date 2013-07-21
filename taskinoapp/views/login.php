<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
//id, name, assigned_to, priority, created_by, date_added
?>
<style type="text/css">
.wrap-login{
	width:220px;
	margin:20% auto;
	border:1px solid #999;
	padding-left: 20px;
	padding-right: 20px;
	-webkit-box-shadow: 2px 2px 10px #ccc;
		 -moz-box-shadow: 2px 2px 10px #ccc;
					box-shadow: 2px 2px 10px #ccc;
}
</style>
<div class="wrap-login img-rounded">

	<center>
		<h3>Taskino</h3>
	</center>

	<?php if( isset($msg_error) && strlen($msg_error) > 0 ): ?>
	<p class="text-center">
		<span class="label label-important"><?php echo $msg_error; ?></span>
	</p>
	<?php endif; ?>
	<?php if( isset($msg_ok) && strlen($msg_ok) > 0 ): ?>
	<p class="text-center">
		<span class="label label-success"><?php echo $msg_ok; ?></span>
	</p>
	<?php endif; ?>


<?php if( isset($recover_password) ): ?>

	<form action="<?php echo base_url('/auth/save_recover_password/'); ?>" method="post">

		<?php if( isset($activation_key) ): ?>
		<input type="hidden" name="activation_key" value="<?php echo set_value('activation_key', $activation_key); ?>">
		<?php endif; ?>

		<label for="member-password"><?php echo _gettxt('password') ?></label>
		<input type="password" id="password" name="password" pattern=".{3,}" placeholder="<?php echo _gettxt('password') ?>" />

		<label for="member-password-confirm"><?php echo _gettxt('password_confirm') ?></label>
		<input type="password" id="password-confirm" name="password_confirm" pattern=".{3,}" placeholder="<?php echo _gettxt('password_confirm') ?>" />

		<label></label>
		<input type="submit" class="btn btn-small" value="<?php echo _gettxt('save') ?>" />

	</form>		

<?php else: ?>

	<form action="<?php echo base_url('/auth/login'); ?>" method="post">

		<input type="text" name="email" class="" placeholder="E-Mail" value="<?php echo set_value('email') ?>" />
		<input type="password" name="password" placeholder="Password" />

		<label></label>
		<input type="submit" class="btn btn-small" value="Login" />
		<a href="javascript:jQuery('form').slideToggle();" class="btn btn-small"><span class="icon-lock"></span> Forgot password</a>

	</form>

	<form action="<?php echo base_url('/auth/forgot_password'); ?>" method="post" style="display:none;">

		<input type="hidden" name="recover_password" value="do_please" />

		<label></label>
		<input type="email" name="email_recover" class="" placeholder="E-Mail" />

		<label></label>
		<a href="javascript:jQuery('form').slideToggle();" class="btn btn-small"><i class="icon-chevron-left"></i> back</a>
		<input type="submit" class="btn btn-small" value="Recover" />

	</form>

<?php endif; // end if check form recovered password ?>

</div><!-- end .wrap -->

<?php include('footer.php'); ?>