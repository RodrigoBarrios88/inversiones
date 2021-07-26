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

/** Error reporting */
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('America/Guatemala');

/** Include PHPExcel */
require_once '../../Clases/PHPExcel.php';
//incluye las librerias y Clases del Proyecto
include_once('html_fns_reportes.php');
    $nombre_usu = $_SESSION["nombre"];
    $colegio = $_SESSION["colegio_nombre_reporte"];
    $usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$tipo = $_REQUEST["tipo"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//--
	$ClsAsist = new ClsAsistencia();
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	//_$POST  //recibe el codigo de horario
	$hashkey1 = $_REQUEST["hashkey1"];
	$hashkey2 = $_REQUEST["hashkey2"];
	$materia = $_REQUEST["materia"];
	$horario = $ClsAsist->decrypt($hashkey1, $usuario);
	$fecha = $ClsAsist->decrypt($hashkey2, $usuario);
	$result = $ClsPen->get_seccion($pensum,$nivel,$grado,$seccion,$tipo);
    if(is_array($result)){
		foreach($result as $row){
            $nivel_desc = $row["niv_descripcion"];
            $grado_desc = $row["gra_descripcion"]." Sección ".$row["sec_descripcion"];
        }
    }  
	$result = $ClsAsist->get_horario_asistencia_seccion($horario,$fecha,$pensum,$nivel,$grado,$seccion);
	if(is_array($result)){
		foreach($result as $row){
			$nivel = $row["hor_nivel"];
			$grado = $row["hor_grado"];
			$seccion = $row["hor_seccion"];
			$dia = $row["hor_dia"];
			$ini = $row["per_hini"];
			$fin = $row["per_hfin"];
			$hora = "$ini - $fin";
			//---
			$grado_desc = utf8_decode($row["gra_descripcion"]);
			$seccion_desc = utf8_decode($row["sec_descripcion"]);
		}
	}

$titulo = "Listado de Alumnos por Sección";
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
            ->setCellValue('C1', 'Listado de Asistencia por Sección')
            ->setCellValue('C2',  $colegio)
            ->setCellValue('C3', 'Nivel: '.$nivel_desc)
            ->setCellValue('C4', 'Grado: '.$grado_desc);
            
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
    $objPHPExcel->getActiveSheet()->setCellValue('A6', "No.");
    $objPHPExcel->getActiveSheet()->setCellValue('B6', "CUI");
    $objPHPExcel->getActiveSheet()->setCellValue('C6', "Alumno");
    $objPHPExcel->getActiveSheet()->setCellValue('D6', "Grado y Sección");
    $objPHPExcel->getActiveSheet()->setCellValue('E6', "Materia");
    $objPHPExcel->getActiveSheet()->setCellValue('F6', "Asistencia");
    $objPHPExcel->getActiveSheet()->setCellValue('G6', "Comentario");
    $objPHPExcel->getActiveSheet()->setCellValue('H6', "Fecha");
    //--
    $objPHPExcel->getActiveSheet()->getStyle("A6:H6")->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("A6:H6")->getFont()->setSize($fontsize*2); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("A6:H6")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle("A6:H6")->getFill()->getStartColor()->setARGB('C4C4C4');
    $objPHPExcel->getActiveSheet()->getStyle("A6:H6")->getFont()->setBold(true); /// Asigna negrita
    $objPHPExcel->getActiveSheet()->getStyle("A6:H6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
    //--
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(60);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
    /////////////////////////////        
	$linea_inicial = 6;
    $linea = 7;
    $i=1;
    
    	$result = $ClsAsist->get_asistencia($horario,$fecha);
    	if(is_array($result)){
    		foreach($result as $row){
    			//No.
    			$objPHPExcel->getActiveSheet()->setCellValue("A$linea", $i);
    			//cui
    			$cui = $row["alu_cui"];
    			$objPHPExcel->getActiveSheet()->setCellValue("B$linea", $cui);
                $objPHPExcel->getActiveSheet()->getStyle("B$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    			//nombre
    			$nombre = trim($row["alu_nombre"]);
    			$apellido = trim($row["alu_apellido"]);
    			$nombres = $apellido.", ".$nombre;
    			$objPHPExcel->getActiveSheet()->setCellValue("C$linea", $nombres);
    			//grado y seccion;
    			$objPHPExcel->getActiveSheet()->setCellValue("D$linea", $grado_desc." ".$seccion_desc);
    			//materia
    			$objPHPExcel->getActiveSheet()->setCellValue("E$linea", $materia);
    			//asistencia
    			$sit = $row["asi_asistencia"];
    			$status = ($sit == 1)?"PRESENTE":"AUSENTE";
    			$objPHPExcel->getActiveSheet()->setCellValue("F$linea", $status);
    			//comentario
    			$comentario = $row["asi_comentario"];
    			$objPHPExcel->getActiveSheet()->setCellValue("G$linea", $comentario);
    			//fecha
    			$objPHPExcel->getActiveSheet()->setCellValue("H$linea", $fecha."  ".$ini."-".$fin);
                ///--
    			$linea++;
    			$i++;
    		}
            $linea--;
                
    	}
		
    
    
    // - ESTILOS DEL CUERPO DE LA TABLA - //
    // Alineacion
    $objPHPExcel->getActiveSheet()->getStyle("A$linea_inicial:A$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("B$linea_inicial:B$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
     
    // recuadro de columnas
    $styleThinBlackBorderOutline = array(
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
            ),
        ),
    );
    $objPHPExcel->getActiveSheet()->getStyle("A$linea_inicial:A$linea")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("B$linea_inicial:B$linea")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("C$linea_inicial:C$linea")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("D$linea_inicial:D$linea")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("E$linea_inicial:E$linea")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("F$linea_inicial:F$linea")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("G$linea_inicial:G$linea")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:H$linea")->applyFromArray($styleThinBlackBorderOutline);
    
    // Pone el Recuadro sobre la tabla
    $styleThinBlackBorderOutline = array(
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THICK,
                'color' => array('argb' => 'FF000000'),
            ),
        ),
    );
    $celda_inicial = "A".$linea_inicial;
    $celda_final = "H".$linea;
    $objPHPExcel->getActiveSheet()->getStyle("A6:H6")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("$celda_inicial:$celda_final")->applyFromArray($styleThinBlackBorderOutline);


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
header ("Content-Disposition: attachment; filename=Listado_asistencia_por_seccion.xlsx");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($excel));
readfile($excel);

unlink($excel);

?>