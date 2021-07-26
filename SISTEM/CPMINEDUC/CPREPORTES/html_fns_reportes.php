<?php
include_once('../../html_fns.php');

function tabla_alumnos_inscritos($pensum,$nivel,$grado,$seccion){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','',$tipo,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" class = "text-center">No.</td>';
			$salida.= '<th width = "60px" class = "text-center">C&oacute;digo Personal</td>';
			$salida.= '<th width = "200px" class = "text-center">Apellidos</td>';
			$salida.= '<th width = "200px" class = "text-center">Nombres</td>';
			$salida.= '<th width = "100px" class = "text-center">Fecha de Nacimiento</td>';
			$salida.= '<th width = "100px" class = "text-center">Nacionalidad</td>';
			$salida.= '<th width = "100px" class = "text-center">Documento de Identificaci&oacute;n</td>';
			$salida.= '<th width = "100px" class = "text-center">No. de Doc. de Identificaci&oacute;n</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo mineduc
			$codigo = $row["alu_codigo_mineduc"];
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//apellidos
			$apellido = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$apellido.'</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//fecha nac
			$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
			$salida.= '<td class = "text-center">'.$fecnac.'</td>';
			//nacionalidad
			$nacionalidad = utf8_decode($row["alu_nacionalidad"]);
			$nacionalidad = ($nacionalidad == "502")?"Guatemalteco":"";
			$salida.= '<td class = "text-center">'.$nacionalidad.'</td>';
			//tipo cui
			$tipo = $row["alu_tipo_cui"];
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//cui
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
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


function tabla_alumnos_auxiliar($pensum,$nivel,$grado,$seccion){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','',$tipo,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">Clave</td>';
			$salida.= '<th width = "200px" class = "text-center">Alumno</td>';
			$salida.= '<th width = "10px" class = "text-center">1</td>';
			$salida.= '<th width = "10px" class = "text-center">2</td>';
			$salida.= '<th width = "10px" class = "text-center">3</td>';
			$salida.= '<th width = "10px" class = "text-center">4</td>';
			$salida.= '<th width = "10px" class = "text-center">5</td>';
			$salida.= '<th width = "10px" class = "text-center">6</td>';
			$salida.= '<th width = "30px" class = "text-center">Ap. Ob</td>';
			$salida.= '<th width = "30px" class = "text-center">Actividades</td>';
			$salida.= '<th width = "30px" class = "text-center">Eval</td>';
			$salida.= '<th width = "30px" class = "text-center">Total</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//apellidos
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombre = utf8_decode($row["alu_nombre"]);
			$salida.= '<td class = "text-left">'.$apellido.', '.$nombre.'</td>';
			//--
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<th></td>';
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
