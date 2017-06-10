<?php

/**
  * modelo Empresas
  *
  *
  *
  * @package   Empresas
  * @author	   Cerón
  * @since	   20100519
  * @version   20100519
  */


class Empresas extends ModelBase
{

 	public $dirfile ;
	public $dirfileout ;
	function __construct(){
      parent::__construct();
      $this->dirfile = FILES."empresas/";
	  $this->dirfileout = URLFILES."empresas/";
   }
   /**
	 * guardar
	 *
	 * Guarda las empresas
	 * identidaor
	 *
	 * @access	public
	 * @author	Cerón
	 * @since	20100519
	 * @version	20100519
	 * @return 	int.
	 */

	public function guardar ( $id =0,$actver=false ){
		if($id>0){
			$this->db->update($this->datos ,EMPRESAS , "id_empresa = '$id'" );
			if($actver){
				$this->db->query("update ".VERSIONES." set actualizado=NOW() where tipo='categoria' ");
			}
		}
		else{
			$this->db->insert($this->datos, EMPRESAS );

			$id = $this->db->insert_id();
			$this->db->query("update ".VERSIONES." set actualizado=NOW() where tipo='categoria' ");
		}
        return $id;
	}

	/**
	 * borrar
	 *
	 * Borra el registro de la empresa seleccionada
	 * identidaor de la empresas
	 *
	 * @access	public
	 * @author	Cerón
	 * @since	20100519
	 * @version	20100519
	 * @return 	boolean.
	 */

	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_empresa from ".EMPRESAS." where id_empresa = '$id' ")) > 0 ){

