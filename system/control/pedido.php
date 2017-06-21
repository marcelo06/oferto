<?php

/**
  * controlador Pedido
  */

class Pedido extends ControlBase {
    /**
	 * detalles
	 * muestra todo el contenido de una pedido
	 */

	public function detalles(){$pedido = new Pedidos();
		$reg['productos'] = pedido::mispedidos($this->get['id_pedido']);
		$reg['cliente'] = $pedido->obtenerCliente($this->get['id_pedido']);
		$reg['ped']= $pedido->obtener($this->get['id_pedido']);
		$this->view->show('admin/detalles_pedido.php',$reg);}

	/**
	 * lista pedidos por usuario
	 */
    public static function mispedidos($id){

		$pedido = new Pedidos();
	     return $pedido->listarProductosPedido($id);

	}

    /**
	 * list_pedidos
	 * llama a la vista de listar las pedidos
	 */
  public function list_pedidos(){

	   $ped    = new pedidos();
	   $idemp=($_SESSION['id_tipo_usuario']==2) ? 0: $_SESSION['id_empresa'];
	   $pedido = $ped->listar($idemp);

	   if(isset($this->get['cliente'])){
		   $usu= new Usuarios();
		   $usuario= $usu->obtener($this->get['cliente']);
		   $reg['buscar']= $usuario['nombre'].' '.$usuario['apellidos'];
	   }
	   if(isset($this->get['pedido'])){
		   $reg['buscar']= $this->get['pedido'];
	   }

	   $empresas= new Empresas();
	   $empresa=0;
		if($_SESSION['id_tipo_usuario']==4)
			$empresa= $_SESSION['id_empresa'];

		$dempresa=$empresas->obtener($empresa);

	   $reg['tabla'] ='
		<thead>
		  <tr>
			<th>Id</th>
			<th>Orden No.</th>
			<th>Cliente</th>
			<th>Fecha</th>
			<th>Método de pago</th>
			<th width="200px">Estado</th>
			<th>Total</th>
			<th>Empresa</th>
			<th>Plataforma</th>';

			if($dempresa['codigo_activo']==1)
				$reg['tabla'] .='<th>Código<br/>Descuento</th>';

			$reg['tabla'] .='
			<th>Opciones</th>
		  </tr>
		</thead>';

	   $reg['tabla'] .='<tbody>';
	   foreach($pedido as $content){

		 $pendienteState = "";
           $confirmadoState = "";
           $canceladoState = "";

           switch ($content['estado']) {
           	case 'Pago pendiente':
           		$pendienteState = 'selected="selected"';
           		break;
           	case 'Pago confirmado':
           		$confirmadoState = 'selected="selected"';
           		break;
           	case 'Cancelado':
           		$canceladoState = 'selected="selected"';
           		break;
           }

		$nombre= ($content['nombre']!='') ? $content['nombre']:$content['nombre_pedido'];
		$plataforma= ($content['usuempresa']==0) ? 'Oferto.co':'Sitio Web';

	/*	if($_SESSION['id_tipo_usuario']!=4){
			$estadopago=$content['estado'];
		}else
		$estadopago='<select onchange="cambiarEstado(this, '.$content['id_pedido'].' ) " style="width:170px">
	                   <option value="Pago pendiente" '.$pendienteState.' >Pago Pendiente</option>
	                   <option value="Pago confirmado" '.$confirmadoState.' >Pago Confirmado</option>
	                   <option value="Cancelado" '.$canceladoState.' >Cancelado</option>
	                  </select>';
	*/
	     $estadopago=($content['estado']!='') ? $content['estado']:'Pago pendiente';
	     $clase=($estadopago=='Pago pendiente') ? 'class="gradeAlert"':'';

	     $reg['tabla'] .='
            <tr id="'.$content['id_pedido'].'" '.$clase.'>

              <td >'.$content['id_pedido'].'</td>
			   <td>'.$content['orden'].'</td>
              <td>'.$nombre.'</td>
              <td>'.fecha_texto($content['fecha']).'</td>
			    <td>'.$content['metodo_pago'].'</td>
			   <td>'.$estadopago.'</td>
				 <td>'.$content['total'].'</td>
				 <td>'.$content['empresa'].'</td>
				 <td>'.$plataforma.'</td>';
			if($dempresa['codigo_activo']==1)
				$reg['tabla'] .='<td>'.$content['codigo_descuento'].'</td>';

			$reg['tabla'] .='
              <td><a class="formulario btn btn-mini" href="pedido-detalles-id_pedido-'.$content['id_pedido'].'">Detalles</a> <a class="delete btn btn-mini btn-danger" href="javascript:borrar('.$content['id_pedido'].')" >Eliminar</a></td>
            </tr>';
	   }

	   $reg['tabla'] .='</tbody>';
	    $this->view->show("admin/list_pedidos.php", $reg);
	 }



