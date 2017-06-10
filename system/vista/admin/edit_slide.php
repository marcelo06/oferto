<? include("includes/tags.php") ?>
<link rel="stylesheet" type="text/css" href="<?= URLBASE?>system/src/galeryhtml5/uploadifive.css">
<link rel="stylesheet" type="text/css" href="<?= URLBASE?>system/src/galeryhtml5/extras.css">
<style type="text/css">
a.fancybox-thumbs,a.fancybox-thumbs:hover,.addimage, .imggal {height: 56px;width: 146px;}
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
							<h1>Galería Principal</h1>
						</div>
					</div>
					<div class="breadcrumbs">
					<ul>
						<li>
							<a href="login-inicio">Inicio</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="#">Galería Principal</a>
						</li>
					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
				
				<div class="row-fluid">
					<div class="span12">
					<div class="box box-color box-bordered darkblue">
					<div class="box-title">
									<h3>
										<i class="icon-camera"></i>
										Slide Inicial
									</h3>
								</div>

                    <form class='form-vertical'action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    <input type="hidden" name="id" value="<?=nvl($id_slide)?>" />
                     <input type="hidden" name="token" id="token" value="<?= $token ?>" />
						<div class="box">
							
							<div class="box-content">
								<div class="alert alert-info">
								           <button type="button" class="close" data-dismiss="alert">×</button>
								           Suba la imagen con el botón Agregar Imagen. Las imágenes deben tener un tamaño 
								           recomendado de <strong>1200px ancho x 450px</strong> de alto y un formato .jpg, .png o .gif.
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
										<button type="submit" name="guardar_btn" value="1" class="btn btn-primary">Guardar</button>
										<button type="button" class="btn" onClick="location = 'login-inicio'">Cancelar</button>
									</div>
                                </div>	
									
								</form>
							</div>
							</div>
						</div>
					</div>
				</div>	
				
			</div>
		
		
        <? include("includes/footer.php") ?>
       
        <script type="text/javascript" src="<?= URLVISTA ?>admin/js/mensaje.js"></script>
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/edit_slide.js?v=1"></script>

		<script src="<?= URLBASE?>system/src/galeryhtml5/jquery.uploadifive.js" type="text/javascript"></script>
		<script src="<?= URLBASE?>system/src/ui/touch.js" type="text/javascript"></script>
		<?= plugin::message() ?>
		<?= plugin::fancybox_2_1() ?>
		<script type="text/javascript">
				var urlbase    = '<?= URLBASE ?>';
				var urlvista   = '<?= URLVISTA ?>';
				
				var mensaje = '<?= nvl($mensaje) ?>';
				var mensaje_tipo = '<?= nvl($mensaje_tipo, 'success') ?>'
				var id_sesion = '<?= $id_sesion ?>';
				var id_galeria = '<?= nvl($id_slide) ?>';
		</script>
</body>
</html>