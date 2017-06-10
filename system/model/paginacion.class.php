<?php 

class Paginacion extends ModelBase
{
	public $pagina;
	public $registros;
	public $consulta;
	public $inicio;
	public $total_paginas;
	public $param;
	public $np;
	public $variable;

	function __construct($pagina,  $consulta, $registros = 20,$variable=''){

		parent::__construct();
		$this->pagina = $pagina;
		$this->registros = $registros;
		$this->consulta = $consulta;
		$this->variable = $variable;
		
		$this->inicio = ($pagina - 1) * $registros; 
	$this->param = "";
		$this->np = 5;
	}

	function paginar (){

		$resultados = $this->db->query($this->consulta);
		$total_registros = $this->db->num_rows($resultados);
		$cons = $this->consulta." LIMIT $this->inicio, $this->registros";
		$resultados = $this->db->query($cons);
		$this->total_paginas = ceil($total_registros / $this->registros);
		return $resultados;

	}

	

	function anterior( $texto="&laquo; Anterior",$var='' ){

		if(($this->pagina - 1) > 0) {

		 	$pag = $this->pagina-1;

		    return '<li><a class="previous i-previous" title="'.$texto.'" href="'.$this->param.'-pagina-'.$pag.$this->variable.'">
<img class="v-middle"  alt="'.$texto.'" src="'.URLVISTA.'skin/comercio/media/pager_arrow_left.gif">
</a></li>';

		}

	}

	

	function numeracion(){

		$ini = $this->pagina-intval($this->np/2);

		$html ="";

		if($ini < 1) $ini = 1;

		$fin = $this->pagina+intval($this->np/2);

		if($fin > $this->total_paginas) $fin = $this->total_paginas;

		for ($i=$ini;  $i <= $fin ; $i++){

			if ($this->pagina == $i) {

				$html .='<li class="current">'.$this->pagina.'</li>';

			} else {

				$html .='<li><a href="'.$this->param.'-pagina-'.$i.$this->variable.'">'.$i.'</a></li>';

			}

		}

		return $html;

	}

	

	function siguiente( $texto= "&raquo; Siguiente" ){


		if(($this->pagina + 1)<=$this->total_paginas) {

			$pag = $this->pagina+1;

			return '<li><a class="next i-next" href="'.$this->param.'-pagina-'.$pag.$this->variable.'" title="'.$texto.'">
                                <img src="'.URLVISTA.'skin/comercio/media/pager_arrow_right.gif" alt="'.$texto.'" class="v-middle" />
                            </a>
                        </li>'; 

		}

	}

	function siguientePag(){
		if(($this->pagina + 1)<=$this->total_paginas) {
			$pag = $this->pagina+1;
			return $pag; 
		}
		else
		return '';
	}

}

?>