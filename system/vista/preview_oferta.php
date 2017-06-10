<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title><?= ( isset($titulo_sitio) )? $titulo_sitio.' - ' : ''; configsite::print_titulo() ?></title>

	<link href="<?=URLVISTA?>css/bootstrap.css" rel="stylesheet" type="text/css" />
	
	<link href="<?=URLVISTA?>css/font-face.css" rel="stylesheet" media="screen"/>
	

		
	<!-- Main Style -->
	<link href="<?=URLVISTA?>css/style.css" rel="stylesheet" type="text/css" />
	

<!-- Important Gallery -->

<style type="text/css">
.bloq2{ min-height:420px;}
</style>
</head>
<body>


<section id="Main">
<?  
	$precio_old=($producto['precio'] and ($producto['oferta_precio']<$producto['precio'])) ? vn($producto['precio']):'';
	$precio=($producto['oferta_precio']) ? vn($producto['oferta_precio']):'';	
	$porcentaje=($producto['precio'] and $producto['oferta_precio']) ? '<span class="tagOff">'.calc_porcentaje($producto['precio'],$producto['oferta_precio']).'%</span>':0;
	$faltan= resta_fechas($producto['oferta_vencimiento'],date("Y-m-d")); ?>	

	<div class="areaCats auto_margin">
	
	<div class="areaProducts">
		<div class="row">
			<div class="col-sm-6 bloq1">
				<div class="Gallery">
					<div class="fotorama" data-width="100%" data-height="auto" data-swipe="true" data-nav="thumbs" data-thumbwidth="90" data-allowfullscreen="true">
						<? if($producto['oferta_imagen']!=''){?>
						<img class="img-responsive" src="<?=$dirfileo.'m'.$producto['oferta_imagen']?>" />
						<?}else if(isset($galeria[0])){ ?>
							<img  class="img-responsive"  src="<?=$dirfileout.'m'.$galeria[0]['archivo']?>">
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

						   	if($existencia){?>
						   		<span class="tt4">UNIDADES DISPONIBLES: <strong><?=$n_existencia?></strong></span>
						 <? }
						   	else{ ?>
						   		<span class="tt4">PRODUCTO AGOTADO</span>
						   	<? }?>
						   
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
                  if($adicional['id_adicional']){

                   ?> 
                  
                   <h4><?=$adicional['adicional']?></h4>

                   <?  if($opciones= adicional::obtieneDocs($adicional['id_adicional'])){?>
                   <ul class="adicionales">			
                    <? foreach($opciones as $opt)
                    { ?>
                    <li id="li_<?=$p.'_'.$opt['id_adicional_opcion']?>">
                      <label for="opcion_<?=$p.'_'.$opt['id_adicional_opcion']?>"><?=$opt['opcion']?></label> 
                  </li>

                  <? }?>
              </ul> 
              <?	}?>

              <?  $p++;}} ?> 
				
				
			</div>
			
			<div class="areaEmpresa">
				<h4><?=$empresa['nombre']?></h4>
			
			</div>
		</div>
	</div>
	<div class="col-sm-12 line-top">
		<? if($producto['descripcion']!='') {?>
	<div class="areaDescript">
	<h4>DESCRIPCIÓN</h4>
	<p><?=$producto['descripcion']?></p>
	</div>
	<? }
	if($producto['detalles']!='') {?>
	<div class="areaDescript">
	<h4>DETALLES</h4>
	<?=$producto['detalles']?>
	</div>
	<? }
	if($producto['oferta_terminos']!='') {?>
	<div class="areaDescript">
	<h4>CONDICIONES</h4>
	<p><?=$producto['oferta_terminos']?></p>
	</div>
	<? }?>

	</div>


	

  </div>

	</div>
</div>
</body>
</html>