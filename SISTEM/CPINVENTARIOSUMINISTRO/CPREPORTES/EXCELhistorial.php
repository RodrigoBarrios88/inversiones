<?php
include_once("html_fns_reportes.php");
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//post
	$tipo = trim($_REQUEST["tipo"]);
	$clase = trim($_REQUEST["clase"]);
	$doc = trim($_REQUEST["doc"]);
	$suc = trim($_REQUEST["suc"]);
	$fini = trim($_REQUEST["fini"]);
	$ffin = trim($_REQUEST["ffin"]);

	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=historial_inventario.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	echo rep_tabla_historiales_inventario('',$tipo,$clase,$doc,$suc,$fini,$ffin,''); 
?>