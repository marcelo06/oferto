<?php

class Almacen extends ControlBase {

	public function index(){
	
	$almacen= new Almacenes();
	$tipo= $this->get['t'];
	$reg['titulo_sitio']= ($tipo=='Almacen')? 'Almacenes':'Puntos de Venta';
	$reg['almacenes']=$almacen->listar($tipo);
	
		$this->view->show("almacenes.php", $reg);
	}
	
	
	
	
    public function lista(){


		$almacen  = new Almacenes();
		 $cont = $almacen->listar($_SESSION['id_empresa']);

	     $reg['tabla'] ='
		  <thead>
			<tr>
			  <th>Id</th>
			  <th>Nombre</th>
			  <th>Dirección</th>
			  <th>Teléfono</th>
			 <th>Ubicación</th>
			  <th>Opciones</th>
			</tr>
		  </thead>';

		 $reg['tabla'] .='<tbody>';
		 foreach($cont as $content){

		   $reg['tabla'] .='
	            <tr id="row_'.$content['id_almacen'].'" >
	              <td>'.$content['id_almacen'].'</td>
	              <td>'.$content['nombre'].'</td>
	              <td>'.cutstr($content['direccion'],100).'</td>
				   <td>'.$content['telefono'].' - '.$content['movil'].'</td>
				 <td>'.$content['ubicacion'].'</td>
				 
	              <td width="120"><a class="btn btn-mini" href="almacen-editar-id-'.$content['id_almacen'].'">Editar</a> <a class="delete btn btn-mini btn-danger" href="javascript:borrar('.$content['id_almacen'].')" >Eliminar</a></td>
	            </tr>';

		 }
		 $reg['tabla'] .='</tbody>';


	    $this->view->show("admin/list_almacenes.php", $reg);
	 }



	 public function editar(){

	    $ser = new Almacenes();
		$reg['tarea'] = 'Agregar';
		$reg['mensaje'] = '';
		
		$id = isset($this->get['id']) ? $this->get['id'] : $this->input->post('id_almacen');

		if(isset($this->get['id']) && ($this->input->post('dat') == false )){
			$reg['reg'] = $ser->obtener($id);
			$reg['tarea'] = 'Editar';
			
		}
		

		if( $this->input->post('dat') ){

			if($this->input->post('delimg') and $this->input->post('id_almacen')){
				$ser->borrarImagen($this->input->post('id_almacen'));	
			} 


			$ser->datos = $this->input->post('dat');
			if(is_uploaded_file(nvl($_FILES['archivo']['tmp_name']))){
			    $ser->subirArchivo('archivo');
			 }
			 
		    
			$id = $ser->guardar($id);

			if(!$this->input->post('id_almacen')){
				$datosalm= array();
				$datosalm[0]['id_almacen']=$id;
				$productos=new productos();
				$prod=$productos->listarProductosTodasUbicaciones();
			
				foreach($prod as $producto){
					 $ser->guardarAlmacenProducto($datosalm,$producto['id_producto'],false);
				}

			}
			$reg['reg'] = $ser->obtener($id);
			$reg['mensaje'] = 'Ubicación Guardada';
		}
		

		 $reg['dirfileout'] = $ser->dirfileout;
		 $this->view->show("admin/edit_almacen.php", $reg);
	  }

	  public function borrar_img(){
			$id = $this->input->post('id');
			$ser = new Almacenes();
			if($ser->borrarImagen($id)){
				echo 1;	
			}else{
				echo 0;
			}
	  }	

	 public function borrar(){
	   $almacen  = new Almacenes();
		if($almacen->borrar($this->input->post('id')) )
			echo "1";
		else
			echo "0";
	 }

	  static function listarUltimos(){

	   $almacen  = new Almacenes();
	   return $almacen->listar();
	 }

	 static function tieneAlmacenes($id_empresa){
	 	$almacenes= new Almacenes();
	 	return $almacenes->numUbicacionesEmpresa($id_empresa);


	 }



}
?>