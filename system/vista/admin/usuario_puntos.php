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
	<!-- jQuery UI -->
	<link rel="stylesheet" href="<?=URLSRC?>css/jquery-ui/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="<?=URLSRC?>css/jquery-ui/smoothness/jquery.ui.theme.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?=URLVISTA?>admin/css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="<?=URLVISTA?>admin/css/themes.css">
    <!-- jQuery -->
  <script src="<?=URLVISTA?>admin/js/jquery.min.js"></script>
   </head>
<script type="text/javascript">
puntos=<?=nvl($ptos['puntos'],0)?>;
usuario=<?=$ptos['id_usuario']?>;
id_puntos=<?=$ptos['id_puntos']?>;
$(document).ready(function(){
 $(".txtRedimir").hide();
 $('#valRedimir').keyup(function () { this.value = this.value.replace(/[^0-9]/g,'');});
  
});
function mostrarR(estado){
  $(".msj").html("");
  $(".txtRedimir").val(puntos);
  if(estado==1){
    $(".btnRedimir").hide();
    $(".txtRedimir").show();
  }
  else if(estado==0){
    $(".txtRedimir").hide();
    $(".btnRedimir").show();
  }
}

function redimir(){
  valor=$("#valRedimir").val();
  console.log(valor);
  if(valor>puntos){
  $(".msj").html("El valor a redimir no puede ser mayor al total de puntos.");
  }
  else{
     mostrarR(0);
     $(".msj").html("Guardando...");
     $.post("usuario-redimir_puntos",{redimir:valor,id_puntos:id_puntos},function(data){
      if(data=='Exito'){
       location.reload();
      }else{
         $(".msj").html("Hubo un error al guardar la información, inténtelo más tarde");
         console.log(data);
      }
      
       
    
     })
  }
}
</script>
<style type="text/css">
.msj{ color:#ff0000;}
#valRedimir{width: 90px;}
</style>
<body>


<div class="Widgets">
	<div class="row-fluid">
    <div class="span12">
     <div class="modWid">
      <div class="title">
        <h1 >Puntos Cliente</h1>
      </div>
      <div class="iwrapform">
       <div class="row-fluid">
        <div class="span12">
         <table  width="100%" border="0" cellspacing="1" cellpadding="8" class="t_pedido">
          <tr>
            <td width="60%"><strong>Usuario</strong></td>
            <td width="10%" align="center" ><strong>Puntos</strong></td>
            <td width="10%" align="center" ><strong>Redimidos</strong></td>
            <td width="20%" align="center" ><strong>Ultima fecha</strong></td>
          </tr>
          <tr >
           <td ><?=$ptos['usuario']?></td>
           <td align="center" ><?=nvl($ptos['puntos'])?></td>
           <td align="center" ><?=nvl($ptos['redimidos'])?></td>
           <td align="center"><?=fecha_texto_resumida($ptos['ultima_fecha'])?></td>
         </tr>
         <? if($ptos['puntos']){?>
         <tr>
            <td ></td>
           <td align="center" ></td>
           <td align="center" ><a class="btn btn-small btnRedimir" href="javascript:mostrarR(1)">Redimir</a><span class="txtRedimir"><input type="text" id="valRedimir" value="<?=nvl($ptos['puntos'])?>"/><br><a href="javascript:redimir()" class="btn btn-small" id="guardar">Redimir</a> <a href="javascript:mostrarR(0)" class="btn btn-small">Salir</a></span></td>
           <td align="right"></td>
         </tr>
         <tr>
         <td colspan="4" align="center"><span class="msj"></span></td>
         </tr>
         <? } ?>
       </table>
     </div>
   </div>
   <br />    
   <? if(nvl($ptos['historial'])!=''){?>
   <div class="row-fluid">
    <div class="span12">
      <h3 >Historial: </h3>
    </div>
   
      <? $historial= explode('_', $ptos['historial']);
      for($i=0;$i<count($historial);$i++){
        $info=explode(',',$historial[$i]);?>
         <div class="row-fluid">
      <div class="span7"><strong>Fecha: </strong><?=fecha_texto_resumida($info[0],'',1)?></div>
      <div class="span5"><strong>Redimidos: </strong><?=$info[1]?></div>
      </div>
     <? } ?>
   

 </div>
 <? }?>

</div>
            </div>
     </div>
   </div>
</div>     
</body>

</html>