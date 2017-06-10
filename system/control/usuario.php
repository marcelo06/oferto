<?php

class Usuario extends ControlBase {
	
	public function listar(){
		if($_SESSION['id_tipo_usuario'] == 3)
			$this->view->show("sys/listar_usuarios.php");
		else{


			$cliente = new usuarios();
			$pedidos= new pedidos();
			$empresas= new Empresas();

			$reg['nombre']='Clientes';

			$empresa=0;
			if($_SESSION['id_tipo_usuario']==4)
				$empresa= $_SESSION['id_empresa'];

			$dempresa=$empresas->obtener($empresa);

			$cont = $cliente->listarUsuarios($empresa,5);

			$reg['tabla'] ='
			<thead>
			<tr>
			<th>Id</th>
			<th>Nombre Completo</th>
			<th>Email</th>
			<th>Proviene de</th>
			<th>Empresa</th>';

			if($dempresa['puntos_activo']==1)
				$reg['tabla'] .='<th>Puntos</th>';

			$reg['tabla'] .='<th>Estado</th>
			<th>Opciones</th>
			</tr>
			</thead>';

			$reg['tabla'] .='<tbody>';
			foreach($cont as $content){

				$estado=$content['estado'] == 1 ? 'Activo' : 'Inactivo' ;
				$enlaceped='';

				$numpedidos= $pedidos->countExitoPorUsuario($content['id_usuario']);

				if($numpedidos){
					if($_SESSION['id_tipo_usuario']==4)	
						$enlaceped=' <a href="pedido-list_pedidos-cliente-'.$content['id_usuario'].'" >('.$numpedidos.'Pedidos)</a>';
					else
						$enlaceped=' ('.$numpedidos.'Pedidos)';
				}

				$editar='';
				if($_SESSION['id_tipo_usuario']==4)
					$editar='<a class="btn btn-mini" href="usuario-editar-id-'.$content['id_usuario'].'">Editar</a>';


				$reg['tabla'] .='
				<tr id="row_'.$content['id_usuario'].'">
				<td>'.$content['id_usuario'].'</td>
				<td>'.$content['nombre'].' '.$content['apellidos'].$enlaceped.'</td>
				<td>'.$content['email'].'</td>
				<td>'.$content['proviene'].'</td>
				<td>'.$content['empresa'].'</td>';

				if($dempresa['puntos_activo']==1){
					$puntos= new Puntos();
					$ptos= $puntos->obtenerPuntosUsuario($content['id_usuario']);
					if(nvl($ptos['puntos'])!='')
					$reg['tabla'] .='<td>'.$ptos['puntos'].'  <a class="detalles" href="usuario-ver_puntos-usuario-'.$content['id_usuario'].'"><i class="icon-edit"/></td>';
				else
					$reg['tabla'] .='<td>0</td>';
				}
			

				$reg['tabla'].='<td>'.$estado.'</td>
				<td><a class="btn btn-mini detalles" href="usuario-detalles-id-'.$content['id_usuario'].'">Detalles</a> '.$editar.'  <a class="delete btn btn-mini btn-danger" href="javascript:borrar('.$content['id_usuario'].')">Eliminar</a></td>
				</tr>';

			}
			$reg['tabla'] .='</tbody>';


			$coferto = $cliente->listarUsuariosOferto($empresa);

			$reg['tabla_oferto'] ='
			<thead>
			<tr>
			<th>Id</th>
			<th>Nombre Completo</th>
			<th>Email</th>
			<th>Siguiendo</th>
			<th>Estado</th>
			<th>Opciones</th>
			</tr>
			</thead>';

			$reg['tabla_oferto'] .='<tbody>';
			foreach($coferto as $c_oferto){

				$estado=$c_oferto['estado'] == 1 ? 'Activo' : 'Inactivo' ;
				$pedido_ofe='';

				$numpedidos= $pedidos->countExitoPorUsuario($c_oferto['id_usuario'],$empresa);

				if($numpedidos){
					if($_SESSION['id_tipo_usuario']==4)	
						$pedido_ofe=' <a href="pedido-list_pedidos-cliente_oferto-'.$c_oferto['id_usuario'].'" >('.$numpedidos.'Pedidos)</a>';
					else
						$pedido_ofe=' ('.$numpedidos.'Pedidos)';
				}
				$editar='';
				if($_SESSION['id_tipo_usuario']==2)
					$editar='<a class="btn btn-mini" href="usuario-editar-id-'.$c_oferto['id_usuario'].'">Editar</a>';

				$estasiguiendo=$empresas->estaSiguiendo($c_oferto['id_usuario'],$empresa);
				$siguiendo= ($estasiguiendo) ? 'Si':'No';
				$reg['tabla_oferto'] .='
				<tr id="row_'.$c_oferto['id_usuario'].'">
				<td>'.$c_oferto['id_usuario'].'</td>
				<td>'.$c_oferto['nombre'].' '.$c_oferto['apellidos'].$pedido_ofe.'</td>
				<td>'.$c_oferto['email'].'</td>
				<td>'.$siguiendo.'</td>
				<td>'.$estado.'</td>

				<td><a class="btn btn-mini detalles" href="usuario-detalles-id-'.$c_oferto['id_usuario'].'-oferto-1">Detalles</a> '.$editar.'</td>
				</tr>';

			}
			$reg['tabla_oferto'] .='</tbody>';

			$this->view->show("admin/list_usuarios.php", $reg);
		}
	}
	
