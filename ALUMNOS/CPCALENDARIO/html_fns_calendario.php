<?php 
include_once('../html_fns.php');

function json_calendario($codigos){
    $ClsInfo = new ClsInformacion();
    
    $json = "[";
	//////////////////////////////////////// GENERAL ///////////////////////////////////////////
	$result = $ClsInfo->get_informacion($codigos);
	if(is_array($result)){
        $i=1;
		foreach($result as $row){
            $json.= '{';
			//--
			$cod = $row["inf_codigo"];
            $json.= "id: $cod,";
            //---
			$nombre = utf8_decode($row["inf_nombre"]);
            $json.= "title: '$nombre',";
            //--
			$fini = trim($row["inf_fecha_inicio"]);
			$ffin = trim($row["inf_fecha_fin"]);
			//FECHA/HORA INICIO DE ACTIVIDAD
			$json.= fecha_inicio($fini);
			//FECHA/HORA DE FINALIZACION DE ACTIVIDAD
			$json.= fecha_final($ffin);
			//--
            //$json.= "url: 'FRMdetalle.php?codigo=$cod,'";
            $json.= "allDay: false";
			//--
			$json.= '},';
			$i++;
		}
        $json = substr($json, 0, -1);
	}
	$json.= "]";
	
    return $json;
    
}



function fecha_inicio($fechor){
    //FECHA/HORA INICIO DE ACTIVIDAD
	$fechor = cambia_fechaHora($fechor);
    $dia = intval(substr($fechor,0,2));
	$mes = intval(substr($fechor,3,2));
	$anio = intval(substr($fechor,6,4));
	$hora = intval(substr($fechor,11,2));
	$min = intval(substr($fechor,14,2));
	///AÑO///
	$year = date("Y");
	if($year > $anio){
		$calc = $year - $anio;
		$Y = "y-$calc";
	}else if($year < $anio){
		$calc = $anio - $year;
		$Y = "y+$calc";
	}else{
		$Y = "y";
	}
	///MES///
	$month = date("m");
	if($month > $mes){
		$calc = $month - $mes;
		$M = "m-$calc";
	}else if($month < $mes){
		$calc = $mes - $month;
		$M = "m+$calc";
	}else{
		$M = "m";
	}
	///DIA///
	$day = date("d");
	if($day > $dia){
		$calc = $day - $dia;
		$D = "d-$calc";
	}else if($day < $dia){
		$calc = $dia - $day;
		$D = "d+$calc";
	}else{
		$D = "d";
	}
	///H ///
    //echo "start: new Date($Y, $M, $D, $hora, $min),";
    //echo "<br>";
	return "start: new Date($Y, $M, $D, $hora, $min),";
}


function fecha_final($fechor){
    //FECHA/HORA INICIO DE ACTIVIDAD
	$fechor = cambia_fechaHora($fechor);
    $dia = intval(substr($fechor,0,2));
	$mes = intval(substr($fechor,3,2));
	$anio = intval(substr($fechor,6,4));
	$hora = intval(substr($fechor,11,2));
	$min = intval(substr($fechor,14,2));
	///AÑO///
	$year = date("Y");
	if($year > $anio){
		$calc = $year - $anio;
		$Y = "y-$calc";
	}else if($year < $anio){
		$calc = $anio - $year;
		$Y = "y+$calc";
	}else{
		$Y = "y";
	}
	///MES///
	$month = date("m");
	if($month > $mes){
		$calc = $month - $mes;
		$M = "m-$calc";
	}else if($month < $mes){
		$calc = $mes - $month;
		$M = "m+$calc";
	}else{
		$M = "m";
	}
	///DIA///
	$day = date("d");
	if($day > $dia){
		$calc = $day - $dia;
		$D = "d-$calc";
	}else if($day < $dia){
		$calc = $dia - $day;
		$D = "d+$calc";
	}else{
		$D = "d";
	}
	///H ///
	return "end: new Date($Y, $M, $D, $hora, $min),";
}


?>