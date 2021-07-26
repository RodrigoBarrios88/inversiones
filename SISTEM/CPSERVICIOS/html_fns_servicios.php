<?php 
include_once('../html_fns.php');

function tabla_grupo_servicios($cod,$nom,$sit){
	$ClsSer = new ClsServicio();
	$result = $ClsSer->get_grupo($cod,$nom,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "100px" height = "30px"><span class="fa fa-cogs"></span></th></th>';
			$salida.= '<th class = "text-center" width = "250px">NOMBRE</th>';
			$salida.= '<th class = "text-center" width = "100px">SITUACI&Oacute;N</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$gru = $row["gru_codigo"];
			$sit = $row["gru_situacion"];
			$salida.= '<td class = "text-center"  >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Grupo_Servicio('.$gru.')" title = "Seleccionar Grupo" ><span class="fa fa-edit"></span></button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "abrir();Deshabilita_Grupo('.$gru.')" title = "Deshabilitar Grupo" ><span class="fa fa-trash-o"></span></button>';
			$salida.= '</td>';
			//grupo
			$grun = utf8_decode($row["gru_nombre"]);
			$salida.= '<td class = "text-center">'.$grun.'</td>';
			//situacion
			$sit = ($sit == 1)?'<strong class = "text-success">ACTIVO</strong>':'<strong class = "text-danger">INACTIVO</strong>';
			$salida.= '<td class = "text-center"  >'.$sit.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_servicios($cod,$grup,$nom,$desc,$barc,$sit){
	$ClsSer = new ClsServicio();
	$result = $ClsSer->get_servicio($cod,$grup,$nom,$desc,$barc,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "100px"><span class="fa fa-cogs"></span></th></th>';
			$salida.= '<th class = "text-center" width = "90px">GRUPO</th>';
			$salida.= '<th class = "text-center" width = "150px">BARCODE</th>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</th>';
			$salida.= '<th class = "text-center" width = "250px">DESCRIPCI&Oacute;N</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$art = $row["ser_codigo"];
			$gru = $row["gru_codigo"];
			$sit = $row["ser_situacion"];
			$salida.= '<td class = "text-center"  >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Servicio('.$art.','.$gru.')" title = "Seleccionar Servicio" ><span class="fa fa-edit"></span></button> &nbsp;';
			if($sit == 1){
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "abrir();Deshabilita_Servicio('.$art.','.$gru.')" title = "Deshabilitar Servicio" ><span class="fa fa-trash-o"></span></button>';
			}else if($sit == 0){
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "abrir();Habilita_Servicio('.$art.','.$gru.')" title = "Habilitar Servicio" ><span class="fa fa-retweet"></span></button>';
			}
			$salida.= '</td>';
			//grupo
			$grun = utf8_decode($row["gru_nombre"]);
			$salida.= '<td class = "text-center">'.$grun.'</td>';
			//barcode
			$barc = $row["ser_barcode"];
			$barc = ($barc != "")?$barc:"N/A";
			$salida.= '<td class = "text-center" >'.$barc.'</td>';
			//nombre
			$nom = utf8_decode($row["ser_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//desc
			$desc = utf8_decode($row["ser_desc"]);
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


//echo tabla_costos($cod,$lot,$art,$grup);



?>
