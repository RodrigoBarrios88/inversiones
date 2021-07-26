<?php 
include_once('../../html_fns.php');

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
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
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
			$ingresos = $row["ingresos"];
			$egresos = $row["egresos"];
			$tcamb = $row["mon_cambio"];
			$saldo = ($ingresos - $egresos);
			$saldo = round($saldo,2);
			$cambio = Cambio_Moneda($tcamb,$oftCamb,$saldo);
			$cambio = number_format($cambio,2, '.', '');
			$total += $cambio;
			if($saldo >0){
				//No.
				$salida.= '<td class = "text-center">'.$i.'.</td>';
				//Moneda
				$salida.= '<td class = "text-center" align = "left">'.$moneda.'</td>';
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
			$salida.= '<td class = "text-center" colspan = "4" align = "right"><b>TOTAL</b></td>';
			$salida.= '<td class = "text-center"><b>'.$oftSimb.'. '.$total.'</b></td>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

?>
