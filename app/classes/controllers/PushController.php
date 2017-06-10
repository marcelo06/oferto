<?php
/**
 * OfertaController
 * 
 */
class PushController extends AbstractController
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
        if($funcion=='coordenadas'){
           return $this->$funcion($request->parameters);
        }
        else{
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
        }
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
        if($funcion=='coordenadas'){
         return   $this->$funcion($request->parameters);
        }
        else{
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
        if(method_exists($this,$funcion) ) 
          return $this->$funcion($request->parameters);                 
        else
         return 'Solicitud desconocida';
     }
     else
       return 'No se pudo verificar acceso ';//.$firma.' - '.$nhash; 
}
     break;
   }
    }



    /**
     * Solicitud de envio de PUSH desde oferto.co 
     * Retorna informacion del envio de push en Android y IOS
     * http://oferto.co/app/push/nueva_oferta/ por POST
     * Pre post_ se obvia en el llamado 
     */

    protected function post_nueva_oferta($atributos=array()){
      $respuesta=  array();
  
      if(!$this->lib->nvl($atributos['id_producto'],0))
        return $respuesta['error']='No se encontró identificador';

        $id_producto=$atributos['id_producto'];
        $sql = "select p.*,e.id_empresa,e.nombre as empresa from productos p left join core_empresas e on p.id_empresa=e.id_empresa  where oferta_portal='Activo' and p.oferta_publicacion <= CURDATE() and oferta_vencimiento > CURDATE() and borrado='0' and oferta_aprobada='Si' and p.id_producto=$id_producto group by p.id_producto";
        $qid = $this->db->query($sql);
        $row =$this->db->fetch_array($qid);
        $nombre= ($row['oferta_descripcion']!='') ? $row['oferta_descripcion'] : $row['nombre'];

        $titulo=$row['nombre'];
        $mensaje='Nueva oferta de '.$row['empresa'].' en OFERTO.CO';

        //Obtener REGIDs para Android
        $sql = "select regid,a.id_usuario from app_regid a left join usuario_empresa u on a.id_usuario=u.id_usuario where a.notificaciones='Si' and u.id_empresa=".$row['id_empresa'];
        $qid = $this->db->query($sql);
        $rreg=$this->db->result_array($qid);
        $ids=array();
        foreach ($rreg as $rid) {
         $ids[]=$rid['regid'];
        }
        //Obtener TOKENs para IOS
        $sql = "select token,a.id_usuario from app_token a left join usuario_empresa u on a.id_usuario=u.id_usuario where a.notificaciones='Si' and u.id_empresa=".$row['id_empresa'];
        $qid = $this->db->query($sql);
        $rtoken =$this->db->result_array($qid);
        $tids=array();
        foreach ($rtoken as $tid) {
         $tids[]=$tid['token'];
        }

        //Obtener URLS para WP
      /*  $sql = "select uri,a.id_usuario from app_uri a left join usuario_empresa u on a.id_usuario=u.id_usuario where a.notificaciones='Si' and u.id_empresa=".$row['id_empresa'];
        $qid = $this->db->query($sql);
        $ruri =$this->db->result_array($qid);
        $uids=array();
        foreach ($ruri as $uid) {
         $uids[]=$uid['uri'];
        }*/

        $respuesta=  (object) array();
        //Android
        if(count($ids))
          $respuesta -> rows['gcm']=$this->gcm($titulo,$mensaje,$ids,'ver_producto',$id_producto);
        else
           $respuesta -> rows['gcm']='No se encontraron dispositivos';
        //IOS
        if(count($tids))
          $respuesta -> rows['apns']=$this->apns($titulo.', '.$mensaje,$tids,$id_producto);
        else
           $respuesta -> rows['apns']='No se encontraron dispositivos';

         //WP
       /* if(count($uids))
          $respuesta -> rows['mpns']=$this->mpns($titulo,$mensaje,$uids,$id_producto);
        else
           $respuesta -> rows['mpns']='No se encontraron dispositivos';*/
           
        return $respuesta;
    }  

    /**
     * Solicitud de envio PUSH por Google Cloud Messages
     * Retorna informacion del envio del push
     */

    protected function gcm($titulo,$mensaje,$ids,$accion='',$idaccion=''){
      $respuesta=  array();

      $data = array( 'title' => $titulo,'message' => $mensaje,'accion' => $accion,'id_accion' => $idaccion );

      $apiKey = 'AIzaSyD6Yonas-1sJXSFNZudeZmCKgJoGDXhF_Q';//AIzaSyDQYrlQAJ0VxDyELYyLnWnMqm86BHScx8c
      $url = 'https://android.googleapis.com/gcm/send';

      $post = array(
                    'registration_ids'  => $ids,
                    'data'              => $data
                    );

      $headers = array( 
                        'Authorization: key='.$apiKey,
                        'Content-Type: application/json'
                    );

      $ch = curl_init();
      curl_setopt( $ch, CURLOPT_URL, $url );
      curl_setopt( $ch, CURLOPT_POST, true );
      curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );
      $respuesta['result'] = curl_exec( $ch );

      if ( curl_errno( $ch ) ){
        $respuesta['error'] ='GCM error: ' . curl_error( $ch );
      }

      curl_close( $ch );
      return $respuesta;
    }  


    /**
     * Solicitud de envio PUSH por Apple Push Notification Services
     * Retorna informacion del envio del push
     */
    protected function apns($mensaje,$ids,$id_producto){
      $respuesta=  array();
      $respuesta['result'] = '';
      
      $deviceToken = 'e762fc71e7f470a18a58718c2281e8d4b47a7a16056e1b8e18463ba2d040a311';//julian
      $passphrase = '9u3h4h1s3';

      
      $cert = 'ck.pem';

      $ctx = stream_context_create();
      stream_context_set_option($ctx, 'ssl', 'local_cert', $cert);
      stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

      $fp = stream_socket_client(
        'ssl://gateway.push.apple.com:2195', $err,
        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

      if (!$fp)
        return $respuesta['error'] ="Failed to connect: $err $errstr" . PHP_EOL;

      $respuesta['result'] .= 'Connected to APNS' . PHP_EOL;

      $body['aps'] = array(
        'alert' => $mensaje,
        'accion' => 'ver_producto',
        'id_accion' => $id_producto,
        'sound' => 'default'
        );
      $payload = json_encode($body);
      $result=false;

      //print_r($ids);
      for($i=0; $i<count($ids); $i++){
        $msg = chr(0) . pack('n', 32) . pack('H*', $ids[$i]) . pack('n', strlen($payload)) . $payload;
          $result= fwrite($fp, $msg, strlen($msg));
      }

      if (!$result)
        $respuesta['result'] .='Message not delivered' . PHP_EOL;
      else
        $respuesta['result'] .='Message successfully delivered' . PHP_EOL;


      fclose($fp);
      return $respuesta;
    }

        /**
     * Solicitud de envio PUSH por Microsoft Push Notification Services
     * Retorna informacion del envio del push
     */
    protected function mpns($titulo,$mensaje,$ids,$id_producto){
      $respuesta=  array();
      $respuesta['result'] = '';

      $delay=2;
      $message_id=NULL;
      $target='toast';
  
        $msg =  "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
        "<wp:Notification xmlns:wp=\"WPNotification\">" .
        "<wp:Toast>" .
        "<wp:Text1>".htmlspecialchars($titulo)."</wp:Text1>" .
        "<wp:Text2>".htmlspecialchars($mensaje)."</wp:Text2>" .
        "<wp:Text2>".htmlspecialchars($mensaje)."</wp:Text2>" .
        "<wp:Param>/www/item.html?id=1</wp:Param>" .
        "</wp:Toast>" .
        "</wp:Notification>";


      $sendedheaders=  array(
                            'Content-Type: text/xml',
                            'Accept: application/*',
              "X-NotificationClass: $delay"
                            );
    if($message_id!=NULL)
    $sendedheaders[]="X-MessageID: $message_id"; 
    if($target!=NULL)
    $sendedheaders[]="X-WindowsPhone-Target:$target";
    
    
    $req = curl_init();
        curl_setopt($req, CURLOPT_HEADER, true); 
    curl_setopt($req, CURLOPT_HTTPHEADER,$sendedheaders); 
        curl_setopt($req, CURLOPT_POST, true);
        curl_setopt($req, CURLOPT_POSTFIELDS, $msg);
        curl_setopt($req, CURLOPT_URL, $ids[0]);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($req);

    if ( curl_errno( $req ) ){
        $respuesta['error'] ='MPNS error: ' . curl_error( $req );
        return $respuesta;
    }
    
    
    curl_close($req);
 
    $result=array();
    foreach(explode("\n",$response) as $line)
    {
    $tab=explode(":",$line,2);
    if(count($tab)==2)
      $result[$tab[0]]=trim($tab[1]);
    }
    return $result;
      // execute request
    /*  $respuesta['result']= curl_exec($r);
   
      if ( curl_errno( $r ) ){
        $respuesta['error'] ='MPNS error: ' . curl_error( $r );
      }
      curl_close($r);
      return $respuesta;*/
    }



     /**
     * Guardar REDID o TOKEN enviado, si no existe
     * Retorna true o false
     * http://oferto.co/app/push/guardar/
     */

     protected function guardar($atributos=array()){
      $respuesta=  array();
      $sql='';
      $guardado=0;
      $regid=$this->lib->nvl($atributos['regid'],0);
      $token=$this->lib->nvl($atributos['token'],0);

      if(!$regid and !$token)
        return $respuesta['error']= 'No se encontró el valor a guardar ';

      $id_usuario=$this->lib->nvl($atributos['id_usuario'],0);
      $notificaciones=$this->lib->nvl($atributos['notificaciones'],'Si');
      $uid=$this->lib->nvl($atributos['uid'],0);

      if($id_usuario=='')
        $id_usuario=0;

      if($notificaciones!='No')
        $notificaciones='Si';

      if($regid){
        if($uid){
          $qid=$this->db->query("select id_regid from app_regid where uid ='$uid' ");
          if($this->db->num_rows($qid)){
            $row =$this->db->fetch_array($qid);
          }
          else{
            $sql="select id_regid from app_regid where regid = '$regid' ";
            $qid = $this->db->query($sql);
            $row =$this->db->fetch_array($qid);
          }
        }
        else{
            $sql="select id_regid from app_regid where regid = '$regid' ";
            $qid = $this->db->query($sql);
            $row =$this->db->fetch_array($qid);
        }
      
        if($row['id_regid']){
            $this->db->query("update app_regid set id_usuario=$id_usuario, notificaciones='$notificaciones', uid='$uid' where id_regid =".$row['id_regid']);
          $guardado=1;
        }else{
          $datos=array();
          $datos['regid']= $regid;
          $datos['fecha']= date('Y-m-d');
          $datos['id_usuario']= $id_usuario;
          $datos['uid']= $uid;
          $datos['notificaciones']= $notificaciones;
          if($this->db->insert($datos, 'app_regid'))
           $guardado=1;
       }
     }elseif($token){
      if($uid){
          $qid=$this->db->query("select id_token from app_token where uid ='$uid' ");
          if($this->db->num_rows($qid)){
            $row =$this->db->fetch_array($qid);
          }
          else{
            $sql="select id_token from app_token where token = '$token' ";
            $qid = $this->db->query($sql);
            $row =$this->db->fetch_array($qid);
          }
        }
        else{
          $sql="select id_token from app_token where token = '$token' ";
          $qid = $this->db->query($sql);
          $row =$this->db->fetch_array($qid);
        }
        

        if($row['id_token']){
            $this->db->query("update app_token set id_usuario=$id_usuario, notificaciones='$notificaciones', uid='$uid', token='$token'  where id_token =".$row['id_token']);
          $guardado=1;
        }else{
          $datos=array();
          $datos['token']= $token;
          $datos['fecha']= date('Y-m-d');
          $datos['id_usuario']= $id_usuario;
          $datos['uid']= $uid;
          $datos['notificaciones']= $notificaciones;
          if($this->db->insert($datos, 'app_token'))
           $guardado=1;
       }
     

     }
     $respuesta['actualizado']=$guardado;
     return $respuesta;
   } 

   /**
     * Guardar URI enviado, si no existe// wp
     * Retorna true o false 
     * http://oferto.co/app/push/guardar/
     * POST
     */

     protected function post_guardar($atributos=array()){
      $respuesta=  array();
      $sql='';
      $guardado=0;
      $uri=$this->lib->nvl($atributos['uri'],0);
     
      if(!$uri)
        return $respuesta['error']= 'No se encontró el valor a guardar ';

      $id_usuario=$this->lib->nvl($atributos['id_usuario'],0);
      if($id_usuario=='')
        $id_usuario=0;
      if($uri){
        $sql="select id_uri from app_uri where uri = '$uri' ";
        $qid = $this->db->query($sql);
        $row =$this->db->fetch_array($qid);

        if($row['id_uri']){
            $this->db->query("update app_uri set id_usuario=$id_usuario where id_uri =".$row['id_uri']);
          $guardado=1;
        }else{
          $datos=array();
          $datos['uri']= $uri;
          $datos['fecha']= date('Y-m-d');
          $datos['id_usuario']= $id_usuario;
          if($this->db->insert($datos, 'app_uri'))
           $guardado=1;
       }
     }
     $respuesta['actualizado']=$guardado;
     return $respuesta;
   } 

    protected function coordenadas($atributos=array()){
      $respuesta=  array();
    
      $response=print_r($atributos,true);
      $ids=array();
      $ids[]='APA91bEr7cfkiE0ALUfGSfElAPJXKvIFoEdDxXpgn2vQ4sf4TeK46QXL1czph7Q8NM8JWdT5U0AM_IViwO7fBB-4pNLSIr15r06j0xSj8oRIHRpggcPIPKCm9YbNkasrbQGFzAKpOdozEeEg_hsV2lJr79MzydDY6w';

      $respuesta= array();
      $respuesta['gcm']=$this->gcm('Respuesta','Mensaje local coordinadas'.$response,$ids);
       // guardar en logs   
      $dat['ip'] ='oferto app';
      $dat['url'] = addslashes( $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
      $dat['fecha'] = date("Y-m-d H:i:s");
      $dat['id_usuario'] = 77;
      $dat['error'] = 'Mejaje de app coordenadas'.$response.' gcm:'.$respuesta['gcm']['result'];
      $this->db->insert($dat, 'core_logs');


      $respuesta ['response']=$response;
      return $respuesta;
    }    


}