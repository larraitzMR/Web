
// Load the Visualization API and the columnchart package.
//google.load('visualization', '1', {packages: ['corechart']});
google.load('visualization', '1', {packages: ['columnchart']});
//google.charts.setOnLoadCallback(drawChart);	
var marker;
var map;
var coor, hora, latitud, longitud 
var latLag = 43.2919385;
var	lonLag = -1.9867600999;
var recorrido = [{lat:43.2919385, lng: -1.9867600999},{lat: 43.3258909, lng: -1.9762766999999712}];  
var route;
var distancia = 0;

var map = null;
var chart = null;
var chartDiv = null;
  
var geocoder = null;
var elevator = null;
var directionsService = null;
var directionsDisplay = null;
var distanceService = null;
var elevations= null;

var mousemarker = null;
var markers = [];
var polyline = null;

var samples = 200;

var ubicacion = {lat: 43.2919385, lng: -1.9867600999};
var destino = {lat: 43.3258909, lng: -1.9762766999999712};
var anoeta = {lat: 43.307148, lng: -1.9790868999999702};

//MAPA DE GOOGLE MAPS
function initMap() {	

	// Create a new StyledMapType object, passing it an array of styles,
    // and the name to be displayed on the map type control.
    var styledMapType = new google.maps.StyledMapType(
	[
	  {
	    "elementType": "geometry",
	    "stylers": [
	      {
	        "color": "#242f3e"
	      }
	    ]
	  },
	  {
	    "elementType": "labels.text.fill",
	    "stylers": [
	      {
	        "color": "#746855"
	      }
	    ]
	  },
	  {
	    "elementType": "labels.text.stroke",
	    "stylers": [
	      {
	        "color": "#242f3e"
	      }
	    ]
	  },
	  {
	    "featureType": "administrative.locality",
	    "elementType": "labels.text.fill",
	    "stylers": [
	      {
	        "color": "#d59563"
	      }
	    ]
	  },
	  {
	    "featureType": "poi",
	    "elementType": "labels.text.fill",
	    "stylers": [
	      {
	        "color": "#d59563"
	      }
	    ]
	  },
	  {
	    "featureType": "poi.attraction",
	    "stylers": [
	      {
	        "visibility": "off"
	      }
	    ]
	  },
	  {
	    "featureType": "poi.business",
	    "stylers": [
	      {
	        "visibility": "off"
	      }
	    ]
	  },
	  {
	    "featureType": "poi.government",
	    "stylers": [
	      {
	        "visibility": "off"
	      }
	    ]
	  },
	  {
	    "featureType": "poi.medical",
	    "stylers": [
	      {
	        "visibility": "off"
	      }
	    ]
	  },
	  {
	    "featureType": "poi.park",
	    "elementType": "geometry",
	    "stylers": [
	      {
	        "color": "#263c3f"
	      }
	    ]
	  },
	  {
	    "featureType": "poi.park",
	    "elementType": "labels.text.fill",
	    "stylers": [
	      {
	        "color": "#6b9a76"
	      }
	    ]
	  },
	  {
	    "featureType": "poi.place_of_worship",
	    "elementType": "labels",
	    "stylers": [
	      {
	        "visibility": "off"
	      }
	    ]
	  },
	  {
	    "featureType": "poi.school",
	    "stylers": [
	      {
	        "visibility": "off"
	      }
	    ]
	  },
	  {
	    "featureType": "poi.sports_complex",
	    "stylers": [
	      {
	        "visibility": "off"
	      }
	    ]
	  },
	  {
	    "featureType": "road",
	    "elementType": "geometry",
	    "stylers": [
	      {
	        "color": "#38414e"
	      }
	    ]
	  },
	  {
	    "featureType": "road",
	    "elementType": "geometry.stroke",
	    "stylers": [
	      {
	        "color": "#212a37"
	      }
	    ]
	  },
	  {
	    "featureType": "road",
	    "elementType": "labels.icon",
	    "stylers": [
	      {
	        "visibility": "off"
	      }
	    ]
	  },
	  {
	    "featureType": "road",
	    "elementType": "labels.text.fill",
	    "stylers": [
	      {
	        "color": "#9ca5b3"
	      }
	    ]
	  },
	  {
	    "featureType": "road.highway",
	    "elementType": "geometry",
	    "stylers": [
	      {
	        "color": "#746855"
	      }
	    ]
	  },
	  {
	    "featureType": "road.highway",
	    "elementType": "geometry.stroke",
	    "stylers": [
	      {
	        "color": "#1f2835"
	      }
	    ]
	  },
	  {
	    "featureType": "road.highway",
	    "elementType": "labels.text.fill",
	    "stylers": [
	      {
	        "color": "#f3d19c"
	      }
	    ]
	  },
	  {
	    "featureType": "transit",
	    "stylers": [
	      {
	        "visibility": "off"
	      }
	    ]
	  },
	  {
	    "featureType": "transit",
	    "elementType": "geometry",
	    "stylers": [
	      {
	        "color": "#2f3948"
	      }
	    ]
	  },
	  {
	    "featureType": "transit.station",
	    "elementType": "labels.text.fill",
	    "stylers": [
	      {
	        "color": "#d59563"
	      }
	    ]
	  },
	  {
	    "featureType": "water",
	    "elementType": "geometry",
	    "stylers": [
	      {
	        "color": "#17263c"
	      }
	    ]
	  },
	  {
	    "featureType": "water",
	    "elementType": "labels.text.fill",
	    "stylers": [
	      {
	        "color": "#515c6d"
	      }
	    ]
	  },
	  {
	    "featureType": "water",
	    "elementType": "labels.text.stroke",
	    "stylers": [
	      {
	        "color": "#17263c"
	      }
	    ]
	  }
	],
        {name: 'Styled Map'});

    //crear el mapa
	map = new google.maps.Map(document.getElementById('map'), {
		center: ubicacion,
		zoom: 15,
		mapTypeControlOptions: {
        mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain',
                'styled_map']
        },
		mapTypeControl: false,
		//Para los controles: zoom, street view, etc.
		zoomControl: true,
		mapTypeControl: false,
		scaleControl: false,
		streetViewControl: false,
		rotateControl: false,
		fullscreenControl: true
	});

	//Associate the styled map with the MapTypeId and set it to display.
    map.mapTypes.set('styled_map', styledMapType);
    map.setMapTypeId('styled_map');

    // Create a new chart in the elevation_chart DIV.
	chartDiv = document.getElementById('elevation_chart');
	//chart = new google.visualization.AreaChart(chartDiv);
	chart = new google.visualization.ColumnChart(chartDiv);

	//creo el marcador con la posicion, el mapa, y el icono
	marker = new google.maps.Marker({
		map: map,
		// position: ubicacion,
		draggable: false,
		animation: google.maps.Animation.DROP,
		icon: getCircle('blue'),
	});
	
	/*
	// Create a "highlighted location" marker color for when the user 
	// mouses over the marker. 
	var highlightedIcon = makeMarkerIcon('FFFF24'); 		
	// Two event listeners - one for mouseover, one for mouseout, 
	// to change the colors back and forth.
	marker.addListener('mouseover', function() {
	this.setIcon(highlightedIcon); 
    }) */
	

	//modificar punto de marcador	
	setInterval(function() {
		var i = 0;
		console.log(i);
		var coor = mostrarCoordenadas();
		hora = coor[0];
		latitud = coor[1];
		longitud = coor[2];
		//sobre todo para la primera iteracion
		//coge lat y long de partida
		if(typeof latitud === 'undefined')
		{
			latitud = latLag;
		}
		if(typeof longitud === 'undefined')
		{
			longitud = lonLag;
		}
		//guardarmos las ultimas coordenadas por si acaso
		latLag = latitud;
		lonLag = longitud;
		marker.setMap(null);
		var ubi = new google.maps.LatLng(latitud, longitud);
		console.log(latitud);
		console.log(longitud);
		marker = new google.maps.Marker({
			position: ubi,
			map: map,
			draggable: false,
			icon: getCircle('rgb(244, 246, 247)')
		});
		marker.setMap(map);
	}, 5000);
	
	elevator = new google.maps.ElevationService;

	//crear la ruta
	directionsService = new google.maps.DirectionsService;
	directionsDisplay = new google.maps.DirectionsRenderer({
		polylineOptions: {
			strokeColor: 'rgb(46, 204, 113)',
			strokeWeight: 5
		}, suppressMarkers: false
	});
	
	directionsDisplay.setMap(map);

	calculateAndDisplayRoute(directionsService, directionsDisplay);
		
	calculateDistance();

	//google.visualization.events.addListener(chart, 'onmouseover', displayPointOnMap);
    //google.visualization.events.addListener(chart, 'onmouseover', function(e) {
	// 	if (mousemarker == null) {
	// 		mousemarker = new google.maps.Marker({
	// 		  position: elevations[e.row].location,
	// 		  map: map,
	// 		  icon: "http://maps.google.com/mapfiles/ms/icons/white-dot.png"
	// 		});
	// 	} else {
	// 		mousemarker.setPosition(elevations[e.row].location);
	// 	}
	// });


}

	/* Funcion para calcular y dibujar la ruta */
