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
    //$_POST
	$cue = $_REQUEST["cue"];
	$ban = $_REQUEST["ban"];
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	$sit = $_REQUEST["sit"];
	//--
	
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_cuenta_banco($cue,$ban);
	
	if(is_array($result)){
		foreach($result as $row){
			$num = trim($row["cueb_ncuenta"]);
			$nom = trim($row["cueb_nombre"]);
			$bann = trim($row["ban_desc_ct"]);
		}	
	}	
	
	$titulo = "Reporte de Cheques de la Cuenta No. $num ($nom) del Banco $bann, del $desde al $hasta";
	

$title = "Reporte de Cheques";
$file_desc = "Listado exportado a Excel";

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator($nombre_usu)
							 ->setLastModifiedBy($nombre_usu)
							 ->setTitle($title)
							 ->setSubject("Nomina en Excel Office 2007 XLSX")
							 ->setDescription($file_desc)
							 ->setKeywords("ASMS LMS")
							 ->setCategory($file_desc);
                             
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
    
    /// Combinacion de Celdas (Merge cells)
    $objPHPExcel->getActiveSheet()->mergeCells('C1:G1');
    $objPHPExcel->getActiveSheet()->mergeCells('C2:G2');
    $objPHPExcel->getActiveSheet()->mergeCells('C3:G3');
    $objPHPExcel->getActiveSheet()->mergeCells('C4:G4');
    $objPHPExcel->getActiveSheet()->mergeCells('C5:G5');
    
    //Seteo de Titulos
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C1', $titulo)
            ->setCellValue('C2',  $colegio)
            ->setCellValue('C3', 'Generado por: '.$nombre_usu)
            ->setCellValue('C4', 'Fecha/Hora de generación: '.date("d/m/Y H:i"));
            
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
    $objPHPExcel->getActiveSheet()->setCellValue('B6', "MONTO");
    $objPHPExcel->getActiveSheet()->setCellValue('C6', "MONEDA");
    $objPHPExcel->getActiveSheet()->setCellValue('D6', "FECHA");
    $objPHPExcel->getActiveSheet()->setCellValue('E6', "A NOMBRE DE QUIEN");
	$objPHPExcel->getActiveSheet()->setCellValue('F6', "CONCEPTO/MOTIVO");
	$objPHPExcel->getActiveSheet()->setCellValue('G6', "SITUACION");
    //--
    $objPHPExcel->getActiveSheet()->getStyle("A6:G6")->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("A6:G6")->getFont()->setSize($fontsize*2); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("A6:G6")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle("A6:G6")->getFill()->getStartColor()->setARGB('C4C4C4');
    $objPHPExcel->getActiveSheet()->getStyle("A6:G6")->getFont()->setBold(true); /// Asigna negrita
    $objPHPExcel->getActiveSheet()->getStyle("A6:G6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
    //--
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(60);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(80);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
    /////////////////////////////        
	$linea_inicial = 6;
    $linea = 7;
    $i=1;
	$result = $ClsBan->get_cheque('',$cue,$ban,'','',$desde,$hasta,$sit);
	if(is_array($result)){
		foreach($result as $row){
			//No.
			$objPHPExcel->getActiveSheet()->setCellValue("A$linea", $i);
			
			$cod = trim($row["suc_id"]);
			$codigo = "# ".Agrega_Ceros($cod);
			//monto
			$monto = number_format($row["che_monto"],2, '.', '');
			$objPHPExcel->getActiveSheet()->setCellValue("B$linea", $monto);
            $objPHPExcel->getActiveSheet()->getStyle("B$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//moneda
			$moneda = $row["mon_desc"];
			$objPHPExcel->getActiveSheet()->setCellValue("C$linea", $moneda);
			//fecha
			$fecha = $row["che_fechor"];
			$fecha = $ClsBan->cambia_fechaHora($fecha);
			$objPHPExcel->getActiveSheet()->setCellValue("D$linea", $fecha);
			//quien
			$quien = trim($row["che_quien"]);
			$objPHPExcel->getActiveSheet()->setCellValue("E$linea", $quien);
			//concepto
			$concepto = trim($row["che_concepto"]);
			$objPHPExcel->getActiveSheet()->setCellValue("F$linea", $concepto);
			//situacion
			$sit = $row["che_situacion"];
			switch($sit){
				case 1: $sitdesc = "En Circulación"; break;
				case 2: $sitdesc = "Cheque Pagado"; break;
				case 0: $sitdesc = "Cheque Anulado"; break;
			}
			$objPHPExcel->getActiveSheet()->setCellValue("G$linea", $sitdesc);
			///--
			$linea++;
			$i++;
		}
        $linea--;
            
	}else{
		
	}
    
    // - ESTILOS DEL CUERPO DE LA TABLA - //
    // Alineacion
    $objPHPExcel->getActiveSheet()->getStyle("A$linea_inicial:A$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("B$linea_inicial:B$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("C$linea_inicial:C$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("G$linea_inicial:G$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
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
    $celda_final = "G".$linea;
    $objPHPExcel->getActiveSheet()->getStyle("A6:G6")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("$celda_inicial:$celda_final")->applyFromArray($styleThinBlackBorderOutline);


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle($title);

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
$objWriter->save("temp/$title.xlsx");
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

$excel = "temp/$title.xlsx";
header ("Content-Disposition: attachment; filename=Reporte_Cheques.xlsx");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($excel));
readfile($excel);

unlink($excel);

?>