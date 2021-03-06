<?php
  //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
  require_once("../../Clases/ClsNumLetras.php");
	$id = $_SESSION["codigo"];
	
  //llena valores
  $ClsFac = new ClsFactura();
  $ClsMon = new ClsMoneda();
	$ClsVent = new ClsVenta();
	
	$NumToWords = new NumberToLetterConverter();
	
	$hashkey1 = $_REQUEST["hashkey1"];
	$hashkey2 = $_REQUEST["hashkey2"];
	$serie = $ClsFac->decrypt($hashkey1, $id);
	$num = $ClsFac->decrypt($hashkey2, $id);
	
	///--trae datos de la factura, si se facturo.
	$result = $ClsFac->get_factura($num,$serie,'');
	  if(is_array($result)){
			$codIN = "";
			foreach ($result as $row) {
				$serie = trim($row["ser_numero"]);
				$factura = trim($row["fac_numero"]);
				$fecha = trim($row["fac_fecha"]);
				$situacion = trim($row["fac_situacion"]);
				//--
				$codIN.= trim($row["ven_codigo"]).",";
			}
			$CodVentas = substr($codIN, 0, -1);
		}

  // INICIA ESCRITURA DE PDF 
  $pdf = new PDF('L','mm','Letter');
  $pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	
	$pdf->Image("FacturaID.jpg",0,0,279.5,215,"JPG");

  $mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
	//$pdf->Image("FacturaID.jpg",0,0,280,216,"JPG");
	
	///-- trae la moneda configurada como primaria
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$MonDesc = utf8_encode($row["mon_desc"]);
			$MonSimbol = utf8_encode($row["mon_simbolo"]);
			$MonCambio = trim($row["mon_cambio"]);
		}	
	}	
	////
  
	////-- trae datos de la venta 
	$result = $ClsVent->get_ventas_varias($CodVentas);
	if(is_array($result)){
	  $i = 1;
		$Tdescuento = 0;
		$Ttotal = 0;
		foreach($result as $row){
			//--
			$nit =  trim($row["cli_nit"]);
			$nom =  utf8_decode($row["cli_nombre"]);
			$dir =  utf8_decode($row["cli_direccion"]);
			//descuento
			$desc = $row["ven_descuento"];
			$Dcambiar = Cambio_Moneda($tcambio,$MonCambio,$desc);
			$Tdescuento+= $Dcambiar;
			//total
			$tot = $row["ven_total"];
			$Ttotal+= $Dcambiar;
			
			$i++;
		}
		$monedaDesc = "$MonDesc / Tipo de Cambio: $MonCambio X 1</b>";
		$Descuento = number_format($Tdescuento, 2, '.', '');
		$Descuento.= $MonSimbol.' '.$Tdescuento;
		$Ttotal = number_format($Ttotal,2, '.', '');
		//$Total.= $MonSimbol.' '.$Ttotal;
		$i--; //resta 1 vuelta porq inicia con 1
	}
	//----------- Situacion de la Factura ------------///
		if($situacion == 0){ 
					$pdf->Image("../../../CONFIG/images/anulada.jpg",5,5,40,40,"JPG");
		}
	//-
		// coordenadas iniciales
				$x = 40;
				$y = 33;
				
				//inicia Escritura del PDF
				
				//Borde recuadro / division en dos
				$pdf->SetDrawColor(0,0,0);
				$pdf->SetXY($x,$y);
				$pdf->Cell(278, 205, '', 0, 0);
				
				
		/////////////////// ORIGINAL //////////////////////////
				//----------- No. ------//
				$pdf->SetFont('Arial','',6);
				$pdf->SetXY(97,3);
				$factura = Agrega_Ceros($factura);
				$pdf->Cell(33, 3, "FACTURA $serie $factura", 0, 0, 'C');
				//--
				$pdf->SetXY(97,6);
				$pdf->Cell(33, 3, "VENTA(S) No. $CodVentas", 0, 0, 'C');
				
				//----------- Nombre del Cliente ------//
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(5,44);
				$pdf->Cell(20, 5, "Cliente: ", 0, 0);
				//--
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(25,44);
				$pdf->Cell(60, 5, $nom, 'B', 0);
				
				//----------- NIT del Cliente ------//
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(5,49);
				$pdf->Cell(20, 5, "Nit: ", 0, 0);
				//--
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(25,49);
				$pdf->Cell(60, 5, $nit, 'B', 0);
				
				//----------- Direccion del Cliente ------//
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(5,54);
				$pdf->Cell(20, 5, trim("Direcci??n: "), 0, 0);
				//--
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(25,54);
				$pdf->Cell(60, 5, $dir, 'B', 0);
				
				//----------- Fecha ------//
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(5,59);
				$pdf->Cell(20, 5, trim("Fecha: "), 0, 0);
				//--
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(25,59);
				$pdf->Cell(60, 5, cambia_fecha($fecha), 'B', 0);
				
				//---------- datos de la venta ---------//
				$pos_x = 5;
	      $pos_y= 75;
			
			  $pdf->SetXY($pos_x,$pos_y);
				$pdf->Ln(5);
				
				$pdf->SetWidths(array(55, 10, 20, 20, 20));  // AQU?? LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C'));  // AQU?? LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
				$pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA??O
				$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
				$pdf->SetXY($pos_x,$pos_y);
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('Descripci??n', 'Cantidad', 'Precio', 'Descuento', 'Subtota'));
				}
			
				$pdf->SetWidths(array(55, 10, 20, 20, 20));  // AQU?? LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('L', 'C', 'C', 'C', 'C'));  // AQU?? LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$result = $ClsVent->get_det_venta('',$CodVentas);
				if(is_array($result)){
					$i = 1;
					$pos_x = 5;
					$pos_y+= 5;
					$Total = 0;
					$Rtotal = 0;
					foreach($result as $row){
								//--
								$cantidad = $row["dven_cantidad"];
								$detalle = utf8_decode($row["dven_detalle"]);
								$precio = $row["mon_simbolo"].". ".number_format($row["dven_precio"],2,'.','');
								$desc = "% ".$row["dven_descuento"];
								$tcambio = $row["dven_tcambio"]."X".$row["ven_tcambio"];
								$rtot = $row["dven_total"];
								$stot = $stot = $row["dven_subtotal"];
								$descuento = $row["mon_simbolo"].". ".number_format($row["dven_descuento"],2,'.','');
								$subtotal = $row["mon_simbolo"].". ".number_format($stot,2,'.','');
								//--
								$Vmons = $row["mon_simbolo_venta"];
								$monc = $row["dven_tcambio"];
								$Dcambiar = Cambio_Moneda($monc,$MonCambio,$stot);
								$Total+= $Dcambiar;
								$Rcambiar = Cambio_Moneda($monc,$MonCambio,$rtot);
								$Rtotal+= $Rcambiar;
								//--
								$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA??O DE LA LETRA
								$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
								$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
								$pdf->SetXY($pos_x,$pos_y);
								$no = $i.".";
								$pdf->Row(array($detalle,$cantidad,$precio,$descuento,$subtotal)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
								$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
								$pos_y+=5;
					}
					
					$i--; //resta 1 vuelta porq inicia con 1
					$label = "TOTAL  ";
					$total = $MonSimbol.". ".number_format($Total,2,'.',',');
					
					$pdf->SetWidths(array(105, 20));  // AQU?? LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$pdf->SetAligns(array('R', 'C'));  // AQU?? LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					
					// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
					$pdf->SetFont('Arial','B',5);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA??O
					$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
					$pdf->SetXY($pos_x,$pos_y);
					$pdf->Row(array($label,$total));
					
					
				}
				//-
				
				
				//----------- Monto en letras ------//
				$pdf->SetFont('Arial','',6);
				$Total = number_format($Total, 2, '.', '');
				$secciona = explode(".", $Total);
				$enteros = $secciona[0];
				$decimales = $secciona[1];
				$monto_enteros = $NumToWords->to_word($enteros);
				$monto_decimales = "CON ".$NumToWords->to_word($decimales)." CENTAVOS";
				
				$exactos = (intval($decimales) == 0)?"EXACTOS":""; 
				$pdf->SetXY(15,185);
				$pdf->Cell(109.5, 5, "$monto_enteros $MonDesc $monto_decimales $exactos", 0, 0, 'C');
				 

		/////////////////// COPIA //////////////////////////
		//----------- Situacion de la Factura ------------///
		if($situacion == 0){ 
					$pdf->Image("../../../CONFIG/images/anulada.jpg",154,5,40,40,"JPG");
		}
		//-
				//----------- No. ------//
				$pdf->SetFont('Arial','',6);
				$pdf->SetXY(237,3);
				$factura = Agrega_Ceros($factura);
				$pdf->Cell(33, 3, "FACTURA $serie $factura", 0, 0, 'C');
				//--
				$pdf->SetXY(237,6);
				$pdf->Cell(33, 3, "VENTA(S) No. $CodVentas", 0, 0, 'C');
				
				//Asignar tamano de fuente
				$pdf->SetFont('Arial','',10);
				
				//----------- Nombre del Cliente ------//
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(145,44);
				$pdf->Cell(20, 5, "Cliente: ", 0, 0);
				//--
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(165,44);
				$pdf->Cell(60, 5, $nom, 'B', 0);
				
				//----------- NIT del Cliente ------//
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(145,49);
				$pdf->Cell(20, 5, "Nit: ", 0, 0);
				//--
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(165,49);
				$pdf->Cell(60, 5, $nit, 'B', 0);
				
				//----------- Direccion del Cliente ------//
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(145,54);
				$pdf->Cell(20, 5, trim("Direcci??n: "), 0, 0);
				//--
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(165,54);
				$pdf->Cell(60, 5, $dir, 'B', 0);
				
				//----------- Fecha ------//
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(145,59);
				$pdf->Cell(20, 5, trim("Fecha: "), 0, 0);
				//--
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(165,59);
				$pdf->Cell(60, 5, cambia_fecha($fecha), 'B', 0);
				
				
				//---------- datos de la venta ---------//
				$pos_x = 145;
	      $pos_y= 75;
			
			  $pdf->SetXY($pos_x,$pos_y);
				$pdf->Ln(5);
				
				$pdf->SetWidths(array(55, 10, 20, 20, 20));  // AQU?? LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C'));  // AQU?? LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
				$pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA??O
				$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
				$pdf->SetXY($pos_x,$pos_y);
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('Descripci??n', 'Cantidad', 'Precio', 'Descuento', 'Subtota'));
				}
			
				$pdf->SetWidths(array(55, 10, 20, 20, 20));  // AQU?? LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('L', 'C', 'C', 'C', 'C'));  // AQU?? LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$result = $ClsVent->get_det_venta('',$CodVentas);
				if(is_array($result)){
					$i = 1;
					$pos_x = 145;
					$pos_y+= 5;
					$Total = 0;
					$Rtotal = 0;
					foreach($result as $row){
								//--
								$cantidad = $row["dven_cantidad"];
								$detalle = utf8_decode($row["dven_detalle"]);
								$precio = $row["mon_simbolo"].". ".number_format($row["dven_precio"],2,'.','');
								$desc = "% ".$row["dven_descuento"];
								$tcambio = $row["dven_tcambio"]."X".$row["ven_tcambio"];
								$rtot = $row["dven_total"];
								$stot = $stot = $row["dven_subtotal"];
								$subtotal = $row["mon_simbolo"].". ".number_format($stot,2,'.','');
								//--
								$Vmons = $row["mon_simbolo_venta"];
								$monc = $row["dven_tcambio"];
								$Dcambiar = Cambio_Moneda($monc,$MonCambio,$stot);
								$Total+= $Dcambiar;
								$Rcambiar = Cambio_Moneda($monc,$MonCambio,$rtot);
								$Rtotal+= $Rcambiar;
								//--
								$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA??O DE LA LETRA
								$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
								$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
								$pdf->SetXY($pos_x,$pos_y);
								$no = $i.".";
								$pdf->Row(array($detalle,$cantidad,$precio,$descuento,$subtotal)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
								$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
								$pos_y+=5;
					}
					
					$i--; //resta 1 vuelta porq inicia con 1
					$label = "TOTAL  ";
					$total = $MonSimbol.". ".number_format($Total,2,'.',',');
					
					$pdf->SetWidths(array(105, 20));  // AQU?? LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$pdf->SetAligns(array('R', 'C'));  // AQU?? LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					
					// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
					$pdf->SetFont('Arial','B',5);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA??O
					$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
					$pdf->SetXY($pos_x,$pos_y);
					$pdf->Row(array($label,$total));
					
					
				}
				//-
				
				
				//----------- Monto en letras ------//
				$pdf->SetFont('Arial','',6);
				$Total = number_format($Total, 2, '.', '');
				$secciona = explode(".", $Total);
				$enteros = $secciona[0];
				$decimales = $secciona[1];
				$monto_enteros = $NumToWords->to_word($enteros);
				$monto_decimales = "CON ".$NumToWords->to_word($decimales)." CENTAVOS";
				
				$exactos = (intval($decimales) == 0)?"EXACTOS":""; 
				$pdf->SetXY(145,185);
				$pdf->Cell(109.5, 5, "$monto_enteros $MonDesc $monto_decimales $exactos", 0, 0, 'C');
				
			
  
	    //-
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output("Factura $serie $factura.pdf","I"); ///  //$pdf->Output("-Nobre del pdf-.pdf","I->Visualizador PDF WEB, D->Descarga Automatica, F->Descarga en un directorio");
  
?>