<?php
ob_start();
header("Cache-control: private, no-cache");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Pragma: no-cache");
header("Cache: no-cahce");
ini_set('max_execution_time', 90000);
ini_set("memory_limit", -1);
//--
include_once('html_fns_api.php');

header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");

///API REQUEST
$request = $_REQUEST["request"];

if ($request != "") {
	switch ($request) {
		case "hijos":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_hijos($tipo_usuario, $tipo_codigo);
			break;
		case "materias":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			API_lista_materias($nivel, $grado);
			break;
		case "tareas_materias":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			$materia = $_REQUEST["materia"];
			API_lista_tareas_materias($nivel, $grado, $seccion, $materia);
			break;
		case "tareas_alumno":
			$alumno = $_REQUEST["alumno"];
			/// 1 -> Programada, 2-> Calificada, 0-> Anulada
			API_lista_tareas_alumno($alumno);
			break;
		case "tarea":
			$codigo = $_REQUEST["codigo"];
			$alumno = $_REQUEST["alumno"];
			$situacion = $_REQUEST["situacion"]; /// 1 -> Programada, 2-> Calificada, 0-> Anulada
			API_tarea($codigo, $alumno, $situacion);
			break;
		case "tarea_archivo":
			$codigo = $_REQUEST["codigo"];
			API_tarea_Archivo($codigo);
			break;
		case "tarea_despligue":
			$alumno = $_REQUEST["alumno"];
			$materia = $_REQUEST["materia"];
			$unidad = $_REQUEST["unidad"];
			API_lista_tareas_materia_unidad($alumno, $materia, $unidad);
			break;
		case "tarea_delete":
			$codigo = $_REQUEST["codigo"];
			$tarea = $_REQUEST["tarea"];
			$alumno = $_REQUEST["alumno"];
			$archivo = $_REQUEST["archivo"];
			API_Eliminar_tarea($codigo, $tarea, $alumno, $archivo);
			break;
			https: //github.com/ajaxorg/ace/wiki/Default-Keyboard-Shortcuts
		default:
			$arr_data = array(
				"status" => "error",
				"message" => "Parametros invalidos..."
			);
			echo json_encode($arr_data);
			break;
	}
} else {
	//devuelve un mensaje de manejo de errores
	$arr_data = array(
		"status" => "error",
		"message" => "Delimite el tipo de consulta a realizar..."
	);
	echo json_encode($arr_data);
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////// FUNCIONES Y CONSULTAS ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function API_lista_hijos($tipo_usuario, $tipo_codigo)
{
	$ClsAsi = new ClsAsignacion();
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();

	if ($tipo_codigo != "") {
		if ($tipo_usuario === "3") {
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAsi->get_alumno_padre($tipo_codigo, "");
			if (is_array($result)) {
				$i = 0;
				foreach ($result as $row) {
					$cui = $row["alu_cui"];
					$arr_data[$i]['cui'] = $row["alu_cui"];
					$arr_data[$i]['tipo_cui'] = $row["alu_tipo_cui"];
					$arr_data[$i]['nombre'] = trim($row["alu_nombre"]);
					$arr_data[$i]['apellido'] = trim($row["alu_apellido"]);
					$arr_data[$i]['fecha_nacimiento'] = cambia_fecha($row["alu_fecha_nacimiento"]);
					$arr_data[$i]['edad'] = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
					$arr_data[$i]['genero'] = $row["alu_genero"];
					//--
					$foto = $row["alu_foto"];
					if (file_exists('../../CONFIG/Fotos/ALUMNOS/' . $foto . '.jpg')) { /// valida que tenga foto registrada
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/" . $foto . ".jpg";
					} else {
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
					}
					///------------------
					$result_grado_alumno = $ClsAcad->comprueba_seccion_alumno($pensum, '', '', '', '', $cui, '', 1);  ////// este array se coloca en la columna de combos
					if (is_array($result_grado_alumno)) {
						$j = 0;
						foreach ($result_grado_alumno as $row_grado_alumno) {
							$arr_grados[$j]['pensum'] = $row_grado_alumno["seca_pensum"];
							$arr_grados[$j]['nivel'] = $row_grado_alumno["seca_nivel"];
							$arr_grados[$j]['grado'] = $row_grado_alumno["seca_grado"];
							$arr_grados[$j]['seccion'] = $row_grado_alumno["seca_seccion"];
							$j++;
						}
						$arr_data[$i]['seccion'] = $arr_grados;
					}
					$i++;
				}
				echo json_encode($arr_data);
			} else {
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No exsisten hijos enlazados a este papa..."
				);
				echo json_encode($arr_data);
			}
		} else {
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario no pertenece al grupo de padres..."
			);
			echo json_encode($arr_data);
		}
	} else {
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de usuario esta vacio"
		);
		echo json_encode($arr_data);
	}
}



