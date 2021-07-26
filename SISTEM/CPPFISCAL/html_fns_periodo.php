<?php
include_once('../html_fns.php');



function tabla_periodo($codigo,$anio){
	$ClsPer = new ClsPeriodoFiscal();
	$result = $ClsPer->get_periodo($codigo,$anio,'1,0');
	
	if(is_array($result)){
		$Thoras = 0;
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "70px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '<th width = "30px" class = "text-center">No.</td>';
		$salida.= '<th width = "200px" class = "text-center">Periodo Fiscal</td>';
		$salida.= '<th width = "50px" class = "text-center">A&ntilde;o</td>';
		$salida.= '<th width = "50px" class = "text-center">Situaci&oacute;n</td>';
		$salida.= '<th width = "50px" class = "text-center">Status</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$codigo = $row["per_codigo"];
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default" onclick = "abrir();xajax_Buscar_Periodo('.$codigo.');" title = "Seleccionar Periodo" ><i class="fa fa-pencil"></i></button>';
					$salida.= '<button type="button" class="btn btn-danger" onclick = "Confirm_Elimina_Periodo('.$codigo.');" title = "Eliminar Periodo" ><i class="fa fa-trash"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//descripcion
			$desc = utf8_decode($row["per_descripcion"]);
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//año
			$anio = trim($row["per_anio"]);
			$salida.= '<td class = "text-center">'.$anio.'</td>';
			//situacion
			$sit = trim($row["per_situacion"]);
			$situacion = ($sit == 1)?"<strong class='text-info'>Habilitado</strong>":"<strong class='text-danger'>Inhabilitado</strong>";
			$salida.= '<td class = "text-center" >'.$situacion.'</td>';
			//status
			$codigo = $row["per_codigo"];
			$status = trim($row["per_activo"]);
			$salida.= '<td class = "text-center">';
			if($status == 1){
				$salida.= '<a href="javascript:void(0);" title = "Desaactivar Periodo" ><i class="fa fa-toggle-on fa-2x text-success"></i></a>';
			}else{
				if($sit == 1){
					$salida.= '<a href="javascript:void(0);" onclick = "activacionPeriodo('.$codigo.');" title = "Activar Periodo" ><i class="fa fa-toggle-off fa-2x text-muted"></i></a>';
				}else{
					$salida.= '<a href="javascript:void(0);" title = "Inhabilitado..." ><i class="fa fa-toggle-off fa-2x text-muted"></i></a>';
				}
			}
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
	}
	
	return $salida;
}

function tabla_niveles($periodo,$nivel,$sit){
	$ClsPer = new ClsPeriodoFiscal();
	$result = $ClsPer->get_nivel($periodo,$nivel,$sit);
	
	if(is_array($result)){
		$Thoras = 0;
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "70px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '<th width = "10px" class = "text-center">No.</td>';
		$salida.= '<th width = "200px" class = "text-center">Periodo Fiscal</td>';
		$salida.= '<th width = "50px" class = "text-center">A&ntilde;o</td>';
		$salida.= '<th width = "100px" class = "text-center">Nivel</td>';
		$salida.= '<th width = "50px" class = "text-center">Situaci&oacute;n</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$periodo = $row["niv_periodo"];
			$codigo = $row["niv_codigo"];
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default" onclick="abrir();xajax_Buscar_Nivel('.$periodo.','.$codigo.');" title = "Seleccionar Nivel" ><i class="fa fa-edit"></i></button>';
					$salida.= '<button type="button" class="btn btn-danger" onclick="Confirm_Elimina_Nivel('.$periodo.','.$codigo.');" title = "Deshabilitar Nivel" ><i class="fa fa-trash"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//descripcion
			$desc = utf8_decode($row["per_descripcion"]);
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//año
			$anio = trim($row["per_anio"]);
			$salida.= '<td class = "text-center">'.$anio.'</td>';
			//descripcion
			$desc = utf8_decode($row["niv_descripcion"]);
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//situacion
			$sit = trim($row["niv_situacion"]);
			$sit = ($sit == 1)?"<strong class='text-success'>ACTIVO</strong>":"<strong class='text-danger'>INACTIVO</strong>";
			$salida.= '<td class = "text-center" >'.$sit.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
	}
	
	return $salida;
}


