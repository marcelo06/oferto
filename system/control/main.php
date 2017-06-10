<?php

class Main extends ControlBase {


	public function index(){
		$reg = array();
		if(defined('SKIN') and isset($_SESSION['id_empresa'])){
			$emp = new Empresas();

			$slide = new Slides();
			$productos= new Productos();


			$reg['slides'] = $slide->obtener_img();
			$reg['dirfileout'] = $slide->dirfileout;

			$reg['p_ofertas']= $productos->obtenerOfertas();
			$reg['p_destacados']= $productos->obtenerDestacados();

			$reg['comprados']=$productos->obtenerMasComprados(6,$_SESSION['id_empresa']);
			$reg['visitados']=$productos->obtenerMasVisitados(6,$_SESSION['id_empresa']);


			$reg['dirfileo']=$productos->dirfileout;
			$reg['dirfilep']=URLFILES."galerias/";
			if(isset($this->get['d']))
				$reg['mensaje']="Su correo ya no está suscrito Por favor contáctenos si desea volver a recibir mensajes promocionales de la empresa";
			$this->view->show('skin/'.SKIN.'/main.php',$reg);
		}
		else{
			$banners=new Banners();
			$ecategorias= new Ecategorias();
			$productos= new Productos();
			$reg['slides']= $banners->obtener_img(1);
			$reg['dirfile']=$banners->dirfileout;
			$productos= new Productos();
			$reg['dirprod']=$productos->dirfileout;
			$reg['dirgal']=URLFILES."galerias/";

			$orden='rand()';
			$ordenamiento=configsite::get_tipo('ordenamiento');
			$a_orden=explode(' ',$ordenamiento);
			switch ($a_orden[0]) {
				case 'aleatorio':
					$orden='rand()';
					break;
				case 'nombre':
					$orden=" IF(p.oferta_descripcion='', p.nombre, p.oferta_descripcion) ".$a_orden[1];
					break;
				default:
					$orden=$ordenamiento;
					break;
			}

			$reg['destacados']=$productos->obtenerOfertasDestacadas(20,$orden);

			$reg['categorias']= $ecategorias->listarCategoriasPrincipales(5);
			$i=0;
			foreach ($reg['categorias'] as $cate) {
				$reg['categorias'][$i]['productos']= $productos->obtenerOfertasCategoria($cate['id_categoria'],20,$orden);
				$i++;
			}

			$reg['populares']=$productos->obtenerOfertasMasCompradas(20);
			$mañana=date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
			$reg['vencen']=$productos->obtenerOfertasVencen($mañana);
			$this->view->show('main.php',$reg);
		}
	 }


	 public function contenido(){
	 	$con = new Contenidos();
	 	if(defined('SKIN') and isset($_SESSION['id_empresa'])){
	 		$tipo = nvl($this->get['t'],1);
	 		$con = new Contenidos();
	 		$reg['con'] = $con->obtenerEmpresa($_SESSION['id_empresa'],$tipo);
	 		$this->view->show('skin/'.SKIN.'/contenidos.php',$reg);
	 	}else{
	 		$productos= new Productos();
	 		$id = nvl($this->get['id'],1);
	 		$reg['con']= $con->obtener($id);

	 		$gal=new Galerias();
	 		$productos= new Productos();

			$reg['dirfileout'] = $gal->dirfileout;
			$reg['dirfileo'] = $productos->dirfileout;
	 		$reg['populares']=$productos->obtenerOfertasMasCompradas(20);
			$mañana=date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
			$reg['vencen']=$productos->obtenerOfertasVencen($mañana);
	 		$this->view->show('contenidos.php',$reg);
	 	}
	 }

