<?php
include_once('../html_fns.php');


function tabla_horario_maestro($maestro,$dia){
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_horario_cursos('','',$dia,'','','','',$maestro,'');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "70px">HORARIO</th>';
			$salida.= '<th class = "text-center" width = "150px">CURSO</th>';
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
			//curso
			$curso = utf8_decode($row["cur_nombre"]);
			$salida.= '<td class = "text-center">'.$curso.'</td>';
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


function tabla_lista_alumnos($curso){
	$ClsCur = new ClsCursoLibre();
	$result = $ClsCur->get_curso_alumno($curso,'');
	
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
	$result = $ClsAsist->get_asistencia_cursos($horario,$fecha);
	
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


function tabla_asistencia_curso($fecha,$curso){
	$ClsAsist = new ClsAsistencia();
	$result = $ClsAsist->get_horario_asistencia_curso('',$fecha,$curso);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "70px">HORARIO</th>';
			$salida.= '<th class = "text-center" width = "150px">CURSO</th>';
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
			//curso
			$curso = utf8_decode($row["cur_nombre"]);
			$salida.= '<td class = "text-center">'.$curso.'</td>';
			//aula
			$aula = utf8_decode($row["aul_descripcion"]);
			$salida.= '<td class = "text-center">'.$aula.'</td>';
			//--
			$horario = $row["asi_horario"];
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsAsist->encrypt($horario, $usu);
			$hashkey2 = $ClsAsist->encrypt($fecha, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<a type="button" class="btn btn-primary" href = "FRMdetalle_asistencia_curso.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" title = "Detalle de Asistencia" ><span class="fa fa-search"></span></a>';
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



function tabla_detalle_asistencia_curso($horario,$fecha){
	$ClsAsist = new ClsAsistencia();
	$result = $ClsAsist->get_asistencia_cursos($horario,$fecha);
	
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


function tabla_lista_alumnos_detalle($curso){
	$ClsCur = new ClsCursoLibre();
	$result = $ClsCur->get_curso_alumno($curso,'');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" class = "text-center">No.</td>';
			$salida.= '<th width = "60px" class = "text-center">CUI</td>';
			$salida.= '<th width = "200px" class = "text-center">ALUMNO</td>';
			$salida.= '<th width = "150px" class = "text-center">CURSO</td>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cog"></i></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//cui
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//curso
			$curso = utf8_decode($row["cur_nombre"]);
			$salida.= '<td class = "text-left">'.$curso.'</td>';
			//--
			$cui = $row["alu_cui"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsCur->encrypt($cui, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<a type="button" class="btn btn-primary" href = "FRMdetalle_asistencia_alumno.php?hashkey='.$hashkey.'" target = "_blank" title = "Detalle de Asistencia" ><span class="fa fa-search"></span></a>';
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


function tabla_periodos_alumno($dia){
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_horario_cursos('','',$dia,'','','','');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-periodos">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">CURSO</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "70px">HORARIO</th>';
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
			//curso
			$curso = utf8_decode($row["cur_nombre"]);
			$salida.= '<td class = "text-left" >'.$curso.'</td>';
			//duracion
			$min = $row["tip_minutos"];
			$salida.= '<td class = "text-center" >'.$min.' MINUTOS</td>';
			//horarios
			$ini = $row["per_hini"];
			$fin = $row["per_hfin"];
			$salida.= '<td class = "text-center">'.$ini.'-'.$fin.'</td>';
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
	$result = $ClsAsist->get_horario_asistencia_alumno_cursos('',$fecha,$alumno);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-asistencia">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">CURSO</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "70px">HORARIO</th>';
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
			//curso
			$curso = utf8_decode($row["cur_nombre"]);
			$salida.= '<td class = "text-left" >'.$curso.'</td>';
			//duracion
			$min = $row["tip_minutos"];
			$salida.= '<td class = "text-center" >'.$min.' MINUTOS</td>';
			//horarios
			$ini = $row["per_hini"];
			$fin = $row["per_hfin"];
			$salida.= '<td class = "text-center">'.$ini.'-'.$fin.'</td>';
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



function tabla_ausencias_alumno($alumno,$mes){
	$ClsAsist = new ClsAsistencia();
	$result = $ClsAsist->get_ausencia_alumno_cursos('','',$alumno,$mes);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-ausencia">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">CURSO</th>';
			$salida.= '<th class = "text-center" width = "150px">D&Iacute;A Y FECHA</th>';
			$salida.= '<th class = "text-center" width = "70px">HORARIO</th>';
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
			//curso
			$curso = utf8_decode($row["cur_nombre"]);
			$salida.= '<td class = "text-left" >'.$curso.'</td>';
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



function tabla_asistencia_maestro($fecha,$maestro){
	$ClsAsist = new ClsAsistencia();
	$result = $ClsAsist->get_horario_asistencia_maestro_cursos('',$fecha,'',$maestro);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "70px">HORARIO</th>';
			$salida.= '<th class = "text-center" width = "150px">CURSO</th>';
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
			//curso
			$curso = utf8_decode($row["cur_nombre"]);
			$salida.= '<td class = "text-center">'.$curso.'</td>';
			//aula
			$aula = utf8_decode($row["aul_descripcion"]);
			$salida.= '<td class = "text-center">'.$aula.'</td>';
			//--
			$horario = $row["asi_horario"];
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsAsist->encrypt($horario, $usu);
			$hashkey2 = $ClsAsist->encrypt($fecha, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<a type="button" class="btn btn-primary" href = "FRMdetalle_asistencia_curso.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" title = "Detalle de Asistencia" ><span class="fa fa-search"></span></a>';
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
		$salida.='<h6 class="alert alert-warning text-center"> <i class="fa fa-warning"></i> No hay asistencia registrada para este curso, este d&iacute;a...</h6>';
		$salida.='</div>';
	}
	
	return $salida;
}




///////////////// CONFIRMACIONES DE ASISTENCIA A CLASES DE CURSO LIBRE //////////////////////

function tabla_horarios_confirmar($fecha,$dia,$curso){
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_horario_cursos('','',$dia,'','','',$curso,'','');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "70px">HORARIO</th>';
			$salida.= '<th class = "text-center" width = "150px">CURSO</th>';
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
			//curso
			$curso = utf8_decode($row["cur_nombre"]);
			$salida.= '<td class = "text-center">'.$curso.'</td>';
			//aula
			$aula = utf8_decode($row["aul_descripcion"]);
			$salida.= '<td class = "text-center">'.$aula.'</td>';
			//--
			$horario = $row["hor_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsHor->encrypt($horario, $usu);
			$hashkey2 = $ClsHor->encrypt($fecha, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<a type="button" class="btn btn-primary" href = "FRMdetalle_confirmacion_asistencia_curso.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" title = "Detalle de Asistencia" ><span class="fa fa-search"></span></a>';
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



function tabla_detalle_confirmacion_asistencia_curso($horario,$fecha){
	$ClsAsist = new ClsAsistencia();
	$result = $ClsAsist->get_reserva_horario_asistencia_alumno($horario,$fecha);
	
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
			$sit = $row["reserva_asistencia"];
			switch($sit){
				case 0:
					$status = "NO PODR&Aacute;";
					$icon = "ban";
					$color = "text-danger";
					break;
				case 1:
					$status = "CONFIRMADO";
					$icon = "check";
					$color = "text-success";
					break;
				case 2:
					$status = "QU&Iacute;ZAS";
					$icon = "info-circle";
					$color = "text-info";
					break;
			}
			$salida.= '<td class = "text-center '.$color.'"><i class="fa fa-'.$icon.'"></i> '.$status.'</td>';
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


?>