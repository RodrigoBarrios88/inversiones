<?php

include_once('../../html_fns.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empresa'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//post
	$suc = trim($_REQUEST["suc"]);
	$art = trim($_REQUEST["art"]);
	$gru = trim($_REQUEST["gru"]);
	$desc = trim($_REQUEST["desc"]);
	$marca = trim($_REQUEST["marca"]);
	
	$pdf=new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'REPORTE DE INVENTARIO DE MAQUINARIA EQUIPO', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 315 ,5, 35 , 30,'JPG', '');
	
	$pdf->Ln(10);
	
	$pdf->SetWidths(array(10, 60, 110, 65, 40, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',10);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
    $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$pdf->Row(array('No.', 'GRUPO', 'DESCRIPCI�N', 'MARCA','No.PARTE','PREC.INI.','PREC.ACTUAL'));
	}

	$pdf->SetWidths(array(10, 60, 110, 65, 40, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'L', 'J', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	$ClsArt = new ClsArticuloPropio();
	$result = $ClsArt->get_inventario('',$gru,$art,'',$desc,$marca,$suc,1);
	
	$i=1;
	if(is_array($result)){
		foreach($result as $row){
			//nombre
			$grun = utf8_decode($row["gru_nombre"]);
			//desc
			$desc = utf8_decode($row["art_desc"]);
			//marca
			$marca = utf8_decode($row["art_marca"]);
			//numero
			$num = $row["inv_numero"];
			//precio
			$mon = $row["mon_simbolo"];
			$prec = $row["inv_precio_inicial"];
			$precini = $mon.'. '.$prec;
			//precio
			$mon = $row["mon_simbolo"];
			$prec = $row["inv_precio_actual"];
			$precact = $mon.'. '.$prec;
			//---
			$pdf->SetFont('Arial','',10);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$pdf->Row(array($no,$grun,$desc,$marca,$num,$precini,$precact)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
		}
		$i--;
			$pdf->SetFont('Arial','B',10);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(345,5,$i.' Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
			
	}
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>