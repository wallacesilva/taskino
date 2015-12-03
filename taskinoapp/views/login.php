<?php defined('BASEPATH') OR exit('No direct script access allowed');

include('header.php'); 
//id, name, assigned_to, priority, created_by, date_added
?>
<style type="text/css">
html{
	height: 100%;
}
body{
	background-image: url('media/images/taskino-login-background-opacity.png');
	background-position: top center;
}
.wrap-login{
	width:220px;
	margin:0% auto 5% auto;
	border:1px solid #999;
	padding-left: 20px;
	padding-right: 20px;
	background-color: #fff;
	-webkit-box-shadow: 2px 2px 10px #ccc;
		 -moz-box-shadow: 2px 2px 10px #ccc;
					box-shadow: 2px 2px 10px #ccc;
}
#taskin-language{
	position: absolute;
	top: 10px;
	right: 10px;
}
#footer{color:#fff;}
</style>

<div id="taskin-language" class="pull-right">
	<?php if( isset($company_register) ): ?>
	<a href="<?php echo base_url('/auth') ?>" class="btn btn-info"><?php echo _gettxt('login') ?></a> &nbsp;
  <?php else: ?>
  <a href="<?php echo base_url('/auth/register') ?>" class="btn btn-success"><?php echo _gettxt('reg_register') ?></a> &nbsp;
	<?php endif; ?>

  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
  	<?php if( get_taskino_language() == 'english'): ?>
  		<span class="icon-flag-usa"></span>
	  <?php else: ?>
		  <span class="icon-flag-brazil"></span>
		<?php endif; ?>
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

<p class="text-center" style="visibility:hidden;">
    <img src="media/images/logo-in9web.png" alt="[in9]Web - Logo" style="height:50px;margin-top:10%">
</p>

<div class="wrap-login img-rounded">

	<center>
		<!-- <h3>Taskino</h3> -->
		<h3><img src="media/images/taskino-logo-wide.png" alt="Taskino - Logo"></h3>
		<hr>
	</center>

	<?php if( isset($msg_error) && strlen($msg_error) > 0 ): ?>
	<p class="text-center">
		<span class="label label-important"><?php echo $msg_error; ?></span>
	</p>
	<?php endif; ?>
	<?php if( isset($msg_ok) && strlen($msg_ok) > 0 ): ?>
	<p class="text-center">
		<span class="label label-success"><?php echo $msg_ok; ?></span>
	</p>
	<?php endif; ?>


