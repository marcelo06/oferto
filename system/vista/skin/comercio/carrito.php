<? include("includes/tags.php");?>

<script type="text/javascript">
mensaje='<?=nvl($mensaje)?>';
jQuery(document).ready(function(){
jQuery('.qty').keyup(function () { this.value = this.value.replace(/[^0-9]/g,'');});
if(mensaje!='')
    smoke.signal(mensaje);
});


</script>
</head>
<body class="  checkout-cart-index">
<div class="wrapper">
    <div class="page">
        

<!-- HEADER BOF -->
<? include("includes/header.php");?>

<!-- HEADER EOF -->
        <div class="main-container col1-layout">
            <div class="main row clearfix">
                <!-- breadcrumbs BOF -->
<!-- breadcrumbs EOF -->
                <div class="col-main">
                                        <div class="cart">
    <div class="page-title title-buttons">
        <h1>Carrito de compras</h1>
                <ul class="checkout-types">
              <li><button type="button" title="Finalizar compra" class="button btn-proceed-checkout btn-checkout" onClick="window.location='<?= (nvl($_SESSION['id_tipo_usuario'],0) == 5) ? ' producto-checkout':'main-registro-comprar-1'?>';"><span><span>Finalizar compra</span></span></button></li>
                            </ul>
            </div>
            <form action="" method="post">
        <fieldset>
            <table id="shopping-cart-table" class="data-table cart-table">
                <col width="1" />
                <col />
                <col width="1" />
                                        <col width="1" />
                                        <col width="1" />
                            <col width="1" />
                                        <col width="1" />

                            <thead>
                    <tr>
                        <th class="td-image" rowspan="1">&nbsp;</th>
                        <th class="td-name" rowspan="1"><span class="nobr">Nombre</span></th>
                       
                        <th class="td-price" class="a-center" colspan="1"><span class="nobr">Precio Unitario</span></th>
                        <th class="td-qty" rowspan="1" class="a-center">Cantidad</th>
                        <th class="td-price" class="a-center" colspan="1">Subtotal</th>
                        <th class="td-delete a-center" rowspan="1">&nbsp;</th>
                    </tr>
                                    </thead>
                <tfoot>
                    <tr>
                        <td colspan="50" class="a-right">
                            <button type="button" title="Continuar comprando" class="button button_naranja btn-continue" onClick="setLocation('main-productos')">
                          	  <span><span>Continuar comprando</span></span></button>
                            
                        </td>
                    </tr>
                </tfoot>
                <tbody>
        <?  $carrito = new carrito();
            $total = 0;
			$total_dolar = 0;
            $k=0;
             for($p =0; $p<$carrito->nf; $p++)
                if(nvl($carrito->carro['estado'][$p])){ 
				$preciot = $carrito->carro['precio'][$p]*$carrito->carro['cantidad'][$p];
				$total += $preciot;
				
				
			$imagen_c= $carrito->carro['imagen'][$p];
			$titulo_c= $carrito->carro['nombre'][$p].$carrito->carro['referencia'][$p];
			$enlace_c='main-producto-id-'.$carrito->carro['producto'][$p].'-t-'.chstr($titulo_c);
			$precio_c=($carrito->carro['precio'][$p]) ? vn($carrito->carro['precio'][$p]):'';
			
			?>
      <tr id="prod<?= $p?>">
        
    <td class="td-image"><a href="<?=$enlace_c?>" title="<?=$titulo_c?>" class="product-image"><img src="<?=$imagen_c?>" data-srcX2="<?=$imagen_c?>" width="200" height="200" alt="<?=$titulo_c?>" /></a></td>
    <td class="td-name">
        <h2 class="product-name"> <a href="<?=$enlace_c?>"><?=$titulo_c?></a></h2>
    </td>
    
    
    
                <td class="a-center td-price">
            <span class="td-title">Precio unitario</span>
                            <span class="cart-price">
                       <span class="price"><?=$precio_c?></span>                
            </span>

                    </td>
                        <td class="a-center td-qty">
        <span class="td-title">Cantidad</span>
        <input name="cantidad<?= $p?>" type="text" id="cantidad<?= $p?>"  value="<?= $carrito->carro['cantidad'][$p]?>" size="4" class="input-text qty" maxlength="12" onKeyUp="updateUp('<?=$p?>',event.keyCode,<?= $carrito->carro['producto'][$p]?>)" onKeyDown="updateDown()" onChange="updateCarrito('<?= $p?>', <?= $carrito->carro['producto'][$p]?>)"  />
          <div class="update"><a onClick="updateCarrito('<?= $p?>,<?= $carrito->carro['producto'][$p]?>')" style="cursor:pointer" >Actualizar</a><div style="color:#F00; font-size:10px" id="mensaje<?= $p?>"></div></div>

    </td>
        <td class="a-center td-price">
        <span class="td-title">Subtotal</span>
                    <span class="cart-price">
                    <span class="price" id="precio_tt<?= $p?>"><?=vn($preciot)?></span>      
                    <div style="display:none" id="precio_val<?= $p?>"><?=$preciot?></div>                      
        </span>
            </td>
            <td class="a-center td-delete"><a href="javascript:eliminar_fila('<?=$p?>')" title="Eliminar Item" onClick="return confirm('Seguro desea borrar el item?');" class="btn-remove btn-remove2">Eliminar item</a>      
    </td>
</tr>
<?	$k++; } ?>
         </tbody>
            </table>
            <script type="text/javascript">decorateTable('shopping-cart-table')</script>
        </fieldset>
    </form>
    <div class="cart-collaterals row clearfix">
        
        
        <div class="grid_12">
            <div class="cart-block cart-total">
                    <table id="shopping-cart-totals-table">
        <col />
        <col width="1" />
        <tfoot>
            <tr>
    <td style="" class="a-right" colspan="1">
        <strong>Total</strong>
    </td>
    <td style="" class="a-right">
        <strong><span class="price"  id="total_tt"><?=vn($total)?></span></strong>
         <div style="display:none" id="total_val"><?=$total?></div> 
    </td>
</tr>
        </tfoot>
        <tbody>
            <tr>
    <td style="" class="a-right" colspan="1">
        Subtotal    </td>
    <td style="" class="a-right">
        <span class="price"><?=vn($total)?></span>    </td>
</tr>
        </tbody>
    </table>
    <ul class="checkout-types">
        <li>    <button type="button" title="Finalizar compra" class="button btn-proceed-checkout btn-checkout" onClick="window.location='<?= (nvl($_SESSION['id_tipo_usuario'],0) == 5) ? ' producto-checkout':'main-registro-comprar-1'?>';"><span><span>Finalizar compra</span></span></button>
</li>
 
</li>
     </ul>
        </div>
        </div>
    </div>
 
 </div>                </div>
            </div>
            <!-- footer BOF -->
<? include("includes/footer.php");?>
<!-- footer EOF -->        </div>
            </div>
</div>
</body>
</html>