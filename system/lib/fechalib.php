<?php 

global $meses,$dia_semana;
$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$dia_semana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");

function fecha2dma($fecha, $tipo){
	if(strpos($fecha,"-")){
		$fec = explode("-",$fecha);
		if($tipo=="d") $n=2; 
		if($tipo=="m") $n=1; 
		if($tipo=="a") $n=0;
		return (int) $fec[$n];
	}elseif(strpos($fecha,"/")){
		$fec = explode("/",$fecha);
		if($tipo=="d") $n=0;
		if($tipo=="m") $n=1;
		if($tipo=="a") $n=2;
		return (int) $fec[$n];
	}else
		return false;
}


function menu_dia($diainp=""){
  if($diainp != "")
	$dia = (int) $diainp;
  else
	$dia = date("j");
	
  for($i=1;$i<32;$i++)
	if($i == $dia)
		echo "<option value='$i' selected>$i</option>";
	else
		echo "<option value='$i'>$i</option>";
}

function fecha_semana(){
$mesesy = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$dia_semanax = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
  $mes = date("n");
   echo  $dia_semanax[date("w")].", ".date("d")."  ".$mesesy[$mes].",".date("Y");
}

function menu_mes($mesinp = ""){
$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  if($mesinp != "")
	$mes = (int) $mesinp;
  else
	$mes = date("n");

	for($i=1;$i<13;$i++)
		if($i == $mes)
			echo "<option value='$i' selected>$meses[$i]</option>";
		else
			echo "<option value='$i'>$meses[$i]</option>";
}

function menu_anio($anioinp = ""){
  if($anioinp != "")
	$anio = (int) $anioinp;
  else
	$anio = date("Y");
	
  for($i=date("Y")-70;$i<date("Y")-5;$i++)
	if($i == $anio)
		echo "<option  value='$i' selected>$i</option>";
	else
		echo "<option value='$i'>$i</option>";
}


function fecha_texto( $fecha, $mesesx = "",$t=0 ){
$mesesx = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	if(strpos($fecha," ")){
		$time = explode(" ",$fecha);
		$fecha = $time[0];
	}
	$fec = explode("-",$fecha);
	$mes = (int)$fec[1];
	$dia = $fec[2];
	$anio = $fec[0];

	$fechar=$mesesx[$mes]." ".$dia." de ".$anio;
	if($t and nvl($time[1])!='')
		$fechar.=" ".$time[1];



    return $fechar;
}

function fecha_texto_resumida( $fecha, $mesesx = "" ,$t=0){
$mesesx = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
	if(strpos($fecha," ")){
		$time = explode(" ",$fecha);
		$fecha = $time[0];
	}
	$fec = explode("-",$fecha);
	$mes = (int)$fec[1];
	$dia = $fec[2];
	$anio = $fec[0];
	
	$fechar=$mesesx[$mes]." ".$dia." ".$anio;
	if($t and nvl($time[1])!='')
		$fechar.=" ".$time[1];

    return $fechar;
	
}


function fecha_punto( $fecha ){
	if(strpos($fecha,"-")){
		$fec = explode("-",$fecha);
		return $fec[2].".".$fec[1].".".$fec[0];
	}else
		return false;
}

function fecha2db( $fecha ){
	if(strpos($fecha,"/")){
		$fec = explode("/",$fecha);
		return $fec[2]."-".$fec[1]."-".$fec[0];
	}else
		return false;
}

function db2fecha( $fecha,$f=1 ){
	if(strpos($fecha," ")){
		$time = explode(" ",$fecha);
		$fecha = $time[0];
		$time[1] = " ".$time[1];
	}else{
		$time[1] = "";
	}
	if($f)
		$time[1] = "";
	if(strpos($fecha,"-")){
		$fec = explode("-",$fecha);
		return $fec[2]."/".$fec[1]."/".$fec[0].$time[1];
	}else
		return false;

}

function resta_fechas($fecha_principal, $fecha_secundaria){

   $d2 = new DateTime($fecha_principal);
   $d1 = new DateTime($fecha_secundaria);
   $interval = $d1->diff($d2);
   
   $restante=$interval->format('%r%a');
   
   if($restante < 0)
   	$restante= 0;
   	
   	return $restante;
}
/*function resta_fechas($fecha1,$fecha2)
{
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$anio1)=split("/",$fecha1);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$anio1)=split("-",$fecha1);
        if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$anio2)=split("/",$fecha2);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$anio2)=split("-",$fecha2);
			  
        $dif = mktime(0,0,0,$mes1,$dia1,$anio1) - mktime(0,0,0,$mes2,$dia2,$anio2);
      $ndias=floor($dif/(24*60*60));
      return($ndias);
}*/

function restar_tiempo($time1, $time2){
	if (preg_match("/[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}/",$time1))
              list($hh1,$mm1,$ss1)=split(":",$time1);
	if (preg_match("/[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}/",$time2))
              list($hh2,$mm2,$ss2)=split(":",$time2);
	
	$res = mktime($hh1,$mm1,$ss1,date('m'),date('d'),date('Y')) - mktime($hh2,$mm2,$ss2,date('m'),date('d'),date('Y'));
			
	return $res/60;

}

function ultimodiames($mes,$anio)
   {
      for ($dia=28;$dia<=31;$dia++)
         if(checkdate($mes,$dia,$anio)) $fecha=$dia;
      return $fecha;
   } 
   

?>