			$this->deleteImage($id);
			$this->db->query("delete from ".EMPRESAS." where id_empresa = '$id' ");
			return true;
		}else
			return false;
	}

		public function borrarImagen($id){
		$sql = "select logo from ".EMPRESAS." where id_empresa = '$id' ";
		$imagen = $this->db->fetch_array( $this->db->query($sql) );

		if( file_exists($this->dirfile."s".$imagen['logo']) )
			@unlink($this->dirfile."s".$imagen['logo']);
		if( file_exists($this->dirfile."m".$imagen['logo']) )
			@unlink($this->dirfile."m".$imagen['logo']);
		if( file_exists($this->dirfile."b".$imagen['logo'])	)
			@unlink($this->dirfile."b".$imagen['logo']);

		$reg['logo'] = '';
		return $this->db->update($reg, EMPRESAS, "id_empresa = '$id' ");

	}
	
	/**
	 * deleteImage
	 *
	 * elimina las imaganes que existan
	 * identidaor de la empresas
	 *
	 * @access	public
	 * @author	Cerón
	 * @since	20100519
	 * @version	20100519
	 * @return 	boolean.
	 */


	public function deleteImage($id){
	      $imagen = $this->db->fetch_array( $this->db->query("select imagen from ".EMPRESAS." where id_empresa = '$id' ") );
			  if( file_exists($this->dirfile."s".$imagen['imagen']) )
					@unlink($this->dirfile."s".$imagen['imagen']);

			  if( file_exists($this->dirfile."m".$imagen['imagen']) )
					@unlink($this->dirfile."m".$imagen['imagen']);

			  if( file_exists($this->dirfile."b".$imagen['imagen']) )
					@unlink($this->dirfile."b".$imagen['imagen']);

			  return true;
	}
	
	public function subirArchivo( $campo){
		$nomfile = date("Ymdhis");
		$img = new images($_FILES[$campo]);

		$img->file_new_name_body = $nomfile;
		$img->file_name_body_pre = 'm';
		$img->file_name_body_add = '_2x';
		$img->allowed = array('image/*');
		$img->image_resize = true;
		$img->image_ratio_fill= true;
		$img->image_x = 400;
		$img->image_y = 160;
		$img->process($this->dirfile);

		$img->file_new_name_body = $nomfile;
		$img->file_name_body_pre = 'm';
		$img->allowed = array('image/*');
		$img->image_resize = true;
		$img->image_ratio_fill= true;
		$img->image_x = 400;
		$img->image_y = 160;
		$img->process($this->dirfile);

		$img->file_new_name_body = $nomfile;
		$img->file_name_body_pre = 's';
		$img->allowed = array('image/*');
		$img->image_resize = true;
		$img->image_ratio_fill = true;
		$img->image_x = 200;
		$img->image_y = 180;
		$img->process($this->dirfile);
		
		$img->file_new_name_body = $nomfile;
		$img->file_name_body_pre = 'f';
		$img->allowed = array('image/*');
		$img->image_resize = true;
		$img->image_ratio_fill= true;
		$img->image_x = 48;
		$img->image_y = 48;
		$img->process($this->dirfile);
		
		$this->datos["logo"] = $nomfile.'.'.$img->file_dst_name_ext;
	}

	/**
	 * numRegistrosEmpresas
	 *
	 * Cuenta el numero de registro de las empresas
	 * @access	public
	 * @author	Cerón
	 * @since	20100519
	 * @version	20100519
	 * @return 	int.
	 */


	public function numRegistrosEmpresas($busqueda = ""){
	    $where = "";
		if($busqueda != "" )
	      $where = " where nombre LIKE '$busqueda%'";

		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".EMPRESAS.$where." ");
		$row =  $this->db->fetch_array($result);
		return $row['count'];
	}


	/*
	 * numEmpresasPorCategoria
	 *
	 * retorna el numero de empresas pertenecientes a una categoria
	 *
	 *
	 * @access	public
	 * @author	Ceron
	 * @since	20110519
	 * @version	20110519
	 * @return 	int.
	 */

	public function numEmpresasPorCategoria($id_categoria){
		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".CATEGORIA_EMPRESA." WHERE id_categoria = '$id_categoria'  ");
		$row =  $this->db->fetch_array($result);
		return $row['count'];
	}

	public function listarTodas( ){
		$sql = "select * FROM ".EMPRESAS." ORDER by nombre asc ";
		return $this->db->result_array( $this->db->query($sql) );
	}

	/**
	 * listarEmpresas
	 *
	 * hace las consulta de las empresas para el listado del grid
	 * orden(parametro de ordenamiento), direccion(asc,desc), start(comienzo de la consulta), limit(cantidad de registro por consulta)
	 *
	 * @access	public
	 * @author	Cerón
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.
	 */

	public function listarEmpresas($orden="fecha" , $direccion = "", $start, $limit, $busqueda = "" ){
	    $where = "";
		if($busqueda != "" )
	      $where = " where nombre LIKE '$busqueda%'";

		$sql = "select * FROM ".EMPRESAS.$where." order by $orden desc LIMIT  $start, $limit ";
		return $this->db->result_array( $this->db->query($sql) );
	}

	

    /**
	 * obtener
	 *
	 * obtiene la informacion de un registro
	 * id(identificador de la empresa)
	 * @return 	array.
	 */

	public function obtener($id){
		$sql="select e.*,c.categoria from ".EMPRESAS." e left join ".ECATEGORIA." c on e.id_categoria=c.id_categoria where e.id_empresa = '$id' ";
		return $this->db->fetch_array($this->db->query($sql));
	}
	
	 /**
	 * obtener
	 *
	 * obtiene la informacion de contacto un registro
	 * id(identificador de la empresa)
	 * @return 	array.
	 */

	public function obtenerInfoContacto($id){
		return $this->db->fetch_array($this->db->query("select email,telefono,telefono2, telefono3,direccion, movil,skype, facebook,twitter,wtwitter,youtube,linkedin,pa,fecha_pa from ".EMPRESAS." where id_empresa = '$id' "));
	}

	/**
	 * obtener completo
	 *
	 * obtiene la informacion de un registro
	 * id(identificador de la empresa)
	 * @return 	array.
	 */

	public function obtenerCompleto($id){
		$sql="select e.*,c.categoria, d.dpto,ci.ciudad from ".EMPRESAS." e 
		left join ".ECATEGORIA." c on e.id_categoria=c.id_categoria 
		left join ".ALMACENES." a on e.id_empresa=a.id_empresa
		left join ".DPTOS." d on d.id_dpto=a.id_dpto
		left join ".CIUDADES." ci on ci.id_ciudad=a.id_ciudad
		where e.id_empresa = '$id' 
		group by e.id_empresa";
		return $this->db->fetch_array($this->db->query($sql));
	}
	
	public function getDominio($id_empresa){
		$sql = "
		SELECT e.dominio, e.subdominio, e.tipodominio
		FROM ".EMPRESAS." e 
		WHERE e.id_empresa = '$id_empresa'
		";
		$qid = $this->db->query($sql);
		$out = $this->db->fetch_assoc($qid);
		return ($out['tipodominio']=='dom') ? $out['dominio'] : $out['subdominio'].'.oferto.co';
	}
	
	

	public function listar($inicio=0,$cantidad=2){
		$sql = "select   p.id_empresa , p.nombre, p.entradilla, p.precio, p.imagen, g.archivo, g.referencia from ".EMPRESAS." p
		             LEFT JOIN ".GALERIA_IMAGENES." g on p.id_galeria = g.id_galeria
						  GROUP BY p.id_empresa
						 ORDER BY p.id_empresa desc limit $inicio, $cantidad";
		$qid = $this->db->query($sql);
		return $this->db->result_array($qid);
	}


