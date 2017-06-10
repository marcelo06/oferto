<?php


class Mapas extends ModelBase
{

    public $dirfile ;
	public $dirfileout ;

	function __construct(){
      parent::__construct();
      $this->dirfile = FILES."mapas/";
	  $this->dirfileout = URLFILES."mapas/";
   }


	public function almacenes_ubicacion ($ubicacion=array(),$boundaries=array()){
		$busq='';
        if (count($boundaries)) {
            $s =  $boundaries[0];
            $w =  $boundaries[1];
            $n =  $boundaries[2];
            $e =  $boundaries[3];
            $busq.=" and (a.latitud > $s and a.latitud<$n and a.longitud > $w and longitud < $e) ";
          }
        

        $pais= nvl($ubicacion[0],0);
        $dpto= nvl($ubicacion[1],0);
        $ciudad= nvl($ubicacion[2],0);
        
        if($pais)
          $busq.=' and a.id_pais='.$pais;
        if($dpto)
          $busq.=' and a.id_dpto='.$dpto;
        if($ciudad)
          $busq.=' and a.id_ciudad='.$ciudad;
          

           $sql = "select a.id_almacen,a.nombre as almacen,a.direccion,a.ubicacion,a.latitud,a.longitud from ".PRODUCTOS." p join ".ALMACEN_PRODUCTOS." ap on ap.id_producto=p.id_producto left join ".ALMACENES." a on ap.id_almacen = a.id_almacen  where p.oferta_portal='Activo'  and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE()  and borrado='0' and oferta_aprobada='Si' $busq group by a.id_almacen ";
             
           $qid = $this->db->query($sql);
           return $this->db->result_array($qid);
	}


	public function almacenes_oferta($oferta=0,$boundaries=array(),$c_latitud=0,$c_longitud=0){
		$busq="";
    $distancia='';
    $ordend='';
    if (count($boundaries)) {
        $s =  $boundaries[0];
        $w =  $boundaries[1];
        $n =  $boundaries[2];
        $e =  $boundaries[3];
        $busq.=" and (a.latitud > $s and a.latitud<$n and a.longitud > $w and longitud < $e) ";
      }

    if($c_latitud and $c_longitud){
      $distancia=", ( 3959 * acos( cos( radians(".$c_latitud.") ) * cos( radians( a.latitud ) ) * cos( radians( a.longitud ) - radians(".$c_longitud.") ) + sin( radians(".$c_latitud.") ) * sin( radians( a.latitud ) ) ) ) AS distance ";
        $ordend="ORDER BY distance"; 
    }
  
    
    $sql = "select a.id_almacen,a.nombre as almacen,a.direccion,a.ubicacion,a.latitud,a.longitud $distancia from ".ALMACEN_PRODUCTOS." ap left join  ".PRODUCTOS." p on ap.id_producto=p.id_producto left join ".ALMACENES." a on ap.id_almacen = a.id_almacen where p.oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE()  and borrado='0' and oferta_aprobada='Si' $busq and ap.id_producto=$oferta $ordend";
       
      $qid = $this->db->query($sql);
      return $this->db->result_array($qid);
	}

  public function almacenes_categoria ($categoria=0,$boundaries=array(),$c_latitud=0,$c_longitud=0){
    $busq='';
    $distancia='';
    $ordend='';
    if (count($boundaries)) {
      $s =  $boundaries[0];
      $w =  $boundaries[1];
      $n =  $boundaries[2];
      $e =  $boundaries[3];
      $busq.=" and (a.latitud > $s and a.latitud<$n and a.longitud > $w and a.longitud < $e) ";
    }

    if($c_latitud and $c_longitud){
      $distancia=", ( 3959 * acos( cos( radians(".$c_latitud.") ) * cos( radians( a.latitud ) ) * cos( radians( a.longitud ) - radians(".$c_longitud.") ) + sin( radians(".$c_latitud.") ) * sin( radians( a.latitud ) ) ) ) AS distance ";
        $ordend="ORDER BY distance"; 
    }
  
   $sql = "select a.id_almacen,a.nombre as almacen,a.direccion,a.ubicacion,a.latitud,a.longitud $distancia from ".PRODUCTOS." p join ".ALMACEN_PRODUCTOS." ap on ap.id_producto=p.id_producto left join ".ALMACENES." a on ap.id_almacen = a.id_almacen left join ".EMPRESAS." e on a.id_empresa=e.id_empresa  where p.oferta_portal='Activo'  and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE()  and borrado='0' and oferta_aprobada='Si' and e.id_categoria=$categoria $busq group by a.id_almacen $ordend";
     
   $qid = $this->db->query($sql);
   return $this->db->result_array($qid);
  }



	public function ofertas($boundaries=array(),$c_latitud=0,$c_longitud=0){
		 $busq='';
     $distancia='';
     $ordend='';

    if (count($boundaries)) {
      $s =  $boundaries[0];
      $w =  $boundaries[1];
      $n =  $boundaries[2];
      $e =  $boundaries[3];
      $busq.=" and (a.latitud > $s and a.latitud<$n and a.longitud > $w and longitud < $e) ";
    }

    if($c_latitud and $c_longitud){
      $distancia=", ( 3959 * acos( cos( radians(".$c_latitud.") ) * cos( radians( a.latitud ) ) * cos( radians( a.longitud ) - radians(".$c_longitud.") ) + sin( radians(".$c_latitud.") ) * sin( radians( a.latitud ) ) ) ) AS distance ";
        $ordend="ORDER BY distance"; 
    }
  
    $sql = "select a.id_almacen,a.nombre as almacen,a.direccion,a.ubicacion,a.latitud,a.longitud $distancia from ".PRODUCTOS." p join ".ALMACEN_PRODUCTOS." ap on ap.id_producto=p.id_producto left join ".ALMACENES." a on ap.id_almacen = a.id_almacen  where p.oferta_portal='Activo'  and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' $busq group by a.id_almacen $ordend";
       
    $qid = $this->db->query($sql);
    return $this->db->result_array($qid);
	}

	public function ofertas_almacen($almacen=0,$search='',$categoria=''){
		$busqueda='';
		if($search!='')
       		$busqueda=" and (p.nombre like '%$search%' or p.nombre like '%$search%') ";

       	if($categoria!='')
       		$busqueda=" and e.id_categoria=$categoria ";

       	 $sql = "select p.id_producto,p.nombre,p.precio,p.oferta_precio,p.oferta_vencimiento,p.oferta_imagen, CEIL(100-(p.oferta_precio*100/p.precio)) as porcentaje,oferta_existencia_estado,oferta_existencia,existencia_estado,existencia,e.nombre as empresa,g.archivo from  ".PRODUCTOS." p  left join ".GALERIA_IMAGENES." g on p.id_galeria=g.id_galeria left join ".EMPRESAS." e on p.id_empresa=e.id_empresa left join ".ALMACEN_PRODUCTOS." ap on ap.id_producto=p.id_producto where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' and ap.id_almacen=$almacen $busqueda group by p.id_producto ";
           
         $qid = $this->db->query($sql);
         return $this->db->result_array($qid);
	}
	

}

?>