<?php
include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["codigo"];
	$arma = $_SESSION["arma"];
	//$_POST
	$pensum = trim($_REQUEST["pensum"]);
	$nivel = trim($_REQUEST["nivel"]);
	$grado = trim($_REQUEST["grado"]);
	$seccion = trim($_REQUEST["seccion"]);
	$materia = trim($_REQUEST["materia"]);
	$unidad = trim($_REQUEST["unidad"]);

	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsNot = new ClsNotas();
	$ClsTar = new ClsTarea();
	$ClsExa = new ClsExamen();
	/// Grado y seccion
	$result = $ClsPen->get_seccion($pensum,$nivel,$grado,$seccion);
	if(is_array($result)){
		foreach($result as $row){
			$grado_desc = utf8_decode($row["gra_descripcion"]);
			$seccion_desc = utf8_decode($row["sec_descripcion"]);
		}
	}

	/// Grado y seccion
	$result = $ClsPen->get_seccion($pensum,$nivel,$grado,$seccion);
	if(is_array($result)){
		foreach($result as $row){
			$grado_desc = utf8_decode($row["gra_descripcion"]);
			$seccion_desc = utf8_decode($row["sec_descripcion"]);
		}
	}

	$result = $ClsPen->get_materia($pensum,$nivel,$grado,$materia);
	if(is_array($result)){
		foreach($result as $row){
			$materia_desc = utf8_decode($row["mat_descripcion"]);
		}
	}

	$pdf=new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical

	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'Reporte de Proceso de Notas (Notas en transcurso)', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, utf8_decode('Fecha/Hora de generación: ').date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por Nombre: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, utf8_decode('Grado y Sección: ').$grado_desc.' '.$seccion_desc, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Materia o Clase: '.$materia_desc, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 315 ,5, 30 , 30, 'JPG', '');


	$pdf->Ln(10);
	////////////////////////////////////// ENCABEZADOS ///////////////////////////////////////////
	$pdf->SetWidths(array(10, 80, 30, 30, 30, 30, 30, 30, 30, 45));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;

	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',10);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
        $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	$pdf->Row(array('No.', 'Alumno', 'Tareas', 'Cortos', 'Trabajo Final','Evaluaciones', 'Actividades', utf8_decode('Evaluación'), 'Total', utf8_decode('Validación')));

	////////////////////////////////////// CUERPO ///////////////////////////////////////////
	$pdf->SetWidths(array(10, 80, 30, 30, 30, 30, 30, 30, 30, 45));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;

	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	$i=1;
	if(is_array($result)){
		foreach($result as $row){
			//CUI
			$cui = $row["alu_cui"];
			//alumno
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			//---
			$zonaTareas = $ClsTar->get_notas_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','Z','1,2');
			$zonaExamen = $ClsExa->get_notas_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','Z','1,2,3');
			$notaTareas = $ClsTar->get_notas_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','E','1,2');
			$notaExamen = $ClsExa->get_notas_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','E','1,2,3');
			///--comprueba si el alumno ya tiene nota, si no da la opcion para grabar.  Si ya tiene nota da la opcion para modificar y se�ala que ya tiene...
			$result_nota_alumno = $ClsNot->comprueba_notas_alumno($cui,$pensum,$nivel,$grado,$materia,$unidad);
			if(is_array($result_nota_alumno)){
				foreach($result_nota_alumno as $row_nota_alumno){
					$zona = $row_nota_alumno["not_zona"];
					$nota = $row_nota_alumno["not_nota"];
					$situacion = $row_nota_alumno["not_situacion"];
					$total = $row_nota_alumno["not_total"];
				}
				$tipo_usuario = $_SESSION['tipo_usuario'];
				if($tipo_usuario == 5 || $tipo_usuario == 1){
					$disabled = "";
				}else{
					$disabled = ($situacion != 1)?"disabled":"";
				}
				$texto = 'Nota Validada';
			}else{
				$zona = '';
				$nota = '';
				$total = '';
				$zonaTareas = $ClsTar->get_notas_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','Z','1,2');
				$zonaExamen = $ClsExa->get_notas_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','Z','1,2,3');
				$zona = $zonaTareas + $zonaExamen;
				$notaTareas = $ClsTar->get_notas_tarea('',$cui,$pensum,$nivel,$grado,'',$materia,$unidad,'','E','1,2');
				$notaExamen = $ClsExa->get_notas_examen('',$cui,$pensum,$nivel,$grado,'',$materia,'',$unidad,'','E','1,2,3');
				$nota = $notaTareas + $notaExamen;
				//--
				$total = '0';
				$texto = 'Pendiente de validar';
			}
			//---
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$pdf->Row(array($no,$nombres,$zonaTareas,$zonaExamen,$notaTareas,$notaExamen,$zona,$nota,$total,$texto)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY
			$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
		}
		$i--;
		////////////////////////////////////// PIE DE REPORTE ///////////////////////////////////////////
		$pdf->SetFont('Arial','B',10);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
		$pdf->SetFillColor(216,216,216);
		$pdf->Cell(345,5,$i.' Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS

	}else{
		$pdf->SetFont('Arial','',8);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
		$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell(345,5,'No se Reportan Datos.',1,'','C',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS

		$y=$pdf->GetY();
		$y+=5;
		// Put the position to the right of the cell
		$pdf->SetXY(5,$y);
		//footer
		$pdf->SetFont('Arial','B',10);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
		$pdf->SetFillColor(216,216,216);
		$pdf->Cell(345,5,'0 Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
	}

	$pdf->Output();

?>
