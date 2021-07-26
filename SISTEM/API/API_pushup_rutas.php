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

include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');
///API REQUEST
$request = $_REQUEST["type"];

if($request != ""){
	switch($request){
		case "pendientes":
			$user_id = $_REQUEST["user_id"];
			$alumno = $_REQUEST["alumno"];
			API_pendientes($user_id,$alumno);
			break;
		case "probar_pendientes":
			$user_id = $_REQUEST["user_id"];
			$type = $_REQUEST["tipo"];
			$item_id = $_REQUEST["item_id"];
			$number = $_REQUEST["cantidad"];
			$alumno = $_REQUEST["alumno"];
			API_probar_pendientes($type,$item_id,$number,$user_id,$alumno);
			break;
		case 1:
			$codigo = $_REQUEST["item_id"];
			API_postit($codigo);
			break;
		case 2:
			$codigo = $_REQUEST["item_id"];
			API_tarea($codigo);
			break;
		case 3:
			$codigo = $_REQUEST["item_id"];
			API_actividad($codigo);
			break;
		case 4:
			$encuesta = $_REQUEST["item_id"];
			$persona = $_REQUEST["cui_usuario"];
			API_encuesta($encuesta,$persona);
			break;
		case 6:
			$codigo = $_REQUEST["item_id"];
			API_circular($codigo);
			break;
		case 7:
			$codigo = $_REQUEST["item_id"];
			API_panial($codigo);
			break;
		case 8:
			$codigo = $_REQUEST["item_id"];
			API_golpe($codigo);
			break;
		case 9:
			$codigo = $_REQUEST["item_id"];
			API_enfermedad($codigo);
			break;
		case 10:
			$codigo = $_REQUEST["item_id"];
			API_conducta($codigo);
			break;
        case 11:
			$codigo = $_REQUEST["item_id"];
			API_photoalbum($codigo);
			break;
		case 12:
			$codigo = $_REQUEST["item_id"];
			$usuario = $_REQUEST["usuario"];
			API_chat($codigo,$usuario);
			break;
        case 100:
			$codigo = $_REQUEST["item_id"];
			//API_photoalbum($codigo);
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


function API_pendientes($user_id,$alumno = ''){
	$ClsPush = new ClsPushup();
	
	if($user_id != ""){
		$postits = $ClsPush->count_pendientes_leer_type($user_id,1,$alumno);
		$tareas = $ClsPush->count_pendientes_leer_type($user_id,2,$alumno);
		$actividades = $ClsPush->count_pendientes_leer_type($user_id,3,$alumno);
		$encuestas = $ClsPush->count_pendientes_leer_type($user_id,4,$alumno);
		$video = $ClsPush->count_pendientes_leer_type($user_id,5,$alumno);
		$circulares = $ClsPush->count_pendientes_leer_type($user_id,6,$alumno);
		$panial = $ClsPush->count_pendientes_leer_type($user_id,7,$alumno);
		$golpe = $ClsPush->count_pendientes_leer_type($user_id,8,$alumno);
		$enfermendad = $ClsPush->count_pendientes_leer_type($user_id,9,$alumno);
		$conducta = $ClsPush->count_pendientes_leer_type($user_id,10,$alumno);
		$photo = $ClsPush->count_pendientes_leer_type($user_id,11,$alumno);
		$chat = $ClsPush->count_pendientes_leer_type($user_id,12);
		$reportes = ($panial+$golpe+$enfermendad+$conducta);
		$general = $ClsPush->count_pendientes_leer_type($user_id,100,$alumno);
		
		$i=0;
		$arr_data[$i]['reportes'] = (!intval($reportes))?0:intval($reportes);
		$arr_data[$i]['tipo1'] = (!intval($postits))?0:intval($postits);
		$arr_data[$i]['tipo2'] = (!intval($tareas))?0:intval($tareas);
		$arr_data[$i]['tipo3'] = (!intval($actividades))?0:intval($actividades);
		$arr_data[$i]['tipo4'] = (!intval($encuestas))?0:intval($encuestas);
		$arr_data[$i]['tipo5'] = (!intval($video))?0:intval($video);
		$arr_data[$i]['tipo6'] = (!intval($circulares))?0:intval($circulares);
		$arr_data[$i]['tipo7'] = (!intval($panial))?0:intval($panial);
		$arr_data[$i]['tipo8'] = (!intval($golpe))?0:intval($golpe);
		$arr_data[$i]['tipo9'] = (!intval($enfermendad))?0:intval($enfermendad);
		$arr_data[$i]['tipo10'] = (!intval($conducta))?0:intval($conducta);
		$arr_data[$i]['tipo11'] = (!intval($photo))?0:intval($photo);
		$arr_data[$i]['tipo12'] = (!intval($chat))?0:intval($chat);
		$arr_data[$i]['multimedia'] = (intval($photo) + intval($video));
		$arr_data[$i]['tipo100'] = (!intval($general))?0:intval($general);
		
		echo json_encode($arr_data);
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de usuario está vacio...");
			echo json_encode($arr_data);
	}
	
}


function API_probar_pendientes($type,$item_id,$number,$user_id,$alumno = ''){
	$ClsPush = new ClsPushup();
	
	if($user_id != ""){
		if($number > 0 && $number <= 5){
			$sql = '';
			for($i = 1; $i <= $number; $i++){
				$sql.= $ClsPush->insert_push_notification($user_id,'push para prueba de pendientes',$type,$item_id,$alumno);
			}
			$rs = $ClsPush->exec_sql($sql);
			if($rs == 1){
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
				"status" => "success",
				"message" => "$number notificaciones pendientes de lectura para el tipo $type");
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
				"message" => "1 es el mínimo y 5 es el número máximo de notificaciones de prueba para cada tipo...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de usuario está vacio...");
			echo json_encode($arr_data);
	}
	
}



function API_postit($codigo){
	
	if($codigo != ""){
		$ClsPost = new ClsPostit();
		$result = $ClsPost->get_postit($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["post_codigo"];
				$grado = trim($row["post_grado_desc"]);
				$seccion = trim($row["post_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['materia'] = trim($row["post_materia_desc"]);
				$target = trim($row["post_target"]);
				$target_nombre = trim($row["post_target_nombre"]);
				$target = ($target != "")?$target_nombre:"Todos";
				$arr_data[$i]['cui'] = trim($row["post_target"]);
				$arr_data[$i]['target'] = $target;
				$arr_data[$i]['titulo'] = trim($row["post_titulo"]);
				$arr_data[$i]['descripcion'] = trim($row["post_descripcion"]);
				$fecha = $row["post_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
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
				$arr_data[$i]['materia'] = trim($row["tar_materia_desc"]);
				$arr_data[$i]['titulo'] = trim($row["tar_nombre"]);
				$arr_data[$i]['descripcion'] = $row["tar_descripcion"];
				$fecha = trim($row["tar_fecha_entrega"]);
				$arr_data[$i]['fecha_entrega'] = cambia_fechaHora($fecha);
				$arr_data[$i]['maestro'] = $row["tar_maestro_nombre"];
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


function API_actividad($codigo){
	$ClsInfo = new ClsInformacion();

	if($codigo != ""){
		$result = $ClsInfo->get_informacion($codigo,"","","");
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["inf_codigo"];
				$imagen = trim($row["inf_imagen"]);
				$imagen = ($imagen == "")?"":"https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Actividades/".$imagen;
                $arr_data[$i]['imagen'] = $imagen;
				$arr_data[$i]['link'] = trim($row["inf_link"]);
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

function API_encuesta($encuesta,$persona){
	$ClsEnc = new ClsEncuesta();

	if($encuesta != ""){
		$result = $ClsEnc->get_encuesta($encuesta);
		if(is_array($result)){
			foreach ($result as $row){
				$arr_encuesta[0]['codigo'] = $row["enc_codigo"];
                $arr_encuesta[0]['titulo'] = trim($row["enc_titulo"]);
				$arr_encuesta[0]['descripcion'] = trim($row["enc_descripcion"]);
				$feclimit = trim($row["enc_fecha_limite"]);
				$feclimit = cambia_fecha($feclimit);
				$arr_encuesta[0]['fecha_limite'];
				$i++;
			}
			$result = $ClsEnc->get_pregunta('',$encuesta);
			if(is_array($result)){
				$i = 0;	
				foreach ($result as $row){
					$codigo = $row["pre_codigo"];
					$arr_pregunta[$i]['codigo'] = $row["pre_codigo"];
					$arr_pregunta[$i]['descripcion'] = trim($row["pre_descripcion"]);
					if($persona != ""){
						$result_respuesta = $ClsEnc->get_respuesta_directa($encuesta,$codigo,$persona);
						if(is_array($result_respuesta)){
							foreach ($result_respuesta as $row_respuesta){
								$arr_pregunta[$i]['ponderacion'] = trim($row_respuesta["resp_ponderacion"]);
							}	
						}else{
							$arr_pregunta[$i]['ponderacion'] = '';
						}
					}else{
						$arr_pregunta[$i]['ponderacion'] = '';
					}
					$i++;
				}
				$arr_encuesta[0]['preguntas'] = $arr_pregunta;
				echo json_encode($arr_encuesta);
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


function API_circular($codigo){
	$ClsInfo = new ClsInformacion();
	$ClsCir = new ClsCircular();
	
	if($codigo != ""){
		$result = $ClsCir->get_circular($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$codigo = $row["cir_codigo"];
				$arr_data[$i]['codigo'] = $codigo;
				$arr_data[$i]['imagen'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/baner_circular.png";
				$arr_data[$i]['link'] = "https://" . $_SERVER['HTTP_HOST'] ."/CONFIG/Circulares/".trim($row["cir_documento"]);
				$arr_data[$i]['titulo'] = trim($row["cir_titulo"]);
				$arr_data[$i]['descripcion'] = trim($row["cir_descripcion"])." (Ver documento adjunto)";
				$autoriza = trim($row["cir_autorizacion"]);
				$autoriza = ($autoriza == 1)?true:false;
				$arr_data[$i]['requiere_autorizacion'] = $autoriza;
				$fini = trim($row["cir_fecha_publicacion"]);
				//--				
				$fechaini = explode(" ",$fini);
				$fini = cambia_fecha($fechaini[0]);
				$arr_data[$i]['fecha_publicacion'] = $fini;
				$arr_data[$i]['hora_publicacion'] = substr($fechaini[1], 0, -3);
				//--
				$respuatoriza = array();
				$respuatoriza = $ClsCir->get_autorizacion_directa($codigo,$persona);
				$autoriza = $respuatoriza["autoriza"];
				$fecha_autoriza = $respuatoriza["fecha"];
				if($autoriza == null){
					$arr_data[$i]['status_autorizacion'] = null;
					$arr_data[$i]['texto_autorizacion'] = "";
				}else if($autoriza == 1){
					$fecha_autoriza = cambia_fechaHora($fecha_autoriza);
					$arr_data[$i]['status_autorizacion'] = true;
					$arr_data[$i]['texto_autorizacion'] = "Autorizada el $fecha_autoriza";
					$arr_data[$i]['requiere_autorizacion'] = false; //ya esta autorizada
				}else if($autoriza == 2){
					$fecha_autoriza = cambia_fechaHora($fecha_autoriza);
					$arr_data[$i]['status_autorizacion'] = false;
					$arr_data[$i]['texto_autorizacion'] = "Denegada el $fecha_autoriza";
					$arr_data[$i]['requiere_autorizacion'] = false; // no esta autorizada, pero ya respondio
				}
				//--
				$i++;
			}
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


function API_panial($codigo){
	$ClsPan = new ClsPanial();
	
	if($codigo != ""){
		$result = $ClsPan->get_panial($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["pan_codigo"];
				$grado = trim($row["pan_grado_desc"]);
				$seccion = trim($row["pan_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['cui'] = trim($row["pan_alumno"]);
				$arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$arr_data[$i]['titulo'] = 'Reporte de Pañal';
				//--
				$alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$pipi = trim($row["pan_cant_pipi"]);
				$popo = trim($row["pan_cant_popo"]);
				$tipo = trim($row["pan_tipo"]);
				$obs = trim($row["pan_observaciones"]);
				$obs = ($obs == "")?"Ninguna":$obs;
$cuerpo = "Deseamos informar que el día de hoy cambiamos el pañal de su hijo(a): $alumno.\r\n
Veces con pipi: $pipi.
Veces con popo: $popo.
Consistencia: $tipo.
Observaciones: $obs.";
				//--
				$arr_data[$i]['pipi'] = $pipi;
				$arr_data[$i]['popo'] = $popo;
				$arr_data[$i]['consistencia'] = $tipo;
				$arr_data[$i]['observaciones'] = $obs;
				
				$arr_data[$i]['descripcion'] = $cuerpo;
				$fecha = $row["pan_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
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


function API_golpe($codigo){
	$ClsGol = new ClsGolpe();
	
	if($codigo != ""){
		$result = $ClsGol->get_golpe($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["gol_codigo"];
                    $grado = trim($row["gol_grado_desc"]);
                    $seccion = trim($row["gol_seccion_desc"]);
                    $arr_data[$i]['seccion'] =  $grado.' '.$seccion;
                    $arr_data[$i]['cui'] = trim($row["gol_alumno"]);
                    $arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);;
                    $arr_data[$i]['genero'] = trim($row["alu_genero"]);
					$arr_data[$i]['titulo'] = 'Reporte de Golpe';
                    //--
                    $alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
                    $lugar = trim($row["gol_lugar"]);
                    $hora = trim($row["gol_hora"]);
                    $desc = trim($row["gol_descripcion"]);
                    $accion = trim($row["gol_medida"]);
                    $dosis = trim($row["gol_dosis"]);
$cuerpo = "Estimados Señores:
Nos dirigimos a ustedes para informarles con mucha pena que su hijo(a) $alumno se lastimó, a continuación los detalles:
Lugar: $lugar.
Hora: $hora.
Parte del Cuerpo lastimada y Descripción del Golpe: $desc.
Acción y medicamento: $accion.
Dosis: $dosis.";
                    //--		
                    $arr_data[$i]['lugar'] = trim($row["gol_lugar"]);
                    $arr_data[$i]['hora'] = trim($row["gol_hora"]);
                    $arr_data[$i]['descripcion'] = trim($row["gol_descripcion"]);
                    $arr_data[$i]['accion'] = trim($row["gol_medida"]);
                    $arr_data[$i]['dosis'] = trim($row["gol_dosis"]);
                    //
                    $arr_data[$i]['cuerpo'] = $cuerpo;
                    $fecha = $row["gol_fecha_registro"];
                    $arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
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


function API_enfermedad($codigo){
	$ClsEnf = new ClsEnfermedad();
	
	if($codigo != ""){
		$result = $ClsEnf->get_enfermedad($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["enf_codigo"];
                    $grado = trim($row["enf_grado_desc"]);
                    $seccion = trim($row["enf_seccion_desc"]);
                    $arr_data[$i]['seccion'] =  $grado.' '.$seccion;
                    $arr_data[$i]['cui'] = trim($row["enf_alumno"]);
                    $arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);;
                    $arr_data[$i]['genero'] = trim($row["alu_genero"]);
					$arr_data[$i]['titulo'] = 'Reporte de Enfermedad';
                    //--
                    $alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
                    $sintomas = trim($row["enf_sintomas"]);
                    $hora = trim($row["enf_hora"]);
                    $aviso = trim($row["enf_aviso"]);
                    $accion = trim($row["enf_medida"]);
                    $dosis = trim($row["enf_dosis"]);
$cuerpo = "Estimados Señores:
Nos dirigimos a ustedes para informarles con mucha pena que su hijo(a) $alumno se sintió mal, a continuación los detalles:
Sintomas: $sintomas.
Hora: $hora.
¿Se aviso a los padres? ¿A quien?: $aviso.
Medida y medicamento: $accion.
Dosis: $dosis.";
                    //--		
                    $arr_data[$i]['sintomas'] = trim($row["enf_sintomas"]);
                    $arr_data[$i]['hora'] = trim($row["enf_hora"]);
                    $arr_data[$i]['se_aviso_a'] = trim($row["enf_aviso"]);
                    $arr_data[$i]['accion'] = trim($row["enf_medida"]);
                    $arr_data[$i]['dosis'] = trim($row["enf_dosis"]);
                    //
                    $arr_data[$i]['cuerpo'] = $cuerpo;
                    $fecha = $row["enf_fecha_registro"];
                    $arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
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


function API_conducta($codigo){
	$ClsCon = new ClsConducta();
	
	if($codigo != ""){
		$result = $ClsCon->get_conducta($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["con_codigo"];
                    $grado = trim($row["con_grado_desc"]);
                    $seccion = trim($row["con_seccion_desc"]);
                    $arr_data[$i]['seccion'] =  $grado.' '.$seccion;
                    $arr_data[$i]['cui'] = trim($row["con_alumno"]);
                    $arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);;
                    $arr_data[$i]['genero'] = trim($row["alu_genero"]);
					$arr_data[$i]['titulo'] = 'Reporte de Conducta';
                    //--
                    $alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
                    $calificacion = trim($row["con_calificacion"]);
                    switch($calificacion){
                         case 1: $cond_text = "Muy Bien"; break;
                         case 2: $cond_text = "Bien"; break;
                         case 3: $cond_text = "Regular"; break;
                         case 4: $cond_text = "Debo Mejorar"; break;
                    }
                    $obs = trim($row["con_observaciones"]);
                    //--
$cuerpo = "Hola mamí y papí, yo $alumno
Hoy me porté:
$cond_text

Observaciones: 
$obs.";
                    //--		
                    $arr_data[$i]['calificacion'] = trim($row["con_calificacion"]);
                    $arr_data[$i]['calificacion_descripcion'] = $cond_text;
                    $arr_data[$i]['observaciones'] = trim($row["con_observaciones"]);
                    //
                    $arr_data[$i]['cuerpo'] = $cuerpo;
                    $fecha = $row["con_fecha_registro"];
                    $arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
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


function API_photoalbum($codigo){
	$ClsPho = new ClsPhoto();
	
	if($codigo != ""){
		$result = $ClsPho->get_photo($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["pho_codigo"];
				$arr_data[$i]['titulo'] = 'Nuevo Photo Album';
				$arr_data[$i]['texto'] = $row["pho_descripcion"];
				//
				$fecha = $row["pho_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
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

function API_chat($dialogo,$usuario){
	$ClsChat = new ClsChat();
	
	if($dialogo != ""){
		$usuario = trim($usuario);
		$result = $ClsChat->get_mensajes($dialogo);
		if (is_array($result)) {
			$i = 0;
			foreach($result as $row){
				$arr_data[$i]['codigo'] = $row["msj_codigo"];
				$arr_data[$i]['emisor'] = $row["msj_usuario_envia"];
				$arr_data[$i]['emisor_nombre'] = $row["usu_nombre_pantalla"];
				$emisor = trim($row["msj_usuario_envia"]);
				$arr_data[$i]['clase'] = ($emisor == $usuario)?"enviado":"recibido";
				$arr_data[$i]['mensaje'] = $row["msj_texto"];
				$freg = trim($row["msj_fechor_registro"]);
				$freg = date("d/m/y H:i", strtotime( $freg ) );
				$fupd = trim($row["msj_fechor_update"]);
				$fupd = date("d/m/y H:i", strtotime( $fupd ) );
				$arr_data[$i]['registrado'] = $freg;
				$arr_data[$i]['actualizado'] = $fupd;
				$arr_data[$i]['status'] = $row["msj_situacion"];
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "empty",
				"message" => "No exsisten mensajes en este dialogo...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de dialogo esta vacio");
			echo json_encode($arr_data);
	}
	
}


?>