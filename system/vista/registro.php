<? include("includes/tags.php") ?>	
<link rel="stylesheet" href="<?= URLSRC ?>smoke/smoke.css" type="text/css" media="screen" />
<link id="theme" rel="stylesheet" href="<?=URLVISTA?>css/smokedark.css" type="text/css" media="screen" />
<script src="<?= URLSRC ?>smoke/smoke.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=URLVISTA?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=URLVISTA?>js/login.js"></script>
<script type="text/javascript" src="<?=URLVISTA?>js/registro.js?v=1"></script>
<script type="text/javascript">
mensaje='';
$(document).ready(function(){
$( "#form-validate" ).validate({
             rules:{
                'dat[_username]':{ required: true,email: true, "remote":{
					url: 'usuario-validar',
					 type: "post",
					 data:{
						 email: function(){
							 return $('#form-validate :input[name="dat[_username]"]').val();
							},
							oferto:1
						}
					}
								 },
				'dat[_password]': {required: true,minlength: 5},
				'contra': {required: true, equalTo: "#pass"},
             },
             messages:{
                 'dat[_username]': {remote: $.validator.format("{0} ya está en uso.")},
				 'dat[_password]': {minlength: "Al menos 5 caracteres"},
				 'contra': {equalTo: "Los campos no coinciden"}
             }
});
});
</script>
</head>
<body>
<? include("includes/header.php") ?>	
<div class="areaHead auto_margin">
	<div class="guia"><a href="">INICIO</a> / INGRESO - REGISTRO /</div>
	
</div>



<section id="Main">
	<div class="areaCats auto_margin">
	<div class="regPadding">
		<div class="row">
			<div class="col-sm-12">

				<div class="height5"></div>
				
				<div class="container-fluid">	
					<div class="col-sm-6">
						<div class="areaRegistro">
							<div class="spc">
								<h3>Ingresar</h3>
								<p>Si usted no tiene una cuenta con nosotros, por favor <b>CREAR UNA NUEVA.</b></p>
								<form method="post" id="form-login">
									<div class="row" id="login-form">

										<input type="hidden" name="success_url" value=""/>
										<input type="hidden" name="error_url" value=""/>
										<?=($compra) ? '<input type="hidden" name="lcompra" id="lcompra"  value="'.$compra.'" />':''?>
										<div class="alerts-inf" style="color:#FF0000"></div>
										<div class="col-xs-12">
											<span class="flabel">Usuario</span>
											<input type="text" id="user" name="user"  required class="form-control" >
										</div>
										<div class="col-xs-12">
											<span class="flabel">Contraseña</span>
											<input type="password" name="password" id="password" required class="form-control">
										</div>

										<div class="col-xs-12">
											<span class="flabel"><a href="javascript:void(0)" id="lost">Olvidó su contraseña?</a></span>
										</div>

										<div class="col-xs-12">
											<span class="blabel">
												<button type="button" onClick="validar()" id="login" class="btn btn-primary upper">Ingresar</button>
											</span>
										</div>

									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="areaRegistro">
							<div class="spc">
								<h3>Crear una Cuenta</h3>
								<p><?=($compra) ? 'Llene los siguientes datos para completar la compra':'Si usted no tiene una cuenta con nosotros, por favor <b>CREAR UNA NUEVA.</b>'?></p>

								<form action="usuario-editar" method="post" id="form-validate">
									<input type="hidden" id="proviene" name="proviene" value="<?=($compra) ? 'compra':'registro'?>"/>
									<input type="hidden" id="id_empresa" name="dat[id_empresa]"  value="0"/>
									<input type="hidden" id="clioferto" name="clioferto"  value="1"/>

									<div class="row">
										<? if($compra){ ?>
										<div class="col-xs-12">
											<label for="elpass"><span class="flabel">Crear cuenta en  Oferto.co</span></label>
											<input type="checkbox" name="elpass" id="elpass"  checked  value="on" onChange="mostrar()" >
										</div>
										<? }?>
										<div id="passc">
											<div class="col-xs-12"><span class="dlabel">Datos de Acceso</span></div>
											<input type="hidden" name="dat[id_tipo_usuario]" id="id_tipo_usuario" value="5"/>        
											<div class="col-xs-12">
												<span class="flabel">Email (Usuario) *</span>
												<input type="email" name="dat[_username]" id="usuario" value="<?=nvl($_SESSION['d_pedido']['email_pedido'])?>"  required class="form-control">
											</div>

											<div class="col-xs-6">
												<span class="flabel">Contraseña *</span>
												<input type="password" name="dat[_password]" id="pass" required class="form-control">
											</div>
											<div class="col-xs-6">
												<span class="flabel">Repetir *</span>
												<input type="password" name="contra" id="contra" required class="form-control">
											</div>
										</div>
										<div id="email_reg">
											<div class="col-xs-12">
												<span class="flabel">Email *</span>
												<input type="email" name="per[email]" id="usuario" value="<?=nvl($_SESSION['d_pedido']['email_pedido'])?>"  required class="form-control">
											</div>
										</div>


										<div class="col-xs-12"><span class="dlabel">Datos Personales </span></div>

										<div class="col-xs-12">
											<span class="flabel">Nombre Completo *</span>
											<input type="text" name="per[nombre]" id="nombre_reg" value="<?=nvl($_SESSION['d_pedido']['nombre_pedido'])?>"  required class="form-control">
										</div>
										<div class="col-xs-6">
											<span class="flabel">Teléfono</span>
											<input type="text" name="per[telefono]" id="telefono_reg" value="<?=nvl($_SESSION['d_pedido']['telefono_pedido'])?>"  class="form-control">
										</div>
										<div class="col-xs-6">
											<span class="flabel">Dirección *</span>
											<input type="text" name="per[direccion]" id="direccion_reg" value="<?=nvl($_SESSION['d_pedido']['direccion_pedido'])?>"  required class="form-control">
										</div>
										<div class="col-xs-12">
											<span class="flabel">Pais *</span>
											<select  name="per[id_pais]" id="pais_reg" onChange="localidades('dptos','pais_reg','departamento_reg')" required class="form-control" >
												<option value=""></option>
												<?=$paises?>
											 </select>
										</div>
										<div class="col-xs-6">
											<span class="flabel">Departamento *</span>
											<select name="per[id_dpto]" id="departamento_reg" onChange="localidades('ciudades','departamento_reg','ciudad_reg')"  required class="form-control">
												<option value=""></option>
											<?=$dptos?>
											 </select>
										</div>
										<div class="col-xs-6">
											<span class="flabel">Ciudad *</span>
											<select name="per[id_ciudad]" id="ciudad_reg" required class="form-control">
												<option value=""></option>
											<?=$ciudades?>
											 </select>
											
										</div>
										<p>&nbsp;</p>
										<p class="error">* Campos requeridos</p>
										<div class="col-xs-12">
											<span class="blabel">
												<button type="submit" class="btn btn-primary upper">Ingresar</button>
											</span>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>	
  </div>
<? include("includes/populares.php") ?>
<? include("includes/footer.php") ?>	
</body>
</html>