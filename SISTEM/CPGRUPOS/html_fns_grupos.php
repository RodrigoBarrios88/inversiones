<?php 
include_once('../html_fns.php');

function tabla_grupo_clases(){
	$ClsGruCla = new ClsGrupoClase();
	$result = $ClsGruCla->get_grupo_clase($cod,$nom,$area,$segmento,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "50px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "200px">GRUPO</th>';
			$salida.= '<th class = "text-center" width = "150px">SEGMENTO</th>';
			$salida.= '<th class = "text-center" width = "150px">AREA</td>';
			$salida.= '<th class = "text-center" width = "100px">PERIODO</th>';
			$salida.= '<th class = "text-center" width = "100px">A&Ntilde;O</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["gru_codigo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "Buscar_Grupo_Clase('.$cod.')" title = "Editar Grupo" ><span class="glyphicon glyphicon-pencil"></span></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Grupo('.$cod.');" title = "Deshabilitar Grupo" ><span class="fa fa-trash"></span></button>';
			$salida.= '</td>';
			//nombre
			$nom = trim($row["gru_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//codigo
			$desc = trim($row["seg_nombre"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//codigo
			$desc =trim($row["are_nombre"]);
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


function tabla_grupo_clases2(){
	$ClsGruCla = new ClsGrupoClase();
	$result = $ClsGruCla->APP_USU();
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "50px">Cui Usuario</th>';
			$salida.= '<th class = "text-center" width = "200px">Dispositivo</th>';
			$salida.= '<th class = "text-center" width = "150px">Fecha</th>';
			$salida.= '<th class = "text-center" width = "150px">Usuario</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=0;
		foreach($result as $row){
			$salida.= '<tr>';
			//nombre
			$nom = trim($row["user_id"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//codigo
			$desc = trim($row["device_type"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//codigo
			$desc =trim($row["updated_at"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//codigo
			$periodo = trim($row["usu_nombre"]);
			$salida.= '<td class = "text-center">'.$periodo.'</td>';
		
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}
?>
