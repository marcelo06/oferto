<? include("includes/tags.php") ?>
</head>
<body data-mobile-sidebar="button"  ><!--onLoad="localizame()"-->
	<? include("includes/header.php") ?>
	<div class="container-fluid" id="content">
		<? include("includes/menu.php") ?>
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>Configuración del Sitio:</h1>
					</div>

				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="login-inicio">Inicio</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="javascript:;">Configuración del Sitio</a>

						</li>

					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
                    <form class='form-vertical form-validate' action="configsite-guardar_configuracion"  method="post" name="form"  id="form_config"  enctype="multipart/form-data">
						<div class="box">
							<div class="box-title">
								<h3>Configuración</h3>
							</div>
							<div class="box-content">
                                <div class="row-fluid">
								<div class="span6">
									<div class="control-group">
										<label for="duracion" class="control-label">Tiempo máximo de duración de una oferta (días)</label>
										<div class="controls controls-row">
											<input type="text"  placeholder="duracion" class="input-block-level" name="tipo[max_dias_oferta]" value="<?= $reg[11]['valor'] ?>" data-rule-integer="true"/>
										</div>
									</div>
								</div>
								<div class="span6">
									<div class="control-group">
										<label for="duracion" class="control-label">Orden de ofertas</label>
										<div class="controls controls-row">
												<select  class="input-block-level" name="tipo[ordenamiento]" id="ordenamiento">
													<option value="aleatorio" <?= ($reg[12]['valor']=='aleatorio') ? 'selected':''?>>Aleatorio</option>
													<option value="precio asc" <?= ($reg[12]['valor']=='precio asc') ? 'selected':''?>>Precio Ascendente</option>
													<option value="precio desc" <?= ($reg[12]['valor']=='precio desc') ? 'selected':''?>>Precio Descendente</option>
													<option value="porcentaje asc" <?= ($reg[12]['valor']=='porcentaje asc') ? 'selected':''?>>Porcentaje Ascendente </option>
													<option value="porcentaje desc" <?= ($reg[12]['valor']=='porcentaje desc') ? 'selected':''?>>Porcentaje Descendente</option>
													<option value="nombre asc"<?= ($reg[12]['valor']=='nombre asc') ? 'selected':''?>>Nombre Ascendente</option>
													<option value="nombre desc" <?= ($reg[12]['valor']=='nombre desc') ? 'selected':''?>>Nombre Descendente</option>
												</select>
										</div>
									</div>
								</div>

								

							</div>
                            </div>




							<div class="box-title">
								<h3>Tags de Sitio</h3>
							</div>
							<div class="box-content">

									<div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="titulo" class="control-label">Título</label>
												<div class="controls controls-row">
													<input placeholder="Título" class="input-block-level" name="tipo[titulo_sitio]" type="text" value="<?= $reg[0]['valor'] ?>" />
												</div>
											</div>
										</div>
                                        </div>
                                        <div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="descripcion" class="control-label">Corta descripción del sitio</label>
												<div class="controls controls-row">
													<textarea  placeholder="Corta Decripción" class="input-block-level" name="tipo[description]" ><?= $reg[2]['valor'] ?></textarea>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="keywords" class="control-label">Palabras clave</label>
												<div class="controls controls-row">
													<textarea  placeholder="keywords" class="input-block-level" name="tipo[key_words]" ><?= $reg[1]['valor'] ?></textarea>
												</div>
											</div>
										</div>

									</div>
                            </div>

							<div class="box-title">
								<h3>Redes Sociales</h3>
							</div>
							<div class="box-content">
                                        <div class="row-fluid">
										<div class="span4">
											<div class="control-group">
												<label for="nombre" class="control-label"> Vínculo Facebook:</label>
												<div class="controls controls-row">
													<input type="hidden" name="facebook" value="<?= $reg[3]['valor'] ?>"/>
													<input placeholder="Facebook" class="input-block-level" name="tipo[facebook]" type="text" value="<?= $reg[3]['valor'] ?>" />
												</div>
											</div>
										</div>
										<div class="span4">
											<div class="control-group">
												<label for="slogan" class="control-label"> Vínculo Twitter:</label>
												<div class="controls controls-row">
													<input type="hidden" name="twitter" value="<?= $reg[4]['valor'] ?>"/>
													<input placeholder="Twitter" class="input-block-level" name="tipo[twitter]" type="text" value="<?= $reg[4]['valor'] ?>" />
												</div>
											</div>
										</div>
                                       <div class="span4">
											<div class="control-group">
												<label for="slogan" class="control-label"> Vínculo Youtube:</label>
												<div class="controls controls-row">
													<input type="hidden" name="youtube" value="<?= $reg[7]['valor'] ?>"/>
													<input placeholder="Youtube" class="input-block-level" name="tipo[youtube]" type="text" value="<?= $reg[7]['valor'] ?>" />
												</div>
											</div>
										</div>
									</div>

