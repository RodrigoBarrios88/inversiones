<?php
  //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
  require_once("../../Clases/ClsNumLetras.php");
	
//llena valores
$ClsVent = new ClsVenta();
$ClsBol = new ClsBoletaCobro();
$ClsAcadem = new ClsAcademico();
$ClsAlu = new ClsAlumno();
$ClsPer = new ClsPeriodoFiscal();
$NumToWords = new NumberToLetterConverter();
$usuario = $_SESSION["codigo"];
$hashkey1 = $_REQUEST["hashkey1"];
$hashkey2 = $_REQUEST["hashkey2"];
$numero = $ClsBol->decrypt($hashkey1, $usuario); //numero de factura
$serie = $ClsBol->decrypt($hashkey2, $usuario);// numero de serie   

////-- trae datos de la boleta 
    
    $result = $ClsBol->get_factura($numero, $serie);
    if(is_array($result)){
        foreach($result as $row){
            $serie = trim($row["ser_numero"]);
            $numero = trim($row["fac_numero"]); 
            $numero_codigo = trim($row["ser_codigo"]);
            $cui = trim($row["fac_alumno"]);
            $fac_descripcion = trim($row["fac_descripcion"]);
            $situacion = trim($row["fac_situacion"]); 
            //--
            $pensum = $ClsPer->get_periodo_activo();  
            $pensum = ($pensum_post != "")?$pensum_post:$pensum; // Si se envia un pensum especifico lo setea, si no agarra el del a�0�9o del periodo fiscal de la boleta
            //alumno
            $result_alumno = $ClsAlu->get_alumno($cui,'','',1);
            if(is_array($result_alumno)){
                foreach($result_alumno as $row_alumno){
                    $alumno = utf8_decode($row_alumno["alu_nombre"])." ".utf8_decode($row_alumno["alu_apellido"]);
                    $nit = trim($row_alumno["alu_nit"]);
                    $nombre = utf8_decode($row_alumno["alu_cliente_nombre"]);
                    $direccion = utf8_decode($row_alumno["alu_cliente_direccion"]);
                }
            }
           /* $result_grado = $ClsAcadem->get_grado_alumno($pensum,'','',$cui,'',1);
            if(is_array($result_grado)){
                foreach($result_grado as $row_grado){
                    $nivel = utf8_decode($row_grado["niv_descripcion"]);
                    $grado = utf8_decode($row_grado["gra_descripcion"]);
                }
            }*/
            
           /* $result_seccion = $ClsAcadem->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);
            if(is_array($result_seccion)){
                foreach($result_seccion as $row_seccion){
                    $seccion = utf8_decode($row_seccion["sec_descripcion"]);
                }
            }*/

            
            //Documento
            $boleta = $row["fac_numero"];
            $boleta = Agrega_Ceros($boleta);
            //fehca
            /* $fec = $row["fac_fecha"];
            $fec = $ClsBol->cambia_fechaHora($fec);
            $mes = substr($fec,3,2);
            //motivo
            $motivo = utf8_decode($row["bol_motivo"]);
            $mes = substr($fec,3,2);
            $mes = Meses_Letra($mes);
            $motivo = $motivo." ($mes)"; */
            //Monto
            $simbolo = "Q";
            $fac_referencia = $row ["fac_referencia"];
            $fac_monto = $row ["fac_monto"];
            $fecha =date ("d/m/Y");
            $i++;
        }
        $i--; //resta 1 vuelta porq inicia con 1
    }

      
      $pdf=new PDF('P','mm','Letter');  // si quieren el reporte horizontal
      
      
      $pdf->AddPage();
      $pdf->SetMargins(5,5,5);
      $pdf->Ln(2);
   
      $pdf->Image('../../../CONFIG/images/logo.png' , 17 ,5, 25 , 25,'PNG', '');//logo
      $pdf->SetFont('Arial','B',8);
      $pdf->setXY(8,30);
      $pdf->MultiCell(44, 3, utf8_decode('Colegio Demo ASMS'), 0 , 'C' , 0);
      $pdf->SetFont('Arial','B',6);
      $pdf->setXY(10,33);
      $pdf->MultiCell(40, 3, utf8_decode('ORGANIZACIÓN S.A.'), 0 , 'C' , 0);
      $pdf->setXY(10,36);
      $pdf->MultiCell(40, 3, utf8_decode('NIT: 1234566789'), 0 , 'C' , 0);
      
      
      $pdf->SetFont('Arial','',10);
      $pdf->setXY(53,15);
      $pdf->MultiCell(60, 4, '24 Avenida 30-24,', 0 , 'L' , 0);
      $pdf->setXY(53,19);
      $pdf->MultiCell(60, 4, utf8_decode('Dirección de la organización'), 0 , 'L' , 0);
      $pdf->setXY(53,23);
      $pdf->MultiCell(60, 4, 'TEL. (502) 2342-5418', 0 , 'L' , 0);
      $pdf->setXY(53,27);
      $pdf->MultiCell(60, 4, utf8_decode('www.asms.gt'), 0 , 'L' , 0);
      $pdf->setXY(53,31);
      $pdf->MultiCell(60, 4, utf8_decode('contabilidad@asms.gt'), 0 , 'L' , 0);
      
      
      
      $pdf->SetFont('Arial','B',10);
      $pdf->setXY(110,10);
      $pdf->MultiCell(100, 5, utf8_decode($tipo_documento_descripcion), 0, 'R' , 0);
      $pdf->SetFont('Arial','B',8);
      $pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
      $pdf->setXY(110,15);
      $pdf->MultiCell(100, 5, utf8_decode('DOCUMENTO TRIBUTARIO ELECTRONICO'), 1 , 'C' , 1);
      $pdf->SetFont('Arial','',8);
      $pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
      $pdf->setXY(110,20);
      $pdf->MultiCell(20, 5, 'UUID:', 1 , 'R' , 0);
      $pdf->setXY(110,25);
      $pdf->MultiCell(20, 5, 'SERIE:', 1 , 'R' , 0);
      $pdf->setXY(110,30);
      $pdf->MultiCell(20, 5, 'FECHA:', 1 , 'R' , 0);
      $pdf->setXY(130,20);
      $pdf->MultiCell(80, 5, $numero, 1 , 'L' , 0);
      $pdf->setXY(130,25);
      $pdf->MultiCell(30, 5, $serie, 1 , 'L' , 0);
      $pdf->setXY(130,30);
      $pdf->MultiCell(30, 5, $fecha, 1 , 'L' , 0);
      $pdf->setXY(160,25);
      $pdf->MultiCell(20, 5, utf8_decode('NUMERO'), 1 , 'R' , 0);
      $pdf->setXY(160,30);
      $pdf->MultiCell(20, 5, 'MONEDA:', 1 , 'R' , 0);
      $pdf->setXY(180,25);
      $pdf->MultiCell(30, 5, $numero_codigo, 1 , 'L' , 0);
      $pdf->setXY(180,30);
      $pdf->MultiCell(30, 5, $simbolo, 1 , 'L' , 0);
      
      if($situacion == 0){ 
			$pdf->Image("../../../CONFIG/images/anulada.jpg",90,150,40,40,"JPG");
		}
      
      ////--- Cliente ----////
      $pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
      $pdf->SetFont('Arial','',8);
      $pdf->setXY(5,50);
      $pdf->MultiCell(35, 5, 'NIT:', 1 , 'L' , 1);
      $pdf->setXY(5,55);
      $pdf->MultiCell(35, 5, 'NOMBRE DEL CLIENTE:', 1 , 'L' , 1);
      $pdf->setXY(5,60);
      $pdf->MultiCell(35, 5, utf8_decode('DIRECCIÓN:'), 1 , 'L' , 1);
      $pdf->SetFont('Arial','',7);
      $pdf->setXY(40,50);
      $pdf->MultiCell(170, 5, $nit, 1 , 'L' , 0);
      $pdf->setXY(40,55);
      $pdf->MultiCell(170, 5, $nombre, 1 , 'L' , 0);
      $pdf->setXY(40,60);
      $pdf->MultiCell(170, 5, $direccion, 1 , 'L' , 0);
      
      $pdf->Ln(10);
      
      
     
      $codventa = trim($row["fac_pago"]);
      $getboleta = $ClsBol->get_boleta_cobro('','','','',$fac_referencia);
      if(is_array($getboleta)){
          foreach($getboleta as $rowboleta){
            $tipo_venta = trim($rowboleta["bol_tipo"]);
            $subtotal = number_format($rowboleta["bol_monto"],2,'.','');
            //descuento
            $descuento = number_format($rowboleta["bol_descuento"],2,'.','');
            //descuento
            $motdesc = utf8_decode($rowboleta["bol_motivo_descuento"]);
            $monto = number_format($subtotal + $descuento,2,'.','');
          }
          if ($tipo_venta == 'V'){
              ////////////////////////////////////// ENCABEZADOS ///////////////////////////////////////////
                $pdf->SetWidths(array(20, 110, 25, 25, 25));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                $pdf->SetAligns(array('C', 'L', 'C', 'C',));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
               // EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
                $pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�0�5O
                $pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
                $pdf->SetTextColor(0);  // AQUI LE DOY COLOR AL TEXTO
                $pdf->Row(array('Cantidad', utf8_decode('Descripcion'), 'Precio Unitario', 'Descuento','Total'));
                
                $pdf->SetWidths(array(20, 110, 25, 25, 25));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                $pdf->SetAligns(array('C', 'L', 'R', 'R', 'R'));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
            $result_detalle = $ClsVent->get_det_venta('',$CodVentas);
            $i=1;
              $monto_total = 0;
              if(is_array($result_detalle)){
                  foreach($result_detalle as $row_detalle){ 
                      //codigo
                      $cantidad = utf8_decode($row_detalle["dven_cantidad"]);
                      //matricula
                      $descripcion = utf8_decode($row_detalle["dven_detalle"]);
                      //moneda
                      $moneda_simbolo = trim($row_detalle["mon_simbolo"]);
                      //precio unitario
                      $precio = trim($row_detalle["dven_precio"]);
                      $precio = number_format($precio,2,'.',',');
                      //DESCUENTOS
                      $descuento = "% ".$row_detalle["dven_descuento"];
                      $tcambio = $row["dven_tcambio"]."X".$row["ven_tcambio"];
                      //subtota
                      $subtotal = trim($row_detalle["dven_total"]);
                      $Vmons = $row["mon_simbolo_venta"];
                      $monc = $row["dven_tcambio"];
                      $Dcambiar = Cambio_Moneda($monc,$MonCambio,$stot);
                      $Total+= $Dcambiar;
                      $Rcambiar = Cambio_Moneda($monc,$MonCambio,$rtot);
                      $Rtotal+= $Rcambiar;
                      $monto_total+= $subtotal;
                      $subtotal = number_format($subtotal,2,'.',',');
                      //---
                      $pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�0�5O DE LA LETRA
                      $pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
                      $pdf->SetTextColor(0);  // LE ASIGNO EL COLOR AL TEXTO
                      $pdf->Row(array($cantidad,"$descripcion","$moneda_simbolo $precio","$descuento","$moneda_simbolo $subtotal"),'',1,4); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
                      $i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
                  }
                  $i--;
                  ////////////////////////////////////// PIE DE REPORTE ///////////////////////////////////////////
                  //Total en letras
                  if($monto_total > 0){
                      $NumToWords = new NumberToLetterConverter();
                      $monto_total = number_format($monto_total,2,'.','');
                      $trozos = explode(".", $monto_total);
                      $enteros = trim($trozos[0]);
                      $decimales = floatval($trozos[1]);
                      $decimales = (strlen($decimales) < 2)?"0$decimales":$decimales; //valida que sea 00, 01, 02, 10, 11, etc
                      $valor_letras = trim($NumToWords->to_word($enteros))." ".$decimales."/100";   
                  }
                  $monto_total = number_format($monto_total,2,'.',',');
                  $pdf->SetAligns(array('C', 'L', 'R', 'R', 'R'));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetFont('Arial','B',6);  	// ASIGNO EL TIPO Y TAMA�0�5O DE LA LETRA
                  $pdf->SetFillColor(216,216,216);
                  $pdf->Row(array('',"Valor en Letras: $valor_letras $moneda_en_letras","Tasa Referencia: $tasa_cambio","% $Tdescuento","$MonSimbol $Ttotal")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY
                  
                  $pdf->Ln(2);
                  $pdf->SetWidths(array(102,103));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetAligns(array('L', 'L'));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetFont('Arial','B',8);  	// ASIGNO EL TIPO Y TAMA�0�5O DE LA LETRA
                  $pdf->SetFillColor(255,255,255);
                  $pdf->Row(array("Venta(s) de referencia:","Numero Interno de la Factura:"),'',0,4); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY
                  
                  $pdf->SetWidths(array(102,103));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetAligns(array('L', 'L'));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetFont('Arial','',6);  	// ASIGNO EL TIPO Y TAMA�0�5O DE LA LETRA
                  $pdf->SetFillColor(255,255,255);
                  $pdf->Row(array("$CodVentas","$serie_interna $numero_interno"),'','B',4);
                  
                  $pdf->Ln(10);
                  $pdf->SetWidths(array(205));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetAligns(array('L'));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetFont('Arial','B',8);  	// ASIGNO EL TIPO Y TAMA�0�5O DE LA LETRA
                  $pdf->SetFillColor(255,255,255);
                  $pdf->Row(array("Observaciones:",""),'',0,4); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY
                  
                  $pdf->SetWidths(array(205));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetAligns(array('J'));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetFont('Arial','',6);  	// ASIGNO EL TIPO Y TAMA�0�5O DE LA LETRA
                  $pdf->SetFillColor(255,255,255);
                  $pdf->Row(array("$observaciones",""),'','',4);
              }else{
                  
                  
                  $pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�0�5O DE LA LETRA
                  $pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
                  $pdf->SetTextColor(0);  // LE ASIGNO EL COLOR AL TEXTO
                  $pdf->Row(array($cantidad,"$descripcion","$moneda_simbolo $precio","$descuento","$moneda_simbolo $subtotal"),'',1,4); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
                  
                  ///////---
                  
                  $monto_total = number_format($monto_total,2,'.',',');
                  $pdf->SetAligns(array('C', 'L', 'R', 'R', 'R'));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetFont('Arial','B',6);  	// ASIGNO EL TIPO Y TAMA�0�5O DE LA LETRA
                  $pdf->SetFillColor(216,216,216);
                  $pdf->Row(array('',"Valor en Letras: $valor_letras $moneda_en_letras","Tasa Referencia: $tasa_cambio","% $Tdescuento","$MonSimbol $Ttotal")); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY
                  
                  $pdf->Ln(2);
                  $pdf->SetWidths(array(102,103));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetAligns(array('L', 'L'));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetFont('Arial','B',8);  	// ASIGNO EL TIPO Y TAMA�0�5O DE LA LETRA
                  $pdf->SetFillColor(255,255,255);
                  $pdf->Row(array("Venta(s) de referencia:","Numero Interno de la Factura:"),'',0,4); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY
                  
                  $pdf->SetWidths(array(102,103));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetAligns(array('L', 'L'));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetFont('Arial','',6);  	// ASIGNO EL TIPO Y TAMA�0�5O DE LA LETRA
                  $pdf->SetFillColor(255,255,255);
                  $pdf->Row(array("$CodVentas","$serie_interna $numero_interno"),'','B',4);
                  
                  $pdf->Ln(10);
                  $pdf->SetWidths(array(205));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetAligns(array('L'));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetFont('Arial','B',8);  	// ASIGNO EL TIPO Y TAMA�0�5O DE LA LETRA
                  $pdf->SetFillColor(255,255,255);
                  $pdf->Row(array("Observaciones:",""),'',0,4); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY
                  
                  $pdf->SetWidths(array(205));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetAligns(array('J'));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                  $pdf->SetFont('Arial','',6);  	// ASIGNO EL TIPO Y TAMA�0�5O DE LA LETRA
                  $pdf->SetFillColor(255,255,255);
                  $pdf->Row(array("$observaciones",""),'','',4);
              }
          }else{
              ////////////////////////////////////// ENCABEZADOS ///////////////////////////////////////////
            $pdf->SetWidths(array( 130, 25, 25, 25));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
            $pdf->SetAligns(array('C', 'L', 'C', 'C',));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
                    // EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
            $pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�0�5O
            $pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
            $pdf->SetTextColor(0);  // AQUI LE DOY COLOR AL TEXTO
            $pdf->Row(array( utf8_decode('Descripcion'), 'Monto', 'Descuento','Total'));
            
            $pdf->SetWidths(array( 130, 25, 25, 25));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
            $pdf->SetAligns(array('C', 'L', 'R', 'R' ));  // AQU�0�1 LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
            $pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�0�5O DE LA LETRA
            $pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
            $pdf->SetTextColor(0);  // LE ASIGNO EL COLOR AL TEXTO
            $pdf->Row(array("$fac_descripcion","$simbolo $monto","$descuento","$simbolo $subtotal"),'',1,4); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
            $i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
          }
      }
     ////--- PIE DE FACTURA ----////
      $pdf->SetFont('Arial','B',8);
      $pdf->setXY(10,235);
      $pdf->MultiCell(50, 5, utf8_decode('SUJETO A PAGOS TRIMESTRALES ISR'), 0, 'C' , 0);
      $pdf->SetFont('Arial','',6);
      $pdf->setXY(10,245);
      $pdf->MultiCell(50, 5, utf8_decode('página 1/1'), 0, 'C' , 0);
      
      $pdf->SetFont('Arial','',6);
      $texto_emisor1 = utf8_decode('El presente documento tributario electrónico fue certificado por '.$certificador.' (NIT '.$certificador_nit.') en fecha '.$fecha_certificacion.'. Para consultar el documento en línea lea el código QR o vaya al sitio: ');
      $texto_emisor2 = utf8_decode('Su documento electrónico también está disponible en el portal de la Superintendencia de Administración Tributaria (SAT) en el portal de la agencia virtual:');
      $pdf->SetXY(65,230);
      $pdf->Cell(107,25,'','L','','C');//recuadro
      $pdf->setXY(67,231);
      $pdf->MultiCell(105, 3,$texto_emisor1, 0 , 'J' , 0);
      
      $pdf->SetFont('Arial','B',6);
      $pdf->SetXY(80, 237);
      $pdf->Cell(75,3,$dteuri,0,'','L');
      $pdf->Link(80, 237, 75, 3, $dteuri);
      
      $pdf->SetFont('Arial','',6);
      $pdf->setXY(67,242);
      $pdf->MultiCell(105, 3,$texto_emisor2, 0 , 'J' , 0);
      
      $pdf->SetFont('Arial','B',6);
      $pdf->SetXY(115, 245);
      $pdf->Cell(50,3,'https://portal.sat.gob.gt/portal/',0,'','L');
      $pdf->Link(115, 245, 50, 3, 'https://portal.sat.gob.gt/portal/');
      
      
      
      //QRCode con el URI del documento
      /*$QRcode = crea_QR($numero,$dteuri);
      $pdf->Image($QRcode , 180 ,225, 30 , 30,'JPG', '');
      if(file_exists($QRcode)){
         unlink($QRcode);
      }*/
      $pdf->SetFont('Arial','B',4);
      $pdf->SetXY(180, 255);
      $pdf->Cell(30,1.5,$factura_id,0,'','C');
      $pdf->Link(180, 255, 30, 1.5, $dteuri);
      
      
   
   $factura_nombre = trim($nombre_cliente);
   $factura_nombre = str_replace(" ","_", $factura_nombre);
   
   //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
   $pdf->Output("Factura $factura_nombre.pdf","I");

  
  
?>