<? include("includes/tags.php") ?>
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/js/login.js"></script>
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/js/registro.js?v=1"></script>
<script type="text/javascript">
mensaje='';
jQuery(document).ready(function(){
jQuery( "#form-validate" ).validate({
             rules:{
                'dat[_username]':{ required: true,email: true, "remote":{
                    url: 'usuario-validar',
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
</head>
<body class="  customer-account-create">
<div class="wrapper">

    <div class="page">

<!-- HEADER BOF -->
<? include("includes/header.php")?>
        <div class="main-container col<?=($compra)? '2-right':'1'?>-layout">
            <div class="main row clearfix">
                <!-- breadcrumbs BOF -->
<!-- breadcrumbs EOF -->
                <div class="col-main">
                <? if($compra){?><div class="page-title"><h1>Finalizar Compra</h1></div><? }?>
<div <?=($compra) ? 'class="opc"':''?>>
<div <?=($compra)? 'id="checkout-step-login"':'class="account-create"'?>>

<div class="block <?=($compra)? 'block block-checkout-register':'block-login'?>">
        <div class="block-title">
            <strong><span>INGRESAR</span></strong>
        </div>

        <div class="block-content" id="login-form">

            <form method="post" id="form-login">

                    <input type="hidden" name="success_url" value=""/>
                    <input type="hidden" name="error_url" value=""/>

                    <h2 class="legend first">Si ya tiene cuenta con nosotros</h2>
                    <div class="alerts-inf" style="color:#FF0000"></div>
                    <ul class="form-list">
                        <li class="fields">
                            <div class="customer-name">
    <div class="field name-firstname">
        <label for="firstname" class="required"><em>*</em>Usuario</label>
         <?=($compra) ? '<input type="hidden" name="lcompra" id="lcompra"  value="1" />':''?>
        <div class="input-box">
            <input type="text" id="user" name="user" value=""  maxlength="255" class="input-text required-entry"  />
        </div>
    </div>

</div>
                        </li>

                        <li class="fields">
                            <div class="field">
                                <label for="password" class="required"><em>*</em>Contraseña</label>

                                <div class="input-box">
                                    <input type="password" name="password" id="password" title="Contraseña" class="input-text required-entry validate-password"/>
                                </div>
                            </div>

                        </li>

                        <li class="fields">
                            <div class="field">
                              <p><a href="javascript:void(0)" id="lost">Olvidó su contraseña?</a></p>
                            </div>

                        </li>

                                                                    </ul>
                    <div id="window-overlay" class="window-overlay" style="display:none;"></div>


                <div class="buttons-set">
                    <p class="required">* Campos requeridos</p>

                    <button type="button" class="button" onClick="validar()"  id="login"  value="Entrar">
                        <span><span>Entrar</span></span></button>
                </div>
                            </form>
            <script type="text/javascript">
                //<![CDATA[
                var dataForm = new VarienForm('form-login', true);
                                //]]>
            </script>

        </div>

    </div>
    <div class="block <?=($compra)? 'block block-checkout-register':'block-login'?>">
        <div class="block-title">
            <strong><span><?=($compra) ? 'Datos de contacto':'Regístrese'?></span></strong>
        </div>

        <div class="block-content">

            <form action="usuario-editar" method="post" id="form-validate">
<input type="hidden" id="proviene" name="proviene" value="<?=($compra) ? 'compra':'registro'?>"/>
<input type="hidden" id="id_empresa" name="dat[id_empresa]"  value="<?=$_SESSION['id_empresa']?>"/>

                    <h2 class="legend first"><?=($compra) ? 'Diligencie los siguientes datos para completar la compra':'Si usted no tiene una cuenta con nosotros, por favor cree una cuenta.'?></h2>
                    <div class="alerts-reg" style="color:#FF0000"></div>
                    <ul class="form-list">

                      <? if($compra){?>

                      <li class="control">
                            <div class="input-box">
                                <input type="checkbox" name="elpass" id="elpass"  checked  value="on" onChange="mostrar()"   class="checkbox"/>
                            </div>
                            <label for="is_subscribed">Crear cuenta en <?=DOMINIO?></label>
                        </li>
                         <div id="passc" style=" clear:both">
                        <li class="fields">
                            <div class="customer-name">
    <div class="field name-firstname">
        <label for="firstname" class="required"><em>*</em>Email (Usuario)</label>
        <div class="input-box">
            <input type="email" name="dat[_username]" id="usuario"  onChange="upemail()" maxlength="255" class="input-text" required value="<?=nvl($_SESSION['d_pedido']['email_pedido'])?>" />
        </div>
    </div>

</div>
                        </li>

                        <li class="fields">

                            <div class="field">
                                <label for="password" class="required"><em>*</em>Contraseña</label>

                                <div class="input-box">
                                    <input type="password" name="dat[_password]" id="pass" class="input-text" required/>
                                </div>
                            </div>

                        </li>
                        <li class="fields">

                            <div class="field">
                                <label for="confirmation"
                                       class="required"><em>*</em>Repetir contraseña</label>

                                <div class="input-box">
                                    <input type="password" name="contra"
                                          id="contra"
                                           class="input-text" required/>
                                </div>
                            </div>
                        </li>
                        </div>

                      <? }else{?>
   <li class="fields">
                            <div class="customer-name">
    <div class="field name-firstname">
        <label for="firstname" class="required"><em>*</em>Email (usuario)</label>
        <div class="input-box">
            <input type="email" name="dat[_username]" id="usuario"  onChange="upemail()"  value=""  maxlength="255" class="input-text" required   />
        </div>
    </div>

</div>
                        </li>
                        <li class="fields">
                            <div class="field">
                                <label for="password" class="required"><em>*</em>Contraseña</label>

                                <div class="input-box">
                                    <input type="password" name="dat[_password]" id="pass"  class="input-text" required/>
                                </div>
                            </div>
                            <div class="field">
                                <label for="confirmation"
                                       class="required"><em>*</em>Repetir contraseña</label>

                                <div class="input-box">
                                    <input type="password" name="contra"
                                            id="contra"
                                           class="input-text" required/>
                                </div>
                            </div>
                        </li>

                    <? }?>

                        <input type="hidden" name="dat[id_tipo_usuario]" id="id_tipo_usuario" value="5"/>                 </ul>


                    <h2 class="legend">Datos personales</h2>
                    <ul class="form-list">
                     <li style="display:none" id="li_email_reg">
                            <label for="email_address"
                                   class="required"><em>*</em>Email</label>

                            <div class="input-box">
                                <input type="email" name="per[email]" id="email_reg" class="input-text" required value="<?=nvl($_SESSION['d_pedido']['email_pedido'])?>"/>
                            </div>
                        </li>
                        <li class="fields">
                            <div class="field">
                                <label for="nombre" class="required"><em>*</em>Nombre Completo </label>
                                <div class="input-box">
                                    <input type="text" name="per[nombre]" id="nombre_reg" class="input-text" required value="<?=nvl($_SESSION['d_pedido']['nombre_pedido'])?>"/>
                                </div>
                            </div>

                        </li>

                        <li class="fields">
                            <div class="field">
                                <label for="telefono" class="required">Teléfono: </label>
                                <div class="input-box">
                                    <input type="text" name="per[telefono]" id="telefono_reg" class="input-text" value="<?=nvl($_SESSION['d_pedido']['telefono_pedido'])?>"/>
                                </div>
                            </div>

                        </li>

                        <li class="fields">
                            <div class="field">
                                <label for="direccion" class="required"><em>*</em>Dirección: </label>
                                <div class="input-box">
                                    <input type="text" name="per[direccion]" id="direccion_reg" class="input-text" required value="<?=nvl($_SESSION['d_pedido']['direccion_pedido'])?>"/>
                                </div>
                            </div>

                        </li>

                        <li class="fields">
                            <div class="field">
                                <label for="pais" class="required"><em>*</em>País: </label>
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
                                <label for="departamento" class="required"><em>*</em>Departamento: </label>
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

</div>
</div>
               </div>
<? if($compra){?>
<div class="col-right sidebar">
                 <div class="block ">
    <div class="block-title">
        <strong><span>Resumen de compra</span></strong>
    </div>


        <div class="presumen">
<div class="details">


 <ol class="mini-products-list" id="cart-sidebar">
 <? $cantidad=0;
    $cadena='';
    $ids= array();
    $carrito = new Carrito();

    if($carrito->numProductos() > 0){?>

    <?  $total = 0;
         $i=0;

         for($p =0; $p<$carrito->nf; $p++)
            if(nvl($carrito->carro['estado'][$p])){
              $cantidad += $carrito->carro['cantidad'][$p];
              $preciot = $carrito->carro['precio'][$p]*$carrito->carro['cantidad'][$p];
              $total += $preciot;

              $imagen_c= $carrito->carro['imagen'][$p];
              $titulo_c= $carrito->carro['nombre'][$p];
              $precio_c=($carrito->carro['precio'][$p]) ? vn($carrito->carro['precio'][$p]):'';?>

        <li class="item clearfix">
<a class="product-image"><img src="<?=$imagen_c?>" data-srcX2="<?=$imagen_c?>" width="50" height="50" alt="<?=$titulo_c?>" /><span></span></a>
<div class="product-details">
<p class="product-name"><a><?=$titulo_c?></a></p>
<strong><?=$carrito->carro['cantidad'][$p]?> *</strong><span class="price"><?=$precio_c?></span></div></li>

        <?  }
      }
     ?>

  </ol>
  <div class="subtotal-wrapper">
  <div class="subtotal">
  <span class="label">Total:</span> <span class="price"><?=(nvl($total,0)) ? vn($total):'0';?></span>
   </div>
   </div>

    </div></div>

</div>              </div>
<? }?>
            </div>
            <!-- footer BOF -->
<? include("includes/footer.php")?>
<!-- footer EOF -->        </div>
            </div>
</div>
</body>
</html>