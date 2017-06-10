<?php

/**
  * controlador Empresa
*/

class Empresa extends ControlBase{

	public $miga;

	function __construct(){
		parent::__construct();
		$this->miga = "";
	}

    /**
	 * list_empresas
	 * llama a la vista de listar los empresas
	 */
    public function list_empresas(){ 

    	$cliente = new usuarios();

    	$reg['nombre']='Empresas';

    	$cont = $cliente->listarUsuarios(0,4);

    	$reg['tabla'] ='
    	<thead>
    	<tr>
    	<th>Id</th>
    	<th>Nombre Representante</th>
    	<th>Email</th>
    	<th>Empresa</th>
    	<th>Categoría</th>
    	<th>Dominio</th>
    	<th>Estado</th>
    	<th>Sitio Web</th>
    	<th>Opciones</th>
    	</tr>
    	</thead>';

    	$reg['tabla'] .='<tbody>';
    	foreach($cont as $content){

    		$editar='empresa-edit_empresa-empresa-'.$content['id_empresa'];
    		$sitiow= ($content['web']!=0) ? 'Activo':'Inactivo';
    		$subdominio= ($content['tipodominio']=='sub') ? $content['subdominio'].'.oferto.co': $content['dominio'];
    		$reg['tabla'] .='
    		<tr id="row_'.$content['id_usuario'].'">
    		<td>'.$content['id_usuario'].'</td>
    		<td>'.$content['nombre'].' '.$content['apellidos'].'</td>
    		<td>'.$content['email'].'</td>

    		<td>'.$content['empresa'].'</td>
    		<td>'.$content['categoria'].'</td>
    		<td><a href="http://'.$subdominio.'" target="_blank">'.$subdominio.'</a></td>
    		<td>'.$content['estadoemp'].'</td>
			<td>'.$sitiow.'</td>
    		<td><a class="btn btn-mini" href="'.$editar.'">Editar</a>  <a class="delete btn btn-mini btn-danger" href="javascript:borrar('.$content['id_usuario'].')">Eliminar</a></td>
    		</tr>';

    	}
    	$reg['tabla'] .='</tbody>';

    	$this->view->show("admin/list_empresas.php", $reg);


    }


