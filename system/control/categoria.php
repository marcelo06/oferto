<?php
/**
  * controlador Categoria
  *
  * 
  *
  * @package   Categoria 
  * @author	   Sebastian Lopez
  * @since	   20100519
  * @version   20100519
  */
  
class Categoria extends ControlBase {

	 /*
	* Muestra la vista con el listado de categorías
	*/
	 public function categorias()
	{
		$categorias= new Categorias();
		$reg['categorias']= $categorias->listar($_SESSION['id_empresa']);
		 $this->view->show("admin/categoria.php",$reg);
	}

	/*
	* Crea una nueva categoria y genera el html correspondiente 
	* solicitud por ajax
	*/
	public function nueva_categoria()
	{
		$categorias= new Categorias();
		$categorias->datos['id_empresa'] = $_SESSION['id_empresa'];
		$categorias->datos['categoria'] = $this->input->post('nombre');
		$cuenta= $this->input->post('cuenta');
		$check= $this->input->post('check');
		

		$info='';
		$estado=0;
		if($id_categoria = $categorias->guardar()){
			$estado=1;
			$info='<li id="li_'.$id_categoria.'">';
			
			if($check){
				 $info.='<div class="check">
				<input type="checkbox" class="icheck-me" data-skin="square" data-color="blue" name="cat['.$cuenta.'][id_categoria]" checked="checked" value="'.$id_categoria.'"/>
				</div>';
            }
			
			$info.='<span class="task"><span class="editable" id="cat_'.$id_categoria.'" >'.$this->input->post('nombre').'</span></span>
			<span class="task-actions">';
			if(!$check){
				$info.='<a href="javascript:delete_cate('.$id_categoria.')" class="task-delete" rel="tooltip" title="Borrar esta categoría"><i class="icon-remove"></i></a>
			
			</span>';
			}
			
			$info.='</li>';
		}
		
		 $respuesta = array (
				  'estado'=>$estado,
				  'info'=>$info);

		echo json_encode($respuesta);
	}

	/*
	* Borra la categoría correspondiente a el id
	* solicitud por ajax
	*/
	public function borrar_categoria(){
	  $categorias = new Categorias();
	  if($this->input->post('id'))
	  {
	     $categorias->borrar($this->input->post('id'));
	      echo 1;
	  }
		else
	      echo 0;
	}


	/*
	* Devuelve el nombre de la categoría correspondiente a el id
	*/
	public static function nombreCategoria($id){

		$categoria = new Categorias();
		$ope = $categoria->obtener($id);	
		return $ope['categoria'];
    }
	
	
	  
	  /* 
	  * Edita el nombre de la categoria desde un elemento jeditable en la vista
	  * solicitud por ajax
	  */
	   public function editable(){
	  
	    $categoria = new categorias();
		$categoria->datos['categoria'] = $this->input->post('value'); 	
		
		$ident = $this->input->post('id');
		$id= explode('_',$ident);
		

		if($id = $categoria->guardar( $id[1]))
			 echo $this->input->post('value');
		 else  
             echo 'Error al guardar';
	  }
	  
	static  function menu($cate,$num=0){
		$categorias = new categorias();
		$lnod = $categorias->listar($_SESSION['id_empresa']);
		foreach($lnod as $row) {
			$nproductos=$categorias->numProductosCategoria($row['id_categoria']);
			if($nproductos){
				$nombre= $row['categoria'];
				
				$current='';
				
				if($row['id_categoria']==$cate)
				$current= ' class="current" ';
				$link='href="main-productos-c-'.$row['id_categoria'].'-t-'.chstr($nombre).'"';
				
				if($num)
				$nombre.= ' ('.$categorias->numProductosCategoria($row['id_categoria']).')';
				echo  '<li class="level1 nav-2-1 first parent"><a '.$current.$link.'><span>'.$nombre.'</span></a></li>';
			}
		}
	}
	  
	 
}
?>