/**
	 * listarUltimas
	 *
	 * lista las n ultimas empresas
	 * inicio de la busqueda y la cantida que va a sacar
	 */

	public function listarUltimos($inicio=0,$cantidad=2){
		$sql = "select   e.* FROM ".EMPRESAS." e  
		join  ".USUARIOS." b on b.id_empresa=e.id_empresa where b.borrado='0' GROUP BY e.id_empresa  
		ORDER BY e.fecha_registro desc,e.id_empresa desc limit $inicio, $cantidad ";
		$qid = $this->db->query($sql);
		return $this->db->result_array($qid);
	}


  /**
	 * updateimagen
	 *
	 * actualiza el campo de imagen cuando es eliminada la imagen
	 * id de la empresa
	 *
	 * @access	public
	 * @author	Cerón
	 * @since	20100519
	 * @version	20100519
	 * @return 	void.
	 */

	public function updateimagen($id){
	   $imagen = "";
	   $this->db->query("Update ".EMPRESAS." set imagen = '$imagen' where id_empresa = '$id'" );
	}
	
	/********** manejo de la empresa ***********/
	
	public function getIdEmpresa(){
		//return 1;
		$_SESSION['dominiovista']= DOMINIO;
		$url = $_SERVER['SERVER_NAME'];
		if(strpos($url, 'localhost') !== false){
			return 5;
			//return false;
		}
		if(strpos($url,'www.') !== false)
			 $url = substr($url, 4, strlen($url)+1);
		$pos = strpos($url, '.');
		$name = substr($url, 0, $pos);
		$dominio = substr($url, $pos+1, strlen($url));
		
		$input = new RI_input(true);
		$name = $input->xss_clean($name);
		$dominio = $input->xss_clean($dominio);
		$_SESSION['dominiovista']= $url;
		$add = '';
		if($dominio == 'oferto.co'){
			$add = "subdominio like '$name' and tipodominio='sub' ";
		}else{
			$add = " (dominio like '$name.$dominio') or (dominio like 'www.$name.$dominio')  and tipodominio='dom' ";
		}
		
		$sql = "
		SELECT id_empresa
		FROM ".EMPRESAS." 
		WHERE $add and web<>'0' and estado = 'Activo'
		";
		$qid = $this->db->query($sql);
		if($this->db->num_rows($qid) > 0){
			$out = $this->db->fetch_assoc($qid);
			//$_SESSION['plan'] = $this->getPlan($out['id_empresa']);
			return $out['id_empresa'];
		}else
			return false;
			
	}
	
	public function getSkin($id_empresa){
		$sql = "
		SELECT e.skin
		FROM ".EMPRESAS." e 
		WHERE e.id_empresa = '$id_empresa'
		";
		$qid = $this->db->query($sql);
		$out = $this->db->fetch_assoc($qid);
		return $out['skin'];
	}
	
	public function validarIdEmpresa($id_empresa){
		$sql = "
			SELECT id_empresa
			FROM ".EMPRESAS."
			WHERE id_empresa = {$id_empresa}
		";
		$qid = $this->db->query($sql);
		if($this->db->num_rows($qid) > 0){
			return true;
		}else{
			return false;
		}
			
	}
	
	public function validarSubdominioEmpresa($subdominio, $id_empresa){
		$sql="select e.* from ".EMPRESAS." e  join ".USUARIOS." u on e.id_empresa=u.id_empresa and u.id_tipo_usuario=4 where e.subdominio = '$subdominio' and e.id_empresa <> '$id_empresa' and borrado='0' ";
		$us = $this->db->query($sql);
		
		if($this->db->num_rows($us) >0){ 
			return true;
		}else
			return false;
	}

	public function validarDominioEmpresa($dominio, $id_empresa){
		$us = $this->db->query("select * from ".EMPRESAS." where dominio = '$dominio' and id_empresa <> '$id_empresa' ");
		
		if($this->db->num_rows($us) >0){ 
			return true;
		}else
			return false;
	}

	public function getColor($id_empresa){
		$sql = "
		SELECT e.color
		FROM ".EMPRESAS." e 
		WHERE e.id_empresa = '$id_empresa'
		";
		$qid = $this->db->query($sql);
		$out = $this->db->fetch_assoc($qid);
		return $out['color'];
	}

	public function selectColor($selected=''){
		$html ='';
		$sql = "SHOW COLUMNS FROM ".EMPRESAS." LIKE 'color'";
		$result = $this->db->fetch_array($this->db->query($sql));
		preg_match_all("/(?:(?!:[\(\,])')(.*?)(?:'(?:[\)\,]))/",$result[1],$enums);
		for($i=0; $i<count($enums[1]); $i++){
			$data= str_replace("''","'",$enums[1][$i]);
			//echo $data.'-';
			$html .='<option value="'.$data.'" '.(($enums[1][$i] == $selected)? 'selected="selected"':"").'>'.(($data == '')? 'Seleccione una opci&oacute;n':$data).'</option>';
		}
		return $html;
	}

	function guardarUsuarioEmpresa($usuario=0,$empresa=0,$tipo='compra'){
		if($usuario and $empresa){
			$qid = $this->db->query("select * from ".USUARIOS_EMPRESA." where id_empresa = '$empresa' and id_usuario=$usuario ");
			$out = $this->db->fetch_assoc($qid);
			if($out['id_usuario'] ){
				if($tipo=='compra' and $out['compra']!='1'){
						$this->db->query("update ".USUARIOS_EMPRESA." set compra='1'  where id_empresa = '$empresa' and id_usuario=$usuario ");

				}elseif($tipo=='siguiendo' and $out['siguiendo']!='1'){
					$this->db->query("update ".USUARIOS_EMPRESA." set siguiendo='1'  where id_empresa = '$empresa' and id_usuario=$usuario ");

				}else
					return false;
				return true;
			}else{
				$datos=array();
				$datos['id_usuario']= $usuario;
				$datos['id_empresa']= $empresa;
				if($tipo=='compra')
					$datos['compra']= '1';
				elseif($tipo=='siguiendo')
					$datos['siguiendo']='1';
				if($this->db->insert($datos, USUARIOS_EMPRESA))
					return true;
				else
					return false;
			}
		}
		else
			return false;	
	}

	function borrarUsuarioEmpresa($usuario=0,$empresa=0,$tipo='compra'){
		if($usuario and $empresa){
			$qid = $this->db->query("select * from ".USUARIOS_EMPRESA." where id_empresa = '$empresa' and id_usuario=$usuario ");
			$out = $this->db->fetch_assoc($qid);
			if($out['id_usuario'] ){
				if($tipo=='compra'){
					$this->db->query("update ".USUARIOS_EMPRESA." set compra='0'  where id_empresa = '$empresa' and id_usuario=$usuario ");
					if($out['siguiendo']=='0')
						$this->db->query("delete from ".USUARIOS_EMPRESA." where id_usuario_empresa =".$out['id_usuario_empresa']);

				}elseif($tipo=='siguiendo'){
					$this->db->query("update ".USUARIOS_EMPRESA." set siguiendo='0'  where id_empresa = '$empresa' and id_usuario=$usuario  ");
					if($out['compra']=='0')
						$this->db->query("delete from ".USUARIOS_EMPRESA." where id_usuario_empresa =".$out['id_usuario_empresa']);

				}else
					return false;

				return true;
			}else
			return true;
		}
		else
			return false;	
	}

	function estaSiguiendo($usuario,$empresa=0){
		$sql = "SELECT id_usuario FROM ".USUARIOS_EMPRESA." WHERE id_usuario = $usuario and id_empresa=$empresa and siguiendo='1' ";
		$qid = $this->db->query($sql);
		if($this->db->num_rows($qid) > 0){
			return true;
		}else{
			return false;
		}
	}

	function contarSiguiendo($usuario){

		$sql = "select e.id_empresa, e.nombre as empresa, e.logo, e.slogan FROM ".EMPRESAS." e left join ".USUARIOS_EMPRESA." u on e.id_empresa= u.id_empresa where u.id_usuario=$usuario and siguiendo='1' ";
		return $this->db->num_rows( $this->db->query($sql) );
	
	}


	function listarSiguiendo($usuario){

		$sql = "select e.id_empresa, e.nombre as empresa, e.logo, e.slogan FROM ".EMPRESAS." e left join ".USUARIOS_EMPRESA." u on e.id_empresa= u.id_empresa where u.id_usuario=$usuario and siguiendo='1' ";
		return $this->db->result_array( $this->db->query($sql) );
	
	}

	function contarSeguidores($empresa){

		$sql = "select u.id_usuario FROM ".USUARIOS." u join ".USUARIOS_EMPRESA." e on u.id_usuario= e.id_usuario where e.id_empresa=$empresa and siguiendo='1' ";
		return $this->db->num_rows( $this->db->query($sql) );
	
	}

	function listarSeguidores($empresa){

		$sql = "select u.id_usuario,p.nombre, u.email FROM ".USUARIOS." u  join ".PERFIL." p on u.id_usuario=p.id_usuario  join ".USUARIOS_EMPRESA." e on u.id_usuario= e.id_usuario where e.id_empresa=$empresa and siguiendo='1' ";
		return $this->db->result_array( $this->db->query($sql) );
	
	}


}

?>