<?php
include_once('../../html_fns.php');

function tabla_esquema($curso){
	$ClsCur = new ClsCursoLibre();
	$ClsTar = new ClsTarea();
	$ClsExa = new ClsExamen();
	
	$result = $ClsCur->get_tema($cod,$curso);
	if(is_array($result)){
			$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">Fila</td>';
			$salida.= '<th width = "10px" class = "text-center">PERIODOS</td>';
			$salida.= '<th width = "150px" class = "text-center">TEMA</td>';
			$salida.= '<th width = "150px" class = "text-center">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th width = "20px" class = "text-center"></td>';
			$salida.= '<th width = "40px" class = "text-center"></td>';
			$salida.= '<th width = "40px" class = "text-center"></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		$temnum = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$tema = $row["tem_codigo"];
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//cantidad de periodos
			$periodos = trim($row["tem_cantidad_periodos"]);
			$salida.= '<td class = "text-center">'.$periodos.'</td>';
			//nombre del tema
			$nombre = utf8_decode($row["tem_nombre"]);
			$salida.= '<td class = "text-left">TEMA '.$temnum.': &nbsp; '.$nombre.'</td>';
			//descripcion
			$desc = utf8_decode($row["tem_descripcion"]);
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//--
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			//--
			$salida.= '</tr>';
			$i++;
			/////////////// TAREAS POR TEMA //////////
			$result_tareas = $ClsTar->get_tarea_curso('',$curso,$tema);
			if(is_array($result_tareas)){
				//limpieza
				$unidad = "";
				$nom = "";
				$periodos = "";
				$desc = "";
				//encabezados
				$salida.= '<tr class = "info">';
				//--
				$salida.= '<td class = "text-center">'.$i.'. </td>';
				$salida.= '<td></td>';
				$salida.= '<td class = "text-center"><label>TAREA (TEMA '.$temnum.')</label></td>';
				$salida.= '<td class = "text-center"><label>DESCRIPCI&Oacute;N (TAREA)</label></td>';
				$salida.= '<td class = "text-center"><label>PUNTEO</label></td>';
				$salida.= '<td class = "text-center"><label>FECHA DE ENTREGA</label></td>';
				$salida.= '<td class = "text-center"><label>TIPO</label></td>';
				//--
				$salida.= '</tr>';
				$i++;
				foreach($result_tareas as $row_tarea){
					$salida.= '<tr class = "info">';
					//--
					$salida.= '<td class = "text-center">'.$i.'. </td>';
					$salida.= '<td></td>';
					//nombre
					$nombre = utf8_decode($row_tarea["tar_nombre"]);
					$salida.= '<td class = "text-left">TAREA (TEMA '.$temnum.'): &nbsp; '.$nombre.'</td>';
					//descripcion
					$desc = utf8_decode($row_tarea["tar_descripcion"]);
					$salida.= '<td class = "text-center">'.$desc.'</td>';
					//punteo
					$pondera = trim($row_tarea["tar_ponderacion"]);
					$tipo_pondera = trim($row_tarea["tar_tipo_calificacion"]);
					$tipo_pondera = ($tipo_pondera == "Z")?"Actividades":"AL Evaluaciones";
					$salida.= '<td class = "text-center">'.$pondera.'/'.$tipo_pondera.'</td>';
					//fecha de entreda
					$fecha = utf8_decode($row_tarea["tar_fecha_entrega"]);
					$fecha = cambia_fechaHora($fecha);
					$fecha = substr($fecha, 0, -3);
					$salida.= '<td class = "text-center">'.$fecha.'</td>';
					//TIPO
					$tipo = utf8_decode($row_tarea["tar_tipo"]);
					$tipo = ($tipo == "OL")?"EN L&Iacute;NEA":"EN CLASE";
					$salida.= '<td class = "text-center">'.$tipo.'</td>';
					//--
					$salida.= '</tr>';
					$i++;
				}	
			}
			/////////////// ! FIN TAREAS POR TEMA //////////
			/////////////// EXAMENES POR TEMA //////////
			$result_examenes = $ClsExa->get_examen_curso('',$curso,$tema);
			if(is_array($result_examenes)){
				//limpieza
				$unidad = "";
				$nom = "";
				$periodos = "";
				$desc = "";
				//encabezados
				$salida.= '<tr class = "success">';
				//--
				$salida.= '<td class = "text-center">'.$i.'. </td>';
				$salida.= '<td></td>';
				$salida.= '<td class = "text-center"><label>Evaluaciones (TEMA '.$temnum.')</label></td>';
				$salida.= '<td class = "text-center"><label>DESCRIPCI&Oacute;N (Evaluaciones)</label></td>';
				$salida.= '<td class = "text-center"><label>PUNTEO</label></td>';
				$salida.= '<td class = "text-center"><label>FECHA DE EVALUACI&Oacute;N</label></td>';
				$salida.= '<td class = "text-center"><label>TIPO</label></td>';
				//--
				$salida.= '</tr>';
				$i++;
				foreach($result_examenes as $row_examenes){
					$salida.= '<tr class = "success">';
					//--
					$salida.= '<td class = "text-center">'.$i.'. </td>';
					$salida.= '<td></td>';
					//nombre
					$titulo = utf8_decode($row_examenes["exa_titulo"]);
					$salida.= '<td class = "text-left">Evaluaciones (TEMA '.$temnum.'): &nbsp; '.$titulo.'</td>';
					//descripcion
					$desc = utf8_decode($row_examenes["exa_descripcion"]);
					$salida.= '<td class = "text-center">'.$desc.'</td>';
					//punteo
					$pondera = number_format($row_examenes["exa_ponderacion"],2,'.','');
					$tipo_pondera = trim($row_examenes["exa_tipo_calificacion"]);
					$tipo_pondera = ($tipo_pondera == "Z")?"Actividades":"AL Evaluaciones";
					$salida.= '<td class = "text-center">'.$pondera.'/'.$tipo_pondera.'</td>';
					//fecha de entreda
					$fecha = utf8_decode($row_examenes["exa_fecha_inicio"]);
					$fecha = cambia_fechaHora($fecha);
					$fecha = substr($fecha, 0, -3);
					$salida.= '<td class = "text-center">'.$fecha.'</td>';
					//TIPO
					$tipo = utf8_decode($row_examenes["exa_tipo"]);
					$tipo = ($tipo == "OL")?"EN L&Iacute;NEA":"EN CLASE";
					$salida.= '<td class = "text-center">'.$tipo.'</td>';
					//--
					$salida.= '</tr>';
					$i++;
				}	
			}
			/////////////// ! FIN EXAMENES POR TEMA //////////
			$temnum++;
		}
		
		/////////////// EXAMENES GLOBALES //////////
		$result_examenes = $ClsExa->get_examen_curso('',$curso,0);
		if(is_array($result_examenes)){
			//limpieza
			$unidad = "";
			$nom = "";
			$periodos = "";
			$desc = "";
			//encabezados
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			$salida.= '<td></td>';
			$salida.= '<td class = "text-center"><label>EvaluacionesES GLOBALES</label></td>';
			$salida.= '<td class = "text-center"><label>DESCRIPCI&Oacute;N (Evaluaciones)</label></td>';
			$salida.= '<td class = "text-center"><label>PUNTEO</label></td>';
			$salida.= '<td class = "text-center"><label>FECHA DE EVALUACI&Oacute;N</label></td>';
			$salida.= '<td class = "text-center"><label>TIPO</label></td>';
			//--
			$salida.= '</tr>';
			$i++;
			foreach($result_examenes as $row_examenes){
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center">'.$i.'. </td>';
				$salida.= '<td></td>';
				//nombre
				$titulo = utf8_decode($row_examenes["exa_titulo"]);
				$salida.= '<td class = "text-left">Evaluaciones (TEMA '.$temnum.'): &nbsp; '.$titulo.'</td>';
				//descripcion
				$desc = utf8_decode($row_examenes["exa_descripcion"]);
				$salida.= '<td class = "text-center">'.$desc.'</td>';
				//punteo
				$pondera = number_format($row_examenes["exa_ponderacion"],2,'.','');
				$tipo_pondera = trim($row_examenes["exa_tipo_calificacion"]);
				$tipo_pondera = ($tipo_pondera == "Z")?"Actividades":"AL Evaluaciones";
				$salida.= '<td class = "text-center">'.$pondera.'/'.$tipo_pondera.'</td>';
				//fecha de entreda
				$fecha = utf8_decode($row_examenes["exa_fecha_inicio"]);
				$fecha = cambia_fechaHora($fecha);
				$fecha = substr($fecha, 0, -3);
				$salida.= '<td class = "text-center">'.$fecha.'</td>';
				//TIPO
				$tipo = utf8_decode($row_examenes["exa_tipo"]);
				$tipo = ($tipo == "OL")?"EN L&Iacute;NEA":"EN CLASE";
				$salida.= '<td class = "text-center">'.$tipo.'</td>';
				//--
				$salida.= '</tr>';
				$i++;
			}	
		}
		/////////////// ! FIN EXAMENES POR TEMA //////////
		$salida.= '</table>';
	}
	
	return $salida;
}



