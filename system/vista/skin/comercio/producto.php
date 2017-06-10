<? include("includes/tags.php") ?>
<script type="text/javascript">
var carrito_act= <?= (count($adicionales)) ? 0:1 ?>;
var cantidad=1;
var adicionales=[];
<? if(count($adicionales)){
  foreach ($adicionales as $adicional){ $a=0; ?>
    adicionales.push(0);	 
    <? $a++;}} ?>
</script>
<style type="text/css">
.add-to-cart:hover #span_cart { display:block;}
.span_cant{color: #ff0000;}
</style>
</head>
<body class="  catalog-product-view catalog-product-view product-skater-dress-in-leaf-print categorypath-women-dresses-html category-dresses">
    <div class="wrapper">

        <div class="page">
            <!-- HEADER BOF -->
            <? include("includes/header.php") ?>

            <!-- HEADER EOF -->
            <div class="main-container col1-layout">
            <div class="main row clearfix">
            <!-- breadcrumbs BOF -->
            <div class="breadcrumbs">
            <ul>
            <li class="home">
            <a href="main-index" title="Go to Home Page">Inicio</a>
            <span></span>
            </li>
            <li class="category35">
            <a href="main-productos" title=""><?=PRODUCTOS_TXT?></a>
            <span></span>
            </li>
            <li class="product">
            <a title=""><?=nvl($titulo)?></a>
            <span></span>
        </li>

    </ul>
</div>
<!-- breadcrumbs EOF -->
<div class="col-main">
  <? if(nvl($producto['id_producto'],0)){ ?>
     <div class="product-category-title"><?=$titulo?></div>

     <div id="messages_product_view"></div>
     <div class="product-view">
        <div class="product-essential">

            <div class="product-img-box" >
                <?=($esoferta) ? '<div class="new-label new-top-right"></div>':''?>            
                <? $ig='';
                $ip='';
                $i=0;
                foreach($galeria as $images){
                  if($i==0)
                      $imgpregal=$images['archivo'];
                  $ip.='<li>
                  <a href="'.$dirfileout.'b'.$images['archivo'].'" class="cloud-zoom-gallery" title="'.$images['referencia'].'"
                  rel="useZoom: \'cloud_zoom\', smallImage: \''.$dirfileout.'m'.$images['archivo'].'\'" title="'.$images['referencia'].'" >
                  <img src="'.$dirfileout.'m'.$images['archivo'].'" data-srcX2="'.$dirfileout.'m'.$images['archivo'].'" width="100"  alt="'.$images['referencia'].'" title="'.$images['referencia'].'"/>
                  </a>
                  </li>';
                  $i++;
              } ?> 

              <? if($esoferta and $producto['oferta_imagen']!=''){       
               $imagenpre=$producto['oferta_imagen'];
               $dirf=$dirfileo;
           }else{
               $imagenpre=$imgpregal;
               $dirf=$dirfileout;
           }?>
           <p class="product-image">
            <a onClick="return false;" href="<?=$dirf.'b'.$imagenpre?>" class="cloud-zoom" id="cloud_zoom" title="<?=$titulo?>" rel="position:'right',showTitle:false,lensOpacity:0.5,smoothMove:3" >
                <img src="<?=$dirf.'m'.$imagenpre?>" data-srcX2="<?=$dirf.'m'.$imagenpre?>" alt="<?=$titulo?>" title="<?=$titulo?>" width="480"  />
            </a>
        </p>


        <div class="more-views">
            <ul id="shopper_gallery_carousel" class="jcarousel-skin-tango clearfix">
                <? if($esoferta and $producto['oferta_imagen']!=''){?> 
                <li>
                    <a href='<?=$dirfileo.'b'.$producto['oferta_imagen']?>' class='cloud-zoom-gallery' title='<?=$producto['referencia']?>'
                        rel="useZoom: 'cloud_zoom', smallImage: '<?=$dirfileo.'m'.$producto['oferta_imagen']?>' ">
                        <img src="<?=$dirfileo.'m'.$producto['oferta_imagen']?>" data-srcX2="<?=$dirfileo.'m'.$producto['oferta_imagen']?>" width="100" alt=""/>
                    </a>
                </li> 
                <? }?>  
                <?=$ip?>

            </ul>
            <div class="jcarousel-controls">
                <a href="#" class="jcarousel-prev-horizontal" id="shopper_gallery_prev"></a>
                <a href="#" class="jcarousel-next-horizontal" id="shopper_gallery_next"></a>
            </div>
        </div>
        <script type="text/javascript">
        jQuery(document).ready(function($) {

        myCarousel = null; // This will be the carousel object

        function mycarousel_initCallback(carousel, state) {
            if (state == 'init') {
                myCarousel = carousel;
            }
            $('#shopper_gallery_next').bind('click', function() {
                carousel.next();
                return false;
            });
            $('#shopper_gallery_prev').bind('click', function() {
                carousel.prev();
                return false;
            });

            $('.product-view .product-img-box .more-views .jcarousel-skin-tango .jcarousel-container-horizontal').width(400);
            $('.product-view .product-img-box .more-views .jcarousel-skin-tango .jcarousel-clip-horizontal').width(400);
            $('.product-view .product-img-box .more-views .jcarousel-skin-tango .jcarousel-item').width(100);
            $('#shopper_gallery_prev, #shopper_gallery_next').css({marginTop:-80});
        };

        $('#shopper_gallery_carousel').jcarousel({
            scroll: 1,
            initCallback: mycarousel_initCallback,
            buttonNextHTML: null,
            buttonPrevHTML: null
        });

        $(window).resize(function(){
            var n = $('#shopper_gallery_carousel > li').length;
            var w = $('#shopper_gallery_carousel > li').outerWidth(true);
            $('#shopper_gallery_carousel').width(n*w);
            myCarousel.scroll(0);
            $('#shopper_gallery_prev, #shopper_gallery_next').css({marginTop:-($('.cloud-zoom-gallery img').height()/2+17)});
        });
    });
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {

  $('.mousetrap').live('click', function(){
     var images = [];
     imgbox1=$('#cloud_zoom').attr('href');
     ttbox=$('#cloud_zoom').attr('title');
     images.push({href : imgbox1, title : ttbox});

     $('a.cloud-zoom-gallery').each(function(){
        imgbox=$(this).attr('href');
        ttbox=$(this).attr('title');
           // photos = {href : 'img1.jpg', title : 'Title'};
           if(imgbox1!=imgbox)
            images.push({href : imgbox, title : ttbox});
				//images.push($(this).attr('href'));
			});

     $.fancybox(
        images,{
           'padding'			: 0,
           'transitionIn'		: 'none',
           'transitionOut'		: 'none',
           'type'              : 'image',
           'changeFade'        : 0
       });
     return false;
 });

});
</script>
</div>

<div class="product-shop">
</div>
<div class="product-shop-info">
<div class="product-name">
    <h1><?=$titulo?></h1>
</div>

<? if($esoferta){
    $preciopro=($producto['oferta_precio']) ? $producto['oferta_precio']:$producto['precio'];?>
    <div class="price-box">
        <p class="old-price">
           <span class="price-label"></span>
           <span class="price" id="old-price-<?=$producto['id_producto']?>"><?=($producto['precio']) ? vn($producto['precio']):'';?></span>
       </p>
       <span class="regular-price" id="product-price-<?=$producto['id_producto']?>">
         <span class="price"><?=($producto['oferta_precio']) ? vn($producto['oferta_precio']):'';?></span>  </span>

         </div> <?
         $faltan= resta_fechas($producto['oferta_vencimiento'],date("Y-m-d"));?>
         <div class="faltan">Quedan <?=$faltan?> dias</div>
         <? }else{
          $preciopro=$producto['precio'];?>
          <div class="price-box">
            <span class="regular-price" id="product-price-<?=$producto['id_producto']?>">
             <span class="price"><?=($producto['precio']) ? vn($producto['precio']):'';?></span>  </span>

         </div>
         <? }?>
         <p class="sku">REF: <span><?=$producto['referencia']?></span>
          <? $existencia=0;
           $n_existencia=0;
            if($esoferta and $producto['oferta_existencia_estado']=='1'){
              $existencia=1;
              if($producto['oferta_existencia']<=0)
                  $n_existencia=0;
              else
                  $n_existencia=$producto['oferta_existencia'];
            }
            elseif($producto['existencia_estado']=='1'){
              $existencia=1;
              if($producto['existencia']<=0)
                  $n_existencia=0;
              else
                  $n_existencia=$producto['existencia'];
              }?>


            <? if($existencia>0) {?>
              <br>DISPONIBLES: <strong><?=$n_existencia?></strong>
              <? }else{ ?>
              <br>AGOTADO
              <? }?>

               
         </p>

         <div class="clear"></div>                

         <div class="short-description">
            <div class="std"><?=$producto['descripcion']?></div>
        </div>

        <li class="item">
            <a class="product-image" style="display:none">
                <img src="<?=$dirf.'m'.$imagenpre?>" data-srcX2="<?=$dirf.'m'.$imagenpre?>" alt="<?=$titulo?>" title="<?=$titulo?>" />
            </a>
            <form  id="lprod<?= $producto['id_producto']?>" >
             <div class="qty-container clearfix">

              <?  $p=0;
              foreach ($adicionales as $adicional){ 
                  if($adicional['id_adicional']){

                   ?> 
                   <h3><?=$adicional['adicional']?></h3>
                   <?  if($opciones= adicional::obtieneDocs($adicional['id_adicional'])){?>
                   <ul class="adicionales">			
                    <? foreach($opciones as $opt)
                    { ?>
                    <li id="li_<?=$p.'_'.$opt['id_adicional_opcion']?>">
                      <input type="radio" name="opcion[<?=$p?>]" id="opcion_<?=$p.'_'.$opt['id_adicional_opcion']?>" value="<?=$adicional['id_adicional']?>.<?=$opt['id_adicional_opcion']?>_<?=$adicional['adicional']?>: <?=$opt['opcion']?>" onClick="activar_carrito(<?=$p?>)"/>
                      <label for="opcion_<?=$p.'_'.$opt['id_adicional_opcion']?>"><?=$opt['opcion']?></label> 
                  </li>

                  <? }?>
              </ul> 
              <?	}?>
              <?  $p++;}} 
              if($preciopro and $existencia){?>

              <input name="dat[id_producto]" type="hidden" id="product" value="<?= $producto['id_producto']?>"  />
              <input name="dat[nombre]" type="hidden" id="nombre" value="<?= $titulo?>" />
              <label for="qty">Cantidad:</label>
              <input type="text"  name="dat[cantidad]" id="cant_<?=$producto['id_producto']?>" maxlength="12" value="1" onKeyUp="ver_cantidad(<?=$producto['id_producto']?>)" title="Cantidad" class="input-text qty" />
              <span class="span_cant"></span>
          </div>
         
         <div class="add-to-box">
          <div class="add-to-cart">
          <span id="span_cart">Debe llenar todas las opciones</span>
          <button type="button" id="cart_button" title="Añadir al carrito" class="button btn-cart ajax-cart"  data-url="producto-carrito" data-lista="prod" data-id="<?=$producto['id_producto']?>" ><span><span>Añadir al carrito</span></span></button>
          </div>
      </div>
    <? }?>

  </form>       
</li>

<span class="ajax_loading" id='ajax_loading172'><img src='http://shopper.queldorei.com/skin/frontend/shopper/default/images/ajax-loader.gif'/></span>
<div class="clear"></div>

<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
    <a class="addthis_button_preferred_1" title="Twitter"></a>
    <a class="addthis_button_preferred_2"></a>
    <a class="addthis_button_preferred_3"></a>
    <a class="addthis_button_preferred_4"></a>
    <a class="addthis_button_compact"></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-533c8f4a210cf83b"></script>
<!-- AddThis Button END -->
</div>
</div>
<div class="clearer"></div>

<script type="text/javascript">
    //<![CDATA[


    function setAjaxData(data,iframe){
            //showMessage(data.message);
            if (data.status != 'ERROR' && jQuery('.cart-top-container').length) {
                jQuery('.cart-top-container').replaceWith(data.cart_top);
            }
        }

        function showMessage(message)
        {
            jQuery('body').append('<div class="alert"></div>');
            var $alert = jQuery('.alert');
            $alert.slideDown(400);
            $alert.html(message).append('<button></button>');
            jQuery('button').click(function () {
                $alert.slideUp(400);
            });
            $alert.slideDown('400', function () {
                setTimeout(function () {
                    $alert.slideUp('400', function () {
                        jQuery(this).slideUp(400, function(){ jQuery(this).detach(); })
                    });
                }, 7000)
            });
        }

        var productAddToCartForm = new VarienForm('product_addtocart_form');
        productAddToCartForm.submit = function (button, url) {
            if (this.validator.validate()) {
                var form = this.form;
                var oldUrl = form.action;
                if (url) {
                    form.action = url;
                }
                var e = null;
                // Start of our new ajax code
                if (!url) {
                    url = jQuery('#product_addtocart_form').attr('action');
                }
                url = url.replace("checkout/cart", "ajax/index"); // New Code
                var data = jQuery('#product_addtocart_form').serialize();
                data += '&isAjax=1';
                jQuery('#ajax_loading'+ jQuery('#product_addtocart_form').find("[name='product']").val() ).css('display', 'block');
                try {
                    jQuery.ajax({
                        url:url,
                        dataType:'jsonp',
                        type:'post',
                        data:data,
                        success:function (data) {
                            jQuery('#ajax_loading'+ jQuery('#product_addtocart_form').find("[name='product']").val() ).css('display', 'none');
                            setAjaxData(data, true);
                            showMessage(data.message);
                        }
                    });
                } catch (e) {
                }
                // End of our new ajax code
                this.form.action = oldUrl;

                if (e) {
                    throw e;
                }
            }
        }.bind(productAddToCartForm);

        
        productAddToCartForm.submitLight = function(button, url){
           if(this.validator) {
               var nv = Validation.methods;
               delete Validation.methods['required-entry'];
               delete Validation.methods['validate-one-required'];
               delete Validation.methods['validate-one-required-by-name'];
               if (this.validator.validate()) {
                   if (url) {
                       this.form.action = url;
                   }
                   this.form.submit();
               }
               Object.extend(Validation.methods, nv);
           }
       }.bind(productAddToCartForm);
    //]]>
    </script>
</div>

<!-- ADDITIONAL -->

<div class="product-tabs-container clearfix">

	<ul class="product-tabs">
    <li id="product_tabs_description_tabbed" class="first"><a href="#">Descripcion</a></li>
    <?=($esoferta and $producto['oferta_terminos']!='') ? ' <li id="product_tabs_terminos_tabbed"><a href="#">Condiciones</a></li>':''?>
  </ul>

  <h2 id="product_acc_description_tabbed" class="tab-heading"><a href="#">Descripcion</a></h2>
  <div class="product-tabs-content tabs-content" id="product_tabs_description_tabbed_contents"><h2>Detalles</h2>
    <div class="std dcontenido">
      <?=$producto['detalles']?>   </div>
  </div>

   <?=($esoferta and $producto['oferta_terminos']!='') ? '<h2 id="product_acc_terminos_tabbed" class="tab-heading"><a href="#">Condiciones</a></h2>
  <div class="product-tabs-content tabs-content" id="product_tabs_terminos_tabbed_contents"><h2>Terminos</h2>
    <div class="std">'.$producto['oferta_terminos'].'</div></div>':''?> 
</div>

  <script type="text/javascript">
//<![CDATA[
Varien.Tabs = Class.create();
Varien.Tabs.prototype = {
  initialize: function(selector) {
    var self=this;
    $$(selector+' a').each(this.initTab.bind(this));
    this.showContent($$(selector+' a')[0]);
},

initTab: function(el) {
  el.href = 'javascript:void(0)';
  el.observe('click', this.showContent.bind(this, el));
},

showContent: function(a) {
    var li = $(a.parentNode), ul = $(li.parentNode);
    ul.select('li', 'ol').each(function(el){
      var contents = $(el.id+'_contents');
      if (el==li) {
        el.addClassName('active');
        contents.show();
    } else {
        el.removeClassName('active');
        contents.hide();
    }
});
}
}
new Varien.Tabs('.product-tabs');
//]]>
</script>	<!-- ADDITIONAL -->

<!-- RELATED -->
<? if(count($recomendados)){?>
<div class="slider-container">
    <div class="clearfix">
        <h3><?=PRODUCTOS_TXT?> Similares</h3>
        <a href="#" class="jcarousel-prev-horizontal" id="shopper_carousel_prev1381262439"></a>
        <a href="#" class="jcarousel-next-horizontal" id="shopper_carousel_next1381262439"></a>
    </div>
    <ul id="related-products-list" class="jcarousel-skin-tango clearfix products-grid">
        <? foreach($recomendados as $recomendado){
           $existencia=1;
         $imagen_r= ($recomendado['archivo']!='') ? $dirfileout.'m'.$recomendado['archivo']:URLFILES.'producto.png';
         $titulo_r= $recomendado['nombre'];
        
         $precio=($recomendado['precio']) ? vn($recomendado['precio']):'';
         $resoferta=($recomendado['oferta']=='Activo' and ($recomendado['oferta_publicacion']<=date("Y-m-d")) and ($recomendado['oferta_vencimiento']>date("Y-m-d")) )? 1:0;
         $estado_o='';
         if($resoferta){
          $titulo_r= ($recomendado['oferta_descripcion']!='') ? $recomendado['oferta_descripcion']:$recomendado['nombre'];
          $imagen_r= ($recomendado['oferta_imagen']!='') ? $dirfileo.'m'.$recomendado['oferta_imagen']:$imagen_r;
          $precio_old=$precio;
          $precio=($recomendado['oferta_precio']) ? vn($recomendado['oferta_precio']):'';

          $faltan= resta_fechas($recomendado['oferta_vencimiento'],date("Y-m-d"));
          $estado_o='<div class="faltan">Quedan '.$faltan.' dias</div>';

        }

         if($resoferta and $recomendado['oferta_existencia_estado']=='1'){
          if($recomendado['oferta_existencia']<=0)
            $existencia=0;
        }
        elseif($recomendado['existencia_estado']=='1' and $recomendado['existencia']<=0)
            $existencia=0;

         $enlace_r='main-producto-id-'.$recomendado['id_producto'].'-t-'.chstr($titulo_r);
        ?>
        <li class="item clearfix">
            <div class="regular">
                <?= ($resoferta) ? '<div class="new-label new-top-right"></div>':''?>
                <a href="<?=$enlace_r?>" title="<?=$titulo_r?>" class="product-image">

                 <?=($recomendado['estado']=='Nuevo') ?  '<div class="new-label new-top-left"></div>':''?>               
                 <img src="<?=$imagen_r?>" data-srcX2="<?=$imagen_r?>" alt="<?=$titulo_r?>" />
             </a>
             <div class="button-container">

                <input name="dat[id_producto]" type="hidden" id="product" value="<?= $recomendado['id_producto']?>"  />
                <input name="dat[nombre]" type="hidden" id="nombre" value="<?= $titulo_r?>" />

                <input type="hidden"  name="dat[cantidad]" id="recomendado-<?=$recomendado['id_producto']?>" value="1" />


                <p><?if($precio and $existencia){

                   $nadic=producto::tiene_adicionales($recomendado['id_producto']);?>
                   <button type="button" title="Añadir al carrito" class="button <?=(!$nadic) ? 'ajax-cart" data-url="producto-carrito" data-lista="recomendado" data-id="'.$recomendado['id_producto']:'" onclick="javascript:window.location=\'main-producto-id-'.$recomendado['id_producto'].'\''?>" >     
                      <span>
                       <span>Añadir al carrito</span>
                   </span>
               </button>

               <? }?>
           </p>
       </div>
       <a class="product-name" href="<?=$enlace_r?>" title="<?=$titulo_r?>"><?=$titulo_r?></a>

       <?=$estado_o?>

       <div class="price-box">                                          
        <?=($resoferta) ? ' <p class="old-price"><span class="price-label"></span>
        <span class="price" id="old-price-'.$recomendado['id_producto'].'">'.$precio_old.' </span></p>':''?>
        <p class="special-price">

            <span class="price" id="product-price-<?=$recomendado['id_producto']?>"><?=$precio?></span>
        </p>


    </div>
</div>
<div class="hover">
   <form  id="lprod<?= $recomendado['id_producto']?>" >
    <div class="mOptions">
        <? if(producto::tiene_adicionales($recomendado['id_producto'])){?>
        <div class="spc">
           <h4>Opciones del producto:</h4>
           <?= producto::imp_adicionales($recomendado['id_producto'],'destacado')?>
       </div>       	 
       <?  }else{?>
       <a href="<?=$enlace_r?>" title="<?=$titulo_r?>" class="product-image">                         
        <img src="<?=$imagen_r?>" data-srcX2="<?=$imagen_r?>" alt="<?=$imagen_r?>" />
    </a>
    <a href="<?=$enlace_r?>" title="<?=$titulo_r?>">
     <div class="price-box">                                          
        <?=($resoferta) ? ' <p class="old-price"><span class="price-label"></span>
        <span class="price" id="old-price-'.$recomendado['id_producto'].'">'.$precio_old.' </span></p>':''?>
        <span class="regular-price" id="product-price-<?=$recomendado['id_producto']?>">
            <span class="price"><?=$precio?></span>                                    
        </span>

    </div>
</a>
<? }?>
</div>

<a class="product-name" href="<?=$enlace_r?>" title="<?=$titulo_r?>"><?=$titulo_r?><br><span class="vermas">VER DETALLES &rarr;</span></a>
<?=$estado_o?>
<div class="button-container">
    <p>

        <input name="dat[id_producto]" type="hidden" id="idprod<?=$recomendado['id_producto']?>" value="<?= $recomendado['id_producto']?>"  />
        <input name="dat[nombre]" type="hidden" id="nombreprod<?=$recomendado['id_producto']?>" value="<?= $titulo_r?>" />
        <input  name="dat[cantidad]" type="hidden" id="cantprod<?=$recomendado['id_producto']?>" value="1" />

        <?=($precio) ? '<button type="button" title="Añadir al carrito" class="button ajax-cart"  data-url="producto-carrito" data-lista="prod" data-id="'.$recomendado['id_producto'].'">
        <span>
        <span>
        <em></em>Añadir al carrito</span>
        </span>
    </button>':''?>
</p>
</div>

<span class="ajax_loading" id='ajax_loading<?=$recomendado['id_producto']?>'><img src='http://shopper.queldorei.com/skin/frontend/shopper/default/images/ajax-loader.gif'/></span>
</form>
</div>

</li>
<? }?>       


</ul>
<div class="clear"></div>
</div>
<? }?>
<script type="text/javascript">

jQuery(document).ready(function($) {

    function mycarousel_initCallback(carousel)
    {
        $('#shopper_carousel_next1381262439').bind('click', function() {
            carousel.next();
            return false;
        });
        $('#shopper_carousel_prev1381262439').bind('click', function() {
            carousel.prev();
            return false;
        });

        if (typeof $('.slider-container').swipe !== 'undefined'){
            $('.slider-container').swipe({
                swipeLeft: function() { carousel.next(); },
                swipeRight: function() { carousel.prev(); },
                swipeMoving: function() {}
            });
        }
    };

    $('#related-products-list').jcarousel({
        scroll: 1,
        initCallback: mycarousel_initCallback,
        buttonNextHTML: null,
        buttonPrevHTML: null
    });

        //line up carousel items
        $(window).load(function(){
            var height = 0;
            $('li.item', '#related-products-list').each(function(i,v){
                $(this).css('height', 'auto');
                if ( $(this).height() > height ) {
                    height = $(this).height();
                }
            });
            $('li.item', '#related-products-list').height(height);
        });

        $('div.main').after($('<div class="slider-container" />'));

        function carouselResize ()
        {
            var $h = $('.main div.slider-container').outerHeight();
            var $wrap = $('.main-container > .slider-container').css({
                width: '100%',
                height: $h,
                marginTop: '-'+$h+'px',
                position: 'absolute'
            });
        }
        carouselResize();
        $(window).resize(carouselResize);

      jQuery('.qty').keyup(function () { this.value = this.value.replace(/[^0-9]/g,'');});
      check_carrito();
    });

    function activar_carrito(p){
       estado=1;
       adicionales[p]=1;
       for(i=0; i< adicionales.length;i++){
          if(adicionales[i]==0)
              estado=0;
      }
      carrito_act=estado;
      if(carrito_act==1)
       check_carrito();
}

function check_carrito(){
  if(!carrito_act){ //mostrar mensaje
    jQuery("#cart_button").attr('disabled',true);
  }
  else{
    jQuery("#span_cart").remove();
    if(cantidad)
       jQuery("#cart_button").removeAttr('disabled');
       
   }
}
function ver_cantidad(id_producto){
  cantidad=jQuery("#cant_"+id_producto).val();
  jQuery.post("producto-validar_cantidad",{id_producto:id_producto,cantidad:cantidad},function(data){
    if(data=='true'){
      cantidad=1;
       jQuery(".span_cant").html('');
       check_carrito();
    }
    else{
    cantidad=0;
      jQuery("#cart_button").attr('disabled',true);
      jQuery(".span_cant").html('La cantidad solicitada no se encuentra disponible');
    }
  });
}

  
  jQuery(document).ready(function() {
    jQuery('.dcontenido img').each(function(index, el) {
      jQuery(el).addClass('img-responsive');
    });

    var i=1;
    jQuery('.dcontenido iframe').each(function(index, el) {

      jQuery(el).before('<div class="video-container" id="video-container'+i+'"></div>');
      i++;
    });

    var i=1;
    jQuery('.dcontenido iframe').each(function(index, el) {
      jQuery(el).appendTo("#video-container"+i+"");
      i++;
    });


    var i=1;
    jQuery('.dcontenido table').each(function(index, el) {
      jQuery(el).before('<div class="table-responsive" id="tablespace'+i+'" style="overflow:auto"></div>');
      i++;
    });

    jQuery('.dcontenido table').each(function(index, el) {
      jQuery(el).addClass('table');
    });

    var i=1;
    jQuery('.dcontenido table').each(function(index, el) {
      jQuery(el).appendTo("#tablespace"+i);
      i++;
    });
  });
</script>

<!-- RELATED -->
<? } ?>
</div>

</div>
</div>
<!-- footer BOF -->
<? include("includes/footer.php")?>
<!-- footer EOF -->        </div>
</div>
</div>
</body>
</html>