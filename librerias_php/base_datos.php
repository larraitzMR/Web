<?php 
	require_once $_SERVER["DOCUMENT_ROOT"]."/librerias_php/myruns.mac.i.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/librerias_php/info_base_datos.php";
	//mac = mysql abstraction class
	if (!isset($MMac) || $MMac=='') {
		$MMac = new myruns_mac();
		$MMac->conectar($bd_host, $bd_usuario, $bd_password, $bd_nombre);
	}
	require_once $_SERVER["DOCUMENT_ROOT"]."/librerias_php/acceso_bd.php";
?>
