<?php 


class Contenidos extends ModelBase
{
	
	
	public function guardar ( $id =0 ){
		if($id>0){
			$this->db->update($this->datos ,CONTENIDOS , "id_contenido = '$id' " );
		}else{
			$this->db->insert($this->datos, CONTENIDOS );
			$id = $this->db->insert_id();
		}
         return $id;
	}

	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_contenido from ".CONTENIDOS." where id_contenido = '$id' ")) > 0 ){
			$this->db->query("delete from ".CONTENIDOS." where id_contenido = '$id' ");
			return true;
		}else
			return false;
 	}
	
	
	public function obtener($id){
		return $this->datos = $this->db->fetch_array($this->db->query("select * from ".CONTENIDOS." where id_contenido = '$id' "));
	} 

	public function obtenerEmpresa($id,$tipo=1){
		return  $this->db->fetch_array($this->db->query("select * from ".CONTENIDOS." where id_empresa = '$id' and tipo=$tipo "));
	}


	public function listar( ){

	    $sql = "SELECT * FROM ".CONTENIDOS." order by id_contenido desc ";

		return $this->db->result_array( $this->db->query($sql) );   

	}

	
	public function numRegistros(){
		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".CONTENIDOS." WHERE id_empresa = '".$_SESSION['id_empresa']."'  "); 
		$row =  $this->db->fetch_array($result); 
		return $row['count'];
	}
	
	
	public function listarContenido($orden="id_contenido" , $direccion = "", $start, $limit ){
	
	    $sql = "SELECT * FROM ".CONTENIDOS." WHERE  id_empresa = '".$_SESSION['id_empresa']."'  order by $orden desc LIMIT  $start, $limit ";
		return $this->db->result_array( $this->db->query($sql) );   
		
	}

}

?>