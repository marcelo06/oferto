<?php


#Manejo de variables get alternos

$vars_get = $input->getVariables($input->get('ruta'));
	
if($vars_get === false)
	trigger_error ('Parametros por get incorrectos', E_USER_ERROR);
	

if(count($vars_get) == 0){
	$controllerName = $config['control_default'];
	$actionName  = "index";
}

if(count($vars_get) == 1){
	$controllerName = $vars_get['control'];
	$actionName  = "index";
}

if(count($vars_get) >= 2	){
	$controllerName = $vars_get['control'];
	$actionName = $vars_get['accion'];
}

if($controllerName == "")
	$controllerName = $config->data['control_default'];;

if(!isset($actionName)){
	$actionName = "index";
}


$controllerPath = CONTROL.$controllerName.EXT;

if(is_file($controllerPath))
	  require $controllerPath;
else{
	if($config->data['errores']){
		trigger_error ('El controlador '.$controllerName .  ' no existe', E_USER_ERROR);
	}
	header('HTTP/1.0 404 Not Found');
	exit;
}
	  
define("QSELF",$controllerName.'-'.$actionName);      //Controlador y acción

#Si no existe la clase que buscamos y su accion, tiramos un error 404

if (method_exists($controllerName, $actionName) == false) 
{
	if($config->data['errores']){
		trigger_error ($controllerName . '->' . $actionName . '` no existe', E_USER_ERROR);
	}
	header('HTTP/1.0 404 Not Found');
	exit;
}

#Cargar el nuevo idioma

define('URI' ,str_replace("ruta=",'',$input->xss_clean($_SERVER['QUERY_STRING']))); //Saca los parametros de la URL

$vlang = str_replace('.htm','',URI);   
$vlang = str_replace('-lang-'.$input->xss_clean($_SESSION['lang']),'', $vlang);

if($vlang == '')   //Parametros sin .htm y sin el lenguaje
	define('QSTRING', $controllerName.'-'.$actionName ); 
else
	define('QSTRING', $vlang ); 

if (array_key_exists('lang', $vars_get)) {
	foreach($config->data['lang'] as $idioma)
		if($vars_get['lang']  == $idioma){
			$_SESSION['lang'] = $vars_get['lang']; 
			header("Location: ".QSTRING);
		}
}


$sec = new Secured();
if(!$sec->permisoUsuario($_SESSION['id_usuario'], $controllerName, $actionName)){
	session_destroy();
	header("Location: login-usuario");
	exit;
}

#Define el id_empresa

$emp = new Empresas();
$id_empresa = $emp->getIdEmpresa();
if($id_empresa !== false && $emp->validarIdEmpresa($id_empresa)){
	if(!isset($_SESSION['autentico'])){ 
		$_SESSION['id_empresa'] =  $id_empresa;
	}
	$datos_e=$emp->obtener($id_empresa);
define('SKIN', $datos_e['skin']);	
define('COLOR', strtolower($datos_e['color']));	
$alias_p=($datos_e['alias_productos']!='')?$datos_e['alias_productos']:'Productos'; 
define('PRODUCTOS_TXT', $alias_p);
}/*else{
	redirect('http://www.oferto.co');
    exit;
}*/



#Si todo esta bien, creamos una instancia del controlador y llamamos a la accion

$controller = new $controllerName();
$controller->get = $vars_get;
$controller->input = $input;

#Destruyendo Variables  no necesarias
unset($vars_get, $controllerName, $vlang, $config, $controllerPath, $ftabla, $flang, $idioma, $val, $site_path);

$controller->$actionName();

?>