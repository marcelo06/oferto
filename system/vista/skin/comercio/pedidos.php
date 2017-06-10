<? include("includes/tags.php") ?>
</head>
<body class="  checkout-cart-index">
<div class="wrapper">
    <div class="page">
<!-- HEADER BOF -->
<? include("includes/header.php") ?>

<!-- HEADER EOF -->
	    <div class="main-container col<?=($mostrar_puntos) ? '2-right':'1'?>-layout">
            <div class="main row">
                <!-- breadcrumbs BOF -->
<div class="breadcrumbs">
    <ul>
            <li class="home">
                     <a href="main-index" title="Inicio">Inicio</a>
                       <span></span>
                        </li>
                    <li>
                          <strong>Compras Realizadas</strong>
                   </li>
            </ul>
</div>
<!-- breadcrumbs EOF -->
  <? if($mostrar_puntos){ ?>
 <div class="col-left sidebar" style="padding-top:28px">
                <div id="checkout-progress-wrapper"><div class="block block-progress opc-block-progress" style="top:28px">
    <div class="block-title">
        <strong><span>PUNTOS ACUMULADOS</span></strong>
    </div>
    <div class="block-content">
        <?=$puntos ?>
    </div>
</div>
</div>    </div>
<? } ?>
<div class="col-main">
<h1 style="font-family: 'Myriad Pro',serif;font-size: 36px;font-weight: 400;letter-spacing: -1.5px;line-height: 30px;text-transform: uppercase; margin-bottom:30px;">Compras realizadas</h1> 
 
   <? if(nvl($tabla,0)){?>
      <h1 class="hTitle">Gracias por su compra</h1>
		
      <p>Su compra ya ha sido registrada en nuestro sistema y pronto haremos el envío. Si desea hacer algún cambio en su información de contacto, puede escribirnos  <a href="main-contactenos">aquí</a></p>
      
    
      
<div style="clear:both"><?=$tabla?></div>

<? 	
	}
	else{ ?>
		
		

	<?	if(nvl($pedidos,0)){
			
			
		foreach($pedidos as $ped)
		{
			
		?>
	   <table width="100%" cellpadding="5" border="0" class="t_pedido">
        <thead>
          <tr>
            <td width="81%"><strong>Detalles</strong></td>
            <td width="14%" align="center" ><strong>Precio</strong></td>
           <td width="13%" align="center" ><strong>Total</strong></td>
          </tr>
        </thead>
       
        <tbody>
        
        <?
					   $productos = pedido::mispedidos($ped['id_pedido']);  
					   $total = 0;
					   $preciot = 0;
					   foreach($productos as $pro){

						$precio = str_replace( ".", "", $pro['precio'] ); 
						
						$cantidad = (int)$pro['cantidad'];
						$cantidad = ((is_integer($cantidad))? $cantidad : 1);
						$preciot = $precio*$cantidad; 
                        $total += $preciot;
						
						
					?>
                       <tr>
            <td ><?= $pro['nombre']?></td>
            <td align="center" ><?= $pro['precio'] ?><sub>COP</sub></td>
           
            <td align="right"><span class="cant">x<?=$pro['cantidad']?></span><br><?= vn($preciot) ?><sub>COP</sub></td>
          </tr>
                    <? } ?>
        
          

          
        </tbody>
      </table>
      <table width="100%" border="0" cellspacing="1" cellpadding="8" >
        <tr>
          <td width="23%" ><strong>Pedido #. </strong><?=$ped['orden']?><br />
            <?=($ped['codigo_descuento']!='') ? '<strong>Código descuento </strong>'.$ped['codigo_descuento'].'<br />':''?>
            <i><?=$ped['estado']?></i><br><span style="font-size:11px; color:#CCC"><?=$ped['fecha']?></span></td>
          <td width="77%" align="right"><div class="tt-price">Total <?=vn($total)?><sub>COP</sub></div></td>
        </tr>
      </table>

		<br />
		<? }}
      else{?>
        <p>No se encontraron pedidos</p>
      <? }
     }?>


 
  <p>&nbsp;</p>
 </div>
 


            </div>
		    <!-- footer BOF -->
<? include("includes/footer.php")?>
<!-- footer EOF -->        </div>
            </div>
</div>
</body>
</html>
