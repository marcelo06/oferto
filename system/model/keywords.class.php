<?php 

/**
  * modelo Keywords
  *
  * 
  *
  * @package   keywords 
  * @author	   Sebastian Lopez
  * @since	   20100519
  * @version   20100519
  */
  

class Keywords extends ModelBase
{   

    public $dirfile ;
	public $dirfileout ;
	
	function __construct(){
      parent::__construct();
      $this->dirfile = FILES."keywords/";
	  $this->dirfileout = URLFILES."keywords/";
   } 
   
   
   /**
	 * guardar
	 *
	 * Guarda las keywords
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
			$this->db->update($this->datos ,KEYWORD , "id_keyword = '$id'" );
		else{
			$this->db->insert($this->datos, KEYWORD );
			$id = $this->db->insert_id();
		}
             return $id;
	}
	
	public function existeKeyword($texto){
		$sql = "select * FROM ".KEYWORD." where keyword ='$texto' ";
		$row=$this->db->fetch_array( $this->db->query($sql));
		if(isset($row['id_keyword']))
			return $row;
		else
			return false;   	   
	}

	public function esStopword($texto){
		$sql = "select * FROM ".KEYWORD_STOPWORD." where stopword ='$texto' ";
		$row=$this->db->fetch_array( $this->db->query($sql));
		if(isset($row['id_stopword']))
			return $row;
		else
			return false;   	   
	}

	public function guardarKeywordProducto ($id_keyword,$id_producto ){
		$datos['id_producto'] = $id_producto;
		$datos['id_keyword'] = $id_keyword;
		$this->db->insert($datos, KEYWORD_PRODUCTO);
	}

	

	public function borrarKeywordsProducto ($id_producto){
		return $this->db->query("delete from ".KEYWORD_PRODUCTO." where id_producto = '$id_producto' ");
	
	}
	
	/**
	 * borrar
	 *
	 * Borra el registro de la keyword seleccionada
	 * identidaor de la keywords
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	boolean.  
	 */	
	
	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_keyword from ".KEYWORD." where id_keyword = '$id' ")) > 0 ){
               		   
			$this->db->query("delete from ".KEYWORD." where id_keyword = '$id' ");
			return true;
		}else
			return false;
	}
	
	
	/**
	 * numRegistrosKeywords
	 *
	 * Cuenta el numero de registro de las keywords
	 * 
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	int.  
	 */	
	
	
	public function numRegistrosKeywords(){
		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".KEYWORD." "); 
		$row =  $this->db->fetch_array($result); 
		return $row['count'];
	
	}

	/**
	 * listar
	 *
	 * hace las consulta de las keywords 
	 * 
	 * @access	public  
	 * @author	Diana 
	 * @since	20110714
	 * @version	20110714
	 * @return 	array.  
	 */	
	
	public function listar(){	
	   $busq= "";   
	   $sql = "select * FROM ".KEYWORD." $busq order by id_keyword ";	
		return $this->db->result_array( $this->db->query($sql) );   	
	}
	

	
	/**
	 * listarKeywords
	 *
	 * hace las consulta de las keywords para el listado del grid
	 * orden(parametro de ordenamiento), direccion(asc,desc), start(comienzo de la consulta), limit(cantidad de registro por consulta)
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	public function listarKeywordsProducto($id_producto=0){
		$sql = "SELECT k.* FROM ".KEYWORD_PRODUCTO." kp left join ".KEYWORD." k on k.id_keyword=kp.id_keyword WHERE kp.id_producto =$id_producto";
		return $this->db->result_array( $this->db->query($sql) );   
	}
	
    /**
	 * obtener
	 *
	 * obtiene la informacion de un registro
	 * id(identificador de la keyword)
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	public function obtener($id){
		return $this->datos = $this->db->fetch_array($this->db->query("select * from ".KEYWORD." where id_keyword = '$id' order by id_keyword"));
	} 
	
	
	public function listBoxKeywords($default=""){
		return $this->db->listbox("select id_keyword, keyword from ".KEYWORD." order by keyword ",$default);
	}

	
	public function buscarKeyword($texto){
		 $sql = "select * FROM ".KEYWORD." where keyword RLIKE '[[:<:]]".$texto."'  order by keyword,id_keyword ";
		return $this->db->result_array( $this->db->query($sql) );   	   
	}

	public function existeBusqueda($texto){
		$sql = "select * FROM ".KEYWORD_BUSQUEDA." where busqueda ='$texto' ";
		$row=$this->db->fetch_array( $this->db->query($sql));
		if(isset($row['id_busqueda']))
			return $row;
		else
			return false;   	   
	}

	public function guardarBusqueda($datos,$id=0){
		if($id>0)
			$this->db->update($datos ,KEYWORD_BUSQUEDA , "id_busqueda = '$id'" );
		else{
			$this->db->insert($datos, KEYWORD_BUSQUEDA );
			$id = $this->db->insert_id();
		}
        return $id;
	}

	public function guardarStopword ($stopword ){
		$sql = "select * FROM ".KEYWORD_STOPWORD." where stopword ='$stopword' ";
		$row=$this->db->fetch_array( $this->db->query($sql));
		if(!isset($row['id_stopword']) and $stopword!=''){
			$datos['stopword'] = $stopword;
			$this->db->insert($datos, KEYWORD_STOPWORD);
		}
		
	}


	
}

?>