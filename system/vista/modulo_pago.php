<? include("includes/tags.php") ?>
<script type="text/javascript">
$(document).ready(function() {
    $("#form_pago").submit();
});
</script>
<body>
<? include("includes/header.php") ?>
<div class="areaHead auto_margin">
	<div class="guia"><a href="main-index">INICIO</a> / Módulo de pago /</div>

</div>


<section id="Main">
	<div class="areaCats auto_margin">
		<div class="areaTabs" style="border:0px">
	<div class="regPadding">
			<div class="row">
				<div class="col-sm-12">
							
					<div class="height5"></div>
	
					<div style="padding: 0px 40px;">
						<h2>MÓDULO DE PAGO</h2>
					    <?= nvl($informe)?>
						  <?= nvl($tabla)?>
						 <?= nvl($form)?>
						 <?= nvl($mensaje)?>
					    </div>
				   </div>
				
	  </div>
	</div>
	</div>	
  </div>
</section>
<? include("includes/footer.php") ?>


</body>
</html>