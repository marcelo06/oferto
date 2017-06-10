<?php

  class piwik {
    
   
    private $_sProfileId;

    private $_ClientId;
    
    private $_sStartDate;
    private $_sEndDate;
    
    private $_bUseCache;
    private $_iCacheAge;
	
	private $url_stats;
    

    public function __construct(){
        $this->_ClientId = '8ea4aa56b794dddbaea2b47a01e13630';
        $this->_bUseCache = false;
        $this->_iCacheAge = 6000;
		
		$this->url_stats='http://www.oferto.co/stats/';
      //  $this->auth();
    }
    
	  /**
    * Sets the id site for PA data
    * 
    * @param ing $id_site 
    */
    public function setIdSite($idSite){
        
        $this->_sProfileId = $idSite; 
        
        
    }
    
    /**
    * Sets the date range for PA data
    * 
    * @param string $sStartDate (YYY-MM-DD)
    * @param string $sEndDate   (YYY-MM-DD)
    */
    public function setDateRange($sStartDate, $sEndDate){
        
        $this->_sStartDate = $sStartDate; 
        $this->_sEndDate   = $sEndDate;
        
    }
    
    /**
    * Sets de data range to a given month
    * 
    * @param int $iMonth
    * @param int $iYear
    */
    public function setMonth($iMonth, $iYear){  
        
        $this->_sStartDate = date('Y-m-d', strtotime($iYear . '-' . $iMonth . '-01')); 
        $this->_sEndDate   = date('Y-m-d', strtotime($iYear . '-' . $iMonth . '-' . date('t', strtotime($iYear . '-' . $iMonth . '-01'))));
    }
    
    /**
    * Get visitors for given period
    * 
    */
    public function getVisitors(){
		$pparams= '&period=day&date='.$this->_sStartDate.','.$this->_sEndDate;
		
      $url= $this->url_stats."index.php?module=API&method=VisitsSummary.getVisits&idSite=".$this->_sProfileId.$pparams."&format=JSON&token_auth=".$this->_ClientId;
		$obj = $this->getData($url);
        return $obj; 
    }
    
    
    /**
    * Get referrers for given period
    * 
    */    
    public function getReferrers(){
  
	if($this->_sStartDate== $this->_sEndDate)
	$pparams= '&period=day&date='.$this->_sStartDate;
	else
	$pparams= '&period=range&date='.$this->_sStartDate.','.$this->_sEndDate;
	
    $url = $this->url_stats."index.php?module=API&method=Referers.getRefererType&idSite=".$this->_sProfileId.$pparams."&language=es&format=JSON&token_auth=".$this->_ClientId;
	
	$general =$this->getData($url);
	
	$urlB= $this->url_stats."index.php?module=API&method=Referers.getSearchEngines&idSite=".$this->_sProfileId.$pparams."&language=es&format=JSON&token_auth=".$this->_ClientId;
	
	$buscadores =$this->getData($urlB);
	
	$tBuscadores= array();
	if(count($buscadores))
	{
		$buscadores=  array_slice($buscadores, 0, 4);
	}
	$dRefers= array_merge($general,$tBuscadores,$buscadores);
		
		
     $urlP = $this->url_stats."index.php?module=API&method=Referers.getWebsites&idSite=".$this->_sProfileId.$pparams."&language=es&format=JSON&token_auth=".$this->_ClientId;
	$paginas = $this->getData($urlP);
	
	$tSitios= array();
		
		
	$dRefers= array_merge($dRefers,$tSitios,$paginas);

	return $dRefers; 
    }
    
  
    
    /**
    * Obtener visitas por pais
    * 
    */    
    public function getCountry(){
		
	if($this->_sStartDate== $this->_sEndDate)
	$pparams= '&period=day&date='.$this->_sStartDate;
	else
	$pparams= '&period=range&date='.$this->_sStartDate.','.$this->_sEndDate;	
		 
     $url= $this->url_stats."index.php?module=API&method=UserCountry.getCountry&idSite=".$this->_sProfileId.$pparams."&language=es&format=JSON&token_auth=".$this->_ClientId;
	
		$obj = $this->getData($url);
        return $obj; 
    }
    
    /**
    * Obtener porcentajes Rebote, No visitas y tiempo promedio  
    * 
    */   
    
    public function getGeneral(){
 
	if($this->_sStartDate== $this->_sEndDate)
	$pparams= '&period=day&date='.$this->_sStartDate;
	else
	$pparams= '&period=range&date='.$this->_sStartDate.','.$this->_sEndDate;
		
      $url = $this->url_stats."index.php?module=API&method=VisitsSummary.get&idSite=".$this->_sProfileId.$pparams."&format=JSON&token_auth=".$this->_ClientId;
	
	
		$obj = $this->getData($url);
	
		$d['rebote'] =$obj['bounce_rate'];
		$d['visitas'] =$obj['nb_visits'];
		$d['tiempo'] =  date('00:i:s',$obj['avg_time_on_site']);
       
        return $d; 
    }
	
	  public function getBounceRate(){
 
	if($this->_sStartDate== $this->_sEndDate)
	$pparams= '&period=day&date='.$this->_sStartDate;
	else
	$pparams= '&period=range&date='.$this->_sStartDate.','.$this->_sEndDate;
		
      $url = $this->url_stats."index.php?module=API&method=VisitsSummary.get&idSite=".$this->_sProfileId.$pparams."&format=JSON&token_auth=".$this->_ClientId;
	
		$obj = $this->getData($url);	
       
        return $obj['bounce_rate'];
    }
	
	  public function getTotalVisits(){
 
	if($this->_sStartDate== $this->_sEndDate)
	$pparams= '&period=day&date='.$this->_sStartDate;
	else
	$pparams= '&period=range&date='.$this->_sStartDate.','.$this->_sEndDate;
		
      $url = $this->url_stats."index.php?module=API&method=VisitsSummary.get&idSite=".$this->_sProfileId.$pparams."&format=JSON&token_auth=".$this->_ClientId;
		
		$obj = $this->getData($url);
       
        return $obj['nb_visits'];
    }
	
	  public function getTimePage(){
 
	if($this->_sStartDate== $this->_sEndDate)
	$pparams= '&period=day&date='.$this->_sStartDate;
	else
	$pparams= '&period=range&date='.$this->_sStartDate.','.$this->_sEndDate;
		
      $url = $this->url_stats."index.php?module=API&method=VisitsSummary.get&idSite=".$this->_sProfileId.$pparams."&format=JSON&token_auth=".$this->_ClientId;
		$obj = $this->getData($url);
        return $obj['avg_time_on_site'];
    
    }
	
	 /**
    * crea el id de seguimiento en rhistats
    * 
    */   
    
	public function crearStats($nombre, $subdominio, $dominio){
		$urls='';
		if($subdominio!='')
		$urls.='&urls[0]='.$subdominio;
		if($dominio!='')
		$urls.='&urls[1]='.$dominio;
		
		if($urls!='')
		{
			$url=$this->url_stats.'index.php?module=API&method=SitesManager.addSite&siteName='.chstr($nombre).$urls.'&format=JSON&token_auth='.$this->_ClientId;
			$out= $this->getData( $url);
			return nvl($out['value'],false);
		}
		else
		return false;
    }
	
	public function actualizarStats($nombre, $subdominio, $dominio){
		$urls='';
		if($subdominio!='')
		$urls.='&urls[0]='.$subdominio;
		if($dominio!='')
		$urls.='&urls[1]='.$dominio;
		if($urls!='')
		{
			$url=$this->url_stats.'index.php?module=API&method=SitesManager.updateSite&idSite='.$this->_sProfileId.'&siteName='.chstr($nombre).$urls.'&format=JSON&token_auth='.$this->_ClientId;
			$out=$this->getData($url);
			$result= (nvl($out['result'])=='success')? true:false;
			return $result; 
		}
		else
		return false;
    }
	
	public function existeStats($idSitio){
	
			$url=$this->url_stats.'index.php?module=API&method=SitesManager.getSiteFromId&idSite='.$idSitio.'&format=JSON&language=es&token_auth='.$this->_ClientId;
			$out= $this->getData($url);
			
			$result= (nvl($out['idsite'],0))? true:false;
			return $result; 
    }
	
	
	/**
    * Hacer la solicitud CURl 
    * 
    */  
	public function getData($url){
		
		 $ch = curl_init($url);
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		$json = curl_exec($ch);
		
		/*if (curl_errno( $ch ) ){
	        echo curl_error( $ch );
	     }*/
		curl_close($ch);
		return json_decode($json,true);
	}

    /**
    * get resulsts from cache if set and not older then cacheAge
    * 
    * @param string $sKey
    * @return mixed cached data
    */
    private function getCache($sKey){
        
        if ($this->_bUseCache === false){
            return false;
        }
        
        if (!isset($_SESSION['cache'][$this->_sProfileId])){
            $_SESSION['cache'][$this->_sProfileId] = array();
        }  
        if (isset($_SESSION['cache'][$this->_sProfileId][$sKey])){
            if (time() - $_SESSION['cache'][$this->_sProfileId][$sKey]['time'] < $this->_iCacheAge){
                return $_SESSION['cache'][$this->_sProfileId][$sKey]['data'];
            } 
        }
        return false;
    }
    
    /**
    * Cache data in session
    * 
    * @param string $sKey
    * @param mixed $mData Te cachen data
    */
    private function setCache($sKey, $mData){
        
        if ($this->_bUseCache === false){
            return false;
        }
        
        if (!isset($_SESSION['cache'][$this->_sProfileId])){
            $_SESSION['cache'][$this->_sProfileId] = array();
        }  
        $_SESSION['cache'][$this->_sProfileId][$sKey] = array(  'time'  => time(),
                                                                'data'  => $mData);
    }
	
	
	
    
}