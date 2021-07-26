<?php 
include_once('../html_fns.php');

function tabla_cursos($cod,$sede,$clase,$nom,$anio,$mes,$fini,$ffin){
	$ClsCur = new ClsCursoLibre();
	$result = $ClsCur->get_curso($cod,$sede,$clase,$nom,$anio,$mes,$fini,$ffin);
	
	if(is_array($result)){
		$Thoras = 0;
			$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" class = "text-center"><span class="glyphicon glyphicon-cog"></span></td>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "150px" class = "text-center">NOMBRE</td>';
			$salida.= '<th width = "250px" class = "text-center">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th width = "100px" class = "text-center">FECHAS</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">';
			$codigo = $row["cur_codigo"];
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Curso('.$codigo.');" title = "Seleccionar Curso" ><span class="fa fa-edit"></span></button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Deshabilita_Curso('.$codigo.');" title = "Deshabilitar Curso" ><span class="fa fa-trash"></span></button>';
			$salida.= '</td>';	
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//descripcion
			$desc = utf8_decode($row["cur_nombre"]);
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//descripcion
			$desc = utf8_decode($row["cur_descripcion"]);
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//año
			$fini = cambia_fecha($row["cur_fecha_inicio"]);
			$ffin = cambia_fecha($row["cur_fecha_fin"]);
			$salida.= '<td class = "text-center">'.$fini.' - '.$ffin.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}
	
	return $salida;
}



function tabla_temas($cod,$curso){
	$ClsCur = new ClsCursoLibre();
	$result = $ClsCur->get_tema($cod,$curso);
	
	if(is_array($result)){
		$Thoras = 0;
			$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "20px" class = "text-center"><span class="fa fa-cogs"></span></td>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "100px" class = "text-center">TEMA</td>';
			$salida.= '<th width = "20px" class = "text-center">PERIODOS</td>';
			$salida.= '<th width = "130px" class = "text-center">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th width = "40px" class = "text-center"><span class="fa fa-paperclip"></span></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">';
			$codigo = $row["tem_codigo"];
			$curso = $row["tem_curso"];
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Tema('.$codigo.','.$curso.');" title = "Seleccionar Tema" ><span class="fa fa-edit"></span></button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Confirm_Elimina('.$codigo.','.$curso.');" title = "Deshabilitar Tema" ><span class="fa fa-trash"></span></button>';
			$salida.= '</td>';	
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//tema
			$nom = utf8_decode($row["tem_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//cantidad de periodos
			$periodos = trim($row["tem_cantidad_periodos"]);
			$salida.= '<td class = "text-center">'.$periodos.'</td>';
			//descripcion
			$desc = utf8_decode($row["tem_descripcion"]);
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//botones
			$salida.= '<td class = "text-center">';
			$tarea = $row["tar_codigo"];
			$salida.= '<button type="button" class="btn btn-outline btn-primary" onclick = "NewFile('.$codigo.','.$curso.','.$i.');" title="Cargar material de auxiliar o Gu&iacute;a"><i class="fa fa-cloud-upload"></i> <i class="fa fa-file-picture-o"></i></button> ';
			$salida.= '<a class="btn btn-default" href = "IFRMarchivostema.php?curso='.$curso.'&tema='.$codigo.'" target = "_blank" title="Ver Documentos Cargados" ><i class="fa fa-search"></i> <i class="fa fa-file-pdf-o"></i></a> ';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}
	
	return $salida;
}


function tabla_cursos_para_temas($cod,$sede,$clase,$nom,$anio,$mes,$fini,$ffin){
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
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsCur->encrypt($codigo, $usu);
			$salida.= '<a class="btn btn-primary btn-xs btn-block" href="FRMtema.php?hashkey='.$hashkey.'" title = "Seleccionar Curso" ><span class="fa fa-angle-double-right fa-2x"></span></a>';
			$salida.= '</td>';	
			//--
			$salida.= '</tr>';
			$i++;
		}
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
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsCur->encrypt($codigo, $usu);
			$salida.= '<a class="btn btn-primary btn-xs btn-block" href="FRMlistalumnos_curso.php?hashkey='.$hashkey.'" title = "Seleccionar Curso" ><span class="fa fa-angle-double-right fa-2x"></span></a>';
			$salida.= '</td>';	
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}
	
	return $salida;
}



function tabla_alumno_asignacion_cursos($curso,$cui,$nom,$ape,$sit){
	$ClsCur = new ClsCursoLibre();
	$ClsPen = new ClsPensum();
	if($pensum == ""){
		$pensum = $ClsPen->get_pensum_activo();
	}
	$result = $ClsCur->get_alumno_curso($cui,$nom,$ape,$curso,$pensum);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "60px">CUI</td>';
			$salida.= '<th class = "text-center" width = "120px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "120px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "100px">MAIL</td>';
			$salida.= '<th class = "text-center" width = "50px"><span class="fa fa-cog"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//CUI
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = trim(utf8_decode($row["alu_nombre"]));
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape =  trim(utf8_decode($row["alu_apellido"]));
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//correo
			$mail = $row["alu_mail"];
			$salida.= '<td class = "text-center">'.$mail.'</td>';
			//codigo
			$salida.= '<td class = "text-center" >';
			$cui = $row["alu_cui"];
			$valida = trim($row["alu_curso_asignado"]);
			if(!$valida){
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsCur->encrypt($cui, $usu);
				$salida.= '<button class="btn btn-primary btn-block btn-xs" onclick="Asignar_Curso_Alumno(\''.$cui.'\',\''.$curso.'\');" title = "Asignar Alumno" ><i class="fa fa-link"></i> <i class="fa fa-book"></i></button>';
			}else{
				$salida.= '<small>Ya Asignado!</small> &nbsp; ';
				$salida.= '<button class="btn btn-danger btn-xs" onclick="Desasignar_Curso_Alumno(\''.$cui.'\',\''.$curso.'\');" title = "desasignar" ></i> <i class="fa fa-unlink"></i></button>';
			}	
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



?>
