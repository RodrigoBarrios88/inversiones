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
		case "calendario":
			$alumnos = $_REQUEST["alumnos"];
			$filtro_tipo = $_REQUEST["tipo"]; // puede venir vacio
			API_calendario($alumnos,$filtro_tipo);
			break;
		case "detalle_informacion":
			$codigo = $_REQUEST["codigo"];
			API_detalle_informacion($codigo);
			break;
		case "tareas_materias":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			$materia = $_REQUEST["materia"];
			API_lista_tareas_materias($nivel,$grado,$seccion,$materia);
			break;
		case "tareas_alumno":
			$alumno = $_REQUEST["alumno"];
			$situacion = $_REQUEST["situacion"]; /// 1 -> Programada, 2-> Calificada, 0-> Anulada
			API_lista_tareas_alumno($alumno,$situacion);
			break;
		case "tarea":
			$codigo = $_REQUEST["codigo"];
			$alumno = $_REQUEST["alumno"];
			$situacion = $_REQUEST["situacion"]; /// 1 -> Programada, 2-> Calificada, 0-> Anulada
			API_tarea($codigo,$alumno,$situacion);
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
					///------------------
					$result_grupo_alumno = $ClsAsi->get_alumno_grupo('',$cui,1);  ////// este array se coloca en la columna
					if(is_array($result_grupo_alumno)){
						$j = 0;
						foreach($result_grupo_alumno as $row_grupo_alumno){
							$arr_grupos[$j]['grupo'] = $row_grupo_alumno["gru_nombre"];
							//--
							$arr_grupos[$j]['area_codigo'] = $row_grupo_alumno["gru_area"];
							$arr_grupos[$j]['segmento_codigo'] = $row_grupo_alumno["gru_segmento"];
							$arr_grupos[$j]['grupo_codigo'] = $row_grupo_alumno["gru_codigo"];
							$j++;
						}
						$arr_data[$i]['grupos'] = $arr_grupos;
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






function API_calendario($alumnos,$filtro_tipo = ''){
	$ClsInfo = new ClsInformacion();
	$ClsPen = new ClsPensum();
	$ClsTar = new ClsTarea();
	$pensum = $ClsPen->get_pensum_activo();
	//--
	$arralumnos = array();
	$arralumnos = explode(",", $alumnos);
	$cantidad = count($arralumnos);
	
	$codigos = "";
	for($i = 0; $i <= $cantidad; $i ++){
		$alumno = $arralumnos[$i];
		if($alumno != ""){
			//////////////////////////////////////// GRADOS Y SECCIONES ///////////////////////////
			$codigos1 = $ClsInfo->get_codigos_informacion_secciones($pensum,$alumno);
			//////////////////////////////////////// GRUPOS //////////////////////////////////////
			$codigos2 = $ClsInfo->get_codigos_informacion_grupos($alumno);
			//////////////////////////////////////// TODOS //////////////////////////////////////
			$codigos3 = $ClsInfo->get_codigos_informacion_todos();
			//////////////////////////////////////// --- ////////////////////////////////////////
			if($codigos1 != ""){
				$codigos.= $codigos1.",";
			}
			if($codigos2 != ""){
				$codigos.= $codigos2.",";
			}
			if($codigos3 != ""){
				$codigos.= $codigos3.",";
			}
		}
	}
	$codigos = substr($codigos, 0, -1);
	if($codigos != ""){
		$i = 0;	
		if($filtro_tipo == 1 || $filtro_tipo == ""){ /// Valida se solo pide actividades o pide todos
			//////////////////////////////////////// ESPECIFICOS //////////////////////////////////////
			$result = $ClsInfo->get_informacion($codigos);
			if (is_array($result)) {
				foreach ($result as $row){
					$arr_data[$i]['codigo'] = $row["inf_codigo"];
					$arr_data[$i]['tipo'] = 1; /// Actividad
					$imagen = trim($row["inf_imagen"]);
					$imagen = ($imagen == "")?"https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/baner_actividad.png":"https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Actividades/".trim($row["inf_imagen"]);
					$arr_data[$i]['imagen'] =  $imagen;
					$url = trim($row["inf_link"]);
					$arr_data[$i]['link'] = $url;
					///------
					$arr_data[$i]['titulo'] = trim($row["inf_nombre"]);
					$arr_data[$i]['descripcion'] = trim($row["inf_descripcion"]);
					$arr_data[$i]['text'] = "<strong>".trim($row["inf_nombre"])."</strong><br>".trim($row["inf_descripcion"]);
					$fini = trim($row["inf_fecha_inicio"]);
					$ffin = trim($row["inf_fecha_fin"]);
					//--				
					$fechaini = explode(" ",$fini);
					$fini = trim($fechaini[0])."T".trim($fechaini[1]).".000Z";
					$arr_data[$i]['start'] = $fini;
					//--
					$fechafin = explode(" ",$ffin);
					$fini = trim($fechafin[0])."T".trim($fechafin[1]).".000Z";
					$arr_data[$i]['end'] = $fini;
					//--
					$arr_data[$i]['color'] = "#3777B7";
					//
					if(file_exists('../../CONFIG/images/logo.png')){ /// valida que tenga foto registrada
						$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
					}else{
						$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/noimage.png";
					}
					///---
					$i++;
				}
			}
		}
		//////////////////////////////////////// TAREAS //////////////////////////////////////
		if($filtro_tipo == 2 || $filtro_tipo == ""){ /// Valida se solo pide tareas o pide todos
			$result = $ClsTar->get_det_tarea('',$alumnos,$pensum);
			if (is_array($result)) {
				foreach ($result as $row){
					$arr_data[$i]['codigo'] = $row["tar_codigo"];
					$arr_data[$i]['tipo'] = 2; /// Tarea
					$arr_data[$i]['cui'] = trim($row["dtar_alumno"]);
					$arr_data[$i]['situacion'] = trim($row["dtar_situacion"]);
					$imagen = trim($row["inf_imagen"]);
					$imagen = ($imagen == "")?"https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/baner_actividad.png":"https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Actividades/".trim($row["inf_imagen"]);
					$arr_data[$i]['imagen'] =  $imagen;
					$url = trim($row["tar_link"]);
					$arr_data[$i]['link'] = $url;
					//--
					$arr_data[$i]['titulo'] = trim($row["tar_nombre"]);
					$arr_data[$i]['descripcion'] = trim($row["tar_descripcion"]);
					$arr_data[$i]['text'] = "<strong>".trim($row["tar_nombre"])."</strong><br>".trim($row["tar_materia_desc"])."<br>".trim($row["tar_grado_desc"])." ".trim($row["tar_seccion_desc"])."<br>".trim($row["tar_descripcion"]);
					$fini = trim($row["tar_fecha_entrega"]);
					$ffin = trim($row["tar_fecha_entrega"]);
					//--				
					$fechaini = explode(" ",$fini);
					$fini = trim($fechaini[0])."T".trim($fechaini[1]).".000Z";
					$arr_data[$i]['start'] = $fini;
					//--
					$fechafin = explode(" ",$ffin);
					$fini = trim($fechafin[0])."T".trim($fechafin[1]).".000Z";
					$arr_data[$i]['end'] = $fini;
					//--
					$arr_data[$i]['color'] = "#8C8C8C";
					//
					if(file_exists('../../CONFIG/images/logo.png')){ /// valida que tenga foto registrada
						$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
					}else{
						$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/noimage.png";
					}
					//--
					$i++;
				}
			}
		}
		if($i <= 0){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos..."
			);
			echo json_encode($arr_data);
		}else{
			echo json_encode($arr_data);
			return;
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "No se registran datos...");
			echo json_encode($arr_data);
	}
	
}


