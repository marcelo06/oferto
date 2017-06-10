// JavaScript Document
mensaje = '';
$(document).ready(function(){
	if(mensaje != ''){
		parent.$().toastmessage('showToast', {
			text     : mensaje,
			position : 'top-center',
			type     : 'success'
		});
parent.cerrar();
	}
});