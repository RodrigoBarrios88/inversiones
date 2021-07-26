<?php

include_once('html_fns_reportes.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//post
	$suc = trim($_REQUEST["suc"]);
	$pv = trim($_REQUEST["pv"]);
	$fini = trim($_REQUEST["desde"]);
	$ffin = trim($_REQUEST["hasta"]);
	
	$pdf=new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'REPORTE DE MOVIMIENTOS DE PUNTOS DE VENTA', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 320 ,5, 30 , 30,'JPG', '');
	
	///////////////////////////////// CAJAS MONETARIAS ////////////////////////////////////
	
	$ClsPV = new ClsPuntoVenta();
	$ClsMon = new ClsMoneda();
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$oftCamb = $row["mon_cambio"];
			$oftSimb = $row["mon_simbolo"];
		}
	}
	$pdf->Ln(5);
	////////////// LISTA PUNTOS DE VENTA ////////////////
	$result = $ClsPV->get_punto_venta($pv,$suc,'',1);
	
	if(is_array($result)){
		foreach($result as $row){
			//codigo
			$pv = $row["pv_codigo"];
			$suc = $row["pv_sucursal"];
			$sit = $row["pv_situacion"];
			$sucn = utf8_decode($row["suc_nombre"]);
			$desc = utf8_decode($row["pv_nombre"]);
		}
	}
	
			////////////////////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////// SALDO DE FECHAS ANTERIORES ////////////////////////////////////
			/////////// ENCABEZADO SECCION
			$pdf->SetFont('Arial','B',10);  
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(345,7,"SALDOS ANTERIORES",1,'','C',true);
			$pdf->Ln(10);
			
			$pdf->SetWidths(array(10, 115, 75, 80, 65));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', 'MONEDA', 'SALDO', 'TIPO/CAMBIO','CAMBIO'));
			}
		
			$pdf->SetWidths(array(10, 115, 75, 80, 65));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'L', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$result = $ClsPV->get_saldo_anterior($pv,$suc,$fini);
			$i=1;
			if(is_array($result)){
				foreach($result as $row){
					//codigo
					$simbolo = $row["mon_simbolo"];
					$moneda = utf8_decode($row["mon_desc"]);
					$ingresos = $row["ingresos"];
					$egresos = $row["egresos"];
					$tcamb = $row["mon_cambio"];
					$saldo = ($ingresos - $egresos);
					$saldo = number_format($saldo,2, '.', '');
					$cambio = Cambio_Moneda($tcamb,$oftCamb,$saldo);
					$total += $cambio;
					if($saldo >0){
						//---
						$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
						$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
						$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
						$no = $i.".";
						$cambio = number_format($cambio,2,'.','');
						$pdf->Row(array($no,$moneda,"$simbolo. $saldo","$tcamb X 1","$oftSimb. $cambio")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
						$i++;
					}
				}
				$i--;
					$pdf->SetFont('Arial','B',8);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(216,216,216);
					$pdf->Cell(280,5,'TOTAL    ',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
					$pdf->SetX(285);
					$pdf->Cell(65,5,"$oftSimb. $total",1,'','C',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
					$pdf->Ln(5);
			}else{
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(345,5,"NO SE REPORTAN SALDOS DE NINGUNA MONEDA",1,'','C',true);
				$pdf->Ln(5);
			}
			
			$pdf->Ln(5);
			
			///////////////////////////////////////MOVIMIENTOS DEL PUNTO DE VENTA ////////////////////////////////////
			/////////// ENCABEZADO SECCION
			$pdf->SetFont('Arial','B',10);  
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(345,7,"MOVIMIENTOS EN EL PERIODO",1,'','C',true);
			$pdf->Ln(10);
			
			$pdf->SetWidths(array(10, 25, 30, 20, 45, 85, 25, 25, 20, 20, 20, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', '#TRANS.', 'FECHA/HORA', 'MOVIMIENTO','MOTIVO','JUSTIFICACI�N','DOCUMENTO','MONEDA','ENTR�','SALI�','TIPO/CAMBIO','SALDO'));
			}
		
			$pdf->SetWidths(array(10, 25, 30, 20, 45, 85, 25, 25, 20, 20, 20, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'L', 'L', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$result = $ClsPV->get_mov_pv('',$pv,$suc,'','','','','',$fini,$ffin,1);
			if(is_array($result)){
				$i = 1;
				foreach($result as $row){
					//Codigo
					$cod = Agrega_Ceros($row["mpv_codigo"]);
					$pv = Agrega_Ceros($row["mpv_punto_venta"]);
					$suc = Agrega_Ceros($row["mpv_sucursal"]);
					$codigo = $cod."-".$pv."-".$suc;
					//fecha hora
					$fec = $row["mpv_fecha"];
					$fec = cambia_fechaHora($fec);
					//Movimiento
					$mov = $row["mpv_movimiento"];
					$movimiento = ($mov == "I")?"INGRESO":"EGRESO";
					//Motivo
					$mot = $row["mpv_tipo"];
					switch($mot){
						case "C": $motivo = "COMPRA"; break;
						case "RT": $motivo = "RETIRO"; break;
						case "RC": $motivo = "CORTE DE CAJA"; break;
						case "TR": $motivo = "TRASLADO A CUENTA"; break;
						case "V": $motivo = "VENTA"; break;
						case "RB": $motivo = "REMBOLSO DE FONDOS"; break;
						case "DP": $motivo = "DEPOSITO"; break;
					}
					//justificacion
					$just = utf8_decode($row["mpv_motivo"]);
					//Documento o Boucher
					$doc = $row["mpv_doc"];
					$doc = Agrega_Ceros($doc);
					//MONEDA
					$mon = $row["mon_desc"];
					///monto
					$mons = trim($row["mon_simbolo"]);
					$mov = trim($row["mpv_movimiento"]);
					$cant = $row["mpv_monto"];
					$cant = number_format($cant,2,'.','');
					if($mov == "I"){
						$entra = $cant;
						$sale = "";
					}else if($mov == "E"){
						$entra = "";
						$sale = $cant;
					}
					$Tentra+= $entra;
					$Tsale += $sale;
					//tasa cambio
					$tcamb = $row["mon_cambio"];
					//--
					$cambio = Cambio_Moneda($tcamb,$oftCamb,$cant);
					$cambio = number_format($cambio,2, '.', '');
					//--
					$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,$codigo,$fec,$movimiento,$motivo,$just,$doc,$mon,$entra,$sale,"$tcamb x 1","$mons. $cambio")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;
				}
					$i--;
			}else{
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				$pdf->Cell(345,5,"NO HAY MOVIMIENTOS",1,'','C',true);
				$pdf->Ln(5);
			}
			
			$pdf->Ln(5);
			
			/////////////////////////////////////// SALDO ACTUAL ////////////////////////////////////
			/////////// ENCABEZADO SECCION
			$pdf->SetFont('Arial','B',10);  
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(345,7,"MOVIMIENTOS EN EL PERIODO",1,'','C',true);
			$pdf->Ln(10);
			
			$pdf->SetWidths(array(10, 115, 75, 80, 65));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', 'MONEDA', 'SALDO', 'TIPO/CAMBIO','CAMBIO'));
			}
		
			$pdf->SetWidths(array(10, 115, 75, 80, 65));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'L', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$fini = "01/01/2000";
			$result = $ClsPV->get_saldo_actual($pv,$suc,$fini,$ffin);
			$i=1;
			if(is_array($result)){
				foreach($result as $row){
					//codigo
					$simbolo = $row["mon_simbolo"];
					$moneda = utf8_decode($row["mon_desc"]);
					$ingresos = $row["ingresos"];
					$egresos = $row["egresos"];
					$tcamb = $row["mon_cambio"];
					$saldo = ($ingresos - $egresos);
					$saldo = number_format($saldo,2, '.', '');
					$cambio = Cambio_Moneda($tcamb,$oftCamb,$saldo);
					$cambio = number_format($cambio,2, '.', '');
					$total += $cambio;
					if($saldo >0){
						//---
						$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
						$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
						$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
						$no = $i.".";
						$pdf->Row(array($no,$moneda,"$simbolo. $saldo","$tcamb X 1","$oftSimb. $cambio")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
						$i++;
					}
				}
				$i--;
					$pdf->SetFont('Arial','B',8);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(216,216,216);
					$pdf->Cell(280,5,'TOTAL    ',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
					$pdf->SetX(285);
					$total = number_format($total,2, '.', '');
					$pdf->Cell(65,5,"$oftSimb. $total",1,'','C',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
					$pdf->Ln(5);
			}else{
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(345,5,"NO SE REPORTAN SALDOS DE NINGUNA MONEDA",1,'','C',true);
				$pdf->Ln(5);
			}
			$pdf->Ln(5);

	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output("Movimiento de Punto de Venta $desc.pdf","I");

?>