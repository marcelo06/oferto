<?php

/**
  * controlador modelo Galeria
  *
  *
  *
  * @package   Galeria
  * @author	   Rhiss.net
  * @since	   201005
  * @version   20100519
  * @modified  20130315
  */

class Banners extends ModelBase
{

	public $docs;
	public $nf;
	public $dirfile;
	public $dirfileout;
    public $token;

	function __construct($token = null){
		parent::__construct();
		$this->dirfile = FILES."banners/";
		$this->dirfileout = URLFILES."banners/";
        $this->token = $token;
        $this->docs[$token] = array();
        $this->nf[$token] = 0;
	}


	public function guardar ($id=0 ){
		if(is_numeric($id) && $id > 0){
			$this->db->update($this->datos ,BANNERS, "id_galeria = '$id'" );
		}else{
			$this->db->insert($this->datos, BANNERS);
			$id = $this->db->insert_id();
		}
		$this->guardarDocs($id);
		$this->borrarDocs();
        $this->nf[$this->token] = NULL;
        $this->docs[$this->token] = NULL;
        $this->sincronizar();
		return $id;
	}


	private function guardarDocs($id){
		if($this->nf[$this->token] > 0){
			$this->db->query("delete from ".BANNER_IMAGENES." where id_galeria = '$id'");
			for($j=1;$j<=$this->nf[$this->token];$j++)
				if($this->docs[$this->token]['estado'][$j] != 0){
					$gal['id_galeria'] = $id;
					$gal['archivo'] = $this->docs[$this->token]['archivo'][$j];
					$gal['imagen'] = $this->docs[$this->token]['imagen'][$j];
					$gal['referencia'] = $this->docs[$this->token]['referencia'][$j];
					$gal['vinculo'] = $this->docs[$this->token]['vinculo'][$j];
					$gal['posicion'] = $this->docs[$this->token]['posicion'][$j];
					$this->db->insert($gal, BANNER_IMAGENES);
				}
		}
	}


	public function borrar($id){
		$outimg = $this->db->query("select archivo from ".BANNER_IMAGENES." where id_galeria = '$id' ");

		if($this->db->num_rows($this->db->query("select id_galeria from ".BANNERS." where id_galeria = '$id' ")) > 0 ){
			if($this->db->num_rows($outimg) > 0 ){
				while($delimg = $this->db->fetch_object($outimg)){
				    if( file_exists($this->dirfile."s".$delimg->archivo) )
					    @unlink($this->dirfile."s".$delimg->archivo);

   				    if( file_exists($this->dirfile."b".$delimg->archivo) )
					   @unlink($this->dirfile."b".$delimg->archivo);

				}
			}
			$this->db->query("delete from ".BANNERS." where id_galeria = '$id' ");
			return true;
		}else
			return false;
	}


	public function obtener($id){
		$this->datos = $this->db->fetch_array($this->db->query("select * from ".BANNERS." where id_galeria = '$id'"));
		$this->obtenerDocs($id);
		return $this->datos;
	}
	
	public function obtenerEmpresa($id){
		$this->datos = $this->db->fetch_array($this->db->query("select * from ".BANNERS." where id_empresa = '$id'"));
		$this->obtenerDocs($id);
		return $this->datos;
	}


	public function obtener_img($id){
		return $this->db->result_array($this->db->query("select i.* from ".BANNER_IMAGENES." i left join ".BANNERS." s on s.id_galeria=i.id_galeria where s.id_galeria=".$id));
	}

	private function obtenerDocs($id){
		$this->nf[$this->token] = 0;
		$out = $this->db->query("select * from ".BANNER_IMAGENES." where id_galeria = '$id' order by posicion");
		while($img = $this->db->fetch_array($out)){
			$this->nf[$this->token]++;
			$this->docs[$this->token]['archivo'][$this->nf[$this->token]] = $img['archivo'];
			$this->docs[$this->token]['imagen'][$this->nf[$this->token]] = $img['imagen'];
			$this->docs[$this->token]['referencia'][$this->nf[$this->token]] = $img['referencia'];
			$this->docs[$this->token]['vinculo'][$this->nf[$this->token]] = $img['vinculo'];
			$this->docs[$this->token]['posicion'][$this->nf[$this->token]] = $this->nf[$this->token];
			$this->docs[$this->token]['estado'][$this->nf[$this->token]] = 1;
		}
		$this->sincronizar();
	}


	public function obtenerDoc($id,$tipo='s'){
		$img = $this->db->fetch_object($this->db->query("select * from ".BANNER_IMAGENES."  where id_galeria = '$id' order by posicion asc"));
		return (file_exists($this->dirfile.$tipo.nvl($img->archivo))) ? $this->dirfileout.$tipo.nvl($img->archivo) : URLVISTA."images/noimage.png";
	}



