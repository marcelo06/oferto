<?php
/**
  * controlador Noticia
  *
  * 
  *
  * @package   Noticia 
  * @author	   Sebastian Lopez
  * @since	   20100519
  * @version   20100519
  */
  
class Adicional extends ControlBase {  
	  

	public function agregar(){
		$adicionales = new adicionales();
		$opciones= new Opciones();
		$n_adicional=  $this->input->post('adicional');
		$n_opciones=  $this->input->post('opciones');
		$check=  $this->input->post('check');
		$cuenta=  $this->input->post('cuenta');

		$adicionales->datos['id_empresa'] = $_SESSION['id_empresa']; 
		$adicionales->datos['adicional'] = $n_adicional; 
		if($idp= $adicionales->guardar(0)){
			$listopciones= explode(',',$n_opciones);
			foreach($listopciones as $opt){ 
				$opciones->datos['opcion']= $opt;
				$opciones->datos['id_adicional']= $idp;						  					   
				$opciones->guardar(0);
			}

			$estado=1;
			$info='<li id="li_'.$idp.'">';
			
			
				 $info.='<div class="check">
				<input type="checkbox" class="icheck-me" data-skin="square" data-color="blue" name="adi['.$cuenta.'][id_adicional]" checked="checked" value="'.$idp.'"/>
				</div>
				<span class="task"><span id="adi_'.$idp.'" >'.$n_adicional.' ('.$n_opciones.')</span></span>
			<span class="task-actions"><a href="#edit-opcion" data-toggle="modal" onClick="edit_adi('.$idp.',\''.$n_adicional.'\',\''.$n_opciones.'\')"  class="task-delete" rel="tooltip" title="Editar"  ><i class="icon-edit"></i></a>

				<a href="javascript:delete_adi('.$idp.')" class="task-delete" rel="tooltip" title="Borrar"><i class="icon-remove"></i></a>
			</span>';
			
			$info.='</li>';
		}

		 $respuesta = array (
				  'estado'=>$estado,
				  'info'=>$info);

		echo json_encode($respuesta);	
	}

	public function editar(){
		$adicionales = new adicionales();
		$opciones= new Opciones();
		$n_adicional=  $this->input->post('adicional');
		$n_opciones=  $this->input->post('opciones');
		$id_adicional=  $this->input->post('id');
		
		$adicionales->datos['adicional'] = $n_adicional; 
		if($id_adicional && $adicionales->guardar($id_adicional)){
			$opciones->borrarOpcionesAdicional($id_adicional);
			$listopciones= explode(',',$n_opciones);
			foreach($listopciones as $opt){ 
				$opciones->datos['opcion']= $opt;
				$opciones->datos['id_adicional']= $id_adicional;						  					   
				$opciones->guardar(0);
			}

			$task='<span id="adi_'.$id_adicional.'" >'.$n_adicional.' ('.$n_opciones.')</span>';
			$actions='<a href="#edit-opcion" data-toggle="modal" onClick="edit_adi('.$id_adicional.',\''.$n_adicional.'\',\''.$n_opciones.'\')"  class="task-delete" rel="tooltip" title="Editar"  ><i class="icon-edit"></i></a>
			<a href="javascript:delete_adi('.$id_adicional.')" class="task-delete" rel="tooltip" title="Borrar"><i class="icon-remove"></i></a>';
		}

		 $respuesta = array (
				  'estado'=>1,
				  'task'=>$task,
				  'actions'=>$actions);

		echo json_encode($respuesta);	
	}
	 /**
	 * borra el adicional correspondiente al id
	 * solicitud por ajax
	 */	
	 public function borrar(){
	 
	   $adicional = new adicionales();
	    
		if($adicional->borrar($this->input->post('id')) )
			echo "1";
		else
			echo "0";
		
	 }
	
	
	/**
	 * Formulario adicional agregado por ajax al formulario de productios
	 * solicitud por ajax
	 */	
	public function form_adicional(){
		
		$pro = new Adicionales();		 
		
		$p=  $this->input->post('p');
		
		$form='<div class="box-content" style="padding-top:0px;" id="table_'.$p.'">  
                             <div class="form-horizontal form-bordered">  
              <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="titulo" class="control-label">Nombre: </label>
												<div class="controls controls-row">
                                              <input type="hidden" name="guardar_adic['.$p.']" value="0" />
													<input name="adic['.$p.'][adicional]"  id="adic_'.$p.'" type="text"  value="" onKeyUp="actualizar_adicional('.$p.')"/><a href="javascript:borrarAdicional(0,'.$p.')"  class="btn" rel="tooltip" title="Borrar esta opción"><i class="icon-remove"></i></a>
												</div>
											</div>
										
                                <div class="control-group">
											<label for="textfield" class="control-label">Escriba las opciones para <span id="tad_'.$p.'">""</span> <span  rel="tooltip" title="Escripa las opciones separadas por coma o dando Enter en el teclado"><img src="'.URLVISTA.'admin/img/question.png"/></span></label>
											<div class="controls">
												<div class="span12"><input type="text" name="opt['.$p.']" id="opciones_'.$p.'" class="" value=""></div>
											</div>
										</div>
                   </div></div>
					
                    </div></div>';
			

			exit($form);
				
	}  
	
	static function selectOpciones($id)
	{
		$opcion= new Opciones();
	 return $opcion->boxOpciones($id);
	}
	
	
	/*
	* Obtiene lista de opciones de un atributo dado
	*/
	static function obtieneDocs($id_p)
	{
		$opcion= new Opciones();
	 return $opcion->listar($id_p);
	}
	 
}
?>