	public function editar(){
		$reg['mensaje'] = '';
		$reg['editar'] = 1;
		$reg['accion'] = 'Agregar Usuario';
		$reg['etiqueta'] = 'ajaxValEmail';
		$con = new Usuarios();
		$localidades= new Cli_localidades();
		
		
		
		$proviene= $this->input->post('proviene');
		if(!($proviene=='compra' and !$this->input->post('elpass')))
			$out = $this->input->post('dat');
		$per = $this->input->post('per');
		
		$per['proviene']=ucfirst($proviene);
		$id_usuario = isset($this->get['id']) ? $this->get['id'] : $this->input->post('id_usuario');
		
		
		if( isset($this->get['id']) && $this->input->post('dat') == false ){
			$reg['reg'] = $con->obtener($id_usuario);
			$reg['accion'] = 'Editar Usuario';
			$reg['etiqueta'] = 'ajaxValEmailConfig';
		}

		if(nvl($out['_username'],0)){
			
			$dat['_username'] = $out['_username'];
			$dat['email']     = $out['_username'];
			$dat['id_empresa']     = $out['id_empresa'];
			$dat['id_tipo_usuario']     = $out['id_tipo_usuario'];
			$per['email'] = $out['_username'];
			
			if(strlen($out['_password']) >= 5){
				$cost = 10;
				$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
				$salt = sprintf("$2a$%02d$", $cost) . $salt;
				$dat['_password'] =crypt($out['_password'], $salt);
			}
			
			//$dat['id_empresa'] = $_SESSION['id_empresa'];
			$dat['estado'] = nvl($out['estado'],1);
			if($id_usuario > 0)	{
				$con->actualizar($dat,$id_usuario);
				$reg['mensaje'] = 'Perfil Actualizado';
			}else{
				
				$id_usuario = $con->agregar($dat,nvl($_SESSION['id_empresa']),$this->input->post('clioferto'));
				$per['id_usuario'] = $id_usuario;
				$con->agregarPerfil($per);
				$reg['mensaje'] = 'Usuario Agregado';
			}
			

			$con->actualizarPerfil($per, $id_usuario);
			$reg['reg'] = $con->obtener($id_usuario);
			$reg['accion'] = 'Editar Usuario';
		}
		
		$reg['tipos_usuario'] = $con->tiposUsuarioPublico(nvl($reg['reg']['id_tipo_usuario']));

		$reg['paises']=$localidades->paisesSelect(nvl($reg['reg']['id_pais'],1));
	 	$reg['dptos']=$localidades->dptosSelect(nvl($reg['reg']['id_pais'],1),$reg['reg']['id_dpto']);
	 	$reg['ciudades']=$localidades->ciudadesSelect(nvl($reg['reg']['id_dpto']),$reg['reg']['id_ciudad']);

		if($_SESSION['id_tipo_usuario'] == 3)
			$this->view->show("sys/edit_usuario.php", $reg);
		else{	
			if($proviene=='registro')
			{
				$_SESSION['id_usuario'] = $id_usuario;
				$_SESSION['id_tipo_usuario'] = 5;
				$_SESSION['nombre'] = $per['nombre'];
				$_SESSION['autentico'] = true;
				
				$per['email']=  $out['_username'];
				correo::enviar_registro($per);
				correo::enviar_confirmacion($per);
				if(defined('SKIN') and isset($_SESSION['id_empresa'])){
					redirect("main-productos");
				}
				else
					redirect("main-registrado");
			}
			elseif($proviene=='compra'){
				if($per['email']){
					$_SESSION['d_pedido']=array();
					
					$_SESSION['d_pedido']['id_usuario'] = nvl($id_usuario,0);
					$_SESSION['d_pedido']['fecha'] = date('Y-m-d');
					$_SESSION['d_pedido']['nombre_pedido'] = $per['nombre'];
					$_SESSION['d_pedido']['telefono_pedido'] = $per['telefono'];
					$_SESSION['d_pedido']['movil_pedido'] = nvl($per['movil']);
					$_SESSION['d_pedido']['direccion_pedido'] = $per['direccion'];
					$_SESSION['d_pedido']['pais_pedido'] = $per['id_pais'];
					$_SESSION['d_pedido']['departamento_pedido'] = $per['id_dpto'];
					$_SESSION['d_pedido']['ciudad_pedido'] = $per['id_ciudad'];
					$_SESSION['d_pedido']['email_pedido'] = $per['email'];
					
				}
				
				if($out['_username']){
					$_SESSION['id_usuario'] = $id_usuario;
					$_SESSION['id_tipo_usuario'] = 5;
					$_SESSION['nombre'] = $per['nombre'];
					$_SESSION['autentico'] = true;

					$per['email']=  $out['_username'];
					correo::enviar_registro($per);
					correo::enviar_confirmacion($per);
				}

				if(defined('SKIN') and isset($_SESSION['id_empresa'])){
					redirect("producto-checkout");
				}
				else
					redirect("main-registrado?compra=1");
			}
			else	
				$this->view->show("admin/edit_usuario.php", $reg);
		}
	}
	
