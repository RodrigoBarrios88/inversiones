<?php 
include_once('../../html_fns.php');


function tabla_boletas_cobro($cue,$ban,$fini,$ffin){
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_cobro($cod,$cue,$ban,$alumno,$documento,$anio,$usuario,$fini,$ffin,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "80px"># CUENTA</th>';
			$salida.= '<th class = "text-center" width = "60px">BANCO</th>';
			$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
			$salida.= '<th class = "text-center" width = "70px"># BOLETA</th>';
			$salida.= '<th class = "text-center" width = "100px">FECHA/PAGO</th>';
			$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
			$salida.= '<th class = "text-center" width = "150px">MOTIVO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$cod = $row["bol_codigo"];
            $cue = $row["bol_cuenta"];
            $ban = $row["bol_banco"];
            $usu = $_SESSION["codigo"];
			$hashkey1 = $ClsBol->encrypt($cod, $usu);
			$hashkey2 = $ClsBol->encrypt($cue, $usu);
			$hashkey3 = $ClsBol->encrypt($ban, $usu);
			$codigo = "$cod-$cue-$ban";
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-default btn-xs" title="Imprimir Boleta" href = "REPboleta.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'" target = "_blank" ><span class="fa fa-print"></span></a> ';
			$salida.= '</td>';
			//numero de cuenta
			$num = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center">'.$num.'</td>';
			//banco
			$bann = $row["ban_desc_ct"];
			$salida.= '<td class = "text-center">'.$bann.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left" >'.$alumno.'</td>';
			//Documento
			$doc = $row["bol_referencia"];
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			//fecha de pago
			$fecha = $row["bol_fecha_pago"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//Monto
			$mons = $row["mon_simbolo"];
			$monto = $row["bol_monto"];
			$monto = number_format($monto, 2);
			$salida.= '<td class = "text-center">'.$mons.'. '.$monto.'</td>';
			//Motivo
			$motivo = $row["bol_motivo"];
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



function tabla_pagos_ejecutados($cue,$ban,$fini,$ffin){
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro('',$cue,$ban,'','','','','','',$fini,$ffin,2);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "80px"># CUENTA</th>';
			$salida.= '<th class = "text-center" width = "60px">BANCO</th>';
			$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
			$salida.= '<th class = "text-center" width = "70px"># BOLETA</th>';
			$salida.= '<th class = "text-center" width = "100px">FECHA/PAGO</th>';
			$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
			$salida.= '<th class = "text-center" width = "150px">MOTIVO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//numero de cuenta
			$num = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center">'.$num.'</td>';
			//banco
			$bann = $row["ban_desc_ct"];
			$salida.= '<td class = "text-center">'.$bann.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left" >'.$alumno.'</td>';
			//Documento
			$doc = $row["pag_referencia"];
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			//fecha de pago
			$fecha = $row["pag_fechor"];
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//Monto
			$monto = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$mons = $row["mon_simbolo"];
			$monto = number_format($monto, 2);
			$salida.= '<td class = "text-center">'.$mons.'. '.$monto.'</td>';
			//Motivo
			$motivo = $row["bol_motivo"];
			$salida.= '<td class = "text-justify">'.$motivo.'</td>';
			$salida.= '</tr>';
			//--
			$i++;
		}
		$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_carga_electronica($cue,$ban,$fini,$ffin){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_carga_electronica($cod,$cue,$ban,$fini,$ffin);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><span class="glyphicon glyphicon-cog"></span></th>';
		$salida.= '<th class = "text-center" width = "30px">CODIGO</th>';
		$salida.= '<th class = "text-center" width = "150px">CUENTA</th>';
		$salida.= '<th class = "text-center" width = "150px">BANCO</th>';
		$salida.= '<th class = "text-center" width = "150px">FECHA DE CARGA</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			//-------- Lista archivos
			$salida.= '<tr>';
			$carga = $row["car_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($carga, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<a type="button" class="btn btn-default" title="Revisar el Archivo de Carga " href="REPdetalle_carga.php?hashkey='.$hashkey.'" target = "_blank" ><span class="fa fa-table"></span></a> ';
			$salida.= '</td>';
			//codigo
			$codigo = $row["car_codigo"];
			$codigo = Agrega_Ceros($codigo);
			$salida.= '<td class = "text-center" >'.$codigo.'</td>';
			//cuenta
			$cuenta = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center" >'.$cuenta.'</td>';
			//Banco
			$banco = $row["ban_desc_lg"];
			$salida.= '<td class = "text-center" >'.$banco.'</td>';
			//fecha de Carga
			$fecha = $row["car_fecha_registro"];
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//--------
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_detalle_carga_electronica($carga){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pagos_de_carga($carga);
	
	if(is_array($result)){
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "40px">TRANSACCI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "40px">BOLETA</th>';
			$salida.= '<th class = "text-center" width = "40px">ALUMNO</th>';
			$salida.= '<th class = "text-center" width = "120px">NOMBRE</th>';
			$salida.= '<th class = "text-center" width = "40px">EFECTIVO</th>';
			$salida.= '<th class = "text-center" width = "40px">CHEQUES PROP.</th>';
			$salida.= '<th class = "text-center" width = "40px">OTROS BAN.</th>';
			$salida.= '<th class = "text-center" width = "40px">ONLINE</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		$errores_boleta = 0;
		$errores_alumnos = 0;
		$errores_monto = 0;
		foreach($result as $row){
			////-- Comprobaciones
				$iconos = "";
				$disabled = "";
				$referencia = $row["pag_referencia"];
				$alumno = $row["pag_alumno"];
				$monto_total = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
				//--comprueba
				$comprueba_boleta = $row["comprueba_boleta"];
				$valida_boleta = ($comprueba_boleta == $referencia)?1:"";
				$comprueba_alumno = $row["comprueba_alumno"];
				$valida_alumno = ($comprueba_alumno == $alumno)?$alumno:"";
				$valida_monto = $row["comprueba_monto"];
				if($valida_boleta == "" && $valida_alumno == ""){
					$class = "danger";
				}else if($valida_boleta != "" && $valida_alumno != "" && $valida_monto != $monto_total){
					$class = "info";
					$disabled = "disabled";
				}else if($valida_boleta != "" && $valida_alumno != "" && $valida_monto == $monto_total){
					$class = "";
					$iconos = ' <span class="fa fa-check text-success" title ="Datos Correctos"></span> ';
					$disabled = "disabled";
				}else{
					$class = "warning";
				}
				//valida iconos a desplegar
				if($valida_boleta == ""){
					$iconos.= ' <span class="fa fa-file-text text-danger" title ="No existe el numero de boleta"></span> ';
					$errores_boleta++;
				}
				if($valida_alumno == ""){
					$iconos.= ' <span class="fa fa-user text-danger" title ="No existe el alumno"></span> ';
					$errores_alumnos++;
				}
				if($valida_boleta != "" && ($valida_monto != $monto_total)){
					$iconos.= ' <span class="fa fa-dollar text-info" title ="El monto de la boleta no coincide con el monto depositado"></span> ';
					$errores_monto++;
				}
				//--------
				$salida.= '<tr class="'.$class.'">';
				$salida.= '<td class = "text-center">'.$iconos.'</td>';
				//transaccion
				$transaccion = $row["pag_transaccion"];
				$transaccion = ($transaccion != "")? $transaccion : 0; /// valida que si el dato es nulo o vacion coloca 0
				$salida.= '<td class = "text-center" >'.$transaccion.'</td>';
				//boleta
				$referencia = $row["pag_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//alumno
				$alumno = $row["pag_alumno"];
				$salida.= '<td class = "text-center" >'.$alumno.'</td>';
				//alumno
				$alumno = utf8_decode($row["alu_nombre_completo"]);
				$salida.= '<td class = "text-left" >'.$alumno.'</td>';
				//efectivo
				$valor = $row["pag_efectivo"];
				$salida.= '<td class = "text-center" >'.$valor.'</td>';
				//chequede propio banco
				$valor = $row["pag_cheques_propios"];
				$salida.= '<td class = "text-center" >'.$valor.'</td>';
				//cheque de otros bancos
				$valor = $row["pag_otros_bancos"];
				$salida.= '<td class = "text-center" >'.$valor.'</td>';
				//Pagos Online
				$valor = $row["pag_online"];
				$salida.= '<td class = "text-center" >'.$valor.'</td>';
				//--
				$salida.= '</tr>';
				//--
				$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
			$salida.= '</table>';
			$salida.= '<input type = "hidden" id = "filas" name = "filas" value = "'.$i.'" />';
			///valida cantidad de errores para notificar
			$errores_total = ($errores_alumnos+$errores_boleta+$errores_monto);
			$alert = ($errores_total > 0)?"danger":"success";
			$salida.= '<div>';
				$salida.= '<div class="alert alert-'.$alert.' alert-dismissable">';
				$salida.= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$salida.= ' '.$errores_total.' Error(es) encontrado(s)...';
				$salida.= '</div>';
				if($errores_alumnos > 0){
					$salida.= '<div class="alert alert-warning alert-dismissable">';
					$salida.= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$salida.= ' '.$errores_alumnos.' Codigos de alumnos fueron digitados incorrectamente en este listado de carga electr&oacute;nica...';
					$salida.= '</div>';
				}
				if($errores_boleta > 0){
					$salida.= '<div class="alert alert-warning alert-dismissable">';
					$salida.= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$salida.= ' '.$errores_boleta.' No. de Referencia(s) fueron digitados incorrectamente en este listado de carga electr&oacute;nica...';
					$salida.= '</div>';
				}
				if($errores_monto > 0){
					$salida.= '<div class="alert alert-warning alert-dismissable">';
					$salida.= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$salida.= ' '.$errores_monto.' montos no coinciden con su monto original...';
					$salida.= '</div>';
				}
			$salida.= '</div>';
			//-- /terminan notificaciones
			$salida.= '</div>';

	}else{
		echo "error en la lectura";
	}
	
	return $salida;
}

?>
