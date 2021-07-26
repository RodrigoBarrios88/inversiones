<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$gremial = $_SESSION["gremial"];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$filas = $_REQUEST["filas"];
	$ventas = $_REQUEST["ventas"];
	$seriesanula = $_REQUEST["seriesanula"];
	$numerosanula = $_REQUEST["numerosanula"];
	$subtotales = $_REQUEST["subtotales"];
	$descuentos = $_REQUEST["descuentos"];
	$totales = $_REQUEST["totales"];
	$monedas = $_REQUEST["monedas"];
	$tcambio = $_REQUEST["tcambio"];
	$cliente = $_REQUEST["cliente"];
	
	$arrcli = explode("|", $cliente);
	$ClsCli = new ClsCliente();
	$result = $ClsCli->get_cliente($arrcli[1],'','');
	if(is_array($result)){
		foreach($result as $row){
			$cod = $row["cli_id"];
			$nom = utf8_decode($row["cli_nombre"]);
			$nit = trim($row["cli_nit"]);
		}
	}
	
	$arrventas = explode("|", $ventas);
	$arrnumerosAnul = explode("|", $numerosanula);
	$codIN = "";
	$cont_anulaciones = 0;
	for($i = 1; $i <= $filas; $i++){
		$codIN.= $arrventas[$i].",";
		$anulacion = $arrnumerosAnul[$i];
		if($anulacion != ""){
			$cont_anulaciones++;
		}
	}
	$codIN = substr($codIN, 0, -1);
	
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label>Facturar Ventas Anteriores</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Fecha:</label> <span class = " text-danger">*</span></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<div class="form-group">
							<div class='input-group date'>
								<input type='text' class="form-control" id = "fecha" name='fecha' value="<?php echo date("d/m/Y"); ?>" />
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Nit:</label> <span class = " text-danger">*</span></div>
					<div class="col-xs-5"><label>Cliente:</label> <span class = " text-danger">*</span></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<input type = "text" class = "form-control" name = "nit" id = "nit" value = "<?php echo $nit; ?>" disabled />
						<input type = "hidden" name = "cli" id = "cli" value = "<?php echo $cli; ?>" />
						<input type = "hidden" name = "filas" id = "filas" value = "<?php echo $filas; ?>" />
						<input type = "hidden" name = "ventas" id = "ventas" value = "<?php echo $ventas; ?>" />
						<input type = "hidden" name = "seriesanula" id = "seriesanula" value = "<?php echo $seriesanula; ?>" />
						<input type = "hidden" name = "numerosanula" id = "numerosanula" value = "<?php echo $numerosanula; ?>" />
						<input type = "hidden" name = "subtotales" id = "subtotales" value = "<?php echo $subtotales; ?>" />
						<input type = "hidden" name = "descuentos" id = "descuentos" value = "<?php echo $descuentos; ?>" />
						<input type = "hidden" name = "totales" id = "totales" value = "<?php echo $totales; ?>" />
						<input type = "hidden" name = "monedas" id = "monedas" value = "<?php echo $monedas; ?>" />
						<input type = "hidden" name = "tcambio" id = "tcambio" value = "<?php echo $tcambio; ?>" />
						<input type = "hidden" name = "clientes" id = "clientes" value = "<?php echo $cliente; ?>" />
					</div>
					<div class="col-xs-5">
						<input type="text" class="form-control" id="nom" name="nom" value = "<?php echo $nom; ?>" disabled />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Empresa:</label> <span class = " text-danger">*</span></div>
					<div class="col-xs-5"><label>Punto de Venta:</label> <span class = " text-danger">*</span></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<?php echo empresa_html("suc1","xajax_SucPuntVnt(this.value,'pv1');"); ?>
					</div>
					<div class="col-xs-5" id = "spv1">
						<?php
							if($_SESSION["empresa"] != ""){
								echo punto_venta_html($_SESSION["empresa"],"pv1");
							}else{
								echo combo_vacio("pv1");
							}
						?>
					</div>
					<script>
						document.getElementById("suc1").value = '<?php echo $_SESSION["empresa"]; ?>';
						document.getElementById("pv1").value = '1';
					</script>
				</div>
				<div class="row" >
					<div class="col-xs-5 col-xs-offset-1"><label>Serie de Factura:</label> <span class = " text-danger">*</span></div>
					<div class="col-xs-5"><label>N&uacute;mero de Factura:</label> <span class = " text-danger">*</span></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<?php echo serie_html("ser","NextFacturaAnterior();"); ?>
					</div>
					<div class="col-xs-5">
						<input type = "text" class = "form-control" name = "facc" id = "facc" onkeyup = "enteros(this);" />
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1 text-center">
						<?php if($cont_anulaciones > 0){ ?>
						<h6 class="alert alert-danger">
							<i class="fa fa-warning"></i> <?php echo $cont_anulaciones; ?> Venta(s) ya cuenta(n) con factura(s). Las facturas anteriores seran anuladas...
						</h6>
						<?php } ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-default" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
						<button type="button" class="btn btn-primary" onclick = "GrabarFacturaAnteriores();"><span class="fa fa-check"></span> Aceptar</button>
					</div>
				</div>
				<hr>
				<?php echo tabla_montos($codIN); ?>
			</div>		
		</div>
		<script>
			$(function () {
				$('#fecha').datetimepicker({
					format: 'DD/MM/YYYY'
				});
			});
		</script>	
	</body>
