<?php

class login extends ControlBase {
		
	public function usuario(){
		$reg = array();		
		if(nvl($_SESSION['autentico'], false) )
			redirect("login-inicio");
		else{
			$this->view->show("admin/login.php", $reg);
		}
	}
	
	public function inicio(){
		switch(nvl($_SESSION['id_tipo_usuario'])){
			case 2:
				if(nvl($this->get['estadisticas'])){
					$reg['pa']=1;
					$this->view->show("admin/reportes.php",$reg);
				}
				else{
					$productos= new Productos();
			 		$pedidos= new Pedidos();
					$usuarios= new Usuarios();
					$reg['nempresas']= count($usuarios->listarUsuarios(0,4)); 
					$reg['nofertas']= $productos->numOfertas();
					$reg['npedidos']= $pedidos->countExito();
					$reg['nusuarios']= $usuarios->countTotalUsuarios(5);
					
					$this->view->show("admin/reportes.php",$reg);
				}
				
				break;
			case 4: 
				/*$ga = new ga();
				if($ga->validar_cuenta()){
					$d['instalado'] = true;
					$d['fecha_inicio'] = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")-30, date("Y") ) );
					$d['fecha_final'] = date('Y-m-d');
				}*/
				
				$pa = new pa();
				if(!$pa->validar_cuenta()){
					$empresa= new Empresas();
					$emp= $empresa->obtener($_SESSION['id_empresa']);
					$subdominio= $empresa->getDominio($_SESSION['id_empresa']);
					if($id_sitio=$pa->crear_stats($subdominio,$subdominio,$emp['dominio'])){
						$empresa->datos['pa']= $id_sitio;
						$empresa->datos['fecha_pa']= date("Y-m-d");
						$empresa->guardar($_SESSION['id_empresa']);
					}
				}
				
				if($pa->validar_cuenta()){
					$empresa= new Empresas();
					$emp= $empresa->obtener($_SESSION['id_empresa']);
					$d['pa']=$emp['pa'];
					/*if(date('Y')>date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")-30, date("Y") ) )){
						$d['fecha_inicio'] = date('Y-m-d', mktime(0, 0, 0, date("m")  , 1, date("Y") ) );	
					}else{
						$d['fecha_inicio'] = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")-30, date("Y") ) );	
					}
					
					$d['fecha_final'] = date('Y-m-d');
					
					*/
				$d['instalado'] = true;
				}
				else{
					$d['instalado'] = false;
				}
				$this->view->show("admin/main.php", $d);
				break;
			case 3: 
				$this->view->show("sys/main.php");
				break;
			case 5: 
				redirect('main-productos');
				break;
			case 6:
					$productos= new Productos();
			 		$pedidos= new Pedidos();
					$usuarios= new Usuarios();
					$reg['nempresas']= count($usuarios->listarUsuarios(0,4)); 
				
					
					$reg['npedidos_oferto']= $pedidos->countExito('oferto');
					$reg['npedidos_empresas']= $pedidos->countExito('empresas');
					$reg['npedidos']= $pedidos->countExito();
					
					$reg['nusuarios_oferto']= $usuarios->countTotalUsuarios(5,'oferto');
					$reg['nusuarios_empresas']= $usuarios->countTotalUsuarios(5,'empresas');
					$reg['nusuarios']=$reg['nusuarios_oferto']+$reg['nusuarios_empresas'];// $usuarios->countTotalUsuarios(5);
					$this->view->show("admin/reportes_estadisticas.php",$reg);
				
				
				break;
			default:
				redirect('main-index');
		}
	}
	
	public function validar() {
		$user = new Usuarios();
		if ($this -> input -> post('usuario') != "" && $this -> input -> post('pass') != "" && $this -> input -> post('trc') != false && isset($_COOKIE['token'])  &&  nvl($_COOKIE['token']) == md5($this->generar_llave() . $this -> input -> post('trc')) && nvl($_SESSION['token']) == md5($this->generar_llave() . $this -> input -> post('trc'))) {
			$empresa="";
			$tipo="";
			$clioferto=0;
			if($this ->input->post('cliente')!=""){
				$empresa=nvl($_SESSION['id_empresa']);
				$tipo=5;
			}
			elseif($this->input->post('oferto')==1){
				$clioferto=1;
				$tipo=5;
			}
				
			$nt = $user -> validarUsuario(trim($this -> input -> post('usuario')), trim($this -> input -> post('pass')),$empresa,$tipo,$clioferto);
			if($nt['id_tipo_usuario']!=5 or(nvl($_SESSION['id_empresa'])==$nt['id_empresa']) or $clioferto) {
				if ($nt != FALSE) {
					$_SESSION['id_usuario'] = $nt['id_usuario'];
					$_SESSION['id_tipo_usuario'] = $nt['id_tipo_usuario'];
					$_SESSION['nombre'] = $nt['nombre'];
					if($nt['id_tipo_usuario']==4){
						$_SESSION['id_empresa'] = $nt['id_empresa'];
						$empresa= new Empresas();
						$_SESSION['dominio']= $empresa->getDominio($_SESSION['id_empresa']);
					}
					
					$_SESSION['autentico'] = true;
					die("2");
				}else {
					die("Usuario o Contrase&ntilde;a Incorrectos");
				}
				
			} else {
				die("Usuario o Contrase&ntilde;a Incorrectos");
			}

		} else {
			die("Usuario o Contrase&ntilde;a incorrectos");
		}
		die("No tiene los permisos necesarios");
	}
	
