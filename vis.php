
<!-- Google API -->
<script src="https://www.google.com/jsapi"></script>

<!-- Libraries -->
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script> 
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<!-- Style -->
<style>
	#map {
		height: 100%;
	}
	#elevation_chart{ 
		height: 100%;
		width: 1240px;
	} 
</style>

<div class="content-grid mdl-grid">
	<!-- Div Mapa -->
	<div class="mapa_cell mdl-cell--7-col" >
		<div id="map"></div>
	</div>
	<!-- Div circulos -->
	<div class="inf_cell mdl-color--white mdl-cell--5-col ">
		<svg fill="currentColor" width="125px" height="125px" viewBox="0 0 1 1" class="inf_graf mdl-cell mdl-cell--3-col">
		  <use xlink:href="#piechart" mask="url(#piemask)" />
		  <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">82<tspan font-size="0.2" dy="-0.07">%</tspan></text>
		</svg>
		<svg fill="currentColor" width="125px" height="125px" viewBox="0 0 1 1" class="inf_graf mdl-cell mdl-cell--3-col">
		  <use xlink:href="#piechart" mask="url(#piemask)" />
		  <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">82<tspan font-size="0.2" dy="-0.07">%</tspan></text>
		</svg>
		<svg fill="currentColor" width="125px" height="125px" viewBox="0 0 1 1" class="inf_graf mdl-cell mdl-cell--3-col">
		  <use xlink:href="#piechart" mask="url(#piemask)" />
		  <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">82<tspan font-size="0.2" dy="-0.07">%</tspan></text>
		</svg>
	</div>
	<!-- Div grafico altimetria -->
	<div class="chart_cell mdl-cell--7-col" >
		<div id="elevation_chart"></div>
	</div>
</div>

<!-- Circulos de los graficos -->
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" style="position: fixed; left: -1000px; height: -1000px;">
	<defs>
	  <mask id="piemask" maskContentUnits="objectBoundingBox">
		<circle cx=0.5 cy=0.5 r=0.49 fill="white" />
		<circle cx=0.5 cy=0.5 r=0.40 fill="black" />
	  </mask>
	  <g id="piechart">
		<circle cx=0.5 cy=0.5 r=0.5 />
		<!-- Para rellenar el cacho que falta -->
		<path d="M 0.5 0.5 0.5 0 A 0.5 0.5 0 0 1 0.95 0.28 z" stroke="none" fill="rgba(255, 255, 255, 0.75)" />
	  </g>
	</defs>
</svg>

<script type="text/javascript" src="/js/mapa.js"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmJDUo5aUSwLoo-ooAKo3PO6-rHpKSFn0&callback=initMap"></script>