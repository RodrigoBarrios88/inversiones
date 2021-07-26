<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	
	//- datos -
	$artc = $_REQUEST["artc"];
	$artn = $_REQUEST["artn"];
	$cant = $_REQUEST["cant"];
	$lot = $_REQUEST["lot"];
	$fila = $_REQUEST["fila"];
	//--
		$ClsArt = new ClsArticulo();
		$chunk = explode("A", $artc);
		$art = $chunk[0]; // articulo
		$gru = $chunk[1]; // grupo
		//valida que los espacios sean numericos
		$art = (is_numeric($art))?$art:0;
		$gru = (is_numeric($gru))?$gru:0;
		$cont = $ClsArt->count_articulo($art,$gru,'','','','','','',1);
		if($cont>0){
			$result = $ClsArt->get_articulo($art,$gru,'','','','','','',1);
			foreach($result as $row){
				$umed = $row["u_desc_lg"];
				$prev = $row["art_precio"];
				$prec = $row["art_precio_costo"];
				$prem = $row["art_precio_manufactura"];
			}
		}
	
	
	$lote = "LOTE EXISTENTE";
	$artcdesc = $artc;  
	$artndesc = $artn; 
	//-- pasa a decimales
	$prem = round($prem, 2);
	$prec = round($prec, 2);
	$prev = round($prev, 2);
	//-- Q.
	$prem = "Q. ".$prem;
	$prec = "Q. ".$prec;
	$prev = "Q. ".$prev;			
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label>Informaci&oacute;n de Descarga. Fila No. <?php echo $fila; ?></label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>C&oacute;digo de Lote: </label></div>
					<div class="col-xs-5"><label>Art&iacute;culo: </label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label class="text-info"><?php echo $artcdesc; ?></label></div>
					<div class="col-xs-5"><label class="text-info"><?php echo $artndesc; ?></label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Cantidad a Descargar: </label></div>
					<div class="col-xs-5"><label>Unidad de Medida: </label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label class="text-info"><?php echo $cant; ?></label></div>
					<div class="col-xs-5"><label class="text-info"><?php echo $umed; ?></label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Tipo de Lote: </label></div>
					<div class="col-xs-5"><label>Precio de Manufactura: </label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label class="text-info"><?php echo $lote; ?></label></div>
					<div class="col-xs-5"><label class="text-info"><?php echo $prem; ?></label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Precio de Costo: </label></div>
					<div class="col-xs-5"><label>Precio + Margen: </label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label class="text-info"><?php echo $perc; ?></label></div>
					<div class="col-xs-5"><label class="text-info"><?php echo $prev; ?></label></div>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-default" onclick = "cerrarModal();"><span class="fa fa-times"></span> Cerrar</button>
					</div>
				</div>
				<br>
			</div>
		</div>
	</body>
</html>
