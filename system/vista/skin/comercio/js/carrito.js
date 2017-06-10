// JavaScript Document
var typingTimer;                //timer identifier
var id;
var doneTypingInterval = 5000;  //time in ms, 5 second for example


 function getCarrito(url){     
        try {
            jQuery.ajax({
                url:url,
                dataType:'json',
				 type: "post",
                success:function (data) {
                 
                    if (data.status != 'ERROR' && jQuery('.cart-top-container').length) {
                        jQuery('.cart-top-container').replaceWith(data.cart_top);
                    }
                }
            });
        } catch (e) {
			
       }
    }

function eliminar_fila(id){
	jQuery.post('producto-borrar_carrito', 
			{ id : id },
			function(data){
			  if(data == "1"){
				  
				 getCarrito('producto-tabla_carrito');
				 if(jQuery("#shopping-cart-table").length){
					
					
					var precio_prod= parseInt(jQuery("#precio_val"+id).html());
					var total= parseInt(jQuery("#total_val").html());
					
					pr_total= total-precio_prod;
				
				jQuery("#total_val").html(pr_total);
				 pr_total= number_format (pr_total, 0, '.', '.') ;
				jQuery("#total_tt").html("$"+pr_total);
				
				jQuery("#prod"+id+"").remove(); 
				 }
			  }
			 
			 
			 });

}



function number_format (number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

function updateUp(ident, keyCode,id_prod){
	id=ident;
	idprod=id_prod;
	typingTimer=setTimeout(updateCarrito, 1100);
}

function updateDown(){
	clearTimeout(typingTimer);
}

function updateCarrito(ido,id_prod){
	if(ido)
	id=ido;

	if(id_prod)
	idprod=id_prod;

var cantidad = jQuery('#cantidad'+id).val(); 
	jQuery.post('producto-actualizar', 
	{ id : id, cantidad : cantidad, actualizar:true ,idprod:idprod},
	function(data){
	  if(data == 1){
	   jQuery('#mensaje'+id).html("Item Actualizado");
	   
	  }else if(data==0){
	  	jQuery('#mensaje'+id).html("Error al Actualizar");
	  }
	  else if(data==2 || data==3){
	  	jQuery('#mensaje'+id).html("La cantidad solicitada no está disponible");
	  }
		setInterval(function(){ jQuery('#mensaje'+id).hide(); }, 3500);
		parent.location = ('producto-carrito-msj-'+data);
	 });
}	