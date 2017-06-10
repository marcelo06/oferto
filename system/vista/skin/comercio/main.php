<? include("includes/tags.php") ?>
<script type="text/javascript">
    //<![CDATA[

mensaje= '<?=nvl($mensaje)?>';
    jQuery(document).ready(function($) {
        if(mensaje!=''){
        showMessage(mensaje);
        }
		

        var carouselID = '#featured_1381246505';
        var jc = null;

        //line up carousel items
        var lineUp = function()
        {
            var height = 0;
            $('li.item', carouselID).each(function(i,v){
                $('div.product-info', this).css('height', 'auto');
                var h = $('div.product-info', this).height();
                if ( h > height ) {
                    height = h;
                }
            });
            $('li.item div.product-info', carouselID).height(height);
        }
/////destacados//////
        var mycarousel_initCallback = function(carousel)
        {
            if ( jc ) {
                return;
            }

            $('#shopper_carousel_next1381246505').bind('click', function() {
                carousel.next();
                return false;
            });
            $('#shopper_carousel_prev1381246505').bind('click', function() {
                carousel.prev();
                return false;
            });

            if (typeof $(carouselID).parent().swipe !== 'undefined'){
                $(carouselID).parent().swipe({
                    swipeLeft: function() { carousel.next(); },
                    swipeRight: function() { carousel.prev(); },
                    swipeMoving: function() {}
                });
            }

            jc = carousel;
        };

        var mycarousel_reloadCallback = function(carousel)
        {
            if ( !isResize('featured_1381246505') ) return;
            carousel.list = $(carouselID);
            var li = $(carouselID).children('li');
            carousel.list.css(carousel.lt, "0px");
            carousel.list.css(carousel.wh, $(li.get(0)).outerWidth(!0) * li.size() + 100);
            carousel.first = 1;
            carousel.last = $(carouselID).parent().width() / $(li.get(0)).outerWidth(!0);
            lineUp();
        }

        $(carouselID).jcarousel({
            scroll: 1,
            initCallback: mycarousel_initCallback,
            reloadCallback: mycarousel_reloadCallback,
            buttonNextHTML: null,
            buttonPrevHTML: null
        });
/////destacados//////
/////nuevos//////
        var carouselIDn = '#featured_nuevos';
        var jcn = null;

        //line up carousel items
        var lineUp = function()
        {
            var height = 0;
            $('li.item', carouselIDn).each(function(i,v){
                $('div.product-info', this).css('height', 'auto');
                var h = $('div.product-info', this).height();
                if ( h > height ) {
                    height = h;
                }
            });
            $('li.item div.product-info', carouselIDn).height(height);
        }

        var mycarousel_initCallback = function(carousel)
        {
            if ( jcn ) {
                return;
            }

            $('#shopper_carousel_nextnuevos').bind('click', function() {
                carousel.next();
                return false;
            });
            $('#shopper_carousel_prevnuevos').bind('click', function() {
                carousel.prev();
                return false;
            });

            if (typeof $(carouselIDn).parent().swipe !== 'undefined'){
                $(carouselIDn).parent().swipe({
                    swipeLeft: function() { carousel.next(); },
                    swipeRight: function() { carousel.prev(); },
                    swipeMoving: function() {}
                });
            }

            jcn = carousel;
        };

        var mycarousel_reloadCallback = function(carousel)
        {
            if ( !isResize('featured_nuevos') ) return;
            carousel.list = $(carouselIDn);
            var li = $(carouselIDn).children('li');
            carousel.list.css(carousel.lt, "0px");
            carousel.list.css(carousel.wh, $(li.get(0)).outerWidth(!0) * li.size() + 100);
            carousel.first = 1;
            carousel.last = $(carouselIDn).parent().width() / $(li.get(0)).outerWidth(!0);
            lineUp();
        }

        $(carouselIDn).jcarousel({
            scroll: 1,
            initCallback: mycarousel_initCallback,
            reloadCallback: mycarousel_reloadCallback,
            buttonNextHTML: null,
            buttonPrevHTML: null
        });
/////nuevos//////
    });

    //]]>
</script>
<script type="text/javascript">
    //<![CDATA[

    //]]>

    //<![CDATA[
    
    //]]>
    </script>
</head>
<body class="  cms-index-index cms-shopper-home-slideshow">
<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
     chromium.org/developers/how-tos/chrome-frame-getting-started -->
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

