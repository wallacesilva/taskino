<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
//id, name, assigned_to, priority, created_by, date_added
?>
<div class="wrap">

	<!-- <a href="<?php echo base_url('/tasks/add'); ?>" class="btn pull-right"><?php echo _gettxt('task_add_txt'); ?></a>	 -->
	<h3><?php echo _gettxt('tasks'). ' '. @$my_tasks; ?></h3>

	<?php if( isset($msg_error) ): ?>
  <div class="alert alert-error"><?php echo $msg_error ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php elseif( isset($msg_ok) ): ?>
  <div class="alert alert-success"><?php echo $msg_ok ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php endif; ?>

	<?php if( !empty($tasks) ): ?>
		<table class="tbl_list table table-bordered table-hover table-condensed">
			<thead>
				<tr>
					<th><?php echo _gettxt('name') ?></th>
					<th><?php echo _gettxt('project') ?></th>
					<?php if (!@$is_dashboard): ?>						
					<th><?php echo _gettxt('assigned_to') ?></th>
					<?php endif ?>
					<th><?php echo _gettxt('created_by') ?></th>
					<th><?php echo _gettxt('due_date') ?></th>
					<th><?php echo _gettxt('options') ?></th>
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
					$task_url_6 		= base_url('/tasks/task_assigned_to/'.$task->id); // view task
					//$task_url_3 		= base_url('/tasks/show/'.$task->id); // view task
				?>
				<tr class="<?php echo $task_solved . $task_to_today; ?>">
					<td>
						<?php echo get_priority_name( $task->priority, true ); ?>
						<a href="<?php echo $task_url_0; ?>">
							<?php echo $task->name; ?>
						</a>
					</td>
					<td>
						<a href="<?php echo base_url('projects/show/'.$task->project_id) ?>">
							<?php echo get_project($task->project_id, 'name'); ?>
						</a>
					</td>
					<?php if (!@$is_dashboard): ?>
					<td><?php echo get_member( $task->assigned_to, 'name'); ?></td>
					<?php endif ?>
					<td><?php echo get_member( $task->created_by, 'name'); ?></td>
					<td><?php echo date('d/m/Y', strtotime($task->task_due_date)); ?></td>
					<td>
						<div class="btn-group">
						  <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">
						    <i class="icon-cog"></i>
						    <span class="caret"></span>
						  </a>
						  <ul class="dropdown-menu">
						  	<li>
						  		<a href="#form-assigned-to-<?php echo $task->id; ?>" class="text-left" title="<?php echo _gettxt('assigned_to') ?>" rel="prettyPhoto">
									<i class="icon-hand-right"></i> <?php echo _gettxt('assigned_to') ?></i>
								</a>
								<div id="form-assigned-to-<?php echo $task->id; ?>" style="display:none;">
									<form method="post" action="<?php echo $task_url_6; ?>">
										<label><?php echo _gettxt('assigned_to') ?></label>
										<select name="assigned_to">
											<?php echo get_members_options(); ?>
										</select>

										<label></label>
										<a href="javascript:;" onclick="$.prettyPhoto.close();" class="btn"><?php echo _gettxt('cancel') ?></a>
										<button type="submit" class="btn btn-primary"><?php echo _gettxt('save') ?></button>
									</form>
								</div>
						  	</li>
							<?php if( $task->status != 2 ): ?>
							<li>
							<a href="<?php echo $task_url_5; ?>" data-confirm-title="<?php echo _gettxt('msg_confirm_task_finalize'); ?>" class="confirm" title="<?php echo _gettxt('finalize') ?>"><span class="icon-ok-circle"></span>
								<?php echo _gettxt('finalize') ?>
							</a>
							</li>
							<?php endif; ?>
						  	<li>
						    <a href="<?php echo $task_url_0; ?>" class="" title="<?php echo _gettxt('task_view') ?>"><span class="icon-eye-open"></span> <?php echo _gettxt('task_view') ?></a>
						  	</li>
							<!-- <a href="<?php echo $task_url_1; ?>" class="btn btn-mini" rel="prettyPhoto" title="Change progress"><span class="icon-signal"></span></a>
							<a href="<?php echo $task_url_2; ?>" class="btn btn-mini" rel="prettyPhoto" title="Change Assigned to"><span class="icon-chevron-right"></span> <i class="icon-user"></i></a> -->
							<li>
							<a href="<?php echo $task_url_3; ?>" class="" title="<?php echo _gettxt('edit') ?>"><span class="icon-pencil"></span> <?php echo _gettxt('edit') ?></a>
							</li>
							<li>
							<a href="<?php echo $task_url_4; ?>" class="confirm" title="<?php echo _gettxt('remove') ?>"
								data-confirm-title="<?php echo _gettxt('msg_confirm_task_remove'); ?>"><span class="icon-trash"></span> <?php echo _gettxt('remove') ?></a>
							</li>
						  </ul>
						</div>
						<div class="hide">
						<a href="#form-assigned-to-<?php echo $task->id; ?>" class="btn btn-mini" title="<?php echo _gettxt('assigned_to') ?>" rel="prettyPhoto">
							<i class="icon-arrow-right"></i><i class="icon-user"></i>
						</a>
						<div id="form-assigned-to-<?php echo $task->id; ?>" style="display:none;">
							<form method="post" action="<?php echo $task_url_6; ?>">
								<label><?php echo _gettxt('assigned_to') ?></label>
								<select name="assigned_to">
									<?php echo get_members_options(); ?>
								</select>

								<label></label>
								<a href="javascript:;" onclick="$.prettyPhoto.close();" class="btn"><?php echo _gettxt('cancel') ?></a>
								<button type="submit" class="btn btn-primary"><?php echo _gettxt('save') ?></button>
							</form>
						</div>
						<a href="<?php echo $task_url_0; ?>" class="btn btn-mini" title="<?php echo _gettxt('task_view') ?>"><span class="icon-eye-open"></span></a>
						<!-- <a href="<?php echo $task_url_1; ?>" class="btn btn-mini" rel="prettyPhoto" title="Change progress"><span class="icon-signal"></span></a>
						<a href="<?php echo $task_url_2; ?>" class="btn btn-mini" rel="prettyPhoto" title="Change Assigned to"><span class="icon-chevron-right"></span> <i class="icon-user"></i></a> -->
						<a href="<?php echo $task_url_3; ?>" class="btn btn-mini" title="<?php echo _gettxt('edit') ?>"><span class="icon-pencil"></span></a>
						<a href="<?php echo $task_url_4; ?>" class="btn btn-mini confirm" title="<?php echo _gettxt('remove') ?>"
							data-confirm-title="<?php echo _gettxt('msg_confirm_task_remove'); ?>"><span class="icon-trash"></span></a>
						<?php if( $task->status != 2 ): ?>
						<a href="<?php echo $task_url_5; ?>" data-confirm-title="<?php echo _gettxt('msg_confirm_task_finalize'); ?>" class="btn btn-mini confirm" title="<?php echo _gettxt('finalize') ?>"><span class="icon-ok-circle"></span></a>
						<?php endif; ?>
						</div>
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