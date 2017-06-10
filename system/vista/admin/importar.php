<? include("includes/tags.php") ?>
</head>

<body data-mobile-sidebar="button">
	<? include("includes/header.php") ?>
	<div class="container-fluid" id="content">
		<? include("includes/menu.php") ?>
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>Importar Empresas</h1>
					</div>

				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="login-inicio">Inicio</a>
							<i class="icon-angle-right"></i>
						</li>
						

					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
                    <form class='form-vertical' action="" method="post" enctype="multipart/form-data" name="form1" id="form_content">
                    
                     <div class="box">
                     <div class="box box-color box-bordered lightgrey">
                     <div class="box-title">
								<h3>Importar Archivo CSV</h3>
								
							</div>
                     <div class="box-content">
                                        <div class="row-fluid">
                                    <div class="span12">
											<div class="control-group">
											
												<div class="controls controls-row">
													<input name="archivo" id="archivo" type="file" class="inputs" /> 
													
												</div>
											</div>
											<?=nvl($mensaje)?>
										</div>
                                </div>
              
                                  
                                   </div>
                         </div>          
                                   
               
								<div class="form-actions">
										<button type="submit"  name="guardar" value="Guardar" class="btn btn-primary">Guardar</button>
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
	</body>

	</html>

