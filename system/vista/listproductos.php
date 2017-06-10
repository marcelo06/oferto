<? include("includes/tags.php") ?>
<link rel="stylesheet" type="text/css" href="<?=URLVISTA?>css/slider.css" media="all" />
<style type="text/css">
.slider-selection {
    background: #FF1267;
}
.mostrar{ margin-right: 10px;}
.precio_rango{padding: 0 10px 0 5px; height: auto !important; float: right; font-weight: normal;}
 span#slide_min {
    display: inline-block;
    text-align: right;
    width: 67px;
}
</style>
<script type="text/javascript">
var pagina=1;
var categoria= <?=$categoria?>;
var seed= <?=$seed?>;
var precio= 0;
var descuento= 0;
var orden='';
var rango='';
var busqueda= '<?=$busqueda?>';
var siguiendo= '<?=$siguiendo?>';
</script>
<? if(count($banner)){?>
<script type="text/javascript">
 $(document).ready(function() {
    var sync1 = $("#sync1");
    var sync2 = $("#sync2");
     
    sync1.owlCarousel({
    singleItem : true,
    slideSpeed : 5000,
    navigation: true,
    pagination:false,
    <? if(count($banner)>1){?>autoPlay:true,<? }?>
    transitionStyle : "fadeUp",
    afterAction : syncPosition,
    responsiveRefreshRate : 200,
    });
     
    sync2.owlCarousel({
    items : 4,
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [979,4],
    itemsTablet : [768,3],
    itemsMobile : [479,2],
    pagination:false,
    responsiveRefreshRate : 100,
    afterInit : function(el){
    el.find(".owl-item").eq(0).addClass("synced");
 	
    }
    });
     
     
    function syncPosition(el){
    var current = this.currentItem;
    $("#sync2")
    .find(".owl-item")
    .removeClass("synced")
    .eq(current)
    .addClass("synced")
    if($("#sync2").data("owlCarousel") !== undefined){
    center(current)
    }
    }
     
    $("#sync2").on("click", ".owl-item", function(e){
    e.preventDefault();
    var number = $(this).data("owlItem");
    sync1.trigger("owl.goTo",number);
    });
     
    function center(number){
    var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
    var num = number;
    var found = false;
    for(var i in sync2visible){
    if(num === sync2visible[i]){
    var found = true;
    }
    }
     
    if(found===false){
    if(num>sync2visible[sync2visible.length-1]){
    sync2.trigger("owl.goTo", num - sync2visible.length+2)
    }else{
    if(num - 1 === -1){
    num = 0;
    }
    sync2.trigger("owl.goTo", num);
    }
    } else if(num === sync2visible[sync2visible.length-1]){
    sync2.trigger("owl.goTo", sync2visible[1])
    } else if(num === sync2visible[0]){
    sync2.trigger("owl.goTo", num-1)
    }
    }
     
    });

</script>
<? }?>
</head>
<body>
<? include("includes/header.php") ?>

<div class="areaHead auto_margin">
	<div class="guia"><a href="">INICIO</a> / <?=($siguiendo) ? 'PRODUCTOS SIGUIENDO':'CATEGORÍAS'?> /</div>
	<h1><?=$miga?></h1>
</div>

