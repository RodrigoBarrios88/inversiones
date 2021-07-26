<?php 
include_once('../../html_fns.php');


function tabla_correcciones(){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_status_correccion();
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="table-responsive">';
		$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px">No.</th>';
		$salida.= '<th class = "text-center" width = "100px">PRE-CONTRATO</td>';
		$salida.= '<th class = "text-center" width = "100px">CUI</td>';
		$salida.= '<th class = "text-center" width = "200px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "150px">GRADO</td>';
		$salida.= '<th class = "text-center" width = "200px">RESPONSABLE EN EL CONTRATO</td>';
		$salida.= '<th class = "text-center" width = "200px">&Uacute;LTIMO COMENTARIO</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$contrato = $row["stat_contrato"];
			$cui = $row["alu_cui_new"];
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//pre-contato
			$contrato = $row["stat_contrato"];
			$salida.= '<td class = "text-center">'.$contrato.'</td>';
			//cui
			$cui = $row["alu_cui_new"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//grado
			$grado = $row["gra_descripcion"];
			$salida.= '<td class = "text-left">'.$grado.'</td>';
			//responsable
			$nom = utf8_decode($row["stat_nombre"]);
			$ape = utf8_decode($row["stat_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//comentario
			$coment = utf8_decode($row["comen_ultimo_comentario"]);
			$salida.= '<td class = "text-justify">'.$coment.'</td>';
			//-
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_datos_actualizados(){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_status_grado_alumno(2);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="table-responsive">';
		$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px">No.</th>';
		$salida.= '<th class = "text-center" width = "100px">PRE-CONTRATO</td>';
		$salida.= '<th class = "text-center" width = "100px">CUI</td>';
		$salida.= '<th class = "text-center" width = "200px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "200px">RESPONSABLE EN EL CONTRATO</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$contrato = $row["stat_contrato"];
			$cui = $row["alu_cui_new"];
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//pre-contato
			$contrato = $row["stat_contrato"];
			$salida.= '<td class = "text-center">'.$contrato.'</td>';
			//cui
			$cui = $row["alu_cui_new"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//responsable
			$nom = utf8_decode($row["stat_nombre"]);
			$ape = utf8_decode($row["stat_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//-
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_boletas_giradas(){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_status_grado_alumno(3);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="table-responsive">';
		$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px">No.</th>';
		$salida.= '<th class = "text-center" width = "100px">PRE-CONTRATO</td>';
		$salida.= '<th class = "text-center" width = "100px">CUI</td>';
		$salida.= '<th class = "text-center" width = "200px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "70px">BOLETA No.</td>';
		$salida.= '<th class = "text-center" width = "70px">REFERENCIA No.</td>';
		$salida.= '<th class = "text-center" width = "50px">MONTO</td>';
		$salida.= '<th class = "text-center" width = "150px">SITUACI&Oacute;N DE BOLETA</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		$cargos = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$contrato = $row["stat_contrato"];
			$cui = $row["alu_cui_new"];
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//pre-contato
			$contrato = $row["stat_contrato"];
			$salida.= '<td class = "text-center">'.$contrato.'</td>';
			//cui
			$cui = $row["alu_cui_new"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//boleta
			$boleta = $row["alu_boleta_inscripcion"];
			$salida.= '<td class = "text-center"># '.$boleta.'</td>';
			//referencia
			$referencia = $row["alu_numero_boleta_inscripcion"];
			$salida.= '<td class = "text-center"># '.$referencia.'</td>';
			//ingresos
			$ingreso = trim($row["alu_monto_boleta_inscripcion"]);
			//descuentos
			$descuento = trim($row["alu_descuento_boleta_inscripcion"]);
			$cargo = $ingreso + $descuento;
			$cargos+= $cargo;
			$cargo = number_format($cargo,2,'.','');
			$salida.= '<td class = "text-center">Q. '.$cargo.'</td>';
			//situacion
			$situacion = $row["alu_boleta_situacion"];
			if($situacion == ""){
				$situacion = '<label class = "text-muted">- no ha generado boleta -</label>';
				$disabled = "disabled";
			}else if($situacion == 0){
				$situacion = '<label class = "text-danger">ANULADA</label>';
				$disabled = "disabled";
			}else{
				$pagado = $row["alu_boleta_pagado"];
				switch($pagado){
					case 0: $situacion = '<label class = "text-info">PENDIENTE DE PAGO</label>'; $disabled = ""; break;
					case 1: $situacion = '<label class = "text-success">PAGADA</label>'; $disabled = ""; break;
				}
			}
			$salida.= '<td class = "text-center">'.$situacion.'</td>';
			//-
			$salida.= '</tr>';
			$i++;
		}
		//---
		$cargos = number_format($cargos,2,'.',',');
		$salida.= '<tr>';
		$salida.= '<td class = "text-center">'.$i.'.</td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<th class = "text-center">Q. '.$cargos.'</td>';
		$salida.= '<td></td>';
		$salida.= '</tr>';
		//--
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_boletas_recibidas(){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_status_grado_alumno(4);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="table-responsive">';
		$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px">No.</th>';
		$salida.= '<th class = "text-center" width = "100px">PRE-CONTRATO</td>';
		$salida.= '<th class = "text-center" width = "100px">CUI</td>';
		$salida.= '<th class = "text-center" width = "200px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "70px">BOLETA No.</td>';
		$salida.= '<th class = "text-center" width = "70px">REFERENCIA No.</td>';
		$salida.= '<th class = "text-center" width = "150px">SITUACI&Oacute;N DE BOLETA</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$contrato = $row["stat_contrato"];
			$cui = $row["alu_cui_new"];
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//pre-contato
			$contrato = $row["stat_contrato"];
			$salida.= '<td class = "text-center">'.$contrato.'</td>';
			//cui
			$cui = $row["alu_cui_new"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//boleta
			$boleta = $row["alu_boleta_inscripcion"];
			$salida.= '<td class = "text-center"># '.$boleta.'</td>';
			//referencia
			$referencia = $row["alu_numero_boleta_inscripcion"];
			$salida.= '<td class = "text-center"># '.$referencia.'</td>';
			//situacion
			$situacion = $row["alu_boleta_situacion"];
			if($situacion == ""){
				$situacion = '<label class = "text-muted">- no ha generado boleta -</label>';
				$disabled = "disabled";
			}else if($situacion == 0){
				$situacion = '<label class = "text-danger">ANULADA</label>';
				$disabled = "disabled";
			}else{
				$pagado = $row["alu_boleta_pagado"];
				switch($pagado){
					case 0: $situacion = '<label class = "text-info">PENDIENTE DE PAGO</label>'; $disabled = ""; break;
					case 1: $situacion = '<label class = "text-success">PAGADA</label>'; $disabled = ""; break;
				}
			}
			$salida.= '<td class = "text-center">'.$situacion.'</td>';
			//-
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_contratos_aprobados(){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_status_grado_alumno(5);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="table-responsive">';
		$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px">No.</th>';
		$salida.= '<th class = "text-center" width = "100px">No. CONTRATO</td>';
		$salida.= '<th class = "text-center" width = "100px">CUI</td>';
		$salida.= '<th class = "text-center" width = "200px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "200px">RESPONSABLE EN EL CONTRATO</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$contrato = $row["stat_contrato"];
			$cui = $row["alu_cui_new"];
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//pre-contato
			$contrato = $row["stat_contrato"];
			$salida.= '<td class = "text-center">'.$contrato.'</td>';
			//cui
			$cui = $row["alu_cui_new"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//responsable
			$nom = utf8_decode($row["stat_nombre"]);
			$ape = utf8_decode($row["stat_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//-
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_contratos($nivel,$grado,$situacion){
	$ClsIns = new ClsInscripcion();
	
	$situacion = ($situacion == "")?"2,3,4,5,6":$situacion; // valida todas las situaciones validas para el listado
	$result = $ClsIns->get_status_grado_alumno($situacion,$nivel,$grado);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="table-responsive">';
		$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px">CONTRATO</td>';
		$salida.= '<th class = "text-center" width = "50px">CUI</td>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "150px">GRADO</td>';
		$salida.= '<th class = "text-center" width = "70px">BOLETA No.</td>';
		$salida.= '<th class = "text-center" width = "70px">REFERENCIA No.</td>';
		$salida.= '<th class = "text-center" width = "50px">DPI</td>';
		$salida.= '<th class = "text-center" width = "150px">FIRMANTE</td>';
		$salida.= '<th class = "text-center" width = "100px">FECHA DE CONTRATO</td>';
		$salida.= '<th class = "text-center" width = "100px">SITUACI&Oacute;N</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//pre-contato
			$contrato = $row["stat_contrato"];
			$salida.= '<td class = "text-center"><label class = "text-danger">'.$contrato.'</label></td>';
			//cui
			$cui = $row["alu_cui_new"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//grado
			$grado = $row["gra_descripcion"];
			$salida.= '<td class = "text-left">'.$grado.'</td>';
			//boleta
			$boleta = $row["alu_boleta_inscripcion"];
			$salida.= '<td class = "text-center"># '.$boleta.'</td>';
			//referencia
			$referencia = $row["alu_numero_boleta_inscripcion"];
			$salida.= '<td class = "text-center"># '.$referencia.'</td>';
			//dpi
			$dpi = trim($row["stat_dpi_firmante"]);
			$salida.= '<td class = "text-center">'.$dpi.'</td>';
			//firmante
			$nom = utf8_decode($row["stat_nombre"]);
			$ape = utf8_decode($row["stat_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//fecha
			$fecha = $row["stat_fechor_registro"];
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//situacion
			$sit = trim($row["stat_situacion"]);
			$salida.= '<td class = "text-left" >';
			if($sit == 2){
				$salida.= ' &nbsp; <i class = "fa fa-check-circle-o text-success"></i> <label class = "text-success"> Info. Actualizada</label>';
			}else if($sit == 3){
				$salida.= ' &nbsp; <i class = "fa fa-print text-muted"></i> <label class = "text-muted">Boleta Girada</label>';
			}else if($sit == 4){
				$salida.= ' &nbsp; <i class = "fa fa-send-o text-info"></i> <label class = "text-info">Solicitud Enviada</label>';
			}else if($sit == 5){
				$salida.= ' &nbsp; <i class = "fa fa-check text-success"></i> <label class = "text-success">Solicitud Aprobada</label>';
			}else if($sit == 6){
				$salida.= ' &nbsp; <i class = "fa fa-inbox text-success"></i> <label class = "text-success">Entregado</label>';
			}
			$salida.= '</td>';
			//--
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




function tabla_ingresos($periodo,$desde,$hasta){
	$ClsIns = new ClsInscripcion();
	$cuenta = $ClsIns->cuenta;
	$banco = $ClsIns->banco;
	$result = $ClsIns->get_boleta_cobro('','','','','',$periodo,'',$desde,$hasta,1,2,1); //Situacion activa (1), orderby 2 (fecha de pago), Pagado (1)
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="table-responsive">';
		$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px">CUI</td>';
		$salida.= '<th class = "text-center" width = "170px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "150px">GRADO</td>';
		$salida.= '<th class = "text-center" width = "70px">BOLETA No.</td>';
		$salida.= '<th class = "text-center" width = "70px">REFERENCIA No.</td>';
		$salida.= '<th class = "text-center" width = "150px">CONCEPTO</td>';
		$salida.= '<th class = "text-center" width = "70px">FECHA</td>';
		$salida.= '<th class = "text-center" width = "30px">CARGOS</td>';
		$salida.= '<th class = "text-center" width = "30px">DESCUENTO</td>';
		$salida.= '<th class = "text-center" width = "30px">INGRESO</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		$cargos = 0;
		$ingresos = 0;
		$descuentos = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//cui
			$cui = $row["alu_cui_new"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//grado
			$grado = utf8_decode($row["alu_grado_descripcion"]);
			$salida.= '<td class = "text-left">'.$grado.'</td>';
			//boleta
			$boleta = $row["bol_codigo"];
			$salida.= '<td class = "text-center"># '.$boleta.'</td>';
			//referenica
			$referencia = $row["bol_referencia"];
			$salida.= '<td class = "text-center"># '.$referencia.'</td>';
			//concepto
			$descuento = trim($row["bol_descuento"]);
			$concepto = utf8_decode($row["bol_motivo"]);
			/*if($descuento > 0){ //valida si hay descuento de re-inscripción
				$concepto = str_replace("INSCRIPCION","RE-INSCRIPCION",$concepto);
			}*/
			$salida.= '<td class = "text-left">'.$concepto.'</td>';
			//fecha
			$fecha = $row["bol_fecha_registro"];
			$fecha = cambia_fechaHora($fecha);
			$fecha = substr($fecha,0,10);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//cargos
			$ingreso = trim($row["bol_monto"]);
			$ingresos+= $ingreso;
			$descuento = trim($row["bol_descuento"]);
			$descuentos+= $descuento;
			$cargo = $ingreso + $descuento;
			$cargos+= $cargo;
			$cargo = number_format($cargo,2,'.','');
			$salida.= '<td class = "text-center">Q. '.$cargo.'</td>';
			//descuentos
			$descuento = number_format($descuento,2,'.','');
			$salida.= '<td class = "text-center">Q. '.$descuento.'</td>';
			//ingresos
			$ingreso = number_format($ingreso,2,'.','');
			$salida.= '<td class = "text-center text-info"><b>Q. '.$ingreso.'<b></td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		//---
		$cargos = number_format($cargos,2,'.',',');
		$descuentos = number_format($descuentos,2,'.',',');
		$ingresos = number_format($ingresos,2,'.',',');
		$salida.= '<tr>';
		$salida.= '<td class = "text-center">'.$i.'.</td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<th class = "text-center">Q. '.$cargos.'</td>';
		$salida.= '<th class = "text-center">Q. '.$descuentos.'</td>';
		$salida.= '<th class = "text-center text-info">Q. '.$ingresos.'</td>';
		$salida.= '</tr>';
		//--
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_cargos($periodo,$desde,$hasta,$sit,$pag =''){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_boleta_cobro('','','','','',$periodo,'',$fini,$ffin,$sit,2,$pag);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="table-responsive">';
		$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px">CUI</td>';
		$salida.= '<th class = "text-center" width = "170px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "150px">GRADO</td>';
		$salida.= '<th class = "text-center" width = "70px">BOLETA</td>';
		$salida.= '<th class = "text-center" width = "70px">REFERENCIA</td>';
		$salida.= '<th class = "text-center" width = "150px">CONCEPTO</td>';
		$salida.= '<th class = "text-center" width = "70px">FECHA</td>';
		$salida.= '<th class = "text-center" width = "50px">CARGOS</td>';
		$salida.= '<th class = "text-center" width = "50px">ABONO</td>';
		$salida.= '<th class = "text-center" width = "50px">DESCUENTO</td>';
		$salida.= '<th class = "text-center" width = "50px">SALDO</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		$cargos = 0;
		$abonos = 0;
		$descuentos = 0;
		$saldos = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//cui
			$cui = $row["alu_cui_new"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//grado
			$grado = utf8_decode($row["alu_grado_descripcion"]);
			$salida.= '<td class = "text-left">'.$grado.'</td>';
			//boleta
			$boleta = $row["bol_codigo"];
			$salida.= '<td class = "text-center"># '.$boleta.'</td>';
			//referenica
			$referencia = $row["bol_referencia"];
			$salida.= '<td class = "text-center"># '.$referencia.'</td>';
			//concepto
			$descuento = trim($row["bol_descuento"]);
			$concepto = utf8_decode($row["bol_motivo"]);
			/*if($descuento > 0){ //valida si hay descuento de re-inscripción
				$concepto = str_replace("INSCRIPCION","RE-INSCRIPCION",$concepto);
			}*/
			$salida.= '<td class = "text-left">'.$concepto.'</td>';
			//fecha
			$fecha = $row["bol_fecha_registro"];
			$fecha = cambia_fechaHora($fecha);
			$fecha = substr($fecha,0,10);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//situacion
			$sit = trim($row["bol_situacion"]);
			//ingresos
			$ingreso = trim($row["bol_monto"]);
			//descuentos
			$descuento = trim($row["bol_descuento"]);
			$descuentos+= $descuento;
			//cargo
			$cargo = $ingreso + $descuento;
			$cargos+= $cargo;
			$cargo = number_format($cargo,2,'.','');
			$descuento = number_format($descuento,2,'.','');
			//abono
			$abono = ($sit == 2)?$ingreso:0; // si la boleta ya esta pagada si hay abono, de lo contrario no el abono es 0
			$abonos+= $abono;
			$abono = number_format($abono,2,'.','');
			//saldo
			$saldo = ($sit == 1)?$ingreso:0; // si la boleta esta pendiente de pago hay saldo, de lo contrario no el saldo es 0
			$saldos+= $saldo;
			$saldo = number_format($saldo,2,'.','');
			//--
			$salida.= '<td class = "text-center">Q. '.$cargo.'</td>';
			$salida.= '<td class = "text-center">Q. '.$abono.'</td>';
			$salida.= '<td class = "text-center">Q. '.$descuento.'</td>';
			$salida.= '<td class = "text-center">Q. '.$saldo.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		//---
		$cargos = number_format($cargos,2,'.',',');
		$descuentos = number_format($descuentos,2,'.',',');
		$abonos = number_format($abonos,2,'.',',');
		$saldos = number_format($saldos,2,'.',',');
		$salida.= '<tr>';
		$salida.= '<td class = "text-center">'.$i.'.</td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<th class = "text-center">Q. '.$cargos.'</td>';
		$salida.= '<th class = "text-center">Q. '.$abonos.'</td>';
		$salida.= '<th class = "text-center">Q. '.$descuentos.'</td>';
		$salida.= '<th class = "text-center">Q. '.$saldos.'</td>';
		$salida.= '</tr>';
		//--
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}




function tabla_descuentos($periodo,$desde,$hasta,$sit,$pag){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_boleta_cobro('','','','','',$periodo,'',$fini,$ffin,$sit,2,$pag);//orderby 2 (fecha de pago)
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="table-responsive">';
		$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px">CUI</td>';
		$salida.= '<th class = "text-center" width = "170px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "150px">GRADO</td>';
		$salida.= '<th class = "text-center" width = "70px">BOLETA</td>';
		$salida.= '<th class = "text-center" width = "70px">REFERENCIA</td>';
		$salida.= '<th class = "text-center" width = "150px">CONCEPTO DE BOLETA</td>';
		$salida.= '<th class = "text-center" width = "150px">MOTIVO DEL DESCUENTO</td>';
		$salida.= '<th class = "text-center" width = "70px">FECHA</td>';
		$salida.= '<th class = "text-center" width = "30px">DESCUENTO</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		$descuentos = 0;
		foreach($result as $row){
			$descuento = trim($row["bol_descuento"]);
			if($descuento > 0){ // si hay descuento
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center">'.$i.'.</td>';
				//cui
				$cui = $row["alu_cui_new"];
				$salida.= '<td class = "text-center">'.$cui.'</td>';
				//nombre
				$nom = utf8_decode($row["alu_nombre"]);
				$ape = utf8_decode($row["alu_apellido"]);
				$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
				//grado
				$grado = utf8_decode($row["alu_grado_descripcion"]);
				$salida.= '<td class = "text-left">'.$grado.'</td>';
				//boleta
				$boleta = $row["bol_codigo"];
				$salida.= '<td class = "text-center"># '.$boleta.'</td>';
				//referenica
				$referencia = $row["bol_referencia"];
				$salida.= '<td class = "text-center"># '.$referencia.'</td>';
				//concepto
				$descuento = trim($row["bol_descuento"]);
				$concepto = utf8_decode($row["bol_motivo"]);
				/*if($descuento > 0){ //valida si hay descuento de re-inscripción
					$concepto = str_replace("INSCRIPCION","RE-INSCRIPCION",$concepto);
				}*/
				$salida.= '<td class = "text-left">'.$concepto.'</td>';
				//motivo de descuento
				$motivo = utf8_decode($row["bol_motivo_descuento"]);
				$salida.= '<td class = "text-left">'.$motivo.'</td>';
				//fecha
				$fecha = $row["bol_fecha_registro"];
				$fecha = cambia_fechaHora($fecha);
				$fecha = substr($fecha,0,10);
				$salida.= '<td class = "text-center">'.$fecha.'</td>';
				//descuentos
				$descuento = trim($row["bol_descuento"]);
				$descuentos+= $descuento;
				$descuento = number_format($descuento,2,'.','');
				$salida.= '<td class = "text-center">Q. '.$descuento.'</td>';
				//--
				$salida.= '</tr>';
				$i++;
			}
		}
		//---
		$descuentos = number_format($descuentos,2,'.',',');
		$salida.= '<tr>';
		$salida.= '<td class = "text-center">'.$i.'.</td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<td></td>';
		$salida.= '<th class = "text-center">Q. '.$descuentos.'</td>';
		$salida.= '</tr>';
		//--
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}




function Montos_Contratos($nivel){
	
	switch($nivel){
		case 1:
			$Montos = array(
				"INSCRIPCION" => "400",
				"COLEGIATURA" => "460",
				"COMPLEMENTARIO" => "375"
			); break;
		case 2:
			$Montos = array(
				"INSCRIPCION" => "500",
				"COLEGIATURA" => "635",
				"COMPLEMENTARIO" => "450"
			); break;
		case 3:
			$Montos = array(
				"INSCRIPCION" => "575",
				"COLEGIATURA" => "800",
				"COMPLEMENTARIO" => "500"
			); break;
		case 4:
			$Montos = array(
				"INSCRIPCION" => "575",
				"COLEGIATURA" => "825",
				"COMPLEMENTARIO" => "500"
			); break;
	}
	
	return $Montos;
}




function Montos_Libros($nivel,$grado){
	///////////////// NOTA ////////////////
	// Las cantidades deben de estar entre "" para que se interpreten como string a la hora de partir enteros y decimales ///
	// esto ayuda a leer los decimales exactos y no simplificados al convertir en letras. Ejemplo ".80" se leera OCHENTA y no OCHO //
	
	if($nivel == 1){
		switch($grado){
			case 1:
				$Montos = array(
					1 => "0"
				); break;
			case 2:
				$Montos = array(
					1 => "820"
				); break;
			case 3:
				$Montos = array(
					1 => "820"
				); break;
			case 4:
				$Montos = array(
					1 => "780"
				); break;
		}
	}else if($nivel == 2){
		switch($grado){
			case 1:
				$Montos = array(
					1 => "286.66",
					2 => "286.66",
					3 => "286.66"
				); break;
			case 2:
				$Montos = array(
					1 => "286.66",
					2 => "286.66",
					3 => "286.66"
				); break;
			case 3:
				$Montos = array(
					1 => "286.66",
					2 => "286.66",
					3 => "286.66"
				); break;
			case 4:
				$Montos = array(
					1 => "286.66",
					2 => "286.66",
					3 => "286.66"
				); break;
			case 5:
				$Montos = array(
					1 => "286.66",
					2 => "286.66",
					3 => "286.66"
				); break;
			case 6:
				$Montos = array(
					1 => "253.33",
					2 => "253.33",
					3 => "253.33"
				); break;
		}
	}else if($nivel == 3){
		switch($grado){
			case 1:
				$Montos = array(
					1 => "203.33",
					2 => "203.33",
					3 => "203.33"
				); break;
			case 2:
				$Montos = array(
					1 => "203.33",
					2 => "203.33",
					3 => "203.33"
				); break;
			case 3:
				$Montos = array(
					1 => "203.33",
					2 => "203.33",
					3 => "203.33"
				); break;
		}
	}else if($nivel == 4){
		switch($grado){
			case 1:
				$Montos = array(
					1 => "203.33",
					2 => "203.33",
					3 => "203.33"
				); break;
			case 2:
				$Montos = array(
					1 => "203.33",
					2 => "203.33",
					3 => "203.33"
				); break;
		}
	}
	
	return $Montos;
}




?>
