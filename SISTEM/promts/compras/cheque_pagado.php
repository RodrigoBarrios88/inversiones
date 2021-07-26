<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	//--
	$monto = $_REQUEST["monto"];
	$monto = round($monto, 2);
	$moneda = $_REQUEST["mon"];
	$montext = $_REQUEST["montex"];
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label><i class="fa fa-money"></i> Forma de Pago</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Banco: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<?php echo banco_html("ban1","xajax_Combo_Cuenta_Banco(this.value,'cue1','scue1','')"); ?>
						<input type = "hidden" name = "tpag1" id = "tpag1" value = "7" />
					</div>
					<div class="col-xs-2 text-right"><label>No. Cuenta: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<span id = "scue1" >
							<select id = "cue1" name = "cue1" class = "form-control">
								<option value = "">Seleccione</option>
							</select>
						</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>No. Cheque: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "bouch1" id = "bouch1" onkeyup = "enteros(this);KeyEnter(this,Valida_Cheque)" onblur="Valida_Cheque();" /></div>
					<div class="col-xs-2 text-right"><label>Moneda: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<?php echo moneda_transacciones_html("monP1"); ?>
						<input type = "hidden" name = "opera1" id = "opera1" value = ""  />
						<input type = "hidden" name = "caja1" id = "caja1" value = ""  />
						<input type = "hidden" name = "suc1" id = "suc1" value = "<?php echo $empCodigo; ?>"  />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Girado a: </div>
					<div class="col-xs-8">
						<input type = "text" class = "form-control" name = "obs1" id = "obs1" onkeyup = "texto(this)" disabled />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Monto pagado con el cheque: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "montp1" id = "montp1" onkeyup = "decimales(this)"  /></div>
					<div class="col-xs-2 text-right"><label>Monto Compra: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "montv1" id = "montv1" value = "<?php echo $monto; ?>" readonly  /></div>
				</div>
				<br><br>
				<div class="row">
					<div class="col-xs-12 text-center">
					   <button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
					   <button type="button" class="btn btn-info" onclick = "NewFilaPago();"><span class="fa fa-check"></span> Aceptar</button>
					</div>
				</div>
				<br>
			</div>		
		</div>
		<script type="text/javascript">
			///Setea la moneda por defecto en la venta
			mon = document.getElementById('monP1');
			mon.value = '<?php echo $moneda; ?>';
		</script>
	</body>
</html>
