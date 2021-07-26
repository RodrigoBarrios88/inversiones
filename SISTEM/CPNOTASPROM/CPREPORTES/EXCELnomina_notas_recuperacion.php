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
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Guatemala');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../Clases/PHPExcel.php';
//incluye las librerias y Clases del Proyecto
include_once('html_fns_reportes.php');
    $usuario = $_SESSION["codigo"];
	$nombre_usu = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$grado_usu = $_SESSION["grado"];
	$arma_usu = $_SESSION["arma"];
	//-- $_POST
	$pensum = $_REQUEST["pensum"];
	$semestre = $_REQUEST["semestre"];
	$nomina = $_REQUEST["nomina"];
	//-- 
	$ClsEst = new ClsEstadisticaRecuperacion();
	//-- 
	$result = $ClsEst->get_nomina($nomina,$pensum,$semestre,'','');
	if(is_array($result)){
		foreach($result as $row){
			//encabezados
			$titulo = trim($row["nom_titulo"]);
			$pensum_desc = trim($row["pen_descripcion_completa"]);
			$semestre_desc = trim($row["sem_descripcion"]);
			$tipo_desc = trim($row["nom_recuperacion"]);
			switch($tipo_desc){
				case 1: $tipo_desc = "1RA. RECUPERACIÓN"; break;
				case 2: $tipo_desc = "2DA. RECUPERACIÓN"; break;
			}
		}	
	}	


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator($nombre_usu)
							 ->setLastModifiedBy($nombre_usu)
							 ->setTitle($titulo)
							 ->setSubject("Nomina en Excel Office 2007 XLSX")
							 ->setDescription($tipo_desc)
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory($tipo_desc);
                             
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
    
    /// Combinacion de Celdas (Merge cells)
    $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
    $objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:F3');
    $objPHPExcel->getActiveSheet()->mergeCells('A4:F4');
    $objPHPExcel->getActiveSheet()->mergeCells('A5:F5');
    
    //Seteo de Titulos
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', $titulo)
            ->setCellValue('A2', 'Programa Acad&eacute;mico: '.$pensum_desc)
            ->setCellValue('A3', 'Semestre: '.$semestre_desc)
            ->setCellValue('A4', 'Tipo: '.$tipo_desc);
            
    $objPHPExcel->getActiveSheet()->getStyle("A1:A4")->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("A1:A4")->getFont()->setSize(12); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(16); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true); /// Asigna negrita
    $objPHPExcel->getActiveSheet()->getStyle("A1")->getFill()->getStartColor()->setARGB('C4C4C4');


    //////////////////////////////______ Lista las Materias ______//////////////////////////////
		$result_materias = $ClsEst->get_nomina_detalle_materias($nomina,$pensum,$semestre,'');
			if(is_array($result_materias)){
				$mat_count = 1;
				foreach($result_materias as $row_materia){
					$mat_cod = $row_materia["mat_codigo"];
					$materia_codigo[$mat_count] = $row_materia["mat_codigo"];
					$materia_descripcion[$mat_count] = $row_materia["mat_desc_ct"];
					$mat_count++;	
				}
				$mat_count--; //quita la ultima vuelta
			}
            
    /////////////////////////////        
	$linea_inicial = 6;
    $linea = 6;
    $i=1;
	$seccX = 0;
	$ancho_tabla = (80+($mat_count*15)+60);
	$result_cadetes = $ClsEst->get_detalle_nomina($pensum,$semestre,$nomina);
	if(is_array($result_cadetes)){
			 	// ESTE ES EL ENCABEZADO DE LA TABLA, 
				$columnas = 2 + $mat_count + 2;
                $ultima_columna = Trae_letra($columnas);
                $celda1 = "A".$linea;
                $celda2 = $ultima_columna.$linea;
                // Nombre de seccion 
                $objPHPExcel->getActiveSheet()->mergeCells("$celda1:$celda2");
                $objPHPExcel->getActiveSheet()->setCellValue($celda1, 'LISTADO GENERAL DE RECUPERACIÓN');
                $objPHPExcel->getActiveSheet()->getStyle($celda1)->getFont()->setSize(12); /// Asigna tamaño de letra
                $objPHPExcel->getActiveSheet()->getStyle($celda1)->getFont()->setBold(true); /// Asigna negrita
                $linea++;
                //encabezados de ceolumnas
                $celda1 = "A".$linea;
                $celda2 = $ultima_columna.$linea;
                $objPHPExcel->getActiveSheet()->getStyle("$celda1:$celda2")->getFont()->setName('Arial'); /// Asigna tipo de letra
                $objPHPExcel->getActiveSheet()->getStyle("$celda1:$celda2")->getFont()->setSize(11); /// Asigna tamaño de letra
                $objPHPExcel->getActiveSheet()->getStyle("$celda1:$celda2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle("$celda1:$celda2")->getFill()->getStartColor()->setARGB('C4C4C4');
                $objPHPExcel->getActiveSheet()->getStyle("$celda1:$celda2")->getFont()->setBold(true); /// Asigna negrita
                
				////////////////////////////////////// TABLA DE NOTAS ///////////////////////////////////////////
				//-- tamaños de columnas
					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
                    $cols = 3;
                    for($z=1;$z<=$mat_count;$z++){
						$letra = Trae_letra($cols);
                        $objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(13);
						$cols++;
					}
                    //promedio
                    $letra = Trae_letra($cols);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(13);
                    //puesto
                    $cols++;
                    $letra = Trae_letra($cols);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(13);
                    //rojos
                    $cols++;
                    $letra = Trae_letra($cols);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(13);
                    //promedio Universitario
                    $cols++;
                    $letra = Trae_letra($cols);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(16);
                    
				///--
				//-- Aliniamientos de columnas
					
				///--
				//-- Encabezados
					$arr_encabezado[0] = 'No.';
					$arr_encabezado[1] = 'NOMBRES';
					$cols = 2;
					for($z=1;$z<=$mat_count;$z++){
						$arr_encabezado[$cols] = $materia_descripcion[$z];
						$cols++;
					}
					$arr_encabezado[$cols] = 'PROM.';
					$arr_encabezado[$cols+1] = 'ROJOS';
					
                    $objPHPExcel->getActiveSheet()->setCellValue("A$linea", 'No.');
				    $objPHPExcel->getActiveSheet()->setCellValue("B$linea", 'NOMBRES');
                    $cols = 3;
                    for($z=1;$z<=$mat_count;$z++){
						$letra = Trae_letra($cols);
                        $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $materia_descripcion[$z]);
						$cols++;
					}
                    //promedio
                    $letra = Trae_letra($cols);
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea,  'PROMEDIO');
                    //rojos
                    $cols++;
                    $letra = Trae_letra($cols);
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea,  'ROJOS');
               ///--
				// FIN DEL ENCABEZADO DE LA TABLA
                $linea++;
			
		
		foreach($result_cadetes as $row){
			//catalogo
			$catalogo = $row["det_catalogo"];
			//nombres
			$grado = $row["gra_desc_ct"];
			$nom1 = trim($row["cad_nom1"]);
			$nom2 = trim($row["cad_nom2"]);
			$ape1 = trim($row["cad_ape1"]);
			$ape2 = trim($row["cad_ape2"]);
			$nombres = $grado." ".$ape1." ".$ape2.", ".$nom1." ".$nom2;
			//promedio
			$promedio = trim($row["det_promedio"]);
			//promedio Universitario
			$promedioU = trim($row["det_promedio_u"]);
			//Rojos
			$rojos = trim($row["det_rojos"]);
			//puesto
			$puesto = trim($row["det_puesto"]);
			//---
			$no = $i.".";
			
			//-- Datos
				$objPHPExcel->getActiveSheet()->setCellValue("A$linea", $i.'.');
				$objPHPExcel->getActiveSheet()->setCellValue("B$linea", $nombres);
				$cols = 3;
				for($z=1;$z<=$mat_count;$z++){
					$materia = $materia_codigo[$z];
					$result_notas = $ClsEst->get_nomina_detalle_notas($nomina,$pensum,$semestre,$catalogo,$materia);
					if(is_array($result_notas)){
						foreach($result_notas as $row_notas){
							$nota = trim($row_notas["not_nota"]);
							if($nota != 0){
								$letra = Trae_letra($cols);
                                $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $nota);
							}else{
								$letra = Trae_letra($cols);
                                $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, "PENDIENTE");
                                $objPHPExcel->getActiveSheet()->getStyle($letra.$linea)->getFont()->setBold(true); /// Asigna negrita
                                $objPHPExcel->getActiveSheet()->getStyle($letra.$linea)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                $objPHPExcel->getActiveSheet()->getStyle($letra.$linea)->getFill()->getStartColor()->setARGB('F7CD6C');
							}
						}
					}else{
						$letra = Trae_letra($cols);
                        $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, "-");
					}
					$cols++;
				}	
				//promedio
                    $letra = Trae_letra($cols);
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $promedio);
                    //rojos
                    $cols++;
                    $letra = Trae_letra($cols);
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$linea, $rojos);
                ///--
			$i++;// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
            $linea++;
		}
        $linea--;
			
	}else{
		
	}
    
    
    // Pone el Recuadro sobre la tabla
    //echo date('H:i:s') , " Set thin black border outline around column" , EOL;
    $styleThinBlackBorderOutline = array(
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
            ),
        ),
    );
    $celda_inicial = "A".$linea_inicial;
    $columnas = 2 + $mat_count + 2;
    $ultima_columna = Trae_letra($columnas);
    $celda_final = $ultima_columna.$linea;
    $objPHPExcel->getActiveSheet()->getStyle("$celda_inicial:$celda_final")->applyFromArray($styleThinBlackBorderOutline);


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle($semestre_desc);





// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$titulo.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 31 Jul 2017 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
