<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
?>
<div class="wrap">

	<h3><?php echo _gettxt('members') ?></h3>

	<form action="<?php echo base_url('/members/save_password'); ?>" method="post">

		<input type="hidden" name="form_action" value="save" />
		<input type="hidden" name="id" value="<?php echo set_value('id', $member->id); ?>" />
		
		<label for="member-password"><?php echo _gettxt('password') ?></label>
		<input type="password" id="member-password" name="password" placeholder="<?php echo _gettxt('password') ?>" />

		<label for="member-password-confirm"><?php echo _gettxt('password_confirm') ?></label>
		<input type="password" id="member-password-confirm" name="password_confirm" placeholder="<?php echo _gettxt('password_confirm') ?>" />


		<p></p>
		<p></p>
		<br>

		<a href="javascript:;" onclick="history.back(-1);" class="btn"><i class="icon-chevron-left"></i> <?php echo _gettxt('back') ?></a>
		<button type="submit" class="btn btn-primary"><?php echo _gettxt('save') ?></button>

	</form>

</div><!-- end .wrap -->

<?php include('footer.php'); ?>