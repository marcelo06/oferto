<?php 

/**
  * modelo Categorias
  *
  * 
  *
  * @package   categorias 
  * @author	   Sebastian Lopez
  * @since	   20100519
  * @version   20100519
  */
  

class Categorias extends ModelBase
{   

    public $dirfile ;
	public $dirfileout ;
	
	function __construct(){
      parent::__construct();
      $this->dirfile = FILES."categorias/";
	  $this->dirfileout = URLFILES."categorias/";
   } 
   
   
   
   /**
	 * guardar
	 *
	 * Guarda las categorias
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
			$this->db->update($this->datos ,CATEGORIA , "id_categoria = '$id'" );
		else{
			$this->db->insert($this->datos, CATEGORIA );
			$id = $this->db->insert_id();
		}
             return $id;
	}
	
	
	public function guardarCategoriaProducto ($datosserv,$id_producto ){
		
		$this->db->query("delete from ".CATEGORIA_PRODUCTO." where id_producto = '$id_producto' ");
		$datos= count($datosserv);
		if($datos)
		{
			for($i=0;$i<count($datosserv); $i++)
			{
				$serv= nvl($datosserv[$i],0);
				if($serv)
				{
				
				$serv_al['id_producto'] = $id_producto;
				$serv_al['id_categoria'] = $serv['id_categoria'];
				$this->db->insert($serv_al, CATEGORIA_PRODUCTO );
				}
			}	
		}
	
	}
	
	/**
	 * borrar
	 *
	 * Borra el registro de la categoria seleccionada
	 * identidaor de la categorias
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	boolean.  
	 */	
	
	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_categoria from ".CATEGORIA." where id_categoria = '$id' ")) > 0 ){
               		   
			$this->db->query("delete from ".CATEGORIA." where id_categoria = '$id' ");
			return true;
		}else
			return false;
	}
	
	
	/**
	 * numRegistrosCategorias
	 *
	 * Cuenta el numero de registro de las categorias
	 * 
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	int.  
	 */	
	
	
	public function numRegistrosCategorias(){
	
		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".CATEGORIA." "); 
		$row =  $this->db->fetch_array($result); 
		return $row['count'];
	
	}
	
	
	/**
	 * listarCategorias
	 *
	 * hace las consulta de las categorias para el listado del grid
	 * orden(parametro de ordenamiento), direccion(asc,desc), start(comienzo de la consulta), limit(cantidad de registro por consulta)
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	public function listarCategorias($orden="id_categoria" , $direccion = "asc", $start, $limit, $buscar=''  ){
	    $busqueda = " where 1 = 1 ";
		if($buscar != ""){
			$busqueda.= " and categoria LIKE '%$buscar%' ";
		}
	
		$sql = "select * FROM ".CATEGORIA." $busqueda order by $orden $direccion LIMIT  $start, $limit ";
		return $this->db->result_array( $this->db->query($sql) );   
	}
	
	/**
	 * listarCategorias
	 *
	 * hace las consulta de las categorias para el listado del grid
	 * orden(parametro de ordenamiento), direccion(asc,desc), start(comienzo de la consulta), limit(cantidad de registro por consulta)
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	public function listarCategoriasProducto($id_producto=0){
		$sql = "SELECT p.id_producto, c . * FROM ".CATEGORIA." c LEFT JOIN (SELECT * FROM ".CATEGORIA_PRODUCTO." WHERE id_producto =$id_producto) AS p ON c.id_categoria = p.id_categoria where c.id_empresa=".$_SESSION['id_empresa']." ORDER BY id_categoria";
		return $this->db->result_array( $this->db->query($sql) );   
	}
	
	
	public function obtenerProductoCategoria($id_producto=0){  
		$sql = "SELECT p.*,c.* FROM ".CATEGORIA_PRODUCTO."  p JOIN ".CATEGORIA." c on p.id_categoria=c.id_categoria WHERE p.id_producto =$id_producto ORDER BY c.categoria";	
		return $this->db->result_array( $this->db->query($sql) );   	
	}
	
	/* 
	* obtener el numero de productos en una categoria
	*/
	public function numProductosCategoria($categoria){
		$busqueda = " where  borrado='0' and estado<>'Inactivo'  and id_empresa=".$_SESSION['id_empresa'];
		
		$sql= " SELECT c.* from ".CATEGORIA_PRODUCTO."  c  join ".PRODUCTOS." p  on p.id_producto=c.id_producto  $busqueda and c.id_categoria=".$categoria;		 
		 return $this->db->num_rows( $this->db->query($sql));
	}
	
	/**
	 * listar
	 *
	 * hace las consulta de las categorias 
	 * 
	 * @access	public  
	 * @author	Diana 
	 * @since	20110714
	 * @version	20110714
	 * @return 	array.  
	 */	
	
	public function listar($id_empresa=0 ){
	   if($id_empresa)
	   $busq= " where id_empresa=  ".$id_empresa;
	   else
	   $busq= "";
	   
	   $sql = "select * FROM ".CATEGORIA." $busq order by id_categoria ";
		
		return $this->db->result_array( $this->db->query($sql) );   	
	}
	
    /**
	 * obtener
	 *
	 * obtiene la informacion de un registro
	 * id(identificador de la categoria)
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	public function obtener($id){
		return $this->datos = $this->db->fetch_array($this->db->query("select * from ".CATEGORIA." where id_categoria = '$id' order by id_categoria"));
	} 
	
	public function obtenerIdPorNombre($categoria){
		$sql = "SELECT * FROM ".CATEGORIA." WHERE  categoria = '$categoria'";
		$ase = $this->db->query($sql);
		if($this->db->num_rows($ase) >0){ 
			$asesor= $this->db->fetch_array($ase);
			return $asesor['id_categoria'];
		}else
			return 0;
	}
	
	
	/**
	 * listarSQL
	 *
	 * lista todas las categorias manda el una cadena con la consulta, sin query
	 * 
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	
	public function listarSQL($sql=""){
		return "select * from ".CATEGORIA."  order by id_categoria ";	
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
	
	
	public function listBoxCategorias($default="")
	{
		return $this->db->listbox("select id_categoria, categoria from ".CATEGORIA." order by categoria ",$default);
	}

	public function busqueda($texto){
		 $sql = "select * FROM ".CATEGORIA." where categoria like '%$texto%' order by categoria,id_categoria ";
		return $this->db->result_array( $this->db->query($sql) );   	   
	}

	
	
}

?>