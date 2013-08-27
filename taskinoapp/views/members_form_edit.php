<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
?>
<div class="wrap">

	<h3><?php echo _gettxt('members') ?></h3>

	<form action="<?php echo base_url('/members/edit_save'); ?>" method="post">

		<input type="hidden" name="form_action" value="save" />
		<input type="hidden" name="id" value="<?php echo set_value('id', $member->id); ?>" />

    <label for="member-login">
      <?php echo _gettxt('login') ?>
      <span class="label"><?php echo $member->login; ?></span>
    </label>
    
    <label for="member-name"><?php echo _gettxt('name') ?></label>
    <input type="text" id="member-name" name="name" placeholder="<?php echo _gettxt('name') ?>" value="<?php echo set_value('name', $member->name) ?>" />
    <?php echo form_error('name', '<span class="help-inline"><span class="text-error">', '</span></span>'); ?>

    <label for="member-email"><?php echo _gettxt('email') ?></label>
    <input type="text" id="member-email" name="email" placeholder="<?php echo _gettxt('email') ?>" value="<?php echo set_value('email', $member->email) ?>" />
    <?php echo form_error('email', '<span class="help-inline"><span class="text-error">', '</span></span>'); ?>


    <label for="member-language_default"><?php echo _gettxt('language_default') ?></label>
    <select id="member-language_default" name="language_default">
      <?php 
      $pt_selected = $en_selected = '';
      if( $member->language_default == 'english' )
        $en_selected = 'selected="selected"'; 
      else
        $pt_selected = 'selected="selected"'; 
      ?>
      <option value="english" <?php echo $en_selected; ?>><?php echo _gettxt('menu_english'); ?></option>
      <option value="portuguese" <?php echo $pt_selected; ?>><?php echo _gettxt('menu_portuguese'); ?></option>
    </select>

  <?php if(member_is_admin() && !member_is_admin_master($member->id)): ?>

    <label for="project-member_admin"><?php echo _gettxt('is_admin') ?></label>
    <select id="project-member_admin" name="member_admin">
    	<?php 
    	$no_selected = $yes_selected = '';
    	if( $member->is_admin == 'yes' )
    		$yes_selected = 'selected="selected"'; 
    	else
    		$no_selected = 'selected="selected"'; 
    	?>
      <option value="no" <?php echo $no_selected; ?>><?php echo _gettxt('no'); ?></option>
      <option value="yes" <?php echo $yes_selected; ?>><?php echo _gettxt('yes'); ?></option>
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