<?php
/*	$corredor = 1;
	$tiempos_corredor = obtener_tiempos_corredor($corredor);
	if ($tiempos_corredor!='') {
		echo 'El tiempo del corredor en el km 5 es: '.$tiempos_corredor['km5'];
	} else {
		echo 'El corredor no tiene tiempos';
	}*/
?>


<div class="mdl-grid">
	<div class="mdl-cell mdl-cell--5-col">
		<div class="selectabla">Seleccionar tabla:
			<select id="tablas">
				<option value="corredores">corredores</option>
				<option value="participantes">participantes</option>
				<option value="tiempos">tiempos</option>
			</select>
		</div>
		<div class="tablaBD " >
			<table id="tabla_generica" class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--4dp">
				<thead>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<div class="button_info">
			<button id="boton_informacion" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
			  INFO
			</button>	
		</div>
	</div>
	<div class="mdl-cell mdl-cell--6-col">
		<div id="infopersona" style="font-size: 25px; padding-top: 20px">
		</div>
		<div class="listaConfig">
			<ul id="configuracion" class="demo-list-item mdl-list" style="display: none;"">
				<li class="mdl-list__item">
					<span class="mdl-list__item-primary-content">
						<p>Estado Bateria: </p> 
						<br>
					</span>
					<span class="mdl-list__item-primary-content">
						<p>Frecuencia envío: </p> 
						<form action="">
							<p>
							<input type="radio" name="frecEnvio" value="3"> 3 min<br>
							<input type="radio" name="frecEnvio" value="6"> 6 min<br>
							<input type="radio" name="frecEnvio" value="9"> 9 min
							</p>
						</form> 
					</span>
				</li>
			</ul>
		</div>
	</div>
</div>


<script type="text/javascript" src="/js/base_datos.js"></script>

