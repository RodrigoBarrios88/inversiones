<?php
	include_once('html_fns_reportes.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	
	$ClsAlu = new ClsAlumno();
	$ClsCli = new ClsCliente();
	$ClsAcadem = new ClsAcademico();
	$ClsAsig = new ClsAsignacion();
	$ClsSeg = new ClsSeguro();
	$cui = $ClsAlu->decrypt($hashkey, $usuario);
	
	$result = $ClsAlu->get_alumno($cui,"","",1);
	if(is_array($result)){
		foreach($result as $row){
			$cui = trim($row["alu_cui"]);
			$tipocui = trim($row["alu_tipo_cui"]);
			$codigo = trim($row["alu_codigo_interno"]);
			//pasa a mayusculas
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombre_completo = ucwords(strtolower($nombre." ".$apellido));
			//--------
			$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
			$edad = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]))." año(s)";
			$genero = trim($row["alu_genero"]);
			$genero = ($genero == "M")?"Niño":"Niña";
			$nacionalidad = utf8_decode($row["alu_nacionalidad"]);
			$religion = utf8_decode($row["alu_religion"]);
			$idioma = utf8_decode($row["alu_idioma"]);
			$mail = trim($row["alu_mail"]);
			$cliente = trim($row["alu_cliente_factura"]);
			//--
			$sangre = trim($row["alu_tipo_sangre"]);
			$alergico = utf8_decode($row["alu_alergico_a"]);
			$emergencia = utf8_decode($row["alu_emergencia"]);
			$emergencia_tel = trim($row["alu_emergencia_telefono"]);
			$recoge = utf8_decode($row["alu_recoge"]);
			$redesociales = trim($row["alu_redes_sociales"]);
			//---
			$foto = trim($row["alu_foto"]);
		}
	}
	
	$result = $ClsAcadem->get_grado_alumno($pensum,'','',$cui,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$nivel = utf8_decode($row["niv_descripcion"]);
			$grado = utf8_decode($row["gra_descripcion"]);
			//--
			
		}
	}
	
	$result = $ClsAcadem->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$seccion = utf8_decode($row["sec_descripcion"]);
		}
	}

	
	$pdf = new PDF('P','mm','Letter');  // si quieren el reporte horizontal
	// P Hoja vertical, tamaño carta, medida en milimetros, ancho total de la hoja 200.5mm
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(0,0,0);
	
	//*******************Recuadro Hoja *****************
	$pdf->SetLineWidth(0.7);
	$pdf->Rect(10,10,196,260);
	$pdf->SetLineWidth(0.2);

	//******************* Inicializacion de Abcisa y Ordenada *****************
	$x = 5;
	$y = 5;
	//******************* PRIVADO ARRIBA *****************
	$pdf->SetTextColor(3,3,3);
	$pdf->SetLineWidth(0.5);
	
	//*******************Recuadro del logo *****************
	if(file_exists('../../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
		$pdf->Image('../../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg',15.1,15.1,39.8,39.8);
	}else{
		$pdf->Image('../../../CONFIG/Fotos/nofoto.jpg',15.1,15.1,39.8,39.8);
	}
	//Borde recuadro
	$pdf->SetXY(15,15);
	$pdf->Cell(40,40,'',1);
	
	//*******************Recuadro del Logo *****************
	//logo
	$pdf->Image('../../../CONFIG/images/replogo.jpg',161.1,15.1,39.8,39.8);
	
	//Borde recuadro
	$pdf->SetXY(161,15);
	$pdf->Cell(40,40,'',1);
	
	//******************* Estado Mayor de la Defensa Nacional *****************
	//******************* FORMULARIO DE DATOS PERSONALES *****************
	$pdf->SetXY(70,30);
	$pdf->SetFont('Arial','B',12);
	$pdf->SetTextColor(3,3,3);
	$pdf->MultiCell(76, 10, 'BITACORA PSICOPEDAGÓGICA DEL ALUMNO(A)', 'B' , 'C' , 0);
	
	
	//******************* Datos Individuales *****************
	$pdf->SetMargins(0,0,0);
	$x = 15;
	$y = 60;
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(50, 5, 'DATOS GENERALES', 'B' , 'L' , '');
	
	$y+=8; //salto de linea para espaciar
	
	//-- Datos generales ---//
	$x = 15;
	//-- IZQUIERDA ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array('CUI (ID): ', 'Nombres: ', 'Fecha de Nac.: ', 'Genero: ', 'Grado: ');
	$pdf->outValues($cabecera,$x,$y,12,90,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($cui,$nombre,$fecnac,$genero,$grado);
	$pdf->outValues($valores,$x,$y+6,12,90,5,"Arial", 10, '', 'B');
	
	
	//-- DERECHA ---//
	$x = 110;
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array('Tipo de ID: ', 'Apellidos: ','Edad: ', 'Nivel: ', 'Sección');
	$pdf->outValues($cabecera,$x,$y,12,90,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($tipocui,$apellido,$edad,$nivel,$seccion);
	$pdf->outValues($valores,$x,$y+6,12,90,5,"Arial", 10, '', 'B');
	//----------------//

	//--
	$x = 15;
	$y = $pdf->getY();
	$y+=10;
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(100, 5, 'BITACORA PSICOPEDAGÓGICA', 'B' , 'L' , '');
	
	////-- encabezados --/////
	$y += 10;
	$pdf->SetXY($x-2,$y);
	$pdf->SetWidths(array(8, 30, 27, 90, 35));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
    $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$y+= $pdf->Row(array('No.', 'Grado/Sección', 'Fecha', 'Comentario','Registró'));
	}
	$y += 5;
	$pdf->SetWidths(array(8, 30, 27, 90, 35));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'L', 'C', 'J', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	////-- cuerpo --/////
	$ClsAcadem = new ClsAcademico();
	$result =  $ClsAcadem->get_comentario_psicopedagogico('',$cui, '', '', '','',1);
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//grado
			$seccion = utf8_decode($row["sec_descripcion"]);
			$grado = utf8_decode($row["gra_descripcion"]);
			$grado_seccion = $grado.' '.$seccion;
			//fecha
			$fechor = $row["psi_fechor_registro"];
			$fechor = cambia_fechaHora($fechor);
			//comentario
			$coment = utf8_decode($row["psi_comentario"]);
			//usuario
			$usuario_nom = utf8_decode($row["usu_nombre_registro"]);
			//---
			$pdf->SetXY($x-2,$y);
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$y+= $pdf->Row(array($i.'.',$grado_seccion,$fechor,$coment,$usuario_nom)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;
			$y += 5;
		}
	}else{
		
		$pdf->SetXY($x-2,$y);
		$pdf->SetFont('Arial','B',8); // 
		$pdf->SetFillColor(255,255,255); // AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell(190,5,'',1,'','C',true); // AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
	}
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>