<? include("includes/prehtml.php"); ?><head>
<? include("includes/tags.php"); ?>
<script type="text/javascript">
</script>
</head>

<body>
<? include("includes/header.php"); ?>
<div id="main">
  <div class="bloq1">
    <? include("includes/menu.php"); ?>
    
  <div class="bloq2">
    <div class="tt">
      <div class="ttx">Módulos / Agregar Módulo</div>
    </div>
    <div class="cont">
      <form action="" method="post"  name="form1" >
        <strong>Módulo:</strong>
        <input name="dat[modulo]" type="text" class="inputs" id="dat[modulo]" value="<? pv($reg['modulo']) ?>" />
      
        <div class="bbts">
          <input type="image" name="btnAceptar" id="imageField" src="<?= URLVISTA ?>sys/images/aceptar.gif"/>
         <a href="modulo-listar_modulos"> <img name="btnCancelar" id="imageField2" border="0" src="<?= URLVISTA ?>sys/images/cancelar.gif"/></a>
        </div>
        
      </form>
    </div>
  </div>
  <div class="both"></div>
</div>
</div>
<? include("includes/pie.php"); ?>
</body>
</html>
