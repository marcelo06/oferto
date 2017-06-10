<?php
/**
  * controlador Google Analytics
  *
  * 
  *
  * @package   PA 
  * @author	   Julian Vega
  * @since	   20100724
  * @version   20100724
  */
  
class pa {
	
	private $pa;
	private $pacode;
	private $fecha_pa;
	
	public function __construct(){
		$emp = empresa::get_contacto();
		if(!empty($emp['pa'])){
			$this->pacode = $emp['pa'];
			$this->fecha_pa = $emp['fecha_pa'];
		}
    }
	
    public function validar_cuenta(){
        if(empty($this->pacode)){
            return false;
        }else{
            return TRUE;
        }
    }
	
	public function visitas(){
		$fecha_desde = $this->input->get('fecha_desde');	
		$fecha_hasta = $this->input->get('fecha_hasta');
		
		if($this->fecha_pa > $fecha_desde)
		{
			$cache = new cache(360);
			$cache->iniciar();
			
			$emp = empresa::datos_empresa();
						
			$this->pa = new piwik();
			$this->pa->setIdSite($this->pacode);
			
			$this->pa->setDateRange($this->fecha_pa, $fecha_hasta);
			$visitas = $this->pa->getVisitors();
			
			foreach ($visitas as $value){
				$json['data'][] = intval($value);				 
			}

			if(count($json['data']) < resta_fechas($fecha_hasta, $fecha_desde)){
				$n =  resta_fechas($fecha_hasta, $fecha_desde) - count($json['data']);
				for($k=0; $k<$n; $k++){
					array_unshift($json['data'], 0);
				}
			}
			
			echo json_encode($json);
			$cache->cerrar();
		}
		else
		{
			$cache = new cache(360);
			$cache->iniciar();
	
			$this->pa = new piwik();
			$this->pa->setIdSite($this->pacode);
			
			
					
			$this->pa->setDateRange($fecha_desde, $fecha_hasta); 
			$visitas = $this->pa->getVisitors();
			
			$json = array();
			foreach ($visitas as $value){
				$json['data'][] = intval($value);				 
			}
			$json['name'] = 'Visitas';
			
			echo json_encode($json);
			$cache->cerrar();
		}
	}
	
	public function general()
	{
		$fecha_desde = $this->input->get('fecha_desde');	
		$fecha_hasta = $this->input->get('fecha_hasta');
		
		if($this->fecha_pa > $fecha_desde)
		{
			$cache = new cache(360);
			$cache->iniciar();
			
			$emp = empresa::datos_empresa();
						
			$this->pa = new piwik();
			$this->pa->setIdSite($this->pacode);
			
			$this->pa->setDateRange($this->fecha_pa, $fecha_hasta);
			$p['rebote'] = $this->pa->getBounceRate();
			$p['visitas'] = $this->pa->getTotalVisits();
			$p['tiempo'] = $this->pa->getTimePage();	
			
			$d['rebote']=nvl($g['rebote'],0)+nvl($p['rebote'],0) /2;
			$d['visitas'] = nvl($g['visitas'],0) +nvl($p['visitas'],0) ;
			$tiempo_v = nvl($g['tiempo'],0) +nvl($p['tiempo'],0) ;
			
			$d['tiempo']= date('00:i:s',$tiempo_v);			
			echo json_encode($d);
			$cache->cerrar();
		}
		else
		{
			$cache = new cache(360);
			$cache->iniciar();
			
			$this->pa = new piwik();
			$this->pa->setIdSite($this->pacode);
			
			$this->pa->setDateRange($fecha_desde, $fecha_hasta);
			$d['rebote'] = $this->pa->getBounceRate();
			$d['visitas'] = $this->pa->getTotalVisits();
			$d['tiempo'] = date('00:i:s',$this->pa->getTimePage());	
			
			echo json_encode($d);
			$cache->cerrar();
		}
		
		
	}
	
