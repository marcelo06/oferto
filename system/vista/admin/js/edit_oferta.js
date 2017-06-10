// JavaScript Document
$(document).ready(function(){
	check_existencia();
	check_almacenes();

	$('.existencia').keyup(function () { this.value = this.value.replace(/[^0-9]/g,'');});

	$('.precios').keyup(function () { this.value = this.value.replace(/[^0-9]/g,'');
		if(this.value==0)
			this.value='';
});

	$('#oferta_publicacion').datepicker().on('changeDate', function(ev){$("#oferta_publicacion").datepicker('hide') });
	
	$('#oferta_publicacion').on('change',function(){
    	$('#oferta_vencimiento').datepicker("remove");
    		mydatepicker();
		});
	mydatepicker();
});

function mydatepicker(){
	nfecha=$('#oferta_publicacion').val();
	var dattmp = nfecha.split('/').reverse().join('/'),
    nwdate =  new Date(dattmp);
	nwdate.setDate(nwdate.getDate());
	
	if(dias_oferta){
		mfecha =  new Date(dattmp);
		mfecha.setDate(mfecha.getDate());
		mfecha.setDate(mfecha.getDate() + dias_oferta); 
	}
	else
		mfecha='';
	$('#oferta_vencimiento').datepicker({ startDate: nwdate, endDate: mfecha}).on('changeDate', function(ev){$("#oferta_vencimiento").datepicker('hide') });
}

function getStartDate() { 
console.log('min'); 
        var d = $('#oferta_publicacion').datepicker('getDate');  
        if (d) return { startDate: d }  
    } 

function borrararch(tipo){
	$("#delimg"+tipo).val('1');
}

/*********** Almacenes ******************/
function check_almacenes(){
	value= $("#almtodos").is(':checked');
	if(value){
		$(".checkalm").attr('disabled','disabled');
		$(".checkalm").parent().removeClass('icheckbox_square-blue');
		$(".checkalm").parent().addClass('icheckbox_square-grey');
		$(".lialm").css('background-color','#FCFCFC');
		$(".lialm").css('color','#B6B6B6');
	
	}
	else{
		$(".checkalm").removeAttr('disabled');
		$(".checkalm").parent().addClass('icheckbox_square-blue');
		$(".checkalm").parent().removeClass('icheckbox_square-grey');
		$(".lialm").removeProp('style');
	}
}

function check_existencia(){
	checked=$("#oferta_existencia_estado").is(":checked");
	
	if(checked)
	$("#datos_existencia").show();
	else
	$("#datos_existencia").hide();
}


