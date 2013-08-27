<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 

?>
<div class="wrap">

  <h3><?php echo _gettxt('report_error') ?></h3>

  <?php if( isset($msg_error) ): ?>
  <div class="alert alert-error"><?php echo $msg_error ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php elseif( isset($msg_ok) ): ?>
  <div class="alert alert-success"><?php echo $msg_ok ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php endif; ?>

  <form method="post" action="<?php echo base_url('settings/report_error'); ?>">

    <input type="hidden" name="do_report" value="bug" />

    <h1 class="pull-right span7" style="text-align:center;font-size:150px;color:gray;"> <i class="icon-bug"></i> </h1>

    <label><?php echo _gettxt('report_title') ?></label>
    <input type="text" name="report_title" class="span5" placeholder="<?php echo _gettxt('report_title') ?>" />

    <label><?php echo _gettxt('report_where') ?></label>
    <input type="text" name="report_where" class="span5" placeholder="<?php echo _gettxt('report_where_placeholder') ?>" />

    <label><?php echo _gettxt('report_description') ?></label>
    <textarea name="report_description" class="span5 form_textarea" placeholder="<?php echo _gettxt('report_description_placeholder') ?>"></textarea>

    <label>&nbsp;</label>
    <input type="submit" class="btn btn-primary" value="<?php echo _gettxt('save'); ?>">

  </form>


</div><!-- end .wrap -->

<?php include('footer.php'); ?>