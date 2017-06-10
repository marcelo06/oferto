<? include("includes/tags.php") ?>
<script type="text/javascript">
mensaje='<?=nvl($mensaje) ?>';
jQuery(document).ready(function(){
jQuery( "#form-validate" ).validate({
             rules:{
                'dat[_username]':{ required: true,email: true, "remote":{url: 'usuario-validarxid',
																		 type: "post",
																		 data:{
																			 email: function(){
																				 return jQuery('#form-validate :input[name="dat[_username]"]').val();
																				}
																			}
																		}
								 },
				'dat[_password]': {required: true,minlength: 5},
				'contra': {required: true, equalTo: "#pass"},
             },
             messages:{
                 'dat[_username]': {remote: jQuery.validator.format("{0} ya está en uso.")},
				 'dat[_password]': {minlength: "Al menos 5 caracteres"},
				 'contra': {equalTo: "Los campos no coinciden"}
             }
});
});
</script>
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/js/registro.js?v=1"></script>
</head>
<body class="customer-account-create">
<div class="wrapper">
        
    <div class="page">

<!-- HEADER BOF -->
<? include("includes/header.php") ?>
        <div class="main-container col1-layout">
            <div class="main row clearfix">
                <!-- breadcrumbs BOF -->
<!-- breadcrumbs EOF -->
                <div class="col-main">
                                        
<div class="account-create" style="width:350px;">
    <div class="block block-login">
        <div class="block-title">
            <strong><span>Actualizar información</span></strong>
        </div>
        
        <div class="block-content">
                        
            <form action="" method="post" id="form-validate">
                  
                    <input type="hidden" name="dat[id_tipo_usuario]"  id="id_tipo_usuario" value="<?=$reg['id_tipo_usuario']?>"/>
                    
                    <div class="alerts-reg" style="color:#FF0000"></div>
                    <ul class="form-list">
                    
                     
   <li class="fields">
                            <div class="customer-name">
    <div class="field name-firstname">
        <label for="firstname" class="required"><em>*</em>Email (Usuario)</label>
        <div class="input-box">
            <input type="email" name="dat[_username]" id="usuario"  value="<?=$reg['_username']?>" maxlength="255" class="input-text" required  />
        </div>
    </div>
    
</div>
                        </li>
                        
                         <li class="control">
                            <div class="input-box">
                                <input name="elpass" id="elpass" type="checkbox"  value="on" onChange="mostrar()"   class="checkbox"/>
                            </div>
                            <label for="is_subscribed">Cambiar contraseña</label>
                        </li>
                        
                         <div id="passc" style="display:none; clear:both">
                        <li class="fields">
                            <div class="field">
                                <label for="password" class="required"><em>*</em>Contraseña</label>

                                <div class="input-box">
                                    <input type="password" name="dat[_password]" id="pass" class="input-text" required/>
                                </div>
                            </div>
                            <div class="field">
                                <label for="confirmation"
                                       class="required"><em>*</em>Repetir contraseña</label>

                                <div class="input-box">
                                    <input type="password" name="contra"
                                           id="contra"
                                           class="input-text required-entry" required/>
                                </div>
                            </div>
                        </li>
                        </div>
                   
                    
                    <h2 class="legend">Datos personales</h2>
                    <ul class="form-list">
                     
                        <li class="fields">
                            <div class="field">
                                <label for="nombre" class="required"><em>*</em>Nombre completo </label>
                                <div class="input-box">
                                    <input type="text" name="per[nombre]" id="nombre_reg" class="input-text" value="<?=$reg['nombre']?>" required/>
                                </div>
                            </div>
                            
                        </li>
                        
                        <li class="fields">
                            <div class="field">
                                <label for="telefono" class="required">Teléfono </label>
                                <div class="input-box">
                                    <input type="text" name="per[telefono]" id="telefono_reg" class="input-text" value="<?=$reg['telefono']?>"/>
                                </div>
                            </div>
                            
                        </li>
                        
                        <li class="fields">
                            <div class="field">
                                <label for="direccion" class="required"><em>*</em>Direción </label>
                                <div class="input-box">
                                    <input type="text" name="per[direccion]" id="direccion_reg"  class="input-text" value="<?=$reg['direccion']?>" required/>
                                </div>
                            </div>
                            
                        </li>
                        
                        <li class="fields">
                            <div class="field">
                                <label for="pais" class="required"><em>*</em>País</label>
                                <div class="input-box">
                                    <select  name="per[id_pais]" id="pais_reg" onChange="localidades('dptos','pais_reg','departamento_reg')" required class="input-text" >
                                        <option value=""></option>
                                       <?=$paises?>
                                     </select>
                                 </div>
                            </div>
                            
                        </li>
                        
                        <li class="fields">
                            <div class="field">
                                <label for="departamento" class="required"><em>*</em>Departamento </label>
                                <div class="input-box">
                                    <select name="per[id_dpto]" id="departamento_reg" onChange="localidades('ciudades','departamento_reg','ciudad_reg')"  required class="input-text">
                                    <option value=""></option>
                                    <?=$dptos?>
                                     </select>
                                </div>
                            </div>
                            
                        </li>
                        
                        <li class="fields">
                            <div class="field">
                                <label for="ciudad" class="required"><em>*</em>Ciudad </label>
                                <div class="input-box">
                                    <select name="per[id_ciudad]" id="ciudad_reg" required class="input-text">
                                        <option value=""></option>
                                        <?=$ciudades?>
                                     </select>
                                </div>
                            </div>
                            
                        </li>
                       </ul>
                    


                <div class="buttons-set">
                    <p class="required">* Campos requeridos</p>

                    <button type="submit" title="Enviar" class="button">
                        <span><span>Enviar</span></span></button>
                </div>
                            </form>
            <script type="text/javascript">
                //<![CDATA[
                var dataForm = new VarienForm('form-validate', true);
                                //]]>
            </script>

        </div>

    </div>

</div>                </div>
            </div>
	        <!-- footer BOF -->
<? include("includes/footer.php")?>
<!-- footer EOF -->        </div>
            </div>
</div>
</body>
</html>