<?php

class cache
{
var $cache_dir; // path ó ruta donde se almacena la cache
var $cache_time; // tiempo en que expira la cache (en segundos)
var $caching = false; //true, para cachear
var $cleaning = false; //true, para limpiar y actualizar
var $file = ''; // path o ruta del script a cachear

public function __construct( $time=300, $path='cache'){
    $this->cache_dir = $path;
    $this->cache_time = $time;
}

public function iniciar($action=NULL){
	clearstatcache();
	$this->cleaning = $action;
	$url = URI != '' ? URI : 'main-index';
	$this->file = $this->cache_dir."/ch_".$_SESSION['id_usuario'].substr($url, -6, 6).md5(urlencode($url));
	if (file_exists($this->file) && (filemtime($this->file)+$this->cache_time)>time() && $this->cleaning == false){
		readfile($this->file);
		exit();
	} else {
		$this->caching = true;
		if(file_exists($this->file)){
			unlink($this->file);
		}
		ob_start();
	}
}

public function iniciar_xml($action=NULL){
    clearstatcache();
    $this->cleaning = $action;
    $url = URI != '' ? URI : 'main-index';
    $this->file = $this->cache_dir."/ch_".$_SESSION['id_usuario'].substr($url, -6, 6).md5(urlencode($url)); 
    if (file_exists($this->file) && (filemtime($this->file)+$this->cache_time)>time() && $this->cleaning == false){
        header('Content-type: text/xml; charset=utf-8');
        readfile($this->file);
        exit();
    } else {
        $this->caching = true;
        if(file_exists($this->file)){
            unlink($this->file);
        }
        ob_start();
    }
}

public function cerrar(){
	if ($this->caching){
		$data = ob_get_clean();
		echo $data;
		if(file_exists($this->file)){
			unlink($this->file);
		}
		$fp = fopen( $this->file , 'w' );
		fwrite ( $fp , $data );
		fclose ( $fp );
		$this->caching = false;
	}
}

public function cerrar_xml(){
    if ($this->caching){
        $data = ob_get_clean();
        header('Content-type: text/xml; charset=utf-8');
        echo $data;
        if(file_exists($this->file)){
            unlink($this->file);
        }
        $fp = fopen( $this->file , 'w' );
        fwrite ( $fp , $data );
        fclose ( $fp );
        $this->caching = false;
    }
}

} 
?>