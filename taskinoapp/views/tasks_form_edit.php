<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
//id, name, assigned_to, priority, created_by, date_added
?>
<div class="wrap">

	<h3><?php echo _gettxt('tasks') ?></h3>

	<form action="<?php echo base_url('/tasks/save'); ?>" method="post">

		<input type="hidden" name="form_action" value="save" />
		<input type="hidden" name="id" value="<?php echo set_value('id', $task->id); ?>" />

	<div class="row">

		<span class="span5">

			<label for="task-name"><?php echo _gettxt('name') ?></label>
			<input type="text" id="task-name" class="span5" name="name" placeholder="<?php echo _gettxt('name') ?>" value="<?php echo set_value('name', $task->name) ?>" />

			<label for="task-description"><?php echo _gettxt('description') ?></label>
			<textarea name="description" id="task-description" class="span5" placeholder="<?php echo _gettxt('description') ?>"><?php echo set_value('description', $task->description) ?></textarea>

		</span>

		<span class="span6 offset1 border-left">

		<label><?php echo _gettxt('priority') ?></label>
		<?php 	
			$radio_checked = 'checked="checked"';
			$pri5 = $pri4 = $pri3 = $pri2 = $pri1 = '';
			if( $task->priority == 5 ) $pri5 = $radio_checked;
			if( $task->priority == 4 ) $pri4 = $radio_checked;
			if( $task->priority == 3 ) $pri3 = $radio_checked;
			if( $task->priority == 2 ) $pri2 = $radio_checked;
			if( $task->priority == 1 ) $pri1 = $radio_checked;
		?>
		<label class="radio inline">
			<input type="radio" name="priority" value="5" <?php echo $pri5; ?> /><span class="label label-success"><?php echo _gettxt('priority_very_low') ?></span>
		</label>
		<label class="radio inline">
			<input type="radio" name="priority" value="4" <?php echo $pri4; ?> /><span class="label label-success"><?php echo _gettxt('priority_low') ?></span>
		</label>
		<label class="radio inline">
			<input type="radio" name="priority" value="3" <?php echo $pri3; ?> /><span class="label label-info"><?php echo _gettxt('priority_normal') ?></span>
		</label>
		<label class="radio inline">
			<input type="radio" name="priority" value="2" <?php echo $pri2; ?> /><span class="label label-important"><?php echo _gettxt('priority_high') ?></span>
		</label>
		<label class="radio inline">
			<input type="radio" name="priority" value="1" <?php echo $pri1; ?> /><span class="label label-important"><?php echo _gettxt('priority_very_high') ?></span>
		</label>

		<p></p>
		<p></p>
		<label for="task-assigned_to"><?php echo _gettxt('assigned_to') ?></label>
		<!-- <select name="assigned_to" id="task-assigned_to">
			<option>Select a member</option>
			<?php echo get_members_options($task->assigned_to); ?>
		</select> -->
		<span class="label"><?php echo get_member($task->assigned_to, 'name'); ?></span>
		<br>

		<label><?php echo _gettxt('progress') ?></label>
		1%
		<input type="range" name="total_percent" min="1" max="99" value="<?php echo $task->total_percent; ?>" onchange="jQuery('#total_percent_bar .bar').width(this.value+'%'); jQuery('#total_percent_bar span').html(this.value+'%');"> 99%
		<div class="progress progress-striped" id="total_percent_bar" style="width:250px;">
		  <div class="bar" style="width: <?php echo $task->total_percent; ?>%;"> <span><?php echo $task->total_percent; ?>%</span> </div> 
		</div>
		<br>
		<br>
		</span>

		<span class="span12">
			<button type="submit" class="btn"><?php echo _gettxt('save') ?></button>
		</span>

		</div>

	</form>

</div><!-- end .wrap -->

<?php include('footer.php'); ?>