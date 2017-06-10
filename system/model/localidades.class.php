<?php 

// Localidades Version 0.2
// Septiembre 18/2008
// Jukian by RHISS.NET

class Localidades extends ModelBase
{

	public $datosPais;
	public $datosDpto;
	public $datosCiudad;
	public $datosZona;
	
	public function __construct(){
        parent::__construct();
        $this->datosPais = array();
		$this->datosDpto = array();
		$this->datosCiudad = array();
		$this->datosZona = array();
   } 

   public function agregarPais ( $npais,$isopais){
   		$datos['nombre']=$npais;
   		$datos['iso']=$isopais;
   		$datos['bnombre']=racentos($npais);

		$this->db->insert($datos, PAISES );
		$id = $this->db->insert_id();

		$this->db->query("update ".VERSIONES." set actualizado=NOW() where tipo='localidad' ");
	     return $id;
	}

	public function agregarDpto($ndpto,$idpais){
   		$datos['dpto']=$ndpto;
   		$datos['id_pais']=$idpais;

   		$datos['bdpto']=racentos($ndpto);
   		
		$this->db->insert($datos, DPTOS );
		$id = $this->db->insert_id();
		$this->db->query("update ".VERSIONES." set actualizado=NOW() where tipo='localidad' ");
	     return $id;
	}

	public function agregarCiudad($nciudad,$iddpto){
   		$datos['ciudad']=$nciudad;
   		$datos['id_dpto']=$iddpto;
		$datos['bciudad'] = racentos($nciudad);

		$this->db->insert($datos, CIUDADES );
		$id = $this->db->insert_id();
		$this->db->query("update ".VERSIONES." set actualizado=NOW() where tipo='localidad' ");
	     return $id;
	}

		
	public function obtenerPaisPorNombre($npais,$isopais){
		  $out = $this->db->fetch_array($this->db->query("select * from ".PAISES." where iso like '%$isopais%' order by nombre"));
		  return nvl($out['id_pais'],0);
	}
	
	public function obtenerDptoPorNombre($ndpto,$idpais){
		$out = $this->db->fetch_array($this->db->query("select * from ".DPTOS." where dpto like '%$ndpto%' and id_pais=$idpais"));
		return nvl($out['id_dpto'],0);
	}
	
	public function obtenerCiudadPorNombre($nciudad,$iddpto){
		  $out = $this->db->fetch_array($this->db->query("select * from ".CIUDADES." where ciudad like '%$nciudad%' and id_dpto=$iddpto"));
		  return nvl($out['id_ciudad'],0);
		 /* if(nvl($out['id_ciudad'],0))
		  return $out['id_ciudad'];
		  else {
		    $datos['ciudad']=$nciudad;
		    $datos['id_dpto']=$iddpto;
		    	$this->db->insert($datos, CIUDADES );
		    	return $this->db->insert_id();
		    }*/
	}
	
	
	public function obtenerPais($id){
		  $out = $this->db->fetch_array($this->db->query("select nombre from ".PAISES." where  id_pais = '$id' "));
		  return $out['nombre'];
	}


	public function obtenerEstado($id){
		  $out = $this->db->fetch_array($this->db->query("select dpto from ".DPTOS." where  id_dpto = '$id' "));
		   return $out['dpto'];
	}
	public function obtenerCiudad($id){
		$out = $this->db->fetch_array($this->db->query("select ciudad from ".CIUDADES." where  id_ciudad = '$id' "));
		 return $out['ciudad'];
	}
	
	
	public function listarPaisesSel($default=""){
		return $this->db->listbox("select id_pais, nombre from ".PAISES." order by nombre",$default);	
	}
	
	
	
	
	
	public function listarEstadosSel( $id_pais, $default=""){
		return $this->db->listbox("select id_dpto, dpto from ".DPTOS." WHERE id_pais = '$id_pais'  order by dpto",$default);	
	}
	
	
	public function listarCiudadesSel($idd, $default="", $private = true){
		return $this->db->listbox("select id_ciudad, ciudad from ".CIUDADES." where id_dpto = '$idd' order by ciudad",$default);	
	}
	
	
	
	public function listarDptoJSON($id_pais, $num_bienes = false, $private = true){
		$add = '';
		if($private){
			$add = ' and i.id_empresa = '.$_SESSION['id_empresa'];
		}
		
		$reg['id'] = array();
		if($num_bienes == 'true'){
			$sql = "
			SELECT p.id_dpto, CONCAT(p.dpto,' (',COUNT(*),')') as dpto 
			FROM ".DPTOS." p 
				INNER JOIN ".BIENES." i ON p.id_dpto = i.id_dpto  
			WHERE p.id_pais = '$id_pais' and i.estado <> 'Eliminado' and i.estado <> 'Inactivo' $add 
			GROUP BY p.id_dpto 
			ORDER BY p.dpto";
		}else{
			$sql = "
			SELECT id_dpto, dpto 
			FROM ".DPTOS." 
			WHERE id_pais = '$id_pais' 
			ORDER by dpto";
		}
		$out = $this->db->query($sql);	
		$sal = $this->db->result_array($out);
		foreach($sal as $dat){
					$reg['id'][] = $dat['id_dpto'];
					$reg['nombre'][] = $dat['dpto'];
		}
		$reg['num'] = count($reg['id']);
		return json_encode($reg);
	}
	
	
	
	public function listarCiudadesJSON($id_dpto, $num_bienes = false, $private = true){
		$add = '';
		if($private){
			$add = ' and i.id_empresa = '.$_SESSION['id_empresa'];
		}
		$reg['id'] = array();
		if($num_bienes == 'true'){
			$sql = "
			SELECT p.id_ciudad, CONCAT(p.ciudad,' (',COUNT(*),')') as ciudad 
			FROM ".CIUDADES." p 
				INNER JOIN ".BIENES." i ON p.id_ciudad = i.id_ciudad  
			WHERE p.id_dpto = '$id_dpto' and i.estado <> 'Eliminado' and i.estado <> 'Inactivo' $add
			GROUP BY p.id_ciudad 
			ORDER BY p.id_ciudad";
		}else{
			$sql = "
			SELECT id_ciudad, ciudad 
			FROM ".CIUDADES." 
			WHERE id_dpto = '$id_dpto' 
			ORDER BY ciudad";
		}
		$out = $this->db->query($sql);	
		$sal = $this->db->result_array($out);
		foreach($sal as $dat){
				$reg['id'][] = $dat['id_ciudad'];
				$reg['nombre'][] = $dat['ciudad'];
		}
		$reg['num'] = count($reg['id']);
		return json_encode($reg);
	}
}

?>