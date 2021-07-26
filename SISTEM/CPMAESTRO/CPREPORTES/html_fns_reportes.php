<?php
include_once('../../html_fns.php');

function tabla_grupos_maestros(){
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_maestro_grupo("",$maestro,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" class = "text-center">No.</td>';
			$salida.= '<th width = "60px" class = "text-center">CUI</td>';
			$salida.= '<th width = "200px" class = "text-center">MAESTRO</td>';
			$salida.= '<th width = "200px" class = "text-center">GRUPO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'</td>';
			//cui
			$cui = $row["mae_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nombre = utf8_decode($row["mae_nombre"]);
			$apellido = utf8_decode($row["mae_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//grupo
			$gru = utf8_decode($row["gru_nombre"]);
			$salida.= '<td class = "text-center">'.$gru.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_secciones_maestros($pensum,$nivel,$grado,$tipo){
	$ClsAcadem = new ClsAcademico();
	$result = $ClsAcadem->get_seccion_maestro($pensum,$nivel,$grado,'','','',$tipo,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "50px" class = "text-center">CUI</td>';
			$salida.= '<th width = "150px" class = "text-center">MAESTRO</td>';
			$salida.= '<th width = "150px" class = "text-center">GRADO</td>';
			$salida.= '<th width = "100px" class = "text-center">SECCION</td>';
			$salida.= '<th width = "200px" class = "text-center">MATERIAS</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'</td>';
			//cui
			$cui = $row["mae_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nombre = utf8_decode($row["mae_nombre"]);
			$apellido = utf8_decode($row["mae_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//grado
			$gra = utf8_decode($row["gra_descripcion"]);
			$salida.= '<td class = "text-center">'.$gra.'</td>';
			//seccion
			$sec = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-center">'.$sec.'</td>';
			//---
			$maestro = $row["mae_cui"];
			$seccion = $row["sec_codigo"];
			$materias = "";
			$result_materias = $ClsAcadem->get_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,'',$maestro);
			if(is_array($result_materias)){
				foreach($result_materias as $row_materias){
					$materias.= utf8_decode($row_materias["materia_descripcion"]).", ";
				}
				$materias = substr($materias, 0, -2);
			}
			$salida.= '<td class = "text-center">'.$materias.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}




function tabla_materias_maestros($pensum,$nivel,$grado,$tipo){
	$ClsAcadem = new ClsAcademico();
	$result = $ClsAcadem->get_materia_maestro($pensum,$nivel,$grado,'','','',$tipo,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "50px" class = "text-center">CUI</td>';
			$salida.= '<th width = "150px" class = "text-center">MAESTRO</td>';
			$salida.= '<th width = "150px" class = "text-center">GRADO</td>';
			$salida.= '<th width = "200px" class = "text-center">MATERIA</td>';
			$salida.= '<th width = "200px" class = "text-center">SECCIONES</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'</td>';
			//cui
			$cui = $row["mae_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nombre = utf8_decode($row["mae_nombre"]);
			$apellido = utf8_decode($row["mae_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//grado
			$gra = utf8_decode($row["gra_descripcion"]);
			$salida.= '<td class = "text-center">'.$gra.'</td>';
			//materias
			$mat = utf8_decode($row["mat_descripcion"]);
			$salida.= '<td class = "text-center">'.$mat.'</td>';
			//---
			$maestro = $row["mae_cui"];
			$materia = $row["mat_codigo"];
			$secciones = "";
			$result_secciones = $ClsAcadem->get_materia_seccion_maestro($pensum,$nivel,$grado,'',$materia,$maestro);
			if(is_array($result_secciones)){
				foreach($result_secciones as $row_secciones){
					$secciones.= utf8_decode($row_secciones["sec_descripcion"]).", ";
				}
				$secciones = substr($secciones, 0, -2);
			}
			$salida.= '<td class = "text-center">'.$secciones.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


?>
