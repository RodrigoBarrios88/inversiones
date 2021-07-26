<?php
include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$grado = $_SESSION["grado"];
	$arma = $_SESSION["arma"];
	//$_POST
	$tipo = trim($_REQUEST["tipo"]);
	$nombre = trim($_REQUEST["nombre"]);
	//--
	
	$pdf=new PDF('L','mm','Letter');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'REPORTE DE USUARIOS DEL CHAT', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por Nombre: '.$nombre, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 250 ,5, 25 , 25,'JPG', '');

	
	
	$pdf->Ln(10);
	////////////////////////////////////// ENCABEZADOS ///////////////////////////////////////////
	$pdf->SetWidths(array(10, 80, 60, 60, 60));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',10);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
        $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$pdf->Row(array('No.', 'NOMBRE', 'T�TULO', 'TIPO DE USUARIO', 'CORREO'));
	}

	////////////////////////////////////// CUERPO ///////////////////////////////////////////
	$pdf->SetWidths(array(10, 80, 60, 60, 60));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'L', 'L', 'L', 'L'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	$ClsChat = new ClsChat();
	$result = $ClsChat->get_cm('','',$nombre,$tipo);
	
	$i=1;
	if(is_array($result)){
		foreach($result as $row){
			//ID
			$id = utf8_decode($row["cm_cui"]);
			//nombre
			$nombre = utf8_decode($row["cm_nombre"]);
			//titulo
			$titulo = utf8_decode($row["cm_titulo"]);
			//tipo
			$tipo = $row["usu_tipo"];
			$tipo = ($tipo == 1)?"Autoridad":"Maestro";
			//correo
			$mail = $row["cm_mail"];
			//---
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$pdf->Row(array($no,$nombre,$titulo,$tipo,$mail)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
		}
		$i--;
	
	////////////////////////////////////// PIE DE REPORTE ///////////////////////////////////////////
			$pdf->SetFont('Arial','B',10);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(270,5,$i.' Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
			
	}else{
		$pdf->SetFont('Arial','',10);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
		$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell(270,5,'No se Reportan Datos.',1,'','C',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
		
		$y=$pdf->GetY();
		$y+=5;
		// Put the position to the right of the cell
		$pdf->SetXY(5,$y);
		//footer
		$pdf->SetFont('Arial','B',10);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
		$pdf->SetFillColor(216,216,216);
		$pdf->Cell(270,5,'0 Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
	} 
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>