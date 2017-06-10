<?php
/**
  * controlador contenido
  */

class Contenido extends ControlBase {
	

	  /*
	 * list_contenidos
	 */


	public function lista(){


	 $contenidos  = new contenidos();

	 $cont = $contenidos->listar();

     $reg['tabla'] ='
	  <thead>
		<tr>
		  <th>Id</th>
		  <th>Título</th>
		  <th>Vínculo</th>
		  <th>Opciones</th>
		</tr>
	  </thead>';

	 $reg['tabla'] .='<tbody>';

	 $borrar = "";
	 foreach($cont as $content){

	   if($content['borrar'] == 1){
         $borrar = '<a class="delete btn btn-mini btn-danger" >Eliminar</a>';
	   }
	   else
	   $borrar='';

	   $reg['tabla'] .='
            <tr >
              <td>'.$content['id_contenido'].'</td>
              <td>'.$content['titulo'].'</td>
              <td><a href="http://'.DOMINIO.URLBASE.'contenido-index-id-'.$content['id_contenido'].'" target="_blank">http://'.DOMINIO.URLBASE.'contenido-index-id-'.$content['id_contenido'].'</a></td>
              <td><a class="btn btn-mini" href="contenido-editar-id-'.$content['id_contenido'].'">Editar</a> '.$borrar.'</td>
            </tr>';

	 }

	 $reg['tabla'] .='</tbody>';

	 $this->view->show("admin/list_contenidos.php", $reg);

	}




	/**
	 * editar_contenido
	 */


	 public function editar(){
		$reg['mensaje'] = '';
		$reg['tarea'] = 'Agregar';
		$contenido = new contenidos();

		if($this->input->post('dat') == false ){
			
			if(isset($this->get['id']) and $_SESSION['id_tipo_usuario']==2){
				$tipo=0;
				$reg['reg'] = $contenido->obtener($this->get['id']);
			}else {
			$tipo= nvl($this->get['t'],1);
				$reg['reg'] = $contenido->obtenerEmpresa($_SESSION['id_empresa'],$tipo);
			}
			
				
			$reg['tarea'] = 'Editar';
		}
 			
		if($this->input->post('dat') ){
			$datos=$this->input->post('dat',false);

			$contenido->datos = $this->input->post('dat'); 
			$contenido->datos['contenido']= $datos['contenido'];
			
			$tipo= $datos['tipo'];

			$reg['tarea'] = 'Editar';
			if($id = $contenido->guardar($this->input->post('id'))){
				$reg['mensaje'] = "Contenido guardado";
			}
			else{
				$reg['mensaje'] = "Ocurri&oacute; un error al guardar, comunicarse con soporte.";
			}

			$reg['reg'] = $contenido->obtener($id);
		}
		 
		 if($tipo==1)
			$reg['tipo']='Quiénes Somos';
		elseif($tipo==2){
			$reg['tipo']='Cómo Comprar';
			$reg['reg']['tipo']=2;
		}
		elseif($tipo==3){
			$reg['tipo']='Términos y condiciones';
			$reg['reg']['tipo']=3;
		}
		else{
		$reg['tipo']='Contenido';
		$reg['reg']['tipo']=0;
		}
			
        $this->view->show("admin/edit_contenido.php", $reg);
	}

	 /**
	 * borrar un contenido recibe por post el id del contenido
	 * Solicitud por ajax
	 */

	 public function borrar(){
		$contenido = new contenidos();
		if($contenido->borrar($this->input->post('id')) )
			echo "1";
		else
			echo "0";
	 }

	 public static function contenido_texto($id=0){
	 	$contenidos= new Contenidos();
	 	$cont= $contenidos->obtener($id);
	 	$contenido=preg_replace("/<img[^>]+\>/i", "", $cont['contenido']); 
	 	return substr($contenido, 0,300);

	 }


}