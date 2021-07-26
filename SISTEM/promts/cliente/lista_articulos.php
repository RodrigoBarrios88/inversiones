<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//-- $_POST
	$codigo = $_REQUEST["codigo"];
	//-- Hashkey
	$ClsCli = new ClsCliente();
	$usucod = $_SESSION["codigo"];
	$hashkey = $ClsCli->encrypt($codigo, $usucod);
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
					<h5 class="text-muted"><u>Listado de articulos que este Cliente ha adquirido</u></h5>
				</div>
				<div class="col-xs-3 text-right">
					<a class="btn btn-default" href= "FRMarticulos.php?hashkey=<?php echo $hashkey; ?>" target="_blank"><i class="fa fa-print fa-2x"></i></a>
				</div>
			</div>
			<div class="row">
				<?php echo tabla_lista_articulos($codigo); ?>
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

function tabla_lista_articulos($cliente){
	$ClsVen = new ClsVenta();
	$result = $ClsVen->get_productos_cliente('',$cliente,'');
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example2">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "20px">CODIGO</th>';
			$salida.= '<th class = "text-center" width = "160px">DESCRIPCI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "60px">CANT./PROM.</th>';
			$salida.= '<th class = "text-center" width = "60px">ITERACIONES</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$art = $row["dven_articulo"];
			$gru = $row["dven_grupo"];
			$art = Agrega_Ceros($art);
			$gru = Agrega_Ceros($gru);
			$articulo = "A".$art."A".$gru;
			$salida.= '<td class = "text-center" >'.$articulo.'</td>';
			//descripcion del articulo
			$descripcion = utf8_decode($row["dven_detalle"]);
			$salida.= '<td class = "text-left">'.$descripcion.'</td>';
			//cantiad promedio
			$cant = round($row["dven_cantidad_promedio"],0);
			$salida.= '<td class = "text-center" >'.$cant.'</td>';
			//Iteraciones de compra
			$frec = $row["dven_frecuencia"];
			$salida.= '<td class = "text-center" >'.$frec.'</td>';
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