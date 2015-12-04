		<div class="header">

			<div class="navbar">
			  <div class="navbar-inner">
			    <ul class="nav">
			    	<?php 
			    		//<!-- <span class="text-info"><?php echo get_company(get_member_session('company_id'), 'name'); ? ></span> -->
			    		$url_logo = get_company(get_member_session('company_id'), 'url_logo'); 
			    		$is_url_logo = true;
			    		$file_headers = @get_headers($url_logo);
							if (strpos($file_headers[0],'200')===false)
								$is_url_logo = false;
			    	?>
				    	<a href="javascript:;" class="brand" style="padding:10px 0px 0px 15px">
				    		<img src="media/images/taskino-favicon.png" style="height:25px;" alt="Logo" />
				    	</a>
			    		<?php if( $is_url_logo ): ?>
					    	<a href="javascript:;" class="brand">
					    		<img src="<?php echo $url_logo; ?>" style="height:20px;" alt="Logo" />
					    	</a>
			    		<?php endif; ?>
			      <li><a href="<?php echo base_url('/dashboard') ?>" class="active"><span class="icon-home"></span> <?php echo _gettxt('menu_dashboard'); ?></a></li>
						<li><a href="<?php echo base_url('/projects') ?>"><span class="icon-briefcase"></span> <?php echo _gettxt('menu_projects') ?></a></li>
						<li><a href="<?php echo base_url('/tasks') ?>"><span class="icon-tasks"></span> <?php echo _gettxt('menu_tasks') ?></a></li>
						<?php if( member_is_admin() ): ?>
						<li><a href="<?php echo base_url('/members') ?>"><span class="icon-user"></span> <?php echo _gettxt('menu_members') ?></a></li>
						<li><a href="<?php echo base_url('/settings') ?>"><span class="icon-cog"></span> <?php echo _gettxt('menu_settings') ?></a></li>
						<?php endif; ?>
			    </ul>
			    <div class="btn-group pull-right" style="margin-left: 2px;">
					  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					  	<span class="icon-user"></span>
					    <?php echo get_member_session('name'); ?>
					    <span class="caret"></span>
					  </a>
					  <ul class="dropdown-menu">
					    <li><a href="<?php echo base_url('/members/edit/'. get_member_session('id')) ?>"><span class="icon-user"></span> <?php echo _gettxt('menu_my_profile') ?></a></li>
					    <li><a href="<?php echo base_url('/members/change_password/'. get_member_session('id')) ?>"><span class="icon-lock"></span> <?php echo _gettxt('change_password') ?></a></li>
					    <li><a href="<?php echo base_url('/auth/logout') ?>"><span class="icon-off"></span> <?php echo _gettxt('menu_logout') ?></a></li>
					  </ul>
					</div>
					<!-- REPORT A BUG -->
					<a href="<?php echo base_url('/settings/report_error'); ?>" class="btn btn-danger pull-right" title="<?php echo _gettxt('report_error') ?>"><i class="icon-bug"></i></a> 
					<?php // translation ?>
					<div class="btn-group pull-right" style="display:none;">
					  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					  	<?php if( get_taskino_language() == 'english'): ?>
					  		<span class="icon-flag-usa"></span>
						  <?php else: ?>
							  <span class="icon-flag-brazil"></span>
							<?php endif; ?>
					  	<!-- <span class="icon-globe"></span> -->
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

		</div> <!-- end header -->