function API_lista_materias($nivel, $grado)
{
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	if ($pensum != "" && $nivel != "" && $grado != "") {
		$result = $ClsPen->get_materia($pensum, $nivel, $grado, '', '', 1);
		if (is_array($result)) {
			$i = 0;
			foreach ($result as $row) {
				$arr_data[$i]['codigo'] = $row["mat_codigo"];
				$arr_data[$i]['pensum'] = $row["mat_pensum"];
				$arr_data[$i]['nivel'] = $row["mat_nivel"];
				$arr_data[$i]['grado'] = $row["mat_grado"];
				$arr_data[$i]['codigo'] = $row["mat_codigo"];
				$arr_data[$i]['descripcion'] = $row["mat_descripcion"];
				$arr_data[$i]['descripcion_corta'] = $row["mat_desc_ct"];
				//tipo
				$tipo = trim($row["mat_tipo"]);
				switch ($tipo) {
					case 'A':
						$tipo_desc = "ACADEMICA";
						break;
					case 'P':
						$tipo_desc = "PRACTICA";
						break;
					case 'D':
						$tipo_desc = "DEPORTIVA";
						break;
				}
				$arr_data[$i]['tipo'] = $tipo_desc;
				$i++;
			}
			echo json_encode($arr_data);
		} else {
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos..."
			);
			echo json_encode($arr_data);
		}
	} else {
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio..."
		);
		echo json_encode($arr_data);
	}
}


function API_lista_tareas_materias($nivel, $grado, $seccion, $materia)
{
	$ClsTar = new ClsTarea();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	if ($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $materia != "") {
		$result = $ClsTar->get_tarea('', $pensum, $nivel, $grado, $seccion, $materia, '', '');
		if (is_array($result)) {
			$i = 0;
			foreach ($result as $row) {
				$arr_data[$i]['codigo'] = $row["tar_codigo"];
				$arr_data[$i]['materia'] = trim($row["tar_materia_desc"]);
				$arr_data[$i]['titulo'] = trim($row["tar_nombre"]);
				$arr_data[$i]['descripcion'] = $row["tar_descripcion"];
				$fecha = trim($row["tar_fecha_entrega"]);
				$arr_data[$i]['fecha_entrega'] = cambia_fechaHora($fecha);
				//--
				$i++;
			}
			echo json_encode($arr_data);
		} else {
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos..."
			);
			echo json_encode($arr_data);
		}
	} else {
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio..."
		);
		echo json_encode($arr_data);
	}
}



