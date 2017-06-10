<!doctype html>
<html>
<head>
<!-- jQuery -->
<script src="<?=URLVISTA?>admin/js/jquery.min.js"></script>
<?= plugin::message() ?>
<!-- Bootstrap -->
<link rel="stylesheet" href="<?=URLVISTA?>admin/css/bootstrap.min.css">

<script type="text/javascript">
 var mensaje = '<?= nvl($mensaje,'') ?>';

$(document).ready(function(){
  if(mensaje != ''){
    parent.$().toastmessage('showToast', {
      text     : mensaje,
      position : 'top-center',
      type     : 'success'
    });
parent.cerrar();
  }
});
</script>
</head>

<body data-mobile-sidebar="button">

  <div class="container-fluid" id="content">

    <div id="main">
      <div class="container-fluid">


        <div class="row-fluid">
          <div class="span12">
                    <form class='form-vertical' method="post">
                     <input type="hidden" name="id_producto" id="id_producto"  value="<?= nvl($dat['id_producto']) ?>">
            <div class="box" >       
                  <div class="row-fluid">
                    <div class="span12">
                      <br/>
                      <div class="control-group">
                        <label for="oferta_aprobada" class="control-label">Aprobar oferta</label>
                        <div class="controls controls-row">
                          <? if($tarea=='editar'){ ?>
                          <select class="input-block-level" name="dat[oferta_aprobada]" id="oferta_aprobada">
                            <option <?=(nvl($dat['oferta_aprobada'])=='') ? 'selected':'' ?>></option>
                            <option <?=(nvl($dat['oferta_aprobada'])=='Si') ? 'selected':'' ?>>Si</option>
                            <option <?=(nvl($dat['oferta_aprobada'])=='No') ? 'selected':'' ?>>No</option>
                          </select>
                          <? } else{?>
                          <?=nvl($dat['oferta_aprobada'])?>
                        <?  }?>
                        </div>
                      </div>
                    </div>
                                        </div>
                                        <div class="row-fluid">
                    <div class="span12">
                      <div class="control-group">
                        <label for="oferta_aprobada_comentario" class="control-label">Comentario</label>
                        <div class="controls controls-row">
                          <? if($tarea=='editar'){ ?>
                          <textarea placeholder="Comentarios:" class="input-block-level" name="dat[oferta_aprobada_comentario]" id="oferta_aprobada_comentario"><?= nvl($dat['oferta_aprobada_comentario']) ?></textarea>
                          <? } else{?>
                          <?=nvl($dat['oferta_aprobada_comentario'])?>
                        <?  }?>
                        </div>
                      </div>
                    </div>
                  </div>
           <? if($tarea=='editar'){ ?>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn" onClick="parent.cerrar()">Cancelar</button>
                  </div>
                  <? }?>
                 </div>

                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
  </body>

  </html>

