<?php

include_once('html_fns_reportes.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//post
	$suc = trim($_REQUEST["suc"]);
	$caja = trim($_REQUEST["caja"]);
	$fini = trim($_REQUEST["desde"]);
	$ffin = trim($_REQUEST["hasta"]);
	
	$pdf=new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'REPORTE DE MOVIMIENTOS DE CAJAS MONETARIAS', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 320 ,5, 30 , 30,'JPG', '');
	
	$pdf->Ln(5);
	
	
///////////////////////////////// CAJAS MONETARIAS ////////////////////////////////////
	
	$ClsCaj = new ClsCaja();
	$result = $ClsCaj->get_caja($caja,$suc);
	
	if(is_array($result)){
		foreach($result as $row){
			$caja = $row["caja_codigo"];
			$desc = utf8_decode($row["caja_descripcion"]);
		}
	}	
		
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
			
			$result = $ClsCaj->get_mov_caja("",$caja,$suc,'','','','',$fini,$ffin,1);
			
			if(is_array($result)){
				$saldo = $ClsCaj->get_saldo_anterior($caja,$suc,$fini);
				$i=1;
				$Tentra = 0;
				$Tsale = 0;
				foreach($result as $row){
					if ($i == 1){ //--
						$mons = trim($row["mon_simbolo"]);	
						$pdf->SetWidths(array(255, 30, 30, 30));  
						$pdf->SetAligns(array('C', 'C', 'C', 'C')); 
						for($i=0;$i<1;$i++){
							$pdf->Row(array('SALDO DE OPERACIONES ANTERIORES', '', '', $mons.'. '.$saldo));
						}
						$pdf->SetWidths(array(10, 20, 30, 35, 40, 80, 40, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
						$pdf->SetAligns(array('C', 'C', 'C', 'C', 'L', 'L', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					} //--
					//--
					$mons = trim($row["mon_simbolo"]);
					//Codigo
					$cod = Agrega_Ceros($row["mcj_codigo"]);
					$caj = Agrega_Ceros($row["mcj_caja"]);
					$suc = Agrega_Ceros($row["mcj_sucursal"]);
					$codigo = $cod."-".$caj."-".$suc;
					//fecha hora
					$fec = $row["mcj_fecha"];
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
					$just = $row["mcj_motivo"];
					//Documento o Boucher
					$doc = $row["mcj_doc"];
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
					$saldo = round($saldo,4);
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
			}
			$pdf->Ln(5);
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output("Movimiento de Caja $desc.pdf","I");

?>