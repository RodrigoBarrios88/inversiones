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
   
   ////////////////////////////////////// PARAMETROS ///////////////////////////////////////////
   $anchos[1] = 6;
   $alineaciones[1] = "C";
   $titulos[1] = "No.";
    $anchos[2] = 12;
   $alineaciones[2] = "C";
   $titulos[2] = "Alumno";
   $i = 3;
	$ancho_total = 6;
	    
	$ClsTar = new ClsTarea();
	$ClsAcad = new ClsAcademico();
	$ClsExa = new ClsExamen();
	$resultTarea = $ClsTar->get_tarea($cod,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,'','','','',$sit);
	$resultExa = $ClsExa->get_examen($cod,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,'','','','',$sit);
	$sit = 1;
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$sit);
	if(is_array($resultTarea)){
      foreach($resultTarea as $row){
         $anchos[$i] = 6;
         $alineaciones[$i] = "C";
         $titulos[$i] = utf8_decode($row["tar_nombre"]);
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
         ->setCellValue('C2',  $colegio)
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
   }	
   return $respuesta;
}

?>