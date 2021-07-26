<?php 
include_once('../html_fns.php');

function tabla_punto_venta($cod,$suc,$nom,$sit,$acc){
	$ClsPV = new ClsPuntoVenta();
	$result = $ClsPV->get_punto_venta($cod,$suc,$nom,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "80px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "130px">EMPRESA</th>';
			$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "60px">SITUACI&Oacute;N</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$caja = $row["pv_codigo"];
			$suc = $row["pv_sucursal"];
			$sit = $row["pv_situacion"];
			$sucn = utf8_decode($row["suc_nombre"]);
			$desc = utf8_decode($row["pv_nombre"]);
			if($acc == "MOD"){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_PV('.$caja.','.$suc.');" title = "Editar Caja" ><span class="glyphicon glyphicon-pencil"></span></button> ';
				$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="abrir();Deshabilita_PV('.$caja.','.$suc.');" title = "Deshabilitar Caja" ><span class="glyphicon glyphicon-trash"></span></button> ';
				$salida.= '</td>';
			}else if($acc == "SALDO"){
				$salida.= '<td class = "text-center">'.$i.'. </td>';
			}else if($acc == "ACD"){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="Seleccionar_PV('.$caja.',\''.$desc.'\','.$suc.',\''.$sucn.'\',\'I\')" title = "Seleccionar Caja" ><span class="fa fa-check"></span></button>';
				$salida.= '</td>';
			}else if($acc == "ACR"){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="Seleccionar_PV('.$caja.',\''.$desc.'\','.$suc.',\''.$sucn.'\',\'E\')" title = "Seleccionar Caja" ><span class="fa fa-check"></span></button>';
				$salida.= '</td>';
			}else{
				$salida.= '<td class = "text-center">'.$i.'. </td>';
			}
			//empresa
			$salida.= '<td class = "text-center">'.$sucn.'</td>';
			//DESCRIPCION
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//situacion
			$sit = ($sit == 1)?"<strong class='text-success'>ACTIVA</strong>":"<strong class='text-danger'>INACTIVA</strong>";
			$salida.= '<td class = "text-center" >'.$sit.'</td>';
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


function tabla_pv_saldos($pv,$suc){
	$ClsPV = new ClsPuntoVenta();
	$ClsMon = new ClsMoneda();
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$oftCamb = $row["mon_cambio"];
			$oftSimb = $row["mon_simbolo"];
		}
	}
			$salida.= '<div class="panel-body">';
			$salida.= '<div class = "text-center">';
			$salida.= '<h5 class = "alert alert-info">SALDO A FECHA FINAL</h5>';
			$salida.= '</div>';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "50px">No.</th>';
			$salida.= '<th class = "text-center" width = "200px">MONEDA</th>';
			$salida.= '<th class = "text-center" width = "100px">SALDO</th>';
			$salida.= '<th class = "text-center" width = "100px">T/CAMBIO</th>';
			$salida.= '<th class = "text-center" width = "100px">CAMBIO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
	$i = 1;	
	$total = 0;
	$fini = "01/01/2000";
	$ffin = date("d/m/Y");
	$result = $ClsPV->get_saldo_actual($pv,$suc,$fini,$ffin);
	if(is_array($result)){
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$simbolo = $row["mon_simbolo"];
			$moneda = $row["mon_desc"];
			$ingresos = number_format($row["ingresos"],2,'.','');
			$egresos = number_format($row["egresos"],2,'.','');
			$tcamb = $row["mon_cambio"];
			$saldo = ($ingresos - $egresos);
			$saldo = number_format($saldo,2, '.', '');
			$cambio = Cambio_Moneda($tcamb,$oftCamb,$saldo);
			$cambio = number_format($cambio,2, '.', '');
			$total += $cambio;
			if($saldo >0){
				//No.
				$salida.= '<td class = "text-center">'.$i.'.</td>';
				//Moneda
				$salida.= '<td class = "text-left">'.$moneda.'</td>';
				//saldo
				$salida.= '<td class = "text-center" >'.$simbolo.'. '.$saldo.'</td>';
				//Tasa Cambio
				$salida.= '<td class = "text-center" >'.$tcamb.' x 1</td>';
				//cambio
				$salida.= '<td class = "text-center" >'.$oftSimb.'. '.$cambio.'</td>';
				$salida.= '</tr>';
				$i++;
			}
		}
			$i--;
			$total = number_format($total,2, '.', '');
			$salida.= '<tr>';
			$salida.= '<td class = "text-right" colspan = "4"><strong>TOTAL</strong></td>';
			$salida.= '<td class = "text-center"><strong>'.$oftSimb.'. '.$total.'</strong></td>';
			$salida.= '</tr>';
	}else{
		$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "5" ><strong>NO HAY MOVIMIENTOS ANTERIORES</strong></td>';
		$salida.= '</tr>';
	}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
			
			
	return $salida;
}

