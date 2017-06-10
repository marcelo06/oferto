<?php
class View
{
	function __construct() 
	{
	}

	public function show($name, $vars = array()) 
	{
		$path = VISTA . $name;

		if (file_exists($path) == false) 
		{
			trigger_error ('Plantilla `' . $path . '` no existe', E_USER_ERROR);
			return false;
		}
		
		if(is_array($vars))
		{
			foreach ($vars as $key => $value) 
				$$key = $value;
		}

		include($path);
	}
}

?>