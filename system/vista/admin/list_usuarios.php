<? include("includes/tags.php") ?>
<?=plugin::fancybox_2_1() ?>
<?= plugin::message() ?>
<link rel="stylesheet" href="<?=URLSRC?>css/TableTools.css">
<link rel="stylesheet" href="<?=URLSRC?>css/chosen/chosen.css">
<script type="text/javascript">
nombre='<?=$nombre?>';
</script>
<style type="text/css">
.box .box-title{padding-top:0;}
.box .box-title .tabs{float: left;}
.box.box-color .box-title .tabs > li.active > a {color: #333333;}
.box.box-color .box-title .tabs > li > a:hover {color: #000;}
.box.box-color .box-title .tabs > li > a {color: #666;}
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
						<div class="box box-color box-bordered ">
							<div class="box-title">
								<ul class="tabs tabs-inline tabs-top">
									<li class='active'>
										<a href="#first11" data-toggle='tab'><i class="icon-table"></i>Clientes Empresa</a>
									</li>
									<li>
										<a href="#second22" data-toggle='tab'><i class="icon-table"></i>Clientes de Oferto.co</a>
									</li>
								</ul>
								<? if($_SESSION['id_tipo_usuario']==2){?>
							<div class="actions" style="margin-top:10px">
									<a class="btn" href="usuario-exportar_completo"><i class="icon-save"></i> Exportar Todos</a>
								</div>
								<?} ?>	
							</div>
							
							<div class="tab-content padding tab-content-inline tab-content-bottom nopadding">
								<div class="tab-pane active" id="first11"><br/>
									<?=($_SESSION['id_tipo_usuario']==4) ? '<a class="btn btn-primary btn-large" href="usuario-editar" > Nuevo Cliente </a>':''?> <a class="btn btn-primary" href="usuario-exportar" ><i class="icon-save"></i> Exportar Clientes </a>
									<div class="box-content nopadding" style="border-top:2px solid #368EE0">
										<table class="table table-hover table-nomargin table-bordered" id="usuarios">
											<?= $tabla ?>

										</table>
									</div>
								</div>
								<div class="tab-pane" id="second22">
									<br/><a class="btn btn-primary" href="usuario-exportar-oferto-1" ><i class="icon-save"></i> Exportar Clientes Oferto </a>
									<div class="box-content nopadding">
										<table class="table table-hover table-nomargin table-bordered dataTable-scroll-x" id="usuarios_oferto">
											<?= $tabla_oferto ?>
										</table>
									</div>
								</div>
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
	<script type="text/javascript">
	$(document).ready(function() {
		if(<?=($_SESSION['id_tipo_usuario']==4) ? 1:0 ?>)
			oTable.fnSetColumnVis( 4, false );
		else{
			oTable.fnSetColumnVis( 3, false );
			oTableofe.fnSetColumnVis( 3, false );
		}
	});
	</script>
</body>
</html>