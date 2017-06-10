<?php

/**
  * controlador Producto
  *
  *
  *
  * @package   Producto
  * @author	   Sebastian Lopez
  * @since	   20100519
  * @version   20100519
*/

class Producto extends ControlBase{

	public $miga;

	function __construct(){
		parent::__construct();
		$this->miga = "";
	}

	public function paginar(){
	   
	  	$producto = new productos();
	  	$galerias = new galerias();
		$dirfileout = $producto->dirfileout;
		
		$categoria=$this->input->post('categoria');
		$busqueda=$this->input->post('busqueda');
		$listkey= array();
		if($busqueda!=''){
 			$keywords=new Keywords();
 			$key=trim($busqueda);
 			$key=strtolower($key);
 			$listkey=$keywords->buscarKeyword($key);
 		}
	 			

		$siguiendo=$this->input->post('siguiendo');
		$rango=$this->input->post('rango');
		$orden=$this->input->post('orden');

		$seed=$this->input->post('seed');

		if($orden==''){
			$ordenamiento=configsite::get_tipo('ordenamiento');
			$a_orden=explode(' ',$ordenamiento);
			switch ($a_orden[0]) {
				case 'aleatorio':
					break;
				case 'nombre':
					$orden=" IF(p.oferta_descripcion='', p.nombre, p.oferta_descripcion) ".$a_orden[1];
					break;
				default:
					$orden=$ordenamiento;
					break;
			}
		}

		
		$sql = $producto->listarOfertasSQL($categoria,$busqueda,$orden,$siguiendo,$rango,$listkey,$seed);
		
		$pag = new Paginacion($this->input->post('pagina'), $sql,12);
		
		 $reg['pag']= $this->input->post('pagina');
		 
		$qid = $pag->paginar();
		
		 $reg['siguiente']= $pag->siguientePag('siguiente');
		
		$productos = $producto->resultArr($qid);
		
		$cadena='';
		foreach($productos as $row)
		{
			$nombre=($row['oferta_descripcion']!='') ? $row['oferta_descripcion']:$row['nombre'];
			$imagen= ($row['oferta_imagen']!='') ? $producto->dirfileout.'m'.$row['oferta_imagen']:(($row['archivo']!='') ? $galerias->dirfileout.'m'.$row['archivo']:URLFILES.'producto.png');
			$enlace='main-producto-id-'.$row['id_producto'].'-t-'.chstr($nombre);
			$precio_old=($row['precio'] and ($row['oferta_precio']<$row['precio'])) ? vn($row['precio']):'';
			$precio=($row['oferta_precio']) ? vn($row['oferta_precio']):'';	
			
			$porcentaje= ($row['porcentaje']>0 && $row['porcentaje']<100) ? '<span class="tagOff">'.$row['porcentaje'].'%</span>':'';
			$faltan= resta_fechas($row['oferta_vencimiento'],date("Y-m-d"));

			$existencia=1;
			if($row['oferta_existencia_estado']=='1'){
		   		if(!$row['oferta_existencia'])
		   			$existencia=0;
		   	}
		   	elseif($row['existencia_estado']=='1'){
		   		if(!$row['existencia'])
		   			$existencia=0;
		   	}
		   	$tagexistencia= (!$existencia) ? '<span class="tagStock"></span>':'';
	

			
		$cadena.='<div class="col-md-3 col-sm-4 col-xs-6">
	   			<!-- Item -->
	   			<div class="item">
	   				<div class="Promo">
	   				<!-- normal -->
	   				   <div class="ih-item square effect13">
	   				    <a href="'.$enlace.'"><div class="img"><img src="'.$imagen.'" alt="'.$nombre.'"></div></a>
	   				    '.$porcentaje.$tagexistencia.'
	   				   </div>
	   				    <!-- end normal -->
	   				<h3><a href="'.$enlace.'">'.$nombre.'</a></h3>
	   				<span class="tt1">'.$row['empresa'].'</span>
	   				<div class="spc"><span class="esq1a"></span><span class="esq1b"></span></div>
	   				<div class="Prodinfo">
	   				<div class="areaPromo">
	   					<div class="Vence">
	   						<span class="vt1">VENCE:</span>
	   						<span class="vt2">'.$faltan.' DIAS</span>
	   						<!--span class="vt2">08:03:55</span-->
	   					</div>
	   					<div class="currentPrice">
	   						<span class="pt1">OFERTA</span>
	   						<span class="pt2">'.$precio.'</span>
	   						<span class="pt3">'.$precio_old.'</span>
	   					</div>
	   				</div>
	   				</div>
	   				<span class="bgcode"></span>
	   				</div>
	   			</div><!-- end Item -->
	   		</div>
	';
		 }
		  
		  $reg['productos']=$cadena; 
		  $reg['total']= count($productos);
		  echo json_encode($reg);
	 }


    /**
	 * list_productos
	 * llama a la vista de listar los productos
	 */
	public function list_productos(){
	 $reg['tabla'] ='
		<thead>
		  <tr>
			<th>Código</th>
			<th>Producto</th>
			<th>Categoría(s)</th>
			<th>Estado</th>
			<th>Oferta</th>
			<th>Calificacion</th>
			<th>Visitas</th>
			<th>Compras</th>
			<th>Opciones</th>
		  </tr>
		</thead>
		<tbody></tbody>';

	   $this->view->show("admin/list_productos.php", $reg);
	}


