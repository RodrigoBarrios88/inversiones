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
	$anio = $_REQUEST["anio"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$mes_reporte = 13; /// cartera trae todo el año
	$periodo = $_REQUEST["periodo"];
	//--
	
	$ClsDiv = new ClsDivision();
	$result = $ClsDiv->get_division($division,$grupo);
	if(is_array($result)){
		foreach($result as $row){
			$division_desc = utf8_decode($row["div_nombre"]);
			$grupo_desc = utf8_decode($row["gru_nombre"]);
		}
	}
    
    if($anio != "" && $periodo != ""){
		$periodo = $_REQUEST["periodo"];
		$anio = "";
	}

$titulo = "Reporte de Cartera";
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
    $objPHPExcel->getActiveSheet()->mergeCells('B2:Q2');
    $objPHPExcel->getActiveSheet()->mergeCells('B3:Q3');
    $objPHPExcel->getActiveSheet()->mergeCells('B4:Q4');
    $objPHPExcel->getActiveSheet()->mergeCells('B5:Q5');
	//--
	$objPHPExcel->getActiveSheet()->mergeCells('C6:D6');
	$objPHPExcel->getActiveSheet()->mergeCells('E6:F6');
	$objPHPExcel->getActiveSheet()->mergeCells('G6:Q6');
	$objPHPExcel->getActiveSheet()->mergeCells('C7:Q7');
    
    //Seteo de Titulos
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', $colegio)
            ->setCellValue('B3', $direccion)
            ->setCellValue('B4', $departamento.", ".$municipio)
			->setCellValue('B5', $pensum_desc)
			->setCellValue('B6', "Grupo de Boletas:")
			->setCellValue('C6', $grupo_desc)
			->setCellValue('E6', "División de Boletas:")
			->setCellValue('G6', "$division_desc")
			->setCellValue('B7', "Periodo:")
			->setCellValue('C7', " Reporte $longitud");
            
    ///// ESTILOS        
    $objPHPExcel->getActiveSheet()->getStyle("B2:Q7")->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("B2:Q7")->getFont()->setSize(10); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setSize(14); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true); /// Asigna negrita
    $objPHPExcel->getActiveSheet()->getStyle("B2")->getFill()->getStartColor()->setARGB('C4C4C4');
	
	$objPHPExcel->getActiveSheet()->getStyle("B2:Q5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
    
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
    $objPHPExcel->getActiveSheet()->setCellValue('C9', "CUI");
    $objPHPExcel->getActiveSheet()->setCellValue('D9', "Alumno");
    $objPHPExcel->getActiveSheet()->setCellValue('E9', "Grado");
	$objPHPExcel->getActiveSheet()->setCellValue('F9', "ENERO");
	$objPHPExcel->getActiveSheet()->setCellValue('G9', "FEBRERO");
	$objPHPExcel->getActiveSheet()->setCellValue('H9', "MARZO");
	$objPHPExcel->getActiveSheet()->setCellValue('I9', "ABRIL");
	$objPHPExcel->getActiveSheet()->setCellValue('J9', "MAYO");
	$objPHPExcel->getActiveSheet()->setCellValue('K9', "JUNIO");
	$objPHPExcel->getActiveSheet()->setCellValue('L9', "JULIO");
	$objPHPExcel->getActiveSheet()->setCellValue('M9', "AGOSTO");
	$objPHPExcel->getActiveSheet()->setCellValue('N9', "SEPTIEMBRE");
	$objPHPExcel->getActiveSheet()->setCellValue('O9', "OCTUBRE");
	$objPHPExcel->getActiveSheet()->setCellValue('P9', "NOVIEMBRE");
	$objPHPExcel->getActiveSheet()->setCellValue('Q9', "DICIEMBRE");
	//--
    $objPHPExcel->getActiveSheet()->getStyle("B9:Q9")->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("B9:Q9")->getFont()->setSize(11); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B9:Q9")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle("B9:Q9")->getFill()->getStartColor()->setARGB('C4C4C4');
    $objPHPExcel->getActiveSheet()->getStyle("B9:Q9")->getFont()->setBold(true); /// Asigna negrita
    $objPHPExcel->getActiveSheet()->getStyle("B9:Q9")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
	$objPHPExcel->getActiveSheet()->getStyle("B6:Q9")->getFont()->setBold(true); /// Asigna negrita
	$objPHPExcel->getActiveSheet()->getStyle("E6")->getFont()->setBold(true); /// Asigna negrita
    //--
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
    /////////////////////////////        
	$linea_inicial = 9;
    $linea = 10;
    $i=1;
	$ClsBol = new ClsBoletaCobro();
    $ClsIns = new ClsInscripcion();
	$ClsPen = new ClsPensum();
    $ClsPer = new ClsPeriodoFiscal();
	if($periodo != "" && $anio == ""){
		$pensum = $ClsPer->get_pensum_periodo($periodo);
	}else if($anio != ""){
		$pensum = $ClsPen->get_pensum_anio($anio);	
	}else{
		$pensum = $_SESSION["pensum"];
	}
	$result = $ClsBol->get_cartera($division,$grupo,$tipo,$anio,$periodo,$mes_reporte,$pensum,$nivel,$grado,$seccion);
    if(is_array($result)){
		foreach($result as $row){
			//No.
			$objPHPExcel->getActiveSheet()->setCellValue("B$linea", $i);
			//cui
			$cui = $row["alu_cui"];
			$objPHPExcel->getActiveSheet()->setCellValue("C$linea", $cui);
			$objPHPExcel->getActiveSheet()->getStyle("C$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			//nombre
			$nom = trim($row["alu_nombre"]);
			$ape = trim($row["alu_apellido"]);
			$nombre = "$nom $ape";
			$objPHPExcel->getActiveSheet()->setCellValue("D$linea", $nombre);
			//grado
			$grado = utf8_decode($row["gra_descripcion"]);
			$seccion = utf8_decode($row["sec_descripcion"]);
			$objPHPExcel->getActiveSheet()->setCellValue("E$linea", $grado." ".$seccion);
			//mes
			$cargo = $row["cargos_enero"];
			$pago = $row["pagos_enero"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
			}else{
				$saldo = $saldo;	
			}
			$saldo = ($saldo != "")?number_format($saldo,2,'.',''):$saldo;
			$objPHPExcel->getActiveSheet()->setCellValue("F$linea", $saldo);
			$objPHPExcel->getActiveSheet()->getStyle("F$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//mes
			$cargo = $row["cargos_febrero"];;
			$pago = $row["pagos_febrero"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
			}else{
				$saldo = $saldo;	
			}
			$saldo = ($saldo != "")?number_format($saldo,2,'.',''):$saldo;
			$objPHPExcel->getActiveSheet()->setCellValue("G$linea", $saldo);
			$objPHPExcel->getActiveSheet()->getStyle("G$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//mes
			$cargo = $row["cargos_marzo"];
			$pago = $row["pagos_marzo"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
			}else{
				$saldo = $saldo;	
			}
			$saldo = ($saldo != "")?number_format($saldo,2,'.',''):$saldo;
			$objPHPExcel->getActiveSheet()->setCellValue("H$linea", $saldo);
			$objPHPExcel->getActiveSheet()->getStyle("H$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//mes
			$cargo = $row["cargos_abril"];
			$pago = $row["pagos_abril"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
			}else{
				$saldo = $saldo;	
			}
			$objPHPExcel->getActiveSheet()->setCellValue("I$linea", $saldo);
			$objPHPExcel->getActiveSheet()->getStyle("I$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//mes
			$cargo = $row["cargos_mayo"];
			$pago = $row["pagos_mayo"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
			}else{
				$saldo = $saldo;	
			}
			$saldo = ($saldo != "")?number_format($saldo,2,'.',''):$saldo;
			$objPHPExcel->getActiveSheet()->setCellValue("J$linea", $saldo);
			$objPHPExcel->getActiveSheet()->getStyle("J$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//mes
			$cargo = $row["cargos_junio"];
			$pago = $row["pagos_junio"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
			}else{
				$saldo = $saldo;	
			}
			$saldo = ($saldo != "")?number_format($saldo,2,'.',''):$saldo;
			$objPHPExcel->getActiveSheet()->setCellValue("K$linea", $saldo);
			$objPHPExcel->getActiveSheet()->getStyle("K$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//mes
			$cargo = $row["cargos_julio"];
			$pago = $row["pagos_julio"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
			}else{
				$saldo = $saldo;	
			}
			$saldo = ($saldo != "")?number_format($saldo,2,'.',''):$saldo;
			$objPHPExcel->getActiveSheet()->setCellValue("L$linea", $saldo);
			$objPHPExcel->getActiveSheet()->getStyle("L$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//mes
			$cargo = $row["cargos_agosto"];
			$pago = $row["pagos_agosto"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
			}else{
				$saldo = $saldo;	
			}
			$saldo = ($saldo != "")?number_format($saldo,2,'.',''):$saldo;
			$objPHPExcel->getActiveSheet()->setCellValue("M$linea", $saldo);
			$objPHPExcel->getActiveSheet()->getStyle("M$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//mes
			$cargo = $row["cargos_septiembre"];
			$pago = $row["pagos_septiembre"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
			}else{
				$saldo = $saldo;	
			}
			$saldo = ($saldo != "")?number_format($saldo,2,'.',''):$saldo;
			$objPHPExcel->getActiveSheet()->setCellValue("N$linea", $saldo);
			$objPHPExcel->getActiveSheet()->getStyle("N$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//mes
			$cargo = $row["cargos_octubre"];
			$pago = $row["pagos_octubre"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
			}else{
				$saldo = $saldo;	
			}
			$saldo = ($saldo != "")?number_format($saldo,2,'.',''):$saldo;
			$objPHPExcel->getActiveSheet()->setCellValue("O$linea", $saldo);
			$objPHPExcel->getActiveSheet()->getStyle("O$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//mes
			$cargo = $row["cargos_noviembre"];
			$pago = $row["pagos_noviembre"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
			}else{
				$saldo = $saldo;	
			}
			$saldo = ($saldo != "")?number_format($saldo,2,'.',''):$saldo;
			$objPHPExcel->getActiveSheet()->setCellValue("P$linea", $saldo);
			$objPHPExcel->getActiveSheet()->getStyle("P$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//mes
			$cargo = $row["cargos_diciembre"];
			$pago = $row["pagos_diciembre"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
			}else{
				$saldo = $saldo;	
			}
			$saldo = ($saldo != "")?number_format($saldo,2,'.',''):$saldo;
			$objPHPExcel->getActiveSheet()->setCellValue("Q$linea", $saldo);
			$objPHPExcel->getActiveSheet()->getStyle("Q$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			///--
			$linea++;
			$i++;
		}
    }
	// - ESTILOS DEL CUERPO DE LA TABLA - //
    // Alineacion
    $objPHPExcel->getActiveSheet()->getStyle("B$linea_inicial:B$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("C$linea_inicial:C$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("E$linea_inicial:E$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("F$linea_inicial:F$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:G$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:H$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("I$linea_inicial:I$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("J$linea_inicial:J$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("K$linea_inicial:K$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:L$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:M$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:N$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:O$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:P$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:Q$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


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
header ("Content-Disposition: attachment; filename=Reporte_Cartera.xlsx");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($excel));
readfile($excel);

unlink($excel);

?>