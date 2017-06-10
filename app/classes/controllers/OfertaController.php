<?php
/**
 * OfertaController
 * 
 */
class OfertaController extends AbstractController{    
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */
    public function get($request) {
      $llave=$this->llave;
      switch (count($request->url_elements)) {
        case 1:
        return 'Solicitud desconocida';
        break;
        default:
        $funcion=$request->url_elements[1];

        $firma=$funcion;
        $hash='';
        foreach ($request->parameters as $key=>$value) {
         if($key!='ruta')
          $firma.=$value;
      } 

      if($hash=$this->lib->nvl($request->url_elements[3]));
      else
        return 'No se pudo verificar acceso ';

      $firma.=$llave;
      $nhash= hash_hmac('sha1', $firma, $llave);
      if($nhash==$hash)  {
        if(method_exists($this,$funcion) ) 
          return $this->$funcion($request->parameters);                 
        else
          return 'Solicitud desconocida';
      }
      else
               return 'No se pudo verificar acceso ';//.$firma.' - '.$nhash;  

             break;
           }
         }

    /**
     * POST action.
     *
     * @param  $request
     * @return null
     */
    public function post($request){
      $llave=$this->llave;
      switch (count($request->url_elements)) {
        case 1:
        return 'Solicitud desconocida';
        break;
        default:
        $funcion=$request->url_elements[1];
        $firma=$funcion;
        $hash='';
        foreach ($request->parameters as $key=>$value) {
         if($key!='ruta')
          $firma.=$value;
      } 
      if($hash=$this->lib->nvl($request->url_elements[3]));
      else
        return 'No se pudo verificar acceso ';
      $firma.=$llave;
      $nhash= hash_hmac('sha1', $firma, $llave);
      if($nhash==$hash)  {
        $funcion='post_'.$funcion;
        if(method_exists($this,$funcion)) 
          return $this->$funcion($request->parameters);                 
        else
         return 'Solicitud desconocida';
     }
     else
       return 'No se pudo verificar acceso ';//.$firma.' - '.$nhash; 

     break;
   }
 }

    /**
     * Redirige solicitud de busqueda de listado de ofertas dependiendo de los atributos
     * Retorna listado completo si no hay parametros
     * http://oferto.co/app/oferta/lista/
     */