     public function json_listProductos(){

	   $producto    = new Productos();
	  
	   $iLenght= $this->input->get('iDisplayLength');
	   $iStart= $this->input->get('iDisplayStart');
	  
	  $iSort= $this->input->get('iSortCol_0');
	  $iSeach=nvl($this->get['buscar']);
	  $boferta=nvl($this->get['oferta']);
	  $iDir=$this->input->get('sSortDir_0');


	  $sortCol='';
	  switch($iSort){
		  case 0:  $sortCol='id_producto';
		 break;
		 case 1:  $sortCol='nombre';
		 break;
		 case 3:  $sortCol='estado';
		 break;
		  case 4:  $sortCol='oferta '.$iDir.', oferta_portal';
		 break;
		  case 5:  $sortCol='calificacion';
		 break;
		 case 6:  $sortCol='visitas';
		 break;
		 case 7:  $sortCol='compras';
		 break;
		 
		
		 
		 }
	  
	  
	   $prod = $producto->listarTodas(nvl($_SESSION['id_empresa'],0),$iStart,$iLenght,$sortCol,$iDir,$iSeach,$boferta);
	$nprod=$producto->numTodas($_SESSION['id_empresa'],$iSeach,$boferta);
	   
	   
	    $output = array(
		"iTotalRecords" => $nprod,
		"iTotalDisplayRecords" => $nprod,
		"aaData" => array());
		
		$aaData= array();
		
		$i=0;
	   foreach($prod as $content){
		$categorias= $producto->listarCategoriasProducto($content['id_producto']);
		$cadcate='';
		foreach($categorias as $nom)
		{
			$cadcate.=$nom['categoria'].', ';
		}
		
		if($cadcate!='')
		$cadcate= substr($cadcate, 0, strlen($cadcate)-2);
		
		$editarOferta='';
		if($content['oferta']=='Activo' or $content['oferta_portal']=='Activo')
		$editarOferta=' <a class="btn btn-mini" id="oferta_'.$content['id_producto'].'" href="producto-edit_oferta-producto-'.$content['id_producto'].'">Editar Oferta</a>';
		
		
		   $oferta=$content['oferta'];
		   $oferta_portal=$content['oferta_portal'];
		   
		   if($oferta=='Activo' and $oferta_portal=='Activo')
		   		$estado_oferta='En Sitio Web y oferto.co';
			elseif($oferta=='Activo' and $oferta_portal=='Inactivo')
				$estado_oferta='solo en Sitio Web';
			elseif($oferta=='Inactivo' and $oferta_portal=='Activo')
				$estado_oferta='solo en oferto.co';
			else
				$estado_oferta='Inactivo';

		  $cpromedio=round($producto->obtenerPromedio($content['id_producto']),2);
		  $ccliente=$producto->numCalificacion($content['id_producto']);
		   
		   $aaData[$i]['DT_RowId'] =$content['id_producto'];
		   $aaData[$i]['id_producto']=$content['id_producto'].'_'.$content['referencia'];
		   $aaData[$i]['nombre']=$content['nombre'];
		   $aaData[$i]['categoria']=$cadcate;
		   $aaData[$i]['estado']=$content['estado'];
			$aaData[$i]['oferta']=$estado_oferta;
		$aaData[$i]['calificacion']=($cpromedio) ? $cpromedio.' <a class="boxComentarios" href="producto-listar_calificaciones-producto-'.$content['id_producto'].'">('.$ccliente.' clientes<img src="'.URLVISTA.'images/comment_small.png" />) </a>':'Sin calificación';
		$aaData[$i]['visitas']=$content['visitas'];
		$aaData[$i]['compras']=$content['compras'];
		$aaData[$i]['opciones']='<a class="btn btn-mini" href="producto-edit_producto-producto-'.$content['id_producto'].'">Editar</a> <a class="btn btn-mini btn-danger" href="javascript:borrar('.$content['id_producto'].')"> Eliminar</a>'.$editarOferta;
		$i++;
	   }
	   $output['aaData'] = $aaData;
        echo json_encode($output);

	 }

	
	 /**
	 * edit_producto
	 * agregar o edit los productos
	 * opcional(id_producto)
	 */
	  public function edit_producto(){

 	    $producto = new productos();
        $categoria	= new Categorias();
	    $adic= new adicionales();
		$opciones= new Opciones();
		$almacen= new Almacenes();
		$keywords=new keywords();


        $reg['id_sesion'] = session_id();

        $reg['token'] = $this->input->post('token') ? $this->input->post('token') : 'tk'.substr(md5(date('hisu').rand(100,9999)), -7);
		
        $galeria = new Galerias($reg['token']);

		$reg['mensaje'] = '';
		$reg['tarea'] = 'Agregar';
		
		$reg['oferta']=nvl($this->get['oferta'],0);

		if(isset($this->get['producto']) && ($this->input->post('dat') == false )){
		    $reg['tarea'] = 'Editar';
			$reg['reg'] = $producto->obtener($this->get['producto']);

		    $reg['id_galeria'] = $reg['reg']['id_galeria'];
            $galeria -> iniciar();
			
			if(nvl($this->get['s'],0))
				$reg['mensaje'] = "Producto guardado";
			
		}

        $galeria -> retomar();
		if( isset($this->get['deladic']) ){
			$adic->borrar($this->get['adic']);						
			redirect("producto-edit_producto-producto-".$this->get['produ']."");
		}
		
		if( isset($this->get['delopt']) ){
			$opcion->borrar($this->get['opt']);						
			redirect("producto-edit_producto-producto-".$this->get['produ']."");
		}	

        if($this->input->post('dat') ){
        	
			if($this->input->post('delimgoferta') and $this->input->post('id')){
				$producto->borrarImagen($this->input->post('id'),'oferta_imagen');	
			} 

			$datos = $this->input->post('dat', false);
			$producto->datos = $this->input->post('dat');
			$producto->datos['detalles']=mysql_real_escape_string($datos['detalles']);

			$producto->datos['existencia_estado']= nvl($producto->datos['existencia_estado'],0);
			if($producto->datos['existencia_estado']==0)
				$producto->datos['existencia']=0;

            $reg['id_galeria'] = $this -> input -> post('id_galeria');
			$galeria->datos['tipo'] = 'Galerias';
			$id = $galeria->guardar( $reg['id_galeria'] );
		    $reg['id_galeria'] = $id;

            $producto->datos['id_galeria'] = $id;
			
			if(is_uploaded_file(nvl($_FILES['archivo_oferta']['tmp_name']))){
			    $producto->subirArchivo('archivo_oferta','oferta_imagen');
			 }
			 
		
			if( $id = $producto->guardar($this->input->post('id'))){
				$datoscat=  $this->input->post('cat');
				 $categoria->guardarCategoriaProducto($datoscat,$id);
				 $datosadi=  $this->input->post('adi');
				 $adic->guardarAdicionalProducto($datosadi,$id);	
				
			/*if($this->input->post('guardar_adic')) {
				
				$datosp=  $this->input->post('adic');
				
				 $guardar_adic= $this->input->post('guardar_adic');
				 $opt_adic= $this->input->post('opt');
				
				foreach($guardar_adic as $p => $valor){
					$adic->datos['dat'] = $datosp[$p];
					if($datosp[$p]['adicional']!=''){
						$adic->datos['dat']['id_producto'] = $id; 
						if($idp= $adic->guardar($valor)){
							$opciones->borrarOpcionesAdicional($valor);
							$opcionesp= $opt_adic[$p];
							$listopciones= explode(',',$opcionesp);
							
							foreach($listopciones as $opt){ 
								$opciones->datos['opcion']= $opt;
								$opciones->datos['id_adicional']= $idp;						  					   
								  $opciones->guardar(0);
							}
							
						}
					}
					
				}	 
			}*/

				if($this->input->post('keywords')!=''){
					$keyw=new keyword();
	        		$cadena=$this->input->post('keywords');
	        		$keyword=explode(',',$cadena);
	        		$keywords->borrarKeywordsProducto($id);
	        		for($i=0;$i<count($keyword); $i++){
	        			$dato= explode('_',$keyword[$i]);
	        			if($dato[0]==0 and $dato[1]!=''){
	        				$id_keyword= $keyw->guardar_keyword($dato[1]);
	        			}
	        			else{
	        				$id_keyword=$dato[0];
	        			}
	        			if($id_keyword)
	        			$keywords->guardarKeywordProducto($id_keyword,$id);
	        		}
	        	}
				 
				redirect("producto-edit_producto-producto-".$id."-s-1");
			}
			else
				$reg['mensaje'] = "Ocurri&oacute; un error al guardar, comunicarse con soporte.";

			$reg['reg'] = $producto->obtener($id);

		}
        else{
            $galeria -> iniciar();
        }

		$reg['dirfileout'] = $producto->dirfileout;
		$reg['categorias'] = $categoria->listarCategoriasProducto(nvl($reg['reg']['id_producto'],0));
		$reg['adicionales_emp'] = $adic->listarAdicionalesProEmpresa(nvl($reg['reg']['id_producto'],0));

		
		if(nvl($reg['reg']['oferta_portal'])=='Activo')
		$reg['almacenes'] = $almacen->listarAlmacenesProducto(nvl($reg['reg']['id_producto'],0));
		
		$reg['keywords']='';
		if(nvl($reg['reg']['id_producto'],0)){
			$listkeywords=$keywords->listarKeywordsProducto($reg['reg']['id_producto']);
			if(count($listkeywords)){
				foreach ($listkeywords as $key) {
					$reg['keywords'].=','.$key['id_keyword'].'_'.$key['keyword'];
				}
			}
		}
		
		//$reg['adicionales'] = $adic->listarAdicionalesPro(nvl($reg['reg']['id_producto'],0));
		$this->view->show("admin/edit_producto.php", $reg);
	  }

 	public function estado(){

     	$prod = new productos();
     	$value=$this->input->post('value');
        $prod->datos['estado'] = $value;

        if($prod->guardar($this->input->post('id_item'))){
        	echo $value; 
        }
        else{
        	echo 'Error';
        }
     }

