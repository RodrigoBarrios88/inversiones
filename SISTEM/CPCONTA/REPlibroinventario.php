<?php

include_once('html_fns_contabilidad.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empresa'];
	//post
	$suc = trim($_REQUEST["suc"]);
	$desde = trim($_REQUEST["desde"]);
	$hasta = trim($_REQUEST["hasta"]);
	$cnum = trim($_REQUEST["cnum"]);
	$cnom = trim($_REQUEST["cnom"]);
	//--
	$cnum = trim(trim($cnum));
	$cnom = trim(trim($cnom));
	//--
	////////////// DATOS DE LA MONEDA POR DEFECTO ////////////////
	$ClsMon = new ClsMoneda();
	$ClsArt = new ClsArticulo();
	$ClsArtPro = new ClsArticuloPropio();
	$ClsSum = new ClsSuministro();
	$ClsEmp = new ClsEmpresa();
	
	///--
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$MonDesc = utf8_encode($row["mon_desc"]);
			$MonSimbol = utf8_encode($row["mon_simbolo"]);
			$MonCambio = trim($row["mon_cambio"]);
		}	
	}	
	////
	
	$result = $ClsEmp->get_sucursal($suc);
	if(is_array($result)){
		foreach($result as $row){
			$empresa = utf8_decode($row["suc_nombre"]);
		}	
	}	
	
	$pdf=new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'LIBRO DE INVENTARIO', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Periodo del : '.$desde.' al '.$hasta, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Contador: '.$cnom. '. N�mero: '.$cnum, 0 , 'L' , 0);
	$pdf->Image('../../CONFIG/images/replogo.jpg' , 310 ,5, 40 , 30,'JPG', '');
	$pdf->Ln(5);
	
	///-----------------------------
	///// VARIABLES GLOBALES ///////
	$TotalGeneral = 0;
		///////////////////////////////////////ARTICULOS A LA VENTA ////////////////////////////////////
			/////////////////////////////////////// ARTICULOS A LA VENTA ////////////////////////////////////
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,5,"  INVENTARIO DE ARTICULOS A LA VENTA",1,'','L',true);
			$pdf->Ln(5);
			
			/////////// ENCABEZADO SECCION
			$pdf->SetWidths(array(10, 60, 55, 90, 30, 20, 30, 30, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', 'NOMBRE', 'MARCA', 'DESCRIPCI�N', 'PRECIO', 'EXISTENCIA', 'VALOR TOTAL', 'MONEDA', 'TIPO/CAMBIO'));
			}
			$pdf->SetWidths(array(10, 60, 55, 90, 30, 20, 30, 30, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'L', 'L', 'L', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$result = $ClsArt->get_articulo('','','','','','','','','',$suc);
			$TotalTipo = 0;
			if(is_array($result)){
				$i = 1;
				foreach($result as $row){
					$exist = $row["art_cant_suc"];
					if($exist > 0){
						//nombre
						$articulo = utf8_decode($row["art_nombre"]);
						//marca
						$marca = utf8_decode($row["art_marca"]);
						//desc
						$desc = utf8_decode($row["art_desc"]);
						//Precio de Venta
						$mon = $row["mon_simbolo"];
						$prev = $row["art_precio"];
						$precio_venta = $mon.'. '.number_format($prev, 2, '.', '');
						//Existencia
						$cant = $row["art_cant_suc"];
						//VAlor Total
						$tcamb = $row["mon_cambio"];
						$vtottal = Cambio_Moneda($tcamb,$MonCambio,($prev * $cant));
						$TotalTipo+= $vtottal;
						$TotalGeneral+= $vtottal;
						$vtottal = $mon.'. '.number_format($vtottal, 2, '.', ',');
						//Moneda
						$moneda = utf8_decode($row["mon_desc"]);
						//Tipo Cambio
						$tcambio = $row["mon_cambio"].' X '.$MonCambio;
						//--
						$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
						$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
						$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
						$no = $i.".";
						$pdf->Row(array($no,$articulo,$marca,$desc,$precio_venta,$cant,$vtottal,$moneda,$tcambio)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
						$i++;
					}
				}
				$i--;
				if($i <= 0){
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->Cell(345,5,"NO HAY EXISTENCIA DE ARTICULOS A LA VENTA",1,'','C',true);
					$pdf->Ln(5);
				}
				//$pdf->Ln(5);
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				/// Total de Inventario por tipo
				$pdf->SetWidths(array(265, 30, 30, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$TotalTipo = number_format($TotalTipo,2,'.',',');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array("", "$MonSimbol $TotalTipo", "$MonDesc", "1 X $MonCambio"));
				}
			}else{
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(345,5,"NO HAY ARTICULOS A LA VENTA",1,'','C',true);
				$pdf->Ln(5);
			}
		
		/////////////////////////////////////// ARTICULOS PARA SUMINISTROS ////////////////////////////////////
			/////////////////////////////////////// ARTICULOS A LA VENTA ////////////////////////////////////
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,5,"  INVENTARIO DE SUMINISTROS",1,'','L',true);
			$pdf->Ln(5);
			
			/////////// ENCABEZADO SECCION
			$pdf->SetWidths(array(10, 60, 55, 90, 30, 20, 30, 30, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', 'NOMBRE', 'MARCA', 'DESCRIPCI�N', 'PRECIO', 'EXISTENCIA', 'VALOR TOTAL', 'MONEDA', 'TIPO/CAMBIO'));
			}
			$pdf->SetWidths(array(10, 60, 55, 90, 30, 20, 30, 30, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'L', 'L', 'L', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$result = $ClsSum->get_articulo('','','','','','','','','',$suc);
			$TotalTipo = 0;
			if(is_array($result)){
				$i = 1;
				foreach($result as $row){
					$exist = $row["art_cant_suc"];
					if($exist > 0){
						//nombre
						$articulo = utf8_decode($row["art_nombre"]);
						//marca
						$marca = utf8_decode($row["art_marca"]);
						//desc
						$desc = utf8_decode($row["art_desc"]);
						//Precio de Venta
						$mon = $row["mon_simbolo"];
						$prev = $row["art_precio"];
						$precio_venta = $mon.'. '.number_format($prev, 2, '.', '');
						//Existencia
						$cant = $row["art_cant_suc"];
						//VAlor Total
						$tcamb = $row["mon_cambio"];
						$vtottal = Cambio_Moneda($tcamb,$MonCambio,($prev * $cant));
						$TotalTipo+= $vtottal;
						$TotalGeneral+= $vtottal;
						$vtottal = $mon.'. '.number_format($vtottal, 2, '.', ',');
						//Moneda
						$moneda = utf8_decode($row["mon_desc"]);
						//Tipo Cambio
						$tcambio = $row["mon_cambio"].' X '.$MonCambio;
						//--
						$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
						$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
						$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
						$no = $i.".";
						$pdf->Row(array($no,$articulo,$marca,$desc,$precio_venta,$cant,$vtottal,$moneda,$tcambio)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
						$i++;
					}
				}
				$i--;
				if($i <= 0){
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->Cell(345,5,"NO HAY EXISTENCIA DE SUMINISTROS",1,'','C',true);
					$pdf->Ln(5);
				}
				//$pdf->Ln(5);
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				/// Total de Inventario por tipo
				$pdf->SetWidths(array(265, 30, 30, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$TotalTipo = number_format($TotalTipo,2,'.',',');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array("", "$MonSimbol $TotalTipo", "$MonDesc", "1 X $MonCambio"));
				}
			}else{
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(345,5,"NO HAY SUMINISTROS",1,'','C',true);
				$pdf->Ln(5);
			}
			
		/////////////////////////////////////// MOBILIARIO Y EQUIPO ////////////////////////////////////
			/////////////////////////////////////// ARTICULOS A LA VENTA ////////////////////////////////////
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,5,"  INVENTARIO DE MOBILIARIO Y EQUIPO",1,'','L',true);
			$pdf->Ln(5);
			
			/////////// ENCABEZADO SECCION
			$pdf->SetWidths(array(10, 60, 55, 90, 30, 20, 30, 30, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', 'NOMBRE', 'MARCA', 'DESCRIPCI�N', 'PRECIO', 'EXISTENCIA', 'VALOR TOTAL', 'MONEDA', 'TIPO/CAMBIO'));
			}
			$pdf->SetWidths(array(10, 60, 55, 90, 30, 20, 30, 30, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'L', 'L', 'L', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$result = $ClsArtPro->get_inventario('','','','','','',$suc,1);
			$TotalTipo = 0;
			if(is_array($result)){
				$i = 1;
				foreach($result as $row){
					$exist = $row["art_cant_suc"];
					if($exist > 0){
						//nombre
						$articulo = utf8_decode($row["art_nombre"]);
						//marca
						$marca = utf8_decode($row["inv_marca"]);
						//desc
						$desc = utf8_decode($row["inv_desc"]);
						//Precio de Venta
						$mon = $row["mon_simbolo"];
						$prev = $row["art_precio_actual"];
						$precio_venta = $mon.'. '.number_format($prev, 2, '.', '');
						//Existencia
						$cant = 1;
						//VAlor Total
						$tcamb = $row["mon_cambio"];
						$vtottal = Cambio_Moneda($tcamb,$MonCambio,($prev * $cant));
						$TotalTipo+= $vtottal;
						$TotalGeneral+= $vtottal;
						$vtottal = $mon.'. '.number_format($vtottal, 2, '.', ',');
						//Moneda
						$moneda = $MonDesc;
						//Tipo Cambio
						$tcambio = $row["mon_cambio"].' X '.$MonCambio;
						//--
						$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
						$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
						$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
						$no = $i.".";
						$pdf->Row(array($no,$articulo,$marca,$desc,$precio_venta,$cant,$vtottal,$moneda,$tcambio)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
						$i++;
					}
				}
				$i--;
				if($i <= 0){
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->Cell(345,5,"NO HAY EXISTENCIA DE MOBILIARIO Y EQUIPO",1,'','C',true);
					$pdf->Ln(5);
				}
				//$pdf->Ln(5);
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				/// Total de Inventario por tipo
				$pdf->SetWidths(array(265, 30, 30, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$TotalTipo = number_format($TotalTipo,2,'.',',');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array("", "$MonSimbol $TotalTipo", "$MonDesc", "1 X $MonCambio"));
				}
			}else{
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(345,5,"NO HAY MOBILIARIO Y EQUIPO",1,'','C',true);
				$pdf->Ln(5);
			}	
			
			
			
		$pdf->SetFont('Arial','B',8);  
		$pdf->SetFillColor(216,216,216);
				
		/// Total de Inventario por tipo
		$pdf->SetWidths(array(265, 30, 30, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		$pdf->SetAligns(array('R', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		$TotalGeneral = number_format($TotalGeneral,2,'.',',');
		for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
			$pdf->Row(array("VALOR TOTAL DE INVENTARIO  ", "$MonSimbol $TotalGeneral", "$MonDesc", "1 X $MonCambio"));
		}
		
		$pdf->Ln(5);
		
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output("Movimiento de Punto de Venta $desc.pdf","I");

?>