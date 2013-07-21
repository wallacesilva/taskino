<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
?>
<div class="wrap">

	<h3><?php echo _gettxt('members') ?></h3>

	<form action="<?php echo base_url('/members/save'); ?>" method="post">

		<input type="hidden" name="form_action" value="save" />
		<input type="hidden" name="id" value="<?php echo set_value('id', $member->id); ?>" />

		<label for="member-name"><?php echo _gettxt('name') ?></label>
		<input type="text" id="member-name" name="name" placeholder="<?php echo _gettxt('name') ?>" value="<?php echo set_value('name', $member->name) ?>" />

		<label for="member-email"><?php echo _gettxt('email') ?></label>
		<input type="text" id="member-email" name="email" placeholder="<?php echo _gettxt('email') ?>" value="<?php echo set_value('email', $member->email) ?>" />

		<p></p>
		<p></p>
		<br>

		<button type="submit" class="btn"><?php echo _gettxt('save') ?></button>

	</form>

</div><!-- end .wrap -->

<?php include('footer.php'); ?>