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
	
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
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
	$pdf->MultiCell(76, 10, 'BITÁCORA PREESCOLAR DEL ALUMNO(A)', 'B' , 'C' , 0);
	
	
	//******************* Datos Individuales *****************
	$pdf->SetMargins(0,0,0);
	$x = 15;
	$y = 60;
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(50, 5, 'Datos Generales', 'B' , 'L' , '');
	
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
	$pdf->MultiCell(50, 5, 'Historial Personal', 'B' , 'L' , '');
	
	$ClsFic = new ClsFicha();
	$result = $ClsFic->get_info_colegio($cui);
	if(is_array($result)){
		foreach($result as $row){
			$edad_colegio = utf8_decode($row["col_edad_colegio"]);
			$adaptado = utf8_decode($row["col_adaptado"]);
			$adaptado = ($adaptado == 1)?"Si":"No";
			$repitente = utf8_decode($row["col_repitente"]);
			$repitente = ($repitente == 1)?"Si":"No";
			$repite_grado = utf8_decode($row["col_repite_grado"]);
			$colegios_anteriores = utf8_decode($row["col_colegios_anteriores"]);
			$retirado_por = utf8_decode($row["col_retirado_por"]);
			$porque_este = utf8_decode($row["col_porque_este"]);
			$hermanos_aqui = utf8_decode($row["col_hermanos_aqui"]);
			$hermanos_aqui = ($hermanos_aqui == 1)?"Si":"No";
			$estudiaron_aqui = utf8_decode($row["col_estudiaron_aqui"]);
			$hermanos  = utf8_decode($row["col_hermanos"]);
			$lugar_hermanos = utf8_decode($row["col_lugar_hermanos"]);
			$vive_con = utf8_decode($row["col_vive_con"]);
			$actualizo = utf8_decode($row["col_fecha_actualiza"]);
        }
	}
	
	if($actualizo != ""){
		$actualizo = cambia_fechaHora($actualizo);
		$actualizado = 'Actualizado el '.$actualizo;
		$pdf->SetTextColor(80, 176, 9);
		$pdf->SetDrawColor(80, 176, 9);
	}else{
		$actualizado = 'No ha actualizado la información';
		$pdf->SetTextColor(204, 138, 58);
		$pdf->SetDrawColor(204, 138, 58);
	}
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(135,$y);
	$pdf->Cell(65,5,$actualizado,1,0,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	
	//-- Datos generales ---//
	$y+=8; //salto de linea para espaciar
	$x = 15;
	//-- Paso 1 ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array(
					'1. ¿A qué edad asistió por primera vez al colegio? ',
					'2. ¿Se adapto? ',
					'3. ¿Es alumno repitente?',
					'4. ¿Que grado a repetido?',
					'5. ¿En que colegios ha estado?',
					'6. ¿Porque fue retirado?',
					'7. ¿Por qué eligió usted este colegio?',
					'8. ¿Tiene hermanos en el colegio?',
					'9. ¿Quien(es) ha(n) estudiado en este colegio?',
				);
	$pdf->outValues($cabecera,$x,$y,12,185,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($edad_colegio,$adaptado,$repitente,$repite_grado,$colegios_anteriores,$retirado_por,$porque_este,$hermanos_aqui,$estudiaron_aqui);
	$pdf->outValues($valores,$x+5,$y+6,12,180,5,"Arial", 10, '', 'B');

	////////////_________________ Pagina 2 _________________////////////////////
	
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
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
	
	//-- Paso 1 ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array(
					'10. ¿Cuántos hermanos tiene el niño?',
					'11. ¿Que lugar ocupa entre ellos?',
					'12. ¿El niño vive con?'
				);
	$pdf->outValues($cabecera,$x,$y,12,185,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($hermanos,$lugar_hermanos,$vive_con);
	$pdf->outValues($valores,$x+5,$y+6,12,180,5,"Arial", 10, '', 'B');
	
	
	
	/////////////////////////////////////////////////////////--
	$x = 15;
	$y = $pdf->getY();
	$y+=10;
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(60, 5, 'Información del Embarazo', 'B' , 'L' , '');
	
	$ClsFic = new ClsFicha();
	$result = $ClsFic->get_embarazo($cui);
	if(is_array($result)){
		foreach($result as $row){
			$planificado = utf8_decode($row["emb_planificado"]);
			$planificado = ($planificado == 1)?"Si":"No";
			$duracion = utf8_decode($row["emb_duracion"]);
			$complicaciones = utf8_decode($row["emb_complicaciones"]);
			$complicaciones = ($complicaciones == 1)?"Si":"No";
			$tipo_complicaciones = utf8_decode($row["emb_tipo_complicaciones"]);
			$rayos_x = utf8_decode($row["emb_rayos_x"]);
			$rayos_x = ($rayos_x == 1)?"Si":"No";
			$depresion = utf8_decode($row["emb_depresion"]);
			$depresion = ($depresion == 1)?"Si":"No";
			$otros = utf8_decode($row["emb_otros"]);
			$actualizo = utf8_decode($row["emb_fecha_actualiza"]);
		}	
	}
	
	if($actualizo != ""){
		$actualizo = cambia_fechaHora($actualizo);
		$actualizado = 'Actualizado el '.$actualizo;
		$pdf->SetTextColor(80, 176, 9);
		$pdf->SetDrawColor(80, 176, 9);
	}else{
		$actualizado = 'No ha actualizado la información';
		$pdf->SetTextColor(204, 138, 58);
		$pdf->SetDrawColor(204, 138, 58);
	}
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(135,$y);
	$pdf->Cell(65,5,$actualizado,1,0,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	
	//-- Información del Embarazo ---//
	$y+=8; //salto de linea para espaciar
	$x = 15;
	//-- Paso 2 ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array(
					'1. ¿Fue planificado? ',
					'2. Respecto a la duración ',
					'3. ¿Tuvo complicaciones durante el embarazo?',
					'4. Tipo de complicaciones',
					'5. ¿Tomaron radiografías o rayos "X"?',
					'6. ¿Sufrió depresión o exceso de tensión?',
					'7. ¿Otra Afección?',
				);
	$pdf->outValues($cabecera,$x,$y,12,185,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($planificado,$duracion,$complicaciones,$tipo_complicaciones,$rayos_x,$depresion,$otros);
	$pdf->outValues($valores,$x+5,$y+6,12,180,5,"Arial", 10, '', 'B');
	
	
	/////////////////////////////////////////////////////////--
	$x = 15;
	$y = $pdf->getY();
	$y+=10;
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(60, 5, 'Información del Parto', 'B' , 'L' , '');
	
	$ClsFic = new ClsFicha();
	$result = $ClsFic->get_parto($cui);
	if(is_array($result)){
		foreach($result as $row){
			$tipo = utf8_decode($row["par_tipo"]);
			$tipo = ($tipo == "C")?"Ces&aacute;rea":"Normal";
			$anestesia = utf8_decode($row["par_anestesia"]);
			$anestesia = ($anestesia == 1)?"Si":"No";
			$inducido = utf8_decode($row["par_inducido"]);
			$inducido = ($inducido == 1)?"Si":"No";
			$forceps = utf8_decode($row["par_forceps"]);
			$forceps = ($forceps == 1)?"Si":"No";
			$otros = utf8_decode($row["par_otro"]);
			$actualizo = utf8_decode($row["par_fecha_actualiza"]);
		}	
	}
	
	if($actualizo != ""){
		$actualizo = cambia_fechaHora($actualizo);
		$actualizado = 'Actualizado el '.$actualizo;
		$pdf->SetTextColor(80, 176, 9);
		$pdf->SetDrawColor(80, 176, 9);
	}else{
		$actualizado = 'No ha actualizado la información';
		$pdf->SetTextColor(204, 138, 58);
		$pdf->SetDrawColor(204, 138, 58);
	}
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(135,$y);
	$pdf->Cell(65,5,$actualizado,1,0,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	
	//-- Información del Parto ---//
	$y+=8; //salto de linea para espaciar
	$x = 15;
	//-- Paso 3 ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array(
					'1. Tipo de Parto ',
					'2. ¿Con anestesia? ',
					'3. ¿Inducido?',
					'4. ¿Con fórceps?',
					'5. ¿Otra método?',
				);
	$pdf->outValues($cabecera,$x,$y,12,185,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($tipo,$anestesia,$inducido,$forceps,$otro);
	$pdf->outValues($valores,$x+5,$y+6,12,180,5,"Arial", 10, '', 'B');
	
	/////////////////////////////////////////////////////////--
	$x = 15;
	$y = $pdf->getY();
	$y+=10;
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(60, 5, 'Información de Lactancia', 'B' , 'L' , '');
	
	$ClsFic = new ClsFicha();
	$result = $ClsFic->get_lactancia($cui);
	if(is_array($result)){
		foreach($result as $row){
			$pecho = utf8_decode($row["lac_pecho"]);
			$pecho = ($pecho == 1)?"Si":"No";
			$pacha = utf8_decode($row["lac_pacha"]);
			$pacha = ($pacha == 1)?"Si":"No";
			$vomitos = utf8_decode($row["lac_vomitos"]);
			$vomitos = ($vomitos == 1)?"Si":"No";
			$colicos = utf8_decode($row["lac_colicos"]);
			$colicos = ($colicos == 1)?"Si":"No";
			$actualizo = utf8_decode($row["lac_fecha_actualiza"]);
		}	
	}
	
	if($actualizo != ""){
		$actualizo = cambia_fechaHora($actualizo);
		$actualizado = 'Actualizado el '.$actualizo;
		$pdf->SetTextColor(80, 176, 9);
		$pdf->SetDrawColor(80, 176, 9);
	}else{
		$actualizado = 'No ha actualizado la información';
		$pdf->SetTextColor(204, 138, 58);
		$pdf->SetDrawColor(204, 138, 58);
	}
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(135,$y);
	$pdf->Cell(65,5,$actualizado,1,0,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	
	//-- Información de Lactancia ---//
	$y+=8; //salto de linea para espaciar
	$x = 15;
	//-- Paso 4 ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array(
					'1. ¿Tomó pecho? ',
					'2. ¿Tomó biberón o pacha? ',
				);
	$pdf->outValues($cabecera,$x,$y,12,185,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($pecho,$pacha);
	$pdf->outValues($valores,$x+5,$y+6,12,180,5,"Arial", 10, '', 'B');
	
	////////////_________________ Pagina 3 _________________////////////////////
	
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
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
	
	//-- Paso 4 ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array(
					'3. ¿Padeció de vómitos?',
					'4. ¿Padeció de cólicos?',
				);
	$pdf->outValues($cabecera,$x,$y,12,185,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($vomitos,$colicos);
	$pdf->outValues($valores,$x+5,$y+6,12,180,5,"Arial", 10, '', 'B');
	
	/////////////////////////////////////////////////////////--
	$x = 15;
	$y = $pdf->getY();
	$y+=10;
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(60, 5, 'Desarrollo Motor', 'B' , 'L' , '');
	
	$ClsFic = new ClsFicha();
	$result = $ClsFic->get_motor($cui);
	if(is_array($result)){
		foreach($result as $row){
			$cabeza = utf8_decode($row["mot_cabeza"]);
			$sento = utf8_decode($row["mot_sento"]);
			$camino = utf8_decode($row["mot_camino"]);
			$gateo = utf8_decode($row["mot_gateo"]);
			$gateo = ($gateo == 1)?"Si":"No";
			$balanceo = utf8_decode($row["mot_balanceo"]);
			$balanceo = ($balanceo == 1)?"Si":"No";
			$babeo = utf8_decode($row["mot_babeo"]);
			$babeo = ($babeo == 1)?"Si":"No";
			$actualizo = utf8_decode($row["mot_fecha_actualiza"]);
		}	
	}
	
	if($actualizo != ""){
		$actualizo = cambia_fechaHora($actualizo);
		$actualizado = 'Actualizado el '.$actualizo;
		$pdf->SetTextColor(80, 176, 9);
		$pdf->SetDrawColor(80, 176, 9);
	}else{
		$actualizado = 'No ha actualizado la información';
		$pdf->SetTextColor(204, 138, 58);
		$pdf->SetDrawColor(204, 138, 58);
	}
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(135,$y);
	$pdf->Cell(65,5,$actualizado,1,0,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	
	//-- Información de Lactancia ---//
	$y+=8; //salto de linea para espaciar
	$x = 15;
	//-- Paso 4 ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array(
					'1. ¿A que edad mantuvo firme la cabeza? ',
					'2. ¿A que edad se sentó sin apoyo? ',
					'3. ¿A que edad caminó? ',
					'4. ¿El niño gateo? ',
					'5. ¿Manifestó balanceó corporal con frecuencia? ',
					'6. ¿El niño babeó con exceso? ',
				);
	$pdf->outValues($cabecera,$x,$y,12,185,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($cabeza,$sento,$camino,$gateo,$balanceo,$babeo);
	$pdf->outValues($valores,$x+5,$y+6,12,180,5,"Arial", 10, '', 'B');
	
	/////////////////////////////////////////////////////////--
	$x = 15;
	$y = $pdf->getY();
	$y+=10;
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(60, 5, 'Lenguaje', 'B' , 'L' , '');
	
	$ClsFic = new ClsFicha();
	$result = $ClsFic->get_lenguaje($cui);
	if(is_array($result)){
		foreach($result as $row){
			$dientes = utf8_decode($row["len_dientes"]);
			$balbuceo = utf8_decode($row["len_balbuceo"]);
			$palabras = utf8_decode($row["len_palabras"]);
			$oraciones = utf8_decode($row["len_oraciones"]);
			$articula = utf8_decode($row["len_articula"]);
			$articula = ($articula == 1)?"Si":"No";
			$entiende = utf8_decode($row["len_entiende"]);
			$entiende = ($entiende == 1)?"Si":"No";
			$actualizo = utf8_decode($row["len_fecha_actualiza"]);
		}	
	}
	
	if($actualizo != ""){
		$actualizo = cambia_fechaHora($actualizo);
		$actualizado = 'Actualizado el '.$actualizo;
		$pdf->SetTextColor(80, 176, 9);
		$pdf->SetDrawColor(80, 176, 9);
	}else{
		$actualizado = 'No ha actualizado la información';
		$pdf->SetTextColor(204, 138, 58);
		$pdf->SetDrawColor(204, 138, 58);
	}
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(135,$y);
	$pdf->Cell(65,5,$actualizado,1,0,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	
	//-- Información de Lactancia ---//
	$y+=8; //salto de linea para espaciar
	$x = 15;
	//-- Paso 4 ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array(
					'1. ¿A que edad empezó su dentición? ',
					'2. ¿A que edad empezó a balbucear? ',
					'3. ¿A que edad empezó a decir sus primeras palabras? ',
					'4. ¿A que edad empezó a decir sus primeras oraciones? ',
					'5. ¿El niño articula bien todas las palabras? ',
					'6. ¿Comprende lo que se le dice? ',
				);
	$pdf->outValues($cabecera,$x,$y,12,185,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($dientes,$balbuceo,$palabras,$oraciones,$articula,$entiende);
	$pdf->outValues($valores,$x+5,$y+6,12,180,5,"Arial", 10, '', 'B');
	
	/////////////////////////////////////////////////////////--
	$x = 15;
	$y = $pdf->getY();
	$y+=10;
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(60, 5, 'Sueño', 'B' , 'L' , '');
	
	$ClsFic = new ClsFicha();
	$result = $ClsFic->get_suenio($cui);
	if(is_array($result)){
		foreach($result as $row){
			$duerme = utf8_decode($row["sue_duerme"]);
			$duerme = ($duerme == 1)?"Si":"No";
			$despierta = utf8_decode($row["sue_despierta"]);
			$despierta = ($despierta == 1)?"Si":"No";
			$terror = utf8_decode($row["sue_terror"]);
			$terror = ($terror == 1)?"Si":"No";
			$insomnio = utf8_decode($row["sue_insomnio"]);
			$insomnio = ($insomnio == 1)?"Si":"No";
			$crujido = utf8_decode($row["sue_crujido_dientes"]);
			$crujido = ($crujido == 1)?"Si":"No";
			$horas = utf8_decode($row["sue_horas"]);
			$duerme_con = utf8_decode($row["sue_duerme_con"]);
			$actualizo = utf8_decode($row["sue_fecha_actualiza"]);
		}	
	}
	
	if($actualizo != ""){
		$actualizo = cambia_fechaHora($actualizo);
		$actualizado = 'Actualizado el '.$actualizo;
		$pdf->SetTextColor(80, 176, 9);
		$pdf->SetDrawColor(80, 176, 9);
	}else{
		$actualizado = 'No ha actualizado la información';
		$pdf->SetTextColor(204, 138, 58);
		$pdf->SetDrawColor(204, 138, 58);
	}
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(135,$y);
	$pdf->Cell(65,5,$actualizado,1,0,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	
	//-- Información de Lactancia ---//
	$y+=8; //salto de linea para espaciar
	$x = 15;
	//-- Paso 4 ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array(
					'1. ¿El niño duerme tranquilamente? ',
					'2. ¿Se despierta con frecuencia? ',
					'3. ¿El niño padece de terror nocturno? ',
				);
	$pdf->outValues($cabecera,$x,$y,12,185,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($duerme,$despierta,$terror);
	$pdf->outValues($valores,$x+5,$y+6,12,180,5,"Arial", 10, '', 'B');
	
	////////////_________________ Pagina 4 _________________////////////////////
	
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
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
	
	//-- Paso 4 ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array(
					'4. ¿El niño padece de insomnio?',
					'5. ¿El niño padece de crujir los dientes? ',
					'6. ¿Cuantas horas duerme en la noche? (cantidad de horas) ',
					'7. El niño duerme acompañado ¿con quien? '
				);
	$pdf->outValues($cabecera,$x,$y,12,185,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($insomnio,$crujido,$horas,$duerme_con);
	$pdf->outValues($valores,$x+5,$y+6,12,180,5,"Arial", 10, '', 'B');
	
	/////////////////////////////////////////////////////////--
	$x = 15;
	$y = $pdf->getY();
	$y+=10;
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(60, 5, 'Alimentación', 'B' , 'L' , '');
	
	$ClsFic = new ClsFicha();
	$result = $ClsFic->get_alimentacion($cui);
	if(is_array($result)){
		foreach($result as $row){
			$solo = utf8_decode($row["ali_solo"]);
			$solo = ($solo == 1)?"Si":"No";
			$exceso = utf8_decode($row["ali_exceso"]);
			$exceso = ($exceso == 1)?"Si":"No";
			$poco = utf8_decode($row["ali_poco"]);
			$poco = ($poco == 1)?"Si":"No";
			$obligado = utf8_decode($row["ali_obligado"]);
			$obligado = ($obligado == 1)?"Si":"No";
			$habitos = utf8_decode($row["ali_habitos"]);
			$habitos = ($habitos == 1)?"Si":"No";
			$peso = utf8_decode($row["ali_peso"]);
			$talla = utf8_decode($row["ali_talla"]);
			$actualizo = utf8_decode($row["ali_fecha_actualiza"]);
		}	
	}
	
	if($actualizo != ""){
		$actualizo = cambia_fechaHora($actualizo);
		$actualizado = 'Actualizado el '.$actualizo;
		$pdf->SetTextColor(80, 176, 9);
		$pdf->SetDrawColor(80, 176, 9);
	}else{
		$actualizado = 'No ha actualizado la información';
		$pdf->SetTextColor(204, 138, 58);
		$pdf->SetDrawColor(204, 138, 58);
	}
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(135,$y);
	$pdf->Cell(65,5,$actualizado,1,0,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	
	//-- Información de Lactancia ---//
	$y+=8; //salto de linea para espaciar
	$x = 15;
	//-- Paso 4 ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array(
					'1. ¿El niño come solo? ',
					'2. ¿El niño come en exceso? ',
					'3. ¿El niño come poco? ',
					'4. ¿Al niño lo obligan a comer? ',
					'5. ¿El niño le exigen hábitos en la mesa? ',
					'6. Peso (en libras): ',
					'7. Talla (en metros): '
				);
	$pdf->outValues($cabecera,$x,$y,12,185,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($solo,$exceso,$poco,$obligado,$habitos,$peso,$talla);
	$pdf->outValues($valores,$x+5,$y+6,12,180,5,"Arial", 10, '', 'B');
	
	
	/////////////////////////////////////////////////////////--
	$x = 15;
	$y = $pdf->getY();
	$y+=10;
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(60, 5, 'Vista', 'B' , 'L' , '');
	
	$ClsFic = new ClsFicha();
	$result = $ClsFic->get_vista($cui);
	if(is_array($result)){
		foreach($result as $row){
			$lentes = utf8_decode($row["vis_lentes"]);
			$lentes = ($lentes == 1)?"Si":"No";
			$uso = utf8_decode($row["vis_uso"]);
			if($uso == "F"){
				$uso = "Uso fijo";
			}else if($uso == "L"){
				$uso = "Para Leer";
			}else{
				$uso = "-";
			}
			$irritacion = utf8_decode($row["vis_irritacion"]);
			$irritacion = ($irritacion == 1)?"Si":"No";
			$secrecion = utf8_decode($row["vis_secrecion"]);
			$secrecion = ($secrecion == 1)?"Si":"No";
			$se_acerca = utf8_decode($row["vis_se_acerca"]);
			$se_acerca = ($se_acerca == 1)?"Si":"No";
			$dolor = utf8_decode($row["vis_dolor_cabeza"]);
			$dolor = ($dolor == 1)?"Si":"No";
			$desviacion = utf8_decode($row["vis_desviacion_ocular"]);
			$desviacion = ($desviacion == 1)?"Si":"No";
			$otro = utf8_decode($row["vis_otros"]);
			$actualizo = utf8_decode($row["vis_fecha_actualiza"]);
		}	
	}
	
	if($actualizo != ""){
		$actualizo = cambia_fechaHora($actualizo);
		$actualizado = 'Actualizado el '.$actualizo;
		$pdf->SetTextColor(80, 176, 9);
		$pdf->SetDrawColor(80, 176, 9);
	}else{
		$actualizado = 'No ha actualizado la información';
		$pdf->SetTextColor(204, 138, 58);
		$pdf->SetDrawColor(204, 138, 58);
	}
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(135,$y);
	$pdf->Cell(65,5,$actualizado,1,0,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	
	//-- Información de Lactancia ---//
	$y+=8; //salto de linea para espaciar
	$x = 15;
	//-- Paso 4 ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array(
					'1. ¿El niño usa lentes? ',
					'2. Si usa, ¿para que los usa? ',
					'3. ¿Padece de ojos irritados? ',
					'4. ¿Secreción en los ojos? ',
					'5. ¿Se acerca demasiado al papel? ',
					'6. ¿Padece de dolor de cabeza? ',
					'7. ¿Desviaciones oculares? ',
					'8. ¿Otras afecciones?'
				);
	$pdf->outValues($cabecera,$x,$y,12,185,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($lentes,$uso,$irritacion,$secrecion,$se_acerca,$dolor,$desviacion,$otro);
	$pdf->outValues($valores,$x+5,$y+6,12,180,5,"Arial", 10, '', 'B');
	
	////////////_________________ Pagina 4 _________________////////////////////
	
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
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
	
	/////////////////////////////////////////////////////////--
	$x = 15;
	$y = $pdf->getY();
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(60, 5, 'Oido', 'B' , 'L' , '');
	
	$ClsFic = new ClsFicha();
	$result = $ClsFic->get_oido($cui);
	if(is_array($result)){
		foreach($result as $row){
			$afecciones = utf8_decode($row["oid_afecciones"]);
			$afecciones = ($afecciones == 1)?"Si":"No";
			$cuales = utf8_decode($row["oid_cuales"]);
			$esfuerzo = utf8_decode($row["oid_esfuerzo"]);
			$esfuerzo = ($esfuerzo == 1)?"Si":"No";
			$responde = utf8_decode($row["oid_responde"]);
			$responde = ($responde == 1)?"Si":"No";
			$no_escucha = utf8_decode($row["oid_no_escucha"]);
			$no_escucha = ($no_escucha == 1)?"Si":"No";
			$actualizo = utf8_decode($row["oid_fecha_actualiza"]);
		}	
	}
	
	if($actualizo != ""){
		$actualizo = cambia_fechaHora($actualizo);
		$actualizado = 'Actualizado el '.$actualizo;
		$pdf->SetTextColor(80, 176, 9);
		$pdf->SetDrawColor(80, 176, 9);
	}else{
		$actualizado = 'No ha actualizado la información';
		$pdf->SetTextColor(204, 138, 58);
		$pdf->SetDrawColor(204, 138, 58);
	}
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(135,$y);
	$pdf->Cell(65,5,$actualizado,1,0,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	
	//-- Información de Oido ---//
	$y+=8; //salto de linea para espaciar
	$x = 15;
	//-- Paso 4 ---//
	$pdf->SetLineWidth(0.1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$cabecera = array(
					'1. ¿Afecciones y padecimientos del oído? ',
					'2. ¿Cuales? especifique ',
					'3. ¿Hace esfuerzos para escuchar? ',
					'4. ¿Responde cuando no esta viendo a la persona? ',
					'5. ¿Manifiesta frecuentemente no haber escuchado una orden o instrucción? ',
				);
	$pdf->outValues($cabecera,$x,$y,12,185,5,"Arial", 10, "B");
	//--
	$pdf->SetTextColor(121, 121, 121);
	$pdf->SetDrawColor(121, 121, 121);
	$valores = array($afecciones,$cuales,$esfuerzo,$responde,$no_escucha);
	$pdf->outValues($valores,$x+5,$y+6,12,180,5,"Arial", 10, '', 'B');
	
	/////////////////////////////////////////////////////////--
	$x = 15;
	$y = $pdf->getY();
	$y_img = $pdf->getY();
	$y+=10;
	$pdf->SetLineWidth(0.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(60, 5, 'Caracter', 'B' , 'L' , '');
	
	$ClsFic = new ClsFicha();
	$result = $ClsFic->get_caracter($cui);
	$i = 1;
	$cols = 1;
	$valores_izquierda = array();
	$valores_derecha = array();
	$y_img+=20;
	$x_img = 80;
	if(is_array($result)){
		foreach($result as $row){
			$caracter = trim($row["car_codigo"]);
			$caracter_desc = utf8_decode($row["car_descripcion"]);
			//--
			$result_conducta = $ClsFic->get_conducta_caracter($cui,$caracter);
			if(is_array($result_conducta)){
				$pdf->Image('../../../CONFIG/images/checks/checkbox2.jpg',$x_img,$y_img,8,8);
			}else{
				$pdf->Image('../../../CONFIG/images/checks/checkbox1.jpg',$x_img,$y_img,8,8);
			}
			if($cols == 1){
				$valores_izquierda[$i] = "$i. ".$caracter_desc;
				//checks (img)
				$x_img = 180; /// para la proxima
			}else if($cols == 2){
				$valores_derecha[$i] = "$i. ".$caracter_desc;
				$cols = 0;
				//checks (img)
				$x_img = 80; /// para la proxima vuelta
				$y_img+=10;
			}
			$cols++;
			$i++;
		}
	}
	$i--;
	
	$y+=5;										
	//-- IZQUIERDA ---//
	$x = 15;
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->outValues($valores_izquierda,$x,$y+6,10,90,5,"Arial", 10, '', '');
	
	
	//-- DERECHA ---//
	$x = 110;
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->outValues($valores_derecha,$x,$y+6,10,90,5,"Arial", 10, '', '');
	//----------------//						
	
	
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 180 ,245, 20 , 20,'JPG', '');
	
	$pdf->Output();

?>