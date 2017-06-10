<?php

#Ultima modificacion 6/10/08

class lib {
	
	function __construct( ){}
	
	/* devuelve diferencia en dias entre 2 fechas  */
	function resta_fechas($f2,$f1) {
		$d2 = new DateTime($f2);
		$d1 = new DateTime($f1);
		$interval = $d1->diff($d2);
		
		$restante=$interval->format('%r%a');
		
		if($restante < 0)
			$restante= 0;
  		
  		return $restante;
	}
	
	
	/* if $var is undefined, return $default, otherwise return $var */
	function nvl(&$var, $default="") {
		return isset($var) ? $var : $default;
	}

	function fullUrl($contenido, $dominio){
	  $contenido = str_replace(
		array(
		  'src="/files/', 
		  'href="/',
		  'href="#/',
		  'src="//'
		),
		array(
		  'src="http://'.$dominio.'/files/', 
		  'href="http://'.$dominio.'/', 
		  'href="http://'.$dominio.'#/',
		  'src="http://'
		),
		$contenido
	  );
	  return $contenido;
	}
	
}
?>