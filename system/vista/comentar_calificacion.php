<? include("includes/tags.php") ?>
<script type="text/javascript">
	mensaje='<?=nvl($mensaje)?>';
	$(document).ready(function(){
		$( "#formC" ).validate();
		if(mensaje!=''){
		     parent.cerrarComentario(mensaje);
		}
	})
</script>
<script type="text/javascript" src="<?=URLVISTA?>js/jquery.validate.min.js"></script>
</header>
<body>
	
		<div class="areaPromociones auto_margin">
			<div class="areaTabs" style="border-radius:0">
				<ul id="myTab" class="nav nav-tabs">
					<li><a style="border-right:none">COMENTARIO CALIFICACIÓN <span style="font-size:15px">PRODUCTO: <?=$calificacion['nombre']?></span></a></li></ul>
					<div class="tab-content">
						<form class="formee" action="" id="formC" name="formC" method="post">
							<input type="hidden" name="id_calificacion" value="<?=$calificacion['id_productos_calificacion']?>"/>
							<div class="col-xs-12">
								<span class="flabel">Comentarios</span>
								<textarea class="form-control" name="comentario" required id="comentario"><?=$calificacion['comentario']?></textarea>
							</div>
							<div class="col-xs-12">
								<span class="blabel">
									<button type="submit" class="btn btn-primary upper">COMENTAR</button>
								</span>
							</div>
						</form>
					</div>
				</div>	
			</div>
	</body>
</html>