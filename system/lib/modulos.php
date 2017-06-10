<?php 

class Modulos extends ModelBase {
	
	public function agregar($dat){
		if($this->db->num_rows($this->db->query("select * from ".MODULOS." where modulo = '".$dat['modulo']."'"))>0){
			return false;
		}else{
				return $this->db->insert($dat, MODULOS);
		}
	}
	
	public function actualizar($dat, $id_modulo){
			return $this->db->update($dat ,MODULOS, " id_modulo = '$id_modulo' " );
	}
		
	public function borrar($id){
		$qid = $this->db->query("select id_modulo, modulo from ".MODULOS." where id_modulo = '$id' ");
		if($this->db->num_rows($qid) > 0 ){ 
			$md = $this->db->fetch_array($qid);
			$this->db->query("delete from ".PERMISOS." where control = '$md[modulo]' ");
			return $this->db->query("delete from ".MODULOS." where id_modulo = '$id' ");
		}else
			return false;
	}
	
	public function obtener($id){
		return  $this->db->fetch_array($this->db->query("select * from ".MODULOS."  where id_modulo = '$id' "));
	}
		
	public function listar(){
		$sql = "select * from ".MODULOS." order by modulo";
		$qid = $this->db->query($sql);
		return $this->db->result_array($qid);
	}
	
	public function listarBox($dfl=""){
		return $this->db->listbox("select * from ".MODULOS." order by modulo", $dfl);
	}
	
	public function obtenerPermiso($control, $metodo, $tipo_usuario){
			$qid = $this->db->query("select id_permiso from ".PERMISOS." where control = '$control' and metodo = '$metodo' ");
			//if($this->db->num_rows($qid)==0)
				//$qid = $this->db->query("select id_permiso from ".PERMISOS." where control = '$control' and  metodo = '*' ");
			if($this->db->num_rows($qid)>0){
				$out = $this->db->fetch_array($qid);
				$pid = $this->db->query("select id_usuario_permiso from ".USUARIOS_PERMISOS." where id_permiso = '".$out['id_permiso']."' and id_tipo_usuario = '$tipo_usuario' ");
				if($this->db->num_rows($pid)>0)
					return 1;
				else
					return 0;
			}else
					return 0;
	}
	
	
	public function cambiar_permiso($modulo, $metodo, $estado, $usuario){
			if($estado){
				$reg['control'] = $modulo;
				$reg['metodo'] = $metodo;
				$dat['id_permiso'] = $this->validarPermiso($modulo, $metodo);
				if($dat['id_permiso'] == false)
					if($this->db->insert($reg, PERMISOS)){
						$dat['id_permiso'] = $this->db->insert_id();
					}
				$dat['id_tipo_usuario'] = $usuario;
				return $this->db->insert($dat, USUARIOS_PERMISOS);
			}else{
				$id_permiso = $this->validarPermiso($modulo, $metodo);
				if($id_permiso != false)
					return $this->db->query("delete from ".USUARIOS_PERMISOS." where id_permiso = '$id_permiso' and id_tipo_usuario = '$usuario'");
			}
	}
	
	public function validarPermiso($control, $metodo){
			$qid = $this->db->query("select id_permiso from ".PERMISOS." where control = '$control' and metodo = '$metodo'");
			if($this->db->num_rows($qid)>0){
				$per = $this->db->fetch_array($qid);
				return $per['id_permiso'];   //ya existe el permiso
			}else
				return false;
	}
	
	public function guardarLog($ip, $ruta, $id_usuario, $error){
			$dat['ip'] = $ip;
			$dat['url'] = addslashes($ruta);
			$dat['fecha'] = date("Y-m-d H:i:s");
			$dat['id_usuario'] = $id_usuario;
			$dat['error'] = addslashes($error);
			return $this->db->insert($dat, LOGS);
	}
				
}

?>