	 /**
	 * edit_pedido
	 *
	 * agregar o edit las pedidos
	 * opcional(id_pedido)
	 */


	  public function edit_pedido(){

	    $pedido = new pedidos();
		$reg['mensaje'] = '';

		if(isset($this->get['pedido']) && ($this->input->post('dat') == false ))
			$reg['reg'] = $pedido->obtener($this->get['pedido']);

		if( isset($this->get['delimg']) ){

			$pedido->deleteImage($this->get['pedido']);
			$pedido->datos['imagen'] = "";
			$pedido->updateimagen($this->get['pedido']);

			redirect("pedido-edit_pedido-pedido-".$this->get['pedido']."");
		}

        if($this->input->post('dat') ){

			$pedido->datos = $this->input->post('dat', false);

			if(is_uploaded_file($_FILES['archivo']['tmp_name'])){

			   $pedido->subirArchivo('archivo');
			}

			if($id = $pedido->guardar($this->input->post('id')))

				$reg['mensaje'] = "Formulario guardado";
			else

				$reg['mensaje'] = "Ocurri&oacute; un error al guardar, comunicarse con soporte.";

			$reg['reg'] = $pedido->obtener($id);
		}


		if( $this->input->post('btnCancelar_x') )

			redirect("pedido-list_pedidos");

		 $oFCKeditor = new FCKeditor('dat[contenido]');

		 $oFCKeditor->ToolbarSet = "Default" ;

		 $oFCKeditor->Height = "600" ;

		 $oFCKeditor->Width = "100%" ;

		 $oFCKeditor->Value = nvl($reg['reg']['contenido']);

		 $reg['editor'] = $oFCKeditor->CreateHtml() ;

		 $reg['dirfileout'] = $pedido->dirfileout;

		 $this->view->show("admin/edit_pedidos.php", $reg);

	  }

	  public function estado(){

     	$ped = new pedidos();
     	$prod= new Productos();

     	$estado=$this->input->post('value');
     	$id= $this->input->post('id_item');
     	$guardarestado=false;
     	if($estado!='' and $id){
	        $ped->datos['estado'] = $estado;

			if($estado=='Pago confirmado'){
				$ped->datos['compra']=1;
				$guardarestado=1;
				//$this->estadoProductoPedido($id,1);
			}

			elseif($estado=='Cancelado'){
				$ped->datos['compra']=0;
				$guardarestado=0;
				//$this->estadoProductoPedido($id,0);
			}

	        if($ped->guardar($id)){
	        	$this->estadoProductoPedido($id,$guardarestado);
	          	echo $estado;
	        }
	        else
	        	echo 'Error';
	    }
     }



	 /**
	 * borrar
	 *
	 * borra la pedido recibe el parametro por post
	 */

	 public function borrar(){

	   $pedido = new pedidos();
		if($pedido->borrar($this->input->post('id')) )
			echo "1";
		else
			echo "0";
	 }


	 /**
	 * borrar
	 *
	 * guarda el rating dado desde la vista.
	 */
	 public static function rating()
	{
		$ped= new pedidos();
		$aResponse['error'] = false;

		if(isset($_POST['action']))
		{
			if(htmlentities($_POST['action'], ENT_QUOTES, 'UTF-8') == 'rating')
			{
				$id = intval($_POST['idBox']);
				$ped->datos['calificacion']=  floatval($_POST['rate']);

				if($id_calificacion=$ped->guardar($id))
				{
					$success = true;
					$aResponse['error'] = false;
				}
				else
				{
					$success = false;
					$aResponse['error'] = true;
				}

			}
			else
			$aResponse['error'] = true;
		}
		else
		$aResponse['error'] = true;

		echo json_encode($aResponse);
	}

	public function pruebaonline()
	{
		$estado_pago= 1;

		redirect("pedido-respuesta?estado_pago=".$estado_pago."");
	}

