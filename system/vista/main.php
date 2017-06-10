<? include("includes/tags.php") ?>
<style type="text/css">
#listados{min-height: 800px;}
<? if(count($slides)<=1){?>
#sync2{display: none !important; height: 0 !important;}
<?	}?>
</style>
</head>
<body>
<? include("includes/header.php") ?>

<section id="Main">
<? if(count($slides)){?>
<section id="Middle" class="auto_margin" style="padding-bottom:20px;">
	<div class="row">
	<div class="col-sm-12">
    <div id="sync1" class="owl-carousel">
    	<? foreach ($slides as $slide) { ?>
   	   <div class="item"><a <?=($slide['vinculo']) ? 'href="'.$slide['vinculo'].'" target="_blank"':'' ?>  title="<?=$slide['referencia'] ?>"><img src="<?=$dirfile.'b'.$slide['archivo']?>" alt="<?=$slide['referencia'] ?>" /></a></div>
   	   <? }?>
    </div>
	<div id="sync2" class="owl-carousel">
		<? foreach ($slides as $slide) { ?>
		<div class="item"><img src="<?=$dirfile.'b'.$slide['archivo']?>"></div>
		<? }?>
	</div>
	</div>
	</div>
</section>
<? }?>


<div id="listados"><div id="listaOfertas">
<? if(count($destacados)){ ?>
<section id="Destacados">
	<div class="areaPromociones auto_margin">
	<h2>OFERTAS <strong>DESTACADAS</strong></h2>
	
	    <div id="owl-promo-A">
	    	 <? foreach($destacados as $desta){ 
	 		$nombre=($desta['oferta_descripcion']!='') ? $desta['oferta_descripcion']:$desta['nombre'];
	 		$imagen= ($desta['oferta_imagen']!='') ? $dirprod.'m'.$desta['oferta_imagen']:(($desta['archivo']!='') ? $dirgal.'m'.$desta['archivo']:URLFILES.'producto.png');
			$enlace='main-producto-id-'.$desta['id_producto'].'-t-'.chstr($nombre);
			$precio_old=($desta['precio'] and ($desta['oferta_precio']<$desta['precio'])) ? vn($desta['precio']):'';
			$precio=($desta['oferta_precio']) ? vn($desta['oferta_precio']):'';
			$porcentaje=$desta['porcentaje'];//($desta['precio'] and $desta['oferta_precio']) ? calc_porcentaje($desta['precio'],$desta['oferta_precio']):0;
			$faltan= resta_fechas($desta['oferta_vencimiento'],date("Y-m-d"));
		
	 	?>
	    	<!-- Item -->
	    	<div class="item">
	    		<div class="Promo">
	    		<!-- normal -->
	    		   <div class="ih-item square effect13">
	    		    <a href="<?=$enlace?>"><div class="img"><img src="<?=$imagen?>" alt="<?=$nombre?>"></div></a>
	    		    <?=($porcentaje) ? '<span class="tagOff">'.$porcentaje.'%</span>':''?>
	    		    <? $existencia=1;
						if($desta['oferta_existencia_estado']=='1'){
					   		if(!$desta['oferta_existencia'])
					   			$existencia=0;
					   	}
					   	elseif($desta['existencia_estado']=='1'){
					   		if(!$desta['existencia'])
					   			$existencia=0;
					   	}
					   	if(!$existencia){?>
					   		 <span class="tagStock"></span>
					 <? } ?>
	    		   </div>
	    		    <!-- end normal -->
	    		<h3><a href="<?=$enlace?>"><?=$nombre?></a></h3>
	    		<span class="tt1"><?=$desta['empresa']?></span>
	    		<div class="spc"><span class="esq1a"></span><span class="esq1b"></span></div>
	    		<div class="Prodinfo">
	    		<div class="areaPromo">
	    			<div class="Vence">
	    				<span class="vt1">VENCE:</span>
	    				<span class="vt2"><?=$faltan?> DIAS</span>
	    				<!--span class="vt2">08:03:55</span-->
	    			</div>
	    			<div class="currentPrice">
	    				<span class="pt1">OFERTA</span>
	    				<span class="pt2"><?=$precio?></span>
	    				<span class="pt3"><?=$precio_old?></span>
	    			</div>
	    		</div>
	    		</div>
	    		<span class="bgcode"></span>
	    		</div>
	    	</div><!-- end Item -->
	    	<? }?>
	    </div>
	</div>
</section>
<script>
    $(document).ready(function() {
	    $("#owl-promo-A").owlCarousel({
	    items : 4,
	    navigation : true,
	    itemsDesktop : [1199,4],
	    itemsDesktopSmall : [979,3],
	    itemsTablet : [768,3],
		itemsMobile : [640,2],
	    });
    });
</script>
<? }?>
<? $i=0; if(count($categorias)){
	foreach($categorias as $cate){ ?>


<section id="OfertasCat" class="bgColor<?=($i%2==0) ? '1':'2'?>">
	<div class="areaPromociones auto_margin">
	<h2>OFERTAS / <strong><?=strtoupper($cate['categoria'])?></strong><a class="t_todas" href="main-productos-c-<?=$cate['id_categoria']?>-t-<?=chstr($cate['categoria'])?>">ver todas ></a></h2>
	
	    <div id="owl-promo-<?=chstr($cate['categoria']) ?>">
	    	<? $nombre="";$imagen="";$enlace="";$precio_old="";$precio="";$faltan="";$porcentaje=0;
	    	
	    	foreach ($cate['productos'] as $producto) {
	    	$nombre=($producto['oferta_descripcion']!='') ? $producto['oferta_descripcion']:$producto['nombre'];
	 		$imagen= ($producto['oferta_imagen']!='') ? $dirprod.'m'.$producto['oferta_imagen']:(($producto['archivo']!='') ? $dirgal.'m'.$producto['archivo']:URLFILES.'producto.png');
			$enlace='main-producto-id-'.$producto['id_producto'].'-t-'.chstr($nombre);
			$precio_old=($producto['precio'] and ($producto['oferta_precio']<$producto['precio'])) ? vn($producto['precio']):'';

			$precio=($producto['oferta_precio']) ? vn($producto['oferta_precio']):'';
			$porcentaje=$producto['porcentaje'];//($producto['precio'] and $producto['oferta_precio']) ? calc_porcentaje($producto['precio'],$producto['oferta_precio']):'';
			$faltan=resta_fechas($producto['oferta_vencimiento'],date("Y-m-d")); 
			
			?>
	   	
	    	<!-- Item -->
	    	<div class="item">
	    		<div class="Promo">
	    		<!-- normal -->
	    		   <div class="ih-item square effect13">
	    		    <a href="<?=$enlace?>"><div class="img"><img src="<?=$imagen?>" alt="<?=$nombre?>"></div></a>
	    		    <?=($porcentaje) ? '<span class="tagOff">'.$porcentaje.'%</span>':''?>
	    		    <? $existencia=1;
						if($producto['oferta_existencia_estado']=='1'){
					   		if(!$producto['oferta_existencia'])
					   			$existencia=0;
					   	}
					   	elseif($producto['existencia_estado']=='1'){
					   		if(!$producto['existencia'])
					   			$existencia=0;
					   	}
					   	if(!$existencia){?>
					   		 <span class="tagStock"></span>
					 <? } ?>
	    		   
	    		   </div>
	    		    <!-- end normal -->
	    		<h3><a href="<?=$enlace?>"><?=$nombre?></a></h3>
	    		<span class="tt1"><?=$producto['empresa']?></span>
	    		<div class="spc"><span class="esq<?=($i%2==0) ? '2':'3'?>a"></span><span class="esq<?=($i%2==0) ? '2':'3'?>b"></span></div>
	    		<div class="Prodinfo">
	    		<div class="areaPromo">
	    			<div class="Vence">
	    				<span class="vt1">VENCE:</span>
	    				<span class="vt2"><?=$faltan?> DIAS</span>
	    				<!--span class="vt2">08:03:55</span-->
	    			</div>
	    			<div class="currentPrice">
	    				<span class="pt1">OFERTA</span>
	    				<span class="pt2"><?=$precio?></span>
	    				<span class="pt3"><?=$precio_old?></span>
	    			</div>
	    		</div>
	    		</div>
	    		<span class="bgcode"></span>
	    		</div>
	    	</div><!-- end Item -->
	    <? }?>
	    </div>
	
	
	</div>
</section>
<script>
    $(document).ready(function() {
	    $("#owl-promo-<?=chstr($cate['categoria'])?>").owlCarousel({
	    items : 4,
	    navigation : true,
	    itemsDesktop : [1199,4],
	    itemsDesktopSmall : [979,3],
	    itemsTablet : [768,3],
		itemsMobile : [520,2],
	    });
    });
</script>
<? $i++; }}?>
<? $npopulares=count($populares);
$nvencen=count($vencen);

