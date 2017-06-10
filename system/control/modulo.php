<?php

class Modulo extends ControlBase {
	
	public function listar_modulos(){
		$this->view->show("sys/listar_modulos.php");
	}
	
	public function edit_modulo(){
		
		$reg = array();
		$con = new Modulos();
		
		if(isset($this->get['id']) && $this->input->post('dat') == FALSE){
			$reg['reg'] = $con->obtener($this->get['id']);
		}
		
		if($this->input->post('btnAceptar_x') != FALSE){
		    $reg= $this->input->post('dat');
			
			if(isset($this->get['id']))
				$sal = $con->actualizar($reg,$this->get['id']);
			else
				$sal = $con->agregar($reg);
				
			if($sal === false)
				mensaje("Ocurrio un error porque la clase no existe o esta repetido");
				
			redirect("modulo-listar_modulos");
			
		}
		
		$this->view->show("sys/edit_modulo.php", $reg);
	}
	
	
	public function xml_modulos(){
		
		$serx = new Modulos();
		$resultado = $serx->listar();
		$xml = '';
		$xml .= '<?xml version="1.0" encoding="UTF-8" ?>';
		$xml .= '<rows>';
		foreach($resultado as $reg){
			$xml .= '<row id="'.$reg['id_modulo'].'">';
			$xml .= '<cell>';
			$xml .= $reg['modulo'];
			$xml .= '</cell>';
			$xml .= '<cell>';
			$xml .= 'Editar^modulo-edit_modulo-id-'.$reg['id_modulo'].".htm".'^_self';
			$xml .= '</cell>';
			$xml .= '<cell>';
			$xml .= 'Borrar^javascript:borrar('.$reg['id_modulo'].');^_self';
			$xml .= '</cell>';
			$xml .= '</row>';
		}
		$xml .= '</rows>';
		header("Content-type: text/xml");
		echo $xml;
		
	}
	
	public function borrar(){
		$abo = new Modulos();
		echo $abo->borrar($this->input->post('id')) ;
	}
	
	public function editar_permisos(){
		$usr = new Usuarios();
		$mod = new Modulos();
		$reg['tipo_usuarios'] = $usr->tiposUsuarioTodos();
		$reg['modulos'] = $mod->listarBox();
		$this->view->show("sys/editar_permisos.php", $reg);
	}
	
	public function xml_permisos(){
		$serx = new Modulos();
		
		$id_modulo = $this->get['modulo'];
		$tipo_usuario = $this->get['tipo_usuario'];
		
		$tmp = $serx->obtener($id_modulo);
		$modulo = $tmp['modulo'];
		
		$metodos = get_class_methods($modulo);
		$nm = count($metodos);
		
		if($nm==0){
			$xml = '';
			$xml .= '<?xml version="1.0" encoding="UTF-8" ?>';
			$xml .= '<rows>';
			$xml .= '<row id="0">';
			$xml .= '<cell>';
			$xml .= 'Este modulo no existe';
			$xml .= '</cell>';
			$xml .= '<cell>';
			$xml .= '0';
			$xml .= '</cell>';
			$xml .= '</row>';
			$xml .= '</rows>';
			header("Content-type: text/xml");
			echo $xml;
		}else{
			$xml = '';
			$xml .= '<?xml version="1.0" encoding="UTF-8" ?>';
			$xml .= '<rows>';
			foreach($metodos as $metodo){
				$xml .= '<row id="'.$metodo.'">';
				$xml .= '<cell>';
				$xml .= $metodo;
				$xml .= '</cell>';
				$xml .= '<cell>';
				$xml .= $serx->obtenerPermiso($modulo, $metodo, $tipo_usuario);
				$xml .= '</cell>';
				$xml .= '</row>';
			}
			$xml .= '</rows>';
			header("Content-type: text/xml");
			echo $xml;
		}
	}
	
	public function cambiar_permiso(){
			$mod = new Modulos();
			$id_modulo = $this->input->post('modulo');
			$tmp = $mod->obtener($id_modulo);
			$modulo = $tmp['modulo'];
			
			echo $mod->cambiar_permiso($modulo, $this->input->post('metodo'), $this->input->post('cambio'), $this->input->post('usuario'));
	}
	
	
}

?>