<?php 
include_once('../html_fns.php');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function rep_caja_movimientos($caja,$suc,$fini,$ffin){
	$ClsCaj = new ClsCaja();
	$result = $ClsCaj->get_mov_caja("",$caja,$suc,'','','','',$fini,$ffin,1);
	
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<th width = "30px" align = "center" >No.</th>';
			$salida.= '<th width = "80px" align = "center" ># TRANS.</th>';
			$salida.= '<th width = "120px" align = "center" >FECHA/HORA</th>';
			$salida.= '<th width = "60px" align = "center" >MOV.</th>';
			$salida.= '<th width = "120px" align = "center" >MOTIVO</th>';
			$salida.= '<th width = "200px" align = "center" >JUSTIFICACIÓN</th>';
			$salida.= '<th width = "100px" align = "center" >DOCUMENTO</th>';
			$salida.= '<th width = "50px" align = "center" ><b>ENTRÓ</b></th>';
			$salida.= '<th  width = "50px" align = "center" ><b>SALIÓ</b></th>';
			$salida.= '<th  width = "50px" align = "center" ><b>SALDO</b></th>';
			$salida.= '</tr>';
	if(is_array($result)){
		$i = 1;	
		$saldo = $ClsCaj->get_saldo_anterior($caja,$suc,$fini);	
		$Tentra = 0;
		$Tsale = 0;
		foreach($result as $row){
			if ($i == 1){ //--
			$mons = trim($row["mon_simbolo"]);	
			$salida.= '<tr>';
			$salida.= '<td colspan = "7" align = "center"> <b>SALDO DE OPERACIONES ANTERIORES</b></td>';
			$salida.= '<td ></td>';
			$salida.= '<td ></td>';
			$salida.= '<td align = "center"><b>'.$mons.'. '.$saldo.'</b></td>';
			$salida.= '</tr>';
			} //--
			$salida.= '<tr>';
			//--
			$salida.= '<td align = "center" >'.$i.'.</td>';
			//Codigo
			$cod = Agrega_Ceros($row["mcj_codigo"]);
			$caj = Agrega_Ceros($row["mcj_caja"]);
			$suc = Agrega_Ceros($row["mcj_sucursal"]);
			$codigo = $cod."-".$caj."-".$suc;
			$salida.= '<td align = "center">'.$codigo.'</td>';
			//fecha hora
			$fec = $row["mcj_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//Movimiento
			$mov = $row["mcj_movimiento"];
			$mov = ($mov == "I")?"CREDITO":"DEBITO";
			$salida.= '<td align = "center">'.$mov.'</td>';
			//Motivo
			$mot = $row["mcj_tipo"];
			switch($mot){
				case "C": $mot = "COMPRA"; break;
				case "RT": $mot = "RETIRO"; break;
				case "TR": $mot = "TRASLADO A CUENTA"; break;
				case "RB": $mot = "REMBOLSO DE FONDOS"; break;
				case "DP": $mot = "DEPOSITO"; break;
			}
			$salida.= '<td align = "center">'.$mot.'</td>';
			//justificacion
			$just = $row["mcj_motivo"];
			$salida.= '<td  class = "text-justify">'.$just.'</td>';
			//Documento o Boucher
			$doc = $row["mcj_doc"];
			$salida.= '<td align = "center">'.$doc.'</td>';
			///monto
			$mons = trim($row["mon_simbolo"]);
			$mov = trim($row["mcj_movimiento"]);
			$cant = $row["mcj_monto"];
			if($mov == "I"){
				$entra = $cant;
				$sale = "";
				$saldo += $entra;
			}else if($mov == "E"){
				$entra = "";
				$sale = $cant;
				$saldo -=  $sale;
			}
			$saldo = round($saldo,4);
			$Tentra+= $entra;
			$Tsale += $sale;
			$salida.= '<td align = "center">'.$entra.'</td>';
			$salida.= '<td align = "center">'.$sale.'</td>';
			$salida.= '<td align = "center">'.$saldo.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			//----
			$salida.= '<tr>';
			$salida.= '<td colspan = "10" align = "center"><br></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th colspan = "7" align = "right"> <b>TOTAL INGRESOS</b></th>';
			$salida.= '<th align = "center"><b>'.$mons.'. '.$Tentra.'</b>';
			$salida.= '<th colspan = "2" ></th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th colspan = "7" align = "right"> <b>TOTAL EGRESOS</b></th>';
			$salida.= '<th ></th>';
			$salida.= '<th align = "center"><b>'.$mons.'. '.$Tsale.'</b></th>';
			$salida.= '<th></th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th colspan = "7" align = "right"> <b>SALDO</b></th>';
			$salida.= '<th colspan = "2" ></th>';
			$salida.= '<th align = "center"><b style = "color:green">'.$mons.'. '.$saldo.'</b></th>';
			$salida.= '</tr>';
        }else{
		$salida.= '<tr>';
		$salida.= '<td colspan = "10"><b> No se reportan Movimientos en este Cierre </b></td>';
		$salida.= '</tr>';
	}            
			//----
			$salida.= '</table>';
			$salida.= '</div>';
	
	return $salida;
}

function rep_tabla_movimientos_cajas($suc,$fini,$ffin){
	$ClsCaj = new ClsCaja();
	$result = $ClsCaj->get_caja('',$suc);
	
	if(is_array($result)){
		foreach($result as $row){
			$caja = $row["caja_codigo"];
			$desc = $row["caja_descripcion"];
			$salida.= '<h3>'.$desc.'</h3><br>';
			$salida.= rep_caja_movimientos($caja,$suc,$fini,$ffin);
			$salida.= '<br>';
		}	
	}
	
	return $salida;
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function rep_pv_movimiento($pv,$suc,$fini,$ffin){
	$ClsPV = new ClsPuntoVenta();
	$ClsMon = new ClsMoneda();
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$oftCamb = $row["mon_cambio"];
			$oftSimb = $row["mon_simbolo"];
		}
	}
	
	$salida = '<div id = "reportes">';
	$salida.= '<table>';
	$result = $ClsPV->get_saldo_anterior($pv,$suc,$fini);
	if(is_array($result)){
			$salida.= '<tr>';
			$salida.= '<th colspan = "12">SALDO ANTERIOR</th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th width = "50px">No.</th>';
			$salida.= '<th align = "center" colspan = "6">&nbsp;</th>';
			$salida.= '<th width = "100px">MONEDA</th>';
			$salida.= '<th width = "100px" colspan = "2">SALDO</th>';
			$salida.= '<th width = "100px">T/CAMBIO</th>';
			$salida.= '<th width = "100px">CAMBIO</th>';
			$salida.= '</tr>';
	$moncant = 1;	
	$total = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$simbolo = $row["mon_simbolo"];
			$moneda = $row["mon_desc"];
			$ingresos = $row["ingresos"];
			$egresos = $row["egresos"];
			$tcamb = $row["mon_cambio"];
			$saldo = ($ingresos - $egresos);
			$saldo = round($saldo,2);
			$cambio = Cambio_Moneda($tcamb,$oftCamb,$saldo);
			$total += $cambio;
			if($saldo >0){
				$arrmondesc[$moncant] = $moneda;
				//No.
				$salida.= '<td align = "center">'.$moncant.'.</td>';
				//Moneda
				$salida.= '<td align = "center" colspan = "6">&nbsp;</td>';
				$salida.= '<td align = "center">'.$moneda.'</td>';
				//saldo
				$salida.= '<td align = "center" colspan = "2" >'.$simbolo.'. '.$saldo.'</td>';
				//Tasa Cambio
				$salida.= '<td align = "center" >'.$tcamb.' x 1</td>';
				//cambio
				$salida.= '<td align = "center" >'.$oftSimb.'. '.$cambio.'</td>';
				$salida.= '</tr>';
				$moncant++;
			}
		}
			$moncant--;
			$total = round($total,2);
			$salida.= '<tr>';
			$salida.= '<td colspan = "11" align = "right"><b>TOTAL</b></td>';
			$salida.= '<td align = "center"><b>'.$oftSimb.'. '.$total.'</b></td>';
			$salida.= '</tr>';
	}
	
	$result = $ClsPV->get_mov_pv('',$pv,$suc,'','','','','',$fini,$ffin,1);
	if(is_array($result)){
			$salida.= '<tr>';
			$salida.= '<th colspan = "12">MOVIMIENTOS</th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td width = "30px" align = "center" >No.</td>';
			$salida.= '<td width = "80px" align = "center" ># TRANS.</td>';
			$salida.= '<td width = "120px" align = "center" >FECHA/HORA</td>';
			$salida.= '<td width = "60px" align = "center" >MOV.</td>';
			$salida.= '<td width = "100px" align = "center" >MOTIVO</td>';
			$salida.= '<td width = "130px" align = "center" >JUSTIFICACIÓN</td>';
			$salida.= '<td width = "80px" align = "center" >DOCUMENTO</td>';
			$salida.= '<td width = "80px" align = "center" ><b>MODENA</b></td>';
			$salida.= '<td width = "50px" align = "center" ><b>ENTRÓ</b></td>';
			$salida.= '<td  width = "50px" align = "center" ><b>SALIÓ</b></td>';
			$salida.= '<td width = "60px" align = "center" >T/CAMB.</td>';
			$salida.= '<td width = "50px" align = "center" >CAMBIO</td>';
			$salida.= '</tr>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td align = "center" >'.$i.'.</td>';
			//Codigo
			$cod = Agrega_Ceros($row["mpv_codigo"]);
			$pv = Agrega_Ceros($row["mpv_punto_venta"]);
			$suc = Agrega_Ceros($row["mpv_sucursal"]);
			$codigo = $cod."-".$pv."-".$suc;
			$salida.= '<td align = "center">'.$codigo.'</td>';
			//fecha hora
			$fec = $row["mpv_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td align = "center">'.$fec.'</td>';
			//Movimiento
			$mov = $row["mpv_movimiento"];
			$mov = ($mov == "I")?"INGRESO":"EGRESO";
			$salida.= '<td align = "center">'.$mov.'</td>';
			//Motivo
			$mot = $row["mpv_tipo"];
			switch($mot){
				case "C": $mot = "COMPRA"; break;
				case "RT": $mot = "RETIRO"; break;
				case "RC": $mot = "CORTE DE CAJA"; break;
				case "TR": $mot = "TRASLADO A CUENTA"; break;
				case "V": $mot = "VENTA"; break;
				case "RB": $mot = "REMBOLSO DE FONDOS"; break;
				case "DP": $mot = "DEPOSITO"; break;
			}
			$salida.= '<td align = "center">'.$mot.'</td>';
			//justificacion
			$just = $row["mpv_motivo"];
			$salida.= '<td  class = "text-justify">'.$just.'</td>';
			//Documento o Boucher
			$doc = $row["mpv_doc"];
			$doc = Agrega_Ceros($doc);
			$salida.= '<td align = "center">'.$doc.'</td>';
			//MONEDA
			$mon = $row["mon_desc"];
			$salida.= '<td align = "center">'.$mon.'</td>';
			///monto
			$mons = trim($row["mon_simbolo"]);
			$mov = trim($row["mpv_movimiento"]);
			$cant = $row["mpv_monto"];
			if($mov == "I"){
				$entra = $cant;
				$sale = "";
			}else if($mov == "E"){
				$entra = "";
				$sale = $cant;
			}
			$Tentra+= $entra;
			$Tsale += $sale;
			$salida.= '<td align = "center">'.$entra.'</td>';
			$salida.= '<td align = "center">'.$sale.'</td>';
			//tasa cambio
			$tcamb = $row["mon_cambio"];
			$salida.= '<td align = "center">'.$tcamb.' x 1</td>';
			//--
			$cambio = Cambio_Moneda($tcamb,$oftCamb,$cant);
			$cambio = round($cambio,2);
			$salida.= '<td align = "center">'.$cambio.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
	}else{
		$salida.= '<tr>';
		$salida.= '<td colspan = "12"><b> No se reportan Movimientos en este Cierre </b></td>';
		$salida.= '</tr>';
	}
	
			$salida.= '<tr>';
			$salida.= '<td colspan = "12"> &nbsp; </td>';
			$salida.= '</tr>';
	
	$fini = "01/01/2000";
	$result = $ClsPV->get_saldo_actual($pv,$suc,$fini,$ffin);
	if(is_array($result)){
			$salida.= '<tr>';
			$salida.= '<th colspan = "12">SALDO A FECHA FINAL</th>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th width = "50px">No.</th>';
			$salida.= '<th align = "center" colspan = "6">&nbsp;</th>';
			$salida.= '<th width = "100px">MONEDA</th>';
			$salida.= '<th width = "100px" colspan = "2">SALDO</th>';
			$salida.= '<th width = "100px">T/CAMBIO</th>';
			$salida.= '<th width = "100px">CAMBIO</th>';
			$salida.= '</tr>';
	$moncant = 1;	
	$total = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$simbolo = $row["mon_simbolo"];
			$moneda = $row["mon_desc"];
			$ingresos = $row["ingresos"];
			$egresos = $row["egresos"];
			$tcamb = $row["mon_cambio"];
			$saldo = ($ingresos - $egresos);
			$saldo = round($saldo,2);
			$cambio = Cambio_Moneda($tcamb,$oftCamb,$saldo);
			$total += $cambio;
			if($saldo >0){
				$arrmondesc[$moncant] = $moneda;
				//No.
				$salida.= '<td align = "center">'.$moncant.'.</td>';
				//Moneda
				$salida.= '<td align = "center" colspan = "6">&nbsp;</td>';
				$salida.= '<td align = "center">'.$moneda.'</td>';
				//saldo
				$salida.= '<td align = "center" colspan = "2" >'.$simbolo.'. '.$saldo.'</td>';
				//Tasa Cambio
				$salida.= '<td align = "center" >'.$tcamb.' x 1</td>';
				//cambio
				$salida.= '<td align = "center" >'.$oftSimb.'. '.$cambio.'</td>';
				$salida.= '</tr>';
				$moncant++;
			}
		}
			$moncant--;
			$total = round($total,2);
			$salida.= '<tr>';
			$salida.= '<th colspan = 11" align = "right"><b>TOTAL</b></th>';
			$salida.= '<th align = "center"><b>'.$oftSimb.'. '.$total.'</b></th>';
			$salida.= '</tr>';
	}
			$salida.= '</table>';
			$salida.= '</div>';
	
	return $salida;
}