     public function oferta(){

     	$prod = new productos();
		$borrarOf=0;
		$txtOferta='';
		$estado= $this->input->post('value');
		if($estado=='inactivo'){
			$prod->datos['oferta']='Inactivo';
			$prod->datos['oferta_portal']='Inactivo';
			$borrarOf=1;
			$txtOferta='Inactivo';
		}elseif($estado=='local'){
			$prod->datos['oferta']='Activo';
			$prod->datos['oferta_portal']='Inactivo';
			$borrarOf=1;
			$txtOferta='solo en Sitio Web';
		}elseif($estado=='portal'){
			$prod->datos['oferta']='Inactivo';
			$prod->datos['oferta_portal']='Activo';
			$txtOferta='solo en oferto.co';
		}elseif($estado=='ambos'){
			$prod->datos['oferta']='Activo';
			$prod->datos['oferta_portal']='Activo';
			$txtOferta='En Sitio Web y oferto.co';
		}

		if($borrarOf){
			$prod->datos['oferta_descripcion']='';
			$prod->datos['oferta_imagen']='';
			$prod->datos['oferta_publicacion']='0000-00-00';
			$prod->datos['oferta_vencimiento']='0000-00-00';
			$prod->datos['oferta_precio']=0;
			$prod->datos['oferta_terminos']='';
			$prod->datos['oferta_almacen']='todos';
			$prod->datos['oferta_aprobada']='';
			$almacen=new Almacenes();
			$almacen->borrarAlmacenesProducto($this->input->post('id_item'));
		}
		

        if($prod->guardar($this->input->post('id_item'))){
			echo $txtOferta;
        }
        else{
        	echo 'Error';
        }
     }

     public function oferta_destacado(){
     	$prod = new productos();
     	$id_oferta= $this->input->post('id_item');

     	if($this->input->post('value'))
     	{
     		$value=$this->input->post('value');
     		$prod->datos['oferta_destacado']=$value;
			 if($prod->guardar($id_oferta))
				echo  $value;
			else
				echo "Error";	  	
		  } 
		  else
		  echo "Error valor";		
     }

     public function oferta_aprobada(){
     	$productos= new Productos();
     	$reg['tarea']='editar';
     	if($_SESSION['id_tipo_usuario']==2){
	       if($this->input->post('dat')){
	       	$productos->datos=$this->input->post('dat');
	       	$productos->datos['oferta_aprobada_vista']='0';
	       	 $productos->guardar($this->input->post('id_producto'));
		     $reg['mensaje'] = 'Informacion actualizada';
	       }

	       else if(isset($this->get['id_producto'])){
	       	$reg['dat']=$productos->obtener($this->get['id_producto']);
		   }
		}
		elseif(isset($this->get['id_producto'])){
	       	$reg['dat']=$productos->obtener($this->get['id_producto']);
			$reg['tarea']='ver';
		}
	   $this->view->show('admin/aprobar_oferta.php', $reg);
	}
	 
	 
		
	 /**
	 * borrar
	 *
	 * borra el producto recibe el parametro por post
	 */

	 public function borrar(){

	    $producto = new productos();

		if($producto->borrar($this->input->post('id')) )
			echo "1";
		else
			echo "0";
	 }


     static function listarUltimos($n = 5){

     	$prod = new Productos();

     	return $prod->listarUltimos(0,$n);
     }
	 
	 //*********/
	/**
	 * list_ofertas
	 * llama a la vista de lista de ofertas
	 */
	public function list_ofertas(){
	 $reg['tabla'] ='
		<thead>
		  <tr>
			<th>Código</th>
			<th width="200">Producto</th>
			<th width="200">Oferta</th>
			<th>Fecha<br/>Publicación</th>
			<th>Fecha<br/>Vencimiento</th>
			<th>Precio<br/>de oferta</th>
			<th width="110">Empresa</th>
			<th width="80">Aprobado</th>
			<th width="80">Destacado</th>
			<th>Visitas</th>
			<th>Compras</th>
			<th>Opciones</th>
		  </tr>
		</thead>
		<tbody></tbody>';

		 if(isset($_GET['oferta'])){
		   $reg['buscar']= urldecode($_GET['oferta']);
	   }

	   $this->view->show("admin/list_ofertas.php", $reg);
	}


     public function json_listOfertas(){

	   $producto    = new Productos();
	  
	   $iLenght= $this->input->get('iDisplayLength');
	   $iStart= $this->input->get('iDisplayStart');
	  
	  $iSort= $this->input->get('iSortCol_0');
	  $sortCol='';
	  switch($iSort){
		  case 0:  $sortCol='id_producto';
		 break;
		 case 1:  $sortCol='nombre';
		 break;
		 case 2:  $sortCol='oferta_descripcion';
		 break;
		  case 3:  $sortCol='oferta_publicacion';
		 break;
		  case 4:  $sortCol='oferta_vencimiento';
		 break;
		  case 5:  $sortCol='oferta_precio';
		 break;
		 case 6:  $sortCol='e.nombre';
		 break;
		 case 7:  $sortCol='oferta_aprobada';
		 break;
		 case 8:  $sortCol='oferta_destacado';
		 break;
		  case 9:  $sortCol='visitas_oferto';
		 break;
		  case 10:  $sortCol='compras';
		 break;
	}
		$iSeach=$this->input->get('sSearch');
	 $iDir=$this->input->get('sSortDir_0');
	 
	 
	  $idemp=($_SESSION['id_tipo_usuario']==2) ? 0: $_SESSION['id_empresa'];
	   $prod = $producto->listarOfertas($iStart,$iLenght,$sortCol,$iDir,$iSeach,$idemp,0);
	$nprod=$producto->numOfertas($iSeach,nvl($_SESSION['id_empresa'],0),0);
	   
	    $output = array(
		"iTotalRecords" => $nprod,
		"iTotalDisplayRecords" => $nprod,
		"aaData" => array());
		
		$aaData= array();
		
		$i=0;
	   foreach($prod as $content){ 
	   
	   $editarOferta='';
		if($_SESSION['id_tipo_usuario']==4)
		$editarOferta='<a class="btn btn-mini" id="oferta_'.$content['id_producto'].'" href="producto-edit_oferta-producto-'.$content['id_producto'].'">Editar</a> ';
		$txt_aprobada=($content['oferta_aprobada']!='') ? $content['oferta_aprobada'].'<img src="'.URLVISTA.'images/comment_small.png">' :(($_SESSION['id_tipo_usuario']==2) ? 'Aprobar':'Pendiente');
		$oferta_aprobar='<a class="boxAprobar" href="producto-oferta_aprobada-id_producto-'.$content['id_producto'].'">'.$txt_aprobada.'</a>';
		  
		  if($content['oferta_aprobada']=='')
		  $aaData[$i]['DT_RowClass'] = "gradeAlert"; 

		   $aaData[$i]['DT_RowId'] = $content['id_producto'];
		   $aaData[$i]['id_producto']=$content['id_producto'].'_'.$content['referencia'];
		   $aaData[$i]['nombre']=$content['nombre'];
		   $aaData[$i]['oferta_descripcion']=$content['oferta_descripcion'];
		   $aaData[$i]['oferta_publicacion']=db2fecha($content['oferta_publicacion']);
		   $aaData[$i]['oferta_vencimiento']=db2fecha($content['oferta_vencimiento']);
		   $aaData[$i]['oferta_precio']=vn($content['oferta_precio']);
		   $aaData[$i]['empresa']=$content['empresa'];
		   $aaData[$i]['oferta_aprobada']=$oferta_aprobar;
		   $aaData[$i]['oferta_destacado']=($content['oferta_destacado']!='Si') ? 'No' :'Si';
		   $aaData[$i]['visitas']=$content['visitas_oferto'];
		   $aaData[$i]['compras']=$content['compras'];
		   $aaData[$i]['opciones']=$editarOferta.'<a class="btn btn-mini espreview" href="producto-preview_oferta-id-'.$content['id_producto'].'" rel="tooltip" data-original-title="Previsualizar" title=""><i class="icon-eye-open"></i></a> <a class="btn btn-mini btn-danger" href="javascript:borrar('.$content['id_producto'].')">Eliminar</a>';
		$i++;
	   }
	   $output['aaData'] = $aaData;
        echo json_encode($output);

	 }
	 