	public function enviar_pago(){
		$ped= new Pedidos();
		$productos= new Productos();
		$conf= new empresas();
		$cart = new carrito();
		$metodo_pago = nvl($_POST['metodo_pago'], 'otro');

		if(defined('SKIN') and isset($_SESSION['id_empresa'])){

			$metodo_pago = nvl($_POST['metodo_pago'], 'otro');
			if(nvl($_SESSION['d_pedido']['email_pedido'])!='' and (nvl($_SESSION['nf'],0))){
				$valido=1;
				//validar cantidades a comprar
				$cproducto= new Producto();
				$ids=array();
				for($p =0; $p<$cart->nf; $p++){

					if(nvl($cart->carro['estado'][$p]) and (!in_array($cart->carro['producto'][$p], $ids))){
						array_push($ids, $cart->carro['producto'][$p]);
						if($cproducto->validar_cantidad_carrito($cart->carro['producto'][$p],0)!=1){
							$valido=0;
							break;
						}

					}
				}
				//fin validar

				if($valido>0){
					$empresa= $conf->obtener($_SESSION['id_empresa']);


					$ped->datos= $_SESSION['d_pedido'];
					$orden=date("Ymdhis");
					$ped->datos['orden'] = $orden;
					$ped->datos['metodo_pago'] = ucfirst($metodo_pago);
					$ped->datos['compra']=0;

					$ped->datos['estado'] = 'Pago pendiente';
					$descripcion='Compra de productos en '.DOMINIO.', Pedido No.'.$orden;
					$emailComprador=  $_SESSION['d_pedido']['email_pedido'];
					$ped->datos['id_empresa']=$_SESSION['id_empresa'];

					$id_pedido = $ped->guardar(0);
					unset($_SESSION['d_pedido']);

					$total = 0;
					$moneda = 'COP';

					$i_emp=0;
					$es_promocion=0;
					for($p =0; $p<$cart->nf; $p++){
						if(nvl($cart->carro['estado'][$p])){
							$dat['id_producto'] = $cart->carro['producto'][$p];
							$dat['nombre'] = $cart->carro['nombre'][$p].$cart->carro['referencia'][$p];
							$dat['id_pedido'] = $id_pedido;
							$dat['precio'] = $cart->carro['precio'][$p];
							$dat['cantidad'] = $cart->carro['cantidad'][$p];

							$ped->guardarProductosPedido($dat);

							$preciot = $cart->carro['precio'][$p]*$cart->carro['cantidad'][$p];
							$total += $preciot;

							$producto= $productos->obtener($dat['id_producto'] );
							$esofertaprod=($producto['oferta']=='Activo' and ($producto['oferta_publicacion']<=date("Y-m-d")) and ($producto['oferta_vencimiento']>date("Y-m-d")) )? 1:0;

							if($es_promocion==0 and $esofertaprod){
								$es_promocion=1;
							}

							if(($producto['oferta_existencia_estado']=='1') or ($producto['existencia_estado']=='1')){
								if($esofertaprod and $producto['oferta_existencia_estado']=='1'){
									$unidades=$producto['oferta_existencia']-$dat['cantidad'];
									$productos->datos['oferta_existencia']= $unidades;
									$productos->guardar($dat['id_producto']);
								}

								if($producto['existencia_estado']=='1'){
									$unidades=$producto['existencia']-$dat['cantidad'];
									$productos->datos['existencia']= $unidades;
									$productos->guardar($dat['id_producto']);
								}

							}
						}
					}
					$ped->datos= array();
					$ped->datos['total']=$total;
					if($es_promocion and $empresa['codigo_activo']=='1'){
						$cod_desc=md5($orden.rand(0,99));
						$cod_desc=substr($cod_desc, -8,strlen($cod_desc)-1);
						$ped->datos['codigo_descuento']=$cod_desc;
						$ped->guardar($id_pedido);
					}


					$reg['id_pedido']=$id_pedido;
					$cart->destruirCarrito();

					$refventa= $id_pedido;
					$valor= $total;

					if($metodo_pago=='otro'){

						$reg['form']='<h1>Su pedido se ha registrado con exito, por favor siga los pasos indicados para concretar la compra.</h1><p>&nbsp;</p><p>'.$empresa['otro_descripcion'].'</p>';
						correo::enviar_correo_cotizacion($id_pedido);
						correo::enviar_compra($id_pedido);
					}
					else{

						if($metodo_pago == 'ii-money')
						{
							$convenio = $empresa['iimoney_convenio'];
                                $_SESSION['pro_description']=$producto['descripcion'];
                                $_SESSION['pro_total']=$valor;
								$reg['form'] = '<form name="form_pago" id="form_pago" method="get" action="http://pagos.ii-money.com/payment/login" target="_self">
										<input id="local_id" type="hidden" name="local_id" value="'.$convenio.'">
										<input id="transaction_type" type="hidden" name="transaction_type" value="payment">
										<input id="ref_id" type="hidden" name="ref_id" value="'.$refventa.'">
										<input id="description" type="hidden" name="description" value="Producto 1">
										<input id="total" type="hidden" name="total" value="'.$valor.'">
										<input id="success_url" type="hidden" name="success_url" value="http://'.DOMINIO.URLBASE.'pedido-respuesta-estado-success">
										<input id="error_url" type="hidden" name="error_url" value="http://'.DOMINIO.URLBASE.'pedido-respuesta-estado-failed">
										<input type="image" src="'.URLVISTA.'images/boton_ii-money.png" border="0" name="submit" alt="Comprar con ii-money">
									</form>';
						}
						else
						{
						$llave=  $empresa['payu_llave'];
						$userid= $empresa['payu_userid'];
						$accountid= $empresa['payu_accountid'];

						$moneda= 'COP';
						$based= '0';
						$iva= '0';
						$prueba=($empresa['payu_test']=='0') ? 0:1;

				//ApiKey~merchantId~referenceCode~amount~currency
						$firma= md5($llave.'~'.$userid.'~'.$refventa.'~'.$valor.'~'.$moneda);

						$url= ($prueba) ? 'https://stg.gateway.payulatam.com/ppp-web-gateway/':'https://gateway.payulatam.com/ppp-web-gateway/';
						$reg['form']= '<form name="form_pago" id="form_pago" method="post"
						action="'.$url.'">
						<input name="referenceCode" type="hidden" value="'.$refventa.'">
						<input name="merchantId"  type="hidden" value="'.$userid.'">
						<input name="accountId"  type="hidden" value="'.$accountid.'">
						<input name="descripcion"  type="hidden" value="'.$descripcion.'">
						<input name="buyerEmail" type="hidden" value="'.$emailComprador.'">
						<input name="amount" type="hidden" value="'.$valor.'">
						<input name="taxReturnBase" type="hidden"value="'.$based.'">
						<input name="tax" type="hidden" value="'.$iva.'">
						<input name="currency" type="hidden" value="'.$moneda.'">
						<input name="signature" type="hidden" value="'.$firma.'">
						<input type="hidden" name="Test" value="'.$prueba.'">

						<input type="hidden" name="responseUrl" value="http://'.DOMINIO.URLBASE.'pedido-respuesta-orden-'.$orden.'">
						<input type="hidden" name="confirmationUrl" value="http://'.DOMINIO.URLBASE.'pedido-confirmacion">
						<h2>Redireccionando al modulo de pagos.....</h2>
						<p>Si en 30 segundos no ha entrado a pagosonline de click en
						<input type="submit" name="submit2" value="Ir a pagosonline" data-role="none"></p>
						</form>';
						}
					}
					$this->view->show('skin/'.SKIN.'/modulo_pago.php', $reg);
				}else{
					redirect('producto-carrito-msj-2');
				}
			}else{
					redirect('main-productos');
			}
		}
		elseif(nvl($_SESSION['d_pedido']['email_pedido'])!='' and (nvl($_SESSION['compra'],0))){
				$opciones= new Opciones();
				$idcompra= explode('_', $_SESSION['compra']);
				$prodcompra= $productos->obtener($idcompra[0]);
				$metodo_pago= $this->input->post('metodo_pago');
				$cantidad= $this->input->post('cantidad');
				$cantidad= intval($cantidad);

				if($prodcompra['id_producto'] and is_int($cantidad)){

					$valido=1;
				//validar cantidades a comprar
					if($prodcompra['oferta_existencia_estado']=='1'){
						if($prodcompra['oferta_existencia']<$cantidad)
						$valido=0;
					}
					elseif($prodcompra['existencia_estado']=='1' and $prodcompra['existencia']<$cantidad)
						$valido=0;
				//fin validar

					if($valido){
						$ped->datos= $_SESSION['d_pedido'];

						$idusu=$_SESSION['d_pedido']['id_usuario'];
						$orden=date("Ymdhis");
						$ped->datos['orden'] = $orden;
						$ped->datos['metodo_pago'] = ucfirst($metodo_pago);
						$ped->datos['compra']=0;
						$ped->datos['estado'] = 'Pago pendiente';
						$descripcion='Compra de productos en '.DOMINIO.', Pedido No.'.$orden;
						$emailComprador=  $_SESSION['d_pedido']['email_pedido'];

						$opciones= new Opciones();
						$idcompra= explode('_', $_SESSION['compra']);
						$prodcompra= $productos->obtener($idcompra[0]);
						$idemp=$prodcompra['id_empresa'];
						$ped->datos['id_empresa']=$idemp;

						$empresa= $conf->obtener($idemp);


						$id_pedido = $ped->guardar(0);
						unset($_SESSION['d_pedido']);
						$total = 0;
						$moneda= 'COP';

						$cadicionales='';

						for($i=1;$i<sizeof($idcompra); $i++){
							$opcion=$opciones->obtener($idcompra[$i]);
							if($opcion['id_adicional_opcion'] and ($opcion['id_producto']==$idcompra[0]))
								$cadicionales.=', '.$opcion['adicional'].': '.$opcion['opcion'];
						}


						$dat['id_producto'] = $prodcompra['id_producto'];
						$dat['nombre'] = ($prodcompra['oferta_descripcion']!='') ? $prodcompra['oferta_descripcion'].$cadicionales: $prodcompra['nombre'].$cadicionales;
						$dat['id_pedido'] = $id_pedido;
						$dat['precio'] = $prodcompra['oferta_precio'];
						$dat['cantidad'] = $cantidad;

						$ped->guardarProductosPedido($dat);
						$total =$prodcompra['oferta_precio'];

						$producto= $productos->obtener($prodcompra['id_producto']);
						$esofertaprod=($producto['oferta']=='Activo' and ($producto['oferta_publicacion']<=date("Y-m-d")) and ($producto['oferta_vencimiento']>date("Y-m-d")) )? 1:0;

						if(($producto['oferta_existencia_estado']=='1') or ($producto['existencia_estado']=='1')){
							if($producto['oferta_existencia_estado']=='1'){
								$unidades=$producto['oferta_existencia']-$cantidad;
								$productos->datos['oferta_existencia']= $unidades;
							}

							if($producto['existencia_estado']=='1'){
								$unidades=$producto['existencia']-$cantidad;
								$productos->datos['existencia']= $unidades;
							}
							$productos->guardar($prodcompra['id_producto']);
						}

						$ped->datos= array();
						$ped->datos['total']=$total;

						if($empresa['codigo_activo']=='1'){
							$cod_desc=md5($orden.rand(0,99));
							$cod_desc=substr($cod_desc, -8,strlen($cod_desc)-1);
							$ped->datos['codigo_descuento']=$cod_desc;
						}

						$ped->guardar($id_pedido);
						$reg['id_pedido']=$id_pedido;
						unset($_SESSION['compra']);

						$conf->guardarUsuarioEmpresa($idusu,$idemp);
						$refventa= $id_pedido;
						$valor= $total;
						$empresa= $conf->obtener($idemp);
						$dominio= $conf->getDominio($idemp);

						if($metodo_pago=='otro'){
							$reg['form']='<h4>Su pedido se ha registrado con exito, por favor siga los pasos indicados para concretar la compra.</h4><p>&nbsp;</p>';
							$reg['form'].=($empresa['otro_descripcion']!='') ? '<p>'.$empresa['otro_descripcion'].'</p>':'<p>La forma de pago no ha sido definida, por favor <a href="http://'.$dominio.'/main-contactenos" target="_blank">comuníquese con la empresa</a> para realizar el pago correspondiente a la compra</p>';
							correo::enviar_correo_cotizacion($id_pedido);
							correo::enviar_compra($id_pedido);
						}
						else{
							if($metodo_pago == 'ii-money')
							{
								
								$convenio = $empresa['iimoney_convenio'];
                                $_SESSION['pro_description']=$producto['descripcion'];
                                $_SESSION['pro_total']=$valor;
								$reg['form'] = '<form name="form_pago" id="form_pago" method="get" action="http://pagos.ii-money.com/payment/login" target="_self">
										<input id="local_id" type="hidden" name="local_id" value="'.$convenio.'">
										<input id="transaction_type" type="hidden" name="transaction_type" value="payment">
										<input id="ref_id" type="hidden" name="ref_id" value="'.$refventa.'">
										<input id="description" type="hidden" name="description" value="Producto 1">
										<input id="total" type="hidden" name="total" value="'.$valor.'">
										<input id="success_url" type="hidden" name="success_url" value="http://'.DOMINIO.URLBASE.'pedido-respuesta-estado-success">
										<input id="error_url" type="hidden" name="error_url" value="http://'.DOMINIO.URLBASE.'pedido-respuesta-estado-failed">
										<input type="image" src="'.URLVISTA.'images/boton_ii-money.png" border="0" name="submit" alt="Comprar con ii-money">
									</form>';
							}
							else
							{
								$llave=  $empresa['payu_llave'];
								$userid= $empresa['payu_userid'];
								$accountid= $empresa['payu_accountid'];

								$moneda= 'COP';
								$based= '0';
								$iva= '0';
								$prueba=($empresa['payu_test']=='0') ? 0:1;

						//ApiKey~merchantId~referenceCode~amount~currency
								$firma= md5($llave.'~'.$userid.'~'.$refventa.'~'.$valor.'~'.$moneda);

								$url= ($prueba) ? 'https://stg.gateway.payulatam.com/ppp-web-gateway/':'https://gateway.payulatam.com/ppp-web-gateway/';
								$reg['form']= '<form name="form_pago" id="form_pago" method="post"
								action="'.$url.'">
								<input name="referenceCode" type="hidden" value="'.$refventa.'">
								<input name="merchantId"  type="hidden" value="'.$userid.'">
								<input name="accountId"  type="hidden" value="'.$accountid.'">
								<input name="descripcion"  type="hidden" value="'.$descripcion.'">
								<input name="buyerEmail" type="hidden" value="'.$emailComprador.'">
								<input name="amount" type="hidden" value="'.$valor.'">
								<input name="taxReturnBase" type="hidden"value="'.$based.'">
								<input name="tax" type="hidden" value="'.$iva.'">
								<input name="currency" type="hidden" value="'.$moneda.'">
								<input name="signature" type="hidden" value="'.$firma.'">
								<input type="hidden" name="Test" value="'.$prueba.'">

								<input type="hidden" name="responseUrl" value="http://'.DOMINIO.URLBASE.'pedido-respuesta-orden-'.$orden.'">
								<input type="hidden" name="confirmationUrl" value="http://'.DOMINIO.URLBASE.'pedido-confirmacion">
								<h2>Redireccionando al modulo de pagos.....</h2>
								<p>Si en 30 segundos no ha entrado a pagosonline de click en
								<input type="submit" name="submit2" value="Ir a pagosonline" data-role="none"></p>
								</form>';
							}
						}
						$this->view->show('modulo_pago.php', $reg);
					}
					else
						redirect('main-producto-id-'.$prodcompra['id_producto']);
				}
				else
					redirect('main-productos');
		}else{
				redirect('main-productos');
		}
	}

