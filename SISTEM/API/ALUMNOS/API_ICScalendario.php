<?php
	ob_start();
	header("Cache-control: private, no-cache");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Pragma: no-cache");
	header("Cache: no-cahce");
	ini_set('max_execution_time', 90000);
	ini_set("memory_limit", -1);
	//--
	date_default_timezone_set('America/Guatemala');
	include_once('html_fns_api.php');
	
	header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
	header("Access-Control-Allow-Origin: *");
	$ClsInfo = new ClsInformacion();
	$codigo = $_REQUEST["codigo"];
	
	$result = $ClsInfo->get_informacion($codigo);
	if(is_array($result)){
		foreach($result as $row){
			$codigo = $row["inf_codigo"];
			$nombre = trim($row["inf_nombre"]);
			$link = trim($row["inf_link"]);
			$descripcion = trim($row["inf_descripcion"]);
			$fini = trim($row["inf_fecha_inicio"]);
			$ffin = trim($row["inf_fecha_fin"]);
			// Inicio yyyy-mm-dd hh:mm:ss
			$anioIni = substr($fini,0,4);
			$mesIni = substr($fini,5,2);
			$diaIni = substr($fini,8,2);
			$horaIni = substr($fini,11,2);
			$minutosIni = substr($fini,14,2);
			$start = array("anio" => intval($anioIni), "mes" => intval($mesIni)-1, "dia" => intval($diaIni), "hora" => intval($horaIni), "min" => intval($minutosIni), "seg" => 0, "mil" => 0, "mic" => 0);
			// Final yyyy-mm-dd hh:mm:ss
			$anioFin = substr($ffin,0,4);
			$mesFin = substr($ffin,5,2);
			$diaFin = substr($ffin,8,2);
			$horaFin = substr($ffin,11,2);
			$minutosFin = substr($ffin,14,2);
			$end = array("anio" => intval($anioFin), "mes" => intval($mesFin)-1, "dia" => intval($diaFin), "hora" => intval($horaFin), "min" => intval($minutosFin), "seg" => 0, "mil" => 0, "mic" => 0);
			$i++;
		}
		////---
		$arr_date = array();
		$arr_date["startDate"] = $start;
		$arr_date["endDate"] = $end;
		$arr_date["title"] = $nombre;
		$arr_date["notes"] = $descripcion;
		$arr_date["eventLocation"] = 'Ciudad';
		$arr_date["link"] = $link;
		
		$arr_data = array(
			"status" => true,
			"data" => $arr_date,
			"message" => "");
			echo json_encode($arr_data);
		
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => false,
			"message" => "No existe la actividad...");
			echo json_encode($arr_data);
	}
	
?>