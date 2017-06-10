function validar(){
	$('.alerts-inf').show();
	$('.alerts-inf').html("Verificando ....");	
	$.post('login-validar', 
	{ usuario : $('#user').val(), pass : $('#password').val(), trc : $('#trc').val(),oferto:1 }, 
	function(data){
		 if(data == 2){
			 lcompra=$('#lcompra').val();  
			 if(lcompra){
				window.location = 'producto-checkout-comprar-'+lcompra;
			 }
			else
				window.location = 'login-usuario';
		 }else{
			 $('.alerts-inf').html(data);
		 }
	 })
}


$(document).ready(function(){ 
	$.get("login-crear_token",function(txt){
	  $("#login-form").append('<input type="hidden" id="trc" value="'+txt+'" />');
	});
	$('#login').on('click', validar);
	$('#password').keypress(function(e) {
        if(e.keyCode == 13) {
			validar();
        }
    });
	$('#lost').on('click', function(){
		if($('#user').val() == ''){
			smoke.alert('Ingresar el usuario de su cuenta');
		}else
			smoke.confirm('Enviar petición de cambio de contraseña a '+$('#user').val()+'?',function(e){
				if (e){
					$.post('login-olvido_pass',
					{ usuario : $('#user').val(), trc : $('#trc').val(),oferto:1 },
					function(data){
						smoke.alert(data);
					});
				}else{
					return false;
				}
			});
	});
});