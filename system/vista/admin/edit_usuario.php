<? include("includes/tags.php")?>
<?= plugin::message() ?>
<script type="text/javascript" src="<?= URLVISTA ?>admin/js/mensaje.js"></script>
<script type="text/javascript">
  
var urlbase    = '<?= URLBASE ?>';
var urlvista   = '<?= URLVISTA ?>';
var identificador = '<?= nvl($reg['id_empresa']) ?>';

var mensaje = '<?= nvl($mensaje) ?>';
var mensaje_tipo = '<?= nvl($mensaje_tipo, 'success') ?>'

function mostrar(){
    if($('#elpass:checked').val() == 'on')
    $('#passc').show();
  else
    $('#passc').hide();
}


function localidades(tipo,origen,destino){
	valor=$("#"+origen).val();
	if(tipo=='dptos')
		$("#ciudad").html('<option value=""></option>');
	$.post('usuario-select_localidad',{tipo:tipo, valor:valor},function(data){
		if(data){
			$("#"+destino).html('<option value=""></option>'+data);
		}
	})
}
$(document).ready(function(){
$.validator.addMethod("passwordCheck", function (value, element) {
	return $(element).parent().find(".progress .bar").hasClass("bar-green");
    }, 'La contraseña no es segura');

validacion=$("#edit_usuario").validate({
	errorElement:"span",
	errorClass:"help-block error",
	errorPlacement:function(e,t){t.parents(".controls").append(e)},
	highlight:function(e){$(e).closest(".control-group").removeClass("error success").addClass("error")},
	success:function(e){e.addClass("valid").closest(".control-group").removeClass("error success").addClass("success")},
	rules: {
            'dat[_password]': {
                passwordCheck: true
            }
        }
});

});


