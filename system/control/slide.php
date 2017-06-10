<?php

class Slide extends ControlBase {


	public function editar(){


        $reg['id_sesion'] = session_id();

        $reg['token'] = $this->input->post('token') ? $this->input->post('token') : 'tk'.substr(md5(date('hisu').rand(100,9999)), -7);
        $gal = new Slides($reg['token']);

		$reg['mensaje'] = '';

		if($this->input->post('guardar_btn') == false ){
			
			$reg['reg']= $gal->obtenerEmpresa($_SESSION['id_empresa']);
			
			$reg['id_slide'] = nvl($reg['reg']['id_galeria'],0);
            $gal -> iniciar();
		}

        $gal -> retomar();

		if($this->input->post('guardar_btn') ){
			$gal->retomar();
			$reg['id_sesion'] = session_id();

			if($this->input->post('fecha'))
			   $fecha= $this->input->post('fecha');
			else
			   $fecha= date("Y-m-d");

			$gal->datos['fecha'] = $fecha;
			
			if($this->input->post('id')==0)
			$gal->datos['id_empresa'] = $_SESSION['id_empresa'];

			$id = $gal->guardar($this->input->post('id'));

			$reg['id_slide'] = $id;
			$reg['mensaje'] = "Slide guardado";

		}
		else{

			 $gal->iniciar();

			}

		$this->view->show("admin/edit_slide.php", $reg);

	  }




	public function cargar_galeria(){
		$gal = new Slides($this->input->post('token'));
		$arch = $gal->listarGaleria($_POST['id'] );
		$uploadId = $_POST['uploadId'];
		$cadena = "";
		$i = 0;
		foreach($arch as $reg){
			$i++;
			$cadena.=
    
	  '<li class="ui-state-default addimage imageli'.$i.'"  value="'.$i.'" id="'.$i.'">
		<div class="extras">
		</div>
		  <a class="fancybox-thumbs" href="'.$gal->dirfileout.'b'.$reg['archivo'].'"  data-fancybox-group="thumbs" title= "'.$reg['referencia'].'" ></a><img class="imggal" id="addClass'.$i.'" src="'.$gal->dirfileout.'s'.$reg['archivo'].'"  width="146" height="56" />
		  <div class="deleteimg" id="dele'.$i.'" onclick="borrar('.$i.')"><img src="'.URLVISTA.'admin/img/Closed.png" title="eliminar imagen" alt="eliminar imagen" ></div>
		  <div class="editimg" ><a class="form_referencia" href="slide-form_referencia-id_doc-'.$i.'-cod-'.$this->input->post('token').'"><img src="'.URLVISTA.'admin/img/icon-02.png"></a></div>
	   </li>';

        }
        echo $cadena;
    }


	// funcion llamada desde el flash para subir el archivo o imagen
   public function subir_archivo(){
		$gal  = new Slides($this->input->post('token'));
		$phpSessId = $this->input->post('id_sesion');

		if (!empty($phpSessId) && session_id() != $phpSessId) {
			session_destroy();
			session_id($phpSessId);
			session_start();
		}
		if(nvl($_SESSION['id_tipo_usuario']) == 4){
			if( !isset($_SESSION['nf'][$gal->token]) ){
			   $gal->iniciar();
			}

			$gal->retomar();

			if (!empty($_FILES)){
				  $dat =  $_FILES['Filedata']['type'];
				  $divId = $this->input->post('divId');
				  $referencia = $this->input->post('referencia');
				  $vinculo = $this->input->post('vinculo');
				  $gal->agregarDoc("Filedata",'','', $divId);
				  $respuesta = array (
				  'pos'=>$_SESSION['nf'][$gal->token],
				  'archivo'=>$gal->dirfileout.'b'.$_SESSION['docs'][$gal->token]['archivo'][$_SESSION['nf'][$gal->token]],
				  'thumbnail'=>$gal->dirfileout.'s'.$_SESSION['docs'][$gal->token]['archivo'][$_SESSION['nf'][$gal->token]],
				  'referencia'=>$referencia, 'vinculo'=>$vinculo);
				  echo json_encode($respuesta);
			}else{
				echo json_encode(array('error' => 'no existe archivo'));
			}

	   }else{
				echo json_encode(array('error' => 'no existe archivo'));
	   }
   }



       //funcion que carga los divs con el listado de imagenes desde la sesion

