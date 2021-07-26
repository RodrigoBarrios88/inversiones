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
		<div class="panel panel-success">
			<div class="panel-heading text-center"><h4>Lado 2</h4></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12" id = "result">
						<?php
							echo tabla_tarjeta_atras_suministro($art,$gru,$suc);
						?>
					</div>
				</div>
			</div>
	    </div>
	</body>
</html>
<?php

function tabla_tarjeta_atras_suministro($art,$grup,$suc){  //////KARDEX LADO B
	$ClsArt = new ClsArticulo();
	$result = $ClsArt->get_lote('',$grup,$art,'',$suc);
	
	if(is_array($result)){
			$salida.= '<table class = "table table-bordered" style = "font-size:10px;">';
		$i = 1;
		$saldo = 0;	
		$prectot = 0;	
		foreach($result as $row){
			if($i == 1){
				//Empresa
				$salida.= '<tr>';
				$sucn = utf8_decode($row["suc_nombre"]);
				$salida.= '<td class = "text-center success" colspan = "9"><b>EMPRESA:</b> '.$sucn.'</td>';
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
				$salida.= '<td class = "text-center" colspan = "4"><b>ARTICULO:</b> '.$artn.'</td>';
				$salida.= '<td class = "text-center" colspan = "3"><b>MARCA:</b> '.$marc.'</td>';
				$salida.= '</tr>';
				//--
				$salida.= '<tr>';
				$salida.= '<td class = "text-center" colspan = "2"><b>CODIGO:</b> '.$artc.'A'.$gruc.'</td>';
				$salida.= '<td class = "text-center" colspan = "4"><b>CODIGO INT.:</b> '.$barc.'</td>';
				$salida.= '<td class = "text-center" colspan = "3"><b>U. DE MEDIDA:</b> '.$umed.'</td>';
				$salida.= '</tr>';
				///---
				$salida.= '<tr>';
				$salida.= '<td class = "text-center" colspan = "9"><br></td>';
				$salida.= '</tr>';
				$salida.= '<tr>';
				$salida.= '<td class = "text-center success" colspan = "9"><b>LOTES Y EXISTENCIAS</b></td>';
				$salida.= '</tr>';
				///---
				$salida.= '<tr>';
				$salida.= '<td class = "text-center" ><b>LOTE</b></td>';
				$salida.= '<td class = "text-center" ><b>FECHA INGRESO</b></td>';
				$salida.= '<td class = "text-center" ><b>EXISTENCIA</b></td>';
				$salida.= '<td class = "text-center" ><b>NIT</b></td>';
				$salida.= '<td class = "text-center" ><b>PROVEEDOR</b></td>';
				$salida.= '<td class = "text-center" ><b>PREC. MARGEN</b></td>';
				$salida.= '<td class = "text-center" ><b>PREC. COSTO</b></td>';
				$salida.= '<td class = "text-center" ><b>PREC. FINAL</b></td>';
				$salida.= '<td class = "text-center" ><b>MONEDA</b></td>';
				$salida.= '</tr>';
			}
			$salida.= '<tr>';
			//lote
			$lc = $row["lot_codigo"];
			$lc = Agrega_Ceros($lc);
			$ac = $row["lot_articulo"];
			$ac = Agrega_Ceros($ac);
			$gc = $row["lot_grupo"];
			$gc = Agrega_Ceros($gc);
			$lote = $lc."A".$ac."A".$gc;
			$salida.= '<td class = "text-center" >'.$lote.'</td>';
			//fecha
			$fec = $row["lot_fecha_in"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//Existencia
			$cant = trim($row["lot_cantidad"]);
			$salida.= '<td class = "text-center" >'.$cant.'</td>';
			//NIT
			$Pnit = trim($row["prov_nit"]);
			$salida.= '<td class = "text-center">'.$Pnit.'</td>';
			//PROVEEDOR
			$Pnom = utf8_decode($row["prov_nombre"]);
			$salida.= '<td class = "text-center">'.$Pnom.'</td>';
			//precios
			$mons = $row["mon_simbolo"];
			$prem = $row["lot_precio_manufactura"];
			$prec = $row["lot_precio_costo"];
			$prev = $row["art_precio"];
			$prectot += $prec;
			$mon = $row["mon_desc"];
			$salida.= '<td class = "text-center" >'.$mons.'. '.$prem.'</td>';
			$salida.= '<td class = "text-center" >'.$mons.'. '.$prec.'</td>';
			$salida.= '<td class = "text-center" >'.$mons.'. '.$prev.'</td>';
			$salida.= '<td class = "text-center" >'.$mon.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			//PRECIO de COSTO PROMEDIO
			$i--;
			$precprom = ($prectot/$i);
			$precprom = round($precprom, 2);
			$salida.= '<tr class="success">';
			$salida.= '<td class = "text-center" colspan = "2"></td>';
			$salida.= '<td class = "text-center" colspan = "3"><b>PRECIO DE COSTO PROMEDIO:</b></td>';
			$salida.= '<td class = "text-center" >'.$mons.'. '.$precprom.'</td>';
			$salida.= '<td class = "text-center" colspan = "3" >'.$mon.'</td>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '<br>';
	}
	
	return $salida;
}

?>