function tabla_grados($periodo,$nivel,$grado,$sit){
	$ClsPer = new ClsPeriodoFiscal();
	$result = $ClsPer->get_grado($periodo,$nivel,$grado,$sit);
	
	if(is_array($result)){
		$Thoras = 0;
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "70px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '<th width = "10px" class = "text-center">No.</td>';
		$salida.= '<th width = "150px" class = "text-center">Periodo Fiscal</td>';
		$salida.= '<th width = "50px" class = "text-center">A&ntilde;o</td>';
		$salida.= '<th width = "100px" class = "text-center">Nivel</td>';
		$salida.= '<th width = "100px" class = "text-center">Grado</td>';
		$salida.= '<th width = "50px" class = "text-center">Situaci&oacute;n</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$periodo = $row["gra_periodo"];
			$nivel = $row["gra_nivel"];
			$codigo = $row["gra_codigo"];
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default" onclick="abrir();xajax_Buscar_Grado('.$periodo.','.$nivel.','.$codigo.');" title = "Seleccionar Grado" ><i class="fa fa-edit"></i></button>';
					$salida.= '<button type="button" class="btn btn-danger" onclick="Confirm_Elimina_Grado('.$periodo.','.$nivel.','.$codigo.');" title = "Deshabilitar Grado" ><i class="fa fa-trash"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//descripcion
			$desc = utf8_decode($row["per_descripcion"]);
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//año
			$anio = trim($row["per_anio"]);
			$salida.= '<td class = "text-center">'.$anio.'</td>';
			//nivel
			$nivel = utf8_decode($row["niv_descripcion"]);
			$salida.= '<td class = "text-center">'.$nivel.'</td>';
			//descripcion
			$desc = utf8_decode($row["gra_descripcion"]);
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//situacion
			$sit = trim($row["gra_situacion"]);
			$sit = ($sit == 1)?"<strong class='text-success'>ACTIVO</strong>":"<strong class='text-danger'>INACTIVO</strong>";
			$salida.= '<td class = "text-center" >'.$sit.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
	}
	
	return $salida;
}

