<?php
  //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
  
  //llena valores
   $ClsBol = new ClsBoletaCobro();
	 $NumToWords = new NumberToLetterConverter();
	 $usuario = $_SESSION["codigo"];
	 $hashkey = $_REQUEST["hashkey"];
	 $carga = $ClsBol->decrypt($hashkey, $usuario);
  
  // INICIA ESCRITURA DE PDF 
  $pdf = new PDF('L','mm',array(196,139.5)); 
  
  $mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
  
	////-- trae datos de la venta 
	$result = $ClsBol->get_factura('','',$carga,'','','','','',1);
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			$nombre_completo = utf8_decode($row["alu_nombre_completo"]);
			/// si reconoce al alumno lo agrega al listado, si no, NO
			if($nombre_completo != ""){
					//--
					$serie =  trim($row["ser_numero"]);
					$factura =  trim($row["fac_numero"]);
					//--
					$nit =  trim($row["cli_nit"]);
					$nom =  utf8_decode($row["cli_nombre"]);
					$dir =  trim($row["cli_direccion"]);
					//--
					$boleta = $row["fac_boleta"];
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
					//--
					$grado = utf8_decode($row["alu_grado_descripcion"]);
					$seccion = utf8_decode($row["alu_seccion_descripcion"]);
							
					$pdf->AddPage();
					$pdf->SetAutoPageBreak(false,2);
							
					//inicia Escritura del PDF
					//----------- No. ------//
					$pdf->SetFont('Arial','',14);
					$pdf->SetXY(135,7);
					$pdf->Cell(25, 3, "FACTURA", 0, 0, 'C');
					$pdf->SetFont('Arial','',12);
					$pdf->SetXY(135,11);
					$pdf->Cell(25, 3, "Serie $serie", 0, 0, 'C');
					$pdf->SetFont('Arial','',14);
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
					$monto_letras = $NumToWords->to_word($monto);
					$secciona = explode(".", $monto);
					$decimales = $secciona[1];
					$exactos = (intval($decimales) == 0)?"EXACTOS":""; 
					$pdf->SetXY(37,60);
					$pdf->Cell(165, 7, "$monto_letras $moneda $exactos", 0, 0, 'L');
					
					//----------- fecha ------//
					$dia = substr($fec,0,2);
					$mes = substr($fec,3,2);
					$anio = substr($fec,6,4);
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
					$pdf->Cell(35, 5, "$simbolo. $monto", 0, 0);
					
					//----------- DESCRIPCION ------//
					$pdf->SetXY(15,81);
					$pdf->MultiCell(180, 7, $desc , 0 , "C", false);
					$pdf->SetXY(15,88);
					$pdf->MultiCell(180, 7, "Alumno(a): $alumno" , 0 , "C", false);
					$pdf->SetXY(15,96);
					$pdf->MultiCell(180, 7, "No. de Boleta # $boleta" , 0 , "C", false);
					$pdf->SetXY(15,105);
					$pdf->MultiCell(180, 7, "Grado: $grado ".utf8_decode("Sección")." $seccion" , 0 , "C", false);
					$i++;
			}
		}
		$i--; //resta 1 vuelta porq inicia con 1
	}
  
	    //-
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
	$carga = Agrega_Ceros($carga);
  $pdf->Output("Facturas de Carga No. $carga.pdf","I");
  
  
?>