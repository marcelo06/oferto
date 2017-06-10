<?php
/**
 * Verifica que el cliente que está consumiendo el servicio web tenga permiso de hacerlo.
 * @param string $requestUri
 * @param string $accessToken
 * @param string $privateKey
 * @return bool
 */
function authenticate($requestUri, $accessToken, $privateKey)
{
	$requestUriNoToken = substr($requestUri, 0, strpos($requestUri, '&access_token')-strlen($requestUri));
	$hmac = hash_hmac('sha1', $requestUriNoToken, $privateKey);
	if($hmac!=$accessToken)
	{
		echo $hmac;
	}
	return $hmac===$accessToken;
}

/**
 * Create URL Title
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with either a dash
 * or an underscore as the word separator.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator: dash, or underscore
 * @return	string
 */
if ( ! function_exists('chstr'))
{
	function chstr($str)
	{
		
		$search		= '-';
		$replace	= '_';
		
		$code= array('á','é','í','ó','ú','ñ','Á','É','Í','Ó','Ú','Ñ');
		$code2= array('a','e','i','o','u','n','A','E','I','O','U','N');
		$str = str_replace($code,$code2,$str);

		
		$trans = array(
			$search								=> $replace,
			"\s+"								=> $replace,
			"[^a-z0-9".$replace."]"				=> '',
			$replace."+"						=> $replace,
			$replace."$"						=> '',
			"^".$replace						=> ''
			);

		$str = strip_tags(strtolower($str));
		
		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#", $val, $str);
		}
		
		return trim(stripslashes($str));
	}
}

function vn(&$var, $default="")
{
	/* if $var is undefined, return $default, otherwise return $var */
	return isset($var) ? "$".number_format($var, 0, ',', '.') : $default;
}

function resta_fechas($fecha_principal, $fecha_secundaria)
{
	$d2 = new DateTime($fecha_principal);
	$d1 = new DateTime($fecha_secundaria);
	$interval = $d1->diff($d2);
	$restante = $interval->format('%r%a');
	if($restante<0)
		$restante= 0;
	return $restante;
}
?>