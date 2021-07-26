<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$gremial = $_SESSION["gremial"];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$compra = $_REQUEST["compra"];
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label>Detalle de Compra</label> <a class="pull-right text-success" target="_blank" href="CPREPORTES/REPbarcode.php?comp=<?php echo $compra; ?>"><i class="fa fa-barcode fa-2x"></i> Etiquetas de C&oacute;digo de Barras</a></div>
			<div class="panel-body">
				<?php echo tabla_detalle_compra($compra); ?>
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

function tabla_detalle_compra($comp){
	$ClsComp = new ClsCompra();
	$result = $ClsComp->get_det_compra('',$comp);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-promt" style = "width: 100%">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<td class = "text-center"  width = "25px"><b>No.</b></td>';
		$salida.= '<td class = "text-center"  width = "60px"><b>Cant.</b></td>';
		$salida.= '<td class = "text-center"  width = "300px"><b>Descipci&oacute;n</b></td>';
		$salida.= '<td class = "text-center"  width = "60px"><b>P. Unitario</b></td>';
		$salida.= '<td class = "text-center"  width = "60px"><b>Descuento</b></td>';
		$salida.= '<td class = "text-center"  width = "60px"><b>C * P</b></td>';
		$salida.= '<td class = "text-center"  width = "60px"><b>T/C</b></td>';
		$salida.= '<td class = "text-center"  width = "60px"><b>P. Total</b></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$Total = 0;
		$Rtotal = 0;
		$i = 1;	
		foreach($result as $row){
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Cantidad
			$cant = $row["dcom_cantidad"];
			$salida.= '<td class = "text-center" >'.$cant.'</td>';
			//Descripcion o Articulo
			$desc = utf8_decode($row["dcom_detalle"]);
			$salida.= '<td class = "text-center" align = "left">'.$desc.'</td>';
			//Precio U.
			$pre = number_format($row["dcom_precio"],2,'.','');
			$mons = $row["mon_simbolo"];
			$Vmons = $row["mon_simbolo_compra"];
			$salida.= '<td class = "text-center" >'.$mons.'. '.$pre.'</td>';
			//Descuento
			$dsc = number_format($row["dcom_descuento"],2,'.','');
			$salida.= '<td class = "text-center" >'.$mons.'. '.$dsc.'</td>';
			//sub Total
			$monc = $row["dcom_tcambio"];
			$Vmonc = $row["com_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$Total+= $Dcambiar;
			$Rcambiar = Cambio_Moneda($monc,$Vmonc,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = number_format($stot, 2, '.', '');
			$salida.= '<td class = "text-center" >'.$mons.' '.$stot.'</td>';
			//---
			$salida.= '<td class = "text-center" >'.$monc.' x 1</td>';
			//---
			$salida.= '<td class = "text-center" >'.$Vmons.' '.number_format($Dcambiar,2,'.','').'</td>';
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
		$salida.= '<h5 class = "alert alert-info text center"><i class = "fa fa-info-circle"></i> No hay compras registradas con estos criterios de busqueda, revise la fecha u otro criterio para concretar....</h5>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}

?>