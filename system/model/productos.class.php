<?php

/**
  * modelo Productos
  *
  *
  *
  * @package   Productos
  * @author	   Cerón
  * @since	   20100519
  * @version   20100519
  */


class Productos extends ModelBase
{

 	public $dirfile ;
	public $dirfileout ;

	function __construct(){
      parent::__construct();
      $this->dirfile = FILES."productos/";
	  $this->dirfileout = URLFILES."productos/";
   }
   /**
	 * guardar
	 *
	 * Guarda las productos
	 * identidaor
	 *
	 * @access	public
	 * @return 	int.
	 */

	public function guardar ( $id =0 ){
		if($id>0)
			$this->db->update($this->datos ,PRODUCTOS , "id_producto = '$id'" );
		else{
			$this->db->insert($this->datos, PRODUCTOS );
			$id = $this->db->insert_id();
		}
        return $id;
	}

	/**
	 * borrar
	 *
	 * Borra el registro de la producto seleccionada
	 * identidaor de la productos
	 *
	 * @access	public
	 * @return 	boolean.
	 */

	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_producto from ".PRODUCTOS." where id_producto = '$id' ")) > 0 ){

			$this->db->query("update ".PRODUCTOS." set borrado='1' where id_producto = '$id' ");
			return true;
		}else
			return false;
	}





	/*
	 * numProductosPorCategoria
	 *
	 * retorna el numero de productos pertenecientes a una categoria
	 *
	 *
	 * @access	public
	 * @return 	int.
	 */

	public function numProductosPorCategoria($id_categoria){
		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".CATEGORIA_PRODUCTO." WHERE id_categoria = '$id_categoria' and borrado='0'  ");
		$row =  $this->db->fetch_array($result);
		return $row['count'];
	}

	public function numTodas( $id_empresa,$search='',$oferta =''){

 		$busq=" where  borrado='0' ";
		if($id_empresa)
		$busq.= " and id_empresa =".$id_empresa;

		if($oferta!=''){
			switch($oferta){
				case 'inactiva':
					$busq.=" and oferta='Inactivo' and oferta_portal='Inactivo' ";
					break;
				case 'local':
					$busq.=" and oferta='Activo' and oferta_portal='Inactivo' ";
					break;
				case 'portal':
					$busq.=" and oferta='Inactivo' and oferta_portal='Activo' ";
					break;
				case 'activa':
					$busq.=" and (oferta='Activo' or oferta_portal='Activo') ";
					break;
			}
		}

		if($search!='')
		{
			$busq.=" and (nombre like '%$search%' or id_producto like '%$search%' or estado like '%$search%' or oferta like '%$search%' or visitas like '%$search%' or compras like '%$search%' )";
		}


		$sql = "select * FROM ".PRODUCTOS." $busq  ";

		return $this->db->num_rows( $this->db->query($sql) );

	}

	public function listarTodas( $id_empresa,$start=0,$lenght=0,$sort='id_producto',$dir='desc',$search='',$oferta=''){
		$busq=" where  p.borrado='0' ";
		if($id_empresa)
		$busq.= " and p.id_empresa =".$id_empresa;

		if($oferta!=''){
			switch($oferta){
				case 'inactiva':
					$busq.=" and oferta='Inactivo' and oferta_portal='Inactivo' ";
					break;
				case 'local':
					$busq.=" and oferta='Activo' and oferta_portal='Inactivo' ";
					break;
				case 'portal':
					$busq.=" and oferta='Inactivo' and oferta_portal='Activo' ";
					break;
				case 'activa':
					$busq.=" and (oferta='Activo' or oferta_portal='Activo') ";
					break;
			}
		}

		if($search!='')
		{
			$busq.=" and (p.nombre like '%$search%' or id_producto like '%$search%' or p.estado like '%$search%' or oferta like '%$search%' or visitas like '%$search%' or compras like '%$search%') ";
		}

		$pag='';
		if($lenght)
		$pag= "limit $start, $lenght";

		$sql = "select p.*, visitas_oferto+visitas as vtotal,e.nombre as empresa FROM ".PRODUCTOS." p
				left join ".EMPRESAS." e on p.id_empresa=e.id_empresa
				$busq
				order by $sort $dir ".$pag;
		return $this->db->result_array( $this->db->query($sql) );
	}



	public function listarCategoriasProducto($id){

		$sql= "SELECT c.id_categoria, c.categoria, cp.id_producto FROM ".CATEGORIA_PRODUCTO." cp
		        JOIN ".CATEGORIA." c ON cp.id_categoria = c.id_categoria
				WHERE cp.id_producto = '$id'
				ORDER by categoria ";
		return $this->db->result_array( $this->db->query($sql) );
	}

    /**
	 * obtener
	 *
	 * obtiene la informacion de un registro
	 * id(identificador de la producto)
	 *
	 * @access	public
	 * @return 	array.
	 */

	public function obtener($id,$id_empresa=''){
		$empresa='';
		if($id_empresa!=''){
			$empresa= "and p.id_empresa= $id_empresa";
		}
		return $this->db->fetch_array($this->db->query("select p.*,g.archivo from ".PRODUCTOS." p left join ".GALERIA_IMAGENES." g on p.id_galeria=g.id_galeria where id_producto = '$id' $empresa "));
	}

	public function obtenerOferta($id){
		$busq = "oferta_publicacion <= CURDATE() and borrado='0' and id_producto = '$id'";

		return $this->db->fetch_array($this->db->query("select p.*,g.archivo from ".PRODUCTOS." p left join ".GALERIA_IMAGENES." g on p.id_galeria=g.id_galeria where $busq"));
	}

	/**
	 * obtenerDestacados
	 *
	 * hace las consulta de los productos en oferta
	 */

	public function obtenerOfertas( ){

		$sql = "select p.*,g.archivo FROM ".PRODUCTOS." p left join ".GALERIA_IMAGENES." g on p.id_galeria=g.id_galeria where estado <> 'Inactivo' and oferta='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE()  and borrado='0' and p.id_empresa=".$_SESSION['id_empresa']." group by p.id_producto desc";

		return $this->db->result_array( $this->db->query($sql) );
	}

	/**
	 * obtenerDestacados
	 *
	 * hace las consulta de los productos destacados
	 */

	public function obtenerDestacados( ){
		$sql = "select p.*,g.archivo FROM ".PRODUCTOS." p left join ".GALERIA_IMAGENES." g on p.id_galeria=g.id_galeria where estado = 'Destacado'  and borrado='0' and p.id_empresa=".$_SESSION['id_empresa']." group by p.id_producto order by p.id_producto desc";
		return $this->db->result_array( $this->db->query($sql) );
	}

	public function listar($inicio=0,$cantidad=2){
		$sql = "select   p.id_producto , p.nombre, p.entradilla, p.precio, p.imagen, g.archivo, g.referencia from ".PRODUCTOS." p
		             LEFT JOIN ".GALERIA_IMAGENES." g on p.id_galeria = g.id_galeria
					 where borrado='0'
						  GROUP BY p.id_producto
						 ORDER BY p.id_producto desc limit $inicio, $cantidad";
		$qid = $this->db->query($sql);
		return $this->db->result_array($qid);
	}

	public function numSQL($categoria=0,$precio_minimo='',$precio_maximo='',$busqpor='',$lkeywords=array()){
		$busqueda = 'WHERE p.id_empresa='.$_SESSION['id_empresa']." AND p.borrado='0' AND p.estado<>'Inactivo'";
		if($precio_minimo!='')
			$busqueda .= ' AND precio>='.$precio_minimo;
		if($precio_maximo!='')
			$busqueda .= ' AND precio<='.$precio_maximo;

		$join = '';
		if($categoria){
			$busqueda .= " AND c.id_categoria=".$categoria;
			$join = 'JOIN '.CATEGORIA_PRODUCTO.' c ON p.id_producto=c.id_producto';
		}

		$keywords = $keyword_producto = '';
		if(count($lkeywords)){
			$busq = '';
			foreach($lkeywords as $key){
				$busq .= ' OR k.id_keyword='.$key['id_keyword'];
			}
			$keywords .= " or (0 $busq)";
			$keyword_producto = 'LEFT JOIN '.KEYWORD_PRODUCTO.' k ON k.id_producto=p.id_producto';
		}

		if($busqpor!=''){
			$busqueda.=" and (p.nombre RLIKE '[[:<:]]".$busqpor."' OR p.descripcion RLIKE '[[:<:]]".$busqpor."' OR e.nombre RLIKE '[[:<:]]".$busqpor."' $keywords) ";
		}

		$sql = 'SELECT DISTINCT p.id_producto FROM '.PRODUCTOS.' p left join '.EMPRESAS." e on e.id_empresa=p.id_empresa $keyword_producto $join $busqueda";

		return $this->db->num_rows( $this->db->query($sql) );
	}

	/**
	 * listarSQL
	 *
	 * lista todas las productos manda el una cadena con la consulta, sin query
	 */

	public function listarSQL($categoria=0,$orden='asc',$por='p.id_producto',$busqpor='',$rango='',$lkeywords=array()){
		$busqueda = " where  p.borrado='0' and p.estado<>'Inactivo' and p.id_empresa=".$_SESSION['id_empresa'];
		$join='';
		if($categoria )
		{
			$busqueda .= " and c.id_categoria=".$categoria;
		  $join=" join ".CATEGORIA_PRODUCTO."  c on p.id_producto=c.id_producto ";
		}

		$keywords='';
		if(count($lkeywords ) ){
			$busq = "";
			foreach($lkeywords as $key){
				$busq .= " or (k.id_keyword = ".$key['id_keyword'].")";
			}
	      $keywords .= " or (0 $busq)";
		}

		$ordenar='';

		if($por=='oferta')
		$ordenar=" p.oferta $orden";

		if($por=='nombre')
		$ordenar=" p.nombre $orden";

		if($por=='precio')
		$ordenar=" $por $orden";


		if($busqpor!=''){
			$busqueda.=" and (p.nombre RLIKE '[[:<:]]".$busqpor."' OR p.descripcion RLIKE '[[:<:]]".$busqpor."' OR e.nombre RLIKE '[[:<:]]".$busqpor."' $keywords) ";
		}

		if($rango!=''){
			$vrango=explode('_', $rango);
	 			$r1=$vrango[0];
	 			$r2=$vrango[1];
			$busqueda.=" and (p.precio >= $r1 and p.precio <= $r2 )";
		}


		return " SELECT p.* , g.archivo
                 FROM ".PRODUCTOS." p
                 left join ".EMPRESAS." e on p.id_empresa=e.id_empresa
                 left join ".KEYWORD_PRODUCTO." k on k.id_producto=p.id_producto
				 $join
				  left join ".GALERIA_IMAGENES." g on p.id_galeria=g.id_galeria
				  $busqueda
				 GROUP BY p.id_producto
                 order by $ordenar ";
	}

	public function listarOfertasSQL($categoria=0,$busqpor='',$orden='',$siguiendo=0,$rango='',$lkeywords,$seed=0){
		$busqueda = " where borrado='0' and p.estado<>'Inactivo' ";
		$join='';
		$ordenar='';
		$porcentaje=', CEIL(100-(oferta_precio*100/precio)) as porcentaje ';

		if($categoria ){
			$busqueda .= " and e.id_categoria =$categoria";
		  $join=" left JOIN ".ECATEGORIA." c ON e.id_categoria = c.id_categoria ";
		}

		$keywords='';
		if(count($lkeywords ) ){
			$busq = "";
			foreach($lkeywords as $key){
				$busq .= " or (k.id_keyword = ".$key['id_keyword'].")";
			}
	      $keywords .= " or (0 $busq)";
		}

		if($busqpor!=''){
			$busqueda.=" and (p.nombre RLIKE '[[:<:]]".$busqpor."' OR p.descripcion RLIKE '[[:<:]]".$busqpor."' OR p.oferta_descripcion RLIKE '[[:<:]]".$busqpor."' OR e.nombre RLIKE '[[:<:]]".$busqpor."' $keywords) ";
		}

		if($orden!=''){
			$ordenar=' order by '.$orden;

		}
		else if($seed){
			$ordenar=" order by rand($seed)";
		}

		if($siguiendo and nvl($_SESSION['id_tipo_usuario'],0)==5){
			$join.= " left join ".USUARIOS_EMPRESA." ue on e.id_empresa=ue.id_empresa ";
			$busqueda.=" and ue.id_usuario=".$_SESSION['id_usuario']." and ue.siguiendo='1' ";
		}

		if($rango!=''){
			$vrango=explode('_', $rango);
	 			$r1=$vrango[0];
	 			$r2=$vrango[1];
	 		if($r1!='undefined' and $r2!='undefined')
			$busqueda.=" and (p.oferta_precio >= $r1 and p.oferta_precio <= $r2 )";
		}

		$sql= "SELECT p.*, g.archivo, e.nombre as empresa,p.precio+0,p.oferta_precio+0 $porcentaje FROM ".PRODUCTOS." p
				left join ".EMPRESAS." e on p.id_empresa= e.id_empresa
				left join ".KEYWORD_PRODUCTO." k on k.id_producto=p.id_producto
		        $join
                LEFT JOIN ".GALERIA_IMAGENES." g ON p.id_galeria = g.id_galeria
				$busqueda
				GROUP BY p.id_producto $ordenar ";
				//echo $sql;
		return $sql;
	}


	/**
	 * Select opciones activas
	 *
	 * lista todas las ofertas
	 * $id(id del producto)
	 */
	public function listBoxOfertas($default="",$tipolista=''){
		$join=" ";
		$nombre=" p.nombre";
		if($tipolista=='conimagen'){
			$join=" LEFT JOIN ".GALERIA_IMAGENES." g ON p.id_galeria = g.id_galeria ";
			$nombre="concat(g.archivo,'_',p.nombre) as nombre";
		}

		$sql = "select p.id_producto, $nombre from ".PRODUCTOS."  p $join where p.oferta_portal='Activo' and p.borrado='0' and p.oferta_publicacion <= CURDATE() and p.oferta_vencimiento > CURDATE()  and oferta_aprobada='Si'
				GROUP BY p.id_producto   order by p.nombre ";
		return $this->db->listbox($sql,$default);
	}


	/**
	 * listarSQLporCategoria
	 *
	 * lista todas las productos manda el una cadena con la consulta, sin query
	 * $id(id de la categoria de los productos)
	 *
	 * @return 	array.
	 */

	public function listarPorCategoria($id, $start , $limit  ){

		return "SELECT DISTINCT p.id_producto, p.nombre, p.referencia, p.entradilla, p.precio, p.imagen, g.archivo , c.nombre_categoria as categoria FROM ".PRODUCTOS." p
		        JOIN ".CATEGORIAS." c ON p.id_categoria = c.id_arbol
                LEFT JOIN ".GALERIA_IMAGENES." g ON p.id_galeria = g.id_galeria
				WHERE p.id_categoria = '$id' and borrado='0'
				GROUP BY p.id_producto
				LIMIT ".$start.",".$limit."
				ORDER by nombre asc ";
		return $this->db->result_array( $this->db->query($sql) );
	}

	/**
	 * resultArr
	 *
	 * realiza el resulta array sobre un query que recive
	 * $qid(query de la consulta)
	 *
	 * @access	public
	 */
	public function resultArr($qid){
	return $this->db->result_array($qid);
	}

	public function resultQuery($sql){
	return $this->db->result_array( $this->db->query($sql) );
	}


	/**
	 * listarUltimas
	 *
	 * lista las n ultimas productos
	 * inicio de la busqueda y la cantida que va a sacar
	 *
	 * @access	public
	 * @author	Cer�n
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.
	 */

	public function listarUltimos($inicio=0,$cantidad=2){
		$sql = "select   p.id_producto , p.nombre, p.entradilla, p.precio, p.imagen,g.archivo, g.referencia from ".PRODUCTOS." p
		               	 LEFT JOIN ".GALERIA_IMAGENES." g on p.id_galeria = g.id_galeria
						 where borrado='0'
						  GROUP BY p.id_producto
						 ORDER BY p.id_producto desc limit $inicio, $cantidad";
		$qid = $this->db->query($sql);
		return $this->db->result_array($qid);
	}


  /**
	 * updateimagen
	 *
	 * actualiza el campo de imagen cuando es eliminada la imagen
	 * id de la producto
	 *
	 * @return 	void.
	 */

	public function updateimagen($id){
	   $imagen = "";
	   $this->db->query("Update ".PRODUCTOS." set imagen = '$imagen' where id_producto = '$id'" );
	}

	public function busqueda($busqueda,$tipo='',$lkeywords=array()){
		$and = " and  p.borrado='0' and p.estado<>'Inactivo' ";

		if($tipo=='empresa')
			$and.=' and p.id_empresa= '.$_SESSION['id_empresa'];
		elseif($tipo=='oferta'){
			$and.=" and p.oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and p.oferta_vencimiento > CURDATE() and oferta_aprobada='Si' " ;
		}

		$keywords='';
		if(count($lkeywords ) ){
			$busq = "";
			foreach($lkeywords as $key){
				$busq .= " or (k.id_keyword = ".$key['id_keyword'].")";
			}
	      $keywords .= " or (0 $busq)";
		}

			$sql= "SELECT DISTINCT p.*, g.archivo
			        FROM ".PRODUCTOS." p
			        left join ".EMPRESAS." e on p.id_empresa=e.id_empresa
					LEFT JOIN ".GALERIA_IMAGENES." g ON p.id_galeria = g.id_galeria
					left join ".KEYWORD_PRODUCTO." k on k.id_producto=p.id_producto
					WHERE  (p.nombre RLIKE '[[:<:]]".$busqueda."' OR p.descripcion RLIKE '[[:<:]]".$busqueda."' OR p.oferta_descripcion RLIKE '[[:<:]]".$busqueda."' OR e.nombre RLIKE '[[:<:]]".$busqueda."' $keywords) $and
					GROUP BY p.id_producto
					ORDER BY p.id_producto DESC";
				//echo $sql;

		 return $this->db->result_array( $this->db->query($sql) );
	}

	public function subirArchivo( $campo, $tipo='imagen'){
		$nomfile = date("Ymdhis".rand(10,999));

		$img = new images($_FILES[$campo]);
		$img->file_new_name_body = $nomfile;

		if($tipo!='imagen'){
			$img->file_name_body_pre = 'b';
			$img->allowed = array('image/*');
			$img->image_resize = true;
			$img->image_ratio_fill = true;
			$img->image_x = 1024;
			$img->image_y = 550;
			$img->process($this->dirfile);

			$img->file_new_name_body = $nomfile;
			$img->file_name_body_pre = 'm';
			$img->allowed = array('image/*');
			$img->image_resize = true;
			$img->image_ratio_fill = true;
			$img->image_x = 500;
			$img->image_y = 268;
			$img->process($this->dirfile);

			$img->file_new_name_body = $nomfile;
			$img->file_name_body_pre = 'a';
			$img->allowed = array('image/*');
			$img->image_resize = true;
			$img->image_ratio_fill = true;
			$img->image_x = 320;
			$img->image_y = 172;
			$img->process($this->dirfile);


			$img->file_new_name_body = $nomfile;
			$img->file_name_body_pre = 's';
			$img->allowed = array('image/*');
			$img->image_resize = true;
			$img->image_ratio_fill = true;
			$img->image_x = 104;
			$img->image_y = 56;
			$img->process($this->dirfile);

			$this->datos['oferta_imagen'] = $nomfile.'.'.$img->file_dst_name_ext;
		}
	}

	public function borrarImagen($id,$tipo='imagen'){
		$sql = "select $tipo from ".PRODUCTOS." where id_producto = '$id' ";
		$imagen = $this->db->fetch_array( $this->db->query($sql) );

		if( file_exists($this->dirfile."s".$imagen[$tipo]) )
			@unlink($this->dirfile."s".$imagen[$tipo]);
		if( file_exists($this->dirfile."m".$imagen[$tipo]) )
			@unlink($this->dirfile."m".$imagen[$tipo]);
		if( file_exists($this->dirfile."b".$imagen[$tipo])	)
			@unlink($this->dirfile."b".$imagen[$tipo]);
		if( file_exists($this->dirfile."a".$imagen[$tipo])	)
			@unlink($this->dirfile."a".$imagen[$tipo]);
		$reg[$tipo] = '';
		return $this->db->update($reg, PRODUCTOS, "id_producto = '$id' ");

	}

	/******* cuenta cuantas ofertas activas  hay en el portal*///////////
	public function numOfertas($search='' ,$id_empresa=0,$activas=1){
		if($id_empresa)
 			$busq=" where (oferta_portal='Activo' or oferta='Activo')  and borrado='0' and p.id_empresa=$id_empresa ";
		else{
			$busq=" where oferta_portal='Activo' and borrado='0'  and p.oferta_vencimiento > CURDATE() ";
			if($activas)
				$busq.=" and p.oferta_publicacion <= CURDATE() ";
		}

		if($search!=''){
			$busq.=" and (p.nombre LIKE '%$search%' OR p.descripcion LIKE '%$search%' OR p.oferta_descripcion LIKE '%$search%' or e.nombre LIKE '%$search%')";
		}


		$sql = "select * FROM ".PRODUCTOS." p left join ".EMPRESAS." e on p.id_empresa=e.id_empresa  $busq  ";

		return $this->db->num_rows( $this->db->query($sql) );

	}

	public function listarOfertas($start=0,$lenght=0,$sort='id_producto',$dir='desc',$search='',$id_empresa=0,$activas=1){
		if($id_empresa)
 			$busq=" where (oferta_portal='Activo' or oferta='Activo')  and borrado='0' and p.id_empresa=$id_empresa ";
		else{
			$busq=" where oferta_portal='Activo' and borrado='0' and p.oferta_vencimiento > CURDATE()";
			if($activas)
				$busq.=" and p.oferta_publicacion <= CURDATE()";
		}

		if($search!='')
		{
			$busq.=" and (p.nombre LIKE '%$search%' OR p.descripcion LIKE '%$search%'  OR p.oferta_descripcion LIKE '%$search%' or e.nombre LIKE '%$search%' or(concat(p.id_producto,'_',p.referencia) LIKE '%$search%') ) ";
		}

		$pag='';
		if($lenght)
		$pag= "limit $start, $lenght";

		$sql = "select p.*, CEIL(100-(p.oferta_precio*100/p.precio)) as porcentaje, e.nombre as empresa FROM ".PRODUCTOS." p left join ".EMPRESAS." e on p.id_empresa=e.id_empresa $busq
				         order by $sort $dir ".$pag;
		return $this->db->result_array( $this->db->query($sql) );
	}

	public function obtenerMasComprados($limite=3,$id_empresa=0 ){
		$busq="";
		if($id_empresa)
			$busq=" and p.id_empresa=$id_empresa";
		$sql = "select p.* , g.archivo, e.nombre as empresa FROM ".PRODUCTOS." p
				left join ".EMPRESAS." e on p.id_empresa=e.id_empresa
				left join ".GALERIA_IMAGENES." g on p.id_galeria=g.id_galeria
		 where compras<>0 and p.borrado='0' $busq  and p.estado<>'Inactivo' group by p.id_producto order by compras desc, id_producto desc  limit ".$limite;
		return $this->db->result_array( $this->db->query($sql) );
	}
	public function obtenerMasVisitadosTotal( ){

		$sql = " select p.nombre, p.visitas,p.visitas_oferto, visitas+visitas_oferto as vtotal,e.nombre as empresa FROM ".PRODUCTOS." p
				left join ".EMPRESAS." e on p.id_empresa=e.id_empresa
		where (visitas<>0 or visitas_oferto<>0) and p.borrado='0' and p.estado<>'Inactivo' order by vtotal desc, p.id_producto desc limit 10";
		return $this->db->result_array( $this->db->query($sql) );
	}

	public function obtenerMasVisitados($limite=3,$id_empresa=0  ){
	$busq="";
		if($id_empresa)
			$busq=" and p.id_empresa=$id_empresa";
		$sql = "select p.* , g.archivo FROM ".PRODUCTOS." p  left join ".GALERIA_IMAGENES." g on p.id_galeria=g.id_galeria
		where visitas<>0 and borrado='0'  and estado<>'Inactivo' $busq  group by p.id_producto order by p.visitas desc, p.id_producto desc  limit $limite ";
		return $this->db->result_array( $this->db->query($sql) );
	}

	public function productosRecomendados($idp=0,$categorias=array(),$preciomax=0, $preciomin=0){
		$busqueda='';
		$busqc='';
		if(count($categorias ) )
		{
			foreach($categorias as $cat)
			{
				$busqc .= " or (id_categoria = ".$cat['id_categoria'].")";
			}
	      $busqueda .= " and (0 $busqc)";
		}

		if($preciomax)
			$busqueda.= " and precio <=$preciomax";
		if($preciomin)
			$busqueda.= " and precio >=$preciomin";


		$sql = "select p.*,g.archivo FROM ".CATEGORIA_PRODUCTO." c left join ".PRODUCTOS." p on p.id_producto= c.id_producto left join ".GALERIA_IMAGENES." g on p.id_galeria=g.id_galeria  where  borrado='0'  and estado<>'Inactivo' and p.id_empresa=".$_SESSION['id_empresa']." and p.id_producto<>$idp $busqueda group by p.id_producto order by p.id_producto desc  limit 8";
		return $this->db->result_array( $this->db->query($sql) );
	}

	public function listarOfertasVencidas(){
		$sql = "select id_producto from ".PRODUCTOS." where (oferta='Activo' or oferta_portal='Activo') and oferta_vencimiento <= CURDATE() ";
		return $this->db->result_array( $this->db->query($sql) );
	}

	public function listarProductosTodasUbicaciones(){

		$sql = "select id_producto FROM ".PRODUCTOS." where oferta_almacen='todos' and id_empresa=".$_SESSION['id_empresa'];
		return $this->db->result_array( $this->db->query($sql) );
	}

	public function obtenerOfertasDestacadas($cantidad=0,$order='rand()'){

			$busq=" where oferta_portal='Activo' and oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE()   and borrado='0' and oferta_aprobada='Si' and oferta_destacado='Si' ";
			$limite="";
			if($cantidad)
				$limite=" LIMIT 0,$cantidad";
		$porcentaje='';
		if($order=='porcentaje'){
			$order.=' desc';

		}

		$porcentaje=', CEIL(100-(p.oferta_precio*100/p.precio)) as porcentaje ';
		$sql = "select p.* $porcentaje, e.nombre as empresa,g.archivo FROM ".PRODUCTOS." p left join ".EMPRESAS." e on p.id_empresa=e.id_empresa  left join ".GALERIA_IMAGENES." g on p.id_galeria=g.id_galeria  $busq group by p.id_producto
				         order by $order $limite";
		//echo $sql;
		return $this->db->result_array( $this->db->query($sql) );
	}

	public function obtenerOfertasCategoria($id_categoria,$cantidad=0,$order="rand()"  ){
		$limite="";
		if($cantidad){
			$limite= "LIMIT 0,$cantidad";
		}

		$porcentaje='';
		if($order=='porcentaje'){
			$order.=' desc';
		}
		$porcentaje=', CEIL(100-(p.oferta_precio*100/p.precio)) as porcentaje ';
		$sql= "SELECT p.* $porcentaje, g.archivo, e.nombre as empresa FROM ".PRODUCTOS." p
				left join ".EMPRESAS." e on p.id_empresa= e.id_empresa
		        left JOIN ".ECATEGORIA." c ON e.id_categoria = c.id_categoria
                LEFT JOIN ".GALERIA_IMAGENES." g ON p.id_galeria = g.id_galeria
				WHERE e.id_categoria = '$id_categoria' and p.borrado='0' and p.estado<>'Inactivo' and p.oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and oferta_aprobada='Si'
				GROUP BY p.id_producto  ORDER by $order
				$limite";
		return $this->db->result_array( $this->db->query($sql) );
	}

	public function obtenerOfertasMasCompradas($cantidad=0 ){
		$limite='';
		if($cantidad){
			$limite=" LIMIT 0,$cantidad";
		}
		$porcentaje=', CEIL(100-(p.oferta_precio*100/p.precio)) as porcentaje ';

		$sql = "select p.* $porcentaje, g.archivo, e.nombre as empresa FROM ".PRODUCTOS." p  left join ".GALERIA_IMAGENES." g on p.id_galeria=g.id_galeria
		left join ".EMPRESAS." e on p.id_empresa= e.id_empresa
		 where compras<>0 and borrado='0'  and p.estado<>'Inactivo'  and p.oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and oferta_aprobada='Si'    group by p.id_producto order by p.compras desc $limite";
		return $this->db->result_array( $this->db->query($sql) );
	}

	public function obtenerOfertasVencen($fecha){
		$porcentaje=', CEIL(100-(p.oferta_precio*100/p.precio)) as porcentaje ';
		$sql = "select p.* $porcentaje, g.archivo, e.nombre as empresa FROM ".PRODUCTOS." p  left join ".GALERIA_IMAGENES." g on p.id_galeria=g.id_galeria
		left join ".EMPRESAS." e on p.id_empresa= e.id_empresa
		  where borrado='0'  and p.estado<>'Inactivo'  and oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento ='$fecha' and oferta_aprobada='Si'  group by p.id_producto";

		return $this->db->result_array( $this->db->query($sql) );

	}

	public function obtenerCalificacionId($id_calificacion){
		$calificacion= $this->db->fetch_array($this->db->query("select p.*,pr.nombre from ".PRODUCTOS_CALIFICACION." p left join ".PRODUCTOS." pr on p.id_producto=pr.id_producto where id_productos_calificacion = $id_calificacion"));

		if(isset($calificacion['id_productos_calificacion']))
			return $calificacion;
		else
			return false;

	}

	public function obtenerCalificacion($usuario, $producto){
		$calificacion= $this->db->fetch_array($this->db->query("select * from ".PRODUCTOS_CALIFICACION." p where id_producto = $producto and id_usuario=$usuario  "));

		if(isset($calificacion['id_productos_calificacion']))
			return $calificacion;
		else
			return false;

	}

	public function numCalificacion($producto){
		$calificaciones= $this->db->fetch_array($this->db->query("select count(*) as cuenta from ".PRODUCTOS_CALIFICACION." where id_producto = $producto "));
			if($calificaciones['cuenta'])
				return $calificaciones['cuenta'];
			else
				return 0;
	}

	public function listarCalificaciones($producto){
		return $this->db->result_array($this->db->query("select c.*, u.nombre as cliente from ".PRODUCTOS_CALIFICACION." c left join ".PERFIL." u on c.id_usuario=u.id_usuario where c.id_producto = $producto "));
	}


	public function obtenerPromedio($producto){
		$promedio= $this->db->fetch_array($this->db->query("select avg(calificacion) as promedio from ".PRODUCTOS_CALIFICACION." where id_producto = $producto "));
			if($promedio['promedio'])
				return $promedio['promedio'];
			else
				return 0;
	}

	function guardarCalificacion($usuario=0,$producto=0,$calificacion=0){
		if($usuario and $producto){
			$qid = $this->db->query("select * from ".PRODUCTOS_CALIFICACION." where id_producto = '$producto' and id_usuario=$usuario ");
			$out = $this->db->fetch_assoc($qid);
			if($out['id_productos_calificacion'] ){
				$this->db->query("update ".PRODUCTOS_CALIFICACION." set calificacion=$calificacion  where id_productos_calificacion = ".$out['id_productos_calificacion']);
				return $out['id_productos_calificacion'];
			}else{
				$datos=array();
				$datos['id_usuario']= $usuario;
				$datos['id_producto']= $producto;
				$datos['calificacion']= $calificacion;
				if($this->db->insert($datos, PRODUCTOS_CALIFICACION))
					return $this->db->insert_id();
				else
					return false;
			}
		}
		else
			return false;
	}

	function guardarComentarioCalificacion($id_calificacion,$comentario){
			$datos['comentario']= $comentario;
			if($this->db->update($datos ,PRODUCTOS_CALIFICACION , "id_productos_calificacion = '$id_calificacion'"))
				return true;
			else
				return false;

	}

	public function obtenerMaxPrecio(){
		$busqueda = " where  borrado='0' and estado<>'Inactivo'  and id_empresa=".$_SESSION['id_empresa'];
		$precio= $this->db->fetch_array($this->db->query("select max(precio) as precio from ".PRODUCTOS.$busqueda));

		if(isset($precio['precio']))
			return $precio['precio'];
		else
			return 0;

	}
	public function obtenerMaxPrecioOferto($categoria=0,$busqpor='',$siguiendo=0){
		$busqueda = " where p.borrado='0'  and p.estado<>'Inactivo'  and p.oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and oferta_aprobada='Si'  ";

		$join='';

		if($categoria ){
			$busqueda .= " and e.id_categoria =$categoria";
		  $join=" left JOIN ".ECATEGORIA." c ON e.id_categoria = c.id_categoria ";
		}

		if($busqpor!=''){
			$busqueda.=" and (p.nombre LIKE '%$busqpor%' OR p.descripcion LIKE '%$busqpor%'  OR p.oferta_descripcion LIKE '%$busqpor%' or e.nombre LIKE '%$busqpor%')";
		}

		if($siguiendo and nvl($_SESSION['id_tipo_usuario'],0)==5){
			$join.= " left join ".USUARIOS_EMPRESA." ue on e.id_empresa=ue.id_empresa ";
			$busqueda.=" and ue.id_usuario=".$_SESSION['id_usuario']." and ue.siguiendo='1' ";
		}


		$sql="select max(oferta_precio) as precio from ".PRODUCTOS." p
				left join ".EMPRESAS." e on p.id_empresa= e.id_empresa ".$join.$busqueda;

		$precio= $this->db->fetch_array($this->db->query($sql));

		if(isset($precio['precio']))
			return $precio['precio'];
		else
			return 0;
	}

	public function listarOfertasPendientes(){
		$busq=" where oferta_portal='Activo' and borrado='0' and p.oferta_vencimiento > CURDATE() and oferta_aprobada='' ";

		$sql = "select p.*, e.nombre as empresa FROM ".PRODUCTOS." p left join ".EMPRESAS." e on p.id_empresa=e.id_empresa $busq
				         order by oferta_publicacion desc";
		return $this->db->result_array( $this->db->query($sql) );
	}

	public function listarOfertaComentarios($id_empresa,$vista=''){
		$busq=" where oferta_portal='Activo' and borrado='0' and p.oferta_vencimiento > CURDATE() and oferta_aprobada<>'' and id_empresa=$id_empresa ";

		if($vista!==''){
			$busq.=" and oferta_aprobada_vista='$vista' ";
		}

		$sql = "select p.* FROM ".PRODUCTOS." p $busq order by oferta_publicacion desc";
		return $this->db->result_array( $this->db->query($sql) );
	}

	public function estadoOfertaComentariosVista($id_empresa,$vista=''){
		if($id_empresa>0 and $vista!==''){
			$sql = "update ".PRODUCTOS." set oferta_aprobada_vista='$vista' where oferta_aprobada<>'' and id_empresa=$id_empresa ";
			return $this->db->query($sql);
		}
		else
			return 0;
	}

	public function aumentarVisitaUsuario($id_producto,$id_usuario){
		if($id_producto and $id_usuario){
			$producto_visita = $this->db->fetch_array($this->db->query("select * FROM ".PRODUCTO_VISITAS." where id_producto =$id_producto and id_usuario=$id_usuario "));
			if($producto_visita['id_producto_visita']){
				$visitas= $producto_visita['visitas']+1;
				$this->db->query("update ".PRODUCTO_VISITAS." set visitas=$visitas where id_producto_visita=".$producto_visita['id_producto_visita']);
			}
			else{
				$datos['visitas']=1;
				$datos['id_producto']=$id_producto;
				$datos['id_usuario']=$id_usuario;
				$this->db->insert($datos, PRODUCTO_VISITAS );
			}
		}
	}

	public function listarOfertasVisitadasUsuario($id_usuario,$cantidad=''){
		$limite='';
		if($cantidad!='')
			$limite=" limit ".$cantidad;
		$busq=" where oferta_portal='Activo' and oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE()   and borrado='0' and oferta_aprobada='Si' ";
		$sql="select p.nombre,p.oferta_descripcion FROM ".PRODUCTOS." p join ".PRODUCTO_VISITAS." v on p.id_producto=v.id_producto $busq and  v.id_usuario =$id_usuario order by v.visitas desc $limite ";
		return $this->db->result_array($this->db->query($sql));
	}
}
?>