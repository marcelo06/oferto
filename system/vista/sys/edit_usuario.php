<? include("includes/prehtml.php"); ?><head>
<? include("includes/tags.php"); ?>

</head>

<body>
<? include("includes/header.php"); ?>
<div id="main">
  <div class="bloq1">
    <? include("includes/menu.php"); ?>
    
  <div class="bloq2">
    <div class="tt">
      <div class="ttx">Usuarios / Agregar Usuario</div>
    </div>
    <div class="cont">
      <form action="usuario-guardar_datos" method="post" enctype="multipart/form-data" name="form1"  id="formusr">
      <input name="id_usuario" type="hidden"  id="id_usuario" value="<? pv($reg['id_usuario']) ?>" />
        <strong>Tipo de Usuario:</strong><br />
<select name="dat[id_tipo_usuario]" id="dat[id_tipo_usuario]">
          <?= $tipo_usuarios ?>
        </select>
        <br />
        <strong>E-mail:</strong>
        <input name="dat[email]" type="text" class="inputs" id="dat[email]" value="<? pv($reg['email']) ?>" size="50" />
      
        <strong>Nombre de Usuario:</strong>
        <input name="dat[_username]" type="text" class="inputs" id="usuario" value="<? pv($reg['_username']) ?>" <?= $user ? 'readonly="readonly"' : '' ?>/>
      
        <strong>Contraseña:</strong>
        <input name="dat[_password]" type="password" class="inputs" id="contrasena1" value=""/>
        <strong>Repetir Contraseña:</strong>
        <input name="repetir" type="password" class="inputs" id="contrasena2" value=""/>
      
        <div class="bbts">
          <input type="image" name="btnAceptar" id="imageField" src="<?= URLVISTA ?>sys/images/aceptar.gif"/>
         <a href="usuario-listar_usuarios"> <img name="btnCancelar" id="imageField2" border="0" src="<?= URLVISTA ?>sys/images/cancelar.gif"/></a>
        </div>
        
      </form>
    </div>
  </div>
  <div class="both"></div>
</div>
<? include("includes/pie.php"); ?>
</body>
</html>
