<?php defined('BASEPATH') OR exit('No direct script access allowed');

//include('header.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Taskino - Controle de tarefas</title>
	<base href="<?php echo base_url() ?>" />

	<script type="text/javascript" src="media/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="media/bootstrap/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="media/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="media/css/styles.css?r=<?php echo filemtime(FCPATH. 'media/css/styles.css') ?>" />
</head>
<body>
<div class="wrap">

	<h3>Task upload</h3>

	<?php echo form_open_multipart('tasks/upload/'.$task_id); ?>

	<input type="hidden" name="save_upload" value="save" />
	<input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />

	<label></label>
	<input type="text" name="description" placeholder="Description to file" />

	<label></label>
	<input type="file" name="userfile" id="userfile" onchange="jQuery('#userfile_label').html(this.value);" style="display:none;" />
	<a href="javascript:;" onclick="jQuery('#userfile').click();" class="btn"><i class="icon-folder-open"></i> Choose a file</a>
	<span id="userfile_label">No file selected</span>

	<label></label>
	<input type="submit" class="btn" value="Upload" />
	<a href="javascript:self.top.$.prettyPhoto.close();" class="btn">Cancel</a>

	<?php echo form_close(); ?>

	<script type="text/javascript">
	jQuery(document).ready(function($){

		<?php if( @$saved ): ?>
		if( self.top ){
			self.top.$.prettyPhoto.close();
			self.top.location = '<?php echo base_url('/tasks/show/'.@$task_id); ?>';
		}
		<?php endif; ?>
	});
	</script>

</div><!-- end .wrap -->
<?php include('footer.php');  ?>