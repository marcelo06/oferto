<div id="navigation">
		<div class="container-fluid">
        <a href="#" class="mobile-sidebar-toggle"><i class="icon-th-list"></i></a>
			<a href="#" id="brand" style="background-image:none">OFERTO</a>
			<? if($_SESSION['id_tipo_usuario']!=6){?>
			<a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Esconder Menú"><i class="icon-reorder"></i></a>
			
			<div class="user">
				<ul class="icon-nav">
					<? if(nvl($_SESSION['id_tipo_usuario'])==4){
						$hpedidos= pedido::pendientes(8);
						if($hpedidos['cantidad']>0) { ?>
					<li class='dropdown'>
						<a href="#" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-shopping-cart"></i><span class="label label-lightred"><?=$hpedidos['cantidad']?></span></a>
						<ul class="dropdown-menu pull-right message-ul">
							<?=$hpedidos['lista']?>
						</ul>
					</li>
					<? }
					$hofertasp= producto::ofertas_comentarios_pendientes();
						if($hofertasp['cantidad']>0) { ?>
					<li class='dropdown'>
						<a href="#" onClick="actualizarOfertaComentario()" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-tags"></i><span class="label label-lightred" id="n-ofertas-com"><?=$hofertasp['cantidad']?></span></a>
						<ul class="dropdown-menu pull-right message-ul">
							<?=$hofertasp['lista']?>
						</ul>
					</li>
					<? } 
					 }?>
					<? if(nvl($_SESSION['id_tipo_usuario'])==2){
						$hofertas= producto::ofertas_pendientes(8);
						if($hofertas['cantidad']>0) { ?>
					<li class='dropdown'>
						<a href="#" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-tags"></i><span class="label label-lightred" id="nofertas-com"><?=$hofertas['cantidad']?></span></a>
						<ul class="dropdown-menu pull-right message-ul">
							<?=$hofertas['lista']?>
						</ul>
					</li>
					<? } }?>
					
					<li>
						<a href="login-inicio" class='lock-screen' rel='tooltip' title="Estadísticas" data-placement="bottom"><i class="icon-bar-chart"></i></a>
					</li>
					<li >
						<a href="<?=($_SESSION['id_tipo_usuario']==4) ? 'empresa-edit_empresa':'configsite-configurar_sitio'?>" class='lock-screen' rel='tooltip' title="Configuración" data-placement="bottom"><i class="icon-cog"></i></a>
					</li>
					<li >
						<a href="http://<?= (isset($_SESSION['dominio']))? $_SESSION['dominio']:DOMINIO.URLBASE ?>" target="_blank" class='lock-screen' rel='tooltip' title="Previsualizar" data-placement="bottom"><i class="icon-eye-open"></i></a>
					</li>
					<li >
						<a href="login-logout" class='lock-screen' rel='tooltip' title="Salir seguro" data-placement="bottom"><i class="icon-signout"></i></a>
					</li>
					
				</ul>
				<div class="dropdown">
					<a href="#" class='dropdown-toggle' data-toggle="dropdown"><?= $_SESSION['nombre'] ?> <img src="<?=URLVISTA?>admin/img/jondoe.png" alt=""></a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="usuario-config">Modificar perfil</a>
						</li>
						
						<li>
							<a href="login-logout">Cerrar Sesión</a>
						</li>
					</ul>
				</div>
			</div>
			<? }?>
		</div>
	</div>