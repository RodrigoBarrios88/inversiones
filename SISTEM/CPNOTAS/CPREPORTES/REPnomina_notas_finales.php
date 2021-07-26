<?php
include_once('html_fns_reportes.php');
	$usuario = $_SESSION["codigo"];
	$nombre_usu = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$colegio = $_SESSION["colegio_nombre_reporte"];
	//$_POST
	$pensum = $_REQUEST["pensum"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$tipo = $_REQUEST["tipo"];
	$unidad = $_REQUEST["num"];
	$tiposec = $_REQUEST["tiposec"];
	$seccion = $_REQUEST["seccion"];
	$filas_materia = $_REQUEST["materiarows"];
	//--formato de notas
	$chkzona = $_REQUEST["chkzona"];
	$chknota = $_REQUEST["chknota"];
	$chktotal = $_REQUEST["chktotal"];
	//--$POST de Configuraci�n
	$titulo = utf8_decode($_REQUEST["titulo"]);
	$acho_cols = $_REQUEST["anchocols"];
	$fontsize = $_REQUEST["font"];
	$tipo_papel = $_REQUEST["papel"];
	$orientacion = $_REQUEST["orientacion"];
	$nota_minima = $_REQUEST["notaminima"];
	////////////////// -- EXONERACIONES -- ///////////////////////
	$chkexonera = $_REQUEST["chkexonera"];
	function porcentajes_unidad($unidad,$nivel){
		switch($unidad){
			case 1: $porcentaje = 0.25; break;
			case 2: $porcentaje = 0.25; break;
			case 3: $porcentaje = 0.25; break;
			case 4: $porcentaje = 0.25; break;
		}
		return $porcentaje;
	}
	$unidades = ($nivel == 1)?3:4;
	$unidades = ($chkexonera == 1)?$unidades:"";
	
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsNot = new ClsNotas();
	
	if($pensum == "" && $nivel == "" && $grado ==""){
		echo "<script>window.close();</script>";
	}
	
	$result = $ClsPen->get_seccion($pensum,$nivel,$grado,$seccion);
	if(is_array($result)){
		foreach($result as $row){
			$pensum_desc = $row["pen_descripcion"];
			$nivel_desc = $row["niv_descripcion"];
			$grado_desc = utf8_decode($row["gra_descripcion"]);
			$seccion_desc = utf8_decode($row["sec_descripcion"]);
		}
	}
	//--
	if($chkexonera != 1){
		$titulo = utf8_decode("Informe de Notas Finales para $grado_desc Sección $seccion_desc");
	}else{
		$titulo = utf8_decode("Nomina para Exoneraciones de $grado_desc Sección $seccion_desc");
	}
	//--
	//--- logo
	$x = 0;
	$y = 0;
	$w = 0;
	$h = 0;
	
	if($tipo_papel == "Letter"){
		if($orientacion == "P"){
			$x = 180;
			$y = 5;
			$w = 30;
			$h = 25;
			$ancho_hoja = 205;
		}else{
			$x = 245;
			$y = 5;
			$w = 30;
			$h = 25;
			$ancho_hoja = 270;
		}
	}else{
		if($orientacion == "P"){
			$x = 180;
			$y = 5;
			$w = 30;
			$h = 25;
			$ancho_hoja = 205;
		}else{
			$x = 320;
			$y = 5;
			$w = 30;
			$h = 25;
			$ancho_hoja = 345;
		}
	}
	
	$pdf=new PDF($orientacion,'mm',$tipo_papel);  // si quieren el reporte horizontal
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(1);
	
	////// Trae las materias a listar en las notas
	$arr_datos = array();
	$mat_count = 1;
	$columnas = 1;
	$PosY = 45;
	$columna = ($ancho_hoja)/3;
	//--
	$pdf->SetFont('Arial','B',12);
	$pdf->SetY(40);
	$pdf->Cell(0, 5, "Materias del Grado", 1, 0, 'C');
	//-
	for($k = 1; $k <= $filas_materia; $k++){
		if($_REQUEST["materia$k"] != ""){
			$materia[$mat_count] = $_REQUEST["materia$k"];
			$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado,$materia[$mat_count],'1',1);
			if(is_array($result_materias)){
				foreach($result_materias as $row_materia){
					//--
					$pensum_desc = utf8_decode($row_materia["pen_descripcion"]);
					$nivel_desc = utf8_decode($row_materia["niv_descripcion"]);
					$grado_desc = utf8_decode($row_materia["gra_descripcion"]);
					$seccion_desc = utf8_decode($row_materia["sec_descripcion"]);
					//--
					$mat_cod = $row_materia["mat_codigo"];
					$materia_codigo[$mat_count] = $row_materia["mat_codigo"];
					$materia_descripcion[$mat_count] = utf8_decode($row_materia["mat_descripcion"]);
					//--
					if($columnas == 1){
						$PosX = 5;
					}else if($columnas == 2){
						$PosX = ($columna+5);
					}else if($columnas == 3){
						$PosX = ($columna*2)+5;
					}
					$pdf->SetFont('Arial','',10);
					$pdf->SetXY($PosX,$PosY);
					$pdf->Cell($columna, 5, "$mat_count. ".utf8_decode($row_materia["mat_descripcion"]), 0, 0);
					//--
				}
				$mat_count++;
				$columnas++;
				if($columnas == 4){
					$columnas = 1;
					$PosY+=5;
				}
			}
		}
	}
	$mat_count--;
	//--
	$PosY+=5;
	//recuadro de todas las notas
	$pdf->SetY(45);
	$alto = $PosY - 45;
	$pdf->Cell(0, $alto, "", 1, 0, 'C');
	//--
	$PosY+=3;
	
	///coloca los formatos porsible en la impresion
	if($chkzona == 1 && $chknota == 1 && $chktotal == 1){
		$formato = "Actividades + Nota de Evaluaciones = Total";
	}else if($chkzona == 1 && $chknota == 1 && $chktotal != 1){
		$formato = "Actividades y Nota";
	}else if($chkzona == 1 && $chknota != 1 && $chktotal != 1){
		$formato = "Zonas";
	}else if($chkzona != 1 && $chknota == 1 && $chktotal != 1){
		$formato = "Nota de Evaluaciones";
	}else if($chkzona != 1 && $chknota != 1 && $chktotal == 1){
		$formato = "Punteo Total";
	}else{
		$formato = "Formato Desconocido (Se usa Punteo Total)"; ///cualquier otra variacion no contemplada se colocara con la nota unicamnete
	}
	
	$pdf->SetY(5);
	$pdf->SetFont('Arial','B',16);
	$pdf->MultiCell(0, 10, $colegio, 0 , 'C' , 0);
	$pdf->SetFont('Arial','B',14);
	$pdf->MultiCell(0, 7, $titulo, 0 , 'C' , 0);
	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, $pensum_desc.', Nivel: '.$nivel_desc, 0 , 'C' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 5, 'Generado: '.date("d/m/Y H:i"), 0 , 'C' , 0);
	$pdf->MultiCell(0, 5, 'Formato de Notas: '.$formato, 0 , 'C' , 0);
	
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , $x ,$y, $w , $h,'JPG', '');
	//$pdf->Rect($x ,$y, $w , $h);

	
	/// CENTRADO DE MARGENES
	$ancho_tabla = (80+($mat_count*$acho_cols)+($acho_cols*2));
	
	if($tipo_papel == "Letter"){
		if($orientacion == "P"){
			$ancho_hoja = 216;
		}else{
			$ancho_hoja = 280;
		}
	}else{
		if($orientacion == "P"){
			$ancho_hoja = 216;
		}else{
			$ancho_hoja = 356;
		}
	}
	$margen_doble = ($ancho_hoja - $ancho_tabla);
	if($margen_doble > 0){
		$margen_horiontal = ($margen_doble/2);
	}else{
		$margen_horiontal = 2;
	}
	
	//echo "$margen_doble = ($ancho_hoja - $ancho_tabla)";
	$pdf->SetMargins($margen_horiontal,5,$margen_horiontal);
	
	$pdf->SetY($PosY);
	
	$i=1;
	$seccX = 0;
	$ancho_tabla = (80+($mat_count*$acho_cols)+($acho_cols*2));
	$result_alumnos = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	if(is_array($result_alumnos)){
		foreach($result_alumnos as $row){
			$seccion = $row["seca_seccion"];
			$seccion_desc = utf8_decode($row["sec_descripcion"]);
			
			if($seccX != $seccion){ //VAlida los encabezados por semestre
				$seccX = $seccion;
				////////////////////////////////////// TABLA DE ARRESTOS ///////////////////////////////////////////
				//-- tama�os de columnas
					$arr_cols[0] = 10;
					$arr_cols[1] = 70;
					$cols = 2;
					for($z=1;$z<=$mat_count;$z++){
						$arr_cols[$cols] = $acho_cols;
						$cols++;
					}
					$arr_cols[$cols] = $acho_cols;
					$arr_cols[$cols+1] = $acho_cols;
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
				$pdf->SetFont('Arial','B',$fontsize);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMA�O
				$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
				$pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
				//-- Encabezados
					$arr_encabezado[0] = 'No.';
					$arr_encabezado[1] = 'NOMBRES';
					$cols = 2;
					for($z=1;$z<=$mat_count;$z++){
						$arr_encabezado[$cols] = $z;
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

			}
			$alumno = $row["alu_cui"];
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre."";
			//---
			$pdf->SetFont('Arial','',$fontsize);   // ASIGNO EL TIPO Y TAMA�O DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			
			//-- Datos
			$arr_datos[0] = $i.'.';
			$arr_datos[1] = $nombres;
			$cols = 2;
			//--	
			$total = 0;
			$rojos = 0;
			$pendientes = 0;
			$notas_validas = 1;
			for($y = 1; $y <= $mat_count; $y++){
				$nota_porcentuada = 0;
				$result_notas = $ClsNot->get_notas_alumno_tarjeta($alumno,$pensum,$nivel,$grado,$seccion,$materia[$y]);
				if(is_array($result_notas)){
					foreach($result_notas as $row_notas){
						$zona = $row_notas["not_zona"];
    					$nota = $row_notas["not_nota"];
    				    $parcial = $row_notas["not_parcial"];
    					$punteo = ($zona + $nota);
    					$porcent = porcentajes_unidad($parcial,$nivel);
    					$porcentaje = ($porcent * $punteo);
    					$porcentaje = number_format($porcentaje, 0, '.', '');
    					$nota_porcentuada+= $porcentaje;
    				}
    				$notas_validas++;
					$total+= $nota_porcentuada;
					///coloca los formatos porsible en la impresion
					if($chkzona != 1 && $chknota != 1 && $chktotal == 1){
						$formato = "$nota_porcentuada";
					}else{
						$formato = "$nota_porcentuada"; ///cualquier otra variacion no contemplada se colocara con la nota unicamnete
					}
					
					$arr_datos[$cols] = $formato;
					if($nota_porcentuada < $nota_minima && $nota_porcentuada > 0){
						$rojos++;
						$arr_colores[$cols-1] = "199,0,57";
					}else if($nota_porcentuada >= $nota_minima && $nota_porcentuada < 70){
						$arr_colores[$cols-1] = "95,141,227";
					}else{
						$arr_colores[$cols-1] = "0,0,0";
					}
				}else{
					$arr_datos[$cols] = "-";
					$pendientes++;
				}
				$cols++;
			}
			$notas_validas--;
			if($total > 0){
				$promedio = ($total/$notas_validas);
				$promedio = round($promedio, 2);
			}else{
				$promedio = 0;
			}
			$promedio = ($promedio > 0)?$promedio:"";
				
			$arr_datos[$cols] = $promedio;
			$arr_datos[$cols+1] = $rojos;
			///--
			
			$pdf->Row($arr_datos,$arr_colores); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY
			//$pdf->Cell($ancho_tabla,5,$pendientes,1,'','C',true);
			$i++;// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
		}
		
		
			
	}else{
		$pdf->SetFont('Arial','',$fontsize);  	// ASIGNO EL TIPO Y TAMA�O DE LA LETRA
		$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell($ancho_tabla,5,'No se Reportan Datos.',1,'','C',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
		
		$y=$pdf->GetY();
		$y+=5;
	} 
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output('Notas Finales.pdf','I');

?>