// JavaScript Document

$(document).ready(function(){

	/* Table initialisation */

	$('#ubicaciones').dataTable( {
		"aaSorting": [[ 0, "desc" ]],
		sPaginationType:"full_numbers",
	    oLanguage:{sSearch:"<span>Buscar:</span> ",sInfo:"Mostrando <span>_START_</span> a <span>_END_</span> de <span>_TOTAL_</span> Ubicaciones",sLengthMenu:"<span>Mostrando </span>_MENU_ <span>Ubicaciones por página</span>",sInfoEmpty: "Mostrando 0 a 0 de 0 ubicaciones",sInfoFiltered: "(Filtrado de _MAX_ total)",sZeroRecords: "No hay ubicaciones",oPaginate: {"sFirst": "Primero", "sPrevious":   "Anterior","sNext": "Siguiente", "sLast": "Último"}},
	    sScrollX:"100%",
	    bScrollCollapse:!0
	    });


});


function borrar(id){
	if(confirm("Está Seguro de eliminar la ubicación?")){
	var nTr = $("#row_"+id)[0];
	 var oTable = $('#ubicaciones').dataTable();	
	oTable.fnDeleteRow(nTr, function(){		 
		  $.post('almacen-borrar',{id : id}, 
		  function(data){
	       if(data == '1'){
		     mensaje = 'Ubicación Eliminada';
			 type = 'success';
		   }
		   else{
		     mensaje = 'Error eliminado, Intente de nuevo'
			 type = 'error';
		   }

		   $().toastmessage('showToast', {text     : mensaje,position : 'top-center',type     : type });

		})
	 })
	}
}

