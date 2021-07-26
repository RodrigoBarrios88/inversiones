<?php 
include_once('../../html_fns.php');

function rep_tabla_pagos($comp,$comtotal,$credtotal,$monid,$montext,$tcambio,$monsimbolo){
	$ClsPag = new ClsPago();
	$result = $ClsPag->get_pago_compra("",$comp);
		$salida.= '<div class = "busqueda" style="text-decoration:underline;" align = "center">Pagos</div>';
	
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
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
			$comp = $row["pag_compra"];
			$cod = Agrega_Ceros($cod);
			$comp = Agrega_Ceros($comp);
			$codigo = $cod."-".$comp;
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
			$montototal = round($montototal, 2);
			$salida.= '<td align = "center">'.$monsimbolo.'. '.$montototal.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
	}
			//----
			$saldo = $comtotal - $montototal;
			$saldo = round($saldo, 2);
			$nota = ($saldo == 0)?"<b style = 'color:green'>VENTA CANCELADA EN SU TOTALIDAD</b>":"<br>";
			$salida.= '<tr>';
			$salida.= '<th colspan = "10" align = "center">'.$nota.'</th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th colspan = "9" align = "right"> <b>TOTAL DE LA FACTURA</b></th>';
			$salida.= '<th align = "center"><b>'.$monsimbolo.'. '.$comtotal.'</b>';
			$salida.= '</tr>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th colspan = "9" align = "right"> <b>TOTAL DE COMPRA AL CREDITO</b></th>';
			$salida.= '<th align = "center"><b>'.$monsimbolo.'. '.$credtotal.'</b>';
			$salida.= '<input type = "hidden" name = "comp" id = "comp" value = "'.$comp.'"/>';
			$salida.= '<input type = "hidden" name = "factotal" id = "factotal" value = "'.$comtotal.'"/>';
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
			$salida.= '</div>';
		
	return $salida;
}


function rep_tabla_creditos_x_pagar($comp,$tipo,$suc,$doc,$fini,$ffin){
	$ClsCred = new ClsCredito();
	$result = $ClsCred->get_credito_compra("",$comp,$doc,$tipo,$suc,$fini,$ffin,1);
	$salida.= '<div class = "busqueda" style="text-decoration:underline;" align = "center">Créditos</div>';
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" align = "center" >No.</th>';
			$salida.= '<th width = "80px" align = "center" ># CREDITO</th>';
			$salida.= '<th width = "80px" align = "center" ># COMPRA</th>';
			$salida.= '<th width = "120px" align = "center" >FORMA PAG.</th>';
			$salida.= '<th width = "80px" align = "center" >AUTORIZÓ</th>';
			$salida.= '<th width = "80px" align = "center" >No. DOC.</th>';
			$salida.= '<th width = "120px" align = "center" >FECHA/HORA</th>';
			$salida.= '<th width = "160px" align = "center" >OBSERVACIONES</th>';
			$salida.= '<th width = "70px" align = "center" >MONTO</th>';
			$salida.= '<th width = "50px" align = "center" >T/C</th>';
			$salida.= '</tr>';
		$i = 1;	
		$montototal = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td align = "center" >'.$i.'.</td>';
			//Codigo
			$cod = trim($row["cred_codigo"]);
			$comp = trim($row["com_codigo"]);
			$codigo = Agrega_Ceros($row["cred_codigo"])."-".Agrega_Ceros($row["com_codigo"]);
			//--
			$salida.= '<td align = "center">CRED-'.$codigo.'</td>';
			$salida.= '<td align = "center">'.Agrega_Ceros($comp).'</td>';
			//FORMA de Pago
			$tpag = $row["tpago_desc_md"];
			$salida.= '<td align = "center">'.$tpag.'</td>';
			//Operador o Banco
			$opera = $row["cred_operador"];
			$salida.= '<td align = "center">'.$opera.'</td>';
			//Documento o Boucher
			$doc = $row["com_doc"];
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
		$salida.= '<div class = "celda" align = "center">No se Registran Creditos en esta Compra ó Gasto</div>';
	}
	
	return $salida;
}


