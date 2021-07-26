<?php

include_once('../../html_fns.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//post
	$suc = trim($_REQUEST["suc"]);
	$pv = trim($_REQUEST["pv"]);
	
	$pdf=new PDF('L','mm','Letter');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'REPORTE DE SALDOS EN PUNTOS DE VENTA', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 245 ,5, 30 , 30,'JPG', '');
	
	$pdf->Ln(10);
	
	$ClsPV = new ClsPuntoVenta();
	$ClsMon = new ClsMoneda();
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$oftCamb = $row["mon_cambio"];
			$oftSimb = $row["mon_simbolo"];
		}
	}
	
	
	////////////// LISTA PUNTOS DE VENTA ////////////////
	$result = $ClsPV->get_punto_venta($pv,$suc,'',1);
	
	if(is_array($result)){
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$pv = $row["pv_codigo"];
			$suc = $row["pv_sucursal"];
			$sit = $row["pv_situacion"];
			$sucn = $row["suc_nombre"];
			$desc = $row["pv_nombre"];
			
			/////////// ENCABEZADO DEL PUNTO DE VENTA
			$pdf->SetFont('Arial','B',8);  
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(270,5,"$desc. EMPRESA: $sucn.",1,'','C',true);
			$pdf->Ln(10);
			
			////////////////////////////////////////////////////////////////////////////////////////////////////////
			$pdf->SetWidths(array(10, 110, 45, 60, 45));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', 'MONEDA', 'SALDO', 'TIPO/CAMBIO','CAMBIO'));
			}
		
			$pdf->SetWidths(array(10, 110, 45, 60, 45));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'L', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			////////////// INICIALIZACION ////////////////
			$total = 0;
			$fini = "01/01/2000";
			$ffin = date("d/m/Y");
			$result = $ClsPV->get_saldo_actual($pv,$suc,$fini,$ffin);
			
			$i=1;
			if(is_array($result)){
				foreach($result as $row){
					$salida.= '<tr>';
					//codigo
					$simbolo = $row["mon_simbolo"];
					$moneda = $row["mon_desc"];
					$ingresos = $row["ingresos"];
					$egresos = $row["egresos"];
					$tcamb = $row["mon_cambio"];
					$saldo = ($ingresos - $egresos);
					$saldo = number_format($saldo,2,'.','');
					$cambio = Cambio_Moneda($tcamb,$oftCamb,$saldo);
					$total += $cambio;
					if($saldo >0){
						//---
						$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
						$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
						$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
						$no = $i.".";
						$cambio = number_format($cambio,2,'.','');
						$pdf->Row(array($no,$moneda,"$simbolo. $saldo",$tcamb,"$oftSimb. $cambio")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
						$i++;
					}
				}
				$i--;
					$pdf->SetFont('Arial','B',8);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(216,216,216);
					$pdf->Cell(225,5,'TOTAL    ',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
					$pdf->SetX(230);
					$total = number_format($total,2,'.','');
					$pdf->Cell(45,5,"$oftSimb. $total",1,'','C',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
			}else{
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(270,5,"NO SE REPORTAN SALDOS DE NINGUNA MONEDA",1,'','C',true);
			}
			$pdf->Ln(10);
		}
	}else{
		$pdf->SetFont('Arial','B',8);  
		$pdf->SetFillColor(216,216,216);
		$pdf->Cell(270,5,"NO SE REPORTAN PUNTOS DE VENTA CON ESTOS CRITERIOS DE SELECCION",1,'','C',true);
	}
	
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>