    protected function lista($atributos=array()){
      $sql='';
      $bubicacion='';
      $busqueda='';
      $brango='';
      $orden='';// mas adelante se toma de los filtros de la app

      $lenght=$this->lib->nvl($atributos['cantidad'],0);
      $start=$this->lib->nvl($atributos['pagina'],0);
      
      $search=$this->lib->nvl($atributos['busqueda'],0);
      $stemp=date("hi");
      $seed=$this->lib->nvl($atributos['seed'],$stemp);

      $orden=$this->lib->nvl($atributos['orden']);
      $rango=$this->lib->nvl($atributos['rango']);

      //$orden="rand($seed)";
      
      if($orden==''){
        $result_orden = $this->db->fetch_array($this->db->query("select valor from core_config where tipo ='ordenamiento'"));
        $ordenamiento=  $result_orden['valor'];
        if($ordenamiento=='')
          $ordenamiento='aleatorio';

        $a_orden=explode(' ',$ordenamiento);

        switch ($a_orden[0]) {
          case 'aleatorio':
           $orden="rand($seed)";
            break;
          case 'nombre':
            $orden=" IF(p.oferta_descripcion='', p.nombre, p.oferta_descripcion) ".$a_orden[1];
            break;
          default:
            $orden=$ordenamiento;
            break;
        }
      }

      if($search!=''){
        $key=trim($search);
        $key=strtolower($key);
        $sqlkey = "select * FROM keywords where keyword RLIKE '[[:<:]]".$key."'  order by keyword,id_keyword ";
        $lkeywords=$this->db->result_array( $this->db->query($sqlkey));

        $bkeywords='';
        if(count($lkeywords ) ){ 
          $busqk = "";
          foreach($lkeywords as $bkey){
            $busqk .= " or (k.id_keyword = ".$bkey['id_keyword'].")";
          } 
            $bkeywords .= " or (0 $busqk)";
        }
        $busqueda=" and (p.nombre RLIKE '[[:<:]]".$search."' OR p.descripcion RLIKE '[[:<:]]".$search."' OR p.oferta_descripcion RLIKE '[[:<:]]".$search."' $bkeywords) ";
      }
        

      $categoria=$this->lib->nvl($atributos['categoria'],0);
      if($categoria!='')
        $busqueda=" and e.id_categoria=$categoria ";

      if($rango!=''){
        $vrango=explode('_', $rango);
          $r1=$vrango[0];
          $r2=$vrango[1];
        if($r1!='undefined' and $r2!='undefined')
        $brango.=" and (p.oferta_precio >= $r1 and p.oferta_precio <= $r2 )";
      }

      if($this->lib->nvl($atributos['ubicacion'],0)){
        $ubicacion=explode('_',$atributos['ubicacion']);
        
        if(!count($ubicacion))
          return 'Formato incorrecto en ubicacion';
        return $this->ofertas_ubicacion($ubicacion,$start,$lenght,$busqueda,$orden,$brango);   
      }
      elseif ($this->lib->nvl($atributos['almacen'],0)) {
        return $this->ofertas_almacen($atributos['almacen'],$start,$lenght,$busqueda,$orden,$brango); 
      }
      else {
        $limite="";
        $total_paginas=0;
        if($lenght){
          $inicio= ($start - 1) * $lenght;
          $limite= "limit $inicio, $lenght";

          $sqlTotal = "select p.id_producto from productos p 
          left join core_empresas e on p.id_empresa=e.id_empresa
          left join producto_keywords k on k.id_producto=p.id_producto
          where oferta_portal='Activo'  and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE()  and borrado='0' and oferta_aprobada='Si' $busqueda $rango";
          $qidTotal = $this->db->query($sqlTotal);
          $total_registros =$this->db->num_rows($qidTotal);
          $total_paginas = ceil($total_registros / $lenght);
        }

        $sqlrango = "select p.oferta_precio from productos p 
        left join galeria_imagenes g on p.id_galeria=g.id_galeria  
        left join core_empresas e on p.id_empresa=e.id_empresa 
        left join producto_keywords k on k.id_producto=p.id_producto
        where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' $busqueda group by p.id_producto order by p.oferta_precio desc limit 1 ";
        $qidrango = $this->db->query($sqlrango);
        $rrango =$this->db->fetch_array($qidrango);
        if(isset($rrango['oferta_precio']))
          $margen_rango='0_'.$rrango['oferta_precio'];
        else
          $margen_rango='0_0';


        $sql = "select p.*,e.nombre as empresa,g.archivo, CEIL(100-(oferta_precio*100/precio)) as porcentaje from productos p 
        left join galeria_imagenes g on p.id_galeria=g.id_galeria  
        left join core_empresas e on p.id_empresa=e.id_empresa 
        left join producto_keywords k on k.id_producto=p.id_producto
        where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' $busqueda $rango group by p.id_producto order by $orden $limite ";
        $qid = $this->db->query($sql);
        $result =$this->db->result_array($qid);
        $i=0;

        $respuesta=  (object) array();
        
        foreach ($result as $row) {
        $oferta_existencia=0;
        $existencia=0;
       if($row['oferta_existencia_estado']=='1'){
         $oferta_existencia=$row['oferta_existencia'];
         $existencia=1;
        }
        elseif($row['existencia_estado']=='1'){
          $oferta_existencia=$row['existencia'];
          $existencia=1;
        }

         $respuesta -> rows[$i]['id'] = $row['id_producto'];
         $respuesta -> rows[$i]['nombre'] = ($row['oferta_descripcion']!='') ? $row['oferta_descripcion']:$row['nombre'];
         $respuesta -> rows[$i]['valor_normal'] = $row['precio'];
         $respuesta -> rows[$i]['valor_oferta'] = $row['oferta_precio'];
         $respuesta -> rows[$i]['empresa']= $row['empresa']; 
         $respuesta -> rows[$i]['porcentaje']= $row['porcentaje']; 
         $respuesta -> rows[$i]['oferta_existencia']= $oferta_existencia;   
         $respuesta -> rows[$i]['existencia']= $existencia;         
         $restante=$this->lib->resta_fechas ($row['oferta_vencimiento'],date('Y-m-d'));      
         $respuesta -> rows[$i]['vence'] = $restante;
         $imagen= ($row['oferta_imagen']!='') ? OFERTO.IMAGENES.'a'.$row['oferta_imagen']:(($row['archivo']!='') ? OFERTO.GALERIAS.'a'.$row['archivo']:'');
         if($imagen=='')
          $imagen= OFERTO.FILES.'producto.png';
        $respuesta->rows[$i]['imagen']=$imagen;
        $i++;
      }
      $respuesta -> total= count($result);
      $respuesta -> margen_rango= $margen_rango;

      $respuesta -> siguiente=(($start+1)<=$total_paginas) ? $start+1:0;
      return $respuesta;
    }


  }

     /**
      * Lista Ofertas activas en la ubicacion (idpais_iddpto_idciudad)
      * 
      */