function API_lista_tareas_alumno($alumno)
{
	$ClsTar = new ClsTarea();
	if ($alumno != "") {

		$result = $ClsTar->get_det_tarea('', $alumno, '', '', '', '', '', '', '', '', '');
		if (is_array($result)) {
			$i = 0;
			foreach ($result as $row) {
				$tarea =  $row["tar_codigo"];
				$arr_data[$i]['codigo'] = $row["tar_codigo"];
				$arr_data[$i]['materia'] = trim($row["tar_materia_desc"]);
				$arr_data[$i]['titulo'] = trim($row["tar_nombre"]);
				$arr_data[$i]['descripcion'] = $row["tar_descripcion"];
				$fecha = trim($row["tar_fecha_entrega"]);
				$arr_data[$i]['fecha_entrega'] = cambia_fechaHora($fecha);
				$arr_data[$i]['nota'] = $row["dtar_nota"];
				$arr_data[$i]['ponderacion'] = $row["tar_ponderacion"];
				$arr_data[$i]['observaciones'] = $row["dtar_observaciones"];
				$situacion = $row["dtar_situacion"];
				$resolucion = trim($row["dtar_resolucion"]);
				switch ($situacion) {
					case '1':
						if ($resolucion > 0) {
							$tipo_sit = " respuesta enviada";
							$arr_data[$i]['status_situacion'] = 2;
							break;
						} else {
							$tipo_sit = "Pendiente de Calificar";
							$arr_data[$i]['status_situacion'] = 3;
							break;
						}
					case '2':
						$tipo_sit = "Calificada";
						$arr_data[$i]['status_situacion'] = 1;
						break;
				}
				$arr_data[$i]['situacion'] = $tipo_sit;
				$arr_data[$i]['link'] = $row["tar_link"];
				$calificacion = trim($row["tar_tipo_calificacion"]);
				switch ($calificacion) {
					case 'Z':
						$tipo_cal = "ZONA";
						break;
					case 'E':
						$tipo_cal = "EVALUACION";
						break;
				}
				$arr_data[$i]['tipo_calificacion'] = $tipo_cal;
				$tipo = trim($row["tar_tipo"]);
				switch ($tipo) {
					case 'SR':
						$tipo = "POR OTROS MEDIOS";
						break;
					case 'OL':
						$tipo = "SE RESPONDE EN LINEA";
						break;
				}
				$arr_data[$i]['tipo_respuesta'] = $tipo;
				$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
				//--
				$resultdoc = $ClsTar->get_respuesta_tarea_archivo('', $tarea, $alumno, '');
				if (is_array($resultdoc)) {
					$cantidad = 0;
					foreach ($resultdoc as $rows) {
						$server = "https://" . $_SERVER['HTTP_HOST'] . "CONFIG/DATALMSALUMNOS/TAREAS/MATERIAS/";
						$arrdoc[$cantidad]["codigo"] = trim($rows["arch_codigo"]);
						$arrdoc[$cantidad]["tarea"] = trim($rows["arch_tarea"]);
						$arrdoc[$cantidad]["alumno"] = trim($rows["arch_alumno"]);
						$arrdoc[$cantidad]["extension"] = trim($rows["arch_extencion"]);
						$arrdoc[$cantidad]["archivo"] = $server . ($rows["arch_codigo"]) . "_" . trim($rows["arch_tarea"]) . "_" . trim($rows["arch_alumno"]) . "." . trim($rows["arch_extencion"]);
						$cantidad++;
					}
					$arr_data[$i]['archivo'] = $arrdoc;
				}
				$i++;
			}

			echo json_encode($arr_data);
		} else {
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos..."
			);
			echo json_encode($arr_data);
		}
	} else {
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio..."
		);
		echo json_encode($arr_data);
	}
}


function API_tarea($codigo, $alumno, $situacion)
{
	$ClsTar = new ClsTarea();
	if ($codigo != "" && $alumno != "") {
		$result = $ClsTar->get_det_tarea($codigo, $alumno, '', '', '', '', '', '', '', '', $situacion);
		if (is_array($result)) {
			$i = 0;
			foreach ($result as $row) {
				$arr_data[$i]['codigo'] = $row["tar_codigo"];
				$arr_data[$i]['materia'] = trim($row["tar_materia_desc"]);
				$arr_data[$i]['titulo'] = trim($row["tar_nombre"]);
				$arr_data[$i]['descripcion'] = $row["tar_descripcion"];
				$fecha = trim($row["tar_fecha_entrega"]);
				$arr_data[$i]['fecha_entrega'] = cambia_fechaHora($fecha);
				$arr_data[$i]['maestro'] = $row["tar_maestro_nombre"];
				$arr_data[$i]['link'] = $row["tar_link"];
				$arr_data[$i]['nota'] = $row["dtar_nota"];
				$arr_data[$i]['observaciones'] = $row["dtar_observaciones"];
				$arr_data[$i]['situacion'] = $row["dtar_situacion"];
				//--
				$i++;
			}
			echo json_encode($arr_data);
		} else {
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos..."
			);
			echo json_encode($arr_data);
		}
	} else {
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio..."
		);
		echo json_encode($arr_data);
	}
}