	 public function contactenos(){
	 		$reg['mensaje'] = '';
	 		if($this->input->post('dat')){
	 			$datos = $this->input->post('dat');
	 			if(correo::enviar_contacto($datos)){
	 				//correo::enviar_confirmacion($datos);
	 				$reg['mensaje'] = 'Gracias por contactarse con nosotros. Pronto un representante se comunicará con usted.';
	 			}
	 			else
	 				$reg['mensaje'] = 'Hubo un error al enviar la información. Por favor inténtelo más tarde.';

	 		}

	 	if(defined('SKIN') and isset($_SESSION['id_empresa'])){
	 		$this->view->show('skin/'.SKIN.'/contactenos.php',$reg);
	 	}
	 	else{
	 		$gal=new Galerias();
	 		$productos= new Productos();

			$reg['dirfileout'] = $gal->dirfileout;
			$reg['dirfileo'] = $productos->dirfileout;
	 		$reg['populares']=$productos->obtenerOfertasMasCompradas(20);
			$mañana=date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
			$reg['vencen']=$productos->obtenerOfertasVencen($mañana);
	 		$this->view->show('contactenos.php',$reg);
	 	}
	 }

	 public function productos(){
	 	$producto = new Productos();
	 	$cat = new Categorias();
	 	$keyword= new Keyword();
	 	if(defined('SKIN') and isset($_SESSION['id_empresa'])){
	 		$reg['categoria'] =0;
	 		$reg['ncate']=PRODUCTOS_TXT;

	 		$id_c='';
	 		if(isset($this->get['c']))
	 			$id_c=$this->get['c'];
	 		else if( $this->input->get('c'))
	 			$id_c=$this->input->get('c');

	 		if($id_c != ''){
	 			$reg['cate'] =$cat->obtener($id_c);
	 			$reg['ncate']= $reg['cate']['categoria'];
	 			$reg['categoria'] = $id_c;
				$str_cate = '-c-'.$id_c.'-t-'.chstr($reg['ncate']);
	 		}

	 		$reg['b']=(nvl($this->get['b'])!='') ? $this->get['b']:$this->input->post('buscar');
	 		$listkey=array();
	 		if($reg['b']!=''){
	 			$keyword->guardarKeywordsBusqueda($reg['b']);
	 			$keywords=new Keywords();
	 			$key=trim($reg['b']);
	 			$key=strtolower($key);
	 			$listkey=$keywords->buscarKeyword($key);
	 		}

	 		$reg['r']=nvl($this->get['rango']);

	 		$reg['cant']=nvl($this->get['cant']);
	 		$reg['orden']= nvl($this->get['orden']);
	 		$reg['por']= nvl($this->get['por']);
	 		$reg['rango']= nvl($this->get['rango']);
	 		$var='';

	 		if(nvl($this->get['cant']))
	 			$var.='-cant-'.$this->get['cant'];
	 		if(nvl($this->get['orden']))
	 			$var.='-orden-'.$this->get['orden'];
	 		if(nvl($this->get['por']))
	 			$var.='-por-'.$this->get['por'];

	 		$reg['rmax']=$producto->obtenerMaxPrecio();//max
	 		$reg['r1']=0;
	 		$reg['r2']=$reg['rmax'];
	 		if(nvl($this->get['rango'])){
	 			$var.='-rango-'.$this->get['rango'];
	 			$vrango=explode('_', $this->get['rango']);
	 			$reg['r1']=$vrango[0];
	 			$reg['r2']=$vrango[1];
	 		}

	 		if($reg['b']!='')
	 			$var.='-b-'.$reg['b'];

	 		$actual= nvl($this->get['pagina'],1);
	 		$sql = $producto->listarSQL($reg['categoria'],nvl($this->get['orden'],'asc'),nvl($this->get['por'],'nombre'),$reg['b'],$reg['r'],$listkey);
	 		$reg['ntotal']=$producto->numSQL($reg['categoria'],$reg['r1'],$reg['r2'],$reg['b'],$listkey);

	 		$numero=nvl($this->get['cant'],9);

	 		$pag = new Paginacion($actual, $sql,$numero,$var);
	 		$pag->param = QSELF.$str_cate;
	 		$reg['pag']= $actual;
	 		$qid = $pag->paginar();
	 		$reg['productos']= $producto->resultArr($qid);
	 		$reg['dirfileo']= $producto->dirfileout;
	 		$reg['dirfilep']= URLFILES."galerias/";

	 		$reg['siguiente']= $pag->siguiente('Siguiente');
	 		$reg['anterior']= $pag->anterior('Anterior');
	 		$reg['numeracion']= $pag->numeracion();

	 		$reg['nitems']=count($reg['productos']);
	 		$reg['ini']=($actual==1 and !$reg['nitems'])? 0: (($actual-1)*$numero)+1;
	 		$reg['fin']=($actual==1 and !$reg['nitems'])? 0: $reg['ini']+$reg['nitems']-1;

	 		$this->view->show('skin/'.SKIN.'/listproductos.php', $reg);
	 	}
	 	else{
	 		$producto = new Productos();
	 		$categorias= new ecategorias();
	 		$gal= new galerias();


	 		$reg['busqueda']='';
	 		$reg['categoria'] =0;
	 		$reg['miga']='TODAS';
	 		$reg['seed']=rand(10,100);
	 		$reg['banner']=array();

	 		if($this->input->post('busqueda')){
	 			$reg['busqueda']=$this->input->post('busqueda');
	 			$keyword->guardarKeywordsBusqueda($reg['busqueda']);

	 		}elseif(isset($this->get['c'])){
	 			$id_c=$this->get['c'];
	 			if($id_c != ''){
	 				$banners= new Banners();
	 				$reg['dirbanner']=$banners->dirfileout;
	 				$reg['cate'] =$categorias->obtener($id_c);
	 				$reg['categoria'] = $id_c;
	 				$reg['miga']=strtoupper($reg['cate']['categoria']);
	 				if($reg['cate']['id_galeria']>0)
	 					$reg['banner']= $banners->obtener_img($reg['cate']['id_galeria']);

	 				if(nvl($_SESSION['id_tipo_usuario'],0)==5)
	 					$categorias->aumentarVisita($id_c,$_SESSION['id_usuario']);
	 			}
	 		}

	 		$siguiendo="";
	 		$reg['siguiendo']=(isset($this->get['siguiendo'])) ? 1:0;
	 		if($reg['siguiendo']){
	 			$siguiendo="-siguiendo-1";
	 		}

	 		$reg['rmax']=$producto->obtenerMaxPrecioOferto($reg['categoria'],$reg['busqueda'],$reg['siguiendo']);//max
	 		$reg['r1']=0;
	 		$reg['r2']=$reg['rmax'];
	 		if(nvl($this->get['rango'])){
	 			$var.='-rango-'.$this->get['rango'];
	 			$vrango=explode('_', $this->get['rango']);
	 			$reg['r1']=$vrango[0];
	 			$reg['r2']=$vrango[1];
	 		}


			$lcategorias = $categorias->listar();
			$reg['scategorias']='<option value="main-productos">Categorías:</option>';

			foreach($lcategorias as $row) {
				$nproductos=$categorias->numOfertasCategoria($row['id_categoria'],$reg['siguiendo']);
				if($nproductos){
					$nombre= $row['categoria'];
					$nombrepro=$nombre;
					$current='';
					if($row['id_categoria']==$reg['categoria'])
						$current= ' selected="selected" ';

					if($nproductos)
						$nombrepro.= ' ('.$nproductos.')';
					$reg['scategorias'].='<option '.$current.' value="main-productos-c-'.$row['id_categoria'].'-t-'.chstr($nombre).$siguiendo.'">'.$nombrepro.'</option>';
				}
			}

			$reg['dirfileout'] = $gal->dirfileout;
			$reg['dirfileo'] = $producto->dirfileout;

			$reg['populares']=$producto->obtenerOfertasMasCompradas(20);
			$mañana=date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
			$reg['vencen']=$producto->obtenerOfertasVencen($mañana);

	 		$this->view->show('listproductos.php', $reg);
	 	}
	 }

