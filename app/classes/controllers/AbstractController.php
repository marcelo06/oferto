<?php
/**
 * @package  api-framework
 * @author   Martin Bean <martin@martinbean.co.uk>
 * @abstract
 */

abstract class AbstractController {
	protected $db;
	protected $lib;
	protected $llave;
	protected $mail;
	
	public function __construct(){
		//define('OFERTO','http://localhost/oferto/');
		define('OFERTO','http://www.oferto.co/');
		define('FILES','files/');
		define('IMAGENES','files/productos/');
		define('GALERIAS','files/galerias/');
		define('EMPRESAS','files/empresas/');
		$this->db = new db();
		$this->lib = new lib();
		$this->mail = new phpmailer();
		$this->llave= 'xj10QvhsV2GR858rAQQJNOUPLTFhzhx.qgOZHFY2K7qkLT02ynJm';
	}
}