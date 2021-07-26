<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//_$POST
	$suc = $_REQUEST["empCodigo"];
	$gru = $_REQUEST["grupo"];
	$art = $_REQUEST["articulo"];
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-primary">
			<div class="panel-heading text-center"><h5>Lado 1</h5></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12" id = "result">
						<?php
							echo tabla_tarjeta_frente_suministro($art,$gru,$suc);
						?>
					</div>
				</div>
			</div>
	    </div>
	</body>
</html>

<?php

function tabla_tarjeta_frente_suministro($art,$grup,$suc){ //////KARDEX LADO B
	$ClsInv = new ClsInventario();
	$result = $ClsInv->get_det_inventario_kardex($art,$grup,$suc);
	
	if(is_array($result)){
			$salida.= '<table class = "table table-bordered" style = "font-size:10px;">';
		$i = 1;
		$saldo = 0;	
		foreach($result as $row){
			if($i == 1){
				//Empresa
				$salida.= '<tr>';
				$sucn = utf8_decode($row["suc_nombre"]);
				$salida.= '<td class = "text-center info" colspan = "8"><b>EMPRESA:</b> '.$sucn.'</td>';
				$salida.= '</tr>';
				//grupo
				$salida.= '<tr>';
				$grun = utf8_decode($row["gru_nombre"]);
				$gruc = $row["gru_codigo"];
				$gruc = Agrega_Ceros($gruc);
				$salida.= '<td class = "text-center" colspan = "2"><b>GRUPO:</b> '.$grun.'</td>';
				$artc = $row["art_codigo"];
				$artc = Agrega_Ceros($artc);
				$artn = utf8_decode($row["art_nombre"]);
				$marc = utf8_decode($row["art_marca"]);
				$barc = $row["art_barcode"];
				$barc = ($barc != "")?$barc:"N/A";
				$umed = $row["u_desc_lg"];
				$salida.= '<td class = "text-center" colspan = "2"><b>ARTICULO:</b> '.$artn.'</td>';
				$salida.= '<td class = "text-center" colspan = "4"><b>MARCA:</b> '.$marc.'</td>';
				$salida.= '</tr>';
				//--
				$salida.= '<tr>';
				$salida.= '<td class = "text-center" colspan = "2"><b>CODIGO:</b> '.$artc.'A'.$gruc.'</td>';
				$salida.= '<td class = "text-center" colspan = "2"><b>CODIGO INT.:</b> '.$barc.'</td>';
				$salida.= '<td class = "text-center" colspan = "4"><b>U. MEDIDA:</b> '.$umed.'</td>';
				$salida.= '</tr>';
				///---
				$salida.= '<tr>';
				$salida.= '<td class = "text-center" colspan = "8"><br></td>';
				$salida.= '</tr>';
				///---
				$salida.= '<tr class = "info">';
				$salida.= '<td class = "text-center" ><b>TRANSACCI&Oacute;N</b></td>';
				$salida.= '<td class = "text-center" ><b>LOTE</b></td>';
				$salida.= '<td class = "text-center" ><b>FECHA</b></td>';
				$salida.= '<td class = "text-center" ><b>DETALLE</b></td>';
				$salida.= '<td class = "text-center" ><b>ENTR&Oacute;</b></td>';
				$salida.= '<td class = "text-center" ><b>SALI&Oacute;</b></td>';
				$salida.= '<td class = "text-center" ><b>SALDO</b></td>';
				$salida.= '<td class = "text-center" ><b>USUARIO</b></td>';
				$salida.= '</tr>';
			}
			$salida.= '<tr>';
			//transaccion
			$inv = $row["inv_codigo"];
			$inv = Agrega_Ceros($inv);
			$dinv = $row["det_codigo"];
			$dinv = Agrega_Ceros($dinv);
			$trans = "$inv-$dinv";
			$salida.= '<td class = "text-center" >'.$trans.'</td>';
			//transaccion
			$lc = $row["lot_codigo"];
			$lc = Agrega_Ceros($lc);
			$ac = $row["lot_articulo"];
			$ac = Agrega_Ceros($ac);
			$gc = $row["lot_grupo"];
			$gc = Agrega_Ceros($gc);
			$lote = $lc."A".$ac."A".$gc;
			$salida.= '<td class = "text-center" >'.$lote.'</td>';
			//fecha
			$fec = $row["inv_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//detalle
			$clase = trim($row["inv_clase"]);
			switch($clase){
				case "C": $det = "COMPRA"; break;
				case "P": $det = "PRODUCCI&Oacute;N"; break;
				case "D": $det = "DONACI&Oacute;N"; break;
				case "D2": $det = "DESCARGA POR RECHAZO"; break;
				case "C2": $det = "A CONSIGNACI&Oacute;N"; break;
				case "C3": $det = "REGRESO CONSIG."; break;
			}
			$doc = $row["inv_documento"];
			$detalle = "$det REF. DOC: $doc";
			$salida.= '<td class = "text-center">'.$detalle.'</td>';
			//cantidades
			$tipo = $row["det_tipo"];
			$cant = $row["det_cantidad"];
			if($tipo == 1){
				$entra = $cant;
				$sale = "";
				$saldo += $entra;
			}else if($tipo == 2){
				$entra = "";
				$sale = $cant;
				$saldo -=  $sale;
			}
			$salida.= '<td class = "text-center" >'.$entra.'</td>';
			$salida.= '<td class = "text-center" >'.$sale.'</td>';
			$salida.= '<td class = "text-center" >'.$saldo.'</td>';
			//usuario
			$usu = $row["inv_quien"];
			$usu = Agrega_Ceros($usu);
			$salida.= '<td class = "text-center" >COD: '.$usu.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			//SAlDO FINAL
			$salida.= '<tr class = "info">';
			$salida.= '<td class = "text-center" colspan = "4"></td>';
			$salida.= '<td class = "text-center" colspan = "2"><b>SALDO TOTAL:</b></td>';
			$salida.= '<td class = "text-center" >'.$saldo.'</td>';
			$salida.= '<td class = "text-center" ></td>';
			$salida.= '</tr>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '<br>';
	}
	
	return $salida;
}


?>
