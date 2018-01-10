<!DOCTYPE HTML>
<html>
<head>
<script>


		
		//GRAFICO 
		window.onload = function () {

		var dps = []; // dataPoints
		var chart = new CanvasJS.Chart("chartContainer", {
			axisY: {
				includeZero: false
			},      
			data: [{
				type: "line",
				dataPoints: dps
			}]
		});

		var xVal = 0;
		var yVal = 100; 
		var updateInterval = 1000;
		var dataLength = 20; // number of dataPoints visible at any point

		var updateChart = function (count) {

			count = count || 1;

			for (var j = 0; j < count; j++) {
				yVal = yVal +  Math.round(5 + Math.random() *(-5-5));
				dps.push({
					x: xVal,
					y: 0
				});
				xVal++;
			}

			if (dps.length > dataLength) {
				dps.shift();
			}

			chart.render();
		};

		updateChart(dataLength);
		setInterval(function(){updateChart()}, updateInterval);

		}

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width:100%; background-image: C:\Users\Propietario\Documents\GitHub\Web;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>