// JavaScript Document
$(document).ready(function(){
	
	$('#subdominio').keyup(function () { this.value = this.value.replace(/[\. ]/g,'');});
	$('#dominio').keyup(function () { this.value = this.value.replace(/[ ]/g,'');});
	
	$('#telefono').keyup(function () { this.value = this.value.replace(/[^0-9]/g,'');});
	$('#movil').keyup(function () { this.value = this.value.replace(/[^0-9]/g,'');});
	
	$('#puntos_unidad').keyup(function () { this.value = this.value.replace(/[^0-9]/g,'');});
	$('#puntos_unidad').keyup(function () { 
		if($('#puntos_unidad').val() ==0)
			$('#puntos_unidad').val('')
	});
	
	organizar_subdominio();
	
	$('#subdominio').on('keyup', function(e) { organizar_subdominio(); });
	editor = CKEDITOR.replace('otro_descripcion',{toolbar: 'Minimo'});

$.validator.addMethod("passwordCheck", function (value, element) {
	return $(element).parent().find(".progress .bar").hasClass("bar-green");
    }, 'La contraseña no es segura');

validacion=$("#form_content").validate({
	errorElement:"span",
	errorClass:"help-block error",
	errorPlacement:function(e,t){t.parents(".controls").append(e)},
	highlight:function(e){$(e).closest(".control-group").removeClass("error success").addClass("error")},
	success:function(e){e.addClass("valid").closest(".control-group").removeClass("error success").addClass("success")},
	rules: {
            'usu[_password]': {
                passwordCheck: true
            }
        }
});

});

function mostrar(){
    if($('#elpass:checked').val() == 'on')
    $('#passc').show();
  else
    $('#passc').hide();
}

function borrararch(){
	$("#delimg").val('1');	
}

function organizar_subdominio(){
	text= $('#subdominio').val();
		var sensor = $('<span id="temptext">'+text+'</span>');
 		$('body').append(sensor);
  		var width = $("#temptext").width();
  		sensor.remove();
 
		nwidth=width+18;
		
		if(width>$(window).width()-200){
  			$("#tt_oferto").css('right','5px');
  			$("#tt_oferto").css('left','auto');
		}
		else if(width==0)
			$("#tt_oferto").css('left','83px');
		else
		   $("#tt_oferto").css('left',nwidth+'px');
}

function cambiar_dominio(tipo){
	$(".tipodominio").hide();
	$("#row_"+tipo).show();
}

function activar_pago(tipo){
	checked=$("#pago_"+tipo).is(":checked");
	
	if(checked)
	$("#datos_"+tipo).show();
	else{
	$("#datos_"+tipo).hide();
		if(tipo=='payu'){
			otro=$("#pago_otro").is(":checked");
			if(!otro){
				$("#pago_otro").prop('checked',true);
				$("#datos_otro").show();
			}
		}
		else if(tipo=='otro'){
			payu=$("#pago_payu").is(":checked");
			if(!payu){
				$("#pago_payu").prop('checked',true);
				$("#datos_payu").show();
			}
		}
	
	}
	/*if(!$("#pago_otro").is(":checked") && !$("#pago_payu").is(":checked")){
		$("#pago_otro").attr('data-rule-required',"true");
		$("#pago_payu").attr('data-rule-required',"true");
	}
	else{
		$("#pago_otro").removeAttr('data-rule-required');
		$("#pago_payu").removeAttr('data-rule-required');
		
		//validacion.resetForm(); 
        // $("#form_content")
		
	}*/
}

function checkWeb(){
	activo=$("#web").is(":checked");
	if(activo){
		$("#box_web").css('background-color','#FFF');
	
		$("#box_web input,#box_web textarea,#box_web select").attr("disabled",false)
	}
	else{
	
		$("#box_web input,#box_web textarea,#box_web select").attr("disabled",'disabled');

		$("#box_web").css('background-color','#EFEFEF');
		
	}
	
}

function activar_puntos(){
	checked=$("#puntos_activo").is(":checked");
	
	if(checked)
	$("#datos_puntos").show();
	else
	$("#datos_puntos").hide();
}
