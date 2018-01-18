<?php

/**
 * MyRuns MySQL Abstraction Class
 *
 * Librería que define la capa de abstracción de acceso a BD a través de MySql
 *
 */

define("T_TXT",1);
define("T_NUM",2);
define("T_HTM",3);

class myruns_mac{

	/**
	 * Variable privada que guarda la conexión a la BD
	 */
    private $conexion = '';
	/**
	 * Variable privada que determina si está activa la conexión a la BD
	 */
    private $conexion_activa = false;
    /**
     * Variable privada para guardar el prepared statement
     */
    private $statement=null;
	/**
	 * Variable privada que guarda el número de querys ejecutadas por el objeto
	 */
	private $num_querys = 0;
	/**
	 * Variable privada que guarda el número de aciertos desde caché
	 */
	private $num_aciertos_cache = 0;
	/**
	 * Variable privada que mantiene la caché
	 */
	private $datos_cache=array();
	/**
	 * Variable privada que indica si la caché está activada para esta consulta o no
	 */
	private $cache_activada=false;
	/**
	 * Variable privada que guarda el id (hash) de caché de una query
	 */
	private $_id_cache;
	/**
	 * Variable privada que guarda el tiempo total de ejecución del objeto
	 */
    private $tiempo_total = 0;
 	/**
	 * Variable privada que guarda el último código de error
	 */
	private $codigo_error = 0;
	/**
	 * Variable privada que guarda el último mensaje de error
	 */
    public $mensaje_error = '';
	/**
	 * Variable privada que guarda el resultset (objeto mysqli_result) de la última query ejecutada
	 */
    private $resultset = '';
	/**
	 * Variable privada que guarda el código SQL de la última consulta ejecutada
	 * (se utiliza para poder escribir en el log y debugear las querys)
	 */
    private $ultimo_sql = '';
	/**
	 * Variable que guarda los datos parseados
	 */
	private $datos = null;
	
	/**
	*  Constructor de la clase
	*/
	function __construct(){

	}

	/**
	 * Constructor de la clase
	 *
	 * Crea e inicializa la conexión a la base de datos
	 *
	 * @param string $host nombre del host/servidor de bd
	 * @param string $usuario nombre de usuario para conectar con la bd
	 * @param string $clave clave del usuario
	 * @param string $bd nombre de la base de datos a la que se quiere conectar
	 * @return bool este constructor devuelve true si el objeto está conectado y listo para usarse
	 */
	function conectar($host, $usuario, $clave, $bd){
        $tiempo_inicio = $this->get_microtime();
		// intentar conectar al servidor
		@$this->conexion = new mysqli($host,$usuario,$clave,$bd);

		if ($this->conexion->connect_error){
            $this->codigo_error = $this->conexion->connect_errno;
            $this->mensaje_error  = $this->conexion->connect_error;
			$this->conexion_activa = false;
            return false;
        }

		//mysql_set_charset solo está disponible con PHP >= 5.2.3 y MySQL >= 5.0.7
		if(!$this->conexion->set_charset('utf8')){
			$this->conexion->query("SET NAMES utf8");
		}

        $this->tiempo_total += $this->get_microtime() - $tiempo_inicio;
		$this->conexion_activa = true;
		return true;
    }


    function ejecutar_query($sql, $bindString='', $params=null) {
    	if ($bindString=='' || $params==null) {
    		return $this->ejecutar_query_no_bind($sql);
    	} else {
    		$this->datos=null;
    		if ($this->conexion_activa) {
	    		//Generar el string sql que se va a realizar
	    		$this->generar_string_ultimo_sql($sql, $params);
	    		++$this->num_querys;

	    		$tiempo_inicio = $this->get_microtime();
	    		$this->statement = $this->conexion->prepare($sql);
	    		call_user_func_array(array($this->statement, "bind_param"), array_merge(array($bindString), $params));
	    		if ($this->statement->execute()) {
					$this->resultset = $this->statement->get_result();
					if($this->conexion->connect_error){
						$this->codigo_error = $this->conexion->connect_errno;
						$this->mensaje_error  = $this->conexion->connect_error;
						$this->tiempo_total += $this->get_microtime() - $tiempo_inicio;
						return false;
					}
	    		} else {
	    			return false;
	    		}
				$this->tiempo_total += $this->get_microtime() - $tiempo_inicio;
				$_resfinal=$this->cargar_resultado();
				//se devuelve por conveniencia, aunque también se guarda en $this->resultset
		        return $_resfinal;	
    		}

    	}
    }