</script>
</head>
<body data-mobile-sidebar="button">
	<? include("includes/header.php")?>
	<div class="container-fluid" id="content">
		<? include("includes/menu.php") ?>
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>Configuración de usuario</h1>
					</div>
					
				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="login-inicio">Inicio</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="javascript:;">Configuración</a>
							
						</li>
						
					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
                    <form class='form-vertical ' action="" method="post" enctype="multipart/form-data" name="edit_usuario" id="edit_usuario" >
                    <input type="hidden" id="id_empresa" name="dat[id_empresa]" value="<?=nvl($_SESSION['id_empresa'],0) ?>" />
						<div class="box">
							<div class="box-title">
								<h3>Datos de acceso al panel:</h3>
							</div>
							<div class="box-content">
								
									<div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="usuario" class="control-label">Dirección de Correo Electrónico (se usará como nombre de usuario):  </label>
												<div class="controls controls-row">
													<input placeholder="Email:" class="input-block-level" name="dat[_username]" type="text" id="usuario" value="<? pv($reg['_username']) ?>" data-rule-email="true" data-rule-required="true" data-rule-remote="usuario-validarxid-id-<?=nvl($reg['id_usuario']) ?>-tipo-<?=nvl($reg['id_tipo_usuario']) ?>" />
												</div>
											</div>
										</div>
                                        </div>
                                        
                                        <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="elpass" class="control-label">Cambiar contraseña?: </label>
												<div class="controls controls-row">
													<input type="checkbox" class="" name="elpass" id="elpass"  value="on" onChange="mostrar()"  />
												</div>
											</div>
										</div>
                                        </div>
                                        
                                        
                                        <div class="row-fluid"  id="passc" style="display:none">
										<div class="span6">
											<div class="control-group">
												<label for="descripcion" class="control-label">Contraseña: </label>
												<div class="controls controls-row">
													<input placeholder="Contraseña:" class="input-block-level complexify-me" name="dat[_password]" type="password" id="contrasena1" />
													<span class="help-block">
														<div class="progress progress-info">
															<div class="bar bar-red" style="width: 0%"></div>
														</div>
													</span>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="contrasena2" class="control-label">Repetir contraseña: </label>
												<div class="controls controls-row">
												<input placeholder="Repetir contraseña:" class="input-block-level" name="contra" type="password" id="contrasena2" value=""  data-rule-equalTo="#contrasena1" data-rule-required="true" data-rule-minlength="5"/>
												</div>
											</div>
										</div>
										
									</div>
                                    
                       <? if(nvl($editar,0)){?>
   <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
                                            <input type="hidden" id="id_tipo_usuario" name="dat[id_tipo_usuario]" value="<?=nvl($reg['id_tipo_usuario'],5)?>" />
												<label for="elpass" class="control-label">Estado: </label>
												<div class="controls controls-row">
												 <select name="dat[estado]" id="estado"class="input-block-level" >
                                               <option value="1" <?= (nvl($reg['estado'])=='1') ? 'selected="selected"':'' ?> >Activo</option>
                                               <option value="0" <?= (nvl($reg['estado'])=='0') ? 'selected="selected"':'' ?> >Inactivo</option>
                                               </select>
												</div>
											</div>
										</div>
                                        </div>
<? }?> 
                                    
                                    
                                       </div>
                                       
                 
                     
                                     
							<div class="box-title">
								<h3>Datos personales</h3>
							</div>
							<div class="box-content">
                                        <div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="nombre" class="control-label">Nombre</label>
												<div class="controls controls-row">
													<input type="text" placeholder="Nombre:" class="input-block-level" name="per[nombre]" id="nombre" value="<?= nvl($reg['nombre']) ?>"  data-rule-required="true"/>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="apellidos" class="control-label">Apellidos</label>
												<div class="controls controls-row">
													<input type="text"  placeholder="Apellidos:" class="input-block-level" name="per[apellidos]" id="apellidos" value="<?= nvl($reg['apellidos']) ?>" />
												</div>
											</div>
										</div>
									</div>
                                    
                                    <div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="nombre" class="control-label">Teléfono Fijo: </label>
												<div class="controls controls-row">
													<input type="text" placeholder="Teléfono fijo:" class="input-block-level" name="per[telefono]" id="telefono" value="<?= nvl($reg['telefono']) ?>" />
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="slogan" class="control-label">Teléfono Móvil</label>
												<div class="controls controls-row">
													<input type="text" placeholder="Móvil:" class="input-block-level" name="per[movil]" id="movil" value="<?= nvl($reg['movil']) ?>" />
												</div>
											</div>
										</div>
									</div>
                                    
                                    <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="direccion" class="control-label">Dirección</label>
												<div class="controls controls-row">
													<textarea  placeholder="Dirección:" class="input-block-level" name="per[direccion]" id="direccion"><?= nvl($reg['direccion']) ?></textarea>	</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span4">
											<div class="control-group">
												<label for="pais" class="control-label">Pais</label>
												<div class="controls controls-row">
													<select  name="per[id_pais]" id="pais" onChange="localidades('dptos','pais','departamento')" required class="input-block-level" >
														<option value=""></option>
				                                       <?=$paises?>
				                                     </select>

												</div>
											</div>
										</div>

										<div class="span4">
											<div class="control-group">
												<label for="pais" class="control-label">Departamento</label>
												<div class="controls controls-row">
													<select  name="per[id_dpto]" id="departamento" onChange="localidades('ciudades','departamento','ciudad')" required class="input-block-level" >
														<option value=""></option>
				                                       <?=$dptos?>
				                                     </select>

												</div>
											</div>
										</div>

										<div class="span4">
											<div class="control-group">
												<label for="pais" class="control-label">Ciudad</label>
												<div class="controls controls-row">
													<select  name="per[id_ciudad]" id="ciudad" required class="input-block-level" >
														<option value=""></option>
				                                       <?=$ciudades?>
				                                     </select>

												</div>
											</div>
										</div>
									</div>
                                    
                                     </div>
                           	
							
								<div class="form-actions">
										<button type="submit" class="btn btn-primary">Guardar Cambios</button>
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
        <!-- complexify -->
	<script src="<?= URLSRC ?>js/complexify/jquery.complexify-banlist.min.js"></script>
	<script src="<?= URLSRC ?>js/complexify/jquery.complexify.min.js"></script>
	</body>

	</html>

