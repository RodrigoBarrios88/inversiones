<?php
  //Incluir las librerias de FPDF
	include_once('html_fns_reportes.php');
    require_once("../recursos/fpdi/fpdi.php"); /// Clase para Importar PDFs Bases
  
  //llena valores
	$ClsIns = new ClsInscripcion();
	$ClsAcadem = new ClsAcademico();
	$ClsAlu = new ClsAlumno();
	//--
	$usuario = $_SESSION["codigo"];
	//---
	$codigo = $_REQUEST["boleta"];
	//echo $pensum;
	// INICIA ESCRITURA DE PDF 
	$pdf = new FPDI('P','mm','Legal'); 
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	
	$mleft = 0;
	$mtop = 0;
	$pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
	/// Imagenes y Logos
	$pdf->Image('../images/boleta_logo.jpg' , 0 , 0, 50 , 25,'JPG', '');
	$pdf->Image('../images/sello_agua.jpg' , 40 , 15, 125 , 65,'JPG', '');
	$pdf->Image('../images/logo_banco.jpg' , 40 , 105, 125 , 65,'JPG', '');
	
	////-- trae datos de la boleta 
	$result = $ClsIns->get_boleta_cobro($codigo);
	if(is_array($result)){
		foreach($result as $row){
			//alumno
			$cui = $row["bol_alumno"];
			$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			
			$result_grado = $ClsIns->get_grado_alumno('','',$cui,'',1);
			if(is_array($result_grado)){
				foreach($result_grado as $row_grado){
					$nivel = utf8_decode($row_grado["niv_descripcion"]);
					$grado = utf8_decode($row_grado["gra_descripcion"]);
				}
			}
			//cuenta
			$division = $row["bol_division"];
			//Documento
			$boleta = $row["bol_codigo"];
			$boleta = Agrega_Ceros($boleta);
			//fehca
			$freg = $row["bol_fecha_registro"];
			$freg = $ClsIns->cambia_fechaHora($freg);
			//fehca
			$fecha = $row["bol_fecha_registro"];
			$fecha = $ClsIns->cambia_fechaHora($fecha);
            $fecha = substr($fecha,0,10);
			$mes = substr($fecha,3,2);
			//motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			$mes = substr($fecha,3,2);
			$mes = Meses_Letra($mes);
			$motivo = $motivo." ($mes)";
			//Monto
			$simbolo = $row["mon_simbolo"];
			$monto = number_format($row["bol_monto"],2,'.','');
			//descuento
			$descuento = number_format($row["bol_descuento"],2,'.','');
			//descuento
			$motdesc = utf8_decode($row["bol_motivo_descuento"]);
			$i++;
		}
		$i--; //resta 1 vuelta porq inicia con 1
	}
	// coordenadas iniciales
	$x = 0;
	$y = 0;
	switch($division){
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
			$resolucion = "EXENTO DE ISR E IVA SEGUN RESOLUCION No. IRG-455-2000 DE FECHA 24/04/2000";
			break;
	}
	
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
	$pdf->MultiCell(76, 10, utf8_decode("BOLETA DE INSCRIPCIÓN") ,0 , "C" , false);
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
		$pdf->Cell(30, 5, $boleta, 0, 0, 'C');
			
		$pdf->SetTextColor($r,$g,$b); // Letras de color rgb
		$pdf->SetFont('Arial','',8);
		
		//----------- No. ------//
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
		$pdf->Cell(35, 3, $fecha, 0, 0);
		
		//----------- Resolucion ------//
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5,87);
		$pdf->Cell(120, 3, $resolucion, 0, 0);	
		
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
		$pdf->Cell(35, 3, $fecha, 0, 0);
		
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
		$pdf->Cell(30, 5, $boleta, 0, 0, 'C');
			
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
		$pdf->Cell(35, 3, $fecha, 0, 0);
		
		//----------- Resolucion ------//
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5,180);
		$pdf->Cell(120, 3, $resolucion, 0, 0);	
		
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
		$pdf->Cell(35, 3, $fecha, 0, 0);
		
		//Instruccions
		$pdf->SetFont('Arial','B',6);
		$pdf->SetXY(155,165);
		$pdf->Cell(35, 3, "Instrucciones de la Empresa:", 0, 0);
		//
		$pdf->SetFont('Arial','',6);
		$pdf->SetXY(155,168);
		$pdf->MultiCell(50, 3, utf8_decode("Válida por la certificación de la máquina receptora y firma del receptor.") ,0 , "J" , false);
	
	////////////////////////////// ------ FIN DE LA SEGUNDA BOLETA (COPIA) ------- ////////////////////////
	
	////////////////////////////// ------ INICIO DEL FORMULARIO DE VERIFICACION ------- ////////////////////////
	//---//--//--//--
	$anio_escolar = 2021;
	$ClsIns = new ClsInscripcion();
	if($cui != ""){
		////// Inicia hoja de verificacion
		$result = $ClsIns->get_status($cui);
		if(is_array($result)){
			foreach($result as $row){
				$situacion_contrato = $row["stat_situacion"];
				$contrato = $row["stat_contrato"];
				$dpi = utf8_decode($row["stat_dpi_firmante"]);
				$tipodpi = trim($row["stat_tipo_dpi"]);
				$nombre = utf8_decode($row["stat_nombre"]);
				$apellido = utf8_decode($row["stat_apellido"]);
				$fecnac = cambia_fecha($row["stat_fec_nac"]);
				$edad = Calcula_Edad(cambia_fecha($row["stat_fec_nac"]));
				$parentesco = trim($row["stat_parentesco"]);
				$ecivil = trim($row["stat_estado_civil"]);
				$nacionalidad = utf8_decode($row["stat_nacionalidad"]);
				$mail = strtolower($row["stat_mail"]);
				$direccion = utf8_decode($row["stat_direccion"]);
				$dep_desc = utf8_decode($row["contrato_departamento_desc"]);
				$mun = utf8_decode($row["contrato_municipio_desc"]);
				$arrmun = explode(",", $mun);
				$mun_desc = trim($arrmun[0]); /// separa el departamento del municipio en la descripción
				$telcasa = $row["stat_telefono"];
				$celular = $row["stat_celular"];
				$trabajo = utf8_decode($row["stat_lugar_trabajo"]);
				$teltrabajo = $row["stat_telefono_trabajo"];
				$profesion = utf8_decode($row["stat_profesion"]);
			}
		}
		
		$result = $ClsIns->get_alumno($cui);
		if(is_array($result)){
			foreach($result as $row){
				$cui = $row["alu_cui_new"];
				$tipocui = $row["alu_tipo_cui"];
				$codigo = $row["alu_codigo_interno"];
				$alunombre = utf8_decode($row["alu_nombre"]);
				$aluapellido = utf8_decode($row["alu_apellido"]);
				$alufecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
				$aluedad = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
				$genero = trim($row["alu_genero"]);
				$sangre = trim($row["alu_tipo_sangre"]);
				$alergico = utf8_decode($row["alu_alergico_a"]);
				$emergencia = utf8_decode($row["alu_emergencia"]);
				$emertel = utf8_decode($row["alu_emergencia_telefono"]);
				//
				$nit = $row["alu_nit"];
			    $cliente = utf8_decode($row["alu_cliente_nombre"]);
			}
		}
		
		
		$result = $ClsIns->get_grado_alumno('','',$cui);
		if(is_array($result)){
    		foreach($result as $row){
    		    $nivCodigo = $row["niv_codigo"];
    			$graCodigo = $row["gra_codigo"];
    		    $nivel = utf8_decode($row["niv_descripcion"]);
    		    $grado = utf8_decode($row["gra_descripcion"]);
    		}
		}
		
		//////// VALIDACIONES ////////////////
		//colegiaturas
		$arrMontos = Montos_Contratos($nivCodigo);
		//libros
		$arrLibros = Montos_Libros($nivCodigo,$graCodigo);
		
		$genero = ($genero == "M")?"NIÑO":"NIÑA";
		$genero = utf8_decode($genero);
		
		switch($parentesco){
			case "P": $parentesco = "PADRE"; break;
			case "M": $parentesco = "MADRE"; break;
			case "A": $parentesco = "ABUELO(A)"; break;
			case "O": $parentesco = "TUTOR(A) O RESPONSABLE"; break;
		}
		
		switch($ecivil){
			case "C": $ecivil = "CASADO(A)"; break;
			case "S": $ecivil = "SOLTERO(A)"; break;
		}
				
		
		// INICIA ESCRITURA DE PDF 
		$pdf->AddPage();
		$pdf->SetAutoPageBreak(false,2);
		
		$mleft = 0;
		$mtop = 0;
		$pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
		
		// Importa pdf de base 
		$pdf->setSourceFile('FICHA.pdf'); 
		
		// PAGINA # 1
		$tplIdx = $pdf->importPage(1); 
		// use the imported page as the template 
		$pdf->useTemplate($tplIdx, 0, 0);
		//------------------------------------------//
		//Asignar tamano de fuente
		$pdf->SetTextColor(76,76,76); // Gris
		$pdf->SetFont('Arial','',10);
		//----------- Datos del Alumno ------//
		$pdf->SetXY(80,52);
		$pdf->Cell(115, 5, $cui, 'B', 0, 'L');
		$pdf->SetXY(80,59.3);
		$pdf->Cell(115, 5, $tipocui, 'B', 0, 'L');
		$pdf->SetXY(80,66);
		$pdf->Cell(115, 5, $codigo, 'B', 0, 'L');
		$pdf->SetXY(80,73);
		$pdf->Cell(115, 5, $alunombre, 'B', 0, 'L');
		$pdf->SetXY(80,80.1);
		$pdf->Cell(115, 5, $aluapellido, 'B', 0, 'L');
		$pdf->SetXY(80,87.3);
		$pdf->Cell(115, 5, $genero, 'B', 0, 'L');
		$pdf->SetXY(80,94);
		$pdf->Cell(115, 5, $alufecnac, 'B', 0, 'L');
		$pdf->SetXY(80,100.4);
		$pdf->Cell(115, 5, $aluedad, 'B', 0, 'L');
		$pdf->SetXY(80,107);
		$pdf->Cell(115, 5, $sangre, 'B', 0, 'L');
		$pdf->SetXY(80,113.5);
		$pdf->Cell(115, 5, $alergico, 'B', 0, 'L');
		$pdf->SetXY(80,120);
		$pdf->Cell(115, 5, $emergencia, 'B', 0, 'L');
		$pdf->SetXY(80,126.5);
		$pdf->Cell(115, 5, $emertel, 'B', 0, 'L');
		
		//----------- Datos de Grado ------//
		$pdf->SetXY(80,150);
		$pdf->Cell(115, 5, $nivel, 'B', 0, 'L');
		$pdf->SetXY(80,157);
		$pdf->Cell(115, 5, $grado, 'B', 0, 'L');
		
		//----------- Datos de Grado ------//
		$pdf->SetXY(80,180);
		$pdf->Cell(115, 5, $nit, 'B', 0, 'L');
		$pdf->SetXY(80,187);
		$pdf->Cell(115, 5, $cliente, 'B', 0, 'L');
		
		//----------- Datos del Contratante ------//
		$pdf->SetXY(80,211);
		$pdf->Cell(115, 5, $dpi, 'B', 0, 'L');
		$pdf->SetXY(80,217.5);
		$pdf->Cell(115, 5, $tipodpi, 'B', 0, 'L');
		$pdf->SetXY(80,224);
		$pdf->Cell(115, 5, $nombre, 'B', 0, 'L');
		$pdf->SetXY(80,230.5);
		$pdf->Cell(115, 5, $apellido, 'B', 0, 'L');
		$pdf->SetXY(80,237.5);
		$pdf->Cell(115, 5, $fecnac, 'B', 0, 'L');
		$pdf->SetXY(80,244.5);
		$pdf->Cell(115, 5, utf8_decode($edad." años"), 'B', 0, 'L');
		$pdf->SetXY(80,251.5);
		$pdf->Cell(115, 5, $parentesco, 'B', 0, 'L');
		$pdf->SetXY(80,258);
		$pdf->Cell(115, 5, $ecivil, 'B', 0, 'L');
		$pdf->SetXY(80,265);
		$pdf->Cell(115, 5, $nacionalidad, 'B', 0, 'L');
		$pdf->SetXY(80,272);
		$pdf->Cell(115, 5, $mail, 'B', 0, 'L');
		$pdf->SetXY(80,279);
		$pdf->Cell(115, 5, $direccion, 'B', 0, 'L');
		$pdf->SetXY(80,286);
		$pdf->Cell(115, 5, $dep_desc, 'B', 0, 'L');
		$pdf->SetXY(80,292.5);
		$pdf->Cell(115, 5, $mun_desc, 'B', 0, 'L');
		$pdf->SetXY(80,298.5);
		$pdf->Cell(115, 5, $telcasa, 'B', 0, 'L');
		$pdf->SetXY(80,305);
		$pdf->Cell(115, 5, $celular, 'B', 0, 'L');
		$pdf->SetXY(80,311);
		$pdf->Cell(115, 5, $trabajo, 'B', 0, 'L');
		$pdf->SetXY(80,317.5);
		$pdf->Cell(115, 5, $teltrabajo, 'B', 0, 'L');
		$pdf->SetXY(80,324);
		$pdf->Cell(115, 5, $profesion, 'B', 0, 'L');
	}
	
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output("Boleta No. $boleta.pdf","I");
  
  
?>