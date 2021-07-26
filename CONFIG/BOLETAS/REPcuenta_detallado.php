<?php
//Incluir las librerias de FPDF
include_once('html_fns_reportes.php');

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
	$ClsPer = new ClsPeriodoFiscal();
	$periodo = $_REQUEST["periodo"];
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	//--
	$hashkey = $_REQUEST["hashkey"];
	$division = $_REQUEST["division"];
	$grupo = $_REQUEST["grupo"];
	$ClsAsig = new ClsAsignacion();
	$ClsAcadem = new ClsAcademico();
	$ClsAlu = new ClsAlumno();
	$cui = $ClsAlu->decrypt($hashkey, $id);
	
	$pdf=new PDF('P','mm','Legal');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	/////// LARGO DE LA HOJA 270 mm ////////////
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'ESTADO DE CUENTA DETALLADO', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generacion: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(205, 5, 'Oficina: Cobros y Cuenta Corriente', 0 , 'L' , 0);
	$pdf->Image('../images/replogo.jpg' , 180 ,5, 30 , 30,'JPG', '');
	
	$pdf->Ln(10);
	
	///////////// CONSULTAS Y CALCULOS ////////////////////
	$result = $ClsAlu->get_alumno($cui,'','',1);
	if(is_array($result)){
		foreach($result as $row){
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			//--
			$padre = utf8_decode($row["alu_padre"]);
			$padre_tel = trim($row["alu_telefono"]);
			$padre_mail = trim($row["alu_mail_padre"]);
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
		
	////// AÑO DE CARGOS A LISTAR /////////
	$anio_periodo = $ClsPer->get_anio_periodo($periodo);
	$anio_actual = date("Y");
	$anio_periodo = ($anio_periodo == "")?$anio_actual:$anio_periodo;
	//// fechas ///
	if($anio_actual == $anio_periodo){
		$mes = date("m"); ///mes de este año para calculo de saldos y moras
		$fini = "01/01/$anio_actual";
		$ffin = "31/$mes/$anio_actual";
		$titulo_programado = "Programado a la fecha:";
		$titulo_pagado = "Pagado a la fecha:";
	}else{
		$fini = "01/01/$anio_periodo";
		$ffin = "31/12/$anio_periodo";
		$titulo_programado = "Programado para el año $anio_periodo:";
		$titulo_pagado = "Pagado del el año $anio_periodo:";
	}
	
	/////// PROGRAMADO ////////
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_vs_pago('','','',$cui,'',$periodo,'',$fini,$ffin,1,2);
	$monto_programdo = 0;
	$monto_pagado = 0;
	$boletaX;
	if(is_array($result)){
		foreach($result as $row){
			$bolcodigo = $row["bol_codigo"];
			$mons = $row["bol_simbolo_moneda"];
			if($bolcodigo != $boletaX){
				$monto_programdo+= $row["bol_monto"];
				$fecha_programdo = $row["bol_fecha_pago"];
				$fecha_pago = $row["pag_fechor"];
				$boletaX = $bolcodigo;
			}
			$monto_pagado+= $row["pag_total"]; /// monto registrado en la boleta, ya con descuento
		}
	}
	//echo $monto_programdo;
	$valor_programado = $mons .". ".number_format($monto_programdo, 2, '.', ',');
	
	/////// PAGADO ////////
	$ClsBol = new ClsBoletaCobro();
	//$result = $ClsBol->get_pago_boleta_cobro('','','',$cui,'','','','','',$fini,$ffin);
	$result = $ClsBol->get_pago_aislado('','','', $cui,'',$periodo,'','0','',$fini,$ffin,'');
	if(is_array($result)){
		foreach($result as $row){
			$mons = $row["mon_simbolo"];
			$monto_pagado+= floatval($row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"]);
		}
	}
	//echo $monto_pagado;
	$valor_pagado = $mons .". ".number_format($monto_pagado, 2, '.', ',');
	
	//----------- NEGRO ------//
	$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
	$pdf->SetFont('Arial','',10);
	//----------- CUI del Alumno ------//
	$pdf->SetXY(5,40);
	$pdf->Cell(100, 5, "CUI:", 0, 0);
	//----------- Nombre del Alumno ------//
	$pdf->SetXY(5,50);
	$pdf->Cell(100, 5, "Alumno:", 0, 0);
	//----------- Grado y Seccion ------//
	$pdf->SetXY(5,60);
	$pdf->Cell(100, 5, "Grado y Sección:", 0, 0);
		
	//----------- Encargado ------//
	$pdf->SetXY(105,40);
	$pdf->Cell(100, 5, "Encargado:", 0, 0);
	//----------- Telefono ------//
	$pdf->SetXY(105,50);
	$pdf->Cell(100, 5, "Telefono:", 0, 0);
	//----------- Correo ------//
	$pdf->SetXY(105,60);
	$pdf->Cell(100, 5, "E-mail:", 0, 0);
	
	//----------- AZUL ------//
	$pdf->SetTextColor(28,75,129); // LETRA COLOR AZUL
	$pdf->SetFont('Arial','B',10);
	//----------- CUI del Alumno ------//
		$pdf->SetXY(10,45);
		$pdf->Cell(90, 5, $cui, 'B', 0);
	//----------- Nombre del Alumno ------//
		$pdf->SetXY(10,55);
		$pdf->Cell(90, 5, $alumno, 'B', 0);
	//----------- Nombre del Alumno ------//
		$pdf->SetXY(10,65);
		$pdf->Cell(90, 5, "$grado SECCIÓN $seccion", 'B', 0);
		
	//----------- CUI del Alumno ------//
		$pdf->SetXY(110,45);
		$pdf->Cell(90, 5, $padre, 'B', 0);
	//----------- Nombre del Alumno ------//
		$pdf->SetXY(110,55);
		$pdf->Cell(90, 5, $padre_tel, 'B', 0);
	//----------- Nombre del Alumno ------//
		$pdf->SetXY(110,65);
		$pdf->Cell(90, 5, $padre_mail, 'B', 0);
		
	////////////////////// ENCABEZADOS DE TABLAS ////////////////////////
	$pdf->SetDrawColor(28,75,129); // COLOR AZUL
	$pdf->SetTextColor(28,75,129); // LETRA COLOR AZUL
	$pdf->SetFont('Arial','B',12);
	$pdf->SetXY(5, 75);
	$pdf->Cell(205, 7, "DETALLE DE COBROS", 1, 0, 'C');
	
	////////////////////////////////////////////////////////////////////////
	$pdf->SetDrawColor(0,0,0); //COLOR NEGRO
	$pdf->SetTextColor(0,0,0); // LETRA COLOR NEGRO
	////////////////////////////////////////////////////////////////////////
	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(205, 5, "PAGOS REALIZADOS", 0, 0, 'C');
	////////////////////// TABLAS PAGOS REALIZADOS ////////////////////////
	$pdf->Ln(5);
	///----- encabezados ---////
	$pdf->SetFillColor(188,188,188);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
	$pdf->SetFont('Arial','B',8);
	$pdf->SetX(5);
	$pdf->Cell(35, 5, "BOLETA", 1, 0, 'C', true);
	$pdf->SetX(40);
	$pdf->Cell(35, 5, "MONTO", 1, 0, 'C', true);
	$pdf->SetX(75);
	$pdf->Cell(35, 5, "FECHA DE PAGO", 1, 0, 'C', true);
	$pdf->SetX(110);
	$pdf->Cell(40, 5, "FACTURA/RECIBO", 1, 0, 'C', true);
	$pdf->SetX(150);
	$pdf->Cell(60, 5, "MOTIVO", 1, 0, 'C', true);
	///----- cuerpo ---////
	$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
	$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro('',$cuenta,'',$cui,'',$periodo,'','','','','',2);
	$pdf->Ln(5);
	if(is_array($result)){
		foreach($result as $row){
			//boleta
			$boleta = $row["pag_programado"];
			$pdf->SetX(5);
			$pdf->Cell(35, 5, "# $boleta", 1, 0, 'C', true);
			//monto
			$valor = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$mons = $row["mon_simbolo"];
			$valor = number_format($valor, 2);
			$pdf->SetX(40);
			$pdf->Cell(35, 5, "$mons. $valor", 1, 0, 'C', true);
			//Fecha de Pago
			$fecha = $row["pag_fechor"];
			$fecha = cambia_fechaHora($fecha);
			$pdf->SetX(75);
			$pdf->Cell(35, 5, $fecha, 1, 0, 'C', true);
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
			$pdf->SetX(110);
			$pdf->Cell(40, 5, $facturado, 1, 0, 'C', true);
			//mes de la boleta
			$fecboleta = $row["bol_fecha_pago"];
			$mes = substr($fecboleta,5,2);
			$mes = trim(Meses_Letra($mes));
			//descripcion
			$boltipo = $row["bol_tipo"];
			if($boltipo == "C"){
				$motivo = "$mes / ".utf8_decode($row["bol_motivo"]);
			}else{
				$motivo = utf8_decode($row["bol_motivo"]);
			}
			$motivo = (strlen($motivo) > 57)?substr($motivo,0,57)."...":$motivo;
			$pdf->SetX(150);
			$pdf->Cell(60, 5, $motivo, 1, 0, 'L', true);
			//--
			$pdf->Ln(5);
		}	
	}
	////////////////////// PIES DE TABLAS ////////////////////////
	$pdf->SetDrawColor(60,118,61); // COLOR VERDE
	$pdf->SetTextColor(60,118,61); // LETRA COLOR VERDE
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX(5);
	//$pdf->Cell(205, 7, "Pagado a la fecha: $valor_pagado", 1, 0, 'C');
	$pdf->Ln(5);
	
	
	////////////////////////////////////////////////////////////////////////
	$pdf->SetDrawColor(0,0,0); //COLOR NEGRO
	$pdf->SetTextColor(0,0,0); // LETRA COLOR NEGRO
	////////////////////////////////////////////////////////////////////////
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(205, 5, "PAGOS PENDIENTES", 0, 0, 'C');
	////////////////////// TABLAS PAGOS PROGRAMADOS ////////////////////////
	$pdf->Ln(5);
	///----- encabezados ---////
	$pdf->SetFillColor(188,188,188);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
	$pdf->SetFont('Arial','B',8);
	$pdf->SetX(5);
	$pdf->Cell(35, 5, "BOLETA", 1, 0, 'C', true);
	$pdf->SetX(40);
	$pdf->Cell(35, 5, "MONTO", 1, 0, 'C', true);
	$pdf->SetX(75);
	$pdf->Cell(35, 5, "FECHA LIMITE", 1, 0, 'C', true);
	$pdf->SetX(110);
	$pdf->Cell(100, 5, "MOTIVO", 1, 0, 'C', true);
	///----- cuerpo ---////
	$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
	$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_cobro('',$division,$grupo,$cui,'',$periodo,'','','',1,2);
	$pdf->Ln(5);
	if(is_array($result)){
		foreach($result as $row){
			$pagado = $row["bol_pagado"];
			if($pagado != 1){ /// si este pagado pone negritas
				$fecha = $row["bol_fecha_pago"];
				//boleta
				$boleta = $row["bol_codigo"];
				$pdf->SetX(5);
				$pdf->Cell(35, 5, "# $boleta", 1, 0, 'C', true);
				//monto
				$valor = $row["bol_monto"];
				$mons = $row["mon_simbolo"];
				$valor = number_format($valor, 2);
				$pdf->SetX(40);
				$pdf->Cell(35, 5, "$mons. $valor", 1, 0, 'C', true);
				//Fecha de Pago
				$fecha = $row["bol_fecha_pago"];
				$fecha = cambia_fechaHora($fecha);
				$pdf->SetX(75);
				$pdf->Cell(35, 5, $fecha, 1, 0, 'C', true);
				
				//mes de la boleta
				$fecboleta = $row["bol_fecha_pago"];
				$mes = substr($fecboleta,5,2);
				$mes = trim(Meses_Letra($mes));
				//motivo
				$boltipo = $row["bol_tipo"];
				if($boltipo == "C"){
					$motivo = "$mes / ".utf8_decode($row["bol_motivo"]);
				}else{
					$motivo = utf8_decode($row["bol_motivo"]);
				}
				$motivo = (strlen($motivo) > 90)?substr($motivo,0,90)."...":$motivo;
				$pdf->SetX(110);
				$pdf->Cell(100, 5, $motivo, 1, 0, 'L', true);
				//--
				$pdf->Ln(5);
			}
		}	
	}	
	////////////////////// PIES DE TABLAS ////////////////////////
	$pdf->SetDrawColor(28,75,129); // COLOR AZUL
	$pdf->SetTextColor(28,75,129); // LETRA COLOR AZUL
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX(5);
	//$pdf->Cell(205, 7, "Pendiente (programado) a la fecha: $valor_programado", 1, 0, 'C');
	
	$pdf->Ln(5);
	////////// CALUCULO DE SOLVENCIA ///////////
	$y = $pdf->GetY();
	$diferencia = $monto_programdo - $monto_pagado;
	if($diferencia <= 0){
		$diferencia = ($diferencia * -1);
		$fecha_pago = cambia_fechaHora($fecha_pago);
		$diferencia = $mons ." ".number_format($diferencia, 2);
		
		//----------- RECTANGULO DE SOLVENCIA ------//
		$pdf->SetDrawColor(60,118,61);
		$pdf->SetFillColor(214,233,198);
		$pdf->Rect(5, $y, 205, 30, 'DF');
		//----------- Titulo de solvencia ------//
		$pdf->SetTextColor(60,118,61); // LETRA COLOR VERDE
		$pdf->SetFont('Arial','B',14);
		$pdf->SetX(5, 45);
		$pdf->Cell(205, 10, "SOLVENTE. SALDO A FAVOR: $diferencia", 0, 0, 'C');
		//--- linea---//
		$pdf->Line(10, $y + 15, 205, $y + 15);
		//----------- Observaciones de solvencia ------//
		$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
		$pdf->SetFont('Arial','',8);
		$pdf->SetX(5, 60);
		$pdf->Ln(15);
		$pdf->Cell(205, 5, "EL ÚLTIMO PAGO SE REALIZÓ EL $fecha_pago", 0, 0, 'C');
	}else{
		if($anio_actual == $anio_periodo){
			$hoy = date("Y-m-d");
			//echo "$fecha_programdo < $hoy";
			if($fecha_programdo < $hoy){
				$fecha_programdo = cambia_fecha($fecha_programdo);
				$diferencia = $mons ." ".number_format($diferencia, 2);
				//----------- RECTANGULO DE SOLVENCIA ------//
				$pdf->SetDrawColor(169,68,66); //COLOR ROJO
				$pdf->SetFillColor(242,222,222);
				$pdf->Rect(5, $y, 205, 30, 'DF');
				//----------- Titulo de solvencia ------//
				$pdf->SetTextColor(169,68,66); // LETRA COLOR ROJO
				$pdf->SetFont('Arial','B',12);
				$pdf->SetX(5);
				$pdf->Cell(205, 10, "FECHA DE PAGO EXPIRADA!. SALDO PENDIENTE: $diferencia", 0, 0, 'C');
				//--- linea---//
				$pdf->Line(10, $y + 15, 205, $y + 15);
				//----------- Observaciones de solvencia ------//
				$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
				$pdf->SetFont('Arial','',8);
				$pdf->SetX(5);
				$pdf->Ln(15);
				$pdf->Cell(205, 5, "EL PAGO EXPIRÓ EL $fecha_programdo", 0, 0, 'C');
			}else{
				$fecha_programdo = cambia_fecha($fecha_programdo);
				$diferencia = $mons ." ".number_format($diferencia, 2);
				//----------- RECTANGULO DE SOLVENCIA ------//
				$pdf->SetDrawColor(191,100,3); //COLOR ROJO
				$pdf->SetFillColor(246,200,151);
				$pdf->Rect(5, $y, 205, 30, 'DF');
				//----------- Titulo de solvencia ------//
				$pdf->SetTextColor(191,100,3); // LETRA COLOR ROJO
				$pdf->SetFont('Arial','B',14);
				$pdf->SetX(5, 45);
				$pdf->Cell(205, 10, "SALDO PARA ESTE MES:  $diferencia", 0, 0, 'C');
				//--- linea---//
				$pdf->Line(10, $y + 15, 205, $y + 15);
				//----------- Observaciones de solvencia ------//
				$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
				$pdf->SetFont('Arial','',8);
				$pdf->SetX(5);
				$pdf->Ln(15);
				$pdf->Cell(205, 5, "EL PRÓXIMO PAGO EXPIRA EL $fecha_programdo", 0, 0, 'C');
			}
		}else{
			$diferencia = $mons ." ".number_format($diferencia, 2);
			//----------- RECTANGULO DE SOLVENCIA ------//
			$pdf->SetDrawColor(28,75,129);
			$pdf->SetFillColor(217,237,247);
			$pdf->Rect(5, $y, 205, 30, 'DF');
			//----------- Titulo de solvencia ------//
			$pdf->SetTextColor(28,75,129); // LETRA COLOR AZUL
			$pdf->SetFont('Arial','B',14);
			$pdf->SetX(5, 45);
			$pdf->Cell(205, 10, trim("MONTO PARA EL AÑO $anio_periodo: $diferencia"), 0, 0, 'C');
			//--- linea---//
			$pdf->Line(10, $y + 15, 205, $y + 15);
			//----------- Observaciones de solvencia ------//
			$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
			$pdf->SetFont('Arial','',8);
			$pdf->SetX(5);
			$pdf->Ln(15);
			$pdf->Cell(205, 5, "Datos calculados referentes al año $anio_periodo", 0, 0, 'C');
		}
	}
	
	/*$y+= 10;
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
	$pdf->Rect(55, $y, 50, 5, 'DF');*/
	
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>