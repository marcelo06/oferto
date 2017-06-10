<? include("includes/tags.php") ?>
<script type="text/javascript">
compra= <?=$compra?>;
$(document).ready(function() {
	redireccion='main-productos';
    if(compra)
    	redireccion='producto-checkout';
    setTimeout(function(){window.location=redireccion; }, 5000);

});
</script>
<!-- Facebook Conversion Code for Registros OFERTO -->
<script>(function() {
var _fbq = window._fbq || (window._fbq = []);
if (!_fbq.loaded) {
var fbds = document.createElement('script');
fbds.async = true;
fbds.src = '//connect.facebook.net/en_US/fbds.js';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(fbds, s);
_fbq.loaded = true;
}
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6017084515343', {'value':'1.00','currency':'COP'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6017084515343&amp;cd[value]=1.00&amp;cd[currency]=COP&amp;noscript=1" /></noscript>
</head>
<body>
	<!-- Google Code for Registros oferto web Conversion Page -->
<script type="text/javascript">
/ <![CDATA[ /
var google_conversion_id = 1029663965;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "Qzx1CL-lrlYQ3dn96gM";
var google_remarketing_only = false;
/ ]]> /
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1029663965/?label=Qzx1CL-lrlYQ3dn96gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<? include("includes/header.php") ?>
<div class="areaHead auto_margin">
	<div class="guia"><a href="main-index">INICIO</a> / REGISTRO EXITOSO /</div>

</div>


<section id="Main">
	<div class="areaCats auto_margin">
	<div class="regPadding">
			<div class="row">
				<div class="col-sm-12">
							
					<div class="height5"></div>
	
					<div style="padding: 0px 40px;">
						<h2 style="padding-left:0; margin-left:0;">¡En hora buena ya estás registrado! </h2>
					    <p style="font-size:16px;">Ahora eres parte del cambio en la manera de comprar, encontrar ofertas, descuentos y promociones. Ya puedes usar tu cuenta de usuario para realizar compras, actualizar tus datos de contacto y revisar tus pedidos. <? if($compra==1){?>
					    Continúa con tu compra <a href="producto-checkout">“Clic Aquí”.</a>
					    <? }?></p>
					    

					    </div>
				   </div>
				
	  </div>
	</div>	
  </div>
<? include("includes/populares.php") ?>
<? include("includes/footer.php") ?>


</body>
</html>