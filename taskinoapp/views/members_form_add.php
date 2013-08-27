<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
?>
<div class="wrap">

	<h3><?php echo _gettxt('members') ?></h3>

  <?php if( isset($msg_error) && strlen($msg_error) > 0 ): ?>
  <div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo $msg_error; ?>
  </div>
  <?php endif; ?>
  <?php if( isset($msg_ok) && strlen($msg_ok) > 0 ): ?>
  <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo $msg_ok; ?>
  </div>
  <?php endif; ?>

  <script type="text/javascript">
  jQuery(document).ready(function($){
    $('#member-login').focusout(function(){
      var self = this;
      var login = this.value;
      var login_url = '<?php echo base_url('auth/check_login/'); ?>/' + login;

      $.get(login_url, function(data) {

        if (data == 'yes') {

          after_message = '<?php echo _gettxt('msg_error_login_exists') ?>';
          after_html = '<span class="help-inline"><span class="text-error">'+ after_message + '</span></span>';

          if ($(self).next('.help-inline').remove()) {
            $(self).after(after_html);
            $(self).focus();
          } else{
            $(self).after(after_html);
          }

        } else {

          $(self).next('.help-inline').remove()

        }

      });

    });
  });
  </script>

	<form action="<?php echo base_url('/members/add_save'); ?>" method="post">

		<input type="hidden" name="form_action" value="save" />

		<label for="member-name"><?php echo _gettxt('name') ?></label>
		<input type="text" id="member-name" name="name" placeholder="<?php echo _gettxt('name') ?>" value="<?php echo set_value('name') ?>" required />
		<?php echo form_error('name', '<span class="help-inline"><span class="text-error">', '</span></span>'); ?>

		<label for="member-email"><?php echo _gettxt('email') ?></label>
		<input type="text" id="member-email" name="email" placeholder="<?php echo _gettxt('email') ?>" value="<?php echo set_value('email') ?>" required />
		<?php echo form_error('email', '<span class="help-inline"><span class="text-error">', '</span></span>'); ?>

    <label for="member-login"><?php echo _gettxt('login') ?></label>
    <input type="text" id="member-login" name="login" placeholder="<?php echo _gettxt('login') ?>" value="<?php echo set_value('login') ?>" required />
    <?php echo form_error('login', '<span class="help-inline"><span class="text-error">', '</span></span>'); ?>

		<label for="member-password"><?php echo _gettxt('password') ?></label>
		<input type="password" id="member-password" name="password" placeholder="<?php echo _gettxt('password') ?>" required />
		<?php echo form_error('password', '<span class="help-inline"><span class="text-error">', '</span></span>'); ?>

		<label for="member-password-confirm">Confirm Password</label>
		<input type="password" id="member-password-confirm" name="password_confirm" placeholder="<?php echo _gettxt('password_confirm') ?>" required />
		<?php echo form_error('password_confirm', '<span class="help-inline"><span class="text-error">', '</span></span>'); ?>

  <?php if(member_is_admin()): ?>

    <label for="project-member_admin"><?php echo _gettxt('is_admin') ?></label>

    <select id="project-member_admin" name="member_admin">
      <option value="no" <?php echo set_select('member_admin', 'yes', true); ?>><?php echo _gettxt('no'); ?></option>
      <option value="yes" <?php echo set_select('member_admin', 'no', false); ?>><?php echo _gettxt('yes'); ?></option>
    </select>
    <?php echo form_error('member_admin', '<span class="help-inline"><span class="text-error">', '</span></span>'); ?>

   <?php endif; ?>

		<p></p>
		<p></p>
		<br>

		<a href="javascript:;" onclick="history.back(-1);" class="btn"><i class="icon-chevron-left"></i> <?php echo _gettxt('back') ?></a>
		<button type="submit" class="btn btn-primary"><?php echo _gettxt('save') ?></button>

	</form>

</div><!-- end .wrap -->

<?php include('footer.php'); ?>