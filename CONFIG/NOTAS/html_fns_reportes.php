<?php
include_once('../../SISTEM/html_fns.php');


function nombre_unidades($numero){
     switch ($numero) {
          case 1: $descripcion = "1ra."; break;
          case 2: $descripcion = "2da."; break;
          case 3: $descripcion = "3ra."; break;
          case 4: $descripcion = "4ta."; break;
          case 5: $descripcion = "5ta."; break;
          case 6: $descripcion = "6ta."; break;
          case 7: $descripcion = "7ma."; break;
          case 8: $descripcion = "8va."; break;
          case 9: $descripcion = "9na."; break;
          case 10: $descripcion = "10ma."; break;
          case 11: $descripcion = "11va."; break;
          case 12: $descripcion = "12va."; break;
          default: $descripcion = $numero."o."; break;
     }
     return $descripcion;
}


function data_grafica_riesgo($alumno,$pensum,$nivel,$grado,$seccion,$materia_codigo,$mat_count,$cant_unidades,$nota_minima){
	$ClsAlu = new ClsAlumno();
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsNot = new ClsNotas();

	$promedios_unidad = array();
	$riesgo_bajo = 0;
	$riesgo_medio = 0;
	$riesgo_alto = 0;
	for($z = 1; $z <= $mat_count; $z++){
		$pendientes = 0;
		$total = 0;
		$notas_validas = 1;
		$columna = 0;
		$materiaX = "-";
		for($parcial = 1; $parcial <= $cant_unidades; $parcial++){
			$materia = $materia_codigo[$z];
			if(($materia != "0") && ($materia != "NULL") && ($materia != $materiaX)){
				//echo " - diferentes $materia - $materiaX; ";
				$materiaX = $materia;
				$columna++;
			}
			///// consulta las notas del alumno en ese parcial para esa materia
			$result = $ClsNot->get_notas_alumno_tarjeta($alumno,$pensum,$nivel,$grado,$seccion,$materia,$parcial);
			if(is_array($result)){
				$punteo = 0;
				foreach($result as $row_notas){
					$zona = $row_notas["not_zona"];
					$nota = $row_notas["not_nota"];
					$punteo = ($zona + $nota);
					$total+= $punteo;
					$notas_validas++;
				}
			}else{
				$punteo = 0;
				$pendientes++;
			}
		}
		$notas_validas--;
		if($total > 0){
			$promedio_riesgo = ($total/$notas_validas);
		}else{
			$promedio_riesgo = 0.00;
		}
		//grafica de riesgo
		if($promedio_riesgo < $nota_minima){
			$riesgo_bajo++;
		}else if($promedio_riesgo >= $nota_minima && $promedio_riesgo < 70){
			$riesgo_medio++;
		}else if($promedio_riesgo > 70){
			$riesgo_alto++;
		}
		//--
	}
	return $arrdata = array("bajo"=>$riesgo_bajo,"medio"=>$riesgo_medio,"alto"=>$riesgo_alto);
}
?>
