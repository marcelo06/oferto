<!doctype html>
<html>
<head>
<!-- jQuery -->
<script src="<?=URLVISTA?>admin/js/jquery.min.js"></script>
<?= plugin::message() ?>
<!-- Bootstrap -->
<link rel="stylesheet" href="<?=URLVISTA?>admin/css/bootstrap.min.css">
<script type="text/javascript" src="<?= URLVISTA ?>admin/js/edit_referencia.js"></script>
<script type="text/javascript">
 var mensaje = '<?= nvl($mensaje,'') ?>';
</script>
</head>

<body data-mobile-sidebar="button">

	<div class="container-fluid" id="content">

		<div id="main">
			<div class="container-fluid">


				<div class="row-fluid">
					<div class="span12">
                    <form class='form-vertical' method="post">
                     <input type="hidden" name="id_doc" id="id_doc"  value="<?= nvl($id_doc) ?>">
           <input type="hidden" name="token" id="id_doc"  value="<?= nvl($token) ?>">
						<div class="box">
                        <div class="box-title">
								<h3></h3>
							</div>
							<div class="box-content">

									<div class="row-fluid">
										<div class="span12">
											<div class="control-group">
												<label for="referencia" class="control-label">Descripción de la imagen</label>
												<div class="controls controls-row">
													<input placeholder="Descripción:" class="input-block-level" name="referencia" id="referencia"  value="<?= nvl($referencia) ?>">
												</div>
											</div>
										</div>
                                        </div>

                                       </div>


								<div class="form-actions">
										<button type="submit" class="btn btn-primary">Aceptar</button>
										<button type="button" class="btn" onClick="parent.cerrar()">Cancelar</button>
									</div>
                                </div>

								</form>
							</div>
						</div>
					</div>
				</div>

			</div>
	</body>

	</html>