function tabla_secciones($periodo,$nivel,$grado,$tipo,$sit){
	$ClsPer = new ClsPeriodoFiscal();
	$result = $ClsPer->get_seccion($periodo,$nivel,$grado,'',$tipo,$sit);
	
	if(is_array($result)){
		$Thoras = 0;
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "70px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '<th width = "10px" class = "text-center">No.</td>';
		$salida.= '<th width = "150px" class = "text-center">Periodo Fiscal</td>';
		$salida.= '<th width = "50px" class = "text-center">Nivel</td>';
		$salida.= '<th width = "50px" class = "text-center">Grado</td>';
		$salida.= '<th width = "50px" class = "text-center">Seccion</td>';
		$salida.= '<th width = "50px" class = "text-center">Tipo</td>';
		$salida.= '<th width = "50px" class = "text-center">Situaci&oacute;n</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$periodo = $row["sec_periodo"];
			$nivel = $row["sec_nivel"];
			$grado = $row["sec_grado"];
			$codigo = $row["sec_codigo"];
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default" onclick="abrir();xajax_Buscar_Seccion('.$periodo.','.$nivel.','.$grado.','.$codigo.');" title = "Seleccionar Seccion" ><i class="fa fa-edit"></i></button>';
					$salida.= '<button type="button" class="btn btn-danger" onclick="Confirm_Elimina_Seccion('.$periodo.','.$nivel.','.$grado.','.$codigo.');" title = "Deshabilitar Seccion" ><i class="fa fa-trash"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//descripcion
			$desc = utf8_decode($row["per_descripcion_completa"]);
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//nivel
			$nivel = utf8_decode($row["niv_descripcion"]);
			$salida.= '<td class = "text-center">'.$nivel.'</td>';
			//grado
			$grado = utf8_decode($row["gra_descripcion"]);
			$salida.= '<td class = "text-center">'.$grado.'</td>';
			//descripcion
			$desc = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//tipo
			$tipo = trim($row["sec_tipo"]);
			switch($tipo){	
				case 'A': $tipo_desc = "ACADEMICA"; break;
				case 'P': $tipo_desc = "PRACTICA"; break;
				case 'D': $tipo_desc = "DEPORTIVA"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo_desc.'</td>';
			//situacion
			$sit = trim($row["sec_situacion"]);
			$sit = ($sit == 1)?"<strong class='text-success'>ACTIVO</strong>":"<strong class='text-danger'>INACTIVO</strong>";
			$salida.= '<td class = "text-center" >'.$sit.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
	}
	
	return $salida;
}


function tabla_periodo_para_importar($periodo){
	$ClsPer = new ClsPeriodoFiscal();
	$ClsAcad = new ClsAcademico();
	$ClsAul = new ClsAula();
	
	$result_nivel = $ClsPer->get_nivel($periodo,"",$sit);
	if(is_array($result_nivel)){
		$salida.= '<ul class="treeview">';
		$niveles=1;	//contador de niveles
		$grados=1;	//contador de grados
		$secciones=1;	//contador de secciones
		$materias=1;	//contador de materias
		foreach($result_nivel as $row){
			$salida.= '<li>';
			//No.
			$nivel = $row["niv_codigo"];
			//descripcion
			$desc = utf8_decode($row["niv_descripcion"]);
			$salida.='<input type = "checkbox" id = "N'.$niveles.'" value = "N'.$nivel.'" checked /> NIVEL: '.$desc.' ';
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
						foreach($result_grados as $row_grado){
							$salida.= '<li>';
							//No.
							$grado = $row_grado["gra_codigo"];
							//descripcion
							$desc = utf8_decode($row_grado["gra_descripcion"]);
							$salida.= '<input type = "checkbox" id = "G'.$grados.'" value = "N'.$nivel.'G'.$grado.'" checked /> GRADO: '.$desc.' ';
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
												foreach($result_secciones as $row_seccion){
													$salida.= '<li>';
													$seccion = $row_grado["sec_codigo"];
													//descripcion
													$desc = utf8_decode($row_seccion["sec_descripcion"]);
													$salida.= '<input type = "checkbox" id = "S'.$secciones.'" value = "N'.$nivel.'G'.$grado.'S'.$seccion.'" checked /> SECCI&Oacute;N: '.$desc.' ';
													//tipo
													$tipo = utf8_decode($row_seccion["sec_tipo"]);
													switch($tipo){	
														case 'A': $tipo_desc = "ACADEMICA"; break;
														case 'P': $tipo_desc = "PRACTICA"; break;
														case 'D': $tipo_desc = "DEPORTIVA"; break;
													}
													$salida.= ' - TIPO: '.$tipo_desc.' ';
													$salida.= '</li>';
													$secciones++;
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
												foreach($result_materia as $row_materia){
													$salida.= '<li>';
													//No.
													$materia = $row_materia["mat_codigo"];
													//descripcion
													$desc = utf8_decode($row_materia["mat_descripcion"]);
													$salida.= '<input type = "checkbox" id = "M'.$materias.'" value = "N'.$nivel.'G'.$grado.'M'.$materia.'" checked /> MATERIA: '.$desc.' ';
													//tipo
													$tipo = utf8_decode($row_materia["sec_tipo"]);
													switch($tipo){	
														case 'A': $tipo_desc = "ACADEMICA"; break;
														case 'P': $tipo_desc = "PRACTICA"; break;
														case 'D': $tipo_desc = "DEPORTIVA"; break;
													}
													$salida.= ' - TIPO: '.$tipo_desc.' ';
													
													$salida.= '</li>';
													$materias++;
												}
											}
										$salida.= '</ul>';
									$salida.= '</li>';///finalizan Materias
									
								$salida.= '</ul>';
							$salida.= '</li>'; ///finalizan Grado
							$grados++;
						}
					}
					$salida.= '</ul>'; ///---
				$salida.= '</li>'; ///---
				
				$salida.= '</ul>';
			$salida.= '</li>'; ///finalizan Nivel
			$niveles++;
		}
		$salida.= '</ul>';
		///finalizan Principal
		$niveles--;
		$grados--;
		$secciones--;
		$materias--;
		$salida.= '<input type = "hidden" id = "Nfilas" id = "Nfilas" value = "'.$niveles.'" />';
		$salida.= '<input type = "hidden" id = "Gfilas" id = "Gfilas" value = "'.$grados.'" />';
		$salida.= '<input type = "hidden" id = "Sfilas" id = "Sfilas" value = "'.$secciones.'" />';
		$salida.= '<input type = "hidden" id = "Mfilas" id = "Mfilas" value = "'.$materias.'" />';
	}
	
	return $salida;
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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


?>