	public function guardar_datos(){
		$con = new Usuarios();
		$reg= $this->input->post('dat');
		$this->input->post('id_usuario');
		if($this->input->post('id_usuario') != ""){

			$out = $this->input->post('dat');
			$dat['_username'] = $out['_username'];
			$dat['email']     = $out['email'];
			$dat['_password'] = md5($out['_password']);
			
			$con->actualizar($dat,$this->input->post('id_usuario'));
		}else{	
			$con->agregar($reg);
		}
		if($_SESSION['id_tipo_usuario'] == 3)
			redirect("usuario-listar_usuarios");
		else
			redirect("login-inicio");
	}
	
	
	public function cambiar_estado(){

		$serx = new Usuarios();
		echo $serx->cambiarEstado	($this->input->post('check'), $this->input->post('cambio'));
	}
	
	public function validar(){
		$serx = new Usuarios();
		$arrayToJs = array();
		if($this->input->post('email')){
			
			if(!$serx->validarNombreUsuario($this->input->post('email'),nvl($_SESSION['id_empresa']),$this->input->post('oferto')))
				echo "true";
			else
				echo "false";
		}
		else{
			$validateValue=$this->input->get('fieldValue');
			$validateId=$this->input->get('fieldId');
			$validateError= "Este e-mail ya está registrado";
			$validateSuccess= "Este e-mail está disponible";
			/* RETURN VALUE */
			
			$arrayToJs[0] = $validateId;
			
			if(!$serx->validarNombreUsuario($validateValue)){		// validate??
				$arrayToJs[1] = true;			// RETURN TRUE
				echo json_encode($arrayToJs);			// RETURN ARRAY WITH success
			}else{
				for($x=0;$x<1000000;$x++){
					if($x == 990000){
						$arrayToJs[1] = false;
						echo json_encode($arrayToJs);		// RETURN ARRAY WITH ERROR
					}
				}
				
			}
		}
		
	}
	
