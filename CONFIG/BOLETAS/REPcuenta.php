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
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generacion: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Oficina: Cobros y Cuenta Corriente', 0 , 'L' , 0);
	$pdf->Image('../images/replogo.jpg' , 245 ,5, 30 , 30,'JPG', '');
	
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
			$monto_pagado+= $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
		}
	}
	//echo $monto_pagado;
	$valor_pagado = $mons .". ".number_format($monto_pagado, 2, '.', ',');
	
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
		$pdf->Cell(137.5, 10, "SOLVENTE. SALDO A FAVOR: $diferencia", 0, 0, 'C');
		//--- linea---//
		$pdf->Line(140, 57.5, 270, 57.5);
		//----------- Observaciones de solvencia ------//
		$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(137.5, 60);
		$pdf->Cell(137.5, 5, "EL ÚLTIMO PAGO SE REALIZÓ EL $fecha_pago", 0, 0, 'C');
	}else{
		if($anio_actual == $anio_periodo){
			$hoy = date("Y-m-d");
			if($fecha_programdo < $hoy){
				$fecha_programdo = cambia_fecha($fecha_programdo);
				$diferencia = $mons ." ".number_format($diferencia, 2);
				//----------- RECTANGULO DE SOLVENCIA ------//
				$pdf->SetDrawColor(169,68,66); //COLOR ROJO
				$pdf->SetFillColor(242,222,222);
				$pdf->Rect(137.5, 40, 137.5, 30, 'DF');
				//----------- Titulo de solvencia ------//
				$pdf->SetTextColor(169,68,66); // LETRA COLOR ROJO
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(137.5, 45);
				$pdf->Cell(137.5, 10, "FECHA DE PAGO EXPIRADA!. SALDO PENDIENTE: $diferencia", 0, 0, 'C');
				//--- linea---//
				$pdf->Line(140, 57.5, 270, 57.5);
				//----------- Observaciones de solvencia ------//
				$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
				$pdf->SetFont('Arial','',8);
				$pdf->SetXY(137.5, 60);
				$pdf->Cell(137.5, 5, "EL PAGO EXPIRÓ EL $fecha_programdo", 0, 0, 'C');
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
				$pdf->Cell(137.5, 10, "SALDO PARA ESTE MES:  $diferencia", 0, 0, 'C');
				//--- linea---//
				$pdf->Line(140, 57.5, 270, 57.5);
				//----------- Observaciones de solvencia ------//
				$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
				$pdf->SetFont('Arial','',8);
				$pdf->SetXY(137.5, 60);
				$pdf->Cell(137.5, 5, "EL PRÓXIMO PAGO EXPIRA EL $fecha_programdo", 0, 0, 'C');
			}
		}else{
			$diferencia = $mons ." ".number_format($diferencia, 2);
			//----------- RECTANGULO DE SOLVENCIA ------//
			$pdf->SetDrawColor(28,75,129);
			$pdf->SetFillColor(217,237,247);
			$pdf->Rect(137.5, 40, 135, 30, 'DF');
			//----------- Titulo de solvencia ------//
			$pdf->SetTextColor(28,75,129); // LETRA COLOR AZUL
			$pdf->SetFont('Arial','B',14);
			$pdf->SetXY(137.5, 45);
			$pdf->Cell(137.5, 10, trim("MONTO PARA EL AÑO $anio_periodo: $diferencia"), 0, 0, 'C');
			//--- linea---//
			$pdf->Line(140, 57.5, 270, 57.5);
			//----------- Observaciones de solvencia ------//
			$pdf->SetTextColor(0,0,0); //LETRA COLOR NEGRO
			$pdf->SetFont('Arial','',8);
			$pdf->SetXY(137.5, 60);
			$pdf->Cell(137.5, 5, "Datos calculados referentes al año $anio_periodo", 0, 0, 'C');
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
	$pdf->Cell(100, 5, "$grado sección $seccion", 0, 0);
		
	
	
	////////////////////////////////////////////////////////// ESTADO DE CUENTA //////////////////////////////////////////////////////////
	$pdf->Ln(10);
	
	$pdf->SetWidths(array(10, 90, 25, 45, 25, 25, 25, 25));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
	$pdf->SetDrawColor(0,0,0); //COLOR ROJO
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
    $pdf->SetTextColor(0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$pdf->Row(array('No.', 'DESCRIPCIÓN', '# BOLETA', 'FECHA LIMITE / PAGO','MONTO','DESCUENTO','SALDO','PAGADO'));
	}

	$pdf->SetWidths(array(10, 90, 25, 45, 25, 25, 25, 25));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'L', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	$ClsBol = new ClsBoletaCobro();
	$orderby = 3;
	$result = $ClsBol->get_boleta_vs_pago('',$division,$grupo,$cui,'',$periodo,'','','',1,$orderby);
	$result_aislado = $ClsBol->get_pago_aislado('',$division,$grupo, $cui,'',$periodo,'','0','','','','');
	
	$i=1;
	if(is_array($result)){
		$boletaX = '';
		$montoTotal = 0;
		$saldoTotal = 0;
		foreach($result as $row){
			////-- Comprobaciones
			$bolcodigo = $row["bol_codigo"];
			if($bolcodigo != $boletaX){
				//-------------------------------------------------------------------------------------------------------------------------------------------------------
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				//boleta
				$boleta = $row["bol_codigo"];
				//Fecha de Pago
				$fecha = $row["bol_fecha_pago"];
				$fecha = cambia_fechaHora($fecha);
				//monto
				$saldo = $row["bol_monto"]; /// monto registrado en la boleta, ya con descuento
				$descuento = $row["bol_descuento"]; // descuento de la boleta
				$monto = ($saldo + $descuento); // monto sin descuento
				$mons = $row["bol_simbolo_moneda"];
				$valor = number_format($valor, 2);
				$monto = $mons.'. '.number_format($monto, 2, '.',',');
				$montoTotal+= $row["bol_monto"];
				//descuento
				$descuento = $mons.'. '.number_format($descuento, 2, '.',',');
				//saldo
				$saldo = $mons.'. '.number_format($saldo, 2, '.',',');
				//pagado
				$pagado = $row["bol_pagado"];
				$pagado = ($pagado == 0)?"pendiente":"";
				//---
				$no = $i.".";
				$pdf->SetFillColor(217,237,247);
				$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
				$pdf->Row(array($no,$motivo,$boleta,$fecha,$monto,$descuento,$saldo,$pagado)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			}else{
				$i--;
			}
			//-------------------------------------------------------------------------------------------------------------------------------------------------------
			$pago = $row["pag_codigo"];
			if($pago != ""){
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				//boleta
				$boleta = $row["pag_programado"];
				//fecha de pago
				$fecha = $row["pag_fechor"];
				$fecha = cambia_fechaHora($fecha);
				//monto
				$saldo = $row["bol_monto"]; /// monto registrado en la boleta, ya con descuento
				$descuento = $row["bol_descuento"]; // descuento de la boleta
				$monto = ($saldo + $descuento); // monto sin descuento
				$mons = $row["bol_simbolo_moneda"];
				$monto = $mons.'. '.number_format($monto, 2, '.',',');
				//descuento
				$descuento = $mons.'. '.number_format($descuento, 2, '.',',');
				//saldo
				$saldo = $mons.'. '.number_format($saldo, 2, '.',',');
				//pagado
				$valor = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
				$mons = $row["pag_simbolo_moneda"];
				$pagado = $mons.'. '.number_format($valor, 2, '.',',');
				//--
				$no = "";
				$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
				$pdf->Row(array($no,$motivo,$boleta,$fecha,$monto,$descuento,$saldo,$pagado)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			}else{
				$motivo = '';
				$boleta = '';
				$fecha = '';
				$monto = '';
				$descuento = '';
				$saldo = '';
				$pagado = '';
				//--
				$no = "";
				$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
				$pdf->Row(array($no,$motivo,$boleta,$fecha,$monto,$descuento,$saldo,$pagado)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			}	
			$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
		}
	}
	if(is_array($result_aislado)){
		foreach($result_aislado as $row){
			//motivo
			$motivo = "- Pago de Boleta No Programado -";
			//boleta
			$boleta = $row["pag_programado"];
			//fecha de pago
			$fecha = $row["pag_fechor"];
			$fecha = cambia_fechaHora($fecha);
			//monto
			$saldo = $row["bol_monto"]; /// monto registrado en la boleta, ya con descuento
			$descuento = $row["bol_descuento"]; // descuento de la boleta
			$monto = ($saldo + $descuento); // monto sin descuento
			$mons = $row["mon_simbolo"];
			$monto = $mons.'. '.number_format($monto, 2, '.',',');
			//descuento
			$descuento = $mons.'. '.number_format($descuento, 2, '.',',');
			//saldo
			$saldo = $mons.'. '.number_format($saldo, 2, '.',',');
			//pagado
			$valor = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$mons = $row["mon_simbolo"];
			$pagado = $mons.'. '.number_format($valor, 2, '.',',');
			//--
			$no = $i.".";
			$pdf->SetFillColor(242,222,222);
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->Row(array($no,$motivo,$boleta,$fecha,$monto,$descuento,$saldo,$pagado)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;
		}
	}
	
	
	////////////////////////////////////////////////////////// ESTADO DE CUENTA //////////////////////////////////////////////////////////

	
	///-- verifica la coordenada final de la tabla
	$y_pagado = $pdf->GetY();
	//echo $Y.", ".$y;
	if($y_pagado >= 190){
		$pdf->AddPage();
		$pdf->SetAutoPageBreak(false,2);
		$pdf->SetMargins(5,5,5);
		$y_pagado = 10;
	}
	
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
	$pdf->Cell(137.5, 7, "$titulo_pagado $valor_pagado", 1, 0, 'C');
	
	//// revisa cambio de pagina
	$Y = $pdf->GetY();
	//echo $Y.", ".$y;
	if($Y >= 185){
		$pdf->AddPage();
		$pdf->SetAutoPageBreak(false,2);
		$pdf->SetMargins(5,5,5);
		$y = 0;
	}
	
	$y+= 10;
	$pdf->SetDrawColor(0,0,0); // COLOR AZUL
	$pdf->SetTextColor(0,0,0); // LETRA COLOR AZUL
	$pdf->SetFont('Arial','B',8);   // Pagado
	$pdf->SetXY(5, $y);
	$pdf->Cell(130, 5, "Claves:", 'B', 0, 'L');
	//--
	$y+= 10;
	$pdf->SetXY(5, $y);
	$pdf->SetFont('Arial','',8);   // Pagado
	$pdf->Cell(50, 5, "Pagos programados:", 0, 0, 'L');
	$pdf->SetFillColor(217,237,247);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
	$pdf->SetDrawColor(0,0,0);
	$pdf->Rect(55, $y, 50, 5, 'DF');
	//--
	$y+= 5;
	$pdf->SetXY(5, $y);
	$pdf->SetFont('Arial','',8);   // Pagado
	$pdf->Cell(50, 5, "Pagos realizados:", 0, 0, 'L');
	$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
	$pdf->SetDrawColor(0,0,0);
	$pdf->Rect(55, $y, 50, 5, 'DF');
	//--
	$y+= 5;
	$pdf->SetXY(5, $y);
	$pdf->SetFont('Arial','',8);   // Pagado
	$pdf->Cell(50, 5, "Pagos realizados no programados:", 0, 0, 'L');
	$pdf->SetFillColor(242,222,222);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
	$pdf->SetDrawColor(0,0,0);
	$pdf->Rect(55, $y, 50, 5, 'DF');
	
	
	$pdf->Output();

?>