	public function graph(){
		$fecha_desde = $this->input->get('fecha_desde');	
		$fecha_hasta = $this->input->get('fecha_hasta');
		$tipo = $this->input->get('tipo');
		if($this->fecha_pa > $fecha_desde)
		{
			$cache = new cache(360);
			$cache->iniciar();
			
			
			if($tipo == 1){	
				echo '<table width="100%"><tr align="center"><td><strong>Sitio</strong></td><td align="center"><strong>Visitas</strong></td></tr>';
			}elseif($tipo == 2){
				echo '<table width="100%"><tr align="center"><td><strong>País</strong></td><td align="center"><strong>Visitas</strong></td></tr>';
			}	
			
			$this->pa = new piwik();
			$this->pa->setIdSite($this->pacode);
			
			$this->pa->setDateRange($this->fecha_pa, $fecha_hasta);
			if($tipo == 1)	
				$pData = $this->pa->getReferrers();
			elseif($tipo == 2)
				$pData = $this->pa->getCountry();
					
			$emp = empresa::datos_empresa();
			$datos= array();
			$sitios= array();
			
			$sitios['Entrada directa']= array();
			$sitios['Entrada directa']['valor']= '';
			foreach($pData as $bValue)
			{
				$nb= $bValue['label'];
				if($nb=='Entrada directa')
				{
				$sitios['Entrada directa']['valor']=$sitios['Entrada directa']['valor']+ $bValue['nb_visits'];
				}
				elseif(isset($sitios[$nb]))
				{
					$sitios[$nb]['valor']=$sitios[$nb]['valor']+ $bValue['nb_visits'];
				}
				else
				{
					$sitios[$nb]['nombre']=$nb;
					$sitios[$nb]['valor']=$bValue['nb_visits'];
				}
			}
			
			$i = 0;	
			foreach($sitios as $sValue)
			{	
				echo '  <tr><td>'.nvl($sValue['nombre']).'</td><td align="center">'.$sValue['valor'].'</td></tr>';
					
				if($i++ > 20) break;		
			}
			
			
			echo '</table>';
			$cache->cerrar();
		}
		else
		{
			$cache = new cache(3600);
			$cache->iniciar();
	
			$this->pa = new piwik();
			$this->pa->setIdSite($this->pacode);
			$tipo = $this->input->get('tipo');	
			
			$this->pa->setDateRange($fecha_desde, $fecha_hasta); 
			
			if($tipo == 1){	
				$aData = $this->pa->getReferrers();
				echo '<table width="100%">
				<tr align="center"><td><strong>Sitio</strong></td><td align="center"><strong>Visitas</strong></td></tr>';
			}elseif($tipo == 2){
				$aData = $this->pa->getCountry();
				echo '<table width="100%">
					<tr align="center"><td><strong>País</strong></td><td align="center"><strong>Visitas</strong></td></tr>';
			}
			$i = 0;	
			
			foreach($aData as $sValue)
			{	
				if($sValue['label']=='tt')
				{
					echo '<tr><td colspan="2"  align="center"><strong>'.$sValue['nombre'].'</strong></td></tr>';	
				}
				elseif($sValue['label']=='Motores de búsqueda' || $sValue['label']=='Sitios web')
				{
					$i--;
				}
				else
				{	
				 $logo=(nvl($sValue['logo'])) ? '<img src="http://www.rhistats.com/'.$sValue['logo'].'"/> ':'';	
				echo '  <tr><td>'.nvl($logo).$sValue['label'].'</td><td align="center">'.$sValue['nb_visits'].'</td></tr>';
				}		
				if($i++ > 20) break;		
			}
			echo '</table>';
			$cache->cerrar();
		}
	}
	
		public function crear_stats($nombre, $subdominio, $dominio){
		$this->pa = new piwik();
		
		
		if($idSite=$this->pa->crearStats($nombre, $subdominio, $dominio))
		{
			$this->pacode= $idSite;
			return $idSite;
		}
		else
			return false;
    }
	
	public function actualizarStats($nombre, $subdominio, $dominio){
		
		$this->pa = new piwik();
		$this->pa->setIdSite($this->pacode);
		
		if($this->pa->actualizarStats($nombre, $subdominio, $dominio))
		return true;
		else
			return false;
			
			
		$urls='';
		if($subdominio!='')
		$urls.='&urls[0]='.$subdominio;
		if($dominio!='')
		$urls.='&urls[1]='.$dominio;
		
		if($urls!='')
		{
			
			$url=$this->url_stats.'index.php?module=API&method=SitesManager.updateSite&idSite='.$this->_ClientId.'&siteName='.$nombre.$urls.'&format=JSON&token_auth='.$this->_ClientId;
			
			$out=$this->getData($url);
			$result= (nvl($out['result'])=='success')? true:false;
			return $result; 
		}
		else
		return false;
    }
}

?>