function API_Eliminar_tarea($codigo, $tarea, $alumno, $archivo){
	$ClsTar = new ClsTarea();
	if ($codigo != "" && $tarea != "") {

		$sql = $ClsTar->delete_respuesta_tarea_archivo($codigo, $tarea, $alumno);
		$rs = $ClsTar->exec_sql($sql);
		if ($rs == 1) {
			if (file_exists("../../CONFIG/DATALMSALUMNOS/TAREAS/MATERIAS/$archivo")) {
				unlink("../../CONFIG/DATALMSALUMNOS/TAREAS/MATERIAS/$archivo");

				$arr_data = array(
					"status" => "satisfactorio",
					"message" => "Tarea eliminada exitosamente..."
				);
					json_encode($arr_data);
			}else{
				$arr_data = array(
					"status" => "negativo",
					"message" => "fallo al eliminar..."
				);
					json_encode($arr_data);
			}
		}
	}
}




function API_tarea_Archivo($codigo)
{
	$ClsTar = new ClsTarea();
	if ($codigo != "") {
		$result = $ClsTar->get_tarea_archivo('', $codigo, '');
		if (is_array($result)) {
			$i = 0;
			foreach ($result as $row) {
				$codigo = trim($row["arch_codigo"]) . "_" . trim($row["arch_tarea"]) . "." . trim($row["arch_extencion"]);
				$arr_data[$i]['codigo'] = trim($row["arch_codigo"]);
				$arr_data[$i]['tarea'] = trim($row["arch_tarea"]);
				$arr_data[$i]['extencion'] = trim($row["arch_extencion"]);
				$arr_data[$i]['codigo'] = trim($row["arch_codigo"]) . "_" . trim($row["arch_tarea"]) . "." . trim($row["arch_extencion"]);
				$arr_data[$i]['nombre'] = trim($row["arch_nombre"]);
				$arr_data[$i]['descripcion'] = trim($row["arch_descripcion"]);
				$arr_data[$i]['url_archivo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/DATALMS/TAREAS/MATERIAS/$codigo";
				$i++;
			}
			echo json_encode($arr_data);
		} else {
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos..."
			);
			echo json_encode($arr_data);
		}
	} else {
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio..."
		);
		echo json_encode($arr_data);
	}
}

