<?php 
include_once('../html_fns.php');


function tabla_hijos_boleta($padre){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_alumno_padre($padre,"");
	
	if(is_array($result)){
			$salida.= '<div id="pad-wrapper" class="datatables-page">';
            $salida.= '<table class="table" id="tabla">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "100px">PRE-CONTRATO</th>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE Y APELLIDO</th>';
			$salida.= '<th class = "text-center" width = "70px">BOLETA No.</th>';
			$salida.= '<th class = "text-center" width = "50px"><i class = "fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "150px">SITUACI&Oacute;N DE BOLETA</th>';
			$salida.= '<th class = "text-center" width = "50px">STATUS (Contrato)</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//--
			$cui = $row["alu_cui_new"];
			//pre-contato
			$contrato = $row["alu_contrato"];
			$salida.= '<td class = "text-center">'.$contrato.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape;
			$salida.= '<input type = "hidden" id = "cui'.$i.'" value = "'.$cui.'" />';
			$salida.= '<input type = "hidden" id = "nombre'.$i.'" value = "'.$nom.'" />';
			$salida.= '<input type = "hidden" id = "apellido'.$i.'" value = "'.$ape.'" />';
			$salida.= '</td>';
			//--
			$referencia = $row["alu_numero_boleta_inscripcion"];
			$referencia = ($referencia == "")?"-":$referencia;
			$salida.= '<td class = "text-center">'.$referencia.'</td>';
			//--
			$sit = trim($row["alu_contrato_situacion"]);
			$bolcod = $row["alu_boleta_inscripcion"];
			$sit_boleta = ($bolcod != "")?1:0;
			$cuenta = $ClsIns->cuenta;
			$banco = $ClsIns->banco;
			//--
			$salida.= '<td class = "text-center" >';
			$cui = $row["alu_cui_new"];
			$bolcod = $row["alu_boleta_inscripcion"];
			if($sit == 2 && $bolcod == ""){
			$salida.= '<button type="button" class="btn btn-primary btn-block" onclick = "generarBoleta('.$i.');" title = "Generar Boleta de Inscripci&oacute;n" ><span class="fa fa-print"></span></button>';
			}else if($sit == 2 && $bolcod != ""){
			$salida.= '<button type="button" class="btn btn-success btn-block" onclick = "#" title = "Saltar al siguiente Paso" disabled ><span class="fas fa-check-circle"></span></button>';
			}else if($sit == 3){
			$salida.= '<a class="btn btn-default btn-block" href = "../../CONFIG/INSCRIPCIONES/REPboleta.php?boleta='.$bolcod.'" target = "_blank" title = "Reimprimir Boleta y Formulario de Informaci&oacute;n" ><span class="fa fa-print"></span></a>';
			}else{
				if($sit == 1){
					$salida.= '<a class = "btn btn-outline btn-warning" href = "FRMpaso1.php" ><i class = "fa fa-warning"></i> Actualizar</a>';
				}else{
					$salida.= '---';
				}
			}
			$salida.= '</td>';
			//--
			$sit_boleta = $row["alu_boleta_situacion"];
			$sit_boleta = ($sit_boleta != "")?$sit_boleta:"-1";
			//situacion de boleta
			switch($sit_boleta){
				case 2: $situacion = '<label class = "text-danger">ANULADA</label>'; $disabled = "disabled"; break;
				case 0: $situacion = '<label class = "text-info">IMPRESA (EN TR&Aacute;MITE)</label>'; $disabled = "disabled"; break;
				case 1: $situacion = '<label class = "text-success">PAGADA</label>'; $disabled = ""; break;
				default: $situacion = '<i class = "fa fa-ban fa-2x text-warning"></i><br><label class = "text-warning">No ha generado boleta</label>'; $disabled = "disabled"; break;
			}
			$salida.= '<td class = "text-center">'.$situacion.'</td>';
			//--
			$sit = trim($row["alu_contrato_situacion"]);
			$salida.= '<td class = "text-center" >';
			if($sit == 1 && $sit_boleta == 2){
				$salida.= '<i class = "fa fa-edit text-warning"></i> <label class = "text-warning">Regreso a Actualizaci&oacute;n</label>';
			}else if($sit == 2 && $bolcod == ""){
				$salida.= '<i class = "fa fa-clock-o text-info"></i> <label class = "text-info">Pedir Boleta</label>';
			}else if($sit == 2 && $bolcod != ""){
				$salida.= '<i class = "fa fa-check text-success"></i> <label class = "text-success">Paso Completo, Saltar</label>';
			}else if($sit == 3){
				$salida.= '<i class = "fa fa-money text-info"></i> <label class = "text-info">Boleta Generada</label>';
			}else if($sit == 4){
				$salida.= '<i class = "fa fa-send-o text-info"></i> <label class = "text-info">Paso # 3</label>';
			}else if($sit == 5){
				$salida.= '<i class = "fa fa-check text-success"></i> <label class = "text-success">Solicitud Aprobada</label>';
			}else if($sit == 6){
				$salida.= '<i class = "fa fa-inbox text-success"></i> <label class = "text-success">Entregado</label>';
			}
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_hijos_verificacion($padre){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_alumno_padre($padre,"");
	
	if(is_array($result)){
			$salida.= '<div id="pad-wrapper" class="datatables-page">';
            $salida.= '<table class="table" id="tabla">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "100px">PRE-CONTRATO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE Y APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "70px">BOLETA No.</td>';
			$salida.= '<th class = "text-center" width = "150px">SITUACI&Oacute;N DE BOLETA</td>';
			$salida.= '<th class = "text-center" width = "50px"><i class = "fa fa-cogs"></i></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//--
			$cui = $row["alu_cui_new"];
			//pre-contato
			$contrato = $row["alu_contrato"];
			$salida.= '<td class = "text-center">'.$contrato.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//--
			$cod_boleta = $row["alu_boleta_inscripcion"];
			if($cod_boleta != ""){
				$result2 = $ClsIns->get_boleta_cobro($cod_boleta);
				if(is_array($result2)){
					foreach($result2 as $row2){
						$referencia = $row2["bol_referencia"];
						$bol_pagado = $row2["bol_pagado"];
						$bol_situacion = $row2["bol_situacion"];
					}
				}
			}else{
				$referencia = "";
				$bol_sit = -1; /////Inicia validacion
			}
			$salida.= '<td class = "text-center">'.$referencia.'</td>';
			//--
			if($bol_situacion == 1){
				switch($bol_pagado){
					case 0: $situacion = '<label class = "text-info">IMPRESA (EN TR&Aacute;MITE)</label>'; $disabled = "disabled"; break;
					case 1: $situacion = '<label class = "text-success">PAGADA</label>'; $disabled = ""; break;
					default: $situacion = '<i class = "fa fa-ban fa-2x text-warning"></i><br><label class = "text-warning">No ha generado boleta</label>'; $disabled = "disabled"; break;
				}
			}else{
				$situacion = '<label class = "text-danger">ANULADA</label>';
				$disabled = "disabled";
			}
			$salida.= '<td class = "text-center">'.$situacion.'</td>';
			//--
			$sit = trim($row["alu_contrato_situacion"]);
			$salida.= '<td class = "text-center" >';
			if($sit < 3){
				if($sit == 1 && $bol_sit == 2){
					$salida.= '<i class = "fa fa-edit text-warning"></i> <label class = "text-warning">Regreso a Actualizaci&oacute;n</label>';
				}else{
					$salida.= '<button type="button" class="btn btn-primary btn-block" onclick = "Solicitar_Aprobacion(\''.$cui.'\');" title = "Solicitar Verificaci&oacute;n" '.$disabled.' ><span class="fa fa-thumbs-up"></span></button>';
				}
			}else{
				if($sit == 3){
					$salida.= '<button type="button" class="btn btn-primary btn-block" onclick = "Solicitar_Aprobacion(\''.$cui.'\');" title = "Solicitar Verificaci&oacute;n" '.$disabled.' ><span class="fa fa-thumbs-up"></span></button>';
				}else if($sit == 4){
					$salida.= '<i class = "fa fa-send-o text-info"></i> <label class = "text-info">Solicitud Enviada</label>';
				}else if($sit == 5){
					$salida.= '<i class = "fa fa-check text-success"></i> <label class = "text-success">Solicitud Aprobada</label>';
				}else if($sit == 6){
					$salida.= '<i class = "fa fa-inbox text-success"></i> <label class = "text-success">Entregado</label>';
				}
			}
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}




function tabla_hijos_contrato($padre){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_alumno_padre($padre,"");
	
	if(is_array($result)){
			$salida.= '<div id="pad-wrapper" class="datatables-page">';
            $salida.= '<table class="table" id="tabla">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "100px">CONTRATO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE Y APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "150px">SITUACI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "30px">COMENTARIOS</td>';
			$salida.= '<th class = "text-center" width = "30px"><i class = "fa fa-cogs"></i></td>';
			$salida.= '<th class = "text-center" width = "50px"><i class = "fa fa-cogs"></i></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//--
			$cui = $row["alu_cui_new"];
			//pre-contato
			$contrato = $row["alu_contrato"];
			$salida.= '<td class = "text-center">'.$contrato.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//situacion
			$sit = trim($row["alu_contrato_situacion"]);
			switch($sit){
				case 0: $situacion = '<label class = "text-danger">DENEGADO</label>'; $disabled = "disabled"; break;
				case 1: $situacion = '<label class = "text-warning">EDICI&Oacute;N</label>'; $disabled = "disabled"; break;
				case 2: $situacion = '<label class = "text-info">EN PROCESOS</label>'; $disabled = "disabled"; break;
				case 3: $situacion = '<label class = "text-info">EN PROCESOS</label>'; $disabled = "disabled"; break;
				case 4: $situacion = '<label class = "text-info">EN PROCESOS</label>'; $disabled = "disabled"; break;
				case 5: $situacion = '<label class = "text-success">APROBADO</label>'; $disabled = ""; break;
			}
			$salida.= '<td class = "text-center">'.$situacion.'</td>';
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default" onclick = "verComentarios('.$contrato.',\''.$cui.'\');" title = "Ver Comentarios y Correcciones" ><span class="fa fa-comments"></span></button>';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-primary btn-block" href = "../../CONFIG/INSCRIPCIONES/REPcontrato.php?cui='.$cui.'" target = "_blank" title = "Imprimir Contrato" '.$disabled.' ><span class="fas fa-file-alt"></span></a>';
			$salida.= '</td>';
			//--
			$sit = trim($row["alu_contrato_situacion"]);
			$bolcod = $row["alu_boleta_inscripcion"];
			$salida.= '<td class = "text-center" >';
			if($sit == 1){
				$salida.= '<i class = "fa fa-edit text-warning"></i> <label class = "text-warning">Regreso a Actualizaci&oacute;n</label>';
			}else if($sit == 2 && $bolcod == ""){
				$salida.= '<i class = "fa fa-clock-o text-info"></i> <label class = "text-info">Pedir Boleta</label>';
			}else if($sit == 2 && $bolcod != ""){
				$salida.= '<i class = "fa fa-check text-muted"></i> <label class = "text-muted">Solicitar Revisi&oacute;n</label>';
			}else if($sit == 3){
				$salida.= '<i class = "fa fa-clock-o text-info"></i> <label class = "text-info">Esperando Revisi&oacute;n</label>';
			}else if($sit == 4){
				$salida.= '<i class = "fa fa-send-o text-info"></i> <label class = "text-info">Solicitud Enviada</label>';
			}else if($sit == 5){
				$salida.= '<i class = "fa fa-check text-success"></i> <label class = "text-success">Solicitud Aprobada</label>';
			}else if($sit == 6){
				$salida.= '<i class = "fa fa-inbox text-success"></i> <label class = "text-success">Entregado</label>';
			}
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


?>
