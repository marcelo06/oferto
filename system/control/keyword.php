<?php
/**
  * controlador Keyword
  *
  * 
  *
  * @package   Keyword 
  * @author	   Sebastian Lopez
  * @since	   20100519
  * @version   20100519
  */
  
class Keyword extends ControlBase {

	 /*
	* Muestra la vista con el listado de categorías
	*/
	 public function keywords(){
		$keywords= new Keywords();
		/*$stopwords='el la los les las de del a ante con en para por y o u tu te ti le que al ha un han lo su una estas esto este es tras suya a acá ahí ajena ajenas ajeno ajenos al algo algún alguna algunas alguno algunos allá alli allí ambos ampleamos ante antes aquel aquella aquellas aquello aquellos aqui aquí arriba  asi atras aun aunque bajo bastante bien cabe cada casi cierta ciertas cierto ciertos como cómo con conmigo conseguimos conseguir consigo consigue consiguen consigues contigo contra cual cuales cualquier cualquiera cualquieras cuancuán cuando cuanta cuánta cuantas cuántas cuanto cuánto cuantos cuántos de dejar del demás demas demasiada demasiadas demasiado demasiados  dentro desde donde dos el él ella ellas  ello ellos empleais emplean emplear empleas empleo en encima entonces entre era eramos eran eras eres es esa esas ese eso esos esta estaba estado estais estamos estan estar estas este esto estos estoy etc fin fue fueron fui fuimos gueno ha hace haceis hacemos hacen hacer haces hacia hago hasta incluso intenta intentais intentamos intentan intentar intentas intento ir jamás junto juntos la largo las lo los mas más me menos mi mía mia mias mientras mio mío mios mis misma mismas mismo mismos modo mucha muchas muchísima muchísimas muchísimo muchísimos mucho muchos muy nada ni ningun ninguna ningunas ninguno ningunos no nos nosotras nosotros nuestra nuestras nuestro nuestros nunca os otra otras otro otros para parecer pero poca pocas poco pocos podeis podemos poder podria podriais podriamos podrian podrias por por qué porque primero primero desde puede pueden puedo pues que qué querer quien quién quienes quienes quiera quienquiera quiza quizas sabe sabeis sabemos saben saber sabes se segun ser si sí siempre siendo sin sín sino so sobre sois solamente solo somos soy sr sra sres esta su sus suya suyas suyo suyos tal tales también tambien tampoco tan tanta tantas tanto tantos te teneis tenemos tener tengo ti tiempo tiene tienen toda todas todo todos tomar trabaja trabajais trabajamos trabajan trabajar trabajas trabajo tras tú tu tus tuya tuyo tuyos ultimo un una unas uno unos usa usais usamos usan usar usas uso usted ustedes va vais valor vamos van varias varios vaya verdad verdadera vosotras vosotros voy vuestra vuestras vuestro vuestros y ya yo como cómo hacer se tengo';
		$words=explode(' ', $stopwords);
		foreach ($words as $word) {
			$keywords->guardarStopword($word);
		}
	*/
		$reg['keywords']= $keywords->listar();
		 $this->view->show("admin/keywords.php",$reg);
	}

	public function guardarKeywordsBusqueda($busqueda){
		$keywords= new Keywords();
		$busqueda= trim($busqueda);
		$busqueda= strtolower($busqueda);

		$datos=array();
	
		$existe=$keywords->existeBusqueda($busqueda);
		if($existe){
			$datos['cantidad']=$existe['cantidad']+1;
			$datos['fecha']=date('Y-m-d');
			$keywords->guardarBusqueda($datos,$existe['id_busqueda']);
		}
		else{
			$datos['busqueda']=$busqueda;
			$datos['cantidad']=1;
			$datos['fecha']=date('Y-m-d');
			$keywords->guardarBusqueda($datos,0);
		}

		$this->guardar_keyword($busqueda);
		
		$keys=explode(' ', $busqueda);
		for($i=0;$i<count($keys);$i++){
			$this->guardar_keyword($keys[$i]);
		}
	}

	public function guardar_keyword($keyword){
		$keywords= new Keywords();
		$keyword=trim($keyword);
		$id_keyword=0;
		if(!$keywords->existeKeyword($keyword) and !$keywords->esStopword($keyword)){
			$keywords->datos['keyword']=strtolower($keyword);
	    	$id_keyword=$keywords->guardar(0);
	    	//$this->sinonimos($keyword);
		}
	    return $id_keyword;
	}

	public function sinonimos($keyword){
		$llave='oxRl1ub143mLPN3cClKo';
		$service_url = "http://thesaurus.altervista.org/thesaurus/v1?word=".urlencode($keyword)."&language=es_ES&key=$llave&output=json";
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
	      if ( curl_errno( $curl ) ){
	        echo 'GCM error: ' . curl_error( $curl );
	      }
	     
	     // print_r($curl_response);
	      curl_close( $curl );
	      
	}

	/*
	* Borra la categoría correspondiente a el id
	* solicitud por ajax
	*/
	public function borrar_keyword(){
	  $keywords = new Keywords();
	  if($this->input->post('id')){
	     $keywords->borrar($this->input->post('id'));
	      echo 1;
	  }
		else
	      echo 0;
	}


	/*
	* Devuelve el nombre de la categoría correspondiente a el id
	*/
	public static function nombreKeyword($id){
		$keyword = new Keywords();
		$ope = $keyword->obtener($id);	
		return $ope['keyword'];
    }
	
	  
	  /* 
	  * Edita el nombre de la keyword desde un elemento jeditable en la vista
	  * solicitud por ajax
	  */
	   public function editable(){
	    $keyword = new keywords();
		$keyword->datos['keyword'] = $this->input->post('value'); 	
		
		$ident = $this->input->post('id');
		$id= explode('_',$ident);
		

		if($id = $keyword->guardar( $id[1]))
			 echo $this->input->post('value');
		 else  
             echo 'Error al guardar';
	  }
	 
	  public function json_keywords(){
	  	$keywords = new Keywords();
	  	$texto= nvl($_GET['texto']);
	  	$listado=$keywords->buscarKeyword($texto);
		echo json_encode($listado);
	  }
	 
}
?>