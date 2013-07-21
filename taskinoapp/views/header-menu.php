		<div class="header">

			<div class="navbar">
			  <div class="navbar-inner">
			    <ul class="nav">
			      <li><a href="<?php echo base_url('/dashboard') ?>" class="active"><span class="icon-home"></span> <?php echo _gettxt('menu_dashboard'); ?></a></li>
						<!-- <li><a href="<?php echo base_url('/projects') ?>"><span class="icon-briefcase"></span> <?php echo _gettxt('menu_projects') ?></a></li> -->
						<li><a href="<?php echo base_url('/tasks') ?>"><span class="icon-tasks"></span> <?php echo _gettxt('menu_tasks') ?></a></li>
						<li><a href="<?php echo base_url('/members') ?>"><span class="icon-user"></span> <?php echo _gettxt('menu_members') ?></a></li>
			    </ul>
			    <div class="btn-group pull-right" style="margin-left: 2px;">
					  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					  	<span class="icon-user"></span>
					    <?php echo get_member_session('name'); ?>
					    <span class="caret"></span>
					  </a>
					  <ul class="dropdown-menu">
					    <li><a href="<?php echo base_url('/members/edit/'. get_member_session('id')) ?>"><span class="icon-user"></span> <?php echo _gettxt('menu_my_profile') ?></a></li>
					    <li><a href="<?php echo base_url('/auth/logout') ?>"><span class="icon-off"></span> <?php echo _gettxt('menu_logout') ?></a></li>
					  </ul>
					</div>
					<?php // translation ?>
					<div class="btn-group pull-right">
					  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					  	<span class="icon-globe"></span>
					    <span class="caret"></span>
					  </a>
					  <ul class="dropdown-menu">
					    <li>
					    	<a href="<?php echo base_url('/languages/change_to/english') ?>" title="<?php echo _gettxt('menu_english') ?>">
					    		<span class="icon-flag-usa"></span> <?php echo _gettxt('menu_english') ?>
					    	</a>
					    	<a href="<?php echo base_url('/languages/change_to/portuguese') ?>" title="<?php echo _gettxt('menu_portuguese') ?>">
					    		<span class="icon-flag-brazil"></span> <?php echo _gettxt('menu_portuguese') ?>
					    	</a>
					    </li>
					  </ul>
					</div>
			  </div>
			</div>

		</div>