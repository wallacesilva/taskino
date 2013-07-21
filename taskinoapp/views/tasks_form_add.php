<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
//id, name, assigned_to, priority, created_by, date_added
?>
<div class="wrap">

	<h3><?php echo _gettxt('tasks') ?></h3>

	<form action="<?php echo base_url('/tasks/save'); ?>" method="post">

		<div class="row">

		<span class="span5">

			<input type="hidden" name="form_action" value="save" />

			<label for="task-name"><?php echo _gettxt('name') ?></label>
			<input type="text" id="task-name" name="name" class="span5" placeholder="<?php echo _gettxt('name') ?>" value="<?php echo set_value('name') ?>" />

			<label for="task-description"><?php echo _gettxt('description') ?></label>
			<textarea name="description" id="task-description" class="span5" placeholder="<?php echo _gettxt('description') ?>"><?php echo set_value('description') ?></textarea>

		</span>
 
		<span class="span6 offset1 border-left">

			<label><?php echo _gettxt('priority') ?></label>
			<label class="radio inline">
				<input type="radio" name="priority" value="5" /><span class="label label-success"><?php echo _gettxt('priority_very_low') ?></span>
			</label>
			<label class="radio inline">
				<input type="radio" name="priority" value="4" /><span class="label label-success"><?php echo _gettxt('priority_low') ?></span>
			</label>
			<label class="radio inline">
				<input type="radio" name="priority" value="3" checked="checked"/><span class="label label-info"><?php echo _gettxt('priority_normal') ?></span>
			</label>
			<label class="radio inline">
				<input type="radio" name="priority" value="2" /><span class="label label-important"><?php echo _gettxt('priority_high') ?></span>
			</label>
			<label class="radio inline">
				<input type="radio" name="priority" value="1" /><span class="label label-important"><?php echo _gettxt('priority_very_high') ?></span>
			</label>

			<br>
			<br>

			<label for="task-assigned_to"><?php echo _gettxt('assigned_to') ?></label>
			<select name="assigned_to" id="task-assigned_to">
				<option><?php echo _gettxt('member_select_option') ?></option>
				<?php echo get_members_options(); ?>
			</select>

			<label for="task-due-date"><?php echo _gettxt('due_date') ?></label>
			<input type="date" id="task-due-date" name="task_due_date" value="<?php echo set_value('task_due_date') ?>" />


		</span>

		<span class="span12">
			
			<label></label>
			<label class="checkbox inline">
				<input type="checkbox" name="notify_by_email" /> <?php echo _gettxt('msg_notify_by_email') ?>
			</label>

			<p></p>
			<p></p>

			<button type="submit" class="btn"><?php echo _gettxt('save') ?></button>
		</span>

	</div> <!-- end .row -->

	</form>

</div><!-- end .wrap -->

<?php include('footer.php'); ?>