	 /**
	 * edit_empresa
	 *
	 * agregar o edit los empresas
	 * opcional(id_empresa)
	 *
	 * @access	public
	 * @author	Cerón
	 * @since	20100519
	 * @version	20100519
	 * @return 	void.
	 */
	 public function edit_empresa(){

	 	$empresa = new empresas();
	 	$cates= new ecategorias();

	 	$reg['mensaje'] = '';
	 	$reg['tarea'] = 'Nueva';          

	 	if($_SESSION['id_tipo_usuario']==2){
	 		$con = new Usuarios();	
	 	}

	 	if($this->input->post('dat') == false ){

	 		if($_SESSION['id_tipo_usuario']==4){
	 			$id_empresa= nvl($_SESSION['id_empresa'],0);
	 			$reg['tarea'] = 'Modificar';
	 		}
	 		else{
	 			$id_empresa= nvl($this->get['empresa'],0);
	 			if($id_empresa)
	 				$reg['tarea'] = 'Modificar';
	 		}

	 		$reg['reg'] = $empresa->obtener($id_empresa);  

	 		if($_SESSION['id_tipo_usuario']==2){
	 			if($id_empresa)
	 				$reg['usu'] = $con->obtenerPorEmpresa($id_empresa);
	 			$id_usuario = nvl($reg['usu']['id_usuario'],0);
	 		}

	 		if(nvl($this->get['s'],0))
	 			$reg['mensaje'] = 'Empresa Guardada';

	 	}

	 	if($this->input->post('dat') ){

	 		if($this->input->post('delimg') and $this->input->post('id')){
	 			$empresa->borrarImagen($this->input->post('id'));	
	 		}

	 		$datos = $this->input->post('dat', false);
	 		$empresa->datos = $this->input->post('dat');

	 		$empresa->datos['wtwitter']= mysql_real_escape_string($datos ['wtwitter']);
	 		$empresa->datos['otro_descripcion']=$datos ['otro_descripcion'];
	 		$empresa->datos['pago_payu']= nvl($empresa->datos['pago_payu'],0);
	 		$empresa->datos['pago_otro']= nvl($empresa->datos['pago_otro'],0);
	 		$empresa->datos['puntos_activo']= nvl($empresa->datos['puntos_activo'],0);
	 		$empresa->datos['codigo_activo']= nvl($empresa->datos['codigo_activo'],0);

	 		if(nvl($empresa->datos['dominio'])!=''){
	 			$url=$empresa->datos['dominio'];
	 			if(strpos($url,'www.') !== false){
	 				 $dominio = substr($url, 4, strlen($url)+1);
					$empresa->datos['dominio']=$dominio;
	 			}
	 		}
			$cambiadominio=0;
			$nempresa=$empresa->datos['nombre'];
	 		if($_SESSION['id_tipo_usuario']==2){
	 			$empresa->datos['web']= nvl($empresa->datos['web'],0);
	 		}
	 		else{
	 			$dominiodatos = $this->input->post('dom', false);
	 		
	 			if($dominiodatos['tipodominio']!=$empresa->datos['tipodominio'])
	 				$cambiadominio=1;
	 			elseif($dominiodatos['tipodominio']=='sub'){
	 				if($dominiodatos['subdominio']!=$empresa->datos['subdominio'])
	 					$cambiadominio=1;
	 			}
	 			elseif($dominiodatos['tipodominio']=='dom'){
	 				if($dominiodatos['dominio']!=$empresa->datos['dominio'])
	 					$cambiadominio=1;
	 			}
	 		}

	 		if(is_uploaded_file(nvl($_FILES['archivo']['tmp_name']))){
	 			$empresa->subirArchivo('archivo');
	 		}

	 		$actversion=false;
	 		if($this->input->post('id') and ($this->input->post('id_categoria')!=$empresa->datos['id_categoria'])){
	 			$actversion=true;
	 		}
	 		if( $id = $empresa->guardar($this->input->post('id'),$actversion) ){
	 			if($cambiadominio){
	 				if($empresa->datos['tipodominio']=='dom'){
	 					if($this->validar_dominio($empresa->datos['dominio'],$id)){
	 						$resp=$this->parkear_dominio($empresa->datos['dominio']);
	 					//	$resp=$this->check_dns($empresa->datos['dominio']);
	 					}
	 				}
	 				correo::enviar_nuevo_dominio($id,$nempresa);
	 			}

	 			$out = $this->input->post('usu');
	 			$per = $this->input->post('per');
	 			if(nvl($out['_username'],0)){
	 				$id_usuario= $this->input->post('id_usuario');
	 				$dat['_username'] = $out['_username'];
	 				$dat['email']     = $out['_username'];
	 				$dat['id_empresa']     = $id;
	 				$dat['id_tipo_usuario']     = 4;

	 				if(strlen($out['_password']) >= 5){
	 					$cost = 10;
	 					$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
	 					$salt = sprintf("$2a$%02d$", $cost) . $salt;
	 					$dat['_password'] =crypt($out['_password'], $salt);
	 				}

	 				$dat['estado'] = nvl($out['estado'],1);
	 				if($id_usuario > 0)	{
	 					$con->actualizar($dat,$id_usuario);
	 					$reg['mensaje'] = 'Perfil Actualizado';
	 				}else{

	 					$id_usuario = $con->agregar($dat,nvl($_SESSION['id_empresa']),0,4);
	 					$per['id_usuario'] = $id_usuario;
	 					$con->agregarPerfil($per);				
	 				}

	 				$con->actualizarPerfil($per, $id_usuario);
	 				$reg['usu'] = $con->obtener($id_usuario);
	 			}

	 			$pa= new Pa();
	 			if($pa->validar_cuenta()){
	 				$subdominio=  $empresa->getDominio($id);
	 				$_SESSION['dominio']=$subdominio;
	 				$pa->actualizarStats($subdominio,$subdominio,nvl($empresa->datos['dominio']));
	 			}


	 			redirect('empresa-edit_empresa-empresa-'.$id.'-s-1');

	 		}	
	 		else
	 			$reg['mensaje'] = "Ocurri&oacute; un error al guardar, comunicarse con soporte.";

	 		$reg['reg'] = $empresa->obtener($id);
	 	}

	 	$reg['dirfileout'] = $empresa->dirfileout;
	 	$reg['categorias']= $cates->listBoxCategorias(nvl($reg['reg']['id_categoria']));
	 	$reg['color']=$empresa->selectColor(nvl($reg['reg']['color']));
	 	$this->view->show("admin/edit_empresa.php", $reg);
	 }


