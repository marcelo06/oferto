<?php

/**
  * modelo Categorias
  *
  *
  *
  * @package   categorias
  * @author	   Sebastian Lopez
  * @since	   20100519
  * @version   20100519
  */


class Ecategorias extends ModelBase
{

    public $dirfile ;
	public $dirfileout ;

	function __construct(){
      parent::__construct();
      $this->dirfile = FILES."categorias/";
	  $this->dirfileout = URLFILES."categorias/";
	}



   /**
	 * guardar
	 *
	 * Guarda las categorias
	 * identidaor
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	int.
	 */

	public function guardar( $id =0 ){
		if($id>0)
			$this->db->update($this->datos ,ECATEGORIA , "id_categoria = '$id'" );
		else{
			$this->db->insert($this->datos, ECATEGORIA );
			$id = $this->db->insert_id();
		}

		$this->db->query("update ".VERSIONES." set actualizado=NOW() where tipo='categoria' ");
         return $id;
	}



	/**
	 * borrar
	 *
	 * Borra el registro de la categoria seleccionada
	 * identidaor de la categorias
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	boolean.
	 */

	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_categoria from ".ECATEGORIA." where id_categoria = '$id' ")) > 0 ){

			$this->db->query("delete from ".ECATEGORIA." where id_categoria = '$id' ");
			return true;
		}else
			return false;
	}


	/**
	 * numRegistrosCategorias
	 *
	 * Cuenta el numero de registro de las categorias
	 *
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	int.
	 */


	public function numRegistrosCategorias(){

		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".ECATEGORIA." ");
		$row =  $this->db->fetch_array($result);
		return $row['count'];

	}


	/**
	 * listarCategorias
	 *
	 * hace las consulta de las categorias para el listado del grid
	 * orden(parametro de ordenamiento), direccion(asc,desc), start(comienzo de la consulta), limit(cantidad de registro por consulta)
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.
	 */

	public function listarCategorias($orden="id_categoria" , $direccion = "asc", $start, $limit, $buscar=''  ){
	    $busqueda = " where 1 = 1 ";
		if($buscar != ""){
			$busqueda.= " and categoria LIKE '%$buscar%' ";
		}

		$sql = "select * FROM ".ECATEGORIA." $busqueda order by $orden $direccion LIMIT  $start, $limit ";
		return $this->db->result_array( $this->db->query($sql) );
	}



	/**
	 * listar
	 *
	 * hace las consulta de las categorias
	 *
	 * @access	public
	 * @author	Diana
	 * @since	20110714
	 * @version	20110714
	 * @return 	array.
	 */

	public function listar($tipo){
		$sql = "SELECT * FROM ".ECATEGORIA." WHERE tipo='$tipo' ORDER BY categoria,id_categoria";
		return $this->db->result_array( $this->db->query($sql) );
	}

    /**
	 * obtener
	 *
	 * obtiene la informacion de un registro
	 * id(identificador de la categoria)
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.
	 */

	public function obtener($id){
		return $this->db->fetch_array($this->db->query("select * from ".ECATEGORIA." where id_categoria = '$id' order by id_categoria"));
	}

	public function obtenerIdPorNombre($categoria){
		$sql = "SELECT * FROM ".ECATEGORIA." WHERE  categoria = '$categoria'";
		$ase = $this->db->query($sql);
		if($this->db->num_rows($ase) >0){
			$asesor= $this->db->fetch_array($ase);
			return $asesor['id_categoria'];
		}else
			return 0;
	}


	/**
	 * listarSQL
	 *
	 * lista todas las categorias manda el una cadena con la consulta, sin query
	 *
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.
	 */


	public function listarSQL($sql=""){
		return "select * from ".ECATEGORIA."  order by id_categoria ";
	}


	/**
	 * resultArr
	 *
	 * realiza el resulta array sobre un query que recive
	 * $qid(query de la consulta)
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.
	 */


	public function resultArr($qid){
	return $this->db->result_array($qid);
	}


	public function listBoxCategorias($default="")
	{
		return $this->db->listbox("select id_categoria, categoria from ".ECATEGORIA." order by categoria ",$default);
	}

	public function listarCategoriasPrincipales($cantidad=0, $oferta=1 ){
	    $busq=" where p.borrado='0' and p.estado<>'Inactivo' and c.id_categoria<>22 ";
	    $limite = "";
		if($cantidad){
			$limite.= " LIMIT 0,$cantidad";
		}
		if($oferta){
			$busq.=" and p.oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and oferta_aprobada='Si' ";
		}

		$sql = "SELECT count(p.id_producto) as count, c.*,p.nombre FROM ".ECATEGORIA." c join ".EMPRESAS." e on e.id_categoria= c.id_categoria  join ".PRODUCTOS." p on e.id_empresa= p.id_empresa $busq group by c.id_categoria order by count desc $limite";

		return $this->db->result_array( $this->db->query($sql) );
	}

	public function numOfertasCategoria($categoria,$siguiendo=0){
		$join="";
		$busqueda = " where  borrado='0' and p.estado<>'Inactivo' and oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and oferta_aprobada='Si'  ";

		if($siguiendo and nvl($_SESSION['id_tipo_usuario'],0)==5){
			$join.= " left join ".USUARIOS_EMPRESA." ue on e.id_empresa=ue.id_empresa ";
			$busqueda.=" and ue.id_usuario=".$_SESSION['id_usuario']." and ue.siguiendo='1' ";
		}

		$sql= " SELECT p.* from ".ECATEGORIA." c join ".EMPRESAS."  e on e.id_categoria=c.id_categoria left join ".PRODUCTOS." p  on p.id_empresa=e.id_empresa $join $busqueda and c.id_categoria=$categoria group by p.id_producto";
		 return $this->db->num_rows( $this->db->query($sql));
	}

	public function busqueda($texto){
		 $sql = "select * FROM ".ECATEGORIA." where categoria like '%$texto%' order by categoria,id_categoria ";
		return $this->db->result_array( $this->db->query($sql) );
	}

	public function aumentarVisita($id_categoria,$id_usuario){
		if($id_categoria and $id_usuario){
			$categoria_visita = $this->db->fetch_array($this->db->query("select * FROM ".CATEGORIA_VISITAS." where id_categoria =$id_categoria and id_usuario=$id_usuario "));
			if($categoria_visita['id_categoria_visita']){
				$visitas= $categoria_visita['visitas']+1;
				$this->db->query("update ".CATEGORIA_VISITAS." set visitas=$visitas where id_categoria_visita=".$categoria_visita['id_categoria_visita']);
			}
			else{
				$datos['visitas']=1;
				$datos['id_categoria']=$id_categoria;
				$datos['id_usuario']=$id_usuario;
				$this->db->insert($datos, CATEGORIA_VISITAS );
			}
		}
	}

	public function listarCategoriasVisitadas($id_usuario){
		$sql="select c.* FROM ".ECATEGORIA." c join ".CATEGORIA_VISITAS." v on c.id_categoria=v.id_categoria where v.id_usuario =$id_usuario order by visitas desc";
		return $this->db->result_array($this->db->query($sql));
	}
}

?>