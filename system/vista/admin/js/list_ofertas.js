// JavaScript Document

$(document).ready(function(){

	/* Table initialisation */

	oTable= $('#productos').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "producto-json_listOfertas",	
		aaSorting: [[ 3, "desc" ]],
		sPaginationType:"full_numbers",
		"aoColumns": [					
		{ "mDataProp": "id_producto" },
		{ "mDataProp": "nombre"},
		{ "mDataProp": "oferta_descripcion"},
		{ "mDataProp": "oferta_publicacion"},
		{ "mDataProp": "oferta_vencimiento"},
		{ "mDataProp": "oferta_precio" },
		{ "mDataProp": "empresa" },
		{ "mDataProp": "oferta_aprobada"},
		{ "mDataProp": "oferta_destacado" },
		{ "mDataProp": "visitas" },
		{ "mDataProp": "compras" },
		{ "mDataProp": "opciones","bSearchable": false,  "bSortable": false , "aTargets": [ 0 ] }
		],
		oLanguage:{sSearch:"<span>Buscar:</span> ",sInfo:"Mostrando <span>_START_</span> a <span>_END_</span> de <span>_TOTAL_</span> Ofertas",sLengthMenu:"<span>Mostrando </span>_MENU_ <span>Ofertas por página</span>",sInfoEmpty: "Mostrando 0 a 0 de 0 ofertas",sInfoFiltered: "(Filtrado de _MAX_ total)",sZeroRecords: "No hay ofertas",oPaginate: {"sFirst": "Primero", "sPrevious":   "Anterior","sNext": "Siguiente", "sLast": "Último"}},
		sScrollX:"100%",
		bScrollCollapse:!0,
		"fnDrawCallback": function () {	
		

			$("a.boxAprobar").fancybox({
      'hideOnContentClick': false,
      'type' : 'iframe' ,
      'width'       : 380,
      'height'      : 300,
      'padding'   : 0,
      'scrolling' : false,
	   
  		 fitToView : false,
  		 autoSize : false,
    });



			$('#productos tr').each(function (index){
				id_celda= $(this).attr("id");
				$(this).children("td").each(function (index2) {

					if(index2==7  && esAdmin){
						/*
						$(this).css("cursor", "pointer");	
						$(this).css("text-decoration", "underline");
						
						$(this).editable( 'producto-oferta_aprobada', {
							"callback": function( sValue, y ) {	
								estado='success';
								if(sValue=='Si')
									mensaje='La oferta está aprobada';
								else if(sValue=='No')
									mensaje='La oferta NO está aprobada';
								else{
									mensaje='Hubo un error al procesar la solicitud';
									estado='error';
								}

								$().toastmessage('showToast', {
									text     : mensaje,
									position : 'top-center',
									type     : estado
								});	

								oTable.fnReloadAjax( "producto-json_listOfertas" );
							},
							"submitdata":{
								"id_item": id_celda,
								"columna": 'aprobada'								
							},
							height : '14px',							
							data   : "{'No':'No','Si':'Si'}",
							type   : 'select',
							submit : 'Ok'							
						} );

						*/					
					}
					else if(index2==8 && esAdmin){
						$(this).css("cursor", "pointer");	
						$(this).css("text-decoration", "underline");
						/*******************************************************/
						$(this).editable( 'producto-oferta_destacado', {
							"callback": function( sValue, y ) {	
								estado='success';
								if(sValue=='Si')
									mensaje='La oferta está destacada';
								else if(sValue=='No')
									mensaje='La oferta NO está destacada';
								else{
									mensaje='Hubo un error al procesar la solicitud';
									estado='error';
								}

								$().toastmessage('showToast', {
									text     : mensaje,
									position : 'top-center',
									type     : estado
								});	
							},
							"submitdata":{
								"id_item": id_celda,
								"columna": 'destacado'								
							},
							height : '14px',							
							data   : "{'No':'No','Si':'Si'}",
							type   : 'select',
							submit : 'Ok'							
						} );

						/*******************************************************/					
					}

				})

			})				
		} 
	});
oTable.fnFilter(buscar);
$("a.espreview").fancybox({
		'hideOnContentClick': false,
		'type' : 'iframe',
		mouseWheel:false,
		'autoDimensions': true
	});



});

function borrar(id){
	if(confirm("Seguro desea quitar esta oferta de oferto.co? "))
	{
	var nTr = $("#row_"+id)[0];
	 var oTable = $('#productos').dataTable();	
	oTable.fnDeleteRow(nTr, function(){		 
		  $.post('producto-borrar_oferta',{id : id}, 
		  function(data){
	       if(data == '1'){
		     mensaje = 'Oferta eliminada';
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


function cerrar(){
	$.fancybox.close();
	oTable.fnReloadAjax( "producto-json_listOfertas" );
}