	public function respuesta(){
		$ped= new Pedidos();
		$reg['titulo']= 'TRANSACCIÓN FALLIDA';
		$reg['informe']= 'Transacci&oacute;n fallida prueba';

		if(isset($_GET['transactionState'])){
			$id_pedido=nvl($_GET['referenceCode']);
			$state_pol=nvl($_GET['transactionState']);

			$processingDate=nvl($_GET['processingDate']);
			$reference_pol=nvl($_GET['reference_pol']);
			$orden=nvl($this->get['orden']);

			$resconcecod_pol= nvl($_GET['polResponseCode']);

			$cus=nvl($_GET['cus']);
			$banco_pse=nvl($_GET['pseBank']);
			$value=nvl($_GET['TX_VALUE'],0);


			if($state_pol== 6 && $resconcecod_pol == 5){
				$reg['mensaje']= 'Transacci&oacute;n fallida';
			}
			else if($state_pol== 6 && $resconcecod_pol == 4){
				$reg['mensaje'] = "Transacci&oacute;n rechazada";
			}
			else if($state_pol == 12 && $resconcecod_pol== 9994){
				$reg['mensaje'] ="Pendiente, Por favor revisar si el d&eacute;bito fue realizado en el Banco";
			}
			else if($state_pol == 4 && $resconcecod_pol == 1){
				$pedido= $ped->obtener($id_pedido);
				if($pedido['id_pedido']){
					$reg['id_pedido']= $pedido['id_pedido'];
					$reg['titulo']= 'TRANSACCIÓN EXITOSA';
					$reg['mensaje'] = "Transacci&oacute;n aprobada";
				}
				else{
					$reg['titulo']= 'TRANSACCIÓN EXITOSA';
					$reg['mensaje'] = "La transacción fue aprobada pero no se encontró el pedido correspondiente en nuestro sistema. Por favor comuníquese con nosotros.";
				}
			}
			else{
				$reg['mensaje'] =nvl($_GET['mensaje']);
			}

			$reg['informe']='<table align="center" width="400" cellpadding="5" cellspacing="3" border="0" class="t_pedido">
			<tr><td><strong>Fecha de procesamiento</strong></td><td>'.$processingDate.'</td></tr>
			<tr><td><strong>Estado de la transacci&oacute;n</strong></td><td>'.$reg['mensaje'] .'</td></tr>
			<tr><td><strong>Pedido #</strong></td><td>'.$orden.'</td></tr>
			<tr><td><strong>Referencia de la transaccion</strong></td><td>'.$reference_pol.'</td></tr>
			<tr>';
			if($banco_pse!=null){
				$reg['informe'].='<tr><td><strong>Cus</strong></td><td>'.$cus.'</td></tr>
				<tr><td><strong>Banco</strong></td><td>'.$banco_pse.'</td></tr>';
			}
			$reg['informe'].='<tr><td><strong>Valor total</strong></td><td>'.vn($value).' COP</td></tr>
			</table>';
		}
        else{
					$codtrans=nvl($this->get['estado']);
        			if($codtrans=="success")
        			{
        			        				
		    			$ref_id = nvl($_GET['ref_id']);
				        $description = $_SESSION['pro_description'];
				        $total = $_SESSION['pro_total'];
				                
				        $pedido= $ped->obtener($ref_id);	
				        $NuevoPed= $ped->actualizarEstado($ref_id, "Pago confirmado");
						if($pedido['id_pedido'])
						{
							$reg['id_pedido']= $pedido['id_pedido'];
							$reg['titulo']= 'TRANSACCIÓN EXITOSA';
							//$reg['mensaje'] = "Transacci&oacute;n aprobada";
						}
						else
						{
							$reg['titulo']= 'TRANSACCIÓN EXITOSA';
							$reg['mensaje'] = "La transacción fue aprobada pero no se encontró el pedido correspondiente en nuestro sistema. Por favor comuníquese con nosotros.";
						}
				                            
				        $reg['informe']='<table align="center" width="400" cellpadding="5" cellspacing="3" border="0" class="t_pedido">
						<tr><td><strong>Fecha de procesamiento</strong></td><td>'.$pedido['fecha'].'</td></tr>
						<tr><td><strong>Estado de la transacci&oacute;n</strong></td><td>'.$reg['titulo'] .'</td></tr>
						<tr><td><strong>Pedido #</strong></td><td>'.$ref_id.'</td></tr>
						<tr><td><strong>Descripci&oacute;n</strong></td><td>'.$description.'</td></tr>
						<tr>';
						$reg['informe'].='<tr><td><strong>Valor total</strong></td><td>'.vn($total).' COP</td></tr>
						</table>';
				        
				        if(defined('SKIN') and isset($_SESSION['id_empresa']))
						$this->view->show('skin/'.SKIN.'/modulo_pago.php', $reg);
						else
						{
							$this->view->show('modulo_pago.php', $reg);
						}
        			}     

		}

		if(defined('SKIN') and isset($_SESSION['id_empresa']))
		$this->view->show('skin/'.SKIN.'/modulo_pago.php', $reg);
		else{
			$this->view->show('modulo_pago.php', $reg);
		}

	}

	
	public function confirmacion(){

		$reg= '';
		$ped= new Pedidos();
		$prod=new Productos();

		if($this->input->post('state_pol')){
			$state_pol=$this->input->post('state_pol');
			$referencia_pol=$this->input->post('response_code_pol');
			$id_pedido=$this->input->post('reference_sale');
			$extra1=$this->input->post('extra1');

			$pedido= $ped->obtener($id_pedido);

			if(nvl($pedido['id_pedido'],0)){
					$ped->datos='';

					$ped->datos['estado']= ($state_pol==4) ? 'Pago confirmado':'Pago pendiente';
					$ped->datos['compra']= ($state_pol==4) ? '1':'0';
					$ped->guardar($pedido['id_pedido']);

				if ($state_pol==4){
					$this->estadoProductoPedido($pedido['id_pedido'],1);

					$idusu= $pedido['id_usuario'];
					$idemp= $pedido['id_empresa'];

					correo::enviar_correo_cotizacion($pedido['id_pedido']);
					correo::enviar_compra($pedido['id_pedido']);

				}
				else
					$this->estadoProductoPedido($pedido['id_pedido'],0);
			}
		}
	}

