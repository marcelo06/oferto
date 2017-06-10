<? include("includes/tags.php") ?>

<script type="text/javascript">
jQuery(document).ready(function(){
	activar_pago('payu');
	activar_pago('otro');
	jQuery(".caja_pago").hide();

});

mensaje='';
function activar_pago(tipo,otro){
	jQuery("#datos_"+tipo).show();
	jQuery("#datos_"+otro).hide();
	
}
</script>
</head>
<body class="  checkout-onepage-index">
<div class="wrapper">
        
    <div class="page">

<!-- HEADER BOF -->
<? include("includes/header.php") ?>
        <div class="main-container col2-right-layout">
            <div class="main row clearfix">
                <!-- breadcrumbs BOF -->
<!-- breadcrumbs EOF -->
                <div class="col-main">
              <div class="page-title"><h1>Finalizar Compra</h1></div>


<div class="section allow active" id="opc-review">
        <div style="" class="step a-item" id="checkout-step-review" >
            <div id="checkout-review-load" class="order-review"  style="background-color:#fff">    
<div id="checkout-review-table-wrapper" class="opc" >
    <table id="checkout-review-table" class="data-table">
                <colgroup><col>
        <col width="1">
        <col width="1">
        <col width="1">
                </colgroup><thead>
            <tr class="first last">
                <th rowspan="1">Nombre</th>
                <th class="a-center" colspan="1">Precio</th>
                <th class="a-center" rowspan="1">Cantidad</th>
                <th class="a-center" colspan="1">Subtotal</th>
            </tr>
             </thead>
        
        <tbody>
 <? $cantidad=0;
	$cadena='';
	$ids= array();
	$carrito = new Carrito();   
	
	if($carrito->numProductos() > 0){?>
    
    <?	$total = 0;
		 $i=0;
		
         for($p =0; $p<$carrito->nf; $p++)
			if(nvl($carrito->carro['estado'][$p])){ 
			  $cantidad += $carrito->carro['cantidad'][$p];
			  $preciot = $carrito->carro['precio'][$p]*$carrito->carro['cantidad'][$p];
			  $total += $preciot;
			  
			  $imagen_c= $carrito->carro['imagen'][$p];
			  $titulo_c= $carrito->carro['nombre'][$p].$carrito->carro['referencia'][$p];
			  $precio_c=($carrito->carro['precio'][$p]) ? vn($carrito->carro['precio'][$p]):'';?>
<tr class="<?=($p%2==0) ? 'odd':'even'?>">
    <td><span class="td-label">Nombre</span>
        <div class="product-name"><?=$titulo_c?></div>
        <div class="clear"></div>
    </td>
        <td class="a-right">
        <span class="td-label">Precio</span><span class="cart-price"><span class="price"><?=$precio_c?></span></span>
 </td>
            <td class="a-center"> <span class="td-label">Cantidad</span><?=$carrito->carro['cantidad'][$p]?></td>
        <td class="a-right last">
        <span class="td-label">Subtotal</span>
                    <span class="cart-price">
        
                            <span class="price"><?=$precio_c?></span>            
        </span>
            </td>
        </tr>
     
		<?  }
	  }
     ?>

                    
                </tbody>
                <tfoot>
    

    <tr class="last">
    <td colspan="3" class="a-right" style="">
        <strong>Total</strong>
    </td>
    <td class="a-right last" style="">
        <strong><span class="price"><?=($total) ? vn($total):'0';?></span></strong>
    </td>
</tr>
    </tfoot>
    </table>
</div>
<form  action="pedido-enviar_pago">
<div class="data-table opc" style="margin-top:3px;" >
<div style=" padding:10px">
   Seleccione la forma de pago:<br>
   <?=($emp['pago_payu']=='1') ? '<input type="radio" class="radio" title="Pago en linea" value="payu" name="metodo_pago" id="pago_payu" onClick="activar_pago(\'payu\',\'otro\')" required/><label for="pago_payu"> Pago en linea (PAYU) con tarjeta de crédito, debito, baloto... </label>&nbsp;':''?>
  <?=($emp['pago_otro']=='1') ? '<input type="radio" class="radio" title="Pago en linea" value="otro" name="metodo_pago" id="pago_otro" onClick="activar_pago(\'otro\',\'payu\')" required/><label for="pago_otro"> Otros métodos de pago </label>':''?>
  
  <div id="datos_payu" class="caja_pago">
  <img src="<?=URLVISTA?>skin/comercio/skin/images/payu_logo.jpg" alt="Pagar con payu" />
  </div>
  <div id="datos_otro" class="caja_pago">
  <p><?=$emp['otro_descripcion']?></p>
  </div>
</div>
</div>

<div id="checkout-review-submit">

 <? if($con['contenido']!=''){?>
<ol class="checkout-agreements">
    <li>
        
        <p class="agree">
            <input type="checkbox" class="checkbox" title="Acepto" value="1" name="agreement" id="agreement-1" required><label for="agreement-1"> Acepto <a href="main-contenido-t-3" target="_blank">Términos y condiciones</a></label>
        </p>
    </li>
</ol>

<? }?>
    <div id="review-buttons-container" class="buttons-set">
        <p class="f-left">Olvidó algo? <a href="producto-carrito">Volver al carrito</a> | <a href="<?=(nvl($_SESSION['id_tipo_usuario'],0)==5) ? 'main-cuenta':'main-registro-comprar-1'?>">Editar datos personales</a></p>
        <button class="button btn-checkout" title="comprar" type="submit"><span><span>Comprar</span></span></button>
        
    </div>
  
</div></form>  
</div>
        </div>
    </div>
               </div>

<div class="col-right sidebar" style="padding-top:120px">
		            <div id="checkout-progress-wrapper"><div class="block block-progress opc-block-progress">
    <div class="block-title">
        <strong><span>Datos Personales del pedido</span></strong>
    </div>
    <div class="block-content">
        <dl>
          <dt><strong>Nombre</strong>: <?=$dpedido['nombre_pedido']?></dt>
          <dt><strong>Email</strong>: <?=$_SESSION['d_pedido']['email_pedido']?></dt>
           <dt><strong>Teléfono</strong>: <?=$_SESSION['d_pedido']['telefono_pedido']?></dt>
           <dt><strong>Dirección</strong>: <?=$_SESSION['d_pedido']['direccion_pedido']?></dt>
           <dt><strong>Pais</strong>: <?=usuario::nombre_localidad('pais',$_SESSION['d_pedido']['pais_pedido'])?></dt>
           <dt><strong>Departamento</strong>: <?=usuario::nombre_localidad('dpto',$_SESSION['d_pedido']['departamento_pedido'])?></dt>
           <dt><strong>Ciudad</strong>: <?=usuario::nombre_localidad('ciudad',$_SESSION['d_pedido']['ciudad_pedido'])?></dt>
            
       </dl>
    </div>
</div>
</div>	  </div>

            </div>
	        <!-- footer BOF -->
<? include("includes/footer.php")?>
<!-- footer EOF -->        </div>
            </div>
</div>
</body>
</html>