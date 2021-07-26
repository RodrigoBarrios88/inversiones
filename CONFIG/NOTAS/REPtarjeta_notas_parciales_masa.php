<?php
include_once('html_fns_reportes.php');
require_once ('../../SISTEM/recursos/jpgraph/jpgraph.php');
require_once ('../../SISTEM/recursos/jpgraph/jpgraph_bar.php');
require_once ('../../SISTEM/recursos/jpgraph/jpgraph_line.php');

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
	//--$POST de Configuraci�n
	$acho_cols = $_REQUEST["anchocols2"];
	$fontsize = $_REQUEST["font2"];
	$tipo_papel = $_REQUEST["papel2"];
	$orientacion = $_REQUEST["orientacion2"];
	$titulo = utf8_decode("BOLETA DE RENDIMIENTO ACADÉMICO");
	$nota_minima = $_REQUEST["notaminima2"];
	$caraA = $_REQUEST["caraA2"];
	$caraB = $_REQUEST["caraB2"];
	$observaciones = $_REQUEST["observaciones2"];

	$cant_unidades = ($nivel == 1)?3:4;
	/////////// Valida los porcentajes de cada unidad por si deben variar
	function porcentajes_unidad($unidad,$nivel){
		if($nivel == 1){
			switch($unidad){
				case 1: $porcentaje = 0.333; break;
				case 2: $porcentaje = 0.333; break;
				case 3: $porcentaje = 0.333; break;
				//	case 5: $porcentaje = 0.2; break;
			}
		}else{
			switch($unidad){
				case 1: $porcentaje = 0.25; break;
				case 2: $porcentaje = 0.25; break;
				case 3: $porcentaje = 0.25; break;
				case 4: $porcentaje = 0.25; break;
			//	case 5: $porcentaje = 0.2; break;
			}
		}
		return $porcentaje;
	}

	$ClsAlu = new ClsAlumno();
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsNot = new ClsNotas();

	/////////// Trae el array de secciones disponibles para ese pensum y ese grado con ese tipo de area (civil, militar o deportiva) //////////
	$result_letras = $ClsNot->get_literales();  ////// este array se coloca en la columna de combos
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////// Trae el array de secciones disponibles para ese pensum y ese grado con ese tipo de area (civil, militar o deportiva) //////////
	$result_tipifica = $ClsNot->get_tipificacion();  ////// este array se coloca en la columna de combos
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

	////// Trae las materias a listar en las notas
	$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado,'','1',1);
	if(is_array($result_materias)){
		$mat_count = 1;
		foreach($result_materias as $row_materia){
			//--
			$pensum_desc = utf8_decode($row_seccion["pen_descripcion"]);
			$nivel_desc = utf8_decode($row_seccion["niv_descripcion"]);
			$grado_desc = utf8_decode($row_seccion["gra_descripcion"]);
			//--
			$materia_codigo[$mat_count] = $row_materia["mat_codigo"];
			$materia_descripcion[$mat_count] = utf8_decode($row_materia["mat_descripcion"]);
			//--
			$mat_count++;
		}
		$mat_count--;
	}
	//--

	$pdf=new PDF($orientacion,'mm',$tipo_papel);  // si quieren el reporte horizontal

	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	if(is_array($result)){
		foreach($result as $row){
			//--
			$alumno = $row["alu_cui"];
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$alumno_nombre = $apellido.", ".$nombre;
			$foto = $row["alu_foto"];
			//--

			if($caraA == 1){
				$pdf->AddPage();
				$pdf->SetAutoPageBreak(false,2);
				$pdf->SetMargins(5,5,5);
				$pdf->Ln(1);

				switch($parcial){
					case 1: $num_parcial = "1RA. UNIDAD"; break;
					case 2: $num_parcial = "2DA. UNIDAD"; break;
					case 3: $num_parcial = "3RA. UNIDAD"; break;
					case 4: $num_parcial = "4TA. UNIDAD"; break;
					case 5: $num_parcial = "5TA. UNIDAD"; break;
				}
				$pdf->SetFont('Arial','B',16);
				$pdf->MultiCell(0, 10, $colegio, 0 , 'L' , 0);
				$pdf->SetFont('Arial','B',10);
				$pdf->MultiCell(0, 5, "$titulo / $num_parcial", 0 , 'L' , 0);
				$pdf->Ln(5);
				$pdf->SetFont('Arial','B',10);
				$pdf->MultiCell(0, 5, 'ALUMNO: '.$alumno_nombre, 0 , 'L' , 0);
				$pdf->SetFont('Arial','',10);
				$pdf->MultiCell(0, 5, 'PEI: '.$pensum_desc, 0 , 'L' , 0);
				$pdf->MultiCell(0, 5, 'Nivel: '.$nivel_desc, 0 , 'L' , 0);
				$pdf->MultiCell(0, 5, 'Grado: '.$grado_desc.' '.$seccion_desc, 0 , 'L' , 0);
				$pdf->MultiCell(0, 6, utf8_decode('Fecha/Hora de generación: ').date("d/m/Y H:i"), 0 , 'L' , 0);

				//--- logo
				$x = 0;
				$y = 0;
				$w = 0;
				$h = 0;

				if($tipo_papel == "Letter"){
					if($orientacion == "P"){
						$x = 160;
						$y = 10;
						$w = 45;
						$h = 30;
						$ancho_hoja = 205;
					}else{
						$x = 225;
						$y = 10;
						$w = 45;
						$h = 30;
						$ancho_hoja = 270;
					}
				}else{
					if($orientacion == "P"){
						$x = 160;
						$y = 10;
						$w = 45;
						$h = 30;
						$ancho_hoja = 205;
					}else{
						$x = 300;
						$y = 10;
						$w = 45;
						$h = 30;
						$ancho_hoja = 345;
					}
				}

				///// LOGO ///////
				$pdf->Image('../images/replogo.jpg' , $x+10 ,$y, 40 , 40,'JPG', '');
				//$pdf->Rect($x ,$y, 50 , 40);

				///// FOTO ///////
				if(file_exists ('../Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$pdf->Image('../Fotos/ALUMNOS/'.$foto.'.jpg' , ($x - 30) ,$y, 40 , 40,'JPG', '');
				}else{
					$pdf->Image('../Fotos/nofoto.jpg' , ($x - 30) ,$y, 40 , 40,'JPG', '');
				}

				/// CENTRADO DE ETIQUETA TITULO
				$pdf->Ln(5);
				$pdf->SetFont('Arial','B',11);
				$pdf->MultiCell($acho_hoja, 6, $titulo, 1 , 'C' , 0);


				$pdf->Ln(5);

				////////////////////////////////////// ENCABEZADOS ///////////////////////////////////////////
				$pdf->SetWidths(array(20.5, 123, 20.5, 20.5, 20.5));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;

				// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
				$pdf->SetFont('Arial','B',$fontsize+2);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
				$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

				$pdf->Row(array('No.', 'MATERIA', 'Actividades', 'NOTA', 'TOTAL'));

				////////////////////////////////////// CUERPO ///////////////////////////////////////////
				$pdf->SetWidths(array((20.5), (123), (20.5), (20.5), (20.5)));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('C', 'L', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS
				$pdf->SetFont('Arial','',$fontsize);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
				$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO

				$sumatoria = 0;
				$validas = 0;
				$graph_bajo = 0;
				$graph_medio = 0;
				$graph_alto = 0;
				for($z = 1; $z <= $mat_count; $z++){
					$materia = $materia_descripcion[$z];
					$codigo = $materia_codigo[$z];
					//----
					$result = $ClsNot->get_notas_alumno_tarjeta($alumno,$pensum,$nivel,$grado,$seccion,$materia_codigo[$z],$parcial);
					if(is_array($result)){
						$total = 0;
						foreach($result as $row){
							$calificacion = trim($row["not_tipo_calificacion"]);
							$zona = $row["not_zona"];
							$nota = $row["not_nota"];
						}
						$total = ($zona + $nota);
						if($calificacion == 1){
							$descripcion_zona = $zona;
							$descripcion_nota = $nota;
							$descripcion_total = $total;
						}else if($calificacion == 2){
							$descripcion_zona = '';
							$descripcion_nota = '';
							$descripcion_total = descripcionRangosLetras($result_letras,$total);
						}else if($calificacion == 3){
							$descripcion_zona = '';
							$descripcion_nota = '';
							$descripcion_total = descripcionRangosTipificacion($result_tipifica,$total);
						}
						$sumatoria+= $total;
						$validas++;
						if($total < $nota_minima && $total > 0){
							$rojos++;
							$colores = "199,0,57";
						}else if($total >= $nota_minima && $total < 70){
							$colores = "95,141,227";
						}else{
							$colores = "0,0,0";
						}
						//---
					}else{
						$descripcion_zona = "";
						$descripcion_nota = "";
						$descripcion_total = "";
						$zona = "";
						$nota = "";
						$total = "";
						$colores = "0,0,0";
					}

					$no = $z.".";
					$pdf->Row(array($no,$materia,$descripcion_zona,$descripcion_nota,$descripcion_total),array("0,0,0","0,0,0","0,0,0",$colores)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY

					//grafica de rendimiento
					if($total < 61){
						$graph_bajo++;
					}else if($total > 60 && $total < 70){
						$graph_medio++;
					}else if($total > 70){
						$graph_alto++;
					}
					//--
				}
				$z--;
				/////////////////////////////////////////////////
				/////////////////////////////////////////////////
				$pdf->SetFont('Arial','B',$fontsize);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
				$pdf->SetWidths(array(20.5, 123, 41, 20.5));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('C', 'L', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS
				$arr_pie_det[0] = '';
				$arr_pie_det[1] = 'PROMEDIO (NOTAS VALIDAS)';
				$arr_pie_det[2] = '';
				//echo $par_count;
				$validas = ($validas > 0)?$validas:1;
				$arr_pie_det[3] = number_format(($sumatoria/$validas),2,'.','');
				///--
				// ESTE ES EL PIE DETALLADO DE LA TABLA,
				$pdf->Row($arr_pie_det);

				////////////////////////////////////// PIE DE REPORTE ///////////////////////////////////////////
				$pdf->SetFont('Arial','B',$fontsize);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
				$pdf->SetFillColor(216,216,216);
				$pdf->Cell($ancho_hoja,6,$z.' Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS


				////////////////////////////////////// RECUPERACIONES ///////////////////////////////////////////

				$pdf->Ln(10);
				$pdf->SetFont('Arial','B',10);
				$pdf->MultiCell(205, 5, utf8_decode("Recuperciones:"), 0 , 'L' , 0);

				$Y = $pdf->getY();
				$pdf->Rect(5, $Y, 205, 50);

				////////////////////////////////////// CODO DE PADRES O ENCARGADOS ///////////////////////////////////////////
				/// CENTRADO DE ETIQUETA TITULO
				$pdf->Ln(55);
				$y = $pdf->GetY();
				$pdf->Line( 5, $y, 210, $y);
				$pdf->Image('../images/replogo.jpg' , 191 ,$y+1, 20 , 20,'JPG', '');
				$pdf->Ln(10);
				$pdf->SetFont('Arial','',10);
				$pdf->MultiCell($acho_hoja, 6, "Devuelva este codo firmado al Colegio", 0 , 'C' , 0);
				$pdf->Ln(5);
				$pdf->SetFont('Arial','B',11);
				$pdf->MultiCell($acho_hoja, 6, $_SESSION["colegio_nombre_reporte"], 1 , 'C' , 0);
				///// LOGO ///////

				$pdf->Ln(0);
				$pdf->SetWidths(array((10.25), (82), (41), (72.57)));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;

				// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
				$pdf->SetFont('Arial','B', $fontsize);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
				$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
				$pdf->Row(array('No.', 'PADRE O ENCARGADO', 'PARENTESCO', 'FIRMA'));

				$pdf->SetWidths(array((10.25), (82), (41), (72.57)));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('C', 'L', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS
				$pdf->SetFont('Arial','',$fontsize);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
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
				$pdf->MultiCell($acho_hoja, 6, utf8_decode("Fecha y hora de Impresión ").date("d/m/Y H:i:s"), 0 , 'R' , 0);
			}
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////            PAGAINA 2             //////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			if($caraB == 1){
				$pdf->AddPage();
				$pdf->SetAutoPageBreak(false,2);
				$pdf->SetMargins(5,5,5);
				$pdf->Ln(5);
				$pdf->SetFont('Arial','B',10);
				$pdf->MultiCell(205, 5, utf8_decode("OBSERVACIONES POR UNIDADES:"), 0 , 'L' , 0);

				////////////////////////////////////// OBSERVACIONES ///////////////////////////////////////////
				$pdf->Ln(5);
				$ClsNot = new ClsNotas();
				$result = $ClsNot->get_comentario_alumno($alumno,$pensum,$nivel,$grado,'',$parcial);
				if(is_array($result)){
					$Y = $pdf->getY();
					foreach($result as $row){
						$comentario = utf8_decode($row["comen_comentario"]);
						$usuario = utf8_decode($row["comen_usuario_nombre"]);
						$fechor = cambia_fechaHora($row["comen_fechor"]);
						$unidad = utf8_decode($row["uni_unidad"]);
						//--
						$pdf->SetY($Y);
						$pdf->SetFont('Arial','B',8);
						$nombre_unidad = nombre_unidades($unidad);
						$pdf->MultiCell(205, 5, utf8_decode("Observación $nombre_unidad Unidad:"), 0 , 'L' , 0);
						$Y+=5;
						$pdf->Rect(5, $Y, 205, 25);
						$pdf->setY($Y+1);
						$pdf->SetFont('Arial','',8);
						$pdf->MultiCell(204, 3, $comentario, 0 , 'J' , 0);
						$Y+=30;
					}
				}else{
					$pdf->SetFont('Arial','',8);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->Cell(204,5,'No hay observaciones por el momento.',1,'','C',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
				}
			}/// cara B
		}// foreach
	}

$pdf->Output();

?>
