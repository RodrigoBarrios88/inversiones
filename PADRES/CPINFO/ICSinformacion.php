<?php
	date_default_timezone_set('America/Guatemala');
	include_once('html_fns_info.php');
	include_once('../Clases/ClsICS.php');
	$ClsInfo = new ClsInformacion();
	//$_POST
	//$hashkey = $_REQUEST["hashkey"];
	//$usu = $_SESSION["codigo"];
	//$codigo = $ClsInfo->decrypt($hashkey, $usu);
	$codigo = $_REQUEST["codigo"];
	
	$result = $ClsInfo->get_informacion($codigo);
	if(is_array($result)){
		foreach($result as $row){
			$codigo = $row["inf_codigo"];
			$nombre = trim($row["inf_nombre"]);
			$link = trim($row["inf_link"]);
			$desc = utf8_decode($row["inf_descripcion"]);
			$fini = trim($row["inf_fecha_inicio"]);
			$ffin = trim($row["inf_fecha_fin"]);
			// elimina las "/"
			$fini = str_replace("-","",$fini);
			$ffin = str_replace("-","",$ffin);
			// elimina los espacio " " e identifica el inico de las horas
			$fini = str_replace(" ","T",$fini);
			$ffin = str_replace(" ","T",$ffin);
			// elimina los ":"
			$fini = str_replace(":","",$fini);
			$ffin = str_replace(":","",$ffin);
			//entrega "YYYYmmddThhiissZ"
		}	
	}
	
	header('Content-type: text/calendar; charset=utf-8');
	header('Content-Disposition: attachment; filename=invite.ics');


	$ics = new ICS(array(
		'location' => '',
		'description' => $desc,
		'dtstart' => $fini,
		'dtend' => $ffin,
		'summary' => $nombre,
		'url' => $link
	));
	  
	echo $ics->to_string();
	
?>