    private function str_first_replace($buscar, $sustituta, $fuente) {
    	return ($pos=strpos($fuente, $buscar))!==FALSE?substr_replace($fuente, $sustituta, $pos, strlen($buscar)):$fuente;
	}

    private function generar_string_ultimo_sql($sql, $params) {
    	for ($i=1; $i<=sizeof($params); $i++) {
    		$nuevoParametro="'#".$i."#'";
    		$sql = $this->str_first_replace('?', $nuevoParametro, $sql);
    	}

    	for($i=0;$i<sizeof($params);$i++){
			//Cuando el parámetro es un array significa que deseamos un tratamiento especial para el dato
			//por tanto, miramos cual es el trato deseado y cargamos el parámetro de la forma deseada
			if(is_array($params[$i])){
				$params[$i][1]=$this->conexion->real_escape_string($params[$i][1]);
				if($params[$i][0]==T_TXT)
					$sql=cargar_parametro($sql,'#'.($i+1).'#',$params[$i][1]);
				if($params[$i][0]==T_NUM)
					$sql=cargar_parametro_numero($sql,'#'.($i+1).'#',$params[$i][1]);
				if($params[$i][0]==T_HTM)
					$sql=cargar_parametro_contenido($sql,'#'.($i+1).'#',$params[$i][1]);
			}else{
				$params[$i]=$this->conexion->real_escape_string($params[$i]);
				$sql=cargar_parametro($sql,'#'.($i+1).'#',$params[$i]);
			}
		}

		$this->ultimo_sql=$sql;
    }

	/**
	 * Función de ejecución de una query
	 *
	 * Ejecuta una query y devuelve su resultset
	 *
	 * @param string $sql query que se desea ejecutar
	 * @param array $params (opcional) array unidimensional que contiene los valores a cargar sobre la query
	 *		Si se pasa un array del tipo ['valor'][$i] con los valores y ['placeholder'][$i] para la clave del array asociativo
	 * @param bool $cache (opcional) parámetro que activa la caché para la consulta enviada
	 * @return resutlSet devuelve el resultado de ejecutar la query en formato resultset
	 */
	private function ejecutar_query_no_bind($sql,$params=null,$_cache=false){
		$this->cache_activada=$_cache;
		$this->datos=null;
		if($this->conexion_activa){
			if(sizeof($params)>0){
				//Comprobamos si el array que ha llegado tiene los nombres de los parámetros o van por número
				if (!isset($params['placeholders'])) {	// no hay nombres de etiquetas
					for($i=0;$i<sizeof($params);$i++){
						//Cuando el parámetro es un array significa que deseamos un tratamiento especial para el dato
						//por tanto, miramos cual es el trato deseado y cargamos el parámetro de la forma deseada
						if(is_array($params[$i])){
							$params[$i][1]=$this->conexion->real_escape_string($params[$i][1]);
							if($params[$i][0]==T_TXT)
								$sql=cargar_parametro($sql,'#'.($i+1).'#',$params[$i][1]);
							if($params[$i][0]==T_NUM)
								$sql=cargar_parametro_numero($sql,'#'.($i+1).'#',$params[$i][1]);
							if($params[$i][0]==T_HTM)
								$sql=cargar_parametro_contenido($sql,'#'.($i+1).'#',$params[$i][1]);
						}else{
							$params[$i]=$this->conexion->real_escape_string($params[$i]);
							$sql=cargar_parametro($sql,'#'.($i+1).'#',$params[$i]);
						}
					}
				} else {	// hay nombres de etiquetas
					for($i=0;$i<sizeof($params['valores']);$i++){
						//Cuando el parámetro es un array significa que deseamos un tratamiento especial para el dato
						//por tanto, miramos cual es el trato deseado y cargamos el parámetro de la forma deseada
						if(is_array($params['valores'][$i])){
							$params['valores'][$i][1]=$this->conexion->real_escape_string($params['valores'][$i][1]);
							if($params['valores'][$i][0]==T_TXT)
								$sql=cargar_parametro($sql,'#'.$params['placeholders'][$i].'#',$params['valores'][$i][1]);
							if($params['valores'][$i][0]==T_NUM)
								$sql=cargar_parametro_numero($sql,'#'.$params['placeholders'][$i].'#',$params['valores'][$i][1]);
							if($params['valores'][$i][0]==T_HTM)
								$sql=cargar_parametro_contenido($sql,'#'.$params['placeholders'][$i].'#',$params['valores'][$i][1]);
						}else{
							$params['valores'][$i]=$this->conexion->real_escape_string($params['valores'][$i]);
							$sql=cargar_parametro($sql,'#'.$params['placeholders'][$i].'#',$params['valores'][$i]);
						}
					}
				}
			}
			$this->ultimo_sql=$sql;
			
			++$this->num_querys;
			$this->_id_cache=md5($sql);
			if($_cache && isset($this->datos_cache[$this->_id_cache])){ //estamos en un acierto de caché
				++$this->num_aciertos_cache;
				$myFile = "prueba.txt";
				return $this->datos_cache[$this->_id_cache];
			}
			//no es un acierto de caché
			$tiempo_inicio = $this->get_microtime();
			$this->resultset = $this->conexion->query($sql);
			if($this->conexion->connect_error){
				$this->codigo_error = $this->conexion->connect_errno;
				$this->mensaje_error  = $this->conexion->connect_error;
				$this->tiempo_total += $this->get_microtime() - $tiempo_inicio;
				return false;
			}
			$this->tiempo_total += $this->get_microtime() - $tiempo_inicio;
			$_resfinal=$this->cargar_resultado();
			if($_cache)$this->datos_cache[$this->_id_cache]=$_resfinal;
			//se devuelve por conveniencia, aunque también se guarda en $this->resultset
	        return $_resfinal;
		}
    }

