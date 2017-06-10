<?php

class Correo extends ControlBase {

	static function enviar_contacto($datos){
		$nombre= $datos['nombre'];
		$email= $datos['email'];
		$telefono= $datos['telefono'];

		$preguntas=$datos['inquietudes'];

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = 'server0.terabihost.com'; //'mail'.DOMINIO;
		$mail->Port = 465;
		$mail->SMTPSecure = 'ssl';
		$mail->IsHTML(true);
		$mail->SMTPAuth = true;
		$mail->From = 'info@oferto.co'; //'info@'.DOMINIO;
		$mail->FromName = utf8_decode($nombre);
		$mail->Username = 'info@oferto.co'; //'info@'.DOMINIO;
		$mail->Password = 'Ha99en1T';
		$mail->Mailer = 'smtp';
		$mail->WordWrap = 65;

		$subject= "Contacto desde ".$_SESSION['dominiovista'];

		$mail->Subject = $subject;

		if(defined('SKIN') and isset($_SESSION['id_empresa'])){
			$emp = new Empresas();
			$empresa = $emp->obtener($_SESSION['id_empresa']);
			$mail->AddAddress($empresa['email']);
		}
		else{
			$conf = new configmodel();
			$correo_e = $conf->obtener_valor('email');
			$mail->AddAddress($correo_e);
		}

		$logo = 'http://'.DOMINIO.URLVISTA.'images/logo.png';
		$mail->AddBCC('cazp83@gmail.com');  // sitios@rhiss.net
		$cuerpo = '<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
		<title>'.$mail->Subject.'</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
		<link href="style-form.css" rel="stylesheet" type="text/css">
		<style type="text/css">
		html {
		  font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}::-moz-selection{background:#0079ff;color:#fff}::selection{background:#0079ff;color:#fff}body {
		    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color: #333333;background-color: #ffffff; padding: 0;margin: 0;;
		  }.ExternalClass,.ReadMsgBody{width:100%;background-color:#f5f7fa}a{color:#0079ff;text-decoration:none;font-weight:300;font-style:normal}a:hover{color:#adb2bb;text-decoration:underline;font-weight:300;font-style:normal}div,p{margin:0!important}table{border-collapse:collapse}@media only screen and (max-width:640px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:440px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:400px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:400px!important;height:1px!important}}@media only screen and (max-width:479px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:280px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:240px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:240px!important;height:1px!important}}
			table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}table col[class*=col-]{position:static;float:none;display:table-column}table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.center-block{display:block;margin-left:auto;margin-right:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important;visibility:hidden!important}.affix{position:fixed;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}
			</style>

	</head>
	<body bgcolor="#F5F7FA">
		<!-- START OF PRE-HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF PRE-HEADER BLOCK--><!-- START OF HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">

										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
															<tr>
																<td align="left" class="center" style="padding: 0px;font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">

																	<span><a href="#" style="color:#0079ff;"><img alt="logo" border="0" src="'.$logo.'" style="display: inline-block;" ></a></span>

																</td>
															</tr>
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF HEADER BLOCK--><!-- START OF FEATURED AREA BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F64B75" width="600" background="http://'.DOMINIO.URLVISTA.'images/featured-background.png">
									<tr>
										<td align="center" width="100%">
											<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr><!-- START OF HEADING-->
															<tr>
																<td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
																	<div style="text-align: center; font-size: 13px; font-weight: 700;">Hola, Soy: </div>
																	<span> <strong>'.$nombre.'</span>
																</td>
															</tr><!-- END OF HEADING--><!-- START OF TEXT-->

															<tr>
																<td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
																	<span>'.nl2br($preguntas).'</span>
																</td>
															</tr>

															<!-- END OF TEXT--><!-- START BUTTON-->
															<!-- END BUTTON-->
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr>
														</table><!-- END LEFT COLUMN-->
													</td>
													<td class="spacer" width="30"></td>
												</tr><!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF FEATURED AREA BLOCK--><!-- START OF 1/3 COLUMN BLOCK-->


		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">


											<div style="text-align: center; font-size: 18px;height: 50px;"><strong>Mis Datos de contacto son</strong>:</div>

											<div class="bs-example" style="padding: 0 20px;">
											    <table class="table table-hover">
											      <tbody>
											        <tr>

											          <td><strong>Email</strong>:</td>
											          <td>'.$email.'</td>

											        </tr>
											        <tr>

											          <td><strong>Teléfono</strong>:</td>
											          <td>'.$telefono.'</td>

											        </tr>

											      </tbody>
											    </table>
											  </div>
										</td>
									</tr>
								</table>


							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK-->
		<!-- START OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">
															<!-- START OF TEXT-->
															<tr>
																<td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:13px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
																	<span>Copyright &#169;Rhiss.net</span>
																</td>
															</tr><!-- END OF TEXT-->
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="spacer" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="20">
															<tr>
																<td height="10" width="100%"></td>
															</tr>
														</table><!-- END OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td width="540">
														<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td align="center" style="padding: 0px;" valign="top">
																	<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
																		<tr>
																			<td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle">
																				<img alt="img 600 290" border="0" class="img_scale" height="10" src="http://'.DOMINIO.URLVISTA.'images/footer-radius.png" style="display:block;" width="600">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>';
//echo $cuerpo;

		$mail->Body = utf8_decode($cuerpo);
		if($mail->Send())
			return true;
		else
			return false;
	}



