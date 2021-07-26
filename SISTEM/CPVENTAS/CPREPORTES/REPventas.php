<?php

include_once('html_fns_reportes.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empresa'];
	$empCodigo = $_SESSION['empCodigo'];
	//post
	$suc = trim($_REQUEST["suc"]);
	$regimen = trim($_REQUEST["regimen"]);
	$desde = trim($_REQUEST["desde"]);
	$hasta = trim($_REQUEST["hasta"]);
	$cfac = trim($_REQUEST["cfac"]);
	$cnum = trim($_REQUEST["cnum"]);
	$cnom = trim($_REQUEST["cnom"]);
	//--
	$cnum = trim(trim($cnum));
	$cnom = trim(trim($cnom));
	//--
	////////////// DATOS DE LA MONEDA POR DEFECTO ////////////////
	$ClsMon = new ClsMoneda();
	$ClsVent = new ClsVenta();
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
	////////////// DATOS DEL REGIMEN TRIBUTARIO ////////////////
	if($regimen == 1){
		$regimen_desc = "RÉGIMEN DE PEQUEÑO CONTRIBUYENTE";
		$iva_procent = 0;
	}else if($regimen == 2){
		$regimen_desc = "RÉGIMEN OPCIONAL SIMPLIFICADO SOBRE INGRESOS DE ACTIVIDADES LUCRATIVAS";
		$iva_procent = 12;
	}else if($regimen == 3){
		$regimen_desc = "RÉGIMEN SOBRE LAS UTILIDADES DE ACTIVIDADES LUCRATIVAS";
		$iva_procent = 12;
	}else{
		$iva_procent = 0;
		$regimen_desc = "SELECIONE UN RÉGIMEN TRIBUTARIO";
	}
	$regimen_desc = utf8_decode($regimen_desc);
	////
	
	$pdf=new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'REPORTE DE VENTAS', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Periodo del : '.$desde.' al '.$hasta, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, utf8_decode('Régimen Tributario : ').$regimen_desc, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 310 , 5, 40 , 30,'JPG', '');
	$pdf->Ln(5);
	
	///------ variables de calculo
		$Total = 0;
		$Rtotal = 0;
		$IVARtotal = 0;
		$TIVA = 0;
		$Tdesc = 0;
	///-----------------------------
		
		/////////////////////////////////////// VALIDACIÓN DEL RÉGIMEN TRIBUTARIO ////////////////////////////////////
		if($regimen == ""){
			$pdf->SetFont('Arial','B',10);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,140,140);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,8,utf8_decode("NO HA SELECCIONADO RÉGIMEN TRIBUTARIO!"),1,'','C',true);
			$pdf->Ln(13);
		}
		/////////////////////////////////////// VALIDACIÓN DEL RÉGIMEN TRIBUTARIO ////////////////////////////////////
		
			///////////////////////////////////////MOVIMIENTOS DEL PUNTO DE VENTA ////////////////////////////////////
			/////////// ENCABEZADO SECCION
			$pdf->SetWidths(array(10, 15, 20, 30, 30, 30, 20, 20, 30, 20, 20, 20, 20, 20, 20, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('No.', 'VENTA', 'FACTURA', 'CLIENTE', 'EMPRESA', 'P.VENTA', 'FECHA', 'LOTE','DESCRIPCIÓN','CANTIDAD','PRECIO','DESCUENTO','C * P','T/C','TOTAL','IVA'));
			}
			
			/////////////////////////////////////// TITULO SERVICIOS ////////////////////////////////////
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,5,"  VENTA DE SERVICIOS",1,'','L',true);
			$pdf->Ln(5);
			
			$pdf->SetWidths(array(10, 15, 20, 30, 30, 30, 20, 20, 30, 20, 20, 20, 20, 20, 20, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'L', 'L', 'L', 'C', 'C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			$result = $ClsVent->get_hist_venta_servicios('','','','','','','','',$desde,$hasta,$con_fac,"1,2");
			if(is_array($result)){
				//--
				$Tt = 0;
				$Ti = 0;
				$i = 1;
				foreach($result as $row){
					//Venta
					$vent = $row["ven_codigo"];
					$vent = Agrega_Ceros($vent);
					//Factura
					$fac = $row["ven_ser_numero"]." ".Agrega_Ceros($row["ven_fac_numero"]);
					//Cliente
					$cli = utf8_decode($row["cli_nombre"]);
					//empresa
					$sucnombre = utf8_decode($row["suc_nombre"]);
					//Punto de Venta
					$pv = utf8_decode($row["pv_nombre"]);
					//Fecha / Venta
					$fec = $row["ven_fecha"];
					$fec = cambia_fecha($fec);
					//lote - no existe este campo en servicios -
					$lote = '---';
					//Descripcion o Articulo
					$desc = utf8_decode($row["dven_detalle"]);
					//Cantidad
					$cant = $row["dven_cantidad"];
					//Precio Venta.
					$pre = number_format($row["dven_precio"], 2, '.', '');
					$mons = $row["mon_simbolo"];
					$Vmons = $row["mon_simbolo_venta"];
					//Descuento
					$dsc = $row["dven_descuento"];
					//sub Total
					$monc = $row["dven_tcambio"];
					$Vmonc = $row["ven_tcambio"];
					$rtot = $row["dven_total"];
					$stot = $stot = $row["dven_subtotal"];
					$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
					$DcambiarT = Cambio_Moneda($monc,$MonCambio,$stot);
					$Total+= $DcambiarT;
					$Rcambiar = Cambio_Moneda($monc,$MonCambio,$rtot);
					$Rtotal+= $Rcambiar;
					//Iva
					$faciva = $row["ven_factura"];
					if($faciva == 1){
						$iva = ($stot * $iva_procent)/100;
						$iva = number_format($iva, 2, '.', '');
						$TIVA+=$iva;
						$IVARtotal += ($DcambiarT);
					}else{
						$iva = 0;
					}
					//--
					$stot = number_format($stot, 2, '.', '');
					$Dcambiar = number_format($Dcambiar,2, '.', '');
					$iva = number_format($iva,2, '.', '');
					//--
					$Tt+= $DcambiarT;
					$Ti+=$iva;
					
					//--
					$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,$vent,$fac,$cli,$sucnombre,$pv,$fec,$lote,$desc,$cant,"$mons $pre","$mons $dsc","$mons $stot","$monc X 1","$MonSimbol $Dcambiar","$MonSimbol $iva")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;
				}
				$i--;
				//$pdf->Ln(5);
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				/// Total Ingresos
				$pdf->SetWidths(array(305, 20, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$Tt = number_format($Tt,2,'.','');
				$Ti = number_format($Ti,2,'.','');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array("", "$MonSimbol $Tt", "$MonSimbol $Ti"));
				}
			}else{
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				$pdf->Cell(345,5,"NO HAY SERVICIOS VENDIDOS",1,'','C',true);
				$pdf->Ln(5);
			}
		
			
			/////////////////////////////////////// VENTA DE PRODUCTOS VENDIDOS Y DESCARGADOS ////////////////////////////////////
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,5,"  PRODUCTO VENDIDO Y DESCARGADO DE INVENTARIO",1,'','L',true);
			$pdf->Ln(5);
			
			$pdf->SetWidths(array(10, 15, 20, 30, 30, 30, 20, 20, 30, 20, 20, 20, 20, 20, 20, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'L', 'L', 'L', 'C', 'C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			////////////----------------------------- PRODUCTOS DESCARGADOS ---------------------------------------/////////////
			$result = $ClsVent->get_hist_venta_lotes('','','','','',$suc,'','',$desde,$hasta,$con_fac,"1,2");
			//--
			$Tt = 0;
			$Ti = 0;
			if(is_array($result)){
				$sale =  0;
				$CheqCircula =  0;
				foreach($result as $row){
					//Venta
					$vent = $row["ven_codigo"];
					$vent = Agrega_Ceros($vent);
					//Factura
					$fac = $row["ven_ser_numero"]." ".Agrega_Ceros($row["ven_fac_numero"]);
					//Cliente
					$cli = utf8_decode($row["cli_nombre"]);
					//empresa
					$sucnom = utf8_decode($row["suc_nombre"]);
					//Punto de Venta
					$pv = utf8_decode($row["pv_nombre"]);
					//Fecha / Venta
					$fec = $row["ven_fecha"];
					$fec = cambia_fecha($fec);
					//Lote
					$lote = Agrega_Ceros($row["lot_codigo"])."-".Agrega_Ceros($row["lot_articulo"])."-".Agrega_Ceros($row["lot_grupo"]);
					//Descripcion o Articulo
					$desc = utf8_decode($row["dven_detalle"]);
					//Cantidad
					$cant = $row["det_cantidad"];
					//Precio Venta.
					$pre = number_format($row["dven_precio"], 2, '.', '');
					//Descuento
					//Descuento
					$dsc = $row["dven_descuento"];
					//sub Total
					$monc = $row["dven_tcambio"];
					$Vmonc = $row["ven_tcambio"];
					$rtot = $row["dven_total"];
					$stot = $stot = $row["dven_subtotal"];
					$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
					$DcambiarT = Cambio_Moneda($monc,$MonCambio,$stot);
					$Total+= $DcambiarT;
					$Rcambiar = Cambio_Moneda($monc,$MonCambio,$rtot);
					$Rtotal+= $Rcambiar;
					//Iva
					$faciva = $row["ven_factura"];
					if($faciva == 1){
						$iva = ($stot * $iva_procent)/100;
						$iva = number_format($iva, 2, '.', '');
						$TIVA+=$iva;
						$IVARtotal += ($DcambiarT);
					}else{
						$iva = 0;
					}
					//--
					$stot = number_format($stot, 2, '.', '');
					$Dcambiar = number_format($Dcambiar,2, '.', '');
					$iva = number_format($iva,2, '.', '');
					//--
					$Tt+= $DcambiarT;
					$Ti+=$iva;
					$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,$vent,$fac,$cli,$sucnom,$pv,$fec,$lote,$desc,$cant,"$mons $pre","$mons $dsc","$mons $stot","$monc X 1","$MonSimbol $Dcambiar","$MonSimbol $iva")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;
				}
					$i--;
					//$pdf->Ln(5);
					$pdf->SetFont('Arial','B',6);  
					$pdf->SetFillColor(216,216,216);
					/// Total Ingresos
					$pdf->SetWidths(array(305, 20, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$pdf->SetAligns(array('R', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$Tt = number_format($Tt,2,'.','');
					$Ti = number_format($Ti,2,'.','');
					for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
						$pdf->Row(array("", "$MonSimbol $Tt", "$MonSimbol $Ti"));
					}
			}else{
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				$pdf->Cell(345,5,"NO HAY PRODUCTOS VENDIDOS YA DESCARGADOS DE INVENTARIO",1,'','C',true);
				$pdf->Ln(5);
			}
			
			/////////////////////////////////////// VENTA DE PRODUCTOS VENDIDOS SIN DESCARGAR ////////////////////////////////////
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,5,"  PRODUCTO VENDIDO PENDIENTE DE DESCARGAR DE INVENTARIO",1,'','L',true);
			$pdf->Ln(5);
			
			$pdf->SetWidths(array(10, 15, 20, 30, 30, 30, 20, 20, 30, 20, 20, 20, 20, 20, 20, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'L', 'L', 'L', 'C', 'C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			////////////----------------------------- PRODUCTOS NO DESCARGADOS ---------------------------------------/////////////
			$result = $ClsVent->get_det_venta_producto('','','P',0,'','',$suc,'','',$desde,$hasta,$con_fac,"1,2");
			//--
			$Tt = 0;
			$Ti = 0;
			if(is_array($result)){
				$sale =  0;
				$CheqCircula =  0;
				foreach($result as $row){
					//Venta
					$vent = $row["ven_codigo"];
					$vent = Agrega_Ceros($vent);
					//Factura
					$fac = $row["ven_ser_numero"]." ".Agrega_Ceros($row["ven_fac_numero"]);
					//Cliente
					$cli = utf8_decode($row["cli_nombre"]);
					//empresa
					$sucnom = utf8_decode($row["suc_nombre"]);
					//Punto de Venta
					$pv = utf8_decode($row["pv_nombre"]);
					//Fecha / Venta
					$fec = $row["ven_fecha"];
					$fec = cambia_fecha($fec);
					//Lote
					$lote = Agrega_Ceros($row["lot_codigo"])."-".Agrega_Ceros($row["lot_articulo"])."-".Agrega_Ceros($row["lot_grupo"]);
					//Descripcion o Articulo
					$desc = utf8_decode($row["dven_detalle"]);
					//Cantidad
					$cant = $row["dven_cantidad"];
					//Precio Venta.
					$pre = number_format($row["dven_precio"], 2, '.', '');
					//Descuento
					//Descuento
					$dsc = $row["dven_descuento"];
					//sub Total
					$monc = $row["dven_tcambio"];
					$Vmonc = $row["ven_tcambio"];
					$rtot = $row["dven_total"];
					$stot = $stot = $row["dven_subtotal"];
					$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
					$DcambiarT = Cambio_Moneda($monc,$MonCambio,$stot);
					$Total+= $DcambiarT;
					$Rcambiar = Cambio_Moneda($monc,$MonCambio,$rtot);
					$Rtotal+= $Rcambiar;
					//Iva
					$faciva = $row["ven_factura"];
					if($faciva == 1){
					$iva = ($stot * $iva_procent)/100;
					$iva = number_format($iva, 2, '.', '');
					$TIVA+=$iva;
					$IVARtotal += ($DcambiarT);
					}else{
					$iva = 0;
					}
					//--
					$stot = number_format($stot, 2, '.', '');
					$Dcambiar = number_format($Dcambiar,2, '.', '');
					$iva = number_format($iva,2, '.', '');
					//--
					$Tt+= $DcambiarT;
					$Ti+=$iva;
					$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,$vent,$fac,$cli,$sucnom,$pv,$fec,$lote,$desc,$cant,"$mons $pre","$mons $dsc","$mons $stot","$monc X 1","$MonSimbol $Dcambiar","$MonSimbol $iva")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;
				}
					$i--;
					//$pdf->Ln(5);
					$pdf->SetFont('Arial','B',6);  
					$pdf->SetFillColor(216,216,216);
					/// Total Ingresos
					$pdf->SetWidths(array(305, 20, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$pdf->SetAligns(array('R', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$Tt = number_format($Tt,2,'.','');
					$Ti = number_format($Ti,2,'.','');
					for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
						$pdf->Row(array("", "$MonSimbol $Tt", "$MonSimbol $Ti"));
					}
			}else{
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				$pdf->Cell(345,5,"NO HAY PRODUCTOS VENDIDOS PENDIENTES DE DESCARGADOS A INVENTARIO",1,'','C',true);
				$pdf->Ln(5);
			}
			
			/////////////////////////////////////// VENTA DE OTROS SERVICIOS O PRODUCTOS ////////////////////////////////////
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,5,"  OTROS",1,'','L',true);
			$pdf->Ln(5);
			
			$pdf->SetWidths(array(10, 15, 20, 30, 30, 30, 20, 20, 30, 20, 20, 20, 20, 20, 20, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'L', 'L', 'L', 'C', 'C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			////////////----------------------------- OTROS ---------------------------------------/////////////
			$result = $ClsVent->get_det_venta('','','O','','',$suc,'','',$desde,$hasta,$con_fac,2);
			//--
			$Tt = 0;
			$Ti = 0;
			if(is_array($result)){
				$sale =  0;
				$CheqCircula =  0;
				foreach($result as $row){
					//Venta
					$vent = $row["ven_codigo"];
					$vent = Agrega_Ceros($vent);
					//Factura
					$fac = $row["ven_ser_numero"]." ".Agrega_Ceros($row["ven_fac_numero"]);
					//Cliente
					$cli = utf8_decode($row["cli_nombre"]);
					//empresa
					$sucnom = utf8_decode($row["suc_nombre"]);
					//Punto de Venta
					$pv = utf8_decode($row["pv_nombre"]);
					//Fecha / Venta
					$fec = $row["ven_fecha"];
					$fec = cambia_fecha($fec);
					//Lote
					$lote = Agrega_Ceros($row["lot_codigo"])."-".Agrega_Ceros($row["lot_articulo"])."-".Agrega_Ceros($row["lot_grupo"]);
					//Descripcion o Articulo
					$desc = utf8_decode($row["dven_detalle"]);
					//Cantidad
					$cant = $row["dven_cantidad"];
					//Precio Venta.
					$pre = number_format($row["dven_precio"], 2, '.', '');
					//Descuento
					//Descuento
					$dsc = $row["dven_descuento"];
					//sub Total
					$monc = $row["dven_tcambio"];
					$Vmonc = $row["ven_tcambio"];
					$rtot = $row["dven_total"];
					$stot = $stot = $row["dven_subtotal"];
					$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
					$DcambiarT = Cambio_Moneda($monc,$MonCambio,$stot);
					$Total+= $DcambiarT;
					$Rcambiar = Cambio_Moneda($monc,$MonCambio,$rtot);
					$Rtotal+= $Rcambiar;
					//Iva
					$faciva = $row["ven_factura"];
					if($faciva == 1){
					$iva = ($stot * $iva_procent)/100;
					$iva = number_format($iva, 2, '.', '');
					$TIVA+=$iva;
					$IVARtotal += ($DcambiarT);
					}else{
					$iva = 0;
					}
					//--
					$stot = number_format($stot, 2, '.', '');
					$Dcambiar = number_format($Dcambiar,2, '.', '');
					$iva = number_format($iva,2, '.', '');
					//--
					$Tt+= $DcambiarT;
					$Ti+=$iva;
					$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,$vent,$fac,$cli,$sucnom,$pv,$fec,$lote,$desc,$cant,"$mons $pre","$mons $dsc","$mons $stot","$monc X 1","$MonSimbol $Dcambiar","$MonSimbol $iva")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;
				}
					$i--;
					//$pdf->Ln(5);
					$pdf->SetFont('Arial','B',6);  
					$pdf->SetFillColor(216,216,216);
					/// Total Ingresos
					$pdf->SetWidths(array(305, 20, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$pdf->SetAligns(array('R', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$Tt = number_format($Tt,2,'.','');
					$Ti = number_format($Ti,2,'.','');
					for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
						$pdf->Row(array("", "$MonSimbol $Tt", "$MonSimbol $Ti"));
					}
			}else{
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				$pdf->Cell(345,5,"NO HAY OTROS PRODUCTOS O SERVICIOS VENDIDOS",1,'','C',true);
				$pdf->Ln(5);
			}
			
			
			/////////////////////////////////////// VENTA POR PAGOS COMPLEMENTARIOS ////////////////////////////////////
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,5,"  VENTAS (FACTURAS) POR CONCEPTO DE PAGOS COMPLEMENTARIOS",1,'','L',true);
			$pdf->Ln(5);
			
			$pdf->SetWidths(array(10, 15, 20, 30, 30, 30, 20, 20, 30, 20, 20, 20, 20, 20, 20, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'L', 'L', 'L', 'C', 'C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			////////////----------------------------- PAGOS COMPLEMENTARIOS (FACTURAS) ---------------------------------------/////////////
			$ClsBol = new ClsBoletaCobro();
			$result = $ClsBol->get_factura('','','','','','',$suc,'',1,$desde,$hasta);
			//--
			$Tt = 0;
			$Ti = 0;
			if(is_array($result)){
				$sale =  0;
				$CheqCircula =  0;
				foreach($result as $row){
					//Venta
					$referencia = $row["fac_referencia"];
					$referencia = Agrega_Ceros($referencia);
					//recibo
					$recibo = $row["ser_numero"]." ".Agrega_Ceros($row["fac_numero"]);
					//Cliente
					$cli = utf8_decode($row["cli_nombre"]);
					//empresa
					$sucnom = utf8_decode($row["suc_nombre"]);
					//Punto de Venta
					$pv = "CONTABILIDAD";
					//Fecha / Venta
					$fec = $row["fac_fecha"];
					$fec = cambia_fecha($fec);
					//Lote
					$lote = "";
					//Descripcion o Articulo
					$desc = utf8_decode($row["fac_descripcion"]);
					//Cantidad
					$cant = 1;
					//Precio Venta.
					$pre = number_format($row["fac_monto"], 2, '.', '');
					//Descuento
					//Descuento
					$dsc = 0;
					//sub Total
					$monc = $row["fac_tcambio"];
					$Vmonc = 1; // tipo de cambio local
					$rtot = $row["fac_monto"];
					$stot = $stot = $row["fac_monto"];
					$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
					$DcambiarT = Cambio_Moneda($monc,$MonCambio,$stot);
					$Total+= $DcambiarT;
					$Rcambiar = Cambio_Moneda($monc,$MonCambio,$rtot);
					$Rtotal+= $Rcambiar;
					//Iva
					$faciva = 0; /// recibo
					if($faciva == 1){
					$iva = ($stot * $iva_procent)/100;
					$iva = number_format($iva, 2, '.', '');
					$TIVA+=$iva;
					$IVARtotal += ($DcambiarT);
					}else{
					$iva = 0;
					}
					//--
					$stot = number_format($stot, 2, '.', '');
					$Dcambiar = number_format($Dcambiar,2, '.', '');
					$iva = number_format($iva,2, '.', '');
					//--
					$Tt+= $DcambiarT;
					$Ti+=$iva;
					$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,$referencia,$recibo,$cli,$sucnom,$pv,$fec,$lote,$desc,$cant,"$mons $pre","$mons $dsc","$mons $stot","$monc X 1","$MonSimbol $Dcambiar","$MonSimbol $iva")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;
				}
					$i--;
					//$pdf->Ln(5);
					$pdf->SetFont('Arial','B',6);  
					$pdf->SetFillColor(216,216,216);
					/// Total Ingresos
					$pdf->SetWidths(array(305, 20, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$pdf->SetAligns(array('R', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$Tt = number_format($Tt,2,'.','');
					$Ti = number_format($Ti,2,'.','');
					for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
						$pdf->Row(array("", "$MonSimbol $Tt", "$MonSimbol $Ti"));
					}
			}else{
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				$pdf->Cell(345,5,"NO HAY FACTURAS GENERADAS POR PAGOS COMPLEMENTARIOS",1,'','C',true);
				$pdf->Ln(5);
			}
			
			
			/////////////////////////////////////// VENTA POR COLEGIATURAS (RECIBOS) ////////////////////////////////////
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$pdf->Cell(345,5,"  RECIBOS POR CONCEPTO DE COLEGIATURAS",1,'','L',true);
			$pdf->Ln(5);
			
			$pdf->SetWidths(array(10, 15, 20, 30, 30, 30, 20, 20, 30, 20, 20, 20, 20, 20, 20, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'L', 'L', 'L', 'C', 'C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			////////////----------------------------- COLEGIATURAS (RECIBOS) ---------------------------------------/////////////
			$ClsBol = new ClsBoletaCobro();
			$result = $ClsBol->get_recibo('','','','','','',$suc,'',1,$desde,$hasta);
			//--
			$Tt = 0;
			$Ti = 0;
			if(is_array($result)){
				$sale =  0;
				$CheqCircula =  0;
				foreach($result as $row){
					//Venta
					$referencia = $row["rec_referencia"];
					$referencia = Agrega_Ceros($referencia);
					//recibo
					$recibo = $row["ser_numero"]." ".Agrega_Ceros($row["rec_numero"]);
					//Cliente
					$cli = utf8_decode($row["cli_nombre"]);
					//empresa
					$sucnom = utf8_decode($row["suc_nombre"]);
					//Punto de Venta
					$pv = "CONTABILIDAD";
					//Fecha / Venta
					$fec = $row["rec_fecha"];
					$fec = cambia_fecha($fec);
					//Lote
					$lote = "";
					//Descripcion o Articulo
					$desc = utf8_decode($row["rec_descripcion"]);
					//Cantidad
					$cant = 1;
					//Precio Venta.
					$pre = number_format($row["rec_monto"], 2, '.', '');
					//Descuento
					//Descuento
					$dsc = 0;
					//sub Total
					$monc = $row["rec_tcambio"];
					$Vmonc = 1; // tipo de cambio local
					$rtot = $row["rec_monto"];
					$stot = $stot = $row["rec_monto"];
					$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
					$DcambiarT = Cambio_Moneda($monc,$MonCambio,$stot);
					$Total+= $DcambiarT;
					$Rcambiar = Cambio_Moneda($monc,$MonCambio,$rtot);
					$Rtotal+= $Rcambiar;
					//Iva
					$faciva = 0; /// recibo
					if($faciva == 1){
					$iva = ($stot * $iva_procent)/100;
					$iva = number_format($iva, 2, '.', '');
					$TIVA+=$iva;
					$IVARtotal += ($DcambiarT);
					}else{
					$iva = 0;
					}
					//--
					$stot = number_format($stot, 2, '.', '');
					$Dcambiar = number_format($Dcambiar,2, '.', '');
					$iva = number_format($iva,2, '.', '');
					//--
					$Tt+= $DcambiarT;
					$Ti+=$iva;
					$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array($no,$referencia,$recibo,$cli,$sucnom,$pv,$fec,$lote,$desc,$cant,"$mons $pre","$mons $dsc","$mons $stot","$monc X 1","$MonSimbol $Dcambiar","$MonSimbol $iva")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					$i++;
				}
					$i--;
					//$pdf->Ln(5);
					$pdf->SetFont('Arial','B',6);  
					$pdf->SetFillColor(216,216,216);
					/// Total Ingresos
					$pdf->SetWidths(array(305, 20, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$pdf->SetAligns(array('R', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
					$Tt = number_format($Tt,2,'.','');
					$Ti = number_format($Ti,2,'.','');
					for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
						$pdf->Row(array("", "$MonSimbol $Tt", "$MonSimbol $Ti"));
					}
			}else{
				$pdf->SetFont('Arial','B',6);  
				$pdf->SetFillColor(216,216,216);
				$pdf->Cell(345,5,"NO HAY RECIBOS GENERADOS POR COLEGIATURAS",1,'','C',true);
				$pdf->Ln(5);
			}
			
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(216,216,216);
				
				/// Total descuentos
				$pdf->SetWidths(array(305, 40));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$Tsedc = $Rtotal - $Total;//saca la diferencia entre los descuentos y el precio real
				$Tsedc = number_format($Tsedc, 2, '.', '');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('TOTAL DE DESCUENTOS  ', $MonSimbol.'. '.$Tsedc));
				}
				
				/// Total de ingresos SIN factura
				$pdf->SetWidths(array(305, 40));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$SinFactura = number_format(($Total - $IVARtotal), 2, '.', '');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('TOTAL DE VENTAS SF (PENDIENTES DE FACTURAR) ', $MonSimbol.'. '.$SinFactura));
				}
				
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(244,244,244);
				
				/// Total de ingresos con factura
				$pdf->SetWidths(array(305, 40));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$IVARtotal = number_format($IVARtotal, 2, '.', '');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('TOTAL DE VENTAS CON FACTURA SIN DEDUCCIONES  ', $MonSimbol.'. '.$IVARtotal));
				}
				
				/// Total de iva
				$pdf->SetWidths(array(305, 40));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$TIVA = number_format($TIVA,2,'.','');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('TOTAL DE IVA  ', $MonSimbol.'. '.$TIVA));
				}
				
				/// Total isr
				$pdf->SetWidths(array(305, 40));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				if($regimen == 1){
					$TISR = ($IVARtotal * 5)/100; //paga 5% sobre ventas
					$isr = $TISR;    
					$TISR = $MonSimbol.'. '.number_format($TISR,2,'.','');					
				}else if($regimen == 2){
					$IVARtotal_menos_iva = $IVARtotal - $TIVA; // resta el IVA
					if($IVARtotal_menos_iva <= 30000){ // si es menor a 30,000
						$TISR = ($IVARtotal_menos_iva * 5)/100; //paga 5% sobre ventas sin iva
					}else{ // si es mayor a 30,000
						$RtotalDepurado = ($IVARtotal_menos_iva)-1500; // 1.500 sobre los primeros 30,000 sin iva
						$TISR = (($RtotalDepurado * 7)/100)+1500; // //paga 7% sobre el resto + los primeros 1,500
					}
					$isr = $TISR;    
					$TISR = $MonSimbol.'. '.number_format($TISR,2,'.','');
				}else if($regimen == 3){
					$TISR = "N/A (calcule utilidades)";
					$isr = 0;
				}else{
					$TISR = "SELECCIONE REGIMEN";
					$isr = 0;
				}
				
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('TOTAL DE ISR  ', $TISR));
				}
				
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(216,216,216);
				
				/// Total todo iva y ISR incluido
				$pdf->SetWidths(array(305, 40));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$Total = number_format($Total, 2, '.', '');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('TOTAL VENTAS SIN DEDUCCIONES  ', $MonSimbol.'. '.$Total));
				}
				
				/// Total todo (con factura y sin factura)
				$pdf->SetWidths(array(305, 40));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				$TotalConIVA = $Total - ($TIVA + $isr);
				$TotalConIVA = number_format($TotalConIVA,2, '.', '');
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('TOTAL GENRAL DE VENTAS CON DEDUCCIONES  ', $MonSimbol.'. '.$TotalConIVA));
				}
				
				$pdf->SetFont('Arial','B',8);  
				$pdf->SetFillColor(255,255,255);
				
				/// MONEDA BASE DE CUALCULOS
				$pdf->SetWidths(array(305, 40));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('MONEDA DE CALCULO  ', $MonDesc.'('.$MonSimbol.')'));
				}
			
			$pdf->Ln(5);
			
			
	
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output("Movimiento de Punto de Venta $desc.pdf","I");

?>