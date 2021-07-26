<?php 
include_once('../html_fns.php');

function tabla_bancos($cod,$dct,$dlg,$pai,$sit){
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_banco($cod,$dct,$dlg,$pai,$sit);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "80px"><span class="fa fa-cogs"></span></th>';
		$salida.= '<th class = "text-center" width = "150px">NOMBRE CORTO</th>';
		$salida.= '<th class = "text-center" width = "250px">NOMBRE LARGO</th>';
		$salida.= '<th class = "text-center" width = "150px">PAIS</th>';
		$salida.= '<th class = "text-center" width = "100px">SITUACI&Oacute;N</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$ban = $row["ban_codigo"];
			$sit = $row["ban_situacion"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Banco('.$ban.');" title = "Editar Banco" ><span class="fa fa-pencil"></span></button> ';
			if($sit == 1){
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Deshabilita_Banco('.$ban.');" title = "Deshabilitar Banco" ><span class="fa fa-trash"></span></button> ';
			}else if($sit == 0){
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="Habilita_Banco('.$ban.');" title = "Habilitar Banco" ><span class="fa fa-retweet"></span></button> ';
			}
			$salida.= '</td>';
			//desc
			$dct = utf8_decode($row["ban_desc_ct"]);
			$salida.= '<td class = "text-center">'.$dct.'</td>';
			//desc
			$dlg = utf8_decode($row["ban_desc_lg"]);
			$salida.= '<td class = "text-center">'.$dlg.'</td>';
			//pais
			$pai = utf8_decode($row["pai_desc"]);
			$salida.= '<td class = "text-center">'.$pai.'</td>';
			//situacion
			$sit = ($sit == 1)?"<strong class='text-success'>ACTIVA</strong>":"<strong class='text-danger'>INACTIVA</strong>";
			$salida.= '<td class = "text-center" >'.$sit.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_cuenta_banco($cod,$ban,$num,$tip,$mon,$pai,$sit,$acc){
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_cuenta_banco($cod,$ban,$num,$tip,$mon,$pai,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			if($acc == "VIS" || $acc == ""){
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			}else if($acc == "MOD" || $acc == "ACD" || $acc == "ACR"){
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "100px"><span class="fa fa-cogs"></span></th>';
			}	
			$salida.= '<th class = "text-center" width = "90px"># CUENTA</th>';
			$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "150px">BANCO</th>';
			$salida.= '<th class = "text-center" width = "150px">EMPRESA</th>';
			$salida.= '<th class = "text-center" width = "100px">TIPO</th>';
			$salida.= '<th class = "text-center" width = "100px">MONEDA</th>';
			$salida.= '<th class = "text-center" width = "150px">SALDO</th>';
			$salida.= '<th class = "text-center" width = "100px">PLAZO</th>';
			if($acc == "VIS"){
			$salida.= '<th class = "text-center" width = "100px" height = "30px">TASA</th>';
			$salida.= '<th class = "text-center" width = "100px" height = "30px">F. INI</th>';
			}
			$salida.= '<th class = "text-center" width = "100px">PAGO INT.</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.	
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//--
			$ban = $row["ban_codigo"];
			$cod = $row["cueb_codigo"];
			$sit = $row["cueb_situacion"];
			$num = utf8_decode($row["cueb_ncuenta"]);
			$bann = utf8_decode($row["ban_desc_ct"]);
			if($acc == "MOD"){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Cuenta('.$cod.','.$ban.');" title = "Editar Cuenta" ><span class="fa fa-pencil"></span></button>';
				if($sit == 1){
				$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Deshabilita_Cuenta('.$cod.','.$ban.');" title = "Deshabilitar Cuenta" ><span class="fa fa-trash"></span></button>';
				}else if($sit == 0){
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="Habilita_Cuenta('.$cod.','.$ban.');" title = "Habilitar Cuenta" ><span class="fa fa-retweet"></span></button>';
				}
				$salida.= '</td>';
			}
			if($acc == "ACD"){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="Seleccionar_Cuenta('.$cod.','.$ban.',\''.$num.'\',\''.$bann.'\',\'I\')" title = "Seleccionar Cuenta" ><span class="fa fa-check"></span></button>';
				$salida.= '</td>';
			}
			if($acc == "ACR"){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="Seleccionar_Cuenta('.$cod.','.$ban.',\''.$num.'\',\''.$bann.'\',\'E\')" title = "Seleccionar Cuenta" ><span class="fa fa-check"></span></button>';
				$salida.= '</td>';
			}
			//numero de cuenta
			$salida.= '<td class = "text-center">'.$num.'</td>';
			//nombre de cuenta
			$nom = utf8_decode($row["cueb_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//banco
			$salida.= '<td class = "text-center">'.$bann.'</td>';
			//empresa
			$empresa = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center">'.$empresa.'</td>';
			//tipo de Cuenta
			$tip = utf8_decode($row["tcue_desc_ct"]);
			$salida.= '<td class = "text-center" >'.$tip.'</td>';
			//Moneda
			$mon = utf8_decode($row["mon_desc"]);
			$salida.= '<td class = "text-center">'.$mon.'</td>';
			//Saldo
			$mons = $row["mon_simbolo"];
			$saldo = $row["cueb_saldo"];
			$saldo = number_format($saldo, 2, '.', '');
			$salida.= '<td class = "text-center">'.$mons.'. '.$saldo.'</td>';
			//plazo
			$plazo = $row["cueb_plazo"];
			$salida.= '<td class = "text-center">'.$plazo.' d&iacute;as</td>';
			if($acc == "VIS"){
			//tasa
			$tasa = $row["cueb_tasa"];
			$salida.= '<td class = "text-center">'.$tasa.' %</td>';
			//fini
			$fini = $row["cueb_fini"];
			$fini = $ClsBan->cambia_fecha($fini);
			$salida.= '<td class = "text-center">'.$fini.'</td>';
			}
			//forma de pago
			$fpag = $row["cueb_forma_pago"];
			switch($fpag){
				case "NA": $fpag = "NO APLICA"; break;
				case "A": $fpag = "ANUAL"; break;
				case "S": $fpag = "SEMESTRAL"; break;
				case "T": $fpag = "TRIMESTRAL"; break;
				case "M": $fpag = "MENSUAL"; break;
				case "Q": $fpag = "QUINCENAL"; break;
			}
			$salida.= '<td class = "text-center">'.$fpag.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_cuenta_movimiento($cod,$ban,$num,$tip,$mon,$fini,$ffin){
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_cuenta_banco($cod,$ban,$num,$tip,$mon,$pai,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "40px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "90px"># CUENTA</th>';
			$salida.= '<th class = "text-center" width = "130px">BANCO</th>';
			$salida.= '<th class = "text-center" width = "90px">TIPO</th>';
			$salida.= '<th class = "text-center" width = "90px">MONEDA</th>';
			$salida.= '<th class = "text-center" width = "100px">SALDO</th>';
			$salida.= '<th class = "text-center" width = "50px">TASA</th>';
			$salida.= '<th class = "text-center" width = "70px">PAGO INT.</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$ban = $row["ban_codigo"];
			$cod = $row["cueb_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="xajax_Seleccionar_Cuenta('.$cod.','.$ban.',\''.$fini.'\',\''.$ffin.'\')" title = "Seleccionar Cuenta" ><span class="fa fa-check"></span></button>';
			$salida.= '</td>';
			//numero de cuenta
			$num = utf8_decode($row["cueb_ncuenta"]);
			$salida.= '<td class = "text-center">'.$num.'</td>';
			//banco
			$bann = utf8_decode($row["ban_desc_ct"]);
			$salida.= '<td class = "text-center">'.$bann.'</td>';
			//tipo de Cuenta
			$tip = utf8_decode($row["tcue_desc_ct"]);
			$salida.= '<td class = "text-center" >'.$tip.'</td>';
			//Moneda
			$mon = utf8_decode($row["mon_desc"]);
			$salida.= '<td class = "text-center">'.$mon.'</td>';
			//Saldo
			$mons = $row["mon_simbolo"];
			$saldo = $row["cueb_saldo"];
			$saldo = number_format($saldo, 2, '.', '');
			$salida.= '<td class = "text-center">'.$mons.'. '.$saldo.'</td>';
			//tasa
			$tasa = $row["cueb_tasa"];
			$salida.= '<td class = "text-center">'.$tasa.' %</td>';
			//forma de pago
			$fpag = $row["cueb_forma_pago"];
			switch($fpag){
				case "NA": $fpag = "NO APLICA"; break;
				case "A": $fpag = "ANUAL"; break;
				case "S": $fpag = "SEMESTRAL"; break;
				case "T": $fpag = "TRIMESTRAL"; break;
				case "M": $fpag = "MENSUAL"; break;
				case "Q": $fpag = "QUINCENAL"; break;
			}
			$salida.= '<td class = "text-center">'.$fpag.'</td>';
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



function tabla_movimientos($cue,$ban,$fini,$ffin){
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_mov_cuenta("",$cue,$ban,'','','','',$fini,$ffin,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px">No.</th>';
			$salida.= '<th class = "text-center" width = "80px"># TRANS.</th>';
			$salida.= '<th class = "text-center" width = "120px">FECHA/HORA</th>';
			$salida.= '<th class = "text-center" width = "50px">MOV.</th>';
			$salida.= '<th class = "text-center" width = "50px">MOTIVO</th>';
			$salida.= '<th class = "text-center" width = "250px">JUSTIFICACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "50px">DOC.</th>';
			$salida.= '<th class = "text-center" width = "70px">ENTR&Oacute;</th>';
			$salida.= '<th class = "text-center" width = "70px">SALI&Oacute;</th>';
			$salida.= '<th class = "text-center" width = "70px">SALDO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		$saldo = $ClsBan->get_saldo_anterior($cue,$ban,$fini);	
		$Tentra = 0;
		$Tsale = 0;
		foreach($result as $row){
			if ($i == 1){ //--
			$mons = trim($row["mon_simbolo"]);	
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "7"> <b>SALDO DE OPERACIONES ANTERIORES</b></td>';
			$salida.= '<td class = "text-center" ></td>';
			$salida.= '<td class = "text-center" ></td>';
			$salida.= '<td class = "text-center"><b>'.$mons.'. '.$saldo.'</b>';
			$salida.= '</tr>';
			} //--
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Codigo
			$cod = Agrega_Ceros($row["mcb_codigo"]);
			$cue = Agrega_Ceros($row["mcb_cuenta"]);
			$ban = Agrega_Ceros($row["mcb_banco"]);
			$codigo = $cod."-".$cue."-".$ban;
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//fecha hora
			$fec = $row["mcb_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center">'.$fec.'</td>';
			//Movimiento
			$mov = $row["mcb_movimiento"];
			$mov = ($mov == "I")?"CREDITO":"DEBITO";
			$salida.= '<td class = "text-center">'.$mov.'</td>';
			//tipo
			$tipo = $row["mcb_tipo"];
			switch($tipo){
				case "TD": $tipo = "TARJETA DEBITO"; break;
				case "CH": $tipo = "CHEQUE"; break;
				case "RT": $tipo = "RETIRO"; break;
				case "FI": $tipo = "FIN DE INVERSI&Oacute;N"; break;
				case "DI": $tipo = "DES-INVERSI&Oacute;N"; break;
				case "DP": $tipo = "DEPOSITO"; break;
				case "IN": $tipo = "INTERESES"; break;
				case "IV": $tipo = "INVERSI&Oacute;N"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//justificacion
			$just = utf8_decode($row["mcb_motivo"]);
			$salida.= '<td class = "text-justify">'.$just.'</td>';
			//Documento o Boucher
			$doc = utf8_decode($row["mcb_doc"]);
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			///monto
			$mons = trim($row["mon_simbolo"]);
			$mov = trim($row["mcb_movimiento"]);
			$cant = number_format($row["mcb_monto"],2,'.','');
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
			$salida.= '</tr>';
			$i++;
		}
			//--
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "7" class = "text-right"></td>';
			$salida.= '<td class = "text-center"><b>'.$mons.'. '.number_format($Tentra,2,'.',',').'</b>';
			$salida.= '<td class = "text-center"><b>'.$mons.'. '.number_format($Tsale,2,'.',',').'</b>';
			$salida.= '<td class = "text-center"><b>'.$mons.'. '.number_format($saldo,2,'.',',').'</b>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "10"><br></td>';
			$salida.= '</tr>';
	$result2 = $ClsBan->get_cheque("",$cue,$ban,'','',$fini,$ffin,1);
	if(is_array($result2)){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "10"><b>CHEQUES EN CIRCULACI&Oacute;N</b></td>';
			$salida.= '</tr>';
		//--
		$saldoProyect =  $saldo;
		$sale =  0;
		$CheqCircula =  0;
		foreach($result2 as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Codigo
			$cod = Agrega_Ceros($row["che_codigo"]);
			$cue = Agrega_Ceros($row["cueb_codigo"]);
			$ban = Agrega_Ceros($row["ban_codigo"]);
			$codigo = $cod."-".$cue."-".$ban;
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//fecha hora
			$fec = $row["che_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center">'.$fec.'</td>';
			//Movimiento
			$salida.= '<td class = "text-center">DEBITO</td>';
			//Motivo
			$salida.= '<td class = "text-center">CHEQUE</td>';
			//Beneficiario
			$quien = utf8_decode($row["che_quien"]);
			$concepto = utf8_decode($row["che_concepto"]);
			$salida.= '<td class = "text-justify">('.$quien.') '.$concepto.'</td>';
			//No. de Cheque
			$doc = utf8_decode($row["che_ncheque"]);
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			///monto
			$cant = $row["che_monto"];
			$sale = number_format($cant,2,'.',',');
			$saldoProyect -=  $cant;
			$saldoProyect = number_format($saldoProyect,2,'.',',');
			$Tsale += $cant;
			$CheqCircula += $cant;
			$salida.= '<td class = "text-center"></td>';
			$salida.= '<td class = "text-center">'.$sale.'</td>';
			$salida.= '<td class = "text-center">'.$saldoProyect.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
	}
			//--
			$saldoProyect = ($saldo - $CheqCircula);
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "7" class = "text-right"> <b>TOTAL INGRESOS</b></td>';
			$Tentra = number_format($Tentra, 2, '.', ',');
			$salida.= '<td class = "text-center"><b>'.$mons.'. '.$Tentra.'</b>';
			$salida.= '<td class = "text-center" colspan = "4" ></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "7" class = "text-right"> <b>TOTAL EGRESOS</b></td>';
			$salida.= '<td class = "text-center" ></td>';
			$Tsale = number_format($Tsale, 2, '.', ',');
			$salida.= '<td class = "text-center"><b>'.$mons.'. '.$Tsale.'</b>';
			$salida.= '<td class = "text-center" ></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "7" class = "text-right"> <b>SALDO REAL</b></td>';
			$salida.= '<td class = "text-center" colspan = "2" ></td>';
			$saldo = number_format($saldo, 2, '.', ',');
			$salida.= '<td class = "text-center"><b class = "text-success">'.$mons.'. '.$saldo.'</b>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "7" class = "text-right"> <b>CHEQUES EN CIRCULACI&Oacute;N</b></td>';
			$salida.= '<td class = "text-center" ></td>';
			$CheqCircula = number_format($CheqCircula, 2, '.', ',');
			$salida.= '<td class = "text-center"><b>'.$mons.'. '.$CheqCircula.'</b>';
			$salida.= '<td class = "text-center" ></td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "7" class = "text-right"> <b>SALDO PROYECTADO</b></td>';
			$salida.= '<td class = "text-center" colspan = "2" ></td>';
			$saldoProyect = number_format($saldoProyect, 2, '.', ',');
			$salida.= '<td class = "text-center"><b class = "text-success">'.$mons.'. '.$saldoProyect.'</b>';
			$salida.= '</tr>';
			//----
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}


//////////////---- Cheques -----------------////////////

function tabla_cheques($cod,$cue,$ban,$num,$quien,$fini,$ffin,$sit){
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_cheque($cod,$cue,$ban,$num,$quien,$fini,$ffin,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px"></th>';
			$salida.= '<th class = "text-center" width = "80px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "70px"># CHEQUE</th>';
			$salida.= '<th class = "text-center" width = "90px"># CUENTA</th>';
			$salida.= '<th class = "text-center" width = "130px">BANCO</th>';
			$salida.= '<th class = "text-center" width = "80px">MONTO</th>';
			$salida.= '<th class = "text-center" width = "90px">FECHA</th>';
			$salida.= '<th class = "text-center" width = "90px">QUIEN</th>';
			$salida.= '<th class = "text-center" width = "200px">CONCEPTO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$cod = $row["che_codigo"];
			$cue = $row["cueb_codigo"];
			$ban = $row["ban_codigo"];
			$sit = $row["che_situacion"];
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsBan->encrypt($cod, $usu);
			$hashkey2 = $ClsBan->encrypt($cue, $usu);
			$hashkey3 = $ClsBan->encrypt($ban, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-default btn-xs" href = "CPREPORTES/REPcheque.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'" target = "_blank" title = "Imprimir Cheque" ><span class="fa fa-print"></span></a> ';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-center" >';
				
			if($sit == 1){
				$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="xajax_Buscar_Cheque('.$cod.','.$cue.','.$ban.')" title = "Editar Cheque" ><span class="fa fa-edit"></span></button> ';
				$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Deshabilita_Cheque('.$cod.','.$cue.','.$ban.')" title = "Deshabilitar Cheque" ><span class="fa fa-trash-o"></span></button> ';
			}else if($sit == 0){
				$salida.= '<span class="fa fa-times text-danger"></span> <label class = "text-danger">Anulado</label> ';
			}else if($sit == 2){
				$salida.= '<span class="fa fa-check text-info"></span> <label class = "text-info">Pagado</label> ';
			}
			$salida.= '</td>';
			//numero de cheque
			$numche = $row["che_ncheque"];
			$salida.= '<td class = "text-center">'.$numche.'</td>';
			$salida.= '<input type = "hidden" name = "Tcod'.$i.'" id = "Tcod'.$i.'" value = "'.$cod.'"/>';
			$salida.= '<input type = "hidden" name = "Tcue'.$i.'" id = "Tcue'.$i.'" value = "'.$cue.'"/>';
			$salida.= '<input type = "hidden" name = "Tban'.$i.'" id = "Tban'.$i.'" value = "'.$ban.'"/>';
			$salida.= '<input type = "hidden" name = "Tnum'.$i.'" id = "Tnum'.$i.'" value = "'.$numche.'"/>';
			$salida.= '</td>';
			//numero de cuenta
			$numcue = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center">'.$numcue.'</td>';
			//banco
			$bann = utf8_decode($row["ban_desc_ct"]);
			$salida.= '<td class = "text-center">'.$bann.'</td>';
			//monto
			$mons = $row["mon_simbolo"];
			$monto = number_format($row["che_monto"],2, '.', '');
			$dinero = $row["che_monto"];
			$salida.= '<td class = "text-center">'.$mons.'. '.$monto;
			$salida.= '<input type = "hidden" name = "Tmonto'.$i.'" id = "Tmonto'.$i.'" value = "'.$dinero.'"/>';
			$salida.= '</td>';
			//fecha
			$fec = $row["che_fechor"];
			$fec = $ClsBan->cambia_fechaHora($fec);
			$salida.= '<td class = "text-center">'.$fec.'</td>';
			//quien
			$quien = utf8_decode($row["che_quien"]);
			$salida.= '<td class = "text-center">'.$quien.'</td>';
			//concepto
			$concepto = utf8_decode($row["che_concepto"]);
			$salida.= '<td class = "text-center">'.$concepto;
			$salida.= '<input type = "hidden" name = "Tconcepto'.$i.'" id = "Tconcepto'.$i.'" value = "('.$quien.') '.$concepto.'"/>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		//$salida.= "$cod,$cue,$ban,$num,$quien,$fini,$ffin,$sit";
	}
	
	return $salida;
}


function tabla_historial_cheques($cod,$cue,$ban,$num,$quien,$fini,$ffin,$sit){
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_cheque($cod,$cue,$ban,$num,$quien,$fini,$ffin,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "30px">SIT.</th>';
			$salida.= '<th class = "text-center" width = "70px"># CHEQUE</th>';
			$salida.= '<th class = "text-center" width = "90px"># CUENTA</th>';
			$salida.= '<th class = "text-center" width = "130px">BANCO</th>';
			$salida.= '<th class = "text-center" width = "80px">MONTO</th>';
			$salida.= '<th class = "text-center" width = "90px">FECHA</th>';
			$salida.= '<th class = "text-center" width = "90px">QUIEN</th>';
			$salida.= '<th class = "text-center" width = "200px">CONCEPTO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$cod = $row["che_codigo"];
			$cue = $row["cueb_codigo"];
			$ban = $row["ban_codigo"];
			$sit = $row["che_situacion"];
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsBan->encrypt($cod, $usu);
			$hashkey2 = $ClsBan->encrypt($cue, $usu);
			$hashkey3 = $ClsBan->encrypt($ban, $usu);
			//--
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-default btn-xs" href = "CPREPORTES/REPcheque.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'" target = "_blank" title = "Imprimir Cheque" ><span class="fa fa-print"></span></a> ';
			$salida.= '</td>';
			//Situacion
			switch($sit){
				case 1: $color = "info"; $title = "En Circulaci&oacute;n"; $icon = "fa-circle-o"; break;
				case 2: $color = "success"; $title = "Cheque Pagado"; $icon = "fa-check"; break;
				case 0: $color = "danger"; $title = "Anulado"; $icon = "fa-minus"; break;
			}
			$salida.= '<td class = "text-center font-12 '.$color.'" >'.$i.'. <span class="fa '.$icon.'" title = "'.$title.'"></span></td>';
			//numero de cheque
			$numche = $row["che_ncheque"];
			$salida.= '<td class = "text-center">'.$numche.'</td>';
			$salida.= '<input type = "hidden" name = "Tcod'.$i.'" id = "Tcod'.$i.'" value = "'.$cod.'"/>';
			$salida.= '<input type = "hidden" name = "Tcue'.$i.'" id = "Tcue'.$i.'" value = "'.$cue.'"/>';
			$salida.= '<input type = "hidden" name = "Tban'.$i.'" id = "Tban'.$i.'" value = "'.$ban.'"/>';
			$salida.= '<input type = "hidden" name = "Tnum'.$i.'" id = "Tnum'.$i.'" value = "'.$numche.'"/>';
			$salida.= '</td>';
			//numero de cuenta
			$numcue = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center">'.$numcue.'</td>';
			//banco
			$bann = utf8_decode($row["ban_desc_ct"]);
			$salida.= '<td class = "text-center">'.$bann.'</td>';
			//monto
			$mons = $row["mon_simbolo"];
			$monto = number_format($row["che_monto"],2, '.', '');
			$dinero = $row["che_monto"];
			$salida.= '<td class = "text-center">'.$mons.'. '.$monto;
			$salida.= '<input type = "hidden" name = "Tmonto'.$i.'" id = "Tmonto'.$i.'" value = "'.$dinero.'"/>';
			$salida.= '</td>';
			//fecha
			$fec = $row["che_fechor"];
			$fec = $ClsBan->cambia_fechaHora($fec);
			$salida.= '<td class = "text-center">'.$fec.'</td>';
			//quien
			$quien = utf8_decode($row["che_quien"]);
			$salida.= '<td class = "text-center">'.$quien.'</td>';
			//concepto
			$concepto = utf8_decode($row["che_concepto"]);
			$salida.= '<td class = "text-center">'.$concepto;
			$salida.= '<input type = "hidden" name = "Tconcepto'.$i.'" id = "Tconcepto'.$i.'" value = "('.$quien.') '.$concepto.'"/>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		//$salida.= "$cod,$cue,$ban,$num,$quien,$fini,$ffin,$sit";
	}
	
	return $salida;
}



function tabla_ejecuta_cheques($cod,$cue,$ban,$num,$quien,$fini,$ffin,$sit){
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_cheque($cod,$cue,$ban,$num,$quien,$fini,$ffin,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "40px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "70px"># CHEQUE</th>';
			$salida.= '<th class = "text-center" width = "90px"># CUENTA</th>';
			$salida.= '<th class = "text-center" width = "130px">BANCO</th>';
			$salida.= '<th class = "text-center" width = "80px">MONTO</th>';
			$salida.= '<th class = "text-center" width = "90px">FECHA</th>';
			$salida.= '<th class = "text-center" width = "90px">QUIEN</th>';
			$salida.= '<th class = "text-center" width = "200px">CONCEPTO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$cod = $row["che_codigo"];
			$cue = $row["cueb_codigo"];
			$ban = $row["ban_codigo"];
			$sit = $row["che_situacion"];
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsBan->encrypt($cod, $usu);
			$hashkey2 = $ClsBan->encrypt($cue, $usu);
			$hashkey3 = $ClsBan->encrypt($ban, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-default btn-xs" href = "CPREPORTES/REPcheque.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'" target = "_blank" title = "Imprimir Cheque" ><span class="fa fa-print"></span></a> ';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="Confirma_Ejecutar_Cheque('.$i.');" title = "Ejecutar Monto del Cheque" ><span class="fa fa-check"></span></button>';
			$salida.= '</td>';
			//numero de cheque
			$numche = $row["che_ncheque"];
			$salida.= '<td class = "text-center">'.$numche.'</td>';
			$salida.= '<input type = "hidden" name = "Tcod'.$i.'" id = "Tcod'.$i.'" value = "'.$cod.'"/>';
			$salida.= '<input type = "hidden" name = "Tcue'.$i.'" id = "Tcue'.$i.'" value = "'.$cue.'"/>';
			$salida.= '<input type = "hidden" name = "Tban'.$i.'" id = "Tban'.$i.'" value = "'.$ban.'"/>';
			$salida.= '<input type = "hidden" name = "Tnum'.$i.'" id = "Tnum'.$i.'" value = "'.$numche.'"/>';
			$salida.= '</td>';
			//numero de cuenta
			$numcue = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center">'.$numcue.'</td>';
			//banco
			$bann = utf8_decode($row["ban_desc_ct"]);
			$salida.= '<td class = "text-center">'.$bann.'</td>';
			//monto
			$mons = $row["mon_simbolo"];
			$monto = number_format($row["che_monto"],2, '.', '');
			$dinero = $row["che_monto"];
			$salida.= '<td class = "text-center">'.$mons.'. '.$monto;
			$salida.= '<input type = "hidden" name = "Tmonto'.$i.'" id = "Tmonto'.$i.'" value = "'.$dinero.'"/>';
			$salida.= '</td>';
			//fecha
			$fec = $row["che_fechor"];
			$fec = $ClsBan->cambia_fechaHora($fec);
			$salida.= '<td class = "text-center">'.$fec.'</td>';
			//quien
			$quien = utf8_decode($row["che_quien"]);
			$salida.= '<td class = "text-center">'.$quien.'</td>';
			//concepto
			$concepto = utf8_decode($row["che_concepto"]);
			$salida.= '<td class = "text-center">'.$concepto;
			$salida.= '<input type = "hidden" name = "Tconcepto'.$i.'" id = "Tconcepto'.$i.'" value = "('.$quien.') '.$concepto.'"/>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		//$salida.= "$cod,$cue,$ban,$num,$quien,$fini,$ffin,$sit";
	}
	
	return $salida;
}


//echo tabla_articulos($cod,$banp,$nom,$desc,$marca,$sit);

/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Tablas de Reportes ///////////////////////////////////////////////


//echo tabla_movimientos(1,1,"30/05/2013","30/07/2013");

?>