	public function listarDocs(){
		$select = "";
		if($this->nf[$this->token] >0 )
			for($i=1;$i<=$this->nf[$this->token];$i++){
				if($this->docs[$this->token]['estado'][$i] != 0)
					$select .= "<option value='$i' >".$this->docs[$this->token]['imagen'][$i]." (".$this->docs[$this->token]['referencia'][$i].")</option>";
			}
		return $select;
	}


	public function agregarDoc( $campo, $referencia, $vinculo,$idDiv ){
		$this->nf[$this->token]++;
		$nomfile = date($this->nf[$this->token]."Ymdhis");
		$img = new images($_FILES[$campo]);

		$img->file_new_name_body = $nomfile;
		$img->file_name_body_pre = 's';
		$img->allowed = array('image/*');
		$img->image_resize = true;
		$img->image_ratio_crop = true;
		$img->image_x = 138;
		$img->image_y = 56;
		$img->process($this->dirfile);


		$img->file_new_name_body = $nomfile;
		$img->file_name_body_pre = 'b';
		$img->allowed = array('image/*');
		$img->image_resize = true;
		$img->image_ratio_crop = true;
		$img->image_x = 992;
		$img->image_y = 400;
		$img->process($this->dirfile);



		$this->docs[$this->token]['archivo'][$this->nf[$this->token]] = $nomfile.'.'.$img->file_dst_name_ext;
		$this->docs[$this->token]['imagen'][$this->nf[$this->token]] = $img->file_src_name;
		$this->docs[$this->token]['referencia'][$this->nf[$this->token]] = $referencia;
		$this->docs[$this->token]['vinculo'][$this->nf[$this->token]] = $vinculo;
        $this->docs[$this->token]['idDiv'][$this->nf[$this->token]] = $idDiv;
        $this->docs[$this->token]['posicion'][$this->nf[$this->token]] = nvl($this->docs[$this->token]['posicion'][$this->nf[$this->token]-1],'-1') + 1;

		$this->docs[$this->token]['estado'][$this->nf[$this->token]] = 2;         // 0 = borrada, 1 = vieja, 2 = nueva
		$this->sincronizar();
	}


	private function borrarDocs($tipo = 0){
		if($this->nf[$this->token] >0 )
			for($i=1;$i<=$this->nf[$this->token];$i++){
				if($this->docs[$this->token]['estado'][$i] == $tipo){
				   if( file_exists($this->dirfile."s".$this->docs[$this->token]['archivo'][$i]) )
					@unlink($this->dirfile."s".$this->docs[$this->token]['archivo'][$i]);

				   if( file_exists($this->dirfile."b".$this->docs[$this->token]['archivo'][$i]) )
					@unlink($this->dirfile."b".$this->docs[$this->token]['archivo'][$i]);

 				}
			}
	}


	public function obtenerGaleria($id_galeria){
		$this->datos = $this->db->fetch_array($this->db->query("select * from ".BANNERS." where id_galeria = '$id_galeria'"));
		return $this->datos;
	}

	public function ordenarArreglo($arregloOrdenamiento){
		$this->retomar();
		$longitud = count($arregloOrdenamiento);

		for($i=1; $i<= $longitud;$i++){

			if($this->docs[$this->token]['posicion'][$arregloOrdenamiento[$i-1]] != 0)
				$this->docs[$this->token]['posicion'][$arregloOrdenamiento[$i-1]] = $i;
		}

		$this->sincronizar();

	}


	private function sincronizar(){
	    $_SESSION['docs'][$this->token] = $this->docs[$this->token];
		$_SESSION['nf'][$this->token] = $this->nf[$this->token];
	}


	public function iniciar(){
		$_SESSION['docs'][$this->token] = NULL;
		$_SESSION['nf'][$this->token] = 0;
	}


	public function retomar(){
		if( isset($_SESSION['nf'][$this->token]) ){
			$this->docs = $_SESSION['docs'];
			$this->nf[$this->token] = $_SESSION['nf'][$this->token];
		}
	}


