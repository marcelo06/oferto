
var map;
var marker;
var contentString = '';
var infowindow;


function cargar_mapa(latg, longg) {
  var haightAshbury = new google.maps.LatLng(latg,longg);
  var mapOptions = {
    zoom: 14,
    center: haightAshbury,
    draggableCursor: 'pointer',
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
    map =  new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

  addMarker(haightAshbury);
  google.maps.event.addListener(map, 'click', function(event) {
    deleteMarker();
    addMarker(event.latLng);
    ventana(event.latLng);

  });


 }

function addMarker(location) {
  marker = new google.maps.Marker({
    position: location,
    map: map,
  draggable: true,
  icon: 'system/src/placepicker/images/location.png',
  title:"Zona donde se encuentra la ubicación"
  });

   google.maps.event.addListener(marker, 'click', function(event) {
      ventana(event.latLng);
  });

  google.maps.event.addListener(marker, 'dragend', function(event) {
      ventana(event.latLng);
    });
}

function deleteMarker(id) {
  if (marker) {
     marker.setMap(null);
  }
}

function ventana (location){
  if(infowindow)
  infowindow.close();
  var lati= location.lat();
  var longi= location.lng();
  contentString = 'Ubicación seleccionada';
    infowindow = new google.maps.InfoWindow({
    content: contentString
  });
  var ubicacion = lati+', '+longi;
  $('#mapa').val(ubicacion);
  infowindow.open(map,marker);
}

function localizame() {
    if(latitud != 0 && longitud != 0){
        cargar_mapa(latitud, longitud);
    }else
  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(coordenadas, errores);
  }else{
      alert('Oops! Tu navegador no soporta geolocalización. Descarga Chrome o Firefox, son gratis!');
      //latitud = <?= $x ?>;
      //longitud = <?= $y ?>;
        cargar_mapa(latitud, longitud);
  }
}

 function coordenadas(position){
       var latg = position.coords.latitude;
       var longg = position.coords.longitude;
       cargar_mapa(latg, longg);
 }

 function errores(err) {
    if (err.code == 0) {
      alert("Oops! Algo ha salido mal");
    }
    if (err.code == 1) {
      alert("Oops! No has aceptado compartir tu posición, se cargará un lugar por defecto");
      cargar_mapa(latitud, longitud);
    }
    if (err.code == 2) {
      alert("Oops! No se puede obtener la posición actual, se cargará un lugar por defecto");
      cargar_mapa(latitud, longitud);
    }
    if (err.code == 3) {
      alert("Oops! Hemos superado el tiempo de espera, se cargará un lugar por defecto");
      cargar_mapa(latitud, longitud);
    }
}

