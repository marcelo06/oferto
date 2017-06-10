<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <!-- Apple devices fullscreen -->
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <!-- Apple devices fullscreen -->
  <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

  <title>RHISS - Sistema Especializado Manejador de Contenidos</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="<?=URLVISTA?>admin/css/bootstrap.min.css">
  <!-- Bootstrap responsive -->
  <link rel="stylesheet" href="<?=URLVISTA?>admin/css/bootstrap-responsive.min.css">
  
  <!-- Theme CSS -->
  <link rel="stylesheet" href="<?=URLVISTA?>admin/css/style.css">
<style type="text/css">
#tlog{
  padding: 15px;
}
#tlog table td{
  border:1px solid #ddd;
}
#tlog table{
  background-color: #fafafa;
}
#tlog table table{
  background-color: #fff;
}
</style>
   </head>


<body>

<div class="Widgets">
  <div class="row-fluid">
    <div class="span12">
     <div class="modWid">
     

      <div class="iwrapform">
       <div class="row-fluid">
          
            <div class="span12" id="tlog">
          <?=$log?>
          </div>
         
           
           </div>
          
            </div>
            </div>
     </div>
   </div>
</div>     
</body>

</html>