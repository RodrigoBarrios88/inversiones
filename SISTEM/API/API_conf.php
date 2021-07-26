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
$_REQUEST = str_replace("undefined", "", $_REQUEST); ///valida campos "undefined" desde javascript

if($request != ""){
	switch($request){
		case "modulos":
			API_get_modulos();
			break;
		case "validar_red":
			API_validar_red();
			break;
		case "versionamiento":
			$codigo = $_REQUEST["codigo"];
			API_validar_version($codigo);
			break;
		default:
			$payload = array(
			"status" => false,
			"data" => [],
			"message" => "Parametros invalidos...");
			echo json_encode($payload);
			break;
	}
}else{
	//devuelve un mensaje de manejo de errores
	$payload = array(
		"status" => false,
		"data" => [],
		"message" => "Delimite el tipo de consulta a realizar...");
		echo json_encode($payload);
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////// FUNCIONES Y CONSULTAS ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function API_get_modulos(){
	
	$ClsReg = new ClsRegla();
	$result = $ClsReg->get_modulos();
	$i = 0;
	if(is_array($result)) {
		foreach ($result as $row){
			$arr_data[$i]['codigo'] = trim($row["mod_codigo"]);
			$arr_data[$i]['modulo'] = trim($row["mod_nombre"]);
			$arr_data[$i]['clave'] = trim($row["mod_clave"]);
			$arr_data[$i]['status'] = (trim($row["mod_situacion"]) == 1)?true:false;
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
}


function API_validar_red(){
	//devuelve un mensaje de manejo de errores
	$payload = array( "status" => true );
	echo json_encode($payload);
}



function API_validar_version($codigo){
	$ClsVer = new ClsVersion();
	$codigo = (trim($codigo) == "")?1:$codigo;
	$result = $ClsVer->get_version($codigo,'','',1);
	if(is_array($result)) {
		foreach ($result as $row){
			$version = trim($row["ver_version"]);
		}
		//devuelve un mensaje de manejo de errores
		$payload = array( "version" => $version );
		echo json_encode($payload);
	}else{
		//devuelve un mensaje de manejo de errores
		$payload = array(
			"status" => false,
			"data" => [],
			"message" => "No hay version registrada para este software...");
		echo json_encode($payload);
	}

}

?>