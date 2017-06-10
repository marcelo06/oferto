<? include("includes/tags.php")?>
<?= plugin::fancybox_2_1() ?>
<?= plugin::message() ?>
<!-- dataTables -->
<link rel="stylesheet" href="<?=URLSRC?>css/TableTools.css">
<!-- chosen -->
<link rel="stylesheet" href="<?=URLSRC?>css/chosen/chosen.css">
<!-- dataTables -->
<script type="text/javascript">
nombre='Empresas';
</script>
</head>

<body data-mobile-sidebar="button"  >
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
						<a class="btn btn-primary btn-large" href="empresa-edit_empresa" > Nueva Empresa </a> <a class="btn btn-large" href="empresa-categorias" > Administrar Categorías </a>
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="icon-table"></i>
									Lista de Empresas
								</h3>
								<div class="actions">
									<a class="btn" href="empresa-exportar"><i class="icon-save"></i> Exportar</a>
								</div>
							</div>
							<div class="box-content nopadding">

								<table class="table table-hover table-nomargin table-bordered" id="usuarios">
									<?= $tabla ?>
									
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	

	</div>


	<? include("includes/footer.php") ?>
	<script src="<?=URLSRC?>js/datatable/jquery.dataTables.min.js"></script>
	<script src="<?=URLSRC?>js/datatable/TableTools.min.js"></script>
	<script src="<?=URLSRC?>js/datatable/ColReorder.min.js"></script>
	<script src="<?=URLSRC?>js/datatable/ColVis.min.js"></script>
	<script src="<?=URLSRC?>js/datatable/jquery.dataTables.columnFilter.js"></script>
	<script src="<?=URLSRC?>js/chosen/chosen.jquery.min.js"></script>
	<script src="<?= URLVISTA ?>admin/js/list_usuarios.js"></script> 
</body>
</html>