     protected function ofertas_ubicacion($ubicacion,$start=0,$lenght=0,$busqueda="",$orden='',$brango='')
     {  
      $busq='';
      $pais= $this->lib->nvl($ubicacion[0],0);
      $dpto= $this->lib->nvl($ubicacion[1],0);
      $ciudad= $this->lib->nvl($ubicacion[2],0);
      
      if($pais)
        $busq.=' and a.id_pais='.$pais;
      if($dpto)
        $busq.=' and a.id_dpto='.$dpto;
      if($ciudad)
        $busq.=' and a.id_ciudad='.$ciudad;

      $limite="";
      $total_paginas=0;
      if($lenght){
        $inicio= ($start - 1) * $lenght;
        $limite= "limit $inicio, $lenght";

        $sqlTotal = "select p.id_producto from productos p  
        left join core_empresas e on p.id_empresa=e.id_empresa 
        left join producto_keywords k on k.id_producto=p.id_producto
        left join almacen_productos ap on ap.id_producto=p.id_producto 
        left join almacenes a on ap.id_almacen = a.id_almacen  
        where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' $busq $busqueda $brango group by p.id_producto";
        $qidTotal = $this->db->query($sqlTotal);
        $total_registros =$this->db->num_rows($qidTotal);
        $total_paginas = ceil($total_registros / $lenght);
      }

       $ordenar="";
      if($orden!='')
        $ordenar=" order by $orden ";


       $sqlrango = "select p.oferta_precio from productos p 
      left join galeria_imagenes g on p.id_galeria=g.id_galeria 
      left join core_empresas e on p.id_empresa=e.id_empresa 
      left join producto_keywords k on k.id_producto=p.id_producto
      left join almacen_productos ap on ap.id_producto=p.id_producto 
      left join almacenes a on ap.id_almacen = a.id_almacen  
      where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' $busq $busqueda group by p.id_producto order by p.oferta_precio desc limit 1 ";
        $qidrango = $this->db->query($sqlrango);
        $rrango =$this->db->fetch_array($qidrango);
        if(isset($rrango['oferta_precio']))
          $margen_rango='0_'.$rrango['oferta_precio'];
        else
          $margen_rango='0_0';


      $sql = "select p.*,e.nombre as empresa,g.archivo, CEIL(100-(oferta_precio*100/precio)) as porcentaje  from productos p 
      left join galeria_imagenes g on p.id_galeria=g.id_galeria 
      left join core_empresas e on p.id_empresa=e.id_empresa 
      left join producto_keywords k on k.id_producto=p.id_producto
      left join almacen_productos ap on ap.id_producto=p.id_producto 
      left join almacenes a on ap.id_almacen = a.id_almacen  
      where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' $busq $busqueda $brango group by p.id_producto $ordenar $limite ";

      $qid = $this->db->query($sql);
      $result =$this->db->result_array($qid);
      $i=0;
      $respuesta=  (object) array();         
      foreach ($result as $row) {

        $oferta_existencia=0;
        $existencia=0;
       if($row['oferta_existencia_estado']=='1'){
         $oferta_existencia=$row['oferta_existencia'];
         $existencia=1;
        }
        elseif($row['existencia_estado']=='1'){
          $oferta_existencia=$row['existencia'];
          $existencia=1;
        }

       $respuesta -> rows[$i]['id'] = $row['id_producto'];
       $respuesta -> rows[$i]['nombre'] = ($row['oferta_descripcion']!='') ? $row['oferta_descripcion']:$row['nombre'];
       $respuesta -> rows[$i]['valor_normal'] = $row['precio'];
       $respuesta -> rows[$i]['valor_oferta'] = $row['oferta_precio'];
       $respuesta -> rows[$i]['empresa']= $row['empresa']; 
       $respuesta -> rows[$i]['porcentaje']= $row['porcentaje'];  
       $respuesta -> rows[$i]['oferta_existencia']= $oferta_existencia;      
       $respuesta -> rows[$i]['existencia']= $existencia;    
       $restante=$this->lib->resta_fechas ($row['oferta_vencimiento'],date('Y-m-d'));      
       $respuesta -> rows[$i]['vence'] = $restante;

       $imagen= ($row['oferta_imagen']!='') ? OFERTO.IMAGENES.'a'.$row['oferta_imagen']:(($row['archivo']!='') ? OFERTO.GALERIAS.'a'.$row['archivo']:'');
       if($imagen=='')
        $imagen= OFERTO.FILES.'producto.png';
      $respuesta->rows[$i]['imagen']=$imagen;
      $i++;
    }
    $respuesta -> total= count($result);
    $respuesta -> margen_rango= $margen_rango;
    $respuesta -> siguiente=(($start+1)<=$total_paginas) ? $start+1:0;
    return $respuesta;
  }



     /**
     * Lista ofertas que hay activas en un almacen
     */
     protected function ofertas_almacen($almacen,$start=0,$lenght=0, $busqueda="",$orden='',$brango='')
     {
      $limite="";
      $total_paginas=0;
      if($lenght){
        $inicio= ($start - 1) * $lenght;
        $limite= "limit $inicio, $lenght";

        $sqlTotal ="select p.id_producto from productos p 
        left join core_empresas e on p.id_empresa=e.id_empresa 
        left join producto_keywords k on k.id_producto=p.id_producto
        left join almacen_productos ap on ap.id_producto=p.id_producto 
        where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE()  and borrado='0' and oferta_aprobada='Si'  and ap.id_almacen=$almacen $busqueda $brango group by p.id_producto";
        $qidTotal = $this->db->query($sqlTotal);
        $total_registros =$this->db->num_rows($qidTotal);
        $total_paginas = ceil($total_registros / $lenght);
      }

       $sqlrango = "select p.oferta_precio from productos p 
      left join galeria_imagenes g on p.id_galeria=g.id_galeria  
      left join core_empresas e on p.id_empresa=e.id_empresa 
      left join producto_keywords k on k.id_producto=p.id_producto
      left join almacen_productos ap on ap.id_producto=p.id_producto 
      where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' and ap.id_almacen=$almacen $busqueda group by p.id_producto order by p.oferta_precio desc limit 1 ";
        $qidrango = $this->db->query($sqlrango);
        $rrango =$this->db->fetch_array($qidrango);
        if(isset($rrango['oferta_precio']))
          $margen_rango='0_'.$rrango['oferta_precio'];
        else
          $margen_rango='0_0';


    $ordenar="";
      if($orden!='')
        $ordenar=" order by $orden ";

      $sql = "select p.*,e.nombre as empresa,g.archivo, CEIL(100-(oferta_precio*100/precio)) as porcentaje   from productos p 
      left join galeria_imagenes g on p.id_galeria=g.id_galeria  
      left join core_empresas e on p.id_empresa=e.id_empresa 
      left join producto_keywords k on k.id_producto=p.id_producto
      left join almacen_productos ap on ap.id_producto=p.id_producto 
      where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' and ap.id_almacen=$almacen $busqueda $brango group by p.id_producto $ordenar $limite ";

      $qid = $this->db->query($sql);
      $result =$this->db->result_array($qid);
      $i=0;
      $respuesta=  (object) array();
      foreach ($result as $row) {
        $oferta_existencia=0;
        $existencia=0;
        $agotado='';
       if($row['oferta_existencia_estado']=='1'){
         $oferta_existencia=$row['oferta_existencia'];
         $existencia=1;
         if(!$row['oferta_existencia'])
                $agotado='AGOTADO';
        }
        elseif($row['existencia_estado']=='1'){
          $oferta_existencia=$row['existencia'];
          $existencia=1;
           if(!$row['existencia'])
               $agotado='AGOTADO';
        }


        $respuesta -> rows[$i]['id'] = $row['id_producto'];
        $nombre= ($row['oferta_descripcion']!='') ? $row['oferta_descripcion']:$row['nombre'];
        $nombre= (strlen($nombre)>28) ? substr($nombre, 0,28):$nombre;
        $respuesta -> rows[$i]['nombre'] =$nombre;

        $respuesta -> rows[$i]['valor_normal'] = $row['precio'];
        $respuesta -> rows[$i]['valor_oferta'] = $row['oferta_precio'];
        $respuesta -> rows[$i]['empresa']= $row['empresa']; 
        $respuesta -> rows[$i]['porcentaje']= $row['porcentaje']; 
        $respuesta -> rows[$i]['oferta_existencia']= $oferta_existencia;      
        $respuesta -> rows[$i]['existencia']= $existencia;    
         $respuesta -> rows[$i]['agotado']= $agotado;        
        $restante=$this->lib->resta_fechas ($row['oferta_vencimiento'],date('Y-m-d'));      
        $respuesta -> rows[$i]['vence'] = $restante;

        $imagen= ($row['oferta_imagen']!='') ? OFERTO.IMAGENES.'a'.$row['oferta_imagen']:(($row['archivo']!='') ? OFERTO.GALERIAS.'a'.$row['archivo']:'');
        if($imagen=='')
          $imagen= OFERTO.FILES.'producto.png';
        $respuesta->rows[$i]['imagen']=$imagen;
        $i++;
      }
      $respuesta -> total= count($result);
      $respuesta -> margen_rango=$margen_rango;
      $respuesta -> siguiente=(($start+1)<=$total_paginas) ? $start+1:0;
      return $respuesta;
    } 

