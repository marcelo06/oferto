// JavaScript Document
var mensaje = '';
$(document).ready(function(){
	$('.editable').editable('keyword-editable', { type     : 'text', submit   : 'ok', tooltip   : 'Click para editar...'});
	
	$('#nombre_keyword').keypress(function(e) {
        if(e.keyCode == 13) {
			save_cate();
        }
    });
});

	function save_cate(){
		nuevo_n= $("#nombre_keyword").val();
		if(nuevo_n!='')
		{
			$.post('keyword-nueva_keyword',{nombre:nuevo_n},
			function(data)
			{
				resp = eval('(' +data+ ')');
				if(resp.estado==1)	{
			   	 $(".basiclist").append(resp.info);
				 	mensaje = 'Categoría agregada';
				 	type = 'success';
					$('.editable').editable('keyword-editable', { type     : 'text', submit   : 'ok', tooltip   : 'Click para editar...'});
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
			$("#nombre_keyword").val('');
			});
		}
	}

	function delete_cate(id_keyword)
	{
		if(confirm("Seguro desea eliminar esta categoría?"))
			$.post('keyword-borrar_keyword',{id:id_keyword},
			function(data)
			{
				if(data==1)	{
			    $("#li_"+id_keyword).remove();
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

	