function tabla_pv_movimiento($pv,$suc,$fini,$ffin){
	$ClsPV = new ClsPuntoVenta();
	$ClsMon = new ClsMoneda();
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$oftCamb = $row["mon_cambio"];
			$oftSimb = $row["mon_simbolo"];
		}
	}
	
	///////////////////// SALDO ANTERIOR //////////////////////////
			$salida.= '<div class="panel-body">';
			$salida.= '<div class = "text-center">';
			$salida.= '<h5 class = "alert alert-info">SALDO DE OPERACIONES ANTERIORES</h5>';
			$salida.= '</div>';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" >';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "50px">No.</th>';
			$salida.= '<th class = "text-center" width = "200px">MONEDA</th>';
			$salida.= '<th class = "text-center" width = "100px">SALDO</th>';
			$salida.= '<th class = "text-center" width = "100px">T/CAMBIO</th>';
			$salida.= '<th class = "text-center" width = "100px">CAMBIO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
	$result = $ClsPV->get_saldo_anterior($pv,$suc,$fini);
	if(is_array($result)){
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
			$saldo = number_format($saldo,2, '.', '');
			$cambio = Cambio_Moneda($tcamb,$oftCamb,$saldo);
			$total += $cambio;
			if($saldo >0){
				$arrmondesc[$moncant] = $moneda;
				//No.
				$salida.= '<td class = "text-center">'.$moncant.'.</td>';
				//Moneda
				$salida.= '<td class = "text-center" align = "left">'.$moneda.'</td>';
				//saldo
				$salida.= '<td class = "text-center" >'.$simbolo.'. '.$saldo.'</td>';
				//Tasa Cambio
				$salida.= '<td class = "text-center" >'.$tcamb.' x 1</td>';
				//cambio
				$salida.= '<td class = "text-center" >'.$oftSimb.'. '.$cambio.'</td>';
				$salida.= '</tr>';
				$moncant++;
			}
		}
			$moncant--;
			$total = number_format($total,2, '.', '');
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "4" ><strong>TOTAL</strong></td>';
			$salida.= '<td class = "text-center"><strong>'.$oftSimb.'. '.$total.'</strong></td>';
			$salida.= '</tr>';
	}else{
		$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "5" ><strong>NO HAY MOVIMIENTOS ANTERIORES</strong></td>';
		$salida.= '</tr>';
	}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	
	///////////////////// MOVIMIENTOS //////////////////////////
			$salida.= '<div class="panel-body">';
			$salida.= '<div class = "text-center">';
			$salida.= '<h5 class = "alert alert-info">MOVIMIENTOS</h5>';
			$salida.= '</div>';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px" >No.</th>';
			$salida.= '<th class = "text-center" width = "80px" ># TRANS.</th>';
			$salida.= '<th class = "text-center" width = "120px" >FECHA/HORA</th>';
			$salida.= '<th class = "text-center" width = "60px" >MOV.</th>';
			$salida.= '<th class = "text-center" width = "100px" >MOTIVO</th>';
			$salida.= '<th class = "text-center" width = "130px" >JUSTIFICACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "80px" >DOCUMENTO</th>';
			$salida.= '<th class = "text-center" width = "80px" >MONEDA</th>';
			$salida.= '<th class = "text-center" width = "50px" ><strong>ENTR&Oacute;</strong></th>';
			$salida.= '<th class = "text-center" width = "50px" ><strong>SALI&Oacute;</strong></th>';
			$salida.= '<th class = "text-center" width = "60px" >T/CAMB.</th>';
			$salida.= '<th class = "text-center" width = "50px" >CAMBIO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
	$result = $ClsPV->get_mov_pv('',$pv,$suc,'','','','','',$fini,$ffin,1);
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Codigo
			$cod = Agrega_Ceros($row["mpv_codigo"]);
			$pv = Agrega_Ceros($row["mpv_punto_venta"]);
			$suc = Agrega_Ceros($row["mpv_sucursal"]);
			$codigo = $cod."-".$pv."-".$suc;
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//fecha hora
			$fec = $row["mpv_fecha"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center">'.$fec.'</td>';
			//Movimiento
			$mov = $row["mpv_movimiento"];
			$mov = ($mov == "I")?"INGRESO":"EGRESO";
			$salida.= '<td class = "text-center">'.$mov.'</td>';
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
			$salida.= '<td class = "text-center">'.$mot.'</td>';
			//justificacion
			$just = utf8_decode($row["mpv_motivo"]);
			$salida.= '<td class = "text-justify">'.$just.'</td>';
			//Documento o Boucher
			$doc = $row["mpv_doc"];
			$doc = Agrega_Ceros($doc);
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			//MONEDA
			$mon = utf8_decode($row["mon_desc"]);
			$salida.= '<td class = "text-center">'.$mon.'</td>';
			///monto
			$mons = trim($row["mon_simbolo"]);
			$mov = trim($row["mpv_movimiento"]);
			$cant = number_format($row["mpv_monto"],2,'.','');
			if($mov == "I"){
				$entra = $cant;
				$sale = "";
			}else if($mov == "E"){
				$entra = "";
				$sale = $cant;
			}
			$Tentra+= $entra;
			$Tsale += $sale;
			$salida.= '<td class = "text-center">'.$entra.'</td>';
			$salida.= '<td class = "text-center">'.$sale.'</td>';
			//tasa cambio
			$tcamb = $row["mon_cambio"];
			$salida.= '<td class = "text-center">'.$tcamb.' x 1</td>';
			//--
			$cambio = Cambio_Moneda($tcamb,$oftCamb,$cant);
			$cambio = number_format($cambio,2, '.', '');
			$salida.= '<td class = "text-center">'.$cambio.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
	}else{
		$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "12" ><strong>NO HAY MOVIMIENTOS</strong></td>';
		$salida.= '</tr>';
	}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
			
	///////////////////// SALDO ACTUAL //////////////////////////
			$salida.= '<div class="panel-body">';
			$salida.= '<div class = "text-center">';
			$salida.= '<h5 class = "alert alert-info">SALDO A FECHA FINAL</h5>';
			$salida.= '</div>';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "50px">No.</th>';
			$salida.= '<th class = "text-center" width = "200px">MONEDA</th>';
			$salida.= '<th class = "text-center" width = "100px">SALDO</th>';
			$salida.= '<th class = "text-center" width = "100px">T/CAMBIO</th>';
			$salida.= '<th class = "text-center" width = "100px">CAMBIO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
	$fini = "01/01/2000";
	$result = $ClsPV->get_saldo_actual($pv,$suc,$fini,$ffin);
	if(is_array($result)){
	$moncant = 1;	
	$total = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$simbolo = $row["mon_simbolo"];
			$moneda = utf8_decode($row["mon_desc"]);
			$ingresos = $row["ingresos"];
			$egresos = $row["egresos"];
			$tcamb = $row["mon_cambio"];
			$saldo = ($ingresos - $egresos);
			$saldo = number_format($saldo,2, '.', '');
			$cambio = Cambio_Moneda($tcamb,$oftCamb,$saldo);
			$total += $cambio;
			if($saldo >0){
				$arrmondesc[$moncant] = $moneda;
				//No.
				$salida.= '<td class = "text-center">'.$moncant.'.</td>';
				//Moneda
				$salida.= '<td class = "text-center" align = "left">'.$moneda.'</td>';
				//saldo
				$salida.= '<td class = "text-center" >'.$simbolo.'. '.$saldo.'</td>';
				//Tasa Cambio
				$salida.= '<td class = "text-center" >'.$tcamb.' x 1</td>';
				//cambio
				$salida.= '<td class = "text-center" >'.$oftSimb.'. '.number_format($cambio,2,'.','').'</td>';
				$salida.= '</tr>';
				$moncant++;
			}
		}
			$moncant--;
			$total = number_format($total,2, '.', '');
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "4" ><strong>TOTAL</strong></td>';
			$salida.= '<td class = "text-center"><strong>'.$oftSimb.'. '.$total.'</strong></td>';
			$salida.= '</tr>';
	}else{
		$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "12" ><strong>NO HAY SALDO PARA REPORTAR</strong></td>';
		$salida.= '</tr>';
	}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	
	return $salida;
}



