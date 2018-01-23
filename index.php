<!DOCTYPE html>
<html>
	<head>
		<title>MYRUNS</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
			
		<!-- Libraries -->
		<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script> 
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

		<!-- Style -->
		<link rel="stylesheet" href="styles/styles.css" />
		
		<!-- Material design lite -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<script src="./mdl/material.min.js"></script>
		<!--<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue-cyan.min.css" />-->
		<link rel="stylesheet" href="mdl/material.min.css">  
	</head>

	<?php 
		require_once "librerias_php/librerias.php";
	?>
	<body>
		<div id="div_principal" class="mdl-layout__container" >
			<!-- Simple header with scrollable tabs. -->
			<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
				<header class="mdl-layout__header ">
					<div class="mdl-layout__header-row">
						<img class="logo" src="myruns-blanco_rec.png"  />
					</div>
					<!-- Tabs -->
					<!-- Tabs <div class="mdl-layout__tab-bar-container">-->
					<div class="mdl-layout__tab-bar mdl-js-ripple-effect">
						<a href="#scroll-tab_visualization" class="mdl-layout__tab is-active">VISUALIZATION</a>
						<a href="#scroll-tab_configuration" class="mdl-layout__tab">CONFIGURATION</a>
						<a href="#scroll-tab_database" class="mdl-layout__tab">DATA BASE</a>

					</div>
					<!--</div>">-->
				</header>
				<main class="mdl-layout__content">
					<!--<?php
					/*
						$pantallaMostrar=(isset($_GET['p']))?$_GET['p']:'vis';
						if (file_exists($pantallaMostrar.'.php')) {							
							include $pantallaMostrar.'.php';
						} else {
							echo 'Recurso no disponible';
						}
						*/
					?>-->
					<!-- Paneles menu-->
					<section class="mdl-layout__tab-panel is-active" id="scroll-tab_visualization">
						<div class="page-content">
						<?php include 'vis.php'; ?>
						</div>
					</section>
					<section class="mdl-layout__tab-panel" id="scroll-tab_configuration">
						<div class="page-content">
						<?php include 'conf.php'; ?>
						</div>
					</section>
					<section class="mdl-layout__tab-panel " id="scroll-tab_database">
						<div class="page-content">
						<?php include 'db.php'; ?>
						</div>
					</section>
					<!--
					<script>
					$(function() {
						setTimeout(function () {
							$('#div_principal').css('display', 'block');
						}, 100);
					});	
					</script>
					-->
				</main>
		   </div>
	    </div>					
	</body>
</html>