<?php
include_once("html_fns_cierre.php");
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//post
	$suc = trim($_REQUEST["suc"]);
	$pv = trim($_REQUEST["pv"]);
	$fini = trim($_REQUEST["fini"]);
	$ffin = trim($_REQUEST["ffin"]);
	
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=cierre_diario.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

			echo "<h2>Movimientos de Caja</h2>";
			echo rep_tabla_movimientos_cajas($suc,$fini,$ffin);
			echo "<br><hr><br>";
			echo "<h2>Movimientos de Puntos de Venta</h2>";
			echo rep_tabla_movimientos_pv($pv,$suc,$fini,$ffin);
			echo "<br><hr><br>";
			echo "<h2>Pagos con Tarjeta</h2>";
			echo rep_tabla_cuentas_x_cobrar($pv,$suc,2,$fini,$ffin);
			echo "<br><hr><br>";
			echo "<h2>Pagos con Cheques</h2>";
			echo rep_tabla_cuentas_x_cobrar($pv,$suc,4,$fini,$ffin);
			echo "<br><hr><br>";
			echo "<h2>Creditos por Cobrar</h2>";
			echo rep_tabla_creditos_x_cobrar($pv,$suc,$fini,$ffin);
			echo "<br><hr><br>";
?>
