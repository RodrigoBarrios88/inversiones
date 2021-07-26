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
				$situacion = trim($row["fac_situacion"]);
				//--
				$codIN.= trim($row["ven_codigo"]).",";
			}
			$CodVentas = substr($codIN, 0, -1);
		}

  // INICIA ESCRITURA DE PDF 
  $pdf = new PDF('P','mm','recibo'); 
  $pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);

  $mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
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
			$nom =  trim($row["cli_nombre"]);
			$dir =  trim($row["cli_direccion"]);
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
		$Total.= $MonSimbol.' '.$Ttotal;
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
				
				//----------- No. ------//
				$pdf->SetFont('Courier','B',8);
				$pdf->SetXY(140,5);
				$pdf->Cell(25, 3, "FACTURA", 0, 0, 'C');
				$pdf->SetFont('Courier','B',8);
				$pdf->SetXY(140,8);
				$pdf->Cell(25, 3, "Serie $serie", 0, 0, 'C');
				$pdf->SetFont('Courier','B',10);
				$pdf->SetXY(140,11);
				$factura = Agrega_Ceros($factura);
				$pdf->Cell(25, 3, "No. $factura", 0, 0, 'C');
				
				//Asignar tamano de fuente
				$pdf->SetFont('Courier','B',10);
				
				//----------- CUI ------//
				$pdf->SetXY(40,18);
				$pdf->Cell(35, 5, "$cui", 0, 0);
				
				//----------- Nombre del Cliente ------//
				$pdf->SetXY(40,23);
				$pdf->Cell(35, 5, $nom, 0, 0);
				
				//----------- Direccion del Cliente ------//
				$pdf->SetXY(40,28);
				$pdf->Cell(35, 5, $dir, 0, 0);
				
				//----------- NIT del Cliente ------//
				$pdf->SetXY(172,28);
				$pdf->Cell(35, 5, $nit, 0, 0);
				
				//----------- Monto en letras ------//
				$monto_letras = $NumToWords->to_word($Total);
				$secciona = explode(".", $Total);
				$decimales = $secciona[1];
				$exactos = (intval($decimales) == 0)?"EXACTOS":""; 
				$pdf->SetXY(40,33);
				$pdf->Cell(35, 5, "$monto_letras $MonDesc $exactos", 0, 0);
				
				//----------- fecha ------//
				$dia = substr($fec,0,2);
				$mes = substr($fec,3,2);
				$anio = substr($fec,6,4);
				//--
				$pdf->SetXY(80,23);
				$pdf->Cell(35, 5, $dia, 0, 0);
				$pdf->SetXY(106,23);
				$pdf->Cell(35, 5, $mes, 0, 0);
				$pdf->SetXY(135,23);
				$pdf->Cell(35, 5, $anio, 0, 0);
				
				//----------- Monto en numeros ------//
				$pdf->SetXY(165,18);
				$pdf->Cell(35, 5, "$MonSimbol. $Total", 0, 0);
				
				//---------- datos de la venta ---------//
				////////////////////// TABLAS PAGOS REALIZADOS ////////////////////////
				$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
				$pdf->SetY(49);
				///----- encabezados ---////
				$pdf->SetX(15);
				$pdf->Cell(37, 5, "CANTIDAD", 0, 0, 'C', true);
				$pdf->SetX(52);
				$pdf->Cell(89, 5, "DESCRIPCIÓN", 0, 0, 'C', true);
				$pdf->SetX(141);
				$pdf->Cell(29, 5, "PRECIO", 0, 0, 'C', true);
				$pdf->SetX(170);
				$pdf->Cell(30, 5, "SUBTOTAL", 0, 0, 'C', true);
				$pdf->Ln(5);
				
				$result = $ClsVent->get_det_venta('',$CodVentas);
				if(is_array($result)){
					$i = 1;
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
								$stot = $row["dven_subtotal"];
								$subtotal = $row["mon_simbolo"].". ".number_format($stot,2,'.','');
								//--
								$Vmons = $row["mon_simbolo_venta"];
								$monc = $row["dven_tcambio"];
								$Dcambiar = Cambio_Moneda($monc,$MonCambio,$stot);
								$Total+= $Dcambiar;
								$Rcambiar = Cambio_Moneda($monc,$MonCambio,$rtot);
								$Rtotal+= $Rcambiar;
								//--
								$pdf->SetX(15);
								$pdf->Cell(37, 5, $cantidad, 0, 0, 'C', true);
								$pdf->SetX(52);
								$pdf->Cell(89, 5, $detalle, 0, 0, 'C', true);
								$pdf->SetX(141);
								$pdf->Cell(29, 5, $precio, 0, 0, 'C', true);
								$pdf->SetX(170);
								$pdf->Cell(30, 5, $subtotal, 0, 0, 'C', true);
								//--
								$pdf->Ln(5);
					}
					
					$i--; //resta 1 vuelta porq inicia con 1
					$label = "TOTAL";
					$total = $MonSimbol.". ".number_format($Total,2,'.','');
					
					$pdf->SetWidths(array(163, 22));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$pdf->SetAligns(array('R', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					
					// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
					$pdf->SetFont('Courier','B',10);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
					$pdf->SetX(15);
					$pdf->Cell(155, 5, "$label   ", 0, 0, 'R', true);
					$pdf->SetX(170);
					$pdf->Cell(30, 5, $total, 0, 0, 'C', true);
							
				}
				//-
				  
	    //-
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output("Factura $serie $factura.pdf","I"); ///  //$pdf->Output("-Nobre del pdf-.pdf","I->Visualizador PDF WEB, D->Descarga Automatica, F->Descarga en un directorio");
  
?>