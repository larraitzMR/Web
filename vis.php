
<!-- Google API -->
<script src="https://www.google.com/jsapi"></script>

<!-- Libraries -->
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script> 
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!-- Style -->
<style>
	#map {
		height: 60%;
	}
	#elevation_chart{ 
		height: 33%;
		border:1px solid #000;

	} 
</style>

<div class="content-grid mdl-grid">
	<!-- Div Mapa -->
	<div class="mapa_cell mdl-cell--6-col" >
		<div id="map"></div>
		<div id="elevation_chart" onmouseout="clearMouseMarker()"></div>
	</div>
	<!-- Div separadores -->
	<div id="separadorV" style="width: 15px; height: 750px; "></div>
	<div id="separadorV" style="width: 10px; height: 750px; background-color: rgb(204,204,204);"></div>
	<div id="separadorV" style="width: 5px; height: 750px; "></div>
	<!-- Div circulos -->
	<div class="inf_cell mdl-color--white mdl-cell--5-col ">
		<div id="nombreCorredor" style="height: 60px; font-size:160%; padding-top: 10px; padding-left: 20px;"> Runner:
		</div>
		<div class="graficos">
			<svg fill="currentColor" color= "#00ec85" width="180" height="180" viewBox="0 0 1 1" class="inf_graf" id="grafTiempo" style="padding-left: 40px" >
				<use xlink:href="#piechart" mask="url(#piemask)" />
				<text x="0.5" y="0.43" font-family="Roboto" font-size="0.17" fill="#666" text-anchor="middle" dy="0.1" id="grafTiempoNum">01:02:03</text>
				<text x="0.5" y="0.58" font-family="Roboto" font-size="0.09" fill="#666" text-anchor="middle" dy="0.1" id="grafTiempoLabel">Tiempo</text>
			</svg>
			<svg fill="currentColor" color= "#0079ec" width="180" height="180" viewBox="0 0 1 1" class="inf_graf" id="grafRitmo">
				<use xlink:href="#piechart" mask="url(#piemask)" />
				<text x="0.5" y="0.43" font-family="Roboto" font-size="0.17" fill="#666" text-anchor="middle" dy="0.1">3:56</text>
				<text x="0.5" y="0.58" font-family="Roboto" font-size="0.09" fill="#666" text-anchor="middle" dy="0.1">Ritmo (min/km) </text>
			</svg>
			<svg fill="currentColor" color= "#e83c3c" width="180" height="180" viewBox="0 0 1 1" class="inf_graf" id="grafDistancia">
				<use xlink:href="#piechart" mask="url(#piemask)" />
				<text x="0.5" y="0.43" font-family="Roboto" font-size="0.17" fill="#666" text-anchor="middle" dy="0.1">25,08</text>
				<text x="0.5" y="0.58" font-family="Roboto" font-size="0.09" fill="#666" text-anchor="middle" dy="0.1">Distancia (km)</text>
			</svg>
		</div>
		<div id="separadorH" style="height: 280px;"></div>
		<div class="graf_seguimiento">
			<img class="runner" src="images/runningman.png" style="height: 150px; padding-top: 10px; padding-left: 80px;" />
			<img class="flecha" src="images/flecha.png" style="height: 140px; padding-left: 20px;"/>
			<!-- <div class= container>
				<img class="flecha" src="flecha.png" style="height: 140px; padding-left: 20px;"/>
				<div class="text-block"> 
				    <p>What a beautiful sunrise</p>
				</div>
			</div> -->
			<img class="runner" src="images/runningman.png" style="height: 150px; padding-top: 10px; padding-left: 40px; " />
		</div>
	</div>
</div>

<!-- Circulos de los graficos -->
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" style="position: fixed; left: -1000px; height: -1000px;">
	<defs>
	  <mask id="piemask" maskContentUnits="objectBoundingBox">
	  	<!-- Para rellenar lo de dentro del circulo -->
		<circle cx=0.5 cy=0.5 r=0.44 fill="white" />
		<circle cx=0.5 cy=0.5 r=0.40 fill="black" />
	  </mask>
	  <g id="piechart">
		<circle cx=0.5 cy=0.5 r=0.5 />
		<!-- Para rellenar el cacho que falta -->
		<!--<path d="M 0.5 0.5 0.5 0 A 0.5 0.5 0 0 1 0.95 0.28 z" stroke="none" fill="rgba(255, 255, 255, 1)" /> -->
	  </g>
	</defs>
</svg>

<script type="text/javascript" src="/js/mapa.js"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyDmJDUo5aUSwLoo-ooAKo3PO6-rHpKSFn0&callback=initMap"></script>