    /**
      * Lista Ofertas consultadas 
      * ubicacion opcional(idpais_iddpto_idciudad)
      * 
      */

     public function ofertas_consultadas($atributos=array()){ 
       $sql='';
      $bubicacion='';
      $busqueda='';
      $brango='';
      $ubicacion=array();

      $lenght=$this->lib->nvl($atributos['cantidad'],0);
      $start=$this->lib->nvl($atributos['pagina'],0);
      $orden=$this->lib->nvl($atributos['orden']);
      $rango=$this->lib->nvl($atributos['rango']);

      if($rango!=''){
        $vrango=explode('_', $rango);
          $r1=$vrango[0];
          $r2=$vrango[1];
        if($r1!='undefined' and $r2!='undefined')
        $brango.=" and (p.oferta_precio >= $r1 and p.oferta_precio <= $r2 )";
      }
      
      if($orden==''){
        $orden='p.compras desc ';
      }
      if($this->lib->nvl($atributos['ubicacion'],0)){
        $ubicacion=explode('_',$atributos['ubicacion']);
        
        if(!count($ubicacion))
          return 'Formato incorrecto en ubicacion';
        else{
         
          $pais= $this->lib->nvl($ubicacion[0],0);
          $dpto= $this->lib->nvl($ubicacion[1],0);
          $ciudad= $this->lib->nvl($ubicacion[2],0);
          
          if($pais)
            $bubicacion.=' and a.id_pais='.$pais;
          if($dpto)
            $bubicacion.=' and a.id_dpto='.$dpto;
          if($ciudad)
            $bubicacion.=' and a.id_ciudad='.$ciudad;
        }
      }

      $limite="";
      $total_paginas=0;
      if($lenght){
        $inicio= ($start - 1) * $lenght;
        $limite= "limit $inicio, $lenght";

        $sqlTotal = "select p.id_producto from productos p  left join core_empresas e on p.id_empresa=e.id_empresa left join almacen_productos ap on ap.id_producto=p.id_producto left join almacenes a on ap.id_almacen = a.id_almacen  where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' and p.compras<>0 $bubicacion $busqueda $brango group by p.id_producto order by $orden";
        $qidTotal = $this->db->query($sqlTotal);
        $total_registros =$this->db->num_rows($qidTotal);
        $total_paginas = ceil($total_registros / $lenght);
      }
       $sqlrango = "select p.oferta_precio from productos p 
      left join galeria_imagenes g on p.id_galeria=g.id_galeria 
      left join core_empresas e on p.id_empresa=e.id_empresa 
      left join almacen_productos ap on ap.id_producto=p.id_producto 
      left join almacenes a on ap.id_almacen = a.id_almacen  
      where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' and  p.compras<>0 $bubicacion $busqueda group by p.id_productoorder by p.oferta_precio desc limit 1 ";
        $qidrango = $this->db->query($sqlrango);
        $rrango =$this->db->fetch_array($qidrango);
        if(isset($rrango['oferta_precio']))
          $margen_rango='0_'.$rrango['oferta_precio'];
        else
          $margen_rango='0_0';


      $sql = "select p.*,e.nombre as empresa,g.archivo, CEIL(100-(oferta_precio*100/precio)) as porcentaje  from productos p 
      left join galeria_imagenes g on p.id_galeria=g.id_galeria 
      left join core_empresas e on p.id_empresa=e.id_empresa 
      left join almacen_productos ap on ap.id_producto=p.id_producto 
      left join almacenes a on ap.id_almacen = a.id_almacen  
      where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' and  p.compras<>0 $bubicacion $busqueda $brango group by p.id_producto order by $orden $limite ";

      $qid = $this->db->query($sql);
      $result =$this->db->result_array($qid);
      $i=0;
      $respuesta=  (object) array();         
      foreach ($result as $row) {
        $oferta_existencia=0;
        $existencia=0;
       if($row['oferta_existencia_estado']=='1'){
         $oferta_existencia=$row['oferta_existencia'];
         $existencia=1;
        }
        elseif($row['existencia_estado']=='1'){
          $oferta_existencia=$row['existencia'];
          $existencia=1;
        }

       $respuesta -> rows[$i]['id'] = $row['id_producto'];
       $respuesta -> rows[$i]['nombre'] = ($row['oferta_descripcion']!='') ? $row['oferta_descripcion']:$row['nombre'];
       $respuesta -> rows[$i]['valor_normal'] = $row['precio'];
       $respuesta -> rows[$i]['valor_oferta'] = $row['oferta_precio'];
       $respuesta -> rows[$i]['empresa']= $row['empresa']; 
       $respuesta -> rows[$i]['porcentaje']= $row['porcentaje'];
       $respuesta -> rows[$i]['oferta_existencia']= $oferta_existencia;       
       $respuesta -> rows[$i]['existencia']= $existencia;    
       $restante=$this->lib->resta_fechas ($row['oferta_vencimiento'],date('Y-m-d'));      
       $respuesta -> rows[$i]['vence'] = $restante;

       $imagen= ($row['oferta_imagen']!='') ? OFERTO.IMAGENES.'a'.$row['oferta_imagen']:(($row['archivo']!='') ? OFERTO.GALERIAS.'a'.$row['archivo']:'');
       if($imagen=='')
        $imagen= OFERTO.FILES.'producto.png';
      $respuesta->rows[$i]['imagen']=$imagen;
      $i++;
    }
    $respuesta -> total= count($result);
    $respuesta -> margen_rango=$margen_rango;
    $respuesta -> siguiente=(($start+1)<=$total_paginas) ? $start+1:0;
    return $respuesta;
  }
     
    
    /**
     * Obtiene información básica de la Oferta
     * http://oferto.co/app/oferta/obtener/id/XX
     */
    protected function obtener($atributos=array())
    {
      if(!$this->lib->nvl($atributos['id'],0))
        return 'Formato incorrecto en obtener';

      $id_usuario=$this->lib->nvl($atributos['id_usuario'],0);
      if($id_usuario =='')
        $id_usuario=0;
      


      $id_producto=$atributos['id'];
      $sql = "select p.*, CEIL(100-(p.oferta_precio*100/p.precio)) as porcentaje,e.id_empresa,e.nombre as empresa,e.telefono,e.movil,e.direccion,e.logo,e.pago_payu,e.payu_userid, e.payu_llave,e.payu_accountid,g.archivo,u.siguiendo from productos p 
      left join galeria_imagenes g on p.id_galeria=g.id_galeria  
      left join core_empresas e on p.id_empresa=e.id_empresa 
      left join (select * from usuario_empresa where id_usuario=$id_usuario and siguiendo='1') u on e.id_empresa=u.id_empresa  
      where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' and p.id_producto=$id_producto group by p.id_producto";
      $qid = $this->db->query($sql);
      $row =$this->db->fetch_array($qid);

      $promedio=0;
      if($row['id_producto']){
        $ppromedio= $this->db->fetch_array($this->db->query("select avg(calificacion) as promedio from productos_calificacion where id_producto = $id_producto "));
        $promedio=$this->lib->nvl($ppromedio['promedio'],0);
        if($promedio)
          $promedio= round($promedio,2);
      }

      $oferta_existencia=0;
      $existencia=0;
       if($row['oferta_existencia_estado']=='1'){
         $oferta_existencia=$row['oferta_existencia'];
         $existencia=1;
        }
        elseif($row['existencia_estado']=='1'){
          $oferta_existencia=$row['existencia'];
          $existencia=1;
        }
      
      $respuesta['id'] = $row['id_producto'];
      $respuesta['nombre'] = ($row['oferta_descripcion']!='') ? $row['oferta_descripcion']:$row['nombre'];
      $respuesta['descripcion'] = $row['descripcion'];
      $respuesta['detalles'] = $this->lib->fullUrl($row['detalles'],'oferto.co');
      $respuesta['terminos'] = $row['oferta_terminos'];
      $respuesta['valor_normal'] = $row['precio'];
      $respuesta['valor_oferta'] = $row['oferta_precio'];
      $respuesta['porcentaje'] = $row['porcentaje'];
      $respuesta['oferta_existencia']=$oferta_existencia; 
      $respuesta['existencia']=$existencia; 
      $restante=$this->lib->resta_fechas ($row['oferta_vencimiento'],date('Y-m-d')); 
       $respuesta['oferta_vencimiento'] = $row['oferta_vencimiento'];    
      $respuesta['vence'] = $restante;
      $respuesta['siguiendo']= ($row['siguiendo']!=1) ? 0:1; 
      $respuesta['enlacecompra']='http://oferto.co/main-registro-comprar-'.$row['id_producto'];
     
      $imagen= ($row['oferta_imagen']!='') ? OFERTO.IMAGENES.'a'.$row['oferta_imagen']:(($row['archivo']!='') ? OFERTO.GALERIAS.'a'.$row['archivo']:'');
      if($imagen=='')
        $imagen= OFERTO.FILES.'producto.png';
      $respuesta['imagen']=$imagen;
      
      $imagenb= ($row['oferta_imagen']!='') ? OFERTO.IMAGENES.'b'.$row['oferta_imagen']:(($row['archivo']!='') ? OFERTO.GALERIAS.'b'.$row['archivo']:'');
      if($imagenb=='')
        $imagenb= OFERTO.FILES.'producto.png';
      $respuesta['imagenb']=$imagenb;

      $respuesta['id_empresa']=$row['id_empresa'];
      $respuesta['empresa']=$row['empresa'];
      $respuesta['logo']=($row['logo']!='') ? OFERTO.EMPRESAS.'s'.$row['logo']:'';
      $respuesta['movil']=$row['movil'];

      if($row['pago_payu']=='1' and $row['payu_userid']!='' and $row['payu_llave']!='' and $row['payu_accountid']!='')
        $respuesta['txt_comprar']='COMPRAR';
      else
        $respuesta['txt_comprar']='RESERVAR';

      $respuesta['promedio']=$promedio;

      $almacen=  array();
      $distancia="";
      $ordend="";
      if($this->lib->nvl($atributos['ubicacion'],0)){
        $location=explode("_",$atributos['ubicacion']);
        if(count($location)<2)
          return 'Formato incorrecto en obtener, location';

          /*To search by kilometers instead of miles, replace 3959 with 6371.
          "SELECT id_almacen( 3959 * acos( cos( radians(".$location[0].") ) * cos( radians( latitud ) ) * cos( radians( longitud ) - radians(".$location[1].") ) + sin( radians(".$location[0].") ) * sin( radians( latitud ) ) ) ) AS distance 
              FROM almacenes HAVING distance < 25 ORDER BY distance LIMIT 0 , 20;"
          */
              $distancia=", ( 3959 * acos( cos( radians(".$location[0].") ) * cos( radians( latitud ) ) * cos( radians( longitud ) - radians(".$location[1].") ) + sin( radians(".$location[0].") ) * sin( radians( latitud ) ) ) ) AS distance ";
              $ordend="ORDER BY distance";  
        } 
        
        $sql = "SELECT a.id_almacen, a.nombre,a.direccion,a.telefono,a.movil,a.ubicacion $distancia
            FROM almacen_productos ap join  productos p on ap.id_producto=p.id_producto join almacenes a on ap.id_almacen = a.id_almacen where p.oferta_portal='Activo'  and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE()  and borrado='0' and oferta_aprobada='Si' and ap.id_producto=$id_producto $ordend LIMIT 1";

        $qid = $this->db->query($sql);
        $rowalm =$this->db->fetch_array($qid);
        $respuesta['almacen']=$this->lib->nvl($rowalm['id_almacen'],0);
        $respuesta['direccion']=($this->lib->nvl($rowalm['direccion'],0))? $rowalm['direccion']:$row['direccion'];
        $respuesta['telefono']=($this->lib->nvl($rowalm['telefono'],0))? $rowalm['telefono']:$row['telefono'];
        $respuesta['movil']=($this->lib->nvl($rowalm['movil'],0))? $rowalm['movil']:$row['movil'];

        $respuesta['adicionales']=array();

        $sqladic = "select a.*,p.id_producto FROM  adicionales a left join adicionales_producto p on a.id_adicional=p.id_adicional where p.id_producto= $id_producto order by a.id_adicional";
    
        $adicionales=$this->db->result_array( $this->db->query($sqladic)); 
        $p=0;
        foreach ($adicionales as $adicional){ 
          if($adicional['id_adicional']){
            $respuesta['adicionales'][$p]=$adicional;
            $respuesta['adicionales'][$p]['opciones']=array();
            
            $sqlopc = "select d.*  FROM adicional_opciones as d  where id_adicional= ".$adicional['id_adicional']." order by id_adicional_opcion";
            $respuesta['adicionales'][$p]['opciones']=$this->db->result_array( $this->db->query($sqlopc)); 
            $p++;
          }
        }   



            return $respuesta;
          }

