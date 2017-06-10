
<? $npopulares=count($populares);
$nvencen=count($vencen);

if($npopulares or $nvencen){ ?>
<script>
$('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});

$(document).ready(function() {
    $("#owl-promo-D").owlCarousel({
    items : 4,
    navigation : true,
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [979,3],
    itemsTablet : [768,3],
	itemsMobile : [520,2],
    });
});

$(document).ready(function() {
    $("#owl-promo-E").owlCarousel({
    items : 4,
    navigation : true,
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [979,3],
    itemsTablet : [768,3],
	itemsMobile : [520,2],
    });
});
</script>

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
				$imagen= ($popular['oferta_imagen']!='') ? $dirfileo.'m'.$popular['oferta_imagen']:(($popular['archivo']!='') ? $dirfileout.'m'.$popular['archivo']:URLFILES.'producto.png');
				$enlace='main-producto-id-'.$popular['id_producto'].'-t-'.chstr($nombre);
				$precio_old=($popular['precio'] and ($popular['oferta_precio']<$popular['precio'])) ? vn($popular['precio']):'';
				$precio=($popular['oferta_precio']) ? vn($popular['oferta_precio']):'';	
				$porcentaje=$popular['porcentaje'];//$porcentaje=($popular['precio'] and $popular['oferta_precio']) ? calc_porcentaje($popular['precio'],$popular['oferta_precio']):0;
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
	  <!-- PRODUCTOS QUE VENCEN HOY -->
	  
	  <? if($nvencen){?>
	  <div class="tab-pane <?=(!$npopulares) ? 'fade in active':''?>" id="vencen">
	  	<div id="owl-promo-E">
	  			<? $nombre="";$imagen="";$enlace="";$precio_old="";$precio="";$faltan="";$porcentaje=0;
	  		foreach ($vencen as $vence) {
	  			$nombre=($vence['oferta_descripcion']!='') ? $vence['oferta_descripcion']:$vence['nombre'];
				$imagen= ($vence['oferta_imagen']!='') ? $dirfileo.'m'.$vence['oferta_imagen']:(($vence['archivo']!='') ? $dirfileout.'m'.$vence['archivo']:URLFILES.'producto.png');
				$enlace='main-producto-id-'.$vence['id_producto'].'-t-'.chstr($nombre);
				$precio_old=($vence['precio']) ? vn($vence['precio']):'';
				$precio=($vence['oferta_precio'] and ($vence['oferta_precio']<$vence['precio'])) ? vn($vence['oferta_precio']):'';	
				$porcentaje=$vence['porcentaje'];//$porcentaje=($vence['precio'] and $vence['oferta_precio']) ? calc_porcentaje($vence['precio'],$vence['oferta_precio']):0;
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
<? }?>
</section>