	public function producto(){
		$producto = new Productos();
			$cat = new Categorias();
			$gal = new Galerias();
			$empresas= new Empresas();
			$adic= new adicionales();

			$reg['txt_comprar']='RESERVAR';
		if(defined('SKIN') and isset($_SESSION['id_empresa'])){
			$empresa=$empresas->obtener($_SESSION['id_empresa']);

			if($empresa['pago_payu']=='1' and $empresa['payu_userid']!='' and $empresa['payu_llave']!='' and $empresa['payu_accountid']!='')
				$reg['txt_comprar']='COMPRAR';


			$reg['producto'] = $producto->obtener($this->get['id'],$_SESSION['id_empresa']);
			if(nvl($reg['producto']['id_producto'])){
				$reg['galeria'] = $gal->obtenerGaleriaFull($reg['producto']['id_galeria']);

				$reg['dirfileout'] = $gal->dirfileout;

				$reg['dirfileo'] = $producto->dirfileout;
				$reg['esoferta']=($reg['producto']['oferta']=='Activo' and ($reg['producto']['oferta_publicacion']<=date("Y-m-d")) and ($reg['producto']['oferta_vencimiento']>date("Y-m-d")) )? 1:0;
				$reg['titulo']= $reg['producto']['nombre'];

				if($reg['esoferta'])
				$reg['titulo']= ($reg['producto']['oferta_descripcion']!='') ? $reg['producto']['oferta_descripcion']: $reg['producto']['nombre'];

				$reg['titulo_sitio'] = $reg['titulo'];

				$reg['descripcion_sitio'] = $reg['producto']['descripcion'];

				if($reg['producto']['archivo']!='')
					$reg['imagen_link']= $reg['dirfileout'].'m'.$reg['producto']['archivo'];

				$categorias= $cat->obtenerProductoCategoria($reg['producto']['id_producto']);
				$preciopor=($reg['producto']['precio']*0.30);
				$preciomax=$reg['producto']['precio']+$preciopor;
				$preciomin=$reg['producto']['precio']-$preciopor;

				$reg['recomendados'] = $producto->productosRecomendados($reg['producto']['id_producto'],$categorias,$preciomax, $preciomin);

				if(nvl($reg['producto']['id_producto'])>0){
					$producto->datos['visitas']= $reg['producto']['visitas']+1;
					$producto->guardar($reg['producto']['id_producto']);
				}

				$reg['adicionales'] = $adic->listarAdicionalesPro($reg['producto']['id_producto']);
			}
			$this->view->show('skin/'.SKIN.'/producto.php', $reg);
		}
		else{
			$reg['diremp'] = $empresas->dirfileout;
			$reg['dirfileout'] = $gal->dirfileout;
			$reg['dirfileo'] = $producto->dirfileout;
			$reg['adicionales']=array();
			$reg['producto'] = $producto->obtenerOferta($this->get['id']);
			if($reg['producto']['id_producto']){
				$reg['empresa']=$empresas->obtenerCompleto($reg['producto']['id_empresa']);
				$reg['empresa']['dominio']=$empresas->getDominio($reg['producto']['id_empresa']);

				if($reg['empresa']['pago_payu']=='1' and $reg['empresa']['payu_userid']!='' and $reg['empresa']['payu_llave']!='' and $reg['empresa']['payu_accountid']!='')
					$reg['txt_comprar']='COMPRAR';


				$reg['galeria'] = $gal->obtenerGaleriaFull($reg['producto']['id_galeria']);

				$reg['titulo']=($reg['producto']['oferta_descripcion']!='') ? $reg['producto']['oferta_descripcion']:$reg['producto']['nombre'];
				$reg['titulo_sitio'] = $reg['titulo'];
				$reg['descripcion_sitio'] = $reg['producto']['descripcion'];

				if($reg['producto']['oferta_imagen']!='')
					$reg['imagen_link']= $reg['dirfileo'].'m'.$reg['producto']['oferta_imagen'];
				elseif($reg['producto']['archivo']!='')
					$reg['imagen_link']= $reg['dirfileout'].'m'.$reg['producto']['archivo'];

				if(nvl($reg['producto']['id_producto'],0)>0){
					$producto->datos['visitas_oferto']= $reg['producto']['visitas_oferto']+1;
					$producto->guardar($reg['producto']['id_producto']);

					if(nvl($_SESSION['id_tipo_usuario'],0)==5)
		 			$producto->aumentarVisitaUsuario($reg['producto']['id_producto'],$_SESSION['id_usuario']);
				}

				$reg['adicionales'] = $adic->listarAdicionalesPro($reg['producto']['id_producto']);
				$reg['siguiendo'] = 0;
				if(nvl($_SESSION['id_tipo_usuario'])==5){
					$reg['siguiendo']= $empresas->estaSiguiendo($_SESSION['id_usuario'],$reg['producto']['id_empresa']);
				}
			}
			$reg['populares']=$producto->obtenerOfertasMasCompradas(20);
			$mañana=date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
			$reg['vencen']=$producto->obtenerOfertasVencen($mañana);
			$this->view->show('producto.php', $reg);
		}

	}