	public function validarxid(){
		$serx= new Usuarios();
		if($this->input->post('email')){
			
			if(!$serx->validarUsuarioxID($this->input->post('email'),$_SESSION['id_usuario'],nvl($_SESSION['id_empresa']),'',$this->input->post('oferto')))
				echo "true";
			else
				echo "false";
		}
		else{
			$tipo= nvl($this->get['t'],'dat');
			$datos=$this->input->get($tipo);
			$id_usuario=nvl($this->get['id'],0);
			$tipo=nvl($this->get['tipo'],5);
			if(!$serx->validarUsuarioxID($datos['_username'], $id_usuario,nvl($_SESSION['id_empresa']),$tipo)){
				echo 'true';	
			}
			else{
		$arrayToJs[0] = false;			// RETURN TRUE
			$arrayToJs[0] = false;			// RETURN TRUE
			$arrayToJs[1] ='El nombre de usuario ya está en uso';			// RETURN ARRAY WITH success
			echo json_encode($arrayToJs);	
		}
	}
}


public function xml_usuarios(){

	$serx = new Usuarios();
	$resultado = $serx->listar();
	$xml = '';
	$xml .= '<?xml version="1.0" encoding="UTF-8" ?>';
	$xml .= '<rows>';
	foreach($resultado as $reg){
		$xml .= '<row id="'.$reg['idusuario'].'">';
		$xml .= '<cell>';
		$xml .= $reg['_username'];
		$xml .= '</cell>';
		$xml .= '<cell>';
		$xml .= $serx->obtenerNombreTipoUsuario($reg['id_tipo_usuario']);
		$xml .= '</cell>';
		$xml .= '<cell>';
		$xml .= $reg['estado'];
		$xml .= '</cell>';
		$xml .= '<cell>';
		$xml .= 'Editar^usuario-edit_usuario-id-'.$reg['idusuario']."".'^_self';
		$xml .= '</cell>';
		$xml .= '<cell>';
		$xml .= 'Borrar^javascript:borrar('.$reg['idusuario'].');^_self';
		$xml .= '</cell>';
		$xml .= '</row>';
	}
	$xml .= '</rows>';
	header("Content-type: text/xml");
	echo $xml;

}

	/**
	  * json_listUsuarios
	  *
	  * crea el json para el listado de Usuarios 
	  *
	  * @access	   public 	 
	  * @author	   Julian Vega
	  * @since	   2101019
	  * @version   2101019
	  * @return    void.  
	  */
	

