<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$monto = $_REQUEST["monto"];
	$monto = round($monto, 2);
	$moneda = $_REQUEST["mon"];
	$montext = $_REQUEST["montex"];
	$tipoP = $_REQUEST["tipo"];
	switch($tipoP){
		case 1: $Tpago = "EFECTIVO"; break;
		case 4: $Tpago = "CHEQUE"; break;
		case 5: $Tpago = "VENTA AL CREDITO"; break;
		case 6: $Tpago = "DEPOSITO BANCARIO O PAGO ELECTRONICO"; break;
	}
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<form name = "f1" id = "f1">
		<div class="panel panel-default">
			<div class="panel-heading"><label><i class="fa fa-credit-card"></i> Forma de Pago</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Tipo de Pago: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
				<?php if($tipoP == 2 || $tipoP == 3){ ?>
						<select id = "tpag1" name = "tpag1" class = "form-control">
							<option value = "2">TARJETA DE DEBITO</option>
							<option value = "3">TARJETA DE CREDITO</option>
						</select>
				<?php }else{ ?>
						<input type = "text" class = "form-control" name = "tpago1" id = "tpago1" value = "<?php echo $Tpago; ?>" readonly  />
						<input type = "hidden" name = "tpag1" id = "tpag1" value = "<?php echo $tipoP; ?>"  />
				<?php } ?>
					</div>
					<div class="col-xs-3 text-right"><label>Moneda: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<?php echo moneda_transacciones_html("monP1"); ?>
					</div>
				</div>
				<?php if($tipoP == 2 || $tipoP == 3){ ?>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Operador: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "opera1" id = "opera1" onkeyup = "texto(this)" /></div>
					<div class="col-xs-3 text-right"><label>Boucher: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" /></div>
				</div>
				<?php }else if($tipoP == 4){ ?>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Banco: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "opera1" id = "opera1" onkeyup = "texto(this)" /></div>
					<div class="col-xs-3 text-right"><label>No. de Cheque: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" /></div>
				</div>
				<?php }else if($tipoP == 5){ ?>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Autoriza: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "opera1" id = "opera1" onkeyup = "texto(this)" /></div>
					<div class="col-xs-3 text-right"><label>No. de Doc.: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" /></div>
				</div>
				<?php }else if($tipoP == 6){ ?>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Banco: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<?php echo banco_html("opera1","xajax_Combo_Cuenta_Banco(this.value,'bouch1','sbouch1','')"); ?>
					</div>
					<div class="col-xs-3 text-right"><label>No. Cuenta: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3" id = "sbouch1">
						<select id = "bouch1" name = "bouch1" class = "form-control">
							<option value = "">Seleccione</option>
						</select>
					</div>
				</div>
				<!--div class="row">
					<div class="col-xs-2 text-right"><label>M&eacute;todo: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<select id = "metodo1" name = "metodo1" class = "form-control">
							<option value = "DEPOSITO BANCARIO">Deposito Bancario</option>
							<option value = "TRANSACCION ELECTRONICA">Transacci&oacute;n Electr&oacute;nica</option>
						</select>
					</div>
					<div class="col-xs-3 text-right"><label>No. de Transacci&oacute;n: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "trans1" id = "trans1" onkeyup = "texto(this)" /></div>
				</div-->
				<?php }else{ ?>
				<div class="row">
					<div class="col-xs-3">
						<input type = "hidden" name = "opera1" id = "opera1" value = ""  />
						<input type = "hidden" name = "bouch1" id = "bouch1" value = ""  />
						<input type = "hidden" name = "obs1" id = "obs1" value = ""  />
					</div>
				</div>
				<?php } ?>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Monto a Pagar: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "montp1" id = "montp1" value = "<?php echo $monto; ?>" onkeyup = "decimales(this)"  /></div>
					<div class="col-xs-3 text-right"><label>Monto de Venta: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "montv1" id = "montv1" value = "<?php echo $monto; ?>" readonly  /></div>
				</div>
				<?php if($tipoP != 1){ ?>
					<?php if($tipoP == 4){ ?>
					<div class="row">
						<div class="col-xs-2 text-right"><label>Quien gira el cheque: </label> <span class = "text-danger">*</span></div>
						<div class="col-xs-9">
							<input type = "text" class = "form-control" name = "obs1" id = "obs1" onkeyup = "texto(this)" />
						</div>
					</div>
					<?php }else if($tipoP == 5){ ?>
					<div class="row">
						<div class="col-xs-2 text-right"><label>Observaciones: </label> </div>
						<div class="col-xs-9">
							<input type = "text" class = "form-control" name = "obs1" id = "obs1" onkeyup = "texto(this)" />
						</div>
					</div>
					<?php }else{ ?>
					<div class="row">
						<div class="col-xs-2 text-right"><label>Observaciones: </label> </div>
						<div class="col-xs-9">
							<input type = "text" class = "form-control" name = "obs1" id = "obs1" onkeyup = "texto(this)" />
						</div>
					</div>
					<?php } ?>
				<?php } ?>
					<br><br>
					<div class="row">
						<div class="col-xs-12 text-center">
						   <button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
							<button type="button" class="btn btn-info" id = "busc" onclick = "NewFilaPago();"><span class="fa fa-check"></span> Aceptar</button>
						 </div>
					</div>
				<br>
			</div>		
		</div>	
		</form>
		<script type="text/javascript">
			///Setea la moneda por defecto en la venta
			mon = document.getElementById('monP1');
			mon.value = <?php echo $moneda; ?>;
		</script>
	</body>
</html>
