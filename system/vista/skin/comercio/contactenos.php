<? include("includes/tags.php") ?>
<script type="text/javascript">
mensaje='<?=nvl($mensaje)?>';
</script>
<script type="text/javascript" src="<?=URLVISTA?>skin/comercio/js/contacto.js"></script>

</head>
<body class="  checkout-cart-index">
<div class="wrapper">

    <div class="page">
        

<!-- HEADER BOF -->

<? include("includes/header.php")?>
<!-- HEADER EOF -->
	    <div class="main-container col2-right-layout">
            <div class="main row">
                <!-- breadcrumbs BOF -->
<!-- breadcrumbs EOF -->
                <div class="col-main">
         <div class="page-title">
    <h1>CONTÁCTENOS</h1>
</div>
<div id="msj" style="color:#F0C56B; font-size:18px; font-weight:bold"></div>

    <form class="formee" action="" id="formC" name="formC" method="post">

    <div class="fieldset">
        <h2 class="legend">Déjenos sus inquietudes o comentarios, pronto nos comunicaremos con usted.</h2>
        <ul class="form-list">
            <li>
                <label for="name" class="required"><em>*</em>Nombre completo</label>
                <div class="input-box">
                    <input  name="dat[nombre]" id="nombre" value="" class="input-text" required type="text" />
                </div>
            </li>
            <li>
                <label for="email" class="required"><em>*</em>Email</label>
                <div class="input-box">
                    <input name="dat[email]"  id="email" value="" required class="input-text" type="email" />
                </div>
            </li>
            <li>
                <label for="telephone">Teléfono</label>
                <div class="input-box">
                    <input  name="dat[telefono]" id="telefono"  value="" class="input-text" type="text" />
                </div>
            </li>
            <li class="wide">
                <label for="comment" class="required"><em>*</em>Comentarios</label>
                <div class="input-box">
                    <textarea name="dat[inquietudes]" id="inquietudes" required class="input-text" cols="5" rows="3"></textarea>
                </div>
            </li>
        </ul><div class="buttons-set">
        <p class="required">* Campos requeridos</p>
        <button type="submit" title="Enviar" class="button"><span><span>Enviar</span></span></button>
    </div>
    </div>
    
</form>

                </div>
                
           <div class="col-right sidebar">
              <div class="block block-left-nav">
                  <div class="block-title">
                   <strong><span>Información de Contacto</span></strong>
                </div>
           <div class="block-content"><? $infoc=empresa::get_contacto();?>
               <dl>
                 <?=($infoc['email']!='') ? '<dt><strong>Email</strong>: '.$infoc['email'].'</dt>':''?>
                 <? if($infoc['telefono']!='' or $infoc['telefono2']!='' or $infoc['telefono3']!=''){
                    echo '<dt><strong>Teléfono(s)</strong>: ';
                    if($infoc['telefono']!='')
                        echo $infoc['telefono'];
                    if($infoc['telefono2']!='')
                        echo ' - '.$infoc['telefono2'];
                    if($infoc['telefono3']!='')
                        echo  ' - '.$infoc['telefono3'];
                    echo '</dt>';
                } ?>

                 <?=($infoc['movil']!='') ? '<dt><strong>Móvil</strong>: '.$infoc['movil'].'</dt>':''?>
                 <?=($infoc['direccion']!='') ? '<dt><strong>Dirección</strong>: '.$infoc['direccion'].'</dt>':''?>
                 <?=($infoc['skype']!='') ? '<dt><strong>Skype</strong>: <a href="skype:'.$infoc['skype'].'?chat" style="color:#999">'.$infoc['skype'].'</a></dt>':''?>          
              </dl>
           </div>
           </div>
           
           
           
           
           
           
           
           
                           </div>     
	           
            </div>
		    <!-- footer BOF -->
<? include("includes/footer.php")?>
<!-- footer EOF -->        </div>
            </div>
</div>
</body>
</html>
