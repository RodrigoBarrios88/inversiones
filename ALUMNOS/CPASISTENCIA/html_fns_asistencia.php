<?php
include_once('../html_fns.php');

///////////////////////////// ASISTENCIA DE CLASES //////////////////////////////////////

function tabla_periodos_alumno_materias($dia,$pensum,$nivel,$grado,$seccion){
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



function tabla_asistencias_alumno_materias($fecha,$alumno){
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



function tabla_ausencias_alumno_materias($alumno,$mes){
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


///////////////////////////// ASISTENCIA DE CURSOS LIBRES //////////////////////////////////////
function tabla_periodos_alumno_cursos($dia,$curso){
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_horario_cursos('','',$dia,'','','',$curso);
	
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



function tabla_asistencias_alumno_cursos($fecha,$alumno,$curso){
	$ClsAsist = new ClsAsistencia();
	$result = $ClsAsist->get_horario_asistencia_alumno_cursos('',$fecha,$alumno,'','','',$curso);
	
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



function tabla_ausencias_alumno_cursos($alumno,$mes,$curso){
	$ClsAsist = new ClsAsistencia();
	$result = $ClsAsist->get_ausencia_alumno_cursos('','',$alumno,$mes,$curso);
	
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

///////////////////////////////////////////////////////////////////////////////

function tabla_periodos_reservados($dia,$curso,$fecha,$alumno){
	$ClsAsist = new ClsAsistencia();
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_horario_cursos('','',$dia,'','','',$curso);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-periodos">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">CURSO</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "50px">HORARIO</th>';
			$salida.= '<th class = "text-center" width = "50px">AULA</th>';
			$salida.= '<th class = "text-center" width = "60px"><i class="fa fa-paste"></i></th>';
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
			$horario = $row["hor_codigo"];
			$result_reserva = $ClsAsist->get_reserva_asistencia($horario,$fecha,$alumno);
			if(is_array($result_reserva)){ //ya esta reservado (puede modifcar)
				foreach($result_reserva as $row_reserva){
					$asistencia = $row_reserva["reserva_asistencia"];
				}
				switch($asistencia){
					case 1:
						$btnout1 = "btn-outline";
						$btnout2 = "";
						$btnout0 = ""; break;
					case 2: 
						$btnout1 = "";
						$btnout2 = "btn-outline";
						$btnout0 = ""; break;
					case 0: 
						$btnout1 = "";
						$btnout2 = "";
						$btnout0 = "btn-outline"; break;
				}
			}else{  //aun no se ha reservado
				$asistencia = "";
				$btnout1 = "";
				$btnout2 = "";
				$btnout0 = "";
			}	
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-dafault '.$btnout1.' btn-xs" title = "Asistir&eacute;" onclick = "Reservar('.$i.',1);" ><i class="fa fa-check text-success"></i></button> ';
			$salida.= '<button type="button" class="btn btn-dafault '.$btnout0.' btn-xs" title = "No Asistir&eacute;" onclick = "Reservar('.$i.',0);" ><i class="fa fa-times text-danger"></i></button> ';
			$salida.= '<button type="button" class="btn btn-dafault '.$btnout2.' btn-xs" title = "Quiz&aacute;s (No reserva espacio)" onclick = "Reservar('.$i.',2);" ><i class="fa fa-question text-info"></i></button>';
			$salida.= '<input type = "hidden" name = "horario'.$i.'" id = "horario'.$i.'" value = "'.$horario.'" />';
			$salida.= '<input type = "hidden" name = "fecha'.$i.'" id = "fecha'.$i.'" value = "'.$fecha.'" />';
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$alumno.'" />';
			$salida.= '</td>';
			//-
			$salida.= '</tr>';
			$i++;
		}
		$i--;
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		$salida.= '<div class = " alert alert-warning text-center">';
		$salida.= '<i class="fa fa-warning"></i> No hay Periodos en este d&iacute;a. ';
		$salida.= '</div>';
	}
	
	return $salida;
}


?>