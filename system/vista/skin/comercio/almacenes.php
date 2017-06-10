<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="info@rhiss.net">
<script language="javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
 <script type="text/javascript" src="<?= URLVISTA ?>skin/comercio/js/infobox.js"></script>
<script type="text/javascript">
var currentPopup;
$(document).ready(function(){
	initialize();
	});
function initialize() {
  var haightAshbury = new google.maps.LatLng(4.532191,-75.660825);
  var mapOptions = {
    zoom: 9,
    center: haightAshbury,
	 disableDefaultUI: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  
 var map =  new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
infowindow = new google.maps.InfoWindow({
    content: ''});	  
<?  $i=0;
foreach($almacenes as $alma)
{ 
if(nvl($alma['latitud']) && nvl($alma['longitud']) )
 {	
	 ?>

var myLatLng = new google.maps.LatLng(<?=$alma['latitud']?>, <?=$alma['longitud']?>);

marker<?= $i ?> = new google.maps.Marker({
    position: myLatLng,
    map: map,
	draggable: false,
	icon: 'http://<?= DOMINIO.URLVISTA?>skin/comercio/skin/images/marker_supermarket.png'});
	
	
google.maps.event.addListener(marker<?= $i ?>, 'click', function(event) {
  imagen='<?=$alma['imagen']?>';
  iwidth='170px';
  isize=85;
  if(imagen!=''){
    imagen='<img src="<?=$dirfileout.'m'.$alma['imagen']?>" style="float:left; margin-right:5px;" width="80" />';
    iwidth='250px';
    isize=125;
  }
    
  inform='<strong><?=$alma['nombre']?></strong><br>'+imagen+'<div  style="float:left;width:150px"><?=($alma['direccion']!='') ? '<strong>Dirección:</strong><br>'.$alma['direccion'].'<br>':''?><?=($alma['telefono']!='') ? '<strong>Teléfonos:</strong><br>'.$alma['telefono']:''?></div>';

   var myOptions = {
       content: '<div style="background-color:#FFFFFF;height: 100px;margin-bottom:1px;box-shadow:#999 0px 0px 3px;border-radius:3px;padding: 8px 0 8px 8px;box-shadow: #999 0px 0px 3px;-webkit-box-shadow: #999 0px 0px 3px;-moz-box-shadow: #999 0px 0px 3px;border-radius: 3px;-moz-border-radius: 3px;-webkit-border-radius: 3px;">'+inform+'</div>'
      ,disableAutoPan: false
      ,maxWidth: 0
      ,pixelOffset: new google.maps.Size(-isize,-45)
      ,zIndex: null
      ,boxStyle: { 
       opacity: 1
       ,background: "url('system/vista/skin/comercio/skin/images/tipbox.png') no-repeat  center bottom"
        ,width: iwidth
       }
      ,closeBoxMargin: "8px"
    
      ,infoBoxClearance: new google.maps.Size(1, 1)
      ,isHidden: false
      ,pane: "floatPane"
      ,enableEventPropagation: false
      ,alignBottom:true
    };
    
    var popup = new InfoBox(myOptions);

      if (currentPopup != null) {
            currentPopup.close();
            currentPopup = null;
      }
      popup.open(map, marker<?= $i ?>);
      currentPopup = popup; 
	});
<?  
}
$i++;
}?>
  
}
</script>
</head>
<body>
<section id="Main">

<article class="iContts">
 <div id="map_canvas" style="width:100%; height:700px"></div>
<span class="clearfix"></span>
</article>
</section>
</body>
</html>
