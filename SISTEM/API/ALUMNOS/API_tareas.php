<?php
ob_start();
header("Cache-control: private, no-cache");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Pragma: no-cache");
header("Cache: no-cahce");
ini_set('max_execution_time', 90000);
ini_set("memory_limit", -1);
ini_set('display_errors', 1);
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
		case "tareas_materias":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			$materia = $_REQUEST["materia"];
			API_lista_tareas_materias($nivel,$grado,$seccion,$materia);
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
			API_tarea($codigo,$alumno,$situacion);
			break;
		case "tarea_archivo":
			$codigo = $_REQUEST["codigo"];
			API_tarea_Archivo($codigo);
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
				$arr_data[$i]['materia'] = trim($row["tar_materia_desc"]);
				$arr_data[$i]['titulo'] = trim($row["tar_nombre"]);
				$arr_data[$i]['descripcion'] = $row["tar_descripcion"];
				$fecha = trim($row["tar_fecha_entrega"]);
				$arr_data[$i]['fecha_entrega'] = cambia_fechaHora($fecha);
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



function API_lista_tareas_alumno($alumno){
	$ClsTar = new ClsTarea();
	if($alumno != ""){
		$result = $ClsTar->get_det_tarea('',$alumno,'','','','','','','','','');
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
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
                switch($situacion){	
                    case '1': 
                        if($resolucion > 0 ){
                            $tipo_sit = " respuesta enviada"; 
                            $arr_data[$i]['status_situacion'] = 2;
                            break;
                        }else 
                            {$tipo_sit = "Pendiente de Calificar"; 
                            $arr_data[$i]['status_situacion'] = 3;
                            break;
                        }
                    case '2': $tipo_sit = "Calificada"; 
                    $arr_data[$i]['status_situacion'] = 1;
                    break;
				}
				$arr_data[$i]['situacion'] = $tipo_sit;
				$arr_data[$i]['link'] = $row["tar_link"];
				$calificacion = trim($row["tar_tipo_calificacion"]);
				switch($calificacion){	
					case 'Z': $tipo_cal = "ZONA"; break;
					case 'E': $tipo_cal = "EVALUACION"; break;
				}
				$arr_data[$i]['tipo_calificacion'] = $tipo_cal;
				$tipo = trim($row["tar_tipo"]);
				switch($tipo){	
					case 'SR': $tipo= "POR OTROS MEDIOS"; break;
					case 'OL': $tipo = "SE RESPONDE EN LINEA"; break;
				}
				$arr_data[$i]['tipo_respuesta'] = $tipo;
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


function API_tarea($codigo,$alumno,$situacion){
	$ClsTar = new ClsTarea();
	if($codigo != "" && $alumno != ""){
		$result = $ClsTar->get_det_tarea($codigo,$alumno,'','','','','','','','',$situacion);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
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

function API_tarea_Archivo($codigo){
	$ClsTar = new ClsTarea();
	if($codigo != "" ){
		$result = $ClsTar->get_tarea_archivo('',$codigo,'');
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$codigo=trim($row["arch_codigo"])."_".trim($row["arch_tarea"]).".".trim($row["arch_extencion"]);
				$arr_data[$i]['codigo'] = trim($row["arch_codigo"]);
				$arr_data[$i]['tarea'] = trim($row["arch_tarea"]);
			    $arr_data[$i]['extencion'] = trim($row["arch_extencion"]);
			    $arr_data[$i]['codigo'] = trim($row["arch_codigo"])."_".trim($row["arch_tarea"]).".".trim($row["arch_extencion"]);
				$arr_data[$i]['nombre'] = utf8_decode($row["arch_nombre"]);
				$arr_data[$i]['descripcion'] = utf8_decode($row["arch_descripcion"]);
				$arr_data[$i]['url_archivo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/DATALMS/TAREAS/MATERIAS/$codigo";
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
