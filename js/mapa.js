
	// Load the Visualization API and the columnchart package.
	google.load('visualization', '1', {packages: ['corechart']});
	google.charts.setOnLoadCallback(drawChart);	
	var marker;
	var map;
	var coor, hora, latitud, longitud 
	var latLag = 43.2919385;
	var	lonLag = -1.9867600999;
	var path;
	var route;
	var distancia;
	
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
		        "color": "#212121"
		      }
		    ]
		  },
		  {
		    "elementType": "labels.icon",
		    "stylers": [
		      {
		        "visibility": "off"
		      }
		    ]
		  },
		  {
		    "elementType": "labels.text.fill",
		    "stylers": [
		      {
		        "color": "#757575"
		      }
		    ]
		  },
		  {
		    "elementType": "labels.text.stroke",
		    "stylers": [
		      {
		        "color": "#212121"
		      }
		    ]
		  },
		  {
		    "featureType": "administrative",
		    "elementType": "geometry",
		    "stylers": [
		      {
		        "color": "#757575"
		      },
		      {
		        "visibility": "off"
		      }
		    ]
		  },
		  {
		    "featureType": "administrative.country",
		    "elementType": "labels.text.fill",
		    "stylers": [
		      {
		        "color": "#9e9e9e"
		      }
		    ]
		  },
		  {
		    "featureType": "administrative.land_parcel",
		    "stylers": [
		      {
		        "visibility": "off"
		      }
		    ]
		  },
		  {
		    "featureType": "administrative.locality",
		    "elementType": "labels.text.fill",
		    "stylers": [
		      {
		        "color": "#bdbdbd"
		      }
		    ]
		  },
		  {
		    "featureType": "poi",
		    "stylers": [
		      {
		        "visibility": "off"
		      }
		    ]
		  },
		  {
		    "featureType": "poi",
		    "elementType": "labels.text.fill",
		    "stylers": [
		      {
		        "color": "#757575"
		      }
		    ]
		  },
		  {
		    "featureType": "poi.park",
		    "elementType": "geometry",
		    "stylers": [
		      {
		        "color": "#181818"
		      }
		    ]
		  },
		  {
		    "featureType": "poi.park",
		    "elementType": "labels.text.fill",
		    "stylers": [
		      {
		        "color": "#616161"
		      }
		    ]
		  },
		  {
		    "featureType": "poi.park",
		    "elementType": "labels.text.stroke",
		    "stylers": [
		      {
		        "color": "#1b1b1b"
		      }
		    ]
		  },
		  {
		    "featureType": "road",
		    "elementType": "geometry.fill",
		    "stylers": [
		      {
		        "color": "#2c2c2c"
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
		        "color": "#8a8a8a"
		      }
		    ]
		  },
		  {
		    "featureType": "road.arterial",
		    "elementType": "geometry",
		    "stylers": [
		      {
		        "color": "#373737"
		      }
		    ]
		  },
		  {
		    "featureType": "road.highway",
		    "elementType": "geometry",
		    "stylers": [
		      {
		        "color": "#3c3c3c"
		      }
		    ]
		  },
		  {
		    "featureType": "road.highway.controlled_access",
		    "elementType": "geometry",
		    "stylers": [
		      {
		        "color": "#4e4e4e"
		      }
		    ]
		  },
		  {
		    "featureType": "road.local",
		    "elementType": "labels.text.fill",
		    "stylers": [
		      {
		        "color": "#616161"
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
		    "elementType": "labels.text.fill",
		    "stylers": [
		      {
		        "color": "#757575"
		      }
		    ]
		  },
		  {
		    "featureType": "water",
		    "elementType": "geometry",
		    "stylers": [
		      {
		        "color": "#000000"
		      }
		    ]
		  },
		  {
		    "featureType": "water",
		    "elementType": "labels.text.fill",
		    "stylers": [
		      {
		        "color": "#3d3d3d"
		      }
		    ]
		  }
		],
            {name: 'Styled Map'});
		var ubicacion = {lat: 43.2919385, lng: -1.9867600999};

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
		
		var directionsService = new google.maps.DirectionsService;
		var directionsDisplay = new google.maps.DirectionsRenderer({
			polylineOptions: {
				strokeColor: "orange",
				strokeWeight: 5
			}, suppressMarkers: false
		});
		
		directionsDisplay.setMap(map);

		calculateAndDisplayRoute(directionsService, directionsDisplay);
				
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
				icon: getCircle('red')
			});
			marker.setMap(map);
		}, 5000);
		
		  var geocoder = new google.maps.Geocoder;

		  var service = new google.maps.DistanceMatrixService;
		  service.getDistanceMatrix({
			origins: [ubicacion],
			destinations: [{lat: 43.285957, lng: -1.985465}],
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

			  var results = response.rows[0].elements;
			  //outputDiv.innerHTML = results[0].distance.text;
			  distancia = results[0].distance.value;
			  //outputDiv.innerHTML = distancia;

			}
		  });
	}
	
	//RUTA
	function calculateAndDisplayRoute(directionsService, directionsDisplay) {
	
		path = [{lat: 43.29295, lng: -1.9712},{lat: 43.285957, lng: -1.985465}];  
		var first = new google.maps.LatLng(43.29295, -1.97122 );
		var second = new google.maps.LatLng(43.285957, -1.985465);

		directionsService.route({
		origin: {
		  lat: 43.2919385,
		  lng: -1.9867600999
		},
		destination: {
		  lat: 43.28735,
		  lng: -1.98558
		},
		waypoints: [{
		  location: path[0],
		  stopover: true
		}, {
		  location: path[1],
		  stopover: false
		}],
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
		
		// Create an ElevationService.
		var elevator = new google.maps.ElevationService;

		// Create a PathElevationRequest object using this array.
		// Ask for 256 samples along that path.
		// Initiate the path request.
		elevator.getElevationAlongPath({
		'path': path,
		'samples': 400
		}, plotElevation);
	}
	
	// Takes an array of ElevationResult objects, draws the path on the map
	// and plots the elevation profile on a Visualization API ColumnChart.
	function plotElevation(elevations, status) {
	  var chartDiv = document.getElementById('elevation_chart');
	  if (status !== 'OK') {
		// Show the error code inside the chartDiv.
		chartDiv.innerHTML = 'Cannot show elevation: request failed because ' +
		  status;
		return;
	  }
	  // Create a new chart in the elevation_chart DIV.
	  var chart = new google.visualization.AreaChart(chartDiv);

	  // Extract the data from which to populate the chart.
	  // Because the samples are equidistant, the 'Sample'
	  // column here does double duty as distance along the
	  // X axis.
	  var data = new google.visualization.DataTable();
	  data.addColumn('string', 'Sample');
	  data.addColumn('number', 'Elevation');
	  for (var i = 0; i < elevations.length; i++) {
		var x = (i*distancia)/400; 
		//var x = (i*(distancia)/400; 
		var xaxis = Math.round(x);
		data.addRow([xaxis.toString(), elevations[i].elevation]);
	  }

	  var options = {
	  	legend: 'none',
		//titleY: 'Elevation (m)',
		backgroundColor: {
			stroke:'blue'
		},
		chartArea: {
		    backgroundColor: 'white',
		    /*width: 1050,
		    height: 200,*/
		    left: 50
		},
		colors:['black','#004411'],
		/*dataOpacity: 1.0,*/
		enableInteractivity: true,
		fontSize: 14,
		vAxis: {
			//title:'Elevation (m)'
		}
	  };

	  // Draw the chart using the data within its DIV.
	  chart.draw(data,options);
	 
	}
	
	// This function takes in a COLOR, and then creates a new marker
    // icon of that color. The icon will be 21 px wide by 34 high, have an origin
    // of 0, 0 and be anchored at 10, 34).
	function makeMarkerIcon(markerColor) {
		var markerImage = new google.maps.MarkerImage(
		  'http://chart.googleapis.com/chart?chst=d_map_spin&chld=1.15|0|'+ markerColor +
		  '|40|_|%E2%80%A2',
		  new google.maps.Size(21, 34),
		  new google.maps.Point(0, 0),
		  new google.maps.Point(10, 34),
		  new google.maps.Size(21,34));
		return markerImage;
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
	
	//Funciones para las coordenadas
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