	public function almacenes(){
		 $alma= new Almacenes();
		 $reg['almacenes']= $alma->listar($_SESSION['id_empresa']);
		 $reg['dirfileout']= $alma->dirfileout;
		 $this->view->show('skin/'.SKIN.'/almacenes.php',$reg);
	 }

	 public function registro(){
	 	$localidades= new Cli_localidades();
	 	$reg['compra']=0;
	 	$reg['paises']=$localidades->paisesSelect(nvl($_SESSION['d_pedido']['pais_pedido'],1));
	 	$reg['dptos']=$localidades->dptosSelect(nvl($_SESSION['d_pedido']['pais_pedido'],1),nvl($_SESSION['d_pedido']['departamento_pedido']));
	 	$reg['ciudades']=$localidades->ciudadesSelect(nvl($_SESSION['d_pedido']['departamento_pedido']),nvl($_SESSION['d_pedido']['ciudad_pedido']));

	 	if(defined('SKIN') and isset($_SESSION['id_empresa'])){
	 		if(nvl($_SESSION['nf'],0))
	 		$reg['compra']= nvl($this->get['comprar'],0);
	 	$this->view->show('skin/'.SKIN.'/registro.php',$reg);
	 	}
	 	else{
	 		$gal=new Galerias();
	 		$productos= new Productos();

			$compra= nvl($this->get['comprar'],0);
			$reg['compra']=(nvl($this->get['c'],0)) ? $compra.'-c-'.$this->get['c']:$compra;

			if(nvl($_SESSION['id_tipo_usuario'],0)==5)
				redirect('producto-checkout-comprar-'.$compra);

			if($reg['compra'])
				$_SESSION['compra']=$reg['compra'];

			$reg['dirfileout'] = $gal->dirfileout;
			$reg['dirfileo'] = $productos->dirfileout;
	 		$reg['populares']=$productos->obtenerOfertasMasCompradas(20);
			$mañana=date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
			$reg['vencen']=$productos->obtenerOfertasVencen($mañana);
	 		$this->view->show('registro.php',$reg);
	 	}
	 }

