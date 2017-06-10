<?php 

/**
  * modelo Puntos
  *
  * 
  *
  * @package   puntoes 
  * @author	   Sebastian Lopez
  * @since	   20100519
  * @version   20100519
  */
  

class Puntos extends ModelBase
{   

   /**
	 * guardar
	 *
	 * Guarda los puntos
	 * identidaor
	 *
	 */	
	
	public function guardar ( $id =0 ){
		if($id>0)
			$this->db->update($this->datos ,PUNTOS , "id_puntos = '$id'" );
		else{
			$this->db->insert($this->datos, PUNTOS );
			$id = $this->db->insert_id();
		}
		
		if(isset($this->datos['atr']))
		$this->guardarPuntos($id);
		
             return $id;
	}
	
	public function sumarPuntos ($id_usuario,$puntos){
		$id_puntos=0;
		$this->datos['id_usuario']=$id_usuario;
		$this->datos['ultima_fecha']=date('Y-m-d');

		$result = $this->db->query("SELECT * FROM ".PUNTOS." where id_usuario = $id_usuario" ); 
		$row =  $this->db->fetch_array($result); 
		if(nvl($row['id_puntos'],0)){
			$id_puntos=$row['id_puntos'];
			$this->datos['puntos']=$row['puntos']+$puntos;
		}
		else{
			$this->datos['puntos']=$puntos;
		}
		$id_puntos=$this->guardar($id_puntos);
		return $id_puntos;
	}
	
	/**
	 * borrar
	 *
	 * Borra el registro de la punto seleccionada
	 * identidaor de la puntoes
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	boolean.  
	 */	
	
	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_puntos from ".PUNTOS." where id_puntos = '$id' ")) > 0 ){
       	$this->db->query("delete from ".PUNTOS." where id_puntos = '$id' ");
			return true;
		}else
			return false;
	}
	
		
	 
	/**
	 * numRegistrosPuntos
	 *
	 * Cuenta el numero de registro de las puntoes
	 * 
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	int.  
	 */	
	
	
	public function numRegistrosPuntos(){
	
		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".PUNTOS." "); 
		$row =  $this->db->fetch_array($result); 
		return $row['count'];
	
	}
	
	
	/**
	 * listarPuntos
	 *
	 * hace las consulta de las puntoes para el listado del grid
	 * orden(parametro de ordenamiento), direccion(asc,desc), start(comienzo de la consulta), limit(cantidad de registro por consulta)
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	public function listarPuntos($orden="id_puntos" , $direccion = "", $start, $limit, $buscar='', $id_producto  ){

	    $busqueda = " where 1 = 1 ";
		if($buscar != ""){
			$busqueda.= " and (punto LIKE '%$buscar%')";
		}
	
		$sql = "select * FROM ".PUNTOS."  ".$busqueda." and id_producto= $id_producto order by $orden $direccion LIMIT  $start, $limit ";
			
		return $this->db->result_array( $this->db->query($sql) );   
		
	}
	
	
	
	
	
    /**
	 * obtener
	 *
	 * obtiene la informacion de un registro
	 * id(identificador de la punto)
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	public function obtener($id){
		return $this->db->fetch_array($this->db->query("select * FROM ".PUNTOS." where id_puntos= $id"));
	} 

	public function obtenerPuntosUsuario($id_usuario){
		return $this->db->fetch_array($this->db->query("select p.*,u.nombre as usuario FROM ".PUNTOS." p left join ".PERFIL." u on p.id_usuario=u.id_usuario where p.id_usuario= $id_usuario"));
	}
	
	
	
	/**
	 * listarSQL
	 *
	 * lista todas las puntoes manda el una cadena con la consulta, sin query
	 * 
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	
	public function listarSQL($sql=""){
		return "select * from ".PUNTOS."  order by id_puntos desc ";	
	}
	
	
	/**
	 * resultArr
	 *
	 * realiza el resulta array sobre un query que recive
	 * $qid(query de la consulta)
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	

	
	public function resultArr($qid){
	return $this->db->result_array($qid);
	}
	
 
	
	/**
	 * listarUltimas
	 *
	 * lista las n ultimas puntoes
	 * inicio de la busqueda y la cantida que va a sacar
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	public function listarUltimas($inicio=0,$cantidad=2){
		$sql = "select * from ".PUNTOS." order by id_puntos desc limit $inicio, $cantidad";
		$qid = $this->db->query($sql);
		return $this->db->result_array($qid);
	}
	
	

	public function obtenerPuntos($id_puntos)
	{
		 $sql = "select ap.*, at.atributo from bf_atributo_punto ap join
	 bf_atributo_tipo at on ap.id_atributo_tipo = at.id_atributo_tipo and ap.id_puntos=".$id_puntos;
		return $this->db->result_array($this->db->query($sql));
	}	



	public function buscar($buscar=''){

	    $busqueda = " where 1 = 1 ";
		if($buscar != ""){
			$busqueda.= " and (ap.valor LIKE '%$buscar%')";
		}
	
		$sql = "select * from ".PUNTOS." p join ".PRODUCTOS." i on i.id_producto= p.id_producto $busqueda) apt on apt.id_tipo_punto = t.id_tipo_punto order by apt.nombre";
		
		return $this->db->result_array( $this->db->query($sql) );   
		
	}
	

	

	
}

?>