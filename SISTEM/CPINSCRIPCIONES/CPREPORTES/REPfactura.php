<?php
   //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
  require_once("../../Clases/ClsNumLetras.php");
	
  //llena valores
  $ClsIns = new ClsInscripcion();
  $cui = $_REQUEST["cui"];
	$NumToWords = new NumberToLetterConverter();
  
  // INICIA ESCRITURA DE PDF 
  $pdf = new PDF('P','mm','recibo'); 
  $pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);

  $mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
  
	////-- trae datos de la boleta 
	$result = $ClsIns->get_boleta_cobro('','','',$cui);
	if(is_array($result)){
		foreach($result as $row){
			//--
			$num = $row["cueb_ncuenta"];
			//banco
			$bann = utf8_decode($row["ban_desc_ct"]);
			//codigo interno
			$codigo = $row["alu_codigo_interno"];
			$codigo = ($codigo != "")?$codigo:$cui;
			//alumno
			$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			
			$result_grado = $ClsIns->get_grado_alumno('','',$cui);
			if(is_array($result_grado)){
				foreach($result_grado as $row_grado){
					$nivel = trim($row_grado["niv_descripcion"]);
					$grado = trim($row_grado["gra_descripcion"]);
				}
			}
			//cliente
			$cli = trim($row["alu_cliente_factura"]);
			
			//Documento
			$referencia = $row["bol_referencia"];
			//motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			//fehca
			$fec = $row["bol_fecha_pago"];
			$fec = $ClsIns->cambia_fechaHora($fec);
			$mes = substr($fec,3,2);
			//Monto
			$simbolo = $row["mon_simbolo"];
			$monto = number_format($row["bol_monto"],2,'.','');
			//descuento
			$descuento = number_format($row["bol_descuento"],2,'.','');
			//descuento
			$motdesc = utf8_decode($row["bol_motivo_descuento"]);
			$i++;
		}
		if(strlen($cli)>0){
			$ClsCli = new ClsCliente();
			$result = $ClsCli->get_cliente($cli);
			if(is_array($result)){
				foreach($result as $row){
					$nit = $row["cli_nit"];
					$cliente = utf8_decode($row["cli_nombre"]);
					$direccion = utf8_decode($row["cli_direccion"]);
				}
			}
		}
	}
				//inicia Escritura del PDF
				//----------- No. ------//
			/*	$pdf->SetFont('Courier','B',8);
				$pdf->SetXY(140,5);
				$pdf->Cell(25, 3, "FACTURA", 0, 0, 'C');
				$pdf->SetFont('Courier','B',8);
				$pdf->SetXY(140,8);
				$pdf->Cell(25, 3, "Serie $serie", 0, 0, 'C');
				$pdf->SetFont('Courier','B',10);
				$pdf->SetXY(140,11);
				$factura = Agrega_Ceros($factura);
				$pdf->Cell(25, 3, "No. $factura", 0, 0, 'C');*/
				
				//Asignar tamano de fuente
				$pdf->SetFont('Courier','B',10);
				
				//----------- CUI ------//
				$pdf->SetXY(40,18);
				$pdf->Cell(35, 5, "$cui", 0, 0);
				
				//----------- Nombre del Cliente ------//
				$pdf->SetXY(40,23);
				$pdf->Cell(35, 5, $cliente, 0, 0);
				
				//----------- Direccion del Cliente ------//
				$pdf->SetXY(40,28);
				$pdf->Cell(35, 5, $direccion, 0, 0);
				
				//----------- NIT del Cliente ------//
				$pdf->SetXY(172,28);
				$pdf->Cell(35, 5, $nit, 0, 0);
				
				//----------- Monto en letras ------//
				$monto_letras = $NumToWords->to_word($monto);
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
				$pdf->Cell(35, 5, "$simbolo. $monto", 0, 0);
				
				//----------- DESCRIPCION ------//
				$pdf->SetXY(15,51);
				$pdf->MultiCell(185, 50, "$motivo / ALUMNO: $alumno" , 0 , "C", false);
  
	    //-
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output("Factura $cui.pdf","I"); ///  //$pdf->Output("-Nobre del pdf-.pdf","I->Visualizador PDF WEB, D->Descarga Automatica, F->Descarga en un directorio");
  
  
?>