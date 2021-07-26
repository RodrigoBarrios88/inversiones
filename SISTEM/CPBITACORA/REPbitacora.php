<?php

include_once('../html_fns.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	$usu = trim($_REQUEST["cat"]);
	$suc = trim($_REQUEST["suc"]);
	$fini = trim($_REQUEST["fini"]);
	$ffin = trim($_REQUEST["ffin"]);
	$mod = trim($_REQUEST["mod"]);
	$acc = trim($_REQUEST["acc"]);
	
	$pdf=new PDF('L','mm','Letter');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'REPORTE DE BITACORA DEL SISTEMA', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->Image('../../CONFIG/images/replogo.jpg' , 245 ,5, 30 , 30,'JPG', '');
	
	$pdf->Ln(10);
	
	$pdf->SetWidths(array(10, 35, 45, 50, 50, 80));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',10);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
        $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$pdf->Row(array('No.', '# TRANSACCION', 'FECHA/HORA', 'USUARIO','MODULO','DESCRIPCION'));
	}

	$pdf->SetWidths(array(10, 35, 45, 50, 50, 80));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'L', 'L', 'J'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	$ClsBit = new ClsBitacora();
	$result = $ClsBit->get_bitacora("",$suc,$usu,$mod,$acc,$fini,$ffin);
	
	$i=1;
	if(is_array($result)){
		foreach($result as $row){
			$numero = "# ".trim($row["bit_id"]);
			//fecha
			$fec = $row["bit_fec_hor"];
			$fec = cambia_fechaHora($fec);
			//Quien Nombre
			$usu = trim($row["usu_usuario"]);
			//Quien Nombre
			$nom = trim($row["usu_nombre"])." (".$usu.")";
			//Modulo
			$modu = trim($row["bit_modulo"]);
			switch ($modu){
				case "ING": $moddes = "INGRESOS"; break;
				case "USU": $moddes = "USUARIOS"; break;
				case "REG": $moddes = "REGISTRO DE ACCIONES"; break;
			}
			//descripcion
			$obs = trim($row["bit_obs"]);
			//---
			$pdf->SetFont('Arial','',10);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Row(array($i.".",$numero,$fec,$nom,$moddes,$obs)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
		}
			$pdf->SetFont('Arial','B',10);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(270,5,$i.' Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
			
	}
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>