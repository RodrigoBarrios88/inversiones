<?php
  //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
  require_once("../../recursos/fpdi/fpdi.php"); /// Clase para Importar PDFs Bases
	require_once("../../Clases/ClsNumLetras.php");
	
  //llena valores
	$NumToWords = new NumberToLetterConverter();
	$ClsIns = new ClsInscripcion();
	$cui = $_REQUEST["cui"];
	 
	//---//--//--//--
	$anio_escolar = 2018;
	
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
			$alunombre = utf8_decode($row["alu_nombre"]);
			$aluapellido = utf8_decode($row["alu_apellido"]);
			$alufecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
			$aluedad = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
			$genero = trim($row["alu_genero"]);
			$sangre = trim($row["alu_tipo_sangre"]);
			$alergico = utf8_decode($row["alu_alergico_a"]);
			$emergencia = utf8_decode($row["alu_emergencia"]);
			$emertel = utf8_decode($row["alu_emergencia_telefono"]);
			$cli = trim($row["alu_cliente_factura"]);
		}
	}
	
	
	if(strlen($cli)>0){
		$ClsCli = new ClsCliente();
		$result = $ClsCli->get_cliente($cli);
		if(is_array($result)){
      foreach($result as $row){
        //$cliente = $row["cli_id"];
        $nit = $row["cli_nit"];
        $cliente = utf8_decode($row["cli_nombre"]);
      }
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
  $pdf = new FPDI('P','mm','Legal'); 
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	
	// Importa pdf de base 
	$pdf->setSourceFile('../../../CONFIG/Documentos/CONTRATO3.pdf'); 
	
	$mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
	// PAGINA # 1
	$tplIdx = $pdf->importPage(1); 
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0);
	
	
	//----------- # de Contrato ------//
	//Asignar tamano de fuente
	$pdf->SetTextColor(255,0,0); // rojo
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY(175,26);
	$pdf->Cell(20, 5, $contrato, 0, 0, 'C');
	
	//----------- fecha de contrato ------//
	$pdf->SetTextColor(0,0,0); // LETRA COLOR AZUL
	$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(158,38.5);
		$pdf->Cell(11, 3, date("d"), 0, 0, 'C');
		$mes = Meses_Letra(date("m"));
		$pdf->SetXY(20,42.5);
		$pdf->Cell(47, 3, strtolower($mes), 0, 0, 'C'); //mes
		$year = $NumToWords->to_word(date("y"));
		$pdf->SetXY(93,42.5);
		$pdf->Cell(30, 3, strtolower($year), 0, 0, 'C');
		
	//----------- Edad de la Presidenta de la Fundación //////////
	$edad_presidenta = Calcula_Edad("10/02/1935");
	$pdf->SetXY(102,49.7);
	$pdf->Cell(20, 3, trim($edad_presidenta), 0, 0, 'C');
	
	////////////////////////////// CONTENIDO DE ESTATICO //////////////////////////
	$pdf->SetTextColor(0,0,0); // LETRA COLOR NEGRO
	$pdf->SetFont('Arial','B',8);
		//----------- CUERPO ------//
			
	$pdf->SetFont('Arial','B',10);
			//----------- Datos del Contratante ------//
			$pdf->SetXY(25,100);
			$pdf->Cell(85, 5, $nombre, 0, 0, 'C');
			$pdf->SetXY(110,100);
			$pdf->Cell(85, 5, $apellido, 0, 0, 'C');
			
			//----------- edad ------//
			$pdf->SetXY(25,110);
			$pdf->Cell(60, 5, utf8_decode("$edad años"), 0, 0, 'C');
			//----------- estado civil ------//
			$pdf->SetXY(88,110);
			$pdf->Cell(50, 5, utf8_decode($ecivil), 0, 0, 'C');
			//----------- Nacionalidad ------//
			$pdf->SetXY(142,110);
			$pdf->Cell(53, 5, $nacionalidad, 0, 0, 'C');
			//----------- Profesion ------//
			$pdf->SetXY(20,120);
			$pdf->Cell(117, 5, $profesion, 0, 0, 'C');
			
			//----------- IDENTIFICACION ------//
			//$dpi = "2582408570101";
			//Se secciona
			$dpi_sec1 = substr($dpi,0,4);
			//seccion 2 valida ceros
			$dpi_sec2 = substr($dpi,4,5);
			$letra1_sec2 = substr($dpi_sec2,0,1);
			$letra2_sec2 = substr($dpi_sec2,1,1);
			if($letra1_sec2 == 0){
				 $cero1_sec2 = "CERO ";
				 if($letra2_sec2 == 0){
						$cero2_sec2 = "CERO ";
				 }else{
						$cero2_sec2 = "";
				 }
			}else{
				 $cero1_sec2 = "";
				 $cero2_sec2 = "";
			}
			//seccion 3 valida ceros
			$dpi_sec3 = substr($dpi,9,4);
			$letra1_sec3 = substr($dpi_sec3,0,1);
			$letra2_sec3 = substr($dpi_sec3,1,1);
			if($letra1_sec3 == 0){
				 $cero1_sec3 = "CERO ";
				 if($letra2_sec3 == 0){
						$cero2_sec3 = "CERO ";
				 }else{
						$cero2_sec3 = "";
				 }
			}else{
				 $cero1_sec3 = "";
				 $cero2_sec3 = "";
			}
			//Se convierte a letras
			$dpi_letras1 = trim($NumToWords->to_word($dpi_sec1));
			$dpi_letras2 = $cero1_sec2."".$cero2_sec2."".trim($NumToWords->to_word($dpi_sec2));
			$dpi_letras3 = $cero1_sec3."".$cero2_sec3."".trim($NumToWords->to_word($dpi_sec3)).".";
			$dpi_letras3 = str_replace("UN.","UNO.",$dpi_letras3);
			//-
			$pdf->SetXY(20,131.5);
			$pdf->MultiCell(175, 7, "EL $tipodpi $dpi_letras1, $dpi_letras2, $dpi_letras3 ($dpi)", 0, 'J', false);
				
			//----------- direccion ------//
			$pdf->SetXY(20,148.5);
			$pdf->MultiCell(175, 8, "                              $direccion DEL MUNICIPIO DE $mun_desc DEL DEPARTAMENTO DE $dep_desc.", 0, 'J', false);
			
			//----------- telefonos ------//
			$pdf->SetXY(72,165);
			$pdf->Cell(55, 5, $telcasa, 0, 0, 'C');
			$pdf->SetXY(140,165);
			$pdf->Cell(55, 5, $teltrabajo, 0, 0, 'C');
			$pdf->SetXY(35,172);
			$pdf->Cell(52, 5, $celular, 0, 0, 'C');
			
			//----------- parentesco ------//
			$pdf->SetXY(125,172);
			$pdf->Cell(70, 5, $parentesco, 0, 0, 'C');
			
			
			//----------- CUI ------//
			$pdf->SetXY(90,217);
			$pdf->Cell(70, 5, $cui, 0, 0, 'C');
  
			//----------- Datos del Alumno ------//
			$pdf->SetXY(20,207);
			$pdf->Cell(90, 5, $alunombre, 0, 0, 'C');
			$pdf->SetXY(110,207);
			$pdf->Cell(85, 5, $aluapellido, 0, 0, 'C');
			
			//----------- Nivel Grado ------//
			$pdf->SetXY(20,225);
			$pdf->Cell(90, 5, $grado, 0, 0, 'C');
			$pdf->SetXY(110,225);
			$pdf->Cell(85, 5, $nivel, 0, 0, 'C');
			
			//----------- Nivel Grado ------//
			$pdf->SetXY(38,265.6);
			$pdf->Cell(14.5, 5, $anio_escolar, 0, 0, 'C');
			
			
	// PAGINA # 2
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	
	// Importa pdf de base 
	$pdf->setSourceFile('../../../CONFIG/Documentos/CONTRATO3.pdf'); 
	
	$mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
	$tplIdx = $pdf->importPage(2); 
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0);
	
	//----------- Montos  ------//
	$inscripcion = $arrMontos["INSCRIPCION"];
	$colegiatura = $arrMontos["COLEGIATURA"];
	
			$pdf->SetXY(130,209);
			$pdf->Cell(60, 5, number_format($inscripcion,2,'.',''), 0, 0, 'C');
			$pdf->SetXY(130,216.5);
			$pdf->Cell(60, 5, number_format($colegiatura,2,'.',''), 0, 0, 'C');
	
	
	// PAGINA # 3
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	
	// Importa pdf de base 
	$pdf->setSourceFile('../../../CONFIG/Documentos/CONTRATO3.pdf'); 
	
	$mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
	$tplIdx = $pdf->importPage(3); 
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0);
	
	//----------- direccion de notificacion ------//
	$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(20,143.7);
		$pdf->Cell(175, 3, "$direccion $mun_desc, $dep_desc.", 0, 0, 'C');
		
	//----------- fecha de contrato ------//
	$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(68,177);
		$pdf->Cell(14, 3, date("d"), 0, 0, 'C');
		$pdf->SetXY(89,177);
		$mes = Meses_Letra(date("m"));
		$pdf->Cell(29, 3, strtolower($mes), 0, 0, 'C'); //mes
		$year = $NumToWords->to_word(date("y"));
		$pdf->SetXY(175.2,177);
		$pdf->Cell(20, 3, strtolower($year), 0, 0, 'C');
		
		////////////// PARCHES DE FIRMAS /////////////////////
		//$pdf->Image("parche_antemi.jpg", 90, 240, 35, 35,"JPG");
		//$pdf->Line(90, 240,125,240); //gia del parche
		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(19,275);
		$pdf->Cell(70, 3, "f) Padre de familia y/o Representante Legal del educando", 0, 0, 'C'); //mes
		$pdf->Line(23.3,274.5,92,274.5);
		//--
		$pdf->SetXY(127,275);
		$pdf->Cell(70, 3, "f)               Nidia Licett Montenegro Flores", 0, 0, 'C'); //mes
		$pdf->SetXY(127,278);
		$pdf->Cell(70, 3, "                 (Presidenta del Consejo Directivo)", 0, 0, 'C'); //mes
		$pdf->Line(127,274.5,199,274.5);
		//--
		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(0,285);
		$pdf->Cell(217, 5, "ANTE MI", 0, 0, 'C'); //mes
		
		
	// PAGINA # 4
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	
	// Importa pdf de base 
	$pdf->setSourceFile('../../../CONFIG/Documentos/CONTRATO1.pdf'); 
	
	$mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
	$tplIdx = $pdf->importPage(1);  ///pagina 2 en el PDF
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0);
	
	//----------- # de Contrato ------//
	//Asignar tamano de fuente
	$pdf->SetTextColor(255,0,0); // rojo
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY(175,10);
	$pdf->Cell(15, 5, $contrato, 0, 0, 'L');
	$pdf->SetTextColor(0,0,0); // Negro
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(130,10);
	$pdf->Cell(45, 5, "Correlativo interno Contrato No.  ", 0, 0);
	
	
	$pdf->SetFont('Arial','B',10);
	//----------- Nombre del Contratante ------//
		$pdf->SetXY(20,80);
		$pdf->Cell(175, 5, "$nombre $apellido", 0, 0, 'C');
	//----------- edad ------//
		$pdf->SetXY(35,87);
		$pdf->Cell(40, 5, $edad, 0, 0, 'C');
		
	//----------- IDENTIFICACION ------//
		//Se secciona
			$dpi_sec1 = substr($dpi,0,4);
			//seccion 2 valida ceros
			$dpi_sec2 = substr($dpi,4,5);
			$letra1_sec2 = substr($dpi_sec2,0,1);
			$letra2_sec2 = substr($dpi_sec2,1,1);
			if($letra1_sec2 == 0){
				 $cero1_sec2 = "CERO ";
				 if($letra2_sec2 == 0){
						$cero2_sec2 = "CERO ";
				 }else{
						$cero2_sec2 = "";
				 }
			}else{
				 $cero1_sec2 = "";
				 $cero2_sec2 = "";
			}
			//seccion 3 valida ceros
			$dpi_sec3 = substr($dpi,9,4);
			$letra1_sec3 = substr($dpi_sec3,0,1);
			$letra2_sec3 = substr($dpi_sec3,1,1);
			if($letra1_sec3 == 0){
				 $cero1_sec3 = "CERO ";
				 if($letra2_sec3 == 0){
						$cero2_sec3 = "CERO ";
				 }else{
						$cero2_sec3 = "";
				 }
			}else{
				 $cero1_sec3 = "";
				 $cero2_sec3 = "";
			}
			//Se convierte a letras
			$dpi_letras1 = trim($NumToWords->to_word($dpi_sec1));
			$dpi_letras2 = $cero1_sec2."".$cero2_sec2."".trim($NumToWords->to_word($dpi_sec2));
			$dpi_letras3 = $cero1_sec3."".$cero2_sec3."".trim($NumToWords->to_word($dpi_sec3)).".";
			$dpi_letras3 = str_replace("UN.","UNO.",$dpi_letras3);
			//-
			$pdf->SetXY(30,97);
			$pdf->MultiCell(155, 5, "EL $tipodpi $dpi_letras1, $dpi_letras2, $dpi_letras3 ($dpi)", 0, 'J', false);	
			
	//----------- direccion ------//
			$pdf->SetXY(30,140.5);
			$pdf->MultiCell(155, 7, "$direccion DEL MUNICIPIO DE $mun_desc DEL DEPARTAMENTO DE $dep_desc.", 0, 'J', false);
			
	//----------- telefonos ------//
			$pdf->SetXY(100,153.2);
			$pdf->Cell(52, 5, "$telcasa - $celular", 0, 0, 'C');
			
	//----------- alumno ------//
			$pdf->SetXY(70,158.3);
			$pdf->Cell(115, 5, "$alunombre $aluapellido", 0, 0, 'C');
			
	//----------- Grado y Nivel ------//
			$pdf->SetXY(70,165.3);
			$pdf->Cell(70, 5, $grado, 0, 0, 'C');
			$pdf->SetXY(30,170.3);
			$pdf->Cell(70, 5, $nivel, 0, 0, 'C');
			
	//----------- CUI ------//
			$pdf->SetXY(137,170);
			$pdf->Cell(50, 5, $cui, 0, 0, 'C');
	/// edad
			$pdf->SetXY(36,175);
			$pdf->Cell(20, 5, $aluedad, 0, 0, 'C');
			
	//----------- alumno ------//
			$pdf->SetXY(30,243.4);
			$pdf->Cell(155, 5, "$alunombre $aluapellido", 0, 0, 'C');
			
	//----------- Montos  ------//
	$complementarios = $arrMontos["COMPLEMENTARIO"];
	//$complementarios = 575;
			$pdf->SetXY(30,268.2);
			$pdf->Cell(115, 5, trim($NumToWords->to_word($complementarios))." QUETZALES EXACTOS" , 0, 0, 'L');
			$pdf->SetXY(155,268.2);
			$pdf->Cell(27, 5, number_format($complementarios,2,'.',''), 0, 0, 'C');
			
	// PAGINA # 5
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	
	// Importa pdf de base 
	$pdf->setSourceFile('../../../CONFIG/Documentos/CONTRATO1.pdf'); 
	
	$mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
	$tplIdx = $pdf->importPage(2);  ///pagina 2 en el PDF
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0);
	
	//----------- direccion de notificacion ------//
	$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(30,129.6);
		$pdf->Cell(157, 3, "$direccion $mun_desc, $dep_desc.", 0, 0, 'C');
		
	//----------- fecha de contrato ------//
	$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(83,168.8);
		$pdf->Cell(11, 3, date("d"), 0, 0, 'C');
		$mes = Meses_Letra(date("m"));
		$pdf->SetXY(100,168.8);
		$pdf->Cell(35, 3, strtolower($mes), 0, 0, 'C'); //mes
		$year = $NumToWords->to_word(date("y"));
		$pdf->SetXY(158,168.8);
		$pdf->Cell(27, 3, strtolower($year), 0, 0, 'C');
		
	////////////// PARCHES DE FIRMAS /////////////////////
		//$pdf->Image("parche_antemi.jpg", 90, 240, 35, 35,"JPG");
		//$pdf->Line(90, 240,125,240); //gia del parche
		$pdf->SetFont('Arial','',10);
		$pdf->SetXY(23,276);
		$pdf->Cell(70, 3, "Responsable del Alumno", 0, 0, 'C'); //mes
		$pdf->Line(30,274.5,87,274.5);
		//--
		$pdf->SetXY(120,276);
		$pdf->Cell(55, 3, utf8_decode("Byron Giovanni Méndez Ruiz"), 0, 0, 'C'); //mes
		$pdf->Line(123,274.5,183,274.5);
		//--
		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(0,285);
		$pdf->Cell(217, 5, "ANTE MI", 0, 0, 'C'); //mes
	
	
	
	// PAGINA # 6
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	
	// Importa pdf de base 
	$pdf->setSourceFile('../../../CONFIG/Documentos/CONTRATO2.pdf'); 
	
	$mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
	$tplIdx = $pdf->importPage(1); //pagina 1 en el PDF
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0);
	
	//----------- # de Contrato ------//
	//Asignar tamano de fuente
	$pdf->SetTextColor(255,0,0); // rojo
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY(175,10);
	$pdf->Cell(15, 5, $contrato, 0, 0, 'L');
	$pdf->SetTextColor(0,0,0); // Negro
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(130,10);
	$pdf->Cell(45, 5, "Correlativo interno Contrato No.  ", 0, 0);
	
	$pdf->SetFont('Arial','B',10);
	//----------- Nombre del Contratante ------//
		$pdf->SetXY(20,80.5);
		$pdf->Cell(175, 5, "$nombre $apellido", 0, 0, 'C');
	//----------- edad ------//
		$pdf->SetXY(35,88);
		$pdf->Cell(35, 5, $edad, 0, 0, 'C');
		
	//----------- IDENTIFICACION ------//	
			//Se secciona
			$dpi_sec1 = substr($dpi,0,4);
			//seccion 2 valida ceros
			$dpi_sec2 = substr($dpi,4,5);
			$letra1_sec2 = substr($dpi_sec2,0,1);
			$letra2_sec2 = substr($dpi_sec2,1,1);
			if($letra1_sec2 == 0){
				 $cero1_sec2 = "CERO ";
				 if($letra2_sec2 == 0){
						$cero2_sec2 = "CERO ";
				 }else{
						$cero2_sec2 = "";
				 }
			}else{
				 $cero1_sec2 = "";
				 $cero2_sec2 = "";
			}
			//seccion 3 valida ceros
			$dpi_sec3 = substr($dpi,9,4);
			$letra1_sec3 = substr($dpi_sec3,0,1);
			$letra2_sec3 = substr($dpi_sec3,1,1);
			if($letra1_sec3 == 0){
				 $cero1_sec3 = "CERO ";
				 if($letra2_sec3 == 0){
						$cero2_sec3 = "CERO ";
				 }else{
						$cero2_sec3 = "";
				 }
			}else{
				 $cero1_sec3 = "";
				 $cero2_sec3 = "";
			}
			//Se convierte a letras
			$dpi_letras1 = trim($NumToWords->to_word($dpi_sec1));
			$dpi_letras2 = $cero1_sec2."".$cero2_sec2."".trim($NumToWords->to_word($dpi_sec2));
			$dpi_letras3 = $cero1_sec3."".$cero2_sec3."".trim($NumToWords->to_word($dpi_sec3)).".";
			$dpi_letras3 = str_replace("UN.","UNO.",$dpi_letras3);
			//-
			$pdf->SetXY(30,97.8);
			$pdf->MultiCell(155, 5, "EL $tipodpi $dpi_letras1, $dpi_letras2, $dpi_letras3 ($dpi).", 0, 'J', false);	
			
	//----------- direccion ------//
			$pdf->SetXY(30,141.2);
			$pdf->MultiCell(155, 7, "$direccion DEL MUNICIPIO DE $mun_desc DEL DEPARTAMENTO DE $dep_desc.", 0, 'J', false);
			
	//----------- telefonos ------//
			$pdf->SetXY(100,154);
			$pdf->Cell(80, 5, "$telcasa - $celular", 0, 0, 'C');
			
	//----------- alumno ------//
			$pdf->SetXY(30,164);
			$pdf->Cell(155, 5, "$alunombre $aluapellido", 0, 0, 'C');
			
	//----------- Grado y Nivel ------//
			$pdf->SetXY(65,171);
			$pdf->Cell(83, 5, $grado, 0, 0, 'C');
			$pdf->SetXY(30,176);
			$pdf->Cell(63, 5, $nivel, 0, 0, 'C');
			
	//----------- CUI ------//
			$pdf->SetXY(134,176);
			$pdf->Cell(45, 5, $cui, 0, 0, 'C');
	/// edad
			$pdf->SetXY(31,181);
			$pdf->Cell(20, 5, $aluedad, 0, 0, 'C');
			
	//----------- alumno ------//
			$pdf->SetXY(30,246);
			$pdf->Cell(155, 5, "$alunombre $aluapellido", 0, 0, 'C');
			
	//----------- Montos de Libros  ------//
	$pdf->SetFont('Arial','B',8);
	if($nivCodigo == 1){
		$libros = $arrLibros[1];
		$arrlibrosletras = explode(".",$libros);
		$enteros = intval($arrlibrosletras[0]);
		$enteros_letras = trim($NumToWords->to_word($enteros));
		//-- valida decimales 00
		$decimales = trim($arrlibrosletras[1]);
		if($decimales > 0){
			$decimales_letras = trim($NumToWords->to_word($decimales))." CENTAVOS";	
		}else{
			$decimales_letras = "EXACTOS";
		}
		
				$pdf->SetXY(30,306);
				$pdf->Cell(115, 5, "$enteros_letras QUETZALES $decimales_letras" , 0, 0, 'L');
				$pdf->SetXY(169,306);
				$pdf->Cell(15, 5, number_format($libros,2,'.',''), 0, 0, 'C');
	}else{
		$libros = $arrLibros[1];
		$arrlibrosletras = explode(".",$libros);
		$enteros = intval($arrlibrosletras[0]);
		$enteros_letras = trim($NumToWords->to_word($enteros));
		//-- valida decimales 00
		$decimales = trim($arrlibrosletras[1]);
		if($decimales > 0){
			$decimales_letras = trim($NumToWords->to_word($decimales))." CENTAVOS";	
		}else{
			$decimales_letras = "EXACTOS";
		}
		
				$pdf->SetXY(30,271.3);
				$pdf->Cell(115, 5, "$enteros_letras QUETZALES $decimales_letras" , 0, 0, 'L');
				$pdf->SetXY(169,271.3);
				$pdf->Cell(15, 5, number_format($libros,2,'.',''), 0, 0, 'C');
	}
	
	
	
	// PAGINA # 7
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	
	// Importa pdf de base 
	$pdf->setSourceFile('../../../CONFIG/Documentos/CONTRATO2.pdf'); 
	
	$mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
	$tplIdx = $pdf->importPage(2); //pagina 2 en el PDF
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0);
	
	//----------- direccion de notificacion ------//
	$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(30,163.6);
		$pdf->Cell(157, 3, "$direccion $mun_desc, $dep_desc.", 0, 0, 'C');
		
	//----------- fecha de contrato ------//
	$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(83,198.5);
		$pdf->Cell(11, 3, date("d"), 0, 0, 'C');
		$mes = Meses_Letra(date("m"));
		$pdf->SetXY(100,198.5);
		$pdf->Cell(35, 3, strtolower($mes), 0, 0, 'C'); //mes
		$year = $NumToWords->to_word(date("y"));
		$pdf->SetXY(158,198.5);
		$pdf->Cell(27, 3, strtolower($year), 0, 0, 'C');
		
	////////////// PARCHES DE FIRMAS /////////////////////
		//$pdf->Image("parche_antemi.jpg", 90, 240, 35, 35,"JPG");
		//$pdf->Line(90, 240,125,240); //gia del parche
		$pdf->SetFont('Arial','',10);
		$pdf->SetXY(23,276);
		$pdf->Cell(70, 3, "Responsable del Alumno", 0, 0, 'C'); //mes
		$pdf->Line(30,274.5,87,274.5);
		//--
		$pdf->SetXY(120,276);
		$pdf->Cell(55, 3, utf8_decode("Oswaldo Antonio Hernández Díaz"), 0, 0, 'C'); //mes
		$pdf->Line(118,274.5,183,274.5);
		//--
		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(0,285);
		$pdf->Cell(215, 5, "ANTE MI", 0, 0, 'C'); //mes
	
			
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output("Correlativo interno Contrato No.  $contrato.pdf","I");
  
  
?>