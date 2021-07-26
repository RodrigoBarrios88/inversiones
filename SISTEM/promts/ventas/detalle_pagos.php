<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$gremial = $_SESSION["gremial"];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$venta = $_REQUEST["venta"];
	
	$ClsVent = new ClsVenta();
	$result = $ClsVent->get_venta($venta);
	if(is_array($result)){
		foreach($result as $row){
			$factotal = trim($row["ven_total"]);
			$tcambio = $row["ven_tcambio"];
			$monsimbolo = $row["mon_simbolo"];
			$moneda = $row["mon_desc"];
		}	
	}	
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label><i class="fa fa-money"></i> Detalle de los Pagos</label></div>
			<div class="panel-body">
				<?php echo tabla_detalle_pagos($venta,$factotal,$tcambio,$monsimbolo,$moneda); ?>
				<hr>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-success" onclick = "cerrarModal();"><span class="fa fa-check"></span> Aceptar</button>
					</div>
				</div>
				<br>
			</div>		
		</div>
		<!-- Page-Level Demo Scripts - Tables - Use for reference -->
		<script>
			$(document).ready(function() {
				$('#dataTables-promt').DataTable({
					pageLength: 10,
					responsive: true
				});
			});
		</script>	
	</body>
</html>
<?php

function tabla_detalle_pagos($vent,$factotal,$tcambio,$monsimbolo,$moneda){
	$ClsPag = new ClsPago();
	$ClsMon = new ClsMoneda();
	$result = $ClsPag->get_pago_venta("",$vent);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-promt" style = "width: 100%;">';
		$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "70px">#TRANS.</th>';
			$salida.= '<th class = "text-center" width = "100px">FORMA PAG.</th>';
			$salida.= '<th class = "text-center" width = "110px">OP./BAN</th>';
			$salida.= '<th class = "text-center" width = "80px">DOC.</th>';
			$salida.= '<th class = "text-center" width = "120px">FECHA/HORA</th>';
			$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
			$salida.= '<th class = "text-center" width = "50px">T/C</th>';
			$salida.= '<th class = "text-center" width = "50px">M*TC</th>';
			$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		$montototal = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Codigo
			$cod = $row["pag_codigo"];
			$vent = $row["pag_venta"];
			$cod = Agrega_Ceros($cod);
			$vent = Agrega_Ceros($vent);
			$codigo = $cod."-".$vent;
			$salida.= '<td class = "text-center" >'.$codigo.'</td>';
			//FORMA de Pago
			$tpag = utf8_decode($row["tpago_desc_md"]);
			$salida.= '<td class = "text-center" >'.$tpag.'</td>';
			//Operador o Banco
			$opera = utf8_decode($row["pag_operador"]);
			$salida.= '<td class = "text-center" >'.$opera.'</td>';
			//Documento o Boucher
			$doc = utf8_decode($row["pag_doc"]);
			$salida.= '<td class = "text-center" >'.$doc.'</td>';
			//fecha hora
			$fec = $row["pag_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//monto
			$mont = $row["pag_monto"];
			$mons = $row["mon_simbolo"];
			$moncamb = $row["mon_cambio"];
			$monto = $mons.". ".number_format($mont,2,'.','');
			$salida.= '<td class = "text-center" >'.$monto.'</td>';
			//cambio
			$camb = $row["pag_tcambio"];
			$salida.= '<td class = "text-center" >'.$camb.' x 1</td>';
			//total
			$Dcambiar = Cambio_Moneda($moncamb,$tcambio,$mont);
			$montototal += $Dcambiar;
			$total = $monsimbolo.". ".number_format($Dcambiar,2,'.','');
			$salida.= '<td class = "text-center" >'.$total.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		//--
			$salida.= '<tr class = "info">';
			$salida.= '<th class = "text-center" width = "10px">'.$i.'.</th>';
			$salida.= '<th class = "text-center" width = "70px"></th>';
			$salida.= '<th class = "text-center" width = "100px"></th>';
			$salida.= '<th class = "text-center" width = "110px"></th>';
			$salida.= '<th class = "text-center" width = "80px"></th>';
			$salida.= '<th class = "text-center" width = "120px">PAGADO</th>';
			$salida.= '<th class = "text-center" width = "50px">'.$moneda.'</th>';
			$salida.= '<th class = "text-center" width = "50px">'.$tcambio.' x 1</th>';
			$salida.= '<th class = "text-center" width = "50px">'.$monsimbolo.'. '.number_format($montototal,2,'.',',').'</th>';
			$salida.= '</tr>';
			//--
			$i++;
			$saldo = $factotal - $montototal;
			$salida.= '<tr class = "warning">';
			$salida.= '<th class = "text-center" width = "10px">'.$i.'.</th>';
			$salida.= '<th class = "text-center" width = "70px"></th>';
			$salida.= '<th class = "text-center" width = "100px"></th>';
			$salida.= '<th class = "text-center" width = "110px"></th>';
			$salida.= '<th class = "text-center" width = "80px"></th>';
			$salida.= '<th class = "text-center" width = "120px">SALDO</th>';
			$salida.= '<th class = "text-center" width = "50px">'.$moneda.'</th>';
			$salida.= '<th class = "text-center" width = "50px">'.$tcambio.' x 1</th>';
			$salida.= '<th class = "text-center" width = "50px">'.$monsimbolo.'. '.number_format($saldo,2,'.',',').'</th>';
			$salida.= '</tr>';
		//----
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}

?>