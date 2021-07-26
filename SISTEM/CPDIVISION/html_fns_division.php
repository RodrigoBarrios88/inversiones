<?php 
include_once('../html_fns.php');

function tabla_grupos($codigo,$nombre){
	$ClsDiv = new ClsDivision();
	$result = $ClsDiv->get_grupo($codigo,$nombre,'',1);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "80px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "150px">Nombre</th>';
		$salida.= '<th class = "text-center" width = "100px">Situaci&oacute;n</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			// No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$grupo = $row["gru_codigo"];
			$situacion = $row["gru_situacion"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<div class="btn-group">';
				$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Grupo('.$grupo.');" title = "Editar Grupo" ><i class="fa fa-pencil"></i></button>';
				if($situacion == 1){
				$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Deshabilita_Grupo('.$grupo.');" title = "Deshabilitar Grupo" ><i class="fa fa-trash"></i></button>';
				}else if($situacion == 0){
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="Habilita_Grupo('.$grupo.');" title = "Habilitar Grupo" ><i class="fa fa-retweet"></i></button>';
				}
			$salida.= '</div>';
			$salida.= '</td>';
			//desc
			$nombre = utf8_decode($row["gru_nombre"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//situacion
			$situacion = ($situacion == 1)?"<strong class='text-success'>ACTIVO</strong>":"<strong class='text-danger'>INACTIVO</strong>";
			$salida.= '<td class = "text-center" >'.$situacion.'</td>';
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_division($codigo,$grupo,$nombre){
	$ClsDiv = new ClsDivision();
	$result = $ClsDiv->get_division($codigo,$grupo,$nombre,'',1);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "80px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "200px">Nombre</th>';
		$salida.= '<th class = "text-center" width = "150px">Grupo</th>';
		$salida.= '<th class = "text-center" width = "150px">Empresa</th>';
		$salida.= '<th class = "text-center" width = "100px">Moneda</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$codigo = $row["div_codigo"];
			$grupo = $row["gru_codigo"];
			$situacion = $row["div_situacion"];
			/////////////
			$salida.= '<tr>';
			//No.	
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//--
			$salida.= '<td class = "text-center">';
			$salida.= '<div class="btn-group">';
				$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Division('.$codigo.','.$grupo.');" title = "Editar Division" ><i class="fa fa-pencil"></i></button>';
				if($situacion == 1){
				$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Deshabilita_Division('.$codigo.','.$grupo.');" title = "Deshabilitar Division" ><i class="fa fa-trash"></i></button>';
				}else if($situacion == 0){
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="Habilita_Division('.$codigo.','.$grupo.');" title = "Habilitar Division" ><i class="fa fa-retweet"></i></button>';
				}
			$salida.= '</div>';
			$salida.= '</td>';
			//nombre de cuenta
			$nombre = utf8_decode($row["div_nombre"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//banco
			$grupoNombre = utf8_decode($row["gru_nombre"]);
			$salida.= '<td class = "text-left">'.$grupoNombre.'</td>';
			//empresa
			$empresa = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-left">'.$empresa.'</td>';
			//Moneda
			$moneda = utf8_decode($row["mon_desc"]);
			$salida.= '<td class = "text-left">'.$moneda.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


?>