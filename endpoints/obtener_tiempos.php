<?php 
	http_response_code(500);
	require_once $_SERVER['DOCUMENT_ROOT'].'/librerias_php/librerias.php';
	$participantes = obtener_tabla_tiempos();
	http_response_code(200);
	echo json_encode($participantes);
?>