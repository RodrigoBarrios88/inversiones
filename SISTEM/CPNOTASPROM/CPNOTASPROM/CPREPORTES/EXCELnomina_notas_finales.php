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
    $usuario = $_SESSION["codigo"];
	$colegio = $_SESSION["colegio_nombre_reporte"];
	//$_POST
	$pensum = $_REQUEST["pensum"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$tipo = $_REQUEST["tipo"];
	$num = $_REQUEST["num"];
	$tiposec = $_REQUEST["tiposec"];
	$seccion = $_REQUEST["seccion"];
	$filas_materia = $_REQUEST["materiarows"];
	//--formato de notas
	$chkzona = $_REQUEST["chkzona"];
	$chknota = $_REQUEST["chknota"];
	$chktotal = $_REQUEST["chktotal"];
	//--$POST de Configuración
	$titulo = $_REQUEST["titulo"];
	$acho_cols = $_REQUEST["anchocols"];
	$fontsize = $_REQUEST["font"];
	$tipo_papel = $_REQUEST["papel"];
	$orientacion = $_REQUEST["orientacion"];
	$nota_minima = $_REQUEST["notaminima"];
    ////////////////// -- EXONERACIONES -- ///////////////////////
	$chkexonera = $_REQUEST["chkexonera"];
	function porcentajes_unidad($unidad,$nivel){
		switch($unidad){
			case 1: $porcentaje = 0.30; break;
			case 2: $porcentaje = 0.30; break;
			case 3: $porcentaje = 0.40; break;
		}
		return $porcentaje;
	}
	$unidades = ($nivel == 1)?3:4;
	$unidades = ($chkexonera == 1)?$unidades:"";
	
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
    $ClsNot = new ClsNotas();
	
	if($pensum == "" && $nivel == "" && $grado ==""){
		echo "<script>window.close();</script>";
	}
	
	$result = $ClsPen->get_seccion($pensum,$nivel,$grado,$seccion);
	if(is_array($result)){
		foreach($result as $row){
			$pensum_desc = $row["pen_descripcion"];
			$nivel_desc = $row["niv_descripcion"];
			$grado_desc = trim($row["gra_descripcion"]);
			$seccion_desc = trim($row["sec_descripcion"]);
		}
	}
	//--

//--
if($chkexonera != 1){
    $titulo = "Nomina de Notas";
}else{
    $titulo = "Nomina para Exoneraciones";
}	
$file_desc = "Listado exportado a Excel";

///coloca los formatos porsible en la impresion
	if($chkzona == 1 && $chknota == 1 && $chktotal == 1){
		$formato = "Actividades + Nota de Evaluacion = Total";
	}else if($chkzona == 1 && $chknota == 1 && $chktotal != 1){
		$formato = "Actividades y Nota";
	}else if($chkzona == 1 && $chknota != 1 && $chktotal != 1){
		$formato = "Zonas";
	}else if($chkzona != 1 && $chknota == 1 && $chktotal != 1){
		$formato = "Nota de Evaluacion";
	}else if($chkzona != 1 && $chknota != 1 && $chktotal == 1){
		$formato = "Punteo Total";
	}else{
		$formato = "Formato Desconocido (Se usa Punteo Total)"; ///cualquier otra variacion no contemplada se colocara con la nota unicamnete
	}

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
    $objPHPExcel->getActiveSheet()->mergeCells('B2:P2');
    $objPHPExcel->getActiveSheet()->mergeCells('B3:P3');
    $objPHPExcel->getActiveSheet()->mergeCells('B4:P4');
    $objPHPExcel->getActiveSheet()->mergeCells('B5:P5');
	$objPHPExcel->getActiveSheet()->mergeCells('B6:P6');
	$objPHPExcel->getActiveSheet()->mergeCells('B7:P7'); //Indice de materias
	
	//Seteo de Titulos
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', $colegio)
            ->setCellValue('B3', "Informe de Notas Finales para $grado_desc Sección $seccion_desc")
            ->setCellValue('B4', $pensum_desc.', Nivel: '.$nivel_desc)
			->setCellValue('B5', 'Generado: '.date("d/m/Y H:i"))
			->setCellValue('B6', 'Formato de Notas: '.$formato)
			->setCellValue('B7', 'MATERIAS LISTADAS');
            
    ///// ESTILOS        
    $objPHPExcel->getActiveSheet()->getStyle("B2:P7")->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("B2:P7")->getFont()->setSize(10); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setSize(14); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true); /// Asigna negrita
    //..
	$objPHPExcel->getActiveSheet()->getStyle("B7")->getFont()->setBold(true); /// Asigna negrita
    $objPHPExcel->getActiveSheet()->getStyle("B2:P7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
    
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
	
	////////// LISTAR MATERIAS
	$mat_count = 1;
	$columna = 1;
	$columnas = 1;
	$fila = 8;
	for($k = 1; $k <= $filas_materia; $k++){
		if($_REQUEST["materia$k"] != ""){
			$materia[$mat_count] = $_REQUEST["materia$k"];
			$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado,$materia[$mat_count],'1',1);
			if(is_array($result_materias)){
				foreach($result_materias as $row_materia){
					//--
					$pensum_desc = $row_materia["pen_descripcion"];
					$nivel_desc = $row_materia["niv_descripcion"];
					$grado_desc = $row_materia["gra_descripcion"];
					$seccion_desc = $row_materia["sec_descripcion"];
					//--
					$mat_cod = $row_materia["mat_codigo"];
					$materia_codigo[$mat_count] = $row_materia["mat_codigo"];
					$materia_descripcion[$mat_count] = trim($row_materia["mat_descripcion"]);
					//--
					if($columna == 1){
						$Col = 2;
						$Col = Trae_letra($Col);
						$objPHPExcel->getActiveSheet()->mergeCells("B$fila:D$fila");
					}else if($columna == 2){
						$Col = 5;
						$Col = Trae_letra($Col);
						$objPHPExcel->getActiveSheet()->mergeCells("E$fila:J$fila");
					}else if($columna == 3){
						$Col = 11;
						$Col = Trae_letra($Col);
						$objPHPExcel->getActiveSheet()->mergeCells("K$fila:P$fila");
					}
					$objPHPExcel->getActiveSheet()->setCellValue($Col."".$fila, $k.".".$row_materia["mat_descripcion"]);
				}
				$mat_count++;
				$columna++;
				if($columna == 4){
					$columna = 1;
					$fila++;
				}
			}
		}
	}
	$mat_count--;
	$fila+=2;
	//--
    
    ////// ENCABEZADOS /////
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, "No.");
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, "Alumno");
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	$Col = 0;
    for($k = 1; $k <= $mat_count; $k++){
		$Col = ($k+3);
		$letra = Trae_letra($Col);
		$objPHPExcel->getActiveSheet()->setCellValue($letra.''.$fila, $k);
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(10);
	}
	$Col = ($mat_count+4);
	$letra = Trae_letra($Col);
	$objPHPExcel->getActiveSheet()->setCellValue($letra.''.$fila, "PROM.");
	$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(15);
	$Col = ($mat_count+5);
	$letra = Trae_letra($Col);
	$objPHPExcel->getActiveSheet()->setCellValue($letra.''.$fila, "ROJOS");
	$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(15);
	//--
    $objPHPExcel->getActiveSheet()->getStyle("B".$fila.":".$letra."".$fila)->getFont()->setName('Arial'); /// Asigna tipo de letra
    $objPHPExcel->getActiveSheet()->getStyle("B".$fila.":".$letra."".$fila)->getFont()->setSize(11); /// Asigna tamaño de letra
    $objPHPExcel->getActiveSheet()->getStyle("B".$fila.":".$letra."".$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle("B".$fila.":".$letra."".$fila)->getFill()->getStartColor()->setARGB('C4C4C4');
    $objPHPExcel->getActiveSheet()->getStyle("B".$fila.":".$letra."".$fila)->getFont()->setBold(true); /// Asigna negrita
    $objPHPExcel->getActiveSheet()->getStyle("B".$fila.":".$letra."".$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); /// alinea al  centro
	$objPHPExcel->getActiveSheet()->getStyle("B".$fila.":".$letra."".$fila)->getFont()->setBold(true); /// Asigna negrita
	
    /////////////////////////////
	$letra_final = $letra;
	$linea_inicial = $fila;
	$linea = ($linea_inicial+1);
    $i=1;
	$seccX = 0;
	$result_alumnos = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	if(is_array($result_alumnos)){
		foreach($result_alumnos as $row){
			$alumno = $row["alu_cui"];
			$nombre = trim($row["alu_nombre"]);
			$apellido = trim($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			//---
			$objPHPExcel->getActiveSheet()->setCellValue("B$linea", $i);
			$objPHPExcel->getActiveSheet()->setCellValue("C$linea", $nombres);
			//echo "objPHPExcel->getActiveSheet()->setCellValue('B$linea', $i) <br>";
			//echo "objPHPExcel->getActiveSheet()->setCellValue('C$linea', $nombres); <br>";
			
			//--	
			$total = 0;
			$rojos = 0;
			$pendientes = 0;
			$notas_validas = 1;
			for($y = 1; $y <= $mat_count; $y++){
				$nota_porcentuada = 0;
				$result_notas = $ClsNot->get_notas_alumno_tarjeta($alumno,$pensum,$nivel,$grado,$seccion,$materia[$y]);
				if(is_array($result_notas)){
					foreach($result_notas as $row_notas){
					    $zona = $row_notas["not_zona"];
    					$nota = $row_notas["not_nota"];
    				    $parcial = $row_notas["not_parcial"];
						$punteo = $row_notas["not_total"];
    					$porcent = porcentajes_unidad($parcial,$nivel);
    					$porcentaje = ($porcent * $punteo);
    					$porcentaje = number_format($porcentaje, 0, '.', '');
    					$nota_porcentuada+= $porcentaje;
					}
    					$total+= $nota_porcentuada;
    					///coloca los formatos porsible en la impresion
    					if($chkzona != 1 && $chknota != 1 && $chktotal == 1){
    						$formato = "$nota_porcentuada";
    					}else{
    						$formato = "$nota_porcentuada"; ///cualquier otra variacion no contemplada se colocara con la nota unicamnete
    					}
						$Col = ($y+3);
						$letra = Trae_letra($Col);
						$celda = $letra.''.$linea;
						$objPHPExcel->getActiveSheet()->setCellValue("$celda", $formato);
						//cuenta validas
						$notas_validas++;
						///-- separa rejors, azules y normales
						if($nota_porcentuada < $nota_minima && $nota_porcentuada > 0){
							$rojos++;
							$styleArray = array(
								'font'  => array(
									'bold'  => true,
									'color' => array('rgb' => 'FF0000')
								));
						}else if($nota_porcentuada >= $nota_minima && $nota_porcentuada < 70){
							$styleArray = array(
								'font'  => array(
									'bold'  => true,
									'color' => array('rgb' => '0040FF')
								));
						}else{
							$arr_colores[$cols-1] = "0,0,0";
							$styleArray = array(
								'font'  => array(
									'bold'  => false,
									'color' => array('rgb' => '000000')
								));
						}
						$objPHPExcel->getActiveSheet()->getStyle("$celda")->applyFromArray($styleArray);
					
				}else{
					$Col = ($y+3);
					$letra = Trae_letra($Col);
					$celda = $letra.''.$linea;
					$objPHPExcel->getActiveSheet()->setCellValue("$celda", "-");
					$pendientes++;
				}
				$cols++;
			}
			$notas_validas--;
			if($total > 0){
				$promedio = ($total/$notas_validas);
				$promedio = number_format($promedio, 2, '.', '');
			}else{
				$promedio = 0;
			}
			$promedio = ($promedio > 0)?$promedio:"";
			
			$Col = ($mat_count+4);
			$letra = Trae_letra($Col);
			$celda = $letra.''.$linea;
			$objPHPExcel->getActiveSheet()->setCellValue("$celda", $promedio);
			$Col = ($mat_count+5);
			$letra = Trae_letra($Col);
			$celda = $letra.''.$linea;
			$objPHPExcel->getActiveSheet()->setCellValue("$celda", $rojos);
			///--
			$linea++;
			$i++;// IGUAL QUE EL ENCABEZADO, Y ESTO SE HACE POR CADA REGISTRO
		}
    }
	$linea--;
			
    // - ESTILOS DEL CUERPO DE LA TABLA - //
    // Alineacion
	$celda_ini1 = 'B'.$linea_inicial;
	$celda_fin1 = $letra_final.''.$linea_inicial;
	$celda_ini2 = 'D'.$linea_inicial;
	$celda_fin2 = $letra_final.''.$linea;
    $objPHPExcel->getActiveSheet()->getStyle("$celda_ini1:$celda_fin1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("$celda_ini2:$celda_fin2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle("C$linea_inicial:C$linea")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	 
    // recuadro de columnas
    $styleThinBlackBorderOutline = array(
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
            ),
        ),
    );
	$linea_materias = $linea_inicial-2;
	$objPHPExcel->getActiveSheet()->getStyle("B7:P7")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("B8:P$linea_materias")->applyFromArray($styleThinBlackBorderOutline);
    $objPHPExcel->getActiveSheet()->getStyle("$celda_ini1:$celda_fin2")->applyFromArray($styleThinBlackBorderOutline);
    


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
header ("Content-Disposition: attachment; filename=Notas_Finales.xlsx");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($excel));
readfile($excel);

unlink($excel);

?>