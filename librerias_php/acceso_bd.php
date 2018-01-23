<?php 
	//querys
	$query_seleccionar_tiempos_por_corredor = "SELECT * FROM ".$bd_nombre.".tiempos WHERE idcorredor=?";
	$query_obtener_corredores= "SELECT * FROM ".$bd_nombre.".corredores";
	$query_obtener_participantes= "SELECT * FROM ".$bd_nombre.".participantes";
	//fin querys

	//funciones
	function obtener_tiempos_corredor($_idcorredor) {
		global $MMac, $query_seleccionar_tiempos_por_corredor;
		$_parametros = array(&$_idcorredor);
		$_bindString = 'i';

		$resultado = '';
		if ($tiempos = $MMac->ejecutar_query($query_seleccionar_tiempos_por_corredor, $_bindString, $_parametros)) {
			if (sizeof($tiempos)==1) {
				$resultado=array();
				$resultado['id'] = $tiempos[0]->id;
				$resultado['idcorredor'] = $tiempos[0]->idcorredor;
				$resultado['km1'] = $tiempos[0]->km1;
				$resultado['km5'] = $tiempos[0]->km5;
				$resultado['km10'] = $tiempos[0]->km10;
			}
		}
		return $resultado;
	}

	function obtener_tabla_corredores() {
		global $MMac, $query_obtener_corredores;

		$resultado = '';
		if ($corredores = $MMac->ejecutar_query($query_obtener_corredores)) {
			if (sizeof($corredores)>0) {
				$resultado=array();
				$i=0;
				foreach ($corredores as $corredor) {
					$resultado[$i]['id'] = $corredor->id;
					$resultado[$i]['nombre'] = $corredor->nombre;
					$resultado[$i]['apellido1'] = $corredor->apellido1;
					$resultado[$i]['apellido2'] = $corredor->apellido2;
					$i++;
				}
			}
		}
		return $resultado;
	}

	function obtener_tabla_participantes() {
		global $MMac, $query_obtener_participantes;

		$resultado = '';
		if ($participantes = $MMac->ejecutar_query($query_obtener_participantes)) {
			if (sizeof($participantes)>0) {
				$resultado=array();
				$i=0;
				foreach ($participantes as $participante) {
					$resultado[$i]['idcorredor'] = $participante->idcorredor;
					$resultado[$i]['idcarrera'] = $participante->idcarrera;
					$resultado[$i]['dorsal'] = $participante->dorsal;
					$i++;
				}
			}
		}
		return $resultado;
	}
	//fin funciones
?>