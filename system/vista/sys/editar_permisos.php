<? include("includes/prehtml.php"); ?>
<head>
<? include("includes/tags.php"); ?>
<script language="JavaScript" type="text/javascript">

$(document).ready(function()
	{ 
		crearGrid('modulo-xml_permisos-modulo-login-tipo_usuario-1');
	 }
); 

function crearGrid(xml){
	mygrid = new dhtmlXGridObject('gridbox');
	mygrid.setImagePath("<?= URLBASE ?>system/src/grid/codebase/imgs/");
	mygrid.setHeader("Metodo,Permiso");
	mygrid.setInitWidths("400,74");
	mygrid.setColAlign("left,center");
	mygrid.setColTypes("ro,ch");
	mygrid.setColSorting("str,str");
	mygrid.enableLightMouseNavigation(true);
	mygrid.setColumnMinWidth(50,0);
	mygrid.setSkin("light");
	mygrid.attachEvent("onCheckbox",cambioCheck);
	mygrid.init();
	mygrid.loadXML(xml, function(){
		mygrid.attachHeader("<div id='title_flt'></div>,#rspan");
		//set title filter field
		//set author fiter field
		mygrid.setSizes();
	});
}
function cambioCheck(id,cell,anterior){
             if(anterior==true){
			 	var estado=1;
			 }
			 else{
			 	var estado=0;
			 }
			var mod = $('#modulos').val();
			var tu = $('#tipo_usuarios').val();
			$.post('modulo-cambiar_permiso', { metodo : id , cambio : estado, modulo : mod, usuario : tu },
				   function(data){
						if(data != "1"){
							alert("Error al cambiar de estado");
						}
					}
			
			);
					return true;
			}
			

function filterBy(){
	var tVal = document.getElementById("title_flt").childNodes[0].value.toLowerCase();
	for(var i=0; i< mygrid.getRowsNum();i++){
		var tStr = mygrid.cells2(i,0).getValue().toString().toLowerCase();
		
		if((tVal=="" || tStr.indexOf(tVal)!=-1)  ) 
			mygrid.setRowHidden(mygrid.getRowId(i),false)
		else
			mygrid.setRowHidden(mygrid.getRowId(i),true)
	}
}

function cargar_metodos(){
	var tu = $('#tipo_usuarios').val();
	var mo = $('#modulos').val();
	if(tu == 0 || mo == 0)
	 return false;
	else{
		mygrid.destructor();
		crearGrid('modulo-xml_permisos-modulo-'+mo+'-tipo_usuario-'+tu);
	}
}
</script>
<link rel="STYLESHEET" type="text/css" href="<?= URLBASE ?>system/src/grid/codebase/dhtmlxgrid.css">
<link rel="STYLESHEET" type="text/css" href="<?= URLBASE ?>system/src/grid/codebase/dhtmlxgrid_skins.css">
<script  src="<?= URLBASE ?>system/src/grid/codebase/dhtmlxcommon.js"></script>
<script  src="<?= URLBASE ?>system/src/grid/codebase/dhtmlxgrid.js"></script>		
<script  src="<?= URLBASE ?>system/src/grid/codebase/dhtmlxgridcell.js"></script>	
<script  src="<?= URLBASE ?>system/src/grid/codebase/excells/dhtmlxgrid_excell_link.js"></script>
<script  src="<?= URLBASE ?>system/src/grid/codebase/ext/dhtmlxgrid_drag.js"></script>
</head>

<body>
<? include("includes/header.php"); ?>
<div id="main">
  <div class="bloq1">
    <? include("includes/menu.php"); ?>
    
  <div class="bloq2">
    <div class="tt">
      <div class="ttx">Clientes / Listado de Clientes</div>
    </div>
    <div class="cont">
    	<div align="left">
    	  <h3><strong>Seleccionar para ver permisos:
  	    </strong></h3>
    	  <p><strong> Tipo de Usuario:</strong>
    	    <select name="tipo_usuarios" id="tipo_usuarios" onChange="cargar_metodos()">
    	      <option value="0">Seleccionar...</option>
    	      <?= $tipo_usuarios 
			?>
   	        </select>
    	    <br />
    	    <strong><br />
    	    Módulo:</strong>
    	    <select name="modulos" id="modulos" onChange="cargar_metodos()">
    	      <option value="0">Seleccionar...</option>
    	      <?= $modulos 
			?>
   	        </select>
    	    <br />
    	    <br />
  	    </p>
        </div>
   	  <div id="gridbox" width="476px" height="500px" style="background-color:white;"></div>
                <div style="display:none">
	<div id="title_flt_box"><input type="100%" style="border:1px solid gray;" onClick="(arguments[0]||window.event).cancelBubble=true;" onKeyUp="filterBy()"></div>
	<div id="author_flt_box"><select style="width:160" onclick="(arguments[0]||window.event).cancelBubble=true;" onChange="filterBy()"></select></div>
    <div id="author_flt_box1"><select style="width:100" onclick="(arguments[0]||window.event).cancelBubble=true;" onChange="filterBy()"></select></div>
</div></div>
  </div>
  <div class="both"></div>
</div>
<? include("includes/pie.php"); ?>
</body>
</html>