	public function listar_galeria(){
	 $gal  = new Slides($this->input->post('token'));
	 $uploadId = $_POST['uploadId'];
	 $cadena = "";
	 $gal->retomar();
	 $i = 1;
	 while($i <= $gal->nf[$gal->token]){
	   if($gal->docs[$gal->token]['estado'][$i] != 0){
	      $cadena.=   '<div id="'.$uploadId.$gal->docs[$gal->token]['idDiv'][$i].'" class="uploadifyQueueItem">
	      <div class="up"  ><a href="javascript:mover(\''.$uploadId.$gal->docs[$gal->token]['idDiv'][$i].'\',\'pos'.$gal->docs[$gal->token]['idDiv'][$i].'\',\'subir\' )">
	      	<img src="'.URLBASE.'system/src/uploadify/up_16.png" border="0" alt="Subir Posicion " title="Subir Posicion "  /></a>
	      </div>
	      <div class="down"><a href="javascript:mover(\''.$uploadId.$gal->docs[$gal->token]['idDiv'][$i].'\',\'pos'.$gal->docs[$gal->token]['idDiv'][$i].'\',\'bajar\' )">
	      	<img src="'.URLBASE.'system/src/uploadify/down_16.png" border="0" alt="Bajar Posicion " title="Bajar Posicion" /></a>
	      </div>
	      <div class="prev" id="prev'.$gal->docs[$gal->token]['idDiv'][$i].'">
	      	<a  style="cursor:pointer" class="screenshot" rel="'.$gal->dirfileout.'s'.$gal->docs[$gal->token]['archivo'][$i].'"><img src="'.URLBASE.'system/src/uploadify/lupita.png" width="146" height="40" border="0" /></a>
	      </div>
	      <div class="cancel">
	      	<a href="javascript:borrar(\''.$uploadId.$gal->docs[$gal->token]['idDiv'][$i].'\',\'pos'.$gal->docs[$gal->token]['idDiv'][$i].'\' );">
	      		<img src="'.URLBASE.'system/src/uploadify/cancel.png" border="0" />
	      	</a>
	      </div>
	      <span class="fileName">'.$gal->docs[$gal->token]['imagen'][$i].'</span>
	      <div id="ref'.$gal->docs[$gal->token]['idDiv'][$i].'">'.$gal->docs[$gal->token]['referencia'][$i].'</div>
	      <input type="hidden" id="pos'.$gal->docs[$gal->token]['idDiv'][$i].'" value="'.$i.'"  >
	      </div>';
	   }
	   $i++;
	 }
	 echo $cadena;
	}




   /**
	 * quitarArchivo
	 * quita del listado la imagen y le coloca un estado en 0 para que no se guarde
	 *
	 *
	 * @access	public
	 * @author	Julian Vega
	 * @since	20100519
	 * @version	20100519
	 * @return 	void.
	 */

	public function borrar_archivo(){
	    $this->input->post('token');
		if($this->input->post('id_doc') ){
			$_SESSION['docs'][$this->input->post('token')]['estado'][$this->input->post('id_doc')] = 0;
			echo '1';
		}else
			echo '0';
	}


	/**
	 * obtenerArchivo
	 * Obtiene la imagen que seleccion para tener vista previa
	 *
	 *
	 * @access	public
	 * @author	Julian Vega
	 * @since	20100519
	 * @version	20100519
	 * @return 	void.
	 */

	public function obtener_archivo(){
		$galeria = new Slides($this->input->post('token'));
		if( $this->input->post('id_doc') ){
			if(is_file($galeria->dirfile.'s'.$_SESSION['docs'][$this->input->post('token')]['archivo'][$this->input->post('id_doc')]))
				echo $galeria->dirfileout.'s'.$_SESSION['docs'][$this->input->post('token')]['archivo'][$this->input->post('id_doc')];
			else
				echo URLVISTA."admin/img/error.gif";
		}else
			echo '0';
	}


	/**
	 * posiciones
	 * funcion para subir y bajar el nivel de las imagenes o posicion
	 *
	 *
	 * @access	public
	 * @return 	void.
	 */


	public function ordenar(){
		$galeria =new Slides($this->input->post('token'));

		$arreglo = $this->input->post('arreglo');
		$galeria->ordenarArreglo($arreglo);
	}

	public function form_referencia(){

       if($this->input->post('id_doc') && $this->input->post('token')){
       	 $_SESSION['docs'][$this->input->post('token')]['referencia'][$this->input->post('id_doc')] = $this->input->post('referencia');
		 $_SESSION['docs'][$this->input->post('token')]['vinculo'][$this->input->post('id_doc')] = $this->input->post('vinculo');
	     $reg['mensaje'] = 'Descripci&oacute;n actualizada.<br> Use el botón guardar para confirmar los cambios';
       }

       else if(isset($this->get['id_doc']) && isset($this->get['cod'])){
	       $reg['id_doc'] = $this->get['id_doc'];
           $reg['token']  = $this->get['cod'];
	       $reg['referencia']   = nvl($_SESSION['docs'][$this->get['cod']]['referencia'][$this->get['id_doc']] );
		    $reg['vinculo']   = nvl($_SESSION['docs'][$this->get['cod']]['vinculo'][$this->get['id_doc']] );

	   }
	   $this->view->show('admin/edit_referenciav.php', $reg);
	}

   public function consulta(){
       print_r($_SESSION);
   }


}

?>