// JavaScript Document
$(document).ready(function(){

    categorias();

    $("a.edit_categoria").fancybox({
			'hideOnContentClick': false,
			'height': 410,
			'width': 850,
			'type' : 'iframe' ,
			fitToView : false,
   autoSize : false,
			onClosed:function(){categorias();}

	});
});




function categorias()
{
	$.post('arbol_menu-selectCategorias',{id:identificador,categoria:id_categoria}, function(data){
		$("#id_categoria").html('');
		$("#id_categoria").html(' <option value="0">Seleccione una categoría</option>'+data);
		});
}

function cerrar()
{
	$.fancybox.close();
	categorias()
}


