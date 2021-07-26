<?php 
include_once('../html_fns.php');

function tabla_alumnos($pensum,$nivel,$grado,$seccion){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			$sit = $row["alu_situacion"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsAcad->encrypt($cui, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-default" href="FRMprogramar.php?hashkey='.$hashkey.'" title = "Programar Pagos" ><span class="fa fa-calendar"></span></a>';
			$salida.= '</td>';
			//cui
			$cui = utf8_decode($row["alu_cui"]);
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//codigo interno
			$codigo = utf8_decode($row["alu_codigo_interno"]);
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//correo
			$pad = utf8_decode($row["alu_padre"]);
			$salida.= '<td class = "text-left">'.$pad.'</td>';
			//telefono1
			$tel = $row["alu_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
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


function tabla_direcotrio_alumnos($pensum){
	$ClsAlu = new ClsAlumno();
	$result = $ClsAlu->get_alumno($cui,'','',1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			$sit = $row["alu_situacion"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsAlu->encrypt($cui, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-default" href="FRMprogramar.php?hashkey='.$hashkey.'&pensum='.$pensum.'" title = "Programar Pagos" ><span class="fa fa-calendar"></span></a>';
			$salida.= '</td>';
			//cui
			$cui = utf8_decode($row["alu_cui"]);
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//codigo interno
			$codigo = utf8_decode($row["alu_codigo_interno"]);
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//correo
			$pad = utf8_decode($row["alu_padre"]);
			$salida.= '<td class = "text-left">'.$pad.'</td>';
			//telefono1
			$tel = $row["alu_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
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


function tabla_alumnos_inscripcion($pensum,$nivel,$grado){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_grado_alumno($pensum,$nivel,$grado,'','',1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cui = $row["alu_cui"];
			$sit = $row["alu_situacion"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsAcad->encrypt($cui, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-default" href="FRMprogramar.php?hashkey='.$hashkey.'&pensum='.$pensum.'" title = "Programar Pagos" ><span class="fa fa-calendar"></span></a>';
			$salida.= '</td>';
			//cui
			$cui = utf8_decode($row["alu_cui"]);
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//codigo interno
			$codigo = utf8_decode($row["alu_codigo_interno"]);
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//correo
			$pad = utf8_decode($row["alu_padre"]);
			$salida.= '<td class = "text-left">'.$pad.'</td>';
			//telefono1
			$tel = $row["alu_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
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

//////////// CONFIGURACION DE BOLETAS DE COBROS ///////////

function tabla_new_configuracion_inicial($monto,$motivo,$periodo,$mes,$dia,$cant){
	$ClsPer = new ClsPeriodoFiscal();
	$result = $ClsPer->get_periodo($periodo);
	if(is_array($result)){
		foreach($result as $row){
			$periodo_descripcion = utf8_decode($row["per_descripcion_completa"]);
			$per_anio = $row["per_anio"];
			echo $per_anio ;
		}
	}else{
		$periodo_descripcion = "- No habilitado -";
	}
	
	if($cant > 0){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "150px">MOTIVO</th>';
		$salida.= '<th class = "text-center" width = "30px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "150px">PERIODO</th>';
		$salida.= '<th class = "text-center" width = "100px">MES</th>';
		$salida.= '<th class = "text-center" width = "30px">DIA</th>';
		$salida.= '<th class = "text-center" width = "100px">A&Ntilde;O</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		for($i = 1; $i <= $cant; $i ++){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="QuitarFilaConfig('.$i.')" title = "Quitar Fila" ><span class="fa fa-trash-o"></span></button>';
			$salida.= '</td>';
			//motivo
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "text" class="form-control" name = "motivo'.$i.'" id = "motivo'.$i.'" value = "'.$motivo.'" onkeyup="texto(this)" />';
			$salida.= '</td>';
			//monto
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "text" class="form-control text-center" name = "monto'.$i.'" id = "monto'.$i.'" value = "'.$monto.'" onkeyup="decimales(this)" />';
			$salida.= '</td>';
			//Periodo
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "text" class="form-control" value = "'.$periodo_descripcion.'" readonly />';
			$salida.= '<input type = "hidden" name = "periodo'.$i.'" id = "periodo'.$i.'" value = "'.$periodo.'"  />';
			$salida.= '</td>';
			//mes
			$salida.= '<td class = "text-center" >';
			$salida.= '<select class="form-control" id="mes'.$i.'" name="mes'.$i.'">';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "1">ENERO</option>';
			$salida.= '<option value = "2">FEBRERO</option>';
			$salida.= '<option value = "3">MARZO</option>';
			$salida.= '<option value = "4">ABRIL</option>';
			$salida.= '<option value = "5">MAYO</option>';
			$salida.= '<option value = "6">JUNIO</option>';
			$salida.= '<option value = "7">JULIO</option>';
			$salida.= '<option value = "8">AGOSTO</option>';
			$salida.= '<option value = "9">SEPTIEMBRE</option>';
			$salida.= '<option value = "10">OCTUBRE</option>';
			$salida.= '<option value = "11">NOVIEMBRE</option>';
			$salida.= '<option value = "12">DICIEMBRE</option>';
			$salida.= '</select>';
			$salida.= '<script type="text/javascript">document.getElementById("mes'.$i.'").value = "'.$mes.'";</script>';
			$salida.= '</td>';
			//dia
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "text" class="form-control text-center" name = "dia'.$i.'" id = "dia'.$i.'" value = "'.$dia.'" onkeyup="enteros(this)" />';
			$salida.= '</td>';
			//año
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "text" class="form-control" name = "anio'.$i.'" id = "anio'.$i.'" value = "'.$per_anio.'" />';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			//--
			$mes++;
			if($mes > 12){
				$anio ++;
				$per_anio ++;
				$mes = 1;
			}
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_new_configuracion($arrmonto,$arrmotivo,$arranio,$arrmes,$arrdia,$cant){
	
	if($cant > 0){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "30px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "150px">MOTIVO</th>';
		$salida.= '<th class = "text-center" width = "30px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "50px">A&Ntilde;O</th>';
		$salida.= '<th class = "text-center" width = "100px">MES</th>';
		$salida.= '<th class = "text-center" width = "30px">DIA</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		for($i = 1; $i <= $cant; $i ++){
			$monto = $arrmonto[$i];
			$motivo = utf8_decode($arrmotivo[$i]);
			$anio = $arranio[$i];
			$mes = $arrmes[$i];
			$dia = $arrdia[$i];
			//--
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="QuitarFilaConfig('.$i.')" title = "Quitar Fila" ><span class="fa fa-trash-o"></span></button>';
			$salida.= '</td>';
			//motivo
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "text" class="form-control" name = "motivo'.$i.'" id = "motivo'.$i.'" value = "'.$motivo.'" onkeyup="texto(this)" />';
			$salida.= '</td>';
			//monto
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "text" class="form-control" name = "monto'.$i.'" id = "monto'.$i.'" value = "'.$monto.'" onkeyup="decimales(this)" />';
			$salida.= '</td>';
			//Periodo
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "text" class="form-control" name = "anio'.$i.'" id = "anio'.$i.'" value = "'.$periodo.'" readonly />';
			$salida.= '</td>';
			//mes
			$salida.= '<td class = "text-center" >';
			$salida.= '<select class="form-control" id="mes'.$i.'" name="mes'.$i.'">';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "1">ENERO</option>';
			$salida.= '<option value = "2">FEBRERO</option>';
			$salida.= '<option value = "3">MARZO</option>';
			$salida.= '<option value = "4">ABRIL</option>';
			$salida.= '<option value = "5">MAYO</option>';
			$salida.= '<option value = "6">JUNIO</option>';
			$salida.= '<option value = "7">JULIO</option>';
			$salida.= '<option value = "8">AGOSTO</option>';
			$salida.= '<option value = "9">SEPTIEMBRE</option>';
			$salida.= '<option value = "10">OCTUBRE</option>';
			$salida.= '<option value = "11">NOVIEMBRE</option>';
			$salida.= '<option value = "12">DICIEMBRE</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			//dia
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "text" class="form-control" name = "dia'.$i.'" id = "dia'.$i.'" value = "'.$dia.'" onkeyup="enteros(this)" />';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			//--
			$mes++;
			if($mes > 12){
				$anio ++;
				$mes = 1;
			}
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_configuraciones_boletas_cobro($codigo,$division,$grupo,$tipo,$periodo){
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_configuracion_boleta_cobro($codigo,$division,$grupo,$tipo,$periodo);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "50px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "150px">DIVISI&Oacute;N</th>';
		$salida.= '<th class = "text-center" width = "150px">GRUPO</th>';
		$salida.= '<th class = "text-center" width = "100px">TIPO</th>';
		$salida.= '<th class = "text-center" width = "150px">MOTIVO</th>';
		$salida.= '<th class = "text-center" width = "30px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "100px">PERIODO</th>';
		$salida.= '<th class = "text-center" width = "10px">DIA</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$codigo = $row["cbol_codigo"];
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Configuracion('.$codigo.');" title = "Seleccionar Configuracion" ><span class="fa fa-edit"></span></button> ';
					$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="ConfirmEliminarConfiguracion('.$codigo.');" title = "Eliminar Registro de Configuracion" ><span class="fa fa-trash-o"></span></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//Division
			$division = utf8_decode($row["div_nombre"]);
			$salida.= '<td class = "text-left">'.$division.'</td>';
			//banco
			$grupo = $row["gru_nombre"];
			$salida.= '<td class = "text-left">'.$grupo.'</td>';
			//tipo
			$tipo = $row["cbol_tipo"];
			switch($tipo){
				case 'C': $tipo = "Cargos"; break;
				case 'M': $tipo = "Moras"; break;
				case 'I': $tipo = "Inscripci&oacute;n"; break;
				case 'E': $tipo = "Evaluaciones de Conocimiento"; break;
				case 'V': $tipo = "Ventas con Boleta"; break;
			}
			$salida.= '<td class = "text-center" >'.$tipo.'</td>';
			//motivo
			$motivo = utf8_decode($row["cbol_motivo"]);
			$salida.= '<td class = "text-center">'.$motivo.'</td>';
			//monto
			$monto = $row["cbol_monto"];
			$monto = number_format($monto, 2);
			$salida.= '<td class = "text-center">'.$monto.'</td>';
			//Periodo
			$periodo = $row["cbol_periodo_descripcion"];
			$salida.= '<td class = "text-center">'.$periodo.'</td>';
			//mes y dia
			$mes = $row["cbol_mes"];
			switch($mes){
				case 1: $mes = "Enero"; break;
				case 2: $mes = "Febrero"; break;
				case 3: $mes = "Marzo"; break;
				case 4: $mes = "Abril"; break;
				case 5: $mes = "Mayo"; break;
				case 6: $mes = "Junio"; break;
				case 7: $mes = "Julio"; break;
				case 8: $mes = "Agosto"; break;
				case 9: $mes = "Septiembre"; break;
				case 10: $mes = "Octubre"; break;
				case 11: $mes = "Noviembre"; break;
				case 12: $mes = "Diciembre"; break;
			}
			//dia
			$dia = $row["cbol_dia"];
			$salida.= '<td class = "text-center">'.$dia.' '.$mes.'</td>';
			$salida.= '</tr>';
			//--
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


////////////// BOLETAS DE COBRO ///////////////////////


function tabla_inicial_boletas_cobro($grupo,$division,$periodo,$cui,$tipodesc,$desc,$motdesc,$referencia,$pensum,$nivel,$grado){
	$ClsBol = new ClsBoletaCobro();
	$result_nivel = $ClsBol->get_configuracion_boleta_cobro('',$division,$grupo,'',$periodo,$pensum,$nivel,0);
	$result_grado = $ClsBol->get_configuracion_boleta_cobro('',$division,$grupo,'',$periodo,$pensum,$nivel,$grado);
	$boleta = $ClsBol->max_boleta_cobro();
	$boleta++;
	
	if(is_array($result_nivel) || is_array($result_grado)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "100px">DIVISI&Oacute;N</th>';
		$salida.= '<th class = "text-center" width = "100px">GRUPO</th>';
		$salida.= '<th class = "text-center" width = "70px">TIPO</th>';
		$salida.= '<th class = "text-center" width = "150px">MOTIVO</th>';
		$salida.= '<th class = "text-center" width = "30px">PRECIO</th>';
		$salida.= '<th class = "text-center" width = "30px">DESC.</th>';
		$salida.= '<th class = "text-center" width = "30px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "50px">FECHA</th>';
		$salida.= '<th class = "text-center" width = "30px"># BOLETA</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		if(is_array($result_nivel)){
			$salida.= '<tr>';
				$salida.= '<th class = "text-center" colspan = "10"> BOLETAS PARA EL NIVEL</th>';
			$salida.= '</tr>';
			foreach($result_nivel as $row){
				$salida.= '<tr>';
				//--
				$codigo = $row["cbol_codigo"];
				//Division
				$div_nombre = $row["div_nombre"];
				$division = $row["cbol_division"];
				$salida.= '<td class = "text-left">';
				$salida.= '<input type ="hidden" name = "division'.$i.'" id = "division'.$i.'" value = "'.$division.'" />';
				$salida.= $div_nombre.'</td>';
				//grupo
				$grupo_nombre = $row["gru_nombre"];
				$grupo = $row["cbol_grupo"];
				$salida.= '<td class = "text-left">';
				$salida.= '<input type ="hidden" name = "grupo'.$i.'" id = "grupo'.$i.'" value = "'.$grupo.'" />';
				$salida.= $grupo_nombre.'</td>';
				//tipo
				$tipo = $row["cbol_tipo"];
					switch($tipo){
					case 'C': $tipo_desc = "Cargos"; break;
					case 'M': $tipo_desc = "Moras"; break;
					case 'I': $tipo_desc = "Inscripci&oacute;n"; break;
					case 'E': $tipo_desc = "Evaluaciones de Conocimiento"; break;
					case 'V': $tipo_desc = "Ventas con Boleta"; break;
				}
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type ="hidden" name = "tipo'.$i.'" id = "tipo'.$i.'" value = "'.$tipo.'" />';
				$salida.= $tipo_desc.'</td>';
				//motivo
				$motivo = utf8_decode($row["cbol_motivo"]);
				$salida.= '<td class = "text-left">';
				$salida.= '<input type ="hidden" name = "motivo'.$i.'" id = "motivo'.$i.'" value = "'.$motivo.'" />';
				$salida.= $motivo.'</td>';
				//precio
				$mons = $row["mon_simbolo"];
				$precio = trim($row["cbol_monto"]);
				$salida.= '<td class = "text-center">'.number_format($precio, 2, '.', ',').'</td>';
				//descuento
				if($tipodesc == "M"){
					$descuento = $desc;
				}else if($tipodesc == "P"){
					$descuento = ($precio * $desc)/100;
				}
				$motdesc = trim($motdesc);
				$salida.= '<td class = "text-center">';
				$salida.= '<input type ="hidden" name = "tipodesc'.$i.'" id = "tipodesc'.$i.'" value = "'.$tipodesc.'" />';
				$salida.= '<input type ="hidden" name = "desc'.$i.'" id = "desc'.$i.'" value = "'.$descuento.'" />';
				$salida.= '<input type ="hidden" name = "motdesc'.$i.'" id = "motdesc'.$i.'" value = "'.$motdesc.'" />';
				$salida.= number_format($descuento, 2, '.', ',').'</td>';
				//monto
				$monto = ($precio - $descuento);
				$icon = ($descuento > 0)?'<i class="fa fa-tag text-info" title = "'.$motdesc.'"></i>':'';
				$salida.= '<td class = "text-center">';
				$salida.= '<input type ="hidden" name = "monto'.$i.'" id = "monto'.$i.'" value = "'.$monto.'" />';
				$salida.= number_format($monto, 2, '.', ',').' '.$icon.'</td>';
				//fecha
				$periodo = $row["cbol_periodo_fiscal"];
				$anio = $row["cbol_anio"];
				$mes = $row["cbol_mes"];
				$dia = $row["cbol_dia"];
				$fecha = "$dia/$mes/$anio";
				$salida.= '<td class = "text-center">';
				$salida.= '<input type ="hidden" name = "fecha'.$i.'" id = "fecha'.$i.'" value = "'.$fecha.'" />';
				$salida.= '<input type ="hidden" name = "periodo'.$i.'" id = "periodo'.$i.'" value = "'.$periodo.'" />';
				$salida.= $fecha.'</td>';
				//boleta
				$salida.= '<td class = "text-center">';
				$salida.= '<input type ="hidden" name = "boleta'.$i.'" id = "boleta'.$i.'" value = "'.$boleta.'" />';
				$salida.= $boleta.'</td>';
				//--
				$salida.= '</tr>';
				$i++;
				$boleta ++;
				$referencia ++;
			}
		}
		if(is_array($result_grado)){
			$salida.= '<tr>';
				$salida.= '<th class = "text-center" colspan = "10"> BOLETAS ESPECIFICAS PARA EL GRADO</th>';
			$salida.= '</tr>';
			foreach($result_grado as $row){
				$salida.= '<tr>';
				//--
				$codigo = $row["cbol_codigo"];
				//Division
				$div_nombre = $row["div_nombre"];
				$division = $row["cbol_division"];
				$salida.= '<td class = "text-left">';
				$salida.= '<input type ="hidden" name = "division'.$i.'" id = "division'.$i.'" value = "'.$division.'" />';
				$salida.= $div_nombre.'</td>';
				//grupo
				$grupo_nombre = $row["gru_nombre"];
				$grupo = $row["cbol_grupo"];
				$salida.= '<td class = "text-left">';
				$salida.= '<input type ="hidden" name = "grupo'.$i.'" id = "grupo'.$i.'" value = "'.$grupo.'" />';
				$salida.= $grupo_nombre.'</td>';
				//tipo
				$tipo = $row["cbol_tipo"];
					switch($tipo){
					case 'C': $tipo_desc = "Cargos"; break;
					case 'M': $tipo_desc = "Moras"; break;
					case 'I': $tipo_desc = "Inscripci&oacute;n"; break;
					case 'E': $tipo_desc = "Evaluaciones de Conocimiento"; break;
					case 'V': $tipo_desc = "Ventas con Boleta"; break;
				}
				$salida.= '<td class = "text-center" >';
				$salida.= '<input type ="hidden" name = "tipo'.$i.'" id = "tipo'.$i.'" value = "'.$tipo.'" />';
				$salida.= $tipo_desc.'</td>';
				//motivo
				$motivo = utf8_decode($row["cbol_motivo"]);
				$salida.= '<td class = "text-left">';
				$salida.= '<input type ="hidden" name = "motivo'.$i.'" id = "motivo'.$i.'" value = "'.$motivo.'" />';
				$salida.= $motivo.'</td>';
				//precio
				$mons = $row["mon_simbolo"];
				$precio = trim($row["cbol_monto"]);
				$salida.= '<td class = "text-center">'.number_format($precio, 2, '.',',').'</td>';
				//descuento
				if($tipodesc == "M"){
					$descuento = $desc;
				}else if($tipodesc == "P"){
					$descuento = ($precio * $desc)/100;
				}
				$motdesc = trim($motdesc);
				$salida.= '<td class = "text-center">';
				$salida.= '<input type ="hidden" name = "desc'.$i.'" id = "desc'.$i.'" value = "'.$descuento.'" />';
				$salida.= '<input type ="hidden" name = "motdesc'.$i.'" id = "motdesc'.$i.'" value = "'.$motdesc.'" />';
				$salida.= number_format($descuento, 2, '.',',').'</td>';
				//monto
				$monto = ($precio - $descuento);
				$icon = ($descuento > 0)?'<i class="fa fa-tag text-info" title = "'.$motdesc.'"></i>':'';
				$salida.= '<td class = "text-center">';
				$salida.= '<input type ="hidden" name = "monto'.$i.'" id = "monto'.$i.'" value = "'.$monto.'" />';
				$salida.= number_format($monto, 2, '.',',').' '.$icon.'</td>';
				//fecha
				$periodo = $row["cbol_periodo_fiscal"];
				$anio = $row["cbol_anio"];
				$mes = $row["cbol_mes"];
				$dia = $row["cbol_dia"];
				$fecha = "$dia/$mes/$anio";
				$salida.= '<td class = "text-center">';
				$salida.= '<input type ="hidden" name = "fecha'.$i.'" id = "fecha'.$i.'" value = "'.$fecha.'" />';
				$salida.= '<input type ="hidden" name = "periodo'.$i.'" id = "periodo'.$i.'" value = "'.$periodo.'" />';
				$salida.= $fecha.'</td>';
				//boleta
				$salida.= '<td class = "text-center">';
				$salida.= '<input type ="hidden" name = "boleta'.$i.'" id = "boleta'.$i.'" value = "'.$boleta.'" />';
				$salida.= $boleta.'</td>';
				//--
				$salida.= '</tr>';
				$i++;
				$boleta ++;
				$referencia ++;
			}
		}
		$i--;
		$salida.= '</table>';
		$salida.= '<input type ="hidden" name = "filas" id = "filas" value = "'.$i.'" />';
		$salida.= '</div>';
	}else{
		$salida.= '<div class="alert alert-warning"><label>No hay configuraci&oacute;n de Boletas de Pago Cargadas para este Grado...</label></div>';
	}
	
	return $salida;
}


function tabla_boletas_cobro($codigo,$division,$grupo,$alumno,$documento,$periodo){
	$ClsPen = new ClsPensum();
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_cobro($codigo,$division,$grupo,$alumno,$documento,$periodo,$usuario,$fini,$ffin,1);
	
	$pensum = $ClsPen->get_pensum_anio($anio);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "100px">DIVISI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "100px">GRUPO</th>';
			$salida.= '<th class = "text-center" width = "30px"># BOLETA</th>';
			$salida.= '<th class = "text-center" width = "60px">FECHA/PAGO</th>';
			$salida.= '<th class = "text-center" width = "30px">MONTO</th>';
			$salida.= '<th class = "text-center" width = "150px">MOTIVO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$codigo = $row["bol_codigo"];
			//--
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($codigo, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-default btn-xs" title="Imprimir Boleta" href = "../../CONFIG/BOLETAS/REPboleta.php?hashkey='.$hashkey.'" target = "_blank" ><span class="fa fa-print"></span></a> ';
			$salida.= '</td>';
			//Division
			$division = utf8_decode($row["div_nombre"]);
			$salida.= '<td class = "text-left">'.$division.'</td>';
			//banco
			$grupo = $row["gru_nombre"];
			$salida.= '<td class = "text-left">'.$grupo.'</td>';
			//boleta
			$boleta = $row["bol_codigo"];
			$salida.= '<td class = "text-center">'.$boleta.'</td>';
			//fecha de pago
			$fecha = $row["bol_fecha_pago"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//Monto
			$mons = $row["mon_simbolo"];
			$monto = $row["bol_monto"];
			$monto = number_format($monto, 2);
			$salida.= '<td class = "text-center">'.$monto.'</td>';
			//Motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			$salida.= '<td class = "text-justify">'.$motivo.'</td>';
			$salida.= '</tr>';
			//--
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

?>
