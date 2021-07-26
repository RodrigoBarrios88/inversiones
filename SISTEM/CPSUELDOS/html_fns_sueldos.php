<?php 
include_once('../html_fns.php');

//////////////////---- Otros Maestros -----/////////////////////////////////////////////
function tabla_tipo_nomina($codigo,$desc,$sit){
	$ClsPla = new ClsPlanilla();
	$result = $ClsPla->get_tipo_nomina($codigo,$desc,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "250px">OBSERVACIONES</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["tip_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_Tipo_Nomina(\''.$codigo.'\')" title = "Editar Tipo de Nomina" ><span class="glyphicon glyphicon-pencil"></span></button>  ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Tipo_Nomina(\''.$codigo.'\')" title = "inhabilitar Tipo de Nomina" ><span class="glyphicon glyphicon-trash"></span></button>';
			$salida.= '</td>';
			//descripcion
			$nom = utf8_decode($row["tip_descripcion"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//obs
			$ape = utf8_decode($row["tip_observaciones"]);
			$salida.= '<td class = "text-justify">'.$ape.'</td>';
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



function tabla_edicion_nominas($codigo,$tipo,$clase,$periodo,$sit){
	$ClsPla = new ClsPlanilla();
	$result = $ClsPla->get_nomina($codigo,$tipo,$clase,$periodo,'','',$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "25px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "150px">T&Iacute;TULO</td>';
			$salida.= '<th class = "text-center" width = "120px">TIPO</td>';
			$salida.= '<th class = "text-center" width = "120px">CLASE</td>';
			$salida.= '<th class = "text-center" width = "100px">PERIODO</td>';
			$salida.= '<th class = "text-center" width = "120px">DESDE - HASTA</td>';
			$salida.= '<th class = "text-center" width = "150px">STATUS</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["nom_codigo"];
			$situacion = $row["nom_situacion"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsPla->encrypt($codigo, $usu);
			$salida.= '<td class = "text-center" >';
			if($situacion == 1){
				$salida.= '<a type="button" class="btn btn-primary btn-xs" onclick = "xajax_Buscar_Nomina('.$codigo.');" title = "Seleccionar Nomina" ><span class="fa fa-edit"></span></a>';
			}else{
				$salida.= '<button type="button" class="btn btn-primary btn-xs" title = "Seleccionar Nomina" disabled ><span class="fa fa-edit"></span></button>';
			}
			$salida.= '</td>';
			//titulo
			$titulo = trim(utf8_decode($row["nom_titulo"]));
			$salida.= '<td class = "text-center">'.$titulo.'</td>';
			//tipo
			$tipo = trim(utf8_decode($row["tip_descripcion"]));
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//clase
			$clase = trim(utf8_decode($row["nom_clase"]));
			switch($clase){
				case 'P': $clase = "PLANILLA"; break;
				case 'F': $clase = "FACTURADO"; break;
			}
			$salida.= '<td class = "text-center">'.$clase.'</td>';
			//periodo
			$periodo = trim(utf8_decode($row["nom_tipo_periodo"]));
			switch($periodo){
				case 'S': $periodo = "SEMANAL"; break;
				case 'Q': $periodo = "QUINCENAL"; break;
				case 'M': $periodo = "MENSUAL"; break;
				case 'E': $periodo = "ESPECIAL"; break;
			}
			$salida.= '<td class = "text-center">'.$periodo.'</td>';
			//desde - hasta
			$desde =  $row["nom_desde"];
			$desde = cambia_fecha($desde);
			$hasta = $row["nom_hasta"];
			$hasta = cambia_fecha($hasta);
			$salida.= '<td class = "text-center">'.$desde.' - '.$hasta.'</td>';
			//correo
			$status = $row["nom_situacion"];
			switch($status){
				case 0: $status = '<label class = "text-danger">DENEGADA</label>'; break;
				case 1: $status = '<label class = "text-info">EDICI&Oacute;N</label>'; break;
				case 2: $status = '<label class = "text-info">SOLICITUD DE APROBACI&Oacute;N</label>'; break;
				case 3: $status = '<label class = "text-success">APROBADA - PENDIENTE DE PAGO</label>'; break;
				case 4: $status = '<label class = "text-success">PAGADA</label>'; break;
			}
			$salida.= '<td class = "text-center">'.$status.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		
	}
	
	return $salida;
}


function tabla_status_nomina($codigo,$tipo,$clase,$periodo,$sit){
	$ClsPla = new ClsPlanilla();
	$result = $ClsPla->get_nomina($codigo,$tipo,$clase,$periodo,'','',$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "25px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "150px">T&Iacute;TULO</td>';
			$salida.= '<th class = "text-center" width = "100px">PERIODO</td>';
			$salida.= '<th class = "text-center" width = "120px">DESDE - HASTA</td>';
			$salida.= '<th class = "text-center" width = "150px">STATUS</td>';
			$salida.= '<th class = "text-center" width = "200px"><span class="fa fa-tasks"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["nom_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsPla->encrypt($codigo, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-primary" href="FRMnomina.php?hashkey='.$hashkey.'" target = "_blank" title = "Visualizar Detalle de Nomina" ><span class="fa fa-search"></span></a>';
			$salida.= '</td>';
			//titulo
			$titulo = trim(utf8_decode($row["nom_titulo"]));
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//periodo
			$periodo = trim(utf8_decode($row["nom_tipo_periodo"]));
			switch($periodo){
				case 'S': $periodo = "SEMANAL"; break;
				case 'Q': $periodo = "QUINCENAL"; break;
				case 'M': $periodo = "MENSUAL"; break;
				case 'E': $periodo = "ESPECIAL"; break;
			}
			$salida.= '<td class = "text-center">'.$periodo.'</td>';
			//desde - hasta
			$desde =  $row["nom_desde"];
			$desde = cambia_fecha($desde);
			$hasta = $row["nom_hasta"];
			$hasta = cambia_fecha($hasta);
			$salida.= '<td class = "text-center">'.$desde.' - '.$hasta.'</td>';
			//correo
			$status = $row["nom_situacion"];
			switch($status){
				case 0: $status = '<label class = "text-danger">DENEGADA</label>'; break;
				case 1: $status = '<label class = "text-info">EDICI&Oacute;N</label>'; break;
				case 2: $status = '<label class = "text-info">SOLICITUD DE APROBACI&Oacute;N</label>'; break;
				case 3: $status = '<label class = "text-success">APROBADA - PENDIENTE DE PAGO</label>'; break;
				case 4: $status = '<label class = "text-success">PAGADA</label>'; break;
			}
			$salida.= '<td class = "text-center">'.$status.'</td>';
			//--
			$salida.= '<td class = "text-center" >';
			$situacion =  $row["nom_situacion"];
			if($situacion == 1){
				$salida.= '<a type="button" class="btn btn-success" href="FRMhoras.php?hashkey='.$hashkey.'" title = "Asignaci&oacute;n de Horas Laboradas y Horas Extras" ><i class="fa fa-plus"></i> <i class="fa fa-clock-o"></i></a> ';
				$salida.= '<a type="button" class="btn btn-primary" href="FRMbonos.php?hashkey='.$hashkey.'" title = "Asignaci&oacute;n de Bonificaciones Regulares, Bonificaciones Emergentes y Comisiones" ><i class="fa fa-plus"></i> <i class="fa fa-dollar"></i></a> ';
				$salida.= '<a type="button" class="btn btn-danger" href="FRMdescuentos.php?hashkey='.$hashkey.'" title = "Asignaci&oacute;n de Descuentos Regulares y Descuentos Emergentes" ><i class="fa fa-minus"></i> <i class="fa fa-dollar"></i></a> ';
			}else{
				$salida.= '<a class="btn btn-success" disabled title = "Asignaci&oacute;n de Horas Laboradas y Horas Extras" ><i class="fa fa-plus"></i> <i class="fa fa-clock-o"></i></a> ';
				$salida.= '<a class="btn btn-primary" disabled title = "Asignaci&oacute;n de Bonificaciones Regulares, Bonificaciones Emergentes y Comisiones" ><i class="fa fa-plus"></i> <i class="fa fa-dollar"></i></a> ';
				$salida.= '<a class="btn btn-danger" disabled title = "Asignaci&oacute;n de Descuentos Regulares y Descuentos Emergentes" ><i class="fa fa-minus"></i> <i class="fa fa-dollar"></i></a> ';
			}
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		
	}
	
	return $salida;
}



function tabla_situacion_nomina($tipo,$clase,$sit){
	$ClsPla = new ClsPlanilla();
	$result = $ClsPla->get_nomina('',$tipo,$clase,'','','',$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "25px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "150px">T&Iacute;TULO</td>';
			$salida.= '<th class = "text-center" width = "100px">PERIODO</td>';
			$salida.= '<th class = "text-center" width = "120px">DESDE - HASTA</td>';
			$salida.= '<th class = "text-center" width = "150px">STATUS</td>';
			$salida.= '<th class = "text-center" width = "200px"><span class="fa fa-tasks"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["nom_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsPla->encrypt($codigo, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-primary" href="FRMnomina.php?hashkey='.$hashkey.'" target = "_blank" title = "Visualizar Detalle de Nomina" ><span class="fa fa-search"></span></a>';
			$salida.= '</td>';
			//titulo
			$titulo = trim(utf8_decode($row["nom_titulo"]));
			$salida.= '<td class = "text-center">'.$titulo.'</td>';
			//periodo
			$periodo = trim(utf8_decode($row["nom_tipo_periodo"]));
			switch($periodo){
				case 'S': $periodo = "SEMANAL"; break;
				case 'Q': $periodo = "QUINCENAL"; break;
				case 'M': $periodo = "MENSUAL"; break;
				case 'E': $periodo = "ESPECIAL"; break;
			}
			$salida.= '<td class = "text-center">'.$periodo.'</td>';
			//desde - hasta
			$desde =  $row["nom_desde"];
			$desde = cambia_fecha($desde);
			$hasta = $row["nom_hasta"];
			$hasta = cambia_fecha($hasta);
			$salida.= '<td class = "text-center">'.$desde.' - '.$hasta.'</td>';
			//correo
			$status = $row["nom_situacion"];
			switch($status){
				case 0: $status = '<label class = "text-danger">DENEGADA</label>'; break;
				case 1: $status = '<label class = "text-info">EDICI&Oacute;N</label>'; break;
				case 2: $status = '<label class = "text-info">SOLICITUD DE APROBACI&Oacute;N</label>'; break;
				case 3: $status = '<label class = "text-success">APROBADA - PENDIENTE DE PAGO</label>'; break;
				case 4: $status = '<label class = "text-success">PAGADA</label>'; break;
			}
			$salida.= '<td class = "text-center">'.$status.'</td>';
			//--
			$salida.= '<td class = "text-center" >';
			$situacion =  $row["nom_situacion"];
			$codigo = $row["nom_codigo"];
			if($situacion == 1){
				$salida.= '<button type="button" class="btn btn-primary" onclick="Situacion_Revision('.$codigo.');" title = "Solicitar Revisi&oacute;n y Aprobaci&oacute;n de Nomina" ><i class="fa fa-magic"></i> Solicitar Aprobaci&oacute;n</button> ';
			}else if($situacion == 2){
				$salida.= '<button type="button" class="btn btn-success" onclick="Situacion_Aprobacion('.$codigo.');" title = "Aprobaci&oacute;n de Nomina" ><i class="fa fa-check"></i> </button> &nbsp; ';
				$salida.= '<button type="button" class="btn btn-warning" onclick="Situacion_Regresar('.$codigo.');" title = "Regresar de Nomina a edici&oacute;n o pedir cambios" ><i class="fa fa-edit"></i> </button> &nbsp; ';
				$salida.= '<button type="button" class="btn btn-danger" onclick="Situacion_Desechar('.$codigo.');" title = "Rechazar Nomina" ><i class="fa fa-trash-o"></i> </button> ';
			}else if($situacion == 3){
				$salida.= '<button type="button" class="btn btn-success" onclick="Situacion_Pagar('.$codigo.');" title = "Cambiar Situaci&oacute;n a Pagada" ><i class="fa fa-money"></i> Pagar</button> ';
			}
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		
	}
	
	return $salida;
}


function tabla_personal_horas($nomina,$tipo){
	$ClsPla = new ClsPlanillaAsignaciones();
	$result = $ClsPla->get_personal_configuracion_horas('',$tipo);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "150px">Colaborador</td>';
		$salida.= '<th class = "text-center" width = "100px">Precio Hora</th>';
		$salida.= '<th class = "text-center" width = "50px">Cantidad Hora</th>';
		$salida.= '<th class = "text-center" width = "50px">Precio Hora/Extras</th>';
		$salida.= '<th class = "text-center" width = "50px">Cant. Horas/Extras</th>';
		$salida.= '<th class = "text-center" width = "50px">Total</th>';
		$salida.= '<th class = "text-center" width = "100px"><i class="fa fa-cogs"></i></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$cui = trim($row["per_dpi"]);
			$result2 = $ClsPla->get_horas_laboradas($nomina,$cui);
			if(is_array($result2)){
				foreach($result2 as $row2){
					$precio_horas = trim($row2["hor_monto_regulares"]);
					$cant_horas = trim($row2["hor_cantidad_regulares"]);
					$precio_extras = trim($row2["hor_monto_extras"]);
					$cant_extras = trim($row2["hor_cantidad_extras"]);
					$bandera = true;
				}	
			}else{
				$precio_horas = trim($row["conf_monto_regulares"]);
				$cant_horas = trim($row["conf_cantidad_regulares"]);
				$precio_extras = trim($row["conf_monto_extras"]);
				$cant_extras = trim($row["conf_cantidad_extras"]);
				$bandera = false;
			}
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//personal
			$personal = trim(utf8_decode($row["per_nombres"])).' '.trim(utf8_decode($row["per_apellidos"]));
			$salida.= '<td class = "text-left">'.$personal.'</td>';
			//--
			$salida.= '<td class = "text-center" >'.number_format($precio_horas,2,'.',',');
			$salida.= '<input type = "hidden" name = "phoras'.$i.'" id = "phoras'.$i.'" value = "'.$precio_horas.'" />';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "text" class="form-inner" name = "horas'.$i.'" id = "horas'.$i.'" value = "'.$cant_horas.'" onkeyup="decimales(this);" onblur = "" />';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-center" >'.number_format($precio_extras,2,'.',',');
			$salida.= '<input type = "hidden" name = "pextras'.$i.'" id = "pextras'.$i.'" value = "'.$precio_extras.'" />';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "text" class="form-inner" name = "extras'.$i.'" id = "extras'.$i.'" value = "'.$cant_extras.'" onkeyup="decimales(this);" onblur = "" />';
			$salida.= '</td>';
			//--
			$cui = trim($row["per_dpi"]);
			$moneda = trim($row["conf_moneda"]);
			$tcambio = trim($row["mon_cambio"]);
			$regulares = ($precio_horas * $cant_horas);
			$extras = ($precio_extras * $cant_extras);
			$total = ($regulares + $extras);
			$total = number_format($total,2,'.',',');
			$simbolo = trim($row["mon_simbolo"]);
			$salida.= '<td class = "text-center" >'.$simbolo.' '.$total;
			$salida.= '<input type = "hidden" name = "personal'.$i.'" id = "personal'.$i.'" value = "'.$cui.'" />';
			$salida.= '<input type = "hidden" name = "moneda'.$i.'" id = "moneda'.$i.'" value = "'.$moneda.'" />';
			$salida.= '<input type = "hidden" name = "tcambio'.$i.'" id = "tcambio'.$i.'" value = "'.$tcambio.'" />';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-center">';
			if($bandera == true){
				$salida.= '<button type="button" onclick="GrabaHorasLaboradas('.$nomina.','.$i.');" title ="Actualizar Horas" class="btn btn-success btn-circle"><i class="fa fa-check"></i></button> ';
				$salida.= '<button type="button" onclick="QuitarHorasLaboradas('.$nomina.','.$i.');" title ="Quitar Horas" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></button>';
			}else{
				$salida.= '<button type="button" onclick="GrabaHorasLaboradas('.$nomina.','.$i.');" title ="Asignar Horas" class="btn btn-default btn-circle"><i class="fa fa-check"></i></button>';
			}
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$i--;
		$salida.= '</table>';
		$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'" />';
		$salida.= '</div>';
	}else{
		
	}
	
	return $salida;
}



function tabla_personal_bonos($nomina,$tipo){
	$ClsPla = new ClsPlanilla();
	$result = $ClsPla->get_personal_tipo_nomina('',$tipo);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "60px">DPI</td>';
			$salida.= '<th class = "text-center" width = "170px">NOMBRES Y APELLIDOS</td>';
			$salida.= '<th class = "text-center" width = "300px"><span class="fa fa-tasks"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//CUI
			$cui = trim(utf8_decode($row["per_dpi"]));
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//personal
			$personal = trim(utf8_decode($row["per_nombres"])).' '.trim(utf8_decode($row["per_apellidos"]));
			$salida.= '<td class = "text-left">'.$personal.'</td>';
			//--
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsPla->encrypt($nomina, $usu);
			$hashkey2 = $ClsPla->encrypt($cui, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-primary" href="ASIGNACIONES/FRMbonos_regulares.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" title = "Bonificaciones Regulares" ><i class="fa fa-dollar"></i> Regulares</a> ';
			$salida.= '<a type="button" class="btn btn-primary" href="ASIGNACIONES/FRMbonos_emergentes.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" title = "Bonificaciones Emergentes" ><i class="fa fa-dollar"></i> Emergentes</a> ';
			$salida.= '<a type="button" class="btn btn-success" href="ASIGNACIONES/FRMcomisiones.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" title = "Comisiones" ><i class="fa fa-dollar"></i> Comisiones</a> ';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		
	}
	
	return $salida;
}



function tabla_personal_descuentos($nomina,$tipo){
	$ClsPla = new ClsPlanilla();
	$result = $ClsPla->get_personal_tipo_nomina('',$tipo);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "60px">DPI</td>';
			$salida.= '<th class = "text-center" width = "170px">NOMBRES Y APELLIDOS</td>';
			$salida.= '<th class = "text-center" width = "300px"><span class="fa fa-tasks"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//CUI
			$cui = trim(utf8_decode($row["per_dpi"]));
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//personal
			$personal = trim(utf8_decode($row["per_nombres"])).' '.trim(utf8_decode($row["per_apellidos"]));
			$salida.= '<td class = "text-left">'.$personal.'</td>';
			//--
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsPla->encrypt($nomina, $usu);
			$hashkey2 = $ClsPla->encrypt($cui, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-warning" href="ASIGNACIONES/FRMdescuentos.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" title = "Descuentos Regulares y Emergentes" ><i class="fa fa-dollar"></i> Regulares y Emergentes</a> ';
			$salida.= '</td>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		
	}
	
	return $salida;
}



function tabla_personal_configuracion($acc){
	$ClsPer = new ClsPersonal();
		$result = $ClsPer->get_personal($dpi,$nom,$ape,$suc,$gene,$nit,'',$pais);
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "15px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px">DPI</th>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRES Y APELLIDOS</th>';
			$salida.= '<th class = "text-center" width = "40px"><span class="fa fa-cogs"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
	if(is_array($result)){
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//DPI
			$dpi = $row["per_dpi"];
			$salida.= '<td class = "text-center">'.$dpi.'</td>';
			//nombre
			$nom = utf8_decode($row["per_nombres"])." ".utf8_decode($row["per_apellidos"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//botones
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsPer->encrypt($dpi, $usu);
		
			$salida.= '<td  class = "text-center">';
			if($acc == 1){
			$salida.= '<a type="button" class="btn btn-info" href="FRMconfiguracion_bonos.php?hashkey='.$hashkey.'" title = "Asignar Bonos Regulares" ><span class="fa fa-money"></span></a> ';
			}else if($acc == 2){
			$salida.= '<a type="button" class="btn btn-warning" href="FRMconfiguracion_descuentos.php?hashkey='.$hashkey.'" title = "Asignar Descuentos Regulares" ><span class="fa fa-money"></span></a> ';
			}else if($acc == 3){
			$salida.= '<a type="button" class="btn btn-default" href="FRMconfiguracion_horas.php?hashkey='.$hashkey.'" title = "Configurar Precios de Horas Regulares y Extras" ><span class="fa fa-clock-o"></span></a> ';
			}
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			//linea divisoria
			$i++;
		}
	}	
			$salida.= '</table>';
			$salida.= '</div>';
	
	return $salida;
}


function tabla_personal_bonos_regurlaes($cui){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_base_bonificaciones($codigo,$cui,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
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
			$codigo = $row["bas_codigo"];
			$dpi = $row["bas_personal"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_Bono_Regular(\''.$codigo.'\',\''.$dpi.'\')" title = "Editar Bonificaci&oacute;n Regular" ><span class="glyphicon glyphicon-pencil"></span></button>  ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Bono(\''.$codigo.'\',\''.$dpi.'\')" title = "inhabilitar Bonificaci&oacute;n Regular" ><span class="glyphicon glyphicon-trash"></span></button>';
			$salida.= '</td>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["bas_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//monto
			$moneda = utf8_decode($row["mon_simbolo"]);
			$monto = utf8_decode($row["bas_monto"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$monto.'</td>';
			//tipo de cambio
			$tcambio = utf8_decode($row["bas_tipo_cambio"]);
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


function tabla_personal_descuentos_regurlaes($cui){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_base_descuentos($codigo,$cui,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
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
			$codigo = $row["bas_codigo"];
			$dpi = $row["bas_personal"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_Descuento_Regular(\''.$codigo.'\',\''.$dpi.'\')" title = "Editar Bonificaci&oacute;n Regular" ><span class="glyphicon glyphicon-pencil"></span></button>  ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Descuento_Regular(\''.$codigo.'\',\''.$dpi.'\')" title = "inhabilitar Bonificaci&oacute;n Regular" ><span class="glyphicon glyphicon-trash"></span></button>';
			$salida.= '</td>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["bas_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//monto
			$moneda = utf8_decode($row["mon_simbolo"]);
			$monto = utf8_decode($row["bas_monto"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$monto.'</td>';
			//tipo de cambio
			$tcambio = utf8_decode($row["bas_tipo_cambio"]);
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


function tabla_detalle_nomina_planilla($tipo,$nomina){
	$ClsPla = new ClsPlanilla();
	$result = $ClsPla->get_personal_pre_planilla($tipo,$nomina);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "30px">DPI</td>';
			$salida.= '<th class = "text-center" width = "30px">No. IGSS</td>';
			$salida.= '<th class = "text-center" width = "170px">NOMBRES Y APELLIDOS</td>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-clock-o" title="Horas Laboradas"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-clock-o" title="Horas Extras"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-money" title="Monto por Horas Laboradas"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-money" title="Monto por Horas Extras"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-money" title="Bonificaciones (Bonificaciones Regulares + Bonificaciones Emergentes)"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-money" title="Comisiones"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-dollar" title="Descuentos (Descuentos Regulares + Descuentos Emergentes)"></i></th>';
			$salida.= '<th class = "text-center" width = "20px">IGSS <i class="fa fa-info-circle" title="IGSS (4.83%) Cuota Trabajadores"></i></th>';
			$salida.= '<th class = "text-center" width = "20px">ISR <i class="fa fa-info-circle" title="ISR (5% sobre los primeros Q.30,000.00 mensuales y 7% sobre el resto) Retenci&oacute;n de ISR para Trabajadores en relaci&oacute;n de dependencia"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-plus"></i> <i class="fa fa-money" title="Total de Asignaciones"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-minus"></i> <i class="fa fa-money" title="Total de Descuentos"></i></th>';
			$salida.= '<th class = "text-center" width = "20px">L&Iacute;QUIDO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$asignaciones = 0;
			$descuentos = 0;
			//--
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//CUI
			$cui = trim(utf8_decode($row["per_dpi"]));
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//No. IGSS
			$nigss = trim(utf8_decode($row["per_igss"]));
			$nigss = ($nigss != "")?$nigss:"-";
			$salida.= '<td class = "text-center">'.$nigss.'</td>';
			//personal
			$personal = trim(utf8_decode($row["per_nombres"])).' '.trim(utf8_decode($row["per_apellidos"]));
			$salida.= '<td class = "text-left">'.$personal.'</td>';
			//Horas Laboradas
			$hlab = trim($row["cantidad_horas_laboradas"]);
			$hlab = ($hlab != "")?$hlab:0;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_horas_laboradas(\''.$nomina.'\',\''.$cui.'\');" >'.$hlab.' hrs.</a></td>';
			//Horas extras
			$hext = trim($row["cantidad_horas_extras"]);
			$hext = ($hext != "")?$hext:0;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_horas_extras(\''.$nomina.'\',\''.$cui.'\');" >'.$hext.' hrs.</a></td>';
			//Monto Horas Laboradas
			$mlab = trim($row["montol_horas_laboradas"]);
			$mlab = round($mlab,2);
			$asignaciones+= $mlab;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_monto_horas_laboradas(\''.$nomina.'\',\''.$cui.'\');" >Q.'.$mlab.'</a></td>';
			//Monto Horas extras
			$mext = trim($row["montol_horas_extras"]);
			$mext = round($mext,2);
			$asignaciones+= $mext;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_monto_horas_extras(\''.$nomina.'\',\''.$cui.'\');" >Q.'.$mext.'</a></td>';
			//Bonificaciones Generales y Emergentes
			$bong = trim($row["bonificaciones_generales"]);
			$bone = trim($row["bonificaciones_emergentes"]);
			$bon = round(($bong+$bone),2);
			$asignaciones+= $bon;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_bonificaciones(\''.$nomina.'\',\''.$cui.'\');" >Q.'.$bon.'</a></td>';
			//Comisiones
			$com = trim($row["comisiones"]);
			$com = round($com,2);
			$asignaciones+= $com;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_comisiones(\''.$nomina.'\',\''.$cui.'\');" >Q.'.$com.'</a></td>';
			//Descuentos
			$des = trim($row["descuentos"]);
			$des = round($des,2);
			$descuentos+= $des;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_descuentos(\''.$nomina.'\',\''.$cui.'\');" >Q.'.$des.'</a></td>';
			//IGSS
			$igss = round((($asignaciones*4.83)/100),2);
			$salida.= '<td class = "text-center" >Q.'.$igss.'</td>';
			//ISR
			$isr = 0;
			$salida.= '<td class = "text-center" >Q.'.$isr.'</td>';
			//Total de Asignaciones
			$asignaciones = round($asignaciones,2);
			$salida.= '<td class = "text-center" >Q.'.$asignaciones.'</td>';
			//Total de Descuentos
			$descuentos = round($descuentos,2);
			$salida.= '<td class = "text-center" >Q.'.$descuentos.'</td>';
			//Sueldo Liquido
			$liquido = round((($asignaciones-$descuentos)-$igss),2);
			$salida.= '<td class = "text-center" >Q.'.$liquido.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		
	}
	
	return $salida;
}




function tabla_detalle_nomina_factura($tipo,$nomina){
	$ClsPla = new ClsPlanilla();
	$result = $ClsPla->get_personal_pre_planilla($tipo,$nomina);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "30px">DPI</td>';
			$salida.= '<th class = "text-center" width = "170px">NOMBRES Y APELLIDOS</td>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-clock-o" title="Horas Laboradas"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-clock-o" title="Horas Extras"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-money" title="Monto por Horas Laboradas"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-money" title="Monto por Horas Extras"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-money" title="Bonificaci&oacute;n por Horas Laboradas"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-money" title="Bonificaci&oacute;n por Horas Extras"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-money" title="Bonificaciones (Bonificaciones Regulares + Bonificaciones Emergentes)"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-money" title="Comisiones"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-dollar" title="Descuentos (Descuentos Regulares + Descuentos Emergentes)"></i></th>';
			$salida.= '<th class = "text-center" width = "20px">IVA <i class="fa fa-info-circle" title="IVA (15% sobre el IVA (0.12) para regimen general abreviado - Servicios Profesionales - 0% sobre regimen de peque&ntilde;o contribuyente) Retenci&oacute;n de IVA"></i></th>';
			$salida.= '<th class = "text-center" width = "20px">ISR <i class="fa fa-info-circle" title="ISR (5% sobre los primeros Q.300,000.00 y 7% sobre el resto) Retenci&oacute;n de ISR para Trabajadores en relaci&oacute;n de dependencia"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-plus"></i> <i class="fa fa-money" title="Total de Asignaciones"></i></th>';
			$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-minus"></i> <i class="fa fa-money" title="Total de Descuentos"></i></th>';
			$salida.= '<th class = "text-center" width = "20px">L&Iacute;QUIDO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//CUI
			$cui = trim(utf8_decode($row["per_dpi"]));
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//personal
			$personal = trim(utf8_decode($row["per_nombres"])).' '.trim(utf8_decode($row["per_apellidos"]));
			$salida.= '<td class = "text-left">'.$personal.'</td>';
			//Horas Laboradas
			$hlab = trim($row["cantidad_horas_laboradas"]);
			$hlab = ($hlab != "")?$hlab:0;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_horas_laboradas(\''.$nomina.'\',\''.$cui.'\');" >'.$hlab.' hrs.</a></td>';
			//Horas extras
			$hext = trim($row["cantidad_horas_extras"]);
			$hext = ($hext != "")?$hext:0;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_horas_extras(\''.$nomina.'\',\''.$cui.'\');" >'.$hext.' hrs.</a></td>';
			//Monto Horas Laboradas
			$mlab = trim($row["montol_horas_laboradas"]);
			$mlab = round($mlab,2);
			$asignaciones+= $mlab;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_monto_horas_laboradas(\''.$nomina.'\',\''.$cui.'\');" >Q.'.$mlab.'</a></td>';
			//Monto Horas extras
			$mext = trim($row["montol_horas_extras"]);
			$mext = round($mext,2);
			$asignaciones+= $mext;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_monto_horas_extras(\''.$nomina.'\',\''.$cui.'\');" >Q.'.$mext.'</a></td>';
			//Bonificaciones Horas Laboradas
			$blab = trim($row["bonificacion_horas_laboradas"]);
			$blab = round($blab,2);
			$asignaciones+= $blab;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_bonificacion_horas_laboradas(\''.$nomina.'\',\''.$cui.'\');" >Q.'.$blab.'</a></td>';
			//Bonificaciones Horas extras
			$bext = trim($row["bonificacion_horas_extras"]);
			$bext = round($bext,2);
			$asignaciones+= $bext;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_bonificacion_horas_extras(\''.$nomina.'\',\''.$cui.'\');" >Q.'.$bext.'</a></td>';
			//Bonificaciones Generales y Emergentes
			$bong = trim($row["bonificaciones_generales"]);
			$bone = trim($row["bonificaciones_emergentes"]);
			$bon = round(($bong+$bone),2);
			$asignaciones+= $bon;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_bonificaciones(\''.$nomina.'\',\''.$cui.'\');" >Q.'.$bon.'</a></td>';
			//Comisiones
			$com = trim($row["comisiones"]);
			$com = round($com,2);
			$asignaciones+= $com;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_comisiones(\''.$nomina.'\',\''.$cui.'\');" >Q.'.$com.'</a></td>';
			//Descuentos
			$des = trim($row["descuentos"]);
			$des = round($des,2);
			$descuentos+= $des;
			$salida.= '<td class = "text-center"><a href = "javascript:void(0)" onclick = "ver_descuentos(\''.$nomina.'\',\''.$cui.'\');" >Q.'.$des.'</a></td>';
			//IVA
			$iva = 0;
			$salida.= '<td class = "text-center" >Q.'.$iva.'</td>';
			//ISR
			$isr = 0;
			$salida.= '<td class = "text-center" >Q.'.$isr.'</td>';
			//Total de Asignaciones
			$asignaciones = round($asignaciones,2);
			$salida.= '<td class = "text-center" >Q.'.$asignaciones.'</td>';
			//Total de Descuentos
			$descuentos = round($descuentos,2);
			$salida.= '<td class = "text-center" >Q.'.$descuentos.'</td>';
			//Sueldo Liquido
			$liquido = round((($asignaciones-$descuentos)-$igss),2);
			$salida.= '<td class = "text-center" >Q.'.$liquido.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		
	}
	
	return $salida;
}



?>