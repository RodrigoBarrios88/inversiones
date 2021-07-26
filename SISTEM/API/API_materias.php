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

if($request != ""){
	switch($request){
		case "hijos":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_hijos($tipo_usuario,$tipo_codigo);
			break;
		case "materias":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			API_lista_materias($nivel,$grado);
			break;
		case "maestros":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			$materia = $_REQUEST["materia"];
			API_lista_maestros($nivel,$grado,$seccion,$materia);
			break;
		case "materia_unidades":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$materia = $_REQUEST["materia"];
			$alumno = $_REQUEST["alumno"];
			API_lista_materia_unidades($nivel,$grado,$materia,$alumno);
			break;
		case "horario":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			$materia = $_REQUEST["materia"];
			API_lista_horarios($nivel,$grado,$seccion,$materia);
			break;
		default:
			$arr_data = array(
			"status" => "error",
			"message" => "Parametros invalidos...");
			echo json_encode($arr_data);
			break;
	}
}else{
	//devuelve un mensaje de manejo de errores
	$arr_data = array(
		"status" => "error",
		"message" => "Delimite el tipo de consulta a realizar...");
		echo json_encode($arr_data);
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////// FUNCIONES Y CONSULTAS ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function API_lista_hijos($tipo_usuario,$tipo_codigo){
	$ClsAsi = new ClsAsignacion();
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "3"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAsi->get_alumno_padre($tipo_codigo,"");
			if (is_array($result)) {
				$i = 0;
				foreach($result as $row){
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
					if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
					}else{
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
					}
					///------------------
					$result_grado_alumno = $ClsAcad->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);  ////// este array se coloca en la columna de combos
					if(is_array($result_grado_alumno)){
						$j = 0;
						foreach($result_grado_alumno as $row_grado_alumno){
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
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No exsisten hijos enlazados a este papa...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario no pertenece al grupo de padres...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de usuario esta vacio");
			echo json_encode($arr_data);
	}
	
}



function API_lista_materias($nivel,$grado){
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($pensum != "" && $nivel != "" && $grado != ""){
		$result = $ClsPen->get_materia($pensum,$nivel,$grado,'','',1);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["mat_codigo"];
                $arr_data[$i]['pensum'] = $row["mat_pensum"];
				$arr_data[$i]['nivel'] = $row["mat_nivel"];
				$arr_data[$i]['grado'] = $row["mat_grado"];
				$arr_data[$i]['codigo'] = $row["mat_codigo"];
				$arr_data[$i]['descripcion'] = $row["mat_descripcion"];
				$arr_data[$i]['descripcion_corta'] = $row["mat_desc_ct"];
				//tipo
				$tipo = trim($row["mat_tipo"]);
				switch($tipo){	
					case 'A': $tipo_desc = "Académica"; break;
					case 'P': $tipo_desc = "Práctica"; break;
					case 'D': $tipo_desc = "Deportiva"; break;
				}
				$arr_data[$i]['tipo'] = $tipo_desc;
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}



function API_lista_maestros($nivel,$grado,$seccion,$materia){
	$ClsPen = new ClsPensum();
	$ClsAcadem = new ClsAcademico();
	$ClsUsu = new ClsUsuario();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $materia != ""){
		$result = $ClsAcadem->get_seccion_maestro($pensum,$nivel,$grado,$seccion,'','','',1);
		if(is_array($result)) {
			foreach ($result as $row){
				$maestro = $row["mae_cui"];
				$result_materia = $ClsAcadem->get_materia_maestro($pensum,$nivel,$grado,$materia,$maestro,'','',1);
				$i = 0;	
				if(is_array($result_materia)) {
					foreach ($result_materia as $row_materia){
						$arr_data[$i]['cui'] = $row["mae_cui"];
						$arr_data[$i]['maestro'] = trim($row_materia["mae_nombre"])." ".trim($row_materia["mae_apellido"]);
						$i++;
					}
				}	
			}
			$result = $ClsUsu->get_usuario_tipo_codigo(2,$maestro);
			if (is_array($result)) {
				foreach($result as $row){
					$arr_data[$i]['user_id'] = $row["usu_id"];
					$arr_data[$i]['chat_user_id'] = trim($row_materia["usu_chat_id"]);
				}	
			}else{
				$arr_data[$i]['user_id'] = "";
				$arr_data[$i]['chat_user_id'] = "";
			}	
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}	
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}



function API_lista_materia_unidades($nivel,$grado,$materia,$alumno){
	$ClsNot = new ClsNotas();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	////////////////////////////// CALCULO DE SOLVENCIA /////////////////////////////////////
	$ClsPer = new ClsPeriodoFiscal();
	////// AÑO DE CARGOS A LISTAR /////////
	$periodo = $ClsPer->get_periodo_activo();
	$anio_periodo = $ClsPer->get_anio_periodo($periodo);
	$anio_actual = date("Y");
	$anio_periodo = ($anio_periodo == "")?$anio_actual:$anio_periodo;
	//// fechas ///
	if($anio_actual == $anio_periodo){
		$mes = date("m"); ///mes de este año para calculo de saldos y moras
		$fini = "00/01/$anio_actual";
		$ffin = "31/$mes/$anio_actual";
	}else{
		$fini = "00/01/$anio_periodo";
		$ffin = "31/12/$anio_periodo";
	}
	
	/////// PROGRAMADO ////////
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_vs_pago('','','',$alumno,'',$periodo,'',$fini,$ffin,1,2);
	$monto_programdo = 0;
	$monto_pagado = 0;
	$referenciaX;
	if(is_array($result)){
		foreach($result as $row){
			$bolcodigo = $row["bol_codigo"];
			$mons = $row["bol_simbolo_moneda"];
			if($bolcodigo != $referenciaX){
				$monto_programdo+= $row["bol_monto"];
				$fecha_programdo = $row["bol_fecha_pago"];
				$fecha_pago = $row["pag_fechor"];
				$referenciaX = $bolcodigo;
			}
			$monto_pagado+= $row["pag_total"]; /// monto registrado en la boleta, ya con descuento
		}
	}
	$valor_programado = $mons .". ".number_format($monto_programdo, 2, '.', ',');
	
	/////// PAGADO ////////
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_aislado('','','', $alumno,'',$periodo,'','0','',$fini,$ffin,'');
	if(is_array($result)){
		foreach($result as $row){
			$mons = $row["mon_simbolo"];
			$monto_pagado+= $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
		}
	}
	//echo $monto_pagado;
	$valor_pagado = $mons .". ".number_format($monto_pagado, 2, '.', ',');
	
	////////// CALUCULO DE SOLVENCIA ///////////
	$solvente = true;
	$diferencia = $monto_programdo - $monto_pagado;
	$diferencia = round($diferencia, 2);
	if($diferencia <= 0){
		$solvente = true;
		$solvencia = '';
	}else{
		if($anio_actual == $anio_periodo){
			$hoy = date("Y-m-d");
			//echo "$fecha_programdo < $hoy";
			if($fecha_programdo < $hoy){
				$fecha_programdo = cambia_fecha($fecha_programdo);
				$diferencia = $mons ." ".number_format($diferencia, 2);
				$solvente = false;
				$solvencia = 'Insolvente';
			}else{
				$fecha_programdo = cambia_fecha($fecha_programdo);
				$diferencia = $mons ." ".number_format($diferencia, 2, '.', '');
				$solvente = true;
				$solvencia = '';
			}
		}else{
			$diferencia = $mons ." ".number_format($diferencia, 2, '.', '');
			$solvente = true;
			$solvencia = '';
		}
	}
	////PARA BLOQUEAR NOTAS ///
	$solvente = false;
	$solvencia = 'Pendientes de Públicar...';
	////////////////////////////// CALCULO DE SOLVENCIA /////////////////////////////////////
	
	if($pensum != "" && $nivel != "" && $grado != "" && $materia != "" && $alumno != ""){
		$result = $ClsPen->get_materia($pensum,$nivel,$grado,$materia,'',1);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				//--
				for($j = 1; $j <= 1; $j++){
					$arr_data[$i]['parcial'] = $j;
					$arr_data[$i]['pensum'] = $row["mat_pensum"];
					$arr_data[$i]['nivel'] = $row["mat_nivel"];
					$arr_data[$i]['grado'] = $row["mat_grado"];
					$arr_data[$i]['materia'] = $row["mat_codigo"];
					$arr_data[$i]['mat_descripcion'] = trim($row["mat_descripcion"]);
					switch($j){
						case 1: $par_descripcion = "1ra. Unidad"; break;
						case 2: $par_descripcion = "2da. Unidad"; break;
						case 3: $par_descripcion = "3ra. Unidad"; break;
						case 4: $par_descripcion = "4ta. Unidad"; break;
						case 5: $par_descripcion = "5ta. Unidad"; break;
					}
					$arr_data[$i]['descripcion'] = $par_descripcion;
					//--
					$parcial = $j;
					$result_notas = $ClsNot->comprueba_notas_alumno($alumno,$pensum,$nivel,$grado,$materia,$parcial);
					$arr_nota = array();
					$k = 0;
					if($solvente == true){
						if(is_array($result_notas)){
							foreach($result_notas as $row_notas){
								$exmane = trim($row_notas["not_nota"]);
								$zona = trim($row_notas["not_zona"]);
								$total = $exmane + $zona;
								//--
								$arr_nota[$k]['examen'] = trim($exmane)." puntos";
								$arr_nota[$k]['zona'] = trim($zona)." puntos";
								$arr_nota[$k]['total'] = trim($total)." puntos";
								$k++;
							}
						}else{
							$arr_nota[$k]['total'] = "Pendiente";
						}
					}else{
						$arr_nota[$k]['total'] = $solvencia;
					}
					$arr_data[$i]['nota'] = $arr_nota;
					//--
					$i++;
				}
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No existe la materia...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}




function API_lista_horarios($nivel,$grado,$seccion,$materia){
	$ClsHor = new ClsHorario();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $materia != ""){
		$result = $ClsHor->get_horario('','','','','','',$pensum,$nivel,$grado,$seccion,$materia,'','');
		if(is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['periodo'] = $row["tip_descripcion"];
				$arr_data[$i]['tiempo'] = $row["tip_minutos"]." MINUTOS";
				$arr_data[$i]['hora_inicia'] = $row["per_hini"];
				$arr_data[$i]['hora_fin'] = $row["per_hfin"];
				$dia = trim($row["per_dia"]);
				switch($dia){	
					case 1: $dia_desc = "Lunes"; break;
					case 2: $dia_desc = "Martes"; break;
					case 3: $dia_desc = "Miércoles"; break;
					case 4: $dia_desc = "Jueves"; break;
					case 5: $dia_desc = "Viernes"; break;
					case 6: $dia_desc = "Sábado"; break;
					case 7: $dia_desc = "Domingo"; break;
				}
				$arr_data[$i]['dia'] = $dia_desc;
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}

