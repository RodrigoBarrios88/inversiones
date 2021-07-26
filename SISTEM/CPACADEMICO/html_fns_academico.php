<?php
include_once('../html_fns.php');

function tabla_grados_alumnos($sit,$pensum,$nivel,$grado){
	$ClsAlu = new ClsAlumno();
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$result = $ClsAlu->get_alumno("","","",1);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "30px" class = "text-center">No.</td>';
		$salida.= '<th width = "60px" class = "text-center">CUI</td>';
		$salida.= '<th width = "200px" class = "text-center">ALUMNO</td>';
		$salida.= '<th width = "100px" class = "text-center"><span class="fa fa-cogs"></span></td>';
		$salida.= '</div>';
		$salida.= '</thead>';
		/////////// Trae el array de secciones disponibles para ese pensum y ese grado con ese tipo de area (civil, militar o deportiva) //////////
		$result_Grado = $ClsPen->get_grado($pensum,$nivel,$grado,1);  ////// este array se coloca en la columna de combos
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'</td>';
			//catalogo
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//---
			$salida.= '<td class = "text-center" >';
			///--comprueba si el alumno ya tiene seccion, si no da la opcion para grabar.  Si ya tiene seccion da la opcion para modificar y señala que ya tiene...
			$result_grado_alumno = $ClsAcad->comprueba_grado_alumno($pensum,$nivel,"","",$cui,1);  ////// este array se coloca en la columna de combos
			if(is_array($result_grado_alumno)){
				foreach($result_grado_alumno as $row_grado_alumno){
					$codigo = $row_grado_alumno["graa_codigo"];
					$grado = $row_grado_alumno["graa_grado"];
				}
				$combo =  combos_html_onclick($result_Grado,"grado$i",'gra_codigo','gra_descripcion',"Asignar_Grado($i);");
				$salida.= $combo." &nbsp;";
				$salida.= '<span id = "spancheck'.$i.'" class="btn btn-success btn-xs" title = "Grado ya Asignada al Alumno" ><span class="fa fa-check-circle-o"></span></span> ';
				$salida.= '<script type = "text/javascript">document.getElementById("grado'.$i.'").value = '.$grado.'</script>';
				$salida.= '<input type = "hidden" name = "codigo'.$i.'" id = "codigo'.$i.'" value = "'.$codigo.'" />';
				$salida.= '<input type = "hidden" name = "gradoold'.$i.'" id = "gradoold'.$i.'" value = "'.$grado.'" />';
			}else{
				$combo =  combos_html_onclick($result_Grado,"grado$i",'gra_codigo','gra_descripcion',"Asignar_Grado($i);");
				$salida.= $combo." &nbsp;";
				$salida.= '<span id = "spancheck'.$i.'" title = "Grado ya Asignada al Alumno" ></span> ';
				$salida.= '<input type = "hidden" name = "codigo'.$i.'" id = "codigo'.$i.'" />';
				$salida.= '<input type = "hidden" name = "gradoold'.$i.'" id = "gradoold'.$i.'" />';
			}
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}

function tabla_secciones_alumnos($sit,$pensum,$nivel,$grado,$tipo){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_grado_alumno($pensum,$nivel,$grado,'','',1);;
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "30px" class = "text-center">No.</td>';
		$salida.= '<th width = "60px" class = "text-center">CUI</td>';
		$salida.= '<th width = "200px" class = "text-center">ALUMNO</td>';
		$salida.= '<th width = "100px" class = "text-center">GRADO</td>';
		$salida.= '<th width = "100px" class = "text-center"><span class="fa fa-cogs"></span></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		/////////// Trae el array de secciones disponibles para ese pensum y ese grado con ese tipo de area (civil, militar o deportiva) //////////
		$result_Seccion = $ClsPen->get_seccion($pensum,$nivel,$grado,"",$tipo,1); ////// este array se coloca en la columna de combos
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'</td>';
			//CUI
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//grado
			$gra = utf8_decode($row["gra_descripcion"]);
			$salida.= '<td class = "text-center">'.$gra.'</td>';
			//---
			$salida.= '<td class = "text-center" >';
			///--comprueba si el alumno ya tiene seccion, si no da la opcion para grabar.  Si ya tiene seccion da la opcion para modificar y señala que ya tiene...
			$result_seccion_alumno = $ClsAcad->comprueba_seccion_alumno($pensum,$nivel,$grado,"","",$cui,$tipo,1);  ////// este array se coloca en la columna de combos
			if(is_array($result_seccion_alumno)){
				foreach($result_seccion_alumno as $row_seccion_alumno){
					$codigo = $row_seccion_alumno["seca_codigo"];
					$seccion = $row_seccion_alumno["seca_seccion"];
				}
				$combo =  combos_html_onclick($result_Seccion,"seccion$i",'sec_codigo','sec_descripcion',"Asignar_Seccion($i);");
				$salida.= $combo." &nbsp;";
				$salida.= '<span id = "spancheck'.$i.'" class="btn btn-success btn-xs" title = "Secci&oacute;n ya Asignada al Alumno" ><span class="fa fa-check-circle-o"></span></span> ';
				$salida.= '<script type = "text/javascript">document.getElementById("seccion'.$i.'").value = '.$seccion.'</script>';
				$salida.= '<input type = "hidden" name = "codigo'.$i.'" id = "codigo'.$i.'" value = "'.$codigo.'" />';
				$salida.= '<input type = "hidden" name = "seccionold'.$i.'" id = "seccionold'.$i.'" value = "'.$seccion.'" />';
			}else{
				$combo =  combos_html_onclick($result_Seccion,"seccion$i",'sec_codigo','sec_descripcion',"Asignar_Seccion($i);");
				$salida.= $combo." &nbsp;";
				$salida.= '<span id = "spancheck'.$i.'" title = "Secci&oacute;n ya Asignada al Alumno" ></span> ';
				$salida.= '<input type = "hidden" name = "codigo'.$i.'" id = "codigo'.$i.'" />';
				$salida.= '<input type = "hidden" name = "seccionold'.$i.'" id = "seccionold'.$i.'" />';
			}
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}

