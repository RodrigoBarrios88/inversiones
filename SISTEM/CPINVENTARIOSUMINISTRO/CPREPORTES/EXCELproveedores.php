<?php
include_once("html_fns_reportes.php");
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//post
	$nit = trim($_REQUEST["nit"]);
	$nom = trim($_REQUEST["nom"]);
	$contac = trim($_REQUEST["contac"]);
	
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=lista_proveedores.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	echo rep_tabla_proveedores($nom,$contact,$pred,$sit);
?>