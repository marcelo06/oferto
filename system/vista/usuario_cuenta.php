<? include("includes/tags.php") ?>
<link rel="stylesheet" href="<?= URLSRC ?>smoke/smoke.css" type="text/css" media="screen" />
<link id="theme" rel="stylesheet" href="<?=URLVISTA?>css/smokedark.css" type="text/css" media="screen" />
<script src="<?= URLSRC ?>smoke/smoke.js" type="text/javascript"></script>
<link href="<?=URLVISTA?>css/font-awesome.css" rel="stylesheet"/>
<script type="text/javascript" src="<?=URLVISTA?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=URLVISTA?>js/registro.js?v=1"></script>
<script src="<?= URLVISTA ?>js/jRating.jquery.js" type="text/javascript"></script>
<link href="<?= URLVISTA ?>css/jRating.jquery.css" rel="stylesheet" type="text/css" />
<?= plugin::fancybox_2_1()?>
<script type="text/javascript">
mensaje='<?=nvl($mensaje)?>';
$(document).ready(function(){
	$(".boxComentarios").fancybox({'type' : 'iframe','height':200,'width': 600,fitToView:false, autoSize: false});
$( "#form-validate" ).validate({
             rules:{
                'dat[_username]':{ required: true,email: true, "remote":{url: 'usuario-validarxid',
																		 type: "post",
																		 data:{email: function(){return $('#form-validate :input[name="dat[_username]"]').val();},
																				oferto:1}
																		}
								 }
             },
             messages:{'dat[_username]': {remote: $.validator.format("{0} ya está en uso.")}}
});

$( "#form-validate-contra" ).validate({
             rules:{
				'dat[_password]': {required: true,minlength: 5},
				'contra': {required: true, equalTo: "#pass"},
             },
             messages:{
				 'dat[_password]': {minlength: "Al menos 5 caracteres"},
				 'contra': {equalTo: "Los campos no coinciden"}
             }
});

	$('.rating').jRating({
				length:5,
				decimalLength:0,
				rateMax :5,
				canRateAgain : true,
	 	 		nbRates : 10,
				step:true,
				type:'big',
				onSuccess: function(data){
					console.log(data.nuevo);
					if(data.nuevo){
						$.fancybox('producto-rating-comentar-'+data.id,{'type' : 'iframe','height':200,'width': 600,fitToView:false, autoSize: false});
						$("#calif_"+data.id_producto).append('<a href="producto-rating-comentar-'+data.id+'" class="boxComentarios"><img src="<?=URLVISTA?>images/comment.png" /></a>');
						$(".boxComentarios").fancybox({'type' : 'iframe','height':200,'width': 600,fitToView:false, autoSize: false});
					}
				
				}
			});

	/*var hash = window.location.hash;
	if(hash)
		 $(hash).tab('show');*/

});

function cerrarComentario(mensaje){
	$.fancybox.close();
	smoke.signal(mensaje);
}

function seguir(id_empresa,estado){
	$.post("empresa-seguir",{empresa:id_empresa,estado:estado},function(data){
		if(data){
			if(estado){
				$(".seguir-emp").html('<span id="span_seguir">Dejar de seguir esta empresa</span>\
					<button class="seguir" onClick="seguir('+id_empresa+',0)"><i class="fa fa-heart"></i> SIGUENDO</button>');
			}else{
				//$("#item_"+id_empresa).remove();
				$("#item_"+id_empresa).fadeOut('slow', function(){
				        $(this).remove();
				    });
			}
		}else{
			//errror
		}
	})
}

