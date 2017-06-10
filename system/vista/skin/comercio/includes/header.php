<div class="header-container">
    <div class="top-switch-bg">
        <div class="row clearfix">
            <div class="grid_6">
                
               
 </div>
            <div class="grid_6">
                <ul class="links">
                <? if(nvl($_SESSION['id_tipo_usuario'],0)>4 ){?>
	                    <li ><a href="main-cuenta" title="Account" >Cuenta</a></li>

			            <li class="separator">&nbsp;</li>
			            <li><a href="main-pedidos">Mis compras</a></li>
			            <li class="separator">&nbsp;</li>
			            <li><a href="login-logout">Salir</a></li>
                       
<? }else{?>
			           
                        <li><a href="main-registro">Ingresar / Registrarse</a></li>
                        <? }?>
    </ul>
            </div>
        </div>
    </div>
    <div class="header-wrapper  search-field">
        <header>
        <div class="row clearfix">
            <div class="grid_12 "> <? $logo=empresa::get_logo();
					if($logo!=''){?>
                 <h1 class="logo">
                    <strong><?=empresa::print_titulo()?></strong>
                    <a href="/" title="<?=empresa::print_titulo()?>" class="logo">
                   
                        <p><img src="<?=$logo?>"  class="retina" alt="<?=empresa::print_titulo()?>" width="200px" /></p>
                        
                    </a>
                </h1>
                <? }?>
                                        <!-- NAVIGATION -->
                    <!-- navigation BOF -->
<div class="nav-container">
    <div class="nav-top-title">
        <div class="icon">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <a href="#">Navegación</a>
    </div>
    
    <ul id="queldoreiNav">
	       <li class="level0 level-top">
         	  <a href="main-index"><span>Inicio</span></a>
            </li>
            <li class="level0 nav-1 level-top first parent">
                <a href="main-productos" class="level-top"><span><?=PRODUCTOS_TXT?></span></a>
                 <div class="sub-wrapper">
                    <ul class="level0">
                                <li>
                                    <ol>
                                    <?=categoria::menu(0);?>     
                                    </ol>
                                </li>
                    </ul>
            </li>

    <li class="level0 nav-2 level-top parent">
        <a href="main-contenido-t-1" class="level-top">
            <span>Quiénes Somos</span>
        </a> </li>
        
        <li class="level0 nav-2 level-top parent">
        <a href="main-contenido-t-2" class="level-top">
            <span>Cómo comprar</span>
        </a> </li>

  

    <li class="level0 nav-4 level-top last">
        <a href="main-contactenos" class="level-top">
            <span>Contáctenos</span>
        </a>
    </li>

</ul>
</div>

<!-- navigation EOF -->   
                
 <!-- NAVIGATION EOF -->
                    <div class="top-dropdowns">
                        <!-- cart BOF -->
                        <div class="cart-top-title">
                            <a href="producto-carrito" class="clearfix"><span class="icon"></span>Carrito</a></div>
                        <div class="cart-top-container">
                            <div class="cart-top">
                                <a class="summary" href="producto-carrito"><span>Carrito (0)</span></a>
                            </div>
                            <div class="details">
                                <div class="details-border"></div>
                        	    <!--div class="cart-promotion">Place your promotion here</div-->                        
                                <p class="a-center">No hay items</p>
                             </div>
                        </div>
<!-- cart EOF -->                                                            
                                <div class="search-top-container">
                            <form id="search_mini_form" action="main-productos" method="post">
                                <div class="form-search">
                                    <input id="search" name="buscar" type="text" autocomplete="off" value="" class="input-text"/>
                                    <button type="submit" title="Buscar"></button>
                                </div>
                                <div id="search_autocomplete" class="search-autocomplete"></div>
                                <script type="text/javascript">
                                    //<![CDATA[
                                    var searchForm = new Varien.searchForm('search_mini_form', 'search', 'Buscar');             
                                    //]]>
                                </script>
                            </form>

                        <ul id="sugerencias-busqueda"></ul>


                        </div>
                        <div class="clear"></div>
                    </div>
                   </div>
            </div>
	       </header>
    </div>
</div>