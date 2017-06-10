<?php
/**
  * Controlador Cofiguración del sitio
  *
  * 
  *
  * @package   configsite 
  * @author	   Julian Vega
  * @since	   20100909
  * @version   20100909
  */
  
class configsite extends ControlBase {
		
	
	public function configurar_sitio(){
		$cf = new configmodel();
		$reg['reg'] = $cf->obtener_config();
		if(nvl($this->get['save']) == 1)
			$reg['mensaje'] = 'Configuración Guardada';
		$this->view->show('admin/config_site.php', $reg);
	}
	
	public function guardar_configuracion(){
		$tipo = $this->input->post('tipo');
		$cf = new configmodel();
		$version=false;
		foreach ($tipo as $key => $value){
			if($key=='facebook'){
				if($this->input->post('facebook')!=$value)
					$version=true;
			}
			if($key=='twitter'){
				if($this->input->post('twitter')!=$value)
					$version=true;
			}
			if($key=='youtube'){
				if($this->input->post('youtube')!=$value)
					$version=true;
			}
			$cf->guardar_valor($key, $value);
		}
		if($version)
			$cf->actualizar_version();
		redirect('configsite-configurar_sitio-save-1.htm');
	}
	
	static function print_titulo(){
		$cf = new configmodel();
		$reg = $cf->obtener_config();
		echo $reg[0]['valor']; 	
	}
	
	static function print_descripcion(){
		$cf = new configmodel();
		$reg = $cf->obtener_config();
		echo $reg[2]['valor']; 	
	}
	
	static function print_keywords(){
		$cf = new configmodel();
		$reg = $cf->obtener_config();
		echo $reg[1]['valor']; 	
	}

	static function get_ga(){
		$cf = new configmodel();
		$reg = $cf->obtener_config();
		return $reg[8]['valor'];
	}

	static function get_tipo($tipo=''){
		$conf= new configmodel();
		return $conf->obtener_valor($tipo);
	}
	
	
	
}

?>