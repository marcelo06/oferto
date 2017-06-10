// JavaScript Document
$(document).ready(function(){
	$('#email_reg').css('display', 'none');
	
	if(mensaje!=''){
		smoke.signal(mensaje);
		
	}	
 });
   
   
function mostrar(){
    if($('#elpass:checked').val() == 'on'){
    $('#passc').show();
	$('#email_reg').css('display', 'none');
	}
  else{
    $('#passc').hide();
	$('#email_reg').css('display', 'block');
	
  }
}

function localidades(tipo,origen,destino){
	valor=$("#"+origen).val();
	if(tipo=='dptos')
		$("#ciudad_reg").html('<option value=""></option>');
	$.post('usuario-select_localidad',{tipo:tipo, valor:valor},function(data){
		if(data){
			$("#"+destino).html('<option value=""></option>'+data);
		}
	})
}
