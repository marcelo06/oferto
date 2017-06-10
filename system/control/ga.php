<?php
/**
  * controlador Google Analytics
  *
  * 
  *
  * @package   GA 
  * @author	   Julian Vega
  * @since	   20100724
  * @version   20100724
  */
  
class ga extends ControlBase {
	
	private $ga;
	private $gacode;
	
	public function __construct(){
		$ga = configsite::get_ga();
		if(!empty($ga)){
			$this->gacode = $ga;
		}
    }
	
    public function validar_cuenta(){
        if(empty($this->gacode)){
            return false;
        }else{
            return TRUE;
        }
    }
	
	public function visitas(){
		$cache = new cache(3600);
        $cache->iniciar();

        $this->ga = new analytics();
		$this->ga->setProfileById($this->gacode);
		
		$fecha_desde = $this->input->get('fecha_desde');	
		$fecha_hasta = $this->input->get('fecha_hasta');
				
		$this->ga->setDateRange($fecha_desde, $fecha_hasta); 
		$visitas = $this->ga->getVisitors();
		
		$json = array();
		foreach ($visitas['rows'] as $value){
			$json['data'][] = intval($value[2]);				 
		}
		$json['name'] = 'Visitas';
		
		echo json_encode($json);
		$cache->cerrar();
	}
	
	public function general(){
		$cache = new cache(3600);
        $cache->iniciar();
        
        $this->ga = new analytics();
		$this->ga->setProfileById($this->gacode);

		$fecha_desde = $this->input->get('fecha_desde');	
		$fecha_hasta = $this->input->get('fecha_hasta');
				
		$this->ga->setDateRange($fecha_desde, $fecha_hasta); 
		$d['rebote'] = $this->ga->getBounceRate();
		$d['visitas'] = $this->ga->getTotalVisits();
		$d['tiempo'] = $this->ga->getTimePage();		
		
		echo json_encode($d);
		$cache->cerrar();
	}
	
	public function graph(){
		$cache = new cache(3600);
        $cache->iniciar();

        $this->ga = new analytics();
		$this->ga->setProfileById($this->gacode);
    	$tipo = $this->input->get('tipo');	
		$fecha_desde = $this->input->get('fecha_desde');	
		$fecha_hasta = $this->input->get('fecha_hasta');
		$this->ga->setDateRange($fecha_desde, $fecha_hasta); 
		
		if($tipo == 1){	
			$aData = $this->ga->getReferrers();
			echo '<table width="100%">
				<tr align="center">
					<td><strong>Sitio</strong></td>
					<td align="center"><strong>Visitas</strong></td>
				</tr>';
		}elseif($tipo == 2){
			$aData = $this->ga->getCountry();
			echo '<table width="100%">
				<tr align="center">
					<td><strong>País</strong></td>
					<td align="center"><strong>Visitas</strong></td>
				</tr>';
		}
		
		$iMax = max($aData['rows']);
		if ($iMax == 0){
			echo '</table>';
			return;
		}

		$datos = $aData['rows'];
		asort($datos);
		$i = 0;		
		foreach($datos as $sValue){
			echo '  <tr>
						<td>' . $sValue[0] . '</td>
						<td align="center">' . $sValue[1] . '</td>
					</tr>';
					
			if($i++ > 20) break;		
		}
		echo '</table>';
		$cache->cerrar();
	}
	
	
}

?>