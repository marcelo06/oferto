<? include("includes/tags.php") ?>
<?= plugin::fancybox_2_1() ?>
<?= plugin::message() ?>
<script src="<?= URLBASE?>system/src/editable/jquery.jeditable.mini.js" type="text/javascript"></script>
<!-- dataTables -->
	<link rel="stylesheet" href="<?= URLSRC ?>css/datatable/TableTools.css">
    <!-- chosen -->
	<link rel="stylesheet" href="<?= URLSRC ?>css/chosen/chosen.css">
<!-- dataTables -->
	<script src="<?= URLSRC ?>js/datatable/jquery.dataTables.min.js"></script>
	<script src="<?= URLSRC ?>js/datatable/TableTools.min.js"></script>
	<script src="<?= URLSRC ?>js/datatable/ColReorder.min.js"></script>
	<script src="<?= URLSRC ?>js/datatable/ColVis.min.js"></script>
	<script src="<?= URLSRC ?>js/datatable/jquery.dataTables.columnFilter.js"></script>
    <script src="<?= URLSRC ?>js/datatable/jquery.reload.js"></script>
    <!-- Chosen -->
	<script src="<?= URLSRC ?>js/chosen/chosen.jquery.min.js"></script>
    <script src="<?= URLVISTA ?>admin/js/list_productos.js"></script>
<style type="text/css">
	select{margin:0px;font-size:12px;width: 80px;margin-right: 3px;}
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
					
					</div>
					
				</div>
				
				<div class="row-fluid">
					<div class="span12">
                    <a class="btn btn-primary btn-large" href="producto-edit_producto" > Agregar producto </a> <a class="btn btn-large" href="categoria-categorias" > Administrar Categorías </a>  
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="icon-table"></i>
									Lista de Productos
								</h3>
								<? if($_SESSION['id_tipo_usuario']==2){?>
							<div class="actions">
									<a class="btn" href="producto-exportar_reporte"><i class="icon-save"></i> Exportar</a>
								</div>
								<?} ?>
							</div>
							<div class="box-content nopadding">
             
<div style="float:right; padding-top:10px;">
<label style="float:left; margin-right:15px;">Oferta: <select name="oferta" id="oferta" onChange="filtro()" style="margin:0">
	<option value="">Escoga una opción</option>
    <option value="inactiva">Inactiva</option>
    <option value="activa">Activa</option>
    <option value="local">Solo en Sitio Web</option>
    <option value="portal">Solo en oferto.co</option>
    
    
</select></label>

<label style="float:left; margin-right:15px;">Buscar: <input type="text" id="buscar"  onKeyUp="filtro()" style="margin:0"></label></div>

								<table class="table table-hover table-nomargin table-bordered dataTableProd" id="productos">
									 <?= $tabla ?>
									
								</table>
							</div>
						</div>
					</div>
						</div>
					</div>
				</div>	
				
			</div>
		
		
        <? include("includes/footer.php")?>
	</body>

	</html>

