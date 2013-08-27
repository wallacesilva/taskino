<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
//id, name, assigned_to, priority, created_by, date_added
?>
<div class="wrap">

  <!-- <a href="<?php echo base_url('/settings/add'); ?>" class="btn pull-right"><?php echo _gettxt('settings_add_txt') ?></a>   -->
  <h3><?php echo _gettxt('settings') ?></h3>

  <?php if( isset($msg_error) ): ?>
  <div class="alert alert-error"><?php echo $msg_error ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php elseif( isset($msg_ok) ): ?>
  <div class="alert alert-success"><?php echo $msg_ok ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php endif; ?>

  <form method="post" action="<?php echo base_url('settings/save'); ?>">

    <input type="hidden" name="form_action" value="save" />

  <div class="row">

    <span class="span12">
      <h4><?php echo _gettxt('company') ?></h4>
    </span>

    <span class="span6">

      <label for="member-name"><?php echo _gettxt('name') ?></label>
      <input type="text" id="member-name" name="name" placeholder="<?php echo _gettxt('name') ?>" value="<?php echo set_value('name', $settings->name) ?>" />
      <?php echo form_error('name', '<span class="help-inline"><span class="text-error">', '</span></span>'); ?>

      <label for="member-logo-url"><?php echo _gettxt('company_url_logo') ?></label>
      <input type="text" id="member-name" name="url_logo" placeholder="http://in9web.com/logo.png" value="<?php echo set_value('url_logo', $settings->url_logo) ?>" />
      
    </span>

    <span class="span6">
          
      <?php $plan_active = get_plan_active(); ?>

      <label>
        <strong><?php echo _gettxt('plan') ?>:</strong>
        <span class="label label-info"><?php echo _gettxt(strtolower($plan_active->name)) ?></span>
      </label>

      <label>
        <strong><?php echo _gettxt('project_max_this_plan') ?>:</strong>
        <?php echo $plan_active->max_projects. ' '. _gettxt('projects'); ?>
      </label>

      <label>
        <strong><?php echo _gettxt('plan_max_disk_usage') ?>:</strong>
        <?php echo $plan_active->max_filesize. ' MB'; ?>
      </label>

      <label>
        <strong><?php echo _gettxt('company_disk_usage') ?>:</strong>
        <?php 
          $disk_usage = company_disk_usage('MB');
          echo $disk_usage;
          echo ' ('. ceil(((float)$disk_usage * 100) / $plan_active->max_filesize). '%)';
        ?>
      </label>

    </span>

    <span class="span12">

      <p>&nbsp;</p>

      <a href="javascript:;" onclick="history.back(-1);" class="btn"><i class="icon-chevron-left"></i> <?php echo _gettxt('back') ?></a>
      <button type="submit" class="btn btn-primary"><?php echo _gettxt('save') ?></button>

    </span>

  </div> <!-- end .row -->

  </form>




</div><!-- end .wrap -->

<?php include('footer.php'); ?>