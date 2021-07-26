<?php
include_once('html_fns_reportes.php');
require_once ('../../recursos/jpgraph/jpgraph.php');
require_once ('../../recursos/jpgraph/jpgraph_bar.php');
require_once ('../../recursos/jpgraph/jpgraph_line.php');

	$usuario = $_SESSION["codigo"];
	$nombre_usu = $_SESSION["nombre"];
	$colegio = $_SESSION["colegio_nombre_reporte"];
	//$_POST
	$pensum = $_REQUEST["pensum2"];
	$nivel = $_REQUEST["nivel2"];
	$grado = $_REQUEST["grado2"];
	$tipo = $_REQUEST["tipo2"];
	$parcial = $_REQUEST["parcial2"];
	$tipo = $_REQUEST["tipo2"];
	$seccion = $_REQUEST["seccion2"];
	$alumno = $_REQUEST["cui2"];
	//--$POST de Configuración
	$acho_cols = $_REQUEST["anchocols2"];
	$fontsize = $_REQUEST["font2"];
	$tipo_papel = $_REQUEST["papel2"];
	$orientacion = $_REQUEST["orientacion2"];
	$titulo = "BOLETA DE RENDIMIENTO ACADÉMICO";
	$nota_minima = $_REQUEST["notaminima2"];
	$caraA = $_REQUEST["caraA2"];
	$caraB = $_REQUEST["caraB2"];
	$observaciones = $_REQUEST["observaciones2"];
	//--
	$cant_unidades = ($nivel == 1)?3:3;
	/////////// Valida los porcentajes de cada unidad por si deben variar
	function porcentajes_unidad($unidad,$nivel){
		switch($unidad){
			case 1: $porcentaje = 0.30; break;
			case 2: $porcentaje = 0.30; break;
			case 3: $porcentaje = 0.40; break;
		}
		return $porcentaje;
	}
	
	$ClsAlu = new ClsAlumno();
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsNot = new ClsNotas();
	
	//////////// Trae las descripciones de Nivel, Grado y Seccion
	$result_seccion = $ClsPen->get_seccion($pensum,$nivel,$grado,$seccion,'',1);
	if(is_array($result_seccion)){
		foreach($result_seccion as $row_seccion){
			//--
			$pensum_desc = utf8_decode($row_seccion["pen_descripcion"]);
			$nivel_desc = utf8_decode($row_seccion["niv_descripcion"]);
			$grado_desc = utf8_decode($row_seccion["gra_descripcion"]);
			$seccion_desc = utf8_decode($row_seccion["sec_descripcion"]);
		}	
	}	
	
	//////////// Trae los nombres y codigos de Materias
		$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado,$materias,'1',1);
			if(is_array($result_materias)){
				$mat_count = 1;
				$par_count = 1;
				foreach($result_materias as $row_materia){
					//--
					$mat_cod = $row_materia["mat_codigo"];
					$materia_codigo[$mat_count] = $row_materia["mat_codigo"];
					$materia_descripcion[$mat_count] = utf8_decode($row_materia["mat_descripcion"]);
					$mat_count++; // trae la cantidad de materias
				}
			}
			$mat_count--; //trae la cantidad total de materias
		//--
	//--
			
	$pdf=new PDF($orientacion,'mm',$tipo_papel);  // si quieren el reporte horizontal
	
	
