<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$comp = $_REQUEST["comp"];
	$total = $_REQUEST["total"];
	$saldo = $_REQUEST["monto"];
	$saldo = round($saldo, 2);
	$monid = $_REQUEST["monc"];
	$montext = $_REQUEST["montext"];
	$tipoP = $_REQUEST["tipo"];
	switch($tipoP){
		case 1: $Tpago = "EFECTIVO"; break;
		case 2: $Tpago = "TARJETA DE DEBITO"; break;
		case 3: $Tpago = "TARJETA DE CREDITO"; break;
		case 4: $Tpago = "CHEQUE"; break;
		case 5: $Tpago = "FINANCIAMIENTO (AL CREDITO)"; break;
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
			<div class="panel-heading"><label>Forma de Pago</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Tipo de Pago: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<input type = "text" class = "form-control" name = "tpago1" id = "tpago1" value = "<?php echo $Tpago; ?>" readonly  />
						<input type = "hidden" name = "tpag1" id = "tpag1" value = "<?php echo $tipoP; ?>"  />
					</div>
					<div class="col-xs-3 text-right"><label>Moneda: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<?php echo moneda_transacciones_html("mon1"); ?>
					</div>
				</div>
				<?php if($tipoP == 2){ ?>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Banco: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<?php echo banco_html("ban1","xajax_Combo_Cuenta_Banco(this.value,'cue1','scue1','');"); ?>
					</div>
					<div class="col-xs-3 text-right"><label>Cuenta: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3" id = "scue1">
						<select id = "cue1" name = "cue1" class = "form-control">
							<option value = "">Seleccione</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Operador: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "opera1" id = "opera1" onkeyup = "texto(this)" /></div>
					<div class="col-xs-3 text-right"><label>Boucher: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<input type = "text" class = "form-control" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" />
						<input type = "hidden" name = "caja1" id = "caja1" value = ""  />
						<input type = "hidden" name = "suc1" id = "suc1" value = "<?php echo $empCodigo; ?>"  />
					</div>
				</div>
				<?php }else if($tipoP == 3){ ?>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Operador: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "opera1" id = "opera1" onkeyup = "texto(this)" /></div>
					<div class="col-xs-3 text-right"><label>Boucher: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<input type = "text" class = "form-control" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" />
						<input type = "hidden" name = "ban1" id = "ban1" value = ""  />
						<input type = "hidden" name = "cue1" id = "cue1" value = ""  />
						<input type = "hidden" name = "caja1" id = "caja1" value = ""  />
						<input type = "hidden" name = "suc1" id = "suc1" value = "<?php echo $empCodigo; ?>"  />
					</div>
				</div>
				<?php }else if($tipoP == 4){ ?>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Banco: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<?php echo banco_html("ban1","xajax_Combo_Cuenta_Banco(this.value,'cue1','scue1','xajax_Last_Cheque(this.value,document.getElementById(\'ban1\').value);');"); ?>
					</div>
					<div class="col-xs-3 text-right"><label>Cuenta: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3" id = "scue1">
						<select id = "cue1" name = "cue1" class = "form-control">
							<option value = "">Seleccione</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>No. de Cheque: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<input type = "text" class = "form-control" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" />
						<input type = "hidden" name = "opera1" id = "opera1" value = ""  />
						<input type = "hidden" name = "caja1" id = "caja1" value = ""  />
						<input type = "hidden" name = "suc1" id = "suc1" value = "<?php echo $empCodigo; ?>"  />
					</div>
				</div>
				<?php }else if($tipoP == 5){ ?>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Autoriza: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "opera1" id = "opera1" onkeyup = "texto(this)" /></div>
					<div class="col-xs-3 text-right"><label>No. de Doc.: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" /></div>
				</div>
				<?php }else{ ?>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Empresa: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<?php echo empresa_html("suc1","Empresa_CajaJS(this.value);"); ?>
					</div>
					<div class="col-xs-3 text-right"><label>Caja: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3" id = "scaja1">
						<select id = "caja1" name = "caja1" class = "form-control">
							<option value = "">Seleccione</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3">
						<input type = "hidden" name = "ban1" id = "ban1" value = ""  />
						<input type = "hidden" name = "cue1" id = "cue1" value = ""  />
						<input type = "hidden" name = "opera1" id = "opera1" value = ""  />
						<input type = "hidden" name = "bouch1" id = "bouch1" value = ""  />
						<input type = "hidden" name = "obs1" id = "obs1" value = ""  />
					</div>
				</div>
				<?php } ?>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Monto a Pagar: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<input type = "text" class = "form-control" name = "montp1" id = "montp1"  value = "<?php echo $saldo; ?>" onkeyup = "decimales(this)"  />
					</div>
					<div class="col-xs-3 text-right"><label>Saldo: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<input type = "text" class = "form-control" name = "montv1" id = "montv1" value = "<?php echo $total; ?>" readonly />
						<input type = "hidden" name = "comp1" id = "comp1" value = "<?php echo $comp; ?>" />
						<input type = "hidden" name = "saldo1" id = "saldo1" value = "<?php echo $saldo; ?>" />
						<input type = "hidden" name = "comcamb1" id = "comcamb1" value = "<?php echo $monid; ?>" />
					</div>
				</div>
				<?php if($tipoP != 1){ ?>
					<?php if($tipoP == 4){ ?>
					<div class="row">
						<div class="col-xs-2 text-right"><label>Quien lo gira: </label> <span class = "text-danger">*</span></div>
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
							<button type="button" class="btn btn-info" id = "busc" onclick = "NewFilaPago2();"><span class="fa fa-check"></span> Aceptar</button>
						 </div>
					</div>
				<br>
			</div>		
		</div>	
		</form>
		<script type="text/javascript">
			///Setea la moneda por defecto en la venta
			mon = document.getElementById('mon1');
			mon.value = '<?php echo $monid; ?>';
		</script>
	</body>
</html>
