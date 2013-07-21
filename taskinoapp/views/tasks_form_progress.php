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

	<h3>Change progress</h3>

	<?php echo form_open_multipart('tasks/task_change_percent/'.$task_id); ?>

	<input type="hidden" name="save_progress" value="save" />
	<input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
	
	<label>Progress</label>
	1%
	<input type="range" name="total_percent" min="1" max="99" value="<?php echo $task->total_percent; ?>" onchange="jQuery('#total_percent_bar .bar').width(this.value+'%'); jQuery('#total_percent_bar span').html(this.value+'%');"> 99%
	<div class="progress progress-striped" id="total_percent_bar" style="width:250px;">
	  <div class="bar" style="width: <?php echo $task->total_percent; ?>%;"> <span><?php echo $task->total_percent; ?>%</span> </div> 
	</div>

	<label></label>
	<input type="submit" class="btn" value="Save" />
	<a href="javascript:self.top.$.prettyPhoto.close();" class="btn">Cancel</a>

	<?php echo form_close(); ?>

	<script type="text/javascript">
		<?php if( @$saved ): ?>
		if( self.top ){
			self.top.$.prettyPhoto.close();
			//setTimeout('self.top.location.reload();', 2000);
		}
		<?php endif; ?>
	jQuery(document).ready(function($){

	});
	</script>

</div><!-- end .wrap -->
<?php include('footer.php');  ?>