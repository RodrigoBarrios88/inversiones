<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//_$POST
	$inv = $_REQUEST["inventario"];
	$tipo = $_REQUEST["tipo"];
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label>Detalle del Movimiento a Inventario</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12">
						<?php echo tabla_detalle_historial_inventario_suministro("",$inv,$tipo); ?>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-default" onclick = "cerrarModal();"><span class="fa fa-times"></span> Cerrar</button>
					</div>
				</div>
				<br>
			</div>
		</div>	
		<!-- Page-Level Demo Scripts - Tables - Use for reference -->
		<script>
			$(document).ready(function() {
				$('#dataTables-example2').DataTable({
					responsive: true
				});
			});
		</script>	
	</body>
</html>

<?php

function tabla_detalle_historial_inventario_suministro($cod,$inv,$tipo){  ///////KARDEX LADO A
	$ClsInv = new ClsInventarioSuministro();
	$result = $ClsInv->get_det_inventario($cod,$inv,$tipo);
	
	if(is_array($result)){
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example2">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px" >No.</th>';
			$salida.= '<th class = "text-center" width = "100px" ># TRANS.</th>';
			$salida.= '<th class = "text-center" width = "120px" >No. LOTE</th>';
			$salida.= '<th class = "text-center" width = "150px" >PROVEEDOR</th>';
			$salida.= '<th class = "text-center" width = "250px" >ARTICULO</th>';
			$salida.= '<th class = "text-center" width = "60px" >CANTIDAD</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Codigo
			$cod = $row["det_codigo"];
			$inv = $row["det_inventario"];
			$tip = $row["det_tipo"];
			$cod = Agrega_Ceros($cod);
			$inv = Agrega_Ceros($inv);
			$tip = Agrega_Ceros($tip);
			$codigo = $cod."-".$inv."-".$tip;
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//Lote
			$lot = $row["lot_codigo"];
			$art = $row["art_codigo"];
			$gru = $row["gru_codigo"];
			$lot = Agrega_Ceros($lot);
			$art = Agrega_Ceros($art);
			$gru = Agrega_Ceros($gru);
			$codigo = $lot."A".$art."A".$gru;
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//Proveedor
			$prov = utf8_decode($row["prov_nombre"]);
			$salida.= '<td class = "text-center">'.$prov.'</td>';
			//Articulo
			$art = utf8_decode($row["art_nombre"]);
			$salida.= '<td class = "text-center">'.$art.'</td>';
			//Cantidad
			$cant = $row["det_cantidad"];
			$salida.= '<td class = "text-center">'.$cant.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


?>