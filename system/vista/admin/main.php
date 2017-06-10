<? include("includes/tags.php") ?>
<link rel="stylesheet" href="<?=URLSRC?>css/datepicker/datepicker.css">
<script src="<?=URLSRC?>js/datepicker/bootstrap-datepicker.js"></script>
	</head>

	<body data-mobile-sidebar="button">
		<? include("includes/header.php") ?>

		<div class="container-fluid" id="content">
			<? include("includes/menu.php") ?>

			<div id="main">
				<div class="container-fluid">
					<div class="page-header">
						<div class="pull-left">
							<h1>Estadísticas</h1>
						</div>
						
					</div>
					
					<? if($instalado){ ?>
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
								<div id="widgetIframe"><iframe width="100%" height="350" src="http://oferto.co/stats/index.php?module=Widgetize&action=iframe&widget=1&moduleToWidgetize=Actions&actionToWidgetize=getPageUrls&idSite=<?=$pa?>&period=day&date=today&disableLink=1&widget=1&token_auth=8ea4aa56b794dddbaea2b47a01e13630" frameborder="0" marginheight="0" marginwidth="0"></iframe></div></div>
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
									<div id="widgetIframe"><iframe width="100%" height="350" src="http://oferto.co/stats/index.php?module=Widgetize&action=iframe&widget=1&moduleToWidgetize=Referrers&actionToWidgetize=getReferrerType&idSite=<?=$pa?>&period=day&date=today&disableLink=1&widget=1&token_auth=8ea4aa56b794dddbaea2b47a01e13630" frameborder="0" marginheight="0" marginwidth="0"></iframe></div>
							</div>
						</div>
					</div>
				</div>
				</div>
			
			<? }else{?>
			 Las estadísticas no han sido instaladas
			<? } ?>
		</div>
		</div>
		<? include("includes/footer.php") ?>
		
		<script src="<?=URLSRC?>js/chosen/chosen.jquery.min.js"></script>
		
	</body>

	</html>

