<?php 
include_once('../html_fns.php'); 

function tabla_inicio_proyecto($filas){
			$salida = '<br>';
			$salida.= '<table class = "tablegrid">';
			$salida.= '<tr>';
			$salida.= '<th class = "thgrid" align = "center" width = "30px" height = "30px">No.</td>';
			$salida.= '<th class = "thgrid" align = "center" width = "100px">Cant.</td>';
			$salida.= '<th class = "thgrid" align = "center" width = "350px">Descipción</td>';
			$salida.= '<th class = "thgrid" align = "center" width = "75px">P. Unitario</td>';
			$salida.= '<th class = "thgrid" align = "center" width = "75px">Descuento</td>';
			$salida.= '<th class = "thgrid" align = "center" width = "75px">P. Total</td>';
			$salida.= '<th class = "thgrid" align = "center" width = "30px" colspan = "2"></td>';
			$salida.= '</tr>';
	$i = 1;	
	if($filas>0){
		for($i = 1; $i <= $filas; $i ++){
			//No.
			$salida.= '<td class = "tdgrid" align = "center">'.$i.'.</td>';
			//Cantidad
			$salida.= '<td class = "tdgrid" align = "center"><span id = "spancant'.$i.'"></span>';
			$salida.= '<input type = "hidden" name = "cant'.$i.'" id = "cant'.$i.'" />';
			$salida.= '<input type = "hidden" name = "tip'.$i.'" id = "tip'.$i.'" />';
			$salida.= '</td>';
			//Descripcion o Articulo
			$salida.= '<td class = "tdgrid" align = "center">';
			$salida.= '<input type = "hidden" name = "barc'.$i.'" id = "barc'.$i.'" />';
			$salida.= '<input type = "hidden" name = "artc'.$i.'" id = "artc'.$i.'" />';
			$salida.= '<input type = "hidden" name = "desc'.$i.'" id = "desc'.$i.'" />';
			$salida.= '</td>';
			//Precio U.
			$salida.= '<td class = "tdgrid" align = "center">';
			$salida.= '<input type = "hidden" name = "prev'.$i.'" id = "prev'.$i.'" />';
			$salida.= '<input type = "hidden" name = "monc'.$i.'" id = "monc'.$i.'" />';
			$salida.= '<input type = "hidden" name = "mons'.$i.'" id = "mons'.$i.'" />';
			$salida.= '</td>';
			//Descuento
			$salida.= '<td class = "tdgrid" align = "center">';
			$salida.= '<input type = "hidden" name = "dsc'.$i.'" id = "dsc'.$i.'" />';
			$salida.= '</td>';
			//sub Total
			$salida.= '<td class = "tdgrid" align = "center">';
			$salida.= '<input type = "hidden" name = "stot'.$i.'" id = "stot'.$i.'" />';
			$salida.= '</td>';
			//---
			$salida.= '<td class = "tdgrid" align = "center">';
			$salida.= '<a href = "javascript:void(0);" title = "Quitar Fila" style = "border:none;" ><img src = "../../CONFIG/images/icons/delete.png" style = "vertical-align:middle;border:none;"></a>';
			$salida.= '</td>';
			$salida.= '</tr>';
		}
	}		
			//----
			$Vmond = $_SESSION["moneda"];
			$salida.= '<tr>';
			$salida.= '<td class = "tdgrid" colspan = "3" rowspan = "4">';
			$salida.= '<span id = "spannota">';
			$salida.= '<b>NOTA:</b> MONEDA PARA COTIZACI&Oacute;N: <b>'.$Vmond.'</b>. TIPO DE CAMBIO '.$Vmonc.' x 1';
			$salida.= '</span></td>';
			$salida.= '<td class = "thgrid">Desc/Unitarios</td>';
			$salida.= '<td class = "tdgrid" align = "center"><span id = "spanpromdesc"><b>0</b></span>';
			$salida.= '<td class = "tdgrid" align = "center">-</td>';
			$salida.= '<td class = "tdgrid" align = "center">';
			$salida.= '<input type = "hidden" name = "promdesc" id = "promdesc" value = "0" /></td>';
			$salida.= '</td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "thgrid">Subtotal</td>';
			$salida.= '<td class = "tdgrid" align = "center">-</td>';
			$salida.= '<td class = "tdgrid" align = "center"><span id = "spanstotal">0</span>';
			$salida.= '<input type = "hidden" name = "stotal" id = "stotal" value = "0" />';
			$salida.= '</td>';
			$salida.= '<td class = "tdgrid" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "thgrid">Desc/General</td>';
			$salida.= '<td class = "tdgrid" align = "center">-</td>';
			$salida.= '<td class = "tdgrid" align = "center"><span id = "spandscgeneral">0</span>';
			$salida.= '<input type = "hidden" name = "ttotal" id = "tdescuento" />';
			$salida.= '<input type = "hidden" name = "ttotal" id = "ttdescuento" />';
			$salida.= '</td>';
			$salida.= '<td class = "tdgrid" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "thgrid">TOTAL</td>';
			$salida.= '<td class = "tdgrid" align = "center">-</td>';
			$salida.= '<td class = "tdgrid" align = "center"><span id = "spanttotal">0</span>';
			$salida.= '<input type = "hidden" name = "ttotal" id = "ttotal" value = "0" />';
			$salida.= '<input type = "hidden" name = "Rtotal" id = "Rtotal" value = "0" />';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "0"/></td>';
			$salida.= '</td>';
			$salida.= '<td class = "tdgrid" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</form>';
			$salida.= '<br>';
	
	return $salida;
}


