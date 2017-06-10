<?php
abstract class ModelBase 
{
	protected $db;
	public $datos;

	public function __construct()
	{
		require_once(LIB."db.php");
		$config = new config();
		$this->db = new db($config->data);
	}
}
?>