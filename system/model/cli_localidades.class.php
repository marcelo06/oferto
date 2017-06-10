<?php 

// Localidades Version 0.2
// Septiembre 18/2008
// Jukian by RHISS.NET

class Cli_Localidades extends ModelBase
{

	public $datosPais;
	public $datosDpto;
	public $datosCiudad;
	
	public function __construct(){
        parent::__construct();
        $this->datosPais = array();
		$this->datosDpto = array();
		$this->datosCiudad = array();
   } 

  	
	public function obtenerPaisPorNombre($npais,$isopais){
		  $out = $this->db->fetch_array($this->db->query("select * from ".CLI_PAISES." where iso like '%$isopais%' order by nombre"));
		  return nvl($out['id_pais'],0);
	}
	
	public function obtenerDptoPorNombre($ndpto,$idpais){
		$out = $this->db->fetch_array($this->db->query("select * from ".CLI_DPTOS." where dpto like '%$ndpto%' and id_pais=$idpais"));
		return nvl($out['id_dpto'],0);
	}
	
	public function obtenerCiudadPorNombre($nciudad,$iddpto){
		  $out = $this->db->fetch_array($this->db->query("select * from ".CLI_CIUDADES." where ciudad like '%$nciudad%' and id_dpto=$iddpto"));
		  return nvl($out['id_ciudad'],0);
	}
	
	public function paisesSelect($default=""){
		return $this->db->listbox("select id_pais, nombre from ".CLI_PAISES." order by nombre",$default);	
	}
	
	
	public function dptosSelect( $id_pais, $default=""){
		return $this->db->listbox("select id_dpto, dpto from ".CLI_DPTOS." WHERE id_pais = '$id_pais'  order by dpto",$default);	
	}
	
	
	public function ciudadesSelect($idd, $default="", $private = true){
		return $this->db->listbox("select id_ciudad, ciudad from ".CLI_CIUDADES." where id_dpto = '$idd' order by ciudad",$default);	
	}

	public function paisNombre($id){
		  $out = $this->db->fetch_array($this->db->query("select nombre from ".CLI_PAISES." where  id_pais = '$id' "));
		  return $out['nombre'];
	}


	public function dptoNombre($id){
		  $out = $this->db->fetch_array($this->db->query("select dpto from ".CLI_DPTOS." where  id_dpto = '$id' "));
		   return $out['dpto'];
	}
	public function ciudadNombre($id){
		$out = $this->db->fetch_array($this->db->query("select ciudad from ".CLI_CIUDADES." where  id_ciudad = '$id' "));
		 return $out['ciudad'];
	}
}

?>