	 public function registrado(){
	 	$con= new Contenidos();
	 	$productos= new Productos();

	 		$gal=new Galerias();
	 		$productos= new Productos();

			$reg['dirfileout'] = $gal->dirfileout;
			$reg['dirfileo'] = $productos->dirfileout;
	 		$reg['populares']=$productos->obtenerOfertasMasCompradas(20);
			$mañana=date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
			$reg['vencen']=$productos->obtenerOfertasVencen($mañana);

	 	$reg['compra']= nvl($_GET['compra'],0);
	 	$this->view->show('registrado.php',$reg);
	 }

	 public function cuenta(){
	 	$localidades= new Cli_localidades();
	 	$reg['mensaje'] = '';
	 	$con = new Usuarios();
	 	$id_usuario = $_SESSION['id_usuario'];

	 	if( $this->input->post('dat') == false ){
	 		$reg['reg'] = $con->obtener($id_usuario);

	 		$reg['paises']=$localidades->paisesSelect(nvl($reg['reg']['id_pais'],1));
	 		$reg['dptos']=$localidades->dptosSelect(nvl($reg['reg']['id_pais'],1),$reg['reg']['id_dpto']);
	 		$reg['ciudades']=$localidades->ciudadesSelect(nvl($reg['reg']['id_dpto']),$reg['reg']['id_ciudad']);
	 	}

	 	if($this->input->post("dat")){
	 		$out = $this->input->post('dat');
	 		if(isset($out['_username'])){
	 			$dat['_username'] = $out['_username'];
	 			$dat['email']     = $out['_username'];
	 			$dat['id_tipo_usuario']     = $out['id_tipo_usuario'];
	 		}
	 		if(isset($out['_password'])){
	 			if(strlen($out['_password']) >= 5){
	 				$cost = 10;
				$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
				$salt = sprintf("$2a$%02d$", $cost) . $salt;
				$dat['_password'] =crypt($out['_password'], $salt);
				}
	 		}
	 		$con->actualizar($dat,$id_usuario);
	 		$reg['mensaje'] = 'Información actualizada';

	 		if(isset($out['_username'])){
	 			$per = $this->input->post('per');
	 			$per['email']     = $out['_username'];
	 			$con->actualizarPerfil($per, $id_usuario);
	 		}
	 		$reg['reg'] = $con->obtener($id_usuario);
	 		if($this->input->post('proviene')=='compra')
	 			redirect("producto-checkout");
	 	}

	 	$reg['paises']=$localidades->paisesSelect(nvl($reg['reg']['id_pais'],1));
	 		$reg['dptos']=$localidades->dptosSelect(nvl($reg['reg']['id_pais'],1),$reg['reg']['id_dpto']);
	 		$reg['ciudades']=$localidades->ciudadesSelect(nvl($reg['reg']['id_dpto']),$reg['reg']['id_ciudad']);


	 	if(defined('SKIN') and isset($_SESSION['id_empresa']))
	 		$this->view->show('skin/'.SKIN.'/usuario_cuenta.php', $reg);
	 	else{
	 		$gal=new Galerias();
	 		$productos= new Productos();

	 		$compra= nvl($this->get['comprar'],0);
			$reg['compra']=(nvl($this->get['c'],0)) ? $compra.'-c-'.$this->get['c']:$compra;

			$reg['dirfileout'] = $gal->dirfileout;
			$reg['dirfileo'] = $productos->dirfileout;
	 		$reg['populares']=$productos->obtenerOfertasMasCompradas(20);
			$mañana=date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
			$reg['vencen']=$productos->obtenerOfertasVencen($mañana);

			$pedido = new Pedidos();
			$reg['pedidos'] = $pedido->listarPorUsuario(nvl($_SESSION['id_usuario'],0),1);

			$empresas= new Empresas();
			$reg['empresas_sigue']=$empresas->listarSiguiendo($_SESSION['id_usuario']);
			$reg['dirfile']= $empresas->dirfileout;
			$this->view->show('usuario_cuenta.php', $reg);
	 	}


	 }