	public function logout(){
			$this->borrar_token();
			session_destroy();
			redirect(URLBASE);
	}
	
	
	/**
	 * Crear Token
	 *
	 * Crea el token que es un hash con el timestamp
	 *
	 * @access	public  
	 * @author	Julian Vega 
	 * @since	20100213
	 * @version	20100213
	 * @return 	timestamp.  
	 */	
	
	public function crear_token() {
		$ct = time();
		setcookie('token', md5( $this->generar_llave(). $ct), 0, '/');
		$_SESSION['token'] = md5( $this->generar_llave(). $ct);
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		echo $ct;
	}
	
	/**
	 * Borra la cookie que tiene el token
	 *
	 * @access	public  
	 * @author	Julian Vega 
	 * @since	20100213
	 * @version	20100213
	 * @return 	Cookie.  
	 */	
	
	private function borrar_token(){
		setcookie('token', '', -10000, '/');
	}
	
	private function generar_llave(){
		return md5('creacion del token rhiss'.$_SERVER['HTTP_USER_AGENT'].ip_address());
	}

	public function validar_token($token){
       return ($token != false && isset($_COOKIE['token'])  &&  nvl($_COOKIE['token']) == md5($this->generar_llave() . trim($token)) && nvl($_SESSION['token']) == md5($this->generar_llave() . trim($token))) ? TRUE : FALSE;
    }
	
	public function olvido_pass(){
        if($this->validar_token($this->input->post('trc'))){
            $usr = new Usuarios();
            $user = trim($this->input->post('usuario'));
            $clioferto=0;
            $empresa='';
            $tipo=0;
			if($this ->input->post('cliente')!=""){
				$empresa=nvl($_SESSION['id_empresa']);
				$tipo=5;
			}
			elseif($this->input->post('oferto')==1){
				$clioferto=1;
				$tipo=5;
			}
			else{
				$tipo=4;
			}

            if($usr->validarNombreUsuario($user,$empresa,$clioferto,$tipo)){
                $info['email'] = $user;
                $info['token'] = urlencode(encriptar($user.'$'.time().'$'.$clioferto.'$'.$tipo.'$'.$empresa.'$', 'LlaveRhissNet'));
                //echo $user.'-'.$clioferto.'-'.$tipo.'-'.$empresa;
                if(correo::enviar_peticion_pass($info)){
                	$log = new Modulos();
           	 		$log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], 'Peticion de cambio contrasena al correo '.$user.'-'.$clioferto.'-'.$tipo.'-'.$empresa);

                    echo 'Mensaje de restablecimiento enviado';
                }else{
                    echo 'Un problema ocurrió al enviar el mensaje';
                }
            }else{
                echo 'El usuario no existe';
            }
            
        }
        
    }
    
    public function reset(){
    	$reg = array();
    	$usr = new Usuarios();
    	if($this->input->get('tk')){
    		$token  = desencriptar(urldecode($this->input->get('tk',false)),'LlaveRhissNet');
	        $datos = explode('$', $token);// $user.'-'.time().'-'.$cliente.'-'.$tipo.'-'.$empresa
			if(!$usr->validarNombreUsuario($datos[0],nvl($datos[4],0),nvl($datos[2],0),nvl($datos[3],0))){
              $reg['tipo'] = 'danger';
	           $reg['mensaje'] =  'Solicitud incorrecta, contactar a soporte@oferto.co';
	        }
	        elseif($datos[1]+(2*60*60) < time()){
	            $reg['tipo'] = 'danger';
	            $reg['mensaje'] =  'Tiempo expiró por seguridad, volver a realizar la solicitud de cambio de contraseña';
	        }
	    }

	    if($this->input->post('pass')){
	    	$log = new Modulos();
	        $log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], 'Reset contraseña  datos->email: '.$datos[0].', empresa:'.nvl($datos[4]).', deOferto: '.nvl($datos[2],0).', tipo: '.nvl($datos[3],0));

        	$pass = $this->input->post('pass');
        	if($usr->validarNombreUsuario($datos[0],nvl($datos[4],0),nvl($datos[2],0),nvl($datos[3],0))){
	            if($usr->cambiarPass($datos[0],nvl($datos[4]),nvl($datos[2],0),nvl($datos[3],0), trim($pass))){
		            $reg['tipo'] = 'success';
		            $reg['mensaje'] = 'Contraseña cambiada <br/> <br/> <a href="main-index">< Volver </a>';
	           	}else{
	           		$reg['tipo'] = 'danger';
	            	$reg['mensaje'] =  'Solicitud incorrecta, contactar a soporte@oferto.co';
	           	}
	        }
        }
        
        $this->view->show("admin/recuperar_pass.php", $reg);
        
        
    }
    
	
	
}

?>