       /* 
       * Obtiene galeria de una oferta
       * http://oferto.co/app/oferta/galeria/id/XX
       */
       protected function galeria($atributos=array())
       {
        if(!$this->lib->nvl($atributos['id'],0))
          return 'Formato incorrecto en galeria';

        $id_producto=$atributos['id'];
        $sql = "select g.archivo from productos p left join galeria_imagenes g on p.id_galeria=g.id_galeria where p.oferta_portal='Activo'  and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' and p.id_producto=$id_producto";
        $qid = $this->db->query($sql);
        $result =$this->db->result_array($qid);
        $i=0;
        $respuesta=  (object) array();
        foreach ($result as $row) {
          $respuesta->rows[$i]['imagen']=OFERTO.GALERIAS.'a'.$row['archivo'];              
          $i++;
        }                    
        return $respuesta;
      }


      /**
     * Redirige solicitud de busqueda de listado de almacenes dependiendo de los atributos
     * Retorna listado completo si no hay parametros
     * http://oferto.co/app/oferta/almacenes/
     * boundaries/4.528_-75.74_4.568_-75.589
     * ubicacion/1_26_63
     * oferta/16
     */

      protected function almacenes($atributos=array())
      {
        $boundaries=array();

        if($this->lib->nvl($atributos['boundaries'],0)){
          $boundaries=explode('_',$atributos['boundaries']);
          if(count($boundaries)<4)
            return 'Formato incorrecto en Boundaries';
        }

        if($this->lib->nvl($atributos['ubicacion'],0)){
          $ubicacion=explode('_',$atributos['ubicacion']);

          if(!count($ubicacion))
            return 'Formato incorrecto en ubicacion';
          return $this->almacenes_ubicacion($ubicacion,$boundaries);  
        }
        elseif ($this->lib->nvl($atributos['oferta'],0)) {
          return $this->almacenes_oferta($atributos['oferta'],$boundaries); 
        }
        else {
          $busq='';
          if (count($boundaries)) {
            $s =  $boundaries[0];
            $w =  $boundaries[1];
            $n =  $boundaries[2];
            $e =  $boundaries[3];
            $busq.=" and (a.latitud > $s and a.latitud<$n and a.longitud > $w and longitud < $e) ";
          }

          $sql = "select a.id_almacen,a.nombre as almacen,a.direccion,a.ubicacion,a.latitud,a.longitud from productos p join almacen_productos ap on ap.id_producto=p.id_producto left join almacenes a on ap.id_almacen = a.id_almacen  where p.oferta_portal='Activo'  and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' $busq group by a.id_almacen ";

          $qid = $this->db->query($sql);
          $result =$this->db->result_array($qid);
          $i=0;
          $respuesta=  (object) array();
          foreach ($result as $row) {
            $respuesta->rows[$i]['id']=$row['id_almacen'];
            $respuesta->rows[$i]['almacen']=$row['almacen'];
            $respuesta->rows[$i]['direccion']=$row['direccion'];
            $respuesta->rows[$i]['ubicacion']=$row['ubicacion'];
            $respuesta->rows[$i]['latitud']=$row['latitud'];
            $respuesta->rows[$i]['longitud']=$row['longitud'];
            $i++;
          }       
          return $respuesta;
        }
      }


