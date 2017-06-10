<? include("includes/tags.php") ?>
<link href="<?=URLVISTA?>css/font-awesome.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcDJiJScRoTu-QvBMQY62NqmrykF_tZLc&sensor=false"></script>
<script type="text/javascript" src="<?=URLVISTA?>js/infobox.js"></script>
<script type="text/javascript" src="<?=URLVISTA?>js/mapa.js?v=2"></script>		
<script type="text/javascript">
    urlvista='<?=URLVISTA?>';
    categoria='<?=$categoria?>';
    oferta='<?=$oferta?>';
</script>
<style type="text/css">
     .areaCats .filtro .dropSelct {
  border-right:none;
  padding-bottom: 15px;
  padding-top: 16px;
}
</style>

</head>
<body>
<? include("includes/header.php") ?>

<div class="areaHead auto_margin">
	<div class="guia"><a href="">INICIO</a> / <?=($categoria) ? 'CATEGORÍA   /</div><h1>'.$cate['categoria'].'</h1>':(($oferta) ? 'OFERTA   /</div><h1>'.$ofer['nombre'].'</h1>':'MAPA DE OFERTAS </div>')?>
	
</div>
<script>
    $(document).ready(function() {
    $("#owl-Map").owlCarousel({
    autoPlay : 5000,
    stopOnHover : true,
    pagination:true,
    paginationSpeed : 1000,
    goToFirstSpeed : 2000,
    singleItem : true
    });
     
    });
</script>

<section id="Main">
	<div class="areaCats auto_margin">
     
		<div class="areaMap">
			<div id="map-canvas"></div>
		            
		      </div>
	</div>
<? include("includes/populares.php") ?>
<? include("includes/footer.php") ?>
</body>
</html>