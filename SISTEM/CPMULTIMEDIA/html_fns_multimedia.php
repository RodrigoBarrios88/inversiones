<?php
include_once('../html_fns.php');
//Push Notifications
include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');

function tabla_multimedia($codigo,$tipo,$categoria,$ordenado_por){
	$ClsMulti = new ClsMultimedia();
	$result = $ClsMulti->get_multimedia($codigo,$tipo,$categoria,1);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th width = "10px" class = "text-center">No.</td>';
		$salida.= '<th width = "20px" class = "text-center"><i class="fa fa-cog"></i></td>';
		$salida.= '<th width = "80px" class = "text-center">T&Iacute;TULO</td>';
		$salida.= '<th width = "100px" class = "text-center">TIPO</td>';
		$salida.= '<th width = "100px" class = "text-center">CATEGOR&Iacute;A</td>';
		$salida.= '<th width = "20px" class = "text-center"><i class="fa fa-film"></i></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$codigo = $row["multi_codigo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default" onclick="abrir();xajax_Buscar_Multimedia('.$codigo.');" target = "_blank" data-toggle="tooltip" data-placement="top" title = "Seleccionar Contenido Multimedia para Editar" ><i class="fa fa-pencil"></i></button>';
			$salida.= '<button type="button" class="btn btn-danger" onclick="Confirm_Eliminar_Multimedia('.$codigo.');" title = "Quitar Video del Listado" ><i class="fa fa-trash"></i></button>';
			$salida.= '</td>';	
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//titulo
			$titulo = utf8_decode($row["multi_titulo"]);
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//tipo
			$tipo = trim($row["multi_tipo"]);
			switch($tipo){
				case 0: $tipo = "OTRO"; break;
				case 1: $tipo = "EDUCATIVO Y/O PEDAG&Oacute;GICO"; break;
				case 2: $tipo = "ENTRETENIMIENTO"; break;
				case 3: $tipo = "INTERESANTE"; break;
			}
			$salida.= '<td class = "text-left">'.$tipo.'</td>';
			//categoria
			$categoria = trim($row["multi_categoria"]);
			switch($categoria){
				case 0: $categoria = "OTROS"; break;
				case 1: $categoria = "PARA PADRES"; break;
				case 2: $categoria = "PARA ALUMNOS"; break;
				case 3: $categoria = "ACTIVIDADES INTERNAS"; break;
			}
			$salida.= '<td class = "text-left">'.$categoria.'</td>';
			//video
			$salida.= '<td class = "text-center">';
			$link = $row["multi_link"];
			$salida.= '<a class="btn btn-default btn-md" href="https://www.youtube.com/watch?v='.$link.'" target = "_blank" title = "ver video" ><i class="fa fa-search"></i> <i class="fa fa-film"></i></a>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


?>
