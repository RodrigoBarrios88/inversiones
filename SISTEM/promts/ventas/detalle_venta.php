<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$gremial = $_SESSION["gremial"];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$venta = $_REQUEST["venta"];
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label>Detalle de Venta</label></div>
			<div class="panel-body">
				<?php echo tabla_detalle_venta($venta); ?>
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

function tabla_detalle_venta($vent){
	$ClsVent = new ClsVenta();
	$result = $ClsVent->get_det_venta('',$vent);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-promt" style = "width: 100%">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<td class = "text-center"  width = "30px"><b>No.</b></td>';
		$salida.= '<td class = "text-center"  width = "75px"><b>Cant.</b></td>';
		$salida.= '<td class = "text-center"  width = "300px"><b>Descipci&oacute;nn</b></td>';
		$salida.= '<td class = "text-center"  width = "65px"><b>P. Unitario</b></td>';
		$salida.= '<td class = "text-center"  width = "65px"><b>Descuento</b></td>';
		$salida.= '<td class = "text-center"  width = "65px"><b>C * P</b></td>';
		$salida.= '<td class = "text-center"  width = "65px"><b>T/C</b></td>';
		$salida.= '<td class = "text-center"  width = "65px"><b>P. Total</b></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$Total = 0;
		$Rtotal = 0;
		$i = 1;	
		foreach($result as $row){
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Cantidad
			$cant = $row["dven_cantidad"];
			$salida.= '<td class = "text-center" >'.$cant.'</td>';
			//Descripcion o Articulo
			$desc = utf8_decode($row["dven_detalle"]);
			$salida.= '<td class = "text-center" align = "left">'.$desc.'</td>';
			//Precio U.
			$pre = $row["dven_precio"];
			$mons = $row["mon_simbolo"];
			$Vmons = $row["mon_simbolo_venta"];
			$salida.= '<td class = "text-center" >'.$mons.'. '.$pre.'</td>';
			//Descuento
			$dsc = $row["dven_descuento"];
			$salida.= '<td class = "text-center" >'.$mons.'. '.$dsc.'</td>';
			//sub Total
			$monc = $row["dven_tcambio"];
			$Vmonc = $row["ven_tcambio"];
			$rtot = $row["dven_total"];
			$stot = $row["dven_subtotal"];
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$Total+= $Dcambiar;
			$Rcambiar = Cambio_Moneda($monc,$Vmonc,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = number_format($stot, 2, '.', '');
			$salida.= '<td class = "text-center" >'.$mons.' '.$rtot.'</td>';
			//---
			$salida.= '<td class = "text-center" >'.$monc.' x 1</td>';
			//---
			$salida.= '<td class = "text-center" >'.$Vmons.' '.$Rcambiar.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
			//----
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		$salida.= '<div class = "row">';
		$salida.= '<div class="col-xs-10 col-xs-offset-1 text-center">';
		$salida.= '<h5 class = "alert alert-info text center"><i class = "fa fa-info-circle"></i> No hay ventas registradas con estos criterios de busqueda, revise la fecha u otro criterio para concretar....</h5>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	return $salida;
}

?>