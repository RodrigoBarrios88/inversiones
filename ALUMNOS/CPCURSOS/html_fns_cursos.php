<?php 
include_once('../html_fns.php');

function lista_cursos($cui){
	$ClsCur = new ClsCursoLibre();
	////// Trae las materias a listar en las notas
	$result = $ClsCur->get_curso_alumno('',$cui);
	if(is_array($result)){
		//------------------------------------------------------------------------------------------------------
		$salida.='<br>';
		$salida.='<div class="panel-body users-list">';
		$salida.='<div class="row-fluid table">';
		$salida.='<table class="table table-hover">';
		$salida.='<tr>';
		$salida.='<th class = "text-center" width = "15px" >No.</th>';
		$salida.='<th class = "text-center" width = "30px" >Curso</th>';
		$salida.='<th class = "text-center" width = "50px" ></th>';
		$salida.='</tr>';
		$salida.='</thead>';
				//--
		$i = 1;
		foreach($result as $row){
			$curso = $row["cur_codigo"];
			$descripcion = utf8_decode($row["cur_nombre"]);
			$salida.='</tr>';
			//--
			$salida.='<th class = "text-center">'.$i.'.</th>';
			//--
			$salida.='<td class = "text-left">';
			$salida.='<a href="FRMdetalle.php?cui='.$cui.'&curso='.$curso.'" target = "_blank" class="name">'.$descripcion.'</a>';
			$salida.='</td>';
			//--
			$salida.='<td>';
			$salida.='<a class="btn-glow primary" href="FRMdetalle.php?cui='.$cui.'&curso='.$curso.'" target = "_blank" title="Ver detalle del Curso" ><i class="icon icon-profile"></i></a>';
			$salida.='</td>';
			//--
			$salida.='</tr>';
			$i++;
		}
		$salida.='</table>';
		$salida.='</div>';
		$salida.='</div>';
		$salida.='<br>';
		//------------------------------------------------------------------------------------------------------
	}
	//--

	return $salida;
}




function lista_notas($cui,$curso){
	$nota_minima = 65;
	$ClsNot = new ClsNotas();
	
	$salida.='<br>';
	$salida.='<table class="display" width="100%" cellspacing="0" border="1">';
	$salida.='<thead>';
	$salida.='<tr>';
	$salida.='<th class = "text-center" width = "15px" rowspan = "2" >No.</th>';
	$salida.='<th class = "text-center" width = "150px" colspan = "3">1. Unidad</th>';
	$salida.='<th class = "text-center" width = "150px" colspan = "3">2. Unidad</th>';
	$salida.='<th class = "text-center" width = "150px" colspan = "3">3. Unidad</th>';
	$salida.='<th class = "text-center" width = "150px" colspan = "3">4. Unidad</th>';
	$salida.='<th class = "text-center" width = "150px" colspan = "3">5. Unidad</th>';
	$salida.='</tr>';
	$salida.='<tr>';
	//--1.
	$salida.='<th class = "text-center" width = "50px">Zona</th>';
	$salida.='<th class = "text-center" width = "50px">Nota</th>';
	$salida.='<th class = "text-center" width = "50px">TOTAL</th>';
	//--2.
	$salida.='<th class = "text-center" width = "50px">Zona</th>';
	$salida.='<th class = "text-center" width = "50px">Nota</th>';
	$salida.='<th class = "text-center" width = "50px">TOTAL</th>';
	//--3.
	$salida.='<th class = "text-center" width = "50px">Zona</th>';
	$salida.='<th class = "text-center" width = "50px">Nota</th>';
	$salida.='<th class = "text-center" width = "50px">TOTAL</th>';
	//--4.
	$salida.='<th class = "text-center" width = "50px">Zona</th>';
	$salida.='<th class = "text-center" width = "50px">Nota</th>';
	$salida.='<th class = "text-center" width = "50px">TOTAL</th>';
	//--5.
	$salida.='<th class = "text-center" width = "50px">Zona</th>';
	$salida.='<th class = "text-center" width = "50px">Nota</th>';
	$salida.='<th class = "text-center" width = "50px">TOTAL</th>';
	$salida.='</tr>';
	$salida.='</thead>';
	//------------------------------------------------------------------------------------------------------
	//tabla de Notas
	$salida.='</tr>';
		$salida.='<td class = "text-center">1.</td>';
	for($z = 1; $z <= 5; $z++){
		$result = $ClsNot->get_notas_alumno_tarjeta($cui,$pensum,$nivel,$grado,$seccion,$materia,$z);
		if(is_array($result)){
			$total = 0;
			foreach($result as $row){
				$zona = $row["not_zona"];
				$nota = $row["not_nota"];
			}
			$total = ($zona + $nota);
			//---
		}else{
			$zona = "-";
			$nota = "-";
			$total = "-";
		}
		$color = ($total <= $nota_minima )?"text-danger":"";
		$salida.='<td class = "text-center">'.$zona.'</td>';
		$salida.='<td class = "text-center">'.$nota.'</th>';
		$salida.='<td class = "text-center"><label class = "'.$color.'">'.$total.'</label></th>';	
	}
	$salida.='</tr>';
	$salida.='</table>';
	$salida.='<br>';
	//--
	
	return $salida;
}




function lista_horarios($curso){
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_horario_cursos('','','','','','',$curso);
	if (is_array($result)) {
		$salida.='<br>';
		$salida.='<table class="display" width="100%" cellspacing="0" border="1">';
		$salida.='<thead>';
		$salida.='<tr>';
		$salida.='<th class = "text-center" width = "15px" >No.</th>';
		$salida.='<th class = "text-center" width = "150px">PERIODO</th>';
		$salida.='<th class = "text-center" width = "50px">TIEMPO</th>';
		$salida.='<th class = "text-center" width = "60px">HORARIO</th>';
		$salida.='<th class = "text-center" width = "100px">DIA</th>';
		$salida.='</tr>';
		$salida.='</thead>';
		//------------------------------------------------------------------------------------------------------
		$i = 1;	
		foreach ($result as $row){
			$salida.='</tr>';
			
			$periodo = utf8_decode($row["tip_descripcion"]);
			$tiempo = $row["tip_minutos"]." MINUTOS";
			$hini = $row["per_hini"];
			$hfin = $row["per_hfin"];
			$dia = trim($row["per_dia"]);
			switch($dia){	
				case '1': $dia_desc = "LUNES"; break;
				case '2': $dia_desc = "MARTES"; break;
				case '3': $dia_desc = "MIERCOLES"; break;
				case '4': $dia_desc = "JUEVES"; break;
				case '5': $dia_desc = "VIERNES"; break;
				case '6': $dia_desc = "SABADO"; break;
				case '7': $dia_desc = "DOMINGO"; break;
			}
			$salida.='<td class = "text-center">'.$i.'.</td>';
			$salida.='<td class = "text-left">'.$periodo.'</td>';
			$salida.='<td class = "text-center">'.$tiempo.' MINUTOS</td>';
			$salida.='<td class = "text-center">'.$hini.'-'.$hfin.'</td>';
			$salida.='<td class = "text-center">'.$dia_desc.'</td>';
			$salida.='</tr>';
			$i++;
		}
		$salida.='</table>';
		$salida.='<br>';
		//--
	}else{
		$salida = '<h4 class = "alert alert-warning">No se reportan horarios asignados..</h4>';
	}
	
	return $salida;
}


?>