<?php
  //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
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
			$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
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
		$result = $ClsCli->get_cliente($cliente);
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
  $pdf = new FPD('P','mm','Legal'); 
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	
	$mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
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
			//Se secciona
			$dpi_sec1 = substr($dpi,0,4);
			$dpi_sec2 = substr($dpi,4,5);
			$dpi_sec3 = substr($dpi,9,4);
			//Se convierte a letras
			$dpi_letras1 = trim($NumToWords->to_word($dpi_sec1));
			$dpi_letras2 = trim($NumToWords->to_word($dpi_sec2));
			$dpi_letras3 = trim($NumToWords->to_word($dpi_sec3));
			//-
			$pdf->SetXY(20,131.5);
			$pdf->MultiCell(175, 7, "EL $tipodpi $dpi_letras1, $dpi_letras2, $dpi_letras3 ($dpi).", 0, 'J', false);
				
			//----------- direccion ------//
			$pdf->SetXY(20,148.5);
			$pdf->MultiCell(175, 8, "$direccion DEL MUNICIPIO DE $mun_desc DEL DEPARTAMENTO DE $dep_desc.", 0, 'J', false);
			
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
			
	
	
	
			
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output("Correlativo interno Contrato No.  $contrato.pdf","I");
  
  
?>