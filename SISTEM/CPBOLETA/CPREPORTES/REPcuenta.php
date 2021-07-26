<?php
//Incluir las librerias de FPDF
include_once('../../html_fns.php');

	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	$pensum_vigente = $_SESSION["pensum"];
	//$_POST
	$pensum = $_REQUEST["pensum"];
	$pensum = ($pensum == "")?$pensum_vigente:$pensum;
	//--
	$anio_actual = date("Y");
	$anio = $_REQUEST["anio"];
	$anio = ($anio == "")?$anio_actual:$anio;
	//--
	$hashkey = $_REQUEST["hashkey"];
	$ClsAsig = new ClsAsignacion();
	$ClsAcadem = new ClsAcademico();
	$ClsAlu = new ClsAlumno();
	$cui = $ClsAlu->decrypt($hashkey, $id);
	
	$pdf=new PDF('L','mm','Letter');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	/////// LARGO DE LA HOJA 270 mm ////////////
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'ESTADO DE CUENTA', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 245 ,5, 30 , 30,'JPG', '');
	
	$pdf->Ln(10);
	
	///////////// CONSULTAS Y CALCULOS ////////////////////
	$result = $ClsAlu->get_alumno($cui,'','',1);
	if(is_array($result)){
		foreach($result as $row){
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
		}
		$alumno = "$nom $ape";
	}
	
	$result = $ClsAcadem->get_grado_alumno($pensum,'','',$cui,'',1);
		if(is_array($result)){
			foreach($result as $row){
				$nivel = trim($row["niv_descripcion"]);
				$grado = trim($row["gra_descripcion"]);
			}
		}
		
		$result = $ClsAcadem->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);
		if(is_array($result)){
			foreach($result as $row){
				$seccion = trim($row["sec_descripcion"]);
			}
		}
		
	////// A�O DE CARGOS A LISTAR /////////
		$anio_actual = date("Y");
		//// fechas ///
		if($anio == $anio_actual){
			$mes = date("m"); ///mes de este a�o para calculo de saldos y moras
			$fini = "01/01/$anio";
			$ffin = "31/$mes/$anio";
			$titulo_programado = "Programado a la fecha:";
			$titulo_pagado = "Pagado a la fecha:";
		}else{
			$fini = "01/01/$anio";
			$ffin = "31/12/$anio";
			$titulo_programado = trim("Programado para el a�o $anio:");
			$titulo_pagado = trim("Pagado del el a�o $anio:");
		}
	
	/////// PROGRAMADO ////////
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_cobro('','','',$cui,'',$anio,'',$fini,$ffin,1,2);
	$monto_programdo = 0;
	if(is_array($result)){
		foreach($result as $row){
			$mons = $row["mon_simbolo"];
			$monto_programdo+= $row["bol_monto"];
			$fecha_programdo = $row["bol_fecha_pago"];
		}
	}
	//echo $monto_programdo;
	$valor_programado = $mons ." ".number_format($monto_programdo, 2);
	
	/////// PAGADO ////////
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro('','','',$cui,'','','','','',$fini,$ffin);
	$monto_pagado = 0;
	if(is_array($result)){
		foreach($result as $row){
			$mons = $row["mon_simbolo"];
			$monto_pagado+= $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$fecha_pago = $row["pag_fechor"];
		}
	}
	//echo $monto_pagado;
	$valor_pagado = $mons ." ".number_format($monto_pagado, 2);
	
	////////// CALUCULO DE SOLVENCIA ///////////
	$diferencia = $monto_programdo - $monto_pagado;
	if($diferencia <= 0){
		$diferencia = ($diferencia * -1);
		$fecha_pago = cambia_fechaHora($fecha_pago);
		$diferencia = $mons ." ".number_format($diferencia, 2);
		
		//----------- RECTANGULO DE SOLVENCIA ------//
		$pdf->SetDrawColor(60,118,61);
		$pdf->SetFillColor(214,233,198);
		$pdf->Rect(137.5, 40, 135, 30, 'DF');
		//----------- Titulo de solvencia ------//
		$pdf->SetTextColor(60,118,61); // LETRA COLOR VERDE
		$pdf->SetFont('Arial','B',14);
		$pdf->SetXY(137.5, 45);
		$pdf->Cell(135, 10, "SOLVENTE. SALDO A FAVOR: $diferencia", 0, 0, 'C');
		//--- linea---//
		$pdf->Line(140, 57.5, 270, 57.5);
		//----------- Observaciones de solvencia ------//
		$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(137.5, 60);
		$pdf->Cell(135, 5, "EL �LTIMO PAGO SE REALIZ� EL $fecha_pago", 0, 0, 'C');
	}else{
		if($anio == $anio_actual){
			$hoy = date("Y-m-d");
			if($fecha_programdo < $hoy){
				$fecha_programdo = cambia_fecha($fecha_programdo);
				$diferencia = $mons ." ".number_format($diferencia, 2);
				//----------- RECTANGULO DE SOLVENCIA ------//
				$pdf->SetDrawColor(169,68,66); //COLOR ROJO
				$pdf->SetFillColor(242,222,222);
				$pdf->Rect(137.5, 40, 135, 30, 'DF');
				//----------- Titulo de solvencia ------//
				$pdf->SetTextColor(169,68,66); // LETRA COLOR ROJO
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(137.5, 45);
				$pdf->Cell(135, 10, "FECHA DE PAGO EXPIRADA!. SALDO PENDIENTE: $diferencia", 0, 0, 'C');
				//--- linea---//
				$pdf->Line(140, 57.5, 270, 57.5);
				//----------- Observaciones de solvencia ------//
				$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
				$pdf->SetFont('Arial','',8);
				$pdf->SetXY(137.5, 60);
				$pdf->Cell(135, 5, "EL PAGO EXPIR� EL $fecha_programdo", 0, 0, 'C');
			}else{
				$fecha_programdo = cambia_fecha($fecha_programdo);
				$diferencia = $mons ." ".number_format($diferencia, 2);
				//----------- RECTANGULO DE SOLVENCIA ------//
				$pdf->SetDrawColor(191,100,3); //COLOR ROJO
				$pdf->SetFillColor(246,200,151);
				$pdf->Rect(137.5, 40, 135, 30, 'DF');
				//----------- Titulo de solvencia ------//
				$pdf->SetTextColor(191,100,3); // LETRA COLOR ROJO
				$pdf->SetFont('Arial','B',14);
				$pdf->SetXY(137.5, 45);
				$pdf->Cell(135, 10, "SALDO PARA ESTE MES:  $diferencia", 0, 0, 'C');
				//--- linea---//
				$pdf->Line(140, 57.5, 270, 57.5);
				//----------- Observaciones de solvencia ------//
				$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
				$pdf->SetFont('Arial','',8);
				$pdf->SetXY(137.5, 60);
				$pdf->Cell(135, 5, "EL PR�XIMO PAGO EXPIRA EL $fecha_programdo", 0, 0, 'C');
			}
		}else{
			$diferencia = $mons ." ".number_format($diferencia, 2);
			//----------- RECTANGULO DE SOLVENCIA ------//
			$pdf->SetDrawColor(60,118,61);
			$pdf->SetFillColor(214,233,198);
			$pdf->Rect(137.5, 40, 135, 30, 'DF');
			//----------- Titulo de solvencia ------//
			$pdf->SetTextColor(60,118,61); // LETRA COLOR VERDE
			$pdf->SetFont('Arial','B',14);
			$pdf->SetXY(137.5, 45);
			$pdf->Cell(135, 10, trim("MONTO PARA EL A�O $anio: $diferencia"), 0, 0, 'C');
			//--- linea---//
			$pdf->Line(140, 57.5, 270, 57.5);
			//----------- Observaciones de solvencia ------//
			$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
			$pdf->SetFont('Arial','',8);
			$pdf->SetXY(137.5, 60);
			$pdf->Cell(135, 5, "Datos calculados referentes al a�o", 0, 0, 'C');
		}
	}
	
	//----------- NEGRO ------//
	$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
	$pdf->SetFont('Arial','',12);
	//----------- CUI del Alumno ------//
		$pdf->SetXY(5,40);
		$pdf->Cell(100, 5, "CUI:", 0, 0);
	//----------- Nombre del Alumno ------//
		$pdf->SetXY(5,50);
		$pdf->Cell(100, 5, "Alumno:", 0, 0);
	//----------- Grado y Seccion ------//
		$pdf->SetXY(5,60);
		$pdf->Cell(100, 5, "Grado y Sección :", 0, 0);
	
	//----------- AZUL ------//
	$pdf->SetTextColor(28,75,129); // LETRA COLOR AZUL
	$pdf->SetFont('Arial','B',12);
	//----------- CUI del Alumno ------//
		$pdf->SetXY(5,45);
		$pdf->Cell(100, 5, $cui, 0, 0);
	//----------- Nombre del Alumno ------//
		$pdf->SetXY(5,55);
		$pdf->Cell(100, 5, $alumno, 0, 0);
	//----------- Nombre del Alumno ------//
		$pdf->SetXY(5,65);
		$pdf->Cell(100, 5, "$grado Sección $seccion", 0, 0);
		
	////////////////////// ENCABEZADOS DE TABLAS ////////////////////////
	$pdf->SetDrawColor(28,75,129); // COLOR AZUL
	$pdf->SetTextColor(28,75,129); // LETRA COLOR AZUL
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY(5, 75);
	$pdf->Cell(130, 7, "PAGOS PROGRAMADOS PARA EL A�O", 1, 0, 'C');
	///////--------
	$pdf->SetDrawColor(60,118,61); // COLOR VERDE
	$pdf->SetTextColor(60,118,61); // LETRA COLOR VERDE
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY(137.5, 75);
	$pdf->Cell(135, 7, "PAGOS YA REALIZADOS ESTE A�O", 1, 0, 'C');
	
	////////////////////////////////////////////////////////////////////////
	$pdf->SetDrawColor(0,0,0); //COLOR NEGRO
	$pdf->SetTextColor(0,0,0); // LETRA COLOR NEGRO
	////////////////////////////////////////////////////////////////////////
	
	////////////////////// TABLAS PAGOS PROGRAMADOS ////////////////////////
	$pdf->SetY(85);
	///----- encabezados ---////
	$pdf->SetFillColor(188,188,188);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
	$pdf->SetFont('Arial','B',6);
	$pdf->SetX(5);
	$pdf->Cell(20, 3, "BOLETA", 1, 0, 'C', true);
	$pdf->SetX(25);
	$pdf->Cell(20, 3, "MONTO", 1, 0, 'C', true);
	$pdf->SetX(45);
	$pdf->Cell(30, 3, "FECHA LIMITE", 1, 0, 'C', true);
	$pdf->SetX(75);
	$pdf->Cell(60, 3, "MOTIVO", 1, 0, 'C', true);
	///----- cuerpo ---////
	$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_cobro('','','',$cui,'',date("Y"),'','','',1,2);
	$pdf->Ln(3);
	if(is_array($result)){
		foreach($result as $row){
			$fecha = $row["bol_fecha_pago"];
			if(strtotime($hoy) > strtotime($fecha)){ /// pinta de celeste las fechas pasadas
				$pdf->SetFillColor(217,237,247);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			}else{
				$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			}
			$pagado = $row["bol_pagado"];
			if($pagado == 1){ /// si este pagado pone negritas
				$pdf->SetFont('Arial','B',6);   // Pagado
			}else{
				$pdf->SetFont('Arial','',6);   // Pendiente de pago
			}
			//boleta
			$referencia = $row["bol_referencia"];
			$pdf->SetX(5);
			$pdf->Cell(20, 3, "# $referencia", 1, 0, 'C', true);
			//monto
			$valor = $row["bol_monto"];
			$mons = $row["mon_simbolo"];
			$valor = number_format($valor, 2);
			$pdf->SetX(25);
			$pdf->Cell(20, 3, "$mons. $valor", 1, 0, 'C', true);
			//Fecha de Pago
			$fecha = $row["bol_fecha_pago"];
			$fecha = cambia_fechaHora($fecha);
			$pdf->SetX(45);
			$pdf->Cell(30, 3, $fecha, 1, 0, 'C', true);
			//motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			$motivo = (strlen($motivo) > 45)?substr($motivo,0,43)."...":$motivo;
			$pdf->SetX(75);
			$pdf->Cell(60, 3, $motivo, 1, 0, 'L', true);
			//--
			$pdf->Ln(3);
		}	
	}	
	///-- verifica la coordenada final de la tabla
	$y_prog = $pdf->GetY();
	
	
	////////////////////// TABLAS PAGOS REALIZADOS ////////////////////////
	$pdf->SetY(85);
	///----- encabezados ---////
	$pdf->SetFillColor(188,188,188);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
	$pdf->SetFont('Arial','B',6);
	$pdf->SetX(137.5);
	$pdf->Cell(27, 3, "BOLETA", 1, 0, 'C', true);
	$pdf->SetX(164.5);
	$pdf->Cell(27, 3, "MONTO", 1, 0, 'C', true);
	$pdf->SetX(191.5);
	$pdf->Cell(27.5, 3, "FECHA DE PAGO", 1, 0, 'C', true);
	$pdf->SetX(219);
	$pdf->Cell(27, 3, "FACTURA/RECIBO", 1, 0, 'C', true);
	$pdf->SetX(246);
	$pdf->Cell(27, 3, "TRANSACCI�N", 1, 0, 'C', true);
	///----- cuerpo ---////
	$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
	$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro($cod,'','',$cui,'',date("Y"),'','','','','',2);
	$pdf->Ln(3);
	if(is_array($result)){
		foreach($result as $row){
			$fecha = $row["bol_fecha_pago"];
			//boleta
			$referencia = $row["pag_referencia"];
			$pdf->SetX(137.5);
			$pdf->Cell(27, 3, "# $referencia", 1, 0, 'C', true);
			//monto
			$valor = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$mons = $row["mon_simbolo"];
			$valor = number_format($valor, 2);
			$pdf->SetX(164.5);
			$pdf->Cell(27, 3, "$mons. $valor", 1, 0, 'C', true);
			//Fecha de Pago
			$fecha = $row["pag_fechor"];
			$fecha = cambia_fechaHora($fecha);
			$pdf->SetX(191.5);
			$pdf->Cell(27.5, 3, $fecha, 1, 0, 'C', true);
			//factura/recibo
			$facturado = $row["pag_facturado"];
			if($facturado == 1){
				$numdesc = $row["fac_numero"];
				$serdesc = $row["fac_serie_numero"];
				$facturado = 'FACTURA '.$serdesc.'-'.$numdesc;
			}else if($facturado == 2){
				$numdesc = $row["rec_numero"];
				$serdesc = $row["rec_serie_numero"];
				$facturado = 'RECIBO '.$serdesc.'-'.$numdesc;
			}else{
				$facturado = "Pendiente";
			}
			$pdf->SetX(219);
			$pdf->Cell(27, 3, $facturado, 1, 0, 'C', true);
			//transaccion
			$transaccion = utf8_decode($row["pag_transaccion"]);
			$pdf->SetX(246);
			$pdf->Cell(27, 3, $transaccion, 1, 0, 'C', true);
			//--
			$pdf->Ln(3);
		}	
	}
	///-- verifica la coordenada final de la tabla
	$y_pagado = $pdf->GetY();
	
	///////////////////////////////
	if($y_prog >= $y_pagado){
		$y = $y_prog;
	}else{
		$y = $y_pagado;
	}
	$y+= 5;
	////////////////////// PIES DE TABLAS ////////////////////////
	$pdf->SetDrawColor(28,75,129); // COLOR AZUL
	$pdf->SetTextColor(28,75,129); // LETRA COLOR AZUL
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY(5, $y);
	$pdf->Cell(130, 7, "$titulo_programado $valor_programado", 1, 0, 'C');
	///////--------
	$pdf->SetDrawColor(60,118,61); // COLOR VERDE
	$pdf->SetTextColor(60,118,61); // LETRA COLOR VERDE
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY(137.5, $y);
	$pdf->Cell(135, 7, "$titulo_pagado $valor_pagado", 1, 0, 'C');
	
	$y+= 10;
	$pdf->SetDrawColor(0,0,0); // COLOR AZUL
	$pdf->SetTextColor(0,0,0); // LETRA COLOR AZUL
	$pdf->SetFont('Arial','B',8);   // Pagado
	$pdf->SetXY(5, $y);
	$pdf->Cell(130, 5, "Claves:", 'B', 0, 'L');
	//--
	$pdf->SetFont('Arial','',8);   // Pagado
	$y+= 5;
	$pdf->SetXY(5, $y);
	$pdf->Cell(50, 5, "Boletas Pagadas: NEGRILLAS", 0, 0, 'L');
	$pdf->SetXY(55, $y);
	$pdf->SetFont('Arial','B',8);   // Pagado
	$pdf->Cell(50, 5, "NEGRILLAS", 0, 0, 'L');
	$y+= 5;
	$pdf->SetXY(5, $y);
	$pdf->SetFont('Arial','',8);   // Pagado
	$pdf->Cell(50, 5, "Boletas Pendientes de Pago:", 0, 0, 'L');
	$pdf->SetXY(55, $y);
	$pdf->Cell(50, 5, "NORMAL", 0, 0, 'L');
	$y+= 5;
	$pdf->SetXY(5, $y);
	$pdf->Cell(50, 5, "Rango Calculado:", 0, 0, 'L');
	$pdf->SetFillColor(217,237,247);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
	$pdf->SetDrawColor(217,237,247);
	$pdf->SetFillColor(217,237,247);
	$pdf->Rect(55, $y, 50, 5, 'DF');
	
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>