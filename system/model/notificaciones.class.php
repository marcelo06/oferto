<?php 


class Notificaciones extends ModelBase
{
	public $dirfile ;
	public $dirfileout ;
	
	function __construct(){
      parent::__construct();
      $this->dirfile = FILES."notificaciones/";
	  $this->dirfileout = URLFILES."notificaciones/";
   }
	
	public function guardar ( $id =0 ){
		if($id>0){
			$this->db->update($this->datos ,NOTIFICACIONES , "id_notificacion = '$id' " );
		}else{
			$this->db->insert($this->datos, NOTIFICACIONES );
			$id = $this->db->insert_id();
		}
         return $id;
	}

	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_notificacion from ".NOTIFICACIONES." where id_notificacion = '$id' ")) > 0 ){
			$this->db->query("delete from ".NOTIFICACIONES." where id_notificacion = '$id' ");
			return true;
		}else
			return false;
 	}
	
	
	public function obtener($id){
		return $this->datos = $this->db->fetch_array($this->db->query("select * from ".NOTIFICACIONES." where id_notificacion = '$id' "));
	} 

	public function obtenerEmpresa($id,$tipo=1){
		return  $this->db->fetch_array($this->db->query("select * from ".NOTIFICACIONES." where id_empresa = '$id' and tipo=$tipo "));
	}


	public function listar(){

	    $sql = "SELECT * FROM ".NOTIFICACIONES." order by id_notificacion desc ";

		return $this->db->result_array( $this->db->query($sql) );   

	}

	public function listarPendientesHoy(){
		$sql = "SELECT id_notificacion, titulo FROM ".NOTIFICACIONES." where  fecha <= NOW() and estado='Pendiente' ";
		return $this->db->result_array( $this->db->query($sql) );   
	}

	
	public function numRegistros(){
		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".NOTIFICACIONES." WHERE id_empresa = '".$_SESSION['id_empresa']."'  "); 
		$row =  $this->db->fetch_array($result); 
		return $row['count'];
	}
	
	
	public function listarNotificacion($orden="id_notificacion" , $direccion = "", $start, $limit ){
	
	    $sql = "SELECT * FROM ".NOTIFICACIONES." WHERE  id_empresa = '".$_SESSION['id_empresa']."'  order by $orden desc LIMIT  $start, $limit ";
		return $this->db->result_array( $this->db->query($sql) );   
		
	}

	public function cambiarEstado($estado='',$log='',$id){
		$update=" fecha_log='".date('y-m-d h:i:s')."', log='$log' ";
		if($estado!='')
			$update.=", estado='$estado' ";
		if($this->db->num_rows($this->db->query("select id_notificacion from ".NOTIFICACIONES." where id_notificacion = '$id' ")) > 0 ){
			return $this->db->query("update ".NOTIFICACIONES." set $update where id_notificacion = '$id' ");
		}else
		return false;
	}

	public function numClientesFiltro($logueado='',$compra='',$tokenonly=0, $regidonly=0){
		$busq=" where 1 ";
		$join=" left JOIN ".PERFIL." p ON p.id_usuario = u.id_usuario ";

		if($compra!=''){
			$logueado='si';
			$join.="left join ".PEDIDOS." pe on u.id_usuario=pe.id_usuario and pe.compra='1' ";
			if($compra=='si'){
				
				$busq.=" and pe.compra='1' ";
			}
			else{
				$busq.=" and pe.id_pedido is null";
			}
		}

		if($logueado!=''){
			if($logueado=='si') 
				$busq.=" and u.id_tipo_usuario = 5  and u.estado='1' and  u.borrado='0' and u.id_empresa=0  group by u.id_usuario";
			else{
				$busq.="and (u.id_usuario is null or u.id_usuario=0) ";
			}
		}

		$select_token="SELECT at.id_token, at.token,at.notificaciones,at.id_token as idn,u.id_usuario,u.email,p.nombre,p.apellidos  FROM ".APP_TOKEN." at 
		left join ".USUARIOS." u on at.id_usuario=u.id_usuario $join $busq ";
			
		$select_regid="SELECT ar.id_regid as id_token,ar.regid as token,ar.notificaciones,ar.id_regid as idn,u.id_usuario,u.email,p.nombre,p.apellidos FROM ".APP_REGID." ar 
		left join ".USUARIOS." u on ar.id_usuario=u.id_usuario $join $busq";

		if($tokenonly)
			$sql=$select_token;
		elseif($regidonly)
			$sql=$select_regid;
		else{
			$sql="select * from (($select_token) union ($select_regid)) as atr ";
		}

		return $this->db->num_rows( $this->db->query($sql) );   
	}


	public function listarClientesFiltro($iStart=0,$iLenght=0,$sortCol='idn',$iDir='asc',$logueado='',$compra='',$tokenonly=0, $regidonly=0){
		$busq=" where notificaciones='si' ";
		$join=" left JOIN ".PERFIL." p ON p.id_usuario = u.id_usuario ";

		$pag='';
		if($iLenght)
			$pag= "limit $iStart, $iLenght";

		if($compra!=''){
			$logueado='si';
			$join.="left join ".PEDIDOS." pe on u.id_usuario=pe.id_usuario and pe.compra='1' ";
			if($compra=='si'){
				
				$busq.=" and pe.compra='1' ";
			}
			else{
				$busq.=" and pe.id_pedido is null";
			}
		}

		if($logueado!=''){
			if($logueado=='si') 
				$busq.=" and u.id_tipo_usuario = 5  and u.estado='1' and  u.borrado='0' and u.id_empresa=0  group by u.id_usuario";
			else{
				$busq.="and (u.id_usuario is null or u.id_usuario=0) ";
			}
		}


		if($tokenonly){
			$sql="SELECT at.*, at.id_token as idn, u.id_usuario,u.email,p.nombre,p.apellidos  FROM ".APP_TOKEN." at 
		left join ".USUARIOS." u on at.id_usuario=u.id_usuario $join $busq ";
		}
		elseif($regidonly){
			$sql="SELECT ar.*, ar.id_regid as idn, u.id_usuario,u.email,p.nombre,p.apellidos FROM ".APP_REGID." ar left join ".USUARIOS." u on ar.id_usuario=u.id_usuario $join $busq";
		}
		else{
			$sql="select * from ((
				SELECT at.id_token, at.token,at.notificaciones,at.id_token as idn,u.id_usuario,u.email,p.nombre,p.apellidos  FROM ".APP_TOKEN." at 
				left join ".USUARIOS." u on at.id_usuario=u.id_usuario 
				$join $busq 
				) union (
				SELECT ar.id_regid as id_token,ar.regid as token,ar.notificaciones,ar.id_regid as idn,u.id_usuario,u.email,p.nombre,p.apellidos FROM ".APP_REGID." ar 
				left join ".USUARIOS." u on ar.id_usuario=u.id_usuario 
				$join $busq)) as atr ";
	}

	$sql.=" order by $sortCol $iDir $pag ";

			//echo $sql;
	return $this->db->result_array( $this->db->query($sql) );   
	}

	public function listarSiguiendoEmpresa($id_empresa=0,$tokenonly=0, $regidonly=0){
		
		if($tokenonly){
			$sql="select id_token,token,a.id_usuario from app_token a left join usuario_empresa u on a.id_usuario=u.id_usuario where a.notificaciones='Si' and u.id_empresa=$id_empresa order by id_token";
		}
		elseif($regidonly){
			$sql="select id_regid,regid,a.id_usuario from app_regid a left join usuario_empresa u on a.id_usuario=u.id_usuario where a.notificaciones='Si' and u.id_empresa=$id_empresa order by id_regid";
		}
		return $this->db->result_array( $this->db->query($sql) );   
	}

	public function updateimagen($id){
	   $imagen = "";
	   $this->db->query("Update ".NOTIFICACIONES." set imagen = '$imagen' where id_notificacion = '$id'" );
	}

	public function subirArchivo( $campo){
		$nomfile = date("Ymdhis".rand(10,999));
		
		$img = new images($_FILES[$campo]);
		$img->file_new_name_body = $nomfile;
		
		$img->file_name_body_pre = 'b';
		$img->allowed = array('image/*');
		$img->image_resize = true;
		$img->image_ratio = true;
		$img->image_x = 500;
		$img->image_y = 1000;
		$image_ratio_x=true;
		$img->process($this->dirfile);


		$img->file_new_name_body = $nomfile;
		$img->file_name_body_pre = 's';
		$img->allowed = array('image/*');
		$img->image_resize = true;
		$img->image_ratio = true;
		$img->image_x = 175;
		$image_ratio_x=true;
		$img->image_y = 175;
		$img->process($this->dirfile);

		$this->datos['imagen'] = $nomfile.'.'.$img->file_dst_name_ext;
		
	}
	
	public function borrarImagen($id,$tipo='imagen'){
		$sql = "select $tipo from ".NOTIFICACIONES." where id_notificacion = '$id' ";
		$imagen = $this->db->fetch_array( $this->db->query($sql) );

		if( file_exists($this->dirfile."s".$imagen[$tipo]) )
			@unlink($this->dirfile."s".$imagen[$tipo]);
		
		if( file_exists($this->dirfile."b".$imagen[$tipo])	)
			@unlink($this->dirfile."b".$imagen[$tipo]);
		
		$reg[$tipo] = '';
		return $this->db->update($reg, NOTIFICACIONES, "id_notificacion = '$id' ");

	}

	public function listBoxAcciones ($selected=''){
		$html ='';
		$sql = "SHOW COLUMNS FROM ".NOTIFICACIONES." LIKE 'accion'";
		$result = $this->db->fetch_array($this->db->query($sql));
		preg_match_all("/(?:(?!:[\(\,])')(.*?)(?:'(?:[\)\,]))/",$result[1],$enums);
		for($i=0; $i<count($enums[1]); $i++){
			$data= str_replace("''","'",$enums[1][$i]);
		//	echo $enums[1][$i];
			$html .='<option value="'.$data.'" '.(($enums[1][$i] == $selected)? 'selected="selected"':"").'>'.(($data == '')? 'Seleccione una opcion':$data).'</option>';
		}
		return $html;
	}

}

?>