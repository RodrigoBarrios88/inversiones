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
	
	if(strlen($cliente)>0){
		$result = $ClsCli->get_cliente($cliente);
		if(is_array($result)){
			foreach($result as $row){
				$nit = $row["cli_nit"];
				$cliente = $row["cli_nombre"];
			}
		}
	}
	
	//////SEGURO
	$result = $ClsSeg->get_seguro($cui);
	if(is_array($result)){
		foreach($result as $row){
			$seguro = trim($row["seg_tiene_seguro"]);
			$seguro = ($seguro == 1)?"Si":"No";
			$poliza = utf8_decode($row["seg_poliza"]);
			$aseguradora = utf8_decode($row["seg_aseguradora"]);
			$plan = utf8_decode($row["seg_plan"]);
			$asegurado = utf8_decode($row["seg_asegurado_principal"]);
			$instrucciones = utf8_decode($row["seg_instrucciones"]);
			$comentarios = utf8_decode($row["seg_comentarios"]);
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
	$pdf->MultiCell(76, 10, 'FICHA TÉCNICA DEL ALUMNO(A)', 'B' , 'C' , 0);
	
	
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
	$cabecera = array('CUI (ID): ', 'Nombres: ', 'Fecha de Nac.: ', 'Genero: ', 'Nacionalidad: ', 'Tipo de Sangre: ', 'En caso de emeregencia avisar a: ', 'Quién recoge en el colegio:', 'Email del Alumno: (no aplica para preescolar)');
	$pdf->outValues($cabecera,$x,$y,12,90,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($cui,$nombre,$fecnac,$genero,$nacionalidad,$sangre,$emergencia,$recoge,$mail);
	$pdf->outValues($valores,$x,$y+6,12,90,5,"Arial", 10, '', 'B');
	
	
	//-- DERECHA ---//
	$x = 110;
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array('Tipo de ID: ', 'Apellidos: ','Edad: ', 'Religion: ', 'Idioma Nativo: ','Alérgico a: ','Teléfono de emergencia: ','Autoriza publicar imagenes en redes Sociales','Código Interno: (Colegio/Institución) ');
	$pdf->outValues($cabecera,$x,$y,12,90,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($tipocui,$apellido,$edad,$religion,$idioma,$alergico,$emergencia_tel,$redesociales,$codigo);
	$pdf->outValues($valores,$x,$y+6,12,90,5,"Arial", 10, '', 'B');
	//----------------//
	
	$y = $pdf->getY();
	$x = 15;
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	//$pdf->MultiCell(185, 5, '', 'B' , 'L' , '');
	
	//-- Datos del colegio ---//
	$y+= 10; //salto de linea para espaciar
	$x = 15;
	//-- IZQUIERDA ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array('¿Cuenta con seguro médico externo? ', 'No. de Poliza: ', 'Plan: ');
	$pdf->outValues($cabecera,$x,$y,12,90,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($seguro,$poliza,$plan);
	$pdf->outValues($valores,$x,$y+6,12,90,5,"Arial", 10, '', 'B');
	
	
	//-- DERECHA ---//
	$x = 110;
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array('', 'Aseguradora: ','Asegurado Principal: ');
	$pdf->outValues($cabecera,$x,$y,12,90,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array('',$aseguradora,$asegurado);
	$pdf->outValues($valores,$x,$y+6,12,90,5,"Arial", 10, '', 'B');
	//----------------//
	$y = $pdf->getY();
	$y+= 6; //salto de linea para espaciar
	$x = 15;
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	//--
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY($x,$y);
	$pdf->Cell(90,5,'Instrucciones:','');
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$y += 6;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(185,5, $instrucciones, 'B' , 'J' , '');
	//--
	$y = $pdf->getY();
	$y+= 1; //salto de linea para espaciar
	$x = 15;
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	//--
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY($x,$y);
	$pdf->Cell(90,5,'Comentarios:','');
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$y += 6;
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(185,5, $comentarios, 'B' , 'J' , '');
	
//////////////_________________ Pagina 2 _________________////////////////////
	
	$pdf->AddPage();
	//******************* PRIVADO ARRIBA *****************
	$pdf->SetTextColor(3,3,3);
	//*******************Recuadro Hoja *****************
	$pdf->SetLineWidth(0.7);
	$pdf->SetDrawColor(0,0,0);
	$pdf->Rect(10,10,196,260);
	$pdf->SetLineWidth(0.2);
	//////////////------------------/////////////////////
	$pdf->SetMargins(0,0,0);
	$x = 15;
	$y = 15;
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	
	//-- Datos del colegio ---//
	$x = 15;
	//-- IZQUIERDA ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array('Nivel: ', 'Grado: ', 'Nit a Facturar: ');
	$pdf->outValues($cabecera,$x,$y,12,90,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($nivel,$grado,$nit);
	$pdf->outValues($valores,$x,$y+6,12,90,5,"Arial", 10, '', 'B');
	
	
	//-- DERECHA ---//
	$x = 110;
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array('', 'Sección: ','Cliente: ');
	$pdf->outValues($cabecera,$x,$y,12,90,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array('',$seccion,$cliente);
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
	$pdf->MultiCell(50, 5, 'FAMILIA', 'B' , 'L' , '');
	
	//-- Padres o encargados ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',10);
	$x = 15;
	$y += 10;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Padre / Madre o Encargados', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//----------------//
	////-- encabezados --/////
	$y += 10;
	$pdf->SetXY($x-2,$y);
	$pdf->SetWidths(array(8, 62, 25, 40, 35, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
    $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$y+= $pdf->Row(array('No.', 'Nombres', 'Parentesco', 'Email','Teléfono','Fecha Nac.'));
	}
	$y += 5;
	$pdf->SetWidths(array(8, 62, 25, 40, 35, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'L', 'C', 'L', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	////-- cuerpo --/////
	$ClsAsig = new ClsAsignacion();
	$result = $ClsAsig->get_alumno_padre('',$cui);
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//rrhh_familia   
			$nombres = utf8_decode($row["pad_nombre"])." ".utf8_decode($row["pad_apellido"]);
			//fecha
			$parentesco = $row["pad_parentesco"];
			switch($parentesco){
				case "P": $parentesco = "Padre"; break;
				case "M": $parentesco = "Madre"; break;
				case "A": $parentesco = "Abuelo(a)"; break;
				case "O": $parentesco = "Encargado"; break;
			}
			//mail
			$mail = trim($row["pad_mail"]);
			//usuario
			$telefono = trim($row["pad_celular"]);
			//usuario
			$fecnac_papa = trim($row["pad_fec_nac"]);
			$fecnac_papa = cambia_fecha($fecnac_papa);
			//---
			$pdf->SetXY($x-2,$y);
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$y+= $pdf->Row(array($i.'.',$nombres,$parentesco,$mail,$telefono,$fecnac_papa)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;
			$y += 5;
		}
	}else{
		
		$pdf->SetXY($x-2,$y);
		$pdf->SetFont('Arial','B',8); // 
		$pdf->SetFillColor(255,255,255); // AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell(190,5,'',1,'','C',true); // AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
	}
	
	
	
	$y = $pdf->getY();
	
	//-- Hermanos ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',10);
	$x = 15;
	$y += 10;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Hermanos', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//----------------//
	////-- encabezados --/////
	$y += 10;
	$pdf->SetXY($x-2,$y);
	$pdf->SetWidths(array(8, 62, 30, 25, 45, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
    $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$y+= $pdf->Row(array('No.', 'Nombres', 'Fecha Nac.', 'Edad','Grado','Situación'));
	}
	$y += 5;
	$pdf->SetWidths(array(8, 62, 30, 25, 45, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'L', 'C', 'C', 'L', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	////-- cuerpo --/////
	$ClsAsig = new ClsAsignacion();
	$result = $ClsAsig->get_alumno_padre('',$cui);
	if(is_array($result)){
		$padres = '';
		foreach($result as $row){
			$padres.= $row["pad_cui"].",";
		}
		$padres = substr($padres,0,-1);
	}else{
		$padres = 'X';
	}
	
	$result = $ClsAsig->get_hermanos($cui, $padres);
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//grado
			$nombres = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			//fecha
			$fecnac_hermanos = cambia_fecha($row["alu_fecha_nacimiento"]);
			//edad
			$edad = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]))." años";
			//grado
			$grado = utf8_decode($row["alu_grado"])." ".utf8_decode($row["alu_seccion"]);
			//situacion
			$sit = trim($row["alu_situacion"]);
			$situacion = ($sit == 1)?'Activo':'Inactivo';
			//---
			$pdf->SetXY($x-2,$y);
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$y+= $pdf->Row(array($i.'.',$nombres,$fecnac_hermanos,$edad,$grado,$situacion)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
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