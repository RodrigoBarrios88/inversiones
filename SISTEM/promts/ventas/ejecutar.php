<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$monto = $_REQUEST["Total"];
	$monto = round($monto, 2);
	$filas = $_REQUEST["Filas"];
	$tipoP = $_REQUEST["Tipo"];
	switch($tipoP){
		case 2: $Tpago = "TARJETA"; $desc = "Cod. Cierre (POS)"; break;
		case 4: $Tpago = "CHEQUE"; $desc = "No. Deposito"; break;
	}
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<form name = "f1" id = "f1" onsubmit = "return false">
		<div class="panel panel-default">
			<div class="panel-heading"><label>Ejecuci&oacute;n de Tarjetas y Cheques</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3 text-right"><label>Tipo de Cuentas: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<input type = "text" class = "form-control" name = "tpago1" id = "tpago1" value = "<?php echo $Tpago; ?>" readonly  />
						<input type = "hidden" name = "tfilas" id = "tfilas" value = "<?php echo $filas; ?>"  />
					</div>
					<div class="col-xs-2 text-right"><label>Tipo de Cobro: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<select id = "tip1" name = "tip1" class = "form-control" onchange="TipoCobro(this.value);">
							<option value = "1">DEPOSITO</option>
							<option value = "2">EFECTIVO</option>
						</select>
					</div>
				</div>
				<div class="row" id = "row1">
					<div class="col-xs-3 text-right"><label>Banco: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<?php echo banco_html("ban1","xajax_Combo_Cuenta_Banco(this.value,'cue1','scue1','');"); ?>
						<script>
							document.getElementById("ban1").value = 1;
						</script>
					</div>
					<div class="col-xs-2 text-right"><label>No. de Cuenta: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3" id = "scue1">
						<?php echo cuenta_banco_html(1,"cue1",""); ?>
					</div>
				</div>
				<div class="row" id = "row2" style="display: none">
					<div class="col-xs-3 text-right"><label>Sucrsal: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<?php echo empresa_html("suc1","Empresa_CajaJS(this.value)"); ?>
					</div>
					<div class="col-xs-2 text-right"><label>Caja: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3" id = "scaja1">
						<select id = "caja1" name = "caja1" class = "form-control">
							<option value = "">Seleccione</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3 text-right"><label><?php echo $desc; ?>: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "doc1" id = "doc1" onkeyup = "texto(this)" /></div>
					<div class="col-xs-2 text-right"><label>% Cargo por Manejo: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "cargo1" id = "cargo1" value = "0" onkeyup = "decimales(this);descuento_x_cargos();" /></div>
				</div>
				<div class="row">
					<div class="col-xs-3 text-right"><label>Monto de Ejecuci&oacute;n: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "montp1" id = "montp1" value = "<?php echo $monto; ?>" readonly /></div>
					<div class="col-xs-2 text-right"><label>Monto a Depositar: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "total1" id = "total1" value = "<?php echo $monto; ?>" /></div>
				</div>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
						<button type="button" class="btn btn-info" id = "busc" onclick = "Ejecutar_Cheque_Tarjeta();"><span class="fa fa-check"></span> Aceptar</button>
					</div>
				</div>
				<br>
			</div>		
		</div>	
		</form>
	</body>
</html>
