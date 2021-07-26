<?php
include_once('../../html_fns.php');


function nomina_lista_html($pensum,$nivel,$grado,$tipo,$sit,$id,$acc="") {
	$ClsEst = new ClsEstadistica();
		$result = $ClsEst->get_nomina("",$pensum,$nivel,$grado,$tipo,$sit);
		return lista_combo_html_onclick($result,$id,'nom_codigo','nom_titulo',$acc);
}


function nomina_lista_recuperacion_html($pensum,$nivel,$grado,$recuperacion,$sit,$id,$acc="") {
	$ClsEst = new ClsEstadisticaRecuperacion();
		$result = $ClsEst->get_nomina("",$pensum,$nivel,$grado,$recuperacion,$sit);
		return lista_combo_html_onclick($result,$id,'nom_codigo','nom_titulo',$acc);
}


function tabla_grados_alumnos($sit,$pensum,$nivel,$grado){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_grado_alumno($pensum,$nivel,$grado,'','',$sit);
	
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



function tabla_secciones_alumnos($sit,$pensum,$nivel,$grado,$seccion,$tipo){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','',$tipo,$sit);
	
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


function tabla_pensum_grafico($pensum){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsAul = new ClsAula();
	
	$result_nivel = $ClsPen->get_nivel($pensum,"",$sit);
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
					$result_grados = $ClsPen->get_grado($pensum,$nivel);
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
											$result_secciones = $ClsPen->get_seccion($pensum,$nivel,$grado,'','',1);
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
											$result_materia = $ClsPen->get_materia($pensum,$nivel,$grado,'','',1);
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


function descripcionRangosLetras($result,$valor){
	$valor = number_format($valor,2,'.','');
	foreach ($result as $row){
		$mayor = trim($row["lit_alta"]);
		$menor = trim($row["lit_baja"]);
		if($valor >= $menor && $valor <= $mayor){
			return utf8_decode($row["lit_letra"]);
		}
	}
	return "";
}


function descripcionRangosTipificacion($result,$valor){
	$valor = number_format($valor,0,'','');
	foreach ($result as $row){
		$mayor = trim($row["tip_alta"]);
		$menor = trim($row["tip_baja"]);
		if($valor >= $menor && $valor <= $mayor){
			return utf8_decode($row["tip_califcacion"]);
		}
	}
	return "";
}



?>
