<?php 

class Secured extends ModelBase {
	
	public function permisoUsuario($id_usuario, $control, $metodo){
		$sqli = "
		SELECT u.id_tipo_usuario
		FROM ".PERMISOS." p INNER JOIN ".USUARIOS_PERMISOS." up ON p.id_permiso = up.id_permiso INNER JOIN ".USUARIOS." u ON u.id_tipo_usuario = up.id_tipo_usuario
		WHERE  p.control = '{$control}' and p.metodo = '{$metodo}'  and u.id_usuario = '{$id_usuario}' and p.tipo = 'Permitir' 
		";
		$qid = $this->db->query($sqli);
		$nm = $this->db->num_rows($qid);
		
		if($nm >0)
			return true;
		else{
			$sql = "
			SELECT u.id_tipo_usuario, p.control, p.metodo, p.id_permiso
			FROM ".PERMISOS." p INNER JOIN ".USUARIOS_PERMISOS." up ON p.id_permiso = up.id_permiso INNER JOIN ".USUARIOS." u ON u.id_tipo_usuario = up.id_tipo_usuario
			WHERE  ( p.control = '{$control}' ) and  (p.metodo = '{$metodo}' )  and p.tipo = 'Permitir' 
			";
			
			$sal = $this->db->result_array($this->db->query($sql));
							
			foreach($sal as $pr){
				if($pr['control'] == $control && $pr['metodo'] == $metodo ){
					$tipo_usuario = $pr['id_tipo_usuario'];
					if($tipo_usuario == 1)
						return true;
				}else   
					$tipo_usuario= $pr['id_tipo_usuario'];
			}

			if(!isset($tipo_usuario) ){
				$log = new Modulos();
				$log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], "Intento de ejecucion $control->$metodo sin permisos");
				return false;
			}
			
			if($tipo_usuario == 1)
				return true;
				
			$usr = new Usuarios();
			$tu = $usr->obtenerTipoUsuario($id_usuario);
			if($tu == $tipo_usuario )
				return true;
			else{
				$log = new Modulos();
				$log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], "Intento de ejecucion $control->$metodo sin permisos");
				return false;
			}
		}
	}
		
	public function asegurarSesion(){
		$fingerprint = 'RHISSNET' . $_SERVER['HTTP_USER_AGENT'];
		$_SESSION['fingerprint'] = md5($fingerprint . session_id());
	}
	
}

?>