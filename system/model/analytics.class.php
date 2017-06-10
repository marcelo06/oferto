<?php

include(LIB.'gapi/Google_Client.php');
include(LIB.'gapi/contrib/Google_AnalyticsService.php');

  class analytics{
    
    private $service;
    private $client;
    private $_sProfileId;

    private $_ClientId;
    private $_email;
    private $_keyFile;
    
    private $_sStartDate;
    private $_sEndDate;
    
    private $_bUseCache;
    private $_iCacheAge;
    

    public function __construct(){
        $this->_ClientId = '101499019966-3ks1cemth9bhrk6devuuppa61q3qn855.apps.googleusercontent.com';
        $this->_email = '101499019966-3ks1cemth9bhrk6devuuppa61q3qn855@developer.gserviceaccount.com';
        $this->_keyFile = LIB.'gapi/auth/6c6905ba0b7069164564d779b5fe459f6228409c-privatekey.p12';
        $this->_bUseCache = false;
        $this->_iCacheAge = 6000;
        $this->auth();
    }
    
    
    /**
    * Google Authentification, returns session when set
    */
    
    private function auth(){
            $client = new Google_Client();
            if(isset($_SESSION['atoken'])){
                $client->setAccessToken($_SESSION['atoken']);
            }
            $client->setApplicationName('wasi.co');
            $client->setAssertionCredentials(
              new Google_AssertionCredentials(
                $this->_email,
                array('https://www.googleapis.com/auth/analytics.readonly'),
                file_get_contents($this->_keyFile)
              )
            );
            $client->setClientId($this->_ClientId);
            $client->setAccessType('offline');
            $this->service = new Google_AnalyticsService($client);
            $this->client = &$client;
    }
    
    
    
    
    /**
    * Sets GA Profile ID  (Example: ga:12345)
    */        
    public function setProfileById($gaid){
        $posi = strpos($gaid,'-');
        $idAcount = substr($gaid, $posi+1);
        $posf = strpos($idAcount, '-');
        $idAcount = substr($idAcount, 0, $posf);
        $profiles = $this->service->management_profiles->listManagementProfiles($idAcount,$gaid);
        $this->_sProfileId = $profiles['items'][0]['id']; 
        $token = $this->client->getAccessToken();
        if(!$this->client->isAccessTokenExpired()){
            $_SESSION['atoken'] = $token;    
        }else{
            unset($_SESSION['atoken']);
        }
        
    }
    
    
    
    public function getData($aProperties = array()){
        $metrics = $aProperties['metrics'];
        $aParams = array_slice($aProperties, 1); 
        $key = md5(serialize($aParams));

        $aCache = $this->getCache($key);
        if ($aCache !== false){
            return $aCache;
        }
        
        $aResult = $this->service->data_ga->get('ga:'.$this->_sProfileId, $this->_sStartDate, $this->_sEndDate, $metrics,$aParams);
        
        $result['total_resultados'] = $aResult['totalResults'];
        $result['metrica'] = $aResult['query']['metrics'][0];
        $result['valor_metrica'] = $aResult['totalsForAllResults'][$result['metrica']];
        $result['rows'] = $aResult['rows'];

        $this->setCache($key, $result);

        return $result;
    }
    
    
    
    /**
    * Sets the date range for GA data
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
                                
        return $this->getData(array( 'metrics'    => 'ga:visits', 
                                     'dimensions' => 'ga:day,ga:month',
                                     'sort'       => 'ga:month'));
    }
    
    /**
    * Get pageviews for given period
    * 
    */    
    public function getPageviews(){
                                
        return $this->getData(array( 'metrics'    => 'ga:pageviews', 
                                     'dimensions' => 'ga:day',
                                     'sort'       => 'ga:day'));
    }
    
    /**
    * Get visitors per hour for given period
    * 
    */    
    public function getVisitsPerHour(){
        
        return $this->getData(array( 'metrics'    => 'ga:visits',
                                     'dimensions' => 'ga:hour',
                                     'sort'       => 'ga:hour'));
    }
    
    /**
    * Get Browsers for given period
    * 
    */    
    public function getBrowsers(){
        
        $aData = $this->getData(array(  'metrics'    => 'ga:visits',
                                        'dimensions' => 'ga:browser,ga:browserVersion',
                                        'sort'       => 'ga:visits'));             
        arsort($aData);
        return $aData;                                                                                                                                                                           
    }
    
    /**
    * Get Operating System for given period
    * 
    */    
    public function getOperatingSystem(){
        
        $aData = $this->getData(array(   'metrics'    => 'ga:visits',
                                         'dimensions' => 'ga:operatingSystem',
                                         'sort'       => 'ga:visits'));
        // sort descending by number of visits
        arsort($aData);
        return $aData; 
    }

    /**
    * Get screen resolution for given period
    * 
    */    
    public function getScreenResolution(){
        
        $aData = $this->getData(array(   'metrics'    => 'ga:visits',
                                         'dimensions' => 'ga:screenResolution',
                                         'sort'       => 'ga:visits'));
        
        // sort descending by number of visits 
        arsort($aData);
        return $aData; 
    }
    
    /**
    * Get referrers for given period
    * 
    */    
    public function getReferrers(){
        
        $aData = $this->getData(array(   'metrics'    => 'ga:visits', 
                                         'dimensions' => 'ga:source',
                                         'sort'       => 'ga:source'));
    
        // sort descending by number of visits 
        arsort($aData);
        return $aData; 
    }
    
    /**
    * Get search words for given period
    * 
    */    
    public function getSearchWords(){
        $aData = $this->getData(array(   'metrics'    => 'ga:visits', 'dimensions' => 'ga:keyword',
                                         'sort'       => 'ga:keyword'));
        // sort descending by number of visits                                                                                                                                                     
        arsort($aData);
        return $aData; 
    }
    
    /**
    * Obtener visitas por pais
    * 
    */    
    public function getCountry(){
        
        $aData = $this->getData(array(   'metrics'    => 'ga:visits','dimensions' => 'ga:country',
                                         'sort'       => 'ga:country'));
    
        // sort descending by number of visits 
        arsort($aData);
        return $aData; 
    }
    
    /**
    * Obtener porcentaje de Rebote
    * 
    */   
    
    public function getBounceRate(){
        
        $bounce = $this->getData(array(   'metrics' => 'ga:bounces', 'dimensions' => 'ga:day',  'sort' => 'ga:day'));
        $totalb = $bounce['valor_metrica'];
        
        $entrance = $this->getData(array(   'metrics' => 'ga:entrances', 'dimensions' => 'ga:day',  'sort' => 'ga:day'));    
        $totale = $entrance['valor_metrica'];
        
        $total = round(($totalb/$totale) * 100, 2);
        
        return $total; 
    }
    
    /**
    * Total Visitas
    * 
    */   
    public function getTotalVisits(){
            $vis = $this->getVisitors();
            
            return $vis['valor_metrica'];
    }
    
    /**
    * Obtener porcentaje de Rebote
    * 
    */   
     
    public function getTimePage(){
        
        $time = $this->getData(array(   'metrics' => 'ga:timeOnSite',  'dimensions' => 'ga:day', 'sort' => 'ga:day'));
        $total_time = $time['valor_metrica'];
        
        $pages = $this->getData(array(   'metrics' => 'ga:visits', 'dimensions' => 'ga:day',  'sort' => 'ga:day'));  
        $total_pages = $pages['valor_metrica'];
        
        $total = $total_time / $total_pages ;
        
        return date('00:i:s',$total); 
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