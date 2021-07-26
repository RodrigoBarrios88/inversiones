<?php
include_once('../../html_fns.php');


function nomina_lista_html($periodo,$nivel,$grado,$tipo,$sit,$id,$acc="") {
	$ClsEst = new ClsEstadistica();
		$result = $ClsEst->get_nomina("",$periodo,$nivel,$grado,$tipo,$sit);
		return lista_combo_html_onclick($result,$id,'nom_codigo','nom_titulo',$acc);
}


function nomina_lista_recuperacion_html($periodo,$nivel,$grado,$recuperacion,$sit,$id,$acc="") {
	$ClsEst = new ClsEstadisticaRecuperacion();
		$result = $ClsEst->get_nomina("",$periodo,$nivel,$grado,$recuperacion,$sit);
		return lista_combo_html_onclick($result,$id,'nom_codigo','nom_titulo',$acc);
}


function tabla_grados_alumnos($sit,$periodo,$nivel,$grado){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_grado_alumno($periodo,$nivel,$grado,'','',$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" class = "text-center">No.</td>';
			$salida.= '<th width = "60px" class = "text-center">CUI</td>';
			$salida.= '<th width = "100px" class = "text-center">TIPO DOC.</td>';
			$salida.= '<th width = "200px" class = "text-center">ALUMNO</td>';
			$salida.= '<th width = "100px" class = "text-center">GRADO</td>';
			$salida.= '</div>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			//No.
			$salida.= '<td class = "text-center">'.$i.'</td>';
			//cui
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//tipo cui
			$tipo = $row["alu_tipo_cui"];
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//grado
			$gra = $row["gra_descripcion"];
			$salida.= '<td class = "text-center">'.$gra.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_secciones_alumnos($sit,$periodo,$nivel,$grado,$seccion,$tipo){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($periodo,$nivel,$grado,$seccion,'','',$tipo,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" class = "text-center">No.</td>';
			$salida.= '<th width = "60px" class = "text-center">CUI</td>';
			$salida.= '<th width = "100px" class = "text-center">TIPO DOC.</td>';
			$salida.= '<th width = "200px" class = "text-center">ALUMNO</td>';
			$salida.= '<th width = "100px" class = "text-center">GRADO</td>';
			$salida.= '<th width = "100px" class = "text-center">SECCION</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'</td>';
			//cui
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//tipo cui
			$tipo = $row["alu_tipo_cui"];
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//grado
			$gra = $row["gra_descripcion"];
			$salida.= '<td class = "text-center">'.$gra.'</td>';
			//seccion
			$sec = $row["sec_descripcion"];
			$salida.= '<td class = "text-center">'.$sec.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_periodo_grafico($periodo){
	$ClsPer = new ClsPeriodoFiscal();
	$ClsAcad = new ClsAcademico();
	$ClsAul = new ClsAula();
	
	$result_nivel = $ClsPer->get_nivel($periodo,"",$sit);
	if(is_array($result_nivel)){
		$salida.= '<ul class="treeview">';
		$i=1;	
		foreach($result_nivel as $row){
			$salida.= '<li>';
			//No.
			$nivel = $row["niv_codigo"];
			//descripcion
			$desc = utf8_decode($row["niv_descripcion"]);
			$salida.='NIVEL: '.$desc.' ';
			//situacion
			$sit = trim($row["niv_situacion"]);
			$sit = ($sit == 1)?"<strong class='text-success'>ACTIVO</strong>":"<strong class='text-danger'>INACTIVO</strong>";
			$salida.= ' - SITUACI&Oacute;N: '.$sit.' ';
				$salida.= '<ul>';
				
				$salida.= '<li> GRADOS';
					$salida.= '<ul>';
					/// inician grados
					$result_grados = $ClsPer->get_grado($periodo,$nivel);
					if(is_array($result_grados)){
						$j=1;	
						foreach($result_grados as $row_grado){
							$salida.= '<li>';
							//No.
							$grado = $row_grado["gra_codigo"];
							//descripcion
							$desc = utf8_decode($row_grado["gra_descripcion"]);
							$salida.= 'GRADO: '.$desc.' ';
							//situacion
							$sit = trim($row_grado["gra_situacion"]);
							$sit = ($sit == 1)?"<strong class='text-success'>ACTIVO</strong>":"<strong class='text-danger'>INACTIVO</strong>";
							$salida.= ' - SITUACI&Oacute;N: '.$sit.' ';
								$salida.= '<ul>';
									$salida.= '<li>SECCIONES';
									///inician Secciones
										$salida.= '<ul>';
											$result_secciones = $ClsPer->get_seccion($periodo,$nivel,$grado,'','',1);
											if(is_array($result_secciones)){
												
												$k=1;	
												foreach($result_secciones as $row_seccion){
													$salida.= '<li>';
													//descripcion
													$desc = utf8_decode($row_seccion["sec_descripcion"]);
													$salida.= 'SECCI&Oacute;N: '.$desc.' ';
													//tipo
													$tipo = utf8_decode($row_seccion["sec_tipo"]);
													switch($tipo){	
														case 'A': $tipo_desc = "ACADEMICA"; break;
														case 'P': $tipo_desc = "PRACTICA"; break;
														case 'D': $tipo_desc = "DEPORTIVA"; break;
													}
													$salida.= ' - TIPO: '.$tipo_desc.' ';
													$salida.= '</li>';
													$k++;
												}
											}
										$salida.= '</ul>';
									///finalizan Secciones
									$salida.= '</li>';
									
									$salida.= '<li>MATERIAS';
									///inician Materias
										$salida.= '<ul>';
											$result_materia = $ClsPer->get_materia($periodo,$nivel,$grado,'','',1);
											if(is_array($result_materia)){
												$k=1;	
												foreach($result_materia as $row_materia){
													$salida.= '<li>';
													//No.
													$materia = $row_materia["mat_codigo"];
													//descripcion
													$desc = utf8_decode($row_materia["mat_descripcion"]);
													$salida.= 'MATERIA: '.$desc.' ';
													//tipo
													$tipo = utf8_decode($row_materia["sec_tipo"]);
													switch($tipo){	
														case 'A': $tipo_desc = "ACADEMICA"; break;
														case 'P': $tipo_desc = "PRACTICA"; break;
														case 'D': $tipo_desc = "DEPORTIVA"; break;
													}
													$salida.= ' - TIPO: '.$tipo_desc.' ';
													
													$salida.= '</li>';
													$k++;
												}
												
											}
										$salida.= '</ul>';
									$salida.= '</li>';///finalizan Materias
									
								$salida.= '</ul>';
							$salida.= '</li>'; ///finalizan Grado
							$j++;
						}
					}
					$salida.= '</ul>'; ///---
				$salida.= '</li>'; ///---
				
				$salida.= '</ul>';
			$salida.= '</li>'; ///finalizan Nivel
			$i++;
		}
		$salida.= '</ul>';
		///finalizan Principal
	}
	
	return $salida;
}


?>