       /**
       * Lista almacenes en que están en una ubicacion (idpais_iddpto_idciudad)
       */
       protected function almacenes_ubicacion($ubicacion,$boundaries=array())
       {
        $busq='';
        if (count($boundaries)) {
          $s =  $boundaries[0];
          $w =  $boundaries[1];
          $n =  $boundaries[2];
          $e =  $boundaries[3];
          $busq.=" and (a.latitud > $s and a.latitud<$n and a.longitud > $w and longitud < $e) ";
        }
        

        $pais= $this->lib->nvl($ubicacion[0],0);
        $dpto= $this->lib->nvl($ubicacion[1],0);
        $ciudad= $this->lib->nvl($ubicacion[2],0);
        
        if($pais)
          $busq.=' and a.id_pais='.$pais;
        if($dpto)
          $busq.=' and a.id_dpto='.$dpto;
        if($ciudad)
          $busq.=' and a.id_ciudad='.$ciudad;


        $sql = "select a.id_almacen,a.nombre as almacen,a.direccion,a.ubicacion,a.latitud,a.longitud from productos p join almacen_productos ap on ap.id_producto=p.id_producto left join almacenes a on ap.id_almacen = a.id_almacen  where p.oferta_portal='Activo'  and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE()  and borrado='0' and oferta_aprobada='Si' $busq group by a.id_almacen ";

        $qid = $this->db->query($sql);
        $result =$this->db->result_array($qid);
        $i=0;
        $respuesta=  (object) array();
        foreach ($result as $row) {
         $respuesta->rows[$i]['id']=$row['id_almacen'];
         $respuesta->rows[$i]['almacen']=$row['almacen'];
         $respuesta->rows[$i]['direccion']=$row['direccion'];
         $respuesta->rows[$i]['ubicacion']=$row['ubicacion'];
         $respuesta->rows[$i]['latitud']=$row['latitud'];
         $respuesta->rows[$i]['longitud']=$row['longitud'];
         $i++;
       }
       return $respuesta;
     }

