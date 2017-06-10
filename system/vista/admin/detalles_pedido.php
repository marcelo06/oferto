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

   </head>


<body>
<?
$tabla='';
$nombre= ($ped['nombre_pedido']!='') ? $ped['nombre_pedido'].' '.$ped['apellidos_pedido']:$cliente['nombre'].' '.$cliente['apellidos'];
$email= ($ped['email_pedido']!='') ? $ped['email_pedido']:$cliente['email'];
$telefono= ($ped['telefono_pedido']!='') ? $ped['telefono_pedido']:$cliente['telefono'];
$movil= ($ped['movil_pedido']!='') ? $ped['movil_pedido']:$cliente['movil'];

$ciudad= ($ped['ciudad_pedido']!='') ? usuario::nombre_localidad('ciudad',$ped['ciudad_pedido']):$cliente['ciudad'];
$departamento= ($ped['departamento_pedido']!='') ? usuario::nombre_localidad('dpto',$ped['departamento_pedido']):$cliente['departamento'];
$pais= ($ped['pais_pedido']!='') ? usuario::nombre_localidad('pais',$ped['pais_pedido']):$cliente['pais'];
$direccion= $ped['direccion_pedido'];


               $tabla .='
                <table  width="100%" border="0" cellspacing="1" cellpadding="8" class="t_pedido">

                  <tr>
                    <td width="81%"><strong>Detalle del producto</strong></td>
					<td width="14%" align="center" ><strong>Precio</strong></td>
					<td width="6%" align="center" ><strong>Cantidad</strong></td>
					
					<td width="13%" align="center" ><strong>Total</strong></td>
                  </tr>';


					   $total = 0;
					   $preciot = 0;
					   foreach($productos as $pro){

						$precio = str_replace( ".", "", $pro['precio'] );

						$cantidad = (int)$pro['cantidad'];
						$cantidad = ((is_integer($cantidad))? $cantidad : 1);
						$preciot = $precio*$cantidad;
                        $total += $preciot;
					$tabla.='
                             <tr >
								
								 <td >'.$pro['nombre'].' '.$pro['adicional_opcion'].'</td>
            <td align="center" >'.vn($pro['precio']).'<sub>COP</sub></td>
            <td align="center" >'.$pro['cantidad'].'</td>
            
            <td align="right">'.vn($preciot).'<sub>COP</sub></td>
			
							 </tr>';
                    }
                  $tabla.='
				  <tr >
                    <td>Total</td>
                    <td ></td>
                    <td ></td>
                    <td align="left" >'.vn($total).'</td>
                  </tr>

			    </table>';
?>

<div class="Widgets">
	<div class="row-fluid">
    <div class="span12">
     <div class="modWid">
      <div class="title">
        <h1 >Información del Pedido #</strong><?=$ped['orden']?>.</h1>
      </div>

      <div class="iwrapform">
       <div class="row-fluid">
            <div class="span12">
            <i><?=$ped['fecha']?></i>
           <?=$tabla?>
            </div>
            </div>
        <br />    
       <div class="row-fluid">
          <div class="span12">
           <h3 >Datos del Cliente: </h3>
          </div>
          <div class="span6"><strong>Nombre Completo:</strong> <?=$nombre?></div>
           
           <div class="span4"><strong>Email:</strong> <?=$email?></div>
           
           <div class="span3"><strong>Teléfono:</strong><?=$telefono?></div>
           <? if($movil!=''){?>
           <div class="span3"><strong>Móvil:</strong> <?=$movil?></div>
           <? }?>
           
            <div class="span3"><strong>Ciudad:</strong> <?=$ciudad?></div>
            <div class="span3"><strong>Departamento:</strong> <?=$departamento?></div>
            <div class="span3"><strong>Pais:</strong> <?=$pais?></div>
           
           
           <div class="span11"><strong>Dirección:</strong> <?=$direccion?></div>
           </div>
          
            </div>
            </div>
     </div>
   </div>
</div>     
</body>

</html>