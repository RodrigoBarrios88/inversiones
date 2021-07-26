<?php
   include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	//$_POST
	$pensum = trim($_REQUEST["pensum"]);
	$nivel = trim($_REQUEST["nivel"]);
	$grado = trim($_REQUEST["grado"]);
	$seccion = trim($_REQUEST["seccion"]);
   $situacion = trim($_REQUEST["situacion"]);
	//--
   $columnas1 = $_REQUEST["columnas1"];
	$columnas2 = $_REQUEST["columnas2"];
	$columnas3 = $_REQUEST["columnas3"];
	$columnas4 = $_REQUEST["columnas4"];
   
	$pdf=new PDF('L','mm','Legal');  // si quieren el reporte horizontal
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, 'REPORTE DE ALUMNOS', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generacion: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por Nombre: '.$nombre, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 320 ,5, 30 , 30,'JPG', '');

	$pdf->Ln(10);
   ////////////////////////////////////// PARAMETROS ///////////////////////////////////////////
   $anchos = array("10");
   $alineaciones = array("C");
   $titulos = array("No.");
   $campos = array();
	$i = 1;
	$ancho_total = 10;
	if(is_array($columnas1)){
      foreach($columnas1 as $col){
         $parametros = parametrosDinamicos($col);
         $anchos[$i] = $parametros['anchos'];
         $alineaciones[$i] = $parametros['alineaciones'];
         $titulos[$i] = $parametros['titulos'];
         $ancho_total+= $parametros['anchos']; 
         $i++;
      }
   }
	if(is_array($columnas2)){
      foreach($columnas2 as $col){
         $parametros = parametrosDinamicos($col);
         $anchos[$i] = $parametros['anchos'];
         $alineaciones[$i] = $parametros['alineaciones'];
         $titulos[$i] = $parametros['titulos'];
         $ancho_total+= $parametros['anchos']; 
         $i++;
      }
   }
	if(is_array($columnas3)){
      foreach($columnas3 as $col){
         $parametros = parametrosDinamicos($col);
         $anchos[$i] = $parametros['anchos'];
         $alineaciones[$i] = $parametros['alineaciones'];
         $titulos[$i] = $parametros['titulos'];
         $ancho_total+= $parametros['anchos']; 
         $i++;
      }
   }
	if(is_array($columnas4)){
      foreach($columnas4 as $col){
         $parametros = parametrosDinamicos($col);
         $anchos[$i] = $parametros['anchos'];
         $alineaciones[$i] = $parametros['alineaciones'];
         $titulos[$i] = $parametros['titulos'];
         $ancho_total+= $parametros['anchos']; 
         $i++;
      }		
	}
	$i--;
   
   //print_r($titulos);
    
	////////////////////////////////////// ENCABEZADOS ///////////////////////////////////////////
	$pdf->SetWidths($anchos);  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns($alineaciones);  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',10);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
   $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$pdf->Row($titulos);
	}

	////////////////////////////////////// CUERPO ///////////////////////////////////////////
	$pdf->SetWidths($anchos);  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns($alineaciones);  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	$ClsAlu = new ClsAlumno();
	$result = $ClsAlu->get_alumno_reportes('','','','','',$pensum,$nivel,$grado,$seccion,$situacion);
	
	$i=1;
	if(is_array($result)){
		foreach($result as $row){
         $j = 1;
			if(is_array($columnas1)){
            foreach($columnas1 as $col){
               $parametros = parametrosDinamicos($col);
               $campo = $parametros['campo'];
               if($col == "fecha_nacimiento"){
                  $arrcampos[$j] = cambia_fecha($row[$campo]);
               }else if($col == "edad"){
                  $edad = Calcula_Edad(cambia_fecha($row[$campo]));
						$edad = ($edad <= 130)?$edad." años":"";
                  $arrcampos[$j] = $edad;
               }else if($col == "genero"){
						$genero = (trim($row[$campo]) == "M")?"Niño":"Niña";
                  $arrcampos[$j] = $genero;
               }else if($col == "seguro"){
						$seguro = (trim($row[$campo]) == 1)?"Si":"No";
                  $arrcampos[$j] = $seguro;
               }else if($col == "situacion"){
						$situacion = (trim($row[$campo]) == 1)?"Activo":"Inactivo";
                  $arrcampos[$j] = $situacion;
               }else{
                  $arrcampos[$j] = utf8_decode($row[$campo]);
               }
               $j++;
            }
         }
			if(is_array($columnas2)){
            foreach($columnas2 as $col){
               $parametros = parametrosDinamicos($col);
               $campo = $parametros['campo'];
               if($col == "padre_fecha_nacimiento"){
                  $arrcampos[$j] = cambia_fecha($row[$campo]);
               }else if($col == "padre_edad"){
                  $edad = Calcula_Edad(cambia_fecha($row[$campo]));
						$edad = ($edad <= 130)?$edad." años":"";
                  $arrcampos[$j] = $edad;
               }else if($col == "padre_estado_civil"){
						$genero = (trim($row[$campo]) == "C")?"Casado":"Soltero";
                  $arrcampos[$j] = $genero;
               }else{
                  $arrcampos[$j] = utf8_decode($row[$campo]);
               }
               $j++;
            }
         }
			if(is_array($columnas3)){
            foreach($columnas3 as $col){
               $parametros = parametrosDinamicos($col);
               $campo = $parametros['campo'];
               if($col == "madre_fecha_nacimiento"){
                  $arrcampos[$j] = cambia_fecha($row[$campo]);
               }else if($col == "madre_edad"){
                  $edad = Calcula_Edad(cambia_fecha($row[$campo]));
						$edad = ($edad <= 130)?$edad." años":"";
                  $arrcampos[$j] = $edad;
					}else if($col == "madre_estado_civil"){
						$genero = (trim($row[$campo]) == "C")?"Casada":"Soltera";
                  $arrcampos[$j] = $genero;
               }else{
                  $arrcampos[$j] = utf8_decode($row[$campo]);
               }
               $j++;
            }
         }
			if(is_array($columnas4)){
            foreach($columnas4 as $col){
               $parametros = parametrosDinamicos($col);
               $campo = $parametros['campo'];
               if($col == "encargado_fecha_nacimiento"){
                  $arrcampos[$j] = cambia_fecha($row[$campo]);
               }else if($col == "encargado_edad"){
                  $edad = Calcula_Edad(cambia_fecha($row[$campo]));
						$edad = ($edad <= 130)?$edad." años":"";
                  $arrcampos[$j] = $edad;
               }else if($col == "encargado_estado_civil"){
						$genero = (trim($row[$campo]) == "C")?"Casado(a)":"Soltero(a)";
                  $arrcampos[$j] = $genero;
               }else if($col == "encargado_parentesco"){
                  $parentesco = trim($row[$campo]);
						if($parentesco == "A"){
							$parentesco = "Abuelo(a)";
						}else if($parentesco == "O"){
							$parentesco = "Encargado";
						}else{
							$parentesco = "";
						}
						$arrcampos[$j] = $parentesco;
               }else{
                  $arrcampos[$j] = utf8_decode($row[$campo]);
               }
               $j++;
            }
         }
			//---
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
         $arrcampos[0] = $i.".";
			$pdf->Row($arrcampos); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;															// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
		}
      
      ////////////////////////////////////// PIE DE REPORTE ///////////////////////////////////////////
		$i--; //quita la uultima vuelta
			$pdf->SetFont('Arial','B',10);  	// ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(216,216,216);
			$pdf->Cell($ancho_total,5,$i.' Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
			
	}else{
		$pdf->SetFont('Arial','',10);  	// ASIGNO EL TIPO Y TAMA?O DE LA LETRA
		$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell($ancho_total,5,'No se Reportan Datos.',1,'','C',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
		
		$y=$pdf->GetY();
		$y+=5;
		// Put the position to the right of the cell
		$pdf->SetXY(5,$y);
		//footer
		$pdf->SetFont('Arial','B',10);  	// ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
		$pdf->SetFillColor(216,216,216);
		$pdf->Cell($ancho_total,5,'0 Registro(s).',1,'','R',true);	// AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
	} 
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();
   
   function parametrosDinamicos($columna){
      switch($columna){
			//////////// ALUMNO /////////////////////////
         case "cui":
            $respuesta["anchos"] = "30";
            $respuesta["alineaciones"] = "C";
            $respuesta["titulos"] = "ID";
            $respuesta["campo"] = "alu_cui";
            break;
         case "tipo_cui":
            $respuesta["anchos"] = "30";
            $respuesta["alineaciones"] = "C";
            $respuesta["titulos"] = "Tipod de ID";
            $respuesta["campo"] = "alu_tipo_cui";
            break;
			case "codigo_interno":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Código Interno";
				$respuesta["campo"] = "alu_codigo_interno";
				break;
			case "codigo_mineduc":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "MINEDUC";
				$respuesta["campo"] = "alu_codigo_mineduc";
				break;
			case "nombre":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Nombres";
				$respuesta["campo"] = "alu_nombre";
				break;
			case "apellido":
				$respuesta["anchos"] = "50";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Apellidos";
				$respuesta["campo"] = "alu_apellido";
				break;
			case "fecha_nacimiento":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Fecha Nac.";
				$respuesta["campo"] = "alu_fecha_nacimiento";
				break;
			case "edad":
				$respuesta["anchos"] = "20";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Edad";
				$respuesta["campo"] = "alu_fecha_nacimiento";
				break;
			case "nacionalidad":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Nacionalidad";
				$respuesta["campo"] = "alu_nacionalidad";
				break;
			case "religion":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Religion";
				$respuesta["campo"] = "alu_religion";
				break;
			case "idioma":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Idioma";
				$respuesta["campo"] = "alu_idioma";
				break;
			case "genero":
				$respuesta["anchos"] = "20";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Genero";
				$respuesta["campo"] = "alu_genero";
				break;
			case "tipo_sangre":
				$respuesta["anchos"] = "25";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Tipo/Sangre";
				$respuesta["campo"] = "alu_tipo_sangre";
				break;
			case "alergico_a":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Alergico a";
				$respuesta["campo"] = "alu_alergico_a";
				break;
			case "emergencia":
				$respuesta["anchos"] = "45";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Emergencia";
				$respuesta["campo"] = "alu_emergencia";
				break;
			case "emertel":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Tel. Emergencia";
				$respuesta["campo"] = "alu_emergencia_telefono";
				break;
			case "mail":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Email (Alumno)";
				$respuesta["campo"] = "alu_mail";
				break;
			case "nit":
				$respuesta["anchos"] = "25";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "NIT";
				$respuesta["campo"] = "cli_nit";
				break;
			case "cliente":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Cliente";
				$respuesta["campo"] = "cli_nombre";
				break;
			case "recoge":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Recoge";
				$respuesta["campo"] = "alu_recoge";
				break;
			case "redes_sociales":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Redes Sociales";
				$respuesta["campo"] = "alu_redes_sociales";
				break;
			case "nivel":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Nivel";
				$respuesta["campo"] = "vgra_nivel_descripcion";
				break;
			case "grado":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Grado";
				$respuesta["campo"] = "vgra_grado_descripcion";
				break;
			case "seccion":
				$respuesta["anchos"] = "25";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Sección";
				$respuesta["campo"] = "vsec_seccion_descripcion";
				break;
			case "seguro":
				$respuesta["anchos"] = "20";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Seguro";
				$respuesta["campo"] = "seg_tiene_seguro";
				break;
			case "poliza":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "No. Poliza";
				$respuesta["campo"] = "seg_poliza";
				break;
			case "aseguradora":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Aseguradora";
				$respuesta["campo"] = "seg_aseguradora";
				break;
			case "plan":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Plan";
				$respuesta["campo"] = "seg_plan";
				break;
			case "asegurado":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Asegurado Principal";
				$respuesta["campo"] = "seg_asegurado_principal";
				break;
			case "instrucciones":
				$respuesta["anchos"] = "100";
				$respuesta["alineaciones"] = "J";
				$respuesta["titulos"] = "Instruciones";
				$respuesta["campo"] = "seg_instrucciones";
				break;
			case "comentarios":
				$respuesta["anchos"] = "100";
				$respuesta["alineaciones"] = "J";
				$respuesta["titulos"] = "Comentarios";
				$respuesta["campo"] = "seg_comentarios";
				break;
			case "situacion":
				$respuesta["anchos"] = "23";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Situación";
				$respuesta["campo"] = "alu_situacion";
				break;
			///////////////// PADRE /////////////////////
			case "padre_cui":
            $respuesta["anchos"] = "30";
            $respuesta["alineaciones"] = "C";
            $respuesta["titulos"] = "ID Padre";
            $respuesta["campo"] = "padre_dpi";
            break;
         case "padre_tipo_dpi":
            $respuesta["anchos"] = "30";
            $respuesta["alineaciones"] = "C";
            $respuesta["titulos"] = "Tipod de ID";
            $respuesta["campo"] = "pad_tipo_dpi";
            break;
			case "padre_nombre":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Nombres (Padre)";
				$respuesta["campo"] = "padre_nombre";
				break;
			case "padre_apellido":
				$respuesta["anchos"] = "50";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Apellidos (Padre)";
				$respuesta["campo"] = "padre_apellido";
				break;
			case "padre_fecha_nacimiento":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Fecha Nac. (Padre)";
				$respuesta["campo"] = "padre_fecha_nacimiento";
				break;
			case "padre_edad":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Edad (Padre)";
				$respuesta["campo"] = "padre_fecha_nacimiento";
				break;
			case "padre_estado_civil":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Estado Civil (Padre)";
				$respuesta["campo"] = "padre_estado_civil";
				break;
			case "nacionalidad":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Nacionalidad (Padre)";
				$respuesta["campo"] = "padre_nacionalidad";
				break;
			case "padre_telefono":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Teléfono (Padre)";
				$respuesta["campo"] = "padre_telefono";
				break;
			case "padre_celular":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Celular (Padre)";
				$respuesta["campo"] = "padre_celular";
				break;
			case "padre_mail":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Email (Padre)";
				$respuesta["campo"] = "padre_mail";
				break;
			case "padre_direccion":
				$respuesta["anchos"] = "100";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Dirección (Padre)";
				$respuesta["campo"] = "padre_direccion";
				break;
			case "padre_lugar_trabajo":
				$respuesta["anchos"] = "50";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Lugar de Trabajo";
				$respuesta["campo"] = "padre_lugar_trabajo";
				break;
			case "padre_telefono_trabajo":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Tel.Trabajo";
				$respuesta["campo"] = "padre_telefono_trabajo";
				break;
			case "padre_profesion":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Profesión (Padre)";
				$respuesta["campo"] = "padre_profesion";
				break;
			///////////////// MADRE /////////////////////
			case "madre_cui":
            $respuesta["anchos"] = "30";
            $respuesta["alineaciones"] = "C";
            $respuesta["titulos"] = "ID Madre";
            $respuesta["campo"] = "madre_dpi";
            break;
         case "madre_tipo_dpi":
            $respuesta["anchos"] = "30";
            $respuesta["alineaciones"] = "C";
            $respuesta["titulos"] = "Tipod de ID";
            $respuesta["campo"] = "pad_tipo_dpi";
            break;
			case "madre_nombre":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Nombres (Madre)";
				$respuesta["campo"] = "madre_nombre";
				break;
			case "madre_apellido":
				$respuesta["anchos"] = "50";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Apellidos (Madre)";
				$respuesta["campo"] = "madre_apellido";
				break;
			case "madre_fecha_nacimiento":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Fecha Nac. (Madre)";
				$respuesta["campo"] = "madre_fecha_nacimiento";
				break;
			case "madre_edad":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Edad (Madre)";
				$respuesta["campo"] = "madre_fecha_nacimiento";
				break;
			case "madre_estado_civil":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Estado Civil (Madre)";
				$respuesta["campo"] = "madre_estado_civil";
				break;
			case "nacionalidad":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Nacionalidad (Madre)";
				$respuesta["campo"] = "madre_nacionalidad";
				break;
			case "madre_telefono":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Teléfono (Madre)";
				$respuesta["campo"] = "madre_telefono";
				break;
			case "madre_celular":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Celular (Madre)";
				$respuesta["campo"] = "madre_celular";
				break;
			case "madre_mail":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Email (Madre)";
				$respuesta["campo"] = "madre_mail";
				break;
			case "madre_direccion":
				$respuesta["anchos"] = "100";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Dirección (Madre)";
				$respuesta["campo"] = "madre_direccion";
				break;
			case "madre_lugar_trabajo":
				$respuesta["anchos"] = "50";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Lugar de Trabajo";
				$respuesta["campo"] = "madre_lugar_trabajo";
				break;
			case "madre_telefono_trabajo":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Tel.Trabajo";
				$respuesta["campo"] = "madre_telefono_trabajo";
				break;
			case "madre_profesion":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Profesión (Madre)";
				$respuesta["campo"] = "madre_profesion";
				break;
			///////////////// MADRE /////////////////////
			case "encargado_cui":
            $respuesta["anchos"] = "30";
            $respuesta["alineaciones"] = "C";
            $respuesta["titulos"] = "ID Encargado";
            $respuesta["campo"] = "encargado_dpi";
            break;
         case "encargado_tipo_dpi":
            $respuesta["anchos"] = "30";
            $respuesta["alineaciones"] = "C";
            $respuesta["titulos"] = "Tipod de ID";
            $respuesta["campo"] = "pad_tipo_dpi";
            break;
			case "encargado_nombre":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Nombres (Encargado)";
				$respuesta["campo"] = "padre_nombre";
				break;
			case "encargado_apellido":
				$respuesta["anchos"] = "50";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Apellidos (Encargado)";
				$respuesta["campo"] = "padre_apellido";
				break;
			case "encargado_parentesco":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Parentesco";
				$respuesta["campo"] = "encargado_parentesco";
				break;
			case "encargado_fecha_nacimiento":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Fecha Nac.";
				$respuesta["campo"] = "encargado_fecha_nacimiento";
				break;
			case "encargado_edad":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Edad";
				$respuesta["campo"] = "encargado_fecha_nacimiento";
				break;
			case "encargado_estado_civil":
				$respuesta["anchos"] = "50";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Estado Civil (Encargado)";
				$respuesta["campo"] = "encargado_estado_civil";
				break;
			case "nacionalidad":
				$respuesta["anchos"] = "50";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Nacionalidad (Encargado)";
				$respuesta["campo"] = "encargado_nacionalidad";
				break;
			case "encargado_telefono":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Teléfono (Encargado)";
				$respuesta["campo"] = "encargado_telefono";
				break;
			case "encargado_celular":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Celular (Encargado)";
				$respuesta["campo"] = "encargado_celular";
				break;
			case "encargado_mail":
				$respuesta["anchos"] = "50";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Email (Encargado)";
				$respuesta["campo"] = "encargado_mail";
				break;
			case "encargado_direccion":
				$respuesta["anchos"] = "100";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Dirección (Encargado)";
				$respuesta["campo"] = "encargado_direccion";
				break;
			case "encargado_lugar_trabajo":
				$respuesta["anchos"] = "50";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Lugar de Trabajo";
				$respuesta["campo"] = "encargado_lugar_trabajo";
				break;
			case "encargado_telefono_trabajo":
				$respuesta["anchos"] = "30";
				$respuesta["alineaciones"] = "C";
				$respuesta["titulos"] = "Tel.Trabajo";
				$respuesta["campo"] = "encargado_telefono_trabajo";
				break;
			case "encargado_profesion":
				$respuesta["anchos"] = "40";
				$respuesta["alineaciones"] = "L";
				$respuesta["titulos"] = "Profesión (Encargado)";
				$respuesta["campo"] = "encargado_profesion";
				break;
		}	
      return $respuesta;
   }
   

?>