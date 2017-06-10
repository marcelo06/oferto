<?php 
if(nvl($descargar)==1){
   $sUrlDescargas = $dirfile;
    $vBarras = array("/", "\\");
    $sDocumento = $sUrlDescargas.str_replace($vBarras, "_", $archivo);
    if (file_exists($sDocumento))
    {
        header("Content-type: application/force-download");
        header("Content-Disposition: attachment; filename=".basename($archivo));
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($sDocumento));
        readfile($sDocumento);
    }
    else
    {
        echo "<br>Ha sido imposible descargar el archivo";
    } 
}
else{?><? include("includes/tags.php") ?>
</head>
<body data-mobile-sidebar="button">
    <? include("includes/header.php") ?>
    <div class="container-fluid" id="content">
        <? include("includes/menu.php") ?>
        <div id="main">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="pull-left">
                        <h1>Ayuda <i class="glyphicon-circle_info"></i></h1>
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
                       <div class="box">
                            <div class="box box-color box-bordered lightgrey">
                                <div class="box-title">
                                <h3>Manual de usuario</h3>
                             </div>
                                <div class="box-content">
                                    <div class="row-fluid">
                                        <? if($_SESSION['id_tipo_usuario']==2) {?>
                                        <div class="span6">
                                            <div class="control-group">
                                                <div class="controls controls-row">
                                                    <a href="usuario-descargar_manual" >Descargar manual Usuario para Administrador</a> <a href="usuario-descargar_manual" class='lock-screen' rel='tooltip' title="Descargar" data-placement="bottom"><i class="icon-download-alt"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <? }?>
                                        <div class="span<?=($_SESSION['id_tipo_usuario']==2) ? '6':'12'?>">
                                            <div class="control-group">
                                                <div class="controls controls-row">
                                                    <a href="usuario-descargar_manual-t-empresa">Descargar manual Usuario para Empresas</a> 
                                                    <a href="usuario-descargar_manual-t-empresa" class='lock-screen' rel='tooltip' title="Descargar" data-placement="bottom"><i class="icon-download-alt"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="clear:both"></div>
    <? include("includes/footer.php") ?>
</body>
</html>
<? }  
?> 