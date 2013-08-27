<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
//id, name, assigned_to, priority, created_by, date_added
?>
<div class="wrap">

	<a href="<?php echo base_url('/members/add'); ?>" class="btn pull-right"><?php echo _gettxt('member_add_txt') ?></a>	
	<h3><?php echo _gettxt('members') ?></h3>

	<?php if( isset($msg_error) ): ?>
  <div class="alert alert-error"><?php echo $msg_error ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php elseif( isset($msg_ok) ): ?>
  <div class="alert alert-success"><?php echo $msg_ok ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
  <?php endif; ?>

	<?php if( !empty($members) ): ?>
		<table class="tbl_list table table-bordered table-hover table-condensed">
			<thead>
				<tr>
					<th><?php echo _gettxt('name') ?></th>
					<th><?php echo _gettxt('email') ?></th>
					<th width="130'"><?php echo _gettxt('options') ?></th>
				</tr>
			</thead>

		<?php foreach ($members as $member): ?>
			<tbody>
				<tr>
					<td><?php echo $member->name; ?></td>
					<td><?php echo $member->email; ?></td>
					<td>

					<?php if( $member->id == get_member_session('id') ): ?>
						<a href="<?php echo base_url('/members/change_password/'.$member->id) ?>" class="btn btn-mini" title="<?php echo _gettxt('change_password') ?>"><span class="icon-lock"></span></a>
					<?php endif; ?>
						<a href="<?php echo base_url('/members/edit/'.$member->id) ?>" class="btn btn-mini" title="<?php echo _gettxt('edit') ?>"><span class="icon-pencil"></span></a>
						<a href="<?php echo base_url('/members/remove/'.$member->id) ?>" class="btn btn-mini" title="<?php echo _gettxt('remove') ?>" onclick="javascript:return confirm('<?php echo _gettxt('msg_confirm_member_remove') ?>');"><span class="icon-trash"></span></a>
					</td>
				</tr>
			</tbody>
		<?php endforeach; ?>

		</table>
	<?php else: ?>
		<div class="no-listing img-rounded"><span class="label label-success"><?php echo _gettxt('no_members') ?></span></div>
	<?php endif; ?>

</div><!-- end .wrap -->

<?php include('footer.php'); ?>