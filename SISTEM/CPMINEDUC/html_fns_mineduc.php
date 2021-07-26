<?php 
include_once('../html_fns.php');

//////////////////---- Alumnos -----/////////////////////////////////////////////

function tabla_secciones_alumnos($pensum,$nivel,$grado,$seccion){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" class = "text-center">No.</td>';
			$salida.= '<th width = "60px" class = "text-center">ID</td>';
			$salida.= '<th width = "60px" class = "text-center">TIPO ID</td>';
			$salida.= '<th width = "200px" class = "text-center">ALUMNO</td>';
			$salida.= '<th width = "100px" class = "text-center">ID MINEDUC</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//CUI
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui;
			$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$cui.'" />';
			$salida.= '</td>';
			//TIPO CUI
			$tipo = utf8_decode($row["alu_tipo_cui"]);
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			$salida.= '<td class = "text-left">'.$nombres.'</td>';
			//codigo
			$codigo_mineduc = utf8_decode($row["alu_codigo_mineduc"]);
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "text" class = "form-control" name = "codigo'.$i.'" id = "codigo'.$i.'" value = "'.$codigo_mineduc.'" onblur = "ActualizaCodigo('.$i.');" />';
			$salida.= ' &nbsp; <span id = "spancheck'.$i.'" title = "'.$title.'" ></span> ';
			$salida.= '</td>';
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


?>