function API_lista_tareas_materia_unidad($alumno, $materia, $unidad)
{
	$ClsNot = new ClsNotas();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	////////////////////////////// CALCULO DE SOLVENCIA /////////////////////////////////////
	$ClsPer = new ClsPeriodoFiscal();
	////// AÑO DE CARGOS A LISTAR /////////
	$periodo = $ClsPer->get_periodo_activo();
	$anio_periodo = $ClsPer->get_anio_periodo($periodo);
	$anio_actual = date("Y");
	$anio_periodo = ($anio_periodo == "") ? $anio_actual : $anio_periodo;
	//// fechas ///
	if ($anio_actual == $anio_periodo) {
		$mes = date("m"); ///mes de este año para calculo de saldos y moras
		$fini = "00/01/$anio_actual";
		$ffin = "31/$mes/$anio_actual";
	} else {
		$fini = "00/01/$anio_periodo";
		$ffin = "31/12/$anio_periodo";
	}

	/////// PROGRAMADO ////////
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_vs_pago('', '', '', $alumno, '', $periodo, '', $fini, $ffin, 1, 2);
	$monto_programdo = 0;
	$monto_pagado = 0;
	$referenciaX;
	if (is_array($result)) {
		foreach ($result as $row) {
			$bolcodigo = $row["bol_codigo"];
			$mons = $row["bol_simbolo_moneda"];
			if ($bolcodigo != $referenciaX) {
				$monto_programdo += $row["bol_monto"];
				$fecha_programdo = $row["bol_fecha_pago"];
				$fecha_pago = $row["pag_fechor"];
				$referenciaX = $bolcodigo;
			}
			$monto_pagado += $row["pag_total"]; /// monto registrado en la boleta, ya con descuento
		}
	}
	$valor_programado = $mons . ". " . number_format($monto_programdo, 2, '.', ',');

	/////// PAGADO ////////
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_aislado('', '', '', $alumno, '', $periodo, '', '0', '', $fini, $ffin, '');
	if (is_array($result)) {
		foreach ($result as $row) {
			$mons = $row["mon_simbolo"];
			$monto_pagado += $row["pag_efectivo"] + $row["pag_cheques_propios"] + $row["pag_otros_bancos"] + $row["pag_online"];
		}
	}
	//echo $monto_pagado;
	$valor_pagado = $mons . ". " . number_format($monto_pagado, 2, '.', ',');

	////////// CALUCULO DE SOLVENCIA ///////////
	$solvente = true;
	$diferencia = $monto_programdo - $monto_pagado;
	$diferencia = round($diferencia, 2);
	if ($diferencia <= 0) {
		$solvente = true;
		$solvencia = '';
	} else {
		if ($anio_actual == $anio_periodo) {
			$hoy = date("Y-m-d");
			//echo "$fecha_programdo < $hoy";
			if ($fecha_programdo < $hoy) {
				$fecha_programdo = cambia_fecha($fecha_programdo);
				$diferencia = $mons . " " . number_format($diferencia, 2);
				$solvente = false;
				$solvencia = 'Insolvente';
			} else {
				$fecha_programdo = cambia_fecha($fecha_programdo);
				$diferencia = $mons . " " . number_format($diferencia, 2, '.', '');
				$solvente = false;
				$solvencia = 'Solvente 1';
			}
		} else {
			$diferencia = $mons . " " . number_format($diferencia, 2, '.', '');
			$solvente = true;
			$solvencia = 'Solvente 2';
		}
	}
	////PARA BLOQUEAR NOTAS ///
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	$resultado = $ClsPen->get_nivel_alumno($alumno, '', $pensum);
	if (is_array($resultado)) {
		foreach ($resultado as $row) {
			$nivel = $row["seca_nivel"];
		}
	}
	$result = $ClsPen->get_nivel_bloqueo($pensum, '', $nivel);
	if (is_array($result)) {
		foreach ($result as $row) {
			$status = $row["notv_status"];
		}
		if ($status !== "1") {
			$solvente = false;
			$solvencia = "Pendientes de Públicar...";
		}
	}
	////////////////////////////// CALCULO DE SOLVENCIA /////////////////////////////////////
	$ClsTar = new ClsTarea();
	if ($alumno != "") {
		$result = $ClsTar->get_det_tarea('', $alumno, '', '', '', '', $materia, $unidad, '', '', '', '');
		if (is_array($result)) {
			$i = 0;
			foreach ($result as $row) {
				$arr_data[$i]['codigo'] = $row["tar_codigo"];
				$arr_data[$i]['materia'] = trim($row["tar_materia_desc"]);
				$arr_data[$i]['titulo'] = trim($row["tar_nombre"]);
				$arr_data[$i]['descripcion'] = $row["tar_descripcion"];
				$fecha = trim($row["tar_fecha_entrega"]);
				$arr_data[$i]['fecha_entrega'] = cambia_fechaHora($fecha);
				if ($solvente == true) {
					$arr_data[$i]['nota'] = $row["dtar_nota"];
				} else {
					$arr_data[$i]['nota'] = $solvencia;
				}
				$arr_data[$i]['ponderacion'] = $row["tar_ponderacion"];
				$arr_data[$i]['observaciones'] = $row["dtar_observaciones"];
				$situacion = $row["dtar_situacion"];
				$resolucion = trim($row["dtar_resolucion"]);
				switch ($situacion) {
					case '1':
						if ($resolucion > 0) {
							$tipo_sit = " respuesta enviada";
							$arr_data[$i]['status_situacion'] = 2;
							break;
						} else {
							$tipo_sit = "Pendiente de Calificar";
							$arr_data[$i]['status_situacion'] = 3;
							break;
						}
					case '2':
						$tipo_sit = "Calificada";
						$arr_data[$i]['status_situacion'] = 1;
						break;
				}
				$arr_data[$i]['situacion'] = $tipo_sit;
				$arr_data[$i]['link'] = $row["tar_link"];
				$calificacion = trim($row["tar_tipo_calificacion"]);
				switch ($calificacion) {
					case 'Z':
						$tipo_cal = "ZONA";
						break;
					case 'E':
						$tipo_cal = "EVALUACION";
						break;
				}
				$arr_data[$i]['tipo_calificacion'] = $tipo_cal;
				$tipo = trim($row["tar_tipo"]);
				switch ($tipo) {
					case 'SR':
						$tipo = "POR OTROS MEDIOS";
						break;
					case 'OL':
						$tipo = "SE RESPONDE EN LINEA";
						break;
				}
				$arr_data[$i]['tipo_respuesta'] = $tipo;
				$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
				//--
				$i++;
			}

			echo json_encode($arr_data);
		} else {
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos..."
			);
			echo json_encode($arr_data);
		}
	} else {
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio..."
		);
		echo json_encode($arr_data);
	}
}
