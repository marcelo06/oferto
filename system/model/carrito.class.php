<?php 

// Carrito Version 0.1
// Sebastian by RHISS.NET

class Carrito extends ModelBase
{
	
	public $nf;
	
	
	function __construct(){
		parent::__construct();
		if(isset($_SESSION['nf']) && isset($_SESSION['carro'])){
			$this->nf = $_SESSION['nf'];
			$this->carro = $_SESSION['carro'];
		}else
			$this->nf = 0;
	}
	
		
	public function addProducto($nombre,$id_producto, $identificador, $valor, $cantidad, $imagen,$referencia){
		if($this->nf == 0)
			$key = false;
		elseif($this->carro['identificador'] > 0){
			$key = array_search($identificador, $this->carro['identificador']);
			if($key !== false)
				if($this->carro['estado'][$key]==0){
					$this->carro['estado'][$key] = 1;
					$this->carro['cantidad'][$key] = 0;
				}
		}else
			$key = false;
		
		if( $key === false){
			
			$this->carro['nombre'][$this->nf] = $nombre;
			$this->carro['producto'][$this->nf] = $id_producto;
			$this->carro['identificador'][$this->nf] = $identificador;
			$this->carro['precio'][$this->nf] = $valor;
			$this->carro['referencia'][$this->nf] = $referencia;
			$this->carro['cantidad'][$this->nf] = $cantidad;
			$this->carro['imagen'][$this->nf] = $imagen;
			$this->carro['estado'][$this->nf] = 1;
			$this->carro['nf'][$this->nf] = $this->nf;
			$this->nf++;
		}else{
			$this->carro['cantidad'][$key] = $this->carro['cantidad'][$key]+$cantidad;
			$this->carro['valor'][$key] = $valor;
		}
		
		$this->sincronizar();
	}
	
	public function updateProducto( $nf, $cantidad, $estado = 1 ){
		if($cantidad === 0)
			$estado = 0;
			
		if($cantidad !== false) $this->carro['cantidad'][$nf] = $cantidad;
		if($estado !== false) $this->carro['estado'][$nf] = $estado;
		$this->sincronizar();
	}
	
	public function numProductos(){
		$num=0;
		for($p =0; $p<$this->nf; $p++)
				if(nvl($this->carro['estado'][$p]))
					$num++;
		return $num;
	}
	
	
	public function numCompras(){
	return $this->nf;
	}

	
    public function destruirCarrito(){
	  unset ($_SESSION['carro']);
	  unset ($_SESSION['nf']);

	}

	
	public function sincronizar(){
		$_SESSION['carro'] = $this->carro;
		$_SESSION['nf'] = $this->nf;
	}
			
}

?>