function API_detalle_informacion($codigo){
	$ClsInfo = new ClsInformacion();
	
	if($codigo != ""){
		$result = $ClsInfo->get_informacion($codigo,"","","");
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["inf_codigo"];
                $imagen = trim($row["inf_imagen"]);
				$imagen = ($imagen == "")?"https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/baner_actividad.png":"https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Actividades/".trim($row["inf_imagen"]);
				$arr_data[$i]['imagen'] =  $imagen;
				$url = trim($row["inf_link"]);
				$arr_data[$i]['link'] = $url;
				/*if (preg_match('#^(https?://|www\.)#i', $url) === 1){
					$arr_data[$i]['link'] = $url;
				} else {
					$arr_data[$i]['link'] = "";
				}*/
				$arr_data[$i]['ics'] = "https://" . $_SERVER['HTTP_HOST'] ."/SISTEM/API/API_ICScalendario.php?codigo=".trim($row["inf_codigo"]);
                $arr_data[$i]['titulo'] = trim($row["inf_nombre"]);
				$arr_data[$i]['descripcion'] = trim($row["inf_descripcion"]);
				$fini = trim($row["inf_fecha_inicio"]);
				$ffin = trim($row["inf_fecha_fin"]);
				//--				
				$fechaini = explode(" ",$fini);
				$fini = cambia_fecha($fechaini[0]);
				$arr_data[$i]['fecha_inicio'] = $fini;
				$arr_data[$i]['hora_inicio'] = substr($fechaini[1], 0, -3);
				//--
				$fechafin = explode(" ",$ffin);
				$fini = cambia_fecha($fechafin[0]);
				$arr_data[$i]['fecha_final'] = $fini;
				$arr_data[$i]['hora_final'] = substr($fechafin[1], 0, -3);
				//
				if(file_exists('../../CONFIG/images/logo.png')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
				}else{
					$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/noimage.png";
				}
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


function API_lista_tareas_materias($nivel,$grado,$seccion,$materia){
	$ClsTar = new ClsTarea();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $materia != ""){
		$result = $ClsTar->get_tarea('',$pensum,$nivel,$grado,$seccion,$materia,'','');
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["tar_codigo"];
				$arr_data[$i]['titulo'] = trim($row["tar_nombre"]);
				$arr_data[$i]['descripcion'] = $row["tar_descripcion"];
				$fecha = trim($row["tar_fecha_entrega"]);
				$arr_data[$i]['fecha_entrega'] = cambia_fechaHora($fecha);
				//--				
				$fechaini = explode(" ",$fecha);
				$fini = cambia_fecha($fechaini[0]);
				$arr_data[$i]['fecha_inicio'] = $fini;
				$arr_data[$i]['hora_inicio'] = substr($fechaini[1], 0, -3);
				//--
				$arr_data[$i]['fecha_final'] = $fini;
				$arr_data[$i]['hora_final'] = substr($fechaini[1], 0, -3);
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



function API_lista_tareas_alumno($alumno,$situacion){
	$ClsTar = new ClsTarea();
	if($alumno != ""){
		$result = $ClsTar->get_det_tarea('',$alumno,'','','','','',$situacion);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["tar_codigo"];
				$arr_data[$i]['titulo'] = trim($row["tar_nombre"]);
				$arr_data[$i]['descripcion'] = $row["tar_descripcion"];
				$fecha = trim($row["tar_fecha_entrega"]);
				$arr_data[$i]['fecha_entrega'] = cambia_fechaHora($fecha);
				//--				
				$fechaini = explode(" ",$fecha);
				$fini = cambia_fecha($fechaini[0]);
				$arr_data[$i]['fecha_inicio'] = $fini;
				$arr_data[$i]['hora_inicio'] = substr($fechaini[1], 0, -3);
				//--
				$arr_data[$i]['fecha_final'] = $fini;
				$arr_data[$i]['hora_final'] = substr($fechaini[1], 0, -3);
				//--
				$arr_data[$i]['nota'] = $row["dtar_nota"];
				$arr_data[$i]['observaciones'] = $row["dtar_observaciones"];
				$arr_data[$i]['situacion'] = $row["dtar_situacion"];
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


function API_tarea($codigo,$alumno,$situacion){
	$ClsTar = new ClsTarea();
	if($codigo != "" && $alumno != ""){
		$result = $ClsTar->get_det_tarea($codigo,$alumno,'','','','','',$situacion);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["tar_codigo"];
				$arr_data[$i]['titulo'] = trim($row["tar_nombre"]);
				$arr_data[$i]['descripcion'] = $row["tar_descripcion"];
				$fecha = trim($row["tar_fecha_entrega"]);
				$arr_data[$i]['fecha_entrega'] = cambia_fechaHora($fecha);
				//--				
				$fechaini = explode(" ",$fecha);
				$fini = cambia_fecha($fechaini[0]);
				$arr_data[$i]['fecha_inicio'] = $fini;
				$arr_data[$i]['hora_inicio'] = substr($fechaini[1], 0, -3);
				//--
				$arr_data[$i]['fecha_final'] = $fini;
				$arr_data[$i]['hora_final'] = substr($fechaini[1], 0, -3);
				//--
				$arr_data[$i]['maestro'] = $row["tar_maestro_nombre"];
				$arr_data[$i]['link'] = $row["tar_link"];
				$arr_data[$i]['nota'] = $row["dtar_nota"];
				$arr_data[$i]['observaciones'] = $row["dtar_observaciones"];
				$arr_data[$i]['situacion'] = $row["dtar_situacion"];
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

