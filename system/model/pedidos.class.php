<?php

/**
  * modelo Pedidos
  *
  *
  *
  * @package   pedidos
  * @author	   Sebastian Lopez
  * @since	   20100519
  * @version   20100519
  */


class Pedidos extends ModelBase
{



   /**
	 * guardar
	 *
	 * Guarda las pedidos
	 * identidaor
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	int.
	 */

	public function guardar ( $id =0 ){
		if($id>0)
			$this->db->update($this->datos ,PEDIDOS , "id_pedido = '$id'" );
		else{
			$this->db->insert($this->datos, PEDIDOS );
			$id = $this->db->insert_id();
		}
             return $id;
	}

	public function guardarProductosPedido ($dat, $id =0 ){
		if($id>0)
			$this->db->update($dat ,PRODUCTOS_PEDIDO , "id_pedido = '$id'" );
		else{
			$this->db->insert($dat, PRODUCTOS_PEDIDO );
			$id = $this->db->insert_id();
		}
             return $id;
	}


	/**
	 * borrar
	 *
	 * Borra el registro de la pedido seleccionada
	 * identidaor de la pedidos
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	boolean.
	 */

	public function borrar($id){
		if($this->db->num_rows($this->db->query("select id_pedido from ".PEDIDOS." where id_pedido = '$id' ")) > 0 ){

			$this->db->query("update  ".PEDIDOS." set borrado='1' where id_pedido = '$id' ");
			return true;
		}else
			return false;
	}



	/**
	 * numRegistrosPedidos
	 *
	 * Cuenta el numero de registro de las pedidos
	 *
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	int.
	 */


	public function numRegistrosPedidos(){

		$result = $this->db->query("SELECT COUNT(*) AS count FROM ".PEDIDOS." ");
		$row =  $this->db->fetch_array($result);
		return $row['count'];

	}


	public function listar($id_empresa=0,$pedientes=0 ){
		$busq="";
		
		if($id_empresa)
			$busq.=" and p.id_empresa=".$id_empresa;

		if($pedientes)
			$busq.=" and (p.estado='' or p.estado='Pago pendiente') ";

		
		
		
		$sql = "select p.id_pedido as id_pedido, p.fecha as fecha,p.orden, p.metodo_pago, p.estado, p.total,p.dominio,p.codigo_descuento,e.nombre as empresa,concat(c.nombre,' ',c.apellidos ) as nombre, concat(p.nombre_pedido,' ',p.apellidos_pedido ) as nombre_pedido, u.id_empresa as usuempresa FROM ".PEDIDOS." p 
		left JOIN ".PERFIL." c ON p.id_usuario = c.id_usuario
		left JOIN ".USUARIOS." u ON u.id_usuario = p.id_usuario
		 left join ".EMPRESAS." e on e.id_empresa=p.id_empresa where p.borrado='0' $busq 
				order by p.id_pedido desc";

		return $this->db->result_array( $this->db->query($sql));

	}

	/**
	 * listarPedidos
	 *
	 * hace las consulta de las pedidos para el listado del grid
	 * orden(parametro de ordenamiento), direccion(asc,desc), start(comienzo de la consulta), limit(cantidad de registro por consulta)
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.
	 */

	public function listarPedidos($orden="fecha" , $direccion = "", $start, $limit ){


		$sql = "select p.id_pedido as id_pedido, p.fecha as fecha, c.nombre as nombre,p.total FROM ".PEDIDOS." p JOIN ".CLIENTES." c
		        ON p.id_cliente = c.id_cliente
				order by $orden desc LIMIT  $start, $limit ";

		return $this->db->result_array( $this->db->query($sql) );

	}


	public function listarProductosPedido( $id_pedido ){
		$sql = "select * FROM ".PRODUCTOS_PEDIDO." 
				WHERE id_pedido = '$id_pedido'
				order by id_pedido desc ";

		return $this->db->result_array( $this->db->query($sql) );

	}

