<? include("includes/tags.php")?>
<?= plugin::fancybox_2_1() ?>
<?= plugin::message() ?>
<script src="<?= URLBASE?>system/src/editable/jquery.jeditable.mini.js" type="text/javascript"></script>

<!-- dataTables -->

	<link rel="stylesheet" href="<?= URLSRC ?>css/datatable/TableTools.css">
    <!-- chosen -->
	<link rel="stylesheet" href="<?= URLSRC ?>css/chosen/chosen.css">
<!-- dataTables -->
<script type="text/javascript">
buscar= '<?=nvl($buscar)?>';
puedeEditar=<?=($_SESSION['id_tipo_usuario']==4) ? 1:0 ?>
</script>
<style type="text/css">
table.dataTable td select{ width: 125px !important; float: left;}
</style>
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
                  	<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="icon-table"></i>
									Lista de Pedidos
								</h3>
								<? if($_SESSION['id_tipo_usuario']==2){?>
							<div class="actions">
									<a class="btn" href="pedido-exportar_ventas"><i class="icon-save"></i> Exportar</a>
								</div>
								<?} ?>
							</div>
							<div class="box-content nopadding">
                            
								<table class="table table-hover table-nomargin table-bordered " id="pedidos">
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
        	<script src="<?= URLSRC ?>js/datatable/jquery.dataTables.min.js"></script>
	<script src="<?= URLSRC ?>js/datatable/TableTools.min.js"></script>
	<script src="<?= URLSRC ?>js/datatable/ColReorder.min.js"></script>
	<script src="<?= URLSRC ?>js/datatable/ColVis.min.js"></script>
	<script src="<?= URLSRC ?>js/datatable/jquery.dataTables.columnFilter.js"></script>
		    <!-- Chosen -->
		<script src="<?= URLSRC ?>js/chosen/chosen.jquery.min.js"></script>
    <script src="<?= URLVISTA ?>admin/js/list_pedidos.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
    	if(<?=($_SESSION['id_tipo_usuario']==4) ? 1:0 ?>){
    		oTable.fnSetColumnVis( 7, false );
    		
    	}
    });
	</script>
	</body>

	</html>

