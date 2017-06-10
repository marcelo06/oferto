// JavaScript Document
jQuery(document).ready(function(){
//    jQuery("#Fregistro").validationEngine({promptPosition: "topLeft",validationEventTrigger: "change" });
	
	
	if(mensaje!=''){
		showMessage(mensaje);
	}	
 });
   
   
function mostrar(){
    if(jQuery('#elpass:checked').val() == 'on'){
    jQuery('#passc').show();
	jQuery('#li_email_reg').css('display', 'none');
	}
  else{
    jQuery('#passc').hide();
	jQuery('#li_email_reg').css('display', 'block');
	
  }
}

function upemail()
{
	email= jQuery("#usuario").val();
	jQuery("#email_reg").val(email);
}


function localidades(tipo,origen,destino){
	valor=jQuery("#"+origen).val();
	if(tipo=='dptos')
		jQuery("#ciudad_reg").html('<option value=""></option>');
	jQuery.post('usuario-select_localidad',{tipo:tipo, valor:valor},function(data){
		if(data){
			jQuery("#"+destino).html('<option value=""></option>'+data);
		}
	})
}

