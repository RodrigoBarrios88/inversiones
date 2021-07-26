<?php
  //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
	
  //llena valores
   $ClsBol = new ClsBoletaCobro();
	 $NumToWords = new NumberToLetterConverter();
	 $usuario = $_SESSION["codigo"];
	 $hashkey1 = $_REQUEST["hashkey1"];
	 $hashkey2 = $_REQUEST["hashkey2"];
	 $numero = $ClsBol->decrypt($hashkey1, $usuario);
	 $serie = $ClsBol->decrypt($hashkey2, $usuario);
  
  // INICIA ESCRITURA DE PDF 
  $pdf = new PDF('P','mm','recibo'); 
  $pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);

  $mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
  
	////-- trae datos de la venta 
	$result = $ClsBol->get_recibo($numero,$serie);
	if(is_array($result)){
			$i = 1;
			foreach($result as $row){
			  //--
				$serie =  trim($row["ser_numero"]);
				$recibo =  trim($row["rec_numero"]);
				//--
				$nit =  trim($row["cli_nit"]);
				$nom =  utf8_decode($row["cli_nombre"]);
				$dir =  trim($row["cli_direccion"]);
				//--
						$boleta = $row["rec_boleta"];
						$cui = $row["rec_alumno"];
						$alumno = utf8_decode($row["alu_nombre_completo"]);
				    $fec = $row["rec_fecha"];
						$fec = cambia_fecha($fec);
				    $monto = $row["rec_monto"];
						$simbolo = $row["mon_simbolo"];
				    $moneda = $row["mon_desc"];
				    $tcamb = $row["rec_tcambio"];
				    $situacion = $row["ven_situacion"];
						$desc = utf8_decode($row["rec_descripcion"]);
			      $i++;
			}
			$i--; //resta 1 vuelta porq inicia con 1
	}
				//inicia Escritura del PDF
				//----------- No. ------//
				$pdf->SetFont('Courier','B',8);
				$pdf->SetXY(140,5);
				$pdf->Cell(25, 3, "RECIBO", 0, 0, 'C');
				$pdf->SetFont('Courier','B',8);
				$pdf->SetXY(140,8);
				$pdf->Cell(25, 3, "Serie $serie", 0, 0, 'C');
				$pdf->SetFont('Courier','B',10);
				$pdf->SetXY(140,11);
				$recibo = Agrega_Ceros($recibo);
				$pdf->Cell(25, 3, "No. $recibo", 0, 0, 'C');
				
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
				
				$pdf->SetXY(15,51);
				$pdf->MultiCell(185, 50, "$desc / ALUMNO: $alumno" , 0 , "C", false);
  
	    //-
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output("Recibo $serie $recibo.pdf","I"); ///  //$pdf->Output("-Nobre del pdf-.pdf","I->Visualizador PDF WEB, D->Descarga Automatica, F->Descarga en un directorio");
  
  
?>