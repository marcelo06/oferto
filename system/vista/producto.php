<? include("includes/tags.php") ?>
<link href="<?=URLVISTA?>css/font-awesome.css" rel="stylesheet"/>
<!-- Important Gallery -->
	<link rel="stylesheet" href="<?=URLVISTA?>css/fotorama.css">
<script src="<?=URLVISTA?>js/fotorama.js"></script>
<?= plugin::fancybox_2_1()?>
<script src="<?= URLVISTA ?>js/jRating.jquery.js" type="text/javascript"></script>
<link href="<?= URLVISTA ?>css/jRating.jquery.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
var id_producto=<?=nvl($producto['id_producto'],0)?>;
var carrito_act= <?= (count($adicionales)) ? 0:1 ?>;
var adicionales=[];
var cantidad=1;
<? if(count($adicionales)){
  foreach ($adicionales as $adicional){ $a=0; ?>
    adicionales.push(0);	 
    <? $a++;}} ?>

function enviarcompra(){
	cadena='';
	 for(i=0; i< adicionales.length;i++){
          cadena+='_'+$("input[name=opcion"+i+"]:checked").val();
      }
     cantidad= $("#cantidad").val();
    //console.log(cadena);
    if(cantidad>0)
	window.location='<?= (nvl($_SESSION['id_tipo_usuario'])==5) ? 'producto-checkout-comprar-'.$producto['id_producto']:'main-registro-comprar-'.$producto['id_producto'] ?>'+cadena+'-c-'+cantidad;
}
</script>
<script src="<?= URLVISTA ?>js/producto.js" type="text/javascript"></script>
<style type="text/css">
.add-cart:hover #span_cart { display:block;}
.seguir-emp:hover #span_seguir { display:block;} 
.cant-compra{width: 21px; padding: 5px 2px; display: inline-block; text-align: center;}
.span_cant{color: #ff0000;}
.tab-content > .tab-paneDetalles {padding: 10px;}
</style>
</head>
<body>
<? include("includes/header.php") ?>

<div class="areaHead auto_margin lpadding">
	<div class="guia"><a href="">INICIO</a> / CATEGORÍA /</div>
	<h1 style="text-transform:uppercase"><?=nvl($empresa['categoria'])?></h1>
</div>

<section id="Main">
	

	<div class="areaCats auto_margin">
		<? if (isset($producto['id_producto'])){ ?>
		
		<?  $precio_old=($producto['precio'] and ($producto['oferta_precio']<$producto['precio'])) ? vn($producto['precio']):'';
	$precio=($producto['oferta_precio']) ? vn($producto['oferta_precio']):'';	
	$porcentaje=($producto['precio'] and $producto['oferta_precio']) ? '<span class="tagOff">'.calc_porcentaje($producto['precio'],$producto['oferta_precio']).'%</span>':0;
	$faltan= resta_fechas($producto['oferta_vencimiento'],date("Y-m-d")); ?>
	<div class="barTop">
		<? if(nvl($empresa['logo'])!=''){?><div class="logo">
		  <figure><img src="<?=$diremp.'s'.$empresa['logo']?>" alt="<?=$empresa['nombre']?>" /></figure>
		</div>
		<? }?>

		<div class="Share">
	  <span class="title">COMPARTIR:</span>
	  <span class="red sh-facebook"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode("http://".DOMINIO.URLBASE.QSTRING)?>" title="facebook"></a></span>
	  <span class="red sh-twitter"><a href="https://twitter.com/intent/tweet?text=<?=strip_tags($titulo)?>+http://<?=DOMINIO.URLBASE.QSTRING?>" title="twitter" target="_blank"></a></span>
	  <span class="red sh-google"><a href="https://plus.google.com/share?url=http://<?=DOMINIO.URLBASE.QSTRING?>&hl=es" target="_blank" title="google+"></a></span>
	  <span class="red sh-mail"><a id="boxEmail" href="main-enviarEmail-enlace-<?=str_replace('-','_', QSTRING)?>-imagen-<?=$imag_pag?>-titulo-<?=strip_tags(str_replace('-','__', $titulo))?>"  title="Email"></a></span>
	</div>

	</div>
	<div class="areaProducts">
		<div class="row">
			<div class="col-sm-6 bloq1">
				<div class="Gallery">
					<div class="fotorama" data-width="100%" data-height="auto" data-swipe="true" data-nav="thumbs" data-thumbwidth="90" data-allowfullscreen="true">
						<? if($producto['oferta_imagen']!=''){?>
						<a href="<?=$dirfileo.'m'.$producto['oferta_imagen']?>" data-full="<?=$dirfileo.'b'.$producto['oferta_imagen']?>"><img src="<?=$dirfileo.'s'.$producto['oferta_imagen']?>"  width="104" height="56" ></a>
						<?} ?>
						<? foreach ($galeria as $gal) {?>
							<a href="<?=$dirfileout.'m'.$gal['archivo']?>" data-full="<?=$dirfileout.'b'.$gal['archivo']?>"><img src="<?=$dirfileout.'m'.$gal['archivo']?>"  width="104" height="56"></a>
						<? } ?>
						
					</div>
				</div>
			</div>
			<div class="col-sm-6">
			<div class="bloq2">
				
				<h2><?=$titulo?></h2>
				
				<div class="dataOferta">
				 <div class="row">
					<div class="col-sm-7">
						  <div class="Precio">
						   <span class="tt1">OFERTA:</span>
						   <span class="tt2"><?=$precio?></span> <span class="tt3"><?=$precio_old?></span>
						   <? $existencia=1;
						   $n_existencia=0;
						   if($producto['oferta_existencia_estado']=='1'){
						   		if($producto['oferta_existencia'])
						   			$n_existencia=$producto['oferta_existencia'];
						   		else
						   			$existencia=0;
						   		
						   	}
						   	elseif($producto['existencia_estado']=='1'){
						   		if($producto['existencia'])
						   			$n_existencia=$producto['existencia'];
						   		else
						   			$existencia=0;
						   	}
						   	if($producto['oferta_existencia_estado'] or $producto['existencia_estado']){
						   	if($existencia){?>
						   		<span class="tt4">UNIDADES DISPONIBLES: <strong><?=$n_existencia?></strong></span>
						 <? }
						   	else{ ?>
						   		<span class="tt4" style="color:#FB0054">PRODUCTO AGOTADO</span>
						   	<? }
						   }?>
						   
						  </div>
					</div>
					<div class="col-sm-5">
						<div class="countDown">
						 <span class="tt1">VENCE EN:</span>
						 <span class="tt2"><?=$faltan?> DIAS</span>
						</div>
					</div>
				 </div>
				</div>
				
				<div class="areaBott">
				
					 <? $p=0;
              foreach ($adicionales as $adicional){ 
                  if($adicional['id_adicional']){ ?> 
                 
                   <h4><?=$adicional['adicional']?></h4>

                   <?  if($opciones= adicional::obtieneDocs($adicional['id_adicional'])){?>
                   <ul class="adicionales">			
                    <? foreach($opciones as $opt)
                    { ?>
                    <li id="li_<?=$p.'_'.$opt['id_adicional_opcion']?>">
                      <input type="radio" name="opcion<?=$p?>" id="opcion_<?=$p.'_'.$opt['id_adicional_opcion']?>" value="<?=$opt['id_adicional_opcion']?>" onClick="activar_carrito(<?=$p?>)"/>
                      <label for="opcion_<?=$p.'_'.$opt['id_adicional_opcion']?>"><?=$opt['opcion']?></label> 
                  </li>

                  <? }?>
              </ul> 
              <?	}?>

              <?  $p++;}} ?> 
				<div class="row">
				

	<? $cpromedio=producto::promedio($producto['id_producto']);
	if($cpromedio['numero']){ ?>
	<div class="col-sm-3 add-cart" >
					<span><div class="rating" data-average="<?=$cpromedio['promedio']?>" data-id="<?=$producto['id_producto']?>" style="margin:0 auto; margin-top:10px;" ></div><span class="votos_rating"><a href="producto-listar_calificaciones-producto-<?=$producto['id_producto']?>" class="boxComentarios"><img src="<?=URLVISTA?>images/comment_small.png" /> <?=$cpromedio['numero']?> cliente(s)</a></span></span>
				
</div><? }?>
				<? if($producto['compras']){?>
				<div class="col-sm-6" style="position:relative">
				<div class="dataShop">COMPRADORES: <span class="lab"><?=$producto['compras']?></span></div>
				</div>
				<? }?>
			<div class="col-sm-3" ></div>	
				<? if($existencia){?>
<div style="clear:both; padding-top:10px;"></div>
				<div class="col-sm-12" >
				<div style="float:left; width:130px; margin-right:4px;">
								<div class="input-group">
						<span class="input-group-btn">
				              <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="cantidad">
				                  <span class="glyphicon glyphicon-minus"></span>
				              </button>
				          </span>
				          <input type="text" name="cantidad" id="cantidad"  class="form-control input-number cant-compra" value="1" min="1" max="1000" onKeyUp="ver_cantidad(<?=$producto['id_producto']?>)">
				          <span class="input-group-btn">
				              <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="cantidad">
				                  <span class="glyphicon glyphicon-plus"></span>
				              </button>
				          </span>

				</div>
		</div>	
				<div style="float:left" class=" add-cart">
					<span id="span_cart">Debe llenar todas las opciones</span>
				<button id="cart_button" onclick="enviarcompra()" class="addShop"><?=$txt_comprar?></button>

				</div>
				
			</div>
			<div style="clear:both"></div>
				<span class="span_cant" style="display:block; text-align:left;"></span>
				<? }?>


				</div>

				
			</div>
			
			<div class="areaEmpresa">
				<h4><?=$empresa['nombre']?></h4><span class="seguir-emp">
				<? if($siguiendo){?>
				<span id="span_seguir">Dejar de seguir esta empresa</span>
				<button class="seguir" onClick="seguir(<?=$producto['id_empresa']?>,0)"><i class="fa fa-heart"></i> SIGUENDO</button>

				<? } elseif(nvl($_SESSION['id_tipo_usuario'])==5){?>
				 <span id="span_seguir">Seguir esta empresa</span>
					<button class="seguir" onClick="seguir(<?=$producto['id_empresa']?>,1)"><i class="fa fa-heart-o"></i> SEGUIR</button>
				<? }else{?>
				<span id="span_seguir">Debe estar logueado</span>
					<button class="seguir"  onClick="window.location='main-registro'"><i class="fa fa-heart-o"></i> SEGUIR</button>
				<? }?>
			</span>
				<div class="spc">
					<div class="row">
					<div class="col-sm-12">
					<span class="ilab">DIRECCIÓN</span>
					<p><?=$empresa['direccion']?><br/>
						<?=$empresa['ciudad']?>, <?=$empresa['dpto']?></p>
					<?=(almacen::tieneAlmacenes($empresa['id_empresa'])) ? '<a href="mapa-ofertas-id-'.$producto['id_producto'].'" class="click-map">VER EL MAPA</a>':''?>
					</div>
					<? if($empresa['telefono']!='' or $empresa['movil']!=''){?>
					<div class="col-sm-<?=($empresa['web']=='0') ? '12':'4'?>">
					<span class="ilab">TELÉFONO</span>
					<p><?=$empresa['telefono'].' '.$empresa['telefono2'].' '.$empresa['telefono3'].' '.$empresa['movil']?></p>
					</div>
					<? }?>
					<? if($empresa['web']!='0') {?><div class="col-sm-8">
					<span class="ilab">SITIO WEB:</span>
					<p><a href="http://<?=$empresa['dominio']?>" target="_blank"><?=$empresa['dominio']?></a></p>
					</div>
					<? }?>
					<div class="col-sm-12">
					<span class="ilab2">SOBRE LA EMPRESA</span>
					 <div class="inf"><?=$empresa['descripcion']?>
					 </div>
					</div>
				</div>
	
			</div>
			
			</div>
		</div>
	</div>
<? if($producto['descripcion']!='' or $producto['detalles']!='' or $producto['oferta_terminos']!=''){?>	
	<div class="col-sm-12 line-top">

<ul class="nav nav-tabs" id="tabdetalles">
  <?=($producto['descripcion']!='') ? '<li class="active"><a href="#descripcion" data-toggle="tab">DESCRIPCIÓN</a></li>':''?>
  <?=($producto['detalles']!='') ? '<li><a href="#detalles" data-toggle="tab">DETALLES</a></li>':''?>
  <?=($producto['oferta_terminos']!='') ? '<li><a href="#terminos" data-toggle="tab">CONDICIONES</a></li>':''?>
</ul>
<!-- Tab panes -->
<div class="tab-content">
<? if($producto['descripcion']!=''){?>
  <div class="tab-pane tab-paneDetalles active" id="descripcion">
  	<div class="height5"></div>
	<p><?=$producto['descripcion']?></p>
  </div>
  <? }?>
  <? if($producto['detalles']!=''){?>
  <div class="tab-pane tab-paneDetalles" id="detalles">
  	<div class="height5"></div>
	<?=$producto['detalles']?>
  </div>
  <? }?>
  <? if($producto['oferta_terminos']!=''){?>
  <div class="tab-pane tab-paneDetalles " id="terminos">
  	<div class="height5"></div>
	<?=$producto['oferta_terminos']?>
  </div>
  <? }?>
  

</div>

	</div>
	<? }?>
  </div>

	</div>
	<? }else{?>
<div style="padding:50px 120px; font-size:25px; text-align:center;">No se encontró el producto</div>
	<? }?>
</div>
<? include("includes/populares.php") ?>
<? include("includes/footer.php") ?>
<script src="<?= URLVISTA ?>js/input_cant.js" type="text/javascript"></script>
</body>
</html>