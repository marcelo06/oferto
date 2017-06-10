// JavaScript Document

$(document).ready(function(){

	/* Table initialisation */

	$('#mailings').dataTable( {
		"aaSorting": [[ 0, "desc" ]],
		sPaginationType:"full_numbers",
	    oLanguage:{sSearch:"<span>Buscar:</span> ",sInfo:"Mostrando <span>_START_</span> a <span>_END_</span> de <span>_TOTAL_</span> Mailings",sLengthMenu:"_MENU_ <span>Mailings por página</span>",sInfoEmpty: "Mostrando 0 a 0 de 0 mailings",sInfoFiltered: "(Filtrado de _MAX_ total)",sZeroRecords: "No hay mailings",oPaginate: {"sFirst": "Primero", "sPrevious":   "Anterior","sNext": "Siguiente", "sLast": "Último"}}} );

    $(".box_log").fancybox({
			'hideOnContentClick': false,
			'height': 410,
			'width': 850,
			'type' : 'iframe' ,
			fitToView : false,
   autoSize : false

	});

});


function borrar(id){
	if(confirm("Está Seguro de eliminar el mailing?")){
	var nTr = $("#row_"+id)[0];
	 var oTable = $('#mailings').dataTable();	
	oTable.fnDeleteRow(nTr, function(){		 
		  $.post('mailing-borrar',{id : id}, 
		  function(data){
	       if(data == '1'){
		     mensaje = 'Mailing Eliminado';
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

