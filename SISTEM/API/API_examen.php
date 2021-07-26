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
		case "materias":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			API_lista_materias($nivel,$grado);
			break;
		case "examen_materias":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			$materia = $_REQUEST["materia"];
			API_lista_examen_materias($nivel,$grado,$seccion,$materia);
			break;
		case "examen_alumno":
			$alumno = $_REQUEST["alumno"];
			$situacion = $_REQUEST["sit"]; /// 1 -> Programada, 2-> Calificada, 0-> Anulada
			API_lista_examen_alumno($alumno,$situacion);
			break;
		case "examen":
			$codigo = $_REQUEST["codigo"];
			$alumno = $_REQUEST["alumno"];
			API_examen($codigo,$alumno);
			break;
		case "examen_archivo":
			$codigo = $_REQUEST["codigo"];
			API_examen_Archivo($codigo);
			break;	
		case "examen_despligue":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			$materia = $_REQUEST["materia"];
			$unidad = $_REQUEST["unidad"];
			$alumno = $_REQUEST["alumno"];
			API_lista_examen_materias_despligue($nivel,$grado,$seccion,$materia,$unidad,$alumno);
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
					case 'A': $tipo_desc = "ACADEMICA"; break;
					case 'P': $tipo_desc = "PRACTICA"; break;
					case 'D': $tipo_desc = "DEPORTIVA"; break;
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


