<?php defined('BASEPATH') OR exit('No direct script access allowed');

//include('header.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Taskino</title>
	<base href="<?php echo base_url() ?>" />

	<script type="text/javascript" src="media/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="media/bootstrap/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="media/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="media/css/styles.css?r=<?php echo filemtime(FCPATH. 'media/css/styles.css') ?>" />
	<style type="text/css">
	#frm-btn-upload{margin-bottom: 10px;}
	</style>
</head>
<body>
<div class="wrap">

	<h3><?php echo _gettxt('task_upload') ?></h3>

	<?php if( isset($msg_error) ): ?>
  <div class="alert alert-error"><?php echo $msg_error ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php elseif( isset($msg_ok) ): ?>
  <div class="alert alert-success"><?php echo $msg_ok ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php endif; ?>

	<?php echo form_open_multipart('tasks/upload/'.$task_id); ?>

	<input type="hidden" name="save_upload" value="save" />
	<input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />

	<div class="controls">
		<input type="text" id="frm-upload-description" name="description" placeholder="<?php echo _gettxt('file_description') ?>" />
		<a href="javascript:;" id="frm-btn-upload" onclick="jQuery('#userfile').click();" class="btn"><i class="icon-folder-open"></i> <?php echo _gettxt('file_choose_file') ?></a>
	</div>

	<label></label>
	<input type="file" name="userfile" id="userfile" onchange="jQuery('#userfile_label').html(this.value);" style="display:none;" />
	<?php /* <span id="userfile_label"><?php echo _gettxt('file_no_file_selected') ?></span>  */?>

	<label></label>
	<input type="submit" class="btn" value="<?php echo _gettxt('upload') ?>" />
	<a href="javascript:self.top.$.prettyPhoto.close();" class="btn"><?php echo _gettxt('cancel') ?></a>

	<?php echo form_close(); ?>

	<script type="text/javascript">
	jQuery(document).ready(function($){

		$('#frm-upload-description').focus();

		$('#userfile').change(function(){
			if( this.value.length > 0 ){
				$('#frm-btn-upload').removeClass('btn-danger').addClass('btn-success');
			} else {
				$('#frm-btn-upload').removeClass('btn-success').addClass('btn-danger');
			}
		});

		$('form').submit(function(){

			if( $(this).find('#userfile').val().length < 1 ){
				$('#frm-btn-upload').removeClass('btn-success').addClass('btn-danger');	
				return false;
			}

		});

	});
	<?php if( @$saved ): ?>
	if( self.top ){
		self.top.$.prettyPhoto.close();

		<?php if( @$is_member ){ ?> 
			self.top.location = '<?php echo base_url('/members/edit/'.get_member_session('id')); ?>';
		<?php } else { ?>
			self.top.location = '<?php echo base_url('/tasks/show/'.@$task_id); ?>';
		<?php } ?>
	}
	<?php endif; ?>
	</script>

</div><!-- end .wrap -->
<?php 
$footer_text = true;
include('footer.php');  ?>