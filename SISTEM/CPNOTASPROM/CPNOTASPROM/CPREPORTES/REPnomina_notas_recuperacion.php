<?php
include_once('html_fns_reportes.php');
	$usuario = $_SESSION["codigo"];
	$nombre_usu = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$grado_usu = $_SESSION["grado"];
	$arma_usu = $_SESSION["arma"];
	//-- $_POST
	$pensum = $_REQUEST["pensum"];
	$semestre = $_REQUEST["semestre"];
	$nomina = $_REQUEST["nomina"];
	//--
	$ClsEst = new ClsEstadisticaRecuperacion();
	//--
	$result = $ClsEst->get_nomina($nomina,$pensum,$semestre,'','');
	if(is_array($result)){
		foreach($result as $row){
			//encabezados
			$titulo = trim($row["nom_titulo"]);
			$pensum_desc = trim($row["pen_descripcion_completa"]);
			$semestre_desc = trim($row["sem_descripcion"]);
			$tipo_desc = trim($row["nom_recuperacion"]);
			switch($tipo_desc){
				case 1: $tipo_desc = "1RA. RECUPERACI�N"; break;
				case 2: $tipo_desc = "2DA. RECUPERACI�N"; break;
			}
		}	
	}	
	
	
	$pdf=new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(1);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, $titulo, 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 5, 'Programa Acad&eacute;mico: '.$pensum_desc, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Semestre: '.$semestre_desc, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Tipo: '.$tipo_desc, 0 , 'L' , 0);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 325 ,10, 25 , 25,'JPG', '');

	
	$pdf->Ln(10);
	
	//////////////////////////////______ Lista las Materias ______//////////////////////////////
		$result_materias = $ClsEst->get_nomina_detalle_materias($nomina,$pensum,$semestre,'');
			if(is_array($result_materias)){
				$mat_count = 1;
				foreach($result_materias as $row_materia){
					$mat_cod = $row_materia["mat_codigo"];
					$materia_codigo[$mat_count] = $row_materia["mat_codigo"];
					$materia_descripcion[$mat_count] = $row_materia["mat_desc_ct"];
					$mat_count++;	
				}
				$mat_count--; //quita la ultima vuelta
			}
			
	
	$i=1;
	$ancho_tabla = (80+($mat_count*15)+30);
	$result_cadetes = $ClsEst->get_detalle_nomina($pensum,$semestre,$nomina);
	if(is_array($result_cadetes)){
			$pdf->SetFont('Arial','',7);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->Cell($ancho_tabla,5,'LISTADO GENERAL DE RECUPERACI�N',1,'','L',true);
			$pdf->Ln(5);
			////////////////////////////////////// TABLA DE NOTAS ///////////////////////////////////////////
			//-- tama�os de columnas
				$arr_cols[0] = 10;
				$arr_cols[1] = 70;
				$cols = 2;
				for($z=1;$z<=$mat_count;$z++){
					$arr_cols[$cols] = 15;
					$cols++;
				}
				$arr_cols[$cols] = 15;
				$arr_cols[$cols+1] = 15;
			///--
			//-- Aliniamientos de columnas
				$arr_cols_align[0] = 'C';
				$arr_cols_align[1] = 'C';
				$cols = 2;
				for($z=1;$z<=$mat_count;$z++){
					$arr_cols_align[$cols] = 'C';
					$cols++;
				}
				$arr_cols_align[$cols] = 'C';
				$arr_cols_align[$cols+1] = 'C';
			///--
				$pdf->SetWidths($arr_cols);  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				$pdf->SetAligns($arr_cols_align);  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
				// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
				$pdf->SetFont('Arial','B',6);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
				$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
			//-- Encabezados
				$arr_encabezado[0] = 'No.';
				$arr_encabezado[1] = 'NOMBRES';
				$cols = 2;
				for($z=1;$z<=$mat_count;$z++){
					$arr_encabezado[$cols] = $materia_descripcion[$z];
					$cols++;
				}
				$arr_encabezado[$cols] = 'PROM.';
				$arr_encabezado[$cols+1] = 'ROJOS';
			///--
			// ESTE ES EL ENCABEZADO DE LA TABLA, 
			$pdf->Row($arr_encabezado);
			////////////////////////////////////// CUERPO ///////////////////////////////////////////
			$pdf->SetWidths($arr_cols);  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
			$arr_cols_align[1] = 'L'; //Alinea a la Izquierda la columna de nombre de cadetes
			$pdf->SetAligns($arr_cols_align);  // AQU� LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
		
		
		foreach($result_cadetes as $row){
			//catalogo
			$catalogo = $row["det_catalogo"];
			//nombres
			$grado = $row["gra_desc_ct"];
			$nom1 = trim($row["cad_nom1"]);
			$nom2 = trim($row["cad_nom2"]);
			$ape1 = trim($row["cad_ape1"]);
			$ape2 = trim($row["cad_ape2"]);
			$nombres = $grado." ".$ape1." ".$ape2.", ".$nom1." ".$nom2;
			//promedio
			$promedio = trim($row["det_promedio"]);
			//promedio Universitario
			$promedioU = trim($row["det_promedio_u"]);
			//Rojos
			$rojos = trim($row["det_rojos"]);
			//puesto
			$puesto = trim($row["det_puesto"]);
			//---
			$pdf->SetFont('Arial','',6);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			
			//-- Datos
				$arr_datos[0] = $i.'.';
				$arr_datos[1] = $nombres;
				$cols = 2;
				for($z=1;$z<=$mat_count;$z++){
					$materia = $materia_codigo[$z-1];
					$result_notas = $ClsEst->get_nomina_detalle_notas($nomina,$pensum,$semestre,$catalogo,$materia);
					if(is_array($result_notas)){
						foreach($result_notas as $row_notas){
							$nota = trim($row_notas["not_nota"]);
							if($nota != 0){
								$arr_datos[$cols] = $nota;
							}else{
								$arr_datos[$cols] = "PENDIENTE";
							}
						}
					}else{
						$arr_datos[$cols] = "-";
					}
					$cols++;
				}	
				$arr_datos[$cols] = $promedio;
				$arr_datos[$cols+1] = $rojos;
			///--
			
			$pdf->Row($arr_datos); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
		}
			
	}else{
		$pdf->SetFont('Arial','',7);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
		$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell($ancho_tabla,5,'No se Reportan Datos.',1,'','C',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
		
		$y=$pdf->GetY();
		$y+=5;
	} 
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>