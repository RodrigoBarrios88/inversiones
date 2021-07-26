<?php

include_once('../html_fns.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//post
	$suc = trim($_REQUEST["suc"]);
	$tipo = trim($_REQUEST["tipo"]);
	$pv = trim($_REQUEST["pv"]);
	$fini = trim($_REQUEST["desde"]);
	$ffin = trim($_REQUEST["hasta"]);
	//--
	$suc = ($suc != "")?$suc:$empCodigo;
	
	$pdf=new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'CIERRE DE CAJAS Y PUNTOS DE VENTA', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Periodo: '.$fini.' - '.$ffin, 0 , 'L' , 0);
	$pdf->Image('../../CONFIG/images/replogo.jpg' , 310 ,5, 40 , 30,'JPG', '');
	
	$pdf->Ln(5);
	
	
if($tipo == "C" || $tipo == "T"){ //--valida que el tipo incluya listar los movimientos de caja
///////////////////////////////// CAJAS MONETARIAS ////////////////////////////////////
	
	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'MOVIMIENTOS DE CAJAS MONETARIAS', 'B' , 'L' , 0);
	$pdf->Ln(5);
	
	$ClsCaj = new ClsCaja();
	$result = $ClsCaj->get_caja('',$suc);
	
	if(is_array($result)){
		foreach($result as $row){
			$cajacod = $row["caja_codigo"];
			$desc = utf8_decode($row["caja_descripcion"]);
			//--
			$pdf->SetFont('Arial','B',10);  
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(345,5,$desc,1,'','C',true);	// TITULO DE LA CAJA
			$pdf->Ln(5);
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
			
			$pdf->SetWidths(array(10, 20, 30, 35, 40, 80, 40, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', '#TRANS.', 'FECHA/HORA', 'MOVIMIENTO','MOTIVO','JUSTIFICACI�N','DOCUMENTO','ENTR�','SALI�','SALDO'));
			}
		
			$pdf->SetWidths(array(10, 20, 30, 35, 40, 80, 40, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'L', 'L', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$result = $ClsCaj->get_mov_caja("",$cajacod,$suc,'','','','',$fini,$ffin,1);
			$saldo = $ClsCaj->get_saldo_anterior($cajacod,$suc,$fini);
			if(is_array($result)){
				$i=1;
				$Tentra = 0;
				$Tsale = 0;
				foreach($result as $row){
					if ($i == 1){ //--
						$mons = trim($row["mon_simbolo"]);	
						$pdf->SetWidths(array(255, 30, 30, 30));  
						$pdf->SetAligns(array('C', 'C', 'C', 'C')); 
						for($i=0;$i<1;$i++){
							$pdf->Row(array('SALDO DE OPERACIONES ANTERIORES', '', '', $mons.'. '.number_format($saldo,2,'.','')));
						}
						$pdf->SetWidths(array(10, 20, 30, 35, 40, 80, 40, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
						$pdf->SetAligns(array('C', 'C', 'C', 'C', 'L', 'L', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					} //--
					//--
					$mons = trim($row["mon_simbolo"]);
					//Codigo
					$cod = Agrega_Ceros($row["mcj_codigo"]);
					$ccod = Agrega_Ceros($row["mcj_caja"]);
					$scod = Agrega_Ceros($row["mcj_sucursal"]);
					$codigo = $cod."-".$ccod."-".$scod;
					//fecha hora
					$fec = $row["mcj_fechor"];
					$fec = cambia_fechaHora($fec);
					//Movimiento
					$mov = $row["mcj_movimiento"];
					$movimiento = ($mov == "I")?"CREDITO":"DEBITO";
					//Motivo
					$mot = $row["mcj_tipo"];
					switch($mot){
						case "C": $mot = "COMPRA"; break;
						case "RT": $mot = "RETIRO"; break;
						case "TR": $mot = "TRASLADO A CUENTA"; break;
						case "RB": $mot = "REMBOLSO DE FONDOS"; break;
						case "DP": $mot = "DEPOSITO"; break;
					}
					//justificacion
					$just = utf8_decode($row["mcj_motivo"]);
					//Documento o Boucher
					$doc = utf8_decode($row["mcj_doc"]);
					///monto
					$mons = trim($row["mon_simbolo"]);
					$mov = trim($row["mcj_movimiento"]);
					$cant = number_format($row["mcj_monto"],2,'.','');
					if($mov == "I"){
						$entra = $cant;
						$sale = "";
						$saldo += $entra;
					}else if($mov == "E"){
						$entra = "";
						$sale = $cant;
						$saldo -=  $sale;
					}
					$saldo = number_format($saldo,2,'.','');
					$Tentra+= $entra;
					$Tsale += $sale;
					//---
					$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,$codigo,$fec,$movimiento,$mot,$just,$doc,$entra,$sale,$saldo)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
				}
				$i--;
				//$pdf->Ln(5);
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(216,216,216);
				/// Total Ingresos
				$pdf->SetWidths(array(255, 30, 60));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$Tentra = number_format($Tentra,2,'.','');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('TOTAL DE INGRESOS  ', $mons.'. '.$Tentra, ''));
				}
				//$pdf->Ln(5);
				/// Total Egresos
				$pdf->SetWidths(array(255, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$Tsale = number_format($Tsale,2,'.','');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('TOTAL DE EGRESOS  ', '', $mons.'. '.$Tsale,''));
				}
				//$pdf->Ln(5);
				/// Total Egresos
				$pdf->SetWidths(array(255, 60, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$saldo = number_format($saldo,2,'.','');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('SALDO  ', '', $mons.'. '.$saldo));
				}
				//$pdf->Ln(5);
			}else{
			    //--
			    $mons = trim($row["mon_simbolo"]);	
				$pdf->SetWidths(array(255, 30, 30, 30));  
				$pdf->SetAligns(array('C', 'C', 'C', 'C')); 
				for($i=0;$i<1;$i++){
				$pdf->Row(array('SALDO DE OPERACIONES ANTERIORES', '', '', $mons.'. '.$saldo));
				}
			    //--
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(345,5,"NO HAY MOVIMIENTOS",1,'','C',true);
				$pdf->Ln(5);
				//--
				$pdf->SetFillColor(216,216,216);
			    $mons = trim($row["mon_simbolo"]);	
				$pdf->SetWidths(array(255, 30, 30, 30));  
				$pdf->SetAligns(array('R', 'C', 'C', 'C')); 
				for($i=0;$i<1;$i++){
				$pdf->Row(array('SALDO    ', '0', '0', $mons.'. '.$saldo));
				}
			    //--
				
			}
			$pdf->Ln(5);
		}	
	}
	
	$pdf->AddPage();
}	


if($tipo == "P" || $tipo == "T"){ //--valida que el tipo incluya listar los movimientos de punto de venta
///////////////////////////////// PUNTOS DE VENTA ////////////////////////////////////
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'MOVIMIENTOS DE PUNTOS DE VENTA', 'B' , 'L' , 0);
	$pdf->Ln(5);
	
	$ClsPV = new ClsPuntoVenta();
	$ClsMon = new ClsMoneda();
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$oftCamb = $row["mon_cambio"];
			$oftSimb = $row["mon_simbolo"];
			$oftDesc = $row["mon_desc"];
		}
	}
	
	////////////// LISTA PUNTOS DE VENTA ////////////////
	$result = $ClsPV->get_punto_venta($pv,$suc,'',1);
	
	if(is_array($result)){
		foreach($result as $row){
			//codigo
			$pvcod = $row["pv_codigo"];
			$succod = $row["pv_sucursal"];
			$sit = $row["pv_situacion"];
			$sucn = utf8_decode($row["suc_nombre"]);
			$desc = utf8_decode($row["pv_nombre"]);
			
			/////////// ENCABEZADO DEL PUNTO DE VENTA
			$pdf->SetFont('Arial','B',12);  
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(345,10,"PUNTO DE VENTA: $desc",'B','','C',true);
			$pdf->Ln(10);
	
	
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
				$pdf->Row(array('No.', 'MONEDA', 'SALDO', 'TIPO/CAMBIO','MONTO'));
			}
		
			$pdf->SetWidths(array(10, 115, 75, 80, 65));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'L', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$result = $ClsPV->get_saldo_anterior($pvcod,$succod,$fini);
			$i=1;
			$total = 0;
			if(is_array($result)){
				foreach($result as $row){
					//codigo
					$simbolo = $row["mon_simbolo"];
					$moneda = $row["mon_desc"];
					$ingresos = $row["ingresos"];
					$egresos = $row["egresos"];
					$tcamb = $row["mon_cambio"];
					$saldo = ($ingresos - $egresos);
					$saldo = number_format($saldo,2,'.','');
					$cambio = Cambio_Moneda($tcamb,$oftCamb,$saldo);
					$cambio = number_format($cambio,2,'.','');
					$total += $cambio;
					if($saldo >0){
						//---
						$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
						$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
						$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
						$no = $i.".";
						$pdf->Row(array($no,$moneda,"$simbolo. $saldo",$tcamb,"$oftSimb. $cambio")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
						$i++;
					}
				}
				$i--;
					$pdf->SetFont('Arial','B',8);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(216,216,216);
					$pdf->Cell(280,5,'TOTAL    ',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
					$pdf->SetX(285);
					$total = number_format($total,2,'.','');
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
			
			$result = $ClsPV->get_mov_pv('',$pvcod,$succod,'','','','','',$fini,$ffin,1);
			if(is_array($result)){
				$i = 1;
				foreach($result as $row){
					//Codigo
					$cod = Agrega_Ceros($row["mpv_codigo"]);
					$pcod = Agrega_Ceros($row["mpv_punto_venta"]);
					$scod = Agrega_Ceros($row["mpv_sucursal"]);
					$codigo = $cod."-".$pcod."-".$scod;
					//fecha hora
					$fec = $row["mpv_fechor"];
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
					$mon = utf8_decode($row["mon_desc"]);
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
					$cambio = number_format($cambio,2,'.','');
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
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(345,5,"NO HAY MOVIMIENTOS",1,'','C',true);
				$pdf->Ln(5);
			}
			
			$pdf->Ln(5);
			
			/////////////////////////////////////// SALDO ACTUAL ////////////////////////////////////
			/////////// ENCABEZADO SECCION
			$pdf->SetFont('Arial','B',10);  
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(345,7,"SALDOS ACTUALES",1,'','C',true);
			$pdf->Ln(10);
			
			$pdf->SetWidths(array(10, 115, 75, 80, 65));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', 'MONEDA', 'SALDO', 'TIPO/CAMBIO','MONTO'));
			}
		
			$pdf->SetWidths(array(10, 115, 75, 80, 65));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'L', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$fec0 = "01/01/2000";
			$result = $ClsPV->get_saldo_actual($pvcod,$succod,$fec0,$ffin);
			$i=1;
			$total = 0;
			if(is_array($result)){
				foreach($result as $row){
					//codigo
					$simbolo = $row["mon_simbolo"];
					$moneda = utf8_decode($row["mon_desc"]);
					$ingresos = $row["ingresos"];
					$egresos = $row["egresos"];
					$tcamb = $row["mon_cambio"];
					$saldo = ($ingresos - $egresos);
					$saldo = number_format($saldo,2,'.','');
					$cambio = Cambio_Moneda($tcamb,$oftCamb,$saldo);
					$cambio = number_format($cambio,2,'.','');
					$total += $cambio;
					if($saldo >0){
						//---
						$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
						$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
						$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
						$no = $i.".";
						$pdf->Row(array($no,$moneda,"$simbolo. $saldo",$tcamb,"$oftSimb. $cambio")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
						$i++;
					}
				}
				$i--;
					$pdf->SetFont('Arial','B',8);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(216,216,216);
					$pdf->Cell(280,5,'TOTAL    ',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
					$pdf->SetX(285);
					$total = number_format($total,2,'.','');
					$pdf->Cell(65,5,"$oftSimb. $total",1,'','C',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
					$pdf->Ln(5);
			}else{
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(345,5,"NO SE REPORTAN SALDOS DE NINGUNA MONEDA",1,'','C',true);
				$pdf->Ln(5);
			}
			$pdf->Ln(5);
		}
	}
	
	$pdf->AddPage();
}	
	
	///////////////////////////////// PAGOS CON TARJETA ////////////////////////////////////
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'PAGOS CON TARJETA', 'B' , 'L' , 0);
	$pdf->Ln(5);
	
		// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
			
			$pdf->SetWidths(array(10, 20, 30, 25, 70, 70, 35, 35, 25, 25));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', '#TRANS.', 'FECHA/HORA', 'VENTA','EMPRESA','PUNTO DE VENTA','OPERADOR','BOUCHER','MONTO','TIPO/CAMBIO'));
			}
		
			$pdf->SetWidths(array(10, 20, 30, 25, 70, 70, 35, 35, 25, 25));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'L', 'L', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$ClsVntCred = new ClsVntCredito();
			$result = $ClsVntCred->get_cobro_creditos_pv('','',$suc,$pv,2,'','',$fini,$ffin,'1,2');
			
			if(is_array($result)){
				$total = 0;
				foreach($result as $row){
					//codigo
					$sit = $row["ven_situacion"];
					$ccred = $row["ccred_codigo"];
					$ven = $row["ven_codigo"];
					$Vtcamb = $row["ven_tcambio"];
					$Vmons = $row["mon_simbolo"];
					//Codigo
					$ccred = Agrega_Ceros($ccred);
					$ven = Agrega_Ceros($ven);
					//Fecha / Hora
					$fec = $row["ccred_fechor_venta"];
					$fec = cambia_fechaHora($fec);
					//empresa
					$sucn = $row["suc_nombre"];
					//punto de venta
					$pvn = utf8_decode($row["pv_nombre"]);
					//Operador
					$opera = $row["ccred_operador"];
					//Doc
					$doc = $row["ccred_boucher"];
					//monto
					$monto = $row["ccred_monto"];
					$mons = $row["mon_simbolo"];
					//cambio
					$camb = $row["ccred_tcambio"];
					//---
					$cambio = Cambio_Moneda($camb,$oftCamb,$monto);
					$total+=$cambio;
					$monto = number_format($monto,2,'.','');
					//--
					$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,"$ccred-$ven",$fec,$ven,$sucn,$pvn,$opera,$doc,"$mons. $monto","$camb x 1")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
				}
				$i--;
					$pdf->SetFont('Arial','B',6);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(216,216,216);
					$pdf->Cell(295,5,"TOTAL  ",1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
					$pdf->SetX(300);
					$total = number_format($total,2,'.',',');
					$pdf->Cell(25,5,"$oftSimb. $total",1,'','C',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
					$pdf->SetX(325);
					$pdf->Cell(25,5,"$oftDesc",1,'','C',true);
					$pdf->Ln(5);
			}
			$pdf->Ln(5);
			
	///////////////////////////////// PAGOS CON CHEQUE ////////////////////////////////////
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'PAGOS CON CHEQUE', 'B' , 'L' , 0);
	$pdf->Ln(5);
	
		// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
			
			$pdf->SetWidths(array(10, 20, 30, 25, 70, 70, 35, 35, 25, 25));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', '#TRANS.', 'FECHA/HORA', 'VENTA','EMPRESA','PUNTO DE VENTA','BANCO','CHEQUE','MONTO','TIPO/CAMBIO'));
			}
		
			$pdf->SetWidths(array(10, 20, 30, 25, 70, 70, 35, 35, 25, 25));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'L', 'L', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$ClsVntCred = new ClsVntCredito();
			$result = $ClsVntCred->get_cobro_creditos_pv('','',$suc,$pv,4,'','',$fini,$ffin,'1,2');
			
			if(is_array($result)){
				foreach($result as $row){
					//codigo
					$sit = $row["ven_situacion"];
					$ccred = $row["ccred_codigo"];
					$ven = $row["ven_codigo"];
					$Vtcamb = $row["ven_tcambio"];
					$Vmons = $row["mon_simbolo"];
					//Codigo
					$ccred = Agrega_Ceros($ccred);
					$ven = Agrega_Ceros($ven);
					//Fecha / Hora
					$fec = $row["ccred_fechor_venta"];
					$fec = cambia_fechaHora($fec);
					//empresa
					$sucn = $row["suc_nombre"];
					//punto de venta
					$pvn = $row["pv_nombre"];
					//Operador
					$opera = $row["ccred_operador"];
					//Doc
					$doc = $row["ccred_boucher"];
					//monto
					$tot = $row["ccred_monto"];
					$mons = $row["mon_simbolo"];
					//cambio
					$camb = $row["ccred_tcambio"];
					//---
					$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,"$ccred-$ven",$fec,$ven,$sucn,$pvn,$opera,$doc,"$mons. $tot","$camb x 1")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
				}
				$i--;
			}
			$pdf->Ln(5);
			
	///////////////////////////////// CREDITOS POR COBRAR ////////////////////////////////////
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'CR�DITOS POR COBRAR', 'B' , 'L' , 0);
	$pdf->Ln(5);
	
		// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
			
			$pdf->SetWidths(array(10, 20, 30, 25, 60, 45, 35, 70, 25, 25));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', '#TRANS.', 'FECHA/HORA', 'VENTA','PUNTO DE VENTA','AUTORIZ�','DOCUMENTO','OBSERVACIONES','MONTO','TIPO/CAMBIO'));
			}
		
			$pdf->SetWidths(array(10, 20, 30, 25, 60, 45, 35, 70, 25, 25));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'L', 'L', 'C', 'J', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$ClsCred = new ClsCredito();
			$result = $ClsCred->get_credito_venta_pv('','',$suc,$pv,$fini,$ffin,1);
			
			if(is_array($result)){
				foreach($result as $row){
					//Codigo
					$cod = trim($row["cred_codigo"]);
					$vent = Agrega_Ceros($row["cred_venta"]);
					$codigo = Agrega_Ceros($row["cred_codigo"])."-".Agrega_Ceros($row["cred_venta"]);
					//fecha hora
					$fec = $row["cred_fechor"];
					$fec = cambia_fechaHora($fec);
					//empresa
					$sucn = utf8_decode($row["suc_nombre"]);
					//punto de venta
					$pvn = utf8_decode($row["pv_nombre"]);
					//Operador o Banco
					$opera = utf8_decode($row["cred_operador"]);
					//Documento o Boucher
					$doc = utf8_decode($row["cred_doc"]);
					//observaciones
					$obs = utf8_decode($row["cred_obs"]);
					$salida.= '<td class = "text-justify">'.$obs.'</td>';
					//monto
					$mont = $row["cred_monto"];
					$mons = $row["mon_simbolo"];
					$moncamb = $row["mon_cambio"];
					$monto = $mons.". ".number_format($mont,2,'.','');
					//cambio
					$camb = $row["cred_tcambio"];
					//---
					$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,"CRED-$codigo",$fec,$vent,$pvn,$opera,$doc,$obs,$monto,"$camb x 1")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
				}
				$i--;
			}
			$pdf->Ln(5);
	
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output("Cierre Diario.pdf","I");

?>