function API_lista_examen_materias($nivel,$grado,$seccion,$materia){
	$ClsExa = new ClsExamen();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $materia != ""){
		$result = $ClsExa->get_examen('',$pensum,$nivel,$grado,$seccion,$materia,'','');
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["exa_codigo"];
				$arr_data[$i]['materia'] = trim($row["exa_materia_desc"]);
				$arr_data[$i]['titulo'] = trim($row["exa_nombre"]);
				$arr_data[$i]['descripcion'] = $row["exa_descripcion"];
                $fechain = trim($row["exa_fecha_inicio"]);
                $fechali = trim($row["exa_fecha_limite"]);
                $arr_data[$i]['fecha_inicio'] = cambia_fechaHora($fechain);
                $arr_data[$i]['fecha_limite'] = cambia_fechaHora($fechali);
				//--
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

function API_lista_examen_materias_despligue($nivel,$grado,$seccion,$materia,$unidad,$alumno){
	$ClsExa = new ClsExamen();
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
				$solvente = false;
				$solvencia = 'Solvente 1';
			}
		}else{
			$diferencia = $mons ." ".number_format($diferencia, 2, '.', '');
			$solvente = true;
			$solvencia = 'Solvente 2';
		}
	}
	////PARA BLOQUEAR NOTAS ///
       $ClsPen = new ClsPensum();
		$resultado = $ClsPen->get_nivel_alumno($alumno,'',$pensum);
		if(is_array($resultado)){
            foreach($resultado as $row){
		        $nivel=$row["seca_nivel"];
		        $seccion=$row["seca_seccion"];
            }
		}
        $result = $ClsPen->get_nivel_bloqueo($pensum,'',$nivel);
       // echo($result);
        if(is_array($result)){
            foreach($result as $row){
		        $status =$row["notv_status"];
            }
		        if($status !== "1"){
		            $solvente = false;
	                $solvencia = "Pendientes de Públicar...";
		        
		        }
		}
	if($unidad !='' && $materia!=''&& $nivel!='' && $grado !=''){
		$result = $ClsExa->get_examen('',$pensum,$nivel,$grado,$seccion,$materia,'',$unidad);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
			    $codigo = $row["exa_codigo"];
				$arr_data[$i]['codigo'] = $row["exa_codigo"];
				$arr_data[$i]['materia'] = trim($row["exa_materia_desc"]);
				$arr_data[$i]['titulo'] = trim($row["exa_titulo"]);
				$arr_data[$i]['descripcion'] = $row["exa_descripcion"];
                $fechain = trim($row["exa_fecha_inicio"]);
                $fechali = trim($row["exa_fecha_limite"]);
                $arr_data[$i]['fecha_inicio'] = cambia_fechaHora($fechain);
                $arr_data[$i]['fecha_limite'] = cambia_fechaHora($fechali);
                $result = $ClsExa->get_pregunta('',$codigo);
                $puntos = 0;
                if(is_array($result)){
                    foreach($result as $row){
                        $puntos+= trim($row["pre_puntos"]);
                	}
                }
                $arr_data[$i]['valor_examen'] = $puntos;
				$respustaTipo = $row["exa_tipo"];
				if($respustaTipo == "OL"){	
                    $arr_data[$i]['respuesta_tipo'] = "Se Responde en linea";
                }else{ 
                    $arr_data[$i]['respuesta_tipo'] = "Por otro Medio";
                }
				$calificacionTipo = $row["exa_tipo_calificacion"];
				if($calificacionTipo == "E"){	
                    $arr_data[$i]['calificaion_tipo'] = "EVALUACION";
				}else{
                    $arr_data[$i]['calificaion_tipo'] = "ZONA";
				}
				$fechain = trim($row["exa_fecha_inicio"]);
                $fechali = trim($row["exa_fecha_limite"]);
                $arr_data[$i]['fecha_inicio'] = cambia_fechaHora($fechain);
                $arr_data[$i]['fecha_limite'] = cambia_fechaHora($fechali);
                $resulte = $ClsExa->get_det_examen($codigo,$alumno);
                if($solvente == true){
                 if(is_array($resulte)){
                    foreach($resulte as $rowe){
        				$nota = $rowe["dexa_nota"];
        				if($nota !=''){
        				    $arr_data[$i]['nota']=$nota;
        				}else{
        				    $arr_data[$i]['nota']="Nota pendiente";
        				}
                    }
                }
                }else{
                    $arr_data[$i]['nota']= $solvencia;
                }
				$arr_data[$i]['observaciones'] = $row["dexa_observaciones"];
				$situacion = $row["dexa_situacion"];
				 switch($situacion){	
                     case '1': $arr_data[$i]['situacion'] = 1;
                    $arr_data[$i]['situacionestatus'] = "Sin Resolver";
                    case '2': $arr_data[$i]['situacion'] = 2;
                    $arr_data[$i]['situacionestatus'] = "Resuelto";
                    case '3':$arr_data[$i]['situacion'] = 3;
                    $arr_data[$i]['situacionestatus'] = "Calificada";
                    break;
				}
				$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
				//--
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



function API_lista_examen_alumno($alumno,$situacion){
	$ClsExa = new ClsExamen();
	if($alumno != ""){
	   
		$result = $ClsExa->get_det_examen('',$alumno,'','','','','','','','',$situacion);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
			    $codigo = $row["exa_codigo"];
			    $result = $ClsExa->get_pregunta('',$codigo);
                $puntos = 0;
                if(is_array($result)){
                    foreach($result as $row){
                        $puntos+= trim($row["pre_puntos"]);
                	}
                }
                $arr_data[$i]['valor_examen'] = $puntos;
				$arr_data[$i]['codigo'] = $row["exa_codigo"];
				$arr_data[$i]['materia_codigo'] = trim($row["exa_materia"]);
				$arr_data[$i]['materia'] = trim($row["exa_materia_desc"]);
				$arr_data[$i]['titulo'] = trim($row["exa_titulo"]);
				$arr_data[$i]['descripcion'] = $row["exa_descripcion"];
				$respustaTipo = $row["exa_tipo"];
				if($respustaTipo == "OL"){	
                    $arr_data[$i]['respuesta_tipo'] = "Se Responde en linea";
                }else{ 
                    $arr_data[$i]['respuesta_tipo'] = "Por otro Medio";
                }
				$calificacionTipo = $row["exa_tipo_calificacion"];
				if($calificacionTipo == "E"){	
                    $arr_data[$i]['calificaion_tipo'] = "EVALUACION";
				}else{
                    $arr_data[$i]['calificaion_tipo'] = "ZONA";
				}
				$fechain = trim($row["exa_fecha_inicio"]);
                $fechali = trim($row["exa_fecha_limite"]);
                $arr_data[$i]['fecha_inicio'] = cambia_fechaHora($fechain);
                $arr_data[$i]['fecha_limite'] = cambia_fechaHora($fechali);
				$arr_data[$i]['nota'] = $row["dexa_nota"];
				$arr_data[$i]['observaciones'] = $row["dexa_observaciones"];
				$situacion = $row["dexa_situacion"];
				 switch($situacion){	
                     case '1': $arr_data[$i]['situacion'] = 1;
                    $arr_data[$i]['situacionestatus'] = "Sin Resolver";
                    case '2': $arr_data[$i]['situacion'] = 2;
                    $arr_data[$i]['situacionestatus'] = "Resuelto";
                    case '3':$arr_data[$i]['situacion'] = 3;
                    $arr_data[$i]['situacionestatus'] = "Calificada";
                    break;
				}
				$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
				//--
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


function API_examen($codigo,$alumno){
	$ClsExa = new ClsExamen();
	if($codigo != "" && $alumno != ""){
		$result = $ClsExa->get_det_examen($codigo,$alumno,'','','','','','','','','');
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["exa_codigo"];
				$arr_data[$i]['materia'] = trim($row["exa_materia"]);
				$arr_data[$i]['titulo'] = trim($row["exa_titulo"]);
				$arr_data[$i]['descripcion'] = $row["exa_descripcion"];
				$fechain = trim($row["exa_fecha_inicio"]);
                $fechali = trim($row["exa_fecha_limite"]);
                $arr_data[$i]['fecha_inicio'] = cambia_fechaHora($fechain);
                $arr_data[$i]['fecha_limite'] = cambia_fechaHora($fechali);
				$arr_data[$i]['maestro'] = $row["exa_maestro"];
                $arr_data[$i]['repetir'] = $row["exa_repetir"];
                $arr_data[$i]['calificar'] = $row["exa_calificar"];
				$arr_data[$i]['nota'] = $row["dexa_nota"];
				$arr_data[$i]['observaciones'] = $row["dexa_observaciones"];
				$arr_data[$i]['situacion'] = $row["dexa_situacion"];
				//--
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

function API_examen_Archivo($codigo){
	$ClsExa = new ClsExamen();
	if($codigo != "" ){
		$result = $ClsExa->get_examen_archivo('',$codigo,'');
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = trim($row["arch_codigo"]);
				$arr_data[$i]['examen'] = trim($row["arch_examen"]);
			    $arr_data[$i]['extencion'] = trim($row["arch_extencion"]);
			    $arr_data[$i]['codigo'] = trim($row["arch_codigo"])."_".trim($row["arch_examen"]).".".trim($row["arch_extencion"]);
				$arr_data[$i]['nombre'] = trim($row["arch_nombre"]);
				$arr_data[$i]['descripcion'] = trim($row["arch_descripcion"]);
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