	 /**
	 * borrar
	 *
	 * borra el empresa recibe el parametro por post
	 * Solicitud por ajax
	 */

	 public function borrar(){

	 	$empresa = new empresas();

	 	if($empresa->borrar($this->input->post('id')) )
	 		echo "1";
	 	else
	 		echo "0";
	 }
	 
	 public function validar_subdominio(){
	 	$serx= new empresas();
	 	$id_empresa=nvl($this->get['id'],0);
	 	$datos=$this->input->get('dat');
	 	if(!$serx->validarSubdominioEmpresa($datos['subdominio'], $id_empresa)){
	 		echo 'true';	
	 	}
	 	else {
	 		echo 'false';
	 	}
	 }

	/**
	 * lista las ultimas empresas registradas en oferto.co
	 */
	public function listarUltimos(){
		$prod = new Empresas();
		$empresas= $prod->listarUltimos(0,10);
		$cadena='';
		foreach($empresas as$emp){
			$cadena.='<li><a href="empresa-edit_empresa-empresa-'.$emp['id_empresa'].'"><span class="task"><span>'.$emp['nombre'].'</span></span></a></li>';
		}
		echo $cadena;
	}

	/************ categorias ***************/

	  /*
	* Muestra la vista con el listado de categorías
	*/
	public function categorias()
	{
		$categorias= new Ecategorias();
		$reg['categorias']= $categorias->listar();
		
		$this->view->show("admin/ecategoria.php",$reg);
	}

	/*
	* Crea una nueva categoria y genera el html correspondiente 
	* solicitud por ajax
	*/
	public function nueva_categoria()
	{
		$categorias= new Ecategorias();
		
		$categorias->datos['categoria'] = $this->input->post('nombre');
		$cuenta= $this->input->post('cuenta');
		$check= $this->input->post('check');
		

		$info='';
		$estado=0;
		if($id_categoria = $categorias->guardar()){
			$estado=1;
			$info='<li id="li_'.$id_categoria.'">';
			
			if($check){
				$info.='<div class="check">
				<input type="checkbox" class="icheck-me" data-skin="square" data-color="blue" name="cat['.$cuenta.'][id_categoria]" checked="checked" value="'.$id_categoria.'"/>
				</div>';
			}
			
			$info.='<span class="task"><span class="editable" id="cat_'.$id_categoria.'" >'.$this->input->post('nombre').'</span></span>
			<span class="task-actions">';
			if(!$check){
				$info.='<a href="javascript:delete_cate('.$id_categoria.')" class="task-delete" rel="tooltip" title="Borrar esta categoría"><i class="icon-remove"></i></a>

				</span>';
			}
			
			$info.='</li>';
		}
		
		$respuesta = array (
			'estado'=>$estado,
			'info'=>$info);

		echo json_encode($respuesta);
	}

	/*
	* Borra la categoría correspondiente a el id
	* solicitud por ajax
	*/
	public function borrar_categoria(){
		$categorias = new Ecategorias();
		if($this->input->post('id'))
		{
			$categorias->borrar($this->input->post('id'));
			echo 1;
		}
		else
			echo 0;
	}


	  /* 
	  * Edita el nombre de la categoria desde un elemento jeditable en la vista
	  * solicitud por ajax
	  */
	  public function editable(){

	  	$categoria = new Ecategorias();
	  	$categoria->datos['categoria'] = $this->input->post('value'); 	

	  	$ident = $this->input->post('id');
	  	$id= explode('_',$ident);


	  	if($id = $categoria->guardar( $id[1]))
	  		echo $this->input->post('value');
	  	else  
	  		echo 'Error al guardar';
	  }

