<?php
#version 14022010

session_start();
if(session_id() == ""){
	session_id(md5(uniqid(rand(), true)) );
	session_name("rhiss.net");
}

if(!isset($_SESSION['id_usuario'])){
	$_SESSION['id_usuario'] = 1;
}

if (version_compare(phpversion(), '5.1.0', '<') == true) { die ('Aplicativo solo funciona en version > PHP5.1'); }

date_default_timezone_set('America/Bogota');

define ('DIRSEP', DIRECTORY_SEPARATOR);

//Definir la ruta absoluta del aplicativo
$site_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP. DIRSEP . '..' . DIRSEP) . DIRSEP;
define ('BASEPATH', $site_path);

//Cargar configuraciones
require(BASEPATH."system/config/config.php");
$config = new Config();

//Depurar
if($config->data['errores']){
	ini_set("display_errors","1");
	error_reporting(E_ALL);
}else{
	ini_set("display_errors","0");
}
ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);

//Constantes
define('URLBASE', $config->data['subdominio'] );
define('DOMINIO',$config->data['dominio']);
define('EXT',$config->data['ext']);
define('SYSTEM',$config->data['system']);
define('MODEL', $config->data['model']);
define('CONTROL', $config->data['control']);
define('VISTA', $config->data['vista']);
define('LIB', $config->data['lib']);
define('FILES', $config->data['files']);
define('SRC', $config->data['system'].'src/');

define('URLSRC', str_replace(BASEPATH,URLBASE,SRC));
define('URLFILES', str_replace(BASEPATH,URLBASE,FILES));
define('URLVISTA', str_replace(BASEPATH,URLBASE,VISTA));


//Carga las librerias
require(LIB."stdlib.php");
require(LIB."userlib.php");
require(LIB."fechalib.php");
require(LIB."controlBase.php");
require(LIB."modelBase.php");
require(LIB."view.php");
require(LIB."RI_input.php");
require(LIB."secured.php");
require(LIB."modulos.php");
require(LIB."plugin.php");

// Deshabilitar modulo de permisos
if(nvl($_SESSION['id_tipo_usuario']) == 3 && !$config->data['permisos']){
	$_SESSION['id_usuario'] = 1;
	$_SESSION['id_tipo_usuario'] = 1;
	redirect(URLBASE);
}
	
// Modo Mantenimiento

if(!$config->data['activo'])
	redirect("mantenimiento.html");

// Carga las clases
function __autoload($class_name) {

	if($class_name != 'finfo' && strpos($class_name,'Google') === false){
		$filename = strtolower($class_name);
		$file = MODEL.$filename.".class".EXT;
		$file2 = CONTROL.$filename.EXT;
		if (file_exists($file) == false && file_exists($file2) == false) { 
			trigger_error ('La clase `' . $class_name . '` no existe', E_USER_ERROR);
			return false;
		}
		if (file_exists($file))
			require ($file);
		elseif (file_exists($file2))
			require($file2);
	}
}


// Cargar lenguaje

if($config->data['idioma']){
		if (isset($_POST['lang'] )){
			foreach($config->data['lang'] as $idioma){
				if($_POST['lang']  == $idioma)
					$_SESSION['lang'] = $_POST['lang'] ; 
			}
		}
		
		if (!isset($_SESSION['lang']) || !in_array(nvl($_SESSION['lang']), $config->data['lang']) ){
			  $_SESSION['lang'] = $config->data['lang'][0] ; 
		}
		
		$idioma = $_SESSION['lang'] ;
		$ftabla = SYSTEM."config/tabla_".$idioma.EXT;
		$flang = SYSTEM."config/lang/idioma_".$idioma.EXT; 
		if (file_exists($ftabla) == false) 
				trigger_error ('Archivo de tablas `' . $ftabla . '` no existe', E_USER_ERROR);
		else
			require($ftabla);
		
		if (file_exists($flang) == false) 
				trigger_error ('Archivo de idioma `' . $flang . '` no existe', E_USER_ERROR);
		else
			require($flang);
}else{
	$_SESSION['lang'] = '';
	$ftabla = SYSTEM."config/tabla".EXT;
	require($ftabla);
}

// Limpiado de variables globales

$input = new RI_input($config->data['xss']);

# Manejo de errores

global $errores;
$errores = $config->data['errores'];

function _Errores($errno, $errstr, $errfile, $errline)
{
	global  $errores;
	$error = "";
	$log = new Modulos();
    switch ($errno) {
    case E_USER_ERROR:
        $error = "<b>ERROR</b> [$errno] $errstr<br />\n";
        $error .="  Error fatal en la linea $errline del archivo $errfile</br>";
        $error .="<b>Abortado</b><br />\n";
		$log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], $error);
		if($errores)
			echo $error;
		exit(1);
        break;

    case E_USER_WARNING:
        $error = "<b>WARNING</b> [$errno] $errstr<br />\n";
		$error .= "  Advertencia en la linea $errline del archivo $errfile</br>";
        break;

    case E_USER_NOTICE:
        $error = "<b>NOTICE</b> [$errno] $errstr<br />\n";
		$error .="  Error en la linea $errline del archivo $errfile</br>";
        break;
		
	case E_NOTICE:
        $error = "<b>NOTICE</b> [$errno] $errstr<br />\n";
		$error .="  Error en la linea $errline del archivo $errfile</br>";
        break;
		
	case E_WARNING:
        $error = "<b>WARNING</b> [$errno] $errstr<br />\n";
		$error .=" Advertencia en la linea $errline del archivo $errfile</br>";
        break;
		
    default:
        $error = "Tipo de error desconocido: [$errno] $errstr<br />\n";
		$error .="  Error en la linea $errline del archivo $errfile</br>";
        break;
    }

	
	if($errores){
		$log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], $error);
		echo $error;
	}	
	
    return true;
}

set_error_handler("_Errores");

#ejecutar controlador frontal
require LIB.'controlFrontal.php';

?>