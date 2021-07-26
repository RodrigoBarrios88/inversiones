<?php 
include_once('../html_fns.php');

function tabla_filas_venta($pv,$suc,$ventMonDesc,$ventMonSimb,$ventMonCambio,$tfdsc,$fdsc){
	
	$ClsVent = new ClsVenta();
	$result = $ClsVent->get_detalle_temporal($pv,$suc);
	//Tratamiento de la cadena de moneda
	$salida.= '<table class="table table-striped table-bordered table-hover">';
	$salida.= '<tr>';
	$salida.= '<th class = "text-center"  width = "30px">No.</td>';
	$salida.= '<th class = "text-center"  width = "75px">Cantidad</td>';
	$salida.= '<th class = "text-center"  width = "300px">Descipci&oacute;n</td>';
	$salida.= '<th class = "text-center"  width = "75px">Prec. Unitario</td>';
	$salida.= '<th class = "text-center"  width = "75px">Descuento</td>';
	$salida.= '<th class = "text-center"  width = "75px">Monto</td>';
	$salida.= '<th class = "text-center"  width = "30px"></td>';
	$salida.= '</tr>';
	$STotal = 0;
	$DescU = 0;
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Cantidad
			$cant = $row["dventemp_cantidad"];
			$tipo = $row["dventemp_tipo"];
			$salida.= '<td class = "text-center" ><span id = "spancant'.$i.'">'.$cant.'</span></td>';
			//Descripcion o Articulo
			$art = trim($row["dventemp_articulo"]);
			$grupo = trim($row["dventemp_grupo"]);
			$descripcion = utf8_decode($row["dventemp_detalle"]);
			$salida.= '<td class = "text-left">'.$descripcion.'</td>';
			//Precio U.
			$mons = trim($row["mon_simbolo"]);
			$precio = trim($row["dventemp_precio"]);
			$precio = number_format($precio, 2, '.', '');
			$salida.= '<td class = "text-center" >'.$mons.' '.$precio.'</td>';
			//Descuento
			$desc = trim($row["dventemp_descuento"]);
			$DescU+= $desc;
			$desc = number_format($desc, 2, '.', '');
			$salida.= '<td class = "text-center" >'.$mons.' '.$desc.'</td>';
			//sub Total
			$total = trim($row["dventemp_total"]);
			$tcambio = trim($row["dventemp_tcambio"]);
			$Rcambiar = Cambio_Moneda($tcambio,$ventMonCambio,$total);
			$STotal+= $Rcambiar;
			$total = number_format($total, 2, '.', '');
			$salida.= '<td class = "text-center" ><span id = "spanstot'.$i.'">'.trim($mons).' '.$total.'</span></td>';
			//---
			$cod = $row["dventemp_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "xajax_Quita_Fila_Venta('.$cod.','.$pv.','.$suc.');" title = "Quitar Fila" ><i class="fa fa-trash"></i></button>';
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
		$i--;
	}		
			//----
			if($tfdsc == "P"){
				$descuento = ($STotal *($fdsc)/100);
			}else if($tfdsc == "M"){
			        $descuento = $fdsc;
			}
			
			$Total = $STotal - $descuento;
			$descuento = number_format($descuento, 2, '.', '');// descuento General
			$STotal = number_format($STotal, 2, '.', ''); //total sin iva
			$Total = number_format($Total, 2, '.', ''); //total sin iva
			$DescU = number_format($DescU, 2, '.', ''); //promedio de descuento
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "3" rowspan = "4">';
			$salida.= '<span id = "spannota">';
			$salida.= '<b>NOTA:</b> MONEDA PARA FACTURACI&Oacute;N: <b>'.$ventMonDesc.'</b>. TIPO DE CAMBIO '.$ventMonCambio.' x 1';
			$salida.= '</span></td>';
			$salida.= '<td class = "text-center">Desc/Unitarios</td>';
			$salida.= '<td class = "text-center" ><b><span id = "spanpromdesc">'.$ventMonSimb.' '.$DescU.'</span></b></td>';
			$salida.= '<td class = "text-center" >-</td>';
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "hidden" name = "promdesc" id = "promdesc" value = "'.$DescU.'" /></td>';
			$salida.= '</td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">Subtotal</td>';
			$salida.= '<td class = "text-center" >-</td>';
			$salida.= '<td class = "text-center" ><b><span id = "spanstotal">'.$ventMonSimb.' '.$STotal.'</span></b>';
			$salida.= '<input type = "hidden" name = "stotal" id = "stotal" value = "'.$STotal.'" />';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">Desc/General</td>';
			$salida.= '<td class = "text-center" >-</td>';
			$salida.= '<td class = "text-center" ><b><span id = "spandscgeneral">'.$ventMonSimb.' '.$descuento.'</span></b>';
			$salida.= '<input type = "hidden" name = "tdescuento" id = "tdescuento" value = "'.$descuento.'" />';
			$salida.= '<input type = "hidden" name = "ttdescuento" id = "ttdescuento" value = "'.$tfdsc.'" />';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">TOTAL</td>';
			$salida.= '<td class = "text-center" >-</td>';
			$salida.= '<td class = "text-center" ></b><span id = "spanttotal">'.$ventMonSimb.' '.$Total.'</span></b>';
			$salida.= '<input type = "hidden" name = "ttotal" id = "ttotal" value = "'.$Total.'" />';
			$salida.= '<input type = "hidden" name = "Rtotal" id = "Rtotal" value = "'.$Rtotal.'" />';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'"/>';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
	
	return $salida;
}


function tabla_filas_venta_pago($filas,$tpago,$monto,$moneda,$tcambio,$opera,$boucher,$observ,$tcambiodia){
		//convierte strig plano en array
		$tpago = explode("|", $tpago);
		$monto = explode("|", $monto);
		$moneda = explode("|", $moneda);
		$tcambio = explode("|", $tcambio);
		$opera = explode("|", $opera);
		$boucher = explode("|", $boucher);
		$observ = explode("|", $observ);
		//----
			$salida.= '<table>';
	$i = 1;	
	$total = 0;
	if($filas>0){
		for($i = 1; $i <= $filas; $i ++){
			//acumulado
			$Dcambiar = 0;
			$Dcambiar = Cambio_Moneda($tcambio[$i],$tcambiodia,$monto[$i]);
			$total += $Dcambiar;
			//-
			$salida.= '<td>';
			$salida.= '<input type = "hidden" name = "Ttpag'.$i.'" id = "Ttpag'.$i.'" value = "'.$tpago[$i].'" />';
			$salida.= '<input type = "hidden" name = "Tmonto'.$i.'" id = "Tmonto'.$i.'" value = "'.$monto[$i].'" />';
			$salida.= '<input type = "hidden" name = "Tmoneda'.$i.'" id = "Tmoneda'.$i.'" value = "'.$moneda[$i].'" />';
			$salida.= '<input type = "hidden" name = "Ttipcambio'.$i.'" id = "Ttipcambio'.$i.'"  value = "'.$tcambio[$i].'" />';
			$salida.= '<input type = "hidden" name = "Toperador'.$i.'" id = "Toperador'.$i.'" value = "'.$opera[$i].'" />';
			$salida.= '<input type = "hidden" name = "Tboucher'.$i.'" id = "Tboucher'.$i.'" value = "'.$boucher[$i].'" />';
			$salida.= '<input type = "hidden" name = "Tobserva'.$i.'" id = "Tobserva'.$i.'" value = "'.$observ[$i].'" />';
			$salida.= '</td>';
		}
	}		
			//----
			$salida.= '<tr>';
			$salida.= '<td><input type = "hidden" name = "PagFilas" id = "PagFilas" value = "'.$filas.'"/></td>';
			$salida.= '</tr>';
			//----//----
			$salida.= '<tr>';
			$salida.= '<td><input type = "hidden" name = "PagTotal" id = "PagTotal" value = "'.$total.'"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
	
	return $salida;
}



function tabla_inicio_venta_pago($filas){
			//----
			$salida.= '</table>';
	$i = 1;	
	if($filas>0){
		for($i = 1; $i <= $filas; $i ++){
			$salida.= '<td>';
			$salida.= '<input type = "hidden" name = "Ttpag'.$i.'" id = "Ttpag'.$i.'" />';
			$salida.= '<input type = "hidden" name = "Tmonto'.$i.'" id = "Tmonto'.$i.'" />';
			$salida.= '<input type = "hidden" name = "Tmoneda'.$i.'" id = "Tmoneda'.$i.'" />';
			$salida.= '<input type = "hidden" name = "Ttipcambio'.$i.'" id = "Ttipcambio'.$i.'" />';
			$salida.= '<input type = "hidden" name = "Ttipcambio'.$i.'" id = "Ttipcambio'.$i.'" />';
			$salida.= '<input type = "hidden" name = "Toperador'.$i.'" id = "Toperador'.$i.'" />';
			$salida.= '<input type = "hidden" name = "Tboucher'.$i.'" id = "Tboucher'.$i.'" />';
			$salida.= '<input type = "hidden" name = "Tobserva'.$i.'" id = "Tobserva'.$i.'" />';
			$salida.= '</td>';
		}
	}		
			//----
			$salida.= '<tr>';
			$salida.= '<td><input type = "hidden" name = "PagFilas" id = "PagFilas" value = "0"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td><input type = "hidden" name = "PagTotal" id = "PagTotal" value = "0"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
	
	return $salida;
}


