<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$gremial = $_SESSION["gremial"];
	$pensum = $_SESSION["pensum"];
	$margen = ($margen == "")?"0":$margen;
	//$_POST
	$codigo = $_REQUEST["codigo"];
	$clase = $_REQUEST["clase"];
	$suc = $_REQUEST["suc"];
	$ClsComp = new ClsCompra();
	$result = $ClsComp->get_detalle_temporal($clase,$suc,$codigo);
	if(is_array($result)){
		foreach($result as $row){
			$tipo = $row["dcomtemp_tipo"];
			$reglon = $row["dcomtemp_reglon"];
			$partida = $row["dcomtemp_partida"];
			//Descripcion o Articulo
			$descripcion = utf8_decode($row["dcomtemp_detalle"]);
			$cantidad = $row["dcomtemp_cantidad"];
			//Precio U.
			$precio = trim($row["dcomtemp_precio"]);
			$precio = number_format($precio, 2, '.', '');
			$moneda = trim($row["dcomtemp_moneda"]);
			$mons = trim($row["mon_simbolo"]);
			$tcambio = trim($row["dcomtemp_tcambio"]);
			//subtotal
			$subtotal = trim($row["dcomtemp_subtotal"]);
			//Descuento
			$desc = trim($row["dcomtemp_descuento"]);
			$DescU+= $desc;
			$desc = number_format($desc, 2, '.', '');
			//sub Total
			$total = trim($row["dcomtemp_total"]);
			$total = number_format($total, 2, '.', '');
			//---
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
			<div class="panel-heading"><h6><i class="fa fa-edit"></i> Editar Fila Importada</h6></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1" id = "lb1"><label>Descripci&oacute;n:</label> <span class = " text-info">*</span></div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1">
						<input type = "text" class = "form-control" name = "desc" id = "desc" value = "<?php echo $descripcion; ?>" disabled />
						<input type = "hidden" name = "tipoEdit" id = "codigoEdit" value = "<?php echo $codigo; ?>" />
						<input type = "hidden" name = "tipoEdit" id = "claseEdit" value = "<?php echo $clase; ?>" />
						<input type = "hidden" name = "tipoEdit" id = "sucEdit" value = "<?php echo $suc; ?>" />
						<input type = "hidden" name = "tipoEdit" id = "tipoEdit" value = "<?php echo $tipo; ?>" />
						<input type = "hidden" name = "parEdit" id = "parEdit" value = "<?php echo $partida; ?>" />
						<input type = "hidden" name = "reglEdit" id = "reglEdit" value = "<?php echo $reglon; ?>" />
						<input type = "hidden" name = "barcEdit" id = "barcEdit"  value = "<?php echo $barc; ?>" />
						<input type = "hidden" name = "prevEdit" id = "prevEdit" value = "<?php echo $prev; ?>" />
						<input type = "hidden" name = "premEdit" id = "premEdit" value = "<?php echo $prem; ?>" />
						<input type = "hidden" name = "monsEdit" id = "monsEdit" value = "<?php echo $mons; ?>" />
						<input type = "hidden" name = "moncEdit" id = "moncEdit" value = "<?php echo $monc; ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Cantidad:</label> <span class = " text-danger">*</span></div>
					<div class="col-xs-5"><label>Pr&eacute;cio:</label> <span class = " text-danger">*</span></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<input type = "text" class = "form-control" name = "cantEdit" id = "cantEdit" onkeyup = "enteros(this);" value = "<?php echo $cantidad; ?>" />
					</div>
					<div class="col-xs-5">
						<input type = "text" class = "form-control" name = "precEdit" id = "precEdit" onkeyup = "decimales(this);" value = "<?php echo $precio; ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Moneda:</label> <span class = " text-danger">*</span></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<?php echo moneda_transacciones_html("monEdit",""); ?>
					</div>
					<script>
						document.getElementById("monEdit").value = '<?php echo $moneda; ?>';
					</script>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Tipo de Descuento (Individual):</label> </div>
					<div class="col-xs-5"><label>Monto del Descuento:</label> </div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<select id="tdscEdit" name="tdscEdit" class = "form-control" >
							<option value="P">Por Porcerntaje (%)</option>
							<option value="M">Por Monto Monetario (Q.)</option>
						</select>
						<script>
							document.getElementById("tdscEdit").value = 'M';
						</script>
					</div>
					<div class="col-xs-5">
						<input type = "text" class = "form-control" name = "dscEdit" id = "dscEdit" onkeyup = "decimales(this);" value = "<?php echo $desc; ?>" />
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-default" onclick = "cerrarModal();"><span class="fa fa-times"></span> Cancelar</button>
						<button type="button" class="btn btn-success" onclick = "EditarDetalleTemporal();"><span class="fa fa-check"></span> Aceptar</button>
					</div>
				</div>
				<br>
			</div>		
		</div>	
	</body>
</html>