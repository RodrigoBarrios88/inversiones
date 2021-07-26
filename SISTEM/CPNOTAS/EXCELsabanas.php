<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('max_execution_time', "240");
ini_set('memory_limit', "1028M");
date_default_timezone_set('America/Guatemala');

require '../Clases/PHPExcel.php';
include_once('html_fns_notas.php');

$usu = "codigo";
if($usu = ""){
    echo "<form id='f1' name='f1' action='../../logout.php' method='post'>";
    echo "<script>document.f1.submit();</script>";
    echo "</form>";
}
$titulo = "NOTAS SABANA";

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Usuario Pendiente")->setDescription("Notas Sabanas");

$objWorksheet = $objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('B1', $titulo)
    ->setCellValue('B3', 'Fecha/Hora de generación: ' . date("d/m/Y H:i"))
    ->setCellValue('B4', $usu);
$objPHPExcel->getActiveSheet()->setTitle("Notas Sabanas");


$objPHPExcel->getActiveSheet()->getStyle("B1:B6")->getFont()->setName('Arial'); /// Asigna tipo de letra
$objPHPExcel->getActiveSheet()->getStyle("B1:B6")->getFont()->setSize(12); /// Asigna tamaño de letra
$objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setSize(14); /// Asigna tamaño de letra
$objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true); /// Asigna negrita
$objPHPExcel->getActiveSheet()->getStyle("B1")->getFill()->getStartColor()->setARGB('C4C4C4');

$linea = 7;
$objPHPExcel->getActiveSheet()->setCellValue("B$linea", "No.");
$objPHPExcel->getActiveSheet()->setCellValue("C$linea", "Almuno");
$objPHPExcel->getActiveSheet()->setCellValue("D$linea", "Vocal E");
$objPHPExcel->getActiveSheet()->setCellValue("E$linea", "Las Silabas");
$objPHPExcel->getActiveSheet()->setCellValue("F$linea", "Literatura Do");
$objPHPExcel->getActiveSheet()->setCellValue("G$linea", "Tarea 482");
$objPHPExcel->getActiveSheet()->setCellValue("H$linea", "Documento Word");
$objPHPExcel->getActiveSheet()->setCellValue("I$linea", "Documento Imagen");
$objPHPExcel->getActiveSheet()->setCellValue("J$linea", "Documento PDF");
$objPHPExcel->getActiveSheet()->setCellValue("K$linea", " Tarea 11 2u");
$objPHPExcel->getActiveSheet()->setCellValue("L$linea", "Tarea 10");
$objPHPExcel->getActiveSheet()->setCellValue("M$linea", "Hoja de Trabajo del Libro Los Patitos");

$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("K")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("L")->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension("M")->setWidth(10);

$rango_celdas = "B$linea:H$linea";
$objPHPExcel->getActiveSheet()->getStyle($rango_celdas)->getFont()->setName('Arial'); /// Asigna tipo de letra
$objPHPExcel->getActiveSheet()->getStyle($rango_celdas)->getFont()->setSize(11); /// Asigna tamaño de letra
$objPHPExcel->getActiveSheet()->getStyle($rango_celdas)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle($rango_celdas)->getFill()->getStartColor()->setARGB('C4C4C4');
$objPHPExcel->getActiveSheet()->getStyle($rango_celdas)->getFont()->setBold(true); /// Asigna negrita
$objPHPExcel->getActiveSheet()->getStyle($rango_celdas)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro

$fila = 7;
$ClsTar = new ClsTarea();
$ClsAcad = new ClsAcademico();
$ClsExa = new ClsExamen();
$resultTarea = $ClsTar->get_tarea($cod,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,'','','','',$sit);
$resultExa = $ClsExa->get_examen($cod,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,'','','','',$sit);
$sit = 1;
$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',$sit);

if(is_array())