<?php
/**
  * controlador notificacion
  */

class Notificacion extends ControlBase {
	

	 /*
	 * list_notificaciones
	 */


	public function lista(){


	 $notificaciones  = new notificaciones();

	 $listado = $notificaciones->listar();

     $reg['tabla'] ='
	  <thead>
		<tr>
		  <th>Id</th>
		  <th>Titulo</th>
		  <th>Mensaje</th>
		  <th>Fecha</th>
		  <th>Estado</th>
		  <th>Opciones</th>
		</tr>
	  </thead>';

	 $reg['tabla'] .='<tbody>';

	 foreach($listado as $row){
	 	$borrar = ' <a class="delete btn btn-mini btn-danger" href="javascript:borrar('.$row['id_notificacion'].')" >Eliminar</a>';

	 	if($row['estado']!='Pendiente')
	 		$editar ='<a href="notificacion-editar-id-'.$row['id_notificacion'].'.htm" class="btn btn-primary btn-mini">Ver Notificacion</a>';
	 	else
	 		$editar ='<a href="notificacion-editar-id-'.$row['id_notificacion'].'.htm"  class="btn btn-primary btn-mini">Editar</a> <a href="notificacion-enviar-id-'.$row['id_notificacion'].'" title="Enviar" class="btn btn-primary btn-mini">Enviar <i class="glyphicon-iphone_shake"></i></a>';

	 	
	 	$fecha=($row['fecha']=='0000-00-00 00:00:00') ? '-':$row['fecha'];
	 	if($row['estado']!='Pendiente'){
	 	$fecha.=' <a class="box_log" href="notificacion-ver_log-id-'.$row['id_notificacion'].'">Log <i class="icon-file-alt"></i></a>';
	 	}
	 	$reg['tabla'] .='<tr  id="row_'.$row['id_notificacion'].'">
              <td>'.$row['id_notificacion'].'</td>
              <td>'.$row['titulo'].'</td>
              <td>'.$row['mensaje'].'</td>
              <td>'.$fecha.'</td>
              <td>'.$row['estado'].'</td>
              <td>'.$editar.$borrar.'</td>
            </tr>';

	 }

	 $reg['tabla'] .='</tbody>';

	 if(isset($this->get['e'])){
	 	if($this->get['e']=='Enviado')
	 		$reg['mensaje']='El mensaje se ha enviado';
	 	elseif($this->get['e']=='Fallido'){
	 		$reg['mensaje']='No se ha podido enviar el mensaje';
	 		$reg['mensaje_tipo']='error';
	 	}

	 }
	 	

	 $this->view->show("admin/list_notificaciones.php", $reg);

	}




	/**
	 * editar_notificacion
	 */


