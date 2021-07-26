<?php
include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	$sucursal = $_SESSION["sucursal"];
	$nom = trim($_REQUEST["nom"]);
	$suc = trim($_REQUEST["suc"]);
	$usu = trim($_REQUEST["usu"]);
	$sit = trim($_REQUEST["sit"]);
	
	
	$pdf=new PDF('L','mm','Letter');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'REPORTE DE USUARIOS', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generacion: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$sucursal, 0 , 'L' , 0);
	$pdf->Image('../../Logos/replogo.jpg' , 245 ,5, 30 , 30,'JPG', '');

	
	
	$pdf->Ln(10);
	////////////////////////////////////// ENCABEZADOS ///////////////////////////////////////////
	$pdf->SetWidths(array(10, 20, 50, 50, 50, 25, 40, 25));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',10);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
        $pdf->SetTextColor(0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$pdf->Row(array('No.', 'Codigo', 'Nombre', 'Empresa','e-mail','Telefono','Rol','Situacion'));
	}

	////////////////////////////////////// CUERPO ///////////////////////////////////////////
	$pdf->SetWidths(array(10, 20, 50, 50, 50, 25, 40, 25));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'L', 'L', 'J', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	$ClsUsu = new ClsUsuario();
	$result = $ClsUsu->get_usuario($id,$suc,$nom,$mail,$nivel,$band,$sit,$usu);
	
	$i=1;
	if(is_array($result)){
		foreach($result as $row){
			//codigo
			$cod = $row["usu_id"];
			$cod = "# ".Agrega_Ceros($cod);
			//nombre
			$nom = trim($row["usu_nombre"]);
			//empresa
			$suc = $row["suc_nombre"];
			//nivel
			$niv = $row["roll_nombre"];
			//e-mail
			$mail = $row["usu_mail"];
			//telefono
			$tel = $row["usu_telefono"];
			//Situacion
			$sit = $row["usu_situacion"];
			switch ($sit){
				case 0: $sit = "INACTIVO"; break;
				case 1: $sit = "ACTIVO"; break;
			}
			//---
			$pdf->SetFont('Arial','',10);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$pdf->Row(array($no,$cod,$nom,$suc,$mail,$tel,$rol,$sit)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
		}
	
	////////////////////////////////////// PIE DE REPORTE ///////////////////////////////////////////
			$pdf->SetFont('Arial','B',10);  	// ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell(270,5,$i.' Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
			
	}else{
		$pdf->SetFont('Arial','',10);  	// ASIGNO EL TIPO Y TAMA„O DE LA LETRA
		$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell(270,5,'No se Reportan Datos.',1,'','C',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
		
		$y=$pdf->GetY();
		$y+=5;
		// Put the position to the right of the cell
		$pdf->SetXY(5,$y);
		//footer
		$pdf->SetFont('Arial','B',10);  	// ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
		$pdf->SetFillColor(216,216,216);
		$pdf->Cell(270,5,'0 Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
	} 
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>