	/**
	 * Función de consulta del estado de la conexión
	 *
	 * @return bool devuelve el estado de la conexión
	 */
	function conexion_activa(){
        return $this->conexion_activa;
    }

	/**
	 * Función de consulta de número de tuplas afectadas
	 *
	 * @return int devuelve el número de tuplas afectadas en la última operación
	 */
	function num_tuplas_afectadas(){
        return $this->conexion->affected_rows;
    }

	/**
	 * Función de consulta de número de tuplas recuperadas
	 *
	 * @return int devuelve el número de tuplas recuperadas en la última operación
	 */
    function num_tuplas_seleccionadas(){
        return $this->resultset->num_rows;
    }

	/**
	 * Función de consulta del identificador asignado a la última tupla insertada	#### SUPONGO QUE ES SOLO PARA CASOS DE AUTOINCREMENT, NO? ####
	 *
	 * @return int devuelve el identificador asignado a la última tupla insertada
	 */
    function ultimo_id(){
        return $this->conexion->insert_id;
    }

	/**
	 * Función de carga del resultado de una query en un array asociativo
	 *
	 * @return array devuelve una matriz asociativa con los resultados de la última consulta ejecutada
	 */
    function cargar_resultado(){
		if($this->cache_activada && isset($this->datos_cache[$this->_id_cache])){
			return $this->datos_cache[$this->_id_cache];
		}else{
			if(is_object($this->resultset)){// && $this->resultset->num_rows){
				if($this->datos!=null)return $this->datos;
				$array = array();
				while ($fila = $this->resultset->fetch_object()) {
					$array[] = $fila;
				}
				$this->datos=$array;
				if($this->cache_activada)$this->datos_cache[$this->_id_cache]=$array;
				return $array;
			}
			return false;
		}
    }

	/**
	 * Función para recuperar la lista de campos devueltos por la consulta (cabeceras)
	 *
	 * @return array devuelve una matriz unidimensional con los nombres de los campos
	 */
    function get_campos(){
    	if($this->datos){
    		$array_objetos = $this->datos;
    		foreach ($array_objetos[0] as $key => $value) {
   				$campos[] = $key;
			}
    	}
    	/*
		if($this->resultset){
			while ($campos[]=$this->resultset->fetch_field()){
			}
		}*/
		return $campos;
	}

