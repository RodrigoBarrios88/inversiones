<?php 
include_once('../../html_fns.php');


function tabla_horario_dia_seccion($dia,$pensum,$nivel,$grado,$seccion,$tipo){
	$ClsHor = new ClsHorario();
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAul = new ClsAula();
	$result_grado = $ClsHor->get_periodos("",$dia,"",$pensum,$nivel,$grado);
	$result_demas = $ClsHor->get_periodos("",$dia,"",$pensum,$nivel,0);
	
	if(is_array($result_grado) || is_array($result_demas)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">TIPO</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "50px">INICIA</th>';
			$salida.= '<th class = "text-center" width = "50px">FINALIZA</th>';
			$salida.= '<th class = "text-center" width = "60px">MATERIA</th>';
			$salida.= '<th class = "text-center" width = "60px">MAESTRO</th>';
			$salida.= '<th class = "text-center" width = "60px">AULA</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		if(is_array($result_grado)){ ///////// VALIDA ESTRUCTURA DE PERIODOS ESPECIFICA PARA UN GRADO
			foreach($result_grado as $row){
				$salida.= '<tr>';
				//codigo
				$periodo = $row["per_codigo"];
				$dia = $row["per_dia"];
				$hini = $row["per_hini"];
				$salida.= '<td class = "text-center">'.$i.'.';
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
				//--
				$codigo = "";
				$result_comprueba = $ClsHor->get_horario("",$periodo,$dia,"","","",$pensum,$nivel,$grado,$seccion);
				if(is_array($result_comprueba)){
					foreach($result_comprueba as $row_comprueba){
						$codigo = $row_comprueba["hor_codigo"];
						$materia = utf8_decode($row_comprueba["mat_descripcion"]);
						$maestro = utf8_decode($row_comprueba["mae_nombre"]);
						$aula = utf8_decode($row_comprueba["aul_descripcion"]);
						//materia
						$salida.= '<td class = "text-center">'.$materia.'</td>';
						//maestro
						$salida.= '<td class = "text-center">'.$maestro.'</td>';
						//aula
						$salida.= '<td class = "text-center">'.$aula.'</td>';
					}
					$existe = 1;
				}else{
					//materia
					$salida.= '<td class = "text-center">-</td>';
					//maestro
					$salida.= '<td class = "text-center">'.$tipo_periodo.'</td>';
					//aula
					$salida.= '<td class = "text-center">-</td>';
				}
				$salida.= '</tr>';
				$i++;
			}
		}else{ ///////// VALIDA ESTRUCTURA DE PERIODOS DE UN NIVEL EDUCATIVO
			foreach($result_demas as $row){
				$salida.= '<tr>';
				//codigo
				$periodo = $row["per_codigo"];
				$dia = $row["per_dia"];
				$hini = $row["per_hini"];
				$salida.= '<td class = "text-center">'.$i.'.';
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
				//--
				$codigo = "";
				$result_comprueba = $ClsHor->get_horario("",$periodo,$dia,"","","",$pensum,$nivel,$grado,$seccion);
				if(is_array($result_comprueba)){
					foreach($result_comprueba as $row_comprueba){
						$codigo = $row_comprueba["hor_codigo"];
						$materia = utf8_decode($row_comprueba["mat_descripcion"]);
						$maestro = utf8_decode($row_comprueba["mae_nombre"]);
						$aula = utf8_decode($row_comprueba["aul_descripcion"]);
						//materia
						$salida.= '<td class = "text-center">'.$materia.'</td>';
						//maestro
						$salida.= '<td class = "text-center">'.$maestro.'</td>';
						//aula
						$salida.= '<td class = "text-center">'.$aula.'</td>';
					}
					$existe = 1;
				}else{
					//materia
					$salida.= '<td class = "text-center">-</td>';
					//maestro
					$salida.= '<td class = "text-center">'.$tipo_periodo.'</td>';
					//aula
					$salida.= '<td class = "text-center">-</td>';
				}
				$salida.= '</tr>';
				$i++;
			}
		}	
		$i--;
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_horario_semana_seccion($pensum,$nivel,$grado,$seccion){
	$ClsHor = new ClsHorario();
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAul = new ClsAula();
	
	for($i = 1; $i <= 5; $i ++){
		$result_grado = $ClsHor->get_periodos("",$i,"",$pensum,$nivel,$grado);
		$result_demas = $ClsHor->get_periodos("",$i,"",$pensum,$nivel,0);
		if(is_array($result_grado) || is_array($result_demas)){
			$j = 1;
			$inicia = "";
			$temporal_materia = "";
			$temporal_maestro = "";
			$temporal_aula = "";
			if(is_array($result_grado)){ ///////// VALIDA ESTRUCTURA DE PERIODOS ESPECIFICA PARA UN GRADO
				foreach($result_grado as $row){
					//dia
					$periodo = $row["per_codigo"];
					$dia[$j]["dia"] = $row["per_dia"];
					//hora
					$ini = $row["per_hini"];
					$fin = $row["per_hfin"];
					$dia[$j]["hora"] = "$ini-$fin";
					//duracion
					$dia[$j]["duracion"] = $row["tip_minutos"]." MIN.";
					//--
					$result_comprueba = $ClsHor->get_horario("",$periodo,$i,"","","",$pensum,$nivel,$grado,$seccion);
					if(is_array($result_comprueba)){
						foreach($result_comprueba as $row_comprueba){
							$dia[$j]["materia"] = utf8_decode($row_comprueba["mat_descripcion"]);
							$dia[$j]["maestro"] = utf8_decode($row_comprueba["mae_nombre"]);
							$dia[$j]["aula"] = utf8_decode($row_comprueba["aul_descripcion"]);
							//--
							$temporal_materia = utf8_decode($row_comprueba["mat_descripcion"]);
							$temporal_maestro = utf8_decode($row_comprueba["mae_nombre"]);
							$temporal_aula = utf8_decode($row_comprueba["aul_descripcion"]);
						}
					}else{
						//tipo_periodo (SI NO HAY HORARIO ASIGNADO COLOCA LA DESCRIPCION DEL TIPO DE PERIODO EJEMPLO: RECESO)
						$dia[$j]["materia"] = "-";
						$dia[$j]["maestro"] = utf8_decode($row["tip_descripcion"]);;
						$dia[$j]["aula"] = "-";
						//--
						$temporal_materia = "";
						$temporal_maestro = "";
						$temporal_aula = "";
					}
					$inicia = $ini;
					$j++;
				}
			}else{ ///////// VALIDA ESTRUCTURA DE PERIODOS DE UN NIVEL EDUCATIVO
				foreach($result_demas as $row){
					//dia
					$periodo = $row["per_codigo"];
					$dia[$j]["dia"] = $row["per_dia"];
					//hora
					$ini = $row["per_hini"];
					$fin = $row["per_hfin"];
					$dia[$j]["hora"] = "$ini-$fin";
					//duracion
					$dia[$j]["duracion"] = $row["tip_minutos"]." MIN.";
					//--
					$result_comprueba = $ClsHor->get_horario("",$periodo,$i,"","","",$pensum,$nivel,$grado,$seccion);
					if(is_array($result_comprueba)){
						foreach($result_comprueba as $row_comprueba){
							$dia[$j]["materia"] = utf8_decode($row_comprueba["mat_descripcion"]);
							$dia[$j]["maestro"] = utf8_decode($row_comprueba["mae_nombre"]);
							$dia[$j]["aula"] = utf8_decode($row_comprueba["aul_descripcion"]);
							//--
							$temporal_materia = utf8_decode($row_comprueba["mat_descripcion"]);
							$temporal_maestro = utf8_decode($row_comprueba["mae_nombre"]);
							$temporal_aula = utf8_decode($row_comprueba["aul_descripcion"]);
						}
					}else{
						//tipo_periodo (SI NO HAY HORARIO ASIGNADO COLOCA LA DESCRIPCION DEL TIPO DE PERIODO EJEMPLO: RECESO)
						$dia[$j]["materia"] = "-";
						$dia[$j]["maestro"] = utf8_decode($row["tip_descripcion"]);;
						$dia[$j]["aula"] = "-";
						//--
						$temporal_materia = "";
						$temporal_maestro = "";
						$temporal_aula = "";
					}
					$inicia = $ini;
					$j++;
				}
			}
			$j--;
		}else{
			$dia[1]["hora"] = "-";
			$dia[1]["duracion"] = "-";
			$dia[1]["materia"] = "-";
			$dia[1]["maestro"] = "-";
			$dia[1]["aula"] = "-";
		}
		$semana[$i] = $dia;
	}
	
	if(is_array($semana)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr style = "font-size: 8px;">';
		for($j = 1; $j <= 5; $j++){
			switch($j){
				case 1: $color = "info"; break;
				case 2: $color = "success"; break;
				case 3: $color = "warning"; break;
				case 4: $color = "info"; break;
				case 5: $color = "success"; break;
			}
			if($j == 1){
			$salida.= '<th class = "text-center" width = "50px">HORA</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			}
			$salida.= '<th class = "text-center '.$color.'" width = "50px">MATERIA</th>';
			$salida.= '<th class = "text-center '.$color.'" width = "50px">MAESTRO</th>';
			$salida.= '<th class = "text-center '.$color.'" width = "50px">AULA</th>';
		}
		$salida.= '</tr>';
		$salida.= '</thead>';
		$filas = count($semana[1]);
		for($i = 1; $i <= $filas; $i++){
			$salida.= '<tr style = "font-size: 8px;">';
				for($j = 1; $j <= 5; $j++){
					switch($j){
					case 1: $color = "info"; break;
					case 2: $color = "success"; break;
					case 3: $color = "warning"; break;
					case 4: $color = "info"; break;
					case 5: $color = "success"; break;
				}
				if($j == 1){
				$salida.= '<th class = "text-center">'.$semana[$j][$i]["hora"].'</td>';
				$salida.= '<th class = "text-center">'.$semana[$j][$i]["duracion"].'</td>';
				}
				$salida.= '<td class = "text-center '.$color.'" style = "font-size: 8px;">'.$semana[$j][$i]["materia"].'</td>';
				$salida.= '<td class = "text-center '.$color.'" style = "font-size: 8px;">'.$semana[$j][$i]["maestro"].'</td>';
				$salida.= '<td class = "text-center '.$color.'" style = "font-size: 8px;">'.$semana[$j][$i]["aula"].'</td>';
			}
			$salida.= '</tr>';
		}
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}	
	
	return $salida;
}





function tabla_horario_maestro($maestro,$dia){
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_horario('','',$dia,'','','','','','','','',$maestro,'');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">TIPO</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "50px">INICIA</th>';
			$salida.= '<th class = "text-center" width = "50px">FINALIZA</th>';
			$salida.= '<th class = "text-center" width = "60px">Grado y Secci&oacute;n</th>';
			$salida.= '<th class = "text-center" width = "60px">MATERIA</th>';
			$salida.= '<th class = "text-center" width = "60px">AULA</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$periodo = $row["per_codigo"];
			$dia = $row["per_dia"];
			$hini = $row["per_hini"];
			$salida.= '<td class = "text-center">'.$i.'.';
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
			//--
			$grado = utf8_decode($row["gra_descripcion"]);
			$seccion = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$grado.' '.$seccion.'</td>';
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



function tabla_horario_aula($aula,$dia){
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_horario('','',$dia,'','','','','','','','','',$aula);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">TIPO</th>';
			$salida.= '<th class = "text-center" width = "50px">DURACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "50px">INICIA</th>';
			$salida.= '<th class = "text-center" width = "50px">FINALIZA</th>';
			$salida.= '<th class = "text-center" width = "60px">Grado y Secci&oacute;n</th>';
			$salida.= '<th class = "text-center" width = "100px">MAESTRO</th>';
			$salida.= '<th class = "text-center" width = "60px">MATERIA</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$periodo = $row["per_codigo"];
			$dia = $row["per_dia"];
			$hini = $row["per_hini"];
			$salida.= '<td class = "text-center">'.$i.'.';
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
			//--
			$grado = utf8_decode($row["gra_descripcion"]);
			$seccion = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$grado.' '.$seccion.'</td>';
			//maestro
			$maestro = utf8_decode($row["mae_nombre_completo"]);
			$salida.= '<td class = "text-center">'.$maestro.'</td>';
			//materia
			$materia = utf8_decode($row["mat_descripcion"]);
			$salida.= '<td class = "text-center">'.$materia.'</td>';
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



function tabla_libres_maestro($maestro,$dia,$hora_inicial,$hora_final){
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_horario('','',$dia,'','','','','','','','',$maestro,'');
	
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "60px">INICIA</th>';
			$salida.= '<th class = "text-center" width = "60px">TERMINA</th>';
			$salida.= '<th class = "text-center" width = "100px">DURACI&Oacute;N EN MINUTOS</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		$j = 1;
		$memoria_hini = 0;
		$memoria_hfin = 0;
	if(is_array($result)){
		foreach($result as $row){
			//codigo
			$ini = $row["per_hini"];
			$fin = $row["per_hfin"];
			if($i == 1){
				$inicia = $hora_inicial;
				$termina = $ini;
				$resta = restaHoras($termina,$inicia);
				$memoria_hini = $ini;
				$memoria_hfin = $fin;
			}else{
				$inicia = $memoria_hfin;
				$termina = $ini;
				$resta = restaHoras($termina,$inicia);
				$memoria_hini = $ini;
				$memoria_hfin = $fin;
			}
			if($resta > 1){
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center">'.$j.' LIBRE</td>';
				//Hora de Inicio del periodo libre
				$salida.= '<td class = "text-center">'.$inicia.'</td>';
				//Hora de Finalizacion del periodo libre
				$salida.= '<td class = "text-center">'.$termina.'</td>';
				//duracion
				$salida.= '<td class = "text-center" >'.$resta.' MINUTOS</td>';
				//--
				$salida.= '</tr>';
				$j++;
			}
			$i++;
		}
		$i--;
	}else{
			$resta = restaHoras($hora_final,$hora_inicial);
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">DIA LIBRE</td>';
			//Hora de Inicio del periodo libre
			$salida.= '<td class = "text-center">'.$hora_inicial.'</td>';
			//Hora de Finalizacion del periodo libre
			$salida.= '<td class = "text-center">'.$hora_final.'</td>';
			//duracion
			$salida.= '<td class = "text-center" >'.$resta.' MINUTOS</td>';
			//--
			$salida.= '</tr>';
	}	
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	
	return $salida;
}



function tabla_libres_aulas($aula,$dia,$hora_inicial,$hora_final){
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_horario('','',$dia,'','','','','','','','','',$aula);
	
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "60px">INICIA</th>';
			$salida.= '<th class = "text-center" width = "60px">TERMINA</th>';
			$salida.= '<th class = "text-center" width = "100px">DURACI&Oacute;N EN MINUTOS</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		$j = 1;
		$memoria_hini = 0;
		$memoria_hfin = 0;
	if(is_array($result)){
		foreach($result as $row){
			//codigo
			$ini = $row["per_hini"];
			$fin = $row["per_hfin"];
			if($i == 1){
				$inicia = $hora_inicial;
				$termina = $ini;
				$resta = restaHoras($termina,$inicia);
				$memoria_hini = $ini;
				$memoria_hfin = $fin;
			}else{
				$inicia = $memoria_hfin;
				$termina = $ini;
				$resta = restaHoras($termina,$inicia);
				$memoria_hini = $ini;
				$memoria_hfin = $fin;
			}
			if($resta > 1){
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center">'.$j.' LIBRE</td>';
				//Hora de Inicio del periodo libre
				$salida.= '<td class = "text-left">'.$inicia.'</td>';
				//Hora de Finalizacion del periodo libre
				$salida.= '<td class = "text-left">'.$termina.'</td>';
				//duracion
				$salida.= '<td class = "text-center" >'.$resta.' MINUTOS</td>';
				//--
				$salida.= '</tr>';
				$j++;
			}
			$i++;
		}
		$i--;
	}else{
			$resta = restaHoras($hora_final,$hora_inicial);
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">DIA LIBRE</td>';
			//Hora de Inicio del periodo libre
			$salida.= '<td class = "text-center">'.$hora_inicial.'</td>';
			//Hora de Finalizacion del periodo libre
			$salida.= '<td class = "text-center">'.$hora_final.'</td>';
			//duracion
			$salida.= '<td class = "text-center" >'.$resta.' MINUTOS</td>';
			//--
			$salida.= '</tr>';
	}	
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	
	
	return $salida;
}




function restaHoras($hIni, $hFin){
	
    //echo "$hIni  /// $hFin <br>";
	$Ini = explode(":",$hIni);
	$Fin = explode(":",$hFin); 
	//echo $Ini[0].", ".$Ini[1].", ".$Ini[2]."  ///  ".$Fin[0].", ".$Fin[1].", ".$Fin[2]."<br>";

    $hora1 = mktime($Ini[0], $Ini[1], $Ini[2]);
    $hora2 = mktime($Fin[0], $Fin[1], $Fin[2]);
	
	//echo "$hora1  /// $hora2";

    return round(($hora1 - $hora2) / (60));
}

?>