function tabla_movimientos($caja,$suc,$fini,$ffin){
	$ClsPV = new ClsPuntoVenta();
	$result = $ClsPV->get_mov_pv("",$caja,$suc,'','','','',$fini,$ffin,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" width = "30px" >No.</td>';
			$salida.= '<td class = "text-center" width = "80px" ># TRANS.</td>';
			$salida.= '<td class = "text-center" width = "120px">FECHA/HORA</td>';
			$salida.= '<td class = "text-center" width = "60px" >MOV.</td>';
			$salida.= '<td class = "text-center" width = "120px" >MOTIVO</td>';
			$salida.= '<td class = "text-center" width = "200px" >JUSTIFICACI&Oacute;N</td>';
			$salida.= '<td class = "text-center" width = "100px" >DOCUMENTO</td>';
			$salida.= '<td class = "text-center" width = "50px" ><b>ENTR&Oacute;</b></td>';
			$salida.= '<td class = "text-center" width = "50px" ><b>SALI&Oacute;</b></td>';
			$salida.= '<td class = "text-center" width = "50px" ><b>SALDO</b></td>';
			$salida.= '</tr>';
		$i = 1;	
		$saldo = $ClsPV->get_saldo_anterior($caja,$suc,$fini);	
		$Tentra = 0;
		$Tsale = 0;
		foreach($result as $row){
			if ($i == 1){ //--
			$mons = trim($row["mon_simbolo"]);	
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "7"> <strong>SALDO DE OPERACIONES ANTERIORES</strong></td>';
			$salida.= '<td class = "text-center" ></td>';
			$salida.= '<td class = "text-center" ></td>';
			$salida.= '<td class = "text-center"><strong>'.$mons.'. '.$saldo.'</strong>';
			$salida.= '</tr>';
			} //--
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Codigo
			$cod = Agrega_Ceros($row["mpv_codigo"]);
			$caj = Agrega_Ceros($row["mpv_punto_venta"]);
			$suc = Agrega_Ceros($row["mpv_sucursal"]);
			$codigo = $cod."-".$caj."-".$suc;
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//fecha hora
			$fec = $row["mpv_fecha"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center">'.$fec.'</td>';
			//Movimiento
			$mov = $row["mpv_movimiento"];
			$mov = ($mov == "I")?"CREDITO":"DEBITO";
			$salida.= '<td class = "text-center">'.$mov.'</td>';
			//Motivo
			$mot = $row["mpv_tipo"];
			switch($mot){
				case "C": $mot = "COMPRA"; break;
				case "RT": $mot = "RETIRO"; break;
				case "TR": $mot = "TRASLADO A CUENTA"; break;
				case "RB": $mot = "REMBOLSO DE FONDOS"; break;
				case "DP": $mot = "DEPOSITO"; break;
			}
			$salida.= '<td class = "text-center">'.$mot.'</td>';
			//justificacion
			$just = utf8_decode($row["mpv_motivo"]);
			$salida.= '<td class = "text-justify">'.$just.'</td>';
			//Documento o Boucher
			$doc = utf8_decode($row["mpv_doc"]);
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			///monto
			$mons = trim($row["mon_simbolo"]);
			$mov = trim($row["mpv_movimiento"]);
			$cant = number_format($row["mpv_monto"],2,'.','');
			if($mov == "I"){
				$entra = $cant;
				$sale = "";
				$saldo += $entra;
			}else if($mov == "E"){
				$entra = "";
				$sale = $cant;
				$saldo -=  $sale;
			}
			$Tentra+= $entra;
			$Tsale += $sale;
			$salida.= '<td class = "text-center">'.$entra.'</td>';
			$salida.= '<td class = "text-center">'.$sale.'</td>';
			$salida.= '<td class = "text-center">'.$saldo.'</td>';
			//--
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
			$i++;
		}
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "10"><br></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$Tentra = number_format($Tentra,2, '.', '');
			$salida.= '<td class = "text-center" colspan = "7" > <strong>TOTAL INGRESOS</strong></td>';
			$salida.= '<td class = "text-center"><strong>'.$mons.'. '.$Tentra.'</strong>';
			$salida.= '<td class = "text-center" colspan = "2" ></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$Tsale = number_format($Tsale,2, '.', '');
			$salida.= '<td class = "text-center" colspan = "7" > <strong>TOTAL EGRESOS</strong></td>';
			$salida.= '<td class = "text-center" ></td>';
			$salida.= '<td class = "text-center"><strong>'.$mons.'. '.$Tsale.'</strong>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$saldo = number_format($saldo,2, '.', '');
			$salida.= '<td class = "text-center" colspan = "7" > <strong>SALDO</strong></td>';
			$salida.= '<td class = "text-center" colspan = "2" ></td>';
			$salida.= '<td class = "text-center"><b style = "color:green">'.$mons.'. '.$saldo.'</strong>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


//echo tabla_articulos($cod,$banp,$nom,$desc,$marca,$sit);

/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Tablas de Reportes ///////////////////////////////////////////////


//echo tabla_pv_movimiento(1,1,"01/06/2013","17/06/2013");

?>
