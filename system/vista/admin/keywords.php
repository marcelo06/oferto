<? include("includes/tags.php")?>
<script src="<?= URLBASE?>system/src/editable/jquery.jeditable.mini.js" type="text/javascript"></script>
<?= plugin::message() ?>
<style type="text/css">
.editable form input{
	margin-right:3px;
	font-size:12px;
}

.basiclist li:hover .task span {
 text-decoration:underline;
}


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
					<label for="nombre_keyword" class="control-label">Nombre</label>
					<div class="controls">
						<input type="text" name="nombre_keyword" id="nombre_keyword">
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<input type="button" onClick="javascript:save_cate()" class="btn btn-primary" value="Agregar">
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
						<h1>Editar Categorías</h1>
					</div>

				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="login-inicio">Inicio</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="producto-list_productos">Listado Categorías de productos</a>

						</li>
                        

					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
                    <form class='form-vertical form-validate' action="" method="post" enctype="multipart/form-data" name="form1" id="form_content">
                    
                    
            
                    
			<div class="box box-color box-bordered lightgrey">
							<div class="box-title">
								<h3><i class="icon-ok"></i> Categorías</h3>
								<div class="actions">
									<a href="#new-task" data-toggle="modal" class='btn'><i class="icon-plus-sign"></i> Agregar Categoría</a>
								</div>
							</div>
							<div class="box-content nopadding">
								<ul class="basiclist">
									<? foreach($keywords as $cate){?> 
									<li id="li_<?=$cate['id_keyword']?>">
										<span class="task"><span class="editable" id="cat_<?=$cate['id_keyword']?>"><?=$cate['keyword']?></span></span>
										<span class="task-actions">
											<a href="javascript:delete_cate(<?=$cate['id_keyword']?>)" class='task-delete' rel="tooltip" title="Borrar esta categoría"><i class="icon-remove"></i></a>
											
										</span>
									</li>
                                    <? }?>
									
									
								</ul>
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
      
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/mensaje.js"></script>
        <script type="text/javascript" src="<?= URLVISTA ?>admin/js/keywords.js"></script>
		
		<script type="text/javascript">
		var mensaje = '<?= nvl($mensaje) ?>';
		var mensaje_tipo = '<?= nvl($mensaje_tipo, 'success') ?>'
		</script>
	</body>

	</html>

