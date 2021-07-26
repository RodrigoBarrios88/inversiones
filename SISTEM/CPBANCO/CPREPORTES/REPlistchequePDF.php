<?php

include_once('../../html_fns.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empresa'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$cue = $_REQUEST["cue"];
	$ban = $_REQUEST["ban"];
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	$sit = $_REQUEST["sit"];
	//--
	
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_cuenta_banco($cue,$ban);
	
	if(is_array($result)){
		foreach($result as $row){
			$num = utf8_decode($row["cueb_ncuenta"]);
			$nom = utf8_decode($row["cueb_nombre"]);
			$bann = utf8_decode($row["ban_desc_ct"]);
		}	
	}	
	
	$titulo = "Reporte de Cheques de la Cuenta No. $num ($nom) del Banco $bann, del $desde al $hasta";
	
	$pdf=new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, $titulo, 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 320 ,5, 30 , 30,'JPG', '');
	
	$pdf->Ln(10);
	
	$pdf->SetWidths(array(10, 40, 45, 80, 135, 35));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
    $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$pdf->Row(array('No.', 'MONTO', 'FECHA','A NOMBRE DE QUIEN','CONCEPTO/MOTIVO','SITUACION'));
	}

	$pdf->SetWidths(array(10, 40, 45, 80, 135, 35));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'L', 'L', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	$result = $ClsBan->get_cheque('',$cue,$ban,'','',$desde,$hasta,$sit);
	
	$i=1;
	if(is_array($result)){
		foreach($result as $row){
			$cod = trim($row["suc_id"]);
			$codigo = "# ".Agrega_Ceros($cod);
			//monto
			$mons = $row["mon_simbolo"];
			$monto = number_format($row["che_monto"],2, '.', ',');
			//fecha
			$fec = $row["che_fechor"];
			$fec = $ClsBan->cambia_fechaHora($fec);
			//quien
			$quien = utf8_decode($row["che_quien"]);
			//concepto
			$concepto = utf8_decode($row["che_concepto"]);
			//situacion
			$sit = $row["che_situacion"];
			switch($sit){
				case 1: $color = '79,118,221'; $sitdesc = "En Circulaci�n"; break;
				case 2: $color = '43,161,24'; $sitdesc = "Cheque Pagado"; break;
				case 0: $color = '171,14,26'; $sitdesc = "Cheque Anulado"; break;
			}
			//---
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$pdf->Row(array($no,"$mons $monto",$fec,$quien,$concepto,$sitdesc),array("0,0,0","0,0,0","0,0,0","0,0,0","0,0,0",$color)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;	
		}
		$i--;
			$pdf->SetFont('Arial','B',8);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(345,5,$i.' Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
			
	}
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>