	 public function pedidos(){
        $us = new Usuarios();
		$pedido = new Pedidos();
		$empresas =new Empresas();

		$dempresa=$empresas->obtener($_SESSION['id_empresa']);
		$reg['mostrar_puntos']=0;

		if($dempresa['puntos_activo']==1){
			$puntos= new Puntos();
			$reg['mostrar_puntos']=1;
			$ptos= $puntos->obtenerPuntosUsuario($_SESSION['id_usuario']);
			if(nvl($ptos['puntos'])!=''){
				$reg['puntos']='<table  width="100%" border="0" cellspacing="1" cellpadding="8">
          <tr>
            <td  align="center" ><strong>Puntos</strong></td>
            <td align="center" ><strong>Redimidos</strong></td>
            <td align="center" ><strong>Ultima fecha</strong></td>
          </tr>
          <tr >

           <td align="center" >'.$ptos['puntos'].'</td>
           <td align="center" >'.$ptos['redimidos'].'</td>
           <td align="center">'.fecha_texto_resumida($ptos['ultima_fecha']).'</td>
         </tr>
       </table>';
			}
			else
			$reg['puntos'] ='No tiene puntos acumulados';
		}


		$reg['pedidos'] = $pedido->listarPorUsuario(nvl($_SESSION['id_usuario'],0),1);

		$this->view->show('skin/'.SKIN.'/pedidos.php',$reg);
	}

