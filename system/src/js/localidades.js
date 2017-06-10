function cargar_localidad(campo_origen, campo_destino, tipolocal, numbienes){
	var idst = $("#"+campo_origen).val();
	objSelect = document.getElementById(campo_destino);
	$.post('localidad-listar_localidades.htm', 
	{ tipo : tipolocal , idd : idst, nbienes : numbienes },
	function(data){
		resp = eval("("+data+")");
		objSelect.options.length = 1; 
	  	for(i=0;i<resp.num;i++){
			value = resp.id[i];
			text = resp.nombre[i];
			option = new Option(text,value);
			try {
			   objSelect.add(option,null);
			} catch (e) {
			   objSelect.add(option,-1);
			}
		}
	})

	$("#"+campo_destino).ajaxStart(function(){
			option = new Option('Cargando...','0');
			try {
			   objSelect.add(option,null);
			} catch (e) {
			   objSelect.add(option,-1);
			}
	});
}

