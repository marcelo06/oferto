<? include("includes/tags.php") ?>
<script type="text/javascript" src="<?=URLVISTA?>js/jquery.validate.min.js"></script>
<script type="text/javascript">
mensaje='';
</script>
<style type="text/css">
.span_cant{color: #ff0000;font-size: 12px;}
</style>
</head>
<body>
<? include("includes/header.php") ?>
<div class="areaHead auto_margin">
	<div class="guia"><a href="">INICIO</a> / CHECKOUT /</div>
</div>



<section id="Main">
	<div class="ShoppingCart auto_margin">
	<div class="cont">
			<div class="row">
				<form id="form-validate" method="POST" action="pedido-enviar_pago">
				<div class="col-sm-8">
<div class="col-sm-12">
					<div class="height5"></div>
				<div class="container-fluid">	
				<div class="row listShopping">
				  <div class="thead hidden-xs">
				  		<div class="col-sm-4"></div>
						<div class="col-sm-5">Descripción</div>
						<div class="col-sm-1"> Cant.</div>
						<div class="col-sm-2"> Precio</div>
				   </div>
				   
				   
				   <div class="item-body">
						<div class="col-sm-4">
						<div class="thumb"><img src="<?=($producto['oferta_imagen']!='') ? $dirfileo.'m'.$producto['oferta_imagen']:(($producto['archivo']!='') ? $dirfileout.'m'.$producto['archivo']:URLFILES.'producto.png')?>" alt="" class="img-responsive center-block"/></div>
						</div>
						<div class="col-sm-5 col-xs-12">
						<div class="entry">
						<h3><?=($producto['oferta_descripcion']!='') ? $producto['oferta_descripcion']: $producto['nombre']?></h3>
						<span class="cod"><?=$emp['nombre']?></span>
						<?=($producto['referencia']!='') ? '<span class="cod"><strong>Código producto:</strong> '.$producto['referencia'].'</span>':''?>
						<?=$cadicionales?>
						
						</div>
						</div>
						
						<div class="col-sm-1 col-xs-6" style="padding-top:5px;" ><div class="tpr"><input type="text" class="form-control" value="<?=$cantidad?>" name="cantidad" id="cantidad" onKeyUp="ver_cantidad(<?=$producto['id_producto']?>)" />
							<span class="span_cant"></span></div></div>
						<div class="col-sm-2 col-xs-6 gtotal" ><div class="tpr"><?=vn($producto['oferta_precio'])?></div><div style="display:none" id="tprecio"><?=$producto['oferta_precio']?></div></div>
					</div>
					<div class="item-body">
						<div class="col-sm-12 gtotal" style="text-align:right"><div class="tpr">Total: <span id="ttotal"><?=vn($total)?></span></div></div>
						
					</div>
				</div>				
				</div>	
			</div>


<div class="col-sm-12">
					<div class="height5"></div>
				<div class="row listShopping">
				<div class="spc">	
					
						Seleccione la forma de pago:<br>
                        
						<?=($emp['pago_payu']=='1') ? '<div class="col-sm-8"><input type="radio" value="payu" name="metodo_pago" id="pago_payu" onClick="activar_pago1(\'payu\',\'otro\',\'iimoney\')" required/> <label style="font-weight:normal" for="pago_payu">Pago en linea (PAYU) con tarjeta de crédito, debito, baloto...</label></div>':''?>
						<?=($emp['pago_payu']=='2') ? '<div class="col-sm-8"><input type="radio" value="ii-money" name="metodo_pago" id="pago_ii-money" onClick="activar_pago1(\'iimoney\',\'payu\',\'otro\')" required/> <label style="font-weight:normal" for="pago_payu">Pago en linea (ii-money) con tarjeta de debito</label></div>':''?>
                        <?=($emp['pago_otro']=='1') ? '<div class="col-sm-4"><input type="radio"  value="otro" name="metodo_pago" id="pago_otro" onClick="activar_pago1(\'otro\',\'payu\',\'iimoney\')" required/> <label style="font-weight:normal" for="pago_otro">Otros métodos de pago</label></div>':''?>
<div class="col-sm-12">
						<div id="datos_payu" class="spc caja_pago" style=" background-color: #FAFAFA; border-radius:5px;">
							<img src="<?=URLVISTA?>images/payu_logo.jpg" alt="Pagar con payu" />
						</div>
    
                        <div id="datos_iimoney" class="spc caja_pago" style=" background-color: #FAFAFA; border-radius:5px;">
							<img src="<?=URLVISTA?>images/ii-money-logo.png" alt="Pagar con ii-money" style="width: 200px" />
						</div>
    
						<div id="datos_otro" class="spc caja_pago" style=" background-color: #FAFAFA; border-radius:5px;">
							<p><?=($emp['otro_descripcion']!='') ? $emp['otro_descripcion']: 'La forma de pago no ha sido definida, por favor <a href="http://'.$dominio.'/main-contactenos" target="_blank">comuníquese con la empresa</a> para realizar el pago correspondiente a la compra'?></p>
						</div>
</div>
						

							<? if($con['contenido']!=''){?>
							<div class="col-sm-12">
								<div class="height5"></div>
										<input type="checkbox" value="1" name="agreement" id="agreement-1" required><label for="agreement-1">&nbsp; Acepto <a href="http://<?=$dominio?>/main-contenido-t-3" target="_blank">Términos y condiciones</a></label>
									</div>
							<? }?>
						
					
<div style="clear:both"></div>
			       </div>
			       </div>
				</div>



				</div>
				<div class="col-sm-4">
					<div class="col-sm-12">
					<div class="height5"></div>
				<div class="row listShopping">
				<div class=" spc">	
<span class="dlabel">Datos Personales </span>
					<strong>Nombre</strong>: <?=$dpedido['nombre_pedido']?><br>
			        <strong>Email</strong>: <?=$_SESSION['d_pedido']['email_pedido']?><br>
			        <strong>Teléfono</strong>: <?=$_SESSION['d_pedido']['telefono_pedido']?><br>
			        <strong>Dirección</strong>: <?=$_SESSION['d_pedido']['direccion_pedido']?><br>
			        <strong>Pais</strong>: <?=usuario::nombre_localidad('pais',$_SESSION['d_pedido']['pais_pedido'])?><br>
			        <strong>Departamento</strong>: <?=usuario::nombre_localidad('dpto',$_SESSION['d_pedido']['departamento_pedido'])?><br>
			        <strong>Ciudad</strong>: <?=usuario::nombre_localidad('ciudad',$_SESSION['d_pedido']['ciudad_pedido'])?><br><br/>
			        Olvidó algo? <a href="<?=(nvl($_SESSION['id_tipo_usuario'],0)==5) ? 'main-cuenta-comprar-'.$compra:'main-registro-comprar-'.$compra?>-c-<?=$cantidad?>">Editar datos personales</a>
			       </div>
			       </div>
			   </div>
<div class="height10"></div>
				<div class="col-xs-12" style="text-align: right;"><button class="check magenta" id="btn_finalizar">Finalizar Reserva</button></div>

				</div>						
	</form>  	
	  </div>
	</div>	
  </div>
</section>
<? include("includes/populares.php") ?>
<? include("includes/footer.php") ?>

<script type="text/javascript">
$(document).ready(function(){
	$( "#form-validate" ).validate();
	activar_pago('payu');
	activar_pago('ii-money');
	activar_pago('otro');
	$(".caja_pago").hide();
	$('#cantidad').keyup(function () { this.value = this.value.replace(/[^0-9]/g,'');});	
});

function activar_pago(tipo,otro){
	$("#datos_"+tipo).show();
	$("#datos_"+otro).hide();
}
function activar_pago1(tipo,otro1, otro2){
	$("#datos_"+tipo).show();
	$("#datos_"+otro1).hide();
	$("#datos_"+otro2).hide();
}

function update_precio(){
	cantidad=$("#cantidad").val();
	if(cantidad===0){
		$("#cantidad").val(1);
		cantidad=1;
	}

	precio=$("#tprecio").html();
	ttotal= precio*cantidad;
	$("#ttotal").html('$'+number_format(ttotal,0,',','.'));

}
function ver_cantidad(id_producto){
  cantidad=$("#cantidad").val();
  if(cantidad==0){
  	$("#btn_finalizar").attr('disabled',true);
  }else{
  	$.post("producto-validar_cantidad",{id_producto:id_producto,cantidad:cantidad},function(data){
	    if(data=='true'){
	      cantidad=1;
	      $(".span_cant").html('');
	      $("#btn_finalizar").removeAttr('disabled');
	       update_precio();
	    }
	    else{
	    cantidad=0;
	      $("#btn_finalizar").attr('disabled',true);
	      $(".span_cant").html('La cantidad solicitada no se encuentra disponible');
	    }
	  });
  }
  
}

function number_format (number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}
</script>
</body>
</html>