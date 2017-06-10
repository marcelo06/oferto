<? include("includes/tags.php") ?>
<script src="<?= URLBASE?>system/src/ui/touch.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?=URLSRC?>css/datatable/TableTools.css">
<script src="<?= URLBASE?>system/src/ui/touch.js" type="text/javascript"></script>
<!-- chosen -->
	<link rel="stylesheet" href="<?=URLSRC?>css/chosen/chosen.css">
<!-- select2 -->
	<link rel="stylesheet" href="<?=URLSRC?>css/select2/select2.css">

<link rel="stylesheet" href="<?=URLSRC?>datetimepicker/bootstrap-datetimepicker.css">


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
						<h1><?=$tarea?> Notificacion</h1>
					</div>

				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="login-inicio">Inicio</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="notificacion-lista">Lista de Notificacion</a>
							<i class="icon-angle-right"></i>
						</liv>
						
						<li>

							<a href="javascript:;"><?=$tarea?> Notificacion</a>

						</li>

					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
						<form class='form-vertical form-validate' action="" method="post" enctype="multipart/form-data" name="form1" id="form_content">
							<input type="hidden" name="id" value="<?= nvl($reg['id_notificacion']) ?>" />
							<div class="box">
								<div class="box-content">
									<div class="row-fluid">
										<div class="span12">

											<div class="control-group">
												<label for="title_meta" class="control-label">Titulo:</label>
												<div class="controls controls-row">
													<input type="text" placeholder="Titulo:" class="input-block-level"  name="dat[titulo]" id="titulo"  value="<?=nvl($reg['titulo']) ?>" <?=(!$edicion ) ? ' disabled="disabled"':''?> />
												</div>
											</div>
										</div>
									</div>
									<div class="row-fluid">
										<div class="span12">

											<div class="control-group">
												<label for="title_meta" class="control-label">Mensaje:</label>
												<div class="controls controls-row">
													<input type="text" placeholder="Mensaje:" class="input-block-level"  name="dat[mensaje]" id="mensaje"  value="<?=nvl($reg['mensaje']) ?>" <?=(!$edicion ) ? ' disabled="disabled"':''?> />
												</div>
											</div>
										</div>
									</div>



									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="textfield" class="control-label">Acción en App</label>
												<div class="controls  controls-row">
												<select name="dat[accion]" id="accion" class='input-block-level select' onChange="actualizarAccion()">
													<?=$acciones?>
												</select>
											</div>
											</div>
										</div>
										<div class="span6 boxAccion" id="boxOferta">
											<div class="control-group">
												<label for="textfield" class="control-label">Oferta destino</label>
												<div class="controls  controls-row">
												<select name="dat[id_oferta]" id="id_oferta" class='input-block-level select'>
													<option >Seleccione una oferta</option>
												<?=$ofertas?></select>
											</div>
											</div>
										</div>

										<div class="span6 boxAccion" id="boxCategoria">
											<div class="control-group">
												<label for="textfield" class="control-label">Categoría destino</label>
												<div class="controls  controls-row">
												<select name="dat[id_categoria]" id="id_categoria" class='input-block-level chosen-select '>
												<option >Seleccione una categoría</option>
												<?=$categorias?></select>
											</div>
											</div>
										</div>
									</div>


									<div class="row-fluid">
										<div class="span12">
											<div class="control-group">
											<label for="archivo" class="control-label"> Imagen oferta (<strong>500px ancho </strong>)</label>
                                            <input type="hidden" name="delimg" id="delimg" value="0"/>
											<div class="controls">
												<div class="fileupload fileupload-<?=(nvl($reg['imagen'])!='') ?'exists':'new'?>" data-provides="fileupload">
													<div class="fileupload-new thumbnail" style="width: 110px; height: 81px;"><img src="<?=URLVISTA?>admin/img/noimage.gif" /></div>
													<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 200px; line-height: 20px;">
                                                    <?=(nvl($reg['imagen'])!='') ?'<img src="'.URLFILES.'notificaciones/s'.$reg['imagen'].'" />':''?>
                                                    </div>
													<div>
														<span class="btn btn-file"><span class="fileupload-new">Seleccione una imagen</span><span class="fileupload-exists">Cambiar</span><input type="file" name='archivo' id="archivo" /></span>
														<a href="javascript:void(0)" onClick="borrararch()" class="btn fileupload-exists" data-dismiss="fileupload">Eliminar</a>
													</div>
												</div>
											</div>
										</div>
										</div>
                                 </div>

                                 <div class="row-fluid">
										<div class="span12">

											<div class="control-group">
												<label for="title_meta" class="control-label">Fecha de envio:</label>
												<div class="controls controls-row">
													 <input type='text' class="input-block-level" name="dat[fecha]" id='fecha' data-date-format="YYYY-MM-DD HH:mm:ss" value="<?=nvl($reg['fecha']) ?>" <?=(!$edicion ) ? ' disabled="disabled"':''?> />
													 <script type="text/javascript">
											            $(function () {
											                $('#fecha').datetimepicker({
															        use24hours: true,
															        useSeconds: true
															    });
											            });
											        </script>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span12">
											<div class="box box-color box-bordered">
												<div class="box-title">
													<h3>
														
														Dispositivos disponibles:  <span id="total" style="font-size:20px;font-weight:bold;"></span>
													</h3>
												</div>
												<div class="box-content ">
													<div class="row-fluid">
										<div class="span12" id="b-filtros" >
														<a href="javascript:limpiar()" title="Limpiar" id="limpiar"></a> <strong>Enviar a clientes que: </strong>
														<?if($edicion ){?>
														
														<input type="hidden" name="dat[filtro]" id="cadfiltro" value="<?=nvl($reg['filtro']) ?>"/>
														
														<label for="logueado">Está Logueado en la app: &nbsp;&nbsp;&nbsp;
															Si <input type="radio" name="logueado" id="logueado_si" value="si" onChange="filtro('logueado','si')"  <?=(nvl($filtro['logueado'])=='si')? 'checked':'' ?> >
															&nbsp;&nbsp;No
															<input type="radio" name="logueado" id="logueado_no" value="no" onChange="filtro('logueado','no')"  <?=(nvl($filtro['logueado'])=='no')? 'checked':'' ?> >
														</label>
														<div id="filtros_login" style="padding:3px; background-color:#f6f6f6">
															<label for="compras">Han realizado compras: &nbsp;&nbsp;&nbsp;
																Si <input type="radio" name="compras" id="compras_si" value="si" onChange="filtro('compras','si')"  <?=(nvl($filtro['compras'])=='si')? 'checked':'' ?> >
																&nbsp;&nbsp;No <input type="radio" name="compras" id="compras_no" value="no" onChange="filtro('compras','no')"  <?=(nvl($filtro['compras'])=='no')? 'checked':'' ?> >
															</label>
														</div>

														<? }
														else{?>
														<?=(nvl($filtro['logueado'])!='') ? '<label >Usuario Logueado en app: '.$filtro['logueado'].'</label>':''?>		
														<?=(nvl($filtro['compras'])!='') ? '<label >Han realizado compras: '.$filtro['compras'].'</label>':''?>
														
														<? }?>
													</div>
												
													
												</div>
											</div>
										</div>
										<br><br>
									</div>
									<div class="form-actions">
										<? if($edicion){?>
										<button type="submit" class="btn btn-primary">Guardar </button>
										<button type="submit" name="guardar_enviar" value="guardarEnviar" class="btn btn-primary">Guardar y Enviar <i class="glyphicon-iphone_shake"></i></button>
										<button type="button" class="btn" onClick="location = 'notificacion-lista'">Cancelar</button>
										<? }else {?>
										<a href="notificacion-editar-id-<?=$reg['id_notificacion']?>-c-1" class="btn btn-primary">CREAR COPIA</a>
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
		<script src="<?= URLSRC ?>js/imagesLoaded/jquery.imagesloaded.min.js"></script>
		<script src="<?=URLSRC?>js/touch-punch/jquery.touch-punch.min.js"></script>
		<script src="<?=URLSRC?>js/fileupload/bootstrap-fileupload.js"></script>

		<script src="<?=URLSRC?>js/datatable/jquery.dataTables.min.js"></script>
		<script src="<?=URLSRC?>js/datatable/TableTools.min.js"></script>
		<script src="<?=URLSRC?>js/datatable/ColReorder.min.js"></script>
		<script src="<?=URLSRC?>js/datatable/ColVis.min.js"></script>
		<script src="<?=URLSRC?>js/datatable/jquery.dataTables.columnFilter.js"></script>
		<script src="<?= URLSRC ?>js/datatable/jquery.reload.js"></script>
		<!-- Chosen -->
	<script src="<?=URLSRC?>js/chosen/chosen.jquery.min.js"></script>
	<!-- select2 -->
	<script src="<?=URLSRC?>js/select2/select2.min.js"></script>
		<!-- CKEditor -->
		<script src="<?= URLSRC ?>js/ckeditor/ckeditor.js"></script>
		<script src="<?=URLSRC?>datetimepicker/moment.js"></script>
		<script src="<?=URLSRC?>datetimepicker/bootstrap-datetimepicker.js"></script>
		

		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/mensaje.js"></script>
		<script type="text/javascript">
		var identificador = '<?= nvl($reg['id_notificacion']) ?>';
		var mensaje = '<?= nvl($mensaje) ?>';
		var mensaje_tipo = '<?= nvl($mensaje_tipo, 'success') ?>'
		var urlbase    = '<?= URLBASE ?>';
		var urlvista   = '<?= URLVISTA ?>';
		var edicion = '<?=$edicion?>';
		var compras='<?=nvl($filtro['compras']) ?>';
		var logueado='<?=nvl($filtro['logueado']) ?>';
		$(document).ready(function(){
			if(<?=($filtro['logueado']=='') ? 1:0?>)
				$("#filtros_login").hide();
		});
		</script>
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/edit_notificacion.js"></script>

		
	</body>
	</html>