function tabla_pensum($codigo,$anio){
	$ClsPen = new ClsPensum();
	$result = $ClsPen->get_pensum($codigo,$anio,'1,0');
	
	if(is_array($result)){
		$Thoras = 0;
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "70px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '<th width = "30px" class = "text-center">No.</td>';
		$salida.= '<th width = "200px" class = "text-center">Programa Acad&eacute;mico</td>';
		$salida.= '<th width = "50px" class = "text-center">A&ntilde;o</td>';
		$salida.= '<th width = "50px" class = "text-center">Situaci&oacute;n</td>';
		$salida.= '<th width = "50px" class = "text-center">Status</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$codigo = $row["pen_codigo"];
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default" onclick = "abrir();xajax_Buscar_Pensum('.$codigo.');" title = "Seleccionar Pensum" ><i class="fa fa-pencil"></i></button>';
					$salida.= '<button type="button" class="btn btn-danger" onclick = "Confirm_Elimina_Pensum('.$codigo.');" title = "Eliminar Pensum" ><i class="fa fa-trash"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//descripcion
			$desc = utf8_decode($row["pen_descripcion"]);
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//año
			$anio = trim($row["pen_anio"]);
			$salida.= '<td class = "text-center">'.$anio.'</td>';
			//situacion
			$sit = trim($row["pen_situacion"]);
			$situacion = ($sit == 1)?"<strong class='text-info'>Habilitado</strong>":"<strong class='text-danger'>Inhabilitado</strong>";
			$salida.= '<td class = "text-center" >'.$situacion.'</td>';
			//status
			$codigo = $row["pen_codigo"];
			$status = trim($row["pen_activo"]);
			$salida.= '<td class = "text-center">';
			if($status == 1){
				$salida.= '<a href="javascript:void(0);" title = "Desaactivar Pensum" ><i class="fa fa-toggle-on fa-2x text-success"></i></a>';
			}else{
				if($sit == 1){
					$salida.= '<a href="javascript:void(0);" onclick = "activacionPensum('.$codigo.');" title = "Activar Pensum" ><i class="fa fa-toggle-off fa-2x text-muted"></i></a>';
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

function tabla_niveles($pensum,$nivel,$sit){
	$ClsPen = new ClsPensum();
	$result = $ClsPen->get_nivel($pensum,$nivel,$sit);
	
	if(is_array($result)){
		$Thoras = 0;
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "70px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '<th width = "10px" class = "text-center">No.</td>';
		$salida.= '<th width = "200px" class = "text-center">Programa Acad&eacute;mico</td>';
		$salida.= '<th width = "50px" class = "text-center">A&ntilde;o</td>';
		$salida.= '<th width = "100px" class = "text-center">Nivel</td>';
		$salida.= '<th width = "50px" class = "text-center">Situaci&oacute;n</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$pensum = $row["niv_pensum"];
			$codigo = $row["niv_codigo"];
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default" onclick="abrir();xajax_Buscar_Nivel('.$pensum.','.$codigo.');" title = "Seleccionar Nivel" ><i class="fa fa-edit"></i></button>';
					$salida.= '<button type="button" class="btn btn-danger" onclick="Confirm_Elimina_Nivel('.$pensum.','.$codigo.');" title = "Deshabilitar Nivel" ><i class="fa fa-trash"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//descripcion
			$desc = utf8_decode($row["pen_descripcion"]);
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//año
			$anio = trim($row["pen_anio"]);
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


function tabla_grados($pensum,$nivel,$grado,$sit){
	$ClsPen = new ClsPensum();
	$result = $ClsPen->get_grado($pensum,$nivel,$grado,$sit);
	
	if(is_array($result)){
		$Thoras = 0;
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "70px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '<th width = "10px" class = "text-center">No.</td>';
		$salida.= '<th width = "150px" class = "text-center">Programa Acad&eacute;mico</td>';
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
			$pensum = $row["gra_pensum"];
			$nivel = $row["gra_nivel"];
			$codigo = $row["gra_codigo"];
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default" onclick="abrir();xajax_Buscar_Grado('.$pensum.','.$nivel.','.$codigo.');" title = "Seleccionar Grado" ><i class="fa fa-edit"></i></button>';
					$salida.= '<button type="button" class="btn btn-danger" onclick="Confirm_Elimina_Grado('.$pensum.','.$nivel.','.$codigo.');" title = "Deshabilitar Grado" ><i class="fa fa-trash"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//descripcion
			$desc = utf8_decode($row["pen_descripcion"]);
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//año
			$anio = trim($row["pen_anio"]);
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

function tabla_secciones($pensum,$nivel,$grado,$tipo,$sit){
	$ClsPen = new ClsPensum();
	$result = $ClsPen->get_seccion($pensum,$nivel,$grado,'',$tipo,$sit);
	
	if(is_array($result)){
		$Thoras = 0;
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "70px" class = "text-center"><i class="fa fa-cogs"></i></td>';
		$salida.= '<th width = "10px" class = "text-center">No.</td>';
		$salida.= '<th width = "150px" class = "text-center">Programa Acad&eacute;mico</td>';
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
			$pensum = $row["sec_pensum"];
			$nivel = $row["sec_nivel"];
			$grado = $row["sec_grado"];
			$codigo = $row["sec_codigo"];
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default" onclick="abrir();xajax_Buscar_Seccion('.$pensum.','.$nivel.','.$grado.','.$codigo.');" title = "Seleccionar Seccion" ><i class="fa fa-edit"></i></button>';
					$salida.= '<button type="button" class="btn btn-danger" onclick="Confirm_Elimina_Seccion('.$pensum.','.$nivel.','.$grado.','.$codigo.');" title = "Deshabilitar Seccion" ><i class="fa fa-trash"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//descripcion
			$desc = utf8_decode($row["pen_descripcion_completa"]);
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


function tabla_pensum_para_importar($pensum){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsAul = new ClsAula();
	
	$result_nivel = $ClsPen->get_nivel($pensum,"",$sit);
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
					$result_grados = $ClsPen->get_grado($pensum,$nivel);
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
											$result_secciones = $ClsPen->get_seccion($pensum,$nivel,$grado,'','',1);
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
											$result_materia = $ClsPen->get_materia($pensum,$nivel,$grado,'','',1);
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

function tabla_bloqueo($codigo){
	$ClsPen = new ClsPensum();
	$result = $ClsPen->get_nivel_bloqueo($codigo);
	
	if(is_array($result)){
		$Thoras = 0;
		$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "30px" class = "text-center">No.</td>';
		$salida.= '<th width = "200px" class = "text-center">Nivel</td>';
		$salida.= '<th width = "50px" class = "text-center">Pensum</td>';
		$salida.= '<th width = "50px" class = "text-center">Situaci&oacute;n</td>';
		$salida.= '<th width = "50px" class = "text-center">Estatus</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$codigo = $row["notv_codigo"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//descripcion
			$desc = utf8_decode($row["niv_descripcion"]);
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//año
			$anio = trim($row["pen_descripcion"]);
			$salida.= '<td class = "text-center">'.$anio.'</td>';
			//situacion
			$sit = trim($row["notv_status"]);
			$situacion = ($sit == 1)?"<strong class='text-info'>Habilitado</strong>":"<strong class='text-danger'>Inhabilitado</strong>";
			$salida.= '<td class = "text-center" >'.$situacion.'</td>';
			//status
			$codigo = $row["notv_codigo"];
			$status = trim($row["notv_status"]);
			$salida.= '<td class = "text-center">';
			if($status == 1){
				$salida.= '<a href="javascript:void(0);" onclick = "NovistaNota('.$codigo.');"  title = "Desaactivar Notas" ><i class="fa fa-toggle-on fa-2x text-success"></i></a>';
			}else{
				
					$salida.= '<a href="javascript:void(0);" onclick = "activacionNota('.$codigo.');" title = "Activar Notas" ><i class="fa fa-toggle-off fa-2x text-muted"></i></a>';
				
			}
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
	}
	
	return $salida;
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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


?>