function calculateAndDisplayRoute(directionsService, directionsDisplay) {

	
	var first = new google.maps.LatLng(43.29295, -1.97122 );
	var second = new google.maps.LatLng(43.285957, -1.985465);

	// Create a PathElevationRequest object using this array.
	// Ask for 256 samples along that path.
	// Initiate the path request.
	elevator.getElevationAlongPath({
	'path': recorrido,
	'samples': samples
	}, plotElevation);

	directionsService.route({
	// origin: {
	//   lat: 43.2919385,
	//   lng: -1.9867600999
	// },
	// destination: {
	//   lat:  43.3258909,
	//   lng: -1.9762766999999712
	// },
	origin: recorrido[0],
	destination: recorrido[1],
	// waypoints: [{
	//   location: anoeta,
	//   stopover: true
	// }],
	optimizeWaypoints: true,
	travelMode: 'WALKING'
	}, function(response, status) {
	if (status === 'OK') {
	  directionsDisplay.setDirections(response);
	  route = response.routes[0];
	} else {
	  window.alert('Directions request failed due to ' + status);
	}
	});
}

/* Funcion para dibujar el grafico */
function plotElevation(results) {
	elevations = results;
	
	var path = [];
    for (var i = 0; i < elevations.length; i++) {
      path.push(elevations[i].location);
    }

    // if (polyline) {
    //   polyline.setMap(null);
    // }
    
    // polyline = new google.maps.Polyline({
    //   path: path,
    //   strokeColor: "#990000",
    //   map: map});

	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Sample');
	 //dataTable.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});
	data.addColumn('number', 'Elevation');
	var j = 0;
	//for (var i = elevations.length - 1; i >= 0; i--) {
	for (var i = 0; i < results.length; i++) {
		var x = ((j*distancia)/400)/1000; 
		j++;
		//var x = (i*(distancia)/400; 
		var xaxis = Math.round(x);
		//data.addRow([xaxis.toString(), elevations[i].elevation]);
		data.addRow(['', elevations[i].elevation]);
	}

	var options = {
	  	legend: 'none',
		//titleY: 'Elevation (m)',
		// backgroundColor: {
		// 	stroke:'green'
		// },
		chartArea: {
		    backgroundColor: 'white',
		    /*width: 1050,
		    height: 200,*/
		    left: 50
		},
		colors:['green'],
		/*dataOpacity: 1.0,*/
		enableInteractivity: true,
		fontSize: 14,
		//height: 300,
		//tooltip: {isHtml: true},
		width: 1100,
		vAxis: {
			//title:'Elevation (m)'
		}
	  };

	//google.visualization.events.addListener(chart, 'select', selectHandler);
	//document.getElementById('elevation_chart').style.display = 'block';
	chart.draw(data,options);
 
}

