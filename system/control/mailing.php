<?php
/**
  * controlador mailing
  */

class Mailing extends ControlBase {
	

	  /*
	 * list_mailings
	 */


	public function lista(){


	 $mailings  = new mailings();

	 $listado = $mailings->listar($_SESSION['id_empresa']);

     $reg['tabla'] ='
	  <thead>
		<tr>
		  <th>Id</th>
		  <th>Asunto</th>
		  <th>Fecha</th>
		  <th>Estado</th>
		  <th>Opciones</th>
		</tr>
	  </thead>';

	 $reg['tabla'] .='<tbody>';

	 foreach($listado as $row){
	 	$borrar = ' <a class="delete btn btn-mini btn-danger" href="javascript:borrar('.$row['id_mailing'].')" >Eliminar</a>';

	 	if($row['estado']!='Pendiente')
	 		$editar ='<a href="mailing-editar-id-'.$row['id_mailing'].'.htm" class="btn btn-primary btn-mini">Ver Mail</a> <a href="mailing-editar-id-'.$row['id_mailing'].'-c-1.htm" class="btn btn-primary btn-mini">Copia</a>';
	 	else
	 		$editar ='<a href="mailing-enviar-id-'.$row['id_mailing'].'" title="Enviar" class="btn btn-primary btn-mini">Enviar <i class="glyphicon-message_out"></i></a> 
	 			<a href="mailing-editar-id-'.$row['id_mailing'].'.htm"  class="btn btn-primary btn-mini">Editar</a> ';

	 	
	 	$fecha=($row['fecha']=='0000-00-00 00:00:00') ? '-':$row['fecha'].' <a class="box_log" href="mailing-ver_log-id-'.$row['id_mailing'].'">Log <i class="icon-file-alt"></i></a>';
	 	$reg['tabla'] .='<tr  id="row_'.$row['id_mailing'].'">
              <td>'.$row['id_mailing'].'</td>
              <td>'.$row['asunto'].'</td>
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
	 	

	 $this->view->show("admin/list_mailings.php", $reg);

	}




	/**
	 * editar_mailing
	 */


	 public function editar(){
		$reg['mensaje'] = '';
		$reg['tarea'] = 'Nuevo';
		$mailing = new mailings();
	$reg['edicion']=1;		
		if($this->input->post('dat') == false and isset($this->get['id'])) {
			$reg['reg'] = $mailing->obtener($this->get['id']);
			
			if($reg['reg']['estado']!='Pendiente'){
				if(isset($this->get['c']))
					$reg['reg']['id_mailing']=0;
				else
				$reg['edicion']=0;
			}
				

			$reg['tarea'] = 'Editar';
			if(isset($this->get['s']))
				$reg['mensaje'] = "Mailing guardado";
		}
 			
		if($this->input->post('dat') ){
			$datos=$this->input->post('dat',false);

			$mailing->datos = $this->input->post('dat'); 
			$mailing->datos['contenido']= $datos['contenido'];
			

			$reg['tarea'] = 'Editar';
			if($id = $mailing->guardar($this->input->post('id'))){
				
				if($this->input->post('guardar_enviar')){
					redirect('mailing-enviar-id-'.$id);
				}
				else{
					redirect('mailing-editar-id-'.$id.'-s-1');
				}
					
			}
			else{
				$reg['mensaje'] = "Ocurri&oacute; un error al guardar, comunicarse con soporte.";
			}

			$reg['reg'] = $mailing->obtener($id);
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
			
        $this->view->show("admin/edit_mailing.php", $reg);
	}

	 /**
	 * borrar un mailing recibe por post el id del mailing
	 * Solicitud por ajax
	 */

	 public function borrar(){
		$mailing = new mailings();
		if($mailing->borrar($this->input->post('id')) )
			echo "1";
		else
			echo "0";
	 }

	 public function enviar($id=0){

		$mailing=new mailings();
		$clientes    = new Usuarios();
		$empresas= new Empresas();
		$id=nvl($this->get['id'],0);
		
		$reg=$mailing->obtener($id);
		if(!$id or $reg['estado']!='Pendiente')
			redirect('mailing-lista');
		else{
			$filtro= $reg['filtro'];
			$afiltro= explode(',',$filtro);
			$i=0;
			foreach($afiltro as $item){
				$items= explode('_',$item);
				switch ($items[0]) {
					case 'compras':
						$compras= nvl($items[1]);
						break;
					case 'de':
						$de= nvl($items[1]);
						break;
					case 'sigue':
						$sigue= nvl($items[1]);
						break;
					case 'puntos':
						$puntos= nvl($items[1]);
						break;
				}
			}
			$empresa=$empresas->obtener($reg['id_empresa']);
			$logo='';
			if($empresa['logo']!=''){
				$logo='<tr>
                     <td>
                        <table valign="center" class="devicewidth" align="center" border="0" cellpadding="0" cellspacing="0" height="50" width="200">
                           <tbody><tr>
                              <td align="center" style="font-family: \'Raleway\', arial, sans-serif; font-size: 13px;color: #4f4f4f"> <a href="#"><img src="http://'.$_SESSION['dominiovista'].$empresas->dirfileout.'m'.$empresa['logo'].'" alt="" style="display:block; border:none; outline:none; text-decoration:none;" border="0" height="50"></a><br/>'.$empresa['nombre'].'</td>
                           </tr>
                        </tbody></table>
                     </td>
                  </tr>';
			}

			$listado = $clientes->listarClientesFiltro($reg['id_empresa'],0,0,'nombre','asc',$compras,$de,$sigue,$puntos);
			$dominio=$_SESSION['dominiovista'];
			$html_mensaje = fullUrl($reg['contenido'],$dominio);
			$html='
<table id="backgroundTable" bgcolor="#e8e8e8" border="0" cellpadding="0" cellspacing="0" width="100%">
   <tbody>
      <tr>
         <td>
            <table class="devicewidth" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
               <tbody>
                 
                  <tr>
                     <td height="20" width="100%"></td>
                  </tr>
                  
                  <tr>
                     <td height="20" width="100%"></td>
                  </tr>
                  
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>

<table id="backgroundTable" bgcolor="#e8e8e8" border="0" cellpadding="0" cellspacing="0" width="100%">
   <tbody>
      <tr>
         <td>
            <table class="devicewidth" align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="600">
               <tbody>
                <tr>
                     <td height="20" width="100%"></td>
                  </tr>
                  '.$logo.'
                  
                  <tr>

                  <td style="font-family: \'Raleway\', arial, sans-serif; font-size: 14px; color: #4f4f4f; text-align:left; line-height: 24px; padding:0 15px;">'.$html_mensaje.'</td>
                    
                  </tr>
                  <tr>
                     <td height="20" width="100%"></td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>';

			if($html_mensaje!='' and count($listado)){
				$mail = new PHPMailer();
				$mail->IsHTML(true);
				$mail->From ="info@".DOMINIO;
				$mail->FromName = 'Admin '.$_SESSION['dominiovista'];
				$mail->Subject =$reg['asunto'];
				
				
				$exito=0;
				$fallido=0;
				$email_fallido='';
				$email_enviado='';
				foreach ($listado as $row){
					$tipo=($row['id_empresa']==0) ? 'o':'e';
					$pie='<table id="backgroundTable" bgcolor="#e8e8e8" border="0" cellpadding="0" cellspacing="0" width="100%">
					   <tbody>
					      <tr>
					         <td>
					            <table class="devicewidth" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
					               <tbody>
					                  <!-- Spacing -->
					                  <tr>
					                     <td height="20" width="100%"></td>
					                  </tr>
					                  <tr>
										<td valign="middle" align="center" style="font-family: \'Raleway\', arial, sans-serif; font-size: 13px;color: #4f4f4f">
					                        Este correo fue enviado a  <a style="text-decoration: none; color: #f9ab22" href="#">'.$row['email'].'.</a> Recibiste éste email porque estás registrado en  '.$empresa['nombre'].'.</a> Puede cancelar la suscripción dando click <a style="text-decoration: none; color: #f9ab22" href="http://'.$_SESSION['dominiovista'].'/mailing-cancelar_suscripcion-llave-'.md5('llaverhiss'.$row['id_usuario'].$_SESSION['id_empresa']).'-c-'.$row['id_usuario'].'_'.$_SESSION['id_empresa'].'">aquí</a>
					                     </td>
					                  </tr>
					 <tr>
					                     <td height="20" width="100%"></td>
					                  </tr>
					                  <!-- Spacing -->
					               </tbody>
					            </table>
					         </td>
					      </tr>
					   </tbody>
					</table>';

					$mail->Body = utf8_decode($html.$pie);
					
					$mail->to= array();
					$mail->AddAddress($row['email']); 
					if($mail->Send()){
						$exito+=1;
						$email_enviado.='<tr><td>'.$exito.'</td><td>'.$row['email'].'</td></tr>';
					}					
					else{
						$fallido+=1;	
						$email_fallido.='<tr><td>'.$fallido.'</td><td>'.$row['email'].'</td></tr>';
					}
				}
				$log= '<p>Eviados: '.$exito.' <br>Fallidos: '.$fallido.'</p><table width="99%" border="0"><tr><td>ENVIADOS</td><td>FALLIDOS</td></tr><tr>
				<td><table width="100%" border="1" celpadding="5">'.$email_enviado.'</table></td>
				<td><table width="100%" border="1" celpadding="5">'.$email_fallido.'</table></td>
					</tr></table>';
				
				$estado=($exito>0) ? 'Enviado':'Fallido';
				
				$mailing->cambiarEstado($estado,$log,$reg['id_mailing']);
				redirect('mailing-lista-e-'.$estado);
			}
			
		}
	 	
	

	 }

	 public function json_listClientes(){
	 	$clientes    = new Usuarios();
	 	$iLenght= $this->input->get('iDisplayLength');
	 	$iStart= $this->input->get('iDisplayStart');

	 	$iSort= $this->input->get('iSortCol_0');
	 	$iDir=$this->input->get('sSortDir_0');

	 	$empresa=nvl($this->get['empresa']);
	 	
	 	$sortCol='';
	 	switch($iSort){
	 		case 0:  $sortCol='nombre';
	 		break;
	 		case 1:  $sortCol='email';
	 		break;
	 		case 2:  $sortCol='id_empresa';
	 		break;
	 	}

	 	$compra=nvl($this->get['compras']);
	 	$de=nvl($this->get['de']);
	 	$sigue=nvl($this->get['sigue']);
	 	$puntos=nvl($this->get['puntos']);

	 	$listado = $clientes->listarClientesFiltro($empresa,$iStart,$iLenght,$sortCol,$iDir,$compra,$de,$sigue,$puntos);
	 	$nCli=$clientes->numClientesFiltro($empresa,$compra,$de,$sigue,$puntos);


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
	 		$aaData[$i]['tipo']=($row['id_empresa']==0) ? 'Oferto.co':'Sitio Web';
	 		$i++;
	 	}
	 	$output['aaData'] = $aaData;
	 	echo json_encode($output);
	 }

	 public function ver_log(){
	 	$mailing= new Mailings();
	 	$row=$mailing->obtener($this->get['id']);
	 	$this->view->show("admin/log_mailing.php", $row);
	 }

	 public function cancelar_suscripcion(){
	 	$usuarios = new Usuarios();
		$llave = $this->get['llave'];
		if(isset($this->get['c'])){
			$datos = explode('_',$this->get['c']);
			//0 Ususario
			//1 Empresa
			if(count($datos)==2 and md5('llaverhiss'.$datos[0].$datos[1]) == $llave)
			$usuarios->cancelarSuscripcionEmpresa($datos[0],$datos[1]);
		}
		
		redirect('main-index-d-1');
}

}