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
	$anio_escolar = 2019;
	
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
			$cli = trim($row["alu_cliente_factura"]);
		}
	}
	
	
	if(strlen($cli)>0){
		$ClsCli = new ClsCliente();
		$result = $ClsCli->get_cliente($cli);
		if(is_array($result)){
      foreach($result as $row){
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
  $pdf = new FPDI('P','mm','Legal'); 
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	
	// Importa pdf de base 
	$pdf->setSourceFile('FICHA.pdf'); 
	
	$mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
	// PAGINA # 1
	$tplIdx = $pdf->importPage(1); 
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0);
	
	
	//------------------------------------------//
	//Asignar tamano de fuente
	$pdf->SetTextColor(76,76,76); // Gris
	$pdf->SetFont('Arial','',12);
			//----------- Datos del Alumno ------//
			$pdf->SetXY(80,52);
			$pdf->Cell(115, 6, $cui, 'B', 0, 'L');
			$pdf->SetXY(80,59.3);
			$pdf->Cell(115, 6, $tipocui, 'B', 0, 'L');
			$pdf->SetXY(80,66.6);
			$pdf->Cell(115, 6, $codigo, 'B', 0, 'L');
			$pdf->SetXY(80,73.9);
			$pdf->Cell(115, 6, $alunombre, 'B', 0, 'L');
			$pdf->SetXY(80,81.2);
			$pdf->Cell(115, 6, $aluapellido, 'B', 0, 'L');
			$pdf->SetXY(80,88.5);
			$pdf->Cell(115, 6, $genero, 'B', 0, 'L');
			$pdf->SetXY(80,95.8);
			$pdf->Cell(115, 6, $alufecnac, 'B', 0, 'L');
			$pdf->SetXY(80,103.1);
			$pdf->Cell(115, 6, $aluedad, 'B', 0, 'L');
			$pdf->SetXY(80,110.4);
			$pdf->Cell(115, 6, $sangre, 'B', 0, 'L');
			$pdf->SetXY(80,117.7);
			$pdf->Cell(115, 6, $alergico, 'B', 0, 'L');
			$pdf->SetXY(80,125);
			$pdf->Cell(115, 6, $emergencia, 'B', 0, 'L');
			$pdf->SetXY(80,132.3);
			$pdf->Cell(115, 6, $emertel, 'B', 0, 'L');
			
			//----------- Datos de Grado ------//
			$pdf->SetXY(80,147);
			$pdf->Cell(115, 6, $nivel, 'B', 0, 'L');
			$pdf->SetXY(80,154.3);
			$pdf->Cell(115, 6, $grado, 'B', 0, 'L');
			
			//----------- Datos de Grado ------//
			$pdf->SetXY(80,169);
			$pdf->Cell(115, 6, $nit, 'B', 0, 'L');
			$pdf->SetXY(80,176.3);
			$pdf->Cell(115, 6, $cliente, 'B', 0, 'L');
			
			//----------- Datos del Contratante ------//
			$pdf->SetXY(80,191);
			$pdf->Cell(115, 6, $dpi, 'B', 0, 'L');
			$pdf->SetXY(80,198.3);
			$pdf->Cell(115, 6, $tipodpi, 'B', 0, 'L');
			$pdf->SetXY(80,205.6);
			$pdf->Cell(115, 6, $nombre, 'B', 0, 'L');
			$pdf->SetXY(80,212.9);
			$pdf->Cell(115, 6, $apellido, 'B', 0, 'L');
			$pdf->SetXY(80,220.2);
			$pdf->Cell(115, 6, $fecnac, 'B', 0, 'L');
			$pdf->SetXY(80,227.5);
			$pdf->Cell(115, 6, $edad, 'B', 0, 'L');
			$pdf->SetXY(80,234.8);
			$pdf->Cell(115, 6, $parentesco, 'B', 0, 'L');
			$pdf->SetXY(80,242.1);
			$pdf->Cell(115, 6, $ecivil, 'B', 0, 'L');
			$pdf->SetXY(80,249.4);
			$pdf->Cell(115, 6, $nacionalidad, 'B', 0, 'L');
			$pdf->SetXY(80,256.7);
			$pdf->Cell(115, 6, $mail, 'B', 0, 'L');
			$pdf->SetXY(80,264);
			$pdf->Cell(115, 6, $direccion, 'B', 0, 'L');
			$pdf->SetXY(80,271.3);
			$pdf->Cell(115, 6, $dep_desc, 'B', 0, 'L');
			$pdf->SetXY(80,278.6);
			$pdf->Cell(115, 6, $mun_desc, 'B', 0, 'L');
			$pdf->SetXY(80,285.9);
			$pdf->Cell(115, 6, $telcasa, 'B', 0, 'L');
			$pdf->SetXY(80,293.2);
			$pdf->Cell(115, 6, $celular, 'B', 0, 'L');
			$pdf->SetXY(80,300.5);
			$pdf->Cell(115, 6, $trabajo, 'B', 0, 'L');
			$pdf->SetXY(80,307.8);
			$pdf->Cell(115, 6, $teltrabajo, 'B', 0, 'L');
			$pdf->SetXY(80,315.1);
			$pdf->Cell(115, 6, $profesion, 'B', 0, 'L');
			
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output("FICHA DE INSCRIPCION.pdf","I");
  
  
?>