       /**
        * Lista almacenes en que esta activa una oferta
        * 
        */

       protected function almacenes_oferta($oferta,$boundaries=array())
       {
        $busq="";
        if (count($boundaries)) {
          $s =  $boundaries[0];
          $w =  $boundaries[1];
          $n =  $boundaries[2];
          $e =  $boundaries[3];
          $busq.=" and (a.latitud > $s and a.latitud<$n and a.longitud > $w and longitud < $e) ";
        }
        
        $sql = "select a.id_almacen,a.nombre as almacen,a.direccion,a.ubicacion,a.latitud,a.longitud from almacen_productos ap left join  productos p on ap.id_producto=p.id_producto left join almacenes a on ap.id_almacen = a.id_almacen where p.oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE()  and oferta_aprobada='Si' and borrado='0' $busq and ap.id_producto=$oferta ";

        $qid = $this->db->query($sql);
        $result =$this->db->result_array($qid);
        $i=0;
        $respuesta=  (object) array();
        foreach ($result as $row) {
          $respuesta->rows[$i]['id']=$row['id_almacen'];
          $respuesta->rows[$i]['almacen']=$row['almacen'];
          $respuesta->rows[$i]['direccion']=$row['direccion'];
          $respuesta->rows[$i]['ubicacion']=$row['ubicacion'];
          $respuesta->rows[$i]['latitud']=$row['latitud'];
          $respuesta->rows[$i]['longitud']=$row['longitud'];
          $i++;
        }
        return $respuesta;
      }

/**
 * Devuelve lista de ofertas que están por vencerse dada una lista de ofertas (favoritos)
 * http://oferto.co/app/oferta/alertas/favoritos/12_11_10
 * Opcional /d/4 para determinar el número de dias
 */

protected function alertas($atributos=array())
{
  $sql='';
  $busq='';
  
  if($this->lib->nvl($atributos['favoritos'],0)){
    $favoritos=explode('_',$atributos['favoritos']);

    if(!count($favoritos))
      return 'Formato incorrecto en Alertas';

    $i=0;
    $busq=" and (0 ";
      for ($i = 0; $i < count($favoritos); $i++) {
        $busq.=" or id_producto=".$favoritos[$i];
      }
      $busq.=" )";
$sql = "select p.*, g.archivo from productos p left join galeria_imagenes g on p.id_galeria=g.id_galeria  where oferta_portal='Activo'  and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE()  and borrado='0' and oferta_aprobada='Si' $busq group by p.id_producto";

$qid = $this->db->query($sql);
$result =$this->db->result_array($qid);

$i=0;
$dias=$this->lib->nvl($atributos['d'],1);
$respuesta=  (object) array();

foreach ($result as $row) {
 $restante=$this->lib->resta_fechas ($row['oferta_vencimiento'],date('Y-m-d')); 
 if($restante>0 and $restante<=$dias){
   $respuesta -> rows[$i]['id'] = $row['id_producto'];
   $respuesta -> rows[$i]['nombre'] =($row['oferta_descripcion']!='') ? $row['oferta_descripcion']:$row['nombre'];
   $respuesta -> rows[$i]['valor_normal'] = $row['precio'];
   $respuesta -> rows[$i]['valor_oferta'] = $row['oferta_precio'];
   $respuesta -> rows[$i]['existencia']= $row['existencia'];        
   $respuesta -> rows[$i]['vence'] = $restante;
   $imagen= ($row['oferta_imagen']!='') ? OFERTO.IMAGENES.'a'.$row['oferta_imagen']:(($row['archivo']!='') ? OFERTO.GALERIAS.'a'.$row['archivo']:'');
   if($imagen=='')
    $imagen= OFERTO.FILES.'producto.png';
  $respuesta->rows[$i]['imagen']=$imagen;
  $i++;
}
}
return $respuesta;
}

}

