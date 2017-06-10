var mensaje ='';
var mensaje_tipo = 'success';

// JavaScript Document

$(document).ready(function(){

	if(mensaje != ''){
       showStickyToast();
	}

});

function showStickyToast() {

	$().toastmessage('showToast', {
		text     : mensaje,
		position : 'top-center',
		type     : mensaje_tipo
	});
}