/* Funcion para calcular las distancias entre rutas */
function calculateDistance(){

	 //Para el calculo de distancias
	var distanceService = new google.maps.DistanceMatrixService;
	distanceService.getDistanceMatrix({
		// origins: [ubicacion, destino],
		// destinations: [destino, ubicacion],
		origins: [ubicacion],
		destinations: [destino],
		travelMode: 'WALKING',
		unitSystem: google.maps.UnitSystem.METRIC,
		avoidHighways: false,
		avoidTolls: false
	}, function(response, status) {
		if (status !== 'OK') {
		  alert('Error was: ' + status);
		}
		else {
			var originList = response.originAddresses;
			var destinationList = response.destinationAddresses;
			var outputDiv = document.getElementById('output');
			//outputDiv.innerHTML = '';
			for (var i = 0; i < originList.length; i++) {
			var results = response.rows[i].elements;
				for (var j = 0; j < results.length; j++) {
			        var from = originList[i];
			        console.log(from);
			        var to = destinationList[j];
			        console.log(to);
			        var distance = results[j].distance.value;
					distancia = distancia + distance;
					console.log(distance);
					console.log(distancia);
			        var duration = results[j].duration.text;
			        console.log(duration);
			  	}
			}
		}
	  });

}

function selectHandler() {
    var selectedItem = chart.getSelection()[0];
    var value = data.getValue(selectedItem.row, 0);
    alert('The user selected ' + value);
}


