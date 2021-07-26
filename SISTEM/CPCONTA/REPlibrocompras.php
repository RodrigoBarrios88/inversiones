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
	$ClsComp = new ClsCompra();
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
	////
	$pdf=new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'LIBRO DE COMPRAS', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Periodo del : '.$desde.' al '.$hasta, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Contador: '.$cnom. '. N�mero: '.$cnum, 0 , 'L' , 0);
	$pdf->Image('../../CONFIG/images/replogo.jpg' , 310 ,5, 40 , 30,'JPG', '');
	$pdf->Ln(5);
	
	///------ variables de calculo
		$Total = 0;
		$Rtotal = 0;
		$IVARtotal = 0;
		$TIVA = 0;
		$Tdesc = 0;
	///-----------------------------
		
			///////////////////////////////////////////////////////////////////////////
			/////////// ENCABEZADO SECCION
			$pdf->SetWidths(array(10, 15, 60, 30, 30, 20, 60, 20, 20, 20, 20, 20, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', ));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', 'COMPRA', 'PROVEEDOR', 'DOC. REF.', 'EMPRESA', 'FECHA', 'DESCRIPCI�N','CANTIDAD','PRECIO','DESCUENTO','C * P','MONTO','T/C'));
			}
			
			/////////////////////////////////////// TITULO COMPRAS ////////////////////////////////////
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,5,"  COMPRAS",1,'','L',true);
			$pdf->Ln(5);
			
			$pdf->SetWidths(array(10, 15, 60, 30, 30, 20, 60, 20, 20, 20, 20, 20, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'L', 'C', 'L', 'C', 'J', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$result = $ClsComp->get_det_compra("","","C",'',$suc,"",'',$desde,$hasta,"","",2);
			if(is_array($result)){
				//--
				$Tt = 0;
				$Ti = 0;
				$i = 1;
				foreach($result as $row){
					//codigo
					$comp = $row["com_codigo"];
					$comp = Agrega_Ceros($comp);
					//cliente
					$pro = utf8_decode($row["prov_nombre"]);
					//referencia
					$ref = utf8_decode($row["com_doc"]);
					//empresa
					$sucnom = utf8_decode($row["suc_nombre"]);
					//Fecha / Compra
					$fec = $row["com_fecha"];
					$fec = cambia_fechaHora($fec);
					//Descripcion o Articulo
					$desc = $row["dcom_detalle"];
					$desc = utf8_decode($desc);
					//Cantidad
					$cant = $row["dcom_cantidad"];
					//precio
					$pre = number_format($row["dcom_precio"], 2, '.', '');
					//descuento
					$dsc =  number_format($row["com_descuento"], 2, '.', '');
					//sub Total
					$monc = $row["dcom_tcambio"];
					$Vmonc = $row["com_tcambio"];
					$rtot = ($pre * $cant);
					$stot = $rtot - (($rtot * $dsc)/100);
					$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
					$DcambiarT = Cambio_Moneda($monc,$MonCambio,$stot);
					$Total+= $DcambiarT;
					$Rcambiar = Cambio_Moneda($monc,$MonCambio,$rtot);
					$Rtotal+= $Rcambiar;
					$stot = number_format($stot, 2, '.', '');
					//total
					$total = number_format($row["com_total"], 2, '.', '');
					$mons = $row["mon_simbolo"];
					//Moneda
					$mon = utf8_decode($row["mon_desc"]);
					//tcamb
					$tcamb = $row["com_tcambio"];
					//--
					$stot = number_format($stot, 2, '.', '');
					$Dcambiar = number_format($Dcambiar,2, '.', '');
					//--
					$Tt+= $DcambiarT;
					
					//--
					$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,$comp,$pro,$ref,$sucnom,$fec,$desc,$cant,"$mons $pre","$mons $dsc","$mons $stot","$mons $total","$tcamb X 1")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;
				}
				$i--;
				//$pdf->Ln(5);
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				/// Total Ingresos
				$pdf->SetWidths(array(305, 20, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$Tt = number_format($Tt,2,'.','');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array("", "$MonSimbol $Tt", ""));
				}
			}else{
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				$pdf->Cell(345,5,"NO COMPRAS REPORTADAS",1,'','C',true);
				$pdf->Ln(5);
			}
		
			
			/////////////////////////////////////// GASTOS ////////////////////////////////////
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,5,"  GASTOS",1,'','L',true);
			$pdf->Ln(5);
			
			$pdf->SetWidths(array(10, 15, 60, 30, 30, 20, 60, 20, 20, 20, 20, 20, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'L', 'C', 'L', 'C', 'J', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			////////////----------------------------- PRODUCTOS DESCARGADOS ---------------------------------------/////////////
			$result = $ClsComp->get_det_compra("","","G",'',$suc,"",'',$desde,$hasta,"","",2);
			//--
			$Tt = 0;
			$Ti = 0;
			if(is_array($result)){
				$sale =  0;
				$CheqCircula =  0;
				foreach($result as $row){
					//codigo
					$comp = $row["com_codigo"];
					$comp = Agrega_Ceros($comp);
					//cliente
					$pro = utf8_decode($row["prov_nombre"]);
					//referencia
					$ref = utf8_decode($row["com_doc"]);
					//empresa
					$sucnom = utf8_decode($row["suc_nombre"]);
					//Fecha / Compra
					$fec = $row["com_fecha"];
					$fec = cambia_fechaHora($fec);
					//Descripcion o Articulo
					$desc = $row["dcom_detalle"];
					$desc = utf8_decode($desc);
					//Cantidad
					$cant = $row["dcom_cantidad"];
					//precio
					$pre = number_format($row["dcom_precio"], 2, '.', '');
					//descuento
					$dsc =  number_format($row["com_descuento"], 2, '.', '');
					//sub Total
					$monc = $row["dcom_tcambio"];
					$Vmonc = $row["com_tcambio"];
					$rtot = ($pre * $cant);
					$stot = $rtot - (($rtot * $dsc)/100);
					$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
					$DcambiarT = Cambio_Moneda($monc,$MonCambio,$stot);
					$Total+= $DcambiarT;
					$Rcambiar = Cambio_Moneda($monc,$MonCambio,$rtot);
					$Rtotal+= $Rcambiar;
					$stot = number_format($stot, 2, '.', '');
					//total
					$total = number_format($row["com_total"], 2, '.', '');
					$mons = $row["mon_simbolo"];
					//Moneda
					$mon = utf8_decode($row["mon_desc"]);
					//tcamb
					$tcamb = $row["com_tcambio"];
					//--
					$stot = number_format($stot, 2, '.', '');
					$Dcambiar = number_format($Dcambiar,2, '.', '');
					//--
					$Tt+= $DcambiarT;
					
					//--
					$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,$comp,$pro,$ref,$sucnom,$fec,$desc,$cant,"$mons $pre","$mons $dsc","$mons $stot","$mons $total","$tcamb X 1")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;
				}
					$i--;
					//$pdf->Ln(5);
					$pdf->SetFont('Arial','B',6);  
					$pdf->SetFillColor(216,216,216);
					/// Total Ingresos
					$pdf->SetWidths(array(305, 20, 20));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$pdf->SetAligns(array('R', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$Tt = number_format($Tt,2,'.','');
					for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
						$pdf->Row(array("", "$MonSimbol $Tt", ""));
					}
			}else{
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				$pdf->Cell(345,5,"NO HAY GASTOS REPORTADOS",1,'','C',true);
				$pdf->Ln(5);
			}
			
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(216,216,216);
				
				/// Total descuentos
				$pdf->SetWidths(array(305, 40));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$Tsedc = $Rtotal - $Total;//saca la diferencia entre los descuentos y el precio real
				$Tsedc = number_format($Tsedc, 2, '.', '');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('TOTAL DE DESCUENTOS  ', $MonSimbol.'. '.$Tsedc));
				}
				
				/// Total de ingresos SIN factura
				$pdf->SetWidths(array(305, 40));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$SinFactura = number_format(($Total - $IVARtotal), 2, '.', '');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('TOTAL COMPRAS Y GASTOS  ', $MonSimbol.'. '.$SinFactura));
				}
				
				/// MONEDA BASE DE CUALCULOS
				$pdf->SetWidths(array(305, 40));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('MONEDA DE CALCULO  ', $MonDesc.'('.$MonSimbol.')'));
				}
			
			$pdf->Ln(5);
			
			
	
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output("Movimiento de Punto de Venta $desc.pdf","I");

?>