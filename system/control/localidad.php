<?php 

class localidad extends ControlBase{  

	
	static public function obtenerPais($id_pais){
		$loc = new Localidades();
		return $loc->obtenerPais($id_pais);	
	}

	static public function obtenerDpto($id_dpto){
		$loc = new Localidades();
		return $loc->obtenerEstado($id_dpto);	
	}
	
	static public function obtenerCiudad($id_ciudad){
		$loc = new Localidades();
		return $loc->obtenerCiudad($id_ciudad);	
	}
	
	public function encontrar_ids() {
	$localidades= new Localidades();
	$npais=$this->input->post('pais');
	$isopais=$this->input->post('isopais');
	$ndpto=$this->input->post('dpto');
	$nciudad=$this->input->post('ciudad');
	
	if($npais!=''){
		if($idp=$localidades->obtenerPaisPorNombre($npais,$isopais))
			$idpais=$idp;
		else
			$idpais=$localidades->agregarPais($npais,$isopais);
	}
	else
		$idpais=0;
	if($ndpto!='' and $idpais){
		if($idd=$localidades->obtenerDptoPorNombre($ndpto,$idpais))
			$iddpto=$idd;
		else	
			$iddpto=$localidades->agregarDpto($ndpto,$idpais);
	}
	else
		$iddpto=0;
	if($nciudad!='' and $iddpto){
		if($idc=$localidades->obtenerCiudadPorNombre($nciudad,$iddpto))
			$idciudad=$idc;
		else
			$idciudad=$localidades->agregarCiudad($nciudad,$iddpto);
	}
	else
		$idciudad=0;
	$respuesta = array (
	 'idpais'=>$idpais,
	 'iddpto'=>$iddpto,
	 'idciudad'=>$idciudad);
		echo json_encode($respuesta);			
	}
	 
}		

?>