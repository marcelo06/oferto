<?php 

/**
  * modelo Adicionales
  *
  * 
  *
  * @package   adicionales 
  * @author	   Sebastian Lopez
  * @since	   20100519
  * @version   20100519
  */
  

class Adicionales extends ModelBase
{   

    public $dirfile ;
	public $dirfileout ;
	
	function __construct(){
      parent::__construct();
      $this->dirfile = FILES."adicionales/";
	  $this->dirfileout = URLFILES."adicionales/";
   } 
   
   
   
   /**
	 * guardar
	 *
	 * Guarda las adicionales
	 * identidaor
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	int.  
	 */	
	
	public function guardar ( $id =0 ){
		if($id>0)
			$this->db->update($this->datos ,ADICIONALES , "id_adicional = '$id'" );
		else{
			$this->db->insert($this->datos, ADICIONALES );
			$id = $this->db->insert_id();
		}
		
             return $id;
	}
	
	/**
	 * borrar
	 *
	 * Borra el registro de la adicional seleccionada
	 * identidaor de la adicionales
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	boolean.  
	 */	
	
	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_adicional from ".ADICIONALES." where id_adicional = '$id' ")) > 0 ){
       	$this->db->query("delete from ".ADICIONALES." where id_adicional = '$id' ");
			return true;
		}else
			return false;
	}
	
		
	 
	/**
	 * numRegistrosAdicionales
	 *
	 * Cuenta el numero de registro de las adicionales
	 * 
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	int.  
	 */	
	
	
	public function numRegistrosAdicionales(){
	
		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".ADICIONALES." "); 
		$row =  $this->db->fetch_array($result); 
		return $row['count'];
	
	}
	
	
	
		/**
	 * listar
	 *
	 * hace las consulta de las adicionales 
	 * 
	 * @access	public  
	 * @author	Diana 
	 * @since	20110714
	 * @version	20110714
	 * @return 	array.  
	 */	
	
	public function listarAdicionalesPro( $id_producto){

		$sql = "select a.*,p.id_producto FROM  ".ADICIONALES." a left join ".ADICIONALES_PRODUCTO." p on a.id_adicional=p.id_adicional where p.id_producto= $id_producto order by a.id_adicional";
		
		return $this->db->result_array( $this->db->query($sql) );   
		
	}

	public function listarAdicionalesProEmpresa($id_producto=0){
		/*$sql = "SELECT a.*,p.id_empresa FROM ".ADICIONALES." a LEFT JOIN ".PRODUCTOS." p on a.id_producto=p.id_producto";
		$result= $this->db->result_array( $this->db->query($sql) );
		foreach($result as $row){
			$this->db->query("update ".ADICIONALES." set id_empresa=".$row['id_empresa']." where id_adicional = ".$row['id_adicional']);
			$dat=array();
			$dat['id_adicional']= $row['id_adicional'];
			$dat['id_producto']= $row['id_producto'];
			$this->db->insert($dat, ADICIONALES_PRODUCTO);
		}*/
		//print_r($result);


		$sql = "SELECT p.id_producto, a . * FROM ".ADICIONALES." a LEFT JOIN (SELECT * FROM ".ADICIONALES_PRODUCTO." WHERE id_producto =$id_producto) AS p ON a.id_adicional = p.id_adicional where a.id_empresa=".$_SESSION['id_empresa']." ORDER BY id_adicional";
		return $this->db->result_array( $this->db->query($sql) );

		

	}
	
	
	public function numAdicionalesPro($id_producto) {
	$sql = "select a.*,p.id_producto FROM  ".ADICIONALES." a left join ".ADICIONALES_PRODUCTO." p on a.id_adicional=p.id_adicional where p.id_producto= $id_producto order by a.id_adicional";
	return $this->db->num_rows( $this->db->query($sql) );
	}
	
	
    /**
	 * obtener
	 *
	 * obtiene la informacion de un registro
	 * id(identificador de la adicional)
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	public function obtener($id){
		return $this->datos = $this->db->fetch_array($this->db->query("select * FROM ".ADICIONALES." where id_adicional= $id"));
	} 
	
	
	
	/**
	 * listarSQL
	 *
	 * lista todas las adicionales manda el una cadena con la consulta, sin query
	 * 
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	
	public function listarSQL($sql=""){
		return "select * from ".ADICIONALES."  order by id_adicional desc ";	
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
	 * lista las n ultimas adicionales
	 * inicio de la busqueda y la cantida que va a sacar
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	public function listarUltimas($inicio=0,$cantidad=2){
		$sql = "select * from ".ADICIONALES." order by id_adicional desc limit $inicio, $cantidad";
		$qid = $this->db->query($sql);
		return $this->db->result_array($qid);
	}


	public function buscar($buscar=''){

	    $busqueda = " where 1 = 1 ";
		if($buscar != ""){
			$busqueda.= " and (ap.valor LIKE '%$buscar%')";
		}
	
		$sql = "select * from ".ADICIONALES." p join ".PRODUCTOS." i on i.id_producto= p.id_producto $busqueda) apt on apt.id_tipo_adicional = t.id_tipo_adicional order by apt.nombre";
		
		return $this->db->result_array( $this->db->query($sql) );   
		
	}

	public function guardarAdicionalProducto ($datos,$id_producto ){
		
		$this->db->query("delete from ".ADICIONALES_PRODUCTO." where id_producto = '$id_producto' ");
		$ndatos= count($datos);
		if($ndatos){
			for($i=0;$i<count($datos); $i++)
			{
				$adic= nvl($datos[$i],0);
				if($adic){
				
				$dadic['id_producto'] = $id_producto;
				$dadic['id_adicional'] = $adic['id_adicional'];
				$this->db->insert($dadic, ADICIONALES_PRODUCTO );
				}
			}	
		}
	
	}
	

	

	
}

?>