	public function json_listUsuarios(){

		$clien   = new Usuarios();
		$respuesta  = new Adm_respuesta_grid(); 
		
		$respuesta->page = $this->input->get('page'); // get the requested page 
		$limite = $this->input->get('rows'); // get how many rows we want to have into the grid 
		$orden = $this->input->get('sidx'); // get index row - i.e. user click to sort 
		$direccion = $this->input->get('sord'); // get the direction 
		
		if(isset($this->get['nombre']))
			$buscar = $this->get['nombre'];
		else
			$buscar= "";
		
		$respuesta->records = $clien->numRegistros($buscar); 
		$inicio = $respuesta->paginar($limite);
		$result = $clien->listarUsuarios( $orden , $direccion, $inicio, $limite, $buscar );
		
		$i=0;
		$editar = '';
		$borrar = '';
		foreach($result as $inm){
			$respuesta->rows[$i]['id']= $inm['id_usuario'];
			$ver ='<a href="cliente-consultar-id-'.$inm['id_usuario'].'">Detalles</a> ';
			$editar ='<a href="usuario-editar-id-'.$inm['id_usuario'].'">Editar</a> ';
			$borrar ='<a  href="javascript:;" onclick="javascript:borrar('.$inm['id_usuario'].');">Borrar</a> ';
			$respuesta->rows[$i]['cell']= array($inm['nombre'].' '.$inm['apellidos'],$inm['tipo_usuario'],$inm['estado'] == 1 ? 'Activo' : 'Inactivo' ,$editar.' | '.$borrar);
			$i ++;
		}
		
		echo json_encode($respuesta); 

	}

	
	public function borrar(){
		$abo = new Usuarios();
		echo $abo->borrar($this->input->post('id')) ;
	}
	
	
	public function config(){
		$reg['mensaje'] = '';
		$reg['accion'] = 'Actualizar mi perfil:';
		$reg['etiqueta'] = 'ajaxValEmailConfig';
		$con = new Usuarios();
		$localidades= new Cli_localidades();
		$reg['reg'] = $con->obtener($_SESSION['id_usuario']);
		//dump($reg);
		if($this->input->post("dat")){
			$out = $this->input->post('dat');
			$id_empresa='';
			$tipo='';
			if($this->input->post('id_empresa')!='')
				$id_empresa=$this->input->post('id_empresa');

			if(nvl($_SESSION['id_empresa'],0))
				$tipo=4;

			if(!$con->validarUsuarioxID($out['_username'], $_SESSION['id_usuario'],$id_empresa,$tipo)){
				$dat['_username'] = $out['_username'];
				$dat['email']     = $out['_username'];
				if(strlen($out['_password']) >= 5){
					$cost = 10;
					$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
					$salt = sprintf("$2a$%02d$", $cost) . $salt;
					$dat['_password'] =crypt($out['_password'], $salt);
				}
				$con->actualizar($dat,$_SESSION['id_usuario']);
				$per = $this->input->post('per');

				$con->actualizarPerfil($per, $_SESSION['id_usuario']);
				$reg['mensaje'] = 'Perfil Actualizado';
			}else{
				$reg['mensaje'] = 'Correo Electrónico ya está en uso';
			}
			
			$reg['reg'] = $con->obtener($_SESSION['id_usuario']);
		}

		$reg['paises']=$localidades->paisesSelect(nvl($reg['reg']['id_pais'],1));
	 	$reg['dptos']=$localidades->dptosSelect(nvl($reg['reg']['id_pais'],1),$reg['reg']['id_dpto']);
	 	$reg['ciudades']=$localidades->ciudadesSelect(nvl($reg['reg']['id_dpto']),$reg['reg']['id_ciudad']);

		if($_SESSION['id_tipo_usuario'] == 3)
			$this->view->show("sys/edit_usuario.php", $reg);
		else			
			$this->view->show("admin/edit_usuario.php", $reg);
	}
	
	
	// SYS 
	
	public function edit_usuario(){
		
		$con = new Usuarios();
		$reg['user'] = false;

		if(isset($this->get['id'])){
			$reg['reg'] = $con->obtener($this->get['id']);
			if($reg['reg']['_username'] != "")
				$reg['user'] = true;
			$reg['reg']['id_usuario'] = $this->get['id'];
		}
		
		$reg['tipo_usuarios'] = $con->tiposUsuario(nvl($reg['reg']['id_tipo_usuario']));

		if($_SESSION['id_tipo_usuario'] == 3)
			$this->view->show("sys/edit_usuario.php", $reg);
		else
			$this->view->show("admin/edit_usuario.php", $reg);
	}
	
	public function listar_usuarios(){
		if($_SESSION['id_tipo_usuario'] == 3)
			$this->view->show("sys/listar_usuarios.php");
		else
			redirect("usuario-main");
	}

	public function listar_siguiendo(){
		$usuarios= new Usuarios();
		$lusuarios= $usuarios->listarUsuariosSiguiendo(10);
		$cadena='';
		
		foreach($lusuarios as $row){
			
					$cadena.='<li><div class="num" id="nsiguiendo">'.$row['count'].'</div><span class="task"><span>'.$row['nombre'].'</span></span></li>';
			
		}
		echo $cadena;
	}
	
