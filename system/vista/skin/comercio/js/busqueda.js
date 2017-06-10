// JavaScript Document
var typingTimer;
jQuery(document).ready(function(){

    jQuery("#search").on("keyup", function(e) {
        typingTimer=setTimeout(obtenerSugerencias, 500);
    });
    
    jQuery("#search").on("keydown", function(e) {
        clearTimeout(typingTimer);
    });

    jQuery("#search").focusout(function() {
        if(jQuery('#sugerencias-busqueda').is(":hover")==false)
            jQuery("#sugerencias-busqueda").html("");
    })
})

function obtenerSugerencias(){
	
	texto_sug=jQuery("#search").val();
	jQuery("#sugerencias-busqueda").html("");
	 	jQuery.ajax({
            url:"main-busqueda_sugerencias",
            data:{texto:texto_sug},
            dataType:'json',
			 type: "post",
            success:function (data) {
                if(data.cantidad){
					jQuery("#sugerencias-busqueda").html(data.sugerencias);
				}
            }
       });
		
}