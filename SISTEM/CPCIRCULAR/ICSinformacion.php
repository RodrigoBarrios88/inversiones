<?php
	date_default_timezone_set('America/Guatemala');
	include_once('html_fns_circular.php');
	include_once('../Clases/ClsICS.php');
	$ClsCir = new ClsCircular();
	//$_POST
	//$hashkey = $_REQUEST["hashkey"];
	//$usu = $_SESSION["codigo"];
	//$codigo = $ClsCir->decrypt($hashkey, $usu);
	$codigo = $_REQUEST["codigo"];
	
	$result = $ClsCir->get_circular($codigo);
	if(is_array($result)){
		foreach($result as $row){
			$codigo = $row["cir_codigo"];
			$titulo = trim($row["cir_titulo"]);
			$autorizacion = trim($row["cir_autorizacion"]);
			$desc = utf8_decode($row["cir_descripcion"]);
			$publicacion = trim($row["cir_fecha_publicacion"]);
			// elimina las "/"
			$publicacion = str_replace("-","",$publicacion);
			// elimina los espacio " " e identifica el inico de las horas
			$publicacion = str_replace(" ","T",$publicacion);
			// elimina los ":"
			$publicacion = str_replace(":","",$publicacion);
		}	
	}
	
	header('Content-type: text/calendar; charset=utf-8');
	header('Content-Disposition: attachment; filename=invite.ics');


	$ics = new ICS(array(
		'location' => '',
		'description' => $desc,
		'dtstart' => $publicacion,
		'dtend' => $ffin,
		'summary' => $titulo,
		'url' => $autorizacion
	));
	  
	echo $ics->to_string();
	
?>