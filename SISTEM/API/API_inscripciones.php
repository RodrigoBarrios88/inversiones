<?php
ob_start();
header("Cache-control: private, no-cache");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Pragma: no-cache");
header("Cache: no-cahce");
ini_set('max_execution_time', 90000);
ini_set("memory_limit", -1);

header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");
//--
include_once('html_fns_api.php');

header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");

///API REQUEST
$request = $_REQUEST["request"];

if($request != ""){
	switch($request){
		case "bloqueados":
			API_lista_bloqueados();
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


function API_lista_bloqueados(){
	$ClsIns = new ClsInscripcion();
	
	$result = $ClsIns->get_bloqueados();
	if(is_array($result)){
		$i = 0;
		foreach($result as $row){
			//codigo
			$cui = $row["blo_cui"];
			$codigo = $row["blo_codigo_interno"];
			//alumno
			$nombre = trim($row["blo_nombre"]);
			///fases de pruficacion de cadena
			//tildes
			$purename = str_replace("Á","A",$nombre);
			$purename = str_replace("É","E",$purename);
			$purename = str_replace("Í","I",$purename);
			$purename = str_replace("Ó","O",$purename);
			$purename = str_replace("Ú","U",$purename);
			//dierecis
			$purename = str_replace("Ä","A",$purename);
			$purename = str_replace("Ë","E",$purename);
			$purename = str_replace("Ï","I",$purename);
			$purename = str_replace("Ö","O",$purename);
			$purename = str_replace("Ü","U",$purename);
			//Ñ
			$purename = str_replace("Ñ","N",$purename);
			///espacios y otros
			$purename = str_replace(" ","",$purename);
			$purename = str_replace(",","",$purename);
			//minusculas
			$purename = strtolower($purename);
			//--
			$arr_data[$i]['cui'] = $cui;
			$arr_data[$i]['codigo'] = $codigo;
			$arr_data[$i]['nombre'] = $nombre;
			$arr_data[$i]['purename'] = $purename;
			//--
			$i++;
		}
		//print_r($arr_data);
		echo json_encode($arr_data);
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "No se registran datos...");
			echo json_encode($arr_data);
	}		
}