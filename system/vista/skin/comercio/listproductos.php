<? include("includes/tags.php") ?>
<link rel="stylesheet" type="text/css" href="<?=URLVISTA?>skin/comercio/media/css/bootstrap.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?=URLVISTA?>skin/comercio/media/css/slider.css" media="all" />
<style type="text/css">
.slider-selection {
    background: #BABABA;
}
.mostrar{ margin-right: 10px;}
.precio_rango{padding: 0 10px 0 5px; height: auto !important;}
span#slide_min {
    display: inline-block;
    text-align: right;
    width: 67px;
    font-weight: bold;
}
</style>
</head>
<body>
<div class="wrapper">
    <div class="page">
<!-- HEADER BOF -->
<? include("includes/header.php") ?>
	    <div class="main-container col2-left-layout">
      
            <div class="main row">
                <!-- breadcrumbs BOF -->
                <div class="breadcrumbs">
                    <ul>
                        <li class="home">
                            <a href="main-index" title="Ir a página inicial">Inicio</a>
                            <span></span>
                        </li>
                       
                      <?=($ncate!=PRODUCTOS_TXT) ? ' <li><a href="main-productos" title="'.PRODUCTOS_TXT.'">'.PRODUCTOS_TXT.'</a><span></span></li>'.$ncate:$ncate?>
                        <? if($b!=''){?> <span></span> <li class="search">
                            <strong>Resultados de la búsqueda: '<?=$b?>'</strong>
                         </li>
                         <? }?>
                    </ul>
                </div>
                <!-- breadcrumbs EOF -->
                <div class="col-main">
             
                <div class="category-products">
                <div class="toolbar">
                <div class="sorter">
        	    <div class="sort-by toolbar-switch">
                    <div class="toolbar-title">
                        <label>Ordenar</label>
                        <? $basico='main-productos';
						if($categoria)
						$basico.='-c-'.$categoria;
						
						if($b)
						$basico.='-b-'.$b;
						
						$addpor='';
						$addorden='';
						$addcant='';
                        $addrango='';
						if($orden){
						$addpor.='-orden-'.$orden;
						$addcant.='-orden-'.$orden;
                        $addrango.='-orden-'.$orden;
						}
						
						if($cant){
						$addpor.='-cant-'.$cant;
						$addorden.='-cant-'.$cant;
                        $addrango.='-cant-'.$cant;
						}
						
						if($por){
						$addcant.='-por-'.$por;
						$addorden.='-por-'.$por;
                        $addrango.='-por-'.$por;
						}

                        if($rango){
                        $addcant.='-rango-'.$rango;
                        $addorden.='-rango-'.$rango;
                        $addpor.='-rango-'.$rango;
                        }
						?>
                        <span class="current"><?=($por=='oferta') ? 'Oferta':(($por=='precio') ? 'Precio':'Nombre')?></span>
                        <select onChange="setLocation(this.value)">
                            <option  <?=($por=='oferta') ? 'selected="selected"':''?> value="<?=$basico.$addpor?>-por-oferta">Oferta</option>
                            <option <?=($por=='titulo') ? 'selected="selected"':''?> value="<?=$basico.$addpor?>-por-nombre">Nombre</option>
                            <option <?=($por=='precio') ? 'selected="selected"':''?> value="<?=$basico.$addpor?>-por-precio">Precio</option> 
                         </select>
                    </div>
                    <div class="toolbar-dropdown">
                        <ul><li <?=($por=='oferta') ? 'class="selected"':''?>><a href="<?=$basico.$addpor?>-por-oferta">Oferta</a></li>
                        <li <?=($por=='titulo') ? 'class="selected"':''?>><a href="<?=$basico.$addpor?>-por-nombre">Nombre</a></li>
                        <li <?=($por=='precio') ? 'class="selected"':''?>><a href="<?=$basico.$addpor?>-por-precio">Precio</a></li></ul>
                    </div>
                </div>
                <div class="sort-order">
                <? if($orden=='desc'){?>
                     <a href="<?=$basico.$addorden?>-orden-asc" title="Ascendente"><img src="<?=URLVISTA?>skin/comercio/media/i_desc_arrow.gif" width="27" height="27" alt="Ascendente" class="v-middle" /></a>   
                    <? } else{?>
                    
                    <a href="<?=$basico.$addorden?>-orden-desc" title="Descendente"><img src="<?=URLVISTA?>skin/comercio/media/i_asc_arrow.gif" width="27" height="27" alt="Desc" class="v-middle" /></a>
                    <? }?>
                </div>



               
                <div class="limiter toolbar-switch mostrar">
                    <div class="toolbar-title">
                        <label>Mostrar</label>
                            <span class="current"><?=nvl($cant)?></span>
                            <select onChange="setLocation(this.value)">
                            <option  <?=(nvl($cant,9)==9) ? 'selected="selected"':''?> value="<?=$basico.$addcant?>-cant-9">9</option>
                            <option  <?=(nvl($cant,9)==15) ? 'selected="selected"':''?> value="<?=$basico.$addcant?>-cant-15">15</option>
                            <option  <?=(nvl($cant,9)==30) ? 'selected="selected"':''?> value="<?=$basico.$addcant?>-cant-30">30</option>                
                        </select>
                     Por página         
                    </div>
                <div class="toolbar-dropdown">
                    <ul><li class="selected"><a href="<?=$basico.$addcant?>-cant-9">9</a></li>
                    <li><a href="<?=$basico.$addcant?>-cant-15">15</a></li>
                    <li><a href="<?=$basico.$addcant?>-cant-30">30</a></li></ul>
                </div>
        </div>


    <div class="limiter toolbar-switch precio_rango">
            <label style="float:left;">Rango Precio</label><div style="float:left;"><span id="slide_min">$<?=number_format($r1,0,'.','.')?></span> <input id="pr_slider" type="text" class="" value="" data-slider-min="0" data-slider-max="<?=$rmax?>" data-slider-step="1" data-slider-value="[<?=$r1?>,<?=$r2?>]" data-slider-tooltip="hide"/> <b id="slide_max">$<?=number_format($r2,0,'.','.')?></b> </div>
        </div>
        <div class="sort-order">
                     <a href="<?=$basico.$addrango?>" id="lrango" title="Aplicar filtro por rango de precio"><img src="<?=URLVISTA?>skin/comercio/media/i_next_arrow.gif" width="27" height="27" alt="Filtrar" class="v-middle" /></a>   
                    
                </div>
    </div>
        <div class="pager">
    	    <p class="amount"><?=($ini==$fin)? 'Mostrando '.$fin.' de '.$ntotal.' '.PRODUCTOS_TXT.' encontrados ':(($ini<=$ntotal) ? 'Mostrando '.$ini.' a '.$fin.' de '.$ntotal.' '.PRODUCTOS_TXT.' encontrados':'No se econtraron '.PRODUCTOS_TXT)?>  </p>
    
            <div class="pages">
                <strong>Página:</strong>
                    <ol>
                        <?=$anterior.$numeracion.$siguiente?>
                    </ol>
            </div>
        </div>

    </div>
        





    <ul class="products-grid two_columns_3">
    <? foreach($productos as $prod){
        $existencia=1;
		$imagen_p= ($prod['archivo']!='') ? $dirfilep.'m'.$prod['archivo']:URLFILES.'producto.png';
			$titulo_p= $prod['nombre'];
			
			$precio=($prod['precio']) ? vn($prod['precio']):'';
            $esoferta=($prod['oferta']=='Activo' and ($prod['oferta_publicacion']<=date("Y-m-d")) and ($prod['oferta_vencimiento']>date("Y-m-d")) )? 1:0;
			
			$precio=($prod['precio']) ? vn($prod['precio']):'';
			$estado_o='';
			if($esoferta){
                $titulo_p= ($prod['oferta_descripcion']!='') ? $prod['oferta_descripcion']: $prod['nombre'];
				$imagen_p= ($prod['oferta_imagen']!='') ? $dirfileo.'m'.$prod['oferta_imagen']:$imagen_p;
				$precio_old=$precio;
				$precio=($prod['oferta_precio']) ? vn($prod['oferta_precio']):'';
                if(!$precio){
                    $precio=$precio_old;
                    $precio_old='';
				}
				$faltan= resta_fechas($prod['oferta_vencimiento'],date("Y-m-d"));
				$estado_o='<div class="faltan">Quedan '.$faltan.' dias</div>';
			}

            if($esoferta and $prod['oferta_existencia_estado']=='1'){
              if($prod['oferta_existencia']<=0)
                $existencia=0;
            }
            else if($prod['existencia_estado']=='1' and $prod['existencia']<=0)
                 $existencia_d=0;


            $enlace_p='main-producto-id-'.$prod['id_producto'].'-t-'.chstr($titulo_p);
		?>
<li class="item">
<?= ($esoferta) ? '<div class="new-label new-top-right"></div>':''?>
                <div class="regular">
                    <a href="<?=$enlace_p?>" title="<?=$titulo_p?>" class="product-image">
                        
                        <img src="<?=$imagen_p?>" data-srcX2="<?=$imagen_p?>" alt="<?=$titulo_p?>" />
                    </a>
                <div class="product-info">
                    <div class="button-container">
                        <p>
                         	        
                            <? if($precio and $existencia){
                            
                                     $nadic=producto::tiene_adicionales($prod['id_producto']);?>
                                     <button type="button" title="Añadir al carrito" class="button <?=(!$nadic) ? 'ajax-cart" data-url="producto-carrito" data-lista="prod" data-id="'.$prod['id_producto']:'" onclick="javascript:window.location=\'main-producto-id-'.$prod['id_producto'].'\''?>" >     
                                      <span>
                                             <span>Añadir al carrito</span>
                                         </span>
                                     </button>
                                     
                            <? }?>
                            
                         </p>
                    </div>
                    <a class="product-name" href="<?=$enlace_p?>" title="<?=$titulo_p?>"><?=cutstr_t($titulo_p,65);?> </a>
                    

                <?=$estado_o?>

                    <div class="price-box">                                          
                        <?=($esoferta) ? ' <p class="old-price"><span class="price-label"></span>
                            <span class="price" id="old-price-'.$prod['id_producto'].'">'.$precio_old.' </span></p>':''?>
                            <span class="regular-price" id="product-price-<?=$prod['id_producto']?>">
                                <span class="price"><?=$precio?></span>
                            </span>
                                        
                    </div>
     </div>
   </div>

    <div class="hover">
       <form  id="lprod<?= $prod['id_producto']?>" >
        <div class="mOptions">
        <? if(producto::tiene_adicionales($prod['id_producto'])){?>
         	<div class="spc">
            <h4>Opciones:</h4>
           <?= producto::imp_adicionales($prod['id_producto'],'prod')?>
           </div>
         	 <?  }else{?>
             <a href="<?=$enlace_p?>" title="<?=$titulo_p?>" class="product-image">
            <img src="<?=$imagen_p?>" data-srcX2="<?=$imagen_p?>" alt="<?=$titulo_p?>" /></a>
        <a href="<?=$enlace_p?>" title="<?=$titulo_p?>">
        <div class="price-box">                                          
                        <?=($esoferta) ? ' <p class="old-price"><span class="price-label"></span>
                            <span class="price" id="old-price-'.$prod['id_producto'].'">'.$precio_old.' </span></p>':''?>
                        <span class="regular-price" id="product-price-<?=$prod['id_producto']?>">
                            <span class="price"><?=$precio?></span>                                    
                        </span>
                        
                </div>
        </a>
        	<? }?>
         </div>
        
        <a class="product-name" href="<?=$enlace_p?>" title="<?=$titulo_p?>"><?=$titulo_p?><br><span class="vermas">VER DETALLES &rarr;</span></a>
        <?=$estado_o?>
        <div class="button-container">
            <p>
            
	 
                        <input name="dat[id_producto]" type="hidden" id="idprod<?= $prod['id_producto']?>" value="<?= $prod['id_producto']?>"  />
                          <input name="dat[nombre]" type="hidden" id="nombreprod<?= $prod['id_producto']?>" value="<?= $titulo_p?>" />
                        <input  name="dat[cantidad]" type="hidden" id="cantprod<?= $prod['id_producto']?>" value="1" />
	        
                        
                            
                <?=($precio and $existencia) ? '<button type="button" title="Añadir al carrito" class="button ajax-cart" data-url="producto-carrito" data-lista="prod" data-id="'.$prod['id_producto'].'">
                    <span>
                        <span>
                            <em></em>Añadir al carrito</span>
                        </span>
                </button>':''?>
                <?=(!$existencia) ? '<span>AGOTADO</span>':''?>
                
                 
            </p>
            
        </div>

        <span class="ajax_loading" id='ajax_loading<?=$prod['id_producto']?>'><img src='http://shopper.queldorei.com/skin/frontend/shopper/default/images/ajax-loader.gif'/></span>

        </form>
            </div>

        </li>
     <? }?>  
            </ul>
    
    <div class="toolbar-bottom">
        <div class="toolbar">
    
     <? if($ini<=$ntotal){?>
        <div class="pager">
    	    <p class="amount"><?=($ini==$fin)? 'Mostrando '.$fin.' de '.$ntotal.' '.PRODUCTOS_TXT.' encontrados ':'Mostrando '.$ini.' a '.$fin.' de '.$ntotal.' '.PRODUCTOS_TXT.' encontrados'?>  </p>
    <div class="pages">
        <strong>Página:</strong>
       <ol><?=$anterior.$numeracion.$siguiente?></ol>
    </div>
    </div>
    <? }?>

    </div>
    </div>
    </div>
</div>
<div class="col-left sidebar">
   <div class="block block-left-nav">
       <div class="block-title">
        <strong><span><?=$ncate?></span></strong>
     </div>
<div class="block-content"><ul id="left-nav">
   
        <?=categoria::menu($categoria,1)?>
	</ul></div>
</div>








                </div>
            </div>
		    <!-- footer BOF -->
<? include("includes/footer.php") ?>
<!-- footer EOF -->
    </div>
</div>
</div>
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/media/js/bootstrap.js"></script>
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/media/js/bootstrap-slider.js"></script>
<script type="text/javascript">
baserango='<?=$basico.$addrango?>';
jQuery(document).ready(function(){
    
    jQuery('#pr_slider').slider({
        formater: function(value) {
            return '$'+number_format(value,0,'.','.');
        }
    }).on('slide', function(data){
        jQuery('#slide_min').html('$'+number_format(data.value[0],0,'.','.'));
        jQuery('#slide_max').html('$'+number_format(data.value[1],0,'.','.'));
        rango=data.value[0]+'_'+data.value[1];
       add_rango(rango);
    });

});

function add_rango(rango){
    var nrango=baserango+'-rango-'+rango;
    jQuery("#lrango").attr('href',nrango);

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
