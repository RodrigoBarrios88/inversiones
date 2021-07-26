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
	$direccion = $_SESSION["colegio_direccion"];
	$departamento = $_SESSION["colegio_departamento"];
	$municipio = $_SESSION["colegio_municipio"];
    //$_POST
	$division = $_REQUEST["division"];
	$grupo = $_REQUEST["grupo"];
	$tipo = $_REQUEST["tipo"];
	$periodo = $_REQUEST["periodo"];
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	//--
	
	$ClsDiv = new ClsDivision();
	$result = $ClsDiv->get_division($division,$grupo);
	if(is_array($result)){
		foreach($result as $row){
			$division_desc = utf8_decode($row["div_nombre"]);
			$grupo_desc = utf8_decode($row["gru_nombre"]);
		}
	}

$titulo = "Reporte de Boletas";
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
    $objPHPExcel->getActiveSheet()->mergeCells('B2:J2');
    $objPHPExcel->getActiveSheet()->mergeCells('B3:J3');
    $objPHPExcel->getActiveSheet()->mergeCells('B4:J4');
    $objPHPExcel->getActiveSheet()->mergeCells('B5:J5');
	//--
	$objPHPExcel->getActiveSheet()->mergeCells('C6:D6');
	$objPHPExcel->getActiveSheet()->mergeCells('E6:F6');
	$objPHPExcel->getActiveSheet()->mergeCells('G6:J6');
	$objPHPExcel->getActiveSheet()->mergeCells('C7:J7');
    
    //Seteo de Titulos
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', $colegio)
            ->setCellValue('B3', $direccion)
            ->setCellValue('B4', $departamento.", ".$municipio)
			->setCellValue('B5', $pensum_desc)
			->setCellValue('B6', "Grupo:")
			->setCellValue('C6', $grupo_desc)
			->setCellValue('E6', "División:")
			->setCellValue('G6', "$division_desc")
			->setCellValue('B7', "Periodo:")
			->setCellValue('C7', "Del $desde al $hasta");
            
    ///// ESTILOS        
    $objPHPExcel->getActiveSheet()->getStyle("B2:K7")->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("B2:K7")->getFont()->setSize(10); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setSize(14); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true); /// Asigna negrita
    $objPHPExcel->getActiveSheet()->getStyle("B2")->getFill()->getStartColor()->setARGB('C4C4C4');
	
	$objPHPExcel->getActiveSheet()->getStyle("B2:K5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
    
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
    $objDrawing->setCoordinates('B1');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    
    ////// ENCABEZADOS /////
    $objPHPExcel->getActiveSheet()->setCellValue('B9', "No.");
    $objPHPExcel->getActiveSheet()->setCellValue('C9', "Alumno");
    $objPHPExcel->getActiveSheet()->setCellValue('D9', "Grado");
	$objPHPExcel->getActiveSheet()->setCellValue('E9', "CUI");
    $objPHPExcel->getActiveSheet()->setCellValue('F9', "Boleta");
	$objPHPExcel->getActiveSheet()->setCellValue('G9', "Referencia");
	$objPHPExcel->getActiveSheet()->setCellValue('H9', "Fecha");
	$objPHPExcel->getActiveSheet()->setCellValue('I9', "Mes");
	$objPHPExcel->getActiveSheet()->setCellValue('J9', "Motivo o Concepto");
	$objPHPExcel->getActiveSheet()->setCellValue('K9', "Monto");
	//--
    $objPHPExcel->getActiveSheet()->getStyle("B9:K9")->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("B9:K9")->getFont()->setSize(11); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B9:K9")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle("B9:K9")->getFill()->getStartColor()->setARGB('C4C4C4');
    $objPHPExcel->getActiveSheet()->getStyle("B9:K9")->getFont()->setBold(true); /// Asigna negrita
    $objPHPExcel->getActiveSheet()->getStyle("B9:K9")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
	$objPHPExcel->getActiveSheet()->getStyle("B6:B7")->getFont()->setBold(true); /// Asigna negrita
	$objPHPExcel->getActiveSheet()->getStyle("E6")->getFont()->setBold(true); /// Asigna negrita
    //--
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
	/////////////////////////////        
	$linea_inicial = 9;
    $linea = 10;
    $i=1;
	$ingresos = 0;
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_cobro('',$division,$grupo,'','',$periodo,'',$desde,$hasta,1,'','',$tipo);
	if(is_array($result)){
		foreach($result as $row){
            //No.
            $objPHPExcel->getActiveSheet()->setCellValue("B$linea", $i);
            //nombre
            $nombre = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
            $objPHPExcel->getActiveSheet()->setCellValue("C$linea", $nombre);
            //grado
            $grado = trim($row["alu_grado_descripcion"]);
            $seccion = trim($row["alu_seccion_descripcion"]);
            $objPHPExcel->getActiveSheet()->setCellValue("D$linea", $grado.' '.$seccion);
            //cui
            $cui = $row["bol_alumno"];
            $objPHPExcel->getActiveSheet()->setCellValue("E$linea", $cui);
            $objPHPExcel->getActiveSheet()->getStyle("E$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            //boleta
            $boleta = $row["bol_codigo"];
            $objPHPExcel->getActiveSheet()->setCellValue("F$linea", $boleta);
            //referencia
            $referencia = $row["bol_referencia"];
            $objPHPExcel->getActiveSheet()->setCellValue("G$linea", $referencia);
            //fecha
            $fecha = $row["bol_fecha_pago"];
            $fecha = cambia_fecha($fecha);
            $objPHPExcel->getActiveSheet()->setCellValue("H$linea", $fecha);
            //colegiatura
            $colegiatura = trim($row["bol_fecha_pago"]);
            $mes = substr($colegiatura,5,2);
            $mes = Meses_Letra($mes);
            $objPHPExcel->getActiveSheet()->setCellValue("I$linea", $mes);
            //concepto
            $motivo = trim($row["bol_motivo"]);
            $objPHPExcel->getActiveSheet()->setCellValue("J$linea", $motivo);
            //ingresos
            $monto = $row["bol_monto"];
            $monto = number_format($monto,2,'.','');
            $objPHPExcel->getActiveSheet()->setCellValue("K$linea", $monto);
            $objPHPExcel->getActiveSheet()->getStyle("K$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $ingresos+= $monto;
            ///--
            $linea++;
            $i++;
		}
    }
	//////---- SUMATORIAS O PIE DE TABLA
		//ingresos
			$ingresos = number_format($ingresos,2,'.',',');
			$objPHPExcel->getActiveSheet()->setCellValue("K$linea", $ingresos);
			$objPHPExcel->getActiveSheet()->getStyle("K$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//--
			$objPHPExcel->getActiveSheet()->getStyle("B$linea:K$linea")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyle("B$linea:K$linea")->getFill()->getStartColor()->setARGB('C4C4C4');
			$objPHPExcel->getActiveSheet()->getStyle("B$linea:K$linea")->getFont()->setBold(true); /// Asigna negrita
		///--
			
    // - ESTILOS DEL CUERPO DE LA TABLA - //
    // Alineacion
    $objPHPExcel->getActiveSheet()->getStyle("B$linea_inicial:B$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("E$linea_inicial:E$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("F$linea_inicial:F$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("G$linea_inicial:G$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:H$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("J$linea_inicial:J$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("K$linea_inicial:K$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 
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
    $celda_final = "K".$linea;
    $objPHPExcel->getActiveSheet()->getStyle("B9:K9")->applyFromArray($styleThinBlackBorderOutline);
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
header ("Content-Disposition: attachment; filename=Reporte_Boletas.xlsx");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($excel));
readfile($excel);

unlink($excel);

?>