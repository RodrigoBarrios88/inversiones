<?php 
include_once('../html_fns.php');

//////////////// PARTIDAS /////////////////
function tabla_partidas($cod,$tipo,$clase,$desc,$sit){
	$ClsPar = new ClsPartida();
	$result = $ClsPar->get_partida($cod,$tipo,$clase,$desc,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "100px">NOMENCLATURA</td>';
			$salida.= '<th class = "text-center" width = "270px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "100px">TIPO</td>';
			$salida.= '<th class = "text-center" width = "100px">CLASIFICACI&Oacute;N</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$sit = $row["par_situacion"];
			$cod = $row["par_codigo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Partida('.$cod.')" title = "Editar Partida" ><span class="fa fa-pencil"></span></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Partida('.$cod.');" title = "Deshabilitar Partida" ><span class="fa fa-trash-o"></span></button> ';
			$salida.= '</td>';
			//codigo
			$cod = Agrega_Ceros($cod);
			$salida.= '<td class = "text-center">'.$cod.'</td>';
			//desc
			$desc = utf8_decode($row["par_descripcion"]);
			$salida.= '<td align = "left">'.$desc.'</td>';
			//tipo
			$tipo = $row["par_tipo"];
			switch ($tipo){
				case "A": $tipo = "Activos"; break;
				case "P1": $tipo = "Pasivos"; break;
				case "P2": $tipo = "Patrimonio"; break;
				case "I": $tipo = "Ingresos"; break;
				case "E": $tipo = "Egresos"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//clases
			$clase = utf8_decode($row["cla_descripcion"]);
			$salida.= '<td class = "text-center">'.$clase.'</td>';
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


function tabla_clases($cod,$tipo,$desc,$sit){
	$ClsPar = new ClsPartida();
	$result = $ClsPar->get_clase($cod,$tipo,$desc,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "100px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "270px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "100px">TIPO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$sit = $row["cla_situacion"];
			$cod = $row["cla_codigo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Clase('.$cod.')" title = "Editar Clasificaci&oacute;n" ><span class="fa fa-pencil"></span></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Clase('.$cod.');" title = "Deshabilitar Clasificaci&oacute;n" ><span class="fa fa-trash-o"></span></button> ';
			$salida.= '</td>';
			//codigo
			$salida.= '<td class = "text-center">'.$cod.'</td>';
			//desc
			$desc = utf8_decode($row["cla_descripcion"]);
			$salida.= '<td align = "left">'.$desc.'</td>';
			//tipo
			$tipo = $row["cla_tipo"];
			switch ($tipo){
				case "A": $tipo = "Activos"; break;
				case "P1": $tipo = "Pasivos"; break;
				case "P2": $tipo = "Patrimonio"; break;
				case "I": $tipo = "Ingresos"; break;
				case "E": $tipo = "Egresos"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
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


function tabla_reglones($cod,$part,$dct,$dlg,$sit){
	$ClsPar = new ClsPartida();
	$result = $ClsPar->get_reglon($cod,$part,'',$dct,$dlg,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px"><span class="fa fa-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "100px">NOMENCLATURA</td>';
			$salida.= '<th class = "text-center" width = "270px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "100px">TIPO</td>';
			$salida.= '<th class = "text-center" width = "100px">CLASIFICACI&Oacute;N</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$sit = $row["reg_situacion"];
			$par = $row["par_codigo"];
			$cod = $row["reg_codigo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Reglon('.$cod.','.$par.');" title = "Editar Reglon" ><span class="fa fa-pencil"></span></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Reglon('.$cod.','.$par.');" title = "Deshabilitar Reglon" ><span class="fa fa-trash-o"></span></button> ';
			$salida.= '</td>';
			//nomenclatura
			$par = Agrega_Ceros($par);
			$cod = Agrega_Ceros($cod);
			$salida.= '<td class = "text-center">'.$par.'.'.$cod.'</td>';
			//Descripcion
			$desc = utf8_decode($row["reg_desc_lg"]);
			$salida.= '<td align = "left">'.$desc.'</td>';
			//tipo
			$tipo = $row["par_tipo"];
			switch ($tipo){
				case "A": $tipo = "Activos"; break;
				case "P1": $tipo = "Pasivos"; break;
				case "P2": $tipo = "Patrimonio"; break;
				case "I": $tipo = "Ingresos"; break;
				case "E": $tipo = "Egresos"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//clases
			$clase = utf8_decode($row["cla_descripcion"]);
			$salida.= '<td class = "text-center">'.$clase.'</td>';
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


function tabla_subreglones($cod,$part,$reglon,$desc,$sit){
	$ClsPar = new ClsPartida();
	$result = $ClsPar->get_subreglon($cod,$part,$reglon,'',$desc,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px"><span class="fa fa-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "150px">CLASIFICACI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "150px">PARTIDA</td>';
			$salida.= '<th class = "text-center" width = "150px">REGL&Oacute;N</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$sit = $row["sub_situacion"];
			$partida = $row["par_codigo"];
			$reglon = $row["reg_codigo"];
			$cod = $row["sub_codigo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Subreglon('.$cod.','.$partida.','.$reglon.');" title = "Editar Sub-Reglon" ><span class="fa fa-pencil"></span></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Subreglon('.$cod.','.$partida.','.$reglon.');" title = "Deshabilitar Sub-Reglon" ><span class="fa fa-trash-o"></span></button> ';
			$salida.= '</td>';
			//Descripcion
			$desc = utf8_decode($row["sub_descripcion"]);
			$salida.= '<td align = "left">'.$desc.'</td>';
			//clases
			$clase = utf8_decode($row["cla_descripcion"]);
			$salida.= '<td class = "text-center">'.$clase.'</td>';
			//paritda
			$part = utf8_decode($row["par_descripcion"]);
			$salida.= '<td align = "left">'.$part.'</td>';
			//reglon
			$reg = utf8_decode($row["reg_desc_ct"]);
			$salida.= '<td align = "left">'.$reg.'</td>';
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