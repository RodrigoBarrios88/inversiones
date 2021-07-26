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
$request = $_REQUEST["request"];

if($request != ""){
	switch($request){
		case "register":
			$user_id = $_REQUEST["user_id"];
			$device_id = $_REQUEST["device_id"];
			$device_token = $_REQUEST["device_token"];
			$device_type = $_REQUEST["device_type"];
			$certificate_type = $_REQUEST["certificate_type"];
			API_register($user_id,$device_id,$device_token,$device_type,$certificate_type);
			break;
		case "unregister":
			$user_id = $_REQUEST["user_id"];
			$device_id = $_REQUEST["device_id"];
			API_unregister($user_id,$device_id);
			break;
		case "send":
			$user_id = $_REQUEST["user_id"]; //CUI
			$mensaje = $_REQUEST["mensaje"];
			$type = $_REQUEST["type"]; //opcional
			$type_id = $_REQUEST["type_id"]; //opcional
			$target = $_REQUEST["target"]; //opcional
			API_send($user_id,$mensaje,$type,$type_id,$target);
			break;
		case "list":
			$user_id = $_REQUEST["user_id"]; //CUI
			$type = $_REQUEST["type"]; //opcional
			$alumno = $_REQUEST["alumno"]; //opcional
			$page = $_REQUEST["page"]; //opcional
			API_list($user_id,$type,$alumno,$page);
			break;
		case "pendientes":
			$user_id = $_REQUEST["user_id"];
			$alumno = $_REQUEST["alumno"]; //opcional
			API_pendientes($user_id,$alumno); //CUI
			break;
		case "reset_count":
			$user_id = $_REQUEST["user_id"];
			API_reset_count($user_id); //CUI
			break;
		case "reset_count_type":
			$user_id = $_REQUEST["user_id"];
			$type = $_REQUEST["type"];
			API_reset_count_type($user_id,$type); //CUI
			break;
		case "reset_count_type_alumno":
			$user_id = $_REQUEST["user_id"];
			$type = $_REQUEST["type"];
			$alumno = $_REQUEST["alumno"];
			API_reset_count_type_alumno($user_id,$type,$alumno); //CUI
			break;
		case "reset_especifica":
			$user_id = $_REQUEST["user_id"];
			$type = $_REQUEST["type"];
			$type_id = $_REQUEST["type_id"];
			API_reset_count_especificas($user_id,$type,$type_id); //ID
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

function API_register($user_id,$device_id,$device_token,$device_type,$certificate_type){
	$ClsPush = new ClsPushup();
	
	if($user_id != "" && $device_id != "" && $device_token != "" && $device_type != "" && $certificate_type != ""){
		
		$fecsist = date("Y-m-d H:i:s");
		$sql.= $ClsPush->insert_push_user($user_id,$device_id,$device_token,$device_type,$certificate_type,1,$fecsist,$fecsist);
		//echo $sql;
		$rs = $ClsPush->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "dispositivo registrado satisfactoriamente!");
				echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "error en el registro de este dispositivo...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
}



function API_unregister($user_id,$device_id){
	$ClsPush = new ClsPushup();
	
	if($user_id != "" && $device_id != ""){
		//echo $sql;
		$sql = $ClsPush->delete_push_user($user_id,$device_id);
		$rs = $ClsPush->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "dispositivo eliminado satisfactoriamente!");
				echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "error en la eliminación de este dispositivo...");
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



function API_send($user_id,$mensaje,$type,$type_id,$target){
	$ClsPush = new ClsPushup();
	
	if($user_id != "" && $mensaje != ""){
		$result = $ClsPush->get_push_user($user_id);
		if(is_array($result)) {
			foreach ($result as $row){
				$device_type = $row["device_type"];
				$device_token = $row["device_token"];
				$certificate_type = $row["certificate_type"];
			}
			$title = 'Prueba';
			$message = $mensaje;
			$push_tipo = 5;
			$item_id = '';
			$cert_path = '../../CONFIG/push/ck_prod.pem';
			$data = array(
				'landing_page'=> 'page',
				'codigo' => $item_id
			);
			//--
			$sql = $ClsPush->insert_push_notification($user_id,$message,$type,$type_id,$target);
			$rs = $ClsPush->exec_sql($sql);
			if($rs == 1){
				//cuenta las notificaciones pendientes
				$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
				if($device_type == 'android') {
					SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // Android
				}else if($device_type == 'ios') {
					SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // iOS
				}
				$arr_data = array(
					"status" => "success",
					"message" => "enviada....");
					echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "error en el registro de este dispositivo...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "este usuario no tiene dispositivo registrado...");
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



function API_list($user_id,$type,$alumno,$page = ''){
	$ClsPush = new ClsPushup();
	$ClsPos = new ClsPostit();
	$ClsPan = new ClsPanial();
	$ClsGol = new ClsGolpe();
	$ClsEnf = new ClsEnfermedad();
	$ClsCon = new ClsConducta();
	$ClsCir = new ClsCircular();
	$ClsInfo = new ClsInformacion();
	$ClsTar = new ClsTarea();
	
	if($page != ""){
		$limit1 = 1;
		$limit2 = 1;
		if($page == 0){
			$limit1 = 0;
			$limit2 = 10;
		}else{
			$limit1 = $page * 10;
			$limit2 = 10;
		}
	}else{
		$limit1 = 0;
		$limit2 = 10;
	}
	
	if($user_id != ""){
		$result = $ClsPush->get_push_notification($user_id,$type,$alumno,'',$limit1,$limit2);
		if(is_array($result)) {
			$i = 0;
			foreach ($result as $row){
				$arr_data[$i]['id'] = $row["push_notification_id"];
				$arr_data[$i]['message'] = $row["message"];
				$arr_data[$i]['type'] = $row["push_type"];
				$arr_data[$i]['item_id'] = $row["type_id"];
				$status = $row["status"];
				$target = $row["target"];
				$arr_data[$i]['cui_alumno'] = $target;
				$arr_data[$i]['status'] = $status;
				$arr_data[$i]['created_at'] = cambia_fechaHora($row["created_at"]);
				$arr_data[$i]['updated_at'] = cambia_fechaHora($row["updated_at"]);
				$tipo = trim($row["push_type"]);
				switch($tipo){
					case 1: $categoria = "Pinboard"; break;
					case 2: $categoria = "Tarea"; break;
					case 3: $categoria = "Actividad"; break;
					case 4: $categoria = "Encuesta"; break;
					case 5: $categoria = "Video Multimedia"; break;
					case 6: $categoria = "Circulares"; break;
					case 7: $categoria = "Reporte de Pañal"; break;
					case 8: $categoria = "Reporte de Golpe"; break;
					case 9: $categoria = "Reporte de Enfermedad"; break;
					case 10: $categoria = "Reporte de Conducta"; break;
					case 11: $categoria = "Photo Album"; break;
					case 12: $categoria = "Chat"; break;
					case 100: $categoria = "General"; break;
				}
				$arr_data[$i]['categoria'] = $categoria;
				$arr_data[$i]['clase'] = ($status == 0)?"noleida":"leida";
				//-- Datos del Alumno
				$type = $row["push_type"];
				$codigo = $row["type_id"];
				//echo "$type, $codigo <br>";
				switch($type){
					case 1:
						$rs = $ClsPos->get_postit($codigo);
						break;
					case 2:
						$rs = $ClsTar->get_det_tarea($codigo,$target);
						break;
					case 3:
						$rs = $ClsInfo->get_informacion($codigo);
						break;
					case 6:
						$rs = $ClsCir->get_circular($codigo);
						break;
					case 7:
						$rs = $ClsPan->get_panial($codigo);
						break;
					case 8:
						$rs = $ClsGol->get_golpe($codigo);
						break;
					case 9:
						$rs = $ClsEnf->get_enfermedad($codigo);
						break;
					case 10:
						$rs = $ClsCon->get_conducta($codigo);
						break;
					default:
						$rs;
						break;
				}
				if($type == 2){
					if(is_array($rs)){
						foreach ($rs as $row_tarea){
							$arr_data[$i]['cui_alumno'] = trim($row_tarea["dtar_alumno"]);
							$arr_data[$i]['situacion'] = trim($row_tarea["dtar_situacion"]);
						}	
					}else{
						$arr_data[$i]['cui_alumno'] = "";
					}
				}else if($type == 3){
					if(is_array($rs)){
						foreach ($rs as $row_actividad){
							$arr_data[$i]['imagen'] = $arr_data[$i]['imagen'] = ($row_actividad["inf_imagen"] != "")?"https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Actividades/".trim($row_actividad["inf_imagen"]):"https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/baner_actividad.png";
						}	
					}else{
						$arr_data[$i]['imagen'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/baner_circular.png";
						$arr_data[$i]['link'] = "";
					}
				}else if($type == 6){
					if(is_array($rs)){
						foreach ($rs as $row_circular){
							$arr_data[$i]['imagen'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/baner_circular.png";
							$arr_data[$i]['link'] = "https://" . $_SERVER['HTTP_HOST'] ."/CONFIG/Circulares/".trim($row_circular["cir_documento"]);
						}	
					}else{
						$arr_data[$i]['imagen'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/baner_circular.png";
						$arr_data[$i]['link'] = "";
					}
				}else{
					if(is_array($rs)){
						foreach ($rs as $row_alumno){
							if($type == 1){
								$arr_data[$i]['cui'] = trim($row_alumno["post_target"]);
								$arr_data[$i]['nombre'] = trim($row_alumno["post_target_nombre"]);
							} else {
								$arr_data[$i]['cui'] = trim($row_alumno["alu_cui"]);
								$arr_data[$i]['nombre'] = trim($row_alumno["alu_nombre"])." ".trim($row_alumno["alu_apellido"]);
							}
						}	
					}else{
						$arr_data[$i]['cui'] = "";
						$arr_data[$i]['nombre'] = "";
					}
				}
				//--
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
				"message" => "no hay notificaciones...");
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


function API_pendientes($user_id,$alumno){
	$ClsPush = new ClsPushup();
	
	if($user_id != ""){
		$count = $ClsPush->count_pendientes_leer($user_id,$alumno);
		$arr_data[0]['pendientes'] = $count;
		echo json_encode($arr_data);
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
}


function API_reset_count($user_id){
	$ClsPush = new ClsPushup();
	
	if($user_id != ""){
		$sql = $ClsPush->update_push_status($user_id);
		$rs = $ClsPush->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Contador de notificaciones reseteado...");
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

function API_reset_count_type($user_id,$type){
	$ClsPush = new ClsPushup();
	
	if($user_id != ""){
		$sql = $ClsPush->update_push_status_type($user_id,$type);
		$rs = $ClsPush->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Contador de notificaciones reseteado...");
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


function API_reset_count_type_alumno($user_id,$type,$alumno){
	$ClsPush = new ClsPushup();
	
	if($user_id != "" && $type != ""  && $alumno != ""){
		$sql = $ClsPush->update_push_status_type_alumno($user_id,$type,$alumno);
		$rs = $ClsPush->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Contador de notificaciones del alumno reseteado...");
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


function API_reset_count_especificas($user_id,$type,$type_id){
	$ClsPush = new ClsPushup();
	
	if($user_id != "" && $type != ""  && $type_id != ""){
		$sql = $ClsPush->update_push_status_especifica($user_id,$type,$type_id);
		$rs = $ClsPush->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Notificación leída ...");
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