	public function subir_nivel($ni){
		for($i=$ni-1; $i>= 0; $i--){
			if($this->docs[$this->token]['estado'][$i] != 0){
				$temp = $this->img_temp($i);
				$this->docs[$this->token]['archivo'][$i]    = $this->docs[$this->token]['archivo'][$ni];
				$this->docs[$this->token]['imagen'][$i]     = $this->docs[$this->token]['imagen'][$ni];
				$this->docs[$this->token]['referencia'][$i] = $this->docs[$this->token]['referencia'][$ni];
				$this->docs[$this->token]['vincculo'][$i] = $this->docs[$this->token]['vincculo'][$ni];
				$this->docs[$this->token]['estado'][$i]     = $this->docs[$this->token]['estado'][$ni];
				$this->docs[$this->token]['idDiv'][$i]     = $this->docs[$this->token]['idDiv'][$ni];

				$this->docs[$this->token]['archivo'][$ni]    = $temp['archivo'];
				$this->docs[$this->token]['imagen'][$ni]     = $temp['imagen'];
				$this->docs[$this->token]['referencia'][$ni] = $temp['referencia'];
				$this->docs[$this->token]['vinculo'][$ni] = $temp['vinculo'];
				$this->docs[$this->token]['estado'][$ni]     = $temp['estado'];
				$this->docs[$this->token]['idDiv'][$ni]     = $temp['idDiv'];
				$this->sincronizar();
				return true;
			}
		}
		return false;
	}



	public function bajar_nivel($ni){
		for($i=$ni+1; $i<= $this->nf[$this->token]; $i++){
			if($this->docs[$this->token]['estado'][$i] != 0){
				$temp = $this->img_temp($i);

				$this->docs[$this->token]['archivo'][$i]    = $this->docs[$this->token]['archivo'][$ni];
				$this->docs[$this->token]['imagen'][$i]     = $this->docs[$this->token]['imagen'][$ni];
				$this->docs[$this->token]['referencia'][$i] = $this->docs[$this->token]['referencia'][$ni];
				$this->docs[$this->token]['vinculo'][$i] = $this->docs[$this->token]['vinculo'][$ni];
				$this->docs[$this->token]['estado'][$i]     = $this->docs[$this->token]['estado'][$ni];
				$this->docs[$this->token]['idDiv'][$i]     = $this->docs[$this->token]['idDiv'][$ni];

				$this->docs[$this->token]['archivo'][$ni]    = $temp['archivo'];
				$this->docs[$this->token]['imagen'][$ni]     = $temp['imagen'];
				$this->docs[$this->token]['referencia'][$ni] = $temp['referencia'];
				$this->docs[$this->token]['vinculo'][$ni] = $temp['vinculo'];
				$this->docs[$this->token]['estado'][$ni]     = $temp['estado'];
				$this->docs[$this->token]['idDiv'][$ni]     = $temp['idDiv'];
				$this->sincronizar();

				return true;
			}
		}
		return false;
	}

	/**
	 * img_temp
	 *
	 * se genera una arreglo temporal para el traspaso de las imagenes de posicion
	 * posicion($ni)
	 *
	 * @access	private
	 * @author	Rhiss.net
	 * @since	20100519
	 * @version	20100519
	 * @return 	array.
	 */

	private function img_temp($ni){
		$tmp['archivo']     = $this->docs[$this->token]['archivo'][$ni];
		$tmp['imagen']      = $this->docs[$this->token]['imagen'][$ni];
		$tmp['referencia']  = $this->docs[$this->token]['referencia'][$ni];
		$tmp['vinculo']  = $this->docs[$this->token]['vinculo'][$ni];
		$tmp['estado']      = $this->docs[$this->token]['estado'][$ni];
		$tmp['idDiv']       = $this->docs[$this->token]['idDiv'][$ni];
		return $tmp;
	}

	public function obtenerGaleriaFull($id_galeria){
		$sql = "
		SELECT *
		FROM ".BANNER_IMAGENES."
		WHERE id_galeria = '$id_galeria'
		ORDER BY posicion
		";
		$qid = $this->db->query($sql);
		return $this->db->result_array($qid);
	}


	public function listarGaleria($id_galeria){
	    $out = $this->db->result_array($this->db->query("select * from ".BANNER_IMAGENES." where id_galeria = '$id_galeria' order by posicion asc "));
		$posicion = 0;
		foreach($out as $reg){
			$this->nf[$this->token]++;
			$posicion++;
			$this->docs[$this->token]['archivo'][$this->nf[$this->token]] = $reg['archivo'];
			$this->docs[$this->token]['imagen'][$this->nf[$this->token]] = $reg['imagen'];
			$this->docs[$this->token]['referencia'][$this->nf[$this->token]] = $reg['referencia'];
			$this->docs[$this->token]['vinculo'][$this->nf[$this->token]] = $reg['vinculo'];
			$this->docs[$this->token]['idDiv'][$this->nf[$this->token]] = $reg['posicion'];
			$this->docs[$this->token]['posicion'][$this->nf[$this->token]] = $posicion;
			$this->docs[$this->token]['estado'][$this->nf[$this->token]] = 1;
		}
       $this->sincronizar();
	   return $out;

	}

}

?>