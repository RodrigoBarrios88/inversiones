<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//-- $_POST
	$codigo = $_REQUEST["codigo"];
	//-- Hashkey
	$ClsProv = new ClsProveedor();
	$usucod = $_SESSION["codigo"];
	$hashkey = $ClsProv->encrypt($codigo, $usucod);
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 text-center">
					<h5 class="text-muted"><u>Historial de Compras a este Proveedor</u></h5>
				</div>
				<div class="col-xs-3 text-right">
					<a class="btn btn-default" href= "FRMhistorial.php?hashkey=<?php echo $hashkey; ?>" target="_blank"><i class="fa fa-print fa-2x"></i></a>
				</div>
			</div>
			<div class="row">
				<?php echo tabla_historial_compra($codigo); ?>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 text-center">
					<button type="button" class="btn btn-success" id = "limp" onclick = "cerrarModal();"><span class="fa fa-check"></span> Aceptar</button>
				</div>
			</div>
			<br>
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

function tabla_historial_compra($proveedor){
	$ClsComp = new ClsCompra();
	$result = $ClsComp->get_compra('','',$proveedor,'','','','','','');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example2">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "20px">SIT.</th>';
			$salida.= '<th class = "text-center" width = "60px">FECHA</th>';
			$salida.= '<th class = "text-center" width = "120px">TIPO</th>';
			$salida.= '<th class = "text-center" width = "70px">DOC. REF.</th>';
			$salida.= '<th class = "text-center" width = "100px">EMPRESA</th>';
			$salida.= '<th class = "text-center" width = "30px"></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$sit = $row["com_situacion"];
			$salida.= '<td class = "text-center" >';
			if($sit == 1 || $sit == 2){
				$salida.= '<i class = "fa fa-check fa-2x text-success" title = "Realizada"></i>';
			}else if($sit == 0){
				$salida.= '<i class = "fa fa-times fa-2x text-danger" title = "Anulada"></i>';
			}
			$salida.= '</td>';
			//--
			$fecha = cambia_fecha($row["com_fecha"]);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//tipo
			$tipo = ($row["com_tipo"] == "C")?"COMPRA":"GASTO";
			$salida.= '<td class = "text-center" >'.$tipo.'</td>';
			//referencia
			$ref = $row["com_doc"];
			$salida.= '<td class = "text-center" >'.$ref.'</td>';
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center" >'.$suc.'</td>';
			//codigo
			$cod = $row["com_codigo"];
			$usucod = $_SESSION["codigo"];
			$hashkey = $ClsComp->encrypt($cod, $usucod);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="text-success" target = "_blank" href = "FRMdetalle_historial.php?hashkey='.$hashkey.'" title = "Ver Detalle de Compra" ><span class="fa fa-paste fa-2x"></span></a> ';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

?>