	public function exportar()
	{
		$usuario= new usuarios();
		$empresas= new Empresas();	

		$empresa=0;
		$admin=0;
		if($_SESSION['id_tipo_usuario']==4)
			$empresa= $_SESSION['id_empresa'];	
		else
			$admin=1;
		if(isset($this->get['oferto'])){
			$result = $usuario->listarUsuariosOferto($empresa);
			$admin=0;
		}
		else
			$result = $usuario->listarUsuarios($empresa);

		$html = '<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<thead> <tr bgcolor="#CCCCCC">';
		if($admin)
			$html .= '<th>Empresa</th>';

		$html .= '<th>Nombre Completo</th>
		<th>Email</th>
		<th>Teléfono</th>
		<th>Móvil</th>
		<th>Dirección</th>
		<th>Pais</th>
		<th>Departamento</th>
		<th>Ciudad</th>
		<th>Estado</th>';
		
		if($_SESSION['id_tipo_usuario']==4)
			$html .= '<th>Siguiendo</th>';
		
		$html .= '</tr>
		</thead>
		<tbody>';


		foreach($result as $row){
			$estado= ($row['estado']==1) ? 'Activo':'Inactivo';
			$html.='<tr>';
			if($admin)
				$html.='<th>'.$row['empresa'].'</th>';

			$html.='<th>'.$row['nombre'].' '.$row['apellidos'].'</th>
			<th>'.$row['email'].'</th>
			<th>'.$row['telefono'].'</th>
			<th>'.$row['movil'].'</th>
			<th>'.$row['direccion'].'</th>
			<th>'.usuario::nombre_localidad('pais',$row['id_pais']).'</th>
			<th>'.usuario::nombre_localidad('dpto',$row['id_dpto']).'</th>
			<th>'.usuario::nombre_localidad('ciudad',$row['id_ciudad']).'</th>
			<th>'.$estado.'</th>';
			
			if($_SESSION['id_tipo_usuario']==4){
				$estasiguiendo=$empresas->estaSiguiendo($row['id_usuario'],$empresa);
				$siguiendo= ($estasiguiendo) ? 'Si':'No';
				$html.='<th>'.$siguiendo.'</th>';
			}
			$html.='</tr>';
		}
		$html.='</tbody></table>';
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=clientes_".date("Y-m-d").".xls");
		echo $html;
	}


	public function exportar_completo()
	{
		$usuario= new usuarios();
		$empresas= new Empresas();	
		$pedidos= new Pedidos();
		$categorias= new Ecategorias();
		$productos=new Productos();

		$empresa=0;
		$admin=0;
		
		$result = $usuario->listarUsuariosCompleto();

		$html = '<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<thead>
		<tr bgcolor="#CCCCCC">
		<th>Empresa</th>
		<th>Nombre Completo</th>
		<th>Email</th>
		<th>Teléfono</th>
		<th>Móvil</th>
		<th>Dirección</th>
		<th>Pais</th>
		<th>Departamento</th>
		<th>Ciudad</th>
		<th>Estado</th>
		<th># Reservas</th>
		<th># Empresas que sigue</th>
		<th>Categorias más visitadas</th>
		<th>Oferta más visitada</th>
		</tr>
		</thead>
		<tbody>';

		foreach($result as $row){
			$estado= ($row['estado']==1) ? 'Activo':'Inactivo';

			if($row['id_empresa']==0)
				$row['empresa']='Oferto.co';

			$nreservas=$pedidos->countExitoPorUsuario($row['id_usuario']);
			$nsiguiendo=$empresas->contarSiguiendo($row['id_usuario']);
			$categorias_visitadas=$categorias->listarCategoriasVisitadas($row['id_usuario']);
			$cadcate='';
			foreach($categorias_visitadas as $cate){
				$cadcate.=$cate['categoria'].', ';
			}
			if($cadcate!='')
			$cadcate= substr($cadcate, 0, strlen($cadcate)-2);
			$oferta_visitada='';

			$ofertas=$productos->listarOfertasVisitadasUsuario($row['id_usuario'],1);
			if(count($ofertas)){
				$oferta_visitada=($ofertas[0]['oferta_descripcion']!='') ? $ofertas[0]['oferta_descripcion']:$ofertas[0]['nombre'];
			}


			$html.='<tr>
			<th>'.$row['empresa'].'</th>
			<th>'.$row['nombre'].' '.$row['apellidos'].'</th>
			<th>'.$row['email'].'</th>
			<th>'.$row['telefono'].'</th>
			<th>'.$row['movil'].'</th>
			<th>'.$row['direccion'].'</th>
			<th>'.usuario::nombre_localidad('pais',$row['id_pais']).'</th>
			<th>'.usuario::nombre_localidad('dpto',$row['id_dpto']).'</th>
			<th>'.usuario::nombre_localidad('ciudad',$row['id_ciudad']).'</th>
			<th>'.$estado.'</th>
			<th>'.$nreservas.'</th>
			<th>'.$nsiguiendo.'</th>
			<th>'.$cadcate.'</th>
			<th>'.$oferta_visitada.'</th>
			</tr>';
			
		}
		$html.='</tbody>
		</table>';
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=clientes_".date("Y-m-d").".xls");
		echo $html;

		
	}

