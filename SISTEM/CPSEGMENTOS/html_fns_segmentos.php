<?php 
include_once('../html_fns.php');

function tabla_segmentos(){
	$ClsArea = new ClsArea();
	$result = $ClsArea->get_segmento($cod,$area,$nom,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "50px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "150px">AREA</td>';
			$salida.= '<th class = "text-center" width = "250px">NOMBRE</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["seg_codigo"];
			$area = $row["seg_area"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "Buscar_Segmento('.$cod.','.$area.')" title = "Editar Segmento" ><span class="glyphicon glyphicon-pencil"></span></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Segmento('.$cod.','.$area.');" title = "Deshabilitar Segmento" ><span class="fa fa-trash"></span></button>';
			$salida.= '</td>';
			//codigo
			$area = trim($row["are_nombre"]);
			$salida.= '<td class = "text-left">'.$area.'</td>';
			//nombre
			$nom = trim($row["seg_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
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