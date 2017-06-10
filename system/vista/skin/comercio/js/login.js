function validar(){
	jQuery('.alerts-inf').show();
	jQuery('.alerts-inf').html("Verificando ....");	
	jQuery.post('login-validar', 
	{ usuario : jQuery('#user').val(), pass : jQuery('#password').val(), trc : jQuery('#trc').val(),cliente:1 }, 
	function(data){
		 if(data == 2){
			 lcompra=jQuery('#lcompra').val();  
			 if(lcompra=='1'){
				window.location = 'producto-checkout';
			 }
			else
				window.location = 'login-usuario';
		 }else{
			 jQuery('.alerts-inf').html(data);
		 }
	 })
}


jQuery(document).ready(function(){ 
	jQuery.get("login-crear_token",function(txt){
	  jQuery("#login-form").append('<input type="hidden" id="trc" value="'+txt+'" />');
	});
	jQuery('#login').on('click', validar);
	jQuery('#password').keypress(function(e) {
        if(e.keyCode == 13) {
			validar();
        }
    });
	jQuery('#lost').on('click', function(){
		if(jQuery('#user').val() == ''){
			smoke.alert('Ingresar el usuario de su cuenta');
		}else
			smoke.confirm('Enviar petición de cambio de contraseña a '+jQuery('#user').val()+'?',function(e){
				if (e){
					jQuery.post('login-olvido_pass',
					{ usuario : jQuery('#user').val(), trc : jQuery('#trc').val(),cliente:1 },
					function(data){
						smoke.alert(data);
					});
				}else{
					return false;
				}
			});
	});
});