<?php
include_once("html_fns_reportes.php");
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//post
	$barc = trim($_REQUEST["barc"]);
	$sit = trim($_REQUEST["sit"]);
	$grup = trim($_REQUEST["gru"]);
	$nom = trim($_REQUEST["artnom"]);
	$desc = trim($_REQUEST["desc"]);
	
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=lista_servicios.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	echo rep_tabla_servicios('',$grup,$nom,$desc,$barc,$sit); 
?>