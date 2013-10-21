<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
//id, name, assigned_to, priority, created_by, date_added
?>
<div class="wrap">
<style type="text/css">
.project-box{
  box-shadow: 0px 0px 5px #999;
  border-radius: 4px;
}
.project-box .box-content{
  padding: 5px 10px;  
}
</style>
  <a href="<?php echo base_url('/projects/add'); ?>" class="btn pull-right"><?php echo _gettxt('project_add_txt'); ?></a> 
  <h3><?php echo _gettxt('projects'). ' '. @$my_projects; ?></h3>

  <?php if( isset($msg_error) ): ?>
  <div class="alert alert-error"><?php echo $msg_error ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php elseif( isset($msg_ok) ): ?>
  <div class="alert alert-success"><?php echo $msg_ok ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php endif; ?>

  <?php if( !empty($projects) ): ?>


      <?php /*foreach ($projects as $project): ?>
    <div class="row">
        <span class="span3 project-box">
          <div class="box-content">
            <h4><?php echo $project->name; ?></h4>
            <p><?php echo strip_tags($project->description); ?></p>
            <p class="text-center">
              <a href="<?php echo base_url('/projects/show/'. $project->id); ?>" class="btn btn-info btn-small"><?php echo _gettxt('project_view'); ?></a>
            </p>
          </div>
        </span>
    </div>
      <?php endforeach; */?>
      <table class="tbl_list table table-bordered table-hover table-condensed">
        <thead>
          <tr>
            <th><?php echo _gettxt('name') ?></th>
            <th><?php echo _gettxt('tasks') ?></th>
            <th>
              <abbr title="<?php echo _gettxt('project_percent_explain') ?>"><?php echo _gettxt('project_percent') ?></abbr>
            </th>
            <th width="160"><?php echo _gettxt('options') ?></th>
          </tr>
        </thead>

        <tbody>
      <?php foreach ($projects as $project): ?>
      <?php 
        $total_tasks = get_total_tasks($project->id);
        $total_tasks_finished = get_total_tasks($project->id, 2);

        $total_percent_project = (($total_tasks_finished * 100) / $total_tasks);
      ?>
          <tr>
            <td>
              <a href="<?php echo base_url('/projects/show/'.$project->id); ?>">
              <?php echo $project->name; ?>
              </a>
            </td>
            <td><?php echo $total_tasks; ?></td>
            <td>
              <div class="text-center">
              <?php echo $total_percent_project; ?> %
              </div>
              <div class="progress" style="height:5px; margin:0 auto;">
                <div class="bar bar-success" style="width: <?php echo $total_percent_project; ?>%"><?php echo $total_percent_project; ?>%</div>
              </div>
            </td>
            <td>
              <a href="<?php echo base_url('/tasks/add/'.$project->id); ?>" class="btn btn-mini btn-primary" title="<?php echo _gettxt('task_add_txt') ?>" onmouseover="jQuery(this).find('.hide').show();" onmouseout="jQuery(this).find('.hide').hide();"><i class="icon-plus"></i> <span class="hide"><?php echo _gettxt('task_add_txt') ?></span></a>
              <div class="btn-group">
                <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">
                  <i class="icon-cog"></i>
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- <li><a href="<?php echo base_url('/tasks/add/'.$project->id); ?>" class=""><i class="icon-plus"></i> <?php echo _gettxt('task_add_txt') ?></a></li> -->
                  <li><a href="<?php echo base_url('/projects/show/'.$project->id); ?>" class=""><i class="icon-eye-open"></i> <?php echo _gettxt('project_view') ?></a></li>
                  <li><a href="<?php echo base_url('/projects/edit/'.$project->id); ?>" class=""><i class="icon-pencil"></i> <?php echo _gettxt('edit') ?></a></li>
                  <li><a href="<?php echo base_url('/projects/remove/'.$project->id); ?>" class="confirm" title="<?php echo _gettxt('remove') ?>"
                data-confirm-title="<?php echo _gettxt('msg_confirm_project_remove'); ?>"><span class="icon-trash"></span> <?php echo _gettxt('remove') ?></a></li>
                </ul>
              </div>
            </td>
          </tr>
      <?php endforeach; ?>
    </tbody>
    </table>

  <?php else: ?>
    <div class="no-listing img-rounded"><span class="label label-success"><?php echo _gettxt('no_projects'); ?></span></div>
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