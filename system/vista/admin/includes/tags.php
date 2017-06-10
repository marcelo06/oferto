<?
 if (!defined('BASEPATH')) die("Entrada inválida");
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<title>RHISS - Sistema Especializado Manejador de Contenidos</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?=URLVISTA?>admin/css/bootstrap.min.css">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="<?=URLVISTA?>admin/css/bootstrap-responsive.min.css">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="<?=URLSRC?>css/jquery-ui/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="<?=URLSRC?>css/jquery-ui/smoothness/jquery.ui.theme.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?=URLVISTA?>admin/css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="<?=URLVISTA?>admin/css/themes.css">

		<!-- jQuery -->
	<script src="<?=URLVISTA?>admin/js/jquery.min.js"></script>
	<!-- Mobile nav swipe -->
	<script src="<?=URLSRC?>js/touchwipe/touchwipe.min.js"></script>
	<!-- Nice Scroll -->
	<script src="<?=URLSRC?>js/nicescroll/jquery.nicescroll.min.js"></script>
	<!-- imagesLoaded -->
	<script src="<?=URLSRC?>js/imagesLoaded/jquery.imagesloaded.min.js"></script>
	<!-- jQuery UI -->
	<script src="<?=URLSRC?>js/jquery-ui/jquery.ui.core.min.js"></script>
	<script src="<?=URLSRC?>js/jquery-ui/jquery.ui.widget.min.js"></script>
	<script src="<?=URLSRC?>js/jquery-ui/jquery.ui.mouse.min.js"></script>
	<script src="<?=URLSRC?>js/jquery-ui/jquery.ui.resizable.min.js"></script>
	<script src="<?=URLSRC?>js/jquery-ui/jquery.ui.sortable.min.js"></script>
	<!-- slimScroll -->
	<script src="<?=URLSRC?>js/slimscroll/jquery.slimscroll.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?=URLVISTA?>admin/js/bootstrap.min.js"></script>
	<!-- Bootbox -->
	<script src="<?=URLSRC?>js/bootbox/jquery.bootbox.js"></script>
	<!-- Bootbox -->
	<script src="<?=URLSRC?>js/form/jquery.form.min.js"></script>
	<!-- Validation -->
	<script src="<?=URLSRC?>js/validation/jquery.validate.js"></script>
    <script src="<?=URLSRC?>js/validation/jquery.validate.es.js"></script>
    
	<script src="<?=URLSRC?>js/validation/additional-methods.min.js"></script>


	<!-- Theme framework -->
	<script src="<?=URLVISTA?>admin/js/eakroko.min.js"></script>
	



	<!--[if lte IE 9]>
		<script src="<?=URLSRC?>js/placeholder/jquery.placeholder.min.js"></script>
		<script>
			$(document).ready(function() {
				$('input, textarea').placeholder();
			});
		</script>
		<![endif]-->
	<script type="text/javascript">
	function actualizarOfertaComentario(){
		$.post("producto-actualizar_comentarios_pendientes",{},function(data){
			if(data==1){
				$("#n-ofertas-com").remove();
			}
		})
	}
	</script>

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?=URLVISTA?>admin/img/favicon.ico" />
	<!-- Apple devices Homescreen icon -->
	<link rel="apple-touch-icon-precomposed" href="<?=URLVISTA?>admin/img/apple-touch-icon-precomposed.png" />
    <?= plugin::fancybox_2_1() ?>