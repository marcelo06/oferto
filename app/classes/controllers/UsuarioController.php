<?php
/**
 * OfertaController
 * 
 */
class UsuarioController extends AbstractController
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
     * Solicitud de verificacion de datos de logueo
     * Retorna informacion del usuario y el estado del login
     * http://oferto.co/app/usuario/login/
     */

    protected function post_login($atributos=array()){
    	$sql='';
      $usuario=$this->lib->nvl($atributos['usuario'],0);
      $contra=$this->lib->nvl($atributos['password'],0);
      $regid=$this->lib->nvl($atributos['regid'],0);
      $token=$this->lib->nvl($atributos['token'],0);
      $user=trim($usuario);
      $pass=trim($contra);
      $respuesta=  array();

      if($user!='' and $pass!=''){

        $sql="select u.* ,p.nombre from core_usuarios  u left join perfil_usuarios p on u.id_usuario=p.id_usuario where CONVERT(_username USING latin1) = '$user' and u.estado = '1' and u.borrado='0' and id_empresa=0  and id_tipo_usuario=5 ";
        $qid = $this->db->query($sql);
        $result =$this->db->fetch_array($qid);
        $respuesta=  array();

        $hash=$this->lib->nvl($result['_password']);

        if(crypt($pass, $hash)===$hash){
          $respuesta['id_usuario'] = $result['id_usuario'];
          $respuesta['nombre'] = $result['nombre'];    
          $respuesta['autentico'] = 1;

         
        }
        else
          $respuesta['autentico'] = 0;

      }
      
      return $respuesta;
    }  


    /**
     * Solicitud de verificacion de datos de logueo
     * Retorna informacion del usuario y el estado del login
     * http://oferto.co/app/usuario/login/
     */

    protected function post_registro($atributos=array()){
      $sql='';
      $respuesta=  array();
      $respuesta['autentico'] = 0;
      $respuesta['error'] = 'Error al procesar la solicitud';

      $username=mysql_real_escape_string($atributos['username']);
      $password=mysql_real_escape_string($atributos['password']);
      $nombre=mysql_real_escape_string($atributos['nombre']);
      $nombre=str_replace('+', ' ', $nombre);
      $telefono=mysql_real_escape_string($atributos['telefono']);
      $direccion=mysql_real_escape_string($atributos['direccion']);
      $pais=mysql_real_escape_string($atributos['pais']);
      $departamento=mysql_real_escape_string($atributos['departamento']);
      $ciudad=mysql_real_escape_string($atributos['ciudad']);
      $proviene=$this->lib->nvl($atributos['proviene']);

      $regid=$this->lib->nvl($atributos['regid'],0);
      $token=$this->lib->nvl($atributos['token'],0);
      
      if($username!='' and $password!='' and $nombre!=''){
        $sql="select * from core_usuarios where CONVERT(_username USING latin1) = '$username' and borrado='0' and id_empresa=0 and id_tipo_usuario=5  ";
        $us = $this->db->query($sql);
        
        if($this->db->num_rows($us) >0){ 
          $respuesta['error'] = $username.' ya está en uso';
        }else{
            $dat['_username'] = $username;
            $dat['email']     = $username;
            $dat['id_empresa']= 0;
            $dat['id_tipo_usuario'] = 5;
            $per['email'] = $username;
            
            if(strlen($password) >= 5){
              $cost = 10;
              $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
              $salt = sprintf("$2a$%02d$", $cost) . $salt;
              $dat['_password'] =crypt($password, $salt);
            }
            
            $dat['estado'] = 1;
            $id_usuario=0;
            if($this->db->insert($dat, 'core_usuarios'))
             $id_usuario= $this->db->insert_id();
            
            $per['id_usuario'] = $id_usuario;
            $per['nombre'] = $nombre;
            $per['telefono'] = $telefono;
            $per['direccion'] = $direccion;
            $per['pais'] = $pais;
            $per['departamento'] = $departamento;
            $per['ciudad'] = $ciudad;
             $per['proviene'] =$proviene;
            $id_perfil=0;
            if($this->db->insert($per ,'perfil_usuarios'))
              $id_perfil= $this->db->insert_id();

            if($id_usuario and $id_perfil){
              $respuesta['id_usuario'] = $id_usuario;
              $respuesta['nombre'] = $nombre; 
              $respuesta['usuario'] = $username;
              $respuesta['password'] = $password;    
              $respuesta['autentico'] = 1;
               $respuesta['error'] = '';

            
            }
            else
              $respuesta['error'] ='Error al procesar la solicitud';   
        }
      }
      else
        $respuesta['error'] ='Campos insuficientes para hacer el registro';
      return $respuesta;
    } 

    /**
     * Solicitud seguir o dejar de seguir una empresa dependiendo el estado enviado
     * Retorna informacion del estado de seguimiento, id usuario, id empresa
     * http://oferto.co/app/usuario/seguir/
     */

    protected function seguir($atributos=array()){
      $sql='';
      $guardado=0;
      $id_usuario=$this->lib->nvl($atributos['id_usuario'],0);
      $id_empresa=$this->lib->nvl($atributos['id_empresa'],0);
      $estado=$this->lib->nvl($atributos['estado'],0);

      if($id_usuario and $id_empresa){
        $sql="select * from usuario_empresa where id_empresa = '$id_empresa' and id_usuario=$id_usuario ";
        $qid = $this->db->query($sql);
        $row =$this->db->fetch_array($qid);

        if($estado==1){
         if($row['id_usuario']){
          $this->db->query("update usuario_empresa set siguiendo='1'  where id_usuario_empresa =".$row['id_usuario_empresa']);
          $guardado=1;

        }else{
          $datos=array();
          $datos['id_usuario']= $id_usuario;
          $datos['id_empresa']= $id_empresa;
          $datos['siguiendo']='1';
          if($this->db->insert($datos, 'usuario_empresa'))
           $guardado=1;
       }

       }else{
         if($row['id_usuario']){
          $this->db->query("update usuario_empresa set siguiendo='0' where id_usuario_empresa =".$row['id_usuario_empresa']);
          $guardado=1;
          if($row['compra']=='0')
            $this->db->query("delete from usuario_empresa where id_usuario_empresa =".$row['id_usuario_empresa']);
         }
      }
    }

    $respuesta=array();
    $respuesta['actualizado']=$guardado;
    $respuesta['estado']=$estado;
    $respuesta['id_usuario']=$id_usuario;
    $respuesta['id_empresa']=$id_empresa;

    return $respuesta;
  } 
  /**
   * [post_contacto]
   * Recibe datos de contacto y envia el mensaje.
   */
  protected function post_contacto($atributos=array()){
      $sql='';
      $id_usuario=$this->lib->nvl($atributos['id_usuario'],0);
      $nombre=mysql_real_escape_string($this->lib->nvl($atributos['nombre']));
      $email=$this->lib->nvl($atributos['email']);
      $telefono=mysql_real_escape_string($this->lib->nvl($atributos['telefono']));
      $inquietudes=mysql_real_escape_string($atributos['inquietudes']);

      $respuesta=  array();
      if(($id_usuario or($nombre!='' and $email!='')) and $inquietudes!=''){
        if($id_usuario){
          $sql="select * from perfil_usuarios where id_usuario = $id_usuario";
          $qid = $this->db->query($sql);
          $result =$this->db->fetch_array($qid);
          $nombre= $result['nombre'];
          $email= $result['email'];
          $telefono= $result['telefono'];
        }
       
        if($nombre!='' and $email!=''){
          $datos['nombre']=$nombre;
          $datos['email']=$email;
          $datos['telefono']=$telefono;
          $datos['inquietudes']=$inquietudes;  
          //enviar
          $enviado=$this->enviar_contacto($datos);
          if($enviado){
            $respuesta['enviado'] = 1;
            $respuesta['error'] = '';
          }
          else{
            $respuesta['enviado'] = 0;
            $respuesta['error'] = 'Hubo un error al enviar el mensaje de contacto';
          }
        }
        else{
          $respuesta['enviado'] = 0;
          $respuesta['error'] = 'Faltaron datos para hacer el envió del mensaje de contácto';
        }
      }
     else{
      $respuesta['enviado'] = 0;
      $respuesta['error'] = 'Faltaron datos para hacer el envió del mensaje de contácto';
     }
        
      return $respuesta;
    }  



  /**
     * Quitar asociacion de id_usuario con REGID
     * Retorna true o false
     * http://oferto.co/app/usuario/salir/
     */

     protected function salir($atributos=array()){
      $respuesta=  array();
      $sql='';
      $guardado=0;
      $regid=$this->lib->nvl($atributos['regid'],0);
      if(!$regid)
        return $respuesta['error']= 'Parámetros requeridos incompletos ';

      $id_usuario=$this->lib->nvl($atributos['id_usuario'],0);

      $sql="select id_regid from app_regid where regid = '$regid' ";
      $qid = $this->db->query($sql);
      $row =$this->db->fetch_array($qid);

      if($row['id_regid']){
        if($id_usuario){
          $this->db->query("update app_regid set id_usuario=$id_usuario where id_regid =".$row['id_regid']);
        }
        $guardado=1;
      }else{
        $datos=array();
        $datos['regid']= $regid;
        $datos['fecha']= date('Y-m-d');
        if($id_usuario)
          $datos['id_usuario']= $id_usuario;
        if($this->db->insert($datos, 'app_regid'))
         $guardado=1;
     }
     $respuesta['actualizado']=$guardado;
     return $respuesta;
   } 


  private function enviar_contacto($datos){     
    $nombre= $datos['nombre'];
    $email= $datos['email'];
    $telefono= $datos['telefono'];
    $preguntas=$datos['inquietudes'];  
  
    $this->mail = new PHPMailer();
    $this->mail->IsHTML(true);
    $this->mail->From ="info@oferto.co";
    $this->mail->FromName = utf8_decode($nombre);
    $subject= "Contacto desde App OFERTO.CO";
    $this->mail->Subject =$subject;
    
  
    $sql="select valor from core_config where tipo ='email'";
    $qid = $this->db->query($sql);
    $row =$this->db->fetch_array($qid);
    
    $this->mail->AddAddress($row['valor']);
     $this->mail->AddBCC('sitios@rhiss.net');
    
    $cuerpo ='<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
    <title>'.$this->mail->Subject.'</title>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
    <link href="style-form.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    html {
      font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}::-moz-selection{background:#0079ff;color:#fff}::selection{background:#0079ff;color:#fff}body {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color: #333333;background-color: #ffffff; padding: 0;margin: 0;;
      }.ExternalClass,.ReadMsgBody{width:100%;background-color:#f5f7fa}a{color:#0079ff;text-decoration:none;font-weight:300;font-style:normal}a:hover{color:#adb2bb;text-decoration:underline;font-weight:300;font-style:normal}div,p{margin:0!important}table{border-collapse:collapse}@media only screen and (max-width:640px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:440px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:400px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:400px!important;height:1px!important}}@media only screen and (max-width:479px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:280px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:240px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:240px!important;height:1px!important}}
      table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}table col[class*=col-]{position:static;float:none;display:table-column}table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.center-block{display:block;margin-left:auto;margin-right:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important;visibility:hidden!important}.affix{position:fixed;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}
      </style>
    
  </head>
  <body bgcolor="#F5F7FA">
    <!-- START OF PRE-HEADER BLOCK-->
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
      <tr>
        <td align="center" valign="top" width="100%">
          <table align="center" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%">
                <!-- START OF VERTICAL SPACER-->
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
                  <tr>
                    <td height="30" width="100%">
                      &nbsp;
                    </td>
                  </tr>
                </table><!-- END OF VERTICAL SPACER-->
                <!-- START OF VERTICAL SPACER-->
                <!-- END OF VERTICAL SPACER-->
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table><!-- END OF PRE-HEADER BLOCK--><!-- START OF HEADER BLOCK-->
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
      <tr>
        <td valign="top" width="100%">
          <table align="center" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%">
                <!-- START OF VERTICAL SPACER-->
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
                  <tr>
                    <td height="30" width="100%">
                      
                    </td>
                  </tr>
                </table><!-- END OF VERTICAL SPACER-->
                <table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
                  <tr>
                    <td width="100%">
                      <table border="0" cellpadding="0" cellspacing="0" width="600">
                        <tr>
                          <td class="spacer" width="30"></td>
                          <td width="540">
                            <!-- START OF LEFT COLUMN-->
                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
                              <tr>
                                <td align="left" class="center" style="padding: 0px;font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">
                                
                                  <span><a href="#" style="color:#0079ff;"><img alt="logo" border="0" src="http://www.oferto.co/system/vista/images/logo.png" style="display: inline-block;" ></a></span>
                                  
                                </td>
                              </tr>
                            </table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
                          </td>
                          <td class="spacer" width="30"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table><!-- START OF VERTICAL SPACER-->
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
                  <tr>
                    <td height="30" width="100%">
                      &nbsp;
                    </td>
                  </tr>
                </table><!-- END OF VERTICAL SPACER-->
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table><!-- END OF HEADER BLOCK--><!-- START OF FEATURED AREA BLOCK-->
    
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
      <tr>
        <td valign="top" width="100%">
          <table align="center" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%">
                <table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F64B75" width="600" background="http://www.oferto.co/system/vista/images/featured-background.png">
                  <tr>
                    <td align="center" width="100%">
                      <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

                        <tr>
                          <td class="spacer" width="30"></td>
                          <td width="540">
                            <!-- START OF LEFT COLUMN-->
                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
                              <tr>
                                <td height="40">
                                  &nbsp;
                                </td>
                              </tr><!-- START OF HEADING-->
                              <tr>
                                <td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
                                  <div style="text-align: center; font-size: 13px; font-weight: 700;">Hola, Soy: </div>
                                  <span> <strong>'.$nombre.'</span>
                                </td>
                              </tr><!-- END OF HEADING--><!-- START OF TEXT-->
                              
                              <tr>
                                <td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                  <span>'.nl2br($preguntas).'</span>
                                </td>
                              </tr>
                              
                              <!-- END OF TEXT--><!-- START BUTTON-->
                              <!-- END BUTTON-->
                              <tr>
                                <td height="40">
                                  &nbsp;
                                </td>
                              </tr>
                            </table><!-- END LEFT COLUMN-->
                          </td>
                          <td class="spacer" width="30"></td>
                        </tr><!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->
                      </table>
                    </td>
                  </tr>
                </table><!-- START OF VERTICAL SPACER-->
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
                  <tr>
                    <td height="40" width="100%">
                      &nbsp;
                    </td>
                  </tr>
                </table><!-- END OF VERTICAL SPACER-->
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table><!-- END OF FEATURED AREA BLOCK--><!-- START OF 1/3 COLUMN BLOCK-->
    
  
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
      <tr>
        <td valign="top" width="100%">
          <table align="center" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%">
                <table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
                  <tr>
                    <td width="100%">
                      
                      
                      <div style="text-align: center; font-size: 18px;height: 50px;"><strong>Mis Datos de contacto son</strong>:</div>
                      
                      <div class="bs-example" style="padding: 0 20px;">
                          <table class="table table-hover">
                            <tbody>
                              <tr>
                                
                                <td><strong>Email</strong>:</td>
                                <td>'.$email.'</td>
                                
                              </tr>
                              <tr>
                                
                                <td><strong>Teléfono</strong>:</td>
                                <td>'.$telefono.'</td>
                                
                              </tr>
                              
                            </tbody>
                          </table>
                        </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table><!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK-->
    <!-- START OF SUB-FOOTER BLOCK-->
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
      <tr>
        <td valign="top" width="100%">
          <table align="center" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%">
                <table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
                  <tr>
                    <td width="100%">
                      <table border="0" cellpadding="0" cellspacing="0" width="600">
                        <tr>
                          <td class="spacer" width="30"></td>
                          <td width="540">
                            <!-- START OF LEFT COLUMN-->
                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">
                              <!-- START OF TEXT-->
                              <tr>
                                <td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:13px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
                                  <span>Copyright &#169;Rhiss.net</span>
                                </td>
                              </tr><!-- END OF TEXT-->
                            </table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="spacer" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="20">
                              <tr>
                                <td height="10" width="100%"></td>
                              </tr>
                            </table><!-- END OF SPACER-->
                          </td>
                          <td class="spacer" width="30"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table><!-- END OF SUB-FOOTER BLOCK-->
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
      <tr>
        <td align="center" valign="top" width="100%">
          <table align="center" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%">
                <table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
                  <tr>
                    <td width="100%">
                      <table border="0" cellpadding="0" cellspacing="0" width="600">
                        <tr>
                          <td width="540">
                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
                              <tr>
                                <td align="center" style="padding: 0px;" valign="top">
                                  <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
                                    <tr>
                                      <td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle">
                                        <img alt="img 600 290" border="0" class="img_scale" height="10" src="http://www.oferto.co/system/vista/images/footer-radius.png" style="display:block;" width="600">
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table><!-- START OF VERTICAL SPACER-->
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
                  <tr>
                    <td height="40" width="100%">
                      &nbsp;
                    </td>
                  </tr>
                </table><!-- END OF VERTICAL SPACER-->
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>';
      $this->mail->Body = utf8_decode($cuerpo);
    if($this->mail->Send())
    return true;
    else
    return false;
  } 
  
     
  
   
}