<?php 
include_once('../html_fns.php');

//////////////////---- Otros Alumnos -----/////////////////////////////////////////////

function tabla_examens($codigo,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,$tema,$tipo){
	$ClsExa = new ClsExamen();
    $result = $ClsExa->get_examen($codigo,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,$tema,$tipo);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "130px">T&Iacute;TULO</td>';
			$salida.= '<th class = "text-center" width = "10px">UNIDAD</td>';
			$salida.= '<th class = "text-center" width = "60px">FECHA LIMITE</td>';
			$salida.= '<th class = "text-center" width = "100px"><span class="fa fa-paste"></span></th>';
			$salida.= '<th class = "text-center" width = "100px"><span class="fa fa-copy"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//valida la vgencia del examen
			$feclimit = trim($row["exa_fecha_limite"]);
			$feclimit = strtotime($feclimit);
			$fecahora = strtotime(date("Y-m-d H:i:s",time()));
			if($feclimit > $fecahora){
				$disabled = "";
			}else{
				$disabled = "disabled";
			}
			//codigo
			$cod = $row["exa_codigo"];
            $salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Examen('.$cod.')" title = "Editar Examen" > <span class="fa fa-edit"></span> </button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "ConfirmEliminar('.$cod.');" title = "Eliminar Examen" > <span class="fa fa-trash-o"></span> </button> ';
			$salida.= '</td>';
			//nombre
			$titulo = trim(utf8_decode($row["exa_titulo"]));
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//unidad
			$unidad = trim(utf8_decode($row["exa_unidad"]));
			$salida.= '<td class = "text-center">'.$unidad.'U</td>';
			//fecha inicia
			$feclimit = trim($row["exa_fecha_limite"]);
			$feclimit = cambia_fechaHora($feclimit);
			$salida.= '<td class = "text-center">'.$feclimit.'</td>';
			//tipo de solucion
			$tipo = trim($row["exa_tipo"]);
			switch($tipo){
				case "OL": $tipo = "RESPONDE EN L&Iacute;NEA"; break;
				case "SR": $tipo = "CALIFICADO INDEPENDIENTE"; break;
			}
			//$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//--
			$cod = $row["exa_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsExa->encrypt($cod, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-primary" href="FRMpreguntas.php?hashkey='.$hashkey.'" target = "_blank" title = "Editar Preguntas" '.$disabled.' ><span class="fa fa-pencil"></span> Preguntas</a> ';
			$salida.= '<a type="button" class="btn btn-success" href="FRMclave.php?hashkey='.$hashkey.'" target = "_blank" title = "Resolver Evaluacion (Clave de Evaluacion)" ><span class="fa fa-key"></span> Clave</a>';
			//--
			$codigo = $row["exa_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-outline btn-primary" onclick = "NewFile('.$codigo.','.$i.');" title="Cargar material de auxiliar o Gu&iacute;a" '.$disabled.' ><i class="fa fa-cloud-upload"></i> <i class="fa fa-file-picture-o"></i></button> ';
			$salida.= '<a class="btn btn-default" href = "IFRMarchivosexamen.php?examen='.$codigo.'&curso='.$curso.'" target = "_blank" title="Ver Documentos Cargados" ><i class="fa fa-search"></i> <i class="fa fa-file-pdf-o"></i></a> ';
			$salida.= '<a class="btn btn-primary" href="FRMcalificarexamen.php?hashkey='.$hashkey.'" title = "Calificar Evaluaciones" ><span class="fa fa-paste"></span> <span class="fa fa-pencil"></span></a>';
			$salida.= '</td>';
				
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






function tabla_preguntas($codigo,$examen){
    $ClsExa = new ClsExamen();
    $result = $ClsExa->get_pregunta($codigo,$examen);
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "250px">PREGUNTA</td>';
			$salida.= '<th class = "text-center" width = "100px">TIPO DE RESPUESTA</td>';
			$salida.= '<th class = "text-center" width = "50px">VALORACI&Oacute;N</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["pre_codigo"];
			$examen = $row["pre_examen"];
            $salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Pregunta('.$codigo.','.$examen.')" title = "Editar Pregunta" > <span class="fa fa-edit"></span> </button> &nbsp;&nbsp; ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Eliminar_Pregunta('.$codigo.','.$examen.');" title = "Eliminar Pregunta" > <span class="fa fa-trash-o"></span> </button> ';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//nombre
			$desc = trim(utf8_decode($row["pre_descripcion"]));
			$desc = nl2br($desc);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//tipo
			$tipo = trim($row["pre_tipo"]);
			switch($tipo){
				case 1: $tipo_pregunta = "OPCI&Oacute;N MULTIPLE"; break;
				case 2: $tipo_pregunta = "VERDADERO Y FALSO"; break;
				case 3: $tipo_pregunta = "ABIERTA"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo_pregunta.'</td>';
			//puntos
			$puntos = trim(utf8_decode($row["pre_puntos"]));
			$salida.= '<td class = "text-center">'.$puntos.' PUNTOS</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
	    	$salida.= '<div class="col-xs-12 text-center">';
	    	$cod = $row["pre_examen"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsExa->encrypt($cod, $usu);
            $salida.= '<a type="button" class="btn btn-success" href="FRMclave.php?hashkey='.$hashkey.'" target = "_blank" title = "Resolver Evaluacion (Clave de Evaluacion)" ><span class="fa fa-key"></span> Clave</a>';			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_reenvio_examen($pensum,$nivel,$grado,$seccion,$examen){
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
			$salida.= '<button type="button" class="btn btn-info btn-xs" onclick = "ReEnviarExamen('.$examen.',\''.$cui.'\');" title = "Re-Enviar Evaluaciones al Alumno" ><i class="fa fa-send"></i> Enviar</button>';
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



function tabla_examen_alumnos($examen){
	$ClsExa = new ClsExamen();
	$result = $ClsExa->get_det_examen($examen);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "50px" class = "text-center">CUI</td>';
			$salida.= '<th width = "170px" class = "text-center">ALUMNO</td>';
			$salida.= '<th width = "100px" class = "text-center">FECHA ENTREGA</td>';
			$salida.= '<th width = "50px" class = "text-center">RESOLUCI&Oacute;N</td>';
			$salida.= '<th width = "50px" class = "text-center">NOTA</td>';
			$salida.= '<th width = "10px" class = "text-center"><span class="fa fa-pencil"></span></td>';
			$salida.= '<th width = "10px" class = "text-center"><span class="fa fa-comments"></span></td>';
			$salida.= '<th width = "10px" class = "text-center">SIT.</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		/////// SUMA LOS PUNTOS DE LAS PREGUNTAS PARA OBTENER LA PONDERACION MAXIMA
		$result_preguntas = $ClsExa->get_pregunta('',$examen);
		$maximo = 0;
		if(is_array($result_preguntas)){
			foreach ($result_preguntas as $row_preguntas){
				$maximo+= trim($row_preguntas["pre_puntos"]);
			}	
		}
		///-------------
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
			$salida.= '<input type = "hidden" name = "examen'.$i.'" id = "examen'.$i.'" value = "'.$examen.'" />';
			$salida.= '</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//nombre
		    $entrega = utf8_decode($row["exa_fecha_entrega"]);
		    if($entrega !=''){
		        $entrega = $entrega;
		    }else{
		        $entrega = "no se ha entregado";
		    }
			$salida.= '<td class = "text-center">'.$entrega.'</td>';
			//resolucion
			$tipo = trim($row["exa_tipo"]);
			$salida.= '<td class = "text-center" >';
			if($tipo == "OL"){
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsExa->encrypt($examen, $usu);
			$hashkey2 = $ClsExa->encrypt($cui, $usu);
			$salida.= '<a class="btn btn-success btn-outline" href="FRMrespuesta_alumno.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" target = "_blank" title="Ver Resolucion del Evaluaciones" ><i class="fa fa-search"></i> <i class="fa fa-file-pdf-o"></i></a> ';
			}else{
			$salida.= '<button type="button" class="btn btn-default btn-xs btn-block" title="Se entregar&aacute; en clase..." disabled >Se presentar&aacute; en clase</button> ';
			}
			$salida.= '</td>';
			//nota
			$nota = $row["dexa_nota"];
			$sit = $row["dexa_situacion"];
			$nota = "$nota/$maximo punto(s).";
			$salida.= '<td class = "text-center" id = "nota'.$i.'">'.$nota.'</td>';
			//---
			$sit = $row["dexa_situacion"];
			$salida.= '<td class = "text-center" >';
			if($sit == 3){
			$salida.= '<a type="button" class="btn btn-outline btn-primary" href="FRMcalificarexamendoc.php?hashkey1='.$cui.'&hashkey2='.$examen.'&hashkey3='.$i.'" title = "Modificar Calificaci&oacute;n de la Evaluaciones"><span class="fa fa-edit"></span></a> &nbsp;';
			}else{
			$salida.= '<a type="button" class="btn btn-outline btn-default" href="FRMcalificarexamendoc.php?hashkey1='.$cui.'&hashkey2='.$examen.'&hashkey3='.$i.'"  title = "Calificar Evaluaciones"><span class="fa fa-edit"></span></a> &nbsp;';
			}
			$salida.= '</td>';
			//observaciones
			$sit = $row["dexa_situacion"];
			$hidden = ($sit == 3)?"":"hidden";
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" id="button'.$i.'" class="btn btn-default '.$hidden.'"  onclick="Observaciones('.$i.');" title="Observaciones al Calificar la Evaluaciones" ><span class="fa fa-search"></span></button> ';
			$salida.= '</td>';
			//situacion
			$sit = $row["dexa_situacion"];
			switch($sit){
				case 1: $icono = '<a href = "javascript:void(0);" title = "Pendiente de Resolver" ><i class = "fa fa-clock-o"></i></a>'; break;
				case 2: $icono = '<a href = "javascript:void(0);" title = "Resuelto"><i class = "fa fa-check"></i></a>'; break;
				case 3: $icono = '<a href = "javascript:void(0);" title = "Calificado"><i class = "fa fa-check"></i></a>'; break;
				case 0: $icono = '<a href = "javascript:void(0);" title = "Anulado"><i class = "fa fa-ban"></i></a>'; break;
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



function tabla_lista_examens($codigo,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,$tema,$acc){
	$ClsExa = new ClsExamen();
    $result = $ClsExa->get_examen($codigo,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,$tema);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</td>';
			$salida.= '<th class = "text-center" width = "150px">T&Iacute;TULO</td>';
			$salida.= '<th class = "text-center" width = "70px">FECHA LIMITE</td>';
			$salida.= '<th class = "text-center" width = "50px">TIPO DE SOLUCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "50px"><i class="fa fa-cogs"></i></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$cod = $row["exa_codigo"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsExa->encrypt($cod, $usu);
			$sit = $row["exa_situacion"];
			//nombre
			$titulo = trim(utf8_decode($row["exa_titulo"]));
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//fecha inicia
			$feclimit = trim($row["exa_fecha_limite"]);
			$feclimit = cambia_fechaHora($feclimit);
			$salida.= '<td class = "text-center">'.$feclimit.'</td>';
			//tipo de solucion
			$tipo = trim($row["exa_tipo"]);
			switch($tipo){
				case "OL": $tipo = "RESPONDE EN L&Iacute;NEA"; break;
				case "SR": $tipo = "CALIFICADO INDEPENDIENTE"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//--
			$cod = $row["exa_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsExa->encrypt($cod, $usu);
			$salida.= '<td class = "text-center" >';
			if($acc == "calificar"){
			$salida.= '<a class="btn btn-primary" href="FRMcalificarexamen.php?hashkey='.$hashkey.'" title = "Calificar Evaluaciones" ><span class="fa fa-paste"></span> Calificar</a> ';
			}else if($acc == "clave"){
			$salida.= '<a class="btn btn-success" href="FRMclave.php?hashkey='.$hashkey.'" title = "Resolver Clave del Evaluaciones" ><span class="fa fa-key"></span> Clave</a> ';
			}
			$salida.= '<a class="btn btn-info" href="FRMreenviar.php?hashkey='.$hashkey.'" title = "Re-Enviar Evaluaciones" ><span class="fa fa-send"></span></a>';
			$salida.= '</td>';
				
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

function radio_multiples($ponderacion,$elemento){
	$ClsExa = new ClsExamen();
	$resultm = $ClsExa->get_multiple('',$examen);
	if(is_array($resultm)){
		foreach ($resultm as $row_multiple){
			$numero = trim($row_multiple["mult_numero"]);
			$descripcion = trim($row_multiple["mult_descripcion"]);
			}	
		}else{
			$numero = "";
			$descripcion = "";
		}
	if(is_array($result)){
		$salida.='<div class="form-group">';
		$salida.='<label class="radio-inline">';
			$salida.='<input type="radio" name="radio'.$i.'" id="radioA'.$i.'" value="'.$numero.'" onclick = "xajax_Grabar_Clave(\''.$examen.'\',\''.$codigo.'\',1,this.value,\'\');" /> '.console.log($descripcion).'';
		$salida.='</label>';
		$salida.='<label class="radio-inline">';
			$salida.='<input type="radio" name="radio'.$i.'" id="radioB'.$i.'" value="2" onclick = "xajax_Grabar_Clave(\''.$examen.'\',\''.$codigo.'\',1,this.value,\'\');" /> 2';
		$salida.='</label>';
		$salida.='<label class="radio-inline">';
			$salida.='<input type="radio" name="radio'.$i.'" id="radioC'.$i.'" value="3" onclick = "xajax_Grabar_Clave(\''.$examen.'\',\''.$codigo.'\',1,this.value,\'\');" /> 3';
		$salida.='</label>';
		$salida.='<label class="radio-inline">';
			$salida.='<input type="radio" name="radio'.$i.'" id="radioD'.$i.'" value="4" onclick = "xajax_Grabar_Clave(\''.$examen.'\',\''.$codigo.'\',1,this.value,\'\');" /> 4';
		$salida.='</label>';
		$salida.='<label class="radio-inline">';
			$salida.='<input type="radio" name="radio'.$i.'" id="radioE'.$i.'" value="5" onclick = "xajax_Grabar_Clave(\''.$examen.'\',\''.$codigo.'\',1,this.value,\'\');" /> 5';
		$salida.='</label>';
	$salida.='</div>';
	$salida.='<script>';
		}
	if($elemento != ''){
		$salida.='document.getElementById("radio'.$elemento.''.$i.'").checked = true;';
	}
	
	return $salida;
	
		
}



?>