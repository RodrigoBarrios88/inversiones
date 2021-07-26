<?php

include_once('../../html_fns.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//post
	$nom = trim($_REQUEST["nom"]);
	$contac = trim($_REQUEST["contac"]);
	$sit = trim($_REQUEST["sit"]);
	
	$pdf=new PDF('L','mm','Letter');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'REPORTE DE EMPRESAS', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 245 ,5, 30 , 30,'JPG', '');
	
	$pdf->Ln(10);
	
	$pdf->SetWidths(array(10, 20, 45, 60, 40, 35, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
    $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$pdf->Row(array('No.', '# CODIGO', 'NOMBRE', 'DIRECCION','TELEFONOS','EMAIL','CONTACTO','SITUACION'));
	}

	$pdf->SetWidths(array(10, 20, 45, 60, 40, 35, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'L', 'L', 'J'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	$ClsEmp = new ClsEmpresa();
	$result = $ClsEmp->get_sucursal($cod,'',$nom,$contact,$sit);
	
	$i=1;
	if(is_array($result)){
		foreach($result as $row){
			$cod = trim($row["suc_id"]);
			$codigo = "# ".Agrega_Ceros($cod);
			//nombre
			$nom = $row["suc_nombre"];
			//direccion
			$dir = $row["suc_direccion"];
			//telefono 1
			$tel = Trim($row["suc_tel1"])."/".Trim($row["suc_tel2"]);
			//mail
			$mail = $row["suc_mail"];
			//contacto
			$contacto = Trim($row["suc_contacto"])." (".Trim($row["suc_cont_tel"]).")";
			//situacion
			$sit = $row["suc_situacion"];
			$sit = ($sit == 1)?"ACTIVA":"INACTIVA";
			//---
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$pdf->Row(array($no,$codigo,$nom,$dir,$tel,$mail,$contacto,$sit)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
		}
		$i--;
			$pdf->SetFont('Arial','B',8);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(270,5,$i.' Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
			
	}
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>