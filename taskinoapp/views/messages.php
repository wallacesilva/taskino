<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
//id, name, assigned_to, priority, created_by, date_added
?>
<div class="wrap">

  <?php if( isset($msg_error) ): ?>
  <div class="alert alert-error"><?php echo $msg_error ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php elseif( isset($msg_ok) ): ?>
  <div class="alert alert-success"><?php echo $msg_ok ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php endif; ?>

  <h3 class="text-center">
    <a href="#" onclick="javascript:window.history.back(-1);return false;"> < <?php echo _gettxt('back'); ?></a>
  </h3>

</div><!-- end .wrap -->

<?php include('footer.php'); ?>