	public function estadoProductoPedido($id_pedido,$estado){
		$ped= new Pedidos();
		$empresas= new Empresas();
		$prod= new Productos();
		$cadena='';

		$proped=$ped->listarProductosPedido($id_pedido);

		foreach($proped as $prope){
			$producto= $prod->obtener($prope['id_producto']);
			$esofertaprod=($producto['oferta']=='Activo' and ($producto['oferta_publicacion']<=date("Y-m-d")) and ($producto['oferta_vencimiento']>date("Y-m-d")) )? 1:0;
			if($estado==1){
				$prod->datos['compras']= $producto['compras']+$prope['cantidad'];
				$cadena.='<br> * '.$prope['nombre'];
				$prod->guardar($prope['id_producto']);
			}
			elseif($estado==0){
				if($esofertaprod and $producto['oferta_existencia_estado']=='1'){
					$unidades=$producto['oferta_existencia']+$prope['cantidad'];
					$prod->datos['oferta_existencia']= $unidades;
				}

				if($producto['existencia_estado']=='1'){
					$unidades=$producto['existencia']+$prope['cantidad'];
					$prod->datos['existencia']= $unidades;
				}
				$prod->guardar($prope['id_producto']);
			}
		}

		$pedido= $ped->obtener($id_pedido);
		$empresa=$empresas->obtener($pedido['id_empresa']);
		if($empresa['puntos_activo']==1 and $estado==1){
			$usuarios= new Usuarios();

			$usuario= $usuarios->obtener($pedido['id_usuario']);

			if($pedido['id_usuario'] and nvl($usuario['id_empresa'])==$pedido['id_empresa']){
				$unidades=$empresa['puntos_unidad'];
				$puntos= new Puntos();
				$total=$pedido['total'];
				$ptos=($total/1000) * $unidades;
				$puntos->sumarPuntos($pedido['id_usuario'],$ptos);
			}
		}

		if($estado){
			correo::enviar_calificar_productos($pedido['id_usuario'],$cadena);
		}


	}


