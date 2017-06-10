<? include("includes/tags.php") ?>
<script src="<?= URLSRC ?>js/imagesLoaded/jquery.imagesloaded.min.js"></script>
<script src="<?= URLSRC ?>js/touch-punch/jquery.touch-punch.min.js"></script>
<script src="<?= URLSRC ?>js/bootbox/jquery.bootbox.js"></script>

<!-- Custom file upload -->
<script src="<?= URLSRC ?>js/fileupload/bootstrap-fileupload.js"></script>

<?= plugin::message() ?>
<script type="text/javascript" src="<?= URLVISTA ?>admin/js/mensaje.js"></script>
<script type="text/javascript" src="<?= URLVISTA ?>admin/js/edit_empresa.js"></script>

<script type="text/javascript">

var urlbase    = '<?= URLBASE ?>';
var urlvista   = '<?= URLVISTA ?>';
var identificador = '<?= nvl($reg['id_empresa']) ?>';

var mensaje = '<?= nvl($mensaje) ?>';
var mensaje_tipo = '<?= nvl($mensaje_tipo, 'success') ?>'

//nombre='<?= nvl($reg['nombre']) ?>';
borrar=0;
$(document).ready(function(){
	cambiar_dominio('t<?=nvl($reg['tipodominio'],'sub')?>');
	activar_pago('payu');
	activar_pago('otro');
	activar_puntos();

	<? if($_SESSION['id_tipo_usuario']==2){?>
checkWeb();
	<? } ?>

});
</script>
</head>
<body data-mobile-sidebar="button">
	<? include("includes/header.php")?>
	<div class="container-fluid" id="content">
		<? include("includes/menu.php")?>
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1><?=$tarea?> Empresa</h1>
					</div>

				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="login-inicio">Inicio</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="javascript:;"><?=($_SESSION['id_tipo_usuario']==2) ? '<a href="empresa-list_empresas">Empresas</a>':'Configuración'?></a>

						</li>

					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
                    <form class="form-vertical" action="" method="post" enctype="multipart/form-data" name="form1" id="form_content">
        <input type="hidden" name="id" value="<? pv($reg['id_empresa']) ?>" />
		<? if($_SESSION['id_tipo_usuario']==2){?>
                  	<div class="box">
							<div class="box-title">
								<h3>Perfil del Administrador:</h3>
							</div>
							<div class="box-content">
								 <input type="hidden" name="id_usuario" value="<? pv($usu['id_usuario']) ?>" />
									<div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="usuario" class="control-label">Dirección de Correo Electrónico (se usará como nombre de usuario):  </label>
												<div class="controls controls-row">
													<input placeholder="Email:" class="input-block-level" name="usu[_username]" type="text" id="usuario" value="<? pv($usu['_username']) ?>" data-rule-email="true" data-rule-required="true" data-rule-remote="usuario-validarxid-id-<?=nvl($usu['id_usuario'],0)?>-t-usu-tipo-4" />
												</div>
											</div>
										</div>
                                        </div>

                                        <div class="row-fluid">
										<? if(nvl($reg['id_empresa'],0)){?>
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
                                        <? }?>
										<div class="span6">
											<div class="control-group">
												<label for="descripcion" class="control-label">Contraseña: </label>
												<div class="controls controls-row">
													<input placeholder="Contraseña:" class="input-block-level  complexify-me" name="usu[_password]" type="password" id="contrasena1" />
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


   <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
                                            <input type="hidden" id="id_tipo_usuario" name="usu[id_tipo_usuario]" value="<?=nvl($usu['id_tipo_usuario'],4)?>" />
												<label for="elpass" class="control-label">Estado: </label>
												<div class="controls controls-row">
												 <select name="dat[estado]" id="estado"class="input-block-level" >
                                               <option value="Activo" <?= (nvl($reg['estado'])=='Activo') ? 'selected="selected"':'' ?> >Activo</option>
                                               <option value="Inactivo" <?= (nvl($reg['estado'])=='Inactivo') ? 'selected="selected"':'' ?> >Inactivo</option>
                                               </select>
												</div>
											</div>
										</div>
                                        </div>


                                        <div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="nombre" class="control-label">Nombre</label>
												<div class="controls controls-row">
													<input type="text" placeholder="Nombre:" class="input-block-level" name="per[nombre]" id="nombre" value="<?= nvl($usu['nombre']) ?>"  data-rule-required="true"/>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="apellidos" class="control-label">Apellidos</label>
												<div class="controls controls-row">
													<input type="text"  placeholder="Apellidos:" class="input-block-level" name="per[apellidos]" id="apellidos" value="<?= nvl($usu['apellidos']) ?>" />
												</div>
											</div>
										</div>
									</div>

                                    <div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="nombre" class="control-label">Teléfono Fijo: </label>
												<div class="controls controls-row">
													<input type="text" placeholder="Teléfono fijo:" class="input-block-level" name="per[telefono]" id="telefono" value="<?= nvl($usu['telefono']) ?>" />
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="slogan" class="control-label">Teléfono Móvil</label>
												<div class="controls controls-row">
													<input type="text" placeholder="Móvil:" class="input-block-level" name="per[movil]" id="movil" value="<?= nvl($usu['movil']) ?>" />
												</div>
											</div>
										</div>
									</div>

                                    <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="direccion" class="control-label">Dirección</label>
												<div class="controls controls-row">
													<textarea  placeholder="Dirección:" class="input-block-level" name="per[direccion]" id="direccion"><?= nvl($usu['direccion']) ?></textarea>	</div>
											</div>
										</div>
									</div>

                                     </div>


                                </div>

                        <? }?>


						<div class="box">
							<div class="box-title">
								<h3>Sitio Web</h3>
								<? if($_SESSION['id_tipo_usuario']==2){?>
									<div class="actions">
										<input type="checkbox" <?=(nvl($reg['web'])!='0') ? 'checked="checked"':''?> style="margin:0 5px 6px 5px;" name="dat[web]" id="web" value="1" onChange="checkWeb()"/> Sitio Web Activo
									</div>
									<? }?>
							</div>
							<div class="box-content" id="box_web">
                            <div class="row-fluid">
										<div class="span12">
											<input type="hidden" name="dom[tipodominio]" value="<?=nvl($reg['tipodominio'])?>"/>
											<span style="margin-right:20px">Subdominio (subdominio.oferto.co) <input type="radio" name="dat[tipodominio]" id="tiposub" value="sub" onChange="cambiar_dominio('tsub')" <?=(nvl($reg['tipodominio'],'sub')=='sub') ? 'checked':''?>/></span>
                                            Dominio Propio <input type="radio" name="dat[tipodominio]" id="tipodom" value="dom" onChange="cambiar_dominio('tdom')" <?=(nvl($reg['tipodominio'],'sub')=='dom') ? 'checked':''?>/>
										</div>
                                        </div>

                            <div class="row-fluid tipodominio" id="row_tsub">
										<div class="span12">
											<div class="control-group">
												<label for="titulo" class="control-label">Subdominio</label>
												<div class="controls controls-row" style="position:relative">
													<input type="hidden" name="dom[subdominio]" value="<?=nvl($reg['subdominio'])?>"/>
													<span id="tt_oferto" style="position:absolute;padding:6px 0; left:83px; color:#999; width:70px;">.oferto.co</span><input type="text" name="dat[subdominio]" id="subdominio" placeholder="subdominio" class="input-block-level" value="<?= nvl($reg['subdominio']) ?>" style="padding-right:65px;" data-rule-remote="empresa-validar_subdominio-id-<?=$reg['id_empresa'] ?>" data-msg-remote="El subdominio ya está en uso"/>
												</div>
											</div>
										</div>

                                        </div>

                                <div class="row-fluid tipodominio" id="row_tdom">
										<div class="span12">
											<div class="control-group">
												<label for="titulo" class="control-label">Dominio</label>
												<div class="controls controls-row">
													<input type="hidden" name="dom[dominio]" value="<?=nvl($reg['dominio'])?>"/>
													<input type="text" data-rule-dominio="true"  name="dat[dominio]" id="dominio" placeholder="Dominio" class="input-block-level" value="<?= nvl($reg['dominio']) ?>" data-rule-required="true" data-rule-remote="empresa-validar_dominio-id-<?=$reg['id_empresa'] ?>" data-msg-remote="El dominio ya está en uso" />
												</div>
											</div>
										</div>
                                        </div>

									<div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="titulo" class="control-label">Título del sitio</label>
												<div class="controls controls-row">
													<input type="text" name="dat[titulo]" id="titulo" placeholder="Titulo" class="input-block-level" value="<?= nvl($reg['titulo']) ?>" data-rule-required="true">
												</div>
											</div>
										</div>
                                        </div>
                                        <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="descripcion" class="control-label">Corta descripción del sitio</label>
												<div class="controls controls-row">
													<textarea  name="dat[descripcion]" id="descripcion"  placeholder="Descripcion" class="input-block-level" ><?= nvl($reg['descripcion']) ?></textarea>
												</div>
											</div>
										</div>


									</div>

									<div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="titulo" class="control-label">Color de la plantilla</label>
												<div class="controls controls-row">
													<select name="dat[color]" id="color" class="input-block-level" ><?= nvl($color) ?></select>
												</div>
											</div>
										</div>
                                        </div>
									<!--div class="row-fluid">
										<div class="span3">
											<div class="control-group" >
                                               <label class="control-label" for="input01">Calcurar Impuestos : </label>
                                            <div class="controls">
                                               No <input name="dat[impuesto]" type="radio" class="" id="impuesto_no" <?=(nvl($reg['impuesto']) !='Si') ? 'checked="checked"':''?>  onchange="verPorcentaje()" value="no"/>&nbsp;&nbsp;
                                                Si <input name="dat[impuesto]" type="radio" class="" id="impuesto_si"  <?=(nvl($reg['impuesto'])=='Si') ? 'checked="checked"':''?> onChange="verPorcentaje()" value="Si" />
                                            </div>
                                         </div>
										</div>

                                        <div class="span9"  id="cporcentaje">
											<div class="control-group">
												<label for="impuesto_porcentaje" class="control-label">Porcentaje de Impuestos: </label>
												<div class="controls controls-row">
													<input type="text" name="dat[impuesto_porcentaje]" id="impuesto_porcentaje" placeholder="% Impuestos" class="input-block-level" value="<? pv($reg['impuesto_porcentaje']) ?>">
												</div>
											</div>
										</div>
                                        </div-->

                                       </div>

							<div class="box-title">
								<h3>Datos de la Empresa</h3>
							</div>
							<div class="box-content">
                                        <div class="row-fluid">
										<div class="span4">
											<div class="control-group">
												<label for="nombre" class="control-label">Nombre</label>
												<div class="controls controls-row">
													<input type="text" name="dat[nombre]" id="nombre" value="<? pv($reg['nombre']) ?>" placeholder="Nombre" class="input-block-level">
												</div>
											</div>
										</div>
										<div class="span8">
											<div class="control-group">
												<label for="slogan" class="control-label">Slogan</label>
												<div class="controls controls-row">
													<input type="text" name="dat[slogan]" id="slogan" value="<? pv($reg['slogan']) ?>" placeholder="Slogan" class="input-block-level">
												</div>
											</div>
										</div>
									</div>
                                    <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="descripcion" class="control-label">Descripción de su empresa</label>
												<div class="controls controls-row">
													<textarea name="dat[descripcion_empresa]" id="descripcion_empresa" class="input-block-level"><?=nvl($reg['descripcion_empresa'])?></textarea>
												</div>
											</div>
										</div>

									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="categoria" class="control-label">Categoría de la Tienda</label>
												<div class="controls controls-row">
													<input type="hidden" id="id_categoria" name="id_categoria" value="<?=nvl($reg['id_categoria'])?>" />
													<select name="dat[id_categoria]" id="categoria" class="input-block-level">
                                                    <option value="0" >Seleccione una categoría</option>
                                                    <?=nvl($categorias)?>
                                                    </select>
												</div>
											</div>
										</div>

										<div class="span6">
											<div class="control-group">
												<label for="slogan" class="control-label"><span rel="tooltip" title="" data-original-title="REEMPLAZA LA PALABRA 'PRODUCTOS' EN LA VISTA DEL SITIO WEB"><i class="glyphicon-circle_question_mark"></i></span> Alias "Productos"</label>
												<div class="controls controls-row">
													<input type="text" name="dat[alias_productos]" id="alias_productos" value="<? pv($reg['alias_productos']) ?>" placeholder="Alias" class="input-block-level">
												</div>
											</div>
										</div>

									</div>

                                    <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
											<label for="archivo" class="control-label">Logo de la tienda (400px de ancho x 160px de alto)</label>
                                            <input type="hidden" name="delimg" id="delimg" value="0"/>
											<div class="controls">
												<div class="fileupload fileupload-<?=(nvl($reg['logo'])!='') ?'exists':'new'?>" data-provides="fileupload">
													<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?=URLVISTA?>admin/img/noimage.gif" /></div>
													<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                                    <?=(nvl($reg['logo'])!='') ?'<img src="'.URLFILES.'empresas/s'.$reg['logo'].'" />':''?>
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

                                     </div>

							<div class="box-title">
								<h3>Datos de contacto</h3>
							</div>
							<div class="box-content">



									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="email" class="control-label">Email</label>
												<div class="controls controls-row">
													<input type="text" name="dat[email]" id="email" value="<?php pv($reg['email']) ?>" placeholder="Email" class="input-block-level">
												</div>
											</div>
										</div>


										<div class="span6">
											<div class="control-group">
												<label for="direccion" class="control-label">Dirección</label>
												<div class="controls controls-row">
													<input type="text" name="dat[direccion]" id="direccion" value="<?php pv($reg['direccion']) ?>" placeholder="Dirección" class="input-block-level">
												</div>
											</div>
										</div>

									</div>
                                    <div class="row-fluid">
										<div class="span4">
											<div class="control-group">
												<label for="telefono" class="control-label">Teléfono Principal</label>
												<div class="controls controls-row">
													<input type="text" name="dat[telefono]" id="telefono" value="<?php pv($reg['telefono']) ?>" placeholder="Teléfono" class="input-block-level">
												</div>
											</div>
										</div>

										<div class="span4">
											<div class="control-group">
												<label for="telefono2" class="control-label">Teléfono 2</label>
												<div class="controls controls-row">
													<input type="text" name="dat[telefono2]" id="telefono2" value="<?php pv($reg['telefono2']) ?>" placeholder="Teléfono 2" class="input-block-level">
												</div>
											</div>
										</div>

										<div class="span4">
											<div class="control-group">
												<label for="telefono3" class="control-label">Teléfono 3</label>
												<div class="controls controls-row">
													<input type="text" name="dat[telefono3]" id="telefono3" value="<?php pv($reg['telefono3']) ?>" placeholder="Teléfono 3" class="input-block-level">
												</div>
											</div>
										</div>



									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="movil" class="control-label">Móvil</label>
												<div class="controls controls-row">
													<input type="text" name="dat[movil]" id="movil" value="<?php pv($reg['movil']) ?>" placeholder="Móvil" class="input-block-level">
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="skype" class="control-label">Skype</label>
												<div class="controls controls-row">
													<input type="text" name="dat[skype]" id="skype" value="<?php pv($reg['skype']) ?>" placeholder="Skype" class="input-block-level">
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
										<div class="span6">
											<div class="control-group">
												<label for="facebook" class="control-label">Facebook (Página)</label>
												<div class="controls controls-row">
													<input type="text" name="dat[facebook]" data-rule-url="true" id="facebook" value="<? pv($reg['facebook']) ?>" placeholder="Facebook" class="input-block-level">
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="twitter" class="control-label">Twitter</label>
												<div class="controls controls-row">
													<input type="text" name="dat[twitter]"  data-rule-url="true" id="twitter" value="<? pv($reg['twitter']) ?>" placeholder="Twitter" class="input-block-level">
												</div>
											</div>
										</div>
									</div>

                                    <div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="youtube" class="control-label">Youtube</label>
												<div class="controls controls-row">
													<input type="text" name="dat[youtube]"  data-rule-url="true" id="youtube" value="<? pv($reg['youtube']) ?>" placeholder="Youtube" class="input-block-level">
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="linkedin" class="control-label">Linkedin</label>
												<div class="controls controls-row">
													<input type="text" name="dat[linkedin]"  data-rule-url="true" id="linkedin" value="<? pv($reg['linkedin']) ?>" placeholder="Linkedin" class="input-block-level">
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="wtwitter" class="control-label">Widget Twitter. Muestra los ultimos tweets de una cuenta de twitter, puede  crear y obtener el código <a href="https://twitter.com/settings/widgets" target="_blank">aquí</a>.</label>
												<div class="controls controls-row">
													<textarea name="dat[wtwitter]" id="wtwitter" placeholder="Widget Twitter" class="input-block-level"><? pv($reg['wtwitter']) ?></textarea>
												</div>
											</div>
										</div>
									</div>

                                    </div>

                                    <div class="box">
							<div class="box-title">
								<h3>Formas de pago</h3>
							</div>
							<div class="box-content">

								<div class="row-fluid">
									<div class="span12">
										<div class="control-group">
											<div class="controls controls-row">
												Generar código de descuento <input type="checkbox" name="dat[codigo_activo]" id="codigo_activo" value="1" <?=(nvl($reg['codigo_activo'],'0')=='1') ? 'checked':''?> />
											</div>
										</div>
									</div>
								</div>

								<div class="row-fluid">
									<div class="span12">
										<div class="control-group">
											<div class="controls controls-row">
												Fidelización por puntos <input type="checkbox" name="dat[puntos_activo]" id="puntos_activo" value="1" onChange="activar_puntos()" <?=(nvl($reg['puntos_activo'],'0')=='1') ? 'checked':''?> />
											</div>
										</div>
									</div>
								</div>
								<div id="datos_puntos">
									<div class="row-fluid">
										<div class="span12">
											<div class="span12">
												<div class="control-group">
													<label class="control-label" for="input01">Puntos otorgados por cada $1.000 pesos de compra: </label>
													<div class="controls controls-row">
														<input name="dat[puntos_unidad]" placeholder="Puntos otorgados" type="text" id="puntos_unidad" class="input-block-level" data-rule-required="true" value="<?= (nvl($reg['puntos_unidad'],0)!=0) ? $reg['puntos_unidad']:'' ?>" />
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="row-fluid">
									<div class="span6">
										<div class="row-fluid">
											<div class="span12">
												<div class="control-group">
													<div class="controls controls-row">
													Pago PayU <input type="checkbox" name="dat[pago_payu]" id="pago_payu" value="1" onChange="activar_pago('payu')" <?=(nvl($reg['pago_payu'],'0')=='1') ? 'checked':''?> />
													</div>
												</div>
											</div>
										</div>

									<div id="datos_payu">
										<p>Si no conoce los datos solicitados a continuación, <a href="http://docs.payulatam.com/manual-integracion-web-checkout/informacion-adicional/" target="_blank">haga clic aquí</a>.</p>
										<div class="row-fluid">
											<div class="span12">
												<div class="control-group">
													<label class="control-label" for="input01">Id Comercio (Merchant Id): </label>
													<div class="controls controls-row">
														<input name="dat[payu_userid]" placeholder="Id comercio" type="text" id="payu_userid" class="input-block-level" value="<?= nvl($reg['payu_userid']) ?>" />
													</div>
												</div>
											</div>
										</div>
										<div class="row-fluid">
											<div class="span12">
												<div class="control-group">
													<label class="control-label" for="input01">ApiKey (Campo único por cada comercio afiliado a PAYU): </label>
													<div class="controls controls-row">
														<input name="dat[payu_llave]" placeholder="ApiKey" type="text" id="payu_llave" class="input-block-level" value="<?= nvl($reg['payu_llave']) ?>" />
													</div>
												</div>
											</div>
										</div>
										<div class="row-fluid">
											<div class="span12">
												<div class="control-group">
													<label class="control-label" for="input01">Id de cuenta (AccountId): </label>
													<div class="controls controls-row">
													<input name="dat[payu_accountid]" placeholder="Id cuenta" type="text" id="payu_accountid" class="input-block-level" value="<?= nvl($reg['payu_accountid']) ?>" />
													</div>
												</div>
											</div>
										</div>
										<div class="row-fluid">
											<div class="span12">
												<label class="control-label" for="input01">Prueba (Se hace una simulación del proceso pero no se realiza ninguna transacción): </label>
												<span style="margin-right:20px">
													Si <input type="radio" name="dat[payu_test]" id="payu_testsi" value="1" <?=(nvl($reg['payu_test'],0)==1) ? 'checked':''?>/>
												</span>
												No <input type="radio" name="dat[payu_test]" id="payu_testno" value="0" <?=(nvl($reg['payu_test'],0)!=1) ? 'checked':''?>/>
											</div>
										</div>
									</div>
									</div>

									<div class="span6">
										<div class="row-fluid">
											<div class="span12">
												<div class="control-group">
													<div class="controls controls-row">
													Otras formas de pago <input type="checkbox" name="dat[pago_otro]" id="pago_otro" value="1" onChange="activar_pago('otro')" <?=(nvl($reg['pago_otro'],'0')=='1' or nvl($reg['pago_payu'],'0')==0) ? 'checked':''?>    />
													</div>
												</div>
											</div>
										</div>
										<div id="datos_otro">
											<p>Agrege descripción detallada de la forma de pago alternativa.</p>
											<div class="row-fluid">
												<div class="span12">
													<div class="control-group">
														<label class="control-label" for="input01"> </label>
														<div class="controls controls-row">
															<textarea rows="10" name="dat[otro_descripcion]" placeholder="Descripción" type="text" class="input-block-level" id="otro_descripcion"><?= nvl($reg['otro_descripcion']) ?></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<input type="hidden" name="dat[fecha_registro]" value="<?=(nvl($reg['fecha_registro'],'0000-00-00 00:00:00')=='0000-00-00 00:00:00') ? date('Y-m-d h:i:s'):$reg['fecha_registro'] ?>" />
							<div class="form-actions">
								<button type="submit" class="btn btn-primary">Guardar cambios</button>
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
	<script src="<?= URLSRC ?>js/ckeditor/ckeditor.js"></script>
	<script src="<?= URLSRC ?>js/complexify/jquery.complexify-banlist.min.js"></script>
	<script src="<?= URLSRC ?>js/complexify/jquery.complexify.min.js"></script>
</body>

</html>
