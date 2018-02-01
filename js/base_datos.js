

	$(function() {
		obtener_tabla_seleccionada('corredores');
		setInterval(function () {
			// obtenerTablaCorredores();
			// obtenerTablaParticipantes();
		}, 20000);
		//On change del select
		$( "#tablas" ).change(function() {
			var seleccionado = $(this).find("option:selected").val();
			console.log(seleccionado);
			obtener_tabla_seleccionada(seleccionado);
		});
		$("#tablas").on("click", "tr", function() {          
		    $(this).addClass('selected').siblings().removeClass('selected');    
				var value=$(this).find('td:first').html();
		    console.log(name);
		});
		$('#boton_informacion').click(function(){
			$("#tabla_generica tbody input:checked").each(function(){
				var nombre = $(this).parent().parent().parent().children(1)[1].innerText;
				var apellido1 = $(this).parent().parent().parent().children(1)[2].innerText;
				var apellido2 = $(this).parent().parent().parent().children(1)[3].innerText;

				if(apellido1 == null || apellido2 == null){
					apellido1 = "";
					apellido2 = "";
				}

				console.log(nombre + " " + apellido1 + " " + apellido2); 

				$('#infopersona').text(nombre + " " + apellido1 + " " + apellido2);
				$('#nombreCorredor').text("Runner: " + nombre + " " + apellido1 + " " + apellido2);
				$('#configuracion').show();
				$('#grafTiempoNum').text("01:02:03");
			});
		});

	});

	function obtenerTablaCorredores() {
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

	function obtenerTablaParticipantes() {
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

	function obtenerTablaTiempos() {
		$.ajax({
			type: "GET",
			dataType: "json",
			url: "/endpoints/obtener_tiempos.php"
		}).done(function(data, textStatus, jqXHR ) {
			console.log(data);
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log(jqXHR);
		});
	}


	function obtener_tabla_seleccionada(tablaSel){
		$.ajax({
			type: "GET",
			dataType: "json",
			url: "/endpoints/obtener_tablas.php?tabla=" + tablaSel
		}).done(function(data, textStatus, jqXHR ) {
			console.log(data);
			//$('#tabla_generica').empty();
			$('#tabla_generica thead tr').remove();
			$('#tabla_generica tbody tr').remove();
			//$('#tabla_generica').addClass("mdl-data-table--selectable");

			var head = '<tr>';
			if (data.length>0) {
				$.each(data[0], function (nombreColumna, valorColumna) {
					head+='<th class="mdl-data-table__cell--non-numeric">'+nombreColumna+'</th>';
				});
				head+='</tr>';
				$('#tabla_generica thead').append(head);
				var cuerpo="";
				$.each(data, function (numfila, fila) {
					cuerpo+='<tr>';
					$.each(fila, function (col, val){
						cuerpo+='<td class="mdl-data-table__cell--non-numeric">'+val+'</td>';
					});
					cuerpo+='</tr>';
				});
				$('#tabla_generica tbody').append(cuerpo);
				$('#tabla_generica').removeAttr('data-upgraded');
				//componentHandler.upgradeElement($('#tabla_generica')[0]);
				componentHandler.upgradeDom();
			} else {
				alert('No hay tuplas');
			}
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log(jqXHR);
		});
	}

	function introducirCorredores(corredores) {
		$('#tabla_corredores tbody').empty();
		var nuevaFila = '<tr><td>Prueba</td><td>Prueba</td><td>Prueba</td></tr>';
		$('#tabla_corredores > tbody:last-child').append('<tr><td>Prueba</td><td>Prueba</td><td>Prueba</td></tr>');
	}


