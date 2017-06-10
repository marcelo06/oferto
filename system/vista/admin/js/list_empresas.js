// JavaScript Document
var oTable;
$(document).ready(function(){

	/* Table initialisation */

	oTable= $('#usuarios').dataTable( {
		aaSorting:[[ 0, "desc" ]],
		sPaginationType:"full_numbers",
		oLanguage:{sSearch:"<span>Buscar:</span> ",
					sInfo:"Mostrando <span>_START_</span> a <span>_END_</span> de <span>_TOTAL_</span> "+nombre,
					sLengthMenu:"_MENU_ <span>"+nombre+" por página</span>",sInfoEmpty: "Mostrando 0 a 0 de 0 "+nombre+"",
					sInfoFiltered: "(Filtrado de _MAX_ total)",
					sZeroRecords: "No hay "+nombre+"",
					oPaginate: {"sFirst": "Primero", "sPrevious":   "Anterior","sNext": "Siguiente", "sLast": "Ultimo"}
				},
		sScrollX:"100%",
		bScrollCollapse:!0,
		
	} );

    $("a.edit_categoria").fancybox({
			'hideOnContentClick': false,
			'height': 410,
			'width': 850,
			'type' : 'iframe' ,
			'autoDimensions': false

	});

});


function borrar(id){
	if(confirm("Seguro desea borrar este "+nombre+"?"))
	{
	var nTr = $("#row_"+id)[0];
	 var oTable = $('#usuarios').dataTable();	
	oTable.fnDeleteRow(nTr, function(){		 
		  $.post('usuario-borrar',{id : id}, 
		  function(data){
	       if(data == '1'){
		     mensaje = nombre+' eliminado';
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

		})
	 })
	}

}

function cerrar()
{
	$.fancybox.close();
}
