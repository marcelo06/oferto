<? include("includes/tags.php")?>
<script src="<?= URLBASE?>system/src/ui/touch.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?= URLSRC ?>css/icheck/all.css">
<?= plugin::message() ?>
<!-- CKEditor -->
<script type="text/javascript">
 
    var urlbase    = '<?= URLBASE ?>';
    var urlvista   = '<?= URLVISTA ?>';
    var identificador = '<?= nvl($reg['id_producto']) ?>';
    var precio = <?= nvl($reg['precio'])?>;
    var dias_oferta=<?=$dias_oferta?>;

    $.validator.addMethod("preciomenor", function (value, element, options){
	   var targetEl = $('input[name="'+options.data+'"]'),
	        preciomenor = parseInt(precio)-parseInt(value);
	    return preciomenor>0;
	});

</script>
<style type="text/css">
#lista_almacenes li .task {left:47px;right:5px;}
</style>
</head>

<body data-mobile-sidebar="button">
	<? include("includes/header.php") ?>
	<div class="container-fluid" id="content">
		<? include("includes/menu.php") ?>
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1><?=$tarea?> Oferta</h1>
					</div>

				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="login-inicio">Inicio</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="producto-list_ofertas">Listado de Productos en Oferta</a>

						</li>
                        <li>
							<a href="javascript:;"><?=$tarea?> Oferta</a>

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
                     <input type="hidden" name="nuevo" value="<?= ($reg['oferta_descripcion']=='' and $reg['oferta_precio']==0 and $reg['oferta_imagen']=='' and $reg['oferta_publicacion']=='00/00/0000' and $reg['oferta_vencimiento']=='00/00/0000') ? 1:0 ?>"/>
                     <div class="box">
                     <div class="box box-color box-bordered lightgrey">
                     <div class="box-title">
								<h3>Información del producto</h3>
								<div class="actions">
									<a class="btn" href="producto-edit_producto-producto-<?=$reg['id_producto']?>"><i class="icon-edit"></i> Editar</a>
								</div>
							</div>
                     <div class="box-content">
                                        <div class="row-fluid">
										<div class="span6">
											<strong>Nombre Producto</strong>:<br> <?= nvl($reg['nombre']) ?>
										</div>
                                     
                                          <div class="span3" ><strong>Referencia</strong>:<br> <?= nvl($reg['referencia']) ?>
                                          </div>
                                          
                                          <div class="span3"><strong>Precio</strong>:<br>  <?= nvl($reg['precio']) ?>
                                          </div>
                                          </div>
              
                               
                                  
                                   </div>
                         </div>          
                                   
                         
                        <div class="box-content">
                                <div class="row-fluid">
                                    <div class="span8">
											<div class="control-group">
												 <label class="control-label" for="input01"><span rel="tooltip" title="" data-original-title="REEMPLAZA EL NOMBRE DEL PRODUCTO EN EL SITIO WEB Y EN OFERTO.CO"><i class="glyphicon-circle_question_mark"></i></span> Nombre de la oferta:

 </label>
												<div class="controls controls-row">
													<input type="text"  placeholder="Descripción:" name="dat[oferta_descripcion]" class='span12' id="oferta_descripcion" value="<?php pv($reg['oferta_descripcion']) ?>"/>
												</div>
											</div>
										</div>

										<div class="span4">
                                    <label class="control-label" for="input01"><span rel="tooltip" title="" data-original-title="SI ESTA ACTIVO Y SE ASIGNA 0, EL SISTEMA LO MOSTRARÁ COMO OFERTA AGOTADA"><i class="glyphicon-circle_question_mark"></i></span> Mostrar # unidades de oferta disponibles 
                                    	<input type="checkbox" name="dat[oferta_existencia_estado]" id="oferta_existencia_estado" value="1" onChange="check_existencia()" <?=(nvl($reg['oferta_existencia_estado'],'0')=='1') ? 'checked':''?>  />

                                    	
                                    </label>
                                    <div class="controls" id="datos_existencia">
                                       <input name="dat[oferta_existencia]" type="text" placeholder="Unidades disponibles:" class="span13t existencia" value="<?= nvl($reg['oferta_existencia']) ?>" />
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="row-fluid">      
                                  <div class="span6">
                                    <label class="control-label" for="input01"><span rel="tooltip" title="" data-original-title="EL PRECIO DE LA OFERTA DEBE SER MENOR QUE EL PRECIO DEL PRODUCTO."><i class="glyphicon-circle_question_mark"></i></span> Precio de Oferta: </label>
                                    <div class="controls control-group">
                                    	 <input name="precio" id="precio" type="hidden" value="<?= nvl($reg['precio'],0)?>" />
                                       <input name="dat[oferta_precio]" id="oferta_precio" type="text" data-rule-required="true" data-rule-preciomenor="true" data-msg-preciomenor="El precio de oferta debe ser menor que el precio del producto." placeholder="Precio:" class="span13t precios" value="<?= (nvl($reg['oferta_precio'],0)==0) ? '': $reg['oferta_precio'] ?>" />
                                    </div>
                                  </div>
                                  
                              </div>
                                          
                                <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
											<label for="archivo_oferta" class="control-label"> <span rel="tooltip" title="" data-original-title="AGREGA UNA IMAGEN PROMOCIONAL PARA LA OFERTA DEL PRODUCTO EN EL SITIO WEB Y EN OFERTO.CO"><i class="glyphicon-circle_question_mark"></i></span> Anuncio gráfico (<strong>1024px ancho x 550px de alto</strong>)</label>
                                            <input type="hidden" name="delimgoferta" id="delimgoferta" value="0"/>
											<div class="controls">
												<div class="fileupload fileupload-<?=(nvl($reg['oferta_imagen'])!='') ?'exists':'new'?>" data-provides="fileupload">
													<div class="fileupload-new thumbnail" style="width: 110px; height: 81px;"><img src="<?=URLVISTA?>admin/img/noimage.gif" /></div>
													<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 200px; line-height: 20px;">
                                                    <?=(nvl($reg['oferta_imagen'])!='') ?'<img src="'.URLFILES.'productos/m'.$reg['oferta_imagen'].'" />':''?>
                                                    </div>
													<div>
														<span class="btn btn-file"><span class="fileupload-new">Seleccione una imagen</span><span class="fileupload-exists">Cambiar</span><input type="file" name='archivo_oferta' id="archivo_oferta" /></span>
														<a href="javascript:void(0)" onClick="borrararch('oferta')" class="btn fileupload-exists" data-dismiss="fileupload">Eliminar</a>
													</div>
												</div>
											</div>
										</div>
										</div>
                                 </div>
                                 <div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="titulo" class="control-label">Fecha Publicación: </label>
												<div class="controls controls-row">
													<input type="text" placeholder="Fecha Publicación:" class="input-block-level" data-date-format="dd/mm/yyyy" data-rule-required="true"  name="oferta_publicacion" id="oferta_publicacion"  value="<?=(nvl($reg['oferta_publicacion'])!='' and nvl($reg['oferta_publicacion'])!='00/00/0000') ? $reg['oferta_publicacion']: date("d/m/Y");?>"/>
												</div>
											</div>
										</div>

										<div class="span6">
											<div class="control-group">
												<label for="titulo" class="control-label">Fecha Vencimiento: </label>
												<div class="controls controls-row">
													<input type="text" placeholder="Fecha Vencimiento:" class="input-block-level" data-date-format="dd/mm/yyyy" data-rule-required="true"  name="oferta_vencimiento" id="oferta_vencimiento"  value="<?=(nvl($reg['oferta_vencimiento'])!='' and nvl($reg['oferta_vencimiento'])!='00/00/0000') ? $reg['oferta_vencimiento']: '';?>"/>
												</div>
											</div>
										</div>

									</div>
                               <div class="row-fluid">
										<div class="span12">
											<div class="control-group">
 <label class="control-label" for="input01">Términos y condiciones: </label>
												<div class="controls controls-row">
													<textarea  placeholder="Términos:" name="dat[oferta_terminos]" class='span12' id="oferta_terminos" ><?php pv($reg['oferta_terminos']) ?></textarea>
												</div>
											</div>
										</div>

									</div> 
                        </div>
              <? if(nvl($reg['oferta_portal'])=='Activo'){?>
              <h3> Información válida para el portal Oferto.co</h3>
              <div class="row-fluid">
                    <div class="span12">
                    <div class="box box-color box-bordered lightgrey">
							<div class="box-title">
								<h3><i class="icon-ok"></i> Oferta válida en los Almacenes:</h3>
								
							</div>
							<div class="box-content nopadding">
								<ul class="basiclist" id="lista_almacenes">
                                <li id="li_todos" style="width:100%; clear:both">
                                    <div class="check">
											<input type="checkbox" class='icheck-me todosalm' data-skin="square" data-color="blue" name="dat[oferta_almacen]" <?=(nvl($reg['oferta_almacen'])!='seleccionados') ? 'checked':''?> value="todos" id="almtodos" onChange="check_almacenes()"/>
										</div>
										<span class="task"><span>Válido en todos los almacenes</span></span>
								</li>
                                    
									<? $i=0; foreach($almacenes as $alm){
										
										 $checked='';
										 if($alm['id_producto'])
										 	$checked='checked="checked"';?> 
									<li id="li_<?=$alm['id_almacen']?>" class="lialm">
                                    <div class="check">
											<input type="checkbox" class='icheck-me checkalm' data-skin="square" data-color="blue" name="alm[<?=$i?>][id_almacen]" <?=$checked?> value="<?=$alm['id_almacen']?>" id="alm<?=$alm['id_almacen']?>" />
										</div>
										<span class="task"><span ><?=$alm['nombre']?></span></span>
										
									</li>
                                    <? $i++; }?>
									
									
								</ul>
                                
							</div>
						</div>
                                       
                    </div>
                    </div>
				  
			 <?  }	?>
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

		
		<!-- Datepicker -->
			<link rel="stylesheet" href="<?= URLSRC ?>css/datepicker/datepicker.css">
			<script src="<?= URLSRC ?>js/datepicker/bootstrap-datepicker.js"></script>
            <script src="<?= URLSRC ?>js/icheck/jquery.icheck.min.js"></script>
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/mensaje.js"></script>
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/edit_oferta.js"></script>
		<script type="text/javascript">
		var mensaje = '<?= nvl($mensaje) ?>';
		var mensaje_tipo = '<?= nvl($mensaje_tipo, 'success') ?>'
		</script>
	</body>

	</html>

