<? include("includes/tags.php") ?>
<link rel="stylesheet" type="text/css" href="<?= URLBASE?>system/src/galeryhtml5/uploadifive.css">
<link rel="stylesheet" type="text/css" href="<?= URLBASE?>system/src/galeryhtml5/extras.css">
<script src="<?= URLBASE?>system/src/galeryhtml5/jquery.uploadifive.js" type="text/javascript"></script>
<script src="<?= URLBASE?>system/src/ui/touch.js" type="text/javascript"></script>
<script src="<?= URLBASE?>system/src/editable/jquery.jeditable.mini.js" type="text/javascript"></script>




<link rel="stylesheet" href="<?= URLSRC ?>css/icheck/all.css">
<!-- Tagsinput -->
	<link rel="stylesheet" href="<?= URLSRC ?>tagsInput_master/jquery.tagsinput.css">
	<!--link rel="stylesheet" href="<?= URLSRC ?>bootstrap-tagsinput/bootstrap-tagsinput.css"-->


<?= plugin::message() ?>
<!-- CKEditor -->
<script type="text/javascript">
    var id_sesion  = '<?= $id_sesion ?>';
    var urlbase    = '<?= URLBASE ?>';
    var urlvista   = '<?= URLVISTA ?>';

    var id_galeria = '<?= nvl($reg['id_galeria']) ?>';

    var identificador = '<?= nvl($reg['id_producto']) ?>';

    var mensaje = '<?= nvl($mensaje) ?>';
	var mensaje_tipo = '<?= nvl($mensaje_tipo, 'success') ?>'
</script>
<style type="text/css">
.editable form input{
	margin-right:3px;
	font-size:12px;
}

#lista_categorias li:hover .task span {
 text-decoration:underline; 
}
#lista_categorias li .task{
	left:47px;
	right:5px;
}


#lista_opciones li .task{
	left:47px;
	right:65px;
}

#lista_opciones li{
	width: 100%
}

.adicionales input[type="text"]{
  padding-bottom: 1px;
  padding-top: 1px;
  margin-bottom:0;
  width:97%
}
.adicionales .span13t{
	min-height:23px;
}
.adicionales li .task {
	right:40px;
}
.adicionales li{
	width:100%;
}
.adicionales li .task span {
	width:100%;
}
.addimage {height: 56px;width: 104px;}
a.fancybox-thumbs,a.fancybox-thumbs:hover {width: 104px;}

</style>
</head>

<body data-mobile-sidebar="button">
<div id="new-task" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button id="close_add" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Agregar Categoría</h3>
		</div>
		<form action="#" class='new-task-form form-horizontal form-bordered'>
			<div class="modal-body nopadding">
				
				<div class="control-group">
					<label for="nombre_categoria" class="control-label">Nombre</label>
					<div class="controls">
						<input type="text" name="nombre_categoria" id="nombre_categoria">
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<input type="button" onClick="javascript:save_cate()" class="btn btn-primary" value="Agregar">
			</div>
		</form>

	</div>
	<div id="new-opcion" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button id="close_adi" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel_adi">Agregar Opción</h3>
		</div>
		<form action="#" class='new-task-form form-horizontal form-bordered'>
			<div class="modal-body nopadding">
				<div class="control-group">
					<label for="titulo" class="control-label">Nombre: </label>
					<div class="controls controls-row">
						<input name="adic[adicional]"  id="adicional_n" type="text"  value="" onKeyUp="actualizar_adicional('n')"/>
					</div>
				</div>
				<div class="control-group">
					<label for="textfield" class="control-label">Escriba las opciones para <span id="tad_n">""</span> <span rel="tooltip" title="" data-original-title="Escriba las opciones separadas por coma o dando Enter en el teclado" data-placement="right" ><i class="glyphicon-circle_question_mark"></i></span></label>
					<div class="controls">
						<input type="text" name="opt" id="opciones" class="" value="">
					</div>
				</div>


				
			</div>
			<div class="modal-footer">
				<input type="button" onClick="save_adicional()" class="btn btn-primary" value="Agregar">
			</div>
		</form>

</div>