	 /*
	 * Desactiva la oferta para oferto.co
	 * Solicitud desde ajax
	 */
	   public function borrar_oferta(){

     	$prod = new productos();
		$borrarOf=1;
		$id= $this->input->post('id');
		$producto=$prod->obtener($id);
		$prod->datos= array();
		
		$prod->datos['oferta_descripcion']='';
		$prod->datos['oferta_imagen']='';
		$prod->datos['oferta_publicacion']='0000-00-00';
		$prod->datos['oferta_vencimiento']='0000-00-00';
		$prod->datos['oferta_precio']=0;
		$prod->datos['oferta_terminos']='';
		$prod->datos['oferta_almacen']='todos';
		$prod->datos['oferta_destacado']='No';
		$prod->datos['oferta_aprobada']='';
		
		$prod->datos['oferta_portal']='Inactivo';
		$prod->datos['oferta']='Inactivo';
		
		if($prod->guardar($id)){
			$almacen=new Almacenes();
			$almacen->borrarAlmacenesProducto($this->input->post('id'));
			echo "1";
		}
		else
			echo "0";
     }
	 
	 /**
	 * edit_oferta
	 * edit los ofertas agregadas en el portal
	 * @return 	void.
	 */
	  public function edit_oferta(){

 	    $producto = new productos();
		$almacen= new Almacenes();

		$reg['mensaje'] = '';
		$reg['tarea'] = 'Agregar';

		if(isset($this->get['producto']) && ($this->input->post('dat') == false )){

		    $reg['tarea'] = 'Editar';
			$reg['reg'] = $producto->obtener($this->get['producto']);

			if(nvl($this->get['s'],0))
				$reg['mensaje'] = "Oferta guardada";
		}

        if($this->input->post('dat') ){
        	$datosofe=$this->input->post('dat');
        	if($datosofe['oferta_precio']!='' and $datosofe['oferta_precio']!=0 and $datosofe['oferta_precio']<=$this->input->post('precio')){
	        	$datosofe=$this->input->post('dat');

	        	
				if($this->input->post('delimgoferta') and $this->input->post('id')){
					$producto->borrarImagen($this->input->post('id'),'oferta_imagen');	
				} 

				$producto->datos = $this->input->post('dat');
			
				$producto->datos['oferta_vencimiento']=fecha2db($this->input->post('oferta_vencimiento'));
				$producto->datos['oferta_publicacion']=fecha2db($this->input->post('oferta_publicacion'));
				
				if(is_uploaded_file(nvl($_FILES['archivo_oferta']['tmp_name']))){
				    $producto->subirArchivo('archivo_oferta','oferta_imagen');
				 }
				 
				  $datosalm=  $this->input->post('alm');
				 if(nvl($producto->datos['oferta_almacen'])!='todos'){
				 	$producto->datos['oferta_almacen']='seleccionados';  
				 }else{
					 $datosalm=$almacen->listarAlmacenesID();
				 }

				 $producto->datos['oferta_existencia_estado']= nvl($producto->datos['oferta_existencia_estado'],0);
				if($producto->datos['oferta_existencia_estado']==0)
					$producto->datos['oferta_existencia']=0;

				 
				if( $id = $producto->guardar($this->input->post('id'))){
					/* if($this->input->post('nuevo')==1){
					 	correo::enviarOfertaSeguidores($id);
					 	$this->enviar_seguidoresapp($id);
					 }*/
					 	
					 $almacen->guardarAlmacenProducto($datosalm,$id);
				 	
					redirect("producto-edit_oferta-producto-".$id."-s-1");
				}
				else
					$reg['mensaje'] = "Ocurri&oacute; un error al guardar, comunicarse con soporte.";
					$reg['mensaje_tipo']  = 'error';	
			}
			else{
				$reg['mensaje'] = "El valor del precio de la oferta no es válido";
				$reg['mensaje_tipo']  = 'error';	
			}
			$reg['reg'] = $producto->obtener($this->input->post('id'));
		}
        
		$reg['dirfileout'] = $producto->dirfileout;
		$reg['almacenes'] = $almacen->listarAlmacenesProducto(nvl($reg['reg']['id_producto'],0));

		if(nvl($reg['reg']['oferta_vencimiento'],0))
			$reg['reg']['oferta_vencimiento']=db2fecha($reg['reg']['oferta_vencimiento']);

		if(nvl($reg['reg']['oferta_publicacion'],0))
			$reg['reg']['oferta_publicacion']=db2fecha($reg['reg']['oferta_publicacion']);

		$reg['dias_oferta']=configsite::get_tipo('max_dias_oferta');
		if($reg['dias_oferta']=='')
			$reg['dias_oferta']=0;

		$this->view->show("admin/edit_oferta.php", $reg);
	  }
	  //En oferto.co
	  public function mas_vendidos(){
		  $producto= new Productos();
		  $productos= $producto->obtenerMasComprados(10);
		$cadena='';
		foreach($productos as $row){
			$cadena.='<li><div class="num" id="nempresas">'.$row['compras'].'</div><span class="task"><span>'.$row['nombre'].' ('.$row['empresa'].')</span></span></li>';
		}
		echo $cadena;
	  }

	  static function mas_visitados(){
		  $producto= new Productos();
		  $productos= $producto->obtenerMasVisitadosTotal(10);
		$cadena='';
		foreach($productos as $row){
			$cadena.='<li><div class="num" id="nempresas">'.$row['vtotal'].'</div><span class="task"><span>'.$row['nombre'].' ('.$row['empresa'].')</span></span></li>';
		}
		echo $cadena;
	  }
	
	  
	  static function mascomprados(){
		$producto= new Productos();
		return $producto->obtenerMasComprados(0,$_SESSION['id_empresa']);
		$reg['masvistos']=$producto->obtenerMasVisitados();
	}
	
	static function masvisitados(){
		$producto= new Productos();
		return $producto->obtenerMasVisitados();
	}
	
	
	/*  Carrito de compras*/
	    public function carrito(){
		$producto = new Productos();
		$carrito = new Carrito(); 
		   
		if($this->input->post('dat') != false){
			$datos = $this->input->post('dat');
			
			$info = $producto->obtener($datos['id_producto']);

			//validad cantidad en carrito
			//
		    $imagen =($info['archivo']!='') ? URLFILES."galerias/m".$info['archivo']:URLFILES.'producto.png';
			
			$precio = $info['precio'];
			
			if($info['oferta']=='Activo'){
				$imagen =($info['oferta_imagen']!='') ? $producto->dirfileout.'m'.$info['oferta_imagen']:$imagen;
				$precio=  ($info['oferta_precio']) ? $info['oferta_precio']:$info['precio'];
			}
			
			$identificador= $datos['id_producto'];
			
			$cantidad = (int)$datos['cantidad'];
			$cantidad = ((is_integer($cantidad)) ? $cantidad : 1);

			$valido=$this->validar_cantidad_carrito($datos['id_producto'],$cantidad);
			
			$list_opt = $this->input->post('opcion');
			$referencia='';
			$ref='';
			if(nvl($list_opt)!=''){
				for($i=0;$i< count($list_opt);$i++){
					$info_opt= explode('_',$list_opt[$i]);
					$ref.=$info_opt[0];
					$referencia.=', '.$info_opt[1];
				}
			}
			
			$identificador= $datos['id_producto'].$ref;
			
			if($valido==1){
				$carrito->addProducto($datos['nombre'], $datos['id_producto'],$identificador,$precio, $cantidad, $imagen,$referencia);
				
				$mensaje= $datos['nombre']." fue agregado al carrito de compras";
			}else
				$mensaje="Error al agregar al carrito, la cantidad solicitada no está disponible";
		
			$cadena=$this->tabla_carrito($mensaje);
				
		 	
		 }
		 else{
		 	$reg['dirfileout'] = $producto->dirfileout;
		 	if(isset($this->get['msj'])){
		 		if($this->get['msj']=='1'){
		 			$reg['mensaje']="Item Actualizado";
		 		}else if($this->get['msj']=='0'){
		 			$reg['mensaje']="Error al Actualizar";
		 		}
		 		 else if($this->get['msj']==2 || $this->get['msj']==3){
		 		 	$reg['mensaje']="La cantidad solicitada no está disponible";
				}
		 	}
		 		
		 	$this->view->show('skin/'.SKIN.'/carrito.php',$reg);
	
		 }
	}
	
