<?php
/**
  * controlador Opcion
  */
  
class Opcion extends ControlBase {
	
	/* formulario opciones de un adicional agregado por ajax al formulario de producto
	* Solicitud por ajax
	*/
	public function form_opcion(){
		$opt = new Opciones();			 
		$d=  $this->input->post('d');
		$p=  $this->input->post('p');
					
		$form='<li id="tr_'.$p.'_0">
                     <input type="hidden" name="guardar_opt['.$p.']['.$d.']" value="0" />
					<span class="task"><span>'.$d.'. <input name="opt['.$p.']['.$d.'][opcion]" id="opt_'.$p.'_'.$d.'"  type="text" class="span13t" onChange="actualizar_preview(\'#pre_op'.$p.'_'.$d.'\',\'opt_'.$p.'_'.$d.'\')" /></span></span>
										
				</li>';
			exit($form);
				
	} 
	  
	 /**
	 * borra la opcion recibe el parametro por post
	 * Solicitud por ajax
	 */	 
	 public function borrar(){
	   $opcion = new opciones(); 
		if($opcion->borrar($this->input->post('id')) )
			echo "1";
		else
			echo "0";
		
	 }	
	 
}
?>