	/**
	 * Función para recuperar el código de error de la última operación
	 *
	 * @return string devuelve el código de error de la última operación
	 */
    function get_codigo_error(){
        return $this->codigo_error;
    }

	/**
	 * Función para recuperar el código de error de la última operación
	 *
	 * @return string devuelve el mensaje de error de la última operación
	 */
    function get_mensaje_error(){
        return $this->mensaje_error;
    }

	/**
	 * Función para recuperar el tiempo total de ejecución del objeto
	 *
	 * @return string devuelve el tiempo total de ejecución del objeto
	 */
    function get_tiempo_total(){
        return round($this->tiempo_total,6);
    }

	/**
	 * Función para recuperar el número de querys ejecutadas por el objeto
	 *
	 * @return string devuelve el número de querys ejecutadas por el objeto
	 */
    function get_num_querys(){
        return $this->num_querys;
    }

	/**
	 * Función para recuperar el número de aciertos en caché
	 *
	 * @return string devuelve el número de aciertos en caché
	 */
    function get_num_aciertos_cache(){
        return $this->num_aciertos_cache;
    }

	/**
	 * Función para recuperar el tamaño de la caché
	 *
	 * @return string devuelve el tamaño de la caché
	 */
    function get_tam_cache(){
        return sizeof($this->datos_cache);
    }
	
	/**
	 * Función para recuperar el tamaño en Bytes de la caché
	 * (cuenta el número de caracteres de la caché serializada y lo multiplica por dos: utf-8)
	 *
	 * @return string devuelve el tamaño en Bytes de la caché
	 */
	function get_bytes_tam_cache() {
		return (2*strlen(serialize($this->datos_cache)));
	}

	/**
	 * Función de uso interno para recuperar el milisegundo actual
	 *
	 * @return float devuelve el milisegundo actual
	 */
	function get_microtime() {
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}

	/**
	 * Función para escribir en el log la consulta actual
	 *
	 * ejemplo de uso: $myruns_mac->logear_consulta(myruns_debug::get_instance());
	 *
	 * @param myruns_debug $debug instancia a la clase de debug en la que se quiera escribir
	 * @return void
	 */
	function logear_consulta($debug){
		$debug->debug($this->ultimo_sql);
	}


	/**
	 * Función para devolver el resultado de la consulta en formato tabla HTML
	 *
	 * @return string, el codigo html(tabla) con los datos de la ultima consulta realizada
	 */
	function tabla_html(){
		if ($this->cargar_resultado()==null) $tabla = '<table border=1>Vacio</table>';
		else {
			$res=$this->datos;
			$tabla='<table border=1><tr>';
			$campos=$this->get_campos();
			foreach($campos as $c){
				$tabla .= '<th><b>'.$c.'</b></th>';
			}
			foreach($res as $r){
				$tabla .= '</tr><tr>';
				foreach($campos as $c){
					$tabla .= '<td align="left" valign="top">'.$r->$c.'</td>';
				}
				$tabla .= '</tr>';
			}
			$tabla .= '</table>';
		}
		return $tabla;
	}

	/**
	 * Función para devolver la query de la última SQL
	 *
	 * @return string, la última SQL
	 */
	function get_ultimo_sql(){
		return $this->ultimo_sql;
	}

	/**
	 * Función que hace mysql_real_escape_string
	 *
	 */
	 function mysql_real_escape_string($param){
		return $this->conexion->real_escape_string($param);
	 }

	/**
	 * Función que devuelve el tipo de mysql que se ha cargado
	 *
	 */
	 function tipo_controlador(){
		return "myruns.mac.i";
	 }

}



/*
 +--------------------+-------------------------------------------------------------------+
 |           FUNCION: | limpiar_mucho(<cadena de texto>)                                  |
 +--------------------+-------------------------------------------------------------------+
 |              Info: | Limpia agresivamente un string. Util para parámetros cortos GET.  |
 |           Entrada: | Texto que se quiere limpiar.                                      |
 |            Salida: | String con solo letras, números, y guión bajo.                    |
 +--------------------+-------------------------------------------------------------------+
*/

