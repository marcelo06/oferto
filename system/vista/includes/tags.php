<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title><?= ( isset($titulo_sitio) )? $titulo_sitio.' - ' : ''; configsite::print_titulo() ?></title>

  <meta name="author" content="info@rhiss.net">
  <meta http-equiv="keywords" content="<?= ( isset($keywords_sitio) )? $keywords_sitio.', ' : ''; configsite::print_keywords() ?>">
  <meta http-equiv="description" content="<?= ( isset($descripcion_sitio) )? $descripcion_sitio.', ' : ''; configsite::print_descripcion() ?>">
	
	<link rel="shortcut icon" href="<?= URLBASE?>favicon.ico">
<? $imag_pag=(nvl($imagen_link,0)) ? $imagen_link :URLFILES.'logo.png';?>
<link href="<?=$imag_pag?>" rel="image_src">

	<link href="<?=URLVISTA?>css/bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="<?=URLVISTA?>css/normalize.css" rel="stylesheet" type="text/css" />
	<link href="<?=URLVISTA?>css/font-face.css" rel="stylesheet" media="screen"/>
	<link href="<?=URLVISTA?>css/slicknav.css" rel="stylesheet" media="screen"/>
	<link href="<?=URLVISTA?>css/ihover.css" rel="stylesheet" media="screen"/>

	<link rel="stylesheet" href="<?=URLVISTA?>css/menu-default.css">
	<link rel="stylesheet" href="<?=URLVISTA?>css/menu-base-theme.css">
		
	<!-- Main Style -->
	<link href="<?=URLVISTA?>css/style.css" rel="stylesheet" type="text/css" />
	
	<!-- Jquery  -->
	<script language="javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

	<!-- Plugins -->
	<script src="<?=URLVISTA?>js/jquery.slicknav.min.js"></script>
	<script type="text/javascript">
	 $(document).ready(function(){$('#nav').slicknav();}); 
	</script>
	
	<!-- Important Owl stylesheet -->
	<link rel="stylesheet" href="<?=URLVISTA?>css/owl.carousel.css">
	<link rel="stylesheet" href="<?=URLVISTA?>css/owl.theme.css"> 
	<link rel="stylesheet" href="<?=URLVISTA?>css/owl.transitions.css"> 
	<script src="<?=URLVISTA?>js/owl.carousel.min.js"></script>
	
	<!-- Important -->
	<script src="<?=URLVISTA?>js/prefixfree.min.js"></script>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<script src="<?=URLVISTA?>js/busqueda.js"></script>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-10478726-10', 'auto');
  ga('send', 'pageview');
</script>

<script type="text/javascript">
  function iratienda(tienda){
	ga('send', 'event', 'Usuario', 'Store', tienda, 1);

		if(tienda=='Apple')
			window.open('https://itunes.apple.com/us/app/oferto/id882068252?l=es&ls=1&mt=8','_blank');
		else if(tienda=='Android')
			window.open('https://play.google.com/store/apps/details?id=net.rhiss.oferto','_blank');
		else if(tienda=='Windows')
			window.open('http://www.windowsphone.com/es-es/store/app/oferto/cd3903f4-0580-49d1-be90-78038ae90c11','_blank');
		else if(tienda=='Blackberry')
			window.open('http://appworld.blackberry.com/webstore/content/...','_blank');
	}

</script>