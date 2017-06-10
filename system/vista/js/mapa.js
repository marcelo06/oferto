// JavaScript Document

var inicializado=0;
var map;
var currentPopup;
var center = null;
var bounds = new google.maps.LatLngBounds();
var markers = [];
var infowindow;

var almacenes = new Array();
var oferta;
var nzoom=15;
var current=false;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var direccitionSet=false;
var current_lat=0;
var current_long=0;

$(document).ready(function(){
    nzoom=15;
     directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true,preserveViewport:true});
    initializeMapa();
    
});

function initializeMapa() { 

    lat= 4.548821563877528;
    long=-75.66671508546278;
    center= new google.maps.LatLng(lat, long);
    inicializado=1;
    
    var mapOptions = {
        center:center,
        zoom: nzoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
           
        },
        panControl: true,
        panControlOptions: {
            
        },
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE,
            
        }
    };
    map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);
     directionsDisplay.setMap(map);

    navigator.geolocation.getCurrentPosition(setLocation,errorLocation);
    
    google.maps.event.addListener(map, 'idle', function() {
        if(map.getBounds()){
            limpiar();
            buscarPuntos();
        }
    });
   buscarPuntos();
}

function buscarPuntos(){
    if(map.getBounds()!=undefined){
        boundaries='';
        if(map.getBounds()){
            var bounds_act = map.getBounds();

            var sw = bounds_act.getSouthWest();
            var ne = bounds_act.getNorthEast();
            var s = sw.lat();
            var w = sw.lng();
            var n = ne.lat();
            var e = ne.lng();
            boundaries=s+'_'+w+'_'+n+'_'+e;

        }
        parametros= {oferta:oferta,categoria:categoria,boundaries:boundaries,current_lat:current_lat,current_long:current_long};
        $.ajax({
         type: 'POST',
         data: parametros,
         url: 'mapa-lista_ofertas',
         success: function(data){agregarPuntos(data);},
         error: function(error){console.log(error);}
     });


    }
}


function agregarPuntos(datos){
    resp= datos.rows;
    $.each(resp, function(i, row) {
        lat = row.latitud;
        long = row.longitud;
        var locat = new google.maps.LatLng(lat,long);
        addMarker(locat, row.id,row.almacen);
    });

    if(center === null){
        center = bounds.getCenter();
        map.fitBounds(bounds);
    }
    
}

function addMarker(location,id,almacen) {
    vicon=urlvista+'images/pin.png';
    bounds.extend(location);
    var marker = new google.maps.Marker({
        position: location,
        map: map,
        id: id,
        icon: vicon
    });
    markers.push(marker);
    if(markers.length==1 && direccitionSet==false && current==true){
         calcRoute(location);
         direccitionSet=true;
    }
    almacenes[id] = { 'nombre':almacen};
    
    google.maps.event.addListener(marker, "click", function (e){
        var id = marker.get("id");
        if(current==true){
          calcRoute(this.position);
        }

        parametros= {almacen:id};
        $.ajax({
         type: 'POST',
         data: parametros,
         url: 'mapa-lista_almacenes',
         success: function(data){ventanaOfertas(data,marker); },
         error: function(error){console.log(error);}
     });
    });
}

function ventanaOfertas(datos,marker){
    data=datos.rows;
    total=datos.total;
    var html='';
    var lihtml='';
    
    var id = marker.get("id");

    if(total){

     html='<div class="mapWrap" id="#cajagal"><ul class="mapCatgr"><div class="closeTop"></div><div id="owl-Map" class="owl-carousel">';

     $.each(data, function(i, row) {
       var imagen='';
       if(row.imagen!='')
         imagen='<img src="'+row.imagen+'" alt="" class="img-responsive" />';
       var porcentaje='';
       if(row.porcentaje!='')
         porcentaje='<span class="tagOff">'+row.porcentaje+'%</span>';

        var agotado='';
       if(row.agotado!='')
         agotado='<span class="tagStock"></span>';

       precio_old='';
       if(row.valor_normal>row.valor_oferta)
        precio_old='$'+number_format(row.valor_normal,0,'.','.');
      lihtml+='<li class="item"><a href="main-producto-id-'+row.id+'">'+imagen+porcentaje+agotado+'<div class="areaTitle"><h2>'+row.nombre+'</h2>\
      <h3>'+row.empresa+'</h3></div><div class="areaPromo"><div class="Vence"><span class="vt1">VENCE:</span>\
      <span class="vt2">'+row.vence+' DÍAS</span><span class="vt2"></span></div><div class="currentPrice">\
      <span class="pt1">OFERTA</span><span class="pt2">$'+number_format(row.valor_oferta,0,'.','.')+'</span>\
      <span class="pt3">'+precio_old+'</span></div></div></a></li>';
    });
     html=html+lihtml+'</div></ul></div>';
   }
   else
    html='No hay ofertas';


    var myOptions = {content: html,disableAutoPan: false,maxWidth: 0,pixelOffset: new google.maps.Size(-150,-270),zIndex: 0,
        boxStyle: {'height': '120px',padding: '0px',width: '290px'
    }
    ,closeBoxURL: urlvista+"images/xclose@2x.png"
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
    popup.open(map, marker);
    currentPopup = popup;

    google.maps.event.addListener(popup, 'domready', function() {
        $("#owl-Map").owlCarousel({autoPlay : 5000,stopOnHover : true,pagination:true,paginationSpeed : 1000,goToFirstSpeed : 2000,singleItem : true});
    });
}

function limpiar(){

    if(markers){
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
    }
}

function setLocation(posi){
  console.log(posi);
    if(posi){
        current_lat=posi.coords.latitude;
        current_long= posi.coords.longitude;
    }
    center= new google.maps.LatLng(current_lat, current_long);
    map.setCenter(center);

    var picon = new google.maps.MarkerImage(urlvista+"images/current-pin.png", null, null, null, new google.maps.Size(27,36));
    var persona = new google.maps.Marker({
        position: center,
        map: map,
        icon: picon
    });

    current=true;
}

function errorLocation(error){
    console.log(error);
}


function calcRoute(destino) {
    directionsDisplay.setDirections({routes: []});
  var start = center;
  var end = destino;
  var request = {
    origin:start,
    destination:end,
    travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(result);
    }
  });
}



function number_format (number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}