<div class="wrapper">
        <noscript>
        <div class="global-site-notice noscript">
            <div class="notice-inner">
                <p>
                    <strong>JavaScript seems to be disabled in your browser.</strong><br />
                    You must have JavaScript enabled in your browser to utilize the functionality of this website.                </p>
            </div>
        </div>
    </noscript>
    <div class="page">
        

<script>
jQuery(function($){

	function setcookie(name, value, expires, path, domain, secure) {	// Send a cookie
		// 
		// +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	
		expires instanceof Date ? expires = expires.toGMTString() : typeof(expires) == 'number' && (expires = (new Date(+(new Date) + expires * 1e3)).toGMTString());
		var r = [name + "=" + escape(value)], s, i;
		for(i in s = {expires: expires, path: path, domain: domain}){
			s[i] && r.push(i + "=" + s[i]);
		}
		return secure && r.push("secure"), document.cookie = r.join(";"), true;
	}

	//purchase bar 
	jQuery('#pb_close').click(function(){
		jQuery(this).parent().hide();
		jQuery('body').removeClass('purchase');
		_gaq.push(['_trackEvent', 'Purchase Bar', 'Close', 'Shopper Magento']);			
		setcookie('hide_preview_popup',1, 3600 * 24, '/');
	});
});
</script>


<!-- HEADER BOF -->
<? include("includes/header.php")?>

<!-- HEADER EOF -->
<!-- SLIDESHOW -->
<? if(count($slides)){ ?>
<div class="slider">
<div class="fullwidthbanner-container">
    <div class="fullwidthbanner">
        <ul>
          <? foreach ($slides as $imagen){?>
	        <li  data-transition="fade" data-masterspeed="300" data-slotamount="1" >
              
              <img src="<?=$dirfileout.'b'.$imagen['archivo']?>" alt="<?=nvl($imagen['referencia'])?>" />
              
              <div class="shopper_caption_light"><?=($imagen['referencia']!='') ? $imagen['referencia']:''?>
               <? if($imagen['vinculo']!=''){?>
               <br><span style="font-size:18px;"><a style="color: #FF7302;text-shadow: none;transition-delay: 0s;transition-duration: 0.2s;transition-property: all;transition-timing-function: ease-out;" href="<?=$imagen['vinculo']?>" target="_blank"> Más Información</a></span>
              <? }?></div>
             
            </li>
            <? }?>
			
		</ul>
	    <div class="tp-bannertimer tp-top"></div>
    </div>
</div>
</div>



<? }?>

