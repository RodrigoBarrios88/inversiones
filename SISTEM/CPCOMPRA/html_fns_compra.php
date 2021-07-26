<?php 
include_once('../html_fns.php');

function tabla_filas_compra($clase,$suc,$compMonDesc,$compMonSimb,$compMonCambio,$tfdsc,$fdsc){
	
	$ClsComp = new ClsCompra();
	$result = $ClsComp->get_detalle_temporal($clase,$suc);
	//Tratamiento de la cadena de moneda
	$salida = '<br>';
	$salida.= '<table class="table table-striped table-bordered table-hover">';
	$salida.= '<tr>';
	$salida.= '<th class = "text-center"  width = "30px" height = "30px">No.</td>';
	$salida.= '<th class = "text-center"  width = "75px">Cantidad</td>';
	$salida.= '<th class = "text-center"  width = "250px">Descipci&oacute;n</td>';
	$salida.= '<th class = "text-center"  width = "75px">Prec. Unitario</td>';
	$salida.= '<th class = "text-center"  width = "75px">Descuento</td>';
	$salida.= '<th class = "text-center"  width = "75px">Monto</td>';
	$salida.= '<th class = "text-center"  width = "60px"></td>';
	$salida.= '</tr>';
	$STotal = 0;
	$DescU = 0;
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Cantidad
			$cantidad = $row["dcomtemp_cantidad"];
			$salida.= '<td class = "text-center" ><span id = "spancant'.$i.'">'.$cantidad.'</span></td>';
			//Descripcion o Articulo
			$descripcion = utf8_decode($row["dcomtemp_detalle"]);
			$salida.= '<td class = "text-left">'.$descripcion.'</td>';
			//Precio U.
			$mons = trim($row["mon_simbolo"]);
			$precio = trim($row["dcomtemp_precio"]);
			$precio = number_format($precio, 2, '.', '');
			$salida.= '<td class = "text-center" >'.$mons.' '.$precio.'</td>';
			//Descuento
			$desc = trim($row["dcomtemp_descuento"]);
			$DescU+= $desc;
			$desc = number_format($desc, 2, '.', '');
			$salida.= '<td class = "text-center" >'.$mons.' '.$desc.'</td>';
			//sub Total
			$total = trim($row["dcomtemp_total"]);
			$tcambio = trim($row["dcomtemp_tcambio"]);
			$Rcambiar = Cambio_Moneda($tcambio,$compMonCambio,$total);
			$STotal+= $Rcambiar;
			$total = number_format($total, 2, '.', '');
			$salida.= '<td class = "text-center" ><span id = "spanstot'.$i.'">'.trim($mons).' '.$total.'</span></td>';
			//---
			$cod = $row["dcomtemp_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "window.parent.EditarFilaImportada('.$cod.',\''.$clase.'\','.$suc.');" title = "Editar Fila" ><i class="fa fa-pencil"></i></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "xajax_Quita_Fila_Compra('.$cod.',\''.$clase.'\','.$suc.');" title = "Quitar Fila" ><i class="fa fa-trash"></i></button>';
			$salida.= '</td>';
			//--
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
			$salida.= '<b>NOTA:</b> MONEDA PARA FACTURACI&Oacute;N: <b>'.$compMonDesc.'</b>. TIPO DE CAMBIO '.$compMonCambio.' x 1';
			$salida.= '</span></td>';
			$salida.= '<td class = "text-center">Desc/Unitarios</td>';
			$salida.= '<td class = "text-center" ><b><span id = "spanpromdesc">'.$compMonSimb.' '.$DescU.'</span></b></td>';
			$salida.= '<td class = "text-center" >-</td>';
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "hidden" name = "promdesc" id = "promdesc" value = "'.$DescU.'" /></td>';
			$salida.= '</td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">Subtotal</td>';
			$salida.= '<td class = "text-center" >-</td>';
			$salida.= '<td class = "text-center" ><b><span id = "spanstotal">'.$compMonSimb.' '.$STotal.'</span></b>';
			$salida.= '<input type = "hidden" name = "stotal" id = "stotal" value = "'.$STotal.'" />';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">Desc/General</td>';
			$salida.= '<td class = "text-center" >-</td>';
			$salida.= '<td class = "text-center" ><b><span id = "spandscgeneral">'.$compMonSimb.' '.$descuento.'</span></b>';
			$salida.= '<input type = "hidden" name = "tdescuento" id = "tdescuento" value = "'.$descuento.'" />';
			$salida.= '<input type = "hidden" name = "ttdescuento" id = "ttdescuento" value = "'.$tfdsc.'" />';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">TOTAL</td>';
			$salida.= '<td class = "text-center" >-</td>';
			$salida.= '<td class = "text-center" ></b><span id = "spanttotal">'.$compMonSimb.' '.$Total.'</span></b>';
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


function tabla_filas_compra_pago($filas,$tpago,$monto,$moneda,$tcambio,$opera,$boucher,$observ,$empresa,$caja,$banco,$cuenta,$tcambiodia){
		//convierte strig plano en array
		$tpago = explode("|", $tpago);
		$monto = explode("|", $monto);
		$moneda = explode("|", $moneda);
		$tcambio = explode("|", $tcambio);
		$opera = explode("|", $opera);
		$boucher = explode("|", $boucher);
		$observ = explode("|", $observ);
		$empresa = explode("|", $empresa);
		$caja = explode("|", $caja);
		$banco = explode("|", $banco);
		$cuenta = explode("|", $cuenta);
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
			$salida.= '<input type = "hidden" name = "Toperador'.$i.'" id = "Toperador'.$i.'" value = "'.utf8_decode($opera[$i]).'" />';
			$salida.= '<input type = "hidden" name = "Tboucher'.$i.'" id = "Tboucher'.$i.'" value = "'.trim($boucher[$i]).'" />';
			$salida.= '<input type = "hidden" name = "Tobserva'.$i.'" id = "Tobserva'.$i.'" value = "'.utf8_decode($observ[$i]).'" />';
			$salida.= '<input type = "hidden" name = "Tsucur'.$i.'" id = "Tsucur'.$i.'" value = "'.$empresa[$i].'" />';
			$salida.= '<input type = "hidden" name = "Tcaja'.$i.'" id = "Tcaja'.$i.'" value = "'.$caja[$i].'" />';
			$salida.= '<input type = "hidden" name = "Tbanco'.$i.'" id = "Tbanco'.$i.'" value = "'.$banco[$i].'" />';
			$salida.= '<input type = "hidden" name = "Tcuenta'.$i.'" id = "Tcuenta'.$i.'" value = "'.$cuenta[$i].'" />';
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



function tabla_inicio_compra_pago($filas){
			//----
			$salida.= '<table>';
	$i = 1;	
	if($filas>0){
		for($i = 1; $i <= $filas; $i ++){
			$salida.= '<td>';
			$salida.= '<input type = "hidden" name = "Ttpag'.$i.'" id = "Ttpag'.$i.'" />';
			$salida.= '<input type = "hidden" name = "Tmonto'.$i.'" id = "Tmonto'.$i.'" />';
			$salida.= '<input type = "hidden" name = "Tmoneda'.$i.'" id = "Tmoneda'.$i.'" />';
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


function tabla_lotes_compra($filas,$lot='',$art='',$gru=''){
	//convierte strig plano en array
	$lot = explode("|", $lot);
	$art = explode("|", $art);
	$gru = explode("|", $gru);
	//----
			$salida.= '<table>';
	$i = 1;	
	if($filas>0){
		for($i = 1; $i <= $filas; $i ++){
			$salida.= '<tr>';
			$salida.= '<td class = "celda">Lote #: </td>';
			//-
			$desc = Agrega_Ceros($lot[$i])."-".Agrega_Ceros($art[$i])."-".Agrega_Ceros($gru[$i]);
			$salida.= '<td class = "busqueda">'.$desc;
			$salida.= '<input type = "hidden" name = "TLlot'.$i.'" id = "TLlot'.$i.'" value = "'.$lot[$i].'"/>';
			$salida.= '<input type = "hidden" name = "TLart'.$i.'" id = "TLart'.$i.'" value = "'.$art[$i].'"/>';
			$salida.= '<input type = "hidden" name = "TLgru'.$i.'" id = "TLgru'.$i.'" value = "'.$gru[$i].'"/>';
			$salida.= '</td>';
			$salida.= '</tr>';
		}
	}else{
			$salida.= '<tr>';
			$salida.= '<td><span class = "celda">No hay Lotes Enlazados</span></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td>';
			$salida.= '<input type = "hidden" name = "TLlot0" id = "TLot0" />';
			$salida.= '<input type = "hidden" name = "TLart0" id = "TLart0" />';
			$salida.= '<input type = "hidden" name = "TLgru0" id = "TLgru0" />';
			$salida.= '</td>';
			$salida.= '</tr>';
	}	
			//----
			$salida.= '<tr>';
			$salida.= '<td><input type = "hidden" name = "LotTotal" id = "LotTotal" value = "'.$filas.'"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
	
	return $salida;
}


function tabla_creditos($comp,$montext,$tcambio,$monsimbolo){
	$ClsCred = new ClsCredito();
	$result = $ClsCred->get_credito_compra("",$comp);
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
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
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		$montototal = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center"  >'.$i.'.</td>';
			//Codigo
			$cod = $row["cred_codigo"];
			$comp = $row["cred_compra"];
			$cod = Agrega_Ceros($cod);
			$comp = Agrega_Ceros($comp);
			$codigo = $cod."-".$comp;
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
			$monto = $mons.". ".number_format($mont, 2, '.', '');
			$salida.= '<td class = "text-center" >'.$monto.'</td>';
			//cambio
			$camb = $row["cred_tcambio"];
			$salida.= '<td class = "text-center" >'.$camb.' x 1</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '<br>';
	}else{
		$salida.= '<div class = "alert alert-warning text-center">No se Registran Creditos en esta Compra &oacute; Gasto</div>';
		$salida.= '<br>';
	}
	
	return $salida;
}

function tabla_pagos($comp,$comtotal,$credtotal,$monid,$montext,$tcambio,$monsimbolo){
	$ClsPag = new ClsPago();
	$result = $ClsPag->get_pago_compra("",$comp);
			
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
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
			$salida.= '</thead>';
		$i = 1;	
		$montototal = 0;
	if(is_array($result)){
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center"  >'.$i.'.</td>';
			//Codigo
			$cod = $row["pag_codigo"];
			$comp = $row["pag_compra"];
			$cod = Agrega_Ceros($cod);
			$comp = Agrega_Ceros($comp);
			$codigo = $cod."-".$comp;
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
			$montototal = number_format($montototal, 2, '.', '');
			$salida.= '<td class = "text-center" >'.$monsimbolo.'. '.$montototal.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
	}
			//----
			$saldo = $comtotal - $montototal;
			$saldo = number_format($saldo, 2, '.', '');
			$nota = ($saldo == 0)?"<b style = 'color:green'>VENTA CANCELADA EN SU TOTALIDAD</b>":"<br>";
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "10" >'.$nota.'</td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-right" colspan = "9" align = "right"> <b>TOTAL DE LA FACTURA</b></td>';
			$salida.= '<td class = "text-right" ><b>'.$monsimbolo.'. '.$comtotal.'</b>';
			$salida.= '</tr>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-right" colspan = "9" align = "right"> <b>TOTAL DE COMPRA AL CREDITO</b></td>';
			$salida.= '<td class = "text-right" ><b>'.$monsimbolo.'. '.$credtotal.'</b>';
			$salida.= '<input type = "hidden" name = "comp" id = "comp" value = "'.$comp.'"/>';
			$salida.= '<input type = "hidden" name = "factotal" id = "factotal" value = "'.$comtotal.'"/>';
			$salida.= '<input type = "hidden" name = "tcambio" id = "tcambio" value = "'.$tcambio.'"/>';
			$salida.= '<input type = "hidden" name = "montext" id = "montext" value = "'.$montext.'"/></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-right" colspan = "9" align = "right"> <b>TOTAL ACUMULADO</b></td>';
			$salida.= '<td class = "text-right" ><b>'.$monsimbolo.'. '.$montototal.'</b>';
			$salida.= '<input type = "hidden" name = "montototal" id = "montototal" value = "'.$montototal.'"/></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-right" colspan = "9" align = "right"> <b>SALDO</b></td>';
			$salida.= '<td class = "text-right" ><b style = "color:green">'.$monsimbolo.'. '.$saldo.'</b>';
			$salida.= '<input type = "hidden" name = "moneda" id = "moneda" value = "'.$monid.'"/>';
			$salida.= '<input type = "hidden" name = "saldo" id = "saldo" value = "'.$saldo.'"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '<br>';
		
	return $salida;
}


function tabla_lista_compras($result){
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "70px"></th>';
			$salida.= '<th class = "text-center" width = "60px"># TRANS.</th>';
			$salida.= '<th class = "text-center" width = "120px">PROVEEDOR</th>';
			$salida.= '<th class = "text-center" width = "70px">DOC. REF.</th>';
			$salida.= '<th class = "text-center" width = "100px">EMPRESA</th>';
			$salida.= '<th class = "text-center" width = "120px">FECHA/HORA</th>';
			$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
			$salida.= '<th class = "text-center" width = "70px">MONEDA</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["com_situacion"];
			$comp = $row["com_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-default btn-xs" href = "FRMpago.php?comp='.$comp.'" title = "Seleccionar Compra" ><span class="fa fa-check text-success"></span></a> ';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "Ver_Detalle_Compra('.$comp.')" title = "Ver Detalle de Historial" ><span class="fa fa-search"></span></button>';
			$salida.= '</td>';
			//Codigo
			$comp = Agrega_Ceros($comp);
			$salida.= '<td class = "text-center" >'.$comp.'</td>';
			//cliente
			$pro = utf8_decode($row["prov_nombre"]);
			$salida.= '<td class = "text-center">'.$pro.'</td>';
			//referencia
			$ref = utf8_decode($row["com_doc"]);
			$salida.= '<td class = "text-center" >'.$ref.'</td>';
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center" >'.$suc.'</td>';
			//Fecha / Hora
			$fec = $row["com_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//total
			$tot = number_format($row["com_total"],2,'.','');
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" ><b>'.$mons.'. '.$tot.'</b></td>';
			//Moneda
			$mon = utf8_decode($row["mon_desc"]);
			$salida.= '<td class = "text-center" >'.$mon.'</td>';
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


function tabla_creditos_x_pagar($comp,$tipo,$suc,$doc,$fini,$ffin){
	$ClsCred = new ClsCredito();
	$result = $ClsCred->get_credito_compra("",$comp,$doc,$tipo,$suc,$fini,$ffin,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" width = "30px"  >No.</td>';
			$salida.= '<th class = "text-center" width = "20px"></th>';
			$salida.= '<td class = "text-center" width = "80px"  ># CREDITO</td>';
			$salida.= '<td class = "text-center" width = "80px"  ># COMPRA</td>';
			$salida.= '<td class = "text-center" width = "120px"  >FORMA PAG.</td>';
			$salida.= '<td class = "text-center" width = "80px"  >AUTORIZ&Oacute;</td>';
			$salida.= '<td class = "text-center" width = "80px"  >No. DOC.</td>';
			$salida.= '<td class = "text-center" width = "120px"  >FECHA/HORA</td>';
			$salida.= '<td class = "text-center" width = "160px"  >OBSERVACIONES</td>';
			$salida.= '<td class = "text-center" width = "70px"  >MONTO</td>';
			$salida.= '<td class = "text-center" width = "50px"  >T/C</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
			
		$i = 1;	
		$montototal = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center"  >'.$i.'.</td>';
			//Codigo
			$cod = trim($row["cred_codigo"]);
			$comp = trim($row["com_codigo"]);
			$codigo = Agrega_Ceros($row["cred_codigo"])."-".Agrega_Ceros($row["com_codigo"]);
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "Ejecutar_Credito('.$cod.','.$comp.')" title = "Ejecutar Cr�dito (Quitar del Listado)" ><span class="fa fa-check text-success"></span></button>';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-center" >CRED-'.$codigo.'</td>';
			$salida.= '<td class = "text-center" >'.$comp.'</td>';
			//FORMA de Pago
			$tpag = utf8_decode($row["tpago_desc_md"]);
			$salida.= '<td class = "text-center" >'.$tpag.'</td>';
			//Operador o Banco
			$opera = utf8_decode($row["cred_operador"]);
			$salida.= '<td class = "text-center" >'.$opera.'</td>';
			//Documento o Boucher
			$doc = utf8_decode($row["com_doc"]);
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
			$salida.= '</tr>';
			$i++;
		}
			//----
			$i--;
			$salida.= '</table>';
			$salida.= '<br>';
	}else{
		$salida.= '<div class = "alert alert-warning text-center" >No se Registran Creditos en esta Compra &oacute; Gasto</div>';
		$salida.= '<br>';
	}
	
	return $salida;
}


function tabla_pagos2($comp,$tcambio,$monsimbolo){
	$ClsPag = new ClsPago();
	$result = $ClsPag->get_pago_compra("",$comp);
	
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
			$comp = $row["pag_compra"];
			$cod = Agrega_Ceros($cod);
			$comp = Agrega_Ceros($comp);
			$codigo = $cod."-".$comp;
			$salida.= '<td class = "text-center" >'.$codigo.'</td>';
			//FORMA de Pago
			$tpag = $row["tpago_desc_md"];
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


function tabla_historial_compra($cod,$tipo,$prov,$suc,$doc,$fini,$ffin,$sit,$form){
	$ClsComp = new ClsCompra();
	$result = $ClsComp->get_compra($cod,$tipo,$prov,$suc,$doc,'',$fini,$ffin,'1,2');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px"></th>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "60px"># TRANS.</th>';
			$salida.= '<th class = "text-center" width = "120px">PROVEEDOR</th>';
			$salida.= '<th class = "text-center" width = "70px">DOC. REF.</th>';
			$salida.= '<th class = "text-center" width = "100px">EMPRESA</th>';
			$salida.= '<th class = "text-center" width = "120px">FECHA/HORA</th>';
			$salida.= '<th class = "text-center" width = "50px">DESCUENTO</th>';
			$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
			$salida.= '<th class = "text-center" width = "70px">MONEDA</th>';
			$salida.= '<th class = "text-center" width = "50px">T/C</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["com_situacion"];
			$comp = $row["com_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "Ver_Detalle_Compra('.$comp.')" title = "Ver Detalle de Historial" ><span class="fa fa-search"></span></button>';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//Codigo
			$comp = Agrega_Ceros($comp);
			$salida.= '<td class = "text-center" >'.$comp.'</td>';
			//cliente
			$pro = utf8_decode($row["prov_nombre"]);
			$salida.= '<td class = "text-center">'.$pro.'</td>';
			//referencia
			$ref = utf8_decode($row["com_doc"]);
			$salida.= '<td class = "text-center" >'.$ref.'</td>';
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center" >'.$suc.'</td>';
			//Fecha / Hora
			$fec = $row["com_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//descuento
			$desc = number_format($row["com_descuento"],2,'.','');
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" >'.$desc.'</td>';
			//total
			$tot = number_format($row["com_total"],2,'.','');
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" ><b>'.$mons.'. '.$tot.'</b></td>';
			//Moneda
			$mon = utf8_decode($row["mon_desc"]);
			$salida.= '<td class = "text-center" >'.$mon.'</td>';
			//tcamb
			$tcamb = $row["com_tcambio"];
			$salida.= '<td class = "text-center" >'.$tcamb.' x 1</td>';
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


function tabla_anulacion_compra($cod,$tipo,$prov,$suc,$doc,$fini,$ffin){
	$ClsComp = new ClsCompra();
	$result = $ClsComp->get_compra($cod,$tipo,$prov,$suc,$doc,'',$fini,$ffin,'1,2');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "50px" height = "30px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "60px"># TRANS.</th>';
			$salida.= '<th class = "text-center" width = "120px">PROVEEDOR</th>';
			$salida.= '<th class = "text-center" width = "70px">DOC. REF.</th>';
			$salida.= '<th class = "text-center" width = "100px">EMPRESA</th>';
			$salida.= '<th class = "text-center" width = "120px">FECHA/HORA</th>';
			$salida.= '<th class = "text-center" width = "50px">DESCUENTO</th>';
			$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
			$salida.= '<th class = "text-center" width = "70px">MONEDA</th>';
			$salida.= '<th class = "text-center" width = "50px">T/C</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["com_situacion"];
			$comp = $row["com_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "ConfirmAnular('.$comp.');" title = "Anular Compra o Gasto" ><span class="glyphicon glyphicon-trash"></span></button>';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-center"  >'.$i.'.</td>';
			//Codigo
			$comp = Agrega_Ceros($comp);
			$salida.= '<td class = "text-center" >'.$comp.'</td>';
			//cliente
			$pro = utf8_decode($row["prov_nombre"]);
			$salida.= '<td class = "text-center">'.$pro.'</td>';
			//referencia
			$ref = $row["com_doc"];
			$salida.= '<td class = "text-center" >'.$ref.'</td>';
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center" >'.$suc.'</td>';
			//Fecha / Hora
			$fec = $row["com_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//descuento
			$desc = number_format($row["com_descuento"],2,'.','');
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" >'.$desc.'</td>';
			//total
			$tot = number_format($row["com_total"],2,'.','');
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" ><b>'.$mons.'. '.$tot.'</b></td>';
			//Moneda
			$mon = utf8_decode($row["mon_desc"]);
			$salida.= '<td class = "text-center" >'.$mon.'</td>';
			//tcamb
			$tcamb = $row["com_tcambio"];
			$salida.= '<td class = "text-center" >'.$tcamb.' x 1</td>';
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

//echo tabla_historial_compra($cod,$tipo,$prov,$suc,$doc,$fini,$ffin,$sit,"H");
//echo tabla_detalle_compra(8);
//echo Caja_Empresa_html(1,$caj,$onclick);
//echo $contenido;

?>