	  static  function menu($cate, $tipo = ''){
	  	$categorias = new ecategorias();
	  	$lnod = $categorias->listar($tipo);
	  	foreach($lnod as $row) {
	  		$nproductos = $categorias->numOfertasCategoria($row['id_categoria']);
	  		if($nproductos){
	  			$nombre = $row['categoria'];

	  			$current = '';

	  			if($row['id_categoria']==$cate)
	  				$current = ' class="current" ';
	  			$link = 'href="main-productos-c-'.$row['id_categoria'].'-t-'.chstr($nombre).'"';

	  			if($nproductos)
	  				$nombre .= ' ('.$nproductos.')';
	  			echo '<li class="col-1"><a title="'.$nombre.'" '.$current.$link.'>'.$nombre.'</a></li>';
	  		}
	  	}
	  }

	  function cgaleria(){
 	    $ecategorias = new ecategorias();
        $reg['id_sesion'] = session_id();
        $reg['token'] = $this->input->post('token') ? $this->input->post('token') : 'tk'.substr(md5(date('hisu').rand(100,9999)), -7);
		
        $galeria = new Banners($reg['token']);

		$reg['mensaje'] = '';
		$reg['tarea'] = 'Agregar';
	
		if(isset($this->get['categoria']) && ($this->input->post('guardar_btn') == false )){
		    $reg['tarea'] = 'Editar';
			$reg['reg'] = $ecategorias->obtener($this->get['categoria']);

		    $reg['id_galeria'] = $reg['reg']['id_galeria'];
            $galeria -> iniciar();
			
			if(nvl($this->get['s'],0))
				$reg['mensaje'] = "Categoria guardada";
		}

        $galeria -> retomar();
        if($this->input->post('guardar_btn')){
			$galeria->datos['fecha'] = date("Y-m-d");
			$galeria->datos['nombre'] = 'banner categoria '.$this->input->post('id');
			$id_galeria = $galeria->guardar($this->input->post('id_galeria'));
           
            $ecategorias->datos['id_galeria'] = $id_galeria;
			
			if( $id = $ecategorias->guardar($this->input->post('id'))){
				redirect("empresa-cgaleria-categoria-".$id."-s-1");
			}
			else
				$reg['mensaje'] = "Ocurri&oacute; un error al guardar, comunicarse con soporte.";

			$reg['reg'] = $ecategorias->obtener($id);
		}
        else{
            $galeria -> iniciar();
        }

		$this->view->show("admin/edit_cgaleria.php", $reg);
	  }

	  
	  /*****************************/
	  
	  static function print_titulo(){
	  	$emp= new Empresas();
	  	$empresa= $emp->obtener($_SESSION['id_empresa']);
	  	echo $empresa['titulo'];
	  }
	  
	  static function print_descripcion(){
	  	$emp= new Empresas();
	  	$empresa= $emp->obtener($_SESSION['id_empresa']);
	  	echo $empresa['descripcion'];
	  }
	  
	  static function get_logo($pre='m'){
	  	$emp= new Empresas();
	  	$empresa= $emp->obtener($_SESSION['id_empresa']);
	  	if($empresa['logo']!='')
	  		return $emp->dirfileout.$pre.$empresa['logo'];
	  	else
	  		return '';
	  }
	  
	  static function get_contacto(){
	  	$emp= new Empresas();
	  	return $emp->obtenerInfoContacto($_SESSION['id_empresa']);
	  }

	  static public function datos_empresa(){
	  	$emp = new Empresas();
	  	return $emp->obtenerInfoContacto($_SESSION['id_empresa']);    
	  }

	  public function seguir(){
	  	if(nvl($_SESSION['id_tipo_usuario'])==5){
	  		$empresas= new Empresas();
	  		$empresa=$this->input->post('empresa');
	  		$estado=$this->input->post('estado');
	  		if($estado==1)
	  			exit($empresas->guardarUsuarioEmpresa($_SESSION['id_usuario'],$empresa,'siguiendo'));
	  		else
	  			exit($empresas->borrarUsuarioEmpresa($_SESSION['id_usuario'],$empresa,'siguiendo'));
	  	}
	  }