	public function exportar_ventas(){
		$ped    = new pedidos();
		$idemp=($_SESSION['id_tipo_usuario']==2) ? 0: $_SESSION['id_empresa'];
		$result = $ped->listar($idemp);

		$html = '<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<thead>
		<tr bgcolor="#CCCCCC">
		<th>Orden No.</th>
		<th>Cliente</th>
		<th>Fecha</th>
		<th>Método de pago</th>
		<th>Estado</th>
		<th>Total</th>
		<th>Empresa</th>
		<th>Plataforma</th>
		<th>Productos</th>
		</tr>
		</thead>
		<tbody>';

		foreach($result as $row){
			$nombre= ($row['nombre']!='') ? $row['nombre']:$row['nombre_pedido'];
			$plataforma= ($row['usuempresa']==0) ? 'Oferto.co':'Sitio Web';

			$proped= $ped->listarProductosPedido($row['id_pedido']);

			$productos='';
			foreach($proped as $nom){
				$productos.=$nom['nombre'].' - ';
			}

			if($productos!='')
			$productos= substr($productos, 0, strlen($productos)-3);

			$html.='<tr>
			<th>'.$row['orden'].'</th>
			<th>'.$nombre.'</th>
			<th>'.$row['fecha'].'</th>
			<th>'.$row['metodo_pago'].'</th>
			<th>'.$row['estado'].'</th>
			<th>'.vn($row['total']).'</th>
			<th>'.$row['empresa'].'</th>
			<th>'.$plataforma.'</th>
			<th>'.$productos.'</th>
			</tr>';
		}

		$html.='</tbody></table>';
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=ventas_".date("Y-m-d").".xls");
		echo $html;
	}

	static function pendientes($cantidad=0){
		$pedidos= new Pedidos();
		$lpedidos= $pedidos->listar($_SESSION['id_empresa'],1);
		$npedidos=count($lpedidos);
		$cadena='';
		$more='';

		$i=0;
		foreach($lpedidos as $row){
			$nombre= ($row['nombre']!='') ? $row['nombre']:$row['nombre_pedido'];
			$plataforma= ($row['usuempresa']==0) ? 'Oferto.co':'Sitio Web';

			$cadena.='<li><a href="pedido-list_pedidos-pedido-'.$row['orden'].'"><div class="details">
										<div class="name">'.$nombre.'</div>
										<div class="message">
											'.$row['fecha'].'. Plataforma: '.$plataforma.'
										</div>
									</div>
								</a>
					</li>';
		$i++;
		if($cantidad>0 and $i>=$cantidad){
			$more.='... ';
				break;
			}
		}

		$cadena.='<li><a href="pedido-list_pedidos" class="more-messages">'.$more.'Ver todos los pedidos <i class="icon-arrow-right"></i></a></li>';

		$reg['cantidad']=$npedidos;
		$reg['lista']=$cadena;
		return $reg;
	}
}
?>