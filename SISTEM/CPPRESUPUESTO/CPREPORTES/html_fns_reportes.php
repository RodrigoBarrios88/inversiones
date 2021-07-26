<?php 
include_once('../../html_fns.php');

function rep_tabla_caja($cod,$suc,$mon,$sit){
	$ClsCaj = new ClsCaja();
	$cont = $ClsCaj->count_caja($cod,$suc,$mon,$sit);
	
	if($cont>0){
		$result = $ClsCaj->get_caja($cod,$suc,$mon,$sit);
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th width = "35px"></th>';
			$salida.= '<th width = "130px">EMPRESA</th>';
			$salida.= '<th width = "220px">DESCRIPCIÓN</th>';
			$salida.= '<th width = "90px">MONEDA</th>';
			$salida.= '<th width = "90px">SITUACIÓN</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["caja_situacion"];
			$sucn = $row["suc_nombre"];
			$desc = $row["caja_descripcion"];
			$salida.= '<td align = "center">'.$i.'. </td>';
			//empresa
			$salida.= '<td>'.$sucn.'</td>';
			//DESCRIPCION
			$salida.= '<td>'.$desc.'</td>';
			//moneda
			$mon = $row["mon_desc"];
			$salida.= '<td align = "center">'.$mon.'</td>';
			//situacion
			$sit = ($sit == 1)?"<b>ACTIVA</b>":"<b>INACTIVA</b>";
			$salida.= '<td align = "center" >'.$sit.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th align = "center" colspan = "7"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function rep_tabla_caja_saldo($cod,$suc,$mon){
	$ClsCaj = new ClsCaja();
	$cont = $ClsCaj->count_caja($cod,$suc,$mon,1);
	
	if($cont>0){
		$result = $ClsCaj->get_caja($cod,$suc,$mon,1);
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th width = "40px" >No.</th>';
			$salida.= '<th width = "90px"># CAJA</th>';
			$salida.= '<th width = "220px">DESCRIPCIÓN</th>';
			$salida.= '<th width = "130px">EMPRESA</th>';
			$salida.= '<th width = "70px">SALDO</th>';
			$salida.= '<th width = "90px">MONEDA</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$suc = $row["caja_sucursal"];
			$caja = $row["caja_codigo"];
			$salida.= '<td align = "center">'.$i.'. </td>';
			//numero de cuenta
			$num = Agrega_Ceros($caja)."-".Agrega_Ceros($suc);
			$salida.= '<td align = "center">'.$num.'</td>';
			//descripcion
			$desc = $row["caja_descripcion"];
			$salida.= '<td  class = "text-justify" >'.$desc.'</td>';
			//empresa
			$sucn = $row["suc_nombre"];
			$salida.= '<td>'.$sucn.'</td>';
			//saldo
			$mons = $row["mon_simbolo"];
			$saldo = $row["caja_saldo"];
			$salida.= '<td align = "center">'.$mons.'. '.$saldo.'</td>';
			//moneda
			$mon = $row["mon_desc"];
			$salida.= '<td align = "center">'.$mon.'</td>';
			$salida.= '</tr>';
			//--
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th align = "center" colspan = "6"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function rep_tabla_movimientos($caja,$suc,$fini,$ffin){
	$ClsCaj = new ClsCaja();
	$result = $ClsCaj->get_mov_caja("",$caja,$suc,'','','','',$fini,$ffin,1);
	
	if(is_array($result)){
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
			//----
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


//echo tabla_articulos($cod,$banp,$nom,$desc,$marca,$sit);

/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Tablas de Reportes ///////////////////////////////////////////////


//echo tabla_movimientos("",1,"30/05/2013","16/09/2013");

?>
