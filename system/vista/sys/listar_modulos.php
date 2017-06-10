<? include("includes/prehtml.php"); ?>
<head>
<? include("includes/tags.php"); ?>
<script language="JavaScript" type="text/javascript">
function borrar(id){
	if(confirm("Seguro desea borrar este item")){
		$.post('modulo-borrar', 
		{ id : id },
		function(data){
			if(data == "1"){
				mygrid.deleteRow(id);
				$("#salida").html("Modulo "+id+" eliminado");
			}else
				$("#salida").html("Error al eliminar");
		})
	}
		
}
$(document).ready(function()
	{ 
		crearGrid();
	 }
); 

function crearGrid(){
	mygrid = new dhtmlXGridObject('gridbox');
	mygrid.setImagePath("<?= URLBASE ?>system/src/grid/codebase/imgs/");
	mygrid.setHeader("Modulo,Editar,Borrar");
	mygrid.setInitWidths("574,70,70");
	mygrid.setColAlign("left,center,center");
	mygrid.setColTypes("ro,link,link");
	mygrid.setColSorting("str,str,str");
	mygrid.enableLightMouseNavigation(true);
	mygrid.setColumnMinWidth(50,0);
	mygrid.setSkin("light");
	mygrid.init();
	mygrid.loadXML("modulo-xml_modulos", function(){
		mygrid.attachHeader("<div id='title_flt'></div>,#rspan,#rspan");
		//set title filter field
		document.getElementById("title_flt").appendChild(document.getElementById("title_flt_box").childNodes[0])
		//set author fiter field
		mygrid.setSizes();
	});
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
      <div class="ttx">Módulos / Listado de Módulos</div>
    </div>
    <div class="cont">
    	<div align="right">
    	  <button onClick="location= 'modulo-edit_modulo'">Agregar Módulo</button>
    	  <br />
<br />
        </div>
   	  <div id="gridbox" width="714px" height="400px" style="background-color:white;"></div>
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
