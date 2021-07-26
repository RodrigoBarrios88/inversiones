<?php 
include_once('../../html_fns.php');


function tabla_boletas_cobro($cue,$ban,$tipo,$periodo,$fini,$ffin){
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_cobro('',$cue,$ban,$alumno,$documento,$periodo,$usuario,$fini,$ffin,1,'','',$tipo);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "50px">GRADO</th>';
		$salida.= '<th class = "text-center" width = "50px">CUI</th>';
		$salida.= '<th class = "text-center" width = "70px"># BOLETA</th>';
		$salida.= '<th class = "text-center" width = "30px">REFERENCIA</td>';
		$salida.= '<th class = "text-center" width = "100px">FECHA/PAGO</th>';
		$salida.= '<th class = "text-center" width = "150px">MOTIVO (MES)</th>';
		$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
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
			$salida.= '<a type="button" class="btn btn-default btn-xs" title="Imprimir Boleta" href = "../../CONFIG/BOLETAS/REPboleta.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'" target = "_blank" ><span class="fa fa-print"></span></a> ';
			$salida.= '</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left" >'.$alumno.'</td>';
			//Grado y Seccion
			$grado = utf8_decode($row["alu_grado_descripcion"])." ".utf8_decode($row["alu_seccion_descripcion"]);
			$salida.= '<td class = "text-left" >'.$grado.'</td>';
			//CUI
			$cui = $row["bol_alumno"];
			$salida.= '<td class = "text-center" >'.$cui.'</td>';
			//boleta
			$boleta = $row["bol_codigo"];
			$salida.= '<td class = "text-center">'.$boleta.'</td>';
			//referencia
			$referencia = $row["bol_referencia"];
			$salida.= '<td class = "text-center">'.$referencia.'</td>';
			//fecha de pago
			$fecha = $row["bol_fecha_pago"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//Motivo
			$fecha = $row["bol_fecha_pago"];
			$mes = substr($fecha,5,2);
			$mes = Meses_Letra($mes);
			$motivo = $row["bol_motivo"];
			$salida.= '<td class = "text-justify">'.$motivo.' ('.$mes.')</td>';
			//Monto
			$mons = $row["mon_simbolo"];
			$monto = $row["bol_monto"];
			$monto = number_format($monto, 2);
			$salida.= '<td class = "text-center">'.$mons.'. '.$monto.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_pagos_ejecutados($cue,$ban,$periodo,$fini,$ffin){
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro('',$cue,$ban,'','',$periodo,'','','',$fini,$ffin,2);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "50px">CUI</th>';
		$salida.= '<th class = "text-center" width = "170px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "100px">GRADO</th>';
		$salida.= '<th class = "text-center" width = "40px"># BOLETA</th>';
		$salida.= '<th class = "text-center" width = "30px">REFERENCIA</td>';
		$salida.= '<th class = "text-center" width = "150px">MOTIVO</th>';
		$salida.= '<th class = "text-center" width = "60px">FECHA/PAGO</th>';
		$salida.= '<th class = "text-center" width = "20px">MONTO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		$ingresos = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//numero de cuenta
			$cui = $row["pag_alumno"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left" >'.$alumno.'</td>';
			//grado
			$grado = utf8_decode($row["alu_grado_descripcion"]);
			$salida.= '<td class = "text-left">'.$grado.'</td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center">'.$boleta.'</td>';
			//referencia
			$referencia = $row["pag_referencia"];
			$salida.= '<td class = "text-center">'.$referencia.'</td>';
			//Motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			$salida.= '<td class = "text-justify">'.$motivo.'</td>';
			//fecha de pago
			$fecha = $row["pag_fechor"];
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//Monto
			$monto = ($row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"]);
			$ingresos+= $monto;
			$mons = $row["mon_simbolo"];
			$monto = number_format($monto, 2);
			$salida.= '<td class = "text-center">'.$mons.'. '.$monto.'</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
		//---
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
		$salida.= '<th class = "text-center">'.$mons.'. '.$ingresos.'</td>';
		$salida.= '</tr>';
		//--
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_ingresos($cue,$ban,$periodo,$desde,$hasta){
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro('',$cue,$ban,'','',$periodo,'','','',$desde,$hasta,3);
	
	if(is_array($result)){
        $salida.= '<div class="dataTable_wrapper">';
        $salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px">CUI</td>';
		$salida.= '<th class = "text-center" width = "170px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "30px">BOLETA No.</td>';
		$salida.= '<th class = "text-center" width = "30px">REFERENCIA No.</td>';
		$salida.= '<th class = "text-center" width = "20px">CARGA</td>';
		$salida.= '<th class = "text-center" width = "150px">GRADO</td>';
		$salida.= '<th class = "text-center" width = "70px">FECHA</td>';
		$salida.= '<th class = "text-center" width = "30px">MONTO</td>';
		$salida.= '<th class = "text-center" width = "50px">FACTURA</td>';
		$salida.= '<th class = "text-center" width = "50px">NIT</td>';
		$salida.= '<th class = "text-center" width = "100px">CONTRIBUYENTE</td>';
		$salida.= '<th class = "text-center" width = "150px">MES</td>';
		$salida.= '<th class = "text-center" width = "150px">Motivo o Concepto</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		$cargos = 0;
		$ingresos = 0;
		$descuentos = 0;
		foreach($result as $row){
			$nombre_completo = utf8_decode($row["alu_nombre_completo"]);
			$nombre_inscripcion = utf8_decode($row["inscripcion_nombre_completo"]);
			/// si reconoce al alumno lo agrega al listado, si no, NO
			if($nombre_completo != "" || $nombre_inscripcion != ""){
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center">'.$i.'.</td>';
				//cui
				$cui = $row["pag_alumno"];
				$salida.= '<td class = "text-center">'.$cui.'</td>';
				//nombre
				$nombre = utf8_decode($row["alu_nombre_completo"]);
				$nombre_inscripcion = utf8_decode($row["inscripcion_nombre_completo"]);
				$nombre = ($nombre == "")?$nombre_inscripcion:$nombre;
				$salida.= '<td class = "text-left">'.$nombre.'</td>';
				//boleta
				$boleta = $row["pag_programado"];
				$salida.= '<td class = "text-center">'.$boleta.'</td>';
				//referencia
				$referencia = $row["pag_referencia"];
				$salida.= '<td class = "text-center">'.$referencia.'</td>';
				//carga
				$carga = $row["pag_carga"];
				$salida.= '<td class = "text-center"># '.$carga.'</td>';
				//grado
				$grado = utf8_decode($row["alu_grado_descripcion"]);
				$seccion = utf8_decode($row["alu_seccion_descripcion"]);
				$salida.= '<td class = "text-left">'.$grado.' '.$seccion.'</td>';
				//fecha
				$fecha = $row["pag_fechor"];
				$fecha = cambia_fechaHora($fecha);
				$fecha = substr($fecha,0,10);
				$salida.= '<td class = "text-center">'.$fecha.'</td>';
				//cargos
				$ingreso = ($row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"]);
				$ingresos+= $ingreso;
				$descuento = 0;
				$descuentos+= $descuento;
				$cargo = $ingreso + $descuento;
				$cargos+= $cargo;
				$cargo = number_format($cargo,2,'.','');
				//$salida.= '<td class = "text-center">Q. '.$cargo.'</td>';
				//descuentos
				$descuento = $row["bol_descuento"];
				//$salida.= '<td class = "text-center">Q. '.$descuento.'</td>';
				//ingresos
				$ingreso = number_format($ingreso,2,'.','');
				$salida.= '<td class = "text-center text-info"><b>Q. '.$ingreso.'<b></td>';
				//factura
				$serie = $row["fac_serie_numero"];
				$numero = $row["fac_numero"];
				$salida.= '<td class = "text-center">'.$serie.' '.$numero.'</td>';
				//NIT
				$nit = utf8_decode($row["alu_nit"]);
				$nit_inscripcion = utf8_decode($row["inscripcion_nit"]);
				$nit = ($nit == "")?$nit_inscripcion:$nit;
				$salida.= '<td class = "text-center">'.$nit.'</td>';
				//Cliente
				$cliente = utf8_decode($row["alu_cliente_nombre"]);
				$cliente_inscripcion = utf8_decode($row["inscripcion_cliente_nombre"]);
				$cliente = ($cliente == "")?$cliente_inscripcion:$cliente;
				$salida.= '<td class = "text-left">'.$cliente.'</td>';
				//colegiatura
				$colegiatura = trim($row["bol_fecha_pago"]);
				$mes = substr($colegiatura,5,2);
				$mes = Meses_Letra($mes);
				$salida.= '<td class = "text-center">'.$mes.'</td>';
				//concepto
				$motivo = utf8_decode($row["bol_motivo"]);
				$motivo_boleta = ($motivo == "")?"- No relacionada -":$motivo;
				$salida.= '<td class = "text-center">'.$motivo_boleta.'</td>';
				//--
				$salida.= '</tr>';
				$i++;
			}
			
		}
		//// Facturas anuladas
		$result = $ClsBol->get_factura('','','','','','',$suc,'',0,$desde,$hasta);
		if(is_array($result)){
			foreach($result as $row){
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center">'.$i.'.</td>';
				//cui
				$cui = $row["fac_alumno"];
				$salida.= '<td class = "text-center">'.$cui.'</td>';
				//nombre
				$nombre = utf8_decode($row["alu_nombre_completo"]);
				$nombre = ($nombre == "")?"---":$nombre;
				$salida.= '<td class = "text-left">'.$nombre.'</td>';
				//boleta
				$boleta = $row["pag_programado"];
				$salida.= '<td class = "text-center">'.$boleta.'</td>';
				//referencia
				$referencia = $row["fac_referencia"];
				$salida.= '<td class = "text-center"># '.$referencia.'</td>';
				//carga
				$carga = $row["fac_carga"];
				$salida.= '<td class = "text-center"># '.$carga.'</td>';
				//grado
				$salida.= '<td class = "text-left">-- anulada --</td>';
				//fecha
				$fecha = $row["fac_fecha"];
				$fecha = cambia_fecha($fecha);
				$salida.= '<td class = "text-center">'.$fecha.'</td>';
				//monto
				$monto = $row["fac_monto"];
				$monto = number_format($monto,2,'.','');
				$salida.= '<td class = "text-center text-muted">Q. '.$monto.' (no+)</td>';
				//factura
				$serie = $row["ser_numero"];
				$numero = $row["fac_numero"];
				$salida.= '<td class = "text-center">'.$serie.' '.$numero.'</td>';
				//NIT
				$nit = utf8_decode($row["alu_nit"]);
				$salida.= '<td class = "text-center">'.$nit.'</td>';
				//Cliente
				$cliente = utf8_decode($row["alu_cliente_nombre"]);
				$salida.= '<td class = "text-left">'.$cliente.'</td>';
				//colegiatura
				$salida.= '<td class = "text-center"><strong class = "text-danger"><i class = "fa fa-ban"></i> ANULADA</strong></td>';
				//concepto
				$salida.= '<td class = "text-center"><strong class = "text-danger"><i class = "fa fa-ban"></i> ANULADA</strong></td>';
				//--
				$salida.= '</tr>';
				$i++;
			}	
		}
		///----
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
			$salida.= '<th class = "text-center text-info">Q. '.$ingresos.'</td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '</tr>';
			//--
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_cargos($division,$grupo,$tipo,$anio,$periodo,$mes_reporte,$nivel,$grado,$seccion){
	$ClsBol = new ClsBoletaCobro();
	$ClsIns = new ClsInscripcion();
	$ClsPen = new ClsPensum();
	$ClsPer = new ClsPeriodoFiscal();
	if($periodo != "" && $anio == ""){
		$pensum = $ClsPer->get_pensum_periodo($periodo);
	}else if($anio != ""){
		$pensum = $ClsPen->get_pensum_anio($anio);	
	}else{
		$pensum = $_SESSION["pensum"];
	}
	$result = $ClsBol->get_cartera($division,$grupo,$tipo,$anio,$periodo,$mes_reporte,$pensum,$nivel,$grado,$seccion);
	if(is_array($result)){
		$salida.= '<div class="scroll-container">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px">CUI</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "100px">GRADO</th>';
		//--
		if($mes_reporte == 1 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">ENERO</th>';
		}
		if($mes_reporte == 2 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">FEBRERO</th>';
		}
		if($mes_reporte == 3 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">MARZO</th>';
		}
		if($mes_reporte == 4 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">ABRIL</th>';
		}
		if($mes_reporte == 5 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">MAYO</th>';
		}
		if($mes_reporte == 6 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">JUNIO</th>';
		}
		if($mes_reporte == 7 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">JULIO</th>';
		}
		if($mes_reporte == 8 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">AGOSTO</th>';
		}
		if($mes_reporte == 9 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">SEPTIEMBRE</th>';
		}
		if($mes_reporte == 10 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">OCTUBRE</th>';
		}
		if($mes_reporte == 11 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">NOVIEMBRE</th>';
		}
		if($mes_reporte == 12 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">DICIEMBRE</th>';
		}
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//cui
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//grado
			$grado = utf8_decode($row["gra_descripcion"]);
			$seccion = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-left">'.$grado.' '.$seccion.'</td>';
			if($mes_reporte == 1 || $mes_reporte == 13){
			//mes
			$mes = ($row["cargos_enero"]+$row["descuentos_enero"]);
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 2 || $mes_reporte == 13){
			//mes
			$mes = $row["cargos_febrero"]+$row["descuentos_febrero"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 3 || $mes_reporte == 13){
			//mes
			$mes = $row["cargos_marzo"]+$row["descuentos_marzo"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 4 || $mes_reporte == 13){
			//mes
			$mes = $row["cargos_abril"]+$row["descuentos_abril"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 5 || $mes_reporte == 13){
			//mes
			$mes = $row["cargos_mayo"]+$row["descuentos_mayo"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 6 || $mes_reporte == 13){
			//mes
			$mes = $row["cargos_junio"]+$row["descuentos_junio"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 7 || $mes_reporte == 13){
			//mes
			$mes = $row["cargos_julio"]+$row["descuentos_julio"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 8 || $mes_reporte == 13){
			//mes
			$mes = $row["cargos_agosto"]+$row["descuentos_agosto"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 9 || $mes_reporte == 13){
			//mes
			$mes = $row["cargos_septiembre"]+$row["descuentos_septiembre"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 10 || $mes_reporte == 13){
			//mes
			$mes = $row["cargos_octubre"]+$row["descuentos_octubre"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 11 || $mes_reporte == 13){
			//mes
			$mes = $row["cargos_noviembre"]+$row["descuentos_noviembre"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 12 || $mes_reporte == 13){
			//mes
			$mes = $row["cargos_diciembre"]+$row["descuentos_diciembre"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			//--
			$salida.= '</tr>';
			$i++;
		}
		//--
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}




function tabla_descuentos($division,$grupo,$tipo,$anio,$periodo,$mes_reporte,$nivel,$grado,$seccion){
	$ClsBol = new ClsBoletaCobro();
	$ClsIns = new ClsInscripcion();
	$ClsPen = new ClsPensum();
	$ClsPer = new ClsPeriodoFiscal();
	if($periodo != "" && $anio == ""){
		$pensum = $ClsPer->get_pensum_periodo($periodo);
	}else if($anio != ""){
		$pensum = $ClsPen->get_pensum_anio($anio);	
	}else{
		$pensum = $_SESSION["pensum"];
	}
	$result = $ClsBol->get_cartera($division,$grupo,$tipo,$anio,$periodo,$mes_reporte,$pensum,$nivel,$grado,$seccion);
	//echo "$mes <br>";
	if(is_array($result)){
		$salida.= '<div class="scroll-container">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px">CUI</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "100px">GRADO</th>';
		//--
		if($mes_reporte == 1 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">ENERO</th>';
		}
		if($mes_reporte == 2 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">FEBRERO</th>';
		}
		if($mes_reporte == 3 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">MARZO</th>';
		}
		if($mes_reporte == 4 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">ABRIL</th>';
		}
		if($mes_reporte == 5 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">MAYO</th>';
		}
		if($mes_reporte == 6 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">JUNIO</th>';
		}
		if($mes_reporte == 7 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">JULIO</th>';
		}
		if($mes_reporte == 8 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">AGOSTO</th>';
		}
		if($mes_reporte == 9 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">SEPTIEMBRE</th>';
		}
		if($mes_reporte == 10 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">OCTUBRE</th>';
		}
		if($mes_reporte == 11 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">NOVIEMBRE</th>';
		}
		if($mes_reporte == 12 || $mes_reporte == 13){
		$salida.= '<th class = "text-center" width = "30px">DICIEMBRE</th>';
		}
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//cui
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//grado
			$grado = utf8_decode($row["gra_descripcion"]);
			$seccion = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-left">'.$grado.' '.$seccion.'</td>';
			if($mes_reporte == 1 || $mes_reporte == 13){
			//mes
			$mes = $row["descuentos_enero"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 2 || $mes_reporte == 13){
			//mes
			$mes = $row["descuentos_febrero"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 3 || $mes_reporte == 13){
			//mes
			$mes = $row["descuentos_marzo"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 4 || $mes_reporte == 13){
			//mes
			$mes = $row["descuentos_abril"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 5 || $mes_reporte == 13){
			//mes
			$mes = $row["descuentos_mayo"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 6 || $mes_reporte == 13){
			//mes
			$mes = $row["descuentos_junio"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 7 || $mes_reporte == 13){
			//mes
			$mes = $row["descuentos_julio"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 8 || $mes_reporte == 13){
			//mes
			$mes = $row["descuentos_agosto"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 9 || $mes_reporte == 13){
			//mes
			$mes = $row["descuentos_septiembre"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 10 || $mes_reporte == 13){
			//mes
			$mes = $row["descuentos_octubre"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 11 || $mes_reporte == 13){
			//mes
			$mes = $row["descuentos_noviembre"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			if($mes_reporte == 12 || $mes_reporte == 13){
			//mes
			$mes = $row["descuentos_diciembre"];
			$mes = number_format($mes,2,'.','');
			$salida.= '<td class = "text-right">Q. '.$mes.'</td>';
			}
			//--
			$salida.= '</tr>';
			$i++;
		}
		//--
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_cartera($division,$grupo,$tipo,$anio,$periodo,$nivel,$grado,$seccion){
	$ClsBol = new ClsBoletaCobro();
	$ClsIns = new ClsInscripcion();
	$ClsPen = new ClsPensum();
	$ClsPer = new ClsPeriodoFiscal();
	if($periodo != "" && $anio == ""){
		$pensum = $ClsPer->get_pensum_periodo($periodo);
	}else if($anio != ""){
		$pensum = $ClsPen->get_pensum_anio($anio);	
	}else{
		$pensum = $_SESSION["pensum"];
	}
	$mes_reporte = 13;
	$result = $ClsBol->get_cartera($division,$grupo,$tipo,$anio,$periodo,$mes_reporte,$pensum,$nivel,$grado,$seccion);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px">CUI</td>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "100px">GRADO</td>';
		$salida.= '<th class = "text-center" width = "30px">ENERO</td>';
		$salida.= '<th class = "text-center" width = "30px">FEBRERO</td>';
		$salida.= '<th class = "text-center" width = "30px">MARZO</td>';
		$salida.= '<th class = "text-center" width = "30px">ABRIL</td>';
		$salida.= '<th class = "text-center" width = "30px">MAYO</td>';
		$salida.= '<th class = "text-center" width = "30px">JUNIO</td>';
		$salida.= '<th class = "text-center" width = "30px">JULIO</td>';
		$salida.= '<th class = "text-center" width = "30px">AGOSTO</td>';
		$salida.= '<th class = "text-center" width = "30px">SEPTIEMBRE</td>';
		$salida.= '<th class = "text-center" width = "30px">OCTUBRE</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//cui
			$cui = trim($row["alu_cui"]);
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//grado
			$grado = utf8_decode($row["gra_descripcion"]);
			$seccion = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-left">'.$grado.' '.$seccion.'</td>';
			//mes
			$cargo = $row["cargos_enero"];
			$pago = $row["pagos_enero"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
				$saldo = '<strong class = "text-info">+ Q. '.number_format($saldo,2,'.','').'</strong>';
			}else{
				$saldo = 'Q. '.number_format($saldo,2,'.','');	
			}
			$salida.= '<td class = "text-right">'.$saldo.'</td>';
			//mes
			$cargo = $row["cargos_febrero"];
			$pago = $row["pagos_febrero"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
				$saldo = '<strong class = "text-info">+ Q. '.number_format($saldo,2,'.','').'</strong>';
			}else{
				$saldo = 'Q. '.number_format($saldo,2,'.','');	
			}
			$salida.= '<td class = "text-right">'.$saldo.'</td>';
			//mes
			$cargo = $row["cargos_marzo"];
			$pago = $row["pagos_marzo"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
				$saldo = '<strong class = "text-info">+ Q. '.number_format($saldo,2,'.','').'</strong>';
			}else{
				$saldo = 'Q. '.number_format($saldo,2,'.','');	
			}
			$salida.= '<td class = "text-right">'.$saldo.'</td>';
			//mes
			$cargo = $row["cargos_abril"];
			$pago = $row["pagos_abril"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
				$saldo = '<strong class = "text-info">+ Q. '.number_format($saldo,2,'.','').'</strong>';
			}else{
				$saldo = 'Q. '.number_format($saldo,2,'.','');	
			}
			$salida.= '<td class = "text-right">'.$saldo.'</td>';
			//mes
			$cargo = $row["cargos_mayo"];
			$pago = $row["pagos_mayo"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
				$saldo = '<strong class = "text-info">+ Q. '.number_format($saldo,2,'.','').'</strong>';
			}else{
				$saldo = 'Q. '.number_format($saldo,2,'.','');	
			}
			$salida.= '<td class = "text-right">'.$saldo.'</td>';
			//mes
			$cargo = $row["cargos_junio"];
			$pago = $row["pagos_junio"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
				$saldo = '<strong class = "text-info">+ Q. '.number_format($saldo,2,'.','').'</strong>';
			}else{
				$saldo = 'Q. '.number_format($saldo,2,'.','');	
			}
			$salida.= '<td class = "text-right">'.$saldo.'</td>';
			//mes
			$cargo = $row["cargos_julio"];
			$pago = $row["pagos_julio"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
				$saldo = '<strong class = "text-info">+ Q. '.number_format($saldo,2,'.','').'</strong>';
			}else{
				$saldo = 'Q. '.number_format($saldo,2,'.','');	
			}
			$salida.= '<td class = "text-right">'.$saldo.'</td>';
			//mes
			$cargo = $row["cargos_agosto"];
			$pago = $row["pagos_agosto"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
				$saldo = '<strong class = "text-info">+ Q. '.number_format($saldo,2,'.','').'</strong>';
			}else{
				$saldo = 'Q. '.number_format($saldo,2,'.','');	
			}
			$salida.= '<td class = "text-right">'.$saldo.'</td>';
			//mes
			$cargo = $row["cargos_septiembre"];
			$pago = $row["pagos_septiembre"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
				$saldo = '<strong class = "text-info">+ Q. '.number_format($saldo,2,'.','').'</strong>';
			}else{
				$saldo = 'Q. '.number_format($saldo,2,'.','');	
			}
			$salida.= '<td class = "text-right">'.$saldo.'</td>';
			//mes
			$cargo = $row["cargos_octubre"];
			$pago = $row["pagos_octubre"];
			$saldo = floatval($cargo - $pago);
			if($saldo == 0){
				$saldo = '';
			}else if($saldo < 0){
				$saldo = ($saldo*-1);
				$saldo = '<strong class = "text-info">+ Q. '.number_format($saldo,2,'.','').'</strong>';
			}else{
				$saldo = 'Q. '.number_format($saldo,2,'.','');	
			}
			$salida.= '<td class = "text-right">'.$saldo.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		//--
		$salida.= '</table>';
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
		$salida.= '<th class = "text-center" width = "40px">COD. PAGO</th>';
		$salida.= '<th class = "text-center" width = "30px">BOLETA No.</td>';
		$salida.= '<th class = "text-center" width = "30px">REFERENCIA No.</td>';
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
			$boleta = $row["pag_programado"];
			$cuenta = $row["pag_cuenta"];
			$banco = $row["pag_banco"];
			$alumno = $row["pag_alumno"];
			$monto_total = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			//--comprueba
			$comprueba_boleta = $row["bol_codigo"];
			$valida_boleta = ($comprueba_boleta == $boleta)?1:"";
			///comprueba exitencia de alumno
			if($row["alu_cui"] != ""){
				$comprueba_alumno = $row["alu_cui"];
			}else if($row["alu_inscripciones_cui"] != ""){ //comprueba existencia de alumno (en modulo de inscripciones / no activo en el sistema)
				$comprueba_alumno = $row["alu_inscripciones_cui"];
			}else{
				$valida_alumno = "";
			}
			$valida_alumno = ($comprueba_alumno == $alumno)?$alumno:"";
			$valida_monto = $row["bol_monto"];
			if($valida_boleta == false && $valida_alumno == ""){
				$class = "danger";
				$disabled2 = "";
			}else if($valida_boleta == true && $valida_alumno != "" && $valida_monto != $monto_total){
				$class = "info";
				$disabled = "";
				$disabled2 = "";
			}else if($valida_boleta == true && $valida_alumno != "" && $valida_monto == $monto_total){
				$class = "";
				$iconos = ' <span class="fa fa-check text-success" title ="Datos Correctos"></span> ';
				$disabled = "disabled";
				$disabled2 = "disabled";
			}else{
				$class = "warning";
				$disabled2 = "";
			}
			//valida iconos a desplegar
			if($valida_boleta == false){
				$iconos.= ' <span class="fa fa-file-text text-danger" title ="No existe el numero de boleta"></span> ';
				$errores_boleta++;
			}
			if($valida_alumno == ""){
				$iconos.= ' <span class="fa fa-user text-danger" title ="No existe el alumno"></span> ';
				$errores_alumnos++;
			}
			if($valida_boleta == true && ($valida_monto != $monto_total)){
				$iconos.= ' <span class="fa fa-dollar text-info" title ="El monto de la boleta no coincide con el monto depositado"></span> ';
				$errores_monto++;
			}
			//--------
			$salida.= '<tr class="'.$class.'">';
			//--
			$salida.= '<td class = "text-center">'.$iconos.'</td>';
			//transaccion
			$transaccion = $row["pag_codigo"];
			$transaccion = ($transaccion != "")? $transaccion : "---"; /// valida que si el dato es nulo o vacion coloca 0
			$salida.= '<td class = "text-center" >'.$transaccion.'</td>';
			//boleta
			$boleta = Agrega_Ceros($row["pag_programado"]);
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//refernecia
			$referencia = trim($row["pag_referencia"]);
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//alumno
			$alumno = $row["pag_alumno"];
			$salida.= '<td class = "text-center" >'.$alumno.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
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
				$salida.= ' '.$errores_boleta.' No. de Boleta(s) fueron digitados incorrectamente en este listado de carga electr&oacute;nica...';
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



function tabla_ventas($periodo,$division,$grupo,$referencia,$alumno,$desde,$hasta){
	$ClsPen = new ClsPensum();
	$ClsBol = new ClsBoletaCobro();
	$ClsPer = new ClsPeriodoFiscal();
	if($periodo != "" && $anio == ""){
		$pensum = $ClsPer->get_pensum_periodo($periodo);
	}else if($anio != ""){
		$pensum = $ClsPen->get_pensum_anio($anio);	
	}else{
		$pensum = $_SESSION["pensum"];
	}
	
	$result = $ClsBol->get_det_venta_producto('',$referencia,$division,$grupo,$tipo,$alumno,'','',$desde,$hasta,'',1);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "10px"></th>';
		$salida.= '<th class = "text-center" width = "10px"></th>';
		$salida.= '<th class = "text-center" width = "50px">CUI</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "70px">FACTURA</th>';
		$salida.= '<th class = "text-center" width = "30px">BOLETA</td>';
		$salida.= '<th class = "text-center" width = "30px">REFERENCIA</td>';
		$salida.= '<th class = "text-center" width = "70px">SITUACI&Oacute;N</td>';
		$salida.= '<th class = "text-center" width = "100px">GRADO</th>';
		$salida.= '<th class = "text-center" width = "100px">FECHA/PAGO</th>';
		$salida.= '<th class = "text-center" width = "30px">CANTIDAD</th>';
		$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</th>';
		$salida.= '<th class = "text-center" width = "30px">SUBTOTAL</th>';
		$salida.= '<th class = "text-center" width = "30px">DESCUENTO</th>';
		$salida.= '<th class = "text-center" width = "30px">TOTAL</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$num = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//--
			$cod = $row["bol_codigo"];
            $cue = $row["bol_cuenta"];
            $ban = $row["bol_banco"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($cod, $usu);
			//
			$num = $row["fac_numero"];
			$ser = $row["fac_serie"];
			$hashkey4 = $ClsBol->encrypt($num, $usu);
			$hashkey5 = $ClsBol->encrypt($ser, $usu);
			$disabled = ($num != "" && $ser != "")?"":"disabled";
			//--
			$codigo = "$cod-$cue-$ban";
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-default btn-xs" title="Imprimir Boleta" href = "../../../CONFIG/BOLETAS/REPboleta.php?hashkey='.$hashkey.'" target = "_blank" ><span class="fa fa-print"></span></a> ';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-info btn-outline btn-xs" title="Imprimir Factura" href = "REPfactura.php?hashkey1='.$hashkey4.'&hashkey2='.$hashkey5.'" target = "_blank" '.$disabled.' ><span class="fa fa-copy"></span></a> ';
			$salida.= '</td>';
			//CUI
			$cui = $row["bol_alumno"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left">'.$alumno.'</td>';
			//factura
			$ser = $row["fac_serie_numero"];
			$num = $row["fac_numero"];
			$salida.= '<td class = "text-center">'.$ser.' '.$num.'</td>';
			//boleta
			$boleta = $row["bol_codigo"];
			$salida.= '<td class = "text-center">'.$boleta.'</td>';
			//referencia
			$referencia = $row["bol_referencia"];
			$salida.= '<td class = "text-center">'.$referencia.'</td>';
			//situacion
			$pagado = trim($row["bol_pagado"]);
			if($pagado == 1){
				$situacion = '<strong class="text-success">Pagado</strong>';
			}else{
				$situacion = '<span class="text-muted">Pendiente</span>';
			}
			$salida.= '<td class = "text-center">'.$situacion.'</td>';
			//grado
			$grado = utf8_decode($row["alu_grado_descripcion"]);
			$seccion = utf8_decode($row["alu_seccion_descripcion"]);
			$salida.= '<td class = "text-left">'.$grado.' '.$seccion.'</td>';
			//fecha de pago
			$fecha = $row["bol_fecha_pago"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//cantidad
			$cantidad = utf8_decode($row["dven_cantidad"]);
			$salida.= '<td class = "text-center">'.$cantidad.'</td>';
			//Motivo
			$motivo = utf8_decode($row["art_nombre"])." ".utf8_decode($row["art_desc"])." / ".utf8_decode($row["art_marca"]);
			$salida.= '<td class = "text-justify">'.$motivo.'</td>';
			//subtotal
			$monto = $row["dven_subtotal"];
			$monto = number_format($monto, 2, '.', '');
			$salida.= '<td class = "text-center">'.$monto.'</td>';
			//descuento
			$monto = $row["dven_descuento"];
			$monto = number_format($monto, 2, '.', '');
			$salida.= '<td class = "text-center">'.$monto.'</td>';
			//total
			$monto = $row["dven_total"];
			$monto = number_format($monto, 2, '.', '');
			$salida.= '<td class = "text-center">'.$monto.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_morosos($division,$grupo,$periodo,$tipo,$pensum,$nivel,$grado,$seccion,$desde,$hasta){
	$ClsBol = new ClsBoletaCobro();
	$ClsPer = new ClsPeriodoFiscal();
	$periodo_activo = $ClsPer->get_periodo_activo();
	if($periodo != ""){
		$pensum = $ClsPer->get_pensum_periodo($periodo);
	}else{
		$pensum = $_SESSION["pensum"];
	}
	
	$result = $ClsBol->get_morosos($desde,$hasta,$pensum,$division,$grupo, $periodo, $periodo_activo, $nivel,$grado,$seccion);
	if(is_array($result)){
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px">CUI</td>';
		$salida.= '<th class = "text-center" width = "170px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "100px">GRADO</td>';
		$salida.= '<th class = "text-center" width = "40px">PROGRAMADO</td>';
		$salida.= '<th class = "text-center" width = "40px">PAGADO</td>';
		$salida.= '<th class = "text-center" width = "40px">SALDO</td>';
		$salida.= '<th class = "text-center" width = "50px"></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$programado = $row["pagos_programados"];
			$pagado = $row["pagos_ejecutados"];
			$saldo = ($programado - $pagado);
			if($saldo > 0){
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center">'.$i.'.</td>';
				//cui
				$cui = $row["alu_cui"];
				$salida.= '<td class = "text-center">'.$cui.'</td>';
				//nombre
				$nombre = utf8_decode($row["alu_nombre"]);
				$apellido = utf8_decode($row["alu_apellido"]);
				$salida.= '<td class = "text-left">'.$nombre.' '.$apellido.'</td>';
				//grado
				$grado = utf8_decode($row["gra_descripcion"]);
				$seccion = utf8_decode($row["sec_descripcion"]);
				$salida.= '<td class = "text-left">'.$grado.' '.$seccion.'</td>';
				//programado
				$programado = $row["pagos_programados"];
				$progra = number_format($programado,2,'.',',');
				$salida.= '<td class = "text-center">Q.'.$progra.'</td>';
				//programado
				$pagado = $row["pagos_ejecutados"];
				$pago = number_format($pagado,2,'.',',');
				$salida.= '<td class = "text-center">Q.'.$pago.'</td>';
				//programado
				$saldo = ($programado - $pagado);
				$saldo = number_format($saldo,2,'.',',');
				$salida.= '<td class = "text-center"><label class = "text-danger">Q.'.$saldo.'</label></td>';
				//--
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsBol->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-info btn-xs" href="../../../CONFIG/BOLETAS/REPcuenta.php?hashkey='.$hashkey.'&periodo='.$periodo.'" target = "_blank" title = "Ver Estado de Cuenta" > <span class="fa fa-copy"></span></a> ';
				$salida.= '<a class="btn btn-success btn-xs" href="../../../CONFIG/BOLETAS/REPcuenta_detallado.php?hashkey='.$hashkey.'&periodo='.$periodo.'" target = "_blank" title = "Ver Estado de Cuenta Detallado" > <span class="fa fa-copy"></span></a> ';
				$salida.= '<a class="btn btn-primary btn-xs" href="REPalumno_padres.php?hashkey='.$hashkey.'" title = "Ver informaci&oacute;n de los padres o encargados" > <span class="fa fa-group"></span></a> ';
				$salida.= '</td>';
				//--
				$salida.= '</tr>';
				$i++;
			}	
		}
		//--
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_solventes($periodo,$division,$grupo,$anio,$nivel,$grado,$seccion,$hasta){
	$ClsBol = new ClsBoletaCobro();
	$ClsPen = new ClsPensum();
	$ClsPer = new ClsPeriodoFiscal();
	$periodo_activo = $ClsPer->get_periodo_activo();
	if($periodo != "" && $anio == ""){
		$pensum = $ClsPer->get_pensum_periodo($periodo);
	}else if($anio != ""){
		$pensum = $ClsPen->get_pensum_anio($anio);
		$anioR= $anio - 1;
		$desde = "01/01/$anioR";
	}else{
		$pensum = $_SESSION["pensum"];
	}
	
	$result = $ClsBol->get_morosos($desde,$hasta,$pensum,$division,$grupo,$periodo,$periodo_activo,$nivel,$grado,$seccion);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px">CUI</td>';
		$salida.= '<th class = "text-center" width = "170px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "100px">GRADO</td>';
		$salida.= '<th class = "text-center" width = "40px">PROGRAMADO</td>';
		$salida.= '<th class = "text-center" width = "40px">PAGADO</td>';
		$salida.= '<th class = "text-center" width = "40px">SALDO</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$programado = $row["pagos_programados"];
			$pagado = $row["pagos_ejecutados"];
			$saldo = ($programado - $pagado);
			if($saldo <= 0){
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center">'.$i.'.</td>';
				//cui
				$cui = $row["alu_cui"];
				$salida.= '<td class = "text-center">'.$cui.'</td>';
				//nombre
				$nombre = utf8_decode($row["alu_nombre"]);
				$apellido = utf8_decode($row["alu_apellido"]);
				$salida.= '<td class = "text-left">'.$nombre.' '.$apellido.'</td>';
				//grado
				$grado = utf8_decode($row["gra_descripcion"]);
				$seccion = utf8_decode($row["sec_descripcion"]);
				$salida.= '<td class = "text-left">'.$grado.' '.$seccion.'</td>';
				//programado
				$programado = $row["pagos_programados"];
				$progra = number_format($programado,2,'.',',');
				$salida.= '<td class = "text-center">Q.'.$progra.'</td>';
				//programado
				$pagado = $row["pagos_ejecutados"];
				$pago = number_format($pagado,2,'.',',');
				$salida.= '<td class = "text-center">Q.'.$pago.'</td>';
				//programado
				$saldo = ($programado - $pagado);
				$saldo = ($saldo < 0)?($saldo*-1):$saldo;
				$saldo = number_format($saldo,2,'.',',');
				$salida.= '<td class = "text-center"><label class = "text-success">Q.'.$saldo.'</label></td>';
				//--
				$salida.= '</tr>';
				$i++;
			}	
		}
		//--
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_moras($division,$grupo,$empresa,$nivel,$grado,$seccion,$pagado){
	$ClsBol = new ClsBoletaCobro();
	$ClsPer = new ClsPeriodoFiscal();
	if($periodo != "" && $anio == ""){
		$pensum = $ClsPer->get_pensum_periodo($periodo);
	}else if($anio != ""){
		$pensum = $ClsPen->get_pensum_anio($anio);
		$desde = "01/01/$anio";
	}else{
		$pensum = $_SESSION["pensum"];
	}
	
	$result = $ClsBol->get_mora('',$division,$grupo,'',$nivel,$grado,$seccion,'', $anio, $empresa, '', '', 1, '',$pagado);
	if(is_array($result)){
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px">CUI</td>';
		$salida.= '<th class = "text-center" width = "170px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "100px">GRADO</td>';
		$salida.= '<th class = "text-center" width = "40px">FECHA DE GENERACI&Oacute;N</td>';
		$salida.= '<th class = "text-center" width = "40px">MONTO</td>';
		$salida.= '<th class = "text-center" width = "150px">MOTIVO</td>';
		$salida.= '<th class = "text-center" width = "50px">SITUACI&Oacute;N</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//cui
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nombre.' '.$apellido.'</td>';
			//grado
			$grado = utf8_decode($row["gra_descripcion"]);
			$seccion = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-left">'.$grado.' '.$seccion.'</td>';
			//fecha de registro
			$freg = $row["bol_fecha_registro"];
			$freg = cambia_fechaHora($freg);
			$salida.= '<td class = "text-center">'.$freg.'</td>';
			//Monto
			$monto = $row["bol_monto"];
			$monto = number_format($monto,2,'.',',');
			$salida.= '<td class = "text-center">Q.'.$monto.'</td>';
			//motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			$salida.= '<td class = "text-left">'.$motivo.'</td>';
			//pagado
			$pagado = trim($row["bol_pagado"]);
			$pagado = ($pagado == 1)?'<span class="text-success">Pagado</span>':'<span class="text-muted">Pendiente de Pago</span>';
			$salida.= '<td class = "text-center">'.$pagado.'</td>';
			//--
			$salida.= '</tr>';
			$i++;	
		}
		//--
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_antiguedad_saldos($division,$grupo,$periodo,$tipo,$desde,$hasta){
	$ClsBol = new ClsBoletaCobro();
	
	$result = $ClsBol->get_boleta_cobro($codigo, $division,$grupo, '', '', $periodo, '', $desde, $hasta, 1, 2, 0, $tipo);
	if(is_array($result)){
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px">CUI</td>';
		$salida.= '<th class = "text-center" width = "170px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "100px">GRADO</td>';
		$salida.= '<th class = "text-center" width = "40px">BOLETA PENDIENTE</td>';
		$salida.= '<th class = "text-center" width = "40px">MONTO</td>';
		$salida.= '<th class = "text-center" width = "40px">FECHA/PAGO</td>';
		$salida.= '<th class = "text-center" width = "40px">D&Iacute;AS/RETRASO</td>';
		$salida.= '<th class = "text-center" width = "40px">MES</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//cui
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nombre.' '.$apellido.'</td>';
			//grado
			$grado = utf8_decode($row["alu_grado_descripcion"]);
			$seccion = utf8_decode($row["alu_seccion_descripcion"]);
			$salida.= '<td class = "text-left">'.$grado.' '.$seccion.'</td>';
			//boleta
			$boleta = trim($row["bol_codigo"]);
			$salida.= '<td class = "text-center">'.$boleta.'</td>';
			//monto
			$monto = trim($row["bol_monto"]);
			$monto = number_format($monto,2,'.',',');
			$salida.= '<td class = "text-center">Q.'.$monto.'</td>';
			//fecha
			$fecha = trim($row["bol_fecha_pago"]);
			$mes = substr($fecha,5,2);
			$ahora = date("Y-m-d");
			$dias = restaFechas($fecha, $ahora);
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//dias
			$salida.= '<td class = "text-center">'.$dias.'</td>';
			//mes
			$mes = Meses_Letra($mes);
			$salida.= '<td class = "text-center">'.$mes.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		//--
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}

?>
