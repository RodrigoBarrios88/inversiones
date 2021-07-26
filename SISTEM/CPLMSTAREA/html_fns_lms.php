<?php
include_once('../html_fns.php');

function tabla_reenvio_tareas($curso,$tarea){
	$ClsCur = new ClsCursoLibre();
	$result = $ClsCur->get_curso_alumno($curso,'');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</td>';
			$salida.= '<th class = "text-center" width = "60px">ID</td>';
			$salida.= '<th class = "text-center" width = "60px">TIPO ID</td>';
			$salida.= '<th class = "text-center" width = "120px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "120px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "60px"><span class="fa fa-cogs"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
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
			//boton
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-info btn-xs" onclick = "ReEnviarTarea('.$tarea.',\''.$cui.'\');" title = "Re-Enviar Tarea al Alumno" ><i class="fa fa-send"></i> Enviar</button>';
			$salida.= '</td>';
			//--	
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



function tabla_tarea_alumnos($tarea){
	$ClsTar = new ClsTarea();
	$result = $ClsTar->get_det_tarea_curso($tarea);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "50px" class = "text-center">CUI</td>';
			$salida.= '<th width = "170px" class = "text-center">ALUMNO</td>';
			$salida.= '<th width = "50px" class = "text-center">RESOLUCI&Oacute;N</td>';
			$salida.= '<th width = "50px" class = "text-center">NOTA</td>';
			$salida.= '<th width = "10px" class = "text-center"><span class="fa fa-pencil"></span></td>';
			$salida.= '<th width = "10px" class = "text-center"><span class="fa fa-comments"></span></td>';
			$salida.= '<th width = "10px" class = "text-center">SIT.</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
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
			$salida.= '<input type = "hidden" name = "tarea'.$i.'" id = "tarea'.$i.'" value = "'.$tarea.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//resolucion
			$tipo = trim($row["tar_tipo"]);
			$salida.= '<td class = "text-center" >';
			if($tipo == "OL"){
			$salida.= '<button type="button" class="btn btn-success btn-outline" onclick="Resolucion('.$i.');" title="Ver Resolucion de la tarea" ><i class="fa fa-search"></i> <i class="fa fa-file-pdf-o"></i></button> ';
			}else{
			$salida.= '<button type="button" class="btn btn-default btn-xs btn-block" title="Se entregar&aacute; en clase..." disabled >Se presentar&aacute; en clase</button> ';
			}
			$salida.= '</td>';
			//nota
			$nota = $row["dtar_nota"];
			$sit = $row["dtar_situacion"];
			$nota = ($sit == 1)?"":$nota." Punto(s).";
			$salida.= '<td class = "text-center" id = "nota'.$i.'">'.$nota.'</td>';
			//---
			$sit = $row["dtar_situacion"];
			$salida.= '<td class = "text-center" >';
			if($sit == 1){
			$salida.= '<button type="button" class="btn btn-default" onclick="Calificar_Tarea('.$i.');" title = "Calificar Tarea"><span class="fa fa-edit"></span></button> &nbsp;';
			}else if($sit == 2){
			$salida.= '<button type="button" class="btn btn-outline btn-primary" onclick="Modificar_Calificacion('.$i.');" title = "Modificar Calificaci&oacute;n de la Tarea"><span class="fa fa-edit"></span></button> &nbsp;';
			}
			$salida.= '</td>';
			//observaciones
			$sit = $row["dtar_situacion"];
			$hidden = ($sit == "2")?"":"hidden";
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" id="button'.$i.'" class="btn btn-default '.$hidden.'"  onclick="Observaciones('.$i.');" title="Observaciones al Calificar la Tarea" ><span class="fa fa-search"></span></button> ';
			$salida.= '</td>';
			//situacion
			$resolucion = trim($row["tar_fecha_resolucion_alumno"]);
			if($resolucion != ""){
				$fecha = cambia_fechaHora($resolucion);
				$sit = $row["dtar_situacion"];
				switch($sit){
					case 1: $icono = '<a href = "javascript:void(0);" title = "Entregada el '.$fecha.', No calificada" ><i class = "fa fa-check"></i> <i class = "fa fa-circle-o"></i></a>'; break;
					case 2: $icono = '<a href = "javascript:void(0);" title = "Entregada el '.$fecha.' y Calificada"><i class = "fa fa-check"></i> <i class = "fa fa-check"></i></a>'; break;
					case 0: $icono = '<a href = "javascript:void(0);" title = "Entregada el '.$fecha.' y Anulada"><i class = "fa fa-ban"></i></a>'; break;
				}
			}else{
				$sit = $row["dtar_situacion"];
				switch($sit){
					case 1: $icono = '<a href = "javascript:void(0);" title = "Pendiente de Entrega, No calificada" ><i class = "fa fa-minus"></i> <i class = "fa fa-circle-o"></i></a>'; break;
					case 2: $icono = '<a href = "javascript:void(0);" title = "Pendiente de Entrega y Calificada"><i class = "fa fa-minus"></i> <i class = "fa fa-check"></i></a>'; break;
					case 0: $icono = '<a href = "javascript:void(0);" title = "Pendiente de Entrega y Anulada"><i class = "fa fa-ban"></i></a>'; break;
				}
			}
			$salida.= '<td class = "text-center">'.$icono.'</td>';
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

function tabla_tareas($cod,$curso,$tema,$maestro,$tipo,$sit){
	$ClsTar = new ClsTarea();
	$result = $ClsTar->get_tarea_curso($cod,$curso,$tema,$maestro,$tipo,$desde,$fecha,$sit);
	
	if(is_array($result)){
		$Thoras = 0;
			$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" class = "text-center"><span class="fa fa-cogs"></span></td>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "100px" class = "text-center">TAREA</td>';
			$salida.= '<th width = "100px" class = "text-center">FECHA</td>';
			$salida.= '<th width = "100px" class = "text-center">PONDERACI&Oacute;N</td>';
			$salida.= '<th width = "150px" class = "text-center"><span class="fa fa-cogs"></span></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">';
			$codigo = $row["tar_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsTar->encrypt($codigo, $usu);
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="Buscar_tarea('.$codigo.');" title = "Seleccionar Tarea" ><span class="fa fa-edit"></span></button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Confirm_Elimina_Tarea('.$codigo.');" title = "Deshabilitar Tarea" ><span class="fa fa-trash"></span></button>';
			$salida.= '</td>';	
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//nombre
			$nombre = utf8_decode($row["tar_nombre"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//fecha de entreda
			$fecha = utf8_decode($row["tar_fecha_entrega"]);
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//ponderacion
			$pondera = trim($row["tar_ponderacion"]);
			$tipocalifica = trim($row["tar_tipo_calificacion"]);
			switch($tipocalifica){
				case 'Z': $tipocal = " Actividades"; break;
				case 'E': $tipocal = " AL Evaluaciones"; break;
			}
			$salida.= '<td class = "text-center">'.$pondera.'pts. / '.$tipocal.'</td>';
			//botones
			$salida.= '<td class = "text-center">';
			$tarea = $row["tar_codigo"];
			$curso = $row["tar_curso"];
			$salida.= '<button type="button" class="btn btn-outline btn-primary" onclick = "NewFile('.$codigo.','.$i.');" title="Cargar material de auxiliar o Gu&iacute;a"><i class="fa fa-cloud-upload"></i> <i class="fa fa-file-picture-o"></i></button> ';
			$salida.= '<a class="btn btn-default" href = "IFRMarchivostarea.php?tarea='.$codigo.'&curso='.$curso.'" target = "_blank" title="Ver Documentos Cargados" ><i class="fa fa-search"></i> <i class="fa fa-file-pdf-o"></i></a> ';
			$salida.= '<a class="btn btn-primary" href="FRMcalificartarea.php?hashkey='.$hashkey.'" title = "Calificar Tarea" ><span class="fa fa-paste"></span> Calificar</a> ';
			$salida.= '<a class="btn btn-info" href="FRMreenviar.php?hashkey='.$hashkey.'" title = "Re-Enviar Tarea" ><span class="fa fa-send"></span></a>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-warning"></i> No se registran tareas en este tema...';
		$salida.= '</h5>';
	}
	
	return $salida;
}



function tabla_tareas_calificacion($cod,$curso,$tema,$maestro,$tipo,$sit){
	$ClsTar = new ClsTarea();
	$result = $ClsTar->get_tarea_curso($cod,$curso,$tema,$maestro,$tipo,$desde,$fecha,$sit);
	
	if(is_array($result)){
		$Thoras = 0;
			$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "100px" class = "text-center">TAREA</td>';
			$salida.= '<th width = "80px" class = "text-center">FECHA</td>';
			$salida.= '<th width = "220px" class = "text-center">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th width = "80px" class = "text-center"><span class="fa fa-cogs"></span></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//nombre
			$nombre = utf8_decode($row["tar_nombre"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//fecha de entreda
			$fecha = utf8_decode($row["tar_fecha_entrega"]);
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//descripcion
			$desc = utf8_decode($row["tar_descripcion"]);
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//botones
			$salida.= '<td class = "text-center">';
			$codigo = $row["tar_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsTar->encrypt($codigo, $usu);
			$salida.= '<a class="btn btn-primary" href="FRMcalificartarea.php?hashkey='.$hashkey.'" title = "Calificar Tarea" ><span class="fa fa-paste"></span> Calificar</a> ';
			$salida.= '<a class="btn btn-info" href="FRMreenviar.php?hashkey='.$hashkey.'" title = "Re-Enviar Tarea" ><span class="fa fa-send"></span></a>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-warning"></i> No se registran tareas en este tema...';
		$salida.= '</h5>';
	}
	
	return $salida;
}






?>
