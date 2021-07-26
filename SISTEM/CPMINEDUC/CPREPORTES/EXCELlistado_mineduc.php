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
	$codigoMINEDUC = "00-18-8622-45";
	$direccion = $_SESSION["colegio_direccion"];
	$departamento = $_SESSION["colegio_departamento"];
	$municipio = $_SESSION["colegio_municipio"];
	$nivelMINEDUC = $_SESSION["mineduc_nivel"];
	$cicloMINEDUC = $_SESSION["mineduc_cliclo"];
	$modalidadMINEDUC = $_SESSION["mineduc_modalidad"];
	$jornadaMINEDUC = $_SESSION["mineduc_jornada"];
	$sectorMINEDUC = $_SESSION["mineduc_sector"];
	$areaMINEDUC = $_SESSION["mineduc_area"];
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
            $grado_desc = trim($row["gra_descripcion"]);
			$seccion_desc = $row["sec_descripcion"];
        }
    }    

$titulo = "Listado tipo MINEDUC";
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
	$objPHPExcel->getActiveSheet()->mergeCells('D2:H2');
    $objPHPExcel->getActiveSheet()->mergeCells('D3:H3');
    $objPHPExcel->getActiveSheet()->mergeCells('D4:H4');
    $objPHPExcel->getActiveSheet()->mergeCells('F5:H5');
    $objPHPExcel->getActiveSheet()->mergeCells('F6:H6');
    $objPHPExcel->getActiveSheet()->mergeCells('F7:H7');
	$objPHPExcel->getActiveSheet()->mergeCells('D6:D8');
	$objPHPExcel->getActiveSheet()->mergeCells('D9:D11');
    
    //Seteo de Titulos
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D2', 'LISTADO DE ALUMNOS INSCRITOS')
			->setCellValue('D3', '-Sistema de Registro Educativo-')
            ->setCellValue('D4',  "Fecha de impresion ".date("d/m/Y H:i:s"))
            ->setCellValue('E5', 'Código: ')
            ->setCellValue('E6', 'Nombre: ')
			->setCellValue('E7', 'Dirección: ')
			->setCellValue('E8', 'Departamento: ')
			->setCellValue('E9', 'Nivel: ')
			->setCellValue('E10', 'Ciclo Lectivo: ')
			->setCellValue('E11', 'Modalidad: ')
			->setCellValue('G8', 'Municipio: ')
			->setCellValue('G9', 'Jornada: ')
			->setCellValue('G10', 'Sector: ')
			->setCellValue('G11', 'Área: ')
			->setCellValue('F5', $codigoMINEDUC) ///// Inician las respuestas
			->setCellValue('F6', $colegio)
			->setCellValue('F7', $direccion) 
			->setCellValue('F8', $departamento)
			->setCellValue('F9', $nivelMINEDUC)
			->setCellValue('F10', $cicloMINEDUC)
			->setCellValue('F11', $modalidadMINEDUC)
			->setCellValue('H8', $municipio)
			->setCellValue('H9', $jornadaMINEDUC)
			->setCellValue('H10', $sectorMINEDUC)
			->setCellValue('H11', $areaMINEDUC);
			
	$objPHPExcel->getActiveSheet()->setCellValue('C13', "Grado:");
	$objPHPExcel->getActiveSheet()->setCellValue('D13', $grado_desc);
    $objPHPExcel->getActiveSheet()->setCellValue('G13', "Seccion:");
	$objPHPExcel->getActiveSheet()->setCellValue('H13', $seccion_desc);
	
	$objPHPExcel->getActiveSheet()->getStyle("D3:D4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
	        
    ///// ESTILOS        
    $objPHPExcel->getActiveSheet()->getStyle("D2:H11")->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("D4:H11")->getFont()->setSize(12); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("D2:D3")->getFont()->setSize(16); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("D2")->getFont()->setBold(true); /// Asigna negrita
   
    ///// LOGO
    $gdImage = imagecreatefromjpeg('../../../CONFIG/images/mineduc.jpg');
    // Add a drawing to the worksheet
    $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $objDrawing->setImageResource($gdImage);
    $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
    $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
    $objDrawing->setHeight(40);
    $objDrawing->setCoordinates('D6');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    ///// QR
    $gdImage = imagecreatefrompng('../../../CONFIG/images/QRmineduc.png');
    // Add a drawing to the worksheet
    $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
    $objDrawing->setName('QR');
    $objDrawing->setDescription('Codigo QR');
    $objDrawing->setImageResource($gdImage);
    $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
    $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
    $objDrawing->setHeight(100);
    $objDrawing->setCoordinates('D9');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	//--
	$objPHPExcel->getActiveSheet()->getStyle("D6:D11")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
	
    ////// ENCABEZADOS /////
    $objPHPExcel->getActiveSheet()->setCellValue('B15', "No.");
    $objPHPExcel->getActiveSheet()->setCellValue('C15', "Código Personal");
    $objPHPExcel->getActiveSheet()->setCellValue('D15', "Nombres");
    $objPHPExcel->getActiveSheet()->setCellValue('E15', "Apellidos");
    $objPHPExcel->getActiveSheet()->setCellValue('F15', "Fecha de Nacimiento");
    $objPHPExcel->getActiveSheet()->setCellValue('G15', "Nacionalidad");
	$objPHPExcel->getActiveSheet()->setCellValue('H15', "Doc. Identificación");
	$objPHPExcel->getActiveSheet()->setCellValue('I15', "No. de Documento");
    //--
    $objPHPExcel->getActiveSheet()->getStyle("B15:I15")->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("B15:I15")->getFont()->setSize($fontsize*2); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B15:I15")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle("B15:I15")->getFill()->getStartColor()->setARGB('C4C4C4');
    $objPHPExcel->getActiveSheet()->getStyle("B15:I15")->getFont()->setBold(true); /// Asigna negrita
    $objPHPExcel->getActiveSheet()->getStyle("B15:I15")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
    //--
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    /////////////////////////////        
	$linea_inicial = 15;
    $linea = 16;
    $i=1;
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	if(is_array($result)){
		foreach($result as $row){
			//No.
			$objPHPExcel->getActiveSheet()->setCellValue("B$linea", $i);
			//codigo MINEDUC
			$codigo = $row["alu_codigo_mineduc"];
			$objPHPExcel->getActiveSheet()->setCellValue("C$linea", $codigo);
			//nombre
			$nombre = trim($row["alu_nombre"]);
			$apellido = trim($row["alu_apellido"]);
			$objPHPExcel->getActiveSheet()->setCellValue("D$linea", $nombre);
			$objPHPExcel->getActiveSheet()->setCellValue("E$linea", $apellido);
			//fecha de nacimiento
			$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
			$objPHPExcel->getActiveSheet()->setCellValue("F$linea", $fecnac);
            $objPHPExcel->getActiveSheet()->getStyle("F$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
			//nacionalidad
			$nacionalidad = utf8_decode($row["alu_nacionalidad"]);
			$nacionalidad = ($nacionalidad == "502")?"Guatemalteco":"";
			$objPHPExcel->getActiveSheet()->setCellValue("G$linea", $nacionalidad);
			//tipo cui
			$tipo = $row["alu_tipo_cui"];
			$objPHPExcel->getActiveSheet()->setCellValue("H$linea", $tipo);
            //cui
			$cui = $row["alu_cui"];
			$objPHPExcel->getActiveSheet()->setCellValue("I$linea", $cui);
            $objPHPExcel->getActiveSheet()->getStyle("I$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
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
    $objPHPExcel->getActiveSheet()->getStyle("F$linea_inicial:F$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:H$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:H$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("I$linea_inicial:I$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
     
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
    $celda_final = "I".$linea;
    $objPHPExcel->getActiveSheet()->getStyle("B15:I15")->applyFromArray($styleThinBlackBorderOutline);
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
header ("Content-Disposition: attachment; filename=Listado_mineduc.xlsx");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($excel));
readfile($excel);

unlink($excel);

?>