if($caraA == 1){
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(1);
	
	$result_alumno = $ClsAlu->get_alumno($alumno);
	if(is_array($result_alumno)){
		foreach($result_alumno as $row){
			$alumno = $row["alu_cui"];
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$alumno_nombre = $apellido.", ".$nombre;
			//--
			$foto = $row["alu_foto"];
		}
	}

	$pdf->SetFont('Arial','B',16);
	$pdf->MultiCell(0, 10, $colegio, 0 , 'L' , 0);
	$pdf->SetFont('Arial','B',10);
	$pdf->MultiCell(0, 5, $titulo, 0 , 'L' , 0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->MultiCell(0, 5, 'ALUMNO: '.$alumno_nombre, 0 , 'L' , 0);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0, 5, 'PEI: '.$pensum_desc, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Nivel: '.$nivel_desc, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Grado: '.$grado_desc.' '.$seccion_desc, 0 , 'L' , 0);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	
	//--- logo
	$x = 0;
	$y = 0;
	$w = 0;
	$h = 0;
	
	if($tipo_papel == "Letter"){
		if($orientacion == "P"){
			$x = 170;
			$y = 10;
			$w = 45;
			$h = 30;
			$ancho_hoja = 205;
		}else{
			$x = 235;
			$y = 10;
			$w = 45;
			$h = 30;
			$ancho_hoja = 270;
		}
	}else{
		if($orientacion == "P"){
			$x = 170;
			$y = 10;
			$w = 45;
			$h = 30;
			$ancho_hoja = 205;
		}else{
			$x = 310;
			$y = 10;
			$w = 45;
			$h = 30;
			$ancho_hoja = 345;
		}
	}
	
	///// LOGO ///////
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , $x ,$y, 40 , 40,'JPG', '');
	//$pdf->Rect($x ,$y, 50 , 40);
	
	///// FOTO ///////
	if(file_exists ('../../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
		$pdf->Image('../../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg' , ($x - 40) ,$y, 40 , 40,'JPG', '');
		//$pdf->Rect(($x - 40) ,$y, 40 , 40);
	}else{
		$pdf->Image('../../../CONFIG/Fotos/nofoto.jpg' , ($x - 40) ,$y, 40 , 40,'JPG', '');
	}
	
	/// CENTRADO DE ETIQUETA TITULO
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell($acho_hoja, 6, $titulo, 1 , 'C' , 0);

	
	$pdf->Ln(5);
	
	////////////////////////////////////// TABLA DE NOTAS ///////////////////////////////////////////
	/////////////////---------------------COLUMNAS DE ENCABEZADOS PRINCIPALES------------------//////////////
	if($nivel == 1){
    	$pdf->SetWidths(array(10, 77, 26,26,26, 20,20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
    	$pdf->SetAligns(array('C', 'C', 'C','C','C', 'C','C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
    	$pdf->SetFont('Arial','B',$fontsize);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
    	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
    	$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
    	//-- Encabezados de detalles
    		$arr_encabezado_det[0] = '';
    		$arr_encabezado_det[1] = '';
    		$arr_encabezado_det[2] = 'PERIODO 1';
    		$arr_encabezado_det[3] = 'PERIODO 2';
    		$arr_encabezado_det[4] = 'PERIODO 3';
    		$arr_encabezado_det[5] = '';
    		$arr_encabezado_det[6] = '';
    		$pdf->Row($arr_encabezado_det);
    	///--
    	//-- Encabezados de detalles
    		$arr_encabezado_det[0] = 'No.';
    		$arr_encabezado_det[1] = 'MATERIA';
    		$arr_encabezado_det[2] = '30%';
    		$arr_encabezado_det[3] = '30%';
    		$arr_encabezado_det[4] = '40%';
    		$arr_encabezado_det[5] = 'ACUMULADO';
    		$arr_encabezado_det[6] = 'NOTA PROM.';
			$pdf->Row($arr_encabezado_det);
		///--
	}else{
		$pdf->SetWidths(array(10, 77, 26,26,26, 20,20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
    	$pdf->SetAligns(array('C', 'C', 'C','C','C', 'C','C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
    	$pdf->SetFont('Arial','B',$fontsize);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
    	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
    	$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
    	//-- Encabezados de detalles
    		$arr_encabezado_det[0] = '';
    		$arr_encabezado_det[1] = '';
    		$arr_encabezado_det[2] = 'PERIODO 1';
    		$arr_encabezado_det[3] = 'PERIODO 2';
    		$arr_encabezado_det[4] = 'PERIODO 3';
    		$arr_encabezado_det[5] = '';
    		$arr_encabezado_det[6] = '';
    		$pdf->Row($arr_encabezado_det);
    	///--
    	//-- Encabezados de detalles
    		$arr_encabezado_det[0] = 'No.';
    		$arr_encabezado_det[1] = 'MATERIA';
    		$arr_encabezado_det[2] = '30%';
			$arr_encabezado_det[3] = '30%';
			$arr_encabezado_det[4] = '40%';
    		$arr_encabezado_det[5] = 'ACUMULADO';
    		$arr_encabezado_det[6] = 'NOTA PROM.';
			$pdf->Row($arr_encabezado_det);
		///--
	}	
	

	////////////////////////////////////// CUERPO ///////////////////////////////////////////
	if($nivel == 1){
		$pdf->SetWidths(array(10, 77, 13,13,13,13,13,13, 20,20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		$pdf->SetAligns(array('C', 'L', 'C','C','C','C','C','C','C','C', 'C','C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	}else{
		$pdf->SetWidths(array(10, 77, 13,13,13,13,13,13, 20,20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		$pdf->SetAligns(array('C', 'L', 'C','C','C','C','C','C','C','C', 'C','C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	}
	
	$pdf->SetFont('Arial','',$fontsize);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
	$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
	$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
	$promedios_unidad = array();
	$graph_bajo = 0;
	$graph_medio = 0;
	$graph_alto = 0;
	$riesgo_bajo = 0;
	$riesgo_medio = 0;
	$riesgo_alto = 0;
	for($z = 1; $z <= $mat_count; $z++){
		$nombre_materia = $materia_descripcion[$z];
		$materia = $materia_codigo[$z];
		//-- Datos
		$arr_datos[0] = $z.'.';
		$arr_datos[1] = $nombre_materia;
		$cols = 2;
		//--
		$rojos = 0;
		$rojos_total = 0;
		$pendientes = 0;
		$total = 0;
		$total_porcentuado = 0;
		$nota_porcentuada = 0;
		$notas_validas = 1;
		$columna = 0;
		$materiaX = "-";
		for($parcial = 1; $parcial <= $cant_unidades; $parcial++){
			$materia = $materia_codigo[$z];
			if(($materia != "0") && ($materia != "NULL") && ($materia != $materiaX)){
				//echo " - diferentes $materia - $materiaX; ";
				$materiaX = $materia;
				$columna++;
			}
			//echo "<br>";
			///// consulta las notas del alumno en ese parcial para esa materia
			$result = $ClsNot->get_notas_alumno_tarjeta($alumno,$pensum,$nivel,$grado,$seccion,$materia,$parcial);
			if(is_array($result)){
				$punteo = 0;
				foreach($result as $row_notas){
					$zona = $row_notas["not_zona"];
					$nota = $row_notas["not_nota"];
					$punteo = $row_notas["not_total"];
					$porcent = porcentajes_unidad($parcial,$nivel);
					$porcentaje = ($porcent * $punteo);
					$porcentaje = number_format($porcentaje, 0, '.', '');
					$nota_porcentuada+= $porcentaje;
					$promedios_unidad[$parcial]+= $punteo;
					$arr_datos[$cols] = $punteo;
					$cols++;
					$arr_datos[$cols] = $porcentaje;
					$total+= $punteo;
					if($punteo < $nota_minima && $punteo > 0){
						$rojos++;
						$arr_colores[$cols-2] = "199,0,57";
					}else if($punteo >= $nota_minima && $punteo < 70){
						$arr_colores[$cols-2] = "0,0,0"; //azul "95,141,227";
					}else{
						$arr_colores[$cols-2] = "0,0,0";
					}
					$notas_validas++;
				}
			}else{
				$promedios_unidad[$parcial]+= 0;
				$arr_datos[$cols] = "";
				$arr_colores[$cols-2] = "0,0,0";
				$cols++;
				$arr_datos[$cols] = "0";
				$pendientes++;
			}
			$cols++;
		}
		$notas_validas--;
		if($total > 0){
			$promedio = ($total/$cant_unidades); /// promedio difiere del acumulado
			$promedio_riesgo = ($total/$notas_validas);
		}else{
			$promedio = 0.00;
			$promedio_riesgo = 0.00;
		}
		$arr_datos[$cols] = number_format($nota_porcentuada, 0, '.', '');
		$arr_datos[$cols+1] = number_format($nota_porcentuada, 0, '.', '');
		//--
		//echo $nota_porcentuada;
		$promedios_unidad[$cant_unidades+1]+= $nota_porcentuada;
		if($nota_porcentuada < $nota_minima && $nota_porcentuada > 0){
			$arr_colores[$cols] = "199,0,57";
		}else if($nota_porcentuada >= $nota_minima && $nota_porcentuada < 70){
			$arr_colores[$cols] = "0,0,0"; //azul "95,141,227";
		}else{
			$arr_colores[$cols] = "0,0,0";
		}
		$promedios_unidad[$cant_unidades+2]+= $promedio;
		if($promedio < $nota_minima && $promedio > 0){
			$arr_colores[$cols+1] = "199,0,57";
		}else if($promedio >= $nota_minima && $promedio < 70){
			$arr_colores[$cols+1] = "0,0,0"; //azul "95,141,227";
		}else{
			$arr_colores[$cols+1] = "0,0,0";
		}
		//--
		//grafica de rendimiento
		if($nota_porcentuada < $nota_minima){
			$graph_bajo++;
		}else if($nota_porcentuada >= $nota_minima && $nota_porcentuada < 70){
			$graph_medio++;
		}else if($nota_porcentuada > 70){
			$graph_alto++;
		}
		//--
		//grafica de riesgo
		if($promedio_riesgo < $nota_minima){
			$riesgo_bajo++;
		}else if($promedio_riesgo >= $nota_minima && $promedio_riesgo < 70){
			$riesgo_medio++;
		}else if($promedio_riesgo > 70){
			$riesgo_alto++;
		}
		//--
		$num++;
		
		$pdf->Row($arr_datos,$arr_colores); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY
		$i++;// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
		//break;
	
	}
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	if($nivel == 1){
		$pdf->SetWidths(array(10, 77, 26,26,26, 20,20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		$pdf->SetAligns(array('C', 'L', 'C','C','C', 'C','C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	}else{
		$pdf->SetWidths(array(10, 77, 26,26,26, 20,20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		$pdf->SetAligns(array('C', 'L', 'C','C','C', 'C','C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	}
	$pdf->SetFont('Arial','B',$fontsize);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
		$arr_pie_det[0] = '';
		$arr_pie_det[1] = 'PROMEDIO';
		//echo $par_count;
		$x = 2;
		for($z = 1; $z <= $cant_unidades; $z++){
			$arr_pie_det[$x] = round(($promedios_unidad[$z]/$mat_count),2);
			$x++;
		}
		$arr_pie_det[$x] = round(($promedios_unidad[$cant_unidades+1]/$mat_count),2);
		$arr_pie_det[$x+1] = round(($promedios_unidad[$cant_unidades+2]/$mat_count),2);
		///--
		// ESTE ES EL PIE DETALLADO DE LA TABLA, 
		$pdf->Row($arr_pie_det);
		
		
		
	////////////////////////////////////// OBSERVACIONES ///////////////////////////////////////////
		$ClsNot = new ClsNotas();
		$result = $ClsNot->get_comentario_alumno($alumno,$pensum,$nivel,$grado,'','');
		if(is_array($result)){
			foreach($result as $row){
				$comentario = utf8_decode($row["comen_comentario"]);
				$usuario = utf8_decode($row["comen_usuario_nombre"]);
				$fechor = cambia_fechaHora($row["comen_fechor"]);
			}
		}
	
	
		$pdf->Ln(10);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(205, 5, trim("Últimas observaciones:"), 0 , 'L' , 0);
		
		$Y = $pdf->getY();
		$pdf->Rect(5, $Y, 205, 25);
		
		$pdf->setY($Y+1);
		$pdf->SetFont('Arial','',8);
		$pdf->MultiCell(204, 3, $comentario, 0 , 'J' , 0);
		
	////////////////////////////////////// CODO DE PADRES O ENCARGADOS ///////////////////////////////////////////
	/// CENTRADO DE ETIQUETA TITULO
	$pdf->Ln(25);
	$y = $pdf->GetY();
	$pdf->Line( 5, $y, 210, $y);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 195 ,$y+1, 15 , 15,'JPG', '');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell($acho_hoja, 6, "Devuelva este codo firmado al Colegio", 0 , 'C' , 0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell($acho_hoja, 6, $_SESSION["colegio_nombre_reporte"], 1 , 'C' , 0);
	///// LOGO ///////
	
	$pdf->Ln(0);
		$pdf->SetWidths(array((10.25), (82), (41), (72.57)));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		
		// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
		$pdf->SetFont('Arial','B', $fontsize);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
		$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
	
		for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE ESTA TABLA, 
			$pdf->Row(array('No.', 'PADRE O ENCARGADO', 'PARENTESCO', 'FIRMA'));
		}
		$pdf->SetWidths(array((10.25), (82), (41), (72.57)));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		$pdf->SetAligns(array('C', 'L', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS
		$pdf->SetFont('Arial','',$fontsize);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
		$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
	
		$ClsAsig = new ClsAsignacion();
		$result_padres = $ClsAsig->get_alumno_padre('',$alumno);
		if(is_array($result_padres)){
			$cont = 1;
			foreach($result_padres as $row_padres){
				$dpi = $row_padres["pad_cui"];
				if($dpi != 0){
					$nom = utf8_decode($row_padres["pad_nombre"]);
					$ape = utf8_decode($row_padres["pad_apellido"]);
					$nombres_padre = "$nom $ape";
					$parentesco = trim($row_padres["pad_mail"]);
					switch($parentesco){
						case 'M': $parentesco = "Madre"; break;
						case 'P': $parentesco = "Padre"; break;
						default: $parentesco = "Encargado(a)";
					}
					
				}else{
					$dpi = "-";
					$nombres_padre = "PENDIENTE DE ACTUALIZAR";
					$mail = "-";
					$telefono = "-";
				}
				$no = $cont.".";
				$pdf->Row(array($no,$nombres_padre,$parentesco,'')); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY
				$cont++;
			}
		}
		
	/////_____________
	$pdf->Ln(1);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell($acho_hoja, 6, "Fecha y hora de Impresión ".date("d/m/Y H:i:s"), 0 , 'R' , 0);
}	
	
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////            PAGAINA 2             //////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if($caraB == 1){
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(10);
	
	$posicion_X = 30;
	$posicion_Y = 30;
	$ancho_grafica = 100;
	////////////////////
		$cont = 0;
		$position1 = 0;
		$position2 = 0;
		$result = $ClsNot->get_promedios_seccion($pensum,$nivel,$grado,$seccion,'');
		//print_r($result);
		if(is_array($result)){
		    $position1 = 10;
		    $position2 = 10;
			foreach($result as $row){
				$notcui = trim($row["not_alumno"]);
				$data1y[$cont] = trim($row["nota_promedio"]);
				if($alumno == $notcui){
					$array_color[$cont] = "#3E7CB2";
					$labels[$cont] = $nombre;
					$puesto_clase = $cont+1;
				}else{
					$array_color[$cont] = "#5DABBF";
					$labels[$cont] = '';
				}
				//---
				$promedio_alumno = trim($row["nota_promedio"]);
				$total_materias = trim($row["notas_conteo"]);
				$cont++;
				$position1+=10;
				$position2+=10;
			}
			
			////////////////---- DESCRIPCIONES -----////////////////////
			$Y = $pdf->GetY();
			$pdf->SetFont('Arial','',6);
			$pdf->SetXY(10,$Y);
			$pdf->Cell(40, 3, "PUESTO EN CLASE: ", 1, 0);
			$pdf->SetFont('Arial','B',6);
			$pdf->SetXY(50,$Y);
			$pdf->Cell(35, 3, "$puesto_clase DE $cont ALUMNOS (CON NOTAS VALIDAS)", 'B', 0);
			//--
			$pdf->SetFont('Arial','',6);
			$pdf->SetXY(10,$Y + 3);
			$pdf->Cell(40, 3, "PROMEDIO CONCRETO: ", 1, 0);
			$pdf->SetFont('Arial','B',6);
			$pdf->SetXY(50,$Y + 3);
			$pdf->Cell(35, 3, number_format($promedio_alumno,0,'.',''), 'B', 0);
			//--
			$pdf->SetFont('Arial','',6);
			$pdf->SetXY(10,$Y + 6);
			$pdf->Cell(40, 3, "MATERIAS CALIFICADAS: ", 1, 0);
			$pdf->SetFont('Arial','B',6);
			$pdf->SetXY(50, $Y + 6);
			$pdf->Cell(35, 3, $total_materias." en $cant_unidades Unidades", 'B', 0);
			
			/////////////////___________________________________________
			//////////////////////// GRAFICA 1 //////////////////////
			if($cont >= 2){ //valida la cantidad minima de registros para graficar
				$pdf->Ln(10);
				// Create the graph. These two calls are always required
				$graph = new Graph(350,200,'auto');
				$graph->SetScale("textlin");
				$theme_class = new UniversalTheme;
				$graph->SetTheme($theme_class);
				
				//$graph->yaxis->SetTickPositions(array(0,100));
				$graph->SetBox(false);
				
				$graph->ygrid->SetFill(false);
				$graph->xaxis->SetTickLabels($labels);
				$graph->yaxis->HideLine(false);
				$graph->yaxis->HideTicks(false,false);
				
				// Create the bar plots
				$b1plot = new BarPlot($data1y);
				
				// Create the grouped bar plot
				$gbplot = new GroupBarPlot(array($b1plot));
				// ...and add it to the graPH
				$graph->Add($gbplot);
				
				$b1plot->SetColor("white");
				$b1plot->SetFillColor($array_color);
				
				$graph->title->Set("Posición del Alumno en su grupo");
				
				// Display the graph
				$nombreImagen = 'temp/' . uniqid() . '.png';
					 
				// Display the graph
				$graph->Stroke($nombreImagen);
					   
				//Aqui agrego la imagen que acabo de crear con jpgraph
				$pdf->Image($nombreImagen, 5 , $posicion_Y , $ancho_grafica , 50);
				//$posicion_Y+= 70;		
				unlink($nombreImagen);
				
			}else{
				$pdf->SetFont('Arial','',6);
				$pdf->MultiCell($acho_hoja, 6, "No hay notas suficientes para crear la gráfica de posición del alumno en su grupo", 1 , 'C' , 0);
				$pdf->Ln(20);
			}
		}else{
			$pdf->SetFont('Arial','',6);
			$pdf->MultiCell($acho_hoja, 6, "No hay notas suficientes para crear la estadistica de posición del alumno en su grupo", 1 , 'C' , 0);
			$pdf->Ln(20);
		}
		
		//////////////////////// GRAFICA 2 //////////////////////		
    	// Create the graph. These two calls are always required
    	$graph = new Graph(350,200,'auto');
    	$graph->SetScale("textlin");
    	$theme_class = new UniversalTheme;
    	$graph->SetTheme($theme_class);
    	
    	$graph->yaxis->SetTickPositions(array(0,0,0));
    	$graph->SetBox(false);
		
		if($caraA != 1 && $caraB == 1){
			$arrdata = data_grafica_riesgo($alumno,$pensum,$nivel,$grado,$seccion,$materia_codigo,$mat_count,$cant_unidades,$nota_minima);
			$riesgo_bajo = $arrdata["bajo"];
			$riesgo_medio = $arrdata["medio"];
			$riesgo_alto = $arrdata["alto"];
		}
    	
    	$graph->ygrid->SetFill(false);
    	$graph->xaxis->SetTickLabels(array("Reprobadas $riesgo_bajo","En riesgo $riesgo_medio","Aprobadas $riesgo_alto"));
    	$graph->yaxis->HideLine(false);
    	$graph->yaxis->HideTicks(false,false);
    	
    	// Create the bar plots
    	$b1plot = new BarPlot(array($riesgo_bajo,$riesgo_medio,$riesgo_alto));
		//$b1plot = new BarPlot(array(8,4,0));
    	
    	// Create the grouped bar plot
    	$gbplot = new GroupBarPlot(array($b1plot));
    	// ...and add it to the graPH
    	$graph->Add($gbplot);
    	
    	$b1plot->SetColor("white");
    	$b1plot->SetFillColor(array("#891B1B","#AAAAAA","#3E7CB2"));
    	
    	$graph->title->Set("Análisis de Promedios Acumulados");
    	
    	// Display the graph
    	$nombreImagen = 'temp/' . uniqid() . '.png';
    		 
    	// Display the graph
    	$graph->Stroke($nombreImagen);
    		   
    	//Aqui agrego la imagen que acabo de crear con jpgraph
    	$pdf->Image($nombreImagen, 110 , $posicion_Y , $ancho_grafica , 50);
    	
    	unlink($nombreImagen);
    	$posicion_Y+= 55;	
		
		//////////////////////// GRAFICA 3 //////////////////////
		////////////////////
		$dataline[0] = 0;
		//U1
		$result = $ClsNot->get_promedios_alumno($pensum,$nivel,$grado,$alumno,1);
		if(is_array($result)){
		    foreach($result as $row){
				$dataline[1] = trim($row["nota_promedio"]);
			}
		}else{
			$dataline[1] = 0;
		}
		//U2
		$result = $ClsNot->get_promedios_alumno($pensum,$nivel,$grado,$alumno,2);
		if(is_array($result)){
		    foreach($result as $row){
				$dataline[2] = trim($row["nota_promedio"]);
			}
		}else{
			$dataline[2] = 0;
		}
		//U3
		$result = $ClsNot->get_promedios_alumno($pensum,$nivel,$grado,$alumno,3);
		if(is_array($result)){
		    foreach($result as $row){
				$dataline[3] = trim($row["nota_promedio"]);
			}
		}else{
			$dataline[3] = 0;
		}
		
		if($nivel != 1){ /// NIVEL 1 solo tiene 3 unidades
			//U4
			$result = $ClsNot->get_promedios_alumno($pensum,$nivel,$grado,$alumno,4);
			if(is_array($result)){
				foreach($result as $row){
					$dataline[4] = trim($row["nota_promedio"]);
				}
			}else{
				$dataline[4] = 0;
			}
		}
				
    	// Create the graph. These two calls are always required
    	$graph = new Graph(700,550);
    	$graph->SetScale("textlin");
    	$theme_class=new UniversalTheme;
    	$graph->SetTheme($theme_class);
    	$graph->img->SetAntiAliasing(false);
    	$graph->title->Set('Representación Gráfica de las Medias por Unidad');
    	$graph->SetBox(false);
    	$graph->img->SetAntiAliasing();
    
    	$graph->yaxis->HideZeroLabel();
    	$graph->yaxis->HideLine(false);
    	$graph->yaxis->HideTicks(false,false);
    	
    	$graph->xgrid->Show();
    	$graph->xgrid->SetLineStyle("solid");
		if($nivel == 1){
			$graph->xaxis->SetTickLabels(array('INICIO','PERIODO 1','PERIODO 2','PERIODO 3'));
		}else{
			$graph->xaxis->SetTickLabels(array('INICIO','PERIODO 1','PERIODO 2','PERIODO 3'));
		}
    	$graph->xgrid->SetColor('#E3E3E3');
    
    	$graph->yaxis->HideLine(false);
    	$graph->yaxis->HideTicks(false,false);
    	
    	// Create the first line
    	$p1 = new LinePlot($dataline);
    	$graph->Add($p1);
    	$p1->SetColor("#B22222");
    	$p1->SetLegend(('Notas por Unidad'));
    	
    	$graph->legend->SetFrameWeight(1);
    	
    	// Display the graph
    	$nombreImagen = 'temp/' . uniqid() . '.png';
    		 
    	// Display the graph
    	$graph->Stroke($nombreImagen);
    		   
    	//Aqui agrego la imagen que acabo de crear con jpgraph
    	$pdf->Image($nombreImagen, 50 , $posicion_Y , 120 , 90);
		$posicion_Y+=90;
		unlink($nombreImagen);
		
    	
}		

	$pdf->Output();
	
function data_grafica_riesgo($alumno,$pensum,$nivel,$grado,$seccion,$materia_codigo,$mat_count,$cant_unidades,$nota_minima){
	$ClsAlu = new ClsAlumno();
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsNot = new ClsNotas();
	
	//echo "Parametros: $alumno,$pensum,$nivel,$grado,$seccion,$mat_count,$cant_unidades,$nota_minima<br><br>";
	
	$promedios_unidad = array();
	$riesgo_bajo = 0;
	$riesgo_medio = 0;
	$riesgo_alto = 0;
	for($z = 1; $z <= $mat_count; $z++){
		$pendientes = 0;
		$total = 0;
		$notas_validas = 1;
		$columna = 0;
		$materiaX = "-";
		for($parcial = 1; $parcial <= $cant_unidades; $parcial++){
			$materia = $materia_codigo[$z];
			if(($materia != "0") && ($materia != "NULL") && ($materia != $materiaX)){
				//echo " - diferentes $materia - $materiaX; ";
				$materiaX = $materia;
				$columna++;
			}
			///// consulta las notas del alumno en ese parcial para esa materia
			$result = $ClsNot->get_notas_alumno_tarjeta($alumno,$pensum,$nivel,$grado,$seccion,$materia,$parcial);
			if(is_array($result)){
				$punteo = 0;
				foreach($result as $row_notas){
					$zona = $row_notas["not_zona"];
					$nota = $row_notas["not_nota"];
					$punteo = ($zona + $nota);
					$total+= $punteo;
					$notas_validas++;
				}
			}else{
				$punteo = 0;
				$pendientes++;
			}
		}
		$notas_validas--;
		if($total > 0){
			$promedio_riesgo = ($total/$notas_validas);
		}else{
			$promedio_riesgo = 0.00;
		}
		//grafica de riesgo
		if($promedio_riesgo < $nota_minima){
			$riesgo_bajo++;
		}else if($promedio_riesgo >= $nota_minima && $promedio_riesgo < 70){
			$riesgo_medio++;
		}else if($promedio_riesgo > 70){
			$riesgo_alto++;
		}
		//--
		//echo " ($total/$notas_validas) = $promedio_riesgo <br> $promedio_riesgo - $nota_minima <br><br>";
	}
	return $arrdata = array("bajo"=>$riesgo_bajo,"medio"=>$riesgo_medio,"alto"=>$riesgo_alto);
}

?>