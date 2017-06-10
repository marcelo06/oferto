<? include("includes/tags.php") ?>
<script src="<?= URLBASE?>system/src/ui/touch.js" type="text/javascript"></script>
<?= plugin::message() ?>
<?= plugin::fancybox_2_1() ?>
</head>

<body data-mobile-sidebar="button">
	<? include("includes/header.php") ?>
	<div class="container-fluid" id="content">
		<? include("includes/menu.php") ?>
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1><?=$tarea?> <?=$tipo?></h1>
					</div>

				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="login-inicio">Inicio</a>
							<i class="icon-angle-right"></i>
						</li>
						
                        <li>
							<a href="javascript:;"><?=$tarea?> Contenido</a>

						</li>

					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
                    <form class='form-vertical form-validate' action="" method="post" enctype="multipart/form-data" name="form1" id="form_content">
                      <input type="hidden" name="id" value="<?= nvl($reg['id_contenido']) ?>" />
                      <input type="hidden" name="dat[tipo]" id="tipo"  value="<?= nvl($reg['tipo'],1) ?>"  />
                      <input type="hidden" name="dat[id_empresa]" id="id_empresa"  value="<?= nvl($reg['id_empresa'],$_SESSION['id_empresa']) ?>"  />
                      <div class="box">
						<div class="box-title">
								<h3>Meta Tags</h3>
							</div>
							<div class="box-content">

									<div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="title_meta" class="control-label">Título Meta Tag:</label>
												<div class="controls controls-row">
													<input type="text" placeholder="Título Meta Tag:" class="input-block-level"  name="dat[title_meta]" id="title_meta"  value="<?php pv($reg['title_meta']) ?>"  />
												</div>
											</div>
										</div>
                                        </div>
                                        <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="keywords_meta" class="control-label">Descripción Meta Tag : </label>
												<div class="controls controls-row">
													<textarea  placeholder="Descripción Meta Tag:" class="input-block-level" name="dat[descripcion_meta]" rows="2" id="descripcion_meta"><?php pv($reg['descripcion_meta']) ?></textarea>
												</div>
											</div>
										</div>


									</div>


                                       </div>

							<div class="box-title">
								<h3></h3>
							</div>
							<div class="box-content">
                                        <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="titulo" class="control-label">Título: </label>
												<div class="controls controls-row">
                                              
													<input type="text" placeholder="Título:" class="input-block-level" name="dat[titulo]" id="titulo" value="<?=nvl($reg['titulo'])?>" data-rule-required="true"  />
                                               </div>
											</div>
										</div>
										
									</div>
                                </div>
                                <div class="box-title">
								<label for="content" class="control-label">Contenido: </label>
							</div>
							<div class="box-content nopadding">
                                   <div class="row-fluid">
										<div class="span12">
											<div class="control-group">

												<div class="controls controls-row">
													<textarea  placeholder="Content:" name="dat[contenido]" class='span12 ckeditor'  id="ck" ><?php pv($reg['contenido']) ?></textarea>
												</div>
											</div>
										</div>

									</div>
                                     </div>

					
							
								<div class="form-actions">
										<button type="submit" class="btn btn-primary">Guardar </button>
										<button type="button" class="btn" onClick="location = 'contenido-lista'">Cancelar</button>
									</div>

                                </div>

								</form>
							</div>
						</div>
					</div>
				</div>

			</div>

		<div style="clear:both"></div>
        <? include("includes/footer.php") ?>
        <script type="text/javascript" src="<?= URLVISTA ?>admin/js/mensaje.js"></script>

		<!-- CKEditor -->
	    <script src="<?= URLSRC ?>js/ckeditor/ckeditor.js"></script>

		<script type="text/javascript">
		 var identificador = '<?= nvl($reg['id_contenido']) ?>';
		
		var mensaje = '<?= nvl($mensaje) ?>';
		var mensaje_tipo = '<?= nvl($mensaje_tipo, 'success') ?>'

		var urlbase    = '<?= URLBASE ?>';
		var urlvista   = '<?= URLVISTA ?>';

		</script>
	</body>

	</html>