	  public function importar(){
	  	$reg['mensaje']='';
	  	if(isset($_FILES['archivo']['tmp_name'])){
	  		$empresas= new Empresas();
	  		$usuarios= new Usuarios();		
	  		if(is_uploaded_file($_FILES['archivo']['tmp_name'])){
	  			$ext = explode(".",$_FILES['archivo']['name']);
	  			$nomfile = 'temp-'.date("Ymdhis").".".$ext[count($ext)-1];

	  			if(strtolower($ext[count($ext)-1])== 'csv' or strtolower($ext[count($ext)-1])== 'txt'){
	  				move_uploaded_file($_FILES['archivo']['tmp_name'], FILES.'temp/'.$nomfile);

	  				$fp = fopen (FILES.'temp/'.$nomfile,"r");

	  				$i=0;
	  				$mensajeok='';
	  				$mensajerr='';

	  				$cost = 10;
	  				$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
	  				$salt = sprintf("$2a$%02d$", $cost) . $salt;
	  				$password =crypt('12345', $salt);


	  				while ($data = fgetcsv ($fp, 1000, ";")){
	  					$usuarios->datos=array();
	  					$empresas->datos=array();
	  					if($i==0)
	  						$i++;
	  					else{
	  						$id=0;
	  						$representante=nvl($data[0]);
	  						$nombre=nvl($data[1]);
	  						$subdominio=nvl($data[2]);
	  						$email=nvl($data[3]);


	  						if($representante!='' and $nombre!='' and $subdominio!='' and validarEmail($email)){

	  							$representante=mysql_real_escape_string($representante);
	  							$nombre=mysql_real_escape_string($nombre);
	  							$subdominio=preg_replace('/[^A-Za-z]/', '', $subdominio);

	  							if(!$usuarios->validarNombreUsuario($email)){
	  								$empresas->datos['nombre']= utf8_encode($nombre);
	  								$empresas->datos['fecha_registro']= date('Y-m-d h:i:s');
	  								$empresas->datos['skin']= 'comercio';
	  								$empresas->datos['titulo']= utf8_encode($nombre);
	  								$empresas->datos['tipodominio']= 'sub';
	  								$empresas->datos['subdominio']= $subdominio;
	  								$empresas->datos['pago_otro']= '1';

	  								if($id = $empresas->guardar(0)) {
	  									$dat= array();
	  									$id_usuario=0;
	  									$dat['_username'] = $email;
	  									$dat['email']  = $email;
	  									$dat['id_empresa']  = $id;
	  									$dat['id_tipo_usuario'] = 4;
	  									$dat['estado'] = 1;
	  									$dat['_password']=$password;

	  									if($id_usuario = $usuarios->agregar($dat)){
	  										$per= array();
	  										$per['id_usuario'] = $id_usuario;
	  										$per['nombre'] = utf8_encode($representante);
	  										$per['email'] = $email;
	  										$usuarios->agregarPerfil($per);	
	  									}	
	  									else 'retorna false';		

	  									$mensajeok.='linea '.$i.' Guardado correctamente ('.$email.') <br/>' ;
	  								}
	  							}
	  							else
	  								$mensajerr.='linea '.$i.' Error _username ya existe ('.$email.') <br/>' ;
	  						}
	  						else
	  							$mensajerr.='linea '.$i.' Error vacios o email no válido ('.$email.') <br/>' ;
	  					}
	  				}
	  				fclose ($fp); 
	  				if(file_exists(FILES.'temp/'.$nomfile)){
	  					@unlink(FILES.'temp/'.$nomfile);	
	  				}
	  				$reg['mensaje']=$mensajerr.$mensajeok;
	  			}
	  			else
	  			{
	  				$reg['mensaje']='El formato del archivo debe ser .csv';
	  			}
	  			$this->view->show("admin/importar.php",$reg);
	  		}

	  		else{
	  			$reg['mensaje']= 'Hubo un problema al subir el archivo, por favor intente de nuevo';
	  			$this->view->show("admin/importar.php",$reg);
	  		}
	  	}
	  	else
	  		$this->view->show("admin/importar.php");
	  }

