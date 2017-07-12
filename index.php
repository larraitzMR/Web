<!DOCTYPE html>
<html>
  <head>
    <title>MyRuns Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 90%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
	<h1><strong>Localizador gps</strong></h1>
    <div id="map"></div>
	<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script> 
	<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmJDUo5aUSwLoo-ooAKo3PO6-rHpKSFn0&callback=initMap"
    ></script>
    <script>
		var marker;
		var map;
		var coor, hora, latitud, longitud 
		
		function initMap() {
			var ubicacion = new google.maps.LatLng(43.2919385, -1.9867600999);

			map = new google.maps.Map(document.getElementById('map'), {
				center: ubicacion,
				zoom: 15
			});
			//creo el marcador con la posición, el mapa, y el icono
			marker = new google.maps.Marker({
				map: map,
				position: ubicacion,
				draggable: true,
				animation: google.maps.Animation.DROP,
				icon: getCircle(),
				title : "MyRuns Technology"
			});
			
			// marker.addListener('click', toggleBounce);
			
			// map.addListener('click', function(e) {
				// placeMarkerAndPanTo(e.latLng, map);
			// });
			
			// map.addListener('center_changed', function() {
			// // 3 seconds after the center of the map has changed, pan back to the
			// // marker.
			// window.setTimeout(function() {
				// map.panTo(marker.getPosition());
				// }, 5000);
			// });
			
			// navigator.geolocation.getCurrentPosition(function(position) {
				// var coor = mostrarCoordenadas();
				// hora = coor[0];
				// console.log(hora);
				// latitud = coor[1];
				// console.log(latitud);
				// longitud = coor[2];
				// console.log(longitud);
				// if(latitud == null)
				// {
					// latitud = 43.2919385;
				// }
				// if(longitud == null)
				// {
					// longitud = -1.9867600999;
				// }
				// var pos = {
				  // lat: latitud,
				  // lng: longitud
				// };
				// marker = new google.maps.Marker({
					// position: pos,
					// map: map,
					// draggable: true,
					// animation: google.maps.Animation.DROP,
					// icon: getCircle()
				// });
				// infoWindow.setPosition(pos);
				// map.setCenter(pos);
			// });
			setInterval(function() {
				marker.setMap(null);
				var coor = mostrarCoordenadas();
				hora = coor[0];
				console.log(hora);
				latitud = coor[1];
				console.log(latitud);
				longitud = coor[2];
				console.log(longitud);
				if(latitud == null)
				{
					latitud = 43.292029;
				}
				if(longitud == null)
				{
					longitud = -1.9867530000000215;
				}
				var ubi = new google.maps.LatLng(lat, lon);
				marker = new google.maps.Marker({
					position: ubi,
					map: map,
					draggable: true,
					// animation: google.maps.Animation.DROP,
					icon: getCircleRed()
				});
				marker.setMap(map);
			}, 5000);
		}
		
				function explode(){
		  alert("Boom!");
		}
			function myFunction(){
		setTimeout(alertFunc, 3000);
			}
		
			function alertFunc() {
				alert("Hello!");
			}
	  
		function toggleBounce() {
			if (marker.getAnimation() !== null) {
			  marker.setAnimation(null);
			} else {
			  marker.setAnimation(google.maps.Animation.BOUNCE);
			}
		}
		
		function getCircle() {
			return {
			  path: google.maps.SymbolPath.CIRCLE,
			  fillColor: 'blue',
			  fillOpacity: 10,
			  scale: 6,
			  strokeColor: 'white',
			  strokeWeight: .5
			};
		}
		
		function getCircleRed() {
			return {
			  path: google.maps.SymbolPath.CIRCLE,
			  fillColor: 'red',
			  fillOpacity: 10,
			  scale: 6,
			  strokeColor: 'white',
			  strokeWeight: .5
			};
		}
		
		var hora, lat, lon;
		function mostrarCoordenadas()
		{
		$.get("coordenadasGPS.xml", {
		// $.get("coor.xml", {
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
</html>