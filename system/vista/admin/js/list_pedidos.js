// JavaScript Document

$(document).ready(function(){

	/* Table initialisation */

	oTable=$('#pedidos').dataTable( {
		"aaSorting": [[ 0, "desc" ]],
		sPaginationType:"full_numbers",
	    oLanguage:{sSearch:"<span>Buscar:</span> ",sInfo:"Mostrando <span>_START_</span> a <span>_END_</span> de <span>_TOTAL_</span> Pedidos",sLengthMenu:"<span>Mostrando </span>_MENU_ <span>Pedidos por página</span>",sInfoEmpty: "Mostrando 0 a 0 de 0 pedidos",sInfoFiltered: "(Filtrado de _MAX_ total)",sZeroRecords: "No hay pedidos",oPaginate: {"sFirst": "Primero", "sPrevious":   "Anterior","sNext": "Siguiente", "sLast": "Último"}},sScrollX:"100%",
	    bScrollCollapse:!0,
		"fnDrawCallback": function () {	

			$('#pedidos tr').each(function (index){
				id_celda= $(this).attr("id");
				$(this).children("td").each(function (index2) {
					cont= $(this).html();
					if(index2==5 && cont=='Pago pendiente' && puedeEditar){
						$(this).css("cursor", "pointer");	
						$(this).css("text-decoration", "underline");
						$(this).editable( 'pedido-estado', {
							"callback": function( sValue, y ) {	
								estado='success';
								mensaje='el estado cambió a '+sValue;
								if(sValue=='Error'){
									mensaje='Hubo un error al procesar la solicitud';
									estado='error';
								}

								$().toastmessage('showToast', {
									text     : mensaje,
									position : 'top-center',
									type     : estado
								});	

								location.reload();
							},
							"submitdata":{
								"id_item": id_celda							
							},						
							data   : "{'Pago confirmado':'Pago confirmado','Pago pendiente':'Pago pendiente','Cancelado':'Cancelado'}",
							type   : 'select',
							submit : 'Ok'	,
							cancel:'Salir'						
						} );				
					}
					
				})

			})				
		}

	    
  });

oTable.fnFilter(buscar);
  $("a.formulario").fancybox({
				'hideOnContentClick': false,
				'type' : 'ajax',
				'autoDimensions': true
			});
});

function borrar(id){
	if(confirm("Está Seguro de eliminar el pedido?")){
	var nTr = $("#row_"+id)[0];
	 var oTable = $('#pedidos').dataTable();	
	oTable.fnDeleteRow(nTr, function(){		 
		  $.post('pedido-borrar',{id : id}, 
		  function(data){
	       if(data == '1'){
		     mensaje = 'Pedido Eliminado';
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

 function cambiarEstado(select, id){

	$.post('pedido-estado',
		{id :id , estado : select.value  },
		function(data){
			resp = eval('(' +data+ ')');

			$().toastmessage('showToast', {
				text     : resp.mensaje,
				position : 'top-center',
				type     : resp.estado
			});
        })
}