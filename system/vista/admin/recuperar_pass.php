<? include ("includes/tags.php") ?>
	
</head>
<body>
	<div class="wrapper" style="padding:15px 50px; max-width:500px;">
		<h1><img alt="oferto" src="<?=URLVISTA?>images/logo.png" class="img-responsive"></h1>
		<div class="login-body" i>

			<h4>CAMBIAR CONTRASEÑA</h4>

			<form id="login-form" class='form-validate'  action="" method="POST">
		<? if(isset($tipo)){ ?>
			<div class="alerts-inf alert alert-<?= $tipo ?>"  >
	         <span id="alerts-inf-txt"><strong><?= nvl($mensaje) ?></strong></span>
	       </div>
	      	<? }else{ ?>
				<div class="control-group">
					<div class="controls">
						<input type="password" name="pass" id="password" placeholder="Nueva Contraseña:" class="input-block-level" value="" data-rule-required="true" data-rule-minlength="5" />
					</div>
				</div>
				<div class="control-group">
					<div class="pw controls">
						<input type="password" name="repass" id="repassword" placeholder="Repetir Contraseña:" class="input-block-level" value="" data-rule-equalTo="#password" data-rule-required="true" data-rule-minlength="5"/>
					</div>

				</div>
				<? } ?>
				<? if(!isset($tipo)){ ?>
				<div class="submit">
					<button class="btn btn-primary" type="submit" id="login">Cambiar</button>
				</div>
				<? }?><br/>
			</form>
			
		</div>
	</div>

</body>
</html>