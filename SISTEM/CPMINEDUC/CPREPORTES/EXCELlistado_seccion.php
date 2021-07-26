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
	$direccion = $_SESSION["colegio_direccion"];
	$departamento = $_SESSION["colegio_departamento"];
	$municipio = $_SESSION["colegio_municipio"];
    //$_POST
	$pensum = $_SESSION["pensum"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$tipo = $_REQUEST["tipo"];
    //--
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	//--
    $result = $ClsPen->get_seccion($pensum,$nivel,$grado,$seccion,$tipo);
    if(is_array($result)){
		foreach($result as $row){
            $nivel_desc = $row["niv_descripcion"];
            $grado_desc = $row["gra_descripcion"]." Sección ".$row["sec_descripcion"];
        }
    }    

$titulo = "Listado Auxiliar";
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
    $objPHPExcel->getActiveSheet()->mergeCells('B2:N2');
    $objPHPExcel->getActiveSheet()->mergeCells('B3:N3');
    $objPHPExcel->getActiveSheet()->mergeCells('B4:N4');
    $objPHPExcel->getActiveSheet()->mergeCells('B5:N5');
	//--
	$objPHPExcel->getActiveSheet()->mergeCells('C6:D6');
	$objPHPExcel->getActiveSheet()->mergeCells('E6:F6');
	$objPHPExcel->getActiveSheet()->mergeCells('G6:N6');
	$objPHPExcel->getActiveSheet()->mergeCells('C7:N7');
    
    //Seteo de Titulos
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', $colegio)
            ->setCellValue('B3', $direccion)
            ->setCellValue('B4', $departamento.", ".$municipio)
			->setCellValue('B5', $pensum_desc)
			->setCellValue('B6', "Materia:")
			->setCellValue('E6', "Maestro:")
			->setCellValue('B7', "Grado:")
			->setCellValue('C7', $grado_desc);
            
    ///// ESTILOS        
    $objPHPExcel->getActiveSheet()->getStyle("B2:N7")->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("B2:N7")->getFont()->setSize(10); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setSize(14); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true); /// Asigna negrita
    $objPHPExcel->getActiveSheet()->getStyle("B2")->getFill()->getStartColor()->setARGB('C4C4C4');
	
	$objPHPExcel->getActiveSheet()->getStyle("B2:N5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
    
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
    $objDrawing->setCoordinates('M3');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    
    ////// ENCABEZADOS /////
    $objPHPExcel->getActiveSheet()->setCellValue('B9', "No.");
    $objPHPExcel->getActiveSheet()->setCellValue('C9', "CUI");
    $objPHPExcel->getActiveSheet()->setCellValue('D9', "Alumno");
    $objPHPExcel->getActiveSheet()->setCellValue('E9', "1");
	$objPHPExcel->getActiveSheet()->setCellValue('F9', "2");
	$objPHPExcel->getActiveSheet()->setCellValue('G9', "3");
	$objPHPExcel->getActiveSheet()->setCellValue('H9', "4");
	$objPHPExcel->getActiveSheet()->setCellValue('I9', "5");
	$objPHPExcel->getActiveSheet()->setCellValue('J9', "6");
	$objPHPExcel->getActiveSheet()->setCellValue('K9', "Ap.Obs.");
	$objPHPExcel->getActiveSheet()->setCellValue('L9', "Actividades");
	$objPHPExcel->getActiveSheet()->setCellValue('M9', "Evaluación");
	$objPHPExcel->getActiveSheet()->setCellValue('N9', "Total");
    //--
    $objPHPExcel->getActiveSheet()->getStyle("B9:N9")->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("B9:N9")->getFont()->setSize($fontsize*2); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B9:N9")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle("B9:N9")->getFill()->getStartColor()->setARGB('C4C4C4');
    $objPHPExcel->getActiveSheet()->getStyle("B9:N9")->getFont()->setBold(true); /// Asigna negrita
    $objPHPExcel->getActiveSheet()->getStyle("B9:N9")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
	$objPHPExcel->getActiveSheet()->getStyle("B6:B7")->getFont()->setBold(true); /// Asigna negrita
	$objPHPExcel->getActiveSheet()->getStyle("E6")->getFont()->setBold(true); /// Asigna negrita
    //--
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
	/////////////////////////////        
	$linea_inicial = 9;
    $linea = 10;
    $i=1;
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	if(is_array($result)){
		foreach($result as $row){
			//No.
			$objPHPExcel->getActiveSheet()->setCellValue("B$linea", $i);
			//cui
			$cui = $row["alu_cui"];
			$objPHPExcel->getActiveSheet()->setCellValue("C$linea", $cui);
            $objPHPExcel->getActiveSheet()->getStyle("C$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			//nombre
			$nombre = trim($row["alu_nombre"]);
			$apellido = trim($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$objPHPExcel->getActiveSheet()->setCellValue("D$linea", $nombres);
			///--
			$linea++;
			$i++;
		}
        $linea--;
            
	}else{
		
	}
    
    // - ESTILOS DEL CUERPO DE LA TABLA - //
    // Alineacion
    $objPHPExcel->getActiveSheet()->getStyle("B$linea_inicial:B$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("C$linea_inicial:C$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
     
    // recuadro de columnas
    $styleThinBlackBorderOutline = array(
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
            ),
        ),
    );
    $objPHPExcel->getActiveSheet()->getStyle("B$linea_inicial:B$linea")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("C$linea_inicial:C$linea")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("D$linea_inicial:D$linea")->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle("E$linea_inicial:E$linea")->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle("F$linea_inicial:F$linea")->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle("G$linea_inicial:G$linea")->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:H$linea")->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle("I$linea_inicial:I$linea")->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle("J$linea_inicial:J$linea")->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle("K$linea_inicial:K$linea")->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle("L$linea_inicial:L$linea")->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle("M$linea_inicial:M$linea")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("N$linea_inicial:N$linea")->applyFromArray($styleThinBlackBorderOutline);
    
    // Pone el Recuadro sobre la tabla
    $styleThinBlackBorderOutline = array(
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THICK,
                'color' => array('argb' => 'FF000000'),
            ),
        ),
    );
    $celda_inicial = "B".$linea_inicial;
    $celda_final = "N".$linea;
    $objPHPExcel->getActiveSheet()->getStyle("B9:N9")->applyFromArray($styleThinBlackBorderOutline);
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
header ("Content-Disposition: attachment; filename=Listado_auxiliar_por_seccion.xlsx");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($excel));
readfile($excel);

unlink($excel);

?>