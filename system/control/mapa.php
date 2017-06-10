<?php

class Mapa extends ControlBase {

	public function ofertas(){
		$gal=new Galerias();
 		$productos= new Productos();

		$reg['dirfileout'] = $gal->dirfileout;
		$reg['dirfileo'] = $productos->dirfileout;
 		$reg['populares']=$productos->obtenerOfertasMasCompradas(20);
		$mañana=date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
		$reg['vencen']=$productos->obtenerOfertasVencen($mañana);

    $reg['categoria']= nvl($this->get['c'],0);
    $reg['oferta']= nvl($this->get['id'],0);

    if($reg['categoria']){
      $categorias= new Ecategorias();
      $reg['cate']= $categorias->obtener($reg['categoria']);
    }

     if($reg['oferta']){
      $reg['ofer']= $productos->obtener($reg['oferta']);
    }


		$pedido = new Pedidos();
		$reg['pedidos'] = $pedido->listarPorUsuario(nvl($_SESSION['id_usuario'],0),1);
		$this->view->show("mapa.php", $reg);
	}
	
	public function lista_ofertas(){
		$mapas= new Mapas();
      $boundaries=array();

        if($this->input->post('boundaries')){
          $boundaries=explode('_',$this->input->post('boundaries'));
          if(count($boundaries)<4)
            return 'Error';
        }

        $c_latitud=$this->input->post('current_lat');
        $c_longitud=$this->input->post('current_long');
   
        if ($this->input->post('oferta')) {
          $result= $mapas->almacenes_oferta($this->input->post('oferta'),$boundaries,$c_latitud,$c_longitud); 
        }elseif ($this->input->post('categoria')) {
          $result= $mapas->almacenes_categoria($this->input->post('categoria'),$boundaries,$c_latitud,$c_longitud); 
        }
        else {
        	$result= $mapas->ofertas($boundaries,$c_latitud,$c_longitud);
         }
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
          header('Content-Type: application/json');
        echo json_encode($respuesta);       
       }
	

       public function lista_almacenes(){
       	$mapas= new Mapas();
       	$productos= new Productos();
        $galerias= new Galerias();
       	$sql='';
       	$bubicacion='';
       	$busqueda='';


       	$search=$this->input->post('busqueda');
       	$categoria=$this->input->post('categoria');
    
       	$result= $mapas->ofertas_almacen($this->input->post('almacen'),$search,$categoria); 

         $i=0;
          $respuesta=  (object) array();
          foreach ($result as $row) {
            $agotado='';

            if($row['oferta_existencia_estado']=='1'){
              if(!$row['oferta_existencia'])
                $agotado='AGOTADO';
            }
            elseif($row['existencia_estado']=='1'){
              if(!$row['existencia'])
               $agotado='AGOTADO';
           }


           $respuesta -> rows[$i]['id'] = $row['id_producto'];
           $respuesta -> rows[$i]['nombre'] = (strlen($row['nombre']) >30) ? substr($row['nombre'], 0,30): $row['nombre'];
           $respuesta -> rows[$i]['valor_normal'] = $row['precio'];
           $respuesta -> rows[$i]['valor_oferta'] = $row['oferta_precio'];
           $respuesta -> rows[$i]['porcentaje'] = $row['porcentaje'];
           $respuesta -> rows[$i]['agotado']= $agotado; 
           $respuesta -> rows[$i]['empresa']= $row['empresa'];       
           $restante=resta_fechas ($row['oferta_vencimiento'],date('Y-m-d'));      
           $respuesta -> rows[$i]['vence'] = $restante;

           $respuesta->rows[$i]['imagen']=($row['oferta_imagen']!='') ? $productos->dirfileout.'a'.$row['oferta_imagen']:$galerias->dirfileout.'a'.$row['archivo'];
           $i++;
         }
          $respuesta -> total= count($result);
          header('Content-Type: application/json');
        echo json_encode($respuesta);     

       }
	
    public function almacenes(){
    	$gal=new Galerias();
 		$productos= new Productos();

		$reg['dirfileout'] = $gal->dirfileout;
		$reg['dirfileo'] = $productos->dirfileout;
 		$reg['populares']=$productos->obtenerOfertasMasCompradas(20);
		$mañana=date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
		$reg['vencen']=$productos->obtenerOfertasVencen($mañana);

		$pedido = new Pedidos();
		$reg['pedidos'] = $pedido->listarPorUsuario(nvl($_SESSION['id_usuario'],0),1);
		$this->view->show("mapa.php", $reg);
    }

	

}
?>