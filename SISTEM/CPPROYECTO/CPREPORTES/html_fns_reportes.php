<?php 
include_once('../../html_fns.php');

function rep_tabla_pagos($vent,$factotal,$credtotal,$monid,$montext,$tcambio,$monsimbolo){
	$ClsPag = new ClsPago();
	$ClsMon = new ClsMoneda();
	$result = $ClsPag->get_pago_venta("",$vent);
		
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" align = "center" >No.</th>';
			$salida.= '<th width = "80px" align = "center" ># TRANS.</th>';
			$salida.= '<th width = "120px" align = "center" >FORMA PAG.</th>';
			$salida.= '<th width = "80px" align = "center" >OP./BAN</th>';
			$salida.= '<th width = "80px" align = "center" >DOC.</th>';
			$salida.= '<th width = "120px" align = "center" >FECHA/HORA</th>';
			$salida.= '<th width = "180px" align = "center" >OBSERVACIONES</th>';
			$salida.= '<th width = "50px" align = "center" >MONTO</th>';
			$salida.= '<th width = "50px" align = "center" >T/C</th>';
			$salida.= '<th width = "50px" align = "center" >ACUM.</th>';
			$salida.= '</tr>';
		$i = 1;	
		$montototal = 0;
	if(is_array($result)){
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td align = "center" >'.$i.'.</td>';
			//Codigo
			$cod = $row["pag_codigo"];
			$vent = $row["pag_venta"];
			$cod = Agrega_Ceros($cod);
			$vent = Agrega_Ceros($vent);
			$codigo = $cod."-".$vent;
			$salida.= '<td align = "center">'.$codigo.'</td>';
			//FORMA de Pago
			$tpag = $row["tpago_desc_md"];
			$salida.= '<td align = "center">'.$tpag.'</td>';
			//Operador o Banco
			$opera = $row["pag_operador"];
			$salida.= '<td align = "center">'.$opera.'</td>';
			//Documento o Boucher
			$doc = $row["pag_doc"];
			$salida.= '<td align = "center">'.$doc.'</td>';
			//fecha hora
			$fec = $row["pag_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//observaciones
			$obs = $row["pag_obs"];
			$salida.= '<td  class = "text-justify">'.$obs.'</td>';
			//monto
			$mont = $row["pag_monto"];
			$mons = $row["mon_simbolo"];
			$moncamb = $row["mon_cambio"];
			$monto = $mons.". ".$mont;
			$salida.= '<td align = "center">'.$monto.'</td>';
			//cambio
			$camb = $row["pag_tcambio"];
			$salida.= '<td align = "center">'.$camb.' x 1</td>';
			//acumulado
			$Dcambiar = Cambio_Moneda($moncamb,$tcambio,$mont);
			$montototal += $Dcambiar;
			$salida.= '<td align = "center">'.$monsimbolo.'. '.$montototal.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
	}
			//----
			$saldo = $factotal - $montototal;
			$nota = ($saldo == 0)?"<b style = 'color:green'>VENTA CANCELADA EN SU TOTALIDAD</b>":"<br>";
			$salida.= '<tr>';
			$salida.= '<th colspan = "10" align = "center">'.$nota.'</th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th colspan = "9" align = "right"> <b>TOTAL DE LA FACTURA</b></th>';
			$salida.= '<th align = "center"><b>'.$monsimbolo.'. '.$factotal.'</b></th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th colspan = "9" align = "right"> <b>TOTAL DE VENTA AL CREDITO</b></th>';
			$salida.= '<th align = "center"><b>'.$monsimbolo.'. '.$credtotal.'</b>';
			$salida.= '<input type = "hidden" name = "vent" id = "vent" value = "'.$vent.'"/>';
			$salida.= '<input type = "hidden" name = "factotal" id = "factotal" value = "'.$factotal.'"/>';
			$salida.= '<input type = "hidden" name = "tcambio" id = "tcambio" value = "'.$tcambio.'"/>';
			$salida.= '<input type = "hidden" name = "montext" id = "montext" value = "'.$montext.'"/></th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th colspan = "9" align = "right"> <b>TOTAL ACUMULADO</b></th>';
			$salida.= '<th align = "center"><b>'.$monsimbolo.'. '.$montototal.'</b>';
			$salida.= '<input type = "hidden" name = "montototal" id = "montototal" value = "'.$montototal.'"/></th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th colspan = "9" align = "right"> <b>SALDO</b></th>';
			$salida.= '<th align = "center"><b style = "color:green">'.$monsimbolo.'. '.$saldo.'</b>';
			$salida.= '<input type = "hidden" name = "moneda" id = "moneda" value = "'.$monid.'"/>';
			$salida.= '<input type = "hidden" name = "saldo" id = "saldo" value = "'.$saldo.'"/></th>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
	
	return $salida;
}

function rep_tabla_cuentas_x_cobrar($ven,$suc,$tipo,$fini,$ffin){
	$ClsVntCred = new ClsVntCredito();
	$result = $ClsVntCred->get_cobro_creditos('',$ven,$suc,'',$tipo,'','','','',$fini,$ffin,'','',1);
	
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px">No.</th>';
			$salida.= '<th width = "100px"># TRANSACCIÓN</th>';
			$salida.= '<th width = "70px"># VENTA</th>';
			$salida.= '<th width = "110px">EMPRESA</th>';
			$salida.= '<th width = "110px">OPERADOR/BANCO</th>';
			$salida.= '<th width = "100px">BOUCHER/CHEQUE</th>';
			$salida.= '<th width = "120px">FECHA/HORA</th>';
			$salida.= '<th width = "60px">MONTO</th>';
			$salida.= '<th width = "50px" align = "center" >T/C</th>';
			$salida.= '</tr>';
	if(is_array($result)){
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["ven_situacion"];
			$ccred = $row["ccred_codigo"];
			$ven = $row["ven_codigo"];
			$Vtcamb = $row["ven_tcambio"];
			$Vmons = $row["mon_simbolo"];
			//--
			$salida.= '<td align = "center" >'.$i.'.</td>';
			//Codigo
			$ccred = Agrega_Ceros($ccred);
			$ven = Agrega_Ceros($ven);
			$salida.= '<td align = "center">'.$ccred.'-'.$ven.'</td>';
			//Venta
			$salida.= '<td align = "center">'.$ven.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td align = "center">'.$suc.'</td>';
			//Operador
			$opera = $row["ccred_operador"];
			$salida.= '<td class = "celdadash">'.$opera.'</td>';
			//Doc
			$doc = $row["ccred_boucher"];
			$salida.= '<td class = "celdadash">'.$doc.'</td>';
			//Fecha / Hora
			$fec = $row["ccred_fechor_venta"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//monto
			$tot = $row["ccred_monto"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td align = "center"><b>'.$mons.'. '.$tot.'</b></td>';
			//cambio
			$camb = $row["ccred_tcambio"];
			$salida.= '<td align = "center">'.$camb.' x 1</td>';
			//--
			$salida.= '</tr>';
			//--
			/*$salida.= '<tr>';
			$salida.= '<td colspan = "11"><div id = "divVent'.$i.'" align = "center" ></div></td>';
			$salida.= '</tr>';*/
			$i++;
		}
	}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th colspan = "11" align = "right"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
		
	return $salida;
}


function rep_tabla_creditos_x_cobrar($vent,$suc,$fini,$ffin){
	$ClsCred = new ClsCredito();
	$result = $ClsCred->get_credito_venta("",$vent,$suc,'',$fini,$ffin,1);
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" align = "center" >No.</th>';
			$salida.= '<th width = "80px" align = "center" ># CREDITO</th>';
			$salida.= '<th width = "70px" align = "center" ># VENTA</th>';
			$salida.= '<th width = "180px" align = "center" >AUTORIZÓ</th>';
			$salida.= '<th width = "100px" align = "center" >No. DOC.</th>';
			$salida.= '<th width = "150px" align = "center" >FECHA/HORA</th>';
			$salida.= '<th width = "285px" align = "center" >OBSERVACIONES</th>';
			$salida.= '<th width = "70px" align = "center" >MONTO</th>';
			$salida.= '<th width = "70px" align = "center" >T/C</th>';
			$salida.= '</tr>';
		$i = 1;	
		$montototal = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//Codigo
			$cod = trim($row["cred_codigo"]);
			$vent = trim($row["cred_venta"]);
			$codigo = Agrega_Ceros($row["cred_codigo"])."-".Agrega_Ceros($row["cred_venta"]);
			//--
			$salida.= '<td align = "center" >'.$i.'.</td>';
			//-
			$salida.= '<td align = "center">CRED-'.$codigo.'</td>';
			//FORMA de Pago
			$salida.= '<td align = "center">'.$vent.'</td>';
			//Operador o Banco
			$opera = $row["cred_operador"];
			$salida.= '<td align = "center">'.$opera.'</td>';
			//Documento o Boucher
			$doc = $row["cred_doc"];
			$salida.= '<td align = "center">'.$doc.'</td>';
			//fecha hora
			$fec = $row["cred_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//observaciones
			$obs = $row["cred_obs"];
			$salida.= '<td  class = "text-justify">'.$obs.'</td>';
			//monto
			$mont = $row["cred_monto"];
			$mons = $row["mon_simbolo"];
			$moncamb = $row["mon_cambio"];
			$monto = $mons.". ".$mont;
			$salida.= '<td align = "center">'.$monto.'</td>';
			//cambio
			$camb = $row["cred_tcambio"];
			$salida.= '<td align = "center">'.$camb.' x 1</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			//----
			$i--;
			$salida.= '<tr>';
			$salida.= '<th colspan = "11" align = "right"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}else{
		$salida.= '<div class = "celda" align = "center">No se Registran Creditos en esta Venta</div>';
	}
	
	return $salida;
}


/////////////////////////// Historiales ///////////////////


function rep_tabla_anulacion_venta($vent,$suc,$pv,$ser,$facc,$fini,$ffin){
	$ClsVent = new ClsVenta();
	$result = $ClsVent->get_venta($vent,'',$pv,$suc,'','',$fini,$ffin,'',0);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px">No.</th>';
			$salida.= '<th width = "60px"># VENTA</th>';
			$salida.= '<th width = "150px">CLIENTE</th>';
			$salida.= '<th width = "100px">EMPRESA</th>';
			$salida.= '<th width = "90px">P. VENTA</th>';
			$salida.= '<th width = "120px">FECHA/HORA</th>';
			$salida.= '<th width = "50px">%DESC.</th>';
			$salida.= '<th width = "50px">MONTO</th>';
			$salida.= '<th width = "70px">MONEDA</th>';
			$salida.= '<th width = "50px">T/C</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["ven_situacion"];
			$vent = $row["ven_codigo"];
			//--
			$salida.= '<td align = "center" >'.$i.'.</td>';
			//Codigo
			$vent = Agrega_Ceros($vent);
			$salida.= '<td align = "center">'.$vent.'</td>';
			//cliente
			$cli = $row["cli_nombre"];
			$salida.= '<td class = "celdadash">'.$cli.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td align = "center">'.$suc.'</td>';
			//punto de venta
			$pv = $row["pv_nombre"];
			$salida.= '<td align = "center">'.$pv.'</td>';
			//Fecha / Hora
			$fec = $row["ven_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//descuento
			$desc = $row["ven_descuento"];
			$salida.= '<td align = "center">'.$desc.' %</td>';
			//total
			$tot = $row["ven_total"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td align = "center"><b>'.$mons.'. '.$tot.'</b></td>';
			//Moneda
			$mon = $row["mon_desc"];
			$salida.= '<td align = "center">'.$mon.'</td>';
			//tcamb
			$tcamb = $row["ven_tcambio"];
			$salida.= '<td align = "center">'.$tcamb.' x 1</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th colspan = "13" align = "right"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


///////////////////////////////

function rep_historial_venta_descargado($vent,$suc,$pv,$grup,$ser,$facc,$fini,$ffin,$fac,$sit){
	$ClsVent = new ClsVenta();
	$ClsFac = new ClsFactura();
	$ClsMon = new ClsMoneda();
	if($ser != "" && $facc != ""){
		$result1 = $ClsFac->get_factura($facc,$ser);
		if(is_array($result1)){
			foreach ($result1 as $row1) {
				$vent = trim($row1["ven_codigo"]);
			}
		}
	}
	//-- trae datos de moneda por defecto
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$montcambio = trim($row['mon_cambio']); //Tipo de Cambio del dia para la moneda por defecto
			$monsimbolo = trim($row['mon_simbolo']); //simbolo de la moneda por defecto
			$montexto = trim($row['mon_desc']); //simbolo de la moneda por defecto
		}
	}
	$result = $ClsVent->get_hist_venta_lotes('',$vent,$grup,'',$pv,$suc,'','',$fini,$ffin,$fac,$sit);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th align = "center" width = "30px"><b>No.</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Venta</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Factura</b></th>';
			$salida.= '<th align = "center" width = "125px"><b>Cliente</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Vendedor (Cod.)</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Cajero (Cod.)</b></th>';
			$salida.= '<th align = "center" width = "95px"><b>Empresa</b></th>';
			$salida.= '<th align = "center" width = "95px"><b>P. Venta</b></th>';
			$salida.= '<th align = "center" width = "95px"><b>Fecha/Hora</b></th>';
			$salida.= '<th align = "center" width = "100px"><b>Lote</b></th>';
			$salida.= '<th align = "center" width = "300px"><b>Descipción</b></th>';
			$salida.= '<th align = "center" width = "75px"><b>Cant.</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>P. Costo</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>P. Margen</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>P. Venta</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>Variación %</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>% Desc.</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>C * P</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>T/C</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>Total</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>IVA</b></th>';
			$salida.= '</tr>';
		$Total = 0;
		$Rtotal = 0;
		$IVARtotal = 0;
		$TIVA = 0;
		$Tdesc = 0;
		$i = 1;	
		foreach($result as $row){
			//No.
			$salida.= '<th align = "center">'.$i.'.</th>';
			//Venta
			$vent = $row["ven_codigo"];
			$vent = Agrega_Ceros($vent);
			$salida.= '<td align = "center">'.$vent.'</td>';
			//Factura
			$fac = $row["ven_ser_numero"]." ".Agrega_Ceros($row["ven_fac_numero"]);
			$salida.= '<td align = "center">'.$fac.'</td>';
			//Cliente
			$cli = $row["cli_nombre"];
			$salida.= '<td align = "left">'.$cli.'</td>';
			//Vendedor
			$ve = $row["ven_vendedor"];
			$ve = Agrega_Ceros($ve);
			$salida.= '<td align = "center">'.$ve.'</td>';
			//Cajero
			$caj = $row["ven_cajero"];
			$caj = Agrega_Ceros($caj);
			$salida.= '<td align = "center">'.$caj.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td align = "left">'.$suc.'</td>';
			//Punto de Venta
			$pv = $row["pv_nombre"];
			$salida.= '<td align = "left">'.$pv.'</td>';
			//Fecha / Hora
			$fec = $row["ven_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//Lote
			$lot = Agrega_Ceros($row["lot_codigo"])."-".Agrega_Ceros($row["lot_articulo"])."-".Agrega_Ceros($row["lot_grupo"]);
			$salida.= '<td align = "center">'.$lot.'</td>';
			//Descripcion o Articulo
			$desc = $row["dven_detalle"];
			$salida.= '<td align = "left">'.$desc.'</td>';
			//Cantidad
			$cant = $row["det_cantidad"];
			$salida.= '<td align = "center">'.$cant.'</td>';
			//Precio Costo.
			$prec = $row["lot_precio_costo"];
			$salida.= '<td align = "center">'.$mons.'. '.$prec.'</td>';
			//Precio Margen.
			$prem = $row["lot_precio_manufactura"];
			$mons = $row["mon_simbolo"];
			$Vmons = $row["mon_simbolo_venta"];
			$salida.= '<td align = "center">'.$mons.'. '.$prem.'</td>';
			//Precio Venta.
			$pre = $row["dven_precio"];
			$salida.= '<td align = "center">'.$mons.'. '.$pre.'</td>';
			//Variacion
			$var = $pre - $prec;
			$porvar = ($var*100)/$pre;
			$porvar = round($porvar, 2);
			$salida.= '<td align = "center">'.$mons.'. '.$var.' ('.$porvar.'%)</td>';
			//Descuento
			$dsc = $row["dven_descuento"];
			$salida.= '<td align = "center">'.$dsc.' %</td>';
			//sub Total
			$monc = $row["dven_tcambio"];
			$Vmonc = $row["ven_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$DcambiarT = Cambio_Moneda($monc,$montcambio,$Dcambiar);
			$Total+= $DcambiarT;
			$Rcambiar = Cambio_Moneda($monc,$montcambio,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = round($stot, 2);
			//Iva
			$faciva = $row["ven_factura"];
			if($faciva == 1){
			$iva = ($stot * 5)/100;
			$iva = round($iva, 2);
			$TIVA+=$iva;
			$IVARtotal += ($DcambiarT);
			}else{
			$iva = 0;
			}
			$salida.= '<td align = "center">'.$mons.' '.$stot.'</td>';
			//---
			$salida.= '<td align = "center">'.$monc.' x 1</td>';
			//---
			$salida.= '<td align = "center">'.$Vmons.' '.$Dcambiar.'</td>';
			//---
			$salida.= '<td align = "center">'.$Vmons.' '.$iva.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
			//--
			$salida.= '<tr>';
			$pdesc = $Rtotal - $Total;//saca la diferencia entre los descuentos y el precio real
			$promdesc = (($pdesc/$Rtotal)*100);
			$promdesc = round($promdesc, 2);
			$salida.= '<th align = "right" colspan = "19"> TOTAL DESCUENTO</th>';
			$salida.= '<th align = "right" colspan = "2">'.$promdesc.'%</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$Total = round($Total, 2);
			$salida.= '<th align = "right" colspan = "19"> TOTAL CON FACTURA</td>';
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$IVARtotal.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "19"> IVA</th>';
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$TIVA.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$Total = round($Total, 2);
			$salida.= '<th align = "right" colspan = "19"> TOTAL TODO IVA INCLUIDO</td>';
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$Total.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "19"> TOTAL TODO SIN IVA</td>';
			$TotalIVA = round($Total - $TIVA,2);
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$TotalIVA.'</th>';
			$salida.= '</tr>';
			//-
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "19"> MONEDA DE CALCULO</td>';
			$salida.= '<th align = "right" colspan = "2">'.$montexto.' ('.$monsimbolo.'.)</th>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</div>';
	}
	return $salida;
}

function rep_historial_venta_nodescargado($vent,$suc,$pv,$grup,$ser,$facc,$fini,$ffin,$fac,$sit){
	$ClsVent = new ClsVenta();
	$ClsFac = new ClsFactura();
	$ClsMon = new ClsMoneda();
	if($ser != "" && $facc != ""){
		$result1 = $ClsFac->get_factura($facc,$ser);
		if(is_array($result1)){
			foreach ($result1 as $row1) {
				$vent = trim($row1["ven_codigo"]);
			}
		}
	}
	//-- trae datos de moneda por defecto
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$montcambio = trim($row['mon_cambio']); //Tipo de Cambio del dia para la moneda por defecto
			$monsimbolo = trim($row['mon_simbolo']); //simbolo de la moneda por defecto
			$montexto = trim($row['mon_desc']); //simbolo de la moneda por defecto
		}
	}
	$result = $ClsVent->get_det_venta_producto('',$vent,'P',$grup,0,'',$pv,$suc,'','',$fini,$ffin,$fac,$sit);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th align = "center" width = "30px"><b>No.</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Venta</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Factura</b></th>';
			$salida.= '<th align = "center" width = "125px"><b>Cliente</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Vendedor (Cod.)</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Cajero (Cod.)</b></th>';
			$salida.= '<th align = "center" width = "95px"><b>Empresa</b></th>';
			$salida.= '<th align = "center" width = "95px"><b>P. Venta</b></th>';
			$salida.= '<th align = "center" width = "95px"><b>Fecha/Hora</b></th>';
			$salida.= '<th align = "center" width = "100px"><b>Lote</b></th>';
			$salida.= '<th align = "center" width = "300px"><b>Descipción</b></th>';
			$salida.= '<th align = "center" width = "75px"><b>Cant.</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>P. Compra</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>P. margen</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>P. Venta</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>Variación %</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>% Desc.</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>C * P</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>T/C</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>Total</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>IVA</b></th>';
			$salida.= '</tr>';
		$Total = 0;
		$Rtotal = 0;
		$IVARtotal = 0;
		$TIVA = 0;
		$Tdesc = 0;
		$i = 1;	
		foreach($result as $row){
			//No.
			$salida.= '<td align = "center">'.$i.'.</td>';
			//Venta
			$vent = $row["ven_codigo"];
			$vent = Agrega_Ceros($vent);
			$salida.= '<td align = "center">'.$vent.'</td>';
			//Factura
			$fac = $row["ven_ser_numero"]." ".Agrega_Ceros($row["ven_fac_numero"]);
			$salida.= '<td align = "center">'.$fac.'</td>';
			//Cliente
			$cli = $row["cli_nombre"];
			$salida.= '<td align = "left">'.$cli.'</td>';
			//Vendedor
			$ve = $row["ven_vendedor"];
			$ve = Agrega_Ceros($ve);
			$salida.= '<td align = "center">'.$ve.'</td>';
			//Cajero
			$caj = $row["ven_cajero"];
			$caj = Agrega_Ceros($caj);
			$salida.= '<td align = "center">'.$caj.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td align = "left">'.$suc.'</td>';
			//Punto de Venta
			$pv = $row["pv_nombre"];
			$salida.= '<td align = "left">'.$pv.'</td>';
			//Fecha / Hora
			$fec = $row["ven_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//Lote
			$salida.= '<td align = "center">---</td>';
			//Descripcion o Articulo
			$desc = $row["dven_detalle"];
			$salida.= '<td align = "left">'.$desc.'</td>';
			//Cantidad
			$cant = $row["dven_cantidad"];
			$salida.= '<td align = "center">'.$cant.'</td>';
			//Precio Compra.
			$salida.= '<td align = "center">-</td>';
			//Precio Costo.
			$salida.= '<td align = "center">-</td>';
			//Precio Venta.
			$mons = $row["mon_simbolo"];
			$monc = $row["dven_tcambio"];
			$Vmonc = $row["ven_tcambio"];
			$Vmons = $row["mon_simbolo_venta"];
			$pre = $row["dven_precio"];
			$salida.= '<td align = "center">'.$mons.'. '.$pre.'</td>';
			//Variacion
			$salida.= '<td align = "center">-</td>';
			//Descuento
			$dsc = $row["dven_descuento"];
			$salida.= '<td align = "center">'.$dsc.' %</td>';
			//sub Total
			$monc = $row["dven_tcambio"];
			$Vmonc = $row["ven_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$DcambiarT = Cambio_Moneda($monc,$montcambio,$Dcambiar);
			$Total+= $DcambiarT;
			$Rcambiar = Cambio_Moneda($monc,$montcambio,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = round($stot, 2);
			//Iva
			$faciva = $row["ven_factura"];
			if($faciva == 1){
			$iva = ($stot * 5)/100;
			$iva = round($iva, 2);
			$TIVA+=$iva;
			$IVARtotal += ($DcambiarT);
			}else{
			$iva = 0;
			}
			$salida.= '<td align = "center">'.$mons.' '.$stot.'</td>';
			//---
			$salida.= '<td align = "center">'.$monc.' x 1</td>';
			//---
			$salida.= '<td align = "center">'.$Vmons.' '.$Dcambiar.'</td>';
			//---
			$salida.= '<td align = "center">'.$Vmons.' '.$iva.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
			//--
			$salida.= '<tr>';
			$pdesc = $Rtotal - $Total;//saca la diferencia entre los descuentos y el precio real
			$promdesc = (($pdesc/$Rtotal)*100);
			$promdesc = round($promdesc, 2);
			$salida.= '<th align = "right" colspan = "19"> TOTAL DESCUENTO</th>';
			$salida.= '<th align = "right" colspan = "2">'.$promdesc.'%</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$Total = round($Total, 2);
			$salida.= '<th align = "right" colspan = "19"> TOTAL CON FACTURA</td>';
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$IVARtotal.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "19"> IVA</th>';
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$TIVA.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$Total = round($Total, 2);
			$salida.= '<th align = "right" colspan = "19"> TOTAL TODO IVA INCLUIDO</td>';
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$Total.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "19"> TOTAL TODO SIN IVA</td>';
			$TotalIVA = round($Total - $TIVA,2);
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$TotalIVA.'</th>';
			$salida.= '</tr>';
			//-
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "19"> MONEDA DE CALCULO</td>';
			$salida.= '<th align = "right" colspan = "2">'.$montexto.' ('.$monsimbolo.'.)</th>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</div>';
	}
	return $salida;
}


function rep_historial_venta_servicios($vent,$suc,$pv,$grup,$ser,$facc,$fini,$ffin,$fac,$sit){
	$ClsVent = new ClsVenta();
	$ClsFac = new ClsFactura();
	$ClsMon = new ClsMoneda();
	if($ser != "" && $facc != ""){
		$result1 = $ClsFac->get_factura($facc,$ser);
		if(is_array($result1)){
			foreach ($result1 as $row1) {
				$vent = trim($row1["ven_codigo"]);
			}
		}
	}
	//-- trae datos de moneda por defecto
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$montcambio = trim($row['mon_cambio']); //Tipo de Cambio del dia para la moneda por defecto
			$monsimbolo = trim($row['mon_simbolo']); //simbolo de la moneda por defecto
			$montexto = trim($row['mon_desc']); //simbolo de la moneda por defecto
		}
	}
	$result = $ClsVent->get_hist_venta_servicios('',$vent,$grup,'',$pv,$suc,'','',$fini,$ffin,$fac,$sit);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th align = "center" width = "30px"><b>No.</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Venta</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Factura</b></th>';
			$salida.= '<th align = "center" width = "125px"><b>Cliente</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Vendedor (Cod.)</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Cajero (Cod.)</b></th>';
			$salida.= '<th align = "center" width = "95px"><b>Empresa</b></th>';
			$salida.= '<th align = "center" width = "95px"><b>P. Venta</b></th>';
			$salida.= '<th align = "center" width = "95px"><b>Fecha/Hora</b></th>';
			$salida.= '<th align = "center" width = "300px"><b>Descipción</b></th>';
			$salida.= '<th align = "center" width = "75px"><b>Cant.</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>P. Costo</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>P. Venta</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>Variación %</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>% Desc.</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>C * P</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>T/C</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>Total</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>IVA</b></th>';
			$salida.= '</tr>';
		$Total = 0;
		$Rtotal = 0;
		$IVARtotal = 0;
		$TIVA = 0;
		$Tdesc = 0;
		$i = 1;	
		foreach($result as $row){
			//No.
			$salida.= '<td align = "center">'.$i.'.</td>';
			//Venta
			$vent = $row["ven_codigo"];
			$vent = Agrega_Ceros($vent);
			$salida.= '<td align = "center">'.$vent.'</td>';
			//Factura
			$fac = $row["ven_ser_numero"]." ".Agrega_Ceros($row["ven_fac_numero"]);
			$salida.= '<td align = "center">'.$fac.'</td>';
			//Cliente
			$cli = $row["cli_nombre"];
			$salida.= '<td align = "left">'.$cli.'</td>';
			//Vendedor
			$ve = $row["ven_vendedor"];
			$ve = Agrega_Ceros($ve);
			$salida.= '<td align = "center">'.$ve.'</td>';
			//Cajero
			$caj = $row["ven_cajero"];
			$caj = Agrega_Ceros($caj);
			$salida.= '<td align = "center">'.$caj.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td align = "left">'.$suc.'</td>';
			//Punto de Venta
			$pv = $row["pv_nombre"];
			$salida.= '<td align = "left">'.$pv.'</td>';
			//Fecha / Hora
			$fec = $row["ven_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//Descripcion o Articulo
			$desc = $row["dven_detalle"];
			$desc = utf8_decode($desc);
			$salida.= '<td align = "left">'.$desc.'</td>';
			//Cantidad
			$cant = $row["dven_cantidad"];
			$salida.= '<td align = "center">'.$cant.'</td>';
			//Precio Costo.
			$prec = $row["ser_precio_costo"];
			$mons = $row["mon_simbolo"];
			$Vmons = $row["mon_simbolo_venta"];
			$salida.= '<td align = "center">'.$mons.'. '.$prec.'</td>';
			//Precio Venta.
			$pre = $row["dven_precio"];
			$mons = $row["mon_simbolo"];
			$Vmons = $row["mon_simbolo_venta"];
			$salida.= '<td align = "center">'.$mons.'. '.$pre.'</td>';
			//Variacion
			$var = $pre - $prec;
			$porvar = ($var*100)/$pre;
			$porvar = round($porvar, 2);
			$salida.= '<td align = "center">'.$mons.'. '.$var.' ('.$porvar.'%)</td>';
			//Descuento
			$dsc = $row["dven_descuento"];
			$salida.= '<td align = "center">'.$dsc.' %</td>';
			//sub Total
			$monc = $row["dven_tcambio"];
			$Vmonc = $row["ven_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$DcambiarT = Cambio_Moneda($monc,$montcambio,$Dcambiar);
			$Total+= $DcambiarT;
			$Rcambiar = Cambio_Moneda($monc,$montcambio,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = round($stot, 2);
			//Iva
			$faciva = $row["ven_factura"];
			if($faciva == 1){
			$iva = ($stot * 5)/100;
			$iva = round($iva, 2);
			$TIVA+=$iva;
			$IVARtotal += ($DcambiarT);
			}else{
			$iva = 0;
			}
			$salida.= '<td align = "center">'.$mons.' '.$stot.'</td>';
			//---
			$salida.= '<td align = "center">'.$monc.' x 1</td>';
			//---
			$salida.= '<td align = "center">'.$Vmons.' '.$Dcambiar.'</td>';
			//---
			$salida.= '<td align = "center">'.$Vmons.' '.$iva.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
			//--
			$salida.= '<tr>';
			$pdesc = $Rtotal - $Total;//saca la diferencia entre los descuentos y el precio real
			$promdesc = (($pdesc/$Rtotal)*100);
			$promdesc = round($promdesc, 2);
			$salida.= '<th align = "right" colspan = "17"> TOTAL DESCUENTO</th>';
			$salida.= '<th align = "right" colspan = "2">'.$promdesc.'%</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$Total = round($Total, 2);
			$salida.= '<th align = "right" colspan = "17"> TOTAL CON FACTURA</td>';
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$IVARtotal.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "17"> IVA</th>';
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$TIVA.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$Total = round($Total, 2);
			$salida.= '<th align = "right" colspan = "17"> TOTAL TODO IVA INCLUIDO</td>';
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$Total.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "17"> TOTAL TODO SIN IVA</td>';
			$TotalIVA = round($Total - $TIVA,2);
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$TotalIVA.'</th>';
			$salida.= '</tr>';
			//-
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "17"> MONEDA DE CALCULO</td>';
			$salida.= '<th align = "right" colspan = "2">'.$montexto.' ('.$monsimbolo.'.)</th>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</div>';
	}
	return $salida;
}


function rep_historial_venta_otros($vent,$suc,$pv,$ser,$facc,$fini,$ffin,$fac,$sit){
	$ClsVent = new ClsVenta();
	$ClsFac = new ClsFactura();
	$ClsMon = new ClsMoneda();
	if($ser != "" && $facc != ""){
		$result1 = $ClsFac->get_factura($facc,$ser);
		if(is_array($result1)){
			foreach ($result1 as $row1) {
				$vent = trim($row1["ven_codigo"]);
			}
		}
	}
	//-- trae datos de moneda por defecto
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$montcambio = trim($row['mon_cambio']); //Tipo de Cambio del dia para la moneda por defecto
			$monsimbolo = trim($row['mon_simbolo']); //simbolo de la moneda por defecto
			$montexto = trim($row['mon_desc']); //simbolo de la moneda por defecto
		}
	}
	$result = $ClsVent->get_det_venta('',$vent,'O','',$pv,$suc,'','',$fini,$ffin,$fac,$sit);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th align = "center" width = "30px"><b>No.</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Venta</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Factura</b></th>';
			$salida.= '<th align = "center" width = "125px"><b>Cliente</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Vendedor (Cod.)</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Cajero (Cod.)</b></th>';
			$salida.= '<th align = "center" width = "95px"><b>Empresa</b></th>';
			$salida.= '<th align = "center" width = "95px"><b>P. Venta</b></th>';
			$salida.= '<th align = "center" width = "95px"><b>Fecha/Hora</b></th>';
			$salida.= '<th align = "center" width = "300px"><b>Descipción</b></th>';
			$salida.= '<th align = "center" width = "75px"><b>Cant.</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>P. Venta</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>% Desc.</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>C * P</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>T/C</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>Total</b></th>';
			$salida.= '<th align = "center" width = "65px"><b>IVA</b></th>';
			$salida.= '</tr>';
		$Total = 0;
		$Rtotal = 0;
		$IVARtotal = 0;
		$TIVA = 0;
		$Tdesc = 0;
		$i = 1;	
		foreach($result as $row){
			//No.
			$salida.= '<td align = "center">'.$i.'.</td>';
			//Venta
			$vent = $row["ven_codigo"];
			$vent = Agrega_Ceros($vent);
			$salida.= '<td align = "center">'.$vent.'</td>';
			//Factura
			$fac = $row["ven_ser_numero"]." ".Agrega_Ceros($row["ven_fac_numero"]);
			$salida.= '<td align = "center">'.$fac.'</td>';
			//Cliente
			$cli = $row["cli_nombre"];
			$salida.= '<td align = "left">'.$cli.'</td>';
			//Vendedor
			$ve = $row["ven_vendedor"];
			$ve = Agrega_Ceros($ve);
			$salida.= '<td align = "center">'.$ve.'</td>';
			//Cajero
			$caj = $row["ven_cajero"];
			$caj = Agrega_Ceros($caj);
			$salida.= '<td align = "center">'.$caj.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td align = "left">'.$suc.'</td>';
			//Punto de Venta
			$pv = $row["pv_nombre"];
			$salida.= '<td align = "left">'.$pv.'</td>';
			//Fecha / Hora
			$fec = $row["ven_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//Descripcion o Articulo
			$desc = $row["dven_detalle"];
			$desc = utf8_decode($desc);
			$salida.= '<td align = "left">'.$desc.'</td>';
			//Cantidad
			$cant = $row["dven_cantidad"];
			$salida.= '<td align = "center">'.$cant.'</td>';
			//Precio Venta.
			$pre = $row["dven_precio"];
			$mons = $row["mon_simbolo"];
			$Vmons = $row["mon_simbolo_venta"];
			$salida.= '<td align = "center">'.$mons.'. '.$pre.'</td>';
			//Descuento
			$dsc = $row["dven_descuento"];
			$salida.= '<td align = "center">'.$dsc.' %</td>';
			//sub Total
			$monc = $row["dven_tcambio"];
			$Vmonc = $row["ven_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$DcambiarT = Cambio_Moneda($monc,$montcambio,$Dcambiar);
			$Total+= $DcambiarT;
			$Rcambiar = Cambio_Moneda($monc,$montcambio,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = round($stot, 2);
			//Iva
			$faciva = $row["ven_factura"];
			if($faciva == 1){
			$iva = ($stot * 5)/100;
			$iva = round($iva, 2);
			$TIVA+=$iva;
			$IVARtotal += ($DcambiarT);
			}else{
			$iva = 0;
			}
			$salida.= '<td align = "center">'.$mons.' '.$stot.'</td>';
			//---
			$salida.= '<td align = "center">'.$monc.' x 1</td>';
			//---
			$salida.= '<td align = "center">'.$Vmons.' '.$Dcambiar.'</td>';
			//---
			$salida.= '<td align = "center">'.$Vmons.' '.$iva.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
			//--
			$salida.= '<tr>';
			$pdesc = $Rtotal - $Total;//saca la diferencia entre los descuentos y el precio real
			$promdesc = (($pdesc/$Rtotal)*100);
			$promdesc = round($promdesc, 2);
			$salida.= '<th align = "right" colspan = "15"> TOTAL DESCUENTO</th>';
			$salida.= '<th align = "right" colspan = "2">'.$promdesc.'%</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$Total = round($Total, 2);
			$salida.= '<th align = "right" colspan = "15"> TOTAL CON FACTURA</td>';
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$IVARtotal.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "15"> IVA</th>';
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$TIVA.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$Total = round($Total, 2);
			$salida.= '<th align = "right" colspan = "15"> TOTAL TODO IVA INCLUIDO</td>';
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$Total.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "15"> TOTAL TODO SIN IVA</td>';
			$TotalIVA = round($Total - $TIVA,2);
			$salida.= '<th align = "right" colspan = "2">'.$monsimbolo.' '.$TotalIVA.'</th>';
			$salida.= '</tr>';
			//-
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "15"> MONEDA DE CALCULO</td>';
			$salida.= '<th align = "right" colspan = "2">'.$montexto.' ('.$monsimbolo.'.)</th>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</div>';
	}
	return $salida;
}


//echo tabla_historial_venta(5,$suc,$pv,$ser,$facc,$fini,$ffin,$sit,"A");
//echo tabla_detalle_venta(5);
//$ClsVntCred = new ClsVntCredito();
//echo $ClsVntCred->insert_cobro_creditos(1,4,1,10,1,1,2,'VISA','1234123','R');;

?>