	 public function editar(){
		$reg['mensaje'] = '';
		$reg['tarea'] = 'Nuevo';
		$notificacion = new notificaciones();
		$productos= new Productos();
		$categorias = new Ecategorias();
	$reg['edicion']=1;		
		if($this->input->post('dat') == false and isset($this->get['id'])) {
			$reg['reg'] = $notificacion->obtener($this->get['id']);
			
			if($reg['reg']['estado']!='Pendiente'){
				if(isset($this->get['c']))
					$reg['reg']['id_notificacion']=0;
				else
				$reg['edicion']=0;
			}
				

			$reg['tarea'] = 'Editar';
			if(isset($this->get['s']))
				$reg['mensaje'] = "Notificacion guardado";
		}
 			
		if($this->input->post('dat') ){
			$notificacion->datos = $this->input->post('dat'); 

			if($this->input->post('delimg') and $this->input->post('id')){
				$notificacion->borrarImagen($this->input->post('id'));	
			} 

			if(is_uploaded_file(nvl($_FILES['archivo']['tmp_name']))){
			    $notificacion->subirArchivo('archivo');
			 }
			
			$reg['tarea'] = 'Editar';
			if($id = $notificacion->guardar($this->input->post('id'))){
				
				if($this->input->post('guardar_enviar')){
					redirect('notificacion-enviar-id-'.$id);
				}
				else{
					redirect('notificacion-editar-id-'.$id.'-s-1');
				}
					
			}
			else{
				$reg['mensaje'] = "Ocurri&oacute; un error al guardar, comunicarse con soporte.";
			}

			$reg['reg'] = $notificacion->obtener($id);
		}

		if(nvl($reg['reg'])){
			$filtro= $reg['reg']['filtro'];
			$afiltro= explode(',',$filtro);
			$cadena= array();
			$i=0;
			foreach($afiltro as $item){
				$items= explode('_',$item);
				$indice=$items[0];
				$cadena[$indice]= nvl($items[1]);
				$i++;
			}
			$reg['filtro']=$cadena;
		}

		$reg['ofertas']= $productos->listBoxOfertas(nvl($reg['reg']['id_oferta']),'conimagen');
		$reg['acciones']= $notificacion->listBoxAcciones(nvl($reg['reg']['accion']));
		$reg['categorias']=$categorias->listBoxCategorias(nvl($reg['reg']['id_categoria']));
			
        $this->view->show("admin/edit_notificacion.php", $reg);
	}

	 /**
	 * borrar un notificacion recibe por post el id del notificacion
	 * Solicitud por ajax
	 */

	 public function borrar(){
		$notificacion = new notificaciones();
		if($notificacion->borrar($this->input->post('id')) )
			echo "1";
		else
			echo "0";
	 }

	 public function enviar($id=0,$desde=''){
		$notificacion=new notificaciones();
		$empresas= new Empresas();
		$push= new Push();
		$id=($id>0) ? $id: nvl($this->get['id'],0);
		$logueado='';
		$compras='';
		
		$reg=$notificacion->obtener($id);
		if(!$id or $reg['estado']!='Pendiente'){
			if($desde!='cronj') 
				redirect('notificacion-lista');
			else
				echo 'no esta Pendiente';
		}	
		else{
			$titulo=$reg['titulo'];
			$mensaje=$reg['mensaje'];

			$accion= strtolower($reg['accion']);
			$accion= str_replace(' ', '_', $accion);
			$id_accion='';
			if($accion=='ver_producto'){
				if($reg['id_oferta']){
					$id_accion= $reg['id_oferta'];
				}
				else
					$accion='listado_ppal';
			}
			elseif($accion=='listado_categoria'){
				if($reg['id_categoria'])
					$id_accion= $reg['id_categoria'];
				else
					$accion='listado_ppal';
			}

			if($accion=='')
				$accion='listado_ppal';

			if($reg['imagen']!=''){
				$nueva_accion='http://www.oferto.co/files/notificaciones/b'.$reg['imagen'].','.$accion.','.$id_accion;
				$accion='push_mensaje';
				$id_accion= $nueva_accion;
			}
	
			$filtro= $reg['filtro'];
			$afiltro= explode(',',$filtro);
			$i=0;
			foreach($afiltro as $item){
				$items= explode('_',$item);
				switch ($items[0]) {
					case 'compras':
						$compras= nvl($items[1]);
						break;
					case 'logueado':
						$logueado= nvl($items[1]);
						break;
				}
			}

			$listadoToken = $notificacion->listarClientesFiltro(0,0,'nombre','asc',$logueado,$compras,1);
			$listadoRegid = $notificacion->listarClientesFiltro(0,0,'nombre','asc',$logueado,$compras,0,1);
			
			$ids=array();
			foreach ($listadoRegid as $rid) {
				$ids[]=$rid['regid'];
			}
			
			$tids=array();
			/*foreach ($listadoToken as $tid) {
				$tids[]=$tid['token'];
			}*/
			$tids=$listadoToken;


			//prueba
			/*$ids=array();
			$ids[]='APA91bHYF3VXCk7t2Phb3PLw_9hpsFCz2PUa_3XBo2Ofy6cfgziU1a2ZXcUCIOgtV4I6XkhMFnY78-gup6R5y1EALysPAbQgzyyCeHheUwuzxB0wEACvWHoy2ZXJBfGMWrJ8-8-Qxlb27Db6SdQhlQOYXMuBoYIT1w';
			$tids=array();*/
			//prueba
			
			if(count($ids))
				$gcm=$push->gcm($titulo,$mensaje,$ids,$accion,$id_accion);
			else{
				$gcm['error']='No se encontraron dispositivos';
				$gcm['log']=$gcm['error'];
			}
			if(count($tids))
				$apns=$push->apns($titulo,$mensaje,$tids,$accion,$id_accion);
			else{
				$apns['error']='No se encontraron dispositivos';
				$apns['log']=$apns['error'];
			}

			if(nvl($gcm['error'])!='' and nvl($apns['error'])!=''){
				$estado= 'Fallido';
			}
			else{
				$estado= 'Enviado';
			}

			$log='<p><strong>Log de Envios:</strong><br/> '.$gcm['log'].'<br/>'.$apns['log'];
			
			$notificacion->cambiarEstado($estado,$log,$reg['id_notificacion']);
			if($desde!='cronj')
			redirect('notificacion-lista-e-'.$estado);
		}
	 }

