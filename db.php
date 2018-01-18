<?php
	echo 'Esto es database';
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
		<option value="participantes">Volvo</option>
		<option value="tiempos">Saab</option>
	</select>
</div>

<div class="tablaBD">
	<table id="tabla_corredores" class="mdl-data-table mdl-js-data-table mdl-shadow--4dp">
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
</div>
<script type="text/javascript">
	$(function() {
		setInterval(function () {
			actualizarTablaCorredores();
		}, 3000);
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

	function introducirCorredores(corredores) {
		$('#tabla_corredores tbody').empty();
		var nuevaFila = '<tr><td>Prueba</td><td>Prueba</td><td>Prueba</td></tr>';
		$('#tabla_corredores > tbody:last-child').append('<tr><td>Prueba</td><td>Prueba</td><td>Prueba</td></tr>');
	}
</script>

