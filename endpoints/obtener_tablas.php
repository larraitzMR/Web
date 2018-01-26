<?php 
	http_response_code(500);
	require_once $_SERVER['DOCUMENT_ROOT'].'/librerias_php/librerias.php';
	$resultado = array();
	$tabla = (isset($_GET['tabla']))?$_GET['tabla']:'corredores';
	switch ($tabla) {
		case 'corredores':
			$resultado = obtener_tabla_corredores_para_pintar();
			break;
		case 'participantes':
			$resultado = obtener_tabla_participantes_para_pintar();
			break;
		case 'tiempos':
			$resultado = obtener_tabla_tiempos_para_pintar();
			break;
		default:
			# code...
			break;
	}
	http_response_code(200);
	echo json_encode($resultado);
?>