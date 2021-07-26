<?php
include_once('html_fns_boleta.php');
$usuario = $_SESSION["codigo"];
$nombre = $_SESSION["nombre"];
$empresa = $_SESSION["empresa"];
$empCodigo = $_SESSION["empCodigo"];
$pensum = $_SESSION["pensum"];
$pensum = $_SESSION["pensum"];
///--
$ClsFac = new ClsFactura();
$ClsBol = new ClsBoletaCobro();

//$_REQUEST
$carga = $_REQUEST["carga"];
$mon = $_REQUEST["mon"];
$suc = $_REQUEST["suc"];
$pv = $_REQUEST["pv"];
$fecha = $_REQUEST["fecha"];

	
$ClsBol = new ClsBoletaCobro();
$result = $ClsBol->get_pagos_de_carga($carga);
if(is_array($result)){
  $fecha = date("Y-m-d");
	$fecha = str_replace("-","",$fecha);
  $file = fopen("Facturas_Electronicas".$fecha."_$carga.txt", "w");
  $i = 1;
	foreach($result as $row){
		if($row["alu_cui"] != ""){
			$comprueba_alumno = $row["alu_cui"];
			$cliente = $row["alu_cliente_factura"];
		}else if($row["alu_inscripciones_cui"] != ""){ //comprueba existencia de alumno (en modulo de inscripciones / no activo en el sistema)
			$comprueba_alumno = $row["alu_inscripciones_cui"];
			$cliente = $row["alu_inscripciones_cliente_factura"];
		}else{
			$comprueba_alumno = "";
		}
		/// si reconoce al alumno lo agrega al listado, si no, NO
		if($comprueba_alumno != ""){
         ////-- Comprobaciones
         $iconos = "";
         $facturado = $row["pag_facturado"]; ///0->Pendiente de Factura o recibo, 1->Facturado, 2->Recibo
         $referencia = $row["pag_referencia"];
         $cuenta = $row["pag_cuenta"];
         $banco = $row["pag_banco"];
         $alumno = $row["pag_alumno"];
         $nit = trim($row["alu_nit"]);
         $monto_total = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
         $motivo = utf8_decode($row["bol_motivo"]);
         $motivo = ($motivo == "")?"Pago no programdo":$motivo;
         $motivo = depurador_texto($motivo);
         $motivo = strtoupper($motivo);
         $tipo = trim($row["bol_tipo"]);
         $tipo = ($tipo == "V")?"P":"S";
         //--comprueba
         $codpago = $row["pag_codigo"];
         $comprueba_boleta = $row["bol_referencia"];
         $cliente = ($cliente == "")?0:$cliente;
         //monto
         $saldo = floatval($row["bol_monto"]); /// monto registrado en la boleta, ya con descuento
         $descuento = floatval($row["bol_descuento"]); // descuento de la boleta
         //--
         $monto = ($saldo + $descuento); // monto sin descuento
         $precio = number_format($saldo, 4, '.','');
         $monto_corto = number_format($monto, 2, '.','');
         $monto_sin_iva = ($saldo / 1.12);
         $iva = ($saldo - $monto_sin_iva);
         //descuento
         $descuento_largo = number_format($descuento, 4, '.',',');
         $descuento_corto = number_format($descuento, 2, '.',',');
         //saldo
         $correlativo = Agrega_Ceros_Largo($i);
         fwrite($file, "1|$fecha|FACE|$nit|1|1|$correlativo|$tipo|1|N" . PHP_EOL);
         fwrite($file, "2|1|1|$precio|0|$descuento_largo|$monto_corto|0.00|$monto_sin_iva|$iva|0.00|$monto_corto|1|$motivo" . PHP_EOL);
         fwrite($file, "4|$monto|$descuento_largo|0.00|$monto_sin_iva|$iva|0.00|$monto_corto|0|0|1|0" . PHP_EOL);
         //--
         $i++;
		}	
	}
	$i--; //quita la ultima fila para cuadrar cantidades
	fclose($file);
	$path = "Facturas_Electronicas".$fecha."_".$carga.".txt";
	header("Content-Type: text/plain");
	header('Content-Disposition: attachment; filename="'.$path.'"');
	header ("Content-Length: ".filesize($path));
	readfile($path);
	
	unlink($path);
}
	

?>