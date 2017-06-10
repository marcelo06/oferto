<?php

/**
* 
*/
class config 
{
	
	public $data;
	function __construct(){
		#configuración base de datos
		$this->data['dbhost'] = "localhost";
		$this->data['dbname'] = 'ofertoha_oferto';  //"oferto";
		$this->data['dbuser'] = 'root';  //"oferto";
		$this->data['dbpass'] = "";

		// #configuración rutas
		// $this->data['dominio'] = 'oferto.haggen-it.com';  //"oferto.co";
		// $this->data['subdominio'] = "/"; 

		/*$this->data['dbhost'] = "localhost";
		$this->data['dbname'] = "oferto";
		$this->data['dbuser'] = "root";
		$this->data['dbpass'] = "root"; */
		#configuración rutas
		$this->data['dominio'] = "localhost";
		$this->data['subdominio'] = "/oferto/"; 

		$this->data['system'] = BASEPATH."system/";     
		$this->data['lib'] = $this->data['system']."lib/";        
		$this->data['model'] =  $this->data['system']."model/";      
		$this->data['control'] = $this->data['system']."control/";
		$this->data['vista'] = $this->data['system'].'vista/';
		$this->data['files'] = BASEPATH."files/";
		$this->data['tmpdir'] = '/tmp';

		#Controlador por defecto
		$this->data['control_default'] = "main";

		#Juego de Caracteres
		$this->data['charset'] = 'utf-8';

		#Configuracion de seguridad
		$this->data['xss'] = true;   			//Activar o desactivar el limpiado de variables GET y POST    valores: true o false;
		$this->data['ext'] = ".php";   		//extension estandar de los scripts

		#Activar sitio web o ponerlo en mantenimiento

		$this->data['activo'] = true;			//Posibles valores: true | false

		#Configuración de lenguajes
		$this->data['idioma'] = false;
		$this->data['lang'][] = "es";       //Espa�ol  
		$this->data['lang'][] = "en";       //Ingles

		// DESACTIVAR EN PRODUCCION

		#Mostrar Depuracion
		$this->data['errores'] = false; 		//Posibles valores: true | false

		#Administrador de permisos
		$this->data['permisos'] = true; 		//Posibles valores: true | false
	}
}
?>