/////////////////////////// Historiales ///////////////////


function rep_tabla_historial_compra($cod,$tipo,$suc,$doc,$fini,$ffin,$sit){
	$ClsComp = new ClsCompra();
	$result = $ClsComp->get_compra($cod,$tipo,'',$suc,$doc,'',$fini,$ffin,$sit);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th width = "20px">No.</th>';
			$salida.= '<th width = "60px"># TRANS.</th>';
			$salida.= '<th width = "150px">PROVEEDOR</th>';
			$salida.= '<th width = "70px">DOC. REF.</th>';
			$salida.= '<th width = "100px">EMPRESA</th>';
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
			$sit = $row["com_situacion"];
			$comp = $row["com_codigo"];
			//--
			$salida.= '<td align = "center" >'.$i.'.</td>';
			//Codigo
			$comp = Agrega_Ceros($comp);
			$salida.= '<td align = "center">'.$comp.'</td>';
			//cliente
			$pro = $row["prov_nombre"];
			$salida.= '<td>'.$pro.'</td>';
			//referencia
			$ref = $row["com_doc"];
			$salida.= '<td align = "center">'.$ref.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td align = "center">'.$suc.'</td>';
			//Fecha / Hora
			$fec = $row["com_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//descuento
			$desc = $row["com_descuento"];
			$salida.= '<td align = "center">'.$desc.' %</td>';
			//total
			$tot = $row["com_total"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td align = "center"><b>'.$mons.'. '.$tot.'</b></td>';
			//Moneda
			$mon = $row["mon_desc"];
			$salida.= '<td align = "center">'.$mon.'</td>';
			//tcamb
			$tcamb = $row["com_tcambio"];
			$salida.= '<td align = "center">'.$tcamb.' x 1</td>';
			//--
			$salida.= '</tr>';
			//--
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


function rep_tabla_anulacion_compra($cod,$tipo,$prov,$suc,$doc,$fini,$ffin){
	$ClsComp = new ClsCompra();
	$result = $ClsComp->get_compra($cod,$tipo,$prov,$suc,$doc,'',$fini,$ffin);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th width = "20px">No.</th>';
			$salida.= '<th width = "60px"># TRANS.</th>';
			$salida.= '<th width = "120px">PROVEEDOR</th>';
			$salida.= '<th width = "70px">DOC. REF.</th>';
			$salida.= '<th width = "100px">EMPRESA</th>';
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
			$sit = $row["com_situacion"];
			$comp = $row["com_codigo"];
			//--
			$salida.= '<td align = "center" >'.$i.'.</td>';
			//Codigo
			$comp = Agrega_Ceros($comp);
			$salida.= '<td align = "center">'.$comp.'</td>';
			//cliente
			$pro = $row["prov_nombre"];
			$salida.= '<td>'.$pro.'</td>';
			//referencia
			$ref = $row["com_doc"];
			$salida.= '<td align = "center">'.$ref.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td align = "center">'.$suc.'</td>';
			//Fecha / Hora
			$fec = $row["com_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//descuento
			$desc = $row["com_descuento"];
			$salida.= '<td align = "center">'.$desc.' %</td>';
			//total
			$tot = $row["com_total"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td align = "center"><b>'.$mons.'. '.$tot.'</b></td>';
			//Moneda
			$mon = $row["mon_desc"];
			$salida.= '<td align = "center">'.$mon.'</td>';
			//tcamb
			$tcamb = $row["com_tcambio"];
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


//echo tabla_historial_compra($cod,$tipo,$prov,$suc,$doc,$fini,$ffin,$sit,"H");
//echo tabla_detalle_compra(8);
//echo Caja_Empresa_html(1,$caj,$onclick);
//echo $contenido;

?>
