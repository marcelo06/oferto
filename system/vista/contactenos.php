<? include("includes/tags.php") ?>
<script type="text/javascript">
mensaje='<?=nvl($mensaje)?>';
</script>
<script type="text/javascript" src="<?=URLVISTA?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=URLVISTA?>js/contacto.js"></script>

</head>
<body>
<? include("includes/header.php") ?>

<div class="areaHead auto_margin">
	<div class="guia"><a href="">INICIO</a> / CONTÁCTENOS /</div>
</div>

<section id="Main">
	<div class="areaCats auto_margin">
	<div class="regPadding">
			<div class="row">
				<div class="col-sm-12">
							
					<div class="height5"></div>
				
						<div class="container-fluid">	
						   	
						   	<div class="col-sm-12">
						   		<div class="areaRegistro">
						   			<? $infocontacto= configsite::get_tipo('info_contacto')?>
						   		
						   		  	<div class="col-sm-<?=($infocontacto!='') ? '7':'12'?>">
						   		  	<div class="spc">
						   		  	<h3>CONTÁCTENOS</h3>
						   		  <p>Déjenos sus inquietudes o comentarios, pronto nos comunicaremos con usted.</p>
						   		  <div class="row">
						   		  	<div id="msj" style="color:#F0C56B; font-size:18px; font-weight:bold"></div>

						   		  	<form class="formee" action="" id="formC" name="formC" method="post">

						   		  		<div class="col-xs-12">
						   		  			<span class="flabel">Nombre completo</span>
						   		  			<input type="text" name="dat[nombre]" id="nombre" value="" required class="form-control"/>
						   		  		</div>
						   		  		<div class="col-xs-6">
						   		  			<span class="flabel">Email</span>
						   		  			<input type="email" name="dat[email]" id="email" value="" required class="form-control"/>
						   		  		</div>
						   		  		<div class="col-xs-6">
						   		  			<span class="flabel">Teléfono</span>
						   		  			<input type="text" name="dat[telefono]" id="telefono" value="" class="form-control"/>
						   		  		</div>

						   		  		<div class="col-xs-12">
						   		  			<span class="flabel">Comentarios</span>
						   		  			<textarea class="form-control" name="dat[inquietudes]" required id="inquietudes"></textarea>
						   		  		</div>
						   		  		<div class="col-xs-12">
						   		  			<span class="blabel">
						   		  				<button type="submit" class="btn btn-primary upper">Enviar</button>
						   		  			</span>
						   		  		</div>
						   		  	</form>
						   		  </div>

						   		</div>
						   		 </div>
						   		<? if($infocontacto!=''){?>
									<div class="col-sm-5">
										 <div class="spc">
						   		  <div class="row">
						   		  	<h3>INFORMACIÓN DE CONTÁCTO</h3>
						   		  	<p><?=nl2br($infocontacto)?></p>
						   		  </div>
						   		</div>
 </div>
						   		<? }?>



						   		<div style="clear:both"></div>
						   		 
						   		</div>
						   	</div>
						   	
						</div>
				   </div>
				
	  </div>
	</div>	
  </div>
<? include("includes/populares.php") ?>
<? include("includes/footer.php") ?>
</body>
</html>