<section id="Main">
	<? if(count($banner)){?>
<section id="Middle" class="auto_margin" style="padding-bottom:20px;">
	<div class="row">
	<div class="col-sm-12">
    <div id="sync1" class="owl-carousel">
    	<? foreach ($banner as $slide) { ?>
   	   <div class="item"><a <?=($slide['vinculo']) ? 'href="'.$slide['vinculo'].'" target="_blank"':'' ?>  title="<?=$slide['referencia'] ?>"><img src="<?=$dirbanner.'b'.$slide['archivo']?>" alt="<?=$slide['referencia'] ?>" /></a></div>
   	   <? }?>
    </div>
     <? if(count($banner)>1){?>
	<div id="sync2" class="owl-carousel">
		<? foreach ($banner as $slide) { ?>
		<div class="item"><img src="<?=$dirbanner.'b'.$slide['archivo']?>"></div>
		<? }?>
	</div>
	<? }?>
	</div>
	</div>
</section>
<? } ?>
	<div class="areaCats auto_margin">
	<div class="filtro">
		<div class="dropSelct">FILTRAR POR: 
		<select id="selcategorias" onChange="ver_categorias()">
			<?=$scategorias?>
		</select> 

		<select id="ordenar" onChange="ordenar()">
			<option value='0'>Ordenar por:</option>
			<option value='porcentaje desc'>Mayor porcentaje</option>
			<option value='porcentaje asc'>Menor porcentaje</option>
			<option value='oferta_precio desc'>Mayor precio</option>
			<option value='oferta_precio asc'>Menor precio</option>
		</select> 

		<div class="limiter toolbar-switch precio_rango">
            <label style="float:left;">Precio</label><div style="float:left;"><span id="slide_min">$<?=number_format($r1,0,'.','.')?></span> <input id="pr_slider" type="text" class="" value="" data-slider-min="0" data-slider-max="<?=$rmax?>" data-slider-step="1" data-slider-value="[<?=$r1?>,<?=$r2?>]" data-slider-tooltip="hide"/> <span id="slide_max">$<?=number_format($r2,0,'.','.')?></span> </div>
        </div>


		<?=($busqueda!='') ? '<span class="tt_search">Palabra(s) clave(s): </span>'.$busqueda.'':''?></div> 
		<div class="linkMap"><a href="mapa-ofertas<?=($categoria) ? '-c-'.$categoria:''?>">VER MAPA</a></div>
		<div class="clearfix"></div>
	</div>
	
	<div class="listCategorias">
	   <div class="row" id="Ofertas">
	   			
	   </div>
	   <div id="more_content"><div id="cargar" class="loading" >CARGANDO <span>OFERTAS</span></div></div>
    </div> 	
  </div>
	</div>
<? include("includes/populares.php") ?>
<? include("includes/footer.php") ?>
<script type="text/javascript" src="<?=URLVISTA?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=URLVISTA?>js/bootstrap-slider.js"></script>
<script type="text/javascript">

$(document).ready(function() {
	cargarOfertas	(1);
	$(window).bind('scroll', function () {
		$(document).ready(function() {
			var docViewTop = $(window).scrollTop();
			var docViewBottom = docViewTop + $(window).height();

			if($("#cargar").is('*') && pagina!=1)
			{
				var elemTop = $("#cargar").offset().top;
				var elemBottom = elemTop + $("#cargar").height();
				if((elemBottom <= docViewBottom) && (elemTop >= docViewTop) ){
					$("#more_content").html('');
					cargarOfertas(pagina)
				}
			}
		});
	});

    
    $('#pr_slider').slider({
        formater: function(value) {
            return '$'+number_format(value,0,'.','.');
        }
    }).on('slideStop', function(data){
        $('#slide_min').html('$'+number_format(data.value[0],0,'.','.'));
        $('#slide_max').html('$'+number_format(data.value[1],0,'.','.'));
        nrango=data.value[0]+'_'+data.value[1];
       
       add_rango(nrango);
    }).on('slide', function(data){
        $('#slide_min').html('$'+number_format(data.value[0],0,'.','.'));
        $('#slide_max').html('$'+number_format(data.value[1],0,'.','.'));
       
    });
})

function ordenar(){
	orden='';
	if($("#ordenar").val()!='0')
		orden=$("#ordenar").val();
	pagina=1;
	$("#Ofertas").html('');
	$("#more_content").html('');
	cargarOfertas(pagina)

		
}
function cargarOfertas(pag){
	$.ajax({
		url:'producto-paginar',
		type: 'POST',
		dataType: 'json',
		data: {pagina:pag, categoria:categoria, busqueda:busqueda,orden:orden,siguiendo:siguiendo,rango:rango,seed:seed},
		success: function(datos){  
			data= datos.productos;
			total= datos.total;
			$("#Ofertas").append(data);	
			
			if(datos.siguiente!='' ){
				pagina= datos.siguiente;
				$("#more_content").html('<div id="cargar" class="loading" >CARGANDO <span>OFERTAS</span></div>');
			}
			else if(total==0){
				$("#more_content").html('No se encontraron Ofertas');
			}
			else
				$("#more_content").html('');
		}
	});
}
function ver_categorias(){
	vcate=$("#selcategorias").val();
		window.location =vcate;
}

function add_rango(nrango){
    rango=nrango;
    pagina=1;
	$("#Ofertas").html('');
	$("#more_content").html('');
	cargarOfertas(pagina);
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