<div id="edit-opcion" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button id="close_edit" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel_adi">Editar Opción</h3>
		</div>
		<form action="#" class='new-task-form form-horizontal form-bordered'>
			<div class="modal-body nopadding">
				<input  id="id_edit" type="hidden"  value="0"/>
				<div class="control-group">
					<label for="titulo" class="control-label">Nombre: </label>
					<div class="controls controls-row">
						<input  id="adicional_edit" type="text"  value="" onKeyUp="actualizar_adicional('edit')"/>
					</div>
				</div>
				<div class="control-group">
					<label for="textfield" class="control-label">Escriba las opciones para <span id="tad_edit">""</span> <span rel="tooltip" title="" data-original-title="Escriba las opciones separadas por coma o dando Enter en el teclado" data-placement="right" ><i class="glyphicon-circle_question_mark"></i></span></label>
					<div class="controls">
						<input type="text" id="opciones_edit" class="" value="">
					</div>
				</div>


				
			</div>
			<div class="modal-footer">
				<input type="button" onClick="editar_adicional()" class="btn btn-primary" value="Editar">
			</div>
		</form>

</div>
	<? include("includes/header.php") ?>
	<div class="container-fluid" id="content">
		<? include("includes/menu.php") ?>
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1><?=$tarea?> Productos</h1>
					</div>

				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="login-inicio">Inicio</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="producto-list_productos">Listado de Productos</a>

						</li>
                        <li>
							<a href="javascript:;"><?=$tarea?> Productos</a>

						</li>

					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
                    <form class='form-vertical form-validate' action="" method="post" enctype="multipart/form-data" name="form1" id="form_content">
                     <input type="hidden" name="id" value="<? pv($reg['id_producto']) ?>" />
                     <input type="hidden" name="dat[id_empresa]" value="<?=(nvl($reg['id_empresa'],0)) ? $reg['id_empresa']: $_SESSION['id_empresa'] ?>" />

                      <div class="box">

							<div class="box-content">
                                        <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="titulo" class="control-label">Nombre: </label>
												<div class="controls controls-row">
                                              
													<input type="text" placeholder="Título:" class="input-block-level" name="dat[nombre]" id="nombre" value="<?=nvl($reg['nombre'])?>" data-rule-required="true"  />
												</div>
											</div>
										</div>
                                        

									</div>
                                     
                                        <br>
                                        <div class="row-fluid">
                                          <div class="span4" >
                                            <label class="control-label" for="input01">Referencia: </label>
                                            <div class="controls">
                                               <input placeholder="Referencia:"  name="dat[referencia]" type="text" class="span13t" value="<?= nvl($reg['referencia']) ?>" />
                                            </div>
                                          </div>
                                          
                                          <div class="span4">
                                            <label class="control-label" for="input01">Precio: </label>
                                            <div class="controls">
                                               <input name="dat[precio]" type="text" placeholder="Precio:" class="span13t precios" value="<?= nvl($reg['precio']) ?>" />
                                            </div>
                                          </div>
                                          <div class="span4">
                                    <label class="control-label" for="input01"><span rel="tooltip" title="" data-original-title="SI ESTA ACTIVO Y SE ASIGNA 0, EL SISTEMA LO MOSTRARÁ COMO PRODUCTO AGOTADO"><i class="glyphicon-circle_question_mark"></i></span> Mostrar # unidades disponibles 
                                    	<input type="checkbox" name="dat[existencia_estado]" id="existencia_estado" value="1" onChange="check_existencia()" <?=(nvl($reg['existencia_estado'],'0')=='1') ? 'checked':''?>  />

                                    	
                                    </label>
                                    <div class="controls" id="datos_existencia">
                                       <input name="dat[existencia]" type="text" placeholder="Unidades disponibles:" class="span13t precios" value="<?= nvl($reg['existencia']) ?>" />
                                    </div>
                                  </div>


                                          </div>
              
                                    
                                    
                                    <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="titulo" class="control-label">Resumen (corta descripción del productos  <span class="badge badge-inverse"> <span id="cuenta">150 </span> Caracteres </span>): </label>
												<div class="controls controls-row">
													<textarea  placeholder="Descripción:" class="input-block-level" name="dat[descripcion]" rows="3" onKeyUp="txtcontador(this,'cuenta', 150)"><? pv($reg['descripcion']) ?></textarea>
												</div>
											</div>
										</div>

									</div>

                                    
                         
                                   <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
 <label class="control-label" for="input01">Detalles: </label>
												<div class="controls controls-row">
													<textarea  placeholder="Content:" name="dat[detalles]" class='span12' id="detalles" ><?php pv($reg['detalles']) ?></textarea>
												</div>
											</div>
										</div>

									</div>
                                 </div>
                                   
                    <div class="box-title">
								<h3>Imágenes del producto</h3>
							</div>
							<div class="box-content">
                             <input type="hidden" name="id_galeria" value="<?= nvl($id_galeria,0)?>" >
        <input type="hidden" name="token" id="token" value="<?= $token ?>" />
								<div class="alert alert-info">
           <button type="button" class="close" data-dismiss="alert">×</button>
           Suba la imagen con el botón Agregar Imagen. Las imágenes deben tener un tamaño recomendado de <strong>1024px ancho x 550px de alto</strong> y un formato .jpg, .png o .gif. Sosteniendo la tecla Ctrl puede seleccionar varias imágenes al tiempo. Puede ordenar con click sostenido sobre la imagen y moviéndola hacia los lados.
           </div>
									<div class="row-fluid">
										<div class="span12">

                                          <input id="file_upload" name="file_upload" type="file" multiple/>

                                          <strong>Imágenes Cargadas:</strong>
                                          <div><ul class="sortable" id="fileQueue"><div style="clear:both"></div></ul></div>

										</div>
                                        </div>


                                       </div>
                   <div class="row-fluid">
										<div class="span12">
                                        <div class="box box-color box-bordered lightgrey">
							<div class="box-title">
								<h3><i class="icon-ok"></i> Categorías</h3>
								<div class="actions">
									<a href="#new-task" data-toggle="modal" class='btn'><i class="icon-plus-sign"></i> Agregar Categoría</a>
								</div>
							</div>
							<div class="box-content nopadding">
								<ul class="basiclist" id="lista_categorias">
									<? $i=0; foreach($categorias as $cate){
										
										 $checked='';
										 if($cate['id_producto'])
										 	$checked='checked="checked"';?> 
									<li id="li_<?=$cate['id_categoria']?>">
                                    <div class="check">
											<input type="checkbox" class='icheck-me' data-skin="square" data-color="blue" name="cat[<?=$i?>][id_categoria]" <?=$checked?> value="<?=$cate['id_categoria']?>"/>
										</div>
										<span class="task"><span class="editable" id="cat_<?=$cate['id_categoria']?>"><?=$cate['categoria']?></span></span>
										
									</li>
                                    <? $i++; }?>
									
									
								</ul>
                                <span class="hidden" id="cuenta_cate"><?=$i?></span>
							</div>
						</div>
                                       
                   	 </div>
                    </div>

                    <div class="row-fluid">
                    	<div class="span12">
                    		<div class="box box-color box-bordered lightgrey">
                    			<div class="box-title">
                    				<h3><i class="icon-ok"></i> Opciones (Colores, Tallas, Tamaños...)</h3>
                    				<div class="actions">
                    					<a href="#new-opcion" data-toggle="modal" class='btn'><i class="icon-plus-sign"></i> Agregar Opción</a>
                    				</div>
                    			</div>
                    			<div class="box-content nopadding">
                    				<ul class="basiclist" id="lista_opciones">
                    					<? $i=0; foreach($adicionales_emp as $adicional){	
                    						$checked='';
                    						if(nvl($reg['id_producto'],0) and ($adicional['id_producto']==$reg['id_producto'])) $checked='checked="checked"';?> 
                    						<li id="li_<?=$adicional['id_adicional']?>">
                    							<div class="check">
                    								<input type="checkbox" class='icheck-me' data-skin="square" data-color="blue" name="adi[<?=$i?>][id_adicional]" <?=$checked?> value="<?=$adicional['id_adicional']?>"/>
                    							</div>
                    							<span class="task"><span id="adi_<?=$adicional['id_adicional']?>"><?=$adicional['adicional']?> (<?
                    								if($opciones= adicional::obtieneDocs($adicional['id_adicional'])){
                    									$c_opciones='';	
                    									foreach($opciones as $opt){ 
                    										$c_opciones.= $opt['opcion'].', ';
                    									}
                    									$c_opciones= substr($c_opciones,0, strlen($c_opciones)-2); 
                    									echo $c_opciones;
                    								} ?>)</span></span>
                    								<span class="task-actions">
                    									<a href="#edit-opcion" data-toggle="modal" onClick="edit_adi(<?=$adicional['id_adicional']?>,'<?=$adicional['adicional']?>','<?=$c_opciones?>')"  class="task-delete" rel="tooltip" title="Editar"  ><i class="icon-edit"></i></a>
                    								<a href="javascript:delete_adi(<?=$adicional['id_adicional']?>)" class="task-delete" rel="tooltip" title="Borrar"><i class="icon-remove"></i></a>
		
													</span>
                    							</li>
                    							<? $i++; }?>
                    						</ul>
                    						<span class="hidden" id="cuenta_adi"><?=$i?></span>
                    					</div>
                    				</div>

                    			</div>
                    		</div>
                    		<div class="box-title">
								<h3>Keywords: </h3>
							</div>

                    		<div class="box-content">
                    		
                    		<div class="row-fluid">
                    			<div class="span12" >
                    				<label class="control-label" for="input01">Liste palabras claves para el buscador interno: </label>
                    				<div class="controls" style="position:relative">
                    					<input type="text" placeholder="Keywords:" id="keywords" name="keywords" value="<?=$keywords?>" class="span13t"/>

                    				</div>


                    			</div>
                    		</div>
						</div>
							
                
                      <span  class="hidden" id="nadicionales"><?=$p?></span>
                    
                     
                 
					<div class="form-actions">
										<button type="submit" class="btn btn-primary">Guardar</button>
										<button type="button" class="btn" onClick="location = 'producto-list_productos'">Cancelar</button>
									</div>

                                </div>

								</form>
							</div>
						</div>
					</div>
				</div>

			</div>

		<div style="clear:both"></div>
        <? include("includes/footer.php") ?>
       	 <script src="<?= URLSRC ?>js/ckeditor/ckeditor.js"></script>
		<script src="<?= URLSRC ?>js/imagesLoaded/jquery.imagesloaded.min.js"></script>
		<script src="<?=URLSRC?>js/touch-punch/jquery.touch-punch.min.js"></script>
		<script src="<?=URLSRC?>js/bootbox/jquery.bootbox.js"></script>

		<!-- Custom file upload -->
		<script src="<?=URLSRC?>js/fileupload/bootstrap-fileupload.js"></script>
		  <script type='text/javascript' src='<?=URLSRC?>js/jquery-ui.min.js'></script>
	<!-- TagsInput -->
	<script src="<?=URLSRC?>tagsInput_master/jquery.tagsinput.js"></script>
	<!--script src="<?=URLSRC?>bootstrap-tagsinput/bootstrap-tagsinput.js"></script-->

		
		<!-- Datepicker -->
			<link rel="stylesheet" href="<?= URLSRC ?>css/datepicker/datepicker.css">
			<script src="<?= URLSRC ?>js/datepicker/bootstrap-datepicker.js"></script>
            <script src="<?= URLSRC ?>js/icheck/jquery.icheck.min.js"></script>
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/mensaje.js"></script>
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/edit_producto.js"></script>
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/edit_galeria.js?v=1"></script>
		<script type="text/javascript">
		 var identificador = '<?= nvl($reg['id_producto']) ?>';
		var id_categoria = '<?= nvl($reg['id_categoria']) ?>';

		var mensaje = '<?= nvl($mensaje) ?>';
		var mensaje_tipo = '<?= nvl($mensaje_tipo, 'success') ?>'

		var id_sesion  = '<?= $id_sesion ?>';
		var urlbase    = '<?= URLBASE ?>';
		var urlvista   = '<?= URLVISTA ?>';

		var id_galeria = '<?= nvl($reg['id_galeria']) ?>';
		</script>
	</body>

	</html>

