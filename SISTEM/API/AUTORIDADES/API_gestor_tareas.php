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
		case "secciones":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_secciones($tipo_usuario,$tipo_codigo);
			break;
		case "materias":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			API_lista_materias($nivel,$grado);
			break;
		case "maestro_secciones":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_secciones_maestro($tipo_usuario,$tipo_codigo);
			break;
		case "maestro_materias":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			API_lista_materias_maestro($tipo_usuario, $tipo_codigo, $nivel, $grado);
			break;
		case "tareas_materia":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			$materia = $_REQUEST["materia"];
			API_lista_tareas_materia($nivel,$grado,$seccion,$materia);
			break;
		case "tareas_mestro":
			$maestro = $_REQUEST["maestro"];
			API_lista_tareas_maestro($maestro);
			break;
		case "tarea":
			$codigo = $_REQUEST["codigo"];
			API_tarea($codigo);
			break;
		case "lista_alumnos_tarea":
			$codigo = $_REQUEST["codigo"];
			API_lista_alumnos_tarea($codigo);
			break;
		case "new_tarea":
			$data = $_REQUEST["data"];
			API_new_tarea($data);
			break;
		case "update_tarea":
			$data = $_REQUEST["data"];
			API_update_tarea($data);
			break;
		case "calificar_tarea":
			$data = $_REQUEST["data"];
			API_calificar_tarea($data);
			break;
		case "delete_tarea":
			$codigo = $_REQUEST["codigo"];
			API_delete_tarea($codigo);
			break;
		//////////////////////////////////////////////////
		case "push":
			$push_tipo = $_REQUEST["tipo"];
			$item_id = $_REQUEST["codigo"];
			API_envia_push($push_tipo,$item_id);
			break;
		//////////////////////////////////////////////////
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

function API_lista_secciones($tipo_usuario,$tipo_codigo){
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "2"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAcadem->get_seccion_maestro($pensum,'','','',$tipo_codigo,'','',1);
			if (is_array($result)) {
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['nivel'] = trim($row["niv_codigo"]);
					$arr_data[$i]['grado'] = trim($row["gra_codigo"]);
					$arr_data[$i]['seccion'] = trim($row["sec_codigo"]);
					$arr_data[$i]['grado_descripcion'] = trim($row["gra_descripcion"]);
					$arr_data[$i]['seccion_descripcion'] = trim($row["sec_descripcion"]);
					///------------------
					$i++;
				}
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "vacio",
					"message" => "No exsisten secciones enlazados a este maestro...");
					echo json_encode($arr_data);
			}
		}else if($tipo_usuario === "1"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$tipo_codigo);
			if(is_array($result)){
				$nivel = "";
				$grado = "";
				foreach($result as $row){
					$nivel.= $row["gra_nivel"].",";
					$grado.= $row["gra_codigo"].",";
				}
				$nivel = substr($nivel, 0, -1);
				$grado = substr($grado, 0, -1);
				$result = $ClsPen->get_seccion_IN($pensum,$nivel,$grado,'','',1);
				if (is_array($result)) {
					$i = 0;
					foreach($result as $row){
						$arr_data[$i]['nivel'] = trim($row["niv_codigo"]);
						$arr_data[$i]['grado'] = trim($row["gra_codigo"]);
						$arr_data[$i]['seccion'] = trim($row["sec_codigo"]);
						$arr_data[$i]['grado_descripcion'] = trim($row["gra_descripcion"]);
						$arr_data[$i]['seccion_descripcion'] = trim($row["sec_descripcion"]);
						$i++;
					}
					echo json_encode($arr_data);
				}
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "vacio",
					"message" => "No exsisten secciones enlazados a esta autoridad...");
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



