<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('America/Guatemala');

/** Include PHPExcel */
require_once '../../Clases/PHPExcel.php';
//incluye las librerias y Clases del Proyecto
include_once('html_fns_reportes.php');
    $nombre_usu = $_SESSION["nombre"];
    $colegio = $_SESSION["colegio_nombre_reporte"];
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
   
   ////////////////////////////////////// PARAMETROS ///////////////////////////////////////////
   $anchos[1] = 6;
   $alineaciones[1] = "C";
   $titulos[1] = "No.";
   $i = 2;
	$ancho_total = 6;
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
   $totalColumnas = $i;
   
   //print_r($titulos);
   

$titulo = "Reporte de Alumnos";
$file_desc = "Listado exportado a Excel";

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator($nombre_usu)
                              ->setLastModifiedBy($nombre_usu)
                              ->setTitle($titulo)
                              ->setSubject("Nomina en Excel Office 2007 XLSX")
                              ->setDescription($file_desc)
                              ->setKeywords("ASMS LMS")
                              ->setCategory($file_desc);
                             
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
    
   /// Combinacion de Celdas (Merge cells)
   $objPHPExcel->getActiveSheet()->mergeCells('C1:D1');
   $objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
   $objPHPExcel->getActiveSheet()->mergeCells('C3:D3');
   $objPHPExcel->getActiveSheet()->mergeCells('C4:D4');
   $objPHPExcel->getActiveSheet()->mergeCells('C5:D5');
   
   //Seteo de Titulos
   $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('C1', 'Reporte de Alumnos')
         ->setCellValue('C2',  utf8_decode($colegio))
         ->setCellValue('C3', 'Fecha de Generación: '.date("d/m/Y H:i:s"))
         ->setCellValue('C4', 'Generado por: '.$nombre);
         
   ///// ESTILOS        
   $objPHPExcel->getActiveSheet()->getStyle("C1:C4")->getFont()->setName('Arial'); /// Asigna tipo de letra
   $objPHPExcel->getActiveSheet()->getStyle("C1:C4")->getFont()->setSize(12); /// Asigna tamaño de letra
   $objPHPExcel->getActiveSheet()->getStyle("C1")->getFont()->setSize(16); /// Asigna tamaño de letra
   $objPHPExcel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true); /// Asigna negrita
   $objPHPExcel->getActiveSheet()->getStyle("C1")->getFill()->getStartColor()->setARGB('C4C4C4');
   
   ///// LOGO
   $gdImage = imagecreatefromjpeg('../../../CONFIG/images/replogo.jpg');
   // Add a drawing to the worksheet
   $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
   $objDrawing->setName('Logo');
   $objDrawing->setDescription('Logo');
   $objDrawing->setImageResource($gdImage);
   $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
   $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
   $objDrawing->setHeight(100);
   $objDrawing->setCoordinates('A1');
   $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
   
   ////// ENCABEZADOS /////
   for($i = 1; $i <= $totalColumnas; $i++){
      $letra = LetrasBase($i);
      $objPHPExcel->getActiveSheet()->setCellValue($letra."6", $titulos[$i]);
   }
   
   //--
   $letra = LetrasBase($totalColumnas);
   //echo "$letra - $totalColumnas <br><br>";
   
   $objPHPExcel->getActiveSheet()->getStyle("A6:$letra"."6")->getFont()->setName('Arial'); /// Asigna tipo de letra
   $objPHPExcel->getActiveSheet()->getStyle("A6:$letra"."6")->getFont()->setSize($fontsize*2); /// Asigna tamaño de letra
   $objPHPExcel->getActiveSheet()->getStyle("A6:$letra"."6")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
   $objPHPExcel->getActiveSheet()->getStyle("A6:$letra"."6")->getFill()->getStartColor()->setARGB('C4C4C4');
   $objPHPExcel->getActiveSheet()->getStyle("A6:$letra"."6")->getFont()->setBold(true); /// Asigna negrita
   $objPHPExcel->getActiveSheet()->getStyle("A6:$letra"."6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
   //--
   for($i = 1; $i <= $totalColumnas; $i++){
      $letra = LetrasBase($i);
      $objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth($anchos[$i]);
   }
   
   $ClsAlu = new ClsAlumno();
	$result = $ClsAlu->get_alumno_reportes('','','','','',$pensum,$nivel,$grado,$seccion,$situacion);
	/////////////////////////////        
   $linea_inicial = 6;
   $linea = 7;
   $i=1;
	if(is_array($result)){
		foreach($result as $row){
         $objPHPExcel->getActiveSheet()->setCellValue("A".$linea, $i.".");
         $j = 2;
			if(is_array($columnas1)){
            foreach($columnas1 as $col){
               $parametros = parametrosDinamicos($col);
               $campo = $parametros['campo'];
               $letra = LetrasBase($j);
               if($col == "fecha_nacimiento"){
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, cambia_fecha($row[$campo]));
               }else if($col == "edad"){
                  $edad = Calcula_Edad(cambia_fecha($row[$campo]));
						$edad = ($edad <= 130)?$edad." años":"";
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $edad);
               }else if($col == "genero"){
                  $genero = (trim($row[$campo]) == "M")?"Niño":"Niña";
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $genero);
               }else if($col == "seguro"){
						$seguro = (trim($row[$campo]) == 1)?"Si":"No";
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $seguro);
               }else if($col == "situacion"){
                  $situacion = (trim($row[$campo]) == 1)?"Activo":"Inactivo";
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $situacion);
               }else if($col == "cui"){
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, trim($row[$campo]));
                  $objPHPExcel->getActiveSheet()->getStyle($letra.$linea)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
               }else{
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, trim($row[$campo]));
               }
               $j++;
            }
         }
			if(is_array($columnas2)){
            foreach($columnas2 as $col){
               $parametros = parametrosDinamicos($col);
               $campo = $parametros['campo'];
               $letra = LetrasBase($j);
               if($col == "padre_fecha_nacimiento"){
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, cambia_fecha($row[$campo]));
               }else if($col == "padre_edad"){
                  $edad = Calcula_Edad(cambia_fecha($row[$campo]));
						$edad = ($edad <= 130)?$edad." años":"";
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $edad);
               }else if($col == "padre_estado_civil"){
						$genero = (trim($row[$campo]) == "C")?"Casado":"Soltero";
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $genero);
               }else if($col == "padre_cui"){
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, trim($row[$campo]));
                  $objPHPExcel->getActiveSheet()->getStyle($letra.$linea)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
               }else{
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, trim($row[$campo]));
               }
               $j++;
            }
         }
			if(is_array($columnas3)){
            foreach($columnas3 as $col){
               $parametros = parametrosDinamicos($col);
               $campo = $parametros['campo'];
               $letra = LetrasBase($j);
               if($col == "madre_fecha_nacimiento"){
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, cambia_fecha($row[$campo]));
               }else if($col == "madre_edad"){
                  $edad = Calcula_Edad(cambia_fecha($row[$campo]));
						$edad = ($edad <= 130)?$edad." años":"";
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $edad);
               }else if($col == "madre_estado_civil"){
						$genero = (trim($row[$campo]) == "C")?"Casado":"Soltero";
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $genero);
               }else if($col == "madre_cui"){
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, trim($row[$campo]));
                  $objPHPExcel->getActiveSheet()->getStyle($letra.$linea)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
               }else{
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, trim($row[$campo]));
               }
               $j++;
            }
         }
			if(is_array($columnas4)){
            foreach($columnas4 as $col){
               $parametros = parametrosDinamicos($col);
               $campo = $parametros['campo'];
               $letra = LetrasBase($j);
               if($col == "encargado_fecha_nacimiento"){
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, cambia_fecha($row[$campo]));
               }else if($col == "encargado_edad"){
                  $edad = Calcula_Edad(cambia_fecha($row[$campo]));
						$edad = ($edad <= 130)?$edad." años":"";
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $edad);
               }else if($col == "encargado_estado_civil"){
						$genero = (trim($row[$campo]) == "C")?"Casado(a)":"Soltero(a)";
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $genero);
               }else if($col == "encargado_parentesco"){
                  $parentesco = trim($row[$campo]);
						if($parentesco == "A"){
							$parentesco = "Abuelo(a)";
						}else if($parentesco == "O"){
							$parentesco = "Encargado";
						}else{
							$parentesco = "";
						}
						$objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $parentesco);
               }else if($col == "encargado_cui"){
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, trim($row[$campo]));
                  $objPHPExcel->getActiveSheet()->getStyle($letra.$linea)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
               }else{
                  $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, trim($row[$campo]));
               }
               $j++;
            }
         }
			$i++;
         $linea++;
      }
      $linea--;
      $i--;
   }
    
   // - ESTILOS DEL CUERPO DE LA TABLA - //
   // Alineacion
   for($i = 1; $i <= $totalColumnas; $i++){
      $letra = LetrasBase($i);
      $alinea = $alineaciones[$i];
      if($alinea == "C"){ /// CENTRA LA COLUMNA DE LA PRIMERA A LA ULTIMA FILA
         $objPHPExcel->getActiveSheet()->getStyle($letra.$linea_inicial.":".$letra.$linea)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      }
   }
   
   // recuadro de columnas
   $styleThinBlackBorderOutline = array(
      'borders' => array(
          'outline' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => array('argb' => 'FF000000'),
          ),
      ),
   );


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle($titulo);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// directorio
$directorio = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
//ofcourse we need rights to create temp dir
if (!file_exists($directorio)){
   mkdir($directorio);
}


