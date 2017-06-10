// JavaScript Document
var map;
var marker;
var zoom;

$(document).ready(function(){ 
initialize() 
});

function initialize() {

  var haightAshbury = new google.maps.LatLng(5.266007882805498,-73.828125);
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
 
  marker = new google.maps.Marker({
    position: location,
    map: map,
	draggable: true
  });
  
  google.maps.event.addListener(marker, 'click', function(event) {
   ventana(event.latLng);
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
		
}

 function placeMarker(location) {
  var clickedLocation = new google.maps.LatLng(location);
  map.setCenter(location);
}