/* Funciones para los marcadores */  
function displayPointOnMap(e){
	var latlong = [];
	latlong = elevations[e.row].location;
	var lat_=latlong.lat();
	var long_=latlong.lng();

	if (mousemarker == null) {
		mousemarker = new google.maps.Marker({
			position: latlong,
			map: map,
			icon: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
		});
	} else {
		mousemarker.setPosition(latlong);
	}
}

function clearMouseMarker() {
	if (mousemarker != null) {
		  mousemarker.setMap(null);
		  mousemarker = null;
	}
}

function toggleBounce() {
	if (marker.getAnimation() !== null) {
	  marker.setAnimation(null);
	} else {
	  marker.setAnimation(google.maps.Animation.BOUNCE);
	}
}

function getCircle(color) {
	return {
	  path: google.maps.SymbolPath.CIRCLE,
	  fillColor: color,
	  fillOpacity: 10,
	  scale: 6,
	  strokeColor: 'white',
	  strokeWeight: .5
	};
}

/* Funciones para las coordenadas */
var hora, lat, lon;
function mostrarCoordenadas()
{
	$.get("leerXML.php", {
	key: "value"
	 })
	.done(function (xml){
		hora = $(xml).find('Hora').last().text();
		lat = $(xml).find('Latitud').last().text();
		lon = $(xml).find('Longitud').last().text();
		console.log(hora);
		console.log(lat);
		console.log(lon);
		var todo = gradToDec(lat,lon);
		lat = todo[0];
		lon = todo[1];
	});		
	return [hora, lat, lon];
}


function gradToDec(la,lo)
{
	var latgrados = la.substr(0,2);
	latgrados = parseInt(latgrados,10);
	var latminutos = la.substr(3,2);
	latminutos = latminutos/60;
	var latsegundos = la.substr(6,4);
	latsegundos = latsegundos/3600;
	var latitudDec = latgrados+ latminutos + latsegundos;
	
	var longgrados = lo.substr(0,2);
	longgrados = parseInt(longgrados,10);
	var longminutos = lo.substr(3,2);
	longminutos = longminutos/60;
	var longsegundos = lo.substr(6,4);
	longsegundos = longsegundos/3600;
	var longitudDec = longgrados + longminutos + longsegundos;
	
	return [latitudDec,-longitudDec];
}

