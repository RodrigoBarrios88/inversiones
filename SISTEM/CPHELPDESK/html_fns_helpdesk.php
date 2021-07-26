<?php 
include_once('../html_fns.php');

function tabla_incidentes(){
	$ClsInc = new ClsIncidente();
	$result = $ClsInc->get_incidente($cod,$dct,$dlg,$pai,$sit);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "5px">No.</th>';
		$salida.= '<th class = "text-center" width = "5px"></th>';
		$salida.= '<th class = "text-center" width = "5px"></th>';
		$salida.= '<th class = "text-center" width = "100px">M&oacute;dulo</th>';
		$salida.= '<th class = "text-center" width = "60px">Plataforma</th>';
		$salida.= '<th class = "text-center" width = "100px">Tipo de Incidente</th>';
		$salida.= '<th class = "text-center" width = "100px">Report&oacute;o (Encargado)</th>';
		$salida.= '<th class = "text-center" width = "150px">Descripci&oacute;n del Problema</th>';
		$salida.= '<th class = "text-center" width = "60px">Prioridad</th>';
		$salida.= '<th class = "text-center" width = "80px">Fecha de Reporte</th>';
		$salida.= '<th class = "text-center" width = "70px">Status</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$disabled = ($row["inc_situacion"] == 1)?'':'disabled';
			$codigo = $row["inc_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsInc->encrypt($codigo, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-default btn-xs" href="FRMedit.php?hashkey='.$hashkey.'" title = "Editar Incidente" '.$disabled.' ><i class="fa fa-pencil"></i></a> ';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary btn-xs" onclick="Informacion('.$codigo.');" title = "Ver Incidente" ><i class="fa fa-info-circle"></i></button> ';
			$salida.= '</td>';
			//modulo
			$modulo = utf8_decode($row["mod_descripcion"]);
			$salida.= '<td class = "text-left">'.$modulo.'</td>';
			//plataforma
			$plata = utf8_decode($row["pla_descripcion"]);
			$salida.= '<td class = "text-left">'.$plata.'</td>';
			//tipo
			$tipo = utf8_decode($row["tip_descripcion"]);
			$salida.= '<td class = "text-left">'.$tipo.'</td>';
			//reporto
			$reporto = utf8_decode($row["inc_persona"]);
			$salida.= '<td class = "text-left">'.$reporto.'</td>';
			//desc
			$desc = utf8_decode($row["inc_descripcion"]);
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//prioridad
			$prior = trim($row["inc_prioridad"]);
			switch($prior){
				case 'N': $prioridad = "2.Normal"; break;
				case 'B': $prioridad = "1.Baja"; break;
				case 'A': $prioridad = "3.Alta"; break;
				case 'U': $prioridad = "4.Urgente"; break;
			}
			$salida.= '<td class = "text-left">'.$prioridad.'</td>';
			//desc
			$freg = cambia_fechaHora($row["inc_fecha_registro"]);
			$salida.= '<td class = "text-center">'.$freg.'</td>';
			//situacion
			$sit = trim($row["inc_situacion"]);
			switch($sit){
				case 10: $status = '<span class = "text-danger">Cancelado</span>'; break;
				case 1: $status = '<span class = "text-muted">1.Reportado</span>'; break;
				case 2: $status = '<span class = "text-info">2.Recibido y en tr&aacute;mite</span>'; break;
				case 3: $status = '<span class = "text-info">3.En evaluaci&oacute;n y soluci&oacute;n</span>'; break;
				case 4: $status = '<b class = "text-success">4.Solucionado</b>'; break;
			}
			//echo $tipo_usuario = $_SESSION["tipo_usuario"];
			$salida.= '<td class = "text-center" >'.$status.'</td>';	
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