<?php if( isset($company_register) ): ?>

	<style type="text/css">
	.wrap-login{
		width:500px;
		background-color: #fff;
		background: #fff url(media/images/ID-10041371.jpg) bottom right no-repeat;
		padding-right: 340px;
	}
	body{
		/*color:#fff;*/
		/*background: transparent url(http://demo.udthemes.com/ego/wordpress/light/wp-content/uploads/2013/03/teaser-2.jpg) top left repeat;*/
		/*background: transparent url(http://blogbackgrounds.freeiz.com/wp-content/uploads/2012/05/blackleather-design-pattern-wallpaper-background-texture-copy.jpg) top left repeat;*/
		background: rgb(255,255,255); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(229,229,229,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,1)), color-stop(100%,rgba(229,229,229,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%); /* IE10+ */
		background: linear-gradient(to bottom, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e5e5e5',GradientType=0 ); /* IE6-9 */
		background-image: url('media/images/taskino-login-background-opacity.png');
		background-position: top center;
		
	}
	</style>

	<script type="text/javascript">
  jQuery(document).ready(function($){

    $('#member-login').focusout(function(){
      var self = this;
      var login = this.value;
      var login_url = '<?php echo base_url('auth/check_login/'); ?>/' + login;

      $.get(login_url, function(data) {

        if (data == 'yes') {
        	html_close_alert = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
          after_message = '<?php echo _gettxt('msg_error_login_exists') ?>';
          after_html = '<div class="alert">'+ html_close_alert+ '<span class="help-inline"><span class="text-error">'+ after_message + '</span></span></div>';

          $('.msg-register').empty().html(after_html).slideToggle();
          $(self).focus();

          /*if ($(self).next('.help-inline').remove()) {
            $(self).after(after_html);
          } else{
            $(self).after(after_html);
          }*/

        } else {

          //$(self).next('.help-inline').remove()

        }

      });

    });
  });
  </script>

	<form action="<?php echo base_url('/auth/register'); ?>" method="post">

		<input type="hidden" name="do_register" value="save" />


		<div class="msg-register" style="display:none;">
			<div class="alert"></div>
		</div>

	<span class="span3">
		<!-- <label><?php echo _gettxt('reg_company_name'); ?></label> -->
		<input type="text" name="company_name" placeholder="<?php echo _gettxt('reg_company_name'); ?>" required tabindex="1" />
		<!-- <label><?php echo _gettxt('login'); ?></label> -->
		<input type="text" id="member-login" name="member_admin_login" placeholder="<?php echo _gettxt('login'); ?>" required tabindex="3" />
		<!-- <label><?php echo _gettxt('email'); ?></label> -->
		<input type="email" name="member_admin_email" placeholder="<?php echo _gettxt('email'); ?>" required tabindex="5" />
	</span>

	<span class="span3">
		<!-- <label><?php echo _gettxt('reg_member_name'); ?></label> -->
		<input type="text" name="member_admin_name" placeholder="<?php echo _gettxt('reg_member_name'); ?>" required tabindex="2" />
		<!-- <label><?php echo _gettxt('password'); ?></label> -->
		<input type="password" name="member_admin_pass" placeholder="<?php echo _gettxt('password'); ?>" required tabindex="4" />

		<select name="plan" class="select" tabindex="6" >
			<option value=""><?php echo _gettxt('plan') ?></option>
			<option value="1"><?php echo _gettxt('free') ?></option>
			<option value="2" disabled><?php echo _gettxt('basic') ?></option>
		</select>
	</span>
	
		<p class="text-center">
			
			<input type="submit" class="btn btn-primary btn-large" value="<?php echo _gettxt('reg_register') ?>" />
			
			<br>
			<br>
			<small style="width:60%;display:inline-block;">
			<?php 
				$lang = 'ptbr';
				if (get_taskino_language() == 'english')
					$lang = 'en';
				$accept = _gettxt('reg_accept_terms_policy');
				$accept = str_replace('{url_terms}', base_url('/page/terms/'. $lang). '?iframe=true" rel="prettyPhoto[iframe]', $accept);
				$accept = str_replace('{url_policy}', base_url('/page/privacy/'. $lang). '?iframe=true" rel="prettyPhoto[iframe]', $accept);
				echo $accept;
			?>
			</small>
		</p>

	</form>

<?php elseif( isset($recover_password) ): ?>

	<form action="<?php echo base_url('/auth/save_recover_password/'); ?>" method="post">

		<?php if( isset($activation_key) ): ?>
		<input type="hidden" name="activation_key" value="<?php echo set_value('activation_key', $activation_key); ?>">
		<?php endif; ?>

		<label for="member-password"><?php echo _gettxt('password') ?></label>
		<input type="password" id="password" name="password" pattern=".{3,}" placeholder="<?php echo _gettxt('password') ?>" />

		<label for="member-password-confirm"><?php echo _gettxt('password_confirm') ?></label>
		<input type="password" id="password-confirm" name="password_confirm" pattern=".{3,}" placeholder="<?php echo _gettxt('password_confirm') ?>" />

		<label></label>
		<input type="submit" class="btn btn-small" value="<?php echo _gettxt('save') ?>" />

	</form>		

<?php elseif( isset($member_companies) ): ?>

	<form action="<?php echo base_url('/auth/choose_company/'); ?>" method="post">

		<h3><?php echo _gettxt('company') ?></h3>

		<select name="company_id">
			<option value="0"><?php echo _gettxt('company_select_option'); ?></option>
			<?php foreach ($member_companies as $company_id): ?>
			<option value="<?php echo $company_id->company_id; ?>"><?php echo get_company($company_id->company_id, 'name'); ?></option>
			<?php endforeach ?>
		</select>

		<label></label>
		<input type="submit" class="btn btn-small" value="<?php echo _gettxt('save') ?>" />

	</form>
	
<?php else: ?>

	<script type="text/javascript">
	jQuery(document).ready(function(){
		
		$('#frm-login-login').focus();

		$('#frm-forgot-password').submit(function(){

			$(this).find('#frm_login_recover').removeClass('input-error');

			if( $(this).find('#frm_login_recover').val().length < 1 ){
				$(this).find('#frm_login_recover').addClass('input-error');
				return false;
			}

		});

	});
	</script>

	<form action="<?php echo base_url('/auth/login'); ?>" method="post">

		<input type="text" id="frm-login-login" name="login" class="" placeholder="<?php echo _gettxt('login') ?>" value="<?php echo set_value('login') ?>" required />
		<input type="password" name="password" placeholder="<?php echo _gettxt('password') ?>" required />

		<label></label>
		<div class="row-fluid">
			
			<div class="span4">
				
				<input type="submit" class="btn btn-small span12" value="Login" />

			</div>

			<div class="span8">
				
				<a href="javascript:jQuery('form').slideToggle();" class="btn btn-small span12"><span class="icon-lock"></span> <?php echo _gettxt('forgot_password') ?></a>
			</div>
		</div>

	</form>

	<form id="frm-forgot-password" action="<?php echo base_url('/auth/forgot_password'); ?>" method="post" style="display:none;">

		<input type="hidden" name="recover_password" value="do_please" />

		<label></label>
		<input type="text" id="frm_login_recover" name="login" class="" placeholder="<?php echo _gettxt('login') ?>" required />

		<label></label>
		<a href="javascript:jQuery('form').slideToggle();" class="btn btn-small"><i class="icon-chevron-left"></i> <?php echo _gettxt('back') ?></a>
		<input type="submit" class="btn btn-small" value="<?php echo _gettxt('recover') ?>" />

	</form>

<?php endif; // end if check form recovered password ?>

</div><!-- end .wrap -->

<?php include('footer.php'); ?>