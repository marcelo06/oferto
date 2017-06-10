<? include("includes/tags.php");?>
<script type="text/javascript">
jQuery(document).ready(function() {
    //jQuery("#form_pago").submit();
});
</script>
</head>
<body class="  checkout-cart-index">
<div class="wrapper">
    <div class="page">
<!-- HEADER BOF -->
<? include("includes/header.php");?>

<!-- HEADER EOF -->
	    <div class="main-container col1-layout">
            <div class="main row">
                <!-- breadcrumbs BOF -->
<div class="breadcrumbs">
    <ul>
            <li class="home">
                     <a href="main-index" title="Inicio">Inicio</a>
                       <span></span>
                        </li>
                    <li>
                          <strong>Módulo de pago</strong>
                   </li>
            </ul>
</div>
<!-- breadcrumbs EOF -->
  
<div class="col-main">
<h1 style="font-family: 'Myriad Pro',serif;font-size: 36px;font-weight: 400;letter-spacing: -1.5px;line-height: 30px;text-transform: uppercase; margin-bottom:30px;">Módulo de pago</h1> 
 <?= nvl($informe)?>
  <?= nvl($tabla)?>
 <?= nvl($form)?>
 <?= nvl($mensaje)?>
  <p>&nbsp;</p>
 </div>

            </div>
		    <!-- footer BOF -->
<? include("includes/footer.php");?>
<!-- footer EOF -->        </div>
            </div>
</div>
</body>
</html>
