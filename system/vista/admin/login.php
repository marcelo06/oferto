<? include ("includes/tags.php") ?>

	<!-- icheck >
    <link rel="stylesheet" href="<?=URLVISTA?>admin/css/plugins/icheck/all.css">
	<script src="<?=URLVISTA?>admin/js/plugins/icheck/jquery.icheck.min.js"></script-->

    <link rel="stylesheet" href="<?= URLSRC ?>smoke/smoke.css" type="text/css" media="screen" />
<link id="theme" rel="stylesheet" href="<?= URLSRC ?>smoke/themes/dark.css" type="text/css" media="screen" />
<script src="<?= URLSRC ?>smoke/smoke.js" type="text/javascript"></script>


    <script language="javascript" type="text/javascript" src="<?= URLVISTA ?>admin/js/login.js" ></script>
</head>

<body class='login'>
	<div class="wrapper">
		<h1><a>OFERTO</a></h1>
		<div class="login-body" id="login-form">

			<h2>ÁREA DE ACCESO</h2>

             <div class="alerts-inf alert alert-error" style="display:none;">

         <span id="alerts-inf-txt"><strong>Error!</strong>  Usuario o Contraseña Incorrecta!</span>
       </div>
			<form class='form-validate' id="test">
				<div class="control-group">
					<div class="email controls">
						<input type="text" name='user' id="user" placeholder="Usuario:" class='input-block-level' data-rule-required="true">
					</div>
				</div>
				<div class="control-group">
					<div class="pw controls">
						<input type="password" name="pass" id="password" placeholder="Contraseña:" class='input-block-level' data-rule-required="true">
					</div>

				</div>
				<div class="submit">

					<input type="button"  onClick="validar()"  id="login" value="Ingresar" class='btn btn-primary'>
				</div>
			</form>
			<div class="forget">
				<a  href="javascript:;" id="lost"><span>¿Olvidó su contraseña?</span></a>
			</div>
		</div>
	</div>

</body>

</html>