//función para limpiar agresivamente un string
function limpiar_mucho($cadena){
	return preg_replace("#[^a-zA-Z0-9_-]+#", "", $cadena);
	//para booleano:
	//return ereg("^[a-zA-Z0-9]+[a-zA-Z0-9_]",$cadena);
}

/**
 * Función genérica para limpiar agresivamente un número. Solo permite números, nada más
 *
 * Se suele utilizar para limpiar parámetros GET de paginación, para evitar inyección de código
 *
 * @param string $cadena texto que se quiere limpiar
 * @return string devuelve el string conteniendo solo números
 */
function limpiar_numero($cadena){
	return preg_replace("#[^0-9-]+#", "", $cadena);
}

/*
 +--------------------+-------------------------------------------------------------------+
 |           FUNCION: | limpiar(<cadena de texto>)                                        |
 +--------------------+-------------------------------------------------------------------+
 |              Info: | Limpia levemente un string. Util para muchos datos por POST.      |
 |           Entrada: | Texto que se quiere limpiar.                                      |
 |            Salida: | String donde se ha sustituido '<' por '[' y '>' por ']', además   |
 |                    | de sustituir todo tipo de comillas por '·'. También se aplica una |
 |                    | llamada a Strip Tags.                                             |
 +--------------------+-------------------------------------------------------------------+
*/

//función para limpiar levemente un string
function limpiar($cadena){
	global $MMac;
	$cadena=preg_replace("#<#","[",$cadena);
	$cadena=preg_replace("#>#","]",$cadena);
	$cadena=preg_replace("#'#",'·',$cadena);
	$cadena=preg_replace('#"#','·',$cadena);
	return strip_tags($MMac->mysql_real_escape_string($cadena));
}

/*
+--------------------+-----------------------------------------------------------------------+
|           FUNCION: | cargar_parametro()                                                    |
+--------------------+-----------------------------------------------------------------------+
|              Info: | Carga el valor de un parámetro en una query con parámetros relativos. |
|           Entrada: | La sentencia, el nombre del parámetro en la query, y el valor nuevo.  |
|            Salida: | Devuelve la query con el parámetro correctamente mapeado.             |
+--------------------+-----------------------------------------------------------------------+
*/
function cargar_parametro($sentencia,$param,$valor){
	return preg_replace("*".$param."*",limpiar($valor),$sentencia);
}


/*
+--------------------+-----------------------------------------------------------------------+
|           FUNCION: | cargar_parametro()                                                    |
+--------------------+-----------------------------------------------------------------------+
|              Info: | Carga el valor de un parámetro en una query con parámetros relativos. |
|           Entrada: | La sentencia, el nombre del parámetro en la query, y el valor nuevo.  |
|            Salida: | Devuelve la query con el parámetro correctamente mapeado.             |
+--------------------+-----------------------------------------------------------------------+
*/
function cargar_parametro_numero($sentencia,$param,$valor){
	return preg_replace("*".$param."*",limpiar_numero($valor),$sentencia);
}


/*
+--------------------+-----------------------------------------------------------------------+
|           FUNCION: | cargar_parametro_contenido()                                          |
+--------------------+-----------------------------------------------------------------------+
|              Info: | Carga el valor de un parámetro en una query con parámetros relativos. |
|           Entrada: | La sentencia, el nombre del parámetro en la query, y el valor nuevo.  |
|            Salida: | Devuelve la query con el parámetro correctamente mapeado.             |
+--------------------+-----------------------------------------------------------------------+
*/
function cargar_parametro_contenido($sentencia,$param,$valor){
	return preg_replace("*".$param."*",$valor,$sentencia);
}
/*
+--------------------+-----------------------------------------------------------------------+
|           FUNCION: | cargar_subquery()                                                     |
+--------------------+-----------------------------------------------------------------------+
|              Info: | Carga el valor de una subquery en una query con parámetros relativos. |
|           Entrada: | La sentencia, el nombre de la subquery en la query, y la subquery.    |
|            Salida: | Devuelve la query con la subquery correctamente mapeada.              |
+--------------------+-----------------------------------------------------------------------+
*/
function cargar_subquery($sentencia,$idsubquery,$subquery){
	return preg_replace("*".$idsubquery."*",$subquery,$sentencia);
}



?>