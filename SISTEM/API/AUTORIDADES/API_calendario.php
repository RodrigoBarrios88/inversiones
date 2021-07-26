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
		case "detalle_informacion":
			$codigo = $_REQUEST["codigo"];
			API_detalle_informacion($codigo);
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