if($npopulares or $nvencen){ ?>
<section id="OfertasCat" class="bgColor">
	<div class="areaPromociones auto_margin">
	<div class="areaTabs">
	<ul class="nav nav-tabs" id="myTab">
	  <?=($npopulares) ? '<li class="active" ><a href="#populares" data-toggle="tab">+ POPULARES</a></li>':''?>
	  <?=($nvencen) ? '<li><a href="#vencen" data-toggle="tab">VENCEN HOY!</a></li>':''?>
	</ul>
	
	<div class="tab-content">
		<? if($npopulares){?>
	  <div class="tab-pane fade in active" id="populares">
	  	<div id="owl-promo-D">
	  		<? $nombre="";$imagen="";$enlace="";$precio_old="";$precio="";$faltan="";$porcentaje=0;
	  		foreach ($populares as $popular) {
	  			$nombre=($popular['oferta_descripcion']!='') ? $popular['oferta_descripcion']:$popular['nombre'];
				$imagen= ($popular['oferta_imagen']!='') ? $dirprod.'m'.$popular['oferta_imagen']:(($popular['archivo']!='') ? $dirgal.'m'.$popular['archivo']:URLFILES.'producto.png');
				$enlace='main-producto-id-'.$popular['id_producto'].'-t-'.chstr($nombre);
				$precio_old=($popular['precio'] and ($popular['oferta_precio']<$popular['precio'])) ? vn($popular['precio']):'';
				$precio=($popular['oferta_precio']) ? vn($popular['oferta_precio']):'';	
				$porcentaje=$popular['porcentaje'];//($popular['precio'] and $popular['oferta_precio']) ? calc_porcentaje($popular['precio'],$popular['oferta_precio']):0;
				$faltan= resta_fechas($popular['oferta_vencimiento'],date("Y-m-d")); ?>
	  		<!-- Item -->
	  		<div class="item">
	  			<div class="Promo">
	  			<!-- normal -->
	  			   <div class="ih-item square effect13">
	  			    <a href="<?=$enlace?>"><div class="img"><img src="<?=$imagen?>" alt="<?=$nombre?>"></div></a>
	  			    <?=($porcentaje) ? '<span class="tagOff">'.$porcentaje.'%</span>':''?>
	  			    <? $existencia=1;
						if($popular['oferta_existencia_estado']=='1'){
					   		if(!$popular['oferta_existencia'])
					   			$existencia=0;
					   	}
					   	elseif($popular['existencia_estado']=='1'){
					   		if(!$popular['existencia'])
					   			$existencia=0;
					   	}
					   	if(!$existencia){?>
					   		 <span class="tagStock"></span>
					 <? } ?>
	  			   </div>
	  			<!-- end normal -->
	  			<h3><a href="<?=$enlace?>"><?=$nombre?></a></h3>
	  			<span class="tt1"><?=$popular['empresa']?></span>
	  			<div class="spc"><span class="esq1"></span><span class="esq2"></span></div>
	  			<div class="Prodinfo">
	  			<div class="areaPromo">
	  				<div class="Vence">
	  					<span class="vt1">VENCE:</span>
	  					<span class="vt2"><?=$faltan?> DIAS</span>
	  					<!--span class="vt2">08:03:55</span-->
	  				</div>
	  				<div class="currentPrice">
	  					<span class="pt1">OFERTA</span>
	  					<span class="pt2"><?=$precio?></span>
	  					<span class="pt3"><?=$precio_old?></span>
	  				</div>
	  			</div>
	  			</div>
	  			<span class="bgcode"></span>
	  			</div>
	  		</div><!-- end Item -->
	  		<? }?>
	    </div>
	  </div>
	  <? }?>
	  <!-- PRODUCTOS QUE VENCEN HOY -->
	  
	  <? if($nvencen){?>
	  <div class="tab-pane <?=(!$npopulares) ? 'fade in active':''?>" id="vencen">
	  	<div id="owl-promo-E">
	  		<? $nombre="";$imagen="";$enlace="";$precio_old="";$precio="";$faltan="";$porcentaje=0;
	  		foreach ($vencen as $vence) {
	  			$nombre=($vence['oferta_descripcion']!='') ? $vence['oferta_descripcion']:$vence['nombre'];
				$imagen= ($vence['oferta_imagen']!='') ? $dirprod.'m'.$vence['oferta_imagen']:(($vence['archivo']!='') ? $dirgal.'m'.$vence['archivo']:URLFILES.'producto.png');
				$enlace='main-producto-id-'.$vence['id_producto'].'-t-'.chstr($nombre);
				$precio_old=($vence['precio'] and ($vence['oferta_precio']<$vence['precio'])) ? vn($vence['precio']):'';
				$precio=($vence['oferta_precio']) ? vn($vence['oferta_precio']):'';	
				$porcentaje=$vence['porcentaje'];//($vence['precio'] and $vence['oferta_precio']) ? calc_porcentaje($vence['precio'],$vence['oferta_precio']):0;
				$faltan= resta_fechas($vence['oferta_vencimiento'],date("Y-m-d")); ?>	
	  			<!-- Item -->
	  			<div class="item">
	  				<div class="Promo">
	  				<!-- normal -->
	  				   <div class="ih-item square effect13">
	  				    <a href="<?=$enlace?>"><div class="img"><img src="<?=$imagen?>" alt="<?=$nombre?>"></div></a>
	  				    <?=($porcentaje) ? '<span class="tagOff">'.$porcentaje.'%</span>':''?>
	  				    <? $existencia=1;
						if($vence['oferta_existencia_estado']=='1'){
					   		if(!$vence['oferta_existencia'])
					   			$existencia=0;
					   	}
					   	elseif($vence['existencia_estado']=='1'){
					   		if(!$vence['existencia'])
					   			$existencia=0;
					   	}
					   	if(!$existencia){?>
					   		 <span class="tagStock"></span>
					 <? } ?>
	  				   </div>
	  				<!-- end normal -->
	  				<h3><a href="<?=$enlace?>"><?=$nombre?></a></h3>
	  				<span class="tt1"><?=$vence['empresa']?></span>
	  				<div class="spc"><span class="esq1a"></span><span class="esq1b"></span></div>
	  				<div class="Prodinfo">
	  				<div class="areaPromo">
	  					<div class="Vence">
	  						<span class="vt1">VENCE:</span>
	  						<span class="vt2"><?=$faltan?> DIAS</span>
	  						<!--span class="vt2">08:03:55</span-->
	  					</div>
	  					<div class="currentPrice">
	  						<span class="pt1">OFERTA</span>
	  						<span class="pt2"><?=$precio?></span>
	  						<span class="pt3"><?=$precio_old?></span>
	  					</div>
	  				</div>
	  				</div>
	  				<span class="bgcode"></span>
	  				</div>
	  			</div><!-- end Item -->
	  			<? }?>
	  	</div>
	  
	  </div>
<? }?>
	</div>
 </div>	
</div>
</section>
<script>
$('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});
<? if($npopulares){?>
    $("#owl-promo-D").owlCarousel({
    items : 4,
    navigation : true,
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [979,3],
    itemsTablet : [768,3],
	itemsMobile : [520,2],
    });
<? }
 if($nvencen){?>
    $("#owl-promo-E").owlCarousel({
    items : 4,
    navigation : true,
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [979,3],
    itemsTablet : [768,3],
	itemsMobile : [520,2],
    });
<? }?>
</script>
<? }?>
</div></div>

</section>
<? include("includes/footer.php") ?>
<div id="box_app" class="boxPopUp boxPopClosed">
	<div class="contBox" id="contBox">
		<div class="rowContt">
			<span style="text-align:center"><p>Descarga nuestra App</p></span>
			<div style="padding:0 10px 30px 10px;"><img class="img-responsive" src="<?=URLVISTA?>images/logo.png"></div>
			<span class="store"><a href="javascript:iratienda('Apple');" ><img src="<?=URLVISTA?>images/appStore.png" alt="Disponible en App Store" /></a></span>
			<span class="store"><a href="javascript:iratienda('Android');" ><img src="<?=URLVISTA?>images/playStore.png" alt="Obtenlo en Google Play" style="padding-top:2px;"/></a></span>
			<span class="store"><a href="javascript:iratienda('Windows');" ><img src="<?=URLVISTA?>images/winapp.png" alt="Descargalo de la tienda de Windows Phone" style="padding-top:2px;" /></a></span>
			<!--span class="store"><a href="javascript:irATienda('blackberry');" target="_blank"><img src="<?=URLVISTA?>images/blackberryworld.png" alt="Obtenlo en BlackBerry World" /></a></span-->
			<a class="cerrarBox" href="javascript:ocultarBox()"></a>
		</div>			
	</div>
</div>
<script type="text/javascript">
var esmovil=0;
$(document).ready(function() {
if(detectmob()){
	esmovil=1;
	$(document).click(function(event) { 
    if(!$(event.target).closest('#contBox').length) {
       ocultarBox();
    }        
})

	mostrarBox();
}

if(esmovil){
	$("#Middle").hide();
}else{
	var sync1 = $("#sync1");
	var sync2 = $("#sync2");

	sync1.owlCarousel({
		singleItem : true,
		slideSpeed : 5000,
		navigation: true,
		pagination:false,
		<? if(count($slides)>1){?>autoPlay:true,<? }?>
		transitionStyle : "fadeUp",
		afterAction : syncPosition,
		responsiveRefreshRate : 200,
	});

	sync2.owlCarousel({
		items : 4,
		itemsDesktop : [1199,4],
		itemsDesktopSmall : [979,4],
		itemsTablet : [768,3],
		itemsMobile : [479,2],
		pagination:false,
		responsiveRefreshRate : 100,
		afterInit : function(el){
			el.find(".owl-item").eq(0).addClass("synced");
		}
	});


	

	$("#sync2").on("click", ".owl-item", function(e){
		e.preventDefault();
		var number = $(this).data("owlItem");
		sync1.trigger("owl.goTo",number);
	});

	
}
function syncPosition(el){
		var current = this.currentItem;
		$("#sync2")
		.find(".owl-item")
		.removeClass("synced")
		.eq(current)
		.addClass("synced")
		if($("#sync2").data("owlCarousel") !== undefined){
			center(current)
		}
	}

	function center(number){
		var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
		var num = number;
		var found = false;
		for(var i in sync2visible){
			if(num === sync2visible[i]){
				var found = true;
			}
		}

		if(found===false){
			if(num>sync2visible[sync2visible.length-1]){
				sync2.trigger("owl.goTo", num - sync2visible.length+2)
			}else{
				if(num - 1 === -1){
					num = 0;
				}
				sync2.trigger("owl.goTo", num);
			}
		} else if(num === sync2visible[sync2visible.length-1]){
			sync2.trigger("owl.goTo", sync2visible[1])
		} else if(num === sync2visible[0]){
			sync2.trigger("owl.goTo", num-1)
		}
	}



});

function mostrarBox(){
	var dheight=$( window ).height()+1000 ;
	$('#box_app').css({'height':dheight+'px'});
	$("#box_app").removeClass('boxPopClosed');
	$("#box_app").addClass('boxPopOpen');
	
	 $('#box_app')[0].scrollIntoView( true );
}
function ocultarBox(){
		$("#box_app").removeClass('boxPopOpen');
		$("#box_app").addClass('boxPopClosed');
}


function detectmob() { 
 if( navigator.userAgent.match(/Android/i)
 || navigator.userAgent.match(/webOS/i)
 || navigator.userAgent.match(/iPhone/i)
 || navigator.userAgent.match(/iPad/i)
 || navigator.userAgent.match(/iPod/i)
 || navigator.userAgent.match(/BlackBerry/i)
 || navigator.userAgent.match(/Windows Phone/i)
 ){
    return true;
  }
 else {
    return false;
  }
}
</script>
</body>
</html>