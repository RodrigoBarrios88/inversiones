<?php
  //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
  require_once("../../Clases/ClsNumLetras.php");
	
  //llena valores
   $ClsBol = new ClsBoletaCobro();
	 $NumToWords = new NumberToLetterConverter();
	 $usuario = $_SESSION["codigo"];
	 $hashkey1 = $_REQUEST["hashkey1"];
	 $hashkey2 = $_REQUEST["hashkey2"];
	 $numero = $ClsBol->decrypt($hashkey1, $usuario);
	 $serie = $ClsBol->decrypt($hashkey2, $usuario);
  
  // INICIA ESCRITURA DE PDF 
  $pdf = new PDF('L','mm',array(196,139.5)); 
  $pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);

  $mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
  
	////-- trae datos de la venta 
	$result = $ClsBol->get_factura($numero,$serie);
	if(is_array($result)){
			$i = 1;
			foreach($result as $row){
			  //--
				$serie =  trim($row["ser_numero"]);
				$factura =  trim($row["fac_numero"]);
				//--
				$nit =  trim($row["cli_nit"]);
				$nom =  utf8_decode($row["cli_nombre"]);
				$dir =  trim($row["cli_direccion"]);
				//--
				$referencia = $row["fac_referencia"];
				$cui = $row["fac_alumno"];
				$alumno = utf8_decode($row["alu_nombre_completo"]);
				$fec = $row["fac_fecha"];
				$fec = cambia_fecha($fec);
				$monto = $row["fac_monto"];
				$simbolo = $row["mon_simbolo"];
				$moneda = $row["mon_desc"];
				$tcamb = $row["fac_tcambio"];
				$situacion = $row["ven_situacion"];
				$desc = utf8_decode($row["fac_descripcion"]);
			    $i++;
			}
			$i--; //resta 1 vuelta porq inicia con 1
	}
				//inicia Escritura del PDF
				//----------- No. ------//
				$pdf->SetFont('Arial','',12);
				$pdf->SetXY(170,5);
				$pdf->Cell(25, 3, "FACTURA", 0, 0, 'C');
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(170,9);
				$pdf->Cell(25, 3, "Serie $serie", 0, 0, 'C');
				$pdf->SetFont('Arial','',12);
				$pdf->SetXY(170,13);
				$factura = Agrega_Ceros($factura);
				$pdf->Cell(25, 3, "No. $factura", 0, 0, 'C');
				
				//Asignar tamano de fuente
				$pdf->SetFont('Arial','B',12);
				
				//----------- CUI ------//
				$pdf->SetXY(15,31);
				$pdf->Cell(35, 10, "$cui", 0, 0);
				
				//----------- Nombre del Cliente ------//
				$pdf->SetXY(15,41);
				$pdf->Cell(35, 10, $nom, 0, 0);
				
				//----------- Direccion del Cliente ------//
				$pdf->SetXY(15,51);
				$pdf->Cell(35, 10, $dir, 0, 0);
				
				//----------- NIT del Cliente ------//
				$pdf->SetXY(235,51);
				$pdf->Cell(35, 10, $nit, 0, 0);
				
				//----------- Monto en letras ------//
				$monto_letras = $NumToWords->to_word($monto);
				$secciona = explode(".", $monto);
				$decimales = $secciona[1];
				$exactos = (intval($decimales) == 0)?"EXACTOS":""; 
				$pdf->SetXY(15,65);
				$pdf->Cell(165, 7, "$monto_letras $moneda $exactos", 0, 0, 'L');
				
				//----------- fecha ------//
				$dia = substr($fec,0,2);
				$mes = substr($fec,3,2);
				$anio = substr($fec,6,4);
				//--
				$pdf->SetXY(90,31);
				$pdf->Cell(35, 5, $dia, 0, 0);
				$pdf->SetXY(136,31);
				$pdf->Cell(35, 5, $mes, 0, 0);
				$pdf->SetXY(165,31);
				$pdf->Cell(35, 5, $anio, 0, 0);
				
				//----------- Monto en numeros ------//
				$pdf->SetXY(235,28);
				$pdf->Cell(35, 5, "$simbolo. $monto", 0, 0);
				
				//----------- DESCRIPCION ------//
				$pdf->SetXY(15,81);
				$pdf->MultiCell(165, 7, "$desc / ALUMNO: $alumno" , 0 , "C", false);
  
	    //-
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output("Factura $serie $factura.pdf","I"); ///  //$pdf->Output("-Nobre del pdf-.pdf","I->Visualizador PDF WEB, D->Descarga Automatica, F->Descarga en un directorio");
  
  
?>