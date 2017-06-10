<html>
<head>
<link href="<?=URLVISTA?>css/bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="<?=URLVISTA?>css/normalize.css" rel="stylesheet" type="text/css" />
  <link href="<?=URLVISTA?>css/font-face.css" rel="stylesheet" media="screen"/>
  <link href="<?=URLVISTA?>css/drop-menu.css" rel="stylesheet" media="screen"/>
  <link href="<?=URLVISTA?>css/slicknav.css" rel="stylesheet" media="screen"/>
  <link href="<?=URLVISTA?>css/ihover.css" rel="stylesheet" media="screen"/>
    
  <!-- Main Style -->
  <link href="<?=URLVISTA?>css/style.css" rel="stylesheet" type="text/css" />

  <script language="javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script type="text/javascript" src="<?=URLVISTA?>js/jquery.validate.min.js"></script>
<script type="text/javascript">
var saved= '<?= nvl($saved) ?>';
$(document).ready(function(){
  $( "#formE" ).validate();
}); 

function enviarD() {
  if($("#formE").valid()){
  $.post('<?=URLBASE?>main-enviarEmail',$('#formE').serialize(),
  function(data){
		  if(data){
			$('#formE').css("display", "none") ;
			$('#msjDest').css("display", "block") ;
          $('#msjDest').html(data);
		  }
 	 });
  }
}

</script>
</head>
<body style="border: #E9308A solid; padding:10px; background-color:#FFF; background-image:none;">
 <div >
<div id="msjDest" style="margin-top:50px; display:none; text-align:center" ></div>
<h4>Enviar por email:</h4>

<img src="http://<?=DOMINIO.$imagen?>" style="float:left; margin-right:6px; width:130px;" /><h3><?= strtoupper($titulo)?></h3>
<div style="clear:both"></div>

<form class="formee" name="formE" id="formE" action="main-enviarEmail">

<input type="hidden" name="dat[titulo]" id="titulo" value="<?=$titulo?>" />
<input type="hidden" name="dat[imagen]" id="imagen" value="<?=$imagen?>" />
<input type="hidden" name="dat[enlace]" id="enlace" value="<?=$enlace?>" />
 <br>
        <label>Email: <em class="formee-req">*</em></label>
             <input type="text" name="dat[email]"  required class="form-control" id="email" />
     <br>
       
      <span class="blabel">
      <button type="button" name="button"  onClick="enviarD()" class="btn btn-primary upper">ENVIAR</button>
      </span>
 

 </form>
 </div>
</body>
</html>