	public function enviarEmail(){
		if(isset($this->get['titulo'])){
			$reg['titulo']= $this->get['titulo'];
			$reg['imagen']= $this->get['imagen'];
			$reg['enlace']= $this->get['enlace'];
			$this->view->show("enviar_email.php",$reg);
		}
		elseif( $this->input->post('dat'))
		{
			$datos= $this->input->post('dat');
			if(correo::enviar_email($datos))
				exit($datos['titulo'].' ha sido enviado a '.$datos['email'].'.');
			else
				exit("Ha ocurrido un problema al enviar, por favor inténtelo más tarde.");

		}
	}

	function busqueda_sugerencias(){
		$texto= $this->input->post('texto');
		$productos= new Productos();
		$galerias = new galerias();
		$keywords = new Keywords();

		$l_categorias = array();
		$l_productos = array();
		$sugerencias='';

		$key=trim($texto);
		$key=strtolower($key);
		$listkey=$keywords->buscarKeyword($key);

		if(strlen($texto)>=2){
			if(defined('SKIN') and isset($_SESSION['id_empresa'])){
				$categorias= new Categorias();
				$l_categorias=$categorias->busqueda($texto);


				$l_productos=$productos->busqueda($texto,'empresa',$listkey);

				foreach($l_categorias as $categoria){
					$nproductos=$categorias->numProductosCategoria($categoria['id_categoria']);
					if($nproductos)
					$sugerencias.='<li class="i-categoria"><a href="main-productos-c-'.$categoria['id_categoria'].'-t-'.chstr($categoria['categoria']).'">'.$categoria['categoria'].' ('.$nproductos.')</a></li>';
				}

				foreach($l_productos as $producto){
					$nombre=($producto['oferta_descripcion']!='') ? $producto['oferta_descripcion']:$producto['nombre'];
					$imagen= ($producto['oferta_imagen']!='') ? $productos->dirfileout.'s'.$producto['oferta_imagen']:(($producto['archivo']!='') ? $galerias->dirfileout.'s'.$producto['archivo']:URLFILES.'producto.png');

					$sugerencias.='<li class="i-producto"><a href="main-producto-id-'.$producto['id_producto'].'-t-'.chstr($nombre).'"><div class="t-nombre">'.$nombre.'</div><div class="t-imagen"><img class="img-responsive" src="'.$imagen.'"/></div><div style="clear:both"></div></a></li>';
				}
			}
			else{
				$categorias= new Ecategorias();
				$l_categorias=$categorias->busqueda($texto);
				$l_productos=$productos->busqueda($texto,'oferta',$listkey);

				foreach($l_categorias as $categoria){
					$nproductos=$categorias->numOfertasCategoria($categoria['id_categoria']);
					if($nproductos)
					$sugerencias.='<li class="i-categoria"><a href="main-productos-c-'.$categoria['id_categoria'].'-t-'.chstr($categoria['categoria']).'">'.$categoria['categoria'].' ('.$nproductos.')</a></li>';
				}

				foreach($l_productos as $producto){
					$nombre=($producto['oferta_descripcion']!='') ? $producto['oferta_descripcion']:$producto['nombre'];
					$imagen= ($producto['oferta_imagen']!='') ? $productos->dirfileout.'s'.$producto['oferta_imagen']:(($producto['archivo']!='') ? $galerias->dirfileout.'s'.$producto['archivo']:URLFILES.'producto.png');

					$sugerencias.='<li class="i-producto"><a href="main-producto-id-'.$producto['id_producto'].'-t-'.chstr($nombre).'"><div class="t-nombre">'.$nombre.'</div><div class="t-imagen"><img class="img-responsive" src="'.$imagen.'"/></div><div style="clear:both"></div></a></li>';
				}
			}
		}
		$respuesta = array (
			  'cantidad'=>count($l_categorias)+count($l_productos),
			  'sugerencias'=>$sugerencias);
		echo json_encode($respuesta);

	}
}

?>