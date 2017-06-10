<? include("includes/tags.php") ?>
<link rel="stylesheet" type="text/css" href="<?= URLBASE?>system/src/galeryhtml5/uploadifive.css">
<link rel="stylesheet" type="text/css" href="<?= URLBASE?>system/src/galeryhtml5/extras.css">
<?= plugin::message() ?>
<style type="text/css">
.addimage {height: 56px;width: 138px;}

a.fancybox-thumbs,a.fancybox-thumbs:hover {width: 138px;}
</style>
</head>
<body data-mobile-sidebar="button">
	<? include("includes/header.php") ?>
	<div class="container-fluid" id="content">
			<? include("includes/menu.php") ?>
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
						<div class="pull-left">
							<h1>Galería Categoria <? pv($reg['categoria']) ?></h1>
						</div>
					</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="login-inicio">Inicio</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="empresa-categorias">Categorias</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
						<a href="#">Galería Categoria <? pv($reg['categoria']) ?></a>
						</li>
					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>

				<div class="row-fluid">
					<div class="span12">
						<form class='form-vertical form-validate' action="" method="post" enctype="multipart/form-data" name="form1" id="form_content">
							<input type="hidden" name="id" value="<? pv($reg['id_categoria']) ?>" />
							<div class="box">
								<div class="box-content">
									<input type="hidden" name="id_galeria" value="<?= nvl($id_galeria,0)?>" >
									<input type="hidden" name="token" id="token" value="<?= $token ?>" />
									
									<div class="alert alert-info">
										<button type="button" class="close" data-dismiss="alert">×</button>
										Suba la imagen con el botón Agregar Imagen. Las imágenes deben tener un tamaño 
										recomendado de 992px ancho x 400px de alto y un formato .jpg, .png o .gif.
										Sosteniendo la tecla Ctrl puede seleccionar varias imágenes al tiempo.
										Puede ordenar con click sostenido sobre la imagen y moviéndola hacia los lados. 
									</div>
									<div class="row-fluid">
										<div class="span12">
											<input id="file_upload" name="file_upload" type="file" multiple>
											<h5><strong>Im&aacute;genes Cargadas:</strong></h5>
											<div>
												<ul class="sortable gallery" id="fileQueue"></ul>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" name="guardar_btn" value="1"  class="btn btn-primary">Guardar</button>
									<button type="button" class="btn" onClick="location='empresa-categorias'">Cancelar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div style="clear:both"></div>
	<script type="text/javascript" src="<?= URLVISTA ?>admin/js/mensaje.js"></script>
	<script type="text/javascript" src="<?= URLVISTA ?>admin/js/edit_banner.js"></script>
	<script src="<?= URLBASE?>system/src/galeryhtml5/jquery.uploadifive.js" type="text/javascript"></script>
	<script src="<?= URLBASE?>system/src/ui/touch.js" type="text/javascript"></script>
	<script type="text/javascript">
	 var identificador = '<?= nvl($reg['id_categoria']) ?>';
	var mensaje = '<?= nvl($mensaje) ?>';
	var mensaje_tipo = '<?= nvl($mensaje_tipo, 'success') ?>'
	var id_sesion  = '<?= $id_sesion ?>';
	var urlbase    = '<?= URLBASE ?>';
	var urlvista   = '<?= URLVISTA ?>';
	var id_galeria = '<?= nvl($reg['id_galeria']) ?>';
	</script>
</body>
</html>

