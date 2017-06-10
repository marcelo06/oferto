<?php 

class Usuarios extends ModelBase {
	
	// Modificado
	public function agregar($dat,$id_empresa='',$clioferto=0,$id_tipo=0){
		if($this->validarNombreUsuario($dat['_username'],$id_empresa,$clioferto,$id_tipo) ){
			return false;
		}else{
			
			if( $this->db->insert($dat, USUARIOS)){
				return $this->db->insert_id();
			}else{
				return false;
			}
		}
	}
	
	public function actualizar($dat, $id_usuario){		
		return $this->db->update($dat ,USUARIOS, " id_usuario = '$id_usuario' " );
	}
	
	public function agregarPerfil($dat){		
		return $this->db->insert($dat ,PERFIL );
	}
	
	public function actualizarPerfil($dat, $id_usuario){		
		if($this->db->num_rows($this->db->query("select id_usuario from ".PERFIL." where id_usuario = '$id_usuario' ")) > 0 ){
			return $this->db->update($dat ,PERFIL, " id_usuario = '$id_usuario' " );
		}else{
			$dat['id_usuario'] = $id_usuario;
			return $this->db->insert($dat ,PERFIL );
		}
	}
	
	
	
	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_usuario from ".USUARIOS." where id_usuario = '$id' ")) > 0 ){
			return $this->db->query("update ".USUARIOS." set borrado='1' where id_usuario = '$id' ");
		}else
		return false;
	}
	
	public function obtener($id){
		$sql = "
		SELECT u.*,p.*,t.*,pa.nombre as pais,de.dpto as departamento,ci.ciudad 
		FROM ".USUARIOS." u 
		LEFT JOIN ".PERFIL." p ON p.id_usuario = u.id_usuario
		LEFT JOIN ".TIPO_USUARIOS." t ON t.id_tipo_usuario = u.id_tipo_usuario
		left join ".CLI_PAISES." pa on p.id_pais=pa.id_pais 
		left join ".CLI_DPTOS." de on p.id_dpto=de.id_dpto 
		left join ".CLI_CIUDADES." ci on p.id_ciudad=ci.id_ciudad 
		WHERE u.id_usuario = '$id' 
		";
		$qid = $this->db->query($sql);
		return $this->db->fetch_assoc($qid);
	}
	public function obtenerEmpOferto($id){
		$sql = "
		SELECT u.*,p.*,t.*,pa.nombre as pais,de.dpto as departamento,ci.ciudad ,s.suscrito
		FROM ".USUARIOS." u 
		LEFT JOIN ".PERFIL." p ON p.id_usuario = u.id_usuario
		LEFT JOIN ".TIPO_USUARIOS." t ON t.id_tipo_usuario = u.id_tipo_usuario
		left join ".CLI_PAISES." pa on p.id_pais=pa.id_pais 
		left join ".CLI_DPTOS." de on p.id_dpto=de.id_dpto 
		left join ".CLI_CIUDADES." ci on p.id_ciudad=ci.id_ciudad 
		left join (select * from ".USUARIOS_EMPRESA." where id_usuario=$id and id_empresa=".$_SESSION['id_empresa'].") as s on u.id_usuario=s.id_usuario
		WHERE u.id_usuario = '$id' 
		group by u.id_usuario
		";
		$qid = $this->db->query($sql);
		return $this->db->fetch_assoc($qid);
	}
	public function obtenerIdUsuario($usuario,$id_empresa='',$clioferto=0,$id_tipo=0){
		$empresa='';

		if($id_empresa!=''){
			$empresa=" and id_empresa=$id_empresa ";
		}
		if($clioferto)
			$empresa.=" and id_empresa=0 and id_tipo_usuario=5 ";

		if($id_tipo)
		$empresa.=" and id_tipo_usuario=$id_tipo ";	
			

		$sql="select id_usuario from ".USUARIOS." where CONVERT(_username USING latin1) = '$usuario' and borrado='0' $empresa ";

		$qid = $this->db->query($sql);
		$out = $this->db->fetch_assoc($qid);
		return $out['id_usuario'];
	}
	
	public function obtenerPorEmpresa($id){
		$sql = "
		SELECT * 
		FROM ".USUARIOS." u 
		LEFT JOIN ".PERFIL." p ON p.id_usuario = u.id_usuario
		LEFT JOIN ".TIPO_USUARIOS." t ON t.id_tipo_usuario = u.id_tipo_usuario
		WHERE u.id_empresa = '$id'  and u.id_tipo_usuario=4
		";
		$qid = $this->db->query($sql);
		return $this->db->fetch_assoc($qid);
	}
	
	public function obtenerCorreo($id_usuario){
		$sql = "
		SELECT * 
		FROM ".USUARIOS." u 
		WHERE u.id_usuario = '$id_usuario' 
		";
		$qid = $this->db->query($sql);
		$out = $this->db->fetch_assoc($qid);
		return $out['email'];
	}
	
	public function obtenerTipoUsuario($id_usuario){
		$tp =  $this->db->fetch_array($this->db->query("select id_tipo_usuario from ".USUARIOS." where id_usuario = '$id_usuario' "));
		return $tp['id_tipo_usuario'];
	}
	
	public function obtenerNombreTipoUsuario($id){
		$tp =  $this->db->fetch_array($this->db->query("select tipo_usuario from ".TIPO_USUARIOS." where id_tipo_usuario = '$id' "));
		return $tp['tipo_usuario']; 
	}
	
	
	public function listar(){
		$sql = "select u.id_usuario as idusuario, u.* from ".USUARIOS." u  where u.id_usuario <> 1 and borrado='0'  order by u.id_tipo_usuario ";
		$qid = $this->db->query($sql);
		return $this->db->result_array($qid);
	}
	
	
	public function cambiarEstado($id_usuario, $estado){
		return $this->db->query("update  ".USUARIOS." set estado='$estado' where id_usuario='$id_usuario'");
	}
	
	public function validarUsuario($user, $pass,$id_empresa='',$id_tipo='',$clioferto=0){
		$empresa='';
		if($id_empresa!='')
			$empresa=" and id_empresa=$id_empresa ";
		
		if($clioferto){
			$empresa=" and id_empresa=0 ";
		}

		$tipo='';
		if($id_tipo!='')
			$tipo=" and id_tipo_usuario=$id_tipo ";
		else
			$tipo=" and (id_tipo_usuario=4 or id_tipo_usuario=2 or id_tipo_usuario=3  or id_tipo_usuario=6) ";


		$sql="select u.* ,p.nombre from ".USUARIOS."  u left join ".PERFIL." p on u.id_usuario=p.id_usuario where CONVERT(_username USING latin1) = '$user' and u.estado = '1' and u.borrado='0' $empresa $tipo";
		//echo $sql;
		$usr = $this->db->fetch_object($this->db->query($sql));
		$hash=nvl($usr->_password);
		//echo crypt($pass,$hash);
		if(crypt($pass, $hash)===$hash){
			$dat['id_usuario'] = $usr->id_usuario;
			$dat['nombre'] = $usr->nombre;		
			$dat['id_tipo_usuario'] = $usr->id_tipo_usuario;	
			$dat['id_empresa'] = $usr->id_empresa;	
			return $dat;
		}else
		return false;
	}
	
	public function tiposUsuario($dfl=""){
		return $this->db->listbox("SELECT id_tipo_usuario, tipo_usuario FROM 	".TIPO_USUARIOS." WHERE id_tipo_usuario <> 1", $dfl);
	}
	
	public function tiposUsuarioTodos($dfl=""){
		return $this->db->listbox("SELECT id_tipo_usuario, tipo_usuario FROM 	".TIPO_USUARIOS." order by id_tipo_usuario", $dfl);
	}
	
	public function tiposUsuarioPublico($dfl=""){
		return $this->db->listbox("SELECT id_tipo_usuario, tipo_usuario FROM 	".TIPO_USUARIOS." WHERE id_tipo_usuario > 3", $dfl);
	}
	
	public function validarNombreUsuario($user,$id_empresa='',$clioferto=0,$id_tipo=0){
		$empresa='';

		if($id_empresa!=''){
			$empresa=" and id_empresa=$id_empresa ";
		}
		if($clioferto)
			$empresa=" and id_empresa=0 and id_tipo_usuario=5 ";

		if($id_tipo)
		$empresa=" and id_tipo_usuario=$id_tipo ";	
			

		$sql="select * from ".USUARIOS." where CONVERT(_username USING latin1) = '$user' and borrado='0' $empresa ";
		//echo $sql;
		$us = $this->db->query($sql);
		if($this->db->num_rows($us) >0){ 
			return true;
		}else
		return false;
	}
	
	
	public function validarUsuarioxID($user, $id_usuario,$id_empresa='',$id_tipo='',$clioferto=0){
		$empresa='';
		if($id_empresa!='' and $id_tipo!=4)
			$empresa=" and id_empresa=$id_empresa ";

		if($clioferto){
			$empresa=" and id_empresa=0 and id_tipo_usuario=5 ";
		}

		$tipo='';
		if($id_tipo!='')
			$tipo=" and id_tipo_usuario=$id_tipo ";
		
		$sql="select * from ".USUARIOS." where CONVERT(_username USING latin1) = '$user' and id_usuario <> '$id_usuario' and  borrado='0' $empresa $tipo";
		//echo $sql;
		$us = $this->db->query($sql);
		if($this->db->num_rows($us) >0){ 
			return true;
		}else
		return false;
	}
	
	public function listarUsuarios($empresa=0,$tipo=5){
		$busq='';
		
		if($empresa)
			$busq=' and b.id_empresa='.$empresa;
		
		$sql = "SELECT b.id_usuario,t.nombre,t.apellidos,t.telefono,t.movil,t.direccion,t.proviene,t.id_pais,t.id_dpto,t.id_ciudad,pa.nombre as pais,de.dpto as departamento,ci.ciudad, d.tipo_usuario, b.estado, b.email ,e.id_empresa, e.nombre as empresa,e.estado as estadoemp,e.telefono as telefonoemp, e.movil as movilemp, e.direccion as direccionemp,e.email as emailemp,e.subdominio,e.tipodominio,e.dominio, e.web,e.facebook,e.twitter,c.categoria
		FROM ".USUARIOS." b 
		left join ".EMPRESAS." e on b.id_empresa=e.id_empresa 
		left join ".ECATEGORIA." c on e.id_categoria=c.id_categoria 
		JOIN ".PERFIL." t ON t.id_usuario = b.id_usuario 
		JOIN ".TIPO_USUARIOS." d ON d.id_tipo_usuario = b.id_tipo_usuario
		left join ".CLI_PAISES." pa on t.id_pais=pa.id_pais 
		left join ".CLI_DPTOS." de on t.id_dpto=de.id_dpto 
		left join ".CLI_CIUDADES." ci on t.id_ciudad=ci.id_ciudad 
		where b.id_tipo_usuario = $tipo $busq and b.id_empresa<>0 and  borrado='0' 
		group by b.id_usuario ";	
		
		return $this->db->result_array( $this->db->query($sql) );   
		
	}

	public function listarUsuariosCompleto($empresa=0,$tipo=5){
		$busq='';
		
		if($empresa)
			$busq=' and b.id_empresa='.$empresa;
		
		$sql = "SELECT b.id_usuario,t.nombre,t.apellidos,t.telefono,t.movil,t.direccion,t.proviene,t.id_pais,t.id_dpto,t.id_ciudad,pa.nombre as pais,de.dpto as departamento,ci.ciudad, d.tipo_usuario, b.estado, b.email ,e.id_empresa, e.nombre as empresa,e.estado as estadoemp,e.telefono as telefonoemp, e.movil as movilemp, e.direccion as direccionemp,e.email as emailemp,e.subdominio, c.categoria
		FROM ".USUARIOS." b 
		left join ".EMPRESAS." e on b.id_empresa=e.id_empresa 
		left join ".ECATEGORIA." c on e.id_categoria=c.id_categoria 
		JOIN ".PERFIL." t ON t.id_usuario = b.id_usuario 
		JOIN ".TIPO_USUARIOS." d ON d.id_tipo_usuario = b.id_tipo_usuario
		left join ".CLI_PAISES." pa on t.id_pais=pa.id_pais 
		left join ".CLI_DPTOS." de on t.id_dpto=de.id_dpto 
		left join ".CLI_CIUDADES." ci on t.id_ciudad=ci.id_ciudad 
		where b.id_tipo_usuario = $tipo $busq and  borrado='0' 
		 order by b.id_usuario desc ";	
		
		return $this->db->result_array( $this->db->query($sql) );   
		
	}

	public function listarUsuariosSiguiendo($limit=0){
		$limitar='';
		
		if($limit)
			$limitar=' limit 0,'.$limit;

		$sql = "select u.id_usuario, siguiendo, p.nombre, count(*) as count 
from ".USUARIOS_EMPRESA." u
left join ".PERFIL." p on u.id_usuario=p.id_usuario where siguiendo='1' group by u.id_usuario, siguiendo
order by count(*) desc $limitar";	
		//echo $sql;
		return $this->db->result_array( $this->db->query($sql) );   
		
	}

	public function countTotalUsuarios($tipo=5,$de=''){
		$busq='';
		if($de=='oferto'){
			$busq.="and id_empresa=0 ";
		}
		else if($de=='empresas'){
			$busq.="and id_empresa<>0 ";
		}

		$sql = "SELECT count(*) as count FROM ".USUARIOS."  where id_tipo_usuario = $tipo and borrado='0' $busq";	
		$result = $this->db->query($sql);
		$row =  $this->db->fetch_array($result);
		return $row['count'];
		
	}

	public function cambiarPass($user,$id_empresa='',$clioferto=0,$id_tipo=0,$pass){
		if($this->validarNombreUsuario($user,$id_empresa,$clioferto,$id_tipo)){
			$id_usuario = $this->obtenerIdUsuario($user,$id_empresa,$clioferto,$id_tipo);
			//echo $id_usuario;
			$cost = 10;
			$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
			$salt = sprintf("$2a$%02d$", $cost) . $salt;
			$dat['_password'] =crypt($pass, $salt);
			$this->actualizar($dat, $id_usuario);
			return $pass;
		}else{
			return FALSE;
		}
	}
	
	public function listarUsuariosOferto($empresa=0){
		$join='';
		$busq=' and b.id_empresa=0 ';
		
		if($empresa){
			$join="left join ".USUARIOS_EMPRESA." e on e.id_usuario=b.id_usuario ";
			$busq=' and e.id_empresa='.$empresa;
		}
		
		$sql = "SELECT b.id_usuario,t.nombre,t.apellidos,t.telefono,t.movil,t.direccion,t.proviene,t.id_pais,t.id_dpto,t.id_ciudad,pa.nombre as pais,de.dpto as departamento,ci.ciudad, b.estado, b.email  FROM ".USUARIOS." b  $join
		JOIN ".PERFIL." t ON t.id_usuario = b.id_usuario 
		left join ".CLI_PAISES." pa on t.id_pais=pa.id_pais 
		left join ".CLI_DPTOS." de on t.id_dpto=de.id_dpto 
		left join ".CLI_CIUDADES." ci on t.id_ciudad=ci.id_ciudad 
		where b.id_tipo_usuario = 5 $busq and  borrado='0' 
		group by b.id_usuario ";	
		
		return $this->db->result_array( $this->db->query($sql) );   
		
	}

	public function numClientesFiltro($empresa=0,$compra='',$de='',$sigue='',$puntos=''){
		$busq="where u.id_tipo_usuario = 5  and u.estado='1' and  u.borrado='0' ";
		$busqoferto=" and e.id_empresa=$empresa and e.suscrito='1' ";
		$busqsitio=" and u.id_empresa=$empresa and u.suscrito='1'";
		
		$join='';
		$joinsitio='';
		$joinoferto='';

		if($compra!=''){
			
			if($compra=='si'){
				$join.="left join ".PEDIDOS." pe on u.id_usuario=pe.id_usuario";
				$busq.=" and pe.id_empresa=$empresa and pe.compra='1' ";
			}
			else{
				$busq.=" and u.id_usuario NOT IN (select id_usuario from pedidos pe where pe.compra ='1' and pe.id_empresa=$empresa) ";
			}
			
		}

		if($sigue!=''){
			if($sigue=='si')
			$busqoferto.=" and e.siguiendo='1' ";
			else
				$busqoferto.=" and e.siguiendo='0' ";
		}

		if($puntos!=''){
			$joinsitio.="left join ".PUNTOS." pu on u.id_usuario=pu.id_usuario";
			if($puntos=='si')
				$busqsitio.=" and pu.puntos>0";
			else
				$busqsitio.=" and (pu.puntos is NULL or pu.puntos=0)";
		}

		$sqlsitio="SELECT u.id_usuario,u.id_empresa,u.email,u.suscrito,p.nombre,p.apellidos
		FROM ".USUARIOS." u
		JOIN ".PERFIL." p ON p.id_usuario = u.id_usuario 
		$join $joinsitio
		$busq $busqsitio
		group by u.id_usuario";

		$sqloferto="SELECT u.id_usuario,u.id_empresa,u.email,u.suscrito,p.nombre,p.apellidos
		FROM ".USUARIOS." u 
		left join ".USUARIOS_EMPRESA." e on e.id_usuario=u.id_usuario 
		JOIN ".PERFIL." p ON p.id_usuario = u.id_usuario 
		$join $joinoferto
		$busq $busqoferto
		group by u.id_usuario";

		if($de=='oferto')
			$sql=$sqloferto;
		elseif($de=='sitio')
			$sql=$sqlsitio;
		else{
			$sql = "select * from (($sqlsitio) union ($sqloferto))  as r group by email   ";
		}

		return $this->db->num_rows( $this->db->query($sql) );   
		
	}

	public function listarClientesFiltro($empresa=0,$iStart=0,$iLenght=0,$sortCol='nombre',$iDir='asc',$compra='',$de='',$sigue='',$puntos=''){
		$busq="where u.id_tipo_usuario = 5  and u.estado='1' and  u.borrado='0' ";
		$busqoferto=" and e.id_empresa=$empresa and e.suscrito='1' ";
		$busqsitio=" and u.id_empresa=$empresa and u.suscrito='1'";
		
		$join='';
		$joinsitio='';
		$joinoferto='';
		$pag='';
		
		if($iLenght)
		$pag= "limit $iStart, $iLenght";

		if($compra!=''){
			
			if($compra=='si'){
				$join.="left join ".PEDIDOS." pe on u.id_usuario=pe.id_usuario";
				$busq.=" and pe.id_empresa=$empresa and pe.compra='1' ";
			}
			else{
				$busq.=" and u.id_usuario NOT IN (select id_usuario from pedidos pe where pe.compra ='1' and pe.id_empresa=$empresa) ";
			}
			
		}

		if($sigue!=''){
			if($sigue=='si')
			$busqoferto.=" and e.siguiendo='1' ";
			else
				$busqoferto.=" and e.siguiendo='0' ";
		}

		if($puntos!=''){
			$joinsitio.="left join ".PUNTOS." pu on u.id_usuario=pu.id_usuario";
			if($puntos=='si')
				$busqsitio.=" and pu.puntos>0";
			else
				$busqsitio.=" and (pu.puntos is NULL or pu.puntos=0)";
		}

		$sqlsitio="SELECT u.id_usuario,u.id_empresa,u.email,p.nombre,p.apellidos
		FROM ".USUARIOS." u
		JOIN ".PERFIL." p ON p.id_usuario = u.id_usuario 
		$join $joinsitio
		$busq $busqsitio
		group by u.id_usuario";

		$sqloferto="SELECT u.id_usuario,u.id_empresa,u.email,p.nombre,p.apellidos
		FROM ".USUARIOS." u 
		left join ".USUARIOS_EMPRESA." e on e.id_usuario=u.id_usuario 
		JOIN ".PERFIL." p ON p.id_usuario = u.id_usuario 
		$join $joinoferto
		$busq $busqoferto
		group by u.id_usuario";

		if($de=='oferto')
			$sql=$sqloferto;
		elseif($de=='sitio')
			$sql=$sqlsitio;
		else{
			$sql = "select * from (($sqlsitio) union ($sqloferto)) as r group by email   ";
		}

		$sql.=" order by $sortCol $iDir $pag ";	
		//echo $sql;
		return $this->db->result_array( $this->db->query($sql) );   
		
	}
	public function estadoSuscripcionUsuEmpresa($estado,$id_usuario=0,$id_empresa=0){
		if($id_usuario and $id_empresa){
			if($this->db->query("update ".USUARIOS_EMPRESA." set suscrito='$estado' where id_usuario=$id_usuario and  id_empresa= $id_empresa"))
				return true;
			else
				return false;
			
		}
		else
			return false;
	}
	public function cancelarSuscripcionEmpresa($id_usuario=0,$id_empresa=0){
		if($id_usuario and $id_empresa){
			$usuario = $this->db->fetch_assoc( $this->db->query("SELECT email FROM ".USUARIOS." u WHERE u.id_usuario = $id_usuario"));
			$email=$usuario['email'];
			if($this->db->num_rows($this->db->query("select id_usuario from ".USUARIOS." where email='$email' and  id_empresa= $id_empresa"))>0){
				$this->db->query("update ".USUARIOS." set suscrito='0' where email='$email' and  id_empresa= $id_empresa");
			}

			$usuarioEmpresa=$this->db->fetch_assoc($this->db->query("select id_usuario_empresa from ".USUARIOS_EMPRESA." ue left join ".USUARIOS." u on u.id_usuario=ue.id_usuario where u.email='$email' and  ue.id_empresa= $id_empresa"));
			if($usuarioEmpresa['id_usuario_empresa']){
				$this->db->query("update ".USUARIOS_EMPRESA." set suscrito='0' where id_usuario_empresa=".$usuarioEmpresa['id_usuario_empresa']);
			}
		}
		else
			return false;
	}

	
}

?>