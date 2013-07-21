<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
//id, name, assigned_to, priority, created_by, date_added
?>
<div class="wrap">

	<a href="<?php echo base_url('/tasks/add'); ?>" class="btn pull-right"><?php echo _gettxt('task_add_txt'); ?></a>	
	<h3><?php echo _gettxt('tasks'). ' '. @$my_tasks; ?></h3>

	<?php if( !empty($tasks) ): ?>
		<table class="tbl_list table table-bordered table-hover table-condensed">
			<thead>
				<tr>
					<th><?php echo _gettxt('name') ?></th>
					<?php if (!@$is_dashboard): ?>						
					<th><?php echo _gettxt('assigned_to') ?></th>
					<?php endif ?>
					<th><?php echo _gettxt('created_by') ?></th>
					<th><?php echo _gettxt('due_date') ?></th>
					<th width="160"><?php echo _gettxt('options') ?></th>
				</tr>
			</thead>

			<tbody>
		<?php foreach ($tasks as $task): ?>
				<?php 
					$task_solved 	= ''; 
					if ($task->status!=1) 
						$task_solved = 'muted'; 
					$task_date_added = strtotime($task->date_added);
					$task_due_date 	= strtotime($task->task_due_date);
					$today_start 		= strtotime(date('Y-m-d '). '00:00:00');
					$today_end 			= strtotime(date('Y-m-d '). '23:59:59');
					$task_to_today 	= ( $task_due_date > $today_start && $task_due_date < $today_end ) ? ' warning' : '';
					$task_url_0 		= base_url('/tasks/show/'.$task->id); // view task
					$task_url_1 		= base_url('/tasks/task_change_percent/'.$task->id.'?iframe=true'); // change progress
					$task_url_2 		= base_url('/tasks/assigned_to/'.$task->id.'?iframe=true'); // change assigned_to
					$task_url_3 		= base_url('/tasks/edit/'.$task->id); // edit task
					$task_url_4 		= base_url('/tasks/remove/'.$task->id); // remove task
					$task_url_5 		= base_url('/tasks/finalize/'.$task->id); // finalize task
					//$task_url_3 		= base_url('/tasks/show/'.$task->id); // view task
				?>
				<tr class="<?php echo $task_solved . $task_to_today; ?>">
					<td>
						<?php echo get_priority_name( $task->priority, true ); ?>
						<?php echo $task->name; ?>
					</td>
					<?php if (!@$is_dashboard): ?>
					<td><?php echo get_member( $task->assigned_to, 'name'); ?></td>
					<?php endif ?>
					<td><?php echo get_member( $task->created_by, 'name'); ?></td>
					<td><?php echo date('d/m/Y', strtotime($task->task_due_date)); ?></td>
					<td>
						<a href="<?php echo $task_url_0; ?>" class="btn btn-mini" title="<?php echo _gettxt('task_view') ?>"><span class="icon-eye-open"></span></a>
						<!-- <a href="<?php echo $task_url_1; ?>" class="btn btn-mini" rel="prettyPhoto" title="Change progress"><span class="icon-signal"></span></a>
						<a href="<?php echo $task_url_2; ?>" class="btn btn-mini" rel="prettyPhoto" title="Change Assigned to"><span class="icon-chevron-right"></span> <i class="icon-user"></i></a> -->
						<a href="<?php echo $task_url_3; ?>" class="btn btn-mini" title="<?php echo _gettxt('edit') ?>"><span class="icon-pencil"></span></a>
						<a href="<?php echo $task_url_4; ?>" class="btn btn-mini confirm" title="<?php echo _gettxt('remove') ?>"
							data-confirm-title="<?php echo _gettxt('msg_confirm_task_remove'); ?>"><span class="icon-trash"></span></a>
						<?php if( $task->status != 2 ): ?>
						<a href="<?php echo $task_url_5; ?>" data-confirm-title="<?php echo _gettxt('msg_confirm_task_finalize'); ?>" class="btn btn-mini confirm" title="<?php echo _gettxt('finalize') ?>"><span class="icon-ok-circle"></span></a>
						<?php endif; ?>
					</td>
				</tr>
		<?php endforeach; ?>
			</tbody>

		</table>
	<?php else: ?>
		<div class="no-listing img-rounded"><span class="label label-success"><?php echo _gettxt('no_tasks'); ?></span></div>
	<?php endif; ?>

	<?php if( !empty($pagination) ): ?>
		<div class="pagination pagination-centered">
			<ul><?php echo @$pagination; ?></ul>
		</div>
	<?php endif; ?>

	<!--
	Legend:
	<br>
	<table class="table" style="border-width:1px;border-style: solid; width:auto;display:inline-block;">
		<tr class="warning"><td>Added today</td></tr>
	</table> -->

</div><!-- end .wrap -->

<?php include('footer.php'); ?>