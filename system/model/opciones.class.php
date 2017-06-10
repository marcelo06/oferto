<?php 

/**
  * modelo Opciones
  *
  * 
  *
  * @package   opciones 
  * @author	   Sebastian Lopez
  * @since	   20100519
  * @version   20100519
  */
  

class Opciones extends ModelBase
{   

    public $dirfile ;
	public $dirfileout ;
	
	function __construct(){
      parent::__construct();
      $this->dirfile = $_SERVER['DOCUMENT_ROOT']."/uploads/";
	  $this->dirfileout = URLFILES."opciones/";
   } 
   
   
   
   /**
	 * guardar
	 *
	 * Guarda las opciones
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
			$this->db->update($this->datos ,OPCIONES , "id_adicional_opcion = '$id'" );
		else{
			$this->db->insert($this->datos, OPCIONES );
			$id = $this->db->insert_id();
		}
             return $id;
	}
	
 

	/**
	 * borrar
	 *
	 * Borra el registro de la opcion seleccionada
	 * identidaor de la opciones
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	boolean.  
	 */	
	
	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_adicional_opcion from ".OPCIONES." where id_adicional_opcion = '$id' ")) > 0 ){
               		   
			
			$this->db->query("delete from ".OPCIONES." where id_adicional_opcion = '$id'");
			return true;
		}else
			return false;
	}
	
	public function borrarOpcionesAdicional($id_adicional){
		if($this->db->num_rows($this->db->query("select id_adicional_opcion from ".OPCIONES." where id_adicional = '$id_adicional' ")) > 0 ){
			$this->db->query("delete from ".OPCIONES." where id_adicional = '$id_adicional'");
			return true;
		}else
			return false;
	}
	
	 
	/**
	 * numRegistrosOpciones
	 *
	 * Cuenta el numero de registro de las opciones
	 * 
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	int.  
	 */	
	
	
	public function numRegistrosOpciones(){
	
		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".OPCIONES." "); 
		$row =  $this->db->fetch_array($result); 
		return $row['count'];
	
	}
	
	
		public function numOpcionesAdicional($id_adicional){
	
		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".OPCIONES." where id_adicional =".$id_adicional); 
		$row =  $this->db->fetch_array($result); 
		return $row['count'];
	
	}
	
	
	
	
		/**
	 * listar
	 *
	 * hace las consulta de las opciones 
	 * 
	 * @access	public  
	 * @author	Diana 
	 * @since	20110714
	 * @version	20110714
	 * @return 	array.  
	 */	
	
	public function listar( $adicional){

	   $sql = "select d.*  FROM ".OPCIONES." as d  where id_adicional= $adicional order by id_adicional_opcion";
		return $this->db->result_array( $this->db->query($sql) );   
		
	}
	
	public function boxOpciones($id_adicional=0, $default='')
	 {
		  $sql = "select id_adicional_opcion,opcion FROM ".OPCIONES." where id_adicional=$id_adicional ";
		return $this->db->listbox( $sql,$default );
	}
	
	
    /**
	 * obtener
	 *
	 * obtiene la informacion de un registro
	 * id(identificador de la opcion)
	 *
	 * @access	public  
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.  
	 */	
	
	public function obtener($id){
		return $this->datos = $this->db->fetch_array($this->db->query("select *  FROM ".OPCIONES." as d  join ".ADICIONALES." p on d.id_adicional= p.id_adicional  join ".ADICIONALES_PRODUCTO." i on i.id_adicional=p.id_adicional where d.id_adicional_opcion = '$id'"));
	} 
	
	public function existeOpcionProducto($id_pro, $ident_opt){
		return $this->datos = $this->db->fetch_array($this->db->query("SELECT i.opcion, i.nombre, i.tipo_opcion, p.id_adicional,d.id_adicional_opcion ,d.opcion as docid FROM ".PRODUCTOS." i join ".ADICIONALES." p on i.id_producto= p.id_producto join ".OPCIONES." d on p.id_adicional= d.id_adicional where i.id_producto= $id_pro and d.opcion= '$ident_opt'"));
	}
	
	
	
	
	

}

?>