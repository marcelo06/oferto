// JavaScript Document
$(document).ready(function(){

		$('#keywords').tagsInput({
				width: 'auto',
				height:'auto',
				identificador:'true',
				defaultText:'agregar',
				 'minChars' : 3,
				//autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
				autocomplete_url:' ', // jquery ui autocomplete requires a json endpoint
				autocomplete:{
								source: function(request, response) {
								  $.ajax({
								     url: "keyword-json_keywords",
								     dataType: "json",
								     data: {
								        texto: request.term
								     },
								     success: function(data) {
								        response( $.map( data, function( item ) {
								        	vreturn=item;
								        	vreturn.id=item.id_keyword;
								        	vreturn.valor=item.keyword;
					                        return {
					                            label: vreturn.valor,
					                            value: vreturn
					                        }
								        }));
								     }
								  })
								}
							}
			});


	check_existencia();
	editor = CKEDITOR.replace('detalles',{toolbar: 'Minimo'});
	
	$('#nombre_categoria').keypress(function(e) {
		if(e.keyCode == 13) {
			save_cate();
		}
	});
	
	$("a.editbox").fancybox({'hideOnContentClick': false,'height': 170,'width': 350,'type' : 'iframe' ,'autoDimensions': false});
	$('.editable').editable('categoria-editable', { type     : 'text', submit   : 'ok', tooltip   : 'Click para editar...'});
	$('.precios').keyup(function () { this.value = this.value.replace(/[^0-9]/g,'');});

});

function txtcontador(field, countfield, maxlimit){

	if (field.value.length > maxlimit)
		field.value = field.value.substring(0, maxlimit);
	else
		document.getElementById(countfield).innerHTML = maxlimit - field.value.length;
}

function borrararch(tipo){
	$("#delimg"+tipo).val('1');
}



function save_cate(){
	nuevo_n= $("#nombre_categoria").val();
	cuenta= $("#cuenta_cate").html();
	if(nuevo_n!='')
	{
		$.post('categoria-nueva_categoria',{nombre:nuevo_n,check:1,cuenta:cuenta},
			function(data)
			{
				resp = eval('(' +data+ ')');
				if(resp.estado==1)	{
					$("#lista_categorias").append(resp.info);
					mensaje = 'Categoría agregada';
					type = 'success';
					
					
					cuenta= parseInt(cuenta)+parseInt(1);
					$("#cuenta_cate").html(cuenta);
					$('.editable').editable('categoria-editable', { type     : 'text', submit   : 'ok', tooltip   : 'Click para editar...'});
					
					$(".icheck-me").length>0&&$(".icheck-me").each(function(){var e=$(this),t=e.attr("data-skin")!==undefined?"_"+e.attr("data-skin"):"",n=e.attr("data-color")!==undefined?"-"+e.attr("data-color"):"",r={checkboxClass:"icheckbox"+t+n,radioClass:"iradio"+t+n,increaseArea:"10%"};e.iCheck(r)})
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


				$("#close_add").trigger('click');
				$("#nombre_categoria").val('');
			});
}
}

function cerrar(info){ 
	$.fancybox.close();
	if(info!='')
	{
		info_d= info.split('-');
		cuenta= parseInt(info_d[2])+parseInt(1) ;
		
		$("#l_categorias").append('  <div class="categoria"><span class="editable" id="cat_'+info_d[0]+'">'+info_d[1]+'</span><input type="checkbox" checked="checked" name="cat['+info_d[2]+'][id_categoria]" value="'+info_d[0]+'" /></div>');
		$("#more_cat").attr('href','categoria-agregar_categoria-c-'+cuenta);
		
		$('.editable').editable('categoria-editable', { 
			type     : 'text',
			submit   : 'Guardar',
			tooltip   : 'Click para editar...'});
	}
}


/*******  adicionales **********/
$(document).ready(function(){


	$("#opciones").tagsInput({width:"auto",height:"auto"});
	$("#opciones_edit").tagsInput({width:"auto",height:"auto"});
	
})
function actualizar_adicional(post){
	valor= $("#adicional_"+post).val();
	$("#tad_"+post).html('"'+valor+'"');
}

function save_adicional(){
	nuevo_n= $("#adicional_n").val();
	opciones_n= $("#opciones").val();
	cuenta= $("#cuenta_adi").html();
	if(nuevo_n!='' && opciones_n!=''){
		$.post('adicional-agregar',{adicional:nuevo_n,check:1,cuenta:cuenta,opciones:opciones_n},
			function(data){
				resp = eval('(' +data+ ')');
				if(resp.estado==1)	{
					$("#lista_opciones").append(resp.info);
					mensaje = 'Adicional agregado';
					type = 'success';
					
					cuenta= parseInt(cuenta)+parseInt(1);
					$("#cuenta_adi").html(cuenta);
					$(".icheck-me").length>0&&$(".icheck-me").each(function(){var e=$(this),t=e.attr("data-skin")!==undefined?"_"+e.attr("data-skin"):"",n=e.attr("data-color")!==undefined?"-"+e.attr("data-color"):"",r={checkboxClass:"icheckbox"+t+n,radioClass:"iradio"+t+n,increaseArea:"10%"};e.iCheck(r)})
				}
				else{
					mensaje = 'Error al agregar, intente de nuevo'
					type = 'error';
				}

				$().toastmessage('showToast', {
					text     : mensaje,
					position : 'top-center',
					type     : type
				});


				$("#close_adi").trigger('click');
				$("#adicional_n").val('');
				$("#opciones").val('');
			});
	}
}

function edit_adi(id_a,nombre,opciones){
	$("#tad_edit").html('"'+nombre+'"');
	$("#id_edit").val(id_a);
	$("#adicional_edit").val(nombre);
	
	$('#opciones_edit').val('');
	$("#opciones_edit").importTags(opciones);	
}

function editar_adicional(){
	id_e= $("#id_edit").val();
	adicional_e= $("#adicional_edit").val();
	opciones_e= $("#opciones_edit").val();
	if(adicional_e!='' && opciones_e!=''){
		$.post('adicional-editar',{id:id_e,adicional:adicional_e,opciones:opciones_e},
			function(data){
				resp = eval('(' +data+ ')');
				if(resp.estado==1)	{
					$("#li_"+id_e+" span.task").html(resp.task);
					$("#li_"+id_e+" span.task-actions").html(resp.actions);
					mensaje = 'Adicional editado';
					type = 'success';
				}
				else{
					mensaje = 'Error al editar, intente de nuevo'
					type = 'error';
				}

				$().toastmessage('showToast', {
					text     : mensaje,
					position : 'top-center',
					type     : type
				});


				$("#close_edit").trigger('click');
			});
	}
}

function delete_adi(id_a){
	if(confirm("Seguro desea borrar este adicional?. Recuerde que otro producto puede estar usando este adicional.")){
		$.post('adicional-borrar',{id:id_a},function(data){
			if(data==1)	{
				$("#li_"+id_a).remove();
				mensaje = 'Adicional eliminado';
				type = 'success';
			}
			else{
				mensaje = 'Error al borrar, intente de nuevo'
				type = 'error';
			}

			$().toastmessage('showToast', {
				text     : mensaje,
				position : 'top-center',
				type     : type
			});

		})
	}
}
/*****************/


function check_existencia(){
	checked=$("#existencia_estado").is(":checked");

	if(checked)
		$("#datos_existencia").show();
	else
		$("#datos_existencia").hide();
}