</script>
<style type="text/css">
.nav-tabs > li > a {
  font-size: 16px;
}
.seguir-emp:hover #span_seguir { display:block;} 
.boxComentarios{margin-left: 5px;}
.cdescuento{ font-size: 13px;color: #ff1267;}
.cdescuento strong{ color: #e94d7a;}
</style>
</head>
<body>
<? include("includes/header.php") ?>
<div class="areaHead auto_margin">
	<div class="guia"><a href="">INICIO</a> / Mi cuenta /</div>
	
</div>



<section id="Main">
	<div class="areaCats auto_margin">
		<ul class="nav nav-tabs" id="tabusuario">
  <li class="active"><a href="#cuenta" data-toggle="tab">MI CUENTA</a></li>
  <li><a href="#historial" data-toggle="tab">HISTORIAL</a></li>
  <li><a href="#siguiendo" data-toggle="tab">SIGUIENDO</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="cuenta">
<div class="regPadding">
			<div class="row">
				<div class="col-sm-12">
					<div class="height5"></div>
						<div class="container-fluid">	
						<form action="" method="post" id="form-validate-contra" >
						   	<div class="col-sm-6">
						   		<div class="areaRegistro">
						   		  <div class="spc">
						   		  <h3>Cambiara Contraseña</h3>
						   		  <p>Si usted no tiene una cuenta con nosotros, por favor <b>CREAR UNA NUEVA.</b></p>
						   		  <input name="elpass" id="elpass" type="hidden"  value="on"/>
						   		  <div class="row">
						   		    <div class="col-xs-12">
						   		    	<span class="flabel">Constraseña</span>
						   		      <input type="password" name="dat[_password]" id="pass" class="form-control" >
						   		    </div>
						   		    <div class="col-xs-12">
						   		    <span class="flabel">Repetir Contraseña</span>
						   		      <input type="password" name="contra" id="contra" class="form-control">
						   		    </div>
						   		    <div class="col-xs-12">
						   		    <span class="blabel">
						   		    <button type="submit" class="btn btn-primary upper">GUARDAR</button>
						   		    </span>
						   		    </div>
						   		  </div>
						   		  </div>
						   		</div>
						   	</div>
						   </form>
						   	<form action="" method="post" id="form-validate">
						   	<div class="col-sm-6">
						   		
                    			<input type="hidden" name="dat[id_tipo_usuario]"  id="id_tipo_usuario" value="5"/>
                    			<input type="hidden" id="proviene" name="proviene" value="<?=($compra) ? 'compra':'actualizar'?>"/>
						   		<div class="areaRegistro">
						   		  <div class="spc">
						   		  <h3>ACTUALIZAR MIS DATOS</h3>
						   		  <div class="row">
						   		  
						   		 
						   		    <div class="col-xs-12">
						   		    	<span class="flabel">Email (Usuario)</span>
						   		      <input name="dat[_username]" id="usuario"  value="<?=$reg['_username']?>" required  class="form-control">
						   		    </div>
						   		    <div class="col-xs-12">
						   		    <span class="flabel">Nombre Completo</span>
						   		     <input type="text"  name="per[nombre]" id="nombre_reg" value="<?=$reg['nombre']?>" required class="form-control">
						   		    </div>
						   		    <div class="col-xs-6">
						   		    <span class="flabel">Teléfono</span>
						   		     <input type="text" name="per[telefono]" id="telefono_reg" value="<?=$reg['telefono']?>" class="form-control">
						   		    </div>
						   		    
						   		    <div class="col-xs-6">
						   		    <span class="flabel">Dirección</span>
						   		      <input type="text"  name="per[direccion]" id="direccion_reg" value="<?=$reg['direccion']?>" required class="form-control">
						   		    </div>
						   		    <div class="col-xs-12">
						   		    <span class="flabel">Pais</span>
						   		    <select  name="per[id_pais]" id="pais_reg" onChange="localidades('dptos','pais_reg','departamento_reg')" required class="form-control" >
						   		    	<option value=""></option>
												<?=$paises?>
											 </select>
						   		      </div>
						   		    <div class="col-xs-6">
						   		    	<span class="flabel">Departamento</span>
						   		     <select name="per[id_dpto]" id="departamento_reg" onChange="localidades('ciudades','departamento_reg','ciudad_reg')"  required class="form-control">
												<option value=""></option>
											<?=$dptos?>
											 </select>
						   		    </div>
						   		    <div class="col-xs-6">
						   		    <span class="flabel">Ciudad</span>
						   		     <select name="per[id_ciudad]" id="ciudad_reg" required class="form-control">
												<option value=""></option>
											<?=$ciudades?>
											 </select>
						   		    </div>
						   		    <div class="col-xs-12">
						   		    <span class="blabel">
						   		    <button type="submit" class="btn btn-primary upper">GUARDAR</button>
						   		    </span>
						   		    </div>
						   		  </div>
						   		  </div>
						   		</div>
						   	</div>
						   </form>
						   	
						</div>
				   </div>
				
	  </div>
	</div>	
  </div>
  <div class="tab-pane" id="historial">

  	<div class="height5"></div>
<h2>HISTORIAL DE COMPRAS</h2>
<div class="table-responsive" style="padding: 20px 40px;">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th><span class="htFecha">Fecha</span></th>
				<th>Descripción Producto</th>
				<th><span class="htCantd">Empresa</span></th>
				<th><span class="htCantd">Cant.</span></th>
				<th><span class="httitle">Total</span></th>
			</tr>
		</thead>
		<tbody>
			<? if(count($pedidos)){
				$idp=0;
				$ids= array();

				foreach ($pedidos as $ped) {
					$productos = pedido::mispedidos($ped['id_pedido']);  
					foreach($productos as $pro){
						$calif= false;
						$calificacion='';
						echo '<tr>';
						if($idp!=$ped['id_pedido']){
							echo '<td ><span class="htFecha"><a>'.$ped['fecha'].'</a></span><span class="htEstado">'.$ped['estado'].'</span></td>';
							$idp=$ped['id_pedido'];
						}
						else
							echo '<td ></td>';

						if($ped['estado']=='Pago confirmado' and (!in_array($pro['id_producto'], $ids))){
							array_push($ids, $pro['id_producto']);
							
							$calif= producto::calificacion($_SESSION['id_usuario'],$pro['id_producto']);

							$ccomentario=(nvl($calif['id_productos_calificacion'],0)) ? '<a href="producto-rating-comentar-'.$calif['id_productos_calificacion'].'" class="boxComentarios"><img src="'.URLVISTA.'images/comment.png" /></a>':'';

							$calificacion= '<br/><span><div class="rating" data-average="'.nvl($calif['calificacion'],0).'" data-id="'.$pro['id_producto'].'" style="float:left; margin-top:3px;"></div></span> '.$ccomentario;
							

						} 
						$total=$pro['cantidad']*$pro['precio'];
						?>

						<td><span class="htDescript" id="calif_<?= $pro['id_producto']?>">
							<?= $pro['nombre']?><?=($ped['codigo_descuento']!='') ? '<br /><span class="cdescuento"><strong>Código descuento </strong>'.$ped['codigo_descuento'].'</span>':''?>
							<?=$calificacion?>
						
					</td>
						<td><span class="htCantd"><?= $ped['empresa']?></span></td>
						<td><span class="htCantd"><?= $pro['cantidad']?></span></td>
						<td><span class="htPrice"><?= vn($total)?></span></td>
					</tr>
					<? }
				}
			}
			else{ ?>
			<tr>
				<td colspan="4">No ha realizado ninguna transaccion en Oferto.co</td>
			</tr>
			<?  }?>
			
		</tbody>
	</table>
</div><!-- /.table-responsive -->

  </div>
  <div class="tab-pane" id="siguiendo">

  	<div class="row listShopping">
  		
  		<? foreach($empresas_sigue as  $emp){?>
  		<div class="item-body" id="item_<?=$emp['id_empresa']?>">
  			<div class="col-sm-3">
  				<div class="thumb" style="padding:5px"><img src="<?=$dirfile.'m'.$emp['logo']?>" alt="<?=$emp['empresa']?>" class="img-responsive center-block"/></div>
  			</div>
  			<div class="col-sm-8 col-xs-12">
  				<div class="entry">
  					<h3><?=$emp['empresa']?></h3>
  					<span class="cod"><?=$emp['slogan']?></span>
  					<span class="seguir-emp">
  					<span id="span_seguir">Dejar de seguir esta empresa</span>
  					<button class="seguir" onClick="seguir('<?=$emp['id_empresa']?>',0)"><i class="fa fa-heart"></i> SIGUENDO</button>
  				</span>

  				</div>
  			</div>

  			
  		</div>
<? }?>



  	</div>

  </div>

</div>
	
  </div>
<? include("includes/populares.php") ?>
<? include("includes/footer.php") ?>
</body>
</html>