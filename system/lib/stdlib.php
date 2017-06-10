<?

function mensaje( $str ){
	echo '<script >
	alert("'.$str.'");
	</script>';
}

function setdefault(&$var, $default="") {
	/* if $var is undefined, set it to $default.  otherwise leave it alone */

	if (! isset($var)) {
		$var = $default;
	}
}

function nvl(&$var, $default="") {
	/* if $var is undefined, return $default, otherwise return $var */

	return isset($var) ? $var : $default;
}

function vn(&$var, $default="") {
	/* if $var is undefined, return $default, otherwise return $var */

	return isset($var) ? "$".number_format($var, 0, ',', '.') : $default;
}

function ov(&$var) {
/* returns $var with the HTML characters (like "<", ">", etc.) properly quoted,
 * or if $var is undefined, will return an empty string.  note this function
 * must be called with a variable, for normal strings or functions use o() */

return isset($var) ? htmlSpecialChars(stripslashes($var)) : "";
}

function pv(&$var) {
/* prints $var with the HTML characters (like "<", ">", etc.) properly quoted,
 * or if $var is undefined, will print an empty string.  note this function
 * must be called with a variable, for normal strings or functions use p() */

echo isset($var) ? htmlSpecialChars(stripslashes($var)) : "";
}

function o($var, $default="") {
/* returns $var with HTML characters (like "<", ">", etc.) properly quoted,
 * or if $var is empty, will return an empty string. */

return empty($var) ? $default : htmlSpecialChars(stripslashes($var));
}

function p($var) {
/* prints $var with HTML characters (like "<", ">", etc.) properly quoted,
 * or if $var is empty, will print an empty string. */

echo empty($var) ? "" : htmlSpecialChars(stripslashes($var));
}



function strip_querystring($url) {
	/* takes a URL and returns it without the querystring portion */

	if ($commapos = strpos($url, '?')) {
		return substr($url, 0, $commapos);
	} else {
		return $url;
	}
}


function url_parametros(){
	$url = getenv("REQUEST_URI");
	$pos = strpos($url,"/",1);
	return substr($url,$pos+1,strlen($url));
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

// ------------------------------------------------------------------------

/**
 * Header Redirect
 *
 * Header redirect in two flavors
 * For very fine grained control over headers, you could use the Output
 * Library's set_header() function.
 *
 * @access	public
 * @param	string	the URL
 * @param	string	the method: location or redirect
 * @return	string
 */
if ( ! function_exists('redirect'))
{
	function redirect($uri = '', $method = 'location', $http_response_code = 302)
	{
		switch($method)
		{
			case 'refresh'	: header("Refresh:0;url=".$uri);
			break;
			default			: header("Location: ".$uri, TRUE, $http_response_code);
			break;
		}
		exit;
	}
}


function ip_address()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
    	$ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
    	$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
    	$ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


function dump($var, $exit = true)
{
	// fetch var
	ob_start();
	var_dump($var);
	$output = ob_get_clean();

	// cleanup the output
	$output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);

	// print
	echo '<pre>'. htmlspecialchars($output, ENT_QUOTES, 'UTF-8') .'</pre>';

	// stop script
	if($exit) exit;
}

function encriptar($cadena, $clave = "una clave secreta")
{
	$cifrado = MCRYPT_RIJNDAEL_256;
	$modo = MCRYPT_MODE_ECB;
	$crypt =  mcrypt_encrypt($cifrado, $clave, $cadena, $modo,
		mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND)
		);
	
	return base64_encode($crypt);	
}

function desencriptar($cadena, $clave = "una clave secreta")
{
	$cadena = base64_decode($cadena);
	$cifrado = MCRYPT_RIJNDAEL_256;
	$modo = MCRYPT_MODE_ECB;
	return mcrypt_decrypt($cifrado, $clave, $cadena, $modo,
		mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND)
		);
}

function code_video($url){
	if(strpos($url, 'vimeo') !== false){
		$ini = strrpos($url, '/');
		return substr($url, $ini+1,strlen($url));
	}elseif(strpos($url,'youtu.be') !== false){
		$ini = strrpos($url, '/');
		return substr($url, $ini+1,strlen($url));
	}else{
		$ini = strpos($url, '=');
		$fin = strpos($url, '&') ? strpos($url, '&') : strlen($url);
		return substr($url, $ini+1, $fin - $ini -1);
	}
}

function racentos($string){
	$table = array(
		'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj', 'Ž'=>'Z', 'ž'=>'z', 'C'=>'C', 'c'=>'c', 'C'=>'C', 'c'=>'c',
		'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
		'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
		'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
		'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
		'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
		'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
		'ÿ'=>'y', 'R'=>'R', 'r'=>'r', "'"=>'-', '"'=>'-'
		);

	return  strtr($string, $table);
}

function html2csv($html)
{
	$tags = array (
		0 => '~<h[123][^>]+>~si',
		1 => '~<h[456][^>]+>~si',
		2 => '~<table[^>]+>~si',
		3 => '~<tr[^>]+>~si',
		4 => '~<li[^>]+>~si',
		5 => '~<br[^>]+>~si',
		6 => '~<p[^>]+>~si',
		7 => '~<div[^>]+>~si',
		);
	
	
	$code= array('á','é','í','ó','ú','Á','É','Í','Ó','Ú');
	$code2= array('a','e','i','o','u','A','E','I','O','U');
	$html = str_replace($code,$code2,$html);

	
	$html =html_entity_decode($html, ENT_QUOTES, "utf-8");	
	
	$html = preg_replace($tags," .",$html);
	$html = preg_replace('~</t(d|h)>\s*<t(d|h)[^>]+>~si',' - ',$html);
	$html = preg_replace('~<[^>]+>~s','',$html);
    // reducing spaces
	$html = preg_replace('~ +~s',' ',$html);
	$html = preg_replace('~^\s+~m','',$html);
	$html = preg_replace('~\s+$~m','',$html);
    // reducing newlines
	$html = preg_replace('~\n+~s',".",$html);
	$code= array(',',';');
	$code2= array(' ',' ');
	$html = str_replace($code,$code2,$html);	
	return $html;
}

function calc_porcentaje($original,$nuevo){
	$porc=($nuevo*100)/$original;
	return ceil($porc)-100;
}

function validarEmail($email){
	if($email=='')
		return false;
	elseif (filter_var($email, FILTER_VALIDATE_EMAIL))
		return true;
	else
		return false;
}

function fullUrl($contenido, $dominio)
{
	  $contenido = str_replace(
		array(
		  'src="/files/', 
		  'href="/',
		  'href="#/'
		),
		array(
		  'src="http://'.$dominio.'/files/', 
		  'href="http://'.$dominio.'/', 
		  'href="http://'.$dominio.'#/'
		),
		$contenido
	  );
	  return $contenido;
}

?>