function tabla_filas_proyecto($filas,$moneda,$cant,$tip,$barc,$artc,$desc,$prev,$mon,$mons,$monc,$tfdsc,$fdsc,$tdsc,$dsc,$IVA){

	//Tratamiento de la cadena de moneda
		$monchunk = explode("/",$moneda); 
		$Vmond = trim($monchunk[0]); // Nombre de Moneda
		$Vmons = trim($monchunk[1]); // Simbolo de Moneda
		$Vmonc = trim($monchunk[2]); // Tipo de Cambio
		$Vmonc = str_replace("(","",$Vmonc); //le quita el primer parentesis que rodea el tipo de cambio
		$Vmonc = str_replace(" x 1)","",$Vmonc); //le quita el 2do. parentesis y el x 1
			$salida = '<br>';
			$salida.= '<table class = "tablegrid">';
			$salida.= '<tr>';
			$salida.= '<th class = "thgrid" align = "center" width = "30px" height = "30px">No.</td>';
			$salida.= '<th class = "thgrid" align = "center" width = "75px">Cant.</td>';
			$salida.= '<th class = "thgrid" align = "center" width = "300px">Descipción</td>';
			$salida.= '<th class = "thgrid" align = "center" width = "75px">P. Unitario</td>';
			$salida.= '<th class = "thgrid" align = "center" width = "75px">Descuento</td>';
			$salida.= '<th class = "thgrid" align = "center" width = "75px">P. Total</td>';
			$salida.= '<th class = "thgrid" align = "center" width = "30px"></td>';
			$salida.= '</tr>';
	$STotal = 0;
	$Total = 0;
	$Rtotal = 0;
	$DescU = 0;
	if($filas>0){
		for($i = 1; $i <= $filas; $i ++){
			//No.
			$salida.= '<td class = "tdgrid" align = "center">'.$i.'.</td>';
			//Cantidad
			$salida.= '<td class = "tdgrid" align = "center"><span id = "spancant'.$i.'">'.$cant[$i].'</span>';
			$salida.= '<input type = "hidden" name = "cant'.$i.'" id = "cant'.$i.'" value = "'.$cant[$i].'" />';
			$salida.= '<input type = "hidden" name = "tip'.$i.'" id = "tip'.$i.'" value = "'.$tip[$i].'" />';
			$salida.= '</td>';
			//Descripcion o Articulo
			$desc[$i] = utf8_decode($desc[$i]);
			$desc[$i] = trim($desc[$i]);
			$salida.= '<td class = "tdgrid" align = "left">'.$desc[$i];
			$salida.= '<input type = "hidden" name = "barc'.$i.'" id = "barc'.$i.'" value = "'.$barc[$i].'" />';
			$salida.= '<input type = "hidden" name = "artc'.$i.'" id = "artc'.$i.'" value = "'.$artc[$i].'" />';
			$salida.= '<input type = "hidden" name = "desc'.$i.'" id = "desc'.$i.'" value = "'.$desc[$i].'" />';
			$salida.= '</td>';
			//Precio U.
			$salida.= '<td class = "tdgrid" align = "center">'.trim($mons[$i]).' '.$prev[$i];
			$salida.= '<input type = "hidden" name = "prev'.$i.'" id = "prev'.$i.'" value = "'.$prev[$i].'" />';
			$salida.= '<input type = "hidden" name = "mon'.$i.'" id = "mon'.$i.'" value = "'.trim($mon[$i]).'" />';
			$salida.= '<input type = "hidden" name = "mons'.$i.'" id = "mons'.$i.'" value = "'.trim($mons[$i]).'" />';
			$salida.= '<input type = "hidden" name = "monc'.$i.'" id = "monc'.$i.'" value = "'.trim($monc[$i]).'" />';
			$salida.= '</td>';
			//Descuento
			$dsign = ($tdsc[$i] == "P")?"%":trim($mons[$i]);
			$salida.= '<td class = "tdgrid" align = "center"><span id = "spandsc'.$i.'">'.$dsign.' '.$dsc[$i].'</span>';
			$salida.= '<input type = "hidden" name = "tdsc'.$i.'" id = "tdsc'.$i.'" value = "'.$tdsc[$i].'" />';
			$salida.= '<input type = "hidden" name = "dsc'.$i.'" id = "dsc'.$i.'" value = "'.$dsc[$i].'" />';
			$salida.= '</td>';
			//sub Total
			$rtot = ($prev[$i] * $cant[$i]);
			if($tdsc[$i] == "P"){
				$descuento = ($rtot *($dsc[$i])/100);
			}else if($tdsc[$i] == "M"){
			        $descuento = $dsc[$i];
			}
			$Dcambiar = Cambio_Moneda($monc[$i],$Vmonc,$descuento);
			$DescU += $Dcambiar;
			$stot = $rtot - $descuento;
			$Dcambiar = Cambio_Moneda($monc[$i],$Vmonc,$stot);
			$STotal+= $Dcambiar;
			$Rcambiar = Cambio_Moneda($monc[$i],$Vmonc,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = round($stot, 2);
			$salida.= '<td class = "tdgrid" align = "center"><span id = "spanstot'.$i.'">'.trim($mons[$i]).' '.$stot.'</span>';
			$salida.= '<input type = "hidden" name = "stot'.$i.'" id = "stot'.$i.'" value = "'.$stot.'" />';
			$salida.= '<input type = "hidden" name = "rtot'.$i.'" id = "rtot'.$i.'" value = "'.$rtot.'" />';
			$salida.= '</td>';
			//---
			$salida.= '<td class = "tdgrid" align = "center">';
			$salida.= '<a href = "javascript:void(0);" onclick = "QuitarFilaVenta('.$i.')" title = "Quitar Fila" style = "border:none;" ><img src = "../../CONFIG/images/icons/delete.png" style = "vertical-align:middle;border:none;"></a>';
			$salida.= '</td>';
			$salida.= '</tr>';
		}
	}		
			//----
			if($tfdsc == "P"){
				$descuento = ($STotal *($fdsc)/100);
			}else if($tfdsc == "M"){
			        $descuento = $fdsc;
			}
			$Total = $STotal - $descuento;
			$STotal = round($STotal, 2); //total sin iva
			$Total = round($Total, 2); //total sin iva
			$DescU = round($DescU, 2); //promedio de descuento
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "tdgrid" colspan = "3" rowspan = "4">';
			$salida.= '<span id = "spannota">';
			$salida.= '<b>NOTA:</b> MONEDA PARA COTIZACI&Oacute;N: <b>'.$Vmond.'</b>. TIPO DE CAMBIO '.$Vmonc.' x 1';
			$salida.= '</span></td>';
			$salida.= '<td class = "thgrid">Desc/Unitarios</td>';
			$salida.= '<td class = "tdgrid" align = "center"><span id = "spanpromdesc"><b>'.$Vmons.' '.$DescU.'</b></span>';
			$salida.= '<td class = "tdgrid" align = "center">-</td>';
			$salida.= '<td class = "tdgrid" align = "center">';
			$salida.= '<input type = "hidden" name = "promdesc" id = "promdesc" value = "'.$DescU.'" /></td>';
			$salida.= '</td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "thgrid">Subtotal</td>';
			$salida.= '<td class = "tdgrid" align = "center">-</td>';
			$salida.= '<td class = "tdgrid" align = "center"><span id = "spanstotal"><b>'.$Vmons.' '.$STotal.'</b></span>';
			$salida.= '<input type = "hidden" name = "stotal" id = "stotal" value = "'.$STotal.'" />';
			$salida.= '</td>';
			$salida.= '<td class = "tdgrid" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "thgrid">Desc/General</td>';
			$salida.= '<td class = "tdgrid" align = "center">-</td>';
			$salida.= '<td class = "tdgrid" align = "center"><span id = "spandscgeneral"><b>'.$Vmons.' '.$descuento.'</b></span>';
			$salida.= '<input type = "hidden" name = "ttotal" id = "tdescuento" value = "'.$descuento.'" />';
			$salida.= '<input type = "hidden" name = "ttotal" id = "ttdescuento" value = "'.$tfdsc.'" />';
			$salida.= '</td>';
			$salida.= '<td class = "tdgrid" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "thgrid">TOTAL</td>';
			$salida.= '<td class = "tdgrid" align = "center">-</td>';
			$salida.= '<td class = "tdgrid" align = "center"><span id = "spanttotal"><b>'.$Vmons.' '.$Total.'</b></span>';
			$salida.= '<input type = "hidden" name = "ttotal" id = "ttotal" value = "'.$Total.'" />';
			$salida.= '<input type = "hidden" name = "Rtotal" id = "Rtotal" value = "'.$Rtotal.'" />';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$filas.'"/></td>';
			$salida.= '</td>';
			$salida.= '<td class = "tdgrid" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</form>';
			$salida.= '<br>';
	
	return $salida;
}



function tabla_filas_proyecto_pago($filas,$tpago,$monto,$moneda,$tcambio,$opera,$boucher,$observ,$tcambiodia){
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



function tabla_inicio_proyecto_pago($filas){
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


function tabla_pagos($pro,$factotal,$monid,$montext,$tcambio,$monsimbolo){
	$ClsPag = new ClsPago();
	$ClsMon = new ClsMoneda();
	$result = $ClsPag->get_pago_proyecto("",$pro);
		$salida.= '<div class = "busqueda" style="text-decoration:underline;" align = "center">Pagos</div>';
	
			$salida.= '<table class = "tabledash" border = 1>';
			$salida.= '<tr>';
			$salida.= '<td class = "encabeza" width = "30px" align = "center" >No.</td>';
			$salida.= '<td class = "encabeza" width = "80px" align = "center" ># TRANS.</td>';
			$salida.= '<td class = "encabeza" width = "120px" align = "center" >FORMA PAG.</td>';
			$salida.= '<td class = "encabeza" width = "80px" align = "center" >OP./BAN</td>';
			$salida.= '<td class = "encabeza" width = "80px" align = "center" >DOC.</td>';
			$salida.= '<td class = "encabeza" width = "120px" align = "center" >FECHA/HORA</td>';
			$salida.= '<td class = "encabeza" width = "180px" align = "center" >OBSERVACIONES</td>';
			$salida.= '<td class = "encabeza" width = "50px" align = "center" >MONTO</td>';
			$salida.= '<td class = "encabeza" width = "50px" align = "center" >T/C</td>';
			$salida.= '<td class = "encabeza" width = "50px" align = "center" >ACUM.</td>';
			$salida.= '</tr>';
		$i = 1;	
		$montototal = 0;
	if(is_array($result)){
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "celdadash" align = "center" >'.$i.'.</td>';
			//Codigo
			$cod = $row["pag_codigo"];
			$pro = $row["pag_proyecto"];
			$cod = Agrega_Ceros($cod);
			$pro = Agrega_Ceros($pro);
			$codigo = $cod."-".$pro;
			$salida.= '<td class = "celdadash" align = "center">'.$codigo.'</td>';
			//FORMA de Pago
			$tpag = $row["tpago_desc_md"];
			$salida.= '<td class = "celdadash" align = "center">'.$tpag.'</td>';
			//Operador o Banco
			$opera = $row["pag_operador"];
			$salida.= '<td class = "celdadash" align = "center">'.$opera.'</td>';
			//Documento o Boucher
			$doc = $row["pag_doc"];
			$salida.= '<td class = "celdadash" align = "center">'.$doc.'</td>';
			//fecha hora
			$fec = $row["pag_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "celdadash" align = "center">'.$fec.'</td>';
			//observaciones
			$obs = $row["pag_obs"];
			$salida.= '<td class = "celdadash"  class = "text-justify">'.$obs.'</td>';
			//monto
			$mont = $row["pag_monto"];
			$mons = $row["mon_simbolo"];
			$moncamb = $row["mon_cambio"];
			$monto = $mons.". ".$mont;
			$salida.= '<td class = "celdadash" align = "center">'.$monto.'</td>';
			//cambio
			$camb = $row["pag_tcambio"];
			$salida.= '<td class = "celdadash" align = "center">'.$camb.' x 1</td>';
			//acumulado
			$Dcambiar = Cambio_Moneda($moncamb,$tcambio,$mont);
			$montototal += $Dcambiar;
			$salida.= '<td class = "celdadash" align = "center">'.$monsimbolo.'. '.$montototal.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
	}
			//----
			$saldo = $factotal - $montototal;
			$nota = ($saldo == 0)?"<b style = 'color:green'>VENTA CANCELADA EN SU TOTALIDAD</b>":"<br>";
			$salida.= '<tr>';
			$salida.= '<td class = "celdadash" colspan = "10" align = "center">'.$nota.'</td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "celdadash" colspan = "9" align = "right"> <b>TOTAL DE LA FACTURA</b></td>';
			$salida.= '<td class = "celdadash" align = "center"><b>'.$monsimbolo.'. '.$factotal.'</b>';
			$salida.= '<input type = "hidden" name = "pro" id = "pro" value = "'.$pro.'"/>';
			$salida.= '<input type = "hidden" name = "factotal" id = "factotal" value = "'.$factotal.'"/>';
			$salida.= '<input type = "hidden" name = "tcambio" id = "tcambio" value = "'.$tcambio.'"/>';
			$salida.= '<input type = "hidden" name = "montext" id = "montext" value = "'.$montext.'"/></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "celdadash" colspan = "9" align = "right"> <b>TOTAL ACUMULADO</b></td>';
			$salida.= '<td class = "celdadash" align = "center"><b>'.$monsimbolo.'. '.$montototal.'</b>';
			$salida.= '<input type = "hidden" name = "montototal" id = "montototal" value = "'.$montototal.'"/></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "celdadash" colspan = "9" align = "right"> <b>SALDO</b></td>';
			$salida.= '<td class = "celdadash" align = "center"><b style = "color:green">'.$monsimbolo.'. '.$saldo.'</b>';
			$salida.= '<input type = "hidden" name = "moneda" id = "moneda" value = "'.$monid.'"/>';
			$salida.= '<input type = "hidden" name = "saldo" id = "saldo" value = "'.$saldo.'"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
	
	return $salida;
}


function tabla_cuentas_x_cobrar($pro,$suc,$tipo,$fini,$ffin){
	$ClsVntCred = new ClsVntCredito();
	$result = $ClsVntCred->get_cobro_creditos_proyecto('',$pro,$suc,'',$tipo,'','','','',$fini,$ffin,'','',1);
	if(is_array($result)){
			$salida.= '<div class = "busqueda" style="text-decoration:underline;" align = "center">Cuentas de Tarjetas y Cheques</div>';
			$salida.= '<br>';
			$salida.= '<table class = "tabledash" border = 1>';
			$salida.= '<tr>';
			$salida.= '<th class = "encabeza" width = "50px" height = "30px"><img src = "../../CONFIG/images/icons/gear.png" class="icon" ></th>';
			$salida.= '<th class = "encabeza" width = "30px">No.</th>';
			$salida.= '<th class = "encabeza" width = "100px"># TRANSACCIÓN</th>';
			$salida.= '<th class = "encabeza" width = "70px"># PRESUPUESTO</th>';
			$salida.= '<th class = "encabeza" width = "110px">EMPRESA</th>';
			$salida.= '<th class = "encabeza" width = "110px">OPERADOR/BANCO</th>';
			$salida.= '<th class = "encabeza" width = "100px">BOUCHER/CHEQUE</th>';
			$salida.= '<th class = "encabeza" width = "120px">FECHA/HORA</th>';
			$salida.= '<th class = "encabeza" width = "60px">MONTO</th>';
			$salida.= '<td class = "encabeza" width = "50px" align = "center" >T/C</td>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["pro_situacion"];
			$ccred = $row["ccred_codigo"];
			$ven = $row["pro_codigo"];
			$Vtcamb = $row["pro_tcambio"];
			$Vmons = $row["mon_simbolo"];
			$salida.= '<td class = "celdadash" align = "center" >';
			$salida.= '<input type = "checkbox" id = "chk'.$i.'">';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "celdadash" align = "center" >'.$i.'.</td>';
			//Codigo
			$ccred = Agrega_Ceros($ccred);
			$ven = Agrega_Ceros($ven);
			$salida.= '<td class = "celdadash" align = "center">'.$ccred.'-'.$ven;
			$salida.= '<input type = "hidden" id = "ccue'.$i.'" value = "'.$ccred.'">';
			$salida.= '</td>';
			//Venta
			$salida.= '<td class = "celdadash" align = "center">'.$ven;
			$salida.= '<input type = "hidden" id = "pro'.$i.'" value = "'.$ven.'">';
			$salida.= '</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td class = "celdadash" align = "center">'.$suc.'</td>';
			//Operador
			$opera = $row["ccred_operador"];
			$tipo = $row["ccred_tipo"];
			$salida.= '<td class = "celdadash">'.$opera;
			$salida.= '<input type = "hidden" id = "tipo'.$i.'" value = "'.$tipo.'">';
			$salida.= '</td>';
			//Doc
			$doc = $row["ccred_boucher"];
			$salida.= '<td class = "celdadash">'.$doc.'</td>';
			//Fecha / Hora
			$fec = $row["ccred_fechor_proyecto"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "celdadash" align = "center">'.$fec.'</td>';
			//monto
			$tot = $row["ccred_monto"];
			$mons = $row["mon_simbolo"];
			$monc = $row["mon_cambio"];
			$Dcambiar = Cambio_Moneda($monc,1,$tot);//realiza el cambio a Quetzales
			$salida.= '<td class = "celdadash" align = "center"><b>'.$mons.'. '.$tot.'</b>';
			$salida.= '<input type = "hidden" id = "monto'.$i.'" value = "'.$Dcambiar.'">';
			$salida.= '</td>';
			//cambio
			$camb = $row["ccred_tcambio"];
			$salida.= '<td class = "celdadash" align = "center">'.$camb.' x 1</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<td class = "footdash" colspan = "11"> '.$i.' Registro(s).<input type = "hidden" id = "filas" value = "'.$i.'"></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "celdadash" colspan = "11"> ';
			$salida.= '<div class = "boxboton" style = "width:100px;">';
			$salida.= '<br>';
			$salida.= '<a class="button" href="javascript:void(0)" onclick = "Confirm_Ejecutar_Cheque_Tarjeta()" ><img src = "../../CONFIG/images/icons/Dollar.png" class="icon" > Ejecutar</a>';
			$salida.= '</div>';
			$salida.= '</td>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '<br>';
	}else{
		$salida.= '<div class = "celda" align = "center">No se Registran Cuentas por Cobrar</div>';
		$salida.= '<br>';
	}
		
	return $salida;
}


function tabla_pagos2($pro,$tcambio,$monsimbolo){
	$ClsPag = new ClsPago();
	$result = $ClsPag->get_pago_proyecto("",$pro);
	
	if(is_array($result)){
			$salida.= '<table class = "tabledash" border = 1>';
			$salida.= '<tr>';
			$salida.= '<td class = "celdadash" width = "70px" align = "center" ><b>#TRANS.</b></td>';
			$salida.= '<td class = "celdadash" width = "100px" align = "center" ><b>FORMA PAG.</b></td>';
			$salida.= '<td class = "celdadash" width = "110px" align = "center" ><b>OP./BAN</b></td>';
			$salida.= '<td class = "celdadash" width = "80px" align = "center" ><b>DOC.</b></td>';
			$salida.= '<td class = "celdadash" width = "120px" align = "center" ><b>FECHA/HORA</b></td>';
			$salida.= '<td class = "celdadash" width = "50px" align = "center" ><b>MONTO</b></td>';
			$salida.= '<td class = "celdadash" width = "50px" align = "center" ><b>T/C</b></td>';
			$salida.= '<td class = "celdadash" width = "50px" align = "center" ><b>M*TC</b></td>';
			$salida.= '</tr>';
		$i = 1;	
		$montototal = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//Codigo
			$cod = $row["pag_codigo"];
			$pro = $row["pag_proyecto"];
			$cod = Agrega_Ceros($cod);
			$pro = Agrega_Ceros($pro);
			$codigo = $cod."-".$pro;
			$salida.= '<td class = "celdadash" align = "center">'.$codigo.'</td>';
			//FORMA de Pago
			$tpag = $row["tpago_desc_md"];
			$salida.= '<td class = "celdadash" align = "center">'.$tpag.'</td>';
			//Operador o Banco
			$opera = $row["pag_operador"];
			$salida.= '<td class = "celdadash" align = "center">'.$opera.'</td>';
			//Documento o Boucher
			$doc = $row["pag_doc"];
			$salida.= '<td class = "celdadash" align = "center">'.$doc.'</td>';
			//fecha hora
			$fec = $row["pag_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "celdadash" align = "center">'.$fec.'</td>';
			//monto
			$mont = $row["pag_monto"];
			$mons = $row["mon_simbolo"];
			$moncamb = $row["mon_cambio"];
			$monto = $mons.". ".$mont;
			$salida.= '<td class = "celdadash" align = "center">'.$monto.'</td>';
			//cambio
			$camb = $row["pag_tcambio"];
			$salida.= '<td class = "celdadash" align = "center">'.$camb.' x 1</td>';
			//total
			$Dcambiar = Cambio_Moneda($moncamb,$tcambio,$mont);
			$total = $monsimbolo.". ".$Dcambiar;
			$salida.= '<td class = "celdadash" align = "center">'.$total.'</td>';
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


function tabla_historial_proyecto($pro,$suc,$pv,$fini,$ffin,$sit,$form){
	$ClsPro = new ClsProyecto();
	$fac = ($cfac == 2)?0:$cfac;
	$result = $ClsPro->get_proyecto($pro,'',$pv,$suc,'','',$fini,$ffin,$sit);
	
	if(is_array($result)){
			$salida = '<br>';
			$salida.= '<table class = "tabledash" border = 1>';
			$salida.= '<tr>';
			if($form == "A"){
			$salida.= '<th class = "encabeza" width = "50px" height = "30px"><img src = "../../CONFIG/images/icons/gear.png" class="icon" ></th>';
			}else if($form == "H"){
			$salida.= '<th class = "encabeza" width = "50px" height = "30px" colspan = "2"><img src = "../../CONFIG/images/icons/gear.png" class="icon" ></th>';
			}
			$salida.= '<th class = "encabeza" width = "20px">No.</th>';
			$salida.= '<th class = "encabeza" width = "60px"># PRESUPUESTO</th>';
			$salida.= '<th class = "encabeza" width = "120px">CLIENTE</th>';
			$salida.= '<th class = "encabeza" width = "100px">EMPRESA</th>';
			$salida.= '<th class = "encabeza" width = "70px">P. VENTA</th>';
			$salida.= '<th class = "encabeza" width = "120px">FECHA/HORA</th>';
			$salida.= '<th class = "encabeza" width = "50px">%DESC.</th>';
			$salida.= '<th class = "encabeza" width = "50px">MONTO</th>';
			$salida.= '<th class = "encabeza" width = "70px">MONEDA</th>';
			$salida.= '<th class = "encabeza" width = "50px">T/C</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["pro_situacion"];
			$pro = $row["pro_codigo"];
			if($form == "H"){
				$salida.= '<td class = "celdadash" align = "center" rowspan = "2" >';
				$salida.= '<a class="button" href="javascript:void(0)" onclick = "xajax_Selecciona_Proyecto('.$pro.','.$i.')" title = "Ver Detalle de Historial" ><img src = "../../CONFIG/images/icons/mas.png" class="icon" ></a>';
				$salida.= '</td>';
				$salida.= '<td class = "celdadash" align = "center" rowspan = "2" >';
				$salida.= '<a class="button" href="javascript:void(0)" onclick = "xajax_Cerrar_Detalle('.$i.')" title = "Cerrar Detalle" ><img src = "../../CONFIG/images/icons/menos.png" class="icon" ></a>';
				$salida.= '</td>';
			}
			//--
			$salida.= '<td class = "celdadash" align = "center" rowspan = "2" >'.$i.'.</td>';
			//Codigo
			$pro = Agrega_Ceros($pro);
			$salida.= '<td class = "celdadash" align = "center">'.$pro.'</td>';
			//cliente
			$cli = $row["cli_nombre"];
			$salida.= '<td class = "celdadash">'.$cli.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td class = "celdadash" align = "center">'.$suc.'</td>';
			//punto de venta
			$pv = $row["pv_nombre"];
			$salida.= '<td class = "celdadash" align = "center">'.$pv.'</td>';
			//Fecha / Hora
			$fec = $row["pro_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "celdadash" align = "center">'.$fec.'</td>';
			//descuento
			$desc = $row["pro_descuento"];
			$salida.= '<td class = "celdadash" align = "center">'.$desc.' %</td>';
			//total
			$tot = $row["pro_total"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "celdadash" align = "center"><b>'.$mons.'. '.$tot.'</b></td>';
			//Moneda
			$mon = $row["mon_desc"];
			$salida.= '<td class = "celdadash" align = "center">'.$mon.'</td>';
			//tcamb
			$tcamb = $row["pro_tcambio"];
			$salida.= '<td class = "celdadash" align = "center">'.$tcamb.' x 1</td>';
			//--
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<td class = "celdadash" colspan = "13"><div id = "divVent'.$i.'" align = "center" ></div></td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<td class = "footdash" colspan = "13"> '.$i.' Registro(s).</td>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '<br>';
	}
	
	return $salida;
}


function tabla_anulacion_proyecto($pro,$suc,$pv,$ser,$facc,$fini,$ffin){
	$ClsPro = new ClsProyecto();
	$result = $ClsPro->get_proyecto($pro,'',$pv,$suc,'','',$fini,$ffin);
	
	if(is_array($result)){
			$salida = '<br>';
			$salida.= '<table class = "tabledash" border = 1>';
			$salida.= '<tr>';
			$salida.= '<th class = "encabeza" width = "40px" height = "30px"><img src = "../../CONFIG/images/icons/gear.png" class="icon" ></th>';
			$salida.= '<th class = "encabeza" width = "30px">No.</th>';
			$salida.= '<th class = "encabeza" width = "60px"># PRESUPUESTO</th>';
			$salida.= '<th class = "encabeza" width = "150px">CLIENTE</th>';
			$salida.= '<th class = "encabeza" width = "100px">EMPRESA</th>';
			$salida.= '<th class = "encabeza" width = "90px">P. VENTA</th>';
			$salida.= '<th class = "encabeza" width = "120px">FECHA/HORA</th>';
			$salida.= '<th class = "encabeza" width = "50px">%DESC.</th>';
			$salida.= '<th class = "encabeza" width = "50px">MONTO</th>';
			$salida.= '<th class = "encabeza" width = "70px">MONEDA</th>';
			$salida.= '<th class = "encabeza" width = "50px">T/C</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["pro_situacion"];
			$pro = $row["pro_codigo"];
			if($sit == 1 || $sit == 2){
			$salida.= '<td class = "celdadash" align = "center" >';
			$salida.= '<a class="button" href="javascript:void(0)" onclick = "ConfirmAnular('.$pro.',\''.$fini.'\',\''.$ffin.'\')" title = "Anular Venta" ><img src = "../../CONFIG/images/icons/delete.png" class="icon" ></a>';
			$salida.= '</td>';
			}else if($sit == 0){
			$salida.= '<td class = "celdadash" align = "center" >';
			$salida.= '<a class="button" href="javascript:void(0)" title = "Anulada" ><img src = "../../CONFIG/images/icons/sitAnulado.gif" class="icon" ></a>';
			$salida.= '</td>';
			}
			//--
			$salida.= '<td class = "celdadash" align = "center" >'.$i.'.</td>';
			//Codigo
			$pro = Agrega_Ceros($pro);
			$salida.= '<td class = "celdadash" align = "center">'.$pro.'</td>';
			//cliente
			$cli = $row["cli_nombre"];
			$salida.= '<td class = "celdadash">'.$cli.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td class = "celdadash" align = "center">'.$suc.'</td>';
			//punto de venta
			$pv = $row["pv_nombre"];
			$salida.= '<td class = "celdadash" align = "center">'.$pv.'</td>';
			//Fecha / Hora
			$fec = $row["pro_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "celdadash" align = "center">'.$fec.'</td>';
			//descuento
			$desc = $row["pro_descuento"];
			$salida.= '<td class = "celdadash" align = "center">'.$desc.' %</td>';
			//total
			$tot = $row["pro_total"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "celdadash" align = "center"><b>'.$mons.'. '.$tot.'</b></td>';
			//Moneda
			$mon = $row["mon_desc"];
			$salida.= '<td class = "celdadash" align = "center">'.$mon.'</td>';
			//tcamb
			$tcamb = $row["pro_tcambio"];
			$salida.= '<td class = "celdadash" align = "center">'.$tcamb.' x 1</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<td class = "footdash" colspan = "13"> '.$i.' Registro(s).</td>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '<br>';
	}
	
	return $salida;
}


function tabla_detalle_proyecto($pro){
	$ClsPro = new ClsProyecto();
	$result = $ClsPro->get_det_proyecto('',$pro);
	
	if(is_array($result)){
			$salida = '<br>';
			$salida.= '<table class = "tablegrid">';
			$salida.= '<tr>';
			$salida.= '<td class = "tdgrid" align = "center" width = "30px"><b>No.</b></td>';
			$salida.= '<td class = "tdgrid" align = "center" width = "75px"><b>Cant.</b></td>';
			$salida.= '<td class = "tdgrid" align = "center" width = "300px"><b>Descipción</b></td>';
			$salida.= '<td class = "tdgrid" align = "center" width = "65px"><b>P. Unitario</b></td>';
			$salida.= '<td class = "tdgrid" align = "center" width = "65px"><b>% Desc.</b></td>';
			$salida.= '<td class = "tdgrid" align = "center" width = "65px"><b>C * P</b></td>';
			$salida.= '<td class = "tdgrid" align = "center" width = "65px"><b>T/C</b></td>';
			$salida.= '<td class = "tdgrid" align = "center" width = "65px"><b>P. Total</b></td>';
			$salida.= '</tr>';
		$Total = 0;
		$Rtotal = 0;
		$i = 1;	
		foreach($result as $row){
			//No.
			$salida.= '<td class = "tdgrid" align = "center">'.$i.'.</td>';
			//Cantidad
			$cant = $row["dpro_cantidad"];
			$salida.= '<td class = "tdgrid" align = "center">'.$cant.'</td>';
			//Descripcion o Articulo
			$desc = $row["dpro_detalle"];
			$salida.= '<td class = "tdgrid" align = "left">'.$desc.'</td>';
			//Precio U.
			$pre = $row["dpro_precio"];
			$mons = $row["mon_simbolo"];
			$Vmons = $row["mon_simbolo_proyecto"];
			$salida.= '<td class = "tdgrid" align = "center">'.$mons.'. '.$pre.'</td>';
			//Descuento
			$dsc = $row["dpro_descuento"];
			$salida.= '<td class = "tdgrid" align = "center">'.$dsc.' %</td>';
			//sub Total
			$monc = $row["dpro_tcambio"];
			$Vmonc = $row["pro_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$Total+= $Dcambiar;
			$Rcambiar = Cambio_Moneda($monc,$Vmonc,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = round($stot, 2);
			$salida.= '<td class = "tdgrid" align = "center">'.$mons.' '.$stot.'</td>';
			//---
			$salida.= '<td class = "tdgrid" align = "center">'.$monc.' x 1</td>';
			//---
			$salida.= '<td class = "tdgrid" align = "center">'.$Vmons.' '.$Dcambiar.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
			//----
			$salida.= '</table>';
			$salida.= '</form>';
			$salida.= '<br>';
	}
	return $salida;
}


///////////////////////////////

function rep_historial_proyecto_descargado($pro,$suc,$pv,$ser,$facc,$fini,$ffin,$fac,$sit){
	$ClsPro = new ClsProyecto();
	$ClsFac = new ClsFactura();
	if($ser != "" && $facc != ""){
		$result1 = $ClsFac->get_factura($facc,$ser);
		if(is_array($result1)){
			foreach ($result1 as $row1) {
				$pro = trim($row1["pro_codigo"]);
			}
		}
	}
	$result = $ClsPro->get_hist_proyecto_lotes('',$pro,'','',$pv,$suc,'','',$fini,$ffin,$fac,$sit);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<br>';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th align = "center" width = "30px"><b>No.</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Presupuesto</b></th>';
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
		$TIVA = 0;
		$Tdesc = 0;
		$i = 1;	
		foreach($result as $row){
			//No.
			$salida.= '<th align = "center">'.$i.'.</th>';
			//Venta
			$pro = $row["pro_codigo"];
			$pro = Agrega_Ceros($pro);
			$salida.= '<td align = "center">'.$pro.'</td>';
			//Factura
			$fac = $row["pro_ser_numero"]." ".Agrega_Ceros($row["pro_fac_numero"]);
			$salida.= '<td align = "center">'.$fac.'</td>';
			//Cliente
			$cli = $row["cli_nombre"];
			$salida.= '<td align = "left">'.$cli.'</td>';
			//Vendedor
			$ve = $row["pro_vendedor"];
			$ve = Agrega_Ceros($ve);
			$salida.= '<td align = "center">'.$ve.'</td>';
			//Cajero
			$caj = $row["pro_cajero"];
			$caj = Agrega_Ceros($caj);
			$salida.= '<td align = "center">'.$caj.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td align = "left">'.$suc.'</td>';
			//Punto de Venta
			$pv = $row["pv_nombre"];
			$salida.= '<td align = "left">'.$pv.'</td>';
			//Fecha / Hora
			$fec = $row["pro_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//Lote
			$lot = Agrega_Ceros($row["lot_codigo"])."-".Agrega_Ceros($row["lot_articulo"])."-".Agrega_Ceros($row["lot_grupo"]);
			$salida.= '<td align = "center">'.$lot.'</td>';
			//Descripcion o Articulo
			$desc = $row["dpro_detalle"];
			$salida.= '<td align = "left">'.$desc.'</td>';
			//Cantidad
			$cant = $row["det_cantidad"];
			$salida.= '<td align = "center">'.$cant.'</td>';
			//Precio Compra.
			$prem = $row["lot_precio_manufactura"];
			$mons = $row["mon_simbolo"];
			$Vmons = $row["mon_simbolo_proyecto"];
			$salida.= '<td align = "center">'.$mons.'. '.$prem.'</td>';
			//Precio Costo.
			$prec = $row["lot_precio_costo"];
			$salida.= '<td align = "center">'.$mons.'. '.$prec.'</td>';
			//Precio Venta.
			$pre = $row["dpro_precio"];
			$salida.= '<td align = "center">'.$mons.'. '.$pre.'</td>';
			//Variacion
			$var = $pre - $prec;
			$porvar = ($var*100)/$pre;
			$porvar = round($porvar, 2);
			$salida.= '<td align = "center">'.$mons.'. '.$var.' ('.$porvar.'%)</td>';
			//Descuento
			$dsc = $row["dpro_descuento"];
			$salida.= '<td align = "center">'.$dsc.' %</td>';
			//sub Total
			$monc = $row["dpro_tcambio"];
			$Vmonc = $row["pro_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$Total+= $Dcambiar;
			$Rcambiar = Cambio_Moneda($monc,$Vmonc,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = round($stot, 2);
			$iva = ($stot * 12)/100;
			$iva = round($iva, 2);
			$TIVA+=$iva;
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
			$salida.= '<th align = "right" colspan = "19"> IVA</th>';
			$salida.= '<th align = "right" colspan = "2">'.$Vmons.' '.$TIVA.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$Total = round($Total, 2);
			$salida.= '<th align = "right" colspan = "19"> TOTAL SIN IVA</td>';
			$salida.= '<th align = "right" colspan = "2">'.$Vmons.' '.$Total.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "19"> TOTAL CON IVA</td>';
			$TotalIVA = round($Total + $TIVA,2);
			$salida.= '<th align = "right" colspan = "2">'.$Vmons.' '.$TotalIVA.'</th>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '<br>';
			$salida.= '</div>';
	}
	return $salida;
}

function rep_historial_proyecto_nodescargado($pro,$suc,$pv,$ser,$facc,$fini,$ffin,$fac,$sit){
	$ClsPro = new ClsProyecto();
	$ClsFac = new ClsFactura();
	if($ser != "" && $facc != ""){
		$result1 = $ClsFac->get_factura($facc,$ser);
		if(is_array($result1)){
			foreach ($result1 as $row1) {
				$pro = trim($row1["pro_codigo"]);
			}
		}
	}
	$result = $ClsPro->get_det_proyecto_producto('',$pro,'',0,'',$pv,$suc,'','',$fini,$ffin,$fac,$sit);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<br>';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th align = "center" width = "30px"><b>No.</b></th>';
			$salida.= '<th align = "center" width = "55px"><b>Presupuesto</b></th>';
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
		$TIVA = 0;
		$Tdesc = 0;
		$i = 1;	
		foreach($result as $row){
			//No.
			$salida.= '<td align = "center">'.$i.'.</td>';
			//Venta
			$pro = $row["pro_codigo"];
			$pro = Agrega_Ceros($pro);
			$salida.= '<td align = "center">'.$pro.'</td>';
			//Factura
			$fac = $row["pro_ser_numero"]." ".Agrega_Ceros($row["pro_fac_numero"]);
			$salida.= '<td align = "center">'.$fac.'</td>';
			//Cliente
			$cli = $row["cli_nombre"];
			$salida.= '<td align = "left">'.$cli.'</td>';
			//Vendedor
			$ve = $row["pro_vendedor"];
			$ve = Agrega_Ceros($ve);
			$salida.= '<td align = "center">'.$ve.'</td>';
			//Cajero
			$caj = $row["pro_cajero"];
			$caj = Agrega_Ceros($caj);
			$salida.= '<td align = "center">'.$caj.'</td>';
			//empresa
			$suc = $row["suc_nombre"];
			$salida.= '<td align = "left">'.$suc.'</td>';
			//Punto de Venta
			$pv = $row["pv_nombre"];
			$salida.= '<td align = "left">'.$pv.'</td>';
			//Fecha / Hora
			$fec = $row["pro_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//Lote
			$salida.= '<td align = "center">---</td>';
			//Descripcion o Articulo
			$desc = $row["dpro_detalle"];
			$salida.= '<td align = "left">'.$desc.'</td>';
			//Cantidad
			$cant = $row["dpro_cantidad"];
			$salida.= '<td align = "center">'.$cant.'</td>';
			//Precio Compra.
			$salida.= '<td align = "center">-</td>';
			//Precio Costo.
			$salida.= '<td align = "center">-</td>';
			//Precio Venta.
			$mons = $row["mon_simbolo"];
			$monc = $row["dpro_tcambio"];
			$Vmonc = $row["pro_tcambio"];
			$Vmons = $row["mon_simbolo_proyecto"];
			$pre = $row["dpro_precio"];
			$salida.= '<td align = "center">'.$mons.'. '.$pre.'</td>';
			//Variacion
			$salida.= '<td align = "center">-</td>';
			//Descuento
			$dsc = $row["dpro_descuento"];
			$salida.= '<td align = "center">'.$dsc.' %</td>';
			//sub Total
			$monc = $row["dpro_tcambio"];
			$Vmonc = $row["pro_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$Total+= $Dcambiar;
			$Rcambiar = Cambio_Moneda($monc,$Vmonc,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = round($stot, 2);
			$iva = ($stot * 12)/100;
			$iva = round($iva, 2);
			$TIVA+=$iva;
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
			$salida.= '<th align = "right" colspan = "19"> IVA</th>';
			$salida.= '<th align = "right" colspan = "2">'.$Vmons.' '.$TIVA.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$Total = round($Total, 2);
			$salida.= '<th align = "right" colspan = "19"> TOTAL SIN IVA</td>';
			$salida.= '<th align = "right" colspan = "2">'.$Vmons.' '.$Total.'</th>';
			$salida.= '</tr>';
			//--
			$salida.= '<tr>';
			$salida.= '<th align = "right" colspan = "19"> TOTAL CON IVA</td>';
			$TotalIVA = round($Total + $TIVA,2);
			$salida.= '<th align = "right" colspan = "2">'.$Vmons.' '.$TotalIVA.'</th>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '<br>';
			$salida.= '</div>';
	}
	return $salida;
}

//echo tabla_historial_proyecto(5,$suc,$pv,$ser,$facc,$fini,$ffin,$sit,"A");
//echo tabla_detalle_proyecto(5);
//$ClsVntCred = new ClsVntCredito();
//echo $ClsVntCred->insert_cobro_creditos(1,4,1,10,1,1,2,'VISA','1234123','R');;

?>