	/******* registro usuario***********/
	static function enviar_registro($datos){


	$mail = new PHPMailer();
	  $mail->IsHTML(true);
      $mail->From ="info@".DOMINIO;
      $mail->FromName = utf8_decode($datos['nombre']);

	  $subject= "Nuevo registro desde ".$_SESSION['dominiovista'];

      $mail->Subject =$subject;
	  $logo='http://'.DOMINIO.URLVISTA.'images/logo.png';
	  if(defined('SKIN') and isset($_SESSION['id_empresa'])){
		  $emp = new Empresas();
		  $empresa= $emp->obtener($_SESSION['id_empresa']);
		$mail->AddAddress($empresa['email']);
		if($empresa['logo']!='')
		$logo='http://'.$_SESSION['dominiovista'].$empresas->dirfileout.'m'.$empresa['logo'];
	 }
	 else{
	 	$conf= new configmodel();
	$correo_e= $conf->obtener_valor('email');
	 $mail->AddAddress($correo_e);
	 }

	$mail->AddBCC('sitios@rhiss.net');


    $cuerpo = '<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
		<title>'.$mail->Subject.'</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
		<link href="style-form.css" rel=""stylesheet" type=""text/css">
		<style type="text/css">
		html {
		  font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}::-moz-selection{background:#0079ff;color:#fff}::selection{background:#0079ff;color:#fff}body {
		    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color: #333333;background-color: #ffffff; padding: 0;margin: 0;;
		  }.ExternalClass,.ReadMsgBody{width:100%;background-color:#f5f7fa}a{color:#0079ff;text-decoration:none;font-weight:300;font-style:normal}a:hover{color:#adb2bb;text-decoration:underline;font-weight:300;font-style:normal}div,p{margin:0!important}table{border-collapse:collapse}@media only screen and (max-width:640px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:440px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:400px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:400px!important;height:1px!important}}@media only screen and (max-width:479px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:280px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:240px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:240px!important;height:1px!important}}
			table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}table col[class*=col-]{position:static;float:none;display:table-column}table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.center-block{display:block;margin-left:auto;margin-right:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important;visibility:hidden!important}.affix{position:fixed;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}
			</style>

	</head>
	<body bgcolor="#F5F7FA">
		<!-- START OF PRE-HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF PRE-HEADER BLOCK--><!-- START OF HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">

										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
															<tr>
																<td align="left" class="center" style="padding: 0px;font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">

																	<span><a href="#" style="color:#0079ff;"><img alt="logo" border="0" src="'.$logo.'" style="display: inline-block;" ></a></span>

																</td>
															</tr>
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF HEADER BLOCK--><!-- START OF FEATURED AREA BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F64B75" width="600" background="http://'.DOMINIO.URLVISTA.'images/featured-background.png">
									<tr>
										<td align="center" width="100%">
											<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr><!-- START OF HEADING-->
															<tr>
																<td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
																	<div style="text-align: center; font-size: 13px; font-weight: 700;">- Nuevo Registro -</div>
																	<span> <strong>'.$datos['nombre'].'</strong></span>
																</td>
															</tr><!-- END OF HEADING--><!-- START OF TEXT-->
															<!-- END OF TEXT--><!-- START BUTTON-->
															<!-- END BUTTON-->
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr>
														</table><!-- END LEFT COLUMN-->
													</td>
													<td class="spacer" width="30"></td>
												</tr><!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF FEATURED AREA BLOCK--><!-- START OF 1/3 COLUMN BLOCK-->


		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">




											<div class="bs-example" style="padding: 0 20px;">
											    <table class="table table-hover">
											      <tbody>
											        <tr>

											          <td>Email:</td>
											          <td>'.$datos['email'].'</td>

											        </tr>
											        <tr>

											          <td>Teléfono:</td>
											          <td>'.$datos['telefono'].'</td>

											        </tr>
											        <tr>
											          <td>Dirección:</td>
											          <td>'.$datos['direccion'].'</td>
											        </tr>

											        <tr>
											          <td>Pais - Dpto - Ciudad:</td>
											          <td>'.usuario::nombre_localidad('pais',$datos['id_pais']).' / '.usuario::nombre_localidad('dpto',$datos['id_dpto']).' / '.usuario::nombre_localidad('ciudad',$datos['id_ciudad']).'</td>
											        </tr>

											      </tbody>
											    </table>
											  </div>
										</td>
									</tr>
								</table>

								<!-- /example -->
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK--><!-- START OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">
															<!-- START OF TEXT-->
															<tr>
																<td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:13px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
																	<span>Copyright &#169;Rhiss.net</span>
																</td>
															</tr><!-- END OF TEXT-->
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="spacer" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="20">
															<tr>
																<td height="10" width="100%"></td>
															</tr>
														</table><!-- END OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td width="540">
														<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td align="center" style="padding: 0px;" valign="top">
																	<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
																		<tr>
																			<td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle">
																				<img alt="img 600 290" border="0" class="img_scale" height="10" src="http://'.DOMINIO.URLVISTA.'images/footer-radius.png" style="display:block;" width="600">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>';
    $cuerpo .= '<br> <br>';

    $mail->Body = utf8_decode($cuerpo);
        if($mail->Send())
      return true;
    else
      return false;
  }

/********* confirmacion registro usuario **************/
  static function enviar_confirmacion($datos){
	  $nombre= $datos['nombre'];
	  $email= $datos['email'];


	  $mail = new PHPMailer();
	  $mail->IsHTML(true);
      $mail->From ="info@".DOMINIO;
      $mail->FromName = 'Admin '.$_SESSION['dominiovista'];

	  $subject= "Gracias por registrarse en ".$_SESSION['dominiovista'];

	  $logo='http://'.DOMINIO.URLVISTA.'images/logo.png';
	  if(defined('SKIN') and isset($_SESSION['id_empresa'])){
		  $emp = new Empresas();
		  $empresa= $emp->obtener($_SESSION['id_empresa']);
		if($empresa['logo']!='')
		$logo='http://'.$_SESSION['dominiovista'].$emp->dirfileout.'m'.$empresa['logo'];
	 }


      $mail->Subject =$subject;

	$mail->AddAddress($email);
	  $mail->AddBCC('diana@rhiss.net');
	  $cuerpo ='<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
		<title>'.$mail->Subject.'</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
		<link href="style-form.css" rel="stylesheet" type="text/css">
		<style type="text/css">
		html {
		  font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}::-moz-selection{background:#0079ff;color:#fff}::selection{background:#0079ff;color:#fff}body {
		    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color: #333333;background-color: #ffffff; padding: 0;margin: 0;;
		  }.ExternalClass,.ReadMsgBody{width:100%;background-color:#f5f7fa}a{color:#0079ff;text-decoration:none;font-weight:300;font-style:normal}a:hover{color:#adb2bb;text-decoration:underline;font-weight:300;font-style:normal}div,p{margin:0!important}table{border-collapse:collapse}@media only screen and (max-width:640px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:440px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:400px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:400px!important;height:1px!important}}@media only screen and (max-width:479px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:280px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:240px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:240px!important;height:1px!important}}
			table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}table col[class*=col-]{position:static;float:none;display:table-column}table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.center-block{display:block;margin-left:auto;margin-right:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important;visibility:hidden!important}.affix{position:fixed;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}
			</style>

	</head>
	<body bgcolor="#F5F7FA">
		<!-- START OF PRE-HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF PRE-HEADER BLOCK--><!-- START OF HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">

										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
															<tr>
																<td align="left" class="center" style="padding: 0px;font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">
																	<span><a href="#" style="color:#0079ff;"><img alt="logo" border="0" src="'.$logo.'" style="display: inline-block;" ></a></span>

																</td>
															</tr>
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF HEADER BLOCK--><!-- START OF FEATURED AREA BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F64B75" width="600" background="http://'.DOMINIO.URLVISTA.'images/featured-background.png">
									<tr>
										<td align="center" width="100%">
											<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr><!-- START OF HEADING-->
															<tr>
																<td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
																Hola <br><span><strong>'.$nombre.'</strong></span>
																</td>
															</tr><!-- END OF HEADING--><!-- START OF TEXT-->
															<tr>
																<td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
																	<span>Gracias por registrarse. Sus datos han sido enviados ya puede usar su cuenta de usuario para actualizar sus datos de contacto y revisar los registros de sus pedidos.</span>
																</td>
															</tr><!-- END OF TEXT--><!-- START BUTTON-->

															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr>
														</table><!-- END LEFT COLUMN-->
													</td>
													<td class="spacer" width="30"></td>
												</tr><!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF FEATURED AREA BLOCK--><!-- START OF 1/3 COLUMN BLOCK-->


		<!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK--><!-- START OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">
															<!-- START OF TEXT-->
															<tr>
																<td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:13px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
																	<span>Copyright &#169;Rhiss.net</span>
																</td>
															</tr><!-- END OF TEXT-->
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="spacer" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="20">
															<tr>
																<td height="10" width="100%"></td>
															</tr>
														</table><!-- END OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td width="540">
														<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td align="center" style="padding: 0px;" valign="top">
																	<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
																		<tr>
																			<td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle">
																				<img alt="img 600 290" border="0" class="img_scale" height="10" src="http://'.DOMINIO.URLVISTA.'images/footer-radius.png" style="display:block;" width="600">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>';
//echo $cuerpo;

    	$mail->Body = utf8_decode($cuerpo);
      	if($mail->Send())
		return true;
		else
		return false;

  }


