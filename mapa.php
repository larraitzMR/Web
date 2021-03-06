<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<meta charset="utf-8">
		<title>MyRuns Map</title>
		<style>
		#contenedor_mapa {
		height: 100%;
		}
		.map {
			width: 1200px;
			height: 100%;
		}
		.grafico{
			width: 1200px; 
			height: 42%;
		}
		</style>
	</head>
	<body>
		<div id="contenedor_mapa">
			<div class="map" id="map"></div>
			<div class= "grafico" id="elevation_chart"></div>
		</div>
		<script>
		
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
				var ubicacion = {lat: 43.2919385, lng: -1.9867600999};

				map = new google.maps.Map(document.getElementById('map'), {
					center: ubicacion,
					zoom: 15,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					mapTypeControl: false
				});
				//creo el marcador con la posicion, el mapa, y el icono
				marker = new google.maps.Marker({
					map: map,
					// position: ubicacion,
					draggable: false,
					animation: google.maps.Animation.DROP,
					icon: getCircle('blue'),
				});
				
				<!-- // Create a "highlighted location" marker color for when the user -->
				<!-- // mouses over the marker. -->
				<!-- var highlightedIcon = makeMarkerIcon('FFFF24'); -->
				
				<!-- // Two event listeners - one for mouseover, one for mouseout, -->
				<!-- // to change the colors back and forth. -->
				<!-- marker.addListener('mouseover', function() { -->
				<!-- this.setIcon(highlightedIcon); -->
			  <!-- }) -->
				
				var directionsService = new google.maps.DirectionsService;
				var directionsDisplay = new google.maps.DirectionsRenderer({
					polylineOptions: {
						strokeColor: "blue",
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
					} else {
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

			  // Draw the chart using the data within its DIV.
			  chart.draw(data, {
				legend: 'none',
				titleY: 'Elevation (m)'
			  });
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


		</script>
	</body>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmJDUo5aUSwLoo-ooAKo3PO6-rHpKSFn0&callback=initMap"></script>
</html>