function tabla_lista_ventas($result){
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px"></th>';
		$salida.= '<th class = "text-center" width = "10px"></th>';
		$salida.= '<th class = "text-center" width = "60px"># VENTA</th>';
		$salida.= '<th class = "text-center" width = "120px">CLIENTE</th>';
		$salida.= '<th class = "text-center" width = "100px">EMPRESA</th>';
		$salida.= '<th class = "text-center" width = "70px">P. VENTA</th>';
		$salida.= '<th class = "text-center" width = "100px">FECHA/VENTA</th>';
		$salida.= '<th class = "text-center" width = "120px">FECHA/REG.</th>';
		$salida.= '<th class = "text-center" width = "50px">DESCUENTO</th>';
		$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			//codigo
			$sit = $row["ven_situacion"];
			$vent = $row["ven_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-success btn-xs" href = "FRMpago.php?vent='.$vent.'" title = "Seleccionar Venta" ><i class="fa fa-check-square-o"></i></a> ';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary btn-xs" onclick = "Ver_Detalle_Venta('.$vent.');" title = "Ver el Detalle de la Venta" ><span class="fa fa-shopping-cart"></span></button>';
			$salida.= '</td>';
			//Codigo
			$vent = Agrega_Ceros($vent);
			$salida.= '<td class = "text-center" >'.$vent.'</td>';
			//cliente
			$cliente = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left">'.$cliente.'</td>';
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center" >'.$suc.'</td>';
			//punto de venta
			$pv = utf8_decode($row["pv_nombre"]);
			$salida.= '<td class = "text-center" >'.$pv.'</td>';
			//Fecha / venta
			$fec = $row["ven_fecha"];
			$fec = cambia_fecha($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//Fecha / registro
			$fec = $row["ven_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//descuento
			$desc = $row["ven_descuento"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($desc,2,'.','').'</td>';
			//total
			$tot = $row["ven_total"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" ><b>'.$mons.'. '.number_format($tot,2,'.','').'</b></td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
			$i--;
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}else{
		$salida.= '<div class = "row">';
		$salida.= '<div class="col-xs-10 col-xs-offset-1 text-center">';
		$salida.= '<h5 class = "alert alert-info text center"><i class = "fa fa-info-circle"></i> No hay ventas registradas con estos criterios de busqueda, revise la fecha u otro criterio para concretar....</h5>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_creditos($vent,$montext,$tcambio,$monsimbolo,$saldo0 = ''){
	$ClsCred = new ClsCredito();
	$result = $ClsCred->get_credito_venta("",$vent);
	if(is_array($result)){
		$salida.= '<table class="table table-striped table-bordered">';
		$salida.= '<tr>';
		$salida.= '<td class = "text-center" width = "30px"  >No.</td>';
		$salida.= '<td class = "text-center" width = "80px"  ># CREDITO</td>';
		$salida.= '<td class = "text-center" width = "120px"  >FORMA PAG.</td>';
		$salida.= '<td class = "text-center" width = "150px"  >AUTORIZ&Oacute;</td>';
		$salida.= '<td class = "text-center" width = "70px"  >No. DOC.</td>';
		$salida.= '<td class = "text-center" width = "120px"  >FECHA/HORA</td>';
		$salida.= '<td class = "text-center" width = "180px"  >OBSERVACIONES</td>';
		$salida.= '<td class = "text-center" width = "50px"  >MONTO</td>';
		$salida.= '<td class = "text-center" width = "50px"  >T/C</td>';
		$salida.= '<td class = "text-center" width = "10px"  ><i class = "fa fa-cogs"></i></td>';
		$salida.= '</tr>';
		$i = 1;	
		$montototal = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center"  >'.$i.'.</td>';
			//Codigo
			$cod = $row["cred_codigo"];
			$vent = $row["cred_venta"];
			$cod = Agrega_Ceros($cod);
			$vent = Agrega_Ceros($vent);
			$codigo = $cod."-".$vent;
			$salida.= '<td class = "text-center" >CRED-'.$codigo.'</td>';
			//FORMA de Pago
			$tpag = utf8_decode($row["tpago_desc_md"]);
			$salida.= '<td class = "text-center" >'.$tpag.'</td>';
			//Operador o Banco
			$opera = utf8_decode($row["cred_operador"]);
			$salida.= '<td class = "text-center" >'.$opera.'</td>';
			//Documento o Boucher
			$doc = utf8_decode($row["cred_doc"]);
			$salida.= '<td class = "text-center" >'.$doc.'</td>';
			//fecha hora
			$fec = $row["cred_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//observaciones
			$obs = utf8_decode($row["cred_obs"]);
			$salida.= '<td class = "text-justify">'.$obs.'</td>';
			//monto
			$mont = $row["cred_monto"];
			$mons = $row["mon_simbolo"];
			$moncamb = $row["mon_cambio"];
			$monto = $mons.". ".number_format($mont,2,'.','');
			$salida.= '<td class = "text-center" >'.$monto.'</td>';
			//cambio
			$camb = $row["cred_tcambio"];
			$salida.= '<td class = "text-center" >'.$camb.' x 1</td>';
			//--
			$salida.= '<td class = "text-center">';
			if($saldo0 === true){
			$sit = $row["cred_situacion"];
			if($sit == 1){
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "Ejecutar_Credito('.$cod.','.$vent.');" title = "Ejecutar Cr&eacute;dito (Quitar del Listado)" ><i class="fa fa-check"></i></button> ';
			}else{
				$salida.= '<label class = "text-warning"><i class="fa fa-money"></i> Pagado</label>';
			}	
			}else{
			$salida.= '<button type="button" class="btn btn-success btn-xs" disabled title = "Ejecutar Cr&eacute;dito (Quitar del Listado)" ><i class="fa fa-check"></i></button> ';
			}
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			//----
			$salida.= '</table>';
			$salida.= '<br>';
	}else{
		$salida.= '<div class = "alert alert-warning text-center" >No se Registran Creditos en esta Venta</div>';
		$salida.= '<br>';
	}
	
	return $salida;
}


function tabla_pagos($vent,$factotal,$credtotal,$monid,$montext,$tcambio,$monsimbolo){
	$ClsPag = new ClsPago();
	$ClsMon = new ClsMoneda();
	$result = $ClsPag->get_pago_venta("",$vent);
		$salida.= '<table class="table table-striped table-bordered">';
		$salida.= '<tr>';
		$salida.= '<td class = "text-center" width = "30px"  >No.</td>';
		$salida.= '<td class = "text-center" width = "80px"  ># TRANS.</td>';
		$salida.= '<td class = "text-center" width = "120px"  >FORMA PAG.</td>';
		$salida.= '<td class = "text-center" width = "80px"  >OP./BAN</td>';
		$salida.= '<td class = "text-center" width = "80px"  >DOC.</td>';
		$salida.= '<td class = "text-center" width = "120px"  >FECHA/HORA</td>';
		$salida.= '<td class = "text-center" width = "180px"  >OBSERVACIONES</td>';
		$salida.= '<td class = "text-center" width = "50px"  >MONTO</td>';
		$salida.= '<td class = "text-center" width = "50px"  >T/C</td>';
		$salida.= '<td class = "text-center" width = "50px"  >ACUM.</td>';
		$salida.= '</tr>';
		$i = 1;	
		$montototal = 0;
	if(is_array($result)){
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center"  >'.$i.'.</td>';
			//Codigo
			$cod = $row["pag_codigo"];
			$vent = $row["pag_venta"];
			$cod = Agrega_Ceros($cod);
			$vent = Agrega_Ceros($vent);
			$codigo = $cod."-".$vent;
			$salida.= '<td class = "text-center" >'.$codigo.'</td>';
			//FORMA de Pago
			$tpag = utf8_decode($row["tpago_desc_md"]);
			$salida.= '<td class = "text-center" >'.$tpag.'</td>';
			//Operador o Banco
			$opera = utf8_decode($row["pag_operador"]);
			$salida.= '<td class = "text-center" >'.$opera.'</td>';
			//Documento o Boucher
			$doc = utf8_decode($row["pag_doc"]);
			$salida.= '<td class = "text-center" >'.$doc.'</td>';
			//fecha hora
			$fec = $row["pag_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//observaciones
			$obs = utf8_decode($row["pag_obs"]);
			$salida.= '<td class = "text-justify">'.$obs.'</td>';
			//monto
			$mont = $row["pag_monto"];
			$mons = $row["mon_simbolo"];
			$moncamb = $row["mon_cambio"];
			$monto = $mons.". ".$mont;
			$salida.= '<td class = "text-center" >'.$monto.'</td>';
			//cambio
			$camb = $row["pag_tcambio"];
			$salida.= '<td class = "text-center" >'.$camb.' x 1</td>';
			//acumulado
			$Dcambiar = Cambio_Moneda($moncamb,$tcambio,$mont);
			$montototal += $Dcambiar;
			$salida.= '<td class = "text-center" >'.$monsimbolo.'. '.number_format($montototal,2,'.','').'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
	}
			//----
			$saldo = $factotal - $montototal;
			$nota = ($saldo == 0)?"<b style = 'color:green'>VENTA CANCELADA EN SU TOTALIDAD</b>":"<br>";
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "10" >'.$nota.'</td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-rigth" colspan = "9" class = "text-right"> <b>TOTAL DE LA FACTURA</b></td>';
			$salida.= '<td class = "text-center" ><b>'.$monsimbolo.'. '.number_format($factotal,2,'.','').'</b>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-rigth" colspan = "9" class = "text-right"> <b>TOTAL DE VENTA AL CREDITO</b></td>';
			$salida.= '<td class = "text-center" ><b>'.$monsimbolo.'. '.$credtotal.'</b>';
			$salida.= '<input type = "hidden" name = "vent" id = "vent" value = "'.$vent.'"/>';
			$salida.= '<input type = "hidden" name = "factotal" id = "factotal" value = "'.$factotal.'"/>';
			$salida.= '<input type = "hidden" name = "tcambio" id = "tcambio" value = "'.$tcambio.'"/>';
			$salida.= '<input type = "hidden" name = "montext" id = "montext" value = "'.$montext.'"/></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-rigth" colspan = "9" class = "text-right"> <b>TOTAL ACUMULADO</b></td>';
			$salida.= '<td class = "text-center" ><b>'.$monsimbolo.'. '.number_format($montototal,2,'.','').'</b>';
			$salida.= '<input type = "hidden" name = "montototal" id = "montototal" value = "'.$montototal.'"/></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-rigth" colspan = "9" class = "text-right"> <b>SALDO</b></td>';
			$salida.= '<td class = "text-center" ><b style = "color:green">'.$monsimbolo.'. '.number_format($saldo,2,'.','').'</b>';
			$salida.= '<input type = "hidden" name = "moneda" id = "moneda" value = "'.$monid.'"/>';
			$salida.= '<input type = "hidden" name = "saldo" id = "saldo" value = "'.$saldo.'"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
	
	return $salida;
}

function tabla_cuentas_x_cobrar($ven,$suc,$tipo,$fini,$ffin,$operador,$orderby){
	$ClsVntCred = new ClsVntCredito();
	$result = $ClsVntCred->get_cobro_creditos('',$ven,$suc,'',$tipo,$operador,'','','',$fini,$ffin,'','',1,$orderby);
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center"><input type = "checkbox" name="chkbase" id="chkbase" onclick = "check_lista_multiple(\'chk\');" /></td>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "30px">TRANSACCI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "70px"># VENTA</th>';
			$salida.= '<th class = "text-center" width = "30px">EMPRESA</th>';
			$salida.= '<th class = "text-center" width = "60px">TIPO</th>';
			$salida.= '<th class = "text-center" width = "30px">OPERADOR/BANCO</th>';
			$salida.= '<th class = "text-center" width = "30px">BOUCHER/CHEQUE</th>';
			$salida.= '<th class = "text-center" width = "50px">FECHA</th>';
			$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["ven_situacion"];
			$ccred = $row["ccred_codigo"];
			$ven = $row["ven_codigo"];
			$Vtcamb = $row["ven_tcambio"];
			$ventMonSimb = $row["mon_simbolo"];
			$salida.= '<td class = "text-center"  >';
			$salida.= '<input type = "checkbox" id = "chk'.$i.'">';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-center"  >'.$i.'.</td>';
			//Codigo
			$ccred = Agrega_Ceros($ccred);
			$ven = Agrega_Ceros($ven);
			$salida.= '<td class = "text-center" >'.$ccred.'-'.$ven;
			$salida.= '<input type = "hidden" id = "ccue'.$i.'" value = "'.$ccred.'">';
			$salida.= '</td>';
			//Venta
			$salida.= '<td class = "text-center" >'.$ven;
			$salida.= '<input type = "hidden" id = "ven'.$i.'" value = "'.$ven.'">';
			$salida.= '</td>';
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center" ><a href = "javascript:void(0);" class="fa fa-building-o fa-2x" title = "'.$suc.'"></a></td>';
			//tipo
			$tipo = utf8_decode($row["ccred_tipo"]);
			$tipo = ($tipo == 4)?"CHEQUE":"TARJETA";
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//Operador
			$opera = utf8_decode($row["ccred_operador"]);
			$tipo = utf8_decode($row["ccred_tipo"]);
			$salida.= '<td class = "text-center">'.$opera;
			$salida.= '<input type = "hidden" id = "tipo'.$i.'" value = "'.$tipo.'">';
			$salida.= '</td>';
			//Doc
			$doc = utf8_decode($row["ccred_boucher"]);
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			//Fecha / Hora
			$fecha = $row["ccred_fechor_venta"];
			$fecha = cambia_fechaHora($fecha);
			$fecha = substr($fecha,0,10);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//monto
			$tot = $row["ccred_monto"];
			$mons = $row["mon_simbolo"];
			$monc = $row["mon_cambio"];
			$Dcambiar = Cambio_Moneda($monc,1,$tot);//realiza el cambio a Quetzales
			$camb = $row["ccred_tcambio"];
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($tot,2,'.','');
			$salida.= '<input type = "hidden" id = "monto'.$i.'" value = "'.$Dcambiar.'">';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '<br>';
			$salida.= '<div class="row"> ';
			$salida.= '<div class="col-xs-12 text-center">';
			$salida.= '<button type="button" class="btn btn-success" onclick = "Confirm_Ejecutar_Cheque_Tarjeta();"><span class="fa fa-shopping-cart"></span> Ejecutar</button> ';
			$salida.= '<input type = "hidden" id = "filas"  name = "filas" value = "'.$i.'">';
			$salida.= '<input type = "hidden" name = "chkrows" id = "chkrows" value = "'.$i.'" />';
			$salida.= '</div>';
			$salida.= '</div>';
			$salida.= '<br>';
			
	}else{
		$salida.= '<div class = "alert alert-warning text-center" >No se Registran Cuentas por Cobrar</div>';
		$salida.= '<input type = "hidden" name = "chkrows" id = "chkrows" value = "0" />';
		$salida.= '<br>';
	}
		
	return $salida;
}


function tabla_creditos_x_cobrar($vent,$suc,$cli,$fini,$ffin){
	$ClsCred = new ClsCredito();
	$result = $ClsCred->get_credito_venta("",$vent,$suc,'',$fini,$ffin,1,$cli);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "80px"># CREDITO</th>';
		$salida.= '<th class = "text-center" width = "70px"># VENTA</th>';
		$salida.= '<th class = "text-center" width = "80px">AUTORIZ&Oacute;</th>';
		$salida.= '<th class = "text-center" width = "80px">No. DOC.</th>';
		$salida.= '<th class = "text-center" width = "30px">FECHA</th>';
		$salida.= '<th class = "text-center" width = "185px">OBSERVACIONES</th>';
		$salida.= '<th class = "text-center" width = "30px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "10px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "10px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "10px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "10px"><i class="fa fa-cogs"></i></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		$montototal = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center"  >'.$i.'.</td>';
			//-
			$cod = trim($row["cred_codigo"]);
			$vent = trim($row["cred_venta"]);
			$codigo = Agrega_Ceros($row["cred_codigo"])."-".Agrega_Ceros($row["cred_venta"]);
			$salida.= '<td class = "text-center" >CRED-'.$codigo.'</td>';
			//FORMA de Pago
			$vent = Agrega_Ceros($row["cred_venta"]);
			$salida.= '<td class = "text-center" >'.$vent.'</td>';
			//Operador o Banco
			$opera = utf8_decode($row["cred_operador"]);
			$salida.= '<td class = "text-center" >'.$opera.'</td>';
			//Documento o Boucher
			$doc = utf8_decode($row["cred_doc"]);
			$salida.= '<td class = "text-center" >'.$doc.'</td>';
			//fecha hora
			$fecha = $row["cred_fechor"];
			$fecha = cambia_fechaHora($fecha);
			$fecha = substr($fecha,0,10);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//observaciones
			$obs = utf8_decode($row["cred_obs"]);
			$salida.= '<td class = "text-justify">'.$obs.'</td>';
			//monto
			$mont = $row["cred_monto"];
			$mons = $row["mon_simbolo"];
			$moncamb = $row["mon_cambio"];
			$monto = number_format($mont,2,'.',',');
			//cambio
			$camb = $row["cred_tcambio"];
			$salida.= '<td class = "text-center" >'.$mons.' '.$monto.'</td>';
			//Codigo
			$cod = trim($row["cred_codigo"]);
			$vent = trim($row["cred_venta"]);
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-outline btn-primary btn-xs" onclick = "Ver_Detalle_Pagos('.$vent.');" title = "Ver Pagos" ><i class="fa fa-search"></i></button> ';
			$salida.= '</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "Editar_Credito('.$cod.','.$vent.');" title = "Editar Datos del Cr&eacute;dito" ><i class="fa fa-edit"></i></button> ';
			$salida.= '</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<a class="btn btn-primary btn-xs" href = "FRMpago.php?vent='.$vent.'" title = "Pagar o abonar al Cr&eacute;dito" ><i class="fa fa-plus"></i> <i class="fa fa-money"></i></a> ';
			$salida.= '</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "Ejecutar_Credito('.$cod.','.$vent.');" title = "Ejecutar Cr&eacute;dito (Quitar del Listado)" ><i class="fa fa-check"></i></button> ';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			//----
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
	}else{
		$salida.= '<div class = "alert alert-warning text-center" >No se Registran Creditos en Ventas</div>';
		$salida.= '<br>';
	}
	
	return $salida;
}




function tabla_pagos2($vent,$tcambio,$monsimbolo){
	$ClsPag = new ClsPago();
	$result = $ClsPag->get_pago_venta("",$vent);
	
	if(is_array($result)){
			$salida.= '<table class = "tabledash" border = 1>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" width = "70px"  ><b>#TRANS.</b></td>';
			$salida.= '<td class = "text-center" width = "100px"  ><b>FORMA PAG.</b></td>';
			$salida.= '<td class = "text-center" width = "110px"  ><b>OP./BAN</b></td>';
			$salida.= '<td class = "text-center" width = "80px"  ><b>DOC.</b></td>';
			$salida.= '<td class = "text-center" width = "120px"  ><b>FECHA/HORA</b></td>';
			$salida.= '<td class = "text-center" width = "50px"  ><b>MONTO</b></td>';
			$salida.= '<td class = "text-center" width = "50px"  ><b>T/C</b></td>';
			$salida.= '<td class = "text-center" width = "50px"  ><b>M*TC</b></td>';
			$salida.= '</tr>';
		$i = 1;	
		$montototal = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//Codigo
			$cod = $row["pag_codigo"];
			$vent = $row["pag_venta"];
			$cod = Agrega_Ceros($cod);
			$vent = Agrega_Ceros($vent);
			$codigo = $cod."-".$vent;
			$salida.= '<td class = "text-center" >'.$codigo.'</td>';
			//FORMA de Pago
			$tpag = utf8_decode($row["tpago_desc_md"]);
			$salida.= '<td class = "text-center" >'.$tpag.'</td>';
			//Operador o Banco
			$opera = utf8_decode($row["pag_operador"]);
			$salida.= '<td class = "text-center" >'.$opera.'</td>';
			//Documento o Boucher
			$doc = utf8_decode($row["pag_doc"]);
			$salida.= '<td class = "text-center" >'.$doc.'</td>';
			//fecha hora
			$fec = $row["pag_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//monto
			$mont = $row["pag_monto"];
			$mons = $row["mon_simbolo"];
			$moncamb = $row["mon_cambio"];
			$monto = $mons.". ".number_format($mont,2,'.','');
			$salida.= '<td class = "text-center" >'.$monto.'</td>';
			//cambio
			$camb = $row["pag_tcambio"];
			$salida.= '<td class = "text-center" >'.$camb.' x 1</td>';
			//total
			$Dcambiar = Cambio_Moneda($moncamb,$tcambio,$mont);
			$total = $monsimbolo.". ".number_format($Dcambiar,2,'.','');
			$salida.= '<td class = "text-center" >'.$total.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			//----
			$salida.= '</table>';
	}
	
	return $salida;
}

/////////////////////////// Historiales ///////////////////


function tabla_historial_venta($vent,$suc,$pv,$ser,$facc,$cli,$fini,$ffin,$cfac,$sit,$form){
	$ClsVent = new ClsVenta();
	$cfac = ($cfac == 2)?0:$cfac;
	$result = $ClsVent->get_venta($vent,$cli,$pv,$suc,'','',$fini,$ffin,$cfac,$sit);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		if($form == "H"){
		$salida.= '<th class = "text-center" width = "10px"></th>';
		$salida.= '<th class = "text-center" width = "10px"></th>';
		}	
		$salida.= '<th class = "text-center" width = "60px"># VENTA</th>';
		$salida.= '<th class = "text-center" width = "120px">CLIENTE</th>';
		$salida.= '<th class = "text-center" width = "100px">EMPRESA</th>';
		$salida.= '<th class = "text-center" width = "70px">P. VENTA</th>';
		$salida.= '<th class = "text-center" width = "100px">FECHA/VENTA</th>';
		$salida.= '<th class = "text-center" width = "120px">FECHA/REG.</th>';
		$salida.= '<th class = "text-center" width = "50px">DESCUENTO</th>';
		$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
		//$salida.= '<th class = "text-center" width = "70px">MONEDA</th>';
		//$salida.= '<th class = "text-center" width = "50px">T/C</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$sit = $row["ven_situacion"];
			$vent = $row["ven_codigo"];
			if($form == "H"){
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary btn-xs" onclick = "Ver_Detalle_Venta('.$vent.');" title = "Ver el Detalle de la Venta" ><span class="fa fa-shopping-cart"></span></button>';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "Ver_Detalle_Pagos('.$vent.');" title = "Ver el Detalle de los Pagos" ><span class="fa fa-money"></span></button>';
			$salida.= '</td>';
			}
			//Codigo
			$vent = Agrega_Ceros($vent);
			$salida.= '<td class = "text-center" >'.$vent.'</td>';
			//cliente
			$cliente = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left">'.$cliente.'</td>';
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center" >'.$suc.'</td>';
			//punto de venta
			$pv = utf8_decode($row["pv_nombre"]);
			$salida.= '<td class = "text-center" >'.$pv.'</td>';
			//Fecha / venta
			$fec = $row["ven_fecha"];
			$fec = cambia_fecha($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//Fecha / registro
			$fec = $row["ven_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//descuento
			$desc = $row["ven_descuento"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($desc,2,'.','').'</td>';
			//total
			$tot = $row["ven_total"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" ><b>'.$mons.'. '.number_format($tot,2,'.','').'</b></td>';
			//Moneda
			$mon = $row["mon_desc"];
			//$salida.= '<td class = "text-center" >'.$mon.'</td>';
			//tcamb
			$tcamb = $row["ven_tcambio"];
			//$salida.= '<td class = "text-center" >'.$tcamb.' x 1</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
			$i--;
		$salida.= '</table>';
		$salida.= '</div>';
	}else{
		$salida.= '<div class = "row">';
		$salida.= '<div class="col-xs-10 col-xs-offset-1 text-center">';
		$salida.= '<h5 class = "alert alert-info text center"><i class = "fa fa-info-circle"></i> No hay ventas registradas con estos criterios de busqueda, revise la fecha u otro criterio para concretar....</h5>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_diario($suc,$pv,$fini,$ffin){
	$ClsMon = new ClsMoneda();
	$ClsVent = new ClsVenta();
	/// calcula moneda base
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$MonDesc = utf8_encode($row["mon_desc"]);
			$MonSimbol = utf8_encode($row["mon_simbolo"]);
			$MonCambio = trim($row["mon_cambio"]);
		}	
	}	
	
	$result = $ClsVent->get_ventas_pagos('','',$pv,$suc,'','',$fini,$ffin,'','');
	if(is_array($result)){
		$salida.= '<div class="table-responsive">';
		$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "60px"># VENTA</th>';
		$salida.= '<th class = "text-center" width = "60px">FACTURA</th>';
		$salida.= '<th class = "text-center" width = "120px">CLIENTE</th>';
		$salida.= '<th class = "text-center" width = "30px">DETALLE</th>';
		$salida.= '<th class = "text-center" width = "50px">EFECTIVO</th>';
		$salida.= '<th class = "text-center" width = "50px">TARJETA</th>';
		$salida.= '<th class = "text-center" width = "50px">CHEQUE</th>';
		$salida.= '<th class = "text-center" width = "50px">CR&Eacute;DITO</th>';
		$salida.= '<th class = "text-center" width = "50px">DESCUENTO</th>';
		$salida.= '<th class = "text-center" width = "50px">TOTAL</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		$Tefectivo = 0;
		$Ttarjeta = 0;
		$Tcheque = 0;
		$Tcredito = 0;
		$Tdescuento = 0;
		$Ttotal = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$sit = $row["ven_situacion"];
			$vent = $row["ven_codigo"];
			$venTcambio = $row["ven_tcambio"];
			//Codigo
			$vent = Agrega_Ceros($vent);
			$salida.= '<td class = "text-center" >'.$vent.'</td>';
			//factura
			$serie = trim($row["ven_ser_numero"]);
			$numero = Agrega_Ceros($row["ven_fac_numero"]);
			$factura = $serie.' '.$numero;
			$factura = (trim($factura) == "")?"-":$factura;
			$salida.= '<td class = "text-center">'.$factura.'</td>';
			//cliente
			$cliente = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left">'.$cliente.'</td>';
			//detalle
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary btn-xs" onclick = "Ver_Detalle_Venta('.$vent.');" title = "Ver el Detalle de la Venta" ><span class="fa fa-shopping-cart"></span></button>';
			$salida.= '</td>';
			//efectivo
			$monto = $row["ven_pago_efectivo"];
			$tcambio = $row["ven_tcambio_efectivo"];
			$Dcambiar = Cambio_Moneda($tcambio,$venTcambio,$monto);
			$DcambiarT = Cambio_Moneda($tcambio,$MonCambio,$monto);
			$Tefectivo+= $DcambiarT;
			$mons = $row["ven_pago_moneda_efectivo"];
			$mons = ($mons == "")?"Q":$mons;
			$monto = $mons.'. '.number_format($Dcambiar,2,'.','');
			$salida.= '<td class = "text-center" >'.$monto.'</td>';
			//tarjeta
			$monto = $row["ven_pago_tarjeta"];
			$tcambio = $row["ven_tcambio_tarjeta"];
			$Dcambiar = Cambio_Moneda($tcambio,$venTcambio,$monto);
			$DcambiarT = Cambio_Moneda($tcambio,$MonCambio,$monto);
			$Ttarjeta+= $DcambiarT;
			$mons = $row["ven_pago_moneda_tarjeta"];
			$mons = ($mons == "")?"Q":$mons;
			$monto = $mons.'. '.number_format($Dcambiar,2,'.','');
			$salida.= '<td class = "text-center" >'.$monto.'</td>';
			//cheque
			$monto = $row["ven_pago_cheque"];
			$tcambio = $row["ven_tcambio_cheque"];
			$Dcambiar = Cambio_Moneda($tcambio,$venTcambio,$monto);
			$DcambiarT = Cambio_Moneda($tcambio,$MonCambio,$monto);
			$Tcheque+= $DcambiarT;
			$mons = $row["ven_pago_moneda_cheque"];
			$mons = ($mons == "")?"Q":$mons;
			$monto = $mons.'. '.number_format($Dcambiar,2,'.','');
			$salida.= '<td class = "text-center" >'.$monto.'</td>';
			//credito
			$monto = $row["ven_pago_credito"];
			$tcambio = $row["ven_tcambio_credito"];
			$Dcambiar = Cambio_Moneda($tcambio,$venTcambio,$monto);
			$DcambiarT = Cambio_Moneda($tcambio,$MonCambio,$monto);
			$Tcredito+= $DcambiarT;
			$mons = $row["ven_pago_moneda_credito"];
			$mons = ($mons == "")?"Q":$mons;
			$monto = $mons.'. '.number_format($Dcambiar,2,'.','');
			$salida.= '<td class = "text-center" >'.$monto.'</td>';
			//descuento
			$desc = $row["ven_descuento"];
			$Tdescuento+= $desc;
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" ><b class="text-muted">'.$mons.'. '.number_format($desc,2,'.','').'</b></td>';
			//total
			$tot = $row["ven_total"];
			$Ttotal+= $tot;
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" ><b>'.$mons.'. '.number_format($tot,2,'.','').'</b></td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
			//--
			$Tefectivo = number_format($Tefectivo,2,'.',',');
			$Ttarjeta = number_format($Ttarjeta,2,'.',',');
			$Tcheque = number_format($Tcheque,2,'.',',');
			$Tcredito = number_format($Tcredito,2,'.',',');
			$Tdescuento = number_format($Tdescuento,2,'.',',');
			$Ttotal = number_format($Ttotal,2,'.',',');
			//--
			$salida.= '<tr class = "info">';
			$salida.= '<td class = "text-center"><b>'.$i.'.</b></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td class = "text-center" ><b>'.$MonSimbol.'. '.$Tefectivo.'</b></td>';
			$salida.= '<td class = "text-center" ><b>'.$MonSimbol.'. '.$Ttarjeta.'</b></td>';
			$salida.= '<td class = "text-center" ><b>'.$MonSimbol.'. '.$Tcheque.'</b></td>';
			$salida.= '<td class = "text-center" ><b>'.$MonSimbol.'. '.$Tcredito.'</b></td>';
			$salida.= '<td class = "text-center" ><b>'.$MonSimbol.'. '.$Tdescuento.'</b></td>';
			$salida.= '<td class = "text-center" ><b>'.$MonSimbol.'. '.$Ttotal.'</b></td>';
			$salida.= '</tr>';
			//--
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}else{
		$salida.= '<div class = "row">';
		$salida.= '<div class="col-xs-10 col-xs-offset-1 text-center">';
		$salida.= '<h5 class = "alert alert-info text center"><i class = "fa fa-info-circle"></i> No hay ventas registradas con estos criterios de busqueda, revise la fecha u otro criterio para concretar....</h5>';
		$salida.= '</div>';
	}
	
	return $salida;
}




function tabla_ventas_reglones($tipo,$grupo,$suc,$pv,$fini,$ffin,$fac,$sit){
	$ClsMon = new ClsMoneda();
	$ClsVent = new ClsVenta();
	/// calcula moneda base
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$MonDesc = utf8_encode($row["mon_desc"]);
			$MonSimbol = utf8_encode($row["mon_simbolo"]);
			$MonCambio = trim($row["mon_cambio"]);
		}	
	}	
	
	if($tipo == "P"){
		$result = $ClsVent->get_det_reglon_producto($tipo,$grupo,$pv,$suc,$fini,$ffin,$fac,$sit);
	}else if($tipo == "S"){
		$result = $ClsVent->get_det_reglon_servicios($tipo,$grupo,$pv,$suc,$fini,$ffin,$fac,$sit);
	}else if($tipo == "O"){
		$result = $ClsVent->get_det_venta('','',$tipo,'',$pv,$suc,'','',$fini,$ffin,$fac,$sit);
	}
	if(is_array($result)){
		$salida.= '<div class="table-responsive">';
		$salida.= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "30px"># VENTA</th>';
		$salida.= '<th class = "text-center" width = "30px">FACTURA</th>';
		$salida.= '<th class = "text-center" width = "30px">FECHA</th>';
		$salida.= '<th class = "text-center" width = "120px">CLIENTE</th>';
		$salida.= '<th class = "text-center" width = "150px">DETALLE</th>';
		$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		$Ttotal = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$sit = $row["ven_situacion"];
			$vent = $row["ven_codigo"];
			$venTcambio = $row["ven_tcambio"];
			//Codigo
			$vent = Agrega_Ceros($vent);
			$salida.= '<td class = "text-center" >'.$vent.'</td>';
			//factura
			$serie = trim($row["ven_ser_numero"]);
			$numero = Agrega_Ceros($row["ven_fac_numero"]);
			$factura = $serie.' '.$numero;
			$factura = (trim($factura) == "")?"-":$factura;
			$salida.= '<td class = "text-center">'.$factura.'</td>';
			//fecha
			$fecha = cambia_fecha($row["ven_fecha"]);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//cliente
			$cliente = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left">'.$cliente.'</td>';
			//detalle
			$detalle = utf8_decode($row["dven_detalle"]);
			$salida.= '<td class = "text-left">'.$detalle.'</td>';
			//total
			$total = $row["dven_total"];
			$Ttotal+= $total;
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" ><b>'.$mons.'. '.number_format($total,2,'.','').'</b></td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
			//--
			$Ttotal = number_format($Ttotal,2,'.',',');
			//--
			$salida.= '<tr class = "info">';
			$salida.= '<td class = "text-center"><b>'.$i.'.</b></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td></td>';
			$salida.= '<td class = "text-center" ><b>'.$MonSimbol.'. '.$Ttotal.'</b></td>';
			$salida.= '</tr>';
			//--
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}else{
		$salida.= '<div class = "row">';
		$salida.= '<div class="col-xs-10 col-xs-offset-1 text-center">';
		$salida.= '<h5 class = "alert alert-info text center"><i class = "fa fa-info-circle"></i> No hay ventas registradas con estos criterios de busqueda, revise la fecha u otro criterio para concretar....</h5>';
		$salida.= '</div>';
	}
	
	return $salida;
}


//echo tabla_detalle_venta(1703);

function tabla_anulacion_venta($vent,$suc,$pv,$cli,$fini,$ffin,$cfac,$sit){
	$ClsVent = new ClsVenta();
	$cfac = ($cfac == 2)?0:$cfac;
	$result = $ClsVent->get_venta($vent,$cli,$pv,$suc,'','',$fini,$ffin,$cfac,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "50px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "60px"># VENTA</th>';
			$salida.= '<th class = "text-center" width = "120px">CLIENTE</th>';
			$salida.= '<th class = "text-center" width = "100px">EMPRESA</th>';
			$salida.= '<th class = "text-center" width = "70px">P. VENTA</th>';
			$salida.= '<th class = "text-center" width = "100px">FECHA/VENTA</th>';
			$salida.= '<th class = "text-center" width = "120px">FECHA/REG.</th>';
			$salida.= '<th class = "text-center" width = "50px">%DESC.</th>';
			$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
			$salida.= '<th class = "text-center" width = "70px">MONEDA</th>';
			$salida.= '<th class = "text-center" width = "50px">T/C</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["ven_situacion"];
			$vent = $row["ven_codigo"];
			
			$salida.= '<td class = "text-center" >';
			if($sit == 1 || $sit == 2){
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "ConfirmAnular('.$vent.',\''.$fini.'\',\''.$ffin.'\')" title = "Anular Venta" ><span class="glyphicon glyphicon-trash"></span></button>';
			}else{
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "" title = "Venta Anulada" ><span class="fa fa-minus"></span></button>';
			}
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//Codigo
			$vent = Agrega_Ceros($vent);
			$salida.= '<td class = "text-center" >'.$vent.'</td>';
			//cliente
			$cliente = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left">'.$cliente.'</td>';
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center" >'.$suc.'</td>';
			//punto de venta
			$pv = utf8_decode($row["pv_nombre"]);
			$salida.= '<td class = "text-center" >'.$pv.'</td>';
			//Fecha / venta
			$fec = $row["ven_fecha"];
			$fec = cambia_fecha($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//Fecha / registro
			$fec = $row["ven_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//descuento
			$desc = $row["ven_descuento"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($desc,2,'.','').'</td>';
			//total
			$tot = $row["ven_total"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" ><b>'.$mons.'. '.number_format($tot,2,'.','').'</b></td>';
			//Moneda
			$mon = $row["mon_desc"];
			$salida.= '<td class = "text-center" >'.$mon.'</td>';
			//tcamb
			$tcamb = $row["ven_tcambio"];
			$salida.= '<td class = "text-center" >'.$tcamb.' x 1</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
	}else{
		$salida.= '<div class = "row">';
		$salida.= '<div class="col-xs-10 col-xs-offset-1 text-center">';
		$salida.= '<h5 class = "alert alert-info text center"><i class = "fa fa-info-circle"></i> No hay ventas registradas con estos criterios de busqueda, revise la fecha u otro criterio para concretar....</h5>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_reimpresion($suc,$pv,$num,$ser,$cli,$fini,$ffin){
	$ClsFac = new ClsFactura();
	$result = $ClsFac->get_factura($num,$ser,'',$cli,$pv,$suc,'','','','',"1,2",$fini,$ffin);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px">No.</th>';
		$salida.= '<th class = "text-center" width = "60px"># VENTA</th>';
		$salida.= '<th class = "text-center" width = "100px">FACTURA</th>';
		$salida.= '<th class = "text-center" width = "120px">CLIENTE</th>';
		$salida.= '<th class = "text-center" width = "100px">EMPRESA</th>';
		$salida.= '<th class = "text-center" width = "70px">P. VENTA</th>';
		$salida.= '<th class = "text-center" width = "100px">FECHA/VENTA</th>';
		$salida.= '<th class = "text-center" width = "120px">FECHA/REG.</th>';
		$salida.= '<th class = "text-center" width = "40px"><span class="fa fa-cogs"></span></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Codigo
			$vent = $row["ven_codigo"];
			$vent = Agrega_Ceros($vent);
			$salida.= '<td class = "text-center" >'.$vent.'</td>';
			//factura
			$serie = $row["ser_numero"];
			$numero = $row["fac_numero"];
			$numero = Agrega_Ceros($numero);
			$salida.= '<td class = "text-center" >'.$serie.' '.$numero.'</td>';
			//cliente
			$cliente = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left">'.$cliente.'</td>';
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center" >'.$suc.'</td>';
			//punto de venta
			$pv = utf8_decode($row["pv_nombre"]);
			$salida.= '<td class = "text-center" >'.$pv.'</td>';
			//Fecha / venta
			$fec = $row["ven_fecha"];
			$fec = cambia_fecha($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//Fecha / registro
			$fec = $row["ven_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//--
			$ser = $row["fac_serie"];
			$num = $row["fac_numero"];
			$usucod = $_SESSION["codigo"];
			$hashkey1 = $ClsFac->encrypt($ser, $usucod);
			$hashkey2 = $ClsFac->encrypt($num, $usucod);
			$salida.= '<td class = "text-center">';
			$salida.= '<a class="btn btn-default btn-xs" target = "_blank" href="CPREPORTES/REPfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" title = "Reimprimir Factrura" ><span class="fa fa-print"></span></a>';
			$salida.= '</td>';
			
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
	}else{
		$salida.= '<div class = "row">';
		$salida.= '<div class="col-xs-10 col-xs-offset-1 text-center">';
		$salida.= '<h5 class = "alert alert-info text center"><i class = "fa fa-info-circle"></i> No hay ventas registradas con estos criterios de busqueda, revise la fecha u otro criterio para concretar....</h5>';
		$salida.= '<input type = "hidden" name = "chkrows" id = "chkrows" value = "0" />';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_ventas_anteriores($vent,$cfac,$suc,$pv,$num,$ser,$cli,$fini,$ffin){
	$ClsVent = new ClsVenta();
	$cfac = ($cfac == 2)?0:$cfac;
	$result = $ClsVent->get_venta($vent,$cli,$pv,$suc,'','',$fini,$ffin,$cfac,$sit);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><input type = "checkbox" name="chkbase" id="chkbase" onclick = "check_lista_multiple(\'chk\');" /></th>';
		$salida.= '<th class = "text-center" width = "20px">No.</th>';
		$salida.= '<th class = "text-center" width = "60px"># VENTA</th>';
		$salida.= '<th class = "text-center" width = "200px">CLIENTE</th>';
		$salida.= '<th class = "text-center" width = "70px">P. VENTA</th>';
		$salida.= '<th class = "text-center" width = "100px">FECHA/VENTA</th>';
		$salida.= '<th class = "text-center" width = "60px">FACTURADO?</th>';
		$salida.= '<th class = "text-center" width = "60px">FACTURA</th>';
		$salida.= '<th class = "text-center" width = "30px"><i class = "fa fa-dollar"></i></th>';
		$salida.= '<th class = "text-center" width = "30px"></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center"  >';
			$salida.= '<input type = "checkbox" id = "chk'.$i.'">';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Codigo
			$vent = $row["ven_codigo"];
			$venta = Agrega_Ceros($vent);
			$subt = $row["ven_subtotal"];
			$desc = $row["ven_descuento"];
			$tot = $row["ven_total"];
			$mon = $row["ven_moneda"];
			$tcamb = $row["ven_tcambio"];
			$salida.= '<td class = "text-center">'. $venta;
			$salida.= '<input type = "hidden" name = "vent'.$i.'" id = "vent'.$i.'" value = "'.$vent.'" />';
			$salida.= '<input type = "hidden" name = "subtotal'.$i.'" id = "subtotal'.$i.'" value = "'.$subt.'" />';
			$salida.= '<input type = "hidden" name = "descuento'.$i.'" id = "descuento'.$i.'" value = "'.$desc.'" />';
			$salida.= '<input type = "hidden" name = "total'.$i.'" id = "total'.$i.'" value = "'.$tot.'" />';
			$salida.= '<input type = "hidden" name = "moneda'.$i.'" id = "moneda'.$i.'" value = "'.$mon.'" />';
			$salida.= '<input type = "hidden" name = "tcambio'.$i.'" id = "tcambio'.$i.'" value = "'.$tcamb.'" />';
			$salida.= '</td>';
			//cliente
			$clinom = utf8_decode($row["cli_nombre"]);
			$cli = $row["cli_id"];
			$salida.= '<td class = "text-center">'. $clinom;
			$salida.= '<input type = "hidden" name = "cli'.$i.'" id = "cli'.$i.'" value = "'.$cli.'" />';
			$salida.= '</td>';
			//punto de venta
			$pv = utf8_decode($row["pv_nombre"]);
			$salida.= '<td class = "text-center" >'.$pv.'</td>';
			//Fecha / venta
			$fec = $row["ven_fecha"];
			$fec = cambia_fecha($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//facturado?
			$cfac = ($row["ven_factura"] == 1)?"SI":"NO";
			$ser = $row["ven_ser_codigo"];
			$num = $row["ven_fac_numero"];
			$salida.= '<td class = "text-center">'. $cfac;
			$salida.= '<input type = "hidden" name = "ser'.$i.'" id = "ser'.$i.'" value = "'.$ser.'" />';
			$salida.= '<input type = "hidden" name = "num'.$i.'" id = "num'.$i.'" value = "'.$num.'" />';
			$salida.= '</td>';
			//facturado?
			$ser = $row["ven_ser_numero"];
			$num = Agrega_Ceros($row["ven_fac_numero"]);
			$salida.= '<td class = "text-center" >'.$ser.' '.$num.'</td>';
			//monto
			$mont = $row["ven_total"];
			$mons = $row["mon_simbolo"];
			$moncamb = $row["mon_cambio"];
			$monto = $mons.". ".number_format($mont,2,'.','');
			//cambio
			$camb = $row["ven_tcambio"];
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<a href = "javascript:void(0);" class="fa fa-money fa-2x" title = "'.$monto.' - '.$camb.' x 1"></a> &nbsp; ';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "Ver_Detalle_Venta('.$vent.');" title = "Ver Detalle de Historial" ><span class="fa fa-search"></span></button>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '<input type = "hidden" name = "chkrows" id = "chkrows" value = "'.$i.'" />';
			$salida.= '</div>';
	}else{
		$salida.= '<div class = "row">';
		$salida.= '<div class="col-xs-10 col-xs-offset-1 text-center">';
		$salida.= '<h5 class = "alert alert-info text center"><i class = "fa fa-info-circle"></i> No hay ventas registradas con estos criterios de busqueda, revise la fecha u otro criterio para concretar....</h5>';
		$salida.= '<input type = "hidden" name = "chkrows" id = "chkrows" value = "0" />';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}



///////////////////////////////

function rep_historial_venta_descargado($vent,$suc,$pv,$ser,$facc,$fini,$ffin,$fac,$sit){
	$ClsVent = new ClsVenta();
	$ClsFac = new ClsFactura();
	if($ser != "" && $facc != ""){
		$result1 = $ClsFac->get_factura($facc,$ser);
		if(is_array($result1)){
			foreach ($result1 as $row1) {
				$vent = trim($row1["ven_codigo"]);
			}
		}
	}
	$result = $ClsVent->get_hist_venta_lotes('',$vent,'','',$pv,$suc,'','',$fini,$ffin,$fac,$sit);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<br>';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th  width = "30px"><b>No.</b></th>';
			$salida.= '<th  width = "55px"><b>Venta</b></th>';
			$salida.= '<th  width = "55px"><b>Factura</b></th>';
			$salida.= '<th  width = "125px"><b>Cliente</b></th>';
			$salida.= '<th  width = "55px"><b>Vendedor (Cod.)</b></th>';
			$salida.= '<th  width = "55px"><b>Cajero (Cod.)</b></th>';
			$salida.= '<th  width = "95px"><b>Empresa</b></th>';
			$salida.= '<th  width = "95px"><b>P. Venta</b></th>';
			$salida.= '<th  width = "95px"><b>Fecha/Venta</b></th>';
			$salida.= '<th  width = "95px"><b>Fecha/Registo</b></th>';
			$salida.= '<th  width = "100px"><b>Lote</b></th>';
			$salida.= '<th  width = "300px"><b>Descipci&oacute;nn</b></th>';
			$salida.= '<th  width = "75px"><b>Cant.</b></th>';
			$salida.= '<th  width = "65px"><b>P. Compra</b></th>';
			$salida.= '<th  width = "65px"><b>P. Costo</b></th>';
			$salida.= '<th  width = "65px"><b>P. Venta</b></th>';
			$salida.= '<th  width = "65px"><b>Variaci&oacute;nn %</b></th>';
			$salida.= '<th  width = "65px"><b>% Desc.</b></th>';
			$salida.= '<th  width = "65px"><b>C * P</b></th>';
			$salida.= '<th  width = "65px"><b>T/C</b></th>';
			$salida.= '<th  width = "65px"><b>Total</b></th>';
			$salida.= '<th  width = "65px"><b>IVA</b></th>';
			$salida.= '</tr>';
		$Total = 0;
		$Rtotal = 0;
		$TIVA = 0;
		$Tdesc = 0;
		$i = 1;	
		foreach($result as $row){
			//No.
			$salida.= '<th >'.$i.'.</th>';
			//Venta
			$vent = $row["ven_codigo"];
			$vent = Agrega_Ceros($vent);
			$salida.= '<td >'.$vent.'</td>';
			//Factura
			$fac = $row["ven_ser_numero"]." ".Agrega_Ceros($row["ven_fac_numero"]);
			$salida.= '<td >'.$fac.'</td>';
			//Cliente
			$cliente = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left">'.$cliente.'</td>';
			//Vendedor
			$ve = $row["ven_vendedor"];
			$ve = Agrega_Ceros($ve);
			$salida.= '<td >'.$ve.'</td>';
			//Cajero
			$caj = $row["ven_cajero"];
			$caj = Agrega_Ceros($caj);
			$salida.= '<td >'.$caj.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td class = "text-left">'.$suc.'</td>';
			//Punto de Venta
			$pv = utf8_decode($row["pv_nombre"]);
			$salida.= '<td class = "text-left">'.$pv.'</td>';
			//Fecha / venta
			$fec = $row["ven_fecha"];
			$fec = cambia_fecha($fec);
			$salida.= '<td >'.$fec.'</td>';
			//Fecha / registro
			$fec = $row["ven_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td >'.$fec.'</td>';
			//Lote
			$lot = Agrega_Ceros($row["lot_codigo"])."-".Agrega_Ceros($row["lot_articulo"])."-".Agrega_Ceros($row["lot_grupo"]);
			$salida.= '<td >'.$lot.'</td>';
			//Descripcion o Articulo
			$desc = $row["dven_detalle"];
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//Cantidad
			$cant = $row["det_cantidad"];
			$salida.= '<td >'.$cant.'</td>';
			//Precio Compra.
			$prem = $row["lot_precio_manufactura"];
			$mons = $row["mon_simbolo"];
			$ventMonSimb = $row["mon_simbolo_venta"];
			$salida.= '<td >'.$mons.'. '.$prem.'</td>';
			//Precio Costo.
			$prec = $row["lot_precio_costo"];
			$salida.= '<td >'.$mons.'. '.$prec.'</td>';
			//Precio Venta.
			$pre = $row["dven_precio"];
			$salida.= '<td >'.$mons.'. '.$pre.'</td>';
			//Variacion
			$var = $pre - $prec;
			$porvar = ($var*100)/$pre;
			$porvar = number_format($porvar, 2, '.', '');
			$salida.= '<td >'.$mons.'. '.$var.' ('.$porvar.'%)</td>';
			//Descuento
			$dsc = $row["dven_descuento"];
			$salida.= '<td >'.$dsc.' %</td>';
			//sub Total
			$monc = $row["dven_tcambio"];
			$ventMonCambio = $row["ven_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$ventMonCambio,$stot);
			$Total+= $Dcambiar;
			$Rcambiar = Cambio_Moneda($monc,$ventMonCambio,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = number_format($stot, 2, '.', '');
			$iva = ($stot * 12)/100;
			$iva = number_format($iva, 2, '.', '');
			$TIVA+=$iva;
			$salida.= '<td >'.$mons.' '.$stot.'</td>';
			//---
			$salida.= '<td >'.$monc.' x 1</td>';
			//---
			$salida.= '<td >'.$ventMonSimb.' '.$Dcambiar.'</td>';
			//---
			$salida.= '<td >'.$ventMonSimb.' '.$iva.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
			//--
			$salida.= '<tr>';
			$pdesc = $Rtotal - $Total;//saca la diferencia entre los descuentos y el precio real
			$promdesc = (($pdesc/$Rtotal)*100);
			$promdesc = number_format($promdesc, 2, '.', '');
			$salida.= '<th class = "text-right" colspan = "19"> TOTAL DESCUENTO</th>';
			$salida.= '<th class = "text-right" colspan = "2">'.$promdesc.'%</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th class = "text-right" colspan = "19"> IVA</th>';
			$salida.= '<th class = "text-right" colspan = "2">'.$ventMonSimb.' '.$TIVA.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$Total = number_format($Total, 2, '.', '');
			$salida.= '<th class = "text-right" colspan = "19"> TOTAL SIN IVA</td>';
			$salida.= '<th class = "text-right" colspan = "2">'.$ventMonSimb.' '.$Total.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th class = "text-right" colspan = "19"> TOTAL CON IVA</td>';
			$TotalIVA = number_format($Total + $TIVA,2, '.', '');
			$salida.= '<th class = "text-right" colspan = "2">'.$ventMonSimb.' '.$TotalIVA.'</th>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '<br>';
			$salida.= '</div>';
	}
	return $salida;
}

function rep_historial_venta_nodescargado($vent,$suc,$pv,$ser,$facc,$fini,$ffin,$fac,$sit){
	$ClsVent = new ClsVenta();
	$ClsFac = new ClsFactura();
	if($ser != "" && $facc != ""){
		$result1 = $ClsFac->get_factura($facc,$ser);
		if(is_array($result1)){
			foreach ($result1 as $row1) {
				$vent = trim($row1["ven_codigo"]);
			}
		}
	}
	$result = $ClsVent->get_det_venta_producto('',$vent,'',0,'',$pv,$suc,'','',$fini,$ffin,$fac,$sit);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<br>';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th  width = "30px"><b>No.</b></th>';
			$salida.= '<th  width = "55px"><b>Venta</b></th>';
			$salida.= '<th  width = "55px"><b>Factura</b></th>';
			$salida.= '<th  width = "125px"><b>Cliente</b></th>';
			$salida.= '<th  width = "55px"><b>Vendedor (Cod.)</b></th>';
			$salida.= '<th  width = "55px"><b>Cajero (Cod.)</b></th>';
			$salida.= '<th  width = "95px"><b>Empresa</b></th>';
			$salida.= '<th  width = "95px"><b>P. Venta</b></th>';
			$salida.= '<th  width = "95px"><b>Fecha/Venta</b></th>';
			$salida.= '<th  width = "95px"><b>Fecha/Registo</b></th>';
			$salida.= '<th  width = "100px"><b>Lote</b></th>';
			$salida.= '<th  width = "300px"><b>Descipci&oacute;nn</b></th>';
			$salida.= '<th  width = "75px"><b>Cant.</b></th>';
			$salida.= '<th  width = "65px"><b>P. Compra</b></th>';
			$salida.= '<th  width = "65px"><b>P. Costo</b></th>';
			$salida.= '<th  width = "65px"><b>P. Venta</b></th>';
			$salida.= '<th  width = "65px"><b>Variaci&oacute;nn %</b></th>';
			$salida.= '<th  width = "65px"><b>% Desc.</b></th>';
			$salida.= '<th  width = "65px"><b>C * P</b></th>';
			$salida.= '<th  width = "65px"><b>T/C</b></th>';
			$salida.= '<th  width = "65px"><b>Total</b></th>';
			$salida.= '<th  width = "65px"><b>IVA</b></th>';
			$salida.= '</tr>';
		$Total = 0;
		$Rtotal = 0;
		$TIVA = 0;
		$Tdesc = 0;
		$i = 1;	
		foreach($result as $row){
			//No.
			$salida.= '<td >'.$i.'.</td>';
			//Venta
			$vent = $row["ven_codigo"];
			$vent = Agrega_Ceros($vent);
			$salida.= '<td >'.$vent.'</td>';
			//Factura
			$fac = $row["ven_ser_numero"]." ".Agrega_Ceros($row["ven_fac_numero"]);
			$salida.= '<td >'.$fac.'</td>';
			//Cliente
			$cliente = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left">'.$cliente.'</td>';
			//Vendedor
			$ve = $row["ven_vendedor"];
			$ve = Agrega_Ceros($ve);
			$salida.= '<td >'.$ve.'</td>';
			//Cajero
			$caj = $row["ven_cajero"];
			$caj = Agrega_Ceros($caj);
			$salida.= '<td >'.$caj.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td class = "text-left">'.$suc.'</td>';
			//Punto de Venta
			$pv = utf8_decode($row["pv_nombre"]);
			$salida.= '<td class = "text-left">'.$pv.'</td>';
			//Fecha / venta
			$fec = $row["ven_fecha"];
			$fec = cambia_fecha($fec);
			$salida.= '<td >'.$fec.'</td>';
			//Fecha / registro
			$fec = $row["ven_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td >'.$fec.'</td>';
			//Lote
			$salida.= '<td >---</td>';
			//Descripcion o Articulo
			$desc = $row["dven_detalle"];
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//Cantidad
			$cant = $row["dven_cantidad"];
			$salida.= '<td >'.$cant.'</td>';
			//Precio Compra.
			$salida.= '<td >-</td>';
			//Precio Costo.
			$salida.= '<td >-</td>';
			//Precio Venta.
			$mons = $row["mon_simbolo"];
			$monc = $row["dven_tcambio"];
			$ventMonCambio = $row["ven_tcambio"];
			$ventMonSimb = $row["mon_simbolo_venta"];
			$pre = $row["dven_precio"];
			$salida.= '<td >'.$mons.'. '.$pre.'</td>';
			//Variacion
			$salida.= '<td >-</td>';
			//Descuento
			$dsc = $row["dven_descuento"];
			$salida.= '<td >'.$dsc.' %</td>';
			//sub Total
			$monc = $row["dven_tcambio"];
			$ventMonCambio = $row["ven_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$ventMonCambio,$stot);
			$Total+= $Dcambiar;
			$Rcambiar = Cambio_Moneda($monc,$ventMonCambio,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = number_format($stot, 2, '.', '');
			$iva = ($stot * 12)/100;
			$iva = number_format($iva, 2, '.', '');
			$TIVA+=$iva;
			$salida.= '<td >'.$mons.' '.$stot.'</td>';
			//---
			$salida.= '<td >'.$monc.' x 1</td>';
			//---
			$salida.= '<td >'.$ventMonSimb.' '.$Dcambiar.'</td>';
			//---
			$salida.= '<td >'.$ventMonSimb.' '.$iva.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
			//--
			$salida.= '<tr>';
			$pdesc = $Rtotal - $Total;//saca la diferencia entre los descuentos y el precio real
			$promdesc = (($pdesc/$Rtotal)*100);
			$promdesc = number_format($promdesc, 2, '.', '');
			$salida.= '<th class = "text-right" colspan = "19"> TOTAL DESCUENTO</th>';
			$salida.= '<th class = "text-right" colspan = "2">'.$promdesc.'%</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th class = "text-right" colspan = "19"> IVA</th>';
			$salida.= '<th class = "text-right" colspan = "2">'.$ventMonSimb.' '.$TIVA.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$Total = number_format($Total, 2, '.', '');
			$salida.= '<th class = "text-right" colspan = "19"> TOTAL SIN IVA</td>';
			$salida.= '<th class = "text-right" colspan = "2">'.$ventMonSimb.' '.$Total.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th class = "text-right" colspan = "19"> TOTAL CON IVA</td>';
			$TotalIVA = number_format($Total + $TIVA,2, '.', '');
			$salida.= '<th class = "text-right" colspan = "2">'.$ventMonSimb.' '.$TotalIVA.'</th>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '<br>';
			$salida.= '</div>';
	}
	return $salida;
}


function tabla_montos_ventas_anteriores($CodVentas){
	$ClsMon = new ClsMoneda();
	$ClsVent = new ClsVenta();
	///--
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$MonDesc = utf8_encode($row["mon_desc"]);
			$MonSimbol = utf8_encode($row["mon_simbolo"]);
			$MonCambio = trim($row["mon_cambio"]);
		}	
	}	
	////
	$result = $ClsVent->get_ventas_varias($CodVentas);
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px">No.</th>';
		$salida.= '<th class = "text-center" width = "60px"># VENTA</th>';
		$salida.= '<th class = "text-center" width = "120px">FECHA DE VENTA</th>';
		$salida.= '<th class = "text-center" width = "50px">DESCUENTOS</th>';
		$salida.= '<th class = "text-center" width = "50px">MONTOS</th>';
		$salida.= '<th class = "text-center" width = "70px">MONEDA</th>';
		$salida.= '<th class = "text-center" width = "50px">T/C</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		$Tdescuento = 0;
		$Ttotal = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$vent = $row["ven_codigo"];
			$vent = Agrega_Ceros($vent);
			$tcambio = $row["ven_tcambio"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" >'.$vent.'</td>';
			//Fecha / venta
			$fec = $row["ven_fecha"];
			$fec = cambia_fecha($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//descuento
			$desc = $row["ven_descuento"];
			$Dcambiar = Cambio_Moneda($tcambio,$MonCambio,$desc);
			$Tdescuento+= $Dcambiar;
			$salida.= '<td class = "text-center" ><b>'.$mons.'. '.$desc.'</b></td>';
			//total
			$tot = $row["ven_total"];
			$Dcambiar = Cambio_Moneda($tcambio,$MonCambio,$tot);
			$Ttotal+= $Dcambiar;
			$salida.= '<td class = "text-center" ><b>'.$mons.'. '.$tot.'</b></td>';
			//Moneda
			$mon = $row["mon_desc"];
			$salida.= '<td class = "text-center" >'.$mon.'</td>';
			//tcamb
			$tcamb = $row["ven_tcambio"];
			$salida.= '<td class = "text-center" >'.$tcamb.' x 1</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
		//--
			//--
			$salida.= '<tr>';
			$titulo = '<b>Moneda: '.$MonDesc.' / Tipo de Cambio: '.$MonCambio.' X 1</b>';
			$salida.= '<th colspan = "3">'.$titulo.'</td>';
			$Tdescuento = number_format($Tdescuento, 2, '.', '');
			$salida.= '<th class = "text-center">'.$MonSimbol.' '.$Tdescuento.'</th>';
			$Ttotal = number_format($Ttotal,2, '.', '');
			$salida.= '<th class = "text-center">'.$MonSimbol.' '.$Ttotal.'</th>';
			$salida.= '<th colspan = "2"></td>';
			$salida.= '</tr>';
		//--
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}

//echo tabla_historial_venta(5,$suc,$pv,$ser,$facc,$fini,$ffin,$sit,"A");
//echo tabla_detalle_venta(5);
//$ClsVntCred = new ClsVntCredito();
//echo $ClsVntCred->insert_cobro_creditos(1,4,1,10,1,1,2,'VISA','1234123','R');;

?>