<div class="row-fluid">
                             
                                        </div>
                                        
                                        

                                     </div>

							<div class="box-title">
								<h3>Información de Contacto</h3>
							</div>
							<div class="box-content">
                            
                  
                   <!--div class="row-fluid">
                   <div class="span6"-->
                   <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label for="titulo" class="control-label">Email</label>
                                        <div class="controls controls-row">
                                            <input placeholder="Email" class="input-block-level" name="tipo[email]" type="text" id="email" value="<?= $reg[5]['valor'] ?>"  data-rule-email="true" data-rule-required="true"/>
                                        </div>
                                    </div>
                                </div>
                   </div>
                    <div class="row-fluid">
								<div class="span12">
                                    <div class="control-group">
                                        <label for="descripcion" class="control-label"> Teléfonos </label>
                                        <div class="controls controls-row">
                                         <input type="text"  placeholder="Teléfonos" class="input-block-level" name="tipo[telefono]" id="telefonos" rows="3" value="<?= $reg[7]['valor'] ?>"/>
                                        </div>
                                    </div>
                                </div>
                                </div>
                   <div class="row-fluid">
								<div class="span12">
                                    <div class="control-group">
                                        <label for="descripcion" class="control-label"> Contacto </label>
                                        <div class="controls controls-row">
                                         <textarea  placeholder="Contact Info" class="input-block-level" name="tipo[info_contacto]" id="info_contacto" rows="3"><?= $reg[6]['valor'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                
                                      
                   <!--/div>
								<div class="span6">
                                    <div class="control-group">
                                        <label for="google_maps" class="control-label"> Ubicación en Mapa </label>
                                        <div class="controls controls-row">

            <input type="hidden" name="tipo[mapa]" id="mapa" value="<?= nvl($reg[8]['valor'])?>">
            <div class="controls">
                <div id="placepicker" style="width: 98%"></div>
                <div id="map_canvas" style="width:98%; height:300px"></div>
            </div>
                                        </div>
                                    </div>
                                </div>
                                </div-->


								
                                        
                                    

<div class="row-fluid">
                             
                                        </div>
                                       
                                       
                                        <div class="form-actions">
										<button type="submit" class="btn btn-primary">Guardar</button>
										<button type="button" class="btn" onClick="location = 'login-inicio'">Cancelar</button>
									</div>
                                        

                                     </div>

								</form>
							</div>
						</div>
					</div>
				</div>

			</div>


        <? include("includes/footer.php") ?>
        <?= plugin::message() ?>
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/mensaje.js"></script>
       

		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <!--script type="text/javascript" src="<?= URLVISTA ?>admin/js/mapaconf.js"></script-->

		<script type="text/javascript">

		var latitud = <?= nvl($x, 0); ?>;
		var longitud = <?= nvl($y, 0); ?>;

		var urlbase    = '<?= URLBASE ?>';
		var urlvista   = '<?= URLVISTA ?>';
		var identificador = '<?= nvl($reg['id_empresa']) ?>';

		var mensaje = '<?= nvl($mensaje) ?>';
		var mensaje_tipo = '<?= nvl($mensaje_tipo, 'success') ?>'
		borrar=0;
		
		</script>
	</body>

	</html>

