<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
//id, name, assigned_to, priority, created_by, date_added
?>
<div class="wrap">
  
  <a href="<?php echo base_url('/projects/edit/'. $project->id); ?>" class="btn btn-success pull-right" title="<?php echo _gettxt('edit') ?>"><span class="icon-pencil"></span> <?php echo _gettxt('edit') ?></a>
  <h3><?php echo _gettxt('project'); ?></h3>
  <div class="project-descript">
    <strong><?php echo _gettxt('name'); ?>:</strong> <?php echo $project->name; ?>  <br>
    <strong><?php echo _gettxt('description'); ?>:</strong> <?php echo $project->description; ?>
  </div>

  <hr>

  <a href="<?php echo base_url('/tasks/add/'. $project->id); ?>" class="btn btn-primary pull-right"><?php echo _gettxt('task_add_txt'); ?></a> 
  <h4><?php echo _gettxt('tasks'); ?></h4>
  <br>
  <div class="project-item-block">
  <?php if( !empty($tasks) ): ?>
    <table class="table table-bordered table-hover table-condensed">
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
          $task_solved  = ''; 
          if ($task->status!=1) 
            $task_solved = 'muted'; 
          $task_date_added = strtotime($task->date_added);
          $task_due_date  = strtotime($task->task_due_date);
          $today_start    = strtotime(date('Y-m-d '). '00:00:00');
          $today_end      = strtotime(date('Y-m-d '). '23:59:59');
          $task_to_today  = ( $task_due_date > $today_start && $task_due_date < $today_end ) ? ' warning' : '';
          $task_url_0     = base_url('/tasks/show/'.$task->id); // view task
          $task_url_1     = base_url('/tasks/task_change_percent/'.$task->id.'?iframe=true'); // change progress
          $task_url_2     = base_url('/tasks/assigned_to/'.$task->id.'?iframe=true'); // change assigned_to
          $task_url_3     = base_url('/tasks/edit/'.$task->id); // edit task
          $task_url_4     = base_url('/tasks/remove/'.$task->id); // remove task
          $task_url_5     = base_url('/tasks/finalize/'.$task->id); // finalize task
          $task_url_6     = base_url('/tasks/task_assigned_to/'.$task->id); // view task
          //$task_url_3     = base_url('/tasks/show/'.$task->id); // view task
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

  </div><!-- end .project-item-block -->
  
  <?php /* ?>
  <h4><?php echo _gettxt('recents_comments'); ?></h4>
  <div class="project-item-block">

  <?php if( !empty($task_comments) ): ?>
    <table class="table table-bordered table-hover table-condensed">
      <thead>
        <tr>
          <th><?php echo _gettxt('subject') ?></th>           
          <th><?php echo _gettxt('comment') ?></th>
          <th><?php echo _gettxt('task') ?></th>
          <th><?php echo _gettxt('created_by') ?></th>
        </tr>
      </thead>
      <tbody>
    <?php foreach ($task_comments as $comment): ?>
       
        <tr class="<?php echo $task_solved . $task_to_today; ?>">
          <td><?php echo $comment->subject ?></td>
          <td><?php echo $comment->comment ?></td>
          <td><?php echo get_task($comment->task_id, 'name') ?></td>
          <td><?php echo get_member( $comment->created_by, 'name'); ?></td>
        </tr>
    <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="no-listing img-rounded"><span class="label label-success"><?php echo _gettxt('no_comments'); ?></span></div>
  <?php endif; ?>

  </div><!-- end .project-item-block -->


  <?php */ ?>
  
  <h4><?php echo _gettxt('files'); ?></h4>
  <div class="project-item-block">

    <?php if( !empty($task_files) ): ?>    

      <?php foreach ($task_files as $tfile): ?>

      <?php $file_description = (strlen($tfile->description) > 0) ? $tfile->description : _gettxt('no_description'); ?>

      <a href="<?php echo base_url('tasks/file/remove/'.$tfile->id); ?>" class="pull-right" title="<?php echo _gettxt('file_remove') ?>">
        <i class="icon-remove"></i>
      </a>

      <strong><?php echo _gettxt('file'); ?>:</strong>

      <?php if( $tfile->is_image ): ?>
        <i class="icon-eye-open"></i> 
        <a href="<?php echo base_url('tasks/file/download/'.$tfile->id); ?>" title="<?php echo $file_description; ?>" rel="prettyPhoto[gallery_down]">
        <?php /* <a href="<?php echo $tfile->full_url; ?>" title="<?php echo $file_description; ?>" rel="prettyPhoto[gallery_down]"> */ ?>
          <?php echo $file_description; ?>
        </a>
      <?php else: ?>
        <i class="icon-download"></i> 
        <a href="<?php echo base_url('tasks/file/download/'.$tfile->id); ?>" title="<?php echo _gettxt('file_download') ?>" class="">
          <?php echo $file_description; ?>
        </a> 
      <?php endif; ?>

      /
      <strong><?php echo _gettxt('task'); ?>:</strong>
      <?php echo get_task($tfile->task_id, 'name') ?>
      <br>

      <?php endforeach; ?>

    <?php else: ?>
      <div class="no-listing img-rounded"><span class="label label-success"><?php echo _gettxt('no_files'); ?></span></div>
    <?php endif; ?>

  </div><!-- end .project-item-block -->

</div><!-- end .wrap -->

<?php include('footer.php'); ?>