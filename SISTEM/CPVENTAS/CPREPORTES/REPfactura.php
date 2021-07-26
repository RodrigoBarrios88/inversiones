<?php
  //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
  require_once("../../Clases/ClsNumLetras.php");
	
  //llena valores
		$ClsFac = new ClsFactura();
		$ClsMon = new ClsMoneda();
		$ClsVent = new ClsVenta();
		$NumToWords = new NumberToLetterConverter();
		$usuario = $_SESSION["codigo"];
		$hashkey1 = $_REQUEST["hashkey1"];
		$hashkey2 = $_REQUEST["hashkey2"];
		$serie = $ClsFac->decrypt($hashkey1, $usuario);
		$num = $ClsFac->decrypt($hashkey2, $usuario);
		
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
  
  // INICIA ESCRITURA DE PDF 
  $pdf = new PDF('L','mm',array(196,139.5)); 
  $pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);

  $mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
  
	////-- trae datos de la venta 
	$result = $ClsVent->get_ventas_varias($CodVentas);
	if(is_array($result)){
			$i = 1;
			foreach($result as $row){
				//--
					$nit =  trim($row["cli_nit"]);
					$nom =  utf8_decode($row["cli_nombre"]);
					$dir =  trim($row["cli_direccion"]);
				//--
				//descuento
					$desc = $row["ven_descuento"];
					$Dcambiar = Cambio_Moneda($tcambio,$MonCambio,$desc);
					$Tdescuento+= $Dcambiar;
				//total
					$tot = $row["ven_total"];
					$Ttotal+= $Dcambiar;
					$i++;
			}
			$i--; //resta 1 vuelta porq inicia con 1
			$monedaDesc = "$MonDesc / Tipo de Cambio: $MonCambio X 1</b>";
			$Descuento = number_format($Tdescuento, 2, '.', '');
			$Descuento.= $MonSimbol.' '.$Tdescuento;
			$Ttotal = number_format($Ttotal,2, '.', '');
			//$Total.= $MonSimbol.' '.$Ttotal;
			$i--; //resta 1 vuelta porq inicia con 1
	}
				//inicia Escritura del PDF
				//----------- No. ------//
				$pdf->SetFont('Arial','',14);
				$pdf->SetXY(135,7);
				$pdf->Cell(25, 3, "FACTURA", 0, 0, 'C');
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(135,11);
				$pdf->Cell(25, 3, "Serie $serie", 0, 0, 'C');
				$pdf->SetFont('Arial','',12);
				$pdf->SetXY(135,15);
				$factura = Agrega_Ceros($factura);
				$pdf->Cell(25, 3, "No. $factura", 0, 0, 'C');
				
				//----------- CUI ------//
				$pdf->SetFont('Arial','',12);
				$pdf->SetXY(30,31);
				$pdf->Cell(35, 10, "$cui", 0, 0);
				
				//----------- Nombre del Cliente ------//
				$pdf->SetFont('Arial','',14);
				$pdf->SetXY(30,38);
				$pdf->Cell(35, 10, $nom, 0, 0);
				
				//----------- Direccion del Cliente ------//
				$pdf->SetFont('Arial','',12);
				$pdf->SetXY(30,47);
				$pdf->Cell(35, 10, $dir, 0, 0);
				
				//----------- NIT del Cliente ------//
				$pdf->SetFont('Arial','',14);
				$pdf->SetXY(170,47);
				$pdf->Cell(35, 10, $nit, 0, 0);
				
				//----------- Monto en letras ------//
				$pdf->SetFont('Arial','',12);
				$monto_letras = $NumToWords->to_word($Ttotal);
				$secciona = explode(".", $Ttotal);
				$decimales = $secciona[1];
				$exactos = (intval($decimales) == 0)?"EXACTOS":""; 
				$pdf->SetXY(37,60);
				$pdf->Cell(165, 7, "$monto_letras $moneda $exactos", 0, 0, 'L');
				
				//----------- fecha ------//
				$dia = substr($fecha,0,2);
				$mes = substr($fecha,3,2);
				$anio = substr($fecha,6,4);
				//--
				$pdf->SetXY(80,32);
				$pdf->Cell(35, 5, $dia, 0, 0);
				$pdf->SetXY(105,32);
				$pdf->Cell(35, 5, $mes, 0, 0);
				$pdf->SetXY(135,32);
				$pdf->Cell(35, 5, $anio, 0, 0);
				
				//----------- Monto en numeros ------//
				$pdf->SetFont('Arial','',14);
				$pdf->SetXY(170,31);
				$pdf->Cell(35, 5, "$MonSimbol. $Ttotal", 0, 0);
				
				//----------- DESCRIPCION ------//
				$pdf->SetXY(15,81);
				$pdf->MultiCell(180, 7, "Venta de Servicios, articulos u otros" , 0 , "C", false);
	    //-
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output("Factura $serie $factura.pdf","I"); ///  //$pdf->Output("-Nobre del pdf-.pdf","I->Visualizador PDF WEB, D->Descarga Automatica, F->Descarga en un directorio");
  
  
?>