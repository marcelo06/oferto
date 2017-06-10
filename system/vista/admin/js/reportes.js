var chart;
var options;
$(document).ready(function() {	
	 ultimas_empresas();
	 mas_vendidos();
	 mas_visitados();
	 usuarios_siguiendo();
});

	function ultimas_empresas(){
		 $.post('empresa-listarUltimos',{},function(data){
			 	$("#empresas").html(data);
			 });
	}
	
	function mas_vendidos(){
		 $.post('producto-mas_vendidos',{},function(data){
			 	$("#productos").html(data);
			 });
	}

	function mas_visitados(){
		 $.post('producto-mas_visitados',{},function(data){
			 	$("#visitados").html(data);
			 });
	}

	function usuarios_siguiendo(){
		 $.post('usuario-listar_siguiendo',{},function(data){
			 	$("#usuarioss").html(data);
			 });
	}
	
	
	
