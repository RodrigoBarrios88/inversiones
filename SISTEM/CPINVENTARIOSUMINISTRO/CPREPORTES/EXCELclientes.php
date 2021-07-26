<?php
include_once("html_fns_reportes.php");
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//post
	$nom = trim($_REQUEST["nom"]);
	$nit = trim($_REQUEST["nit"]);
	
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=lista_clientes.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	echo rep_tabla_clientes($nit,$nom);
?>