<?php 
include_once('../html_fns.php');


function tabla_solicitud_boletas(){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_status($alumno,"1,2,3,4");
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px"><i class = "fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "50px">PRE-CONTRATO</th>';
		$salida.= '<th class = "text-center" width = "70px">CUI</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "150px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "100px">STATUS (Contrato)</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$codigo = $row["alu_boleta_inscripcion"];
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
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Anular_Boleta('.$codigo.');" title = "Anular Boleta" '.$disabled.' ><span class="fa fa-trash"></span></button>';
			$salida.= '</td>';
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
			$salida.= '<td class = "text-left">'.$nom.' '.$ape;
			$salida.= '<input type = "hidden" id = "cui'.$i.'" value = "'.$cui.'" />';
			$salida.= '<input type = "hidden" id = "nombre'.$i.'" value = "'.$nom.'" />';
			$salida.= '<input type = "hidden" id = "apellido'.$i.'" value = "'.$ape.'" />';
			$salida.= '</td>';
			//situacion label
			$salida.= '<td class = "text-center">'.$situacion.'</td>';
			//-
			$bolcod = $row["alu_boleta_inscripcion"];
			$cuenta = $ClsIns->cuenta;
			$banco = $ClsIns->banco;
			//--
			$salida.= '<td class = "text-center" >';
			$cui = $row["alu_cui_new"];
			$sit = $row["stat_situacion"]; //situacion del contrato
			if($sit == 1){
				$salida.= '<label>Edici&oacute;n</label>';
			}else if($sit == 2){
				$salida.= '<span class="text-info">Pendiente de Boleta</span>';
			}else if($sit == 3 && $bolcod != ""){
				$salida.= '<a class="btn btn-default btn-block" href = "../../CONFIG/INSCRIPCIONES/REPboleta.php?boleta='.$bolcod.'" target = "_blank" title = "Re-Imprimir Boleta" ><span class="fa fa-print"></span></a>';
			}else if($sit > 3 && $pagado == 1){
				$salida.= '<span class="text-success"><i class="fa fa-check"></i> Listo!</span>';
			}else if($sit >= 3 && $pagado == 0){
				$salida.= '<span class="text-warning">Pendiente de Pago</span>';
			}else{
				$salida.= '<span class="text-muted">Ups!</span>';
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


function tabla_boletas(){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_status($alumno,"2,3,4");
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px"><i class = "fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px">PRE-CONTRATO</th>';
			$salida.= '<th class = "text-center" width = "70px">CUI</th>';
			$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
			$salida.= '<th class = "text-center" width = "150px">BOLETA</th>';
			$salida.= '<th class = "text-center" width = "100px">STATUS (Contrato)</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$codigo = $row["alu_boleta_inscripcion"];
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
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Anular_Boleta('.$codigo.');" title = "Anular Boleta" '.$disabled.' ><span class="fa fa-trash"></span></button>';
			$salida.= '</td>';
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
			$salida.= '<td class = "text-left">'.$nom.' '.$ape;
			$salida.= '<input type = "hidden" id = "cui'.$i.'" value = "'.$cui.'" />';
			$salida.= '<input type = "hidden" id = "nombre'.$i.'" value = "'.$nom.'" />';
			$salida.= '<input type = "hidden" id = "apellido'.$i.'" value = "'.$ape.'" />';
			$salida.= '</td>';
			//situacion label
			$salida.= '<td class = "text-center">'.$situacion.'</td>';
			//-
			$bolcod = $row["alu_boleta_inscripcion"];
			$cuenta = $ClsIns->cuenta;
			$banco = $ClsIns->banco;
			//--
			$salida.= '<td class = "text-center" >';
			$cui = $row["alu_cui_new"];
			$sit = $row["stat_situacion"]; //situacion del contrato
			if($sit == 1){
				$salida.= '<label>Edici&oacute;n</label>';
			}else if($sit == 2){
				$salida.= '<span class="text-info">Pendiente de Boleta</span>';
			}else if(($sit == 2 ||$sit == 3) && $bolcod != "" && $pagado == 0){
				$salida.= '<button type="button" class="btn btn-success" onclick = "Situacion_Boleta('.$bolcod.','.$contrato.');" title = "Boleta Pagada!" '.$disabled.' ><span class="fa fa-check"></span></button>';
			}else if($sit == 3 && $bolcod != "" && $pagado == 1){
				$salida.= '<span class="text-success"><i class="fa fa-check"></i> Listo!</span>';
			}else if($sit > 3 && $pagado == 1){
				$salida.= '<span class="text-success"><i class="fa fa-check"></i> Listo!</span>';
			}else if($sit >= 3 && $pagado == 0){
				$salida.= '<span class="text-warning">Pendiente de Pago</span>';
			}else{
				$salida.= '<span class="text-muted">Ups!</span>';
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



function tabla_contratos_aprobacion(){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_status_grado_alumno("3,4");
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "5px"></td>';
			$salida.= '<th class = "text-center" width = "5px"></td>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "100px">PRE-CONTRATO</td>';
			$salida.= '<th class = "text-center" width = "100px">CUI</td>';
			$salida.= '<th class = "text-center" width = "200px">ALUMNO</td>';
			$salida.= '<th class = "text-center" width = "70px">BOLETA No.</td>';
			$salida.= '<th class = "text-center" width = "70px">REFERENCIA No.</td>';
			$salida.= '<th class = "text-center" width = "150px">SITUACI&Oacute;N DE BOLETA</td>';
			$salida.= '<th class = "text-center" width = "5px"></td>';
			$salida.= '<th class = "text-center" width = "5px"></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$contrato = $row["stat_contrato"];
			$cui = $row["alu_cui_new"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-warning btn-xs" onclick = "Regresar_Contrato('.$contrato.',\''.$cui.'\');" title = "Regresar Contrato para Correcciones" ><span class="fa fa-arrow-circle-left"></span></button>';
			$salida.= '</td>';
			//--
			$cui = $row["alu_cui_new"];
			$salida.= '<td class = "text-center">';
			$salida.= '<a class="btn btn-default btn-xs" href = "FRMeditmenu.php?cui='.$cui.'" target = "_blank" title = "Editar datos del Pre-Contrato" '.$disabled.' ><span class="fa fa-pencil"></span></a>';
			$salida.= '</td>';
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
			$codigo = $row["alu_boleta_inscripcion"];
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
			$cui = $row["alu_cui_new"];
			$salida.= '<td class = "text-center">';
			$salida.= '<a class="btn btn-primary btn-xs" href = "../../CONFIG/INSCRIPCIONES/REPcontrato.php?cui='.$cui.'" target = "_blank" title = "Revisar Pre-Contrato" '.$disabled.' ><span class="fa fa-search"></span></a>';
			$salida.= '</td>';
			//-
			$contrato = $row["stat_contrato"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "Aprobar_Contrato('.$contrato.');" title = "Validar Informaci&oacute;n del Contrato" '.$disabled.' ><span class="fa fa-check"></span></button>';
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



function tabla_contratos_recepcion(){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_status_grado_alumno(5);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "100px">PRE-CONTRATO</td>';
			$salida.= '<th class = "text-center" width = "100px">CUI</td>';
			$salida.= '<th class = "text-center" width = "200px">ALUMNO</td>';
			$salida.= '<th class = "text-center" width = "70px">BOLETA No.</td>';
			$salida.= '<th class = "text-center" width = "70px">REFERENCIA No.</td>';
			$salida.= '<th class = "text-center" width = "150px">SITUACI&Oacute;N DE BOLETA</td>';
			$salida.= '<th class = "text-center" width = "5px"></td>';
			$salida.= '<th class = "text-center" width = "5px"></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
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
			$codigo = $row["alu_boleta_inscripcion"];
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
			$cui = $row["alu_cui_new"];
			$salida.= '<td class = "text-center">';
			$salida.= '<a class="btn btn-default" href = "../../CONFIG/INSCRIPCIONES/REPcontrato.php?cui='.$cui.'" target = "_blank" title = "Revisar Pre-Contrato" '.$disabled.' ><span class="fa fa-search"></span></a>';
			$salida.= '</td>';
			//-
			$contrato = $row["stat_contrato"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-primary" onclick = "Recepcion_Contrato('.$contrato.');" title = "Marcar Como Contrato Recibido" ><span class="fa fa-inbox"></span></button>';
			$salida.= '</td>';
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



function tabla_inscripcion($pensum){
	$ClsIns = new ClsInscripcion();
	$ClsAlu = new ClsAlumno();
	$result = $ClsIns->get_status_grado_alumno(6);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "100px">CONTRATO</td>';
			$salida.= '<th class = "text-center" width = "100px">CUI</td>';
			$salida.= '<th class = "text-center" width = "200px">ALUMNO</td>';
			$salida.= '<th class = "text-center" width = "100px">NIVEL</td>';
			$salida.= '<th class = "text-center" width = "100px">GRADO</td>';
			$salida.= '<th class = "text-center" width = "20px"><i class = "fa fa-cogs"></i></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//contato
			$contrato = $row["stat_contrato"];
			$salida.= '<td class = "text-center">'.$contrato.'</td>';
			//cui
			$cuinew = $row["alu_cui_new"];
			$cuiold = $row["alu_cui_old"];
			$codint = $row["alu_codigo_interno"];
			$salida.= '<td class = "text-center">'.$cuinew.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//nivel
			$nivel = $row["niv_codigo"];
			$nivel_desc = $row["niv_descripcion"];
			$salida.= '<td class = "text-center">'.$nivel_desc.'</td>';
			//grado
			$grado = $row["gra_codigo"];
			$grado_desc = utf8_decode($row["gra_descripcion"]);
			$salida.= '<td class = "text-center">'.$grado_desc.'</td>';
			//-
			$cont = $ClsAlu->get_alumno_pensum($pensum,$cuinew);
			if($cont > 0){
				$boton = "default";
				$icono = "fa fa-ban";
				$disabled = "disabled";
			}else{
				$boton = "success";
				$icono = "fa fa-check-square-o";
				$disabled = "";
			}
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-'.$boton.'" onclick = "Inscripcion('.$nivel.','.$grado.',\''.$cuinew.'\',\''.$cuiold.'\',\''.$codint.'\');" title = "Inscribir a alumno en el siguiente cliclo" '.$disabled.' ><span class="'.$icono.'"></span></button>';
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




function tabla_lista_negra(){
	$ClsIns = new ClsInscripcion();
	$result = $ClsIns->get_bloqueados();
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "70px">CUI</td>';
			$salida.= '<th class = "text-center" width = "70px">CODIGO INTERNO</td>';
			$salida.= '<th class = "text-center" width = "150px">ALUMNO</td>';
			$salida.= '<th class = "text-center" width = "70px">GRADO</td>';
			$salida.= '<th class = "text-center" width = "200px">MOTIVO</td>';
			$salida.= '<th class = "text-center" width = "20px"><i class = "fa fa-cogs"></i></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//cui
			$cui = $row["blo_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//codigo
			$codigo = $row["blo_codigo_interno"];
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//nombre
			$nombre = utf8_decode($row["blo_nombre"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//grado
			$grado = utf8_decode($row["blo_grado"]);
			$salida.= '<td class = "text-left">'.$grado.'</td>';
			//observaciones
			$obs = utf8_decode($row["blo_observaciones"]);
			$salida.= '<td class = "text-justify">'.$obs.'</td>';
			//-
			$contrato = $row["stat_contrato"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger" onclick = "Quitar_Bloqueo(\''.$cui.'\');" title = "Quitar del Listado" ><span class="fa fa-trash"></span></button>';
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
