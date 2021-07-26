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
		case "images":
			API_imagenes();
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

function API_imagenes(){
	$arr_data = array();
	$arr_data['logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo.png";
	$arr_data['baner_actividad'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/baner_actividad.png";
	$arr_data['baner_circular'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/baner_circular.png";
	$arr_data['baner_tarea'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/baner_tarea.jpg";
	$arr_data['alumnos'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/alumnos.jpg";
	$arr_data['chat'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/chat.jpg";
	$arr_data['grupos'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/grupos.jpg";
	$arr_data['materias'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/materias.jpg";
	$arr_data['notas'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/notas.jpg";
	$arr_data['pagos'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/pagos.jpg";
	$arr_data['tareas'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/tareas.jpg";
	$arr_data['photoalbum'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/photoalbum.jpg";
	$arr_data['videos'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/videos.jpg";
	
	$payload = array(
			"status" => true,
			"data" => $arr_data);
				
	echo json_encode($payload);
	
}
