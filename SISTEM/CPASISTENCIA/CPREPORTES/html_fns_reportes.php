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
			$gra = utf8_decode($row["gra_descripcion"]);
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
			$gra = utf8_decode($row["gra_descripcion"]);
			$salida.= '<td class = "text-center">'.$gra.'</td>';
			//seccion
			$sec = utf8_decode($row["sec_descripcion"]);
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

function tabla_asistencia_seccion($fecha,$pensum,$nivel,$grado,$seccion){
	$ClsAsist = new ClsAsistencia();
	$result = $ClsAsist->get_horario_asistencia_seccion('',$fecha,$pensum,$nivel,$grado,$seccion);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "70px">HORARIO</th>';
			$salida.= '<th class = "text-center" width = "150px">Grado y Secci&oacute;n</th>';
			$salida.= '<th class = "text-center" width = "60px">MATERIA</th>';
			$salida.= '<th class = "text-center" width = "60px">AULA</th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cog"></i></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$dia = $row["per_dia"];
			$hini = $row["per_hini"];
			$salida.= '<td class = "text-center">'.$i.'.';
			$salida.= '</td>';
			//duracion
			$min = $row["tip_minutos"];
			$salida.= '<td class = "text-center" >'.$min.' MINUTOS</td>';
			//horarios
			$ini = $row["per_hini"];
			$fin = $row["per_hfin"];
			$salida.= '<td class = "text-center">'.$ini.'-'.$fin.'</td>';
			//--
			$grado1 = utf8_decode($row["gra_descripcion"]);
			$seccion1 = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$grado1.' '.$seccion1.'</td>';
			//materia
			$materia = utf8_decode($row["mat_descripcion"]);
			$salida.= '<td class = "text-center">'.$materia.'</td>';
			//aula
			$aula = utf8_decode($row["aul_descripcion"]);
			$salida.= '<td class = "text-center">'.$aula.'</td>';
			//--
			$horario = $row["asi_horario"];
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsAsist->encrypt($horario, $usu);
			$hashkey2 = $ClsAsist->encrypt($fecha, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<a type="button" class="btn btn-success" id = "excel"  href = "EXCELnomina_seccion.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&materia='.utf8_encode($materia).'&nivel='.$nivel.'&grado='.$grado.'&seccion='.$seccion.'"><span class="fa fa-file-excel-o"></span> Excel</a>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$i--;
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		$salida='<div class="panel-body">';
		$salida.='<h6 class="alert alert-warning text-center"> <i class="fa fa-warning"></i> No hay asistencia registrada para esta secci&oacute;n este d&iacute;a...</h6>';
		$salida.='</div>';
	}
	
	return $salida;
}


?>