	 public function enviar_pendientes(){
	 	$notificaciones= new Notificaciones();
	 	$lista=$notificaciones->listarPendientesHoy();
	 	$log = new Modulos();
      	$rlista=print_r($lista,true);

      	if(count($lista))
        $log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], 'Enviando '.count($lista).' notificaciones pendientes '.$rlista);
        echo  'Enviando '.count($lista).' notificaciones pendientes '.$rlista;
	 	foreach ($lista as $row) {
	 		$this->enviar($row['id_notificacion'],'cronj');
	 	}

	 }

	 public function json_listClientes(){
	 	$notificaciones= new Notificaciones();
	 	$iLenght= $this->input->get('iDisplayLength');
	 	$iStart= $this->input->get('iDisplayStart');

	 	$iSort= $this->input->get('iSortCol_0');
	 	$iDir=$this->input->get('sSortDir_0');
	 	
	 	$sortCol='';
	 	switch($iSort){
	 		case 0:  $sortCol='nombre';
	 		break;
	 		case 1:  $sortCol='email';
	 		break;
	 	}

	 	$compra=nvl($this->get['compras']);
	 	$logueado=nvl($this->get['logueado']);
	 	
	 	$listado = $notificaciones->listarClientesFiltro($iStart,$iLenght,$sortCol,$iDir,$logueado,$compra);
	 	$nCli=$notificaciones->numClientesFiltro($logueado,$compra);

	 	$output = array(
	 		"iTotalRecords" => $nCli,
	 		"iTotalDisplayRecords" => $nCli,
	 		"aaData" => array());

	 	$aaData= array();
	 	$i=0;
	 	foreach($listado as $row){
	 		$aaData[$i]['DT_RowId'] =$row['id_usuario'];
	 		$aaData[$i]['nombre']=$row['nombre'].' '.$row['apellidos'];
	 		$aaData[$i]['email']=$row['email'];
	 		$i++;
	 	}
	 	$output['aaData'] = $aaData;
	 	echo json_encode($output);
	 }

	 public function total_clientes(){
	 	$notificaciones= new Notificaciones();
	 	$compra=nvl($this->get['compras']);
	 	$logueado=nvl($this->get['logueado']);
	 	echo $notificaciones->numClientesFiltro($logueado,$compra);
	 }

	 public function ver_log(){
	 	$notificacion= new Notificaciones();
	 	$row=$notificacion->obtener($this->get['id']);
	 	$this->view->show("admin/log_notificacion.php", $row);
	 }

}