    /**
     * Verifica que una oferta aun este activa
     * http://oferto.co/app/oferta/obtener_estado/id/XX
     */
    protected function obtener_estado($atributos=array())
    {
      if(!$this->lib->nvl($atributos['id'],0))
        return 'Formato incorrecto en obtener';
      $id_producto=$atributos['id'];
      $sql = "select id_producto from productos where oferta_portal='Activo' and oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' and id_producto=$id_producto";
      $qid = $this->db->query($sql);
      $cant =$this->db->num_rows($qid);

        return $cant;
    }

    public function post_sugerencias($atributos=array()){
      $sql='';
      $busq='';
      $separador='?';

      $texto=$this->lib->nvl($atributos['texto'],0);

      if($this->lib->nvl($atributos['ubicacion'],0)){
        $ubicacion=explode('_',$atributos['ubicacion']);
      
        if(!count($ubicacion))
          return 'Formato incorrecto en ubicacion';
        else{
          $pais= $this->lib->nvl($ubicacion[0],0);
          $dpto= $this->lib->nvl($ubicacion[1],0);
          $ciudad= $this->lib->nvl($ubicacion[2],0);
        
          if($pais)
            $busq.=' and a.id_pais='.$pais;
          if($dpto)
            $busq.=' and a.id_dpto='.$dpto;
          if($ciudad)
            $busq.=' and a.id_ciudad='.$ciudad;

          $limite="";
        }
      }

      if($this->lib->nvl($atributos['separador'],0))
        $separador=$atributos['separador'];

      $l_categorias = array();
      $l_productos = array();
      $sugerencias='';
      if(strlen($texto)>2){

        $sqlcat = "select c.id_categoria,c.categoria, count(p.id_producto) as cantidad from  core_categorias  c join core_empresas  e on e.id_categoria=c.id_categoria left join productos p on p.id_empresa=e.id_empresa  left join almacen_productos ap on ap.id_producto=p.id_producto left join almacenes a on ap.id_almacen = a.id_almacen where  c.categoria like '%$texto%' and borrado='0' and p.estado<>'Inactivo' and oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and oferta_aprobada='Si' $busq group by c.id_categoria order by categoria";
        $l_categorias=$this->db->result_array( $this->db->query($sqlcat) );


        $key=trim($texto);
        $key=strtolower($key);
        $sqlkey = "select * FROM keywords where keyword RLIKE '[[:<:]]".$key."'  order by keyword,id_keyword ";
        $lkeywords=$this->db->result_array( $this->db->query($sqlkey));

        $bkeywords='';
        if(count($lkeywords ) ){ 
          $busqk = "";
          foreach($lkeywords as $bkey){
            $busqk .= " or (k.id_keyword = ".$bkey['id_keyword'].")";
          } 
            $bkeywords .= " or (0 $busqk)";
        }


        $and = " and  p.borrado='0' and p.estado<>'Inactivo' and p.oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and p.oferta_vencimiento > CURDATE() and oferta_aprobada='Si' " ;
        

        $sql= "SELECT DISTINCT p.*
              FROM productos p
              left join core_empresas e on p.id_empresa=e.id_empresa 
              left join almacen_productos ap on ap.id_producto=p.id_producto 
              left join producto_keywords k on k.id_producto=p.id_producto
              left join almacenes a on ap.id_almacen = a.id_almacen 
          WHERE  (p.nombre RLIKE '[[:<:]]".$texto."' OR p.descripcion RLIKE '[[:<:]]".$texto."' OR p.oferta_descripcion RLIKE '[[:<:]]".$texto."' OR e.nombre RLIKE '[[:<:]]".$texto."' $bkeywords)  $and $busq 
          GROUP BY p.id_producto
          ORDER BY p.id_producto DESC";
  
      $l_productos= $this->db->result_array( $this->db->query($sql) ); 
        foreach($l_categorias as $categoria){
            $sugerencias.='<li><a href="listado.html'.$separador.'categoria='.$categoria['id_categoria'].'">'.$categoria['categoria'].' ('.$categoria['cantidad'].')</a></li>';
        }

        foreach($l_productos as $producto){
          $nombre=($producto['oferta_descripcion']!='') ? $producto['oferta_descripcion']:$producto['nombre'];
         
          $sugerencias.='<li><a href="item.html'.$separador.'id='.$producto['id_producto'].'">'.$nombre.'</a></li>';
        }
      }


      $i=0;

      $respuesta=  array();

      $respuesta['error']= 0;
      $respuesta['cantidad']= count($l_categorias)+count($l_productos);
      $respuesta['sugerencias']=$sugerencias;
    return $respuesta;



  }
}