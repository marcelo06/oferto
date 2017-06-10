// JavaScript Document
var typingTimer;
$(document).ready(function(){
    $("#ibusqueda").on("keyup", function(e) {
        typingTimer=setTimeout(obtenerSugerencias, 500);
    });
    
    $("#ibusqueda").on("keydown", function(e) {
        clearTimeout(typingTimer);
    });

     $("#ibusqueda").focusout(function() {
        if($('#sugerencias-busqueda').is(":hover")==false)
            $("#sugerencias-busqueda").html("");
    })
})

function obtenerSugerencias(){
	texto_sug=$("#ibusqueda").val();
	$("#sugerencias-busqueda").html("");
	 	$.ajax({
            url:"main-busqueda_sugerencias",
            data:{texto:texto_sug},
            dataType:'json',
			 type: "post",
            success:function (data) {
                if(data.cantidad){
					$("#sugerencias-busqueda").html(data.sugerencias);
				}
            }
       });
		
}