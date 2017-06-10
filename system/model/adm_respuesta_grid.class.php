<?php

/**
  * modelo para la respuesta json del grid
  *
  * 
  *
  * @package   Respuesta 
  * @author	   Luis Cerón
  * @since	   20100211
  * @version   20100211  
  */


class Adm_respuesta_grid 
{
	
	public $page;
	public $total;
	public $records;
	
	function __construct(){
		$this->page = 1;
		$this->rows = array();
	}

   /**
	 * paginar
	 *
	 * Calcula el número de paginas del grid
	 * recibe el limite de la paginación
	 *
	 * @access	public  
	 * @author	Luis Cerón
	 * @since	20100211
	 * @version	20100211
	 * @retorna el inicio de la paginación.  
	 
	 */	
	
		
	public function paginar ($limite  ){
		
	  if( $this->records >0 ) { 
	    $this->total = ceil( $this->records / $limite ); 
	  } 
	  else { 
	    $this->total = 0; 
	  } 
	  if( $this->page > $this->total ){
	     $this->page = $this->total;
	  }
	  

      $inicio = $limite * $this->page - $limite;
	  
	  if( $inicio < 0 ){
	     $inicio = 0;
	  }
	  	 
	  return $inicio;	 

	}
	
}

?>