  /******** pedido ***************/
  static function enviar_compra($id_pedido)
	{
		$error='';
		$compra= 'Pedido';
		$pedidos= new Pedidos();
	 	$ped= $pedidos->obtener($id_pedido);

	  	$empresa= new Empresas();
	    $emp= $empresa->obtener($ped['id_empresa']);
	    $medodo= $ped['metodo_pago'];

	    $logo='http://'.DOMINIO.URLVISTA.'images/logo.png';
	 	 if(defined('SKIN') and isset($_SESSION['id_empresa'])){
			if($emp['logo']!='')
			$logo='http://'.$_SESSION['dominiovista'].$empresa->dirfileout.'m'.$emp['logo'];
		 }



		  $mail = new PHPMailer();
		  $mail->IsHTML(true);

		  $mail->From = "info@".DOMINIO;
		  $mail->FromName =  $_SESSION['dominiovista'];

		  $mail->Subject = "Compra de productos en ".$_SESSION['dominiovista'];


		  $mail->AddAddress($emp['email']);

		  $mail->AddBCC("sitios@rhiss.net");
		  $mail->AddBCC('diana@rhiss.net');

		  $texto='';

	  if($medodo=='Otro'){
	  $texto.='Esta compra esta en estado "pago pendiente", revise la información correspondiente a "Otros medio de pago" para hacer la confirmación del pago correspondiente .';
	  }

	  $cdescuento='';
		  if($ped['codigo_descuento']!=''){
		  	$cdescuento=' <table align="center" border="0" cellpadding="0" cellspacing="0" width="540">
						  	<tr>
						  		<td align="center" style="margin: 0; font-size:14px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 0;">
						  			<span><img alt="divider image" border="0" class="divider" height="1" src="http://'.DOMINIO.URLVISTA.'images/divider-image.png" style="display: inline-block;" width="540"></span>
						  		</td>
						  	</tr>
						  </table>
						  <div style="padding: 20px 40px; text-align: center;"><strong>Código de descuento</strong>: <strong style="color: #E62C5A; font-size: 16px;">'.$ped['codigo_descuento'].'</strong>. <br/>Recuerde que solo debe dar el descuento de la oferta a la persona que tenga el codigo de descuento generado</div>';
		  }

               $cuerpo = '<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
		<title>'.$mail->Subject.'</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
		<style type="text/css">
html {
  font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}::-moz-selection{background:#0079ff;color:#fff}::selection{background:#0079ff;color:#fff}body {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color: #333333;background-color: #ffffff; padding: 0;margin: 0;;
  }.ExternalClass,.ReadMsgBody{width:100%;background-color:#f5f7fa}a{color:#0079ff;text-decoration:none;font-weight:300;font-style:normal}a:hover{color:#adb2bb;text-decoration:underline;font-weight:300;font-style:normal}div,p{margin:0!important}table{border-collapse:collapse}@media only screen and (max-width:640px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:440px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:400px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:400px!important;height:1px!important}}@media only screen and (max-width:479px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:280px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:240px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:240px!important;height:1px!important}}
	table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}table col[class*=col-]{position:static;float:none;display:table-column}table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.center-block{display:block;margin-left:auto;margin-right:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important;visibility:hidden!important}.affix{position:fixed;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0);}
	</style>

	</head>
	<body bgcolor="#F5F7FA">
		<!-- START OF PRE-HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF PRE-HEADER BLOCK--><!-- START OF HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%" >
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
															<tr>
																<td align="left" class="center" style="padding: 0px;font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">
																	<span><a href="#" style="color:#0079ff;"><img alt="logo" border="0" src="'.$logo.'" style="display: inline-block;" ></a></span>

																</td>
															</tr>
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF HEADER BLOCK--><!-- START OF FEATURED AREA BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F64B75" width="600" background="http://'.DOMINIO.URLVISTA.'images/featured-background.png">
									<tr>
										<td align="center" width="100%">
											<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr><!-- START OF HEADING-->
															<!-- END OF HEADING--><!-- START OF TEXT-->
															<tr>
																<td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
																	<span><strong>'.$ped['nombre_pedido'].' ha hecho una compra.</strong><br/>'.$texto.'</span>
																</td>
															</tr><!-- END OF TEXT--><!-- START BUTTON-->

															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr>
														</table><!-- END LEFT COLUMN-->
													</td>
													<td class="spacer" width="30"></td>
												</tr><!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF FEATURED AREA BLOCK--><!-- START OF 1/3 COLUMN BLOCK-->

		<!-- END OF 1/3 COLUMN BLOCK--><!-- START OF DIVIDER IMAGE BLOCK-->
		<!-- END OF DIVIDER IMAGE BLOCK--><!-- START OF 1/2 COLUMN RIGHT IMAGE BLOCK-->
		<!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK--><!-- START OF DIVIDER IMAGE BLOCK-->
		<!-- END OF DIVIDER IMAGE BLOCK--><!-- START OF 1/2 COLUMN RIGHT IMAGE BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<div class="bs-example" style="padding: 0 20px;">
											    <table class="table table-hover" style="color: #333;width:100%">
											      <thead>
											        <tr>
											          <th>#</th>
											          <th>Descripcion del producto</th>
											          <th style="text-align: center;">Cant.</th>
											          <th style="text-align: right;">Total</th>
											        </tr>
											      </thead> <tbody>';

		 $productos = pedido::mispedidos($id_pedido);
					   $total = 0;
					   $total_dolar=0;
					   $preciot = 0;
					   $moneda= 'COP';
					   foreach($productos as $pro){
						$cantidad = (int)$pro['cantidad'];
						$cantidad = ((is_integer($cantidad))? $cantidad : 1);
						$preciot = $pro['precio']*$cantidad;
                        $total += $preciot;

						$preciot_vista= $preciot;

						$cuerpo.=' <tr>
						          <td>1</td>
						          <td>'.$pro['nombre'].'</td>
						         <td style="text-align: center;">'.$pro['cantidad'].'</td>
						          <td style="text-align: right;">'.vn($preciot_vista).' '.$moneda.'</td>
						        </tr>';
                    }
					$total_vista= $total;

											$cuerpo.='<tr>
											          <td colspan="3"><strong>- Pedido No.</strong> '.$ped['orden'].' </td>
											          <td style="text-align: right;"><strong style="color: #E62C5A; font-size: 16px;">'.vn($total_vista).' COP</strong></td>
											        </tr>
											      </tbody>
											    </table>

											  </div>

											 '.$cdescuento.'


										</td>
									</tr>
								</table>


								<!-- /example -->
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK--><!-- START OF FOOTER BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">
															<!-- START OF TEXT-->
															<tr>
																<td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:13px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
																	<span>Copyright &#169;'.DOMINIO.'</span>
																</td>
															</tr><!-- END OF TEXT-->
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->

													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td width="540">
														<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td align="center" style="padding: 0px;" valign="top">
																	<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
																		<tr>
																			<td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle">
																				<img alt="img 600 290" border="0" class="img_scale" height="10" src="http://'.DOMINIO.URLVISTA.'images/footer-radius.png" style="display:block;" width="600">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>';

	$mail->Body = utf8_decode($cuerpo);

