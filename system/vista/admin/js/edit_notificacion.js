// JavaScript Document
$(document).ready(function(){
	if($("#cadfiltro").val()!='' && edicion=='1') 
		$("#limpiar").html('<i class="icon-undo"></i>');

	contarFiltro("-logueado-"+logueado+"-compras-"+compras);
	actualizarAccion();
});

function filtro(tipo,val){
	$("#limpiar").html('<i class="icon-undo"></i>');
	if(tipo=='logueado'){
		logueado=val;
		if(val=='si'){
			$("#filtros_login").show();		
		}	
		else if(val=='no'){
			$("#filtros_login").hide();	
			$("#filtros_login input:radio").attr("checked", false);
			compras='';	
		}
	}
	else if(tipo=='compras'){
			compras=val;
	}
	
	$("#cadfiltro").val("logueado_"+logueado+",compras_"+compras);

	contarFiltro("-logueado-"+logueado+"-compras-"+compras);	
}

function limpiar(){
	$("#b-filtros input:radio").attr("checked", false);
	$("#cadfiltro").val("");
	compras='';
	logueado='';
	contarFiltro("-logueado-"+logueado+"-compras-"+compras);	
}

function contarFiltro(variables){
	$.get("notificacion-total_clientes"+variables,{},function(data){
		$("#total").html(data);
	})
}

function borrararch(){
	$("#delimg").val('1');
}

function actualizarAccion(){
	$(".boxAccion").hide();
	var accion= $("#accion").val();
	if(accion=='Ver producto'){
		$("#boxOferta").show();
	}
	else if(accion=='Listado categoria'){
		$("#boxCategoria").show();
	}
}

if($("#id_oferta").length > 0){
	function formatFlags(state){
		if (!state.id) return state.text; 
		//<img style='padding-right:10px;' width='50' src='"+urlbase+"system/files/" + state.id.toLowerCase() + ".gif'/>" + state.text;
		texto=state.text.split('_');
		return "<img style='padding-right:10px;' width='30' src='"+urlbase+"files/galerias/s"+texto[0]+"'/>" + texto[1];
	}
	$("#id_oferta").select2({
		formatResult: formatFlags,
		formatSelection:formatFlags,
		escapeMarkup: function(m) { return m; }
	});
}
