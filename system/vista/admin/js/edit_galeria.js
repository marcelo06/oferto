// JavaScript Document
var mensaje = '';
$(document).ready(function(){

    $('.fancybox-thumbs').fancybox({
     padding: 1,
     helpers : {
        title : {
          type : 'outside'
        },
      }
    });


    $("a.form_referencia").fancybox({
      'hideOnContentClick': false,
      'type' : 'iframe' ,
      
      'width'       : 580,
      'height'      : 200,
      
      'padding'   : 1,
      'scrolling' : false,
	  fitToView : false,
  		 autoSize : false
    });


    $('#file_upload').uploadifive({
            'auto'          : true,
            'formData'      : {'id_sesion' : id_sesion, 'token' : $('#token').val() },
            'queueID'       : 'fileQueue',
            'uploadScript'  : 'galeria-subir_archivo',
            'buttonText'    : '',
            'fileType'     : 'image',
            onUploadComplete:function(file, data) {
              if(data){
                resp = eval('(' +data+ ')');
                $('#nuevoli').append('<div class="extras"></div><a class="fancybox-thumbs" title="" data-fancybox-group="thumbs" href="'+resp.archivo+'"></a><img class="imggal" id="addClass'+file.id+'" src="'+resp.thumbnail+'"  width="104" height="56" /><div class="deleteimg" id="dele'+resp.pos+'" onclick="borrar('+resp.pos+')"><img src="'+urlvista+'admin/img/Closed.png" title="eliminar imagen" alt="eliminar imagen" ></div><div class="editimg" ><a class="form_referencia" href="galeria-form_referencia-id_doc-'+resp.pos+'-cod-'+$('#token').val()+'"><img src="'+urlvista+'admin/img/icon-02.png"></a></div>');
                $('#nuevoli').attr("value",resp.pos);
                $('#nuevoli').attr("id",resp.pos);
              }else{
                alert('Imagen inválida');
                $('#nuevoli').remove();
              }

            },
            'onAddQueueItem' : function(file) {
              $('#fileQueue').append('<li class="ui-state-default addimage imageli"  value="" id="nuevoli"></li>');
            },
            'onError'      : function(errorType) {
                if('FORBIDDEN_FILE_TYPE' == errorType){
                  $('#nuevoli').remove();
                  alert('Tipo de archivo inválido, solo imágenes');
                }
            }
    });

    muestra_imagenes();

});

function sortablegrid(){

       $(function(){
        $( ".sortable" ).sortable({
          stop: function(evento, ui){
                  var result = $('.sortable').sortable('toArray');
                  $.post('galeria-ordenar',{arreglo : result, 'token' : $('#token').val()  });

              }
          });
        $( ".sortable" ).disableSelection();
       });

}


function borrar(pos){
  $.post('galeria-borrar_archivo',
  { id_doc : pos , 'token' : $('#token').val() },
  function(data){
    if(data == '1'){
    $('#'+pos).fadeOut(250, function() { $('#'+pos).remove(); });
    }else
      alert("Error Eliminado, intente de nuevo");
  });
}


function muestra_imagenes(){
  $('#fileQueue').html('');
    $.post('galeria-cargar_galeria',
    { id : id_galeria , uploadId : 'uploadify' , 'token' : $('#token').val()  },
    function(data){
      $('#fileQueue').append(data);

      sortablegrid();

  });
}