	  public function exportar(){
	  	$cliente = new usuarios();
	  	$empresas= new Empresas();
    	$result = $cliente->listarUsuarios(0,4);

			$html = '<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <thead>
      <tr bgcolor="#CCCCCC">
      <th>Representante</th>
      <th>Email</th>
      <th>Teléfono</th>
      <th>Móvil</th>
     <th>Dirección</th>
     <th>Empresa</th>
     <th>Email empresa</th>
     <th>Teléfono empresa</th>
     <th>Móvil empresa</th>
     <th>Dirección empresa</th>
     <th>Facebook</th>
     <th>Twitter</th>
     <th>Categoría</th>
     <th>Subdominio</th>
     <th>Estado</th>
     <th>Sitio web</th>
     <th>Seguidores</th>
     </tr>
     </thead>
     <tbody>';

    foreach($result as $row){
    	$sitiow= ($row['web']!='0') ? 'Activo':'Inactivo';
    	$seguidores=$empresas->contarSeguidores($row['id_empresa']);
      
      $html.='<tr>
      <th>'.$row['nombre'].' '.$row['apellidos'].'</th>
      <th>'.$row['email'].'</th>
      <th>'.$row['telefono'].'</th>
      <th>'.$row['movil'].'</th>
     <th>'.$row['direccion'].'</th>
     <th>'.$row['empresa'].'</th>
     <th>'.$row['emailemp'].'</th>
     <th>'.$row['telefonoemp'].'</th>
     <th>'.$row['movilemp'].'</th>
     <th>'.$row['direccionemp'].'</th>
     <th>'.$row['facebook'].'</th>
     <th>'.$row['twitter'].'</th>
     <th>'.$row['categoria'].'</th>
     <th>'.$row['subdominio'].'</th>
     <th>'.$row['estadoemp'].'</th>
     <th>'.$sitiow.'</th>
     <th>'.$seguidores.'</th>
     </tr>';
   }
   $html.='</tbody>
   </table>';

   header("Content-type: application/vnd.ms-excel");
   header("Content-Disposition: attachment; filename=empresas_registradas_".date("Y-m-d").".xls");
   echo $html;
	}


	 public function parkear_dominio($dominio){
	 	$user = "root";
        $pass = "!iMdSkLR";
        $query = "https://server.oferto.co:10000"; 
        $cpanel = curl_init();
        $addr = $query."/virtual-server/remote.cgi";
        $string_values = "?program=create-domain&domain=".$dominio."&alias-with-mail=oferto.co&mail=&dns=&json=1";
        //$string_values = "?program=create-domain&domain=".$dominio."&alias-with-mail=inmored.co&mail=&dns=&template=wasit&json=1";
        curl_setopt($cpanel, CURLOPT_URL, $addr.$string_values);
        curl_setopt($cpanel, CURLOPT_TIMEOUT, 20);
        curl_setopt($cpanel, CURLOPT_HTTPAUTH, CURLAUTH_ANY); 
        curl_setopt($cpanel, CURLOPT_USERPWD, "$user:$pass");
        curl_setopt($cpanel, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cpanel, CURLOPT_SSL_VERIFYPEER, false);
        $respuesta['result']  = curl_exec($cpanel);

        if(curl_errno( $cpanel)){
       	 $respuesta['error'] ='Error: ' . curl_error( $cpanel );
      	}
        curl_close ($cpanel);
      	$log = new Modulos();
      	$log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], print_r($respuesta,true));
        return $respuesta;
    }

    public function validar_dominio($dominio='',$id_empresa=0){
    	$empresas= new empresas();
    	$imprimir=0;
    	$respuesta=false;
    	
    	if(isset($this->get['id'])){
    		$id_empresa=nvl($this->get['id'],0);
	 		$datos=$this->input->get('dat');
	 		$dominio = $datos['dominio'];
	 		$imprimir=1;
    	}
	 	
	 	if(strpos($dominio,'www.') !== false)
	 		$dominio = substr($dominio, 4, strlen($dominio)+1);
	 
		if(!$empresas->validarDominioEmpresa($dominio, $id_empresa))
	 		$respuesta= true;	
	 	else 
	 		$respuesta=  false;
	 	
		if($imprimir)
			echo ($respuesta) ? 'true':'false';
	 	else
	 		return $respuesta;
		
    }

    public function check_dns($dominio){
    	$dns = dns_get_record($dominio, DNS_NS);
        if(empty($dns) || ( nvl($dns[0]['target']) != 'ns1.oferto.co' && nvl($dns[0]['target']) != 'ns2.oferto.co')){
           return 'false';
        }else{
           return 'true';
        }
    }

}

?>
