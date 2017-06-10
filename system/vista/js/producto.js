
    $(document).ready(function(){
        check_carrito();
        $("#boxEmail").fancybox({'type' : 'iframe','height':350,'width': 300,fitToView:false, autoSize: false});
        $(".boxComentarios").fancybox({'type' : 'iframe','height':200,'width': 600,fitToView:true, autoSize: true});

        	$('.rating').jRating({
				length:5,
				decimalLength:0,
				rateMax :5,
				canRateAgain : false,
	 	 		nbRates : 10,
				step:true,
				type:'big',
				 isDisabled : true,
				onError : function(){
					alert('Error : please retry');
				}
			});

			$('#cantidad').keyup(function () { this.value = this.value.replace(/[^0-9]/g,'');});
			$('#cantidad').change(function () { if(this.value ==0) this.value=1;});
    });

    function activar_carrito(p){
       estado=1;
       adicionales[p]=1;
       for(i=0; i< adicionales.length;i++){
          if(adicionales[i]==0)
              estado=0;
      }
      carrito_act=estado;

      if(carrito_act==1)
       check_carrito();
}

function check_carrito(){
	if(!carrito_act){
		$("#cart_button").attr('disabled',true);
	}
	else{
		$("#span_cart").remove();
		if(cantidad)
       $("#cart_button").removeAttr('disabled');
       
   }
}

function ver_cantidad(){
	
  cantidad=$("#cantidad").val();
  $.post("producto-validar_cantidad",{id_producto:id_producto,cantidad:cantidad},function(data){
    if(data=='true'){
      cantidad=1;
       $(".span_cant").html('');
       check_carrito();
    }
    else{
    cantidad=0;
      $("#cart_button").attr('disabled',true);
      $(".span_cant").html('La cantidad solicitada no se encuentra disponible');
    }
  });
}

function seguir(id_empresa,estado){
	$.post("empresa-seguir",{empresa:id_empresa,estado:estado},function(data){
		if(data){
			if(estado){
				$(".seguir-emp").html('<span id="span_seguir">Dejar de seguir esta empresa</span>\
					<button class="seguir" onClick="seguir('+id_empresa+',0)"><i class="fa fa-heart"></i> SIGUENDO</button>');
			}else{
				$(".seguir-emp").html('<span id="span_seguir">Seguir esta empresa</span>\
					<button class="seguir" onClick="seguir('+id_empresa+',1)"><i class="fa fa-heart-o"></i> SEGUIR</button>');
			}
		}else{
			//errror
		}
	})
}