function rep_tabla_movimientos_pv($pv,$suc,$fini,$ffin){
	$ClsPV = new ClsPuntoVenta();
	$result = $ClsPV->get_punto_venta($pv,$suc);
	
	if(is_array($result)){
		foreach($result as $row){
			$pv = $row["pv_codigo"];
			$desc = $row["pv_nombre"];
			$salida.= '<h3>'.$desc.'</h3><br>';
			$salida.= rep_pv_movimiento($pv,$suc,$fini,$ffin);
			$salida.= '<br>';
		}	
	}
	
	return $salida;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function rep_tabla_cuentas_x_cobrar($pv,$suc,$tipo,$fini,$ffin){
	$ClsVntCred = new ClsVntCredito();
	$result = $ClsVntCred->get_cobro_creditos_pv('',$ven,$suc,$pv,$tipo,$fini,$ffin,'','',1);
	
	if(is_array($result)){
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
            		$i--;
			$salida.= '<tr>';
			$salida.= '<th colspan = "11" align = "right"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}else{
		$salida.= '<h4>No se Registran Documentos en este Cierre</h4>';
	}
		
	return $salida;
}


function rep_tabla_creditos_x_cobrar($pv,$suc,$fini,$ffin){
	$ClsCred = new ClsCredito();
	$result = $ClsCred->get_credito_venta_pv("",$vent,$suc,$pv,$fini,$ffin,1);
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
		$salida.= '<h4>No se Registran Creditos en este Cierre</h4>';
	}
	
	return $salida;
}



?>
