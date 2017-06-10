// JavaScript Document
$(document).ready(function(){
	$("#filtros_sitio").hide();
		$("#filtros_oferto").hide();

		editor = CKEDITOR.replace('contenido',{toolbar: 'Minimo'});

	oTable=$('#clientes').dataTable({
		bProcessing:!0,
		"bServerSide":!0,
		sAjaxSource:"mailing-json_listClientes-empresa-"+empresa+"-compras-"+compras+"-sigue-"+sigue+"-puntos-"+puntos+"-de-"+de,
		sPaginationType:"full_numbers",
		aoColumns:[
			{"mDataProp":"nombre"},
			{"mDataProp":"email"},
			{ "mDataProp": "tipo" }
			],
		oLanguage:{sSearch:"<span>Buscar:</span> ",
					sInfo:"Mostrando <span>_START_</span> a <span>_END_</span> de <span>_TOTAL_</span> Clientes",
					sLengthMenu:"<span>Mostrando </span>_MENU_ <span>Clientes por página</span>",sInfoEmpty: "Mostrando 0 a 0 de 0 clientes",
					sInfoFiltered: "(Filtrado de _MAX_ total)",
					sZeroRecords: "No hay clientes",
					oPaginate: {"sFirst": "Primero", "sPrevious":   "Anterior","sNext": "Siguiente", "sLast": "Último"}
				},
		"bFilter":false,
		sScrollX:"100%",
		bScrollCollapse:!0
	});
});

function filtro(tipo,val){
	$("#limpiar").html('<i class="icon-undo"></i>');
	if(tipo=='de'){

		if(val=='oferto'){
			$("#filtros_sitio").hide();
			$("#filtros_oferto").show();
			de='oferto';
			if(puntos!=''){
				$("#puntos_"+puntos).prop('checked', false);
				console.log("#puntos_"+puntos);
				puntos='';
			}
				
		}	
		else if(val=='sitio'){
			$("#filtros_sitio").show();
			$("#filtros_oferto").hide();
			de='sitio';
			if(sigue!=''){
				$("#sigue_"+sigue).prop('checked', false);
				console.log("#sigue"+sigue);
				sigue='';
			}
				
		}
	}
	else if(tipo=='compras'){
			compras=val;
	}
	else if(tipo=='sigue'){
			sigue=val;
	}
	else if(tipo=='puntos'){
			puntos=val;
	}
	$("#cadfiltro").val("compras_"+compras+",sigue_"+sigue+",puntos_"+puntos+",de_"+de);

	oTable.fnReloadAjax( "mailing-json_listClientes-empresa-"+empresa+"-compras-"+compras+"-sigue-"+sigue+"-puntos-"+puntos+"-de-"+de);	
}

function limpiar(){
	$("#b-filtros input:radio").attr("checked", false);
	$("#filtros_oferto, #filtros_sitio").hide();
	$("#cadfiltro").val("");
	compras='';
	sigue='';
	puntos='';
	de='';
	oTable.fnReloadAjax( "mailing-json_listClientes-empresa-"+empresa+"-compras-"+compras+"-sigue-"+sigue+"-puntos-"+puntos+"-de-"+de );	
}