</html>
<?php

function tabla_montos($CodVentas){
	$ClsMon = new ClsMoneda();
	$ClsVent = new ClsVenta();
	///--
	$result = $ClsMon->get_moneda($_SESSION['moneda']);
	if(is_array($result)){
		foreach($result as $row){
			$MonDesc = utf8_encode($row["mon_desc"]);
			$MonSimbol = utf8_encode($row["mon_simbolo"]);
			$MonCambio = trim($row["mon_cambio"]);
		}	
	}	
	////
	$result = $ClsVent->get_ventas_varias($CodVentas);
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px">No.</th>';
		$salida.= '<th class = "text-center" width = "60px"># VENTA</th>';
		$salida.= '<th class = "text-center" width = "120px">FECHA/FACTURA</th>';
		$salida.= '<th class = "text-center" width = "50px">DESCUENTOS</th>';
		$salida.= '<th class = "text-center" width = "50px">MONTOS</th>';
		$salida.= '<th class = "text-center" width = "70px">MONEDA</th>';
		$salida.= '<th class = "text-center" width = "50px">T/C</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		$Tdescuento = 0;
		$Ttotal = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$vent = $row["ven_codigo"];
			$vent = Agrega_Ceros($vent);
			$tcambio = $row["ven_tcambio"];
			$mons = $row["mon_simbolo"];
			$salida.= '<td class = "text-center" >'.$vent.'</td>';
			//Fecha / venta
			$fec = $row["ven_fecha"];
			$fec = cambia_fecha($fec);
			$salida.= '<td class = "text-center" >'.$fec.'</td>';
			//descuento
			$desc = $row["ven_descuento"];
			$Dcambiar = Cambio_Moneda($tcambio,$MonCambio,$desc);
			$Tdescuento+= $Dcambiar;
			$salida.= '<td class = "text-center" ><b>'.$mons.'. '.$desc.'</b></td>';
			//total
			$tot = $row["ven_total"];
			$Dcambiar = Cambio_Moneda($tcambio,$MonCambio,$tot);
			$Ttotal+= $Dcambiar;
			$salida.= '<td class = "text-center" ><b>'.$mons.'. '.$tot.'</b></td>';
			//Moneda
			$mon = $row["mon_desc"];
			$salida.= '<td class = "text-center" >'.$mon.'</td>';
			//tcamb
			$tcamb = $row["ven_tcambio"];
			$salida.= '<td class = "text-center" >'.$tcamb.' x 1</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
		//--
			//--
			$salida.= '<tr>';
			$titulo = '<b>Moneda: '.$MonDesc.' / Tipo de Cambio: '.$MonCambio.' X 1</b>';
			$salida.= '<th colspan = "3">'.$titulo.'</td>';
			$Tdescuento = number_format($Tdescuento, 2, '.', '');
			$salida.= '<th class = "text-center">'.$MonSimbol.' '.$Tdescuento.'</th>';
			$Ttotal = number_format($Ttotal,2, '.', '');
			$salida.= '<th class = "text-center">'.$MonSimbol.' '.$Ttotal.'</th>';
			$salida.= '<th colspan = "2"></td>';
			$salida.= '</tr>';
		//--
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}		

?>