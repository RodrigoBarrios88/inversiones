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
	$cue = $_REQUEST["cue"];
	$ban = $_REQUEST["ban"];
	$periodo = $_REQUEST["periodo"];
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	//--
	
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_cuenta_banco($cue,$ban);
	if(is_array($result)){
		foreach($result as $row){
			$cuenta_desc = trim($row["cueb_nombre"]);
			$cuenta_num = trim($row["cueb_ncuenta"]);
			$banco_desc = trim($row["ban_desc_lg"]);
		}	
	}	

$titulo = "Reporte de Ingresos";
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
			->setCellValue('B6', "Banco:")
			->setCellValue('C6', $banco_desc)
			->setCellValue('E6', "Cuenta No.:")
			->setCellValue('G6', "$cuenta_num - $cuenta_desc")
			->setCellValue('B7', "Periodo:")
			->setCellValue('C7', "Del $desde al $hasta");
            
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
    $objDrawing->setCoordinates('B1');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    
    ////// ENCABEZADOS /////
    $objPHPExcel->getActiveSheet()->setCellValue('B9', "No.");
    $objPHPExcel->getActiveSheet()->setCellValue('C9', "CUI");
    $objPHPExcel->getActiveSheet()->setCellValue('D9', "Alumno");
    $objPHPExcel->getActiveSheet()->setCellValue('E9', "Boleta");
	$objPHPExcel->getActiveSheet()->setCellValue('F9', "Referencia");
	$objPHPExcel->getActiveSheet()->setCellValue('G9', "Carga");
	$objPHPExcel->getActiveSheet()->setCellValue('H9', "Grado");
	$objPHPExcel->getActiveSheet()->setCellValue('I9', "Fecha");
	$objPHPExcel->getActiveSheet()->setCellValue('J9', "Monto");
	$objPHPExcel->getActiveSheet()->setCellValue('K9', "Factura");
	$objPHPExcel->getActiveSheet()->setCellValue('L9', "NIT");
	$objPHPExcel->getActiveSheet()->setCellValue('M9', "Contribuyente");
	$objPHPExcel->getActiveSheet()->setCellValue('N9', "Mes");
	$objPHPExcel->getActiveSheet()->setCellValue('O9', "Motivo o Concepto");
	//--
    $objPHPExcel->getActiveSheet()->getStyle("B9:O9")->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("B9:O9")->getFont()->setSize(11); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B9:O9")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle("B9:O9")->getFill()->getStartColor()->setARGB('C4C4C4');
    $objPHPExcel->getActiveSheet()->getStyle("B9:O9")->getFont()->setBold(true); /// Asigna negrita
    $objPHPExcel->getActiveSheet()->getStyle("B9:O9")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
	$objPHPExcel->getActiveSheet()->getStyle("B6:B7")->getFont()->setBold(true); /// Asigna negrita
	$objPHPExcel->getActiveSheet()->getStyle("E6")->getFont()->setBold(true); /// Asigna negrita
    //--
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(40);
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(40);
    /////////////////////////////        
	$linea_inicial = 9;
    $linea = 10;
    $i=1;
	$ingresos = 0;
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro('',$cue,$ban,'','',$periodo,'','','',$desde,$hasta,3);
	if(is_array($result)){
		foreach($result as $row){
			$nombre_completo = trim($row["alu_nombre_completo"]);
			$nombre_inscripcion = trim($row["inscripcion_nombre_completo"]);
			/// si reconoce al alumno lo agrega al listado, si no, NO
			if($nombre_completo != "" || $nombre_inscripcion != ""){
				//No.
				$objPHPExcel->getActiveSheet()->setCellValue("B$linea", $i);
				//cui
				$cui = $row["pag_alumno"];
				$objPHPExcel->getActiveSheet()->setCellValue("C$linea", $cui);
				$objPHPExcel->getActiveSheet()->getStyle("C$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				//nombre
				$nombre = trim($row["alu_nombre_completo"]);
				$nombre_inscripcion = trim($row["inscripcion_nombre_completo"]);
				$nombre = ($nombre == "")?$nombre_inscripcion:$nombre;
				$objPHPExcel->getActiveSheet()->setCellValue("D$linea", $nombre);
				//boleta
				$boleta = $row["pag_programado"];
				$objPHPExcel->getActiveSheet()->setCellValue("E$linea", $boleta);
				//referencia
				$referencia = $row["pag_referencia"];
				$objPHPExcel->getActiveSheet()->setCellValue("F$linea", $referencia);
				//carga
				$carga = $row["pag_carga"];
				$salida.= '<td class = "text-center"># '.$carga.'</td>';
				$objPHPExcel->getActiveSheet()->setCellValue("G$linea", $carga);
				//grado
				$grado = trim($row["alu_grado_descripcion"]);
				$seccion = trim($row["alu_seccion_descripcion"]);
				$objPHPExcel->getActiveSheet()->setCellValue("H$linea", $grado.' '.$seccion);
				//fecha
				$fecha = $row["pag_fechor"];
				$fecha = cambia_fechaHora($fecha);
				$fecha = substr($fecha,0,10);
				$objPHPExcel->getActiveSheet()->setCellValue("I$linea", $fecha);
				//ingresos
				$ingreso = ($row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"]);
				$ingreso = number_format($ingreso,2,'.','');
				$objPHPExcel->getActiveSheet()->setCellValue("J$linea", $ingreso);
				$objPHPExcel->getActiveSheet()->getStyle("J$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
				$ingresos+= $ingreso;
				//factura
				$serie = $row["fac_serie_numero"];
				$numero = $row["fac_numero"];
				$objPHPExcel->getActiveSheet()->setCellValue("K$linea", $numero);
				//NIT
				$nit = trim($row["alu_nit"]);
				$nit_inscripcion = trim($row["inscripcion_nit"]);
				$nit = ($nit == "")?$nit_inscripcion:$nit;
				$objPHPExcel->getActiveSheet()->setCellValue("L$linea", $nit);
				//Cliente
				$cliente = trim($row["alu_cliente_nombre"]);
				$cliente_inscripcion = trim($row["inscripcion_cliente_nombre"]);
				$cliente = ($cliente == "")?$cliente_inscripcion:$cliente;
				$objPHPExcel->getActiveSheet()->setCellValue("M$linea", $cliente);
				//colegiatura
				$colegiatura = trim($row["bol_fecha_pago"]);
				$mes = substr($colegiatura,5,2);
				$mes = Meses_Letra($mes);
				$objPHPExcel->getActiveSheet()->setCellValue("N$linea", $mes);
				//concepto
				$motivo = trim($row["bol_motivo"]);
				$motivo_boleta = ($motivo == "")?"- No relacionada -":$motivo;
				$objPHPExcel->getActiveSheet()->setCellValue("O$linea", $motivo);
				///--
				$linea++;
				$i++;
			}
		}
    }
	//// Facturas anuladas
	$result = $ClsBol->get_factura('','','','','','',$suc,'',0,$desde,$hasta);
	if(is_array($result)){
		foreach($result as $row){
			//No.
			$objPHPExcel->getActiveSheet()->setCellValue("B$linea", $i);
			//cui
			$cui = $row["fac_alumno"];
			$objPHPExcel->getActiveSheet()->setCellValue("C$linea", $cui);
            $objPHPExcel->getActiveSheet()->getStyle("C$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			//nombre
			$nombre = trim($row["alu_nombre_completo"]);
			$nombre = ($nombre == "")?"---":$nombre;
			$objPHPExcel->getActiveSheet()->setCellValue("D$linea", $nombre);
			//boleta
			$boleta = $row["pag_programado"];
			$objPHPExcel->getActiveSheet()->setCellValue("E$linea", $boleta);
			//boleta
			$referencia = $row["fac_referencia"];
			$objPHPExcel->getActiveSheet()->setCellValue("F$linea", $referencia);
			//carga
			$carga = $row["fac_carga"];
			$salida.= '<td class = "text-center"># '.$carga.'</td>';
			$objPHPExcel->getActiveSheet()->setCellValue("G$linea", $carga);
			//grado
			$grado = trim($row["alu_grado_descripcion"]);
			$seccion = trim($row["alu_seccion_descripcion"]);
			$objPHPExcel->getActiveSheet()->setCellValue("H$linea", $grado.' '.$seccion);
			//fecha
			$fecha = $row["fac_fechor"];
			$fecha = cambia_fechaHora($fecha);
			$fecha = substr($fecha,0,10);
			$objPHPExcel->getActiveSheet()->setCellValue("I$linea", $fecha);
			//ingresos
			$monto = $row["fac_monto"];
			$monto = number_format($monto,2,'.','');
			$objPHPExcel->getActiveSheet()->setCellValue("J$linea", $monto);
			//factura
			$serie = $row["ser_numero"];
			$numero = $row["fac_numero"];
			$objPHPExcel->getActiveSheet()->setCellValue("K$linea", $numero);
			//NIT
			$nit = trim($row["alu_nit"]);
			$objPHPExcel->getActiveSheet()->setCellValue("L$linea", $nit);
			//Cliente
			$cliente = trim($row["alu_cliente_nombre"]);
			$objPHPExcel->getActiveSheet()->setCellValue("M$linea", $cliente);
			//colegiatura
			$objPHPExcel->getActiveSheet()->setCellValue("N$linea", "ANULADA");
			//motivo
			$objPHPExcel->getActiveSheet()->setCellValue("O$linea", "ANULADA");
			///--
			$linea++;
			$i++;
		}
    }
    //////---- SUMATORIAS O PIE DE TABLA
		//ingresos
			$ingresos = number_format($ingresos,2,'.',',');
			$objPHPExcel->getActiveSheet()->setCellValue("I$linea", $ingresos);
			$objPHPExcel->getActiveSheet()->getStyle("I$linea")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//--
			$objPHPExcel->getActiveSheet()->getStyle("B$linea:O$linea")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyle("B$linea:O$linea")->getFill()->getStartColor()->setARGB('C4C4C4');
			$objPHPExcel->getActiveSheet()->getStyle("B$linea:O$linea")->getFont()->setBold(true); /// Asigna negrita
		///--
			
    // - ESTILOS DEL CUERPO DE LA TABLA - //
    // Alineacion
    $objPHPExcel->getActiveSheet()->getStyle("B$linea_inicial:B$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("C$linea_inicial:C$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("E$linea_inicial:E$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("F$linea_inicial:F$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("H$linea_inicial:H$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("I$linea_inicial:I$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("J$linea_inicial:J$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("K$linea_inicial:K$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("L$linea_inicial:L$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 
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
    $objPHPExcel->getActiveSheet()->getStyle("O$linea_inicial:O$linea")->applyFromArray($styleThinBlackBorderOutline);
    
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
    $celda_final = "O".$linea;
    $objPHPExcel->getActiveSheet()->getStyle("B9:O9")->applyFromArray($styleThinBlackBorderOutline);
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
header ("Content-Disposition: attachment; filename=Reporte_Ingresos.xlsx");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($excel));
readfile($excel);

unlink($excel);

?>