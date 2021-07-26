<?php
	date_default_timezone_set('America/Guatemala');
	include_once('html_fns_info.php');
	include_once('../Clases/ClsICS.php');
	$ClsVid = new ClsVideoclase();
	//$_POST
	//$hashkey = $_REQUEST["hashkey"];
	//$usu = $_SESSION["codigo"];
	//$codigo = $ClsVid->decrypt($hashkey, $usu);
	$codigo = $_REQUEST["codigo"];
	
	$result = $ClsVid->get_videoclase($codigo);
	if(is_array($result)){
		foreach($result as $row){
			$codigo = $row["vid_codigo"];
			$nombre = trim($row["vid_nombre"]);
			$link = trim($row["vid_link"]);
			$desc = utf8_decode($row["vid_descripcion"]);
			$fini = trim($row["vid_fecha_inicio"]);
			$ffin = trim($row["vid_fecha_fin"]);
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