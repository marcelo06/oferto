<?php 

function print_email($email){
	$newemail = "";
	$n = strlen($email);
	for($i=0;$i<$n;$i++)
		$newemail .= "&#".ord($email[$i]).";";
	return $newemail; 
}


function cambiar_imagen($ancho, $alto, $origen, $destino){
	$datos = getimagesize($origen);
	switch($datos[2]){
		case 1: 
			$fuente = imagecreatefromgif($origen);
			break;
		case 2:
			$fuente = imagecreatefromjpeg($origen); 
			break;
		case 3:
			$fuente = imagecreatefrompng($origen); 
			break;
	}

	$imgAncho = imagesx($fuente); 
	$imgAlto = imagesy($fuente); 
	$porc = $ancho*100/$imgAncho;
	$tamx = $imgAncho*$porc/100;
	$tamy = $imgAlto*$porc/100;

	if($tamx > $ancho || $tamy > $alto){
		$porc = $alto*100/$imgAlto;
		$tamx = $imgAncho*$porc/100;
		$tamy = $imgAlto*$porc/100;
	}

	if($tamx < $ancho){
		$x = ($ancho-$tamx)/2;
		$y=0;
	}else{
		$y = ($alto-$tamy)/2;
		$x=0;
	}

	$imagentemp = @imagecreatetruecolor($tamx,$tamy) or $imagentemp=imagecreate($tamx,$tamy);
	@imagecopyresampled($imagentemp,$fuente,0,0,0,0, $tamx+1, $tamy+1, $imgAncho, $imgAlto) or imagecopyresized($imagentemp,$fuente,0,0,0,0, $tamx+1, $tamy+1, $imgAncho, $imgAlto);
	$imagen = @imagecreatetruecolor($ancho,$alto) or $imagen=imagecreate($ancho,$alto);
    $bg = imagecolorallocate($imagen, 255, 255, 255);
	imagefill($imagen,0,0,$bg);
    imagecopy($imagen,$imagentemp,$x,$y,0,0,$tamx,$tamy);
	
	switch($datos[2]){
		case 1: 
			imagegif($imagen, $destino); 
			break;
		case 2:
			imagejpeg($imagen, $destino, 100); 
			break;
		case 3:
			imagepng($imagen, $destino);  
			break;
	}

}

function rid($id, $n=3){
	if(strlen($id)<$n){
		$id = "0".$id;
		return rid($id, $n);
	}else
		return $id;

}

function cutstr($str, $n){
	if(strlen($str) > 70){
		$str = substr($str,0,$n);
		$pos = strrpos($str," ");
		return substr($str,0, $pos)." ...";
	}else
		return $str;

}

function cutstr_t($str, $n){
	if(strlen($str) > $n){
		return substr($str,0, $n)." ...";
	}else
		return $str;

}

function cambiar_imagen_onfly($nombre, $anchura, $hmax){
	$datos = getimagesize($nombre);
	if($datos[2]==1){$img = @imagecreatefromgif($nombre);}
	if($datos[2]==2){$img = @imagecreatefromjpeg($nombre);}
	if($datos[2]==3){$img = @imagecreatefrompng($nombre);}
	$ratio = ($datos[0] / $anchura);
	$altura = ($datos[1] / $ratio);
	if($altura>$hmax){$anchura2=$hmax*$anchura/$altura;$altura=$hmax;$anchura=$anchura2;}
	$thumb = imagecreatetruecolor($anchura,$altura);
	imagecopyresampled($thumb, $img, 0, 0, 0, 0, $anchura, $altura, $datos[0], $datos[1]);
	if($datos[2]==1){header("Content-type: image/gif"); imagegif($thumb);}
	if($datos[2]==2){header("Content-type: image/jpeg");imagejpeg($thumb);}
	if($datos[2]==3){header("Content-type: image/png");imagepng($thumb); }
	imagedestroy($thumb);
}

function validar_usuario($nombre_usuario){
   if (preg_match("/^[a-zA-Z0-9]{3,20}$/", $nombre_usuario)) {
      return true;
   } else {
      return false;
   }
} 


function extension($archivo){
	$ext = explode(".",$archivo);
	return $ext[count($ext)-1];
}

function acortar($nombre){
	if(strlen($nombre) > 18){
		$cad1 = substr($nombre, 0, 6);
		$cad2 = substr($nombre, -8, 8);
		return $cad1.'...'.$cad2;
	}else{
		return $nombre;
	}
}

?>