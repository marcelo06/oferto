<? include("includes/tags.php") ?>
</head>
<body>
<? include("includes/header.php") ?>
<div class="areaHead auto_margin">
	<div class="guia"><a href="main-index">INICIO</a> / <?=strtoupper($con['titulo'])?> /</div>

</div>


<section id="Main">
	<div class="areaCats auto_margin">
	<div class="regPadding">
			<div class="row">
				<div class="col-sm-12">
							
					<div class="height5"></div>
	
					<div style="padding: 0px 40px;">
						<h2><?=$con['titulo']?></h2>
					     <?=$con['contenido']?>
					    </div>
				   </div>
				
	  </div>
	</div>	
  </div>
<? include("includes/populares.php") ?>
<? include("includes/footer.php") ?>


</body>
</html>