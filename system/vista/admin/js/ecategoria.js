// JavaScript Document
var mensaje = '';
$(document).ready(function(){
	$('.editable').editable('empresa-editable', { type     : 'text', submit   : 'ok', tooltip   : 'Click para editar...'});
	
	$('#nombre_categoria').keypress(function(e) {
        if(e.keyCode == 13) {
			save_cate();
        }
    });
});


	function save_cate()
	{
		nuevo_n= $("#nombre_categoria").val();
		if(nuevo_n!='')
		{
			$.post('empresa-nueva_categoria',{nombre:nuevo_n},
			function(data)
			{
				resp = eval('(' +data+ ')');
				if(resp.estado==1)	{
			   	 $(".basiclist").append(resp.info);
				 	mensaje = 'Categoría agregada';
				 	type = 'success';
					$('.editable').editable('empresa-editable', { type     : 'text', submit   : 'ok', tooltip   : 'Click para editar...'});
		 	 	}
				else{
		     		mensaje = 'Error al eliminar, intente de nuevo'
			 		type = 'error';
		   		}

		  	 $().toastmessage('showToast', {
				text     : mensaje,
				position : 'top-center',
				type     : type
		  	 });
			 
			 
			$("#close_add").trigger('click');
			$("#nombre_categoria").val('');
			});
		}
	}

	function delete_cate(id_categoria)
	{
		if(confirm("Seguro desea eliminar esta categoría?"))
			$.post('empresa-borrar_categoria',{id:id_categoria},
			function(data)
			{
				if(data==1)	{
			    $("#li_"+id_categoria).remove();
				 	mensaje = 'Categoría eliminada';
				 	type = 'success';
		 	 	}
				else{
		     		mensaje = 'Error al eliminar, intente de nuevo'
			 		type = 'error';
		   		}

		  	 $().toastmessage('showToast', {
				text     : mensaje,
				position : 'top-center',
				type     : type
		  	 });
		   
			  
			});
	}

	