	/* actualizar carrito de compras
	 * Validar cantidad disponible
 	 */
	public function actualizar(){
		$carrito = new Carrito();
		
		$id_producto=$this->input->post('idprod');
		$productos= new Productos();
		$producto= $productos->obtener($id_producto);

		$valida=1;
		
		if($this->input->post('actualizar') ){	
			$cantidad = $this->input->post('cantidad');
			$cantidad = (int)$cantidad;
			$cantidad = ((is_integer($cantidad))? $cantidad : 1);

			$esoferta=($producto['oferta']=='Activo' and ($producto['oferta_publicacion']<=date("Y-m-d")) and ($producto['oferta_vencimiento']>date("Y-m-d")) )? 1:0;
			if($esoferta and $producto['oferta_existencia_estado']=='1'){
				$tcantidad=0;
		        for($p =0; $p<$carrito->nf; $p++){
		        	if($carrito->carro['estado'][$p] and ($p!=$this->input->post('id')) and ($carrito->carro['producto'][$p]==$id_producto)){
		        		if(($tcantidad+$carrito->carro['cantidad'][$p])>$producto['oferta_existencia']){
		        			$carrito->updateProducto( $p, 0, 0 );
		        			$valida=-1;
		        		}else
		        		$tcantidad += $carrito->carro['cantidad'][$p];	
					}
				}
				
				if(($tcantidad+$cantidad)>$producto['oferta_existencia'])
					$valida=0;
			}
			else if($producto['existencia_estado']=='1'){
				$tcantidad=0;
				
		        for($p =0; $p<$carrito->nf; $p++){
		        	if($carrito->carro['estado'][$p] and ($p!=$this->input->post('id')) and ($carrito->carro['producto'][$p]==$id_producto)){
		        		if(($tcantidad+$carrito->carro['cantidad'][$p])>$producto['existencia']){
		        			$carrito->updateProducto( $p, 0, 0 );
		        			$valida=-1;
		        		}else
		        		$tcantidad += $carrito->carro['cantidad'][$p];
					}
				}
				
				if(($tcantidad+$cantidad)>$producto['existencia'])
					$valida=0;
			}

     		if($valida>0){
     			$carrito->updateProducto($this->input->post('id'), $cantidad);
     			echo 1;
     		}
     		else if($valida==0){
     			if($esoferta and $producto['oferta_existencia_estado']=='1'){
     				$ncantidad= $producto['oferta_existencia']-$tcantidad;
     				$carrito->updateProducto($this->input->post('id'), $ncantidad);
     			}else{
     				$ncantidad= $producto['existencia']-$tcantidad;
     				$carrito->updateProducto($this->input->post('id'), $ncantidad);
     			}
     			
     			echo 2;
     		}	
     		elseif($valida==-1){
     			echo 3;
     		}
		 }else 
		    echo 0;
	}

	public function borrar_carrito(){
		 $cart = new Carrito();
		 $cart->updateProducto( $this->input->post('id'), 0, 0 );
		 echo 1;
		
	 }
	
	public function tabla_carrito($mensaje=''){
		
		$cantidad=0;
		$cadena='';
		 $ids= array();
		$carrito = new Carrito();   
	    if($carrito->numProductos() > 0){
           $total = 0;
		  $cantidad = 0;
		  
		 $cadena='';
		 $p =$carrito->nf;
		 $i=0;
		
             for($p; $p>=0; $p--)
                if(nvl($carrito->carro['estado'][$p])){ 
				$i++;
				  $cantidad += $carrito->carro['cantidad'][$p];
				  
				  $preciot = $carrito->carro['precio'][$p]*$carrito->carro['cantidad'][$p];
				  $total += $preciot;
				
				  
				  $imagen_c= $carrito->carro['imagen'][$p];
			$titulo_c= $carrito->carro['nombre'][$p].$carrito->carro['referencia'][$p];
			$enlace_c='main-producto-id-'.$carrito->carro['producto'][$p].'-t-'.chstr($titulo_c);
			$precio_c=($carrito->carro['precio'][$p]) ? vn($carrito->carro['precio'][$p]):'';
			
			
			if($i<=5){
				  $cadena.='<li class="item clearfix" id="fila'.$carrito->carro['producto'][$p].'">
 <a href="'.$enlace_c.'" title="'.$titulo_c.'" class="product-image"><img src="'.$imagen_c.'" data-srcX2="'.$imagen_c.'" width="50" height="50" alt="'.$titulo_c.'" /><span></span></a>
 <div class="product-details">
 <a href="javascript:eliminar_fila(\''.$p.'\')" title="Eliminar Item" class="btn-remove">Eliminar</a>
 <p class="product-name"><a href="'.$enlace_c.'">'.$titulo_c.'</a></p>
 <strong>'.$carrito->carro['cantidad'][$p].' *</strong>
 <span class="price">'.$precio_c.'</span></div></li>';
			}
			  }
	  }else{
		 $cadena=' 
  <li><div class="cm1"><span class="cct">------------ <b>-----------</b></span></div> <div class="cm2"><span class="cct">$ 0.00</span></div>
  </li>';
	 }
	 
	 
	 if($cantidad){
		$pago=(nvl($_SESSION['id_tipo_usuario'],0) == 5) ? 'producto-checkout':'main-registro-comprar-1';
	 }
	else
		$pago='javascript:void(0)';
	 
		
		 $cadena='<div class="cart-top-container"><div class="cart-top"><a class="summary" href="producto-carrito"><span>CARRITO ('.$cantidad.')</span></a></div>
<div class="details">
<div class="details-border"></div>
<p class="block-subtitle text-recently">'.PRODUCTOS_TXT.' recién agregado(s)</p>
 <ol id="cart-sidebar" class="mini-products-list">'.$cadena;
  
	 $cadena.=' </ol>
  <div class="subtotal-wrapper">
  <div class="subtotal">
  <span class="label">Total:</span> <span class="price">'.vn($total).'</span>
   </div>
   </div>
   <div class="buttons clearfix">
   <button type="button" title="Ver carrito" class="button btn-continue" onclick="setLocation(\'producto-carrito\')"><span><span>Ver Carrito</span></span></button>
   <button type="button" title="Finalizar compra" class="button btn-checkout" onclick="setLocation(\''.$pago.'\')"><span><span>Finalizar compra</span></span></button>
   </div>
    </div></div>';
	 	
		 $respuesta = array (
		  'status'=>"SUCCESS",
		  'message'=>$mensaje,
			'cart_top'=>$cadena);
			echo json_encode($respuesta);		
	}

