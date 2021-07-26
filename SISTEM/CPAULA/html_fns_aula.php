<?php 
include_once('../html_fns.php');


function tabla_sedes($cod,$nom,$dep,$mun){
	$ClsAul = new ClsAula();
	$result = $ClsAul->get_sede($cod,$nom,$dep,$mun);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<th class = "text-center" width = "70px"><span class="fa fa-cogs"></span></th></th>';
			$salida.= '<th class = "text-center" width = "150px">NOMBRE O DESCRIPCI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "250px">DIRECCI&Oacute;N</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["sed_codigo"];
			$salida.= '<td class = "text-center"  >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Sede('.$codigo.');" title = "Seleccionar Sede" ><span class="fa fa-edit"></span></button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "abrir();Deshabilita_Sede('.$codigo.');" title = "Deshabilitar Sede" ><span class="fa fa-trash-o"></span></button>';
			$salida.= '</td>';
			//nombre
			$sede_nombre = utf8_decode($row["sed_nombre"]);
			$salida.= '<td class = "text-center">'.$sede_nombre.'</td>';
			//tipo_periodo
			$direccion = utf8_decode($row["sed_direccion"])." ".utf8_decode($row["municiopio_desc"]);
			$salida.= '<td class = "text-center">'.$direccion.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_aulas($cod,$sede,$nom,$tipo){
	$ClsAul = new ClsAula();
	$result = $ClsAul->get_aula($cod,$sede,$tipo,$desc);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<th class = "text-center" width = "70px"><span class="fa fa-cogs"></span></th></th>';
			$salida.= '<th class = "text-center" width = "150px">SEDE</th>';
			$salida.= '<th class = "text-center" width = "250px">NOMBRE O DESCRIPCI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "150px">TIPO DE AULA</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["aul_codigo"];
			$salida.= '<td class = "text-center"  >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Aula('.$codigo.');" title = "Seleccionar Aula" ><span class="fa fa-edit"></span></button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "abrir();Deshabilita_Aula('.$codigo.');" title = "Deshabilitar Aula" ><span class="fa fa-trash-o"></span></button>';
			$salida.= '</td>';
			//Nivel
			$sede_nombre = utf8_decode($row["sed_nombre"]);
			$salida.= '<td class = "text-center">'.$sede_nombre.'</td>';
			//tipo_periodo
			$nom = utf8_decode($row["aul_descripcion"]);
			$salida.= '<td class = "text-center">'.$nom.'</td>';
			//minutos
			$tipo = $row["aul_tipo"];
			switch($tipo){
				case "S": $tipo_desc = "SAL&Oacute;N DE CLASE"; break;
				case "A": $tipo_desc = "AULA AL AIRE LIBRE"; break;
				case "G": $tipo_desc = "GIMNASIO"; break;
				case "T": $tipo_desc = "AUDITORIUM O TEATRO"; break;
				case "O": $tipo_desc = "OTRO"; break;
			}
			$salida.= '<td class = "text-center"  >'.$tipo_desc.'</td>';
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
