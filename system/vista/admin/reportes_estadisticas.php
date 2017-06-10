<? include("includes/tags.php") ?>
<style type="text/css">
.basiclist li{
	width:100%;
	clear:both;
}
.basiclist li .num {
  border-right:1px solid #FEC5BD;
  float: left;
  padding-bottom: 10px;
  padding-left: 10px;
  padding-right: 10px;
  padding-top: 10px;
  width:70px;
  text-align:right;
  font-size:1.1em;
}
#reporte li .task,.lproductos  li .task{
  left: 95px;
}
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
							<h1>Reportes</h1>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span12">
							<div class="box box-color box-bordered">

								<div class="box-title">
									<h3><i class="icon-bar-chart"></i>Números Registrados</h3>
									<div class="actions">
										<a class="btn btn-mini content-slideUp" href="#"><i class="icon-angle-down"></i></a>
									</div>
								</div>
								<div class="box-content nopadding">
									<ul class="basiclist" id="reporte">
										<li><div class="num" id="nempresas"><?=$nempresas?></div>
											<span class="task">
												<span>Empresas Registradas <a class="task-bookmark" href="empresa-exportar" title="Exportar Empresas Registradas"><i class="icon-save"></i></a></span>
											</span>
											
										</li>
										
										<li><div class="num" id="nventas"><?=$npedidos?></div>
											<span class="task">
												<span>Ventas realizadas. 
													<strong><?=$npedidos_oferto?></strong> En Oferto.co, <strong><?=$npedidos_empresas?></strong> En Mini sitio de empresas</span>
											</span>
											</li>
											<li><div class="num" id="nusuarios"><?=$nusuarios?></div>
												<span class="task">
													<span>Clientes Registrados. 
													<strong><?=$nusuarios_oferto?></strong> En Oferto.co, <strong><?=$nusuarios_empresas?></strong> En Mini sitio de empresas <a class="task-bookmark" href="usuario-exportar_completo" title="Exportar Clientes"><i class="icon-save"></i></a></span>
												</span>
												
											</li>
										</ul>
									</div>
								</div>
							</div>

						</div>
						
						

					</div>
			</div>
			
		</div>
		<? include("includes/footer.php") ?>
		<? if(!isset($pa)){?>	
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/reportes_estadisticas.js"></script>
		<? }?>	
	</body>
	</html>