// Save Excel 2007 file
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save("temp/$titulo.xlsx");
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

$excel = "temp/$titulo.xlsx";
header ("Content-Disposition: attachment; filename=Reporte_Alumnos.xlsx");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($excel));
readfile($excel);

unlink($excel);


function LetrasBase($numero){
   if($numero > 0 && $numero <= 26){
      $letras = Trae_letra($numero);
   }else if($numero > 26 && $numero <= 52){
      $resta = ($numero - 26);
      $letras = "A".Trae_letra($resta);
   }else if($numero > 52 && $numero <= 78){
      $resta = ($numero - 52);
      $letras = "B".Trae_letra($resta);
   }else if($numero > 78 && $numero <= 104){
      $resta = ($numero - 78);
      $letras = "C".Trae_letra($resta);
   }
   
   return $letras;
}

function parametrosDinamicos($columna){
   switch($columna){
      //////////// ALUMNO /////////////////////////
      case "cui":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "ID";
         $respuesta["campo"] = "alu_cui";
         break;
      case "tipo_cui":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Tipod de ID";
         $respuesta["campo"] = "alu_tipo_cui";
         break;
      case "codigo_interno":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Código Interno";
         $respuesta["campo"] = "alu_codigo_interno";
         break;
      case "codigo_mineduc":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "MINEDUC";
         $respuesta["campo"] = "alu_codigo_mineduc";
         break;
      case "nombre":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Nombres";
         $respuesta["campo"] = "alu_nombre";
         break;
      case "apellido":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Apellidos";
         $respuesta["campo"] = "alu_apellido";
         break;
      case "fecha_nacimiento":
         $respuesta["anchos"] = "20";
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
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Nacionalidad";
         $respuesta["campo"] = "alu_nacionalidad";
         break;
      case "religion":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Religion";
         $respuesta["campo"] = "alu_religion";
         break;
      case "idioma":
         $respuesta["anchos"] = "20";
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
         $respuesta["anchos"] = "35";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Alergico a";
         $respuesta["campo"] = "alu_alergico_a";
         break;
      case "emergencia":
         $respuesta["anchos"] = "35";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Emergencia avisar a";
         $respuesta["campo"] = "alu_emergencia";
         break;
      case "emertel":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Teléfono Emergencia";
         $respuesta["campo"] = "alu_emergencia_telefono";
         break;
      case "mail":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Email (Alumno)";
         $respuesta["campo"] = "alu_mail";
         break;
      case "nit":
         $respuesta["anchos"] = "15";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "NIT";
         $respuesta["campo"] = "alu_nit";
         break;
      case "cliente":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Cliente";
         $respuesta["campo"] = "alu_cliente_nombre";
         break;
      case "recoge":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Recoge";
         $respuesta["campo"] = "alu_recoge";
         break;
      case "redes_sociales":
         $respuesta["anchos"] = "15";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Redes Sociales";
         $respuesta["campo"] = "alu_redes_sociales";
         break;
      case "nivel":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Nivel";
         $respuesta["campo"] = "vgra_nivel_descripcion";
         break;
      case "grado":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Grado";
         $respuesta["campo"] = "vgra_grado_descripcion";
         break;
      case "seccion":
         $respuesta["anchos"] = "15";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Sección";
         $respuesta["campo"] = "vsec_seccion_descripcion";
         break;
      case "seguro":
         $respuesta["anchos"] = "15";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Seguro";
         $respuesta["campo"] = "seg_tiene_seguro";
         break;
      case "poliza":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "No. Poliza";
         $respuesta["campo"] = "seg_poliza";
         break;
      case "aseguradora":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Aseguradora";
         $respuesta["campo"] = "seg_aseguradora";
         break;
      case "plan":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Plan";
         $respuesta["campo"] = "seg_plan";
         break;
      case "asegurado":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Asegurado Principal";
         $respuesta["campo"] = "seg_asegurado_principal";
         break;
      case "instrucciones":
         $respuesta["anchos"] = "60";
         $respuesta["alineaciones"] = "J";
         $respuesta["titulos"] = "Instruciones";
         $respuesta["campo"] = "seg_instrucciones";
         break;
      case "comentarios":
         $respuesta["anchos"] = "60";
         $respuesta["alineaciones"] = "J";
         $respuesta["titulos"] = "Comentarios";
         $respuesta["campo"] = "seg_comentarios";
         break;
      case "situacion":
         $respuesta["anchos"] = "13";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Situación";
         $respuesta["campo"] = "alu_situacion";
         break;
      ///////////////// PADRE /////////////////////
      case "padre_cui":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "ID Padre";
         $respuesta["campo"] = "padre_dpi";
         break;
      case "padre_tipo_dpi":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Tipod de ID";
         $respuesta["campo"] = "pad_tipo_dpi";
         break;
      case "padre_nombre":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Nombres (Padre)";
         $respuesta["campo"] = "padre_nombre";
         break;
      case "padre_apellido":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Apellidos (Padre)";
         $respuesta["campo"] = "padre_apellido";
         break;
      case "padre_fecha_nacimiento":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Fecha Nac. (Padre)";
         $respuesta["campo"] = "padre_fecha_nacimiento";
         break;
      case "padre_edad":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Edad (Padre)";
         $respuesta["campo"] = "padre_fecha_nacimiento";
         break;
      case "padre_estado_civil":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Estado Civil (Padre)";
         $respuesta["campo"] = "padre_estado_civil";
         break;
      case "nacionalidad":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Nacionalidad (Padre)";
         $respuesta["campo"] = "padre_nacionalidad";
         break;
      case "padre_telefono":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Teléfono (Padre)";
         $respuesta["campo"] = "padre_telefono";
         break;
      case "padre_celular":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Celular (Padre)";
         $respuesta["campo"] = "padre_celular";
         break;
      case "padre_mail":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Email (Padre)";
         $respuesta["campo"] = "padre_mail";
         break;
      case "padre_direccion":
         $respuesta["anchos"] = "60";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Dirección (Padre)";
         $respuesta["campo"] = "padre_direccion";
         break;
      case "padre_lugar_trabajo":
         $respuesta["anchos"] = "40";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Lugar de Trabajo";
         $respuesta["campo"] = "padre_lugar_trabajo";
         break;
      case "padre_telefono_trabajo":
         $respuesta["anchos"] = "15";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Tel.Trabajo";
         $respuesta["campo"] = "padre_telefono_trabajo";
         break;
      case "padre_profesion":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Profesión (Padre)";
         $respuesta["campo"] = "padre_profesion";
         break;
      ///////////////// MADRE /////////////////////
      case "madre_cui":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "ID Madre";
         $respuesta["campo"] = "madre_dpi";
         break;
      case "madre_tipo_dpi":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Tipod de ID";
         $respuesta["campo"] = "pad_tipo_dpi";
         break;
      case "madre_nombre":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Nombres (Madre)";
         $respuesta["campo"] = "madre_nombre";
         break;
      case "madre_apellido":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Apellidos (Madre)";
         $respuesta["campo"] = "madre_apellido";
         break;
      case "madre_fecha_nacimiento":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Fecha Nac. (Madre)";
         $respuesta["campo"] = "madre_fecha_nacimiento";
         break;
      case "madre_edad":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Edad (Madre)";
         $respuesta["campo"] = "madre_fecha_nacimiento";
         break;
      case "madre_estado_civil":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Estado Civil (Madre)";
         $respuesta["campo"] = "madre_estado_civil";
         break;
      case "nacionalidad":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Nacionalidad (Madre)";
         $respuesta["campo"] = "madre_nacionalidad";
         break;
      case "madre_telefono":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Teléfono (Madre)";
         $respuesta["campo"] = "madre_telefono";
         break;
      case "madre_celular":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Celular (Madre)";
         $respuesta["campo"] = "madre_celular";
         break;
      case "madre_mail":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Email (Madre)";
         $respuesta["campo"] = "madre_mail";
         break;
      case "madre_direccion":
         $respuesta["anchos"] = "60";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Dirección (Madre)";
         $respuesta["campo"] = "madre_direccion";
         break;
      case "madre_lugar_trabajo":
         $respuesta["anchos"] = "40";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Lugar de Trabajo";
         $respuesta["campo"] = "madre_lugar_trabajo";
         break;
      case "madre_telefono_trabajo":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Tel.Trabajo";
         $respuesta["campo"] = "madre_telefono_trabajo";
         break;
      case "madre_profesion":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Profesión (Madre)";
         $respuesta["campo"] = "madre_profesion";
         break;
      ///////////////// MADRE /////////////////////
      case "encargado_cui":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "ID Encargado";
         $respuesta["campo"] = "encargado_dpi";
         break;
      case "encargado_tipo_dpi":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Tipod de ID";
         $respuesta["campo"] = "pad_tipo_dpi";
         break;
      case "encargado_nombre":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Nombres (Encargado)";
         $respuesta["campo"] = "encargado_nombre";
         break;
      case "encargado_apellido":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Apellidos (Encargado)";
         $respuesta["campo"] = "encargado_apellido";
         break;
      case "encargado_parentesco":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Parentesco";
         $respuesta["campo"] = "encargado_parentesco";
         break;
      case "encargado_fecha_nacimiento":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Fecha Nac.";
         $respuesta["campo"] = "encargado_fecha_nacimiento";
         break;
      case "encargado_edad":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Edad";
         $respuesta["campo"] = "encargado_fecha_nacimiento";
         break;
      case "encargado_estado_civil":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Estado Civil (Encargado)";
         $respuesta["campo"] = "encargado_estado_civil";
         break;
      case "nacionalidad":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Nacionalidad (Encargado)";
         $respuesta["campo"] = "encargado_nacionalidad";
         break;
      case "encargado_telefono":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Teléfono (Encargado)";
         $respuesta["campo"] = "encargado_telefono";
         break;
      case "encargado_celular":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Celular (Encargado)";
         $respuesta["campo"] = "encargado_celular";
         break;
      case "encargado_mail":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Email (Encargado)";
         $respuesta["campo"] = "encargado_mail";
         break;
      case "encargado_direccion":
         $respuesta["anchos"] = "60";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Dirección (Encargado)";
         $respuesta["campo"] = "encargado_direccion";
         break;
      case "encargado_lugar_trabajo":
         $respuesta["anchos"] = "40";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Lugar de Trabajo";
         $respuesta["campo"] = "encargado_lugar_trabajo";
         break;
      case "encargado_telefono_trabajo":
         $respuesta["anchos"] = "20";
         $respuesta["alineaciones"] = "C";
         $respuesta["titulos"] = "Tel.Trabajo";
         $respuesta["campo"] = "encargado_telefono_trabajo";
         break;
      case "encargado_profesion":
         $respuesta["anchos"] = "30";
         $respuesta["alineaciones"] = "L";
         $respuesta["titulos"] = "Profesión (Encargado)";
         $respuesta["campo"] = "encargado_profesion";
         break;
   }	
   return $respuesta;
}

?>