    /**
	 * obtener
	 *
	 * obtiene la informacion de un registro
	 * id(identificador de la pedido)
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.
	 */

	public function obtener($id){
		return $this->datos = $this->db->fetch_array($this->db->query("select  * from ".PEDIDOS." where id_pedido = '$id' "));
	}


	public function obtenerPorOrden($orden){
		return $this->datos = $this->db->fetch_array($this->db->query("select  * from ".PEDIDOS." where orden = '$orden' "));
	}

	  /**
	 * obtener
	 *
	 * obtiene la informacion del cliente de  un pedido
	 * id(identificador de la pedido)
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.
	 */

	public function obtenerCliente($id){
		return $this->datos = $this->db->fetch_array($this->db->query("select  c.*,u.email from ".PERFIL." c join ".PEDIDOS." p on  p.id_usuario = c.id_usuario join ".USUARIOS." u on c.id_usuario=u.id_usuario where p.id_pedido = ".$id));
	}

/* lista compras realizadas con exito por un usuario dado*/
	public function countExitoPorUsuario($id_usuario,$id_empresa=""){
		$empresa='';
		if($id_empresa!=''){
			$empresa=' and id_empresa='.$id_empresa;
		}
		$sql= "select count(*) as count FROM ".PEDIDOS."
				Where id_usuario = '$id_usuario' and borrado='0' and estado='Pago confirmado' $empresa";
		$row =  $this->db->fetch_array($this->db->query($sql));
		return $row['count'];	
	}
	
	/* lista compras realizadas con exito*/
	public function countExito($de=''){
		$busq='';
		if($de=='oferto'){
			$busq.="and u.id_empresa=0 ";
		}
		else if($de=='empresas'){
			$busq.="and u.id_empresa<>0 ";
		}

		$sql= "select count(*) as count FROM ".PEDIDOS." p
				left join ".USUARIOS." u on p.id_usuario=u.id_usuario 
				Where p.borrado='0' and p.estado='Pago confirmado' $busq ";
		$row =  $this->db->fetch_array($this->db->query($sql));
		return $row['count'];	
	}

	public function contarPorUsuario($id_usuario, $estado=0){
		$busq='';
		if($estado)
		$busq=" and (metodo_pago='Otro' or (metodo_pago='Payu' and compra='1')) ";
		$sql= "select p.id_pedido FROM ".PEDIDOS." p JOIN ".PERFIL." c
		        ON p.id_usuario = c.id_usuario
		        left join ".EMPRESAS." e on p.id_empresa=e.id_empresa
				Where p.id_usuario = '$id_usuario' and borrado='0' $busq
				order by p.id_pedido desc,compra asc ";
				
	return $this->db->num_rows( $this->db->query($sql));

	}
	
	public function listarPorUsuario($id_usuario, $estado=0){
		$busq='';
		if($estado)
		$busq=" and (metodo_pago='Otro' or (metodo_pago='Payu' and compra='1')) ";
		$sql= "select p.*,c.*, e.nombre as empresa FROM ".PEDIDOS." p JOIN ".PERFIL." c
		        ON p.id_usuario = c.id_usuario
		        left join ".EMPRESAS." e on p.id_empresa=e.id_empresa
				Where p.id_usuario = '$id_usuario' and borrado='0' $busq
				order by p.id_pedido desc,compra asc ";
				
	return $this->db->result_array( $this->db->query($sql));

	}
	/**
	 * listarSQL
	 *
	 * lista todas las pedidos manda el una cadena con la consulta, sin query
	 *
	 *
	 * @access	public
	 * @author	Sebastian Lopez
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.
	 */



	public function listarSQLUsuario($id_usuario, $sql=""){
		return "select * FROM ".PEDIDOS." p JOIN ".PERFIL." c
		        ON p.id_usuario = c.id_usuario
				Where p.id_usuario = '$id_usuario' and borrado='0'
				order by p.id_pedido desc ";

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



}

?>