function tabla_cursos_para_asignar($cod,$sede,$clase,$nom,$anio,$mes,$fini,$ffin){
	$ClsCur = new ClsCursoLibre();
	$result = $ClsCur->get_curso($cod,$sede,$clase,$nom,$anio,$mes,$fini,$ffin);
	
	if(is_array($result)){
		$Thoras = 0;
			$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "150px" class = "text-center">NOMBRE</td>';
			$salida.= '<th width = "250px" class = "text-center">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th width = "100px" class = "text-center">FECHAS</td>';
			$salida.= '<th width = "30px" class = "text-center"><i class="fa fa-cogs"></i></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//nombre
			$nombre = utf8_decode($row["cur_nombre"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//descripcion
			$desc = utf8_decode($row["cur_descripcion"]);
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//año
			$fini = cambia_fecha($row["cur_fecha_inicio"]);
			$ffin = cambia_fecha($row["cur_fecha_fin"]);
			$salida.= '<td class = "text-center">'.$fini.' - '.$ffin.'</td>';
			//--
			$salida.= '<td class = "text-center">';
			$codigo = $row["cur_codigo"];
			$salida.= '<a class="btn btn-primary btn-xs btn-block" href="REPasigcurso.php?curso='.$codigo.'" target="_blank" title = "Seleccionar Curso" ><span class="fa fa-angle-double-right fa-2x"></span></a>';
			$salida.= '</td>';	
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}
	
	return $salida;
}



function tabla_alumno_asignacion_cursos($curso){
	$ClsCur = new ClsCursoLibre();
	$result = $ClsCur->get_alumno($cui,$nom,$ape,$curso);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th class = "text-center" width = "60px">ID</td>';
			$salida.= '<th class = "text-center" width = "60px">TIPO ID</td>';
			$salida.= '<th class = "text-center" width = "120px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "120px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "200px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "100px">CORREO</td>';
			$salida.= '<th class = "text-center" width = "100px">TELEFONO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'</td>';
			//ID
			$id = utf8_decode($row["alu_cui"]);
			$salida.= '<td class = "text-center">'.$id.'</td>';
			//TIPO ID
			$tipo = utf8_decode($row["alu_tipo_cui"]);
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//correo
			$pad = utf8_decode($row["alu_padre"]);
			$salida.= '<td class = "text-left">'.$pad.'</td>';
			//correo
			$mail = $row["alu_mail_padre"];
			$salida.= '<td class = "text-left">'.$mail.'</td>';
			//telefono1
			$tel = $row["alu_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
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