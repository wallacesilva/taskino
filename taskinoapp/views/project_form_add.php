<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
//id, name, assigned_to, priority, created_by, date_added
?>
<div class="wrap">

  <h3><?php echo _gettxt('projects') ?></h3>

  <form action="<?php echo base_url('/projects/save'); ?>" method="post">

    <div class="row">

    <span class="span12">

      <input type="hidden" name="form_action" value="save" />

      <label for="project-name"><?php echo _gettxt('name') ?></label>
      <input type="text" id="project-name" name="name" class="span5" pattern=".{3,}" placeholder="<?php echo _gettxt('name') ?>" value="<?php echo set_value('name') ?>" />
      <?php echo form_error('name', '<span class="help-inline"><span class="text-error">', '</span></span>'); ?>

      <label for="project-description"><?php echo _gettxt('description') ?></label>
      <textarea name="description" id="project-description" pattern=".{3,}" class="span5 form_textarea" placeholder="<?php echo _gettxt('description') ?>"><?php echo set_value('description') ?></textarea>
      <?php echo form_error('description', '<span class="help-inline"><span class="text-error">', '</span></span>'); ?>

    </span>
 
    <span class="span6 offset1 border-left"></span>

    <span class="span12">
      
      <p></p>
      <p></p>

      <a href="javascript:;" onclick="history.back(-1);" class="btn"><i class="icon-chevron-left"></i> <?php echo _gettxt('back') ?></a>
      <button type="submit" class="btn btn-primary"><?php echo _gettxt('save') ?></button>
    </span>

  </div> <!-- end .row -->

  </form>

</div><!-- end .wrap -->

<?php include('footer.php'); ?>