function API_lista_secciones_maestro($tipo_usuario,$tipo_codigo){
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "2"){
			$result = $ClsAcadem->get_seccion_maestro($pensum,'','','',$tipo_codigo,'','',1);
			if(is_array($result)){
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['pensum'] = $row["niv_pensum"];
					$arr_data[$i]['nivel'] = $row["niv_codigo"];
					$arr_data[$i]['gra_codigo'] = $row["gra_codigo"];
					$arr_data[$i]['sec_codigo'] = $row["sec_codigo"];
					$arr_data[$i]['gra_descripcion'] = trim($row["gra_descripcion"]);
					$arr_data[$i]['sec_descripcion'] = trim($row["sec_descripcion"]);
					$i++;
				}
				
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No existen secciones con estos parametros, en las que impartan clases este maestro...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario no pertenece al grupo de maestros...");
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


function API_lista_materias_maestro($tipo_usuario,$tipo_codigo,$nivel = "", $grado = ""){
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "1"){
			$result = $ClsPen->get_materia($pensum,$nivel,$grado,'','',1);
			if(is_array($result)){
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['pensum'] = $row["niv_pensum"];
					$arr_data[$i]['nivel'] = $row["niv_codigo"];
					$arr_data[$i]['niv_descripcion'] = trim($row["niv_descripcion"]);
					$arr_data[$i]['grado'] = $row["gra_codigo"];
					$arr_data[$i]['gra_descripcion'] = trim($row["gra_descripcion"]);
					$arr_data[$i]['mat_codigo'] = $row["mat_codigo"];
					$arr_data[$i]['mat_descripcion'] = trim($row["mat_descripcion"]);
					$i++;
				}
				
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No materias con estos parametros, que imparta este maestro...");
					echo json_encode($arr_data);
			}
		}if($tipo_usuario === "2"){
			$result = $ClsAcadem->get_materia_maestro($pensum,$nivel,$grado,'',$tipo_codigo,'','',1);;
			if(is_array($result)){
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['pensum'] = $row["niv_pensum"];
					$arr_data[$i]['nivel'] = $row["niv_codigo"];
					$arr_data[$i]['niv_descripcion'] = trim($row["niv_descripcion"]);
					$arr_data[$i]['grado'] = $row["gra_codigo"];
					$arr_data[$i]['gra_descripcion'] = trim($row["gra_descripcion"]);
					$arr_data[$i]['mat_codigo'] = $row["mat_codigo"];
					$arr_data[$i]['mat_descripcion'] = trim($row["mat_descripcion"]);
					$i++;
				}
				
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No materias con estos parametros, que imparta este maestro...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario no pertenece al grupo de maestros...");
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



function API_lista_tareas_materia($nivel,$grado,$seccion,$materia){
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



function API_lista_tareas_maestro($maestro){
	$ClsTar = new ClsTarea();
	if($maestro != ""){
		$result = $ClsTar->get_tarea('','','','','','',$maestro);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["tar_codigo"];
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


function API_tarea($codigo){
	$ClsTar = new ClsTarea();
	if($codigo != ""){
		$result = $ClsTar->get_tarea($codigo);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["tar_codigo"];
				$arr_data[$i]['titulo'] = trim($row["tar_nombre"]);
				$arr_data[$i]['descripcion'] = $row["tar_descripcion"];
				$fecha = trim($row["tar_fecha_entrega"]);
				$arr_data[$i]['fecha_entrega'] = cambia_fechaHora($fecha);
				$arr_data[$i]['link'] = $row["tar_link"];
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



function API_lista_alumnos_tarea($tarea){
	$ClsTar = new ClsTarea();
	if($tarea != ""){
		$result = $ClsTar->get_det_tarea($tarea);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["tar_codigo"];
				$arr_data[$i]['titulo'] = trim($row["tar_nombre"]);
				$arr_data[$i]['descripcion'] = $row["tar_descripcion"];
				$fecha = trim($row["tar_fecha_entrega"]);
				$arr_data[$i]['fecha_entrega'] = cambia_fechaHora($fecha);
				$arr_data[$i]['link'] = $row["tar_link"];
				$arr_data[$i]['cui_alumno'] = $row["dtar_alumno"];
				$arr_data[$i]['nombre_alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
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


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////// GESTORES ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function API_new_tarea($data){
	$ClsTar = new ClsTarea();
	$ClsPen = new ClsPensum();
	$ClsAcadem = new ClsAcademico();
	
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$pensum = $ClsPen->get_pensum_activo();
		$nivel = trim($data[0]["nivel"]);
		$grado = trim($data[0]["grado"]);
		$seccion = trim($data[0]["seccion"]);
		$materia = trim($data[0]["materia"]);
		$maestro = trim($data[0]["maestro"]);
		$titulo = trim($data[0]["titulo"]);
		$desc = trim($data[0]["descripcion"]);
		$fecha = trim($data[0]["fecha"]);
		$link = trim($data[0]["link"]);
		//--
		$titulo = utf8_encode($titulo);
		$desc = utf8_encode($desc);
		//--
		$titulo = trim($titulo);
		$desc = trim($desc);
		//--------
		if($titulo !="" && $desc !=""){
			$codigo = $ClsTar->max_tarea();
			$codigo++;
			$sql = $ClsTar->insert_tarea($codigo,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$titulo,$desc,$fecha,$link);
			$result = $ClsAcadem->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
			if(is_array($result)){
			   foreach($result as $row){
				   $alumno = $row["alu_cui"];
				   $sql.= $ClsTar->insert_det_tarea($codigo,$alumno,0,"",1);
			   }
			}
			
			$rs = $ClsTar->exec_sql($sql);
			if($rs == 1){
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "success",
					"codigo" => $codigo,
					"message" => "Tarea creada satisfactoriamente....");
					echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "Uno o mas datos no cumplen con las normas de integridad de la información, contacte al administrador...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Algunos datos estan vacios");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Formato no valido...");
			echo json_encode($arr_data);
	}
	
}



function API_update_tarea($data){
	$ClsTar = new ClsTarea();
	
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$codigo = trim($data[0]["codigo"]);
		$materia = trim($data[0]["materia"]);
		$titulo = trim($data[0]["titulo"]);
		$desc = trim($data[0]["descripcion"]);
		$fecha = trim($data[0]["fecha"]);
		$link = trim($data[0]["link"]);
		//--
		$titulo = utf8_encode($titulo);
		$desc = utf8_encode($desc);
		//--
		$titulo = trim($titulo);
		$desc = trim($desc);
		//--------
		if($titulo !="" && $desc !=""){
			$sql = $ClsTar->modifica_tarea_datos($codigo,$materia,$titulo,$desc,$fecha,$link);
			$rs = $ClsTar->exec_sql($sql);
			//echo $sql;
			if($rs == 1){
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "success",
					"message" => "Tarea actualizada satisfactoriamente....");
					echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "Uno o mas datos no cumplen con las normas de integridad de la información, contacte al administrador...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Algunos datos estan vacios");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Formato no valido...");
			echo json_encode($arr_data);
	}
	
}


function API_calificar_tarea($data){
	$ClsTar = new ClsTarea();
	
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$codigo = trim($data[0]["codigo"]);
		$alumno = trim($data[0]["alumno"]);
		$nota = trim($data[0]["nota"]);
		$obs = trim($data[0]["observaciones"]);
		//--
		$obs = utf8_encode($obs);
		//--
		$obs = trim($obs);
		//--------
		if($nota !="" && $obs !=""){
			$sql = $ClsTar->modifica_det_tarea($codigo,$alumno,$nota,$obs);
			$sql.= $ClsTar->cambiar_sit_det_tarea($codigo,$alumno,2);
			$rs = $ClsTar->exec_sql($sql);
			//echo $sql;
			if($rs == 1){
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "success",
					"message" => "Tarea Calificada Satisfactoriamente....");
					echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "Uno o mas datos no cumplen con las normas de integridad de la información, contacte al administrador...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Algunos datos estan vacios");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Formato no valido...");
			echo json_encode($arr_data);
	}
	
}


function API_delete_tarea($codigo){
	$ClsTar = new ClsTarea();
	if($codigo != ""){
		//$respuesta->alert("$cod,$sit");
		$sql = $ClsTar->delete_det_tarea_alumnos($codigo);
		$sql.= $ClsTar->delete_tarea($codigo);
		$rs = $ClsTar->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Tarea Eliminada Satisfactoriamente....");
				echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Uno o mas datos no cumplen con las normas de integridad de la información, contacte al administrador...");
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




///////////////////////////////////////// NOTIFICACIONES ///////////////////////////////////////////


function API_envia_push($push_tipo,$item_id){
	$ClsPush = new ClsPushup();
	if($item_id !=""){
		///// Ejecuta notificaciones push
		$result = $ClsPush->get_push_notification_user('',$push_tipo,'',$item_id);
		if(is_array($result)) {
			foreach ($result as $row){
				$user_id = $row["user_id"];
				$device_type = $row["device_type"];
				$device_token = $row["device_token"];
				$certificate_type = $row["certificate_type"];
				$target = $row["target"];
				//---
				$message = trim($row["message"]);
				//cuenta las notificaciones pendientes
				$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
				//--
				$data = array(
				   'landing_page'=> 'tareas',
				   'codigo' => $item_id
				);
				//envia la push
				if($device_type == 'android') {
					SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // Android
				}else if($device_type == 'ios') {
					SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // iOS
				}	
			}
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
			"status" => "success",
			"message" => "Notificaciones enviadas satisfactoriamente...");
			echo json_encode($arr_data);
		} else {
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
			"status" => "error",
			"message" => "Esta notificación no existe...");
			echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
		"status" => "error",
		"message" => "Algunos datos estan vacios");
		echo json_encode($arr_data);
	}
	
}
