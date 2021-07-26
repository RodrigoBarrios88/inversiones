<?php
	include_once('html_fns_videoclase.php');
	
	$fecha_dmY = date("d/m/Y H:i:s");
	$fecha_Ymd = regresa_fechaHora($fecha_dmY);
	$fecha_int = strtotime("$fecha_Ymd");
	//---
	$fecha_kaltura = date("d/m/Y H:i:s", $fecha_int);
	
	$result =  kaltura_connect();
	print_r($result);
	//echo json_encode($result);
	//echo "<br>";
	//echo $result["ks"];
	
?>