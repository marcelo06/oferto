<?php 


class Mailings extends ModelBase
{
	
	
	public function guardar ( $id =0 ){
		if($id>0){
			$this->db->update($this->datos ,MAILINGS , "id_mailing = '$id' " );
		}else{
			$this->db->insert($this->datos, MAILINGS );
			$id = $this->db->insert_id();
		}
         return $id;
	}

	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_mailing from ".MAILINGS." where id_mailing = '$id' ")) > 0 ){
			$this->db->query("delete from ".MAILINGS." where id_mailing = '$id' ");
			return true;
		}else
			return false;
 	}
	
	
	public function obtener($id){
		return $this->datos = $this->db->fetch_array($this->db->query("select * from ".MAILINGS." where id_mailing = '$id' "));
	} 

	public function obtenerEmpresa($id,$tipo=1){
		return  $this->db->fetch_array($this->db->query("select * from ".MAILINGS." where id_empresa = '$id' and tipo=$tipo "));
	}


	public function listar($id_empresa=0 ){

	    $sql = "SELECT * FROM ".MAILINGS." where id_empresa=$id_empresa order by id_mailing desc ";

		return $this->db->result_array( $this->db->query($sql) );   

	}

	
	public function numRegistros(){
		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".MAILINGS." WHERE id_empresa = '".$_SESSION['id_empresa']."'  "); 
		$row =  $this->db->fetch_array($result); 
		return $row['count'];
	}
	
	
	public function listarMailing($orden="id_mailing" , $direccion = "", $start, $limit ){
	
	    $sql = "SELECT * FROM ".MAILINGS." WHERE  id_empresa = '".$_SESSION['id_empresa']."'  order by $orden desc LIMIT  $start, $limit ";
		return $this->db->result_array( $this->db->query($sql) );   
		
	}

	public function cambiarEstado($estado='',$log='',$id){
		$update=" fecha='".date('y-m-d h:i:s')."', log='$log' ";
		if($estado!='')
			$update.=", estado='$estado' ";
		if($this->db->num_rows($this->db->query("select id_mailing from ".MAILINGS." where id_mailing = '$id' ")) > 0 ){
			return $this->db->query("update ".MAILINGS." set $update where id_mailing = '$id' ");
		}else
		return false;
	}

}

?>