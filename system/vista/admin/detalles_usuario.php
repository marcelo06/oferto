<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<title>RHISS - Sistema Especializado Manejador de Contenidos</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?=URLVISTA?>admin/css/bootstrap.min.css">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="<?=URLVISTA?>admin/css/bootstrap-responsive.min.css">
	
	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?=URLVISTA?>admin/css/style.css">
    <script src="<?=URLVISTA?>admin/js/jquery.min.js"></script>
    <?= plugin::message() ?>
  <script src="<?= URLBASE?>system/src/editable/jquery.jeditable.mini.js" type="text/javascript"></script>
	
<style type="text/css">
.box .box-title{padding-top:0;}
.box .box-title .tabs{float: left;}
.box.box-color .box-title .tabs > li.active > a {color: #333333;}
.box.box-color .box-title .tabs > li > a:hover {color: #000;}
.box.box-color .box-title .tabs > li > a {color: #666;}
.boxpadd{margin: 0 2px 2px 0; background-color: #F5F5F5;}
.tt_suscrito{display: block; float: left; font-weight: bold; margin-right: 10px;}
.suscrito{display: block; float: left; text-decoration: underline; color:#368ee0;}
</style>
   </head>


<body>

<div class="Widgets">
	<div class="row-fluid">
    <div class="span12">
     <div class="modWid">
     

      <div class="iwrapform">
       <div class="row-fluid">
          
            <div class="span12">
           <h3 >Datos del Usuario: </h3>
          </div>
          <div class="span6"><div class="boxpadd"><strong>Nombre Completo:</strong> <?=$usuario['nombre'].' '.$usuario['apellidos']?></div></div>
           
           <div class="span4"><div class="boxpadd"><strong>Email:</strong> <?=$usuario['email']?></div></div>
           
           <div class="span3"><div class="boxpadd"><strong>Teléfono:</strong><?=$usuario['telefono']?></div></div>
          
           <div class="span3"><div class="boxpadd"><strong>Móvil:</strong> <?=$usuario['movil']?></div></div>
          
           
            <div class="span3"><div class="boxpadd"><strong>Ciudad:</strong> <?=$usuario['ciudad']?></div></div>
            <div class="span3"><div class="boxpadd"><strong>Departamento:</strong> <?=$usuario['departamento']?></div></div>
            <div class="span3"><div class="boxpadd"><strong>Pais:</strong> <?=$usuario['pais']?></div></div>
           
           
           <div class="span3"><div class="boxpadd"><strong>Dirección:</strong> <?=$usuario['direccion']?></div></div>
           <div class="span10"><div class="boxpadd"><span class="tt_suscrito">Sucrito Mailing:</span> <span class="suscrito" href="javascript:void(0)"><?=($usuario['suscrito']=='1') ? 'Si':'No'?></span><div style="clear:both"></div></div></div>
          
      </div>
     </div>
   </div>
</div> 
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){

  $('.suscrito').editable( 'usuario-estado_suscripcion-tipo-<?=$tipo?>', {
    "callback": function( sValue, y ) { 
      estado='success';
      mensaje='El usuario '+sValue+' esta suscrito';
      if(sValue=='Error'){
        mensaje='Hubo un error al procesar la solicitud';
        estado='error';
      }

      $().toastmessage('showToast', {
        text     : mensaje,
        position : 'top-center',
        type     : estado
      }); 
    },
    "submitdata":{
      "id_item": <?=$usuario['id_usuario']?>             
    },            
    data   : "{'1':'Si','0':'No'}",
    type   : 'select',
    submit : 'Guardar'              
  } ); 
});       
</script>    
</body>
</html>