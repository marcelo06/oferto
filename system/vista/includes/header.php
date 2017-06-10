<div class="container-fluid">
<div class="areaHeader">
	<header id="Header" class="auto_margin">
		<div class="areaData">
			<div class="userArea">
			<? if(nvl($_SESSION['id_tipo_usuario'],0)==5 ){?>
				Hola, <?=$_SESSION['nombre']?> | <a href="main-productos-siguiendo-1">Siguiendo</a> | <a href="main-cuenta">Mi cuenta</a> | <a href="login-logout">Salir</a>
			<? } else{?>
				<a href="main-registro">INGRESO</a> | <a href="main-registro">REGISTRARSE</a> | <a href="mapa-ofertas">MAPA DE OFERTAS</a><!--a href="http://ofertoempresas.co/" target="_blank">VENDA CON NOSOTROS</a-->
			<? }?>
			</div>
			<div class="Redes">
			<? $facebook= configsite::get_tipo('facebook');
				$twitter= configsite::get_tipo('twitter');
				$youtube= configsite::get_tipo('youtube'); ?>

				  <?=($facebook!='') ? '<span class="red facebook"><a href="'.$facebook.'" title="facebook" target="_blank"></a></span>':''?>
				  <?=($twitter!='') ? '<span class="red twitter"><a href="'.$twitter.'" title="twitter" target="_blank"></a></span>':'' ?>
				  <?=($youtube!='') ? '<span class="red youtube"><a href="'.$youtube.'" title="youtube" target="_blank"></a></span>':'' ?>
			</div>
			<div class="height5"></div>
			<div class="areaSearch">
				<form action="main-productos" method="post">
				<input type="text" name="busqueda" id="ibusqueda" value="" class="inp-search" maxlength="50" autocomplete="off" />
				<input type="image" src="<?=URLVISTA?>images/bttSearch.png" name="" value="" class="bttn" />
				</form>
				<ul id="sugerencias-busqueda"></ul>
			</div>
		</div>
		<div class="logo"><a href="main-index"><img class="img-responsive center-block" src="<?=URLVISTA?>images/logo.png" alt="" width="290" /></a></div>
	</header>
</div>

<nav id="Menu">
  <ul id="nav" class="menu slide">
  <li class="current"><a href="main-index">INICIO</a></li>
  <li><a class="curl-top-right" href="main-productos">COMERCIO</a>
  	<!--div class="dropdown-col-4 gallery space_4col">
  		<div class="video-gallery-container">
  			<div class="col-4">
  				<ol>
			    <? /*= empresa::menu(0, 'c');*/ ?>
			  	</ol>
			</div>
		</div>
	</div-->
  </li>
  <li><a class="curl-top-right" href="main-productos-c-12-t-viajes_y_turismo">TURISMO</a>
  	<!--div class="dropdown-col-3 gallery space_3col">
  		<div class="video-gallery-container">
  			<div class="col-3">
  				<ol>
			    <? /*=empresa::menu(0, 't');*/ ?>
			  	</ol>
			</div>
		</div>
	</div-->
  </li>
  <li><a href="main-productos-c-53-t-cafes_especiales">CAFÉS ESPECIALES</a></li>
  <li><a href="main-productos-c-22-t-inmobiliarias">INMOBILIARIAS</a></li>
  </ul>
  <div class="areaSearch">
  </div>
</nav>