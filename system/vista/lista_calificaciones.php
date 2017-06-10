<? include("includes/tags.php") ?>
<script src="<?= URLVISTA ?>js/jRating.jquery.js" type="text/javascript"></script>
<link href="<?= URLVISTA ?>css/jRating.jquery.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(document).ready(function(){

        	$('.rating').jRating({
				length:5,
				decimalLength:0,
				rateMax :5,
				canRateAgain : false,
	 	 		nbRates : 10,
				step:true,
				type:'small',
				 isDisabled : true
			});
    });
</script>
<style type="text/css">
.ctt{float: left; color: #909090; margin-right: 5px; font-size: 16px;}
.rating{float: left; margin-top: 6px;}
</style>
</header>
<body>
	
		<div class="areaPromociones auto_margin">
			<div class="areaTabs" style="border-radius:0">
				<ul id="myTab" class="nav nav-tabs">
					<li><a style="border-right:none">COMENTARIOS Y CALIFICACIONES <span style="font-size:15px">PRODUCTO: <?=$producto['nombre']?></span></a></li></ul>
					<div class="tab-content">
						<? foreach ($calificaciones as $calif) {?>
						<div class="areaRegistro">
							<div class="ctt"><?=$calif['cliente']?> </div>
							<div class="rating" data-average="<?=$calif['calificacion']?>" data-id="<?=$calif['id_productos_calificacion']?>" ></div>
							<p style="clear:both"><?=$calif['comentario']?></p>
						</div>
						<? } ?>
						
					</div>
				</div>	
			</div>
	</body>
</html>