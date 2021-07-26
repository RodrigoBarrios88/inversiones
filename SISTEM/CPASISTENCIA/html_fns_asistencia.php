<?php
include_once('../html_fns.php');


function tabla_horario_maestro($maestro,$dia){
	$ClsHor = new ClsHorario();
	$pensum = $_SESSION["pensum"];
	$result = $ClsHor->get_horario('','',$dia,'','','',$pensum,'','','','',$maestro,'');
	
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
			$grado = utf8_decode($row["gra_descripcion"]);
			$seccion = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$grado.' '.$seccion.'</td>';
			//materia
			$materia = utf8_decode($row["mat_descripcion"]);
			$salida.= '<td class = "text-center">'.$materia.'</td>';
			//aula
			$aula = utf8_decode($row["aul_descripcion"]);
			$salida.= '<td class = "text-center">'.$aula.'</td>';
			//--
			$horario = $row["hor_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsHor->encrypt($horario, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<a type="button" class="btn btn-primary" href = "FRMasistencia.php?hashkey='.$hashkey.'" title = "Tomar Asistencia" ><span class="fa fa-arrow-right"></span></a>';
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
	}
	
	return $salida;
}


function tabla_secciones_alumnos($pensum,$nivel,$grado,$seccion){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center"><input type = "checkbox" name="asistbase" id="asistbase" onclick = "check_lista_multiple(\'asist\');" /></td>';
			$salida.= '<th width = "300px" class = "text-center"></td>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center"><span class="fa fa-cogs"></span></td>';
			$salida.= '<th width = "30px" class = "text-center">No.</td>';
			$salida.= '<th width = "60px" class = "text-center">CUI</td>';
			$salida.= '<th width = "250px" class = "text-center">ALUMNO</td>';
			$salida.= '<th width = "250px" class = "text-center">COMENTARIO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//Check
			$salida.= '<td class = "text-center"><input type = "checkbox" name="asist'.$i.'" id="asist'.$i.'" value="'.$cui.'" /></td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//CUI
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//comentario
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "text" class="form-control" name = "comentario'.$i.'" id = "comentario'.$i.'" value="" />';
			$salida.= '</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
		$i--;
			$salida.= '</table>';
			$salida .= '<input type = "hidden" name="asistrows" id="asistrows" value='.$i.' />';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_asistencia_alumnos($horario,$fecha){
	$ClsAsist = new ClsAsistencia();
	$result = $ClsAsist->get_asistencia($horario,$fecha);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center"><input type = "checkbox" name="asistbase" id="asistbase" onclick = "check_lista_multiple(\'asist\');" /></td>';
			$salida.= '<th width = "300px" class = "text-center"></td>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center"><span class="fa fa-cogs"></span></td>';
			$salida.= '<th width = "30px" class = "text-center">No.</td>';
			$salida.= '<th width = "60px" class = "text-center">CUI</td>';
			$salida.= '<th width = "250px" class = "text-center">ALUMNO</td>';
			$salida.= '<th width = "250px" class = "text-center">COMENTARIO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			$sit = $row["asi_asistencia"];
			$chk = ($sit == 1)?"checked":"";
			//Check
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "checkbox" name="asist'.$i.'" id="asist'.$i.'" value="'.$cui.'" '.$chk.' />';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//CUI
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//comentario
			$comentario = utf8_decode($row["asi_comentario"]);
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "text" class="form-control" name = "comentario'.$i.'" id = "comentario'.$i.'" value="'.$comentario.'" />';
			$salida.= '</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
		$i--;
			$salida.= '</table>';
			$salida .= '<input type = "hidden" name="asistrows" id="asistrows" value='.$i.' />';
			$salida.= '</div>';
			$salida.= '</div>';
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
			$grado = utf8_decode($row["gra_descripcion"]);
			$seccion = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$grado.' '.$seccion.'</td>';
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
			$salida.= '<a type="button" class="btn btn-primary" href = "FRMdetalle_asistencia_seccion.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" title = "Detalle de Asistencia" ><span class="fa fa-search"></span></a>';
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



function tabla_detalle_asistencia_seccion($horario,$fecha){
	$ClsAsist = new ClsAsistencia();
	$result = $ClsAsist->get_asistencia($horario,$fecha);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "20px" class = "text-center">No.</td>';
			$salida.= '<th width = "60px" class = "text-center">CUI</td>';
			$salida.= '<th width = "250px" class = "text-center">ALUMNO</td>';
			$salida.= '<th width = "50px" class = "text-center"><span class="fa fa-cogs"></span></td>';
			$salida.= '<th width = "250px" class = "text-center">COMENTARIO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//CUI
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//status
			$sit = $row["asi_asistencia"];
			$color = ($sit == 1)?"text-success":"text-danger";
			$icon = ($sit == 1)?"check":"ban";
			$status = ($sit == 1)?"PRESENTE":"AUSENTE";
			$salida.= '<td class = "text-center '.$color.'"><i class="fa fa-'.$icon.'"></i> '.$status.'</td>';
			//comentario
			$comentario = $row["asi_comentario"];
			$salida.= '<td class = "text-left">'.utf8_decode($comentario).'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
		$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_lista_alumnos(){
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAlu = new ClsAlumno();
	
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	if($tipo_usuario === "1"){ /// SI el Usuario es Director
		$pensum = $ClsPen->get_pensum_activo();
		$result = $ClsAcad->get_otros_usuarios_alumnos($pensum,'','',$tipo_codigo);
	}else if($tipo_usuario === "2"){ /// SI el Usuario es Maestro
		$pensum = $ClsPen->get_pensum_activo();
		$result = $ClsAcad->get_maestro_alumnos($pensum,'','','',$tipo_codigo);
	}else{ // Si el Usuario es Administrador
		$pensum = $ClsPen->get_pensum_activo();
		$result = $ClsAcad->get_seccion_alumno($pensum,'','','','');
	}
	///---
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
		$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cog"></i></th>';
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
			//--
			$cui = $row["alu_cui"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsAcad->encrypt($cui, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<a class="btn btn-primary" href = "FRMdetalle_asistencia_alumno.php?hashkey='.$hashkey.'" target = "_blank" title = "Detalle de Asistencia" ><i class="fa fa-search"></i></a>';
			$salida.= '</td>';
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


function tabla_periodos_alumno($dia,$pensum,$nivel,$grado,$seccion){
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_horario('','',$dia,'','','',$pensum,$nivel,$grado,$seccion);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-periodos">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "70px">HORARIO</th>';
			$salida.= '<th class = "text-center" width = "60px">MATERIA</th>';
			$salida.= '<th class = "text-center" width = "60px">AULA</th>';
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
			//materia
			$materia = utf8_decode($row["mat_descripcion"]);
			$salida.= '<td class = "text-center">'.$materia.'</td>';
			//aula
			$aula = utf8_decode($row["aul_descripcion"]);
			$salida.= '<td class = "text-center">'.$aula.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$i--;
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_asistencias_alumno($fecha,$alumno){
	$ClsAsist = new ClsAsistencia();
	$result = $ClsAsist->get_horario_asistencia_alumno('',$fecha,$alumno);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-asistencia">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "70px">HORARIO</th>';
			$salida.= '<th class = "text-center" width = "60px">MATERIA</th>';
			$salida.= '<th class = "text-center" width = "60px">AULA</th>';
			$salida.= '<th class = "text-center" width = "60px">COMENTARIO</th>';
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
			//materia
			$materia = utf8_decode($row["mat_descripcion"]);
			$salida.= '<td class = "text-center">'.$materia.'</td>';
			//aula
			$aula = utf8_decode($row["aul_descripcion"]);
			$salida.= '<td class = "text-center">'.$aula.'</td>';
			//comentario
			$comentario = utf8_decode($row["asi_comentario"]);
			$salida.= '<td class = "text-center">'.$comentario.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$i--;
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_ausencias_alumno($alumno,$mes){
	$ClsAsist = new ClsAsistencia();
	$result = $ClsAsist->get_ausencia_alumno('','',$alumno,$mes);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-ausencia">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">D&Iacute;A Y FECHA</th>';
			$salida.= '<th class = "text-center" width = "70px">HORARIO</th>';
			$salida.= '<th class = "text-center" width = "60px">MATERIA</th>';
			$salida.= '<th class = "text-center" width = "60px">AULA</th>';
			$salida.= '<th class = "text-center" width = "60px">COMENTARIO</th>';
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
			//fecha
			$fec = $row["asi_fecha"];
			$dia = $dia = date('N', strtotime($fec));
			switch($dia){
				case 1: $dia_desc = "LUNES"; break;
				case 2: $dia_desc = "MARTES"; break;
				case 3: $dia_desc = "MIERCOLES"; break;
				case 4: $dia_desc = "JUEVES"; break;
				case 5: $dia_desc = "VIERNES"; break;
				case 6: $dia_desc = "SABADO"; break;
			}
			$fecha = cambia_fecha($fec);
			$salida.= '<td class = "text-center" >'.$dia_desc.' '.$fecha.'</td>';
			//horarios
			$ini = $row["per_hini"];
			$fin = $row["per_hfin"];
			$salida.= '<td class = "text-center">'.$ini.'-'.$fin.'</td>';
			//materia
			$materia = utf8_decode($row["mat_descripcion"]);
			$salida.= '<td class = "text-center">'.$materia.'</td>';
			//aula
			$aula = utf8_decode($row["aul_descripcion"]);
			$salida.= '<td class = "text-center">'.$aula.'</td>';
			
			//comentario
			$comentario = utf8_decode($row["asi_comentario"]);
			$salida.= '<td class = "text-center">'.$comentario.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$i--;
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_asistencia_maestro($fecha,$maestro){
	$ClsAsist = new ClsAsistencia();
	$result = $ClsAsist->get_horario_asistencia_maestro('',$fecha,'',$maestro);
	
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
			$grado = utf8_decode($row["gra_descripcion"]);
			$seccion = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$grado.' '.$seccion.'</td>';
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
			$salida.= '<a type="button" class="btn btn-primary" href = "FRMdetalle_asistencia_seccion.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" title = "Detalle de Asistencia" ><span class="fa fa-search"></span></a>';
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