	public function checkout(){
		$us = new Usuarios();
		$ped = new Pedidos(); 
		
		$reg['mensaje']='';
		
		if(nvl($_SESSION['id_tipo_usuario'],0)==5){
			$dusuario=$us->obtener($_SESSION['id_usuario']);
			
			$_SESSION['d_pedido']['id_usuario'] = $_SESSION['id_usuario'];
			$_SESSION['d_pedido']['fecha'] = date('Y-m-d');
			$_SESSION['d_pedido']['nombre_pedido'] = $dusuario['nombre'];
			$_SESSION['d_pedido']['telefono_pedido'] = $dusuario['telefono'];
			$_SESSION['d_pedido']['movil_pedido'] = nvl($dusuario['movil']);
			$_SESSION['d_pedido']['direccion_pedido'] = $dusuario['direccion'];
			$_SESSION['d_pedido']['pais_pedido'] = $dusuario['id_pais'];
			$_SESSION['d_pedido']['departamento_pedido'] = $dusuario['id_dpto'];
			$_SESSION['d_pedido']['ciudad_pedido'] = $dusuario['id_ciudad'];
			$_SESSION['d_pedido']['email_pedido'] = $dusuario['_username'];
			
			$reg['dpedido']=$_SESSION['d_pedido'];
			
		}
		elseif(nvl($_SESSION['d_pedido']['email_pedido'])!='')
			$reg['dpedido']=$_SESSION['d_pedido'];
		
		if(defined('SKIN') and isset($_SESSION['id_empresa'])){
			$conf= new empresas();
			$reg['emp']= $conf->obtener($_SESSION['id_empresa']);

			if(isset($reg['dpedido']) and nvl($_SESSION['nf'],0)){
				$con = new Contenidos();
				$reg['con'] = $con->obtenerEmpresa($_SESSION['id_empresa'],3);	
				$this->view->show('skin/'.SKIN.'/checkout.php', $reg);
			}
			elseif(nvl($_SESSION['nf'],0))
				redirect('main-registro-comprar-1');
			else
				redirect('main-productos');
		}
		else{
			$gal=new Galerias();
			$productos= new Productos();
			$empresas= new Empresas();
			$opciones= new Opciones();
			$compra=0;
			if(nvl($this->get['comprar'],0)){
				$compra=$this->get['comprar'];
				$cantidad=nvl($this->get['c'],1);
				$_SESSION['compra']= $compra.'-c-'.$cantidad;
			}elseif(nvl($_SESSION['compra'],0)){
				$scompra= explode('-', $_SESSION['compra']);
				$compra= $scompra[0];
				$cantidad= nvl($scompra['2'],1);
			}
			
			if($compra){
				$idcompra= explode('_', $compra);
				$reg['producto']= $productos->obtener($idcompra[0]);

			$valido=1;

			if($reg['producto']['oferta_existencia_estado']=='1'){
	          if($cantidad>$reg['producto']['oferta_existencia'])
	          	$valido=0;
	        }
	        elseif($reg['producto']['existencia_estado']=='1' and $cantidad>$reg['producto']['existencia'])
				$valido=0;

			if($valido==0)
				redirect('main-producto-id-'.$reg['producto']['id_producto']);
	

				$reg['cantidad']= $cantidad;
				$reg['total']= $cantidad*$reg['producto']['oferta_precio'];

				$reg['cadicionales']='';
				$reg['adicionales']='';
				for($i=1;$i<sizeof($idcompra); $i++){
					$opcion=$opciones->obtener($idcompra[$i]);
					if($opcion['id_adicional_opcion']){
						$reg['cadicionales'].='<span class="opt"><strong>'.$opcion['adicional'].':</strong> '.$opcion['opcion'].'</span>';
						$reg['adicionales'].=', '.$opcion['adicional'].': '.$opcion['opcion'];
					}

				}
				$reg['compra']=$_SESSION['compra'];
				$reg['emp']= $empresas->obtener($reg['producto']['id_empresa']);
				$con = new Contenidos();
				$reg['con'] = $con->obtenerEmpresa($reg['producto']['id_empresa'],3);
				$reg['dominio']= $empresas->getDominio($reg['producto']['id_empresa']);	
			

				$reg['dirfileout'] = $gal->dirfileout;
				$reg['dirfileo'] = $productos->dirfileout;
				$reg['populares']=$productos->obtenerOfertasMasCompradas(20);
				$mañana=date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
				$reg['vencen']=$productos->obtenerOfertasVencen($mañana);

				$this->view->show('checkout.php', $reg);
			}
			else
				redirect('main-productos');
		}

	}
	
	static function tiene_adicionales($id_producto){
			$adic= new Adicionales();	
			return $adic->numAdicionalesPro($id_producto);
	}
		
	static function imp_adicionales($id_producto,$tt=''){
		$adic= new Adicionales();
		$opcion= new Opciones();

		$adicionales= $adic->listarAdicionalesPro($id_producto);
	
		$p=0;
		$cadena='';
		  foreach ($adicionales as $adicional){ 
		  
			  $cadena.='<span class="ilab">'.$adicional['adicional'].'</span><select class="dropdown" name="opcion['.$p.']" id="ad_'.$tt.$id_producto.'_'.$p.'" ><option value="">Escoja una opción</option>';
			  if($opciones=  $opcion->listar($adicional['id_adicional'])){		
				foreach($opciones as $opt){ 
					$cadena.='<option id="opt_'.$p.'_'.$opt['id_adicional_opcion'].'" value="'.$adicional['id_adicional'].'.'.$opt['id_adicional_opcion'].'_'.$adicional['adicional'].': '.$opt['opcion'].'">'.$opt['opcion'].'</option>';
				 }
				}
				$cadena.='</select> ';
				$p++;
			}
					  
		return $cadena;
	}

	static function calificacion($usuario,$producto){
		$productos= new Productos();
		return $productos->obtenerCalificacion($usuario,$producto);

	}

	static function promedio($producto){
		$productos= new Productos();
		$reg['promedio']=$productos->obtenerPromedio($producto);
		$reg['numero']= $productos->numCalificacion($producto);
		return $reg;
	}

	public function listar_calificaciones(){
		$productos= new productos();
		
		if(nvl($this->get['producto'],0)){
			$reg['producto']=$productos->obtener($this->get['producto']);
			$reg['calificaciones']=$productos->listarCalificaciones($this->get['producto']);
			
			$this->view->show('lista_calificaciones.php',$reg);
		}
		
	}