<!-- SLIDESHOW EOF -->        
<div class="main-container col1-layout">
    <div class="main row clearfix">
       <!-- breadcrumbs BOF -->
        <!-- breadcrumbs EOF -->
        <div class="col-main">
            <div class="std" style="margin-top:30px;">
           <div class="home-main">
  <? if(count($p_ofertas)){?>
<div class="product-slider-container">
    <div class="clearfix title-container">
        <h2><?=PRODUCTOS_TXT?> en oferta</h2>
       <a href="#" class="jcarousel-prev-horizontal" id="shopper_carousel_prevnuevos"></a>
        <a href="#" class="jcarousel-next-horizontal" id="shopper_carousel_nextnuevos"></a>
    </div>
    <ul id="featured_nuevos" class="products-grid jcarousel-skin-tango clearfix two_columns_3">
    
    <? foreach($p_ofertas as $ofer){
        $existencia_n=1;
		$imagen_n= ($ofer['oferta_imagen']!='') ? $dirfileo.'m'.$ofer['oferta_imagen']:(($ofer['archivo']!='') ? $dirfilep.'m'.$ofer['archivo']:URLFILES.'producto.png');
			$titulo_n= ($ofer['oferta_descripcion']!='') ? $ofer['oferta_descripcion']:$ofer['nombre'];
			$enlace_n='main-producto-id-'.$ofer['id_producto'].'-t-'.chstr($titulo_n);
			$precio_old=($ofer['precio']) ? vn($ofer['precio']):'';
			$precio=($ofer['oferta_precio']) ? vn($ofer['oferta_precio']):'';
			
			$faltan= resta_fechas($ofer['oferta_vencimiento'],date("Y-m-d"));
			$estado_o='<div class="faltan">Quedan '.$faltan.' dias</div>';

            if($ofer['oferta_existencia_estado']=='1'){
                if($ofer['oferta_existencia']<=0)
                    $existencia_n=0;
            }
            elseif($ofer['existencia_estado']=='1' and $ofer['existencia']<=0)
            $existencia_n=0;
		
		?>
	     <li class="item">
<div class="new-label new-top-right"></div>
            <div class="regular">
                <a href="<?=$enlace_n?>" title="<?=$titulo_n?> " class="product-image">
                                   
                    <img src="<?=$imagen_n?>" data-srcX2="<?=$imagen_n?>" alt="<?=$titulo_n?>" />
                </a>
                <div class="product-info">
                    <div class="button-container">
                        <p>
                 
                                             
                           <? if($precio and $existencia_n){
                           $nadic=producto::tiene_adicionales($ofer['id_producto']);?>
                  
                           <button type="button" title="Añadir al carrito" class="button <?=(!$nadic) ? 'ajax-cart" data-url="producto-carrito" data-lista="nuevo" data-id="'.$ofer['id_producto']:'" onclick="javascript:window.location=\'main-producto-id-'.$ofer['id_producto'].'\''?>" >
                                <span>
                                    <span>Añadir al carrito</span>
                                </span>
                            </button>
                            <? }?>
                         
                        </p>
                    </div>
                    <a class="product-name" href="<?=$enlace_n?>" title="<?=$titulo_n?>"><?=cutstr_t($titulo_n,65);?></a>
                    <?=$estado_o?>

                    <div class="price-box">                                          
                        <p class="old-price">
                            <span class="price-label"></span>
                            <span class="price" id="old-price-<?= $ofer['id_producto']?>"><?=$precio_old?></span>
                        </p>
                        <p class="special-price">
                                <span class="price-label"></span>
                                <span class="price" id="product-price-<?= $ofer['id_producto']?>"><?=$precio?></span>
                        </p>
                                    
                    
                    </div>
                    

                </div>
            </div>

            <div class="hover">
               <form  id="lnuevo<?= $ofer['id_producto']?>" >  
                <div class="mOptions">
				 <? if(producto::tiene_adicionales($ofer['id_producto'])){?>	
					<div class="spc">
	                <h4>Opciones del producto:</h4>
	               <?= producto::imp_adicionales($ofer['id_producto'],'oferta')?>
					 </div>
					 <?  }else{?>
                     <a href="<?=$enlace_n?>" title="<?=$titulo_n?> " class="product-image">
                                               
                    <img src="<?=$imagen_n?>" data-srcX2="<?=$imagen_n?>"  alt="<?=$titulo_n?>" />
                </a>
					<a href="<?=$enlace_n?>" title="<?=$titulo_n?> " class="product-image">                    
                    <div class="price-box">                                          
                        <p class="old-price">
                            <span class="price-label"></span>
                            <span class="price" id="old-price-<?= $ofer['id_producto']?>"><?=$precio_old?></span>
                        </p>
                        <p class="special-price">
                                <span class="price-label"></span>
                                <span class="price" id="product-price-<?= $ofer['id_producto']?>"><?=$precio?></span>
                        </p>
                  </div>
				</a><? }?>
                 </div> 
                <a class="product-name" href="<?=$enlace_n?>" title="<?=$titulo_n?>"><?=$titulo_n?><br><span class="vermas">VER DETALLES &rarr;</span></a>
                
				<?=$estado_o?>
              
                <div class="button-container">
                
	 
                        <input name="dat[id_producto]" type="hidden" id="idnuevo<?=$ofer['id_producto']?>" value="<?= $ofer['id_producto']?>"  />
                          <input name="dat[nombre]" type="hidden" id="nombrenuevo<?=$ofer['id_producto']?>" value="<?= $titulo_n?>" />
                        <input  name="dat[cantidad]" type="hidden" id="nuevonuevo<?=$ofer['id_producto']?>" value="1" />
	             
                    <?=($precio and $existencia_n) ? '<p><button type="button" title="Añadir al carrito" class="button ajax-cart" data-url="producto-carrito" data-lista="nuevo"  data-id="'.$ofer['id_producto'].'"><span><span><em></em>Añadir al carrito</span></span></button></p>  ':''?>
                    <? if(!$existencia_n){?>
                            <span>AGOTADO</span>
                            <? }?>
                   
                    
                </div> </form>
                <script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery( "#lnuevo<?= $ofer['id_producto']?>" ).validate();
				})
				</script>
                <span class="ajax_loading" id='ajax_loading<?=$ofer['id_producto']?>'><img src='http://shopper.queldorei.com/skin/frontend/shopper/default/images/ajax-loader.gif'/></span>
            </div>

        </li>
        <? }?>
	 
	
		    </ul>
    <div class="clear"></div>
