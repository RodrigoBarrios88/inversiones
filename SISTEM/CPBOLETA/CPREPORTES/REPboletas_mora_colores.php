<?php
  //Incluir las librerias de FPDF
	require_once("../../Clases/ClsBoletaCobro.php");
	require_once("../../Clases/ClsAcademico.php");
	require_once("../../Clases/ClsAlumno.php");
	require_once("../../recursos/fpdf/rounded_rect2.php");
	require_once("../../Clases/ClsNumLetras.php");
	
  //llena valores
	$ClsBol = new ClsBoletaCobro();
	$ClsAcadem = new ClsAcademico();
	$ClsAlu = new ClsAlumno();
	//$_POST
	$grupo = $_REQUEST["grupo"];
	
	///// SOLO PARA LOS OLIVOS QUE MANEJA MORAS SOLO CON DINAMICA EDUCATIVA
    $cuenta_quemada = 2;
    $banco_quemado = 1;
    //--
	
	// INICIA ESCRITURA DE PDF 
	$pdf = new PDF('L','mm',array(186,216)); 
	$result = $ClsBol->get_mora('','','','','','','','', '', '', '', '', 1, 1,'',$grupo);
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			$pdf->AddPage();
			$pdf->SetAutoPageBreak(false,2);
			
			$mleft = 0;
			$mtop = 0;
			$pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
		  
			/// Imagenes y Logos
			$pdf->Image('../../../CONFIG/images/boleta_logo.jpg' , 0 , 0, 50 , 25,'JPG', '');
			$pdf->Image('../../../CONFIG/images/sello_agua.jpg' , 40 , 15, 125 , 65,'JPG', '');
			$pdf->Image('../../../CONFIG/images/logo_banco.jpg' , 40 , 105, 125 , 65,'JPG', '');
			
			// coordenadas iniciales
			$x = 0;
			$y = 0;
			switch($cuenta_quemada){
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
			
			////////////////////////////// ------- DATOS DE LA BOLETA -------------- ///////////////////////
			$codigo = $row["bol_codigo"];
			//$codigo = '# '.Agrega_Ceros($codigo);
			///--//boleta
			$referencia = $row["bol_referencia"];
			//--
			$num = $row["cueb_ncuenta"];
			//banco
			$bann = utf8_decode($row["ban_desc_ct"]);
			//alumno
			$cui = $row["alu_cui"];
			$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			//nivel
			$nivel = utf8_decode($row["niv_descripcion"]);
			//grado
			$grado = utf8_decode($row["gra_descripcion"]);
			//fehca
			$freg = $row["bol_fecha_registro"];
			$freg = $ClsBol->cambia_fechaHora($freg);
			$mes = substr($freg,3,2);
			$mes = trim(Meses($mes));
			//fehca
			$fec = $row["bol_fecha_pago"];
			$fec = $ClsBol->cambia_fechaHora($fec);
			//Monto
			$simbolo = $row["mon_simbolo"];
			$monto = $row["bol_monto"];
			//descripcion
			$motivo = utf8_decode($row["bol_motivo"]);

			////////////////////////////// ------ PRIMERA BOLETA (ORIGINAL) ------- ////////////////////////
			
			//recuadro de datos para el banco
			$pdf->SetLineWidth(0.5);
			$pdf->SetDrawColor($r,$g,$b);
			$pdf->SetFillColor(255);
			$pdf->RoundedRect(150, 20, 60, 65, 5, '1234', 'D');
			$pdf->RoundedRect(152, 70, 56, 13, 5, '1234', 'D');
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
			$pdf->RoundedRect(150, 113, 60, 65, 5, '1234', 'D');
			$pdf->RoundedRect(152, 163, 56, 13, 5, '1234', 'D');
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
			
	/*	
	if($cue != "" && $ban != ""){
		$ClsBan = new ClsBanco();
		$result = $ClsBan->get_cuenta_banco($cue,$ban);
		if(is_array($result)){
			foreach($result as $row){
				$cuenta_desc = utf8_decode($row["cueb_nombre"]);
				$cuenta_num = utf8_decode($row["cueb_ncuenta"]);
				$banco_desc = utf8_decode($row["ban_desc_ct"]);
			}	
		}
		$cuenta_titulo = "_Cuenta No. $cuenta_num";
	}
	
	if($empresa != ""){
		$ClsEmp = new ClsEmpresa();
		$result = $ClsEmp->get_sucursal($empresa);
		if(is_array($result)){
			foreach($result as $row){
				$empresa_nombre = utf8_decode($row["suc_nombre"]);
			}	
		}
		$empresa_titulo = "_$empresa_nombre";
	}*/
  
	$documento = "Moras del grupo $grupo el ".date("d/m/Y");
  
	//Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
	$pdf->Output($documento,"I");
  
	function Meses($mes){
		switch($mes){
			case 1: $mes = "ENERO"; break;
			case 2: $mes = "FEBRERO"; break;
			case 3: $mes = "MARZO"; break;
			case 4: $mes = "ABRIL"; break;
			case 5: $mes = "MAYO"; break;
			case 6: $mes = "JUNIO"; break;
			case 7: $mes = "JULIO"; break;
			case 8: $mes = "AGOSTO"; break;
			case 9: $mes = "SEPTIEMBRE"; break;
			case 10: $mes = "OCTUBRE"; break;
			case 11: $mes = "NOVIEMBRE"; break;
			case 12: $mes = "DICIEMBRE"; break;
		}   
		return $mes;
	}  
  
?>