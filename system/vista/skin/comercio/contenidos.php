<? include("includes/tags.php") ?>
<script type="text/javascript">
jQuery(document).ready(function() {
	
			jQuery("a[rel=boxFotos]").fancybox({
				'width'				: 'auto',
				'height'			: 'auto',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'transitionIn'		: 'elastic',
				 'titlePosition'    : 'over',
				'overlayOpacity'	:  0.8,
				helpers	: {title : {type : 'over'},thumbs	: {width	: 100,height	: 70}}});
	
			});	

      
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
</head>
<body class="  checkout-cart-index">
<div class="wrapper">
    <div class="page">
<!-- HEADER BOF -->
<? include("includes/header.php")?>

<!-- HEADER EOF -->
	    <div class="main-container col1-layout">
            <div class="main row">
                <!-- breadcrumbs BOF -->
<div class="breadcrumbs">
    <ul>
            <li class="home">
                     <a href="main-index" title="Inicio">Inicio</a>
                       <span></span>
                        </li>
                    <li>
                          <strong><?=$con['titulo']?></strong>
                   </li>
            </ul>
</div>
<!-- breadcrumbs EOF -->
  
<div class="col-main contenido">
<h1 style="font-family: 'Myriad Pro',serif;font-size: 36px;font-weight: 400;letter-spacing: -1.5px;line-height: 30px;text-transform: uppercase; margin-bottom:30px;"><?=$con['titulo']?></h1> 
 <div class="dcontenido"> <?=$con['contenido']?></div>
 
    
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
