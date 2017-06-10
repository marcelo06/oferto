// JavaScript Document

$(document).ready(function(){

	oTable=$('#productos').dataTable({
		bProcessing:!0,
		"bServerSide":!0,
		sAjaxSource:"producto-json_listProductos",
		aaSorting:[[ 0, "desc" ]],
		sPaginationType:"full_numbers",
				aoColumns:[
			{mDataProp:"id_producto"},
			{mDataProp:"nombre"},
			{ "mDataProp": "categoria","bSearchable": false,"bSortable": false ,"aTargets": [ 0 ]  },
			{ "mDataProp": "estado" },
			{ "mDataProp": "oferta" },
			{ "mDataProp": "calificacion" },
			{ "mDataProp": "visitas" },
			{ "mDataProp": "compras" },
			{ "mDataProp": "opciones","bSearchable": false,  "bSortable": false,"aTargets":[0]}
			],
		oLanguage:{sSearch:"<span>Buscar:</span> ",
					sInfo:"Mostrando <span>_START_</span> a <span>_END_</span> de <span>_TOTAL_</span> Productos",
					sLengthMenu:"<span>Mostrando </span>_MENU_ <span>Productos por página</span>",sInfoEmpty: "Mostrando 0 a 0 de 0 productos",
					sInfoFiltered: "(Filtrado de _MAX_ total)",
					sZeroRecords: "No hay productos",
					oPaginate: {"sFirst": "Primero", "sPrevious":   "Anterior","sNext": "Siguiente", "sLast": "Último"}
				},
		"bFilter":false,
		sScrollX:"100%",
		bScrollCollapse:!0,
		"fnDrawCallback": function () {	
		 $(".boxComentarios").fancybox({'type' : 'iframe','height':200,'width': 600,fitToView:true, autoSize: true});		
			$('#productos tr').each(function (index){
				id_celda= $(this).attr("id");
				$(this).children("td").each(function (index2) {
					if(index2==3){
						$(this).css("cursor", "pointer");	
						$(this).css("text-decoration", "underline");
						$(this).editable( 'producto-estado', {
							"callback": function( sValue, y ) {	
								estado='success';
								mensaje='El producto está '+sValue;
								if(sValue=='Error'){
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
								"id_item": id_celda							
							},						
							data   : "{'Activo':'Activo','Inactivo':'Inactivo','Destacado':'Destacado'}",
							type   : 'select',
							submit : 'Guardar'							
						} );				
					}
					else if(index2==4){
						$(this).css("cursor", "pointer");	
						$(this).css("text-decoration", "underline");
						$(this).editable( 'producto-oferta', {
							"callback": function( sValue, y ) {	
								var id = $(this).closest("tr").attr("id");
								
								if(sValue=='Error'){
									$().toastmessage('showToast', {
										text     : 'Hubo un error al procesar la solicitud',
										position : 'top-center',
										type     : 'error'
									});
								}else if(sValue!='Inactivo'){
									window.location.href="producto-edit_oferta-producto-"+id;
								}
								else{
									$("#oferta_"+id).remove();
									$().toastmessage('showToast', {
										text     : 'La oferta está inactiva',
										position : 'top-center',
										type     : 'success'
									});
								}
							},
							"submitdata":{
								"id_item": id_celda							
							},						
							data   : "{'inactivo':'Inactivo','local':'solo en Sitio Web','portal':'solo en oferto.co','ambos':'En Sitio Web y oferto.co'}",
							type   : 'select',
							submit : 'Guardar'							
						} );				
					}

				})

			})				
		}
		
	});

    $("a.edit_categoria").fancybox({
			'hideOnContentClick': false,
			'height': 410,
			'width': 850,
			'type' : 'iframe' ,
			'autoDimensions': !0

	});

  $('.delete').on( 'click', function () {

	 if(confirm("Seguro desea borrar éste producto?")){

	   var oTable = $('#productos').dataTable();
	   var nTr = $(this).parents('td')[0];
	   var aPos = oTable.fnGetPosition( nTr );

       var aData = oTable.fnGetData( aPos[0] );

	   $.post('producto-borrar',
		{id : aData[0] },
		function(data){
	       if(data == '1'){
		     mensaje = 'Producto eliminado';
			 type = 'success';
             oTable.fnDeleteRow( aPos[0] );
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
	 }

  });

});

function borrar(id){
	if(confirm("Seguro desea borrar éste producto?"))
	{
	var nTr = $("#row_"+id)[0];
	 var oTable = $('#productos').dataTable();	
	oTable.fnDeleteRow(nTr, function(){		 
		  $.post('producto-borrar',{id : id}, 
		  function(data){
	       if(data == '1'){
		     mensaje = 'Producto eliminado';
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

function cambiarOferta(select, id){
	
	estado=select.value

	$.post('producto-oferta',
		{id :id , estado : estado  },
		function(data){
			if(estado!='inactivo'){
				window.location.href="producto-edit_oferta-producto-"+id;
			}
			else{
				$("#oferta_"+id).remove();
				resp = eval('(' +data+ ')');
				$().toastmessage('showToast', {
					text     : resp.mensaje,
					position : 'top-center',
					type     : resp.estado
				});
			}
        })
}

function cerrar()
{
	$.fancybox.close();
}


function filtro(){
	oferta= $("#oferta").val();
	buscar= $("#buscar").val();
	oTable.fnReloadAjax( "producto-json_listProductos-oferta-"+oferta+"-buscar-"+buscar );	
}