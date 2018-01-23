<?php
	$corredor = 1;
	$tiempos_corredor = obtener_tiempos_corredor($corredor);
	if ($tiempos_corredor!='') {
		echo 'El tiempo del corredor en el km 5 es: '.$tiempos_corredor['km5'];
	} else {
		echo 'El corredor no tiene tiempos';
	}
?>

<div class="selectabla">Seleccionar tabla:
	<select>
		<option value="participantes">corredores</option>
		<option value="tiempos">tiempos</option>
	</select>
</div>

<div class="tablaBD">
	<table id="tabla_corredores" class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--4dp">
		<thead>
		<tr>
			<th class="mdl-data-table__cell--non-numeric">Nombre</th>
			<th class="mdl-data-table__cell--non-numeric">Primer Apellido</th>
			<th class="mdl-data-table__cell--non-numeric">Segundo Apellido</th>
		</tr>
		</thead>
		<tbody>
			<?php
				$corredores = obtener_tabla_corredores();
				if ($corredores!='' && sizeof($corredores)>0) {
					foreach ($corredores as $corredor) {
						$nuevaFila = '<tr>';
						$nuevaFila.= '<td class="mdl-data-table__cell--non-numeric">'.$corredor['nombre'].'</td>';
						$nuevaFila.= '<td class="mdl-data-table__cell--non-numeric">'.$corredor['apellido1'].'</td>';
						$nuevaFila.= '<td class="mdl-data-table__cell--non-numeric">'.$corredor['apellido2'].'</td>';
						$nuevaFila.='</tr>';
						echo $nuevaFila;
					}
				}				 
			?>
		</tbody>
	</table>
	<table id="tabla_participantes" style="display:none" class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--4dp" " >
		<thead>
		<tr>
			<th class="mdl-data-table__cell--non-numeric">idCorredor</th>
			<th class="mdl-data-table__cell--non-numeric">idCarrera</th>
			<th class="mdl-data-table__cell--non-numeric">Dorsal</th>
		</tr>
		</thead>
		<tbody>
			<?php
				$participantes = obtener_tabla_participantes();
				if ($participantes!='' && sizeof($participantes)>0) {
					foreach ($participantes as $participante) {
						$nuevaFila = '<tr>';
						$nuevaFila.= '<td class="mdl-data-table__cell--non-numeric">'.$participante['idcorredor'].'</td>';
						$nuevaFila.= '<td class="mdl-data-table__cell--non-numeric">'.$participante['idcarrera'].'</td>';
						$nuevaFila.= '<td class="mdl-data-table__cell--non-numeric">'.$participante['dorsal'].'</td>';
						$nuevaFila.='</tr>';
						echo $nuevaFila;
					}
				}				 
			?>
		</tbody>
	</table>	
</div>
<script type="text/javascript">
	$(function() {
		setInterval(function () {
			actualizarTablaCorredores();
			actualizarTablaParticipantes();
		}, 6000);
		//On change del select
		$( ".selectabla" ).change(function() {
			obtener_tabla_seleccionada();
		});
	});

	function actualizarTablaCorredores() {
		$.ajax({
			type: "GET",
			dataType: "json",
			url: "/endpoints/obtener_corredores.php"
		}).done(function(data, textStatus, jqXHR ) {
			console.log(data);
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log(jqXHR);
		});
	}
	function actualizarTablaParticipantes() {
		$.ajax({
			type: "GET",
			dataType: "json",
			url: "/endpoints/obtener_participantes.php"
		}).done(function(data, textStatus, jqXHR ) {
			console.log(data);
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log(jqXHR);
		});
	}

	function obtener_tabla_seleccionada(){

	}

	function introducirCorredores(corredores) {
		$('#tabla_corredores tbody').empty();
		var nuevaFila = '<tr><td>Prueba</td><td>Prueba</td><td>Prueba</td></tr>';
		$('#tabla_corredores > tbody:last-child').append('<tr><td>Prueba</td><td>Prueba</td><td>Prueba</td></tr>');
	}


</script>

