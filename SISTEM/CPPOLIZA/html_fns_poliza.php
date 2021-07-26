<?php 
include_once('../html_fns.php');

//////////////// POLIZAS /////////////////
function tabla_polizas($suc,$doc,$desc,$fini,$ffin){
	$ClsCon = new ClsConta();
	$result = $ClsCon->get_poliza($cod,$suc,$doc,$desc,$fini,$ffin,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "70px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "100px">DOCUMENTO REF.</td>';
			$salida.= '<th class = "text-center" width = "270px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "100px">FECHA CONTABLE</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$sit = $row["pol_situacion"];
			$cod = $row["pol_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsCon->encrypt($cod, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<a type="button" class="btn btn-default btn-xs" href = "FRMmodpoliza.php?hashkey='.$hashkey.'" title = "Editar Poliza" ><span class="fa fa-pencil"></span></a> ';
			$salida.= '<a type="button" class="btn btn-default btn-xs" href = "FRMdetalle.php?hashkey='.$hashkey.'" title = "Editar Detalle de la Poliza" ><span class="fa fa-folder-open"></span></a> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Poliza('.$cod.');" title = "Deshabilitar Poliza" ><span class="fa fa-trash-o"></span></button> ';
			$salida.= '</td>';
			//documento
			$doc = utf8_decode($row["pol_documento"]);
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			//desc
			$desc = utf8_decode($row["pol_descripcion"]);
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//fecha contable
			$fecha = trim($row["pol_fecha_contable"]);
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
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


function tabla_detalle($poliza){
	$ClsCon = new ClsConta();
	$result = $ClsCon->get_det_poliza('',$poliza);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">SUB-REGL&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "100px">MOVIMIENTO</td>';
			$salida.= '<th class = "text-center" width = "100px">MONTO</td>';
			$salida.= '<th class = "text-center" width = "100px">MONEDA</td>';
			$salida.= '<th class = "text-center" width = "100px">T/CAMBIO</td>';
			$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N / MOTIVO</td>';
			$salida.= '<th class = "text-center" width = "10px"><span class="fa fa-cogs"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//subrelon
			$subreglon = utf8_decode($row["sub_descripcion"]);
			$salida.= '<td align = "left">'.$subreglon.'</td>';
			//movimiento
			$mov = trim($row["dpol_movimiento"]);
			$movimiento = ($mov == "D")? "Debe" : "Haber";
			$salida.= '<td class = "text-center">'.$movimiento.'</td>';
			//monto
			$monto = number_format($row["dpol_monto"], 2, '.', '');
			$salida.= '<td class = "text-center">'.$monto.'</td>';
			//monto
			$monto = number_format($row["dpol_monto"], 2, '.', '');
			$salida.= '<td class = "text-center">'.$monto.'</td>';
			//tipo cambio
			$moneda = utf8_decode($row["mon_desc"]).' ('.trim($row["mon_simbolo"]).')';
			$salida.= '<td class = "text-center">'.$moneda.'</td>';
			//motivo
			$motivo = utf8_decode($row["dpol_motivo"]);
			$salida.= '<td  class = "text-justify">'.$motivo.'</td>';
			//boton
			$cod = $row["dpol_codigo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Delete_Detalle('.$cod.','.$poliza.');" title = "Eliminar Detalle" ><span class="fa fa-trash-o"></span></button> ';
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