<?php
/**
 * OfertaController
 * 
 */
class ConfigController extends AbstractController
{    
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
     * Redirige solicitud de busqueda de listado de ofertasdependiendo de los atributos
     * Retorna listado completo si no hay parametros
     * http://oferto.co/app/oferta/lista/
     */
     
    protected function versiones($atributos=array())
    {
    	$sql='';
      $busqueda='';

      $tipo=$this->lib->nvl($atributos['tipo'],0);
     
      if($tipo!='')
        $busqueda="  where tipo='$tipo' ";

         $sql = "select * from version $busqueda ";
    		 $qid = $this->db->query($sql);
         if($tipo){
          $result =$this->db->fetch_array($qid);
          $respuesta=  array();

          $respuesta['tipo'] = $result['tipo'];
          $respuesta['actualizado'] = $result['actualizado'];
         }
         else{
          $result =$this->db->result_array($qid);
          $respuesta=  (object) array();
        
          foreach ($result as $row) {
             $respuesta -> $row['tipo'] = $row['actualizado'];
          }
         
         }
    		return $respuesta;
     }
     
     /**
      * Lista Ofertas activas en la ubicacion (idpais_iddpto_idciudad)
      * 
      */
      
     protected function localidades($atributos=array())
     {  
     	$busq='';
       $respuesta=  (object) array(); 
    	 $sqlPaises = "select * from paises";
       $qidPaises = $this->db->query($sqlPaises);
       $resultPaises =$this->db->result_array($qidPaises);
       $respuesta-> paises= $resultPaises;  

       $sqlDptos = "select  p.nombre, p.id_pais,p.bnombre, d.* from dptos d JOIN paises p on d.id_pais=p.id_pais ";
       $qidDptos = $this->db->query($sqlDptos);
       $resultDptos =$this->db->result_array($qidDptos);
       $respuesta-> dptos= $resultDptos;   

       $sqlCiudades = "select p.nombre, p.id_pais,p.bnombre, d.dpto, d.id_dpto,d.bdpto,c.* from ciudades c JOIN dptos d on c.id_dpto=d.id_dpto JOIN paises p on d.id_pais=p.id_pais ";
       $qidCiudades = $this->db->query($sqlCiudades);
       $resultCiudades =$this->db->result_array($qidCiudades);
       $respuesta-> ciudades= $resultCiudades;   
         
        return $respuesta;
    }
     

         
       /**
         * Lista contenidos de oferto.co
         * Sobre oferto.co, Condiciones de uso, Politica de privacidad
         * http://oferto.co/app/oferta/contenidos/
         */
         
       protected function contenidos($atributos)
       {
        $respuesta= array();
        if(!$this->lib->nvl($atributos['id'],0))
          return 'Formato incorrecto en obtener';
        
        $id=$atributos['id'];
       	$sql = "select id_contenido,titulo,contenido from contenidos where id_contenido=".$id;
        $qid = $this->db->query($sql);
        $row =$this->db->fetch_array($qid);
       
        $respuesta['id']=$row['id_contenido'];
        $respuesta['titulo']=$row['titulo'];
        $respuesta['contenido']=$this->lib->fullUrl($row['contenido'],'oferto.co'); 
           
           return $respuesta;
        }
        


  protected function categorias($atributos=array()){
    $busq='';
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
       

    //$sql = "select c.* from  core_categorias c join core_empresas  e on c.id_categoria=e.id_categoria group by c.id_categoria ";
    $sql="select c.id_categoria,c.categoria, count(DISTINCT p.id_producto) as cantidad from  core_categorias  c join core_empresas  e on e.id_categoria=c.id_categoria left join productos p on p.id_empresa=e.id_empresa  left join almacen_productos ap on ap.id_producto=p.id_producto left join almacenes a on ap.id_almacen = a.id_almacen where  borrado='0' and p.estado<>'Inactivo' and oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and oferta_aprobada='Si' $busq group by c.id_categoria order by categoria";
         $qid = $this->db->query($sql);
         $result =$this->db->result_array($qid);
         $i=0;
         
         $respuesta=  (object) array();
        
         foreach ($result as $row) {
             $respuesta -> rows[$i]['id'] = $row['id_categoria'];
             $respuesta -> rows[$i]['categoria'] = $row['categoria'];
             $respuesta -> rows[$i]['cantidad'] = $row['cantidad'];
             $i++;
         }
        
        return $respuesta;       
     }

    protected function redes($atributos=array()){
    $sql = "select tipo,valor from  core_config where id_config=4 or  id_config=5 or  id_config=8 order by id_config ";
         $qid = $this->db->query($sql);
         $result =$this->db->result_array($qid);
         $i=0;
         
         $respuesta=  (object) array();
        
         foreach ($result as $row) {
          if($row['valor']!=''){
             $respuesta -> rows[$i]['nombre'] = $row['tipo'];
             $respuesta -> rows[$i]['valor'] = $row['valor'];
             $i++;
           }
         }
        
        return $respuesta;       
     }
       
}