	public function exportar_siguiendo(){
		
	}

	public function detalles(){
		$usuario = new Usuarios();
		$reg['tipo']='usuario';
		if(nvl($this->get['oferto']) and nvl($_SESSION['id_empresa'])){
			$reg['usuario'] = $usuario->obtenerEmpOferto($this->get['id']);
			$reg['tipo']='oferto';
		}
		else
		$reg['usuario'] = $usuario->obtener($this->get['id']);

		$this->view->show('admin/detalles_usuario.php',$reg);
	}

	public function estado_suscripcion(){
     	$usuario = new Usuarios();
     	$value=$this->input->post('value');

        if($this->get['tipo']=='oferto'){
        	$result=$usuario->estadoSuscripcionUsuEmpresa( $value,$this->input->post('id_item'),$_SESSION['id_empresa']);
        }
        else{
        	 $datos['suscrito'] = $value;
        	$result=$usuario->actualizar($datos,$this->input->post('id_item'));
        }
        if($result){
        	echo ($value=='1') ? 'Si':'No'; 
        }
        else{
        	echo 'Error';
        }
	}

	public function ver_puntos(){
		$id_usuario=nvl($this->get['usuario']);
		$puntos= new Puntos();
		$reg['ptos']=$puntos->obtenerPuntosUsuario($id_usuario);
		$this->view->show('admin/usuario_puntos.php',$reg);
		
	}

	public function redimir_puntos(){
		$puntos= new Puntos();
		$id_puntos=$this->input->post('id_puntos');
		$redimir=$this->input->post('redimir');

		$dpuntos= $puntos->obtener($id_puntos);
		
		if($id_puntos and $redimir and ($redimir<=$dpuntos['puntos'])){
			$historial=$dpuntos['historial'];
			if($historial!='')
				$historial.='_';
			$puntos->datos['historial']=$historial.date('Y-m-d h:i:s').','.$redimir;
			$puntos->datos['puntos']=$dpuntos['puntos']-$redimir;
			$puntos->datos['redimidos']=$dpuntos['redimidos']+$redimir;
			$puntos->datos['ultima_fecha']=date('Y-m-d h:i:s');
			if($puntos->guardar($id_puntos))
				echo 'Exito';
		}
	}

	public function select_localidad(){
		$localidades= new Cli_localidades();
		$tipo= $this->input->post('tipo');
		$valor= $this->input->post('valor');
		if($tipo!='' and $valor!=''){
			$metodo=$tipo.'Select';
			echo $localidades->$metodo($valor);
		}
			
		else
			echo false;
	}

	static function nombre_localidad($tipo,$id){
		$localidades= new Cli_localidades();
		if($tipo!='' and $id!=''){
			$metodo=$tipo.'Nombre';
			return $localidades->$metodo($id);
		}	
		else
			return '';
	}

	public function ayuda(){
		$this->view->show("admin/manual.php");  
	}
	public function descargar_manual(){
		$reg['descargar']=1;
		$reg['dirfile']= FILES.'manuales/';
		if(nvl($this->get['t'])=='empresa')
			$reg['archivo']= 'Manual-usuario-empresario.pdf';
		else
			$reg['archivo']= ($_SESSION['id_usuario']==2) ? 'Manual-usuario-adm.pdf':'Manual-usuario-empresario.pdf';
			 $this->view->show("admin/manual.php", $reg);  
	}

} ?>