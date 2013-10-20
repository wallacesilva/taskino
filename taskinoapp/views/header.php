<?php 

$html_lang = 'en';
if( get_taskino_language() == 'portuguese' )
	$html_lang = 'pt-BR';
?>
<!DOCTYPE html>
<html lang="<?php echo $html_lang; ?>">
<head>
	<meta charset="utf-8">
	<title>Taskino</title>
	<base href="<?php echo base_url() ?>" />


	<link rel="stylesheet" type="text/css" href="media/bootstrap/css/bootstrap.min.css" /> <!-- css bootstrap -->
	<!-- <link rel="stylesheet" type="text/css" href="media/bootstrap/css/bootstrap-responsive.min.css" />  -->
	<link rel="stylesheet" type="text/css" href="media/css/prettyPhoto.css" /> <!-- css prettyphoto -->
	<link rel="stylesheet" type="text/css" href="media/font-awesome/css/font-awesome.min.css" /> <!-- css font-awesome -->
	<link rel="stylesheet" type="text/css" href="media/css/styles.css?r=<?php echo filemtime(FCPATH. 'media/css/styles.css') ?>" />

	<script type="text/javascript" src="media/js/jquery-1.8.3.min.js"></script> <!-- jquery -->
	<script type="text/javascript" src="media/bootstrap/js/bootstrap.min.js"></script> <!-- twitter bootstrap -->
	<script type="text/javascript" src="media/js/jquery.prettyPhoto.js"></script> <!-- prettyphoto -->
	<script type="text/javascript" src="media/js/bootstrap-bootbox.min.js"></script> <!-- bootbox -->
	<script type="text/javascript">
	jQuery(document).ready(function($){

		// tooltip animated
		$('.tooltip').tooltip();

		// modals
		//$('.gomodal-iframe').modal({remote: true});

		// prettyphoto
		$("a[rel^='prettyPhoto']").prettyPhoto({social_tools:''});

		// modal personal
		$('.gomodal').click(function(){

			var modal_id = '#gomodal-iframe';
			var modal_iframe_src = $(this).attr('href');
			var close_reload = $(this).attr('data-close-reload');
			$(modal_id).on('show', function(){
        $('iframe#gomodal_body_iframe').attr("src",modal_iframe_src);
        // adaptar melhor a tela
        //$(this).width('70%').css({'margin-left':'-35%'});
			}).on('hidden', function () {

				// if necessary reload page
				if( close_reload == true || close_reload == 'true' ){
					window.location.reload();
				}
			  
			});

		  $(modal_id).modal({show:true});

		  return false;

		});

		$('.confirm').click(function(e){
			e.preventDefault();

			var title = $(this).attr('data-confirm-title');
			var confirm_url = $(this).attr('href');
			bootbox.confirm( title, function(result){

				if( result ){
					window.location.href = confirm_url;
				}

			});

		});

	});

	function hide_modal_iframe(){
		$('#myModal').modal('hide');
	}
	</script>
</head>
<body>
<div id="gomodal-iframe" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>&nbsp;</h3>
	</div>
	<div class="modal-body">
    <iframe src="" id="gomodal_body_iframe" style="zoom:0.60" width="99.6%" height="500" frameborder="0"></iframe>
	</div>
</div>

	<div class="gowrapper">

		<?php 
		if( strpos(current_url(), 'auth') == FALSE )
			include('header-menu.php'); 
		?>

		<div class="container">
		