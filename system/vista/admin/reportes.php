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
					
					<? if(isset($pa)){?>
					<div class="page-header">
						<div class="pull-left">
							<h1>Estadisticas sitio web Oferto.co</h1>
						</div>
					</div>
					<div class="row-fluid">
					<div class="span12">
						<div class="box box-color box-bordered">

							<div class="box-title">
								<h3>
									<i class="icon-bar-chart"></i>
									Visitas
								</h3>
								<div class="actions">

									<a href="#" class="btn btn-mini content-slideUp"><i class="icon-angle-down"></i></a>
								</div>
							</div>
							<div class="box-content">
								
								<div id="widgetIframe"><iframe width="100%" height="350" src="http://oferto.co/stats/index.php?module=Widgetize&action=iframe&columns[]=nb_visits&widget=1&moduleToWidgetize=VisitsSummary&actionToWidgetize=getEvolutionGraph&idSite=<?=$pa?>&period=day&date=today&disableLink=1&widget=1&token_auth=8ea4aa56b794dddbaea2b47a01e13630" frameborder="0" marginheight="0" marginwidth="0"></iframe></div>
							</div>
						</div>
					</div>
					
					<div class="row-fluid">

					<div class="span6">
						<div class="box box-color lightred box-bordered">
							<div class="box-title">
								<h3>
									<i class="icon-bar-chart"></i>
									Páginas visitadas
								</h3>
								<div class="actions">

									<a href="#" class="btn btn-mini content-slideUp"><i class="icon-angle-down"></i></a>
								</div>
							</div>
							<div class="box-content">
								<div id="widgetIframe"><iframe width="100%"   height="350" src="http://oferto.co/stats/index.php?module=Widgetize&action=iframe&widget=1&moduleToWidgetize=Actions&actionToWidgetize=getPageUrls&idSite=<?=$pa?>&period=day&date=today&disableLink=1&widget=1&token_auth=8ea4aa56b794dddbaea2b47a01e13630" frameborder="0" marginheight="0" marginwidth="0"></iframe></div></div>
						</div>
					</div>
					<div class="span6">
						<div class="box box-color lightred box-bordered">
							<div class="box-title">
								<h3>
									<i class="icon-bar-chart"></i>
									Visitas por país y ciudad
								</h3>
								<div class="actions">

									<a href="#" class="btn btn-mini content-slideUp"><i class="icon-angle-down"></i></a>
								</div>
							</div>
							<div class="box-content">
									<div id="widgetIframe"><iframe width="100%" height="350" src="http://oferto.co/stats/index.php?module=Widgetize&action=iframe&widget=1&moduleToWidgetize=UserCountry&actionToWidgetize=getCity&idSite=<?=$pa?>&period=day&date=today&disableLink=1&widget=1&token_auth=8ea4aa56b794dddbaea2b47a01e13630" frameborder="0" marginheight="0" marginwidth="0"></iframe></div>
							</div>
						</div>
					</div>
				</div>

				<div class="row-fluid">

					<div class="span6">
						<div class="box box-color lightred box-bordered">
							<div class="box-title">
								<h3>
									<i class="icon-bar-chart"></i>
									Palabras Clavés en buscadores
								</h3>
								<div class="actions">

									<a href="#" class="btn btn-mini content-slideUp"><i class="icon-angle-down"></i></a>
								</div>
							</div>
							<div class="box-content">
								<div id="widgetIframe"><iframe width="100%" height="350" src="http://oferto.co/stats/index.php?module=Widgetize&action=iframe&widget=1&moduleToWidgetize=Referrers&actionToWidgetize=getKeywords&idSite=<?=$pa?>&period=day&date=today&disableLink=1&widget=1&token_auth=8ea4aa56b794dddbaea2b47a01e13630" frameborder="0" marginheight="0" marginwidth="0"></iframe></div></div>
						</div>
					</div>
					<div class="span6">
						<div class="box box-color lightred box-bordered">
							<div class="box-title">
								<h3>
									<i class="icon-bar-chart"></i>
									Referencias
								</h3>
								<div class="actions">

									<a href="#" class="btn btn-mini content-slideUp"><i class="icon-angle-down"></i></a>
								</div>
							</div>
							<div class="box-content">
									<div id="widgetIframe"><iframe width="100%" height="350" src="http://oferto.co/stats/index.php?module=Widgetize&action=iframe&widget=1&moduleToWidgetize=Referrers&actionToWidgetize=getReferrerType&idSite=<?=$pa?>&period=day&date=today&disableLink=1&widget=1&token_auth=8ea4aa56b794dddbaea2b47a01e13630"  frameborder="0" marginheight="0" marginwidth="0"></iframe></div>
							</div>
						</div>
					</div>
				</div>
				</div>
				<? }
				else{ ?>
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
												<span>Empresas Registradas </span>
											</span>
											<span class="task-actions">
												<a class="task-list" href="empresa-list_empresas" title="Listar Empresas Registradas" ><i class="icon-list"></i></a>
												<a class="task-bookmark" href="empresa-exportar" title="Exportar Empresas Registradas"><i class="icon-save"></i></a>
											</span>
										</li>
										<li><div class="num" id="nofertas"><?=$nofertas?></div>
											<span class="task">
												<span>Ofertas activas</span>
											</span>
											<span class="task-actions">
												<a class="task-list" href="producto-list_ofertas" title="Listar Ofertas activas"><i class="icon-list"></i></a>
												<a class="task-bookmark" href="producto-exportar_ofertas" title="Exportar Ofertas"><i class="icon-save"></i></a>
											</span>
										</li>
										<li><div class="num" id="nventas"><?=$npedidos?></div>
											<span class="task">
												<span>Ventas realizadas</span>
											</span>
											<span class="task-actions">
												<a class="task-list" href="pedido-list_pedidos" title="Listar Ventas"><i class="icon-list"></i></a>
												<a class="task-bookmark" href="pedido-exportar_ventas" title="Exportar Ventas"><i class="icon-save"></i></a>
											</span></li>
											<li><div class="num" id="nusuarios"><?=$nusuarios?></div>
												<span class="task">
													<span>Clientes Registrados</span>
												</span>
												<span class="task-actions">
													<a class="task-list" href="usuario-listar" title="Listar clientes"><i class="icon-list"></i> </a>
													<a class="task-bookmark" href="usuario-exportar_completo" title="Exportar Clientes"><i class="icon-save"></i></a>
												</span>
											</li>
										</ul>
									</div>
								</div>
							</div>

						</div>
						<div class="row-fluid">
							<div class="span6">
								<div class="box box-color box-bordered">
									<div class="box-title">
										<h3><i class="icon-bar-chart"></i>Productos más vendidos</h3>
										<div class="actions">
											<a class="btn btn-mini " href="producto-exportar-orden-compras" title="Exportar productos más vendidos"><i class="icon-save"></i></a>
											<a class="btn btn-mini content-slideUp" href="#"><i class="icon-angle-down"></i></a>
										</div>
									</div>
									<div class="box-content nopadding">
										<ul class="basiclist lproductos" id="productos">
										</ul>
									</div>
								</div>
							</div>
							<div class="span6">
								<div class="box box-color box-bordered">

									<div class="box-title">
										<h3><i class="icon-bar-chart"></i>Productos más Visitados</h3>
										<div class="actions">
											<a class="btn btn-mini " href="producto-exportar-orden-vtotal" title="Exportar productos más visitados"><i class="icon-save"></i></a>
											<a class="btn btn-mini content-slideUp" href="#"><i class="icon-angle-down"></i></a>
										</div>
									</div>
									<div class="box-content nopadding">
										<ul class="basiclist lproductos" id="visitados">

										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span6">
								<div class="box box-color box-bordered">
									<div class="box-title">
										<h3><i class="icon-bar-chart"></i>Clientes siguiendo empresas</h3>
										<div class="actions">
											<!--a class="btn btn-mini " href="usuario-exportar_siguiendo" title="Exportar clientes siguiendo empresas"><i class="icon-save"></i></a-->
											<a class="btn btn-mini content-slideUp" href="#"><i class="icon-angle-down"></i></a>

										</div>
									</div>
									<div class="box-content nopadding">
										<ul class="basiclist lproductos" id="usuarioss">
										</ul>
									</div>
								</div>
							</div>
							<div class="span6">
								<div class="box box-color box-bordered">
									<div class="box-title">
										<h3><i class="icon-bar-chart"></i>Últimas Empresas Registradas</h3>
										<div class="actions">
											<a class="btn btn-mini content-slideUp" href="#"><i class="icon-angle-down"></i></a>

										</div>
									</div>
									<div class="box-content nopadding">
										<ul class="basiclist" id="empresas">

										</ul>
									</div>
								</div>
							</div>


						</div>
						<? }?>
				</div>
			</div>
			
		</div>
		<? include("includes/footer.php") ?>
		<? if(!isset($pa)){?>	
		<script type="text/javascript" src="<?= URLVISTA ?>admin/js/reportes.js"></script>
		<? }?>	
	</body>
	</html>