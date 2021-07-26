<?php
  //Incluir las librerias de FPDF
  include_once('html_fns_reportes.php');
  
  //llena valores
	$ClsBol = new ClsBoletaCobro();
	$ClsAcadem = new ClsAcademico();
	$ClsAlu = new ClsAlumno();
	//--
	$usuario = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$hashkey1 = $_REQUEST["hashkey1"];
	$hashkey2 = $_REQUEST["hashkey2"];
	$hashkey3 = $_REQUEST["hashkey3"];
   $anio = $_REQUEST["anio"];
	$cui = $ClsBol->decrypt($hashkey1,$usuario);
	$cue = $ClsBol->decrypt($hashkey2, $usuario);
	$ban = $ClsBol->decrypt($hashkey3, $usuario);
   
	
	// INICIA ESCRITURA DE PDF 
	$pdf = new PDF('L','mm',array(186,216)); 
	
	////-- trae datos de la boleta 
	$result = $ClsBol->get_boleta_cobro('',$cue,$ban,$cui,'',$anio);
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//--
			$num = $row["cueb_ncuenta"];
			//banco
			$bann = utf8_decode($row["ban_desc_ct"]);
			//alumno
			$cui = $row["alu_cui"];
			$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
         //grado
         $grado = utf8_decode($row["alu_grado_descripcion"]);
         //seccion
         $seccion = utf8_decode($row["alu_seccion_descripcion"]);
			//cuenta
			$cuenta = $row["bol_cuenta"];
			//Documento
			$referencia = $row["bol_referencia"];
			//fehca
			$freg = $row["bol_fecha_registro"];
			$freg = $ClsBol->cambia_fechaHora($freg);
			//fehca
			$fec = $row["bol_fecha_pago"];
			$fec = $ClsBol->cambia_fechaHora($fec);
			$mes = substr($fec,3,2);
			//motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			$mes = substr($fec,3,2);
			$mes = Meses_Letra($mes);
			$motivo = $motivo." ($mes)";
			//Monto
			$simbolo = $row["mon_simbolo"];
			$monto = number_format($row["bol_monto"],2,'.','');
			//descuento
			$descuento = number_format($row["bol_descuento"],2,'.','');
			//descuento
			$motdesc = utf8_decode($row["bol_motivo_descuento"]);
	
         // coordenadas iniciales
         $x = 0;
         $y = 0;
         switch($cuenta){
            case 1:
               $r = "202";
               $g = "111";
               $b = "30";
               $empresa = "CLUB DEPORTIVO LA CONDESA";
               $transaccion = "8150"; //COMPLEMENTARIOS
               break;
            case 2:
               $r = "28";
               $g = "75";
               $b = "129";
               $empresa = "DINAMICA EDUCATIVA S.A.";
               $transaccion = "8797"; //LIBROS Y OTROS
               break;
            case 3:
               $r = "26";
               $g = "82";
               $b = "18";
               $empresa = "FUNDACIÓN FRANCISCO MONTENEGRO GIRÓN";
               $transaccion = "8796"; //COLEGIATURA
               break;
         }
         
         $pdf->AddPage();
         $pdf->SetAutoPageBreak(false,2);
         $mleft = 0;
         $mtop = 0;
         $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
        
         /// Imagenes y Logos
         $pdf->Image('../images/boleta_logo.jpg' , 0 , 0, 50 , 25,'JPG', '');
         $pdf->Image('../images/sello_agua.jpg' , 40 , 15, 125 , 65,'JPG', '');
         $pdf->Image('../images/logo_banco.jpg' , 40 , 105, 125 , 65,'JPG', '');
               
         ////////////////////////////// ------ PRIMERA BOLETA (ORIGINAL) ------- ////////////////////////
         
         //recuadro de datos para el banco
         $pdf->SetLineWidth(0.5);
         $pdf->SetDrawColor($r,$g,$b);
         $pdf->SetFillColor(255);
         $pdf->Rect(150, 20, 60, 65);
         $pdf->Rect(152, 70, 56, 13);
         // titulo del recuadro
         $pdf->SetTextColor($r,$g,$b); // Letras de color rgb
         $pdf->SetXY(150,25);
         $pdf->SetFont('Arial','',10);
         $pdf->MultiCell(60, 5, utf8_decode("Sección para el Banco") ,0 , "C" , false);
         $pdf->SetLineWidth(0.2);
         $pdf->SetDrawColor($r,$g,$b);
         $pdf->Line(165, 30, 200, 30);
         
         //inicia Escritura del PDF
         //Borde recuadro / division en dos
         $pdf->SetDrawColor(0,0,0);
         $pdf->SetXY($x,$y);
         $pdf->Cell(278, 205, '', 0, 0);
                  
         //----------- # de Boleta ------//
         $pdf->SetFont('Arial','B',8);
         $pdf->SetTextColor($r,$g,$b); // Letras de color rgb
         $pdf->SetXY(155,5);
         $pdf->Cell(30, 5, "PAGO A TERCEROS", 0, 0, 'C');
         //Asignar tamano de fuente
         $pdf->SetTextColor($r,$g,$b); // Letras de color rgb
         $pdf->SetXY(155,10);
         $pdf->Cell(30, 5, utf8_decode("TRANSACIÓN:"), 0, 0, 'C');
         //--
         $pdf->SetFont('Arial','B',20);
         $pdf->SetTextColor($r,$g,$b); // Letras de color rgb
         $pdf->SetXY(185,7);
         $pdf->Cell(23, 5, $transaccion, 0, 0, 'C');
         
         /////////// TITULO ////////
         $pdf->SetTextColor($r,$g,$b); // Letras de color rgb
         $pdf->SetXY(69.5,8);
         $pdf->SetFont('Arial','B',16);
         $pdf->MultiCell(76, 10, utf8_decode("BOLETA DE PAGO") ,0 , "C" , false);
         $pdf->SetXY(69.5,17);
         $pdf->SetFont('Arial','',8);
         $pdf->MultiCell(76, 3, utf8_decode("FAVOR DEPOSITAR A NOMBRE DE:") ,0 , "C" , false);
         $pdf->SetXY(57.5,21);
         $pdf->SetFont('Arial','B',10);
         $pdf->MultiCell(100, 5, utf8_decode($empresa) ,0 , "C" , false);
         $pdf->SetXY(69.5,26);
         $pdf->SetFont('Arial','',8);
         $pdf->MultiCell(76, 3, utf8_decode("BANCO G&T CONTINENTAL") ,0 , "C" , false);
         //--
         $pdf->SetDrawColor($r,$g,$b);
         $pdf->Line(78, 16, 137, 16);
         
         ////////////////////////////// ------------ //////////////////////////
         $pdf->SetTextColor($r,$g,$b); // Letras de color rgb
         $pdf->SetFont('Arial','',10);
            //----------- CUERPO ------//
            //----------- CUI del Alumno ------//
            $pdf->SetXY(5,30);
            $pdf->Cell(35, 3, "CUI:", 0, 0);
            
            //----------- Nombre del Alumno ------//
            $pdf->SetXY(5,40);
            $pdf->Cell(35, 3, "Alumno:", 0, 0);
            
            //----------- Contrato ------//
            $pdf->SetXY(5,50);
            $pdf->Cell(35, 3, "Motivo:", 0, 0);
            
            //----------- Monto ------//
            $pdf->SetXY(5,60);
            $pdf->Cell(35, 3, "Monto:", 0, 0);
            
            //----------- Descuento ------//
            $pdf->SetXY(65,60);
            //$pdf->Cell(35, 3, "Descuento:", 0, 0);
            
            //----------- Nivel y Grado------//
            $pdf->SetXY(5,70);
            $pdf->Cell(35, 3, "Grado:", 0, 0);
            
            //----------- Fecha ------//
            $pdf->SetXY(5,80);
            $pdf->Cell(35, 3, "Fecha:", 0, 0);
                  
            //----------- Codo ------//
            ////--- Boleta No. /////
            $pdf->SetTextColor(255,0,0); // rojo
            $pdf->SetFont('Arial','B',10);
            $pdf->SetXY(176,34.5);
            $pdf->Cell(30, 5, $referencia, 0, 0, 'C');
               
            $pdf->SetTextColor($r,$g,$b); // Letras de color rgb
            $pdf->SetFont('Arial','',8);
            
            //----------- CUI del Alumno ------//
            $pdf->SetXY(154,35);
            $pdf->Cell(35, 3, "Boleta No.:", 0, 0);
         
            //----------- Transaccion ------//
            $pdf->SetXY(154,42);
            $pdf->Cell(35, 3, utf8_decode("Código Alumno:"), 0, 0);
            
            //----------- Cajero ------//
            $pdf->SetXY(154,49);
            $pdf->Cell(35, 3, "Mes:", 0, 0);
            
            //----------- Monto ------//
            $pdf->SetXY(154,56);
            $pdf->Cell(35, 3, "Monto:", 0, 0);
            
            //----------- Fecha y Hora ------//
            $pdf->SetXY(154,63);
            $pdf->Cell(35, 3, "Fecha", 0, 0);
                  
            // Lineas //
               $pdf->SetDrawColor($r,$g,$b);
               $y = 39;
               for($i = 1; $i <= 5; $i++){
                  $pdf->Line(175, $y, 206, $y);
                  $y+= 7;
               }
               
      
                  
         ////////////////////////////// ------------- ////////////////////////
               
         $pdf->SetTextColor($r,$g,$b); //Letras de color negro
         $pdf->SetFont('Courier','B',10);
            //----------- CUERPO ------//
         //----------- CUI del Alumno ------//
            $pdf->SetXY(30,30);
            $pdf->Cell(35, 3, $cui, 0, 0);
            
            //----------- Nombre del Alumno ------//
            $pdf->SetXY(30,40);
            $pdf->Cell(35, 3, $alumno, 0, 0);
            
            //----------- Contrato ------//
            $pdf->SetXY(30,50);
            $pdf->MultiCell(115, 4, $motivo, 0, 'J', 0);
            
            //----------- Monto ------//
            $pdf->SetXY(30,60);
            $pdf->Cell(35, 3, "$simbolo. $monto", 0, 0);
            
            //----------- Descuento ------//
            $pdf->SetXY(95,60);
            //$pdf->Cell(35, 3, "$simbolo. $descuento", 0, 0);
            
            //----------- Grado y Seccion------//
            $pdf->SetXY(30,70);
            $pdf->MultiCell(115, 4, "$grado / $nivel", 0, 'J', 0);
            
            //----------- Fecha ------//
            $pdf->SetXY(30,80);
            $pdf->Cell(35, 3, $fec, 0, 0);
            
            //----------- Motivo de descuento ------//
            $pdf->SetFont('Courier','',8);
            $pdf->SetXY(60,80);
            //$pdf->Cell(35, 3, "($motdesc)", 0, 0);
                  
            //----------- CODO ------//
            $pdf->SetFont('Courier','',10);
            //----------- CUI del Alumno ------//
            $pdf->SetXY(176,42);
            $pdf->Cell(35, 3, $cui, 0, 0);
            //----------- Mes ------//
            $pdf->SetXY(176,49);
            $pdf->Cell(35, 3, $mes, 0, 0);
            //----------- Monto ------//
            $pdf->SetXY(176,56);
            $pdf->Cell(35, 3, "$simbolo. $monto", 0, 0);
            //----------- fecha ------//
            $pdf->SetXY(176,63);
            $pdf->Cell(35, 3, $fec, 0, 0);
            
            //Instruccions
            $pdf->SetFont('Arial','B',6);
            $pdf->SetXY(155,72);
            $pdf->Cell(35, 3, "Instrucciones de la Empresa:", 0, 0);
            //
            $pdf->SetFont('Arial','',6);
            $pdf->SetXY(155,75);
            $pdf->MultiCell(50, 3, utf8_decode("Válida por la certificación de la máquina receptora y firma del receptor.") ,0 , "J" , false);
                  
         ////////////////////////////// ------ FIN DE LA PRIMERA BOLETA (ORIGINAL) ------- ////////////////////////
         
         $pdf->Line(1, 93, 215, 93); ////// LINEA DIVISORIA ENTRE BOLETAS
         
         ////////////////////////////// ------ SEGUNDA BOLETA (COPIA) ------- ////////////////////////////////////
         
         //recuadro de datos para el banco
         $pdf->SetLineWidth(0.5);
         $pdf->SetDrawColor(0, 0, 0);
         $pdf->SetFillColor(255);
         $pdf->Rect(150, 113, 60, 65);
         $pdf->Rect(152, 163, 56, 13);
         // titulo del recuadro
         $pdf->SetTextColor(0, 0, 0); // Letras de color rgb
         $pdf->SetXY(150,118);
         $pdf->SetFont('Arial','',10);
         $pdf->MultiCell(60, 5, utf8_decode("Sección para el Banco") ,0 , "C" , false);
         $pdf->SetLineWidth(0.2);
         $pdf->SetDrawColor(0, 0, 0);
         $pdf->Line(165, 123, 200, 123);
         
         
         //inicia Escritura del PDF
         //Borde recuadro / division en dos
         $pdf->SetDrawColor(0,0,0);
         $pdf->SetXY($x,$y);
         $pdf->Cell(278, 205, '', 0, 0);		
      
         //----------- # de Boleta ------//
         $pdf->SetFont('Arial','B',8);
         $pdf->SetTextColor(0, 0, 0); // Letras de color rgb
         $pdf->SetXY(155,98);
         $pdf->Cell(30, 5, "PAGO A TERCEROS", 0, 0, 'C');
         //Asignar tamano de fuente
         $pdf->SetTextColor(0, 0, 0); // Letras de color rgb
         $pdf->SetXY(155,103);
         $pdf->Cell(30, 5, utf8_decode("TRANSACIÓN:"), 0, 0, 'C');
         //--
         $pdf->SetFont('Arial','B',20);
         $pdf->SetTextColor(0, 0, 0); // Letras de color rgb
         $pdf->SetXY(185,100);
         $pdf->Cell(23, 5, $transaccion, 0, 0, 'C');
         
         /////////// TITULO ////////
         $pdf->SetTextColor(0, 0, 0); // Letras de color rgb
         $pdf->SetXY(69.5,101);
         $pdf->SetFont('Arial','B',16);
         $pdf->MultiCell(76, 10, utf8_decode("BOLETA DE PAGO") ,0 , "C" , false);
         $pdf->SetXY(69.5,110);
         $pdf->SetFont('Arial','',8);
         $pdf->MultiCell(76, 3, utf8_decode("FAVOR DEPOSITAR A NOMBRE DE:") ,0 , "C" , false);
         $pdf->SetXY(57.5,114);
         $pdf->SetFont('Arial','B',10);
         $pdf->MultiCell(100, 5, utf8_decode($empresa) ,0 , "C" , false);
         $pdf->SetXY(69.5,119);
         $pdf->SetFont('Arial','',8);
         $pdf->MultiCell(76, 3, utf8_decode("BANCO G&T CONTINENTAL") ,0 , "C" , false);
         //--
         $pdf->SetDrawColor(0, 0, 0);
         $pdf->Line(78, 109, 137, 109);
         
         ////////////////////////////// --------- ////////////////////////
         $pdf->SetTextColor(0, 0, 0); // Letras de color rgb
         $pdf->SetFont('Arial','',10);
            //----------- CUERPO ------//
            //----------- CUI del Alumno ------//
            $pdf->SetXY(5,123);
            $pdf->Cell(35, 3, "CUI:", 0, 0);
            
            //----------- Nombre del Alumno ------//
            $pdf->SetXY(5,133);
            $pdf->Cell(35, 3, "Alumno:", 0, 0);
            
            //----------- Contrato ------//
            $pdf->SetXY(5,143);
            $pdf->Cell(35, 3, "Motivo:", 0, 0);
            
            //----------- Monto ------//
            $pdf->SetXY(5,153);
            $pdf->Cell(35, 3, "Monto:", 0, 0);
            
            //----------- Descuento ------//
            $pdf->SetXY(65,153);
            //$pdf->Cell(35, 3, "Descuento:", 0, 0);
            
            //----------- Nivel y Grado------//
            $pdf->SetXY(5,163);
            $pdf->Cell(35, 3, "Grado:", 0, 0);
            
            //----------- Fecha ------//
            $pdf->SetXY(5,173);
            $pdf->Cell(35, 3, "Fecha:", 0, 0);
                  
            //----------- Codo ------//
            ////--- Boleta No. /////
            $pdf->SetTextColor(255,0,0); // rojo
            $pdf->SetFont('Arial','B',10);
            $pdf->SetXY(176,127.5);
            $pdf->Cell(30, 5, $referencia, 0, 0, 'C');
               
            $pdf->SetTextColor(0, 0, 0); // Letras de color rgb
            $pdf->SetFont('Arial','',8);
            
            //----------- CUI del Alumno ------//
            $pdf->SetXY(154,128);
            $pdf->Cell(35, 3, "Boleta No.:", 0, 0);
         
            //----------- Transaccion ------//
            $pdf->SetXY(154,135);
            $pdf->Cell(35, 3, utf8_decode("Código Alumno:"), 0, 0);
            
            //----------- Cajero ------//
            $pdf->SetXY(154,142);
            $pdf->Cell(35, 3, "Mes:", 0, 0);
            
            //----------- Monto ------//
            $pdf->SetXY(154,149);
            $pdf->Cell(35, 3, "Monto:", 0, 0);
            
            //----------- Fecha y Hora ------//
            $pdf->SetXY(154,156);
            $pdf->Cell(35, 3, "Fecha", 0, 0);
                  
            // Lineas //
            $pdf->SetDrawColor(0, 0, 0);
            $y = 132;
            for($i = 1; $i <= 5; $i++){
               $pdf->Line(175, $y, 206, $y);
               $y+= 7;
            }
                        
         ////////////////////////////// ------------- ////////////////////////
               
         $pdf->SetTextColor(0, 0, 0); //Letras de color negro
         $pdf->SetFont('Courier','B',10);
            //----------- CUERPO ------//
            //----------- CUI del Alumno ------//
            $pdf->SetXY(30,123);
            $pdf->Cell(35, 3, $cui, 0, 0);
            
            //----------- Nombre del Alumno ------//
            $pdf->SetXY(30,133);
            $pdf->Cell(35, 3, $alumno, 0, 0);
            
            //----------- Contrato ------//
            $pdf->SetXY(30,143);
            $pdf->MultiCell(115, 4, $motivo, 0, 'J', 0);
            
            //----------- Monto ------//
            $pdf->SetXY(30,153);
            $pdf->Cell(35, 3, "$simbolo. $monto", 0, 0);
            
            //----------- Descuento ------//
            $pdf->SetXY(95,153);
            //$pdf->Cell(35, 3, "$simbolo. $descuento", 0, 0);
            
            //----------- Grado y Seccion------//
            $pdf->SetXY(30,163);
            $pdf->MultiCell(115, 4, "$grado / $nivel", 0, 'J', 0);
            
            //----------- Fecha ------//
            $pdf->SetXY(30,173);
            $pdf->Cell(35, 3, $fec, 0, 0);
            
            //----------- Motivo de descuento ------//
            $pdf->SetFont('Courier','',8);
            $pdf->SetXY(60,173);
            //$pdf->Cell(35, 3, "($motdesc)", 0, 0);
                  
            //----------- CODO ------//
            $pdf->SetFont('Courier','',10);
            
            //----------- CUI del Alumno ------//
            $pdf->SetXY(176,135);
            $pdf->Cell(35, 3, $cui, 0, 0);
            //----------- Mes ------//
            $pdf->SetXY(176,142);
            $pdf->Cell(35, 3, $mes, 0, 0);
            //----------- Monto ------//
            $pdf->SetXY(176,149);
            $pdf->Cell(35, 3, "$simbolo. $monto", 0, 0);
            //----------- fecha ------//
            $pdf->SetXY(176,156);
            $pdf->Cell(35, 3, $fec, 0, 0);
            
            //Instruccions
            $pdf->SetFont('Arial','B',6);
            $pdf->SetXY(155,165);
            $pdf->Cell(35, 3, "Instrucciones de la Empresa:", 0, 0);
            //
            $pdf->SetFont('Arial','',6);
            $pdf->SetXY(155,168);
            $pdf->MultiCell(50, 3, utf8_decode("Válida por la certificación de la máquina receptora y firma del receptor.") ,0 , "J" , false);
         
            ////////////////////////////// ------ FIN DE LA SEGUNDA BOLETA (COPIA) ------- ////////////////////////
         $i++;
		}
		$i--; //resta 1 vuelta porq inicia con 1
	}
	
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output("Boletas Alumno $cui.pdf","I");
  
?>