<?php 
include_once('../html_fns.php');

function tabla_tipo_periodo($cod,$pensum,$nivel,$nom,$min){
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_tipo_periodo($cod,$pensum,$nivel,$min,$desc);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<th class = "text-center" width = "100px" height = "30px"><span class="fa fa-cogs"></span></th></th>';
			$salida.= '<th class = "text-center" width = "250px">NIVEL</th>';
			$salida.= '<th class = "text-center" width = "250px">DESCRIPCI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "100px">MINUTOS</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$tipo = $row["tip_codigo"];
			$pensum = $row["tip_pensum"];
			$nivel = $row["tip_nivel"];
			$salida.= '<td class = "text-center"  >';
			$salida.= '<button type="button" class="btn btn-default" onclick = "abrir();xajax_Buscar_Tipo_Periodo('.$tipo.','.$pensum.','.$nivel.');" title = "Seleccionar Tipo" ><span class="fa fa-edit"></span></button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-danger" onclick = "abrir();Deshabilita_Tipo('.$tipo.','.$pensum.','.$nivel.');" title = "Deshabilitar Tipo" ><span class="fa fa-trash-o"></span></button>';
			$salida.= '</td>';
			//Nivel
			$nivel = utf8_decode($row["niv_descripcion"]);
			$salida.= '<td class = "text-center">'.$nivel.'</td>';
			//tipo_periodo
			$tipo = utf8_decode($row["tip_descripcion"]);
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//minutos
			$min = $row["tip_minutos"];
			$salida.= '<td class = "text-center"  >'.$min.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_periodos($dia,$tipo,$pensum,$nivel,$grado){
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_periodos("",$dia,$tipo,$pensum,$nivel,$grado);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<th class = "text-center" width = "100px"><span class="fa fa-cogs"></span></th></th>';
			$salida.= '<th class = "text-center" width = "200px">TIPO</th>';
			$salida.= '<th class = "text-center" width = "100px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "100px">INICIA</th>';
			$salida.= '<th class = "text-center" width = "150px">FINALIZA</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["per_codigo"];
			$dia = $row["per_dia"];
			$salida.= '<td class = "text-center"  >';
			$salida.= '<button type="button" class="btn btn-default" onclick = "abrir();xajax_Buscar_Periodo('.$cod.','.$dia.');" title = "Seleccionar Periodo" ><span class="fa fa-edit"></span></button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-danger" onclick = "abrir();Deshabilita_Periodo('.$cod.','.$dia.');" title = "Deshabilitar Periodo" ><span class="fa fa-trash-o"></span></button>';
			$salida.= '</td>';
			//tipo_periodo
			$tipo = utf8_decode($row["tip_descripcion"]);
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//barcode
			$min = $row["tip_minutos"];
			$salida.= '<td class = "text-center" >'.$min.' MINUTOS</td>';
			//descripcion
			$ini = $row["per_hini"];
			$salida.= '<td class = "text-center">'.$ini.'</td>';
			//desc
			$fin = $row["per_hfin"];
			$salida.= '<td class = "text-center">'.$fin.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_horario_a_definir($dia,$pensum,$nivel,$grado,$seccion,$tipo){
	$ClsHor = new ClsHorario();
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAul = new ClsAula();
	$result_grado = $ClsHor->get_periodos("",$dia,"",$pensum,$nivel,$grado);
	$result_demas = $ClsHor->get_periodos("",$dia,"",$pensum,$nivel,0);
	
	if(is_array($result_grado) || is_array($result_demas)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">TIPO</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "50px">INICIA</th>';
			$salida.= '<th class = "text-center" width = "50px">FINALIZA</th>';
			$salida.= '<th class = "text-center" width = "60px">MATERIA</th>';
			$salida.= '<th class = "text-center" width = "60px">MAESTRO</th>';
			$salida.= '<th class = "text-center" width = "60px">AULA</th>';
			$salida.= '<th class = "text-center" width = "15px"><span class="fa fa-cogs"></span></th></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$result_maestro = $ClsAcadem->get_seccion_maestro($pensum,$nivel,$grado,$seccion,'','',$tipo,1);
		$result_aula = $ClsAul->get_aula("","");
		$result_materia = $ClsPen->get_materia($pensum,$nivel,$grado,"","",1);
		
		$i = 1;
		if(is_array($result_grado)){ ///////// VALIDA ESTRUCTURA DE PERIODOS ESPECIFICA PARA UN GRADO
			foreach($result_grado as $row){
				$salida.= '<tr>';
				//codigo
				$periodo = $row["per_codigo"];
				$dia = $row["per_dia"];
				$hini = $row["per_hini"];
				$salida.= '<td class = "text-center">'.$i.'.';
				$salida.= '<input type = "hidden" name = "periodo'.$i.'" id = "periodo'.$i.'" value = "'.$periodo.'" >';
				$salida.= '<input type = "hidden" name = "hini'.$i.'" id = "hini'.$i.'" value = "'.$hini.'" >';
				$salida.= '</td>';
				//tipo_periodo
				$tipo_periodo = utf8_decode($row["tip_descripcion"]);
				$salida.= '<td class = "text-left">'.$tipo_periodo.'</td>';
				//duracion
				$min = $row["tip_minutos"];
				$salida.= '<td class = "text-center" >'.$min.' MINUTOS</td>';
				//inicai
				$ini = $row["per_hini"];
				$salida.= '<td class = "text-center">'.$ini.'</td>';
				//termina
				$fin = $row["per_hfin"];
				$salida.= '<td class = "text-center">'.$fin.'</td>';
				//materia
				$salida.= '<td class = "text-center">'.combos_html_onclick($result_materia,"materia$i",'mat_codigo','mat_descripcion',"Asignar_Horario($i);").'</td>';
				//maestro
				$salida.= '<td class = "text-center">'.combos_html_onclick($result_maestro,"maestro$i","mae_cui","mae_nombre","Asignar_Horario($i)").'</td>';
				//aula
				$salida.= '<td class = "text-center">'.combos_html_onclick($result_aula,"aula$i",'aul_codigo','aul_descripcion',"Asignar_Horario($i)").'</td>';
				//--
				$salida.= '<td class = "text-center">';
				$codigo = "";
				$result_comprueba = $ClsHor->get_horario("",$periodo,$dia,"","","",$pensum,$nivel,$grado,$seccion);
				if(is_array($result_comprueba)){
					foreach($result_comprueba as $row_comprueba){
						$codigo = $row_comprueba["hor_codigo"];
						$materia = $row_comprueba["mat_codigo"];
						$maestro = $row_comprueba["mae_cui"];
						$aula = $row_comprueba["aul_codigo"];
						$salida.= '<span id = "spancheck'.$i.'" class="btn btn-success btn-xs" onclick="ConfirmEliminarHorario('.$i.')">';
						$salida.= '<span class="fa fa-check-circle-o"></span>';
						$salida.= '</span> ';
						$salida.= '<script type = "text/javascript">';
						$salida.= "document.getElementById('materia$i').value = '$materia';";
						$salida.= "document.getElementById('maestro$i').value = '$maestro';";
						$salida.= "document.getElementById('aula$i').value = '$aula';";
						$salida.= '</script>';
					}
					$existe = 1;
				}else{
					$salida.= '<span id = "spancheck'.$i.'" class="btn btn-default btn-xs" title = "" ></span> ';
					$existe = 0;
				}
				$salida.= '<input type = "hidden" name = "codigo'.$i.'" id = "codigo'.$i.'" value = "'.$codigo.'" >';
				$salida.= '<input type = "hidden" name = "existe'.$i.'" id = "existe'.$i.'" value = "'.$existe.'" >';
				$salida.= '</td>';
				$salida.= '</tr>';
				$i++;
			}
		}else{
			foreach($result_demas as $row){ ///////// VALIDA ESTRUCTURA DE PERIODOS DE UN NIVEL EDUCATIVO
				$salida.= '<tr>';
				//codigo
				$periodo = $row["per_codigo"];
				$dia = $row["per_dia"];
				$hini = $row["per_hini"];
				$salida.= '<td class = "text-center">'.$i.'.';
				$salida.= '<input type = "hidden" name = "periodo'.$i.'" id = "periodo'.$i.'" value = "'.$periodo.'" >';
				$salida.= '<input type = "hidden" name = "hini'.$i.'" id = "hini'.$i.'" value = "'.$hini.'" >';
				$salida.= '</td>';
				//tipo_periodo
				$tipo_periodo = utf8_decode($row["tip_descripcion"]);
				$salida.= '<td class = "text-left">'.$tipo_periodo.'</td>';
				//duracion
				$min = $row["tip_minutos"];
				$salida.= '<td class = "text-center" >'.$min.' MINUTOS</td>';
				//inicai
				$ini = $row["per_hini"];
				$salida.= '<td class = "text-center">'.$ini.'</td>';
				//termina
				$fin = $row["per_hfin"];
				$salida.= '<td class = "text-center">'.$fin.'</td>';
				//materia
				$salida.= '<td class = "text-center">'.combos_html_onclick($result_materia,"materia$i",'mat_codigo','mat_descripcion',"Asignar_Horario($i);").'</td>';
				//maestro
				$salida.= '<td class = "text-center">'.combos_html_onclick($result_maestro,"maestro$i","mae_cui","mae_nombre","Asignar_Horario($i)").'</td>';
				//aula
				$salida.= '<td class = "text-center">'.combos_html_onclick($result_aula,"aula$i",'aul_codigo','aul_descripcion',"Asignar_Horario($i)").'</td>';
				//--
				$salida.= '<td class = "text-center">';
				$codigo = "";
				$result_comprueba = $ClsHor->get_horario("",$periodo,$dia,"","","",$pensum,$nivel,$grado,$seccion);
				if(is_array($result_comprueba)){
					foreach($result_comprueba as $row_comprueba){
						$codigo = $row_comprueba["hor_codigo"];
						$materia = $row_comprueba["mat_codigo"];
						$maestro = $row_comprueba["mae_cui"];
						$aula = $row_comprueba["aul_codigo"];
						$salida.= '<span id = "spancheck'.$i.'" class="btn btn-success btn-xs" onclick="ConfirmEliminarHorario('.$i.')">';
						$salida.= '<span class="fa fa-check-circle-o"></span>';
						$salida.= '</span> ';
						$salida.= '<script type = "text/javascript">';
						$salida.= "document.getElementById('materia$i').value = '$materia';";
						$salida.= "document.getElementById('maestro$i').value = '$maestro';";
						$salida.= "document.getElementById('aula$i').value = '$aula';";
						$salida.= '</script>';
					}
					$existe = 1;
				}else{
					$salida.= '<span id = "spancheck'.$i.'" class="btn btn-default btn-xs" title = "" ></span> ';
					$existe = 0;
				}
				$salida.= '<input type = "hidden" name = "codigo'.$i.'" id = "codigo'.$i.'" value = "'.$codigo.'" >';
				$salida.= '<input type = "hidden" name = "existe'.$i.'" id = "existe'.$i.'" value = "'.$existe.'" >';
				$salida.= '</td>';
				$salida.= '</tr>';
				$i++;
			}
		}
		$i--;
			$salida.= '<tr>';
			$salida.= '<td colspan = "9" class = "text-right"><label>Total de periodos '.$i.'</label>';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'" >';
			$salida.= '</td>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


//echo tabla_costos($cod,$lot,$per,$tipop);



?>
