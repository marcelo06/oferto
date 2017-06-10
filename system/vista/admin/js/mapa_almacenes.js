// JavaScript Document
var map;
var marker;
var zoom;

$(document).ready(function(){ 
initialize() 
});

function initialize() {

  var haightAshbury = new google.maps.LatLng(4.532191,-75.660825);
  var mapOptions = {
    zoom: zoommapa,
    center: haightAshbury,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map =  new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

  google.maps.event.addListener(map, 'click', function(event) {
    deleteMarker();
	addMarker(event.latLng);
	saveMarker(event.latLng);
	});


  
  if(longitud_ini!='' && latitud_ini!='')
{
var myLatLng = new google.maps.LatLng(latitud_ini,longitud_ini);

addMarker (myLatLng);
placeMarker(myLatLng)
	
}
  
}
  
function addMarker(location) {
	nombre=$("#nombre").val();
 
  marker = new google.maps.Marker({
    position: location,
    map: map,
	draggable: true,
	title:nombre
  });
  

	
	google.maps.event.addListener(marker, 'dragend', function(event) {
	 saveMarker(event.latLng);
});
}


// Deletes all markers in the array by removing references to them
function deleteMarker(id) {
  if (marker) {
     marker.setMap(null);    
  }
  
}



function saveMarker(location)
{
	var latitud= location.lat();
	var longitud= location.lng();
	$("#latitud").val(latitud);
	$("#longitud").val(longitud);
	$.get('http://maps.googleapis.com/maps/api/geocode/json?latlng='+latitud+','+longitud+'&language=es&sensor=false', function(datos) {
		currentData=datos.results[0].address_components;
		var ubicacion='';
		var n_ciudad='';
		var n_pais='';
		var n_dpto='';
				
		
		for(i=0;i< currentData.length; i++)
		{
			if(currentData[i].types[0]=='locality')
			{
			ubicacion+=currentData[i].long_name+', ';
			n_ciudad= currentData[i].long_name;
			
			}
			
			if(currentData[i].types[0]=='administrative_area_level_1')
			{
			ubicacion+=currentData[i].long_name+', ';
			n_dpto= currentData[i].long_name;
			
			}
			
			if(currentData[i].types[0]=='country')
			{
			ubicacion+=currentData[i].long_name;
			n_pais= currentData[i].long_name;
			isopais= currentData[i].short_name;
			
			}
		}
		$("#ubicacion").val( ubicacion);
		jQuery.ajax({
		    url:'localidad-encontrar_ids',
		    data:{pais:n_pais,isopais:isopais,dpto:n_dpto,ciudad:n_ciudad},
		    dataType:'json',
			 type: "post",
		    success:function (data) {
		     
		        $("#id_pais").val( data.idpais);
		        $("#id_dpto").val( data.iddpto);
		        $("#id_ciudad").val( data.idciudad);
		    }
		});
			
		});
		
		
}

 function placeMarker(location) {
  var clickedLocation = new google.maps.LatLng(location);
  map.setCenter(location);
}