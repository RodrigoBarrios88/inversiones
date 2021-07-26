<?php 
include_once('../../html_fns.php');

//////////////////---- Otros Maestros -----/////////////////////////////////////////////

function tabla_configuracion_horas_laborales($nomina,$cui){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_configuracion_horas_laboradas('',1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-bordered ">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "20px">BASE</td>';
			$salida.= '<th class = "text-center" width = "20px">BONIFICACION</td>';
			$salida.= '<th class = "text-center" width = "20px">CANTIDAD DE HORAS</td>';
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["conf_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//descripcion
			$mon = utf8_decode($row["mon_id"]);
			$moneda = utf8_decode($row["mon_simbolo"]);
			$tcambio = utf8_decode($row["mon_cambio"]);
			$monto = utf8_decode($row["conf_monto_hora"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$monto.'</td>';
			//descripcion
			$bono = utf8_decode($row["conf_bonificacion_hora"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$bono.'</td>';
			//obs
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "text" class="form-control text-center" name = "cantidad'.$i.'" id = "cantidad'.$i.'" />';
			$salida.= '</td>';
			//total
			$tipo = utf8_decode($row["conf_codigo"]);
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary btn-circle" onclick = "GrabaHorasLaboradas(\''.$nomina.'\',\''.$cui.'\','.$tipo.','.$monto.','.$bono.','.$mon.','.$tcambio.','.$i.');" title = "Grabar" ><span class="fa fa-arrow-right"></span></button>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_horas_laborales($nomina,$cui){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_horas_laboradas($nomina,$cui,'');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "25px">BASE</td>';
			$salida.= '<th class = "text-center" width = "25px">BONIFICACION</td>';
			$salida.= '<th class = "text-center" width = "25px">CANTIDAD DE HORAS</td>';
			$salida.= '<th class = "text-center" width = "25px">TOTAL</td>';
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["conf_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//descripcion
			$moneda = utf8_decode($row["mon_simbolo"]);
			$tcambio = utf8_decode($row["hor_tipo_cambio"]);
			$monto = utf8_decode($row["hor_monto_hora"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$monto.'</td>';
			//descripcion
			$bono = utf8_decode($row["hor_bonificacion_hora"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$bono.'</td>';
			//obs
			$cant = utf8_decode($row["hor_cantidad"]);
			$salida.= '<td class = "text-center">'.$cant.'</td>';
			//total
			$total = (($monto + $bono)*$cant)*$tcambio;
			$total = round($total,2);
			$salida.= '<td class = "text-center">'.$moneda.' '.$total.'</td>';
			//--
			$codigo = trim($row["hor_codigo"]);
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "abrir();xajax_Quitar_Horas_Laboradas(\''.$nomina.'\',\''.$cui.'\','.$codigo.');" title = "Quitar" ><span class="fa fa-times"></span></button>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}




function tabla_configuracion_horas_extras($nomina,$cui){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_configuracion_horas_extras('',1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-bordered ">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "20px">BASE</td>';
			$salida.= '<th class = "text-center" width = "20px">BONIFICACION</td>';
			$salida.= '<th class = "text-center" width = "20px">CANTIDAD DE HORAS</td>';
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["conf_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//descripcion
			$mon = utf8_decode($row["mon_id"]);
			$moneda = utf8_decode($row["mon_simbolo"]);
			$tcambio = utf8_decode($row["mon_cambio"]);
			$monto = utf8_decode($row["conf_monto_hora"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$monto.'</td>';
			//descripcion
			$bono = utf8_decode($row["conf_bonificacion_hora"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$bono.'</td>';
			//obs
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "text" class="form-control text-center" name = "cantidad'.$i.'" id = "cantidad'.$i.'" />';
			$salida.= '</td>';
			//total
			$tipo = utf8_decode($row["conf_codigo"]);
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary btn-circle" onclick = "GrabaHorasExtras(\''.$nomina.'\',\''.$cui.'\','.$tipo.','.$monto.','.$bono.','.$mon.','.$tcambio.','.$i.');" title = "Grabar" ><span class="fa fa-arrow-right"></span></button>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_horas_extras($nomina,$cui){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_horas_extras($nomina,$cui,'');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "25px">BASE</td>';
			$salida.= '<th class = "text-center" width = "25px">BONIFICACION</td>';
			$salida.= '<th class = "text-center" width = "25px">CANTIDAD DE HORAS</td>';
			$salida.= '<th class = "text-center" width = "25px">TOTAL</td>';
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["conf_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//descripcion
			$moneda = utf8_decode($row["mon_simbolo"]);
			$tcambio = utf8_decode($row["hor_tipo_cambio"]);
			$monto = utf8_decode($row["hor_monto_hora"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$monto.'</td>';
			//descripcion
			$bono = utf8_decode($row["hor_bonificacion_hora"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$bono.'</td>';
			//obs
			$cant = utf8_decode($row["hor_cantidad"]);
			$salida.= '<td class = "text-center">'.$cant.'</td>';
			//total
			$total = (($monto + $bono)*$cant)*$tcambio;
			$total = round($total,2);
			$salida.= '<td class = "text-center">'.$moneda.' '.$total.'</td>';
			//--
			$codigo = trim($row["hor_codigo"]);
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "abrir();xajax_Quitar_Horas_Extras(\''.$nomina.'\',\''.$cui.'\','.$codigo.');" title = "Quitar" ><span class="fa fa-times"></span></button>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}




function tabla_base_bonificaciones_regulares($nomina,$cui){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_base_bonificaciones('',$cui,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-bordered ">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "20px">MONTO</td>';
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["bas_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//descripcion
			$moneda = utf8_decode($row["mon_simbolo"]);
			$monto = utf8_decode($row["bas_monto"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$monto.'</td>';
			//valores
			$mon = utf8_decode($row["mon_id"]);
			$tcambio = utf8_decode($row["bas_tipo_cambio"]);
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary btn-circle" onclick = "abrir();xajax_Grabar_Bonificacion_Regular(\''.$nomina.'\',\''.$cui.'\',\''.$monto.'\',\''.$mon.'\',\''.$tcambio.'\',\''.$desc.'\');" title = "Asignar" ><span class="fa fa-arrow-right"></span></button>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_bonificaciones_regulares($nomina,$cui){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_bonificaciones_generales($nomina,$cui,'');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "25px">MONTO</td>';
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["bon_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//descripcion
			$moneda = utf8_decode($row["mon_simbolo"]);
			$tcambio = utf8_decode($row["bon_tipo_cambio"]);
			$monto = utf8_decode($row["bon_monto"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$monto.'</td>';
			//--
			$codigo = trim($row["bon_codigo"]);
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "abrir();xajax_Quitar_Bonificacion_Regular(\''.$nomina.'\',\''.$cui.'\','.$codigo.');" title = "Quitar" ><span class="fa fa-times"></span></button>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_personal_bonos_emergentes($nomina,$cui){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_bonificaciones_emeregentes($nomina,$cui,'');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px"><span class="fa fa-cogs"></span></td>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "25px">MONTO</td>';
			$salida.= '<th class = "text-center" width = "25px">TIPO DE CAMBIO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			$codigo = $row["bon_codigo"];
			$dpi = $row["bon_personal"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_Bono_Emergente(\''.$nomina.'\',\''.$dpi.'\',\''.$codigo.'\');" title = "Editar Bonificaci&oacute;n Emergente" ><span class="glyphicon glyphicon-pencil"></span></button>  ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Bono_Emergente(\''.$nomina.'\',\''.$dpi.'\',\''.$codigo.'\');" title = "inhabilitar Bonificaci&oacute;n Emergente" ><span class="glyphicon glyphicon-trash"></span></button>';
			$salida.= '</td>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["bon_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//monto
			$moneda = utf8_decode($row["mon_simbolo"]);
			$monto = utf8_decode($row["bon_monto"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$monto.'</td>';
			//tipo de cambio
			$tcambio = utf8_decode($row["bon_tipo_cambio"]);
			$salida.= '<td class = "text-center">'.$tcambio.' x 1</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_personal_comisiones($nomina,$cui){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_comisiones($nomina,$cui,'');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px"><span class="fa fa-cogs"></span></td>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "25px">MONTO</td>';
			$salida.= '<th class = "text-center" width = "25px">TIPO DE CAMBIO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			$codigo = $row["com_codigo"];
			$dpi = $row["com_personal"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_Comision(\''.$nomina.'\',\''.$dpi.'\',\''.$codigo.'\');" title = "Editar Bonificaci&oacute;n Emergente" ><span class="glyphicon glyphicon-pencil"></span></button>  ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Comision(\''.$nomina.'\',\''.$dpi.'\',\''.$codigo.'\');" title = "inhabilitar Bonificaci&oacute;n Emergente" ><span class="glyphicon glyphicon-trash"></span></button>';
			$salida.= '</td>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["com_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//monto
			$moneda = utf8_decode($row["mon_simbolo"]);
			$monto = utf8_decode($row["com_monto"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$monto.'</td>';
			//tipo de cambio
			$tcambio = utf8_decode($row["com_tipo_cambio"]);
			$salida.= '<td class = "text-center">'.$tcambio.' x 1</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_base_descuentos($nomina,$cui){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_base_descuentos('',$cui,1);
	
	if(is_array($result)){
			$salida.= '<table class="table table-bordered ">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "20px">MONTO</td>';
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["bas_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//descripcion
			$moneda = utf8_decode($row["mon_simbolo"]);
			$monto = utf8_decode($row["bas_monto"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$monto.'</td>';
			//valores
			$mon = utf8_decode($row["mon_id"]);
			$tcambio = utf8_decode($row["bas_tipo_cambio"]);
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary btn-circle" onclick = "abrir();xajax_Grabar_Descuento_Regular(\''.$nomina.'\',\''.$cui.'\',\''.$monto.'\',\''.$mon.'\',\''.$tcambio.'\',\''.$desc.'\');" title = "Asignar" ><span class="fa fa-arrow-down"></span></button>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
	}
	
	return $salida;
}


function tabla_personal_descuentos($nomina,$cui){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_descuentos($nomina,$cui,'');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px"><span class="fa fa-cogs"></span></td>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "25px">MONTO</td>';
			$salida.= '<th class = "text-center" width = "25px">TIPO DE CAMBIO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			$codigo = $row["des_codigo"];
			$dpi = $row["des_personal"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_Descuento_Emergente(\''.$nomina.'\',\''.$dpi.'\',\''.$codigo.'\');" title = "Editar Bonificaci&oacute;n Emergente" ><span class="glyphicon glyphicon-pencil"></span></button>  ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Descuento(\''.$nomina.'\',\''.$dpi.'\',\''.$codigo.'\');" title = "inhabilitar Bonificaci&oacute;n Emergente" ><span class="glyphicon glyphicon-trash"></span></button>';
			$salida.= '</td>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["des_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//monto
			$moneda = utf8_decode($row["mon_simbolo"]);
			$monto = utf8_decode($row["des_monto"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$monto.'</td>';
			//tipo de cambio
			$tcambio = utf8_decode($row["des_tipo_cambio"]);
			$salida.= '<td class = "text-center">'.$tcambio.' x 1</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}





?>