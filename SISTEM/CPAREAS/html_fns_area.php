<?php 
include_once('../html_fns.php');

function tabla_areas(){
	$ClsArea = new ClsArea();
	$result = $ClsArea->get_area($cod,$nom,$periodo,$anio,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "50px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</th>';
			$salida.= '<th class = "text-center" width = "100px">PERIODO</th>';
			$salida.= '<th class = "text-center" width = "100px">A&Ntilde;O</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["are_codigo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "Buscar_Area('.$cod.')" title = "Editar &Aacute;rea" ><span class="glyphicon glyphicon-pencil"></span></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Area('.$cod.');" title = "Deshabilitar &Aacute;rea" ><span class="fa fa-trash"></span></button>';
			$salida.= '</td>';
			//nombre
			$desc = trim($row["are_nombre"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//codigo
			$periodo = trim($row["are_periodo"]);
			$salida.= '<td class = "text-center">'.$periodo.'</td>';
			//codigo
			$anio = $row["are_anio"];
			$salida.= '<td class = "text-center">'.$anio.'</td>';
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
