<?php
include_once("html_fns_reportes.php");
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//post
	$sit = trim($_REQUEST["sit"]);
	$nom = trim($_REQUEST["nom"]);
	
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=lista_grupo_articulos.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	echo rep_tabla_grupo_articulos('',$nom,$sit); 
?>