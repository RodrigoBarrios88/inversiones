<?php
//Incluir las librerias de FPDF 
include_once('../../html_fns.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$pensum = $_REQUEST["pensum"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$materia = $_REQUEST["materia"];
	$unidad = $_REQUEST["unidad"];
	//--
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion);
	if(is_array($result)){
		foreach($result as $row){
			$grado_desc = utf8_decode($row["gra_descripcion"]);
			$seccion_desc = utf8_decode($row["sec_descripcion"]);
		}
	}
	
	$result = $ClsPen->get_materia($pensum,$nivel,$grado,$materia);
	if(is_array($result)){
		foreach($result as $row){
			$materia_desc = $row["mat_descripcion"];
		}
	}
	
	$titulo = utf8_decode("Dosificación Curricular de $materia_desc) para $grado_desc Sección $seccion_desc");
	
	$pdf = new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, $titulo, 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, utf8_decode('Fecha/Hora de generación: ').date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 320 ,5, 30 , 30,'JPG', '');
	
	$pdf->Ln(10);
	
	
///////////////////////////////// TEMAS ////////////////////////////////////

	$ClsAcad = new ClsAcademico();
	$ClsTar = new ClsTarea();
	$ClsExa = new ClsExamen();
	$result = $ClsAcad->get_tema('',$pensum,$nivel,$grado,$seccion,$materia,$unidad);
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
			$pdf->SetWidths(array(25, 25, 100, 105, 30, 30, 30));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÓO
			$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(28,75,129); // LETRA COLOR AZUL  // AQUI LE DOY COLOR AL TEXTO
		
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('UNIDAD', 'PERIODOS', 'TEMA', utf8_decode('DESCRIPCIÓN'),'','',''));
			}
			$pdf->SetWidths(array(25, 25, 100, 105, 30, 30, 30));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'L', 'J', 'C', 'C', 'C'));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetFont('Arial','B',8);   // ASIGNO EL TIPO Y TAMAÓO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(28,75,129); // LETRA COLOR AZUL  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$pdf->Row(array($unidad.' Unidad',$periodos.' Periodo(s)',$nombre,$desc,'','','')); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			//$pdf->Ln(5);
			$i++;
			/////////////// TAREAS POR TEMA //////////
			$result_tareas = $ClsTar->get_tarea('','','','','','','','',$tema);
			if(is_array($result_tareas)){
				//limpieza
				$unidad = "";
				$nom = "";
				$periodos = "";
				$desc = "";
				///----- encabezados ---////
				$pdf->SetWidths(array(25, 25, 205, 30, 30, 30,));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				
				// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
				$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÓO
				$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
			
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('', 'TAREA (TEMA '.$temnum.')', utf8_decode('DESCRIPCIÓN (TAREA)'),'PUNTEO','FECHA DE ENTREGA','TIPO'));
				}
				$pdf->SetWidths(array(25, 25, 205, 30, 30, 30,));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array( 'C', 'L', 'J', 'C', 'C', 'C'));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
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
					$tipo = trim($row_tarea["tar_tipo"]);
					$tipo = ($tipo == "OL")?"EN LÍNEA":"EN CLASE";
					//--
					$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÓO DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array('',$nombre,$desc,$pondera.'/'.$tipo_pondera,$fecha,utf8_decode($tipo))); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					//$pdf->Ln(5);
					$i++;
				}	
			}
			/////////////// ! FIN TAREAS POR TEMA //////////
			/////////////// EXAMENES POR TEMA //////////
			$result_examenes = $ClsExa->get_examen('','','','','','','','',$tema);
			if(is_array($result_examenes)){
				//limpieza
				$unidad = "";
				$nom = "";
				$periodos = "";
				$desc = "";
				
				///----- encabezados ---////
				$pdf->SetWidths(array(50, 100, 105, 30, 30, 30));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
				$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÓO
				$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
			
				for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
					$pdf->Row(array('', 'EXÁMEN (TEMA '.$temnum.')', utf8_decode('DESCRIPCIÓN (EXÁMEN)'),'PUNTEO',utf8_decode(utf8_decode('FECHA DE EVALUACIÓN')),'TIPO'));
				}
				$pdf->SetWidths(array(50, 100, 105, 30, 30, 30));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns(array('C', 'L', 'J', 'C', 'C', 'C'));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$i++;
				foreach($result_examenes as $row_examenes){
					//nombre
					$titulo = utf8_decode($row_examenes["exa_titulo"]);
					//descripcion
					$desc = utf8_decode($row_examenes["exa_descripcion"]);
					//punteo
					$pondera = number_format($row_examenes["exa_ponderacion"],2,'.','');
					$tipo_pondera = trim($row_examenes["exa_tipo_calificacion"]);
					$tipo_pondera = ($tipo_pondera == "Z")?"Actividades":utf8_decode("Evaluación");
					//fecha de entreda
					$fecha = utf8_decode($row_examenes["exa_fecha_inicio"]);
					$fecha = cambia_fechaHora($fecha);
					$fecha = substr($fecha, 0, -3);
					//TIPO
					$tipo = trim($row_examenes["exa_tipo"]);
					$tipo = ($tipo == "OL")?"EN LÍNEA":"EN CLASE";
					//--
					$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÓO DE LA LETRA
					$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
					$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
					$no = $i.".";
					$pdf->Row(array('',$titulo,$desc,$pondera.'/'.$tipo_pondera,$fecha,utf8_decode($tipo))); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
					//$pdf->Ln(5);
					$i++;
				}	
			}
			/////////////// ! FIN EXAMENES POR TEMA //////////
			$temnum++;
		}
		
		/////////////// EXAMENES GLOBALES //////////
		$result_examenes = $ClsExa->get_examen('',$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,0);
		if(is_array($result_examenes)){
			//limpieza
			$unidad = "";
			$nom = "";
			$periodos = "";
			$desc = "";
			///----- encabezados ---////
			$pdf->SetWidths(array(50, 100, 105, 30, 30, 30));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
			$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÓO
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
			for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
				$pdf->Row(array('',utf8_decode('EXÁMENES GLOBALES'), utf8_decode('DESCRIPCIÓN (EXÁMEN)'),'PUNTEO',utf8_decode('FECHA DE EVALUACIÓN'),'TIPO'));
			}
			$pdf->SetWidths(array(50, 100, 105, 30, 30, 30));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$pdf->SetAligns(array('C', 'L', 'J', 'C', 'C', 'C'));  // AQUÓ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$i++;
			foreach($result_examenes as $row_examenes){
				//nombre
				$titulo = utf8_decode($row_examenes["exa_titulo"]);
				//descripcion
				$desc = utf8_decode($row_examenes["exa_descripcion"]);
				//punteo
				$pondera = number_format($row_examenes["exa_ponderacion"],2,'.','');
				$tipo_pondera = trim($row_examenes["exa_tipo_calificacion"]);
				$tipo_pondera = ($tipo_pondera == "Z")?"Actividades":utf8_decode("Evaluación");
				//fecha de entreda
				$fecha = utf8_decode($row_examenes["exa_fecha_inicio"]);
				$fecha = cambia_fechaHora($fecha);
				$fecha = substr($fecha, 0, -3);
				//TIPO
				$tipo = utf8_decode($row_examenes["exa_tipo"]);
				$tipo = ($tipo == "OL")?"EN LÍNEA":"EN CLASE";
				//--
				$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÓO DE LA LETRA
				$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
				$pdf->Row(array('',$titulo,$desc,$pondera.'/'.$tipo_pondera,$fecha,utf8_decode($tipo))); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
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