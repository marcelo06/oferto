<?php 


class Push extends ModelBase{
  
 
    public function gcm($titulo,$mensaje,$ids,$accion='',$idaccion=''){
      $respuesta=  array();
       $respuesta['envios'] =0;
       $respuesta['error'] ='';
       $respuesta['log']='GCM No enviados';


      /*$ids=array();
      $ids[]='APA91bHYF3VXCk7t2Phb3PLw_9hpsFCz2PUa_3XBo2Ofy6cfgziU1a2ZXcUCIOgtV4I6XkhMFnY78-gup6R5y1EALysPAbQgzyyCeHheUwuzxB0wEACvWHoy2ZXJBfGMWrJ8-8-Qxlb27Db6SdQhlQOYXMuBoYIT1w';*/
     
      $nuevo_ids=array();
      if(count($ids)>1000){
        $nuevo_ids= array_slice($ids, 1001);
        $ids= array_slice($ids, 0,1000);
      }
      
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
        $respuesta['log'] ='GCM error';
      }
      else
         $respuesta['log']='GCM Enviados correctamente';

      curl_close( $ch );
      
    
     $respuesta['envios'] =count($ids);
      $log = new Modulos();
      $rides=print_r($ids,true);
        $rrespuesta=print_r($respuesta,true);
        $log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], 'push gcm respuesta '.$rrespuesta.$rides);
        if(count($nuevo_ids)){
          $this->gcm($titulo,$mensaje,$nuevo_ids,$accion,$idaccion);
        }
        else{
          return $respuesta;
        }
      
    }  


    /**
     * Solicitud de envio PUSH por Apple Push Notification Services
     * Retorna informacion del envio del push
     */
    public function apns($titulo,$msj,$ids,$accion,$id_accion){
      $mensaje=$titulo.', '.$msj;
     $log = new Modulos();
     $errorapns=false;
     $respuesta=  array();
     $respuesta['result'] = '';
     $respuesta['log']='APNS No enviados';
     
     $passphrase = '9u3h4h1s3';

      /*$ids=array();
      $ids[]='5626d0b787d719f529d1866a490e0e6399f9ab71dfd5eb7c700757a062ecfade';//juan david*/
      
      $cert = LIB.'apns/ck.pem';

      $body = array();
      $body['aps'] = array('alert' => $mensaje);
      $body['aps']['accion'] = $accion;
      $body['aps']['id_accion'] = $id_accion;
      $body['aps']['sound'] ='default';
    //$body['aps']['badge'] = 1;

    //Setup stream (connect to Apple Push Server)
      $ctx = stream_context_create();
      stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
      stream_context_set_option($ctx, 'ssl', 'local_cert', $cert);
      $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
      stream_set_blocking ($fp, 0); //This allows fread() to return right away when there are no errors. But it can also miss errors during last seconds of sending, as there is a delay before error is returned. Workaround is to pause briefly AFTER sending last notification, and then do one more fread() to see if anything else is there.

    if (!$fp) {
      $respuesta['error'] ="Failed to connect: $err $errstrn";
      $respuesta['log'] ='APNS Failed to connect';
      return $respuesta;
    } else {
        $apple_expiry = time() + (7 * 24 * 60 * 60); //Keep push alive (waiting for delivery) for 7 days

        //Loop thru tokens from database
        $i=0;
        foreach($ids as $row){
          $apple_identifier =$i.'_'.$row['id_token'];
          $deviceToken = $row['token'];
          $payload = json_encode($body);
            //$msg = chr(0) . pack('n', 32) . pack('H*', $ids[$i]) . pack('n', strlen($payload)) . $payload;
            $msg = pack("C", 1) . pack("N", $apple_identifier) . pack("N", $apple_expiry) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload; //Enhanced Notification
           $result=  fwrite($fp, $msg); //SEND PUSH
           $errorapns=$this->checkAppleErrorResponse($fp); 
           $i++;
         }
         if($errorapns===false){
            //Workaround to check if there were any errors during the last seconds of sending.
            usleep(500000); //Pause for half a second. Note I tested this with up to a 5 minute pause, and the error message was still available to be retrieved
            $errorapns=$this->checkAppleErrorResponse($fp);
          }
          $respuesta['log']='';
          if($errorapns===false){
            $respuesta['log']='APNS enviados correctamente';
            $respuesta['result'] .='Enviados: '.count($ids).PHP_EOL;
            $respuesta['success'] =count($ids);

            $rides=print_r($ids,true);
            $rrespuesta=print_r($respuesta,true);
            $log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], 'push apns respuesta '.$rrespuesta.$rides);
            return $respuesta;
          }
          elseif(is_numeric($errorapns)){
            $respuesta['result'] .='Erro APNS. volviendo a intentar... '.PHP_EOL;
            $id_token= $ids[$errorapns]['id_token'];
            $this->borrarToken($id_token);
            $nuevo_ids=array();
            $nuevo_ids=array_slice($ids,$errorapns+1);

            $rides=print_r($nuevo_ids,true);
            $rrespuesta=print_r($respuesta,true);
            $log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], 'push apns respuesta '.$rrespuesta.$rides);

            if(count($nuevo_ids))
              $this->apns($titulo,$msj,$nuevo_ids,$accion,$id_accion);
            else{
             $respuesta['result'].='No hay mas tokens a enviar.';
             $respuesta['log']='APNS enviados correctamente';
             $rrespuesta=print_r($respuesta,true);
             $log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], 'push apns respuesta '.$rrespuesta);
             return $respuesta;
           } 
         }
         else{
           $respuesta['result'] .='Erro APNS. id: '.$errorapns;
           $respuesta['log']=$respuesta['result'];
           $rrespuesta=print_r($respuesta,true);
           $log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], 'push apns respuesta '.$rrespuesta);
           return $respuesta;
         }
       }
     }

    public function checkAppleErrorResponse($fp) {

       $apple_error_response = fread($fp, 6); //byte1=always 8, byte2=StatusCode, bytes3,4,5,6=identifier(rowID). Should return nothing if OK.
       
       if ($apple_error_response) {
         fclose($fp);

            $error_response = unpack('Ccommand/Cstatus_code/Nidentifier', $apple_error_response); //unpack the error response (first byte 'command" should always be 8)

            if ($error_response['status_code'] == '0') {
                $error_response['status_code'] = '0-No errors encountered';

            } else if ($error_response['status_code'] == '1') {
                $error_response['status_code'] = '1-Processing error';

            } else if ($error_response['status_code'] == '2') {
                $error_response['status_code'] = '2-Missing device token';

            } else if ($error_response['status_code'] == '3') {
                $error_response['status_code'] = '3-Missing topic';

            } else if ($error_response['status_code'] == '4') {
                $error_response['status_code'] = '4-Missing payload';

            } else if ($error_response['status_code'] == '5') {
                $error_response['status_code'] = '5-Invalid token size';

            } else if ($error_response['status_code'] == '6') {
                $error_response['status_code'] = '6-Invalid topic size';

            } else if ($error_response['status_code'] == '7') {
                $error_response['status_code'] = '7-Invalid payload size';

            } else if ($error_response['status_code'] == '8') {
                $error_response['status_code'] = '8-Invalid token';

            } else if ($error_response['status_code'] == '255') {
                $error_response['status_code'] = '255-None (unknown)';

            } else {
                $error_response['status_code'] = $error_response['status_code'].'-Not listed';

            }

            $respuesta= '<br><b>+ + + + + + ERROR</b> Response Command:<b>' . $error_response['command'] . '</b>&nbsp;&nbsp;&nbsp;Identifier:<b>' . $error_response['identifier'] . '</b>&nbsp;&nbsp;&nbsp;Status:<b>' . $error_response['status_code'] . '</b><br>';
           $respuesta.= 'Identifier is the rowID (index) in the database that caused the problem, and Apple will disconnect you from server. To continue sending Push Notifications, just start at the next rowID after this Identifier.<br>';

            $log = new Modulos();
            $log->guardarLog(ip_address(), $_SERVER['REQUEST_URI'], $_SESSION['id_usuario'], 'push apns enhanced '.$respuesta);

            //borrar token
            return $error_response['identifier'];
       }
       else
        return false;
       
    }

    public function borrarToken($id){
      $this->db->query("delete from ".APP_TOKEN." where id_token = '$id' ");
      return true;
    
  }
   
}

?>