</div>

<? }?>

<!--Slide de produtos del medio --> 
<? if(count($p_destacados)){?>
<div class="product-slider-container">
    <div class="clearfix title-container">
        <h2><?=PRODUCTOS_TXT?> destacados</h2>
       <a href="#" class="jcarousel-prev-horizontal" id="shopper_carousel_prev1381246505"></a>
        <a href="#" class="jcarousel-next-horizontal" id="shopper_carousel_next1381246505"></a>
    </div>
    <ul id="featured_1381246505" class="products-grid jcarousel-skin-tango clearfix two_columns_3">
    <? foreach($p_destacados as $destacado){
        $existencia_d=1;
		$imagen_d= ($destacado['archivo']!='') ? $dirfilep.'m'.$destacado['archivo']:URLFILES.'producto.png';
		
		$precio=($destacado['precio']) ? vn($destacado['precio']):'';
        $desoferta=($destacado['oferta']=='Activo' and ($destacado['oferta_publicacion']<=date("Y-m-d")) and ($destacado['oferta_vencimiento']>date("Y-m-d")) )? 1:0;
		$estado_d='';
        $titulo_d= $destacado['nombre'];
			if($desoferta){
                $titulo_d= ($destacado['oferta_descripcion']!='') ? $destacado['oferta_descripcion'] : $destacado['nombre'];
				$imagen_d= ($destacado['oferta_imagen']!='') ? $dirfileo.'m'.$destacado['oferta_imagen']:$imagen_d;
				$precio_old=$precio;
				$precio=($destacado['oferta_precio']) ? vn($destacado['oferta_precio']):'';
				
				$faltan= resta_fechas($destacado['oferta_vencimiento'],date("Y-m-d"));
				$estado_d='<div class="faltan">Quedan '.$faltan.' dias</div>';
                
                if($destacado['oferta_existencia_estado']=='1' and $destacado['oferta_existencia']<=0)
                    $existencia_d=0;
			}

            if($desoferta and $destacado['oferta_existencia_estado']=='1'){
              if($destacado['oferta_existencia']<=0)
                $existencia=0;
            }
            else if($destacado['existencia_estado']=='1' and $destacado['existencia']<=0)
                 $existencia_d=0;


        $enlace_d='main-producto-id-'.$destacado['id_producto'].'-t-'.chstr($titulo_d);
		?>
	     <li class="item">
<?= ($desoferta) ? '<div class="new-label new-top-right"></div>':''?>
            <div class="regular">
                <a href="<?=$enlace_d?>" title="<?=$titulo_d?> " class="product-image">
                                   
                    <img src="<?=$imagen_d?>" data-srcX2="<?=$imagen_d?>" alt="<?=$titulo_d?>" />
                </a>
                <div class="product-info">
                    <div class="button-container">
                        <p>
                                                 
                            <?if($precio and $existencia_d){
                            
                                     $nadic=producto::tiene_adicionales($destacado['id_producto']);?>
                                     <button type="button" title="Añadir al carrito" class="button <?=(!$nadic) ? 'ajax-cart" data-url="producto-carrito" data-lista="destacado" data-id="'.$destacado['id_producto']:'" onclick="javascript:window.location=\'main-producto-id-'.$destacado['id_producto'].'\''?>" >     
                                      <span>
                                             <span>Añadir al carrito</span>
                                         </span>
                                     </button>
                                     
                            <? }?>
                                      
                            
                         
                            
                           
                        </p>
                    </div>
                    <a class="product-name" href="<?=$enlace_d?>" title="<?=$titulo_d?>"><?=cutstr_t($titulo_d,65);?></a>
                    <?=$estado_d?>

                    <div class="price-box">                                          
                        <?=($desoferta) ? ' <p class="old-price"><span class="price-label"></span>
                            <span class="price" id="old-price-'.$destacado['id_producto'].'">'.$precio_old.' </span></p>':''?>
                        <p class="special-price">
                                <span class="price-label"></span>
                                <span class="price" id="product-price-173"><?=$precio?></span>
                        </p>
                                    
                    
                    </div>

                </div>
            </div>

            <div class="hover">
             <form  id="ldestacado<?= $destacado['id_producto']?>" >
                <div class="mOptions"> 
                <? if(producto::tiene_adicionales($destacado['id_producto'])){?>
                	<div class="spc">
                   <h4>Opciones del producto:</h4>
                  <?= producto::imp_adicionales($destacado['id_producto'],'destacado')?>
                   </div> 
                	 <?  }else{?>
                     <a href="<?=$enlace_d?>" title="<?=$titulo_d?> " class="product-image">
                    <img src="<?=$imagen_d?>" data-srcX2="<?=$imagen_d?>"  alt="<?=$titulo_d?>" />
                </a>
                <a href="<?=$enlace_d?>" title="<?=$titulo_d?> " class="product-image">
               <div class="price-box">                                          
                   <?=($desoferta) ? ' <p class="old-price"><span class="price-label"></span>
                       <span class="price" id="old-price-'.$destacado['id_producto'].'">'.$precio_old.' </span></p>':''?>
                   <p class="special-price">
                           <span class="price-label"></span>
                           <span class="price" id="product-price-173"><?=$precio?></span>
                   </p>
                
               </div>
				</a>
				<? }?>
                </div>
                <a class="product-name" href="<?=$enlace_d?>" title="<?=$titulo_d?>"><?=$titulo_d?><br><span class="vermas">VER DETALLES &rarr;</span></a>
<?=$estado_d?>
                <div class="button-container">
                
	 
                        <input name="dat[id_producto]" type="hidden" id="iddestacado<?=$destacado['id_producto']?>" value="<?= $destacado['id_producto']?>"  />
                          <input name="dat[nombre]" type="hidden" id="nombredestacado<?=$destacado['id_producto']?>" value="<?= $titulo_d?>" />
                        <input  name="dat[cantidad]" type="hidden" id="cantdestacado<?=$destacado['id_producto']?>" value="1" />
	        
                            
                            
                    <?=($precio and $existencia_d) ? '<p><button type="button" title="Añadir al carrito" class="button ajax-cart" data-url="producto-carrito" data-lista="destacado" data-id="'.$destacado['id_producto'].'"><span><span><em></em>Añadir al carrito</span></span></button></p>':''?>
                      <? if(!$existencia_d){?>
                            <span>AGOTADO</span>
                            <? }?>
                  
                </div>  </form>
            </div>

        </li>
        <? }?>
	 
	
		    </ul>
    <div class="clear"></div>
</div>

<? }?>

    </div>


    <div class="home-right">
    <? if(count($comprados)){?>
        <div class="block block-slideshow">
            <div class="block-content">
                <div class="block-slider">
                    <strong>Más comprados</strong>
                    <ul class="slides products-mas">
                        <? foreach ($comprados  as $c_prod) {
                            $imagen_co= ($c_prod['archivo']!='') ? $dirfilep.'m'.$c_prod['archivo']:URLFILES.'producto.png';
                            $precio=($c_prod['precio']) ? vn($c_prod['precio']):'';
                            $cesoferta=($c_prod['oferta']=='Activo' and ($c_prod['oferta_publicacion']<=date("Y-m-d")) and ($c_prod['oferta_vencimiento']>date("Y-m-d")) )? 1:0;
                            $estado_co='';
                            $titulo_co= $c_prod['nombre'];
                            if($cesoferta){
                                $titulo_co= ($c_prod['oferta_descripcion']!='') ? $c_prod['oferta_descripcion'] : $c_prod['nombre'];
                                $imagen_co= ($c_prod['oferta_imagen']!='') ? $dirfileo.'m'.$c_prod['oferta_imagen']:$imagen_co;
                                $precio_old=$precio;
                                $precio=($c_prod['oferta_precio']) ? vn($c_prod['oferta_precio']):'';

                                $faltan= resta_fechas($c_prod['oferta_vencimiento'],date("Y-m-d"));
                                $estado_co='<div class="faltan">Quedan '.$faltan.' dias</div>'; 
                            }
                            $enlace_co='main-producto-id-'.$c_prod['id_producto'].'-t-'.chstr($titulo_co);
                            ?>
                     <li class="item">
                        <?= ($cesoferta) ? '<div class="new-label new-top-right"></div>':''?>
                        <div class="regular">
                            <a href="<?=$enlace_co?>" title="<?=$titulo_co?>" class="product-image">
                                <img src="<?=$imagen_co?>" data-srcX2="<?=$imagen_co?>" alt="<?=$titulo_co?>" style="max-width:200px;" />
                            </a>
                            <div class="product-info">
                                <a class="product-name" href="<?=$enlace_co?>" title="<?=$titulo_co?>"><?=cutstr_t($titulo_co,65);?><br/>
                                    <span class="vermas">VER DETALLES →</span></a>
                                    <?=$estado_co?>
                                    <div class="price-box">                                          
                                        <?=($cesoferta) ? ' <p class="old-price"><span class="price-label"></span>
                                        <span class="price" id="old-price-'.$c_prod['id_producto'].'">'.$precio_old.' </span></p>':''?>
                                        <p class="special-price">
                                            <span class="price-label"></span>
                                            <span class="price" id="product-price-173"><?=$precio?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <? }?>
                    </ul>
                </div>
            </div>
        </div>
        <? }?>

    <? if(count($visitados)){?>
        <div class="block block-slideshow">
            <div class="block-content">
                <div class="block-slider">
                    <strong>Más Visitados</strong>
                    <ul class="slides products-mas">
                        <? foreach ($visitados  as $v_prod) {
                            $imagen_vi= ($v_prod['archivo']!='') ? $dirfilep.'m'.$v_prod['archivo']:URLFILES.'producto.png';
                            $precio=($v_prod['precio']) ? vn($v_prod['precio']):'';
                            $cesoferta=($v_prod['oferta']=='Activo' and ($v_prod['oferta_publicacion']<=date("Y-m-d")) and ($v_prod['oferta_vencimiento']>date("Y-m-d")) )? 1:0;
                            $estado_vi='';
                            $titulo_vi= $v_prod['nombre'];
                            if($cesoferta){
                                $titulo_vi= ($v_prod['oferta_descripcion']!='') ? $v_prod['oferta_descripcion'] : $v_prod['nombre'];
                                $imagen_vi= ($v_prod['oferta_imagen']!='') ? $dirfileo.'m'.$v_prod['oferta_imagen']:$imagen_vi;
                                $precio_old=$precio;
                                $precio=($v_prod['oferta_precio']) ? vn($v_prod['oferta_precio']):'';

                                $faltan= resta_fechas($v_prod['oferta_vencimiento'],date("Y-m-d"));
                                $estado_vi='<div class="faltan">Quedan '.$faltan.' dias</div>'; 
                            }
                            $enlace_vi='main-producto-id-'.$v_prod['id_producto'].'-t-'.chstr($titulo_vi);
                            ?>
                     <li class="item">
                        <?= ($cesoferta) ? '<div class="new-label new-top-right"></div>':''?>
                        <div class="regular">
                            <a href="<?=$enlace_vi?>" title="<?=$titulo_vi?>" class="product-image">
                                <img src="<?=$imagen_vi?>" data-srcX2="<?=$imagen_vi?>" alt="<?=$titulo_vi?>" style="max-width:200px;"/>
                            </a>
                            <div class="product-info">
                                <a class="product-name" href="<?=$enlace_vi?>" title="<?=$titulo_vi?>"><?=cutstr_t($titulo_vi,65);?><br/>
                                    <span class="vermas">VER DETALLES →</span></a>
                                    <?=$estado_vi?>
                                    <div class="price-box">                                          
                                        <?=($cesoferta) ? ' <p class="old-price"><span class="price-label"></span>
                                        <span class="price" id="old-price-'.$v_prod['id_producto'].'">'.$precio_old.' </span></p>':''?>
                                        <p class="special-price">
                                            <span class="price-label"></span>
                                            <span class="price" id="product-price-173"><?=$precio?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <? }?>
                    </ul>
                </div>
            </div>
        </div>
        <? }?>
        
    </div>



  </div>               
</div>
</div>


<!-- footer BOF -->
<? include("includes/footer.php") ?>
<!-- footer EOF -->        </div>
            </div>
</div>
</body>
</html>