      	$mail->Send();
	}

	static function enviar_correo_cotizacion($id_pedido){
	  $pedidos= new Pedidos();


	  $ped= $pedidos->obtener($id_pedido);

	  $mail = new PHPMailer();
	  $mail->IsHTML(true);

      $mail->From = "info@".DOMINIO;
      $mail->FromName =  $_SESSION['dominiovista'];
      $mail->Subject = "Compra de productos ".$_SESSION['dominiovista'];

	  $mail->AddAddress($ped['email_pedido']);

	  $empresa= new Empresas();
	  $emp= $empresa->obtener($ped['id_empresa']);

	  $logo='http://'.DOMINIO.URLVISTA.'images/logo.png';
	 	if(defined('SKIN') and isset($_SESSION['id_empresa'])){
			if($emp['logo']!='')
			$logo='http://'.$_SESSION['dominiovista'].$empresa->dirfileout.'m'.$emp['logo'];
		 }


	  $medodo= $ped['metodo_pago'];

	  $texto='Su pedido se ha registrado con exito';
	  $texto_desc='';
	  if($medodo=='Otro'){
	  $texto.=' , por favor siga los pasos indicados para concretar la compra.';
	  $texto_desc= '<p>'.fullUrl($emp['otro_descripcion'],DOMINIO).'</p>';
	  }

	  $cdescuento='';
		  if($ped['codigo_descuento']!=''){
		  	$cdescuento=' <table align="center" border="0" cellpadding="0" cellspacing="0" width="540">
						  	<tr>
						  		<td align="center" style="margin: 0; font-size:14px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 0;">
						  			<span><img alt="divider image" border="0" class="divider" height="1" src="http://'.DOMINIO.URLVISTA.'images/divider-image.png" style="display: inline-block;" width="540"></span>
						  		</td>
						  	</tr>
						  </table>
						  <div style="padding: 20px 40px; text-align: center;"><strong>Código de descuento</strong>: <strong style="color: #E62C5A; font-size: 16px;">'.$ped['codigo_descuento'].'</strong>. <br />No olvide presentarlo para hacer válidas las promociones y descuentos incluidas en esta compra.</div>';
		  }

               $cuerpo = '<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
		<title>'.$mail->Subject.'</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
		<style type="text/css">
html {
  font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}::-moz-selection{background:#0079ff;color:#fff}::selection{background:#0079ff;color:#fff}body {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color: #333333;background-color: #ffffff; padding: 0;margin: 0;;
  }.ExternalClass,.ReadMsgBody{width:100%;background-color:#f5f7fa}a{color:#0079ff;text-decoration:none;font-weight:300;font-style:normal}a:hover{color:#adb2bb;text-decoration:underline;font-weight:300;font-style:normal}div,p{margin:0!important}table{border-collapse:collapse}@media only screen and (max-width:640px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:440px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:400px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:400px!important;height:1px!important}}@media only screen and (max-width:479px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:280px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:240px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:240px!important;height:1px!important}}
	table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}table col[class*=col-]{position:static;float:none;display:table-column}table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.center-block{display:block;margin-left:auto;margin-right:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important;visibility:hidden!important}.affix{position:fixed;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0);}
	</style>

	</head>
	<body bgcolor="#F5F7FA">
		<!-- START OF PRE-HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF PRE-HEADER BLOCK--><!-- START OF HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%" >
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
															<tr>
																<td align="left" class="center" style="padding: 0px;font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">
																	<span><a href="#" style="color:#0079ff;"><img alt="logo" border="0" src="'.$logo.'" style="display: inline-block;" ></a></span>

																</td>
															</tr>
														</table><!-- END OF LEFT COLUMN--><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF HEADER BLOCK--><!-- START OF FEATURED AREA BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F64B75" width="600" background="http://'.DOMINIO.URLVISTA.'images/featured-background.png">
									<tr>
										<td align="center" width="100%">
											<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr><!-- START OF HEADING-->
															<tr>
																<td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;"> Hola,<br><span> <strong>Sr(a) '.$ped['nombre_pedido'].',</strong></span>
																</td>
															</tr><!-- END OF HEADING--><!-- START OF TEXT-->
															<tr>
																<td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
																	<span>'.$texto.'</span>
																</td>
															</tr><!-- END OF TEXT--><!-- START BUTTON-->

															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr>
														</table><!-- END LEFT COLUMN-->
													</td>
													<td class="spacer" width="30"></td>
												</tr><!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF FEATURED AREA BLOCK--><!-- START OF 1/3 COLUMN BLOCK-->

		<!-- END OF 1/3 COLUMN BLOCK--><!-- START OF DIVIDER IMAGE BLOCK-->
		<!-- END OF DIVIDER IMAGE BLOCK--><!-- START OF 1/2 COLUMN RIGHT IMAGE BLOCK-->
		<!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK--><!-- START OF DIVIDER IMAGE BLOCK-->
		<!-- END OF DIVIDER IMAGE BLOCK--><!-- START OF 1/2 COLUMN RIGHT IMAGE BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<div class="bs-example" style="padding: 0 20px;">
											    <table class="table table-hover" style="color: #333;width:100%">
											      <thead>
											        <tr>
											          <th>#</th>
											          <th>Descripcion del producto</th>
											          <th style="text-align: center;">Cant.</th>
											          <th style="text-align: right;">Total</th>
											        </tr>
											      </thead> <tbody>';

		 $productos = pedido::mispedidos($id_pedido);
					   $total = 0;
					   $total_dolar=0;
					   $preciot = 0;
					   $moneda= 'COP';
					   foreach($productos as $pro){
						$cantidad = (int)$pro['cantidad'];
						$cantidad = ((is_integer($cantidad))? $cantidad : 1);
						$preciot = $pro['precio']*$cantidad;
                        $total += $preciot;

						$preciot_vista= $preciot;

						$cuerpo.=' <tr>
						          <td>1</td>
						          <td>'.$pro['nombre'].'</td>
						         <td style="text-align: center;">'.$pro['cantidad'].'</td>
						          <td style="text-align: right;">'.vn($preciot_vista).' '.$moneda.'</td>
						        </tr>';
                    }
					$total_vista= $total;

											$cuerpo.='<tr>
											          <td colspan="3"><strong>- Pedido No.</strong> '.$ped['orden'].' </td>
											          <td style="text-align: right;"><strong style="color: #E62C5A; font-size: 16px;">'.vn($total_vista).' COP</strong></td>
											        </tr>
											      </tbody>
											    </table>

											  </div>

											 '.$cdescuento.'

											  <table align="center" border="0" cellpadding="0" cellspacing="0" width="540">
											  	<tr>
											  		<td align="center" style="margin: 0; font-size:14px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 0;">
											  			<span><img alt="divider image" border="0" class="divider" height="1" src="http://'.DOMINIO.URLVISTA.'images/divider-image.png" style="display: inline-block;" width="540"></span>
											  		</td>
											  	</tr>
											  </table>
											  <div style="padding: 20px 40px;">'.$texto_desc.' </div>

										</td>
									</tr>
								</table>


								<!-- /example -->
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK--><!-- START OF FOOTER BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">
															<!-- START OF TEXT-->
															<tr>
																<td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:13px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
																	<span>Copyright &#169;'.DOMINIO.'</span>
																</td>
															</tr><!-- END OF TEXT-->
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->

													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td width="540">
														<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td align="center" style="padding: 0px;" valign="top">
																	<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
																		<tr>
																			<td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle">
																				<img alt="img 600 290" border="0" class="img_scale" height="10" src="http://'.DOMINIO.URLVISTA.'images/footer-radius.png" style="display:block;" width="600">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>';
      // echo $cuerpo;
    	$mail->Body = utf8_decode($cuerpo);

      	if($mail->Send())
			return true;
		else
			return false;

	}


