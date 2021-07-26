<?php 
include_once('../html_fns.php');

//////////////////---- Otros Padres -----/////////////////////////////////////////////
function tabla_gestor_alumnos_temporales($cod,$nom,$ape,$pensum,$nivel,$grado,$seccion){
	$ClsTempAlu = new ClsTempAlumno();
	$result = $ClsTempAlu->get_alumno($cod,$nom,$ape,$pensum,$nivel,$grado,$seccion,"1,2");
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example1">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px"></th>';
			$salida.= '<th width = "10px"></th>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th class = "text-center" width = "30px">CODIGO</th>';
			$salida.= '<th class = "text-center" width = "100px">NOMBRE</th>';
			$salida.= '<th class = "text-center" width = "100px">APELLIDO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["talu_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_Alumno(\''.$codigo.'\');" title = "Editar Alumno" ><span class="glyphicon glyphicon-pencil"></span></button>';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Alumno(\''.$codigo.'\')" title = "Eliminar Alumno" ><span class="glyphicon glyphicon-trash"></span></button>';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'</td>';
			//codigo
			$codigo = $row["talu_codigo"];
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//nombre
			$nom = utf8_decode($row["talu_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["talu_apellido"]);
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		//$salida = "$codigo,$nom,$ape,$sit,$acc";
	}
	
	return $salida;
}


function tabla_gestor_seccion_alumnos($pensum,$nivel,$grado,$seccion){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example2">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px"></th>';
			$salida.= '<th width = "10px"></th>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "30px" class = "text-center">CUI</td>';
			$salida.= '<th width = "100px" class = "text-center">NOMBRE</td>';
			$salida.= '<th width = "100px" class = "text-center">APELLIDO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["alu_codigo_interno"];
			$salida.= '<td class = "text-center" >';
			if($codigo != ""){
			$salida.= '<button type="button" class="btn btn-default btn-xs" title = "Codigo Interno '.$codigo.'" ><span class="fa fa-search"></span></button> ';
			}else{
			$salida.= '<button type="button" class="btn btn-default btn-xs" title = "" disabled ><span class="fa fa-search"></span></button> ';
			}
			$salida.= '</td>';
			$salida.= '<td class = "text-center" >';
			if($codigo != ""){
			$salida.= '<button type="button" class="btn btn-success btn-xs" title = "Alumno ya Sincronizado" ><span class="fa fa-check"></span></button> ';
			}else{
			$salida.= '<button type="button" class="btn btn-default btn-xs" title = "Alumno No Sincronizado" ><span class="fa fa-minus-square-o"></span></button> ';
			}
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'</td>';
			//cui
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//apellido
			$apellido = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$apellido.'</td>';
			//-
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_depuracion_alumnos($pensum,$nivel,$grado,$seccion){
	$ClsTempAlu = new ClsTempAlumno();
	$ClsAcad = new ClsAcademico();
	$result_temp = $ClsTempAlu->get_alumno($cod,$nom,$ape,$pensum,$nivel,$grado,$seccion,"1");
	$result_sist = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	
	if(is_array($result_temp)){
		$i = 0;
		foreach($result_temp as $row){
			$arrTemp[$i] = $row;
			$i++;
		}	
	}
	if(is_array($result_sist)){
		$j = 0;
		foreach($result_sist as $row){
			$arrSist[$j] = $row;
			$j++;
		}	
	}
	//echo "$i - $j";
	if(is_array($result_temp) && is_array($result_sist)){
		if($i == $j){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "30px" class = "text-center">CODIGO</td>';
			$salida.= '<th width = "200px" class = "text-center">ALUMNOS TEMPORALES</td>';
			$salida.= '<th width = "30px" class = "text-center">CUI</td>';
			$salida.= '<th width = "200px" class = "text-center">ALUMNOS EN SISTEMA</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
			$i=1;
			for($i = 0; $i < $j; $i++){
				$salida.= '<tr>';
				//No.
				$salida.= '<td class = "text-center">'.($i+1).'.</td>';
				//cui
				$codigo = $arrTemp[$i]["talu_codigo"];
				$cui = $arrSist[$i]["alu_cui"];
				$salida.= '<td class = "text-center">'.$codigo.'</td>';
				//nombre
				$nombre = utf8_decode($arrTemp[$i]["talu_nombre"]);
				$apellido = utf8_decode($arrTemp[$i]["talu_apellido"]);
				$nombres = $nombre." ".$apellido;
				$salida.= '<td class = "text-left">'.$nombres;
				$salida.= '<input type = "hidden" name = "codigo'.$i.'" id = "codigo'.$i.'" value = "'.$codigo.'" />';
				$salida.= '<input type = "hidden" name = "cui'.$i.'" id = "cui'.$i.'" value = "'.$cui.'" />';
				$salida.= '<input type = "hidden" name = "nom'.$i.'" id = "nom'.$i.'" value = "'.$nombre.'" />';
				$salida.= '<input type = "hidden" name = "ape'.$i.'" id = "ape'.$i.'" value = "'.$apellido.'" />';
				$salida.= '</td>';
				//cui
				$cui = $arrSist[$i]["alu_cui"];
				$salida.= '<td class = "text-center">'.$cui.'</td>';
				//nombre
				$nombre = utf8_decode($arrSist[$i]["alu_nombre"]);
				$apellido = utf8_decode($arrSist[$i]["alu_apellido"]);
				$nombres = $nombre." ".$apellido;
				$salida.= '<td class = "text-left">'.$nombres.'</td>';
				//-
				$salida.= '</tr>';
			}
			$salida.= '</table>';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'" />';
			$salida.= '</div>';
			$salida.= '</div>';
		}else{
			$salida.= '<h6 class="alert alert-warning text-center">Una de las listas tiene menos alumnos que la otra...</h6>';
		}
	}else{
		$salida.= '<h6 class="alert alert-danger text-center">Una de las listas esta vacia, tiene parametros diferentes o YA FU&Eacute; SINCRONIZADA, revise por favor...</h6>';
	}
	
	return $salida;
}



?>
