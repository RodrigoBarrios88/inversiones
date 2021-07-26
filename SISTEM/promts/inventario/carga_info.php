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
	$pronom = $_REQUEST["pronom"];
	$pronit = $_REQUEST["pronit"];
	$prem = $_REQUEST["prem"];
	$prec = $_REQUEST["prec"];
	$prev = $_REQUEST["prev"];
	$fila = $_REQUEST["fila"];
	
	$artcdesc = $artc;
	$artndesc = $artn;
	$arttit = "C&oacute;digo de Articulo:";
	
	
		$ClsArt = new ClsArticulo();
		$chunk = explode("A", $artc);
		$lot = $chunk[0]; // lote
		$art = $chunk[1]; // articulo
		$gru = $chunk[2]; // grupo
		//valida que los espacios sean numericos
		$lot = (is_numeric($lot))?$lot:0;
		$art = (is_numeric($art))?$art:0;
		$gru = (is_numeric($gru))?$gru:0;
				
	//--
	$prem = ($prem != "")? $prem: "-";
	$prec = ($prec != "")? $prec: "-";
	$prev = ($prev != "")? $prev: "-";
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
			<div class="panel-heading"><label>Informaci&oacute;n de Carga Fila No. <?php echo $fila; ?></label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>NIT: </label></div>
					<div class="col-xs-5"><label>Proveedor: </label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label class="text-info"><?php echo $pronit; ?></label></div>
					<div class="col-xs-5"><label class="text-info"><?php echo $pronom; ?></label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label><?php echo $arttit; ?> </label></div>
					<div class="col-xs-5"><label>Art&iacute;culo: </label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label class="text-info"><?php echo $artcdesc; ?></label></div>
					<div class="col-xs-5"><label class="text-info"><?php echo $artndesc; ?></label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Cantidad: </label></div>
					<div class="col-xs-5"><label>Tipo de Lote: </label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label class="text-info"><?php echo $cant; ?></label></div>
					<div class="col-xs-5"><label class="text-info">NUEVO LOTE</label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Precio Manufact.: </label></div>
					<div class="col-xs-5"><label>Precio de Costo: </label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label class="text-info"><?php echo $prem; ?></label></div>
					<div class="col-xs-5"><label class="text-info"><?php echo $prec; ?></label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Precio de Venta: </label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label class="text-info"><?php echo $prev; ?></label></div>
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