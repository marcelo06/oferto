<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml"> <![endif]-->

<!--[if gt IE 8]><!-->
<html class="no-js" lang="es"> <!--<![endif]-->
<head>

  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?= ( isset($titulo_sitio) )? $titulo_sitio.' - ' : ''; empresa::print_titulo() ?></title>

  <meta name="author" content="info@rhiss.net"/>

  <meta http-equiv="description" content="<?= ( isset($descripcion_sitio) )? $descripcion_sitio.', ' : ''; empresa::print_descripcion() ?>"/>

  <link rel="icon" href="<?=empresa::get_logo('f');?>" type="image/x-icon" />
  <link rel="shortcut icon" href="<?=empresa::get_logo('f');?>" type="image/x-icon" />
  
<!--[if lt IE 7]>
<script type="text/javascript">
//<![CDATA[
    var BLANK_URL = 'http://shopper.queldorei.com/js/blank.html';
    var BLANK_IMG = 'http://shopper.queldorei.com/js/spacer.gif';
//]]>
</script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?=URLVISTA?>skin/comercio/media/css/style.css" media="all" />
<? if(defined('COLOR')){?>
<link rel="stylesheet" type="text/css" href="<?=URLVISTA?>skin/comercio/css/color_<?=COLOR?>.css" media="all" />
<? }?>

<!--link rel="stylesheet" type="text/css" href="<?=URLVISTA?>skin/comercio/media/css/otro.css" media="print" -->
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/media/js/prototype1.7.js"></script>
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/js/jquery.validate.min.js"></script>




<!--[if lt IE 8]>
<link rel="stylesheet" type="text/css" href="<?=URLVISTA?>skin/comercio/media/css/magneto.css" media="all" />
<![endif]-->
<!--[if lt IE 7]>
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/js/transparence.js"></script>
<![endif]-->
<!--[if lt IE 9]>
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/media/js/shiv.js"></script>
<![endif]-->
<!--[if !IE]>
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/media/js/jSwipe.js"></script>
<![endif]-->
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/js/jquery.themepunch.plugins.min.js"></script>
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/js/jquery.themepunch.revolution.min.js"></script>
<link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="<?=URLVISTA?>skin/comercio/media/css/easydropdown.css"/>
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/media/js/jquery.easydropdown.min.js"></script>

<script type="text/javascript">//<![CDATA[
var Translator = new Translate([]);
//]]></script>
<script type="text/javascript">
    //<![CDATA[
    var Shopper = {};
    Shopper.url = 'http://shopper.queldorei.com/';
    Shopper.store = 'en';
    Shopper.price_circle = 1;
    Shopper.fixed_header = 1;
    Shopper.totop = 1;
    Shopper.responsive = 1;
    Shopper.quick_view = 0;
    Shopper.shopby_num = '5';
    Shopper.text = {};
    Shopper.text.more = 'more...';
    Shopper.text.less = 'less...';
    Shopper.anystretch_bg = '';
        //]]>
</script>

<script type="text/javascript">

function ver_mapa()
{
	jQuery.fancybox( 'main-almacenes',{
			'hideOnContentClick': false,
			'height': 700,
			'width': jQuery(window).width()-100,
			'type' : 'iframe' ,
			'autoDimensions': true
		});
}

        </script>
 <script type="text/javascript">
    var CONFIG_REVOLUTION = {
        delay:9000,
        startwidth:1200,
        startheight:450,
        hideThumbs:200,
        navigationType:"bullet",
        navigationArrows:"verticalcentered",
        navigationStyle:"round",
        touchenabled:"on",
        shuffle:"off",
        navOffsetHorizontal:0,
        navOffsetVertical:-14,
        onHoverStop:"on",
        
        hideCaptionAtLimit:0,
        hideAllCaptionAtLilmit:0,
        hideSliderAtLimit:0,
        stopAtSlide:-1,
        stopAfterLoops:-1,
        fullWidth:"off"
    };
</script>
<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
 chromium.org/developers/how-tos/chrome-frame-getting-started -->
 <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
 <!--script language="javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script-->
 <script src="<?=URLVISTA?>skin/comercio/js/carrito.js"></script>
 <script type="text/javascript">
 jQuery(document).ready(function($) {
  getCarrito('producto-tabla_carrito');
})
 </script>
 <link rel="stylesheet" href="<?= URLSRC ?>smoke/smoke.css" type="text/css" media="screen" />
<link id="theme" rel="stylesheet" href="<?=URLVISTA?>css/smokedark.css" type="text/css" media="screen" />
<script src="<?= URLSRC ?>smoke/smoke.js" type="text/javascript"></script>
<script src="<?= URLVISTA ?>skin/comercio/js/busqueda.js" type="text/javascript"></script>
