<?php
  //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
  
  $cod = $_REQUEST["vent"];
   
  //llena valores
   $ClsFac = new ClsFactura();
   $ClsVent = new ClsVenta();
  ///--trae datos de la factura, si se facturo.
	    $result = $ClsFac->get_factura('','',$cod);
	    if(is_array($result)){
			foreach ($result as $row) {
				$serie = trim($row["ser_numero"]);
				$factura = trim($row["fac_numero"]);
			}
	    }
  ////-- trae datos de la venta 
	    $result = $ClsVent->get_venta($cod);
	    if(is_array($result)){
			$i = 1;
			foreach($result as $row){
			        //--
				$nit =  trim($row["cli_nit"]);
				$nom =  trim($row["cli_nombre"]);
				$dir =  trim($row["cli_direccion"]);
				//--
				    $fec = $row["ven_fecha"];
				    $fec = cambia_fecha($fec);
				    $desc = $row["ven_descuento"];
				    $tot = $row["ven_total"];
				    $mon = $row["mon_desc"];
				    $tcamb = $row["ven_tcambio"];
				    $situacion = $row["ven_situacion"];
			      $i++;
			}
			$i--; //resta 1 vuelta porq inicia con 1
	    }
			
  

  
  // INICIA ESCRITURA DE PDF 
  $pdf = new PDF('L','mm','Letter'); 
  //$pdf->AddPage();

  $mleft = 2;
  $mtop = 2;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
  
  //Asignar tamano de fuente
  $pdf->SetFont('Arial','B',10);
  
  // coordenadas iniciales
  $x = 2;
  $y = 42;
	
  //inicia Escritura del PDF
	//*******************RECUADRO DEL BOLETA *****************
	//Borde recuadro / division en dos
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->Cell(278, 205, '', 0, 0);
	//$pdf->Image("../../../CONFIG/images/linea_punteada.png",14,0.2,0.1,20.5,"PNG");
	/////////////---------------///////////////-----------------------------//////////////
  /////////////---------------Copia Original-----------------------------//////////////
  /////////////---------------///////////////-----------------------------//////////////
	  //----------- Datos de la Factura ------//
			$pdf->SetFont('Arial','',8);
			$xfac = (140/2) + 30; 
			$pdf->SetXY($xfac,5);
			if($serie != "" && $factura != ""){ 
				$pdf->Cell(35, 5, "Factura Serie $serie No. $factura", 0, 0);
			}else{
				$pdf->Cell(35, 5, "Venta sin Factura", 0, 0); 
			}
			$pdf->SetXY($xfac,2);
			$cod = Agrega_Ceros($cod);
			$pdf->Cell(35, 5, "Transaccion # $cod", 0, 0);
			
				//---------- datos del cliente ---------//
			$x1 = $x + 5;
			$pdf->SetXY($x1,$y);
			$info = array("Nit:","Nombre:","Direccion:","Fecha:");	
			$pos_x = $x1;
			$pos_y = $y;
			$altura = 5;
			$pdf->outValues($info,$pos_x,$pos_y,$altura);
			//Crear lineas
			$lpos_x = $x1+15;
			$lpos_y = $y+12;
			$longitud = 50;
			$altura = 5;
			
			for($i=1;$i<=4;$i++) {
				$pdf->createHorLine($lpos_x,$lpos_y,$longitud);
				$lpos_y += $altura;
			} 
			//
			$info = array($nit,$nom,$dir,$fec);	
			$pos_x = $x1+15;
			$pos_y = $y;
			$altura = 5;
			$pdf->outValues($info,$pos_x,$pos_y,$altura);
	  //--
	  //---------- datos de la venta ---------//
	    $pos_x = $x1;
	    $pos_y+= 35;
			
			$pdf->SetXY($pos_x,$pos_y);
			$pdf->Ln(5);
	    
			$pdf->SetWidths(array(12, 62, 12, 12, 12, 12));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('Cantidad', 'Descripcion', 'Precio', 'Desc.','Tipo/Cam','Subtota'));
			}
		
			$pdf->SetWidths(array(12, 62, 12, 12, 12, 12));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'L', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	    
	    $result = $ClsVent->get_det_venta('',$cod);
	    if(is_array($result)){
				$i = 1;
				$pos_x = $x1;
				$pos_y+= 5;
				$Total = 0;
				$Rtotal = 0;
				foreach($result as $row){
							//--
							$cantidad = $row["dven_cantidad"];
							$detalle = $row["dven_detalle"];
							$precio = $row["mon_simbolo"].". ".$row["dven_precio"];
							$desc = "% ".$row["dven_descuento"];
							$tcambio = $row["dven_tcambio"]."X".$row["ven_tcambio"];
							$rtot = ($row["dven_precio"] * $row["dven_cantidad"]);
							$stot = $rtot - (($rtot * $row["dven_descuento"])/100);
							$subtotal = $row["mon_simbolo"].". ".round($stot,2);
							//--
							$Vmons = $row["mon_simbolo_venta"];
							$monc = $row["dven_tcambio"];
							$Vmonc = $row["ven_tcambio"];
							$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
							$Total+= $Dcambiar;
							$Rcambiar = Cambio_Moneda($monc,$Vmonc,$rtot);
							$Rtotal+= $Rcambiar;
							//--
							$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
							$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
							$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
							$no = $i.".";
							$pdf->Row(array($cantidad,$detalle,$precio,$desc,$tcambio,$subtotal)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
							$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
							$pos_y+=3;
				}
				$i--; //resta 1 vuelta porq inicia con 1
				$label = "TOTAL";
				$total = $Vmons.". ".$Rtotal;
				
				$pdf->SetWidths(array(110, 12));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
				$pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
				$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
				$pdf->Row(array($label,$total));
				    
	    }
	    //-
	    //----------- Situacion de la Factura ------------///
	    if($situacion == 0){ 
			  $pdf->Image("../../../CONFIG/images/anulada.png",25,80,80,80,"PNG");
	    }
	    //-
	    
	/////////////---------------///////////////-----------------------------//////////////
	/////////////---------------Copia local    -----------------------------//////////////
  /////////////---------------///////////////-----------------------------//////////////
	  //----------- Datos de la Factura ------//
		$pdf->SetFont('Arial','',8);
		$xfac = (278-(140/2)) + 30; 
		$pdf->SetXY($xfac,5);
		if($serie != "" && $factura != ""){ 
		$pdf->Cell(35, 5, "Factura Serie $serie No. $factura", 0, 0);
		}else{
	        $pdf->Cell(35, 05, "Venta sin Factura", 0, 0); 
		}
		$pdf->SetXY($xfac,2);
		$cod = Agrega_Ceros($cod);
		$pdf->Cell(35, 05, "Transaccion # $cod", 0, 0);
	
	   //---------- datos del cliente ---------//
			$x2 = 140 + 9;
			$pdf->SetXY($x2,$y);
			$info = array("Nit:","Nombre:","Direccion:","Fecha:");	
			$pos_x = $x2;
			$pos_y = $y;
			$altura = 5;
			$pdf->outValues($info,$pos_x,$pos_y,$altura);
			//Crear lineas
			$lpos_x = $x2 + 15;
			$lpos_y = $y + 12;
			$longitud = 50;
			$altura = 5;
			
			for($i=1;$i<=4;$i++) {
				$pdf->createHorLine($lpos_x,$lpos_y,$longitud);
				$lpos_y += $altura;
			} 
			//
			$info = array($nit,$nom,$dir,$fec);	
			$pos_x = $x2+15;
			$pos_y = $y;
			$altura = 5;
			$pdf->outValues($info,$pos_x,$pos_y,$altura);
		//--
	  //---------- datos de la venta ---------//
	    $pos_x = $x2;
	    $pos_y+= 35;
	    
			$pdf->SetXY($x2,$pos_y);
			$pdf->SetX($x2);
			$pdf->Ln(5);
			
			$pdf->SetWidths(array(12, 62, 12, 12, 12, 12));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('Cantidad', 'Descripcion', 'Precio', 'Desc.','Tipo/Cam','Subtota'));
			}
		
			$pdf->SetWidths(array(12, 62, 12, 12, 12, 12));   // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'L', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	    
	    $result = $ClsVent->get_det_venta('',$cod);
	    if(is_array($result)){
				$i = 1;
				$pos_x = $x1;
				$pos_y+= .5;
				$Total = 0;
				$Rtotal = 0;
				foreach($result as $row){
							//--
							$cantidad = $row["dven_cantidad"];
							$detalle = $row["dven_detalle"];
							$precio = $row["mon_simbolo"].". ".$row["dven_precio"];
							$desc = "% ".$row["dven_descuento"];
							$tcambio = $row["dven_tcambio"]."X".$row["ven_tcambio"];
							$rtot = ($row["dven_precio"] * $row["dven_cantidad"]);
							$stot = $rtot - (($rtot * $row["dven_descuento"])/100);
							$subtotal = $row["mon_simbolo"].". ".round($stot,2);
							//--
							$Vmons = $row["mon_simbolo_venta"];
							$monc = $row["dven_tcambio"];
							$Vmonc = $row["ven_tcambio"];
							$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
							$Total+= $Dcambiar;
							$Rcambiar = Cambio_Moneda($monc,$Vmonc,$rtot);
							$Rtotal+= $Rcambiar;
							//--
							$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
							$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
							$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
							$no = $i.".";
							$pdf->Row(array($cantidad,$detalle,$precio,$desc,$tcambio,$subtotal)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
							$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
							$pos_y+=.3;
				}
				$i--; //resta 1 vuelta porq inicia con 1
				$label = "TOTAL";
				$total = $Vmons.". ".$Rtotal;
				
				$pdf->SetWidths(array(110, 12));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('R', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
				$pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
				$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
				$pdf->Row(array($label,$total));
				    
	    }
	    //--
	    //----------- Situacion de la Factura ------------///
	    if($situacion == 0){ 
				$pdf->Image("../../../CONFIG/images/anulada.png",16.5,8,8,8,"PNG");
	    }
	    //-
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output();
  
  
?>