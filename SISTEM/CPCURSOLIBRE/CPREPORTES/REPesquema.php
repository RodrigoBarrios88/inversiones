<?php

include_once('html_fns_reportes.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$curso = $_REQUEST["curso"];
	//--
	$ClsCur = new ClsCursoLibre();
	$result = $ClsCur->get_curso($curso);
	if(is_array($result)){
		foreach($result as $row){
			$curso = $row["cur_codigo"];
			$nombre_curso = utf8_decode($row["cur_nombre"]);
			$sede = utf8_decode($row["sed_nombre"]);
			$fechas = cambia_fecha($row["cur_fecha_inicio"])." - ".cambia_fecha($row["cur_fecha_fin"]);
		}
	}
	
	$titulo = utf8_decode('DOSIFICACIÓN CURRICULAR DEL CURSO "').$nombre_curso.' ('.$fechas.')".  SEDE: '.$sede.'.';
	
	$pdf=new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, $titulo, 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, utf8_decode('Fecha/Hora de generación: ').date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Empresa: '.$empresa, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 320 ,5, 30 , 30,'JPG', '');
	
	$pdf->Ln(5);
	
	
///////////////////////////////// TEMAS ////////////////////////////////////

	$ClsCur = new ClsCursoLibre();
	$ClsTar = new ClsTarea();
	$ClsExa = new ClsExamen();
	$result = $ClsCur->get_tema($cod,$curso);
	if(is_array($result)){
		$i=1;
		$temnum = 1;	
		foreach($result as $row){
			$tema = $row["tem_codigo"];
			//unidad
			$unidad = utf8_decode($row["tem_unidad"]);
			//cantidad de periodos
			$periodos = trim($row["tem_cantidad_periodos"]);
			//nombre del tema
			$nombre = utf8_decode($row["tem_nombre"]);
			//descripcion
			$desc = utf8_decode($row["tem_descripcion"]);
			//--
			///----- encabezados ---////
			$pdf->SetWidths(array(50, 100, 100, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(28,75,129); // LETRA COLOR AZUL  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('CANTIDAD DE PERIODOS', 'TEMA', utf8_decode('DESCRIPCIÓN'),'','',''));
			}
			$pdf->SetWidths(array(50, 100, 100, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'L', 'J', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(28,75,129); // LETRA COLOR AZUL  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$pdf->Row(array($periodos.' Periodo(s)',$nombre,$desc,'','','')); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			//$pdf->Ln(5);
			$i++;
			/////////////// TAREAS POR TEMA //////////
			$result_tareas = $ClsTar->get_tarea_curso('',$curso,$tema);
			if(is_array($result_tareas)){
				//limpieza
				$unidad = "";
				$nom = "";
				$periodos = "";
				$desc = "";
				///----- encabezados ---////
				$pdf->SetWidths(array(50, 100, 100, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
				$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
				$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
			
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('', 'TAREA (TEMA '.$temnum.')', utf8_decode('DESCRIPCIÓN (TAREA)'),'PUNTEO','FECHA DE ENTREGA','TIPO'));
				}
				$pdf->SetWidths(array(50, 100, 100, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array( 'C', 'L', 'J', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$i++;
				foreach($result_tareas as $row_tarea){
					//nombre
					$nombre = utf8_decode($row_tarea["tar_nombre"]);
					//descripcion
					$desc = utf8_decode($row_tarea["tar_descripcion"]);
					//punteo
					$pondera = trim($row_tarea["tar_ponderacion"]);
					$tipo_pondera = trim($row_tarea["tar_tipo_calificacion"]);
					$tipo_pondera = ($tipo_pondera == "Z")?"Actividades":"AL Evaluaciones";
					//fecha de entreda
					$fecha = utf8_decode($row_tarea["tar_fecha_entrega"]);
					$fecha = cambia_fechaHora($fecha);
					$fecha = substr($fecha, 0, -3);
					//TIPO
					$tipo = utf8_decode($row_tarea["tar_tipo"]);
					$tipo = ($tipo == "OL")?"EN L&Iacute;NEA":"EN CLASE";
					//--
					$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array('',$nombre,$desc,$pondera.'/'.$tipo_pondera,$fecha,$tipo)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					//$pdf->Ln(5);
					$i++;
				}	
			}
			/////////////// ! FIN TAREAS POR TEMA //////////
			/////////////// EXAMENES POR TEMA //////////
			$result_examenes = $ClsExa->get_examen_curso('',$curso,$tema);
			if(is_array($result_examenes)){
				//limpieza
				$unidad = "";
				$nom = "";
				$periodos = "";
				$desc = "";
				
				///----- encabezados ---////
				$pdf->SetWidths(array(50, 100, 100, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
				$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
				$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
			
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('', utf8_decode('EXÁMEN (TEMA '.$temnum.')'), utf8_decode('DESCRIPCIÓN (EXÁMEN)'),'PUNTEO',utf8_decode('FECHA DE EVALUACIÓN'),'TIPO'));
				}
				$pdf->SetWidths(array(50, 100, 100, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('C', 'L', 'J', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$i++;
				foreach($result_examenes as $row_examenes){
					//nombre
					$titulo = utf8_decode($row_examenes["exa_titulo"]);
					//descripcion
					$desc = utf8_decode($row_examenes["exa_descripcion"]);
					//punteo
					$pondera = number_format($row_examenes["exa_ponderacion"],2,'.','');
					$tipo_pondera = trim($row_examenes["exa_tipo_calificacion"]);
					$tipo_pondera = ($tipo_pondera == "Z")?"Actividades":"Evaluacion";
					//fecha de entreda
					$fecha = utf8_decode($row_examenes["exa_fecha_inicio"]);
					$fecha = cambia_fechaHora($fecha);
					$fecha = substr($fecha, 0, -3);
					//TIPO
					$tipo = utf8_decode($row_examenes["exa_tipo"]);
					$tipo = ($tipo == "OL")?"EN L�NEA":"EN CLASE";
					//--
					$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array('',$titulo,$desc,$pondera.'/'.$tipo_pondera,$fecha,$tipo)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					//$pdf->Ln(5);
					$i++;
				}	
			}
			/////////////// ! FIN EXAMENES POR TEMA //////////
			$temnum++;
		}
		
		/////////////// EXAMENES GLOBALES //////////
		$result_examenes = $ClsExa->get_examen_curso('',$curso,0);
		if(is_array($result_examenes)){
			//limpieza
			$unidad = "";
			$nom = "";
			$periodos = "";
			$desc = "";
			///----- encabezados ---////
			$pdf->SetWidths(array(50, 100, 100, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('',utf8_decode('EXAMENES GLOBALES'), utf8_decode('DESCRIPCIÓN (EXÁMEN)'),'PUNTEO',utf8_decode('FECHA DE EVALUACIÓN'),'TIPO'));
			}
			$pdf->SetWidths(array(50, 100, 100, 30, 30, 30));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'L', 'J', 'C', 'C', 'C'));  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$i++;
			foreach($result_examenes as $row_examenes){
				//nombre
				$titulo = utf8_decode($row_examenes["exa_titulo"]);
				//descripcion
				$desc = utf8_decode($row_examenes["exa_descripcion"]);
				//punteo
				$pondera = number_format($row_examenes["exa_ponderacion"],2,'.','');
				$tipo_pondera = trim($row_examenes["exa_tipo_calificacion"]);
				$tipo_pondera = ($tipo_pondera == "Z")?"Actividades":"Evaluacion";
				//fecha de entreda
				$fecha = utf8_decode($row_examenes["exa_fecha_inicio"]);
				$fecha = cambia_fechaHora($fecha);
				$fecha = substr($fecha, 0, -3);
				//TIPO
				$tipo = utf8_decode($row_examenes["exa_tipo"]);
				$tipo = ($tipo == "OL")?"EN L�NEA":"EN CLASE";
				//--
				$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
				$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
				$pdf->Row(array('',$titulo,$desc,$pondera.'/'.$tipo_pondera,$fecha,$tipo)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
				//$pdf->Ln(5);
				$i++;
			}	
		}
		/////////////// ! FIN EXAMENES GLOBALES //////////
	}

	$pdf->Ln(5);
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output("Dosificacion Curricular de Materias.pdf","I");

?>