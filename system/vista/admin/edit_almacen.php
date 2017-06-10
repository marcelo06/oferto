<? include("includes/tags.php") ?>
<?= plugin::message() ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>


<script type="text/javascript">

longitud_ini='<?= nvl($reg['longitud']) ?>';
latitud_ini='<?= nvl($reg['latitud']) ?>';
zoommapa=<?= (nvl($reg['latitud'])!='') ? 15:6?>;

</script>


</head>

<body data-mobile-sidebar="button">
	<? include("includes/header.php") ?>
	<div class="container-fluid" id="content">
		<? include("includes/menu.php") ?>
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1><?=$tarea?> Almacén</h1>
					</div>

				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="login-inicio">Inicio</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="almacen-lista">Lista de Almacenes</a>

						</li>
                        <li>
							<a href="javascript:;"><?=$tarea?> Almacén</a>

						</li>

					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
                    <form class='form-vertical form-validate' action="" method="post" enctype="multipart/form-data" name="form1" id="form_content">
                     <input type="hidden" name="id_almacen" value="<?= nvl($reg['id_almacen']) ?>" />
                      <input type="hidden" name="dat[id_empresa]" id="id_empresa"  value="<?= nvl($reg['id_empresa'],$_SESSION['id_empresa']) ?>"  />
                      <div class="box">
						
							<div class="box-content">
                            
                            
                                        
                               <div class="row-fluid">
                               	 <div class="span6">
                                 <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                    <label for="archivo" class="control-label">Imagen Principal (750px ancho x 570px alto)</label>
                                    <input type="hidden" name="delimg" id="delimg" value="0"/>
                                    <div class="controls">
                                        <div class="fileupload fileupload-<?=(nvl($reg['imagen'])!='') ?'exists':'new'?>" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 110px; height: 81px;"><img src="<?=URLVISTA?>admin/img/noimage.gif" /></div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 110px; max-height: 81px; line-height: 20px;">
                                            <?=(nvl($reg['imagen'])!='') ?'<img src="'.URLFILES.'almacenes/m'.$reg['imagen'].'" />':''?>
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
												<label for="nombre" class="control-label">Nombre: </label>
												<div class="controls controls-row">
                                              
													<input type="text" placeholder="Nombre:" class="input-block-level" name="dat[nombre]" id="nombre" value="<?=nvl($reg['nombre'])?>" data-rule-required="true"  />
                                               </div>
											</div>
										</div>
                                    </div> 
                                   
                                   <div class="row-fluid">
                                         <div class="span12">
											<div class="control-group">
												<label for="direccion" class="control-label">Dirección: </label>
												<div class="controls controls-row">
                                              
													<input type="text" placeholder="Dirección:" class="input-block-level" name="dat[direccion]" id="direccion" value="<?=nvl($reg['direccion'])?>" />
                                               </div>
											</div>
										</div>
                                    </div>
                                    
                                   <div class="row-fluid">
                                         <div class="span6">
											<div class="control-group">
												<label for="telefono" class="control-label">Teléfono: </label>
												<div class="controls controls-row">
                                              
													<input type="text" placeholder="Teléfono:" class="input-block-level" name="dat[telefono]" id="telefono" value="<?=nvl($reg['telefono'])?>"  />
                                               </div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="telefono" class="control-label">Móvil: </label>
												<div class="controls controls-row">
                                              
													<input type="text" placeholder="Móvil:" class="input-block-level" name="dat[movil]" id="movil" value="<?=nvl($reg['movil'])?>"  />
                                               </div>
											</div>
										</div>
                                    </div> 
                                    <div class="row-fluid">
                                         <div class="span4">
                                    Latitud: <input name="dat[latitud]" readonly id="latitud" type="text" class="span13t" value="<?php pv($reg['latitud']) ?>" />
                    
										</div>
                                         <div class="span4">
										
                                   
                     Longitud: <input name="dat[longitud]" id="longitud" readonly type="text" class="span13t" value="<?php pv($reg['longitud']) ?>" />
                                  
										</div>
										<div class="span4">
															
										              
										Ubicación: <input  name="dat[ubicacion]"  id="ubicacion" readonly type="text" class="span13t" value="<?php pv($reg['ubicacion']) ?>" />
										    <input type="hidden"  name="dat[id_pais]"  id="id_pais" value="<?php pv($reg['id_pais']) ?>" />
										    <input type="hidden"  name="dat[id_dpto]"  id="id_dpto" value="<?php pv($reg['id_dpto']) ?>" />
										    <input type="hidden"  name="dat[id_ciudad]"  id="id_ciudad" value="<?php pv($reg['id_ciudad']) ?>" />        
										</div>
                                    </div>   
                               	 </div>
                              
                               	 <div class="span6">
                                 <div class="row-fluid">
                                         <div class="span12">
											<div class="control-group">
                                    <label class="control-label">De click en la ubicación del almacén: </label>
                                    <div class="controls controls-row">
                                   <div id="map_canvas" class="inputl" style="width:100%; height:420px"></div>
                                   </div>
                                </div>
										</div>
                                    </div>
     
                                    
                                
                               	 </div>
                                </div>         
                          </div>
	
								<div class="form-actions">
										<button type="submit" class="btn btn-primary">Guardar </button>
										<button type="button" class="btn" onClick="location = 'almacen-lista'">Cancelar</button>
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
        <script src="<?= URLSRC ?>js/imagesLoaded/jquery.imagesloaded.min.js"></script>
        <script src="<?=URLSRC?>js/touch-punch/jquery.touch-punch.min.js"></script>
		<script src="<?=URLSRC?>js/bootbox/jquery.bootbox.js"></script>
        <!-- Custom file upload -->
		<script src="<?=URLSRC?>js/fileupload/bootstrap-fileupload.js"></script>
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/mapa_almacenes.js"></script>
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/edit_almacen.js"></script>
	
		<script type="text/javascript">
		 var identificador = '<?= nvl($reg['id_contenido']) ?>';
		
		var mensaje = '<?= nvl($mensaje) ?>';
		var mensaje_tipo = '<?= nvl($mensaje_tipo, 'success') ?>'

		var urlbase    = '<?= URLBASE ?>';
		var urlvista   = '<?= URLVISTA ?>';

		</script>
	</body>
</html>