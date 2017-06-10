<?php


class Almacenes extends ModelBase
{

    public $dirfile ;
	public $dirfileout ;

	function __construct(){
      parent::__construct();
      $this->dirfile = FILES."almacenes/";
	  $this->dirfileout = URLFILES."almacenes/";
   }


	public function guardar ( $id =0 ){
		if($id>0)
			$this->db->update($this->datos ,ALMACENES , "id_almacen = '$id' " );
		else{
			$this->db->insert($this->datos, ALMACENES );
			$id = $this->db->insert_id();
		}
             return $id;
	}


	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_almacen from ".ALMACENES." where id_almacen = '$id'  ")) > 0 ){
			$this->borrarImagen($id);
			$this->db->query("delete from ".ALMACENES." where id_almacen = '$id'  ");
			return true;
		}else
			return false;
	}

	public function numRegistros($buscar){

		$busqueda= " WHERE 1  ";
		if($buscar != "")
			$busqueda .= " and titulo LIKE '%$buscar%' ";

		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".ALMACENES.$busqueda." ");
		$row =  $this->db->fetch_array($result);
		return $row['count'];

	}

	
	public function listar($id_empresa){

	$busq='';
	if($id_empresa!='')
	$busq=" where id_empresa=$id_empresa ";
		$sql = "select * FROM ".ALMACENES." $busq order by id_almacen desc ";
		return $this->db->result_array( $this->db->query($sql) );

	}


	public function obtener($id){
		return $this->datos = $this->db->fetch_array($this->db->query("select * from ".ALMACENES." where id_almacen = '$id'  "));
	}


	public function listarUltimas($inicio=0,$cantidad=2){
		$sql = "select id_almacen, titulo, entradilla from ".ALMACENES." order by fecha desc limit $inicio, $cantidad";
		$qid = $this->db->query($sql);
		return $this->db->result_array($qid);
	}
	
	public function borrarImagen($id){
		$sql = "select imagen from ".ALMACENES." where id_almacen = '$id' ";
		$imagen = $this->db->fetch_array( $this->db->query($sql) );

		if( file_exists($this->dirfile."s".$imagen['imagen']) )
			@unlink($this->dirfile."s".$imagen['imagen']);
		if( file_exists($this->dirfile."m".$imagen['imagen']) )
			@unlink($this->dirfile."m".$imagen['imagen']);
		if( file_exists($this->dirfile."b".$imagen['imagen'])	)
			@unlink($this->dirfile."b".$imagen['imagen']);
		$reg['imagen'] = '';
		return $this->db->update($reg, ALMACENES, "id_almacen = '$id' ");

	}
	
	public function subirArchivo( $campo){
		$nomfile = date("Ymdhis");
		$img = new images($_FILES[$campo]);

		$img->file_new_name_body = $nomfile;
		$img->file_name_body_pre = 'b';
		$img->image_resize = true;
		$img->allowed = array('image/*');
		$img->image_ratio = true;
		$img->image_x = 500;
		$img->image_y = 500;
		$img->process($this->dirfile);;

		$img->file_new_name_body = $nomfile;
		$img->file_name_body_pre = 'm';
		$img->allowed = array('image/*');
		$img->image_resize = true;
		$img->image_ratio = true;
	$img->image_x = 200;
		$img->image_y = 200;
		
		$img->process($this->dirfile);

		$img->file_new_name_body = $nomfile;
		$img->file_name_body_pre = 's';
		$img->allowed = array('image/*');
		$img->image_resize = true;
		$img->image_ratio_crop = true;
		$img->image_x = 110;
		$img->image_y = 110;
		$img->process($this->dirfile);

		$this->datos["imagen"] = $nomfile.'.'.$img->file_dst_name_ext;
	}
	
	
	public function guardarAlmacenProducto ($datosalm,$id_producto,$del=true){
		if($del)
		$this->db->query("delete from ".ALMACEN_PRODUCTOS." where id_producto = '$id_producto' ");
		$datos= count($datosalm);
		if($datos)
		{
			for($i=0;$i<count($datosalm); $i++)
			{
				$row= nvl($datosalm[$i],0);
				if($row)
				{
				
				$row_al['id_producto'] = $id_producto;
				$row_al['id_almacen'] = $row['id_almacen'];
				$this->db->insert($row_al, ALMACEN_PRODUCTOS );
				}
			}	
		}
	
	}


	/**
	 * listarAlmacenes  con id del producto si este se encuentra asociado
	 *
	 */	
	
	public function listarAlmacenesProducto($id_producto=0){
		$sql = "SELECT p.id_producto, a . * FROM ".ALMACENES." a LEFT JOIN (SELECT * FROM ".ALMACEN_PRODUCTOS." WHERE id_producto =$id_producto) AS p ON a.id_almacen = p.id_almacen where a.id_empresa=".$_SESSION['id_empresa']." ORDER BY a.nombre";
		return $this->db->result_array( $this->db->query($sql) );   
	}
	
	public function listarAlmacenesID(){
	$sql = "SELECT id_almacen FROM ".ALMACENES." where id_empresa=".$_SESSION['id_empresa']." ORDER BY nombre";
			return $this->db->result_array( $this->db->query($sql) );
	
	}
	
	public function borrarAlmacenesProducto($id_producto=0){
		if($this->db->num_rows($this->db->query("select id_producto from ".ALMACEN_PRODUCTOS." where id_producto = '$id_producto'  ")) > 0 ){
			$this->db->query("delete from ".ALMACEN_PRODUCTOS." where id_producto = '$id_producto'  ");
			return true;
		}else
			return false;
	}

	public function numUbicacionesEmpresa($id_empresa){
		$sql="select * from ".ALMACENES." where id_empresa = '$id_empresa' and latitud <>'' and longitud<>''  ";
		return $this->db->num_rows($this->db->query($sql));
	}
	

}

?>