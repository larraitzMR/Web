<?php 
	//querys
	$query_seleccionar_tiempos_por_corredor = "SELECT * FROM ".$bd_nombre.".tiempos WHERE idcorredor=?";
	$query_obtener_corredores= "SELECT * FROM ".$bd_nombre.".corredores";
	$query_obtener_corredores_para_pintar = "SELECT nombre as Nombre, apellido1 as 'Primer Apellido', apellido2 as 'Segundo Apellido' FROM ".$bd_nombre.".corredores";
	$query_obtener_participantes= "SELECT * FROM ".$bd_nombre.".participantes";
	$query_obtener_participantes_para_pintar= "SELECT * FROM ".$bd_nombre.".participantes";
	$query_obtener_tiempos= "SELECT * FROM ".$bd_nombre.".tiempos";
	$query_obtener_tiempos_para_pintar= "SELECT idcorredor as ID, km1 as 'Tiempo km1', km5 as 'Tiempo km5', km10 as 'Tiempo km10', FROM ".$bd_nombre.".tiempos";
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

	function obtener_tabla_corredores_para_pintar() {
		global $MMac, $query_obtener_corredores_para_pintar;

		$resultado = '';
		if ($corredores = $MMac->ejecutar_query($query_obtener_corredores_para_pintar)) {
			if (sizeof($corredores)>0) {
				$resultado=array();
				$i=0;
				foreach ($corredores as $fila) {
					foreach ($fila as $nombreColumna => $valorColumna) {
						$resultado[$i][$nombreColumna] = $valorColumna;
					}
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

	function obtener_tabla_participantes_para_pintar() {
		global $MMac, $query_obtener_participantes_para_pintar;

		$resultado = '';
		if ($corredores = $MMac->ejecutar_query($query_obtener_participantes_para_pintar)) {
			if (sizeof($corredores)>0) {
				$resultado=array();
				$i=0;
				foreach ($corredores as $fila) {
					foreach ($fila as $nombreColumna => $valorColumna) {
						$resultado[$i][$nombreColumna] = $valorColumna;
					}
					$i++;
				}
			}
		}
		return $resultado;
	}

	function obtener_tabla_tiempos() {
		global $MMac, $query_obtener_tiempos;

		$resultado = '';
		if ($tiempos = $MMac->ejecutar_query($query_obtener_tiempos)) {
			if (sizeof($tiempos)>0) {
				$resultado=array();
				$i=0;
				foreach ($tiempos as $tiempo) {
					$resultado[$i]['id'] = $tiempo->id;
					$resultado[$i]['idcorredor'] = $tiempo->idcorredor;
					$resultado[$i]['km1'] = $tiempo->km1;
					$resultado[$i]['km5'] = $tiempo->km5;
					$resultado[$i]['km10'] = $tiempo->km10;
					$i++;
				}
			}
		}
		return $resultado;
	}

	function obtener_tabla_tiempos_para_pintar() {
		global $MMac, $query_obtener_tiempos;

		$resultado = '';
		if ($corredores = $MMac->ejecutar_query($query_obtener_tiempos)) {
			if (sizeof($corredores)>0) {
				$resultado=array();
				$i=0;
				foreach ($corredores as $fila) {
					foreach ($fila as $nombreColumna => $valorColumna) {
						$resultado[$i][$nombreColumna] = $valorColumna;
					}
					$i++;
				}
			}
		}
		return $resultado;
	}
	//fin funciones
?>