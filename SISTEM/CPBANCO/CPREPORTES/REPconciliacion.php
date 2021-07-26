<?php

include_once('html_fns_reportes.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//post
	$ban = trim($_REQUEST["ban"]);
	$cue = trim($_REQUEST["cue"]);
	$fini = trim($_REQUEST["desde"]);
	$ffin = trim($_REQUEST["hasta"]);
	
	$pdf=new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'REPORTE DE CONCILIACI�N BANCARIA', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 320 ,5, 30 , 30,'JPG', '');
	$pdf->Ln(5);
	
	////////////// DATOS DE LA CUENTA DE BANCO ////////////////
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_cuenta_banco($cue,$ban,'','','','',1);
	
	if(is_array($result)){
		foreach($result as $row){
			//numero de cuenta
			$num = utf8_decode($row["cueb_ncuenta"]);
			//banco
			$bann = utf8_decode($row["ban_desc_lg"]);
			//tipo de Cuenta
			$tipo = utf8_decode($row["tcue_desc_lg"]);
			//Moneda
			$moneda = utf8_decode($row["mon_desc"]);
			$mons = $row["mon_simbolo"];
		}
	}
		
			////////////////////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////// DATOS DE LA CUENTA DE BANCO ////////////////////////////////////
			/////////// ENCABEZADO SECCION
			//--
				$pdf->SetFont('Arial','B',10);  
				$pdf->SetFillColor(216,216,216);
				$pdf->Cell(345,5,"$tipo No.: $num DE $bann.   Moneda: $moneda",1,'','C',true);	// TITULO DE LA CAJA
				$pdf->Ln(10);
			//--
			
			///////////////////////////////////////MOVIMIENTOS DEL PUNTO DE VENTA ////////////////////////////////////
			/////////// ENCABEZADO SECCION
			$pdf->SetFont('Arial','B',10);  
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(345,7,"MOVIMIENTOS EN EL PERIODO",1,'','C',true);
			$pdf->Ln(10);
			
			$pdf->SetWidths(array(10, 25, 30, 30, 50, 85, 25, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', '#TRANS.', 'FECHA/HORA', 'MOVIMIENTO','MOTIVO','JUSTIFICACI�N','DOCUMENTO','ENTR�','SALI�','SALDO'));
			}
			
			/////////////////////////////////////// SALDO DE FECHAS ANTERIORES ////////////////////////////////////
			$saldo = $ClsBan->get_saldo_anterior($cue,$ban,$fini);
			$saldo = number_format($saldo,2,'.','');
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(255,5,"SALDO DE OPERACIONES ANTERIORES",1,'','C',true);
			$pdf->Cell(30,5,"",1,'','C',true);
			$pdf->Cell(30,5,"",1,'','C',true);
			$pdf->Cell(30,5,"$mons. $saldo",1,'','C',true);
			$pdf->Ln(5);
			
			$pdf->SetWidths(array(10, 25, 30, 30, 50, 85, 25, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'L', 'L', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$result = $ClsBan->get_mov_cuenta("",$cue,$ban,'','','','',$fini,$ffin,1);
			if(is_array($result)){
				$i = 1;
				foreach($result as $row){
					//Codigo
					$cod = Agrega_Ceros($row["mcb_codigo"]);
					$cue = Agrega_Ceros($row["mcb_cuenta"]);
					$ban = Agrega_Ceros($row["mcb_banco"]);
					$codigo = $cod."-".$cue."-".$ban;
					//fecha hora
					$fec = $row["mcb_fechor"];
					$fec = cambia_fechaHora($fec);
					//Movimiento
					$mov = $row["mcb_movimiento"];
					$movimiento = ($mov == "I")?"CREDITO":"DEBITO";
					//Motivo
					$tipo = $row["mcb_tipo"];
					$tipo = "FI";
					switch($tipo){
						case "TD": $tipo = "TARJETA DEBITO"; break;
						case "CH": $tipo = "CHEQUE"; break;
						case "RT": $tipo = "RETIRO"; break;
						case "FI": $tipo = "FIN DE INVERSI�N"; break;
						case "DI": $tipo = "DES-INVERSI�N"; break;
						case "DP": $tipo = "DEPOSITO"; break;
						case "IN": $tipo = "INTERESES"; break;
						case "IV": $tipo = "INVERSI�N"; break;
					}
					//justificacion
					$just = utf8_decode($row["mcb_motivo"]);
					//Documento o Boucher
					$doc = utf8_decode($row["mcb_doc"]);
					$doc = Agrega_Ceros($doc);
					//MONEDA
					$mon = $row["mon_desc"];
					///monto
					$mons = trim($row["mon_simbolo"]);
					$mov = trim($row["mcb_movimiento"]);
					$cant = number_format($row["mcb_monto"],2,'.','');
					if($mov == "I"){
						$entra = $cant;
						$sale = "";
						$saldo += $entra;
					}else if($mov == "E"){
						$entra = "";
						$sale = $cant;
						$saldo -=  $sale;
					}
					$Tentra+= $entra;
					$Tsale += $sale;
					$saldo = number_format($saldo,2, '.', '');
					//--
					$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,$codigo,$fec,$movimiento,$tipo,$just,$doc,"$entra","$sale","$saldo")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;
				}
				$i--;
				//$pdf->Ln(5);
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(216,216,216);
				/// Total Ingresos
				$pdf->SetWidths(array(255, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$Tentra = number_format($Tentra,2,'.','');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('', "$mons $Tentra","$mons $Tsale","$mons $saldo"));
				}
			
					
			}else{
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(216,216,216);
				$pdf->Cell(345,5,"NO HAY MOVIMIENTOS",1,'','C',true);
				$pdf->Ln(5);
			}
			
			/////////////////////////////////////// LINEA EN BLANCO ////////////////////////////////////
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,5,"",1,'','C',true);
			$pdf->Ln(5);
			
			/////////////////////////////////////// CHEQUES ////////////////////////////////////
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,5,"CHEQUES EN CIRCULACI�N",1,'','C',true);
			$pdf->Ln(5);
			
			$pdf->SetWidths(array(10, 25, 30, 30, 50, 85, 25, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'L', 'L', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			///////----------------
			$saldoProyect =  $saldo;
			/////______
			$result2 = $ClsBan->get_cheque("",$cue,$ban,'','',$fini,$ffin,1);
			if(is_array($result2)){
				$sale =  0;
				$CheqCircula =  0;
				foreach($result2 as $row){
					//Codigo
					$cod = Agrega_Ceros($row["che_codigo"]);
					$cue = Agrega_Ceros($row["cueb_codigo"]);
					$ban = Agrega_Ceros($row["ban_codigo"]);
					$codigo = $cod."-".$cue."-".$ban;
					//fecha hora
					$fec = $row["che_fechor"];
					$fec = cambia_fechaHora($fec);
					//Movimiento
					$movimiento = "DEBITO";
					//Motivo
					$tipo = "CHEQUE";
					//justificacion
					$quien = utf8_decode($row["che_quien"]);
					$concepto = utf8_decode($row["che_concepto"]);
					$just = "($quien) $concepto";
					//Documento o Boucher
					$doc = utf8_decode($row["che_ncheque"]);
					//MONEDA
					$mon = $row["mon_desc"];
					///monto
					$cant = $row["che_monto"];
					$sale = number_format($cant,2,'.','');
					$saldoProyect -=  $sale;
					$saldoProyect = number_format($saldoProyect,2,'.','');
					$Tsale += $sale;
					$CheqCircula += $sale;
					//--
					$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,$codigo,$fec,$movimiento,$tipo,$just,$doc,"","$sale","$saldoProyect")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;
				}
					$i--;
			}else{
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(216,216,216);
				$pdf->Cell(345,5,"NO HAY CHEQUES EN CIRCULACI�N",1,'','C',true);
				$pdf->Ln(5);
			}
			
				//$pdf->Ln(5);
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(216,216,216);
				/// Total Ingresos
				$pdf->SetWidths(array(255, 30, 60));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$Tentra = number_format($Tentra,2,'.',',');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('TOTAL DE INGRESOS  ', $mons.'. '.$Tentra, ''));
				}
				//$pdf->Ln(5);
				/// Total Egresos
				$pdf->SetWidths(array(255, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$Tsale = number_format($Tsale,2,'.',',');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('TOTAL DE EGRESOS  ', '', $mons.'. '.$Tsale,''));
				}
				//$pdf->Ln(5);
				/// Total Egresos
				$pdf->SetWidths(array(255, 60, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$saldo = number_format($saldo,2,'.',',');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('SALDO REAL ', '', $mons.'. '.$saldo));
				}
				
				/// Total Egresos
				$pdf->SetWidths(array(255, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$CheqCircula = number_format($CheqCircula,2,'.',',');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('CHEQUES EN CIRCULACI�N  ', '', $mons.'. '.$CheqCircula,''));
				}
				//$pdf->Ln(5);
				/// Total Egresos
				$pdf->SetWidths(array(255, 60, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$saldoProyect = number_format($saldoProyect, 2, '.', ',');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('SALDO PROYECTADO ', '', $mons.'. '.$saldoProyect));
				}
			
			$pdf->Ln(5);
			
			

	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output("Movimiento de Punto de Venta $desc.pdf","I");

?>