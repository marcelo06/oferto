<!--
2	Administrador
4	Empresa
5	Cliente
6 Estadisticas
-->
	<div id="left">
<? if($_SESSION['id_tipo_usuario']==6){?>
	 <div class="subnav">
				<div class="subnav-title">
				<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Módulos</span></a>
				</div>
				<ul class="subnav-menu">
					<li><a href="login-inicio">Reportes de Oferto.co</a></li>
					 <li><a href="usuario-config">Modificar Perfil</a></li>
					<li><a href="login-logout">Salir</a></li>
                
				</ul>
			</div>

    <?  }else if($_SESSION['id_tipo_usuario']==2){?>
   			 <div class="subnav">
				<div class="subnav-title">
				<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Módulos</span></a>
				</div>
				<ul class="subnav-menu">
					<li><a href="banner-editar-id-1">Banner Promocional</a></li>
					<li><a href="empresa-categorias">Categorías</a></li>
					 <li><a href="empresa-list_empresas">Empresas</a></li>
					<li><a href="producto-list_ofertas">Ofertas</a></li>
                    <li><a href="usuario-listar">Clientes</a></li>
                    <li><a href="notificacion-lista">Notificaciones</a></li>
                    <li><a href="login-inicio-estadisticas-1">Estadísticas Oferto.co</a></li>
					<li><a href="login-inicio">Reportes de Empresas</a></li>
					<li><a href="usuario-ayuda">Ayuda <i class="glyphicon-circle_info"></i></a></li>
				</ul>
			</div>
            
			<div class="subnav">
				<div class="subnav-title">
				<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Configuración</span></a>
				</div>
				<ul class="subnav-menu">
					<li><a href="configsite-configurar_sitio">Sitio Web Portal</a></li>
					<li><a href="usuario-config">Perfil Administrador</a></li>
				</ul>
			</div>
			
			<div class="subnav">
				<div class="subnav-title">
				<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Contenidos</span></a>
				</div>
				<ul class="subnav-menu">
					<li><a href="contenido-editar-id-1">Sobre Oferto.co</a></li>
					<li><a href="contenido-editar-id-2">Condiciones de uso</a></li>
					<li><a href="contenido-editar-id-3">Política de privacidad</a></li>
				</ul>
			</div>
    
	<? }elseif($_SESSION['id_tipo_usuario']==4){?>
			<div class="subnav">
				<div class="subnav-title">
				<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Módulos</span></a>
				</div>
				<ul class="subnav-menu">
					<li><a href="slide-editar">Slide Promocional</a></li>
					<li><a href="producto-list_productos">Productos</a></li>
                    <li><a href="producto-list_ofertas">Ofertas</a></li>
                    <li><a href="usuario-listar">Clientes</a></li>
					
                    <li><a href="pedido-list_pedidos">Pedidos</a></li>
                     <li><a href="mailing-lista">Mailing</a></li>
                    <li><a href="login-inicio">Estadísticas</a></li>
                    <li><a href="usuario-ayuda">Ayuda <i class="glyphicon-circle_info"></i></a></li>   
				</ul>
			</div>
            <div class="subnav">
				<div class="subnav-title">
				<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Contenidos</span></a>
				</div>
				<ul class="subnav-menu">
					 <li><a href="contenido-editar-t-1">Quiénes Somos</a></li>
                      <li><a href="contenido-editar-t-2">Cómo comprar</a></li>
                      <li><a href="contenido-editar-t-3">Términos y condiciones</a></li>
                      
				</ul>
			</div>
			<div class="subnav">
				<div class="subnav-title">
				<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Configuración</span></a>
				</div>
				<ul class="subnav-menu">
					<li><a href="empresa-edit_empresa">Sitio Web</a></li>
					<li><a href="usuario-config">Perfil Usuario</a></li>
                    <li><a href="almacen-lista">Almacenes (mapa)</a></li>
				</ul>
			</div>
			<div class="subnav">
				<div class="subnav-title">
				<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Aplicación Rutas</span></a>
				</div>
				<ul class="subnav-menu">
					<li><a href="http://www.rutasdelpaisajeculturalcafetero.com/loader.php?lServicio=InventarioTuristico&lTipo=inventario&lFuncion=linkOfertoApps&id=<?= $_SESSION['id_empresa'] ?>" target="_blank">Administrar</a></li>
				</ul>
			</div>
            <? }?>
		</div>