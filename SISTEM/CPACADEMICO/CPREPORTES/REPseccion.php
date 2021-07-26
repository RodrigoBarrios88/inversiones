<?php
include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["codigo"];
	$arma = $_SESSION["arma"];
	//$_POST
	$pensum = trim($_REQUEST["pensum"]);
	$nivel = trim($_REQUEST["nivel"]);
	$grado = trim($_REQUEST["grado"]);
	$tipo = trim($_REQUEST["tipo"]);
	$sit = trim($_REQUEST["sit"]);
	
	
	
	$pdf=new PDF('L','mm','Letter');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'REPORTE DE SECCIONES POR GRADOS Y NIVELES', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, utf8_decode('Fecha/Hora de generación: ').date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por Nombre: '.$nombre, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 240 ,5, 32 , 25,'JPG', '');

	
	
	$pdf->Ln(10);
	////////////////////////////////////// ENCABEZADOS ///////////////////////////////////////////
	$pdf->SetWidths(array(10, 90, 40, 45, 40, 25, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C',));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',10);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
        $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$pdf->Row(array('No.', 'Pensum', 'Nivel', 'Grado', 'Nombre','Tipo',utf8_decode('Situación')));
	}

	////////////////////////////////////// CUERPO ///////////////////////////////////////////
	$pdf->SetWidths(array(10, 90, 40, 45, 40, 25, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	$ClsPen = new ClsPensum();
	$result = $ClsPen->get_seccion($pensum,$nivel,$grado,'',$tipo,$sit);
	
	$i=1;
	if(is_array($result)){
		foreach($result as $row){
			//pensum
			$pen = utf8_decode($row["pen_descripcion_completa"]);
			//nivel
			$niv = utf8_decode($row["niv_descripcion"]);
			//grado
			$sem = utf8_decode($row["gra_descripcion"]);
			//nombre
			$nombre = utf8_decode($row["sec_descripcion"]);
			//tipo
			$tipo = $row["sec_tipo"];
			switch ($tipo){
				case 'A': $tipo = "ACADEMICA"; break;
				case 'P': $tipo = "PRACTICA"; break;
				case 'D': $tipo = "DEPORTIVA"; break;
			}
			//Situacion
			$sit = $row["sec_situacion"];
			switch ($sit){
				case 0: $sit = "INACTIVA"; break;
				case 1: $sit = "ACTIVA"; break;
			}
			//---
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$pdf->Row(array($no,$pen,$niv,$sem,$nombre,$tipo,$sit)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
		}
		$i--;
	
	////////////////////////////////////// PIE DE REPORTE ///////////////////////////////////////////
			$pdf->SetFont('Arial','B',10);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(270,5,$i.' Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
			
	}else{
		$pdf->SetFont('Arial','',8);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
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