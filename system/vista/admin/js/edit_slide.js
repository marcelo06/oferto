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
      'height'      : 270,
      'padding'   : 1,
      'scrolling' : false,
	   
  		 fitToView : false,
  		 autoSize : false,
    });



    $('#file_upload').uploadifive({
            'auto'          : true,
            'formData'      : {'id_sesion' : id_sesion, 'token' : $('#token').val() },
            'queueID'       : 'fileQueue',
            'uploadScript'  : 'slide-subir_archivo',
            'buttonText'    : '',
            'fileType'     : 'image',
            onUploadComplete:function(file, data) {
              if(data){
                resp = eval('(' +data+ ')');
                $('#nuevoli').append('<div class="extras"></div><a class="fancybox-thumbs" title="" data-fancybox-group="thumbs" href="'+resp.archivo+'"></a><img class="imggal" id="addClass'+file.id+'" src="'+resp.thumbnail+'"  width="146" height="66" /><div class="deleteimg" id="dele'+resp.pos+'" onclick="borrar('+resp.pos+')"><img src="'+urlvista+'admin/img/Closed.png" title="eliminar imagen" alt="eliminar imagen" ></div><div class="editimg" ><a class="form_referencia" href="slide-form_referencia-id_doc-'+resp.pos+'-cod-'+$('#token').val()+'"><img src="'+urlvista+'admin/img/icon-02.png"></a></div>');
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
                  $.post('slide-ordenar',{arreglo : result, 'token' : $('#token').val()  });

              }
          });
        $( ".sortable" ).disableSelection();
       });

}


function borrar(pos){
  $.post('slide-borrar_archivo',
  { id_doc : pos , 'token' : $('#token').val() },
  function(data){
    if(data == '1'){
    $('#'+pos).fadeOut(250, function() { $('#'+pos).remove(); });
    }else
      alert("Failed to delete, please try again");
  });
}


function muestra_imagenes(){
  $('#fileQueue').html('');
    $.post('slide-cargar_galeria',
    { id : id_galeria , uploadId : 'uploadify' , 'token' : $('#token').val()  },
    function(data){
      $('#fileQueue').append(data);

      sortablegrid();

  });
}


function cerrar(){
  parent.$.fancybox.close();
}