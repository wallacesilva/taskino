<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
//id, task_id, comment, created_by, date_added
?>
<div class="wrap">

	<h3><?php echo _gettxt('tasks') ?></h3>

	<div class="container">
		<div class="row">
			<span class="span4">

				<div class="task_info">

					<strong><?php echo _gettxt('project') ?>:</strong> 
					<a href="<?php echo base_url('projects/show/'.$task->project_id) ?>">
						<?php echo get_project($task->project_id, 'name'); ?>
					</a> <br>

					<strong><?php echo $task->name; ?></strong> <small>(<?php echo date('d/m/Y', strtotime($task->date_added)); ?>)</small>
					<br>
					<small>
						<strong><?php echo _gettxt('assigned_to') ?></strong> <?php echo get_member( $task->assigned_to, 'name'); ?> <br>
						<strong><?php echo _gettxt('due_date') ?></strong> <?php echo date('d/m/Y', strtotime($task->task_due_date)); ?> <br>
					</small>
					<small id="task-more-info">
						<strong><?php echo _gettxt('created_by') ?></strong> <?php echo get_member( $task->created_by, 'name'); ?> <br>
						<strong><?php echo _gettxt('priority') ?></strong> <?php echo get_priority_name( $task->priority, true ); ?> <br>
						<p>
							<strong><?php echo _gettxt('description') ?> </strong>
							<?php echo nl2br($task->description); ?>
						</p>
						<strong><?php echo _gettxt('progress') ?> (<span><?php echo $task->total_percent; ?>%</span>)</strong>
						<div class="progress progress-striped" id="total_percent_bar" style="width:100%;">
						  <div class="bar" style="width: <?php echo $task->total_percent; ?>%;"> </div> 
						</div>
					</small>

					<a href="javascript:jQuery('#task-more-info').slideToggle();" class="btn btn-mini hide" style="width:95%; margin:0 auto;">
						<i class="icon-long-arrow-down"></i>
						<i class="icon-long-arrow-up"></i>
						<?php echo _gettxt('see_more') ?></a> 
					<hr>

					<strong><?php echo _gettxt('task_files') ?></strong> 
					
					<!-- <a href="<?php echo base_url('/tasks/upload/'.$task->id); ?>" class="gomodal pull-right btn btn-mini" data-close-reload="true"> -->
					<a href="<?php echo base_url('/tasks/upload/'.$task->id); ?>?iframe=true" class="pull-right btn btn-mini" rel="prettyPhoto[iframe]">
						<i class="icon-upload"></i> <?php echo _gettxt('file_add') ?>
					</a> 
					<br>
					<?php if( !empty($task_files) ): ?>
					
					<div style="display:block;clear:both;margin:10px 0;">
					<small>

						<?php foreach ($task_files as $tfile): ?>

						<?php $file_description = (strlen($tfile->description) > 0) ? $tfile->description : _gettxt('no_description'); ?>

						<a href="<?php echo base_url('tasks/file/remove/'.$tfile->id); ?>" class="pull-right" title="<?php echo _gettxt('file_remove') ?>">
							<i class="icon-remove"></i>
						</a>

						<?php if( $tfile->is_image ): ?>
							<i class="icon-eye-open"></i> 
							<a href="<?php echo base_url('tasks/file/download/'.$tfile->id); ?>" title="<?php echo $file_description; ?>" rel="prettyPhoto[gallery_down]">
							<?php /* <a href="<?php echo $tfile->full_url; ?>" title="<?php echo $file_description; ?>" rel="prettyPhoto[gallery_down]"> */ ?>
								<?php echo $file_description; ?>
							</a>
							<br>
						<?php else: ?>
							<i class="icon-download"></i> 
							<a href="<?php echo base_url('tasks/file/download/'.$tfile->id); ?>" title="<?php echo _gettxt('file_download') ?>" class="">
								<?php echo $file_description; ?>
							</a> 
							<br>
						<?php endif; ?>
							
						<?php endforeach; ?>
						</div>

					</small>

					<?php else: ?>
						<small><?php echo _gettxt('no_files') ?></small>
					<?php endif; ?>

				</div><!-- end .task_info -->

			</span>
			<span class="span8"> 


				<div class="form_add_comment">
					<strong><?php echo _gettxt('comment_add') ?></strong>

					<form action="<?php echo base_url('/tasks/comment_save'); ?>" method="post">
						
						<input type="hidden" name="task_id" value="<?php echo $task->id; ?>" />

						<!-- <label for="task_subject"></label>
						<input type="text" name="subject" id="task_subject" placeholder="<?php echo _gettxt('subject') ?>" /> -->
						<label for="task_comment"></label>
						<textarea name="comment" id="task_comment" class="form_textarea2 input-xxlarge" placeholder="<?php echo _gettxt('comment') ?>"></textarea>

						<!-- <label></label> -->
						<!-- <input type="submit" class="btn" value="<?php echo _gettxt('save') ?>" />
						<input type="reset" class="btn" value="<?php echo _gettxt('reset') ?>" /> -->
						<button type="submit" id="task_comment_btn_save" class="btn btn-primary"><?php echo _gettxt('save') ?></button>

					</form>
				</div><!-- end .form_add_comment -->

				<strong><?php echo _gettxt('comments') ?>:</strong> <br>

				<?php if (!empty($task_comments)): ?>

					<?php foreach ($task_comments as $comment): ?>
						
						<div class="task_comments_box">

							<div class="comments_title"><?php echo $comment->subject; ?>
								<small class="label pull-right">
									<span class="pull-right"><?php echo get_member( $comment->created_by, 'name'); ?></span>
									 <br>
									<?php $comment_date = strtotime($comment->date_added); ?>
									<?php echo date('d/m/Y', $comment_date); ?>
									<small><?php echo _gettxt('at') ?> <?php echo date('H:i', $comment_date); ?></small>
								</small>
							</div>
							<span class="comments_description">
								<?php echo nl2br($comment->comment); ?>
							</span>

						</div><!-- end .task_comments_box -->
						<hr>

					<?php endforeach; ?>
					
				<?php else: ?>

					<div class="no-listing"><span class="label label-info"><?php echo _gettxt('no_comments') ?></span></div>

				<?php endif; ?>

			</span><!-- end .span8 -->

		</div>
	</div>

</div><!-- end .wrap -->

<?php include('footer.php'); ?>