/****** contraseña*********/

  static function enviar_peticion_pass($dat){
      $mail = new PHPMailer();
      $mail->IsHTML(true);
      $mail->From = 'soporte@'.DOMINIO;
      $mail->FromName =  'Soporte '.$_SESSION['dominiovista'];
      $mail->Subject = utf8_decode("Asistencia de contraseñas ".$_SESSION['dominiovista']);
      $mail->AddAddress($dat['email']);
      $mail->AddBCC("sitios@rhiss.net");

      $logo='http://'.DOMINIO.URLVISTA.'images/logo.png';
	 	if(defined('SKIN') and isset($_SESSION['id_empresa'])){
	 		$empresas= new Empresas();
	 		$empresa= $empresas->obtener($_SESSION['id_empresa']);
			if($empresa['logo']!='')
			$logo='http://'.$_SESSION['dominiovista'].$empresas->dirfileout.'m'.$empresa['logo'];
		 }

      //$_SESSION['dominiovista'];
      $cuerpo = '<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
		<title>'.$mail->Subject.'</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
		<link href="style-form.css" rel="stylesheet" type="text/css">
		<style type="text/css">
		html {
		  font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}::-moz-selection{background:#0079ff;color:#fff}::selection{background:#0079ff;color:#fff}body {
		    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color: #333333;background-color: #ffffff; padding: 0;margin: 0;;
		  }.ExternalClass,.ReadMsgBody{width:100%;background-color:#f5f7fa}a{color:#0079ff;text-decoration:none;font-weight:300;font-style:normal}a:hover{color:#adb2bb;text-decoration:underline;font-weight:300;font-style:normal}div,p{margin:0!important}table{border-collapse:collapse}@media only screen and (max-width:640px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:440px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:400px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:400px!important;height:1px!important}}@media only screen and (max-width:479px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:280px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:240px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:240px!important;height:1px!important}}
			table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}table col[class*=col-]{position:static;float:none;display:table-column}table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.center-block{display:block;margin-left:auto;margin-right:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important;visibility:hidden!important}.affix{position:fixed;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}
			</style>

	</head>
	<body bgcolor="#F5F7FA">
		<!-- START OF PRE-HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF PRE-HEADER BLOCK--><!-- START OF HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">

										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
															<tr>
																<td align="left" class="center" style="padding: 0px;font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">
																	<span><a href="#" style="color:#0079ff;"><img alt="logo" border="0" src="'.$logo.'" style="display: inline-block;" ></a></span>

																</td>
															</tr>
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF HEADER BLOCK--><!-- START OF FEATURED AREA BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F64B75" width="600" background="http://'.DOMINIO.URLVISTA.'images/featured-background.png">
									<tr>
										<td align="center" width="100%">
											<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr><!-- START OF HEADING-->
															<tr>
																<td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
																Hola <br>
																</td>
															</tr><!-- END OF HEADING--><!-- START OF TEXT-->
															<tr>
																<td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
																	<span>Hemos recibido una solicitud de restablecimiento de contraseña para el usuario '.$dat['email'].'. Para iniciar el proceso, haz clic en el siguiente enlace:
http://oferto.co/login-reset?tk='.$dat['token'].'
<br /><br />
Si el enlace no funciona, copia y pega la URL en
una ventana nueva del navegador. La URL caducará en 24 horas por motivos de
seguridad.
<br /><br />
Si no has sido tú el que ha realizado la solicitud de restablecimiento de contraseña, haz caso omiso de este mensaje.<br />
Si sigues experimentando problemas para acceder a tu cuenta, responda este mensaje indicando el problema.<br /></span>
																</td>
															</tr><!-- END OF TEXT--><!-- START BUTTON-->

															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr>
														</table><!-- END LEFT COLUMN-->
													</td>
													<td class="spacer" width="30"></td>
												</tr><!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF FEATURED AREA BLOCK--><!-- START OF 1/3 COLUMN BLOCK-->


		<!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK--><!-- START OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">
															<!-- START OF TEXT-->
															<tr>
																<td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:13px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
																	<span>Copyright &#169;Rhiss.net</span>
																</td>
															</tr><!-- END OF TEXT-->
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="spacer" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="20">
															<tr>
																<td height="10" width="100%"></td>
															</tr>
														</table><!-- END OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td width="540">
														<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td align="center" style="padding: 0px;" valign="top">
																	<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
																		<tr>
																			<td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle">
																				<img alt="img 600 290" border="0" class="img_scale" height="10" src="http://'.DOMINIO.URLVISTA.'images/footer-radius.png" style="display:block;" width="600">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>';

        $mail->Body = utf8_decode($cuerpo);
        if($mail->Send())
            return true;
        else
            return FALSE;
    }

    static function enviar_nuevo_pass($dat){
    	//info['info'] = clioferto.'-'.tipo.'-'.empresa;
    	$dominio='oferto.co';
    	$tipo='';

    	if(nvl($dat['info'],0)){
    		$info= explode('-', $dat['info']);

    		if($info[1]==4)
    			$tipo='para tu <b>cuenta de EMPRESA</b>';


    		if($info[0]==0 and nvl($info[2])!=''){
    			$empresas= new Empresas();
    			$empresa= $empresas->obtener($info[2]);
    			$dominio=$empresas->getDominio($empresa['id_empresa']);
    		}
    	}



      $mail = new PHPMailer();
      $mail->IsHTML(true);
      $mail->From = 'soporte@oferto.co';
      $mail->FromName =  'Soporte '.$dominio;
      $mail->Subject = utf8_decode("Asistencia de contraseñas ".$dominio);
      $mail->AddAddress($dat['email']);
      $mail->AddBCC("sitios@rhiss.net");

      $logo='http://'.DOMINIO.URLVISTA.'images/logo.png';
	 	if(defined('SKIN') and isset($_SESSION['id_empresa'])){
	 		$empresas= new Empresas();
	 		$empresa= $empresas->obtener($_SESSION['id_empresa']);
			if($empresa['logo']!='')
			$logo='http://'.$_SESSION['dominiovista'].$empresas->dirfileout.'m'.$empresa['logo'];
		 }
      $cuerpo = '<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
		<title>'.$mail->Subject.'</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
		<link href="style-form.css" rel="stylesheet" type="text/css">
		<style type="text/css">
		html {
		  font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}::-moz-selection{background:#0079ff;color:#fff}::selection{background:#0079ff;color:#fff}body {
		    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color: #333333;background-color: #ffffff; padding: 0;margin: 0;;
		  }.ExternalClass,.ReadMsgBody{width:100%;background-color:#f5f7fa}a{color:#0079ff;text-decoration:none;font-weight:300;font-style:normal}a:hover{color:#adb2bb;text-decoration:underline;font-weight:300;font-style:normal}div,p{margin:0!important}table{border-collapse:collapse}@media only screen and (max-width:640px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:440px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:400px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:400px!important;height:1px!important}}@media only screen and (max-width:479px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:280px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:240px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:240px!important;height:1px!important}}
			table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}table col[class*=col-]{position:static;float:none;display:table-column}table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.center-block{display:block;margin-left:auto;margin-right:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important;visibility:hidden!important}.affix{position:fixed;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}
			</style>

	</head>
	<body bgcolor="#F5F7FA">
		<!-- START OF PRE-HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF PRE-HEADER BLOCK--><!-- START OF HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">

										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
															<tr>
																<td align="left" class="center" style="padding: 0px;font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">
																	<span><a href="#" style="color:#0079ff;"><img alt="logo" border="0" src="'.$logo.'" style="display: inline-block;" ></a></span>

																</td>
															</tr>
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF HEADER BLOCK--><!-- START OF FEATURED AREA BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F64B75" width="600" background="http://'.DOMINIO.URLVISTA.'images/featured-background.png">
									<tr>
										<td align="center" width="100%">
											<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr><!-- START OF HEADING-->
															<tr>
																<td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
																Hola <br><span>Se ha restablecido la contraseña de '.$dat['email'].' '.$tipo.'</span>
																</td>
															</tr><!-- END OF HEADING--><!-- START OF TEXT-->
															<tr>
																<td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
																	<span><br /><br />
Contraseña: '.$dat['pass'].'
<br /><br />
Si sigues experimentando problemas para acceder a tu cuenta, responda este mensaje indicando el problema.</span>
																</td>
															</tr><!-- END OF TEXT--><!-- START BUTTON-->

															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr>
														</table><!-- END LEFT COLUMN-->
													</td>
													<td class="spacer" width="30"></td>
												</tr><!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF FEATURED AREA BLOCK--><!-- START OF 1/3 COLUMN BLOCK-->


		<!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK--><!-- START OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">
															<!-- START OF TEXT-->
															<tr>
																<td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:13px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
																	<span>Copyright &#169;Rhiss.net</span>
																</td>
															</tr><!-- END OF TEXT-->
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="spacer" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="20">
															<tr>
																<td height="10" width="100%"></td>
															</tr>
														</table><!-- END OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td width="540">
														<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td align="center" style="padding: 0px;" valign="top">
																	<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
																		<tr>
																			<td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle">
																				<img alt="img 600 290" border="0" class="img_scale" height="10" src="http://'.DOMINIO.URLVISTA.'images/footer-radius.png" style="display:block;" width="600">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>';

        $mail->Body = utf8_decode($cuerpo);
        if($mail->Send())
            return true;
        else
            return FALSE;
    }



    static function enviarOfertaSeguidores($id_oferta){
    	$productos= new Productos();
    	$empresas= new Empresas();
    	$galerias= new Galerias();
    	$oferta= $productos->obtener($id_oferta);
    	$empresa= $empresas->obtener($oferta['id_empresa']);


    	$siguiendo=$empresas->listarSeguidores($oferta['id_empresa']);
    	$nombre= ($oferta['oferta_descripcion']!='') ? $oferta['oferta_descripcion']:$oferta['nombre'];
    	$nempresa= $empresa['nombre'];

    	$imagen= ($oferta['oferta_imagen']!='') ? 'http://oferto.co/'.$productos->dirfileout.'m'.$oferta['oferta_imagen']:(($oferta['archivo']!='') ? 'http://www.oferto.co/'.$galerias->dirfileout.'m'.$oferta['archivo']:'http://www.oferto.co/'.URLFILES.'producto.png');
    	$enlace='http://www.oferto.co/main-producto-id-'.$oferta['id_producto'].'-t-'.chstr($nombre);
    	if($oferta['oferta_precio']){
    		$precio_old=($oferta['precio']) ? ' <strike>'.vn($oferta['precio']).'</strike>':'';
    		$precio=($oferta['oferta_precio']) ? 'Precio de oferta: '.vn($oferta['oferta_precio']):'';
    	}
    	else{
    		$precio_old='';
    		$precio=($oferta['precio']) ? 'Precio: '.vn($oferta['precio']):'';
    	}


    	$porcentaje=($oferta['precio'] and $oferta['oferta_precio']) ? '<br/><span style="font-size:26px">'.calc_porcentaje($oferta['precio'],$oferta['oferta_precio']).'% de descuento!</span>':'';
    	$faltan= resta_fechas($oferta['oferta_vencimiento'],date("Y-m-d"));
    	if($faltan)
    		$faltan='Esta promoción vence en '.$faltan.' dia(s)';

    	$mail = new PHPMailer();
    	$mail->IsHTML(true);
    	$mail->From ="info@".DOMINIO;
    	$mail->FromName = 'Oferto.co';
    	$subject= "Nueva oferta de ".utf8_decode($nempresa).' en OFERTO.CO';
    	$mail->Subject =$subject;

    	$logo='http://'.DOMINIO.URLVISTA.'images/logo.png';
      $cuerpo = '<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
		<title>'.$mail->Subject.'</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
		<link href="style-form.css" rel="stylesheet" type="text/css">
		<style type="text/css">
		html {
		  font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}::-moz-selection{background:#0079ff;color:#fff}::selection{background:#0079ff;color:#fff}body {
		    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color: #333333;background-color: #ffffff; padding: 0;margin: 0;;
		  }.ExternalClass,.ReadMsgBody{width:100%;background-color:#f5f7fa}a{color:#0079ff;text-decoration:none;font-weight:300;font-style:normal}a:hover{color:#adb2bb;text-decoration:underline;font-weight:300;font-style:normal}div,p{margin:0!important}table{border-collapse:collapse}@media only screen and (max-width:640px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:440px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:400px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:400px!important;height:1px!important}}@media only screen and (max-width:479px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:280px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:240px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:240px!important;height:1px!important}}
			table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}table col[class*=col-]{position:static;float:none;display:table-column}table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.center-block{display:block;margin-left:auto;margin-right:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important;visibility:hidden!important}.affix{position:fixed;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}
			</style>

	</head>
	<body bgcolor="#F5F7FA">
		<!-- START OF PRE-HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF PRE-HEADER BLOCK--><!-- START OF HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">

										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
															<tr>
																<td align="left" class="center" style="padding: 0px;font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">
																	<span><a href="#" style="color:#0079ff;"><img alt="logo" border="0" src="'.$logo.'" style="display: inline-block;" ></a></span>

																</td>
															</tr>
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF HEADER BLOCK--><!-- START OF FEATURED AREA BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F64B75" width="600" background="http://'.DOMINIO.URLVISTA.'images/featured-background.png">
									<tr>
										<td align="center" width="100%">
											<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr><!-- START OF HEADING-->
															<tr>
																<td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
																Hola <br><span> <strong>'.strtoupper($nempresa).'</strong>,<br/> una empresa que sigues en <a href="http://oferto.co">OFERTO.CO</a> ha publicado una nueva oferta!</span>
																</td>
															</tr><!-- END OF HEADING--><!-- START OF TEXT-->
															<tr>
																<td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
																	<span><a href="'.$enlace.'"><img src="'.$imagen.'" /></a><br>
    	<a href="'.$enlace.'"><span style="font-size:32px"; font-weight:bold>'.$nombre.'</span></a><br/>
    	<span>'.$nempresa.'</span>
    	<p>'.$precio.$precio_old.$porcentaje.'<br/>'.$faltan.'</p></span>
																</td>
															</tr><!-- END OF TEXT--><!-- START BUTTON-->

															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr>
														</table><!-- END LEFT COLUMN-->
													</td>
													<td class="spacer" width="30"></td>
												</tr><!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF FEATURED AREA BLOCK--><!-- START OF 1/3 COLUMN BLOCK-->


		<!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK--><!-- START OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">
															<!-- START OF TEXT-->
															<tr>
																<td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:13px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
																	<span>Copyright &#169;Rhiss.net</span>
																</td>
															</tr><!-- END OF TEXT-->
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="spacer" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="20">
															<tr>
																<td height="10" width="100%"></td>
															</tr>
														</table><!-- END OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td width="540">
														<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td align="center" style="padding: 0px;" valign="top">
																	<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
																		<tr>
																			<td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle">
																				<img alt="img 600 290" border="0" class="img_scale" height="10" src="http://'.DOMINIO.URLVISTA.'images/footer-radius.png" style="display:block;" width="600">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>';



    	$mail->Body = utf8_decode($cuerpo);
    	//$mail->AddBCC('sitios@rhiss.net');
    	$error=0;
    	foreach ($siguiendo as $usus) {
			$mail->AddAddress($usus['email']);
	    	if(!$mail->Send())
				$error=1;
	    	$mail->ClearAddresses();
    	}

    	$mail->AddBCC('sitios@rhiss.net');
	    $mail->Send();

	    if($error)
	    	return false;
	    else
	    	return true;
    }

	static function enviar_nuevo_dominio($id_empresa,$nombre){
	  $empresas= new Empresas();
	  $dominio=$empresas->getDominio($id_empresa);
	  $mail = new PHPMailer();
	  $mail->IsHTML(true);
      $mail->From ="info@".DOMINIO;
      $mail->FromName = 'Admin OFERTO.CO';

	  $subject= utf8_decode("La empresa ".$nombre." ha actualizado en nombre de dominio");

      $mail->Subject =$subject;

      $conf= new configmodel();
	  $correo_e= $conf->obtener_valor('email');
	  $mail->AddAddress($correo_e);
	  $mail->AddBCC('sitios@rhiss.net');

$logo='http://'.DOMINIO.URLVISTA.'images/logo.png';
      $cuerpo = '<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
		<title>'.$mail->Subject.'</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
		<link href="style-form.css" rel="stylesheet" type="text/css">
		<style type="text/css">
		html {
		  font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}::-moz-selection{background:#0079ff;color:#fff}::selection{background:#0079ff;color:#fff}body {
		    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color: #333333;background-color: #ffffff; padding: 0;margin: 0;;
		  }.ExternalClass,.ReadMsgBody{width:100%;background-color:#f5f7fa}a{color:#0079ff;text-decoration:none;font-weight:300;font-style:normal}a:hover{color:#adb2bb;text-decoration:underline;font-weight:300;font-style:normal}div,p{margin:0!important}table{border-collapse:collapse}@media only screen and (max-width:640px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:440px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:400px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:400px!important;height:1px!important}}@media only screen and (max-width:479px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:280px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:240px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:240px!important;height:1px!important}}
			table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}table col[class*=col-]{position:static;float:none;display:table-column}table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.center-block{display:block;margin-left:auto;margin-right:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important;visibility:hidden!important}.affix{position:fixed;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}
			</style>

	</head>
	<body bgcolor="#F5F7FA">
		<!-- START OF PRE-HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF PRE-HEADER BLOCK--><!-- START OF HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">

										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
															<tr>
																<td align="left" class="center" style="padding: 0px;font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">
																	<span><a href="#" style="color:#0079ff;"><img alt="logo" border="0" src="'.$logo.'" style="display: inline-block;" ></a></span>

																</td>
															</tr>
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF HEADER BLOCK--><!-- START OF FEATURED AREA BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F64B75" width="600" background="http://'.DOMINIO.URLVISTA.'images/featured-background.png">
									<tr>
										<td align="center" width="100%">
											<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr><!-- START OF HEADING-->
															<tr>
																<td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
																<span>La empresa '.strtoupper($nombre).' ha actualizado su nombre de dominio a:<br/> <strong>'.$dominio.'</strong></span>
																</td>
															</tr><!-- END OF HEADING--><!-- START OF TEXT-->
															<!-- END OF TEXT--><!-- START BUTTON-->

															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr>
														</table><!-- END LEFT COLUMN-->
													</td>
													<td class="spacer" width="30"></td>
												</tr><!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF FEATURED AREA BLOCK--><!-- START OF 1/3 COLUMN BLOCK-->


		<!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK--><!-- START OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">
															<!-- START OF TEXT-->
															<tr>
																<td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:13px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
																	<span>Copyright &#169;Rhiss.net</span>
																</td>
															</tr><!-- END OF TEXT-->
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="spacer" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="20">
															<tr>
																<td height="10" width="100%"></td>
															</tr>
														</table><!-- END OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td width="540">
														<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td align="center" style="padding: 0px;" valign="top">
																	<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
																		<tr>
																			<td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle">
																				<img alt="img 600 290" border="0" class="img_scale" height="10" src="http://'.DOMINIO.URLVISTA.'images/footer-radius.png" style="display:block;" width="600">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>';

    	$mail->Body = utf8_decode($cuerpo);
      	if($mail->Send())
			return true;
		else
			return false;
  }

  static function enviar_calificar_productos($id_usuario,$cadena){
    	$usuarios= new Usuarios();
    	$usuario= $usuarios->obtener($id_usuario);

    	$mail = new PHPMailer();
    	$mail->IsHTML(true);
    	$mail->From ="info@".DOMINIO;
    	$mail->FromName = 'Oferto.co';
    	$subject= "Califique los productos comprados en OFERTO.CO";
    	$mail->Subject =$subject;
    	if($usuario['id_empresa']==0){

    	$logo='http://'.DOMINIO.URLVISTA.'images/logo.png';
      $cuerpo = '<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
		<title>'.$mail->Subject.'</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
		<link href="style-form.css" rel="stylesheet" type="text/css">
		<style type="text/css">
		html {
		  font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}::-moz-selection{background:#0079ff;color:#fff}::selection{background:#0079ff;color:#fff}body {
		    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color: #333333;background-color: #ffffff; padding: 0;margin: 0;;
		  }.ExternalClass,.ReadMsgBody{width:100%;background-color:#f5f7fa}a{color:#0079ff;text-decoration:none;font-weight:300;font-style:normal}a:hover{color:#adb2bb;text-decoration:underline;font-weight:300;font-style:normal}div,p{margin:0!important}table{border-collapse:collapse}@media only screen and (max-width:640px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:440px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:400px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:400px!important;height:1px!important}}@media only screen and (max-width:479px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:280px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:240px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:240px!important;height:1px!important}}
			table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}table col[class*=col-]{position:static;float:none;display:table-column}table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.center-block{display:block;margin-left:auto;margin-right:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important;visibility:hidden!important}.affix{position:fixed;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}
			</style>

	</head>
	<body bgcolor="#F5F7FA">
		<!-- START OF PRE-HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF PRE-HEADER BLOCK--><!-- START OF HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">

										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
															<tr>
																<td align="left" class="center" style="padding: 0px;font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">
																	<span><a href="#" style="color:#0079ff;"><img alt="logo" border="0" src="'.$logo.'" style="display: inline-block;" ></a></span>

																</td>
															</tr>
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF HEADER BLOCK--><!-- START OF FEATURED AREA BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F64B75" width="600" background="http://'.DOMINIO.URLVISTA.'images/featured-background.png">
									<tr>
										<td align="center" width="100%">
											<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr><!-- START OF HEADING-->
															<tr>
																<td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
																<span>Ya puedes calificar los productos que compraste desde tu perfil en  <a href="http://oferto.co">OFERTO.CO</a>!</span>
																</td>
															</tr><!-- END OF HEADING--><!-- START OF TEXT-->
															<tr>
																<td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
																	<span>Ingresa con tu cuenta en  <a href="http://oferto.co/main-registro">OFERTO.CO</a>, ve a tu historial de compras y califica los productos que has comprado. <br/>Por favor califica los productos de tu última compra:<br>'.$cadena.'</span>
																</td>
															</tr><!-- END OF TEXT--><!-- START BUTTON-->

															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr>
														</table><!-- END LEFT COLUMN-->
													</td>
													<td class="spacer" width="30"></td>
												</tr><!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF FEATURED AREA BLOCK--><!-- START OF 1/3 COLUMN BLOCK-->


		<!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK--><!-- START OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">
															<!-- START OF TEXT-->
															<tr>
																<td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:13px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
																	<span>Copyright &#169;Rhiss.net</span>
																</td>
															</tr><!-- END OF TEXT-->
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="spacer" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="20">
															<tr>
																<td height="10" width="100%"></td>
															</tr>
														</table><!-- END OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td width="540">
														<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td align="center" style="padding: 0px;" valign="top">
																	<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
																		<tr>
																			<td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle">
																				<img alt="img 600 290" border="0" class="img_scale" height="10" src="http://'.DOMINIO.URLVISTA.'images/footer-radius.png" style="display:block;" width="600">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>';

    	$mail->Body = utf8_decode($cuerpo);
    	//$mail->AddBCC('sitios@rhiss.net');
    	$mail->AddAddress($usuario['email']);
	    if($mail->Send())
	    	return true;
	    else
	    	return false;
		}
    }

    static function enviar_email($datos){
		$mail = new PHPMailer();
		$titulo=$datos['titulo'];
		$enlace= 'http://'.DOMINIO.URLBASE.str_replace('__','-',$datos['enlace']);
		$imagen= 'http://'.DOMINIO.$datos['imagen'];
		$email= $datos['email'];

		$conf= new configmodel();
		$correo_e= $conf->obtener_valor('email');

		$mail->IsHTML(true);
		$mail->From = 'info@'.DOMINIO;
		$mail->FromName =  utf8_decode(DOMINIO);
		$mail->Subject = "Un amigo quiere que conozcas ".$titulo." ".DOMINIO;
		$mail->AddAddress($email);


		$logo='http://'.DOMINIO.URLVISTA.'images/logo.png';
      $cuerpo = '<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
		<title>'.$mail->Subject.'</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
		<link href="style-form.css" rel="stylesheet" type="text/css">
		<style type="text/css">
		html {
		  font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}::-moz-selection{background:#0079ff;color:#fff}::selection{background:#0079ff;color:#fff}body {
		    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color: #333333;background-color: #ffffff; padding: 0;margin: 0;;
		  }.ExternalClass,.ReadMsgBody{width:100%;background-color:#f5f7fa}a{color:#0079ff;text-decoration:none;font-weight:300;font-style:normal}a:hover{color:#adb2bb;text-decoration:underline;font-weight:300;font-style:normal}div,p{margin:0!important}table{border-collapse:collapse}@media only screen and (max-width:640px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:440px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:400px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:400px!important;height:1px!important}}@media only screen and (max-width:479px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:280px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:240px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:240px!important;height:1px!important}}
			table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}table col[class*=col-]{position:static;float:none;display:table-column}table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.center-block{display:block;margin-left:auto;margin-right:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important;visibility:hidden!important}.affix{position:fixed;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}
			</style>

	</head>
	<body bgcolor="#F5F7FA">
		<!-- START OF PRE-HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF PRE-HEADER BLOCK--><!-- START OF HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">

										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
															<tr>
																<td align="left" class="center" style="padding: 0px;font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">
																	<span><a href="#" style="color:#0079ff;"><img alt="logo" border="0" src="'.$logo.'" style="display: inline-block;" ></a></span>

																</td>
															</tr>
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF HEADER BLOCK--><!-- START OF FEATURED AREA BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F64B75" width="600" background="http://'.DOMINIO.URLVISTA.'images/featured-background.png">
									<tr>
										<td align="center" width="100%">
											<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr><!-- START OF HEADING-->
															<tr>
																<td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
																<span><strong>Un amigo quiere que conozcas  '.$titulo.'</strong></span>
																</td>
															</tr><!-- END OF HEADING--><!-- START OF TEXT-->
															<tr>
																<td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
																	<span><a href="'.$enlace.'">Mas inforamci&oacute;n -></a><br/><a href="'.$enlace.'"><img src="'.$imagen.'" alt="" style="padding:1px; border:solid 1px #CCC; width:90%" /></a></span>
																</td>
															</tr><!-- END OF TEXT--><!-- START BUTTON-->

															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr>
														</table><!-- END LEFT COLUMN-->
													</td>
													<td class="spacer" width="30"></td>
												</tr><!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF FEATURED AREA BLOCK--><!-- START OF 1/3 COLUMN BLOCK-->


		<!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK--><!-- START OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">
															<!-- START OF TEXT-->
															<tr>
																<td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:13px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
																	<span>Copyright &#169;Rhiss.net</span>
																</td>
															</tr><!-- END OF TEXT-->
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="spacer" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="20">
															<tr>
																<td height="10" width="100%"></td>
															</tr>
														</table><!-- END OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td width="540">
														<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td align="center" style="padding: 0px;" valign="top">
																	<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
																		<tr>
																			<td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle">
																				<img alt="img 600 290" border="0" class="img_scale" height="10" src="http://'.DOMINIO.URLVISTA.'images/footer-radius.png" style="display:block;" width="600">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>';
		$mail->Body = $cuerpo;

		if($mail->Send())
			return true;
		else
			return false;
	}

	 static function enviar_vencen_hoy($oferta=array(),$cliente='',$email='',$nempresa=''){
	 	$productos= new Productos();
	 	$galerias= new Galerias();
    	$nombre= ($oferta['oferta_descripcion']!='') ? $oferta['oferta_descripcion']:$oferta['nombre'];

    	$imagen= ($oferta['oferta_imagen']!='') ? 'http://oferto.co/'.$productos->dirfileout.'m'.$oferta['oferta_imagen']:(($oferta['archivo']!='') ? 'http://oferto.co/'.$galerias->dirfileout.'m'.$oferta['archivo']:'http://oferto.co/'.URLFILES.'producto.png');
    	$enlace='http://www.oferto.co/main-producto-id-'.$oferta['id_producto'].'-t-'.chstr($nombre);
    	if($oferta['oferta_precio']){
    		$precio_old=($oferta['precio']) ? ' <strike>'.vn($oferta['precio']).'</strike>':'';
    		$precio=($oferta['oferta_precio']) ? 'Precio de oferta: '.vn($oferta['oferta_precio']):'';
    	}
    	else{
    		$precio_old='';
    		$precio=($oferta['precio']) ? 'Precio: '.vn($oferta['precio']):'';
    	}


    	$porcentaje=($oferta['precio'] and $oferta['oferta_precio']) ? '<br/><span style="font-size:26px">'.calc_porcentaje($oferta['precio'],$oferta['oferta_precio']).'% de descuento!</span>':'';

    	$mail = new PHPMailer();
    	$mail->IsHTML(true);
    	$mail->From ="info@".DOMINIO;
    	$mail->FromName = 'Oferto.co';
    	$subject= "La oferta ".utf8_decode($nombre)." vence hoy!!";
    	$mail->Subject =$subject;

    	$logo='http://'.DOMINIO.URLVISTA.'images/logo.png';
      $cuerpo = '<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
		<title>'.$mail->Subject.'</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
		<link href="style-form.css" rel="stylesheet" type="text/css">
		<style type="text/css">
		html {
		  font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}::-moz-selection{background:#0079ff;color:#fff}::selection{background:#0079ff;color:#fff}body {
		    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color: #333333;background-color: #ffffff; padding: 0;margin: 0;;
		  }.ExternalClass,.ReadMsgBody{width:100%;background-color:#f5f7fa}a{color:#0079ff;text-decoration:none;font-weight:300;font-style:normal}a:hover{color:#adb2bb;text-decoration:underline;font-weight:300;font-style:normal}div,p{margin:0!important}table{border-collapse:collapse}@media only screen and (max-width:640px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:440px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:400px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:400px!important;height:1px!important}}@media only screen and (max-width:479px){table table,td[class=full_width]{width:100%!important}div[class=div_scale],table[class=table_scale],td[class=td_scale]{width:280px!important;margin:0 auto!important}img[class=img_scale]{width:100%!important;height:auto!important}table[class=spacer],td[class=spacer]{display:none!important}td[class=center]{text-align:center!important}table[class=full]{width:240px!important;margin-left:20px!important;margin-right:20px!important}img[class=divider]{width:240px!important;height:1px!important}}
			table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}table col[class*=col-]{position:static;float:none;display:table-column}table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.center-block{display:block;margin-left:auto;margin-right:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important;visibility:hidden!important}.affix{position:fixed;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}
			</style>

	</head>
	<body bgcolor="#F5F7FA">
		<!-- START OF PRE-HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF PRE-HEADER BLOCK--><!-- START OF HEADER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">

										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
															<tr>
																<td align="left" class="center" style="padding: 0px;font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">
																	<span><a href="#" style="color:#0079ff;"><img alt="logo" border="0" src="'.$logo.'" style="display: inline-block;" ></a></span>

																</td>
															</tr>
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
									<tr>
										<td height="30" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF HEADER BLOCK--><!-- START OF FEATURED AREA BLOCK-->

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F64B75" width="600" background="http://'.DOMINIO.URLVISTA.'images/featured-background.png">
									<tr>
										<td align="center" width="100%">
											<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr><!-- START OF HEADING-->
															<tr>
																<td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
																Hola '.$cliente.', <br><span>hoy es el último dia de oferta para<br><strong>'.$nombre.'</strong></span>
																</td>
															</tr><!-- END OF HEADING--><!-- START OF TEXT-->
															<tr>
																<td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
																	<span><a href="'.$enlace.'"><img src="'.$imagen.'" /></a><br>

															    	Esta oferta pertenece a  '.$nempresa.', empresa que sigues en <a href="http://oferto.co">OFERTO.CO</a>
															    	<p>'.$precio.$precio_old.$porcentaje.'</p></span>
																</td>
															</tr><!-- END OF TEXT--><!-- START BUTTON-->

															<tr>
																<td height="40">
																	&nbsp;
																</td>
															</tr>
														</table><!-- END LEFT COLUMN-->
													</td>
													<td class="spacer" width="30"></td>
												</tr><!--[if gte mso 9]> </v:textbox> </v:rect> <![endif]-->
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF FEATURED AREA BLOCK--><!-- START OF 1/3 COLUMN BLOCK-->


		<!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK--><!-- START OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td class="spacer" width="30"></td>
													<td width="540">
														<!-- START OF LEFT COLUMN-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">
															<!-- START OF TEXT-->
															<tr>
																<td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:13px ; color:#adb2bb; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
																	<span>Copyright &#169;Rhiss.net</span>
																</td>
															</tr><!-- END OF TEXT-->
														</table><!-- END OF LEFT COLUMN--><!-- START OF SPACER-->
														<table align="left" border="0" cellpadding="0" cellspacing="0" class="spacer" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="20">
															<tr>
																<td height="10" width="100%"></td>
															</tr>
														</table><!-- END OF SPACER-->
													</td>
													<td class="spacer" width="30"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><!-- END OF SUB-FOOTER BLOCK-->
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%">
								<table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td width="100%">
											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tr>
													<td width="540">
														<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
															<tr>
																<td align="center" style="padding: 0px;" valign="top">
																	<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
																		<tr>
																			<td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle">
																				<img alt="img 600 290" border="0" class="img_scale" height="10" src="http://'.DOMINIO.URLVISTA.'images/footer-radius.png" style="display:block;" width="600">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table><!-- START OF VERTICAL SPACER-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
									<tr>
										<td height="40" width="100%">
											&nbsp;
										</td>
									</tr>
								</table><!-- END OF VERTICAL SPACER-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>';

//echo $cuerpo;

    	$mail->Body = utf8_decode($cuerpo);
    	$mail->AddBCC('sitios@rhiss.net');
    	$mail->AddAddress($email);
    	//$mail->AddAddress('dianaleonoraz@gmail.com');
	    if($mail->Send())
	    	return true;
	    else
	    	return false;
    }
}
?>