	/**
	 *
	 * guarda el rating dado desde la vista.
	 */
	public function rating(){
		$productos= new productos();
		if(nvl($this->get['comentar'],0)){
			$reg['calificacion']=$productos->obtenerCalificacionId($this->get['comentar']);
			

			if($this->input->post('comentario')){
				if($productos->guardarComentarioCalificacion($this->input->post('id_calificacion'),$this->input->post('comentario')))
					$reg['mensaje']='Comentario guardado con éxtito';
				else
					$reg['mensaje']='Hubo un error procesando su solicitud. Por favor inténtelo más tarde';

				

			}
			$this->view->show('comentar_calificacion.php',$reg);
		}
		else{
			$aResponse['error'] = false;	
			$aResponse['nuevo'] = 0;
			$aResponse['id'] =0;


			if(isset($_POST['action'])){
				if(htmlentities($_POST['action'], ENT_QUOTES, 'UTF-8') == 'rating'){
					$id_producto = intval($_POST['idBox']);
					$calificacion=  floatval($_POST['rate']);
					if($calif=producto::calificacion($_SESSION['id_usuario'],$id_producto))
						$aResponse['nuevo'] = 0;
					else
						$aResponse['nuevo'] = 1;

					if($id_calificacion=$productos->guardarCalificacion($_SESSION['id_usuario'],$id_producto,$calificacion)){		
						$success = true;
						$aResponse['error'] = false;
						$aResponse['id'] = $id_calificacion;	
						$aResponse['id_producto'] = $id_producto;	

					}
					else{
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
	}

	public function exportar_ofertas(){
		$html = '<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<thead>
		<tr bgcolor="#CCCCCC">
		<th>Producto</th>
		<th>Oferta</th>
		<th>Fecha Publicación</th>
		<th>Fecha Vencimiento</th>
		<th># dias en oferta</th>
		<th>Precio Oferta</th>
		<th>% Descuento</th>
		<th>Empresa</th>
		<th>Destacado</th>
		<th>Visitas</th>
		<th>Compras</th>
		<th>Estado Aprobación</th>
		<th>Ubicación</th>
		</tr>
		</thead>
		<tbody>';

		$producto    = new Productos();
		$empresas= new Empresas();
		$result = $producto->listarOfertas(0,0,'compras desc, visitas_oferto','desc','',0);

		foreach($result as $row){
			$destacado=($row['oferta_destacado']!='Si') ? 'No' :'Si';
			$aprobacda_comentario=($row['oferta_aprobada']!='') ? (($row['oferta_aprobada_comentario']!='') ? '. '.$row['oferta_aprobada_comentario'] :''):'';

			$datetime1 = new DateTime($row['oferta_publicacion']);
			$datetime2 = new DateTime($row['oferta_vencimiento']);
			$interval = $datetime1->diff($datetime2);
			$diasdiff=$interval->format('%r%a días');

			$empresa=$empresas->obtenerCompleto($row['id_empresa']);

			$html.='<tr>
			<th>'.$row['nombre'].'</th>
			<th>'.$row['oferta_descripcion'].'</th>
			<th>'.$row['oferta_publicacion'].'</th>
			<th>'.$row['oferta_vencimiento'].'</th>
			<th>'.$diasdiff.'</th>
			<th>'.vn($row['oferta_precio']).'</th>
			<th>'.$row['porcentaje'].'</th>
			<th>'.$row['empresa'].'</th>
			<th>'.$destacado.'</th>
			<th>'.$row['visitas_oferto'].'</th>
			<th>'.$row['compras'].'</th>
			<th>'.$row['oferta_aprobada'].$aprobacda_comentario.'</th>
			<th>'.$empresa['ciudad'].', '.$empresa['dpto'].'</th>
			</tr>';
		}
		$html.='</tbody></table>';
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=ofertas_activas_".date("Y-m-d").".xls");
		echo $html;
	}

	public function exportar(){
		$orden=nvl($this->get['orden'],'id_producto');
		$html = '<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<thead>
		<tr bgcolor="#CCCCCC">
		<th>Producto</th>
		<th>Categoría(s)</th>
		<th>Empresa</th>
		<th>Estado</th>
		<th>Oferta</th>
		<th>Calificación</th>
		<th>Compras</th>
		<th>Visitas Totales</th>
		<th>Visitas Sitio Web</th>
		<th>Visitas Oferto.co</th>
		</tr>
		</thead>
		<tbody>';

	  	$producto    = new Productos();
	    $result = $producto->listarTodas(0,0,0,$orden,'desc','','');
	   
	  	foreach($result as $row){
	  		$calificacion=($row['calificacion']) ? $row['calificacion']:'Sin calificación';
	  		$categorias= $producto->listarCategoriasProducto($row['id_producto']);
			$cadcate='';
			foreach($categorias as $nom){
				$cadcate.=$nom['categoria'].', ';
			}
			
			if($cadcate!='')
			$cadcate= substr($cadcate, 0, strlen($cadcate)-2);
		
		   $oferta=$row['oferta'];
		   $oferta_portal=$row['oferta_portal'];
		   
		   if($oferta=='Activo' and $oferta_portal=='Activo')
		   		$estado_oferta='En Sitio Web y oferto.co';
			elseif($oferta=='Activo' and $oferta_portal=='Inactivo')
				$estado_oferta='solo en Sitio Web';
			elseif($oferta=='Inactivo' and $oferta_portal=='Activo')
				$estado_oferta='solo en oferto.co';
			else
				$estado_oferta='Inactivo';

			$html.='<tr>
			<th>'.$row['nombre'].'</th>
			<th>'.$cadcate.'</th>
			<th>'.$row['empresa'].'</th>
			<th>'.$row['estado'].'</th>
			<th>'.$estado_oferta.'</th>
			<th>'.$calificacion.'</th>
			<th>'.$row['compras'].'</th>
			<th>'.$row['vtotal'].'</th>
			<th>'.$row['visitas'].'</th>
			<th>'.$row['visitas_oferto'].'</th>
			</tr>';
	  	}

	  	$html.='</tbody></table>';
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=productos_".date("Y-m-d").".xls");
		echo $html;
	}

	private function enviar_seguidoresapp($id_producto){
		$productos=new productos();
		$empresas= new Empresas();
		$notificacion= new notificaciones();
		$push = new Push();
		$row= $productos->obtener($id_producto);
		$empresa= $empresas->obtener($row['id_empresa']);
		$row['empresa']= $empresa['nombre'];
        
        $nombre= ($row['oferta_descripcion']!='') ? $row['oferta_descripcion'] : $row['nombre'];
        $titulo=$row['nombre'];
        $mensaje='Nueva oferta de '.$row['empresa'].' en OFERTO.CO';

        $listadoToken = $notificacion->listarSiguiendoEmpresa($row['id_empresa'],1);
     
		$listadoRegid = $notificacion->listarSiguiendoEmpresa($row['id_empresa'],0,1);
			
			$ids=array();
			foreach ($listadoRegid as $rid) {
				$ids[]=$rid['regid'];
			}

			/*$tids=array();
			foreach ($listadoToken as $tid) {
				$tids[]=$tid['token'];
			}*/
			$tids=$listadoToken;
			
			if(count($ids))
				$gcm=$push->gcm($titulo,$mensaje,$ids,'ver_producto',$id_producto);
			else
				$gcm['error']='No se encontraron dispositivos';

			if(count($tids))
				$apns=$push->apns($titulo,$mensaje,$tids,'ver_producto',$id_producto);
			else
				$apns['error']='No se encontraron dispositivos';


			if(nvl($gcm['error'])!='' and nvl($apns['error'])!=''){
				$estado= 'Fallido';
			}
			else{
				$estado= 'Enviado';
			}

        return $estado;
	}


	/*
	 * Validar la cantidad disponible en la oferta al agregar al carrito
	 */
	public function validar_cantidad($id_producto=0,$cantidad=0){
		$productos= new Productos();
		if($this->input->post('id_producto'))
		$id_producto= $this->input->post('id_producto');
	if($this->input->post('cantidad'))
		$cantidad= $this->input->post('cantidad');

		$dprod= $productos->obtener($id_producto);
		$esoferta=($dprod['oferta']=='Activo' and ($dprod['oferta_publicacion']<=date("Y-m-d")) and ($dprod['oferta_vencimiento']>date("Y-m-d")) )? 1:0;

		if($esoferta and $dprod['oferta_existencia_estado']=='1'){
          if($cantidad>$dprod['oferta_existencia'])
          	echo 'false';
          else
          	echo 'true';

        }
        elseif($dprod['existencia_estado']=='1' and $cantidad>$dprod['existencia'])
			echo 'false';
		else
			echo 'true';
	}

	public function validar_cantidad_carrito($id_producto,$cantidad){
		$carrito = new Carrito();
		$productos= new Productos();
		$producto= $productos->obtener($id_producto);
		$valida=1;
	
		$esoferta=($producto['oferta']=='Activo' and ($producto['oferta_publicacion']<=date("Y-m-d")) and ($producto['oferta_vencimiento']>date("Y-m-d")) )? 1:0;

		if($esoferta and $producto['oferta_existencia_estado']=='1'){
			$tcantidad=0;
	        for($p =0; $p<$carrito->nf; $p++){
	        	if($carrito->carro['estado'][$p] and ($carrito->carro['producto'][$p]==$id_producto)){
	        		if(($tcantidad+$carrito->carro['cantidad'][$p])>$producto['oferta_existencia']){
	        			$carrito->updateProducto( $p, 0, 0 );
	        			$valida=-1;
	        		}else
	        		$tcantidad += $carrito->carro['cantidad'][$p];
				}
			}
			if(($tcantidad+$cantidad)>$producto['oferta_existencia'])
				$valida=0;
        }
        elseif($producto['existencia_estado']=='1'){
			$tcantidad=0;
	        for($p =0; $p<$carrito->nf; $p++){
	        	if($carrito->carro['estado'][$p] and ($carrito->carro['producto'][$p]==$id_producto)){
	        		if(($tcantidad+$carrito->carro['cantidad'][$p])>$producto['existencia']){
	        			$carrito->updateProducto( $p, 0, 0 );
	        			$valida=-1;
	        		}else
	        		$tcantidad += $carrito->carro['cantidad'][$p];
				}
			}
			if(($tcantidad+$cantidad)>$producto['existencia'])
				$valida=0;
		}

 		if($valida>0){ //cantidad valida
 			return 1;
 		}
 		else if($valida==0){ //la nueva cantidad sobrepasa
 			return 2;
 		}	
 		elseif($valida==-1){ //La cantidad existente ya estaba sobrepasada
 			return 3;
 		}
	}

	static function ofertas_pendientes($cantidad=0){
		$productos= new Productos();
		$lproductos= $productos->listarOfertasPendientes();
		$nproductos=count($lproductos);
		$cadena='';
		$more='';

		$i=0;
		foreach($lproductos as $row){
			$cadena.='<li><a href="producto-list_ofertas?oferta='.urlencode($row['id_producto'].'_'.$row['referencia']).'"><div class="details">
										<div class="name">'.$row['nombre'].'</div>
										<div class="message">
											'.$row['oferta_publicacion'].'. Empresa: '.$row['empresa'].'
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

		$cadena.='<li><a href="producto-list_ofertas" class="more-messages">'.$more.'Ver todas las Ofertas <i class="icon-arrow-right"></i></a></li>';

		$reg['cantidad']=$nproductos;
		$reg['lista']=$cadena;
		return $reg;
	}

	public function lista_oferta_comentarios(){
	 $producto  = new productos();

	 $listado = $producto->listarOfertaComentarios($_SESSION['id_empresa']);

     $reg['tabla'] ='
	  <thead>
		<tr>
		  <th>Id</th>
		  <th>>Producto</th>
		  <th>Estado</th>
		  <th>Comentario</th>
		</tr>
	  </thead>';

	 $reg['tabla'] .='<tbody>';

	 foreach($listado as $row){
	 
	 $estado=($row['oferta_aprobada']=='Si') ? 'La oferta fue Aprobada':(($row['oferta_aprobada']=='No') ? 'La oferta NO fue aprobada':'');
	 	$reg['tabla'] .='<tr  id="row_'.$row['id_producto'].'">
              <td>'.$row['id_producto'].'</td>
              <td>'.$row['nombre'].'</td>
              <td>'.$estado.'</td>         
              <td>'.$row['oferta_aprobada_comentario'].'</td>
            </tr>';
	 }
	 $reg['tabla'] .='</tbody>';

	 $this->view->show("admin/lista_oferta_comentarios.php", $reg);

	}


	static function ofertas_comentarios_pendientes($cantidad=0){
		$productos= new Productos();
		$lproductos= $productos->listarOfertaComentarios($_SESSION['id_empresa'],0);
		$nproductos=count($lproductos);
		$cadena='';
		$more='';

		$i=0;
		foreach($lproductos as $row){
			$estado=($row['oferta_aprobada']=='Si') ? 'La oferta fue Aprobada':(($row['oferta_aprobada']=='No') ? 'La oferta NO fue aprobada':'');

			$cadena.='<li><a href="producto-lista_oferta_comentarios?oferta='.$row['id_producto'].'"><div class="details">
										<div class="name">'.$row['nombre'].'</div>
										<div class="message">
											'.$estado.'
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

		$cadena.='<li><a href="producto-lista_oferta_comentarios" class="more-messages">'.$more.'Ver todas las alertas <i class="icon-arrow-right"></i></a></li>';

		$reg['cantidad']=$nproductos;
		$reg['lista']=$cadena;
		return $reg;
	}

	public function actualizar_comentarios_pendientes(){
		$productos= new Productos();
		if($productos->estadoOfertaComentariosVista($_SESSION['id_empresa'],1))
			exit('1');
		else
			exit('0');
	}

	public function preview_oferta(){
		$producto = new Productos();
		$cat = new Categorias();
		$gal = new Galerias();
		$empresas= new Empresas();
		$adic= new adicionales();

		$reg['txt_comprar']='RESERVAR';
		$reg['diremp'] = $empresas->dirfileout;
		$reg['producto'] = $producto->obtener($this->get['id']);
		$reg['empresa']=$empresas->obtener($reg['producto']['id_empresa']);
		$reg['empresa']['dominio']=$empresas->getDominio($reg['producto']['id_empresa']);

		if($reg['empresa']['pago_payu']=='1' and $reg['empresa']['payu_userid']!='' and $reg['empresa']['payu_llave']!='' and $reg['empresa']['payu_accountid']!='')
			$reg['txt_comprar']='COMPRAR';



		$reg['galeria'] = $gal->obtenerGaleriaFull($reg['producto']['id_galeria']);

		$reg['dirfileout'] = $gal->dirfileout;

		$reg['dirfileo'] = $producto->dirfileout;

		$reg['titulo']=($reg['producto']['oferta_descripcion']!='') ? $reg['producto']['oferta_descripcion']:$reg['producto']['nombre'];

		$reg['titulo_sitio'] = $reg['titulo'];

		$reg['descripcion_sitio'] = $reg['producto']['descripcion'];

		if($reg['producto']['oferta_imagen']!='')
			$reg['imagen_link']= $reg['dirfileo'].'m'.$reg['producto']['oferta_imagen'];
		elseif($reg['producto']['archivo']!='')
			$reg['imagen_link']= $reg['dirfileout'].'m'.$reg['producto']['archivo'];


		$reg['adicionales'] = $adic->listarAdicionalesPro($reg['producto']['id_producto']);
		
		$this->view->show('preview_oferta.php', $reg);
	}


	public function actualizar_vencidas(){
		$prod= new Productos();
		$almacen=new Almacenes();
		$vencidos=$prod->listarOfertasVencidas();
		
		$i=0;
		foreach ($vencidos as $oferta) {
	
			$prod->datos= array();
			$prod->datos['oferta']='Inactivo';
			$prod->datos['oferta_portal']='Inactivo';
			$prod->datos['oferta_descripcion']='';
			$prod->datos['oferta_imagen']='';
			$prod->datos['oferta_publicacion']='0000-00-00';
			$prod->datos['oferta_vencimiento']='0000-00-00';
			$prod->datos['oferta_precio']=0;
			$prod->datos['oferta_destacado']='No';
			$prod->datos['oferta_terminos']='';
			$prod->datos['oferta_almacen']='todos';
			$prod->datos['oferta_aprobada']='';
			
			if($prod->guardar($oferta['id_producto']))
			$almacen->borrarAlmacenesProducto($oferta['id_producto']);
			$i++;
		}
		
		//echo "Se actualizaron $i ofertas vencidas";
	}

	public function enviar_vencen_hoy(){
		$fechahoy=date("Y-m-d");
		$ahora= time();
		$fecha_pre= strtotime($fechahoy.' 08:30:00');
		$fecha_post= strtotime($fechahoy.' 9:30:00');
		$log = new Modulos();
        $log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], 'producto- enviar_vencen_hoy '.date("Y-m-d h:i:s"));

		if($fecha_pre<$ahora and $ahora<$fecha_post){
			$productos= new Productos();
			$empresas= new Empresas();
			$mañana=date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
			$vencen=$productos->obtenerOfertasVencen($mañana);
			foreach($vencen as $row){
				$seguidores=$empresas->listarSeguidores($row['id_empresa']);
				$empresa= $empresas->obtener($row['id_empresa']);
				foreach ($seguidores as $cli) {
					//echo 'enviar '.$row['nombre'].' a '.$cli['nombre'].'<br/>';
					correo::enviar_vencen_hoy($row,$cli['nombre'],$cli['email'],$empresa['nombre']);
				}
			}
			correo::enviar_vencen_hoy($row,'diana','dianaleonoraz@gmail.com',$empresa['nombre']);
		}
		else{
			//echo 'Horario no permitido';
		}
		
	}	
}
?>