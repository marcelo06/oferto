<? include("includes/tags.php") ?>
<link rel="stylesheet" href="<?=URLSRC?>css/datatable/TableTools.css">
<script src="<?= URLBASE?>system/src/ui/touch.js" type="text/javascript"></script>
<?= plugin::message() ?>
</head>

<body data-mobile-sidebar="button">
	<? include("includes/header.php") ?>
	<div class="container-fluid" id="content">
		<? include("includes/menu.php") ?>
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1><?=$tarea?> Mailing</h1>
					</div>

				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="login-inicio">Inicio</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="mailing-lista">Lista de Mailing</a>
							<i class="icon-angle-right"></i>
						</liv>
						
						<li>

							<a href="javascript:;"><?=$tarea?> Mailing</a>

						</li>

					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
						<form class='form-vertical form-validate' action="" method="post" enctype="multipart/form-data" name="form1" id="form_content">
							<input type="hidden" name="id" value="<?= nvl($reg['id_mailing']) ?>" />
							<input type="hidden" name="dat[id_empresa]" id="id_empresa"  value="<?= nvl($reg['id_empresa'],$_SESSION['id_empresa']) ?>"  />
							<div class="box">
								
								<div class="box-content">
									<div class="row-fluid">
										<div class="span8">
											<div class="row-fluid">
												<div class="span12">

													<div class="control-group">
														<label for="title_meta" class="control-label">Asunto:</label>
														<div class="controls controls-row">
															<input type="text" placeholder="Asunto:" class="input-block-level"  name="dat[asunto]" id="asunto"  value="<?=nvl($reg['asunto']) ?>" <?=(!$edicion ) ? ' disabled="disabled"':''?> />
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
																<textarea  placeholder="Content:" name="dat[contenido]" class='span12'  id="contenido" <?=(!$edicion ) ? ' disabled="disabled"':''?>><?=nvl($reg['contenido']) ?></textarea>
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
										<div class="span4">
											
											<div class="row-fluid">
												<div class="span12">
													<div class="box box-color box-bordered">
														<div class="box-title">
															<h3>
																<i class="icon-table"></i>
																Lista de Clientes
															</h3>
														</div>
														<div class="box-content nopadding">
															<div style="text-align:right; padding:10px 5px; border:1px solid #ddd" id="b-filtros">
																<a href="javascript:limpiar()" title="Limpiar" id="limpiar"></a> <strong>Enviar a clientes que: </strong>
													<?if($edicion ){?>
														
														<input type="hidden" name="dat[filtro]" id="cadfiltro" value="<?=nvl($reg['filtro']) ?>"/>
																<label for="desde">Han realizado compras: &nbsp;&nbsp;&nbsp;
																	Si <input type="radio" name="compras" id="compras_si" value="si" onChange="filtro('compras','si')"  <?=(nvl($filtro['compras'])=='si')? 'checked':'' ?> >
																	&nbsp;&nbsp;No <input type="radio" name="compras" id="compras_no" value="no" onChange="filtro('compras','no')"  <?=(nvl($filtro['compras'])=='no')? 'checked':'' ?> >
																</label>

																<label for="desde">Vienen de: &nbsp;&nbsp;&nbsp;
																	Oferto <input type="radio" name="de" id="de_oferto" value="oferto" onChange="filtro('de','oferto')"  <?=(nvl($filtro['de'])=='oferto')? 'checked':'' ?> >
																	&nbsp;&nbsp;Sitio Web
																	<input type="radio" name="de" id="de_sitio" value="sitio" onChange="filtro('de','sitio')"  <?=(nvl($filtro['de'])=='oferto')? 'checked':'' ?> >
																</label>
																<div id="filtros_oferto" style="padding:3px; background-color:#f6f6f6">
																	<label for="desde">Siguen a la empresa: &nbsp;&nbsp;&nbsp;
																		Si <input type="radio" name="sigue" id="sigue_si" value="si" onChange="filtro('sigue','si')"  <?=(nvl($filtro['sigue'])=='si')? 'checked':'' ?> >
																	&nbsp;&nbsp;No <input type="radio" name="sigue" id="sigue_no" value="no" onChange="filtro('sigue','no')"  <?=(nvl($filtro['sigue'])=='no')? 'checked':'' ?> >
																	</label>
																</div>

																<div id="filtros_sitio" style="padding:3px; background-color:#f6f6f6">
																	<label for="desde">Tienen puntos: &nbsp;&nbsp;&nbsp;
																		Si <input type="radio" name="puntos" id="puntos_si" value="si" onChange="filtro('puntos','si')"  <?=(nvl($filtro['puntos'])=='si')? 'checked':'' ?> >
																	&nbsp;&nbsp;No <input type="radio" name="puntos" id="puntos_no" value="no" onChange="filtro('puntos','no')"  <?=(nvl($filtro['puntos'])=='no')? 'checked':'' ?> >
																	</label>

																</div>

														<? }
														else{?>

																<?=(nvl($filtro['compras'])!='') ? '<label >Han realizado compras: '.$filtro['compras'].'</label>':''?>
																<?=(nvl($filtro['de'])!='') ? '<label >Vienen de: '.$filtro['de'].'</label>':''?>
																<?=(nvl($filtro['siguen'])!='') ? '<label >Siguen a la empresa: '.$filtro['siguen'].'</label>':''?>
																<?=(nvl($filtro['puntos'])!='') ? '<label >Tienen puntos: '.$filtro['puntos'].'</label>':''?>
																

														<? }?>




													</div>
															<table class="table table-hover table-nomargin table-bordered dataTableProd" id="clientes">
																<thead>
																	<tr>
																		<th>Nombre</th>
																		<th>Email</th>
																		<th>De</th>
																	</tr>
																</thead>
																<tbody></tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-actions">
										<? if($edicion){?>
										<button type="submit" class="btn btn-primary">Guardar </button>
										<button type="submit" name="guardar_enviar" value="guardarEnviar" class="btn btn-primary">Guardar y Enviar <i class="glyphicon-message_out"></i></button>
										<button type="button" class="btn" onClick="location = 'mailing-lista'">Cancelar</button>
										<? }else {?>
											<a href="mailing-editar-id-<?=$reg['id_mailing']?>-c-1" class="btn btn-primary">CREAR COPIA</a>
										<?}?>
										
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
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/edit_mailing.js"></script>
		<script src="<?=URLSRC?>js/datatable/jquery.dataTables.min.js"></script>
		<script src="<?=URLSRC?>js/datatable/TableTools.min.js"></script>
		<script src="<?=URLSRC?>js/datatable/ColReorder.min.js"></script>
		<script src="<?=URLSRC?>js/datatable/ColVis.min.js"></script>
		<script src="<?=URLSRC?>js/datatable/jquery.dataTables.columnFilter.js"></script>
		<script src="<?= URLSRC ?>js/datatable/jquery.reload.js"></script>

		<!-- CKEditor -->
		<script src="<?= URLSRC ?>js/ckeditor/ckeditor.js"></script>

		<script type="text/javascript">
		var identificador = '<?= nvl($reg['id_mailing']) ?>';
		var mensaje = '<?= nvl($mensaje) ?>';
		var mensaje_tipo = '<?= nvl($mensaje_tipo, 'success') ?>'
		var urlbase    = '<?= URLBASE ?>';
		var urlvista   = '<?= URLVISTA ?>';
		var empresa=<?= nvl($reg['id_empresa'],$_SESSION['id_empresa']) ?>;

		var de='<?=nvl($filtro['de']) ?>';
		var compras='<?=nvl($filtro['compras']) ?>';
		var sigue='<?=nvl($filtro['sigue']) ?>';
		var puntos='<?=nvl($filtro['puntos']) ?>';

		</script>
	</body>

	</html>

