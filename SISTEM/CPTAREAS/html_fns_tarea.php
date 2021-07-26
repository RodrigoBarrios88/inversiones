<?php
include_once('../html_fns.php');
//Push Notifications
include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');

function tabla_reenvio_tareas($pensum,$nivel,$grado,$seccion,$tarea){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	
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
			$salida.= '<button type="button" class="btn btn-info btn-xs" onclick = "ReEnviarTarea('.$tarea.',\''.$cui.'\');" title = "Reenviar Tarea al Alumno" ><i class="fa fa-send"></i> Enviar</button>';
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
	$result = $ClsTar->get_det_tarea($tarea);
	
	if(is_array($result)){
	    
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "50px" class = "text-center">CUI</td>';
			$salida.= '<th width = "170px" class = "text-center">ALUMNO</td>';
			$salida.= '<th width = "100px" class = "text-center">FECHA DE ENTREGA</td>';
			$salida.= '<th width = "50px" class = "text-center">DESCARGA ARCHIVOS</td>';
			$salida.= '<th width = "50px" class = "text-center">NOTA</td>';
			$salida.= '<th width = "10px" class = "text-center">CALIFICAR TAREA</td>';
			$salida.= '<th width = "10px" class = "text-center"><span class="fa fa-comments"></span></td>';
			$salida.= '<th width = "10px" class = "text-center">SIT.</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
		    $alumno = $row["alu_cui"];
	    	$result1 = $ClsTar->get_respuesta_directa($tarea,$alumno);
        	if(is_array($result1)){
        		foreach($result1 as $row1){
        			$fecha_respuesta = cambia_fechaHora($row1["reso_fecha_registro"]);
        		}
        	}
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
			//fecha entrega
			$resolucion = trim($row["tar_fecha_resolucion_alumno"]);
			if($resolucion != ""){
				$fecha = cambia_fechaHora($resolucion);
				$sit = $row["dtar_situacion"];
				switch($sit){
					case 1: $fech = '<td class = "text-left">'.$fecha.'</td>';
					case 2: $fech = '<td class = "text-left">'.$fecha.'</td>';
					case 3: $fech = '<td class = "text-left">'.$fecha.'</td>';
				}
			}else{
				    $fech = '<td class = "text-left">Pendiente de entrega</td>';
				}
			 $salida.= $fech;	
		
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
			$salida.= '<a type="button" class="btn btn-default" href="FRMcalificartareadoc.php?hashkey1='.$cui.'&hashkey2='.$tarea.'&hashkey3='.$i.'"  title = "Calificar Tarea"><span class="fa fa-edit"></span></a> &nbsp;';
			}else if($sit == 2){
			$salida.= '<a type="button" class="btn btn-outline btn-primary" href="FRMcalificartareadoc.php?hashkey1='.$cui.'&hashkey2='.$tarea.'&hashkey3='.$i.'"  title = "Modificar Calificaci&oacute;n de la Tarea"><span class="fa fa-edit"></span></a> &nbsp;';
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

function tabla_tareas($codigo,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$desde,$fecha,$sit){
	$ClsTar = new ClsTarea();
	$result = $ClsTar->get_tarea($codigo,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,$tema,$desde,$fecha,$sit);
	
	if(is_array($result)){
		$Thoras = 0;
			$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" class = "text-center"><span class="fa fa-cogs"></span></td>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			//$salida.= '<th width = "80px" class = "text-center">GRADO</td>';
			//$salida.= '<th width = "120px" class = "text-center">MATERIA</td>';
			$salida.= '<th width = "100px" class = "text-center">TEMA</td>';
			$salida.= '<th width = "100px" class = "text-center">NOMBRE</td>';
			$salida.= '<th width = "80px" class = "text-center">FECHA</td>';
			$salida.= '<th width = "150px" class = "text-center"></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">';
			$codigo = $row["tar_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsTar->encrypt($codigo, $usu);
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Tarea('.$codigo.');" target = "_blank" data-toggle="tooltip" data-placement="top" title = "Seleccionar Tarea" ><span class="fa fa-edit"></span></button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Confirm_Elimina_Tarea('.$codigo.');" target = "_blank" data-toggle="tooltip" data-placement="top" title = "Deshabilitar Tarea" ><span class="fa fa-ban"></span></button>';
			$salida.= '</td>';	
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//grado
			$grado = utf8_decode($row["tar_grado_desc"]);
			$seccion = utf8_decode($row["tar_seccion_desc"]);
			//$salida.= '<td class = "text-center">'.$grado.' '.$seccion.'</td>';
			//materia
			$materia = utf8_decode($row["tar_materia_desc"]);
			//$salida.= '<td class = "text-center">'.$materia.'</td>';
			//tema
			$tema = utf8_decode($row["tem_nombre"]);
			$salida.= '<td class = "text-left">'.$tema.'</td>';
			//descripcion
			$nombre = utf8_decode($row["tar_nombre"]);
			$salida.= '<td class = "text-center">'.$nombre.'</td>';
			//fecha de entreda
			$fecha = utf8_decode($row["tar_fecha_entrega"]);
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//botones
			$salida.= '<td class = "text-center">';
			$desc = utf8_decode($row["tar_descripcion"]);
			$tarea = $row["tar_codigo"];
			$salida.= '<button type="button" class="btn btn-outline btn-primary" onclick = "NewFile('.$codigo.','.$i.');" title="Cargar material de auxiliar o Gu&iacute;a"><i class="fa fa-cloud-upload"></i> <i class="fa fa-file-picture-o"></i></button> ';
			$salida.= '<a class="btn btn-default" href = "IFRMarchivostarea.php?tarea='.$codigo.'&curso='.$curso.'" target = "_blank" title="Ver Documentos Cargados" ><i class="fa fa-search"></i> <i class="fa fa-file-pdf-o"></i></a> ';
			$salida.= '<a class="btn btn-primary" href="FRMcalificartarea.php?hashkey='.$hashkey.'" title = "Calificar Tarea" ><span class="fa fa-paste"></span> Calificar</a> ';
			$salida.= '<a class="btn btn-info" href="FRMreenviar.php?hashkey='.$hashkey.'" title = "Reenviar Tarea" ><span class="fa fa-send"></span></a>';
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}
	
	return $salida;
}


function tabla_tareas_calificacion($cod,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$tipo,$sit){
	$ClsTar = new ClsTarea();
	$result = $ClsTar->get_tarea($cod,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$desde,$fecha,$sit);
	
	if(is_array($result)){
		$Thoras = 0;
			$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "100px" class = "text-center">TAREA</td>';
			$salida.= '<th width = "80px" class = "text-center">FECHA</td>';
			$salida.= '<th width = "200px" class = "text-center">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th width = "100px" class = "text-center"><span class="fa fa-cogs"></span></td>';
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
			$salida.= '<a class="btn btn-info" href="FRMreenviar.php?hashkey='.$hashkey.'" title = "Reenviar Tarea" ><span class="fa fa-send"></span></a>';
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