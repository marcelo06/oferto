<?php 

/**
  * Model configuraciones
  *
  * 
  *
  * @package   configmodel 
  * @author	   Julian Vega
  * @since	   20100909
  * @version   20100909
  */

class Configmodel extends ModelBase
{
	
    
	/**
	  * guardar_valor
	  *
	  * actualiza los registros en la tabla de core_config
	  *
	  * @access	   public 	 
	  * @author	   Julian Vega
	  * @since	   20100909
	  * @version   20100909
	  * @return    bool.  
	  */
	
	public function guardar_valor ( $tipo, $valor){
		$q = $this->db->query('SELECT tipo FROM '.CONFIG.' WHERE tipo = \''.$tipo.'\' ');
		if($this->db->num_rows($q) > 0 ){
			$datos['valor'] = $valor;
			$this->db->update($datos ,CONFIG, "tipo = '$tipo' " );
			return true;
		}else
			return false;
	}
	
	/**
	  * obtener_valor
	  *
	  * obtiene los registros en la tabla de core_config del tipo dado
	  *
	  * @access	   public 	 
	  * @author	   Julian Vega
	  * @since	   20100909
	  * @version   20100909
	  * @return    bool.  
	  */
	
	public function obtener_valor($tipo){
		$q = $this->db->query('select valor from '.CONFIG.' where tipo = \''.$tipo.'\' ');
		$sal = $this->db->fetch_array($q);
		return $sal['valor'];
	}
	
	/**
	  * obtener_config
	  *
	  * obtiene los registros en la tabla de core_config 
	  *
	  * @access	   public 	 
	  * @author	   Julian Vega
	  * @since	   20100909
	  * @version   20100909
	  * @return    bool.  
	  */
	
	public function obtener_config(){
		$q = $this->db->query('select tipo, valor from '.CONFIG.'  order by id_config');
		$sal = $this->db->result_array($q);
		return $sal;
	}

	public function actualizar_version(){
		$this->db->query("update ".VERSIONES." set actualizado=NOW() where tipo='redes' ");
	}
	
	
	

}

?>